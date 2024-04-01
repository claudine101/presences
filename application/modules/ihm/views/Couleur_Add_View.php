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
              <a href="<?= base_url('ihm/Couleur/index') ?>" class='btn btn-primary float-right'>
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

                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Couleur/add'); ?>">


                  <div class="row">
                    <div class="col-md-6">
                      <label for="FName">COULEUR</label>
                      <input type="text" name="COULEUR" autocomplete="off" id="FR" value="<?= set_value('COULEUR') ?>" class="form-control">

                      <?php echo form_error('COULEUR', '<div class="text-danger">', '</div>'); ?>
                      <br>
                      <div class="col-md-6">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#CouleurModal">Ajouter une autre langue</button>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <label for="FName"></label>
                      <input type="hidden" name="COULEUR_TRADUCTION" autocomplete="off" id="COULEUR_TRADUCTION" class="form-control">

                      <?php echo form_error('COULEUR_TRADUCTION', '<div class="text-danger">', '</div>'); ?>

                    </div>



                  </div <div class="col-md-6" style="margin-top:31px;">
                  <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
              </div>
              </form>
            </div>


          </div>
        </div>
    </div>
  </div>
  </section>
  </div>
  </div>


  <!-- Couleur modal -->

  <div class='modal fade' id='CouleurModal'>
    <div class='modal-dialog'>
      <div class='modal-content'>

        <div class='modal-body'>
          <center>
            <h5><strong>Choississez la langue ?</strong></h5>
          </center><br>
          <form name='myform' method='post' class='form-horizontal'>

            <div class='form-group'>
              <div class="col-md-10">
                <label>Anglais</label>
                <input id='ENG' type='text' class='form-control' name='ENG' placeholder='Entrez Anglais'>
              </div>
            </div>

            <div class='form-group'>
              <div class="col-md-10">
                <label>Kirundi</label>
                <input id='KIR' type='text' class='form-control' name='KIR' placeholder='Entrez Kirundi'>
              </div>
            </div>

            <div class='form-group'>
              <div class="col-md-10">
                <label>Kiswahili</label>
                <input id='KISW' type='text' class='form-control' name='KISW' placeholder='Entrez Kirundi'>
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

  <?php include VIEWPATH . 'templates/footer.php'; ?>

</body>

</html>


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
      url: "<?= base_url() ?>ihm/Couleur/saveForma",
      type: "POST",
      dataType: "JSON",
      cache: false,
      data: form,
      processData: false,
      contentType: false,
      beforeSend: function() {},
      success: function(data) {

        $('#COULEUR_TRADUCTION').val(JSON.stringify(data))
        $('#CouleurModal').modal('hide')
      }

    });

  }
</script>