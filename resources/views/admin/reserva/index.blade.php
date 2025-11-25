@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">LISTADO DE RESERVAS</h1>
                </div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Reservas</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-navy">
                <div class="card-header" style="background-color: #CCF3EA;">
                    <h3 class="card-title"><b>Reservas Registradas</b></h3>

                    <!-- /.card-tools -->
                    <div class="card-tools">
                        <a href="{{ route('admin.reserva.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Crear Reserva</a>
                    </div>
                </div>
                
                <!-- /.card-header -->
                <div class="card-body bg-dark" style="background-color: #f0f5e8;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="table1" class="table table-dark table-bordered table-striped table-hover table-sm">
                                    <thead class="thead-light">
                                        <th style="width: 10px">Nro</th>
                                        <th>Deportista</th>
                                        <th>Cancha y disciplina</th>
                                        <th>Imagen</th>
                                        <th>Fecha y hora</th>
                                        <th>Precio</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach($reservas as $reserva)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $reserva->deportista->user->nombres }} {{ $reserva->deportista->user->apellidos }}</td>
                                            <td>
                                                {{ $reserva->cancha->nombre }} <br>
                                                <div class="mt-2 p-2 border rounded bg-light text-truncate" style="display: inline-block; min-width: 150px; border-color: orange !important; font-size: 0.875rem;">
                                                
                                                    <div>{{ $reserva->disciplina->nombre }}</div>
                                                
                                                </div>
                                            </td>
                                            <td>
                                                @if($reserva->cancha->imgcancha)
                                                    <img src="{{ asset('storage/'.$reserva->cancha->imgcancha) }}"
                                                        alt="Imagen cancha"
                                                        class="img-thumbnail"
                                                        style="width: 100px; height: auto; max-height: 100px; display: block; margin: 0 auto;">
                                                @else
                                                    <span class="text-muted">Sin imagen</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($reserva->fechaReserva)->format('d/m/Y') }} <br>
                                                {{ \Carbon\Carbon::parse($reserva->horaInicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($reserva->horaFin)->format('H:i') }}
                                            </td>
                                            <td>(Bs.) {{ $reserva->cancha->precioxhora }}</td>
                                            <td>
                                                @if($reserva->estado == 'Pendiente')
                                                    <span class="badge badge-warning">{{ $reserva->estado }}</span>
                                                @elseif($reserva->estado == 'Confirmada')
                                                    <span class="badge badge-success">{{ $reserva->estado }}</span>
                                                @elseif($reserva->estado == 'Cancelada')
                                                    <span class="badge badge-danger">{{ $reserva->estado }}</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                @if(!$reserva->deleted_at)
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="{{ route('admin.reserva.show', $reserva->id) }}" class="btn-icon-circle btn-view mr-1" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.reserva.edit', $reserva->id) }}" class="btn-icon-circle btn-edit mr-1" title="Editar reserva">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.pago.create', $reserva->id) }}" class="btn-icon-circle btn-pay mr-1" title="Registrar pago">
                                                        <i class="fas fa-credit-card"></i>
                                                    </a>

{{-- @if($reserva->estado !== 'Cancelada' && $reserva->fechaReserva >= now()->toDateString()) --}}
                                                    <form action="{{ route('admin.reserva.cancelarReserva', $reserva->id) }}" method="POST" style="display:inline-block;" id="cancelarFormulario{{ $reserva->id }}">
                                                        @csrf
                                                        <button type="submit" class="btn-icon-circle btn-cancel mr-1"
                                                            onclick="confirmarCancelacion(event, {{ $reserva->id }})"
                                                            title="Cancelar reserva">
                                                            <i class="fas fa-times-circle"></i>
                                                        </button>
                                                    </form>
                                                    <script>
                                                        function confirmarCancelacion(event, id) {
                                                            event.preventDefault();

                                                            Swal.fire({
                                                                title: '¿Desea cancelar esta reserva?',
                                                                text: 'Por favor, indique el motivo de la cancelación.',
                                                                icon: 'warning',
                                                                input: 'text',
                                                                inputLabel: 'Motivo',
                                                                inputPlaceholder: 'Ejemplo: El cliente no asistió...',
                                                                showCancelButton: true,
                                                                confirmButtonText: 'SI',
                                                                confirmButtonColor: '#e0a800',
                                                                cancelButtonText: 'NO',
                                                                inputValidator: (value) => {
                                                                    if (!value) {
                                                                        return 'Debe ingresar un motivo antes de continuar.';
                                                                    }
                                                                }
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    const form = document.getElementById('cancelarFormulario' + id);
                                                                    
                                                                    // Crear input oculto con el motivo
                                                                    const input = document.createElement('input');
                                                                    input.type = 'hidden';
                                                                    input.name = 'motivo';
                                                                    input.value = result.value;
                                                                    form.appendChild(input);

                                                                    // Enviar formulario
                                                                    form.submit();
                                                                }
                                                            });
                                                        }
                                                    </script>

        {{-- @endif --}}
                                                    <form action="{{ route('admin.reserva.destroy', $reserva->id) }}" method="POST"
                                                        id="miFormulario{{ $reserva->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-icon-circle btn-delete mr-1"
                                                            onclick="preguntar{{$reserva->id}}(event)" 
                                                            title="Eliminar">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                    <script>
                                                        function preguntar{{ $reserva->id }}(event) {
                                                            event.preventDefault();
                                                            console.log('clic detectado');
                                                            Swal.fire({
                                                                title: '¿Desea eliminar este registro?',
                                                                text: '',
                                                                icon: 'question',
                                                                showDenyButton: true,
                                                                confirmButtonText: 'SI',
                                                                confirmButtonColor: '#a5161d',
                                                                denyButtonColor: '#270a0a',
                                                                denyButtonText: 'NO',
                                                            }).then((result) => {
                                                                if(result.isConfirmed){
                                                                    document.getElementById('miFormulario{{ $reserva->id }}').submit();
                                                                }
                                                            });
                                                        }
                                                    </script>
                                                @else
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <form action="{{ route('admin.reserva.restore', $reserva->id) }}" method="POST"
                                                        id="miFormulario{{ $reserva->id }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning btn-sm"
                                                            onclick="preguntar{{$reserva->id}}(event)">
                                                            <i class="fas fa-trash-alt me-1"></i> Restaurar reserva
                                                        </button>
                                                    </form>
                                                </div>
                                                    <script>
                                                        function preguntar{{ $reserva->id }}(event) {
                                                            event.preventDefault();
                                                            console.log('clic detectado');
                                                            Swal.fire({
                                                                title: '¿Desea restaurar esta reserva?',
                                                                text: '',
                                                                icon: 'question',
                                                                showDenyButton: true,
                                                                confirmButtonText: 'SI',
                                                                confirmButtonColor: '#a5161d',
                                                                denyButtonColor: '#270a0a',
                                                                denyButtonText: 'NO',
                                                            }).then((result) => {
                                                                if(result.isConfirmed){
                                                                    document.getElementById('miFormulario{{ $reserva->id }}').submit();
                                                                }
                                                            });
                                                        }
                                                    </script>
                                                
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Estilos de las acciones */
        .btn-icon-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: transform 0.15s ease, box-shadow 0.15s ease, border 0.15s ease, color 0.15s ease;
        }
        .btn-view { background-color: #0062ff; border-color: #1f72aa; }
        .btn-edit { background-color: #44ce42; border-color: #27ae60; }
        .btn-pay  { background-color: #a461d8; border-color: #8e44ad; }
        .btn-delete { background-color: #fc5a5a; border-color: #c0392b; }
        .btn-cancel { background-color: #1abc9c; border-color: #16a085; }
        
        .btn-icon-circle:hover {
            transform: scale(1.15);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .btn-icon-circle:hover i {
            color: #ffffff;
        }

        /* Estilos de la tabla */
        table.dataTable tbody td {
            vertical-align: middle;
            text-align: center;
        }

        table.dataTable thead {
            /* background-color: #001737;
            color: #ffffff; */
            text-align: center;
        }

        #table1_wrapper .dt-buttons {
            background-color: transparent;
            box-shadow: none;
            border: none;
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        #table1_wrapper .btn {
            color: #fff;
            border-radius: 4px;
            padding: 5px 15px;
            font-size: 14px;
        }
        .btn-danger { background-color: #dc3545; border: none; }
        .btn-success { background-color: #28a745; border: none; }
        .btn-info { background-color: #17a2b8; border: none; }
        .btn-warning { background-color: #ffc107; color: #212529; border: none; }
        /* .btn-default { background-color: #6e7176; color: #212529; border: none; } */

        .badge-fuchsia {
            background-color: #ADFF2F;
            color: black;
        }

    </style>
@stop

@section('js')
    <script>
        $(function(){
            $("#table1").DataTable({
                "pageLength":5,
                "ordering": false,
                "language":{
                    "emptyTable": "No hay informacion",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Reservas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Reservas",
                    "infoFiltered": "(Filtrado de _MAX_ total Reservas)",
                    "lengthMenu": "Mostrar _MENU_ Reservas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscador:",
                    "zeroRecords": "Sin resultados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                
            });
        });
    </script>
@stop