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
}
