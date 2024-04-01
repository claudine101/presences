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

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Citoyen/add'); ?>" >



                 <div class="row">
                  <div class="col-md-6">
                    <label for="FName">NOM DU CITOYEN</label>
                    <input type="text" name="NOM_CITOYEN" autocomplete="off" id="NOM_CITOYEN" value="<?= set_value('NOM_CITOYEN') ?>"  class="form-control">
                    
                    <?php echo form_error('NOM_CITOYEN', '<div class="text-danger">', '</div>'); ?> 

                  </div>


                  <div class="col-md-6">
                    <label for="FName">PRENOM DU CITOYEN</label>
                    <input type="text" name="PRENOM_CITOYEN" autocomplete="off" id="PRENOM_CITOYEN" value="<?= set_value('PRENOM_CITOYEN') ?>"  class="form-control">  
                    <?php echo form_error('PRENOM_CITOYEN', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                  <div class="col-md-6">
                    <label for="FName">N° IDENTITE</label>
                    <input type="text" name="CNI" autocomplete="off" id="CNI" value="<?= set_value('CNI') ?>"  class="form-control">
                    
                    <?php echo form_error('CNI', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                  <div class="col-md-6">
                    <label for="FName">TELEPHONE </label>
                    <input type="number" name="NUMERO_CITOYEN" autocomplete="off" id="NUMERO_CITOYEN" value="<?= set_value('NUMERO_CITOYEN') ?>"  class="form-control">
                    
                    <?php echo form_error('NUMERO_CITOYEN', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                  <div class="col-md-6">
                    <label for="FName"> E-MAIL</label>
                    <input type="email" name="NOM_UTILISATEUR" autocomplete="off" id="NOM_UTILISATEUR" value="<?= set_value('NOM_UTILISATEUR') ?>"  class="form-control">
                    
                    <?php echo form_error('NOM_UTILISATEUR', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName">PASSWORD</label>
                    <input type="password" name="MOT_DE_PASSE" autocomplete="off" id="MOT_DE_PASSE" value="<?= set_value('MOT_DE_PASSE') ?>"  class="form-control">
                    
                    <?php echo form_error('MOT_DE_PASSE', '<div class="text-danger">', '</div>'); ?> 
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


