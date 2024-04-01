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
            </div>
          </div>
        </div>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="col-md-12 col-xl-12 grid-margin stretch-card">

          <div class="card">
            <div class="card-body">
              <div class="col-md-12">
                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/DetailLabel/add'); ?>">
                  <div class="row">
                    <input type="hidden" class="form-control" name="ID_REPONSE" value="<?= $label['ID_CONTROLES_QUESTIONNAIRES'] ?>">

                    <div class="col-md-4">
                      <label for="FName"><?= $label['LABEL_REPONSE'] ?></label>
                      <input type="text" name="LABEL_REPONSE" autocomplete="off" id="FR" value="<?= set_value('LABEL_REPONSE') ?>" class="form-control" required>

                      <?php echo form_error('LABEL_REPONSE', '<div class="text-danger">', '</div>'); ?>
                    </div>


                    <div class="col-md-2" style="margin-top:31px;">
                      <button type="button" class="btn btn-secondary input-sm" data-toggle="modal" data-target="#labeldescModal">langue</button>
                    </div>


                    <div class="col-md-4">
                      <label for="FName">JSON</label>
                     <!--  <input required type="text" name="REPONSE_DECRP_TRADUCTION" autocomplete="off" id="REPONSE_DECRP_TRADUCTION" value='' class="form-control" required> -->
                      <textarea name="REPONSE_DECRP_TRADUCTION" readonly id="REPONSE_DECRP_TRADUCTION" value='' class="form-control" required></textarea>
                    </div>

                    <div class="col-md-2" style="margin-top:31px;">
                      <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
                    </div>
                  </div>
                </form>
              </div>

              <br>


              <div class="col-md-12">
                <?= $this->session->flashdata('message'); ?>

                <table id='reponse1' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                  <thead>
                    <tr>
                      <td>Reponse</td>
                      <td>OPTIONS</td>

                    </tr>
                  </thead>
                </table>
              </div>

            </div>
      </section>
    </div>
  </div>
</body>




<div class='modal fade' id='labeldescModal'>
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
        <a class='btn btn-warning btn-md' onclick='saveDonne2()'>Enregistrer</a>
        <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

    </div>
  </div>
</div>

<?php include VIEWPATH . 'templates/footer.php'; ?>


<script type="text/javascript">
  function saveDonne2() {
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

        $('#REPONSE_DECRP_TRADUCTION').val(JSON.stringify(data))

        $('#labeldescModal').modal('hide')


      }


    });

  }
</script>

<script type="text/javascript">
  $('#message').delay('slow').fadeOut(3000);
  $("#reponse1").DataTable({
    "destroy": true,
    "processing": true,
    "serverSide": true,
    "oreder": [],
    "ajax": {
      url: "<?php echo base_url('ihm/DetailLabel/listing/') . $this->uri->segment(4) ?>",
      type: "GET",
      beforeSend: function() {}
    },
    lengthMenu: [
      [10, 50, 100],
      [10, 50, 100, "All"]
    ],
    pageLength: 10,
    "columnDefs": [{
      "targets": [],
      "orderable": false
    }],
    dom: 'Bfrtlip',
    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    language: {
      "sProcessing": "Traitement en cours...",
      "sSearch": "Rechercher&nbsp;:",
      "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
      "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      "sInfoPostFix": "",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
      "oPaginate": {
        "sFirst": "Premier",
        "sPrevious": "Pr&eacute;c&eacute;dent",
        "sNext": "Suivant",
        "sLast": "Dernier"
      },
      "oAria": {
        "sSortAscending": ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
      }
    }
  });
</script>