@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Gestão de Frota</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('frota.lista')}}">Gestão de frota</a></li>
        <li><a href="">Cadastro KM</a></li>
    </ol>
@stop

@section('content')

    <h2>Cadastro de KM</h2>
    @include('site.includes.alerts')
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

    <form role="form" method="POST" action="{{ route('frota.salvar.km')}}" >
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
            
              <div class="col-xs-2">  
                <label>Placa do Veiculo</label>  
                <p>{{$viatura->placa or ''}}</p>
              </div> 

              <div class="col-xs-2">
                <label>Prefixo</label>
                <p>{{$viatura->prefixo or ''}}</p>
              </div>

              <div class="col-xs-2">
                <label>KM</label>
                <p>{{$viatura->km or ''}}</p>
              </div>
              
        </div> <br>
        <div class="row">
            <div class="col-xs-2">
                <label>KM</label>
                <p><input type="number" name="km" id="km" required></p>
              </div>
              <div class="col-xs-2">
                <label>Data</label>
                <p><input type="date" name="data" id="data" required></p>
              </div>
              <div class="col-xs-2">
                <label>Hora</label>
                <p><input type="time" name="hora" id="hora" required></p>
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