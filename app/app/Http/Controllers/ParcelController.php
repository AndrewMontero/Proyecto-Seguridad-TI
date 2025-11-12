<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcel;

class ParcelController extends Controller
{
    /**
     * Mostrar listado simple de parcelas.
     */
    public function index(Request $request)
    {
        // Muestra todas las parcelas — en la demo pueden verse los IDs para explotar el IDOR
        $parcels = Parcel::orderBy('id', 'desc')->paginate(15);
        return view('parcels.index', compact('parcels'));
    }

    /**
     * Mostrar formulario de edición.
     *
     * ⚠️ VULNERABLE: NO verifica que la parcela pertenezca al usuario autenticado.
     * Cualquiera que conozca el ID puede acceder a /parcels/{id}/edit
     */
    public function edit($id)
    {
        $parcel = Parcel::findOrFail($id); // no ownership check
        return view('parcels.edit', compact('parcel'));
    }

    /**
     * Actualizar parcela.
     *
     * ⚠️ VULNERABLE: NO hay verificación de propietario ni autorización.
     */
    public function update(Request $request, $id)
    {
        $parcel = Parcel::findOrFail($id); // no ownership check

        // Sin validación de entrada (demo)
        $parcel->name = $request->input('name');
        $parcel->description = $request->input('description');
        $parcel->area = $request->input('area');

        $parcel->save();

        return redirect()->route('parcels.index')
                         ->with('success', 'Parcel updated (demo vulnerable).');
    }

    /**
     * (Opcional) Mostrar detalle
     */
    public function show($id)
    {
        $parcel = Parcel::findOrFail($id);
        return view('parcels.show', compact('parcel'));
    }

    /**
     * (Opcional) crear nuevas parcelas - simplificado
     */
    public function create()
    {
        return view('parcels.create');
    }

    public function store(Request $request)
    {
        // Demo: no validations
        $parcel = new Parcel();
        $parcel->name = $request->input('name');
        $parcel->description = $request->input('description');
        $parcel->area = $request->input('area');
        // Example: in a real app you'd set user_id = auth()->id()
        $parcel->user_id = $request->input('user_id', null);
        $parcel->save();

        return redirect()->route('parcels.index')->with('success', 'Parcel created (demo).');
    }

    /**
     * Eliminar parcela.
     *
     * ⚠️ VULNERABLE: NO verifica ownership - cualquiera puede eliminar parcelas ajenas
     */
    public function destroy($id)
    {
        $parcel = Parcel::findOrFail($id); // no ownership check
        $parcel->delete();

        return redirect()->route('parcels.index')
                         ->with('success', 'Parcela eliminada correctamente.');
    }
}
