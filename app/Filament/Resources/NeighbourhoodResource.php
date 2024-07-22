<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NeighbourhoodResource\Pages;
use App\Filament\Resources\NeighbourhoodResource\RelationManagers;
use App\Models\District;
use App\Models\Neighbourhood;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NeighbourhoodResource extends Resource
{
    protected static ?string $model = Neighbourhood::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name'),
                Select::make("district_id")->options(District::all()->pluck("name","id"))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("name"),
                TextColumn::make("district.name"),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListNeighbourhoods::route('/'),
            'create' => Pages\CreateNeighbourhood::route('/create'),
            'edit' => Pages\EditNeighbourhood::route('/{record}/edit'),
        ];
    }
}
