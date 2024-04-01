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
            <div class="col-sm-10">
              <h4 class="m-0"><?= $title ?></h4>
            </div><!-- /.col -->

            <div class="col-md-2">
              <label>Date</label><br>
              <select class="form-control input-sm" name="date" id="date" onchange='liste()'>
                <option value="">Sélectionner</option>
                <?php foreach ($historique as $key) { ?>
                  <option value="<?php echo $key['date'] ?>"><?php echo  $key['date'] ?></option>
                <?php } ?>
              </select>

            </div>

          </div><!-- /.row -->
        </div><!-- /.container-fluid -->


        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">

          <div class="col-md-12 col-xl-12 grid-margin stretch-card">

            <div class="card">

              <div class="card-body">



                <div class="col-md-12 ">
                  <?= $this->session->flashdata('message'); ?>

                  <div class="table-responsive">  <table id='reponse1' class="table table-bordered  table-striped table-hover table-condensed">
                      <thead>
                        <tr>
                          <th>Agent</th>
                          <th>Date de fait</th>
                          <th>Type</th>
                          <th>Annulé</th>
                          <th>Plaque</th>
                          <th>Permis</th>
                          <th>Amende BIF</th>
                          <th>Statut</th>
                          <th>Actions</th>
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




  <!-- MODAL POUR LE DETAIL -->
<div class="modal fade" id="detailControl">
 <div class="modal-dialog modal-lg" >
   <div class="modal-content">
     <div class="modal-header" style="background: black;">
      <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;">Détails</h4></b></div>

      <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </div>
   </div>
   <div class="modal-body" id="donneDeatail">
    
  
   
  </div>
  <div class="modal-footer"> 
   <!--  <button id="btn_quiter" type="button" class="btn btn-primary" class='close' data-dismiss='modal'>Quitter</button> -->
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



   function getDetailControl(id = 0) {


      $('#detailControl').modal()



        $.ajax({
          url : "<?=base_url()?>PSR/Historique/gethistoControl/"+id,
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {ID:id},
          beforeSend:function () { 
            $('#donneDeatail').html("");
          },
          success:function(data) {
           $('#donneDeatail').html(data.views_detail);
           $('#donneTitre').html(data.titres);
          
          },
          error:function() {
            $('#donneDeatail').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher cette page! Veuillez réessayer</div>');
          }
      });
      
    }

</script>





<script type="text/javascript">
  function liste()
  {
  $('#message').delay('slow').fadeOut(3000);
  $("#reponse1").DataTable({
  "destroy" : true,
  "processing":true,
  "serverSide":true,
  "oreder":[],
  "ajax":{
  url: "<?php echo base_url('PSR/Historique/listing/'); ?>",
  type:"POST",
  data : {
  date : $('#date').val(),
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
  </script>