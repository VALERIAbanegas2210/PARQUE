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

                                @isset($formulario->tipoEntrada->precio)
                                    <li><strong>Precio De La Entrada:</strong> {{ $formulario->tipoEntrada->precio }} Bs</li>
                                @endisset

                            </ul>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('usuario.editar.formulario', ['idReserva' => $formulario->reserva->id,'idForm'=>$formulario->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                                <button type="button" class="btn btn-danger btn-sm" title="Eliminar Reserva" onclick="showDeleteModal('{{ $formulario->nombre }}', '{{ route('usuario.eliminar.formulario', ['id' => $formulario->id]) }}')">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal para confirmar la eliminación -->
    <div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoleModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar la reserva de <strong id="roleName"></strong>?
                </div>
                <div class="modal-footer">
                    <form id="deleteRoleForm" method="POST" action="">
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
        function showDeleteModal(name, url) {
            // Actualiza el texto con el nombre de la reserva
            document.getElementById('roleName').textContent = name;

            // Actualiza la acción del formulario con la URL correcta
            document.getElementById('deleteRoleForm').action = url;

            // Muestra el modal
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteRoleModal'));
            deleteModal.show();
        }
    </script>
@endsection
