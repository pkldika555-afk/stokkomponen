<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\MasterKomponen;
use App\Models\MutasiBarang;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    public function index(Request $request)
    {
        $query = MutasiBarang::with(['komponen', 'departemenAsal', 'departemenTujuan'])->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc');

        if ($request->filled('jenis')) {
            $query->where(
                'jenis',
                $request->jenis
            );
        }
        if ($request->filled('id_komponen')) {
            $query->where(
                'id_komponen',
                $request->id_komponen
            );
        }
        if ($request->filled('dari')) {
            $query->whereDate(
                'tanggal',
                '>=',
                $request->tanggal
            );
        }
        if ($request->filled('sampai')) {
            $query->whereDate(
                'tanggal',
                '<=',
                $request->tanggal
            );
        }
        $mutasi = $query->paginate(15);
        $komponen = MasterKomponen::orderBy('nama_komponen')->get();
        return view("mutasi.index", compact("komponen", "mutasi"));
    }
    public function create()
    {
        $komponen = MasterKomponen::all();
        $departemen = Departemen::all();
        return view('mutasi.create', compact('komponen', 'departemen'));
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'id_komponen' => 'required|exists:master_komponen,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'id_departemen_asal' => 'required|exists:departemen,id',
            'id_departemen_tujuan' => 'required|exists:departemen,id',
            'jenis' => 'required|in:pembelian,internal,retur,repair_kembali',
            'keterangan' => 'nullable|string|max:500',
        ]);

        if (in_array($validate['jenis'], MutasiBarang::JENIS_KELUAR)) {
            $komponen = MasterKomponen::findOrFail($validate['id_komponen']);
            if ($komponen->stok < $validate['jumlah']) {
                return back()->withInput()->withErrors(['jumlah' => "Stok tidak cukup. Stok tersedia: {$komponen->stok} {$komponen->satuan}"]);
            }
        }
        MutasiBarang::create($validate);
        return redirect()->route('mutasi.index')->with('success', 'Mutasi berhasil ditambahkan');
    }
}
