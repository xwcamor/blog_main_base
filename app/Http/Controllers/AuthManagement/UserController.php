<?php

// Source folder: app\Http\Controllers\SettingManagement\
namespace App\Http\Controllers\AuthManagement;

// Allow to use subfolders
use App\Http\Controllers\Controller;

// Use Models
use App\Models\User;
 
// Use Illuminates
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import Hash for encrypting passwords
use Illuminate\Support\Facades\Storage; // Save folder
use Illuminate\Support\Str;

// Use Request folder for validations
use App\Http\Requests\AuthManagement\User\StoreRequest;
use App\Http\Requests\AuthManagement\User\UpdateRequest;

// Main class
class UserController extends Controller
{
    // ------------------------------
    // INDEX
    // ------------------------------
    public function index(Request $request, User $user)
    {
        $query = $user::notDeleted();

        // Filters
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', (int) $request->is_active);
        }

        // Order
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'email', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        // Pagination
        $users = $query->paginate(10)->appends($request->all());

        return view('auth_management.users.index', compact('users'));
    }

    // ------------------------------
    // NEW
    // ------------------------------
    public function create()
    {
        return view('auth_management.users.create');
    }

    // Action Insert data from view create.blade.php
    public function store(StoreRequest $request)
    {
        // Insert data on table
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        // Upload Photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $slug = Str::slug($user->name) . '-' . uniqid();
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs("photos/{$slug}", $filename, 'public');

            $user->photo = "{$slug}/{$filename}"; // solo la ruta relativa
        }
        
        // Save array data
        $user->save();
       
        // Redirect to view with success message
        return redirect()
               ->route('auth_management.users.index')
               ->with('success', 'Registro creado.');
    }

    // ------------------------------
    // SHOW
    // ------------------------------
    public function show(User $user)
    {
        return view('auth_management.users.show', compact('user'));
    }

    // ------------------------------
    // EDIT
    // ------------------------------
    public function edit(User $user)
    {
        return view('auth_management.users.edit', compact('user'));
    }

    // Action Update data from view edit.blade.php
    public function update(UpdateRequest $request, User $user)
    {
        // Update data on table
        $user->name      = $request->name;
        $user->email     = $request->email;
        $user->is_active = $request->is_active;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Subir nueva foto
        if ($request->hasFile('photo')) {
            // Eliminar foto anterior si existe
            if ($user->photo && Storage::exists('public/photos/' . $user->photo)) {
                Storage::delete('public/photos/' . $user->photo);
            }

            $file = $request->file('photo');
            $slug = Str::slug($user->name) . '-' . uniqid();
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs("photos/{$slug}", $filename, 'public');
            $user->photo = "{$slug}/{$filename}";
        }

        // Save array data
        $user->save();
        
        // Redirect to view with success message
        return redirect()
               ->route('auth_management.users.index')
               ->with('success', 'Registro actualizado.');
    }

    // ------------------------------
    // DELETE
    // ------------------------------
    public function delete(User $user)
    {
        // Displays file delete.blade.php
        return view('auth_management.users.delete', compact('user'));
    }
    
    // Action Update column is_deleted (hide from view)
    public function deleteSave(Request $request, User $user)
    {
        // Validate the request data
        $request->validate([
            'deleted_description' => 'required|string|max:500',
        ]);

        // Update the model with the validated data
        $user->update([
            'is_active' => false,
            'is_deleted' => true,
            'deleted_description' => $request->deleted_description,
        ]);

        return redirect()
               ->route('auth_management.users.index')
               ->with('success', 'Registro eliminado');
    }

}
