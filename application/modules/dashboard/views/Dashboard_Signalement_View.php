<!DOCTYPE html>
<html lang="en">   
    <head>
      <script src="https://code.highcharts.com/highcharts.js"></script>
      <script src="https://code.highcharts.com/highcharts-more.js"></script>
      <script src="https://code.highcharts.com/modules/dumbbell.js"></script>
      <script src="https://code.highcharts.com/modules/lollipop.js"></script>
      <script src="https://code.highcharts.com/modules/exporting.js"></script>
      <script src="https://code.highcharts.com/modules/accessibility.js">
      </script src="https://code.highcharts.com/modules/exporting.js"></script>
      <script src="https://code.highcharts.com/modules/export-data.js"></script>
      <script src="https://code.highcharts.com/modules/accessibility.js"></script>
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
    </head>
  <?php include VIEWPATH . 'templates/header_reporting.php'; ?>
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
    .modal-header {
      background-color: #000;
      color: #fff;
      font-size: 13px;
    }
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
              <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                <h4 style='color:#FFFFFF;margin-left: 20px'><?=$title?></h4>

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
                <div class="row" style="margin-left: 20px">       
                  <div class="form-group col-md-2">
                  <label style='color:#FFFFFF'>Du</label>
                  <input type="date" id="DATE1" onchange="get_rapport();change_date_arrival(this.value)" name="DATE1" class="form-control" value="">         
                  </div>
                  <div class="form-group col-md-2">
                  <label style='color:#FFFFFF'>Au</label>
                  <input type="date" id="DATE2" name="DATE2" onchange="get_rapport();change_date_depart(this.value)"  class="form-control" >
                  </div>
                  <div class="form-group col-md-2">
                  <label style='color:#FFFFFF'>Statut</label>
                  <select name="STATUT" id="STATUT" onchange="get_rapport()" class="form-control">
                  <option value="">Sélectionner</option>
                  <?php
                  foreach ($statut as $key => $value) {
                  if (set_value('STATUT')==$value['ID_ALERT_STATUT']) {?>
                  <option value="<?=$value['ID_ALERT_STATUT']?>" selected><?=$value['NOM']?></option>   
                  <?php }else{
                  ?>
                  <option value="<?=$value['ID_ALERT_STATUT']?>"><?=$value['NOM']?></option>
                  <?php
                  }}?> 
                  </select>
                  <span class="help-block" style="color: red"></span>
                  </div>

                  <div class="form-group col-md-2">
                  <span class="label-input100" style='color:#FFFFFF'>
                  Source du signalement</span> <br>

                  <input type="radio" onchange="get_rapport()" name="SOURCE" id="sourceoui" value="1"><span style='color:#FFFFFF'>agent</span>
                  <input type="radio"  onchange="get_rapport()" name="SOURCE" id="sourcenon"  value="0" ><span style='color:#FFFFFF'>citoyen</span>
                  <input type="radio"  onchange="get_rapport()" name="SOURCE" id="SOURCETOUS"  value="3" ><span style='color:#FFFFFF'>tout</span>

                  </div>
                  <div class="form-group col-md-2">
                  <span class="label-input100" style='color:#FFFFFF'>
                  Avoir vu la plaque</span> <br>

                  <input type="radio" onchange="get_rapport()" name="PLAQUE" id="plaqueoui" value="1"><span style='color:#FFFFFF'>oui</span>
                  <input type="radio"  onchange="get_rapport()" name="PLAQUE" id="plaquenon"  value="0"><span style='color:#FFFFFF'>non</span>

                  <input type="radio"  onchange="get_rapport()" name="PLAQUE" id="PLAQUETOUS"  value="3"><span style='color:#FFFFFF'>tout</span>

                  </div>
                  <div class="form-group col-md-2">
                  <span class="label-input100" style='color:#FFFFFF'>
                  Annulation du signalement</span> <br>

                  <input type="radio" onchange="get_rapport()" name="ANNULATION" id="annulationoui" value="1"><span style='color:#FFFFFF'>oui</span>

                  <input type="radio"  onchange="get_rapport()" name="ANNULATION" id="annulationnon"  value="0" ><span style='color:#FFFFFF'>non</span>

                  <input type="radio"  onchange="get_rapport()" name="ANNULATION" id="ANNULATIONTOUS"  value="3" ><span style='color:#FFFFFF'>tout</span> 

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" style="margin-bottom: 20px"></div>       
          <div id="container1"  class="col-md-12"  ></div>

          <div class="col-md-12" style="margin-bottom: 20px"></div>
          <div id="container2"  class="col-md-12"  ></div>

          <div class="col-md-12" style="margin-bottom: 20px"></div>
          <div id="container3"  class="col-md-12" ></div>

          <div class="col-md-12" style="margin-bottom: 20px"></div>
          <div id="container4"  class="col-md-12" ></div>
          <div class="col-md-12" style="margin-bottom: 20px"></div>
        </div>
      </div>
    </div>
          <div id="nouveau1"></div>
          <div id="nouveau2"></div>
          <div id="nouveau3"></div>
          <div id="nouveau4"></div>

        <div class="modal fade" id="myModal1" role="dialog">
         <div class="modal-dialog modal-xl" style ="width:1000px">
          <div class="modal-content  modal-xl">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titre1"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytable1' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
                <thead>
                  <th>#</th>
                  <th>image</th>
                  <th>auteur</th>
                  <th>profil</th>
                  <th>numéro de la plaque</th> 
                  <th>date</th>
                </thead> 
              </table>
            </div>
          </div>
          </div>
        </div>
      </div>

          <!-----=====================modal detail 2================-->
      <div class="modal fade" id="myModal2" role="dialog">
        <div class="modal-dialog modal-xl" style ="width:1000px">
          <div class="modal-content  modal-xl">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titre2"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
                <thead>
                  <th>#</th>
                  <th>image</th> 
                  <th>auteur</th>
                  <th>profil</th>
                  <th>date du signal</th>
                  <th>numéro de la plaque</th>
                  <th>infraction</th>
                  <th>amande</th>    
                </thead>  
              </table>
            </div>
          </div>
          </div>
        </div>
      </div>

      <!-----=====================modal detail 3================-->
      <div class="modal fade" id="myModal3" role="dialog">
        <div class="modal-dialog modal-xl" style ="width:1000px">
          <div class="modal-content  modal-xl">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titre3"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytable3' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
                 <thead>
                  <th>#</th>
                  <th>image</th> 
                  <th>auteur</th>
                  <th>profil</th>
                  <th>date du signal</th>
                  <th>infraction</th>    
                </thead>   
              </table>
            </div>
          </div>
          </div>
        </div>
      </div>
      <!-----=====================modal detail 4================-->
      <div class="modal fade" id="myModal4" role="dialog">
        <div class="modal-dialog modal-xl" style ="width:1000px">
          <div class="modal-content  modal-xl">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titre4"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytable4' class='table table-bordered table-striped table-hover table-condensed' style="width:1000px">
                 <thead>
                  <th>#</th>
                  <th>image</th> 
                  <th>auteur</th>
                  <th>profil</th>
                  <th>date du signal</th>
                  <th>numéro de la plaque</th>
                  <th>infraction</th>   
                </thead> 
              </table>
            </div>
          </div>
          </div>
        </div>
      </div>     
          </div>
    <?php include VIEWPATH . 'templates/footer.php'; ?>
  </body>
  <script type="text/javascript">
  $(document).ready(function(){
    get_rapport();
  });
  </script>
  <script type="text/javascript">
    function getdate()
    {
      var date = $('#DATE1').val();
      $('#DATE2').val(date);
     // DATE2=html(date)
    }
      function get_rapport()
    {

        if (document.getElementById('sourceoui').checked)
        {
         var SOURCE = document.getElementById('sourceoui').value;
        }
        else if (document.getElementById('sourcenon').checked)
        {
         var SOURCE = document.getElementById('sourcenon').value;
        }
         else if (document.getElementById('SOURCETOUS').checked)
        {
         var SOURCE = document.getElementById('SOURCETOUS').value;
        }
          // alert(SOURCE);
        if (document.getElementById('plaqueoui').checked) 
        {
         var PLAQUE = document.getElementById('plaqueoui').value;
        }
        else if (document.getElementById('plaquenon').checked) 
        {
         var PLAQUE = document.getElementById('plaquenon').value;
        }
        else if (document.getElementById('PLAQUETOUS').checked) 
        {
         var PLAQUE = document.getElementById('PLAQUETOUS').value;
        }

        if (document.getElementById('annulationoui').checked) 
        {
         var ANNULATION = document.getElementById('annulationoui').value;
        }
        else if (document.getElementById('annulationnon').checked) 
        {
         var ANNULATION = document.getElementById('annulationnon').value;
        }
        else if (document.getElementById('ANNULATIONTOUS').checked) 
        {
         var ANNULATION = document.getElementById('ANNULATIONTOUS').value;
        }

        var DATE1=$('#DATE1').val();
        var DATE2=$('#DATE2').val();
        var STATUT=$('#STATUT').val();
        
        $.ajax({
          url:"<?=base_url()?>dashboard/Dashboard_Signalement/get_rapport",
          type:"POST",
          dataType:"JSON",
          data:
          {
          DATE1:DATE1,
          DATE2:DATE2,
          STATUT:STATUT,
          SOURCE:SOURCE,
          PLAQUE:PLAQUE,
          ANNULATION:ANNULATION
          },
          success:function(data){
            $('#container1').html("");
            $('#nouveau1').html(data.rapp1); 
            $('#container2').html("");
            $('#nouveau2').html(data.rapp2); 
            $('#container3').html("");
            $('#nouveau3').html(data.rapp3); 
            $('#container4').html("");
            $('#nouveau4').html(data.rapp4); 

          }
        })
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
       
        var arrival_date = yyyy+'-'+month+'-'+day;
      // alert(arrival_date)
      document.getElementById("DATE2").setAttribute("min",arrival_date);
      $('#DATE2').val('');

    }
    function change_date_depart()
    {
        var date_arriv=$('#DATE1').val();
        var formDate=new Date($('#DATE1').val());
        var dd=formDate.getDate()+1;
        var mm=formDate.getMonth()+1;
        var hours =formDate.getHours();  
        var minutes =formDate.getMinutes();

        var yyyy=formDate.getFullYear();

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
       
        var arrival_date = yyyy+'-'+month+'-'+day+'T'+hours+':'+minutes;

        if (date_arriv=='') 
        {
          alert('Please choose the departure date');
          $('#DATE2').val(''); 
        }

        document.getElementById("DATE2").setAttribute("min",arrival_date);
    }
  </script>
</html>






  

