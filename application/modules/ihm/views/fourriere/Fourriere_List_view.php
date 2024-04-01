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
            <div class="col-sm-8">
              <h4 class="m-0"><?= $title ?></h4>
            </div><!-- /.col -->
            <div class="col-sm-4 text-right">
             <span style="margin-right: 15px" class="col-md-12 row">
                     <div class="col-md-7">
                         <select class="form-control input-sm" name="TYPE_FOURRIERE" id="TYPE_FOURRIERE" onchange='onSelected()'>
                          <option value="">Type</option>
                          <?php foreach ($types as $key) { ?>
                            <option value="<?php echo $key['ID_TYPE_FOURR'] ?>"><?php echo  $key['TYPE_FOURRIERE'] ?></option>
                          <?php } ?>
                        </select> 
                      </div>
                      <div class="col-md-2"></div>
                      <div class="col-md-3" style="float:right;">
                        <a href="<?= base_url('ihm/Fourriere/ajouter') ?>" style="width: 100px;" class='btn btn-primary btn-sm float-right'>
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
                  
                  <div class="table-responsive">
                    <table id='reponse1' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                      <thead>
                      <tr>
                        <th>Fourrière</th>
                        <th>Numéro plaque</th>
                        <th>Modèle voiture</th>
                        <th>Marque voiture </th>
                        <th>Type</th>
                        <th>Responsable</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Intervention</th>
                        <th>Active</th>
                        <th>Date</th>
                        <th>Options</th>
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
<!-- <div class="modal fade" id="fourriere">
       <div class="modal-dialog modal-lg" > -->
        <div class="modal fade" id="fourriere" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
       <div class="modal-dialog modal-xl">
         <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <div id="title"><b><h4 id="fourriere_titre" style="color:#fff;font-size: 18px;">Fourrière</h4></b>
              
            </div>
            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
         <div class="modal-body">

          <div class="col-md-12">
                    <div class="table-responsive">
                    <table id='mytable' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        <!-- <th>NO</th> -->
                        <th>Numéro plaque</th>
                        <th>Propriétaire</th>
                        <th>Date prise</th>
                        <th>Date dépôt</th>
                        <th>Lieu prise</th>
                        <th>Images</th>
                        <th>Distance</th>
                        <th>Montant</th>
                      </tr>
                    </thead>
                  </table>
            </div>
      </div>
      <div class="modal-footer"> 
          
      </div>
    </div>
  </div>
  </div>

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





<script type="text/javascript">
  function liste()
  {
  $('#message').delay('slow').fadeOut(3000);
  $("#reponse1").DataTable({
  "destroy" : true,
  "processing":true,
  "serverSide":true,
  "order":[[9,'DESC']],
  "ajax":{
  url: "<?php echo base_url('ihm/Fourriere/listing/'); ?>",
  type:"POST",
  data : { TYPE_FOURRIERE : $('#TYPE_FOURRIERE').val(),},
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
  function supprimer(id,fourriere=null,responsable=null){
    Swal.fire({
      title: 'Souhaitez-vous supprimer  '+responsable+' Fourrière de '+ fourriere+'?',
      showDenyButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>ihm/Fourriere/supprimer/"+id,
          type : "DELETE",
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
  function activer(id,fourriere=null,responsable=null){
    Swal.fire({
      title: 'Souhaitez-vous désactiver  '+responsable+' Fourrière de '+ fourriere+'?',
      showDenyButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>ihm/Fourriere/activer/"+id,
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
 function desactiver(id,fourriere=null,responsable=null){
    Swal.fire({
      title: 'Souhaitez-vous désactiver  '+responsable+' Fourrière de '+ fourriere+'?',
      showDenyButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>ihm/Fourriere/desactiver/"+id,
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
 function getHistorique(id = 0,responsable,fourriere) 
 {
    $('#fourriere').modal()
    $("#fourriere_titre").val("Fourrière "+fourriere+" de "+responsable)
    var row_count ="1000000";
    $("#mytable").DataTable(
    {
        "processing":true,
        "serverSide":true,
        "bDestroy": true,
        "oreder":[],
        "ajax":
        {
        url : "<?=base_url()?>ihm/Fourriere/get_historique/"+id,      
        type:"POST",
        data:
        {
        },
        beforeSend : function() {}
        },
                  lengthMenu: [[10,50, 100, row_count], [10,50, 100, "All"]],
                  pageLength: 10,
                  "columnDefs":[{
                    "targets":[],
                    "orderable":false
                  }],

                  dom: 'Bfrtlip',
                  buttons: [
                  'excel', 'print','pdf'
                  ],
                  language: {
                    "sProcessing":     "Traitement en cours...",
                    "sSearch":         "Rechercher&nbsp;:",
                    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                    "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    "sInfoPostFix":    "",
                    "sLoadingRecords": "Chargement en cours...",
                    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
                    "oPaginate": {
                      "sFirst":      "Premier",
                      "sPrevious":   "Pr&eacute;c&eacute;dent",
                      "sNext":       "Suivant",
                      "sLast":       "Dernier"
                    },
                    "oAria": {
                      "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                      "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                    }
                  }
      });
  }
  function onSelected()
  {
   liste();
  }
  </script>