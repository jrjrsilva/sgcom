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
        <input type="text" name="name" value="{{ auth()->user()->name }}">
    </div>
    
    <div class="col-xs-12">
            <label for="email">Email:</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}">
        </div>
        
    <div class="col-xs-12">
            <label for="password">Senha:</label>
            <input type="password" name="password" value="">
        </div>
        
    <div class="col-xs-12">
        @if(auth()->user()->image != null)
    <img src="{{ url('storage/users/'.auth()->user()->image)}}" alt="{{ auth()->user()->name}}" style="max-width: 50px;">
        @endif
            <label for="image">Foto:</label>
            <input type="file" name="image[]" id="image" class="form-group">
            <input type="file" name="image[]" id="image" class="form-group">
            <input type="file" name="image[]" id="image" class="form-group">
            <input type="file" name="image[]" id="image" class="form-group">
            <input type="file" name="image[]" id="image" class="form-group">
        </div>
    <div class="col-xs-12">
        <button type="submit" class="btn btn-info">Atualizar perfil</button>
    </div>
</form>
        </section>
</div>
@stop