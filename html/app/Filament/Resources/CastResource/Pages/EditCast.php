<?php

namespace App\Filament\Resources\CastResource\Pages;

use App\Filament\Resources\CastResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCast extends EditRecord
{
    protected static string $resource = CastResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
