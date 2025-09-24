<?php

// Using Namespace from app\Services
namespace App\Services\SystemManagement;

// Models
use App\Models\Tenant;

// Support
use Illuminate\Support\Str;

class TenantService
{
    // Service for create
    public function create(array $data): Tenant
    {
        $data['created_by'] = auth()->id();

        // create tenant
        $tenant = Tenant::create($data);

        // upload logo if exists
        if (request()->hasFile('logo')) {
            $this->uploadLogo($tenant, request()->file('logo'));
        }

        return $tenant;
    }

    // Service for update
    public function update(Tenant $tenant, array $data): Tenant
    {
        $tenant->update($data);

        // upload logo if exists
        if (request()->hasFile('logo')) {
            $this->uploadLogo($tenant, request()->file('logo'));
        }

        return $tenant;
    }

    // Service for soft delete
    public function delete(Tenant $tenant, string $reason): void
    {
        $tenant->update([
            'deleted_description' => $reason,
            'deleted_by'          => auth()->id(),
            'is_active'           => false,
        ]);

        $tenant->delete();
    }

    // Method to upload logo
    private function uploadLogo(Tenant $tenant, \Illuminate\Http\UploadedFile $file): void
    {
        $slug = Str::slug($tenant->name) . '-' . uniqid();
        $filename = time() . '_' . $file->getClientOriginalName();

        // Save on storage/app/public/logos/{slug}/
        $file->storeAs("logos/{$slug}", $filename, 'public');

        // Update source on database
        $tenant->update([
            'logo' => "{$slug}/{$filename}"
        ]);
    }
}