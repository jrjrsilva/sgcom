@extends('adminlte::page')

@section('title', 'SGCOM')

@section('content_header')
    <h1>Inteligência</h1>
    <ol class="breadcrumb">
        <li><a href="">Inteligência</a></li>
        <li><a href="{{route('inteligencia.form')}}">Novo</a></li>
    </ol>
@stop

@section('content')
<div class="row">
     <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">Total de Ocorrências</span>
                <span class="info-box-number">0</span>
            <!-- The progress section is optional -->
            <div class="progress">
              <div class="progress-bar" style="width: %"></div>
            </div>
            <span class="progress-description">
              % das ocorrências de {{ date('Y') }}
            </span>
            </div>
          <!-- /.info-box-content -->
       </div>
    </div>
    
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-meh-o"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">CVLI</span>
                <span class="info-box-number">0</span>
            <!-- The progress section is optional -->
            <div class="progress">
              <div class="progress-bar" style="width: %"></div>
            </div>
            <span class="progress-description">
            % em {{ date('Y') }}
            </span>
            </div>
          <!-- /.info-box-content -->
       </div>
    </div>
    
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-automobile"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">CVP</span>
                <span class="info-box-number">0</span>
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
        <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">Homicídios</span>
                <span class="info-box-number">0 </span>
            <!-- The progress section is optional -->
            <div class="progress">
            <div class="progress-bar" style="width: %"></div>
            </div>
            <span class="progress-description">
            % dos homicidios de {{ date('Y') }}
            </span>
            </div>
          <!-- /.info-box-content -->
       </div>
    </div>
    </div>
     <div class="box">
         <div class="box-header">
         Criminosos
         <div class="btn-toolbar pull-right">
          <a href="{{route('inteligencia.form')}}" class="btn btn-primary btn-flat"> <i class="fa fa-">Incluir</i></a>
         </div>
         <div class="box-header">
            <form action="{{route('inteligencia.crim.search')}}" method="POST" class="form form-inline">
              {!! csrf_field() !!}
             
              <label for="pnome">Nome:</label>    
              <input  type="text" name="pnome"  id="pnome" class="form-control"
               placeholder="Informe o nome"/>
               <label for="apelido">Apelido:</label>    
              <input  type="text" name="apelido"  id="apelido" class="form-control"
               placeholder="Informe o apelido"/>

               <label for="faccao">Facção:</label>
               <select class="form form-control" id="faccao" name="faccao">
                 <option value="">Selecione a Facção</option>
                 @foreach( $faccoes as $faccao )
                 <option value="{{ $faccao->id }}" ><p> {{ $faccao->nome }} </p></option>
                 @endforeach
               </select>

               @can('gestor-cpr')
                <label for="pregional">Comando Regional:</label>
                <select class="form form-control" id="pregional" name="pregional">
                  <option value="">Selecione o CPR</option>
                  @foreach( $cprs as $cpr )
                  <option value="{{ $cpr->id }}" ><p> {{ $cpr->sigla }} </p></option>
                  @endforeach
                </select>
                @endcan
               
                 <label for="popm">OPM:</label>
                <select class="form form-control" id="opm" name="popm">
                  <option value="">Selecione a OPM</option>
                  @foreach( $opms as $opm )
                  <option value="{{ $opm->id }}" ><p> {{ $opm->opm_sigla }} </p></option>
                  @endforeach
                </select>
              
              
                  <button id="btn-pesquisar"  type="submit" class="btn btn-primary" >Pesquisar</button>
              </form>
            </div>
         </div>
         <div class="table-responsive">
          <div class="box-body">
              <table id="tb1" class="table table-sm table-bordered table-striped table-hover">
                <thead>
                <tr><th>Foto</th>
                  <th>Nome</th>
                  <th>Apelido</th>
                  <th>Facção</th>
                  <th>OPM</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                  @forelse($criminosos as $criminoso)
                  <tr>
                    <td>  @if($criminoso->foto != null)
                      <img src="{{ url($criminoso->foto) }}" alt="{{ $criminoso->nome }}"
                      height="100" width="100" >                 
                     @else
                     <img src="{{url("fotos/sem_foto.jpg")}}" height="150" width="100">
                     @endif</td>
                    <td>{{$criminoso->nome}}</td>
                    <td>{{$criminoso->apelido}}</td>
                    <td>{{$criminoso->faccao->nome}}</td>
                    <td>{{$criminoso->opm->opm_sigla}}</td>
                    <td>
                      @can('inteligencia-list')
                      @if($criminoso->opm_id == Auth::user()->efetivo->opm_id or Auth::user()->ehAdmin() )
                      <a href="{{route('inteligencia.crim.edit',$criminoso->id)}}" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a>
                      <a href="{{route('inteligencia.crim.excluir',$criminoso->id)}}" 
                              onclick="return confirmExcluircriminoso();" class="btn btn-danger btn-flat"><i class="fa fa-trash-o"></i></a>
                    @endif
                    @endcan
                      </td>
                  </tr>
                  @empty
                  @endforelse 
               </tbody>
              
                <tfoot>
                <tr>
                  <th>Foto</th>
                  <th>Nome</th>
                  <th>Apelido</th>
                  <th>Facção</th>
                  <th>OPM</th>
                  <th></th>
                </tr>
                
                </tfoot>
              </table>
            </div>
            
              <table id="tab2" class="table table-bordered">
                 <tbody>
                  <tr>
                     <td> 
                      @if (isset($dataForm))
                      {{ $criminosos->appends($dataForm)->links() }}
                     @else
                       {!! $criminosos->links()!!}                  
                     @endif
                     </td>
                     <td align="right">Total de registros</td>
                     <td>{{ $criminosos->total() }}</td> 
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