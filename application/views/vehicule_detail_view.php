<section class="content">
          <div class="col-md-12 col-xl-12 grid-margin stretch-card">
            <div class="container-fluid">
                <br>
                <div class="row">
                  <div class="col-lg-4">
                    <div class="card mb-4">
                            <div class="card-body">
                              <h3 style="float:center; color: #333;">Carte Rose</h3>
                              <p class="mb-1" style="font-size: .77rem;">N° Carte Rose: <span style="float: right;"><b><?=$carte_rose['NUMERO_CARTE_ROSE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>
                              <p class="mb-1" style="font-size: .77rem;">Plaque: <span style="float: right;"><b><?=$carte_rose['NUMERO_PLAQUE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>
                              <p class="mb-1" style="font-size: .77rem;">Categorie: <span style="float: right;"><b><?=$carte_rose['CATEGORIE_PLAQUE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>
                              <p class="mb-1" style="font-size: .77rem;">Marque: <span style="float: right;"><b><?=$carte_rose['MARQUE_VOITURE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>
                              <p class="mb-1" style="font-size: .77rem;">Chassis: <span style="float: right;"><b><?=$carte_rose['NUMERO_CHASSIS']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Nbr Place: <span style="float: right;"><b><?=$carte_rose['NOMBRE_PLACE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>

                              <p class="mb-1" style="font-size: .77rem;">Nom: <span style="float: right;"><b><?= $carte_rose['PRENOM_PROPRIETAIRE'];?> <?=$carte_rose['NOM_PROPRIETAIRE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Chassis: <span style="float: right;"><b><?=$carte_rose['NUMERO_CHASSIS']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">CNI: <span style="float: right;"><b><?=$carte_rose['NUMERO_IDENTITE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>

                              <p class="mb-1" style="font-size: .77rem;">Province: <span style="float: right;"><b><?=$carte_rose['PROVINCE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>

                              <p class="mb-1" style="font-size: .77rem;">Profession: <span style="float: right;"><b><?=$carte_rose['CATEGORIE_PROPRIETAIRE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Usage: <span style="float: right;"><b><?=$carte_rose['CATEGORIE_USAGE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>

                              <p class="mb-1" style="font-size: .77rem;">Puissance: <span style="float: right;"><b><?=$carte_rose['PUISSANCE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Couleur: <span style="float: right;"><b><?=$carte_rose['COULEUR']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Frabrication: <span style="float: right;"><b><?=$carte_rose['ANNEE_FABRICATION']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Date d'enregistrement: <span style="float: right;"><b><?=$carte_rose['DATE_INSERTION']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Modele: <span style="float: right;"><b><?=$carte_rose['MODELE_VOITURE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>

                              <p class="mb-1" style="font-size: .77rem;">Poids: <span style="float: right;"><b><?=$carte_rose['POIDS']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Carburant: <span style="float: right;"><b><?=$carte_rose['TYPE_CARBURANT']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>

                              <p class="mb-1" style="font-size: .77rem;">NIF: <span style="float: right;"><b><?=$carte_rose['NIF']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>


                              <p class="mb-1" style="font-size: .77rem;">Date de délivreson: <span style="float: right;"><b><?=$carte_rose['DATE_DELIVRANCE']?></b></span> </p>
                              <div class="progress rounded" style="height: 5px;">
                              </div>
                            </div>
                        </div>
                        <div class="row">
                              <?php if(!empty($controle)) { ?>
                               <div class="col-md-12">
                                <div class="card mb-4 mb-md-0">
                                  <div class="card-body">
                                   <h3 style="float:center; color: #333;">Assurance</h3>

                                    <p class="mb-1" style="font-size: .60rem;">Plaque: <span style="float: right;"><b><?= $assurance['NUMERO_PLAQUE'];?></b></span> </p>
                                    <div class="progress rounded" style="height: 5px;">
                                    </div>

                                    <p class="mb-1" style="font-size: .77rem;">Assureur: <span style="float: right;"><b><?= $assurance['ASSURANCE'];?></b></span> </p>
                                    <div class="progress rounded" style="height: 5px;">
                                    </div>

                                    <p class="mb-1" style="font-size: .77rem;">Début: <span style="float: right;"><b><?= $assurance['DATE_DEBUT'];?></b></span> </p>
                                    <div class="progress rounded" style="height: 5px;">
                                    </div>
                                      <?php
                                          if($assurance['DATE_VALIDITE']>=date("Y-m-d")){ ?>
                                            <p class="mb-1" style="font-size: .77rem;co">Date validité: <span style="float: right;"><b><?=$assurance['DATE_VALIDITE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                         <?php } else { ?>
                                          <p class="mb-1" style="font-size: .77rem;color: red;">Date validité: <span style="float: right;"><b><?=$assurance['DATE_VALIDITE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px; color: red;">
                                          </div>

                                          <?php }  ?>

                                    <p class="mb-1" style="font-size: .77rem;">Places: <span style="float: right;"><b><?= $assurance['PLACES_ASSURES'];?></b></span> </p>
                                    <div class="progress rounded" style="height: 5px;">
                                    </div>

                                    <p class="mb-1" style="font-size: .77rem;">Type: <span style="float: right;"><b><?= $assurance['TYPE_ASSURANCE'];?></b></span> </p>
                                    <div class="progress rounded" style="height: 5px;">
                                    </div>

                                    <p class="mb-1" style="font-size: .77rem;">Propriètaire: <span style="float: right;"><b><?= $assurance['NOM_PROPRIETAIRE'];?></b></span> </p>
                                    <div class="progress rounded" style="height: 5px;">
                                    </div>


                                  </div>
                              </div>
                            </div>
                          <?php } else {?>
                            <div class="col-md-12">
                              <div class="card mb-12 mb-md-0">
                                <div class="card-body">
                                  <div class="alert alert-danger" role="alert">
                                    Il n'y a pas eu l'assurance
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php } ?>
                      </div>

                        </div>
                        <div class="col-lg-8">
                          <div class="card mb-4">
                            <div class="card-body">
                              <div class="row">
                                   <div class="form-group col-md-4">
                                    <label style='color:#333'>Du</label>
                                      
                                      <input type="date" id="DATE1" onchange="show_vehicule()" name="DATE1" class="form-control" value="<?=set_value('DATE1')?>">         
                                   </div>
                                  <div class="form-group col-md-4">
                                        <label style='color:#333'>Au</label>
                                        <input type="date" id="DATE2" name="DATE2" onchange="show_vehicule()"  class="form-control" min="<?=set_value('DATE1')?>" value="<?=set_value('DATE2')?>">
                                   </div>
                                   <div class="form-group col-md-4">
                                     <label style='color:#FFFFFF'>Paiement</label>
                                     <select class="form-control"  onchange="show_vehicule()" name="STATUT" id="STATUT">
                                        <option value="">Sélectionner</option>
                                        <?php
                                        $select="";
                                        foreach($paiement as $key=>$value){
                                        
                                        ?>
                                        <option <?php if ($value==$STATUT_PAIEMENT): ?>
                                          selected
                                        <?php endif ?> value="<?=$value?>"><?=$key?></option>
                                        <?php } ?>
                                  </select>
                                </div>
                                    <br>
                                    <div class="col-md-12" id="container" style="border: 1px solid #d2d7db;"></div>
                                  </div>
                              </div>

                              </div>
                              
                                <?php if(!empty($transport)) { ?>
                                  <div class="col-md-12">
                                    <div class="card mb-4 ">
                                      <div class="card-body">
                                        <h3 style="float:center; color: #333;">Transport</h3>

                                          <p class="mb-1" style="font-size: .77rem;">Numero: <span style="float: right;"><b><?=$transport['NUMERO_CONTROLE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>


                                          <p class="mb-1" style="font-size: .77rem;">Plaque: <span style="float: right;"><b><?=$transport['NUMERO_PLAQUE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Chassis: <span style="float: right;"><b><?=$transport['NUMERO_CHASSIS']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Propriétaire: <span style="float: right;"><b><?=$transport['PROPRIETAIRE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Date: <span style="float: right;"><b><?=$transport['DATE_DEBUT']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div><?php
                                          if($transport['DATE_VALIDITE']>=date("Y-m-d")){ ?>
                                            <p class="mb-1" style="font-size: .77rem;co">Date validité: <span style="float: right;"><b><?=$transport['DATE_VALIDITE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                         <?php } else { ?>
                                          <p class="mb-1" style="font-size: .77rem;color: red;">Date validité: <span style="float: right;"><b><?=$transport['DATE_VALIDITE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px; color: red;">
                                          </div>

                                          <?php }  ?>
                                           
                                          

                                        

                                          <p class="mb-1" style="font-size: .77rem;">Type: <span style="float: right;"><b><?=$transport['TYPE_VEHICULE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                <?php } else {?>
                                  <div class="col-md-12">
                                    <div class="card mb-4 ">
                                      <div class="card-body">
                                        <div class="alert alert-danger" role="alert">
                                          Il n'y a pas eu un  permis de transport
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php } ?>
                                 

                              <div class="row">
                                <?php if(!empty($controle)) { ?>
                                  <div class="col-md-6">
                                    <div class="card mb-4 mb-md-0">
                                      <div class="card-body">
                                        <h3 style="float:center; color: #333;">Contrôle Technique</h3>
                                          <p class="mb-1" style="font-size: .77rem;">Numero: <span style="float: right;"><b><?=$controle['NUMERO_CONTROLE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>


                                          <p class="mb-1" style="font-size: .77rem;">Plaque: <span style="float: right;"><b><?=$controle['NUMERO_PLAQUE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Chassis: <span style="float: right;"><b><?=$controle['NUMERO_CHASSIS']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Propriétaire: <span style="float: right;"><b><?=$controle['PROPRIETAIRE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Date: <span style="float: right;"><b><?=$controle['DATE_DEBUT']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <?php
                                          if($controle['DATE_VALIDITE']>=date("Y-m-d")){ ?>
                                            <p class="mb-1" style="font-size: .77rem;co">Date validité: <span style="float: right;"><b><?=$controle['DATE_VALIDITE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                         <?php } else { ?>
                                          <p class="mb-1" style="font-size: .77rem;color: red;">Date validité: <span style="float: right;"><b><?=$controle['DATE_VALIDITE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px; color: red;">
                                          </div>

                                          <?php }  ?>


                                          <p class="mb-1" style="font-size: .77rem;">Type: <span style="float: right;"><b><?=$controle['TYPE_VEHICULE']?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php } else {?>
                                  <div class="col-md-6">
                                    <div class="card mb-4 mb-md-0">
                                      <div class="card-body">
                                        <div class="alert alert-danger" role="alert">
                                          Il n'y a pas eu une contrôle Technique
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php } ?>
                                <?php if(!empty($vol)) { ?>
                                  <div class="col-md-6">
                                    <div class="card mb-4 mb-md-0">
                                      <div class="card-body">
                                        <h3 style="float:center; color: #333;">Police Judiciaire</h3>
                                          <p class="mb-1" style="font-size: .77rem;">Plaque: <span style="float: right;"><b><?= $vol['NUMERO_PLAQUE'];?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Déclarant: <span style="float: right;"><b><?= $vol['NOM_DECLARANT'];?> <?= $vol['PRENOM_DECLARANT'];?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Couleur: <span style="float: right;"><b><?= $vol['COULEUR_VOITURE'];?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>

                                          <p class="mb-1" style="font-size: .77rem;">Marque: <span style="float: right;"><b><?= $vol['MARQUE_VOITURE'];?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>


                                          <p class="mb-1" style="font-size: .77rem;">Date du vol: <span style="float: right;"><b><?= $vol['DATE_VOLER'];?></b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>


                                          <?= $vol['STATUT']==1 ? '<p class="mb-1" style="font-size: .77rem;">Statut: <span style="float: right;"><b>Trouvé</b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>' :

                                          '<p class="mb-1" style="font-size: .77rem;">Statut: <span style="float: right;"><b>Volé</b></span> </p>
                                          <div class="progress rounded" style="height: 5px;">
                                          </div>'
                                          ?>

                                        </div>
                                      </div>
                                  </div>
                                <?php } else {?>
                                  <div class="col-md-6">
                                    <div class="card mb-4 mb-md-0">
                                      <div class="card-body">
                                        <div class="alert alert-success" role="alert">
                                          Il n'y a pas eu une déclaration de vol
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php } ?>

                              </div>
                            </br> </br>
                            


                    </div>
                  </div>
                </div>

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



</section>
<?php include VIEWPATH . 'templates/footerDeux.php'; ?>
<script type="text/javascript">

  Highcharts.chart('container', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Amende totale <?=$total?> FBU<br>'
    },
    subtitle: {
        text: 'Contrôle totale  <?=$nbr?> <br>'
    },
    xAxis: {
      type: 'category'
    },
    yAxis: {
      min: 0,
      title: {
        text: '',
        align: 'high'
      },
      labels: {
        overflow: 'justify'
      }
    },
    tooltip: {
     valueSuffix: 'FBU'
   },
   plotOptions: {
    column: {
     dataLabels: {
      enabled: true,
      point:{
        events:{
          click: function(e){
            date:$('#date').val()
          }
        }
      }
    },

  }
},
legend: {
  layout: 'vertical',
  align: 'right',
  verticalAlign: 'top',
  x: -40,
  y: 80,
  floating: true,
  borderWidth: 1,
  backgroundColor:
  Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
  shadow: true
},
credits: {
  enabled: false
},
series: [{
  name: 'Amende',
  data: [<?=$amandes?>]
}]
});           
</script>

<script type="text/javascript">
 function get_rapport(){
  myform.submit()
  date:$('#date').val()
}

</script>

<script>

  function submit_province() {


    myform.action= myform.action;
    myform.submit();
  }



  getMaps();

   function show_vehicule(NUMERO_PLAQUE = 0){
       var PLAQUE;
       var NUMERO_PLAQUE= NUMERO_PLAQUE;
       DATE1=  $('#DATE1').val();
       DATE2=  $('#DATE2').val();
       STATUT=  $('#STATUT').val();
       if(NUMERO_PLAQUE==0)
       {
          PLAQUE =  $('#PLAQUE').val();
       }else{
          PLAQUE =  NUMERO_PLAQUE;
          $("#PLAQUE").val(NUMERO_PLAQUE)
       }
       
      $('#vehicule').modal()
      $("#vehicule_titre").html("Tableau de bord de la plaque "+PLAQUE);
      $.ajax({
          url : "<?php echo base_url('Vehicule/show_vehicule'); ?>",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: { NUMERO_PLAQUE:PLAQUE,
                  DATE1:DATE1,
                  DATE2:DATE2,
                  STATUT:STATUT},
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