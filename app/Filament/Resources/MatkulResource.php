<?php
namespace App\Filament\Resources;

use App\Filament\Resources\MatkulResource\Pages;
use App\Models\Matkul;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;

class MatkulResource extends Resource
{
    protected static ?string $model = Matkul::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Akademik';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama_matkul')->required()->maxLength(255),
            Forms\Components\TimePicker::make('jam_mulai')->required(),
            Forms\Components\TimePicker::make('jam_selesai')->required(),
            Forms\Components\TextInput::make('sks')->numeric()->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nama_matkul')->searchable(),
            Tables\Columns\TextColumn::make('jam_mulai'),
            Tables\Columns\TextColumn::make('jam_selesai'),
            Tables\Columns\TextColumn::make('sks'),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMatkuls::route('/'),
        ];
    }
}
