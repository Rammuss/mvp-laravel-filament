<?php

namespace App\Filament\Resources\PropertyLeadResource\Pages;

use App\Filament\Resources\PropertyLeadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPropertyLeads extends ListRecords
{
    protected static string $resource = PropertyLeadResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
