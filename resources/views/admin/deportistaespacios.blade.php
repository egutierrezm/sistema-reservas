@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>Bienvenido: </b>{{ Auth::user()->nombres }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href=""><b>Rol: {{ Auth::user()->roles->pluck('name')->implode(', ') }} </b></a> </li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr>
@stop

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>Bienvenido: </b>{{ Auth::user()->name }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <b>Rol: {{ Auth::user()->roles->pluck('name')->implode(', ') }}</b>
                    </li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr>
@stop

@section('content')

@php
    $roles = Auth::user()->roles->pluck('name');
    $from = request()->get('from');
@endphp

@if($roles->contains('DEPORTISTA') && $from)
    @if($from === 'reserva')
        @php
            session()->now('mensaje', 'Puedes hacer tus reservas desde aquí.');
            session()->now('icono', 'info');
        @endphp
    @elseif($from === 'valoracion')
        @php
            session()->now('mensaje', 'Puedes hacer tus valoraciones desde aquí.');
            session()->now('icono', 'info');
        @endphp
    @endif
@endif

<div class="container">
    <div class="row">
        @foreach($espacios as $espacio)
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white h-100">
                    @if($espacio->imgespacio)
                        <img src="{{ asset('storage/'.$espacio->imgespacio) }}" class="card-img-top" alt="{{ $espacio->nombre }}" style="height:180px; object-fit:cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center text-warning mb-3" style="font-weight: bold; font-size: 1.2rem;">
                            {{ $espacio->nombre }}
                        </h5>
                        <p class="card-text" style="font-size:0.9rem;">{{ $espacio->descripcion }}</p>
                        <p class="card-text" style="font-size:0.9rem;">
                            <i class="fas fa-user-tie"></i> <b> Administrador:</b>
                            {{ $espacio->administradorEspacio ? $espacio->administradorEspacio->user->nombres . ' ' . $espacio->administradorEspacio->user->apellidos : 'Sin asignar' }}
                        </p>
                        <p class="card-text" style="font-size:0.9rem;">
                            <b>Dirección:</b> {{ $espacio->direccion }}<br>
                            <b>Horario:</b> {{ \Carbon\Carbon::parse($espacio->horaApertura)->format('H:i') }} - {{ \Carbon\Carbon::parse($espacio->horaCierre)->format('H:i') }}
                        </p>
                        <div class="mt-auto">
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#mapModal{{ $espacio->id }}">
                                <i class="fas fa-map-marked-alt"></i> Ver Ubicación
                            </button>
                            <a href="{{ route('admin.verCanchas', $espacio->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-basketball-ball"></i> Ver Canchas
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Google Maps -->
            <div class="modal fade" id="mapModal{{ $espacio->id }}" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel{{ $espacio->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mapModalLabel{{ $espacio->id }}">Ubicación de {{ $espacio->nombre }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <iframe
                            width="100%"
                            height="350"
                            frameborder="0" style="border:0"
                            src="https://www.google.com/maps?q={{ urlencode($espacio->direccion) }}&output=embed"
                            allowfullscreen>
                        </iframe>
                    </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@stop

@section('css')
<style>
.card {
    border-radius: 0.5rem;
}
.card .btn {
    width: 48%;
}

</style>
@stop

@section('js')
@if(session('mensaje'))
<script>
    Swal.fire({
        icon: "{{ session('icono') }}",
        title: "{{ session('mensaje') }}",
        toast: true,
        position: 'top-end',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
    });
</script>
@endif

@stop
