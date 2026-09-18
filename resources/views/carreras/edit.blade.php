@extends('template')

@section('title', 'Editar Carrera')

@section('content')

<div class="encabezado">
    <h1>Editar Carrera</h1>
    <p>Modifica la información de la carrera seleccionada.</p>
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
        action="{{ url('/carreras/' . $carrera->id_carrera) }}"
        method="POST">

        @csrf
        @method('PUT')


        <div class="campo">

            <label for="nombre_carrera">
                Nombre de la carrera
            </label>

            <input
                type="text"
                id="nombre_carrera"
                name="nombre_carrera"
                value="{{ old('nombre_carrera', $carrera->nombre_carrera) }}"
                placeholder="Nombre de la carrera"
                required>

        </div>


        <div class="botones-formulario">

            <button
                type="submit"
                class="btn btn-principal">

                Actualizar Carrera

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