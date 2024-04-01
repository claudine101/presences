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

 


  <!-- <marquee><h5 style="font-family:  Impact, Haettenschweiler, Franklin Gothic, Charcoal, Helvetica Inserat, Bitstream Vera Sans Bold, Arial Black, sans serif;"><font color="red"><b>Dernier </b></font>  <?=$dernier['DESCRIPTION'].'   '.$dernier['NUMERO']?> - date <?=$dernier['DATE_INSERTION']?>  - Poste: <?= $dernier['LIEU_EXACTE']?> - Agent <?= $dernier['NOM']?> <?= $dernier['PRENOM']?> N° matricule  <b><?= $dernier['NUMERO_MATRICULE']?></b> </h5></marquee> -->


   <?php 
    }  
 ?>
  </div>
  </div>

<div class="card-body stretch-card" style="width: ;height: 93.5vh; margin-top: -20px" id="map"></div>
 <div class="row">
  <!-- <div class="col-md-12"> -->
              


<!-- </div> -->

<div style="float: left;margin-top: -35px; z-index: 1; margin-left: 15px;">

  <div class='col-md-12'>
    <div class="row">
      <button style="border-radius: 0px" title="Légende" onclick="getModal_lengende()"  type="button" class="btn btn-secondary btn-sm"><i class="fa fa-list"></i> Légende</button>
    </div>
    
  </div>

</div>

     

  


</div>

<script type="text/javascript">
  function close_modal1(){
   
     $('#div_panel1').delay(100).hide('show');
  }
function getModal_lengende(id){
    /*$('#div_panel1').attr('hidden',false);*/
    $('#div_panel1').delay(100).show('hide');
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
        .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v12'));


  var layers = {
      Streets: L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v12'),
      Satellite: L.mapbox.styleLayer('mapbox://styles/mapbox/satellite-streets-v12'),
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










/// fourriere 




map.addControl(L.mapbox.geocoderControl('mapbox.places', {
    autocomplete: true
}));


<?=$donne_fours?>

//    L.marker([-3.2147, 29.4789],{
//           icon: L.mapbox.marker.icon({
//             'marker-color':'#4F57DD',
//             'marker-size':'small',
//             'marker-symbol':'police',
//           })
//         }
//     ).bindPopup("").addTo(map);


// var points = [
//     [-3.1247, 29.1478],
//     [-3.2147, 29.4789]
// ];

// // polyline
// var selection = [points];
// var polyline = new L.Polyline([selection], {
//     color: 'red',
//     weight: 5,
//     dashArray: '20, 20',
//     dashOffset: '0',
//     smoothFactor: 0.1
// }).addTo(map);






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

 marker.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;<a href="#" title="'+current_val[3]+'" onclick="get_donne_plaques(this.title)">'+current_val[3].toUpperCase()+'</a></b><br>🤵🏽‍♂️ &nbsp;De <b>'+current_val[22].toUpperCase()+'</b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>').addTo(map);


  last.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div>🚘 &nbsp;Plaque <b><a href="#" title="'+current_val[3]+'" onclick="get_donne_plaques(this.title)">'+current_val[3].toUpperCase()+'</a></b><br>💳 &nbsp;<a href="#" title="'+current_val[21]+'" onclick="get_donne_permis(this.title)">'+current_val[21].toUpperCase()+'</a></b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>').addTo(map);

  
  markers_last.addLayer(last);
  markers_last.addLayer(marker);
}


if (current_val[8]==1 && current_val[16]==1) {
var icon1=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': current_val[17]})  
  
  
  var marke1 = L.marker([current_val[0],current_val[1]],{icon:icon1});
  // marke.addTo(map);
  marke1.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div>🚘 &nbsp;Plaque <b><a href="#" title="'+current_val[3]+'" onclick="get_donne_plaques(this.title)">'+current_val[3].toUpperCase()+'</a></b><br>🤵🏽‍♂️ &nbsp;De <b>'+current_val[22].toUpperCase()+'</b><br>💳 &nbsp;<a href="#" title="'+current_val[21]+'" onclick="get_donne_permis(this.title)">'+current_val[21].toUpperCase()+'</a></b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>');

    markers.addLayer(marke1);
  
 }


if (current_val[8]==2 && current_val[16]==1) {
var icon2=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': current_val[17]})
  
  var marke2 = L.marker([current_val[0],current_val[1]],{icon:icon2});
  // marke.addTo(map);
  marke2.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;<a href="#" title="'+current_val[3]+'" onclick="get_donne_plaques(this.title)">'+current_val[3].toUpperCase()+'</a></b><br>🤵🏽‍♂️ &nbsp;De <b>'+current_val[22].toUpperCase()+'</b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>');

    markers2.addLayer(marke2);
  
 }

if (current_val[8]==3 && current_val[16]==1) {
var icon3=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': current_val[17]})
  
  var marke3 = L.marker([current_val[0],current_val[1]],{icon:icon3});
  // marke.addTo(map);
  marke3.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;<a href="#" title="'+current_val[3]+'" onclick="get_donne_plaques(this.title)">'+current_val[3].toUpperCase()+'</a></b><br>🤵🏽‍♂️ &nbsp;De <b>'+current_val[22].toUpperCase()+'</b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>');
    markers3.addLayer(marke3);
  
 }

 if (current_val[8]==6 && current_val[16]==1) {
var icon6=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': current_val[17]})
  
  var marke6 = L.marker([current_val[0],current_val[1]],{icon:icon6});
  // marke.addTo(map);
  marke6.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;<a href="#" title="'+current_val[3]+'" onclick="get_donne_plaques(this.title)">'+current_val[3].toUpperCase()+'</a></b><br>🤵🏽‍♂️ &nbsp;De <b>'+current_val[22].toUpperCase()+'</b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>');
    markers6.addLayer(marke6);
  
 }

  if (current_val[8]==7 && current_val[16]==1) {
  var icon7=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': current_val[17]})
  
  var marke7 = L.marker([current_val[0],current_val[1]],{icon:icon7});
  // marke.addTo(map);
  marke7.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;<a href="#" title="'+current_val[3]+'" onclick="get_donne_plaques(this.title)">'+current_val[3].toUpperCase()+'</a></b><br>🤵🏽‍♂️ &nbsp;De <b>'+current_val[22].toUpperCase()+'</b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>');
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

  var icon3=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-size':'small', 'marker-color': '848484'})
  
  var marke4 = L.marker([current_val[0],current_val[1]],{icon:icon3});
  // marke.addTo(map);
  marke4.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;<a href="#" title="'+current_val[3]+'" onclick="get_donne_plaques(this.title)">'+current_val[3].toUpperCase()+'</a></b><br>🤵🏽‍♂️ &nbsp;De <b>'+current_val[22].toUpperCase()+'</b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>');

  var lls = L.latLng(current_val[0],current_val[1]);

   var cssIcons = L.divIcon({
      className: 'css-icon',
      html: '<div class="gps_ringss"></div>'
      ,iconSize: [15,15]
      // ,iconAnchor: [11,11]
    });
    //  marker = L.marker(lls, {
    //   icon: cssIcons,
    //   title: ''
    // }).bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;<a href="#" title="'+current_val[3]+'" onclick="get_donne_plaques(this.title)">'+current_val[3].toUpperCase()+'</a></b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',<br>📚 &nbsp;N°'+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a><hr><a href="#" onclick="get_detail_Pdl('+current_val[19]+','+current_val[20]+')">✉️ &nbsp; '+current_val[20]+' ...</a></b><br><a href="#" onclick="get_detail_performance('+current_val[19]+')">🧐 &nbsp; Total PV</a></div></div></div>').addTo(map)

    

    //markers8.addLayer(marker);

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
    //map.addLayer(markers8);

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
    //map.addLayer(markers8);
  

}else if($(this).is(":not(:checked)")){

    
    map.removeLayer(markers4);
     //map.removeLayer(markers8);
 
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