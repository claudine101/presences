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
  /*width:auto;*/
  max-height: 600;
  margin: 2px;
  padding: 10px; 
 /*overflow-x: auto;*/
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
      /*opacity: 0.0*/
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
      /*opacity: 0.0*/
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
                 <div class="modal-header" style="background: black;">
                  <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;">Détails</h4></b></div>

                  <div style="color:#fff;cursor: pointer;" onclick="close_modal_Sign_Details()" >
                   <span  aria-hidden="true" style="font-size: 25px;cursor: pointer;">&times;</span>
                 </div>
               </div>
               <div class="modal-body" id="Sign_donnes">


              </div>
              <div class="modal-footer"> 
                 <button id="btn_quiter" type="button" class="btn btn-success" onclick="check_position()">Confirmer</button>
                 <button type="button" class="btn btn-info"  onclick="demissio_modal()">Annuler</button>
              </div>
            </div>
            </div>
            </div>








             <span style="float: right;margin-bottom: 8vh; z-index: 1;width: 18vw; margin-right: 1px; margin-top: 2px;">
               
                <div class='card col-md-12' style="padding : 10px">
                  <div class='card-header text-left'>
                    <h6><font color='white'><b>Signalements pour</b></font></h6>
                  </div>
                  <div class='card-body' id="legande">
                    <!-- <img src='' width='20' height='20' style='border-radius:50%;'> &nbsp; Agent</b><br>
                    <img src='' width='20' height='20' style='border-radius:50%;'> &nbsp; Voiture</b><br>
                    <img src='' width='20' height='20' style='border-radius:50%;'> &nbsp; Autre</b><br><br> -->
                  </div>

                   <div class='card-footer'>
                    <button title="Autre filtre" onclick="getModal()"  type="button" class="btn btn-secondary btn-block col-md-12"><i class="fa fa-filter"></i> Filtre</button>
                  </div>
                </div>
              
             </span>


       

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


                <div class="row">
                <div class="col-sm-12">
                  <label>Elément de la PNB</label>
                  <form id="form_data">
                  <div class="input-group">

                  <!-- <input type="" name="" value="0" id="ID_ELEMENT"> -->

                  <input onkeyup="getSearchResults()" autocomplete="off" placeholder="Rechercher nom, prénom, matricule" type="text" value="<?=set_value('search')?>" name="search" id="search" class="form-control">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i id="default_loading" class="fa fa-search" aria-hidden="true"></i>
                      <i id="loading"></i>
                    </span>
                    
                  </div>
                </div>
                </form>
                  <span class="result"></span>
                </div>
              </div>
             


                <div class="row">

                  <div class="form-group col-md-4">

                    <label>Année</label>
                    <select class="form-control"  onchange="getMaps()" name="annee" id="annee">
                           <option value="">Sélectionner</option>
                    
                          </select>
                </div>

                <div class="form-group col-md-4"> 
                  <label>Mois</label>
                  <select class="form-control"  onchange="getMaps()" name="mois" id="mois">
                   <option value=""> Sélectionner </option> 
                                          </select>
                </div>

                <div class="form-group col-md-4"> 
                    <label>Jours</label>
                    <select class="form-control"  onchange="getMaps()" name="jour" id="jour">
                     <option value=""> Sélectionner </option> 
                   
                    </select>
                </div>

                

                <div class="form-group col-md-12">
                 <label>Numéro plaque</label>
                    <div class="input-group">
                     <input autocomplete="off" type="text" class="form-control" name="NUMERO_PLAQUE"  id="NUMERO_PLAQUE"  placeholder="Recherche" value="<?=set_value('NUMERO_PLAQUE')?>">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><a href="javascript:;"  onclick="getMaps()"><i class="fa fa-search" aria-hidden="true"></i></a></span>
                    </div>
                     </div>
                </div>
                <div class="form-group col-md-12">
                 <label>Numéro permis</label>
                    <div class="input-group">
                             <input autocomplete="off" type="text" class="form-control " name="NUMERO_PERMIS"  id="NUMERO_PERMIS"  placeholder="Recherche" value="<?=set_value('NUMERO_PERMIS')?>">
                                <div class="input-group-prepend">
                            <span class="input-group-text"><a href="javascript:;" onclick="getMaps()"><i class="fa fa-search" aria-hidden="true"></i></a></span>
                      </div>
                      </div>
                </div>
                <div class="form-group col-md-12">
                <label>Paiement</label>
                <select class="form-control"  onchange="getMaps()" name="IS_PAID" id="IS_PAID">
                       <option value="">Sélectionner</option>

                        <option value="1">Payé</option>
                       <option value="0">Non payé</option>

                      </select>
                    </div>
                              </div></form>

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
             $('#id_signnew').val(id);

          }

        });

    }






  $(document).ready(function () {
      $('#div_panel').hide();
    });

  function close_modal(){
    $('#div_panel').delay(100).hide('show');
  }

  function getModal(id){

      $('#div_panel').delay(100).show('hide');
     
    }




</script>




<script>

get_data() 
function get_data() {

        $.ajax({
          url : "<?=base_url()?>geo/New_signalement/get_carte/",
          type : "POST",
          dataType: "JSON",
          cache:false,
         
          data: {Agents:null},
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


function check_position(){

    const options = {
      enableHighAccuracy: true,
      timeout: 4000,
      maximumAge: 0
    };
  
    navigator.geolocation.getCurrentPosition(successData, error);

    $('#Sign_controls').modal({
        backdrop: 'static',
        keyboard: false
      });

}



    



</script>

</body>

