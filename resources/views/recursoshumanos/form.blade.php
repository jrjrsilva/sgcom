@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Gestão de Pessoal</h1>
    <ol class="breadcrumb">
    <li><a href="{{route('rh.listar')}}">Dashboard</a></li>
        <li><a href="">Efetivo</a></li>
    </ol>
@stop

@section('content')

    <h2>Cadastro</h2>
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

    <form role="form" method="POST" action="{{ route('rh.salvar')}}" >
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $efetivo->id or '' }}">
 <!--DADOS  DO POLICIAL-->   

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Dados do Policial</h3>
          @include('site.includes.alerts')
        </div><br>
        
        <div class="row">
        <div class="form-row">
            <div class="col-xs-2"> 
                <label for="gh">Grau Hierarquico</label>
              <select class="form-control" id="gh" name="gh" required >
                <option value="">Selecione</option>
                @foreach( $ghs as $gh )
                <option value="{{ $gh->id or ''}}" 
                  @isset($efetivo->grauhierarquico->id)
                    @if($efetivo->grauhierarquico->id == $gh->id)
                      selected 
                    @endif 
                  @endisset ><p> {{ $gh->sigla }} </p></option>
                @endforeach
              </select>
            </div> 

              <div class="col-xs-5">
                  <label for="nome">Nome</label>
              <input type="text" class="form-control" placeholder="Nome" required
              value="{{  $efetivo->nome or '' }}" id="nome" name="nome"> 
              </div>
        </div>
        <div class="form-row">
            <div class="col-xs-2">
                <label for="matricula">Matrícula</label>
            <input type="number" pattern="[0-9]" maxlength=9 class="form-control" placeholder="Informe a matricula" required
            value="{{  $efetivo->matricula or '' }}" id="matricula" name="matricula"> 
            </div>
        </div>
        </div>
        <br>
       <br>

        <div class="row">

              <div class="col-xs-2">
                <div class="input-group">
                        <label for="data_nascimento">Data de Nascimento</label>
                      <input type="date" class="form-control timepicker" placeholder="Selecione a Data"
                       id="data_nascimento" name="data_nascimento" value="{{$efetivo->datanascimento or '' }}"
                       
                       required>
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>  

              </div>

              <div class="col-xs-2">
                <div class="input-group">
                    <label for="data_admissao">Data de Admissão</label>
                      <input type="date" class="form-control timepicker" placeholder="Selecione a Data"
                       id="data_admissao" name="data_admissao" value="{{$efetivo->dataadmissao or '' }}"
                       
                       required>
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
              </div>         
            
              <div class="col-xs-1">
                  <label for="sexo">Sexo</label>
                <select class="form-control" id="sexo" name="sexo">
                    <option value="">Selecione</option>
                    <option value="M"  @if($efetivo->sexo == 'M')
                        selected 
                      @endif >M</option>
                    <option value="F"  @if($efetivo->sexo == 'F')
                        selected 
                      @endif >F</option>
                  </select>
              </div>

              <div class="col-xs-1">
                  <label for="fatorrh">Fator RH</label>
                <select class="form-control" id="fatorrh" name="fatorrh">
                    <option value="">Selecione</option>
                    <option value="+"  @if($efetivo->fatorrh == '+')
                        selected 
                      @endif >+</option>
                    <option value="-"  @if($efetivo->fatorrh == '-')
                        selected 
                      @endif >-</option>
                  </select>
              </div>

              <div class="col-xs-2">
                  <label for="tiposangue">Tipo de Sangue</label>
                <select class="form-control" id="tiposangue" name="tiposangue">
                    <option value="">Selecione</option>
                    <option value="A"  @if($efetivo->tiposangue == "A")
                        selected 
                      @endif >A</option>
                      <option value="AB"  @if($efetivo->tiposangue == "AB")
                        selected 
                      @endif >AB</option>
                      <option value="B"  @if($efetivo->tiposangue == "B")
                        selected 
                      @endif >B</option>
                    <option value="O"  @if($efetivo->tiposangue == "O")
                        selected 
                      @endif >O</option>
                    
                  </select>
              </div>
        </div> 
        <br>
<div class="row">
    <div class="col-xs-2">
        <label for="cnh">Número CNH</label>
      <input type="text" class="form-control" id="cnh"
       name="cnh" maxlength="11" value="{{$efetivo->cnh}}">
    </div>

  <div class="col-xs-2">
    <label for="categoriacnh">Categoria CNH</label>
  <select class="form-control" id="categoriacnh" name="categoriacnh">
      <option value="">Selecione</option>
      <option value="A"  @if($efetivo->categoria_cnh == "A")
          selected 
        @endif >A</option>
        <option value="AB"  @if($efetivo->categoria_cnh == "AB")
          selected 
        @endif >AB</option>
        <option value="AC"  @if($efetivo->categoria_cnh == "AC")
          selected 
        @endif >AC</option>
      <option value="AD"  @if($efetivo->categoria_cnh == "AD")
          selected 
        @endif >AD</option>
        <option value="AE"  @if($efetivo->categoria_cnh == "AE")
          selected 
        @endif >AE</option>
        <option value="B"  @if($efetivo->categoria_cnh == "B")
          selected 
        @endif >B</option>
        <option value="C"  @if($efetivo->categoria_cnh == "C")
          selected 
        @endif >C</option>
        <option value="D"  @if($efetivo->categoria_cnh == "D")
          selected 
        @endif >D</option>
        <option value="E"  @if($efetivo->categoria_cnh == "E")
          selected 
        @endif >E</option>
    </select>
</div>

<div class="col-xs-2">
    <div class="input-group">
        <label for="validadecnh">Data de Validade</label>
          <input type="date" class="form-control timepicker" placeholder="Selecione a Data"
           id="validadecnh" name="validadecnh" value="{{$efetivo->validade_cnh or '' }}"           
           >
          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
    </div>
  </div>

<div class="col-xs-2">
  <label for="ehmotorista">É Motorista?</label>
<select class="form-control" id="ehmotorista" name="ehmotorista">
    <option value="">Selecione</option>
    <option value="1"  @if($efetivo->eh_motorista == 1)
        selected 
      @endif >SIM</option>
    <option value="0"  @if($efetivo->eh_motorista == 0)
        selected 
      @endif >NÃO</option>
  </select>
</div>

<div class="col-xs-2">
  <label for="motoristatipo">Motorista Tipo</label>
<select class="form-control" id="motoristatipo" name="motoristatipo">
    <option value="">Selecione</option>
    <option value="Administrativo"  @if($efetivo->motorista_tipo == 'Administrativo')
        selected 
      @endif >Administrativo</option>
    <option value="Operacional"  @if($efetivo->motorista_tipo == 'Operacional')
        selected 
      @endif >Operacional</option>
  </select>
</div>
</div> <br>
<div class="row">
    <div class="col-xs-2">
        <label for="cep">CEP</label>
      <input type="text" class="form-control" id="cep" onblur="buscarCep()"
       name="cep" maxlength="10" value="{{$efetivo->cep or ''}}">
    </div>
    <div class="col-xs-5">
        <label for="endereco">Endereço</label>
      <input type="text" class="form-control" id="endereco"
       name="endereco" maxlength="200" value="{{$efetivo->endereco or ''}}">
    </div>
    <div class="col-xs-1">
        <label for="\..">Número</label>
      <input type="text" class="form-control" id="numero"
       name="numero" maxlength="60" value="{{$efetivo->numero or ''}}">
    </div>
    <div class="col-xs-3">
        <label for="bairro">Bairro</label>
      <input type="text" class="form-control" id="bairro"
       name="bairro" maxlength="60" value="{{$efetivo->bairro or ''}}">
    </div>
    <div class="col-xs-3">
        <label for="complemento">Complemento</label>
      <input type="text" class="form-control" id="complemento"
       name="complemento" maxlength="60" value="{{$efetivo->complemento or ''}}">
    </div>
    <div class="col-xs-2">
        <label for="cidade_estado">Cidade</label>
      <input type="text" class="form-control" id="cidade_estado"
       name="cidade_estado" maxlength="60" value="{{$efetivo->cidade_estado or ''}}">
    </div>
    <div class="col-xs-2">
        <label for="telefone">Telefone</label>
      <input type="text" class="form-control" id="telefone"
       name="telefone" maxlength="14" value="{{$efetivo->telefone or ''}}">
    </div>
    <div class="col-xs-4">
        <label for="email">E-mail</label>
      <input type="text" class="form-control" id="email"
       name="email" maxlength="120" value="{{$efetivo->email or ''}}">
    </div>

</div>

<br><br>
<div class="box-header with-border">
    <h3 class="box-title">Dados Funcionais</h3>
  </div><br>
  
  
  <br>
  <div class="row">
        <div class="col-xs-2"> 
            <label for="opm">OPM</label>
          <select class="form-control" id="opm" name="opm" required >
            <option value="">Selecione a OPM</option>
            @foreach( $opms as $opm )
            <option value="{{ $opm->id or ''}}" 
              @isset($efetivo->opm->id)
                @if($efetivo->opm->id == $opm->id)
                  selected 
                @endif 
              @endisset ><p> {{ $opm->opm_sigla }} </p></option>
            @endforeach
          </select>
        </div> 

        <div class="col-xs-4"> 
            <label for="secao">Seção</label>
          <select class="form-control" id="secao" name="secao" required >
            <option value="">Selecione</option>
            @foreach( $secoes as $secao )
            <option value="{{ $secao->id or ''}}" 
              @isset($efetivo->secao->id)
                @if($efetivo->secao->id == $secao->id)
                  selected 
                @endif 
              @endisset ><p> {{ $secao->nome }} </p></option>
            @endforeach
          </select>
        </div> 
        <div class="col-xs-2"> 
            <label for="funcao">Função</label>
          <select class="form-control" id="funcao" name="funcao" required >
            <option value="">Selecione</option>
            @foreach( $funcoes as $funcao )
            <option value="{{ $funcao->id or ''}}" 
              @isset($efetivo->funcao->id)
                @if($efetivo->funcao->id == $funcao->id)
                  selected 
                @endif 
              @endisset ><p> {{ $funcao->nome }} </p></option>
            @endforeach
          </select>
        </div>  
        <div class="col-xs-2"> 
          <label for="situacao">Situação</label>
          <select class="form-control" id="situacao" name="situacao" required >
            <option value="">Selecione</option>
            @foreach( $situacoes as $situacao )
            <option value="{{ $situacao->id or ''}}" 
              @isset($efetivo->situacao->id)
                @if($efetivo->situacao->id == $situacao->id)
                  selected 
                @endif 
              @endisset ><p> {{ $situacao->nome}} </p></option>
            @endforeach
          </select>
        </div>
           
  </div> <br>
</div>
        <br>
        <br><br>
        <div class="box-header with-border">
            <h3 class="box-title">Formação Acadêmica</h3>
          </div>          
          <br>
          <div class="row">
                <div class="col-xs-2"> 
                    <label for="formacao">Formação</label>
                    <select class="form-control" id="formacao" name="formacao" >
                    <option value="">Selecione</option>
                    <option value="Fundamental"  @if($efetivo->formacao_academica == 'Fundamental')
                        selected 
                      @endif >Fundamental</option>
                    <option value="Médio"  @if($efetivo->formacao_academica == 'Médio')
                        selected 
                     @endif >Médio</option>
                     <option value="Pós Graduado"  @if($efetivo->formacao_academica == 'Pós Graduado')
                      selected 
                    @endif >Pós Graduado</option>
                    <option value="Mestrado"  @if($efetivo->formacao_academica == 'Mestrado')
                      selected 
                    @endif >Mestrado</option>
                    <option value="Doutorado"  @if($efetivo->formacao_academica == 'Doutorado')
                      selected 
                    @endif >Doutorado</option>  
                  </select>
                </div> 
        
                <div class="col-xs-2"> 
                    <label for="areaconhecimento">Área de conhecimento</label>
                    <select class="form-control" id="areaconhecimento" name="areaconhecimento" >
                      <option value="">Selecione</option>
                      <option value="Ciências Agrárias"  @if($efetivo->area_conhecimento == 'Ciências Agrárias')
                        selected 
                    @endif >Ciências Agrárias</option>
                      <option value="Ciências Biológicas"  @if($efetivo->area_conhecimento == 'Ciências Biológicas')
                          selected 
                        @endif >Ciências Biológicas</option>
                    <option value="Ciências Humanas"  @if($efetivo->area_conhecimento == 'Ciências Humanas')
                          selected 
                      @endif >Ciências Humanas</option>                    
                    <option value="Ciências Sociais"  @if($efetivo->area_conhecimento == 'Ciências Sociais')
                      selected 
                     @endif >Ciências Sociais</option>
                    <option value="Engenharias e TI"  @if($efetivo->area_conhecimento == 'Engenharias e TI')
                      selected 
                      @endif >Engenharias e TI</option>
                    <option value="Letras e Artes"  @if($efetivo->area_conhecimento == 'Letras e Artes')
                      selected 
                       @endif >Letras e Artes</option>
                  </select>
                </div> 

                <div class="col-xs-5">
                  <label for="cursoacademico">Informe o curso</label>
              <input type="text" class="form-control" placeholder="Curso Acadêmico" maxlength="60"
              value="{{  $efetivo->curso_academico or '' }}" id="cursoacademico" name="cursoacademico"> 
              </div>

                
                <div class="col-xs-2"> 
                    <label for="anoconclusao">Ano de Conclusão</label>
                  <input type="number" class="form-control" id="anoconclusao" name="anoconclusao" value="{{$efetivo->ano_conclusao or ''}}" >
                </div> 
        
          </div> <br>
        
          
        
        </div>
        <!--FORMULÁRIO -->

    </div>
              <div class="box-footer">
                <div class="btn-toolbar pull-right">
                   <button type="submit" class="btn btn-success btn-lg">Salvar</button>
                 </div>
              </div>
    </form>


    <div class="clearfix"></div>
                    
                  </form>
              </div>
          </div>
      </div>
  </div>

    </section>
@stop

@section('js')
<script>
 $(document).ready(function(){
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

});

function buscarCep()
{
  var cep = $("#cep").val();
  $.ajax({
    url: "/obtercep/"+cep,
    type: "get",
    //data: "",
    dataType: "json"

}).done(function(resposta) {
    $("#bairro").val(resposta[0].bairro);
    $("#cidade_estado").val(resposta[0].cidade_estado);
    $("#endereco").val(resposta[0].logradouro);
    console.log(resposta[0].bairro);

}).fail(function(jqXHR, textStatus ) {
    console.log("Request failed: " + textStatus);

}).always(function() {
    console.log("completou");
});

}

  </script>
@stop