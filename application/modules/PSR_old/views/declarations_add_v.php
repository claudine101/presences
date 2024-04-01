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
              <a href="<?=base_url('PSR/Declaration_Vol/index')?>" class='btn btn-primary float-right'>
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

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Declaration_Vol/add'); ?>" >

                 <div class="row">
                   <div class="col-md-6">
                    <label for="Ftype">Plaque</label>
                     <select required class="form-control" name="NUMERO_PLAQUE" id="NUMERO_PLAQUE" >
                          <option value="">---Sélectionner---</option>
                          <?php
                            foreach ($plaques as $value)
                            {
                          ?>
                          <option value="<?=$value['NUMERO_PLAQUE']?>"><?=$value['NUMERO_PLAQUE']?></option>
                          <?php
                            }
                          ?>
                        </select>
                    <!-- <div><font color="red" id="error_province"></font></div>  -->
                    <?php echo form_error('NUMERO_PLAQUE', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <div class="col-md-6">
                    <label for="FName">Nom du declarant</label>
                    <input type="text" name="NOM_DECLARANT" autocomplete="off" id="NOM_DECLARANT" value="<?= set_value('NOM_DECLARANT') ?>"  class="form-control">
                    
                    <?php echo form_error('NOM_DECLARANT', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> Prenom du declarant</label>
                    <input type="text" name="PRENOM_DECLARANT" autocomplete="off" id="PRENOM_DECLARANT" value="<?= set_value('PRENOM_DECLARANT') ?>"  class="form-control">
                    
                    <?php echo form_error('PRENOM_DECLARANT', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName">  Couleur </label>
                    <input type="text" name="COULEUR_VOITURE" autocomplete="off" id="COULEUR_VOITURE" value="<?= set_value('COULEUR_VOITURE') ?>"  class="form-control">
                    
                    <?php echo form_error('COULEUR_VOITURE', '<div class="text-danger">', '</div>'); ?> 
                  </div>

                  <div class="col-md-6">
                    <label for="FName"> Marque</label>
                    <input type="text" name="MARQUE_VOITURE" autocomplete="off" id="MARQUE_VOITURE" value="<?= set_value('MARQUE_VOITURE') ?>"  class="form-control">
                    
                    <?php echo form_error('MARQUE_VOITURE', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> Date du vol</label>
                    <input type="date" name="DATE_VOLER" autocomplete="off" id="DATE_VOLER" value="<?= set_value('DATE_VOLER') ?>"  class="form-control">
                    
                    <?php echo form_error('DATE_VOLER', '<div class="text-danger">', '</div>'); ?> 
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


