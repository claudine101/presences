<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header_reporting.php'; ?>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>


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

        <div class="col-md-12 col-xl-12 grid-margin stretch-card">

          <div class="card">
            <div class="card-header">
              <form id="myForm" method="post" action="<?= base_url('rapport/Declaration_Vehicule/index') ?>">

                <div class="row">


                  <div class="form-group col-md-6 ">

                    <label>DATE</label>

                    <select class="form-control" onchange="date_vol()" name="date_insert" id="date_insert">
                      <option value="">Sélectionner</option>
                      <?php

                      foreach ($date as $value) {
                        if ($value['date_insert'] == set_value('date_insert')) { ?>
                          <option value="<?= $value['date_insert'] ?>" selected><?= $value['date_insert'] ?></option>
                        <?php } else { ?>
                          <option value="<?= $value['date_insert'] ?>"><?= $value['date_insert'] ?></option>
                      <?php }
                      } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-6">


                    <label>STATUT</label>

                    <select class="form-control" onchange="statut_vol()" name="STATUT" id="STATUT">
                      <option value="">Sélectionner</option>
                      <?php

                      foreach ($statut as $value) {
                        if ($value['STATUT'] == set_value('STATUT')) { ?>
                          <option value="<?= $value['STATUT'] ?>" selected><?= $value['Statut'] ?></option>
                        <?php } else { ?>
                          <option value="<?= $value['STATUT'] ?>"><?= $value['Statut'] ?></option>
                      <?php }
                      } ?>
                    </select>
                  </div>
                </div>
            </div>
            </form>


            <div class="card-body">
              <div class="row">
                <div class="col-md-6" id="container" style="border : solid #d2d7db;"></div>
                <div class="col-md-6" id="container1" style="border: solid  #d2d7db;"></div>


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
  function date_vol() {
    myForm.submit();
  }
</script>


<script type="text/javascript">
  function statut_vol() {
    myForm.submit();
  }
</script>



<script type="text/javascript">
  Highcharts.chart('container1', {
    chart: {
      type: 'pie'
    },
    title: {
      text: 'STATUT (<?= $nombre1 ?>) '
    },
    subtitle: {
      text: 'STATUT'
    },
    xAxis: {
      type: 'category'

    },

    plotOptions: {
      pie: {
        cursor: 'pointer',
        depth: 25,

        dataLabels: {
          enabled: true
        },
        showInLegend: true
      }
    },
    credits: {
      enabled: true,
      href: "",
      text: "MEDIABOX"
    },
    series: [{
      color: 'lightblue',
      data: [<?= $donne1 ?>]
    }]
  });
</script>


<script>
  // Set up the chart
  Highcharts.chart('container', {
    chart: {
      type: 'columnpyramid'
    },
    title: {
      text: '<b>VALIDATION (<?= $nombre ?>)</b></br> </b>valider'
    },
    subtitle: {
      text: ''
    },
    credits: {
      enabled: true,
      href: "",
      text: "MEDIABOX"
    },

    xAxis: {
      type: 'category',
      labels: {
        rotation: -45,
        style: {
          fontSize: '10px',
          fontFamily: 'Verdana, sans-serif'
        }
      }
    },
    yAxis: {
      min: 0,
      title: {
        text: 'NBRE DE STATUT'
      }
    },
    legend: {
      enabled: false
    },
    tooltip: {
      pointFormat: 'STATUT'
    },


    credits: {
      enabled: true,
      href: "",
      text: "MEDIABOX"
    },
    plotOptions: {
      columnpyramid: {
        cursor: 'pointer',
        depth: 25,
        dataLabels: {
          enabled: true
        },
        showInLegend: true
      }
    },

    series: [{
      name: 'Menu',
      color: 'blue',
      data: [<?= $donne ?>],


    }]
  });
</script>

</html>