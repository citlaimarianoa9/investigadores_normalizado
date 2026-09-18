@extends('template')

@section('title', 'Registrar Asignación')

@section('content')

<div class="encabezado">

    <h1>Registrar Asignación</h1>

    <p>
        Selecciona una productividad y el investigador
        que será asignado.
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
        action="{{ route('asignarinvestigadores.store') }}"
        method="POST">

        @csrf


        {{-- PRODUCTIVIDAD --}}
        <div class="campo">

            <label for="buscarProductividad">
                Productividad
            </label>


            <div class="busqueda-opciones">

                <input
                    type="text"
                    id="buscarProductividad"
                    placeholder="Escribe para buscar una productividad..."
                    autocomplete="off">


                <input
                    type="hidden"
                    id="id_productividad"
                    name="id_productividad"
                    value="{{ old('id_productividad') }}">


                <div
                    id="resultadosProductividad"
                    class="resultados-opciones">
                </div>

            </div>

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


        {{-- BOTONES --}}
        <div class="botones-formulario">

            <button
                type="submit"
                class="btn btn-guardar">

                Guardar Asignación

            </button>


            <a
                href="{{ route('asignarinvestigadores.index') }}"
                class="btn btn-cancelar">

                Cancelar

            </a>

        </div>

    </form>

</div>

@endsection


@push('styles')

<style>

    .formulario {
        max-width: 900px;
    }


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


    .btn-cancelar {
        background: #667784;
        color: white;

        padding: 11px 20px;
    }


    .btn-cancelar:hover {
        background: #52616c;
        color: white;
    }


    .botones-formulario {
        display: flex;

        gap: 10px;

        margin-top: 25px;
    }


    .busqueda-opciones {
        position: relative;

        width: 100%;
    }


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
            0 5px 15px rgba(0,0,0,.12);

        z-index: 1000;
    }


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


    .sin-resultados {
        padding: 12px 15px;

        color: #777;
    }

</style>

@endpush


@push('scripts')

<script>

    /*
    ==========================================
    PRODUCTIVIDADES
    ==========================================
    */

    const buscarProductividad =
        document.getElementById(
            'buscarProductividad'
        );

    const idProductividad =
        document.getElementById(
            'id_productividad'
        );

    const resultadosProductividad =
        document.getElementById(
            'resultadosProductividad'
        );


    const productividades = [

        @foreach($productividades as $productividad)

            {
                id: @json(
                    $productividad->id_productividad
                ),

                titulo: @json(
                    $productividad->titulo
                )
            },

        @endforeach

    ];


    buscarProductividad.addEventListener(
        'input',
        function () {

            const texto =
                this.value
                    .toLowerCase()
                    .trim();


            resultadosProductividad.innerHTML = '';

            idProductividad.value = '';


            if (texto === '') {

                resultadosProductividad.style.display =
                    'none';

                return;

            }


            const coincidencias =
                productividades.filter(
                    function (productividad) {

                        return productividad.titulo
                            .toLowerCase()
                            .includes(texto);

                    }
                );


            if (coincidencias.length === 0) {

                resultadosProductividad.innerHTML =
                    '<div class="sin-resultados">' +
                    'No se encontraron productividades' +
                    '</div>';

                resultadosProductividad.style.display =
                    'block';

                return;

            }


            coincidencias.forEach(
                function (productividad) {

                    const opcion =
                        document.createElement('div');


                    opcion.className =
                        'opcion-busqueda';


                    opcion.textContent =
                        productividad.titulo;


                    opcion.addEventListener(
                        'click',
                        function () {

                            buscarProductividad.value =
                                productividad.titulo;

                            idProductividad.value =
                                productividad.id;

                            resultadosProductividad
                                .style.display =
                                'none';

                        }
                    );


                    resultadosProductividad
                        .appendChild(opcion);

                }
            );


            resultadosProductividad.style.display =
                'block';

        }
    );


    /*
    ==========================================
    INVESTIGADORES
    ==========================================
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


            resultadosInvestigador.innerHTML = '';

            idInvestigador.value = '';


            if (texto === '') {

                resultadosInvestigador.style.display =
                    'none';

                return;

            }


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
    ==========================================
    CERRAR OPCIONES
    ==========================================
    */

    document.addEventListener(
        'click',
        function (event) {

            if (
                !event.target.closest(
                    '.busqueda-opciones'
                )
            ) {

                resultadosProductividad
                    .style.display = 'none';

                resultadosInvestigador
                    .style.display = 'none';

            }

        }
    );

</script>

@endpush