<?php

namespace App\Http\Controllers\SettingManagement;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\SettingManagement\Worker\StoreRequest;
use App\Http\Requests\SettingManagement\Worker\UpdateRequest;

class WorkerController extends Controller
{
    public function index(Request $request, Worker $worker)
    {
        $query = $worker::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('lastname')) {
            $query->where('lastname', 'like', '%' . $request->lastname . '%');
        }

        if ($request->filled('num_doc')) {
            $query->where('num_doc', $request->num_doc);
        }

        $workers = $query->paginate(10)->appends($request->all());

        return view('setting_management.workers.index', compact('workers'));
    }

    public function create()
    {
        return view('setting_management.workers.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $this->fetchFromSunat($request->num_doc);

        Worker::create([
            'num_doc'  => $request->num_doc,
            'name'     => $data['name'] ?? '',
            'lastname' => $data['lastname'] ?? '',
        ]);

        return redirect()->route('setting_management.workers.index')
            ->with('success', 'Worker created successfully.');
    }

    public function edit(Worker $worker)
    {
        return view('setting_management.workers.edit', compact('worker'));
    }

    public function update(UpdateRequest $request, Worker $worker)
    {
        $worker->update([
            'num_doc'  => $request->num_doc,
            'name'     => $request->name,
            'lastname' => $request->lastname,
        ]);

        return redirect()->route('setting_management.workers.index')
            ->with('success', 'Worker updated successfully.');
    }

    public function delete(Worker $worker)
    {
        return view('setting_management.workers.delete', compact('worker'));
    }

    public function deleteSave(Request $request, Worker $worker)
    {
        $worker->delete();

        return redirect()->route('setting_management.workers.index')
            ->with('success', 'Worker deleted successfully.');
    }

    /**
     * Llamada AJAX para autocompletar DNI
     */
    public function fetchDni(Request $request)
    {
        $num_doc = $request->input('num_doc');
        $data = $this->fetchFromSunat($num_doc);

        return response()->json($data);
    }

    /**
     * Consulta a la API de SUNAT / RENIEC usando token
     */
    private function fetchFromSunat($num_doc)
    {
        $token = env('API_PERU_TOKEN'); // Agrega tu token en .env

        $response = Http::withToken($token)
            ->get("https://api.apis.net.pe/v1/dni?numero={$num_doc}");

        if ($response->successful()) {
            $result = $response->json();
            return [
                'name'     => $result['nombres'] ?? '',
                'lastname' => ($result['apellidoPaterno'] ?? '') . ' ' . ($result['apellidoMaterno'] ?? '')
            ];
        }

        return [];
    }
}
