


<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>



<style type="text/css">
.hidden {
    display: none;
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
            <div class="form-group col-md-3"><h4 style='color:blue'>Rapport annuel</h4></div>
            <div class="form-group col-md-3">
                    <label  style='color:blue'>agences</label>
                    <select class="form-control input-sm" name="ID_AGENCE" id="ID_AGENCE" onchange='get_rapport()'>
                      <option value="">agences</option>
                      <?php foreach ($agences as $key) { ?>
                        <option value="<?php echo $key['ID_AGENCE'] ?>"><?php echo  $key['DESCRIPTION'] ?></option>
                      <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                        <label style='color:blue'>Date</label>
                        <input onchange='get_rapport()' type="date" name="DATE_PRESENCE" autocomplete="off" id="DATE_PRESENCE" value="<?= set_value('DATE_PRESENCE') ?>" class="form-control">

                    </div>
            <div class="form-group col-md-3">
                  <label  style='color:blue'>Avant  ou  après midi</label>
                  <select class="form-control input-sm" name="avant" id="avant" onchange='get_rapport()'>
                      <option value="">Avant  ou  après midi</option>
                      <option value="AM">Avant  midi </option>
                      <option value="PM">Après midi</option>
                      
                    </select>

            </div>
   
            
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->


        
        <div class="card-body">
        
            <div class="row">
              <div id="container"  class="col-md-12" ></div>
              <div class="col-md-12" style="margin-bottom: 20px"></div>
              <div id="container1"  class="col-md-6" ></div>
              <div id="container2"  class="col-md-6" ></div>
              <div class="col-md-12" style="margin-bottom: 20px"></div>
              <div id="container3"  class="col-md-12" >
              <div class="card">
              <div class="col-sm-4 text-right">


            <span style="margin-right: 15px" class="col-md-12 row">
                <div class="col-md-6">
                            <label for="mois"></label>
                            <select class="form-control input-sm" id="mois" name="mois" onchange='liste()'>
                              <option value="">Choisissez un mois</option>
                              <option value="01">Janvier</option>
                              <option value="02">Février</option>
                              <option value="03">Mars</option>
                              <option value="04">Avril</option>
                              <option value="05">Mai</option>
                              <option value="06">Juin</option>
                              <option value="07">Juillet</option>
                              <option value="08">Août</option>
                              <option value="09">Septembre</option>
                              <option value="10">Octobre</option>
                              <option value="11">Novembre</option>
                              <option value="12">Décembre</option>
                            </select>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
            </span>

            </div><!-- /.col -->
              <div class="card-body">
                <div class="col-md-12">
                  <?= $this->session->flashdata('message'); ?>
                  <div class="table-responsive">
                   
                  <table id='reponse1' class="table table-bordered table-striped table-hover table-condensed " style="width: 100%;">
                    <thead>
                      <tr>
                      <th data-orderable="false">NO</th>
                        <th>Employes</th>
                        <th>Présences</th>
                        <th>Retards</th>
                        <th>Retards justifiés</th>
                        <th>Congés</th>
                        <th>Absences</th>
                        <th>Malades</th>
                        <th>sur Terrains</th>
                        <th>en Missions</th>
                        <th>en Formations</th>
                        <th data-orderable="false">TOTAL</th>
                      </tr>
                    </thead>
                  </table>

                  </div>

                </div>


                <!--  VOS CODE ICI  -->



              </div>
            </div>
                  </div>


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
                   <th>EMPLOYES</th>
                  <th>CONTACT</th>
                  <th>AGENCE</th>
                  <th>DATE PRESENCE</th>
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
 
<div class="modal fade" id="myModala" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content  modal-lg">
      <div class="modal-header">
        <h4 class="modal-title"><span id="titrea"></span></h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id='mytablea' class='table table-bordered table-striped table-hover table-condensed' >
          <thead>
                   <th>#</th>
                   <th>EMPLOYES</th>
                  <th>CONTACT</th>
                  <th>AGENCE</th>
                  <th>DATE ABSANT</th>
                  <th>PERIODE</th>
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

<div class="modal fade" id="myModalb" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content  modal-lg">
      <div class="modal-header">
        <h4 class="modal-title"><span id="titreb"></span></h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id='mytableb' class='table table-bordered table-striped table-hover table-condensed' >
          <thead>
                   <th>#</th>
                   <th>EMPLOYES</th>
                  <th>CONTACT</th>
                  <th>AGENCE</th>
                  <th>DATE ABSANT</th>
                  <th>PERIODE</th>
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

</div>





<?php include VIEWPATH.'templates/footer.php'; ?>
</body>
</html>


<script type="text/javascript">
$( document ).ready(function() {
get_rapport();
liste();
});   
function liste()
  {
  $('#message').delay('slow').fadeOut(3000);
  $("#reponse1").DataTable({
  "destroy" : true,
  "processing":true,
  "serverSide":true,
  /* "oreder":[], */
  "order":[[1,'ASC']],
  "ajax":{
  url: "<?php echo base_url('dashboard/Dashboard_annuel/listing/'); ?>",
  type:"POST",
  data : {
    
    mois: $('#mois').val(),
  },
  beforeSend : function() {
  }
  },
  lengthMenu: [[10,50, 100, -1], [10,50, 100, "All"]],
  pageLength: 10,
  "columnDefs":[{
  "targets":[],
  "orderable":false
  }],
  dom: 'Bfrtlip',
  buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
  language: {
  "sProcessing": "Traitement en cours...",
  "sSearch": "Rechercher&nbsp;:",
  "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
  "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
  "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
  "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
  "sInfoPostFix": "",
  "sLoadingRecords": "Chargement en cours...",
  "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
  "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
  "oPaginate": {
  "sFirst": "Premier",
  "sPrevious": "Pr&eacute;c&eacute;dent",
  "sNext": "Suivant",
  "sLast": "Dernier"
  },
  "oAria": {
  "sSortAscending": ": activer pour trier la colonne par ordre croissant",
  "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
  }
  }
  });
  }
function get_i() {

$('#jour').html('');
$('#heure').html('');
get_rapport();
  
}

function get_m() {

$('#heure').html('');
get_rapport();

}

function get_rapport(){
var agence=$('#ID_AGENCE').val()
var avant=$('#avant').val();
var DATE_PRESENCE=$('#DATE_PRESENCE').val();
$.ajax({
url : "<?=base_url()?>dashboard/Dashboard_annuel/get_rapport_user",
type : "POST",
dataType: "JSON",
cache:false,
data:{
agence:agence,
avant:avant,
DATE_PRESENCE:DATE_PRESENCE
},
success:function(data){   
  $('#container').html("");             
$('#nouveau').html(data.rapp );
$('#container1').html("");             
$('#nouveau1').html(data.rapp_absent);
$('#container2').html("");             
$('#nouveau2').html(data.rapp_conge);
},            

});  
}


function afficherPresences(user=null,id=null,nom=null,prenom=null) {
  // Affiche la fenêtre modale avec Swal et injecte le tableau HTML
  var titre = "";

if (id == 1) {
    titre = "presences";
} else if (id == 2) {  // Correction ici (changement de 'elseif' à 'else if' et 'id==1' à 'id==2')
    titre = "retards justifiés";
} else {
    titre = "retards";
}

  Swal.fire({
    
    title: 'Les '+titre +' de '+prenom+' '+' '+nom,
    html: `<div id="sms"></div>
    <div class="table-responsive">
          <table id='presences' class='table table-bordered table-striped table-hover table-condensed' >
            <thead>
             <th>#</th>
            <th>DATE </th>
            <th>STATUT/JUSTIFICATION</th>
            </thead>
          </table>
        </div>`,
    width: '80%',
    showCloseButton: true,
    showCancelButton: false,
    focusConfirm: false
  });

  // Délai pour cacher un éventuel message après affichage
  $('#sms').delay('slow').fadeOut(3000);

  // Initialisation du DataTable après l'affichage du tableau dans Swal
  $("#presences").DataTable({
    "destroy": true,
    "processing": true,
    "serverSide": true,
    "order": [[1, 'DESC']],
    
    "ajax": {
      url: "<?php echo base_url('dashboard/Dashboard_annuel/detail_pres/'); ?>",
      type: "POST",
      data: {
        user: user,
        keys: id,
        mois: $('#mois').val(),

      },
      beforeSend: function() {
        // Vous pouvez gérer un message de chargement ici si nécessaire
      }
    },
    lengthMenu: [[10, 50, 100, -1], [10, 50, 100, "All"]],
    pageLength: 10,
    "columnDefs": [{
      "targets": [],
      "orderable": false
    }],
    dom: 'Bfrtlip',
    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    language: {
      "sProcessing": "Traitement en cours...",
      "sSearch": "Rechercher&nbsp;:",
      "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
      "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
      "oPaginate": {
        "sFirst": "Premier",
        "sPrevious": "Pr&eacute;c&eacute;dent",
        "sNext": "Suivant",
        "sLast": "Dernier"
      },
      "oAria": {
        "sSortAscending": ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
      }
    }
  });
}



function afficherAbsences(user=null,id=null,nom=null,prenom=null) {
  // Affiche la fenêtre modale avec Swal et injecte le tableau HTML
 

  Swal.fire({
    
    title: 'Les absences de '+prenom+' '+' '+nom,
    html: `<div id="sms"></div>
    <div class="table-responsive">
          <table id='absences' class='table table-bordered table-striped table-hover table-condensed' >
            <thead>
             <th>#</th>
            <th>DATE </th>
            <th>PERIODE</th>
            </thead>
          </table>
        </div>`,
    width: '80%',
    showCloseButton: true,
    showCancelButton: false,
    focusConfirm: false
  });

  // Délai pour cacher un éventuel message après affichage
  $('#sms').delay('slow').fadeOut(3000);

  // Initialisation du DataTable après l'affichage du tableau dans Swal
  $("#absences").DataTable({
    "destroy": true,
    "processing": true,
    "serverSide": true,
    "order": [[1, 'DESC']],
    
    "ajax": {
      url: "<?php echo base_url('dashboard/Dashboard_annuel/detail_abs/'); ?>",
      type: "POST",
      data: {
        user: user,
        keys: id,
       mois: $('#mois').val(),

      },
      beforeSend: function() {
        // Vous pouvez gérer un message de chargement ici si nécessaire
      }
    },
    lengthMenu: [[10, 50, 100, -1], [10, 50, 100, "All"]],
    pageLength: 10,
    "columnDefs": [{
      "targets": [],
      "orderable": false
    }],
    dom: 'Bfrtlip',
    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    language: {
      "sProcessing": "Traitement en cours...",
      "sSearch": "Rechercher&nbsp;:",
      "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
      "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
      "oPaginate": {
        "sFirst": "Premier",
        "sPrevious": "Pr&eacute;c&eacute;dent",
        "sNext": "Suivant",
        "sLast": "Dernier"
      },
      "oAria": {
        "sSortAscending": ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
      }
    }
  });
}



function afficherConges(user=null,id=null,nom=null,prenom=null) {
  // Affiche la fenêtre modale avec Swal et injecte le tableau HTML
  var titre = "";

if (id == 1) {
    titre = "congés";
} else if (id == 2) {  // Correction ici (changement de 'elseif' à 'else if' et 'id==1' à 'id==2')
    titre = "malades";
}  else if (id == 3) {  // Correction ici (changement de 'elseif' à 'else if' et 'id==1' à 'id==2')
    titre = "jours se trouvant sur  terrains";
} else if (id == 4) {  // Correction ici (changement de 'elseif' à 'else if' et 'id==1' à 'id==2')
    titre = "jours se trouvant en missions  ";
}else {
    titre = "jours se trouvant en formations  ";
}

  Swal.fire({
    title: 'Les '+titre +' de '+prenom+' '+' '+nom,
    html: `<div id="sms"></div>
    <div class="table-responsive">
          <table id='absences' class='table table-bordered table-striped table-hover table-condensed' >
            <thead>
             <th>#</th>
            <th>DATE </th>
            <th>PERIODE</th>
            </thead>
          </table>
        </div>`,
    width: '80%',
    showCloseButton: true,
    showCancelButton: false,
    focusConfirm: false
  });

  // Délai pour cacher un éventuel message après affichage
  $('#sms').delay('slow').fadeOut(3000);

  // Initialisation du DataTable après l'affichage du tableau dans Swal
  $("#absences").DataTable({
    "destroy": true,
    "processing": true,
    "serverSide": true,
    "order": [[1, 'DESC']],
    
    "ajax": {
      url: "<?php echo base_url('dashboard/Dashboard_annuel/detail_cong/'); ?>",
      type: "POST",
      data: {
        user: user,
        keys: id,
      mois: $('#mois').val(),

      },
      beforeSend: function() {
        // Vous pouvez gérer un message de chargement ici si nécessaire
      }
    },
    lengthMenu: [[10, 50, 100, -1], [10, 50, 100, "All"]],
    pageLength: 10,
    "columnDefs": [{
      "targets": [],
      "orderable": false
    }],
    dom: 'Bfrtlip',
    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    language: {
      "sProcessing": "Traitement en cours...",
      "sSearch": "Rechercher&nbsp;:",
      "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
      "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
      "oPaginate": {
        "sFirst": "Premier",
        "sPrevious": "Pr&eacute;c&eacute;dent",
        "sNext": "Suivant",
        "sLast": "Dernier"
      },
      "oAria": {
        "sSortAscending": ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
      }
    }
  });
}
</script> 


