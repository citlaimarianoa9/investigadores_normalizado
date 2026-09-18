@extends('template')

@section('title', 'Registrar Carrera')

@section('content')

<div class="encabezado">
    <h1>Registrar Carrera</h1>
    <p>Agrega una nueva carrera al sistema.</p>
</div>


<div class="card formulario">

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
        action="{{ route('carreras.store') }}"
        method="POST">

        @csrf


        <div class="campo">

            <label for="nombre_carrera">
                Nombre de la carrera
            </label>

            <input
                type="text"
                id="nombre_carrera"
                name="nombre_carrera"
                value="{{ old('nombre_carrera') }}"
                placeholder="Ej. Ingeniería en Sistemas Computacionales"
                required>

        </div>


        <div class="botones-formulario">

            <button
                type="submit"
                class="btn btn-principal">

                Guardar Carrera

            </button>


            <a
                href="{{ route('carreras.index') }}"
                class="btn btn-secundario">

                Cancelar

            </a>

        </div>

    </form>

</div>

@endsection