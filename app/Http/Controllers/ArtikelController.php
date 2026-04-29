<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index() 
    {
        $artikels = Artikel::latest()->get();
        return view('admin.Artikel.index', compact('artikels'));
    }


    public function create() 
    {
        return view('admin.Artikel.create');
    }

    public function store(Request $request) 
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required', 
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048' 
        ], [
            'title.required' => 'Harap lengkapi data artikel',
            'content.required' => 'Harap lengkapi data artikel',
            'image.required' => 'Harap lengkapi data artikel',
        ]);

        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images/articles'), $imageName);


        Artikel::create([
            'judul' => $request->title,
            'deskripsi' => $request->content, 
            'gambar' => $imageName,           
        ]);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dibuat!');
    }

    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('admin.Artikel.show', compact('artikel'));
    }

    public function update(Request $request, $id)
    {
        $artikel = \App\Models\Artikel::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'deskripsi.required' => 'harap lengkapi data artikel',
            'judul.required' => 'judul tidak boleh kosong'
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ];
        
        if ($request->hasFile('gambar')) {
            $imageName = time().'.'.$request->gambar->extension();  
            $request->gambar->move(public_path('images/articles'), $imageName);
            $data['gambar'] = $imageName;
        }

        $artikel->update($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui');
    }

    public function edit($id)
    {
        $artikel = \App\Models\Artikel::findOrFail($id);
        return view('admin.Artikel.edit', compact('artikel'));
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        
        // Hapus file gambar dari folder public
        if (file_exists(public_path('gambar/artikel/' . $artikel->gambar))) {
            unlink(public_path('gambar/artikel/' . $artikel->gambar));
        }

        $artikel->delete();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus');
    }
}