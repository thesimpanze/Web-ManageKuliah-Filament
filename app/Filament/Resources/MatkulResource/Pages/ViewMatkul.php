<?php

namespace App\Filament\Resources\MatkulResource\Pages;

use App\Filament\Resources\MatkulResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMatkul extends ViewRecord
{
    protected static string $resource = MatkulResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}