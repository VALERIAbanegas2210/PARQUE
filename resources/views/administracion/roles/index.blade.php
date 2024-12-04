@extends('layouts.admin_template')

@section('header2')
    <title>Roles</title>
@endsection

@section('header')
    <div class="pagetitle">
        <h1>Roles</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.admin_template') }}">Home</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item active">Roles</li>
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
                            <h5 class="card-title">Lista de Roles</h5>
                            <!-- Botón para abrir el modal de agregar rol -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addRoleModal">
                                <i class="bi bi-plus-circle"></i> Agregar Rol
                            </button>
                        </div>

                        <!-- Tabla con botones de editar y eliminar en la columna Acción -->
                        <table class="table table-hover table-striped table-bordered text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <th scope="row">{{ $role->id }}</th>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.Roles.edit', $role->id) }}"
                                                class="btn btn-warning btn-sm">Editar</a>

                                            <!-- Botón para abrir el modal de confirmación -->
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteRoleModal" data-role-id="{{ $role->id }}"
                                                data-role-name="{{ $role->name }}">
                                                Eliminar
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <!-- Modal para confirmar la eliminación -->
                            <!-- Modal para confirmar la eliminación -->
                            <div class="modal fade" id="deleteRoleModal" tabindex="-1"
                                aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteRoleModalLabel">Confirmar Eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Estás seguro de que deseas eliminar el rol <strong id="roleName"></strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <form id="deleteRoleForm" method="POST" action="">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </table>
                        <!-- End Enhanced Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para agregar rol -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoleModalLabel">Agregar Nuevo Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addRoleForm" action="{{ route('admin.Roles.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="roleName" class="form-label">Nombre del Rol</label>
                            <input type="text" class="form-control" id="roleName" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-success">Agregar Rol</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        #successAlert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            width: 250px;
            /* Controla el ancho del mensaje */
        }
    </style>

    <script>
        var deleteRoleModal = document.getElementById('deleteRoleModal');
        deleteRoleModal.addEventListener('show.bs.modal', function(event) {
            // Botón que disparó el modal
            var button = event.relatedTarget;

            // Extraer el ID y el nombre del rol desde los atributos data
            var roleId = button.getAttribute('data-role-id');
            var roleName = button.getAttribute('data-role-name');

            // Actualizar el contenido del modal con el nombre del rol
            var roleNameElement = document.getElementById('roleName');
            roleNameElement.textContent = roleName;

            // Actualizar la acción del formulario para incluir el ID del rol
            var form = document.getElementById('deleteRoleForm');
            form.action = '/admin/roles/delete/' + roleId;
        });
        setTimeout(function() {
            let alertElement = document.getElementById('successAlert');
            if (alertElement) {
                alertElement.style.display = 'none'; // Oculta el mensaje
            }
        }, 3000); // Desaparece después de 3 segundos
    </script>
@endsection
