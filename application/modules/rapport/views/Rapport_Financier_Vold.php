<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header_reporting.php'; ?>


<style type="text/css">
  .highcharts-figure,
  .highcharts-data-table table {
    min-width: 360px;
    max-width: 800px;
    margin: 1em auto;
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
              <div class="row">

                <div class="col-md-12 " style="padding: 5px">

                  <form name="myform" action="<?= base_url('rapport/Rapport_Financier') ?>" method="post" id="myform">

                    <div class="row">
                      <div class="form-group col-md-4">
                        <label>ANNEE</label>

                        <select class="form-control" onchange="submit();" name="ANNEE" id="ANNEE">
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

                        <select class="form-control" onchange="submit();submit()" name="MOIS" id="MOIS">
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

              </div>

            </div>



            <div class="card-body">

              <div class="row">
                <div class="col-md-6" id="container" style="border: 1px solid #d2d7db;"></div>
                <div class="col-md-6" id="container2" style="border: 1px solid #d2d7db;"></div>
              </div>



            </div>
          </div>
        </div>

      </section>

    </div>

  </div>
  <!-- ./wrapper -->
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <?php include VIEWPATH . 'templates/footerDeux.php'; ?>


</body>

<script type="text/javascript">
  Highcharts.chart('container', {
    chart: {
      type: 'line'
    },
    title: {
      text: ' Total Amende par signalement <?= number_format($total2, 0, ',', ' ') ?> FBU'
    },
    subtitle: {
      //text: 'Source: WorldClimate.com'
    },
    xAxis: {
      categories: [<?= $catego ?>]
    },
    yAxis: {
      title: {
        text: 'Montant'
      }
    },
    plotOptions: {
      line: {
        dataLabels: {
          enabled: true
        },
        enableMouseTracking: false
      }
    },
    series: [{
      name: 'Amande par signalement',
      color: 'yellow',
      data: [<?= $datas ?>]
    }]
  });
</script>


<script type="text/javascript">
  Highcharts.chart('container2', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'Total Amende par controle <?= number_format($total, 0, ',', ' ') ?> FBU'
    },
    subtitle: {
      //text: 'Source: WorldClimate.com'
    },
    xAxis: {
      categories: [<?= $catego2 ?>]
    },
    yAxis: {
      title: {
        text: 'Montant'
      }
    },
    plotOptions: {
      line: {
        dataLabels: {
          enabled: true
        },
        enableMouseTracking: false
      }
    },
    series: [{
      name: 'Amande par controle',
      color: 'red',
      data: [<?= $datas2 ?>]
    }]
  });
</script>

<script type="text/javascript">
  function submit() {
    myForm.submit();
  }
</script>



</html>