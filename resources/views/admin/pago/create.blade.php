@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Registrar pago para la reserva:{{ $reserva->cancha->nombre }}</h1>
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

<div class="row justify-content-center g-3">
    <div class="col-lg-5 col-md-6 mb-3">
        <div class="card border-light h-100 shadow bg-dark">
            <div class="card-header text-white text-center">
                <h5 class="mb-0"><i class="fas fa-receipt"></i> Detalle de la Reserva</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-5 text-light"><i class="fas fa-user text-info mr-1"></i>Reservado por:</dt>
                    <dd class="col-sm-7 text-white">{{ $reserva->deportista->user->apellidos }} {{ $reserva->deportista->user->nombres }}</dd>

                    <dt class="col-sm-5 text-light"><i class="fas fa-calendar text-info mr-1"></i>Fecha reserva:</dt>
                    <dd class="col-sm-7 text-white">{{ \Carbon\Carbon::parse($reserva->fechaReserva)->format('d/m/Y') }}</dd>

                    <dt class="col-sm-5 text-light"><i class="fas fa-clock text-info mr-1"></i>Hora:</dt>
                    <dd class="col-sm-7 text-white">{{ \Carbon\Carbon::parse($reserva->horaInicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($reserva->horaFin)->format('H:i') }}</dd>

                    <dt class="col-sm-5 text-light"><i class="fas fa-futbol text-info mr-1"></i>Cancha:</dt>
                    <dd class="col-sm-7 text-white">{{ $reserva->cancha->nombre ?? 'N/A' }}</dd>

                    <dt class="col-sm-5 text-light"><i class="fas fa-money-bill-wave text-info mr-1"></i>Precio total:</dt>
                    <dd class="col-sm-7 text-white">Bs. {{ $precioTotal }}</dd>

                    <dt class="col-sm-5 text-light"><i class="fas fa-money-check text-info mr-1"></i>Total pagado:</dt>
                    <dd class="col-sm-7 text-white">Bs. {{ $totalPagado }}</dd>

                    @if ($saldo > 0)
                        <dt class="col-sm-5 text-light"><i class="fas fa-exclamation-triangle text-warning mr-1"></i>Saldo pendiente:</dt>
                        <dd class="col-sm-7"><strong class="text-warning">Bs. {{ $saldo }}</strong></dd>
                    @else
                        <dt class="col-sm-5 text-light"><i class="fas fa-check-circle text-success mr-1"></i>Estado:</dt>
                        <dd class="col-sm-7"><strong class="text-success">Reserva totalmente pagada</strong></dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    <div class="col-lg-5 col-md-6 mb-3">
        <div class="card border-light h-100 shadow bg-dark">
            <div class="card-header card-outline bg-success text-white text-center">
                <h5 class="mb-0"><i class="fas fa-money-check-alt"></i> Formulario de Pago</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pago.store', $reserva->id) }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="monto" class="text-white">Monto del pago (Bs)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-money-bill-wave text-dark"></i></span>
                            <input type="number" step="0.01" min="0.01" name="monto" id="monto" class="form-control"
                                value="{{ old('monto') }}" placeholder="Ingrese el monto"
                                {{ $saldo <= 0 ? 'disabled' : 'required' }}
                                data-saldo="{{ $saldo }}">
                            <small id="errorMonto" class="text-warning d-none"></small>
                        </div>
                        @error('monto')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="metodo" class="text-white">Método de pago</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-credit-card text-dark"></i></span>
                            <select name="metodo" id="metodo" class="form-control"
                                {{ $saldo <= 0 ? 'disabled' : 'required' }}>
                                <option value="">Seleccione una opción</option>
                                {{-- <option value="Efectivo" {{ old('metodo') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option> --}}
                                <option value="Transferencia" {{ old('metodo') == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                                <option value="Tarjeta" {{ old('metodo') == 'Tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                                @if(!auth()->user()->getRoleNames()->contains('DEPORTISTA'))
                                    <option value="Efectivo" {{ old('metodo') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                                @endif
                            </select>
                            <small id="mensajeEfectivo" class="text-warning d-none">
                                El pago en efectivo debe realizarse personalmente en la cancha.
                            </small>
                        </div>
                        @error('metodo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="fechaPago" class="text-white">Fecha de pago</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-dark"></i></span>
                            <input type="date" name="fechaPago" id="fechaPago" class="form-control"
                                value="{{ old('fechaPago', date('Y-m-d')) }}"
                                {{ $saldo <= 0 ? 'disabled' : 'required' }}>
                        </div>
                        @error('fechaPago')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <hr class="bg-light">
                    <div class="text-end">
                        <a href="{{ route('admin.reserva.index', $reserva->id) }}" class="btn btn-light me-2">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </a>

                        @if ($saldo > 0)
                            <button type="submit" class="btn btn-success">
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
</div>

{{-- Modal simulador de pago --}}
<div class="modal fade" id="modalTarjeta" tabindex="-1" aria-labelledby="modalTarjetaLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTarjetaLabel">
          <i class="fas fa-spinner fa-spin me-2"></i> Procesando pago...
        </h5>
      </div>
      <div class="modal-body text-center">
        <div class="progress mb-2">
          <div id="barraProgreso" class="progress-bar progress-bar-striped progress-bar-animated bg-info" 
               role="progressbar" style="width: 0%"></div>
        </div>
        <div id="mensajeProceso" class="mb-2"><i class="fas fa-info-circle me-1"></i> Iniciando transacción...</div>
        <div id="mensajeFinal" class="d-none">
          <i class="fas fa-check-circle text-success me-1"></i> ¡Tarjeta procesada!
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('css')
<style>
    /* .input-group-text i {
        color: navy;
    } */
    /* th {
        font-weight: 600;
    }
    .card.shadow-sm {
        border-radius: 8px;
    } */
</style>
@stop

@section('js')

<script>
console.log("Vista de registro de pagos cargada correctamente");

document.addEventListener('DOMContentLoaded', function() {
    const inputMonto = document.getElementById('monto');
    const errorMonto = document.getElementById('errorMonto');
    const saldo = parseFloat(inputMonto.dataset.saldo);

    const form = inputMonto.closest('form');
    const submitBtn = form.querySelector('button[type="submit"]');

    inputMonto.addEventListener('input', function() {
        const valor = parseFloat(this.value);

        if (valor > saldo) {
            errorMonto.textContent = `El monto no puede ser mayor al saldo pendiente (Bs. ${saldo.toFixed(2)}).`;
            errorMonto.classList.remove('d-none');
            this.classList.add('is-invalid');
            submitBtn.disabled = true;
        } else {
            errorMonto.textContent = '';
            errorMonto.classList.add('d-none');
            this.classList.remove('is-invalid');
            submitBtn.disabled = false;
        }
    });

    form.addEventListener('submit', function(e) {
        const valor = parseFloat(inputMonto.value);
        if (valor > saldo) {
            e.preventDefault();
            inputMonto.focus();
            alert(`El monto ingresado no puede ser mayor al saldo pendiente (Bs. ${saldo.toFixed(2)}).`);
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const metodoPago = document.getElementById('metodo');
    const mensajeEfectivo = document.getElementById('mensajeEfectivo');
    const saldo = parseFloat(document.getElementById('monto').dataset.saldo);
    const esDeportista = @json(auth()->user()->getRoleNames()->contains('DEPORTISTA'));

    metodoPago.addEventListener('change', function() {
        if (this.value === 'Efectivo' && esDeportista) {
            mensajeEfectivo.textContent = 'Debe pasar a pagar personalmente el efectivo en la cancha.';
            mensajeEfectivo.classList.remove('d-none');
        } else {
            mensajeEfectivo.textContent = '';
            mensajeEfectivo.classList.add('d-none');
        }
    });
});

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const metodoSelect = document.getElementById('metodo');
    const form = metodoSelect.closest('form');
    const modalTarjeta = new bootstrap.Modal(document.getElementById('modalTarjeta'));
    const barraProgreso = document.getElementById('barraProgreso');
    const mensajeFinal = document.getElementById('mensajeFinal');
    const mensajeProceso = document.getElementById('mensajeProceso');
    const mensajes = [
        "<i class='fas fa-lock me-1'></i> Verificando seguridad",
        "<i class='fas fa-credit-card me-1'></i> Autorizando tarjeta",
        "<i class='fas fa-university me-1'></i> Conectando con el banco",
        "<i class='fas fa-file-alt me-1'></i> Validando datos",
        "<i class='fas fa-cogs me-1'></i> Procesando pago"
    ];
    form.addEventListener('submit', function(e) {
        if(metodoSelect.value === 'Tarjeta') {
            e.preventDefault();
            barraProgreso.style.width = '0%';
            mensajeFinal.classList.add('d-none');
            mensajeProceso.innerHTML = "<i class='fas fa-info-circle me-1'></i> Iniciando transacción...";
            modalTarjeta.show();

            let progreso = 0;
            let mensajeIndex = 0;
            const intervalo = setInterval(() => {
                progreso += 5;
                barraProgreso.style.width = progreso + '%';
                if(progreso % 20 === 0 && mensajeIndex < mensajes.length) {
                    mensajeProceso.innerHTML = mensajes[mensajeIndex];
                    mensajeIndex++;
                }
                if(progreso >= 100){
                    clearInterval(intervalo);
                    mensajeProceso.classList.add('d-none');
                    mensajeFinal.classList.remove('d-none');
                    setTimeout(() => form.submit(), 1000);
                }
            }, 450);
        }
    });
});
</script>
@stop
