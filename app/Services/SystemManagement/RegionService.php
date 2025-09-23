<?php

// Using Namespace from app\Services
namespace App\Services\SystemManagement;

// Use model
use App\Models\Region;

// Main class
class RegionService
{
    // Service for create
    public function create(array $data): Region
    {
        $data['created_by'] = auth()->id();
        return Region::create($data);
    }

    // Service for update
    public function update(Region $region, array $data): Region
    {
        $region->update($data);
        return $region;
    }

    // Service for soft delete
    public function delete(Region $region, string $reason): void
    {
        $region->update([
            'deleted_description' => $reason,
            'deleted_by'          => auth()->id(),
            'is_active'           => false,
        ]);

        $region->delete();
    }
}
