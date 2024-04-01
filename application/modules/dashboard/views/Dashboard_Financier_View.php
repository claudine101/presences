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
            <script>
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; 
            var yyyy = today.getFullYear();

            if(dd<10){
              dd='0'+dd
          } 
          if(mm<10){
              mm='0'+mm
          } 
          today = yyyy+'-'+mm+'-'+dd;
      </script>
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
<div class="form-group col-md-4"><h4 style='color:#FFFFFF'>Rapport Financier</h4></div>

    <div class="form-group col-md-2">
<label style='color:#FFFFFF'>Année</label>
<select class="form-control"  onchange="change_date_mois();change_date_mois_fin();get_i()" name="mois" id="mois">

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
<select class="form-control"  name="jour" id="jour" onchange="change_date_mois();change_date_mois_fin();get_rapport();change_date_arrivale(this.value);">
 
      </select>
    </div>

    <div class="form-group col-md-2">
      <label style='color:#FFFFFF'>Du</label>
        <input type="date" id="DATE1" onchange="change_date_mois_fin();get_rapport();change_date_arrival(this.value)" name="DATE1" class="form-control" value="<?=date('Y-m')?>-01">         
                    </div>
        <div class="form-group col-md-2">
        <label style='color:#FFFFFF'>Au</label>
        <input type="date" id="DATE2" name="DATE2" onchange="get_rapport();change_date_depart(this.value)"  class="form-control" value="<?=date('Y-m-d')?>" >
                    </div>


<!-- <div class="form-group col-md-2">
  <label style='color:#FFFFFF'>Statut</label>

  <select class="form-control input-sm" onchange="get_rapport()" name="IS_PAID" id="IS_PAID" >
    <?php if (set_value('IS_PAID') == 1) { ?>
        <option value="">Sélectionner</option>
        <option value="1" selected>Payé</option>
        <option value="0">Non Payé</option>
    <?php } elseif (set_value('IS_PAID') == "0") { ?>
        <option value="">Sélectionner</option>
        <option value="1">Payé</option>
        <option value="0" selected>Non Payé</option>

    <?php }else{ ?>
    <option value="" selected>Sélectionner</option>
    <option value="1">Payé</option>
    <option value="0">Non Payé</option>

    <?php } ?>
   
</select>
</div>  -->
     </div>
   </div>
  </div>
 </div>
</div>

<div class="row">
 
      <div class="col-md-12" style="margin-bottom: 20px"></div>    
  <div id="container1"  class="col-md-12" style="max-height: 450px" ></div>   
  <div id="container"  class="col-md-12" style="max-height: 450px;margin-top: 5px;" ></div>
  
  <div class="col-md-12" style="margin-bottom: 20px"></div>
  
  
</div>
</div>
</div>


<div class="modal fade bd-example-modal-xl" tabindex="-1" id="myModal" role="dialog">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header" style="background: #000">
              <h4 class="modal-title"><span id="titre"></span></h4>
            </div>
            <div class="modal-body">
                 <div class="table-responsive"> 
                <table style="width: 100%;" id='mytable' class='table table-bordered table-striped table-hover table-condensed table-responsive'>
                   <thead>
                                <tr>
                                
                                  <th>Agent</th>
                                  <th>Date&nbsp;des&nbsp;faits</th>
                                  <th>Type</th>
                                  <th>Annulé</th>
                                  <th>Plaque</th>
                                  <th>Permis</th>
                                  <th>Amende BIF</th>
                                  <th>Statut</th>
                                  <th>Actions</th>
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

      <div class="modal fade" id="myModal1" role="dialog">
        <div class="modal-dialog modal-lg" style ="width:600px">
          <div class="modal-content  modal-lg">
            <div class="modal-header" style="background: #000">
              <h4 class="modal-title"><span id="titre1"></span></h4>
            </div>
            <div class="modal-body">
                 <div class="table-responsive"> 
                <table style="width: 120%;" id='mytable1' class='table table-bordered table-striped table-hover table-condensed table-responsive'>
                   <thead>
                                <tr>

                                  <th>Agent</th>
                                  <th>Plaque</th>
                                  <th>Type</th>
                                  <th>Annulé</th>
                                  <th>Date</th>
                                  <th>Amende BIF</th>
                                 
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
   

     <div class="modal fade" id="detailControl">
       <div class="modal-dialog modal-lg" >
         <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;">Détails</h4></b></div>

            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
         <div class="modal-body" id="donneDeatail">



         </div>
         <div class="modal-footer"> 
           <!--  <button id="btn_quiter" type="button" class="btn btn-primary" class='close' data-dismiss='modal'>Quitter</button> -->
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

function getdate()
      {
        var date = $('#jour').val();
        $('#DATE1').val(date);
       // DATE2=html(date)
      }
function get_rapport(){

var mois=$('#mois').val();  
var jour=$('#jour').val();
var DATE1=$('#DATE1').val();
var DATE2=$('#DATE2').val();
var IS_PAID=$('#IS_PAID').val();
var heure=$('#heure').val();
$.ajax({
url : "<?=base_url()?>dashboard/Dashboard_Financier/get_rapport",
type : "POST",
dataType: "JSON",
cache:false,
data:{
mois:mois,
jour:jour,
DATE1:DATE1,
DATE2:DATE2,
IS_PAID:IS_PAID,
heure:heure,
 
},
success:function(data){   
$('#container').html("");             
$('#nouveau').html(data.rapp );
$('#container1').html("");             
$('#nouveau1').html(data.rapp1 );
$('#jour').html(data.select_month);
$('#heure').html(data.selectjour);

},            

});  
}

</script> 

<script>
function getDetailControl(id = 0) {


    $('#detailControl').modal()



    $.ajax({
      url : "<?=base_url()?>PSR/Historique/gethistoControl/"+id,
      type : "POST",
      dataType: "JSON",
      cache:false,
      data: {ID:id},
      beforeSend:function () { 
        $('#donneDeatail').html("");
      },
      success:function(data) {
       $('#donneDeatail').html(data.views_detail);
       $('#donneTitre').html(data.titres);

     },
     error:function() {
      $('#donneDeatail').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher cette page! Veuillez réessayer</div>');
    }
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
}else if(month=='02' || month=='04' ||month=='06' ||month=='09' ||month=='11'){
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