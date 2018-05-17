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
          <li> <a href="<?=base_url()?>producto">Inicio</a> </li>
          <li> <a href="<?=base_url()?>comision">Comisiones</a> </li>
          <li class="active"> <strong>General</strong> </li>          
        </ol>
      </div>
      <div class="wrapper-content ">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5 style="margin-top: 21px; font-size: 1.3em;">Lista de comisiones</h5>
                <div class="form-group col-md-4" style="margin-bottom: 0; float: right;">
                  <label>Fecha final</label>
                  <input type="date" class="form-control" id="fecha_fin" name="filtro[fecha_final]" value="<?=date('Y-m-d')?>">
                </div>
                <div class="form-group col-md-4" style="margin-bottom: 0; float: right;">
                  <label>Fecha inicial</label>
                  <input type="date" class="form-control" id="fecha_inicial" name="filtro[fecha_inicial]" value="<?=date('Y');?>-01-01">
                </div>
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
                  <div class="row">
                    <div class="form-group col-md-2 col-md-offset-3" style="margin-bottom: 0;">
                      <select class="form-control" required id="departamento-usuario-form" onchange="validarSelectComisiones('departamento-usuario-form', $(this).val()); aplicarFiltro('departamento-usuario-form', 'Departamento',0);">
                        <option value="0">Departamento</option>
                        <?php 
                          if ($departamentos != 0) {
                            foreach ($departamentos as $departamento) {
                        ?>
                        <option value="<?=$departamento['id_departamento'];?>"><?=$departamento['nombre_departamento'];?></option>
                        <?php
                            }
                          }
                        ?>  
                      </select>
                    </div>
                    <div class="form-group col-md-2" style="margin-bottom: 0;">
                      <select class=" form-control" required id="ciudad" onchange="validarSelectComisiones('ciudad', $(this).val()); aplicarFiltro('ciudad', 'Ciudad',0);">
                        <option value="0">Ciudad</option>
                      </select>
                    </div>
                    <div class="form-group col-md-2" style="margin-bottom: 0;">
                      <select class=" form-control" required id="estacion" onchange="validarSelectComisiones('estacion', $(this).val()); aplicarFiltro('estacion', 'Estacion',0);">
                        <option value="0">Estación</option>
                      </select>
                    </div>
                  </div>
                  <br>
                  <button class="btn blue tn-large" style="margin-bottom: 15px;"><i class="fa fa-money"></i> Liquidar seleccionados</button>
                  <div>
                    <table id="productos" class="table responsive nowrap table-bordered " cellspacing="0">
                      <thead class="align-center">
                        <tr>
                          <th style="width: 50px !important;">
                            <input id="selectAll" type="checkbox"></input>
                          </th>
                          <th style="width: 350px !important;">Nombre</th>
                          <th style="width: 200px !important;" class="align-center">Tipo incentivo</th>
                          <th class="align-center">Comisión generada</th>
                          <th class="align-center">Comisión 2%</th>
                          <th class="align-center">Opciones</th>
                        </tr>
                      </thead>
                      <tbody id="body-tabla-ventas">
                        <?php
                          if ($comisiones != 0) {
                            foreach ($comisiones as $comision) {
                        ?>
                        <tr id="comision_<?=$comision['id']?>">
                          <td class="align-center">
                            <input type="checkbox"></input>
                          </td>
                          <td><?=$comision['nombre']?></td>
                          <td><?=$comision['incentivo']?></td>
                          <td class="align-center">$<?= number_format($comision['comision'],0,'.',',') ?></td>
                          <td class="align-center">$<?= number_format((($comision['comision']*2)/100),2,'.',',') ?></td>
                          <td class="align-center">
                            <!--<a title="Ver" href="<?=base_url();?>producto/obtener/" class="btn orange btn-mini" type="button">
                              <i class="fa fa-eye"></i>
                              Detalles
                            </a>-->
                            <?php
                                if (tipoUsuarioConectado() == 1) {
                            ?>
                                  <a class="btn blue btn-mini" type="button" onclick="liquidarComisiones(<?=$comision['id_incentivo']?>, 'Departamento', <?=$comision['id']?>, this);">
                                    <i class="fa fa-money"></i>
                                    Liquidar
                                  </a>
                            <?php
                                }
                                else{
                                  echo '<p>- N/A -</p>';
                                }
                            ?>
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
      <script type="text/javascript" src="<?=base_url();?>resources/js/ventas.js"></script>
      <script type="text/javascript" src="<?=base_url();?>resources/js/comisiones.js"></script>
  <?php $this->load->view('includes/footer'); ?> 