<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Page;
use Illuminate\Support\Facades\Validator; //Chamando a classe do validator
use Illuminate\Support\Str; //Chamando a classe do Str (ela manipula string)
use Illuminate\Support\Facades\Auth; //Pegando a classe Auth

class PageController extends Controller
{
   

    public function __construct()
    {
        //Sem estar logado nós não conseguiremos acessar esse controller (verifica se o cara está logado)
        $this->middleware('auth');             
    }



    public function index()
    {
        $pages = Page::paginate(2); //Antes era Paginate::all();
       
        return view('admin.pages.index', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
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
            'title',
            'body'           
        ]);

        //Criando o Slug (Esse segundo parâmetro é o separador que fica entre uma palavra e outra)
        $data['slug'] = Str::slug($data['title'], '-'); 

        //Validando os dados (Chamamos a classe Validator lá em cima)
        $validator = Validator::make($data, [
            'title' => ['required', 'string', 'max:100'],
            'body' => ['string'],
            'slug' => ['required', 'string', 'max:100', 'unique:pages']

        ]);

        //Verificando se deu falha na validação
        if($validator->fails())
        {
            return redirect()->route('users.create')->withErrors($validator)->withInput();
        }

        //Criando a página
        $page = new Page;
        $page->title = $data['title'];
        $page->slug = $data['slug'];
        $page->body = $data['body'];
        $page->save();

        return redirect()->route('pages.index');
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
        $page  = Page::find($id);

        if($page)      
            return view('admin.pages.edit', ['page' => $page]);
      

        return redirect()->route('pages.index');
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

       $page = Page::find($id);

       if($page)
       {
            //Só aceitará esses campos
            $data = $request->only(['title','body']);

            //Validando os dados e verificando a necessidade de alterar o Slug
            if($page['title'] !== $data['title'])
            {
                //Se o título foi alterado, automaticamente temos que mudar o slug
                $data['slug'] = Str::slug($data['title'], '-');

                //Validando os dados que chegaram (title, body e slug)
                $validator = Validator::make($data, [                              
                    'title' => ['required', 'string', 'max:100'],
                    'body' => ['string'],
                    'slug' => ['required', 'string', 'max:100', 'unique:pages']
                ]);
            }
            else
            {
                 //Validando os dados que chegaram (title e body)
                $validator = Validator::make($data, [                              
                    'title' => ['required', 'string', 'max:100'],
                    'body' => ['string']
                ]);
            }
                      
            //Verificando se deu falha na validação
            if($validator->fails())
            {
                return redirect()->route('pages.edit',[
                    'page' => $id

                ])->withErrors($validator)->withInput();
            }

            //Alterando o title
            $page->title = $data['title'];

            //Alterando o body
            $page->title = $data['body'];

            //Verificando se é necessário atualizar o slug
            if(!empty($data['slug']))
            {
                //Alterando o slug
                $page->slug = $data['slug'];
            }
          
            $page->save();
       }

       return redirect()->route('pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        
        $page = Page::find($id);       
        $page->delete();
        
        return redirect()->route('pages.index');
        
    }
}
