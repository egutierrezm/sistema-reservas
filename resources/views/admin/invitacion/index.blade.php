@extends('adminlte::page')

@section('title', 'Mis Invitaciones')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-white">Mis Invitaciones</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        @forelse($deportistas as $deportista)
            @foreach($deportista->reservaParticipadas as $reserva)
                @php
                    // Lógica de estado
                    $ingreso = $reserva->pivot->ingreso;
                    $borde = $ingreso ? 'border-secondary' : 'border-success';
                    $textoEstado = $ingreso ? 'INGRESÓ' : 'INVITADO';
                    $bgRibbon = $ingreso ? 'bg-light' : 'bg-success';
                    
                    // Formato fechas
                    $fecha = \Carbon\Carbon::parse($reserva->fechaReserva)->format('d/m/Y');
                    $hora = substr($reserva->horaInicio, 0, 5) . ' - ' . substr($reserva->horaFin, 0, 5);
                @endphp

                <div class="col-12 col-md-6 col-lg-4 col-xl-3 d-flex align-items-stretch">
                    {{-- Tarjeta: bg-dark, borde verde --}}
                    <div class="card bg-dark {{ $borde }} shadow-lg mb-4 w-100 card-compact">
                        
                        {{-- Ribbon --}}
                        <div class="ribbon-wrapper ribbon-md">
                            <div class="ribbon {{ $bgRibbon }} text-bold">
                                {{ $textoEstado }}
                            </div>
                        </div>

                        {{-- CARD BODY: Estructura Vertical --}}
                        <div class="card-body p-3 d-flex flex-column text-center">
                            
                            {{-- 1. INFORMACIÓN SUPERIOR --}}
                            <div class="mb-2">
                                <h6 class="text-success font-weight-bold mb-1">
                                    {{ $reserva->cancha->espacioDeportivo->nombre }}
                                </h6>
                                <h5 class="text-white font-weight-bold mb-2">
                                    Cancha - {{ $reserva->cancha->nombre }}
                                </h5>
                                
                                <div class="text-white-60 small">
                                    <span class="d-block mb-1">
                                        <i class="fas fa-calendar-day mr-1 text-success"></i> {{ $fecha }}
                                    </span>
                                    <span>
                                        <i class="far fa-clock mr-1 text-success"></i> {{ $hora }}
                                    </span>
                                    <span class="d-block">
                                        <i class="fas fa-user mr-1 text-success"></i> {{$deportista->user->nombres}}
                                    </span>
                                </div>
                            </div>

                            {{-- 2. QR CENTRADO (Antes de los botones) --}}
                            <div class="mt-auto mb-3">
                                @if($reserva->pivot->qr_image)
                                    {{-- Contenedor blanco para el SVG --}}
                                    <div class="bg-white p-2 rounded shadow-sm d-inline-block qr-thumbnail"
                                         data-toggle="modal" 
                                         data-target="#modalQR-{{ $reserva->id }}"
                                         style="cursor: pointer;">
                                        <img src="{{ asset('storage/' . $reserva->pivot->qr_image) }}" 
                                             alt="QR" 
                                             class="img-fluid" 
                                             style="width: 100px; height: 100px;">
                                    </div>
                                    <div class="small text-white-50 mt-1" style="font-size: 0.7rem;">Clic para ampliar</div>
                                @else
                                    <div class="py-3 text-white-50 small">
                                        <i class="fas fa-spinner fa-spin mb-2"></i><br>Generando...
                                    </div>
                                @endif
                            </div>

                            {{-- 3. BOTONES --}}
                            <div class="row">
                                <div class="col-6 pr-1">
                                    @if($reserva->pivot->qr_image)
                                        <button class="btn btn-outline-light btn-block btn-sm" 
                                                data-toggle="modal" 
                                                data-target="#modalQR-{{ $reserva->id }}">
                                            <i class="fas fa-eye"></i> Ver QR
                                        </button>
                                    @endif
                                </div>
                                <div class="col-6 pl-1">
                                    @if($reserva->pivot->qr_image)
                                        <a href="{{ asset('storage/' . $reserva->pivot->qr_image) }}" 
                                           class="btn btn-success btn-block btn-sm" 
                                           download="Invitacion-{{ $deportista->user->nombres }}.svg">
                                            <i class="fas fa-download"></i> Descargar
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL QR --}}
                @if($reserva->pivot->qr_image)
                <div class="modal fade" id="modalQR-{{ $reserva->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content bg-dark border-success">
                            <div class="modal-header border-secondary p-2">
                                <h6 class="modal-title text-white">Pase de Acceso</h6>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center pt-4 pb-4">
                                <div class="bg-white p-3 rounded d-inline-block shadow-lg">
                                    <img src="{{ asset('storage/' . $reserva->pivot->qr_image) }}" style="width: 200px; height: 200px;">
                                </div>
                                <p class="text-white mt-3 mb-0 font-weight-bold"> Cancha - {{ $reserva->cancha->nombre }}</p>
                                <p class="text-success small">{{ $fecha }} | {{ $hora }}</p>
                                <p class="small text-white mb-0">Presenta este código en la entrada</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            @endforeach
        @empty
            <div class="col-12">
                <div class="alert alert-dark border-secondary text-center">
                    No hay invitaciones activas.
                </div>
            </div>
        @endforelse
    </div>
</div>
@stop

@section('css')
<style>
    .text-white-50 { color: rgba(255, 255, 255, 0.6) !important; }
    
    .card-compact {
        transition: transform 0.2s;
        border-width: 1px;
    }
    .card-compact:hover {
        transform: translateY(-3px);
        box-shadow: 0 0 15px rgba(40, 167, 69, 0.4) !important; 
    }
    
    .qr-thumbnail {
        transition: transform 0.2s;
    }
    .qr-thumbnail:hover {
        transform: scale(1.05);
    }
</style>
@stop