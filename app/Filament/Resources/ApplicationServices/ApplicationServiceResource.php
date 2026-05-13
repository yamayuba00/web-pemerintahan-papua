<?php

namespace App\Filament\Resources\ApplicationServices;

use App\Filament\Resources\ApplicationServices\Pages\CreateApplicationService;
use App\Filament\Resources\ApplicationServices\Pages\EditApplicationService;
use App\Filament\Resources\ApplicationServices\Pages\ListApplicationServices;
use App\Filament\Resources\ApplicationServices\Schemas\ApplicationServiceForm;
use App\Filament\Resources\ApplicationServices\Tables\ApplicationServicesTable;
use App\Models\ApplicationService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ApplicationServiceResource extends Resource
{
    protected static ?string $model = ApplicationService::class;

    protected static string | UnitEnum | null $navigationGroup = 'Management Content';
    protected static ?int $navigationSort = 5;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquare3Stack3d;

    protected static ?string $navigationLabel = 'Application Services';

    public static function form(Schema $schema): Schema
    {
        return ApplicationServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicationServicesTable::configure($table);
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
            'index' => ListApplicationServices::route('/'),
            'create' => CreateApplicationService::route('/create'),
            'edit' => EditApplicationService::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return true;
    }
}
