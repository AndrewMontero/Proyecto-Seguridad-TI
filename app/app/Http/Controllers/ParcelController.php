<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcel;
use Illuminate\Support\Facades\Auth;

class ParcelController extends Controller
{
    // Mostrar listado
    public function index(Request $request)
    {
        $q = $request->input('q', '');
        // Listado simple con búsqueda por nombre o cultivo
        $parcels = Parcel::when($q, function($query,$q){
                        $query->where('name','like',"%{$q}%")
                              ->orWhere('crop','like',"%{$q}%");
                    })
                    ->orderBy('created_at','desc')
                    ->paginate(12);
        return view('parcels.index', compact('parcels','q'));
    }

    // Form crear
    public function create()
    {
        return view('parcels.create');
    }

    // Guardar
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'area' => 'nullable|numeric',
            'crop' => 'nullable|string|max:120',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        // si tienes auth y quieres asignar dueño:
        if(Auth::check()){
            $data['user_id'] = Auth::id();
        }

        Parcel::create($data);
        return redirect()->route('parcels.index')->with('success','Parcela creada.');
    }

    // Mostrar detalle
    public function show(Parcel $parcel)
    {
        return view('parcels.show', compact('parcel'));
    }

    // Form editar
    public function edit(Parcel $parcel)
    {
        return view('parcels.edit', compact('parcel'));
    }

    // Actualizar
    public function update(Request $request, Parcel $parcel)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'area' => 'nullable|numeric',
            'crop' => 'nullable|string|max:120',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        $parcel->update($data);
        return redirect()->route('parcels.show', $parcel)->with('success','Parcela actualizada.');
    }

    // Eliminar
    public function destroy(Parcel $parcel)
    {
        $parcel->delete();
        return redirect()->route('parcels.index')->with('success','Parcela eliminada.');
    }
}
