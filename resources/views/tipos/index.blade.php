@extends('template')

@section('title', 'Tipos de Productividad')

@section('content')

<div class="encabezado">
    <h1>Tipos de Productividad</h1>
    <p>Consulta, registra, modifica y administra los tipos de productividad.</p>
</div>


<div class="card">

    @if(session('success'))
        <div class="mensaje-exito">
            {{ session('success') }}
        </div>
    @endif


    <div class="acciones-superiores">

        <a
            href="{{ route('tipos.create') }}"
            class="btn btn-nuevo-modulo">

            + Registrar Tipo

        </a>


        <div class="contenedor-buscador">

            <input
                type="text"
                id="buscarTipo"
                placeholder="Buscar tipo de productividad..."
                autocomplete="off">

            <div
                id="resultadosTipo"
                class="resultados-busqueda">
            </div>

        </div>

    </div>


    <div class="tabla-responsive">

        <table id="tablaTipos">

            <thead>

                <tr>

                    <th style="width: 100px;">
                        ID
                    </th>

                    <th>
                        Tipo de productividad
                    </th>

                    <th style="width: 240px;">
                        Acciones
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($tipos as $tipo)

                    <tr data-id="{{ $tipo->id_tipo }}">

                        <td>
                            {{ $tipo->id_tipo }}
                        </td>


                        <td>
                            <strong>
                                {{ $tipo->desc_tipo }}
                            </strong>
                        </td>


                        <td>

                            <div class="acciones">

                                <a
                                    href="{{ route('tipos.edit', $tipo->id_tipo) }}"
                                    class="btn btn-editar-nuevo">

                                    Editar

                                </a>


                                <form
                                    action="{{ url('/tipos/' . $tipo->id_tipo) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="btn btn-eliminar-nuevo"
                                        onclick="return confirm('¿Deseas eliminar este tipo de productividad?')">

                                        Eliminar

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="3"
                            class="vacio">

                            No se encontraron tipos de productividad.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <div class="paginacion">

        {{ $tipos->appends(request()->query())->links() }}

    </div>

</div>

@endsection


@push('styles')

<style>

    .btn-nuevo-modulo {
        background: #2e6f95;
        color: white;
        font-weight: 500;
        padding: 12px 20px;
    }

    .btn-nuevo-modulo:hover {
        background: #244d70;
    }


    .btn-editar-nuevo {
        background: #397da3;
        color: white;
        padding: 10px 18px;
    }

    .btn-editar-nuevo:hover {
        background: #285f80;
    }


    .btn-eliminar-nuevo {
        background: #b94a55;
        color: white;
        padding: 10px 18px;
    }

    .btn-eliminar-nuevo:hover {
        background: #963b45;
    }


    .contenedor-buscador {
        position: relative;
        width: 390px;
    }


    #buscarTipo {
        width: 100%;
        height: 48px;
        padding: 10px 15px;

        border: 1px solid #ccd5dc;
        border-radius: 7px;

        font-size: 15px;
        background: white;
    }


    #buscarTipo:focus {
        border-color: #2e6f95;
        box-shadow: 0 0 0 2px rgba(46,111,149,.12);
    }


    .resultados-busqueda {
        display: none;

        position: absolute;

        top: 53px;
        left: 0;

        width: 100%;
        max-height: 250px;

        overflow-y: auto;

        background: white;

        border: 1px solid #d6dee5;
        border-radius: 7px;

        box-shadow: 0 5px 15px rgba(0,0,0,.12);

        z-index: 100;
    }


    .opcion-tipo {
        padding: 12px 15px;
        cursor: pointer;
        border-bottom: 1px solid #edf1f4;
        font-size: 14px;
    }


    .opcion-tipo:hover {
        background: #edf4f8;
        color: #16324f;
    }


    .sin-resultados {
        padding: 14px;
        color: #777;
        text-align: center;
    }

</style>

@endpush


@push('scripts')

<script>

const buscarTipo = document.getElementById('buscarTipo');
const resultadosTipo = document.getElementById('resultadosTipo');

let temporizadorTipo;


buscarTipo.addEventListener('input', function () {

    clearTimeout(temporizadorTipo);

    const texto = this.value.trim();


    if (texto.length === 0) {

        resultadosTipo.innerHTML = '';
        resultadosTipo.style.display = 'none';

        return;
    }


    temporizadorTipo = setTimeout(function () {

        fetch(
            "{{ route('tipos.index') }}?buscar=" +
            encodeURIComponent(texto),
            {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }
        )

        .then(response => response.text())

        .then(html => {

            const documento = new DOMParser()
                .parseFromString(html, 'text/html');


            const filas = documento.querySelectorAll(
                '#tablaTipos tbody tr[data-id]'
            );


            resultadosTipo.innerHTML = '';


            if (filas.length === 0) {

                resultadosTipo.innerHTML =
                    '<div class="sin-resultados">No se encontraron tipos</div>';

                resultadosTipo.style.display = 'block';

                return;
            }


            filas.forEach(fila => {

                const nombre =
                    fila.querySelector('td:nth-child(2)')
                        .innerText
                        .trim();


                const opcion =
                    document.createElement('div');


                opcion.className = 'opcion-tipo';

                opcion.innerText = nombre;


                opcion.addEventListener('click', function () {

                    buscarTipo.value = nombre;

                    resultadosTipo.style.display = 'none';


                    window.location.href =
                        "{{ route('tipos.index') }}" +
                        "?buscar=" +
                        encodeURIComponent(nombre);

                });


                resultadosTipo.appendChild(opcion);

            });


            resultadosTipo.style.display = 'block';

        });

    }, 250);

});


document.addEventListener('click', function (event) {

    if (!event.target.closest('.contenedor-buscador')) {

        resultadosTipo.style.display = 'none';

    }

});

</script>

@endpush