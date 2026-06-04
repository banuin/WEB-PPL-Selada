<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    // Nama tabel yang sudah kita perbaiki tadi
    protected $table = 'pemesanans';
    
    protected $guarded = [];

    // 1. Relasi ke Pelanggan (Tabel Users)
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'id_pelanggan');
    }

    // 2. Relasi ke Detail Pemesanan <--- INI YANG DICARI OLEH LARAVEL
    public function detailPemesanan()
    {
        return $this->hasMany(DetailPemesanan::class, 'id_pemesanan');
    }
}