@extends('template')

@section('title', 'Asignaciones')

@section('content')

<div class="encabezado">

    <h1>Administración de Asignaciones</h1>

    <p>
        Consulta, registra, modifica y administra
        las asignaciones del sistema.
    </p>

</div>


<div class="card">

    {{-- MENSAJE --}}
    @if(session('success'))

        <div class="mensaje-exito">
            {{ session('success') }}
        </div>

    @endif


    {{-- ACCIONES --}}
    <div class="acciones-superiores">

        <a
            href="{{ route('asignarinvestigadores.create') }}"
            class="btn btn-nuevo-modulo">

            + Registrar Asignación

        </a>


        <form
            action="{{ route('asignarinvestigadores.index') }}"
            method="GET"
            class="buscador"
            id="formBuscar">

            <div class="contenedor-buscador">

                <input
                    type="text"
                    name="buscar"
                    id="buscarAsignacion"
                    value="{{ $buscar ?? '' }}"
                    placeholder="Buscar investigador o productividad..."
                    autocomplete="off">

                <div
                    id="resultadosBusqueda"
                    class="resultados-busqueda">
                </div>

            </div>


            <button
                type="submit"
                class="btn btn-buscar">

                Buscar

            </button>


            @if(!empty($buscar))

                <a
                    href="{{ route('asignarinvestigadores.index') }}"
                    class="btn btn-limpiar">

                    Limpiar

                </a>

            @endif

        </form>

    </div>


    {{-- TABLA --}}
    <div class="tabla-responsive">

        <table>

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Productividad</th>

                    <th>Investigador</th>

                    <th>Acciones</th>

                </tr>

            </thead>


            <tbody>

                @forelse($asignaciones as $asignacion)

                    <tr>

                        <td>
                            {{ $asignacion->id_asigna }}
                        </td>


                        <td>

                            @if($asignacion->productividad)

                                <strong>
                                    {{ $asignacion->productividad->titulo }}
                                </strong>

                            @endif

                        </td>


                        <td>

                            @if($asignacion->investigador)

                                {{ $asignacion->investigador->nombre }}

                                {{ $asignacion->investigador->apellido_p }}

                                {{ $asignacion->investigador->apellido_m }}

                            @endif

                        </td>


                        <td>

                            <div class="acciones">

                                <a
                                    href="{{ url('/asignarinvestigadores/' . $asignacion->id_asigna . '/edit') }}"
                                    class="btn btn-editar-nuevo">

                                    Editar

                                </a>


                                <form
                                    action="{{ url('/asignarinvestigadores/' . $asignacion->id_asigna) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="btn btn-eliminar-nuevo"
                                        onclick="return confirm('¿Deseas eliminar esta asignación?')">

                                        Eliminar

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
                            class="vacio">

                            No se encontraron asignaciones.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection


@push('styles')

<style>

    .btn-nuevo-modulo {
        background: #2e6f95;
        color: white;
        padding: 12px 20px;
        font-weight: 500;
    }

    .btn-nuevo-modulo:hover {
        background: #244d70;
        color: white;
    }


    .btn-buscar {
        background: #2e6f95;
        color: white;
    }

    .btn-buscar:hover {
        background: #244d70;
        color: white;
    }


    .btn-limpiar {
        background: #667784;
        color: white;
    }

    .btn-limpiar:hover {
        background: #52616c;
        color: white;
    }


    .btn-editar-nuevo {
        background: #397da3;
        color: white;
        padding: 10px 18px;
    }

    .btn-editar-nuevo:hover {
        background: #285f80;
        color: white;
    }


    .btn-eliminar-nuevo {
        background: #b94a55;
        color: white;
        padding: 10px 18px;
    }

    .btn-eliminar-nuevo:hover {
        background: #963b45;
    }


    .acciones {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .acciones form {
        margin: 0;
    }


    .contenedor-buscador {
        position: relative;
        width: 400px;
    }

    .contenedor-buscador input {
        width: 100%;
        height: 44px;
    }


    .resultados-busqueda {
        display: none;

        position: absolute;

        top: calc(100% + 4px);
        left: 0;

        width: 100%;
        max-height: 250px;

        overflow-y: auto;

        background: white;

        border: 1px solid #ccd5dc;
        border-radius: 7px;

        box-shadow:
            0 5px 15px rgba(0,0,0,.12);

        z-index: 1000;
    }


    .opcion-asignacion {
        padding: 11px 15px;

        cursor: pointer;

        border-bottom:
            1px solid #edf1f4;

        color: #16324f;

        background: white;
    }


    .opcion-asignacion:hover {
        background: #edf4f8;
    }


    .sin-resultados {
        padding: 12px 15px;
        color: #777;
    }

</style>

@endpush


@push('scripts')

<script>

    const buscarAsignacion =
        document.getElementById('buscarAsignacion');

    const resultadosBusqueda =
        document.getElementById('resultadosBusqueda');


    /*
        SOLO ASIGNACIONES QUE LLEGARON
        DESDE LA BASE DE DATOS.
    */

    const asignaciones = [

        @foreach($asignaciones as $asignacion)

            {
                productividad: @json(
                    $asignacion->productividad
                        ? $asignacion->productividad->titulo
                        : ''
                ),

                investigador: @json(
                    $asignacion->investigador
                        ? $asignacion->investigador->nombre . ' ' .
                          $asignacion->investigador->apellido_p . ' ' .
                          $asignacion->investigador->apellido_m
                        : ''
                )
            },

        @endforeach

    ];


    buscarAsignacion.addEventListener(
        'input',
        function () {

            const texto =
                this.value
                    .toLowerCase()
                    .trim();


            resultadosBusqueda.innerHTML = '';


            if (texto === '') {

                resultadosBusqueda.style.display =
                    'none';

                return;

            }


            const coincidencias =
                asignaciones.filter(
                    function (asignacion) {

                        return (
                            asignacion.productividad
                                .toLowerCase()
                                .includes(texto)
                            ||
                            asignacion.investigador
                                .toLowerCase()
                                .includes(texto)
                        );

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
                function (asignacion) {

                    const opcion =
                        document.createElement('div');


                    opcion.className =
                        'opcion-asignacion';


                    opcion.textContent =
                        asignacion.productividad +
                        ' - ' +
                        asignacion.investigador;


                    opcion.addEventListener(
                        'click',
                        function () {

                            buscarAsignacion.value =
                                asignacion.investigador;

                            resultadosBusqueda.style.display =
                                'none';


                            document
                                .getElementById('formBuscar')
                                .submit();

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