<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkResource\Pages;
use App\Filament\Resources\LinkResource\RelationManagers\ClicksRelationManager;
use App\Models\Link;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationLabel = 'Мои ссылки';

    protected static ?string $modelLabel = 'ссылка';

    protected static ?string $pluralModelLabel = 'ссылки';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('original_url')
                    ->label('Оригинальный URL')
                    ->url()
                    ->required()
                    ->maxLength(2048)
                    ->columnSpanFull(),

                Forms\Components\Placeholder::make('short_url')
                    ->label('Короткая ссылка')
                    ->content(fn (?Link $record): string => $record?->short_url ?? 'Будет создана после сохранения')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('original_url')
                    ->label('Оригинальный URL')
                    ->limit(60)
                    ->searchable(),

                Tables\Columns\TextColumn::make('short_url')
                    ->label('Короткая ссылка')
                    ->copyable()
                    ->copyMessage('Ссылка скопирована'),

                Tables\Columns\TextColumn::make('clicks_count')
                    ->label('Клики')
                    ->counts('clicks')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создана')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Статистика'),

                Tables\Actions\EditAction::make()
                    ->label('Изменить'),

                Tables\Actions\DeleteAction::make()
                    ->label('Удалить'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Удалить выбранные'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ClicksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'view' => Pages\ViewLink::route('/{record}'),
            'edit' => Pages\EditLink::route('/{record}/edit'),
        ];
    }
}
