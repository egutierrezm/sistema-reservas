<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::create(['name' => 'ADMINISTRADOR']);
        Role::create(['name' => 'ADMINISTRADOR DE ESPACIOS']);
        Role::create(['name' => 'DEPORTISTA']);
        Role::create(['name' => 'CONTROLADOR']);
        //Ajustes
        Permission::create(['name' => 'admin.ajuste.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.ajuste.create'])->syncRoles($superAdmin);
        //Roles
        Permission::create(['name' => 'admin.role.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.role.create'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.role.store'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.role.edit'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.role.update'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.role.destroy'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.role.permiso'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.role.updatePermiso'])->syncRoles($superAdmin);
        //Users
        Permission::create(['name' => 'admin.user.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.user.create'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.user.store'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.user.show'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.user.edit'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.user.update'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.user.destroy'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.user.restore'])->syncRoles($superAdmin);
        //Espacios Deportivos
        Permission::create(['name' => 'admin.espacioDeportivo.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.espacioDeportivo.create'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.espacioDeportivo.store'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.espacioDeportivo.show'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.espacioDeportivo.edit'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.espacioDeportivo.update'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.espacioDeportivo.destroy'])->syncRoles($superAdmin);
        //Disciplina Deportiva
        Permission::create(['name' => 'admin.disciplinaDeportiva.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.disciplinaDeportiva.create'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.disciplinaDeportiva.store'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.disciplinaDeportiva.show'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.disciplinaDeportiva.edit'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.disciplinaDeportiva.update'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.disciplinaDeportiva.destroy'])->syncRoles($superAdmin);
        //Cancha
        Permission::create(['name' => 'admin.cancha.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.cancha.create'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.cancha.store'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.cancha.show'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.cancha.edit'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.cancha.update'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.cancha.destroy'])->syncRoles($superAdmin);
        //Administrador de Espacios
        Permission::create(['name' => 'admin.administradorEspacio.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.administradorEspacio.show'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.administradorEspacio.edit'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.administradorEspacio.update'])->syncRoles($superAdmin);
        //Deportista
        Permission::create(['name' => 'admin.deportista.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.deportista.show'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.deportista.edit'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.deportista.update'])->syncRoles($superAdmin);
        //Reserva
        Permission::create(['name' => 'admin.reserva.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.reserva.create'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.reserva.store'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.reserva.show'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.reserva.edit'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.reserva.update'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.reserva.destroy'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.reserva.disponibilidad'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.reserva.cancelarReserva'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.reserva.canchasPorEspacio'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.reserva.disciplinasPorCancha'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.reserva.finalizarReserva'])->syncRoles($superAdmin);

        //Pago
        Permission::create(['name' => 'admin.pago.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.pago.create'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.pago.store'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.pago.edit'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.pago.update'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.pago.destroy'])->syncRoles($superAdmin);
        //Codigo Qr
        Permission::create(['name' => 'admin.codigoQr.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.codigoQr.show'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.codigoQr.edit'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.codigoQr.update'])->syncRoles($superAdmin);
        //Cancelacion
        Permission::create(['name' => 'admin.cancelacion.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.cancelacion.show'])->syncRoles($superAdmin);
        //Controlador
        Permission::create(['name' => 'admin.controlador.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.controlador.show'])->syncRoles($superAdmin);
        //CanchaControlador
        Permission::create(['name' => 'admin.asignacion.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.asignacion.create'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.asignacion.store'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.asignacion.show'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.asignacion.edit'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.asignacion.update'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.asignacion.destroy'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.asignacion.canchasPorEspacio'])->syncRoles($superAdmin);
        //Valoracion
        Permission::create(['name' => 'admin.valoracion.index'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.valoracion.create'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.valoracion.store'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.valoracion.edit'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.valoracion.update'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.valoracion.destroy'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.valoracion.canchasPorEspacio'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.valoracion.comentarioPorCancha'])->syncRoles($superAdmin);
        Permission::create(['name' => 'admin.valoracion.getValoracionPorCancha'])->syncRoles($superAdmin);
        
        //Invitacion
        Permission::create(['name' => 'admin.invitacion.index'])->syncRoles($superAdmin);
    }
}
