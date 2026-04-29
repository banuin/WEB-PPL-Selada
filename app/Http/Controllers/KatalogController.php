<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KatalogController extends Controller
{
    /**
     * Menampilkan daftar katalog (Halaman awal admin katalog)
     */
    public function index()
    {
        return view('admin.katalog.index');
    }

    /**
     * Menampilkan form tambah katalog
     */
    public function create()
    {
        return view('admin.katalog.create');
    }

    /**
     * Menyimpan data katalog baru (termasuk banyak foto) ke database
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validator = Validator::make($request->all(), [
            'judul'     => 'required|max:50',
            'deskripsi' => 'required|max:500',
            'foto'      => 'required|array', // Memastikan foto dikirim sebagai array
            'foto.*'    => 'image|mimes:jpeg,png,jpg|max:2048', // Validasi setiap file dalam array
            'berat'     => 'required|integer',
            'stok'      => 'required|integer',
            'harga'     => 'required|integer',
        ]);

        // 2. Jika form kosong / tidak lengkap
        if ($validator->fails()) {
            return back()->withInput()->with('error_katalog', 'Harap lengkapi data katalog');
        }

        // 3. Simpan Banyak Gambar ke folder 'storage/app/public/katalog'
        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                // Simpan path masing-masing foto ke dalam array
                $fotoPaths[] = $file->store('katalog', 'public'); 
            }
        }

        // 4. Simpan Data ke Database
        $katalog = Katalog::create([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto'      => $fotoPaths, // Simpan array foto ke database (berkat $casts di Model)
            'berat'     => $request->berat,
            'stok'      => $request->stok,
            'harga'     => $request->harga,
        ]);

        // 5. Alihkan ke halaman detail dengan pesan sukses
        return redirect()->route('admin.katalog.show', $katalog->id)
                         ->with('success', 'Katalog berhasil diunggah');
    }

    /**
     * Menampilkan halaman detail katalog
     */
    public function show($id)
    {
        // Cari data berdasarkan ID, akan error 404 jika tidak ditemukan
        $katalog = Katalog::findOrFail($id);
        
        return view('admin.katalog.show', compact('katalog'));
    }
}