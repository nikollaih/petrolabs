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
          <li> <a>Usuarios</a> </li>
          <li> <a>Listado</a> </li>
          <li class="active"> <strong><?= $nombre_rol ?></strong> </li>
        </ol>
      </div>
      <div class="wrapper-content ">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Listado de usuarios (<?= $nombre_rol ?>)</h5>
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
                  <div >
                    <table id="usuarios" class="table  responsive nowrap table-bordered" cellspacing="0" width="100%">
                      <thead class="align-center">
                        <tr>
                          <th>Cedula</th>
                          <th>Nombre</th>
                          <th>Apellidos</th>
                          <th>Email</th>
                          <th>Telefono</th>
                          <th>Ciudad</th>
                          <?php
                          	if ($rol == 3) {
                          ?>
                          		<th>Estacion</th>
                          		<th>RUT</th>
                          <?php
                          	}
                          ?>
                          <?php
                            if ($rol == 2) {
                          ?>
                              <th>Comisión vigente</th>
                          <?php
                            }
                          ?>
                          <th>Opciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                          if ($usuarios != 0) {
                            $dptos = unserialize(getUsuarioConectado()['dptos']);
                            foreach ($usuarios as $usuario) {
                              $mostrar = false;
                              
                              if (tipoUsuarioConectado() == 2) {
                                  for ($i=0; $i < count($dptos); $i++) { 
                                    if ($usuario['id_departamento'] == $dptos[$i]) {
                                      $mostrar = true;
                                    }
                                  }
                              }
                              else if(tipoUsuarioConectado() == 1){
                                $mostrar = true;
                              }

                              if($mostrar){
                        ?>
                                <tr>
                                  <td><?= $usuario['cedula'] ?></td>
                                  <td><?= $usuario['nombre'] ?></td>
                                  <td><?= $usuario['apellidos'] ?></td>
                                  <td><?= $usuario['email'] ?></td>
                                  <td><?= $usuario['telefono'] ?></td>
                                  <td><?= $usuario['nombre_ciudad'] ?></td>
                                  <?php
                                  	if ($rol == 3) {
                                  ?>
                                  		<td><?= $usuario['nombre_estaciones'] ?></td>
                                  		<td class="align-center">
                                        <?php
                                          if (!empty($usuario['rut'])) {
                                        ?>
                                            <a href="<?= base_url() ?>uploads/rut/<?= $usuario['rut'] ?>" target="blank"><i class="fa fa-file icon-table-link"></i></a>
                                        <?php
                                          }
                                        ?>
                                  		</td>
                                  <?php
                                  	}
                                  ?>


                                  <?php
                                    if ($rol == 2) {
                                  ?>
                                      <td>$<?= number_format(comisionAsesor($usuario['id_usuario']), 0, ',', '.') ?></td>
                                  <?php
                                    }
                                  ?>


                                  <td class="align-center">
                                    <?php
                                      if ($rol == 2) {
                                    ?>
                                         <a title="Asignar estaciones" href="<?=base_url();?>usuario/asesorestaciones/<?= $usuario['id_usuario'] ?>/<?= stringToUrl($usuario['nombre'].' '.$usuario['apellidos']) ?>" class="btn blue btn-mini" type="button">
                                          <i class="fa fa-tint"></i>
                                        </a>
                                    <?php
                                      }
                                    ?>
                                    <a title="Editar" href="<?=base_url();?>usuario/obtener/<?= $usuario['id_usuario'] ?>/<?= $usuario['rol'] ?>/<?= stringToUrl($usuario['nombre'].' '.$usuario['apellidos']) ?>" class="btn orange btn-mini" type="button">
                                      <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn red btn-mini btn-cicle e-usuario" data-id="<?= $usuario['id_usuario'] ?>" type="button">
                                      <i class="fa fa-trash"></i>
                                    </a>
                                    </a>
                                  </td>
                                </tr>
                        <?php
                              }
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
        var tablaUsuarios;
        $(document).ready(function(){
          tablaUsuarios = $("#usuarios").DataTable({
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