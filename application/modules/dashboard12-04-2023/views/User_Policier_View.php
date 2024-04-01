<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header_reporting.php'; ?>


<style type="text/css">
  #container {
    height: 400px;
  }


  .highcharts-figure,
  .highcharts-data-table table {
    min-width: 310px;
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
        <div class="panel-body">
          <div class="row">

            <div class="col-md-6" id="container"></div>
            <div class="col-md-6" id="container1"></div>



          </div>


          <div class="modal fade" id="myModal2" role="dialog">
            <div class="modal-dialog modal-lg" style="width:1000px">
              <div class="modal-content  modal-lg">
                <div class="modal-header">
                  <h4 class="modal-title"><span id="titre2"></span></h4>
                </div>
                <div class="modal-body">
                  <div class="table-responsive">
                    <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>PIECE</th>
                          <th>QUANTITE</th>

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


  <?php include VIEWPATH . 'templates/footerDeux.php'; ?>


</body>


<script type="text/javascript">
  Highcharts.chart('container1', {
    chart: {
      type: 'column'
    },
    title: {
      text: '<?= $nom1 ?>officier connecté',
    },
    subtitle: {
      text: ''
    },
    xAxis: {
      type: 'category'
    },
    yAxis: {
      min: 0,
      title: {
        text: ''
      }
    },
    plotOptions: {


      column: {
        cursor: 'pointer',
        depth: 25,
        point: {
          events: {
            click: function() {

              $("#titre2").html("Liste des officiers connectés par date");

              $("#myModal2").modal();


              var row_count = "1000000";
              $("#mytable2").DataTable({
                "processing": true,
                "serverSide": true,
                "bDestroy": true,
                "oreder": [],
                "ajax": {
                  url: "<?= base_url('dashboard/Useer_Policier_Dash/detailUsers') ?>",
                  type: "POST",
                  data: {
                    key: this.key,


                  }
                },
                lengthMenu: [
                  [10, 50, 100, row_count],
                  [10, 50, 100, "All"]
                ],
                pageLength: 10,
                "columnDefs": [{
                  "targets": [],
                  "orderable": false
                }],

                dom: 'Bfrtlip',
                buttons: [
                  'excel', 'print', 'pdf'
                ],
                language: {
                  "sProcessing": "Traitement en cours...",
                  "sSearch": "Rechercher&nbsp;:",
                  "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                  "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                  "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                  "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                  "sInfoPostFix": "",
                  "sLoadingRecords": "Chargement en cours...",
                  "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                  "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                  "oPaginate": {
                    "sFirst": "Premier",
                    "sPrevious": "Pr&eacute;c&eacute;dent",
                    "sNext": "Suivant",
                    "sLast": "Dernier"
                  },
                  "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
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
    series: [{
      name: 'officier connecté par date',

      data: [<?= $donnees1 ?>]
    }]
  });
  Highcharts.chart('container', {
    chart: {
      type: 'line'
    },
    title: {
      text: '<?= $nom ?>officier au total'
    },
    subtitle: {
      text: ''
    },
    xAxis: {
      // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      type: 'category'
    },
    yAxis: {
      title: {
        text: 'nbre d officier connecté'
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
    credits: {
      enabled: true,
      href: "",
      text: "MEDIABOX"
    },
    series: [{
        name: 'officier connecté',
        data: [<?= $donnees ?>]


      }

    ]
  });
</script>





</html>