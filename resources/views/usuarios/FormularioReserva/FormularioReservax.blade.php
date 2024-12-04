@extends('layouts.template')

@section('header2')
    <title>Formulario-Reserva</title>
    
@endsection

@section('header')
    <div class="pagetitle">
        <h1>Formularios de Reservas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts.template') }}">Home</a></li>
                <li class="breadcrumb-item">Usuario</li>
                <li class="breadcrumb-item active">Formularios</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <style>
        .form-container {
            display: flex;
            width: 100%;
            
            position: relative;
        }
        .form-slide {
            flex: 0 0 100%;
            transition: transform 0.8s ease-in-out;
        }
        .indicators {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        .indicator {
            width: 10px;
            height: 10px;
            margin: 5px;
            border-radius: 50%;
            background-color: #ccc;
            cursor: pointer;
        }
        .indicator.active {
            background-color: #007bff;
        }
    </style>

    <!-- Modal for initial reservation count selection -->
    <div class="modal fade" id="initialModal" tabindex="-1" aria-labelledby="initialModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="initialModalLabel">Seleccione el número de Reservas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="reservationCount">Número de reservas: </label>
                    <input type="number" id="reservationCount" class="form-control" min="1" value="1">
                </div>
                <!--boton para generar los formularios--->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="startReservations" data-bs-dismiss="modal">Generar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-outline-success" id="addForm">Agregar Reservas</button>
            <button class="btn btn-outline-danger" id="removeForm">Eliminar Reserva</button>
        </div>

        <div class="form-container" id="formContainer">
            <!-- Reservation forms will be injected here -->
        </div>

        <div class="indicators" id="indicatorsContainer"></div>
        </br>
        </br>
        <div class="d-flex justify-content-between mt-3">
            <button class="btn btn-secondary" id="prevBtn">Anterior</button>
            <button class="btn btn-info" id="viewSummaryBtn" type="button">Ver Resumen</button>
            <button class="btn btn-primary" id="nextBtn">Siguiente</button>
        </div>
    </div>

    <!-- Template for reservation form -->
    <template id="reservationFormTemplate">
        <div class="form-slide">
            <form class="p-4 bg-white shadow rounded">
                <h5>Reservation Form</h5>
                <div class="container mt-4">
                    <div class="row g-3">
                        <!-- Tipo de Entrada -->
                                            <!-- Tipo de Entrada -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><span class="fw-bold">Tipo de Entrada</span></label>
                            <select class="form-select tipo_entrada" name="tipo_entrada" required>
                                <option value="">Seleccione el tipo de entrada</option>
                                @foreach($tipoEntradas as $tipoEntrada)
                                    <option value="{{ $tipoEntrada->id }}" data-precio="{{ $tipoEntrada->precio }}">{{ $tipoEntrada->nombre }} - {{$tipoEntrada->precio }} Bs</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Departamento -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><span class="fw-bold">Departamento</span></label>
                            <select class="form-select" id="departamento" name="departamento">
                                <option value="">Seleccione un departamento</option>
                                @foreach($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}" data-nombre="{{ $departamento->nombre }}" >{{ $departamento->nombre }}</option>
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
                                    <option value="{{ $comunidad->id }}" data-nombre="{{ $comunidad->nombre }}" {{ $comunidad->disponibilidad !== 'DISPONIBLE' ? 'disabled' : '' }}>
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
                                <option value="">Seleccione una ruta</option>
                                <!-- Opciones serán cargadas por AJAX según la comunidad seleccionada -->
                            </select>
                        </div>
                    </div>


                      <!-- Fecha de Reserva -->
                    <div class="col-md-6" id="fecha-reserva-container" style="display:none">
                        <div class="form-group">
                            <label class="form-label"><span class="fw-bold">Fecha de Reserva</span></label>
                            <input type="date" class="form-control" name="fecha_reserva" required>
                        </div>
                     </div>
                                      <!-- Nombre (solo cuando corresponda) -->
                        <div class="col-md-6" id="nombre-container" style="display: none;">
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Nombre</span></label>
                                <input type="text" class="form-control" name="nombre" placeholder="Escriba su Nombre" required>
                                <!---para mostrar por si infrinje las reglas-->
                                <div class="invalid-feedback">
                                    Campo Rellenado incorrectamente
                                </div>
                                <div class="valid-feedback">
                                     ¡Nombre rellenado correctamente!
                                </div>
                            </div>
                        </div>

                        <!-- Cédula de Identidad (CI) -->
                        <div class="col-md-6" id="ci-container" style="display: none;">
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Cédula de Identidad (CI)</span></label>
                                <input type="number" class="form-control" name="ci" placeholder="Escriba su CI" required>
                                <div class="invalid-feedback">
                                    Campo Rellenado incorrectamente
                                  </div>
                                <div class="valid-feedback">
                                    CI rellenado correctamente
                                </div>
                            </div>
                        </div>

                        <!-- Edad -->
                        <div class="col-md-6" id="edad-container" style="display: none;">
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Edad</span></label>
                                <input type="number" class="form-control" name="edad" placeholder="digite su edad" required>
                                <div id="invalidEdad" class="invalid-feedback">
                                    edad incorrecta,debe ser mayor que 0 y menor o igual a 100
                                  </div>
                                <div class="valid-feedback">
                                  ¡edad correcta!
                                </div>
                            </div>
                        </div>

                           <!-- Tiempo de Estadía -->
                            <div class="col-md-6 tiempoEstadia-container" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label"><span class="fw-bold">Tiempo de Estadia(dias)</span></label>
                                    <select class="form-select custom-select-scroll" name="tiempoEstadia" required>
                                        <option value="" disabled selected>Seleccione un tiempo de estadia</option>
                                        <!-- Opciones serán generadas dinámicamente -->
                                    </select>
                                </div>
                            </div>
                            <!--nacionalidad-->
                            <div class="col-md-6 nacionalidad-container" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label"><span class="fw-bold">Nacionalidad</span></label>
                                    <select class="form-select custom-select-scroll" id="nacionalidad" name="nacionalidad" required>
                                        <option value="" disabled selected>Seleccione su nacionalidad</option>
                                        <!-- Las opciones serán cargadas dinámicamente -->
                                    </select>
                                </div>
                            </div>
                        <!-- Pasaporte (solo para extranjeros) -->
                        <div class="col-md-6" id="pasaporte-container" style="display: none;">
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Pasaporte</span></label>
                                <input type="text" class="form-control" name="pasaporte" placeholder="Escriba su pasaporte" required>
                            </div>
                            <div class="invalid-feedback">
                                Campo Rellenado incorrectamente
                              </div>
                            <div class="valid-feedback">
                                ¡Pasaporte rellenado correctamente!
                            </div>
                        </div>
                
                        <!-- Datos de Estudiantes -->
                        <div class="col-md-6" id="estudiante-container" style="display: none;">
                            <!--<div class="form-group">
                                <label class="form-label"><span class="fw-bold">Rude o Identificación Universitaria</span></label>
                                <input type="text" class="form-control" name="rude" required placeholder="Escriba su identificación">
                            </div>-->
                            <div class="form-group">
                                <label class="form-label"><span class="fw-bold">Cédula de Identidad (CI)</span></label>
                                <input type="number" class="form-control" name="ci_estudiante" placeholder="Escriba su CI" required>
                                <div class="invalid-feedback">
                                    Campo Rellenado incorrectamente
                                  </div>
                                <div class="valid-feedback">
                                    CI rellenado correctamente
                                </div>
                            </div>


                            <div class="form-group mt-2">
                                <label class="form-label"><span class="fw-bold">Institución Educativa</span></label>
                                <input type="text" class="form-control" name="unidad_educativa" placeholder="Escriba su Universidad o Colegio" required>
                            </div>
                        </div>
                    </div>
                </div>
                                        
            </form>
        </div>
    </template>
<!--    <div class="d-flex justify-content-start mt-5">

        <button class="btn btn-info" id="viewSummaryBtn" type="button">Ver Resumen</button>
    </div>-->
    
    <style>
        .indicator {
            width: 10px;
            height: 10px;
            margin: 5px;
            border-radius: 50%;
            background-color: #ccc;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .indicator.active {
            background-color: #007bff; /* Azul activo para indicar el formulario actual */
        }

        .is-invalid ~ .invalid-feedback {
            display: block; /* Mostrar solo si es inválido */
        }
        .is-valid ~ .valid-feedback {
            display: block; /* Mostrar solo si es válido */
        }
        /* Específico para selects dentro de un contenedor con clase 'form-group' */

    </style>
    <!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>-->
    <script>
      let currentFormIndex = 0;
        const formContainer = document.getElementById('formContainer');
        const indicatorsContainer = document.getElementById('indicatorsContainer');

        //new bootstrap.Modal(document.getElementById('initialModal')).show();


        //ni bien carga la pagina entonces muestra el modal preguntando cuantas reservas quiere
        document.addEventListener('DOMContentLoaded', function() {
            var initialModal = new bootstrap.Modal(document.getElementById('initialModal'));
            initialModal.show();//no se a que se refiere con show,me imagino que muestra el modal
        });

        //agarra el boton de "generar" para generar los formularios, al hacer click crea los formularios
        document.getElementById('startReservations').addEventListener('click', () => {
            const count = parseInt(document.getElementById('reservationCount').value);
            generateForms(count);
        });




        function generateForms(count) {
            for (let i = formContainer.children.length; i < count; i++) {
                const formTemplate = document.getElementById('reservationFormTemplate').content.cloneNode(true);//clona el formulario
                const formSlide = formTemplate.querySelector('.form-slide');
                
                const nacionalidadSelect = formSlide.querySelector('[name="nacionalidad"]');
                const tiempoEstadiaSelect=formSlide.querySelector('[name="tiempoEstadia"]');
                //const nacionlidadSelect=formSlide.querySelector('[name="nacionalidad"]');
                
                console.log(tiempoEstadiaSelect);
                populateNacionalidades(nacionalidadSelect); // Llenar nacionalidades
                cargarTiempoEstadia(tiempoEstadiaSelect);
                assignValidationsToForm(formSlide); // Asignar validaciones
                
                formContainer.appendChild(formTemplate);
                const indicator = document.createElement('div');
                indicator.classList.add('indicator');

                if (i === 0) indicator.classList.add('active');
                indicatorsContainer.appendChild(indicator);
            }
            currentFormIndex = 0;
            updateFormPosition();//actualizar las posiciones de los formularios
            assignIndicatorClickEvents(); // Reasignar eventos después de agregar nuevos indicadores
        }

        function assignIndicatorClickEvents() {//creo que asigna eventos a cada indicador,los indicadores son los puntos
            Array.from(indicatorsContainer.children).forEach((indicator, index) => {
                indicator.onclick = () => {
                    currentFormIndex = index;
                    updateFormPosition();
                };
            });
        }

        function updateFormPosition() {//muevo los formularios para que aparenten estar separados
            
            formContainer.style.transform = `translateX(-${currentFormIndex * 100}%)`;
            updateActiveIndicator();
        }

        function updateActiveIndicator() {
            const indicators = indicatorsContainer.children;
            Array.from(indicators).forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentFormIndex);
            });
        }

        // Actualizar los eventos al agregar un nuevo formulario
        document.getElementById('addForm').addEventListener('click', () => {
            const formTemplate = document.getElementById('reservationFormTemplate').content.cloneNode(true);
            
            
            const nacionalidadSelect = formTemplate.querySelector('[name="nacionalidad"]');
            //console.log(nacionalidadSelect);
            populateNacionalidades(nacionalidadSelect); // Llenar nacionalidades
            
            const tiempoEstadiaSelect=formTemplate.querySelector('[name="tiempoEstadia"]');//poblar dias
            cargarTiempoEstadia(tiempoEstadiaSelect);
            
            formContainer.appendChild(formTemplate);
            const indicator = document.createElement('div');
            indicator.classList.add('indicator');
            indicatorsContainer.appendChild(indicator);

            asignarValidacionesAlFormularioAlAgregar();
            assignIndicatorClickEvents(); // Reasignar eventos después de agregar
        });
        //para eliminar un formulario
        document.getElementById('removeForm').addEventListener('click', () => {
            if (formContainer.children.length > 1) {
                formContainer.removeChild(formContainer.children[currentFormIndex]);
                indicatorsContainer.removeChild(indicatorsContainer.children[currentFormIndex]);
                currentFormIndex = Math.min(currentFormIndex, formContainer.children.length - 1);
                updateFormPosition();
                assignIndicatorClickEvents(); // Reasignar eventos después de eliminar
            }
        });
        //para ir al siguiente
        document.getElementById('nextBtn').addEventListener('click', () => {
            if (currentFormIndex < formContainer.children.length - 1) {
                currentFormIndex++;
                updateFormPosition();
            }
        });
        //para volver atras
        document.getElementById('prevBtn').addEventListener('click', () => {
            if (currentFormIndex > 0) {
                currentFormIndex--;
                updateFormPosition();
            }
        });
        //evento para el tipo de entrada
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
                form.querySelector('#ci-container').style.display = (tipoEntradaNombre == "Nacional") ? 'block' : 'none';
                form.querySelector('#pasaporte-container').style.display = (tipoEntradaNombre == "Extranjero" || tipoEntradaNombre=="Extranjero-Menor") ? 'block' : 'none';
                form.querySelector('#estudiante-container').style.display = (tipoEntradaNombre == "Estudiante") ? 'block' : 'none';
                form.querySelector('#nombre-container').style.display = (tipoEntradaNombre != null) ? 'block' : 'none';
                form.querySelector('#edad-container').style.display = (tipoEntradaNombre != null) ? 'block' : 'none';
                form.querySelector('.tiempoEstadia-container').style.display = (tipoEntradaNombre != null) ? 'block' : 'none';
                form.querySelector('.nacionalidad-container').style.display = (tipoEntradaNombre == "Extranjero"||tipoEntradaNombre=="Extranjero-Menor") ? 'block' : 'none';
                form.querySelector('#fecha-reserva-container').style.display = (tipoEntradaNombre != null) ? 'block' : 'none';
                const departamento = form.querySelector('#departamento');
                if (tipoEntradaNombre == "Extranjero" || tipoEntradaNombre=='Extranjero-Menor') {
                    departamento.value = '';
                    departamento.disabled = true;
                } else {
                    departamento.disabled = false;
                }
            }
        });
        //evento para la comunidad,aqui hace el fetch con AJAX
        document.addEventListener('change', function(event) {
            if (event.target.classList.contains('comunidad')) {
                const comunidadId = event.target.value;
                const form = event.target.closest('.form-slide');
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
                                option.setAttribute('data-nombre',ruta.nombre);
                                // Si la ruta no está disponible, la deshabilita y añade un texto indicativo
                                if (ruta.disponibilidad !== 'DISPONIBLE') {
                                        option.disabled = true;
                                        option.textContent += ' (No Disponible)';
                                    }

                                rutaSelect.appendChild(option);
                            });
                        })
                        .catch(() => {
                            alert('Error al obtener las rutas turísticas.');
                        });
                }
            }
        });

        // Deshabilitar el desplazamiento horizontal del contenedor del formulario
        //formContainer.style.overflowX = 'hidden';
    
    //    formContainer.style.width = `${formContainer.children.length * 100}%`;
        //formContainer.style.overflowX = 'hidden';

        //logica para envio de formulario a resumen

        
        //para envio de formularios
        document.getElementById('viewSummaryBtn').addEventListener('click', () => {
            let formData = [];

            //usar el storage para hacer reload y no muera

            // Limpiar el sessionStorage para eliminar cualquier dato previo
           // sessionStorage.clear();

            // Recorrer cada formulario y recopilar los datos

            Array.from(formContainer.children).forEach((formSlide) => {
                const form = formSlide.querySelector('form');
                const tipoEntradaSelect = form.querySelector('[name="tipo_entrada"]');
                const selectedOption = tipoEntradaSelect.options[tipoEntradaSelect.selectedIndex];
                //para departamento
                const departamentoSelect=form.querySelector('[name="departamento"]');
                const departamentoselectedOption = departamentoSelect.options[departamentoSelect.selectedIndex];
                //para comunidad
                const comunidadSelect=form.querySelector('[name="comunidad"]');
                const comunidadselectedOption=comunidadSelect.options[comunidadSelect.selectedIndex];
                //para ruta turistica
                const rutaTuristicaSelect=form.querySelector('[name="ruta_turistica"]');
                const rutaTuristicaselectedOption=rutaTuristicaSelect.options[rutaTuristicaSelect.selectedIndex];

                //para la fecha
                let fechaReserva = form.querySelector('[name="fecha_reserva"]').value;
                if (!fechaReserva) {
                    const today = new Date();
                    const day = String(today.getDate()).padStart(2, '0');
                    const month = String(today.getMonth() + 1).padStart(2, '0'); // Enero es 0
                    const year = today.getFullYear();
                    fechaReserva = `${year}-${month}-${day}`;
                }
                let data = {
                    tipo_entrada: tipoEntradaSelect.value,
                    departamento: departamentoSelect.value,
                    comunidad: comunidadSelect.value,
                    ruta_turistica: rutaTuristicaSelect.value,
                    nombre: form.querySelector('[name="nombre"]')?.value || '',
                    ci: form.querySelector('[name="ci"]')?.value || '',
                    edad: form.querySelector('[name="edad"]')?.value || '',
                    tiempoEstadia: form.querySelector('[name="tiempoEstadia"]')?.value || '',
                    nacionalidad: form.querySelector('[name="nacionalidad"]')?.value || '',
                    pasaporte: form.querySelector('[name="pasaporte"]')?.value || '',
                    ci_estudiante: form.querySelector('[name="ci_estudiante"]')?.value || '',
                    unidad_educativa: form.querySelector('[name="unidad_educativa"]')?.value || '',
                    precioEntrada: selectedOption.getAttribute('data-precio')||'',

                    fecha_reserva: fechaReserva,

                    nombre_departamento: departamentoselectedOption.getAttribute('data-nombre')||'',
                    nombre_comunidad:comunidadselectedOption.getAttribute('data-nombre')||'',
                    nombre_ruta_turistica:rutaTuristicaselectedOption.getAttribute('data-nombre')||''

                };
                formData.push(data);
            });


            //lo almaceno en el storage 
            // Guardar los datos de las reservas en sessionStorage
            sessionStorage.clear();

            // Crear un formulario oculto para enviar los datos a Resumen.blade.php
            const summaryForm = document.createElement('form');
            summaryForm.method = 'POST';
            summaryForm.action = '{{ route("usuario.formulario.resumen") }}'; // Asegúrate de tener definida la ruta correspondiente en Laravel

            // Agregar CSRF token para proteger la solicitud
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            summaryForm.appendChild(csrfInput);

            // Añadir los datos de cada formulario al formulario oculto
            formData.forEach((data, index) => {
                for (let key in data) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `formData[${index}][${key}]`;
                    input.value = data[key];
                    summaryForm.appendChild(input);
                }
            });

            // Añadir el formulario al DOM y enviarlo
            document.body.appendChild(summaryForm);
            summaryForm.submit();
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
      function populateNacionalidades(selectElement) {
            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country;
                option.textContent = country;
                selectElement.appendChild(option);
            });
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
            const tipoEntradaSelect = formSlide.querySelector('[name="tipo_entrada"]');
            const edadLimite=tipoEntradaSelect.value==="1"||tipoEntradaSelect.value==="4"?18:100;
            // Validación de la edad
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
    function asignarValidacionesAlFormularioAlAgregar(){
        const forms = document.querySelectorAll('.form-slide');
        forms.forEach((form)=>{
            assignValidationsToForm(form);
        })
    }

        
    </script>
@endsection
