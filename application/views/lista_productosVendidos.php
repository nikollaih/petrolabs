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
          <li class="active"> <strong>Vendidos</strong> </li>
        </ol>
      </div>
      <div class="wrapper-content ">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5 style="margin-top: 11px;">Productos vendidos</h5>
                <div class="form-group col-md-2 col-md-offset-2" style="margin-bottom: 0;">
                  <select class="form-control" onchange="setItemSelect('ciudad-usuario-form', 'Ciudad'); cargarFiltro(this, 'Departamento'); validarSelect('departamento-usuario-form', $('#departamento-usuario-form').val(), this);" required id="departamento-usuario-form" data-ciudad-usuario="0" name="filtro[departamento]">
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
                  <select class="form-control" onchange="setItemSelect('estacion-usuario-form', 'Estación'); cargarFiltro(this, 'Ciudad'); validarSelect('ciudad-usuario-form', $('#ciudad-usuario-form').val(), this);" required id="ciudad-usuario-form" data-estacion-usuario="0" name="filtro[ciudad]">
                    <option value="0">Ciudad</option>
                  </select>
                </div>
                <div class="form-group col-md-2" style="margin-bottom: 0;">
                  <select class="form-control" onchange="setItemSelect('islero-usuario-form', 'Islero'); cargarFiltro(this, 'Estacion'); validarSelect('estacion-usuario-form', $('#estacion-usuario-form').val(), this);" required id="estacion-usuario-form" data-islero="0" name="filtro[estacion]">
                    <option value="0">Estación</option>
                  </select>
                </div>
                <div class="form-group col-md-2"  style="margin-bottom: 0;">
                  <select class="form-control" onchange="cargarFiltro(this, 'Islero');" required id="islero-usuario-form" name="filtro[islero]">
                    <option value="0">Islero</option>
                  </select>
                </div>
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
                  <div >
                    <table id="productos" class="table  responsive nowrap table-bordered" cellspacing="0" width="100%">
                      <thead class="align-center">
                        <tr>
                          <th>Foto</th>
                          <th style="width: 350px !important;">Nombre</th>
                          <th class="align-center numeric-field">Cantidad</th>
                          <th class="align-center numeric-field">Total venta</th>
                          <th class="align-center numeric-field">Comisión generada</th>
                        </tr>
                      </thead>
                      <tbody id="body-tabla-ventas">
                        <?php
                          if ($ventas != 0) {
                            foreach ($ventas as $venta) {
                        ?>
                        <tr>
                          <td class="align-center">
                            <img class="foto-producto" src="<?=base_url();?>uploads/productos/<?=$venta['foto'];?>">
                          </td>
                          <td><?=$venta['nombre_producto'];?></td>
                          <td class="align-center"><?=$venta['cantidad'];?></td>
                          <td class="align-center">$<?= number_format($venta['total'],0,'.',',') ?></td>
                          <td class="align-center">$<?= number_format($venta['comision_total'],0,'.',',') ?></td>
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
        .numeric-field{
          width: 100px;
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
      <script type="text/javascript">
        function validarSelect(select, valor, element) {
          if (select == 'departamento-usuario-form') {
            $('#islero-usuario-form').html('<option selected value="0">Islero</option>');
            $('#estacion-usuario-form').html('<option selected value="0">Estación</option>');
            $('#ciudad-usuario-form').html('<option selected value="0">Ciudad</option>');
            cargarFiltro(element, 'Departamento');
          }else if(select == 'ciudad-usuario-form' && valor == 0){
            $('#islero-usuario-form').html('<option selected value="0">Islero</option>');
            $('#estacion-usuario-form').html('<option selected value="0">Estación</option>');
            cargarFiltro(element, 'Ciudad');
          }else if(select == 'estacion-usuario-form' && valor == 0){
            $('#islero-usuario-form').html('<option selected value="0">Islero</option>');
            cargarFiltro(element, 'Estacion');
          }
        }
      </script>
  <?php $this->load->view('includes/footer'); ?> 