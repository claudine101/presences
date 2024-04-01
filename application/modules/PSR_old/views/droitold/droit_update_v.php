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
              <a href="<?=base_url('PSR/Droit/index')?>" class='btn btn-primary float-right'>
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

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Droit/update'); ?>" >
                 <input type="hidden" class="form-control" name="ID_DROIT" value="<?=$data['ID_DROIT']?>" >
                 <div class="row">
                  <div class="col-md-6">
                    <label for="Ftype">Profil</label>
                    <select class="form-control" name="PROFIL_ID" id="PROFIL_ID" onchange="get_communes();">
                      <!-- <option value="">---Sélectionner---</option> -->
                      <?php

                      foreach ($profils as $value)
                      {

                        $selected="";
                        if($value['PROFIL_ID']==$data['PROFIL_ID'])
                        {
                          $selected="selected";
                        }
                        ?>
                        <option value="<?=$value['PROFIL_ID']?>" <?=$selected?>><?=$value['STATUT']?></option>
                        <?php
                      }
                      ?>
                    </select>
                    <div><font color="red" id="error_profil"></font></div> 
                  </div>
                </div>

                <div class="row">

                 
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="INFRACTION" <?= $chec1?> value="<?=  $data['INFRACTION']?>" id="INFRACTION" >
                      <label class="form-check-label" for="INFRACTION">
                        Infractions
                      </label>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="PSR_ELEMENT" <?= $chec2?> value="<?= $data['PSR_ELEMENT'] ?>" id="PSR_ELEMENT">
                      <label class="form-check-label" for="PSR_ELEMENT">
                        Psr_element
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="PEINES" <?= $chec3?> value="<?= $data['PEINES']?>"id="PEINES">
                      <label class="form-check-label" for="PEINES">
                        Peines
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="AFFECTATION" <?= $chec4?> value="<?= $data['AFFECTATION'] ?>" id="AFFECTATION">
                      <label class="form-check-label" for="AFFECTATION">
                        Affectation
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="PERMIS" <?= $chec5?> value="<?= $data['PERMIS']?>" id="PERMIS">
                      <label class="form-check-label" for="PERMIS">
                        Permis
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="DECLARATION" <?= $chec6?> value="<?= $data['DECLARATION'] ?>" id="DECLARATION">
                      <label class="form-check-label" for="DECLARATION">
                        Declaration
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                   <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="IMMATRICULATION" <?= $chec7?> value="<?= $data['IMMATRICULATION'] ?>" id="IMMATRICULATION">
                    <label class="form-check-label" for="IMMATRICULATION">
                      Immatriculation
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                 <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="CONTROLE_TECHNIQUE" <?= $chec8?> value="<?= $data['CONTROLE_TECHNIQUE'] ?>" id="CONTROLE_TECHNIQUE">
                  <label class="form-check-label" for="CONTROLE_TECHNIQUE">
                    Controle_Technique
                  </label>
                </div>
              </div>
              <div class="col-md-6">
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="ASSURANCE" <?= $chec9?> value="<?= $data['ASSURANCE']?>" id="ASSURANCE">
                <label class="form-check-label" for="ASSURANCE">
                  Assurance
                </label>
              </div>
            </div>

            <div class="col-md-6">
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="QUESTIONNAIRE" <?= $chec10?> value="<?= $data['QUESTIONNAIRE']?>" id="QUESTIONNAIRE">
                <label class="form-check-label" for="QUESTIONNAIRE">
                  Questionnaire
                </label>
              </div>
            </div>

          </div>

          <div class="col-md-6" style="margin-top:31px;">
            <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Modifier</button>
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



