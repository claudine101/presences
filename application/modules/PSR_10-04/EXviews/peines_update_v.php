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
              <a href="<?=base_url('PSR/infra_peines/index')?>" class='btn btn-primary float-right'>
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

               <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Infra_peines/update'); ?>" >

                <div class="row">
                    <input type="hidden" class="form-control" name="ID_INFRA_PEINE" value="<?=$data['ID_INFRA_PEINE']?>" >


                    <div class="col-md-6">
                      <label for="FName">NUMERO_PLAQUE</label>
                      <input type="text" name="NUMERO_PLAQUE" value="<?=$data['NUMERO_PLAQUE'] ?>"  id="NUMERO_PLAQUE" class="form-control">

                      <?php echo form_error('NUMERO_PLAQUE', '<div class="text-danger">', '</div>'); ?> 

                    </div>
                    <div class="col-md-6">
                      <label for="FName">NOM_DECLARANT</label>
                      <input type="text" name="NOM_DECLARANT" value="<?=$data['NOM_DECLARANT'] ?>"  id="NOM_DECLARANT" class="form-control">

                      <?php echo form_error('NOM_DECLARANT', '<div class="text-danger">', '</div>'); ?> 

                    </div>
                        <div class="col-md-6">
                      <label for="FName">PRENOM_DECLARANT</label>
                      <input type="text" name="PRENOM_DECLARANT" value="<?=$data['PRENOM_DECLARANT'] ?>"  id="PRENOM_DECLARANT" class="form-control">

                      <?php echo form_error('PRENOM_DECLARANT', '<div class="text-danger">', '</div>'); ?> 

                    </div>
                    <div class="col-md-6">
                      <label for="FName">COULEUR_VOITURE</label>
                      <input type="text" name="COULEUR_VOITURE" value="<?=$data['COULEUR_VOITURE'] ?>"  id="COULEUR_VOITURE" class="form-control">

                      <?php echo form_error('COULEUR_VOITURE', '<div class="text-danger">', '</div>'); ?> 

                    </div>

                        <div class="col-md-6">
                      <label for="FName">MARQUE_VOITURE</label>
                      <input type="text" name="MARQUE_VOITURE" value="<?=$data['MARQUE_VOITURE'] ?>"  id="MARQUE_VOITURE" class="form-control">

                      <?php echo form_error('MARQUE_VOITURE', '<div class="text-danger">', '</div>'); ?> 

                    </div>
                    <div class="col-md-6">
                      <label for="FName">DATE_VOLER</label>
                      <input type="text" name="DATE_VOLER" value="<?=$data['DATE_VOLER'] ?>"  id="DATE_VOLER" class="form-control">

                      <?php echo form_error('DATE_VOLER', '<div class="text-danger">', '</div>'); ?> 

                    </div>
                  </div>

                </div>  
                <div class="col-md-6" style="margin-top:31px;">
                  <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Modifier</button>

                </div>
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


