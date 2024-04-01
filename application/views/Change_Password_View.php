<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php';?>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include VIEWPATH.'templates/navbar.php'; ?>
    <!-- Main Sidebar Container -->
    <?php include VIEWPATH.'templates/sidebar.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-9">
              <h4 class="m-0"><?=$title?></h4>
            </div><!-- /.col -->
            <!-- <div class="col-sm-3">
              <a href="<?=base_url('ihm/Maladies/index')?>" class='btn btn-primary float-right'>
                <i class="nav-icon fas fa-list ul"></i>
                Liste
              </a>
            </div> --><!-- /.col -->
          </div>
        </div><!-- /.container-fluid -->
      </section>



      <!-- Main content -->
      <section class="content">
        <div class="col-md-12 col-xl-12 grid-margin stretch-card">

          <div class="card">
            <div class="card-body">
              <div class="col-md-12">
               
                <?= $this->session->flashdata('message').$this->session->flashdata('message1') ?>
              </div>

              <div class="col-md-12">

                <form name="myform" method="post" class="form-horizontal" action="<?=base_url('Change_Password/change_pswd'); ?>">

                  <div class="row">
                    <div class="col-md-6">
                      <label>Ancien mot de passe</label>
                      <input type="password" class="form-control"  name="Old_Password">
                      <!-- <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-lock"></span>
                        </div>
                      </div> -->
                      <?php echo form_error('Old_Password', '<div class="text-danger">', '</div>'); ?>
                      
                    </div>
                    <div class="col-md-6">

                      <label>Nouveau mot de passe</label>
                       <input type="password" class="form-control"  name="New_Password"   id="New_Password">
                        
                      <?php echo form_error('New_Password', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">

                      <label>Confirmez le nouveau mot de passe</label>
                       <input type="password" class="form-control" name="New_Password1"   id="New_Password">
                        
                      <?php echo form_error('New_Password1', '<div class="text-danger">', '</div>'); ?>

                    </div>

                     <div class="col-md-6" style="margin-top:31px;">

                      <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Modifier</button>
                      <!-- <input type="submit" name="" class="btn btn-primary" value="mmm"> -->
                    </div>

                  </div>


                </div>


              </form>

            </div>


            <!--  VOS CODE ICI  -->



          </div>
        </div>
      </div>
    </section>
  </div>
</div>
</body>

<?php include VIEWPATH.'templates/footer.php'; ?>


<script type="text/javascript">
   $('#message').delay('slow').fadeOut(3000);
  // $('#message').delay('slow').fadeOut(2000);
</script>
<?php if (!empty($this->session->flashdata('message'))) {
  # code...
 ?>
<script type="text/javascript">

  $( document ).ready(function() {
    setTimeout(function(){ window.location.href = "<?= base_url('Login/do_logout')?>"; }, 3001);
});
</script>
<?php }  ?>