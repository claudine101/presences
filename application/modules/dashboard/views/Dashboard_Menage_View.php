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
<div class="form-group col-md-4"><h5 style='color:#FFFFFF'>Tableau de bord des localités et  ménages </h5></div>

                    <div class="form-group col-md-2">
                     
                      <label style='color:#FFFFFF'>Province</label>
                     <select class="form-control" onchange="submit_prov();get_rapport()" name="PROVINCE_ID" id="PROVINCE_ID">
                        <option value="">Sélectionner</option>
                        <?php
                        foreach ($province as $value){
                            if ($value['PROVINCE_ID'] == $PROVINCE_ID){?>
                                <option value="<?=$value['PROVINCE_ID']?>" selected><?=$value['PROVINCE_NAME']?></option>
                            <?php } else{ ?>
                                <option value="<?=$value['PROVINCE_ID']?>"><?=$value['PROVINCE_NAME']?></option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label style='color:#FFFFFF'>Commune</label>
                        <select class="form-control"onchange="submit_com();get_rapport()" name="COMMUNE_ID" id="COMMUNE_ID">
                            <option value="">Sélectionner</option>
                          
                            </select>
                        </div>


                        <div class="form-group col-md-2">
                            <label style='color:#FFFFFF'>Zone</label>
                            <select class="form-control"onchange="submit_zon();get_rapport()" name="ZONE_ID" id="ZONE_ID">
                                <option value="">Sélectionner</option>

                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                 <label style='color:#FFFFFF'>Colline</label>
                                <select class="form-control"onchange="get_rapport()" name="COLLINE_ID" id="COLLINE_ID">
                                    <option value="">Sélectionner</option>
                                  
                                    </select>
                                </div>
     </div>
   </div>
  </div>
 </div>
</div>

<div class="row">
 
      <div class="col-md-12" style="margin-bottom: 20px"></div>       
  <div id="containercol"  class="col-md-6" ></div>
  <div id="container"  class="col-md-6" ></div>
  <div class="col-md-12" style="margin-bottom: 20px"></div>
  <div id="container1"  class="col-md-6" ></div>
  <div id="container2"  class="col-md-6" ></div>
  <div class="col-md-12" style="margin-bottom: 20px"></div>
  
</div>
</div>
</div>



    

     <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
       <div class="modal-header" style="background: #000">
        <h4 class="modal-title service" id="titre"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          
                <table id='mytable' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
          
            <thead>
             <tr>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;Colline&nbsp;&nbsp;&nbsp;&nbsp;</th>
                 <th>&nbsp;&nbsp;&nbsp;&nbsp;Zone&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  <th>&nbsp;&nbsp;&nbsp;&nbsp;Commune&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  <th>&nbsp;&nbsp;&nbsp;&nbsp;Province&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  <th>&nbsp;&nbsp;&nbsp;&nbsp;Habitats&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  <th>&nbsp;&nbsp;&nbsp;&nbsp;Chefs&nbsp;de&nbsp;colline&nbsp;&nbsp;</th>
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


  <div class="modal fade" id="myModal1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
       <div class="modal-header" style="background: #000">
        <h4 class="modal-title service" id="titre1"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          
                <table id='mytable1' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
          
            <thead>
             <tr>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;Avenue&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;Colline&nbsp;&nbsp;&nbsp;&nbsp;</th>
                 <th>&nbsp;&nbsp;&nbsp;&nbsp;Zone&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  <th>&nbsp;&nbsp;&nbsp;&nbsp;Commune&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  <th>&nbsp;&nbsp;&nbsp;&nbsp;Province&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  <th>&nbsp;&nbsp;&nbsp;&nbsp;Habitats&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  <th>&nbsp;&nbsp;&nbsp;&nbsp;Chefs&nbsp;de&nbsp;secteur&nbsp;&nbsp;</th>
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
          
                <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
          
            <thead>
             <tr>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;Numero&nbsp;maison&nbsp;&nbsp;&nbsp;&nbsp; </th>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;Colline&nbsp;&nbsp;&nbsp;&nbsp;</th>
                 <th>&nbsp;&nbsp;&nbsp;&nbsp;Zone&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  <th>&nbsp;&nbsp;&nbsp;&nbsp;Commune&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  <th>&nbsp;&nbsp;&nbsp;&nbsp;Province&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  <th>Habitats</th>
                   <th>Responsable</th>
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


<div class="modal fade" id="myModal3" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
       <div class="modal-header" style="background: #000">
        <h4 class="modal-title service" id="titre3"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          
                <table id='mytable3' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">

          
            <thead>
             <tr>
                <th>Numero&nbsp;appartement </th>
                 <th>Appartement</th>
                 <th>Numero&nbsp;maison </th>
                <th>Colline</th>
                 <th>Zone</th>
                  <th>Commune</th>
                  <th>Province</th>
                  <th>Habitats</th>
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
<div id="nouveaucol">
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

</script>

<script> 
function get_rapport(){

var DATE1=$('#DATE1').val();
var DATE2=$('#DATE2').val();
var PROVINCE_ID=$('#PROVINCE_ID').val();
var COMMUNE_ID=$('#COMMUNE_ID').val();
var ZONE_ID=$('#ZONE_ID').val();
var COLLINE_ID=$('#COLLINE_ID').val();

$.ajax({
url : "<?=base_url()?>dashboard/Dashboard_Menage/get_rapport",
type : "POST",
dataType: "JSON",
cache:false,
data:{

DATE1:DATE1,
DATE2:DATE2,
PROVINCE_ID:PROVINCE_ID, 
COMMUNE_ID:COMMUNE_ID,
ZONE_ID:ZONE_ID,
COLLINE_ID:COLLINE_ID,
 
},
success:function(data){   
$('#container').html("");             
$('#nouveau').html(data.rapp );
$('#container1').html("");             
$('#nouveau1').html(data.rapp1 );
$('#container2').html("");             
$('#nouveau2').html(data.rapp2 );
$('#containercol').html("");             
$('#nouveaucol').html(data.rappcol );
$('#COMMUNE_ID').html(data.comm);
$('#ZONE_ID').html(data.zon); 
$('#COLLINE_ID').html(data.col);
},            

});  
}



function submit_prov() {
        $('#COMMUNE_ID').html('');
        $('#ZONE_ID').html('');
        $('#COLLINE_ID').html('');
    }

    function submit_com() {
        $('#ZONE_ID').html('');
        $('#COLLINE_ID').html('');

    }

    function submit_zon() {
        $('#COLLINE_ID').html('');
    }
</script> 

<script type="text/javascript">  
      function change_date_arrival()
      {  

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
}else if( month=='04' ||month=='06' ||month=='09' ||month=='11'){
var jourfin ='30';
}
         
          var arrival_date = yyyy+'-'+month+'-'+day;
          var arrival_fine = yyyy+'-'+month+'-'+jourfin;
        // alert(arrival_date);
        document.getElementById("DATE2").setAttribute("min",arrival_date);
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