@extends('layouts.template')

@section('header2')
    <title>Entrada</title>
@endsection

@section('header')
    <div class="pagetitle">
        <h1>Entrada</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.template') }}">Home</a></li>
                <li class="breadcrumb-item">usuario</li>
                <li class="breadcrumb-item active">Entrada</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    @if (session('success'))
        <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert"
            style="position: fixed; top: 20px; right: 20px; z-index: 1050; width: 250px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Lista de Entrada</h5>
                        </div>

                        <!-- Tabla con datos -->
                        <table class="table table-hover table-striped table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipo_entrada as $tipo_entradas)
                                    <tr>
                                        <td scope="row">{{ $tipo_entradas->id }}</td>
                                        <td>{{ $tipo_entradas->nombre }}</td>
                                        <td>{{ $tipo_entradas->precio }}</td>
                                        <td>{{ $tipo_entradas->descripcion }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </br>
                    <a href="{{ route('usuario.formulario.create') }}" class="btn btn-primary text-white" style="text-decoration: none;">
                        Reservar Entrada
                    </a>
                    
                        <!-- End Enhanced Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
