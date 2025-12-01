<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TenantResource\Pages;
// ... baaki imports ...
use App\Models\Tenant;
use Filament\Forms; // <-- Ye line missing thi ya ghalat jagah thi
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn; // <-- Ye line bhi zaroori hai
use Filament\Tables\Actions\Action; // <-- Ye line bhi zaroori hai
use Filament\Tables\Actions\EditAction; // <-- Ye line bhi zaroori hai

// In teen lines ki wajah se error aa raha tha:
use Filament\Forms\Components\TextInput; // <-- Ye line add karein
use Filament\Forms\Components\DatePicker; // <-- Ye line add karein
use Filament\Forms\Components\Select; // <-- Ye line add karein
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter; // <-- Ye line bhi zaroori hai
use Filament\Tables\Actions\DeleteAction; // <-- Ye line bhi zaroori hai
use Filament\Tables\Actions\BulkActionGroup; // <-- Ye line bhi zaroori hai
use Filament\Tables\Actions\DeleteBulkAction; // <-- Ye line bhi zaroori hai
class TenantResource extends Resource
{
    // Tenant model use ho raha hai
    protected static ?string $model = Tenant::class;

    // Sidebar ka icon
    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    // Sidebar label
    protected static ?string $navigationLabel = 'Projects (Tenants)';

    // Resource ki group navigation
    protected static ?string $navigationGroup = 'Tenant Management';

    // Form ka istemal zaroori nahi hai kyunki creation Livewire se ho raha hai
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Yahan hum Forms\Components\TextInput hi rakhenge
                Forms\Components\TextInput::make('id')
                    ->label('Tenant ID')
                    ->required()
                    ->maxLength(255)
                    ->disabled(), // ID ko edit hone se rok dein

                Forms\Components\DatePicker::make('trial_ends_at')
                    ->label('Trial End Date'),

                Forms\Components\Select::make('plan_status')
                    ->options([
                        'trial' => 'Trial',
                        'active' => 'Active',
                        'expired' => 'Expired',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // --- COLUMNS ---
                TextColumn::make('id')
                    ->searchable()
                    ->label('Tenant ID')
                    ->sortable(),

                // Domain relation se primary domain display karna
                TextColumn::make('domains.domain')
                    ->label('Primary Domain')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('plan_status')
                    ->badge()
                    ->label('Status')
                    ->color(fn (string $state): string => match ($state) {
                        'trial' => 'warning',
                        'active' => 'success',
                        'expired' => 'danger',
                    })
                    ->sortable(),

                TextColumn::make('trial_ends_at')
                    ->label('Trial Ends')
                    ->date()
                    ->color('danger')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Registered On')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // --- FILTERS ---
                Filter::make('expired_trial')
                    ->label('🛑 Expired Tenants')
                    ->query(fn (Builder $query): Builder => $query->where('trial_ends_at', '<', now())->where('plan_status', '!=', 'active')),

                Filter::make('on_trial')
                    ->label('⏳ On Trial')
                    ->query(fn (Builder $query): Builder => $query->where('plan_status', 'trial')->orWhere('trial_ends_at', '>', now())),
            ])
            ->actions([
                // --- ACTIONS ---
                // Mark as Paid/Active Action (Trial bypass logic)
                Action::make('mark_paid')
                    ->label('Mark Active')
                    ->icon('heroicon-o-currency-dollar')
                    // Ye button tabhi dikhega jab status trial ya expired ho
                    ->visible(fn (Tenant $record): bool => $record->plan_status !== 'active')
                    ->requiresConfirmation()
                    ->action(function (Tenant $record) {
                        // Status update karein aur trial date hata dein
                        $record->update([
                            'plan_status' => 'active',
                            'trial_ends_at' => null,
                        ]);
                    }),

                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                // --- BULK ACTIONS ---
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        // Pages\ManageTenants ki jagah Pages\ListTenants use karein for simplicity
        return [
            'index' => Pages\ListTenants::route('/'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }
}
