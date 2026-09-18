<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    // Mostrar tipos y realizar búsqueda con LIKE
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $tipos = Tipo::when($buscar, function ($query, $buscar) {
            return $query->where(
                'desc_tipo',
                'LIKE',
                '%' . $buscar . '%'
            );
        })
        ->orderBy('id_tipo', 'asc')
        ->paginate(10);

        return view('tipos.index', compact('tipos', 'buscar'));
    }


    // Formulario para registrar
    public function create()
    {
        return view('tipos.create');
    }


    // Guardar nuevo tipo
    public function store(Request $request)
    {
        $request->validate([
            'desc_tipo' => 'required|string|max:150',
        ]);

        Tipo::create([
            'desc_tipo' => $request->desc_tipo,
        ]);

        return redirect()
            ->route('tipos.index')
            ->with('success', 'Tipo de productividad registrado correctamente.');
    }


    // Formulario para editar
    public function edit(Tipo $tipo)
    {
        return view('tipos.edit', compact('tipo'));
    }


    // Actualizar
    public function update(Request $request, Tipo $tipo)
    {
        $request->validate([
            'desc_tipo' => 'required|string|max:150',
        ]);

        $tipo->update([
            'desc_tipo' => $request->desc_tipo,
        ]);

        return redirect()
            ->route('tipos.index')
            ->with('success', 'Tipo de productividad actualizado correctamente.');
    }


    // Eliminar
    public function destroy(Tipo $tipo)
    {
        $tipo->delete();

        return redirect()
            ->route('tipos.index')
            ->with('success', 'Tipo de productividad eliminado correctamente.');
    }
}