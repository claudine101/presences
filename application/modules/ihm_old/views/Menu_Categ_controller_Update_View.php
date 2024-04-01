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
              <a href="<?=base_url('ihm/Menu_Categ_controller/index')?>" class='btn btn-primary float-right'>
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

 <form  method="POST" enctype="multipart/form-data"  action="<?= base_url('ihm/Menu_Categ_controller/update'); ?>" >
                <div class="row">
<input type="hidden" name="ID_CATEGORIE" 
          value="<?=$data['ID_CATEGORIE']?>"  id="ID_CATEGORIE" class="form-control">

            <div class="col-md-6">
            <label for="FName">categories</label>
          <input type="text" name="NOM_CATEGORIE" 
          value="<?=$data['NOM_CATEGORIE'] ?>"  id="NOM_CATEGORIE" class="form-control">

             <?php echo form_error('NOM_CATEGORIE', '<div class="text-danger">', '</div>'); ?> 

            </div>



                   <div class="col-md-6">

                     <div class="col-md-6">

                    <!--   <input type="file" name="PHOTO_UNE" id="PHOTO"> -->
                    <label for="text" style="font-size: 10px;" id="fileName"></label></BR>
                  <label class="label" data-toggle="tooltip" title="Attacher un fichier">
                        <font style="font-size: 40PX;color: green" ><i class="fas fa-image rounded" id="avatar" alt="avatar"></i></font>
                        <input type="file" class="sr-only" id="PHOTO_UNE" name="PHOTO_UNE" accept="image/*" required>
                       

                  </label>

                    
                   </div>
                 
                  <div class="col-md-6" style="margin-top: 5px" id="resultGet"><img  height="80" src="<?=$data['IMAGE'] ?>"></div>
                  
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

  $("#PHOTO_UNE").change(function() {
   readURL(this);
  });

</script>


<?php include VIEWPATH.'templates/footer.php'; ?>


