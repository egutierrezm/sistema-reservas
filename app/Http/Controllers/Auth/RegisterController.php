<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Deportista;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'apellidos' => ['required', 'string', 'max:255'],
            'nombres' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),

            'apellidos' => $data['apellidos'],
            'nombres' => $data['nombres'],

            'tipoDocumento' => null,
            'nroDocumento' => null,
            'fechaNaci' => null,
            'celular' => null,
            'genero' => null,
        ]);
        $user->assignRole('DEPORTISTA');

        $deportista = Deportista::firstOrCreate([
            'user_id' => $user->id,
        ]);

        if (!empty($data['reserva_id'])) {
            $reserva = Reserva::find($data['reserva_id']);
            if ($reserva) {
                // $reserva->participantes()->attach($deportista->id);
                if (!$reserva->participantes->contains($deportista->id)) {
                    $urlAcceso = route('admin.controlAcceso', [
                        'reserva_id' => $reserva->id,
                        'deportista_id' => $deportista->id
                    ]);
                    $qrFileName = 'qrs/ingreso_reserva_'.$reserva->id.'_dep_'.$deportista->id.'.png';
                    $qr = QrCode::format('png')->size(300)->generate($urlAcceso);
                    Storage::disk('public')->put($qrFileName, $qr);
                    $reserva->participantes()->attach($deportista->id, [
                        'ingreso' => false,
                        'fechaIngreso' => null,
                        'qr_image' => $qrFileName
                    ]);
                }
            }
        }

        return $user;
    }
}
