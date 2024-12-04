@extends('layouts.template')

@section('header2')
    <title>Editar Rol</title>
@endsection

@section('header')
    <div class="pagetitle">
        <h1>Editar Rol</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.template') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.Roles.index') }}">Roles</a></li>
                <li class="breadcrumb-item active">Editar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Editar Rol</h5>

                        <form action="{{ route('admin.Roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="roleName" class="form-label">Nombre del Rol</label>
                                <input type="text" class="form-control" id="roleName" name="name"
                                    value="{{ $role->name }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar Rol</button>
                            <a href="{{ route('admin.Roles.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
