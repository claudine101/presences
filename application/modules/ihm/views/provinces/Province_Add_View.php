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
            <div class="col-sm-3">
              <a href="<?=base_url('ihm/Provinces/index')?>" class='btn btn-primary float-right'>
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

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Provinces/add'); ?>" >

                 <div class="row">
                  <div class="col-md-6">
                    <label for="FName">Description</label>
                    <input type="text" name="PROVINCE_NAME" autocomplete="off" id="PROVINCE_NAME" value="<?= set_value('PROVINCE_NAME') ?>"  class="form-control">
                    <?php echo form_error('PROVINCE_NAME', '<div class="text-danger">', '</div>'); ?> 
                    
                  </div>
                   <div class="col-md-12" style="margin-top:31px;">
                      <!-- <a href="#" class="next">suivant &raquo;</a>
                      <button type="button" style="float: right;" onclick='suivant()' class="btn btn-primary"><span class="fas fa-save"></span> suivant</button> -->
                      <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
                    </div>

                </div>

                <div class="row">
                  <div class="col-md-6">
                    <label for="FName">Description</label>
                    <input type="text" name="PROVINCE_NAME" autocomplete="off" id="PROVINCE_NAME" value="<?= set_value('PROVINCE_NAME') ?>"  class="form-control">
                    <?php echo form_error('PROVINCE_NAME', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName">Latitude</label>
                    <input type="number" name="PROVINCE_LATITUDE" autocomplete="off" id="PROVINCE_LATITUDE" value="<?= set_value('PROVINCE_LATITUDE') ?>"  class="form-control">
                    <?php echo form_error('PROVINCE_LATITUDE', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName">Longitude</label>
                    <input type="number" name="PROVINCE_LONGITUDE" autocomplete="off" id="PROVINCE_LONGITUDE" value="<?= set_value('PROVINCE_LONGITUDE') ?>"  class="form-control">
                    <?php echo form_error('PROVINCE_LONGITUDE', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6" style="margin-top:31px;">
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

<?php include VIEWPATH.'templates/footer.php'; ?>


