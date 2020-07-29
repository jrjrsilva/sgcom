@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Gestão de Usuários</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('admin.usuarios')}}">Usuários</a></li>
        <li><a href="">Usuário</a></li>
    </ol>
@stop

@section('content')

    <h2>Edição</h2>
    <div class="box">

    <section class="content">
 <!--FORMULÁRIO -->                            

    <form role="form" method="POST" action="{{ route('admin.usuarios.salvar')}}" >
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $user->id or '' }}">
 <!--DADOS  DO POLICIAL-->   

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Dados do usuário</h3>
          @include('site.includes.alerts')
        </div><br>
        
        <div class="row">
        <div class="form-row">
              <div class="col-xs-4">
                  <label for="nome">Nome</label>
              <input type="text" class="form-control" placeholder="Nome" 
              value="{{  $user->efetivo->nome or '' }}" id="nome" name="nome" readonly> 
              </div>
        </div>
        <div class="form-row">
            <div class="col-xs-2">
                <label for="matricula">Matrícula</label>
            <input type="text"  class="form-control" placeholder="Informe a matricula" required
            value="{{  $user->efetivo->matricula or '' }}" id="matricula" name="matricula" readonly> 
            </div>
        </div>
        </div>
        <br>
        <div class="row">
              <div class="col-xs-2"> 
                  <label for="opm">OPM</label>
                <select class="form-control" id="opm" name="opm" required >
                  <option value="">Selecione a OPM</option>
                  @foreach( $opms as $opm )
                  <option value="{{ $opm->id or ''}}" 
                    @isset($user->efetivo->opm->id)
                      @if($user->efetivo->opm->id == $opm->id)
                        selected 
                      @endif 
                    @endisset ><p> {{ $opm->opm_sigla }} </p></option>
                  @endforeach
                </select>
              </div> 

              <div class="col-xs-2"> 
                  <label for="gh">Grau Hierarquico</label>
                <select class="form-control" id="gh" name="gh" required >
                  <option value="">Selecione</option>
                  @foreach( $ghs as $gh )
                  <option value="{{ $gh->id or ''}}" 
                    @isset($user->efetivo->grauhierarquico->id)
                      @if($user->efetivo->grauhierarquico->id == $gh->id)
                        selected 
                      @endif 
                    @endisset ><p> {{ $gh->sigla }} </p></option>
                  @endforeach
                </select>
              </div> 
              <div class="col-xs-2">
                    <label for="Status">Status</label>
                  <select class="form-control" id="status" name="status">
                      <option value="">Selecione</option>
                      <option value="Ativo"  @if($user->status == 'Ativo')
                          selected 
                        @endif >Ativo</option>
                      <option value="Inativo"  @if($user->status == 'Inativo')
                          selected 
                        @endif >Inativo</option>
                    </select>
                </div>

        </div>

        <div class="row">
              <div class="col-xs-6">
                <div class="input-group">
                    <label for="email">Email</label>
                      <input type="email" class="form-control " 
                       id="email" name="email" value="{{$user->email or '' }}">
                </div>  

              </div>
            </div>
<br>
</div>
              <div class="box-footer">
                <div class="btn-toolbar pull-right">
                   <button type="submit" class="btn btn-success btn-lg">Salvar</button>
                 </div>
              </div>
    </form>

    <p>Lista de Papéis para: {{$user->efetivo->grauhierarquico->sigla}}  {{$user->efetivo->nome}}  :: {{$user->efetivo->opm->opm_sigla}}</p>
    <div class="box">
		<div class="box-header">
			<form action="{{route('admin.usuarios.papelSalvar',$user->id)}}" method="post">
			{{ csrf_field() }}
			<div class="form-group col-xs-2">
				<select name="papel_id" class="form-control">
					@foreach($papeis as $papel)
					<option value="{{$papel->id}}">{{$papel->nome}}</option>
					@endforeach
				</select>
				
			</div>
			<button class="btn btn-primary">Adicionar</button>
			</form>


		</div>

		<div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
					<tr>

						<th>Papel</th>
						<th>Descrição</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
				@foreach($user->papeis as $papel)
					<tr>
						<td>{{ $papel->nome }}</td>
						<td>{{ $papel->descricao }}</td>

						<td>

							<form action="{{route('admin.usuarios.papelDestroy',[$user->id,$papel->id])}}" method="post">
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
									<button title="Deletar" class="btn  btn-danger btn-flat"><i class="fa fa-trash"></i></button>
							</form>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>

        </div>

	</div>


    <div class="clearfix"></div>
                    
                  </form>
              </div>
          </div>
      </div>
  </div>

    </section>
@stop

@section('js')
<script>
 $(document).ready(function(){
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

});


  </script>
@stop