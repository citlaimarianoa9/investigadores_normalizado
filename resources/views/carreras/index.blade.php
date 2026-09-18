@extends('template')

@section('title', 'Carreras')

@section('content')

<div class="encabezado">
    <h1>Administración de Carreras</h1>
    <p>Consulta, registra, modifica y administra las carreras del sistema.</p>
</div>


<div class="card">

    @if(session('success'))
        <div class="mensaje-exito">
            {{ session('success') }}
        </div>
    @endif


    <div class="acciones-superiores">

        <a
            href="{{ route('carreras.create') }}"
            class="btn btn-nuevo-modulo">

            + Registrar Carrera

        </a>


        <div class="contenedor-buscador">

            <input
                type="text"
                id="buscarCarrera"
                placeholder="Buscar carrera..."
                autocomplete="off">

            <div
                id="resultadosCarrera"
                class="resultados-busqueda">
            </div>

        </div>

    </div>


    <div class="tabla-responsive">

        <table id="tablaCarreras">

            <thead>

                <tr>
                    <th style="width: 90px;">ID</th>

                    <th>
                        Nombre de la carrera
                    </th>

                    <th style="width: 230px;">
                        Acciones
                    </th>
                </tr>

            </thead>


            <tbody>

                @forelse($carreras as $carrera)

                    <tr
                        data-id="{{ $carrera->id_carrera }}"
                        data-nombre="{{ strtolower($carrera->nombre_carrera) }}">

                        <td>
                            {{ $carrera->id_carrera }}
                        </td>


                        <td>
                            <strong>
                                {{ $carrera->nombre_carrera }}
                            </strong>
                        </td>


                        <td>

                            <div class="acciones">

                                <a
                                    href="{{ route('carreras.edit', $carrera->id_carrera) }}"
                                    class="btn btn-editar-nuevo">

                                    Editar

                                </a>


                                <form
                                    action="{{ url('/carreras/' . $carrera->id_carrera) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="btn btn-eliminar-nuevo"
                                        onclick="return confirm('¿Deseas eliminar esta carrera?')">

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

                            No hay carreras registradas.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <div class="paginacion">

        {{ $carreras->links() }}

    </div>

</div>

@endsection


@push('styles')

<style>

    /* BOTÓN REGISTRAR */

    .btn-nuevo-modulo {
        background: #2e6f95;
        color: white;
        font-weight: 500;
        padding: 12px 20px;
    }

    .btn-nuevo-modulo:hover {
        background: #244d70;
    }


    /* BOTÓN EDITAR */

    .btn-editar-nuevo {
        background: #397da3;
        color: white;
        padding: 10px 18px;
    }

    .btn-editar-nuevo:hover {
        background: #285f80;
    }


    /* BOTÓN ELIMINAR */

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
        width: 390px;
    }

    #buscarCarrera {
        width: 100%;
        height: 48px;
        padding: 10px 15px;
        border: 1px solid #ccd5dc;
        border-radius: 7px;
        font-size: 15px;
        background: white;
    }

    #buscarCarrera:focus {
        border-color: #2e6f95;
        box-shadow: 0 0 0 2px rgba(46,111,149,.12);
    }


    /* RESULTADOS DE BÚSQUEDA */

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


    .opcion-carrera {
        padding: 12px 15px;
        cursor: pointer;
        border-bottom: 1px solid #edf1f4;
        font-size: 14px;
    }


    .opcion-carrera:hover {
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

const buscador = document.getElementById('buscarCarrera');
const resultados = document.getElementById('resultadosCarrera');

let temporizador;


buscador.addEventListener('input', function () {

    clearTimeout(temporizador);

    const texto = this.value.trim();


    if (texto.length === 0) {

        resultados.innerHTML = '';
        resultados.style.display = 'none';

        return;
    }


    temporizador = setTimeout(function () {

        fetch("{{ route('carreras.index') }}?buscar=" + encodeURIComponent(texto), {

            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }

        })

        .then(response => response.text())

        .then(html => {

            const documento = new DOMParser()
                .parseFromString(html, 'text/html');

            const filas = documento.querySelectorAll(
                '#tablaCarreras tbody tr[data-id]'
            );


            resultados.innerHTML = '';


            if (filas.length === 0) {

                resultados.innerHTML =
                    '<div class="sin-resultados">No se encontraron carreras</div>';

                resultados.style.display = 'block';

                return;
            }


            filas.forEach(fila => {

                const id = fila.dataset.id;

                const nombre =
                    fila.querySelector('td:nth-child(2)')
                        .innerText.trim();


                const opcion =
                    document.createElement('div');


                opcion.className = 'opcion-carrera';

                opcion.innerText = nombre;


                opcion.addEventListener('click', function () {

                    buscador.value = nombre;

                    resultados.style.display = 'none';


                    window.location.href =
                        "{{ route('carreras.index') }}" +
                        "?buscar=" +
                        encodeURIComponent(nombre);

                });


                resultados.appendChild(opcion);

            });


            resultados.style.display = 'block';

        });

    }, 250);

});


document.addEventListener('click', function (e) {

    if (!e.target.closest('.contenedor-buscador')) {

        resultados.style.display = 'none';

    }

});

</script>

@endpush