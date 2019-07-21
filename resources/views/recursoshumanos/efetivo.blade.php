@extends('adminlte::page')

@section('title', 'SGCOM | RH')

@section('content_header')
    <h1>Recursos Humanos</h1>
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">RH</a></li>
    </ol>
@stop

@section('content')
    <p>Gestão de Efetivo</p>
    <div class="box">
            <div class="box-header">
            <form action="{{route('opm.search')}}" method="POST" class="form form-inline">
              {!! csrf_field() !!}    
              <input  type="text" name="opm_sigla"  id="opm_sigla" class="form-control"
               placeholder="Informe a OPM para buscar"/>

                  <button  type="submit" class="btn btn-primary">Pesquisar</button>
              </form>
            </div>
            <div class="box-header">
              <button  type="submit" class="btn btn-primary">Novo</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th></th>
                  <th>Grau Herarquico</th>
                  <th>Nome</th>
                  <th>Matrícula</th>
                  <th>OPM</th>
                  <th>CPF</th>
                  <th>Sexo</th>
                </tr>
                </thead>
                <tbody>
                @forelse($efetivos as $efetivo)
                <tr>
                  <td>{{$efetivo->id}}</td>
                  <td>{{$efetivo->grauhierarquico->sigla}}</td>
                  <td>{{$efetivo->nome}}</td>
                  <td>{{$efetivo->matricula}}</td>
                  <td>{{$efetivo->opm->opm_sigla}}</td>
                  <td>{{$efetivo->cpf}}</td>
                  <td>{{$efetivo->sexo}}</td>
                </tr>
                @empty
                @endforelse 
               </tbody>
                <tfoot>
                <tr>
                  <th>#</th></th>
                  <th>Grau Herarquico</th>
                  <th>Nome</th>
                  <th>Matrícula</th>
                  <th>OPM</th>
                  <th>CPF</th>
                  <th>Sexo</th>
                </tr>
                </tfoot>
              </table>
              <div >
            {!! $efetivos->links()!!}
            </div>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@stop

@section('js')
    <script> console.log('Hi!'); </script>

    <!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->
<script>
$('#example1').DataTable(
    {
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    })
</script>
@stop