@extends('layouts.admin_template')

@section('header2')
    <title>Formularios de Reservas</title>
@endsection

@section('header')
    <div class="pagetitle">
        <h1>Formularios de Reservas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.admin_template') }}">Home</a></li>
                <li class="breadcrumb-item">Reservas</li>
                <li class="breadcrumb-item active">Formularios de Reservas</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container mt-5">
        <h1>Formularios Pagados</h1>
        <div class="card">
            <div class="card-header">
                <h5>Información de los Formularios de Reservas</h5>
                <input type="text" id="filterInput" class="form-control me-2" placeholder="Buscar por CI o Nombre">
            </div>
            <div class="card-body">
                @if($formularios->isEmpty())
                    <p class="text-muted">No hay formularios registrados.</p>
                @else
                <table class="table table-striped table-hover table-bordered" id="formulariosTable">
                    <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                
                                <th>Tipo de Entrada</th>
                                <th>Estadia(dias)</th>
                                <th>Fecha de Reserva</th>
                                <th>Reservado</th>
                                <th>Atendido</th>
                                <th>Comunidad</th>
                                <th>Ruta Turistica</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($formularios as $formulario)
                                <tr>
                                    <td>{{ $formulario->id }}</td>
                                    <td>{{ $formulario->nombre }}</td>
                                    
                                    <td>{{ $formulario->tipoEntrada->nombre ?? 'N/A' }}</td>
                                    <td>{{ $formulario->tiempoEstadia }}</td>
                                    <td>{{ $formulario->fechaReserva }}</td>
                                    <td>{{ $formulario->reserva->usuario->nombre }}</td>
                                    <td>{{ $formulario->guardaparque->nombre ?? 'N/A' }}</td>
                                    <td>{{ $formulario->comunidad->nombre?? 'N/A' }}</td>
                                    <td>{{ $formulario->rutaTuristica->nombre ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.editar.formulario', ['idReserva' => $formulario->reserva->id, 'idForm' => $formulario->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="{{ route('admin.editar.pagos.formulario', ['idFormulario' => $formulario->id]) }}" class="btn btn-info btn-sm">Editar Pago</a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteFormularioModal" data-id="{{ $formulario->id }}" data-nombre="{{ $formulario->nombre }}">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <!-- Paginación -->
                
            <div class="d-flex justify-content-center">
                {{ $formularios->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <!-- Modal para eliminar formulario -->
    <div class="modal fade" id="deleteFormularioModal" tabindex="-1" aria-labelledby="deleteFormularioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteFormularioModalLabel">Eliminar Formulario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro que desea eliminar el formulario de <strong id="deleteFormularioNombre"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteFormularioForm" method="POST" action="" data-route="{{ route('usuario.eliminar.formulario', ['id' => ':id']) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                    
                </div>

            </div>
        </div>
    </div>

    


    <script>
        // Script para manejar el modal de eliminación de formulario
        let deleteFormularioModal = document.getElementById('deleteFormularioModal');
        deleteFormularioModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget;
            let formularioId = button.getAttribute('data-id');
            let formularioNombre = button.getAttribute('data-nombre');
            
            // Obtén la plantilla de ruta del atributo data-route del formulario
            let modalForm = deleteFormularioModal.querySelector('#deleteFormularioForm');
            let routeTemplate = modalForm.getAttribute('data-route');
            
            // Reemplaza el marcador de posición ':id' con el ID real
            let deleteUrl = routeTemplate.replace(':id', formularioId);
            
            // Establece la acción del formulario
            modalForm.action = deleteUrl;

            // Establece el nombre del formulario a eliminar en el modal
            let nombreElement = deleteFormularioModal.querySelector('#deleteFormularioNombre');
            nombreElement.textContent = formularioNombre;
        });


        // Script para filtrar los formularios por CI o Nombre
        document.getElementById('filterInput').addEventListener('keyup', function() {
            var filterValue = this.value.toLowerCase();
            var tableRows = document.querySelectorAll('#formulariosTable tbody tr');

            tableRows.forEach(function(row) {
                var nombre = row.cells[1].textContent.toLowerCase(); // Columna Nombre
                var ci = row.cells[2].textContent.toLowerCase(); // Columna CI
                if (ci.includes(filterValue) || nombre.includes(filterValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
