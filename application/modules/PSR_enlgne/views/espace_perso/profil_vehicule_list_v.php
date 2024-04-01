<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>


<style type="text/css">
.mapbox-improve-map {
  display: none;
}

.leaflet-control-attribution {
  display: none !important;
}

.leaflet-control-attribution {
  display: none !important;



  .mapbox-logo {
    display: none;
  }

  
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include VIEWPATH . 'templates/navbar.php'; ?>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include VIEWPATH . 'templates/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-8">
              <h4 class="m-0"><?= $title ?></h4>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->


        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">

          <div class="col-md-12 col-xl-12 grid-margin stretch-card">

            <div class="container-fluid">
                 <!--  <div class="row">
                    <div class="col">
                     <div class="row">
                      <div class="col-md-12" style="float:left ;">
                        <a href="javascript:window.history.go(-1);"><span class="btn btn-primary btn-sm">Retour</span></a>
                      </div>
                    </div>
                  </div>
                </div> -->
                <br>
                
                <div class="row">
                  <div class="col-lg-4">
                    <div class="card mb-4" style="height:100%">

                          <!-- <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                            class="rounded-circle img-fluid" style="width: 150px;"> -->
                            <h3 ><center>Carte Rose</center></h3>
                            <div class="card-body">

                              <p class="mb-1" style="font-size: .77rem;">N° Carte Rose: <span style="float: right;"><b><?=$carte_rose['NUMERO_CARTE_ROSE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Plaque: <span style="float: right;"><b><?=$carte_rose['NUMERO_PLAQUE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Categorie: <span style="float: right;"><b><?=$carte_rose['CATEGORIE_PLAQUE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Marque: <span style="float: right;"><b><?=$carte_rose['MARQUE_VOITURE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>

                              <p class="mb-1" style="font-size: .77rem;">Chassis: <span style="float: right;"><b><?=$carte_rose['NUMERO_CHASSIS']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Nbr Place: <span style="float: right;"><b><?=$carte_rose['NOMBRE_PLACE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>

                              <p class="mb-1" style="font-size: .77rem;">Nom: <span style="float: right;"><b><?= $carte_rose['PRENOM_PROPRIETAIRE'];?> <?=$carte_rose['NOM_PROPRIETAIRE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Chassis: <span style="float: right;"><b><?=$carte_rose['NUMERO_CHASSIS']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">CNI: <span style="float: right;"><b><?=$carte_rose['NUMERO_IDENTITE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>

                              <p class="mb-1" style="font-size: .77rem;">Province: <span style="float: right;"><b><?=$carte_rose['PROVINCE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>

                              <p class="mb-1" style="font-size: .77rem;">Profession: <span style="float: right;"><b><?=$carte_rose['CATEGORIE_PROPRIETAIRE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Usage: <span style="float: right;"><b><?=$carte_rose['CATEGORIE_USAGE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Puissance: <span style="float: right;"><b><?=$carte_rose['PUISSANCE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Couleur: <span style="float: right;"><b><?=$carte_rose['COULEUR']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Frabrication: <span style="float: right;"><b><?=$carte_rose['ANNEE_FABRICATION']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Date d'enregistrement: <span style="float: right;"><b><?=$carte_rose['DATE_INSERTION']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Modele: <span style="float: right;"><b><?=$carte_rose['MODELE_VOITURE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>

                              <p class="mb-1" style="font-size: .77rem;">Poids: <span style="float: right;"><b><?=$carte_rose['POIDS']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Carburant: <span style="float: right;"><b><?=$carte_rose['TYPE_CARBURANT']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>

                              <p class="mb-1" style="font-size: .77rem;">NIF: <span style="float: right;"><b><?=$carte_rose['NIF']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Date de délivreson: <span style="float: right;"><b><?=$carte_rose['DATE_DELIVRANCE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>




                            </div>
                          </div>

                        </div>
                        <div class="col-lg-8">
                          <div class="card mb-4">
                            <div class="card-body">
                              <div class="row">

                                <form action="<?=base_url('PSR/Obr_Immatriculation/show_vehicule/'.$ID_IMMATRICULATION.'/'.$NUMERO_PLAQUE.'')?>" method='POST' name="myform" id="myform">    
                                 <div class="row">
                                  <div class="form-group col-md-12">
                                    Date
                                    <select class="form-control" onchange="submit_province()" name="date" id="date">
                                      <option value="" selected>Sélectionner</option>
                                      <?php
                                      foreach ($day as $value){
                                        if ($value['date'] == $date)
                                          {?>
                                            <option value="<?=$value['date']?>" selected><?=$value['date']?></option>
                                          <?php } else{ ?>
                                            <option value="<?=$value['date']?>"><?=$value['date']?></option>
                                          <?php } } ?>
                                        </select>
                                      </div>
                                    </div>

                                    </form> 
                                    <br>
                                    <div class="col-md-12" id="container" style="border: 1px solid #d2d7db;"></div>
                                  </div>

                                </div>
                              </div>
                              <div class="row">
                                <?php if(!empty($controle)) { ?>
                                  <div class="col-md-6">
                                    <div class="card mb-4 mb-md-0">
                                      <div class="card-body">
                                        <h3 style="float:center; color: #333;">Controle Technique</h3>
                                        <div class="card-body p-0">

                                          <p class="mb-1" style="font-size: .77rem;">Numero: <span style="float: right;"><b><?=$controle['NUMERO_CONTROLE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>


                                          <p class="mb-1" style="font-size: .77rem;">Plaque: <span style="float: right;"><b><?=$controle['NUMERO_PLAQUE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Chassis: <span style="float: right;"><b><?=$controle['NUMERO_CHASSIS']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Propietaire: <span style="float: right;"><b><?=$controle['PROPRIETAIRE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Date: <span style="float: right;"><b><?=$controle['DATE_DEBUT']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Date validite: <span style="float: right;"><b><?=$controle['DATE_VALIDITE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>


                                          <p class="mb-1" style="font-size: .77rem;">Type: <span style="float: right;"><b><?=$controle['TYPE_VEHICULE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>


                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php } else {?>
                                  <div class="col-md-6">
                                    <div class="card mb-4 mb-md-0">
                                      <div class="card-body">
                                        <div class="alert alert-danger" role="alert">
                                          Il n'y a pas eu une contrrole Technique
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php } ?>
                                <?php if(!empty($vol)) { ?>
                                  <div class="col-md-6">
                                    <div class="card mb-4 mb-md-0">
                                      <div class="card-body">
                                        <h3 style="float:center; color: #333;">Police Judiciaire (Declaration VOl)</h3>
                                        <div class="card-body p-0">


                                          <p class="mb-1" style="font-size: .77rem;">Plaque: <span style="float: right;"><b><?= $vol['NUMERO_PLAQUE'];?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Declarant: <span style="float: right;"><b><?= $vol['NOM_DECLARANT'];?> <?= $vol['PRENOM_DECLARANT'];?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Couleur: <span style="float: right;"><b><?= $vol['COULEUR_VOITURE'];?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Marque: <span style="float: right;"><b><?= $vol['MARQUE_VOITURE'];?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>


                                          <p class="mb-1" style="font-size: .77rem;">Date du vol: <span style="float: right;"><b><?= $vol['DATE_VOLER'];?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>


                                          <?= $vol['STATUT']==1 ? '<p class="mb-1" style="font-size: .77rem;">Statut: <span style="float: right;"><b>Trouvé</b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>' :

                                          '<p class="mb-1" style="font-size: .77rem;">Statut: <span style="float: right;"><b>Volé</b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>'
                                          ?>

                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php } else {?>
                                  <div class="col-md-6">
                                    <div class="card mb-4 mb-md-0">
                                      <div class="card-body">
                                        <div class="alert alert-success" role="alert">
                                          Il n'y a pas eu une déclaration de vol
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php } ?>

                              </div>
                            </br> </br>
                            <div class="row">
                              <?php if(!empty($controle)) { ?>
                               <div class="col-md-6">
                                <div class="card mb-4 mb-md-0">
                                  <div class="card-body">
                                   <h3 style="float:center; color: #333;">Assurance</h3>
                                   <div class="card-body p-0">

                                    <p class="mb-1" style="font-size: .77rem;">Plaque: <span style="float: right;"><b><?= $assurance['NUMERO_PLAQUE'];?></b></span> </p>
                                    <div class="progress rounded" style="height: 5px;">
                                    </div>

                                    <p class="mb-1" style="font-size: .77rem;">Assureur: <span style="float: right;"><b><?= $assurance['ASSURANCE'];?></b></span> </p>
                                    <div class="progress rounded" style="height: 5px;">
                                    </div>

                                    <p class="mb-1" style="font-size: .77rem;">Début: <span style="float: right;"><b><?= $assurance['DATE_DEBUT'];?></b></span> </p>
                                    <div class="progress rounded" style="height: 5px;">
                                    </div>

                                    <p class="mb-1" style="font-size: .77rem;">Fin d'assurance: <span style="float: right;"><b><?= $assurance['DATE_VALIDITE'];?></b></span> </p>
                                    <div class="progress rounded" style="height: 5px;">
                                    </div>

                                    <p class="mb-1" style="font-size: .77rem;">Places: <span style="float: right;"><b><?= $assurance['PLACES_ASSURES'];?></b></span> </p>
                                    <div class="progress rounded" style="height: 5px;">
                                    </div>

                                    <p class="mb-1" style="font-size: .77rem;">Type: <span style="float: right;"><b><?= $assurance['TYPE_ASSURANCE'];?></b></span> </p>
                                    <div class="progress rounded" style="height: 5px;">
                                    </div>

                                    <p class="mb-1" style="font-size: .77rem;">Propriètaire: <span style="float: right;"><b><?= $assurance['NOM_PROPRIETAIRE'];?></b></span> </p>
                                    <div class="progress rounded" style="height: 5px;">
                                    </div>


                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php } else {?>
                            <div class="col-md-6">
                              <div class="card mb-4 mb-md-0">
                                <div class="card-body">
                                  <div class="alert alert-danger" role="alert">
                                    Il n'y a pas eu l'assurance
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php } ?>
                          <div class="col-md-6">
                           <div class="card mb-4 mb-md-0">
                            <pre id='distance' class='ui-distance'></pre>
                            <div class="card-body" id="mapview" style="height: 260px">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

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



</section>


<!-- /.content -->
</div>

</div>
<!-- ./wrapper -->
<?php include VIEWPATH . 'templates/footer.php'; ?>
</body>

</html>


<script>
//   L.mapbox.accessToken = 'pk.eyJ1IjoibWFydGlubWVkaWFib3giLCJhIjoiY2s4OXc1NjAxMDRybzNobTE2dmo1a3ZndCJ9.W9Cm7Pjp25FQ00bII9Be6Q';
//   var center = '-3.4313888,29.9079177';
//   var center_coord = center.split(",");
//   var zoom ='8';
//   if(this.map) {
//     this.map.remove();
//   }
//   var map = L.mapbox.map('map')
//   .setView([center_coord[0],center_coord[1]], zoom)
//   .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'));
//   var layers = {
//     Streets: L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'),
//     Satellite: L.mapbox.styleLayer('mapbox://styles/mapbox/satellite-streets-v11'),
//   };

//   layers.Streets.addTo(map);
//   L.control.layers(layers).addTo(map);

// // Start with a fixed marker.

// <?=$donne_carte?>



// var fc = fixedMarker.getLatLng();

// var featureLayer = L.mapbox.featureLayer().addTo(map);

// map.on('click', function(ev) {

//   var c = ev.latlng;

//   var geojson = {
//     type: 'FeatureCollection',
//     features: [
//     {
//       "type": "Feature",
//       "geometry": {
//         "type": "Point",
//         "coordinates": [c.lng, c.lat]
//       },
//       "properties": {
//         "marker-color": "#ff8888"
//       }
//     }, {
//       "type": "Feature",
//       "geometry": {
//         "type": "LineString",
//         "coordinates": [
//         [fc.lng, fc.lat],
//         [c.lng, c.lat]
//         ]
//       },
//       "properties": {
//         "stroke": "#000",
//         "stroke-opacity": 0.5,
//         "stroke-width": 4
//       }
//     }
//     ]
//   };

//   featureLayer.setGeoJSON(geojson);

//   var container = document.getElementById('distance');
//   container.innerHTML = (fc.distanceTo(c)).toFixed(0) + 'm';
// });


  getMaps();
</script>




<script type="text/javascript">

  Highcharts.chart('container', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Amende totale <?=$total?> FBU<br>'
    },
    xAxis: {
      type: 'category'
    },
    yAxis: {
      min: 0,
      title: {
        text: '',
        align: 'high'
      },
      labels: {
        overflow: 'justify'
      }
    },
    tooltip: {
     valueSuffix: 'FBU'
   },
   plotOptions: {
    column: {
     dataLabels: {
      enabled: true,
      point:{
        events:{
          click: function(e){
            date:$('#date').val()
          }
        }
      }
    },

  }
},
legend: {
  layout: 'vertical',
  align: 'right',
  verticalAlign: 'top',
  x: -40,
  y: 80,
  floating: true,
  borderWidth: 1,
  backgroundColor:
  Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
  shadow: true
},
credits: {
  enabled: false
},
series: [{
  name: 'Amande',
  data: [<?=$amandes?>]
}]
});           
</script>

<script type="text/javascript">
 function get_rapport(){
  myform.submit()
  date:$('#date').val()
}

</script>

<script>

  function submit_province() {


    myform.action= myform.action;
    myform.submit();
  }



  getMaps();

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