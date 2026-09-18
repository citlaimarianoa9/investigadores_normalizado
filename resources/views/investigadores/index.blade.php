@extends('template')

@section('title', 'Investigadores')

@section('content')

<div class="encabezado">

    <h1>Administración de Investigadores</h1>

    <p>
        Consulta, registra, modifica y administra los investigadores del sistema.
    </p>

</div>


<div class="card">

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))

        <div class="mensaje-exito">
            {{ session('success') }}
        </div>

    @endif


    {{-- BOTÓN Y BUSCADOR --}}
    <div class="acciones-superiores">

        <a
            href="{{ route('investigadores.create') }}"
            class="btn btn-nuevo-modulo">

            + Registrar Investigador

        </a>


        <form
            action="{{ route('investigadores.index') }}"
            method="GET"
            class="buscador"
            id="formBuscar">

            <div class="contenedor-buscador">

                <input
                    type="text"
                    name="buscar"
                    id="buscarInvestigador"
                    placeholder="Buscar investigador..."
                    value="{{ $buscar ?? '' }}"
                    autocomplete="off">

                {{-- RESULTADOS MIENTRAS ESCRIBIMOS --}}
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
                    href="{{ route('investigadores.index') }}"
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

                    <th>Nombre</th>

                    <th>
                        Apellido<br>paterno
                    </th>

                    <th>
                        Apellido<br>materno
                    </th>

                    <th>Carrera</th>

                    <th>Acciones</th>

                </tr>

            </thead>


            <tbody>

                @forelse($investigadores as $investigador)

                    <tr>

                        <td>
                            {{ $investigador->id_investigador }}
                        </td>


                        <td>
                            <strong>
                                {{ $investigador->nombre }}
                            </strong>
                        </td>


                        <td>
                            {{ $investigador->apellido_p }}
                        </td>


                        <td>
                            {{ $investigador->apellido_m }}
                        </td>


                        <td>

                            @if($investigador->carrera)

                                {{ $investigador->carrera->nombre_carrera }}

                            @endif

                        </td>


                        <td>

                            <div class="acciones">

                                <a
                                    href="{{ url('/investigadores/' . $investigador->id_investigador . '/edit') }}"
                                    class="btn btn-editar-nuevo">

                                    Editar

                                </a>


                                <form
                                    action="{{ url('/investigadores/' . $investigador->id_investigador) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="btn btn-eliminar-nuevo"
                                        onclick="return confirm('¿Deseas eliminar este investigador?')">

                                        Eliminar

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="vacio">

                            No se encontraron investigadores.

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

    /* BOTÓN REGISTRAR */

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


    /* BOTÓN BUSCAR */

    .btn-buscar {
        background: #2e6f95;
        color: white;
    }

    .btn-buscar:hover {
        background: #244d70;
    }


    /* BOTÓN LIMPIAR */

    .btn-limpiar {
        background: #667784;
        color: white;
    }

    .btn-limpiar:hover {
        background: #52616c;
        color: white;
    }


    /* EDITAR */

    .btn-editar-nuevo {
        background: #397da3;
        color: white;
        padding: 10px 18px;
    }

    .btn-editar-nuevo:hover {
        background: #285f80;
        color: white;
    }


    /* ELIMINAR */

    .btn-eliminar-nuevo {
        background: #b94a55;
        color: white;
        padding: 10px 18px;
    }

    .btn-eliminar-nuevo:hover {
        background: #963b45;
    }


    /* BUSCADOR */

    .contenedor-buscador {
        position: relative;
        width: 400px;
    }

    .contenedor-buscador input {
        width: 100%;
        height: 44px;
    }


    /* RESULTADOS DEL LIKE */

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

        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);

        z-index: 1000;
    }


    .opcion-investigador {
        padding: 11px 15px;

        cursor: pointer;

        border-bottom: 1px solid #edf1f4;

        color: #16324f;

        background: white;
    }


    .opcion-investigador:hover {
        background: #edf4f8;
    }


    .sin-resultados {
        padding: 12px 15px;

        color: #777;
    }


    /* ACCIONES */

    .acciones {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .acciones form {
        margin: 0;
    }

</style>

@endpush


@push('scripts')

<script>

    const buscarInvestigador =
        document.getElementById('buscarInvestigador');

    const resultadosBusqueda =
        document.getElementById('resultadosBusqueda');


    /*
        Estos investigadores vienen de la colección
        que Laravel obtuvo de la base de datos.
        No se agrega ningún investigador manualmente.
    */

    const investigadores = [

        @foreach($investigadores as $investigador)

            {
                nombre: @json(
                    $investigador->nombre . ' ' .
                    $investigador->apellido_p . ' ' .
                    $investigador->apellido_m
                )
            },

        @endforeach

    ];


    buscarInvestigador.addEventListener('input', function () {

        const texto =
            this.value
                .toLowerCase()
                .trim();


        resultadosBusqueda.innerHTML = '';


        /*
            Si no ha escrito nada,
            no mostramos toda la lista.
        */

        if (texto === '') {

            resultadosBusqueda.style.display = 'none';

            return;

        }


        /*
            Buscamos coincidencias.
            Funciona como LIKE %texto%.
        */

        const coincidencias =
            investigadores.filter(function (investigador) {

                return investigador.nombre
                    .toLowerCase()
                    .includes(texto);

            });


        /*
            Si no existe coincidencia.
        */

        if (coincidencias.length === 0) {

            resultadosBusqueda.innerHTML =
                '<div class="sin-resultados">' +
                'No se encontraron investigadores' +
                '</div>';

            resultadosBusqueda.style.display =
                'block';

            return;

        }


        /*
            Mostrar las coincidencias.
        */

        coincidencias.forEach(function (investigador) {

            const opcion =
                document.createElement('div');


            opcion.className =
                'opcion-investigador';


            opcion.textContent =
                investigador.nombre;


            /*
                Al seleccionar una opción,
                colocamos el nombre en el buscador.
            */

            opcion.addEventListener(
                'click',
                function () {

                    buscarInvestigador.value =
                        investigador.nombre;

                    resultadosBusqueda.style.display =
                        'none';

                    document
                        .getElementById('formBuscar')
                        .submit();

                }
            );


            resultadosBusqueda.appendChild(opcion);

        });


        resultadosBusqueda.style.display =
            'block';

    });


    /*
        Cerrar resultados al hacer clic fuera.
    */

    document.addEventListener('click', function (event) {

        if (!event.target.closest('.contenedor-buscador')) {

            resultadosBusqueda.style.display =
                'none';

        }

    });

</script>

@endpush