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