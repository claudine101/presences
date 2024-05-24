


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
              <!-- <h4 class="m-0"style="color:blue"><?=$title?></h4> -->
            </div><!-- /.col -->
            <div class="col-sm-3">
              <a href="<?=base_url('donnees/Qr_presence/index')?>" class='btn btn-primary float-right'>
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

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('donnees/Qr_presence/save'); ?>" >

                 <div class="row">
                 
                  <div class="col-md-6 col-sm-6 ">
                                  <label >Date présence</label>
                                    <input type="date" name="DATE_PRES"  min="<?=date('d-m-Y')?>" class="form-control" autofocus>
                                    <span class="error"><?php echo form_error('DATE_PRES'); ?></span>    
                                </div>
                                <div class="col-md-6 col-sm-6 ">
                                  <label >Début de validité</label>
                                    <input type="time" name="HEURE_DEBUT"  class="form-control" autofocus>
                                    <span class="error"><?php echo form_error('HEURE_DEBUT'); ?></span>    
                                </div>
                                <div class="col-md-6 col-sm-6 ">
                                  <label >Début de validité</label>
                                    <input type="time" name="HEURE_FIN"  class="form-control" autofocus>
                                    <span class="error"><?php echo form_error('HEURE_FIN'); ?></span>    
                                </div>
                                
                  <div class="col-md-6">
                    
                    <div class="col-md-6" style="margin-top:31px;">
                      <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
                    </div>
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

