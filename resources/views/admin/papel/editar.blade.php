@extends('adminlte::page')

@section('title', 'SGCOM | Admin')

@section('content_header')
    <h1>Papeis</h1>
    <ol class="breadcrumb">
	<li><a href="{{route('admin.papeis')}}">Papeis</a></li>
        <li><a href="">papel</a></li>
    </ol>
@stop
@section('content')
<div class="container">
	<h2 class="center">Editar Papel</h2>

	<div class="row">
		<form action="{{ route('admin.papeis.update') }}" method="POST">
			<input type="hidden" value="{{$papel->id}}" id="id" name="id">
		{{csrf_field()}}
	
		<div class="box">
		@include('admin.papel._form')
<br>
		<button class="btn btn-primary">Atualizar</button>

	</div>	
		</form>
			
	</div>
	
</div>
	

@endsection