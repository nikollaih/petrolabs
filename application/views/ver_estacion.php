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
          <li> <a href="<?=base_url()?>estacion">Inicio</a> </li>
          <li> <a href="<?=base_url()?>estacion">Estaciones</a> </li>
          <?php
            if (isset($estacion['id_estacion'])) {
          ?>
          <li> <a>Modificar</a> </li>
          <li class="active"> <strong><?= $estacion['nombre_estaciones'] ?></strong> </li>
          <?php
            }else{
          ?>
          <li class="active"> <strong>Nueva</strong> </li>
          <?php
            }
          ?>
          
        </ol>
      </div>
      <div class="wrapper-content ">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Detalles de la estacion</h5>
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
                  <form class="row" method="post" action="<?=base_url();?>estacion/modificar/<?= isset($estacion['id_estacion'])?$estacion['id_estacion']:'nueva'?>">
                  	<input type="hidden" name="estacion[id_estacion]" value="<?= isset($estacion['id_estacion'])?$estacion['id_estacion']:'-1'?>">
                  	<div class="form-group col-md-3">
                        <label for="info[departamento]">Departamento</label>
                        <select class="form-control departamento-asesores" data-ciudad-usuario="<?= $estacion['ciudad'] ?>" data-asesores="lista-asesores-departamento" required id="departamento-usuario-form">
                          <option value="">Departamento</option>
                          <?php
                            if ($departamentos != 0) {
                              foreach ($departamentos as $departamento) {
                          ?>
                                <option <?php echo ($estacion['departamento']==$departamento['id_departamento']) ? 'selected' : ''; ?> value="<?= $departamento['id_departamento'] ?>"><?= $departamento['nombre_departamento'] ?></option>
                          <?php
                              }
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="info[ciudad]">Ciudad</label>
                        <select data-estacion-estacion="<?= $estacion['id_estacion'] ?>" class="form-control" required id="ciudad-usuario-form" name="info[ciudad]">
                          
                        </select>
                    </div>
                      <div class="form-group col-md-3">
                        <label for="info[nombre_estacion]">Nombre estación</label>
                        <input class="form-control" required name="info[nombre_estaciones]" placeholder="Nombre de la estación" type="text" value="<?= $estacion['nombre_estaciones']?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="info[departamento]">Asesor</label>
                        <select class="form-control lista-asesores-departamento" name="asesor" id="asesor-estacion-form">
                          <option value="">Asesor</option>
                          <?php
                            if ($asesores != 0) {
                              foreach ($asesores as $asesor) {
                          ?>
                                <option <?php echo ($estacion['usuario']==$asesor['id_usuario']) ? 'selected' : ''; ?> value="<?= $asesor['id_usuario'] ?>"><?= $asesor['nombre'] ?></option>
                          <?php
                              }
                            }
                          ?>
                        </select>
                    </div>
                    <div class="col-md-12"><hr></div>
                    <div class="col-md-5 col-md-offset-7">
                      <div class="col-md-6">
                        <button class="btn btn-block btn-success" type="submit">
                          <i class="fa fa-<?= isset($estacion['id_estacion'])?'paste':'check'?>"></i> Guardar
                        </button>
                      </div>
                      <div class="col-md-6">
                        <a href="<?=base_url()?>estacion" class="btn btn-block btn-primary" type="button">
                          <i class="fa fa-times"></i> Cancelar
                        </a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  <?php
    if (isset($estacion['id_estacion'])) {
  ?>
      <script type="text/javascript">
        setTimeout(function(){
          obtenerAsesoresDepartamento(<?php echo $estacion['departamento'] ?>, '.lista-asesores-departamento', <?php echo $estacion['usuario'] ?>);
          llenarSelectCiudad(<?php echo $estacion['departamento'] ?>, '#ciudad-usuario-form', <?php echo $estacion['ciudad'] ?>);
        }, 500);
      </script>
  <?php
    }
  ?>
  <?php $this->load->view('includes/footer'); ?> 