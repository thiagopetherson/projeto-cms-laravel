<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request; //Adicionado
use Illuminate\Support\Facades\Auth; //Adicionado para fazermos o login


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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('admin.register');
    }

    public function registrar(Request $request)
    {
        $data = $request->only(['name','email','password','password_confirmation']);

        //Usando o método validator (que está aqui mesmo nesse arquivo)
        $validator = $this->validator($data);

        //Verificando se a validação deu certo ou errado
        if($validator->fails())
        {   
            //Se der errado o validador, então somos direcionados para a rota de registro
            return redirect()->route('register')->withErrors($validator)->withInput();
        }

        //Criando o usuário
        $user = $this->create($data);

        //Logando o Usuário
        Auth::login($user);

        //Se der tudo certo, redireciona o usuário para a rota de admin 
        return redirect()->route('admin');

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
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
