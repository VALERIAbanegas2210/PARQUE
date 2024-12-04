@extends($layout)

@section('header2')
    <title>Pagos del Usuario</title>
@endsection

@section('header')
    <div class="pagetitle">
        <h1>Pagos del Usuario</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.template') }}">Home</a></li>
                <li class="breadcrumb-item">Reservas</li>
                <li class="breadcrumb-item active">Pagos del Usuario</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')


@if(session('success') && session('source') === 'pagosUser')
<script>
    // Simula un tiempo de carga (esto debería estar sincronizado con tu backend o eventos reales)
    setTimeout(() => {
        // Ocultar el indicador de carga
        const loadingContainer = document.getElementById('loading-container');
        if (loadingContainer) {
            loadingContainer.style.display = 'none';
        }

        // Mostrar el modal de éxito
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
    }, 2000); // Cambiar a la duración real de la carga, si aplica
</script>
@endif

@if(session('error') && session('source') === 'pagosUser')
<script>
    
        setTimeout(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                showConfirmButton: true,
                timer: 3000
            });
        }, 2000);
    
</script>
@endif


    <div class="container mt-5">
        <div class="alert alert-warning text-center" role="alert">
            <h4 class="alert-heading">¡Atención!</h4>

            <p>  
                @if($montoActual==$tipoEntrada->precio)
                    El total Actual cumple con las condiciones por lo tanto esta <strong>PAGADO</strong>
                @else
                    El total Actual cumple con las condiciones por lo tanto esta PENDIENTE
                @endif
            </br>
                La sumatoria de pagos no debe ser mayor que <strong>{{ $tipoEntrada->precio }} Bs</strong>.</br>
                En caso de que la sumatoria sea mayor,se debe eliminar algunos pagos, asimismo si es menor se deben agregar o actualizar pagos
                
            </p>
            
            
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5>Información de los Pagos</h5>
            </div>
            <!-- Mensajes de éxito y error -->
            
            <div class="card-body">
                @if($pagos->isEmpty())
                    <p class="text-muted">No hay pagos registrados para este formulario.</p>
                @else
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Pago</th>
                                <th>Monto (Bs)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pagos as $pago)
                                <tr>
                                    <td>{{ $pago->id }}</td>
                                    <td>{{ $pago->nombre }}</td>
                                    <td>{{ number_format($pago->monto, 2) }} Bs</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editPagoModal" data-id="{{ $pago->id }}" data-nombre="{{ $pago->nombre }}" data-monto="{{ $pago->monto }}">
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePagoModal" data-id="{{ $pago->id }}" data-nombre="{{ $pago->nombre }}">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="alert alert-info mt-4" role="alert">
                <strong>Total: {{$montoActual}} Bs</strong>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver</a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPagoModal">Agregar Pago</button>
            </div>
        </div>
    </div>

    <!-- Modal para editar pago -->
    <div class="modal fade" id="editPagoModal" tabindex="-1" aria-labelledby="editPagoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPagoModalLabel">Editar Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPagoForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editNombrePagoSelect" class="form-label">Nombre del Pago</label>
                            <select class="form-select" id="editNombrePagoSelect" name="nombre" required>
                                <option value="" disabled selected>Seleccione el tipo de pago</option>
                                <option value="QR">QR</option>
                                <option value="EFECTIVO">EFECTIVO</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editMontoPagoInput" class="form-label">Monto (Bs)</label>
                            <input type="number" class="form-control" id="editMontoPagoInput" name="monto" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para eliminar pago -->
    <div class="modal fade" id="deletePagoModal" tabindex="-1" aria-labelledby="deletePagoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePagoModalLabel">Eliminar Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro que desea eliminar el pago <strong id="deletePagoNombre"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deletePagoForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar pago -->
    <div class="modal fade" id="addPagoModal" tabindex="-1" aria-labelledby="addPagoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPagoModalLabel">Agregar Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <!-- Modal para agregar pago -->
                    <form id="addPagoForm" method="POST" action="{{ route('admin.agregar.pago', ['idFormulario' => request()->route('idFormulario')]) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="addNombrePagoSelect" class="form-label">Nombre del Pago</label>
                            <select class="form-select" id="addNombrePagoSelect" name="nombre" required>
                                <option value="" disabled selected>Seleccione el tipo de pago</option>
                                <option value="QR">QR</option>
                                <option value="EFECTIVO">EFECTIVO</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addMontoPagoInput" class="form-label">Monto (Bs)</label>
                            <input type="number" class="form-control" id="addMontoPagoInput" name="monto" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Pago</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script para manejar el modal de edición de pago
        var editPagoModal = document.getElementById('editPagoModal');
        editPagoModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var pagoId = button.getAttribute('data-id');
            var pagoNombre = button.getAttribute('data-nombre');
            var pagoMonto = button.getAttribute('data-monto');
            
            var modalForm = editPagoModal.querySelector('#editPagoForm');
            modalForm.action = `/admin/pagos/${pagoId}`;
            
            var nombreSelect = editPagoModal.querySelector('#editNombrePagoSelect');
            var montoInput = editPagoModal.querySelector('#editMontoPagoInput');
            
            nombreSelect.value = pagoNombre;
            montoInput.value = pagoMonto;
        });

        // Script para manejar el modal de eliminación de pago
        var deletePagoModal = document.getElementById('deletePagoModal');
        deletePagoModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var pagoId = button.getAttribute('data-id');
            var pagoNombre = button.getAttribute('data-nombre');
            
            var modalForm = deletePagoModal.querySelector('#deletePagoForm');
            modalForm.action = `/admin/pagos/${pagoId}`;
            
            var nombreElement = deletePagoModal.querySelector('#deletePagoNombre');
            nombreElement.textContent = pagoNombre;
        });
    </script>
@endsection
