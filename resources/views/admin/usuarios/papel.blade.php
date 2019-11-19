@extends('adminlte::page')

@section('title', 'SGCOM | Admin')

@section('content_header')
    <h1>Papéis do usuário</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('admin.usuarios')}}">Usuários</a></li>
        <li><a href="#">Usuário</a></li>
    </ol>
@stop
@section('content')
<p >Lista de Papéis para: {{$usuario->efetivo->grauhierarquico->sigla}}  {{$usuario->efetivo->nome}}  :: {{$usuario->efetivo->opm->opm_sigla}}</p>
    <div class="box">
		<div class="box-header">
			<form action="{{route('admin.usuarios.papelSalvar',$usuario->id)}}" method="post">
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
				@foreach($usuario->papeis as $papel)
					<tr>
						<td>{{ $papel->nome }}</td>
						<td>{{ $papel->descricao }}</td>

						<td>

							<form action="{{route('admin.usuarios.papelDestroy',[$usuario->id,$papel->id])}}" method="post">
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
									<button title="Deletar" class="btn red"><i class="fa fa-trash"></i></button>
							</form>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>

        </div>

	</div>

@endsection
