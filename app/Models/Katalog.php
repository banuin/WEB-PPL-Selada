<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
{
    protected $table = 'katalogs';
    protected $fillable = ['judul', 'deskripsi', 'foto', 'berat', 'stok', 'harga'];
    
    protected $casts = [
        'foto' => 'array',
    ];
}
