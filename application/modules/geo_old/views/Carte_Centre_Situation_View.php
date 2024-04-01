<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php'; ?>


            <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
           <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
<script src='https://unpkg.com/@turf/turf/turf.js'></script>


<style type="text/css">

 #div_panel{
  position:fixed;
  bottom:5%;
  right: 1%;
  z-index:1;
  max-width:27%;
  /*width:auto;*/
  max-height: auto;
  margin: 2px;
  padding: 1px; 
 /*overflow-x: auto;*/
 color: #000;
 border:1px solid rgba(25, 0, 0, 0);
 background-color:rgba(25, 0, 0, 0);

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

#divImage{

  top: 10.4%;
  width: 50.4%;
  height: 100%;
  background: #fff;
  position: fixed;
  z-index: 1060;
  right: 20%;
  right: 20%;
  visibility: hidden;
  overflow-x: auto;

  top: 0;
  left: 0;
  display: none;
  width: 100%;
  height: 100%;
  overflow: hidden;
  outline: 0;
  outline-color: currentcolor;
  outline-style: none;
  outline-width: 0px;

  overflow-x: hidden;
  overflow-y: auto;

}


  #allImage {
  position: relative;
  width: auto;
  margin: .5rem;
  pointer-events: none;

}


#donnIdentite {
  position: relative;
  width: auto;
  margin: .5rem;
  /*pointer-events: none;*/

}


#divIdentite{

  width: 500px;
  max-height: 80%;
  overflow-x: hidden;
  overflow-y: auto;
  background: #fff;
  position: fixed;
  z-index: 1060;
  right: 20%;
  left: 18.3%;
  visibility: hidden;
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
<style>
.legend label,
.legend span {
  display:block;
  float:left;
  height:15px;
  width:20%;
  text-align:center;
  font-size:9px;
  color:#808080;
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

  .gps_ringu { 
    border: 7px solid #F30707;
     -webkit-border-radius: 30px;
     height: 38px;
     width: 38px;   
     margin-left: -10px;
     margin-top: -15px;
      -webkit-animation: pulsate 1s ease-out;
      -webkit-animation-iteration-count: infinite; 
      /*opacity: 0.0*/
  }


  .gps_ringss { 
    border: 7px solid #848484;
     -webkit-border-radius: 30px;
     height: 38px;
     width: 38px;   
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
<style>
.legend label,
.legend span {
  display:block;
  float:left;
  height:15px;
  width:20%;
  text-align:center;
  font-size:9px;
  color:#808080;
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


  #divImage{

  top: 10.4%;
  width: 50.4%;
  height: 100%;
  background: #fff;
  position: fixed;
  z-index: 1060;
  right: 20%;
  right: 20%;
  visibility: hidden;
  overflow-x: auto;

  top: 0;
  left: 0;
  display: none;
  width: 100%;
  height: 100%;
  overflow: hidden;
  outline: 0;
  outline-color: currentcolor;
  outline-style: none;
  outline-width: 0px;

  overflow-x: hidden;
  overflow-y: auto;

}


  #allImage {
  position: relative;
  width: auto;
  margin: .5rem;
  pointer-events: none;

}
  </style>

    <style type="text/css">

    #div_panel1{
  position:fixed;
  bottom:0.5%;
  right: 0px;
  z-index:11;
  width:28.8%;
  /*width:auto;*/
  margin: 2px;
  padding: 10px; 
 /*overflow-x: auto;*/
 color: #000;
 border:1px solid rgba(25, 0, 0, 0);
 

  }
  </style>

 
<body class="hold-transition sidebar-mini layout-fixed">




   <div>

               <div class="card w-80" id="divIdentite">
                  <div class="card-header">
                     <span>PSR <a style="float: right" href="#" onclick="viewIdentite()"><i class="fa fa-times"></i></a></span> <br>
                  </div>
                  <div class="card-body" id="donnIdentite">
              
                  </div>
                </div>
              </div>




   <div class="card" id="divImage">
                  <div class="card-header">
                     <span>PSR <a style="float: right" href="#" onclick="viewImage()"><i class="fa fa-times"></i></a></span> <br>
                  </div>
                  <div class="card-body" id="allImage">
                  </div>
                </div>
              </div>
  


 <audio style="display: none;" id="xhhh"  controls src="<?=base_url('uploads/sons.mpga')?>"  >
            <code>audio</code>
</audio>
  <div class="wrapper">

    <!-- Navbar -->
    <?php include VIEWPATH.'templates/navbar.php'; ?>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include VIEWPATH.'templates/sidebar.php'; ?>



       <div class="card" id="divImage">
                  <div class="card-header">
                     <span>PSR <a style="float: right; color: #fff;font-size: 20px;" href="#" onclick="viewImage()"><i class="fa fa-times"></i></a></span> <br>
                  </div>
                  <div class="card-body" id="allImage">
                  </div>
                </div>
              </div>



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <!-- <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-8">
             <h4 class="m-0">Centre de situation</h4>
           </div>

           
           <div class="col-sm-4 text-right">


            <span style="margin-right: 15px">
              <div class="row">
              <div class="col-sm-6" style="float:right;">
              </div>

              </div>
            </span>

          </div>
        </div>
      </div> -->


      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content" >

        <!-- <div class="col-md-12 col-xl-12 grid-margin stretch-card"> -->

          <!-- <div class="card" > -->
        
            <!-- <div class="card-body " > -->
      

                <?= $this->session->flashdata('message');?>

                <div id="reload_page">
              <div class="row">
              <div class="col-md-12">
                <center>

                  <img height="50" src="<?php echo base_url() ?>upload/reload.gif">
               
                </center>
              </div>
            </div>


            </div>
            

     
             
           <!-- <div class="card-body col-md-12 col-xl-12 grid-margin stretch-card" id="map" ></div> -->
          <div id="mapview"></div>

         
          
          <div class="card col-md-12" id="div_panel1" >
            

             <div class="card-header text-left">
              <font color="#fff"><i class="icon-address-card"></i></font>
              <span id="titre_op"></span>
              <button style="float: left;"  id="close_div" onclick="close_modal1()" class="btn btn-sm">
                <font color="#fff">
                  <i class="fa fa-times"></i>
                </font>
              </button>
            </div>
            <div class="card-body" style="background-color: white" id="legende_map">
            </div>
         
          </div>
                
              <!-- </div> -->


              <!--  VOS CODE ICI  -->



            <!-- </div> -->
          <!-- </div> -->

          </section>
        </div>


    





<!-- /.content -->
</div>

</div>
</div>








<!-- MODAL POUR LE DETAIL -->
<div class="modal fade" id="detail_perfoemance">
 <div class="modal-dialog modal-lg" >
   <div class="modal-content">
     <div class="modal-header" style="background: black;">
      <div id="title"><b><h4 id="donneTitre_autre" style="color:#fff;font-size: 18px;">Performance de l'agent</h4></b></div>

      <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </div>
   </div>
   <div class="modal-body" id="donnePerformance">
    
  
   
  </div>
  <div class="modal-footer"> 
   <!--  <button id="btn_quiter" type="button" class="btn btn-primary" class='close' data-dismiss='modal'>Quitter</button> -->
  </div>
</div>
</div>
</div>











<!-- DEBUT DIV POPUP DETAIL WITH FUNCTION ONCLICK -->
          <div class="card" id="div_panel" >
            <div class="card-header" style="background-color: black;color: white;padding: 5px">
              <font color="#fff"><i class="icon-address-card"></i></font>
              <span id="titre_op"></span>
               <button style="text-decoration: none;background-color: #000;color: #fff;float:left;"  id="close_div" onclick="close_modal()" class="btn btn-sm">
                <font color="#fff">
                  <i class="fa fa-times"></i>
                </font>
              </button>

            </div>
            <div class="card-body" style="background-color:#fff;padding: 5px;max-height: 600px;">
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
                    <?php

                    foreach ($annees as $value){
                    if ($value['annee'] == set_value('annee'))
                    {?>
                    <option value="<?=$value['annee']?>" selected><?=$value['annee']?></option>
                    <?php } else{ 
                     ?>
                    <option value="<?=$value['annee']?>" ><?=$value['annee']?></option>
                    <?php } } ?>
                          </select>
                </div>

                <div class="form-group col-md-4"> 
                  <label>Mois</label>
                  <select class="form-control"  onchange="getMaps()" name="mois" id="mois">
                   <option value=""> Sélectionner </option> 
                  <?php

                  foreach ($mois as $value){
                  if ($value['mois'] == set_value('mois'))
                  {?>
                  <option value="<?=$value['mois']?>" selected><?=$value['mois']?></option>
                  <?php } else{ 
                   ?>
                  <option value="<?=$value['mois']?>" ><?=$value['mois']?></option>
                  <?php } } ?>
                        </select>
                </div>

                <div class="form-group col-md-4"> 
                    <label>Jours</label>
                    <select class="form-control"  onchange="getMaps()" name="jour" id="jour">
                     <option value=""> Sélectionner </option> 
                    <?php

                    foreach ($jours as $value){
                    if ($value['jours'] == set_value('jour'))
                    {?>
                    <option value="<?=$value['jours']?>" selected><?=$value['jours']?></option>
                    <?php } else{ 
                     ?>
                    <option value="<?=$value['jours']?>" ><?=$value['jours']?></option>
                    <?php } } ?>
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






















<!-- MODAL POUR LE DETAIL -->
<div class="modal fade" id="detailControl">
 <div class="modal-dialog modal-lg" >
   <div class="modal-content modal-lg">
     <div class="modal-header" style="background: black;">
      <div id="title"><b><h4 id="donneTitres" style="color:#fff;font-size: 18px;">Détails des contrôles</h4></b></div>

      <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </div>
   </div>
   <div class="modal-body" id="donneControls">
    
    </div>
  <div class="modal-footer"> 
   <!--  <button id="btn_quiter" type="button" class="btn btn-primary" class='close' data-dismiss='modal'>Quitter</button> -->
  </div>
</div>
</div>
</div>




<!-- MODAL POUR LE DETAIL -->
<div class="modal fade" id="MessagePolice">
 <div class="modal-dialog" >
    <div class="modal-content">
     <div class="modal-header" style="background: black;">
      <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;">Nouveau message</h4></b></div>

      <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </div>
   </div>
   <div class="modal-body" id="donneDeatail">

  <form>
    <input type="hidden" class="form-control" id="IdAgents">
    <div class="form-group">
      <label for="exampleFormControlInput1">Contact</label>
      <input type="number" class="form-control" id="phoneNumber" placeholder="71586523" readonly>
    </div>
   
    <div class="form-group">
      <label for="exampleFormControlTextarea1">Message</label>
      <textarea class="form-control" id="MessageText" rows="3" placeholder="Message..."></textarea>
    </div>
  </form>
  

  </div>
  <div class="modal-footer"> 
     <button id="btn_quiter" type="button" class="btn btn-primary" onclick="sendMessage()">Envoyer</button>
    <!-- <button id="btn_quiter" type="button" class="btn btn-primary" class='close' data-dismiss='modal'></button> -->
  </div>
</div>
</div>
</div>








<!-- ./wrapper -->
<?php include VIEWPATH.'templates/footerDeux.php'; ?>
</body>
</html>








<script type="text/javascript">
    
    $(document).ready(function() {

        $("#loading").hide();

// var delay = (function() {
//     var timer = 0;
//     return function(callback, ms) {
//         clearTimeout(timer);
//         timer = setTimeout(callback, ms);
//     };
// })();

// $('#ID_PSR_ELEMENT').keyup(function() {
//     var target = $(this);
//     delay(function() {
//         getSearchResults(target.val());
//     }, 1000);
// });

});

function getSearchResults() {

    var search=$('#search').val();

    // alert(search)

    $.ajax({
        
        url: "<?=base_url()?>geo/Carte_Centre_Situation/Recherche",
        dataType:"html",
        data: {"search": search},
        method: "post",
        beforeSend: function(){
            $("#default_loading").hide();
            $('#loading').html("<i style='font-size: 20px' class='fa fa-spinner fa-pulse fa-1x fa-fw'></i>");
            $("#loading").show();
        },
        success: function(data){
            if(data !== null) {
                $(".result").html(data);
                // $('#form_data')[0].reset(); 
            }
            $('#loading').hide();
            $('#default_loading').show();
        },
        error: function(){
            $("#loading").fadeOut("slow");
            $("#default_loading").hide();
        }
    });        
}



function save_elementpnb_id(id = 0){
  $('#NUMERO_PLAQUE').val(id)

  alert($('#NUMERO_PLAQUE').val());
}

</script> 



<script type="text/javascript">

  $(document).ready(function () {

      // $('#close_div').hide();
      
      $('#div_panel').delay(100).hide('show');
    });


  function close_modal(){
    $('#div_panel').delay(100).hide('show');
    // $('#form_data')[0].reset();
  }

  function getModal(id){

    // alert(1)
     
      $('#div_panel').delay(100).show('hide');
      // $('#div_panel').show();
      // $('#close_div').show();
      
    }

</script>



<script type="text/javascript">


    function getDetailControl(id = 0) {


      $('#detailControl').modal()



        $.ajax({
          url : "<?=base_url()?>PSR/Historique/gethistoControl/"+id,
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {ID:id},
          beforeSend:function () { 
            $('#donneControls').html("");
          },
          success:function(data) {
           $('#donneControls').html(data.views_detail);
           $('#donneTitres').html(data.titres);
          
          },
          error:function() {
            $('#donneControls').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher cette page! Veuillez réessayer</div>');
          }
      });
      
    }







  $(document).ready(function(){
    getMaps();
     
  
    setInterval(function() {
       // check_new();

      },20000);
    });

    function getMaps(id = null){

    var NUMERO_PLAQUE=$('#NUMERO_PLAQUE').val();
    var NUMERO_PERMIS=$('#NUMERO_PERMIS').val();
    var annee=$('#annee').val();  
    var jour=$('#jour').val();
    var mois=$('#mois').val();  
    var IS_PAID=$('#IS_PAID').val();
    var ID_CATEGORIE=$('#ID_CATEGORIE').val();
    var ID_PSR_ELEMENT= id;
    var search=$('#search').val();

     var ID_CATEGORIE_NEW=$('#ID_CATEGORIE_NEW').val();

    // alert(ID_PSR_ELEMENT)

        $.ajax({
          url : "<?=base_url()?>geo/Carte_Centre_Situation/get_carte/",
          type : "POST",
          dataType: "JSON",
          cache:false,
         
         data: {
          NUMERO_PLAQUE:NUMERO_PLAQUE,
          NUMERO_PERMIS:NUMERO_PERMIS,  
          annee:annee,
          jour:jour,  
          mois:mois,
          ID_CATEGORIE_NEW : ID_CATEGORIE_NEW,
          IS_PAID:IS_PAID,
          ID_CATEGORIE:ID_CATEGORIE,
          ID_PSR_ELEMENT:ID_PSR_ELEMENT,
          search:search,
         },
          beforeSend:function () { 

            $('#reload_page').show();
            $('#mapview').hide();
          },
          success:function(data) {

            
            $('#mapview').show();
            var x = document.getElementById("myAudio"); 

            if (data.id==1) 
            {
              xhhh.play(); 
            }

            // alert(data.id)
           
           $('#mapview').html(data.cartes);
           $('#legende_map').html(data.leg);
           // $("#d_table1").DataTable();
            $('#reload_page').hide();
          },
          error:function() {
            $('#carte_').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher la carte! Veuillez réessayer</div>');
          }
      });
    }

     


  </script>


<script type="text/javascript">
   function check_new() 
      {
        $.ajax({
          url : "<?=base_url()?>geo/Carte_Centre_Situation/check_new",
          type : "GET",
          dataType: "JSON",
          cache:false,
          success:function(data) {
           

            if (data.nbr==1) {
             
              $('#ID_CATEGORIE_NEW').val(data.catego);

              getMaps();
     
              // getMaps(data.nbr);
              
            }
          }
        });
      }

</script>

    
   

<script>
    function submit_f(){
    
    myform.submit();
  }
  
</script>
   



<script type="text/javascript">
  




  function sendMessage(num = null){
    
    if ($('#MessageText').val() == ''){

      $('#MessageText').focus()

    }else{

      $.ajax({
          url : "<?=base_url()?>geo/Elements_Pnb/sendMessage/",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {IdAgents:$('#IdAgents').val(),phoneNumber:$('#phoneNumber').val(),MessageText:$('#MessageText').val()},

          beforeSend:function () { 
            alert_encours()

          },
          success:function(data) {
            if (Number(data) == 1) {
              alert_succes("Message envoyé avec succès")
              $('#MessageText').val("")
              $('#MessagePolice').modal('hide')
            }else{
              alert_erro("Message non envoyer problème soit de connexion")
             
            }
            
           
          
          },
          error:function() {
            alert_erro("Message non envoyer problème soit de connexion")
          }
      });

    }

 
  }





  function alert_succes_chec(message){

         Swal.fire("Vérification de la facture avec succès!", message, "success");
 }


 function alert_succes(message){

         Swal.fire(message, '', "success");
 }



 function alert_erro(message){

         Swal.fire({
                   icon: 'error',
                   title: message,
                   text: 'Veillez réessayer plus tard merci!',
                   //footer: '<a href="<?=base_url()?>?</a>'
                 })
 }


  function alert_encours(message = ""){

         Swal.fire({
                 title: 'Connexion encours !',
                 html: 'Veillez patienter <b></b>  sécondes prés ...',
                 timer: 6000,
                 timerProgressBar: true,
                 didOpen: () => {
                   Swal.showLoading()
                   const b = Swal.getHtmlContainer().querySelector('b')
                   timerInterval = setInterval(() => {
                     b.textContent = Swal.getTimerLeft()
                   }, 100)
                 },
                 willClose: () => {
                   clearInterval(timerInterval)
                 }
               }).then((result) => {
               /* Read more about handling dismissals below */
                 if (result.dismiss === Swal.DismissReason.timer) {
                  console.log('I was closed by the timer')
                 }
               })
 }




 function get_donne_permis(id){

        $('#detail_perfoemance').modal()
        $('#donneTitre_autre').html("Tableau de bord d'un conduiteur")
 
        $.ajax({
          url : "<?=base_url()?>ihm/Permis/get_donne_permis/"+id,
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {ID:id},
          beforeSend:function () { 
            $('#donnePerformance').html('<center><font color="#000"><i class="fas fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span></font></center>');
          },
          success:function(data) {
           $('#donnePerformance').html(data.donne_permis);
           //$('#perdoTitre').html(data.titres);
          
          },
          error:function() {
            $('#donnePerformance').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher cette page! Veuillez réessayer</div>');
          }
      });
   }








  function get_detail_performance(id){

        $('#detail_perfoemance').modal()


        $.ajax({
          url : "<?=base_url()?>ihm/Performance_Police/getperformance/"+id,
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {ID:id},
          beforeSend:function () { 
            $('#donnePerformance').html('<center><font color="#000"><i class="fas fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span></font></center>');
          },
          success:function(data) {
           $('#donnePerformance').html(data.cartes);
           //$('#perdoTitre').html(data.titres);
          
          },
          error:function() {
            $('#donnePerformance').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher cette page! Veuillez réessayer</div>');
          }
      });
   }


   function get_detail_Pdl(id = 0,phone = 0){

        // alert();

         $('#MessagePolice').modal()
        
         $('#phoneNumber').val(phone)

         $('#IdAgents').val(id)

      
     
    
    //window.location.href = '<?=base_url("ihm/Performance_Police/index/")?>'+id;
  }

  $(document).ready(function(){
    getMaps();
     
  
     setInterval(function() {
       $('#MessageText').focus()

      },1000);


     });

  
     


  </script>




    
   

<script>
    function submit_f(){
    
    myform.submit();
  }
  
</script>
   