<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            DatePicker::make('hari_tanggal')
                ->label('Hari Tanggal')
                ->required()
                ->displayFormat('Y-m-d') // Format tampilan di form
                ->format('Y-m-d'),       // Format penyimpanan ke database

            TextInput::make('uraian')
                ->label('Uraian')
                ->required()
                ->maxLength(255),       // Maksimum karakter

            TextInput::make('bidang')
                ->label('Bidang')
                ->required()
                ->maxLength(255),

            TextInput::make('pemasukan')
                ->label('Pemasukan')
                ->numeric()             // Hanya menerima angka
                ->default(0)
                ->required(),

            TextInput::make('pengeluaran')
                ->label('Pengeluaran')
                ->numeric()
                ->default(0)
                ->required(),

            FileUpload::make('bukti_transaksi')
                ->label('Bukti Transaksi')
                ->nullable()            // Tidak wajib diisi
                ->directory('bukti_transaksi') // Folder penyimpanan

                ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf']) // Tipe file yang diterima
                ->maxSize(2048),        // Maksimum ukuran file dalam KB (2MB)

            FileUpload::make('spj')
                ->label('SPJ')
                ->nullable()
                ->directory('spj')
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf'])
                ->maxSize(2048),
            
            Forms\Components\Select::make('anggota_id')
            ->relationship('anggota', 'nama')
            ->searchable()
            ->preload()
            ->required()
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hari_tanggal'),
                Tables\Columns\TextColumn::make('uraian'),
                Tables\Columns\TextColumn::make('bidang'),
                Tables\Columns\TextColumn::make('pemasukan'),
                Tables\Columns\TextColumn::make('pengeluaran'),
                Tables\Columns\TextColumn::make('total'),
                Tables\Columns\TextColumn::make('anggota.nama'),
                Tables\Columns\TextColumn::make('bukti_transaksi'),
                Tables\Columns\TextColumn::make('spj'),
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
