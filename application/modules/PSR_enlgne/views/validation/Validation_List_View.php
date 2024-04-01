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
            </div><!-- /.col -->
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
                 Validés
                  <span id="vvalide"class="badge badge-danger"><?=$Nbre_valide?></span>
                </a>
             </div>
              <div class="col-md-2">
               <a href="#" id="3" onclick='liste_rejette()' style="width:   80px;" class='btn btn-outline-primary'>
                 Rejetés
                  <span id="rrejette" class="badge badge-danger"><?=$Nbre_rejette?></span>
                </a>
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
                
                <div class="col-md-12 table-responsive">
                   <div class="row">
                      <div class="form-group col-md-3">
                          <label>Du</label>
                         <input type="date" class="form-control input-sm" onchange="onSelected();" name="DATE_UNE" id="DATE_UNE" value="<?=set_value('DATE_UNE')?>" >
                      </div>  
                      <div class="form-group col-md-3">
                        <label>Au</label>

                         <input type="date"  class="form-control input-sm" onchange="onSelected();" name="DATE_DEUX" id="DATE_DEUX" min="<?=set_value('DATE_UNE')?>" value="<?=set_value('DATE_DEUX')?> " >

                      </div>
                      <div class="form-group col-md-6">
                        <div style="float:right ;">
                        <label>Catégories</label><br>
                       <select class="form-control input-sm" name="type" id="type" onchange='onSelected()'>
                          <option value="">Sélectionner</option>
                          <?php foreach ($categories as $key) { ?>
                            <option value="<?php echo $key['ID_TYPE'] ?>"><?php echo  $key['DESCRIPTION'] ?></option>
                          <?php } ?>
                        </select> 
                        </div>
                      </div>
                    </div>
                <div id="signale_nouvau">
                  <table id='nouveau' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        <!-- <th data-orderable="false"></th> -->
                        <th>AUTEUR</th>
                        <th>NUMERO PLAQUE</th>
                        <th>DESCRIPTION</th>
                        <th>COMMENTAIRE</th>
                        <th>CATEGORIE</th>
                        <th>PHOTO</th>
                        <th>STATUT</th>
                        <th>DATE DE SIGNALEMENT</th>
                        <th data-orderable="false" >OPTIONS</th>

                      </tr>
                    </thead>
                  </table>
                  </div>

                   <div id="signale_valide" style="display: none;">
                  <table id='valide' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                     <tr>
                        <!-- <th data-orderable="false"></th> -->
                        <th>AUTEUR</th>
                        <th>NUMERO PLAQUE</th>
                        <th>DESCRIPTION</th>
                        <th>COMMENTAIRE</th>
                        <th>CATEGORIE</th>
                        <th>PHOTO</th>
                        <th>STATUT</th>
                        <th>DATE DE SIGNALEMENT</th>

                      </tr>
                    </thead>
                  </table>
                  </div>

                  <div id="signale_rejette" style="display: none;">
                  <table id='rejette' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        <!-- <th data-orderable="false"></th> -->
                        <th>AUTEUR</th>
                        <th>NUMERO PLAQUE</th>
                        <th>DESCRIPTION</th>
                        <th>COMMENTAIRE</th>
                        <th>CATEGORIE</th>
                        <th>PHOTO</th>
                        <th>STATUT</th>
                        <th>DATE DE SIGNALEMENT</th>
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

      <!-- PSR partie -->

      <!-- End PSR partie -->

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


//LES MODALS CONTENANT  LES AVIS 

    <div class='modal fade' id='mydelete'>
      <div class='modal-dialog'>
      <div class='modal-header' style='background: black;'>
            <div id='title'><b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'>Annulation d'un signalement</h4></b></div>

            <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </div>
      </div>
        <div class='modal-content'>
          <div class='modal-body'>
               <form id='myForm1".$row->ID_SIGNALEMENT_NEW."'action=".base_url('PSR/Validation_signalement/rejette/'.$row->ID_SIGNALEMENT_NEW)." method='post' autocomplete='off'>
                   <div class='col-md-12 mt-4'>
                   <label>Avis</label>
                         <?=$selectAvisRejetter?>
                      </div> 
                   <div class='col-md-12 mt-4'>
                   </div> 
                    </div>
                    <div class='modal-footer'>
                    <button type='button' onclick='save_all_rejette()' class='btn btn-primary btn-md' >Rejetter</button> </form> 
                    </form>
                    <div class='modal-footer'>
                    <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
                 </div>
               </div>
              </div>
            </div>
            </div>

             <div class='modal fade' id='myAccepte'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                  <div class='modal-header' style='background: black;'>
                    <div id='title'><b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'>Validation d'un signalement</h4></b></div>

                    <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
                     <span aria-hidden='true'>&times;</span>
                   </div>
                 </div>
                    <div class='modal-body'>
                    <!-- <form id='myForm".$row->ID_SIGNALEMENT_NEW."'action=".base_url('PSR/Validation_signalement/save/'.$row->ID_SIGNALEMENT_NEW)." method='post' autocomplete='off'> -->
                    <form id='myForm'method='post' autocomplete='off'>
                   <div class='col-md-12 mt-4'>
                   <label>Avis</label>
                      <?=$selectAvisValide?>
                      </div> 
                   <div class='col-md-12 mt-4'>
                   </div> 
                    </div>
                    <div class='modal-footer'>
                    <button type='button' onclick='save_all_valide()' class='btn btn-primary btn-md' >Valider</button> </form> 
                  </form> 
                    <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
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
    liste_nouveau();
  });
  function subForm(id)
 {
    $('#myForm'+id).submit()
 }
 function subForm1(id)
 {
    $('#myForm1'+id).submit()
 }
  function liste_nouveau()
  {
    var btn1=document.getElementById("1")
    var btn2=document.getElementById("2")
    var btn3=document.getElementById("3")
 
    btn1.className = "btn btn-primary";
    btn2.className = "btn btn-outline-primary";
    btn3.className = "btn btn-outline-primary";

    $('#message').delay('slow').fadeOut(3000);
    $("#signale_nouvau").show()
    $("#signale_valide").hide()
    $("#signale_rejette").hide()

  $("#nouveau").DataTable(
  {
  "destroy" : true,
  "processing":true,
  "serverSide":true,
  "order":[[4,'DESC']],
  "ajax":{
  url: "<?php echo base_url('PSR/Validation_signalement/listing/'); ?>",
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
  function liste_valide()
  {
    var btn1=document.getElementById("1")
    var btn2=document.getElementById("2")
    var btn3=document.getElementById("3")
 
    btn1.className = "btn btn-outline-primary";
    btn2.className = "btn btn-primary";
    btn3.className = "btn btn-outline-primary";

  $('#message').delay('slow').fadeOut(3000);
    $("#signale_nouvau").hide()
    $("#signale_valide").show()
    $("#signale_rejette").hide()
  $("#valide").DataTable(
  {
  "destroy" : true,
  "processing":true,
  "serverSide":true,
  "oreder":[],
  "ajax":{
  url: "<?php echo base_url('PSR/Validation_signalement/listing_valide/'); ?>",
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
  function liste_rejette()
  {
    var btn1=document.getElementById("1")
    var btn2=document.getElementById("2")
    var btn3=document.getElementById("3")
 
    btn1.className = "btn btn-outline-primary";
    btn2.className = "btn btn-outline-primary";
    btn3.className = "btn btn-primary";

  $('#message').delay('slow').fadeOut(3000);
   $("#signale_nouvau").hide()
    $("#signale_valide").hide()
    $("#signale_rejette").show()
  $("#rejette").DataTable(
  {
  "destroy" : true,
  "processing":true,
  "serverSide":true,
  "oreder":[],
  "ajax":{
  url: "<?php echo base_url('PSR/Validation_signalement/listing_rejette/'); ?>",
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
  function one_checked(){
   var i = 0;
   $("input[name=SIGNALEMENT_ID]").each(function() {
      if (this.checked == true && this.value > 0) {
      i++  
      }
     });
     if(i>0){
      $('#selections').prop('disabled',false)
    }
    else{
      $('#selections').prop('disabled',true)
    }
    $('#nombress').html(i) 
 }
  function cocher_all(){
     const firstInput = document.getElementsByName('SIGNALEMENT_ID');
     var i = 0;
            if (firstInput[0].checked) {
                $("input[name=SIGNALEMENT_ID]").each(function() {
               this.checked = true; 
                   if (this.value > 0) {
                      i++
                   }
            });
            }else{
               $(':checkbox').each(function() {
               this.checked = false;                       
            });
          }
          if(i>0){
                 $('#selections').prop('disabled',false)
          }
          else{
                 $('#selections').prop('disabled',true)

          }
          $('#nombress').html(i)
 }
 function valide_all(){
   var i = 0;
   // var ID_ASSUREUR_ALL = $('#assureur').val();
   const donne= [];
   $("input[name=SIGNALEMENT_ID]").each(function() {
      if (this.checked == true && this.value > 0) {
        donne.push(this.value)
      }
     });
   // if (ID_ASSUREUR_ALL == '') {
   //    $('#assureur').focus()
   // }else{
         Swal.fire({
            title: 'Souhaitez-vous valider ou  rejetter ces signalements sélectionnés?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Valider',
            denyButtonText: `Rejetter`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
            /* Debut ajax*/
               $('#myAccepte').modal()
            } else if (result.isDenied) {

               $('#mydelete').modal()
            }
            
          })

}
function save_all_rejette(){
   var i = 0;
   var SIGNALEMENT_AVIS_REJETTER = $('#signalement_avis_rejetter').val();
   const donne= [];
   $("input[name=SIGNALEMENT_ID]").each(function() {
      if (this.checked == true && this.value > 0) {
        donne.push(this.value)
      }
     });
   if (SIGNALEMENT_AVIS_REJETTER == '') {
      $('#signalement_avis_rejetter').focus()
   }else{
         Swal.fire({
            title: 'Souhaitez-vous rejetter ces signalements sélectionnés?',
            showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: 'Maintenant',
            denyButtonText: `Pas maintenant`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              

            /* Debut ajax*/
               $.ajax({
                url : "<?=base_url()?>PSR/Validation_signalement/rejette_alls/",
                type : "POST",
                dataType: "JSON",
                cache:false,
                data: {ID_SIGNALEMENT_NEW:donne,
                      SIGNALEMENT_AVIS_REJETTER:SIGNALEMENT_AVIS_REJETTER},
                beforeSend:function () { 
                 
                },
                success:function(data) {
                  console.log(data.message);
                  $('#nombress').html(0)
                  Swal.fire(data.message, '', 'success')
                  liste_valide()
                  $('#mydelete').modal('hide')

                },
                error:function() {
                  Swal.fire('Erreur de la connexion', '', 'info')
                }
            });
            } else if (result.isDenied) {
              Swal.fire('Non Confirmé', '', 'info')
            }
          })
      }
}
function save_all_valide(){
   var i = 0;
   var SIGNALEMENT_AVIS_VALIDER = $('#signalement_avis_valider').val();
   const donne= [];
   $("input[name=SIGNALEMENT_ID]").each(function() {
      if (this.checked == true && this.value > 0) {
        donne.push(this.value)
      }
     });
   if (SIGNALEMENT_AVIS_VALIDER == '') {
      $('#signalement_avis_valider').focus()
   }else{
         Swal.fire({
            title: 'Souhaitez-vous valide ces signalements sélectionnés?',
            showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: 'Maintenant',
            denyButtonText: `Pas maintenant`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              

            /* Debut ajax*/
               $.ajax({
                url : "<?=base_url()?>PSR/Validation_signalement/save_alls/",
                type : "POST",
                dataType: "JSON",
                cache:false,
                data: {ID_SIGNALEMENT_NEW:donne,
                      SIGNALEMENT_AVIS_VALIDER:SIGNALEMENT_AVIS_VALIDER},
                beforeSend:function () { 
                 
                },
                success:function(data) {
                  console.log(data.message);
                  $('#nombress').html(0)
                   Swal.fire(data.message, '', 'success')

                  liste_valide()
                  $('#myAccepte').modal('hide')

                },
                error:function() {
                  Swal.fire('Erreur de la connexion', '', 'info')
                }
            });

              
            } else if (result.isDenied) {
              Swal.fire('Non Confirmé', '', 'info')
            }
          })
      }
}
function subForm_delete(id)
 {
    Swal.fire({
      title: 'Souhaitez-vous rejetter un signalement?',
      showDenyButton: true,
      // showCancelButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $('#myForm1'+id).submit()
        $('#mydelete').modal('hide')
        Swal.fire('Confirmé!', '', 'success')
      } else if (result.isDenied) {
        Swal.fire('Non Confirmé', '', 'info')
      }
    })
 }
 function subForm_valide(id)
 {
    Swal.fire({
      title: 'Souhaitez-vous valider ce signalement?',
      showDenyButton: true,
      // showCancelButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $('#myForm'+id).submit()
        Swal.fire('Confirmé!', '', 'success')
        $('#myAccepte').modal('hide')
      } else if (result.isDenied) {
        Swal.fire('Non Confirmé', '', 'info')
      }
    })
    
 }
function onSelected()
{
   let DATE_UNE=  $('#DATE_UNE').val()
   document.getElementById("DATE_DEUX").setAttribute("min", DATE_UNE); 
   liste_nouveau()
}
  </script>