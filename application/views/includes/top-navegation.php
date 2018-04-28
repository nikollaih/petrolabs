<div class="page-header navbar navbar-fixed-top">
  <!-- BEGIN HEADER INNER -->
  <div class="page-header-inner ">
    <!-- BEGIN LOGO -->
    <div class="page-logo"> 
      <a href="<?= base_url() ?>" style="text-decoration: none; font-size: 2.3em; cursor: pointer;" >
        <span>PetroLabs</span>
      </a> 
    </div>
    <!-- END LOGO -->
    <div class="library-menu"> <span class="one">-</span> <span class="two">-</span> <span class="three">-</span> </div>
    <!-- BEGIN TOP NAVIGATION MENU -->
    <div class="top-menu">
      <ul class="nav navbar-nav pull-right">
        <!-- START USER LOGIN DROPDOWN -->
<li class="dropdown dropdown-user"> <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown"  class="dropdown-toggle" href="javascript:;"> <span class="username username-hide-on-mobile"><?= $this->session->userdata('nombre').' '.$this->session->userdata('apellidos') ?></span> <i class="fa fa-angle-down"></i> </a>
          <ul class="dropdown-menu dropdown-menu-default">
            <li> <a href="<?= base_url() ?>usuario/perfil/<?= $this->session->userdata('id_usuario').'/'.stringToUrl($this->session->userdata('nombre').' '.$this->session->userdata('apellidos')) ?>"> <i class="icon-user"></i> Perfil </a></li>
            <li class="divider"> </li>
            <li> <a href="<?= base_url() ?>usuario/logout"> <i class="icon-key"></i> Cerrar Sesion </a> </li>
          </ul>
        </li>
        <!-- END USER LOGIN DROPDOWN -->
      </ul>
      <?php 
        if (($this->session->flashdata())) {
          $info = $this->session->flashdata()['info'];
      ?>
            <div class="alert alert-<?= $info[0] ?> alert-message">
              <strong><?= $info[1] ?>!</strong>
               <?= $info[2] ?>
               <i class="fa fa-close close-alert"></i>
            </div>

            <script type="text/javascript">
              setTimeout(function(){
                $('.alert-message').remove();
              }, 5000)
            </script>
      <?php
        }
      ?>
    </div>
    <!-- END TOP NAVIGATION MENU -->
  </div>
  <!-- END HEADER INNER -->
</div>

<style type="text/css">
  .alert-message{
    position: absolute;
    right: 21px;
    bottom: -100px;
  }

  .alert-message i{
    margin-left: 10px;
    cursor: pointer;
  }

  .alert-message.alert-success{
    border-left: 2px solid #3c763d;
  }

  .alert-message.alert-danger{
    border-left: 2px solid #a94442;
  }

  .alert-message.alert-warning{
    border-left: 2px solid #8a6d3b;
  }
</style>

<script type="text/javascript">
  $(document).on('click', '.close-alert', function(){
    $('.alert-message').remove();
  })
</script>