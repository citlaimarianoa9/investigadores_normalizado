@extends('template')

@section('title', 'Registrar Productividad')

@section('content')

<div class="encabezado">

    <h1>Registrar Productividad</h1>

    <p>
        Ingresa la información de la nueva productividad.
    </p>

</div>


<div class="card formulario">

    {{-- ERRORES --}}
    @if($errors->any())

        <div class="mensaje-error">

            <strong>
                Revisa la información ingresada:
            </strong>

            <ul>
                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach
            </ul>

        </div>

    @endif


    <form
        action="{{ route('productividades.store') }}"
        method="POST">

        @csrf


        {{-- TÍTULO --}}
        <div class="campo">

            <label for="titulo">
                Título
            </label>

            <input
                type="text"
                id="titulo"
                name="titulo"
                value="{{ old('titulo') }}"
                placeholder="Título de la productividad"
                required>

        </div>


        {{-- FECHA --}}
        <div class="campo">

            <label for="fecha_p">
                Fecha de productividad
            </label>

            <input
                type="date"
                id="fecha_p"
                name="fecha_p"
                value="{{ old('fecha_p') }}"
                required>

        </div>


        {{-- INVESTIGADOR --}}
        <div class="campo">

            <label for="buscarInvestigador">
                Investigador
            </label>

            <div class="busqueda-opciones">

                <input
                    type="text"
                    id="buscarInvestigador"
                    placeholder="Escribe para buscar un investigador..."
                    autocomplete="off">

                {{-- AQUÍ SE GUARDA EL ID REAL --}}
                <input
                    type="hidden"
                    id="id_investigador"
                    name="id_investigador"
                    value="{{ old('id_investigador') }}">

                <div
                    id="resultadosInvestigador"
                    class="resultados-opciones">
                </div>

            </div>

        </div>


        {{-- TIPO DE PRODUCTIVIDAD --}}
        <div class="campo">

            <label for="buscarTipo">
                Tipo de productividad
            </label>

            <div class="busqueda-opciones">

                <input
                    type="text"
                    id="buscarTipo"
                    placeholder="Escribe para buscar un tipo..."
                    autocomplete="off">

                {{-- AQUÍ SE GUARDA EL ID REAL --}}
                <input
                    type="hidden"
                    id="id_tipo"
                    name="id_tipo"
                    value="{{ old('id_tipo') }}">

                <div
                    id="resultadosTipo"
                    class="resultados-opciones">
                </div>

            </div>

        </div>


        {{-- DESCRIPCIÓN --}}
        <div class="campo">

            <label for="descripcion">
                Descripción
            </label>

            <textarea
                id="descripcion"
                name="descripcion"
                rows="5"
                placeholder="Descripción de la productividad"
                required>{{ old('descripcion') }}</textarea>

        </div>


        {{-- BOTONES --}}
        <div class="botones-formulario">

            <button
                type="submit"
                class="btn btn-guardar">

                Guardar Productividad

            </button>


            <a
                href="{{ route('productividades.index') }}"
                class="btn btn-cancelar">

                Cancelar

            </a>

        </div>

    </form>

</div>

@endsection


@push('styles')

<style>

    /* TARJETA DEL FORMULARIO */

    .formulario {
        max-width: 900px;
    }


    /* BOTÓN GUARDAR */

    .btn-guardar {
        background: #2e6f95;
        color: white;
        padding: 11px 20px;
        border: none;
        cursor: pointer;
    }

    .btn-guardar:hover {
        background: #244d70;
        color: white;
    }


    /* BOTÓN CANCELAR */

    .btn-cancelar {
        background: #667784;
        color: white;
        padding: 11px 20px;
    }

    .btn-cancelar:hover {
        background: #52616c;
        color: white;
    }


    /* BOTONES */

    .botones-formulario {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }


    /* TEXTAREA */

    .campo textarea {
        width: 100%;
        resize: vertical;
        min-height: 130px;
    }


    /* CONTENEDOR DE BÚSQUEDA */

    .busqueda-opciones {
        position: relative;
        width: 100%;
    }


    /* RESULTADOS */

    .resultados-opciones {
        display: none;

        position: absolute;

        top: calc(100% + 4px);
        left: 0;

        width: 100%;
        max-height: 230px;

        overflow-y: auto;

        background: white;

        border: 1px solid #ccd5dc;
        border-radius: 7px;

        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);

        z-index: 1000;
    }


    /* CADA OPCIÓN */

    .opcion-busqueda {
        padding: 11px 15px;

        cursor: pointer;

        border-bottom: 1px solid #edf1f4;

        color: #16324f;

        background: white;
    }

    .opcion-busqueda:hover {
        background: #edf4f8;
    }


    /* SIN RESULTADOS */

    .sin-resultados {
        padding: 12px 15px;
        color: #777;
    }

</style>

@endpush


@push('scripts')

<script>

    /*
    ==================================================
    INVESTIGADORES
    ==================================================
    */

    const buscarInvestigador =
        document.getElementById('buscarInvestigador');

    const idInvestigador =
        document.getElementById('id_investigador');

    const resultadosInvestigador =
        document.getElementById('resultadosInvestigador');


    /*
        Únicamente investigadores que Laravel
        obtuvo de la base de datos.
    */

    const investigadores = [

        @foreach($investigadores as $investigador)

            {
                id: @json($investigador->id_investigador),

                nombre: @json(
                    $investigador->nombre . ' ' .
                    $investigador->apellido_p . ' ' .
                    $investigador->apellido_m
                )
            },

        @endforeach

    ];


    buscarInvestigador.addEventListener(
        'input',
        function () {

            const texto =
                this.value
                    .toLowerCase()
                    .trim();


            resultadosInvestigador.innerHTML = '';

            /*
                Si vuelve a escribir,
                quitamos el ID seleccionado anteriormente.
            */

            idInvestigador.value = '';


            /*
                No mostrar toda la lista si
                todavía no ha escrito.
            */

            if (texto === '') {

                resultadosInvestigador.style.display =
                    'none';

                return;

            }


            /*
                Búsqueda tipo LIKE %texto%
            */

            const coincidencias =
                investigadores.filter(
                    function (investigador) {

                        return investigador.nombre
                            .toLowerCase()
                            .includes(texto);

                    }
                );


            if (coincidencias.length === 0) {

                resultadosInvestigador.innerHTML =
                    '<div class="sin-resultados">' +
                    'No se encontraron investigadores' +
                    '</div>';

                resultadosInvestigador.style.display =
                    'block';

                return;

            }


            coincidencias.forEach(
                function (investigador) {

                    const opcion =
                        document.createElement('div');


                    opcion.className =
                        'opcion-busqueda';


                    opcion.textContent =
                        investigador.nombre;


                    opcion.addEventListener(
                        'click',
                        function () {

                            buscarInvestigador.value =
                                investigador.nombre;

                            idInvestigador.value =
                                investigador.id;

                            resultadosInvestigador.style.display =
                                'none';

                        }
                    );


                    resultadosInvestigador
                        .appendChild(opcion);

                }
            );


            resultadosInvestigador.style.display =
                'block';

        }
    );


    /*
    ==================================================
    TIPOS
    ==================================================
    */

    const buscarTipo =
        document.getElementById('buscarTipo');

    const idTipo =
        document.getElementById('id_tipo');

    const resultadosTipo =
        document.getElementById('resultadosTipo');


    /*
        Únicamente tipos obtenidos
        desde la tabla tipos.
    */

    const tipos = [

        @foreach($tipos as $tipo)

            {
                id: @json($tipo->id_tipo),
                nombre: @json($tipo->desc_tipo)
            },

        @endforeach

    ];


    buscarTipo.addEventListener(
        'input',
        function () {

            const texto =
                this.value
                    .toLowerCase()
                    .trim();


            resultadosTipo.innerHTML = '';

            idTipo.value = '';


            /*
                No mostrar todos los tipos
                si todavía no escribe.
            */

            if (texto === '') {

                resultadosTipo.style.display =
                    'none';

                return;

            }


            /*
                Búsqueda tipo LIKE %texto%
            */

            const coincidencias =
                tipos.filter(
                    function (tipo) {

                        return tipo.nombre
                            .toLowerCase()
                            .includes(texto);

                    }
                );


            if (coincidencias.length === 0) {

                resultadosTipo.innerHTML =
                    '<div class="sin-resultados">' +
                    'No se encontraron tipos' +
                    '</div>';

                resultadosTipo.style.display =
                    'block';

                return;

            }


            coincidencias.forEach(
                function (tipo) {

                    const opcion =
                        document.createElement('div');


                    opcion.className =
                        'opcion-busqueda';


                    opcion.textContent =
                        tipo.nombre;


                    opcion.addEventListener(
                        'click',
                        function () {

                            buscarTipo.value =
                                tipo.nombre;

                            idTipo.value =
                                tipo.id;

                            resultadosTipo.style.display =
                                'none';

                        }
                    );


                    resultadosTipo
                        .appendChild(opcion);

                }
            );


            resultadosTipo.style.display =
                'block';

        }
    );


    /*
    ==================================================
    CERRAR RESULTADOS
    ==================================================
    */

    document.addEventListener(
        'click',
        function (event) {

            if (
                !event.target.closest(
                    '.busqueda-opciones'
                )
            ) {

                resultadosInvestigador.style.display =
                    'none';

                resultadosTipo.style.display =
                    'none';

            }

        }
    );

</script>

@endpush