<!---esta vista solo se usa en conjunto con un controlador modifcado de guardaparqque controller
llamada show Modificado-->

@extends('layouts.template')

@section('header2')
    <title>Horario Guardaparque</title>
@endsection


@section('header')
    <!-- Page Header-->
    <div class="pagetitle">
        <h1>Perfil</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Usuario</li>
                <li class="breadcrumb-item active">Ver Horario</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection


@section('content')
<!-- Edición de datos del guardaparque -->

<h2>Guardaparque - {{ $guardaparque->nombre }}</h2>

<!-- Para mostrar las comunidades -->

<!-- Lista de comunidades asignadas al guardaparque -->
<div class="container mt-4">
    <h3>Comunidades Asignadas</h3>
    <div class="list-group">
        @forelse($comunidadesAsignadas as $comunidadAsignada)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <span>Comunidad: {{ $comunidadAsignada->comunidad_nombre }}</span>
            </div>
        @empty
            <div class="list-group-item">
                <span>No hay comunidades asignadas.</span>
            </div>
        @endforelse
    </div>
</div>

<!-- Sección para editar horarios y comunidades asignadas -->
<div class="container mt-4">
    <h3>Asignación de Comunidades y Horarios</h3>

    <!-- Lista de comunidades y horarios asignados actualmente -->
    @forelse($lugaresHorariosAsignadosAGuardaparque as $asignacion)
        <div class="card mb-3">
            <div class="card-body">
                <h5>Comunidad: {{ $asignacion->comunidad_nombre }} (Zona: {{ $asignacion->zona }})</h5>

                <h6>Días y Horarios Asignados:</h6>
                <ul>
                    <li>Día: {{ $asignacion->dia_nombre }} - {{ $asignacion->hora_inicio }} a {{ $asignacion->hora_fin }}</li>
                </ul>
            </div>
        </div>
    @empty
        <div class="card mb-3">
            <div class="card-body">
                <span>No hay comunidades ni horarios asignados.</span>
            </div>
        </div>
    @endforelse
</div>

@endsection
