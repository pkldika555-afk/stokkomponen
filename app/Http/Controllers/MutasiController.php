<?php

namespace App\Http\Controllers;

use App\Models\MasterKomponen;
use App\Models\MutasiBarang;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    public function index(Request $request)
    {
        $query = MutasiBarang::with(['komponen', 'departemenAsal', 'departemenTujuan'])->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc');

        if ($request->filled('jenis')){
            $query->where('jenis', $request->jenis
            );
        }
        if ($request->filled('id_komponen')){
            $query->where('id_komponen', $request->id_komponen
            );
        }
        if ($request->filled('dari')){
            $query->whereDate('tanggal', '>=', $request->tanggal
            );
        }
        if ($request->filled('sampai')){
            $query->whereDate('tanggal', '<=', $request->tanggal
            );
        }
        $mutasi = $query->paginate(15);
        $komponen = MasterKomponen::orderBy('nama_komponen')->get();
        return view("mutasi.index", compact("komponen", "mutasi"));
    }
}
