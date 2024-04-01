<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php'; ?>


            <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
           <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
<script src='https://unpkg.com/@turf/turf/turf.js'></script>


    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style>
/* Adjustments to account for mapbox.css box-sizing rules */
.leaflet-control-zoomslider-knob { width:7px; height:2px; }
.leaflet-container .leaflet-control-zoomslider-body {
  -webkit-box-sizing:content-box;
     -moz-box-sizing:content-box;
          box-sizing:content-box;
  }
</style>

<style>

.autocomplete-items {
  position: absolute;
  /border: 1px solid #d4d4d4;/
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /position the autocomplete items to be the same width as the container:/
  /*top: 100%;
  left: 0;
  right: 0;*/
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

</style>

<style type="text/css">
    .scroller {
        height: 450px;
        overflow-y: scroll;
        border-radius: 10px;
    }
</style>


<style type="text/css">
  .card{
  border-width: 0px;
  font-size: 14px;
  margin: 0px;
  padding: 0px;
}


.select2-container--default .select2-selection--multiple .select2-selection__choice {
  color: #434393;

}


#div_panel{
  position:fixed;
  bottom:1%;
  right: 0.1%;
  z-index:1;
  max-width:28.8%;
  /width:auto;/
  max-height: 600;
  margin: 2px;
  padding: 10px; 
 /overflow-x: auto;/
 color: #000;
 border:1px solid rgba(25, 0, 0, 0);
 

  }


.card-header{
  margin-top: -11px;
  margin-left: -11px;
  margin-right: -11px;
  text-align: center;
  background-color: black;
  color: white;
}
.card-footer{
  margin-bottom: -12px;
  margin-left: -11px;
  margin-right: -11px;
  padding-right: -8px
  padding-left: -8px
}

/*.card-body{
  margin-left: -13px;
  margin-right: -13px;
  margin-bottom: -13px;
}*/
.ui-coordinates {
  background:rgba(0,0,0,0.5);
  position:absolute;
  top:280px;right:15px;
  z-index:1;
  bottom:10px;
  right:20px;
  padding:5px 10px;
  color:#fff;
  font-size:12px;
  border-radius:3px;
  max-height:220px;
 
  width:250px;
  }
</style>


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
}

 .animated-icon{
  width: 25px;
  height: 25px;
  background-color: rgba(255,255,255,0.5);
  border-radius: 50%;
  box-shadow: 0px 0px 20px red;
  transition: all 1s;
}
</style>
<style>
  
  .css-icon {

  }

  .gps_ringss { 
    border: 14px solid #F30707;
     -webkit-border-radius: 30px;
     height: 10px;
     width: 10px;   
     margin-left: 0px;
     margin-top: 0px;
      -webkit-animation: pulsate 1s ease-out;
      -webkit-animation-iteration-count: infinite; 
      /opacity: 0.0/
  }
  
  @-webkit-keyframes pulsate {
        0% {-webkit-transform: scale(0.1, 0.1); opacity: 0.0;}
        50% {opacity: 1.0;}
        100% {-webkit-transform: scale(1.2, 1.2); opacity: 0.0;}
  }
  </style>

 
<style>
/* Adjustments to account for mapbox.css box-sizing rules */
.leaflet-control-zoomslider-knob { width:7px; height:2px; }
.leaflet-container .leaflet-control-zoomslider-body {
  -webkit-box-sizing:content-box;
     -moz-box-sizing:content-box;
          box-sizing:content-box;
  }
</style>


<style type="text/css">
  .card{
  border-width: 0px;
  font-size: 14px;
  margin: 0px;
  padding: 0px;
}



.card-header{
  margin-top: -11px;
  margin-left: -11px;
  margin-right: -11px;
  text-align: center;
  background-color: black;
  color: white;
}
.card-footer{
  margin-bottom: -12px;
  margin-left: -11px;
  margin-right: -11px;
  padding-right: -8px
  padding-left: -8px
}

.card-body{
  margin-left: -13px;
  margin-right: -13px;
  margin-bottom: -13px;
}
.ui-coordinates {
  background:rgba(0,0,0,0.5);
  position:absolute;
  top:280px;right:15px;
  z-index:1;
  bottom:10px;
  right:20px;
  padding:5px 10px;
  color:#fff;
  font-size:12px;
  border-radius:3px;
  max-height:220px;
 
  width:250px;
  }
</style>


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
}

 .animated-icon{
  width: 25px;
  height: 25px;
  background-color: rgba(255,255,255,0.5);
  border-radius: 50%;
  box-shadow: 0px 0px 20px red;
  transition: all 1s;
}
</style>
<style>
  
  .css-icon {

  }

  .gps_ring { 
    border: 7px solid #F30707;
     -webkit-border-radius: 30px;
     height: 48px;
     width: 48px;   
     margin-left: -10px;
     margin-top: -15px;
      -webkit-animation: pulsate 1s ease-out;
      -webkit-animation-iteration-count: infinite; 
      /opacity: 0.0/
  }
  
  @-webkit-keyframes pulsate {
        0% {-webkit-transform: scale(0.1, 0.1); opacity: 0.0;}
        50% {opacity: 1.0;}
        100% {-webkit-transform: scale(1.2, 1.2); opacity: 0.0;}
  }


  </style>

  <style>
  #map {position:absolute; top:0; bottom:0; right:0;left: 0; width:100vw; height: 93vh}
</style>

 
<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">


    <?php include VIEWPATH.'templates/navbar.php'; ?>
    <?php include VIEWPATH.'templates/sidebar.php'; ?>

      <div class="content-wrapper">
        <div class="container-fluid">

        </div>

        <section class="content" >

            <div class="card" style="margin-right: -25px;">

              <div id="filtr_checkbox"></div>

              <div class="card-body col-md-12 col-xl-12 grid-margin stretch-card" id="map" >

             </div>

              

          </div>

        </section>


            <!-- MODAL POUR LE CONTROL RAPID -->
          

        <div class="modal fade" id="Sign_controls" role="dialog">
        <div class="modal-dialog modal-lg" style ="width:1000px">
          <div class="modal-content  modal-lg">
            <div class="modal-header">
               <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;">Détails</h4></b></div>
                  <div style="color:#fff;cursor: pointer;" onclick="close_modal_Sign_controls()" >
                   <span  aria-hidden="true" style="font-size: 25px;cursor: pointer;">&times;</span>
                 </div>
            </div>
            <div class="modal-body" id="Control_donnes">
              <div class="table-responsive">
                <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
                <thead>
                <th>#</th>
                <th>STATUT</th>
               <th>TYPE DE VERIFICATION</th>
               <th>NUMERO_PLAQUE</th>  
               <th>CONSTAT</th>           
               <th>DATE</th>
               
              </thead>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button id="btn_quiter" type="button" class="btn btn-success" onclick="confir_verbal()">Confirmer</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Quitter</button>
            </div>
          </div>
        </div>
      </div>





            <!-- MODAL POUR LE DETAIL SIGNALEMENT -->
            <div class="modal fade" id="Sign_Details">
             <div class="modal-dialog modal-lg" >
                <div class="modal-content ">
                  <form action="<?= base_url() ?>PSR/Obr_immatricUlation/controle_rapide"; method="post"  enctype="multipart/form-data" id='myform_controle'>
                 <div class="modal-header" style="background: black;">
                  <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;">Détails</h4></b></div>


                  <div style="color:#fff;cursor: pointer;" onclick="close_modal_Sign_Details()" >
                   <span  aria-hidden="true" style="font-size: 25px;cursor: pointer;">&times;</span>
                 </div>
               </div>
               <div class="modal-body" id="Sign_donnes">


              </div>
              <div id="message"></div>
              <div class="modal-footer" id="btn_data"> 
              
              </div>
              </form>
            </div>
            </div>
            </div>






            <div style="float: left;margin-top: 89vh; z-index: 1; margin-left: 5px;">

              <div class='col-md-12'>
                <div class="row">
                  <button style="border-radius: 0px" title="Filtre" onclick="getModal()"  type="button" class="btn btn-secondary btn-sm"><i class="fa fa-filter"></i> Filtre</button>
                  <button style="border-radius: 0px" title="Légende" onclick="getModal1()"  type="button" class="btn btn-secondary btn-sm"><i class="fa fa-list"></i> Légende</button>
                </div>
                
              </div>

            </div>



            <div style="float: right;margin-bottom: 8vh; z-index: 1;width: 18vw; margin-right: 1px; margin-top: 2px;">

            
               
                <div id="div_panel1" class='card col-md-12' style="padding : 10px">
                  <div class='card-header'>
                    <button style="float: left;"  id="close_div" onclick="close_modal1()" class="btn btn-sm">
                <font color="#fff">
                  <i class="fa fa-times"></i>
                </font>
              </button>

                    <h6><font color='white'><b>Légende</b></font></h6>
                  </div>
                  <div class='card-body' id="legande">
                  </div>
                </div>
              
             </div>
             <!-- MODAL DE RESULTANT DE CONTROLE  -->
             <div id="vehicule" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
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
                    
                     

               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
          </div>
        </div>
</div>
<!-- FIN -->


       

       <!-- DEBUT DIV POPUP DETAIL WITH FUNCTION ONCLICK -->
          <div class="card col-md-12" id="div_panel" >
            <div class="card-header text-left">
              <font color="#fff"><i class="icon-address-card"></i></font>
              <span id="titre_op"></span>
              <button style="float: left;"  id="close_div" onclick="close_modal()" class="btn btn-sm">
                <font color="#fff">
                  <i class="fa fa-times"></i>
                </font>
              </button>
            </div>
            <div class="card-body" style="">
              <form id="form_data">
                <!-- method="POST" action="<?=base_url()?>geo/New_signalement/get_carte" -->


                <div class="row">
                <div class="col-sm-12">
                  <!-- <label>Elément de la PNB</label> -->
                  <!-- <form id="form_data"> -->
                  <div class="input-group">

                  <!-- <input type="" name="" value="0" id="ID_ELEMENT"> -->

                  <input autocomplete="off" placeholder="Rechercher nom, prénom, matricule" type="text" value="<?=set_value('key')?>" name="key" id="key" class="form-control">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-search search" aria-hidden="true"></i>
                      <span id="loading_search"></span>
                    </span>
                    
                  </div>
                </div>
                <!-- </form> -->
                  <div class="autocomplete-items"></div>
                </div>
              </div>
             


                <div class="row">

                  <div class="form-group col-md-6">
                    <label>Du</label>
                    <input type="date" name="DATE1" id="DATE1" class="form-control" >
                  </div>

                  <div class="form-group col-md-6">
                    <label>au</label>
                    <input type="date" onchange="get_data()" name="DATE2" id="DATE2" class="form-control" ><!-- onchange="submit()" -->
                  </div>

                  <div class="form-group col-md-6">

                    <label>Type</label>
                    <select class="form-control"  onchange="get_data()" name="annee" id="annee">
                           <option value="">Sélectionner</option>
                    <?php
                    $type =  $this->Model->getRequete('SELECT * FROM civil_alerts_types ');
                    foreach ($type as $value){
                    if ($value['ID_TYPE'] == set_value('ID_TYPE'))
                    {?>
                    <option value="<?=$value['ID_TYPE']?>" selected><?=$value['DESCRIPTION']?></option>
                    <?php } else{ 
                     ?>
                    <option value="<?=$value['ID_TYPE']?>" ><?=$value['DESCRIPTION']?></option>
                    <?php } } ?>
                          </select>
                </div>

                <div class="form-group col-md-6"> 
                  <label>Statut</label>
                  <select class="form-control"  onchange="get_data()" name="ID_ALERT_STATUT" id="ID_ALERT_STATUT">
                   <option value=""> Sélectionner </option> 
                   <?php
                   $statut =  $this->Model->getRequete('SELECT * FROM civil_alerts_statuts');
                    foreach ($statut as $value){
                    if ($value['ID_ALERT_STATUT'] == set_value('ID_ALERT_STATUT'))
                    {?>
                    <option value="<?=$value['ID_ALERT_STATUT']?>" selected><?=$value['NOM']?></option>
                    <?php } else{ 
                     ?>
                    <option value="<?=$value['ID_ALERT_STATUT']?>" ><?=$value['NOM']?></option>
                    <?php } } ?>
                  </select>
                </div>

                

                <div class="form-group col-md-12">
                 <label>Numéro plaque</label>
                    <div class="input-group">
                     <input autocomplete="off" type="text" class="form-control" name="NUMERO_PLAQUE"  id="NUMERO_PLAQUE"  placeholder="Recherche" value="<?=set_value('NUMERO_PLAQUE')?>">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><a href="javascript:;"  onclick="get_data()"><i class="fa fa-search" aria-hidden="true"></i></a></span>
                    </div>
                     </div>
                </div>
                              </div>
                            </form>

            </div>
          </div>
          <!-- FIN DIV POPUP DETAIL WITH FUNCTION ONCLICK -->








     </div>



</div>
<?php include VIEWPATH.'templates/footerDeux.php'; ?>
</body>
</html>

<input type="hidden" name="id" id="id_signnew">

<script type="text/javascript">


   function close_modal_Sign_controls(){
     $('#Sign_controls').modal('hide');
   }

   function close_modal_Sign_Details(){
     $('#Sign_Details').modal('hide');
   }

   function get_detail_sign(id){
      
      $('#Sign_Details').modal({
        backdrop: 'static',
        keyboard: false
      });

      $.ajax({
          url : "<?=base_url()?>geo/New_signalement/get_detail_signal/"+id,
          type : "GET",
          dataType: "JSON",
          cache:false,
          success:function(data) {
             
             $('#donneTitre').html(data.titre);
             $('#Sign_donnes').html(data.donne);
             // $('#Sign_donnes').html(data.donne);
             $('#id_signnew').val(id);
             $('#btn_data').html(data.btn_data);


          }

        });

    }






  $(document).ready(function () {
      $('#div_panel').hide();
      $('#div_panel1').hide();
    });

  function close_modal(){
    $('#div_panel').delay(100).hide('show');
  }

  function close_modal1(){
    $('#div_panel1').delay(100).hide('show');
  }

  function getModal(id){

      $('#div_panel').delay(100).show('hide');
     
    }

    function getModal1(id){

      $('#div_panel1').delay(100).show('hide');
     
    }




</script>



<script type="text/javascript">
    
    $(document).ready(function() {

    var delay = (function() {
        var timer = 0;
        return function(callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $('#key').keyup(function() {
        var target = $(this);
        delay(function() {
            getSearchResults(target.val());
        }, 1000);
    });

function getSearchResults(str) {

    $.ajax({
        
        url: "<?=base_url()?>index.php/geo/New_signalement/Recherche",
        dataType:"html",
        data: {"term": str},
        method: "post",
        beforeSend: function(){
            $('#loading_search').html("<i class='fa fa-spinner'></i>");
            $('.search').hide();
        },
        success: function(data){
            if(data !== null) {
                $(".autocomplete-items").html(data);
                $('#loading_search').html("");
                $('.search').show();
            }
        },
        error: function(){
            // $("#loading_search").fadeOut("slow");
            $('#loading_search').html("");
        }
    });        
}


});

</script> 



<script>

get_data() 
function get_data(id) {

    var NUMERO_PLAQUE=$('#NUMERO_PLAQUE').val();
    var ID_TYPE=$('#ID_TYPE').val();
    var ID_ALERT_STATUT=$('#ID_ALERT_STATUT').val();  
    var DATE1=$('#DATE1').val();
    var DATE2=$('#DATE2').val();
    var ID_UTILISATEUR= id;

    // alert(ID_UTILISATEUR)

        $.ajax({
          url : "<?=base_url()?>geo/New_signalement/get_carte/",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {
            NUMERO_PLAQUE:NUMERO_PLAQUE,
            ID_TYPE:ID_TYPE,
            ID_ALERT_STATUT:ID_ALERT_STATUT,
            DATE1 : DATE1,
            DATE2 : DATE2,
            ID_UTILISATEUR:ID_UTILISATEUR
          },
          beforeSend:function () { 
            $('#map').html("");
            $('#map').html('<center style="margin-top: 250px;"><img height="50"   src="<?php echo base_url() ?>upload/reload.gif"></center>');
            
          },
          success:function(data) {

           $('#map').html("");
           $('#map').html(data.cartes);
           $('#legande').html(data.get_legande.html_titr);
           $('#legande_total').html(data.get_legande.total);

           $('#filtr_checkbox').html(data.get_legande.filtr_checkbox);

          },
          error:function() {
            $('#map').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher la carte! Veuillez réessayer</div>');
          }
      });


    }


function successData(pos) {

  

 

  const crd = pos.coords;
  /*
  console.log('Your current position is:');
  console.log(`Latitude : ${crd.latitude}`);
  console.log(`Longitude: ${crd.longitude}`); */
  console.log(`More or less ${crd.accuracy} meters.`); 

  if ($('#plaque_numbers').val() == "") {
    $('#plaque_numbers').focus()
  }else{

   $.ajax({
          url : "<?=base_url('geo/New_signalement/control_rapid')?>",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {
                  numeroPlaque: $('#plaque_numbers').val(),
                  lat: crd.latitude,
                  long: crd.longitude,
                  controleType: 1,
                  id : $('#id_signnew').val()
          },
          beforeSend:function () { 
           
          },
          success:function(data) {
            console.log(data)

          },
          error:function() {
           console.log('Erreur :control rapid')
          }
      });

   }

 
}




function error(err) {
  console.log(`ERROR(${err.code}): ${err.message}`);
}


// function check_position(){

//     const options = {
//       enableHighAccuracy: true,
//       timeout: 4000,
//       maximumAge: 0
//     };
  
//     navigator.geolocation.getCurrentPosition(successData, error);

//     $('#Sign_controls').modal({
//         backdrop: 'static',
//         keyboard: false
//       });

// }


function check_position(id){

var PLAQUE_NUMERO = $('#plaque_numbers').val();
var COMMENTAIRE = $('#COMMENTAIRE_VALID').val();

$.ajax({
      url : "<?=base_url('geo/New_signalement/check_position')?>",
      type : "POST",
      dataType: "JSON",
      cache:false,
      data: {
              id: id,
              PLAQUE_NUMERO:PLAQUE_NUMERO,
              COMMENTAIRE:COMMENTAIRE
            },
      beforeSend:function () { 
       
      },
      success:function(data) {
        $('#message').html(data.message);

        setTimeout(()=>{
            window.location.reload();
        },3000)
      },
      error:function() {
       console.log('Erreur :control rapid')
      }
  });

}


function demissio_modal(id){

var PLAQUE_NUMERO = $('#plaque_numbers').val();
var COMMENTAIRE = $('#COMMENTAIRE_VALID').val();

$.ajax({
      url : "<?=base_url('geo/New_signalement/demissio_modal')?>",
      type : "POST",
      dataType: "JSON",
      cache:false,
      data: {
              id: id,
              PLAQUE_NUMERO:PLAQUE_NUMERO,
              COMMENTAIRE:COMMENTAIRE
            },
      beforeSend:function () { 
       
      },
      success:function(data) {
        $('#message').html(data.message);

        setTimeout(()=>{
            window.location.reload();
        },3000)
      },
      error:function() {
       console.log('Erreur :control rapid')
      }
  });

}
function save(){
     // const crd = pos.coords;
     // console.log(`More or less ${crd.accuracy} meters.`); 
     // var lat=crd.latitude;

     var NUMERO_PLAQUE = $('#plaque_numbers').val();
     var ID_SIGNALEMENT_NEW = $('#ID_SIGNALEMENT_NEW').val();
     var MONTANT_AMANDE = $('#MONTANT_AMANDE').val();
     var ID_AUTRE_CONTROL = $('#ID_AUTRE_CONTROL').val();
     var COMMENTAIRE = $('#COMMENTAIRE_VALID').val();

     Swal.fire({
      title: 'Souhaitez-vous effectuer un contrôle rapide sur le plaque numéro '+NUMERO_PLAQUE+' ?',
      showDenyButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>geo/New_signalement/controle_rapide/",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {
               NUMERO_PLAQUE:NUMERO_PLAQUE,
               ID_SIGNALEMENT_NEW:ID_SIGNALEMENT_NEW,
               MONTANT_AMANDE:MONTANT_AMANDE,
               ID_AUTRE_CONTROL:ID_AUTRE_CONTROL,
               COMMENTAIRE:COMMENTAIRE
             },
          beforeSend:function () { 
           $('#message').html('<center><font color="#000"><i class="fas fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span></font></center>');
           $('#idbutton').prop('disabled',true)
          },
          success:function(data) {
            $('#btn_data').html('<button id="idbutton" type="button"  onclick="show_vehicule()"  class="btn btn-primary btn-md" >Voir les documents</button><button type="button" class="btn btn-info"  onclick="demissio_modal()>Annuler</button><button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>');
            // get_data() 
            console.log(data);
            Swal.fire('Confirmé!', '', 'success')
            $('#message').html(data.message);

          },
          error:function() {
            $('#message').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher cette page! Veuillez réessayer</div>');
          }
      });

        
      } else if (result.isDenied) {
        Swal.fire('Non Confirmé', '', 'info')
      }
    })

    //Fin ajax

 }
function show_vehicule(){
       if ($('#plaque_numbers').val() == "") {
           $('#plaque_numbers').focus()
       }
      else{

       var PLAQUE;
       var NUMERO_PLAQUE= $('#plaque_numbers').val();
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
      $('#vehicule').modal()
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
   }

</script>

</body>