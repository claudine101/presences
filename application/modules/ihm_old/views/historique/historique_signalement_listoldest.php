<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php'; ?>

<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

<style type="text/css">
.mapbox-improve-map{
  display: none;
}

.leaflet-control-attribution{
  display: none !important;
}
.leaflet-control-attribution{
  display: none !important;
}


.mapbox-logo {
  display: none;
  }a
</style>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include VIEWPATH.'templates/navbar.php'; ?>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include VIEWPATH.'templates/sidebar.php'; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-8">
              <h4 class="m-0"><?=$title?></h4>
            </div><!-- /.col -->


            <div class="col-sm-4 text-right">




            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->


        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">

          <div class="col-md-12 col-xl-12 grid-margin stretch-card">

            <div class="card">





              <div class="card-body">

                <div class="col-md-12">
                  <?=  $this->session->flashdata('message');?>
                  <div class="table-responsive">
                    <table id='reponse1' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                      <thead>
                        <tr>

                          <td>Utilisateur</td>
                          <td>Plaque</td>
                          <td>Infranction</td>
                          <td>Amendes</td>
                          <td>Description</td>
                          <td>Status</td>
                          <td>Date</td>
                          <td>OPTIONS</td>

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

        <!-- Rapport partie -->



        <!-- End Rapport partie -->

      </div>
    </div>
  </div>          
</div>


</section>



<!-- Paiement modal -->

 <div class='modal fade' id='PaiementModal'>
    <div class='modal-dialog'>
    <div class='modal-content'>

    <div class='modal-body'>
    <center><h5><strong>Voulez-vous payer ?</strong></h5></center><br>
    <form name='myform' method='post' class='form-horizontal' >
   
    <div class='form-group'>
    <div class="col-md-10">
      <label>Amende <span id="labelAmande"></span> FBU</label>
      <input id='AMENDE' type='number' class='form-control' name='AMENDE' readonly>
    </div>
  </div>
    
    <div class='form-group'>
    <div class="col-md-10">
       <label>Téléphone Econet</label>
      <input id='Telephone' type='number' max="8" min="8" class='form-control' name='Telephone' placeholder='Payer avec Ecocash'>
    </div>
    </div>

    <input type="hidden" name="ID_HISTO_SIGNALEMMENT" id="ID_HISTO_SIGNALEMMENT">

    </form>

    </div>

    <div class='modal-footer'>
    <a class='btn btn-warning btn-md' onclick='ecocash()'>Confirmer</a>
    <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
    </div>

    </div>
    </div>
    </div>

<!-- /.content -->
</div>

</div>
<!-- ./wrapper -->
<?php include VIEWPATH.'templates/footer.php'; ?>
</body>
</html>
<script type="text/javascript">
 $(document).ready(function(){
  liste();

});
</script>



<script type="text/javascript">
  function liste() 
  {  
    $('#message').delay('slow').fadeOut(3000);
    $("#reponse1").DataTable({
      "destroy" : true,
      "processing":true,
      "serverSide":true,
      "oreder":[],
      "ajax":{
        url: "<?php echo base_url('ihm/Historique_signalement/listing/');?>", 
        type:"POST",
        data : {   },
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
      buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print'  ],
      language: {
        "sProcessing":     "Traitement en cours...",
        "sSearch":         "Rechercher&nbsp;:",
        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
        "oPaginate": {
          "sFirst":      "Premier",
          "sPrevious":   "Pr&eacute;c&eacute;dent",
          "sNext":       "Suivant",
          "sLast":       "Dernier"
        },
        "oAria": {
          "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
          "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        }
      }
    });


  }
</script> 




<script>

  function getPayement(id,amende){

   $('#AMENDE').val(amende)
   $('#ID_HISTO_SIGNALEMMENT').val(id)
   $('#labelAmande').html(amende.toLocaleString('fr'))

}


function ecocash(){

  var Telephone = $('#Telephone').val()
  if (Telephone =="") {
    $('#Telephone').css('border-color','red')
    $('#Telephone').focus()
  }else{

    $('#Telephone').css('border-color','green')
    var AMENDE = $('#AMENDE').val()
    var Telephone = $('#Telephone').val()
    var ID_HISTO_SIGNALEMMENT = $('#ID_HISTO_SIGNALEMMENT').val()

    var form= new FormData();

    form.append("AMENDE", AMENDE)
    form.append("Telephone", Telephone)
    form.append("ID_HISTO_SIGNALEMMENT", ID_HISTO_SIGNALEMMENT)
    
    $.ajax({
      url: "<?=base_url()?>ihm/Historique_signalement/httpPost",
      type : "POST",
      data: form,
      dataType: "JSON",
      processData: false,  
      contentType: false,
      beforeSend:function () { 
       encours();
       },
      success:function(data){
        if (data.statut == "200") {
           success(data.message)
        }else{
            erreur(data.message)
        }

        $('#PaiementModal').modal('hide')

      }


  })




   }


}






function encours(){
  
              Swal.fire({
                 title: 'Traitement encours !',
                 html: 'Veillez patienter <b></b>  sécondes prés ...',
                 timer: 15000,
                 timerProgressBar: true,
                 didOpen: () => {
                   Swal.showLoading()
                   const b = Swal.getHtmlContainer().querySelector('b')
                   timerInterval = setInterval(() => {
                     b.textContent = Swal.getTimerLeft()
                   }, 100)
                 },
                 willClose: () => {
                   clearInterval(timerInterval)
                 }
               }).then((result) => {
               /* Read more about handling dismissals below */
                 if (result.dismiss === Swal.DismissReason.timer) {
                  console.log('I was closed by the timer')
                 }
               })

} 


function success(message=""){
         
         Swal.fire("Paiement initié avec succès !", message , "success");

} 

function erreur(message =""){

          Swal.fire({
                icon: 'error',
                title: 'Erreur...',
                text: message,
                   //footer: '<a href="<?=base_url()?>?</a>'
              })
}
</script>
