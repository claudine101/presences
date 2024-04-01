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

<form  name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Psr_element_affectation/add'); ?>" >

<style type="text/css">
  

.select2-container--default .select2-selection--multiple .select2-selection__choice {
  color: #434393;

}

.select2-container--default .select2-selection--single .select2-selection__rendered {
  color: #444;
  line-height: 20px;
}

/*.select2-container .select2-selection--single {
  box-sizing: border-box;
  cursor: pointer;
  display: block;
  height: 30px;
  user-select: none;
  -webkit-user-select: none;
}*/

</style>

                

               <div class="row">

                   <div class="col-md-6">
                    <label for="Ftype">Agents PNB</label>
          <select class="form-control select2"   name="ID_PSR_ELEMENT[]" id="ID_PSR_ELEMENT"  multiple="multiple" required>
                      <option value="">---Sélectionner---</option>
                      <?php
                      foreach ($polices as $value)
                      {
                        ?>
                         <option value="<?=$value['ID_PSR_ELEMENT']?>"><?=$value['PNB']?></option>
                        <?php
                      }
                      ?>
                    </select>

                  </div>
    <script type="text/javascript">
        $(document).ready(function() {
            let $select = $('#ID_PSR_ELEMENT').multiselect({
              includeSelectAllOption: false,
              enableFiltering: true,
              includeFilterClearBtn: true,
              enableCaseInsensitiveFiltering: true
            });

            $select.multiselect('select', ['1', '3']);
       });

      </script>



                     <div class="col-md-6">
                    <label for="Ftype">LIEU</label>
          <select required class="form-control select2" name="PSR_AFFECTATION_ID" id="PSR_AFFECTATION_ID" required>
                      <option value="">---Sélectionner---</option>
                      <?php
                      foreach ($postes as $value)
                      {
                        ?>
        <option value="<?=$value['PSR_AFFECTATION_ID']?>"><?=$value['LIEU_EXACTE']?></option>
                        <?php
                      }
                      ?>
                    </select>

                  </div>
                 

                 
                    <div class="col-md-6">
                    <label for="FName">DATE DEBUT</label>
                    <input type="datetime-local" name="DATE_DEBUT" min="2018-06-07T00:00" id="DATE_DEBUT" value="<?= set_value('DATE_DEBUT') ?>"  class="form-control" required>
                    
                   

                  </div>

                

                 
                    <div class="col-md-6">
                    <label for="FName">DATE FIN</label>
                    <input type="datetime-local" name="DATE_FIN" autocomplete="off" id="DATE_FIN" value="<?= set_value('DATE_FIN') ?>"  class="form-control" required>
                    
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


    