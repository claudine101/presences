<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>

<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
<script src='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.js'></script>
<link href='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.css' rel='stylesheet' />


<style type="text/css">
  .mapbox-improve-map {
    display: none;
  }

  .leaflet-control-attribution {
    display: none !important;
  }

  .leaflet-control-attribution {
    display: none !important;


  }

  .mapbox-logo {
    display: none;
  }




  .highcharts-figure,
  .highcharts-data-table table {
    max-height: 250px;
    max-width: 800px;
    margin: 1em auto;
  }

  #container {
    height: 400px;
  }

  .highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
  }

  .highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
  }

  .highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
  }

  .highcharts-data-table td,
  .highcharts-data-table th,
  .highcharts-data-table caption {
    padding: 0.5em;
  }

  .highcharts-data-table thead tr,
  .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
  }

  .highcharts-data-table tr:hover {
    background: #f1f7ff;
  }

  }
</style>


<style>
  pre.ui-distance {
    position: absolute;
    z-index: 1;
    bottom: 10px;
    left: 10px;
    padding: 5px 10px;
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
    font-size: 11px;
    line-height: 18px;
    border-radius: 3px;
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

            <div class="col-sm-4 text-right">


              <span style="margin-right: 15px">
                <div class="col-sm-3" style="float:right;">
                  <a href="<?= base_url('PSR/Psr_elements/') ?>" style="width: 100px;" class='btn btn-primary btn-sm float-right'>
                    <i class="nav-icon fas fa-list"></i>
                    Liste
                  </a>
                </div>

              </span>

            </div><!-- /.col -->


          </div><!-- /.row -->
        </div><!-- /.container-fluid -->





        <!-- /.content-header 


SELECT e.ID_PSR_ELEMENT,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,e.DATE_NAISSANCE,e.PHOTO,p.PROVINCE_NAME as PROV_NAISSANCE,c.COMMUNE_NAME as COM_NAISSANCE,z.ZONE_NAME as ZONE_NAISSANCE,co.COLLINE_NAME as COLL_NAISSANCE,e.TELEPHONE,e.EMAIL,pr.PROVINCE_NAME as PROV_AFFECT,cm.COMMUNE_NAME as COMM_AFFECT,zo.ZONE_NAME as ZON_AFFECT, col.COLLINE_NAME as COLLINE_AFFECT,a.LIEU_EXACTE,a.LATITUDE,a.LONGITUDE

        -->

        <!-- Main content -->


        <section class="content" style="background-color: #f1f1f100;">
          <div class="container-fluid">
            <!-- <div class="row">
      <div class="col">
      </div>
    </div> -->




            <div class="row">
              <div class="col-lg-4">
                <div class="card mb-4">
                  <div class="card-body text-center">
                    <img src="<?= $agent['PHOTO'] ?>" alt="." class="img-fluid" style="width:160px;height:150px">
                    <p class="text-muted mb-1"><?= $agent['NOM'] . ' ' . $agent['PRENOM'] ?></p>
                    <p class="text-muted mb-1"><?=  $this->notifications->ago($agent['DATE_NAISSANCE'],date('Y-m-d'))  ?> </p>
                    <p class="text-muted mb-4">MATRICULE <?= $agent['NUMERO_MATRICULE'] ?></p>

                  </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                  <div class="card-body p-0">
                    <ul class="list-group list-group-flush rounded-3">

                      <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <i class="fas fa-phone fa-lg" style="color: #3b5998;"></i>
                        <p class="mb-0"><?= $agent['TELEPHONE'] ?></p>
                      </li>

                      <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <i class="fas fa-envelope fa-lg" style="color: #3b5998;"></i>
                        <p class="mb-0"><?= $agent['EMAIL'] ?></p>
                      </li>

                      <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <i class="fas fa-globe fa-lg text-warning"></i>Né à
                        <p class="mb-0"><?= $agent['PROV_NAISSANCE'] ?></p>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <i class="fas fa-home fa-lg" style="color: #333333;"></i>Commune
                        <p class="mb-0"><?= $agent['COM_NAISSANCE'] ?></p>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <i class="fas fa-map fa-lg" style="color: #55acee;"></i>Zone
                        <p class="mb-0"><?= $agent['ZONE_NAISSANCE'] ?></p>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <i class="fas fa-map-marker-alt fa-lg" style="color: #ac2bac;"></i>Colline
                        <p class="mb-0"><?= $agent['COLL_NAISSANCE'] ?></p>
                      </li>

                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="card mb-4">
                  <div class="card-body">

                    <div class="col-md-4">
                      <form method="post" id="myForma" action="<?=base_url('ihm/Performance_Police/index/'.$this->uri->segment(4))?>">
                      <select class="form-control input-sm" data-live-search="true"  name="DATE_VERIFIF"  id="DATE_VERIFIF" onchange="changeDate()">
                        <option value='' >Date de vérification</option>
                       <?php 
                       foreach($dateVerifi as $key) { 
                        if ($key['DATE_VERIFIF']==$trove) { 
                          echo "<option value='".$key['DATE_VERIFIF']."' selected>".$key['DATE_VERIFIF']."</option>";
                        }  else{
                         echo "<option value='".$key['DATE_VERIFIF']."' >".$key['DATE_VERIFIF']."</option>"; 
                       } }?>
                      </select> 
                     </form>
                    </div>


                    <div id="containerRqpport" style="height: 350px;"></div>
                  </div>
                </div>
                <div class="row">


                  <div class="col-md-7">
                    <div class="card mb-4 mb-md-0">
                      <div class="card-body">
                        <h5 style="color: #000" class="mb-4">Affectation
                        </h5>
                        <p class="mb-1" style="font-size: .77rem;">Province: <span style="float: right;"><b><?= $agent['PROV_AFFECT'] ?></b></span> </p>
                        <div class="progress rounded" style="height: 5px;">

                        </div>

                        <p class="mb-1" style="font-size: .77rem;">Commune: <span style="float: right;"><b><?= $agent['COMM_AFFECT'] ?></b></span> </p>
                        <div class="progress rounded" style="height: 5px;">

                        </div>

                        <p class="mb-1" style="font-size: .77rem;">Zone: <span style="float: right;"><b><?= $agent['ZON_AFFECT'] ?></b></span> </p>
                        <div class="progress rounded" style="height: 5px;">

                        </div>

                        <p class="mb-1" style="font-size: .77rem;">Colline: <span style="float: right;"><b><?= $agent['COLLINE_AFFECT'] ?></b></span> </p>
                        <div class="progress rounded" style="height: 5px;">

                        </div>

                        <p class="mb-1" style="font-size: .77rem;">Lieu: <span style="float: right;"><b><?= $agent['LIEU_EXACTE'] ?></b></span> </p>
                        <div class="progress rounded" style="height: 5px;">

                        </div>
                        <!--  --><br>
                        <div class="progress rounded mb-2" style="height: 5px;">
                          <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-5">
                    <div class="card mb-4 mb-md-0">
                      <pre id='distance' class='ui-distance'></pre>
                      <div class="card-body" id="map" style="height: 260px">
                      </div>
                    </div>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </section>




        <!-- /.content -->
      </div>

    </div>
    <!-- ./wrapper -->
    <?php include VIEWPATH . 'templates/footerDeux.php'; ?>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

</body>

</html>

<script type="text/javascript">
   function  changeDate() {
     myForma.submit();
   }
</script>


<script>
  L.mapbox.accessToken = 'pk.eyJ1IjoibWFydGlubWVkaWFib3giLCJhIjoiY2s4OXc1NjAxMDRybzNobTE2dmo1a3ZndCJ9.W9Cm7Pjp25FQ00bII9Be6Q';
  var center = '-3.4313888,29.9079177';
  var center_coord = center.split(",");
  var zoom = '8';
  if (this.map) {
    this.map.remove();
  }
  var map = L.mapbox.map('map')
    .setView([center_coord[0], center_coord[1]], zoom)
    .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'));
  var layers = {
    Streets: L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'),
    Satellite: L.mapbox.styleLayer('mapbox://styles/mapbox/satellite-streets-v11'),
  };

  layers.Streets.addTo(map);
  L.control.layers(layers).addTo(map);

  // Start with a fixed marker.
  <?= $donne_carte ?>
  // var fixedMarker = L.marker(new L.LatLng(-3.4313888,29.9079177), {
  //     icon: L.mapbox.marker.icon({
  //         'marker-color': 'ff8888'
  //     })
  // }).bindPopup("<center><b><?= $agent['NOM'] ?> <?= $agent['PRENOM'] ?></b><br><?= $agent['NUMERO_MATRICULE'] ?></center>").addTo(map);


  var fc = fixedMarker.getLatLng();

  var featureLayer = L.mapbox.featureLayer().addTo(map);

  map.on('click', function(ev) {

    var c = ev.latlng;

    var geojson = {
      type: 'FeatureCollection',
      features: [{
        "type": "Feature",
        "geometry": {
          "type": "Point",
          "coordinates": [c.lng, c.lat]
        },
        "properties": {
          "marker-color": "#ff8888"
        }
      }, {
        "type": "Feature",
        "geometry": {
          "type": "LineString",
          "coordinates": [
            [fc.lng, fc.lat],
            [c.lng, c.lat]
          ]
        },
        "properties": {
          "stroke": "#000",
          "stroke-opacity": 0.5,
          "stroke-width": 4
        }
      }]
    };

    featureLayer.setGeoJSON(geojson);

    var container = document.getElementById('distance');
    container.innerHTML = (fc.distanceTo(c)).toFixed(0) + 'm';
  });
</script>




<script>
  // // Set up the chart
  // Highcharts.chart('containerRqpport', {
  //   chart: {
  //     type: 'bar'
  //   },
  //   title: {
  //     text: 'Performance totale <?=   number_format($total, 0, ',', ' '); ?> FBU<br>'
  //   },
  //   subtitle: {
  //     text: ''
  //   },
  //   xAxis: {
  //     categories: [<?= $catego ?>],
  //     title: {
  //       text: null
  //     }
  //   },
  //   yAxis: {
  //     min: 0,
  //     title: {
  //       text: '',
  //       align: 'high'
  //     },
  //     labels: {
  //       overflow: 'justify'
  //     }
  //   },
  //   tooltip: {
  //     valueSuffix: ' FBU'
  //   },
  //   plotOptions: {
  //     bar: {
  //       dataLabels: {
  //         enabled: true
  //       }
  //     }
  //   },
  //   legend: {
  //     layout: 'vertical',
  //     align: 'right',
  //     verticalAlign: 'top',
  //     x: -40,
  //     y: 80,
  //     floating: true,
  //     borderWidth: 1,
  //     backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
  //     shadow: true
  //   },
  //   credits: {
  //     enabled: false
  //   },
  //   series: [{
  //       name: 'Rainfall',
  //       type: 'column',
  //       yAxis: 1,
  //       data: [49.9, 71.5],
  //       tooltip: {
  //           valueSuffix: ' mm'
  //       }

  //   }, {
  //       name: 'Temperature',
  //       type: 'spline',
  //       data: [7.0, 6.9],
  //       tooltip: {
  //           valueSuffix: '°C'
  //       }
  //   }],
  // });










  Highcharts.chart('containerRqpport', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Performance totale <?=   number_format($total, 0, ',', ' '); ?> FBU<br>'
    },
    subtitle: {
        text: ''
    },
    xAxis: [{
        categories: [<?= $catego ?>],
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}Moyenne',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: 'Moyenne',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        }
    }, { // Secondary yAxis
        title: {
            text: 'Amende',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        labels: {
            format: '{value} FBU',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        opposite: true
    }],
    tooltip: {
        shared: true
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        x: 120,
        verticalAlign: 'top',
        y: 100,
        floating: true,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || // theme
            'rgba(255,255,255,0.25)'
    },
    series: [{
        name: 'Amende',
        type: 'bar',
        yAxis: 1,
        data: [<?=$donne?>],
        tooltip: {
            valueSuffix: ' FBU'
        }

    }, {
        name: 'Moyenne',
        type: 'spline',
        data: [<?=$donnePoint?>],
        tooltip: {
            valueSuffix: ' FBU'
        }
    }]
});
</script>