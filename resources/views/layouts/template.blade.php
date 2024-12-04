<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    @section('header2')
        <title>Dashboard - Parque Nacional</title>
    @endsection
    @yield('header2')
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


    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.css">-->
    <!-- =======================================================
    * Template Name: NiceAdmin
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Updated: Apr 20 2024 with Bootstrap v5.3.3
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>

    @if(session('success') && session('source') === 'reserva')
        <script>
             // Simula un tiempo de carga (esto debería estar sincronizado con tu backend o eventos reales)
             setTimeout(() => {
                // Ocultar el indicador de carga
                const loadingContainer = document.getElementById('loading-container');
                if (loadingContainer) {
                    loadingContainer.style.display = 'none';
                }

                // Mostrar el modal de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            }, 3000); // Cambiar a la duración real de la carga, si aplica
        </script>
    @endif
    @if(session('error')  && session('source') === 'reserva')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
            // Simula un tiempo de carga (esto debería estar sincronizado con tu backend o eventos reales)
            setTimeout(() => {
                // Ocultar el indicador de carga
                const loadingContainer = document.getElementById('loading-container');
                if (loadingContainer) {
                    loadingContainer.style.display = 'none';
                }

                // Mostrar el modal de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    showConfirmButton: true
                });
            }, 3000); // Cambiar a la duración real de la carga, si aplica
        });
        </script>
    @endif

    <div id="loading-container">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
        <h4>Cargando...</h4>
    </div>
    <style>
                /* Contenedor del indicador de carga */
        #loading-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        /* Animación del spinner */
        .spinner {
            width: 40px;
            height: 40px;
            position: relative;
        }

        .double-bounce1,
        .double-bounce2 {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #007bff; /* Cambiar el color según tu diseño */
            opacity: 0.6;
            position: absolute;
            top: 0;
            left: 0;
            animation: bounce 2s infinite ease-in-out;
        }

        .double-bounce2 {
            animation-delay: -1s;
        }

        @keyframes bounce {
            0%, 100% {
                transform: scale(0);
            }
            50% {
                transform: scale(1);
            }
        }

        /* Texto debajo del spinner */
        #loading-container h4 {
            margin-top: 15px;
            font-size: 1.2rem;
            font-weight: 500;
            color: #333;
        }

    </style>



    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{route('user.usuariotemplate')}}}" class="logo d-flex align-items-center">
                <img src="{{ asset('/usuariotemplate/administracion/assets/img/favicon.png') }}" alt="">
                <span class="d-none d-lg-block">Parque Nacional Amboro</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->



                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ Auth::guard('usuarios')->user()->profile_image
                            ? asset('storage/' . Auth::guard('usuarios')->user()->profile_image)
                            : (Auth::guard('usuarios')->user()->sexo == 'masculino'
                                ? asset('/usuariotemplate/administracion/assets/img/default-masculino.jpg')
                                : asset('/usuariotemplate/administracion/assets/img/default-femenino.jpg')) }}"
                            alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">
                            @if (Auth::guard('usuarios')->check())
                                {{ Auth::guard('usuarios')->user()->nombre }}
                            @else
                                Invitado
                            @endif
                        </span>

                    </a><!-- End Profile Image Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            @if (Auth::guard('usuarios')->check())
                                <h6>{{ Auth::guard('usuarios')->user()->nombre }}</h6>
                                <span>{{ Auth::guard('usuarios')->user()->correo }}</span>
                                <!-- Aquí mostramos el rol del usuario -->
                                <br>
                                <div>
                                    <strong>Roles:</strong>
                                    @foreach (Auth::guard('usuarios')->user()->roles as $role)
                                        <span>{{ $role->name }}</span>{{ $loop->last ? '' : ',' }}
                                        <!-- Muestra los roles separados por comas -->
                                    @endforeach
                                </div>
                            @else
                                <h6>Invitado</h6>
                                <span></span>
                            @endif
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('usuarios.perfil') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            <a class="dropdown-item d-flex align-items-center" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>


                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->



            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('layouts.template') ? '' : 'collapsed' }}"
                href="{{ route('layouts.template') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('usuarios.perfil') ? '' : 'collapsed' }}"
                href="{{ route('usuarios.perfil') }}">
                <i class="bi bi-person"></i>
                <span>Perfil</span>
            </a>
        </li><!-- End Profile Page Nav -->
        @if (Auth::guard('usuarios')->check() && Auth::guard('usuarios')->user()->hasRole('usuario'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('usuarios.tipo_entrada') ? '' : 'collapsed' }}"
                    href="{{ route('usuarios.tipo_entrada') }}">
                    <i class="bi bi-person"></i>
                    <span>Compra de entrada</span>
                </a>
            </li><!-- End tiket Page Nav -->
        @endif

        <!-- End tiket Page Nav -->
        <!---vista solo pa guardaparque-->
        @if (Auth::guard('usuarios')->check() && Auth::guard('usuarios')->user()->hasRole('guardaparque'))
            <li class="nav-item">
                <a class="nav-link"  href="{{ route('usuarios.guardaparque.verHorario', ['id' => Auth::guard('usuarios')->user()->id]) }}">  
                    <i class="bi bi-layout-text-window-reverse"></i>
                    <span>Ver Horario</span>
                </a>
            </li><!-- End tiket Page Nav -->
        @endif
        
       
            <li class="nav-item">
                <a class="nav-link" href="{{ route('usuarios.k') }}">  
                    <i class="bi bi-layout-text-window-reverse"></i>
                    <span>prueba</span>
                </a>
            </li><!-- End tiket Page Nav -->
        @if (Auth::guard('usuarios')->check() && Auth::guard('usuarios')->user()->hasRole('usuario'))
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#turista-actividad-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i>
                    <span>Mi Actividad En El parque</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="turista-actividad-nav" class="collapse" data-bs-parent="#sidebar-nav"> 
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('usuario.show.reserva') }}">
                            <i class="bi bi-person"></i>
                            <span>Mis Reservas Pendientes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('usuario.reservasPagadas') }}">
                            <i class="bi bi-person"></i>
                            <span>Mis Reservas Pagadas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('usuario.actividadEnCurso') }}">
                            <i class="bi bi-person"></i>
                            <span>Actividad En Curso</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        

        @if (Auth::guard('usuarios')->check() && Auth::guard('usuarios')->user()->hasRole('guardaparque'))
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#negocio-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i>
                    <span>Negocio</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="negocio-nav" class="collapse" data-bs-parent="#sidebar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.formulario.create') }}">
                            <i class="bi bi-person"></i>
                            <span>Vender Entrada</span>
                        </a>
                    </li><!-- End Vender Entrada Page Nav -->
            
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.show.reserva.pendiente') }}">
                            <i class="bi bi-person"></i>
                            <span>Mis Reservas Pendientes</span>
                        </a>
                    </li><!-- End Mis Reservas Pendientes Page Nav -->
            
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.show.reserva.pagada') }}">
                            <i class="bi bi-person"></i>
                            <span>Mis Reservas Pagadas</span>
                        </a>
                    </li><!-- End Mis Reservas Pagadas Page Nav -->
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('usuario.formulariosPendientes.comunidad') }}">
                            <i class="bi bi-person"></i>
                            <span>Reservas Pendientes</span>
                        </a>
                    </li><!-- End Mis Reservas Pendientes Page Nav -->
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('usuario.formulariosPagados.comunidad') }}">
                            <i class="bi bi-person"></i>
                            <span>Reservas pagadas</span>
                        </a>
                    </li><!-- End Mis Reservas Pendientes Page Nav -->
                </ul>
            </li>
        @endif   
    


            

        
        <li class="nav-item">
            <a class="nav-link" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i>
                <span>Comunidades</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="{{ request()->routeIs('comunidad.show_villa_amoboro', ['id' => 5]) ? 'active' : '' }}"
                        href="{{ route('comunidad.show_villa_amoboro', ['id' => 5]) }}">
                        <i class="bi bi-circle"></i>
                        <span>Villa Amboro</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('comunidad.show_jardin_de_las_delicias', ['id' => 7]) ? 'active' : '' }}"
                        href="{{ route('comunidad.show_jardin_de_las_delicias', ['id' => 7]) }}">
                        <i class="bi bi-circle"></i>
                        <span>Jardin de las delicias</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('comunidad.show_la_chonta', ['id' => 2]) ? 'active' : '' }}"
                        href="{{ route('comunidad.show_la_chonta', ['id' => 2]) }}">
                        <i class="bi bi-circle"></i>
                        <span>La chonta</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('comunidad.show_mataracu', ['id' => 1]) ? 'active' : '' }}"
                        href="{{ route('comunidad.show_mataracu', ['id' => 1]) }}">
                        <i class="bi bi-circle"></i>
                        <span>Mataracu</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('comunidad.show_oriente', ['id' => 3]) ? 'active' : '' }}"
                        href="{{ route('comunidad.show_oriente', ['id' => 3]) }}">
                        <i class="bi bi-circle"></i>
                        <span>Oriente</span>
                    </a>
                </li>
            </ul>

        </li>

    </ul>
</aside><!-- End Sidebar -->




    <main id="main" class="main">

        <div class="pagetitle">
            @yield('header')
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="container">
                <div class="row">
                    @yield('content')
                    
                  <!-- Revenue Card Aquí -->
                    <!--<div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li><h6>Filter</h6></li>
                            <li><a href="#">Today</a></li>
                            <li><a href="#">This Month</a></li>
                            <li><a href="#">This Year</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Revenue <span>| This Month</span></h5>
                            <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ps-3">
                                <h6>$3,264</h6>
                                <span class="text-success fw-bold">8%</span>
                                <span class="text-muted">increase</span>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>-->
                </div>
            </div>
        </section>
        

    </main>

    

    <script>

        document.addEventListener('DOMContentLoaded', () => {
            const loadingContainer = document.getElementById('loading-container');
            // Ocultar el indicador después de 1 segundo (simulación)
            setTimeout(() => {
                loadingContainer.style.opacity = '0';
                loadingContainer.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    loadingContainer.style.display = 'none';
                }, 500);
            }, 1000); // Puedes ajustar el tiempo según tus necesidades
        });


        window.history.pushState(null, document.title, window.location.href);
        window.addEventListener('popstate', function(event) {
            window.history.pushState(null, document.title, window.location.href);
            // Aquí puedes agregar un mensaje o redirigir
            // alert("No puedes volver a la página anterior.");
            window.location.href = "{{ route('layouts.template') }}"; // Redirigir si se intenta volver
        });
    </script>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('/usuariotemplate/administracion/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>-->
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
    
    

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
