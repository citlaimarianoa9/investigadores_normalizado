<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    // Mostrar carreras y buscar con LIKE
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $carreras = Carrera::when($buscar, function ($query, $buscar) {
            return $query->where(
                'nombre_carrera',
                'LIKE',
                '%' . $buscar . '%'
            );
        })
        ->orderBy('id_carrera', 'asc')
        ->paginate(10);

        return view('carreras.index', compact('carreras', 'buscar'));
    }


    // Mostrar formulario para registrar
    public function create()
    {
        return view('carreras.create');
    }


    // Guardar carrera
    public function store(Request $request)
    {
        $request->validate([
            'nombre_carrera' => 'required|string|max:150|unique:carreras,nombre_carrera',
        ]);

        Carrera::create([
            'nombre_carrera' => $request->nombre_carrera,
        ]);

        return redirect()
            ->route('carreras.index')
            ->with('success', 'Carrera registrada correctamente.');
    }


    // Mostrar formulario para editar
    public function edit(Carrera $carrera)
    {
        return view('carreras.edit', compact('carrera'));
    }


    // Actualizar carrera
    public function update(Request $request, Carrera $carrera)
    {
        $request->validate([
            'nombre_carrera' =>
                'required|string|max:150|unique:carreras,nombre_carrera,' .
                $carrera->id_carrera .
                ',id_carrera',
        ]);

        $carrera->update([
            'nombre_carrera' => $request->nombre_carrera,
        ]);

        return redirect()
            ->route('carreras.index')
            ->with('success', 'Carrera actualizada correctamente.');
    }


    // Eliminar carrera
    public function destroy(Carrera $carrera)
    {
        $carrera->delete();

        return redirect()
            ->route('carreras.index')
            ->with('success', 'Carrera eliminada correctamente.');
    }
}