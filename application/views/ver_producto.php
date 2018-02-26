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
          <li> <a href="<?=base_url()?>producto">Productos</a> </li>
          <?php
            if (isset($producto['id_producto'])) {
          ?>
          <li> <a>Modificar</a> </li>
          <li class="active"> <strong><?= $producto['nombre_producto'] ?></strong> </li>
          <?php
            }else{
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
                <h5>Detalles del producto</h5>
              </div>
              <div class="ibox-content collapse in">
                <div class="widgets-container">
                  <form class="row" method="post" enctype="multipart/form-data" action="<?=base_url();?>producto/modificar/<?= isset($producto['id_producto'])?$producto['id_producto']:'-1'?>">
                  	<input type="hidden" name="producto[id_producto]" value="<?= isset($producto['id_producto'])?$producto['id_producto']:'-1'?>">
                  	<div class="col-md-7">
                  		<div class="form-group col-md-12">
                  			<label for="producto[nombre_producto]">Nombre producto</label>
		                  	<input class="form-control" required id="producto[nombre_producto]" name="producto[nombre_producto]" placeholder="Nombre producto" type="text" value="<?= isset($producto['nombre_producto'])?$producto['nombre_producto']:''?>">
		                  </div>
		                <div class="form-group col-md-12">
		                  	<label for="producto[estado]">Estado</label>
		                  	<select class="form-control" required id="producto[estado]" name="producto[estado]">
                          <?php
                            if (isset($producto['estado'])) {
                          ?>
                          <option <?php echo ($producto['estado']==1) ? 'selected' : ''; ?> value="1">Activo</option>
                          <option <?php echo ($producto['estado']==2) ? 'selected' : ''; ?> value="2">Inactivo</option>
                          <option <?php echo ($producto['estado']==3) ? 'selected' : ''; ?> value="3">Eliminado</option>
                          <?php
                            }else{
                          ?>
                          <option value="1">Activo</option>
                          <option value="2">Inactivo</option>
                          <option value="3">Eliminado</option>
                          <?php
                            }
                          ?>
		                    </select>
		                </div>
		                <div class="form-group col-md-6">
                  			<label for="producto[precio]">Precio</label>
		                  	<input class="form-control" required id="producto[precio]" name="producto[precio]" placeholder="Precio producto" type="number" value="<?= isset($producto['precio'])?$producto['precio']:''?>">
		                </div>
		                <div class="form-group col-md-6">
                  			<label for="producto[comision]">Comisión</label>
		                  	<input class="form-control" required id="producto[comision]" name="producto[comision]" placeholder="Comisión producto" type="number" value="<?= isset($producto['comision'])?$producto['comision']:''?>">
		                </div>
                  	</div>
                  	<div class="col-md-3 col-md-offset-1">
                  		<div class="foto-contenedor">
                        <?php
                          if (isset($producto['foto'])) {
                            $imgRuta = $producto['foto'];
                          }else{
                            $imgRuta = '../upload.jpg';
                          }
                        ?>
                  			<img class="imgPreview" src="<?=base_url();?>uploads/productos/<?=$imgRuta?>">
                  			<div class="overview" style="text-align: center;">
                  				<input type="file" onchange="readUrlImage(this);" name="imageProducto" id="imageProducto">
                  				<i class="fa fa-upload"></i>
                  			</div>
                  		</div>
                  	</div>
                  	<div class="col-md-12"><hr></div>
                  	<div class="col-md-5 col-md-offset-7">
                  		<div class="col-md-6">
                  			<button class="btn btn-block btn-success" type="submit">
	                  			<i class="fa fa-<?= isset($producto['id_producto'])?'paste':'check'?>"></i> Guardar
	                  		</button>
                  		</div>
                  		<div class="col-md-6">
                  			<a href="<?=base_url()?>producto" class="btn btn-block btn-primary" type="button">
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
      <style type="text/css">
      	.foto-contenedor{
      		width: 100%;
      		height: 250px;
      		border: 2px dashed #29aba4;
      		position: relative;
      		border-radius: 50% !important;
      		overflow: hidden;
      		text-align: center;	
      	}
      	.foto-contenedor img{
      		height: auto;
		    width: 100%;
		    margin: 0 auto;
		    top: 50%;
		    position: absolute;
		    left: 0;
		    transform: translateY(-50%);
      	}
      	.overview{
      		height: 100%;
      		width: 100%;
      		position: absolute;
      		background: rgba(41, 171, 164, 0.75);
      		top: 0;
      		left: 0;
      		display: none;
      		font-size: 4em;
      		color: #fff;
      	}
      	.overview i, .overview input{
      		position: absolute;
      		top: 50%;
      		left: 50%;
      		transform: translate(-50%, -50%);
      		cursor: pointer;
      	}
      	.overview input{
      		opacity: 0;
		    width: 100%;
		    height: 100%;
		    z-index: 99999999;
      	}
      </style>
      <script type="text/javascript">

      	function readUrlImage(input){
      		if (input.files && input.files[0]) {
      			var reader = new FileReader();

      			reader.onload = function(e){
      				$(".imgPreview").attr('src', e.target.result);
      			}

      			reader.readAsDataURL(input.files[0]);
      		}
      	}

      	$( ".foto-contenedor" ).hover(function() {
			$('.overview').fadeIn();
		});
		$( ".foto-contenedor" ).mouseleave(function() {
			$('.overview').fadeOut();
		});
      </script>
  <?php $this->load->view('includes/footer'); ?> 