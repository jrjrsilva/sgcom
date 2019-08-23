@extends('adminlte::page')

@section('title', 'SGCOM | RH')

@section('content_header')
    <h1>Recursos Humanos</h1>
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">RH</a></li>
    </ol>
@stop

@section('content')
    <p>Gestão de Efetivo</p>
    <div class="box">
            <div class="box-header">
            <form action="{{route('rh.searchMatricula')}}" method="POST" class="form form-inline">
              {!! csrf_field() !!}
              <label for="pnome">Nome:</label>    
              <input  type="text" name="pnome"  id="pnome" class="form-control"
               placeholder="Informe o nome"/>
               <label for="pmatricula">Matrícula:</label>    
              <input  type="number" pattern="[0-9]" maxlength=9 name="pmatricula"  id="pmatricula" class="form-control"
               placeholder="Informe a Matrícula"/>
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
                  
                  <th>Grau Hierarquico</th>
                  <th>Nome</th>
                  <th>Matrícula</th>
                  <th>OPM</th>
                  <th>Data de Nascimento</th>
                  <th>Sexo</th>
                  <th>Data de Admissão</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($efetivos as $efetivo)
                <tr>
                  <td>{{$efetivo->grauhierarquico->sigla}}</td>
                  <td>{{$efetivo->nome}}</td>
                  <td>{{$efetivo->matricula}}</td>
                  <td>{{$efetivo->opm->opm_sigla}}</td>
                  <td>{{ \Carbon\Carbon::parse($efetivo->datanascimento)->format('d/m/Y')}}</td>
                  <td>{{$efetivo->sexo}}</td>
                  <td>{{ \Carbon\Carbon::parse($efetivo->dataadmissao)->format('d/m/Y')}}</td>
                  <td>
                    <a href="{{route('rh.edit',$efetivo->id)}}" class="btn btn-adn">Editar</a>
                   
                  </td>
                </tr>
                @empty
                @endforelse 
               </tbody>
                <tfoot>
                <tr>
                  <th>Grau Hierarquico</th>
                  <th>Nome</th>
                  <th>Matrícula</th>
                  <th>OPM</th>
                  <th>Data Nascimento</th>
                  <th>Sexo</th>
                  <th>Data de Admissão</th>
                <th></th>
                </tr>
                </tfoot>
              </table>
              <div >
                @if (isset($dataForm))
                 {{ $efetivos->appends($dataForm)->links() }}
                @else
                  {!! $efetivos->links()!!}
                
                
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