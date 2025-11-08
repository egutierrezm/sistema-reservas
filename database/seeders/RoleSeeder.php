<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'ADMINISTRADOR']);
        Role::create(['name' => 'ADMINISTRADOR DE ESPACIOS']);
        Role::create(['name' => 'DEPORTISTA']);
    }
}
