<?php

namespace App\Filament\Resources\CastBlogResource\Pages;

use App\Filament\Resources\CastBlogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCastBlog extends EditRecord
{
    protected static string $resource = CastBlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
