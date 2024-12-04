@extends('layouts.admin_template')

@section('content')
    <div class="container">
        <h1>Lista de Guardaparques</h1>

        <!-- Barra de búsqueda -->
        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar Guardaparque por nombre">
        </div>
        
        <!-- Tabla de guardaparques -->
        <table class="table table-striped" id="guardaparquesTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>CI</th>
                    <th>Edad</th>
                    <th>Sexo</th>
                    <th>Correo</th>
                    <th>Número de Celular</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guardaparques as $guardaparque)
                    <tr class="guardaparqueRow">
                        <td>{{ $guardaparque->id }}</td>
                        <td class="nombre">{{ $guardaparque->nombre }}</td>
                        <td>{{ $guardaparque->CI }}</td>
                        <td>{{ $guardaparque->edad }}</td>
                        <td>{{ $guardaparque->sexo }}</td>
                        <td>{{ $guardaparque->correo }}</td>
                        <td>{{ $guardaparque->nroCelular }}</td>
                        <td>
                            <!-- Botón para Editar Perfil -->
                            <a href="{{ route('admin.guardaparque.edit', $guardaparque->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            <!-- Botón para Ver Bitácora -->

                            

                            <a href="{{ route('admin.guardaparque.bitacoraGuarda', $guardaparque->id) }}" class="btn btn-info btn-sm" title="Ver Bitácora">
                                <i class="fas fa-book"></i> Ver Bitácora
                            </a>

                            <!-- Botón para Eliminar -->
                            <form action="{{ route('admin.guardaparque.delete', $guardaparque->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este guardaparque?')">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Script de búsqueda en tiempo real -->
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#guardaparquesTable .guardaparqueRow');
            
            rows.forEach(row => {
                let nombre = row.querySelector('.nombre').textContent.toLowerCase();
                if (nombre.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
