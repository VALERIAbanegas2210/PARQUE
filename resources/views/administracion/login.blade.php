<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login - Parque Nacional</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('/usuariotemplate/administracion/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('/usuariotemplate/administracion/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('/usuariotemplate/administracion/assets/vendor/bootstrap/css/bootstrap.min.css') }}"
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

            <section class="section register min-vh-100 d-flex align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">

                        <!-- Columna izquierda: Video y foto -->
                        <div class="col-lg-8 d-flex flex-column align-items-center justify-content-center">
                            <!-- Video -->
                            <!-- Video con autoplay, sin controles ni barra de tiempo -->
                            <video width="100%" autoplay muted playsinline>
                                <source src="{{ asset('/usuariotemplate/administracion/assets/img/video_Amboro.mp4') }}"
                                    type="video/mp4">
                                Tu navegador no soporta la etiqueta de video.
                            </video>
                            <img src="{{ asset('/usuariotemplate/administracion/assets/img/imagen_de_video.jpg') }}"
                                alt="Descripción de la imagen" class="img-fluid">

                        </div>

                        <!-- Columna derecha: Formulario de login -->
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4">
                                <a href="{{route('user.usuariotemplate')}}" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ asset('/usuariotemplate/administracion/assets/img/favicon.png') }}"
                                        alt="">
                                    <span class="d-none d-lg-block">Parque Nacional Amboro</span>
                                </a>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Inicie sesión en su cuenta</h5>
                                        <p class="text-center small">Ingrese su nombre de usuario y contraseña para
                                            iniciar sesión</p>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <!--Inicio del formulario-->
                                    
                                    <form class="row g-4 needs-validation"method="POST"
                                        action="{{ route('login.submit') }}" novalidate>
                                        {{ csrf_field() }}
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Correo</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="correo" class="form-control"
                                                    id="yourUsername" required>
                                                <div class="invalid-feedback">Por favor, introduzca su nombre de
                                                    usuario.</div>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Contraseña</label>
                                            <input type="password" name="contraseña" class="form-control"
                                                id="yourPassword" required>
                                            <div class="invalid-feedback">¡Por favor, introduzca su contraseña!</div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    value="true" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Recordar</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Iniciar sesión</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">¿No tienes cuenta? <a
                                                    href="{{ route('administracion.registro') }}">Crear
                                                    Una Cuenta</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div><!-- Fin Columna derecha -->

                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('/usuariotemplate/administracion/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('/usuariotemplate/administracion/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}">
    </script>
    <script src="{{ asset('/usuariotemplate/administracion/assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('/usuariotemplate/administracion/assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('/usuariotemplate/administracion/assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('/usuariotemplate/administracion/assets/vendor/simple-datatables/simple-datatables.js') }}">
    </script>
    <script src="{{ asset('/usuariotemplate/administracion/assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('/usuariotemplate/administracion/assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('/usuariotemplate/administracion/assets/js/main.js') }}"></script>

</body>

</html>
