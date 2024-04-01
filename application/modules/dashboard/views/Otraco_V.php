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

             <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog modal-lg" style ="width:100%">
                <div class="modal-content  modal-lg">
                  <div class="modal-header">
                    <h4 class="modal-title"><span id="titre"></span></h4>
                  </div>
                  <div class="modal-body">
                    <div class="table-responsive">
                      <table id='mytable' class='table table-bordered table-striped table-hover table-condensed' style="width:100%">
                        <thead>
                         <th>#</th>
                         <th>PLAQUE</th>
                         <th>DATE VALIDITE</th>

                         <th>TYPE DE VOITURE</th>
                         <th>PROPRIETAIRE</th>


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



          <div class="modal fade" id="myModal2" role="dialog">
            <div class="modal-dialog modal-lg" style ="width:100%">
              <div class="modal-content  modal-lg">
                <div class="modal-header">
                  <h4 class="modal-title"><span id="titre2"></span></h4>
                </div>
                <div class="modal-body">
                  <div class="table-responsive">
                    <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style="width:100%">
                      <thead>
                       <tr>
                        <th>#</th>
                        <th>NUMERO PLAQUE</th>
                        <th>NOM_ASSUREUR</th>
                        <th>DATE_VALIDITE</th>
                        <th>PLACES_ASSURES</th>
                        <th>NOM_PROPRIETAIRE</th>
                      </tr>
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

            <div class="col-md-6" id="container" style="border: 1px solid #d2d7db;"></div>

            <div class="col-md-6" id="container1" style="border: 1px solid #d2d7db;"></div> 
          </div>
          <div class="row">

           <div class="col-md-6" id="container3" style="border: 1px solid #d2d7db;"></div>            

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
  Highcharts.chart('container1', {
    chart: {
      type: 'column'
    },
    title: {
      text: '<?=$nombre1?> voitures assurées au Total '
    },
    subtitle: {
      text: 'Liste des voitures assurées Selon leur validité'
    },
    xAxis: {
      type: 
      'category'


    },
    yAxis: {
      min: 0,
      title: {
        text: 'Nbre des voitures'
      }
    },
    tooltip: {
      shared: true,

    },
    plotOptions: {
      column: {

       cursor:'pointer',
       point:{
        events: {
         click: function()
         {



           $("#titre2").html("Liste des voitures assurées Selon leur validité");
           $("#myModal2").modal();

           var row_count ="1000000";
           $("#mytable2").DataTable({
            "processing":true,
            "serverSide":true,
            "bDestroy": true,
            "oreder":[],
            "ajax":{
              url:"<?=base_url('dashboard/Dashboard_Otraco/detailAssurance')?>",
              type:"POST",
              data:{
                key:this.key,

              }
            },
            lengthMenu: [[10,50, 100, row_count], [10,50, 100, "All"]],
            pageLength: 10,
            "columnDefs":[{
              "targets":[],
              "orderable":false
            }],

            dom: 'Bfrtlip',
            buttons: [
            'excel', 'print','pdf'
            ],
            language: {
              "sProcessing":     "Traitement en cours...",
              "sSearch":         "Rechercher&nbsp;:",
              "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
              "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
              "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
              "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
              "sInfoPostFix":    "",
              "sLoadingRecords": "Chargement en cours...",
              "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
              "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
              "oPaginate": {
                "sFirst":      "Premier",
                "sPrevious":   "Pr&eacute;c&eacute;dent",
                "sNext":       "Suivant",
                "sLast":       "Dernier"
              },
              "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
              }
            }

          });


         }
       }
     },

     dataLabels: {
       enabled: true
     },
     showInLegend: false
   }
 },  
 credits: {
  enabled: true,
  href: "",
  text: "MEDIABOX"
},
series: [{
  color: 'lightblue',
  data: [<?=$donnees1?>]

}]
});
</script>
<script type="text/javascript">
  Highcharts.chart('container', {
    chart: {
      type: 'pie'
    },
    title: {
      text: '<?=$nombre?> voiture au total avec Controle technique'
    },
    subtitle: {
      text: 'Listes des voitures avec Controle technique selon leur validité'
    },
    xAxis: {
      type: 'category'

    },

    plotOptions: { 
      pie: {
       cursor:'pointer',
       depth: 25,
       point:{
        events: {
          click: function()
          {
                //  alert(this.key);

                $("#titre").html("Liste des voitures selon la vilidité du controle-technique");

                $("#myModal").modal();


                var row_count ="1000000";
                $("#mytable").DataTable({
                  "processing":true,
                  "serverSide":true,
                  "bDestroy": true,
                  "oreder":[],
                  "ajax":{
                    url:"<?=base_url('dashboard/Dashboard_Otraco/detailControle')?>",
                    type:"POST",
                    data:{
                      key:this.key,


                    }
                  },
                  lengthMenu: [[5,10,50, 100, row_count], [5,10,50, 100, "All"]],
                  pageLength: 5,
                  "columnDefs":[{
                    "targets":[],
                    "orderable":false
                  }],

                  dom: 'Bfrtlip',
                  buttons: [
                  'excel', 'print','pdf'
                  ],
                  language: {
                    "sProcessing":     "Traitement en cours...",
                    "sSearch":         "Rechercher&nbsp;:",
                    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                    "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    "sInfoPostFix":    "",
                    "sLoadingRecords": "Chargement en cours...",
                    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
                    "oPaginate": {
                      "sFirst":      "Premier",
                      "sPrevious":   "Pr&eacute;c&eacute;dent",
                      "sNext":       "Suivant",
                      "sLast":       "Dernier"
                    },
                    "oAria": {
                      "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                      "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                    }
                  }

                });




              }
            }
          },
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
      data: [<?=$donnees?>]
    }]
  });
</script>







</html>