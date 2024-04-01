<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header_reporting.php'; ?>


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
                                                            <div class="card-body">

                                                                      <div class="col-md-12 " style="padding: 5px">


                                                                                <form id="myform" action="<?= base_url('dashboard/Amende_percu_journe/index') ?>" method="post">
                                                                                          <div class="row">
                                                                                                    <div class="form-group col-md-4">
                                                                                                              <label>Du</label>
                                                                                                              <input type="date" name="DateChec" class="form-control" onchange="getNeyday()" value="<?= $date_insert ?>">
                                                                                                    </div>
                                                                                                    <div class="form-group col-md-4">
                                                                                                              <label>Au</label>
                                                                                                              <input type="date" name="date_fin" class="form-control" onchange="getNeyday()" value="<?= $date_fin ?>">
                                                                                                    </div>
                                                                                          </div>

                                                                                </form>



                                                                                <div id="container" style="border: 1px solid #d2d7db"></div>

                                                                      </div>

                                                            </div>
                                                  </div>


                              </section>

                    </div>

          </div>
          <!-- ./wrapper -->
          <?php include VIEWPATH . 'templates/footer.php'; ?>
</body>

<script type="text/javascript">
          function getNeyday() {
                    //alert('date_insert')
                    myform.submit();
          }
</script>


<script>
          Highcharts.chart('container', {
                    chart: {
                              type: 'column'
                    },
                    title: {
                              text: '<b>Amende journalière totale </b><?= number_format($nombre, 0, ',', ' ')  ?> FBU'
                    },

                    subtitle: {
                              text: ''
                    },
                    xAxis: {
                              type: 'category'
                    },

                    plotOptions: {
                              column: {
                                        cursor: 'pointer',
                                        depth: 25,
                                        point: {
                                                  events: {
                                                            click: function() {

                                                                      $("#titre").html("Liste des cas");

                                                                      $("#myModal2").modal();



                                                                      var row_count = "1000000";
                                                                      $("#mytable2").DataTable({
                                                                                "processing": true,
                                                                                "serverSide": true,
                                                                                "bDestroy": true,
                                                                                "oreder": [],
                                                                                "ajax": {
                                                                                          url: "<?= base_url('dashboard/Amende_percu_journe/detailChausse') ?>",
                                                                                          type: "POST",
                                                                                          data: {
                                                                                                    key: this.key,
                                                                                                    date_insert: $('#date_insert').val()

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
                                                                                          "sLengthMenu": "Afficher MENU &eacute;l&eacute;ments",
                                                                                          "sInfo": "Affichage de l'&eacute;l&eacute;ment START &agrave; END sur TOTAL &eacute;l&eacute;ments",
                                                                                          "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                                                                                          "sInfoFiltered": "(filtr&eacute; de MAX &eacute;l&eacute;ments au total)",
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


                    credits: {
                              enabled: true,
                              href: "",
                              text: "MEDIABOX"
                    },
                    series: [{
                              name: 'Fonctionnaire PNB',
                              color: '#1E90FF',
                              data: [<?= $donne ?>]
                    }]
          });
</script>


</html>