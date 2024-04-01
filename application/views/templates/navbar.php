<!-- Navbar -->
<?php
    setlocale(LC_TIME, 'fr_FR');
    date_default_timezone_set('Europe/Paris');
    if (setlocale(LC_TIME, 'fr_FR') == '') {
        setlocale(LC_TIME, 'FRA');  //correction problème pour windows
        $format_jour = '%#d';
    } else {
        $format_jour = '%e';
    }

?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="" class="nav-link">Accueil&nbsp;&nbsp;&nbsp;</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="" class="nav-link">  <div class="row"><div class=""><?=  utf8_encode(strftime("%A $format_jour %B %Y", strtotime(date('Y-m-d')))); ?></div>&nbsp;-&nbsp;<div style="font-weight: bold;" id="heure_exacte"></div></div></a>
      <!-- <div class="row">
        <div class="col-sm-12" id="heure"></div>
    </div>
    <div class="row">
        <div class="col-sm-12" id="date"></div>
    </div> -->
    </li>
  </ul>

  <!-- SEARCH FORM -->
  <form class="form-inline ml-6">
    <div class="input-group input-group-sm">
          <?php
            
            if ($this->router->class == 'Carte_Centre_Situation') {
              ?>
<!--               <marquee><h6 style="font-family:  Impact, Haettenschweiler, Franklin Gothic, Charcoal, Helvetica Inserat, Bitstream Vera Sans Bold, Arial Black, sans serif;"><font color="red"><b>Dernier </b></font>  <?=$dernier['DESCRIPTION'].'   '.$dernier['NUMERO']?> - date <?=$dernier['DATE_INSERTION']?>  - Poste: <?= $dernier['LIEU_EXACTE']?> - Agent <?= $dernier['NOM']?> <?= $dernier['PRENOM']?> N° matricule  <b><?= $dernier['NUMERO_MATRICULE']?></b> </h6></marquee>
 -->              <?php
            }
          ?>
     
    </div>
  </form> 

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-flag"></i>
        <span class="badge badge-danger navbar-badge">2</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="<?php echo base_url(); ?>Language/index/french" class="dropdown-item">
        FR</a>

        <a href="<?php echo base_url(); ?>Language/index/french" class="dropdown-item">
        ENG</a>
      </div>
    
    </li>



    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
       <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-user-cog"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="<?=base_url('Change_Password')?>" class="dropdown-item">
          <i class="fas fa-key mr-2"></i> Modifier le mot de passe
        </a>
        <div class="dropdown-divider"></div>
        <a href="<?=base_url('Login/do_logout')?>" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
        </a>
      </div>
    </li> 
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-th-large"></i>
      </a>
    </li> -->
  </ul>
</nav>
<!-- /.navbar -->
