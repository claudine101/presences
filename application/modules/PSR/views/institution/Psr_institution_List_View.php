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
            <div class="col-sm-8">
              <h4 class="m-0"><?=$title?></h4>
            </div><!-- /.col -->
            <div class="col-sm-4 text-right">
             <span style="margin-right: 15px" class="col-md-12 row">
                     <div class="col-md-7">
                          <select class="form-control"  onchange="liste()" name="STATUT" id="STATUT">
                                    <option value="">Sélectionner</option>
                                    <?php
                                    $select="";
                                    foreach($statuts as $key=>$value){
                                    
                                    ?>
                                    <option  value="<?=$value?>"><?=$key?></option>
                                    <?php } ?>
                              </select>
                      </div>
                      <div class="col-md-2"></div>
                      <div class="col-md-3" style="float:right;">
                        <a href="<?=base_url('PSR/Psr_institution/ajouter')?>" style="width: 100px;" class='btn btn-primary btn-sm float-right'>
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
                        <th>Institution</th>
                        <th>Personne</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th>Active ?</th>
                        <th>Chauffeur</th>
                        <th>Véhicule</th>
                        <th>Amende sur les permis</th>
                        <th>Amende sur les véhicules</th>
                        <th>Date</th>
                        <th data-orderable="false">Options</th>
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
<!-------------------- DEBUT MODAL POUR LISTER  LES chauffeur DANS UN TABLEAU ------------------->
<div class="modal fade" id="chauffeur" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title service" id="staticBackdropLabel"></h4>
        <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
      </div>
      <div class="modal-body">
        <div>
          <table id='mytable_chauffeur' class="table table-bordered table-striped table-hover table-condensed " style="width: 100%;">
            <thead>
             <tr>
                <th>Propriétaire</th>
                <th>Permis</th>
                <th>Points</th>
                <th>Téléphone</th>
                <th>Catégorie</th>
                <th>Institution</th>
                <th>Date de naissance</th>
                <th>Date de livraison</th>
                <th>Date d'expiration</th>
             </tr>
           </thead>
         </table>
       </div>
     </div>
     <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
    </div>
  </div>
  
</div>
</div>

<!---------------------- FIN MODAL POUR LISTER  LES chauffeur DANS UN TABLEAU  ----------- -->

<!-------------------- DEBUT MODAL POUR LISTER  LES VEHICULE  D'UNE INSTITUTION------------------->
<div class="modal fade" id="vehicule" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title service" id="staticBackdropLabel"></h4>
        <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
        </div>
      </div>
      <div class="modal-body">
        <div>
          <table id='mytable_vehicule' class="table table-responsive table-bordered table-striped table-hover table-condensed " style="width: 100%;">
            <thead>
             <tr>
                <th>Propriétaire</th>
                <th>Plaque</th>
                <th>N° Carte rose</th>
                <th>Contact</th>
                <th>Profession</th>
                <th>CNI</th>
                <th>Catégorie</th>
                <th>Marque</th>
                <th>N° Chassis</th>
                <th>Place</th>
                <th>Usage</th>
                <th>Puissance</th>
                <th>Couleur</th>
                <th>Année de fabrication</th>
                <th>Modèle</th>
                <th>Poids</th>
                <th>Carburant</th>
                <th>Taxe DMC</th>
                <th>NIF</th>
                <th>Date de délivrance</th>
             </tr>
           </thead>
         </table>
       </div>
     </div>
     <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
    </div>
  </div>
  
</div>
</div>

<!--FIN MODAL POUR LISTER  LES VEHICULE  D'UNE INSTITUTION-->

<!-- DEBUT MODAL POUR LISTER  LES AMENDES VEHICULE D'UNE INSTITUTION-->
<div class="modal fade" id="modal_amende_vehicule" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
              <div class="modal-content">
                 <div class="modal-header">
                    <h4 class="modal-title service" id="staticBackdropLabel"></h4>
                    <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
                    <input type="hidden" class="form-control" name="ID_INSTITUTION" id="ID_INSTITUTION" value="">
                    <input type="hidden" class="form-control" name="NOM_INSTITUTION" id="NOM_INSTITUTION" value="">
                </div>
                <div class="modal-body">
                  <div>
                      <div class="row">
                          <div class="form-group col-md-3">
                            <label>Du</label>
                            <input type="date" onchange="filter_vehicule()" name="DATE1" id="DATE1" class="form-control" >
                          </div>
                          <div class="form-group col-md-3">
                            <label>au</label>
                            <input type="date" onchange="filter_vehicule()" name="DATE2" id="DATE2" class="form-control" ><!-- onchange="submit()" -->
                          </div>
                          <div class="form-group col-md-3"> 
                            <label>Statut</label>
                            <select class="form-control"  onchange="filter_vehicule()" name="STATUT" id="STATUT">
                                        <option value="">Sélectionner</option>
                                        <?php
                                        $select="";
                                        foreach($paiement as $key=>$value){
                                        
                                        ?>
                                        <option  value="<?=$value?>"><?=$key?></option>
                                        <?php } ?>
                                  </select>
                          </div>
                          <div class="form-group col-md-3">
                              <label>Numéro plaque</label>
                              <div class="input-group">
                               <input autocomplete="off" type="text" class="form-control" name="NUMERO_PLAQUE"  id="NUMERO_PLAQUE"  placeholder="Recherche" value="<?=set_value('NUMERO_PLAQUE')?>">
                              <div class="input-group-prepend">
                              <span class="input-group-text"><a href="javascript:;"  onclick="filter_vehicule()"><i class="fa fa-search" aria-hidden="true"></i></a></span>
                              </div>
                               </div>
                          </div>
                      </div>
                      <table id='amende_vehicule' class="table table-bordered table-striped table-hover table-condensed " style="width: 100%;">
                      <thead>
                        <tr>
                          <th>Agent</th>
                           <th>Date&nbsp;des&nbsp;faits</th>
                            <th>Type</th>
                            <th>Annulé</th>
                            <th>Plaque</th>
                            <th>Permis</th>
                            <th>Amende BIF</th>
                            <th>Statut</th>
                            <th>Options</th>
                        </tr>
                     </thead>
                   </table>
                 </div>
               </div>
               <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              </div>
            </div>
            
          </div>
          </div> 
<!--------------------FIN MODAL POUR LISTER  LES AMENDES VEHICULE D'UNE INSTITUTION------------------->

<!-------------------- DEBUT MODAL POUR LISTER  LES AMENDES PERMIS D'UNE INSTITUTION------------------->
<div class="modal fade" id="modal_amende_permis" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                 <div class="modal-header">
                    <h4 class="modal-title service" id="staticBackdropLabel"></h4>
                    <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                   </div>
                    <input type="hidden" class="form-control" name="ID_INSTITUTION_permis" id="ID_INSTITUTION_permis" value="">
                    <input type="hidden" class="form-control" name="ID_INSTITUTION_permis" id="NOM_INSTITUTION_permis" value="">
                    
                </div>
                <div class="modal-body">
                 <div>
                    <div class="row">
                          <div class="form-group col-md-3">
                            <label>Du</label>
                            <input type="date" onchange="filter_permis()" name="DATE1_permis" id="DATE1_permis" class="form-control" >
                          </div>
                          <div class="form-group col-md-3">
                            <label>au</label>
                            <input type="date" onchange="filter_permis()" name="DATE2_permis" id="DATE2_permis" class="form-control" ><!-- onchange="submit()" -->
                          </div>
                          <div class="form-group col-md-3"> 
                            <label>Statut</label>
                            <select class="form-control"  onchange="filter_permis()" name="STATUT_permis" id="STATUT_permis">
                                        <option value="">Sélectionner</option>
                                        <?php
                                        $select="";
                                        foreach($paiement as $key=>$value){
                                        
                                        ?>
                                        <option  value="<?=$value?>"><?=$key?></option>
                                        <?php } ?>
                                  </select>
                          </div>
                          <div class="form-group col-md-3">
                              <label>Numéro permis</label>
                              <div class="input-group">
                               <input autocomplete="off" type="text" class="form-control" name="NUMERO_PERMIS"  id="NUMERO_PERMIS"  placeholder="Recherche" value="<?=set_value('NUMERO_PERMIS')?>">
                              <div class="input-group-prepend">
                              <span class="input-group-text"><a href="javascript:;"  onclick="filter_permis()"><i class="fa fa-search" aria-hidden="true"></i></a></span>
                              </div>
                               </div>
                          </div>
                      </div>
                    <table id='amende_permis' class="table table-responsive table-striped table-hover table-condensed " style="width: 100%;">
                    
                      <thead>
                       <tr>
                       
                          <th>Agent</th>
                           <th>Date&nbsp;des&nbsp;faits</th>
                            <th>Type</th>
                            <th>Annulé</th>
                            <th>Plaque</th>
                            <th>Permis</th>
                            <th>Points</th>
                            <th>Amende BIF</th>
                            <th>Statut</th>
                            <th data-orderable="false">Options</th>

                       
                       </tr>
                     </thead>
                   </table>
                 </div>
               </div>
               <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              </div>
            </div>
            
          </div>
          </div> 
<!--------------------FIN MODAL POUR LISTER  LES AMENDES PERMIS D'UNE INSTITUTION------------------->

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

</html>
<div id="permis" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <input type="hidden" class="form-control" name="PERMIS" id="PERMIS" value=""> 
            <div id="title"><b><h4 id="permis_titre" style="color:#fff;font-size: 18px;"></h4></b>
              
            </div>
            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
         <div class="modal-body">
          <div  id="permisdata">
            
          </div>
           
    </div>
  </div>
</div>
</div>

<div id="vehicule_detail" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <input type="hidden" class="form-control" name="PLAQUE" id="PLAQUE" value=""> 
            <div id="title"><b><h4 id="vehicule_titre" style="color:#fff;font-size: 18px;"></h4></b>
              
            </div>
            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
         <div class="modal-body">
          <div  id="vehiculedata">
            
          </div>
          
    </div>
  </div>
</div>
</div>

</html>
<script type="text/javascript">
  $(document).ready(function() {
    liste();

  });
  function show_permis(NUMERO_PERMIS = 0){
      
    
       var PERMIS;

       var NUMERO_PERMIS= NUMERO_PERMIS;

       DATE1=  $('#DATE1').val();
       DATE2=  $('#DATE2').val();
     
       if(NUMERO_PERMIS==0)
       {
          PERMIS =  $('#PERMIS').val();
       }else{
          PERMIS =  NUMERO_PERMIS;
          $("#PERMIS").val(NUMERO_PERMIS)
       }
       
      $('#permis').modal({
        backdrop: 'static',
        keyboard: false
      });
      $("#permis_titre").html("Tableau de bord de la permis "+PERMIS);
      $.ajax({
          url : "<?php echo base_url('Vehicule/show_permis'); ?>",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: { NUMERO_PERMIS:PERMIS,
                  DATE1:DATE1,
                  DATE2:DATE2},
          beforeSend:function () { 
            
             $('#permisdata').html('<center><font color="#000"><i class="fas fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span></font></center>');
          },
          success:function(data) {
            console.log(data)
           $('#permisdata').html(data.donne_permis);
          },
          error:function() {
            $('#permisdata').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher cette page! Veuillez réessayer</div>');
          }
      });
       
   }
 $(document).ready(function(){
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
      "order":[[7,'DESC']],

      "ajax":{
        url: "<?php echo base_url('PSR/Psr_institution/listing/');?>", 
        type:"POST",
        data : {STATUT:$('#STATUT').val()},
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
  function chauffeur(id)
  {
   $("#chauffeur").modal("show");
   var row_count ="1000000";
   // $('.service').html('Liste des services');
   table=$("#mytable_chauffeur").DataTable({
    "processing":true,
    "destroy" : true,
    "serverSide":true,
    "oreder":[[ 0, 'desc' ]],
    "ajax":{
      url:"<?php echo base_url()?>PSR/Psr_institution/chauffeur/"+id,
      type:"POST",
    },

  });
    $.ajax ({
      url:"<?php echo base_url('PSR/Psr_institution/getInstitution/')?>"+id,
      type:"POST",
      dataType:"JSON",
      success: function(data)
      {
        $('.service').html('Chauffeurs pour  '+data.NOM_INSTITUTION +' ');
        
      },
      
    });
 }
 function vehicule(id)
  {
   $("#vehicule").modal("show");
   var row_count ="1000000";
   // $('.service').html('Liste des services');
   table=$("#mytable_vehicule").DataTable({
    "processing":true,
    "destroy" : true,
    "serverSide":true,
    "oreder":[[ 0, 'desc' ]],
    "ajax":{
      url:"<?php echo base_url()?>PSR/Psr_institution/vehicule/"+id,
      type:"POST",
    },

  });
    $.ajax ({
      url:"<?php echo base_url('PSR/Psr_institution/getInstitution/')?>"+id,
      type:"POST",
      dataType:"JSON",
      success: function(data)
      {
        $('.service').html('Véhicule  pour '+data.NOM_INSTITUTION +' ');
        
      },
      
    });

 }
 //FUNCTION POUR  VOIR LES AMENDES VEHICULE D'UNE INSTITUTION
 function   amende_vehicule(id=null ,institution=null){
                      $("#ID_INSTITUTION").val(id)
                      $("#NOM_INSTITUTION").val(institution)

                      $('.service').html('Amendes  '+institution+' ');
                      $("#modal_amende_vehicule").modal();

                      var row_count ="1000000";

                        $("#amende_vehicule").DataTable({
                          "processing":true,
                          "serverSide":true,
                          "bDestroy": true,
                          "oreder":[],
                          "ajax":{
                              url:"<?php echo base_url()?>PSR/Psr_institution/amende_vehicule/"+id,
                              type:"POST",
                              data:{
                                DATE1:$('#DATE1').val(),
                                DATE2:$('#DATE2').val(),
                                STATUT:$('#STATUT').val(),
                                NUMERO_PLAQUE:$('#NUMERO_PLAQUE').val(),
                              }
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
                      $.ajax ({
                          url:"<?php echo base_url('PSR/Psr_institution/getMontant/')?>"+id,
                          type:"POST",
                          data:{
                                DATE1:$('#DATE1').val(),
                                DATE2:$('#DATE2').val(),
                                STATUT:$('#STATUT').val(),
                                NUMERO_PLAQUE:$('#NUMERO_PLAQUE').val(),
                              },
                          dataType:"JSON",
                          success: function(data)
                          {
                            $('#montant').html(data +' <i>BIF</i>');
                            
                          },
                          
                    });
 }

 //FUNCTION POUR  VOIR LES AMENDES PERMIS D'UNE INSTITUTION
 function   amende_permis(id,institution=null){
                      $('.service').html('Amendes '+institution+' ');
                      $('#ID_INSTITUTION_permis').val(id);
                      $("#NOM_INSTITUTION_permis").val(institution)
                      $("#modal_amende_permis").modal();
                      
                      var row_count ="1000000";
                        $("#amende_permis").DataTable({
                          "processing":true,
                          "serverSide":true,
                          "bDestroy": true,
                          "oreder":[],
                          "ajax":{
                              url:"<?php echo base_url()?>PSR/Psr_institution/amende_permis/"+id,
                              type:"POST",
                              data:{
                                DATE1:$('#DATE1_permis').val(),
                                DATE2:$('#DATE2_permis').val(),
                                STATUT:$('#STATUT_permis').val(),
                                NUMERO_PERMIS:$('#NUMERO_PERMIS').val(),
                              }
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
                        $.ajax ({
                          url:"<?php echo base_url('PSR/Psr_institution/getMontant_permis/')?>"+id,
                          type:"POST",
                          data:{
                                DATE1:$('#DATE1').val(),
                                DATE2:$('#DATE2').val(),
                                STATUT:$('#STATUT').val(),
                                NUMERO_PERMIS:$('#NUMERO_PERMIS').val(),
                              },
                          dataType:"JSON",
                          success: function(data)
                          {
                            $('#montant_permis').html(data +' <i>BIF</i>');
                            
                          },
                          
                    });
 }
 //FONCTIONS UTILISER POUR  ACTIVER  UNE INSTITUTION
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
          url : "<?=base_url()?>PSR/Psr_institution/activer/"+id,
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
 //FONCTIONS UTILISER POUR  LES FILTERS  LES AMENDES VEHICULES
 function filter_vehicule(){
   var id=$("#ID_INSTITUTION").val()
   var institution=$("#NOM_INSTITUTION").val()
   amende_vehicule(id,institution)
 }
 //FONCTIONS UTILISER POUR  LES FILTERS OUR LES AMENDES PERMIS
 function filter_permis(){
   var id=$("#ID_INSTITUTION_permis").val()
   var institution=$("#NOM_INSTITUTION_permis").val()
   amende_permis(id,institution)
 }
 //FONCTIONS UTILISER POUR  DESACTIVER  UNE INSTITUTION
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
          url : "<?=base_url()?>PSR/Psr_institution/desactiver/"+id,
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
  function show_vehicule_detail(NUMERO_PLAQUE = 0){
       var PLAQUE;
       var NUMERO_PLAQUE= NUMERO_PLAQUE;
       DATE1=  $('#DATE1').val();
       DATE2=  $('#DATE2').val();
       STATUT=  $('#STATUT').val();
       if(NUMERO_PLAQUE==0)
       {
          PLAQUE =  $('#PLAQUE').val();
       }else{
          PLAQUE =  NUMERO_PLAQUE;
          $("#PLAQUE").val(NUMERO_PLAQUE)
       }
      $('#vehicule_detail').modal({
        backdrop: 'static',
        keyboard: false
      });
      $("#vehicule_titre").html("Tableau de bord de la plaque "+PLAQUE);
      $.ajax({
          url : "<?php echo base_url('Vehicule/show_vehicule'); ?>",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: { 
                  NUMERO_PLAQUE:PLAQUE,
                  DATE1:DATE1,
                  DATE2:DATE2,
                  STATUT:STATUT},
          beforeSend:function () { 
            
             $('#vehiculedata').html('<center><font color="#000"><i class="fas fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span></font></center>');
          },
          success:function(data) {
            console.log(data)
           $('#vehiculedata').html(data.detail);
          },
          error:function() {
            $('#vehiculedata').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher cette page! Veuillez réessayer</div>');
          }
      });
       
   }
</script>



