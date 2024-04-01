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

                <form name="myform" method="post" enctype="multipart/form-data" class="form-horizontal" action="<?= base_url('PSR/Autres_controles_questionnaires/add'); ?>">



                  <div class="row">
                    <div class="col-md-6">
                      <label for="FName">Infranctions</label>
                      <input type="text" name="INFRACTION" autocomplete="off" id="INFRACTION" value="<?= set_value('INFRACTION') ?>" class="form-control">

                      <?php echo form_error('INFRACTION', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Description</label>
                      <input type="text" name="DESCRIPTION" autocomplete="off" id="DESCRIPTION" value="<?= set_value('DESCRIPTION') ?>" class="form-control">
                      <?php echo form_error('DESCRIPTION', '<div class="text-danger" >', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Amendes (en FBU)</label>
                      <input type="text" name="MONTANT" autocomplete="off" id="MONTANT" value="<?= set_value('MONTANT') ?>" class="form-control">

                      <?php echo form_error('MONTANT', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Points</label>
                      <input type="text" name="POURCENTAGE" autocomplete="off" id="POURCENTAGE" value="<?= set_value('POURCENTAGE') ?>" class="form-control">
                      <?php echo form_error('POURCENTAGE', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="Ftype">Catégorie</label>
                      <select required class="form-control" name="ID_QUESTIONNAIRE_CATEGORIES" id="ID_QUESTIONNAIRE_CATEGORIES">
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($categorie_g as $value) {
                        ?>
                          <option value="<?= $value['ID_QUESTIONNAIRE_CATEGORIES'] ?>"><?= $value['CATEGORIES'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <!-- <div><font color="red" id="error_province"></font></div>  -->
                      <?php echo form_error('ID_QUESTIONNAIRE_CATEGORIES', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="col-md-6">

                      <label for="maniere">Manière de Repondre</label>
                      <select class="form-control" name="MANIERE_REPONSE">
                        <option value="null">Pas Besoin</option>
                        <option value="2">SELECT</option>
                        <option value="1">INPUT</option>
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label for="FName">Label Reponse</label>
                      <input type="text" name="LABEL_REPONSE" autocomplete="off" id="LABEL_REPONSE" value="<?= set_value('LABEL_REPONSE') ?>" class="form-control">

                      <?php echo form_error('LABEL_REPONSE', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Label de description</label>
                      <input type="text" name="DESCR_LABEL" autocomplete="off" id="DESCR_LABEL" value="<?= set_value('DESCR_LABEL') ?>" class="form-control">

                      <?php echo form_error('DESCR_LABEL', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-6">
                      <br>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="NEED_IDENTITE" value="0" id="NEED_IDENTITE">
                        <label class="form-check-label" for="NEED_IDENTITE">
                          Besoin d'identité
                        </label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <br>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="NEED_IMAGE" value="0" id="NEED_IMAGE">
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


                    <div class="col-md-6" style="margin-top:31px;">
                      <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
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