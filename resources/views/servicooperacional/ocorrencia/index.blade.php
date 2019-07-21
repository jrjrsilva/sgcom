@extends('adminlte::page')

@section('title', 'SGCOM | Admin')

@section('content_header')
    <h1>Serviço Operacional</h1>
    <ol class="breadcrumb">
        <li><a href="">Serviço Operacional</a></li>
        <li><a href="">Ocorrência</a></li>
    </ol>
@stop

@section('content')

    <h2>Ocorrência</h2>
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

    <form role="form">
    

 <!--DADOS DA OCORRÊNCIA-->   

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Dados da Ocorrência</h3>
        </div><br>

                
        <div class="row">
              <div class="col-xs-4"> 
                <select class="form-control" id="opm">
                  <option>Selecione a OPM</option>
                  @foreach( $opms as $opm )
                  <option value="{{ $opm->id }}" ><p> {{ $opm->opm_sigla }} </p></option>
                  @endforeach
                </select>
              </div> 

              <div class="col-xs-4"> 
                <input type="text" class="form-control" placeholder="Coordenador Regional" id="coord_cprca">
              </div> 

              <div class="col-xs-4"> 
                <input type="text" class="form-control" placeholder="Supervisor Regional" id="superv_cprca">
              </div>
        </div> <br>

        <div class="row">

              <div class="col-xs-4">
                <div class="input-group">
                      <input type="date" class="form-control timepicker" placeholder="Selecione a Data" id="data_ocorre">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>  

              </div>

              <div class="col-xs-4">
                  <div class="input-group">
                      <input type="time" class="form-control timepicker" placeholder="Selecione a hora" id="hora_ocorre">
                      <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                  </div>
              </div>
              
                
                
                <div class="col-xs-4">
                    <select class="form-control" id="tipo_ocorr">
                    <option>Selecione o tipo da ocorrência</option>
                    </select>
              </div>

        </div> <br>

        <div class="form-row">
              <div class="col">
              <input type="text" class="form-control" placeholder="Informe o local da ocorrência" id="local_ocorre"> 
              </div>
        </div> <br>

<!-- GUARNIÇÃO DE SERVIÇO -->

<div class="box box-solid box-primary">
          
          <div class="box-header with-border">
            <h3 class="box-title">Guarnição de Serviço</h3>
        </div><br>

        <div class="row">

        <div class="col-xs-5">
          <select class="form-control" id="policial">
            <option>Selecione o policial</option>
          </select>
      </div>

      <div class="col-xs-3">
        <select class="form-control" id="funcao">
            <option>Selecione a função</option>
            <option>Comandante</option>
            <option>Motorista</option>
            <option>Patrulheiro</option>
          </select>
      </div>

      <div class="col-xs-2">
        <select class="form-control" id="arma">
          <option>Selecione o armamento</option>
        </select>
      </div>

      <div class="col-xs-2">
      <select class="form-control" id="vtr">
          <option>Selecione a viatura</option>
        </select>
      </div>
      
   </div>
          <div class="box-footer">
            <div class="btn-toolbar">
              <button type="button" class="btn btn-info pull-right">Adicionar</button>
              <button type="button" class="btn btn-danger pull-right">Excluir</button>
             </div>
          </div>
   </div>

<!-- ENVOLVIDOS -->

        <div class="box box-solid box-default">
          
              <div class="box-header with-border">
                <h3 class="box-title">Envolvidos na Ocorrência</h3>
            </div><br>

            <div class="row">

            <div class="col-xs-2">
              <select class="form-control" id="tipo_envol">
                <option>Informe o envolvimento</option>
              </select>
          </div>

          <div class="col-xs-6">
            <input type="text" class="form-control" placeholder="Nome" id="envolvido">
          </div>

          <div class="col-xs-2">
            <select class="form-control" id="sexo">
              <option>sexo</option>
            </select>
          </div>

          <div class="col-xs-2">
              <input type="text" class="form-control" placeholder="idade" id="idade">
          </div>
          
       </div>
              <div class="box-footer">
                <div class="btn-toolbar">
                  <button type="button" class="btn btn-info pull-right">Adicionar</button>
                  <button type="button" class="btn btn-danger pull-right">Excluir</button>
                 </div>
              </div>
       </div>

<!-- DIV DESCRIÇÃO DA OCORRÊNCIA -->

        <div class="box box-warning">
                  
                  <div class="box-header with-border">
                    <h3 class="box-title">Descrição da Ocorrência</h3>
                </div><br>

                <div class="form-row">
                  <textarea class="form-control" rows="10" placeholder="Descreva a ocorrência"></textarea>
                </div><br>
                <div class="form-row">
                  <label for="arquivoOcorrencia">Anexar</label>
                  <input type="file" id="arquivoOcorrencia">
                  <p class="help-block">Anexar arquivos ou fotos à ocorrência</p>
                
                </div>
        </div>
        
<!-- Boletim de Ocorrência -->

<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Boletim de Ocorrência</h3>
        </div><br>

                
        <div class="row">
              <div class="col-xs-4"> 
                <select class="form-control" id="delegacia">
                  <option>Selecione a Delegacia</option>
                </select>
              </div> 

              <div class="col-xs-6"> 
                <input type="text" class="form-control" placeholder="Endereço" id="end_delegacia">
              </div> 

              <div class="col-xs-2"> 
              <select class="form-control" id="aisp">
                  <option>Selecione a AISP</option>
                </select>
              </div>
        </div> <br>

        <div class="row">

              <div class="col-xs-6">
                    <input type="text" class="form-control" placeholder="Informe o nome do delegado" id="delegado">                        
                </div>

                <div class="col-xs-3">
                    <input type="text" class="form-control" placeholder="Informe o nº inquérito" id="inq_policial">
                    
                </div>
                
                <div class="col-xs-3">
                   <input type="text" class="form-control" placeholder="Informe o nº do BO" id="bo">
              </div>

        </div> <br>

      
       
      <!-- Produtividade da ocorrência -->

        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Produtividade</h3>
          </div><br>

          <div class="row">

            <div class="col-xs-2">
              <label>Veículos Recuperados</label>
              <input type="number" class="form-control">
            </div>

            <div class="col-xs-1">
              <label>Armas de Fogo</label>
              <input type="number" class="form-control">
            </div>

            <div class="col-xs-1">
            <label>Armas Brancas</label>
              <input type="number" class="form-control">
            </div>

            <div class="col-xs-2">
            <label>Armas Artesanais</label>
              <input type="number" class="form-control">
            </div>

            <div class="col-xs-2">
            <label>Flagrantes</label>
              <input type="number" class="form-control">
            </div>

            <div class="col-xs-1">
            <label>TCO</label>
              <input type="number" class="form-control">
            </div>

            <div class="col-xs-2">
            <label>Menor Apreendido</label>
              <input type="number" class="form-control">
            </div>


          </div> <br>

          <div class="box box-solid box-info">
          
              <div class="box-header with-border">
                <h3 class="box-title">Drogas Apreendidas</h3>
            </div><br>

          <div class="row">

            <div class="col-xs-4">
              <select class="form-control" id="tipo_droga">
                <option>Selecione o tipo de droga</option>
                <option>Maconha</option>
                <option>Cocaína</option>
                <option>Crack</option>
                <option>Outra</option>
              </select>
            </div>

            <div class="col-xs-2">
              <input type="text" class="form-control" placeholder="Descrição de outra droga" id="outra">
            </div>

            <div class="col-xs-2">
              <input type="text" class="form-control" placeholder="Quantidade de droga" id="outra">
            </div>

                    
       </div>
              <div class="box-footer">
                <div class="btn-toolbar">
                  <button type="button" class="btn btn-info pull-right">Adicionar</button>
                  <button type="button" class="btn btn-danger pull-right">Excluir</button>
                 </div>
              </div>
       </div>
      </div>
    


        <!--FORMULÁRIO -->

      
    </div>
              <div class="box-footer">
                <div class="btn-toolbar pull-right">
                  <button type="button" class="btn btn-danger btn-lg">Limpar</button>
                  <button type="button" class="btn btn-success btn-lg">Adicionar</button>
                 </div>
              </div>
    </form>
    
           

    </section>
@stop

@section('js')

<script>
$('#tb-aisp').DataTable(
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