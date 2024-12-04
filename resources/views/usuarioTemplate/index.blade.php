<!DOCTYPE html>
<html lang="en">
<!--INICIO / DE LA PAGINA-->
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Inicio</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/usuariotemplate/principal/assets/favicon.ico') }}" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('/usuariotemplate/principal/css/styles.css') }}" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <!--Barra de navegacion-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top">Parque Nacional</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#about">Historia</a></li>
                    <li class="nav-item"><a class="nav-link" href="#projects">Flora/Fauna</a></li>
                    <li class="nav-item"><a class="nav-link" href="#signup">Contactos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('administracion.login') }}">Login</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('administracion.registro') }}">Registrar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
            <div class="d-flex justify-content-center">
                <div class="text-center">
                    <h1 class="mx-auto my-0 text-uppercase">Parque Nacional Amboro</h1>
                    <h2 class="text-white-50 mx-auto mt-2 mb-5">
                        Reserva de fauna, protejida por las autoridades
                        Bolivianas
                        y aduaneras, Bolivia-Santa Cruz
                    </h2>

                    <!--boton para reservar un cupo--->

                    <a class="btn btn-primary" href="{{route('administracion.login')}}">Reserva tu Cupo</a>
                </div>
            </div>
        </div>
    </header>
    <!-- About-->
    <section class="about-section text-center" id="about">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4">¿Cuándo se crea el Parque Nacional Amboró?</h2>
                    <p class="text-white-40">
                        Los inicios del <strong>Parque Nacional
                            Amboró</strong> datan desde principios de 1970, cuando una sección del <strong>Cerro
                            Amboro</strong> fue declarada <strong>«Reserva Natural Tcnl. German Busch»</strong> en 1973.
                    <p>Posteriormente, en 1984 el área protegida es reasignada como <strong>Parque Nacional
                            Amboró</strong> con una extensión de 180.000 ha. Subsecuentes expansiones y reajustes
                        provocaron una expansión del área protegida hasta 442.500 ha, rodeada por el <strong>Área de
                            Manejo Integrado</strong>.</p>
                    </p>
                </div>
            </div>
            <img class="img-fluid" src="{{ asset('/usuariotemplate/principal/assets/img/fondoParque.png') }}"
                alt="..." />
        </div>
    </section>
    <!-- Projects-->
    <section class="projects-section bg-light" id="projects">
        <div class="container px-4 px-lg-5">
            <!-- Featured Project Row-->
            <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
                <div class="col-xl-8 col-lg-7"><img class="img-fluid mb-3 mb-lg-0"
                        src="{{ asset('/usuariotemplate/principal/assets/img/Laguna.jpg') }}" alt="..." /></div>
                <div class="col-xl-4 col-lg-5">
                    <div class="featured-text text-center text-lg-left">
                        <h4>Flora</h4>
                        <p class="text-black-50 mb-0">
                            El <strong>área del Parque Nacional
                                Amboró</strong> se caracteriza por poseer una gran diversidad florística. Existen
                            aproximadamente 3.000 especies de plantas registradas para el área. Entre la gran diversidad
                            se destacan numerosas especies de orquídeas, los helechosarbóreos gigantes (Cyathea y
                            Alsophyla) que forman extensos parches. Así como especies económicamente importantes como el
                            pacay (Inga velutina), el asaí (Euterpe precatoria) y el guitarrero (Didymopanax
                            morototoni). Así como especies maderables como la mara o caoba americana (Swietenia
                            macrophylla), el pino de monte (Podocarpus spp.) y el nogal (Juglans boliviana).
                        </p>
                    </div>
                </div>
            </div>
            <!-- Project One Row-->
            <div class="row gx-0 mb-5 mb-lg-0 justify-content-center">
                <div class="col-lg-6"><img class="img-fluid"
                        src="{{ asset('/usuariotemplate/principal/assets/img/animal1.png') }}" alt="..." /></div>
                <div class="col-lg-6">
                    <div class="bg-black text-center h-100 project">
                        <div class="d-flex h-100">
                            <div class="project-text w-100 my-auto text-center text-lg-left">
                                <h4 class="text-white">Oso andino</h4>
                                <p class="mb-0 text-white-50">No es un oso de gran tamaño, el oso andino llega a medir
                                    en promedio entre 1,30 y 1,90 m de alto y puede llegar a pesar entre 80 a 125 kg.
                                    Aunque no hay un dimorfismo sexual muy acentuado, los machos son más grades que las
                                    hembras de la especie.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Project Two Row-->
            <div class="row gx-0 justify-content-center">
                <div class="col-lg-6"><img class="img-fluid"
                        src="{{ asset('/usuariotemplate/principal/assets/img/animal2.png') }}" alt="..." /></div>
                <div class="col-lg-6 order-lg-first">
                    <div class="bg-black text-center h-100 project">
                        <div class="d-flex h-100">
                            <div class="project-text w-100 my-auto text-center text-lg-right">
                                <h4 class="text-white">Pava de copete</h4>
                                <p class="mb-0 text-white-50">En la última década ha desaparecido más del 90% de los
                                    bosques que son utilizados por esta especie para vivir, aún siendo el parque
                                    nacional Amboró un área protegida, la situación del ave evidencia que los recursos
                                    financieros y humanos necesarios para asegurar la protección de estas áreas, no son
                                    suficientes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Project One Row-->
            <div class="row gx-0 mb-5 mb-lg-0 justify-content-center">
                <div class="col-lg-6"><img class="img-fluid"
                        src="{{ asset('/usuariotemplate/principal/assets/img/animal3.jpg') }}" alt="..." /></div>
                <div class="col-lg-6">
                    <div class="bg-black text-center h-100 project">
                        <div class="d-flex h-100">
                            <div class="project-text w-100 my-auto text-center text-lg-left">
                                <h4 class="text-white">Tucan</h4>
                                <p class="mb-0 text-white-50">Se denomina tucán a los miembros de la familia
                                    Ramphastidae, que se compone de 5 géneros y aproximadamente 42 especies. Se trata de
                                    un ave cuyo nombre proviene de la palabra tukana, que a su vez pertenece a la lengua
                                    tupí. Es además fácilmente reconocible por su pico largo y colorido; y asociado con
                                    la selva y el ambiente tropical.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Signup-->
    <section class="signup-section" id="signup">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5">
                <div class="col-md-10 col-lg-8 mx-auto text-center">
                    <i class="far fa-paper-plane fa-2x mb-2 text-white"></i>
                    <h2 class="text-white mb-5">¡Suscríbete para recibir actualizaciones!</h2>
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- * * SB Forms Contact Form * *-->
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- This form is pre-integrated with SB Forms.-->
                    <!-- To make this form functional, sign up at-->
                    <!-- https://startbootstrap.com/solution/contact-forms-->
                    <!-- to get an API token!-->
                    <form class="form-signup" id="contactForm" data-sb-form-api-token="API_TOKEN">
                        <!-- Email address input-->
                        <div class="row input-group-newsletter">
                            <div class="col"><input class="form-control" id="emailAddress" type="email"
                                    placeholder="INTRODUZCA LA DIRECCION DE CORREO ELECTRONICO."
                                    aria-label="Enter email address..." data-sb-validations="required,email" /></div>
                            <div class="col-auto"><button class="btn btn-primary disabled" id="submitButton"
                                    type="submit">!NOTIFICAME!</button></div>
                        </div>
                        <div class="invalid-feedback mt-2" data-sb-feedback="emailAddress:required">
                            El correo electrónico es Obligatorio.</div>
                        <div class="invalid-feedback mt-2" data-sb-feedback="emailAddress:email">
                            El correo electrónico no es válido.
                        </div>
                        <!-- Submit success message-->
                        <!---->
                        <!-- This is what your users will see when the form-->
                        <!-- has successfully submitted-->
                        <div class="d-none" id="submitSuccessMessage">
                            <div class="text-center mb-3 mt-2 text-white">
                                <div class="fw-bolder">¡Envío de formulario exitoso!</div>
                            </div>
                        </div>
                        <!-- Submit error message-->
                        <!---->
                        <!-- This is what your users will see when there is-->
                        <!-- an error submitting the form-->
                        <div class="d-none" id="submitErrorMessage">
                            <div class="text-center text-danger mb-3 mt-2">¡Error al enviar el mensaje!</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact-->
    <!--esta seccion es para la direccion-email-celular-->  
    <!--div para las redes sociales aun no fucionan-->
    <section class="contact-section bg-black">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marked-alt text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">Direccion</h4>
                            <hr class="my-4 mx-auto" />
                            <div class="small text-black-50">Av. SiempreVIVA 123</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-envelope text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">Email</h4>
                            <hr class="my-4 mx-auto" />
                            <div class="small text-black-50"><a href="#!">diegohonor43@gmail.com</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-mobile-alt text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">Celular</h4>
                            <hr class="my-4 mx-auto" />
                            <div class="small text-black-50">+ (00591) 69019400</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--div para las redes sociales aun no fucionan-->
            <div class="social d-flex justify-content-center">
                <a class="mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                <a class="mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                <a class="mx-2" href="#!"><i class="fab fa-github"></i></a>
            </div>
        </div>
    </section>
    <!-- Footer innecesario solo para poner copyrigth-->
    <footer class="footer bg-black small text-center text-white-50">
        <div class="container px-4 px-lg-5">Copyright &copy; Your Website 2023</div>
    </footer>
    <!-- Bootstrap core JS,importar libreria de bootstrap me imagino-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS no tengo ni idea-->
    <script src="{{ asset('/usuariotemplate/principal/js/scripts.js') }}"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>
