<?php $this->load->view('includes/tags') ?>
<body class="green-bg login">
<div class="middle-box text-center loginscreen ">
  <div class="widgets-container">
    <div style="margin-bottom: 40px;">
      <img width="60%" src="<?= base_url() ?>resources/images/logo.png">
    </div>
    <h3>Petrolabs de Colombia</h3>
    <p>Inicia sesion para continuar</p>
    <form class="top15">
      <div class="form-group">
        <input type="email" required="" placeholder="Username" id="email" name="email" class="form-control">
      </div>
      <div class="form-group">
        <input type="password" required="" placeholder="Password" id="password" name="password" class="form-control">
      </div>
      <div style="display: none;" class="alert alert-danger login-error"> Datos incorrectos. </div>
      <div id="loginSubmit" class="btn green block full-width bottom15">Continuar</div>
      <a href="<?= base_url() ?>auth/forgotpassword"><small>¿Olvidaste tu contraseña?</small></a>
    </form>
    <p class="top15"> <small>Petrolabs &copy; <?= Date('Y') ?></small> </p>
  </div>
</div>
</body>
<!-- Mirrored from adminbag-v1.3.bittyfox.com/default/dark-blue/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Dec 2017 21:15:32 GMT -->
</html>
