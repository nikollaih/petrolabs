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
          <li> <a>Usuarios</a> </li>
          <?php
          	if (isset($usuario['id_usuario'])) {
          ?>
          		<li> <a>Modificar</a> </li>
          		<li class="active"> <strong><?= $usuario['nombre'].' '.$usuario['apellidos'] ?></strong> </li>
          <?php
          	}
          	else{
          ?>
          		<li class="active"> <strong>Nuevo</strong> </li>
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
                <h5>Detalles del usuario</h5>
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
                  <form enctype="multipart/form-data" method="post" action="<?= base_url() ?>usuario/modificar/<? echo (isset($usuario['id_usuario'])) ? $usuario['id_usuario'] : '0' ?>" class="row">
                  	<input type="hidden" name="id_usuario" value="<? echo (isset($usuario['id_usuario'])) ? $usuario['id_usuario'] : '-1' ?>">
                  	<input type="hidden" name="info[rol]" value="<? echo (isset($usuario['rol'])) ? $usuario['rol'] : $rol ?>">
                  	<div class="col-md-12">
                  		<div class="form-group col-md-6">
                  			<label for="info[nombre]">Nombre</label>
		                  	<input class="form-control" required name="info[nombre]" placeholder="Nombres" type="text" value="<?= $usuario['nombre']?>">
		                </div>
		                <div class="form-group col-md-6">
                  			<label for="info[apellidos]">Apellidos</label>
		                  	<input class="form-control" required name="info[apellidos]" placeholder="Apellidos" type="text" value="<?= $usuario['apellidos']?>">
		                </div>
		                <div class="form-group col-md-6">
                  			<label for="info[cedula]">Cedula</label>
		                  	<input class="form-control" required name="info[cedula]" placeholder="Cedula" type="number" value="<?= $usuario['cedula']?>">
		                </div>
		                <div class="form-group col-md-6">
                  			<label for="info[telefono]">Telefono</label>
		                  	<input class="form-control" required name="info[telefono]" placeholder="Telefono" type="number" value="<?= $usuario['telefono']?>">
		                </div>
		                <div class="form-group col-md-6">
                  			<label for="info[email]">Email</label>
		                  	<input class="form-control" required name="info[email]" placeholder="Email" type="email" value="<?= $usuario['email']?>">
		                </div>
		                <div class="form-group col-md-6">
		                  	<label for="info[estado]">Estado</label>
		                  	<select class="form-control" required name="info[estado]">
		                    	<option <?php echo ($usuario['estado']==1) ? 'selected' : ''; ?> value="1">Activo</option>
		                      	<option <?php echo ($usuario['estado']==2) ? 'selected' : ''; ?> value="2">Inactivo</option>
		                    </select>
		                </div>
		                <div class="form-group col-md-6">
		                  	<label for="info[departamento]">Departamento</label>
		                  	<select data-ciudad-usuario="<?= $usuario['ciudad'] ?>" class="form-control" required id="departamento-usuario-form">
                          <option value="">Departamento</option>
		                  		<?php
		                  			if ($departamentos != 0) {
		                  				foreach ($departamentos as $departamento) {
		                  		?>
		                  					<option <?php echo ($usuario['departamento']==$departamento['id_departamento']) ? 'selected' : ''; ?> value="<?= $departamento['id_departamento'] ?>"><?= $departamento['nombre_departamento'] ?></option>
		                  		<?php
		                  				}
		                  			}
		                  		?>
		                    </select>
		                </div>
		                <div class="form-group col-md-6">
		                  	<label for="info[ciudad]">Ciudad</label>
		                  	<select data-estacion-usuario="<?= $usuario['id_estacion'] ?>" class="form-control" required id="ciudad-usuario-form" name="info[ciudad]">
		                  		
		                    </select>
		                </div>

		                <?php
		                	if ($rol == 3) {
		                ?>
		                		<div class="form-group col-md-4">
				                  	<label for="islero[estacion]">Estacion</label>
				                  	<select class="form-control" id="estacion-usuario-form" required name="islero[estacion]">
				                  		
				                    </select>
				                </div>
				                <div class="form-group col-md-4">
				                  	<label for="islero[tipo_incentivo]">Tipo incentivo</label>
				                  	<select class="form-control" required name="islero[tipo_incentivo]">
				                  		<?php
				                  			if ($incentivos != 0) {
				                  				foreach ($incentivos as $incentivo) {
				                  		?>
				                  					<option <?php echo ($usuario['tipo_incentivo']==$incentivo['id_tipo']) ? 'selected' : ''; ?> value="<?= $incentivo['id_tipo'] ?>"><?= $incentivo['descripcion'] ?></option>
				                  		<?php
				                  				}
				                  			}
				                  		?>
				                    </select>
				                </div>
				                <div class="form-group col-md-4">
				                  	<label for="islero[estacion]">RUT</label>
				                  	<input type="file" class="form-control" name="rut" >
				                </div>
		                <?php
		                	}
		                ?>
                  	</div>
                  	<div class="col-md-12"><hr></div>
                  	<div class="col-md-5 col-md-offset-7">
                  		<div class="col-md-6">
                  			<button class="btn btn-block btn-success" type="submit"><i class="fa fa-paste"></i> Guardar</button>
                  		</div>
                  		<div class="col-md-6">
                  			<a href="<?= base_url() ?>usuario/lista/<?= $rol ?>/<?= $usuario['nombre_rol'] ?>" class="btn btn-block btn-primary" type="button"><i class="fa fa-times"></i> Cancelar</a>
                  		</div>
                  	</div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <style type="text/css">
      	.foto-contenedor{
      		width: 100%;
      		height: 250px;
      		border: 2px solid #000;
      		position: relative;
      	}
      	.foto-contenedor img{
      		height: 100%;
      		width: auto;
      		margin: 0 auto;
      	}
      	.overview{
      		height: 100%;
      		width: 100%;
      		position: absolute;
      		background: rgba(0,0,0,0.9);
      		top: 0;
      		left: 0;
      		display: none;
      	}
      </style>
      <?php
        if (isset($usuario['id_departamento'])) {
      ?>
        <script type="text/javascript">
      		llenarSelectCiudad(<?= $usuario['id_departamento'] ?>, '#ciudad-usuario-form', <?= $usuario['id_ciudad'] ?>);
      		llenarSelectEstacion(<?= $usuario['id_ciudad'] ?>, '#estacion-usuario-form', <?= $usuario['id_estacion'] ?>);
        </script>
      <?php
        }
      ?>
  <?php $this->load->view('includes/footer'); ?> 