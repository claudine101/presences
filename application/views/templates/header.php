<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title id="app_title">PNB</title>

  <link rel="icon" type="image/jpg" href="<?=base_url()?>uploads/images.jfif"/>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/summernote/summernote-bs4.min.css">


  <!-- Select2 -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?=base_url()?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css
  ">
  <!-- <link rel="stylesheet" href="../../extensions/Editor/css/editor.dataTables.min.css
  "> -->
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.2/css/select.dataTables.min.css
  ">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css
  ">
  <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.0.2/css/dataTables.dateTime.min.css
  ">
  <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.3/css/colReorder.dataTables.min.css
  ">

<!-- PACY -->
<link rel="stylesheet" href="<?= base_url()?>plugins/bs-stepper/css/bs-stepper.min.css">



  <script src='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.js'></script>
  <link href='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.css' rel='stylesheet' />

  <!-- <link href="https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js"></script> -->


<!-- <script src="https://unpkg.com/leaflet-canvas-marker@0.2.0"></script>
-->
<link href='https://api.mapbox.com/mapbox.js/v3.2.0/mapbox.css' rel='stylesheet' />
 <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/leaflet.markercluster.js'></script>
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.css' rel='stylesheet' />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.Default.css' rel='stylesheet' />

<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' /> <script src='https://api.mapbox.com/mapbox.js/v3.2.0/mapbox.js'></script>
<link href='https://api.mapbox.com/mapbox.js/v3.2.0/mapbox.css' rel='stylesheet' />
 <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/leaflet.markercluster.js'></script>
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.css' rel='stylesheet' />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.Default.css' rel='stylesheet' />

<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />

<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-zoomslider/v0.7.0/L.Control.Zoomslider.js'></script>
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-zoomslider/v0.7.0/L.Control.Zoomslider.css' rel='stylesheet' />


<!-- Toastr -->
 <link rel="stylesheet" href="<?=base_url()?>plugins/css/prism.css" />
   
    <link rel="stylesheet" href="<?=base_url()?>plugins/dist/simple-notify.min.css" />
    <link rel="stylesheet" href="<?=base_url()?>plugins/css/OverlayScrollbars.min.css" />

<link rel="stylesheet" href="<?=base_url()?>build/css/intlTelInput.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Ce code affiche l'heure acteulle -->
<script>
function affichZero(nombre) {
return nombre < 10 ? '0' + nombre : nombre;
}

function dateEtHeure() {

const infos = new Date();
 

document.getElementById('heure_exacte').innerHTML = ' ' + affichZero(infos.getHours()) + ':' + affichZero(infos.getMinutes()) + ":" + affichZero(infos.getSeconds());
}
window.onload = function() {
setInterval("dateEtHeure()", 1000);
};
</script>


<style type="text/css">
   .btn-success {
  color: green;
  background-color: #fff;
  border-color: #f4fbf5;
}

.btn-danger{

  color: red;
  background-color: #fff;
  border-color: #f4fbf5;

}

.modal-header{
  background-color: #000;
  color: #fff;
  font-size: 13px;
}
/*.welcome-text{
  background-color: #fff;
  color: "#000";
}
*/
</style>



</head>
