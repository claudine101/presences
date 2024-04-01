


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
    max-width: 800px;
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



        <section class="content" style="background-color: #f1f1f100;">
          <div class="container-fluid">
      

            <div class="row">
              <div class="col-lg-4">
                <div class="card mb-4">
                  <div class="card-body text-center">
                    <img src="<?= $agent['PHOTO'] ?>" alt="." class="img-fluid" style="width:160px;height:150px">
                    <p class="text-muted mb-1"><?= $agent['NOM'] . ' ' . $agent['PRENOM'] ?></p>
                    <p class="text-muted mb-1"><?=  $this->notifications->ago($agent['DATE_NAISSANCE'],date('Y-m-d'))  ?> </p>
                    <p class="text-muted mb-4">N° <?= $agent['NUMERO_MATRICULE'] ?></p>

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
              <div class="col-lg-0"></div>
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


                  <div class="col-md-12">
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

                        <p class="mb-1" style="font-size: .77rem;">Date: <span style="float: right;"><b><?= $agent['DATE_DEBUT'] ?> au <?= $agent['DATE_FIN'] ?></b></span> </p>
                        
                        <div class="progress rounded mb-2" style="height: 5px;">
                          <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                  </div>

               <!--    <div class="col-md-5">
                    <div class="card mb-4 mb-md-0">
                      <pre id='distance' class='ui-distance'></pre>
                      <div class="card-body" id="mapsss" style="height: 260px">
                      </div>
                    </div>
                  </div> -->


                </div>
              </div>
            </div>
          </div>
        </section>


<script type="text/javascript">
   function  changeDate() {
     myForma.submit();
   }
</script>







<script>


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