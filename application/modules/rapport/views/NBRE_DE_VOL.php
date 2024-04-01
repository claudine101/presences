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
        <form id="myForm" method="post" action="<?=base_url('rapport/NBRE_DE_VOL/index')?>">
          
        <div class="row">
         
            
        <div class="form-group col-md-6 ">
       
                             <label>DATE</label>
                           
                  <select class="form-control" onchange="date_vol()" name="date_insert" id="date_insert" >
                            <option value="">Sélectionner</option>
                            <?php
                                
                            foreach ($date as $value){
                                if ($value['date_insert'] == set_value('date_insert'))
                                    {?>
                                    <option value="<?=$value['date_insert']?>" selected><?=$value['date_insert']?></option>
                                <?php } else{ ?>
                                    <option value="<?=$value['date_insert']?>"><?=$value['date_insert']?></option>
                                <?php } 
                              } ?>
                        </select>
                </div>

                 <div class="form-group col-md-6" >
           
          
               <label>STATUT</label>
                           
                  <select class="form-control" onchange="statut_vol()" name="STATUT" id="STATUT" >
                            <option value="">Sélectionner</option>
                            <?php
                                
                            foreach ($statut as $value){
                                if ($value['STATUT'] == set_value('STATUT'))
                                    {?>
                                    <option value="<?=$value['STATUT']?>" selected><?=$value['Statut']?></option>
                                <?php } else{ ?>
                                    <option value="<?=$value['STATUT']?>"><?=$value['Statut']?></option>
                                <?php } 
                              } ?>
                        </select>
                        </div> 
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
                     <th>DATE_INSERTION</th>
                     <th>COULEUR</th>
                     <th>NUMERO_PLAQUE</th>
                     <th>NOM</th>
                     <th>VALIDATION</th>
                     <th>NUMERO_SERIE</th>
                     <th>DATE_VOLER</th>
                                               
                         
                                      
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
                    <h4 class="modal-title"><span id="titre2"></span></h4>
                  </div>
                  <div class="modal-body">
                    <div class="table-responsive">
                      <table id='mytable3' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
                        <thead>
                         <tr>
                          <th>#</th>
                          <th>STATUT</th>
                          <th>DATE_INSERTION</th>
                          <th>COULEUR</th>
                          <th>NUMERO_PLAQUE</th>
                          <th>NOM</th>
                          <th>NUMERO_SERIE</th>
                          <th>DATE_VOLER</th>

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
                      
  <div class="col-md-6" id="container" style="border: 4px  #d2d7db;"></div>
  <div class="col-md-6" id="container1" style="border: 4px  #d2d7db;"></div>


                       
                      
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
  function date_vol()
  {
    myForm.submit();
  }

</script>



   <script>    
// Set up the chart
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: '<b>VALIDATION (<?=$nombre?>) </b><br/> validation enregistrer'
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
                fontSize: '10px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'NBRE DE VALIDATION'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'VALIDATION'
    },


       credits: {
              enabled: true,
              href: "",
              text: "MEDIABOX"
      },
     plotOptions: {  
        column: {
       cursor:'pointer',
       depth: 25,
                        point:{
                            events: {
                                click: function(e)
         {
          
   
                           //alert(this.key);

                              $("#titre").html("Liste d'immatriculation");

                              $("#myModal2").modal();
                              
        
                              var row_count ="1000000";
                              $("#mytable2").DataTable({
                                "processing":true,
                                "serverSide":true,
                                "bDestroy": true,
                                "oreder":[],
                                "ajax":{
  url: "<?=base_url('Rapport/NBRE_DE_VOL/detailVal')?>",
                                  type:"POST",
                                  data:{
                                    key:this.key,
                                    date_insert:$('#date_insert').val(), 
                                    
                              
                                   //  MOIS:$('#MOIS').val(),
                                   //  DAYS:$('#DAYS').val(),
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
        color: 'green',
         data: [<?=$donne?>],
       
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
  function statut_vol()
  {
    myForm.submit();
  }

</script>

    <script>    
// Set up the chart
Highcharts.chart('container1', {
    chart: {
        type: 'column'
    },
    title: {
        text: '<b>STATUT (<?=$nombre1?>)</b></br> </b>status enregistrer'
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
                fontSize: '10px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'NBRE DE STATUT'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'STATUT'
    },


       credits: {
              enabled: true,
              href: "",
              text: "MEDIABOX"
      },
     plotOptions: {  
        column: {
       cursor:'pointer',
       depth: 25,
                        point:{
                            events: {
                                click: function(e)
         {
          
   
                           //alert(this.key);

                              $("#titre").html("Liste d'immatriculation");

                              $("#myModal3").modal();
                              
        
                              var row_count ="1000000";
                              $("#mytable3").DataTable({
                                "processing":true,
                                "serverSide":true,
                                "bDestroy": true,
                                "oreder":[],
                                "ajax":{
                          url: "<?=base_url('Rapport/NBRE_DE_VOL/detailStatut')?>",
                                  type:"POST",
                                  data:{
                                    key:this.key,
                                    STATUT:$('#STATUT').val(), 
                                    
                              
                                   //  MOIS:$('#MOIS').val(),
                                   //  DAYS:$('#DAYS').val(),
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
        color: 'blue',
         data: [<?=$donne1?>],
       
     
    }]
});
   </script>

   </html>