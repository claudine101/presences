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
              <a href="<?=base_url('PSR/Utilisateur/index')?>" class='btn btn-primary float-right'>
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

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Utilisateur/add'); ?>" >


                  
                  

                 <div class="row">
                  <div class="col-md-6">
                    <label for="FName">NOM_UTILISATEUR</label>
                    <input type="text" name="NOM_UTILISATEUR" autocomplete="off" id="NOM_UTILISATEUR" value="<?= set_value('NOM_UTILISATEUR') ?>"  class="form-control">
                    
                    <?php echo form_error('NOM_UTILISATEUR', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                  
                  <div class="col-md-6">
                    <label for="FName">MOT_DE_PASSE</label>
                    <input type="text" name="MOT_DE_PASSE" autocomplete="off" id="MOT_DE_PASSE" value="<?= set_value('MOT_DE_PASSE') ?>"  class="form-control">
                    
                    <?php echo form_error('MOT_DE_PASSE', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                  
                  <div class="col-md-6">
                    <label for="FName">CNI</label>
                    <input type="text" name="CNI" autocomplete="off" id="CNI" value="<?= set_value('CNI') ?>"  class="form-control">
                    
                    <?php echo form_error('CNI', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                  <div class="col-md-6">
                    <label for="Ftype">PROFIL</label>
                    <select required class="form-control" name="PROFIL_ID" id="PROFIL_ID" >
                      <option value="">---Sélectionner---</option>
                      <?php
                      foreach ($CONTAGE_g as $value)
                      {
                        ?>
                        <option value="<?=$value['PROFIL_ID']?>"><?=$value['STATUT']?></option>
                        <?php
                      }
                      ?>
                    </select>
                    <!-- <div><font color="red" id="error_province"></font></div>  -->
                    <?php echo form_error('PROFIL_ID', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  
                  
                </div>

                <div class="col-md-6" style="margin-top:31px;">
                  <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
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

      <?php include VIEWPATH.'templates/footer.php'; ?>


