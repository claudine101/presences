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
                    <div class="col-md-12">
                      <div class="row">

                          <div class="col-md-4">
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

                          <div class="col-md-8"></div>


                        <div class="col-md-4">
                          <label for="FName">Infranctions</label>

                          <textarea  name="INFRACTION" required autocomplete="off" id="FR" value="<?= set_value('INFRACTION') ?>" class="form-control"></textarea>


                          <?php echo form_error('INFRACTION', '<div class="text-danger">', '</div>'); ?>
                        </div>
                        <div class="col-md-2">
                          <button type="button" style="margin-top:25px" class="btn btn-secondary" data-toggle="modal" data-target="#infranctionModal">langue</button>
                        </div>

                        <div class="col-md-6">
                          <label for="FName"></label>
                          <textarea readonly name="INFRA_TRADUCTION" required autocomplete="off" id="INFRA_TRADUCTION" value="<?= set_value('INFRA_TRADUCTION') ?>" class="form-control"></textarea>

                          <?php echo form_error('INFRA_TRADUCTION', '<div class="text-danger">', '</div>'); ?>

                        </div>
                      </div>
                    </div>


                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-4">
                          <label for="FName">Description ou référence</label>
                          <input type="text" name="DESCRIPTION" autocomplete="off" id="FR1" value="<?= set_value('DESCRIPTION') ?>" class="form-control">
                          <?php echo form_error('DESCRIPTION', '<div class="text-danger" >', '</div>'); ?>
                        </div>
                        <div class="col-md-2">
                          <button type="button" style="margin-top:25px" class="btn btn-secondary" data-toggle="modal" data-target="#descModal">langue</button>
                        </div>
                        <div class="col-md-6">
                          <label for="FName"></label>
                          <textarea readonly name="DESC_TRADUCTION" required  id="DESC_TRADUCTION" value="<?= set_value('DESC_TRADUCTION') ?>" class="form-control"></textarea>

                          <?php echo form_error('DESC_TRADUCTION', '<div class="text-danger">', '</div>'); ?>

                        </div>
                      </div>

                    </div>



                    <div class="col-md-2">
                      <label for="FName">Amendes (en FBU)</label>
                      <input type="number" name="MONTANT" autocomplete="off" id="MONTANT" value="<?= set_value('MONTANT') ?>" class="form-control">

                      <?php echo form_error('MONTANT', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-2">
                      <label for="FName">Points</label>
                      <input type="number" name="POURCENTAGE" autocomplete="off" id="POURCENTAGE" value="<?= set_value('POURCENTAGE') ?>" class="form-control">
                      <?php echo form_error('POURCENTAGE', '<div class="text-danger">', '</div>'); ?>

                    </div>
                   

                    <div class="col-md-2">

                      <label for="maniere">Manière détaillée</label>
                      <select class="form-control" name="MANIERE_REPONSE">
                        <option value="null">Pas Besoin</option>
                        <option value="2">Selection</option>
                        <option value="1">Text</option>
                      </select>
                    </div>
                    </br>
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-4">
                          <label for="FName">Label du détail</label>
                          <input type="text" name="LABEL_REPONSE" autocomplete="off" id="FR3" value="<?= set_value('LABEL_REPONSE') ?>" class="form-control">

                          <?php echo form_error('LABEL_REPONSE', '<div class="text-danger">', '</div>'); ?>
                        </div>
                        <div class="col-md-2">
                          <button type="button" style="margin-top:25px" class="btn btn-secondary" data-toggle="modal" data-target="#labelModal">langue</button>
                        </div>
                        <div class="col-md-6">
                          <label></label>
                          <textarea readonly  required name="LABEL_TRADUCTION" autocomplete="off" id="LABEL_TRADUCTION" value="<?= set_value('LABEL_TRADUCTION') ?>" class="form-control"></textarea>
                          <?php echo form_error('LABEL_TRADUCTION', '<div class="text-danger">', '</div>'); ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-4">
                          <label for="FName">Label du commentaire</label>
                          <input type="text" name="DESCR_LABEL" autocomplete="off" id="FR2" value="<?= set_value('DESCR_LABEL') ?>" class="form-control">
                          <?php echo form_error('DESCR_LABEL', '<div class="text-danger">', '</div>'); ?>
                        </div>
                        <div class="col-md-2">
                          <button type="button" style="margin-top:25px" class="btn btn-secondary" data-toggle="modal" data-target="#labeldescModal"> langue</button>
                        </div>
                        <div class="col-md-6">
                          <label></label>
                          <textarea readonly name="DESC_LABEL_TRADUCTION" autocomplete="off" id="DESC_LABEL_TRADUCTION" value="<?= set_value('DESC_LABEL_TRADUCTION') ?>" class="form-control"></textarea>
                          <?php echo form_error('DESC_LABEL_TRADUCTION', '<div class="text-danger">', '</div>'); ?>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-2">
                      <br>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="NEED_IDENTITE" value="0" id="NEED_IDENTITE">
                        <label class="form-check-label" for="NEED_IDENTITE">
                          Besoin d'identité
                        </label>
                      </div>
                    </div>

                    <div class="col-md-2">
                      <br>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="NEED_IMAGE" value="0" id="NEED_IMAGE">
                        <label class="form-check-label" for="NEED_IMAGE">
                          Besoin d'Image
                        </label>
                      </div>
                    </div>


                     <div class="col-md-2">

                      <label for="FName">Appeler la fourrière ?</label><br>

                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="APPEL_FOURRIERE_QUESTION" id="APPEL_FOURRIERE1" value="1">
                        <label class="form-check-label" for="APPEL_FOURRIERE1">Oui</label>
                      </div>


                      <div class="form-check form-check-inline">
                        <input checked class="form-check-input" type="radio" name="APPEL_FOURRIERE_QUESTION" id="APPEL_FOURRIERE2" value="0">
                        <label class="form-check-label" for="APPEL_FOURRIERE2">Non</label>
                      </div>

                    </div>


                    <div class="col-md-6 row">
                      <div class="col-md-6">
                        <label for="text" style="font-size: 15px;" id="fileName">Icon</label></BR>
                        <label class="label" data-toggle="tooltip" title="Attacher un fichier" style="margin-top:-15px">
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
              <h5><strong>Traduction d'infranction</strong></h5>
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
              <h5><strong>Traduction de la description</strong></h5>
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
                  <input id='KISW1' type='text' class='form-control' name='KISW' placeholder='Kiswahili'>
                </div>
              </div>

              <input type="hidden" name="ID_HISTO_SIGNALEMMENT" id="ID_HISTO_SIGNALEMMENT">

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
              <h5><strong>Traduction du label de commentaire</strong></h5>
            </center><br>
            <form name='myform' method='post' class='form-horizontal'>

              <div class='form-group'>
                <div class="col-md-10">
                  <label>Anglais </label>
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
                  <input id='KISW2' type='text' max="8" min="8" class='form-control' name='KISW' placeholder='Kiswahili'>
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
              <h5><strong>Traduction de label détail</strong></h5>
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
    //  alert()

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

    var FR = $('#FR1').val()
    var ENG = $('#ENG1').val()
    var KIR = $('#KIR1').val()
    var KISW = $('#KISW1').val()

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

        $('#DESC_TRADUCTION').val(JSON.stringify(data))

        $('#descModal').modal('hide')


      }


    });

  }



  function saveDonne2() {
    // alert()

    var FR = $('#FR2').val()
    var ENG = $('#ENG2').val()
    var KIR = $('#KIR2').val()
    var KISW = $('#KISW2').val()

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

        $('#DESC_LABEL_TRADUCTION').val(JSON.stringify(data))

        $('#labeldescModal').modal('hide')


      }


    });

  }


  function saveDonne3() {
    // alert()

    var FR = $('#FR3').val()
    var ENG = $('#ENG3').val()
    var KIR = $('#KIR3').val()
    var KISW = $('#KISW3').val()

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

        $('#LABEL_TRADUCTION').val(JSON.stringify(data))

        $('#labelModal').modal('hide')


      }


    });

  }
</script>