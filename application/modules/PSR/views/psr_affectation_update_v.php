<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php';?>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include VIEWPATH.'templates/navbar.php'; ?>
    <!-- Main Sidebar Container -->
    <?php include VIEWPATH.'templates/sidebar.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-9">

              <h4 class="m-0"><?=$title?></h4>
            </div><!-- /.col -->
            <div class="col-sm-3">
              <a href="<?=base_url('PSR/Psr_affectation/index')?>" class='btn btn-primary float-right'>
                <i class="nav-icon fas fa-list ul"></i>
                Liste
              </a>
            </div><!-- /.col -->
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="col-md-12 col-xl-12 grid-margin stretch-card">

          <div class="card">
            <div class="card-body">

              <div class="col-md-12">

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Psr_affectation/update'); ?>" >

                  <div class="row">
                    <input type="hidden" class="form-control" name="PSR_AFFECTATION_ID" value="<?=$membre['PSR_AFFECTATION_ID']?>" >
                    <div class="col-md-6">
                      <label for="Ftype">Police</label>
                      <select class="form-control" name="police" id="police" onchange="get_communes();">
                        
                        <?php

                        foreach ($policien as $value)
                        {

                          $selected="";
                          if($value['ID_PSR_ELEMENT']==$membre['ID_PSR_ELEMENT'])
                          {
                            $selected="selected";
                          }
                          ?>
                          <option value="<?=$value['ID_PSR_ELEMENT']?>" <?=$selected?>><?=$value['NUMERO_MATRICULE']?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <div><font color="red" id="error_province"></font></div> 
                    </div>

                    <div class="col-md-6">
                      <label for="Ftype">Province</label>
                      <select class="form-control" name="ID_PROVINCE" id="ID_PROVINCE" onchange="get_communes();">
                        <!-- <option value="">---Sélectionner---</option> -->
                        <?php

                        foreach ($provinces as $value)
                        {

                          $selected="";
                          if($value['PROVINCE_ID']==$membre['PROVINCE_ID'])
                          {
                            $selected="selected";
                          }
                          ?>
                          <option value="<?=$value['PROVINCE_ID']?>" <?=$selected?>><?=$value['PROVINCE_NAME']?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <div><font color="red" id="error_province"></font></div> 
                    </div>

                    <div class="col-md-6">
                      <label for="Ftype">Commune</label>
                      <select class="form-control" name="ID_COMMUNE" id="ID_COMMUNE" onchange="get_zones();">
                        <!-- <option value="">---Sélectionner---</option> -->
                        <?php
                        foreach ($communes as $key)
                        {
                          $selected="";
                          if($key['COMMUNE_ID']==$membre['COMMUNE_ID'])
                          {
                            $selected="selected";
                          }
                          ?>
                          <option value="<?=$key['COMMUNE_ID']?>" <?=$selected?>><?=$key['COMMUNE_NAME']?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <div><font color="red" id="error_commune"></font></div>
                    </div>

                    <div class="col-md-6">
                      <label for="Ftype">Zone</label>
                      <select class="form-control" name="ID_ZONE" id="ID_ZONE" onchange="get_collines();">
                        <!-- <option value="">---Sélectionner---</option> -->
                        <?php
                        foreach ($zones as $key)
                        {
                          $selected="";
                          if($key['ZONE_ID']==$membre['ZONE_ID'])
                          {
                            $selected="selected";
                          }
                          ?>
                          <option value="<?=$key['ZONE_ID']?>" <?=$selected?>><?=$key['ZONE_NAME']?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <div><font color="red" id="error_zone"></font></div>
                    </div>

                    <div class="col-md-6">
                      <label for="Ftype">Colline</label>
                      <select class="form-control" name="ID_COLLINE" id="ID_COLLINE">
                        <!-- <option value="">---Sélectionner---</option> -->
                        <?php
                        foreach ($collines as $key)
                        {
                          $selected="";
                          if($key['COLLINE_ID']==$membre['COLLINE_ID'])
                          {
                            $selected="selected";
                          }
                          ?>
                          <option value="<?=$key['COLLINE_ID']?>" <?=$selected?>><?=$key['COLLINE_NAME']?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <div><font color="red" id="error_colline"></font></div> 
                    </div>

                    <div class="col-md-6">
                      <label for="FName">LIEU EXACTE</label>
                      <input type="text" name="LIEU_EXACTE" value="<?=$membre['LIEU_EXACTE'] ?>"  id="LIEU_EXACTE" class="form-control">
                      <?php echo form_error('LIEU_EXACTE', '<div class="text-danger">', '</div>'); ?> 
                    </div>
                    <div class="col-md-6">
                      <label for="FName">LATITUDE</label>
                      <input type="text" name="LATITUDE" value="<?=$membre['LATITUDE'] ?>"  id="LATITUDE" class="form-control">

                      <?php echo form_error('LATITUDE', '<div class="text-danger">', '</div>'); ?> 

                    </div>
                    <div class="col-md-6">
                      <label for="FName">LONGITUDE</label>
                      <input type="text" name="LONGITUDE" value="<?=$membre['LONGITUDE'] ?>"  id="LONGITUDE" class="form-control">

                      <?php echo form_error('LONGITUDE', '<div class="text-danger">', '</div>'); ?> 

                    </div>


                  </div>  
                  <div class="col-md-6" style="margin-top:31px;">
                    <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Modifier</button>

                  </div>
                </div>

              </div>
            </div>

                <!-- <div class="row">
                  
                </div> -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
</body>

<?php include VIEWPATH.'templates/footer.php'; ?>


<script>
  function get_communes()
  {
    var ID_PROVINCE=$('#ID_PROVINCE').val();
    if(ID_PROVINCE=='')
    {
      $('#ID_COMMUNE').html('<option value="">---Sélectionner---</option>');
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    }
    else
    {
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax(
      {
        url:"<?=base_url()?>PSR/Psr_elements/get_communes/"+ID_PROVINCE,
        type:"GET",
        dataType:"JSON",
        success: function(data)
        {
          $('#ID_COMMUNE').html(data);
        }
      });

    }
  }

  function get_zones()
  {
    var ID_COMMUNE=$('#ID_COMMUNE').val();
    if(ID_COMMUNE=='')
    {
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    }
    else
    {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax(
      {
        url:"<?=base_url()?>PSR/Psr_elements/get_zones/"+ID_COMMUNE,
        type:"GET",
        dataType:"JSON",
        success: function(data)
        {
          $('#ID_ZONE').html(data);
        }
      });

    }
  }


  function get_collines()
  {
    var ID_ZONE=$('#ID_ZONE').val();
    if(ID_ZONE=='')
    {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    }
    else
    {
      $.ajax(
      {
        url:"<?=base_url()?>PSR/Psr_elements/get_collines/"+ID_ZONE,
        type:"GET",
        dataType:"JSON",
        success: function(data)
        {
          $('#ID_COLLINE').html(data);
        }
      });

    }
  }
</script>