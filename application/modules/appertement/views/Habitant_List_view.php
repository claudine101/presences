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
            <div class="col-sm-2">
                 <h4 class="m-0"><?= $title ?></h4>
            </div><!-- /.col -->
            <div class="col-sm-8 " align="center">
              <div class="row">
             <?php if($profil==20|| $profil==22 ||$profil==21) { ?>
           
              <div class="col-md-2 ">
               <a href="#" onclick='liste_nouveau()' id="1"  style="width: 100px;" class='btn btn-outline-primary'>
                  Nouveau 
                  <span  id="nnouveau"class="badge badge-danger"><?=$Nbre_nouveau?></span>
                  
                </a>
             </div>
             <div class="col-md-2">
               <a href="#" id="2" onclick='liste_valide()' style="width:  80px;" class='btn btn-outline-primary'>
                 Visiter
                  <span id="vvalide"class="badge badge-danger"><?=$Nbre_valide?></span>
                </a>
             </div>
              <div class="col-md-2">
               <a href="#" id="3" onclick='liste_rejette()' style="width:   100px;" class='btn btn-outline-primary'>
                 soupçonner
                  <span id="rrejette" class="badge badge-danger"><?=$Nbre_rejette?></span>
                </a>
             </div>
          <?php } ?>
          </div> 
          </div> 
             <div class="col-md-2" align="right">
<!--               <span style="margin-right: 15px">
                <div class="col-sm-3" style="float:right;"> -->
                  <a href="<?=base_url('Appertement/Enclos/ajouter_habitant')?>" style="width: 100px;" class='btn btn-primary btn-sm float-right'>
                    <i class="nav-icon fas fa-plus"></i>
                    Nouveau
                  </a>
       <!--          </div>

              </span> -->

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
                  <?php if($profil==20) { ?>
                     <!-- CHEF DE SECTEUR -->
                    <?php } 
                    elseif($profil==22) { ?>
                      <!-- CHEF DE QUARTIER -->
                          <div class="form-group col-md-3">
                          <label for="Ftype">Avenues</label>
                          <select required class="form-control" name="AVENUE_ID" id="AVENUE_ID" onchange="onSelected_aven();">
                            <option value="">---Sélectionner---</option>
                            <?php
                            foreach ($avenues as $value) {
                            ?>
                              <option value="<?= $value['AVENUE_ID'] ?>"><?= $value['AVENUE_NAME'] ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <?php echo form_error('AVENUE_ID', '<div class="text-danger">', '</div>'); ?>
                        </div>
                    <?php } 
                    elseif ($profil==21) {?>
                        <div class="form-group col-md-3">
                          <label for="Ftype">Collines</label>
                          <select required class="form-control" name="ID_COLLINE" id="ID_COLLINE" onchange="onSelected_coll();">
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
                    else{?>
                      <div class="form-group col-md-3">
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

                    <div class="form-group col-md-3">
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
                    <?php } ?>
                   

                  
                      
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
                <div id="habitant_nouvau">
                  <table id='nouveau' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                     <tr>
                        <th>Habitant</th>
                        <th>CNI</th>
                        <th>PARENTS</th>
                        <th>Age</th>
                        <th>CONTACT</th>
                        <th>ADRESSE</th>
                        <th>LOCALITE</th>
                        <th>ETAT CIVIL</th>
                        <th>FONCTION</th>
                        <th>ROLE</th>
                        <th>OPTIONS</th>
                       
                      </tr>
                    </thead>
                  </table>
                  </div>

                   <div id="habitant_valide" style="display: none;">
                  <table id='valide' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                     <tr>
                         <th>Habitant</th>
                        <th>CNI</th>
                        <th>PARENTS</th>
                        <th>Age</th>
                        <th>CONTACT</th>
                        <th>ADRESSE</th>
                        <th>LOCALITE</th>
                        <th>ETAT CIVIL</th>
                        <th>FONCTION</th>
                        <th>ROLE</th>
                      </tr>
                    </thead>
                  </table>
                  </div>

                  <div id="habitant_rejette" style="display: none;">
                  <table id='rejette' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                         <th>Habitant</th>
                        <th>CNI</th>
                        <th>PARENTS</th>
                        <th>Age</th>
                        <th>CONTACT</th>
                        <th>ADRESSE</th>
                        <th>LOCALITE</th>
                        <th>ETAT CIVIL</th>
                        <th>FONCTION</th>
                        <th>ROLE</th>
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
            <div id='title'><b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'>Annulation d'un habitantment</h4></b></div>

            <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </div>
      </div>
        <div class='modal-content'>
          <div class='modal-body'>
               <form id='myForm1".$row->ID_SIGNALEMENT_NEW."'action=".base_url('PSR/Validation_habitantment/rejette/'.$row->ID_SIGNALEMENT_NEW)." method='post' autocomplete='off'>
                   <div class='col-md-12 mt-4'>
                   <label>Avis</label>
                         <?=$selectAvissoupçonner?>
                      </div> 
                   <div class='col-md-12 mt-4'>
                   </div> 
                    </div>
                    <div class='modal-footer'>
                    <button type='button' onclick='save_all_rejette()' class='btn btn-primary btn-md' >soupçonner</button> </form> 
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
                    <div id='title'><b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'>Validation d'un habitantment</h4></b></div>

                    <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
                     <span aria-hidden='true'>&times;</span>
                   </div>
                 </div>
                    <div class='modal-body'>
                    <!-- <form id='myForm".$row->ID_SIGNALEMENT_NEW."'action=".base_url('PSR/Validation_habitantment/save/'.$row->ID_SIGNALEMENT_NEW)." method='post' autocomplete='off'> -->
                    <form id='myForm'method='post' autocomplete='off'>
                   <div class='col-md-12 mt-4'>
                   <label>Avis</label>
                      <?=$selectAvisValide?>
                      </div> 
                   <div class='col-md-12 mt-4'>
                   </div> 
                    </div>
                    <div class='modal-footer'>
                    <button type='button' onclick='save_all_valide()' class='btn btn-primary btn-md' >Visiter</button> </form> 
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
            title: 'Souhaitez-vous valider ou  soupçonner ces habitantments sélectionnés?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Visiter',
            denyButtonText: `soupçonner`,
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
   var SIGNALEMENT_AVIS_REJETTER = $('#habitantment_avis_soupçonner').val();
   const donne= [];
   $("input[name=SIGNALEMENT_ID]").each(function() {
      if (this.checked == true && this.value > 0) {
        donne.push(this.value)
      }
     });
   if (SIGNALEMENT_AVIS_REJETTER == '') {
      $('#habitantment_avis_soupçonner').focus()
   }else{
         Swal.fire({
            title: 'Souhaitez-vous soupçonner ces habitantments sélectionnés?',
            showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: 'Maintenant',
            denyButtonText: `Pas maintenant`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              

            /* Debut ajax*/
               $.ajax({
                url : "<?=base_url()?>PSR/Validation_habitantment/rejette_alls/",
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
   var SIGNALEMENT_AVIS_VALIDER = $('#habitantment_avis_valider').val();
   const donne= [];
   $("input[name=SIGNALEMENT_ID]").each(function() {
      if (this.checked == true && this.value > 0) {
        donne.push(this.value)
      }
     });
   if (SIGNALEMENT_AVIS_VALIDER == '') {
      $('#habitantment_avis_valider').focus()
   }else{
         Swal.fire({
            title: 'Souhaitez-vous valide ces habitantments sélectionnés?',
            showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: 'Maintenant',
            denyButtonText: `Pas maintenant`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              

            /* Debut ajax*/
               $.ajax({
                url : "<?=base_url()?>PSR/Validation_habitantment/save_alls/",
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
      title: 'Souhaitez-vous soupçonner un habitantment?',
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
      title: 'Souhaitez-vous valider ce habitantment?',
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

//HABITANT NOUVEAU
 function liste_nouveau()
  {
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

  $("#nouveau").DataTable(
  {
  "destroy" : true,
  "processing":true,
  "serverSide":true,
  "order":[[4,'DESC']],
  "ajax":{
        url: "<?php echo base_url('appertement/Enclos/listing_habitant_nouveau/');?>", 
        type:"POST",
        data : {
         ID_PROVINCE : $('#ID_PROVINCE').val(),
         ID_COMMUNE : $('#ID_COMMUNE').val(),
         ID_ZONE: $('#ID_ZONE').val(),
         ID_COLLINE : $('#ID_COLLINE').val(),
         ID_AVENUE : $('#AVENUE_ID').val(),
         ID_FONCTION : $('#ID_FONCTION').val(),
         ID_HABITANT_ROLE : $('#ID_HABITANT_ROLE').val()
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
         ID_PROVINCE : $('#ID_PROVINCE').val(),
         ID_COMMUNE : $('#ID_COMMUNE').val(),
         ID_ZONE: $('#ID_ZONE').val(),
         ID_COLLINE : $('#ID_COLLINE').val(),
         ID_FONCTION : $('#ID_FONCTION').val(),
         ID_HABITANT_ROLE : $('#ID_HABITANT_ROLE').val()
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
         ID_PROVINCE : $('#ID_PROVINCE').val(),
         ID_COMMUNE : $('#ID_COMMUNE').val(),
         ID_ZONE: $('#ID_ZONE').val(),
         ID_COLLINE : $('#ID_COLLINE').val(),
         ID_FONCTION : $('#ID_FONCTION').val(),
         ID_HABITANT_ROLE : $('#ID_HABITANT_ROLE').val()
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
      $('#AVENUE_ID').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>Appertement/Enclos/get_avenuesAdd/" + ID_COLLINE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#AVENUE_ID').html(data);
        }
      });

    }
  }
  function onSelected()
  {
    liste_rejette();
    liste_valide();
    liste_nouveau();
    get_communes();
  }
  function onSelected_com()
  {
    liste_rejette();
    liste_valide();
    liste_nouveau();
    get_zones();
  }
  function onSelected_zon()
  {
   liste_rejette();
   liste_valide();
    liste_nouveau();
    get_collines();
  }
  function onSelected_coll()
  {
   liste_rejette();
   liste_valide();
   liste_nouveau();
   get_avenues()
  }
   function onSelected_aven()
  {
   
   liste_rejette();
   liste_valide();
   liste_nouveau();
  }
  function onSelected_prof()
  {
   liste_rejette();
   liste_valide();
   liste_nouveau();
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
          url : "<?=base_url()?>appertement/Enclos/delete_habitant/"+id,
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
 function valider(id,nom=null,prenom=null){
    Swal.fire({
      title: 'Souhaitez-vous valider  '+nom+' '+prenom,
      showDenyButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>Appertement/Enclos/valider/"+id,
          type : "DELETE",
          dataType: "JSON",
          cache:false,
          data: {},
          beforeSend:function () { 
          },
          success:function(data) {
            console.log(data);
            liste_rejette();
           liste_nouveau();
           liste_valide();
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
 function soupçonner(id,nom=null,prenom=null){
    Swal.fire({
      title: 'Souhaitez-vous soupçonner  '+nom+' '+prenom,
      showDenyButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>Appertement/Enclos/soupçonner/"+id,
          type : "DELETE",
          dataType: "JSON",
          cache:false,
          data: {},
          beforeSend:function () { 
          },
          success:function(data) {
            console.log(data);
           liste_valide();
           liste_nouveau();
           liste_rejette();
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