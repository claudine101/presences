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

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Droit/add'); ?>" >

                  <div class="row">
                    <div class="col-md-6">
                     <label for="Ftype">Profil</label>
                     <select required class="form-control" name="PROFIL_ID" id="PROFIL_ID">
                          <option value="">---Sélectionner---</option>
                          <?php
                            foreach ($profils as $value)
                            {
                          ?>
                          <option value="<?=$value['PROFIL_ID']?>"><?=$value['STATUT']?></option>
                          <?php
                            }
                          ?>
                        </select>

                    <?php echo form_error('PROFIL_ID', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2" style="margin-top:30pX">
                      <input type="checkbox" name="checkAll" onchange="cocher_all()" id="checkAll">
                      <label>Cocher tout</label>
                    </div>
                    <!-- <div class="col-md-2" style="margin-top:30pX">
                       <button id="selections" onclick='subForm()' class='btn btn-primary btn-sm' disabled>
                        <span class="badge badge-danger" id="nombress">0</span>
                          Soumettre
                        </button>
                    </div> -->
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label>IHM</label>
                      <div class="row">
                      <div class="col-md-6">
                      <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="INFRACTION" value="1" id="INFRACTION" >
                      <label class="form-check-label" for="INFRACTION">
                        Infractions
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="PSR_ELEMENT" value="1" id="PSR_ELEMENT">
                      <label class="form-check-label" for="PSR_ELEMENT">
                        Psr_element
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="PEINES" value="1" id="PEINES">
                      <label class="form-check-label" for="PEINES">
                        Peines
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="AFFECTATION" value="1" id="AFFECTATION">
                      <label class="form-check-label" for="AFFECTATION">
                        Affectation
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="PERMIS"  value="1" id="PERMIS" >
                      <label class="form-check-label" for="PERMIS">
                        Permis
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="DECLARATION" value="1" id="DECLARATION">
                      <label class="form-check-label" for="DECLARATION">
                        Declaration
                      </label>
                    </div>
                   <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="IMMATRICULATION" value="1" id="IMMATRICULATION">
                      <label class="form-check-label" for="IMMATRICULATION">
                        Immatriculation
                      </label>
                  </div>
                 <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="CONTROLE_TECHNIQUE" value="1" id="CONTROLE_TECHNIQUE">
                    <label class="form-check-label" for="CONTROLE_TECHNIQUE">
                      Controle_Technique
                    </label>
                </div>
               <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="ASSURANCE" value="1" id="ASSURANCE">
                  <label class="form-check-label" for="ASSURANCE">
                    Assurance
                  </label>
              </div>
               <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="QUESTIONNAIRE" value="1" id="QUESTIONNAIRE">
                  <label class="form-check-label" for="QUESTIONNAIRE">
                    Questionnaire
                  </label>
              </div>
              
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="SIGNALEMENT" value="1" id="SIGNALEMENT">
                <label class="form-check-label" for="SIGNALEMENT">
                  Signalement
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="VALIDATEUR" value="1" id="VALIDATEUR">
                <label class="form-check-label" for="VALIDATEUR">
                  Validateur
                </label>
              </div>
            
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="POLICE_JUDICIAIRE" value="1" id="POLICE_JUDICIAIRE">
                <label class="form-check-label" for="POLICE_JUDICIAIRE">
                  Police judiciaire
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TRANSPORT" value="1" id="TRANSPORT">
                <label class="form-check-label" for="TRANSPORT">
                  transport
                </label>
              </div>
              </div>
              <div class="col-md-6">
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="PARAMETRE" value="1" id="PARAMETRE">
                <label class="form-check-label" for="PARAMETRE">
                  paramètre
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="CONFIGURATION_DATA" value="1" id="CONFIGURATION_DATA">
                <label class="form-check-label" for="CONFIGURATION_DATA">
                  configuration data 
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="IHM" value="1" id="IHM">
                <label class="form-check-label" for="IHM">
                  IHM
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="RH_FONCTIONNAIRE" value="1" id="RH_FONCTIONNAIRE">
                <label class="form-check-label" for="RH_FONCTIONNAIRE">
                  RH fonctionnaire
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="RH_POSTE" value="1" id="RH_POSTE">
                <label class="form-check-label" for="RH_POSTE">
                  RH poste
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="RH_AFFECTATION" value="1" id="RH_AFFECTATION">
                <label class="form-check-label" for="RH_AFFECTATION">
                  RH affectation
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="VERIFICATION" value="1" id="VERIFICATION">
                <label class="form-check-label" for="VERIFICATION">
                  Vérification
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="CONSTANT_SUR_CONTROLE" value="1" id="CONSTANT_SUR_CONTROLE">
                <label class="form-check-label" for="CONSTANT_SUR_CONTROLE">
                  constant sur contrôles
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="FOURRIERE" value="1" id="FOURRIERE">
                <label class="form-check-label" for="FOURRIERE">
                  fourrière 
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="CHEF_MENAGE" value="1" id="CHEF_MENAGE">
                <label class="form-check-label" for="CHEF_MENAGE">
                  chef des ménages 
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="GESTION_CHEF_MENAGE" value="1" id="GESTION_CHEF_MENAGE">
                <label class="form-check-label" for="GESTION_CHEF_MENAGE">
                  gestions chefs ds ménages 
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="INSTITUTION" value="1" id="INSTITUTION">
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
                  <input class="form-check-input" type="checkbox" name="TB_PJ" value="1" id="TB_PJ">
                  <label class="form-check-label" for="TB_PJ">
                    TB pj
                  </label>
               </div>
              <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="TB_ASSURANCE" value="1" id="TB_ASSURANCE">
                  <label class="form-check-label" for="TB_ASSURANCE">
                    TB assurance
                  </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_IMMATRICULATION" value="1" id="TB_IMMATRICULATION">
                <label class="form-check-label" for="TB_IMMATRICULATION">
                  TB immatriculation
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_PERMIS" value="1" id="TB_PERMIS">
                <label class="form-check-label" for="TB_PERMIS">
                  TB permis
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_FINANCIER" value="1" id="TB_FINANCIER">
                <label class="form-check-label" for="TB_FINANCIER">
                  TB financier
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_AMANDE" value="1" id="TB_AMANDE">
                <label class="form-check-label" for="TB_AMANDE">
                  TB amande
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_POLICE" value="1" id="TB_POLICE">
                <label class="form-check-label" for="TB_POLICE">
                  TB police
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_SIGNALMENT" value="1" id="TB_SIGNALMENT">
                <label class="form-check-label" for="TB_SIGNALMENT">
                  TB signalement
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_CONSTANT" value="1" id="TB_CONSTANT">
                <label class="form-check-label" for="TB_CONSTANT">
                  TB constant
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_CONTROLE_RAPIDE" value="1" id="TB_CONTROLE_RAPIDE">
                <label class="form-check-label" for="TB_CONTROLE_RAPIDE">
                  TB contrôle rapide
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_CONTROLE_TECHNIQUE" value="1" id="TB_CONTROLE_TECHNIQUE">
                <label class="form-check-label" for="TB_CONTROLE_TECHNIQUE">
                  TB  contrôle  technique
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_AUTRE_CONTROLE" value="1" id="TB_AUTRE_CONTROLE">
                <label class="form-check-label" for="TB_AUTRE_CONTROLE">
                  TB autre contrôle 
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="TB_TRANSPORT" value="1" id="TB_TRANSPORT">
                <label class="form-check-label" for="TB_TRANSPORT">
                  TB Transport 
                </label>
              </div>
          </div>
          <div class="col-md-3">
            <label>Geo</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="MAP_CENTRE_SITUATION" value="1" id="MAP_CENTRE_SITUATION">
                <label class="form-check-label" for="MAP_CENTRE_SITUATION">
                  MAP centre situation
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="MAP_AGENT_POLICE" value="1" id="MAP_AGENT_POLICE">
                <label class="form-check-label" for="MAP_AGENT_POLICE">
                  MAP agent police 
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="MAP_SIGNALEMENT" value="1" id="MAP_SIGNALEMENT">
                <label class="form-check-label" for="MAP_SIGNALEMENT">
                  MAP signalement 
                </label>
              </div>

                      
          </div>

      </div>
      <div class="col-md-12" style="margin-top:31px;">
                      <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
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
  function send()
  {
    var test=$('#PERMIS').val();
    alert(test);
  }
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
 function subForm()
 {
    Swal.fire({
      title: 'Souhaitez-vous consulter l\'avis du  partenaire pour le traitement de ce constat?',
      showDenyButton: true,
      // showCancelButton: true,
      confirmButtonText: 'oui',
      denyButtonText: `Non`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $('#myForm').submit()
        Swal.fire('Confirmé!', '', 'success')
      } else if (result.isDenied) {
        Swal.fire('Non Confirmé', '', 'info')
      }
    })
    
 }
</script>














