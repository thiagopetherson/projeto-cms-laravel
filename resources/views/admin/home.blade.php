@extends('adminlte::page')

@section('plugins.Chartjs', true)

@section('title','Admin')

@section('content_header')
	
	<div class="row">

		<div class="col-md-6">
				<h1>Dashboard</h1>
		</div>

		<div class="col-md-6">
			<form method="POST" action="{{route('homesearch')}}">

				@csrf				
					<select onChange="this.form.submit()" class="form-control float-right" name="dataFiltro" id="dataFiltro">
						<option {{$dateInterval==30?'selected="selected"':''}} value="30">Últimos 30 dias</option>
						<option {{$dateInterval==60?'selected="selected"':''}} value="60">Últimos 60 dias</option>
						<option {{$dateInterval==90?'selected="selected"':''}} value="90">Últimos 90 dias</option>
						<option {{$dateInterval==120?'selected="selected"':''}} value="120">Últimos 120 dias</option>
					</select>		

			</form>
		</div>	
	</div>
	
@endsection

@section('content')
	
	<div class="row">
		<div class="col-md-3">
			<div class="small-box bg-info">
				<div class="inner">
					<h3>{{$visitsCount}}</h3>
					<p>Acessos</p>
				</div>
				<div class="icon">
					<i class="fa fa-fw fa-eye"></i>
				</div>
			</div>	
		</div>

		<div class="col-md-3">
			<div class="small-box bg-success">
				<div class="inner">
					<h3>{{$onlineCount}}</h3>
					<p>Usuários Online</p>
				</div>
				<div class="icon">
					<i class="fa fa-fw fa-heart"></i>
				</div>
			</div>	
		</div>

		<div class="col-md-3">
			<div class="small-box bg-warning">
				<div class="inner">
					<h3>{{$pageCount}}</h3>
					<p>Páginas</p>
				</div>
				<div class="icon">
					<i class="fa fa-fw fa-sticky-note"></i>
				</div>
			</div>	
		</div>

		<div class="col-md-3">
			<div class="small-box bg-danger">
				<div class="inner">
					<h3>{{$userCount}}</h3>
					<p>Usuários</p>
				</div>
				<div class="icon">
					<i class="fa fa-fw fa-user"></i>
				</div>
			</div>	
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<div class="card-title">Páginas mais Visitadas</div>						
				</div>	
				<div class="card-body">
					<canvas id="pagePie"></canvas>
				</div>
			</div>	
		</div>

		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<div class="card-title">Sobre o Sistema</div>						
				</div>	
				<div class="card-body">
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever.
				</div>
			</div>	
		</div>
	</div>

	<script>
		window.onload = function()
		{
			let ctx = document.getElementById('pagePie').getContext('2d');
			window.pagePie = new Chart(ctx, {
				type:'pie', //Tipo do gráfico
				data:{
					datasets:[{ //Os dados que preencherão o gráfico
						data:{{$pageValues}},
						backgroundColor: '#0000FF'

					}],
					labels:{!!$pageLabels!!} //As partes do gráfico 
					//(OBS: Fizemos o blade daquele forma ali (com !! e com só um {} porque estava dando erro de escape)

				},
				options:{
					responsive:true, //Deixando responsivo
					legend:{
						display: false //Tirando a legenda
					}

				}


			});
		}

	</script>
	
@endsection

