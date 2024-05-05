<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>



<style type="text/css">
  .mapbox-improve-map {
    display: none;
  }

  .leaflet-control-attribution {
    display: none !important;
  }

  .leaflet-control-attribution {
    display: none !important;
  }


  .mapbox-logo {
    display: none;
  }

  a
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include VIEWPATH . 'templates/navbar.php'; ?>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include VIEWPATH . 'templates/sidebar.php'; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-2">
              <h4 class="m-0"style="color:blue"><?=$title?></h4>
            </div><!-- /.col -->
            <div class="col-sm-8">
              <div class="row">
                      <div class="form-group col-md-6">
                      <label id="Ftype" for="Ftype" style="color:white">Province</label>
                      <select required class="form-control form-control-sm" name="PROVINCE_ID" id="PROVINCE_ID" onchange="onSelected();">
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($provinces as $value) {
                        ?>
                          <option value="<?= $value['PROVINCE_ID'] ?>"><?= $value['PROVINCE_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <!-- <div><font color="red" id="error_province"></font></div>  -->
                      <?php echo form_error('PROVINCE_ID', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="form-group col-md-6">
                      <label id="Ftype" for="Ftype" style="color:white">Commune</label>
                      <select required class="form-control form-control-sm" name="COMMUNE_ID" id="COMMUNE_ID" onchange="onSelected_com();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_commune"></font></div> -->
                      <?php echo form_error('COMMUNE_ID', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    
                    
                    </div>
            </div><!-- /.col -->
            <div class="col-sm-2 text-right">
              <span style="margin-right: 15px">
                <div class="col-sm-3" style="float:right;">
                  <a href="<?=base_url('ihm/Zones/ajouter')?>" style="width: 100px;" class='btn btn-primary btn-sm float-right'>
                    <i class="nav-icon fas fa-plus"></i>
                    Nouveau
                  </a>
                </div>

              </span>

            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->


        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">

          <div class="col-md-12 col-xl-12 grid-margin stretch-card">

            <div class="card">
              <div class="card-body">
                <div class="col-md-12">
                  <?= $this->session->flashdata('message'); ?>

                  <table id='reponse1' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                      <th data-orderable="false">NO</th>
                        <th>ZONE</th>
                        <th>COMMUNE</th>
                        <th>PROVINCE</th>
                        <th>LATITUDE</th>
                        <th>LONGITUDE</th>
                        <th data-orderable="false">OPTIONS</th>


                      </tr>
                    </thead>
                  </table>



                </div>


                <!--  VOS CODE ICI  -->



              </div>
            </div>
          </div>

      </div>

      <!-- Rapport partie -->



      <!-- End Rapport partie -->

    </div>
  </div>
  </div>
  </div>


  </section>


  <!-- /.content -->
  </div>

  </div>
  <!-- ./wrapper -->
  <?php include VIEWPATH . 'templates/footer.php'; ?>
</body>

</html>
<script type="text/javascript">
  $(document).ready(function() {
    liste();

  });
</script>





< <script type="text/javascript">
  function liste()
  {
  $('#message').delay('slow').fadeOut(3000);
  $("#reponse1").DataTable({
  "destroy" : true,
  "processing":true,
  "serverSide":true,
  /* "oreder":[], */
  "order":[[0,'DESC']],
  "ajax":{
  url: "<?php echo base_url('ihm/Zones/listing/'); ?>",
  type:"POST",
  data : {
    PROVINCE_ID: $('#PROVINCE_ID').val(),
    COMMUNE_ID: $('#COMMUNE_ID').val(),

  },
  beforeSend : function() {
  }
  },
  lengthMenu: [[10,50, 100, -1], [10,50, 100, "All"]],
  pageLength: 10,
  "columnDefs":[{
  "targets":[],
  "orderable":false
  }],
  dom: 'Bfrtlip',
  buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
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
  }
  function onSelected()
  {
   liste();
    get_communes();
  }
  function onSelected_com()
  {
    liste();
    /* get_zones(); */
  }
  function get_communes(){
    var PROVINCE_ID = $('#PROVINCE_ID').val();
    if (PROVINCE_ID == '') {
      $('#COMMUNE_ID').html('<option value="">---Sélectionner---</option>');
    }
    else { 
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_communes/" + PROVINCE_ID,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#COMMUNE_ID').html(data);
        }
      });
    }
  }
  </script>