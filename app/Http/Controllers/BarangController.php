<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
{
    $query = Barang::query();

    // Jika ada pencarian
    if ($request->has('search') && $request->search != '') {
        $query->where('nama_barang', 'like', '%' . $request->search . '%');
    }

    $barangs = $query->orderBy('nama_barang')->get();

    return view('barang.index', compact('barangs'));
}

    public function create()
    {
        return view('barang.create');
    }

    // Pencarian Barang
   public function search(Request $request)
{
    $keyword = $request->keyword;
    $barang = Barang::where('nama_barang', 'LIKE', "%{$keyword}%")
        ->get(['id', 'nama_barang', 'harga', 'stok']);

    // Ubah nama_barang 
    $barang = $barang->map(function($b){
        return [
            'id' => $b->id,
            'nama_barang' => $b->nama_barang, 
            'harga' => $b->harga,
            'stok' => $b->stok
        ];
    });

    return response()->json($barang);
}
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|in:pcs,lusin,rol',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'harga' => $request->harga_satuan,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        Barang::destroy($id);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
}