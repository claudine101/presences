<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>

<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
           <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

<style type="text/css">
.mapbox-improve-map {
  display: none;
}

.leaflet-control-attribution {
  display: none !important;
}

.leaflet-control-attribution {
  display: none !important;
}


.mapbox-logo {
  display: none;
}

a
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include VIEWPATH . 'templates/navbar.php'; ?>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include VIEWPATH . 'templates/sidebar.php'; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-4">
              <h4 class="m-0"><?= $title ?></h4>
            </div><!-- /.col -->
            
            
            <div class="col-sm-8 text-right">
              <span style="margin-right: 15px">
                <div class="row">
                  <div class="col-md-3">
                       
                      <select required class="form-control" name="ID_ASSUREUR1" id="ID_ASSUREUR1" onchange="liste()">
                        <option value="">Assureurs---</option>
                        <?php
                        foreach ($assurances as $value) {
                        ?>
                          <option value="<?= $value['ID_ASSUREUR'] ?>"><?= $value['ASSURANCE'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                      <div class="col-md-4">
                           <button type="button" class="btn btn-primary btn-sm float-right"  data-toggle="modal" data-target="#myModal">
                              Importation fichier assurance
                            </button>
                      </div>
                      <div class="col-md-3">
                            <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#myControle">
                               Contrôle rapide
                           </button>
                      </div>
                      <div class="col-md-2">
                           <?php if ($this->session->userdata('PROFIL_ID') != 2){ ?>
                            <a href="<?= base_url('PSR/Assurances/ajouter') ?>" style="width: 100px;" class='btn btn-primary btn-sm float-right'>
                              <i class="nav-icon fas fa-plus"></i>
                              Nouveau
                            </a>
                          <?php } ?>
                      </div>
                  </div>
               <!-- MODAL POUR  I?PORTATION DE FICHIER EXCEL -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <form action="<?= base_url() ?>PSR/Assurances/add_excel"; method="post"  enctype="multipart/form-data" id='myformExcel'>
                        <div class="modal-header" style="background: black;">
                            <div id="title"><b><h4 style="color:#fff;font-size: 18px;">Importation fichier assurances</h4></b></div>
                            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                            </div>
                        </div>
                        <div class="modal-body col-lg-12 col-md-12 col-sm-12">


                          <div class="row">

                               <div class="col-lg-6 col-md-6">
                      
                                  <select required class="form-control" name="ID_ASSUREUR" id="ID_ASSUREUR" onchange="liste()">
                                    <option value="">Assureurs---</option>
                                    <?php
                                    foreach ($assurances as $value) {
                                    ?>
                                      <option value="<?= $value['ID_ASSUREUR'] ?>"><?= $value['ASSURANCE'] ?></option>
                                    <?php
                                    }
                                    ?>
                                  </select>
                    
                               </div>

                            <div class="col-lg-6 col-md-6 col-sm-12" id="form1">
                              <input type="file" name="FICHIER" id="FICHIER" class="form-control" required>
                              <div><?php echo form_error('IMEI');?></div>
                            </div>
                          </div>  
                          <!-- <div class="form-group col-lg-12">
                            <div class="col-lg-6 col-lg-offset-4 col-md-8 col-md-offset-4 col-sm-12"  style="margin-top:5px">
                            </div>
                          </div> -->                    

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                          <button type='submit' class="btn btn-primary" name="submitEtudiant"> Enregistrer</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- MODAL POUR FAIRE UN CONTROLE RAPIDE -->

                <div class="modal fade" id="myControle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div  class="modal-dialog" role="document">
                    <div class="modal-content">
                      <form action="<?= base_url() ?>PSR/Obr_immatricUlation/controle_rapide"; method="post"  enctype="multipart/form-data" id='myform_controle'>
                        <div class="modal-header" style="background: black;">
                            <div id="title"><b><h4 style="color:#fff;font-size: 18px;">Contrôle rapide</h4></b></div>
                            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                            </div>
                        </div>
                        <div  id="concernediv" class="modal-body">
                          <div class="form-group col-lg-12"><div class="col-lg-12 col-md-12 col-sm-12 form-group" id="form1">
                              <input type="text" name="NUMERO_PLAQUE" id="NUMERO_PLAQUE" class="form-control" placeholder="Numéro Plaque">
                              <div><?php echo form_error('IMEI');?></div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button id="idbutton" type='button' onclick='save()' class='btn btn-primary btn-md' >Envoyer</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                          
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </span>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->


        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">

          <div class="col-md-12 col-xl-12 grid-margin stretch-card">

            <div class="card">

              <div class="card-body">

                <div class="col-md-12">
                  <?= $this->session->flashdata('message'); ?>

                  <div class="table-responsive">
                    <table id='reponse1' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>Plaque</th>
                          <th>Assureur</th>
                          <th>Début</th>
                          <th>Fin</th>
                          <th>Validité</th>
                          <th>Places assurées</th>
                          <th>Type d'assurance</th>
                          <th>Propriétaire</th>
                          <th>Téléphone</th>
                          <th>Date</th>
                          <th data-orderable="false">Options</th>
                        </tr>
                      </thead>
                    </table>
                  </div>





                </div>

              </div>
            </div>
          </div>

        </div>

        <!-- Rapport partie -->



        <!-- End Rapport partie -->

      </div>
    </div>
  </div>
</div>


</section>


<!-- /.content -->
</div>

</div>
<!-- ./wrapper -->
<?php include VIEWPATH . 'templates/footer.php'; ?>
</body>
 <div id="vehicule" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <input type="hidden" class="form-control" name="PLAQUE" id="PLAQUE" value=""> 
            <div id="title"><b><h4 id="vehicule_titre" style="color:#fff;font-size: 18px;"></h4></b>
              
            </div>
            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
         <div class="modal-body">
          <div  id="vehiculedata">
            
          </div>
    </div>
  </div>
</div>
</div>
</html>
<script type="text/javascript">
  $(document).ready(function() {
    liste();

  });



</script>





< <script type="text/javascript">
  function liste()
  {
    // alert($('#ID_ASSUREUR1').val())

    $('#message').delay('slow').fadeOut(3000);
    $("#reponse1").DataTable({
      "destroy" : true,
      "processing":true,
      "serverSide":true,
      "order":[[9,'DESC']],

      "ajax":{
        url: "<?php echo base_url('PSR/Assurances/listing/'); ?>",
        type:"POST",
        data : { ID_ASSUREUR : $('#ID_ASSUREUR1').val(),ID_ASSUREUR0 : $('#ID_ASSUREUR').val(), },
        beforeSend : function() {
        }
      },
      lengthMenu: [[10,50, 100, -1], [10,50, 100, "All"]],
      pageLength: 10,
      "columnDefs":[{
        "targets":[0, 10 ],
        "orderable":false
      }],
      dom: 'Bfrtlip',
      buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
      language: {
        "sProcessing": "Traitement en cours...",
        "sSearch": "Rechercher&nbsp;:",
        "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
        "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix": "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
        "oPaginate": {
          "sFirst": "Premier",
          "sPrevious": "Pr&eacute;c&eacute;dent",
          "sNext": "Suivant",
          "sLast": "Dernier"
        },
        "oAria": {
          "sSortAscending": ": activer pour trier la colonne par ordre croissant",
          "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        }
      }
    });


  }
function show_vehicule(NUMERO_PLAQUE = 0){
      
    
       var PLAQUE;

       var NUMERO_PLAQUE= NUMERO_PLAQUE;

       DATE1=  $('#DATE1').val();
       DATE2=  $('#DATE2').val();
     
       if(NUMERO_PLAQUE==0)
       {
          PLAQUE =  $('#PLAQUE').val();
       }else{
          PLAQUE =  NUMERO_PLAQUE;
          $("#PLAQUE").val(NUMERO_PLAQUE)
       }
       $('#vehicule').modal({
        backdrop: 'static',
        keyboard: false
      });
      $("#vehicule_titre").html("Tableau de bord de la plaque "+PLAQUE);
      $.ajax({
          url : "<?php echo base_url('Vehicule/show_vehicule'); ?>",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: { NUMERO_PLAQUE:PLAQUE,
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
function save(){
     var NUMERO_PLAQUE = $('#NUMERO_PLAQUE').val();
   Swal.fire({
      title: 'Souhaitez-vous effectuer un contrôle rapide sur le plaque numéro '+NUMERO_PLAQUE+' ?',
      showDenyButton: true,
      // showCancelButton: true,
      confirmButtonText: 'Maintenant',
      denyButtonText: `Pas maintenant`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        

      /* Debut ajax*/
         $.ajax({
          url : "<?=base_url()?>PSR/Obr_Immatriculation/controle_rapide/",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {NUMERO_PLAQUE:NUMERO_PLAQUE},
          beforeSend:function () { 
           $('#concernediv').html('<center><font color="#000"><i class="fas fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span></font></center>');
           $('#idbutton').prop('disabled',true)
          },
          success:function(data) {
             // $('#myControle').modal('hide')
             $('#concernediv').html('<div class="form-group col-lg-12"><div class="col-lg-12 col-md-12 col-sm-12 form-group" id="form1"><input type="text" name="NUMERO_PLAQUE" id="NUMERO_PLAQUE" class="form-control" placeholder="Numéro Plaque"><div><?php echo form_error("IMEI");?></div></div></div>')
            $('#idbutton').prop('disabled',false)
            console.log(data);
            Swal.fire('Confirmé!', '', 'success')
            show_vehicule(NUMERO_PLAQUE)
          },
          error:function() {
            Swal.fire('Erreur de la connexion', '', 'info')
          }
      });

        
      } else if (result.isDenied) {
        Swal.fire('Non Confirmé', '', 'info')
      }
    })

    //Fin ajax

 }
</script>