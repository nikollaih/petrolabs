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
        <li class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle count-info" > <i class="fa fa-envelope"></i> <span class="badge badge-danger ">6</span> </a>
          <ul class="dropdown-menu dropdown-messages menuBig">
            <li>
              <div class="dropdown-messages-box"> <a class="pull-left" href="profile.html"> <img src="<?= base_url() ?>resources/images/teem/a7.jpg" class="img-circle" alt="image"> </a>
                <div class="media-body"> <small class="pull-right">46h ago</small> <strong>Mike Loreipsum</strong> started following <strong>Olivia Wenscombe</strong>. <br>
                  <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small> </div>
              </div>
            </li>
            <li class="divider"></li>
            <li>
              <div class="dropdown-messages-box"> <a class="pull-left" href="profile.html"> <img src="<?= base_url() ?>resources/images/teem/a4.jpg" class="img-circle" alt="image"> </a>
                <div class="media-body "> <small class="pull-right text-navy">5h ago</small> <strong>Alex Smith </strong> started following <strong>Olivia Wenscombe</strong>. <br>
                  <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small> </div>
              </div>
            </li>
            <li class="divider"></li>
            <li>
              <div class="dropdown-messages-box"> <a class="pull-left" href="profile.html"> <img src="<?= base_url() ?>resources/images/teem/a3.jpg" class="img-circle" alt="image"> </a>
                <div class="media-body "> <small class="pull-right">23h ago</small> <strong>Olivia Wenscombe</strong> love <strong>Sophie </strong>. <br>
                  <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small> </div>
              </div>
            </li>
            <li class="divider"></li>
            <li>
              <div class="text-center link-block"> <a href="mailbox.html"> <i class="fa fa-envelope"></i> <strong>Read All Messages</strong> </a> </div>
            </li>
          </ul>
        </li>
        <li class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle count-info" > <i class="fa fa-bell"></i> <span class="badge badge-primary">8</span> </a>
          <ul class="dropdown-menu dropdown-alerts menuBig">
            <li> <a href="mailbox.html">
              <div> <i class="fa fa-envelope fa-fw"></i> You have 16 messages <span class="pull-right text-muted small">4 minutes ago</span> </div>
              </a> </li>
            <li class="divider"></li>
            <li> <a href="profile.html">
              <div> <i class="fa fa-twitter fa-fw"></i> 3 New Followers <span class="pull-right text-muted small">12 minutes ago</span> </div>
              </a> </li>
            <li class="divider"></li>
            <li> <a href="grid_options.html">
              <div> <i class="fa fa-upload fa-fw"></i> Server Rebooted <span class="pull-right text-muted small">4 minutes ago</span> </div>
              </a> </li>
            <li class="divider"></li>
            <li>
              <div class="text-center link-block"> <a href="mailbox.html"> <strong>See All Alerts</strong> <i class="fa fa-angle-right"></i> </a> </div>
            </li>
          </ul>
        </li>
        <!-- START USER LOGIN DROPDOWN -->
<li class="dropdown dropdown-user"> <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown"  class="dropdown-toggle" href="javascript:;"> <img src="<?= base_url() ?>resources/images/teem/a10.jpg" class="img-circle" alt=""> <span class="username username-hide-on-mobile"> Susan Wenscombe</span> <i class="fa fa-angle-down"></i> </a>
          <ul class="dropdown-menu dropdown-menu-default">
            <li> <a href="profile.html"> <i class="icon-user"></i> My Profile </a>

</li>
<li>
<a href="profile_2.html"> <i class="icon-user"></i> Profile-2 </a> </li>
            <li> <a href="calendar.html"> <i class="icon-calendar"></i> My Calendar </a> </li>
            <li> <a href="mailbox.html"> <i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger"> 3 </span> </a> </li>
            <li> <a href="dashboard2.html"> <i class="icon-rocket"></i> My Tasks <span class="badge badge-success"> 7 </span> </a> </li>
            <li class="divider"> </li>
            <li> <a href="lockscreen.html"> <i class="icon-lock"></i> Lock Screen </a> </li>
            <li> <a href="login.html"> <i class="icon-key"></i> Log Out </a> </li>
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