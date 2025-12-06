<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use App\Models\StaticPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Columns\TextColumn; // <-- Naya Import
use Filament\Tables\Columns\IconColumn; // <-- Naya Import

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Site Configuration';
    protected static ?string $modelLabel = 'Global Settings'; // Name change for better UX

    // Settings are key-value, so we don't need a list view by default.
    // However, for Filament to work, we need a standard structure.

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Since this is key-value, form is not ideal. We will rely on pages/custom logic.
                // But for Filament stability, define a basic schema:
                TextInput::make('key')->required()->maxLength(255)->disabledOn('edit'),
                TextInput::make('value')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')->searchable(),
                TextColumn::make('value')->limit(50),
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

    public static function getPages(): array
    {
        return [
            // List Page rakhein, lekin Super Admin ko manually keys add karni hongi.
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
