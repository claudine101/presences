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
          <a href="<?=base_url('menage/Chefs_menage_affectation/index')?>" class='btn btn-primary float-right'>
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

<form  name="myform" method="post" class="form-horizontal" action="<?= base_url('menage/Chefs_menage_affectation/update'); ?>" >



                

               <div class="row">
<input type="hidden" class="form-control" name="ID_AFFECTATION" value="<?=$membre['ID_AFFECTATION']?>" >
                   <div class="col-md-6">
                    <label for="Ftype">Autorite des manages</label>
          <!-- <select class="form-control "   name="ID_CHEF[]" id="ID_CHEF"  multiple="multiple" required>
                      <option value="">---Sélectionner---</option> -->
                      <select required class="form-control" name="ID_CHEF" id="ID_CHEF" required  onchange="get_lieux(); ">
                      <option value="">---Sélectionner---</option>
                      <?php
                      foreach ($polices as $value)
                      {
                        
                          $selected = "";
                          if ($value['ID_CHEF'] == $membre['ID_CHEF']) {
                            $selected = "selected";
                          }
                        ?>
                   <option value="<?=$value['ID_CHEF']?>" <?= $selected ?>><?=$value['PNB']?></option>
                        <?php
                      }
                      ?>
                    </select>

                  </div>
                  <div class="col-md-6">
                      <label for="Ftype">Profil</label>



                      <select onchange="get_lieux(); " required class="form-control" name="CODE_PROFIL" id="CODE_PROFIL">

                        <!-- <option value="">---Sélectionner---</option> -->
                        <?php

                        foreach ($profils as $value) {

                        if($value['CODE_PROFIL'] == $membre['CODE_PROFIL']) { ?>
                            
                        <option selected value="<?= $value['CODE_PROFIL'] ?>"><?= $value['STATUT'] ?></option>

                        <?php }else{ ?>

                        <option value="<?= $value['CODE_PROFIL'] ?>" ><?= $value['STATUT'] ?></option>

                        <?php }  } ?>


                      </select>
                      <div>
                        <font color="red" id="error_profil"></font>
                      </div>
                    </div> 
                    <div class="col-md-6">
                    <label for="FName">DATE DEBUT</label>
                    <input type="date" name="DATE_DEBUT" autocomplete="off" id="DATE_DEBUT" value="<?=$membre['dateDebut']
                     ?>"  class="form-control" required>
                    
                   

                  </div>
                 
                    <div class="col-md-6">
                    <label for="FName">DATE FIN</label>
                    <input type="date" name="DATE_FIN" autocomplete="off" id="DATE_FIN" value="<?=$membre['dateFin'] ?>"   class="form-control" required>
                    
                    <?php echo form_error('CNI', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                    <div class="col-md-6">
                      <label for="Ftype">Province</label>
                      <select class="form-control" name="ID_PROVINCE" id="ID_PROVINCE" onchange="get_communes();">
                        <!-- <option value="">---Sélectionner---</option> -->
                        <?php

                        foreach ($provinces as $value) {

                          $selected = "";
                          if ($value['PROVINCE_ID'] == $membre['PROVINCE_ID']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['PROVINCE_ID'] ?>" <?= $selected ?>><?= $value['PROVINCE_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <div>
                        <font color="red" id="error_province"></font>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <label for="Ftype">Commune</label>
                      <select class="form-control" name="ID_COMMUNE" id="ID_COMMUNE" onchange="get_zones();">
                        <!-- <option value="">---Sélectionner---</option> -->
                        <?php
                        foreach ($communes as $key) {
                          $selected = "";
                          if ($key['COMMUNE_ID'] == $membre['COMMUNE_ID']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $key['COMMUNE_ID'] ?>" <?= $selected ?>><?= $key['COMMUNE_NAME'] ?>
                            
                          </option>
                        <?php
                        }
                        ?>
                      </select>
                      <div>
                        <font color="red" id="error_commune"></font>
                      </div>
                    </div>
                    <?php if($membre['CODE_PROFIL']==21 || $membre['CODE_PROFIL']==22 || $membre['CODE_PROFIL']==20) { ?>

                    <div class="col-md-6">
                      <label for="Ftype">Zone</label>
                      <select class="form-control" name="ID_ZONE" id="ID_ZONE" onchange="get_collines();">
                        <!-- <option value="">---Sélectionner---</option> -->
                        <?php
                        foreach ($zones as $key) {
                          $selected = "";
                          if ($key['ZONE_ID'] == $membre['ZONE_ID']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $key['ZONE_ID'] ?>" <?= $selected ?>><?= $key['ZONE_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <div>
                        <font color="red" id="error_zone"></font>
                      </div>
                    </div>
                    <?php
                        }
                        if($membre['CODE_PROFIL']==22 ||$membre['CODE_PROFIL']==20){
                        ?>
                    <div class="col-md-6">
                      <label for="Ftype">Colline</label>
                      <select class="form-control" name="ID_COLLINE" id="ID_COLLINE" onchange="get_avenues();">
                        <!-- <option value="">---Sélectionner---</option> -->
                        <?php
                        foreach ($collines as $key) {
                          $selected = "";
                          if ($key['COLLINE_ID'] == $membre['COLLINE_ID']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $key['COLLINE_ID'] ?>" <?= $selected ?>><?= $key['COLLINE_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <div>
                        <font color="red" id="error_colline"></font>
                      </div>

                    </div>
                    <?php
                        }
                        if($membre['CODE_PROFIL']==20){

                        ?>
                      <div class="col-md-6">
                      <label for="Ftype">Avenue</label>
                       <select class="form-control" name="ID_AVENUE" id="ID_AVENUE" onchange="getAutreAvenue(this.value)">
                        <!-- <option value="">---Sélectionner---</option> -->
                        <?php
                        foreach ($avenues as $key) {
                          $selected = "";
                          if ($key['ID_AVENUE'] == $membre['ID_AVENUE']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $key['AVENUE_ID'] ?>" <?= $selected ?>><?= $key['AVENUE_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <div>
                        <font color="red" id="error_colline"></font>
                      </div>
                      <div id="autre_description" class="col-md-6 row" style="display:none">
                     
                      <input type="text" class="form-control col-md-10" id="AVENUE_NAME" placeholder="Autre serie" name="AVENUE_NAME"><span class="col-md-1"></span>
                      <button type="button" class="btn btn-outline-success btn-sm  float-right  col-md-1" onclick="save_newAvenue()"><i class="nav-icon fas fa-plus"></i></button>
                    </div>
                    </div>
                    <?php
                        }
                        ?>
                  <div class="col-md-6" style="margin-top:31px;">
                    <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
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
        </div><script>
  function get_communes() {
    var ID_PROVINCE = $('#ID_PROVINCE').val();
    if (ID_PROVINCE == '') {
      $('#ID_COMMUNE').html('<option value="">---Sélectionner---</option>');
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>menage/Chefs_menage/get_communes/" + ID_PROVINCE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COMMUNE').html(data);
        }
      });

    }
  }

  function get_zones() {
    var ID_COMMUNE = $('#ID_COMMUNE').val();
    if (ID_COMMUNE == '') {
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>menage/Chefs_menage/get_zones/" + ID_COMMUNE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_ZONE').html(data);
        }
      });

    }
  }


  function get_collines() {
    var ID_ZONE = $('#ID_ZONE').val();
    if (ID_ZONE == '') {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>menage/Chefs_menage/get_collines/" + ID_ZONE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COLLINE').html(data);
        }
      });

    }
  }
  function get_avenues(ID_AVENUE=0){
    var ID_COLLINE = $('#ID_COLLINE').val();
    if (ID_COLLINE == '') {
      $('#ID_AVENUE').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>menage/Chefs_menage/get_avenues/" + ID_COLLINE+"/"+ID_AVENUE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_AVENUE').html(data);
        }
      });

    }
  }
  function getAutreAvenue(id = 0){
  if (id == 0) {
    $('#autre_description').show()
  }else{
     $('#autre_description').hide()
  }

}
 function save_newAvenue(){
   var AVENUE_NAME = $('#AVENUE_NAME').val();
   if (ID_COLLINE == "") {
    $('#ID_COLLINE').css('border-color','red');
  }else if (AVENUE_NAME == "") {
    $('#ID_COLLINE').css('border-color','green');
    $('#AVENUE_NAME').css('border-color','red');
  }else{
    $('#ID_COLLINE').css('border-color','green');
    $('#AVENUE_NAME').css('border-color','green');

    var ID_COLLINE = $('#ID_COLLINE').val();
    var AVENUE_NAME = $('#AVENUE_NAME').val();

    var dataU = new FormData();
    dataU.append('ID_COLLINE',ID_COLLINE);
    dataU.append('AVENUE_NAME',AVENUE_NAME);
    $.ajax({
      url : "<?= base_url() ?>menage/Chefs_menage/save_avenue",
      type : "POST",
      dataType: "JSON",
      data : dataU,
      processData: false,
      contentType: false,
      success:function(data) {
        $('#AVENUE_NAME').val("");
        get_avenues(data.id)
        $('#autre_description').hide()
      },
    });
  }

}

</script>
      </body>

  <script>
  function get_communes() {
    var ID_PROVINCE = $('#ID_PROVINCE').val();
    if (ID_PROVINCE == '') {
      $('#ID_COMMUNE').html('<option value="">---Sélectionner---</option>');
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>menage/Chefs_menage/get_communes/" + ID_PROVINCE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COMMUNE').html(data);
        }
      });

    }
  }

  function get_zones() {
    var ID_COMMUNE = $('#ID_COMMUNE').val();
    if (ID_COMMUNE == '') {
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>menage/Chefs_menage/get_zones/" + ID_COMMUNE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_ZONE').html(data);
        }
      });

    }
  }


  function get_collines() {
    var ID_ZONE = $('#ID_ZONE').val();
    if (ID_ZONE == '') {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>menage/Chefs_menage/get_collines/" + ID_ZONE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COLLINE').html(data);
        }
      });

    }
  }

  function get_lieux() {
   var CODE_PROFIL = Number($('#CODE_PROFIL').val());
    //CHEF DE ZONE
    if(CODE_PROFIL==21)
    {
       $('#zone').show()
       $('#colline').hide()
       $('#avenue').hide()

       $('#ID_ZONE').prop('required',true)
       $('#ID_COLLINE').prop('required',false)
       $('#ID_AVENUE').prop('required',false)
    }
    //CHEF DE QUARTIER
    else if(CODE_PROFIL==22)
    {
       $('#zone').show()
       $('#colline').show()
       $('#avenue').hide()

       $('#ID_ZONE').prop('required',true)
       $('#ID_COLLINE').prop('required',true)
       $('#ID_AVENUE').prop('required',false)
    }
    //CHEF DE SECTEUR
    else if(CODE_PROFIL==20)
    {
      $('#zone').show()
       $('#colline').show()
       $('#avenue').show()

       $('#ID_ZONE').prop('required',true)
       $('#ID_COLLINE').prop('required',true)
       $('#ID_AVENUE').prop('required',true)
    }
  }
</script>

      <?php include VIEWPATH.'templates/footer.php'; ?>


    