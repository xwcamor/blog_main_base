<?php

namespace App\Services\CompanyManagement;

use App\Models\Company;

class CompanyService
{
    public function create(array $data): Company
    {
        $data['created_by'] = auth()->id();
        return Company::create($data);
    }

    public function update(Company $company, array $data): Company
    {
        $company->update($data);
        return $company;
    }
    public function delete(Company $company, string $reason): void
    {
        $company->update([
            'deleted_description' => $reason,
            'deleted_by'          => auth()->id(),
            'is_active'           => false,
        ]);

        $company->forceDelete();
    }
}
