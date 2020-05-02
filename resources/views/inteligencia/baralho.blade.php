@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Inteligência</h1>
    <ol class="breadcrumb">
        <li><a href="">Inteligência</a></li>
        <li><a href="{{route('inteligencia.criminosos')}}">criminosos</a></li>
    </ol>
@stop

@section('content')   
    <div class="box">
    <section class="content">
 <!--FORMULÁRIO -->                            
    <form role="form" method="POST" action="{{ route('inteligencia.crim.salvar')}}" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $criminoso->id or '' }}">
<!-- Criminoso -->
<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Fotos dos Criminosos</h3>
        </div><br>
        <div class="box">
          <div class="box-header">
            <form action="{{route('inteligencia.crim.searchGaleria')}}" method="POST" class="form form-inline">
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

      
<!--galeria de fotos -->
  <main role="main">
   <div class="album py-5 bg-light">
      <div class="container">
        <div class="row">
          @foreach ($criminosos  as $galeria)
              <div class="col-md-4">
                <div  class="card mb-4 shadow-sm">
                  <div class="card-body">
                    @if($galeria->foto != null)
                    <img src="{{ url($galeria->foto) }}" 
                    height="200" width="150" >                 
                   @else
                   <img src="{{url("fotos/sem_foto.jpg")}}" height="200" width="150">
                   @endif                    
                    <div class="d-flex justify-content-between align-items-center ">
                      <div class="btn-group">
                        <p class="card-text">{{$galeria->nome}}</p>
                        <p class="card-text">{{$galeria->opm->opm_sigla}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
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
    </div>

  </main>

  <!-- Fim Galeria de fotos-->
    <div class="clearfix"></div>
              </div>
          </div>
      </div>
  </div>
 </section>

@stop

@section('js')
<script src="{{ asset('js/jquery.mask.js') }}"></script>

<script>
 $(document).ready(function($){
    $('#cpf').mask("999.999.999-99");
 });

 



 </script> 
@stop
@section('css')
<style>
.table-striped > tbody > tr{
  background-color: #ccc;
}
.table-hover > tbody > tr:hover{
  background-color: #333;
  color: #fff;
}
  body { padding: 20px; }
       .navbar { margin-bottom: 20px; }
       :root { --jumbotron-padding-y: 10px; }
       .jumbotron {
         padding-top: var(--jumbotron-padding-y);
         padding-bottom: var(--jumbotron-padding-y);
         margin-bottom: 10;
         background-color: #fff;
       }
       @media (min-width: 768px) {
         .jumbotron {
           padding-top: calc(var(--jumbotron-padding-y) * 2);
           padding-bottom: calc(var(--jumbotron-padding-y) * 2);
         }
       }
       .jumbotron p:last-child { margin-bottom: 10; }
       .jumbotron-heading { font-weight: 300; }
       .jumbotron .container { max-width: 40rem; }
       .btn-card { margin: 4px; }
       .btn { margin-right: 5px; }
       footer { padding-top: 3rem; padding-bottom: 3rem; }
       footer p { margin-bottom: .25rem; }
   </style>
@endsection