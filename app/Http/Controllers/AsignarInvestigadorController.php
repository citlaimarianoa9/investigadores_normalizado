<?php

namespace App\Http\Controllers;

use App\Models\AsignarInvestigador;
use App\Models\Productividad;
use App\Models\Investigador;
use Illuminate\Http\Request;

class AsignarInvestigadorController extends Controller
{
    // MOSTRAR ASIGNACIONES
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $asignaciones = AsignarInvestigador::with([
                'productividad',
                'investigador'
            ])
            ->when($buscar, function ($query, $buscar) {

                $query->where(function ($q) use ($buscar) {

                    $q->whereHas(
                        'productividad',
                        function ($consulta) use ($buscar) {

                            $consulta->where(
                                'titulo',
                                'LIKE',
                                '%' . $buscar . '%'
                            );
                        }
                    )

                    ->orWhereHas(
                        'investigador',
                        function ($consulta) use ($buscar) {

                            $consulta
                                ->where(
                                    'nombre',
                                    'LIKE',
                                    '%' . $buscar . '%'
                                )
                                ->orWhere(
                                    'apellido_p',
                                    'LIKE',
                                    '%' . $buscar . '%'
                                )
                                ->orWhere(
                                    'apellido_m',
                                    'LIKE',
                                    '%' . $buscar . '%'
                                );
                        }
                    );

                });

            })
            ->orderBy('id_asigna', 'asc')
            ->get();

        return view(
            'asignarinvestigadores.index',
            compact('asignaciones', 'buscar')
        );
    }


    // FORMULARIO REGISTRAR
    public function create()
    {
        $productividades = Productividad::orderBy(
            'titulo',
            'asc'
        )->get();

        $investigadores = Investigador::orderBy(
            'nombre',
            'asc'
        )->get();

        return view(
            'asignarinvestigadores.create',
            compact(
                'productividades',
                'investigadores'
            )
        );
    }


    // GUARDAR
    public function store(Request $request)
    {
        $request->validate([
            'id_productividad' =>
                'required|exists:productividades,id_productividad',

            'id_investigador' =>
                'required|exists:investigadores,id_investigador',
        ]);

        AsignarInvestigador::create([
            'id_productividad' =>
                $request->id_productividad,

            'id_investigador' =>
                $request->id_investigador,
        ]);

        return redirect()
            ->route('asignarinvestigadores.index')
            ->with(
                'success',
                'Asignación registrada correctamente.'
            );
    }


    // FORMULARIO EDITAR
    public function edit($id)
    {
        $asignacion =
            AsignarInvestigador::findOrFail($id);

        $productividades =
            Productividad::orderBy(
                'titulo',
                'asc'
            )->get();

        $investigadores =
            Investigador::orderBy(
                'nombre',
                'asc'
            )->get();

        return view(
            'asignarinvestigadores.edit',
            compact(
                'asignacion',
                'productividades',
                'investigadores'
            )
        );
    }


    // ACTUALIZAR
    public function update(Request $request, $id)
    {
        $asignacion =
            AsignarInvestigador::findOrFail($id);

        $request->validate([
            'id_productividad' =>
                'required|exists:productividades,id_productividad',

            'id_investigador' =>
                'required|exists:investigadores,id_investigador',
        ]);

        $asignacion->update([
            'id_productividad' =>
                $request->id_productividad,

            'id_investigador' =>
                $request->id_investigador,
        ]);

        return redirect()
            ->route('asignarinvestigadores.index')
            ->with(
                'success',
                'Asignación actualizada correctamente.'
            );
    }


    // ELIMINAR
    public function destroy($id)
    {
        $asignacion =
            AsignarInvestigador::findOrFail($id);

        $asignacion->delete();

        return redirect()
            ->route('asignarinvestigadores.index')
            ->with(
                'success',
                'Asignación eliminada correctamente.'
            );
    }
}