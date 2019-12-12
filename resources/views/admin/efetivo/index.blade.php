@extends('adminlte::page')

@section('title', 'SGCOM | Admin')

@section('content_header')
    <h1>Efetivo</h1>
    <ol class="breadcrumb">
        <li><a href=""></a></li>
        <li><a href=""></a></li>
    </ol>
@stop

@section('content')
    <p>Gestão de Efetivo</p>
    <div class="box">
            <div class="box-header">
            <form action="{{route('rh.getPolicial')}}" method="POST" class="form form-inline">
              {!! csrf_field() !!}    
              <label for="pnome">Nome:</label>    
              <input  type="text" name="pnome"  id="pnome" class="form-control"
               placeholder="Informe o nome"/>
               <label for="pmatricula">Matrícula:</label>    
              <input  type="number" pattern="[0-9]" maxlength=9 name="pmatricula"  id="pmatricula" class="form-control"
               placeholder="Informe a Matrícula"/>
                
                  <button  type="submit" class="btn btn-primary">Pesquisar</button>
              </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Matricula</th>
                    <th>Nome</th>
                    <th>GH</th>
                    <th>OPM</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  @forelse($policiais as $efetivo)
                  <tr>
                    <td>
                        <a href="{{route('rh.editPolicial',$efetivo->id)}}">{{$efetivo->matricula}}</a>
                      </td>
                    <td>{{$efetivo->nome}}</td>
                    <td>{{$efetivo->sigla}}</td>
                    <td>{{$efetivo->opm_sigla}}</td>
                     
                  </tr>
                  @empty
                  @endforelse 
                 </tbody>
                  <tfoot>
                  <tr>
                    <th>Matricula</th>
                    <th>Nome</th>
                    <th>GH</th>
                    <th>OPM</th>
                  </tr>
                  </tfoot>
                </table>
                <div >
              </div>
            </div>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop

@section('js')
    
@stop