

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
  position:absolute;
  z-index: 1;
  bottom:10px;
  left:10px;
  padding:5px 10px;
  background:rgba(0,0,0,0.5);
  color:#fff;
  font-size:11px;
  line-height:18px;
  border-radius:3px;
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






        <section class="content" style="background-color: #f1f1f100;">

          <div class="card">

            <div class="card-body">
             <div class="row">
              <div class="col">
                <div class="row">
                  <div class="col-md-12" style="float:left ;">
                    <a href="javascript:window.history.go(-1);"><span class="btn btn-primary btn-sm">Retour</span></a>
                  </div>
                </div>
              </div>

            </div>
          </br>
            <div class="row">
              <div class="col-lg-4">
                <div class="card mb-4">
                  <div class="card-body text-center">
                    <img src="https://www.bing.com/th?id=OIP.8BcplPdIioIbIRLvpp6reQHaHa&w=250&h=250&c=8&rs=1&qlt=90&o=6&pid=3.1&rm=2" alt="avatar"
                    class="rounded-circle img-fluid" style="width: 150px;">
                    <p class="text-muted mb-1"><?=$agent['NOM'].' '.$agent['PRENOM']?></p>
                    <p class="text-muted mb-1"><?=$agent['DATE_NAISSANCE']?> ans</p>
                    <p class="text-muted mb-4">MATRICULE <?=$agent['NUMERO_MATRICULE']?></p>

                  </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                  <div class="card-body p-0">
                    <ul class="list-group list-group-flush rounded-3">

                     <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <i class="fas fa-phone fa-lg" style="color: #3b5998;"></i>
                      <p class="mb-0"><?=$agent['TELEPHONE']?></p>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <i class="fas fa-envelope fa-lg" style="color: #3b5998;"></i>
                      <p class="mb-0"><?=$agent['EMAIL']?></p>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <i class="fas fa-globe fa-lg text-warning"></i>Né à
                      <p class="mb-0"><?=$agent['PROV_NAISSANCE']?></p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <i class="fas fa-home fa-lg" style="color: #333333;"></i>Commune
                      <p class="mb-0"><?=$agent['COM_NAISSANCE']?></p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <i class="fas fa-map fa-lg" style="color: #55acee;"></i>Zone
                      <p class="mb-0"><?=$agent['ZONE_NAISSANCE']?></p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <i class="fas fa-map-marker-alt fa-lg" style="color: #ac2bac;"></i>Colline
                      <p class="mb-0"><?=$agent['COLL_NAISSANCE']?></p>
                    </li>

                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="card mb-4">
               <div class="card-body" >
                <div id="containerRqpport" style="height: 250px;"></div>
              </div>
            </div>
            <div class="row">


              <div class="col-md-7">
                <div class="card mb-4 mb-md-0">
                  <div class="card-body">
                    <h5 style="color: #000" class="mb-4">Affectation
                    </h5>
                    <p class="mb-1" style="font-size: .77rem;">Province: <span style="float: right;"><b><?=$agent['PROV_AFFECT']?></b></span> </p>
                    <div class="progress rounded" style="height: 5px;">

                    </div>

                    <p class="mb-1" style="font-size: .77rem;">Commune: <span style="float: right;"><b><?=$agent['COMM_AFFECT']?></b></span> </p>
                    <div class="progress rounded" style="height: 5px;">

                    </div>

                    <p class="mb-1" style="font-size: .77rem;">Zone: <span style="float: right;"><b><?=$agent['ZON_AFFECT']?></b></span> </p>
                    <div class="progress rounded" style="height: 5px;">

                    </div>

                    <p class="mb-1" style="font-size: .77rem;">Colline: <span style="float: right;"><b><?=$agent['COLLINE_AFFECT']?></b></span> </p>
                    <div class="progress rounded" style="height: 5px;">

                    </div>

                    <p class="mb-1" style="font-size: .77rem;">Lieu: <span style="float: right;"><b><?=$agent['LIEU_EXACTE']?></b></span> </p>
                    <div class="progress rounded" style="height: 5px;">

                    </div>
                    <!--  --><br>
                    <div class="progress rounded mb-2" style="height: 5px;">
                      <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100"
                      aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-5">
                <div class="card mb-4 mb-md-0">
                  <pre id='distance' class='ui-distance'></pre>
                  <div class="card-body" id="map" style="height: 260px">


                   <!--  <div id='map' style="height: 200px"></div> -->


                   <div class="progress rounded mb-2" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100"
                    aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div> 


          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

<!--  VOS CODE ICI  -->



</div>
</div>
</div>

<!-- /.content -->

<!-- ./wrapper -->
<?php //include VIEWPATH . 'templates/footer.php'; ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

</body>

</html>


<script>
  L.mapbox.accessToken = 'pk.eyJ1IjoibWFydGlubWVkaWFib3giLCJhIjoiY2s4OXc1NjAxMDRybzNobTE2dmo1a3ZndCJ9.W9Cm7Pjp25FQ00bII9Be6Q';
  var center = '-3.4313888,29.9079177';
  var center_coord = center.split(",");
  var zoom ='8';
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

// Start with a fixed marker.
var fixedMarker = L.marker(new L.LatLng(-3.4313888,29.9079177), {
  icon: L.mapbox.marker.icon({
    'marker-color': 'ff8888'
  })
}).bindPopup("<?=$agent['NOM']?> <?=$agent['PRENOM']?><br><?=$agent['NUMERO_MATRICULE']?>").addTo(map);


var fc = fixedMarker.getLatLng();

var featureLayer = L.mapbox.featureLayer().addTo(map);

map.on('click', function(ev) {

  var c = ev.latlng;

  var geojson = {
    type: 'FeatureCollection',
    features: [
    {
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
    }
    ]
  };

  featureLayer.setGeoJSON(geojson);

  var container = document.getElementById('distance');
  container.innerHTML = (fc.distanceTo(c)).toFixed(0) + 'm';
});
</script>




<script>

// Set up the chart
Highcharts.chart('containerRqpport', {
  chart: {
    type: 'bar'
  },
  title: {
    text: 'Amende totale <?=$total?> FBU<br>'
  },
  subtitle: {
    text: ''
  },
  xAxis: {
    categories: [<?=$catego?>],
    title: {
      text: null
    }
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
    bar: {
      dataLabels: {
        enabled: true
      }
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
  series: [ <?=$donne?>]
});
</script>