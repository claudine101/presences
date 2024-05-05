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

              <h4 class="m-0"style="color:blue"><?=$title?></h4>
            </div><!-- /.col -->
            <div class="col-sm-3">
              <a href="<?=base_url('ihm/Zones/index')?>" class='btn btn-primary float-right'>
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

               <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Zones/update'); ?>" >

                <div class="row">
                <input type="hidden" class="form-control" name="ZONE_ID" value="<?=$data['ZONE_ID']?>" >
              
                <div class="row">
                <div class="col-md-6">
                      <label for="Ftype">Province</label>
                      <select class="form-control" name="PROVINCE_ID" id="PROVINCE_ID" onchange='get_communes()'>
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($provinces as $value) {

                          $selected = "";
                          if ($value['PROVINCE_ID'] == $selectProv['PROVINCE_ID']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['PROVINCE_ID'] ?>" <?= $selected ?>><?= $value['PROVINCE_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('PROVINCE_ID', '<div class="text-danger">', '</div>'); ?> 

                    </div>
                    <div class="col-md-6">
                      <label for="Ftype">Commune</label>
                      <select class="form-control" name="COMMUNE_ID" id="COMMUNE_ID" >
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($communes as $value) {

                          $selected = "";
                          if ($value['COMMUNE_ID'] == $selectComm['COMMUNE_ID']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['COMMUNE_ID'] ?>" <?= $selected ?>><?= $value['COMMUNE_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('COMMUNE_ID', '<div class="text-danger">', '</div>'); ?> 

                    </div>
                  <div class="col-md-6">
                    <label for="FName">Zone</label>
                    <input type="text" name="ZONE_NAME" autocomplete="off" id="ZONE_NAME" value="<?= $data['ZONE_NAME'] ?>"  class="form-control">
                    <?php echo form_error('ZONE_NAME', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName">Latitude</label>
                    <input type="number" name="LATITUDE" autocomplete="off" id="LATITUDE" value="<?= $data['LATITUDE']?>"  class="form-control">
                    <?php echo form_error('LATITUDE', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName">Longitude</label>
                    <input type="number" name="LONGITUDE" autocomplete="off" id="LONGITUDE" value="<?= $data['LONGITUDE']?>"  class="form-control">
                    <?php echo form_error('LONGITUDE', '<div class="text-danger">', '</div>'); ?> 
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

    </div>
  </section>
</div>
</div>
</body>

<?php include VIEWPATH.'templates/footer.php'; ?>

<script>
function get_communes(){
    var PROVINCE_ID = $('#PROVINCE_ID').val();
    if (PROVINCE_ID == '') {
      $('#COMMUNE_ID').html('<option value="">---Sélectionner---</option>');
    }
    else { 
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_communes/" + PROVINCE_ID,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#COMMUNE_ID').html(data);
        }
      });
    }
  }
  </script>
