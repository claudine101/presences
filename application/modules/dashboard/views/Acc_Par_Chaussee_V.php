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
            <form id="myForm" method="post" action="<?=base_url('dashboard/Acc_Par_Chaussee/index')?>">
                      <div class="row"> 
                       <div class="form-group col-md-3">

                          <label>GRAVITE</label>
                           
                  <select class="form-control" onchange="rapport_king()" name="ID_TYPE_GRAVITE" id="ID_TYPE_GRAVITE" >
                            <option value="">Sélectionner</option>
                            <?php
                                
                            foreach ($gravite as $value){
                                if ($value['ID_TYPE_GRAVITE'] == set_value('ID_TYPE_GRAVITE'))
                                    {?>
                                    <option value="<?=$value['ID_TYPE_GRAVITE']?>" selected><?=$value['gravite']?></option>
                                <?php } else{ ?>
                                    <option value="<?=$value['ID_TYPE_GRAVITE']?>"><?=$value['gravite']?></option>
                                <?php } 
                              } ?>
                        </select>
                </div> 





               <div class="form-group col-md-3">

                          <label>DATE</label>
                           
                  <select class="form-control" onchange="rapport_king()" name="date_insert" id="date_insert" >
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
                     <th>CHAUSSE</th>
                     <th>PLAQUE</th>
                     <th>TYPE ACIDDENT</th>

                     <th>VALIDATION</th>

                      <th>DESCRIPTION</th>
                    
                     <th>DATE D'INSERTION</th>
                                    
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

                      
  <div  id="container" style="border: 1px solid #d2d7db;"></div>
                       
                      
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

<script  type="text/javascript">
function rapport_king()
{
  myForm.submit();
} 
</script>


   <script>
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: '<b>Nombre d\'accident par chaussée </b><br>Total=(<?=$nombre?>)'
    },

     subtitle: {
    text:''
  },
    xAxis: {
        type: 'category'
    },

           plotOptions: {  
       column: {
       cursor:'pointer',
       depth: 25,
                        point:{
                            events: {
                                click: function()
         {
                              $("#titre").html("Liste des cas");

                              $("#myModal2").modal();

                           

                              var row_count ="1000000";
                              $("#mytable2").DataTable({
                                "processing":true,
                                "serverSide":true,
                                "bDestroy": true,
                                "oreder":[],
                                "ajax":{
                                  url:"<?=base_url('dashboard/Acc_Par_Chaussee/detailChausse')?>",
                                  type:"POST",
                                  data:{
                                   key:this.key,
                                   gravite: $('#ID_TYPE_GRAVITE').val()
                                   
                                  
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
                                  "sLengthMenu":     "Afficher MENU &eacute;l&eacute;ments",
                                  "sInfo":           "Affichage de l'&eacute;l&eacute;ment START &agrave; END sur TOTAL &eacute;l&eacute;ments",
                                  "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                                  "sInfoFiltered":   "(filtr&eacute; de MAX &eacute;l&eacute;ments au total)",
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
        name: 'Chaussée',
        color: '#1E90FF',
        data: [<?=$donne?>]
    }]
});
   </script>
   

   </html>