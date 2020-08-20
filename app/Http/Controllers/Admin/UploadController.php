<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function imageUpload(Request $request)
    {
    	$request->validate([
    		'file' => 'required|image|mimes:jpeg,jpg,png' //O mime é o tipo de arquivo que aceitará
    	]);

    	//Gerando o nome da imagem
    	$ext = $request->file->extension(); //Pegando a extensão do arquivo
    	$imageName = time().'.'.$ext;

    	//Movendo o arquivo da pasta temporária de upload para a pasta que nós criamos
    	$request->file->move(public_path('media/images'), $imageName);

    	//Gerando e retornando o link completo do arquivo
    	return [
    		'location' => asset('media/images/'.$imageName)
    	];

    }
}
