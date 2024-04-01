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
              <a href="<?= base_url('PSR/Obr_Immatriculation/index') ?>" class='btn btn-primary float-right'>
                <i class="nav-icon fas fa-list ul"></i>
                Liste
              </a>
            </div><!-- /.col -->
          </div>
        </div><!-- /.container-fluid -->
      </section>il

      <!-- Main content -->
      <section class="content">
        <div class="col-md-12 col-xl-12 grid-margin stretch-card">

          <div class="card">
            <div class="card-body">

              <div class="col-md-12">

                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Obr_Immatriculation/add'); ?>">

                  <div class="row">
                    <div class="col-md-6">
                      <label for="FName">N° carte rose</label>
                      <input type="text" name="NUMERO_CARTE_ROSE" autocomplete="off" id="NUMERO_CARTE_ROSE" value="<?= set_value('NUMERO_CARTE_ROSE') ?>" class="form-control">

                      <?php echo form_error('NUMERO_CARTE_ROSE', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Plaque</label>
                      <input type="text" name="NUMERO_PLAQUE" autocomplete="off" id="NUMERO_PLAQUE" value="<?= set_value('NUMERO_PLAQUE') ?>" class="form-control">

                      <?php echo form_error('NUMERO_PLAQUE', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName">Catégorie</label>
                      <input type="text" name="CATEGORIE_PLAQUE" autocomplete="off" id="CATEGORIE_PLAQUE" value="<?= set_value('CATEGORIE_PLAQUE') ?>" class="form-control">

                      <?php echo form_error('CATEGORIE_PLAQUE', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName">Marque</label>
                      <input type="text" name="MARQUE_VOITURE" autocomplete="off" id="MARQUE_VOITURE" value="<?= set_value('MARQUE_VOITURE') ?>" class="form-control">

                      <?php echo form_error('MARQUE_VOITURE', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName">N° Chassis</label>
                      <input type="text" name="NUMERO_CHASSIS" autocomplete="off" id="NUMERO_CHASSIS" value="<?= set_value('NUMERO_CHASSIS') ?>" class="form-control">

                      <?php echo form_error('NUMERO_CHASSIS', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Places</label>
                      <input type="text" name="NOMBRE_PLACE" autocomplete="off" id="NOMBRE_PLACE" value="<?= set_value('NOMBRE_PLACE') ?>" class="form-control">

                      <?php echo form_error('NOMBRE_PLACE', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName">Nom du propriètaire</label>
                      <input type="text" name="NOM_PROPRIETAIRE" autocomplete="off" id="NOM_PROPRIETAIRE" value="<?= set_value('NOM_PROPRIETAIRE') ?>" class="form-control">

                      <?php echo form_error('NOM_PROPRIETAIRE', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName">Prenom du propriètaire</label>
                      <input type="text" name="PRENOM_PROPRIETAIRE" autocomplete="off" id="PRENOM_PROPRIETAIRE" value="<?= set_value('PRENOM_PROPRIETAIRE') ?>" class="form-control">

                      <?php echo form_error('PRENOM_PROPRIETAIRE', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName">Téléphone du propriètaire</label>
                      <input type="text" name="TELEPHONE" autocomplete="off" id="TELEPHONE" value="<?= set_value('TELEPHONE') ?>" class="form-control">

                      <?php echo form_error('TELEPHONE', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName">Email du propriètaire</label>
                      <input type="text" name="EMAIL" autocomplete="off" id="EMAIL" value="<?= set_value('EMAIL') ?>" class="form-control">

                      <?php echo form_error('EMAIL', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName">CNI</label>
                      <input type="text" name="NUMERO_IDENTITE" autocomplete="off" id="NUMERO_IDENTITE" value="<?= set_value('NUMERO_IDENTITE') ?>" class="form-control">

                      <?php echo form_error('NUMERO_IDENTITE', '<div class="text-danger">', '</div>'); ?>

                    </div>



                    <div class="col-md-6">
                      <label for="Ftype">Province</label>
                      <select required class="form-control" name="ID_PROVINCE" id="ID_PROVINCE">
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($provinces as $value) {
                        ?>
                          <option value="<?= $value['PROVINCE_ID'] ?>"><?= $value['PROVINCE_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <!-- <div><font color="red" id="error_province"></font></div>  -->
                      <?php echo form_error('ID_PROVINCE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName">Profession</label>
                      <input type="text" name="CATEGORIE_PROPRIETAIRE" autocomplete="off" id="CATEGORIE_PROPRIETAIRE" value="<?= set_value('CATEGORIE_PROPRIETAIRE') ?>" class="form-control">

                      <?php echo form_error('CATEGORIE_PROPRIETAIRE', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName"> Catégorie d'usage</label>
                      <input type="text" name="CATEGORIE_USAGE" autocomplete="off" id="CATEGORIE_USAGE" value="<?= set_value('CATEGORIE_USAGE') ?>" class="form-control">

                      <?php echo form_error('CATEGORIE_USAGE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Puissance</label>
                      <input type="text" name="PUISSANCE" autocomplete="off" id="PUISSANCE" value="<?= set_value('PUISSANCE') ?>" class="form-control">

                      <?php echo form_error('PUISSANCE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Couleur</label>
                      <input type="text" name="COULEUR" autocomplete="off" id="COULEUR" value="<?= set_value('COULEUR') ?>" class="form-control">

                      <?php echo form_error('COULEUR', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Année de fabrication</label>
                      <input type="text" name="ANNEE_FABRICATION" autocomplete="off" id="ANNEE_FABRICATION" value="<?= set_value('ANNEE_FABRICATION') ?>" class="form-control">

                      <?php echo form_error('ANNEE_FABRICATION', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="col-md-6">
                      <label for="FName"> Modele du Véhicule</label>
                      <input type="text" name="MODELE_VOITURE" autocomplete="off" id="MODELE_VOITURE" value="<?= set_value('MODELE_VOITURE') ?>" class="form-control">

                      <?php echo form_error('MODELE_VOITURE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Poids</label>
                      <input type="text" name="POIDS" autocomplete="off" id="POIDS" value="<?= set_value('POIDS') ?>" class="form-control">

                      <?php echo form_error('POIDS', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Type Carburant</label>
                      <input type="text" name="TYPE_CARBURANT" autocomplete="off" id="TYPE_CARBURANT" value="<?= set_value('TYPE_CARBURANT') ?>" class="form-control">

                      <?php echo form_error('TYPE_CARBURANT', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Taxe DMC</label>
                      <input type="text" name="TAXE_DMC" autocomplete="off" id="TAXE_DMC" value="<?= set_value('TAXE_DMC') ?>" class="form-control">

                      <?php echo form_error('TAXE_DMC', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> NIF</label>
                      <input type="text" name="NIF" autocomplete="off" id="NIF" value="<?= set_value('NIF') ?>" class="form-control">

                      <?php echo form_error('NIF', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Date de délivrance</label>
                      <input type="text" name="DATE_DELIVRANCE" autocomplete="off" id="DATE_DELIVRANCE" value="<?= set_value('DATE_DELIVRANCE') ?>" class="form-control">

                      <?php echo form_error('DATE_DELIVRANCE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                  </div>

                  <div class="col-md-12" style="margin-top:31px;">
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

<?php include VIEWPATH . 'templates/footer.php'; ?>



<script>
  function get_communes() {
    var ID_PROVINCE = $('#ID_PROVINCE').val();
    if (ID_PROVINCE == '') {
      $('#ID_COMMUNE').html('<option value="">---Sélectionner---</option>');
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>PSR/Psr_elements/get_communes/" + ID_PROVINCE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COMMUNE').html(data);
        }
      });

    }
  }

  function get_zones() {
    var ID_COMMUNE = $('#ID_COMMUNE').val();
    if (ID_COMMUNE == '') {
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>PSR/Psr_elements/get_zones/" + ID_COMMUNE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_ZONE').html(data);
        }
      });

    }
  }


  function get_collines() {
    var ID_ZONE = $('#ID_ZONE').val();
    if (ID_ZONE == '') {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>PSR/Psr_elements/get_collines/" + ID_ZONE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COLLINE').html(data);
        }
      });

    }
  }
</script>