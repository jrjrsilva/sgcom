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
    $this->get('dashboard','OcorrenciaController@dashboard')->name('servico.dashboard');
    $this->get('ocorrencia/{id?}/edit','OcorrenciaController@edit')->name('servico.ocorrencia.edit');
    $this->get('ocorrencia/{id?}/excluirenv','OcorrenciaController@excluirenv')->name('servico.ocorrencia.excluirenv');
    $this->get('ocorrencia/{id?}/excluiredroga','OcorrenciaController@excluirdroga')->name('servico.ocorrencia.excluirdroga');
    $this->get('ocorrencia/{id?}/detalhe','OcorrenciaController@detalhe')->name('servico.ocorrencia.detalhe');
    $this->get('ocorrencia','OcorrenciaController@index')->name('servico.ocorrencia');
    $this->post('ocorrencia-salvar','OcorrenciaController@salvar')->name('servico.ocorrencia.salvar');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Site', 'prefix' => 'home'], function(){
    $this->get('/','SGCOMController@home')->name('auth.home');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'RecursosHumanos', 'prefix' => 'rh'], function(){
    $this->get('efetivo','EfetivoController@index')->name('rh.listar');
    $this->any('efetivo-search', 'EfetivoController@searchMatricula')->name('rh.searchMatricula');
});

    $this->get('/', 'Site\SGCOMController@index')->name('home');

Auth::routes();


