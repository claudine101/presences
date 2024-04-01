<?php
      $json = json_decode('{"FR":"","ENG":"","KIR":"","KISW":""}');
      $varIfra = !empty($data['PEINES_TRADUCTION']) ? json_decode($data['PEINES_TRADUCTION']) : $json;
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

                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Infra_peines/update'); ?>">
                  <div class="row">


                    <input type="hidden" class="form-control" name="ID_INFRA_PEINE" value="<?= $data['ID_INFRA_PEINE'] ?>">

                    <div class="col-md-12">
                      <label for="Ftype">Infractions</label>
                      <select class="form-control" name="ID_INFRA_INFRACTION" id="ID_INFRA_INFRACTION">

                        <?php

                        foreach ($infraPeines as $value) {

                          $selected = "";
                          if ($value['ID_INFRA_INFRACTION'] == $data['ID_INFRA_INFRACTION']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['ID_INFRA_INFRACTION'] ?>" <?= $selected ?>><?= $value['NIVEAU_ALERTE'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('ID_INFRA_INFRACTION', '<div class="text-danger">', '</div>'); ?>

                    </div>

                   
                    <div class="col-md-6">
                      <label for="FR">Piène</label>
                      <textarea name="AMENDES"  id="FR"  class="form-control"><?= htmlentities($data['AMENDES']) ?></textarea>
                      <?php echo form_error('AMENDES', '<div class="text-danger">', '</div>'); ?>
                    
                    </div>



                    <div class="col-md-1">
                        <label for="FR" style="color:#fff">...</label>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#langueModal" style="margin-top: 30px;">langue</button>
                      </div>


                    <div class="col-md-5">
                      <label for="PEINES_TRADUCTION" style="">Autre langue</label>
                      <textarea name="PEINES_TRADUCTION" readonly id="PEINES_TRADUCTION"  class="form-control"><?= htmlentities($data['PEINES_TRADUCTION']) ?></textarea>
                      <?php echo form_error('PEINES_TRADUCTION', '<div class="text-danger">', '</div>'); ?>

                    </div>

                    <div class="col-md-2">
                      <label for="FName">Contravention</label>
                      <input type="number" name="MONTANT" autocomplete="off" id="MONTANT" value="<?= $data['MONTANT'] ?>" class="form-control">

                      <?php echo form_error('MONTANT', '<div class="text-danger">', '</div>'); ?>

                    </div>


                    <div class="col-md-4">
                      <label for="FName">Points</label>
                      <input type="number" name="POINTS" autocomplete="off" id="POINTS" value="<?= $data['POINTS'] ?>" class="form-control">

                      <?php echo form_error('POINTS', '<div class="text-danger">', '</div>'); ?>

                    </div>


                    <div class="col-md-6">

                      <label for="FName">Appeler la fourrière ?</label><br>

                      
                      <div class="form-check form-check-inline">
                        <input <?php if ($data['APPEL_FOURRIERE'] == 1) { echo "checked"; }   ?> class="form-check-input" type="radio" name="APPEL_FOURRIERE" id="APPEL_FOURRIERE1" value="1">
                        <label class="form-check-label" for="APPEL_FOURRIERE1">Oui</label>
                      </div>


                      <div class="form-check form-check-inline">
                        <input <?php if ($data['APPEL_FOURRIERE'] == 0) { echo "checked"; }   ?>  class="form-check-input" type="radio" name="APPEL_FOURRIERE" id="APPEL_FOURRIERE2" value="0">
                        <label class="form-check-label" for="APPEL_FOURRIERE2">Non</label>
                      </div>

                    </div>

                  



                  <div class="col-md-12" style="margin-top:31px;">
                    <button type="submit" style="float: left;" class="btn btn-primary"><span class="fas fa-save"></span> Modifier</button>
                  </div>




                  </div>

                </form>

              </div>
            </div>
          </div>
        </div>
      </section>
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
  </div>
</body>

<?php include VIEWPATH . 'templates/footer.php'; ?>



<script type="text/javascript">
  function saveDonne() {
    // alert()

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
        $('#PEINES_TRADUCTION').val(JSON.stringify(data))

        $('#langueModal').modal('hide')


      }


    });

  }
</script>