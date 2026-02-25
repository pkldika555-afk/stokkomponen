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
}
