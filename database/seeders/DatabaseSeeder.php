<?php

namespace Database\Seeders;

use App\Models\AdministradorEspacio;
use App\Models\User;
use App\Models\Ajuste;
use App\Models\Cancha;
use App\Models\Controlador;
use App\Models\Deportista;
use App\Models\EspacioDeportivo;
use App\Models\DisciplinaDeportiva;
use App\Models\Reserva;
use App\Models\Valoracion;
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
            'foto' => '1tWluAkGUE1UXcmz56EaC3yVEnZyCzSzZTPvTA8f.jpg',
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
            'foto' => 'I2GqpD988qoHiAyiP6DOshjuW0BME1eXiSQRBb4W.jpg',
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
        $useradmin3 = User::create([
            'name' => 'genaro',
            'email' => 'genaro@gmail.com',
            'password' => Hash::make('genaro744'),
            'tipoDocumento' => 'CI',
            'nroDocumento' => '12001892',
            'nombres' => 'Genaro',
            'apellidos' => 'Mendoza Ayaviri',
            'fechaNaci' => '2000-07-12',
            'celular' => '60988325',
            'genero' => 'Masculino',
            'foto' => null,
            'estado' => true
        ])->assignRole('ADMINISTRADOR DE ESPACIOS');
        AdministradorEspacio::firstOrCreate(['user_id' => $useradmin3->id]);

        $espdep1 = EspacioDeportivo::create([
            'nombre' => 'Espacio Deportivo Guido Loayza',
            'direccion' => 'Ananta, zona sur de La Paz, Bolivia',
            'descripcion' => 'Varias canchas disponibles para entrenar, competir y disfrutar del deporte',
            'horaApertura' => '08:00:00',
            'horaCierre' => '20:00:00',
            'imgespacio' => 'espacios/IDqPGT6uuJIOL0bId3YEWtYytDPlbzUDL6aiIsdO.jpg',
            'administrador_espacio_id' => $useradmin1->administradorEspacio->id
        ]);
        $espdep2 = EspacioDeportivo::create([
            'nombre' => 'Espacio Deportivo Luis Lastra',
            'direccion' => 'Final Calle Presbítero Medina, Sopocachi, La Paz, Bolivia',
            'descripcion' => 'Disfruta de varias canchas en un espacio cómodo y seguro para tus reservas',
            'horaApertura' => '14:30:00',
            'horaCierre' => '20:00:00',
            'imgespacio' => 'espacios/psMPLbh43sdPfSo5QVhR0qtZNLCKDfeFCr4AKLYU.jpg',
            'administrador_espacio_id' => $useradmin2->administradorEspacio->id
        ]);
        $espdep3 = EspacioDeportivo::create([
            'nombre' => 'Espacio Deportivo The Strongest',
            'direccion' => 'Calle 34, Zona Achumani, La Paz, Bolivia',
            'descripcion' => 'Centro deportivo con varias canchas para entrenar y organizar tus reservas',
            'horaApertura' => '09:30:00',
            'horaCierre' => '20:00:00',
            'imgespacio' => 'espacios/pyOhth8FBHCpNKggMsQmP7XIbg6UGTi3qrHjKYA5.jpg',
            'administrador_espacio_id' => $useradmin3->administradorEspacio->id
        ]);

        // Seed para Disciplina Deportiva + Cancha
        $futbol = DisciplinaDeportiva::create([
            'nombre' => 'Fútbol',
            'descripcion' => 'Deporte de equipo jugado con balón, con 11 jugadores por equipo'
        ]);

        $baloncesto = DisciplinaDeportiva::create([
            'nombre' => 'Baloncesto',
            'descripcion' => 'Deporte de equipo con canasta, con 5 jugadores por lado'
        ]);

        $voley = DisciplinaDeportiva::create([
            'nombre' => 'Vóley',
            'descripcion' => 'Deporte de equipo con red y balón, con 6 jugadores por equipo'
        ]);

        $tenis = DisciplinaDeportiva::create([
            'nombre' => 'Tenis',
            'descripcion' => 'Deporte de raqueta, individual o por parejas, con 1 o 2 jugadores por lado'
        ]);

        $futsal = DisciplinaDeportiva::create([
            'nombre' => 'Futsal',
            'descripcion' => 'Deporte de salón similar al fútbol, jugado con 5 jugadores por equipo'
        ]);

        $voleyplaya = DisciplinaDeportiva::create([
            'nombre' => 'Vóley de playa',
            'descripcion' => 'Deporte de equipo en arena, jugado con 2 jugadores por equipo, similar al vóley'
        ]);

        $natacion = DisciplinaDeportiva::create([
            'nombre' => 'Natación',
            'descripcion' => 'Deporte acuático practicado en piscina, individual o por relevos'
        ]);

        $cancha1 = Cancha::create([
            'nombre' => 'Zeus 1',
            'descripcion' => 'Cancha de fútbol con césped natural',
            'capacidad' => 200,
            'precioxhora' => 150.00,
            'imgcancha' => 'canchas/k3j3GTPx1Kz807fDPuVbOCq8A3PXmMcdBqw01cmb.jpg',
            'espacio_deportivo_id' => $espdep1->id
        ]);
        $cancha2 = Cancha::create([
            'nombre' => 'Zeus 2',
            'descripcion' => 'Cancha de baloncesto y futsal con piso de concreto',
            'capacidad' => 50,
            'precioxhora' => 55.00,
            'imgcancha' => 'canchas/6mXn3FkvVmtAozXdjitsdEjmpY9BmepjDmRTJpMB.jpg',
            'espacio_deportivo_id' => $espdep1->id
        ]);
        $cancha3 = Cancha::create([
            'nombre' => 'Zeus 3',
            'descripcion' => 'Cancha de vóley de playa sobre arena',
            'capacidad' => 30,
            'precioxhora' => 120.00,
            'imgcancha' => 'canchas/SJE9PSAB5pYXfOTDKLSlOM3PumFQEQr5MVH3jHCp.jpg',
            'espacio_deportivo_id' => $espdep1->id
        ]);

        $cancha4 = Cancha::create([
            'nombre' => 'Atenea 1',
            'descripcion' => 'Cancha de voley con piso de madera flotante',
            'capacidad' => 100,
            'precioxhora' => 90.00,
            'imgcancha' => 'canchas/5MLWRffyKFAa61kkYQ0rk18dA7yyPzquGo7SGYsw.jpg',
            'espacio_deportivo_id' => $espdep2->id
        ]);
        $cancha5 = Cancha::create([
            'nombre' => 'Atenea 2',
            'descripcion' => 'Cancha de baloncesto con superficie de cemento antideslizante',
            'capacidad' => 34,
            'precioxhora' => 76.00,
            'imgcancha' => 'canchas/LmAZ6LwgOdmmL4TJPTMEgjPTnCOH7OJZH3SB5Geo.jpg',
            'espacio_deportivo_id' => $espdep2->id
        ]);
        $cancha6 = Cancha::create([
            'nombre' => 'Atenea 3',
            'descripcion' => 'Piscina con fondo de azulejo para entrenamiento y competición',
            'capacidad' => 200,
            'precioxhora' => 325.00,
            'imgcancha' => 'canchas/OBemWZ23BEhXandPlB06ndVRt1JhTgU3YoNs0QuN.jpg',
            'espacio_deportivo_id' => $espdep2->id
        ]);
        $cancha7 = Cancha::create([
            'nombre' => 'Atenea 4',
            'descripcion' => 'Cancha de tenis con superficie de arcilla',
            'capacidad' => 22,
            'precioxhora' => 112.00,
            'imgcancha' => 'canchas/u5vvRvEDb6Eb3o50gv4ix3aYlDxbu3E4eqpJS6tq.jpg',
            'espacio_deportivo_id' => $espdep2->id
        ]);

        $cancha8 = Cancha::create([
            'nombre' => 'Hades 1',
            'descripcion' => 'Cancha de tenis con piso de tartan',
            'capacidad' => 80,
            'precioxhora' => 78.00,
            'imgcancha' => 'canchas/kAaQ9ODteVJ49F3Pn5Y9Moew4mBLYYSHiwNf59dA.jpg',
            'espacio_deportivo_id' => $espdep3->id
        ]);
        $cancha9 = Cancha::create([
            'nombre' => 'Hades 2',
            'descripcion' => 'Cancha de baloncesto bajo techo con superficie profesional',
            'capacidad' => 65,
            'precioxhora' => 187.00,
            'imgcancha' => 'canchas/4UiBJHBdzoWGigEgAAUHlyzw0kAdts8hQilufGe3.jpg',
            'espacio_deportivo_id' => $espdep3->id
        ]);

        $cancha1->disciplinaDeportivas()->attach($futbol->id);
        $cancha2->disciplinaDeportivas()->attach([$baloncesto->id, $futsal->id]);
        $cancha3->disciplinaDeportivas()->attach($voleyplaya->id);
        $cancha4->disciplinaDeportivas()->attach($voley->id);
        $cancha5->disciplinaDeportivas()->attach($baloncesto->id);
        $cancha6->disciplinaDeportivas()->attach($natacion->id);
        $cancha7->disciplinaDeportivas()->attach($tenis->id);
        $cancha8->disciplinaDeportivas()->attach($tenis->id);
        $cancha9->disciplinaDeportivas()->attach($baloncesto->id);


        //Seed para Deportista + Reserva + (Cancha + Disciplina Deportiva)
        Reserva::create([
            'fechaReserva' => '2025-11-27',
            'horaInicio' => '10:00:00',
            'horaFin' => '11:00:00',
            'estado' => 'Pendiente',
            'deportista_id' => $userdep5->deportista->id,
            'cancha_id' => $cancha1->id
        ]);

        Reserva::create([
            'fechaReserva' => '2025-11-27',
            'horaInicio' => '17:00:00',
            'horaFin' => '18:00:00',
            'estado' => 'Pendiente',
            'deportista_id' => $userdep4->deportista->id,
            'cancha_id' => $cancha2->id
        ]);

        //Seed para Controladores
        $usercontroller1 = User::create([
            'name' => 'joaquin',
            'email' => 'joaquin@gmail.com',
            'password' => Hash::make('joaquin181'),
            'tipoDocumento' => 'CI',
            'nroDocumento' => '10018982',
            'nombres' => 'Joaquin',
            'apellidos' => 'Olmos Catacora',
            'fechaNaci' => '1990-04-23',
            'celular' => '74533233',
            'genero' => 'Masculino',
            'foto' => null,
            'estado' => true
        ])->assignRole('CONTROLADOR');
        Controlador::firstOrCreate(['user_id' => $usercontroller1->id]);
        $usercontroller2 = User::create([
            'name' => 'wilmer',
            'email' => 'wilmer@hotmail.com',
            'password' => Hash::make('wilmer333'),
            'tipoDocumento' => 'CI',
            'nroDocumento' => '19023856',
            'nombres' => 'Wilmer',
            'apellidos' => 'Ticona Tarqui',
            'fechaNaci' => '1997-09-13',
            'celular' => '77711199',
            'genero' => 'Masculino',
            'foto' => null,
            'estado' => true
        ])->assignRole('CONTROLADOR');
        Controlador::firstOrCreate(['user_id' => $usercontroller2->id]);
        $usercontroller3 = User::create([
            'name' => 'soledad',
            'email' => 'soledad@outlook.com',
            'password' => Hash::make('soledad606'),
            'tipoDocumento' => 'CI',
            'nroDocumento' => '13477811',
            'nombres' => 'Soledad',
            'apellidos' => 'Copa Burgoa',
            'fechaNaci' => '1999-07-05',
            'celular' => '60689343',
            'genero' => 'Femenino',
            'foto' => null,
            'estado' => true
        ])->assignRole('CONTROLADOR');
        Controlador::firstOrCreate(['user_id' => $usercontroller3->id]);

        // Seed para valoraciones
        $valoraciones = [
            ['cancha' => $cancha1, 'deportista' => $userdep1->deportista, 'puntuacion' => 5, 'comentario' => 'Excelente cancha, muy buena iluminación.'],
            ['cancha' => $cancha1, 'deportista' => $userdep2->deportista, 'puntuacion' => 4, 'comentario' => 'Buena cancha, pero el césped necesita mantenimiento.'],
            ['cancha' => $cancha2, 'deportista' => $userdep3->deportista, 'puntuacion' => 4, 'comentario' => 'Canchas amplias y cómodas.'],
            ['cancha' => $cancha2, 'deportista' => $userdep4->deportista, 'puntuacion' => 3, 'comentario' => 'Podría mejorar la ventilación del lugar.'],
            ['cancha' => $cancha3, 'deportista' => $userdep5->deportista, 'puntuacion' => 5, 'comentario' => 'Arena perfecta para jugar vóley de playa.'],
            ['cancha' => $cancha3, 'deportista' => $userdep1->deportista, 'puntuacion' => 4, 'comentario' => 'Muy buena cancha, aunque algo pequeña para torneos.'],
            ['cancha' => $cancha4, 'deportista' => $userdep2->deportista, 'puntuacion' => 5, 'comentario' => 'Cancha de voley con piso excelente.'],
            ['cancha' => $cancha4, 'deportista' => $userdep3->deportista, 'puntuacion' => 4, 'comentario' => 'Buen lugar, el horario es cómodo.'],
            ['cancha' => $cancha5, 'deportista' => $userdep4->deportista, 'puntuacion' => 3, 'comentario' => 'Piso de cemento algo resbaladizo.'],
            ['cancha' => $cancha5, 'deportista' => $userdep5->deportista, 'puntuacion' => 4, 'comentario' => 'Ideal para entrenar baloncesto.'],
            ['cancha' => $cancha6, 'deportista' => $userdep1->deportista, 'puntuacion' => 5, 'comentario' => 'Piscina muy limpia y bien mantenida.'],
            ['cancha' => $cancha6, 'deportista' => $userdep2->deportista, 'puntuacion' => 5, 'comentario' => 'Perfecta para nadar y entrenar.'],
            ['cancha' => $cancha7, 'deportista' => $userdep3->deportista, 'puntuacion' => 4, 'comentario' => 'Buena cancha de tenis, superficie adecuada.'],
            ['cancha' => $cancha7, 'deportista' => $userdep4->deportista, 'puntuacion' => 5, 'comentario' => 'Excelente ubicación y comodidad.'],
            ['cancha' => $cancha8, 'deportista' => $userdep5->deportista, 'puntuacion' => 4, 'comentario' => 'Cancha de tenis profesional, muy buena.'],
            ['cancha' => $cancha8, 'deportista' => $userdep1->deportista, 'puntuacion' => 3, 'comentario' => 'Algo ruidosa, pero el piso es perfecto.'],
            ['cancha' => $cancha9, 'deportista' => $userdep2->deportista, 'puntuacion' => 5, 'comentario' => 'Cancha techada ideal para entrenamientos.'],
            ['cancha' => $cancha9, 'deportista' => $userdep3->deportista, 'puntuacion' => 4, 'comentario' => 'Buen espacio, iluminación adecuada.'],
        ];

        foreach ($valoraciones as $val) {
            Valoracion::create([
                'cancha_id' => $val['cancha']->id,
                'deportista_id' => $val['deportista']->id,
                'puntos' => $val['puntuacion'],
                'comentario' => $val['comentario'],
            ]);
        }
    
    }
}
