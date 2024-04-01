<section class="content" style="background-color: #f1f1f100;">
  <div class="col-md-12 col-xl-12 grid-margin stretch-card">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
      </div>
    </div>
    <div class="row"> 

      <?php if(!empty($immatriculation)) { ?>

        <div class="col-md-12">
          <div class="card mb-4 mb-md-0">
            <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Immatriculation</h3>
            <div class="card-body">
              <?=  $immatriculation  ?>
            </div>
          </div>
        </div>
      <?php } else {?>
        <div class="col-md-12">
          <div class="card mb-4 mb-md-0">
            <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Immatriculation</h3>
            <div class="card-body">
              <div class="alert alert-success" role="alert">
                L'immatriculation est correcte
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(!empty($assurance)) { ?>

          <div class="col-md-12">
          <div class="card mb-4 mb-md-0">
           <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Assurance</h3>
            <div class="card-body">
                <?= $assurance ?>
            </div>
          </div>
        </div>
      <?php } else {?>
        <div class="col-md-12">
          <div class="card mb-4 mb-md-0">
           <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Assurance</h3>
            <div class="card-body">
              <div class="alert alert-success" role="alert">
                L'assurance est correcte
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(!empty($controle_technique)) { ?>
        <div class="col-md-12">
          <div class="card mb-4 mb-md-0">
           <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Contrôle Technique</h3>
            <div class="card-body">
               <?=  $controle_technique  ?>
            </div>
          </div>
        </div>

      <?php } else {?>
        <div class="col-md-12">
          <div class="card mb-4 mb-md-0">
           <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Contrôle Technique</h3>
            <div class="card-body">
              <div class="alert alert-success" role="alert">
                Le Contrôle technique est correct
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if(!empty($vol)) { ?>

         <div class="col-md-12">
          <div class="card mb-4 mb-md-0">
           <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Déclaration du vol</h3>
            <div class="card-body">
               <?=  $vol  ?>
            </div>
          </div>
        </div>

      <?php } else {?>
        <div class="col-md-12">
          <div class="card mb-4 mb-md-0">
           <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Déclaration du vol</h3>
            <div class="card-body">
              <div class="alert alert-success" role="alert">
                pas de vol
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      

      <?php if(!empty($permis)) { ?>

          <div class="col-md-12">
          <div class="card mb-4 mb-md-0">
           <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Contrôle Permis</h3>
            <div class="card-body">
              <div class="alert alert-success" role="alert">
                 <?=  $permis  ?>
              </div>
            </div>
          </div>
        </div>


      <?php } else {?>

        <div class="col-md-12">
          <div class="card mb-4 mb-md-0">
           <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Contrôle Permis</h3>
            <div class="card-body">
              <div class="alert alert-success" role="alert">
                Le pemis est en regle
              </div>
            </div>
          </div>
        </div>

      <?php } ?>

   

      <?php if(!empty($detailControle)) { ?>
        <div class="col-md-12">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
              <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Contrôle Physique</h3>
              <div class="card-body">
                <?=  $detailControle  ?>
              </div>
            </div>
          </div>
        </div>
     
      <?php } ?>

      <?php if(!empty($equipement)) { ?>
        <div class="col-md-12">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
             <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Contrôle equipement</h3>
              <div class="card-body">
                <?=  $equipement  ?>
              </div>
            </div>
          </div>
        </div>
     
      <?php } ?>

       <?php if(!empty($marchandise)) { ?>
        <div class="col-md-12">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
             <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Contrôle marchandise</h3>
              <div class="card-body">
                <?=  $marchandise  ?>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
       

      <?php if(!empty($comportement)) { ?>

       <div class="col-md-12">
          <div class="card mb-4 mb-md-0">
            <div class="card-body">
             <h3 style="float:center; color: #333; text-align: center; font-size: 13px;">Comportement du chauffeur</h3>
              <?=  $comportement  ?>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>




    
     

    </div>
  </div>
</div>
  </section>


