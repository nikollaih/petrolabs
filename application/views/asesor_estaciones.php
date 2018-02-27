<?php $this->load->view('includes/tags'); ?>
<script type="text/javascript" src="<?= base_url() ?>resources/plugins/sweetalert/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>resources/plugins/sweetalert/dist/sweetalert2.min.css">
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
          <li> <a>Usuarios</a> </li>
          <li> <a>Asesor</a> </li>
          <li> <a>Estaciones</a> </li>
          <li class="active"> <strong><?= $usuario['nombre'].' '.$usuario['apellidos'] ?></strong> </li>
        </ol>
      </div>
      <div class="wrapper-content ">
        <div class="row">
          <div class="col-lg-7">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Listado de estaciones del asesor </h5>
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
                  <div >
                    <table id="estaciones-asesor" class="table  responsive nowrap table-bordered" cellspacing="0" width="100%">
                      <thead class="align-center">
                        <tr>
                          <th>Estacion</th>
                          <th style="width: 100px;">Opciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                          if ($estaciones_usuario != 0) {
                            foreach ($estaciones_usuario as $estacion) {
                        ?>
                        <tr>
                          <td><?= $estacion['nombre_estaciones'] ?></td>
                          <td class="align-center">
                            <a class="btn red btn-mini btn-cicle eliminar-estacion-asesor" data-estacion="<?= $estacion['id_estacion'] ?>" data-asesor="<?= $usuario['id_usuario'] ?>" type="button">
                              <i class="fa fa-trash"></i>
                            </a>
                          </td>
                        </tr>
                        <?php
                            }
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5">
          	<div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Asignar estación</h5>
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
                  <div class="row">
                    <div class="col-md-8 col-sm-12">
                    	 <select id="estacion-asesor" class="form-control">
                    	 	<option value="0">Seleccione una estacion</option>
                    	 	<?php
                    	 		if ($estaciones != 0) {
                    	 			foreach ($estaciones as $estacion) {
                    	 	?>
                    	 				<option value="<?= $estacion['id_estacion'] ?>"><?= $estacion['nombre_estaciones'] ?></option>
                    	 	<?php
                    	 			}
                    	 		}
                    	 	?>
                    	 </select>
                    </div>
                    <div class="col-md-4 col-sm-12">
                    	<button data-asesor="<?= $usuario['id_usuario'] ?>" class="btn btn-block btn-success" id="slt-estacion-asesor" type="button"><i class="fa fa-link"></i> Asignar</button>
                    </div>
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
        .foto-usuario{
          height: 70px;
          width: auto;
          margin: 0 auto;
          border: 2px solid #000;
          border-radius: 50%;
        }

        .icon-table-link{
        	font-size: 1.5em;
        }
      </style>
      <script type="text/javascript">
        var tabla_estaciones_asesor;
        $(document).ready(function(){
          tabla_estaciones_asesor = $("#estaciones-asesor").DataTable({
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
              },
            },
            'iDisplayLength' : 25
          });
        });
      </script>
  <?php $this->load->view('includes/footer'); ?> 