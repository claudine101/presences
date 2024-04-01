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

.highcharts-credits{
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





        <!-- /.content-header 



SELECT `ID_PERMIS`, `NUMERO_PERMIS`, `NOM_PROPRIETAIRE`, `CATEGORIES`, `DATE_NAISSANCE`, `DATE_DELIVER`, `DATE_EXPIRATION` FROM `chauffeur_permis` WHERE ID_PERMIS

-->

<!-- Main content -->


<section class="content" style="background-color: #f1f1f100;">
  <div class="col-md-12 col-xl-12 grid-margin stretch-card">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
      </div>
    </div>
    <div class="row"> 

      <?php if(!empty($immatriculation)) { ?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
             <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Immatriculation</h3>
              <div class="card-body">
                <?=  $immatriculation  ?>
              </div>
            </div>
          </div>
        </div>
      <?php } else {?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
            <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Immatriculation</h3>
            <div class="card-body">
              <div class="alert alert-success" role="alert">
                L'immatriculation est correcte
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(!empty($assurance)) { ?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
             <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Assurance</h3>
              <div class="card-body">
                <?php  var_dump($assurance) ?>
              </div>
            </div>
          </div>
        </div>
      <?php } else {?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
           <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Assurance</h3>
            <div class="card-body">
              <div class="alert alert-success" role="alert">
                L'assurance est correcte
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(!empty($controle_technique)) { ?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
             <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Controle Technique</h3>
              <div class="card-body">
                <?=  $controle_technique  ?>
              </div>
            </div>
          </div>
        </div>
      <?php } else {?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
           <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Controle Technique</h3>
            <div class="card-body">
              <div class="alert alert-success" role="alert">
                Le controle technique est correct
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if(!empty($vol)) { ?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
             <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Declaration du vol</h3>
              <div class="card-body">
                <?=  $vol  ?>
              </div>
            </div>
          </div>
        </div>
      <?php } else {?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
           <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Declaration du vol</h3>
            <div class="card-body">
              <div class="alert alert-success" role="alert">
                pas de vol
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if(!empty($permis)) { ?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
             <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Controle Permis</h3>
              <div class="card-body">
                <?=  $permis  ?>
              </div>
            </div>
          </div>
        </div>
      <?php } else {?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
           <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Controle Permis</h3>
            <div class="card-body">
              <div class="alert alert-success" role="alert">
                Le pemis est en regle
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(!empty($detailControle)) { ?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
              <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Controle Physique</h3>
              <div class="card-body">
                <?=  $detailControle  ?>
              </div>
            </div>
          </div>
        </div>
      <?php } else {?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
             <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Controle Physique</h3>
              <div class="alert alert-success" role="alert">
                Le controle physique est correct
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(!empty($equipement)) { ?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
             <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Controle equipement</h3>
              <div class="card-body">
                <?=  $equipement  ?>
              </div>
            </div>
          </div>
        </div>
      <?php } else {?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
             <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Controle equipement</h3>
              <div class="alert alert-success" role="alert">
                controle equipement est correcte
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

       <?php if(!empty($marchandise)) { ?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
             <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Controle marchandise</h3>
              <div class="card-body">
                <?=  $marchandise  ?>
              </div>
            </div>
          </div>
        </div>
      <?php } else {?>
        <div class="col-md-6">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
             <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Controle marchandise</h3>
              <div class="alert alert-success" role="alert">
                controle marchandise est correcte
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
  </section>




  <!-- /.content -->
</div>

</div>
<!-- ./wrapper -->
<?php include VIEWPATH . 'templates/footer.php'; ?>
    <!-- <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script> -->

</body>

</html>

