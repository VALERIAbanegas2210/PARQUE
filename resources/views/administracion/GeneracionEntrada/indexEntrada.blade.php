@extends('layouts.admin_template')

@section('header')
    <div class="pagetitle">
        <h1>Generación de Entradas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.admin_template') }}">Home</a></li>
                <li class="breadcrumb-item active">Generar Entradas</li>
            </ol>
        </nav>
    </div>
@endsection



@section('content')
    <div class="container mt-5">

        @if(session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h2>Seleccione el Tipo de Entrada</h2>

        <!-- Formulario de selección de tipo de entrada y carga de archivo Excel -->
        <form id="entradaForm" method="POST" action="{{ route('admin.procesar.excel') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="tipoEntrada" class="form-label">Tipo de Entrada:</label>
                <select id="tipoEntrada" name="tipoEntrada" class="form-select" >
                    <option value="">Seleccione un tipo de entrada</option>
                    @foreach ($tiposDeEntrada as $tipoEntrada)
                        <option value="{{ $tipoEntrada->id }}">{{ $tipoEntrada->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Botón para abrir el file chooser -->
            <div class="mb-3">
                <button type="button" id="generarEntradas" class="btn btn-primary">Cargar Archivo de Entradas</button>
            </div>

            <!-- Input para seleccionar el archivo Excel -->
            <div class="mb-3 d-none" id="fileInputContainer">
                <label for="archivoExcel" class="form-label">Seleccione un archivo Excel:</label>
                <input type="file" id="archivoExcel" name="archivoExcel" class="form-control" accept=".xlsx, .xls" required>
            </div>

            <!-- Botón para generar las entradas del archivo cargado -->
            <div class="mb-3 d-none" id="submitContainer" >
                <button type="submit" class="btn btn-success">Generar Entradas del Excel</button>
            </div>
        </form>

        

        <!-- Entradas Generadas -->
        @if(isset($entradas) && count($entradas) > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5>Entradas Generadas</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>NRO</th>
                            <th>NIT</th>
                            <th>COD AUTORIZACION</th>
                            <th>Tipo de Entrada</th>
                            <th>Fecha Limite de Emision</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entradas as $entrada)
                            <tr>
                                <td>{{ $entrada->id }}</td>
                                <td>{{ $entrada->nit }}</td>
                                <td>{{ $entrada->codigoAutorizacion }}</td>
                                <td>{{ $entrada->tipoEntrada->nombre }}</td>
                                <td>{{$entrada->fechaLimiteEmision}}</td>
                                <td>
                                    <!-- Botón para editar con modal -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarEntradaModal-{{ $entrada->id }}">Editar</button>

                                    <!-- Modal de edición -->
                                    <div class="modal fade" id="editarEntradaModal-{{ $entrada->id }}" tabindex="-1" aria-labelledby="editarEntradaModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editarEntradaModalLabel">Editar Entrada</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('admin.editar.entradaGenerada', ['id' => $entrada->id]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <!-- Aquí agregar los campos para editar -->
                                                        <div class="mb-3">
                                                            <label for="nombreEntrada" class="form-label">Codigo de Autorizacion:</label>
                                                            <input type="text" class="form-control" id="nombreEntrada" name="codigo" value="{{ $entrada->codigoAutorizacion }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botón para eliminar con modal de confirmación -->
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarEntradaModal-{{ $entrada->id }}">Eliminar</button>

                                    <!-- Modal de confirmación para eliminar -->
                                    <div class="modal fade" id="eliminarEntradaModal-{{ $entrada->id }}" tabindex="-1" aria-labelledby="eliminarEntradaModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="eliminarEntradaModalLabel">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Está seguro que desea eliminar con codigo de autorizacion "{{ $entrada->codigoAutorizacion }}"?
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST" action="{{ route('admin.eliminar.entradaGenerada', ['id' => $entrada->id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
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
                <!-- Paginación -->
                
                <div class="d-flex justify-content-center">
                    {{ $entradas->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
    <style>
        .fade-out {
            animation: fadeOut 2s forwards; /* Animación que dura 2 segundos y se ejecuta hacia adelante */
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
    </style>
    <script>
        document.getElementById('generarEntradas').addEventListener('click', function() {
            document.getElementById('fileInputContainer').classList.remove('d-none');
            document.getElementById('submitContainer').classList.remove('d-none');
        });

        //scrip para la desaparicion de las confirmaciones o errores
          // Desaparecer automáticamente después de 5 segundos
        setTimeout(function() {
            let successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.classList.add('fade-out'); // Añadir la animación de desvanecimiento
                setTimeout(() => successAlert.style.display = 'none', 2000); // Eliminarlo después de la animación (2 segundos)
            }

            let errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                errorAlert.classList.add('fade-out'); // Añadir la animación de desvanecimiento
                setTimeout(() => errorAlert.style.display = 'none', 2000); // Eliminarlo después de la animación (2 segundos)
            }
        }, 5000);
    </script>
@endsection
