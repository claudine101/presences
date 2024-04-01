<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include VIEWPATH . 'templates/navbar.php'; ?>
    <!-- Main Sidebar Container -->
    <?php include VIEWPATH . 'templates/sidebar.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-9">
              <h4 ><?= $title ?></h4> 
            </div><!-- /.col -->

            <div class="col-sm-3">
              <a href="<?= base_url('recouvrement/Liste_recouvrement/index') ?>" class='btn btn-primary float-right'>
                <i class="nav-icon fas fa-list ul"></i>
                Liste
              </a>
            </div><!-- /.col -->
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="col-md-12 col-xl-12 grid-margin stretch-card">
       <?= $this->session->flashdata('message');?>
          <div class="card">
            <div class="card-body">

              <div class="col-md-12">

                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('recouvrement/Liste_recouvrement/add'); ?>">


                  <div class="row">
                    <div class="col-md-6">
                      <label for="FName">Début comptage</label>
                      <input type="number" name="DEBUT" autocomplete="off" id="DEBUT"  class="form-control">
                      <?php echo form_error('DEBUT', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Délais de payement max</label>
                      <input type="number" name="TEMPS" autocomplete="off" id="TEMPS"  class="form-control">
                      <?php echo form_error('TEMPS', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="col-md-6">
                      <label for="FName">Interêt accumulé</label>
                      <input type="number" name="INTERET" autocomplete="off" id="INTERET"  class="form-control">
                      <?php echo form_error('INTERET', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="col-md-6">
                      <br>
                      <br>
                    </div>
                    <div class="col-md-7" style="margin-top:31px;">
                      <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</body>

<?php include VIEWPATH . 'templates/footer.php'; ?>

</html>

