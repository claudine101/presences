<?php
      $json = json_decode('{"FR":"","ENG":"","KIR":"","KISW":""}');
      $varIfra = !empty($infra['INFRACTION_TRADUCTION']) ? json_decode($infra['INFRACTION_TRADUCTION']) : $json;
 ?>
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
              <a href="<?= base_url('PSR/Infra_infractions/index') ?>" class='btn btn-primary float-right'>
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
                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Infra_infractions/update'); ?>">

                  <div class="row">
                    <input type="hidden" class="form-control" name="ID_INFRA_INFRACTION" value="<?= $infra['ID_INFRA_INFRACTION']; ?>">

                    <div class="col-md-3">
                      <label for="Ftype">Vérification</label>
                      <select class="form-control" name="ID_TYPE_VERIFICATION" id="ID_TYPE_VERIFICATION">

                        <?php

                        foreach ($verifications as $value) {

                          $selected = "";
                          if ($value['ID_TYPE_VERIFICATION'] == $infra['ID_TYPE_VERIFICATION']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['ID_TYPE_VERIFICATION'] ?>" <?= $selected ?>><?= $value['VERIFICATION'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('ID_QUESTIONNAIRE_CATEGORIES', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-9">
                      <div class="row">
                        <div class="col-md-4">
                          <label for="FName">Niveau  alerte</label>
                           <!-- <textarea  name="NIVEAU_ALERTE" autocomplete="off" id="NIVEAU_ALERTE" value="<?= set_value('NIVEAU_ALERTE') ?>" class="form-control">  </textarea> -->
                           <input type="text" name="NIVEAU_ALERTE" value="<?= $infra['NIVEAU_ALERTE']; ?>" id="FR" class="form-control">

                          <?php echo form_error('NIVEAU_ALERTE', '<div class="text-danger">', '</div>'); ?>
                        </div>
                        <div class="col-md-2">
                          <button type="button" style="margin-top:25px" class="btn btn-secondary" data-toggle="modal" data-target="#langueModal">langue</button>
                        </div>

                        <div class="col-md-6">
                          <label for="FName"></label>
                            <textarea readonly name="INFRACTION_TRADUCTION"  id="INFRACTION_TRADUCTION" class="form-control" ><?= htmlentities($infra['INFRACTION_TRADUCTION'])  ?></textarea>
                          <?php echo form_error('INFRACTION_TRADUCTION', '<div class="text-danger">', '</div>'); ?>

                        </div>
                      </div>
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


    <div class='modal fade' id='langueModal'>
      <div class='modal-dialog'>
        <div class='modal-content'>

          <div class='modal-body'>
            <center>
              <h5><strong>Traduction</strong></h5>
            </center><br>
            <form name='myform' method='post' class='form-horizontal'>
              <div class='form-group'>
                <div class="col-md-10">
                  <label>Anglais </label>
                  <input id='ENG'  type='text'  value="<?php echo $varIfra->ENG; ?>" class='form-control' name='ENG' placeholder='Anglais'>
                </div>
              </div>
              <div class='form-group'>
                <div class="col-md-10">
                  <label>Kirundi </label>
                  <input id='KIR' type='text' value="<?php echo $varIfra->KIR; ?>" class='form-control' name='KIR' placeholder='Kirundi'>
                </div>
              </div>
              <div class='form-group'>
                <div class="col-md-10">
                  <label>Kiswahili</label>
                  <input id='KISW' type='text' value="<?php echo $varIfra->KISW; ?>" max="8" min="8" class='form-control' name='KISW' placeholder='Kiswahili'>
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
      url: "<?= base_url() ?>PSR/Infra_infractions/saveForma",
      type: "POST",
      dataType: "JSON",
      cache: false,
      data: form,
      processData: false,
      contentType: false,
      beforeSend: function() {},
      success: function(data) {
        // alert(data);
        $('#INFRACTION_TRADUCTION').val(JSON.stringify(data))
        $('#langueModal').modal('hide')
      }

    });

  }
</script>