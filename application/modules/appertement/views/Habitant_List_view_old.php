<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php'; ?>



<style type="text/css">
.mapbox-improve-map{
  display: none;
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
            
          <div class="col-sm-8 text-left">
            <div class="row">
              <div class="col-md-6">
                 <h4 class="m-0"><?= $title ?></h4>
             </div>
           
              <div class="col-md-2">
               <a href="#" onclick='liste_nouveau()' id="1"  style="width: 100px;" class='btn btn-outline-primary'>
                  Nouveau 
                  <span  id="nnouveau"class="badge badge-danger"><?=$Nbre_nouveau?></span>
                  
                </a>
             </div>
             <div class="col-md-2">
               <a href="#" id="2" onclick='liste_valide()' style="width:  80px;" class='btn btn-outline-primary'>
                 Valider
                  <span id="vvalide"class="badge badge-danger"><?=$Nbre_valide?></span>
                </a>
             </div>
              <div class="col-md-2">
               <a href="#" id="3" onclick='liste_rejette()' style="width:   80px;" class='btn btn-outline-primary'>
                 Rejetter
                  <span id="rrejette" class="badge badge-danger"><?=$Nbre_rejette?></span>
                </a>
             </div>
          </div>
        </div><!-- /.col -->

            <div class="col-sm-4 text-right">


              <span style="margin-right: 15px">
                <div class="col-sm-3" style="float:right;">
                  <a href="<?=base_url('appertement/Enclos/ajouter_habitant')?>" style="width: 100px;" class='btn btn-primary btn-sm float-right'>
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
                    <div class="row">
                      <div class="form-group col-md-2">
                      <label for="Ftype">Province</label>
                      <select required class="form-control" name="ID_PROVINCE" id="ID_PROVINCE" onchange="onSelected();">
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
                    <div class="form-group col-md-2">
                      <label for="Ftype">Commune</label>
                      <select required class="form-control" name="ID_COMMUNE" id="ID_COMMUNE" onchange="onSelected_com();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_commune"></font></div> -->
                      <?php echo form_error('ID_COMMUNE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="Ftype">Zone</label>
                      <select class="form-control" name="ID_ZONE" id="ID_ZONE" onchange="onSelected_zon();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_zone"></font></div> -->
                      <?php echo form_error('ID_ZONE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="Ftype">Colline</label>
                      <select class="form-control" name="ID_COLLINE" id="ID_COLLINE" onchange="onSelected_coll();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_colline"></font></div> -->
                      <?php echo form_error(' ID_COLLINE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="Ftype">Fonction</label>
                      <select  onchange="onSelected_coll();" required class="form-control" name="ID_FONCTION" id="ID_FONCTION">
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($fonctions as $value) {
                        ?>
                          <option value="<?= $value['ID_FONCTION'] ?>"><?= $value['FONCTION_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <!-- <div><font color="red" id="error_colline"></font></div> -->
                      <?php echo form_error('ID_FONCTION', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="Ftype">Rôle</label>
                      <select  onchange="onSelected_coll();" required class="form-control" name="ID_HABITANT_ROLE" id="ID_HABITANT_ROLE">
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($roles as $value) {
                        ?>
                          <option value="<?= $value['ID_HABITANT_ROLE'] ?>"><?= $value['NOM_ROLE'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <!-- <div><font color="red" id="error_colline"></font></div> -->
                      <?php echo form_error('ID_HABITANT_ROLE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    </div>

                <!-- DEBUT LISTE DES HABITATANTS NOUVEAU -->
                <div id="habitant_nouveau">
                 <table id='nouveau' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>Habitant</th>
                        <th>Age</th>
                        <th>CNI</th>
                        <th>LIEU DE DELIVRANCE</th>
                        <th>DATE DE DELIVRANCE</th>
                        <th>PERE</th>
                        <th>MERE</th>
                        <th>CONTACT</th>
                        <th>AVENUE</th>
                        <th>COLLINE</th>
                        <th>ZONE</th>
                        <th>COMMUNE</th>
                        <th>PROVINCE</th>
                        <th>ETAT CIVIL</th>
                        <th>FONCTION</th>
                        <th>ROLE</th>
                        <th>OPTIONS</th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <!-- FIN LISTE -->

                <!-- DEBUT LISTE DES HABITATANTS VALIDE -->
                <div id="habitant_valide" style="display: none;">
                  <table id='valide' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        <!-- <td data-orderable="false"></td> -->
                        <td>AUTEUR</td>
                        <td>NUMERO PLAQUE</td>
                        <td>DESCRIPTION</td>
                        <td>COMMENTAIRE</td>
                        <td>CATEGORIE</td>
                        <td>PHOTO</td>
                        <td>STATUT</td>
                        <td>DATE DE SIGNALEMENT</td>
                        <td data-orderable="false" >OPTIONS</td>

                      </tr>
                    </thead>
                  </table>
                  </div>
                  <!-- FIN LISTE-->

                <!-- DEBUT LISTE DES HABITANTS REJETTE -->
                  <div id="habitant_rejette" style="display: none;">
                  <table id='rejette' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        <!-- <td data-orderable="false"></td> -->
                        <td>AUTEUR</td>
                        <td>NUMERO PLAQUE</td>
                        <td>DESCRIPTION</td>
                        <td>COMMENTAIRE</td>
                        <td>CATEGORIE</td>
                        <td>PHOTO</td>
                        <td>STATUT</td>
                        <td>DATE DE SIGNALEMENT</td>
                      </tr>
                    </thead>
                  </table>
                  </div>
                </div>
                  <!-- FIN LISTE -->


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
  liste_nouveau();

});
</script>

<script type="text/javascript">

  function liste_nouveau()
   { 
    $('#message').delay('slow').fadeOut(3000);
    var btn1=document.getElementById("1")
    var btn2=document.getElementById("2")
    var btn3=document.getElementById("3")
 
    btn1.className = "btn btn-primary";
    btn2.className = "btn btn-outline-primary";
    btn3.className = "btn btn-outline-primary";

    $('#message').delay('slow').fadeOut(3000);
    $("#habitant_nouvau").show()
    $("#habitant_valide").hide()
    $("#habitant_rejette").hide()

    $("#nouveau").DataTable({
      "destroy" : true,
      "processing":true,
      "serverSide":true,
      "oreder":[],
      "ajax":{
        url: "<?php echo base_url('appertement/Enclos/listing_habitant_nouveau/');?>", 
        type:"POST",
        data : {
         ID_PROVINCE : $('#ID_PROVINCE').val(),
         ID_COMMUNE : $('#ID_COMMUNE').val(),
         ID_ZONE: $('#ID_ZONE').val(),
         ID_COLLINE : $('#ID_COLLINE').val(),
         ID_FONCTION : $('#ID_FONCTION').val(),
         ID_HABITANT_ROLE : $('#ID_HABITANT_ROLE').val(),

        },
  beforeSend : function() {
  }
  },
  "drawCallback": function(settings) {
   console.log(settings.json.recordsFiltered)
   $("#nnouveau").html(settings.json.recordsFiltered)

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

  //HABITANT VALIDE
  function liste_valide()
  {
    var btn1=document.getElementById("1")
    var btn2=document.getElementById("2")
    var btn3=document.getElementById("3")
 
    btn1.className = "btn btn-outline-primary";
    btn2.className = "btn btn-primary";
    btn3.className = "btn btn-outline-primary";

  $('#message').delay('slow').fadeOut(3000);
    $("#habitant_nouvau").hide()
    $("#habitant_valide").show()
    $("#habitant_rejette").hide()
  $("#valide").DataTable(
  {
  "destroy" : true,
  "processing":true,
  "serverSide":true,
  "oreder":[],
  "ajax":{
  url: "<?php echo base_url('appertement/Enclos/listing_habitant_valide/'); ?>",
  type:"POST",
  data : {
          DATE_UNE : $('#DATE_UNE').val(),
          DATE_DEUX : $('#DATE_DEUX').val(),
          TYPE:$('#type').val()


        },
  beforeSend : function() {
  }
  },
  "drawCallback": function(settings) {
   console.log(settings.json.recordsFiltered)
   $("#vvalide").html(settings.json.recordsFiltered)

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

  //HABITANT REJETTE
  function liste_rejette()
  {
    var btn1=document.getElementById("1")
    var btn2=document.getElementById("2")
    var btn3=document.getElementById("3")
 
    btn1.className = "btn btn-outline-primary";
    btn2.className = "btn btn-outline-primary";
    btn3.className = "btn btn-primary";

  $('#message').delay('slow').fadeOut(3000);
    $("#habitant_nouvau").hide()
    $("#habitant_valide").hide()
    $("#habitant_rejette").show()
  $("#rejette").DataTable(
  {
  "destroy" : true,
  "processing":true,
  "serverSide":true,
  "oreder":[],
  "ajax":{
  url: "<?php echo base_url('appertement/Enclos/listing_habitant_rejette/'); ?>",
  type:"POST",
  data : {
          DATE_UNE : $('#DATE_UNE').val(),
          DATE_DEUX : $('#DATE_DEUX').val(),
          TYPE:$('#type').val()
        },
  beforeSend : function() {
  }
  },

"drawCallback": function(settings) {
   console.log(settings.json.recordsFiltered)
   $("#rrejette").html(settings.json.recordsFiltered)

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
   liste_nouveau();
    get_communes();
  }
  function onSelected_com()
  {
    liste_nouveau();
    get_zones();
  }
  function onSelected_zon()
  {
   liste_nouveau();
    get_collines();
  }
  function onSelected_coll()
  {
   liste_nouveau();
  }
  function onSelected_prof()
  {
   liste_nouveau();
  }
</script> 