<!-- Start page sidebar wrapper -->
  <div class="page-sidebar-wrapper">
    <div class="page-sidebar">
      <ul class="page-sidebar-menu  page-header-fixed ">
        <li class="heading">
          <h3 class="uppercase">Usuarios</h3>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-toggle" href="javascript:;">
            <i class="fa fa-user-circle"></i>
            <span class="title">Administradores</span>
            <span class="arrow"></span>
          </a>
          <ul class="nav-item sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="<?=base_url()?>usuario/lista/1/Administradores">
                <span class="title">Listado</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?=base_url()?>usuario/obtener/nuevo/1">
                <span class="title">Agregar</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-toggle" href="javascript:;">
            <i class="fa fa-users"></i>
            <span class="title">Asesores</span>
            <span class="arrow"></span>
          </a>
          <ul class="nav-item sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="<?=base_url()?>usuario/lista/2/Asesores">
                <span class="title">Listado</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?=base_url()?>usuario/obtener/nuevo/2">
                <span class="title">Agregar</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-toggle" href="javascript:;">
            <i class="fa fa-vcard"></i>
            <span class="title">Isleros</span>
            <span class="arrow"></span>
          </a>
          <ul class="nav-item sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="<?=base_url()?>usuario/lista/3/Isleros">
                <span class="title">Listado</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?=base_url()?>usuario/obtener/nuevo/3">
                <span class="title">Agregar</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="heading">
          <h3 class="uppercase">Productos</h3>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-toggle" href="javascript:;">
            <i class="fa fa-truck"></i>
            <span class="title">Productos</span>
            <span class="arrow"></span>
          </a>
          <ul class="sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="<?=base_url()?>producto">
                <span class="title">Listado</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?=base_url()?>producto/obtener/nuevo">
                <span class="title">Agregar</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=base_url()?>venta">
            <i class="fa fa-shopping-cart"></i>
            <span class="title">Productos vendidos</span>
          </a>
        </li>
        <li class="heading">
          <h3 class="uppercase">Estaciones</h3>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-toggle" href="javascript:;">
            <i class="fa fa-building"></i>
            <span class="title">Estaciones</span>
            <span class="arrow"></span>
          </a>
          <ul class="sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="<?=base_url()?>estacion">
                <span class="title">Listado</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?=base_url()?>estacion/obtener/nuevo">
                <span class="title">Agregar</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="heading">
          <h3 class="uppercase">Comisiones</h3>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=base_url()?>comision">
            <i class="fa fa-shopping-cart"></i>
            <span class="title">Liquidar comisiones</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
  <!-- End page sidebar wrapper -->