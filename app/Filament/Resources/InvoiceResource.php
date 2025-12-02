<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use App\Models\Tenant; // Tenant model import karein
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action; // Action button ke liye
use Filament\Tables\Columns\TextColumn; // Columns ke liye
use Filament\Tables\Filters\SelectFilter; // Filters ke liye
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent'; // Naya Icon
    protected static ?string $navigationGroup = 'Billing & Activation'; // Grouping

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Manual creation ki zarurat nahi, lekin agar form use karna ho
                Forms\Components\Select::make('tenant_id')
                    ->label('Project ID')
                    ->options(Tenant::pluck('id', 'id')->toArray())
                    ->searchable()
                    ->required(),
                
                Forms\Components\TextInput::make('total_amount')
                    ->numeric()
                    ->required()
                    ->label('Total Amount'),
                
                Forms\Components\DatePicker::make('period_starts_at')
                    ->label('Start Date')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // --- COLUMNS ---
                TextColumn::make('id')->label('Invoice ID')->searchable(),
                
                TextColumn::make('tenant_id') // Tenant ID
                    ->label('Project ID')
                    ->searchable(),
                    
                TextColumn::make('total_amount')
                    ->money('USD')
                    ->label('Amount Due'),
                    
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        default => 'danger',
                    }),
                    
                TextColumn::make('payment_method')->label('Method'),
                
                TextColumn::make('period_ends_at')
                    ->date()
                    ->label('Membership Ends'),
            ])
            ->filters([
                // --- FILTERS ---
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                    ]),
                SelectFilter::make('payment_method')
                    ->options([
                        'Card' => 'Card',
                        'PayPal' => 'PayPal',
                        'Invoice' => 'Invoice',
                    ])
            ])
            ->actions([
                // --- MANUAL ACTIVATION ACTION (CRITICAL LOGIC) ---
                Action::make('activate_tenant')
                    ->label('Mark Paid & Activate')
                    ->icon('heroicon-o-check-circle')
                    // Ye button sirf 'Invoice' method aur 'pending' status par dikhega
                    ->visible(fn (Invoice $record): bool => $record->status === 'pending' && $record->payment_method === 'Invoice')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Invoice $record) {
                        // 1. Invoice status update karein
                        $record->update(['status' => 'paid']);

                        // 2. Tenant ko activate karein (is_active = TRUE)
                        $tenant = Tenant::find($record->tenant_id);
                        if ($tenant) {
                            $record->update([
                                'period_starts_at' => now(), // Start date record karein
                                'period_ends_at' => now()->addMonths($record->plan->duration_months),
                            ]);
                            
                            $tenant->update(['plan_status' => 'active', 'is_active' => true]);
                        }
                        
                        // User ko notification bhej sakte hain yahan
                        
                        session()->flash('success', 'Tenant activated manually and invoice marked as paid!');
                    }),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}