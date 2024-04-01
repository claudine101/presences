<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>



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
            <div class="col-sm-8">
              <h4 class="m-0"><?= $title ?></h4>
            </div><!-- /.col -->
             <div class="col-sm-4 text-right">
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->


        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="col-md-12 col-xl-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="col-md-12 table-responsive">
                  <table id='commentaire' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        <td>NUMERO PLAQUE</td>
                         <td>DATE</td>
                        <td>OBR</td>
                        <td>ASSURANCE</td>
                        <td>OTRACO</td>
                        <td>POLICE JUDICIAIRE</td>
                        <td>INTERPOL</td>
                        <td>PSR</td>
                        <td>PARKING</td>
                        <td>TRANSPORT</td>
                      </tr>
                    </thead>
                  </table>
                </div>
                <!--  VOS CODE ICI  -->
              </div>
            </div>
          </div>

      </div>

      <!-- PSR partie -->



      <!-- End PSR partie -->

    </div>
  </div>
  </div>
  </div>


  </section>

 <div class="modal fade" id="detailControl">
       <div class="modal-dialog modal-lg" >
         <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;">Détails:</h4>

            </div>

            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
         <div class="modal-body">

           <div class="col-md-12">

                  <table id='mytable' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        <td>NUMERO PLAQUE</td>
                        <td>COMMENTAIRE</td>
                        <td>PHOTO</td>
                        <td>DATE</td>
                      </tr>
                    </thead>
                  </table>



                </div>
        
      </div>
         <div class="modal-footer"> 
           <!--  <button id="btn_quiter" type="button" class="btn btn-primary" class='close' data-dismiss='modal'>Quitter</button> -->
         </div>
       </div>
     </div>
   </div>


  <!-- /.content -->
  </div>

  </div>


  <!-- ./wrapper -->
  <?php include VIEWPATH . 'templates/footer.php'; ?>
</body>

</html>

