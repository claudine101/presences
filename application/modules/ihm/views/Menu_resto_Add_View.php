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
              <a href="<?=base_url('ihm/Menu_restaurants/index')?>" class='btn btn-primary float-right'>
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

              <div class="col-md-12 ">

               <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Menu_restaurants/add'); ?>" >
                <div class="row">
               

                  <div class="col-md-2">
                    <label for="FName">Vendeur</label>

                    <select class="form-control" name="ID_RESTAURANT" id="ID_RESTAURANT" onchange="liste()">    
                      <option value="">-----Sélectionner----</option>
                      <?php 
                      foreach ($restaurants as $key_menu) 
                      {
                        if ($key_menu['ID_RESTAURANT'] == $this->session->userdata('ID_RESTAURANT')) 
                          {?>
                            <option value="<?= $key_menu['ID_RESTAURANT'] ?>" selected=''><?= $key_menu['NOM_RESTAURANT'] ?></option>
                          <?php } else {?>
                            <option value="<?= $key_menu['ID_RESTAURANT'] ?>"><?=$key_menu['NOM_RESTAURANT'] ?></option>
                            <?php 
                          }
                        }

                        ?>

                      </select>

                      <?php echo form_error('ID_RESTAURANT', '<div class="text-danger">', '</div>'); ?> 

                    </div>



                  <div class="col-md-3">
                    <label for="FName">Catégorie</label>

                    <select class="form-control" name="ID_CATEGORIE" id="ID_CATEGORIE" onchange="liste('CATEGO')">  

                      <option value="" selected>Sélectionner-</option>

                    <?php 
                      foreach ($menu_categories as $key_menu) { ?>

                        <option value="<?= $key_menu['ID_CATEGORIE'] ?>"><?= $key_menu['NOM_CATEGORIE'] ?></option>

                      <?php  }  ?>

                      </select>

                      <?php echo form_error('ID_CATEGORIE', '<div class="text-danger">', '</div>'); ?> 

                    </div>



                  <div class="col-md-3">
                    <label for="FName">Aricle/Menu</label>

                      <select class="form-control" name="ID_MENU" id="ID_MENU" onchange="liste()">    
                        <option value="">-----Sélectionner----</option>
                     
                      </select>

                      
                    </div>


                    <div class="col-md-2">
                    <label for="FName">PU HTVA</label>

                      <input type="number" name="PRIX" class="form-control"  id="PRIX">    
                        
                    </div>


                    <div class="col-md-2" style="margin-top:31px;">
                       <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-okay"></span>Enregistrer</button>
                     </div>

                  </div>


              </div>

            </div>
          </div>
          
      </form>

      </div>

      <div class="col-md-12 col-xl-12 grid-margin stretch-card">

     <div class="card">
            
      <div class="card-body">

      <div class="col-md-12">
      <?=  $this->session->flashdata('message');?>
      <div class="table-responsive">
      <table id='reponse1' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
      <thead>
        <tr>
          <td>Image</td>
          <td>Catégorie</td>
          <td>Aricle/Menu</td>
          <td>Prix HTV</td>
          <td>OPTIONS</td>
        </tr>
      </thead>
      </table>
     </div>

      </div>
     </div>

                        <!-- <div class="row">
                          
                        </div> -->
                   

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
 $(document).ready(function(){
    liste();
     
    });




 function get_categorie(id=0){
  //alert(id);
   $.ajax({
        url : "<?=base_url()?>ihm/Menu_restaurants/get_categorie/"+id,
        type : "POST",
        success:function(data) {
            $('#ID_MENU').html(data)     
        }  

    });
}
 </script>
<!-- ID_RESTAURANT
ID_CATEGORIE
ID_MENU -->
<script type="text/javascript">
function liste(donne=0) 
{  
  if (donne == 'CATEGO') {
    get_categorie($('#ID_CATEGORIE').val());
  }

  $('#message').delay('slow').fadeOut(3000);
   $("#reponse1").DataTable({
    "destroy" : true,
    "processing":true,
    "serverSide":true,
    "oreder":[],
    "ajax":{
      url: "<?php echo base_url('ihm/Menu_restaurants/listing/');?>", 
      type:"POST",
      data : { ID_RESTAURANT : $('#ID_RESTAURANT').val(),
               ID_CATEGORIE : $('#ID_CATEGORIE').val(),
               ID_MENU  : $('#ID_MENU').val()
             },
      beforeSend : function() {
      }
    },
    lengthMenu: [[10,50, 100, -1], [10,50, 100, "All"]],
    pageLength: 10,
    "columnDefs":[{
      "targets":[],
      "orderable":false
    }],
    dom: 'Bfrtlip',
    buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print'  ],
    language: {
      "sProcessing":     "Traitement en cours...",
      "sSearch":         "Rechercher&nbsp;:",
      "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
      "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      "sInfoPostFix":    "",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
      "oPaginate": {
        "sFirst":      "Premier",
        "sPrevious":   "Pr&eacute;c&eacute;dent",
        "sNext":       "Suivant",
        "sLast":       "Dernier"
      },
      "oAria": {
        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
      }
    }
  });


 }
</script>