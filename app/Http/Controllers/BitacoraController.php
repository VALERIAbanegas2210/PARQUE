<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    public function index()
    {
        // Obtén las bitácoras con la relación user
        $bitacoras = Bitacora::with('user')->paginate(10); // Ajusta el número de registros por página según necesites

        return view('bitacora.index', compact('bitacoras'));
    }
}