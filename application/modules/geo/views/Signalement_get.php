
<style type="text/css">
  .mapIcon{
    font-size: 20px;
  }
</style>
 <div class="row">








  <div class="col-md-8">
              

<div style="width: 100%;height: 550px;" id="map"></div>

</div>


 <div class="col-md-4">


<select onchange="getMaps()" id="PROVINCE_ID" name="PROVINCE_ID" class="form-control">
                                 <option value="0">Province</option>
                                 <?php 

                                   
                                    foreach ($provinces as $key) {
                                      # code...
                                      if($PROVINCE_ID==$key['PROVINCE_ID']){
                                        ?>
                                        <option selected value="<?php echo $key['PROVINCE_ID'] ?>"><?php echo $key['PROVINCE_NAME'] ?></option>
                                        <?php
                                      }else{
                                        ?>
                                         <option value="<?php echo $key['PROVINCE_ID'] ?>"><?php echo $key['PROVINCE_NAME'] ?></option>
                                        <?php
                                      }
                                    }
                                  ?>
                               </select>

<br>

<br>

<br>

          
  <div id='legend' style='background: transparent;'>
  <strong>Légende</strong>

<br>

<br>
  <hr>
  <nav class='legend'>
     
     <table class="">
       

        <tr>
         <td style="width:20%"><label style='background: #0ec85f;width: 16px;height: 16px;border-radius: 10px;'></label></td>
         <td>&emsp;<input type="checkbox" checked  name="opt0_5"> Véhicule verbalisé en ligne
           (<b id="vehiculeTraiteVerba"></b> / <?=number_format($nombreVehicule,0,',',' ')?>)</td>
         </tr>


          <tr>
         <td style="width:20%"><label style='background: #000;width: 16px;height: 16px;border-radius: 10px;'></label></td>
         <td>&emsp;<input type="checkbox" checked  name="opt0"> Déclarations pour un véhicule non-traité
           (<b id="vehiculeNotriatre"></b> / <?=number_format($nombreVehicule,0,',',' ')?>)</td>
         </tr>



        <tr>
         <td><label style='background:green;width: 16px;height: 15px;border-radius: 10px;'></label></td>
         <td>&emsp;<input type="checkbox" checked  name="opt4">  Déclarations pour un véhicule traité
           (<b id="vehiculeTraite"></b> / <?=number_format($nombreVehicule,0,',',' ')?>)</td>
         </tr>

         
        <tr>
         <td><label style='background:red ;width: 16px;height: 15px;border-radius: 10px;'></label></td>
         <td>&emsp;<input type="checkbox" checked  name="opt1"> Accidents (<a href="#" onclick="getincident(1)"><?=number_format($accident,0,',',' ')?></a>)</td>
         </tr>
         <tr>
         <td><label style='background:blue;width: 16px;height: 15px;border-radius: 10px;'></label></td>
         <td>&emsp;<input type="checkbox" checked  name="opt2">  Embouteillages (<a href="#" onclick="getincident(2)"><?=number_format($embout,0,',',' ')?></a>)</td>
         </tr>
         <tr>
         <td><label style='background:orange;width: 16px;height: 15px;border-radius: 10px;'></label></td>
         <td>&emsp;<input type="checkbox" checked  name="opt3">  Déclaration vol 
          averés (<a href="#" onclick="getincident(3)"><?=number_format($vol,0,',',' ')?></a>)</td>
         </tr>

      <!--   <tr>
         <td><label style='background:#30d930;width: 16px;height: 15px;border-radius: 10px;'></label></td>
         <td>&emsp;<input type="checkbox" checked  name="opt4">  Declaration vol 
          averés (<a href="#" onclick="getincident(4)"><?=number_format($accident,0,',',' ')?></a>)</td>
         </tr>
                -->
     </table>
    
     
    
  </nav>
</div>  
<br> 


<br>
<small>Source: <a href="#link to source">MediaBox</a></small>
    <!-- <button type="button" class="btn btn-primary form-control"><a href="<?php echo base_url();?>/PSR/Psr_elements/index" style="color:#fff"> Element PNB >></a> </button> -->
 
</div>


</div>

     

  


</div>


<script type="text/javascript">


$(document).ready(function(){


$('input[name="opt0"]').click(function(){
  
if($(this).is(":checked")){
     

    map.addLayer(markers_last);

 

}else if($(this).is(":not(:checked)")){

    
    map.removeLayer(markers_last);

}
});


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


$('input[name="opt4"]').click(function(){
  
if($(this).is(":checked")){
     
    map.addLayer(markers5);
  

}else if($(this).is(":not(:checked)")){

    
    map.removeLayer(markers5);
 
}
});


$('input[name="opt0_5"]').click(function(){
  
if($(this).is(":checked")){
     
    map.addLayer(markers05);
  

}else if($(this).is(":not(:checked)")){

    
    map.removeLayer(markers05);
 
}
});






});

 

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
      Sombre: L.mapbox.styleLayer('mapbox://styles/mapbox/navigation-guidance-night-v4'),
  };

  layers.Streets.addTo(map);
  L.control.layers(layers).addTo(map);

  L.control.fullscreen().addTo(map);
  


  
  var markers_last = new L.MarkerClusterGroup();
  var markers =  new L.MarkerClusterGroup();//new L.MarkerClusterGroup(); //L.featureGroup();
  var markers2 =  new L.MarkerClusterGroup();//new L.MarkerClusterGroup(); //L.featureGroup();
  var markers3 =  new L.MarkerClusterGroup();//new L.MarkerClusterGroup(); //L.featureGroup();
  var markers4 = new L.MarkerClusterGroup();//new L.MarkerClusterGroup();

  var markers5 = new L.MarkerClusterGroup();//new L.MarkerClusterGroup();

  var markers05 = new L.MarkerClusterGroup();//new L.MarkerClusterGroup();




/*VEHICULE DECLARATION*/

var vehicule_detail = "<?= $vehicule_detail ?>";
console.log(vehicule_detail);

if (vehicule_detail !="") {

var vehicule_detail = vehicule_detail.split("$");

var vehiculeNotre = 0;
var vehiculeTraite = 0;
var vehiculeTraiteVerba = 0;

for (var i = 0; i < (vehicule_detail.length)-1; i++) {

var current_val = vehicule_detail[i].split("<>");

// statut_traitement (16)
// is_valide (17)
// alert(Number(current_val[16])+" "+Number(current_val[17]))


if (Number(current_val[17])==0 && Number(current_val[16])==0) {


    vehiculeNotre ++;


    var cssIcon = L.divIcon({
      className: 'css-icon',
      html: '<div class="gps_ringOld" ><font color="green" style="font-size:19px" class="mapIconVehicu" id="mapIconVehicu'+current_val[14]+'" ></font></div>'
      ,iconSize: [22,22]
    });

    var ll = L.latLng(current_val[0],current_val[1]);

    markerNew = L.marker(ll, {
      icon: cssIcon,
      title: ''
    });


    markerNew.bindPopup("<div class='card'><div class='card-header text-center'><h4><font color='white'><b>"+current_val[9]+"</b></font></h4></div><div class='card-body'>🚘 &nbsp; N° <b>"+current_val[10]+"</b><br>👮🏾 &nbsp; <b style='font-size:13px'>"+current_val[11]+"</b></span><br>🤓 &nbsp; <b> "+current_val[2]+"</b><br>💼 &nbsp; ("+current_val[3]+")  <b><br><a href='#' title='"+current_val[7]+"' onclick='getDetailControl(this.title)' >🧐 &nbsp; voir plus d'image...</a> <hr><b style='text-decoration: underline;padding:5px'>Commentaire</b>:<p style='font-family: times;font-size:13px;padding-left:8px'>"+current_val[13]+"</p><span style='float: left;font-size:12px'><a href='#'  onclick='get_detail_vehicule("+current_val[14]+")' >✅ &nbsp; Prendre en charge</a></span><span style='background:rgba(0, 0, 0, 0.5);color:#fff;border-radius:5px; padding:2px;float: right;font-size:12px'>"+current_val[6]+"</span></div></div></div>");

       // marker.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><b>🚘 &nbsp;'+current_val[3].toUpperCase()+'</b><br>🗓️ &nbsp;'+current_val[4]+'<br>👮🏾 &nbsp;'+current_val[5]+',N° '+current_val[7]+' <br>📍 &nbsp;'+current_val[14]+'<br>💵&nbsp; Amende de '+current_val[13]+'<br><a href="#" onclick="getDetailControl('+current_val[15]+')">🧐 &nbsp;voir plus..</a></div></div></div>').addTo(map);




markers_last.addLayer(markerNew);

}else if (Number(current_val[16]) > 0  && Number(current_val[17]) == 0){


var encours = '<i class="fas fa-sync fa-spin fa-0x fa-fw"></i>';


vehiculeTraite ++;


var icon5 = L.divIcon({
                className: 'label',
                html: '<span  ><font color="green" style="font-size:15px" class="mapIconVehicu" id="mapIconVehicu'+current_val[14]+'" >'+encours+'</font></span>', });

var marke5 = L.marker([current_val[0],current_val[1]], {icon: icon5});

  marke5.bindPopup("<div class='card'><div class='card-header text-center'><h4><font color='white'><b>"+current_val[9]+"</b></font></h4></div><div class='card-body'>🚘 &nbsp; N° <b>"+current_val[10]+"</b><br>👮🏾 &nbsp; <b style='font-size:13px'>"+current_val[11]+"</b></span><br>🤓 &nbsp; <b> "+current_val[2]+"</b><br>💼 &nbsp; ("+current_val[3]+")  <b><br><a href='#' title='"+current_val[7]+"' onclick='getDetailControl(this.title)' >🧐 &nbsp; voir plus d'image...</a> <hr><b style='text-decoration: underline;padding:5px'>Commentaire</b>:<p style='font-family: times;font-size:13px;padding-left:8px'>"+current_val[13]+"</p><span style='float: left;font-size:12px'><a href='#' ><i class='fas fa-sync fa-spin fa-0x fa-fw'></i> encours de traitement</a></span><span style='background:rgba(0, 0, 0, 0.5);color:#fff;border-radius:5px; padding:2px;float: right;font-size:12px'>"+current_val[6]+"</span></div></div></div>");




markers5.addLayer(marke5);


}else if (Number(current_val[16]) >= 3 && Number(current_val[17]) == 1){


var encoursS = '<i class="fas fa-dot-circle"></i>';


vehiculeTraiteVerba ++;


var icon05 = L.divIcon({
                className: 'label',
                html: '<span  ><font color="#0ec85f" style="font-size:15px" class="mapIconVehicu" id="mapIconVehicu'+current_val[14]+'" >'+encoursS+'</font></span>', });

var marke05 = L.marker([current_val[0],current_val[1]], {icon: icon05});

  marke05.bindPopup("<div class='card'><div class='card-header text-center'><h4><font color='white'><b>"+current_val[9]+"</b></font></h4></div><div class='card-body'>🚘 &nbsp; N° <b>"+current_val[10]+"</b><br>👮🏾 &nbsp; <b style='font-size:13px'>"+current_val[11]+"</b></span><br>🤓 &nbsp; <b> "+current_val[2]+"</b><br>💼 &nbsp; ("+current_val[3]+")  <b><br><a href='#' title='"+current_val[7]+"' onclick='getDetailControl(this.title)' >🧐 &nbsp; voir plus d'image...</a> <hr><b style='text-decoration: underline;padding:5px'>Commentaire</b>:<p style='font-family: times;font-size:13px;padding-left:8px'>"+current_val[13]+"</p><span style='float: left;font-size:12px'><a href='#' >✅ Amende de "+current_val[11]+"</a></span><span style='background:rgba(0, 0, 0, 0.5);color:#fff;border-radius:5px; padding:2px;float: right;font-size:12px'>"+current_val[6]+"</span></div></div></div>");




markers05.addLayer(marke05);


}







  
}





}


$('#vehiculeTraiteVerba').html(vehiculeTraiteVerba)

$('#vehiculeNotriatre').html(vehiculeNotre)

$('#vehiculeTraite').html(vehiculeTraite)


/*Accident*/

var data_donne = "<?= $data_accident ?>";

var data_donne = data_donne.split("$");

for (var i = 0; i < (data_donne.length)-1; i++) {

var current_val = data_donne[i].split("<>");


var icon = L.divIcon({
                className: 'label',
                html: '<span  onclick="get_detail_Pdl('+current_val[7]+')"><font color="red" class="mapIcon" id="mapIcon'+current_val[0]+'" ><i class="fas fa-taxi"></i></font></span>', });

var marke1 = L.marker([current_val[0],current_val[1]], {icon: icon});

  marke1.bindTooltip('<table width="300"><span style="font-size:11px;color:#000"><tr><td> <center><img src="'+current_val[7]+'" width="50" height="50" style="border-radius:50%; border : 1px solid #aaa"></center></td><td></td><td> <b style="color:#000;"> Accident '+current_val[5]+'</b><br><b>'+current_val[8]+'</b></span><br> signaler par <b> '+current_val[2]+' </b><br> <span style="font-size:11px;color:#000">'+current_val[3]+'</span>  </b><br> '+current_val[6]+' </span></b></td></tr></span></table>');

  markers.addLayer(marke1);
  
}





/*Embouteillage*/


var data_emboutaill = "<?= $data_emboutaill ?>";

var data_emboutaill = data_emboutaill.split("$");

for (var i = 0; i < (data_emboutaill.length)-1; i++) {

var current_val = data_emboutaill[i].split("<>");


var icon = L.divIcon({
                className: 'label',
                html: '<span  onclick="get_detail_Pdl('+current_val[7]+')"><font color="blue" class="mapIcon" id="mapIcon'+current_val[0]+'" ><i class="fas fa-taxi"></i></font></span>', });

var marke2 = L.marker([current_val[0],current_val[1]], {icon: icon});

  marke2.bindTooltip('<table width="300"><span style="font-size:11px;color:#000"><tr><td> <center><img src="'+current_val[7]+'" width="50" height="50" style="border-radius:50%; border : 1px solid #aaa"></center></td><td></td><td> <b style="color:#000;"> Embouteillage <br>'+current_val[5]+'</b><br><b>'+current_val[8]+'</b></span><br> signaler par <b> '+current_val[2]+' </b><br> <span style="font-size:11px;color:#000">'+current_val[3]+'</span>  </b><br> '+current_val[6]+' </span></b></td></tr></span></table>');

  markers2.addLayer(marke2);
  
}




/*Declaration vole*/


var data_vols = "<?= $data_vols?>";

var data_vols = data_vols.split("$");

for (var i = 0; i < (data_vols.length)-1; i++) {

var current_val = data_vols[i].split("<>");


var icon = L.divIcon({
                className: 'label',
                html: '<span  onclick="get_detail_Pdl(1)"><font color="orange" class="mapIcon" id="mapIcon" ><i class="fas fa-taxi"></i></font></span>', });

var marke3 = L.marker([current_val[0],current_val[1]], {icon: icon});

  marke3.bindTooltip('<table width="300"><span style="font-size:11px;color:#000"><tr><td> <center><img src="'+current_val[11]+'" width="50" height="50" style="border-radius:50%; border : 1px solid #aaa"></center></td><td></td><td> <b style="color:#000;"> Declaration vol <br>'+current_val[10]+' </b><br><b>'+current_val[4]+'</b></span><br> couleur <b> '+current_val[7]+' </b><br> serie <span style="font-size:11px;color:#000">'+current_val[8]+'</span>  </b><br>categorie '+current_val[9]+' <br>Declarant '+current_val[3]+' <br> '+current_val[6]+' <br>date vol '+current_val[5]+' </span></b></td></tr></span></table>');

  markers3.addLayer(marke3);
  
}
markers05


    map.addLayer(markers);
    map.addLayer(markers2);
    map.addLayer(markers3);
    map.addLayer(markers5);
    map.addLayer(markers05);
    map.addLayer(markers_last);



   var bounds = markers_last.getBounds(); 
map.fitBounds(bounds);





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