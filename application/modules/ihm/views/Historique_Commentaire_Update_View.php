
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
              <a href="<?= base_url('ihm/Historique_Commentaire/index') ?>" class='btn btn-primary float-right'>
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

                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Historique_Commentaire/update'); ?>">

                  <div class="row">
                    <div class="col-md-2">
                    <label for="Ftype">Type Vérification</label>
                   
                    <select class="form-control" data-live-search="true"  name="ID_TYPE_VERIFICATION" >
                     <?php 
                     foreach($veriff as $key_marque) { 
                       $selected = "";
                       if ($key_marque['ID_TYPE_VERIFICATION'] == $data['ID_TYPE_VERIFICATION']) {
                        $selected = "selected";
                      }
                      ?>
                      <option value="<?= $key_marque['ID_TYPE_VERIFICATION'] ?>" <?= $selected ?>><?= $key_marque['VERIFICATION'] ?></option>
                      <?php
                    }
                    ?>
                  </select>


                  <?php echo form_error('ID_TYPE_VERIFICATION', '<div class="text-danger">', '</div>'); ?>
                  
                </div>
                    <div class="col-md-4">

                      <input type="hidden" class="form-control" name="COMMENTAIRE_ID" value="<?= $data['COMMENTAIRE_ID'] ?>">
                      <label for="FName">Commentaire</label>
                      <input type="text" name="COMMENTAIRE_TEXT" value="<?= $data['COMMENTAIRE_TEXT'] ?>" id="FR" class="form-control">

                      <?php echo form_error('COMMENTAIRE_TEXT', '<div class="text-danger">', '</div>'); ?>

                    
                     
                    </div>

                    <div class="col-md-2">
                    <label for="FName" style="color:#fff">.</label><br>
                     <!--  <div class="col-md-2"> -->
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#HistoriQuemodal">langue</button>
                      <!-- </div> -->
                    </div>

                    <div class="col-md-4">
                      <label for="FName"></label>
                      <textarea readonly name="COMMENTAIRE_TEXT_TRADUCTION" autocomplete="off" id="COMMENTAIRE_TEXT_TRADUCTION" class="form-control" value="<?= set_value('COMMENTAIRE_TEXT_TRADUCTION') ?>"><?= htmlentities($data['COMMENTAIRE_TEXT_TRADUCTION']) ?></textarea>
                      
                      <?php echo form_error('COMMENTAIRE_TEXT_TRADUCTION', '<div class="text-danger">', '</div>'); ?>
                    </div>




                   

                  </div>
                  <div class="col-md-12" style="margin-top:31px;">
                    <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Modifier</button>

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


<?php 

if (!empty($data['COMMENTAIRE_TEXT_TRADUCTION'])) {
 $donne = json_decode($data['COMMENTAIRE_TEXT_TRADUCTION']);
}else{
 $donnes = '{"FR":"","ENG":"","KIR":"","":""}';
 $donne = json_decode($donnes);
}

?>

  <div class='modal fade' id='HistoriQuemodal'>
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
                <input id='ENG' type='text' class='form-control' name='ENG' placeholder='Entrez Anglais' value="<?=$donne->ENG?>">
              </div>
            </div>

            <div class='form-group'>
              <div class="col-md-10">
                <label>Kirundi</label>
                <input id='KIR' type='text' class='form-control' name='KIR' placeholder='Entrez Kirundi' value="<?=$donne->KIR?>">
              </div>
            </div>

            <div class='form-group'>
              <div class="col-md-10">
                <label>Kiswahili</label>
                <input id='KISW' type='text' class='form-control' name='KISW' placeholder='Entrez Kirundi' value="<?=$donne->KISW?>">
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
      url: "<?= base_url() ?>ihm/Historique_Commentaire/saveForma",
      type: "POST",
      dataType: "JSON",
      cache: false,
      data: form,
      processData: false,
      contentType: false,
      beforeSend: function() {},
      success: function(data) {

        $('#COMMENTAIRE_TEXT_TRADUCTION').val(JSON.stringify(data))
        $('#HistoriQuemodal').modal('hide')
      }

    });

  }
</script>