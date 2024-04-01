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
              <a href="<?=base_url('PSR/Psr_elements/index')?>" class='btn btn-primary float-right'>
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

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Psr_elements/add'); ?>" >
                  
                 <div class="row">
                  <div class="col-md-6">
                    <label for="FName">Nom</label>
                    <input type="text" name="NOM" autocomplete="off" id="NOM" value="<?= set_value('NOM') ?>"  class="form-control">
                    
                    <?php echo form_error('NOM', '<div class="text-danger">', '</div>'); ?> 

                  </div>


                  <div class="col-md-6">
                    <label for="FName">Prenom</label>
                    <input type="text" name="PRENOM" autocomplete="off" id="PRENOM" value="<?= set_value('PRENOM') ?>"  class="form-control">  
                    <?php echo form_error('PRENOM', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                  <div class="col-md-6">
                    <label for="FName">Matricule</label>
                    <input type="text" name="NUMERO_MATRICULE" autocomplete="off" id="NUMERO_MATRICULE" value="<?= set_value('NUMERO_MATRICULE') ?>"  class="form-control">
                    
                    <?php echo form_error('NUMERO_MATRICULE', '<div class="text-danger">', '</div>'); ?> 

                  </div>


                  <div class="col-md-6">
                    <label for="Ftype">Province</label>
                     <select required class="form-control" name="ID_PROVINCE" id="ID_PROVINCE" onchange="get_communes();">
                          <option value="">---Sélectionner---</option>
                          <?php
                            foreach ($provinces as $value)
                            {
                          ?>
                          <option value="<?=$value['PROVINCE_ID']?>"><?=$value['PROVINCE_NAME']?></option>
                          <?php
                            }
                          ?>
                        </select>
                    <!-- <div><font color="red" id="error_province"></font></div>  -->
                    <?php echo form_error('ID_PROVINCE', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="col-md-6">
                    <label for="Ftype">Commune</label>
                    <select required class="form-control" name="ID_COMMUNE" id="ID_COMMUNE" onchange="get_zones();">
                          <option value="">---Sélectionner---</option>
                        </select>
                        <!-- <div><font color="red" id="error_commune"></font></div> -->
                        <?php echo form_error('ID_COMMUNE', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="col-md-6">
                    <label for="Ftype">Zone</label>
                  <select class="form-control" name="ID_ZONE" id="ID_ZONE" onchange="get_collines();">
                          <option value="">---Sélectionner---</option>
                        </select>
                        <!-- <div><font color="red" id="error_zone"></font></div> -->
                        <?php echo form_error('ID_ZONE', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="col-md-6">
                    <label for="Ftype">Colline</label>
                    <select class="form-control" name="ID_COLLINE" id="ID_COLLINE">
                          <option value="">---Sélectionner---</option>
                        </select>
                        <!-- <div><font color="red" id="error_colline"></font></div> --> 
                         <?php echo form_error(' ID_COLLINE', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <div class="col-md-6">
                    <label for="FName">Telephone</label>
                    <input type="tel" name="  TELEPHONE" autocomplete="off" id="  TELEPHONE" value="<?= set_value(' TELEPHONE') ?>"  class="form-control">
                    
                    <?php echo form_error(' TELEPHONE', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                  <div class="col-md-6">
                    <label for="FName"> Email</label>
                    <input type="text" name="EMAIL" autocomplete="off" id="EMAIL" value="<?= set_value('EMAIL') ?>"  class="form-control">
                    
                    <?php echo form_error('EMAIL', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="Ftype">Profil</label>
                     <select required class="form-control" name="PROFIL_ID" id="PROFIL_ID" >
                          <option value="">---Sélectionner---</option>
                          <?php
                            foreach ($profils as $value)
                            {
                          ?>
                          <option value="<?=$value['PROFIL_ID']?>"><?=$value['STATUT']?></option>
                          <?php
                            }
                          ?>
                        </select>
                    <!-- <div><font color="red" id="error_province"></font></div>  -->
                    <?php echo form_error('PROFIL_ID', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <div class="col-md-6">
                    <label for="FName">Latitude</label>
                    <input type="text" name="LATITUDE" autocomplete="off" id="LATITUDE" value="<?= set_value('LATITUDE') ?>"  class="form-control">
                    
                    <?php echo form_error('LATITUDE', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> Longitude</label>
                    <input type="text" name="LONGITUDE" autocomplete="off" id="LONGITUDE" value="<?= set_value('LONGITUDE') ?>"  class="form-control">
                    
                    <?php echo form_error('LONGITUDE', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                </div>

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
        </div>
      </body>

      <?php include VIEWPATH.'templates/footer.php'; ?>



<script>
  get_test()

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

  //  function get_test()
  // {
  //    alert()
   
  //     $.ajax(
  //     {
  //       url:"https://api.eacpass.eac.int/data-integration/api/check",
  //       type:"GET",
  //       dataType:"JSON",
  //       success: function(data)
  //       {


  //         console.log(data)
  //       }
  //     });

    
  // }
</script>