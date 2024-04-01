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
                  </div>

                 <div class="row">
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="INFRACTION" value="1" id="INFRACTION" >
                      <label class="form-check-label" for="INFRACTION">
                        Infractions
                      </label>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="PSR_ELEMENT" value="1" id="PSR_ELEMENT">
                      <label class="form-check-label" for="PSR_ELEMENT">
                        Psr_element
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="PEINES" value="1" id="PEINES">
                      <label class="form-check-label" for="PEINES">
                        Peines
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="AFFECTATION" value="1" id="AFFECTATION">
                      <label class="form-check-label" for="AFFECTATION">
                        Affectation
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="PERMIS"  value="1" id="PERMIS" >
                      <label class="form-check-label" for="PERMIS">
                        Permis
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="DECLARATION" value="1" id="DECLARATION">
                      <label class="form-check-label" for="DECLARATION">
                        Declaration
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                   <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="IMMATRICULATION" value="1" id="IMMATRICULATION">
                    <label class="form-check-label" for="IMMATRICULATION">
                      Immatriculation
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                 <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="CONTROLE_TECHNIQUE" value="1" id="CONTROLE_TECHNIQUE">
                  <label class="form-check-label" for="CONTROLE_TECHNIQUE">
                    Controle_Technique
                  </label>
                </div>
              </div>
              <div class="col-md-6">
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="ASSURANCE" value="1" id="ASSURANCE">
                <label class="form-check-label" for="ASSURANCE">
                  Assurance
                </label>
              </div>
            </div>
            <div class="col-md-6">
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="QUESTIONNAIRE" value="1" id="QUESTIONNAIRE">
                <label class="form-check-label" for="QUESTIONNAIRE">
                  Questionnaire
                </label>
              </div>
            </div>

          </div>

          <div class="col-md-6" style="margin-top:31px;">
            <button type="Submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
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
</script>














