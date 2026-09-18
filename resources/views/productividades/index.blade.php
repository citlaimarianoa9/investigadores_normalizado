@extends('template')

@section('title', 'Productividades')

@section('content')

<div class="encabezado">

    <h1>Administración de Productividades</h1>

    <p>
        Consulta, registra, modifica y administra las productividades del sistema.
    </p>

</div>


<div class="card">

    {{-- MENSAJE --}}
    @if(session('success'))

        <div class="mensaje-exito">
            {{ session('success') }}
        </div>

    @endif


    {{-- ACCIONES SUPERIORES --}}
    <div class="acciones-superiores">

        <a
            href="{{ route('productividades.create') }}"
            class="btn btn-nuevo-modulo">

            + Registrar Productividad

        </a>


        <form
            action="{{ route('productividades.index') }}"
            method="GET"
            class="buscador"
            id="formBuscar">

            <div class="contenedor-buscador">

                <input
                    type="text"
                    name="buscar"
                    id="buscarProductividad"
                    placeholder="Buscar productividad..."
                    value="{{ $buscar ?? '' }}"
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
                    href="{{ route('productividades.index') }}"
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

                    <th>Título</th>

                    <th>Fecha</th>

                    <th>Investigador</th>

                    <th>Descripción</th>

                    <th>Tipo</th>

                    <th>Acciones</th>

                </tr>

            </thead>


            <tbody>

                @forelse($productividades as $productividad)

                    <tr>

                        <td>
                            {{ $productividad->id_productividad }}
                        </td>


                        <td>

                            <strong>
                                {{ $productividad->titulo }}
                            </strong>

                        </td>


                        <td>
                            {{ $productividad->fecha_p }}
                        </td>


                        <td>

                            @if($productividad->investigador)

                                {{ $productividad->investigador->nombre }}

                                {{ $productividad->investigador->apellido_p }}

                                {{ $productividad->investigador->apellido_m }}

                            @endif

                        </td>


                        <td>
                            {{ $productividad->descripcion }}
                        </td>


                        <td>

                            @if($productividad->tipo)

                                {{ $productividad->tipo->desc_tipo }}

                            @endif

                        </td>


                        <td>

                            <div class="acciones">

                                <a
                                    href="{{ url('/productividades/' . $productividad->id_productividad . '/edit') }}"
                                    class="btn btn-editar-nuevo">

                                    Editar

                                </a>


                                <form
                                    action="{{ url('/productividades/' . $productividad->id_productividad) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="btn btn-eliminar-nuevo"
                                        onclick="return confirm('¿Deseas eliminar esta productividad?')">

                                        Eliminar

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="vacio">

                            No se encontraron productividades.

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

    /* REGISTRAR */

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


    /* BUSCAR */

    .btn-buscar {
        background: #2e6f95;
        color: white;
    }

    .btn-buscar:hover {
        background: #244d70;
        color: white;
    }


    /* LIMPIAR */

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


    /* ACCIONES */

    .acciones {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .acciones form {
        margin: 0;
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


    /* RESULTADOS DE BÚSQUEDA */

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

        box-shadow: 0 5px 15px rgba(0,0,0,.12);

        z-index: 1000;
    }


    .opcion-productividad {

        padding: 11px 15px;

        cursor: pointer;

        border-bottom: 1px solid #edf1f4;

        color: #16324f;

        background: white;
    }


    .opcion-productividad:hover {
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

    const buscarProductividad =
        document.getElementById('buscarProductividad');

    const resultadosBusqueda =
        document.getElementById('resultadosBusqueda');


    /*
        ÚNICAMENTE PRODUCTIVIDADES QUE LLEGAN
        DESDE LA BASE DE DATOS.
    */

    const productividades = [

        @foreach($productividades as $productividad)

            {
                titulo: @json($productividad->titulo)
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


            resultadosBusqueda.innerHTML = '';


            /*
                NO MOSTRAR TODA LA LISTA
                SI EL CAMPO ESTÁ VACÍO.
            */

            if (texto === '') {

                resultadosBusqueda.style.display =
                    'none';

                return;

            }


            /*
                COINCIDENCIAS TIPO LIKE %texto%
            */

            const coincidencias =
                productividades.filter(
                    function (productividad) {

                        return productividad.titulo
                            .toLowerCase()
                            .includes(texto);

                    }
                );


            if (coincidencias.length === 0) {

                resultadosBusqueda.innerHTML =
                    '<div class="sin-resultados">' +
                    'No se encontraron productividades' +
                    '</div>';

                resultadosBusqueda.style.display =
                    'block';

                return;

            }


            /*
                MOSTRAR COINCIDENCIAS
            */

            coincidencias.forEach(
                function (productividad) {

                    const opcion =
                        document.createElement('div');


                    opcion.className =
                        'opcion-productividad';


                    opcion.textContent =
                        productividad.titulo;


                    opcion.addEventListener(
                        'click',
                        function () {

                            buscarProductividad.value =
                                productividad.titulo;


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


    /*
        CERRAR AL HACER CLIC FUERA
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