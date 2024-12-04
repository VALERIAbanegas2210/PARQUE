<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Registro - Parque Nacional</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('/usuariotemplate/administracion/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('/usuariotemplate/administracion/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('/usuariotemplate/administracion/assets/vendor/bootstrap/css/bootstrap.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('/usuariotemplate/administracion/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}"
        rel="stylesheet">
    <link href="{{ asset('/usuariotemplate/administracion/assets/vendor/boxicons/css/boxicons.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('/usuariotemplate/administracion/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('/usuariotemplate/administracion/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('/usuariotemplate/administracion/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('/usuariotemplate/administracion/assets/vendor/simple-datatables/style.css') }}"
        rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('/usuariotemplate/administracion/assets/css/style.css') }}" rel="stylesheet">

</head>

<body>

    <main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-10 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="{{route('user.usuariotemplate')}}" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">Parque Nacional Amboro</span>
                                </a>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Crear una cuenta</h5>
                                        <p class="text-center small">Introduce tus datos personales para crear una
                                            cuenta</p>
                                    </div>
                                    @if (session('success'))
                                        <div id="success-message" class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <form class="row g-3 needs-validation" novalidate enctype="multipart/form-data"
                                        action="{{ route('admin.register') }}" method="POST">
                                        @csrf

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <!-- Nacionalidad -->
                                        <div class="col-md-6">
                                            <label for="nacionalidad" class="form-label">Nacionalidad</label>
                                            <select name="nacionalidad" class="form-select" id="nacionalidad" required>
                                                <option value="">Seleccionar...</option>
                                                <option value="boliviana">Bolivia</option>
                                                <option value="ext">Ext</option>
                                            </select>
                                            <div class="invalid-feedback">¡Por favor, seleccione su Nacionalidad!</div>
                                        </div>
                                        <!-- Primera Fila: Nombre y Correo Electrónico -->
                                        <div class="col-md-6">
                                            <label for="yourName" class="form-label">Nombre</label>
                                            <input type="text" name="nombre" class="form-control" id="yourName"
                                                required>
                                            <div class="invalid-feedback">¡Por favor, introduzca su nombre!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="yourEmail" class="form-label">Correo electrónico</label>
                                            <input type="email" name="correo" class="form-control" id="yourEmail"
                                                required>
                                            <div class="invalid-feedback">¡Por favor, introduzca una dirección de correo
                                                electrónico válida!</div>
                                        </div>

                                        <!-- Segunda Fila: Nombre de usuario y Contraseña -->
                                        <div class="col-md-6">
                                            <label for="yourUsername" class="form-label">Nombre de usuario</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" name="usuario" class="form-control"
                                                    id="yourUsername" required>
                                                <div class="invalid-feedback">Por favor, elija un nombre de usuario.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="yourPassword" class="form-label">Contraseña</label>
                                            <input type="password" name="contraseña" class="form-control"
                                                id="yourPassword" required>
                                            <div class="invalid-feedback">¡Por favor, introduzca su contraseña!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="yourPasswordConfirmation" class="form-label">Confirmar
                                                Contraseña</label>
                                            <input type="password" name="contraseña_confirmation"
                                                class="form-control" id="yourPasswordConfirmation" required>
                                            <div class="invalid-feedback">¡Por favor, confirme su contraseña!</div>
                                        </div>
                                        <!-- Tercera Fila: CI y Edad -->
                                        <div class="col-md-6">
                                            <label for="ci" class="form-label">CI</label>
                                            <input type="text" name="ci" class="form-control" id="ci"
                                                required disabled>
                                            <div class="invalid-feedback">¡Por favor, introduzca su CI!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edad" class="form-label">Edad</label>
                                            <input type="number" name="edad" class="form-control" id="edad"
                                                required>
                                            <div class="invalid-feedback">¡Por favor, introduzca su edad!</div>
                                        </div>

                                        <!-- Cuarta Fila: Sexo y Pasaporte -->
                                        <div class="col-md-6">
                                            <label for="sexo" class="form-label">Sexo</label>
                                            <select name="sexo" class="form-select" id="sexo" required>
                                                <option value="">Seleccionar...</option>
                                                <option value="masculino">Masculino</option>
                                                <option value="femenino">Femenino</option>
                                            </select>
                                            <div class="invalid-feedback">¡Por favor, seleccione su sexo!</div>
                                        </div>
                                        <!-- Pasaporte -->
                                        <div class="col-md-6">
                                            <label for="pasaporte" class="form-label">Pasaporte</label>
                                            <input type="text" name="pasaporte" class="form-control"
                                                id="pasaporte" disabled>
                                            <div class="invalid-feedback">¡Por favor, introduzca su pasaporte!</div>
                                        </div>

                                        <!-- Botón de enviar -->
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Crear una
                                                cuenta</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">¿Ya tienes una cuenta? <a
                                                    href="{{ route('administracion.login') }}">Inicia sesión</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('/usuariotemplate/administracion/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}">
    </script>
    <script src="{{ asset('/usuariotemplate/administracion/assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('/usuariotemplate/administracion/assets/vendor/simple-datatables/simple-datatables.js') }}">
    </script>
    <script src="{{ asset('/usuariotemplate/administracion/assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('/usuariotemplate/administracion/assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('/usuariotemplate/administracion/assets/js/main.js') }}"></script>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 5000); // 5000 ms = 5 segundos
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const nacionalidadField = document.getElementById('nacionalidad');
        const ciField = document.getElementById('ci');
        const pasaporteField = document.getElementById('pasaporte');

        // Función para ajustar los campos según la nacionalidad
        function ajustarCampos() {
            if (nacionalidadField.value === 'boliviana') {
                pasaporteField.value = '';
                pasaporteField.setAttribute('disabled', 'disabled');
                ciField.removeAttribute('disabled');
            } else if (nacionalidadField.value === 'ext') {
                ciField.value = '';
                ciField.setAttribute('disabled', 'disabled');
                pasaporteField.removeAttribute('disabled');
            } else {
                // Si no se selecciona nada, ambos campos están deshabilitados
                ciField.value = '';
                pasaporteField.value = '';
                ciField.setAttribute('disabled', 'disabled');
                pasaporteField.setAttribute('disabled', 'disabled');
            }
        }

        // Ejecutar cuando la página carga
        ajustarCampos();

        // Ejecutar cuando el usuario cambia la nacionalidad
        nacionalidadField.addEventListener('change', ajustarCampos);
    });
    document.getElementById('yourPassword').addEventListener('input', function() {
        const password = this.value;
        const feedback = document.querySelector('.invalid-feedback');
        if (password.length < 8) {
            feedback.textContent = 'La contraseña debe tener al menos 8 caracteres.';
            feedback.style.display = 'block';
        } else {
            feedback.style.display = 'none';
        }
    });
</script>

</html>
