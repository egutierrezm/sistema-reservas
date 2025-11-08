<?php

namespace Database\Seeders;

use App\Models\AdministradorEspacio;
use App\Models\User;
use App\Models\Ajuste;
use App\Models\Cancha;
use App\Models\CanchaDisciplinaDeportiva;
use App\Models\Deportista;
use App\Models\EspacioDeportivo;
use App\Models\DisciplinaDeportiva;
use App\Models\Reserva;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'erick',
        //     'email' => 'erick@gmail.com',
        // ]);

        Ajuste::create([
            'nombre' => 'Sistema de reserva PUKARA SPORTS',
            'descripcion' => 'Sistema de reservas de espacios deportivos',
            'sucursal' => 'Sucursal Central La Paz',
            'telefono' => '78965412',
            'direccion' => 'Av. Arce Nro. 123, Zona Central',
            'correo' => 'pukara@hotmail.com',
            'logo' => 'uuxxEiw7JkywTSISxbmtcHE3KPUgDmBVKALgSMwE.png'
        ]);

        //Seed para el Administrador (Super Admin)
        $this->call(RoleSeeder::class);
        User::create([
            'name' => 'Super Admin',
            'email' => 'erick@gmail.com',
            'password' => Hash::make('erick125'),
            'tipoDocumento' => 'CI',
            'nroDocumento' => '9123456',
            'nombres' => 'Erick',
            'apellidos' => 'Gutierrez Morales',
            'fechaNaci' => '1998-08-15',
            'celular' => '76543210',
            'genero' => 'Masculino',
            'foto' => null,
            'estado' => true
        ])->assignRole('ADMINISTRADOR');

        //Seed para Deportistas
        $userdep1 = User::create([
            'name' => 'maria',
            'email' => 'maria@umsa.com',
            'password' => Hash::make('maria349'),
            'tipoDocumento' => 'CI',
            'nroDocumento' => '9456721',
            'nombres' => 'Maria',
            'apellidos' => 'Fernandez Lopez',
            'fechaNaci' => '1995-03-22',
            'celular' => '71234567',
            'genero' => 'Femenino',
            'foto' => null,
            'estado' => true
        ])->assignRole('DEPORTISTA');
        Deportista::firstOrCreate(['user_id' => $userdep1->id]);
        $userdep2 = User::create([
            'name' => 'alan',
            'email' => 'alan@hotmail.com',
            'password' => Hash::make('alan606'),
            'tipoDocumento' => 'CI',
            'nroDocumento' => '9734669',
            'nombres' => 'Alan',
            'apellidos' => 'Brito Delgado',
            'fechaNaci' => '2001-08-05',
            'celular' => '77733373',
            'genero' => 'Masculino',
            'foto' => null,
            'estado' => true
        ])->assignRole('DEPORTISTA');
        Deportista::firstOrCreate(['user_id' => $userdep2->id]);
        $userdep3 = User::create([
            'name' => 'karina',
            'email' => 'karina@gmail.com',
            'password' => Hash::make('karina818'),
            'tipoDocumento' => 'CI',
            'nroDocumento' => '9992221',
            'nombres' => 'Karina',
            'apellidos' => 'Mamani Perez',
            'fechaNaci' => '1999-05-14',
            'celular' => '76676689',
            'genero' => 'Femenino',
            'foto' => null,
            'estado' => true
        ])->assignRole('DEPORTISTA');
        Deportista::firstOrCreate(['user_id' => $userdep3->id]);
        $userdep4 = User::create([
            'name' => 'gabriela',
            'email' => 'gabriela@outlook.com',
            'password' => Hash::make('gabriela293'),
            'tipoDocumento' => 'CI',
            'nroDocumento' => '13238940',
            'nombres' => 'Gabriela',
            'apellidos' => 'Quevedo Conde',
            'fechaNaci' => '2005-05-09',
            'celular' => '60923401',
            'genero' => 'Femenino',
            'foto' => null,
            'estado' => true
        ])->assignRole('DEPORTISTA');
        Deportista::firstOrCreate(['user_id' => $userdep4->id]);
        $userdep5 = User::create([
            'name' => 'joel',
            'email' => 'joel@gmail.com',
            'password' => Hash::make('joel111'),
            'tipoDocumento' => 'CI',
            'nroDocumento' => '15590321',
            'nombres' => 'Joel',
            'apellidos' => 'Salinas Siñani',
            'fechaNaci' => '2005-12-23',
            'celular' => '69027233',
            'genero' => 'Masculino',
            'foto' => null,
            'estado' => true
        ])->assignRole('DEPORTISTA');
        Deportista::firstOrCreate(['user_id' => $userdep5->id]);
        
        // Seed para Administrador de Espacios + Espacio Deportivo
        $useradmin1 = User::create([
            'name' => 'warita',
            'email' => 'wara@gmail.com',
            'password' => Hash::make('wara909'),
            'tipoDocumento' => 'CI',
            'nroDocumento' => '9155803',
            'nombres' => 'Wara',
            'apellidos' => 'Andrade Sanchez',
            'fechaNaci' => '2002-10-14',
            'celular' => '69034777',
            'genero' => 'Femenino',
            'foto' => null,
            'estado' => true
        ])->assignRole('ADMINISTRADOR DE ESPACIOS');
        AdministradorEspacio::firstOrCreate(['user_id' => $useradmin1->id]);
        $useradmin2 = User::create([
            'name' => 'camila',
            'email' => 'camila@outlook.com',
            'password' => Hash::make('camila567'),
            'tipoDocumento' => 'CI',
            'nroDocumento' => '9566902',
            'nombres' => 'Camila',
            'apellidos' => 'Auza Mejia',
            'fechaNaci' => '2004-11-28',
            'celular' => '66778801',
            'genero' => 'Femenino',
            'foto' => null,
            'estado' => true
        ])->assignRole('ADMINISTRADOR DE ESPACIOS');
        AdministradorEspacio::firstOrCreate(['user_id' => $useradmin2->id]);
        $espdep1 = EspacioDeportivo::create([
            'nombre' => 'Centro Deportivo La Esperanza',
            'direccion' => 'Av. Arica 789',
            'descripcion' => 'Instalaciones deportivas para entrenamiento y competencias',
            'horaApertura' => '08:00:00',
            'horaCierre' => '20:00:00',
            'administrador_espacio_id' => $useradmin1->administradorEspacio->id
        ]);
        $espdep2 = EspacioDeportivo::create([
            'nombre' => 'Complejo Deportivo Las Lomas',
            'direccion' => 'Av. La Paz 456',
            'descripcion' => 'Canchas para futbol, basquet y voley',
            'horaApertura' => '14:30:00',
            'horaCierre' => '20:00:00',
            'administrador_espacio_id' => $useradmin2->administradorEspacio->id
        ]);
        $espdep3 = EspacioDeportivo::create([
            'nombre' => 'Complejo Deportivo  The Strongest',
            'direccion' => 'Calle Achumani 34',
            'descripcion' => 'Centro de alto rendimiento deportivo',
            'horaApertura' => '09:30:00',
            'horaCierre' => '20:00:00',
            'administrador_espacio_id' => $useradmin2->administradorEspacio->id
        ]);

        // Seed para Disciplina Deportiva + Cancha
        $futbol = DisciplinaDeportiva::create([
            'nombre' => 'Futbol',
            'descripcion' => 'Deporte de equipo con balon con 11 jugadores por equipo'
        ]);
        $baloncesto = DisciplinaDeportiva::create([
            'nombre' => 'Baloncesto',
            'descripcion' => 'Deporte de canasta con 5 jugadores por lado'
        ]);
        $voley = DisciplinaDeportiva::create([
            'nombre' => 'Voley',
            'descripcion' => 'Deporte de red y balon con 6 jugadores por equipo'
        ]);
        $tenis = DisciplinaDeportiva::create([
            'nombre' => 'Tenis',
            'descripcion' => 'Deporte de raqueta con 1 o 2 jugadores por equipo'
        ]);
        $futsal = DisciplinaDeportiva::create([
            'nombre' => 'Futsal',
            'descripcion' => 'Deporte de salon similar al futbol, jugado con 5 jugadores por equipo.'
        ]);
        $cancha1 = Cancha::create([
            'nombre' => 'Pukara 1',
            'descripcion' => 'Cancha de futbol con cesped natural',
            'capacidad' => 200,
            'precioxhora' => 150.00,
            'imgcancha' => 'canchas/k3j3GTPx1Kz807fDPuVbOCq8A3PXmMcdBqw01cmb.jpg',
            'espacio_deportivo_id' => $espdep1->id
        ]);
        $cancha2 = Cancha::create([
            'nombre' => 'Pukara 2',
            'descripcion' => 'Cancha de baloncesto y futsal con piso de madera',
            'capacidad' => 50,
            'precioxhora' => 55.00,
            'imgcancha' => 'canchas/6mXn3FkvVmtAozXdjitsdEjmpY9BmepjDmRTJpMB.jpg',
            'espacio_deportivo_id' => $espdep1->id
        ]);
        $cancha3 = Cancha::create([
            'nombre' => 'Atenea 1',
            'descripcion' => 'Cancha de voley con piso de madera flotante',
            'capacidad' => 100,
            'precioxhora' => 90.00,
            'imgcancha' => null,
            'espacio_deportivo_id' => $espdep2->id
        ]);
        $cancha4 = Cancha::create([
            'nombre' => 'Nayru 1',
            'descripcion' => 'Cancha de tenis con piso de tartan',
            'capacidad' => 80,
            'precioxhora' => 78.00,
            'imgcancha' => null,
            'espacio_deportivo_id' => $espdep3->id
        ]);
        $cancha1->disciplinaDeportivas()->attach($futbol->id);
        $cancha2->disciplinaDeportivas()->attach([$baloncesto->id, $futsal->id]);
        $cancha3->disciplinaDeportivas()->attach($voley->id);
        $cancha4->disciplinaDeportivas()->attach($tenis->id);

        //Seed para Deportista + Reserva + (Cancha + Disciplina Deportiva)
        Reserva::create([
            'fechaReserva' => '2025-11-03',
            'horaInicio' => '10:00:00',
            'horaFin' => '11:00:00',
            'estado' => 'Pendiente',
            'deportista_id' => $userdep5->deportista->id,
            'cancha_id' => $cancha1->id
        ]);

        Reserva::create([
            'fechaReserva' => '2025-11-03',
            'horaInicio' => '17:00:00',
            'horaFin' => '18:00:00',
            'estado' => 'Pendiente',
            'deportista_id' => $userdep4->deportista->id,
            'cancha_id' => $cancha2->id
        ]);
    
    }
}
