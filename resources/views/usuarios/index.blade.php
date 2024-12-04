@extends('layouts.admin_template')

@section('content')
    <div class="container">
        <h1>Lista de Usuarios Registrados con Rol "Usuario"</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Fecha de Registro</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Acciones</th> <!-- Nueva columna de acciones -->
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->nombre }}</td> <!-- Nombre del usuario -->
                        <td>{{ $usuario->correo }}</td> <!-- Email del usuario -->
                        <td>{{ $usuario->created_at }}</td> <!-- Fecha de creación -->
                        <td>
                            @foreach ($usuario->roles as $role)
                                <span class="badge bg-info">{{ $role->name }}</span>
                            @endforeach
                        </td> <!-- Roles del usuario -->
                        <td>
                            <!-- Botones de acciones -->
                            <a href="#" class="btn btn-info btn-sm" title="Ver Información" data-bs-toggle="modal"
                                data-bs-target="#userModal-{{ $usuario->id }}">
                                <i class="fas fa-eye"></i> Ver<!-- Icono para ver -->
                            </a>
                            <a href="" class="btn btn-warning btn-sm" title="Editar Usuario"data-bs-toggle="modal"
                                data-bs-target="#editUserModal-{{ $usuario->id }}">
                                <i class="fas fa-edit"></i> Editar<!-- Icono para editar -->
                            </a>
                            <!-- Modal para editar usuario -->
                            <div class="modal fade" id="editUserModal-{{ $usuario->id }}" tabindex="-1"
                                aria-labelledby="editUserModalLabel-{{ $usuario->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUserModalLabel-{{ $usuario->id }}">Editar
                                                Usuario</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('usuarios.admin.update', $usuario->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="row mb-3">
                                                    <label for="profileImage"
                                                        class="col-md-4 col-lg-3 col-form-label">Imagen de Perfil</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <img id="profileImagePreview"
                                                            src="{{ $usuario->profile_image
                                                                ? asset('storage/' . $usuario->profile_image)
                                                                : ($usuario->sexo == 'masculino'
                                                                    ? asset('/usuariotemplate/administracion/assets/img/default-masculino.jpg')
                                                                    : asset('/usuariotemplate/administracion/assets/img/default-femenino.jpg')) }}"
                                                            alt="Profile"class="img-thumbnail"
                                                            style="width: 100px; height: 100px;">
                                                        <div class="pt-2">
                                                            <input type="file" name="profile_image" id="profile_image"
                                                                style="display: none;" accept="image/*">
                                                            <a class="btn btn-primary btn-sm"
                                                                title="Subir nueva imagen de perfil" id="uploadBtn">
                                                                <i class="bi bi-upload"></i>
                                                            </a>
                                                            <a class="btn btn-danger btn-sm"
                                                                title="Eliminar mi imagen de perfil" id="deleteImageBtn">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nombre
                                                        Completo</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input type="text" name="fullName" class="form-control"
                                                            value="{{ $usuario->nombre }}" required>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="username"
                                                        class="col-md-4 col-lg-3 col-form-label">Usuario</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input type="text" name="username" class="form-control"
                                                            value="{{ $usuario->usuario }}" required>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="email" class="col-md-4 col-lg-3 col-form-label">Correo
                                                        Electrónico</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input type="email" name="email" class="form-control"
                                                            value="{{ $usuario->correo }}" required>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="ci"
                                                        class="col-md-4 col-lg-3 col-form-label">CI</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input type="text" name="ci" class="form-control"
                                                            value="{{ $usuario->ci }}" required>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="age"
                                                        class="col-md-4 col-lg-3 col-form-label">Edad</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input type="number" name="age" class="form-control"
                                                            value="{{ $usuario->edad }}" required>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="gender"
                                                        class="col-md-4 col-lg-3 col-form-label">Género</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <select name="gender" class="form-select" required>
                                                            <option value="masculino"
                                                                {{ $usuario->sexo == 'masculino' ? 'selected' : '' }}>
                                                                Masculino</option>
                                                            <option value="femenino"
                                                                {{ $usuario->sexo == 'femenino' ? 'selected' : '' }}>
                                                                Femenino</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="passport"
                                                        class="col-md-4 col-lg-3 col-form-label">Pasaporte</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input type="text" name="passport" class="form-control"
                                                            value="{{ $usuario->pasaporte }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="nationality"
                                                        class="col-md-4 col-lg-3 col-form-label">Nacionalidad</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input type="text" name="nationality" class="form-control"
                                                            value="{{ $usuario->nacionalidad }}">
                                                    </div>
                                                </div>
                                                <!--espacio para poner los roles y cambiarlos-->
                                                
                                                <div class="row mb-3">
                                                    <label for="role"
                                                        class="col-md-4 col-lg-3 col-form-label">Rol</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <select name="role" class="form-select" required>
                                                           @foreach ($roles as $rol)
                                                               <option value="{{$rol->id}}"
                                                                @if ($usuario->roles->first()->id==$rol->id)
                                                                    selected
                                                                @endif
                                                                >{{$rol->name}}</option>
                                                           @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mb-3">
                                                    <label for="nroCelular"
                                                        class="col-md-4 col-lg-3 col-form-label">Celular</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input type="text" name="nroCelular" class="form-control"
                                                            value="{{ $usuario->nroCelular }}">
                                                    </div>
                                                </div>
                                                <!--guardamos los cambios al editar-->
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Guardar
                                                        Cambios</button>
                                                </div>
                                            </form>


                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Botón para abrir el modal de confirmación de eliminación -->
                            <button type="button" class="btn btn-danger btn-sm" title="Eliminar Usuario"
                                data-bs-toggle="modal" data-bs-target="#deleteRoleModal-{{ $usuario->id }}">
                                <i class="fas fa-trash-alt"></i> Eliminar<!-- Icono para eliminar -->
                            </button>

                            <!-- Modal para confirmar la eliminación -->
                            <div class="modal fade" id="deleteRoleModal-{{ $usuario->id }}" tabindex="-1"
                                aria-labelledby="deleteRoleModalLabel-{{ $usuario->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteRoleModalLabel-{{ $usuario->id }}">
                                                Confirmar
                                                Eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Estás seguro de que deseas eliminar este usuario
                                            <strong>{{ $usuario->nombre }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td> <!-- Columna de acciones -->

                    </tr>

                    <!-- Modal para ver información del usuario -->
                    <div class="modal fade" id="userModal-{{ $usuario->id }}" tabindex="-1"
                        aria-labelledby="userModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userModalLabel">Detalles del Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                        <h5 class="card-title">Detalles del Perfil</h5>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Foto de Perfil</div>
                                            <div class="col-lg-9 col-md-8">
                                                <img id="profileImagePreview"
                                                    src="{{ $usuario->profile_image
                                                        ? asset('storage/' . $usuario->profile_image)
                                                        : ($usuario->sexo == 'masculino'
                                                            ? asset('/usuariotemplate/administracion/assets/img/default-masculino.jpg')
                                                            : asset('/usuariotemplate/administracion/assets/img/default-femenino.jpg')) }}"
                                                    alt="Profile"class="img-thumbnail"
                                                    style="width: 100px; height: 100px;">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Nombre Completo</div>
                                            <div class="col-lg-9 col-md-8">{{ $usuario->nombre }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Usuario</div>
                                            <div class="col-lg-9 col-md-8">{{ $usuario->usuario }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Correo</div>
                                            <div class="col-lg-9 col-md-8">{{ $usuario->correo }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">CI</div>
                                            <div class="col-lg-9 col-md-8">{{ $usuario->ci }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Edad</div>
                                            <div class="col-lg-9 col-md-8">{{ $usuario->edad }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Sexo</div>
                                            <div class="col-lg-9 col-md-8">{{ $usuario->sexo }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Pasaporte</div>
                                            <div class="col-lg-9 col-md-8">{{ $usuario->pasaporte }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Nacionalidad</div>
                                            <div class="col-lg-9 col-md-8">{{ $usuario->nacionalidad }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        {{ $usuarios->links('pagination::bootstrap-4') }}
    </div>
@endsection
