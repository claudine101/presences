<!doctype html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- navbar -->
    <?php include VIEWPATH . 'templates/navbar.php'; ?>
    <!-- main sidebar container -->
    <?php include VIEWPATH . 'templates/sidebar.php'; ?>
    <!-- content wrapper. contains page content -->
    <div class="content-wrapper">
      <!-- content header (page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-9">

              <h4 class="m-0"><?= $title ?></h4>
            </div><!-- /.col -->
            <div class="col-sm-3">
              <a href="<?= base_url('ihm/chaussee/index') ?>" class='btn btn-primary float-right'>
                <i class="nav-icon fas fa-list ul"></i>
                liste
              </a>
            </div><!-- /.col -->
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- main content -->
      <section class="content">
        <div class="col-md-12 col-xl-12 grid-margin stretch-card">

          <div class="card">
            <div class="card-body">

              <div class="col-md-12">

                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/chaussee/update'); ?>">

                  <div class="row">
                    <div class="col-md-6">

                      <input type="hidden" class="form-control" name="ID_CHAUSSEE" value="<?= $data['ID_CHAUSSEE'] ?>">
                      <label for="fname">chaussée</label>
                      <input type="text" name="NOM_CHAUSSE" value="<?= $data['NOM_CHAUSSE'] ?>" id="FR" class="form-control">

                      <?php echo form_error('NOM_CHAUSSE', '<div class="text-danger">', '</div>'); ?>
                      <br>
                      <div class="col-md-6">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#PaiementModal">ajouter une autre langue</button>
                      </div>
                    </div>


                    <div class="col-md-6">
                      <label for="FName"></label>
                      <input type="hidden" name="QUESTIONNAIRE_TRADUCTION" id="QUESTIONNAIRE_TRADUCTION" class="form-control">

                      <?php echo form_error('QUESTIONNAIRE_TRADUCTION', '<div class="text-danger">', '</div>'); ?>

                    </div>


                  </div>
                  <div class="col-md-6" style="margin-top:31px;">
                    <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> modifier</button>

                  </div>
              </div>

            </div>
          </div>

          </form>

          <div class='modal fade' id='PaiementModal'>
            <div class='modal-dialog'>
              <div class='modal-content'>

                <div class='modal-body'>
                  <center>
                    <h5><strong>Traduction</strong></h5>
                  </center><br>
                  <form name='myform' method='post' class='form-horizontal'>

                    <div class='form-group'>
                      <div class="col-md-10">
                        <label>Anglais</label>
                        <input id='ENG' type='text' class='form-control' name='ENG'>
                      </div>
                    </div>

                    <div class='form-group'>
                      <div class="col-md-10">
                        <label>Kirundi</label>
                        <input id='KIR' type='text' class='form-control' name='KIR'>
                      </div>
                    </div>

                    <div class='form-group'>
                      <div class="col-md-10">
                        <label>Kiswahili</label>
                        <input id='KISW' type='text' class='form-control' name='KISW'>
                      </div>
                    </div>
                  </form>

                </div>

                <div class='modal-footer'>
                  <a class='btn btn-warning btn-md' onclick='saveDonne()'>Confirmer</a>
                  <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
                </div>



              </div>
            </div>
          </div>



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
      url: "<?= base_url() ?>ihm/Chaussee/saveForma",
      type: "POST",
      dataType: "JSON",
      cache: false,
      data: form,
      processData: false,
      contentType: false,
      beforeSend: function() {},
      success: function(data) {

        $('#QUESTIONNAIRE_TRADUCTION').val(JSON.stringify(data))
        $('#PaiementModal').modal('hide')
      }

    });

  }
</script>