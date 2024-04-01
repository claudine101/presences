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
              <a href="<?= base_url('ihm/Type_Verification/index') ?>" class='btn btn-primary float-right'>
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

                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Type_Verification/update'); ?>">

                  <div class="row">
                    <div class="col-md-6">

                      <input type="hidden" class="form-control" name="ID_TYPE_VERIFICATION" value="<?= $data['ID_TYPE_VERIFICATION'] ?>">
                      <label for="FName">source de vérifiction</label>
                      <input type="text" name="VERIFICATION" value="<?= $data['VERIFICATION'] ?>" id="VERIFICATION" class="form-control">

                      <?php echo form_error('NOM', '<div class="text-danger">', '</div>'); ?>

                    </div>



                  </div>
                  <div class="col-md-6" style="margin-top:31px;">
                    <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Modifier</button>

                  </div>
              </div>

            </div>
          </div>

          <!-- <div class="row">
                  
                </div> -->
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