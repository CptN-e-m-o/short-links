<?php

namespace App\Filament\Resources\LinkResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ClicksRelationManager extends RelationManager
{
    protected static string $relationship = 'clicks';

    protected static ?string $title = 'Переходы';

    protected static ?string $modelLabel = 'переход';

    protected static ?string $pluralModelLabel = 'переходы';

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP-адрес')
                    ->searchable(),

                Tables\Columns\TextColumn::make('clicked_at')
                    ->label('Дата перехода')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('clicked_at', 'desc')
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
