@extends('layouts.template')

@section('header2')
    <title>Resumen de Reservas</title>
@endsection

@section('header')
    <div class="pagetitle">
        <h1>Mis Reservas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.template') }}">Home</a></li>
                <li class="breadcrumb-item">usuario</li>
                <li class="breadcrumb-item active">Reserva Actual</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection
@section('content')
    <div class="container mt-5">
        <h2>Resumen de Reservas</h2>
        
        <div class="row">
            @foreach ($formularios as $index => $formulario)
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5>Reserva {{ $index + 1 }}</h5>
                            <ul>
                                <li><strong>Tipo de Entrada:</strong> {{ $formulario->tipoEntrada->nombre }}</li>
                                
                                @isset($formulario->departamento->nombre)
                                    <li><strong>Departamento:</strong> {{ $formulario->departamento->nombre }}</li>
                                @endisset

                                <li><strong>Comunidad:</strong> {{ $formulario->comunidad->nombre }}</li>
                                <li><strong>Ruta Turística:</strong> {{ $formulario->rutaTuristica->nombre }}</li>
                                <li><strong>Fecha Reserva</strong> {{ $formulario->fechaReserva }}</li>
                                <li><strong>Nombre:</strong> {{ $formulario->nombre }}</li>

                                @isset($formulario->ci)
                                    <li><strong>CI:</strong> {{ $formulario->ci }}</li>
                                @endisset

                                @isset($formulario->edad)
                                    <li><strong>Edad:</strong> {{ $formulario->edad }}</li>
                                @endisset

                                @isset($formulario->tiempoEstadia)
                                    <li><strong>Tiempo de Estadia:</strong> {{ $formulario->tiempoEstadia }} días</li>
                                @endisset

                                @isset($formulario->nacionalidad)
                                    <li><strong>Nacionalidad:</strong> {{ $formulario->nacionalidad }}</li>
                                @endisset

                                @isset($formulario->pasaporte)
                                    <li><strong>Pasaporte:</strong> {{ $formulario->pasaporte }}</li>
                                @endisset

                                @isset($formulario->entrada)
                                    <li><strong>Entrada Nro:</strong> {{ $formulario->entrada->id }} </li>
                                    <li><strong>Codigo Entrada:</strong> {{ $formulario->entrada->codigoAutorizacion }} </li>
                                @endisset
                                
                                @isset($formulario->tipoEntrada->precio)
                                    <li><strong>Precio De La Entrada:</strong> {{ $formulario->tipoEntrada->precio }} Bs</li>
                                @endisset
                            </ul>
                            
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

   

    
@endsection
