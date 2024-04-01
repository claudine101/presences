</div>

<div class="row"><div class="col-md-12">


  <div style="width: 100%;height: 550px;" id="map"></div>

</div>

</div>


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

  var markers =  new L.MarkerClusterGroup();//new L.MarkerClusterGroup(); //L.featureGroup();
  // var markers2 =  new L.MarkerClusterGroup();//new L.MarkerClusterGroup(); //L.featureGroup();
  // var markers3 =  new L.MarkerClusterGroup();//new L.MarkerClusterGroup(); //L.featureGroup();
  // var markers4 = new L.MarkerClusterGroup();//new L.MarkerClusterGroup();


////////////////////////////////////////////////////////////////////

var data_donne = "<?= $data_donne ?>";


var data_donne = data_donne.split("$");


for (var i = 0; i < (data_donne.length)-1; i++) {

  var current_val = data_donne[i].split("<>");

  if (current_val[6]==1) {

    var cssIcon = L.divIcon({
      // Specify a class name we can refer to in CSS.
      className: 'css-icon',
      html: '<div class="gps_ring"></div>'
      // Set marker width and height
      ,iconSize: [22,22]
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

last.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div>Date : <b>'+current_val[8]+'</b><br>Nbre Agent:  <b>'+current_val[7]+'</b><br></div></div></div>').addTo(map);
marker.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div>Date : <b>'+current_val[8]+'</b><br>Nbre Agent:  <b>'+current_val[7]+'</b><br></div></div></div>').addTo(map);

markers_last.addLayer(last);
markers_last.addLayer(marker);


//markers.addLayer(marker);

}
//map.addLayer(markers_last);
console.log(marker)



  var icon1=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': 'FF8000'})  
  
  
  var marke1 = L.marker([current_val[0],current_val[1]],{icon:icon1});
  // marke.addTo(map);
  marke1.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div><a href="" onclick="getincident(0)"> Agent:  <b>'+current_val[7]+'</b></a><br></div></div></div>');

  markers.addLayer(marke1);
  


// if (current_val[8]==2) {
//   var icon2=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': '3e9ceb'})
  
//   var marke2 = L.marker([current_val[0],current_val[1]],{icon:icon2});
//   // marke.addTo(map);
//   marke2.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div>N° : <b>'+current_val[3]+'</b><br>Date:  <b>'+current_val[4]+'</b><br>Agent:  <b>'+current_val[7]+'</b><br>Amande:  <b>'+current_val[13]+'</b><br></div></div></div>');

 //  markers2.addLayer(marke2);
  
// }

// if (current_val[8]==3) {
//   var icon3=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': 'F1080F'})
  
//   var marke3 = L.marker([current_val[0],current_val[1]],{icon:icon3});
//   // marke.addTo(map);
//   marke3.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div>N° : <b>'+current_val[3]+'</b><br>Date:  <b>'+current_val[4]+'</b><br>Agent:  <b>'+current_val[7]+'</b><br>Amande:  <b>'+current_val[13]+'</b><br></div></div></div>');
//   markers3.addLayer(marke3);
  
// }



// if (current_val[8]==4) {
//   var icon3=L.mapbox.marker.icon({'marker-symbol': 'police', 'marker-color': '000'})
  
//   var marke4 = L.marker([current_val[0],current_val[1]],{icon:icon3});
//   // marke.addTo(map);
//   marke4.bindPopup('<div class="card"><div class="card-header text-center"><h4><font color="white"><b>'+current_val[2]+'</b></font></h4></div><div class="card-body"><div>N° : <b>'+current_val[3]+'</b><br>Date:  <b>'+current_val[4]+'</b><br>Agent:  <b>'+current_val[7]+'</b><br>Amande:  <b>'+current_val[13]+'</b><br></div></div></div>');
//   markers4.addLayer(marke4);
  
// }







}


var bounds = markers_last.getBounds(); 
map.fitBounds(bounds);


map.addLayer(markers_last);

map.addLayer(markers);
//map.addLayer(markers2);
// map.addLayer(markers3);
// map.addLayer(markers4);








// $(document).ready(function(){


//   $('input[name="opt1"]').click(function(){

//     if($(this).is(":checked")){

//       map.addLayer(markers);


//     }else if($(this).is(":not(:checked)")){

//       map.removeLayer(markers);

//     }
//   });

//   $('input[name="opt2"]').click(function(){

//     if($(this).is(":checked")){

//       map.addLayer(markers2);


//     }else if($(this).is(":not(:checked)")){


//       map.removeLayer(markers2);

//     }
//   });


//   // $('input[name="opt3"]').click(function(){

//   //   if($(this).is(":checked")){

//   //     map.addLayer(markers3);


//   //   }else if($(this).is(":not(:checked)")){


//   //     map.removeLayer(markers3);

//   //   }
//   // });

//   // $('input[name="opt4"]').click(function(){

//   //   if($(this).is(":checked")){

//   //     map.addLayer(markers4);


//   //   }else if($(this).is(":not(:checked)")){


//   //     map.removeLayer(markers4);

//   //   }
//   // });


// });


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