@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Gestão de Frota</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('frota.lista')}}">Gestão de frota</a></li>
        <li><a href="">Cadastro Histórico</a></li>
    </ol>
@stop

@section('content')
    <h2>Cadastro de Histórico</h2>
    @include('site.includes.alerts')
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

           
              <div class="col-xs-2">  
                <label>Placa do Veiculo</label>  
                <p>{{$viatura->placa or ''}}</p>
              </div> 

              <div class="col-xs-2">
                <label>Prefixo</label>
                <p>{{$viatura->prefixo or ''}}</p>
              </div>
        </div> <br>
         <form role="form" method="POST" action="{{ route('frota.salvar.historico')}}" >
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $viatura->id or '' }}">
 <!--DADOS -->   

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
        </div>
        <div class="row">
              <div class="col-xs-2"> 
                <label>OPM</label>  
               <p> {{ $viatura->opm->opm_sigla }} </p>
                  
              </div> 
    <div class="row">
            <div class="col-xs-2">
                <label>Tipo</label>
                <select class="form form-control" id="tipo" name="tipo" required>
                    <option value="">Selecione</option>
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