<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemen = departemen::paginate(10);
        return view('departemen.index', compact('departemen'));
    }
    public function create()
    {
        return view('departemen.create');
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama_departemen'=> 'required',
        ]);
        $departemen = departemen::create($validate);
        return redirect()->route(route: 'departemen.index')->with('success','Data berhasil ditambahkan');
    }
    public function edit($id)
    {
        $departemen = departemen::findOrFail($id);
        return view('departemen.edit', compact('departemen'));
    }
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama_departemen' => 'required',
        ]);
        $departemen = departemen::findOrFail($id);
        $departemen->update($validate);
        return redirect()->route(route:'departemen.index')->with('success','Data berhasil diperbarui');
    }
    public function destroy($id)
    {
        $departemen = departemen::findOrFail($id);
        $departemen->delete();
        return redirect()->route(route:'departemen.index')->with('success','Data berhasil dihapus');
    }
}
