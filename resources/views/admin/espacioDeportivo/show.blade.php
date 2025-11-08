@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Datos del Espacio Deportivo</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.espacioDeportivo.index') }}">Listado de Espacios Deportivos</a></li>
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
                    <h3 class="card-title"><i class="fas fa-futbol mr-1"></i> Información del Espacio Deportivo</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        {{-- coloca qui el administrador --}}
                        <dt class="col-sm-4"><i class="fas fa-user-cog fa-fw mr-1 icon-color"></i>Administrador del spacio</dt>
                        <dd class="col-sm-8">
                            {{ $espacioDeportivo->administradorEspacio->user->nombres ?? '' }}
                            {{ $espacioDeportivo->administradorEspacio->user->apellidos ?? '' }}
                        </dd>

                        <dt class="col-sm-4"><i class="fas fa-envelope fa-fw mr-1 icon-color"></i>Correo del administrador</dt>
                        <dd class="col-sm-8">
                            {{ $espacioDeportivo->administradorEspacio->user->email ?? '' }}
                        </dd>

                        <dt class="col-sm-4"><i class="fas fa-building fa-fw mr-1 icon-color"></i>Espacio deportivo</dt>
                        <dd class="col-sm-8">{{ $espacioDeportivo->nombre }}</dd>

                        <dt class="col-sm-4"><i class="fas fa-map-marker-alt fa-fw mr-1 icon-color"></i>Direccion</dt>
                        <dd class="col-sm-8">{{ $espacioDeportivo->direccion }}</dd>

                        <dt class="col-sm-4"><i class="fas fa-align-left fa-fw mr-1 icon-color"></i>Descripcion</dt>
                        <dd class="col-sm-8">{{ $espacioDeportivo->descripcion }}</dd>

                        <dt class="col-sm-4"><i class="fas fa-door-open fa-fw mr-1 icon-color"></i>Hora de apertura</dt>
                        <dd class="col-sm-8">{{ date('H:i', strtotime($espacioDeportivo->horaApertura)) }}</dd>

                        <dt class="col-sm-4"><i class="fas fa-door-closed fa-fw mr-1 icon-color"></i>Hora de cierre</dt>
                        <dd class="col-sm-8">{{ date('H:i', strtotime($espacioDeportivo->horaCierre)) }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-info card-outline h-100">
                <div class="card-body box-profile text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="https://img.icons8.com/color/96/football2--v1.png"
                        alt="Icono espacio deportivo">
                    <h3 class="profile-username">{{ $espacioDeportivo->nombre }}</h3>
                    <p class="text-muted">Espacio Deportivo</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .icon-color {
            color: navy;
        }
    </style>
@stop

@section('js')
    <script> console.log("Vista show del Espacio Deportivo cargada correctamente"); </script>
@stop
