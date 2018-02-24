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
          <li> <a>Productos</a> </li>
          <li class="active"> <strong>Listado</strong> </li>
        </ol>
      </div>
      <div class="wrapper-content ">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Listado de productos</h5>
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
                  <div >
                    <table id="productos" class="table  responsive nowrap table-bordered" cellspacing="0" width="100%">
                      <thead class="align-center">
                        <tr>
                          <th>Foto</th>
                          <th>Nombre</th>
                          <th class="align-center">Precio</th>
                          <th class="align-center">Comisión</th>
                          <th class="align-center">Estado</th>
                          <th>Opciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                          if ($productos != 0) {

                            foreach ($productos as $producto) {
                        ?>
                        <tr>
                          <td class="align-center">
                            <img class="foto-producto" src="<?=$producto['foto']?>">
                          </td>
                          <td><?=$producto['nombre_producto']?></td>
                          <td class="align-center">$<?= number_format($producto['precio'],0,'.',',')?></td>
                          <td class="align-center">$<?= number_format($producto['comision'],0,'.',',') ?></td>
                          <td class="align-center">
                            <select>
                              <option <?php echo ($producto['estado']==1) ? 'selected' : ''; ?> value="1">Activo</option>
                              <option <?php echo ($producto['estado']==2) ? 'selected' : ''; ?> value="2">Inactivo</option>
                              <option <?php echo ($producto['estado']==3) ? 'selected' : ''; ?> value="3">Eliminado</option>
                            </select>
                          </td>
                          <td class="align-center">
                            <a title="Editar" href="<?=base_url();?>producto/obtener/<?= $producto['id_producto'] ?>" class="btn orange btn-mini" type="button">
                              <i class="fa fa-pencil"></i>
                            </a>
                            <a class="btn red btn-mini btn-cicle" type="button">
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
        </div>
      </div>      
      <style type="text/css">
        table td{
          vertical-align: middle !important;
        }
        .align-center{
          text-align: center;
        }
        .foto-producto{
          height: 70px;
          width: auto;
          margin: 0 auto;
          border: 2px solid #000;
          border-radius: 50%;
        }
      </style>
      <script type="text/javascript">
        $(document).ready(function(){
          $("#productos").DataTable({
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
            }
          });
        });
      </script>
  <?php $this->load->view('includes/footer'); ?> 