<!DOCTYPE html>
<html lang="en">

<?php include VIEWPATH . 'templates/header.php'; ?>



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
#Ftype{
    color: White;
  }
#divImage{

  top: 10.4%;
  width: 50.4%;
  height: 100%;
  background: #fff;
  position: fixed;
  z-index: 1060;
  right: 20%;
  right: 20%;
  visibility: hidden;
  overflow-x: auto;

  top: 0;
  left: 0;
  display: none;
  width: 100%;
  height: 100%;
  overflow: hidden;
  outline: 0;
  outline-color: currentcolor;
  outline-style: none;
  outline-width: 0px;

  overflow-x: hidden;
  overflow-y: auto;

}


  #allImage {
  position: relative;
  width: auto;
  margin: .5rem;
  pointer-events: none;

}


 #donnIdentite {
  position: relative;
  width: auto;
  margin: .5rem;
  /*pointer-events: none;*/

}


#divIdentite{

  width: 500px;
  height: 100%;
  overflow-x: hidden;
  overflow-y: auto;
  background: #fff;
  position: fixed;
  z-index: 1060;
  right: 20%;
  left: 18.3%;
  visibility: hidden;
}
span.select2-selection.select2-selection--single {
    height: 40px;
}
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include VIEWPATH . 'templates/navbar.php'; ?>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include VIEWPATH . 'templates/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->

    <div>
    



                <div class="card" id="divImage">
                  <div class="card-header">
                     <span>PSR <a style="float: right" href="#" onclick="viewImage()"><i class="fa fa-times"></i></a></span> <br>
                  </div>
                  <div class="card-body" id="allImage">
                  </div>
                </div>
              </div>




              <div>

                <div class="card w-80" id="divIdentite">
                  <div class="card-header">
                     <span>PSR <a style="float: right" href="#" onclick="viewIdentite()"><i class="fa fa-times"></i></a></span> <br>
                  </div>
                  <div class="card-body" id="donnIdentite">
              
                  </div>
                </div>
              </div>


              <script type="text/javascript">
                function viewImage(){
                  $('#divImage').delay(100).hide('show')
                }

                function showviewImage(src){
                  var img=src.split('#')
                  var imgsrc=""
                  for (var i = 0; i < img.length; i++) {
                   // alert(img[i]);
                   imgsrc+='<img   class="card-img-top" src="'+img[i]+'">'
                 }
                 imgsrc+=""
                 $("#divImage").css("visibility", "visible");
                 $('#divImage').delay(100).show('hide')

                 $('#allImage').html(imgsrc);
                  //document.getElementById('imgesss').src = src
                  console.log(imgsrc)
                }


              </script>


              <script type="text/javascript">

                  function viewIdentite(){
                  //$('#divIdentite').delay(100).hide('show')
                  $("#divIdentite").css("visibility", "hidden")
                }
                  function getIdentite(id){
                  // alert(id)
                    $('#divIdentite').delay(100).show('hide')
                  $("#divIdentite").css("visibility", "visible")

                  $.ajax({
                    url : "<?=base_url()?>PSR/Historique/getIdentite/"+id,
                    type : "GET",
                    dataType: "JSON",
                    success:function(data) {
                     $('#donnIdentite').html(data.views_detail)
                   },
                   error:function() {

                    $('#divIdentite').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher cette page! Veuillez réessayer</div>');
                       
                   $('#divIdentite').delay(100).hide('show')
                  }
                });

                }
              </script>

              <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col-sm-4">
                        <h4 class="m-0"><?= $title ?></h4>
                      </div><!-- /.col -->

                      <div class="col-sm-8">
                        
                       

                        <div class="row">
                          <div class="col-md-3" style="flex: 0 0 0%;max-width: 0%"></div>
                          <div class="">
                            <label id="Ftype" for="Ftype">Province</label>
                             <select class="form-control select2"  name="ID_PSR_ELEMENT"  id="ID_PSR_ELEMENT" value="" required onchange="liste()" >
                              <option value="">-----Tous-----</option>
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
                          <div class="col-md-2">
                             <label id="Ftype" for="Ftype">Type de contrôle</label>
                             <select class="form-control"  name="FILTRE" id="FILTRE" value="" required onchange="liste()" >
                              <option value="">-----Tous-----</option>
                                <?php
                                $provinces=$this->Model->getRequete('SELECT ID_CATEGORIE,DESCRIPTION from historiques_categories where 1');
                                  foreach ($provinces as $value)
                                  {
                                ?>
                                <option value="<?=$value['ID_CATEGORIE']?>"><?=$value['DESCRIPTION']?></option>
                                <?php
                                  }
                                ?>
                            </select>
                            
                          </div>
                          <div class="col-md-2">
                            <label id="Ftype" for="Ftype">De</label>
                            <input class="form-control" type="date" name="DATE1" id="DATE1" onchange="liste();get_min(this.value)" max=<?=date('Y-m-d')?>>
                          </div><div class="col-md-2">
                              <label id="Ftype" for="Ftype">Au</label>
                            <input class="form-control" type="date" name="DATE2"id="DATE2" onchange="liste()">
                          </div>
                  </div>
                </div>









                      </div><!-- /.col -->

                      <div class="col-md-2">
                       <!--   <label id="Ftype" for="Ftype">Date</label><br>
                        <select class="form-control input-sm" name="date" id="date" onchange='liste()'>
                          <option value="">Sélectionner</option>
                          <?php foreach ($historique as $key) { ?>
                            <option value="<?php echo $key['date'] ?>"><?php echo  $key['date'] ?></option>
                          <?php } ?>
                        </select> -->

                      </div>

                    </div><!-- /.row -->
                  </div><!-- /.container-fluid -->


                  <!-- /.content-header -->

                  <!-- Main content -->
                  <section class="content">

                    <div class="col-md-12 col-xl-12 grid-margin stretch-card">

                      <div class="card">

                        <div class="card-body">

               <!--   <label id="Ftype" for="Ftype">Type de vérification</label>
                <select  class="form-control" name="employe" id="employe" onchange='liste()'>
                  <option value="">---Sélectionner---</option>
                  <?php
                  $verification='SELECT ';
                  foreach ($verification as $value) {
                    ?>
                    <option value="<?= $value['IDEmploye'] ?>"><?= $value['Nom'] ?></option>
                    <?php
                  }
                  ?>
                </select> -->


                 








                          <div class="col-md-12 ">
                            <?= $this->session->flashdata('message'); ?>

                            <div class="table-responsive">  <table id='reponse1' class="table table-bordered  table-striped table-hover table-condensed">
                              <thead>
                                <tr>
                                
                                  <th>Agent</th>
                                  <th>Date de fait</th>
                                  <th>Type</th>
                                  <th>Annulé</th>
                                  <th>Plaque</th>
                                  <th>Permis</th>
                                  <th>Amende BIF</th>
                                  <th>Statut</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                            </table>


                          </div>


                        </div>


                        <!--  VOS CODE ICI  -->



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




      <!-- MODAL POUR LE DETAIL -->
      <div class="modal fade" id="detailControl">
       <div class="modal-dialog modal-lg" >
         <div class="modal-content">
           <div class="modal-header" style="background: black;">
            <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;">Détails</h4></b></div>

            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
         <div class="modal-body" id="donneDeatail">



         </div>
         <div class="modal-footer"> 
           <!--  <button id="btn_quiter" type="button" class="btn btn-primary" class='close' data-dismiss='modal'>Quitter</button> -->
         </div>
       </div>
     </div>
   </div>




   <!-- /.content -->
 </div>

</div>
<!-- ./wrapper -->
<?php include VIEWPATH . 'templates/footer.php'; ?>
</body>

</html>
<script type="text/javascript">
  $(document).ready(function() {
    liste();

  });



  function getDetailControl(id = 0) {


    $('#detailControl').modal()



    $.ajax({
      url : "<?=base_url()?>PSR/Historique/gethistoControl/"+id,
      type : "POST",
      dataType: "JSON",
      cache:false,
      data: {ID:id},
      beforeSend:function () { 
        $('#donneDeatail').html("");
      },
      success:function(data) {
       $('#donneDeatail').html(data.views_detail);
       $('#donneTitre').html(data.titres);

     },
     error:function() {
      $('#donneDeatail').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher cette page! Veuillez réessayer</div>');
    }
  });

  }

</script>





<script type="text/javascript">
  function liste()
  { var FILTRE = $('#FILTRE').val();
    var DATE1=$('#DATE1').val();
    var DATE2=$('#DATE2').val();
    var ID_PSR_ELEMENT = $('#ID_PSR_ELEMENT').val();
    $('#message').delay('slow').fadeOut(3000);
    $("#reponse1").DataTable({
      "destroy" : true,
      "processing":true,
      "serverSide":true,
      "order":[[1,'DESC']],
      "ajax":{
        url: "<?php echo base_url('PSR/Historique/listing/'); ?>",
        type:"POST",
        data : {
         DATE1:DATE1,
         DATE2:DATE2,
         FILTRE:FILTRE,
         ID_PSR_ELEMENT:ID_PSR_ELEMENT,
         date : $('#date').val(),
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
</script>


</script> 
<!-- script pour limiter la date fin --->
<script type="text/javascript">
  function get_min(){
    var min=$('#DATE1').val();
    $('#DATE2').prop('min',min);
  }
</script>