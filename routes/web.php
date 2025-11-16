<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdministradorEspacioController;
// use App\Http\Controllers\HomeController;
use App\Http\Controllers\AjusteController;
use App\Http\Controllers\CancelacionController;
use App\Http\Controllers\CanchaControladorController;
use App\Http\Controllers\CanchaController;
use App\Http\Controllers\CodigoQrController;
use App\Http\Controllers\ControladorController;
use App\Http\Controllers\DeportistaController;
use App\Http\Controllers\DisciplinaDeportivaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EspacioDeportivoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/home', [AdminController::class, 'index'])->name('admin.index.home')->middleware('auth');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware('auth');

// Rutas para ajustes
Route::get('/admin/ajuste', [AjusteController::class, 'index'])->name('admin.ajuste.index')->middleware('auth');
Route::post('/admin/ajuste/create', [AjusteController::class, 'store'])->name('admin.ajuste.create')->middleware('auth');

// Rutas para roles
Route::get('/admin/role', [RoleController::class, 'index'])->name('admin.role.index')->middleware('auth');
Route::get('/admin/role/create', [RoleController::class, 'create'])->name('admin.role.create')->middleware('auth');
Route::post('/admin/role/store', [RoleController::class, 'store'])->name('admin.role.store')->middleware('auth');
Route::get('/admin/role/edit/{id}',[RoleController::class, 'edit'])->name('admin.role.edit')->middleware('auth');
Route::put('/admin/role/update/{id}',[RoleController::class, 'update'])->name('admin.role.update')->middleware('auth');
Route::delete('/admin/role/destroy/{id}',[RoleController::class, 'destroy'])->name('admin.role.destroy')->middleware('auth');
Route::get('/admin/role/permiso/{id}',[RoleController::class, 'permiso'])->name('admin.role.permiso')->middleware('auth');
Route::post('/admin/role/updatePermiso/{id}', [RoleController::class, 'updatePermiso'])->name('admin.role.updatePermiso')->middleware('auth');

// Rutas para usuarios
Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.index')->middleware('auth');
Route::get('/admin/user/create', [UserController::class, 'create'])->name('admin.user.create')->middleware('auth');
Route::post('/admin/user/store', [UserController::class, 'store'])->name('admin.user.store')->middleware('auth');
Route::get('/admin/user/show/{id}', [UserController::class, 'show'])->name('admin.user.show')->middleware('auth');
Route::get('/admin/user/edit/{id}',[UserController::class, 'edit'])->name('admin.user.edit')->middleware('auth');
Route::put('/admin/user/update/{id}',[UserController::class, 'update'])->name('admin.user.update')->middleware('auth');
Route::delete('/admin/user/destroy/{id}',[UserController::class, 'destroy'])->name('admin.user.destroy')->middleware('auth');
Route::post('/admin/user/restore/{id}', [UserController::class, 'restore'])->name('admin.user.restore')->middleware('auth');

// Rutas para espacios deportivos
Route::get('/admin/espacioDeportivo', [EspacioDeportivoController::class, 'index'])->name('admin.espacioDeportivo.index')->middleware('auth');
Route::get('/admin/espacioDeportivo/create', [EspacioDeportivoController::class, 'create'])->name('admin.espacioDeportivo.create')->middleware('auth');
Route::post('/admin/espacioDeportivo/store', [EspacioDeportivoController::class, 'store'])->name('admin.espacioDeportivo.store')->middleware('auth');
Route::get('/admin/espacioDeportivo/show/{id}', [EspacioDeportivoController::class, 'show'])->name('admin.espacioDeportivo.show')->middleware('auth');
Route::get('/admin/espacioDeportivo/edit/{id}',[EspacioDeportivoController::class, 'edit'])->name('admin.espacioDeportivo.edit')->middleware('auth');
Route::put('/admin/espacioDeportivo/update/{id}',[EspacioDeportivoController::class, 'update'])->name('admin.espacioDeportivo.update')->middleware('auth');
Route::delete('/admin/espacioDeportivo/destroy/{id}',[EspacioDeportivoController::class, 'destroy'])->name('admin.espacioDeportivo.destroy')->middleware('auth');

// Rutas para disciplina deportiva
Route::get('/admin/disciplinaDeportiva', [DisciplinaDeportivaController::class, 'index'])->name('admin.disciplinaDeportiva.index')->middleware('auth');
Route::get('/admin/disciplinaDeportiva/create', [DisciplinaDeportivaController::class, 'create'])->name('admin.disciplinaDeportiva.create')->middleware('auth');
Route::post('/admin/disciplinaDeportiva/store', [DisciplinaDeportivaController::class, 'store'])->name('admin.disciplinaDeportiva.store')->middleware('auth');
Route::get('/admin/disciplinaDeportiva/show/{id}', [DisciplinaDeportivaController::class, 'show'])->name('admin.disciplinaDeportiva.show')->middleware('auth');
Route::get('/admin/disciplinaDeportiva/edit/{id}',[DisciplinaDeportivaController::class, 'edit'])->name('admin.disciplinaDeportiva.edit')->middleware('auth');
Route::put('/admin/disciplinaDeportiva/update/{id}',[DisciplinaDeportivaController::class, 'update'])->name('admin.disciplinaDeportiva.update')->middleware('auth');
Route::delete('/admin/disciplinaDeportiva/destroy/{id}',[DisciplinaDeportivaController::class, 'destroy'])->name('admin.disciplinaDeportiva.destroy')->middleware('auth');

// Rutas para cancha
Route::get('/admin/cancha', [CanchaController::class, 'index'])->name('admin.cancha.index')->middleware('auth');
Route::get('/admin/cancha/create', [CanchaController::class, 'create'])->name('admin.cancha.create')->middleware('auth');
Route::post('/admin/cancha/store', [CanchaController::class, 'store'])->name('admin.cancha.store')->middleware('auth');
Route::get('/admin/cancha/show/{id}', [CanchaController::class, 'show'])->name('admin.cancha.show')->middleware('auth');
Route::get('/admin/cancha/edit/{id}',[CanchaController::class, 'edit'])->name('admin.cancha.edit')->middleware('auth');
Route::put('/admin/cancha/update/{id}',[CanchaController::class, 'update'])->name('admin.cancha.update')->middleware('auth');
Route::delete('/admin/cancha/destroy/{id}',[CanchaController::class, 'destroy'])->name('admin.cancha.destroy')->middleware('auth');

// Rutas para administrador de espacio
Route::get('/admin/administradorEspacio', [AdministradorEspacioController::class, 'index'])->name('admin.administradorEspacio.index')->middleware('auth');
Route::get('/admin/administradorEspacio/show/{id}', [AdministradorEspacioController::class, 'show'])->name('admin.administradorEspacio.show')->middleware('auth');
Route::get('/admin/administradorEspacio/edit/{id}', [AdministradorEspacioController::class, 'edit'])->name('admin.administradorEspacio.edit')->middleware('auth');
Route::put('/admin/administradorEspacio/update/{id}',[AdministradorEspacioController::class, 'update'])->name('admin.administradorEspacio.update')->middleware('auth');

// Rutas para deportistas
Route::get('/admin/deportista', [DeportistaController::class, 'index'])->name('admin.deportista.index')->middleware('auth');
Route::get('/admin/deportista/show/{id}', [DeportistaController::class, 'show'])->name('admin.deportista.show')->middleware('auth');
Route::get('/admin/deportista/edit/{id}', [DeportistaController::class, 'edit'])->name('admin.deportista.edit')->middleware('auth');
Route::put('/admin/deportista/update/{id}',[DeportistaController::class, 'update'])->name('admin.deportista.update')->middleware('auth');

// Rutas para reservas
Route::get('/admin/reserva', [ReservaController::class, 'index'])->name('admin.reserva.index')->middleware('auth');
Route::get('/admin/reserva/create', [ReservaController::class, 'create'])->name('admin.reserva.create')->middleware('auth');
Route::post('/admin/reserva/store', [ReservaController::class, 'store'])->name('admin.reserva.store')->middleware('auth');
Route::get('/admin/reserva/show/{id}', [ReservaController::class, 'show'])->name('admin.reserva.show')->middleware('auth');
Route::get('/admin/reserva/edit/{id}',[ReservaController::class, 'edit'])->name('admin.reserva.edit')->middleware('auth');
Route::put('/admin/reserva/update/{id}',[ReservaController::class, 'update'])->name('admin.reserva.update')->middleware('auth');
Route::delete('/admin/reserva/destroy/{id}',[ReservaController::class, 'destroy'])->name('admin.reserva.destroy')->middleware('auth');
Route::get('/admin/reserva/disponibilidad', [ReservaController::class, 'disponibilidad'])->name('admin.reserva.disponibilidad');
Route::post('/admin/reserva/cancelarReserva/{id}', [ReservaController::class, 'cancelarReserva'])->name('admin.reserva.cancelarReserva')->middleware('auth');

// Rutas para pagos
Route::get('/admin/pago', [PagoController::class, 'index'])->name('admin.pago.index')->middleware('auth');
Route::get('/admin/pago/edit/{id}',[PagoController::class, 'edit'])->name('admin.pago.edit')->middleware('auth');
Route::delete('/admin/pago/destroy/{id}',[PagoController::class, 'destroy'])->name('admin.pago.destroy')->middleware('auth');
Route::get('/admin/pago/create/{id}', [PagoController::class, 'create'])->name('admin.pago.create')->middleware('auth');
Route::post('/admin/pago/store/{id}', [PagoController::class, 'store'])->name('admin.pago.store')->middleware('auth');

// Rutas para el codigo QR
Route::get('/admin/codigoQr', [CodigoQrController::class, 'index'])->name('admin.codigoQr.index')->middleware('auth');
Route::get('/admin/codigoQr/show/{id}', [CodigoQrController::class, 'show'])->name('admin.codigoQr.show')->middleware('auth');
Route::get('/admin/codigoQr/edit/{id}',[CodigoQrController::class, 'edit'])->name('admin.codigoQr.edit')->middleware('auth');
Route::put('/admin/codigoQr/update/{id}',[CodigoQrController::class, 'update'])->name('admin.codigoQr.update')->middleware('auth');

// Rutas para cancelar reservas
Route::get('/admin/cancelacion', [CancelacionController::class, 'index'])->name('admin.cancelacion.index')->middleware('auth');
Route::get('/admin/cancelacion/show/{id}', [CancelacionController::class, 'show'])->name('admin.cancelacion.show')->middleware('auth');

// Rutas para el controlador
Route::get('/admin/controlador', [ControladorController::class, 'index'])->name('admin.controlador.index')->middleware('auth');
Route::get('/admin/controlador/show/{id}', [ControladorController::class, 'show'])->name('admin.controlador.show')->middleware('auth');

// Rutas para el controlador mas la cancha
route::get('/admin/asignacion', [CanchaControladorController::class, 'index'])->name('admin.asignacion.index')->middleware('auth');
Route::get('/admin/asignacion/create', [CanchaControladorController::class, 'create'])->name('admin.asignacion.create')->middleware('auth');
Route::post('/admin/asignacion/store', [CanchaControladorController::class, 'store'])->name('admin.asignacion.store')->middleware('auth');
Route::get('/admin/asignacion/show/{id}', [CanchaControladorController::class, 'show'])->name('admin.asignacion.show')->middleware('auth');
Route::get('/admin/asignacion/edit/{id}',[CanchaControladorController::class, 'edit'])->name('admin.asignacion.edit')->middleware('auth');
Route::put('/admin/asignacion/update/{id}',[CanchaControladorController::class, 'update'])->name('admin.asignacion.update')->middleware('auth');
Route::delete('/admin/asignacion/destroy/{id}',[CanchaControladorController::class, 'destroy'])->name('admin.asignacion.destroy')->middleware('auth');
Route::get('/admin/asignacion/canchasPorEspacio/{id}', [CanchaControladorController::class, 'getCanchasPorEspacio'])->name('admin.asignacion.canchasPorEspacio')->middleware('auth');

