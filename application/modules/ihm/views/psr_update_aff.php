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
          <a href="<?=base_url('ihm/Psr_element_affectation/index')?>" class='btn btn-primary float-right'>
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

<form  name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Psr_element_affectation/updateData'); ?>" >

                

               <div class="row">

                   <div class="col-md-6">
                    <label for="Ftype">Agents PNB</label>
          <select required class="form-control" name="ID_PSR_ELEMENT" id="ID_PSR_ELEMENT" required>
                      <option value="">---Sélectionner---</option>
                      <?php
                      foreach ($polices as $value){  
                         if ($donne['ID_PSR_ELEMENT'] == $value['ID_PSR_ELEMENT']) { ?>
                         <option selected value="<?=$value['ID_PSR_ELEMENT']?>" ><?=$value['PNB']?></option>
                         <?php }else{ ?>
                          <option value="<?=$value['ID_PSR_ELEMENT']?>"><?=$value['PNB']?></option>
                        <?php  } }  ?>
                     
                      
                    </select>
                    <!-- <div><font color="red" id="error_province"></font></div>  -->
                    <?php echo form_error('PNB', '<div class="text-danger">', '</div>'); ?>
                  </div>




                     <div class="col-md-6">
                    <label for="Ftype">LIEU</label>
          <select required class="form-control" name="PSR_AFFECTATION_ID" id="PSR_AFFECTATION_ID" required>
                      <option value="">---Sélectionner---</option>
                      <?php
                      foreach ($postes as $value){  
                         if ($donne['PSR_AFFECTATION_ID'] == $value['PSR_AFFECTATION_ID']) { ?>
                         <option selected value="<?=$value['PSR_AFFECTATION_ID']?>" ><?=$value['LIEU_EXACTE']?></option>
                         <?php }else{ ?>
                          <option value="<?=$value['PSR_AFFECTATION_ID']?>"><?=$value['LIEU_EXACTE']?></option>
                        <?php  } }  ?>
                     
                    </select>
                    <!-- <div><font color="red" id="error_province"></font></div>  -->
                    <?php echo form_error('PSR_AFFECTATION_ID', '<div class="text-danger">', '</div>'); ?>
                  </div>
                 

        
                    <div class="col-md-6">
                    <label for="FName">DATE DEBUT</label>
                    <input type="date" name="DATE_DEBUT" autocomplete="off" id="DATE_DEBUT" value="<?= $donne['DATE_DEBUT'] ?>"  class="form-control" required>
                    
                

                  </div>


  <input type="hidden" name="ELEMENT_AFFECT_ID" value="<?=$donne['ELEMENT_AFFECT_ID']?>">
                 
                    <div class="col-md-6">
                    <label for="FName">DATE FIN</label>
                    <input type="date" name="DATE_FIN" autocomplete="off" id="DATE_FIN" value="<?= $donne['DATE_FIN'] ?>"  class="form-control" required>
                    
                    <?php echo form_error('CNI', '<div class="text-danger">', '</div>'); ?> 

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


