@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>Bienvenido: </b>{{ Auth::user()->name }}</h1>
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

@stop

@section('css')

@stop

@section('js')

@stop
