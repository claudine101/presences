<style type="text/css">

 #div_panel1{
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


<input type="hidden" name="ID_CATEGORIE_NEW" id="ID_CATEGORIE_NEW">


<div class="row"><div class="col-sm-12">



  <?php if (!empty($dernier['ID_HISTORIQUE'])) {

     $middle = strtotime($dernier['DATE_INSERTION']);             // returns bool(false)

     $new_date = date('d-m-Y H:i', $middle);


   ?>

 


  <marquee><h5 style="font-family:  Impact, Haettenschweiler, Franklin Gothic, Charcoal, Helvetica Inserat, Bitstream Vera Sans Bold, Arial Black, sans serif;"><font color="red"><b>Dernier </b></font>  <?=$dernier['DESCRIPTION'].'   '.$dernier['NUMERO']?> - date <?=$dernier['DATE_INSERTION']?>  - Poste: <?= $dernier['LIEU_EXACTE']?> - Agent <?= $dernier['NOM']?> <?= $dernier['PRENOM']?> N° matricule  <b><?= $dernier['NUMERO_MATRICULE']?></b> </h5></marquee>
   <?php 
    }  
 ?>
  </div>
  </div>

 <div class="row">
  <div class="col-md-12">
              
<div style="width: 100%;height: 650px;" id="map"></div>

</div>

<div style="float: left;margin-top: -35px; z-index: 1; margin-left: 15px;">

  <div class='col-md-12'>
    <div class="row">
      <button style="border-radius: 0px" title="Légende" onclick="getModal_lengende()"  type="button" class="btn btn-secondary btn-sm"><i class="fa fa-list"></i> Légende</button>
    </div>
    
  </div>

</div>

 <div hidden="" class="card col-md-12" id="div_panel1" style="max-height: 650px; overflow-x: auto;padding: 5px;padding: 10px;">
  <div class="card-header text-left">
              <font color="#fff"><i class="icon-address-card"></i></font>
              <span id="titre_op"></span>
              <button style="float: left;"  id="close_div" onclick="close_modal1()" class="btn btn-sm">
                <font color="#fff">
                  <i class="fa fa-times"></i>
                </font>
              </button>
            </div>
            <div class="card-body" style="background-color: white">
  <div class="row" style="">
    <div class="col-md-9">
      <label>Catégories</label>
      <select class="form-control"  onchange="getMaps()" name="ID_CATEGORIE" id="ID_CATEGORIE">
       <option value="">Sélectionner</option>
      <?php

      foreach ($categorie as $value){
      if ($value['ID_CATEGORIE'] == set_value('ID_CATEGORIE'))
      {?>
      <option value="<?=$value['ID_CATEGORIE']?>" selected><?=$value['DESCRIPTION']?></option>
      <?php } else{ 
       ?>
      <option value="<?=$value['ID_CATEGORIE']?>" ><?=$value['DESCRIPTION']?></option>
      <?php } } ?>
            </select>
    </div>
    <div class="col-md-3">
      <br>
      <button title="Autre filtre" onclick="getModal()" style="margin-top: 6px" type="button" class="btn btn-secondary btn-block"> <i class="fa fa-filter"></i> </button>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <!-- <label>Elément de la PNB</label> -->
      <form id="form_data">
      <div class="input-group">


      <div class="input-group-prepend">
       <!--  <span class="input-group-text">
          <i id="default_loading" class="fa fa-search" aria-hidden="true"></i>
          <i id="loading"></i>
        </span> -->
        
      </div>
    </div>
    </form>
     <!--  <span class="result"></span> -->
    </div>
  </div>
  <div>

                           
  </div>

            <div>
    

       
  </div><br>
             <strong>Dix dernières vérifications</strong>
  <hr>
            <div id="demo" class="carousel slide" data-ride="carousel">

  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>

  <!-- The slideshow -->
  <div class="carousel-inner">


    <?php 

    $i=0;
    foreach ($dernier_2 as $key => $value) {

     $i++;
     $indic=0;
     $active='';
     
     if ($i==1) {
     $active='active';
     }

    //$indic='Vérification dernière N° '.$i;
    $indic='Dernier contrôle '.$i.'/10';
    
    $middle = strtotime($value['DATE_INSERTION']);           

    $new_date = date('d-m-Y H:i', $middle);
     
     ?>
    <div class="carousel-item <?=$active?>">

      <div class="card-body text-center">
      
      <h5 class="trans"><?=$indic?></h5> Poste: <?= $value['LIEU_EXACTE']?><br>
      <?=$value['DESCRIPTION']?> <br>Agent <?= $value['NOM']?> <?= $value['PRENOM']?><br>
      <?=$value['NUMERO']?><br>
      N° matricule <?= $value['NUMERO_MATRICULE'] ?>.<br>
       <?= $new_date ?><br>
      
      </div>

      
    </div>

   <?php  }  ?>
    
  </div>
 

  <!-- Left and right controls margin-left: -80px -->
  <a  class="carousel-control-prev" href="#demo" data-slide="prev">
    <span style="background-color: black;" class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span style="background-color: black;"  class="carousel-control-next-icon"></span>
  </a>

</div>
<br>
             
          
      <div id='legend' style='background: transparent;'>
  <strong>Légende</strong>
  <hr>
  <nav class='legend'>
     
     <table class="" width="100%">

        <?= $labels?>

     
         
          <tr>
         <td width="100%"><span style='background:#848484;width: 15px;height: 15px;border-radius: 10px;'></span>
         &emsp;<input type="checkbox" checked  name="opt4">  Contrôle annulé (<a href="#" onclick="getincident(4)"><?=number_format($Scan,0,',',' ')?></a>)</td>
         </tr>

         <!-- <tr>
         <td><label style='background:#37AC02;width: 16px;height: 15px;border-radius: 10px;'></label></td>
         <td>&emsp;Dernier incident (<a href="#" onclick="getincident(4)"><?=number_format($fermenonavere,0,',',' ')?></a>)</td>
         </tr> -->
         
            
       
     </table>
    
     
    <small>Source: <a href="#link to source">MediaBox</a></small>
  </nav>
</div>  
<br> 


    
    <button type="button" class="btn btn-primary form-control"><a href="<?php echo base_url();?>/PSR/Historique" style="color:#fff"> Historiques >></a> </button>
 
</div>
</div>


</div>

     

  


</div>

<script type="text/javascript">
  function close_modal1(){
    $('#div_panel1').attr('hidden',true);
  }
function getModal_lengende(id){
    $('#div_panel1').attr('hidden',false);
  }
</script>


<script type="text/javascript">
 

L.mapbox.accessToken = 'pk.eyJ1IjoibWFydGlubWVkaWFib3giLCJhIjoiY2s4OXc1NjAxMDRybzNobTE2dmo1a3ZndCJ9.W9Cm7Pjp25FQ00bII9Be6Q';

  var center = '<?= $coord; ?>';
  var center_coord = center.split(",");
  var zoom ='<?= $zoom; ?>';

  if(this.map) {
  this.map.remove();
  }
  

  var map = L.mapbox.map('map')
        .setView([center_coord[0],center_coord[1]], zoom)
        .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'));


  var layers = {
      Streets: L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'),
      Satellite: L.mapbox.styleLayer('mapbox://styles/mapbox/satellite-streets-v11'),
  };

  layers.Streets.addTo(map);
  L.control.layers(layers).addTo(map);

  L.control.fullscreen().addTo(map);
  

  var markers_last = L.featureGroup();
  var markers =  new L.MarkerClusterGroup();
  var markers1 =  new L.MarkerClusterGroup();//new L.MarkerClusterGroup(); //L.featureGroup();
  var markers2 =  new L.MarkerClusterGroup();//new L.MarkerClusterGroup(); //L.featureGroup();
  var markers3 =  new L.MarkerClusterGroup();//new L.MarkerClusterGroup(); //L.featureGroup();
  var markers4 = new L.MarkerClusterGroup();//new L.MarkerClusterGroup();
  var markers6 = new L.MarkerClusterGroup();//new L.MarkerClusterGroup();

  var markers7 = new L.MarkerClusterGroup();//new L.MarkerClusterGroup();

  var markers9 = new L.MarkerClusterGroup();//new L.MarkerClusterGroup();

  var markers8 = new L.featureGroup();



////////////////////////////////////////////////////////////////////

var data_donne = "<?= $data_donne ?>";

var data_donne = data_donne.split("$");

// alert(data_donne)

for (var i = 0; i < (data_donne.length)-1; i++) {

var current_val = data_donne[i].split("<>");


if (current_val[6]==1) {


  var cssIcon = L.divIcon({
      // Specify a class name we can refer to in CSS.
      className: 'css-icon',
      html: '<div class="gps_ringu"></div>'
      // Set marker width and height
      ,iconSize: [15,15]
      // ,iconAnchor: [11,11]
    });

//marker latlng
var ll = L.latLng(current_val[0],current_val[1]);
var iconO=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': '000'})  
var last = L.marker([current_val[0],current_val[1]],{icon:iconO});

// create marker
 marker = L.marker(ll, {
  icon: cssIcon,
  title: ''
});

 marker.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;'+current_val[3].toUpperCase()+'</b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>').addTo(map);


  last.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div>🚘 &nbsp;Plaque <b>'+current_val[3].toUpperCase()+'</b><br>💳 &nbsp;<a href="#" title="'+current_val[21]+'" onclick="get_donne_permis(this.title)">'+current_val[21].toUpperCase()+'</a></b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>').addTo(map);

  
  markers_last.addLayer(last);
  markers_last.addLayer(marker);
}


if (current_val[8]==1 && current_val[16]==1) {
var icon1=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': current_val[17]})  
  
  
  var marke1 = L.marker([current_val[0],current_val[1]],{icon:icon1});
  // marke.addTo(map);
  marke1.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div>🚘 &nbsp;Plaque <b>'+current_val[3].toUpperCase()+'</b><br>💳 &nbsp;<a href="#" title="'+current_val[21]+'" onclick="get_donne_permis(this.title)">'+current_val[21].toUpperCase()+'</a></b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>');

    markers.addLayer(marke1);
  
 }


if (current_val[8]==2 && current_val[16]==1) {
var icon2=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': current_val[17]})
  
  var marke2 = L.marker([current_val[0],current_val[1]],{icon:icon2});
  // marke.addTo(map);
  marke2.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;'+current_val[3].toUpperCase()+'</b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>');

    markers2.addLayer(marke2);
  
 }

if (current_val[8]==3 && current_val[16]==1) {
var icon3=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': current_val[17]})
  
  var marke3 = L.marker([current_val[0],current_val[1]],{icon:icon3});
  // marke.addTo(map);
  marke3.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;'+current_val[3].toUpperCase()+'</b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>');
    markers3.addLayer(marke3);
  
 }

 if (current_val[8]==6 && current_val[16]==1) {
var icon6=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': current_val[17]})
  
  var marke6 = L.marker([current_val[0],current_val[1]],{icon:icon6});
  // marke.addTo(map);
  marke6.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;'+current_val[3].toUpperCase()+'</b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>');
    markers6.addLayer(marke6);
  
 }

  if (current_val[8]==7 && current_val[16]==1) {
  var icon7=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': current_val[17]})
  
  var marke7 = L.marker([current_val[0],current_val[1]],{icon:icon7});
  // marke.addTo(map);
  marke7.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;'+current_val[3].toUpperCase()+'</b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>');
    markers7.addLayer(marke7);
  
 }


  if (current_val[8]==8 && current_val[16]==1) {
  var icon9=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': current_val[17]})
  
  var marke9 = L.marker([current_val[0],current_val[1]],{icon:icon9});
  // marke.addTo(map);
  marke9.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>💳 &nbsp;<a href="#" title="'+current_val[21]+'" onclick="get_donne_permis(this.title)">'+current_val[21].toUpperCase()+'</a></b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>');
    markers9.addLayer(marke9);
  
 }



 if (current_val[16]==2) {

  var icon3=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': '848484'})
  
  var marke4 = L.marker([current_val[0],current_val[1]],{icon:icon3});
  // marke.addTo(map);
  marke4.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;'+current_val[3].toUpperCase()+'</b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>');

  var lls = L.latLng(current_val[0],current_val[1]);

   var cssIcons = L.divIcon({
      className: 'css-icon',
      html: '<div class="gps_ringss"></div>'
      ,iconSize: [15,15]
      // ,iconAnchor: [11,11]
    });
     marker = L.marker(lls, {
      icon: cssIcons,
      title: ''
    }).bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;'+current_val[3].toUpperCase()+'</b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>').addTo(map)

    

    markers8.addLayer(marker);

    markers4.addLayer(marke4);
  
 }







}
   

var bounds = markers_last.getBounds(); 
map.fitBounds(bounds);

    
    map.addLayer(markers_last);

    map.addLayer(markers);

    map.addLayer(markers1);
    map.addLayer(markers2);
    map.addLayer(markers3);
    map.addLayer(markers4);
    map.addLayer(markers8);

    map.addLayer(markers6);
    map.addLayer(markers7);

     map.addLayer(markers9);








$(document).ready(function(){


$('input[name="opt1"]').click(function(){
  
if($(this).is(":checked")){
     
    map.addLayer(markers);
  

}else if($(this).is(":not(:checked)")){

    
    map.removeLayer(markers);
 
}
});

$('input[name="opt2"]').click(function(){
  
if($(this).is(":checked")){
     
    map.addLayer(markers2);
  

}else if($(this).is(":not(:checked)")){

    
    map.removeLayer(markers2);
 
}
});


$('input[name="opt3"]').click(function(){
  
if($(this).is(":checked")){
     
    map.addLayer(markers3);
  

}else if($(this).is(":not(:checked)")){

    
    map.removeLayer(markers3);
 
}
});


$('input[name="opt6"]').click(function(){
  
if($(this).is(":checked")){
     
    map.addLayer(markers6);
  

}else if($(this).is(":not(:checked)")){

    
    map.removeLayer(markers6);
 
}
});


$('input[name="opt7"]').click(function(){
  
if($(this).is(":checked")){
     
    map.addLayer(markers7);
  

}else if($(this).is(":not(:checked)")){

    
    map.removeLayer(markers7);
 
}
});


$('input[name="opt8"]').click(function(){
  
if($(this).is(":checked")){
     
    map.addLayer(markers9);
  

}else if($(this).is(":not(:checked)")){

    
    map.removeLayer(markers9);
 
}
});


$('input[name="opt4"]').click(function(){
  
if($(this).is(":checked")){
     
    map.addLayer(markers4);
    map.addLayer(markers8);
  

}else if($(this).is(":not(:checked)")){

    
    map.removeLayer(markers4);
     map.removeLayer(markers8);
 
}
});


});


function doAnimations(){
   var myIcon = document.querySelector('.my-icon')
  
   setTimeout(function(){
      myIcon.style.width = '50px'
      myIcon.style.height = '50px'
      myIcon.style.marginLeft = '-25px'
      myIcon.style.marginTop = '-25px'
    }, 1000)

    setTimeout(function(){
      myIcon.style.borderRadius = '10%'
      myIcon.style.backgroundColor = 'white'
    }, 2000)

    setTimeout(function(){
      myIcon.style.width = '30px'
      myIcon.style.height = '30px'
      myIcon.style.borderRadius = '50%'
      myIcon.style.marginLeft = '-15px'
      myIcon.style.marginTop = '-15px'
    }, 3000)
} 
</script>

<script type="text/javascript">
  $(document).ready(function(){





  //  doAnimations();

  //  setInterval(function(){
  //   doAnimations()
  // }, 300)

    


      });

</script>