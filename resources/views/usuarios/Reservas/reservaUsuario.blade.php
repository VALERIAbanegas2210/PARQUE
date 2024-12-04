@extends('layouts.template')

@section('header2')
    <title>Mis Reservas</title>
@endsection
<!--vista para las reservas-->
@section('header')
    <div class="pagetitle">
        <h1>Mis Reservas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.template') }}">Home</a></li>
                <li class="breadcrumb-item">usuario</li>
                <li class="breadcrumb-item active">Mis Reservas</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @if($estado=="PENDIENTE")
                <h5 class="card-title">Mis Reservas Pendientes</h5>
            @else
                <h5 class="card-title">Mis Reservas Pagadas</h5>
            @endif
            @if($reservasPendientes->isEmpty())
                <p>No tienes reservas pendientes en este momento.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Reserva</th>
                                <th>Fecha de Reserva</th>
                                <th>Monto Total</th>
                                <th>Cantidad</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservasPendientes as $index => $reserva)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $reserva->fechaReserva }}</td>
                                    <td>{{ $reserva->montoTotal }}</td>
                                    <td>{{ $reserva->cantidad }}</td>
                                    <td>{{ $reserva->estado }}</td>
                                    <td>
                                        @if($estado=="PENDIENTE")
                                            <a href="{{ route('usuario.show.detalle', $reserva->id) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                                            <button type="button" class="btn btn-danger btn-sm" title="Cancelar Reserva" onclick="showDeleteModal('{{ $reserva->fecha_reserva }}', '{{ route('usuario.delete.reserva', $reserva->id) }}')">
                                                <i class="fas fa-trash-alt"></i>Eliminar
                                            </button>
                                        @else
                                            <a href="{{ route('usuario.show.detalle.pagado', $reserva->id) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                                        @endif
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
                <!-- Paginación -->
                
                <div class="d-flex justify-content-center">
                    {{ $reservasPendientes->links('pagination::bootstrap-4') }}
                </div>
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
                    ¿Estás seguro de que deseas Eliminar la reserva?
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
            //document.getElementById('roleName').textContent = name;

            // Actualiza la acción del formulario con la URL correcta
            document.getElementById('deleteRoleForm').action = url;

            // Muestra el modal
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteRoleModal'));
            deleteModal.show();
        }
    </script>
@endsection
