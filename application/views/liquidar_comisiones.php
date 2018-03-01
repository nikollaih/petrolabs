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
                  <input type="date" class="form-control" name="filtro[fecha_final]">
                </div>
                <div class="form-group col-md-4" style="margin-bottom: 0; float: right;">
                  <label>Fecha inicial</label>
                  <input type="date" class="form-control" name="filtro[fecha_inicial]">
                </div>
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
                  <div class="row">
                    
                  </div>
                  <div>
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
                        <tr>
                          <td class="align-center">
                            <img class="foto-producto" src="<?=base_url();?>uploads/productos/1">
                          </td>
                          <td>Hola</td>
                          <td class="align-center">Hola</td>
                          <td class="align-center">12312</td>
                          <td class="align-center">12312</td>
                        </tr>
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