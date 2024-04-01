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
}
</style>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include VIEWPATH.'templates/navbar.php'; ?>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include VIEWPATH.'templates/sidebar.php'; ?>
 <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
         <div class="col-sm-6 p-md-0">
 <div class="welcome-text">
    <h4 style='color:#FFFFFF'>Contrôle rapide</h4>

     </div>
    </div>
       </div><!-- /.container-fluid -->
     </div>
     <!-- /.content-header -->
<div class="col-md-12 col-xl-12 grid-margin stretch-card">
<div class="row column1">
  <div class="col-md-12">
   <div class="white_shd full margin_bottom_10">
    <div class="full graph_head">
      <div class="row" style="margin-top: 0px">
<div class="form-group col-md-2">
 
<label style='color:#FFFFFF'>Catégories</label>
<select class="form-control"  onchange="get_rapport()" name="ID_CATEGORIE" id="ID_CATEGORIE">
       <option value="">Sélectionner</option>
<?php

foreach ($categorie as $value){
if ($value['ID_CATEGORIE'] == set_value('ID_CATEGORIE'))
{?>
<option value="<?=$value['ID_CATEGORIE']?>" selected><?=$value['DESCRIPTION']?></option>
<?php } else{ 
 ?>
<option value="<?=$value['ID_CATEGORIE']?>" ><?=$value['DESCRIPTION']?></option>
<?php } } ?>
      </select>
    </div>
 <div class="form-group col-md-1">

<label style='color:#FFFFFF'>Année</label>
<select class="form-control"  onchange="get_i()" name="mois" id="mois">
       <option value="">Sélectionner</option>
<?php

foreach ($dattes as $value){
if ($value['mois'] == set_value('mois'))
{?>
<option value="<?=$value['mois']?>" selected><?=$value['mois']?></option>
<?php } else{ 
 ?>
<option value="<?=$value['mois']?>" ><?=$value['mois']?></option>
<?php } } ?>
      </select>
    </div>

<div class="form-group col-md-1"> 
    
    <label style='color:#FFFFFF'>Mois</label>
<select class="form-control"  onchange="get_m()" name="jour" id="jour">
 <option value=""> Sélectionner </option> 
<?php

foreach ($datte as $value){
if ($value['jour'] == set_value('jour'))
{?>
<option value="<?=$value['jour']?>" selected><?=$value['jour']?></option>
<?php } else{ 
 ?>
<option value="<?=$value['jour']?>" ><?=$value['jour']?></option>
<?php } } ?>
      </select>
    </div>
    <div class="form-group col-md-2"> 
    
    <label style='color:#FFFFFF'>Jours</label>
<select class="form-control"  onchange="get_rapport()" name="heure" id="heure">
 <option value=""> Sélectionner </option> 
<?php

foreach ($datte as $value){
if ($value['jour'] == set_value('jour'))
{?>
<option value="<?=$value['jour']?>" selected><?=$value['jour']?></option>
<?php } else{ 
 ?>
<option value="<?=$value['jour']?>" ><?=$value['jour']?></option>
<?php } } ?>
      </select>
    </div>


<div class="form-group col-md-2">
 
 <label style='color:#FFFFFF'>Numéro plaque</label>
    <div class="input-group mb-3">
     <input type="text" class="form-control" name="NUMERO_PLAQUE"  id="NUMERO_PLAQUE"  placeholder="Recherche" value="<?=set_value('NUMERO_PLAQUE')?>">
    <div class="input-group-prepend">
    <span class="input-group-text"><a href="#" onclick="get_rapport()"><i class="fa fa-search" aria-hidden="true"></i></a></span>
    </div>
     </div>
</div>
<div class="form-group col-md-2">
 
 <label style='color:#FFFFFF'>Numéro permis</label>
    <div class="input-group mb-3">
             <input type="text" class="form-control " name="NUMERO_PERMIS"  id="NUMERO_PERMIS"  placeholder="Recherche" value="<?=set_value('NUMERO_PERMIS')?>">
                <div class="input-group-prepend">
            <span class="input-group-text"><a href="#" onclick="get_rapport()"><i class="fa fa-search" aria-hidden="true"></i></a></span>
                             </div>
                            </div>
                     </div>
<div class="form-group col-md-2">
<label style='color:#FFFFFF'>Paiement</label>
<select class="form-control"  onchange="get_rapport()" name="IS_PAID" id="IS_PAID">
       <option value="">Sélectionner</option>

        <option value="1">Payée</option>
       <option value="0">Non payée</option>

      </select>
    </div>

     


     </div>
   </div>
  </div>
 </div>
</div>


<div class="row">
 
 <div class="col-md-12" style="margin-bottom: 20px"></div>       
  <div id="container"  class="col-md-6"  ></div>
  <div id="container0"  class="col-md-6"  ></div>
  <div class="col-md-12" style="margin-bottom: 20px"></div>
  <div id="container1"  class="col-md-6"  ></div>
  <div id="container2"  class="col-md-6"  ></div>
  <div class="col-md-12" style="margin-bottom: 20px"></div>
  <div id="container3"  class="col-md-6"  ></div>
  <div id="container4"  class="col-md-6"  ></div>
  <div class="col-md-12" style="margin-bottom: 20px"></div>
  
</div>
</div>
</div>


<div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg" style ="width:1000px">
          <div class="modal-content  modal-lg">
            <div class="modal-header">
              <h4 class="modal-title"><span id="titre"></span></h4>
            </div>
            <div class="modal-body">
              <div class="table-responsive">
                <table id='mytable' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
                  <thead>
                      <th>#</th>
               <th>NUMERO_PLAQUE</th>
               <th>NUMERO_PERMIS</th>
               <th>POLICIER</th>
               <th>NUMERO_MATRICULE</th>
               <th>LIEU_EXACTE</th>
               <th>MONTANT</th>
               <th>DATTE_FIN</th>
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
<div id="nouveau2">
</div>
<div id="nouveau3">
</div>
<div id="nouveau4">
</div>
<div id="nouveau0">
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
function get_i() {

    $('#jour').html('');
    $('#heure').html('');
    get_rapport();
   
}
</script>
<script type="text/javascript">
    
function get_m() {

    $('#heure').html('');
    get_rapport();
   
}
</script>

<script> 
function get_rapport(){ 

var NUMERO_PLAQUE=$('#NUMERO_PLAQUE').val();
var NUMERO_PERMIS=$('#NUMERO_PERMIS').val();
var mois=$('#mois').val();  
var jour=$('#jour').val();
var heure=$('#heure').val();  
var IS_PAID=$('#IS_PAID').val();
var ID_CATEGORIE=$('#ID_CATEGORIE').val();





$.ajax({
url : "<?=base_url()?>dashboard/Dashbord_Controle_Rapide/get_rapport",
type : "POST",
dataType: "JSON",
cache:false,
data:{
NUMERO_PLAQUE:NUMERO_PLAQUE,
NUMERO_PERMIS:NUMERO_PERMIS,  
mois:mois,
jour:jour,  
heure:heure,
IS_PAID:IS_PAID,
ID_CATEGORIE:ID_CATEGORIE,
 
},
success:function(data){   
$('#container').html("");             
$('#nouveau').html(data.rapp );
$('#container0').html("");             
$('#nouveau0').html(data.rapp0 );
$('#container4').html("");             
$('#nouveau4').html(data.rapp4 );
$('#container1').html("");             
$('#nouveau1').html(data.rapp1 );
$('#container2').html("");             
$('#nouveau2').html(data.rapp2 );
$('#container3').html("");             
$('#nouveau3').html(data.rapp3 );
$('#jour').html(data.select_month);
$('#heure').html(data.selectjour);
},            

});  
}

</script> 