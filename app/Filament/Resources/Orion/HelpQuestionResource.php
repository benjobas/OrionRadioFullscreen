<?php

namespace App\Filament\Resources\Orion;

use Filament\Tables;
use App\Models\HelpQuestion;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Forms\Components\CKEditor;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\Orion\HelpQuestionResource\Pages;
use App\Filament\Resources\Orion\HelpQuestionResource\RelationManagers;

class HelpQuestionResource extends Resource
{
    protected static ?string $model = HelpQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-s-question-mark-circle';

    protected static ?string $navigationGroup = 'Help Center';

    protected static ?string $slug = 'help/help-questions';

    protected static ?string $label = 'Help Questions';

    public static function form(Form $form): Form
    {
        return $form->schema(static::getForm());
    }

    public static function getForm(bool $turnsTitleRedirectable = false): array
    {
        return [
            Card::make()
                ->schema([
                    TextInput::make('title')
                        ->placeholder('Question title')
                        ->required()
                        ->autocomplete()
                        ->columnSpan('full'),

                    Select::make('categories')
                        ->multiple()
                        ->visibleOn('create')
                        ->relationship('categories', 'name'),

                    CKEditor::make('content')
                        ->label('Question content')
                        ->required()
                        ->columnSpan('full'),

                    Toggle::make('visible')
                ])
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::getTable())
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getTable(): array
    {
        return [
            TextColumn::make('id')
                ->label('ID'),

            TextColumn::make('title')
                ->searchable()
                ->url(fn (HelpQuestion $helpQuestion) => static::getPages()['view'])
                ->limit(50),

            TextColumn::make('user.username')
                ->label('Created By')
                ->searchable()
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CategoriesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHelpQuestions::route('/'),
            'create' => Pages\CreateHelpQuestion::route('/create'),
            'view' => Pages\ViewHelpQuestion::route('/{record}'),
            'edit' => Pages\EditHelpQuestion::route('/{record}/edit'),
        ];
    }
}