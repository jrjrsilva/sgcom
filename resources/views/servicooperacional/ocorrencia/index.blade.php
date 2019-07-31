@extends('adminlte::page')

@section('title', 'SGCOM | ')

@section('content_header')
    <h1>Serviço Operacional</h1>
    <ol class="breadcrumb">
        <li><a href="">Serviço Operacional</a></li>
        <li><a href="">Ocorrência</a></li>
    </ol>
@stop

@section('content')

    <h2>Ocorrência</h2>
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

    <form role="form" method="POST" action="{{ route('servico.ocorrencia.salvar')}}" >
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $ocorrencia->id or '' }}">
 <!--DADOS DA OCORRÊNCIA-->   

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Dados da Ocorrência</h3>
        </div><br>

                
        <div class="row">
              <div class="col-xs-4"> 
                <select class="form-control" id="opm" name="opm">
                  <option>Selecione a OPM</option>
                  @foreach( $opms as $opm )
                  <option value="{{ $opm->id }}" 
                    @isset($ocorrencia->id)
                      @if($ocorrencia->opm->id == $opm->id)
                        selected 
                      @endif 
                    @endisset ><p> {{ $opm->opm_sigla }} </p></option>
                  @endforeach
                </select>
              </div> 

              <div class="col-xs-4"> 
                <input type="text" class="form-control" placeholder="Coordenador Regional" id="coord_cprca">
              </div> 

              <div class="col-xs-4"> 
                <input type="text" class="form-control" placeholder="Supervisor Regional" id="superv_cprca">
              </div>
        </div> <br>

        <div class="row">

              <div class="col-xs-4">
                <div class="input-group">
                      <input type="date" class="form-control timepicker" placeholder="Selecione a Data"
                       id="data_ocorre" name="data_ocorre" value="{{$ocorrencia->data or '' }}">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>  

              </div>

              <div class="col-xs-4">
                  <div class="input-group">
                      <input type="time" class="form-control timepicker" placeholder="Selecione a hora" 
                      value="{{ $ocorrencia->hora or ''}}" id="hora_ocorre" name="hora_ocorre">
                      <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                  </div>
              </div> 
                <div class="col-xs-4">
                    <select class="form-control" id="tipo_ocorr" name="tipo_ocorr">
                    <option>Selecione o tipo da ocorrência</option>
                    @foreach( $tiposocorrencias as $tipoocorrencia )
                    <option value="{{ $tipoocorrencia->id }}" 
                        @isset($ocorrencia->id)
                        @if($ocorrencia->tipoocorrencia->id == $tipoocorrencia->id)
                        selected 
                      @endif 
                    @endisset
                      ><p> {{ $tipoocorrencia->descricao }} </p></option>
                    @endforeach
                    </select>
              </div>

        </div> <br>

        <div class="form-row">
              <div class="col">
              <input type="text" class="form-control" placeholder="Informe o local da ocorrência" 
              value="{{ $ocorrencia->ocorrencia_local or '' }}" id="local_ocorre" name="local_ocorre"> 
              </div>
        </div> <br>

<!-- GUARNIÇÃO DE SERVIÇO -->

<!-- ENVOLVIDOS -->

       

<!-- DIV DESCRIÇÃO DA OCORRÊNCIA -->

        <div class="box box-warning">
                  
                  <div class="box-header with-border">
                    <h3 class="box-title">Descrição da Ocorrência</h3>
                </div><br>

                <div class="form-row">
                  <textarea class="form-control" rows="10" placeholder="Descreva a ocorrência" 
                 value="" id="desc_ocorrencia" 
                  name="desc_ocorrencia" >{{ $ocorrencia->ocorrencia_relatorio or ''}} </textarea>
                </div><br>
                <div class="form-row">
                  <label for="arquivoOcorrencia">Anexar</label>
                  <input type="file" id="arquivoOcorrencia">
                  <p class="help-block">Anexar arquivos ou fotos à ocorrência</p>
                
                </div>
        </div>
        
<!-- Boletim de Ocorrência -->

<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Boletim de Ocorrência</h3>
        </div><br>
 <br>

       <br>

      
       
      <!-- Produtividade da ocorrência -->

      
    


        <!--FORMULÁRIO -->

      
    </div>
              <div class="box-footer">
                <div class="btn-toolbar pull-right">
                  <button type="button" class="btn btn-danger btn-lg">Limpar</button>
                  <button type="submit" class="btn btn-success btn-lg">Adicionar</button>
                 </div>
              </div>
    </form>
    
           

    </section>
@stop

@section('js')

@stop