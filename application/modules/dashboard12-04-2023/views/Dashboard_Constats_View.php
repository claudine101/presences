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


#container {
    height: 400px;
}

.highcharts-figure,
.highcharts-data-table table {
    min-width: 310px;
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
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
   <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>


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

   

 <div class="form-group col-md-4"> 
  <h4 style='color:#FFFFFF'>Tableau de bord des constats</h4>
  </div>
 <div class="form-group col-md-2">
<label style='color:#FFFFFF'>Année</label>
<select class="form-control"  onchange="change_date_mois();change_date_mois_fin();get_i();get_rapport2();" name="mois" id="mois">

<?php
  if (empty($anneesonne['ANNh'])) {
   echo "<option value='".date('Y')."'>".date('Y')."</option>";
        }else{
                             
        }  
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

<div class="form-group col-md-2">
<label style='color:#FFFFFF'>Mois</label> 
<select class="form-control"  name="jour" id="jour" onchange="change_date_mois();change_date_mois_fin();get_rapport();get_rapport2();change_date_arrivale(this.value);">
 
      </select>
    </div>

    <div class="form-group col-md-2">
      <label style='color:#FFFFFF'>Du</label>
        <input type="date" id="DATE1" onchange="change_date_mois_fin();get_rapport();get_rapport2();change_date_arrival(this.value)" name="DATE1" class="form-control" value="<?=date('Y-m')?>-01">         
                    </div>
        <div class="form-group col-md-2">
        <label style='color:#FFFFFF'>Au</label>
        <input type="date" id="DATE2" name="DATE2" onchange="get_rapport();get_rapport2();change_date_depart(this.value)"  class="form-control" value="<?=date('Y-m-d')?>" >
                    </div>

     </div>
   </div>
  </div>
 </div>
</div>

<div class="row">
   
 <div class="col-md-12" style="margin-bottom: 20px"></div>       
 <div id="container"  class="col-md-12" ></div>
 <div class="col-md-12" style="margin-bottom: 20px"></div>
 <div id="container1"  class="col-md-12" ></div>
 <div class="col-md-12" style="margin-bottom: 20px"></div>
 <div  style="float: right;" class="col-md-2"> 
   <label style="color: white">Assureur</label>
<select class="form-control"  onchange="get_rapport2()" name="ID_ASSUREUR" id="ID_ASSUREUR">
 <option value=""> Sélectionner </option> 

      </select>
    </div>
 <div id="container2"  class="col-md-12" ></div>
 <div class="col-md-12" style="margin-bottom: 20px"></div>
 
 
 
 <div id="container3"  class="col-md-12" ></div>
 
 <div class="col-md-12" style="margin-bottom: 20px"></div>
 <div id="container4"  class="col-md-12" ></div>
 <div class="col-md-12" style="margin-bottom: 20px"></div>
 <div id="container5"  class="col-md-12" ></div>
 <div class="col-md-12" style="margin-bottom: 20px"></div>
 <div id="container6"  class="col-md-12" ></div>
 <div class="col-md-12" style="margin-bottom: 20px"></div>
 <div id="container7"  class="col-md-12" ></div>
 <div class="col-md-12" style="margin-bottom: 20px"></div>
 <div id="container8"  class="col-md-12" ></div>
 <div class="col-md-12" style="margin-bottom: 20px"></div>
 <div id="container9"  class="col-md-12" ></div>
 
 
</div>
</div>
</div>


      <div class="modal fade" id="myModal2" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
       <div class="modal-header" style="background: #000">
        <h4 class="modal-title service" id="titre2"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div>
          <table id='mytable2' class="table table-bordered table-striped table-hover table-condensed " style="width: 100%;">
          
            <thead>
             <tr>
             
                <th>NUMERO&nbsp;&nbsp;DE&nbsp;&nbsp;LA&nbsp;&nbsp;PLAQUE</th>
                 <th>TYPE&nbsp;&nbsp;DE&nbsp;&nbsp;VERIFICATION</th>
                  <th>DATE&nbsp;&nbsp;D'&nbsp;&nbsp;INSERTION</th>
                  <th>INFRANCTION</th>
                  <th>COMMENTAIRE</th>

             </tr>
           </thead>
         </table>
       </div>
     </div>
     <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
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
<div id="nouveau5">
</div>
<div id="nouveau6">
</div>
<div id="nouveau7">
</div>
<div id="nouveau8">
</div>
<div id="nouveau9">
</div>


</div>



    

<?php include VIEWPATH.'templates/footer.php'; ?>
</body>
</html>


<script type="text/javascript">
$( document ).ready(function() {
    get_rapport();
   get_rapport2();
    // alert();
});
    
function get_i() {

 $('#jour').html('');
 get_rapport();
   
}
</script>

<script>
function getdate()
      {
        var date = $('#jour').val();
        $('#DATE1').val(date);
       // DATE2=html(date)
      } 
function get_rapport(){ 
var mois=$('#mois').val();  
var jour=$('#jour').val(); 
var MOIS=$('#MOIS').val(); 
var DATE1=$('#DATE1').val();
var DATE2=$('#DATE2').val(); 
var ID_ASSUREUR=$('#ID_ASSUREUR').val();
 
$.ajax({
url : "<?=base_url()?>dashboard/Dashboard_Constats/get_rapport",
type : "POST",
dataType: "JSON",
cache:false,
data:{
mois:mois,
jour:jour,
DATE1:DATE1,
DATE2:DATE2,
ID_ASSUREUR:ID_ASSUREUR
},
success:function(data){   
$('#container').html("");             
$('#nouveau').html(data.rapp);
$('#container1').html("");             
$('#nouveau1').html(data.rapp1);
$('#container3').html("");             
$('#nouveau3').html(data.rapp3);
$('#container4').html("");             
$('#nouveau4').html(data.rapp4);
$('#container5').html("");             
$('#nouveau5').html(data.rapp5);

$('#container6').html("");             
$('#nouveau6').html(data.rapp6);
$('#container7').html("");             
$('#nouveau7').html(data.rapp7);
$('#container8').html("");             
$('#nouveau8').html(data.rapp8);
$('#container9').html("");             
$('#nouveau9').html(data.rapp9);

$('#jour').html(data.select_month);
$('#ID_ASSUREUR').html(data.assurances);
},            

});  
}

function get_rapport2(){

 var mois=$('#mois').val();  
var jour=$('#jour').val(); 
var MOIS=$('#MOIS').val(); 
var DATE1=$('#DATE1').val();
var DATE2=$('#DATE2').val(); 
var ID_ASSUREUR=$('#ID_ASSUREUR').val();
$.ajax({
url : "<?=base_url()?>dashboard/Dashboard_Constats/get_rapport",
type : "POST",
dataType: "JSON",
cache:false,
data:{
mois:mois,
jour:jour,
DATE1:DATE1,
DATE2:DATE2,
ID_ASSUREUR:ID_ASSUREUR

},
success:function(data){   

$('#container2').html("");             
$('#nouveau2').html(data.rapp2);

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
}else if(month=='04' ||month=='06' ||month=='09' ||month=='11'){
var jourfin ='30';
}
         
          var arrival_date = yyyy+'-'+month+'-'+day;
          var arrival_fine = yyyy+'-'+month+'-'+jourfin;
        // alert(arrival_date)
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
}else if(month=='04' ||month=='06' ||month=='09' ||month=='11'){
var jourfin ='30';
}

         
          var arrival_date = yyyy+'-'+month+'-'+day;
           var arrival_fine = yyyy+'-'+month+'-'+jourfin;
        // alert(arrival_date)
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

