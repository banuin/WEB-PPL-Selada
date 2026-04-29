<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('katalogs', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 50); // Nama produk (Varchar 50)
            $table->string('deskripsi', 500); // Deskripsi (Varchar 500)
            $table->json('foto');// Path foto disimpan sebagai string
            $table->integer('berat'); // Integer
            $table->integer('stok')->nullable(); // Sesuai desain UI Anda
            $table->integer('harga'); // Integer
            $table->timestamps();
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katalogs');
    }
};