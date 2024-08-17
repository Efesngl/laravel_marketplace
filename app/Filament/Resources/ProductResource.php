<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Helpers\CategoryHelper;
use App\Models\Product;
use App\Models\Specification;
use App\Models\SpecificationValue;
use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make("title"),
                TextInput::make("price")
                    ->mask(RawJs::make('$money($input, ".", " ")'))
                    ->minValue(1)
                    ->maxValue(999999999999.99)
                    ->rules("between:1,1000000000000"),
                Select::make("user_id")->label("user")->options(User::all()->pluck("name", "id"))->searchable(),
                Select::make("parent_id")
                    ->relationship(
                        name: "category",
                        titleAttribute: "category_id",
                        modifyQueryUsing: fn(Builder $query) => $query->where("can_have_children", 0),
                    )
                    ->getOptionLabelFromRecordUsing(fn(Model $category) => CategoryHelper::getCategoryChain($category->id)),
                Grid::make(2)->schema([
                    TextInput::make("stock"),
                    TextInput::make("quantity_per_user"),
                ]),
                    Grid::make(1)->schema([
                    RichEditor::make("description"),
                ]),
                Toggle::make("is_active"),
                Grid::make(1)->schema([
                    Repeater::make("specifications")->relationship()->schema([
                        Select::make("specification_id")
                            ->relationship("specification", "specification_id")
                            ->options(Specification::all()->pluck("specification", "id"))->live(),
                        Select::make("value_id")
                            ->relationship("value", "value_id")
                            ->options(function (Get $get) {
                                if (is_null($get("specification_id"))) {
                                    return SpecificationValue::all()->pluck("value", "id");
                                }
                                return SpecificationValue::where("specification_id", $get("specification_id"))->get()->pluck("value", "id");
                            })
                    ])->collapsible()->collapsed()
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("title"),
                TextColumn::make("price"),
                TextColumn::make("user.name"),
                TextColumn::make("is_active"),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
