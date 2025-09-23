<?php

namespace App\Services\SystemManagement;

use App\Models\Locale;
use Illuminate\Support\Str;

class LocaleService
{
    public function getAll()
    {
        return Locale::all();
    }

    public function create(array $data)
    {
        // Generate a random unique slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateUniqueSlug();
        }

        return Locale::create($data);
    }

    public function update(Locale $locale, array $data)
    {
        $locale->update($data);
        return $locale;
    }

    public function delete(Locale $locale, array $data = [])
    {
        // Si quieres guardar "deleted_by" o "deleted_description"
        if (isset($data['deleted_by'])) {
            $locale->deleted_by = $data['deleted_by'];
        }
        if (isset($data['deleted_description'])) {
            $locale->deleted_description = $data['deleted_description'];
        }
        $locale->save();

        $locale->delete();
        return true;
    }

    /**
     * Generate a unique random slug for Locale.
     */
    protected function generateUniqueSlug(int $length = 12): string
    {
        do {
            $slug = Str::lower(Str::random($length));
        } while (Locale::withTrashed()->where('slug', $slug)->exists());

        return $slug;
    }
}
