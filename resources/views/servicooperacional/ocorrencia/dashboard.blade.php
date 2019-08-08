@extends('adminlte::page')

@section('title', 'SGCOM | Admin')

@section('content_header')
    <h1>Ocorrências</h1>
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Ocorrências</a></li>
    </ol>
@stop

@section('content')
     <div class="box">
          <!-- /.box-header -->
            <div class="box-body">
              <table id="tb1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tipo de Ocorrência</th>
                  <th>OPM</th>
                  <th>Data</th>
                  <th>Hora</th>
                  <th>CPR</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                  @forelse($ocorrencias as $ocorrencia)
                  <tr>
                    <td>{{$ocorrencia->tipoocorrencia->descricao}}</td>
                    <td>{{$ocorrencia->opm->opm_sigla}}</td>
                    <td>{{ \Carbon\Carbon::parse($ocorrencia->data)->format('d/m/Y')}}</td>
                    <td>{{$ocorrencia->hora}}</td>
                    <td>{{$ocorrencia->opm->cpr->sigla}}</td>
                    <td>
                      <a href="{{route('servico.ocorrencia.edit',$ocorrencia->id)}}" class="btn btn-adn">Editar</a>
                      <a href="{{route('servico.ocorrencia.detalhe',$ocorrencia->id)}}" class="btn btn-primary">Detalhe</a>
                    </td>
                  </tr>
                  @empty
                  @endforelse 
               </tbody>
                <tfoot>
                <tr>
                  <th>Tipo de Ocorrência</th>
                  <th>OPM</th>
                  <th>Data</th>
                  <th>Hora</th>
                  <th>CPR</th>
                  <th></th>
                </tr>
                </tfoot>
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