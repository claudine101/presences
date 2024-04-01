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



  .mapbox-logo {
    display: none;
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
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-8">
              <h4 class="m-0"><?= $title ?></h4>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->


        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">

          <div class="col-md-12 col-xl-12 grid-margin stretch-card">

            <div class="card">

              <div class="card-body">

                <div class="container py-5">
                  <div class="row">
                    <div class="col">
                     <div class="row">
                      <div class="col-md-12" style="float:left ;">
                        <a href="javascript:window.history.go(-1);"><span class="btn btn-primary btn-sm">Retour</span></a>
                      </div>
                    </div>
                  </div>
                </div>
              <br>
                <div class="row">
                  <div class="col-lg-4">
                    <div class="card mb-4" style="height:100%">

                      <div class="card-body text-center">
                          <!-- <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                            class="rounded-circle img-fluid" style="width: 150px;"> -->
                            <h3 style="float:center; color: #55acee;">Carte Rose</h3>
                            <div class="card-body p-0">
                              <ul class="list-group list-group-flush rounded-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>N Carte Rose</label>
                                  <p class="mb-0"><?= $carte_rose['NUMERO_CARTE_ROSE'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Plaque</label>
                                  <p class="mb-0"><?= $carte_rose['NUMERO_PLAQUE'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Categorie</label>
                                  <p class="mb-0"><?= $carte_rose['CATEGORIE_PLAQUE'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Marque</label>
                                  <p class="mb-0"><?= $carte_rose['MARQUE_VOITURE'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Chassis :</label>
                                  <p class="mb-0" ><?= $carte_rose['NUMERO_CHASSIS'];?></p>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Numero Place</label>
                                  <p class="mb-0"><?= $carte_rose['NOMBRE_PLACE'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Nom</label>
                                  <p class="mb-0"><?= $carte_rose['NOM_PROPRIETAIRE'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Prenom</label>
                                  <p class="mb-0"><?= $carte_rose['PRENOM_PROPRIETAIRE'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>CNI</label>
                                  <p class="mb-0"><?= $carte_rose['NUMERO_IDENTITE'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Province</label>
                                  <p class="mb-0"><?= $carte_rose['PROVINCE'];?></p>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Profession</label>
                                  <p class="mb-0"><?= $carte_rose['CATEGORIE_PROPRIETAIRE'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Usage</label>
                                  <p class="mb-0"><?= $carte_rose['CATEGORIE_USAGE'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Puissance</label>
                                  <p class="mb-0"><?= $carte_rose['PUISSANCE'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Couleur</label>
                                  <p class="mb-0"><?= $carte_rose['COULEUR'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Frabrication</label>
                                  <p class="mb-0"><?= $carte_rose['ANNEE_FABRICATION'];?></p>
                                </li>


                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Entegistre le</label>
                                  <p class="mb-0"><?= $carte_rose['DATE_INSERTION'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Modele</label>
                                  <p class="mb-0"><?= $carte_rose['MODELE_VOITURE'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Poids</label>
                                  <p class="mb-0"><?= $carte_rose['POIDS'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Carburant</label>
                                  <p class="mb-0"><?= $carte_rose['TYPE_CARBURANT'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Taxe</label>
                                  <p class="mb-0"><?= $carte_rose['TAXE_DMC'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>NIF</label>
                                  <p class="mb-0"><?= $carte_rose['NIF'];?></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                  <label>Delivre le</label>
                                  <p class="mb-0"><?= $carte_rose['DATE_DELIVRANCE'];?></p>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      <!-- <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-0">
                          <ul class="list-group list-group-flush rounded-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                              <i class="fas fa-globe fa-lg text-warning"></i>
                              <p class="mb-0">https://mdbootstrap.com</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                              <i class="fab fa-github fa-lg" style="color: #333333;"></i>
                              <p class="mb-0">mdbootstrap</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                              <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                              <p class="mb-0">@mdbootstrap</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                              <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                              <p class="mb-0">mdbootstrap</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                              <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                              <p class="mb-0">mdbootstrap</p>
                            </li>
                          </ul>
                        </div>
                      </div> -->
                    </div>
                    <div class="col-lg-8">
                      <div class="card mb-4">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-12" id="container" style="border: 1px solid #d2d7db;"></div>
                          </div>

                        </div>
                      </div>
                      <div class="row">
                        <?php if(!empty($controle)) { ?>
                          <div class="col-md-6">
                            <div class="card mb-4 mb-md-0">
                              <div class="card-body">
                                <h3 style="float:center; color: #333;">Controle Technique</h3>
                                <div class="card-body p-0">
                                  <ul class="list-group list-group-flush rounded-3">
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                      <label>Numero</label>
                                      <p class="mb-0"><?= $controle['NUMERO_CONTROLE'];?></p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                      <label>Plaque</label>
                                      <p class="mb-0"><?= $controle['NUMERO_PLAQUE'];?></p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                      <label>Chassis</label>
                                      <p class="mb-0"><?= $controle['NUMERO_CHASSIS'];?></p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                      <label>Propietaire</label>
                                      <p class="mb-0"><?= $controle['PROPRIETAIRE'];?></p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                      <label>Date </label>
                                      <p class="mb-0" ><?= $controle['DATE_DEBUT'];?></p>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                      <label>Date validite</label>
                                      <p class="mb-0"><?= $controle['DATE_VALIDITE'];?></p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                      <label>Type</label>
                                      <p class="mb-0"><?= $controle['TYPE_VEHICULE'];?></p>
                                    </li>

                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php } else {?>
                          <div class="col-md-6">
                            <div class="card mb-4 mb-md-0">
                              <div class="card-body">
                                <div class="alert alert-danger" role="alert">
                                  Il n'y a pas eu une contrrole Technique
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php } ?>
                        <?php if(!empty($vol)) { ?>
                          <div class="col-md-6">
                            <div class="card mb-4 mb-md-0">
                              <div class="card-body">
                                <h3 style="float:center; color: #333;">Police Judiciaire (Declaration VOl)</h3>
                                <div class="card-body p-0">
                                  <ul class="list-group list-group-flush rounded-3">
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                      <label>Plaque</label>
                                      <p class="mb-0"><?= $vol['NUMERO_PLAQUE'];?></p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                      <label>Nom</label>
                                      <p class="mb-0"><?= $vol['NOM_DECLARANT'];?></p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                      <label>Prenom</label>
                                      <p class="mb-0"><?= $vol['PRENOM_DECLARANT'];?></p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                      <label>Couleur</label>
                                      <p class="mb-0"><?= $vol['COULEUR_VOITURE'];?></p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                      <label>Marque</label>
                                      <p class="mb-0" ><?= $vol['MARQUE_VOITURE'];?></p>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                      <label>Date vol</label>
                                      <p class="mb-0"><?= $vol['DATE_VOLER'];?></p>
                                    </li>
                                    <?= $vol['STATUT']==1 ? '<li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <label>Statut</label>
                                    <p class="mb-0" style="color:blue">Trouvé</p>
                                    </li>' :

                                    '<li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <label>Statut</label>
                                    <p class="mb-0" style="color:red;">Volé</p>
                                    </li>'
                                    ?>
                                  </ul>
                                </div>
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
                    <div class="row">
                      <?php if(!empty($controle)) { ?>
                       <div class="col-md-6">
                        <div class="card mb-4 mb-md-0">
                          <div class="card-body">
                           <h3 style="float:center; color: #333;">Assurance</h3>
                           <div class="card-body p-0">
                            <ul class="list-group list-group-flush rounded-3">
                              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <label>Plaque</label>
                                <p class="mb-0"><?= $assurance['NUMERO_PLAQUE'];?></p>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <label>Asssureur</label>
                                <p class="mb-0"><?= $assurance['ASSURANCE'];?></p>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <label>Date</label>
                                <p class="mb-0"><?= $assurance['DATE_DEBUT'];?></p>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <label>Date de validite</label>
                                <p class="mb-0" style="float: right;"><?= $assurance['DATE_VALIDITE'];?></p>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <label>Nbre d'assures </label>
                                <p class="mb-0" ><?= $assurance['PLACES_ASSURES'];?></p>
                              </li>

                              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <label>Type</label>
                                <p class="mb-0"><?= $assurance['TYPE_ASSURANCE'];?></p>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <label>Proprietaire</label>
                                <p class="mb-0"><?= $assurance['NOM_PROPRIETAIRE'];?></p>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } else {?>
                    <div class="col-md-6">
                      <div class="card mb-4 mb-md-0">
                        <div class="card-body">
                          <div class="alert alert-danger" role="alert">
                            Il n'y a pas eu l'assurance
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                 <!--  <div class="col-md-6">
                    <div class="card mb-4 mb-md-0">
                      <div class="card-body">
                        <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project Status
                        </p>
                        <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                        <div class="progress rounded" style="height: 5px;">
                          <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                          aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup</p>
                        <div class="progress rounded" style="height: 5px;">
                          <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72"
                          aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="mt-4 mb-1" style="font-size: .77rem;">One Page</p>
                        <div class="progress rounded" style="height: 5px;">
                          <div class="progress-bar" role="progressbar" style="width: 89%" aria-valuenow="89"
                          aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="mt-4 mb-1" style="font-size: .77rem;">Mobile Template</p>
                        <div class="progress rounded" style="height: 5px;">
                          <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55"
                          aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="mt-4 mb-1" style="font-size: .77rem;">Backend API</p>
                        <div class="progress rounded mb-2" style="height: 5px;">
                          <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66"
                          aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                  </div> -->
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
</div>
</div>


</section>


<!-- /.content -->
</div>

</div>
<!-- ./wrapper -->
<?php include VIEWPATH . 'templates/footer.php'; ?>
</body>

</html>



<script type="text/javascript">

  Highcharts.chart('container', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Amende totale de <?=$total ?> FBU<br>'
    },
    xAxis: {
      categories: [<?= $date ;?>]

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
      enabled: true
    }
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
  name: 'Amande',
  data: [<?=$amandes?>]
}]
});           
</script>

