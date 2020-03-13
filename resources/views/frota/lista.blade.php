@extends('adminlte::page')

@section('title', 'SGCOM')

@section('content_header')
    <h1>Gestão de Frota</h1>
    <ol class="breadcrumb">
            <li><a href="{{route('frota.lista')}}">Gestão de frota</a></li>
    <li><a href="{{route('frota.index')}}">Cadastro</a></li>
        </ol>  
@stop

@section('content')
    @include('site.includes.alerts')
    <div class="row">
     <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-automobile"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">Total de Viaturas</span>
                <span class="info-box-number">0{{ $viaturas->total() }}</span>
            <!-- The progress section is optional -->
            <div class="progress">
              <div class="progress-bar" style="width: 100%"></div>
            </div>
            <span class="progress-description">
              
            </span>
            </div>
          <!-- /.info-box-content -->
       </div>
    </div>
    
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box bg-green">
          <span class="info-box-icon"><i class="fa fa-automobile"></i></span>
              <div class="info-box-content">
              <span class="info-box-text">Viaturas Operantes</span>
              <span class="info-box-number">{{ $operantes }}</span>
          <!-- The progress section is optional -->
          <div class="progress">
            <div class="progress-bar" style="width: 00%"></div>
          </div>
          <span class="progress-description">
           
          </span>
          </div>
        <!-- /.info-box-content -->
     </div>
  </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-automobile"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">Viaturas Baixadas</span>
                <span class="info-box-number">{{ $baixadas }}</span>
            <!-- The progress section is optional -->
            <div class="progress">
              <div class="progress-bar" style="width: {{$baixadas}}%"></div>
            </div>
            <span class="progress-description">
          
            </span>
            </div>
          <!-- /.info-box-content -->
       </div>
    </div>
    
    
    
</div>
    <div class="box">
                  <div class="box-header">
                  <form action="{{route('frota.search')}}" method="POST" class="form form-inline">
                    {!! csrf_field() !!}                    
                            <label>Situação</label>  
                            <select class="form-control" id="situacao" name="situacao">
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
                          
                    <label for="popm">OPM:</label>
                      <select class="form form-control" id="opm" name="popm">
                        <option value="">Selecione a OPM</option>
                        @foreach( $opms as $opm )
                        <option value="{{ $opm->id }}" ><p> {{ $opm->opm_sigla }} </p></option>
                        @endforeach
                      </select>
                    
                        <button  type="submit" class="btn btn-primary">Pesquisar</button>
                    </form>
                  </div>
                  
                  <!-- /.box-header -->
                  <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        
                        <th>Prefixo</th>
                        <th>Modelo</th>
                        <th>Situação</th>
                        <th>KM Atual</th>
                        <th>OPM</th>
                        <th>Ano de Fabricação</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      @forelse($viaturas as $viatura)
                      <tr>
                        <td>{{$viatura->prefixo}}</td>
                        <td>{{$viatura->modeloveiculo->descricao}}</td>
                        <td>{{$viatura->situacaoviatura->descricao}}</td>
                        <td> {{number_format($viatura->km,0,'.','.')}}</td>
                        <td>{{$viatura->opm->opm_sigla}}</td>
                        <td> {{$viatura->ano_fabricacao}}</td>
                        
                        <td>
                          <a href="{{route('frota.edit.historico',$viatura->id)}}" class="btn btn-primary btn-flat">Lançar Historico</a>
                          <a href="{{route('frota.edit.revisao',$viatura->id)}}" class="btn btn-primary btn-flat">Lançar Revisão</a>
                          <a href="{{route('frota.edit.km',$viatura->id)}}" class="btn btn-primary btn-flat">Lançar KM</a>
                          <a href="{{route('frota.edit',$viatura->id)}}" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a>
                        </td>
                      </tr>
                      @empty
                      @endforelse 
                     </tbody>
                      <tfoot>
                      <tr>
                            <th>Prefixo</th>
                            <th>Modelo</th>
                            <th>Situação</th>
                            <th>KM Atual</th>
                            <th>OPM</th>
                            <th>Ano de Fabricação</th>
                      <th></th>
                      </tr>
                      </tfoot>
                    </table>
                  
                    <table id="tab2" class="table table-bordered">
                      <thead>
                         <tr>
                             <th></th>
                             <th></th>                         
                        </tr>
                      </thead>
                      <tbody>
                      <tr>
                         <td> 
                          @if (isset($dataForm))
                          {{ $viaturas->appends($dataForm)->links() }}
                         @else
                           {!! $viaturas->links()!!}                  
                         @endif
                         </td>
                         <td align="right">Total de registros</td>
                         <td>{{ $viaturas->total() }}</td> 
                      </tr>
                     </tbody>
                </table>
                  
                  
                   
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>

                          
              

      @stop


@section('js')
<script>



</script>
@stop