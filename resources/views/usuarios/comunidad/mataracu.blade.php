@extends('layouts.template')

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
                    <img src="https://i.ytimg.com/vi/b9b2j79RwSo/maxresdefault.jpg" alt="{{ $comunidad->nombre }}"
                        class="img-fluid rounded"style="width: auto; height: 500px;">
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
                                src="https://www.google.com/maps/embed?pb=!1m13!1m8!1m3!1d7608.13175306273!2d-63.870158!3d-17.55205!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTfCsDMzJzA3LjQiUyA2M8KwNTInMDMuMyJX!5e0!3m2!1ses-419!2sbo!4v1728603474584!5m2!1ses-419!2sbo"
                                style="border:0;" allowfullscreen="" loading="lazy" loading="lazy"></iframe>
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
                        <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/01/9c/39/d1/casitas-habitacion-doble.jpg?w=700&h=-1&s=1"
                            alt="Restaurante" class="rounded" style="width: 120px;" alt="Alojamiento">
                    </div>
                    <div>
                        <h5 class="card-title text-primary">Alojamiento <i class="fas fa-bed"></i></h5>
                        <p class="card-text">Las cabañas son de construcción rústica pero cómoda, elaboradas
                            con materiales naturales de la zona, lo que las hace sostenibles
                            y respetuosas con el medio ambiente. Los visitantes pueden disfrutar
                            de diversas actividades como caminatas por la selva, observación de aves,
                            paseos por ríos y cascadas, y participar en actividades culturales con los
                            habitantes locales, como aprender sobre las plantas medicinales y la artesanía
                            tradicional. </p>
                        <p><strong>Capacidad Máxima:</strong> 10 Personas</p>
                        <p><strong>Costo:</strong> 200 Bs Por Noche</p>
                    </div>
                </div>
            </div>

            <!-- Transporte -->
            <div class="col-md-12 mt-3">
                <div class="card shadow-sm h-100 d-flex flex-row align-items-center">
                    <div class="me-3">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRflXK-x2xg6g4sYzaQQ6fjaEpbqikLng2JBH5DFWdf286KNPjLMSG3ELyWhUlKcJ2tRY&usqp=CAU"
                            class="rounded" style="width: 120px;" alt="Transporte">
                    </div>
                    <div>
                        <h5 class="card-title text-primary">Transporte <i class="fas fa-bus"></i></h5>
                        <p class="card-text">
                        <table>
                            <tr>
                                <th>LINEA</th>
                                <th>DESCRIPCION</th>
                                <th>PRECIO</th>

                            </tr>
                            <tr>
                                <td>TRUFI</td>
                                <td>VEHICULO DE PRESTACION DE SERVICIOS</td>
                                <td>50 BS/PERSONA </td>
                            </tr>
                            <tr>
                                <td>VEHICULO 4X4</td>
                                <td> VEHICULO QUE INGRESARA HACIA DENTRO DE LA COMUNIDAD</td>
                                <td> 400 BS/PERSONA</td>
                            </tr>

                        </table>
                        </p>
                    </div>
                </div>
            </div>
        </div>


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
                                                @if (Auth::id() == $comentario->usuario_id)
                                                    <button  type="button" class="btn btn-danger btn-circle position-absolute top-0 end-0"
                                                            onclick="confirmDeleteImage('{{ $imagen->id }}')"
                                                            style="background-color: #A9A9A9; border: none; padding: 5px; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; z-index: 10;">&nbsp;
                                                        
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
    
                                <!-- Botones de editar y eliminar (solo si el usuario es el autor del comentario) -->
                                @if (Auth::id() == $comentario->usuario_id)
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
                                @endif
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
                document.getElementById('editCommentForm').action = "{{ route('comentarios.update', ':id') }}".replace(':id', comentarioId);
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

                //TODO IMAGEN
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
