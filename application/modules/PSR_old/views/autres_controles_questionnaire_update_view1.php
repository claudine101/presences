<!DOCTYPE html>
<html lang="en">
<?php

use function PHPSTORM_META\elementType;

include VIEWPATH . 'templates/header.php'; ?>

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
              <a href="<?= base_url('PSR/Autres_controles_questionnaires/index') ?>" class='btn btn-primary float-right'>
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

                <form name="myform" method="post" enctype="multipart/form-data" class="form-horizontal" action="<?= base_url('PSR/Autres_controles_questionnaires/update'); ?>">

                  <div class="row">
                    <input type="hidden" class="form-control" name="ID_CONTROLES_QUESTIONNAIRES" value="<?= $questions['ID_CONTROLES_QUESTIONNAIRES'] ?>">


                    <div class="col-md-6">
                      <label for="Ftype">Categorie</label>
                      <select class="form-control" name="ID_QUESTIONNAIRE_CATEGORIES" id="ID_QUESTIONNAIRE_CATEGORIES">

                        <?php
                        foreach ($categorie_g as $value) {
                          $selected = "";
                          if ($value['ID_QUESTIONNAIRE_CATEGORIES'] == $questions['ID_QUESTIONNAIRE_CATEGORIES']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['ID_QUESTIONNAIRE_CATEGORIES'] ?>" <?= $selected ?>><?= $value['CATEGORIES'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('ID_QUESTIONNAIRE_CATEGORIES', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Infranctions</label>
                      <input type="text" name="INFRACTIONS" value="<?= $questions['INFRACTIONS'] ?>" id="INFRACTIONS" class="form-control">

                      <?php echo form_error('INFRACTIONS', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName">Description</label>
                      <input type="text" name="DESCRIPTION" value="<?= $questions['DESCRIPTION'] ?>" id="DESCRIPTION" class="form-control">

                      <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <label for="FName">Montant</label>
                      <input type="text" name="MONTANT" value="<?= $questions['MONTANT'] ?>" id="MONTANT" class="form-control">

                      <?php echo form_error('MONTANT', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Points</label>
                      <input type="text" name="POURCENTAGE" value="<?= $questions['POURCENTAGE'] ?>" id="POURCENTAGE" class="form-control">

                      <?php echo form_error('POURCENTAGE', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">

                      <label for="maniere">Manière de Repondre</label>
                      <select class="form-control" name="MANIERE_REPONSE">

                        <?php if ($questions['MANIERE_REPONSE'] == 2) { ?>
                          <option value="null">Pas Besoin</option>
                          <option value="2" selected>SELECT</option>
                          <option value="1">INPUT</option>
                        <?php } else if ($questions['MANIERE_REPONSE'] == 1) { ?>
                          <option value="null">Pas Besoin</option>
                          <option value="2">SELECT</option>
                          <option value="1" selected>INPUT</option>
                        <?php } else { ?>
                          <option value="null" selected>Pas Besoin</option>
                          <option value="2">SELECT</option>
                          <option value="1">INPUT</option>
                        <?php } ?>
                      </select>


                      <?php echo form_error('MANIERE_REPONSE', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Label de Reponse</label>
                      <input type="text" name="LABEL_REPONSE" value="<?= $questions['LABEL_REPONSE'] ?>" id="LABEL_REPONSE" class="form-control">

                      <?php echo form_error('LABEL_REPONSE', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Label de description</label>
                      <input type="text" name="DESCR_LABEL" value="<?= $questions['DESCR_LABEL'] ?>" id="DESCR_LABEL" class="form-control">

                      <?php echo form_error('DESCR_LABEL', '<div class="text-danger">', '</div>'); ?>

                    </div>


                    <div class="col-md-6">
                      <br>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="NEED_IDENTITE" <?= $chec1 ?> value="<?= $questions['NEED_IDENTITE'] ?>" id="NEED_IDENTITE">
                        <label class="form-check-label" for="NEED_IDENTITE">
                          Besoin d'identification
                        </label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <br>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="NEED_IMAGE" <?= $chec2 ?> value="<?= $questions['NEED_IMAGE'] ?>" id="NEED_IMAGE">
                        <label class="form-check-label" for="NEED_IMAGE">
                          Besoin d'Image
                        </label>
                      </div>
                    </div>



                    <div class="col-md-6 row">
                      <div class="col-md-6">
                        <label for="text" style="font-size: 10px;" id="fileName"></label></BR>
                        <label class="label" data-toggle="tooltip" title="Attacher un fichier">
                          <font style="font-size: 40PX;color: green"><i class="fas fa-image rounded" id="avatar" alt="avatar"></i></font>
                          <input type="file" class="sr-only" id="PHOTO" name="PHOTO" accept="image/*" required>
                        </label>
                      </div>
                      <div class="col-md-6" style="margin-top: 5px" id="resultGet"></div>

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

<?php include VIEWPATH . 'templates/footer.php'; ?>


<script type="text/javascript">
  function readURL(input) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        //alert(e.target.result);
        $('#buttonFile').delay(100).show('hide');
        let myArr = e.target.result;
        const myArrData = myArr.split(":");
        let deux_name = myArrData[1].split("/");

        if (deux_name[0] == 'image') {
          var back_lect = '<img  height="80" src="' + e.target.result + '">';
          $('#resultGet').html(back_lect);
        } else {
          $('#resultGet').html('');
        }

      }

      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

  $("#PHOTO").change(function() {
    readURL(this);
  });
</script>