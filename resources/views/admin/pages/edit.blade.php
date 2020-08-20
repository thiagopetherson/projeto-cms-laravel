@extends('adminlte::page')

@section('title','Editar Página')

@section('content_header')
	
	<h1>
		Editar Página
	</h1>
	
@endsection

@section('content')
		

		@if($errors->any())

			<div class="alert alert-danger">
				<ul>
					<h5><i class="icon fas fa-ban"></i> Ocorreu um erro</h5>
					@foreach($errors->all() as $error)
						<li>{{$error}}</li>
					@endforeach
				</ul>
			</div>

		@endif

	
		<div class="card">
			<!--
			<div class="card-header">

			</div>
			-->
		
			<div class="card-body">
				
				<form action="{{route('pages.update', ['page'=>$page->id])}}" method="POST" class="form-horizontal">

					@csrf
					@method('PUT')

					<div class="form-group row">					
						<label class="col-sm-2 col-form-label">Título</label>
						<div class="col-sm-10">
							<input type="text" name="title" value="{{$page->title}}" class="form-control @error('title') is-invalid @enderror" />
						</div>					
					</div>

					<div class="form-group row">					
						<label class="col-sm-2 col-form-label">Corpo</label>
						<div class="col-sm-10">
							<textarea name="body" class="form-control body-field">{{$page->body}}</textarea>							
						</div>					
					</div>					

					<div class="form-group row">			
						<label class="col-sm-2 col-form-label"></label>
						<div class="col-sm-10">
							<input type="submit" value="Salvar" class="btn btn-success" />
						</div>			
					</div>

				</form>

			</div>

		</div>


		<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>

		<script type="text/javascript">
			tinymce.init({
				selector:"textarea.body-field", //Pegando a textarea
				height: 300, //definindo a altura
				menubar: false, //Remove o menu superior de estilização
				plugins:['link','table','image','autoresize','lists'], //Chamando os plugins
				toolbar:'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | table | link image | bullist numlist', //Definindo o toolbar de estilização
				content_css:[
					'{{asset('assets/css/content.css')}}' //Chamando um arquivo CSS
				],
				images_upload_url:'{{route('imageupload')}}',//definindo qual a url fará o upload (será uma requisição AJAX) [Botamos ali a rota. Tem que ser rota de API]
				images_upload_credentials:true, //Serve para mandar o cookie (para só aceitar upload de usuário que estiver logado)
				convert_urls: false //Impede a conversão da URL e diversos erros (Usa as url originais)
			});

		</script>



@endsection
