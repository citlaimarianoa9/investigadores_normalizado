<?php

namespace App\Http\Controllers;

use App\Models\Productividad;
use App\Models\Investigador;
use App\Models\Tipo;
use Illuminate\Http\Request;

class ProductividadController extends Controller
{
    // MOSTRAR PRODUCTIVIDADES
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $productividades = Productividad::with([
                'investigador',
                'tipo'
            ])
            ->when($buscar, function ($query, $buscar) {

                $query->where(function ($q) use ($buscar) {

                    $q->where('titulo', 'LIKE', '%' . $buscar . '%')
                      ->orWhere('descripcion', 'LIKE', '%' . $buscar . '%');

                });

            })
            ->orderBy('id_productividad', 'asc')
            ->get();

        return view(
            'productividades.index',
            compact('productividades', 'buscar')
        );
    }


    // FORMULARIO REGISTRAR
    public function create()
    {
        $investigadores = Investigador::orderBy('nombre', 'asc')->get();

        $tipos = Tipo::orderBy('desc_tipo', 'asc')->get();

        return view(
            'productividades.create',
            compact('investigadores', 'tipos')
        );
    }


    // GUARDAR
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'fecha_p' => 'required|date',
            'id_investigador' => 'required|exists:investigadores,id_investigador',
            'descripcion' => 'required|string',
            'id_tipo' => 'required|exists:tipos,id_tipo',
        ]);

        Productividad::create([
            'titulo' => $request->titulo,
            'fecha_p' => $request->fecha_p,
            'id_investigador' => $request->id_investigador,
            'descripcion' => $request->descripcion,
            'id_tipo' => $request->id_tipo,
        ]);

        return redirect()
            ->route('productividades.index')
            ->with(
                'success',
                'Productividad registrada correctamente.'
            );
    }


    // FORMULARIO EDITAR
    public function edit($id)
    {
        $productividad = Productividad::findOrFail($id);

        $investigadores = Investigador::orderBy('nombre', 'asc')->get();

        $tipos = Tipo::orderBy('desc_tipo', 'asc')->get();

        return view(
            'productividades.edit',
            compact(
                'productividad',
                'investigadores',
                'tipos'
            )
        );
    }


    // ACTUALIZAR
    public function update(Request $request, $id)
    {
        $productividad = Productividad::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'fecha_p' => 'required|date',
            'id_investigador' => 'required|exists:investigadores,id_investigador',
            'descripcion' => 'required|string',
            'id_tipo' => 'required|exists:tipos,id_tipo',
        ]);

        $productividad->update([
            'titulo' => $request->titulo,
            'fecha_p' => $request->fecha_p,
            'id_investigador' => $request->id_investigador,
            'descripcion' => $request->descripcion,
            'id_tipo' => $request->id_tipo,
        ]);

        return redirect()
            ->route('productividades.index')
            ->with(
                'success',
                'Productividad actualizada correctamente.'
            );
    }


    // ELIMINAR
    public function destroy($id)
    {
        $productividad = Productividad::findOrFail($id);

        $productividad->delete();

        return redirect()
            ->route('productividades.index')
            ->with(
                'success',
                'Productividad eliminada correctamente.'
            );
    }
}