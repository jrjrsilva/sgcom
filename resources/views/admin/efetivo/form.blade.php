@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Gestão de Pessoal</h1>
    <ol class="breadcrumb">
    <li><a href="{{route('rh.policiais')}}">Pesquisar</a></li>
        <li><a href="">Efetivo</a></li>
    </ol>
@stop

@section('content')

    <h3>Movimentação</h3>
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

    <form role="form" method="POST" action="{{ route('rh.salvarMovimentacao')}}" >
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

              <div class="col-xs-5">
              <label for="nome">Nome</label>
              <input type="text" class="form-control" placeholder="Nome" readonly
              value="{{  $efetivo->nome or '' }}" id="nome" name="nome"> 
              </div>
      
        
            <div class="col-xs-2">
                <label for="matricula">Matrícula</label>
            <input type="text" class="form-control" placeholder="Informe a matricula" readonly
            value="{{  $efetivo->matricula or '' }}" id="matricula" name="matricula"> 
            </div>
        </div>
        </div>
        <br>
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
</script>
@stop