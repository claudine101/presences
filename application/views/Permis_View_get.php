
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
  
  .highcharts-credits{
    display: none;
  }



  .highcharts-figure,
  .highcharts-data-table table {
    max-height: 400px;
    max-width: 400px;
    margin: 1em auto;
  }

  #container {
    height: 800px;
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

        <section class="content" style="background-color: #f1f1f100;">
          <div class="container-fluid py-4">
            <div class="row">
              <div class="col">
              </div>
            </div>

            <div class="row">
              <div class="col-lg-4">
                <div class="card mb-4">
                  <div class="card-body text-center">
                    <img src="https://www.bing.com/th?id=OIP.8BcplPdIioIbIRLvpp6reQHaHa&w=250&h=250&c=8&rs=1&qlt=90&o=6&pid=3.1&rm=2" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                    <p class="text-muted mb-1"><?= $Permis['NOM_PROPRIETAIRE'] ?></p>
                    <p class="text-muted mb-1"><?=$this->notifications->ago($Permis['DATE_NAISSANCE'],date('Y-m-d'))?> </p>
                    <p class="text-muted mb-4"><?= $Permis['NUMERO_PERMIS'] ?></p>


                  </div>
                </div>
                <div class="mb-4 mb-md-0">
                  <!-- <div class="card-body p-2"> -->

                    <p class="mb-1" style="font-size: .77rem;">Categorie: <span style="float: right;"><b><?= $Permis['CATEGORIES'] ?></b></span> </p>
                    <div class="progress rounded" style="height: 5px;">
                    </div>

                     <p class="mb-1" style="font-size: .77rem;">Point: <span style="float: right;"><b><?= $Permis['POINT_PERMIS'] - $totalPoint ?></b></span> </p>
                    <div class="progress rounded" style="height: 5px;">
                    </div>

                    <p class="mb-1" style="font-size: .77rem;">Delivre: <span style="float: right;"><b><?= $Permis['DATE_DELIVER'] ?></b></span> </p>
                    <div class="progress rounded" style="height: 5px;">
                    </div>


                    <p class="mb-1" style="font-size: .77rem;">Expiration: <span style="float: right;"><b><?= $Permis['DATE_EXPIRATION'] ?></b></span> </p>
                    <div class="progress rounded" style="height: 5px;">
                    </div>

                   <!-- 
                    </ul>
                  </div> -->
                </div>
              </div>
              <div class="col-lg-8">
                <div class="card mb-4">
                  <div class="card-body">
                    <div id="containerRqpport" style="height: 400px;"></div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </section>








<script>
  // Set up the chart


  Highcharts.chart('containerRqpport', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Rapport de la conduite'
    },
    subtitle: {
        text: '<?= number_format($totalInter, 0, ',', ' ')  ?> Interpellations, <?= number_format($totalAmende, 0, ',', ' ')  ?>FBU Amendes, - <?= $totalPoint?> Points<br></b>'
    },
    xAxis: {
        categories: [<?= $catego ?>],
        accessibility: {
            description: 'Infrations'
        }
    },


    yAxis: {
        title: {
            text: 'Permis'
        },
        labels: {
            formatter: function () {
                return this.value + 'K FBU';
            }
        }
    },

     tooltip: {
        crosshairs: true,
        shared: true
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: true,
            // marker: {
            //     radius: 2,
            //     lineColor: '#666666',
            //     lineWidth: 1
            // }
        }
    },


    series: [<?= $donne ?>],

});






 
</script>