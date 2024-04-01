<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php'; ?>



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
  }a
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
            <div class="col-sm-8">
             <h4 class="m-0"><?=$title?></h4>
           </div><!-- /.col -->


           <div class="col-sm-4 text-right">


            <span style="margin-right: 15px">
              <div class="row">
                <div class="col-sm-6" style="float:right;">
                 <!--  <a href="javascript:void()" style="width: 100px;" class='btn btn-primary btn-sm float-right' data-toggle="modal" data-target="#import_excel">
                    <i class="nav-icon fas fa-book"></i>
                    EXCEL
                  </a> -->
                </div>
                <div class="col-sm-6" style="float:right;">
                  <a href="<?=base_url('ihm/publicites/ajouter')?>" style="width: 100px;" class='btn btn-primary btn-sm float-right'>
                    <i class="nav-icon fas fa-plus"></i>
                    Nouveau
                  </a>
                </div>
              </div>
            </span>

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->


      <!-- /.content-header -->

      <!-- Main content -->
    <section class="content">
        <div class="col-md-12 col-xl-12 grid-margin stretch-card">

          <div class="card">
            <div class="card-body">
              
            <div class="col-md-4">

            <label>Restaurant</label>
              <select class="form-control " name="ID_RESTAURANT" id="ID_RESTAURANT" onchange='liste()'> 
              <option value="">Sélectionner</option>

                 <?php foreach ($restaurants as $key) { ?>
          
                    <option value="<?php echo $key['ID_RESTAURANT']?>"><?php echo $key['NOM_RESTAURANT']?></option>
    
                <?php } ?>


                  </select>
                </div>


            </div>

          </div>

   

          <div class="card">
            <div class="card-body">
              
            <div class="col-md-12">

        
                <?=  $this->session->flashdata('message');?>

           

                <div class="table-responsive">
                  <table id='reponse1' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        
                       
                        <td>Bannière</td>
                        <td>Publicitaire</td>
                        <td>Link</td>
                        <td>OPTIONS</td>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>


              <!--  VOS CODE ICI  -->



            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>          
</div>


</section>


<!-- /.content -->
</div>

</div>
</div>

<!-- ./wrapper -->
<?php include VIEWPATH.'templates/footer.php'; ?>
</body>
</html>


<!-- #####<! modal pour l'importation du fichier excel  >####### -->




<script type="text/javascript">
 $(document).ready(function(){
  liste();

});
</script>

<script type="text/javascript">
  function liste() 
  {  
    var ID_RESTAURANT=$('#ID_RESTAURANT').val()
    $('#message').delay('slow').fadeOut(3000);

    $("#reponse1").DataTable({
      "destroy" : true,
      "processing":true,
      "serverSide":true,
      "oreder":[],
      "ajax":{
        url: "<?php echo base_url('ihm/Publicites/listing/');?>", 
        type:"POST",
        data : { resto:ID_RESTAURANT  },
        beforeSend : function() {
        }
      },
      lengthMenu: [[10,50, 100, -1], [10,50, 100, "All"]],
      pageLength: 10,
      "columnDefs":[{
        "targets":[],
        "orderable":false
      }],
      dom: 'Bfrtlip',
      buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print'  ],
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
</script>

