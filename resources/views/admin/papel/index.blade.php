@extends('adminlte::page')

@section('title', 'SGCOM | Admin')

@section('content_header')
    <h1>Papeis</h1>
    <ol class="breadcrumb">
	<li><a href="{{route('admin.papeis')}}">Papéis</a></li>
	<li><a href="{{route('admin.papeis.novo')}}">papel</a></li>
    </ol>
@stop
@section('content')
	<div class="container">
		<h2 class="center">Lista de Papéis</h2>
		@can('papel-list')
		<div class="box-body">
			<table id="table1" class="table table-bordered table-striped">
			  <thead>
					<tr>						
						<th>Nome</th>
						<th>Descrição</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
				@foreach($papeis as $papel)
			
					<tr>
						<td>{{ $papel->nome }}</td>
						<td>{{ $papel->descricao }}</td>

						<td>
							<form action="{{route('admin.papeis.papelDestroy',$papel->id)}}" method="post">
								<a title="Editar" class="btn btn-primary btn-flat" href="{{ route('admin.papeis.edit',$papel->id) }}"><i class="fa fa-edit"></i></a>
							<a title="Permissões" class="btn btn-info btn-flat" href="{{route('admin.papeis.permissao',$papel->id)}}"><i class="fa fa-lock"></i></a>
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
									<button title="Deletar" 
									onclick="return confirmExcluir();"
									class="btn btn-danger btn-flat"><i class="fa fa-trash-o"></i></button>
							</form>
						</td>
					</tr>
				
				@endforeach
				</tbody>
			</table>

		</div>
		<div class="row">
			<a class="btn btn-primary" href="{{route('admin.papeis.novo')}}">Novo</a>
		</div>
		@endcan
	</div>

@endsection
@section('js')
<script>
  function confirmExcluir() {
  if(!confirm("Confirma exclusão deste a Papel?"))
  event.preventDefault();
}
</script>

@stop