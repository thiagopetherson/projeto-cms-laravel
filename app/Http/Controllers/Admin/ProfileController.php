<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //Chamando a classe do validator
use Illuminate\Support\Facades\Hash; //Chamando a classe do Hash
use Illuminate\Support\Facades\Auth; //Pegando a classe Auth
use App\User;

class ProfileController extends Controller
{
    public function __construct()
    {
    	//Verificando se o cara está logado
    	$this->middleware('auth');
    }

    public function index()
   	{
   		//Pegando o usuário que está logado
   		$loggedId = intval(Auth::id());

   		//Pegando o usuário com base no ID capturado acima
   		$user = User::find($loggedId);

   		if($user)
   		{
	   		//Chamando a view e passando os dados
	   		return view('admin.profile.index', 
	   						['user' => $user]
	   					);
   		}
   		else
   		{
   			//Se não der certo, redirecionamos para essa rota
   			return redirect()->route('admin');
   		}
   	}

    public function save(Request $request)
    {

        //Pegando o usuário que está logado
        $loggedId = intval(Auth::id());

        //Pegando o usuário com base no ID capturado acima
        $user = User::find($loggedId);

         if($user)
         {
              //Só aceitará esses campos
              $data = $request->only(['name','email','password','password_confirmation']);

              //Validando os dados que chegaram (name e email)
              $validator = Validator::make([
                  'name' => $data['name'],
                  'email' => $data['email'], 
              ],
              [                
                  'name' => ['required', 'string', 'max:100'],
                  'email' => ['required', 'string', 'email', 'max:100']
              ]);
            
              //Alterando o nome usuário
              $user->name = $data['name'];

              //Validando o email
              if($user->email != $data['email']){

                  //Verificando se email já existe na tabela
                  $hasEmail = User::where('email', $data['email'])->get();

                  //Verificando se foi retornado algum email dessa linha acima
                  if(count($hasEmail) === 0){
                     //Alterando o email usuário
                      $user->email = $data['email'];
                  }
                  else{
                      $validator->errors()->add('email', __('validation.unique', [
                          'atribute' => 'email'                      

                      ]));                   
                  }

              }
              
              //Validação da senha
              if(!empty($data['password']))
              {
                  if(strlen($data['password']) >= 4)
                  {
                      //Verificando se a senha e a senha de confirmação são iguais
                      if($data['password'] === $data['password_confirmation'])
                      {
                          //Armazenando a senha
                          $user->password = hash::make($data['password']);
                      }
                      else
                      {
                          $validator->errors()->add('password', __('validation.confirmed', [
                              'atribute' => 'email'

                          ])); 
                      }
                  }
                  else
                  {
                      $validator->errors()->add('password', __('validation.min.string', [
                          'atribute' => 'password',
                          'min' => 4
                      ]));                   
                  }
              }

              if(count($validator->errors()) > 0)
              {
                  return redirect()->route('profile', [
                      'user' => $loggedId
                  ])->withErrors($validator);
              }


              $user->save();

              return redirect()->route('profile')->with('warning', 'Informações Alteradas com Sucesso!');
          }

          return redirect()->route('profile');  
      }
}