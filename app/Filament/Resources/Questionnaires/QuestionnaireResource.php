<?php

namespace App\Filament\Resources\Questionnaires;

use App\Filament\Resources\Questionnaires\Pages\CreateQuestionnaire;
use App\Filament\Resources\Questionnaires\Pages\EditQuestionnaire;
use App\Filament\Resources\Questionnaires\Pages\ListQuestionnaires;
use App\Filament\Resources\Questionnaires\Pages\ViewResponses;
use App\Filament\Resources\Questionnaires\Schemas\QuestionnaireForm;
use App\Filament\Resources\Questionnaires\Tables\QuestionnairesTable;
use App\Models\Questionnaire;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class QuestionnaireResource extends Resource
{
    protected static ?string $model = Questionnaire::class;

    protected static string | UnitEnum | null $navigationGroup = 'Questionnaire';
    protected static ?int $navigationSort = 6;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    public static function form(Schema $schema): Schema
    {
        return QuestionnaireForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuestionnairesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestionnaires::route('/'),
            'create' => CreateQuestionnaire::route('/create'),
            'edit' => EditQuestionnaire::route('/{record}/edit'),
            'responses' => ViewResponses::route('/{record}/responses'),
        ];
    }

    public static function canViewAny(): bool
    {
        return true;
    }
}
