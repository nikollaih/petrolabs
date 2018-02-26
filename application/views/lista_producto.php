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
                            <img class="foto-producto" src="<?=base_url();?>uploads/productos/<?=$producto['foto']?>">
                          </td>
                          <td><?=$producto['nombre_producto']?></td>
                          <td class="align-center">$<?= number_format($producto['precio'],0,'.',',')?></td>
                          <td class="align-center">$<?= number_format($producto['comision'],0,'.',',') ?></td>
                          <td class="align-center">
                            <select id="producto[estado]" name="producto[estado]" onchange="enviarFormulario(this,'<?=$producto['id_producto']?>');">
                              <option <?= ($producto['estado']==1) ? 'selected' : ''; ?> value="1">Activo</option>
                              <option <?= ($producto['estado']==2) ? 'selected' : ''; ?> value="2">Inactivo</option>
                              <option <?= ($producto['estado']==3) ? 'selected' : ''; ?> value="3">Eliminado</option>
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
        function enviarFormulario(element, id){
          estado =element.value;
          $.ajax({
            method: 'post',
            url: base_url+"producto/modificarEstado/"+id,
            data:{
              estado: estado
            },
            success: function (response) {
                var datos = eval(JSON.parse(response));
                if (datos['estado']) {
                  mostrarAlerta('success', 'Exito', datos['mensaje']);
                }else{
                  mostrarAlerta('danger', 'Fallo', datos['mensaje']);

                }
            },
            error: function (e) {
                console.log(e);
            }
          });
        }

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