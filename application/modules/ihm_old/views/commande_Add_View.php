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
              <a href="<?=base_url('ihm/visualisation_commandes/index')?>" class='btn btn-primary float-right'>
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

               <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/visualisation_commandes/add'); ?>" >
                <div class="row">
                  <div class="col-md-6">
                    <label for="FName">RESTAURANT</label>
                    <select class="form-control" name="ID_RESTAURANT" id="ID_RESTAURANT">
                      
                      <option value="">Sélectionner</option>
                      <?php 
                      foreach ($ID_RESTAURANT as $key_marque) 
                      {
                        if ($key_marque['ID_RESTAURANT']==set_value('ID_RESTAURANT')) 
                          {?>
                            <option value="<?= $key_marque['ID_RESTAURANT'] ?>" selected=''><?= $key_marque['NOM_RESTAURANT'] ?></option>
                            <?php } else {?>
                            <option value="<?= $key_marque['ID_RESTAURANT'] ?>"><?= $key_marque['NOM_RESTAURANT'] ?></option>
                            <?php 
                          }
                        }

                        ?>

                      </select>

                      <?php echo form_error('ID_RESTAURANT', '<div class="text-danger">', '</div>'); ?> 

                    </div>
                    <div class="col-md-6">
                      <label>MENU</label>
                      <select class="form-control" name="ID_MENU" id="ID_MENU">
                        
                        <option value="">Sélectionner</option>
                        <?php 
                        foreach ($ID_MENU as $key_marque) 
                        {
                          if ($key_marque['ID_MENU']==set_value('ID_MENU')) 
                            {?>
                              <option value="<?= $key_marque['ID_MENU'] ?>" selected=''><?= $key_marque['NOM_MENU'] ?></option>
                              <?php } else {?>
                              <option value="<?= $key_marque['ID_MENU'] ?>"><?= $key_marque['NOM_MENU'] ?></option>
                              <?php 
                            }
                          }

                          ?>

                        </select>
                        <?php echo form_error('ID_MENU', '<div class="text-danger">', '</div>'); ?> 
                      </div>

                      
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label>NUMERO CLIENT</label>
                        <input type="number" name="NUMERO_CLIENT" autocomplete="off" id="NUMERO_CLIENT" value="<?= set_value('NUMERO_CLIENT') ?>"  class="form-control">
                        
                        <?php echo form_error('NUMERO_CLIENT', '<div class="text-danger">', '</div>'); ?> 
                        
                      </div>

                      <div class="col-md-6">
                        <label for="FName">ADRESSE</label>
                        <input type="Text" name="ADRESSE_CLIENT" autocomplete="off" id="ADRESSE_CLIENT" value="<?= set_value('ADRESSE_CLIENT') ?>"  class="form-control">
                        
                        <?php echo form_error('ADRESSE_CLIENT', '<div class="text-danger">', '</div>'); ?> 

                      </div>

                      <div class="col-md-6">
                        <label for="FName">Date de commande</label>
                        <input type="Date" name="DATE_COMMANDE" autocomplete="off" id="DATE_COMMANDE" value="<?= set_value('DATE_COMMANDE') ?>"  class="form-control">
                        
                        <?php echo form_error('DATE_COMMANDE', '<div class="text-danger">', '</div>'); ?> 

                      </div>
                      <div class="col-md-6">
                        <label for="FName">LONGITUDE</label>
                        <input type="number" name="LONGITUDE" autocomplete="off" id="LONGITUDE" value="<?= set_value('LONGITUDE') ?>"  class="form-control">
                        
                        <?php echo form_error('DATE_COMMANDE', '<div class="text-danger">', '</div>'); ?> 

                      </div>

                      
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="FName">LATITUDE</label>
                        <input type="number" name="LATITUDE" autocomplete="off" id="LATITUDE" value="<?= set_value('LATITUDE') ?>"  class="form-control">
                        
                        <?php echo form_error('LATITUDE', '<div class="text-danger">', '</div>'); ?> 

                      </div>

                      <div class="col-md-6">
                        <label for="STATUT" class="form-check-input-label">VALIDATION</label>
                        <div class="d-flex">
                          <div>
                            <input type="radio" id="premier" value="0"  name="STATUT" autocomplete="off">
                            <label for="premier">NON VALIDE</label>
                          </div>&nbsp;
                          <div>
                            <input type="radio" id="deuxieme" value="1" name="STATUT" autocomplete="off">
                            <label for="deuxieme">VALIDE</label>
                          </div>
                        </div>

                      </div>
                    </div>
                    
                    <div class="col-md-6" style="margin-top:31px;">
                      <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
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


