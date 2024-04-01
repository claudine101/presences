<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php'; ?>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>



<style type="text/css">
.mapbox-improve-map{
  display: none;
}
#Ftype{
    color: White;
  }
.leaflet-control-attribution{
  display: none !important;
}
.leaflet-control-attribution{
  display: none !important;
}


.mapbox-logo {
  display: none;
  }a
</style>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include VIEWPATH.'templates/navbar.php'; ?>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include VIEWPATH.'templates/sidebar.php'; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-2">
              <h4 class="m-0"><?=$title?></h4>
            </div><!-- /.col -->
            <div class="col-sm-8">
              <div class="row">
                      <div class="form-group col-md-3">
                      <label id="Ftype" for="Ftype">Province</label>
                      <select required class="form-control form-control-sm" name="ID_PROVINCE" id="ID_PROVINCE" onchange="onSelected();">
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
                      <?php echo form_error('ID_PROVINCE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="form-group col-md-3">
                      <label id="Ftype" for="Ftype">Commune</label>
                      <select required class="form-control form-control-sm" name="ID_COMMUNE" id="ID_COMMUNE" onchange="onSelected_com();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_commune"></font></div> -->
                      <?php echo form_error('ID_COMMUNE', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-3">
                      <label id="Ftype" for="Ftype">Zone</label>
                      <select class="form-control form-control-sm" name="ID_ZONE" id="ID_ZONE" onchange="onSelected_zon();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_zone"></font></div> -->
                      <?php echo form_error('ID_ZONE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="form-group col-md-3">
                      <label id="Ftype" for="Ftype">Colline</label>
                      <select class="form-control form-control-sm" name="ID_COLLINE" id="ID_COLLINE" onchange="onSelected_coll();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_colline"></font></div> -->
                      <?php echo form_error(' ID_COLLINE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    </div>
            </div><!-- /.col -->
            <div class="col-sm-2 text-right">
              <span style="margin-right: 15px">
                <div class="col-sm-3" style="float:right;">
                  <a href="<?=base_url('menage/Chefs_menage/ajouter')?>" style="width: 100px;" class='btn btn-primary btn-sm float-right'>
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
                  <?=  $this->session->flashdata('message');?>

                  <div class="table-responsive">
                    
                    <table id='reponse1' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                      
                        <th>Agent</th>
                        <th>Age</th>
                        <th>N° Matricule</th>
                        <th>Province</th>
                        <th>Commune</th>
                        <th>Zone</th>
                        <th>Colline</th>
                        <th>Contact</th>
                        <th>DATE INSERTION</th>
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
<?php include VIEWPATH.'templates/footer.php'; ?>
</body>
</html>
<script type="text/javascript">
 $(document).ready(function(){
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
      "order":[[8,'DESC']],
      "ajax":{
        url: "<?php echo base_url('menage/Chefs_menage/listing/');?>", 
        type:"POST",
        data : {
         ID_PROVINCE : $('#ID_PROVINCE').val(),
         ID_COMMUNE : $('#ID_COMMUNE').val(),
         ID_ZONE: $('#ID_ZONE').val(),
         ID_COLLINE : $('#ID_COLLINE').val(),
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
      buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print'  ],
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
  function supprimer(id,nom=null,prenom=null){
    Swal.fire({
      title: 'Souhaitez-vous Supprimer  '+nom+' '+prenom,
      showDenyButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>menage/Chefs_menage/delete/"+id,
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
 function get_communes(){
    var ID_PROVINCE = $('#ID_PROVINCE').val();
    if (ID_PROVINCE == '') {
      $('#ID_COMMUNE').html('<option value="">---Sélectionner---</option>');
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    }
    else { 
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>PSR/Psr_elements/get_communes/" + ID_PROVINCE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COMMUNE').html(data);
        }
      });
    }
  }

  function get_zones() {
    var ID_COMMUNE = $('#ID_COMMUNE').val();
    if (ID_COMMUNE == '') {
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>PSR/Psr_elements/get_zones/" + ID_COMMUNE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_ZONE').html(data);
        }
      });

    }
  }
  function get_collines(){
    var ID_ZONE = $('#ID_ZONE').val();
    if (ID_ZONE == '') {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>PSR/Psr_elements/get_collines/" + ID_ZONE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COLLINE').html(data);
        }
      });

    }
  }
  function get_avenues(){
    var ID_COLLINE = $('#ID_COLLINE').val();
    if (ID_COLLINE == '') {
      $('#AVENUS_ID').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>menage/Chefs_menage/get_avenues/" + ID_COLLINE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#AVENUS_ID').html(data);
        }
      });

    }
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
  function onSelected_zon()
  {
   liste();
    get_collines();
  }
  function onSelected_coll()
  {
   liste();
  }
  function onSelected_prof()
  {
   liste();
  }
</script> 

