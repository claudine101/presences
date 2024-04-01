<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php'; ?>

<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
           <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

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
#Ftype{
    color: White;
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
             <?php if($profil==20 || $profil==22 || $profil==21  ) { ?>
                <div class="col-sm-6">
               <?php } else{ ?>
                  <div class="col-sm-2">
               <?php } ?>
              <h4 class="m-0"><?=$title?><?=$name?></h4>
            </div><!-- /.col -->
            <div class="col-sm-8">
              <?php if($profil==20) { ?>
                     <!-- CHEF DE SECTEUR -->
                    <?php } 
                    elseif($profil==22) { ?>
                      <!-- CHEF DE QUARTIER -->
                     <div class="row">
                          <div class="form-group col-md-3">
                           <label id="Ftype"  for="Ftype">Avenues</label>
                          <select required class="form-control form-control-sm" name="ID_AVENUE" id="ID_AVENUE" onchange="onSelected_aven();">
                            <option value="">---Sélectionner---</option>
                            <?php
                            foreach ($avenues as $value) {
                            ?>
                              <option value="<?= $value['AVENUE_ID'] ?>"><?= $value['AVENUE_NAME'] ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <?php echo form_error('ID_AVENUE', '<div class="text-danger">', '</div>'); ?>
                        </div>
                      </div>
                    <?php } 
                    elseif ($profil==21) {?>
                      <div class="row">
                        <div class="form-group col-md-3">
                           <label id="Ftype"  for="Ftype">Collines</label>
                          <select required class="form-control form-control-sm" name="ID_COLLINE" id="ID_COLLINE" onchange="onSelected_coll();">
                            <option value="">---Sélectionner---</option>
                            <?php
                            foreach ($collines as $value) {
                            ?>
                              <option value="<?= $value['COLLINE_ID'] ?>"><?= $value['COLLINE_NAME'] ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <!-- <div><font color="red" id="error_province"></font></div>  -->
                          <?php echo form_error('ID_COLLINE', '<div class="text-danger">', '</div>'); ?>
                        </div>
                        <div class="form-group col-md-3">
                           <label id="Ftype"  for="Ftype">Avenues</label>
                          <select class="form-control form-control-sm" name="ID_AVENUE" id="ID_AVENUE" onchange="onSelected_aven();">
                            <option value="">---Sélectionner---</option>
                          </select>
                          <!-- <div><font color="red" id="error_colline"></font></div> -->
                          <?php echo form_error('ID_AVENUE', '<div class="text-danger">', '</div>'); ?>
                        </div>
                     </div>
                   <?php }
                    else{?>
                      <div class="row">
                      <div class="form-group col-md-3">
                       <label id="Ftype"  for="Ftype">Province</label>
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
                       <label id="Ftype"  for="Ftype">Commune</label>
                      <select required class="form-control form-control-sm" name="ID_COMMUNE" id="ID_COMMUNE" onchange="onSelected_com();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_commune"></font></div> -->
                      <?php echo form_error('ID_COMMUNE', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-2">
                       <label id="Ftype"  for="Ftype">Zone</label>
                      <select class="form-control form-control-sm" name="ID_ZONE" id="ID_ZONE" onchange="onSelected_zon();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_zone"></font></div> -->
                      <?php echo form_error('ID_ZONE', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-2">
                       <label id="Ftype"  for="Ftype">Colline</label>
                      <select class="form-control form-control-sm" name="ID_COLLINE" id="ID_COLLINE" onchange="onSelected_coll();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_colline"></font></div> -->
                      <?php echo form_error(' ID_COLLINE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="form-group col-md-2">
                       <label id="Ftype"  for="Ftype">Avenues</label>
                       <select class="form-control form-control-sm" name="ID_AVENUE" id="ID_AVENUE" onchange="onSelected_aven();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_colline"></font></div> -->
                      <?php echo form_error('ID_AVENUE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    </div>

                    <?php } ?>

            </div><!-- /.col -->
             <?php if($profil==20 || $profil==22 || $profil==21  ) { ?>
                            <div class="col-sm-4 text-right">

               <?php } else{ ?>
                              <div class="col-sm-2 text-right">

               <?php } ?>
              <span style="margin-right: 15px">
                <div class="col-sm-3" style="float:right;">
                  <a href="<?=base_url('appertement/Enclos/ajouter')?>" style="width: 100px;" class='btn btn-primary btn-sm float-right'>
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
                    <table id='maison' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>Responsable</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>N° enclos</th>
                        <th>Code</th>
                        <th>Adresse</th>
                        <th>Localité</th>
                        <th>Nombre appartement</th>
                        <th>Date</th>
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
 <div class="modal fade" id="appertement">
       <div class="modal-dialog modal-lg" >
         <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <div id="title"><b><h4 id="appertement_list" style="color:#fff;font-size: 18px;"></h4></b>
            </div>
            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
         <div class="modal-body">

           <div class="col-md-12">
                  <table id='mytable' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>Responsable</th>
                        <th>Numero d'appartements</th>
                        <th>Habitant</th>
                        <th>Nombre chambre</th>
                        <th>Date insertion</th>
                        <th data-orderable="false">Options</th>
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
  
  <div id="habitant" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <div id="title"><b><h4 id="habitant_titre" style="color:#fff;font-size: 18px;">Habitant</h4></b>
              
            </div>
            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
         <div class="modal-body">

      <div class="col-md-12 table-responsive">
        <table id='mytable_habitant' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>HABITANT</th>
                        <th>CNI</th>
                        <!-- <th>PARENTS</th> -->
                        <th>CONTACT</th>
                        <th>ADDRESSE</th>
                        <th>LOCALITE</th>
                        <th>ETAT CIVIL</th>
                        <th>FONCTION</th>
                        <th>ROLE</th>
                        <th data-orderable="false">OPTIONS</th>
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

  <div class="modal fade" id="appertement_add">
       <div class="modal-dialog modal-lg" >
         <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <div id="title"><b><h4 id="appertement_titre" style="color:#fff;font-size: 18px;">Nouveau appartement</h4></b>
              
            </div>
            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
         <div class="modal-body">
                   <div class="col-md-6">
                       <label id="Ftype"  for="FName">Adresse</label>
                      <input type="tel" name="ADRESSE" autocomplete="off" id="ADRESSE" value="<?= set_value('ADRESSE') ?>" class="form-control form-control-sm">
                      <?php echo form_error('ADRESSE', '<div class="text-danger">', '</div>'); ?>
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
<?php include VIEWPATH.'templates/footer.php'; ?>
</body>
</html>
<script type="text/javascript">
 $(document).ready(function(){
  liste();
});
</script>
<script type="text/javascript">
 function subForm(id,nom=null,prenom=null)
 {
    Swal.fire({
      title: "Souhaitez-vous ajouter une nouvelle appertement dans l'\enclos de "+nom+ " "+prenom,
      showDenyButton: true,
      // showCancelButton: true,
      confirmButtonText: 'oui',
      denyButtonText: `Non`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $('#myForm'+id).submit()
        // getDetail(id)
        Swal.fire('Confirmé!', '', 'success')
      } else if (result.isDenied) {
        Swal.fire('Non Confirmé', '', 'info')
      }
    })
    
 }
 function subForm_edit(id,nom=null,prenom=null)
 {
    Swal.fire({
      title: "Souhaitez-vous modifier appertement  "+nom,
      showDenyButton: true,
      // showCancelButton: true,
      confirmButtonText: 'oui',
      denyButtonText: `Non`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $('#myForm_edit'+id).submit()
        // getDetail(id)
        Swal.fire('Confirmé!', '', 'success')
      } else if (result.isDenied) {
        Swal.fire('Non Confirmé', '', 'info')
      }
    })
    
 }
 function supprimer(id,id1){
    Swal.fire({
      title: 'Souhaitez-vous Supprimer  appertement N°'+id1+'?',
      showDenyButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>appertement/Enclos/supprimer/"+id,
          type : "DELETE",
          dataType: "JSON",
          cache:false,
          data: {},
          beforeSend:function () { 
           
          },
          success:function(data) {
            console.log(data);
            // getDetail(id1)
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
 function supprimer_enclos(id,nom=null,prenom=null){
    Swal.fire({
      title: 'Souhaitez-vous Supprimer Enclos de:  '+nom+' '+prenom,
      showDenyButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>appertement/Enclos/delete/"+id,
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
 function supprimer_habitant(id,nom=null,prenom=null){
    Swal.fire({
      title: 'Souhaitez-vous Supprimer   '+nom+'  '+prenom+'?',
      showDenyButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>appertement/Enclos/delete_habitant/"+id,
          type : "DELETE",
          dataType: "JSON",
          cache:false,
          data: {},
          beforeSend:function () { 
           
          },
          success:function(data) {
            console.log(data);
            getHabitant(id)
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
 function getDetail(id = 0,enclos=null) 
 {
    $('#appertement').modal()
    $("#appertement_list").html("Les appartement se trouvant dans l'enclos N° "+enclos);
  
    var row_count ="1000000";
    $("#mytable").DataTable(
    {
        "processing":true,
        "serverSide":true,
        "bDestroy": true,
        "oreder":[],
        "ajax":
        {
        url : "<?=base_url()?>appertement/Enclos/get_appartement/"+id,      
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
  function getHabitant(id = 0,nom=null,prenom=null) 
 {
    $('#habitant').modal()
    $("#habitant_titre").html("Les habitant se trouvant dans l'appartement: "+nom+' enclos:'+prenom);
    var row_count ="1000000";
    $("#mytable_habitant").DataTable(
    {
        "processing":true,
        "serverSide":true,
        "bDestroy": true,
        "oreder":[],
        "ajax":
        {
        url : "<?=base_url()?>appertement/Enclos/get_habitant/"+id,      
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
  function liste() 
  {  
    $('#message').delay('slow').fadeOut(3000);
    $("#maison").DataTable({
      "destroy" : true,
      "processing":true,
      "serverSide":true,
      "order":[[7,'DESC']],
      "ajax":{
        url: "<?php echo base_url('appertement/Enclos/listing/');?>", 
        type:"POST",
        data : {
         ID_PROVINCE : $('#ID_PROVINCE').val(),
         ID_COMMUNE : $('#ID_COMMUNE').val(),
         ID_ZONE: $('#ID_ZONE').val(),
         ID_COLLINE : $('#ID_COLLINE').val(),
         ID_AVENUE : $('#ID_AVENUE').val()
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
        url: "<?= base_url() ?>Appertement/Enclos/get_communes/" + ID_PROVINCE,
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
        url: "<?= base_url() ?>Appertement/Enclos/get_zones/" + ID_COMMUNE,
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
        url: "<?= base_url() ?>Appertement/Enclos/get_collines/" + ID_ZONE,
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
      $('#ID_AVENUE').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>Appertement/Enclos/get_avenues/" + ID_COLLINE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_AVENUE').html(data);
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
   get_avenues();
  }
  function onSelected_prof()
  {
   liste();
  }
  function onSelected_aven()
  {
    liste();
  }

</script> 
<script type="text/javascript">
  function show_edit_modal(id) {
     $('#edit'+id).modal()
  }
</script>

