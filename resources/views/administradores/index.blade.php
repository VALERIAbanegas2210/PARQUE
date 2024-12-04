@extends('layouts.admin_template')

@section('header2')
    <title>PERFIL</title>
@endsection


@section('header')
    <!-- Page Header-->
    <div class="pagetitle">
        <h1>Perfil</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Usuario</li>
                <li class="breadcrumb-item active">Perfil</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="{{ Auth::guard('usuarios')->user()->profile_image
                            ? asset('storage/' . Auth::guard('usuarios')->user()->profile_image)
                            : (Auth::guard('usuarios')->user()->sexo == 'masculino'
                                ? asset('/usuariotemplate/administracion/assets/img/default-masculino.jpg')
                                : asset('/usuariotemplate/administracion/assets/img/default-femenino.jpg')) }}"
                            alt="Profile" class="rounded-circle">

                        <h2>{{ Auth::guard('usuarios')->user()->nombre }}</h2>
                        <h3>{{ Auth::guard('usuarios')->user()->correo }}</h3>
                        <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success" id="success-alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Visión general</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar
                                    Perfil</button>
                            </li>


                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-change-password">Cambiar contraseña</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <!-- Bordered Tabs -->

                                <h5 class="card-title">Detalles del Perfil</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Nombre Completo</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::guard('usuarios')->user()->nombre }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Usuario</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::guard('usuarios')->user()->usuario }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Correo</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::guard('usuarios')->user()->correo }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">CI</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::guard('usuarios')->user()->ci }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Edad</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::guard('usuarios')->user()->edad }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Sexo</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::guard('usuarios')->user()->sexo }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Pasaporte</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::guard('usuarios')->user()->pasaporte }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Nacionalidad</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::guard('usuarios')->user()->nacionalidad }}
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <!-- Profile Edit Form -->
                                <form action="{{ route('admin.update', Auth::guard('usuarios')->user()->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT') <!-- Cambia el método a PUT para la actualización -->
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Imagen de
                                            Perfil</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img id="profileImagePreview"
                                                src="{{ Auth::guard('usuarios')->user()->profile_image
                                                    ? asset('storage/' . Auth::guard('usuarios')->user()->profile_image)
                                                    : (Auth::guard('usuarios')->user()->sexo == 'masculino'
                                                        ? asset('/usuariotemplate/administracion/assets/img/default-masculino.jpg')
                                                        : asset('/usuariotemplate/administracion/assets/img/default-femenino.jpg')) }}"
                                                alt="Profile">
                                            <div class="pt-2">
                                                <input type="file" name="profile_image" id="profile_image"
                                                    style="display: none;" accept="image/*">
                                                <a class="btn btn-primary btn-sm" title="Subir nueva imagen de perfil"
                                                    id="uploadBtn">
                                                    <i class="bi bi-upload"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm" title="Eliminar mi imagen de perfil"
                                                    id="deleteImageBtn">
                                                    <i class="bi bi-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nombre
                                            Completo</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="fullName" type="text" class="form-control" id="fullName"
                                                value="{{ Auth::guard('usuarios')->user()->nombre }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="username" class="col-md-4 col-lg-3 col-form-label">Usuario</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="username" type="text" class="form-control" id="username"
                                                value="{{ Auth::guard('usuarios')->user()->usuario }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Correo</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="email"
                                                value="{{ Auth::guard('usuarios')->user()->correo }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="ci" class="col-md-4 col-lg-3 col-form-label">CI</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="ci" type="text" class="form-control" id="ci"
                                                value="{{ Auth::guard('usuarios')->user()->ci }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="age" class="col-md-4 col-lg-3 col-form-label">Edad</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="age" type="number" class="form-control" id="age"
                                                value="{{ Auth::guard('usuarios')->user()->edad }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="gender" class="col-md-4 col-lg-3 col-form-label">Sexo</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select name="gender" class="form-select" id="gender">
                                                <option value="femenino"
                                                    {{ Auth::guard('usuarios')->user()->sexo == 'femenino' ? 'selected' : '' }}>
                                                    Femenino</option>
                                                <option value="masculino"
                                                    {{ Auth::guard('usuarios')->user()->sexo == 'masculino' ? 'selected' : '' }}>
                                                    Masculino</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="passport" class="col-md-4 col-lg-3 col-form-label">Pasaporte</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="passport" type="text" class="form-control" id="passport"
                                                value="{{ Auth::guard('usuarios')->user()->pasaporte }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="nationality"
                                            class="col-md-4 col-lg-3 col-form-label">Nacionalidad</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select name="nationality" class="form-select" id="nationality">
                                                <option value="BOLIVIA"
                                                    {{ Auth::guard('usuarios')->user()->nacionalidad == 'BOLIVIA' ? 'selected' : '' }}>
                                                    BOLIVIA</option>
                                                <option value="EXT"
                                                    {{ Auth::guard('usuarios')->user()->nacionalidad == 'EXT' ? 'selected' : '' }}>
                                                    EXT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->
                            </div>




                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form method="POST" action="{{ route('updateProfile') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Contraseña
                                            Actual</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="current_password" type="password" class="form-control"
                                                id="currentPassword" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nueva
                                            Contraseña</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="new_password" type="password" class="form-control"
                                                id="newPassword" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirmar
                                            Nueva Contraseña</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="new_password_confirmation" type="password" class="form-control"
                                                id="renewPassword" required>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Cambiar Datos</button>
                                    </div>
                                </form>

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
    <script>
        document.getElementById('deleteImageBtn').addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto del enlace

            // Cambiar la imagen de vista previa a la predeterminada según el sexo
            const userSex = "{{ Auth::guard('usuarios')->user()->sexo }}"; // Obtener el sexo del usuario
            const defaultImage = userSex === 'masculino' ?
                '{{ asset('/usuariotemplate/administracion/assets/img/default-masculino.jpg') }}' :
                '{{ asset('/usuariotemplate/administracion/assets/img/default-femenino.jpg') }}';

            document.getElementById('profileImagePreview').src = defaultImage;

            // Realizar una petición AJAX para eliminar la imagen del servidor
            fetch('{{ route('deleteProfileImage') }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        user_id: {{ Auth::guard('usuarios')->user()->id }}
                    })
                })

                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Imagen de perfil eliminada exitosamente.');
                    } else {
                        console.error('Error al eliminar la imagen de perfil.');
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        document.getElementById('uploadBtn').addEventListener('click', function() {
            document.getElementById('profile_image').click();
        });

        document.getElementById('profile_image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImagePreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
        setTimeout(function() {
            document.getElementById('success-alert').style.display = 'none';
        }, 5000); // Desaparece después de 5 segundos
    </script>
@endsection

@section('footer')
    <a href="{{ route('admin.index') }}" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
@endsection
