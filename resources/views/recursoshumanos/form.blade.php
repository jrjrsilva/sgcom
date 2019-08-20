@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Recursos Humanos</h1>
    <ol class="breadcrumb">
        <li><a href="">Recursos Humanos</a></li>
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
              <div class="col-xs-4">
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


        </div> <br>

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

              <div class="col-xs-1">
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


  </script>
@stop