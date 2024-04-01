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
              <a href="<?=base_url('PSR/Signalement_accident/index')?>" class='btn btn-primary float-right'>
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

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Signalement_accident/update'); ?>" >
                 <div class="row">
                  <input type="hidden" class="form-control" name="ID_SIGN_ACCIDENT" value="<?=$datas['ID_SIGN_ACCIDENT']?>" >

                  <div class="col-md-6">
                    <label for="FName">PLAQUE</label>
                    <input type="text" name="PLAQUE" id="PLAQUE" value="<?= 
                    $datas['PLAQUE'] ?>"  class="form-control">
                    
                    <?php echo form_error('PLAQUE', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                  <div class="col-md-6">
                    <label for="Ftype">Etat de l'activité</label>
                    <select class="form-control" name="ID_TYPE_GRAVITE" id="ID_TYPE_GRAVITE" >
                      <!-- <option value="">---Sélectionner---</option> -->
                      <?php

                      foreach ($gravites as $value)
                      {

                        $selected="";
                        if($value['ID_TYPE_GRAVITE']==$datas['ID_TYPE_GRAVITE'])
                        {
                          $selected="selected";
                        }
                        ?>
                        <option value="<?=$value['ID_TYPE_GRAVITE']?>" <?=$selected?>> <?=$value['DESCRIPTION']?></option>
                        <?php
                      }
                      ?>
                    </select>
                    <div><font color="red" id="error_profil"></font></div> 
                  </div>

                  
                  <div class="col-md-6">
                    <label for="FName">Description</label>
                    <input type="text" name="DESCRIPTION" autocomplete="off" id="DESCRIPTION" value="<?= 
                    $datas['DESCRIPTION'] ?>"  class="form-control">
                    
                    <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                  <div class="col-md-6">
                      <label for="Ftype">Route</label>
                      <select class="form-control" name="ID_CHAUSSEE" id="ID_CHAUSSEE">
                        
                        <?php

                        foreach ($chausses as $value)
                        {

                          $selected="";
                          if($value['ID_CHAUSSEE']==$questions['ID_CHAUSSEE'])
                          {
                            $selected="selected";
                          }
                          ?>
                          <option value="<?=$value['ID_CHAUSSEE']?>" <?=$selected?>><?=$value['NOM_CHAUSSE']?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('ID_CHAUSSEE', '<div class="text-danger">', '</div>'); ?> 

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

