<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        // Vulnerable a SQLi (intencional para la demo)
        $busqueda = $request->input('buscar', '');
        
        // Usar query en lugar de select para mantener la vulnerabilidad pero permitir conversión
        $productos = DB::table('productos')
            ->whereRaw("nombre LIKE '%$busqueda%'")
            ->paginate(12); // Añade paginación
        
        return view('productos.index', compact('productos', 'busqueda'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        // Vulnerable a XSS (no valida ni sanitiza)
        DB::insert(
            "INSERT INTO productos (nombre, descripcion, precio, created_at, updated_at)
             VALUES (?, ?, ?, NOW(), NOW())",
            [$request->nombre, $request->descripcion, $request->precio]
        );

        return redirect('/productos');
    }
}