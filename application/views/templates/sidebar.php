

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<style type="text/css">
  .bordersolid {
    border-style: solid;
    border-color: gray;
    border-width: 1px;
  }

  .tooltipp {
    display: inline-block;
    position: relative;
    border-bottom: 1px dotted #666;
    text-align: left;
  }

  .tooltipp .topp {
    min-width: 200px;
    top: -20px;
    left: 50%;
    transform: translate(-50%, -100%);
    padding: 10px 20px;
    color: #111111;
    background-color: #EEEEEE;
    font-weight: normal;
    font-size: 13px;
    border-radius: 8px;
    position: absolute;
    z-index: 99999999;
    box-sizing: border-box;
    box-shadow: 0 1px 8px #FFFFFF;
    display: none;
  }

  .tooltipp:hover .topp {
    display: block;
  }

  .tooltipp .topp i {
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -12px;
    width: 24px;
    height: 12px;
    overflow: hidden;
  }

  .tooltipp .topp i::after {
    content: '';
    position: absolute;
    width: 12px;
    height: 12px;
    left: 50%;
    transform: translate(-50%, -50%) rotate(45deg);
    background-color: #EEEEEE;
    box-shadow: 0 1px 8px #FFFFFF;
  }

  .content-wrapper {
    /*background-color: #312f568f;*/
    background-image: url('<?= base_url() ?>/upload/policeTrois.png');
    background-size: cover;
    background-repeat: no-repeat;
    height: 100%;
    margin: 0;
    padding: 0;
  }

  #title {
    color: #fff;
  }

  h1 {
    color: #fff;
  }

  h4 {
    color: #fff;
  }

  h5 {
    color: #000;
  }

  h3 {
    color: #fff;
  }

  h2 {
    color: #fff;
  }

  .list-group-item-heading {
    color: #000;
  }

  strong {
    color: #000;
  }

  .dataTables_filter < label{
    float: left;
  }
  .nav-item{
    font-size: 14px;
  }

  td,th{
    font-size: 14px;
  }

  #imageLogo{
  width: 26px;
  height: 26px;
  border-radius: 50%;
}
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <?php $image = !empty($this->session->userdata('ICON_LOGO')) ? $this->session->userdata('ICON_LOGO') : "testImage.webp";


         if ($this->session->userdata('PROFIL_ID') == 2) {

        $inputs = $this->session->userdata('ID_INSTITUTION');

        $condition =  " AND ID_ASSUREUR =".$inputs;


        $assureur = $this->Model->getRequeteOne('SELECT ID_ASSUREUR, ASSURANCE,ICON_LOGO FROM assureur WHERE 1 '.$condition.'  ORDER BY ASSURANCE ASC');

        $icon_logo = $this->Model->getRequeteOne('SELECT ICON_LOGO FROM assureur WHERE ID_ASSUREUR='.$inputs);
        
        $assureur = $assureur['ASSURANCE'];
        $logo = $icon_logo['ICON_LOGO'];


       }else{
        
       $assureur = "";
       $logo=!empty($this->session->userdata('ICON_LOGO')) ? $this->session->userdata('ICON_LOGO') : "testImage.webp";
       }

   ?>

   <?php if ($this->session->userdata('PROFIL_ID') == 2) { ?>
        <!-- <a href="#" class="d-block"><img src="<?= $image ?>" id="imageLogo"> <?= $assureur ?> </a> -->
         <img height="13.5%" width="100%" src="<?= $logo?>" alt="" class="brand-image">
        <?php }else{  ?>
        
         <img height="13.5%" width="100%" src="<?= base_url() ?>upload/bannerUne.png" alt="" class="brand-image">
         <?php } ?>
<!-- <?= $assureur ?> -->
 
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
          <?php if (!empty($this->session->userdata('ICON_LOGO'))) { ?>
        <a href="#" class="d-block"><img src="<?= $this->session->userdata('ICON_LOGO')?>" id="imageLogo">  <?= $this->session->userdata('USER_NAME') ?> </a>
        <?php }else{  ?>
        <a href="#" class="d-block"><i class="fa fa-user"></i> <?= $this->session->userdata('USERNAME') ?></a>

         <?php } ?>
      </div>
      <!--  <div class="info">
       
      </div> -->
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">


      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Utilisateurs' || $this->router->class == 'Partie_politique' || $this->router->class == 'Profils' || $this->router->class == 'Droit') echo 'active'; ?>">
              <i class="nav-icon fa fa-user-md"></i>
              <p>
                Administration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('administration/Utilisateurs/index') ?>" class="nav-link <?php if ($this->router->class == 'Utilisateurs') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Utilisateurs </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('administration/Profils/index') ?>" class="nav-link <?php if ($this->router->class == 'Profils') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profils</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?= base_url('administration/Partie_politique/index') ?>" class="nav-link <?php if ($this->router->class == 'Partie_politique') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Partie politiques</p>
                </a>
              </li>
            
                <li class="nav-item">
                  <a href="<?= base_url('PSR/Droit/index') ?>" class="nav-link <?php if ($this->router->class == 'Droit') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Droits</p>
                  </a>
                </li>

            </ul>

          </li>

     

<!-- TABLEAU DE BORD PARTENAIRE -->
        <?php if ($this->session->userdata('TB_PJ') == 1 || $this->session->userdata('TB_ASSURANCE') == 1 ||$this->session->userdata('TB_IMMATRICULATION') == 1 || $this->session->userdata('TB_PERMIS') == 1) { ?>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Dashboard_declare_vole' || $this->router->class == 'Dashboard_Vehecule_Assure' || $this->router->class == 'Signalement_Citoyen' || $this->router->class == 'Dashboard_Otraco' ||  $this->router->class == 'User_Policier_Dash' || $this->router->class == 'Declaration_Vehicule' || $this->router->class == 'Dashboard_controle_tech' || $this->router->class == 'Dashboard_Immatriculation_obr' || $this->router->class == 'Dashboard_Chauffeur_permis')  echo 'active'; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Tableau de bord partenaire
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <?php if ($this->session->userdata('TB_PJ') == 1){ ?>

                <li class="nav-item">
                <a href="<?= base_url('dashboard/Dashboard_declare_vole') ?>" class="nav-link <?php if ($this->router->class == 'Dashboard_declare_vole') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>BD interpol ou PJ</p>
                </a>
              </li>
               <?php } ?>
             <?php if ($this->session->userdata('TB_ASSURANCE') == 1){ ?>
               <li class="nav-item">
                <a href="<?= base_url('dashboard/Dashboard_Vehecule_Assure') ?>" class="nav-link <?php if ($this->router->class == 'Dashboard_Vehecule_Assure') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>BD Assurance</p>
                </a>
              </li>
              <?php } ?>
             <?php if ($this->session->userdata('TB_IMMATRICULATION') == 1){ ?>
              <li class="nav-item">
                <a href="<?= base_url('dashboard/Dashboard_Immatriculation_obr') ?>" class="nav-link <?php if ($this->router->class == 'Dashboard_Immatriculation_obr') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>BD Immatriculation</p>
                </a>
              </li>

           <?php } ?>
             <?php if ($this->session->userdata('TB_PERMIS') == 1){ ?>
               <li class="nav-item">
                <a href="<?= base_url('dashboard/Dashboard_Chauffeur_permis') ?>" class="nav-link <?php if ($this->router->class == 'Dashboard_Chauffeur_permis') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>BD Pemis</p>
                </a>
              </li>
              <?php } ?>
             <?php if ($this->session->userdata('TB_CONTROLE_TECHNIQUE') == 1){ ?>
              <li class="nav-item">
                <a href="<?= base_url('dashboard/Dashboard_controle_tech/index') ?>" class="nav-link <?php if ($this->router->class == 'Dashboard_controle_tech') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>BD contrl technique</p>
                </a>
              </li>
               <?php } ?>
            </ul>
          </li>
<?php } ?>


<!-- TABLEAU DE BORD FINANCIER -->
<?php if ($this->session->userdata('TB_FINANCIER') == 1 || $this->session->userdata('TB_AMANDE') == 1 ||$this->session->userdata('TB_POLICE') == 1 ){ ?>
        <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Dashboard_Financier' || $this->router->class == 'Amende_percu_journe' || $this->router->class == 'Dash_performance_police')  echo 'active'; ?>">
              <i class="nav-icon fas fa-chart-area"></i>
              <p>
                Tableau de bord Financier
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
             <ul class="nav nav-treeview">
                <?php if ($this->session->userdata('TB_FINANCIER') == 1 )  { ?>
                  <li class="nav-item">
                    <a href="<?= base_url('dashboard/Dashboard_Financier/index') ?>" class="nav-link <?php if ($this->router->class == 'Dashboard_Financier') echo 'active'; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Rapport Financier</p>
                    </a>
                  </li>
                <?php } ?>
                <?php if ($this->session->userdata('TB_AMANDE') == 1 )  { ?>
                  <li class="nav-item">
                    <a href="<?= base_url('dashboard/Amende_percu_journe/index') ?>" class="nav-link <?php if ($this->router->class == 'Amende_percu_journe') echo 'active'; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Rapport des amendes</p>
                    </a>
                  </li>
                <?php } ?>
                <?php if ($this->session->userdata('TB_POLICE') == 1 )  { ?>
                    <li class="nav-item">
                      <a href="<?= base_url('dashboard/Dash_performance_police/index') ?>" class="nav-link <?php if ($this->router->class == 'Dash_performance_police') echo 'active'; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Performance police</p>
                      </a>
                    </li>
                <?php } ?>
            </ul>
        </li>
   <?php } ?>

   <!-- RAPPORT SIGNALEMENT -->
    <?php if ($this->session->userdata('TB_SIGNALMENT') == 1 || $this->session->userdata('TB_CONSTANT') == 1 ){ ?>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Dashboard_Signalement' || $this->router->class == 'Dashboard_Constats' || $this->router->class == 'Dahboard_Grobal')  echo 'active'; ?>">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>
                Rapport des signalements
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
             <ul class="nav nav-treeview">
              <?php if ($this->session->userdata('TB_SIGNALMENT') == 1 ){ ?>
              <li class="nav-item">
                <a href="<?= base_url('dashboard/Dashboard_Signalement/index') ?>" class="nav-link <?php if ($this->router->class == 'Dashboard_Signalement') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Signalements</p>
                </a>
              </li>
              <?php } ?>
              <?php if ($this->session->userdata('TB_CONSTANT') == 1 ){ ?>
              <li class="nav-item">
                <a href="<?= base_url('dashboard/Dashboard_Constats/index') ?>" class="nav-link <?php if ($this->router->class == 'Dashboard_Constats') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Constats</p>
                </a>
              </li> 
              <?php } ?>
            </ul>
          </li>
       <?php } ?>

<!-- RAPPORT DE CONTROLE -->
<?php if ($this->session->userdata('TB_CONTROLE_RAPIDE') == 1 || $this->session->userdata('TB_AUTRE_CONTROLE') == 1 ){ ?>
      <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Dashboard_Controle_Physique' || $this->router->class == 'Dashbord_Controle_Rapide')  echo 'active'; ?>">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Rapport des contrôles
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if ($this->session->userdata('TB_CONTROLE_RAPIDE') == 1  ){ ?>
               <li class="nav-item">
                  <a href="<?= base_url('dashboard/Dashbord_Controle_Rapide') ?>" class="nav-link <?php if ($this->router->class == 'Dashbord_Controle_Rapide') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Contrôle Global</p>
                  </a>
                </li>
               <?php } ?>
               <?php if ($this->session->userdata('TB_AUTRE_CONTROLE') == 1  ){ ?>
                 <li class="nav-item">
                    <a href="<?= base_url('dashboard/Dashboard_Controle_Physique') ?>" class="nav-link <?php if ($this->router->class == 'Dashboard_Controle_Physique') echo 'active'; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Autre contrôles</p>
                    </a>
                </li> 
              <?php } ?>
            </ul>
      </li>
<?php } ?>

<!-- SIG -->
<?php if ($this->session->userdata('MAP_CENTRE_SITUATION') == 1 || $this->session->userdata('MAP_AGENT_POLICE') == 1 || $this->session->userdata('MAP_SIGNALEMENT') == 1) { ?>
       <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Carte_Centre_Situation' || $this->router->class == 'Elements_Pnb' || $this->router->class == 'Carte_affectation_psr' || $this->router->class == 'Signalement' || $this->router->class == 'New_signalement') echo 'active'; ?>">
              <!-- <i class="nav-icon fas fa-globe-africa"></i> -->
              <i class="nav-icon fa fa-map-marker" aria-hidden="true"></i>
              <p>
                SIG
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
              <ul class="nav nav-treeview">
                <?php if ($this->session->userdata('MAP_CENTRE_SITUATION') == 1) { ?>
                  <li class="nav-item">
                    <a href="<?= base_url('geo/Carte_Centre_Situation/index') ?>" class="nav-link <?php if ($this->router->class == 'Carte_Centre_Situation') echo 'active'; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Centre de situation </p>
                    </a>
                  </li>
                <?php } ?>
                <?php if ($this->session->userdata('MAP_AGENT_POLICE') == 1) { ?>
                <li class="nav-item">
                  <a href="<?= base_url('geo/Elements_Pnb/index') ?>" class="nav-link <?php if ($this->router->class == 'Elements_Pnb') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Fonctionnaire de la PNB </p>
                  </a>
                </li>
                <?php } ?>
                <?php if ($this->session->userdata('MAP_SIGNALEMENT') == 1) { ?>
                <li class="nav-item">
                  <a href="<?= base_url('geo/New_signalement/index') ?>" class="nav-link <?php if ($this->router->class == 'Signalement') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Signalement </p>
                  </a>
                </li>
               <?php } ?>
              </ul>
          </li>
<?php } ?>


<!-- CONFIGURATION -->
<?php if ($this->session->userdata('CONFIGURATION_DATA') == 1) { ?>
  <li class="nav-item">
          <a href="#" class="nav-link <?php if ($this->router->class == 'Couleur'  ||  $this->router->class == 'Infra_infractions' ||  $this->router->class == 'Infra_peines' ||  $this->router->class == 'Autres_controles_questionnaires' || $this->router->class == 'Identite' || $this->router->class == 'Type_Verification' || $this->router->class == 'Question_Categorie' || $this->router->class == 'Gravite' || $this->router->class == 'Chaussee' || $this->router->class == 'Liste_recouvrement' || $this->router->class == 'Historique_Commentaire' || $this->router->class == 'Recouv_Histo') echo 'active'; ?>">

              <i class="nav-icon fas fa-database"></i>
              <p>
                Configuration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">


               <?php if ($this->session->userdata('INFRACTION') == 1) { ?>
                <li class="nav-item">
                  <a href="<?= base_url('ihm/Historique_Commentaire/index') ?>" class="nav-link <?php if ($this->router->class == 'Historique_Commentaire') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Commentaires </p>
                  </a>
                </li>


                <li class="nav-item">
                  <a href="<?= base_url('recouvrement/Liste_recouvrement/index') ?>" class="nav-link <?php if ($this->router->class == 'Liste_recouvrement') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Fréquence de Pénalités</p>
                  </a>
                </li>

              

                 <li class="nav-item">
                  <a href="<?= base_url('recouvrement/Recouv_Histo/index') ?>" class="nav-link <?php if ($this->router->class == 'Recouv_Histo') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Arriéré de paiement </p>
                  </a>
                </li>
              <?php } ?>


              <?php if ($this->session->userdata('INFRACTION') == 1) { ?>
                <li class="nav-item">
                  <a href="<?= base_url('PSR/Infra_infractions/index') ?>" class="nav-link <?php if ($this->router->class == 'Infra_infractions') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Infractions </p>
                  </a>
                </li>
              <?php } ?>

              <?php if ($this->session->userdata('PEINES') == 1) { ?>
                <li class="nav-item">
                  <a href="<?= base_url('PSR/Infra_peines/index') ?>" class="nav-link <?php if ($this->router->class == 'Infra_peines') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pénalités des Contrôles</p>
                  </a>
                </li>
              <?php } ?>
              <?php if ($this->session->userdata('QUESTIONNAIRE') == 1 && $this->session->userdata('PSR_ELEMENT') == 1) { ?>
                <li class="nav-item">
                  <a href="<?= base_url('PSR/Autres_controles_questionnaires/index') ?>" class="nav-link <?php if ($this->router->class == 'Autres_controles_questionnaires') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Question de Contrôle</p>
                  </a>
                </li>
              <?php  } ?>


              <li class="nav-item">
                <a href="<?= base_url('ihm/Identite/index') ?>" class="nav-link <?php if ($this->router->class == 'Identite') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Personnes interpellées(PSR)</p>
                </a>
              </li>


              <?php if ($this->session->userdata('PSR_ELEMENT') == 1) { ?>
                <li class="nav-item">
                  <a href="<?= base_url('ihm/Type_Verification/index') ?>" class="nav-link <?php if ($this->router->class == 'Type_Verification') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Source de Vérification</p>
                  </a>
                </li>
              <?php } ?>
              <?php if ($this->session->userdata('PSR_ELEMENT') == 1) { ?>
                <li class="nav-item">
                  <a href="<?= base_url('ihm/Question_Categorie/index') ?>" class="nav-link <?php if ($this->router->class == 'Question_Categorie') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Catégorie de Questions</p>
                  </a>
                </li>
              <?php } ?>



              <li class="nav-item">
                <a href="<?= base_url('ihm/Couleur/index') ?>" class="nav-link <?php if ($this->router->class == 'Couleur') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Couleur</p>
                </a>
              </li>

              <?php if ($this->session->userdata('PSR_ELEMENT') == 1) { ?>
                <li class="nav-item">
                  <a href="<?= base_url('ihm/Chaussee/index') ?>" class="nav-link <?php if ($this->router->class == 'Chaussee') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Chaussée</p>
                  </a>
                </li>

              <?php } ?>
              <li class="nav-item">
                <a href="<?= base_url('ihm/Gravite/index') ?>" class="nav-link <?php if ($this->router->class == 'Gravite') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gravité d'Accident</p>
                </a>
              </li>
            </ul>
          </li>
  <?php } ?>

  <!-- DONNNEES -->
  <?php if ($this->session->userdata('IMMATRICULATION') == 1 || $this->session->userdata('PERMIS') == 1 || $this->session->userdata('CONTROLE_TECHNIQUE') == 1 || $this->session->userdata('ASSURANCE') == 1 || $this->session->userdata('POLICE_JUDICIAIRE') == 1 || $this->session->userdata('TRANSPORT') == 1 ) { ?>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Obr_Immatriculation' || $this->router->class == 'Chauffeur_permis' || $this->router->class == 'Controle' || $this->router->class == 'Declaration_Vol' || $this->router->class == 'Transport'|| $this->router->class == 'Assurances') echo 'active'; ?>">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Données
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="font-size: 12px;">
              <?php if($this->session->userdata('IMMATRICULATION') == 1){ ?>
                <li class="nav-item">
                  <a href="<?= base_url('PSR/Obr_Immatriculation/index') ?>" class="nav-link <?php if ($this->router->class == 'Obr_Immatriculation') echo 'active'; ?>">
                    <i class="nav-icon fas fa-car-alt" style="color:green"></i>
                    <p>
                      BD infos Immatriculation(OBR)
                    </p>
                  </a>
                </li>
              <?php } ?>
              <?php if ($this->session->userdata('PERMIS') == 1) { ?>
                <li class="nav-item">
                  <a href="<?= base_url('PSR/Chauffeur_permis/index') ?>" class="nav-link <?php if ($this->router->class == 'Chauffeur_permis') echo 'active'; ?>">
                    <i class="nav-icon fas fa-address-book" style="color:green"></i>
                    <p>
                      BD Infos Permis(PSR)
                    </p>
                  </a>
                </li>
              <?php } ?>
              <?php if ($this->session->userdata('CONTROLE_TECHNIQUE') == 1) { ?>
                <li class="nav-item">
                  <a href="<?= base_url('PSR/Controle/index') ?>" class="nav-link <?php if ($this->router->class == 'Controle') echo 'active'; ?>">
                    <i class="nav-icon fas fa-edit" style="color:green"></i>
                    <p>
                      BD Infos Contrôle technique
                    </p>
                  </a>
                </li>

              <?php } ?>
              <?php if ($this->session->userdata('TRANSPORT') == 1) { ?>
                <li class="nav-item">
                  <a href="<?= base_url('PSR/Transport/index') ?>" class="nav-link <?php if ($this->router->class == 'Transport') echo 'active'; ?>">
                    <i class="nav-icon fas fa-bus" style="color:green"></i>
                    <p>
                       BD transport
                    </p>
                  </a>
                </li>
              <?php } ?>
              <?php if ($this->session->userdata('ASSURANCE') == 1) { ?>
                <li class="nav-item">
                  <a href="<?= base_url('PSR/Assurances/index') ?>" class="nav-link <?php if ($this->router->class == 'Assurances') echo 'active'; ?>">
                    <i class="nav-icon fas fa-american-sign-language-interpreting" style="color:green"></i>
                    <p>
                     BD Infos Assurance
                    </p>
                  </a>
                </li>
              <?php } ?>
              <?php if ($this->session->userdata('POLICE_JUDICIAIRE') == 1) { ?>
                <li class="nav-item">
                  <a href="<?= base_url('PSR/Declaration_Vol/index') ?>" class="nav-link <?php if ($this->router->class == 'Declaration_Vol') echo 'active'; ?>">
                    <i class="nav-icon fas fa-user-circle" style="color:green"></i>
                    <p>
                       BD Infos vol(PJ)
                    </p>
                  </a>
                </li>
              <?php } ?>
            </ul>
          </li>
        <?php } ?>


<!-- IHM -->
<?php if ($this->session->userdata('IHM') == 1) { ?>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Assureur' || $this->router->class == 'Verif_Permis' || $this->router->class == 'Notification' || $this->router->class == 'Citoyen'|| $this->router->class == 'Money') echo 'active'; ?>">
              <i class="nav-icon fa fa-desktop"></i>
              <p>
                IHM
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('ihm/Citoyen/index') ?>" class="nav-link <?php if ($this->router->class == 'Citoyen') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Citoyens </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('PSR/Assureur/index') ?>" class="nav-link <?php if ($this->router->class == 'Assureur') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Assureur</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('ihm/Money/index') ?>" class="nav-link <?php if ($this->router->class == 'Money') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monnaie</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('ihm/Notification/index') ?>" class="nav-link <?php if ($this->router->class == 'Notification') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Notification</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?= base_url('ihm/Verif_Permis/index') ?>" class="nav-link <?php if ($this->router->class == 'Verif_Permis') echo 'active'; ?>">
                  <i class="nav-icon far fa-circle"></i>
                  <p>Chauffeur</p>
                </a>
              </li>

            </ul>
          </li>
 <?php } ?>


 <!-- RH -->
 <?php if ($this->session->userdata('RH_FONCTIONNAIRE') == 1 || $this->session->userdata('RH_POSTE') == 1 || $this->session->userdata('RH_AFFECTATION') == 1) { ?>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Psr_elements'  ||  $this->router->class == 'Poste_Pnb' ||  $this->router->class == 'Psr_element_affectation' ) echo 'active'; ?>">
              <i class="nav-icon fas fa-object-group"></i>
              <p>
                RH
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
           <?php if ($this->session->userdata('RH_FONCTIONNAIRE') == 1) { ?>
              <li class="nav-item">
                <a href="<?= base_url('PSR/Psr_elements/index') ?>" class="nav-link <?php if ($this->router->class == 'Psr_elements' || $this->router->class == 'Performance_Police') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fonctionnaire de la PNB</p>
                </a>
              </li>
            <?php } ?>
            <?php if ($this->session->userdata('RH_POSTE') == 1) { ?>
              <li class="nav-item">
                <a href="<?= base_url('PSR/Poste_Pnb/index') ?>" class="nav-link <?php if ($this->router->class == 'Poste_Pnb') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Poste de la PNB</p>
                </a>
              </li>
            <?php } ?>
            <?php if ($this->session->userdata('RH_AFFECTATION') == 1) { ?>
              <li class="nav-item">
                <a href="<?= base_url('ihm/Psr_element_affectation/index') ?>" class="nav-link <?php if ($this->router->class == 'Psr_element_affectation') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Affectations de la PNB</p>
                </a>
              </li>
            <?php }  ?>
            </ul>
          </li>
<?php }  ?>


<!-- LES CHEFS DES MENAGE -->
<?php if ($this->session->userdata('CHEF_MENAGE') == 1 || $this->session->userdata('GESTION_CHEF_MENAGE') == 1 ) { ?>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Chefs_menage' || $this->router->class == 'Enclos' || $this->router->class == 'Chefs_menage_affectation') echo 'active'; ?>">
              <i class="nav-icon fa fa-user-md"></i>
              <p>
                Cahier de ménage
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if ($this->session->userdata('GESTION_CHEF_MENAGE') == 1) { ?>
              <li class="nav-item">
                <a href="<?= base_url('menage/Chefs_menage/') ?>" class="nav-link <?php if ($this->router->class == 'Chefs_menage') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Chefs des ménages</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?= base_url('menage/Chefs_menage_affectation') ?>" class="nav-link <?php if ($this->router->class == 'Chefs_menage_affectation') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Affectations des ches ménages</p>
                </a>
              </li>
              <?php }  ?>
              <?php if ($this->session->userdata('CHEF_MENAGE') == 1) { ?>
              <li class="nav-item">
                <a href="<?= base_url('appertement/Enclos/index') ?>" class="nav-link <?php if ($this->router->class == 'Enclos') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Enclos </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?= base_url('appertement/Enclos/habitant') ?>" class="nav-link <?php if ($this->router->class == 'Enclos') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Habitant</p>
                </a>
              </li>
              <?php }  ?>


            </ul>

          </li>

        <?php } ?>
<!-- VERIFICATION -->
<?php if ($this->session->userdata('DECLARATION') == 1 ) { ?>
          <li class="nav-item">
            <a href="<?= base_url('PSR/Vol_Controller/index')?>" class="nav-link <?php if ($this->router->class == 'Vol_Controller') echo 'active'; ?>">
              <i class="nav-icon fas fa-bell" aria-hidden="true"></i>
              <p>Déclaration  de vol </p>
            </a>
          </li>
<?php }  ?>
<!-- VERIFICATION -->
<?php if ($this->session->userdata('VERIFICATION') == 1 ) { ?>
          <li class="nav-item">
            <a href="<?= base_url('PSR/Historique/index') ?>" class="nav-link <?php if ($this->router->class == 'Historique') echo 'active'; ?>">
              <i class="nav-icon fa fa-history" aria-hidden="true"></i>
              <p>Vérification PNB</p>
            </a>
          </li>
<?php }  ?>

<!-- SIGNALEMENT -->
<?php if ($this->session->userdata('SIGNALEMENT') == 1 ) { ?>
           <li class="nav-item">
              <a href="<?= base_url('PSR/Validation_signalement') ?>" class="nav-link <?php if ($this->router->class == 'Validation_signalement') echo 'active'; ?>">
                <i class="fa fa-wifi nav-icon"></i>
                <p>Signalements</p>
              </a>
            </li>
<?php }  ?>

<!-- CONSTANT SUR UN CONTROLE -->
<?php if ($this->session->userdata('CONSTANT_SUR_CONTROLE') == 1 ) { ?>
           <li class="nav-item">
              <a href="<?= base_url('PSR/Commentaire/all_const') ?>" class="nav-link <?php if ($this->router->class == 'Commentaire') echo 'active'; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Constat sur Contrôle</p>
              </a>
            </li>
<?php }  ?>
<!-- FOURRIERE -->
<?php if ($this->session->userdata('FOURRIERE') == 1 ) { ?>
           <li class="nav-item">
              <a href="<?= base_url('ihm/Fourriere/') ?>" class="nav-link <?php if ($this->router->class == 'Fourriere') echo 'active'; ?>">
                <i class="fa fa-truck nav-icon"></i>
                <p>Fourrière</p>
              </a>
            </li>
<?php }  ?>
</ul>

    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>




<div class="modal fade" id="ImageConstatr" style="z-index: 1111111;">
       <div class="modal-dialog modal-lg" >
         <div class="modal-content">
           <div class="modal-header" style="background: black;">
           <!--  <div id="title"><b><h4 id="" style="color:#fff;font-size: 18px;"></h4>
              
            </div> -->
            <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </div>
         </div>
         <div class="modal-body">

           <div class="col-md-12" id="imageGet">
                        </div>
      </div>
      <div class="modal-footer"> 
          
      </div>
    </div>
  </div>
  </div>


  <script type="text/javascript">
    
    function get_imag(src) {
      
      $('#ImageConstatr').modal()
      $('#imageGet').html('<img src="'+src+'" width="100%" >')
    }
  </script>