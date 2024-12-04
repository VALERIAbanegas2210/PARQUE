@extends('layouts.template')

@section('header')
    <!-- Page Header-->
    <div class="pagetitle">
        <h1>Actividad En El Parque</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.template') }}">Home</a></li>
                <li class="breadcrumb-item">Reservas</li>
                <li class="breadcrumb-item active">Mi Actividad</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('header2')
    <title>Actividad en Curso</title>
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5>Actividad en Curso</h5>
        </div>
        <div class="card-body">
            @if($formularios->isEmpty())
                <p class="text-muted">No hay actividad en curso registrada.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>CI</th>
                            <th>Pasaporte</th>
                            <th>Tiempo de Estadía (días)</th>
                            <th>Fecha de Ingreso</th>
                            <th>Fecha de Reserva</th>
                            <th>Comunidad</th>
                            <th>Ruta Turística</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formularios as $formulario)
                            <tr>
                                <td>{{ $formulario->id }}</td>
                                <td>{{ $formulario->nombre }}</td>
                                <td>{{ $formulario->edad }}</td>
                                <td>{{ $formulario->ci ?? 'N/A' }}</td>
                                <td>{{ $formulario->pasaporte ?? 'N/A' }}</td>
                                <td>{{ $formulario->tiempoEstadia }}</td>
                                <td>{{ $formulario->fechaIngreso ?? 'N/A' }}</td>
                                <td>{{ $formulario->fechaReserva ?? 'N/A' }}</td>
                                <td>{{ $formulario->comunidad->nombre }}</td>
                                <td>{{ $formulario->rutaTuristica->nombre }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <!-- Paginación -->
                
            <div class="d-flex justify-content-center">
                {{ $formularios->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
