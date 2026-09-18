@extends('template')

@section('title', 'Registrar Investigador')

@section('content')

<div class="encabezado">

    <h1>Registrar Investigador</h1>

    <p>
        Agrega un nuevo investigador y asigna la carrera a la que pertenece.
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
        action="{{ route('investigadores.store') }}"
        method="POST">

        @csrf


        {{-- NOMBRE --}}
        <div class="campo">

            <label for="nombre">
                Nombre
            </label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                value="{{ old('nombre') }}"
                placeholder="Nombre del investigador"
                required>

        </div>


        {{-- APELLIDO PATERNO --}}
        <div class="campo">

            <label for="apellido_p">
                Apellido paterno
            </label>

            <input
                type="text"
                id="apellido_p"
                name="apellido_p"
                value="{{ old('apellido_p') }}"
                placeholder="Apellido paterno"
                required>

        </div>


        {{-- APELLIDO MATERNO --}}
        <div class="campo">

            <label for="apellido_m">
                Apellido materno
            </label>

            <input
                type="text"
                id="apellido_m"
                name="apellido_m"
                value="{{ old('apellido_m') }}"
                placeholder="Apellido materno"
                required>

        </div>


        {{-- CARRERA --}}
        <div class="campo">

            <label for="buscarCarrera">
                Carrera
            </label>


            <div class="busqueda-carrera">

                <input
                    type="text"
                    id="buscarCarrera"
                    placeholder="Escribe para buscar una carrera..."
                    autocomplete="off"
                    required>


                <input
                    type="hidden"
                    id="id_carrera"
                    name="id_carrera"
                    value="{{ old('id_carrera') }}">


                <div
                    id="resultadosCarrera"
                    class="resultados-carrera">
                </div>

            </div>

        </div>


        {{-- BOTONES --}}
        <div class="botones-formulario">

            <button
                type="submit"
                class="btn btn-guardar">

                Guardar Investigador

            </button>


            <a
                href="{{ route('investigadores.index') }}"
                class="btn btn-cancelar">

                Cancelar

            </a>

        </div>

    </form>

</div>

@endsection


@push('styles')

<style>

    .btn-guardar {
        background: #2e6f95;
        color: white;
        padding: 11px 20px;
    }

    .btn-guardar:hover {
        background: #244d70;
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


    .busqueda-carrera {
        position: relative;
        width: 100%;
    }


    .resultados-carrera {
        display: none;
        position: absolute;

        top: 100%;
        left: 0;

        width: 100%;
        max-height: 230px;

        overflow-y: auto;

        background: white;

        border: 1px solid #ccd5dc;
        border-radius: 7px;

        margin-top: 4px;

        box-shadow: 0 5px 15px rgba(0,0,0,.12);

        z-index: 1000;
    }


    .opcion-carrera {
        padding: 12px 15px;

        cursor: pointer;

        border-bottom: 1px solid #edf1f4;

        color: #16324f;
    }


    .opcion-carrera:hover {
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

    const buscarCarrera =
        document.getElementById('buscarCarrera');

    const idCarrera =
        document.getElementById('id_carrera');

    const resultadosCarrera =
        document.getElementById('resultadosCarrera');


    /*
        Estas son únicamente las carreras
        que vienen de la tabla carreras.
    */

    const carreras = [

        @foreach($carreras as $carrera)

            {
                id: @json($carrera->id_carrera),
                nombre: @json($carrera->nombre_carrera)
            },

        @endforeach

    ];


    buscarCarrera.addEventListener('input', function () {

        const texto =
            this.value
                .toLowerCase()
                .trim();


        resultadosCarrera.innerHTML = '';

        idCarrera.value = '';


        if (texto === '') {

            resultadosCarrera.style.display = 'none';

            return;

        }


        /*
            Búsqueda equivalente a:
            LIKE %texto%
        */

        const coincidencias =
            carreras.filter(function (carrera) {

                return carrera.nombre
                    .toLowerCase()
                    .includes(texto);

            });


        if (coincidencias.length === 0) {

            resultadosCarrera.innerHTML =
                '<div class="sin-resultados">' +
                'No se encontraron carreras' +
                '</div>';

            resultadosCarrera.style.display =
                'block';

            return;

        }


        coincidencias.forEach(function (carrera) {

            const opcion =
                document.createElement('div');


            opcion.className =
                'opcion-carrera';


            opcion.textContent =
                carrera.nombre;


            opcion.addEventListener(
                'click',
                function () {

                    buscarCarrera.value =
                        carrera.nombre;

                    idCarrera.value =
                        carrera.id;

                    resultadosCarrera.style.display =
                        'none';

                }
            );


            resultadosCarrera.appendChild(opcion);

        });


        resultadosCarrera.style.display =
            'block';

    });


    document.addEventListener('click', function (event) {

        if (!event.target.closest('.busqueda-carrera')) {

            resultadosCarrera.style.display =
                'none';

        }

    });

</script>

@endpush