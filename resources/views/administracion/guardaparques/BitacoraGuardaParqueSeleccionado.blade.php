@extends('layouts.admin_template')

@section('content')
    <div class="container">
        <h1>Bitácora del Guardaparque</h1>

        @if (count($bitacora) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Comunidad</th>
                        <th>Guardaparque</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bitacora as $registro)
                        <tr>
                            <td>{{ $registro->id }}</td>
                            <td>{{ $registro->nombreComunidad }}</td>
                            <td>{{ $registro->nombreGuardaparque }}</td>
                            <td>{{ $registro->fecha }}</td>
                            <td>{{ $registro->tipo }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay registros en la bitácora para este guardaparque.</p>
        @endif
    </div>
@endsection
