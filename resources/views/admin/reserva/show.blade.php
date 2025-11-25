@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Detalles de la Reserva</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.reserva.index') }}">Listado de reservas</a></li>
            </ol>
        </div>
    </div>
</div>
<hr>
@stop

@section('content')
<div class="row d-flex align-items-stretch">
    <div class="col-md-8 d-flex flex-column">
        <!-- Card de Pagos -->
        <div class="card card-outline card-success bg-dark flex-fill mb-4 shadow"> 
            <div class="card-header d-flex align-items-center text-white">
                <h3 class="card-title mb-0"><i class="fas fa-credit-card mr-1"></i> Pagos Realizados</h3>
                <div class="ml-auto">
                    <a href="{{ route('admin.pago.create', $reserva->id) }}" class="btn btn-success btn-sm" style="width: 150px;">
                        <i class="fas fa-plus"></i> Realizar Pago
                    </a>
                </div>
            </div>
            <div class="card-body text-white">
                @if($reserva->pagos->count() > 0)
                    <table class="table table-dark table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Método</th>
                                <th>Monto (Bs)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reserva->pagos as $pago)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($pago->fechaPago)->format('d/m/Y') }}</td>
                                    <td>{{ $pago->metodo }}</td>
                                    <td>{{ number_format($pago->monto, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr class="bg-light">
                    <dl class="row mt-2">
                        <dt class="col-sm-4 text-light">Total Pagado</dt>
                        <dd class="col-sm-8 text-white">{{ number_format($reserva->pagos->sum('monto'), 2) }} Bs</dd>
                        <dt class="col-sm-4 text-light">Monto total a cancelar</dt>
                        <dd class="col-sm-8 text-white">{{ number_format($reserva->cancha->precioxhora, 2) }} Bs</dd>
                        <dt class="col-sm-4 text-light">Pendiente</dt>
                        <dd class="col-sm-8 text-white">{{ number_format($reserva->cancha->precioxhora - $reserva->pagos->sum('monto'), 2) }} Bs</dd>
                    </dl>
                @else
                    <p class="text-light mb-0">No se han registrado pagos aún.</p>
                @endif
            </div>
        </div>

        <!-- Card de Participantes -->
        <div class="card card-outline card-success bg-dark flex-fill shadow">
            <div class="card-header d-flex justify-content-between align-items-center text-white">
                <h3 class="card-title"><i class="fas fa-users mr-1"></i> Participantes</h3>
            </div>
            <div class="card-body text-white">
                @if($reserva->participantes->count() > 0)
                    <table class="table table-dark table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>Nombre y Apellido</th>
                                <th>Correo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reserva->participantes as $participante)
                                <tr>
                                    <td>{{ $participante->user->nombres }} {{ $participante->user->apellidos }}</td>
                                    <td>{{ $participante->user->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-light mb-0">No hay participantes registrados.</p>
                @endif
            </div>
        </div>

    </div>

    <!-- Columna Derecha: Información de la Cancha -->
    <div class="col-md-4 d-flex flex-column">
        <div class="card card-success card-outline bg-dark flex-fill">
            <div class="card-body box-profile text-center text-white">
                @if($reserva->cancha->imgcancha)
                    <img class="img-fluid rounded mb-2"
                        src="{{ asset('storage/' . $reserva->cancha->imgcancha) }}"
                        alt="Imagen de la cancha {{ $reserva->cancha->nombre }}">
                @else
                    <img class="img-fluid rounded mb-2"
                        src="https://img.icons8.com/officel/80/hockey-field.png"
                        alt="Imagen genérica de cancha">
                @endif
                <p class="text-muted text-light">
                    @if($reserva->cancha->espacioDeportivo)
                        <span class="badge badge-light">{{ $reserva->cancha->espacioDeportivo->nombre }}</span>
                    @endif
                </p>
                <h3 class="mt-2 text-white">{{ $reserva->cancha->nombre }}</h3>
                <p>
                    @foreach($reserva->cancha->disciplinaDeportivas as $disciplina)
                        <span class="badge badge-light">{{ $disciplina->nombre }}</span>
                    @endforeach
                </p>
                <hr class="bg-light">
                <strong><i class="fas fa-user fa-fw mr-1 text-info"></i> Reservado por</strong>
                <p class="text-light">{{ $reserva->deportista->user->nombres }} {{ $reserva->deportista->user->apellidos }}</p>
                
                <strong><i class="fas fa-calendar-alt fa-fw mr-1 text-info"></i> Fecha de la Reserva</strong>
                <p class="text-light">{{ $reserva->fechaReserva }}</p>

                <strong><i class="fas fa-clock fa-fw mr-1 text-info"></i> Horario</strong>
                <p class="text-light">{{ \Carbon\Carbon::parse($reserva->horaInicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($reserva->horaFin)->format('H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .badge { font-size: 0.9em; }
    .icon-color { color: navy; }
    .flex-fill { display: flex; flex-direction: column; }
    
</style>
@stop

@section('js')
<script> console.log("Mostrando información de la reserva"); </script>
@stop
