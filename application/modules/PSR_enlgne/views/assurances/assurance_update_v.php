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
              <a href="<?= base_url('PSR/Assurances/index') ?>" class='btn btn-primary float-right'>
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

                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Assurances/update'); ?>">

                  <div class="row">
                    <input type="hidden" class="form-control" name="ID_ASSURANCE" value="<?= $data['ID_ASSURANCE'] ?>">



                    <div class="col-md-6">
                      <label for="Ftype">Plaque</label>
                      <select class="form-control" name="NUMERO_PLAQUE" id="NUMERO_PLAQUE">

                        <?php

                        foreach ($plaques as $value) {

                          $selected = "";
                          if ($value['NUMERO_PLAQUE'] == $data['NUMERO_PLAQUE']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['NUMERO_PLAQUE'] ?>" <?= $selected ?>><?= $value['NUMERO_PLAQUE'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('NUMERO_PLAQUE', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="Ftype">Assureur</label>
                      <select class="form-control" name="ID_ASSUREUR" id="ID_ASSUREUR">

                        <?php

                        foreach ($assurances as $value) {

                          $selected = "";
                          if ($value['ID_ASSUREUR'] == $data['ID_ASSUREUR']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['ID_ASSUREUR'] ?>" <?= $selected ?>><?= $value['ASSURANCE'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('ID_ASSUREUR', '<div class="text-danger">', '</div>'); ?>

                    </div>



                    <div class="col-md-6">
                      <label for="FName">Début</label>
                      <input type="date" name="DATE_DEBUT" value="<?= date("Y-m-d", strtotime($data['DATE_DEBUT'])) ?>" id="DATE_DEBUT" class="form-control">
                      <?php echo form_error('DATE_DEBUT', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName">Fin</label>
                      <input type="date" name="DATE_VALIDITE" id="DATE_VALIDITE" value="<?= date("Y-m-d", strtotime($data['DATE_VALIDITE'])); ?>" class="form-control">
                      <?php echo form_error('DATE_VALIDITE', '<div class="text-danger">', '</div>'); ?>


                    </div>
                    <div class="col-md-6">
                      <label for="FName">Places assurées</label>
                      <input type="number" name="PLACES_ASSURES" value="<?= $data['PLACES_ASSURES'] ?>" id="PLACES_ASSURES" class="form-control">

                      <?php echo form_error('PLACES_ASSURES', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Type assurance</label>
                      <input type="text" name="TYPE_ASSURANCE" value="<?= $data['TYPE_ASSURANCE'] ?>" id="TYPE_ASSURANCE" class="form-control">

                      <?php echo form_error('TYPE_ASSURANCE', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName">Propriètaire</label>
                      <input type="text" name="NOM_PROPRIETAIRE" value="<?= $data['NOM_PROPRIETAIRE'] ?>" id="NOM_PROPRIETAIRE" class="form-control">

                      <?php echo form_error('NOM_PROPRIETAIRE', '<div class="text-danger">', '</div>'); ?>

                    </div>



                      <div class="col-md-6">
                      <label for="FName">Téléphone</label>
                      <input type="number" name="PHONE" autocomplete="off" id="PHONE" value="<?= $data['PHONE'] ?>" class="form-control">

                      <?php echo form_error('PHONE', '<div class="text-danger">', '</div>'); ?>
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

<?php include VIEWPATH . 'templates/footer.php'; ?>