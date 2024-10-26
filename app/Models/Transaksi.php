<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'hari_tanggal',
        'uraian',
        'bidang',
        'pemasukan',
        'pengeluaran',
        'total',
        'anggota_id',
        'bukti_transaksi',
        'spj',
    ];

// Accessor untuk memformat pemasukan
public function getPemasukanFormattedAttribute()
{
    $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
    return $formatter->format($this->pemasukan);
}

// Accessor untuk memformat pengeluaran
public function getPengeluaranFormattedAttribute()
{
    $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
    return $formatter->format($this->pengeluaran);
}

// Accessor untuk memformat total
public function getTotalFormattedAttribute()
{
    $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
    return $formatter->format($this->total);
}

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
