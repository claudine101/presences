<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header_reporting.php'; ?> 


<style type="text/css">
.highcharts-figure,
.highcharts-data-table table {
    min-width: 360px;
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


        <div class="card-header">
          <div class="row">
   <!-- <div class="col-md-6">

      <form id="myform" method="post" action="<?php echo base_url('rapport/Rapport_Financier/index')?>"></form>
     <input class="form-control" type="date" name="date_filter" onchange="submit()">
 </div> -->





 <div class="col-md-12 "style="padding: 5px">

  <form name="myform" action="<?=base_url('rapport/Rapport_Financier')?>" method="post" id="myform" >

   <div class="row">

    <div class="form-group col-md-2">
 
<label>Année</label> 
<select class="form-control" onchange="submit_annee()" name="ANNE" id="ANNE">
<option value="" selected>Sélectionner</option>
<?php
foreach ($annee_searc as $value){
if ($value['annee'] == $ANNE)
{?>
<option value="<?=$value['annee']?>" selected><?=$value['annee']?></option>
<?php } else{ ?>
<option value="<?=$value['annee']?>"><?=$value['annee']?></option>
<?php } } ?>
</select>
</div>

<div class="form-group col-md-2">

<label>Mois</label> 
<select class="form-control" onchange="submit_mois()" name="MOIS" id="MOIS">
<option value="" selected>Sélectionner</option>
<?php foreach($mois_searc as $value){ 
if ($value['mois']==$MOIS) {
echo '<option selected value="'.$value['mois'].'" selected>'.$value['mois'].'</option>';
} else {
echo '<option value="'.$value['mois'].'">'.$value['mois'].'</option>';
                                    
}  
} ?>

</select>
</div>
    <div class="form-group col-md-3">
      <label>Du</label>

      <input type="date" class="form-control input-sm" onchange="submit();" name="DATE_UNE" id="DATE_UNE" value="<?=set_value('DATE_UNE')?>" min="<?=set_value('MOIS')?>-01">
       
 </div>  


<div class="form-group col-md-3">
  <label>Au</label>

   <input type="date" class="form-control input-sm" onchange="submit();" name="DATE_DEUX" id="DATE_DEUX" min="<?=set_value('DATE_UNE')?>" value="<?=set_value('DATE_DEUX')?>" >

</div>


<div class="form-group col-md-2">
  <label>Statut</label>

  <select class="form-control input-sm" onchange="submit()" name="IS_PAID" id="IS_PAID" >
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
</div> 
</div>
</form>









</div>

</div>

</div>



<div class="card-body">

    <div class="row">
       <div class="col-md-6" id="container" style="border: 1px solid #d2d7db;"></div>
       <div class="col-md-6" id="container2" style="border: 1px solid #d2d7db;"></div>

        <!-- <div class="col-md-12" id="container3" style="border: 1px solid #d2d7db;"></div> -->
   </div>
   


</div>
</div>
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<?php include VIEWPATH . 'templates/footerDeux.php'; ?>


</body>

<script type="text/javascript">

     Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: ' Total Amende par signalement '
    },
    subtitle: {
        text: '<?= number_format($total,0,',',' ') ?> FBU'
    },
    xAxis: {
        categories: [<?=$catego?>]
    },
    yAxis: {
        title: {
            text: 'Amende (FBU)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Amende par signalement',
        color:'green',
        data: [<?= $datas ?>]
    }]
});
      


</script>


<script type="text/javascript">


     Highcharts.chart('container2', {
    chart: {
        type: 'line'
    },
    title: {
        text: ' Total Amende par contrôle '
    },
    subtitle: {
        text: '<?= number_format($total2,0,',',' ') ?> FBU'
    },
    xAxis: {
        categories: [<?=$catego2?>]
    },
    yAxis: {
        title: {
            text: 'Amende (FBU)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Amende par contrôle',
        color:'orange',
        data: [<?= $datas2 ?>]
    }]
});

</script>

<script type="text/javascript">
  function submit()
  {
    myForm.submit();
}
function submit_annee(){

myform.action= myform.action;
 myform.submit();

 }

 function submit_mois(){

myform.action= myform.action;
 myform.submit();

 }


</script>



</html>