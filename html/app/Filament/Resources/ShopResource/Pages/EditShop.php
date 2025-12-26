<?php

namespace App\Filament\Resources\ShopResource\Pages;

use App\Filament\Resources\ShopResource;
use App\Models\Area;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShop extends EditRecord
{
    protected static string $resource = ShopResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // エリアから都道府県を取得してセット
        if (isset($data['area_id'])) {
            $area = Area::find($data['area_id']);
            if ($area) {
                $data['prefecture_id'] = $area->prefecture_id;
            }
        }

        return $data;
    }
}
