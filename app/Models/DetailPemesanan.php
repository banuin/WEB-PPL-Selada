<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    // PASTIKAN BARIS INI ADA DAN MENGGUNAKAN AKHIRAN 's'
    protected $table = 'detail_pemesanans';
    
    public $timestamps = false; 
    protected $guarded = [];

    // Relasi balik ke Pemesanan
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }

    // Relasi ke Katalog (Produk)
    public function katalog()
    {
        return $this->belongsTo(Katalog::class, 'id_produk');
    }
}