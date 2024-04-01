<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header_reporting.php'; ?>



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
            <div class="col-sm-6">
              <h1 class="m-0"><?= $title ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6 text-right">


              <span style="margin-right: 15px"> </span>

            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->


      <section class="content">

        <div class="card">

          <div class="col-md-12 " style="padding: 5px">
            <form name="myform" action="<?= base_url('dashboard/Dash_accident') ?>" method="POST" id="myform">

              <div class="row">
                <div class="form-group col-md-4">
                  <label>ANNEE</label>

                  <select class="form-control" onchange="submit()" name="ANNEE" id="ANNEE">
                    <option value="">Sélectionner</option>
                    <?php

                    foreach ($annees as $value) {
                      if ($value['ANNEE'] == set_value('ANNEE')) { ?>
                        <option value="<?= $value['ANNEE'] ?>" selected><?= $value['ANNEE'] ?></option>
                      <?php } else { ?>
                        <option value="<?= $value['ANNEE'] ?>"><?= $value['ANNEE'] ?></option>
                    <?php }
                    } ?>
                  </select>
                </div>

                <div class="form-group col-md-4">
                  <label>MOIS</label>

                  <select class="form-control" onchange="submit()" name="MOIS" id="MOIS">
                    <option value="">Sélectionner</option>
                    <?php

                    foreach ($mois as $value) {
                      if ($value['MOIS'] == set_value('MOIS')) { ?>
                        <option value="<?= $value['MOIS'] ?>" selected><?= $value['MOIS'] ?></option>
                      <?php } else { ?>
                        <option value="<?= $value['MOIS'] ?>"><?= $value['MOIS'] ?></option>
                    <?php }
                    } ?>
                  </select>
                </div>

                <div class="form-group col-md-4">
                  <label>DATE</label>

                  <select class="form-control" onchange="submit()" name="DAYS" id="DAYS">
                    <option value="">Sélectionner</option>
                    <?php

                    foreach ($jour as $value) {
                      if ($value['DAYS'] == set_value('DAYS')) { ?>
                        <option value="<?= $value['DAYS'] ?>" selected><?= $value['DAYS'] ?></option>
                      <?php } else { ?>
                        <option value="<?= $value['DAYS'] ?>"><?= $value['DAYS'] ?></option>
                    <?php }
                    } ?>
                  </select>
                </div>



              </div>


            </form>
          </div>







          <div class="card-body">
            <div class="row">



              <div class="col-md-6" id="container" style="border: 1px solid #d2d7db;"></div>

              <div class="col-md-6" id="container2" style="border: 1px solid #d2d7db;"></div>
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
  </div>
  </section>

  </div>

  </div>
  <!-- ./wrapper -->
  <?php include VIEWPATH . 'templates/footer.php'; ?>
</body>

<script type="text/javascript">
  function submit() {
    myForm.submit();
  }
</script>


<script type="text/javascript">
  Highcharts.chart('container2', {
    chart: {
      type: 'area'
    },
    title: {
      text: 'Rapport des accidents par chaussée'
    },
    subtitle: {
      text: '',
      align: 'right',
      verticalAlign: 'bottom'
    },
    legend: {
      layout: 'vertical',
      align: 'left',
      verticalAlign: 'top',
      x: 100,
      y: 70,
      floating: true,
      borderWidth: 1,
      backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
    },
    xAxis: {
      type: 'category'
    },
    yAxis: {
      title: {
        text: 'Nbre des accidents'
      }
    },
    credits: {
      enabled: true,
      href: "",
      text: "MEDIABOX"
    },
    plotOptions: {
      area: {
        fillOpacity: 0.5
      }
    },
    credits: {
      enabled: false
    },
    series: [{
      name: 'Chaussée',
      data: [<?= $donnees1 ?>]
    }]
  });
</script>




<script type="text/javascript">
  // Radialize the colors
  Highcharts.setOptions({
    colors: Highcharts.map(Highcharts.getOptions().colors, function(color) {
      return {
        radialGradient: {
          cx: 0.5,
          cy: 0.3,
          r: 0.7
        },
        stops: [
          [0, color],
          [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
        ]
      };
    })
  });

  // Build the chart
  Highcharts.chart('container', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: '<?= $nombre ?> accidents sur tous les dates'
    },
    tooltip: {
      pointFormat: '{series.name}: <b><?= $nombre ?></b>'
    },
    credits: {
      enabled: true,
      href: "",
      text: "MEDIABOX"
    },
    accessibility: {
      point: {
        valueSuffix: '%'
      }
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          format: '<b>{point.name}</b>:({point.y})',
          connectorColor: 'silver'
        }
      }
    },
    series: [{
      name: 'Accident',
      data: [<?= $donnees ?>]
    }]
  });
</script>






</html>