@extends('adminlte::page')

@section('title','Configurações')

@section('content_header')
	
	<h1>Configurações</h1>
	
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

	@if(session('warning'))

		<div class="alert alert-success">				
				{{session('warning')}}			
		</div>

	@endif

	<div class="card">
		<div class="card-body">

			<form action="{{route('settings.save')}}" method="POST" class="form-horizontal">

					@csrf
					@method('PUT')

					<div class="form-group row">					
						<label class="col-sm-2 col-form-label">Título do Site</label>
						<div class="col-sm-10">
							<input type="text" name="title" value="{{$settings['title']}}" class="form-control" />
						</div>					
					</div>

					<div class="form-group row">					
						<label class="col-sm-2 col-form-label">Subtítulo</label>
						<div class="col-sm-10">
							<input type="text" name="subtitle" value="{{$settings['subtitle']}}" class="form-control" />
						</div>					
					</div>

					<div class="form-group row">					
						<label class="col-sm-2 col-form-label">Email para contato</label>
						<div class="col-sm-10">
							<input type="email" name="email" value="{{$settings['email']}}" class="form-control" />
						</div>					
					</div>

					<div class="form-group row">					
						<label class="col-sm-2 col-form-label">Cor do Fundo</label>
						<div class="col-sm-1">
							<input type="color" name="bg-color" value="{{$settings['bg-color']}}" class="form-control" />
						</div>					
					</div>

					<div class="form-group row">					
						<label class="col-sm-2 col-form-label">Cor do Texto</label>
						<div class="col-sm-1">
							<input type="color" name="text-color" value="{{$settings['text-color']}}" class="form-control" />
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
	
@endsection

