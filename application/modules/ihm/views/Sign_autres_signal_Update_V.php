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
              <a href="<?=base_url('ihm/Sign_autres_signal/index')?>" class='btn btn-primary float-right'>
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


      <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Sign_autres_signal/update'); ?>" >
                 <div class="row">
<input type="hidden" class="form-control" name="ID_AUTRES_SIGNQLEMENT"value="<?=$datas['ID_AUTRES_SIGNQLEMENT']?>" >


                   
                   <div class="col-md-6">

                    <label>NOM</label>
                    <select class="form-control" name="NOM" id="ID_UTILISATEUR">
                      <?php
                      foreach ($users as  $value) {

                        if ($value['ID_UTILISATEUR']==$datas['USER_ID']) {
                          # code...
                          echo "<option value=".$value['ID_UTILISATEUR']." selected>".$value['NOM']."</option>";
                        }else{
                         echo "<option value=".$value['ID_UTILISATEUR'].">".$value['NOM']."</option>";
                       }
                       
                     }
                     ?>
                   </select>
                   
                   <?php echo form_error('ID_UTILISATEUR', '<div class="text-danger">', '</div>'); ?>                   
                 </div>



                  <div class="col-md-6">
                    <label for="FName">DESCRIPTION</label>
                    <input type="text" name="DESCRIPTION" autocomplete="off" id="DESCRIPTION" 
                    value="<?=$datas['DESCRIPTION'] ;?>"  class="form-control">
                    
                    <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                 

              </div>

              <div class="col-md-12" style="margin-top:31px;">
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

