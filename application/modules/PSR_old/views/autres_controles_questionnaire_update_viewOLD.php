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
                      <label for="FName">Infranctions</label>
                      <input type="text" name="INFRACTIONS" value="<?= $questions['INFRACTIONS'] ?>" id="FR" class="form-control">

                      <?php echo form_error('INFRACTIONS', '<div class="text-danger">', '</div>'); ?>

                      <br>
                      <div class="col-md-6">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#infranctionModal">Ajouter une autre langue</button>
                      </div>
                    </div>


                    <div class="col-md-6">
                      <!-- <label for="FName">Traduction Infranctions</label> -->
                      <!-- <input type="text" name="INFRA_TRADUCTION" autocomplete="off" id="INFRA_TRADUCTION" value='<?= htmlentities($questions['INFRA_TRADUCTION']) ?>' class="form-control"> -->
                      <textarea readonly name="INFRA_TRADUCTION" autocomplete="off" id="INFRA_TRADUCTION" class="form-control" ><?= htmlentities($questions['INFRA_TRADUCTION']) ?></textarea>

                      <?php echo form_error('INFRA_TRADUCTION', '<div class="text-danger">', '</div>'); ?>

                    </div>



                    <div class="col-md-6">
                      <label for="FName">Description</label>
                      <input type="text" name="DESCRIPTION" value="<?= $questions['DESCRIPTION'] ?>" id="FR1" class="form-control">

                      <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?>

                      <br>
                      <div class="col-md-6">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#descModal">Ajouter une autre langue</button>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <!-- <label for="FName">Traduction Description</label> -->
                     <!--  <input type="text" name="DESC_TRADUCTION" autocomplete="off" id="DESC_TRADUCTION" value='<?= htmlentities($questions['DESC_TRADUCTION']) ?>' class="form-control"> -->

                       <textarea readonly name="DESC_TRADUCTION" autocomplete="off" id="DESC_TRADUCTION" class="form-control" ><?= htmlentities($questions['DESC_TRADUCTION']) ?></textarea>

                      <?php echo form_error('DESC_TRADUCTION', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <input type="hidden" name="ICON_QUESTION" value="<?= $questions['ICON'] ?>">


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
                      <label for="FName">Montant</label>
                      <input type="number" name="MONTANT" value="<?= $questions['MONTANT'] ?>" id="MONTANT" class="form-control">

                      <?php echo form_error('MONTANT', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Points</label>
                      <input type="number" name="POURCENTAGE" value="<?= $questions['POURCENTAGE'] ?>" id="POURCENTAGE" class="form-control">

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
                      <input type="text" name="LABEL_REPONSE" value="<?= $questions['LABEL_REPONSE'] ?>" id="FR3" class="form-control">

                      <?php echo form_error('LABEL_REPONSE', '<div class="text-danger">', '</div>'); ?>

                      <br>
                      <div class="col-md-6">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#labelModal">Ajouter une autre langue</button>
                      </div>
                    </div>


                    <div class="col-md-6">
                      <label for="FName"> Traduction de Label Reponse</label>
<!--                       <input type="text" name="LABEL_TRADUCTION" id="LABEL_TRADUCTION" value='<?= $questions['LABEL_TRADUCTION'] ?>' class="form-control"> -->
                        <textarea readonly name="LABEL_TRADUCTION"  id="LABEL_TRADUCTION" class="form-control" ><?= htmlentities($questions['LABEL_TRADUCTION']) ?></textarea>

                      <?php echo form_error('LABEL_TRADUCTION', '<div class="text-danger">', '</div>'); ?>

                    </div>




                    <div class="col-md-6">
                      <label for="FName">Label de description</label>
                      <input type="text" name="DESCR_LABEL" value="<?= $questions['DESCR_LABEL'] ?>" id="FR2" class="form-control">

                      <?php echo form_error('DESCR_LABEL', '<div class="text-danger">', '</div>'); ?>

                      <br>
                      <div class="col-md-6">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#labeldescModal">Ajouter une autre langue</button>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <!-- <label for="FName"> Traduction de Label description</label> -->
                    <!--   <input type="text" name="DESC_LABEL_TRADUCTION" autocomplete="off" id="DESC_LABEL_TRADUCTION" value='<?= $questions['DESC_LABEL_TRADUCTION'] ?>' class="form-control"> -->

                       <textarea readonly name="DESC_LABEL_TRADUCTION"  id="DESC_LABEL_TRADUCTION" class="form-control" ><?= htmlentities($questions['DESC_LABEL_TRADUCTION']) ?></textarea>


                      <?php echo form_error('DESC_LABEL_TRADUCTION', '<div class="text-danger">', '</div>'); ?>

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
                  <?php  if (!empty($questions['ICON'])){  ?>
                   <img width="40px" src="<?= $questions['ICON'] ?>" >
                  <?php }else{ ?>
                     <font style="font-size: 40PX;color: green"><i class="fas fa-image rounded" id="avatar" alt="avatar"></i></font>
                  <?php } ?>
                  <input type="file" class="sr-only" id="PHOTO" name="PHOTO" accept="image/*" >
                 
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

      <div class='modal fade' id='infranctionModal'>
        <div class='modal-dialog'>
          <div class='modal-content'>

            <div class='modal-body'>
              <center>
                <h5><strong>La traduction</strong></h5>
              </center><br>
              <form name='myform' method='post' class='form-horizontal'>

                <div class='form-group'>
                  <div class="col-md-10">
                    <label>Anglais </label>
                    <input id='ENG' type='text' class='form-control' name='ENG' placeholder='Anglais'>
                  </div>
                </div>
                <div class='form-group'>
                  <div class="col-md-10">
                    <label>Kirundi </label>
                    <input id='KIR' type='text' class='form-control' name='KIR' placeholder='Kirundi'>
                  </div>
                </div>
                <div class='form-group'>
                  <div class="col-md-10">
                    <label>Kiswahili</label>
                    <input id='KISW' type='text' max="8" min="8" class='form-control' name='KISW' placeholder='Kiswahili'>
                  </div>
                </div>

                <input type="hidden" name="ID_HISTO_SIGNALEMMENT" id="ID_HISTO_SIGNALEMMENT">

              </form>

            </div>

            <div class='modal-footer'>
              <a class='btn btn-warning btn-md' onclick='saveDonne()'>Enregistrer</a>
              <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
            </div>

          </div>
        </div>
      </div>

      <div class='modal fade' id='descModal'>
        <div class='modal-dialog'>
          <div class='modal-content'>

            <div class='modal-body'>
              <center>
                <h5><strong>La traduction</strong></h5>
              </center><br>
              <form name='myform' method='post' class='form-horizontal'>

                <div class='form-group'>
                  <div class="col-md-10">
                    <label>Anglais </label>
                    <input id='ENG1' type='text' class='form-control' name='ENG' placeholder='Anglais'>
                  </div>
                </div>
                <div class='form-group'>
                  <div class="col-md-10">
                    <label>Kirundi </label>
                    <input id='KIR1' type='text' class='form-control' name='KIR' placeholder='Kirundi'>
                  </div>
                </div>
                <div class='form-group'>
                  <div class="col-md-10">
                    <label>Kiswahili</label>
                    <input id='KISW1' type='text' max="8" min="8" class='form-control' name='KISW' placeholder='Kiswahili'>
                  </div>
                </div>

              </form>

            </div>

            <div class='modal-footer'>
              <a class='btn btn-warning btn-md' onclick='saveDonne1()'>Enregistrer</a>
              <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
            </div>

          </div>
        </div>
      </div>

      <div class='modal fade' id='labeldescModal'>
        <div class='modal-dialog'>
          <div class='modal-content'>

            <div class='modal-body'>
              <center>
                <h5><strong>La traduction</strong></h5>
              </center><br>
              <form name='myform' method='post' class='form-horizontal'>

                <div class='form-group'>
                  <div class="col-md-10">
                    <label>Anglais</label>
                    <input id='ENG2' type='text' class='form-control' name='ENG' placeholder='Anglais'>
                  </div>
                </div>
                <div class='form-group'>
                  <div class="col-md-10">
                    <label>Kirundi </label>
                    <input id='KIR2' type='text' class='form-control' name='KIR' placeholder='Kirundi'>
                  </div>
                </div>
                <div class='form-group'>
                  <div class="col-md-10">
                    <label>Kiswahili</label>
                    <input id='KISW2' type='text' class='form-control' name='KISW' placeholder='Kiswahili'>
                  </div>
                </div>
              </form>

            </div>

            <div class='modal-footer'>
              <a class='btn btn-warning btn-md' onclick='saveDonne2()'>Enregistrer</a>
              <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
            </div>

          </div>
        </div>
      </div>

      <div class='modal fade' id='labelModal'>
        <div class='modal-dialog'>
          <div class='modal-content'>

            <div class='modal-body'>
              <center>
                <h5><strong>La traduction</strong></h5>
              </center><br>
              <form name='myform' method='post' class='form-horizontal'>

                <div class='form-group'>
                  <div class="col-md-10">
                    <label>Anglais </label>
                    <input id='ENG3' type='text' class='form-control' name='ENG' placeholder='Anglais'>
                  </div>
                </div>
                <div class='form-group'>
                  <div class="col-md-10">
                    <label>Kirundi </label>
                    <input id='KIR3' type='text' class='form-control' name='KIR' placeholder='Kirundi'>
                  </div>
                </div>
                <div class='form-group'>
                  <div class="col-md-10">
                    <label>Kiswahili</label>
                    <input id='KISW3' type='text' max="8" min="8" class='form-control' name='KISW' placeholder='Kiswahili'>
                  </div>
                </div>

                <input type="hidden" name="ID_HISTO_SIGNALEMMENT" id="ID_HISTO_SIGNALEMMENT">

              </form>

            </div>

            <div class='modal-footer'>
              <a class='btn btn-warning btn-md' onclick='saveDonne3()'>Enregistrer</a>
              <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
            </div>

          </div>
        </div>
      </div>

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


<script type="text/javascript">
  function saveDonne() {

    var FR = $('#FR').val()
    var ENG = $('#ENG').val()
    var KIR = $('#KIR').val()
    var KISW = $('#KISW').val()

    var form = new FormData();

    form.append("FR", FR)
    form.append("ENG", ENG)
    form.append("KIR", KIR)
    form.append("KISW", KISW)
    $.ajax({
      url: "<?= base_url() ?>PSR/Autres_controles_questionnaires/saveForma",
      type: "POST",
      dataType: "JSON",
      cache: false,
      data: form,
      processData: false,
      contentType: false,
      beforeSend: function() {},
      success: function(data) {
        // alert(data);
        $('#INFRA_TRADUCTION').val(JSON.stringify(data))


        $('#infranctionModal').modal('hide')


      }


    });

  }

  function saveDonne1() {
    // alert()

    var FR1 = $('#FR1').val()
    var ENG = $('#ENG1').val()
    var KIR = $('#KIR1').val()
    var KISW = $('#KISW1').val()

    var form = new FormData();

    form.append("FR", FR1)
    form.append("ENG", ENG)
    form.append("KIR", KIR)
    form.append("KISW", KISW)
    $.ajax({
      url: "<?= base_url() ?>PSR/Autres_controles_questionnaires/saveForma",
      type: "POST",
      dataType: "JSON",
      cache: false,
      data: form,
      processData: false,
      contentType: false,
      beforeSend: function() {},
      success: function(data) {
        // alert(data);

        $('#DESC_TRADUCTION').val(JSON.stringify(data))

        $('#descModal').modal('hide')


      }


    });

  }



  function saveDonne2() {
    // alert()

    var FR2 = $('#FR2').val()
    var ENG = $('#ENG2').val()
    var KIR = $('#KIR2').val()
    var KISW = $('#KISW2').val()

    var form = new FormData();

    form.append("FR", FR2)
    form.append("ENG", ENG)
    form.append("KIR", KIR)
    form.append("KISW", KISW)
    $.ajax({
      url: "<?= base_url() ?>PSR/Autres_controles_questionnaires/saveForma",
      type: "POST",
      dataType: "JSON",
      cache: false,
      data: form,
      processData: false,
      contentType: false,
      beforeSend: function() {},
      success: function(data) {
        // alert(data);

        $('#DESC_LABEL_TRADUCTION').val(JSON.stringify(data))

        $('#labeldescModal').modal('hide')


      }


    });

  }


  function saveDonne3() {
    // alert()

    var FR3 = $('#FR3').val()
    var ENG = $('#ENG3').val()
    var KIR = $('#KIR3').val()
    var KISW = $('#KISW3').val()

    var form = new FormData();

    form.append("FR", FR3)
    form.append("ENG", ENG)
    form.append("KIR", KIR)
    form.append("KISW", KISW)
    $.ajax({
      url: "<?= base_url() ?>PSR/Autres_controles_questionnaires/saveForma",
      type: "POST",
      dataType: "JSON",
      cache: false,
      data: form,
      processData: false,
      contentType: false,
      beforeSend: function() {},
      success: function(data) {
        // alert(data);

        $('#LABEL_TRADUCTION').val(JSON.stringify(data))

        $('#labelModal').modal('hide')


      }


    });

  }
</script>