<?php

$this->group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function(){
    $this->post('aisp', 'AispController@searchAisp')->name('aisp.search');
    $this->get('aisp', 'AispController@index')->name('admin.aisp');
    
    $this->get('cpr', 'CprController@index')->name('admin.cpr');
    
    $this->post('opm', 'OpmController@searchOpm')->name('opm.search');
    $this->get('opm', 'OpmController@index')->name('admin.opm');
    
    $this->get('/', 'AdminController@index')->name('admin.home');

});

$this->group(['middleware' => ['auth'], 'namespace' => 'Servicooperacional', 'prefix' => 'servico'], function(){
    $this->get('listarocorrencias','OcorrenciaController@listar')->name('servico.listarocorrencias');
    $this->get('ocorrencia/{id?}/edit','OcorrenciaController@edit')->name('servico.ocorrencia.edit');
    $this->get('ocorrencia/{id?}/excluirenv','OcorrenciaController@excluirenv')->name('servico.ocorrencia.excluirenv');
    $this->get('ocorrencia/{id?}/excluirdroga','OcorrenciaController@excluirdroga')->name('servico.ocorrencia.excluirdroga');
    $this->get('ocorrencia/{id?}/detalhe','OcorrenciaController@detalhe')->name('servico.ocorrencia.detalhe');
    $this->get('ocorrencia','OcorrenciaController@index')->name('servico.ocorrencia');
    $this->post('ocorrencia-salvar','OcorrenciaController@salvar')->name('servico.ocorrencia.salvar');
    $this->get('ocorrencia/{id?}/excluir','OcorrenciaController@excluir')->name('servico.ocorrencia.excluir');
    $this->post('ocorrencia-pesquisar', 'OcorrenciaController@search')->name('servico.ocorrencia.search');

    $this->get('escala','OcorrenciaController@escala')->name('servico.escala.index');
    $this->get('produtividade','OcorrenciaController@produtividade')->name('servico.produtividade.index');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Site', 'prefix' => 'home'], function(){
    $this->get('/','SGCOMController@home')->name('auth.home');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Frotas', 'prefix' => 'frota'], function(){
    $this->get('lista','FrotaController@index')->name('frota.index');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Cvli', 'prefix' => 'cvli'], function(){
    $this->get('index','CvliController@index')->name('cvli.index');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Cvp', 'prefix' => 'cvp'], function(){
    $this->get('index','CvpController@index')->name('cvp.index');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'PainelGestao', 'prefix' => 'painel'], function(){
    $this->get('index','PainelGestaoController@index')->name('painel.index');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Inteligencia', 'prefix' => 'inteligencia'], function(){
    $this->get('index','InteligenciaController@index')->name('inteligencia.index');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Armamento', 'prefix' => 'armas'], function(){
    $this->get('lista','ArmamentoController@lista')->name('armas.lista');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Recursoshumanos', 'prefix' => 'rh'], function(){
    $this->get('listageral','EfetivoController@index')->name('rh.listar');
    $this->any('listageral-search', 'EfetivoController@searchMatricula')->name('rh.searchMatricula');
    $this->get('listageral/{id?}/edit','EfetivoController@edit')->name('rh.edit');
    $this->get('listageral/{id?}/detalhe','EfetivoController@detalhe')->name('rh.detalhe');
    $this->post('salvar','EfetivoController@salvar')->name('rh.salvar');
});

$this->get('meu-perfil', 'Admin\UserController@profile')->name('profile')->middleware('auth');
$this->post('update-perfil', 'Admin\UserController@update')->name('profile.update')->middleware('auth');

$this->get('/', 'Site\SGCOMController@index')->name('home');

Auth::routes();


