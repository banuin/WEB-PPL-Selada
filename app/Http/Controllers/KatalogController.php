<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KatalogController extends Controller
{
    public function index()
    {
        $katalogs = Katalog::latest()->get();

        return view('admin.katalog.index', compact('katalogs'));
    }

    public function create()
    {
        return view('admin.katalog.create');
    }

    public function store(Request $request)
    {
        // 1. "Pembersihan" Data (Sanitization)
        // Menghapus "Rp.", titik, dan "KG" agar menjadi angka murni sebelum divalidasi
        if ($request->has('harga')) {
            $hargaClean = preg_replace('/[^0-9]/', '', $request->harga);
            $request->merge(['harga' => $hargaClean]);
        }

        if ($request->has('berat')) {
            $beratClean = preg_replace('/[^0-9]/', '', $request->berat);
            $request->merge(['berat' => $beratClean]);
        }

        // 2. Validasi Data
        $validator = Validator::make($request->all(), [
            'judul'     => 'required|max:50',
            'deskripsi' => 'required|max:1000',
            'foto'      => 'required|array|min:1',
            'berat'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'harga'     => 'required|numeric|digits_between:1,12', // Maksimal 12 digit (ratusan miliar)
        ]);

        // 3. Jika Validasi Gagal
        if ($validator->fails()) {
            return back()
                ->withErrors($validator) // Agar kita bisa tahu error spesifiknya apa
                ->withInput()
                ->with('error_katalog', 'Harap lengkapi data katalog');
        }

        // 4. Simpan Banyak Gambar
        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $fotoPaths[] = $file->store('katalog', 'public'); 
            }
        }

        // 5. Simpan Data ke Database
        $katalog = Katalog::create([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto'      => $fotoPaths, 
            'berat'     => $request->berat,
            'stok'      => $request->stok,
            'harga'     => $request->harga,
        ]);

        return redirect()->route('admin.katalog.show', $katalog->id)
                         ->with('success', 'Katalog berhasil diunggah');
    }

    public function show($id)
    {
        $katalog = Katalog::findOrFail($id);
        return view('admin.katalog.show', compact('katalog'));
    }
    public function edit($id)
    {
        $katalog = Katalog::findOrFail($id);
        return view('admin.katalog.edit', compact('katalog'));
    }
    public function destroy($id)
    {
        $katalog = Katalog::findOrFail($id);

        if ($katalog->foto) {
            foreach ($katalog->foto as $path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
            }
        }

        $katalog->delete();

        return redirect()->route('admin.katalog.index')
                         ->with('success', 'Katalog berhasil dihapus!');
    }

    public function update(Request $request, $id)
    {
        $katalog = Katalog::findOrFail($id);

        // 1. Bersihkan "Rp." dan karakter non-angka agar bisa divalidasi
        if ($request->has('harga')) {
            $request->merge(['harga' => preg_replace('/[^0-9]/', '', $request->harga)]);
        }
        if ($request->has('berat')) {
            $request->merge(['berat' => preg_replace('/[^0-9]/', '', $request->berat)]);
        }

        // 2. Validasi (Foto tidak diwajibkan di halaman edit)
        $validator = Validator::make($request->all(), [
            'judul'     => 'required|max:50',
            'deskripsi' => 'required|max:1000',
            'berat'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'harga'     => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->with('error_katalog', 'Harap lengkapi data katalog');
        }

        // 3. Update data ke Database
        $katalog->update([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'berat'     => $request->berat,
            'stok'      => $request->stok,
            'harga'     => $request->harga,
        ]);

        // 4. Kembali ke halaman detail dengan pesan sukses
        return redirect()->route('admin.katalog.show', $katalog->id)
                         ->with('success', 'Katalog berhasil diubah!');
    }

    public function showPelanggan($id)
    {
        $katalog = Katalog::findOrFail($id);
        
        // Kita arahkan ke folder view yang berbeda (khusus pelanggan)
        return view('pelanggan.katalog.show', compact('katalog'));
    }
}