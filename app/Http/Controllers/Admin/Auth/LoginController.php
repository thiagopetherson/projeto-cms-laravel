<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; //Adicionamos
use Illuminate\Support\Facades\Validator; //Adicionamos
use Illuminate\Http\Request; //Adicionamos

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin'; //Nem tá usando. Só de sobreaviso

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
       return view('admin.login');
    }

    public function autenticar(Request $request)
    {
       //Especificando os dados que serão recebidos da requisição
       $data = $request->only(['email', 'password']);

       //Validando os dados         
       $validator = $this->validator($data);

       //Pegando o remember (Se não vier, colocamos false)
       //Quando marcamos a opção 'lembrar-me' então é retornado o valor 'on' (string mesmo)
       $remember = $request->input('remember', false);

        //Verificando se deu erro na validação
        if($validator->fails()) 
        {
            //Se der errado o validador, então somos direcionados para a rota de login
            return redirect()->route('login')->withErrors($validator)->withInput();
        }


        //Verificando se o login deu certo
        if(Auth::attempt($data, $remember))
        {
            //Se deu certo, somos direcionados para a tela de admin
            return redirect()->route('admin');
        }
        else
        {   
            //Adicionando mensagem de erro no campo senha (para o caso de se errar a senha)
            $validator->errors()->add('password', 'E-mail e/ou senha errados!');

            //Se não deu certo, somos direcionados para a tela de login
             return redirect()->route('login')->withErrors()->withInput();
        }

    }

    public function logout()
    {
       //Método de logout de usuário
       Auth::logout();

       //Redirecionando o usuário para a rota de login
       return redirect()->route('login');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:4']

         ]);
    }
}
