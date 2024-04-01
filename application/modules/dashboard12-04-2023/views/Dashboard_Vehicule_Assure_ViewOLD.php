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


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
         <div class="col-sm-6 p-md-0">
 <div class="welcome-text">
    

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
<div class="form-group col-md-4"><h5 style='color:#FFFFFF'>Tableau de bord des assurances</h5></div>
<div class="form-group col-md-2">
 
<label style='color:#FFFFFF'>Assurance</label>
<select class="form-control"  onchange="get_rapport()" name="ID_ASSUREUR" id="ID_ASSUREUR">
       <option value="">Sélectionner</option>
<?php

foreach ($assurence as $value){

if (($this->session->userdata('PROFIL_ID') == 2) && ($value['ID_ASSUREUR'] == $this->session->userdata('ID_INSTITUTION'))) { ?>

<option value="<?=$value['ID_ASSUREUR']?>" selected><?=$value['ASSURANCE']?></option>
<?php } else{ 
 ?>
<option value="<?=$value['ID_ASSUREUR']?>" ><?=$value['ASSURANCE']?></option>
<?php } } ?>
      </select>
    </div>
    <div class="form-group col-md-1">
<label style='color:#FFFFFF'>Année</label>
<select class="form-control"  onchange="change_date_mois();change_date_mois_fin();get_i()" name="mois" id="mois">
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
<select class="form-control"  name="jour" id="jour" onchange="change_date_mois();change_date_mois_fin();get_rapport();change_date_arrivale(this.value);">
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
      <label style='color:#FFFFFF'>Du</label>
        <input type="date" id="DATE1" onchange="change_date_mois_fin();get_rapport();change_date_arrival(this.value)" name="DATE1" class="form-control" value=" ">         
                    </div>
        <div class="form-group col-md-2">
        <label style='color:#FFFFFF'>Au</label>
        <input type="date" id="DATE2" name="DATE2" onchange="get_rapport();change_date_depart(this.value)"  class="form-control" value=" " >
                    </div>


     </div>
   </div>
  </div>
 </div>
</div>

<div class="row">
 
      <div class="col-md-12" style="margin-bottom: 20px"></div>       
  <div id="container"  class="col-md-12" ></div>
  <div id="container1"  class="col-md-6" ></div>
  <div class="col-md-12" style="margin-bottom: 20px"></div>
  <div id="container2"  class="col-md-12" ></div>
  <div class="col-md-12" style="margin-bottom: 20px"></div>
  
</div>
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
                <table id='mytable' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
                  <thead>
                  <th>#</th>

                <th>NUMERO_PLAQUE</th>   
               <th>PROPRIETAIRE</th>
               <th>ASSUREUR</th>
               <th>TYPE_ASSURANCE</th>
               <th>PLACES</th>
               <th>DATE_DEBUT</th>
               <th>DATE_VALIDITE</th>
               <th>NUMERO_ASSURANCE</th>
               <th>DATE_INSERTION</th>
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

var mois=$('#mois').val();
var jour=$('#jour').val();
var heure=$('#heure').val();
var DATE1=$('#DATE1').val();
var DATE2=$('#DATE2').val();
var ID_ASSUREUR=$('#ID_ASSUREUR').val();
$.ajax({
url : "<?=base_url()?>dashboard/Dashboard_Vehecule_Assure/get_rapport",
type : "POST",
dataType: "JSON",
cache:false,
data:{
mois:mois,
jour:jour,
DATE1:DATE1,
DATE2:DATE2,
heure:heure,
ID_ASSUREUR:ID_ASSUREUR,
 
},
success:function(data){   
$('#container').html("");             
$('#nouveau').html(data.rapp );
$('#jour').html(data.select_month);
$('#heure').html(data.selectjour);
},            

});  
}

</script> 

<script type="text/javascript">  
      function change_date_arrival()
      {  
          // var formDate=new Date($('#jour').val());

          var formDate=new Date($('#DATE1').val());
          var dd=formDate.getDate()+1;
          var mm=formDate.getMonth()+1;
          var hours =formDate.getHours();  
          var minutes =formDate.getMinutes();
          var yyyy=formDate.getFullYear();
           var jourfin ='28';

         if (dd<10) 
         {
           day='0'+dd;
         }else{
           day=dd;
         }

         if (mm<10) 
         {
          month='0'+mm;
         }else{
          month=mm;
         }

         if (hours<10)
           {
            hours='0'+hours;
           }
           
           if (minutes<10) 
           {
            minutes='0'+minutes;
           }

if (month=='01' || month=='03' ||month=='05' ||month=='07' ||month=='08' ||month=='10' ||month=='12' ) {
var jourfin ='31';
}else if(month=='02' || month=='04' ||month=='06' ||month=='09' ||month=='11'){
var jourfin ='30';
}
         
          var arrival_date = yyyy+'-'+month+'-'+day;
          var arrival_fine = yyyy+'-'+month+'-'+jourfin;
        //alert(arrival_date);
        document.getElementById("DATE2").setAttribute("min",arrival_date);
        document.getElementById("DATE2").setAttribute("max",arrival_fine);
        $('#DATE2').val('');

      }
     

            function change_date_arrivale()
      {  
          // var formDate=new Date($('#jour').val());
          var formDate=new Date($('#jour').val());
          var dd=formDate.getDate();
          var mm=formDate.getMonth()+1;
          var hours =formDate.getHours();  
          var minutes =formDate.getMinutes();
          var yyyy=formDate.getFullYear();
          var jourfin ='28';
         if (dd<10) 
         {
           day='0'+dd;
         }else{
           day=dd;
         }

         if (mm<10) 
         {
          month='0'+mm;
         }else{
          month=mm;
         }

         if (hours<10)
           {
            hours='0'+hours;
           }
           
           if (minutes<10) 
           {
            minutes='0'+minutes;
           }
if (month=='01' || month=='03' ||month=='05' ||month=='07' ||month=='08' ||month=='10' ||month=='12' ) {
var jourfin ='31';
}else if(month=='02' || month=='04' ||month=='06' ||month=='09' ||month=='11'){
var jourfin ='30';
}

         
          var arrival_date = yyyy+'-'+month+'-'+day;
           var arrival_fine = yyyy+'-'+month+'-'+jourfin;
        //alert(arrival_date);
        document.getElementById("DATE1").setAttribute("min",arrival_date);
        document.getElementById("DATE1").setAttribute("max",arrival_fine);
        $('#DATE1').val('');

      }
        function change_date_mois()
      {  
          
          var arrival_mois ='';
        document.getElementById("DATE1").setAttribute("value",arrival_mois);
        document.getElementById("DATE1").setAttribute("min",arrival_mois);
        document.getElementById("DATE1").setAttribute("max",arrival_mois);
        $('#DATE1').val('');

      }
      function change_date_mois_fin()
      {  

          var arrival_mois ='';
        document.getElementById("DATE2").setAttribute("value",arrival_mois);
        document.getElementById("DATE2").setAttribute("max",arrival_mois);
        document.getElementById("DATE2").setAttribute("min",arrival_mois);
        $('#DATE2').val('');

      }

    </script>