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
          <li class="active"> <strong>Detalles</strong> </li>
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
                  <form class="row">
                  	<input type="hidden" name="info[id_producto]" value="<?= $producto['id_producto']?>">
                  	<div class="col-md-7">
                  		<div class="form-group col-md-12">
                  			<label for="info[nombre_producto]">Nombre producto</label>
		                  	<input class="form-control" required id="info[nombre_producto]" placeholder="Nombre producto" type="text" value="<?= $producto['nombre_producto']?>">
		                </div>
		                <div class="form-group col-md-12">
		                  	<label for="info[estado]">Estado</label>
		                  	<select class="form-control" required id="info[estado]">
		                    	<option <?php echo ($producto['estado']==1) ? 'selected' : ''; ?> value="1">Activo</option>
		                      	<option <?php echo ($producto['estado']==2) ? 'selected' : ''; ?> value="2">Inactivo</option>
		                      	<option <?php echo ($producto['estado']==3) ? 'selected' : ''; ?> value="3">Eliminado</option>
		                    </select>
		                </div>
		                <div class="form-group col-md-6">
                  			<label for="info[precio]">Precio</label>
		                  	<input class="form-control" required id="info[precio]" placeholder="Precio producto" type="number" value="<?= $producto['precio']?>">
		                </div>
		                <div class="form-group col-md-6">
                  			<label for="info[comision]">Comisión</label>
		                  	<input class="form-control" required id="info[comision]" placeholder="Comisión producto" type="number" value="<?= $producto['comision']?>">
		                </div>
                  	</div>
                  	<div class="col-md-3 col-md-offset-1">
                  		<div class="foto-contenedor">
                  			<img src="<?= $producto['foto']?>">
                  			<div class="overview" style="text-align: center;">
                  				hola
                  			</div>
                  		</div>
                  	</div>
                  	<div class="col-md-12"><hr></div>
                  	<div class="col-md-4 col-md-offset-8">
                  		<div class="col-md-6">
                  			<button class="btn btn-block btn-warning" type="button">Editar</button>
                  		</div>
                  		<div class="col-md-6">
                  			<button class="btn btn-block btn-primary" type="button">Cancelar</button>
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
      <script type="text/javascript">
      	$( ".foto-contenedor" ).hover(function() {
			$('.overview').fadeIn();
		});
		$( ".foto-contenedor" ).mouseleave(function() {
			$('.overview').fadeOut();
		});
      </script>
  <?php $this->load->view('includes/footer'); ?> 