@extends($layout)

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

    <!--Modal para pedirle cuantas reservas quiere hacer el usuario -->
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
                            <select class="form-select departamento" name="departamento">
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
                            <select class="form-select ruta_turistica" name="ruta_turistica">
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
                    <div class="col-md-6 nombre-container" style="display: none;">
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
                    <div class="col-md-6 ci-container" style="display: none;">
                        <div class="form-group">
                            <label class="form-label"><span class="fw-bold">Cédula de Identidad (CI)</span></label>
                            <input type="number" class="form-control" name="ci" placeholder="Escriba su CI (solo numero)" required>
                            <div class="invalid-feedback">
                                Campo Rellenado incorrectamente
                              </div>
                            <div class="valid-feedback">
                                CI rellenado correctamente
                            </div>
                        </div>
                    </div>

                    <!-- Edad -->
                    <div class="col-md-6 edad-container" style="display: none;">
                        <div class="form-group">
                            <label class="form-label"><span class="fw-bold">Edad</span></label>
                            <input type="number" class="form-control" name="edad" placeholder="Digite su edad" required>
                            <div id="invalidEdad" class="invalid-feedback">
                                edad incorrecta,debe ser mayor que 0 y menor o igual a 100
                              </div>
                            <div class="valid-feedback">
                              ¡edad correcta!
                            </div>
                        </div>
                    </div>

                    <!-- Tiempo de Estadia -->
                  <!--  <div class="col-md-6 tiempoEstadia-container" style="display: none;">
                        <div class="form-group">
                            <label class="form-label"><span class="fw-bold">Tiempo de Estadia</span></label>
                            <input type="number" class="form-control" name="tiempoEstadia" placeholder="Digite el tiempo de estadia en dias" required>
                        </div>
                    </div>-->
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
                    <div class="col-md-6 pasaporte-container" style="display: none;">
                        <div class="form-group">
                            <label class="form-label"><span class="fw-bold">Pasaporte</span></label>
                            <input type="text" class="form-control" name="pasaporte" placeholder="Escriba su pasaporte" required>
                            <div class="invalid-feedback">
                                Campo Rellenado incorrectamente
                              </div>
                            <div class="valid-feedback">
                                ¡Pasaporte rellenado correctamente!
                            </div>
                        </div>
                    </div>
                    
                    <!-- Datos de Estudiantes -->
                    <div class="col-md-6 estudiante-container" style="display: none;">
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
                    
                    <!-- Tipo de Pago dependiendo cual seleccione se activa para realizar el qr o efectivo -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><span class="fw-bold">Tipo de Pago</span></label>
                            <select class="form-select tipo_pago" name="tipo_pago" required>
                                <option value="">Seleccione el tipo de pago</option>
                                <option value="QR">QR</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Mixto">Mixto</option>
                            </select>
                        </div>
                    </div>

                    <!-- Monto QR (solo para tipo de pago mixto) -->
                    <div class="col-md-6 monto_qr_container" style="display: none;">
                        <div class="form-group">
                            <label class="form-label"><span class="fw-bold">Monto QR</span></label>
                            <input type="number" class="form-control monto_qr" name="monto_qr" placeholder="Monto pagado con QR" required>
                        </div>
                    </div>

                    <!-- Monto Efectivo (solo para tipo de pago mixto) -->
                    <div class="col-md-6 monto_efectivo_container" style="display: none;">
                        <div class="form-group">
                            <label class="form-label"><span class="fw-bold">Monto Efectivo</span></label>
                            <input type="number" class="form-control monto_efectivo" name="monto_efectivo" placeholder="Monto pagado en efectivo" required>
                        </div>
                    </div>

                    <!-- Mensaje de validación,solamente mostrar si no cumple la validacion-->
                    <div class="col-md-12" id="validation_message" style="color: red; display: none;">
                        <p>El monto total debe ser igual al precio de la entrada.</p>
                    </div>
                </div>
            </form>
        </div>
    </template>
    

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
            background-color: #007bff;
        }
        /* Estilo general para todos los select */
        
        .is-invalid ~ .invalid-feedback {
            display: block; /* Mostrar solo si es inválido */
        }
        .is-valid ~ .valid-feedback {
            display: block; /* Mostrar solo si es válido */
        }
        /* Específico para selects dentro de un contenedor con clase 'form-group' */
        

    </style>

    <script>
        let currentFormIndex = 0;
        const formContainer = document.getElementById('formContainer');
        const indicatorsContainer = document.getElementById('indicatorsContainer');
        //para inicio del modal
        document.addEventListener('DOMContentLoaded', function () {
            const initialModal = new bootstrap.Modal(document.getElementById('initialModal'));
            initialModal.show();
        });

        //para generar lso formularios
        document.getElementById('startReservations').addEventListener('click', () => {
            const count = parseInt(document.getElementById('reservationCount').value);
            generateForms(count);
        });

        //aqui se crean los formularios junto a sus eventos,tambien se crean los puntos que se puede navegar
        //ENTONCES AQUI SE PUEDEN HACER LAS VALIDACIONES PARA QUE APARESCA EN TIEMPO REAL LAS EDAD 
        //Y DEMAS SERIA CREAR FUNCIONES
        function generateForms(count) {
            for (let i = formContainer.children.length; i < count; i++) {
                const formTemplate = document.getElementById('reservationFormTemplate').content.cloneNode(true);
                const formSlide = formTemplate.querySelector('.form-slide');
                
                // Añadir eventos al select de tipo de pago y los inputs de monto
                const tipoPagoSelect = formSlide.querySelector('.tipo_pago');
                const montoQrInput = formSlide.querySelector('.monto_qr');
                const montoEfectivoInput = formSlide.querySelector('.monto_efectivo');
                const montoQrContainer = formSlide.querySelector('.monto_qr_container');
                const montoEfectivoContainer = formSlide.querySelector('.monto_efectivo_container');
                const nacionalidadSelect = formSlide.querySelector('[name="nacionalidad"]');
                const tiempoEstadiaSelect=formSlide.querySelector('[name="tiempoEstadia"]');
                //const nacionlidadSelect=formSlide.querySelector('[name="nacionalidad"]');

                console.log(tiempoEstadiaSelect);
                populateNacionalidades(nacionalidadSelect); // Llenar nacionalidades
                cargarTiempoEstadia(tiempoEstadiaSelect);
                assignValidationsToForm(formSlide); // Asignar validaciones
                
                // Evento para seleccionar tipo de pago
                tipoPagoSelect.addEventListener('change', function() {
                    const tipoPago = tipoPagoSelect.value;
                    if (tipoPago === 'Mixto') {//si es mixto muestra los bloques
                        montoQrContainer.style.display = 'block';
                        montoEfectivoContainer.style.display = 'block';
                    } else {//si no los mantiene en none,es decir el display no los muestra
                        montoQrContainer.style.display = 'none';
                        montoEfectivoContainer.style.display = 'none';
                        montoQrInput.value = '';
                        montoEfectivoInput.value = '';
                    }
                });

                // Evento para validar la suma de los montos cuando el pago es mixto
                montoQrInput.addEventListener('input', validatePayment);
                montoEfectivoInput.addEventListener('input', validatePayment);

                function validatePayment() {
                    const tipoEntradaSelect = formSlide.querySelector('[name="tipo_entrada"]');
                    const selectedOption = tipoEntradaSelect.options[tipoEntradaSelect.selectedIndex];
                    const precioEntrada = parseFloat(selectedOption.getAttribute('data-precio')) || 0;

                    const montoQr = parseFloat(montoQrInput.value) || 0;
                    const montoEfectivo = parseFloat(montoEfectivoInput.value) || 0;
                    const totalMonto = montoQr + montoEfectivo;

                    // Mensaje de validación
                    let validationMessage = formSlide.querySelector('.validation_message');
                    if (!validationMessage) {
                        validationMessage = document.createElement('div');
                        validationMessage.classList.add('validation_message');
                        validationMessage.style.color = 'red';
                        formSlide.appendChild(validationMessage);
                    }

                    // Mostrar mensaje si el total no coincide con el precio de la entrada
                    if (totalMonto !== precioEntrada && tipoPagoSelect.value === 'Mixto') {
                        validationMessage.innerText = `La suma de los montos debe ser igual a ${precioEntrada} Bs. Actualmente es ${totalMonto} Bs.`;
                    } else {
                        validationMessage.innerText = '';
                    }
                }

                formContainer.appendChild(formSlide);
                
                // Crear indicador
                const indicator = document.createElement('div');
                indicator.classList.add('indicator');
                if (i === 0) indicator.classList.add('active');
                indicatorsContainer.appendChild(indicator);
            }
            currentFormIndex = 0;
            //solo para actualizar la vista nada que ver con los eventos
            updateFormPosition();
            assignIndicatorClickEvents(); // Reasignar eventos después de agregar nuevos indicadores
        }


        //para darle eventos a los indicadores
        function assignIndicatorClickEvents() {
            Array.from(indicatorsContainer.children).forEach((indicator, index) => {
                indicator.onclick = () => {
                    currentFormIndex = index;
                    updateFormPosition();
                };
            });
        }
        //para actualizar el formulario de posicion
        function updateFormPosition() {
            formContainer.style.transform = `translateX(-${currentFormIndex * 100}%)`;
            updateActiveIndicator();
        }

        function updateActiveIndicator() {
            const indicators = indicatorsContainer.children;
            Array.from(indicators).forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentFormIndex);
            });
        }
        //para agregar formularios
        //Y TAMBIEN AQUI PARA AGREGAR ALGUNOS CAMBIOS,POR SI SE AGREGA UN FORMULARIO,LOS NUEVOS OBJETOS DEBEN 
        //TENER ESOS EVENTOS DE VALIDACION

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
            assignIndicatorClickEvents();
            //console.log(`formulario en addform formTemplate: ${formTemplate.querySelector('form-slide')}`)
            //assignValidationsToForm(formTemplate); // Asignar validaciones
            asignarValidacionesAlFormularioAlAgregar();
            assignPaymentTypeEvents(); // Asignar eventos de tipo de pago

        });

        //eliminacion de formulario

        document.getElementById('removeForm').addEventListener('click', () => {
            if (formContainer.children.length > 1) {
                formContainer.removeChild(formContainer.children[currentFormIndex]);
                indicatorsContainer.removeChild(indicatorsContainer.children[currentFormIndex]);
                currentFormIndex = Math.min(currentFormIndex, formContainer.children.length - 1);
                updateFormPosition();
                assignIndicatorClickEvents();
            }
        });

        // evento para ir al siguiente elemento del formulario

        document.getElementById('nextBtn').addEventListener('click', () => {
            if (currentFormIndex < formContainer.children.length - 1) {
                currentFormIndex++;
                updateFormPosition();
            }
        });

        // evento para ir a un formulario anterior

        document.getElementById('prevBtn').addEventListener('click', () => {
            if (currentFormIndex > 0) {
                currentFormIndex--;
                updateFormPosition();
            }
        });

        //para agregar los eventos a cada tipo de pago de cada formulario para que sean independientes
        function assignPaymentTypeEvents() {
            //seleccionar todos los formularios
            const forms = document.querySelectorAll('.form-slide');
            forms.forEach((form) => {
                const tipoPagoSelect = form.querySelector('.tipo_pago');
                const montoQrContainer = form.querySelector('.monto_qr_container');
                const montoEfectivoContainer = form.querySelector('.monto_efectivo_container');

                tipoPagoSelect.addEventListener('change', function () {
                    const tipoPago = tipoPagoSelect.value;

                    if (tipoPago === 'Mixto') {
                        montoQrContainer.style.display = 'block';
                        montoEfectivoContainer.style.display = 'block';
                        const montoQrInput = form.querySelector('.monto_qr');
                        const montoEfectivoInput = form.querySelector('.monto_efectivo');
                        //montoQrInput.addEventListener('input', validatePayment);
                        //montoEfectivoInput.addEventListener('input', validatePayment);
                         // Asignar eventos para validar los montos
                        montoQrInput.addEventListener('input', () => validatePayment(form));
                        montoEfectivoInput.addEventListener('input', () => validatePayment(form));

                    } else {
                        montoQrContainer.style.display = 'none';
                        montoEfectivoContainer.style.display = 'none';
                        form.querySelector('.monto_qr').value = '';
                        form.querySelector('.monto_efectivo').value = '';
                         // Limpiar cualquier mensaje de validación
                        form.querySelector('.validation_message')?.remove();
                    }
                   
                });

            });
        }

        //evento para tipo de entrada
        document.addEventListener('change', function (event) {
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
                form.querySelector('.ci-container').style.display = (tipoEntradaNombre == "Nacional") ? 'block' : 'none';
                form.querySelector('.pasaporte-container').style.display = (tipoEntradaNombre == "Extranjero" || tipoEntradaNombre == "Extranjero-Menor") ? 'block' : 'none';
                form.querySelector('.estudiante-container').style.display = (tipoEntradaNombre == "Estudiante") ? 'block' : 'none';
                form.querySelector('.nombre-container').style.display = (tipoEntradaNombre != null) ? 'block' : 'none';
                form.querySelector('.edad-container').style.display = (tipoEntradaNombre != null) ? 'block' : 'none';
                form.querySelector('.tiempoEstadia-container').style.display = (tipoEntradaNombre != null) ? 'block' : 'none';
                form.querySelector('.nacionalidad-container').style.display = (tipoEntradaNombre == "Extranjero" || tipoEntradaNombre == "Extranjero-Menor") ? 'block' : 'none';
                form.querySelector('#fecha-reserva-container').style.display = (tipoEntradaNombre != null) ? 'block' : 'none';

                const departamento = form.querySelector('.departamento');
                if (tipoEntradaNombre == "Extranjero" || tipoEntradaNombre == 'Extranjero-Menor') {
                    departamento.value = '';
                    departamento.disabled = true;
                } else {
                    departamento.disabled = false;
                }
            }
        });

//para hacer peticiones AJAX para llenar las rutas turisticas
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


        //funcion para validar el pago
        function validatePayment(form) {
            const tipoEntradaSelect = form.querySelector('[name="tipo_entrada"]');
            const selectedOption = tipoEntradaSelect.options[tipoEntradaSelect.selectedIndex];

            // Obtener los montos ingresados
            const montoQr = parseFloat(form.querySelector('.monto_qr').value) || 0;
            const montoEfectivo = parseFloat(form.querySelector('.monto_efectivo').value) || 0;
            const totalMonto = montoQr + montoEfectivo;
            const precioEntrada = parseFloat(selectedOption.getAttribute('data-precio')) || 0;

            // Mensaje de validación
            let validationMessage = form.querySelector('.validation_message');
            if (!validationMessage) {
                validationMessage = document.createElement('div');
                validationMessage.classList.add('validation_message');
                validationMessage.style.color = 'red';
                form.appendChild(validationMessage);
            }

            // Mostrar mensaje si el total no coincide con el precio de la entrada
            if (totalMonto !== precioEntrada) {
                validationMessage.innerText = `La suma de los montos debe ser igual a ${precioEntrada} Bs. Actualmente es ${totalMonto} Bs.`;
            } else {
                validationMessage.innerText = '';
            }
        }

        //evento para cuando se envia el formulario
        document.getElementById('viewSummaryBtn').addEventListener('click', () => {
            
            sessionStorage.clear();//limpiar el storage cada que se presiona click en ver resumen

            let formData = [];


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

                //para el pago
                const tipoPago=form.querySelector('[name="tipo_pago"]');
                const tipoPagoSeleccionado=tipoPago.options[tipoPago.selectedIndex];//para saber el tipo de pago seleccionado

                //para nacionalidad
                //const nacionalidadSelect=form.querySelector('[name="nacionalidad"]');
                //const nacionalidadSelectedOption=nacionalidadSelect.options[nacionalidadSelect.selectedIndex];
                

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
                    nombre_departamento: departamentoselectedOption.getAttribute('data-nombre')||'',

                    fecha_reserva:fechaReserva,//si es nulo en el backend marca para hoy
                    //tipoPago:tipoPagoSeleccionado?.value||'',
                    nombre_comunidad:comunidadselectedOption.getAttribute('data-nombre')||'',
                    nombre_ruta_turistica:rutaTuristicaselectedOption.getAttribute('data-nombre')||''

                };
                data.tipoPago=tipoPagoSeleccionado?.value||'';

                if(tipoPagoSeleccionado.value==="Mixto"){
                    data.montoQR=form.querySelector('[name="monto_qr"]')?.value||'';
                    data.montoEfectivo=form.querySelector('[name="monto_efectivo"]')?.value||'';
                }
                //console.log(data);
                
                formData.push(data);
            });

            sessionStorage.clear();//limpio el storage por si hay datos que siguen ahí

            // Crear un formulario oculto para enviar los datos a Resumen.blade.php
            const summaryForm = document.createElement('form');
            summaryForm.method = 'POST';
            summaryForm.action = '{{ route("admin.formulario.resumen") }}'; // Asegúrate de tener definida la ruta correspondiente en Laravel

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


        //logica para agregar validaciones en tiempo real al formulario
        //logica para buscar nacionalidades
        /*document.addEventListener('DOMContentLoaded', function () {
            const nacionalidadSelect = document.getElementById('nacionalidad');
             // Fetch nacionalidades de la API
             fetch('https://restcountries.com/v3.1/all')
                .then(response => response.json())
                .then(data => {
                    data.forEach(country => {
                        const option = document.createElement('option');
                        option.value = country.name.common; // Gentilicio o nombre común
                        option.textContent = country.name.common;
                        nacionalidadSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar las nacionalidades:', error));
           
        });*/

        /*function fetchNacionalidad(nacionalidadSelect){

        }*/
        
        // Lista de países para América Latina y otros continentes
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
    function asignarValidacionesAlFormularioAlAgregar(){
        const forms = document.querySelectorAll('.form-slide');
        forms.forEach((form)=>{
            assignValidationsToForm(form);
        })
    }
     
    </script>
@endsection
