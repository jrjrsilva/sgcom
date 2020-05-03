<?php

use Illuminate\Support\Facades\Auth;

$this->group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    $this->post('aisp', 'AispController@searchAisp')->name('aisp.search');
    $this->get('aisp', 'AispController@index')->name('admin.aisp');

    $this->get('cpr', 'CprController@index')->name('admin.cpr');

    $this->post('opm', 'OpmController@searchOpm')->name('opm.search');
    $this->get('opm', 'OpmController@index')->name('admin.opm');



    $this->get('usuarios', 'UserController@index')->name('admin.usuarios');
    $this->get('usuarios/{id}', 'UserController@status')->name('admin.usuarios.status');
    $this->post('usuarios/salvar', 'UserController@salvar')->name('admin.usuarios.salvar');
    $this->get('usuarios/{id}/edit', 'UserController@edit')->name('admin.usuarios.edit');
    $this->post('usuarios', 'UserController@search')->name('admin.usuarios.search');

    $this->get('usuarios/papel/{id}', 'UserController@papel')->name('admin.usuarios.papel');
    $this->post('usuarios/papel/{papel}', 'UserController@papelSalvar')->name('admin.usuarios.papelSalvar');
    $this->delete('usuarios/papel/{usuario}/{papel}', 'UserController@papelDestroy')->name('admin.usuarios.papelDestroy');


    $this->get('papeis/novo', 'PapelController@show')->name('admin.papeis.novo');
    $this->get('papeis/{id}', 'PapelController@edit')->name('admin.papeis.edit');
    $this->get('papeis', 'PapelController@index')->name('admin.papeis');
    $this->post('papeis/salvar', 'PapelController@papelSalvar')->name('admin.papeis.salvar');

    $this->post('papeis/atualizar', 'PapelController@update')->name('admin.papeis.update');
    $this->delete('papeis/{papel}', 'PapelController@papelDestroy')->name('admin.papeis.papelDestroy');


    $this->get('papeis/permissao/{id}', 'PapelController@permissao')->name('admin.papeis.permissao');
    $this->post('papeis/permissao/{permissao}', 'PapelController@permissoesStore')->name('admin.papeis.permissao.store');
    $this->delete('papeis/permissao/{usuario}/{permissao}', 'PapelController@permissoesDestroy')->name('admin.papeis.permissao.destroy');


    $this->get('/', 'AdminController@index')->name('admin.home');
    $this->get('/veiculo/modelos/{id}', 'VeiculoController@getModelosVeiculo')->name('admin.modelosveiculo');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Servicooperacional', 'prefix' => 'servico'], function () {
    $this->get('listarocorrencias', 'OcorrenciaController@listar')->name('servico.listarocorrencias');
    $this->get('ocorrencia/{id?}/edit', 'OcorrenciaController@edit')->name('servico.ocorrencia.edit');
    $this->get('ocorrencia/{id?}/excluirenv', 'OcorrenciaController@excluirenv')->name('servico.ocorrencia.excluirenv');
    $this->get('ocorrencia/{id?}/excluirdroga', 'OcorrenciaController@excluirdroga')->name('servico.ocorrencia.excluirdroga');
    $this->get('ocorrencia/{id?}/detalhe', 'OcorrenciaController@detalhe')->name('servico.ocorrencia.detalhe');
    $this->get('ocorrencia', 'OcorrenciaController@index')->name('servico.ocorrencia');
    $this->post('ocorrencia-salvar', 'OcorrenciaController@salvar')->name('servico.ocorrencia.salvar');
    $this->get('ocorrencia/{id?}/excluir', 'OcorrenciaController@excluir')->name('servico.ocorrencia.excluir');
    $this->any('ocorrencia-pesquisar', 'OcorrenciaController@search')->name('servico.ocorrencia.search');

    $this->get('escala', 'OcorrenciaController@escala')->name('servico.escala.index');
    $this->get('produtividade', 'OcorrenciaController@produtividade')->name('servico.produtividade.index');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Site', 'prefix' => 'home'], function () {
    $this->get('/', 'SGCOMController@home')->name('auth.home');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Frotas', 'prefix' => 'frota'], function () {
    $this->get('index', 'FrotaController@index')->name('frota.index');
    $this->get('lista', 'FrotaController@lista')->name('frota.lista');
    $this->post('pesquisar', 'FrotaController@search')->name('frota.search');
    $this->get('edit/{id}', 'FrotaController@edit')->name('frota.edit');
    $this->get('edit-km/{id}', 'FrotaController@editKM')->name('frota.edit.km');
    $this->post('salvarKM', 'FrotaController@salvarKM')->name('frota.salvar.km');
    $this->get('edit-revisao/{id}', 'FrotaController@editRevisao')->name('frota.edit.revisao');
    $this->post('salvarRevisao', 'FrotaController@salvarRevisao')->name('frota.salvar.revisao');
    $this->get('edit-historico/{id}', 'FrotaController@editHistorico')->name('frota.edit.historico');
    $this->post('salvarHistorico', 'FrotaController@salvarHistorico')->name('frota.salvar.historico');
    $this->post('salvar', 'FrotaController@salvar')->name('frota.salvar');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Cvli', 'prefix' => 'cvli'], function () {
    $this->get('index', 'CvliController@index')->name('cvli.index');
    // $this->get('json','CvliController@json')->name('cvli.json');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Cvp', 'prefix' => 'cvp'], function () {
    $this->get('index', 'CvpController@index')->name('cvp.index');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'PainelGestao', 'prefix' => 'painel'], function () {
    $this->get('index', 'PainelGestaoController@index')->name('painel.index');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Inteligencia', 'prefix' => 'inteligencia'], function () {
    $this->get('criminosos', 'InteligenciaController@index')->name('inteligencia.criminosos');
    $this->get('crim_excluir/{id}', 'InteligenciaController@excluir')->name('inteligencia.crim.excluir');
    $this->get('crim_hist_excluir/{id}', 'InteligenciaController@excluirHist')->name('inteligencia.crim.hist.excluir');
    $this->delete('hist_excluir', 'InteligenciaController@exHist')->name('inteligencia.hist.excluir');
    $this->get('crim_edit/{id}', 'InteligenciaController@edit')->name('inteligencia.crim.edit');
    $this->get('crim_view/{id}', 'InteligenciaController@view')->name('inteligencia.crim.view');
    $this->get('crim_form', 'InteligenciaController@form')->name('inteligencia.form');
    $this->post('crim_salvar', 'InteligenciaController@salvarCriminoso')->name('inteligencia.crim.salvar');
    $this->post('crim_processual_salvar', 'InteligenciaController@salvarProcessualCriminoso')->name('inteligencia.crim.processual.salvar');
    $this->get('crim_status_processual/{id}', 'InteligenciaController@buscarStatusProcessual')->name('inteligencia.buscar.status.processual');
    $this->post('album_salvar', 'InteligenciaController@salvarAlbumCriminoso')->name('inteligencia.album.salvar');
    $this->delete('album_delete', 'InteligenciaController@deleteAlbumCriminoso')->name('inteligencia.album.delete');
    $this->get('download/{id}', 'InteligenciaController@downloadAlbumCriminoso')->name('inteligencia.album.download');
    $this->any('crim_search', 'InteligenciaController@search')->name('inteligencia.crim.search');
    $this->any('crim_search_galeria', 'InteligenciaController@searchGaleria')->name('inteligencia.crim.searchGaleria');


    $this->post('doc_salvar', 'InteligenciaController@salvarDocCriminoso')->name('inteligencia.doc.salvar');
    $this->delete('doc_delete', 'InteligenciaController@deleteDocCriminoso')->name('inteligencia.doc.delete');
    $this->get('doc_download/{id}', 'InteligenciaController@downloadDocCriminoso')->name('inteligencia.doc.download');
    $this->get('baralho', 'InteligenciaController@baralho')->name('inteligencia.baralho');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Armamento', 'prefix' => 'armas'], function () {
    $this->get('lista', 'ArmamentoController@lista')->name('armas.lista');
    $this->get('view/{id}', 'ArmamentoController@view')->name('armas.view');
    $this->get('index', 'ArmamentoController@index')->name('armas.index');
    $this->any('pesquisar', 'ArmamentoController@search')->name('armas.search');
    $this->get('edit/{id}', 'ArmamentoController@edit')->name('armas.edit');
    $this->post('salvar', 'ArmamentoController@salvar')->name('armas.salvar');
    $this->get('edit-historico/{id}', 'ArmamentoController@editHistorico')->name('armas.edit.historico');
    $this->post('salvarHistorico', 'ArmamentoController@salvarHistorico')->name('armas.salvar.historico');
});

$this->group(['middleware' => ['auth'], 'namespace' => 'Recursoshumanos', 'prefix' => 'rh'], function () {
    $this->get('listageral', 'EfetivoController@index')->name('rh.listar');
    $this->any('listageral-search', 'EfetivoController@search')->name('rh.search');
    $this->get('listageral/{id?}/edit', 'EfetivoController@edit')->name('rh.edit');
    $this->get('listageral/{id?}/detalhe', 'EfetivoController@detalhe')->name('rh.detalhe');
    $this->post('salvar', 'EfetivoController@salvar')->name('rh.salvar');
    $this->get('previsaoefetivo/{id}', 'EfetivoController@getPrevisao')->name('rh.previsao');
    $this->get('realefetivo/{id}', 'EfetivoController@getEfetivoReal')->name('rh.efetivoReal');
    $this->get('removerdaopm/{id}', 'EfetivoController@removerDaOpm')->name('rh.removerDaOpm');
    $this->get('resumoEfetivo', 'EfetivoController@resumoEfetivo')->name('rh.resumoEfetivo');

    $this->get('aniversariantes', 'EfetivoController@aniversariantes')->name('rh.aniversariantes');
    $this->any('pesquisar-aniversario', 'EfetivoController@pesquisaAniversarios')->name('rh.pesquisaAniversarios');

    $this->get('previsao-ferias', 'EfetivoController@previsaoFerias')->name('rh.previsaoFerias');

    $this->any('pesquisa-previsao-ferias', 'EfetivoController@pesquisaPrevisaoFerias')->name('rh.pesquisaPrevisaoFerias');

    $this->get('historico/{id}', 'EfetivoController@historicopolicial')->name('rh.historico');
    $this->get('historiconovo/{id}', 'EfetivoController@historiconovo')->name('rh.historiconovo');
    $this->any('historico-search', 'EfetivoController@searchHistorico')->name('rh.searchHistorico');
    $this->post('salvarhistorico', 'EfetivoController@salvarhistorico')->name('rh.salvarhistorico');
});


$this->post('admin/efetivo/salvar', 'Recursoshumanos\EfetivoController@salvarMovimentacao')->name('rh.salvarMovimentacao');
$this->get('admin/efetivo', 'Recursoshumanos\EfetivoController@policiais')->name('rh.policiais');
$this->any('admin/efetivo/search', 'Recursoshumanos\EfetivoController@getPolicial')->name('rh.getPolicial');
$this->get('admin/efetivo/{id?}', 'Recursoshumanos\EfetivoController@editPolicial')->name('rh.editPolicial');

$this->get('meu-perfil', 'Admin\UserController@profile')->name('profile')->middleware('auth');
$this->post('update-perfil', 'Admin\UserController@update')->name('profile.update')->middleware('auth');
$this->get('picture', 'Admin\UserController@getPicture')->name('picture')->middleware('auth');
$this->get('obtercep/{cep}', 'Recursoshumanos\EfetivoController@getCep')->name('obtercep')->middleware('auth');



$this->get('/', 'Site\SGCOMController@index')->name('home');
$this->get('/rh/matricula/{id}', 'Recursoshumanos\EfetivoController@getMatricula')->name('register.matricula');

$this->get('/cvli/json', 'Cvli\CvliController@json')->name('cvli.json');


$this->get('/efetivo/secoes/{id}', 'Recursoshumanos\EfetivoController@getSecoes')->name('rh.getSecoes');

Auth::routes();
