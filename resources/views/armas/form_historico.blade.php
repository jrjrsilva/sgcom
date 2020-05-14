@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Gestão de Armas</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('armas.lista')}}">Gestão de Armas</a></li>
        <li><a href="">Cadastro Histórico</a></li>
    </ol>
@stop

@section('content')
    <h2>Cadastro de Histórico</h2>
    @include('site.includes.alerts')
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

       <form role="form" method="POST" action="{{ route('armas.salvar.historico')}}" >
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $arma->id or '' }}">
 <!--DADOS -->   

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
        </div>
        <div class="row">
              <div class="col-xs-4"> 
                <label>Nº de Série</label>
                <p> 
                  {{$arma->numero_de_serie}}
                </p>
              </div> 

              <div class="col-xs-4">
                <label>Calibre</label>
              <p>{{$arma->calibre->nome}}</p>  
              </div>

              <div class="col-xs-4">
                <label>Especie:</label>
               <p>{{$arma->especiearma->nome}}</p>
        </div>
        </div> 

    <div class="row">
      <div class="col-xs-4"> 
        <label for="opm">OPM:</label>
        <input type="hidden" id="opm" name="opm" value="{{$arma->opm->id}}">
           <p> {{ $arma->opm->opm_sigla }} </p>
       </div>
    <div class="col-xs-4">     
          <label>Situação:</label>
          <select class="form-control" id="situacaoarma" name="situacaoarma" required >
            <option value="">Selecione a Situacao</option>
            @foreach( $situacaoarmas as $situacaoarma )
            <option value="{{ $situacaoarma->id or ''}}" 
              @isset($arma->situacaoarma->id)
                @if($arma->situacaoarma->id == $situacaoarma->id)
                  selected 
                @endif 
              @endisset ><p> {{ $situacaoarma->nome }} </p></option>
            @endforeach
          </select>
</div>
    </div> <br>
        <div class="row">
            <div class="col-xs-2">
                <label>Tipo</label>
                <select class="form form-control" id="tipo" name="tipo" required>
                     @foreach( $tipos as $tipo )
                    <option value="{{ $tipo->id }}" ><p> {{ $tipo->nome }} </p></option>
                    @endforeach
                  </select>
              </div>
              <div class="col-xs-2">
                <label>Data</label>
                <p><input type="date" name="data" id="data" required></p>
              </div>
        </div><br>
              <div class="row">                                                  
                <div class="col-xs-6">
                  <label for="observacao" class="control-label">Descrição</label>
                  <textarea class="form-control" id="observacao" name="observacao" required></textarea>
                </div>
                </div>
        </div>
     <br>
        <!--FORMULÁRIO -->
        <div class="box-footer">
          <div class="btn-toolbar pull-right">
           
            <button type="submit" class="btn btn-success btn-lg">Salvar</button>
           </div>
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