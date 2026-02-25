<?php

namespace App\Http\Controllers;

use App\Models\MasterKomponen;
use App\Models\MutasiBarang;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    public function index()
    {
        $komponen = MasterKomponen::all();
        $mutasi = MutasiBarang::paginate(10);
        return view("mutasi.index", compact("komponen", "mutasi"));
    }
}
