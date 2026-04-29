<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
    {
        protected $fillable = ['judul', 'deskripsi', 'foto', 'berat', 'stok', 'harga'];

        // Tambahkan ini:
        protected $casts = [
            'foto' => 'array',
        ];
    }
