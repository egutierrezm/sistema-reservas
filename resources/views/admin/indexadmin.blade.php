@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>Bienvenido: </b>{{ Auth::user()->name }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href=""><b>Rol: {{ Auth::user()->roles->pluck('name')->implode(', ') }} </b></a> </li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <a href="{{ route('admin.role.index') }}">
                                    <img src="{{ asset('images/roles.gif') }}" width="100%" alt="Roles" />
                                </a>
                            </span>
                        <div class="info-box-content bg-custom">
                            <span class="info-box-text">Roles registrados</span>
                            <span class="info-box-number">{{ $totalRoles }} roles</span>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <a href="{{ route('admin.user.index') }}">
                                    <img src="{{ asset('images/users.gif') }}" width="100%" alt="Users" />
                                </a>
                            </span>
                        <div class="info-box-content bg-custom">
                            <span class="info-box-text">Usuarios registrados</span>
                            <span class="info-box-number">{{ $totalUsers }} usuarios</span>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <a href="{{ route('admin.espacioDeportivo.index') }}">
                                    <img src="{{ asset('images/espacios.gif') }}" width="100%" alt="Espacios" />
                                </a>
                            </span>
                        <div class="info-box-content bg-custom">
                            <span class="info-box-text">Espacios registrados</span>
                            <span class="info-box-number">{{ $totalEspacios }} espacios</span>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <a href="{{ route('admin.cancha.index') }}">
                                    <img src="{{ asset('images/canchas.gif') }}" width="100%" alt="Users" />
                                </a>
                            </span>
                            <div class="info-box-content bg-custom">
                                <span class="info-box-text">Canchas registradas</span>
                                <span class="info-box-number">{{ $totalCanchas }} canchas</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <a href="{{ route('admin.reserva.index') }}">
                                    <img src="{{ asset('images/reservas.gif') }}" width="100%" alt="Users" />
                                </a>
                            </span>
                            <div class="info-box-content bg-custom">
                                <span class="info-box-text">Reservas registradas</span>
                                <span class="info-box-number">{{ $totalReservas }} reservas</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <a href="{{ route('admin.deportista.index') }}">
                                    <img src="{{ asset('images/deportistas.gif') }}" width="100%" alt="Users" />
                                </a>
                            </span>
                            <div class="info-box-content bg-custom">
                                <span class="info-box-text">Clientes registrados</span>
                                <span class="info-box-number">{{ $totalDeportistas }} deportistas</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-6">
                        <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Bs. {{ $ingresoHoy }}</h3>
                            <p>Ingresos del dia</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Bs. {{ $ingresoSemana }}</h3>
                            <p>Ingresos de la semana</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>Bs. {{ $ingresoMes }}</h3>
                            <p>Ingresos del mes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-outline card-navy">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-money-bill-wave"></i> <b>Ingresos mensuales</b></h3>
                            </div>
                            <div class="card-body">
                                <canvas id="ingresosMensuales" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-outline card-navy">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-futbol"></i> <b>Reservas por espacios</b></h3>
                            </div>
                            <div class="card-body">
                                <canvas id="reservasEspacios" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-3">
                <h3 id="reloj-hora" class="text-center font-weight-bold"></h3>
                <h6 id="reloj-fecha" class="text-center"></h6>
                <div class="card card-outline card-navy">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-calendar-alt"></i> <b>Calendario</b></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12 d-flex justify-content-center">
                                <div id="calendar" style="margin-top: -20px"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .info-box {
        border-radius: 8px;
        overflow: hidden;
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .info-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 18px rgba(0,122,255,0.25);
    }
    .bg-custom {
        background-color: #1F2A50;
        color: white;
        border-radius: 0 8px 8px 0;
        padding: 15px 12px;
    }
    .info-box-number {
        color: #2DD4FF;
        font-weight: bold;
    }
</style>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendar = new VanillaCalendar('#calendar', {
            type: 'default',
            settings: {
                lang: 'es',
                visibility:{
                    theme: 'light'
                }
            },
            locale:{
                months:[
                    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                weekday: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb']
            },
            actions:{
                clickDay(event, self){
                    console.log('Fecha seleccionada: ', self.selectedDates[0]);
                }
            }
        });
        calendar.HTMLElement.style.width = '80%';
        calendar.HTMLElement.style.maxWidth = '80%';
        calendar.init();
    });
</script>

<script>
    function actualizarReloj() {
        const d = new Date();
        const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        
        const diaSemana = dias[d.getDay()];
        const dia = d.getDate();
        const mes = meses[d.getMonth()];
        const anio = d.getFullYear();
        
        let h = d.getHours();
        let m = d.getMinutes();
        let s = d.getSeconds();

        // Convertir a formato de 12 horas y determinar AM/PM
        let meridiano = h >= 12 ? 'PM' : 'AM';
        h = h % 12;
        h = h ? h : 12; // La hora '0' debe ser '12'
        
        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        
        document.getElementById('reloj-fecha').innerHTML = `${diaSemana}, ${dia} de ${mes} de ${anio}`;
        document.getElementById('reloj-hora').innerHTML = `${h}:${m}:${s} ${meridiano}`;
    }
    
    setInterval(actualizarReloj, 1000);
    actualizarReloj();
</script>

<script>
const ingresosData =  @json($datosMensuales);
var ctx1 = document.getElementById("ingresosMensuales").getContext('2d');
var ingresosMensuales = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        datasets: [{
            label: 'Ingresos (Bs)',
            data: ingresosData,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

<script>
const labels = @json($labels);
const data = @json($datos);
var ctx2 = document.getElementById("reservasEspacios").getContext('2d');
var reservasEspacios = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            label: 'Reservas por espacio deportivo',
            data: data,
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)'
            ],
            borderColor: [
                'rgba(255, 255, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        legend:{
            position: 'top',
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.labels[tooltipItem.index];
                    var value = data.datasets[0].data[tooltipItem.index];
                    return label + ': ' + value + ' reservas';
                }
            }
        }
    }
});
</script>
@stop