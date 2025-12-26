<?php

namespace App\Filament\Resources\CastResource\Pages;

use App\Filament\Resources\CastResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCasts extends ListRecords
{
    protected static string $resource = CastResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
