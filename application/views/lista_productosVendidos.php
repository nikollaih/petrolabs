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
                  <select class="form-control" required id="departamento-usuario-form" data-ciudad-usuario="0" name="filtro[departamento]">
                    <option value="0">Departamento</option>
                    <option value="1">Quindío</option>
                    <option value="2">Valle del cauca</option>
                  </select>
                </div>
                <div class="form-group col-md-2" style="margin-bottom: 0;">
                  <select class="form-control" required id="ciudad-usuario-form" data-estacion-usuario="0" name="filtro[ciudad]">
                    <option value="0">Ciudad</option>
                    <option value="1">Armenia</option>
                    <option value="2">La tebaida</option>
                    <option value="3">Cali</option>
                  </select>
                </div>
                <div class="form-group col-md-2" style="margin-bottom: 0;">
                  <select class="form-control" required id="estacion-usuario-form" data-islero="0" name="filtro[estacion]">
                    <option value="0">Estación</option>
                    <option value="1">Quindío</option>
                    <option value="2">Valle del cauca</option>
                  </select>
                </div>
                <div class="form-group col-md-2" style="margin-bottom: 0;">
                  <select class="form-control" required id="filtro[ciudad]" name="filtro[islero]">
                    <option value="0">Islero</option>
                    <option value="1">Armenia</option>
                    <option value="2">La tebaida</option>
                    <option value="3">Cali</option>
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
                      <tbody>
                        <tr>
                          <td class="align-center">
                            <img class="foto-producto" src="<?=base_url();?>uploads/productos/producto_15_1519547702.jpeg">
                          </td>
                          <td>Producto 1</td>
                          <td class="align-center">5</td>
                          <td class="align-center">$<?= number_format(10000*5,0,'.',',') ?></td>
                          <td class="align-center">$<?= number_format(1000*5,0,'.',',') ?></td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="2" style="text-align: right;">Totales</td>
                          <td class="align-center">5</td>
                          <td class="align-center">$<?= number_format(10000*5,0,'.',',') ?></td>
                          <td class="align-center">$<?= number_format(1000*5,0,'.',',') ?></td>
                        </tr>
                      </tfoot>
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