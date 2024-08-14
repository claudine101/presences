<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>



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
              <h4 class="m-0" style="color:blue"><?=$title?></h4>
            </div><!-- /.col -->
            <div class="col-sm-8">
              <div class="row">
                    <div class="form-group col-md-2">
                          <label style='color:blue'>agences</label>
                          <select class="form-control input-sm" name="ID_AGENCE" id="ID_AGENCE" onchange='liste()'>
                            <option value="">agences</option>
                            <?php foreach ($agences as $key) { ?>
                              <option value="<?php echo $key['ID_AGENCE'] ?>"><?php echo  $key['DESCRIPTION'] ?></option>
                            <?php } ?>
                          </select>
                      </div>
                      <div class="form-group col-md-2">
                        <label style='color:blue'>Date</label>
                        <input onchange='liste()' type="date" name="DATE_PRESENCE" autocomplete="off" id="DATE_PRESENCE" value="<?= set_value('DATE_PRESENCE') ?>" class="form-control">

                    </div>
                    <div class="form-group col-md-2">
                        <label style='color:blue'>Avant  ou  après midi</label>
                        <select class="form-control input-sm" name="avant" id="avant" onchange='liste()'>
                            <option value="">Avant  ou  après midi</option>
                            <option value="AM">Avant  midi </option>
                            <option value="PM">Après midi</option>
                          </select>
                  </div>
                </div>
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
                  <div class="table-responsive">
                   
                  <table id='reponse1' class="table table-bordered table-striped table-hover table-condensed " style="width: 100%;">
                    <thead>
                      <tr>
                      <th data-orderable="false">NO</th>
                        <th>Employes</th>
                        <th>CONTACT</th>
                        <th>AGENCE</th>
                        <th>DATE DE PRESENCE</th>
                        <th>STATUT</th>
                        <th data-orderable="false">OPTIONS</th>
 
                      </tr>
                    </thead>
                  </table>

                  </div>

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
  url: "<?php echo base_url('donnees/Presences/listing/'); ?>",
  type:"POST",
  data : {
  
    avant: $('#avant').val(),
    agence: $('#ID_AGENCE').val(),
    dates: $('#DATE_PRESENCE').val()
    
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
    get_zones();
  }
  function onSelected_zone()
  {
    liste();
  }

  function onSelected_poste()
  {
    liste();
  }
  function onSelected_parti()
  {
    liste();

  }
  function get_communes(){
    var PROVINCE_ID = $('#PROVINCE_ID').val();
    if (PROVINCE_ID == '') {
      $('#COMMUNE_ID').html('<option value="">---Sélectionner---</option>');
      $('#ZONE_ID').html('<option value="">---Sélectionner---</option>');
      $('#COLLINE_ID').html('<option value="">---Sélectionner---</option>');
    }
    else { 
      $('#ZONE_ID').html('<option value="">---Sélectionner---</option>');
      $('#COLLINE_ID').html('<option value="">---Sélectionner---</option>');
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

  function get_zones() {
    var COMMUNE_ID = $('#COMMUNE_ID').val();
    if (COMMUNE_ID == '') {
      $('#ZONE_ID').html('<option value="">---Sélectionner---</option>');
      $('#COLLINE_ID').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#COLLINE_ID').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_zones/" + COMMUNE_ID,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ZONE_ID').html(data);
        }
      });

    }
  }
  </script>
  <script type="text/javascript">
    function get_rapport() {
      myform.submit()
    }
    function activer(id,nom=null,prenom=null){
    Swal.fire({
      title: 'Souhaitez-vous activer  '+nom,
      showDenyButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>donnees/Presences/activer/"+id,
          type : "PUT",
          dataType: "JSON",
          cache:false,
          data: {},
          beforeSend:function () { 
          },
          success:function(data) {
            console.log(data);
            liste()
            Swal.fire('Confirmé!', '', 'success')
          },
          error:function() {
            Swal.fire('Erreur de la connexion', '', 'info')
          }
      });

        
      } else if (result.isDenied) {
        Swal.fire('Non Confirmé', '', 'info')
      }
    })


    //Fin ajax

 }

 function desactiver(id,nom=null,prenom=null){
    Swal.fire({
      title: 'Souhaitez-vous désactiver  '+nom,
      showDenyButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>donnees/Presences/desactiver/"+id,
          type : "PUT",
          dataType: "JSON",
          cache:false,
          data: {},
          beforeSend:function () { 
          },
          success:function(data) {
            console.log(data);
            liste()
            Swal.fire('Confirmé!', '', 'success')
          },
          error:function() {
            Swal.fire('Erreur de la connexion', '', 'info')
          }
      });

        
      } else if (result.isDenied) {
        Swal.fire('Non Confirmé', '', 'info')
      }
    })


    //Fin ajax

 }
  </script>