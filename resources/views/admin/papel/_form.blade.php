<div class="row">
		<div class="col-xs-2">
		<label>Nome do papel</label>
	<input type="text" name="nome" class="form-control" required
	 value="{{ isset($papel->nome) ? $papel->nome : '' }}">
		</div>
</div>

<div class="row">
	<div class="col-xs-4">
	<label>Descrição</label>
	<input type="text" name="descricao" class="form-control"required
	 value="{{ isset($papel->descricao) ? $papel->descricao : '' }}">
</div>
</div>



