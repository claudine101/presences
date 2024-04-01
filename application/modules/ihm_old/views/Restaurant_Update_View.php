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
              <a href="<?=base_url('ihm/Restaurants/index')?>" class='btn btn-primary float-right'>
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

               <form  name="myform" method="post" enctype="multipart/form-data" class="form-horizontal" action="<?= base_url('ihm/Restaurants/update'); ?>">
                <div class="row">
              <input type="hidden" class="form-control" name="ID_RESTAURANT" value="<?=$resto['ID_RESTAURANT']?>" >
                  <div class="col-md-6">
                    <label for="FNif">Nom Restaurant</label>
                    <input  type="text" required name="NOM_RESTAURANT"  id="NOM_RESTAURANT"  class="form-control" value="<?=$resto['NOM_RESTAURANT']?>">
                    
                    <div><font color="red" id="error_prenom"></font></div> 

                  </div>

                  <div class="col-md-6">
                    <label for="FNrc">Description </label><br>
                    <input type="text" name="DESCRIPTION_RESTAURANT" autocomplete="off" id="DESCRIPTION_RESTAURANT" class="form-control" value="<?=$resto['DESCRIPTION_RESTAURANT']?>">
                    
                    <div><font color="red" id="error_telephone"></font></div>  

                  </div>

                  <div class="col-md-6">
                    <label for="Ftype">Province</label>
                    <select class="form-control" name="PROVINCE_ID" id="ID_PROVINCE" onchange="get_communes();">
                      <!-- <option value="">---Sélectionner---</option> -->
                      <?php
                      foreach ($provinces as $value)
                      {

                        $selected="";
                        if($value['PROVINCE_ID']==$resto['PROVINCE_ID'])
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
                    <select class="form-control" name="COMMUNE_ID" id="ID_COMMUNE" onchange="get_zones();">

                      <?php
                      foreach ($communes as $key)
                      {
                        $selected="";
                        if($key['COMMUNE_ID']==$resto['COMMUNE_ID'])
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
                    <select class="form-control" name="ZONE_ID" id="ID_ZONE" onchange="get_collines();">
                      <!-- <option value="">---Sélectionner---</option> -->
                      <?php
                      foreach ($zones as $key)
                      {
                        $selected="";
                        if($key['ZONE_ID']==$resto['ZONE_ID'])
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
                    <select class="form-control" name="COLLINE_ID" id="ID_COLLINE">
                      <!-- <option value="">---Sélectionner---</option> -->
                      <?php
                      foreach ($collines as $key)
                      {
                        $selected="";
                        if($key['COLLINE_ID']==$resto['COLLINE_ID'])
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
                    <label for="FName">Responsable</label>
                    <input type="text" name="NOM_RESPONSABLE" autocomplete="off" id="NOM_RESPONSABLE" value="<?=$resto['NOM_RESPONSABLE']?>"  class="form-control">
                    
                    <div><font color="red" id="error_resto"></font></div>  

                  </div>
                  <div class="col-md-6">
                    <label for="FName">Téléphone</label>
                    <input type="text" name="TEL_RESPONSABLE" autocomplete="off" id="TEL_RESPONSABLE"  value="<?=$resto['TEL_RESPONSABLE']?>" class="form-control">
                    
                    <div><font color="red" id="error_telephone"></font></div> 

                  </div>
                  <div class="col-md-6">
                    <label for="FName">Email</label>
                    <input type="tel" name="EMAIL_RESPONSABLE" autocomplete="off" id="EMAIL_RESPONSABLE"  class="form-control" value="<?=$resto['EMAIL_RESPONSABLE']?>">
                    
                    <div><font color="red" id="error_email"></font></div> 
                  </div>
                   <div class="col-md-6">
                        <label style="font-weight: 900; color:#454545">Activer <span class="text-danger">*</span></label><br>
                         <?php $check_oui =  ($resto['IS_ACTIF'] == 1) ? 'checked' : '';
                                $check_non =  ($resto['IS_ACTIF'] == 0) ? 'checked' : ''; ?>
                        <label>Oui</label>
                        <input value="1" type="radio" name="IS_ACTIF" <?=$check_oui?>>
                        <label>Non</label>
                        <input value="0" type="radio" name="IS_ACTIF" <?=$check_non?>>
                       <div><font color="red" id="error_actif"></font></div> 
                       </div>
               

                  <div class="col-md-3">
                    <label for="FName"> LATITUDE</label>
                    <input type="text" name="LATITUDE" autocomplete="off" id="LATITUDE" value="<?=$resto['LATITUDE']?>" class="form-control">
                    
                    <div><font color="red" id="error_lat"></font></div> 

                  </div> 
                  <div class="col-md-3">
                    <label for="FName"> LONGITUDE</label>
                    <input type="text" name="LONGITUDE" autocomplete="off" id="LONGITUDE" value="<?=$resto['LONGITUDE']?>" class="form-control">
                    
                    <div><font color="red" id="error_long"></font></div> 

                  </div> 
                <div class="col-md-6 row">
                  <div class="col-md-2">
                    <label for="text" style="font-size: 20px;" id="fileName"></label> </br>
                    <label class="label" data-toggle="tooltip" title="Attacher un fichier">
                      <font style="font-size: 40PX;color: green" ><i class="fas fa-image rounded" id="avatar" alt="avatar"></i></font>
                      <input type="file" class="sr-only" id="PHOTO" name="PHOTO" accept="image/*" required>
                      
                    </label>
                      <input type="hidden"  id="old"  name="old"  value="<?=$resto['IMAGE']?>">
                    </div>
                    <div class="col-md-6" style="margin-top: 5px" id="resultGet">
                      <img src=" <?=$resto['IMAGE']?>" height="40" width="40"> 
                    </div>
                  </div>
                </div>

              </form>
              <div class="col-md-6" style="margin-top:31px;">
                <button type="submit" style="float: right;" class="btn btn-primary" onclick="valide()";><span class="fas fa-save"></span> Modifier </button>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div></div><br>
  <?php include VIEWPATH.'templates/footer.php'; ?>
</div>
</body>



<script type="text/javascript">
  function valide()
  {
    var NOM_RESTAURANT=$('#NOM_RESTAURANT').val();
    var DESCRIPTION_RESTAURANT=$('#DESCRIPTION_RESTAURANT').val();
    var ID_PROVINCE=$('#ID_PROVINCE').val();
    var ID_COMMUNE=$('#ID_COMMUNE').val();
    var ID_ZONE=$('#ID_ZONE').val();
    var ID_COLLINE=$('#ID_COLLINE').val();
    var NOM_RESPONSABLE=$('#NOM_RESPONSABLE').val();
    var TEL_RESPONSABLE=$('#TEL_RESPONSABLE').val();
    var EMAIL_RESPONSABLE=$('#EMAIL_RESPONSABLE').val();
    var IS_ACTIF=$('#IS_ACTIF').val();
    var LATITUDE=$('#LATITUDE').val();
    var LONGITUDE=$('#LONGITUDE');



    $('#error_prenom').html('');
    $('#error_telephone').html('');
    $('#error_province').html('');
    $('#error_commune').html('');
    $('#error_zone').html('');
    $('#error_colline').html('');
    $('#error_resto').html('');
    $('#error_telephone').html('');
    $('#error_email').html('');
    $('#error_actif').html('');
    $('#error_lat').html('');
    $('#error_long').html('');
    var statut=0;
    if(NOM_RESTAURANT=='')
    {
      $('#error_prenom').html('Le champion est obligatoire');
      statut=1;
    }

    if(DESCRIPTION_RESTAURANT=='')
    {
      $('#error_telephone').html('Le champion est obligatoire');
      statut=1;
    }

    if(ID_PROVINCE=='')
    {
      $('#error_province').html('Le champion est obligatoire');
      statut=1;
    }

    if(ID_COMMUNE=='')
    {
      $('#error_commune').html('Le champion est obligatoire');
      statut=1;
    }

    if(ID_ZONE=='')
    {
      $('#error_zone').html('Le champion est obligatoire');
      statut=1;
    }

    if(ID_COLLINE=='')
    {
      $('#error_colline').html('Le champion est obligatoire');
      statut=1;
    }

    if(NOM_RESPONSABLE=='')
    {
      $('#error_resto').html('Le champion est obligatoire');
      statut=1;
    }

    if(TEL_RESPONSABLE=='')
    {
      $('#error_telephone').html('Le champion est obligatoire');
      statut=1;
    }
    if(EMAIL_RESPONSABLE=='')
    {
      $('#error_email').html('Le champion est obligatoire');
      statut=1;
    }
    if(IS_ACTIF=='')
    {
      $('#error_actif').html('Le champion est obligatoire');
      statut=1;
    }

    if(LATITUDE=='')
    {
      $('#error_lat').html('Le champion est obligatoire');
      statut=1;
    }
    if(LONGITUDE=='')
    {
      $('#error_long').html('Le champion est obligatoire');
      statut=1;
    }


    if(statut==0)
    {
      myform.submit();
    }
  }

</script>



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
        url:"<?=base_url()?>ihm/Restaurants/get_communes/"+ID_PROVINCE,
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
        url:"<?=base_url()?>ihm/Restaurants/get_zones/"+ID_COMMUNE,
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
        url:"<?=base_url()?>ihm/Restaurants/get_collines/"+ID_ZONE,
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

<script type="text/javascript">

  function readURL(input) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
      //alert(e.target.result);
      $('#buttonFile').delay(100).show('hide');
      let myArr = e.target.result;
      const myArrData = myArr.split(":");
      let deux_name = myArrData[1].split("/");
      
      if (deux_name[0] == 'image') {
        var back_lect = '<img  height="80" src="'+e.target.result+'">';
        $('#resultGet').html(back_lect);
      }else{
        $('#resultGet').html('');
      }

    }
    
     reader.readAsDataURL(input.files[0]); // convert to base64 string
   }
 }

 $("#PHOTO").change(function() {
   readURL(this);
 });

</script>

