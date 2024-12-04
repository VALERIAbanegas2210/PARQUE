@extends('layouts.admin_template')

@section('header2')
    <title>Administrar Rutas</title>
@endsection

@section('header')
    <div class="pagetitle">
        <h1>Administración de Rutas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.admin_template') }}">Home</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item active">Rutas</li>
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

    @if (session('error'))
        <div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert"
            style="position: fixed; top: 80px; right: 20px; z-index: 1050; width: 250px;">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Lista de Rutas</h5>
                        </div>

                        <!-- Formulario para agregar una nueva ruta -->
                        <form action="{{ route('admin.rutas.store') }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre de la Ruta:</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" required>
                            </div>

                            <!-- Selección de Comunidad -->
                            <div class="mb-3">
                                <label for="comunidad_id" class="form-label">Comunidad</label>
                                <select id="comunidad_id" name="comunidad_id" class="form-select" required>
                                    <option value="" disabled selected>Seleccione una Comunidad</option>
                                    @foreach($comunidades as $comunidad)
                                        <option value="{{ $comunidad->id }}" {{ $comunidad->disponibilidad !== 'DISPONIBLE' ? 'disabled' : '' }}>
                                            {{ $comunidad->nombre }} - Zona: {{ $comunidad->zona }}
                                            @if($comunidad->disponibilidad !== 'DISPONIBLE') (No Disponible) @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            
                            <button type="submit" class="btn btn-primary">Agregar Ruta</button>
                        </form>

                        <!-- Tabla para visualizar todas las rutas -->
                        <table class="table table-hover table-striped table-bordered text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Comunidad</th>
                                    <th scope="col">Disponibilidad</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rutas as $ruta)
                                    <tr>
                                        <td>{{ $ruta->id }}</td>
                                        <td>{{ $ruta->nombre }}</td>
                                        <td>{{ $ruta->comunidad->nombre }}</td>
                                        <td>{{ $ruta->disponibilidad}}</td>
                                        <td>
                                            <!-- Botón para abrir el modal de edición -->
                                            <button type="button" class="btn btn-warning btn-sm" title="Editar Ruta"
                                                data-bs-toggle="modal" data-bs-target="#editRutaModal-{{ $ruta->id }}">
                                                <i class="fas fa-edit"></i>Editar
                                            </button>

                                            <!-- Modal de edición -->
                                            <div class="modal fade" id="editRutaModal-{{ $ruta->id }}" tabindex="-1" aria-labelledby="editRutaModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editRutaModalLabel">Editar Ruta</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('admin.rutas.update', $ruta->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="nombre-{{ $ruta->id }}" class="form-label">Nombre de la Ruta:</label>
                                                                    <input type="text" id="nombre-{{ $ruta->id }}" name="nombre" class="form-control" value="{{ $ruta->nombre }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="comunidad_id-{{ $ruta->id }}" class="form-label">Comunidad:</label>
                                                                    <select id="comunidad_id-{{ $ruta->id }}" name="comunidad_id" class="form-select" required>
                                                                        @foreach ($comunidades as $comunidad)
                                                                            <option value="{{ $comunidad->id }}" {{ $comunidad->id == $ruta->comunidad_id ? 'selected' : '' }}>{{ $comunidad->nombre }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <!--Disponibilidad--->
                                                                <div class="mb-3">
                                                                    <label for="disponibilidad" class="form-label">Disponibilidad</label>
                                                                    <select class="form-select" id="disponibilidad" name="disponibilidad" required>
                                                                        <option value="" disabled selected>Seleccione una opción</option>
                                                                        <option value="DISPONIBLE" {{ $ruta->disponibilidad === 'DISPONIBLE' ? 'selected' : '' }}>DISPONIBLE</option>
                                                                        <option value="NO DISPONIBLE" {{ $ruta->disponibilidad === 'NO DISPONIBLE' ? 'selected' : '' }}>NO DISPONIBLE</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <button type="submit" class="btn btn-success">Actualizar Ruta</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Botón de eliminación -->
                                            <form action="{{ route('admin.rutas.destroy', $ruta->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar Ruta" onclick="return confirm('¿Estás seguro de que deseas eliminar esta ruta?');">
                                                    <i class="fas fa-trash-alt"></i>Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
