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
             


              <form action="<?=base_url('dashboard/Dashboard_Controles_Tech')?>" method='POST' name="myform" id="myform">
                <div class="row">
                 <div class="col-md-4">

                    <label>ANNEE</label>

                    <select class="form-control" name="ANNEE" id="ANNEE" onchange="submit()" onchange='year()'>
                      <option value="">Sélectionner</option>
                      <?php 
                      foreach ($year as $key_annee)
                      { 
                        if ($key_annee['ANNEE']==set_value('ANNEE'))
                          { ?>
                            <option value="<?=$key_annee['ANNEE'] ?>"selected=''><?=$key_annee['ANNEE'] ?></option>
                          <?php }else
                          { ?>
                            <option value="<?=$key_annee['ANNEE'] ?>"><?=$key_annee['ANNEE'] ?></option>
                          <?php }
                        } ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label>MOIS</label>
                      <select class="form-control" name="MOIS" id="MOIS" onchange="submit()" onchange='month()'>
                        <option value="">Sélectionner</option>
                        <?php 
                        foreach ($month as $key_mois)
                        { 

                          if ($key_mois['MOIS']==set_value('MOIS'))
                            { ?>
                              <option value="<?=$key_mois['MOIS'] ?>"selected=''><?=$key_mois['MOIS'] ?></option>
                            <?php }else
                            {?>
                              <option value="<?=$key_mois['MOIS'] ?>"><?=$key_mois['MOIS'] ?></option>
                            <?php }
                          }?>
                        </select>
                      </div>

                          <div class="col-md-4">
                      <label>JOUR</label>
                      <select class="form-control" name="DAYS" id="DAYS" onchange="submit()" onchange='month()'>
                        <option value="">Sélectionner</option>
                        <?php 
                        foreach ($jour as $key_jour)
                        { 

                          if ($key_jour['DAYS']==set_value('DAYS'))
                            { ?>
                              <option value="<?=$key_jour['DAYS'] ?>"selected=''><?=$key_jour['DAYS'] ?></option>
                            <?php }else
                            {?>
                              <option value="<?=$key_jour['DAYS'] ?>"><?=$key_jour['DAYS'] ?></option>
                            <?php }
                          }?>
                        </select>
                      </div>

                    </div>
                  </form>





 



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
                      
  <div class="col-md-6" id="container" style="border: 1px solid #d2d7db;"></div>
  <div class="col-md-6" id="container1" style="border: 1px solid #d2d7db;"></div>
  
 

                      
                      
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
     
// Set up the chart
Highcharts.chart('container', {
    chart: {
        type: 'lollipop'
    },
    title: {
        text: '<b>Infractions enregistrées</b><br/><?=$nombre2?> cas en Controles techniques'
    },
    subtitle: {
        text: ''
    },
      credits: {
              enabled: true,
              href: "",
              text: "MEDIABOX"
      },

    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Nbre de cas par infraction'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'infractions'
    },


       credits: {
              enabled: true,
              href: "",
              text: "MEDIABOX"
      },
     plotOptions: {  
        lollipop: {
       cursor:'pointer',
       depth: 25,
                        point:{
                            events: {
                                click: function()
         {
                             //alert(this.key);

                              $("#titre").html("Liste des commandes");

                              $("#myModal2").modal();


                              var row_count ="1000000";
                              $("#mytable2").DataTable({
                                "processing":true,
                                "serverSide":true,
                                "bDestroy": true,
                                "oreder":[],
                                "ajax":{
                                  url:"<?=base_url('dashboard/Dashboard_Controles_Tech/detailControle')?>",
                                  type:"POST",
                                  data:{
                                    key:this.key,
                              
                                    
                                   ANNEE:$('#ANNEE').val(),
                                    MOIS:$('#MOIS').val(),
                                    DAYS:$('#DAYS').val(),
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
            showInLegend: true
        }
    },
 
    series: [{
        name: 'Menu',
        color: '#800000',
         data: [<?=$donnees2?>],
       
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
              
   </script>






 <script type="text/javascript">
     
// Set up the chart
Highcharts.chart('container1', {
    chart: {
        type: 'lollipop'
    },
    title: {
        text: '<b>Infractions enregistrées</b><br/><?=$nombre3?> cas en Assurrances'
    },
    subtitle: {
        text: ''
    },
      credits: {
              enabled: true,
              href: "",
              text: "MEDIABOX"
      },

    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Nbre de cas par infraction'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'infractions'
    },


       credits: {
              enabled: true,
              href: "",
              text: "MEDIABOX"
      },
     plotOptions: {  
        lollipop: {
       cursor:'pointer',
       depth: 25,
                        point:{
                            events: {
                                click: function()
         {
                           //  alert(this.key);

                              $("#titre").html("Liste des commandes");

                              $("#myModal3").modal();


                              var row_count ="1000000";
                              $("#mytable3").DataTable({
                                "processing":true,
                                "serverSide":true,
                                "bDestroy": true,
                                "oreder":[],
                                "ajax":{
                                  url:"<?=base_url('dashboard/Dashboard_Controles_Tech/detailAssurance')?>",
                                  type:"POST",
                                  data:{
                                    key:this.key,
                              
                                    
                                   ANNEE:$('#ANNEE').val(),
                                    MOIS:$('#MOIS').val(),
                                    DAYS:$('#DAYS').val(),
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
            showInLegend: true
        }
    },
 
    series: [{
        name: 'Menu',
        color: '#800000',
         data: [<?=$donnees3?>],
       
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
              
   </script>


   <script type="text/javascript">
     
// Set up the chart
Highcharts.chart('container', {
    chart: {
        type: 'lollipop'
    },
    title: {
        text: '<b>Infractions enregistrées</b><br/><?=$nombre2?> cas en Controles techniques'
    },
    subtitle: {
        text: ''
    },
      credits: {
              enabled: true,
              href: "",
              text: "MEDIABOX"
      },

    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Nbre de cas par infraction'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'infractions'
    },


       credits: {
              enabled: true,
              href: "",
              text: "MEDIABOX"
      },
     plotOptions: {  
        lollipop: {
       cursor:'pointer',
       depth: 25,
                        point:{
                            events: {
                                click: function()
         {
                             //alert(this.key);

                              $("#titre").html("Liste des commandes");

                              $("#myModal2").modal();


                              var row_count ="1000000";
                              $("#mytable2").DataTable({
                                "processing":true,
                                "serverSide":true,
                                "bDestroy": true,
                                "oreder":[],
                                "ajax":{
                                  url:"<?=base_url('dashboard/Dashboard_Controles_Tech/detailControle')?>",
                                  type:"POST",
                                  data:{
                                    key:this.key,
                              
                                    
                                   ANNEE:$('#ANNEE').val(),
                                    MOIS:$('#MOIS').val(),
                                    DAYS:$('#DAYS').val(),
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
            showInLegend: true
        }
    },
 
    series: [{
        name: 'Menu',
        color: '#800000',
         data: [<?=$donnees2?>],
       
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
              
   </script>


   

   </html>