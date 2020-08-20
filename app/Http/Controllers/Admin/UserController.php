<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator; //Chamando a classe do validator
use Illuminate\Support\Facades\Hash; //Chamando a classe do Hash
use Illuminate\Support\Facades\Auth; //Pegando a classe Auth


class UserController extends Controller
{

    public function __construct()
    {
        //Sem estar logado nós não conseguiremos acessar esse controller (verifica se o cara está logado)
        $this->middleware('auth'); 
        $this->middleware('can:edit-users');         
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(2); //Antes era User::all();
        $loggedId = Auth::id(); //Pegando o usuário logado

        return view('admin.users.index', ['users' => $users, 'loggedId' => $loggedId]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       	return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	//Recebendo os dados do request
        $data = $request->only([
        	'name',
        	'email',
        	'password',
        	'password_confirmation'
        ]);

        //Validando os dados (Chamamos a classe Validator lá em cima)
        $validator = Validator::make($data, [
        	'name' => ['required', 'string', 'max:100'],
        	'email' => ['required', 'string', 'email', 'max:200', 'unique:users'],
        	'password' => ['required', 'string', 'min:4', 'confirmed']

        ]);

        //Verificando se deu falha na validação
        if($validator->fails())
        {
        	return redirect()->route('users.create')->withErrors($validator)->withInput();
        }

        //Inserindo o usuário
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']); //Usamos a classe hash, que importamos lá em cima, para hashear a senha
        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user  = User::find($id);

        if($user)      
            return view('admin.users.edit', ['user' => $user]);
      

        return redirect()->route('users.index');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $user = User::find($id);

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
                return redirect()->route('users.edit', [
                    'user' => $id
                ])->withErrors($validator);
            }


            $user->save();
       }

       return redirect()->route('users.index');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Verificando se estamos apagando o usuários que estamos logados (isso poderia dar merda)
        //Pegando o id do usuário que está logado e verificando se é iguao ao que veio na requisição
        $loggedId = Auth::id();

        if($loggedId != $id) 
        {
            $user = User::find($id);
            $user->delete();
        }

        return redirect()->route('users.index');

    }
}
