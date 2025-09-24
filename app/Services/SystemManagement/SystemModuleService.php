<?php

// Using Namespace from app\Services
namespace App\Services\SystemManagement;

// Use model
use App\Models\SystemModule;

// Main class
class SystemModuleService
{
    // Service for create
    public function create(array $data): SystemModule
    {
        $data['created_by'] = auth()->id();
        return SystemModule::create($data);
    }
    
    // Service for update
    public function update(SystemModule $system_module, array $data): SystemModule
    {
        $system_module->update($data);
        return $system_module;
    }
    
    // Service for soft delete
    public function delete(SystemModule $system_module, string $reason): void
    {
        $system_module->update([
            'deleted_description' => $reason,
            'deleted_by'          => auth()->id(),
            'is_active'           => false,
        ]);

        $system_module->delete(); 
    }    
}