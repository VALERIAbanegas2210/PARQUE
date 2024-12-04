@extends('layouts.admin_template')

@section('header')
    <div class="pagetitle">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.template') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bitacoras Guardaparques</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <div class="container">
        <h1>Bitácora de Guardaparques</h1>

        @if($bitacoras->isEmpty())
            <p>No hay registros en la bitácora.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Nombre Guardaparque</th>
                        <th>Nombre Comunidad</th>
                        <th>ID Guardaparque</th>
                        <th>ID Comunidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bitacoras as $bitacora)
                        <tr>
                            <td>{{ $bitacora->tipo }}</td>
                            <td>{{ $bitacora->fecha }}</td>
                            <td>{{ $bitacora->nombreGuardaparque }}</td>
                            <td>{{ $bitacora->nombreComunidad }}</td>
                            <td>{{ $bitacora->id_guardaparque }}</td>
                            <td>{{ $bitacora->id_comunidad }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Enlaces de paginación -->
            
            {{ $bitacoras->links('pagination::bootstrap-4') }}  
        @endif
    </div>
@endsection
