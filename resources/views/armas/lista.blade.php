@extends('adminlte::page')

@section('title', 'SGCOM')

@section('content_header')
    <h1>Gestão de Armas</h1>
    <ol class="breadcrumb">
            <li><a href="{{route('armas.lista')}}">Gestão de Armas</a></li>
    <li><a href="{{route('armas.index')}}">Cadastro</a></li>
        </ol>  
@stop

@section('content')
    <h2>Listagem</h2>
    @include('site.includes.alerts')
    <div class="box">
                  <div class="box-header">
                  <form action="{{route('armas.search')}}" method="POST" class="form form-inline">
                    {!! csrf_field() !!}
                    <label for="pserial">Nº de Série:</label>    
                    <input  type="text" name="pserial"  id="pserial" class="form-control"
                     placeholder="Informe o serial" maxlength="10"/>

                    <label for="psituacao">Especie da Arma:</label>
                    <select class="form form-control" id="psituacao" name="psituacao">
                      <option value="">Selecione a Situação</option>
                      @foreach( $situacaoarmas as $situacao )
                      <option value="{{ $situacao->id }}" ><p> {{ $situacao->nome }} </p></option>
                      @endforeach
                    </select>

                    <label for="pespecie">Especie da Arma:</label>
                    <select class="form form-control" id="pespecie" name="pespecie">
                      <option value="">Selecione a Especie</option>
                      @foreach( $especies as $especie )
                      <option value="{{ $especie->id }}" ><p> {{ $especie->nome }} </p></option>
                      @endforeach
                    </select>

                    <label for="pcalibre">Calibre:</label>
                    <select class="form form-control" id="pcalibre" name="pcalibre">
                      <option value="">Selecione o Calibre</option>
                      @foreach( $calibres as $calibre )
                      <option value="{{ $calibre->id }}" ><p> {{ $calibre->nome }} </p></option>
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
                        
                        <th>Número de Série</th>
                        <th>Calibre</th>
                        <th>Especie</th>
                        <th>OPM</th>
                        <th>Situação</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      @forelse($armas as $arma)
                      <tr>
                        <td>{{$arma->numero_de_serie}}</td>
                        <td> {{$arma->calibre->nome}}</td>
                        <td>{{$arma->especiearma->nome}}</td>
                        <td>{{$arma->opm->opm_sigla}}</td>
                        <td>{{$arma->situacaoarma->nome}}</td>
                        <td>{{$arma->marcaarma->nome}}</td>
                        <td>{{$arma->modeloarma->nome}}</td>
                        <td>
                          <a href="{{route('armas.edit',$arma->id)}}" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a>
                        </td>
                      </tr>
                      @empty
                      @endforelse 
                     </tbody>
                      <tfoot>
                      <tr>
                        <th>Número de Série</th>
                        <th>Calibre</th>
                        <th>Especie</th>
                        <th>OPM</th>
                        <th>Situação</th>
                        <th>Marca</th>
                        <th>Modelo</th>
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
                          {{ $armas->appends($dataForm)->links() }}
                         @else
                           {!! $armas->links()!!}                  
                         @endif
                         </td>
                         <td align="right">Total de registros</td>
                         <td>{{ $armas->total() }}</td> 
                      </tr>
                     </tbody>
                </table>
                    <div >
                     
                  
                  </div>
                    
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
      @stop


@section('js')
   
@stop