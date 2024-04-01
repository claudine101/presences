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

        <div class="col-md-12 col-xl-12 grid-margin stretch-card">

          <div class="card">
            <div class="card-body">
             







 



       <div class="modal fade" id="myModal2" role="dialog">
        <div class="modal-dialog modal-lg" style ="width:1000px">
          <div class="modal-content  modal-lg">
            <div class="modal-header">
              <h4 class="modal-title"><span id="titre"></span></h4>
            </div>
            <div class="modal-body">
              <div class="table-responsive">
                <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
                    <thead>
                     <th>#</th>
                                    <th>Plaque</th>
                                     <th>AMENDES</th>
                                      
                                      <th>DATE</th>
                                   
                                      
                  </thead>
                </table>
              </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>



               <div class="modal fade" id="myModal3" role="dialog">
        <div class="modal-dialog modal-lg" style ="width:1000px">
          <div class="modal-content  modal-lg">
            <div class="modal-header">
              <h4 class="modal-title"><span id="titre"></span></h4>
            </div>
            <div class="modal-body">
              <div class="table-responsive">
                <table id='mytable3' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
                  <thead>
                     <th>#</th>
                                    <th>PLAQUE</th>
                                     <th>AMENDES</th>
                                     <th>DATE</th>

                                    
                  </thead>
                </table>
              </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>






                  <div class="panel-body">
                    <div class="row">
                      
  <div class="col-md-12" id="container" style="border: 1px solid #d2d7db;"></div>
 
    <!-- <div class="col-md-6" id="container1" style="border: 1px solid #d2d7db;"></div> --> 
 

                      
                      
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








  
<script type="text/javascript">
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: '<?=$nombre?> voitures au Total'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: ['<?=$nombre?>'],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'nbre de jours restants '
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f}jrs</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0,
            cursor:'pointer'
        }
    },
    series: [{
        name: 'nbre de jrs restants',
        data: [<?=$donnees?>]

    }]
});

   </script>



   </html>