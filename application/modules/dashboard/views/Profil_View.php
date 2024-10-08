


<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>



<style type="text/css">
.hidden {
    display: none;
}
  .wide-table {
    width: 1000%; /* Utilise toute la largeur disponible */
  }

  .mapbox-improve-map {
    display: none;
  }

  .leaflet-control-attribution {
    display: none !important;
  }

  .leaflet-control-attribution {
    display: none !important;
  }


  .mapbox-logo {
    display: none;
  }

  a
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
            <div class="col-sm-2">
             
            </div><!-- /.col -->
            <div class="col-sm-8">
              <div class="row">
              
             
                    
                    
                    </div>
            </div><!-- /.col -->
            <div class="form-group col-md-3"><h4 style='color:blue'>Mes Ponctualités</h4></div>
          
            <div class="form-group col-md-3">
                  <label  style='color:blue'>Avant  ou  après midi</label>
                  <select class="form-control input-sm" name="avant" id="avant" onchange='get_rapport()'>
                      <option value="">Avant  ou  après midi</option>
                      <option value="AM">Avant  midi </option>
                      <option value="PM">Après midi</option>
                      
                    </select>

            </div>
            <div class="col-sm-3 text-right">
              <span style="margin-right: 15px">
                <div  style="float:right;">
               <a  class='btn btn-warning btn-sm float-right' id='<?= $data['ID_UTILISATEUR'] ?>'  title='<?= $data['NOM_EMPLOYE'] ?>'  onclick='declarer("<?= $data['ID_UTILISATEUR'] ?>",this.title,this.id)' style='float:right'>
               <i class="nav-icon fas fa-plus"></i>
                    Déclarer Mon Statut
                  </a>
                
                </div>
               
              </span>

            </div><!-- /.col -->
            
            <div class="col-sm-3 text-right">
              <span style="margin-right: 15px">
                <div  style="float:right;" id="presenterButton"  class="hidden">
                
               <a  class='btn btn-primary btn-sm float-right' id='<?= $data['ID_UTILISATEUR'] ?>'  title='<?= $data['NOM_EMPLOYE'] ?>'  onclick='presenter("<?= $data['ID_UTILISATEUR'] ?>",this.title,this.id)' style='float:right'>
                    <i class="nav-icon fas fa-plus"></i>
                    Se présenter 
                  </a>
                
                </div>
               
              </span>

            </div><!-- /.col -->
            
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->


        <div class="card-body">
            <div class="row">
              <div id="container"  class="col-md-12" ></div>
              <div class="col-md-12" style="margin-bottom: 20px"></div>
              <div id="container1"  class="col-md-6" ></div>
              <div id="container2"  class="col-md-6" ></div>
            </div>
       </div>

</div>
</div>


<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content  modal-lg">
      <div class="modal-header">
        <h4 class="modal-title"><span id="titre"></span></h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id='mytable' class='table table-bordered table-striped table-hover table-condensed' >
            <thead>
             <th>#</th>
            <th>DATE </th>
            <th>STATUT/JUSTIFICATION</th>
            </thead>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Quitter</button>
      </div>
    </div>
  </div>
</div>
 

<div class="modal fade" id="myModal1" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content  modal-lg">
      <div class="modal-header">
        <h4 class="modal-title"><span id="titre1"></span></h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id='mytable1' class='table table-bordered table-striped table-hover table-condensed wide-table' >
            <thead>
             <th>#</th>
            <th>DATE </th>
            <th>PERIODE </th>

            </thead>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Quitter</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal2" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content  modal-lg">
      <div class="modal-header">
        <h4 class="modal-title"><span id="titre2"></span></h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed wide-table' >
            <thead>
             <th>#</th>
            <th>DATE </th>
            <th>PERIODE </th>

            </thead>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Quitter</button>
      </div>
    </div>
  </div>
</div>
 



</div>
</div></div></div>
<div id="nouveau">
    </div>
<div id="nouveau1">
    </div>
<div id="nouveau2">


</div>





<?php include VIEWPATH.'templates/footer.php'; ?>
</body>
</html>


<script type="text/javascript">
$( document ).ready(function() {
get_rapport();
checkNbre()
// alert();
});   

function checkNbre(){
var agence=$('#ID_AGENCE').val()
$.ajax({
url : "<?=base_url()?>dashboard/Dashboard_hebdomadaires/getNbre",
type : "POST",
dataType: "JSON",
cache:false,
success:function(data){   
  var nbresPM = data.nbrePM;
  var nbresAM = data.nbreAM;

  /* alert(nbresAM) */
            var currentHour = new Date().getHours();
            if ((currentHour >= 12 && nbresPM == 0) || (currentHour <= 12 && nbresAM == 0)) {
                $('#presenterButton').removeClass('hidden'); // Afficher le conteneur du bouton
            } else {
                $('#presenterButton').addClass('hidden'); // Masquer le bouton si la condition n'est pas remplie
            }

},            

});  
}


function get_rapport(){
var avant=$('#avant').val()
$.ajax({
url : "<?=base_url()?>dashboard/Dashboard_hebdomadaires/get_rapport_user",
type : "POST",
dataType: "JSON",
cache:false,
data:{
  avant:avant
},
success:function(data){   
  $('#container').html("");             
$('#nouveau').html(data.rapp );
$('#container1').html("");             
$('#nouveau1').html(data.rapp_absant );

$('#container2').html("");             
$('#nouveau2').html(data.rapp_conge );


},            

});  
}


function declarer(id,nom=null,prenom=null){
Swal.fire({
title: nom+' Souhaitez-vous déclarer ton statut?  ',
html: `
      <form id="declarationForm">
        <div class="row">
          <div class="col-md-6">
            <input type="hidden" class="form-control" name="ID_EMPLOYE" value="${id}">
            <label for="DEBUT">Date début</label>
            <input type="date" name="DEBUT" autocomplete="off" id="DEBUT" class="form-control">
          </div>
          <div class="col-md-6">
            <label for="FIN">Date fin</label>
            <input type="date" name="FIN" autocomplete="off" id="FIN" class="form-control">
          </div>
          <div class="col-md-6">
            <label for="PERIODE">Période</label>
            <select class="form-control" name="PERIODE" id="PERIODE">
              <option value="">---Sélectionner---</option>
              <option value="1">AM</option>
              <option value="2">PM</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="ID_MOTIF">Motif</label>
            <select class="form-control" name="ID_MOTIF" id="ID_MOTIF">
              <option value="">---Sélectionner---</option>
              <option value="1">Congé</option>
              <option value="3">Travailler  sur  terrain </option>
              <option value="4">En mission</option>
              <option value="5">En formation</option>

            </select>
          </div>
        </div>
      </form>
    `,
    showDenyButton: true,
    confirmButtonText: 'Enregistrer',
    denyButtonText: `Annuler`,
    preConfirm: () => {
      const debut = document.getElementById('DEBUT').value;
      const fin = document.getElementById('FIN').value;
      const periode = document.getElementById('PERIODE').value;
      const motif = document.getElementById('ID_MOTIF').value;

      if (!debut || !fin || !motif) {
        Swal.showValidationMessage('Veuillez remplir tous les champs');
        return false;
      }

      return {
        ID_UTILISATEUR:id,
        DEBUT: debut,
        FIN: fin,
        PERIODE: periode,
        ID_MOTIF: motif
      };
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = result.value;
      $.ajax({
        url: "<?=base_url()?>dashboard/Dashboard_hebdomadaires/declarer/",
        type: "POST",
        dataType: "JSON",
        cache: false,
        data: formData,
        success: function(data) {
          console.log(data);
          get_rapport();
          checkNbre();
          Swal.fire('Enregistré!', '', 'success');
        },
        error: function() {
          Swal.fire('Erreur de la connexion', '', 'info');
        }
      });
    }
  });
}


function presenter(id,nom=null,prenom=null){
Swal.fire({
title: nom+' Souhaitez-vous  vous présenter?  ',
html: `
      <form id="declarationForm">
      <input type="checkbox" id="present_checkbox">
          <label for="present_checkbox">Je me présente avec un motif</label><br>
          <textarea id="motif" placeholder="Tapez votre motif ici..." style="display:none; margin-top:10px;" class="form-control" rows="4"></textarea>
      </form>
    `,
    showDenyButton: true,
    confirmButtonText: 'Oui',
    denyButtonText: `Non`,
    
    didOpen: () => {
            $('#present_checkbox').on('change', function () {
                $('#motif').toggle(this.checked);
            });
        },
    preConfirm: () => {
      const checkbox = document.getElementById('present_checkbox').value;
      const motif = document.getElementById('motif').value;
      
            if (checkbox.checked && motif === "") {
                Swal.showValidationMessage('Veuillez entrer un motif');
                return false; // Empêche la fermeture de la boîte de dialogue
            }

            return {
                isChecked: checkbox.checked,
                motif: motif // Retourne la valeur du motif
            };
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = result.value;
      $.ajax({
        url: "<?=base_url()?>dashboard/Dashboard_hebdomadaires/presenter/",
        type: "POST",
        dataType: "JSON",
        cache: false,
        data: formData,
        success: function(data) {
          console.log(data);
          get_rapport();
          checkNbre();
          Swal.fire('Enregistré!', '', 'success');
        },
        error: function() {
          Swal.fire('Erreur de la connexion', '', 'info');
        }
      });
    }
  });
}
</script> 
