<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;
use Illuminate\Support\Facades\Validator;


class SettingController extends Controller
{
    public function __contruct()
    {
    	//Middleware para só deixar acessar se estiver logado
    	$this->middleware('auth');
    }

    public function index()
    {
    	//Pegando as configurações da tabela settings
    	$settings = [];

    	$dbsettings = Setting::get(); //Usamos o get pois o find sem argumento não funciona

    	foreach($dbsettings as $dbsetting)
    	{
    		$settings[$dbsetting['name']] = $dbsetting['content'];
    	}

    	return view('admin.settings.index',
    		['settings' => $settings]
    	);
    }

    public function save(Request $request)
    {
    	//Recebendo os dados da requisição
    	$data = $request->only(['title','subtitle','email','bg-color','text-color']);

    	//Validando essas informações
    	$validator = $this->validator($data);

    	//Verificando se a validação deu certo
    	if($validator->fails())
    	{
    		//Redirecionando no caso de falha
    		return redirect()->route('settings')->withErrors($validator);
    	}
    		
    	foreach($data as $item => $value)
    	{
    		Setting::where('name', $item)->update([
    			'content' => $value
    		]);
    	}


    	//Redirecionando no caso de sucesso
    	return redirect()->route('settings')
    	->with('warning', 'Informações alteradas com sucesso!');
    }

    //Método que valida os dados
    protected function validator($data)
    {
    	//Validando os dados com a classe Validator (que foi importada lá no topo)
    	return Validator::make($data, [
    		'title' => ['string', 'max:100'],
    		'subtitle' => ['string', 'max:100'],
    		'email' => ['string', 'email'],
    		'bg-color' => ['string', 'regex:/#[a-zA-Z0-9]{6}/i'], //Esse regez é para só aceitar 6 caracteres e sendo número ou letras
    		'text-color' => ['string', 'regex:/#[a-zA-Z0-9]{6}/i']

    	]);
    }
}
