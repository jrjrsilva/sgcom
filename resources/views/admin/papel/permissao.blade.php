@extends('adminlte::page')

@section('title', 'SGCOM | Admin')

@section('content_header')
    <h1>Permissões</h1>
    <ol class="breadcrumb">
	<li><a href="{{route('admin.papeis')}}">Papéis</a></li>
        <li><a href="">Usuários</a></li>
    </ol>
@stop

@section('content')
	<div class="container">
		<h2 class="center">Lista de Permissões para o papel: {{$papel->nome}}</h2>
		<div class="row">
			<form action="{{route('admin.papeis.permissao.store',$papel->id)}}" method="post">
			{{ csrf_field() }}
			<div class="input-field">
				<select name="permissao_id">
					@foreach($permissoes as $valor)
					<option value="{{$valor->id}}">{{$valor->nome}}</option>
					@endforeach
				</select>
			</div>
				<button class="btn btn-primary">Adicionar</button>
			</form>


		</div>

		<div class="box-body">
			<table id="tb1" class="table table-bordered table-striped">
			  <thead>
					<tr>

						<th>Permissão</th>
						<th>Descrição</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
				@foreach($papel->permissoes as $permissao)
					<tr>
						<td>{{ $permissao->nome }}</td>
						<td>{{ $permissao->descricao }}</td>

						<td>

							<form action="{{route('admin.papeis.permissao.destroy',[$papel->id,$permissao->id])}}" method="post">
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
									<button title="Deletar" class="btn btn-danger btn-flat"
									onclick="confirmExcluir();"
									><i class="fa fa-trash-o"></i></button>
							</form>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>

		</div>

	</div>

@endsection

@section('js')
<script>
  function confirmExcluir() {
  if(!confirm("Confirma exclusão desta permissão?"))
  event.preventDefault();
}
</script>

@stop
