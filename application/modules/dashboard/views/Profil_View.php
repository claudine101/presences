


<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>



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

  a
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
            <div class="col-sm-2">
             
            </div><!-- /.col -->
            <div class="col-sm-8">
              <div class="row">
              
             
                    
                    
                    </div>
            </div><!-- /.col -->
            <div class="form-group col-md-6"><h4 style='color:blue'>Mes Ponctualités</h4></div>
          <div class="form-group col-md-3"></div>
            <div class="col-sm-2 text-right">
              <span style="margin-right: 15px">
                <div class="col-sm-3" style="float:right;">
                <?php 
                $currentHour = (int)date('H');
                 if (($currentHour >= 12 && $nbre == 1) || $nbre == 0) { ?>
               <a class = 'btn btn-info btn-sm' id='<?= $data['ID_UTILISATEUR'] ?>'  title='<?= $data['NOM_EMPLOYE'] ?>'  onclick='presenter("<?= $data['ID_UTILISATEUR'] ?>",this.title,this.id)' style='float:right'>
                    <i class="nav-icon fas fa-plus"></i>
                    Presenter 
                  </a>
                  <?php }?>
                </div>
               
              </span>

            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->


        
<div class="row">
 
 <div class="col-md-12" style="margin-bottom: 20px"></div>       
<div id="container"  class="col-md-12" ></div>
<div class="col-md-12" style="margin-bottom: 20px"></div>

</div>
</div>
</div>


<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content  modal-lg">
      <div class="modal-header">
        <h4 class="modal-title"><span id="titre"></span></h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id='mytable' class='table table-bordered table-striped table-hover table-condensed' >
            <thead>
             <th>#</th>
            <th>DATE </th>
            <th> STATUT</th>
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
</div></div></div>
<div id="nouveau">
</div>


</div>





<?php include VIEWPATH.'templates/footer.php'; ?>
</body>
</html>


<script type="text/javascript">
$( document ).ready(function() {
get_rapport();
// alert();
});   

function get_rapport(){
var agence=$('#ID_AGENCE').val()
$.ajax({
url : "<?=base_url()?>dashboard/Dashboard_hebdomadaires/get_rapport_user",
type : "POST",
dataType: "JSON",
cache:false,
data:{

agence:agence

},
success:function(data){   
$('#container').html("");             
$('#nouveau').html(data.rapp );

},            

});  
}


function presenter(id,nom=null,prenom=null){
Swal.fire({
title: 'Souhaitez-vous presenter  '+nom,
showDenyButton: true,
confirmButtonText: 'Maintenant',
denyButtonText: `Pas maintenant`,
}).then((result) => {
/* Read more about isConfirmed, isDenied below */
if (result.isConfirmed) {
/* Debut ajax*/
   $.ajax({
    url : "<?=base_url()?>dashboard/Dashboard_hebdomadaires/presenter/"+id,
    type : "PUT",
    dataType: "JSON",
    cache:false,
    data: {},
    beforeSend:function () { 
    },
    success:function(data) {
      console.log(data);
      liste()
      Swal.fire('Confirmé!', '', 'success')
    },
    error:function() {
      Swal.fire('Erreur de la connexion', '', 'info')
    }
});

  
} else if (result.isDenied) {
  Swal.fire('Non Confirmé', '', 'info')
}
})


//Fin ajax

}

</script> 
