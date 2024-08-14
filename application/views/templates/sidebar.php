

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
    background-image: url('<?= base_url() ?>/upload/agence.jpg');
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

  <?php $image = !empty($this->session->userdata('ICON_LOGO')) ? $this->session->userdata('ICON_LOGO') : "receca.png";


         if ($this->session->userdata('PROFIL_ID') == 2) {

        $inputs = $this->session->userdata('ID_INSTITUTION');

        $condition =  " AND ID_ASSUREUR =".$inputs;


        $assureur = $this->Model->getRequeteOne('SELECT ID_ASSUREUR, ASSURANCE,ICON_LOGO FROM assureur WHERE 1 '.$condition.'  ORDER BY ASSURANCE ASC');

        $icon_logo = $this->Model->getRequeteOne('SELECT ICON_LOGO FROM assureur WHERE ID_ASSUREUR='.$inputs);
        
        $assureur = $assureur['ASSURANCE'];
        $logo = $icon_logo['ICON_LOGO'];


       }else{
        
       $assureur = "";
       $logo=!empty($this->session->userdata('ICON_LOGO')) ? $this->session->userdata('ICON_LOGO') : "receca.png";
       }
       $logo=!empty($this->session->userdata('PHOTO_EMPLOYE')) ? $this->session->userdata('PHOTO_EMPLOYE') : "receca.png";


   ?>

  
        <!-- <a href="#" class="d-block"><img src="<?= $image ?>" id="imageLogo"> <?= $assureur ?> </a> -->
         <img height="13.5%" width="100%" src="<?= $logo?>" alt="" class="brand-image">
      
 
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        
        <a href="#" class="d-block"><?= $this->session->userdata('NOM_EMPLOYE') ?>  <?= $this->session->userdata('PRENOM_EMPLOYE') ?> </a>
        <a href="#" class="d-block"><i class="fa fa-email"></i> <?= $this->session->userdata('USERNAME') ?></a>

      </div>
      <!--  <div class="info">
       
      </div> -->
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">


      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Dashboard_annuel' ||$this->router->class == 'Dashboard_presence' ||$this->router->class =='Dashboard_hebdomadaire'  ||$this->router->class =='Dashboard_hebdomadaires')  echo 'active'; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Tableau de bord 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
            <?php if ($this->session->userdata('ID_PROFIL') == 5  ||$this->session->userdata('ID_PROFIL') == 3 || $this->session->userdata('ID_PROFIL') == 1 || $this->session->userdata('ID_PROFIL') == 2) { ?>
            <li class="nav-item">
                <a href="<?= base_url('dashboard/Dashboard_hebdomadaires') ?>" class="nav-link <?php if ($this->router->class == 'Dashboard_hebdomadaires') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mes ponctualites</p>
                </a>
              </li>
              <?php } ?>
            <?php if ($this->session->userdata('ID_PROFIL') == 2 ||  $this->session->userdata('ID_PROFIL') == 4 || $this->session->userdata('ID_PROFIL') == 5) { ?>

              <li class="nav-item">
                <a href="<?= base_url('dashboard/Dashboard_hebdomadaire') ?>" class="nav-link <?php if ($this->router->class == 'Dashboard_hebdomadaire') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rapport hebdomadaire </p>
                </a>
              </li>
              <?php } ?>
              <?php if ($this->session->userdata('ID_PROFIL') == 2 ||  $this->session->userdata('ID_PROFIL') == 4 || $this->session->userdata('ID_PROFIL') == 5) { ?>

              <li class="nav-item">
                <a href="<?= base_url('dashboard/Dashboard_annuel') ?>" class="nav-link <?php if ($this->router->class == 'Dashboard_annuel') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rapport annuel </p>
                </a>
              </li>
            <?php } ?>

            <?php if ($this->session->userdata('ID_PROFIL') == 2 ||$this->session->userdata('ID_PROFIL') == 4 || $this->session->userdata('ID_PROFIL') == 5) { ?>
              <li class="nav-item">
                <a href="<?= base_url('dashboard/Dashboard_presence') ?>" class="nav-link <?php if ($this->router->class == 'Dashboard_presence') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rapport global</p>
                </a>
              </li>
              <?php } ?>

            </ul>
              </li>
          <?php if ($this->session->userdata('ID_PROFIL') == 2 ||$this->session->userdata('ID_PROFIL') == 4 || $this->session->userdata('ID_PROFIL') == 5) { ?>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class == 'Utilisateurs'  || $this->router->class == 'Profils' || $this->router->class == 'Droit') echo 'active'; ?>">
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
            </ul>

          </li>
          <?php } ?>
          <!-- IHM -->
          <?php if ($this->session->userdata('ID_PROFIL') == 2 ||$this->session->userdata('ID_PROFIL') == 4 || $this->session->userdata('ID_PROFIL') == 5) { ?>

          <li class="nav-item">
            <a href="#" class="nav-link <?php if ($this->router->class =='Presences'||$this->router->class =='Employes'||$this->router->class =='Agences'||$this->router->class =='Provinces'||$this->router->class =='Communes' ||$this->router->class =='Zones' ||$this->router->class =='Collines') echo 'active'; ?>">
              <i class="nav-icon fa fa-desktop"></i>
              <p>
                IHM
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                  <a href="<?= base_url('donnees/Employes/index') ?>" class="nav-link <?php if ($this->router->class == 'Employes') echo 'active'; ?>">
                    <!-- <i class="nav-icon fas fa-user-circle" style="color:green"></i> -->
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                       Employes
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('donnees/Presences/index') ?>" class="nav-link <?php if ($this->router->class == 'Presences') echo 'active'; ?>">
                    <!-- <i class="nav-icon fas fa-user-circle" style="color:green"></i> -->
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                       Presences
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('ihm/Agences/index') ?>" class="nav-link <?php if ($this->router->class == 'Agences') echo 'active'; ?>">
                    <!-- <i class="nav-icon fas fa-user-circle" style="color:green"></i> -->
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                       Agences
                    </p>
                  </a>
                </li>
              <li class="nav-item">
                <a href="<?= base_url('ihm/Provinces/index') ?>" class="nav-link <?php if ($this->router->class == 'Provinces') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Provinces </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('ihm/Communes/index') ?>" class="nav-link <?php if ($this->router->class == 'Communes') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Communes </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('ihm/Zones/index') ?>" class="nav-link <?php if ($this->router->class == 'Zones') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Zones </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('ihm/Collines/index') ?>" class="nav-link <?php if ($this->router->class == 'Collines') echo 'active'; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Collines </p>
                </a>
              </li>

            </ul>
          </li>
          <?php } ?>
      
 <!-- CONFIGURATION -->
 <?php if ($this->session->userdata('ID_PROFIL') == 2 ||$this->session->userdata('ID_PROFIL') == 4 || $this->session->userdata('ID_PROFIL') == 5) { ?>

  <li class="nav-item">
          <a href="#" class="nav-link <?php if ($this->router->class == 'Qr_presence') echo 'active'; ?>">

              <i class="nav-icon fa fa-history"></i>
              <p>
                Configuration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="<?= base_url('donnees/Qr_presence/index') ?>" class="nav-link <?php if ($this->router->class == 'Qr_presence') echo 'active'; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Generation de QRcode</p>
                  </a>
                </li>
               
            </ul>
          </li>
          <?php } ?>
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