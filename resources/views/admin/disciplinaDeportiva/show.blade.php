@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Datos de la Disciplina Deportiva</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.disciplinaDeportiva.index') }}">Listado de Disciplinas Deportivas</a></li>
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
                    <h3 class="card-title"><i class="fas fa-futbol mr-1"></i> Información de la Disciplina Deportiva</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4"><i class="fas fa-pen-nib fa-fw mr-1"></i>Nombre</dt>
                        <dd class="col-sm-8">{{ $disciplinaDeportiva->nombre }}</dd>

                        <dt class="col-sm-4"><i class="fas fa-align-left fa-fw mr-1"></i>Descripción</dt>
                        <dd class="col-sm-8">{{ $disciplinaDeportiva->descripcion }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        @php
            $iconos = [
                'Futbol' => 'https://img.icons8.com/plasticine/100/football2.png',
                'Futsal' => 'https://img.icons8.com/officel/80/football2--v2.png',
                'Baloncesto' => 'https://img.icons8.com/pin/100/basketball.png',
                'Voley' => 'https://img.icons8.com/plasticine/100/volleyball.png',
                'Natacion' => 'https://img.icons8.com/color/96/swimming.png',
                'Tenis' => 'https://img.icons8.com/emoji/96/baseball-emoji.png'
            ];
            $iconoDisciplina = $iconos[$disciplinaDeportiva->nombre] ?? 'https://img.icons8.com/color/96/sports.png';
        @endphp
        <div class="col-md-4">
            <div class="card card-info card-outline h-100">
                <div class="card-body box-profile text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ $iconoDisciplina }}"
                        alt="Icono disciplina deportiva">
                    <h3 class="profile-username">{{ $disciplinaDeportiva->nombre }}</h3>
                    <p class="text-muted">Disciplina Deportiva</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script> console.log("Vista show de Disciplina Deportiva cargada correctamente"); </script>
@stop
