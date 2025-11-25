@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Registrar una Nueva Reserva</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/reserva') }}">Listado de reservas</a></li>
            </ol>
        </div>
    </div>
</div>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Complete los datos de la reserva</h3>
            </div>
            <div class="card-body bg-dark">
                <form action="{{ route('admin.reserva.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- SECCIÓN IZQUIERDA -->
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-6">
                                    {{-- espacios --}}
                                    <div class="form-group">
                                        <label for="espacio_id">Espacio Deportivo</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            </div>
                                            <select name="espacio_id" id="espacio_id" class="form-control" required>
                                                <option value="">Seleccione un espacio</option>
                                                @foreach($espacios as $espacio)
                                                    <option value="{{ $espacio->id }}">{{ $espacio->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('espacio_id')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Canchas -->
                                    <div class="form-group">
                                        <label for="cancha_id">Cancha</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-futbol"></i></span>
                                            </div>
                                            <select name="cancha_id" id="cancha_id" class="form-control" required>
                                                <option value="">Seleccione una cancha</option>
                                            </select>
                                        </div>
                                        @error('cancha_id')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    {{-- disciplinas --}}
                                    <div class="form-group">
                                        <label for="disciplina_id">Disciplina</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-running"></i></span>
                                            </div>
                                            <select name="disciplina_id" id="disciplina_id" class="form-control" required>
                                                <option value="">Seleccione una disciplina</option>
                                            </select>
                                        </div>
                                        @error('disciplina_id')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Fecha de reserva -->
                                    <div class="form-group">
                                        <label for="fechaReserva">Fecha de la Reserva</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                            </div>
                                            <input type="date" class="form-control" name="fechaReserva" id="fechaReserva"
                                                value="{{ old('fechaReserva') }}" required>
                                        </div>
                                        @error('fechaReserva')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Horarios -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="horaInicio">Hora de Inicio</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            </div>
                                            <input type="time" class="form-control" name="horaInicio" id="horaInicio"
                                                value="{{ old('horaInicio') }}" required>
                                        </div>
                                        @error('horaInicio')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="horaFin">Hora de Fin</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            </div>
                                            <input type="time" class="form-control" name="horaFin" id="horaFin"
                                                value="{{ old('horaFin') }}" required>
                                        </div>
                                        @error('horaFin')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Deportista -->
                                    <div class="form-group">
                                        <label for="deportista_id">Reservado por</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <select name="deportista_id" id="deportista_id" class="form-control" required>
                                                <option value="">Seleccione un deportista</option>
                                                @foreach($deportistas as $deportista)
                                                    <option value="{{ $deportista->id }}"
                                                        {{ old('deportista_id') == $deportista->id ? 'selected' : '' }}>
                                                        {{ $deportista->user->nombres }} {{ $deportista->user->apellidos }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('deportista_id')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Estado -->
                                    <div class="form-group">
                                        <label for="estado">Estado de la Reserva</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                            </div>
                                            <select name="estado" id="estado" class="form-control" required>
                                                <option value="">Seleccione un estado</option>
                                                <option value="Pendiente" {{ old('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                <option value="Confirmada" {{ old('estado') == 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                                                <option value="Cancelada" {{ old('estado') == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                                            </select>
                                        </div>
                                        @error('estado')
                                            <small style="color:red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- SECCIÓN DERECHA -->
                        <div class="col-md-5">
                            <!-- Previsualizacion de la cancha -->
                            <div id="previewCancha" class="text-center" style="display:none;">
                                <h5 id="nombreCancha"></h5>
                                <img id="imagenCancha" src="" alt="Imagen de cancha" style="max-width:250px; border-radius:10px;">
                            </div>
                            <!-- Matriz de horarios -->
                            <div id="horariosDisponibles" class="mt-4" style="display:none;">
                                <h5 class="text-center">Disponibilidad de horarios</h5>
                                <div id="bloquesHorario" class="d-flex flex-wrap justify-content-center"></div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <a href="{{ route('admin.reserva.index') }}" class="btn btn-light me-2">
                                <i class="fas fa-arrow-left me-1"></i> Regresar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Guardar Reserva
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .input-group-text i {
        color: navy;
    }
    #bloquesHorario button {
        width: 110px;
        font-weight: 600;
    }
</style>
@stop

@section('js')
<script>
$(function() {
    $('#participantes').select2({
        theme: 'classic',
        placeholder: 'Seleccione participantes',
        allowClear: true,
        width: 'resolve'
    });
    $('#deportista_id').on('change', function() {
        var selectedId = $(this).val();
        $('#participantes option').prop('disabled', false);
        if (selectedId) {
            $('#participantes option[value="' + selectedId + '"]').prop('disabled', true);
            var selectedParticipants = $('#participantes').val() || [];
            var index = selectedParticipants.indexOf(selectedId);
            if (index > -1) {
                selectedParticipants.splice(index, 1);
                $('#participantes').val(selectedParticipants).trigger('change');
            }
        }
        $('#participantes').select2({
            theme: 'classic',
            placeholder: 'Seleccione uno o varios participantes',
            allowClear: true,
            width: 'resolve'
        });
    });
    $('#deportista_id').trigger('change');
});


$(function () {
    const canchas = @json($canchas);
    // Cambia la cancha
    $('#cancha_id').on('change', function () {
        const id = $(this).val();
        const cancha = canchas.find(c => c.id == id);
        if (cancha) {
            // Mostrar disciplinas
            const disciplinas = cancha.disciplina_deportivas.map(d => d.nombre).join(', ');
            $('#disciplinasCancha').text('Disciplinas: ' + disciplinas);
            // Previsualizacion si tiene imagen
            if (cancha.imgcancha) {
                $('#previewCancha').show();
                $('#nombreCancha').text(cancha.nombre);
                $('#imagenCancha').attr('src', '/storage/' + cancha.imgcancha);
            } else {
                $('#previewCancha').hide();
            }
        } else {
            $('#disciplinasCancha').text('');
            $('#previewCancha').hide();
        }

        if ($('#fechaReserva').val()) {
            cargarHorariosDisponibles();
        }
    });

    // Cambia la fecha
    $('#fechaReserva').on('change', function () {
        if ($('#cancha_id').val()) {
            cargarHorariosDisponibles();
        }
    });

    function cargarHorariosDisponibles() {
        const fecha = $('#fechaReserva').val();
        const cancha_id = $('#cancha_id').val();
        if (!fecha || !cancha_id) return;

        $.ajax({
            url: '{{ route('admin.reserva.disponibilidad') }}',
            method: 'GET',
            data: { fecha, cancha_id },
            success: function(bloques) {
                $('#horariosDisponibles').show();
                const contenedor = $('#bloquesHorario');
                contenedor.empty();

                if (bloques.length === 0) {
                    contenedor.append('<p class="text-muted">No hay horarios configurados para este día.</p>');
                    return;
                }

                bloques.forEach(b => {
                    const boton = $('<button>')
                        .attr('type', 'button')
                        .addClass('btn btn-sm m-1')
                        .text(`${b.inicio} - ${b.fin}`)
                        .prop('disabled', b.ocupado)
                        .addClass(b.ocupado ? 'btn-danger' : 'btn-success');

                    if (!b.ocupado) {
                        boton.on('click', function () {
                            $('#horaInicio').val(b.inicio);
                            $('#horaFin').val(b.fin);

                            // Resalta el bloque seleccionado
                            $('#bloquesHorario button')
                                .removeClass('btn-primary')
                                .addClass('btn-success');
                            $(this)
                                .removeClass('btn-success')
                                .addClass('btn-primary');
                        });
                    }

                    contenedor.append(boton);
                });
            },
            error: function() {
                $('#horariosDisponibles').hide();
                alert('Error al consultar la disponibilidad de horarios.');
            }
        });
    }
});
</script>

{{-- Seleccionar espacios --}}
<script>
$(document).ready(function() {
    $('#espacio_id').change(function() {
        var espacioID = $(this).val();
        if(espacioID) {
            $.ajax({
                url: "{{ url('admin/reserva/canchasPorEspacio') }}/" + espacioID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#cancha_id').empty();
                    $('#cancha_id').append('<option value="">Seleccione una cancha</option>');
                    $.each(data, function(key, value) {
                        $('#cancha_id').append('<option value="'+ value.id +'">'+ value.nombre +'</option>');
                    });
                }
            });
        } else {
            $('#cancha_id').empty();
            $('#cancha_id').append('<option value="">Seleccione una cancha</option>');
        }
    });
});
</script>
{{-- Seleccionar disciplinas --}}
<script>
    $(document).ready(function() {
    $('#cancha_id').change(function() {
        var canchaID = $(this).val();

        if (canchaID) {
            $.ajax({
                url: "{{ url('admin/reserva/disciplinasPorCancha') }}/" + canchaID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#disciplina_id').empty();
                    $('#disciplina_id').append('<option value="">Seleccione una disciplina</option>');
                    $.each(data, function(key, value) {
                        $('#disciplina_id').append('<option value="'+ value.id +'">'+ value.nombre +'</option>');
                    });
                }
            });
        } else {
            $('#disciplina_id').empty();
            $('#disciplina_id').append('<option value="">Seleccione una disciplina</option>');
        }
    });
});
</script>
@stop
