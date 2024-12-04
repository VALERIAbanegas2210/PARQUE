@extends('layouts.admin_template')

@section('header2')
    <title>Formularios de Reservas</title>
@endsection

@section('content')
            <div class="row">

                <!-- Primera fila: Ventas (A) y Ganancias (B) -->
                <div class="col-lg-6 col-md-6 mb-3">
                    <div class="card info-card sales-card">
                        <div class="filter ventas-filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filtrado</h6>
                                </li>
                                <li><a class="dropdown-item" href="#" data-filtro="hoy">Hoy</a></li>
                                <li><a class="dropdown-item" href="#" data-filtro="mes">Este Mes</a></li>
                                <li><a class="dropdown-item" href="#" data-filtro="año">Este Año</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Ventas <span>| Hoy</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>145</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-lg-6 col-md-6 mb-3">
                    <div class="card info-card revenue-card">
                        <div class="filter ganancias-filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filtrado</h6>
                                </li>
                                <li><a class="dropdown-item" href="#" data-filtro="hoy">Hoy</a></li>
                                <li><a class="dropdown-item" href="#" data-filtro="mes">Este Mes</a></li>
                                <li><a class="dropdown-item" href="#" data-filtro="año">Este Año</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Ganancias <span>| Hoy</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>$3,264</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Segunda fila: Reportes (C) y Métodos de pago (F) -->
                <!---grafica de las ventas del dia-->
                <div class="col-lg-8 col-md-12 mb-3">
                    <div class="card">
                        <div class="card info-card ventas-graficaSx-card">
                            <div class="filter ventas-grafica-filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start"><h6>Filtrado</h6></li>
                                    <li><a class="dropdown-item" href="#" data-filtro="hoy">Hoy</a></li>
                                    <li><a class="dropdown-item" href="#" data-filtro="mes">Este Mes</a></li>
                                    <li><a class="dropdown-item" href="#" data-filtro="año">Este Año</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Ventas <span>| Hoy</span></h5>
                                <div id="ventasGraficaChart" style="min-height: 400px;"></div>
                            </div>
                            <!-- Line Chart -->
                        </div>    

                            <!--<script>
                                document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#reportsChart"), {
                                    series: [{
                                    name: 'Sales',
                                    data: [31, 40, 28, 51, 42, 82, 56],
                                    }, {
                                    name: 'Revenue',
                                    data: [11, 32, 45, 32, 34, 52, 41]
                                    }, {
                                    name: 'Customers',
                                    data: [15, 11, 32, 18, 9, 24, 11]
                                    }],
                                    chart: {
                                    height: 350,
                                    type: 'area',
                                    toolbar: {
                                        show: false
                                    },
                                    },
                                    markers: {
                                    size: 4
                                    },
                                    colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                    fill: {
                                    type: "gradient",
                                    gradient: {
                                        shadeIntensity: 1,
                                        opacityFrom: 0.3,
                                        opacityTo: 0.4,
                                        stops: [0, 90, 100]
                                    }
                                    },
                                    dataLabels: {
                                    enabled: false
                                    },
                                    stroke: {
                                    curve: 'smooth',
                                    width: 2
                                    },
                                    xaxis: {
                                    type: 'datetime',
                                    categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                                    },
                                    tooltip: {
                                    x: {
                                        format: 'dd/MM/yy HH:mm'
                                    },
                                    }
                                }).render();
                                });
                            </script>-->
                            <!-- End Line Chart -->


                        
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 mb-3">
                    <div class="card">
                        <div class="filter tortas-filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filtrador</h6>
                                </li>
                                <li><a class="dropdown-item" href="#" data-filtro="hoy">Hoy</a></li>
                                <li><a class="dropdown-item" href="#" data-filtro="mes">Este Mes</a></li>
                                <li><a class="dropdown-item" href="#" data-filtro="año">Este Año</a></li>
                            </ul>
                        </div>
                        <div class="card-body pb-0">
                            <h5 class="card-title">Modos de Pago <span>| Hoy</span></h5>
                            <div id="trafficChart" style="min-height: 400px;"></div>
                        </div>
                    </div>
                </div>
            
                <!-- Tercera fila: Comunidades (D) y Gráfico de comunidades (E) -->
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="card">
                        <div class="comunidades-card">
                            <div class="filter comunidades-filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filtrador</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#" data-filtro="hoy">Hoy</a></li>
                                    <li><a class="dropdown-item" href="#" data-filtro="mes">Este Mes</a></li>
                                    <li><a class="dropdown-item" href="#" data-filtro="año">Este Año</a></li>
                                </ul>
                            </div>  
                            <div class="card-body pb-0">
                                <h5 class="card-title">Comunidades <span>| Hoy</span></h5>
                                <table class="table table-borderless" id="tablaVisitantes">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Comunidad</th>
                                            <th scope="col">Zona</th>
                                            <th scope="col">Nro Visitantes</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="card">
                        <div class="comunidades-graficas-card">
                            <div class="filter comunidades-filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filtrador</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#" data-filtro="hoy">Hoy</a></li>
                                    <li><a class="dropdown-item" href="#" data-filtro="mes">Este Mes</a></li>
                                    <li><a class="dropdown-item" href="#" data-filtro="año">Este Año</a></li>
                                </ul>
                            </div>
                            
                            <div class="card-body pb-0">
                                <h5 class="card-title">Gráfico de Comunidades <span>| Hoy</span></h5>
                                <div id="comunidadesChart" style="min-height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        <script>
            //logica ventas
        document.addEventListener('DOMContentLoaded', function () {
            // Realizar solicitud inicial para mostrar las ventas de "Hoy"
            fetchVentas('hoy', 'hoy');

            // Seleccionar solo los elementos del filtro de ventas
            const ventasFiltroItems = document.querySelectorAll('.ventas-filter .dropdown-item');

            ventasFiltroItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Obtener el filtro seleccionado
                    const filtro = this.getAttribute('data-filtro'); // Usamos data-filtro para obtener el tipo de filtro
                    const filtroTexto = this.textContent.trim(); // Obtenemos el texto del filtro ("Hoy", "Este Mes", "Este Año")

                    // Realizar solicitud al backend
                    fetchVentas(filtro, filtroTexto);
                });
            });


            //para ganancias
            fetchGanancias('hoy', 'hoy');

            // Seleccionar solo los elementos del filtro de ventas
            const gananciasFiltroItems = document.querySelectorAll('.ganancias-filter .dropdown-item');

            gananciasFiltroItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Obtener el filtro seleccionado
                    const filtro = this.getAttribute('data-filtro'); // Usamos data-filtro para obtener el tipo de filtro
                    const filtroTexto = this.textContent.trim(); // Obtenemos el texto del filtro ("Hoy", "Este Mes", "Este Año")

                    // Realizar solicitud al backend
                    fetchGanancias(filtro, filtroTexto);
                });
            });

            // Lógica para el gráfico de Torta (Modos de Pago)
            fetchTortas('hoy', 'hoy');
            const tortaFiltroItems = document.querySelectorAll('.tortas-filter .dropdown-item');
            tortaFiltroItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    const filtro = this.getAttribute('data-filtro');
                    const filtroTexto = this.textContent.trim();
                    fetchTortas(filtro, filtroTexto);
                });
            });


            //para las comunidades
            fetchVisitantes('hoy','hoy'); // Por defecto, muestra los datos de hoy
            const comunidadFiltroItems = document.querySelectorAll('.comunidades-filter .dropdown-item');
            comunidadFiltroItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    const filtro = this.getAttribute('data-filtro');
                    const filtroTexto = this.textContent.trim();
                    
                    fetchVisitantes(filtro,filtroTexto);
                });
            });

            //para las ventas en formato grafico

            const ventasGraficaChart = new ApexCharts(document.querySelector("#ventasGraficaChart"), {
                series: [{
                    name: "Ventas",
                    data: [] // Datos iniciales
                }],
                chart: {
                    height: 400,
                    type: 'line'
                },
                xaxis: {
                    categories: [] // Etiquetas iniciales
                },
                colors: ['#4154f1'],
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                tooltip: {
                    x: {
                        format: 'dd/MM HH:mm'
                    }
                }
            });
            ventasGraficaChart.render();

            // Función para actualizar la gráfica
            function actualizarGraficaVentas(filtro, filtroTexto) {
                fetch(`{{route('ventas.grafica.filtrar')}}?filtro=${filtro}`) // Asegúrate de cambiar a tu ruta correcta
                    .then(response => response.json())
                    .then(data => {
                        ventasGraficaChart.updateOptions({
                            series: [{
                                name: 'Ventas',
                                data: data.data
                            }],
                            xaxis: {
                                categories: data.labels
                            }
                        });

                        // Actualizar el título del filtro
                        document.querySelector(".ventas-graficaSx-card .card-title span").textContent = `| ${filtroTexto}`;
                    })
                    .catch(error => console.error('Error al cargar los datos:', error));
            }

            // Manejar el filtro
            document.querySelectorAll('.ventas-grafica-filter .dropdown-item').forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    const filtro = this.getAttribute('data-filtro');
                    const filtroTexto = this.textContent.trim();
                    actualizarGraficaVentas(filtro, filtroTexto);
                });
            });

            // Cargar datos por defecto (hoy)
            actualizarGraficaVentas('hoy', 'Hoy');


        });

        // Función para realizar la solicitud al backend y actualizar la UI
        function fetchVentas(filtro, filtroTexto) {
            fetch(`{{ route('ventas.filtrar') }}?filtro=${filtro}`)
                .then(response => response.json())
                .then(data => {
                    if (data.totalVentas !== undefined) {
                        actualizarVentasUI(data, filtroTexto); // Actualiza la UI y el filtro
                    } else {
                        console.error('Error en la respuesta:', data.error);
                    }
                })
                .catch(error => console.log('Error:', error));
        }

        // Función para actualizar únicamente la UI de ventas
        function actualizarVentasUI(data,filtroTexto) {
            const ventasElemento = document.querySelector('.sales-card .ps-3 h6'); // Selector específico para la tarjeta de ventas
            ventasElemento.textContent = data.totalVentas || 0;
              // Actualizar el texto del filtro (por ejemplo, "Hoy", "Este Mes", "Este Año")
            const filtroTitulo = document.querySelector('.sales-card .card-title span'); // Selector para el span del filtro
            if (filtroTitulo) {
                filtroTitulo.textContent = `| ${filtroTexto}`; // Actualizamos el filtro dinámicamente
            }
        }
        
        //logica para saber las ganancias
        function fetchGanancias(filtro, filtroTexto) {
            fetch(`{{ route('ganancias.filtrar') }}?filtro=${filtro}`)
                .then(response => response.json())
                .then(data => {
                    if (data.totalGanancias !== undefined) {
                        actualizarGananciasUI(data, filtroTexto); // Actualiza la UI y el filtro
                    } else {
                        console.error('Error en la respuesta:', data.error);
                    }
                })
                .catch(error => console.log('Error:', error));
        }

        function actualizarGananciasUI(data,filtroTexto){
            const gananciasElemento = document.querySelector('.revenue-card .ps-3 h6'); // Selector específico para la tarjeta de ventas
            gananciasElemento.textContent =`${data.totalGanancias || 0}Bs`  ;
              // Actualizar el texto del filtro (por ejemplo, "Hoy", "Este Mes", "Este Año")
            const filtroTitulo = document.querySelector('.revenue-card .card-title span'); // Selector para el span del filtro
            if (filtroTitulo) {
                filtroTitulo.textContent = `| ${filtroTexto}`; // Actualizamos el filtro dinámicamente
            }
        }


        //torta
        
         // Función para Torta
        function fetchTortas(filtro, filtroTexto) {
            fetch(`{{ route('tortas.filtrar') }}?filtro=${filtro}`)
                .then(response => response.json())
                .then(data => {
                    if (data.cantidadQR !== undefined && data.cantidadEfectivo !== undefined && data.cantidadMixto !== undefined) {
                        actualizarTortaUI(data, filtroTexto);
                    } else {
                        console.error('Error en la respuesta:', data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function actualizarTortaUI(data, filtroTexto) {
            const trafficChart = echarts.init(document.querySelector('#trafficChart'));
            trafficChart.setOption({
                tooltip: {
                    trigger: 'item',
                },
                legend: {
                    top: '5%',
                    left: 'center',
                },
                series: [
                    {
                        name: 'Modos de Pago',
                        type: 'pie',
                        radius: ['40%', '70%'],
                        avoidLabelOverlap: false,
                        label: {
                            show: false,
                            position: 'center',
                        },
                        emphasis: {
                            label: {
                                show: true,
                                fontSize: '18',
                                fontWeight: 'bold',
                            },
                        },
                        labelLine: {
                            show: false,
                        },
                        data: [
                            { value: data.cantidadQR, name: 'QR' },
                            { value: data.cantidadEfectivo, name: 'Efectivo' },
                            { value: data.cantidadMixto, name: 'Mixto' },
                        ],
                    },
                ],
            });

            const filtroTitulo = document.querySelector('.tortas-card .card-title span');
            //console.log(`actualziacion torta ${filtroTexto}`);
            if (filtroTitulo) {
                filtroTitulo.textContent = `| ${filtroTexto}`;
            }
        }

        //para las comunidades
        function fetchVisitantes(filtro,filtroTexto) {
            fetch(`{{ route('comunidades.visitantes.filtrar') }}?filtro=${filtro}`) // Ruta del backend
                .then(response => response.json())
                .then(data => {
                    actualizarTablaVisitantes(data,filtroTexto);
                    actualizarGraficoComunidades(data, filtroTexto);
                })
                .catch(error => console.error('Error:', error));
        }

        function actualizarTablaVisitantes(data,filtroTexto) {
            const tbody = document.querySelector('#tablaVisitantes tbody'); // Selector del tbody
            tbody.innerHTML = ''; // Limpiar contenido previo

            const nombres = [];
            const visitantes = [];

            data.forEach(item => {
                const fila = `
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.nombre}</td>
                        <td>${item.zona}</td>
                        <td>${item.nro_visitantes}</td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', fila);
                // Guardar datos para el gráfico
                nombres.push(item.nombre);
                visitantes.push(item.nro_visitantes);
            });
            // Actualizar el gráfico
            renderizarGraficoComunidades(nombres, visitantes);
            const filtroTitulo = document.querySelector('.comunidades-card .card-title span');
            //console.log(`actualziacion torta ${filtroTexto}`);
            if (filtroTitulo) {
                filtroTitulo.textContent = `| ${filtroTexto}`;
            }
        }
        function renderizarGraficoComunidades(nombres, visitantes) {
            const comunidadesChart = echarts.init(document.querySelector('#comunidadesChart'));

            const option = {
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow',
                    },
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true,
                },
                xAxis: {
                    type: 'value',
                },
                yAxis: {
                    type: 'category',
                    data: nombres, // Nombres de las comunidades
                },
                series: [
                    {
                        name: 'Nro Visitantes',
                        type: 'bar',
                        data: visitantes, // Número de visitantes por comunidad
                        itemStyle: {
                            color: '#4CAF50', // Color personalizado para las barras
                        },
                    },
                ],
            };

            comunidadesChart.setOption(option);
        }
        // Actualizar el gráfico
        function actualizarGraficoComunidades(data, filtroTexto) {
            const trafficChart = echarts.init(document.querySelector('#comunidadesChart'));
            const nombres = data.map(item => item.nombre);
            const valores = data.map(item => item.nro_visitantes);

            // Generar colores únicos
            const colores = data.map(() => `#${Math.floor(Math.random() * 16777215).toString(16)}`);

            trafficChart.setOption({
                tooltip: {
                    trigger: 'axis',
                    axisPointer: { type: 'shadow' }
                },
                xAxis: {
                    type: 'value',
                    boundaryGap: [0, 0.01]
                },
                yAxis: {
                    type: 'category',
                    data: nombres
                },
                series: [
                    {
                        name: 'Visitantes',
                        type: 'bar',
                        data: valores,
                        itemStyle: {
                            color: function (params) {
                                return colores[params.dataIndex];
                            }
                        }
                    }
                ]
            });

            const filtroTitulo = document.querySelector('.comunidades-graficas-card .card-title span');
            if (filtroTitulo) {
                filtroTitulo.textContent = `| ${filtroTexto}`;
            }
        }


        //para hacer responsivo los cambios
        const charts = [
            { id: '#reportsChart', type: 'apex' },
            { id: '#trafficChart', type: 'echarts' },
            { id: '#comunidadesChart', type: 'echarts' }
        ];

        function resizeCharts() {
            charts.forEach(chart => {
                if (chart.type === 'apex') {
                    const apexChart = ApexCharts.getChartByID(chart.id);
                    if (apexChart) apexChart.resize();
                } else if (chart.type === 'echarts') {
                    const echart = echarts.getInstanceByDom(document.querySelector(chart.id));
                    if (echart) echart.resize();
                }
            });
        }

        // Redimensionar gráficos en tiempo real
        window.addEventListener("resize", resizeCharts);
    </script>
@endsection