<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\MasterKomponen;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index()
    {
        $komponen = MasterKomponen::paginate(10);
        $departemen = Departemen::all();
        return view('komponen.index', compact('komponen', 'departemen'));
    }
    public function create()
    {
        $departemen = Departemen::all();
        return view('komponen.create', compact('departemen'));
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'kode_komponen' => 'required|max:255',
            'nama_komponen' => 'required',
            'tipe' => 'required',
            'satuan' => 'required',
            'stok_minimal' => 'required',
            'rak' => 'required',
            'lokasi' => 'required',
            'departemen_id' => 'required',
        ]);
        MasterKomponen::create($validate);
        return redirect()->route('komponen.index')->with('success', 'Data berhasil ditambahkan');
    }
    public function edit($id)
    {
        $komponen = MasterKomponen::findOrFail($id);
        $departemen = Departemen::all();
        return view('komponen.edit', compact('komponen', 'departemen'));
    }
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'kode_komponen' => 'required|max:255',
            'nama_komponen' => 'required',
            'tipe' => 'required',
            'satuan' => 'required',
            'stok_minimal' => 'required',
            'rak' => 'required',
            'lokasi' => 'required',
            'id_departemen' => 'required',
        ]);
        MasterKomponen::findOrFail($id)->update($validate);
        return redirect()->route('komponen.index')->with('success', 'Data berhasil diubah');
    }
    public function destroy($id)
    {
        $komponen = MasterKomponen::findOrFail($id);
        $komponen->delete();
        return redirect()->route('komponen.index')->with('success', 'Data berhasil dihapus');
    }
}
