<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>

    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
           <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

<style type="text/css">
  .mapbox-improve-map {
    display: none;
  }

  .leafvar-control-attribution {
    display: none !important;
  }

  .leafvar-control-attribution {
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
             
            <div class="col-sm-12 text-left">
            <div class="row" id="envoyer">
              <div class="col-md-3">
                 <h4 class="m-0"><?= $title ?></h4>
             </div>

             <div class="col-md-1">
               <a href="#" id="5" onclick='liste()' class='btn btn-primary btn-sm'>
                  Nouveau
                  <span id="nnouveau" class="badge badge-danger"><?=$Nbre_nouveau?></span>
                </a>
             </div>
             <div class="col-md-1">
               <a href="#"  id="3" onclick='liste_encours()' class='btn btn-outline-primary '>
                  Transmis 
                  <span  id="ttransmis" class="badge badge-danger"><?=$Nbre_encours?></span>
             </a>
             </div>
             <div class="col-md-1">
               <a href="#"  id="4" onclick='liste_valide()'  class='btn btn-outline-primary '>
                 Retours
                  <span id="rretours" class="badge badge-danger"><?=$Nbre_avis?></span>
                </a>
             </div>
            <div class="col-md-1">
               <a href="#" id="1" onclick='liste_maintenir()'    class='btn btn-primary '>
                  Rejetés
                  <span id="rrejetter" class="badge badge-danger"><?=$Nbre_maintenir?></span>
                </a>
             </div>
              <div class="col-md-1">
               <a href="#" id="2" onclick='lister_annuler()'  class='btn btn-primary'>
                  Approuvés
                  <span id="aapprouver" class="badge badge-danger"><?=$Nbre_canceler?></span>

                </a>
             </div>
             <div class="col-md-2" >
               
             </div>
             <div class="col-md-2 text-left">
               <!--  <div style="float:right ;">
                  <label>Type de verification</label><br>
                       <select class="form-control input-sm" name="typeVerification" id="typeVerification" onchange='onSelected()'>
                          <option value="">Sélectionner</option>
                          <?php foreach ($type_verification as $key) { ?>
                            <option value="<?php echo $key['ID_TYPE_VERIFICATION'] ?>"><?php echo  $key['VERIFICATION'] ?></option>
                          <?php } ?>
                        </select> 
                  </div> -->
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
                      <div class="form-group col-md-2">
                          <label>Du</label>
                         <input type="date" class="form-control input-sm" onchange="onSelected();" name="DATE_UNE" id="DATE_UNE" value="<?=set_value('DATE_UNE')?>" >
                      </div>  
                      <div class="form-group col-md-2">
                        <label>Au</label>

                         <input type="date"  class="form-control input-sm" onchange="onSelected();" name="DATE_DEUX" id="DATE_DEUX" min="<?=set_value('DATE_UNE')?>" value="<?=set_value('DATE_DEUX')?> " >

                      </div>
                      <div class="form-group col-md-2"></div>
                      <div class="form-group col-md-6">
                         <div style="float:right ;">
                         <label>Type de vérification</label><br>
                         <select class="form-control input-sm" name="typeVerification" id="typeVerification" onchange='onSelected()'>
                          <option value="">Sélectionner</option>
                          <?php foreach ($type_verification as $key) { ?>
                            <option value="<?php echo $key['ID_TYPE_VERIFICATION'] ?>"><?php echo  $key['VERIFICATION'] ?></option>
                          <?php } ?>
                        </select> 
                  </div>
                      </div>
                    </div>
                 <div id="constantvcont" style="display: none;">

                   <div class="row" >
                    <div class="col-md-3">
                      <input type="checkbox" name="CONSTAT_ID" onchange="cocher_aull()">
                      <label>Cocher tout</label>
                    </div>

                    <div class="col-md-2">
                       <button id="selections" onclick='save_alls()' class='btn btn-primary btn-sm' disabled>
                        <span class="badge badge-danger" id="nombress">0</span>
                          Soumettre
                        </button>
                    </div>

                   </div>

                  <table id='constant_retours' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
  
                     <thead>
                      <tr>
                      <th></th>
                      <th>CONCERNE</th> 
                      <th>TYPE DE VERIFICATION</th>
                      <th>INSTITUTION</th> 
                      <!-- <th>COMMENTAIRE</th> -->
                      <th>STATUT DU TRAITEMENT</th>
                      <!-- <th>UTILISATEUR</th> -->
                      <th>DATE DE TRAITEMENT </th>
                      <th>OPTIONS</th>

                  </table>
                 
                 </div>
                  <div id="constantListing" style="display: none;">
                  <table id='constantnouveau' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    
                     <thead>
                     <tr>
                        <th>CONCERNE</th>
                        <th >PROPRIETAIRE</th>
                        <th >POSTE DE CONTROLE</th>
                        <th >TYPE DE VERIFICATION</th>
                        <th >PEINE</th>
                        <th >CONSTAT</th>
                        <th >PHOTO</th>
                        <th >DATE DE TRAITEMENT </th>
                        <th data-orderable="false">OPTIONS</th>

                      </tr></thead>
                  </table>
                 </div>
                 <div id='constantcont'>
                  <table id='constant' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    
                     <thead> 
                        <tr>
                          <th>CONCERNE</th>
                        <th >PROPRIETAIRE</th>
                        <th >POSTE DE CONTROLE</th>
                        <th >TYPE DE VERIFICATION</th>
                        <th >INSTITUTION</th>
                        <th >PEINE</th>
                        <th >CONSTAT</th>
                        <th >PHOTO</th>
                        <th >DATE DE TRAITEMENT </th>
                        </tr>
                      </thead>
                  </table>
                 </div>
                  <div id='constantcontV' style="display: none;">
                  <table id='constantV' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    
                     <thead> 
                        <tr>
                          <th>CONCERNE</th> 
                          <th>TYPE DE VERIFICATION</th> 
                          <th>INSTITUTION</th>
                          <th>CONSTAT</th>
                          <th>AVIS</th>
                          <th>MOTIF</th>
                          <th>STATUT DU TRAITEMENT</th>
                          <th>DATE DE TRAITEMENT</th>
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
    <div class="modal fade" id="detailControl">
       <div class="modal-dialog modal-lg" >
         <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;"></h4>
              <input type="hidden" name="type_verif_id" id="type_verif_id">
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
                        <th></th>
                        <th>COMMENTAIRE</th>
                        <th>PHOTO</th>
                        <!-- <th data-orderable="false">OPTIONS</th> -->
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
   <div class="modal fade" id="detail">
       <div class="modal-dialog modal-lg" >
         <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;"></h4>

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
                        <th>INSTITUTION</th>
                        <th>AVIS DU INSTITUTION</th>
                        <th>DATE DE TRAITEMENT</th>
                      </tr>
                    </thead>
                  </table>
            </div>
      </div>
      <div class="modal-footer"> 
           <!--  <button id="btn_quiter" type="button" class="btn btn-primary" class='close' data-dismiss='modal'>Quitter</button> -->
      </div>
    </div>
  </div>
  </div>



  </div>
  </div>
  </div>
  <!-- /.content -->
</div>
</div>

<div class="modal fade" id="detailControl_transmis">
       <div class="modal-dialog modal-lg" >
         <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <div id="title"><b><h4 id="donneTitre_transmis" style="color:#fff;font-size: 18px;"></h4>

            </div>

            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
         <div class="modal-body">
           <div class="col-md-12">
                  <table id='mytable_transmis' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>NUMER</th>
                        <th>COMMENTAIRE</th>
                        <th>AVIS</th>
                        <th>MOTIF</th>
                        <th>PHOTO</th>
                        <th>DATE DE TRAITEMENT</th>
                      </tr>
                    </thead>
                  </table>
            </div>
      </div>
      <div class="modal-footer"> 
           <!--  <button id="btn_quiter" type="button" class="btn btn-primary" class='close' data-dismiss='modal'>Quitter</button> -->
      </div>
    </div>
  </div>
  </div>
   <div class="modal fade" id="detail">
       <div class="modal-dialog modal-lg" >
         <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;"></h4>

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
                        <th>INSTITUTION</th>
                        <th>AVIS DU INSTITUTION</th>
                        <th>DATE DE TRAITEMENT</th>
                      </tr>
                    </thead>
                  </table>
            </div>
      </div>
      <div class="modal-footer"> 
           <!--  <button id="btn_quiter" type="button" class="btn btn-primary" class='close' data-dismiss='modal'>Quitter</button> -->
      </div>
    </div>
  </div>
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
function envoyer_all_assur(id){
   var i = 0;
   var assureurId = $('#assureurIds'+id).val();
   var histo_commentaire_id = $('#histo_commentaire_id').val();
   const donne= [];
        donne.push(histo_commentaire_id)
   if (assureurId == '') {
      $('#assureurId').focus()
   }else{
         Swal.fire({
            title: 'Souhaitez-vous envoyer ce constat sélectionné?',
            showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: 'Maintenant',
            denyButtonText: `Pas maintenant`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              

            /* Debut ajax*/
               $.ajax({
                url : "<?=base_url()?>PSR/Commentaire/envoyer_all_assur/",
                type : "POST",
                dataType: "JSON",
                cache:false,
                data: {HISTO_COMMENTAIRE_ID:donne,
                      ID_ASSUREUR:assureurId},
                beforeSend:function () { 
                 
                },
                success:function(data) {
                  console.log(data);
                  $('#nombress').html(0)
                  Swal.fire('Confirmé!', '', 'success')
                  liste_valide()
                   $('#myAssurance').modal('hide')
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
function supprimer(id){
         Swal.fire({
            title: 'Souhaitez-vous supprimer ce constats sélectionné?',
            showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: 'Maintenant',
            denyButtonText: `Pas maintenant`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              

            /* Debut ajax*/
               $.ajax({
                url : "<?=base_url()?>PSR/Commentaire/supprimer/"+id,
                type : "POST",
                dataType: "JSON",
                cache:false,
                data: {HISTO_COMMENTAIRE_ID:donne,
                      ID_ASSUREUR:assureurId},
                beforeSend:function () { 
                 
                },
                success:function(data) {
                  console.log(data);
                  $('#nombress').html(0)
                  Swal.fire('Confirmé!', '', 'success')
                  liste_valide()
                   $('#myFormAssureur').modal('hide')
                  $('#detailControl').modal('hide')


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

 function save_all(id){

   Swal.fire({
      title: 'Souhaitez-vous conclure ce constat sélectionné?',
      showDenyButton: true,
      // showCancelButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        

      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>PSR/Commentaire/save_all/",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {ID_COMMENTAIRE_VERIFICATION:id},
          beforeSend:function () { 
           
          },
          success:function(data) {
            console.log(data);
            lister_annuler()
            liste_encours()
            liste_maintenir()
            liste()
            liste_valide()
            $('#nombress').html(0)
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

 function one_check(){
   var i = 0;
   $("input[name=CONSTAT_ID]").each(function() {
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

 function cocher_aull(){
     const firstInput = document.getElementsByName('CONSTAT_ID');
     var i = 0;
            if (firstInput[0].checked) {
                $("input[name=CONSTAT_ID]").each(function() {
               this.checked = true; 
                   if (this.value > 0) {
                      i++
                      console.log(this.value)
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

  function add_all(){
   var i = 0;
   const donne= [];
   $("input[name=CONSTAT_ID]").each(function() {
      if (this.checked == true && this.value > 0) {
        donne.push(this.value)
      
      }
    
     });
   $.ajax({
          url : "<?=base_url()?>PSR/Commentaire/add_all/",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {ID_COMMENTAIRE_VERIFICATION:donne},
          beforeSend:function () { 
           
          },
          success:function(data) {
            console.log(data);
            liste_valide()
            $('#nombress').html(0)
          },
          error:function() {
            
          }
      });

 }
 function cocher_all(){
     const firstInputs = document.getElementsByName('COMMENTAIRE_ID');
     var i = 0;
            if (firstInputs[0].checked) {
                $("input[name=COMMENTAIRE_ID]").each(function() {
               this.checked = true; 
                   if (this.value > 0) {
                      i++
                      console.log(this.value)
                   }
                                      
            });
            }else{
               $(':checkbox').each(function() {
               this.checked = false;                       
            });
          }
        if(i>0){
              $('#selectionse').prop('disabled',false)
            }
            else{
              $('#selectionse').prop('disabled',true)
            }
          $('#nombres').html(i)
         
 }
function one_checked(){
   var i = 0;
   $("input[name=COMMENTAIRE_ID]").each(function() {
      if (this.checked == true && this.value > 0) {
      i++  
      }
     });
    $('#nombres').html(i) 
    if(i>0){
              $('#selectionse').prop('disabled',false)
            }
            else{
              $('#selectionse').prop('disabled',true)
            }
    
 }

function onSelected()
{
  lister_annuler()
  liste_encours()
  liste_valide()
  liste_maintenir()
  liste()
}
function liste()
  {
    
     var btn1=document.getElementById("1")
     var btn2=document.getElementById("2")
     var btn3=document.getElementById("3")
     var btn4=document.getElementById("4")
     var btn5=document.getElementById("5")

    btn1.className = "btn btn-outline-primary";
    btn2.className = "btn btn-outline-primary";
    btn3.className = "btn btn-outline-primary";
    btn4.className = "btn btn-outline-primary";
    btn5.className = "btn btn-primary";

    $("#constantListing").show()
    $("#constantcont").hide()
    $("#constantvcont").hide()
    $("#constantcontV").hide()



    $('#message').delay('slow').fadeOut(3000);
    $("#constantnouveau").DataTable(
     {
    "destroy" : true,
    "processing":true,
    "serverSide":true,
    "order":[[5,'DESC']],
    "ajax":{
    url: "<?php echo base_url('PSR/Commentaire/constant_nouveau/'); ?>",
    type:"POST",
    data : {
          typeVerification : $('#typeVerification').val(),
         DATE_UNE : $('#DATE_UNE').val(),
         
         DATE_DEUX : $('#DATE_DEUX').val(),
         DATE_UNE : $('#DATE_UNE').val(),
         
         DATE_DEUX : $('#DATE_DEUX').val(),
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
    "orderable":false,
    "visible": true
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
  function liste_maintenir()
  {
   
    $("#constantListing").hide()
    $("#constantcont").hide()
    $("#constantcontV").show()
    $("#constantvcont").hide()

     var btn1=document.getElementById("1")
     var btn2=document.getElementById("2")
     var btn3=document.getElementById("3")
     var btn4=document.getElementById("4")
     var btn5=document.getElementById("5")

    btn1.className = "btn btn-primary";
    btn2.className = "btn btn-outline-primary";
    btn3.className = "btn btn-outline-primary";
    btn4.className = "btn btn-outline-primary";
    btn5.className = "btn btn-outline-primary";

    $('#message').delay('slow').fadeOut(3000);
    $("#constantV").DataTable(
    {
        "destroy" : true,
        "processing":true,
        "serverSide":true,
        "order":[[6,'DESC']],
        "ajax":{
        url: "<?php echo base_url('PSR/Commentaire/constant_maintenir/'); ?>",
        type:"POST",
        data : {
         typeVerification : $('#typeVerification').val(),
         DATE_UNE : $('#DATE_UNE').val(),
         DATE_DEUX : $('#DATE_DEUX').val(),
        },
        beforeSend : function() {
        }
        },
        "drawCallback": function(settings) {
         console.log(settings.json.recordsFiltered)
         $("#rrejetter").html(settings.json.recordsFiltered)

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

 function lister_annuler()
  {
    $("#constantListing").hide()
    $("#constantcont").hide()
    $("#constantcontV").show()
    $("#constantvcont").hide()

    var btn1=document.getElementById("1")
    var btn2=document.getElementById("2")
    var btn3=document.getElementById("3")
    var btn4=document.getElementById("4")
    var btn5=document.getElementById("5")

    btn1.className = "btn btn-outline-primary";
    btn2.className = "btn btn-primary";
    btn3.className = "btn btn-outline-primary";
    btn4.className = "btn btn-outline-primary";
    btn5.className = "btn btn-outline-primary";

    $('#message').delay('slow').fadeOut(3000);
    $("#constantV").DataTable(
    {
        "destroy" : true,
        "processing":true,
        "serverSide":true,
        "order":[[6,'DESC']],
        "ajax":{
        url: "<?php echo base_url('PSR/Commentaire/constant_annuler/'); ?>",
        type:"POST",
        data : {
        typeVerification : $('#typeVerification').val(),
         DATE_UNE : $('#DATE_UNE').val(),
         DATE_DEUX : $('#DATE_DEUX').val(),
        },
        beforeSend : function() {
        }
        }
        ,
          "drawCallback": function(settings) {
           console.log(settings.json.recordsFiltered)
           $("#aapprouver").html(settings.json.recordsFiltered)

        },
        lengthMenu: [[10,50, 100, -1], [10,50, 100, "All"]],
        pageLength: 10,
        "columnDefs":[{
        "targets":[],
        "orderable":true
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

  function liste_encours()
  {
    $("#constantvcont").hide()
    $("#constantcontV").hide()
    $("#constantcont").show()
    $("#constantListing").hide()

    
    var btn1=document.getElementById("1")
    var btn2=document.getElementById("2")
    var btn3=document.getElementById("3")
    var btn4=document.getElementById("4")
    var btn5=document.getElementById("5")

    btn1.className = "btn btn-outline-primary";
    btn2.className = "btn btn-outline-primary";
    btn3.className = "btn btn-primary";
    btn4.className = "btn btn-outline-primary";
    btn5.className = "btn btn-outline-primary";

    $('#message').delay('slow').fadeOut(3000);
    $("#constant").DataTable(
      {
      "destroy" : true,
      "processing":true,
      "serverSide":true,
         "order":[[8,'DESC']],
      "ajax":{
      url: "<?php echo base_url('PSR/Commentaire/constant_encours/'); ?>",
      type:"POST",
      data : {
         typeVerification : $('#typeVerification').val(),
         DATE_UNE : $('#DATE_UNE').val(),
         DATE_DEUX : $('#DATE_DEUX').val(),
        },
      beforeSend : function() {
      }
      },
        "drawCallback": function(settings) {
         console.log(settings.json.recordsFiltered)
         $("#ttransmis").html(settings.json.recordsFiltered)

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
    $("#constantListing").hide()
    $("#constantcont").hide()
    $("#constantcontV").hide()
    $("#constantvcont").show()

    var btn1=document.getElementById("1")
    var btn2=document.getElementById("2")
    var btn3=document.getElementById("3")
    var btn4=document.getElementById("4")
    var btn5=document.getElementById("5")

    btn1.className = "btn btn-outline-primary";
    btn2.className = "btn btn-outline-primary";
    btn3.className = "btn btn-outline-primary";
    btn4.className = "btn btn-primary";
    btn5.className = "btn btn-outline-primary";

    $('#message').delay('slow').fadeOut(3000);
    $("#constant_retours").DataTable(
    {
        "destroy" : true,
        "processing":true,
        "serverSide":true,
        "order":[[5,'DESC']],
        "ajax":{
        url: "<?php echo base_url('PSR/Commentaire/constant_valide/'); ?>",
        type:"POST",
        data : {
                   typeVerification : $('#typeVerification').val(),
         DATE_UNE : $('#DATE_UNE').val(),
         
         DATE_DEUX : $('#DATE_DEUX').val(),
        },
        beforeSend : function() {
        }
        },
          "drawCallback": function(settings) {
           console.log(settings.json.recordsFiltered)
           $("#rretours").html(settings.json.recordsFiltered)

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

    // one_check()
 }
 function subForm(id)
 {
    Swal.fire({
      title: 'Souhaitez-vous consulter l\'avis du  partenaire pour le traitement de ce constat?',
      showDenyButton: true,
      // showCancelButton: true,
      confirmButtonText: 'oui',
      denyButtonText: `Non`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $('#myForm'+id).submit()
        Swal.fire('Confirmé!', '', 'success')
      } else if (result.isDenied) {
        Swal.fire('Non Confirmé', '', 'info')
      }
    })
    
 }
function maintenir_direct(id,id_histo,id_type){
    Swal.fire({
      title: 'Souhaitez-vous approuver ce constat?',
      showDenyButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>PSR/Commentaire/approuver/"+id+"/"+id_histo+"/"+id_type,
          type : "PUT",
          dataType: "JSON",
          cache:false,
          data: {},
          beforeSend:function () { 
           
          },
          success:function(data) {
            console.log(data);
            lister_annuler()
            liste_encours()
            liste_maintenir()
            liste()
            liste_valide()
            $('#nombress').html(0)
            $('#detailControl').modal('hide')
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
 
  function subForm_inst(id)
 {
    Swal.fire({
      title: 'Souhaitez-vous conclure ce constat sélectionné?',
      showDenyButton: true,
      // showCancelButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $('#subForm_inst'+id).submit()
        Swal.fire('Confirmé!', '', 'success')
      } else if (result.isDenied) {
        Swal.fire('Non Confirmé', '', 'info')
      }
    })
    
 }
function save_alls(){

   var i = 0;
   const donne= [];
   $("input[name=CONSTAT_ID]").each(function() {
      if (this.checked == true && this.value > 0) {
        donne.push(this.value)
      
      }
    
     });
   Swal.fire({
      title: 'Souhaitez-vous conclure ces constats sélectionnés?',
      showDenyButton: true,
      // showCancelButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        

      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>PSR/Commentaire/save_alls/",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {ID_COMMENTAIRE_VERIFICATION:donne},
          beforeSend:function () { 
           
          },
          success:function(data) {
            console.log(data);
            lister_annuler()
            liste_encours()
            liste_maintenir()
            liste()
            liste_valide()
            $('#selections').prop('disabled',true)
            const firstInput = document.getElementsByName('CONSTAT_ID');
            if (firstInput[0].checked) {
                $("input[name=CONSTAT_ID]").each(function() {
               this.checked = false;                      
            });
            }
            $('#nombress').html(0)
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
function envoyer_all(ID_TYPE_VERIFICATION,HISTO_COMMENTAIRE_ID){

   if (ID_TYPE_VERIFICATION == 2) {
      $('#myFormAssureur').modal()
      
   }else{

   var i = 0;
   const donne= [];
    donne.push(HISTO_COMMENTAIRE_ID)
    Swal.fire({
      title: 'Souhaitez-vous envoyer ce constat sélectionné?',
      showDenyButton: true,
      // showCancelButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>PSR/Commentaire/envoyer_all/",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {HISTO_ID_COMMENTAIRE:donne},
          beforeSend:function () { 
           
          },
          success:function(data) {
            console.log(data);
            liste_valide()
            $('#nombress').html(0)
            $('#detailControl').modal('hide')
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

  }

    //Fin ajax

 }
 function supprimer(id){
    Swal.fire({
      title: 'Souhaitez-vous Supprimer  ce constat sélectionné?',
      showDenyButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>PSR/Commentaire/supprimer/"+id,
          type : "DELETE",
          dataType: "JSON",
          cache:false,
          data: {},
          beforeSend:function () { 
           
          },
          success:function(data) {
            console.log(data);
            lister_annuler()
            liste_encours()
            liste_maintenir()
            liste_valide()
            liste()
            $('#nombress').html(0)
            $('#detailControl').modal('hide')
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
 function getDetail(id = 0,verification=0,date=null, plaque=null) 
 {
    $('#detailControl').modal()

    $('#type_verif_id').val(verification)
    
    if(verification==1)
    {
      $("#donneTitre").html("Constat pour Contrôle immatriculation "+plaque+"               "+date);
    }
    else if(verification==2)
    {
     $("#donneTitre").html("Constat pour  Contrôle assurance "+plaque+"               "+date);
    }
    else if(verification==3)
    {
     $("#donneTitre").html("constat pour Contrôle technique "+plaque+"               "+date);
    }
    else if(verification==4)
    {
     $("#donneTitre").html("Contrôle permis de transport "+plaque+"               "+date);
    }
     else if(verification==6 )
    {
     $("#donneTitre").html("Controle technique "+plaque+"               "+date);
    }
    var row_count ="1000000";
    $("#mytable").DataTable(
    {
        "processing":true,
        "serverSide":true,
        "bDestroy": true,
        "oreder":[],
        "ajax":
        {
        url : "<?=base_url()?>PSR/Commentaire/detail/"+id+"/"+verification,      
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
function getDetail_transmis(id = 0,verification=0,date=null, plaque=null) 
 {
    $('#detailControl_transmis').modal()
    if(verification==1)
    {
      $("#donneTitre_transmis").html("Constat pour Contrôle immatriculation "+plaque+"               "+date);
    }
    else if(verification==2)
    {
     $("#donneTitre_transmis").html("Constat pour  Contrôle assurance "+plaque+"               "+date);
    }
    else if(verification==3)
    {
     $("#donneTitre").html("constat pour Contrôle technique "+plaque+"               "+date);
    }
    else if(verification==4)
    {
     $("#donneTitre_transmis").html("Contrôle permis de transport "+plaque+"               "+date);
    }
     else if(verification==6 )
    {
     $("#donneTitre_transmis").html("Controle technique "+plaque+"               "+date);
    }
    var row_count ="1000000";
    $("#mytable_transmis").DataTable(
    {
        "processing":true,
        "serverSide":true,
        "bDestroy": true,
        "oreder":[],
        "ajax":
        {
        url : "<?=base_url()?>PSR/Commentaire/detail_transmis/"+id+"/"+verification,      
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

  function getDetail_constant(id = 0,date=null,plaque=null) 
  {
    $('#detail').modal()
    $("#donneTitre").html("Verification du plaque  "+plaque+"               "+date);
    var row_count ="1000000";
    $("#mytable").DataTable(
    {
        "processing":true,
        "serverSide":true,
        "bDestroy": true,
        "oreder":[],
        "ajax":
        {
        url : "<?=base_url()?>PSR/Commentaire/detail_const/"+id,      
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
  </script>



<div class='modal fade' id='myAlerte'>
          <div class='modal-dialog'>
          <div class='modal-content'>
          <div class='modal-body'>
            <h4>Voulez-vous confirmer cette requette?</h4>
            
          </div>
          <div class='modal-footer'>
          <button type='button' onclick='subForm()' class='btn btn-primary btn-md' >Envoyer</button> </form> 
          <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
          </div>
          </div>
          </div>
          </div>";