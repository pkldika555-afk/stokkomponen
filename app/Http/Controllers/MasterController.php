<?php

namespace App\Http\Controllers;

use App\Models\MasterKomponen;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index()
    {
        $komponen = MasterKomponen::paginate(10);
        return view('komponen.index', compact('komponen'));
    }
    public function create()
    {
        return view('komponen.create');
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'kode_komponen' => 'required|max:255',
            'nama_komponen'=> 'required',
            'tipe'=> 'required',
            'satuan'=> 'required',
            'stok_minimal'=> 'required',
        ]);
        MasterKomponen::create($validate);
        return redirect()->route('komponen.index')->with('success','Data berhasil ditambahkan');
    }
}
