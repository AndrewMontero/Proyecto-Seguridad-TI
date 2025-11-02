<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Lectura;
use App\Models\Parcel;

class LecturaController extends Controller
{
    /**
     * ⚠️ VULNERABLE: SQL Injection en filtros
     */
    public function index(Request $request)
    {
        $parcelaId = $request->input('parcela_id', '');
        $fechaDesde = $request->input('fecha_desde', '');

        // Vulnerable a SQL Injection
        $query = "SELECT lecturas.*, parcels.name as parcela_nombre
                  FROM lecturas
                  LEFT JOIN parcels ON lecturas.parcel_id = parcels.id
                  WHERE 1=1";

        if ($parcelaId) {
            $query .= " AND parcel_id = $parcelaId";
        }

        if ($fechaDesde) {
            $query .= " AND fecha_lectura >= '$fechaDesde'";
        }

        $query .= " ORDER BY fecha_lectura DESC LIMIT 50";

        $lecturas = DB::select($query);
        $parcelas = Parcel::all();

        return view('lecturas.index', compact('lecturas', 'parcelas'));
    }

    /**
     * Mostrar formulario de crear
     */
    public function create()
    {
        $parcelas = Parcel::all();
        return view('lecturas.create', compact('parcelas'));
    }

    /**
     * ⚠️ VULNERABLE: XSS - no valida ni sanitiza entrada
     */
    public function store(Request $request)
    {
        // Sin validación - vulnerable a XSS
        DB::insert(
            "INSERT INTO lecturas (parcel_id, temperatura, humedad, ph, humedad_suelo, tipo_sensor, notas, fecha_lectura, created_at, updated_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())",
            [
                $request->parcel_id,
                $request->temperatura,
                $request->humedad,
                $request->ph,
                $request->humedad_suelo,
                $request->tipo_sensor,
                $request->notas,
                $request->fecha_lectura ?? now()
            ]
        );

        return redirect('/lecturas')->with('success', 'Lectura registrada correctamente');
    }

    /**
     * ⚠️ VULNERABLE: IDOR - no verifica permisos
     */
    public function show($id)
    {
        // No verifica si el usuario tiene acceso a esta lectura
        $lectura = DB::selectOne("SELECT lecturas.*, parcels.name as parcela_nombre
                                   FROM lecturas
                                   LEFT JOIN parcels ON lecturas.parcel_id = parcels.id
                                   WHERE lecturas.id = $id");

        if (!$lectura) {
            abort(404);
        }

        return view('lecturas.show', compact('lectura'));
    }

    /**
     * Eliminar lectura
     */
    public function destroy($id)
    {
        DB::delete("DELETE FROM lecturas WHERE id = ?", [$id]);
        return redirect('/lecturas')->with('success', 'Lectura eliminada');
    }
}
