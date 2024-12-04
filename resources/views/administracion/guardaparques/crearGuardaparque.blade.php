@extends('layouts.admin_template')

@section('content')
    <div class="container">
        <h1>Crear Guardaparque</h1>
         <!-- Estilos para hacer el placeholder más transparente -->
         <style>
             .form-control::placeholder {
                color: rgba(0, 0, 0, 0.3); 
              }
        </style>
        <!-- Mensajes de éxito y error -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <!-- Formulario de creación de Guardaparque -->
        <form action="{{ route('admin.guardaparque.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Nombre -->
            <div class="row mb-3">
                <label for="nombre" class="col-md-4 col-lg-3 col-form-label">Nombre</label>
                <div class="col-md-8 col-lg-9">
                    <input type="text" name="nombre" class="form-control" required placeholder="Escribe tu nombre">
                </div>
            </div>
            
            <!-- CI -->
            <div class="row mb-3">
                <label for="ci" class="col-md-4 col-lg-3 col-form-label">CI</label>
                <div class="col-md-8 col-lg-9">
                    <input type="text" name="CI" class="form-control" required placeholder="Escribe tu CI">
                </div>
            </div>
            
            <!-- Edad -->
            <div class="row mb-3">
                <label for="edad" class="col-md-4 col-lg-3 col-form-label">Edad</label>
                <div class="col-md-8 col-lg-9">
                    <input type="number" name="edad" class="form-control" required placeholder="Escribe tu edad">
                </div>
            </div>
            
            <!-- Correo -->
            <div class="row mb-3">
                <label for="correo" class="col-md-4 col-lg-3 col-form-label">Correo Electrónico</label>
                <div class="col-md-8 col-lg-9">
                    <input type="email" name="correo" class="form-control" required placeholder="Escribe tu correo">
                </div>
            </div>
            
            <!-- Sexo -->
            <div class="row mb-3">
                <label for="sexo" class="col-md-4 col-lg-3 col-form-label">Sexo</label>
                <div class="col-md-8 col-lg-9">
                    <select name="sexo" class="form-select" required>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                    </select>
                </div>
            </div>
            
            <!-- Número de Celular -->
            <div class="row mb-3">
                <label for="nroCelular" class="col-md-4 col-lg-3 col-form-label">Número de Celular</label>
                <div class="col-md-8 col-lg-9">
                    <input type="text" name="nroCelular" class="form-control" required placeholder="Escribe tu numero celular">
                </div>
            </div>
            
            <!-- Contraseña -->
            <div class="row mb-3">
                <label for="contraseña" class="col-md-4 col-lg-3 col-form-label">Contraseña</label>
                <div class="col-md-8 col-lg-9">
                    <input type="password" name="contraseña" class="form-control" placeholder="password is here" required>
                </div>
            </div>
            
            <!-- Botón para enviar el formulario -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Guardar Guardaparque</button>
            </div>
        </form>
    </div>
@endsection

