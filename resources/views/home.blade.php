@extends('template')

@section('title', 'Inicio')

@section('content')

<div class="encabezado-home">
    <div>
        <h1>Panel General</h1>
        <p>
            Resumen de la información registrada en el sistema
            de Investigadores TESVB.
        </p>
    </div>
</div>


{{-- ================================================= --}}
{{-- TARJETAS DE RESUMEN --}}
{{-- ================================================= --}}

<div class="resumen-grid">

    <a href="{{ route('carreras.index') }}" class="resumen-card">

        <div class="resumen-numero">
            {{ $totalCarreras }}
        </div>

        <div class="resumen-info">
            <h3>Carreras</h3>
            <p>Carreras registradas</p>
        </div>

    </a>


    <a href="{{ route('tipos.index') }}" class="resumen-card">

        <div class="resumen-numero">
            {{ $totalTipos }}
        </div>

        <div class="resumen-info">
            <h3>Tipos</h3>
            <p>Tipos de productividad</p>
        </div>

    </a>


    <a href="{{ route('investigadores.index') }}" class="resumen-card">

        <div class="resumen-numero">
            {{ $totalInvestigadores }}
        </div>

        <div class="resumen-info">
            <h3>Investigadores</h3>
            <p>Investigadores registrados</p>
        </div>

    </a>


    <a href="{{ route('productividades.index') }}" class="resumen-card">

        <div class="resumen-numero">
            {{ $totalProductividades }}
        </div>

        <div class="resumen-info">
            <h3>Productividades</h3>
            <p>Productividades registradas</p>
        </div>

    </a>


    <a href="{{ route('asignarinvestigadores.index') }}" class="resumen-card">

        <div class="resumen-numero">
            {{ $totalAsignaciones }}
        </div>

        <div class="resumen-info">
            <h3>Asignaciones</h3>
            <p>Asignaciones registradas</p>
        </div>

    </a>

</div>


{{-- ================================================= --}}
{{-- TABLAS --}}
{{-- ================================================= --}}

<div class="home-tablas">

    {{-- ÚLTIMAS PRODUCTIVIDADES --}}

    <div class="home-card">

        <div class="home-card-header">

            <div>
                <h2>Últimas Productividades</h2>
                <p>Registros recientes del sistema</p>
            </div>

            <a
                href="{{ route('productividades.index') }}"
                class="ver-todos">

                Ver todas

            </a>

        </div>


        <div class="tabla-home">

            <table>

                <thead>
                    <tr>
                        <th>Productividad</th>
                        <th>Investigador</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($ultimasProductividades as $productividad)

                        <tr>

                            <td>
                                <strong>
                                    {{ $productividad->titulo }}
                                </strong>
                            </td>


                            <td>

                                @if($productividad->investigador)

                                    {{ $productividad->investigador->nombre }}
                                    {{ $productividad->investigador->apellido_p }}
                                    {{ $productividad->investigador->apellido_m }}

                                @else

                                    Sin investigador

                                @endif

                            </td>


                            <td>

                                @if($productividad->tipo)

                                    {{ $productividad->tipo->desc_tipo }}

                                @else

                                    Sin tipo

                                @endif

                            </td>


                            <td class="fecha-home">
                                {{ $productividad->fecha_p }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="sin-registros">
                                No hay productividades registradas.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>



    {{-- ÚLTIMOS INVESTIGADORES --}}

    <div class="home-card">

        <div class="home-card-header">

            <div>
                <h2>Últimos Investigadores</h2>
                <p>Investigadores registrados recientemente</p>
            </div>

            <a
                href="{{ route('investigadores.index') }}"
                class="ver-todos">

                Ver todos

            </a>

        </div>


        <div class="tabla-home">

            <table>

                <thead>
                    <tr>
                        <th>Investigador</th>
                        <th>Carrera</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($ultimosInvestigadores as $investigador)

                        <tr>

                            <td>

                                <strong>
                                    {{ $investigador->nombre }}
                                    {{ $investigador->apellido_p }}
                                    {{ $investigador->apellido_m }}
                                </strong>

                            </td>


                            <td>

                                @if($investigador->carrera)

                                    {{ $investigador->carrera->nombre_carrera }}

                                @else

                                    Sin carrera

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="2" class="sin-registros">
                                No hay investigadores registrados.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

    /*
    =========================================
    ENCABEZADO
    =========================================
    */

    .encabezado-home {
        margin-bottom: 28px;
    }

    .encabezado-home h1 {
        margin: 0 0 7px 0;
        color: #16324f;
        font-size: 34px;
    }

    .encabezado-home p {
        margin: 0;
        color: #6c7a86;
        font-size: 16px;
    }


    /*
    =========================================
    TARJETAS
    =========================================
    */

    .resumen-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(170px, 1fr));
        gap: 18px;
        margin-bottom: 30px;
    }

    .resumen-card {
        background: white;
        border: 1px solid #dce4e9;
        border-radius: 12px;
        padding: 23px 20px;
        text-decoration: none;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .05);
        transition: .2s ease;
    }

    .resumen-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 18px rgba(0, 0, 0, .09);
        border-color: #397da3;
    }

    .resumen-numero {
        color: #2e6f95;
        font-size: 34px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .resumen-info h3 {
        color: #16324f;
        font-size: 18px;
        margin: 0 0 5px 0;
    }

    .resumen-info p {
        color: #778590;
        font-size: 13px;
        margin: 0;
    }


    /*
    =========================================
    TABLAS
    =========================================
    */

    .home-tablas {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 22px;
    }

    .home-card {
        background: white;
        border: 1px solid #dce4e9;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .05);
        min-width: 0;
    }

    .home-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .home-card-header h2 {
        color: #16324f;
        font-size: 21px;
        margin: 0 0 5px 0;
    }

    .home-card-header p {
        color: #7a8791;
        font-size: 13px;
        margin: 0;
    }

    .ver-todos {
        color: #2e6f95;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        white-space: nowrap;
    }

    .ver-todos:hover {
        text-decoration: underline;
    }

    .tabla-home {
        width: 100%;
        overflow-x: auto;
    }

    .tabla-home table {
        width: 100%;
        border-collapse: collapse;
    }

    .tabla-home thead {
        background: #edf2f5;
    }

    .tabla-home th {
        padding: 12px 13px;
        text-align: left;
        color: #16324f;
        font-size: 14px;
        border-bottom: 2px solid #dce4e9;
    }

    .tabla-home td {
        padding: 13px;
        color: #344653;
        font-size: 14px;
        border-bottom: 1px solid #e4e9ed;
        line-height: 1.3;
    }

    .tabla-home tbody tr:hover {
        background: #f7fafc;
    }

    .fecha-home {
        white-space: nowrap;
    }

    .sin-registros {
        text-align: center;
        color: #7a8791 !important;
        padding: 25px !important;
    }


    /*
    =========================================
    RESPONSIVE
    =========================================
    */

    @media(max-width: 1200px) {

        .resumen-grid {
            grid-template-columns: repeat(3, 1fr);
        }

    }

    @media(max-width: 900px) {

        .home-tablas {
            grid-template-columns: 1fr;
        }

        .resumen-grid {
            grid-template-columns: repeat(2, 1fr);
        }

    }

    @media(max-width: 550px) {

        .resumen-grid {
            grid-template-columns: 1fr;
        }

    }

</style>

@endpush