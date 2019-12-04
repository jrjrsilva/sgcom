@extends('adminlte::page')

@section('title', 'SGCOM | RH')

@section('content_header')
    <h1>Histórico</h1>
    <ol class="breadcrumb">
    <li><a href="{{route('rh.listar')}}">Dashboard</a></li>
        <li><a href="{{route('rh.historiconovo',$efetivo->id)}}" class="btn">Incluir Histórico</a></li>
    </ol>
@stop

@section('content')
<div class="box">
  <label for="nome"></label>
  <p>
      {{$efetivo->nome}}
    </p>
</div>
<div class="box">
  <div class="box-header">
  <form action="{{route('rh.search')}}" method="POST" class="form form-inline">
    {!! csrf_field() !!}
     <label for="tipo">Tipo de Lançamento:</label>
      <select class="form form-control" id="tipo" name="tipo">
        <option value="">Selecione </option>
        @foreach( $tiposhistorico as $tipohistorico )
        <option value="{{ $tipohistorico->id }}" ><p> {{ $tipohistorico->nome }} </p></option>
        @endforeach
      </select>
    
        <button  type="submit" class="btn btn-primary">Pesquisar</button>
    </form>
  </div>
  
  <!-- /.box-header -->
  <div class="box-body">
    
    <table id="tabl-1" class="table table-bordered table-striped">
      <thead>
      <tr>
        
        <th>Tipo</th>
        <th>Data Inicio</th>
        <th>Data Fim</th>
        <th>Obs</th>
       
        <th></th>
      </tr>
      </thead>
      <tbody>
      @forelse($historicos as $historico)
      <tr>
        <td>{{$historico->tipohistorico->nome}}</td>
        <td>{{$historico->data_inicio}}</td>
        <td>{{$historico->data_fim}}</td>
        <td>{{$historico->observacao}}</td>
          
      </tr>
      @empty
      @endforelse 
     </tbody>
      <tfoot>
      <tr>
          <th>Tipo</th>
          <th>Data Inicio</th>
          <th>Data Fim</th>
          <th>Obs</th>
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
        {{ $historicos->appends($dataForm)->links() }}
       @else
         {!! $historicos->links()!!}                  
       @endif
       </td>
       <td align="right">Total de registros</td>
       <td>{{ $historicos->total() }}</td> 
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
@stop

@section('style')
  
@endsection