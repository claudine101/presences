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
              <a href="<?=base_url('ihm/Gestion_Publication_Menu/index')?>" class='btn btn-primary float-right'>
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

               <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Gestion_Publication_Menu/add'); ?>" >
                <div class="row">
                
                  <div class="col-md-6">
                    <label>CATEGORIES</label>
                    <select class="form-control" name="ID_CATEGORIE" id="ID_CATEGORIE">
                          
                          <option value="">Sélectionner</option>
                          <?php 
                          foreach ($marque as $key_marque) 
                          {
                            if ($key_marque['ID_CATEGORIE']==set_value('ID_CATEGORIE')) 
                              {?>
                                <option value="<?= $key_marque['ID_CATEGORIE'] ?>" selected=''><?= $key_marque['NOM_CATEGORIE'] ?></option>
                              <?php } else {?>
                                <option value="<?= $key_marque['ID_CATEGORIE'] ?>"><?= $key_marque['NOM_CATEGORIE'] ?></option>
                                <?php 
                              }
                            }

                            ?>

                          </select>
                          <?php echo form_error('ID_CATEGORIE', '<div class="text-danger">', '</div>'); ?> 
                  </div>

                   <div class="col-md-6">
                    <label for="FName">MENUS</label>
                    <input type="text" name="NOM_MENU" autocomplete="off" id="NOM_MENU" value="<?= set_value('NOM_MENU') ?>"  class="form-control">
                    
                    <?php echo form_error('NOM_MENU', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                  </div>
                

               <div class="row">
                  <div class="col-md-6">
                  <label for="FName">DESCRIPTION</label>
                    <input type="text" name="DESCRIPTION" autocomplete="off" id="DESCRIPTION" value="<?= set_value('DESCRIPTION') ?>"  class="form-control">
                    
                    <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                  <div class="col-md-6 row">
                     <div class="col-md-6">
                    <label for="text" style="font-size: 10px;" id="fileName"></label></BR>
                  <label class="label" data-toggle="tooltip" title="Attacher un fichier">
                        <font style="font-size: 40PX;color: green" ><i class="fas fa-image rounded" id="avatar" alt="avatar"></i></font>
                        <input type="file" class="sr-only" id="PHOTO" name="PHOTO" accept="image/*" required>
                  </label>
                  </div>
                  <div class="col-md-6" style="margin-top: 5px" id="resultGet"></div>
                  
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
