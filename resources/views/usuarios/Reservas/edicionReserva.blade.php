
@extends('layouts.template')

@section('header2')
    <title>Formulario-Reserva</title>
@endsection

@section('header')
    <div class="pagetitle">
        <h1>Formulario de Edición de Reserva</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.template') }}">Home</a></li>
                <li class="breadcrumb-item">Usuario</li>
                <li class="breadcrumb-item active">Editar Formulario</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    @if(session('success') && session('source') === 'edicionFormulario')
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
        }, 2000); // Cambiar a la duración real de la carga, si aplica
    </script>
    @endif
    @if(session('error')  && session('source') === 'edicionFormulario')
    <script>
        
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
        }, 2000); // Cambiar a la duración real de la carga, si aplica
    
    </script>
    @endif

    <div class="container mt-5">
        <div class="form-slide">
            <form id="formulario-reserva" class="p-4 bg-white shadow rounded" action="{{ route('usuario.update.formulario', ['idReserva' => $formulario->reserva->id, 'idForm' => $formulario->id]) }}" method="POST">
                 @csrf
                @method('PUT')
                <h5>Editar Formulario de Reserva</h5>
                <div class="container mt-4">
                    <div class="row g-3">
                        <!-- Tipo de Entrada -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Tipo de Entrada</span></label>
                                <select class="form-select tipo_entrada" name="tipo_entrada" required>
                                    <option value="" disabled selected>Seleccione el tipo de entrada</option>
                                    @foreach($tipoEntradas as $tipoEntrada)
                                        <option value="{{ $tipoEntrada->id }}" data-precio="{{ $tipoEntrada->precio }}" {{ $formulario->tipo_entrada_id == $tipoEntrada->id ? 'selected' : '' }}>{{ $tipoEntrada->nombre }} - {{ $tipoEntrada->precio }} Bs</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Departamento -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Departamento</span></label>
                                <select class="form-select" id="departamento" name="departamento">
                                    <option value="" disabled selected>Seleccione un departamento</option>
                                    @foreach($departamentos as $departamento)
                                        <option value="{{ $departamento->id }}" data-nombre="{{ $departamento->nombre }}" {{ $formulario->departamento_id == $departamento->id ? 'selected' : '' }}>{{ $departamento->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Comunidad -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Comunidad</span></label>
                                <select class="form-select comunidad" name="comunidad" required>
                                    <option value="" disabled selected>Seleccione una comunidad</option>
                                    @foreach($comunidades as $comunidad)
                                        <option value="{{ $comunidad->id }}" data-nombre="{{ $comunidad->nombre }}" {{ $comunidad->disponibilidad !== 'DISPONIBLE' ? 'disabled' : '' }}
                                            {{ $formulario->comunidad_id == $comunidad->id ? 'selected' : '' }}>
                                            {{ $comunidad->nombre }} - Zona: {{ $comunidad->zona }}
                                            @if($comunidad->disponibilidad !== 'DISPONIBLE') (Comunidad No Disponible) @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Ruta Turística -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Ruta Turística</span></label>
                                <select class="form-select" name="ruta_turistica">
                                    <option value="" disabled selected>Seleccione una ruta</option>
                                    <!-- Opciones serán cargadas por AJAX según la comunidad seleccionada -->
                                </select>
                            </div>
                        </div>

                        <!-- Nombre -->
                        <div class="col-md-6" id="nombre-container">
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Nombre</span></label>
                                <input type="text" class="form-control" name="nombre" placeholder="Escriba su Nombre" value="{{ $formulario->nombre }}" required>
                                <div class="invalid-feedback">
                                    Campo Rellenado incorrectamente
                                  </div>
                                <div class="valid-feedback">
                                  ¡Nombre rellenado correctamente!
                                </div>
                            </div>
                        </div>

                        <!-- Cédula de Identidad (CI) -->
                        <div class="col-md-6" id="ci-container" style="display: {{ $formulario->ci ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Cédula de Identidad (CI)</span></label>
                                <input type="number" class="form-control" name="ci" placeholder="Escriba su CI" value="{{ $formulario->ci }}">
                                <div class="invalid-feedback">
                                    Campo Rellenado incorrectamente
                                  </div>
                                <div class="valid-feedback">
                                    CI rellenado correctamente
                                </div>
                            </div>
                        </div>

                        <!-- Edad -->
                        <div class="col-md-6" id="edad-container">
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Edad</span></label>
                                <input type="number" class="form-control" name="edad" placeholder="Digite su edad" value="{{ $formulario->edad }}" required>
                                <div id="invalidEdad" class="invalid-feedback">
                                    edad incorrecta,debe ser mayor que 0 y menor o igual a 100
                                  </div>
                                <div class="valid-feedback">
                                  ¡edad correcta!
                                </div>
                            </div>
                        </div>

                        <!-- Fecha de Reserva -->
                        <div class="col-md-6" id="fecha-reserva-container">
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Fecha de Reserva</span></label>
                                <input type="date" class="form-control" name="fecha_reserva" value={{$formulario->fechaReserva}} required>
                            </div>
                        </div>

                        <!-- Tiempo de Estadia -->
                      
                         <!-- Tiempo de Estadía -->
                         <div class="col-md-6 tiempoEstadia-container" id="tiempoEstadia-container" >
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Tiempo de Estadia(dias)</span></label>
                                <select class="form-select custom-select-scroll" name="tiempoEstadia" required>
                                    <option value="" disabled selected>Seleccione un tiempo de estadia</option>
                                    <!-- Opciones serán generadas dinámicamente -->
                                </select>
                            </div>
                        </div>

                        <!--nacionalidad-->
                        <div class="col-md-6 nacionalidad-container" id="nacionalidad-container" style="display: {{ $formulario->nacionalidad ? 'block' : 'none' }};" >
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Nacionalidad</span></label>
                                <select class="form-select custom-select-scroll" id="nacionalidad" name="nacionalidad" required>
                                    <option value="" disabled selected>Seleccione su nacionalidad</option>
                                    <!-- Las opciones serán cargadas dinámicamente -->
                                </select>
                            </div>
                        </div>

                        <!--para la entrada--->

                        
                        


                        <!-- Pasaporte (solo para extranjeros) -->
                        <div class="col-md-6" id="pasaporte-container" style="display: {{ $formulario->pasaporte ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Pasaporte</span></label>
                                <input type="text" class="form-control" name="pasaporte" placeholder="Escriba su pasaporte" value="{{ $formulario->pasaporte }}">
                                <div class="invalid-feedback">
                                    Campo Rellenado incorrectamente
                                  </div>
                                <div class="valid-feedback">
                                    ¡Pasaporte rellenado correctamente!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Botones de acción -->
                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver Atrás</a>
                    <button type="button" class="btn btn-primary" id="boton-actualizar">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

     <!-- Modal de Confirmación de actualizacion-->
     <div class="modal fade" id="modalConfirmacion" tabindex="-1" role="dialog" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmacionLabel">Confirmar Actualización</h5>
                    <button type="button" class="btn-close"
                    data-bs-dismiss="modal" aria-label="Close"></button>
                    
                    
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas actualizar este formulario? No habrá reversión de cambios.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmar-actualizacion">Sí, Actualizar</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        
        .is-invalid ~ .invalid-feedback {
            display: block; /* Mostrar solo si es inválido */
        }
        .is-valid ~ .valid-feedback {
            display: block; /* Mostrar solo si es válido */
        }
        /* Específico para selects dentro de un contenedor con clase 'form-group' */
    </style>

    <script>
        
        document.addEventListener('DOMContentLoaded', function () {
            // Al cargar la página, verificar si hay una comunidad seleccionada y cargar rutas
            const comunidadSelect = document.querySelector('.form-select.comunidad');
            if (comunidadSelect && comunidadSelect.value) {
                cargarRutasPorComunidad(comunidadSelect.value);
            }
            
            const nacionalidadSelect = document.querySelector('[name="nacionalidad"]');
                const tiempoEstadiaSelect=document.querySelector('[name="tiempoEstadia"]');
                const formSlide=document.querySelector('.form-slide');
                const botonActualizar = document.getElementById('boton-actualizar');
                const nacionalidadBD=@json($formulario->nacionalidad);
                const tiempoEstadiaSeleccionado=@json($formulario->tiempoEstadia);

                console.log(formSlide);
                //const nacionlidadSelect=formSlide.querySelector('[name="nacionalidad"]');
                

            //console.log(tiempoEstadiaSelect);
            //con esto cargo a los select de dias y nacionalidad
            populateNacionalidades(nacionalidadSelect,nacionalidadBD); // Llenar nacionalidades
            cargarTiempoEstadia(tiempoEstadiaSelect);
            tiempoEstadiaSelect.value=tiempoEstadiaSeleccionado;
            //con esto le asigno los eventos de validacion al formulario
            assignValidationsToForm(formSlide);

            //para agregar los eventos al formulario

          

        });
    
        document.addEventListener('change', function(event) {
            if (event.target.classList.contains('tipo_entrada')) {
                const tipoEntrada = event.target.value;
                let tipoEntradaNombre = null;
    
                switch (tipoEntrada) {
                    case "1":
                        tipoEntradaNombre = "Estudiante";
                        break;
                    case "2":
                        tipoEntradaNombre = "Extranjero";
                        break;
                    case "3":
                        tipoEntradaNombre = "Nacional";
                        break;
                    case "4":
                        tipoEntradaNombre = "Extranjero-Menor";
                        break;
                    default:
                        break;
                }
    
                const form = event.target.closest('.form-slide');
                form.querySelector('#ci-container').style.display = (tipoEntradaNombre == "Nacional" || tipoEntradaNombre == "Estudiante") ? 'block' : 'none';
                form.querySelector('#pasaporte-container').style.display = (tipoEntradaNombre == "Extranjero" || tipoEntradaNombre == "Extranjero-Menor") ? 'block' : 'none';
                form.querySelector('#nombre-container').style.display = (tipoEntradaNombre != null) ? 'block' : 'none';
                form.querySelector('#edad-container').style.display = (tipoEntradaNombre != null) ? 'block' : 'none';
                form.querySelector('#tiempoEstadia-container').style.display = (tipoEntradaNombre != null) ? 'block' : 'none';
                form.querySelector('#nacionalidad-container').style.display = (tipoEntradaNombre == "Extranjero" || tipoEntradaNombre == "Extranjero-Menor") ? 'block' : 'none';
    
                const departamento = form.querySelector('#departamento');
                if (tipoEntradaNombre == "Extranjero" || tipoEntradaNombre == 'Extranjero-Menor') {
                    departamento.value = '';
                    departamento.disabled = true;
                } else {
                    departamento.disabled = false;
                }
            }
        });
    
        document.addEventListener('change', function(event) {
            if (event.target.classList.contains('comunidad')) {
                const comunidadId = event.target.value;
                cargarRutasPorComunidad(comunidadId);
            }

        });
    
        function cargarRutasPorComunidad(comunidadId) {
            const form = document.querySelector('.form-slide');
            const rutaSelect = form.querySelector('select[name="ruta_turistica"]');
            rutaSelect.innerHTML = '<option value="">Seleccione una ruta</option>';
    
            if (comunidadId) {
                // Reemplazar el marcador de posición :id con el valor real del comunidadId seleccionado
                const mostrarRutasDeComunidadesUrl = "{{ route('route.mostrarRutasDeComunidades', ':id') }}";
                const url = mostrarRutasDeComunidadesUrl.replace(':id', comunidadId);
    
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(ruta => {
                            const option = document.createElement('option');
                            option.value = ruta.id;
                            option.textContent = ruta.nombre;
                            option.setAttribute('data-nombre', ruta.nombre);
                            // Si la ruta no está disponible, la deshabilita y añade un texto indicativo
                            if (ruta.disponibilidad !== 'DISPONIBLE') {
                                        option.disabled = true;
                                        option.textContent += ' (No Disponible)';
                                    }

                            rutaSelect.appendChild(option);
                        });
    
                        // Seleccionar la ruta previamente seleccionada (si corresponde)
                        const rutaIdActual = "{{ $formulario->ruta_turistica_id ?? '' }}";
                        if (rutaIdActual) {
                            rutaSelect.value = rutaIdActual;
                        }
                    })
                    .catch(() => {
                        alert('Error al obtener las rutas turísticas.');
                    });
            }
        }
        //logica para que dispare la actualizacion del modal
        document.getElementById('boton-actualizar').addEventListener('click', function () {
            // Mostrar el modal de confirmación
            var modalConfirmacion = new bootstrap.Modal(document.getElementById('modalConfirmacion'));
            modalConfirmacion.show();
        });

        document.getElementById('confirmar-actualizacion').addEventListener('click', function () {
            // Enviar el formulario una vez que se confirme la actualización
            document.getElementById('formulario-reserva').submit();
        });


        const countries = [
            // América Latina
            "Argentina",
            "Bolivia",
            "Brasil",
            "Chile",
            "Colombia",
            "Costa Rica",
            "Cuba",
            "Ecuador",
            "El Salvador",
            "Guatemala",
            "Honduras",
            "México",
            "Nicaragua",
            "Panamá",
            "Paraguay",
            "Perú",
            "República Dominicana",
            "Uruguay",
            "Venezuela",
            "Estados Unidos"
        /* // Europa
            "España",
            "Francia",
            "Italia",
            "Reino Unido",
            "Alemania",

            // Asia
            "Japón",
            "China",
            "India",
            "Corea del Sur",

            // África
            "Sudáfrica",
            "Egipto",

            // Oceanía
            "Australia",
            "Nueva Zelanda",

            // América del Norte
            "Estados Unidos",
            "Canadá"*/
        ];

    
    // Función para cargar países en un selector
      // Función para cargar países en un selector
      function populateNacionalidades(selectElement,nacionalidadBD) {
            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country;
                option.textContent = country;
                selectElement.appendChild(option);
            });
            if(selectElement.value!==""){
                selectElement.value = nacionalidadBD;
            }
            
        }

    const diasEstadias=[1,2,3,4,5,6,7,8,9,10];
     function cargarTiempoEstadia(selectElement){
        diasEstadias.forEach(numeroDia=>{
            const option = document.createElement('option');
            option.value = numeroDia;
            option.textContent = numeroDia;
            selectElement.appendChild(option);
        });
     }

     //metodo para asiganar las validaciones a la edad,nombre,pasaporte,fecha_de reserva,ci
     function assignValidationsToForm(formSlide) {
        formSlide.addEventListener('input', function (event) {
            const input = event.target;

            // Validación de la edad  
            const tipoEntradaSelect = formSlide.querySelector('[name="tipo_entrada"]');
            console.log(`tipoDeENtradaSelect ${tipoEntradaSelect.value}`)
            const edadLimite=tipoEntradaSelect.value==="1"||tipoEntradaSelect.value==="4"?18:100;

        
            if (input.name === 'edad') {
                const value = parseInt(input.value, 10);
                if (value > 0 && value <= edadLimite) {
                    const divTextoEdadInvalida=document.getElementById('invalidEdad');
                    divTextoEdadInvalida.textContent=`¡La edad Debe ser mayor a 0 y menor o igual a ${edadLimite}`
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
            }

            // Validación del nombre (solo letras y espacios)
            if (input.name === 'nombre') {
                const regex = /^[a-zA-Z\s]+$/;
                if (regex.test(input.value.trim()) && input.value.trim().length > 0) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
            }

            // Validación del pasaporte (letras y números permitidos)
            if (input.name === 'pasaporte') {
                const regex = /^[a-zA-Z0-9]+$/;
                if (regex.test(input.value.trim())) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
            }

            // Validación de la fecha de reserva (>= fecha actual)
            if (input.name === 'fecha_reserva') {
                const now = new Date();
                const offset = now.getTimezoneOffset(); // Desfase en minutos con respecto a UTC
                now.setMinutes(now.getMinutes() - offset); // Ajustar al desfase local

                const today = now.toISOString().split('T')[0];

                console.log(`Hoy ajustado: ${today}`);
                
                const selectedDate = input.value;
                console.log(`fecha entrante: ${selectedDate}`)
                if (selectedDate >= today) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
            }

            //validacion para el ci
            if (input.name === 'ci' || input.name === 'ci_estudiante' ) {
                const regex = /^[0-9]+$/;
                if (regex.test(input.value.trim())) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
            }

            if(input.name==='unidad_educativa'){
                const regex = /^[a-zA-Z\s]+$/;
                if (regex.test(input.value.trim()) && input.value.trim().length > 0) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
            }

        });
    }

    </script>

@endsection

