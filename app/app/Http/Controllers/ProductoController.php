<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->input('buscar', '');

        // VULNERABLE: concatenación directa (solo para demo)
        if ($busqueda !== '') {
            $sql = "SELECT * FROM productos WHERE nombre LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%'";
            $resultados = DB::select($sql);
            $productos = collect($resultados);
        } else {
            $productos = DB::table('productos')->orderByDesc('id')->paginate(12);
        }

        return view('productos.index', compact('productos', 'busqueda'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        DB::insert(
            "INSERT INTO productos (nombre, descripcion, precio, created_at, updated_at)
             VALUES (?, ?, ?, NOW(), NOW())",
            [$request->nombre, $request->descripcion, $request->precio]
        );

        return redirect('/productos');
    }
}
