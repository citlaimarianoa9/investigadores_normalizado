<?php

namespace App\Http\Controllers;

use App\Models\Investigador;
use App\Models\Carrera;
use Illuminate\Http\Request;

class InvestigadorController extends Controller
{
    // MOSTRAR INVESTIGADORES Y BUSCAR CON LIKE
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $investigadores = Investigador::with('carrera')
            ->when($buscar, function ($query, $buscar) {

                $query->where(function ($q) use ($buscar) {

                    $q->where('nombre', 'LIKE', '%' . $buscar . '%')
                      ->orWhere('apellido_p', 'LIKE', '%' . $buscar . '%')
                      ->orWhere('apellido_m', 'LIKE', '%' . $buscar . '%');

                });

            })
            ->orderBy('id_investigador', 'asc')
            ->get();

        return view(
            'investigadores.index',
            compact('investigadores', 'buscar')
        );
    }


    // FORMULARIO PARA REGISTRAR
    public function create()
    {
        $carreras = Carrera::orderBy('nombre_carrera', 'asc')->get();

        return view(
            'investigadores.create',
            compact('carreras')
        );
    }


    // GUARDAR INVESTIGADOR
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_p' => 'required|string|max:100',
            'apellido_m' => 'required|string|max:100',
            'id_carrera' => 'required|exists:carreras,id_carrera',
        ]);

        Investigador::create([
            'nombre' => $request->nombre,
            'apellido_p' => $request->apellido_p,
            'apellido_m' => $request->apellido_m,
            'id_carrera' => $request->id_carrera,
        ]);

        return redirect()
            ->route('investigadores.index')
            ->with('success', 'Investigador registrado correctamente.');
    }


    // FORMULARIO PARA EDITAR
    public function edit($id)
    {
        $investigador = Investigador::findOrFail($id);

        $carreras = Carrera::orderBy('nombre_carrera', 'asc')->get();

        return view(
            'investigadores.edit',
            compact('investigador', 'carreras')
        );
    }


    // ACTUALIZAR INVESTIGADOR
    public function update(Request $request, $id)
    {
        $investigador = Investigador::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_p' => 'required|string|max:100',
            'apellido_m' => 'required|string|max:100',
            'id_carrera' => 'required|exists:carreras,id_carrera',
        ]);

        $investigador->update([
            'nombre' => $request->nombre,
            'apellido_p' => $request->apellido_p,
            'apellido_m' => $request->apellido_m,
            'id_carrera' => $request->id_carrera,
        ]);

        return redirect()
            ->route('investigadores.index')
            ->with('success', 'Investigador actualizado correctamente.');
    }


    // ELIMINAR INVESTIGADOR
    public function destroy($id)
    {
        $investigador = Investigador::findOrFail($id);

        $investigador->delete();

        return redirect()
            ->route('investigadores.index')
            ->with('success', 'Investigador eliminado correctamente.');
    }
}