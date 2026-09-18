<?php

namespace App\Http\Controllers;

use App\Models\Investigador;
use App\Models\Carrera;
use App\Models\Productividad;
use App\Models\Tipo;
use App\Models\AsignarInvestigador;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $tipoReporte = $request->tipo_reporte;
        $buscar = $request->buscar;

        $resultados = collect();

        /*
        =============================================
        PRODUCTIVIDADES POR INVESTIGADOR
        =============================================
        */
        if ($tipoReporte == 'investigador') {

            $resultados = Productividad::with([
                    'investigador.carrera',
                    'tipo'
                ])
                ->when($buscar, function ($query, $buscar) {

                    $query->whereHas(
                        'investigador',
                        function ($q) use ($buscar) {

                            $q->where(
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

                })
                ->orderBy('id_productividad', 'asc')
                ->get();
        }


        /*
        =============================================
        PRODUCTIVIDADES POR CARRERA
        =============================================
        */
        elseif ($tipoReporte == 'carrera') {

            $resultados = Productividad::with([
                    'investigador.carrera',
                    'tipo'
                ])
                ->when($buscar, function ($query, $buscar) {

                    $query->whereHas(
                        'investigador.carrera',
                        function ($q) use ($buscar) {

                            $q->where(
                                'nombre_carrera',
                                'LIKE',
                                '%' . $buscar . '%'
                            );

                        }
                    );

                })
                ->orderBy('id_productividad', 'asc')
                ->get();
        }


        /*
        =============================================
        PRODUCTIVIDADES POR TIPO
        =============================================
        */
        elseif ($tipoReporte == 'tipo') {

            $resultados = Productividad::with([
                    'investigador',
                    'tipo'
                ])
                ->when($buscar, function ($query, $buscar) {

                    $query->whereHas(
                        'tipo',
                        function ($q) use ($buscar) {

                            $q->where(
                                'desc_tipo',
                                'LIKE',
                                '%' . $buscar . '%'
                            );

                        }
                    );

                })
                ->orderBy('id_productividad', 'asc')
                ->get();
        }


        /*
        =============================================
        INVESTIGADORES POR PRODUCTIVIDAD
        =============================================
        */
        elseif ($tipoReporte == 'productividad') {

            $resultados = AsignarInvestigador::with([
                    'productividad',
                    'investigador.carrera'
                ])
                ->when($buscar, function ($query, $buscar) {

                    $query->whereHas(
                        'productividad',
                        function ($q) use ($buscar) {

                            $q->where(
                                'titulo',
                                'LIKE',
                                '%' . $buscar . '%'
                            );

                        }
                    );

                })
                ->orderBy('id_asigna', 'asc')
                ->get();
        }


        /*
        =============================================
        DATOS PARA LOS BUSCADORES
        =============================================
        */

        $investigadores = Investigador::orderBy(
            'nombre',
            'asc'
        )->get();

        $carreras = Carrera::orderBy(
            'nombre_carrera',
            'asc'
        )->get();

        $tipos = Tipo::orderBy(
            'desc_tipo',
            'asc'
        )->get();

        $productividades = Productividad::orderBy(
            'titulo',
            'asc'
        )->get();


        return view(
            'reportes.index',
            compact(
                'tipoReporte',
                'buscar',
                'resultados',
                'investigadores',
                'carreras',
                'tipos',
                'productividades'
            )
        );
    }
}