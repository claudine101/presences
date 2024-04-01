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

              <h4 class="m-0"><?= $title ?></h4>
            </div><!-- /.col -->
            <div class="col-sm-3">
              <a href="<?= base_url('ihm/Verif_Permis/index') ?>" class='btn btn-primary float-right'>
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

          <div class="card">
            <div class="card-body">

              <div class="col-md-12">

                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Verif_Permis/update'); ?>">

                  <div class="row">
                    <input type="hidden" class="form-control" name="ID_IMMATRICULATION_PERMIS" value="<?= $datas['ID_IMMATRICULATION_PERMIS'] ?>">
                    <div class="col-md-6">
                      <label for="FName"> Plaque</label>
                      <input type="text" name="ID_OBR" autocomplete="off" id="ID_OBR" value="<?= $plaques['NUMERO_PLAQUE'] ?>" class="form-control" required>

                      <?php echo form_error('ID_OBR', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="col-md-6">
                      <label for="FName"> Permis</label>
                      <input type="text" name="ID_PSR" autocomplete="off" id="ID_PSR" value="<?= $permis['NUMERO_PERMIS'] ?>" class="form-control" required>

                      <?php echo form_error('ID_PSR', '<div class="text-danger">', '</div>'); ?>
                    </div>

                  </div>

                  <div class="col-md-6" style="margin-top:31px;">
                    <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
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


<script>

</script>