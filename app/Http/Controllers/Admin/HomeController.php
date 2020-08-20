<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //Chamando a classe de Autenticação
use App\Visitor;
use App\Page;
use App\User;


class HomeController extends Controller
{

	public function __construct()
	{
		//Middleware de autenticação (ou seja, o cara tem que estar logado para acessar esse Controller)
		$this->middleware('auth'); 
	}

   
    public function index(Request $request)
    {
    	$visitsCount = 0;
    	$onlineCount = 0;
    	$pageCount = 0;
    	$userCount = 0;
    	$data_filtro = intval($request->input('dataFiltro',30));


		//Para o caso de tentarem burlar no código fonte do front  	
    	if($data_filtro > 120)
    	{
    		$data_filtro = 120;
    	}
    	
    	$dataFiltro = date('Y-m-d H:i:s', strtotime('-'.$data_filtro.' days'));    	

    	//Pegando data de hoje
    	$hoje = date('Y-m-d H:i:s');

       	//Pegando Visitas pelo filtro
    	$visitsCount = Visitor::whereBetween('date_access', [$dataFiltro, $hoje])->count(); 

    	//Contagem de Usuários Online (Aqui vamos pegar a data de 5 minutos atrás)
    	$datelimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));
    	//Aqui vamos pegar os usuários que acessaram a página nos últimos 5 minutos (só que pegaremos por diferentes IP)
    	$onlineList = Visitor::select('ip')->where('date_access', '>=', $datelimit)->groupBy('ip')->get(); 
    	//Aqui contamos quantos usuários fizeram isso
    	$onlineCount = count($onlineList);

    	//Contagem de Páginas
    	$pageCount = Page::count();
    	
    	//Contagem de Usuários
    	$userCount = User::count();

    	//Contagem para o PagePie
    	$pagePie = [];
    	$visitsAll = Visitor::selectRaw('page, count(page) as c')->whereBetween('date_access', [$dataFiltro, $hoje])->groupBy('page')->get();

    	foreach($visitsAll as $visit)
    	{
    		$pagePie[$visit['page']] = $visit['c'];
    	}    

    	$pageLabels = json_encode(array_keys($pagePie)); //Pegando as keys de $pagePie
    	$pageValues = json_encode(array_values($pagePie)); //Pegando os Values de $pagePie

    	return view('admin.home',[
    		'visitsCount' => $visitsCount,
    		'onlineCount' => $onlineCount,
    		'pageCount' => $pageCount,
    		'userCount' => $userCount,
    		'pageLabels' => $pageLabels,
    		'pageValues' => $pageValues,
    		'dateInterval' => $data_filtro
        ]);
    }
}
