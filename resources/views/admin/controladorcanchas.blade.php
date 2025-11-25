@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"><b>Bienvenido: </b>{{ Auth::user()->nombres }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href=""><b>Rol: {{ Auth::user()->roles->pluck('name')->implode(', ') }} </b></a> </li>
            </ol>
        </div>
    </div>
</div>
<hr>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Contenedor izquierdo --}}
        <div class="col-md-8">
            <div class="row">
                {{-- Estadísticas rápidas --}}
                <div class="col-md-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $reservas->count() }}</h3>
                            <p>Reservas el día de hoy</p>
                        </div>
                        <div class="icon"><i class="fas fa-calendar-check"></i></div>
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $reservas->sum(fn($r) => $r->participantes->count()) }}</h3>
                            <p>Participantes totales</p>
                        </div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $reservas->sum(fn($r) => $r->participantes->where('pivot.ingreso',1)->count()) }}</h3>
                            <p>Ingresos registrados</p>
                        </div>
                        <div class="icon"><i class="fas fa-user-check"></i></div>
                    </div>
                </div>
            </div>

            {{-- Filtro por reserva --}}
            <div class="row mb-3">
                <div class="col-6">
                    <select id="filtroReserva" class="form-control">
                        <option value="todas">Todas las reservas</option>
                        @foreach($reservas as $reserva)
                            <option value="reserva-{{ $reserva->id }}">
                                {{ $reserva->cancha->nombre }} - {{ $reserva->disciplina->nombre }}
                                ({{ \Carbon\Carbon::parse($reserva->horaInicio)->format('H:i') }} -
                                 {{ \Carbon\Carbon::parse($reserva->horaFin)->format('H:i') }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Reservas y participantes --}}
            <div class="row">
                @forelse($reservas as $reserva)
                <div class="reserva-card col-12 mb-3" id="reserva-{{ $reserva->id }}">
                    <div class="card card-outline card-success bg-dark shadow">
                        <div class="card-header text-white">
                            <h5>
                                {{ $reserva->cancha->nombre }} - {{ $reserva->disciplina->nombre }}
                                ({{ \Carbon\Carbon::parse($reserva->horaInicio)->format('H:i') }} -
                                 {{ \Carbon\Carbon::parse($reserva->horaFin)->format('H:i') }})
                            </h5>
                            <div>
                                @if($reserva->estaPagada())
                                    <span class="badge badge-success">Reserva Pagada</span>
                                @else
                                    <a href="{{ route('admin.pago.create', $reserva->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-money-bill-wave"></i> Reserva pendiente de pago
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body text-white">
                            <table class="table table-dark table-bordered table-striped">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Participante</th>
                                        <th>Ingreso</th>
                                        <th>QR Acceso</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reserva->participantes as $part)
                                    <tr>
                                        <td>{{ $part->user->nombres }} {{ $part->user->apellidos }}</td>
                                        <td>
                                            @if($part->pivot->ingreso)
                                                <span class="badge badge-success">Ingreso</span>
                                            @else
                                                <span class="badge badge-danger">No ingreso</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($part->pivot->qr_image)
                                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#qrModal{{ $part->id }}">
                                                <i class="fas fa-qrcode"></i> Ver QR
                                            </button>
                                            <div class="modal fade" id="qrModal{{ $part->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-sm modal-dialog-centered">
                                                    <div class="modal-content bg-dark text-white">
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">QR de Ingreso</h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('storage/' . $part->pivot->qr_image) }}" class="img-fluid">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$part->pivot->ingreso)
                                            <form action="" method="POST">
                                                @csrf
                                                <input type="hidden" name="reserva_id" value="{{ $reserva->id }}">
                                                <input type="hidden" name="deportista_id" value="{{ $part->id }}">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-check"></i> Marcar Ingreso
                                                </button>
                                            </form>
                                            @else
                                            <button class="btn btn-sm btn-light" disabled>
                                                <i class="fas fa-lock"></i> Ya ingreso
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @empty
                    <p class="text-white">No hay reservas activas hoy.</p>
                @endforelse
            </div>
        </div>

        {{-- Contenedor derecho: QR --}}
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h4 class="mb-3">Escaneo por Cámara</h4>
                    <div id="qr-reader" style="width:100%;"></div>
                    <hr>
                    <h5 class="mb-2">O pega una imagen con CTRL+V</h5>
                    <p class="text-muted">Puedes copiar una imagen con un QR y pegarla aquí.</p>
                    <div id="paste-area" style="border:2px dashed #6c757d; padding:40px; cursor:pointer;">
                        <span class="text-muted">Haz clic aquí y presiona <b>CTRL+V</b></span>
                    </div>
                    <canvas id="qr-canvas" style="display:none;"></canvas>
                    <br><br>
                    <div id="qr-result" class="alert alert-info d-none">
                        <strong>QR:</strong> <span id="qr-value"></span>
                        <br><br>
                        <form id="register-form" method="POST" style="display:inline-block;">
                            @csrf
                            <input type="hidden" name="reserva_id" id="reserva_id">
                            <input type="hidden" name="deportista_id" id="deportista_id">
                            <button type="submit" class="btn btn-success btn-lg">Registrar Ingreso</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>

<script>
function beep() {
    const ctx = new (window.AudioContext || window.webkitAudioContext)();
    const osc = ctx.createOscillator();
    const gain = ctx.createGain();
    osc.connect(gain);
    gain.connect(ctx.destination);
    osc.frequency.value = 900;
    gain.gain.value = 0.2;
    osc.start();
    setTimeout(() => osc.stop(), 150);
}

function showQRResult(text) {
    const validPrefix = "http://pukara-sports.test/admin/controlAcceso/";
    if (!text.startsWith(validPrefix)) {
        alert("QR no válido para este sistema");
        return;
    }
    beep();
    document.getElementById("qr-value").textContent = text;
    document.getElementById("qr-result").classList.remove("d-none");
    const parts = text.split("/");
    const reservaId = parts[parts.length - 2];
    const deportistaId = parts[parts.length - 1];
    document.getElementById("reserva_id").value = reservaId;
    document.getElementById("deportista_id").value = deportistaId;
    document.getElementById("register-form").action = `/admin/controlAcceso/${reservaId}/${deportistaId}`;
}

function onScanSuccess(decodedText) {
    html5QrcodeScanner.clear();
    showQRResult(decodedText);
}

const html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 }, false);
html5QrcodeScanner.render(onScanSuccess);

// Pegar imagen desde portapapeles
const pasteArea  = document.getElementById("paste-area");
const canvas     = document.getElementById("qr-canvas");
const ctxCanvas  = canvas.getContext("2d");
pasteArea.addEventListener("click", () => pasteArea.focus());
document.addEventListener("paste", async (event) => {
    if (!event.clipboardData) return;
    for (let item of event.clipboardData.items) {
        if (item.type.indexOf("image") === 0) {
            const blob = item.getAsFile();
            const img = new Image();
            img.onload = () => {
                canvas.width = img.width;
                canvas.height = img.height;
                ctxCanvas.drawImage(img, 0, 0);
                const imgData = ctxCanvas.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imgData.data, canvas.width, canvas.height);
                if (code) showQRResult(code.data);
                else alert("La imagen pegada no contiene un QR válido.");
            };
            img.src = URL.createObjectURL(blob);
            break;
        }
    }
});

// Filtro por reserva
document.getElementById('filtroReserva').addEventListener('change', function() {
    const selected = this.value;
    document.querySelectorAll('.reserva-card').forEach(card => {
        card.style.display = (selected === 'todas' || card.id === selected) ? 'block' : 'none';
    });
});
</script>
@stop
