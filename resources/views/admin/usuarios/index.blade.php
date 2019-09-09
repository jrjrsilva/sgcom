@extends('adminlte::page')

@section('title', 'SGCOM | Admin')

@section('content_header')
    <h1>usuários</h1>
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Usuários</a></li>
    </ol>
@stop

@section('content')
    <p>Gestão de Usuários</p>
    <div class="box">
            <div class="box-header">
            <form action="{{route('admin.usuarios.search')}}" method="POST" class="form form-inline">
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
                <label for="pstatus">Status:</label>
                <select class="form form-control" id="pstatus" name="pstatus">
                  <option value="">Selecione o Status</option>
                         <option value="Ativo" ><p>Ativo</p></option>
                         <option value="Inativo" ><p>Inativo</p></option>
                </select>
                  <button  type="submit" class="btn btn-primary">Pesquisar</button>
              </form>
            </div>
            <div class="box-header">
              <button  type="submit" class="btn btn-primary">Novo Usuário</button>
             
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
                  <th>Status</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                <tr>
                  <td>
                      <a href="{{route('admin.usuarios.edit',$user->id)}}">{{$user->matricula}}</a>
                    </td>
                  <td>{{$user->nome}}</td>
                  <td>{{$user->sigla}}</td>
                  <td>{{$user->opm_sigla}}</td>
                   <td>{{$user->status}}</td>
                   <td>
                      <a href="{{route('admin.usuarios.status',$user->id)}}" class="btn btn-adn">Mudar Status</a>
                   </td>
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
                  <th>Status</th>
                </tr>
                </tfoot>
              </table>
              <div >
            {!! $users->links()!!}
            </div>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop

@section('js')
    
@stop