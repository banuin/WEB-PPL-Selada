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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            // id_pelanggan terhubung ke tabel users
            $table->foreignId('id_pelanggan')->constrained('users')->onDelete('cascade');
            $table->string('kode_pemesanan');
            $table->dateTime('tanggal_pemesanan');
            $table->string('metode_pengiriman');
            $table->integer('total_pembayaran');
            $table->string('bukti_transfer');
            $table->string('status_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
