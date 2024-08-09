


<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>



<style type="text/css">
.hidden {
    display: none;
}

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
            <div class="form-group col-md-6"><h4 style='color:blue'>Rapport annuel</h4></div>
            <div class="form-group col-md-3">
                    <label  style='color:blue'>agences</label>
                    <select class="form-control input-sm" name="ID_AGENCE" id="ID_AGENCE" onchange='get_rapport()'>
                      <option value="">agences</option>
                      <?php foreach ($agences as $key) { ?>
                        <option value="<?php echo $key['ID_AGENCE'] ?>"><?php echo  $key['DESCRIPTION'] ?></option>
                      <?php } ?>
                    </select>
                </div>
               
            <div class="form-group col-md-3">
                  <label  style='color:blue'>Avant  ou  après midi</label>
                  <select class="form-control input-sm" name="avant" id="avant" onchange='get_rapport()'>
                      <option value="">Avant  ou  après midi</option>
                      <option value="AM">Avant  midi </option>
                      <option value="PM">Après midi</option>
                      
                    </select>

            </div>
   
            
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->


        
        <div class="row">
 
 <div class="col-md-12" style="margin-bottom: 20px"></div>       
 <div id="container"  class="col-md-12" ></div>
 <div class="col-md-12" style="margin-bottom: 20px"></div>
  <div id="container1"  class="col-md-12" ></div>
 <div class="col-md-12" style="margin-bottom: 20px"></div>
 <div id="container2"  class="col-md-12 " ></div>
 
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
                  <th>NOM </th>
                  <th> PRENOM</th>
                  <th>EMAIL</th>
                  <th>TELEPHONE</th>
                  <th>AGENCE</th>
                  <th>DATE PRESENCE</th>
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
 
<div class="modal fade" id="myModala" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content  modal-lg">
      <div class="modal-header">
        <h4 class="modal-title"><span id="titrea"></span></h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id='mytablea' class='table table-bordered table-striped table-hover table-condensed' >
          <thead>
                   <th>#</th>
                  <th>NOM </th>
                  <th> PRENOM</th>
                  <th>EMAIL</th>
                  <th>TELEPHONE</th>
                  <th>AGENCE</th>
                  <th>DATE ABSANT</th>
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
<div id="nouveau1">
    </div>


</div>





<?php include VIEWPATH.'templates/footer.php'; ?>
</body>
</html>


<script type="text/javascript">
$( document ).ready(function() {
get_rapport();
});   

function get_i() {

$('#jour').html('');
$('#heure').html('');
get_rapport();
  
}

function get_m() {

$('#heure').html('');
get_rapport();

}

function get_rapport(){
var agence=$('#ID_AGENCE').val()
var avant=$('#avant').val();
$.ajax({
url : "<?=base_url()?>dashboard/Dashboard_annuel/get_rapport_user",
type : "POST",
dataType: "JSON",
cache:false,
data:{
agence:agence,
avant:avant
},
success:function(data){   
  $('#container').html("");             
$('#nouveau').html(data.rapp );
$('#container1').html("");             
$('#nouveau1').html(data.rapp_absent);
},            

});  
}
</script> 


