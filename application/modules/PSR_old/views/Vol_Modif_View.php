<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include VIEWPATH . 'templates/navbar.php'; ?>
    <!-- Main Sidebar Container -->
    <?php include VIEWPATH . 'templates/sidebar.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-9">

              <h4 class="m-0"><?= $title ?></h4>
            </div><!-- /.col -->
            <div class="col-sm-3">
              <a href="<?= base_url('PSR/Vol_Controller/index') ?>" class='btn btn-primary float-right'>
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

                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Vol_Controller/update'); ?>">

                  <div class="row">

                    <input type="hidden" class="form-control" name="ID_TAMPO_PJ" value="<?= $data['ID_TAMPO_PJ'] ?>">




                    <div class="col-md-6">
                      <label for="FName">Marque</label>
                      <input type="text" name="MARQUE_VOITURE" value="<?= $data['MARQUE_VOITURE'] ?>" id="MARQUE_VOITURE" class="form-control">



                    </div>



                    <div class="col-md-6">
                      <label for="FName">Numero de série</label>
                      <input type="text" name="NUMERO_SERIE" value="<?= $data['NUMERO_SERIE'] ?>" id="NUMERO_SERIE" class="form-control">



                    </div>

                  </div>
                  <div class="row">
                    <div class="col-md-6">

                      <label for="FName">Couleur</label>
                      <select class="form-control" name="ID_TYPE_COULEUR" id="ID_TYPE_COULEUR" required>


                        <?php
                        foreach ($couleur as $key_marque) {
                          if ($key_marque['ID_TYPE_COULEUR'] == set_value('ID_TYPE_COULEUR')) { ?>
                            <option value="<?= $data['ID_TYPE_COULEUR'] ?>"></option>
                            <option value="<?= $key_marque['ID_TYPE_COULEUR'] ?>" selected=''><?= $key_marque['COULEUR'] ?></option>
                          <?php } else { ?>
                            <option value="<?= $key_marque['ID_TYPE_COULEUR'] ?>"><?= $key_marque['COULEUR'] ?></option>
                        <?php
                          }
                        }

                        ?>

                      </select>

                      <?php echo form_error('ID_TYPE_COULEUR', '<div class="text-danger">', '</div>'); ?>


                    </div>
                    <div class="col-md-6">

                      <label for="FName">DATE du vol</label>
                      <input type="date" name="DATE_VOLER" value="<?= $data['DATE_VOLER'] ?>" id="DATE_VOLER" class="form-control">


                    </div>
                    <div class="col-md-6">
                      <label for="FName">NUMERO PERMIS</label>
                      <input type="text" name="NUMERO_PERMIS" value="<?= $data['NUMERO_PERMIS'] ?>" id="NUMERO_PERMIS" class="form-control">
                    </div>
                  </div>


              </div>



            </div>
            <div class="col-md-12" style="margin-top:31px;">
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

<?php include VIEWPATH . 'templates/footer.php'; ?>


<script>

</script>