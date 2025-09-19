<?php

// Using Namespace from app\Services
namespace App\Services\SystemManagement;

// Use model
use App\Models\Language;

// Main class
class LanguageService
{
    // Service for create
    public function create(array $data): Language
    {
        $data['created_by'] = auth()->id();
        return Language::create($data);
    }
    
    // Service for update
    public function update(Language $language, array $data): Language
    {
        $language->update($data);
        return $language;
    }
    
    // Service for soft delete
    public function delete(Language $language, string $reason): void
    {
        $language->update([
            'deleted_description' => $reason,
            'deleted_by'          => auth()->id(),
            'is_active'           => false,
        ]);

        $language->delete(); 
    }    
}