<?php $this->load->view('includes/tags'); ?>
<script type="text/javascript" src="<?= base_url() ?>resources/js/productos.js"></script>
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
                <h5 style="margin: 0; margin-top: 7px;">Listado de productos</h5>
                <div class="row">
                  <div class="col-md-2" style="float: right;">
                    <a class="btn btn-block btn-primary" href="<?= base_url() ?>excels/exportarProductos" target="_blank">
                      <i class="fa fa-file-excel-o"></i> Exportar a excel
                    </a>
                  </div>
                </div>
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
                          <?php
                            if (tipoUsuarioConectado() == 1) {
                          ?>
                              <th>Opciones</th>
                          <?php
                            }
                          ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                          if ($productos != 0) {
                            foreach ($productos as $producto) {
                        ?>
                        <tr>
                          <td class="align-center">
                            <img class="foto-producto" src="<?=base_url();?>uploads/productos/<?=$producto['foto']?>">
                          </td>
                          <td><?=$producto['nombre_producto']?></td>
                          <td class="align-center">$<?= number_format($producto['precio'],0,'.',',')?></td>
                          <td class="align-center">$<?= number_format($producto['comision'],0,'.',',') ?></td>
                          <td class="align-center">
                          <?php
                            if (tipoUsuarioConectado() == 1) {
                          ?>
                              <select id="producto[estado]" name="producto[estado]" onchange="enviarFormulario(this,'<?=$producto['id_producto']?>');">
                                <option <?= ($producto['estado']==1) ? 'selected' : ''; ?> value="1">Activo</option>
                                <option <?= ($producto['estado']==2) ? 'selected' : ''; ?> value="2">Inactivo</option>
                                <option <?= ($producto['estado']==3) ? 'selected' : ''; ?> value="3">Eliminado</option>
                              </select>
                          <?php
                            }
                            else{
                              switch ($producto['estado']) {
                                case '1':
                                  echo 'Activo';
                                  break;
                                case '2':
                                  echo 'Inactivo';
                                  break;
                                case '3':
                                  echo 'Eliminado';
                                  break;
                                
                                default:
                                  # code...
                                  break;
                              }
                            }
                          ?>
                          </td>
                          <?php
                            if (tipoUsuarioConectado() == 1) {
                          ?>
                              <td class="align-center">
                                <a title="Editar" href="<?=base_url();?>producto/obtener/<?= $producto['id_producto'] ?>" class="btn orange btn-mini" type="button">
                                  <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn red btn-mini btn-cicle e-producto" data-id="<?= $producto['id_producto'] ?>" type="button">
                                  <i class="fa fa-trash"></i>
                                </a>
                              </td>
                          <?php
                            }
                          ?>
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
          width: 70px;
          height: 70px;
          border: 2px dashed #29aba4;
          position: relative;
          border-radius: 50% !important;
          overflow: hidden;
          text-align: center;
          margin: 0 auto;
        }
      </style>
      <script type="text/javascript">
        
      </script>
  <?php $this->load->view('includes/footer'); ?> 