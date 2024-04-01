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
              <a href="<?=base_url('PSR/Assurances/index')?>" class='btn btn-primary float-right'>
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

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Assurances/add'); ?>" >

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
                    <label for="FName">Assureur</label>
                    <input type="text" name="NOM_ASSUREUR" autocomplete="off" id="NOM_ASSUREUR" value="<?= set_value('NOM_ASSUREUR') ?>"  class="form-control">
                    
                    <?php echo form_error('NOM_ASSUREUR', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> Debut</label>
                    <input type="date" name="DATE_DEBUT" autocomplete="off" id="DATE_DEBUT" value="<?= set_value('DATE_DEBUT') ?>"  class="form-control">
                    
                    <?php echo form_error('DATE_DEBUT', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> Date de Validite  </label>
                    <input type="date" name="DATE_VALIDITE" autocomplete="off" id="DATE_VALIDITE" value="<?= set_value('DATE_VALIDITE') ?>"  class="form-control">
                    
                    <?php echo form_error('DATE_VALIDITE', '<div class="text-danger">', '</div>'); ?> 
                  </div>

                  <div class="col-md-6">
                    <label for="FName"> Places assurées</label>
                    <input type="text" name="PLACES_ASSURES" autocomplete="off" id="PLACES_ASSURES" value="<?= set_value('PLACES_ASSURES') ?>"  class="form-control">
                    
                    <?php echo form_error('PLACES_ASSURES', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName">Type d'assurance</label>
                    <input type="text" name="TYPE_ASSURANCE" autocomplete="off" id="TYPE_ASSURANCE" value="<?= set_value('TYPE_ASSURANCE') ?>"  class="form-control">
                    
                    <?php echo form_error('TYPE_ASSURANCE', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                   <div class="col-md-6">
                    <label for="FName">Proprietaire</label>
                    <input type="text" name="NOM_PROPRIETAIRE" autocomplete="off" id="NOM_PROPRIETAIRE" value="<?= set_value('NOM_PROPRIETAIRE') ?>"  class="form-control">
                    
                    <?php echo form_error('NOM_PROPRIETAIRE', '<div class="text-danger">', '</div>'); ?> 
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


