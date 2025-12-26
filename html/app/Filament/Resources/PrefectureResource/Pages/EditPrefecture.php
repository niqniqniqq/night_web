<?php

namespace App\Filament\Resources\PrefectureResource\Pages;

use App\Filament\Resources\PrefectureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrefecture extends EditRecord
{
    protected static string $resource = PrefectureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
