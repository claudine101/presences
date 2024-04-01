<style type="text/css">
    .leaflet-control-layers-expanded {
    color: white;
    background-color: #2da0e2;
    float: right;

  }


.gps_ringss { 
    border: 7px solid #F30707;
     -webkit-border-radius: 20px;
     height: 20px;
     width: 20px;   
     margin-left: 0px;
     margin-top: 0px;
      -webkit-animation: pulsate 1s ease-out;
      -webkit-animation-iteration-count: infinite; 
      /*opacity: 0.0*/
  }
  
  @-webkit-keyframes pulsate {
        0% {-webkit-transform: scale(0.1, 0.1); opacity: 0.0;}
        50% {opacity: 0.6;}
        100% {-webkit-transform: scale(1.2, 1.2); opacity: 0.0;}
  }
</style>

<script>

  L.mapbox.accessToken = 'pk.eyJ1IjoibWFydGlubWVkaWFib3giLCJhIjoiY2s4OXc1NjAxMDRybzNobTE2dmo1a3ZndCJ9.W9Cm7Pjp25FQ00bII9Be6Q';

  var center = '<?= $coord; ?>';
  var center_coord = center.split(",");
  var zoom ='<?= $zoom; ?>';

 //projection: 'naturalEarth'
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

   

    
    <?=$markers['marker_all']?>

    const donness = [<?=$donne?>];
    var id_max = "<?=$id_max?>";

  

    console.log(donness)

    var markers1 =  new L.MarkerClusterGroup();
    var markersUne =  new L.MarkerClusterGroup();


    donness.forEach(function(item) {

        for (var i = 0; i < item.length; i++) {



           if (item[i].PSR_ELEMENT_ID > 0) {
            var nom = item[i].NOM_AGENT+" "+item[i].PRENOM_AGENT;
            var sex =  "";
            var phone = item[i].TEL_AGENT;
            
            if (item[i].SEXE_AGENT == "H"){
             sex += "Mr l'agent,";
            }else{
            sex += "Md l'agent,";
            }


          }else{
            var nom = item[i].PRENOM_CITOYEN+" "+item[i].NOM_CITOYEN;
            var sex = "";
            var phone = item[i].NOM_UTILISATEUR;

            if (item[i].SEXE == 0){
             sex += "Mr,";
            }else{
            sex += "Md,";
            }

          }

          if (item[i].ID_CATEGORIE_SIGNALEMENT > 2) {
            var prefix = "";
          }else{
            var prefix = "Signalement pour ";
          }

          if (item[i].ID_CATEGORIE_SIGNALEMENT == 1 && item[i].HAVE_SEE_PLAQUE == 1) {
            var plaques = '🚖 &nbsp; Plaque:  <b> '+item[i].PLAQUE_NUMERO+'</b><br>';
          }else{
            var plaques = "";
          }

          


          var titrepup = '<center><b > '+prefix+item[i].TYPE_SIGNAL+'</b></center><span style="font-size:13px;color:#000;font-size:13px">'+plaques+'🆔 &nbsp; Statut: <b>'+item[i].STATUT+'</b> <br>👮🏻 &nbsp; Auteur: <b>'+sex+''+nom+'</b><br>📆 &nbsp; Date:  <b> '+item[i].DATE_SIGNAL+'</b></span>';

          var popup = "<div class='card'><div class='card-header text-center'><h6><font color='white'><b>"+prefix+item[i].TYPE_SIGNAL+"</b></font></h6></div><div class='card-body'><span style='font-size:13px;color:#000;font-size:13px'>"+plaques+"🆔 &nbsp; Statut: <b>"+item[i].STATUT+"</b> <br>👮🏻 &nbsp; Auteur: <b>"+nom+"</b><br>📆 &nbsp; Date:  <b> "+item[i].DATE_SIGNAL+"</b><br><a href='#' onclick='get_message("+item[i].phone+")'>📳 &nbsp; "+phone+"</a></span><hr><a href='#' onclick='get_detail_sign("+item[i].ID_SIGNALEMENT_NEW+")'>🧐 &nbsp; voir plus..</a></div></div>";

              if (item[i].ID_SIGNALEMENT_NEW == id_max) {

                 var icon2 = L.divIcon({
                            className: 'css-icon',
                            html: '<div class=\'gps_ringss\'></div>',
                            iconSize: [15,15]
                          });

                  var markew = L.marker([item[i].LATITUDE,item[i].LONGITUDE], {icon: icon2});
                  markew.bindTooltip(titrepup);
                  markew.bindPopup(popup);
                  markersUne.addLayer(markew);

              }


          
              var icon=L.mapbox.marker.icon({'marker-symbol': item[i].MARK, 'marker-color': item[i].COLOR ,'marker-size':'medium'})  
              var marke1 = L.marker([item[i].LATITUDE,item[i].LONGITUDE], {icon: icon});


              marke1.bindTooltip(titrepup);
              marke1.bindPopup(popup);


               <?=$markers['marker_add_all']?>

              /*small, medium, large
              https://labs.mapbox.com/maki-icons/
                if (item[i].ID_CATEGORIE_SIGNALEMENT == 2 && item[i].ID_ALERT_STATUT == 2) {
                   police2_1.addLayer(marke1);
                }
                leaflet-control-mapbox-geocoder-form
             */

        }
    });

   
        
         
    var bounds = markersUne.getBounds(); 
    map.fitBounds(bounds);

    map.addLayer(police2_1);
    map.addLayer(markers1);
    map.addLayer(markersUne);


    


</script>