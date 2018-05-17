<?php $this->load->view('includes/tags'); ?>

<body class="page-header-fixed ">
  <script src="<?= base_url() ?>resources/js/angular.js"></script>
<script type="text/javascript" src="<?= base_url() ?>resources/js/jquery.tabletojson.min.js"></script>
<script src="<?= base_url() ?>resources/js/excellentexport.min.js"></script>
    <script data-require="ui-bootstrap@0.11.0" data-semver="0.11.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.11.0.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>resources/js/ventas.js"></script>
<script type="text/javascript" src="<?=base_url();?>resources/js/comisiones.js"></script>

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
          <li class="active"> <strong>Liquidadas</strong> </li>          
        </ol>
      </div>
      <div class="wrapper-content ">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5 style="margin-top: 21px; font-size: 1.3em;">Lista de comisiones liquidadas</h5>
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
                    <div class="form-group col-md-2" style="margin-bottom: 0;">
                      <select class="form-control" required id="departamento-liquidada" onchange="validarSelectComisionesLiquidadas('departamento-liquidada', $(this).val()); aplicarFiltro('departamento-liquidada', 'Departamento',1);">
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
                      <select class=" form-control" required id="ciudad-liquidada" onchange="validarSelectComisionesLiquidadas('ciudad-liquidada', $(this).val()); aplicarFiltro('ciudad-liquidada', 'Ciudad',1);">
                        <option value="0">Ciudad</option>
                      </select>
                    </div>
                    <div class="form-group col-md-2" style="margin-bottom: 0;">
                      <select class=" form-control" required id="estacion-liquidada" onchange="validarSelectComisionesLiquidadas('estacion-liquidada', $(this).val()); aplicarFiltro('estacion-liquidada', 'Estacion',1);">
                        <option value="0">Estación</option>
                      </select>
                    </div>
                    <div class="col-md-2" style="float: right;">
                      <button class="btn btn-block btn-primary" id="comision_liq_export">
                        <i class="fa fa-file-excel-o"></i> Exportar a excel
                      </button>
                    </div>
                  </div>
                  <form id="formExportarComisiones" action="<?=base_url()?>excels/exportarComisionesLiquidadas" method="post" target="_blank">
                    <input type="hidden" id="comisionesArray" name="comisionesArray">
                    <input type="hidden" name="filtroNombre" id="filtroNombre">
                    <input type="hidden" name="tipoFiltro" id="tipoFiltro">
                  </form>
                  <br>
                  <br>
                  <div>
                    <table id="productos" class="table responsive nowrap table-bordered " cellspacing="0">
                      <thead class="align-center">
                        <tr>
                          <th style="width: 50px !important; text-align: center;">Item</th>
                          <th style="width: 350px !important;">Nombre</th>
                          <th style="width: 200px !important;" class="align-center">Tipo incentivo</th>
                          <th class="align-center">Comisión generada</th>
                          <th class="align-center">Comisión 2%</th>
                        </tr>
                      </thead>
                      <tbody id="body-tabla-ventas">
                        <script type="text/javascript">
                          $( document ).ready(function() {
                            comisionesLiquidadas=JSON.parse('<?=json_encode($comisiones);?>');
                            filtroComision = 'General';
                            filtroAplicado = '';
                          });
                        </script>
                        <?php
                          if ($comisiones != 0) {
                            $i = 1;
                            foreach ($comisiones as $comision) {
                        ?>
                        <tr id="comision_<?=$comision['id']?>">
                          <td class="align-center" style="text-align: center;"><?=$i?></td>
                          <td><?=$comision['nombre']?></td>
                          <td><?=$comision['incentivo']?></td>
                          <td class="align-center">$<?= number_format($comision['comision'],0,'.',',') ?></td>
                          <td class="align-center">$<?= number_format((($comision['comision']*2)/100),2,'.',',') ?></td>
                        </tr> 
                        <?php
                              $i++;
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
  <?php $this->load->view('includes/footer'); ?> 
  <script type="text/javascript">
    $(document).ready(function(){
        $('#boton').click( function(e) { 
        var table = $('#productos').tableToJSON();
        table.shift()
        table.pop()
        var result = groupBy(table, function(item)
           {  
            return [item.Cliente];
           });
        var table = document.getElementById("xgrupo");
        table.innerHTML='';
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(-1);
        cell1.innerHTML = "<h3>Tu expediente</h3>"
        row = table.insertRow(-1);
        cell1 = row.insertCell(-1);
        cell1.innerHTML = "<b>Encabezado</b>"
        cell1 = row.insertCell(-1);
        cell1 = row.insertCell(-1);
        cell1 = row.insertCell(-1);
        var f = new Date();
        cell1.innerHTML ='<b>Fecha de Generación: </b>'+f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear();
        for (var i = 0; i < result.length; i++) {
            var sub_result= result[i];
            var actua=[];
            for (var j = 0; j < sub_result.length; j++)
             {  
              if (j==0){
                    row = table.insertRow(-1);

                    row = table.insertRow(-1);

                    for (var line = 0; line < 12; line++) {
                      cell1 = row.insertCell(-1);
                      cell1.innerHTML='<hr style="background: #000;"> <span style="color: #fff;">.</span>';
                    }

                    row = table.insertRow(-1);
                    cell1 = row.insertCell(-1);
                    cell1.innerHTML = '<b>Nombres: </b>'+sub_result[j].Cliente;
                    row = table.insertRow(-1);
                    row.innerHTML= '<th>Descripción</th><th>Responsable</th><th>Gestión</th><th>Radicado</th> <th>Despacho</th> <th>Fecha Actuación</th><th>Fecha Evento</th><th>Pretensión</th><th>Etapa</th><th>Ciudad</th><th>Notas</th><th>Estado</th>';
                   }
                   actua.push({fecha:sub_result[j]['Fecha actuacion'], descripcion:sub_result[j].Descripción});
                   row = table.insertRow(-1);
                   cel = row.insertCell(-1);
                   cel.innerHTML=sub_result[j].Descripción;
                   cel = row.insertCell(-1);
                   cel.innerHTML=sub_result[j].Responsable;
                   cel = row.insertCell(-1);
                   cel.innerHTML=sub_result[j].Gestión;
                   cel = row.insertCell(-1);
                   cel.innerHTML=sub_result[j].Radicado;
                   cel = row.insertCell(-1);
                   cel.innerHTML=sub_result[j].Despacho;
                   cel = row.insertCell(-1);
                   cel.innerHTML=sub_result[j]['Fecha actuacion'];
                   cel = row.insertCell(-1);
                   cel.innerHTML=sub_result[j]['Fecha evento'];
                   cel = row.insertCell(-1);
                   cel.innerHTML=sub_result[j].Pretensión;
                   cel = row.insertCell(-1);
                   cel.innerHTML=sub_result[j].Etapa;
                   cel = row.insertCell(-1);
                   cel.innerHTML=sub_result[j].Ciudad;
                   cel = row.insertCell(-1);
                   cel.innerHTML=sub_result[j].Notas;
                   cel = row.insertCell(-1);
                   cel.innerHTML=sub_result[j].Estado;
                 //   if (j==sub_result.length-1){
                 //    row = table.insertRow(-1);
                 //    row.innerHTML= '<th>Actuaciones</th>';
                 //       for (ac in actua){
                 //        row = table.insertRow(-1);
                 //        cel = row.insertCell(-1);
                 //        cel.innerHTML=actua[ac].fecha
                 //        cel = row.insertCell(-1);
                 //        cel.innerHTML=actua[ac].descripcion
                 //        }
                 // }
             }
        }
        ExcellentExport.excel(this, 'xgrupo', 'Reportes Actuaciones de Casos');

        } );

       
});

  </script>