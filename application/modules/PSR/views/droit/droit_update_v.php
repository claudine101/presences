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
                  <div class="col-md-2"></div>
                  <div class="col-md-2" style="margin-top:30pX">
                      <input type="checkbox" name="checkAll" onchange="cocher_all()" id="checkAll">
                      <label>Cocher tout</label>
                  </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>IHM</label>
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="INFRACTION" <?= $chec1?> value="<?=  $data['INFRACTION']?>" id="INFRACTION" >
                                  <label class="form-check-label" for="INFRACTION">
                                    Infractions
                                  </label>
                             </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="PSR_ELEMENT" <?= $chec2?> value="<?= $data['PSR_ELEMENT'] ?>" id="PSR_ELEMENT">
                              <label class="form-check-label" for="PSR_ELEMENT">
                                Psr_element
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="PEINES" <?= $chec3?> value="<?= $data['PEINES']?>"id="PEINES">
                              <label class="form-check-label" for="PEINES">
                                Peines
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="AFFECTATION" <?= $chec4?> value="<?= $data['AFFECTATION'] ?>" id="AFFECTATION">
                              <label class="form-check-label" for="AFFECTATION">
                                Affectation
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="PERMIS" <?= $chec5?> value="<?= $data['PERMIS']?>" id="PERMIS">
                              <label class="form-check-label" for="PERMIS">
                                Permis
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="DECLARATION" <?= $chec6?> value="<?= $data['DECLARATION'] ?>" id="DECLARATION">
                              <label class="form-check-label" for="DECLARATION">
                                Declaration
                              </label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="IMMATRICULATION" <?= $chec7?> value="<?= $data['IMMATRICULATION'] ?>" id="IMMATRICULATION">
                            <label class="form-check-label" for="IMMATRICULATION">
                              Immatriculation
                            </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="CONTROLE_TECHNIQUE" <?= $chec8?> value="<?= $data['CONTROLE_TECHNIQUE'] ?>" id="CONTROLE_TECHNIQUE">
                        <label class="form-check-label" for="CONTROLE_TECHNIQUE">
                          Controle_Technique
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="ASSURANCE" <?= $chec9?> value="<?= $data['ASSURANCE']?>" id="ASSURANCE">
                        <label class="form-check-label" for="ASSURANCE">
                          Assurance
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="QUESTIONNAIRE" <?= $chec10?> value="<?= $data['QUESTIONNAIRE']?>" id="QUESTIONNAIRE">
                        <label class="form-check-label" for="QUESTIONNAIRE">
                          Questionnaire
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="SIGNALEMENT" <?= $chec11?> value="<?= $data['SIGNALEMENT']?>" id="SIGNALEMENT">
                        <label class="form-check-label" for="SIGNALEMENT">
                          Signalement
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="VALIDATEUR" <?= $chec12?> value="<?= $data['VALIDATEUR']?>" id="VALIDATEUR">
                        <label class="form-check-label" for="VALIDATEUR">
                          Validateur
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="POLICE_JUDICIAIRE"  <?= $POLICE_JUDICIAIRE?> value="<?= $data['POLICE_JUDICIAIRE']?>" id="POLICE_JUDICIAIRE">
                        <label class="form-check-label" for="POLICE_JUDICIAIRE">
                          Police judiciaire
                        </label>
                      </div>
                      <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="TRANSPORT"  <?= $TRANSPORT?> value="<?= $data['TRANSPORT']?>"  id="TRANSPORT">
                          <label class="form-check-label" for="TRANSPORT">
                            transport
                          </label>
                     </div>
               </div>
              <div class="col-md-6">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" name="PARAMETRE"  <?= $PARAMETRE?> value="<?= $data['PARAMETRE']?>"  id="PARAMETRE">
                <label class="form-check-label" for="PARAMETRE">
                  Paramètre
                </label>
              </div>
                <div class="form-check">
                <input class="form-check-input" type="checkbox" name="CONFIGURATION_DATA"  <?= $CONFIGURATION_DATA?> value="<?= $data['CONFIGURATION_DATA']?>"  id="CONFIGURATION_DATA">
                <label class="form-check-label" for="CONFIGURATION_DATA">
                  configuration data 
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="IHM"  <?= $IHM?> value="<?= $data['IHM']?>"  id="IHM">
                <label class="form-check-label" for="IHM">
                  IHM
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="RH_FONCTIONNAIRE"  <?= $RH_FONCTIONNAIRE?> value="<?= $data['RH_FONCTIONNAIRE']?>"  id="RH_FONCTIONNAIRE">
                <label class="form-check-label" for="RH_FONCTIONNAIRE">
                  RH fonctionnaire
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="RH_POSTE"  <?= $RH_POSTE?> value="<?= $data['RH_POSTE']?>"  id="RH_POSTE">
                <label class="form-check-label" for="RH_POSTE">
                  RH poste
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="RH_AFFECTATION"  <?= $RH_AFFECTATION?> value="<?= $data['RH_AFFECTATION']?>"  id="RH_AFFECTATION">
                <label class="form-check-label" for="RH_AFFECTATION">
                  RH affectation
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="VERIFICATION"  <?= $VERIFICATION?> value="<?= $data['VERIFICATION']?>"  id="VERIFICATION">
                <label class="form-check-label" for="VERIFICATION">
                  Vérification
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="CONSTANT_SUR_CONTROLE"  <?= $CONSTANT_SUR_CONTROLE?> value="<?= $data['CONSTANT_SUR_CONTROLE']?>"  id="CONSTANT_SUR_CONTROLE">
                <label class="form-check-label" for="CONSTANT_SUR_CONTROLE">
                  constant sur contrôles
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="FOURRIERE"  <?= $FOURRIERE?> value="<?= $data['FOURRIERE']?>"  id="FOURRIERE">
                <label class="form-check-label" for="FOURRIERE">
                  fourrière 
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="CHEF_MENAGE"  <?= $CHEF_MENAGE?> value="<?= $data['CHEF_MENAGE']?>"  id="CHEF_MENAGE">
                <label class="form-check-label" for="CHEF_MENAGE">
                  chefs des ménages  
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="GESTION_CHEF_MENAGE"  <?= $GESTION_CHEF_MENAGE?> value="<?= $data['GESTION_CHEF_MENAGE']?>"  id="GESTION_CHEF_MENAGE">
                <label class="form-check-label" for="GESTION_CHEF_MENAGE">
                  gestion chefs des ménages   
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="INSTITUTION"  <?= $INSTITUTION?> value="<?= $data['INSTITUTION']?>"  id="INSTITUTION">
                <label class="form-check-label" for="INSTITUTION">
                   gestions des institutions   
                </label>
              </div>
              </div>
        </div>
        </div>
        <div class="col-md-3">
           <label>Tableau de Bord</label>
           <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_PJ"  <?= $TB_PJ?> value="<?= $data['TB_PJ']?>"  id="TB_PJ">
                <label class="form-check-label" for="TB_PJ">
                  TB pj
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_ASSURANCE"  <?= $TB_ASSURANCE?> value="<?= $data['TB_ASSURANCE']?>"  id="TB_ASSURANCE">
                <label class="form-check-label" for="TB_ASSURANCE">
                  TB assurance
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_IMMATRICULATION"  <?= $TB_IMMATRICULATION?> value="<?= $data['TB_IMMATRICULATION']?>"  id="TB_IMMATRICULATION">
                <label class="form-check-label" for="TB_IMMATRICULATION">
                  TB immatriculation
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_PERMIS"  <?= $TB_PERMIS?> value="<?= $data['TB_PERMIS']?>"  id="TB_PERMIS">
                <label class="form-check-label" for="TB_PERMIS">
                  TB permis
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_FINANCIER"  <?= $TB_FINANCIER?> value="<?= $data['TB_FINANCIER']?>"  id="TB_FINANCIER">
                <label class="form-check-label" for="TB_FINANCIER">
                  TB financier
                </label>
                </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_AMANDE"  <?= $TB_AMANDE?> value="<?= $data['TB_AMANDE']?>"  id="TB_AMANDE">
                <label class="form-check-label" for="TB_AMANDE">
                  TB amande
                </label>
              </div>
            
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_POLICE"  <?= $TB_POLICE?> value="<?= $data['TB_POLICE']?>"  id="TB_POLICE">
                <label class="form-check-label" for="TB_POLICE">
                  TB police
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_SIGNALMENT"  <?= $TB_SIGNALMENT?> value="<?= $data['TB_SIGNALMENT']?>"  id="TB_SIGNALMENT">
                <label class="form-check-label" for="TB_SIGNALMENT">
                  TB signalement
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_CONSTANT"  <?= $TB_CONSTANT?> value="<?= $data['TB_CONSTANT']?>"  id="TB_CONSTANT">
                <label class="form-check-label" for="TB_CONSTANT">
                  TB constant
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_CONTROLE_RAPIDE"  <?= $TB_CONTROLE_RAPIDE?> value="<?= $data['TB_CONTROLE_RAPIDE']?>"  id="TB_CONTROLE_RAPIDE">
                <label class="form-check-label" for="TB_CONTROLE_RAPIDE">
                  TB contrôle rapide
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_CONTROLE_TECHNIQUE"  <?= $TB_CONTROLE_TECHNIQUE?> value="<?= $data['TB_CONTROLE_TECHNIQUE']?>" id="TB_CONTROLE_TECHNIQUE">
                <label class="form-check-label" for="TB_CONTROLE_TECHNIQUE">
                  TB  contrôle  technique
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_AUTRE_CONTROLE"  <?= $TB_AUTRE_CONTROLE?> value="<?= $data['TB_AUTRE_CONTROLE']?>"  id="TB_AUTRE_CONTROLE">
                <label class="form-check-label" for="TB_AUTRE_CONTROLE">
                  TB autre contrôle 
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_TRANSPORT" <?= $TB_TRANSPORT?> value="<?= $data['TB_TRANSPORT']?>"  id="TB_TRANSPORT">
                <label class="form-check-label" for="TB_TRANSPORT">
                  TB Transport 
                </label>
              </div>

        </div>
        <div class="col-md-3">
          <label>Geo</label>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="MAP_CENTRE_SITUATION"  <?= $MAP_CENTRE_SITUATION?> value="<?= $data['MAP_CENTRE_SITUATION']?>"  id="MAP_CENTRE_SITUATION">
                <label class="form-check-label" for="MAP_CENTRE_SITUATION">
                  MAP centre situation
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="MAP_AGENT_POLICE"  <?= $MAP_AGENT_POLICE?> value="<?= $data['MAP_AGENT_POLICE']?>"  id="MAP_AGENT_POLICE">
                <label class="form-check-label" for="MAP_AGENT_POLICE">
                  MAP agent police 
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="MAP_SIGNALEMENT"  <?= $MAP_SIGNALEMENT?> value="<?= $data['MAP_SIGNALEMENT']?>"  id="MAP_SIGNALEMENT">
                <label class="form-check-label" for="MAP_SIGNALEMENT">
                  MAP signalement 
                </label>
              </div>
            </div>
          </div>
          <div class="col-md-12" style="margin-top:31px;">
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
<script type="text/javascript">

function cocher_all(){
     const firstInput = document.getElementsByName('checkAll');
     var i = 0;
            if (firstInput[0].checked) {
                $("input[type=checkbox]").each(function() {
               this.checked = true; 
                   if (this.value > 0) {
                      i++
                      console.log(this.value)
                   }
                                      
            });
            }else{
               $(':checkbox').each(function() {
               this.checked = false;                       
            });
          }
       if(i>0){
          $('#selections').prop('disabled',false)
        }
        else{
          $('#selections').prop('disabled',true)
        }
        $('#nombress').html(i)


 }
</script>
 



