<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>iCCM | S'authentifier</title>

  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>dist/css/adminlte.min.css">
</head>
<body class="hold-transition">



<div class="login-page">
  <div class="row">
    <a href="<?=base_url()?>">
      <img src="<?=base_url()?>dist/img/iccm_logo_bleu.png">
    </a>
  </div>
 <div class="login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

      <form action="<?= base_url('Login/reset_password')?>" method="post" class="form-signin">
        <div class="text-center mb-4">
          <h1 class="h5 mb-3 font-weight-normal"><b>Récuperer votre mot de passe</b></h1>
        </div>

        <!-- <div class="form-label-group">
          <input type="text" name="inputUsername" class="form-control" placeholder="Nom d'utilisateur" autofocus>
          <label for="username">Email de reinitialisation</label>
        </div> -->

        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="inputUsername">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="row text-center">
          <!-- /.col -->
          <div class="col-6 mt-1">
            <a href="<?= base_url('Login/index')?>" class='text-center'><i>Se connecter</i></a>
          </div>
          <div class="col-6">
           
            <button type="submit" class="btn btn-block btn-primary btn-sm" style="float: right;">
              <i class="fas fa-arrow-right nav-icon"></i>
              Récuperer
            </button>
            <!-- <button class="btn btn-lg btn-primary btn-block" type="submit">Recuperer</button> -->
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
 </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?=base_url()?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>dist/js/adminlte.min.js"></script>
</body>
</html>
