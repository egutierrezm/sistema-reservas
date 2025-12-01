@extends('adminlte::page')

@section('title', 'Dashboard Espacios')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-tachometer-alt text-primary mr-2"></i>
                    <b>Panel de Control</b>
                </h1>
                <small class="text-muted">Bienvenido de nuevo, {{ Auth::user()->nombres }}</small>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item text-primary">Rol: {{ Auth::user()->roles->pluck('name')->implode(', ') }}</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')

    {{-- Alertas con animación suave --}}
    @if(session('mensaje'))
        <div class="alert alert-{{ session('icono') == 'success' ? 'success' : 'danger' }} alert-dismissible fade show shadow-sm" role="alert">
            <i class="icon fas {{ session('icono') == 'success' ? 'fa-check' : 'fa-ban' }}"></i>
            {{ session('mensaje') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        {{-- Contenedor Principal (Izquierdo) --}}
        <div class="col-lg-8 col-12">
            
            {{-- Estadísticas (KPIs) con Gradientes y Sombras --}}
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="small-box bg-gradient-info elevation-2">
                        <div class="inner">
                            <h3>{{ $totalEspacios }}</h3>
                            <p>Mis Espacios</p>
                        </div>
                        <div class="icon"><i class="fas fa-building"></i></div>
                        <a href="#" class="small-box-footer">Ver detalles <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="small-box bg-gradient-success elevation-2">
                        <div class="inner">
                            <h3>{{ $totalCanchas }}</h3>
                            <p>Total Canchas</p>
                        </div>
                        <div class="icon"><i class="fas fa-futbol"></i></div>
                        <a href="#" class="small-box-footer">Ver inventario <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="small-box bg-gradient-warning elevation-2">
                        <div class="inner">
                            <h3><sup style="font-size: 20px">Bs</sup> {{ number_format($ingresoDia, 2) }}</h3>
                            <p>Ingresos Hoy</p>
                        </div>
                        <div class="icon"><i class="fas fa-cash-register"></i></div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="small-box bg-gradient-light elevation-2">
                        <div class="inner">
                            <h3><sup style="font-size: 20px">Bs</sup> {{ number_format($ingresoSemana, 2) }}</h3>
                            <p>Ingresos Semana</p>
                        </div>
                        <div class="icon"><i class="fas fa-chart-line"></i></div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
                <h4 class="text-secondary"><i class="fas fa-tasks mr-2"></i> Gestión Operativa</h4>
            </div>

            {{-- Lista de Espacios (Estilo Limpio) --}}
            @foreach($espacios as $espacio)
                <div class="card card-outline card-success collapsed-card shadow-sm mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-map-marker-alt mr-2"></i> 
                            <b>{{ $espacio->nombre }}</b> 
                        </h3>
                        <div class="card-tools">
                            <span class="badge badge-light mr-2" style="font-size: 0.9rem">{{ $espacio->canchas->count() }} Canchas</span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover m-0">
                                <thead class="bg-light text-secondary">
                                    <tr>
                                        <th class="pl-4">Cancha</th>
                                        <th class="text-center">Actividad</th>
                                        <th>Controlador Asignado</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($espacio->canchas as $cancha)
                                    <tr>
                                        <td class="pl-4 align-middle">
                                            <span class="text-bold text-dark">{{ $cancha->nombre }}</span>
                                            <br>
                                            <small class="text-muted">
                                                <i class="far fa-clock"></i>
                                                 {{ \Carbon\Carbon::parse($espacio->horaApertura)->format('H:i') }} - {{ \Carbon\Carbon::parse($espacio->horaCierre)->format('H:i') }}
                                                </small>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="badge badge-info" style="font-size: 0.9em">
                                                {{ $cancha->reservas_count }} Reservas
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            @if($cancha->controladores->count() > 0)
                                                @foreach($cancha->controladores as $controlador)
                                                    <div class="user-block-sm mb-1">
                                                        <i class="fas fa-user-circle text-success"></i>
                                                        <span class="username text-sm text-primary">{{ $controlador->user->nombres }}</span>
                                                        <span class="description text-xs text-muted">
                                                            {{ \Carbon\Carbon::parse($controlador->pivot->fechaAsignacion)->format('d/m') }} - {{ $controlador->pivot->turnoAsignado }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="badge badge-secondary font-weight-normal px-2 py-1">Sin asignar</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <button type="button" 
                                                    class="btn btn-outline-success btn-sm rounded-pill font-weight-bold px-3 shadow-sm"
                                                    data-toggle="modal" 
                                                    data-target="#modalAsignar"
                                                    data-cancha-id="{{ $cancha->id }}"
                                                    data-cancha-nombre="{{ $cancha->nombre }}">
                                                <i class="fas fa-plus mr-1"></i> Asignar
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Contenedor Derecho (Widgets) --}}
        <div class="col-lg-4 col-12">
            
            {{-- Tarjeta de Información --}}
            <div class="card card-outline card-warning shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-lightbulb text-warning mr-2"></i> Tips de Administración</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-2">
                        <i class="fas fa-check text-success mr-1"></i> Recuerda asignar controladores al menos 24 horas antes.
                    </p>
                    <p class="text-muted mb-0">
                        <i class="fas fa-check text-success mr-1"></i> Revisa los ingresos al final del día.
                    </p>
                </div>
            </div>

            {{-- Widget visual de calendario (Solo visual) --}}
            <div class="card bg-gradient-success">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="far fa-calendar-alt"></i>
                        Calendario
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body pt-0">
                   <div class="text-center py-4">
                       <h5 class="mb-0">{{ now()->format('d') }}</h5>
                       <span>{{ now()->locale('es')->monthName }}</span>
                       <hr class="bg-white">
                       <small>Gestión de Canchas</small>
                   </div>
                </div>
            </div>

        </div>
    </div>

    {{-- MODAL ESTILIZADO --}}
    <div class="modal fade" id="modalAsignar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                {{-- Header con Gradiente --}}
                <div class="modal-header bg-gradient-success text-white">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fas fa-user-plus mr-2"></i> Asignar Controlador
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form action="{{ route('admin.asignacion.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <input type="hidden" name="cancha_id" id="modal_cancha_id">
                        
                        {{-- Campo Cancha (Readonly) --}}
                        <div class="form-group">
                            <label class="text-secondary font-weight-bold">Cancha Seleccionada</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="fas fa-futbol text-success"></i></span>
                                </div>
                                <input type="text" id="modal_cancha_nombre" class="form-control bg-white font-weight-bold text-dark" disabled>
                            </div>
                        </div>

                        {{-- Select Controlador --}}
                        <div class="form-group">
                            <label class="text-secondary font-weight-bold">Controlador</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <select name="controlador_id" class="form-control" required>
                                    <option value="">Seleccione un personal</option>
                                    @foreach($controladoresList as $ctrl)
                                        <option value="{{ $ctrl->id }}">
                                            {{ $ctrl->user->nombres }} {{ $ctrl->user->apellidos }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('controlador_id') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            {{-- Fecha --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-secondary font-weight-bold">Fecha</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" name="fechaAsignacion" class="form-control" 
                                               value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                                    </div>
                                    @error('fechaAsignacion') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            {{-- Turno --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-secondary font-weight-bold">Turno</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <select name="turnoAsignado" class="form-control" required>
                                            <option value="Mañana">Mañana</option>
                                            <option value="Tarde">Tarde</option>
                                            <option value="Noche">Noche</option>
                                        </select>
                                    </div>
                                    @error('turnoAsignado') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary font-weight-bold" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success font-weight-bold px-4 shadow-sm">
                            <i class="fas fa-save mr-1"></i> Guardar Asignación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    /* Pequeños ajustes CSS extra */
    .card { border-radius: 8px; border: none; }
    .small-box { border-radius: 8px; }
    .modal-content { border-radius: 12px; }
    .input-group-text { border: 1px solid #ced4da; background-color: #f8f9fa; }
    .btn-rounded-pill { border-radius: 50px; }
    
    /* Hover effect en tabla */
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,.03);
    }
</style>
@stop

@section('js')
<script>
    $('#modalAsignar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('cancha-id');
        var nombre = button.data('cancha-nombre');
        
        var modal = $(this);
        modal.find('#modal_cancha_id').val(id);
        modal.find('#modal_cancha_nombre').val(nombre);
    });
</script>
@stop