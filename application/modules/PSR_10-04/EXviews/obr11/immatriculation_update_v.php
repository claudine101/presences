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
              <a href="<?=base_url('PSR/Obr_Immatriculation/index')?>" class='btn btn-primary float-right'>
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

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Obr_Immatriculation/update'); ?>" >

                 <div class="row">
                   <input type="hidden" class="form-control" name="ID_IMMATRICULATION" value="<?=$membre['ID_IMMATRICULATION']?>" >

                  <div class="col-md-6">
                    <label for="FName">NUMERO CARTE ROSE</label>
                    <input type="text" name="NUMERO_CARTE_ROSE" autocomplete="off" id="NUMERO_CARTE_ROSE" value="<?= $membre['NUMERO_CARTE_ROSE'] ?>"  class="form-control">
                    
                    <?php echo form_error('NUMERO_CARTE_ROSE', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                  <div class="col-md-6">
                    <label for="FName">PLAQUE</label>
                    <input type="text" name="NUMERO_PLAQUE" autocomplete="off" id="NUMERO_PLAQUE" value="<?= $membre['NUMERO_PLAQUE'] ?>"  class="form-control">
                    
                    <?php echo form_error('NUMERO_PLAQUE', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                  <div class="col-md-6">
                    <label for="FName">CATEGORIE</label>
                    <input type="text" name="CATEGORIE_PLAQUE" autocomplete="off" id="CATEGORIE_PLAQUE" value="<?= $membre['CATEGORIE_PLAQUE'] ?>"  class="form-control">
                    
                    <?php echo form_error('CATEGORIE_PLAQUE', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                  <div class="col-md-6">
                    <label for="FName">MARQUE_VOITURE</label>
                    <input type="text" name="MARQUE_VOITURE" autocomplete="off" id="MARQUE_VOITURE" value="<?= $membre['MARQUE_VOITURE'] ?>"  class="form-control">
                    
                    <?php echo form_error('MARQUE_VOITURE', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                  <div class="col-md-6">
                    <label for="FName">NUMERO_CHASSIS</label>
                    <input type="text" name="NUMERO_CHASSIS" autocomplete="off" id="NUMERO_CHASSIS" value="<?= $membre['NUMERO_CHASSIS'] ?>"  class="form-control">
                    
                    <?php echo form_error('NUMERO_CHASSIS', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                  <div class="col-md-6">
                    <label for="FName">NOMBRE_PLACE</label>
                    <input type="text" name="NOMBRE_PLACE" autocomplete="off" id="NOMBRE_PLACE" value="<?= $membre['NOMBRE_PLACE'] ?>"  class="form-control">
                    
                    <?php echo form_error('NOMBRE_PLACE', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                  <div class="col-md-6">
                    <label for="FName">NOM_PROPRIETAIRE</label>
                    <input type="text" name="NOM_PROPRIETAIRE" autocomplete="off" id="NOM_PROPRIETAIRE" value="<?= $membre['NOM_PROPRIETAIRE'] ?>"  class="form-control">
                    
                    <?php echo form_error('NOM_PROPRIETAIRE', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                  <div class="col-md-6">
                    <label for="FName">PRENOM_PROPRIETAIRE</label>
                    <input type="text" name="PRENOM_PROPRIETAIRE" autocomplete="off" id="PRENOM_PROPRIETAIRE" value="<?= $membre['PRENOM_PROPRIETAIRE'] ?>"  class="form-control">
                    
                    <?php echo form_error('PRENOM_PROPRIETAIRE', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                  <div class="col-md-6">
                    <label for="FName">NUMERO_IDENTITE</label>
                    <input type="text" name="NUMERO_IDENTITE" autocomplete="off" id="NUMERO_IDENTITE" value="<?= $membre['NUMERO_IDENTITE'] ?>"  class="form-control">
                    
                    <?php echo form_error('NUMERO_IDENTITE', '<div class="text-danger">', '</div>'); ?> 

                  </div>



                    <div class="col-md-6">
                    <label for="Ftype">Province</label>
                    <select class="form-control" name="ID_PROVINCE" id="ID_PROVINCE" >
                      <!-- <option value="">---Sélectionner---</option> -->
                      <?php

                      foreach ($provinces as $value)
                      {

                        $selected="";
                        if($value['PROVINCE_ID']==$membre['PROVINCE_ID'])
                        {
                          $selected="selected";
                        }
                        ?>
                        <option value="<?=$value['PROVINCE_ID']?>" <?=$selected?>><?=$value['PROVINCE_NAME']?></option>
                        <?php
                      }
                      ?>
                    </select>
                    <div><font color="red" id="error_province"></font></div> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName">CATEGORIE_PROPRIETAIRE</label>
                    <input type="text" name="CATEGORIE_PROPRIETAIRE" autocomplete="off" id="CATEGORIE_PROPRIETAIRE" value="<?= $membre['CATEGORIE_PROPRIETAIRE'] ?>"  class="form-control">
                    
                    <?php echo form_error('CATEGORIE_PROPRIETAIRE', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                  <div class="col-md-6">
                    <label for="FName"> CATEGORIE_USAGE</label>
                    <input type="text" name="CATEGORIE_USAGE" autocomplete="off" id="CATEGORIE_USAGE" value="<?= $membre['CATEGORIE_USAGE'] ?>"  class="form-control">
                    
                    <?php echo form_error('CATEGORIE_USAGE', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> PUISSANCE</label>
                    <input type="text" name="PUISSANCE" autocomplete="off" id="PUISSANCE" value="<?= $membre['PUISSANCE'] ?>"  class="form-control">
                    
                    <?php echo form_error('PUISSANCE', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> COULEUR</label>
                    <input type="text" name="COULEUR" autocomplete="off" id="COULEUR" value="<?= $membre['COULEUR'] ?>"  class="form-control">
                    
                    <?php echo form_error('COULEUR', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> ANNEE_FABRICATION</label>
                    <input type="text" name="ANNEE_FABRICATION" autocomplete="off" id="ANNEE_FABRICATION" value="<?= $membre['ANNEE_FABRICATION'] ?>"  class="form-control">
                    
                    <?php echo form_error('ANNEE_FABRICATION', '<div class="text-danger">', '</div>'); ?> 
                  </div>

                  <div class="col-md-6">
                    <label for="FName"> MODELE_VOITURE</label>
                    <input type="text" name="MODELE_VOITURE" autocomplete="off" id="MODELE_VOITURE" value="<?= $membre['MODELE_VOITURE'] ?>"  class="form-control">
                    
                    <?php echo form_error('MODELE_VOITURE', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> POIDS</label>
                    <input type="text" name="POIDS" autocomplete="off" id="POIDS" value="<?= $membre['POIDS'] ?>"  class="form-control">
                    
                    <?php echo form_error('POIDS', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> TYPE_CARBURANT</label>
                    <input type="text" name="TYPE_CARBURANT" autocomplete="off" id="TYPE_CARBURANT" value="<?= $membre['TYPE_CARBURANT'] ?>"  class="form-control">
                    
                    <?php echo form_error('TYPE_CARBURANT', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> TAXE_DMC</label>
                    <input type="text" name="TAXE_DMC" autocomplete="off" id="TAXE_DMC" value="<?= $membre['TAXE_DMC'] ?>"  class="form-control">
                    
                    <?php echo form_error('TAXE_DMC', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> NIF</label>
                    <input type="text" name="NIF" autocomplete="off" id="NIF" value="<?= $membre['NIF'] ?>"  class="form-control">
                    
                    <?php echo form_error('NIF', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> DATE_DELIVRANCE</label>
                    <input type="text" name="DATE_DELIVRANCE" autocomplete="off" id="DATE_DELIVRANCE" value="<?= $membre['DATE_DELIVRANCE'] ?>"  class="form-control">
                    
                    <?php echo form_error('DATE_DELIVRANCE', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                </div>

                <div class="col-md-6" style="margin-top:31px;">
                  <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Modifier</button>
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



