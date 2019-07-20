@extends('adminlte::page')

@section('title', 'SGCOM | Admin')

@section('content_header')
    <h1>OPM</h1>
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">OPM</a></li>
    </ol>
@stop

@section('content')
    <p>Gestão de OPM</p>
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
              <button  type="submit" class="btn btn-primary">Nova OPM</button>
             
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th></th>
                  <th>OPM</th>
                  <th>Descrição</th>
                  <th>CPR</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($opms as $opm)
                <tr>
                  <td>{{$opm->id}}</td>
                  <td>{{$opm->opm_sigla}}</td>
                  <td>{{$opm->descricao}}</td>
                  <td>{{$opm->cpr->sigla}}</td>
                </tr>
                @empty
                @endforelse 
               </tbody>
                <tfoot>
                <tr>
                  <th>#</th>
                  <th>OPM</th>
                  <th>Descrição</th>
                </tr>
                </tfoot>
              </table>
              <div >
            {!! $opms->links()!!}
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
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
</script>
@stop