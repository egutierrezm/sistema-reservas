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

<div class="mb-2">
    <h2 class="mb-4">{{ $espacio->nombre }}</h2>
    <div class="row">
        @forelse($espacio->canchas as $cancha)
        <div class="col-md-3 mb-4">
            <div class="card bg-dark text-white h-100 shadow">
                @if($cancha->imgcancha)
                <img src="{{ asset('storage/' . $cancha->imgcancha) }}" class="card-img-top" alt="{{ $cancha->nombre }}" style="height: 150px; object-fit: cover;">
                @else
                <img src="{{ asset('images/default_cancha.png') }}" class="card-img-top" alt="Sin imagen" style="height: 150px; object-fit: cover;">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $cancha->nombre }}</h5>
                    <p class="card-text">
                        <strong>Disciplinas:</strong>
                        @forelse($cancha->disciplinaDeportivas as $disciplina)
                            <span class="badge badge-info">{{ $disciplina->nombre }}</span>
                        @empty
                            <span class="text-muted">Sin disciplinas registradas</span>
                        @endforelse
                    </p>
                    <ul class="list-unstyled small mb-3">
                        <li><i class="fas fa-users"></i> <strong> Capacidad:</strong> {{ $cancha->capacidad }} personas</li>
                        <li><i class="fas fa-money-bill-wave"></i> <strong> Precio/Hora:</strong> Bs. {{ $cancha->precioxhora }}</li>
                    </ul>
                    @php
                        $promedio = $cancha->valoraciones->avg('puntos') ?? 0;
                        $entero = floor($promedio);
                        $decimal = $promedio - $entero;
                        $cantDeportistas = $cancha->valoraciones->count();
                    @endphp

                    <div class="mb-2 text-center">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $entero)
                                <i class="fas fa-star text-warning"></i>
                            @elseif ($i == $entero + 1 && $decimal >= 0.25)
                                <i class="fas fa-star-half-alt text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor

                        <span class="ml-2">({{ $cantDeportistas }})</span>
                    </div>

                    <button class="btn btn-success mt-auto" data-toggle="modal" data-target="#reservaModal" data-cancha="{{ $cancha->id }}" data-nombre="{{ $cancha->nombre }}">
                        <i class="fas fa-calendar-plus"></i> Reservar
                    </button>
                    <button class="btn btn-info mt-auto ver-comentarios" data-cancha="{{ $cancha->id }}">
                        <i class="fas fa-comments"></i> Ver comentarios
                    </button>
                    <button class="btn btn-warning mt-auto valorar-comentario" data-cancha="{{ $cancha->id }}">
                        <i class="fas fa-star-half-alt"></i> Valorar y Comentar
                    </button>

                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p>No hay canchas disponibles en este espacio deportivo.</p>
        </div>
        @endforelse
    </div>
</div>
<div class="mb-3">
    <a href="{{ url()->previous() }}" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i> Ver espacios deportivos
    </a>
</div>

{{-- Modal de Reserva --}}
<div class="modal fade" id="reservaModal" tabindex="-1" role="dialog" aria-labelledby="reservaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form id="reservaForm" method="POST" action="{{ route('admin.reserva.store') }}">
            @csrf
            <input type="hidden" name="cancha_id" id="modalCanchaId">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="reservaModalLabel">Reservar Cancha</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="modalUsuarioNombre">Reservado por: {{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}</p>
                    <p id="modalCanchaNombre"></p>
                    <div class="form-group">
                        <label for="fechaReserva">Fecha:</label>
                        <input type="date" name="fechaReserva" id="fechaReserva" class="form-control" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="horaInicio">Hora Inicio:</label>
                            <input type="time" name="horaInicio" id="horaInicio" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="horaFin">Hora Fin:</label>
                            <input type="time" name="horaFin" id="horaFin" class="form-control" required>
                        </div>
                    </div>
                    <input type="hidden" name="deportista_id" value="{{ auth()->user()->deportista->id }}">
                    <input type="hidden" name="estado" value="Pendiente">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Reservar</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- Modal comentarios --}}
<div class="modal fade" id="comentariosModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Comentarios</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body direct-chat-messages" id="comentarios-body" style="max-height:500px; overflow-y:auto;">
                <p>Cargando comentarios...</p>
            </div>
        </div>
    </div>
</div>
{{-- Modal calificar y comentar --}}
<div class="modal fade" id="crearValoracionModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="crearValoracionForm" method="POST">
            @csrf
            <div class="modal-content bg-dark text-white">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Valorar y Comentar Cancha</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Deportista: {{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}</p>
                    <input type="hidden" name="cancha_id" id="modalCrearCanchaId">
                    <input type="hidden" name="deportista_id" id="modalCrearDeportistaId" value="{{ auth()->user()->deportista->id }}">
                    <div class="form-group">
                        <label for="puntos">Puntos:</label>
                        <select name="puntos" id="modalCrearPuntos" class="form-control" style="color: black;" required>
                            <option value="">Selecciona</option>
                            @for($i=1;$i<=5;$i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="comentario">Comentario:</label>
                        <textarea name="comentario" id="modalCrearComentario" class="form-control" rows="3" style="color: black;" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Enviar Valoración</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="editarValoracionModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editarValoracionForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content bg-dark text-white">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Editar Valoración</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Deportista: {{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}</p>
                    <div class="form-group">
                        <label for="puntos">Puntos:</label>
                        <select name="puntos" id="modalEditarPuntos" class="form-control" style="color: black;" required>
                            <option value="">Selecciona</option>
                            @for($i=1;$i<=5;$i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="comentario">Comentario:</label>
                        <textarea name="comentario" id="modalEditarComentario" class="form-control" rows="3" style="color: black;" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Actualizar Valoración</button>
                </div>
            </div>
        </form>
    </div>
</div>

@stop

@section('css')
<style>
    .card-title {
        font-weight: bold;
        font-size: 1.2rem;
    }
    .card-text, p {
        font-size: 0.9rem;
    }
    .btn-success {
        background-color: #28a745;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-success:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        cursor: pointer;
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease;
        border: 2px solid transparent;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        border: 2px solid #28a745;
        cursor: pointer;
    }
</style>
@stop

@section('js')
<script>
    $('#reservaModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var canchaId = button.data('cancha')
        var canchaNombre = button.data('nombre')
        var modal = $(this)
        modal.find('#modalCanchaId').val(canchaId)
        modal.find('#modalCanchaNombre').text('Cancha: ' + canchaNombre)
    })

    //horarios disponibles de la cancha
    $('#reservaModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var canchaId = button.data('cancha')
        var canchaNombre = button.data('nombre')
        var modal = $(this)
        modal.find('#modalCanchaId').val(canchaId)
        modal.find('#modalCanchaNombre').text('Cancha: ' + canchaNombre)

        // Limpiar campos y horarios previos
        modal.find('#fechaReserva').val('')
        modal.find('#horaInicio').val('')
        modal.find('#horaFin').val('')
        $('#horariosDisponibles').remove()
    });

    // Crear contenedor para horarios disponibles
    $('#fechaReserva').on('change', function () {
        var modal = $('#reservaModal')
        var canchaId = modal.find('#modalCanchaId').val()
        var fecha = $(this).val()
        if (!canchaId || !fecha) return;
        $.ajax({
            url: '{{ route("admin.reserva.disponibilidad") }}',
            method: 'GET',
            data: { cancha_id: canchaId, fecha: fecha },
            success: function(bloques) {
                // Eliminamos grilla previa
                $('#horariosDisponibles').remove();

                // Creamos el contenedor
                var container = $('<div id="horariosDisponibles" class="mt-3 d-flex justify-content-center flex-column align-items-center"><h5>Horarios Disponibles:</h5></div>');
                var grid = $('<div class="d-flex flex-wrap justify-content-center"></div>');
                container.append(grid);
                $('#reservaModal .modal-body').append(container);

                if (bloques.length === 0) {
                    grid.append('<p class="text-muted">No hay horarios disponibles para esta fecha.</p>');
                    return;
                }
                bloques.forEach(function(b) {
                    var btn = $('<button type="button" class="btn btn-sm m-1"></button>')
                        .text(b.inicio + ' - ' + b.fin)
                        .prop('disabled', b.ocupado)
                        .addClass(b.ocupado ? 'btn-danger' : 'btn-success');

                    if (!b.ocupado) {
                        btn.on('click', function () {
                            $('#horaInicio').val(b.inicio)
                            $('#horaFin').val(b.fin)

                            // Resaltamos bloque seleccionado
                            $('#horariosDisponibles button').removeClass('btn-primary').addClass('btn-success');
                            $(this).removeClass('btn-success').addClass('btn-primary');
                        });
                    }
                    grid.append(btn);
                });
            },
            error: function() {
                alert('Error al consultar la disponibilidad de horarios.');
            }
        });
    });
</script>

<script>
    $('.ver-comentarios').click(function() {
        var canchaId = $(this).data('cancha');
        $('#comentarios-body').html('<p>Cargando comentarios...</p>');
        $('#comentariosModal').modal('show');

        $.get('/admin/valoracion/comentariosPorCancha/' + canchaId, function(data) {
            $('#comentarios-body').html(data);
        });
    });
</script>

<script>
$('.valorar-comentario').click(function() {
    var canchaId = $(this).data('cancha');

    // GET para saber si ya hay valoración del deportista
    $.get('/admin/valoracion/getValoracionPorCancha/' + canchaId, function(data) {
        var valoracion = data.valoracion;

        if (valoracion) {
            // Existe → abrir modal de editar
            $('#modalEditarPuntos').val(valoracion.puntos);
            $('#modalEditarComentario').val(valoracion.comentario);
            $('#editarValoracionForm').attr('action', '/admin/valoracion/update/' + valoracion.id);
            $('#editarValoracionModal').modal('show');
        } else {
            // No existe → abrir modal de crear
            $('#modalCrearCanchaId').val(canchaId);
            $('#modalCrearDeportistaId').val({{ auth()->user()->deportista->id }});
            $('#modalCrearPuntos').val('');
            $('#modalCrearComentario').val('');
            $('#crearValoracionForm').attr('action', '/admin/valoracion/store');
            $('#crearValoracionModal').modal('show');
        }
    });
});

</script>

<script>
// Crear Valoración
$('#crearValoracionForm').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: form.serialize(),
        success: function(res) {
            alert(res.mensaje);
            $('#crearValoracionModal').modal('hide');
        },
        error: function(err) {
            alert('Error al guardar la valoración.');
        }
    });
});
// Editar Valoración
$('#editarValoracionForm').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: form.serialize(),
        success: function(res) {
            alert(res.mensaje);
            $('#editarValoracionModal').modal('hide');
        },
        error: function(err) {
            alert('Error al actualizar la valoración.');
        }
    });
});
</script>

@stop
