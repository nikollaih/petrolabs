<?php $this->load->view('includes/tags'); ?>
<script type="text/javascript" src="<?= base_url() ?>resources/js/facturas.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>resources/css/facturas.css">
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
          <li class="active"> <strong>Facturas</strong> </li>
        </ol>
      </div>
      <div class="wrapper-content ">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5 style="margin: 0; margin-top: 7px;">Listado de facturas</h5>
                <div data-tipo="1" class="form-group col-md-2 incentivo-header" style="margin-bottom: 0; float: right; text-align: right;">
                  <label class="incentivo-1 incentivo-header"></label>
                  Efectivo
                </div>
                <div data-tipo="2" class="form-group col-md-2 incentivo-header" style="margin-bottom: 0; float: right; text-align: right;">
                  <label class="incentivo-header incentivo-2"></label>
                  Exito
                </div>
                <div data-tipo="3" class="form-group col-md-2 incentivo-header" style="margin-bottom: 0; float: right; text-align: right;">
                  <label class="incentivo-header incentivo-3"></label>
                  Catalogo
                </div>
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label>Asesor</label>
                      <select id="asesor-factura" class="form-control item-filtro-factura">
                        <option value="0">Todos</option>
                        <?php 
                          if ($asesores != 0) {
                            foreach ($asesores as $asesor) {
                        ?>
                        <option value="<?=$asesor['id_usuario'];?>"><?=$asesor['nombre'].' '.$asesor['apellidos'];?></option>
                        <?php
                            }
                          }
                        ?>  
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Fecha inicial</label>
                      <input type="date" class="form-control item-filtro-factura" id="fecha_inicial" name="filtro[fecha_inicial]" value="<?=date('Y-m');?>-01">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Fecha final</label>
                      <input type="date" class="form-control item-filtro-factura" id="fecha_fin" name="filtro[fecha_final]" value="<?=date('Y-m-d')?>">
                    </div>
                  </div>
                  <div id="facturas" class="row">
                    <?php
                      if ($facturas != 0) {
                        foreach ($facturas as $f) {
                    ?>
                          <div class="col-md-3 col-sm-6 content-factura incentivo-t-<?php echo $f['incentivo'] ?>">
                            <article id="<?php echo $f['id_factura'] ?>" class="item-factura">
                              <label title="<?php echo $f['incentivo'] ?>" class="etiqueta incentivo-<?php echo $f['incentivo'] ?>"></label>
                              <div class="content-img">
                                <a target="blank" href="<?php echo base_url() ?>pdf/factura/<?php echo $f['id_factura'].'/'.$f['nombre'].' '. $f['apellidos'] ?>">
                                  <img src="<?php echo base_url() ?>resources/images/pdf.png">
                                </a>
                              </div>
                              <div class="content-bottom">
                                <p><i class="fa fa-user"></i> <?php echo $f['nombre'].' '. $f['apellidos'] ?></p>
                                <p><i class="fa fa-calendar"></i> <?php echo $f['fecha_visual'] ?></p>
                              </div>
                            </article>
                          </div>
                    <?php
                        }
                      }
                      else{
                        echo '<p style="padding: 11px;">No se han encontrado facturas</p>';
                      }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> 
  <?php $this->load->view('includes/footer'); ?> 