@extends('adminlte::page')

@section('title', 'SGCOM')

@section('content_header')
    <h1>Aniversariantes</h1>
@stop

@section('content')
      
 <div class="box">
    <div class="box-header">
    
    <form  action="{{route('rh.pesquisaAniversarios')}}" method="POST" class="form form-inline">
     {!! csrf_field() !!}        
   
     
     <label for="mes">Mês:</label>
     <select class="form-control" id="mes" name="mes" >
       <option value="01">Janeiro</option>
       <option value="02">Fevereiro</option>
       <option value="03">Março</option>
       <option value="04">Abril</option>
       <option value="05">Maio</option>
       <option value="06">Junho</option>
       <option value="07">Julho</option>
       <option value="08">Agosto</option>
       <option value="09">Setembro</option>
       <option value="10">Outubro</option>
       <option value="11">Novembro</option>
       <option value="12">Dezembro</option>
      
       </select>


   
    <label for="opm">OPM</label>
     <select class="form-control" id="opm" name="opm" >
       <option value="">Selecione a OPM</option>
       @foreach( $opms as $opm )
       <option value="{{ $opm->id or ''}}">
         <p> {{ $opm->opm_sigla }} </p></option>
       @endforeach
     </select>

       <button  type="submit" class="btn btn-primary">Pesquisar</button>     
     </form>
    
    
    </div>

  <div class="row">     
            
    <div class="col-xs-8">
        <table id="tbEfetivo" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>OPM</th>
              <th>GH</th>
              <th>Nome</th>
              <th>Data</th>
            </tr>
            </thead>
            <tbody>
            @forelse($aniversarios as $efetivo)
            <tr>
              <td>{{$efetivo->opm_sigla}}</td>
              <td>{{$efetivo->sigla}}</td>
              <td>{{$efetivo->nome}}</td>
              <td>{{ \Carbon\Carbon::parse($efetivo->datanascimento)->format('d/m')}}</td>
              <td>    
              </td>
            </tr>
            @empty
            @endforelse           
           </tbody>
            <tfoot>
            <tr>
              <th>OPM</th>
              <th>GH</th>
              <th>Nome</th>
              <th>Data</th>
             <th></th>
            </tr>
            </tfoot>
          </table>
         <table id="tab2" class="table table-bordered">
               <tbody>
                <tr>
                   <td> 
                        @if (isset($dataForm))
                        {{ $aniversarios->appends($dataForm)->links() }}
                       @else
                         {!! $aniversarios->links()!!}
                       @endif 
                   </td>
                   <td align="right">Total de registros</td>
                   <td>{{ $aniversarios->total() }}</td> 
                </tr>
               </tbody>
          </table>
    </div>     
</div>     
   
</div>

  
@stop

@section('js')
<script>
   
</script> 
@stop