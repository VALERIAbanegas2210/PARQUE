@extends('layouts.admin_template')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4">Bitácora de Sesiones</h1>
        <div class="card shadow">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Fecha y Hora</th>
                            <th scope="col">Ip</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bitacoras as $bitacora)
                            <tr>
                                <td>{{ $bitacora->id }}</td>
                                <td>{{ $bitacora->user->nombre ?? 'Usuario no encontrado' }}</td>
                                <!-- Relación con el modelo User -->
                                <td>{{ $bitacora->action }}</td> <!-- 'login' o 'logout' -->
                                <td>{{ $bitacora->created_at }}</td>
                                <td>{{ $bitacora->ip_address }}</td> <!-- Dirección IP -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $bitacoras->links('vendor.pagination.bootstrap-4') }}
                    <!-- Usamos la vista de Bootstrap para la paginación -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <a href="{{ route('bitacora.index') }}" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>
@endsection
