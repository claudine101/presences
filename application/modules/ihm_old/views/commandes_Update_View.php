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

 <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/visualisation_commandes/update'); ?>" >
                <div class="row">
                  <div class="col-md-6">

                  <input type="hidden" class="form-control" name="ID_COMMANDE" value="<?=$data['ID_COMMANDE']?>" >
                    <label for="LName">NOM_RESTAURANT</label>
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
            <input type="hidden" class="form-control" name="ID_MENU_RESTO" value="<?=$data['ID_MENU_RESTO']?>"
          <div class="col-md-6">
            <label for="FName">MENU</label>
                
              <select class="form-control" data-live-search="true"  name="ID_MENU" >
               <?php 
               foreach($ID_MENU as $key) { 
                if ($key['ID_MENU'] ==$data['ID_MENU']) { 
                  echo "<option value='".$key['ID_MENU']."' selected>".$key['NOM_MENU']."</option>";
                }  else{
                 echo "<option value='".$key['ID_MENU']."' >".$key['NOM_MENU']."</option>"; 
               } }?>
             </select> 

            <?php echo form_error('ID_MENU', '<div class="text-danger">', '</div>'); ?>
                  </div>
</div>
               <div class="row">
                <div class="col-md-6">
            

            <label>Date</label>
              <input type="Date" name="DATE_COMMANDE" value="<?=$data['DATE_COMMANDE'] ?>"  id="DATE_COMMANDE" class="form-control">

             <?php echo form_error('DATE_COMMANDE', '<div class="text-danger">', '</div>'); ?> 

 
             
                  </div>
                  <div class="col-md-6">
            

            <label>NUMERO CLIENT</label>
              <input type="Number" name="NUMERO_CLIENT" value="<?=$data['NUMERO_CLIENT'] ?>"  id="NUMERO_CLIENT" class="form-control">

             <?php echo form_error('NUMERO_CLIENT', '<div class="text-danger">', '</div>'); ?> 

 
             
                  </div>
 
                    </div>
            <div class="row">
            <div class="col-md-6">

            <label>ADRESSE CLIENT</label>
              <input type="Text" name="ADRESSE_CLIENT" value="<?=$data['ADRESSE_CLIENT'] ?>"  id="ADRESSE_CLIENT" class="form-control">

             <?php echo form_error('ADRESSE_CLIENT', '<div class="text-danger">', '</div>'); ?> 

 
             
                  
                         </div>

            
              <div class="col-md-6">
                <label>LONGITUDE</label>
              <input type="Text" name="LONGITUDE" value="<?=$data['LONGITUDE'] ?>"  id="LONGITUDE" class="form-control">

             <?php echo form_error('ADRESSE_CLIENT', '<div class="text-danger">', '</div>'); ?> 
</div>
 <div class="row">
  <div class="col-md-6">
                <label>LATITUDE</label>
              <input type="Text" name="LATITUDE" value="<?=$data['LATITUDE'] ?>"  id="LATITUDE" class="form-control">

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

<?php include VIEWPATH.'templates/footer.php'; ?>


