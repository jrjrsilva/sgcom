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
    <h2>Listagem</h2>
    @include('site.includes.alerts')
    <div class="box">
                  <div class="box-header">
                  <form action="{{route('frota.search')}}" method="POST" class="form form-inline">
                    {!! csrf_field() !!}
                    
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
                        <td>{{$viatura->opm->opm_sigla}}</td>
                        <td> {{$viatura->ano_fabricacao}}</td>
                        
                        <td>
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
                            <th>OPM</th>
                            <th>Ano de Fabricação</th>
                      <th></th>
                      </tr>
                      </tfoot>
                    </table>
                    <div >
                      @if (isset($dataForm))
                       {{ $viaturas->appends($dataForm)->links() }}
                      @else
                        {!! $viaturas->links()!!}
                      
                      
                      @endif
                  
                  </div>
                    
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
      @stop


@section('js')
   
@stop