@extends('layouts.admin_template')

@section('header2')
    <title>{{ $comunidad->nombre }}</title>
    <!-- Google Fonts for Modern Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .pagetitle {
            margin-bottom: 20px;
        }

        .breadcrumb-item a {
            color: #007bff;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            font-weight: 700;
            color: #343a40;
        }

        .card {
            border-radius: 12px;
        }

        .card-header {
            border-bottom: none;
        }

        .card-body {
            padding: 30px;
        }

        .card-footer {
            background-color: #f9f9f9;
            border-top: none;
        }

        .card img {
            border-radius: 8px;
            max-height: 180px;
            object-fit: cover;
        }

        .text-primary {
            color: #007bff !important;
        }

        /* Espaciado para las tarjetas adicionales */
        .card .me-3 img,
        .card .me-3 iframe {
            border-radius: 10px;
        }

        /* Sombreado suave para las tarjetas */
        .shadow-sm {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
        }

        /* Animación hover en las tarjetas */
        .card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease-in-out;
        }

        /* Espaciado entre las tarjetas adicionales */
        .card-body.row.g-4 .col-md-4,
        .card-body.row.g-4 .col-md-8 {
            padding: 15px;
        }

        /* Sección de contacto */
        .card-title.text-primary {
            font-weight: 600;
        }

        .fab {
            margin-right: 8px;
        }

        /* Ajuste de tamaño en dispositivos móviles */
        @media (max-width: 768px) {
            .card img {
                max-height: 150px;
            }

            .breadcrumb-item {
                font-size: 14px;
            }

            .card-body.row.g-4 .col-md-8 {
                padding-top: 20px;
            }
        }

        table {
            width: auto;

            border-collapse: collapse;
            /* Elimina el espacio entre bordes */
        }

        th,
        td {
            border: 1px solid black;
            /* Bordes de la tabla */
            padding: 8px;
            /* Espaciado dentro de las celdas */
            text-align: left;
            /* Alineación del texto */
        }

        th {
            background-color: #f2f2f2;
            /* Color de fondo para la cabecera */
        }
    </style>
@endsection

@section('header')
    <div class="pagetitle">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.template') }}">Home</a></li>
                <li class="breadcrumb-item">Comunidades</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $comunidad->nombre }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    <div class="container mt-4">
        <!-- Tarjeta principal de la comunidad -->
        <div class="card shadow-sm mb-5">
            <div class="card-header text-center bg-primary text-white">
                <h2 class="mb-0 display-4" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
                    <i class="fas fa-map-marked-alt me-2"></i>{{ $comunidad->nombre }}
                </h2>
            </div>

            <div class="card-body row g-4">
                <div class="col-md-4 text-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Laguna_Verde_en_Bolivia.jpg/800px-Laguna_Verde_en_Bolivia.jpg"
                        alt="{{ $comunidad->nombre }}" style="width: auto; height: 500px;" class="img-fluid rounded">
                </div>
                <div class="col-md-8">
                    <h5 class="card-title text-primary">Descripción</h5>
                    <p class="card-text">{{ $comunidad->descripcion }}</p>

                    <h5 class="card-title text-primary">Zona</h5>
                    <p class="card-text">{{ $comunidad->zona }}</p>
                </div>
            </div>
            <div class="card-footer text-muted text-center">
                Última actualización: {{ $comunidad->updated_at->format('d/m/Y H:i') }}
            </div>
        </div>

        <!-- Sección de tarjetas adicionales -->
        <div class="row mt-5">
            <!-- Ubicación -->
            <div class="col-md-12">
                <div class="card shadow-sm h-100 d-flex flex-row align-items-center">
                    <div class="me-3">
                        <div class="ratio ratio-1x1" style="width: 120px;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3797.1642616472336!2d-64.5127735!3d-17.8777712!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x93faade29daa2a65%3A0x15fca55c65665390!2sLaguna%20Verde%20Comarapa!5e0!3m2!1ses-419!2sbo!4v1728614277786!5m2!1ses-419!2sbo"
                                style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                    <div>
                        <h5 class="card-title text-primary">Ubicación <i class="fas fa-map-marker-alt"></i></h5>
                        <p class="card-text">¿COMO LLEGAR?</p>
                    </div>
                </div>
            </div>

            <!-- Alojamiento -->
            <div class="col-md-12 mt-3">
                <div class="card shadow-sm h-100 d-flex flex-row align-items-center">
                    <div class="me-3">
                        <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/17/49/dd/bc/img-20190422-172318-largejpg.jpg?w=700&h=-1&s=1"
                            alt="Restaurante" class="rounded" style="width: 120px;" alt="Alojamiento">
                    </div>
                    <div>
                        <h5 class="card-title text-primary">Alojamiento <i class="fas fa-bed"></i></h5>
                        <p class="card-text">El albergue ecoturístico "Laguna Verde" cuenta con cabañas rústicas diseñadas
                            para integrarse con el entorno natural. Cada cabaña tiene capacidad para alojar hasta 12
                            personas, ofreciendo un espacio acogedor y sencillo, ideal para quienes buscan una experiencia
                            de contacto directo con la naturaleza. Las habitaciones están equipadas con lo esencial para una
                            estancia cómoda, manteniendo un estilo simple y respetuoso con el ambiente.

                            Además del alojamiento en cabañas, el albergue ofrece áreas habilitadas para acampar,
                            permitiendo a los visitantes disfrutar de noches bajo las estrellas en medio de un paisaje
                            natural inigualable.</p>
                        <p><strong>Capacidad Máxima:</strong> 12 Personas</p>
                        <p><strong>Costo:</strong> 150 Bs Por Noche</p>
                    </div>
                </div>
            </div>
            <!--gastronimia -->
            <div class="col-md-12 mt-3">
                <div class="card shadow-sm h-100 d-flex flex-row align-items-center">
                    <div class="me-3">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQchDpwBuO7zn5RR8eSCu_tDP-027BPbOZ3KA&s"
                            alt="Restaurante" class="rounded" style="width: 120px;" alt="Alojamiento">
                    </div>
                    <div>
                        <h5 class="card-title text-primary">Gastronomia <i class="fas fa-bed"></i></h5>
                        <p class="card-text">Se basa en ingredientes frescos y locales, reflejando las tradiciones
                            culinarias de la región. Los platos suelen incluir pescados frescos de los ríos cercanos, carnes
                            locales y productos agrícolas como el plátano, yuca y maíz. Los guisos y asados son populares,
                            al igual que las preparaciones sencillas y nutritivas. Además, se ofrecen bebidas tradicionales
                            como la chicha, hechas de maíz o yuca, que complementan la experiencia gastronómica y conectan a
                            los visitantes con las costumbres ancestrales de la comunidad.
                        </p>
                        <table>
                            <tr>
                                <th>COMIDA</th>
                                <th>PRECIO(bs)</th>

                            </tr>
                            <tr>
                                <td>SUDAO DE PESCADO</td>
                                <td>25</td>

                            </tr>
                            <tr>
                                <td>SOPA TAPADA</td>
                                <td>12</td>
                            </tr>
                            <tr>
                                <td>MAJAO</td>
                                <td>30</td>

                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Transporte -->
            <div class="col-md-12 mt-3">
                <div class="card shadow-sm h-100 d-flex flex-row align-items-center">
                    <div class="me-3">
                        <img src="https://www.ticketsbolivia.com.bo/assets/images/bus-companies/78/capital.jpg"
                            class="rounded" style="width: 120px;" alt="Transporte">
                    </div>
                    <div>
                        <h5 class="card-title text-primary">Transporte <i class="fas fa-bus"></i></h5>
                        <p class="card-text"><strong>Tomar una flota interprovincial que preste servicio de viaje a Comarapa
                            </strong></p>
                        <p><strong>Precio por persona 50 bs </strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!--SECCION DE COMENTARIOS-->


     <!-- Sección de comentarios -->
     <!-- Sección de comentarios -->
     <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-primary">Comentarios</h3>
                <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#createCommentModal">
                    Añadir Comentario
                </button>
                
                <!-- Lista de Comentarios -->
                @if ($comentarios->isEmpty())
                    <p>No hay comentarios disponibles para esta comunidad.</p>
                @else
                    <ul class="list-group">
                        @foreach ($comentarios as $comentario)
                            <li class="list-group-item">
                                <strong>{{ $comentario->usuario->nombre }}
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $comentario->puntuacion ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </strong>
                                <p>{{ $comentario->descripcion }}</p>
                                
                                <small>Publicado el: {{ $comentario->created_at->format('d/m/Y H:i') }}</small>
                                
                                <!-- Mostrar imagen si existe -->
                                @if($comentario->imagenes->isNotEmpty())
                                    <div class="mt-3">
                                        @foreach ($comentario->imagenes as $imagen)
                                            <div class="position-relative d-inline-block">
                                                <!-- Imagen miniatura -->
                                                <img src="{{ asset('storage/' . $imagen->ruta) }}" alt="Imagen del comentario" class="img-thumbnail img-fluid" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('{{ asset('storage/' . $imagen->ruta) }}')">
                                
                                                <!-- X para eliminar -->
                                                 <!-- Ícono de eliminar imagen (X) -->
                                            <!-- X para eliminar -->
                                            <button  type="button" class="btn btn-danger btn-circle position-absolute top-0 end-0"
                                                    onclick="confirmDeleteImage('{{ $imagen->id }}')"
                                                    style="background-color: #A9A9A9; border: none; padding: 5px; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; z-index: 10;">&nbsp;
                                                 
                                                <i class="fas fa-times"></i>
                                            </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
    
                                <!-- Botones de editar y eliminar (solo si el usuario es el autor del comentario) -->
                                
                                    <button class="btn edit-btn btn-sm" data-bs-toggle="modal" data-bs-target="#editCommentModal"
                                        onclick="editComment('{{ $comentario->id }}', '{{ $comentario->descripcion }}', '{{ $comentario->puntuacion }}')">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="btn delete-btn btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCommentModal"
                                        onclick="deleteComment('{{ route('comentarios.destroy', $comentario->id) }}')">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                    <!-- Botón para abrir el modal -->
                                    <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#addImageModal" onclick="prepareAddImage('{{ $comentario->id }}')">
                                        <i class="fas fa-image"></i> Agregar Imagen
                                    </button>
                                
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
<!--estilos para los botones de eliminado y editar-->

<style>
    .edit-btn {
        background-color: #1877f2; /* Azul al estilo Facebook */
        color: #fff;
        border: none;
        border-radius: 20px; /* Bordes redondeados */
        padding: 5px 15px;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .edit-btn:hover {
        background-color: #145dbf; /* Azul más oscuro al hacer hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); /* Añadir una sombra */
    }

    .delete-btn {
        background-color: #ff5a5f; /* Rojo más sutil */
        color: #fff;
        border: none;
        border-radius: 20px; /* Bordes redondeados */
        padding: 5px 15px;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .delete-btn:hover {
        background-color: #e04848; /* Rojo más oscuro al hacer hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); /* Añadir una sombra */
    }

    .btn i {
        margin-right: 5px; /* Espacio entre el icono y el texto */
    }
</style>

            <!-- Modal para crear un nuevo comentario -->
            <div class="modal fade" id="createCommentModal" tabindex="-1" aria-labelledby="createCommentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCommentModalLabel">Añadir Comentario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('comentarios.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="comunidad_id" value="{{ $comunidad->id }}">
                                
                                <!-- Input oculto para la puntuación -->
                                <input type="hidden" name="puntuacion" id="puntuacionCreate" value="0">

                                <div class="mb-3">
                                    <label class="form-label">Puntuación</label>
                                    <div id="ratingStars" class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star" data-value="{{ $i }}"></i>
                                        @endfor
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="descripcionCreate" class="form-label">Descripción</label>
                                    <textarea name="descripcion" id="descripcionCreate" class="form-control" rows="3" required></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estilos para las estrellas -->
            <style>
                .rating {
                    display: flex;
                    gap: 5px;
                    cursor: pointer;
                }
                .rating .fa-star {
                    font-size: 2rem;
                    color: #ccc; /* Color gris para las estrellas no seleccionadas */
                    transition: color 0.2s;
                }
                .rating .fa-star.selected, .rating .fa-star.hovered {
                    color: #ffc107; /* Color dorado para las estrellas seleccionadas o al pasar el cursor */
                }
            </style>

            <!-- Estilos para las estrellas -->


            <!-- Modal para editar un comentario existente -->
            <div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCommentModalLabel">Editar Comentario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editCommentForm" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="comentario_id" id="comentarioIdEdit">

                                <div class="mb-3">
                                    <label for="descripcionEdit" class="form-label">Descripción</label>
                                    <textarea name="descripcion" id="descripcionEdit" class="form-control" rows="3" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="puntuacionEdit" class="form-label">Puntuación</label>
                                    <select name="puntuacion" id="puntuacionEdit" class="form-select" required>
                                        <option value="1">1 Estrella</option>
                                        <option value="2">2 Estrellas</option>
                                        <option value="3">3 Estrellas</option>
                                        <option value="4">4 Estrellas</option>
                                        <option value="5">5 Estrellas</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- Reutilizamos el CSS de las estrellas -->

            <!-- Modal para confirmar la eliminación de un comentario -->
            <div class="modal fade" id="deleteCommentModal" tabindex="-1" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteCommentModalLabel">Eliminar Comentario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro de que deseas eliminar este comentario?</p>
                            <form id="deleteCommentForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

                        <!-- Modal para agregar imagen -->
                        <div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addImageModalLabel">Agregar Imagen al Comentario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addImageForm" method="POST" enctype="multipart/form-data" action="{{ route('comentarios.imagenes.agregar') }}">
                                            @csrf
                                            <input type="hidden" name="comentario_id" id="comentarioIdInput">
                                            <div class="mb-3">
                                                <label for="imagenPreview" class="form-label">Imagen Seleccionada</label>
                                                <div id="previewContainer" class="text-center">
                                                    <img id="imagenPreview" src="#" alt="Previsualización de la imagen" style="display: none; max-width: 100%; height: auto;">
                                                </div>
                                                <input type="file" name="imagen" id="imagenInput" class="form-control mt-3" accept="image/*" required onchange="previewImage(event)">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Confirmar</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <!--modal para agrandar la imagen-->
                        <!-- Modal para mostrar la imagen en grande -->
                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel">Imagen del Comentario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img id="imagePreview" src="" alt="Imagen grande" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <!--modal para la eliminacion de la imagen-->
                        <!-- Modal de Confirmación para eliminar imagen -->
                        <div class="modal fade" id="deleteImageModal" tabindex="-1" aria-labelledby="deleteImageModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteImageModalLabel">Confirmar Eliminación de Imagen</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar esta imagen? Esta acción no se puede deshacer.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form id="deleteImageForm" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
            





        <!-- Sección de contacto -->
        <div class="container mt-5">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3 class="card-title text-primary">Contacto</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="https://wa.me/59176083442?text=¡Hola,%20necesito%20más%20información%20sobre%20el%20parque%amboró"" target="_blank">
                                <p><i class="fab fa-whatsapp"></i> +591 760-834-42</p>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="tel:+59176083442">
                                <p><i class="fas fa-phone"></i> +591 760-834-42</p>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="mailto:fernando201469@gmail.com">
                                <p><i class="fas fa-envelope"></i> fernando201469@gmail.com</p>
                            </a>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="https://www.google.com" target="_blank">
                            <p><i class="fas fa-link"></i> Visitar Google</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        

        <script>

            function editComment(comentarioId, descripcion, puntuacion) {
                document.getElementById('comentarioIdEdit').value = comentarioId;
                document.getElementById('descripcionEdit').value = descripcion;
                document.getElementById('puntuacionEdit').value = puntuacion;

                // Actualizar la acción del formulario para la edición
                document.getElementById('editCommentForm').action = "{{ route('admin.comentarios.update', ':id') }}".replace(':id', comentarioId);
            }

            function deleteComment(actionUrl) {
                // Actualizar la acción del formulario para la eliminación
                document.getElementById('deleteCommentForm').action = actionUrl;
            }

            document.addEventListener('DOMContentLoaded', function () {
                const stars = document.querySelectorAll('#ratingStars .fa-star');
                    let puntuacionInput = document.getElementById('puntuacionCreate');

                    stars.forEach(star => {
                        // Manejar el clic en una estrella para fijar la puntuación
                        star.addEventListener('click', () => {
                            const value = star.getAttribute('data-value');
                            puntuacionInput.value = value;

                            // Eliminar la clase 'selected' de todas las estrellas
                            stars.forEach(s => s.classList.remove('selected'));

                            // Añadir la clase 'selected' a las estrellas hasta la seleccionada
                            for (let i = 0; i < value; i++) {
                                stars[i].classList.add('selected');
                            }
                        });

                        // Añadir un efecto hover para mostrar el rango seleccionado
                        star.addEventListener('mouseover', () => {
                            // Eliminar la clase 'hovered' de todas las estrellas
                            stars.forEach(s => s.classList.remove('hovered'));

                            // Añadir la clase 'hovered' a todas las estrellas hasta la seleccionada
                            for (let i = 0; i < star.getAttribute('data-value'); i++) {
                                stars[i].classList.add('hovered');
                            }
                        });

                        // Eliminar el efecto hover cuando el ratón salga del área de las estrellas
                        star.addEventListener('mouseout', () => {
                            stars.forEach(s => s.classList.remove('hovered'));
                        });
                    });

                    // Limpiar las estrellas seleccionadas y el valor de la puntuación cuando se cierra el modal
                    const createCommentModal = document.getElementById('createCommentModal');
                    createCommentModal.addEventListener('hidden.bs.modal', () => {
                        stars.forEach(s => s.classList.remove('selected', 'hovered'));
                        puntuacionInput.value = 0;
                    });
                });
                                //para la imagen
                function previewImage(event) {
                    const file = event.target.files[0];
                    const preview = document.getElementById('imagenPreview');
                    
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        preview.src = '#';
                        preview.style.display = 'none';
                    }
                }

                function prepareAddImage(comentarioId) {
                    document.getElementById('comentarioIdInput').value = comentarioId;
                    console.log(`entre al prepareAddIMage ${comentarioId}`);
                    document.getElementById('imagenInput').value = null;
                    document.getElementById('imagenPreview').style.display = 'none';
                }
                // Función para mostrar la imagen en el modal mas grande
                function showImage(imageUrl) {
                    document.getElementById('imagePreview').src = imageUrl;
                }

                //eliminacion de la imagen

                function confirmDeleteImage(imagenId) {
                     // Genera la ruta usando el helper route() de Laravel
                    const form = document.getElementById('deleteImageForm');
                    const url = "{{ route('comentarios.imagenes.eliminar', ':imagenId') }}".replace(':imagenId', imagenId);
                    //console.log(url);
                    form.action = url;

                    // Muestra el modal de confirmación
                    const deleteImageModal = new bootstrap.Modal(document.getElementById('deleteImageModal'));
                    deleteImageModal.show();
                }

        </script>

    @endsection
