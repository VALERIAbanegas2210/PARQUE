@extends('layouts.template')

@section('header2')
    <title>Resumen de Reservas</title>
@endsection

@section('content')

    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">¡Atención!</h4>
        <p>  
        Si algunos formularios no aparecen en el resumen, esto puede deberse a multiples factores:
        
        <ul>
            <li>verique que este seleccionado las comunidades,ruta turistica, tipo de entrada</li>
            <li>Si es nacional o estudiante verifique que este seleccionado el departamento</li>
            <li>verifique que la fecha seleccionada sea la adecuada</li>
            <li>verifique que los montos de los pagos sean los adecuados</li>
            <li>verifique que no haya formularios sin rellenar</li>
        </ul>
        </p>
                
    </div>
    <div class="container mt-5">
        <!--funciones de php de conversion-->
        @php    
            $nombretipoEntradas=[
                "1"=>'Estudiante',
                "2"=>'Extranjero',
                "3"=>'Nacional',
                "4"=>'Extranjero-Menor'
            ];
        @endphp
        
        <h2>Resumen de Reservas</h2>
        
        <!-- Mensajes de alerta -->
        @isset($huboCambios)
            @if ($huboCambios ?? false)
                <div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    Hubo algunos datos no rellenados correctamente. Por favor, verifica los datos.
                </div>
            @else
                <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
                    Datos recibidos correctamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        @endisset
        <div class="row" id="resumenContainer">
            @if(empty($formData))
                <h3>No Reservo ningun formulario</h3>
            @endif

            
            <!-- Aquí se llenarán los datos desde sessionStorage si la página se recarga -->
            @foreach ($formData as $index => $data)
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5>Reserva {{ $index + 1 }}</h5>
                            <ul>
                                
                                <li><strong>Tipo de Entrada:</strong> {{ $nombretipoEntradas[$data['tipo_entrada']] }}</li>
                                
                                @isset($data['departamento'])
                                    <li><strong>Departamento:</strong> {{ $data['nombre_departamento'] }}</li>
                                @endisset

                                <li><strong>Comunidad:</strong> {{ $data['nombre_comunidad'] }}</li>
                                <li><strong>Ruta Turística:</strong> {{ $data['nombre_ruta_turistica'] }}</li>
                                
                                @isset($data['nombre'])
                                    <li><strong>Nombre:</strong> {{ $data['nombre'] }}</li>
                                @endisset

                                @isset($data['ci'])
                                    <li><strong>CI:</strong> {{ $data['ci'] }}</li>
                                @endisset

                                @isset($data['edad'])
                                    <li><strong>Edad:</strong> {{ $data['edad'] }}</li>
                                @endisset

                                @isset($data['tiempoEstadia'])
                                    <li><strong>Tiempo de Estadia:</strong> {{ $data['tiempoEstadia'] }} días</li>
                                @endisset

                                @isset($data['nacionalidad'])
                                    <li><strong>Nacionalidad:</strong> {{ $data['nacionalidad'] }}</li>
                                @endisset

                                @isset($data['pasaporte'])
                                    <li><strong>Pasaporte:</strong> {{ $data['pasaporte'] }}</li>
                                @endisset

                                @isset($data['rude'])
                                    <li><strong>Rude:</strong> {{ $data['rude'] }}</li>
                                @endisset

                                @isset($data['unidad_educativa'])
                                    <li><strong>Unidad Educativa:</strong> {{ $data['unidad_educativa'] }}</li>
                                @endisset
                                @isset($data['montoRelativo'])
                                    <li><strong>Precio De La Entrada</strong> {{ $data['montoRelativo'] }} Bs</li>
                                @endisset
                                @isset($data['tipoPago'])
                                    <li><strong>Tipo Pago: </strong> {{$data['tipoPago']}}</li>
                                    @if ($data['tipoPago']=="Mixto")
                                        <li><strong>Monto QR: </strong> {{$data['montoQR']}}Bs</li>
                                        <li><strong>Monto Efectivo: </strong> {{$data['montoEfectivo']}}Bs</li>
                                    @else
                                        <li><strong>Monto Pagado: </strong> {{$data['montoRelativo']}}Bs</li>
                                    @endif
                                @endisset
                                
                                @isset($data['fecha_reserva'])
                                    <li><strong>Fecha de Reserva: </strong> {{$data['fecha_reserva']}}</li>
                                @endisset

                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Total a pagar -->
        <div id="container-montoTotal" class="d-flex justify-content-start mb-4">
            <h6>Total A Pagar: {{ $montoTotal ?? 0 }} Bs</h6>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-between">
            <!--<button class="btn btn-secondary" onclick="window.history.go(-2);">Volver Atrás</button>-->
           <!-- <button id="goBackButton" class="btn btn-secondary">Volver Atrás</button>-->
            <form action="{{ route('usuario.formularios.guardarReservas') }}" method="POST">
                @csrf
                <input type="hidden" name="formData" value="{{ json_encode($formData) }}">
                <input type="hidden" name="montoTotal" value="{{ $montoTotal }}">
                @if($huboCambios===null || $huboCambios)
                    <button id="btn-submit" type="submit" class="btn btn-success" disabled>Confirmar y Enviar</button>
                @else
                    <button id="btn-submit" type="submit" class="btn btn-success" >Confirmar y Enviar</button>
                @endif             
            </form>
        </div>
    </div>

    <!-- Script para manejar sessionStorage -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const resumenContainer = document.getElementById('resumenContainer');
            const savedData = sessionStorage.getItem('formData');
            //sessionStorage.clear();
            console.log("antes");
            console.log(sessionStorage.getItem('formData'));
            console.log(@json($esActualizacion));
            //si no hay datos guardados, entonces cargalo al storage ya filtrados
            if (!savedData) {
                // Si no hay datos en sessionStorage, guardarlos al cargar la página
                const validatedData = @json($formData);
                const monto=@json($montoTotal);
                const huboCambios=@json($huboCambios);
                
                sessionStorage.setItem('formData', JSON.stringify(validatedData));
                sessionStorage.setItem('montoTotal', JSON.stringify(monto));
                sessionStorage.setItem('huboCambios',JSON.stringify(huboCambios))
                console.log("dewspues");
                console.log(sessionStorage.getItem('formData'));
                console.log(sessionStorage.getItem('montoTotal'));
                console.log(sessionStorage.getItem('huboCambios'));

            } else {
                // Si hay datos en sessionStorage, reconstruir la vista
                //preguntando si es actualizacion
                //si es actualizacion entonces carga lo que tenga el storage
                
                let esActualizacion=@json($esActualizacion);
                const montoGuardado=sessionStorage.getItem('montoTotal');
                const huboCambiosStorage=sessionStorage.getItem('huboCambios')
                if(esActualizacion){//si es actualizacion el monto es 0 y tendra que cargarlo desde el storage
                    const formData = JSON.parse(savedData);
                    const montoTotalData=JSON.parse(montoGuardado);
                    const huboCambios=JSON.parse(huboCambiosStorage);
                    console.log("es actualizacion")
                    console.log(huboCambios)
                    resumenContainer.innerHTML = ''; // Limpiar el contenido existente
                    cargarDatos(formData);
                    cargarMontoTotal(montoTotalData);
                    modificarEstadoBotonConfirmar(huboCambios);
                }else{//si no es actualizcaion entonces cargamos el nuevo monto total
                    sessionStorage.clear();
                    console.log("no es actualizacion")
                    const formData=@json($formData);
                    const monto=@json($montoTotal);
                    sessionStorage.setItem('formData', JSON.stringify(formData));
                    sessionStorage.setItem('montoTotal', JSON.stringify(monto));
                    cargarDatos(formData);
                    cargarMontoTotal(monto);
                    modificarEstadoBotonConfirmar(huboCambios);
                }
            }
        });

        function cargarDatos(formData) {
            const tipoEntradas = @json($nombretipoEntradas); // Pasamos el array PHP como un objeto JS
            const resumenContainer = document.getElementById('resumenContainer');
            resumenContainer.innerHTML = ''; // Limpia el contenedor antes de renderizar

            formData.forEach((data, index) => {
                resumenContainer.innerHTML += `
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5>Reserva ${index + 1}</h5>
                                <ul>
                                    <li><strong>Tipo de Entrada:</strong> ${tipoEntradas[data.tipo_entrada] || 'N/A'}</li>
                                    ${data.nombre_departamento ? `<li><strong>Departamento:</strong> ${data.nombre_departamento}</li>` : ''}
                                    <li><strong>Comunidad:</strong> ${data.nombre_comunidad || 'N/A'}</li>
                                    <li><strong>Ruta Turística:</strong> ${data.nombre_ruta_turistica || 'N/A'}</li>
                                    ${data.nombre ? `<li><strong>Nombre:</strong> ${data.nombre}</li>` : ''}
                                    ${data.ci ? `<li><strong>CI:</strong> ${data.ci}</li>` : ''}
                                    ${data.edad ? `<li><strong>Edad:</strong> ${data.edad}</li>` : ''}
                                    ${data.tiempoEstadia ? `<li><strong>Tiempo de Estadia:</strong> ${data.tiempoEstadia} días</li>` : ''}
                                    ${data.nacionalidad ? `<li><strong>Nacionalidad:</strong> ${data.nacionalidad}</li>` : ''}
                                    ${data.pasaporte ? `<li><strong>Pasaporte:</strong> ${data.pasaporte}</li>` : ''}
                                    ${data.unidad_educativa ? `<li><strong>Unidad Educativa:</strong> ${data.unidad_educativa}</li>` : ''}
                                    ${data.montoRelativo ? `<li><strong>Precio De La Entrada:</strong> ${data.montoRelativo} Bs</li>` : ''}
                                    <li><strong>Fecha de Reserva:</strong> ${data.fecha_reserva || 'N/A'}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                `;
            });
        }
        
        // Método para cargar el monto total
        function cargarMontoTotal(montoTotal) {
            const montoTotalContainer = document.getElementById('container-montoTotal');
            montoTotalContainer.innerHTML = `
                <h6>Total A Pagar: ${montoTotal || 0} Bs</h6>
            `;
        }
        /*document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('guardarReservasForm');

            if (form) {
                form.addEventListener('submit', (event) => {
                    // Limpia el sessionStorage antes de enviar el formulario
                    sessionStorage.clear();
                    
                    console.log('El almacenamiento de sesión se ha limpiado antes de enviar el formulario.');
                });
            }
        });*/


        function modificarEstadoBotonConfirmar(huboCambios) {
            
            
            const confirmButton = document.getElementById('btn-submit');
            console.log(`ingrese al modificar ${huboCambios}`)
            if (huboCambios||huboCambios===null) {
                confirmButton.setAttribute('disabled', 'disabled'); // Desactiva el botón
            } else {
                confirmButton.removeAttribute('disabled'); // Activa el botón
            }
        }

        /*document.getElementById('goBackButton').addEventListener('click', () => {
            //history.go(-1); // Retrocede al estado previo sin recargar.
            window.history.go(-2)
        });*/

    </script>
@endsection
