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
              <a href="<?=base_url('PSR/Signalement_embouteillage/index')?>" class='btn btn-primary float-right'>
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
                <!--  -->


                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Signalement_embouteillage/update'); ?>" >
                 <div class="row">
                  <input type="hidden" class="form-control" name="ID_AMBOUTEILLAGE" value="<?=$datas['ID_AMBOUTEILLAGE']?>" >


                   <div class="col-md-6">
                      <label for="Ftype">Route</label>
                      <select class="form-control" name="ID_CHAUSSEE" id="ID_CHAUSSEE">
                        
                        <?php

                        foreach ($chausses as $value)
                        {

                          $selected="";
                          if($value['ID_CHAUSSEE']==$questions['ID_CHAUSSEE'])
                          {
                            $selected="selected";
                          }
                          ?>
                          <option value="<?=$value['ID_CHAUSSEE']?>" <?=$selected?>><?=$value['NOM_CHAUSSE']?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('ID_CHAUSSEE', '<div class="text-danger">', '</div>'); ?> 

                    </div>

                  <div class="col-md-6">
                    <label for="FName">CAUSE</label>
                    <input type="text" name="CAUSE" autocomplete="off" id="CAUSE" 
                    value="<?= $datas['CAUSE'] ;?>"  class="form-control">
                    
                    <?php echo form_error('CAUSE', '<div class="text-danger">', '</div>'); ?> 

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

 $("#IMAGE_1").change(function() {
   readURL(this);
 });

</script>

