<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembershipPlanResource\Pages;
use App\Filament\Resources\MembershipPlanResource\RelationManagers;
use App\Models\MembershipPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Column; // Naya import (optional for better layout)
class MembershipPlanResource extends Resource
{
    protected static ?string $model = MembershipPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                // Naya Field: Subscription Duration
                TextInput::make('duration_months')
                    ->label('Subscription Duration (Months)')
                    ->numeric()
                    ->required()
                    ->minValue(1) // Kam se kam 1 month
                    ->default(12)
                    ->columnSpanFull(), // Ye field poori width legi

                TextInput::make('price')
                    ->numeric()
                    ->required()
                    ->prefix('$')
                    ->default(100.00),

                Textarea::make('features_list')
                    ->label('Features (One per line)')
                    ->placeholder('e.g. Unlimited Users, 10GB Storage')
                    ->helperText('Each feature should be on a new line.'),
            ])
            ->columns(2); // Form ko 2 columns mein split kar dete hain
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('duration_months')
                    ->label('Duration')
                    ->formatStateUsing(fn ($state) => $state . ' Months'),
                TextColumn::make('features_list')
                    ->label('Key Features')
                    ->limit(50),
            ])
            ->filters([
                // Filters here...
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMembershipPlans::route('/'),
            'create' => Pages\CreateMembershipPlan::route('/create'),
            'edit' => Pages\EditMembershipPlan::route('/{record}/edit'),
        ];
    }
}
