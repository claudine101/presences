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
              <a href="<?=base_url('PSR/Declaration_Vol/index')?>" class='btn btn-primary float-right'>
                <i class="nav-icon fas fa-list ul"></i>
                Liste
              </a>
            </div><!-- /.col -->
          </div>
        </div><!-- /.container-fluid -->
      </section>

     
  <div id="vehicule" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <div id="title"><b><h4 id="vehicule_titre" style="color:#fff;font-size: 18px;"></h4></b>
              
            </div>
            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
         <div class="modal-body">
          <div  id="vehiculedata">
      
          </div>
            
             

       <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
    </div>
  </div>
</div>
</div>



      <!-- Main content -->
      <section class="content">
        <div class="col-md-12 col-xl-12 grid-margin stretch-card">

          <div class="card">
            <div class="card-body">

              <div class="col-md-12">

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Declaration_Vol/add'); ?>" >

                 <div class="row">
                   <div class="col-md-6">
                    <label for="Ftype">Plaque</label>
                     <input onkeyup="get_concerne()" type="text" name="NUMERO_PLAQUE"  id="NUMERO_PLAQUE" value="<?= set_value('NUMERO_PLAQUE') ?>" class="form-control" required>
                   
                      <!-- <div><font color="red" id="error_province"></font></div>  -->
                      <?php echo form_error('NUMERO_PLAQUE', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <div class="col-md-6">
                    <label for="FName">Nom du déclarant</label>
                    <input type="text" name="NOM_DECLARANT" autocomplete="off" id="NOM_DECLARANT" value="<?= set_value('NOM_DECLARANT') ?>"  class="form-control">
                    
                    <?php echo form_error('NOM_DECLARANT', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> Prenom du déclarant</label>
                    <input type="text" name="PRENOM_DECLARANT" autocomplete="off" id="PRENOM_DECLARANT" value="<?= set_value('PRENOM_DECLARANT') ?>"  class="form-control">
                    
                    <?php echo form_error('PRENOM_DECLARANT', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName">  Couleur </label>
                    <input type="text" name="COULEUR_VOITURE" autocomplete="off" id="COULEUR_VOITURE" value="<?= set_value('COULEUR_VOITURE') ?>"  class="form-control">
                    
                    <?php echo form_error('COULEUR_VOITURE', '<div class="text-danger">', '</div>'); ?> 
                  </div>

                  <div class="col-md-6">
                    <label for="FName"> Marque</label>
                    <input type="text" name="MARQUE_VOITURE" autocomplete="off" id="MARQUE_VOITURE" value="<?= set_value('MARQUE_VOITURE') ?>"  class="form-control">
                    
                    <?php echo form_error('MARQUE_VOITURE', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="FName"> Date du vol</label>
                    <input type="date" name="DATE_VOLER" autocomplete="off" id="DATE_VOLER" value="<?= set_value('DATE_VOLER') ?>"  class="form-control">
                    
                    <?php echo form_error('DATE_VOLER', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                </div>
                <div id='concernediv' style="margin-top:35px;">
                  
                 </div>
                <div class="col-md-6" style="margin-top:31px;">
                  <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
                </div>
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
function get_concerne(){
    var NUMERO_PLAQUE=  $('#NUMERO_PLAQUE').val();
    if(NUMERO_PLAQUE.length>=6){
        $.ajax({
          url : "<?php echo base_url('PSR/Declaration_Vol/get_concerne'); ?>",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {NUMERO_PLAQUE:NUMERO_PLAQUE},
          beforeSend:function () { 
            $('#concernediv').html('<center><font color="#000"><i class="fas fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span></font></center>');
          },
          success:function(data) {



           $('#concernediv').html(data);
           //$('#perdoTitre').html(data.titres);
          
          },
          error:function() {
            $('#concernediv').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher cette page! Veuillez réessayer</div>');
          }
      });
   }

}
function show_vehicule(NUMERO_PLAQUE=0){
       var NUMERO_PLAQUE= NUMERO_PLAQUE;
       DATE1=  $('#DATE1').val();
       DATE2=  $('#DATE2').val();
       if(NUMERO_PLAQUE==0)
       {
        NUMERO_PLAQUE=  $('#NUMERO_PLAQUE').val();
       }
       
      $('#vehicule').modal()
      $("#vehicule_titre").html("Tableau de bord de la plaque "+NUMERO_PLAQUE);
      $.ajax({
          url : "<?php echo base_url('Vehicule/show_vehicule'); ?>",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: { NUMERO_PLAQUE:NUMERO_PLAQUE,
                  DATE1:DATE1,
                  DATE2:DATE2},
          beforeSend:function () { 
            
             $('#vehiculedata').html('<center><font color="#000"><i class="fas fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span></font></center>');
          },
          success:function(data) {
            console.log(data)
           $('#vehiculedata').html(data.detail);
          },
          error:function() {
            $('#vehiculedata').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher cette page! Veuillez réessayer</div>');
          }
      });
       
   }
</script>


