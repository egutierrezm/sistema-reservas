@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Registrar pago para la reserva #{{ $reserva->id }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/pago') }}">Listado de pagos</a></li>
            </ol>
        </div>
    </div>
</div>
<hr>
@stop

@section('content')
@php
    $totalPagado = $reserva->pagos->sum('monto');
    $precioTotal = $reserva->cancha->precioxhora;
    $saldo = $precioTotal - $totalPagado;
@endphp

<div class="row">
    <div class="col-md-10">
        {{-- Card principal --}}
        <div class="card shadow-sm border-navy">
            <div class="card-header bg-navy text-white">
                <h3 class="card-title mb-0"><i class="fas fa-money-check-alt"></i> Registrar pago</h3>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    {{-- Mini-card: Detalle de la reserva --}}
                    <div class="col-md-6">
                        <div class="card border-primary h-100 shadow-sm">
                            <div class="card-header bg-primary text-white text-center">
                                <h5 class="mb-0"><i class="fas fa-receipt"></i> Detalle de la Reserva</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-sm mb-0">
                                    <tr>
                                        <th>Reservado por:</th>
                                        <td>{{ $reserva->deportista->user->apellidos }} {{ $reserva->deportista->user->nombres }}</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha reserva:</th>
                                        <td>{{ \Carbon\Carbon::parse($reserva->fechaReserva)->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Hora:</th>
                                        <td>{{ \Carbon\Carbon::parse($reserva->horaInicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($reserva->horaFin)->format('H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cancha:</th>
                                        <td>{{ $reserva->cancha->nombre ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Precio total:</th>
                                        <td>Bs. {{ $precioTotal }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total pagado:</th>
                                        <td>Bs. {{ $totalPagado }}</td>
                                    </tr>
                                    @if ($saldo > 0)
                                        <tr>
                                            <th>Saldo pendiente:</th>
                                            <td><strong class="text-danger">Bs. {{ $saldo }}</strong></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <th>Estado:</th>
                                            <td><strong class="text-success">Reserva totalmente pagada</strong></td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Mini-card: Formulario de pago --}}
                    <div class="col-md-6">
                        <div class="card border-success h-100 shadow-sm">
                            <div class="card-header bg-success text-white text-center">
                                <h5 class="mb-0"><i class="fas fa-money-check-alt"></i> Formulario de Pago</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.pago.store', $reserva->id) }}" method="POST">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label for="monto">Monto del pago (Bs)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                            <input type="number" step="0.01" min="0.01" name="monto" id="monto" class="form-control"
                                                value="{{ old('monto') }}" placeholder="Ingrese el monto"
                                                {{ $saldo <= 0 ? 'disabled' : 'required' }}>
                                        </div>
                                        @error('monto')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="metodo">Método de pago</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                            <select name="metodo" id="metodo" class="form-control"
                                                {{ $saldo <= 0 ? 'disabled' : 'required' }}>
                                                <option value="">Seleccione una opción</option>
                                                <option value="Efectivo" {{ old('metodo') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                                                <option value="Transferencia" {{ old('metodo') == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                                                <option value="Tarjeta" {{ old('metodo') == 'Tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                                            </select>
                                        </div>
                                        @error('metodo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="fechaPago">Fecha de pago</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="date" name="fechaPago" id="fechaPago" class="form-control"
                                                value="{{ old('fechaPago', date('Y-m-d')) }}"
                                                {{ $saldo <= 0 ? 'disabled' : 'required' }}>
                                        </div>
                                        @error('fechaPago')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <hr>
                                    <div class="text-end">
                                        <a href="{{ route('admin.reserva.index', $reserva->id) }}" class="btn btn-outline-secondary me-2">
                                            <i class="fas fa-arrow-left"></i> Regresar
                                        </a>

                                        @if ($saldo > 0)
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Guardar pago
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-success" disabled>
                                                <i class="fas fa-check-circle"></i> Pago completo
                                            </button>
                                        @endif
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div> {{-- row g-3 --}}
            </div> {{-- card-body --}}
        </div> {{-- card principal --}}
    </div>
</div>
@stop

@section('css')
<style>
    .input-group-text i {
        color: navy;
    }
    th {
        font-weight: 600;
    }
    .card.shadow-sm {
        border-radius: 8px;
    }
</style>
@stop

@section('js')
<script>
    console.log("Vista de registro de pagos cargada correctamente");
</script>
@stop
