<?php

namespace App\Filament\Resources\Tourisms;

use App\Filament\Resources\Tourisms\Pages\CreateTourism;
use App\Filament\Resources\Tourisms\Pages\EditTourism;
use App\Filament\Resources\Tourisms\Pages\ListTourisms;
use App\Filament\Resources\Tourisms\Schemas\TourismForm;
use App\Filament\Resources\Tourisms\Tables\TourismsTable;
use App\Models\Tourism;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TourismResource extends Resource
{
    protected static ?string $model = Tourism::class;

    protected static string | UnitEnum | null $navigationGroup = 'Management Content';
    protected static ?int $navigationSort = 4;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    public static function form(Schema $schema): Schema
    {
        return TourismForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TourismsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTourisms::route('/'),
            'create' => CreateTourism::route('/create'),
            'edit' => EditTourism::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return true;
    }
}
