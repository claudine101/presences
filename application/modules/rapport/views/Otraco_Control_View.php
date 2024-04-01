<!DOCTYPE html>
<html lang="en">
 <?php include VIEWPATH.'templates/header.php'; ?> 


<style type="text/css">
#container {
  height: 420px;
}

.highcharts-figure,
.highcharts-data-table table {
  min-width: 360px;
  max-width: 600px;
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

        <div class="col-md-12 col-xl-12 grid-margin stretch-card">

          <div class="card">
            <div class="card-body">
        
<!--  <div class="col-md-12" id="container1" style="border: 1px solid #d2d7db;"></div>-->
  <div class="col-md-12" id="container2" style="border: 1px solid #d2d7db;"></div>
                      
                      
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/cylinder.js"></script>
<script src="https://code.highcharts.com/modules/funnel3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<?php include VIEWPATH.'templates/footerDeux.php'; ?>


</body>

<script>



Highcharts.chart('container2', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
    },
    title: {
        text: 'control technique<br><?=$FautControleTechnique + $ControleTechniqueVerifier?> immatriculations<br><?=date('d-m-Y')?>',
        align: 'center',
        verticalAlign: 'middle',
        y: 60
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                distance: -50,
                style: {
                    fontWeight: 'bold',
                    color: 'white'
                }
            },
            startAngle: -90,
            endAngle: 90,
            center: ['50%', '75%'],
            size: '110%'
        }
    },
    series: [{
        type: 'pie',
        name: 'control technique Total <?=$FautControleTechnique + $ControleTechniqueVerifier?> immatriculations',
        innerSize: '50%',
        data: [
            ['Otraco cntrl (<?=$otraco?>)', <?=$otraco?>],
            ['Faut Plaque avec cntrl (<?=$FautControleTechnique?>)', <?=$FautControleTechnique?>],
            ['Plaque avec cntrl (<?=$ControleTechniqueVerifier?>)', <?=$ControleTechniqueVerifier?>],
            
            {
                name: 'Other',
                y: 7.61,
                dataLabels: {
                    enabled: false
                }
            }
        ]
    }]
});






</script>


</html>