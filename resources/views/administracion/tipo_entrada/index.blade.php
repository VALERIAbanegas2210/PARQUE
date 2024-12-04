@extends('layouts.admin_template')

@section('header2')
    <title>Entrada</title>
@endsection

@section('header')
    <div class="pagetitle">
        <h1>Entrada</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.admin_template') }}">Home</a></li>
                <li class="breadcrumb-item">Administración</li>
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
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Lista de Entrada</h5>
                            <!-- Botón para abrir el modal de agregar rol -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addRoleModal">
                                <i class="bi bi-plus-circle"></i> Agregar Entrada
                            </button>
                        </div>

                        <!-- Tabla con botones de editar y eliminar en la columna Acción -->
                        <table class="table table-hover table-striped table-bordered text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipo_entrada as $tipo_entradas)
                                    <tr>
                                        <td scope="row">{{ $tipo_entradas->id }}</td>
                                        <td>{{ $tipo_entradas->nombre }}</td>
                                        <td>{{ $tipo_entradas->precio }}</td>
                                        <td>{{ $tipo_entradas->descripcion }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" title="Editar Entrada"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editRoleModal-{{ $tipo_entradas->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <!-- Modal de editar -->
                                            <div class="modal fade" id="editRoleModal-{{ $tipo_entradas->id }}"
                                                tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editRoleModalLabel">Editar Entrada
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.tipo_entrada.update', $tipo_entradas->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="nombre" class="form-label">Nombre de
                                                                        Entrada</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nombre" name="nombre"
                                                                        value="{{ $tipo_entradas->nombre }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="precio" class="form-label">Precio</label>
                                                                    <input type="number" class="form-control"
                                                                        id="precio" name="precio"
                                                                        value="{{ $tipo_entradas->precio }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="descripcion"
                                                                        class="form-label">Descripcion</label>
                                                                    <input type="text" class="form-control"
                                                                        id="descripcion" name="descripcion"
                                                                        value="{{ $tipo_entradas->descripcion }}" required>
                                                                </div>
                                                                <button type="submit" class="btn btn-success">Actualizar
                                                                    Entrada</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Botón para eliminar con modal -->
                                            <button type="button" class="btn btn-danger btn-sm" title="Eliminar Entrada"
                                                onclick="showDeleteModal('{{ $tipo_entradas->nombre }}', '{{ route('admin.tipo_entrada.destroy', $tipo_entradas->id) }}')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                            <!-- Modal para confirmar la eliminación -->
                                            <div class="modal fade" id="deleteRoleModal" tabindex="-1"
                                                aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteRoleModalLabel">Confirmar
                                                                Eliminación</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de que deseas eliminar la entrada <strong
                                                                id="roleName"></strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form id="deleteRoleForm" method="POST" action="">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Eliminar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <!-- End Enhanced Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para agregar entrada -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoleModalLabel">Agregar Nueva Entrada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addRoleForm" action="{{ route('admin.tipo_entrada.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de Entrada</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="precio" name="precio" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                        <button type="submit" class="btn btn-success">Agregar Entrada</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showDeleteModal(name, url) {
            // Actualiza el texto con el nombre de la entrada
            document.getElementById('roleName').textContent = name;

            // Actualiza la acción del formulario con la URL correcta
            document.getElementById('deleteRoleForm').action = url;

             
            // Muestra el modal
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteRoleModal'));
            deleteModal.show();
        }
    </script>
@endsection
