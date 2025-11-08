@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Datos de la Cancha</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.cancha.index') }}">Listado de canchas</a></li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-info h-100">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Información de la Cancha</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4"><i class="fas fa-landmark fa-fw mr-1 icon-color"></i>Espacio Deportivo</dt>
                    <dd class="col-sm-8">{{ $cancha->espacioDeportivo->nombre }}</dd>

                    <dt class="col-sm-4"><i class="fas fa-pen-nib fa-fw mr-1 icon-color"></i>Cancha</dt>
                    <dd class="col-sm-8">{{ $cancha->nombre }}</dd>
                    
                    <dt class="col-sm-4"><i class="fas fa-running fa-fw mr-1 icon-color"></i>Disciplinas</dt>
                    <dd class="col-sm-8">
                        @foreach($cancha->disciplinaDeportivas as $disciplina)
                            <span class="badge badge-primary">{{ $disciplina->nombre }}</span>
                        @endforeach
                    </dd>
                    
                    <dt class="col-sm-4"><i class="fas fa-align-left fa-fw mr-1 icon-color"></i>Descripción</dt>
                    <dd class="col-sm-8">{{ $cancha->descripcion }}</dd>

                    <dt class="col-sm-4"><i class="fas fa-users fa-fw mr-1 icon-color"></i>Capacidad</dt>
                    <dd class="col-sm-8">{{ $cancha->capacidad }}</dd>

                    <dt class="col-sm-4"><i class="fas fa-dollar-sign fa-fw mr-1 icon-color"></i>Precio por hora</dt>
                    <dd class="col-sm-8">Bs. {{ number_format($cancha->precioxhora, 2) }}</dd>


                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-info card-outline h-100">
            <div class="card-body box-profile text-center">
                @if($cancha->imgcancha)
                    <img class="img-fluid rounded"
                        src="{{ asset('storage/' . $cancha->imgcancha) }}"
                        alt="Imagen de la cancha {{ $cancha->nombre }}">
                @else
                    <img class="img-fluid rounded"
                        src="https://img.icons8.com/officel/80/hockey-field.png"
                        alt="Imagen genérica de cancha">
                @endif
                <h3 class="mt-3">{{ $cancha->nombre }}</h3>
                <p class="text-muted">
                    <span class="badge badge-info">{{ $cancha->espacioDeportivo->nombre }}</span>
                </p>
                <hr>
                <strong><i class="fas fa-calendar-alt mr-1"></i> Fecha de Creación</strong>
                <p class="text-muted">{{ $cancha->created_at->isoFormat('dddd, D [de] MMMM [de] YYYY, h:mm A') }}</p>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .badge {
            font-size: 0.9em;
        }
        .icon-color {
            color: navy;
        }
    </style>
@stop

@section('js')
    <script> console.log("Mostrando información de la cancha"); </script>
@stop
