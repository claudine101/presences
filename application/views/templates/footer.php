<!-- /.content-wrapper -->
<footer class="main-footer">
  <strong>Copy right &copy; <?=date('Y')?> <a href="http://wasili.bi">RECECA-INKINGI</a>.</strong>
  Tous droits réservés.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.0
  </div>
</footer>

<!-- /.control-sidebar -->

<!-- jQuery -->
<script src="<?=base_url()?>plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url()?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?=base_url()?>plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?=base_url()?>plugins/sparklines/sparkline.js"></script>

<!-- jQuery Knob Chart -->
<script src="<?=base_url()?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?=base_url()?>plugins/moment/moment.min.js"></script>
<script src="<?=base_url()?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=base_url()?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?=base_url()?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url()?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url()?>dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?=base_url()?>dist/js/pages/dashboard.js"></script> -->

<!-- Hichart -->
<script src="<?=base_url()?>plugins/highcharts/highcharts.js"></script>
<script src="<?=base_url()?>plugins/highcharts/modules/sunburst.js"></script>
<script src="<?=base_url()?>plugins/highcharts/modules/exporting.js"></script>
<script src="<?=base_url()?>plugins/highcharts/modules/xrange.js"></script>
<script src="<?=base_url()?>plugins/highcharts/modules/export-data.js"></script>
<script src="<?=base_url()?>plugins/highcharts/highcharts-3d.js"></script>

<!-- DataTables -->
<!-- <script src="<?=base_url()?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url()?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url()?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js" ></script>

<!-- Select2 -->
<script src="<?=base_url()?>plugins/select2/js/select2.full.min.js"></script>
<script src="<?=base_url()?>plugins/select2/js/select2.min.js"></script>
<script type="text/javascript">
	$('.select2').select2()
</script>


<!-- NOTIFY -->
<script src="<?=base_url('')?>plugins/dist/simple-notify.min.js"></script>
<script src="<?=base_url('')?>plugins/js/prism.js"></script>
<script src="<?=base_url('')?>plugins/js/OverlayScrollbars.min.js"></script>
<script src="<?=base_url('')?>plugins/js/main.js"></script>
<!--  -->


<!-- <script src="../../extensions/Editor/js/dataTables.editor.min.js"></script> -->
<script src="https://cdn.datatables.net/select/1.3.2/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.0.2/js/dataTables.dateTime.min.js"></script>
<script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js
"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js
"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js
"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js
"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js
"></script>

<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js
"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js "></script>

<script src="<?=base_url()?>build/js/intlTelInput.js"></script>

<!-- BS-Stepper -->
<script src="<?= base_url()?>plugins/bs-stepper/js/bs-stepper.min.js">
</script>
<script>
   // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })
</script>


<script type="text/javascript">
  window.alert_notify=function(status,title,message,typ)
  {

      var notif=new Notify ({
        status:status,//success
        title: title,//Notify Title
        text: message,//Notify text lorem ipsum
        effect: 'slide',
        speed: 700,
        customClass: null,
        customIcon: null,
        showIcon: true,
        showCloseButton: true,
        autoclose: true,
        autotimeout: 5000,
        gap: 20,
        distance: 20,
        type:typ,
        position: 'right top'
      })
   
  }
    
</script>



