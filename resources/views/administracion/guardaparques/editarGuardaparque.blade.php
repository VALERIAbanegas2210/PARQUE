@extends('layouts.admin_template')

@section('content')
<!-- Edición de datos del guardaparque -->
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h2>Editar Guardaparque - {{ $guardaparque->nombre }}</h2>

    <!-- Formulario de Actualización -->
    <form id="updateForm" action="{{ route('admin.guardaparque.update', $guardaparque->id) }}" method="POST">
        @csrf
        @method('PATCH')
        
        <!-- Campos del formulario -->
        <!-- Nombre -->
        <div class="row mb-3">
            <label for="nombre" class="col-md-4 col-lg-3 col-form-label">Nombre</label>
            <div class="col-md-8 col-lg-9">
                <input type="text" name="nombre" class="form-control" value="{{ $guardaparque->nombre }}" placeholder="Escribe tu nombre">
            </div>
        </div>
        
        <!-- CI -->
        <div class="row mb-3">
            <label for="ci" class="col-md-4 col-lg-3 col-form-label">CI</label>
            <div class="col-md-8 col-lg-9">
                <input type="text" name="CI" class="form-control" value="{{ $guardaparque->CI }}" required placeholder="Escribe tu CI">
            </div>
        </div>
        
        <!-- Edad -->
        <div class="row mb-3">
            <label for="edad" class="col-md-4 col-lg-3 col-form-label">Edad</label>
            <div class="col-md-8 col-lg-9">
                <input type="number" name="edad" class="form-control" value="{{ $guardaparque->edad }}" required placeholder="Escribe tu edad">
            </div>
        </div>
        
        <!-- Correo -->
        <div class="row mb-3">
            <label for="correo" class="col-md-4 col-lg-3 col-form-label">Correo Electrónico</label>
            <div class="col-md-8 col-lg-9">
                <input type="email" name="correo" class="form-control" value="{{ $guardaparque->correo }}" required placeholder="Escribe tu correo">
            </div>
        </div>
        
        <!-- Sexo -->
        <div class="row mb-3">
            <label for="sexo" class="col-md-4 col-lg-3 col-form-label">Sexo</label>
            <div class="col-md-8 col-lg-9">
                <select name="sexo" class="form-select" required>
                    <option value="masculino" {{ $guardaparque->sexo == 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="femenino" {{ $guardaparque->sexo == 'femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
            </div>
        </div>

        <!-- Número de Celular -->
        <div class="row mb-3">
            <label for="nroCelular" class="col-md-4 col-lg-3 col-form-label">Número de Celular</label>
            <div class="col-md-8 col-lg-9">
                <input type="text" name="nroCelular" class="form-control" value="{{ $guardaparque->nroCelular }}" required placeholder="Escribe tu numero celular">
            </div>
        </div>
        
        <!-- Contraseña -->
        <div class="row mb-3">
            <label for="contraseña" class="col-md-4 col-lg-3 col-form-label">Contraseña</label>
            <div class="col-md-8 col-lg-9">
                <input type="password" name="contraseña" class="form-control" placeholder="Escribe una nueva contraseña">
            </div>
        </div>

        <div class="row mb-3">
            <label for="role"
                class="col-md-4 col-lg-3 col-form-label">Rol</label>
            <div class="col-md-8 col-lg-9">
                <select name="role" class="form-select" required>
                   @foreach ($roles as $rol)
                       <option value="{{$rol->id}}"
                        @if ($usuarioIdRolActual==$rol->id)
                            selected
                        @endif
                        >{{$rol->name}}</option>
                   @endforeach
                </select>
            </div>
        </div>
        <!-- Botón para abrir el modal de confirmación de actualización -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">Actualizar Datos Guardaparque</button>
    </form>

    <!-- Modal de Confirmación de Actualización -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Confirmar Actualización</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro que quieres actualizar los datos del guardaparque?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('updateForm').submit();">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de Eliminación -->
    <form id="deleteForm" action="{{ route('admin.guardaparque.delete', $guardaparque->id) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')

        <!-- Botón para abrir el modal de confirmación de eliminación -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Eliminar Guardaparque</button>
    </form>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro que quieres eliminar al guardaparque? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteForm').submit();">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</div>









<!--Para mostrar las comunidades-->

<!-- Lista de comunidades asignadas al guardaparque -->
<div class="container mt-4">
    <h3>Comunidades Asignadas</h3>
    <div class="list-group">
        @foreach($comunidadesAsignadas as $comunidadAsignada)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <span>Comunidad: {{ $comunidadAsignada->comunidad_nombre }}</span>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarComunidadAsignada({{ $comunidadAsignada->supervisa_id }}, '{{ $comunidadAsignada->comunidad_nombre }}')">Eliminar</button>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal de Confirmación de Eliminación de la comunidad asignada -->
<div class="modal fade" id="modalConfirmarEliminacionComunidad" tabindex="-1" aria-labelledby="modalConfirmarEliminacionComunidadLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmarEliminacionComunidadLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar la asignación de la comunidad <strong id="comunidadAEliminar"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="confirmarEliminacionComunidadAsignada()">Eliminar</button>
            </div>
        </div>
    </div>
</div>











<!--EN ESTE MODAL MUESTRA LOS INPUT NECESARIOS PARA AGREGAR UNA NUEVA COMUNIDAD CON SU HORARIO-->
<!---modal para mostrarr el modal de creacion de horario ->

<!--AQUI CREAREMOS EL BOTON Y EL MODAL PARA CREAR NUEVAS ASIGNACIONES CON SUS HORARIOS-->
<button type="button" class="btn btn-success mt-3" onclick="agregarAsignacion()">Asignar Nueva Comunidad</button>

<!-- Modal para Crear una Nueva Asignación -->
<div class="modal fade" id="modalCrearAsignacion" tabindex="-1" aria-labelledby="modalCrearAsignacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex flex-column align-items-center text-center">
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title mb-2" id="modalCrearAsignacionLabel">Asignar Nueva Comunidad</h5>
            </div>
            <div class="modal-body">
                <!-- Formulario para creación de asignación -->
                <form id="formCrearAsignacion" method="POST" action="{{ route('admin.guardaparque.supervisa.create') }}">
                    @csrf

                    <!-- Selección de Comunidad comunidades no disponibles aparecen inabilitadas -->
                    <div class="mb-3">
                        <label for="comunidad" class="form-label">Comunidad</label>
                        <select id="comunidad" name="comunidad_id" class="form-select" required>
                            <option value="" disabled selected>Seleccione una Comunidad</option>
                            @foreach($comunidades as $comunidad)
                                <option value="{{ $comunidad->id }}" {{ $comunidad->disponibilidad !== 'DISPONIBLE' ? 'disabled' : '' }}>
                                    {{ $comunidad->nombre }} - Zona: {{ $comunidad->zona }}
                                    @if($comunidad->disponibilidad !== 'DISPONIBLE') (Comunidad No Disponible) @endif
                                </option>
                            @endforeach
                        </select>
                    </div>



                    <!--le paso un input oculto para mandar el inde guardaparque,otra manera seria que en el store le mande el id por la url
                    -->
                    <input type="text" id="guarda_parque_id_69" name="guardaparque_id" class="form-control" value={{$guardaparque->id}} hidden>
                    <!-- Checkbox para seleccionar/deseleccionar todos los días -->
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="selectAllDays" onclick="toggleAllDays(this)">
                        <label class="form-check-label" for="selectAllDays">Seleccionar/Deseleccionar Todos los Días</label>
                    </div>


                     <!-- Campos para Hora General de Inicio y Fin -->
                     <div class="mb-3 row">
                        <div class="col">
                            <label for="generalHoraInicio" class="form-label">Hora de Inicio General</label>
                            <input type="time" id="generalHoraInicio" class="form-control">
                        </div>
                        <div class="col">
                            <label for="generalHoraFin" class="form-label">Hora de Fin General</label>
                            <input type="time" id="generalHoraFin" class="form-control">
                        </div>
                    </div>

                    <!-- Checkbox para aplicar la hora general a todos los días -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" id="applyGeneralHours" class="form-check-input">
                        <label for="applyGeneralHours" class="form-check-label">Aplicar Hora General a Todos los Días Seleccionados</label>
                    </div>





                    <!-- Selección de Día (Checkboxes) -->
                    <div class="mb-3">
                        <label class="form-label">Días de Trabajo</label>
                        <div class="form-check">
                            @foreach($dias as $dia)
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input day-checkbox" id="dia_{{ $dia->id }}" name="dias[]" value="{{ $dia->id }}" onclick="toggleDayHours(this)">
                                    <label class="form-check-label" for="dia_{{ $dia->id }}">{{ $dia->nombre }}</label>
                                    <div class="row mt-1">
                                        <div class="col-6">
                                            <input type="time" class="form-control hour-input" name="hora_inicio_{{ $dia->id }}" placeholder="Hora Inicio" required disabled>
                                        </div>
                                        <div class="col-6">
                                            <input type="time" class="form-control hour-input" name="hora_fin_{{ $dia->id }}" placeholder="Hora Fin" required disabled>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Botón para Guardar la Nueva Asignación -->
                    <button type="submit" class="btn btn-primary mt-3">Guardar Nueva Asignación</button>
                </form>
            </div>
        </div>
    </div>
</div>









<!-- Sección para editar horarios y comunidades asignadas
esto despliega todas las comunidades con sus horarios -->
<div class="container mt-4">
    <h3>Asignación de Comunidades y Horarios</h3>

    <!-- Lista de comunidades y horarios asignados actualmente 
    esto despliega todas las comunidades con sus horarios-->
    @foreach($lugaresHorariosAsignadosAGuardaparque as $asignacion)
        <div class="card mb-3">
            <div class="card-body">
                <h5>Comunidad: {{ $asignacion->comunidad_nombre }} (Zona: {{ $asignacion->zona }})</h5>
                
                <h6>Días y Horarios Asignados:</h6>
                <ul>
                    <li>Día: {{ $asignacion->dia_nombre }} - {{ $asignacion->hora_inicio }} a {{ $asignacion->hora_fin }}</li>
                </ul>
                
                <!-- Botones de acciones -->
                <button type="button" class="btn btn-warning btn-sm" onclick="editarAsignacion({{ $asignacion->horario_id }},'{{ $asignacion->comunidad_nombre }}','{{$asignacion->zona}}')">Editar</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarAsignacion({{ $asignacion->horario_id }}, '{{ $asignacion->dia_nombre }}')">Eliminar</button>
            </div>
        </div>
    @endforeach

    
    
</div>

<!-- Modal para Editar el horario
esto muestra esa ventana para editar -->
<!-- Modal para Editar el horario 
esto solo se muestra cuando se va editar el horario de la comunidad-->
<div class="modal fade" id="modalEditarAsignacion" tabindex="-1" aria-labelledby="modalEditarAsignacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--<div class="modal-header">
                <h5 class="modal-title" id="modalEditarAsignacionLabel">Editar Asignación de Horario</h5>
                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>-->
            <div class="modal-header d-flex flex-column align-items-center text-center">
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title mb-2" id="modalEditarAsignacionLabel">Editar Asignación de Horario</h5>
                <h5 id="model-texto-comunidad-zona9">Comunidad: Se la doi yo - Zona: se la doi yo</h5>
            </div>
            
            <div class="modal-body">
                <!-- Formulario de edición de asignación (enlace con Ajax) -->
                <form id="formEditarAsignacion" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Selección de Día -->
                    <!-- Mostrar el día sin el desplegable -->

                    <div class="mb-3">
                        <label for="dia" class="form-label">Día</label>
                        <input type="text" id="dia" name="dia_id" class="form-control" value="s" hidden readonly>
                        <input type="text" id="dia-nombre" name="dia_id-2" class="form-control" value="s" readonly>
                    </div>

                    <!-- Horarios -->
                    <!--<h6>Horarios de Trabajo</h6>-->
                    <div class="mb-3">
                        <label for="hora_inicio" class="form-label">Hora Inicio</label>
                        <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="hora_fin" class="form-label">Hora Fin</label>
                        <input type="time" id="hora_fin" name="hora_fin" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="modalConfirmarEliminacion" tabindex="-1" aria-labelledby="modalConfirmarEliminacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmarEliminacionLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar la asignación de horario del día <strong id="diaAEliminar"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="confirmarEliminacion()">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
    let horarioIdAEliminar;
    let horarioIdAEditar;
    //solo muestra un previo antes de eliminar
    function eliminarAsignacion(horarioId, diaNombre) {
        horarioIdAEliminar = horarioId;
        document.getElementById('diaAEliminar').textContent = diaNombre;
        const modal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminacion'));
        modal.show();
    }
    //aqui si se elimina
    function confirmarEliminacion() {
        fetch(`/admin/guardaparque/horario/delete/${horarioIdAEliminar}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload(); // Recargar la página para actualizar la lista
            } else {
                alert('Hubo un problema al eliminar la asignación.');
            }
        })
        .catch(error => console.error('Error:', error));
    }


    //solo es un modal,se dispara cuando clickeamos en editar
    //dado que tenemos el id del dia del backend,un truco pa sacar el nombre
    const diasMap = {
        1: 'Lunes',
        2: 'Martes',
        3: 'Miércoles',
        4: 'Jueves',
        5: 'Viernes',
        6: 'Sábado',
        7: 'Domingo'
    };
    function editarAsignacion(horarioId,nombreComunidad,nombreZona) {
        horarioIdAEditar = horarioId;
        console.log("entre", horarioIdAEditar);
        
        // Fetch para obtener los detalles del horario a editar
        fetch(`/admin/guardaparque/horario/get/${horarioIdAEditar}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                
                // Eliminar los segundos de hora_inicio y hora_fin
                const horaInicioParts = data.hora_inicio.split(':');
                const horaFinParts = data.hora_fin.split(':');
                
                // Concatenar solo los primeros dos componentes (hora y minuto)
                const horaInicioFormatted = `${horaInicioParts[0]}:${horaInicioParts[1]}`;
                const horaFinFormatted = `${horaFinParts[0]}:${horaFinParts[1]}`;
                //este es para mostrar el dia en formato literal
                document.getElementById('dia-nombre').value = diasMap[data.dia_id]||'undefined';
                //este es el que recibe el backend y lo utiliza por que es el id
                document.getElementById('dia').value = data.dia_id;
                document.getElementById('hora_inicio').value = horaInicioFormatted;
                document.getElementById('hora_fin').value = horaFinFormatted;
                
                //para modificar el texto del modal h5 para que aparesca la comunidad y zona seleccionada
                document.getElementById('model-texto-comunidad-zona9').innerText=`Comunidad: ${nombreComunidad}- Zona: ${nombreZona}`;

                //clave pa editar
                document.getElementById('formEditarAsignacion').action = `/admin/guardaparque/horario/update/${horarioIdAEditar}`;
                const modal = new bootstrap.Modal(document.getElementById('modalEditarAsignacion'));
                modal.show();
            })
            .catch(error => console.error('Error:', error));
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////
    //codiog para la logica de crear un nueva asignacion

    function agregarAsignacion() {
        // Restablecer los valores del formulario para una nueva asignación
        document.getElementById('formCrearAsignacion').reset();
        
        // Abrir el modal de creación
        const modal = new bootstrap.Modal(document.getElementById('modalCrearAsignacion'));
        modal.show();
    }

    // Función para habilitar/deshabilitar los inputs de hora según el día seleccionado
    function toggleDayHours(checkbox) {
        const horaInicioInput = document.querySelector(`[name="hora_inicio_${checkbox.value}"]`);
        const horaFinInput = document.querySelector(`[name="hora_fin_${checkbox.value}"]`);

        if (checkbox.checked) {
            // Si el día está seleccionado, habilitamos los inputs de hora
            horaInicioInput.disabled = false;
            horaFinInput.disabled = false;
        } else {
            // Si el día no está seleccionado, deshabilitamos los inputs de hora y los vaciamos
            horaInicioInput.disabled = true;
            horaFinInput.disabled = true;
            horaInicioInput.value = '';
            horaFinInput.value = '';
        }
    }

    // Función para seleccionar/deseleccionar todos los días
    function toggleAllDays(checkbox) {
        const dayCheckboxes = document.querySelectorAll('.day-checkbox');
        dayCheckboxes.forEach(dayCheckbox => {
            dayCheckbox.checked = checkbox.checked;
            toggleDayHours(dayCheckbox);
        });
    }

    // Aplicar Hora General a todos los días seleccionados
    document.getElementById('applyGeneralHours').addEventListener('change', function() {
        if (this.checked) {
            const generalHoraInicio = document.getElementById('generalHoraInicio').value;
            const generalHoraFin = document.getElementById('generalHoraFin').value;

            if (generalHoraInicio && generalHoraFin) {
                const dayCheckboxes = document.querySelectorAll('.day-checkbox');
                dayCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const horaInicioInput = document.querySelector(`[name="hora_inicio_${checkbox.value}"]`);
                        const horaFinInput = document.querySelector(`[name="hora_fin_${checkbox.value}"]`);
                        horaInicioInput.value = generalHoraInicio;
                        horaFinInput.value = generalHoraFin;
                    }
                });
            } else {
                alert('Por favor, ingrese ambas horas: Hora de Inicio y Hora de Fin.');
                this.checked = false; // desactivar si no están ambas horas completas
            }
        }
    });

    //logica para el eliminado de la comunidad asignada

    let supervisaIdAEliminar;
    let comunidadNombreAEliminar;

    function eliminarComunidadAsignada(supervisaId, comunidadNombre) {
        supervisaIdAEliminar = supervisaId;
        comunidadNombreAEliminar = comunidadNombre;
        document.getElementById('comunidadAEliminar').textContent = comunidadNombre;
        const modal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminacionComunidad'));
        modal.show();
    }

    function confirmarEliminacionComunidadAsignada() {
        fetch(`/admin/guardaparque/supervisa/delete/${supervisaIdAEliminar}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload(); // Recargar la página para actualizar la lista
            } else {
                alert('Hubo un problema al eliminar la asignación.');
            }
        })
        .catch(error => console.error('Error:', error));
    }



</script>
@endsection