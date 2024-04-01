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
              <a href="<?=base_url('ihm/Citoyen/index')?>" class='btn btn-primary float-right'>
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

                 <form enctype="multipart/form-data" name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Money/update'); ?>">
                  <div id="add">
                 <div class="row">
                  <div class="col-md-6">
                    <input type="hidden" class="form-control" name="ID_MONEY" value="<?= $moneys['ID_MONEY'] ?>">
                    <label for="FName">Monnaie</label>
                    <input type="text" name="MONEY" autocomplete="off" id="MONEY" value="<?= $moneys['MONEY'] ?>"   class="form-control">
                    
                    <?php echo form_error('MONEY', '<div class="text-danger">', '</div>'); ?> 

                  </div>


                  <div class="col-md-6">
                    <label for="FName">Symbole</label>
                    <input type="text" name="SYMBOLE" autocomplete="off" id="SYMBOLE" value="<?= $moneys['SYMBOLE'] ?>"  class="form-control">  
                    <?php echo form_error('SYMBOLE', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                  <div class="form-group col-md-6">
                      <label id="Ftype" for="Ftype">Province</label>
                      <select required class="form-control form-control-sm" name="ID_PAYS" id="ID_PAYS" onchange="onSelected();">
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($countries as $value) {

                          $selected = "";
                          if ($value['COUNTRY_ID'] == $moneys['ID_PAYS']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['COUNTRY_ID'] ?>" <?= $selected ?>><?= $value['CommonName'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <!-- <div><font color="red" id="error_province"></font></div>  -->
                      <?php echo form_error('ID_PAYS', '<div class="text-danger">', '</div>'); ?>
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

<?php include VIEWPATH.'templates/footer.php'; ?>


