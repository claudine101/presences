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
              <a href="<?=base_url('ihm/Identite/index')?>" class='btn btn-primary float-right'>
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
                <!--  -->

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Identite/update'); ?>" enctype="multipart/form-data">
                 <div class="row">
                  <input type="hidden" class="form-control" name="ID_IDENTITE" value="<?=$datas['ID_IDENTITE']?>" >


                  <div class="col-md-6">
                    <label for="Ftype">DESCRIPTION</label>
          <select class="form-control" name="ID_AUTRES_CONTROLES" id="ID_AUTRES_CONTROLES" >
                      <!-- <option value="">---Sélectionner---</option> -->
                      <?php

                      foreach ($controle as $value)
                      {

                        $selected="";
                        if($value['ID_AUTRES_CONTROLES']==$datas['ID_IDENTITE'])
                        {
                          $selected="selected";
                        }
                        ?>
                        <option value="<?=$value['ID_AUTRES_CONTROLES']?>" <?=$selected?>><?=$value['DESCRP_REPONSE']?></option>
                        <?php
                      }
                      ?>
                    </select>
                    <div><font color="red" id="error_profil"></font></div> 
                  </div>


                 <div class="col-md-6">
                    <label for="Ftype">Nationalite</label>
          <select class="form-control" name="NATIONNALITE_ID" id="NATIONNALITE_ID" >
                      <!-- <option value="">---Sélectionner---</option> -->
                      <?php

                      foreach ($nationalite as $value)
                      {

                        $selected="";
                        if($value['COUNTRY_ID']==$datas['NATIONNALITE_ID'])
                        {
                          $selected="selected";
                        }
                        ?>
                        <option value="<?=$value['COUNTRY_ID']?>" <?=$selected?>> <?=$value['CommonName']?></option>
                        <?php
                      }
                      ?>
                    </select>
                    <div><font color="red" id="error_profil"></font></div> 
                  </div>







                  <div class="col-md-6">
                    <label for="FName">NOM</label>
                    <input type="text" name="NOM" autocomplete="off" id="NOM" value="<?= 
                    $datas['NOM'] ?>"  class="form-control">
                    
                    <?php echo form_error('NOM', '<div class="text-danger">', '</div>'); ?> 

                  </div>


                   <div class="col-md-6">
                    <label for="FName">SEXE</label>
                    <input type="text" name="SEXE" autocomplete="off" id="SEXE" value="<?= 
                    $datas['SEXE'] ?>"  class="form-control">
                    
                    <?php echo form_error('SEXE', '<div class="text-danger">', '</div>'); ?> 

                  </div>



                  <div class="col-md-6">
                    <label for="FName">CNI</label>
                    <input type="text" name="CNI" autocomplete="off" id="CNI" value="<?= 
                    $datas['CNI'] ?>"  class="form-control">
                    
                    <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?> 

                  </div>


                  <div class="col-md-6">
                    <label for="FName">TELEPHONE</label>
            <input type="text" name="TELEPHONE" autocomplete="off" id="TELEPHONE"value="<?= 
                    $datas['TELEPHONE'] ?>"  class="form-control">
                    
                    <?php echo form_error('TELEPHONE', '<div class="text-danger">', '</div>'); ?> 

                  </div>



                  <div class="col-md-6">
                    <label for="FName">PHOTO</label>
         
          
            <input type="file" name="PHOTO_NOUVEAU"  id="PHOTO_NOUVEAU"class="form-control">
                    
            <?php echo form_error('PHOTO_NOUVEAU', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                 

                </div>

                <div class="col-md-12" style="margin-top:31px;">
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

