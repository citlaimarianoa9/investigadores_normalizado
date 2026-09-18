@extends('template')

@section('title', 'Reportes')

@section('content')

<div class="encabezado">
    <h1>Reportes</h1>
    <p>
        Consulta y genera reportes con la información registrada en el sistema.
    </p>
</div>


{{-- ===================================================== --}}
{{-- PANEL DE FILTROS --}}
{{-- ===================================================== --}}

<div class="card panel-reportes">

    <div class="titulo-filtros">
        <h2>Generar Reporte</h2>
        <p>Selecciona el tipo de reporte y escribe el dato que deseas consultar.</p>
    </div>


    <form
        action="{{ route('reportes.index') }}"
        method="GET"
        id="formReporte">

        <div class="filtros-reporte">

            {{-- TIPO DE REPORTE --}}
            <div class="campo-reporte">

                <label for="tipo_reporte">
                    Tipo de reporte
                </label>

                <select
                    name="tipo_reporte"
                    id="tipo_reporte"
                    required>

                    <option value="">
                        Selecciona un reporte
                    </option>

                    <option
                        value="investigador"
                        {{ $tipoReporte == 'investigador' ? 'selected' : '' }}>

                        Productividades por investigador

                    </option>

                    <option
                        value="carrera"
                        {{ $tipoReporte == 'carrera' ? 'selected' : '' }}>

                        Productividades por carrera

                    </option>

                    <option
                        value="tipo"
                        {{ $tipoReporte == 'tipo' ? 'selected' : '' }}>

                        Productividades por tipo

                    </option>

                    <option
                        value="productividad"
                        {{ $tipoReporte == 'productividad' ? 'selected' : '' }}>

                        Investigadores por productividad

                    </option>

                </select>

            </div>


            {{-- BUSCADOR --}}
            <div class="campo-reporte">

                <label for="buscarReporte">
                    Buscar
                </label>

                <div class="contenedor-buscador">

                    <input
                        type="text"
                        name="buscar"
                        id="buscarReporte"
                        value="{{ $buscar ?? '' }}"
                        placeholder="Escribe para buscar..."
                        autocomplete="off">

                    <div
                        id="resultadosBusqueda"
                        class="resultados-busqueda">
                    </div>

                </div>

            </div>

        </div>


        {{-- BOTONES --}}
        <div class="botones-reporte">

            <button
                type="submit"
                class="btn btn-generar">

                Generar Reporte

            </button>


            @if($tipoReporte)

                <a
                    href="{{ route('reportes.index') }}"
                    class="btn btn-limpiar">

                    Limpiar

                </a>

            @endif


            @if($tipoReporte && $resultados->count() > 0)

                <button
                    type="button"
                    class="btn btn-imprimir"
                    onclick="window.print()">

                    Imprimir Reporte

                </button>

            @endif

        </div>

    </form>

</div>



{{-- ===================================================== --}}
{{-- RESULTADOS --}}
{{-- ===================================================== --}}

@if($tipoReporte)

<div class="card reporte-resultados">

    {{-- ENCABEZADO DEL REPORTE --}}
    <div class="encabezado-reporte">

        <div>

            @if($tipoReporte == 'investigador')

                <h2>
                    Productividades por Investigador
                </h2>

            @elseif($tipoReporte == 'carrera')

                <h2>
                    Productividades por Carrera
                </h2>

            @elseif($tipoReporte == 'tipo')

                <h2>
                    Productividades por Tipo
                </h2>

            @elseif($tipoReporte == 'productividad')

                <h2>
                    Investigadores por Productividad
                </h2>

            @endif


            @if(!empty($buscar))

                <p class="filtro-aplicado">

                    Filtro:

                    <strong>
                        {{ $buscar }}
                    </strong>

                </p>

            @else

                <p class="filtro-aplicado">
                    Mostrando todos los registros
                </p>

            @endif

        </div>


        <div class="total-resultados">

            {{ $resultados->count() }}

            @if($resultados->count() == 1)
                resultado
            @else
                resultados
            @endif

        </div>

    </div>



    {{-- ================================================= --}}
    {{-- PRODUCTIVIDADES POR INVESTIGADOR --}}
    {{-- ================================================= --}}

    @if($tipoReporte == 'investigador')

        <div class="tabla-responsive">

            <table class="tabla-reporte">

                <thead>

                    <tr>
                        <th>Investigador</th>
                        <th>Carrera</th>
                        <th>Productividad</th>
                        <th>Tipo</th>
                        <th class="columna-fecha">Fecha</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($resultados as $resultado)

                        <tr>

                            <td>

                                @if($resultado->investigador)

                                    <strong>
                                        {{ $resultado->investigador->nombre }}
                                        {{ $resultado->investigador->apellido_p }}
                                        {{ $resultado->investigador->apellido_m }}
                                    </strong>

                                @endif

                            </td>


                            <td>

                                @if(
                                    $resultado->investigador &&
                                    $resultado->investigador->carrera
                                )

                                    {{ $resultado
                                        ->investigador
                                        ->carrera
                                        ->nombre_carrera }}

                                @endif

                            </td>


                            <td>
                                {{ $resultado->titulo }}
                            </td>


                            <td>

                                @if($resultado->tipo)

                                    {{ $resultado->tipo->desc_tipo }}

                                @endif

                            </td>


                            <td class="columna-fecha">
                                {{ $resultado->fecha_p }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="sin-datos">

                                No se encontraron resultados.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    @endif



    {{-- ================================================= --}}
    {{-- PRODUCTIVIDADES POR CARRERA --}}
    {{-- ================================================= --}}

    @if($tipoReporte == 'carrera')

        <div class="tabla-responsive">

            <table class="tabla-reporte">

                <thead>

                    <tr>
                        <th>Carrera</th>
                        <th>Investigador</th>
                        <th>Productividad</th>
                        <th>Tipo</th>
                        <th class="columna-fecha">Fecha</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($resultados as $resultado)

                        <tr>

                            <td>

                                @if(
                                    $resultado->investigador &&
                                    $resultado->investigador->carrera
                                )

                                    <strong>
                                        {{ $resultado
                                            ->investigador
                                            ->carrera
                                            ->nombre_carrera }}
                                    </strong>

                                @endif

                            </td>


                            <td>

                                @if($resultado->investigador)

                                    {{ $resultado->investigador->nombre }}
                                    {{ $resultado->investigador->apellido_p }}
                                    {{ $resultado->investigador->apellido_m }}

                                @endif

                            </td>


                            <td>
                                {{ $resultado->titulo }}
                            </td>


                            <td>

                                @if($resultado->tipo)

                                    {{ $resultado->tipo->desc_tipo }}

                                @endif

                            </td>


                            <td class="columna-fecha">
                                {{ $resultado->fecha_p }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="sin-datos">

                                No se encontraron resultados.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    @endif



    {{-- ================================================= --}}
    {{-- PRODUCTIVIDADES POR TIPO --}}
    {{-- ================================================= --}}

    @if($tipoReporte == 'tipo')

        <div class="tabla-responsive">

            <table class="tabla-reporte">

                <thead>

                    <tr>
                        <th>Tipo</th>
                        <th>Productividad</th>
                        <th>Investigador</th>
                        <th class="columna-fecha">Fecha</th>
                        <th>Descripción</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($resultados as $resultado)

                        <tr>

                            <td>

                                @if($resultado->tipo)

                                    <strong>
                                        {{ $resultado->tipo->desc_tipo }}
                                    </strong>

                                @endif

                            </td>


                            <td>
                                {{ $resultado->titulo }}
                            </td>


                            <td>

                                @if($resultado->investigador)

                                    {{ $resultado->investigador->nombre }}
                                    {{ $resultado->investigador->apellido_p }}
                                    {{ $resultado->investigador->apellido_m }}

                                @endif

                            </td>


                            <td class="columna-fecha">
                                {{ $resultado->fecha_p }}
                            </td>


                            <td>
                                {{ $resultado->descripcion }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="sin-datos">

                                No se encontraron resultados.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    @endif



    {{-- ================================================= --}}
    {{-- INVESTIGADORES POR PRODUCTIVIDAD --}}
    {{-- ================================================= --}}

    @if($tipoReporte == 'productividad')

        <div class="tabla-responsive">

            <table class="tabla-reporte">

                <thead>

                    <tr>
                        <th>Productividad</th>
                        <th>Investigador</th>
                        <th>Carrera</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($resultados as $resultado)

                        <tr>

                            <td>

                                @if($resultado->productividad)

                                    <strong>
                                        {{ $resultado
                                            ->productividad
                                            ->titulo }}
                                    </strong>

                                @endif

                            </td>


                            <td>

                                @if($resultado->investigador)

                                    {{ $resultado->investigador->nombre }}
                                    {{ $resultado->investigador->apellido_p }}
                                    {{ $resultado->investigador->apellido_m }}

                                @endif

                            </td>


                            <td>

                                @if(
                                    $resultado->investigador &&
                                    $resultado->investigador->carrera
                                )

                                    {{ $resultado
                                        ->investigador
                                        ->carrera
                                        ->nombre_carrera }}

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="3"
                                class="sin-datos">

                                No se encontraron resultados.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    @endif

</div>

@endif

@endsection



{{-- ===================================================== --}}
{{-- ESTILOS --}}
{{-- ===================================================== --}}

@push('styles')

<style>

    /*
    =========================================
    PANEL DE FILTROS
    =========================================
    */

    .panel-reportes {
        padding: 28px 32px;
    }


    .titulo-filtros {
        margin-bottom: 25px;
    }


    .titulo-filtros h2 {
        margin: 0 0 6px 0;

        color: #16324f;

        font-size: 22px;
    }


    .titulo-filtros p {
        margin: 0;

        color: #6c7a86;

        font-size: 15px;
    }


    /*
    =========================================
    FILTROS
    =========================================
    */

    .filtros-reporte {

        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 25px;
    }


    .campo-reporte {

        display: flex;

        flex-direction: column;

        gap: 8px;
    }


    .campo-reporte label {

        color: #16324f;

        font-weight: 600;

        font-size: 16px;
    }


    .campo-reporte select,
    .campo-reporte input {

        width: 100%;

        height: 50px;

        padding: 0 15px;

        border:
            1px solid #cbd5dd;

        border-radius: 8px;

        background: white;

        color: #1f2933;

        font-size: 16px;

        outline: none;

        box-sizing: border-box;

        transition:
            border-color .2s,
            box-shadow .2s;
    }


    .campo-reporte select:focus,
    .campo-reporte input:focus {

        border-color: #397da3;

        box-shadow:
            0 0 0 3px
            rgba(57, 125, 163, .12);
    }


    /*
    =========================================
    BOTONES
    =========================================
    */

    .botones-reporte {

        display: flex;

        flex-wrap: wrap;

        align-items: center;

        gap: 12px;

        margin-top: 25px;
    }


    .btn-generar {

        background: #2e6f95;

        color: white;

        padding: 12px 21px;

        border: none;

        border-radius: 7px;

        cursor: pointer;

        font-weight: 500;
    }


    .btn-generar:hover {

        background: #244d70;

        color: white;
    }


    .btn-limpiar {

        background: #667784;

        color: white;

        padding: 12px 21px;

        border-radius: 7px;
    }


    .btn-limpiar:hover {

        background: #52616c;

        color: white;
    }


    .btn-imprimir {

        background: #397da3;

        color: white;

        padding: 12px 21px;

        border: none;

        border-radius: 7px;

        cursor: pointer;

        font-weight: 500;
    }


    .btn-imprimir:hover {

        background: #285f80;

        color: white;
    }


    /*
    =========================================
    REPORTE
    =========================================
    */

    .reporte-resultados {

        margin-top: 28px;

        padding: 32px;
    }


    .encabezado-reporte {

        display: flex;

        justify-content: space-between;

        align-items: center;

        gap: 20px;

        margin-bottom: 25px;

        padding-bottom: 18px;

        border-bottom:
            1px solid #dce4e9;
    }


    .encabezado-reporte h2 {

        margin: 0 0 8px 0;

        color: #16324f;

        font-size: 26px;
    }


    .filtro-aplicado {

        margin: 0;

        color: #64727e;

        font-size: 15px;
    }


    .filtro-aplicado strong {

        color: #16324f;
    }


    /*
    =========================================
    CONTADOR
    =========================================
    */

    .total-resultados {

        flex-shrink: 0;

        background: #edf4f8;

        color: #2e6f95;

        padding: 9px 15px;

        border-radius: 20px;

        font-weight: 600;

        font-size: 14px;
    }


    /*
    =========================================
    TABLA
    =========================================
    */

    .tabla-responsive {

        width: 100%;

        overflow-x: auto;
    }


    .tabla-reporte {

        width: 100%;

        border-collapse: collapse;

        table-layout: auto;
    }


    .tabla-reporte thead {

        background: #eaf0f4;
    }


    .tabla-reporte th {

        padding: 15px 16px;

        text-align: left;

        color: #16324f;

        font-size: 15px;

        font-weight: 600;

        border-bottom:
            2px solid #d7e0e6;
    }


    .tabla-reporte td {

        padding: 16px;

        color: #263746;

        vertical-align: middle;

        border-bottom:
            1px solid #e1e7eb;

        line-height: 1.35;
    }


    .tabla-reporte tbody tr {

        transition:
            background-color .15s;
    }


    .tabla-reporte tbody tr:hover {

        background: #f7fafc;
    }


    /*
    =========================================
    FECHA EN UNA SOLA LÍNEA
    =========================================
    */

    .columna-fecha {

        white-space: nowrap;

        min-width: 110px;
    }


    /*
    =========================================
    SIN DATOS
    =========================================
    */

    .sin-datos {

        text-align: center !important;

        padding: 35px !important;

        color: #75838e !important;
    }


    /*
    =========================================
    AUTOCOMPLETADO
    =========================================
    */

    .contenedor-buscador {

        position: relative;

        width: 100%;
    }


    .resultados-busqueda {

        display: none;

        position: absolute;

        top: calc(100% + 5px);

        left: 0;

        width: 100%;

        max-height: 250px;

        overflow-y: auto;

        background: white;

        border:
            1px solid #ccd5dc;

        border-radius: 8px;

        box-shadow:
            0 8px 20px
            rgba(0, 0, 0, .12);

        z-index: 1000;
    }


    .opcion-reporte {

        padding: 12px 15px;

        cursor: pointer;

        color: #16324f;

        border-bottom:
            1px solid #edf1f4;
    }


    .opcion-reporte:last-child {

        border-bottom: none;
    }


    .opcion-reporte:hover {

        background: #edf4f8;
    }


    .sin-resultados {

        padding: 13px 15px;

        color: #777;
    }


    /*
    =========================================
    RESPONSIVE
    =========================================
    */

    @media(max-width: 800px) {

        .filtros-reporte {

            grid-template-columns: 1fr;
        }


        .encabezado-reporte {

            align-items: flex-start;

            flex-direction: column;
        }


        .panel-reportes,
        .reporte-resultados {

            padding: 20px;
        }

    }


    /*
    =========================================
    IMPRESIÓN
    =========================================
    */

    @media print {

        .panel-reportes,
        .encabezado,
        nav,
        header {

            display: none !important;
        }


        body {

            background: white !important;
        }


        .reporte-resultados {

            margin: 0;

            padding: 0;

            border: none;

            box-shadow: none;
        }


        .encabezado-reporte {

            border-bottom:
                2px solid #333;
        }


        .total-resultados {

            border:
                1px solid #999;

            background: white;
        }


        .tabla-reporte {

            font-size: 12px;
        }


        .tabla-reporte th,
        .tabla-reporte td {

            padding: 9px;

            border:
                1px solid #bbb;
        }


        .tabla-reporte tbody tr:hover {

            background: transparent;
        }


        .columna-fecha {

            white-space: nowrap;
        }

    }

</style>

@endpush



{{-- ===================================================== --}}
{{-- JAVASCRIPT --}}
{{-- ===================================================== --}}

@push('scripts')

<script>

    const tipoReporte =
        document.getElementById('tipo_reporte');

    const buscarReporte =
        document.getElementById('buscarReporte');

    const resultadosBusqueda =
        document.getElementById('resultadosBusqueda');


    /*
    ==============================================
    DATOS DE LA BASE DE DATOS
    ==============================================
    */

    const investigadores = [

        @foreach($investigadores as $investigador)

            @json(
                $investigador->nombre . ' ' .
                $investigador->apellido_p . ' ' .
                $investigador->apellido_m
            ),

        @endforeach

    ];


    const carreras = [

        @foreach($carreras as $carrera)

            @json($carrera->nombre_carrera),

        @endforeach

    ];


    const tipos = [

        @foreach($tipos as $tipo)

            @json($tipo->desc_tipo),

        @endforeach

    ];


    const productividades = [

        @foreach($productividades as $productividad)

            @json($productividad->titulo),

        @endforeach

    ];


    /*
    ==============================================
    CAMBIAR TEXTO DEL BUSCADOR
    ==============================================
    */

    function actualizarPlaceholder() {

        if (tipoReporte.value === 'investigador') {

            buscarReporte.placeholder =
                'Escribe el nombre del investigador...';

        }

        else if (tipoReporte.value === 'carrera') {

            buscarReporte.placeholder =
                'Escribe el nombre de la carrera...';

        }

        else if (tipoReporte.value === 'tipo') {

            buscarReporte.placeholder =
                'Escribe el tipo de productividad...';

        }

        else if (tipoReporte.value === 'productividad') {

            buscarReporte.placeholder =
                'Escribe el título de la productividad...';

        }

        else {

            buscarReporte.placeholder =
                'Primero selecciona un tipo de reporte...';

        }

    }


    actualizarPlaceholder();


    tipoReporte.addEventListener(
        'change',
        function () {

            buscarReporte.value = '';

            resultadosBusqueda.style.display =
                'none';

            actualizarPlaceholder();

        }
    );


    /*
    ==============================================
    BUSCADOR
    ==============================================
    */

    buscarReporte.addEventListener(
        'input',
        function () {

            const texto =
                this.value
                    .toLowerCase()
                    .trim();


            resultadosBusqueda.innerHTML = '';


            if (
                texto === '' ||
                tipoReporte.value === ''
            ) {

                resultadosBusqueda.style.display =
                    'none';

                return;

            }


            let datos = [];


            if (tipoReporte.value === 'investigador') {

                datos = investigadores;

            }

            else if (tipoReporte.value === 'carrera') {

                datos = carreras;

            }

            else if (tipoReporte.value === 'tipo') {

                datos = tipos;

            }

            else if (tipoReporte.value === 'productividad') {

                datos = productividades;

            }


            /*
                COINCIDENCIAS TIPO LIKE
            */

            const coincidencias =
                datos.filter(
                    function (dato) {

                        return dato
                            .toLowerCase()
                            .includes(texto);

                    }
                );


            if (coincidencias.length === 0) {

                resultadosBusqueda.innerHTML =
                    '<div class="sin-resultados">' +
                    'No se encontraron coincidencias' +
                    '</div>';

                resultadosBusqueda.style.display =
                    'block';

                return;

            }


            coincidencias.forEach(
                function (dato) {

                    const opcion =
                        document.createElement('div');


                    opcion.className =
                        'opcion-reporte';


                    opcion.textContent =
                        dato;


                    opcion.addEventListener(
                        'click',
                        function () {

                            buscarReporte.value =
                                dato;

                            resultadosBusqueda
                                .style.display =
                                'none';

                        }
                    );


                    resultadosBusqueda
                        .appendChild(opcion);

                }
            );


            resultadosBusqueda.style.display =
                'block';

        }
    );


    /*
    ==============================================
    CERRAR RESULTADOS
    ==============================================
    */

    document.addEventListener(
        'click',
        function (event) {

            if (
                !event.target.closest(
                    '.contenedor-buscador'
                )
            ) {

                resultadosBusqueda.style.display =
                    'none';

            }

        }
    );

</script>

@endpush