<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Sistema de Investigadores')
    </title>


    <style>

        /*
        ==============================================
        CONFIGURACIÓN GENERAL
        ==============================================
        */

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f4f7fa;

            color: #263238;

        }



        /*
        ==============================================
        BARRA SUPERIOR
        ==============================================
        */

        .navbar {

            background: #16324f;

            min-height: 72px;

            display: flex;

            align-items: center;

            padding: 0 45px;

            box-shadow:
                0 2px 8px
                rgba(0, 0, 0, .12);

        }



        /*
        ==============================================
        NOMBRE DEL SISTEMA
        ==============================================
        */

        .marca {

            color: white;

            text-decoration: none;

            margin-right: 45px;

            flex-shrink: 0;

        }


        .marca h2 {

            margin: 0;

            font-size: 20px;

        }


        .marca span {

            display: block;

            margin-top: 3px;

            font-size: 11px;

            color: #b9cad8;

        }



        /*
        ==============================================
        MENÚ
        ==============================================
        */

        .menu {

            display: flex;

            align-items: center;

            gap: 5px;

            flex: 1;

        }


        .menu a {

            color: #e5edf3;

            text-decoration: none;

            padding: 12px 14px;

            border-radius: 7px;

            font-size: 14px;

            transition: .2s;

            white-space: nowrap;

        }


        .menu a:hover {

            background: #244d70;

            color: white;

        }


        /*
        Opción seleccionada actualmente
        */

        .menu a.activo {

            background: #2e6f95;

            color: white;

        }



        /*
        ==============================================
        INSTITUCIÓN
        ==============================================
        */

        .institucion {

            color: #c5d3de;

            font-size: 13px;

            margin-left: 20px;

            flex-shrink: 0;

        }



        /*
        ==============================================
        CONTENIDO PRINCIPAL
        ==============================================
        */

        .pagina {

            max-width: 1400px;

            margin: auto;

            padding: 35px 40px;

        }



        /*
        ==============================================
        ENCABEZADOS
        ==============================================
        */

        .encabezado {

            margin-bottom: 25px;

        }


        .encabezado h1 {

            margin: 0 0 7px 0;

            color: #16324f;

            font-size: 30px;

        }


        .encabezado p {

            margin: 0;

            color: #71808d;

            font-size: 14px;

        }



        /*
        ==============================================
        TARJETAS
        ==============================================
        */

        .card {

            background: white;

            padding: 25px;

            border-radius: 12px;

            border:
                1px solid #e2e8ed;

            box-shadow:
                0 3px 12px
                rgba(0, 0, 0, .05);

        }



        /*
        ==============================================
        PARTE SUPERIOR DE LAS TABLAS
        ==============================================
        */

        .acciones-superiores {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            margin-bottom: 25px;

        }



        /*
        ==============================================
        BUSCADOR
        ==============================================
        */

        .buscador {

            display: flex;

            gap: 8px;

        }


        .buscador input {

            min-width: 260px;

        }



        /*
        ==============================================
        FORMULARIOS
        ==============================================
        */

        .formulario {

            max-width: 800px;

        }


        .campo {

            margin-bottom: 20px;

        }


        label {

            display: block;

            font-weight: bold;

            margin-bottom: 7px;

            color: #34495e;

            font-size: 14px;

        }


        input,
        select,
        textarea {

            width: 100%;

            padding: 11px 13px;

            border:
                1px solid #ccd5dc;

            border-radius: 7px;

            background: white;

            font-size: 14px;

            outline: none;

        }


        input:focus,
        select:focus,
        textarea:focus {

            border-color: #2e6f95;

            box-shadow:
                0 0 0 2px
                rgba(46, 111, 149, .10);

        }


        textarea {

            min-height: 120px;

            resize: vertical;

        }



        /*
        ==============================================
        BOTONES
        ==============================================
        */

        .btn {

            display: inline-block;

            padding: 10px 16px;

            border: none;

            border-radius: 7px;

            text-decoration: none;

            cursor: pointer;

            font-size: 14px;

            transition: .2s;

        }


        .btn:hover {

            opacity: .88;

        }


        .btn-principal {

            background: #2e6f95;

            color: white;

        }


        .btn-nuevo {

            background: #198754;

            color: white;

        }


        .btn-editar {

            background: #f0ad2c;

            color: #222;

        }


        .btn-eliminar {

            background: #dc3545;

            color: white;

        }


        .btn-secundario {

            background: #6c757d;

            color: white;

        }


        .botones-formulario {

            display: flex;

            gap: 10px;

            margin-top: 25px;

        }



        /*
        ==============================================
        TABLAS
        ==============================================
        */

        .tabla-responsive {

            width: 100%;

            overflow-x: auto;

        }


        table {

            width: 100%;

            border-collapse: collapse;

        }


        thead {

            background: #edf2f6;

        }


        th {

            color: #34495e;

            font-size: 14px;

            font-weight: bold;

        }


        th,
        td {

            padding: 14px 12px;

            text-align: left;

            border-bottom:
                1px solid #e5eaee;

        }


        td {

            font-size: 14px;

        }


        tbody tr:hover {

            background: #f8fafc;

        }


        .acciones {

            display: flex;

            gap: 7px;

        }



        /*
        ==============================================
        MENSAJES
        ==============================================
        */

        .mensaje-exito {

            background: #d9f2e3;

            color: #146c43;

            padding: 13px 16px;

            border-radius: 7px;

            margin-bottom: 20px;

            border-left:
                4px solid #198754;

        }


        .mensaje-error {

            background: #f8d7da;

            color: #842029;

            padding: 13px 16px;

            border-radius: 7px;

            margin-bottom: 20px;

            border-left:
                4px solid #dc3545;

        }


        .vacio {

            text-align: center;

            padding: 30px;

            color: #758391;

        }


        .paginacion {

            margin-top: 22px;

        }



        /*
        ==============================================
        RESPONSIVE
        ==============================================
        */

        @media(max-width: 1050px) {

            .navbar {

                padding: 15px 20px;

                flex-wrap: wrap;

            }


            .marca {

                margin-bottom: 10px;

            }


            .menu {

                width: 100%;

                order: 3;

                overflow-x: auto;

                padding-top: 10px;

            }


            .menu a {

                white-space: nowrap;

            }


            .pagina {

                padding: 25px 20px;

            }

        }



        @media(max-width: 700px) {

            .acciones-superiores {

                flex-direction: column;

                align-items: stretch;

            }


            .buscador {

                width: 100%;

            }


            .buscador input {

                min-width: 0;

            }


            .institucion {

                display: none;

            }

        }

    </style>


    {{-- ESTILOS DE CADA VISTA --}}

    @stack('styles')

</head>


<body>


{{-- ====================================================== --}}
{{-- BARRA DE NAVEGACIÓN --}}
{{-- ====================================================== --}}

<header class="navbar">


    {{-- NOMBRE DEL SISTEMA --}}

    <a
        href="{{ route('home') }}"
        class="marca">

        <h2>
            Investigadores TESVB
        </h2>

        <span>
            Sistema de administración
        </span>

    </a>



    {{-- ================================================== --}}
    {{-- MENÚ PRINCIPAL --}}
    {{-- ================================================== --}}

    <nav class="menu">


        {{-- HOME --}}

        <a
            href="{{ route('home') }}"
            class="{{ request()->routeIs('home') ? 'activo' : '' }}">

            TESVB

        </a>



        {{-- CARRERAS --}}

        <a
            href="{{ route('carreras.index') }}"
            class="{{ request()->routeIs('carreras.*') ? 'activo' : '' }}">

            Carreras

        </a>



        {{-- TIPOS --}}

        <a
            href="{{ route('tipos.index') }}"
            class="{{ request()->routeIs('tipos.*') ? 'activo' : '' }}">

            Tipos

        </a>



        {{-- INVESTIGADORES --}}

        <a
            href="{{ route('investigadores.index') }}"
            class="{{ request()->routeIs('investigadores.*') ? 'activo' : '' }}">

            Investigadores

        </a>



        {{-- PRODUCTIVIDADES --}}

        <a
            href="{{ route('productividades.index') }}"
            class="{{ request()->routeIs('productividades.*') ? 'activo' : '' }}">

            Productividades

        </a>



        {{-- ASIGNACIONES --}}

        <a
            href="{{ route('asignarinvestigadores.index') }}"
            class="{{ request()->routeIs('asignarinvestigadores.*') ? 'activo' : '' }}">

            Asignaciones

        </a>



        {{-- REPORTES --}}

        <a
            href="{{ route('reportes.index') }}"
            class="{{ request()->routeIs('reportes.*') ? 'activo' : '' }}">

            Reportes

        </a>


    </nav>



    {{-- INSTITUCIÓN --}}

    <div class="institucion">

        TESVB

    </div>


</header>



{{-- ====================================================== --}}
{{-- CONTENIDO DE CADA PÁGINA --}}
{{-- ====================================================== --}}

<main class="pagina">


    {{-- MENSAJE DE ÉXITO --}}

    @if(session('success'))

        <div class="mensaje-exito">

            {{ session('success') }}

        </div>

    @endif



    {{-- MENSAJE DE ERROR --}}

    @if(session('error'))

        <div class="mensaje-error">

            {{ session('error') }}

        </div>

    @endif



    {{-- CONTENIDO DE LAS VISTAS --}}

    @yield('content')


</main>



{{-- ====================================================== --}}
{{-- JAVASCRIPT DE CADA VISTA --}}
{{-- ====================================================== --}}

@stack('scripts')


</body>

</html>