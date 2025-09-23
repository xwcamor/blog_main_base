<?php

// Using Namespace from app\Services
namespace App\Services\SystemManagement;

// Use model
use App\Models\Tenant;

// Main class
class TenantService
{
    // Service for create
    public function create(array $data): Tenant
    {
        $data['created_by'] = auth()->id();
        return Tenant::create($data);
    }

    // Service for update
    public function update(Tenant $tenant, array $data): Tenant
    {
        $tenant->update($data);
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
}
