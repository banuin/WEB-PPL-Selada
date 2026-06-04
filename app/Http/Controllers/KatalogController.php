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
        if ($request->has('harga')) {
            $hargaClean = preg_replace('/[^0-9]/', '', $request->harga);
            $request->merge(['harga' => $hargaClean]);
        }


        $validator = Validator::make($request->all(), [
            'judul'     => 'required|max:50',
            'deskripsi' => 'required|max:1000',
            'foto'      => 'required|array|min:1',
            'foto.*'    => 'image|mimes:jpeg,png,jpg|max:10240',
            'stok'      => 'required|numeric',
            'harga'     => 'required|numeric|digits_between:1,12', 
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput(); 
        }

        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $fotoPaths[] = $file->store('katalog', 'public'); 
            }
        }

        $katalog = Katalog::create([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto'      => $fotoPaths, 
            'stok'      => $request->stok,
            'harga'     => $request->harga,
            'berat'     => 0,
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

        if ($request->has('harga')) {
            $request->merge(['harga' => preg_replace('/[^0-9]/', '', $request->harga)]);
        }

        $validator = Validator::make($request->all(), [
            'judul'     => 'required|max:50',
            'deskripsi' => 'required|max:1000',
            'stok'      => 'required|numeric',
            'harga'     => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $katalog->update([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'stok'      => $request->stok,
            'harga'     => $request->harga,
            'berat'     => 0,
        ]);

        return redirect()->route('admin.katalog.show', $katalog->id)
                         ->with('success', 'Katalog berhasil diubah!');
    }

    public function showPelanggan($id)
    {
        $produk = Katalog::findOrFail($id);

        return view('pelanggan.katalog.show', compact('produk'));
    }
}