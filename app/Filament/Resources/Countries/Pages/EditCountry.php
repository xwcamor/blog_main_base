<?php

namespace App\Filament\Resources\Countries\Pages;

use App\Filament\Resources\Countries\CountryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCountry extends EditRecord
{
    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
           // ViewAction::make(),
           // DeleteAction::make(),
        ];
    }
}
