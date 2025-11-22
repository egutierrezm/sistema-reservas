@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Datos del Deportista</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.deportista.index') }}">Listado de deportistas</a></li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
@stop

@section('content')
<div class="row">
    {{-- Información principal --}}
    <div class="col-md-8">
        <div class="card card-info h-100">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Información del deportista</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4"><i class="fas fa-user fa-fw mr-1 icon-color"></i> Nombres</dt>
                    <dd class="col-sm-8">{{ $deportista->user->nombres }}</dd>

                    <dt class="col-sm-4"><i class="fas fa-user-tag fa-fw mr-1 icon-color"></i> Apellidos</dt>
                    <dd class="col-sm-8">{{ $deportista->user->apellidos }}</dd>

                    <dt class="col-sm-4"><i class="fas fa-phone fa-fw mr-1 icon-color"></i> Celular</dt>
                    <dd class="col-sm-8">{{ $deportista->user->celular }}</dd>

                    <dt class="col-sm-4"><i class="fas fa-envelope fa-fw mr-1 icon-color"></i> Correo</dt>
                    <dd class="col-sm-8">{{ $deportista->user->email }}</dd>

                    <dt class="col-sm-4"><i class="fas fa-sun fa-fw mr-1 icon-color"></i> Club</dt>
                    <dd class="col-sm-8">{{ $deportista->club ?? 'No asignado' }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-info card-outline h-100">
            <div class="card-body box-profile text-center">
                @if($deportista->user->foto)
                    <img class="img-fluid rounded-circle mb-3"
                        src="{{ asset('storage/fotos/' . $deportista->user->foto) }}"
                        alt="Foto de {{ $deportista->user->nombres }}">
                @else
                    <img class="img-fluid rounded-circle mb-3"
                        src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                        alt="Foto genérica de usuario">
                @endif

                <h3 class="mt-2">{{ $deportista->user->nombres }} {{ $deportista->user->apellidos }}</h3>
                <p class="text-muted mb-1">
                    <span class="badge badge-info">Deportista</span>
                </p>
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
        .img-fluid {
            max-width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
@stop

@section('js')
    <script> console.log("Mostrando información del deportista"); </script>
@stop
