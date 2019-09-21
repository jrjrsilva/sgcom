@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Gestão de Frota</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('frota.lista')}}">Gestão de frota</a></li>
        <li><a href="">Cadastro</a></li>
    </ol>
@stop

@section('content')

    <h2>Cadastro</h2>
    @include('site.includes.alerts')
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

    <form role="form" method="POST" action="{{ route('frota.salvar')}}" >
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $viatura->id or '' }}">
 <!--DADOS -->   

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
        </div>
        <div class="row">
              <div class="col-xs-4"> 
                <label>OPM</label>  
                <select class="form-control" id="opm" name="opm" required >
                  <option value="">Selecione a OPM</option>
                  @foreach( $opms as $opm )
                  <option value="{{ $opm->id or ''}}" 
                    @isset($viatura->opm->id)
                      @if($viatura->opm->id == $opm->id)
                        selected 
                      @endif 
                    @endisset ><p> {{ $opm->opm_sigla }} </p></option>
                  @endforeach
                </select>
              </div> 

              <div class="col-xs-4"> 
                <label>Placa</label>
                <input type="text" class="form-control" placeholder="Placa da VTR" 
                  id="placa" name="placa" required maxlength="8" value="{{$viatura->placa or ''}}"
                style="text-transform: uppercase;">
              </div> 

              <div class="col-xs-4">
                <label>Prefixo</label>
                <input type="text" class="form-control" placeholder="Prefixo da VTR" value="{{$viatura->prefixo or ''}}"
                  id="prefixo" name="prefixo" maxlength="6" data-mask="0.0000" data-mask-selectonfocus="true">
              </div>
        </div> <br>


    <div class="row">

      <div class="col-xs-4">
              <label>Marca:</label>
                 <select class="form-control" id="marcaveiculo" name="marcaveiculo" 
                  required class="marcaveiculo">
                    <option value="">Selecione a Marca da VTR</option>
                    @foreach( $marcaveiculos as $marcaveiculo )
                    <option value="{{$marcaveiculo->id or '' }}" 
                        @isset($viatura->marcaveiculo->id)
                          @if($viatura->marcaveiculo->id == $marcaveiculo->id)
                            selected 
                           @endif 
                     @endisset
                      ><p> {{ $marcaveiculo->descricao }} </p></option>
                    @endforeach
                    </select>
      </div>
     
    <div class="col-xs-4">
     
          <label>Modelo:</label>
          <select class="form-control" id="modeloveiculo" 
          required name="modeloveiculo">
            <option value="">Selecione o Modelo da VTR</option>
            @foreach( $modeloveiculos as $modeloveiculo )
            <option value="{{$modeloveiculo->id or '' }}" 
                @isset($viatura->modeloveiculo->id)
                @if($viatura->modeloveiculo->id == $modeloveiculo->id)
                selected 
              @endif 
            @endisset
              ><p> {{ $modeloveiculo->descricao }} </p></option>
            @endforeach
            </select>


    </div>

    <div class="col-xs-4">
            <label>KM:</label>
            <input type="number" class="form-control " 
            required placeholder="KM da VTR" maxlength="6"
            value="{{  $viatura->km or '' }}" id="km" name="km" />
    </div> 
    <div class="col-xs-4">
          <label>CHASSI:</label>
          <input type="text" class="form-control "  required
          style="text-transform: uppercase;"
            placeholder="Chassi" maxlength="15" 
            value="{{  $viatura->chassi or '' }}" id="chassi" name="chassi" />
       
    </div>

    <div class="col-xs-4">
        <label>Renavam:</label>
        <input type="text"  class="form-control " 
        required placeholder="renavam do veículo" maxlength="10"
        value="{{  $viatura->renavam or '' }}" id="renavam" name="renavam" />
</div> 
<div class="col-xs-4">
      <label>Patrimônio:</label>
      <input type="text" class="form-control " 
      required placeholder="tipo" maxlength="15" 
        value="{{  $viatura->patrimonio or '' }}" id="patrimonio" name="patrimonio" />
</div>


<div class="col-xs-3">
    <label>Combustível</label>  
    <select class="form-control" id="combustivel" 
        required name="combustivel">
        <option value="">Selecione o Combustível</option>
        @foreach( $combustiveis as $combustivel )
        <option value="{{$combustivel->id or '' }}" 
            @isset($viatura->combustivel->id)
            @if($viatura->combustivel->id == $combustivel->id)
            selected 
          @endif 
        @endisset
          ><p> {{ $combustivel->descricao }} </p></option>
        @endforeach
      </select>
  </div>

  
  <div class="col-xs-3">
    <label>Situação</label>  
    <select class="form-control" id="situacao" required name="situacao">
        <option value="">Selecione a Situação</option>
        @foreach( $situacaoviaturas as $situacaoviatura )
        <option value="{{$situacaoviatura->id or '' }}" 
            @isset($viatura->situacaoviatura->id)
            @if($viatura->situacaoviatura->id == $situacaoviatura->id)
            selected 
          @endif 
        @endisset
          ><p> {{ $situacaoviatura->descricao }} </p></option>
        @endforeach
      </select>
  </div>
   <div class="col-xs-3">
        <label>Ano Modelo</label>
        <input type="text" class="form-control" required
         maxlength="4" minlength="4" placeholder="Informe o ano do modelo" 
         value="{{$viatura->ano_modelo or '' }}"id="anomodelo" name="anomodelo">
    </div>
    <div class="col-xs-3">
     <label>Ano Fabricação</label>
       <input type="text" class="form-control" required
        maxlength="4" minlength="4" placeholder="Informe o ano de fabricação" 
        value="{{$viatura->ano_fabricacao or ''}}" id="anofabricacao" name="anofabricacao">
      </div>
      <div class="col-xs-3">
                <label>Codigo dos Pneus</label>  
                <select class="form-control" id="tipopneu" name="tipopneu" required>
                    <option value="">Selecione o tipo</option>
                    @foreach( $tipopneus as $tipopneu )
                    <option value="{{$tipopneu->id or '' }}" 
                        @isset($viatura->tipopneu->id)
                        @if($viatura->tipopneu->id == $tipopneu->id)
                        selected 
                      @endif 
                    @endisset
                      ><p> {{ $tipopneu->descricao }} </p></option>
                    @endforeach
                    
                  </select>
              </div>
              <div class="col-xs-3">
                <label>Cor</label>  
                <select class="form-control" id="cor" required name="cor">
                    <option value="">Selecione a cor</option>
                   @isset($viatura)
                    <option value="Padrão PM"
                      @if($viatura->cor == 'Padrão PM') selected @endif
                      >Padrão PM</option>
                    <option value="CIPT"
                      @if($viatura->cor == "CIPT") selected @endif
                      >CIPT</option>
                    <option value="SOINT"
                      @if($viatura->cor == 'SOINT') selected @endif
                      >SOINT</option>
                    @endisset
                  </select>
              </div>
        </div> <br>
        <!--FORMULÁRIO -->
    </div>
              <div class="box-footer">
                <div class="btn-toolbar pull-right">
                 
                  <button type="submit" class="btn btn-success btn-lg">Adicionar</button>
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

$('#marcaveiculo').change(function () {
        var id_veiculo = $(this).val();
        $.get('/admin/veiculo/modelos/'+id_veiculo, function (modelos) {
            $('select[name=modeloveiculo]').empty();
            $.each(modelos, function (key, value) {
                $('select[name=modeloveiculo]').append('<option value=' + value.id + '>' + value.descricao + '</option>');
            });
        });
    });
    
</script>

@stop