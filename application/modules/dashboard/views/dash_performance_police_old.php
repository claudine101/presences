<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header_reporting.php'; ?> 



<style type="text/css">
.mapbox-improve-map{
  display: none;
}

.leaflet-control-attribution{
  display: none !important;
}
.leaflet-control-attribution{
  display: none !important;
}

.mapbox-logo {
  display: none;
}
</style>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include VIEWPATH.'templates/navbar.php'; ?>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include VIEWPATH.'templates/sidebar.php'; ?> 


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><?=$title?></h1>
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
        <div class="card-header">
         <div class="col-md-12 "style="padding: 5px">
          <form name="myform" action="<?=base_url('dashboard/Dash_performance_police') ?>" method="POST" id="myform">

            <div class="row">
              <div class="form-group col-md-3">
                <label>ANNEE</label>

                <select class="form-control" onchange="submit()" name="ANNEE" id="ANNEE" >
                  <option value="">Sélectionner</option>
                  <?php

                  foreach ($annees as $value){
                    if ($value['ANNEE'] == set_value('ANNEE'))
                      {?>
                        <option value="<?=$value['ANNEE']?>" selected><?=$value['ANNEE']?></option>
                      <?php } else{ ?>
                        <option value="<?=$value['ANNEE']?>"><?=$value['ANNEE']?></option>
                      <?php }              
                    } ?>
                  </select>
                </div>  

                <div class="form-group col-md-3">
                  <label>MOIS</label>

                  <select class="form-control" onchange="submit()" name="MOIS" id="MOIS" >
                    <option value="">Sélectionner</option>
                    <?php

                    foreach ($mois as $value){
                      if ($value['MOIS'] == set_value('MOIS'))
                        {?>
                          <option value="<?=$value['MOIS']?>" selected><?=$value['MOIS']?></option>
                        <?php } else{ ?>
                          <option value="<?=$value['MOIS']?>"><?=$value['MOIS']?></option>
                        <?php }              
                      } ?>
                    </select>
                  </div>  

                  <div class="form-group col-md-3">
                    <label>DATE</label>

                    <select class="form-control" onchange="submit()" name="DAYS" id="DAYS" >
                      <option value="">Sélectionner</option>
                      <?php

                      foreach ($jour as $value){
                        if ($value['DAYS'] == set_value('DAYS'))
                          {?>
                            <option value="<?=$value['DAYS']?>" selected><?=$value['DAYS']?></option>
                          <?php } else{ ?>
                            <option value="<?=$value['DAYS']?>"><?=$value['DAYS']?></option>
                          <?php }       
                        } ?>
                      </select>
                    </div>  

                    <div class="form-group col-md-3">
                      <label>Statut</label>

                      <select class="form-control" onchange="submit()" name="STATUT" id="STATUT" >
                       <option value="">Sélectionner</option>
                       <option value="1" >Payé</option>

                       <option value="0" >Non Payé</option>

                     </select>
                   </div>  



                 </div>


               </form>
             </div>

           </div>
           





           <div class="card-body">
            <div class="row">



              <div class="col-md-6" id="containerRapport"></div>

              <div class="col-md-6" id="container2" ></div> 
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
<?php include VIEWPATH.'templates/footer.php'; ?>
</body>

<script  type="text/javascript">
  function submit()
  {
    myForm.submit();
  } 
</script>


<script type="text/javascript">
  Highcharts.chart('container2', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Total Amende par fonctionnel de la police <?= number_format($total1, 0, ',', ' ') ?> FBU'
    },
    subtitle: {
      //text: 'Source: WorldClimate.com'
    },
    xAxis: {
      categories: [<?= $categos ?>]
    },
    yAxis: {
      title: {
        text: 'Montant'
      }
    },
    plotOptions: {
      column: {
        dataLabels: {
          enabled: true
        },
        enableMouseTracking: false
      }
    },
    series: [{
      name: 'Amende',
      data: [<?= $donne1 ?>],
    }]
  });
</script>



<script>
  // Set up the chart
  Highcharts.chart('containerRapt', {
    chart: {
      type: 'bar'
    },
    title: {
      text: 'Nombre totale de Contrôle : <?= $total ?> <br>'
    },
    subtitle: {
      text: ''
    },
    xAxis: {
      categories: [<?= $catego ?>],
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
      valueSuffix: null
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
      backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
      shadow: true
    },
    credits: {
      enabled: false
    },
    series: [<?= $donne ?>]
  });
</script>

<script type="text/javascript">
  // Build the chart
  Highcharts.chart('containerRappo', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: 'Nombre totale de Contrôle : <?= $total ?> <br>'
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.y}</b>'
    },
    accessibility: {
      point: {
        valueSuffix: null
      }
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          format: '<b>{point.name}</b>: {point.y} ',
          connectorColor: 'silver'
        },
        showInLegend: true
      }
    },
    series: [{
      name: 'Brands',
      colorByPoint: true,
      data: [<?= $donne ?>]
    }]
  });
</script>


<script type="text/javascript">

  Highcharts.chart('containerRapport', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'Nombre totale de Contrôle : <?= $total ?> <br>'
    },
    subtitle: {
      text: ''
    },
    xAxis: {
      categories: [<?= $catego ?>]
    },
    yAxis: {
      title: {
        text: null
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
    series: [<?= $donne ?>]
  });
</script>

</html>