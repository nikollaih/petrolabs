<?php $this->load->view('includes/tags'); ?>
<body class="page-header-fixed ">
<?php $this->load->view('includes/top-navegation'); ?>
<div class="clearfix"> </div>
<div class="page-container">
  <?php $this->load->view('includes/site-bar'); ?>
  <!-- Start page content wrapper -->
  <div class="page-content-wrapper animated fadeInRight">
    <div class="page-content">
      <div class="row border-bottom white-bg dashboard-header">
        <ol class="breadcrumb">
          <li> <a>Inicio</a> </li>
          <li> <a>Estaciones</a> </li>
          <li class="active"> <strong>Listado</strong> </li>
        </ol>
      </div>
      <div class="wrapper-content ">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Listado de estaciones</h5>
                <div class="form-group col-md-2 col-md-offset-2" style="margin-bottom: 0;">
                  <select class="form-control lista-estaciones" required id="departamento-usuario-form" data-ciudad-usuario="0" name="filtro[departamento]">
                    <option value="">Departamento</option>
                    <?php 
                      if ($departamentos != 0) {
                        foreach ($departamentos as $departamento) {
                          if (tipoUsuarioConectado() == 2) {
                            $dptos = unserialize(getUsuarioConectado()['dptos']);
                            for ($i=0; $i < count($dptos); $i++) { 
                              if ($departamento['id_departamento'] == $dptos[$i]) {
                    ?>
                                <option value="<?=$departamento['id_departamento'];?>"><?=$departamento['nombre_departamento'];?></option>
                    <?php
                              }
                            }  
                          }
                          else if(tipoUsuarioConectado() == 1){
                    ?>
                            <option value="<?=$departamento['id_departamento'];?>"><?=$departamento['nombre_departamento'];?></option>
                    <?php
                          }
                    ?>
                    <?php
                        }
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group col-md-2" style="margin-bottom: 0;">
                  <select class="form-control lista-estaciones" required id="ciudad-usuario-form" data-estacion-usuario="0" name="filtro[ciudad]">
                    <option value="">Ciudad</option>
                  </select>
                </div>
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
                  <div >
                    <table id="estaciones" class="table  responsive nowrap table-bordered" cellspacing="0" width="100%">
                      <thead class="align-center">
                        <tr>
                          <th>Nombre</th>
                          <th class="align-center">Asesor</th>
                          <th class="align-center">Departamento</th>
                          <th class="align-center">Ciudad</th>
                          <th style="width: 100px;">Opciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>      
      <style type="text/css">
        table td{
          vertical-align: middle !important;
        }
        .align-center{
          text-align: center;
        }
        .foto-estacion{
          width: 70px;
          height: 70px;
          border: 2px dashed #29aba4;
          position: relative;
          border-radius: 50% !important;
          overflow: hidden;
          text-align: center;
          margin: 0 auto;
        }

        #estaciones tr td:last-child{
        	text-align: center !important;
        }

        #estaciones tr td:last-child a{
        	margin-right: 3px;
        }
      </style>
      <script type="text/javascript">
      	var tabla_estaciones;
        $(document).ready(function(){
          tabla_estaciones = $("#estaciones").DataTable({
            language: {
              "decimal": ".", 
              "emptyTable": "No hay información",
              "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
              "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
              "infoFiltered": "(Filtrado de _MAX_ entradas en total)",
              "infoPostFix": "",
              "thousands": ",",
              "lengthMenu": "Mostrar _MENU_ Entradas",
              "loadingRecords": "Cargando...",
              "processing": "Procesando...",
              "search": "Buscar:",
              "zeroRecords": "No hay coincidencias",
              "paginate": {
                  "first": "Primero",
                  "last": "Ultimo",
                  "next": "Siguiente",
                  "previous": "Anterior"
              }
            },
            'iDisplayLength' : 25
          });
        });
      </script>
  <?php $this->load->view('includes/footer'); ?> 