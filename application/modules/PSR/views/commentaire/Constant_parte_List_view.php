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
              <div class="col-md-8">
                 <h4 class="m-0"><?= $title ?></h4>
             </div>
            <!--  <div class="col-md-2">
               <a href="#" id="1" onclick='liste_noTraite()'style="width: 100px;" class='btn btn-outline-primary'>
                  Nouveau 
                  <span class="badge badge-danger"><?=$Nbre_transmis?></span>
                  
                </a>
             </div> -->
              <div class="col-md-2">
               <a href="#" onclick='liste_noTraite()' id="1"  style="width: 100px;" class='btn btn-outline-primary'>
                  Nouveau 
                  <span id="nouveauParte" class="badge badge-danger"><?=$Nbre_transmis?></span>
                  
                </a>
             </div>
             <div class="col-md-2">
               <a href="#" id="2" onclick='liste_valide()' style="width:  100px;" class='btn btn-outline-primary'>
                 Transmis
                  <span id="transParte" class="badge badge-danger"><?=$Nbre_retours?></span>
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
                      <div class="form-group col-md-2">
                          <label>Du</label>
                         <input type="date" class="form-control input-sm" onchange="onSelected();" name="DATE_UNE" id="DATE_UNE" value="<?=set_value('DATE_UNE')?>" >
                      </div>  
                      <div class="form-group col-md-2">
                        <label>Au</label>

                         <input type="date"  class="form-control input-sm" onchange="onSelected();" name="DATE_DEUX" id="DATE_DEUX" min="<?=set_value('DATE_UNE')?>" value="<?=set_value('DATE_DEUX')?> " >

                      </div>
                    </div>
                   <div id="constant_nouvau">
                    <!-- <div class="row" >
                    <div class="col-md-1">
                      <input type="checkbox" name="COMMENTAIRE_ID_ASSURANCE" onchange="cocher_all()">
                      <label>Tout</label>
                    </div>
                    <div class="col-md-2">
                       <button id='selections' onclick='envoyer_all()' class='btn btn-primary btn-sm' disabled>
                        <span class="badge badge-danger" id="nombres">0</span>
                          Sélectionnés
                        </button>
                    </div>
                   </div> -->
                      <table id='constantnouv' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                       <thead id="thead">
                          <tr>
                           <th>CONCERNE</th>
                        <th >PROPRIETAIRE</th>
                        <th >POSTE DE CONTROLE</th>
                        <th >TYPE DE VERIFICATION</th>
                        <th >PEINE</th>
                        <th >CONSTANT</th>
                        <th >PHOTO</th>
                        <th >DATE DE TRAITEMENT </th>
                        <th data-orderable="false">OPTIONS</th>
                          </tr>
                        </thead>
                      </table>
                   </div>
                    <div id="constant_transmis" style="display: none;">
                       <table id='constanttra' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                       <thead >
                         <tr>
                          <th>CONCERNE</th>
                          <th>COMMENTAIRE</th>
                          <th>PHOTO</th>
                          <th>AVIS</th>
                          <th>MOTIF</th>
                          <th>DATE DE TRAITEMENT</th>
                          <th>DATE AVIS</th>
                        </tr>
                      </thead>
                      </table>
                    </div>

                 <!--  <div id='avis'>
                    <table style="width: 100%;" class="table table-bordered table-striped table-hover table-condensed" >
                    <thead>
                      <tr>
                        <th>CONCERNE</th>
                         <th>COMMENTAIRE</th>
                         <th>PHOTOxcghjklm</th>
                         <th>DATE DE CONTRAVATION</th>
                         <th>OPTONS</th>
                      </tr>
                    </thead>
                  </table>
                  </div> -->
                  
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
                        <th>ASSUREUR</th>
                        <th>AVIS DU PARTENAIRE</th>
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
     <div class='modal fade' id='myFormAssuranc'>
          <div class='modal-dialog'>
          <div class='modal-content'>
            <div class="modal-header" style="background: black;">
            <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;">Avis après la vérification en interne</h4>
            </div>
            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
          <div class='modal-body'>
           <form id='myFormAssurance' action="<?= base_url('PSR/Commentaire/save') ?>" method='post' autocomplete='off'>
            <div class="form-group">
              <label>Avis</label>
              <?= $Avis_partenaire ?>
            </div>
          <div class="form-group">
          <label for="exampleFormControlTextarea1">Commentaire</label>
           <textarea name='motifAssurance' id='motifPartenaire' class="form-control" id="MessageText" rows="3" placeholder="..."></textarea>
              <input type="hidden" name="type_verif_id" id="type_verif_id">

         </div>

          </div>
          <div class='modal-footer'>
          <button type='button' onclick='save_all_assurance()' class='btn btn-primary btn-md' >Envoyer</button> </form> 
          <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
          </div>
          </div>
          </div>
          </div>
</html>

<script type="text/javascript">
 $(document).ready(function() {
    liste_noTraite();
  });

  function isChicked(id,id1)
  {
    // $('#myForm'+id).submit()
    $("button1").html("<a  onclick='isChicked("+id+","+id1+")'class='btn btn-primary' href='#' data-toggle='modal' data-target='#mydelete" +id1+ "'><font class='text-info'>&nbsp;&nbsp;Aviser</font></a>");
  }
  
  function liste_noTraite()
  {
     var btn1=document.getElementById("1")
    var btn2=document.getElementById("2")
 
    btn1.className = "btn btn-primary";
    btn2.className = "btn btn-outline-primary";
    $("#constant_nouvau").show()
    $("#constant_transmis").hide()
  $('#message').delay('slow').fadeOut(3000);
  $("#constantnouv").DataTable(
  {
  "destroy" : true,
  "processing":true,
  "serverSide":true,
  "order":[[3,'DESC']],
  "ajax":{
  url: "<?php echo base_url('PSR/Commentaire/constant_noTraite/'); ?>",
  type:"POST",
  data : { 
         DATE_UNE : $('#DATE_UNE').val(),
         DATE_DEUX : $('#DATE_DEUX').val()},
  beforeSend : function() {
  }
  },
   "drawCallback": function(settings) {
         console.log(settings.json.recordsFiltered)
         $("#nouveauParte").html(settings.json.recordsFiltered)

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
 
  btn1.className = "btn btn-outline-primary";
  btn2.className = "btn btn-primary";
   $("#constant_nouvau").hide()
    $("#constant_transmis").show()
  $('#message').delay('slow').fadeOut(3000);
  $("#constanttra").DataTable(
  {
  "destroy" : true,
  "processing":true,
  "serverSide":true,
  "order":[[6,'DESC']],
  "ajax":{
  url: "<?php echo base_url('PSR/Commentaire/constant_avis_parte/'); ?>",
  type:"POST",
  data : { 
         DATE_UNE : $('#DATE_UNE').val(),
         DATE_DEUX : $('#DATE_DEUX').val()},
  beforeSend : function() {
  }
  },
  "drawCallback": function(settings) {
         console.log(settings.json.recordsFiltered)
         $("#transParte").html(settings.json.recordsFiltered)

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
  function getDetail_constant(id = 0,date=null,plaque=null) 
  {
    $('#detail').modal()
    $("#donneTitre").html("Verification du plaque  "+plaque+"               "+date);
            var row_count ="1000000";
            $("#mytable").DataTable({
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
  function cocher_all(){
     const firstInputs = document.getElementsByName('COMMENTAIRE_ID_ASSURANCE');
     var i = 0;
            if (firstInputs[0].checked) {
                $("input[name=COMMENTAIRE_ID_ASSURANCE]").each(function() {
               this.checked = true; 
                   if (this.value > 0) {
                      i++
                      // console.log(this.value)
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
    
          $('#nombres').html(i)
 }
function one_checked(){
   var i = 0;
   $("input[name=COMMENTAIRE_ID_ASSURANCE]").each(function() {
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
    $('#nombres').html(i) 
    
 }
function save_all_assurance(){
   var i = 0;
   var ID_AVIS = $('#avisePartenaire').val();
   var MOTIF = $('#motifPartenaire').val();
   const donne= [];
   $("input[name=COMMENTAIRE_ID_ASSURANCE]").each(function() {
      if (this.checked == true && this.value > 0) {
        donne.push(this.value)
      }
     });
   if (ID_AVIS == '' ) {
      $('#avisePartenaire').focus()
   }else{
         Swal.fire({
            title: 'Souhaitez-vous conclure ces constants sélectionnés?',
            showDenyButton: true,
            // showCancelButton: true,
           confirmButtonText: 'Maintenant',
          denyButtonText: `Pas maintenant`,

          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              

            /* Debut ajax*/
               $.ajax({
                url : "<?=base_url()?>PSR/Commentaire/avise_all/",
                type : "POST",
                dataType: "JSON",
                cache:false,
                data: {
                     HISTO_COMMENTAIRE_ID:donne,
                     ID_AVIS:ID_AVIS,
                      MOTIF:MOTIF},
                beforeSend:function () { 

                },
                success:function(data) {
                  $('#nombress').html(0)
                  Swal.fire('Confirmé!', '', 'success')
                  $('#myFormAssurance').modal('hide');
                   liste_noTraite();
                },
                error:function() {
                 
                  Swal.fire('Erreur de la connexion', '', 'info')
                   $('#myFormAssurance').modal('hide');
                   liste_noTraite();
                  console.log(data);
                   
                }
            });

              
            } else if (result.isDenied) {
              Swal.fire('Non Confirmé', '', 'info')
            }
          })

      }

}
function envoyer_all(){
        $('#myFormAssurance').modal()
 }
 function subFormAssur(id)
  { 
    $('#myFormAss'+id).submit()
  }
  function save_all_assur(id){
   var ID_AVIS = $('#avise'+id).val()
   var MOTIF = $('#motif'+id).val();
   const donne= [];
  donne.push(id)
   if (ID_AVIS == '') {
      $('#ID_AVIS_PARTENAIRE').focus()
   }else{
         Swal.fire({
            title: 'Souhaitez-vous conclure ce constant sélectionné?',
            showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: 'Maintenant',
            denyButtonText: `Pas maintenant`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              

            /* Debut ajax*/
               $.ajax({
                url : "<?=base_url()?>PSR/Commentaire/avise_all/",
                type : "POST",
                dataType: "JSON",
                cache:false,
                data: {
                     HISTO_COMMENTAIRE_ID:donne,
                     ID_AVIS:ID_AVIS,
                      MOTIF:MOTIF},
                beforeSend:function () { 
                 
                },
                success:function(data) {
                  console.log(data);
                  $('#nombress').html(0)
                  $('#institution'+id).modal('hide');
                  liste_valide();
                  liste_noTraite()
                  Swal.fire('Confirmé!', '', 'success')
                },
                error:function() {
                  Swal.fire('Erreur de la connexion', '', 'info')
                   $('#myFormInstution').modal('hide');
                  liste_noTraite()
                }
            });

              
            } else if (result.isDenied) {
              Swal.fire('Non Confirmé', '', 'info')
            }
          })

      }
}
function onSelected()
{
   let DATE_UNE=  $('#DATE_UNE').val()
   document.getElementById("DATE_DEUX").setAttribute("min", DATE_UNE); 
   liste_valide();
   liste_noTraite();
}
  </script>