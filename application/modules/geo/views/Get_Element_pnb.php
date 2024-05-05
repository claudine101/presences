
<style>
  
  .css-icon {

  }


   .gps_ringss { 
    border: 7px solid #ff008f;
     -webkit-border-radius: 30px;
     height: 19px;
     width: 19px;   
     margin-left: 0px;
     margin-top: 0px;
      -webkit-animation: pulsate 1s ease-out;
      -webkit-animation-iteration-count: infinite; 
      /*opacity: 0.0*/
  }

  .gps_ringutt { 
    border: 7px solid #F30707;
     -webkit-border-radius: 60px;
     height: 20px;
     width: 20px;   
     margin-left: -10px;
     margin-top: -15px;
      -webkit-animation: pulsate 1s ease-out;
      -webkit-animation-iteration-count: infinite; 
      /*opacity: 0.0*/
  }


  .gps_ringu { 
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
<style type="text/css">
  #mapIcon{
    font-size: 20px;
  }
</style>





<div style="width: 100%;height: 630px;" id="map"></div>

</div>


 


<script type="text/javascript">

  function generate_code(taille=0){
    var Caracteres = '1234567809'; 
    var QuantidadeCaracteres = Caracteres.length; 
    QuantidadeCaracteres--; 
    var Hash= ''; 
      for(var x =1; x <= taille; x++){ 
          var Posicao = Math.floor(Math.random() * QuantidadeCaracteres);
          Hash +=  Caracteres.substr(Posicao, 1); 
      }
      return Number(Hash); 
  }

</script>

<script type="text/javascript">


L.mapbox.accessToken = 'pk.eyJ1IjoibWFydGlubWVkaWFib3giLCJhIjoiY2s4OXc1NjAxMDRybzNobTE2dmo1a3ZndCJ9.W9Cm7Pjp25FQ00bII9Be6Q';

  var center = '<?= $coord; ?>';
  var center_coord = center.split(",");
  var zoom ='<?= $zoom; ?>';

 
  var map = L.mapbox.map('map')
        .setView([center_coord[0],center_coord[1]], zoom)
        .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v12'));





  var layers = {
      Streets: L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v12'),
      Satellite: L.mapbox.styleLayer('mapbox://styles/mapbox/satellite-streets-v12'),
      Sombre: L.mapbox.styleLayer('mapbox://styles/mapbox/navigation-guidance-night-v4'),
  };

  layers.Streets.addTo(map);
  L.control.layers(layers).addTo(map);

  L.control.fullscreen().addTo(map);


    map.addControl(L.mapbox.geocoderControl('mapbox.places', {
      autocomplete: true
  }));



  var markers1 =  new L.MarkerClusterGroup();//new L.MarkerClusterGroup(); //L.featureGroup();
  var markers2 =  new L.MarkerClusterGroup();//new L.MarkerClusterGroup(); //L.featureGroup();
  var markers3 = new L.featureGroup();//new L.MarkerClusterGroup(); //L.featureGroup();
  var markers4 = new L.MarkerClusterGroup();//new L.MarkerClusterGroup();


  var markers5 = new L.MarkerClusterGroup();//new L.MarkerClusterGroup();

  ////////////////////////////////////////////////////////////////////

 

  var lls = L.latLng(<?=$gernier['LATITUDE']?>,<?=$gernier['LONGITUDE']?>);

   var cssIcons = L.divIcon({
      className: 'css-icon',
      html: '<div class="gps_ringu"></div>'
      ,iconSize: [15,15]
      // ,iconAnchor: [11,11]
    });
    var marker = L.marker(lls, {
      icon: cssIcons,
      title: ''
    }).addTo(map)

    

map.on('click', function(e) {

    if($('#axeaffect').is(":checked")){
            
            $('#type_aff_id').val(1)
            $('#lieux_id_aff').val("")

            var marker = L.marker(e.latlng, {
            icon: L.mapbox.marker.icon({
                'marker-color': 'ff8888'
            }),
            draggable: true
            });

            var code = generate_code(5);

            // marker.bindPopup('This marker is draggable! Move it around.'+code);
            // marker.addTo(map);

            var marknew = e.latlng;
            

            var signal = L.divIcon({
              className: 'css-icon',
              html: '<div class="gps_ringss"></div>'
              ,iconSize: [15,15]
            });
             markersig = L.marker(marknew, {
              icon: signal,
              title: '',

            }).bindPopup('This marker is draggable! Move it around.'+code)    

            markers5.addLayer(markersig);

            var lat = marknew.lat;
            var lng = marknew.lng;
            var addres = "";


            $.get('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat='+lat+'&lon='+lng+'', function(data){
              
              var namess = data.name != "null" ? data.name : data.address.suburb;

              var addresstype = data.addresstype;

              var pays_code = data.address.country_code;

              $('#pays_text').val(data.address.country)

              $('#pays_id').val(pays_code.toUpperCase())
              
              $('#province_id').val(data.address.state)
              // country '+data.type+'
              $('#Lieux').val(data.address.suburb+','+data.name)

              $('#latlong_donne').val(lat+','+lng)
              
              $('#AdresseComplete').val(data.address)
              
              addres += data.type+' '+data.name;
              var prop = data.addresstype;
           
            });

            var bounds = markers5.getBounds(); 
            map.fitBounds(bounds);

            map.addLayer(markers5);

           


            Swal.fire({
                        title: 'Confirmez-vous ?',
                        text: "l'affectation des agents de la police à cette adresse!\n"+addres+"",
                        icon: 'warning',
                        position: 'top-end',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Confirmer',
                        cancelButtonText: 'Annuler'
                      }).then((result) => {
                        if (result.isConfirmed) {
                          $('#LieuxAffect').modal()
                          $('#Adresse_iput').show()
                        }else{
                          markers5.clearLayers(markersig);

                        }
              })



          } /*End checkbox*/
          

  });

 

   
  

function annuless(){
  markers5.clearLayers(markersig);

}


var data_poste = "<?= $data_poste ?>";

var data_donne = "<?= $data_donne ?>";







var data_donne = data_donne.split("$");

for (var i = 0; i < (data_donne.length)-1; i++) {

var current_val = data_donne[i].split("<>");









if (current_val[5]==1) {


var icon = L.divIcon({
                className: 'label',
                html: '<span><font color="#30d930" class="mapIcon" id="mapIcon'+current_val[0]+'" ><i class="fas fa-dot-circle"></i></font></span>', });

var marke1 = L.marker([current_val[13],current_val[14]], {icon: icon});



var iconZ = L.divIcon({
                className: 'label',
                html: '<span></span>', });

var markeZ = L.marker([current_val[0],current_val[1]], {icon: iconZ});

  if (current_val[5] == 1) {
     var userActif = '<span style="color:green">Actif</span>';
  }else{
    var userActif = '<span style="color:red">Non Actif</span>';
  }


  var fc = marke1.getLatLng();
  var fc2 = markeZ.getLatLng();
  var met = (fc.distanceTo(fc2)).toFixed(0);
  var kilo = Math.round(met / 100) / 10;

  var distan = "<b>Distance Agent à son Poste.</b><br><b>"+met+"</b> m =><b>"+kilo+"</b> km ";


  var points = [
      [current_val[13],current_val[14]],
      [current_val[0],current_val[1]]
  ];

  

  var gentpnb = current_val[2]+" "+current_val[3];

  marke1.bindTooltip('<span style="font-size:13px;color:#000;font-size:13px">👮🏻 &nbsp; '+gentpnb+' '+userActif+' <br>🆔 &nbsp; Matricule <b> '+current_val[4]+'</span>');

  marke1.bindPopup("<div class='card'><div class='card-header text-center'><h6><font color='white'><b>"+gentpnb.toUpperCase()+"<br>N° "+current_val[4]+"</b></font></h6></div><div class='card-body'><center><img src='"+current_val[6]+"' width='50' height='50' style='border-radius:50%;'></center><br><b>👮🏻 &nbsp; "+current_val[2]+" "+current_val[3]+"</b><br>🆔 &nbsp; Matricule <b> "+current_val[4]+" </b><br>📧 &nbsp; "+current_val[8]+" <br>🚩 &nbsp; Poste "+current_val[11]+"<br>🗓️ &nbsp; "+current_val[9]+" au "+current_val[10]+"<hr>↕️ &nbsp; Statu <b> "+userActif+" </b><br><a href='#' onclick='get_detail_Pdl("+current_val[7]+","+current_val[12]+")'>✉️ &nbsp; "+current_val[12]+" ...</a></b><br><a href='#' onclick='get_detail_performance("+current_val[7]+")'>🧐 &nbsp; voir plus..</a></div></div>");

  markers1.addLayer(marke1);
  
 

  
}



if (current_val[5]==0) {

  var icon2 = L.divIcon({
                className: 'label',
                html: '<span><font color="red" class="mapIcon" id="mapIcon'+current_val[0]+'" ><i class="fas fa-dot-circle"></i></font></span>', });

  var iconW = L.divIcon({
                className: 'label',
                html: '<span></span>', });

  var markeW = L.marker([current_val[13],current_val[14]], {icon: iconW});

  var marke2 = L.marker([current_val[13],current_val[14]], {icon: icon2});

  if (current_val[5] == 1) {
     var userActif = '<span style="color:green">Actif</span>';
  }else{
    var userActif = '<span style="color:red">Non Actif</span>';
  }
  
   var gentpnb = current_val[2]+" "+current_val[3];

  marke2.bindTooltip('<span style="font-size:13px;color:#000;font-size:13px">👮🏻 &nbsp; '+gentpnb+' '+userActif+' <br>🆔 &nbsp; Matricule <b> '+current_val[4]+'</span>');

  marke2.bindPopup("<div class='card'><div class='card-header text-center'><h6><font color='white'><b>"+gentpnb.toUpperCase()+"<br>N° "+current_val[4]+"</b></font></h6></div><div class='card-body'><center><img src='"+current_val[6]+"' width='50' height='50' style='border-radius:50%;'></center><br><b>👮🏻 &nbsp; "+current_val[2]+" "+current_val[3]+"</b><br>🆔 &nbsp; Matricule <b> "+current_val[4]+" </b><br>📧 &nbsp; "+current_val[8]+" <br>🚩 &nbsp; Poste "+current_val[11]+"<br>🗓️ &nbsp; "+current_val[9]+" au "+current_val[10]+"<hr>↕️ &nbsp; Statu <b> "+userActif+" </b><br><a href='#' onclick='get_detail_Pdl("+current_val[7]+","+current_val[12]+")'>✉️ &nbsp; "+current_val[12]+" ...</a></b><br><a href='#' onclick='get_detail_performance("+current_val[7]+")'>🧐 &nbsp; voir plus..</a></div></div>");


  markers2.addLayer(marke2);
    // markers2.addLayer(markeW);
  
 }


}







/* poste RECECA-INKINGI*/


var data_poste = data_poste.split("$");

for (var i = 0; i < (data_poste.length); i++) {

    var current_donn = data_poste[i].split("<>");


    var iconPnb =  "<?=base_url('/uploads/logoPNB.png')?>";
    var icon5=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': '000'})  
    var marksss = L.marker([current_donn[0],current_donn[1]],{icon:icon5});
    var poste = current_donn[2];
    marksss.bindPopup("<div class='card'><div class='card-header text-center'><h5><font color='white'><b>"+poste.toUpperCase()+"</b></font></h5></div><div class='card-body'><center><img src='"+iconPnb+"' width='50' height='50' style='border-radius:50%; border : 1px solid #30d930'></center><br><b>🗺️ &nbsp; Province "+current_donn[3]+"</b><br>🏚️ &nbsp; Commune "+current_donn[4]+"<br>🏚️ &nbsp; Zone "+current_donn[5]+" <br>📍 &nbsp; Colline "+current_donn[6]+"<br>🚩 &nbsp; "+current_donn[2]+"<hr>👮🏻 &nbsp;  <a href='#' id='donne_views' onclick='affectation_new("+current_donn[8]+", "+current_donn[7]+")'>"+current_donn[7]+" agents </a><br> </div></div>");
   /*<a href='#' onclick='getDetailControl("+current_donn[2]+")'>🧐 &nbsp; voir plus..</a>*/
   markers3.addLayer(marksss);
 }
</script>
<script type="text/javascript">
 var bounds = markers3.getBounds(); 
  map.fitBounds(bounds);
map.addLayer(markers1);
map.addLayer(markers2);
map.addLayer(markers3);


$('input[name="opt1"]').click(function(){
  
if($(this).is(":checked")){
     
    map.addLayer(markers1);
    

}else if($(this).is(":not(:checked)")){

    
    map.removeLayer(markers1);
 
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



</script> 



<script type="text/javascript">
  
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