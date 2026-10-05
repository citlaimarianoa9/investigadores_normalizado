<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Tipo;
use App\Models\Investigador;
use App\Models\Productividad;
use App\Models\AsignarInvestigador;

class HomeController extends Controller
{
    public function index()
    {
        // Totales de cada módulo
        $totalCarreras = Carrera::count();
        $totalTipos = Tipo::count();
        $totalInvestigadores = Investigador::count();
        $totalProductividades = Productividad::count();
        $totalAsignaciones = AsignarInvestigador::count();

        // Últimas productividades registradas
        $ultimasProductividades = Productividad::with([
                'investigador',
                'tipo'
            ])
            ->orderBy('id_productividad', 'desc')
            ->take(5)
            ->get();

        // Últimos investigadores registrados
        $ultimosInvestigadores = Investigador::with('carrera')
            ->orderBy('id_investigador', 'desc')
            ->take(5)
            ->get();

        return view('home', compact(
            'totalCarreras',
            'totalTipos',
            'totalInvestigadores',
            'totalProductividades',
            'totalAsignaciones',
            'ultimasProductividades',
            'ultimosInvestigadores'
        ));
    }
}