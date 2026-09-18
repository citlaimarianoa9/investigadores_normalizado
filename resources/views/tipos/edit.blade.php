@extends('template')

@section('title', 'Editar Tipo')

@section('content')

<div class="encabezado">

    <h1>Editar Tipo de Productividad</h1>

    <p>
        Modifica la información del tipo de productividad seleccionado.
    </p>

</div>


<div class="card formulario">

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
        action="{{ url('/tipos/' . $tipo->id_tipo) }}"
        method="POST">

        @csrf
        @method('PUT')


        <div class="campo">

            <label for="desc_tipo">
                Tipo de productividad
            </label>


            <input
                type="text"
                id="desc_tipo"
                name="desc_tipo"
                value="{{ old('desc_tipo', $tipo->desc_tipo) }}"
                placeholder="Tipo de productividad"
                required>

        </div>


        <div class="botones-formulario">

            <button
                type="submit"
                class="btn btn-guardar">

                Actualizar Tipo

            </button>


            <a
                href="{{ route('tipos.index') }}"
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
    }

</style>

@endpush