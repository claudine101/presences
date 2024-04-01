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
        <div class="card">
          <div class="card-header">
            <div class="col-md-12 " style="padding: 5px">
              <form name="myform" action="<?= base_url('dashboard/Dash_performance_police') ?>" method="POST" id="myform">

                <div class="row">

                  <div class="form-group col-md-2">
                    <label>CATEGORIES</label>

                    <select class="form-control" onchange="submit()" name="ID_CATEGORIE" id="ID_CATEGORIE">
                 <option value="">Sélectionner</option>
                      <?php

                      foreach ($cat as $value) {
                        if ($value['ID_CATEGORIE'] ==set_value('ID_CATEGORIE')) { ?>
                          <option value="<?= $value['ID_CATEGORIE'] ?>" selected><?= $value['DESCRIPTION'] ?></option>
                        <?php } else { ?>
                          <option value="<?= $value['ID_CATEGORIE'] ?>"><?= $value['DESCRIPTION'] ?></option>
                      <?php }
                      } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-2">
                    <label>ANNEE</label>

                    <select class="form-control" onchange="submit()" name="ANNEE" id="ANNEE">
                     <!--  <option value="">Sélectionner</option> -->
                      <?php

                      foreach ($annees as $value) {
                        if ($value['ANNEE'] == $ANNEE) { ?>
                          <option value="<?= $value['ANNEE'] ?>" selected><?= $value['ANNEE'] ?></option>
                        <?php } else { ?>
                          <option value="<?= $value['ANNEE'] ?>"><?= $value['ANNEE'] ?></option>
                      <?php }
                      } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-2">
                    <label>MOIS</label>

                    <select class="form-control" onchange="submit()" name="MOIS" id="MOIS">
                    <option value=""><?=$MOISsel?></option>
                      <?php

                      foreach ($mois as $value) {
                        if ($value['MOIS'] ==set_value('MOIS')) { ?>
                          <option value="<?= $value['MOIS'] ?>" selected><?= $value['MOIS'] ?></option>
                        <?php } else { ?>
                          <option value="<?= $value['MOIS'] ?>"><?= $value['MOIS'] ?></option>
                      <?php }
                      } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-2">
                    <label>DATE</label>

                    <select class="form-control" onchange="submit()" name="DAYS" id="DAYS">
                      <option value="">Sélectionner</option>
                      <?php

                      foreach ($jour as $value) {
                        if ($value['DAYS'] == set_value('DAYS')) { ?>
                          <option value="<?= $value['DAYS'] ?>" selected><?= $value['DAYS'] ?></option>
                        <?php } else { ?>
                          <option value="<?= $value['DAYS'] ?>"><?= $value['DAYS'] ?></option>
                      <?php }
                      } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-2">
                    <label>Annulation</label>

                    <select class="form-control" onchange="submit()" name="IS_ANNULE" id="IS_ANNULE">
                      <option value="">Sélectionner</option>

                      <?php if (set_value('IS_ANNULE') == 1) { ?>
                        <option value="1" selected>Annulé</option>

                        <option value="0">Maintenu</option>
                      <?php } else { ?>
                        <option value="1">Annulé</option>

                        <option value="0" selected>Maintenu</option>
                      <?php } ?>

                    </select>
                  </div>


                  <div class="form-group col-md-2">
                    <label>Statut</label>

                    <select class="form-control" onchange="submit()" name="STATUT" id="STATUT">
                      <option value="">Sélectionner</option>

                      <?php if (set_value('STATUT') == 1) { ?>
                        <option value="1" selected>Payé</option>

                        <option value="0">Non Payé</option>
                      <?php } else { ?>
                        <option value="1">Payé</option>

                        <option value="0" selected>Non Payé</option>
                      <?php } ?>

                    </select>
                  </div>



                </div>


              </form>
            </div>

          </div>






          <div class="card-body">
            <div class="row">



              <div class="col-md-6" id="containerRapport"></div>

              <div class="col-md-6" id="container2"></div>
            </div>




          </div>


          <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg" style ="width:1000px">
          <div class="modal-content  modal-lg">
            <div class="modal-header" style="background: #000">
              <h4 class="modal-title"><span id="titre"></span></h4>
            </div>
            <div class="modal-body">
                 <div class="table-responsive"> 
                <table style="width: 100%;" id='mytable' class='table table-bordered table-striped table-hover table-condensed table-responsive'>
                   <thead>
                                <tr>
                                
                                  <th>Agent</th>
                                  <th>Date_de_fait</th>
                                  <th>Type</th>
                                  <th>Annulé</th>
                                  <th>Plaque</th>
                                  <th>Permis</th>
                                  <th>Amende BIF</th>
                                  <th>Statut</th>
                                  
                                </tr>
                              </thead>
                </table>

             </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Quitter</button>
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
  <!-- ./wrapper -->
  <?php include VIEWPATH . 'templates/footer.php'; ?>
</body>

<script type="text/javascript">
  function submit() {
    myForm.submit();
  }
</script>


<script type="text/javascript">
  Highcharts.chart('container2', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Amende par fonctionnaire de la police <?= number_format($total1, 0, ',', ' ') ?> FBU'
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
                 cursor:'pointer',
      point:{
        events: {
    click: function()
                 {
                                  
                   $("#titre").html("Detail");
                      $("#myModal").modal();

                      var row_count ="1000000";

                        $("#mytable").DataTable({
                          "processing":true,
                          "serverSide":true,
                          "bDestroy": true,
                          "oreder":[],
                          "ajax":{
                               url:"<?=base_url('dashboard/Dash_performance_police/detail')?>",
                              type:"POST",
                              data:{
                                key:this.key,
                                STATUT:$('#STATUT').val(),
                                ANNEE:$('#ANNEE').val(),
                                MOIS:$('#MOIS').val(),
                                ID_CATEGORIE:$('#ID_CATEGORIE').val(),
                                DAYS:$('#DAYS').val(),
                                 IS_ANNULE:$('#IS_ANNULE').val(),
                                
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
             enabled: true,
             format: '{point.y:,f} '
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
      name: 'Amende',
      data: [<?= $donne1 ?>],
    }]
  });
</script>




<script type="text/javascript">
  Highcharts.chart('containerRapport', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'Nombre total de Contrôle : <?= $total ?> <br>'
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
                 cursor:'pointer',
      point:{
        events: {
    click: function()
                 {
                                  
                   $("#titre").html("Detail");
                      $("#myModal").modal();

                      var row_count ="1000000";

                        $("#mytable").DataTable({
                          "processing":true,
                          "serverSide":true,
                          "bDestroy": true,
                          "oreder":[],
                          "ajax":{
                               url:"<?=base_url('dashboard/Dash_performance_police/detail')?>",
                              type:"POST",
                              data:{
                                key:this.key,
                                STATUT:$('#STATUT').val(),
                                ANNEE:$('#ANNEE').val(),
                                MOIS:$('#MOIS').val(),
                                ID_CATEGORIE:$('#ID_CATEGORIE').val(),
                                DAYS:$('#DAYS').val(),
                                 IS_ANNULE:$('#IS_ANNULE').val(),
                                
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
             enabled: true,
             format: '{point.y:,f} '
         },
         showInLegend: false
     }
 },
                    credits: {
              enabled: true,
              href: "",
              text: "MEDIABOX"
      },
  
    series: [<?= $donne ?>]
  });
</script>

</html>