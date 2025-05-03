<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MatkulResource\Pages;
use App\Models\Matkul;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MatkulResource extends Resource
{
    protected static ?string $model = Matkul::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    
    protected static ?string $navigationGroup = 'Akademik';

    protected static ?string $pluralLabel = 'Mata Kuliah';
    
    protected static ?string $label = 'Mata Kuliah';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_matkul')
                    ->required()
                    ->label('Kode Mata Kuliah')
                    ->maxLength(20),
                    
                Forms\Components\TextInput::make('nama_matkul')
                    ->required()
                    ->label('Nama Mata Kuliah')
                    ->maxLength(100),
                    
                Forms\Components\TimePicker::make('jam_mulai')
                    ->required()
                    ->label('Jam Mulai')
                    ->seconds(false),
                    
                Forms\Components\TimePicker::make('jam_selesai')
                    ->required()
                    ->label('Jam Selesai')
                    ->seconds(false)
                    ->after('jam_mulai'),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_matkul')
                    ->label('Kode Mata Kuliah')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('nama_matkul')
                    ->label('Nama Mata Kuliah')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('jam_mulai')
                    ->label('Jam Mulai')
                    ->time('H:i')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('jam_selesai')
                    ->label('Jam Selesai')
                    ->time('H:i')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListMatkuls::route('/'),
            'create' => Pages\CreateMatkul::route('/create'),
            'view' => Pages\ViewMatkul::route('/{record}'),
            'edit' => Pages\EditMatkul::route('/{record}/edit'),
        ];
    }
}