@extends('adminlte::page')

@section('title', 'SGCOM | Perfil')

@section('content_header')
    <h1>Perfil do Usuário</h1>
    <ol class="breadcrumb">
        <li><a href="">Perfil</a></li>
        <li><a href="">Meus dados</a></li>
    </ol>
@stop

@section('content')
<h1>Dados pessoais</h1>

@include('site.includes.alerts')

<div class="box">

<section class="content">
    <form role="form" method="POST" action="{{ route('profile.update')}}" enctype="multipart/form-data" >
                        {!! csrf_field() !!}
    <div class="col-xs-12">
        <label for="name">Nome:</label>
        {{ auth()->user()->efetivo->nome }}
    </div>
    
    <div class="col-xs-12">
            <label for="email">Email:</label>
            {{ auth()->user()->email }}
        </div>
        
  
        
    <div class="col-xs-12">
        <label for="image">Foto:</label>
      
        @if(auth()->user()->image != null)
            <img src="{{url("img_perfil/".auth()->user()->image)}}" height="50" width="50">
            @else
            <img src="{{url("fotos/sem_foto.jpg")}}" height="50" width="50">
         @endif
       
            <input type="file" name="image" id="image" class="form-group">
    </div>
    <div class="col-xs-12">
        <button type="submit" class="btn btn-info">Atualizar perfil</button>
    </div>
</form>
        </section>
</div>
@stop