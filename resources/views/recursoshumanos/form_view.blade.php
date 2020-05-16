@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Gestão de Pessoal</h1>
    <ol class="breadcrumb">
    <li><a href="{{route('rh.listar')}}">Gestão efetivo</a></li>
        <li><a href="{{route('rh.edit',$efetivo->id)}}">Efetivo</a></li>
    </ol>
@stop

@section('content')

    <h2>Detalhe</h2>
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

    <form role="form">
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $efetivo->id or '' }}">
 
 <!--DADOS  DO POLICIAL-->   

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Dados do Policial</h3>
        
        </div><br>
        
        <div class="row">
        <div class="form-row">
            <div class="col-md-2"> 
                <label for="gh">Grau Hierarquico</label>
              
                <p>{{$efetivo->grauhierarquico->sigla }} </p>
            </div> 

              <div class="col-md-5">
                  <label for="nome">Nome</label>
              <p>{{  $efetivo->nome }} </p>
              </div>
        </div>
        <div class="form-row">
            <div class="col-md-2">
                <label for="matricula">Matrícula</label>
           <p>{{$efetivo->matricula}}
                     </p>
            </div>
        </div>
        <div class="form-row">
          <div class="custom-file>
            <label for="arquivo" class="custom-file-label"></label>
            @if($efetivo->foto != null)
            <img src="{{ url($efetivo->foto) }}" alt="{{ $efetivo->nome }}"
            height="200" width="150" >
          
           @else
           <img src="{{url("fotos/sem_foto.jpg")}}" height="200" width="150">
           @endif
           
          </div>
      </div>
        </div>
        <br>
       <br>

        <div class="row">

              <div class="col-md-2">
                <div class="input-group">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <p>{{$efetivo->datanascimento or '' }}"
                     </p>
                </div>  

              </div>

              <div class="col-md-2">
                <div class="input-group">
                    <label for="data_admissao">Data de Admissão</label>
                     <p>{{$efetivo->dataadmissao or '' }}"
                     </p>
                </div>
              </div>         
            
              <div class="col-md-1">
                  <label for="sexo">Sexo</label>
                <p>{{$efetivo->sexo}}</p>
              </div>

              <div class="col-md-2">
                  <label for="tiposangue">Sangue</label>
               <p>{{$efetivo->tiposangue}}</p>
              </div>

              <div class="col-md-1">
                  <label for="fatorrh">Fator RH</label>
                <p>{{$efetivo->fatorrh}}
                  </p>
              </div>

              
        </div> 
        <br>
<div class="row">
    <div class="col-md-2">
        <label for="cnh">Número CNH</label>
     <p>{{$efetivo->cnh}}</p>
    </div>

  <div class="col-md-2">
    <label for="categoriacnh">Categoria CNH</label>
  <p>{{$efetivo->categoria_cnh or ''}}</p>
</div>

<div class="col-md-2">
    <div class="input-group">
        <label for="validadecnh">Data de Validade</label>
          <p>{{$efetivo->validade_cnh or '' }}</p>
    </div>
  </div>

<div class="col-md-2">
  <label for="ehmotorista">É Motorista?</label>
    @if($efetivo->eh_motorista == 1)
    <p>SIM</p>    
      @else
    <p>
       NÃO 
      @endif
</div>

<div class="col-md-2">
  <label for="motoristatipo">Motorista Tipo</label>
<p>{{$efetivo->motorista_tipo}}</p>
</div>
</div> <br>
<div class="row">
    <div class="col-md-2">
        <label for="cep">CEP</label>
     <p>{{$efetivo->cep}}</p>
    </div>
    <div class="col-md-5">
        <label for="endereco">Endereço</label>
     <p>{{$efetivo->endereco}}</p>
    </div>
    <div class="col-md-1">
        <label for="\..">Número</label>
      <p>{{$efetivo->numero}}</p>
    </div>
    <div class="col-md-3">
        <label for="bairro">Bairro</label>
     <p>{{$efetivo->bairro}}</p>
    </div>
    <div class="col-md-3">
        <label for="complemento">Complemento</label>
      <p>{{$efetivo->complemento}}</p>
    </div>
    <div class="col-md-2">
        <label for="cidade_estado">Cidade</label>
        <p>{{$efetivo->cidade_estado}}</p>
    </div>
    <div class="col-md-2">
        <label for="telefone">Telefone</label>
      <P>{{$efetivo->telefone}}</P>
    </div>
    <div class="col-md-4">
        <label for="email">E-mail</label>
     <P>{{$efetivo->email}}</P>
    </div>

</div>

<br><br>
<div class="box-header with-border">
    <h3 class="box-title">Dados Funcionais</h3>
  </div><br>
  
  
  <br>
  <div class="row">
        <div class="col-md-2"> 
            <label for="opm">OPM</label>
         <p> {{$efetivo->opm->opm_sigla}}</p>
        </div> 

        <div class="col-md-4"> 
            <label for="secao">Seção</label>
        <p>{{$efetivo->secao->nome}}</p>
        </div> 
        <div class="col-md-2"> 
            <label for="funcao">Função</label>
         <p>{{$efetivo->funcao->nome}}</p>
        </div>  
        <div class="col-md-2"> 
          <label for="situacao">Situação</label>
         <p> {{ $efetivo->situacao->nome}} </p>  
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
                <div class="col-md-2"> 
                    <label for="formacao">Formação</label>
                    <p>{{$efetivo->formacao_academica}}</p>
                </div> 
        
                <div class="col-md-2"> 
                    <label for="areaconhecimento">Área de conhecimento</label>
                   <P>{{$efetivo->area_conhecimento}}</P>
                </div> 

                <div class="col-md-5">
                  <label for="cursoacademico">Informe o curso</label>
             <p>{{  $efetivo->curso_academico}}</p>
              </div>

                
                <div class="col-md-2"> 
                    <label for="anoconclusao">Ano de Conclusão</label>
                  <P>{{$efetivo->ano_conclusao}}</P>
                </div> 
        
          </div> <br>
</div>
        <!--FORMULÁRIO -->

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

@stop