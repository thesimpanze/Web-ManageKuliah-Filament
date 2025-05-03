<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TugasResource\Pages;
use App\Models\Tugas;
use App\Models\Matkul;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class TugasResource extends Resource
{
    protected static ?string $model = Tugas::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    
    protected static ?string $navigationGroup = 'Akademik';

    protected static ?string $pluralLabel = 'Tugas';
    
    protected static ?string $label = 'Tugas';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_tugas')
                    ->required()
                    ->label('Kode Tugas')
                    ->maxLength(20)
                    ->default(fn () => 'TGS-' . Str::random(6)),
                    
                Forms\Components\TextInput::make('nama_tugas')
                    ->required()
                    ->label('Nama Tugas')
                    ->maxLength(100),
                    
                Forms\Components\Select::make('matkul_id')
                    ->label('Mata Kuliah')
                    ->relationship('matkul', 'nama_matkul')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('kode_matkul')
                            ->required()
                            ->maxLength(20)
                            ->label('Kode Mata Kuliah'),
                        Forms\Components\TextInput::make('nama_matkul')
                            ->required()
                            ->maxLength(100)
                            ->label('Nama Mata Kuliah'),
                        Forms\Components\TimePicker::make('jam_mulai')
                            ->required()
                            ->label('Jam Mulai'),
                        Forms\Components\TimePicker::make('jam_selesai')
                            ->required()
                            ->label('Jam Selesai'),
                    ]),
                    
                Forms\Components\DateTimePicker::make('deadline')
                    ->required()
                    ->label('Deadline')
                    ->minDate(now()),
                    
                Forms\Components\RichEditor::make('deskripsi')
                    ->required()
                    ->label('Deskripsi Tugas')
                    ->columnSpanFull(),
                    
                Forms\Components\FileUpload::make('file_path')
                    ->label('File Tugas (Opsional)')
                    ->directory('tugas-files')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/*'])
                    ->maxSize(5120) // 5MB
                    ->columnSpanFull(),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_tugas')
                    ->label('Kode Tugas')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('nama_tugas')
                    ->label('Nama Tugas')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('matkul.nama_matkul')
                    ->label('Mata Kuliah')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('deadline')
                    ->label('Deadline')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->color(fn (Tugas $record) => 
                        $record->deadline->isPast() ? 'danger' : 
                        ($record->deadline->diffInDays(now()) < 3 ? 'warning' : 'success')),
                        
                Tables\Columns\IconColumn::make('file_path')
                    ->label('File')
                    ->boolean()
                    ->trueIcon('heroicon-o-document')
                    ->falseIcon('heroicon-o-x-mark'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('matkul_id')
                    ->relationship('matkul', 'nama_matkul')
                    ->searchable()
                    ->preload()
                    ->label('Filter Mata Kuliah'),
                    
                Tables\Filters\Filter::make('deadline')
                    ->form([
                        Forms\Components\DatePicker::make('deadline_from')
                            ->label('Deadline Dari'),
                        Forms\Components\DatePicker::make('deadline_until')
                            ->label('Deadline Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['deadline_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('deadline', '>=', $date),
                            )
                            ->when(
                                $data['deadline_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('deadline', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        
                        if ($data['deadline_from'] ?? null) {
                            $indicators['deadline_from'] = 'Deadline dari ' . $data['deadline_from'];
                        }
                        
                        if ($data['deadline_until'] ?? null) {
                            $indicators['deadline_until'] = 'Deadline sampai ' . $data['deadline_until'];
                        }
                        
                        return $indicators;
                    }),
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
            'index' => Pages\ListTugas::route('/'),
            'create' => Pages\CreateTugas::route('/create'),
            'view' => Pages\ViewTugas::route('/{record}'),
            'edit' => Pages\EditTugas::route('/{record}/edit'),
        ];
    }
}