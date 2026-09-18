@extends('template')

@section('title', 'Editar Productividad')

@section('content')

<div class="encabezado">

    <h1>Editar Productividad</h1>

    <p>
        Modifica la información de la productividad seleccionada.
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

                    <li>{{ $error }}</li>

                @endforeach
            </ul>

        </div>

    @endif


    <form
        action="{{ url('/productividades/' . $productividad->id_productividad) }}"
        method="POST">

        @csrf
        @method('PUT')


        {{-- TÍTULO --}}
        <div class="campo">

            <label for="titulo">
                Título
            </label>

            <input
                type="text"
                id="titulo"
                name="titulo"
                value="{{ old('titulo', $productividad->titulo) }}"
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
                value="{{ old('fecha_p', $productividad->fecha_p) }}"
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
                    value="{{ old(
                        'nombre_investigador',
                        $productividad->investigador
                            ? $productividad->investigador->nombre . ' ' .
                              $productividad->investigador->apellido_p . ' ' .
                              $productividad->investigador->apellido_m
                            : ''
                    ) }}"
                    placeholder="Escribe para buscar un investigador..."
                    autocomplete="off">

                <input
                    type="hidden"
                    id="id_investigador"
                    name="id_investigador"
                    value="{{ old(
                        'id_investigador',
                        $productividad->id_investigador
                    ) }}">

                <div
                    id="resultadosInvestigador"
                    class="resultados-opciones">
                </div>

            </div>

        </div>


        {{-- TIPO --}}
        <div class="campo">

            <label for="buscarTipo">
                Tipo de productividad
            </label>

            <div class="busqueda-opciones">

                <input
                    type="text"
                    id="buscarTipo"
                    value="{{ old(
                        'nombre_tipo',
                        $productividad->tipo
                            ? $productividad->tipo->desc_tipo
                            : ''
                    ) }}"
                    placeholder="Escribe para buscar un tipo..."
                    autocomplete="off">

                <input
                    type="hidden"
                    id="id_tipo"
                    name="id_tipo"
                    value="{{ old(
                        'id_tipo',
                        $productividad->id_tipo
                    ) }}">

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
                required>{{ old('descripcion', $productividad->descripcion) }}</textarea>

        </div>


        {{-- BOTONES --}}
        <div class="botones-formulario">

            <button
                type="submit"
                class="btn btn-guardar">

                Actualizar Productividad

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

    /* FORMULARIO */

    .formulario {
        max-width: 900px;
    }


    /* BOTÓN ACTUALIZAR */

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

        min-height: 130px;

        resize: vertical;
    }


    /* CONTENEDOR DE BÚSQUEDA */

    .busqueda-opciones {
        position: relative;

        width: 100%;
    }


    /* LISTA DE RESULTADOS */

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

        box-shadow:
            0 5px 15px rgba(0, 0, 0, 0.12);

        z-index: 1000;
    }


    /* OPCIÓN */

    .opcion-busqueda {

        padding: 11px 15px;

        cursor: pointer;

        border-bottom:
            1px solid #edf1f4;

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
    BUSCADOR DE INVESTIGADORES
    ==================================================
    */

    const buscarInvestigador =
        document.getElementById(
            'buscarInvestigador'
        );

    const idInvestigador =
        document.getElementById(
            'id_investigador'
        );

    const resultadosInvestigador =
        document.getElementById(
            'resultadosInvestigador'
        );


    /*
        Los datos de aquí vienen de
        $investigadores, es decir, de tu BD.
    */

    const investigadores = [

        @foreach($investigadores as $investigador)

            {
                id: @json(
                    $investigador->id_investigador
                ),

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


            resultadosInvestigador.innerHTML =
                '';


            /*
                Como el usuario comenzó a modificar
                el texto, quitamos temporalmente el ID.
            */

            idInvestigador.value = '';


            if (texto === '') {

                resultadosInvestigador.style.display =
                    'none';

                return;

            }


            /*
                Coincidencia tipo LIKE %texto%
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
                        document.createElement(
                            'div'
                        );


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

                            resultadosInvestigador
                                .style.display =
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
    BUSCADOR DE TIPOS
    ==================================================
    */

    const buscarTipo =
        document.getElementById(
            'buscarTipo'
        );

    const idTipo =
        document.getElementById(
            'id_tipo'
        );

    const resultadosTipo =
        document.getElementById(
            'resultadosTipo'
        );


    /*
        Estos datos vienen únicamente
        de la tabla tipos.
    */

    const tipos = [

        @foreach($tipos as $tipo)

            {
                id: @json(
                    $tipo->id_tipo
                ),

                nombre: @json(
                    $tipo->desc_tipo
                )
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


            resultadosTipo.innerHTML =
                '';


            idTipo.value = '';


            if (texto === '') {

                resultadosTipo.style.display =
                    'none';

                return;

            }


            /*
                Coincidencia tipo LIKE %texto%
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
                        document.createElement(
                            'div'
                        );


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

                            resultadosTipo
                                .style.display =
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
    CERRAR LAS OPCIONES AL HACER CLIC FUERA
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

                resultadosInvestigador
                    .style.display =
                    'none';

                resultadosTipo
                    .style.display =
                    'none';

            }

        }
    );

</script>

@endpush