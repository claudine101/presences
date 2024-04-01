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
              <a href="<?= base_url('PSR/Infra_peines/index') ?>" class='btn btn-primary float-right'>
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

                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Infra_peines/add'); ?>">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="FName">Infractions</label>
                      <select class="form-control" name="ID_INFRA_INFRACTION" id="ID_INFRA_INFRACTION">

                        <option value="">Sélectionner</option>
                        <?php
                        foreach ($infraPeines as $key_marque) {
                          if ($key_marque['ID_INFRA_INFRACTION'] == set_value('ID_INFRA_INFRACTION')) { ?>
                            <option value="<?= $key_marque['ID_INFRA_INFRACTION'] ?>" selected=''><?= $key_marque['NIVEAU_ALERTE'] ?></option>
                          <?php } else { ?>
                            <option value="<?= $key_marque['ID_INFRA_INFRACTION'] ?>"><?= $key_marque['NIVEAU_ALERTE'] ?></option>
                        <?php
                          }
                        }

                        ?>

                      </select>

                      <?php echo form_error('ID_INFRA_INFRACTION', '<div class="text-danger">', '</div>'); ?>

                    </div>


                    <div class="col-md-6">
                      <label for="FName">Peines</label>
                      <input type="text" name="AMENDES" autocomplete="off" id="AMENDES" value="<?= set_value('AMENDES') ?>" class="form-control">
                      <?php echo form_error('AMENDES', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Montant</label>
                      <input type="text" name="MONTANT" autocomplete="off" id="MONTANT" value="<?= set_value('MONTANT') ?>" class="form-control">

                      <?php echo form_error('MONTANT', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName">POINTS</label>
                      <input type="text" name="POINTS" autocomplete="off" id="POINTS" value="<?= set_value('POINTS') ?>" class="form-control">

                      <?php echo form_error('POINTS', '<div class="text-danger">', '</div>'); ?>

                    </div>

                  </div>

                  <div class="col-md-12" style="margin-top:31px;">
                    <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
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