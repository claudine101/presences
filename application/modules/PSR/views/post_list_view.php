<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>


<style type="text/css">
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
  color: #434393;

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
            <div class="col-sm-8">
              <h4 class="m-0"><?= $title ?></h4>
            </div><!-- /.col -->


            <div class="col-sm-4 text-right">


              <span style="margin-right: 15px">
                <div class="col-sm-3" style="float:right;">
                  <a href="<?= base_url('PSR/Poste_Pnb/ajouter') ?>" style="width: 100px;" class='btn btn-primary btn-sm float-right'>
                    <i class="nav-icon fas fa-plus"></i>
                    Nouveau
                  </a>
                </div>

              </span>

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
                  <?= $this->session->flashdata('message'); ?>

                  <div class="table-responsive">
                    <table id='reponse1' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                      <thead>
                        <tr>

                          <th>Province</th>
                          <th>Commune</th>
                          <th>Zone</th>
                          <th>Colline</th>
                          <th>Agents</th>
                          <th>Lieu exacte</th>
                          <th data-orderable="false">Options</th>

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


  <!-- /.content -->
  </div>

  </div>
  <!-- ./wrapper -->
  <?php include VIEWPATH . 'templates/footer.php'; ?>
</body>
 <!-- MODAL POUR LE DETAIL -->
<div class="modal fade" id="LieuxAffect" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="false">
<!-- <div class="modal fade" id=""> -->
 <div class="modal-dialog modal-lg" >
    <div class="modal-content modal-lg">
     <div class="modal-header" style="background: black;">
      <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;">Nouvelle affectation</h4></b></div>

      <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close" onclick="annuless()">
       <span aria-hidden="true">&times;</span>
     </div>
   </div>
   <div class="modal-body" id="donneDeatail">

  <form id="myformune" >
      

    
      <div id="Adresse_iput" class="row">

      <div class="col-md-6">
        <label for="Adresse">Pays</label>
        <input type="text" class="form-control" id="pays_text" placeholder="" readonly>
        <input type="hidden" class="form-control" id="pays_id" name="pays_id" placeholder="" readonly>
      </div>

      


      <div class="col-md-6">
        <label for="Adresse">Province</label>
        <input type="text" class="form-control" id="province_id" placeholder="" readonly>
      </div>



      <div class="col-md-4">
        <label for="Adresse">Point</label>
        <input type="text" class="form-control" id="latlong_donne" placeholder="" readonly>
      </div>

       <div class="col-md-8">
        <label for="Lieux">Adresse</label>
         <textarea class="form-control" id="Lieux" rows="1" placeholder="..."></textarea>
      </div>
      </div>

      <div class="row">

      <input type="hidden" id="lieux_id_aff" name="lieux_id_aff">

      <div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px;border: 1px solid #fff;padding: 10px;border-bottom-left-radius: 8px;border-bottom-right-radius: 8px; border-top-left-radius: 8px;border-top-right-radius: 8px; ">
        <label for="Lieux">Agent de Police</label>
          <select id="Agents" name="Agents[]" class="form-control select2 selectpicker"  multiple="multiple"  data-live-search="true" required>
            <?php foreach ($donne_pnb as $key => $donne) { ?>
              <?php $sexe =  ($donne['SEXE']=="H") ? "🧑🏼‍✈️":"👮🏻"; ?>
            <option value="<?=$donne['ID_PSR_ELEMENT']?>"><img width="10" height="10" src="<?=$donne['PHOTO']?>" ><?=$sexe ?><?=$donne['NOM']?> <?=$donne['PRENOM']?>/Tél <?=$donne['TELEPHONE']?> </option>
            <?php } ?>
          </select>
      </div>

      <hr>
      
    </div>


    <div class="row" style="margin-top: 10px;margin-bottom: 10px;">





      <div class="col-md-6">
        <label for="Lieux">Catégorie</label>
          <select id="control_catego" name="control_catego[]" class="form-control select2 selectpicker"  multiple="multiple"  data-live-search="true" required onchange="getTypeControl()">
            <?php foreach ($catego_histo as $key => $donne) { ?>
            <option value="<?=$donne['ID_CATEGORIE']?>"><?=$donne['DESCRIPTION']?> </option>
            <?php } ?>
          </select>
      
       </div>


        <div class="col-md-6">
        <label for="Lieux">Type de contrôle</label>
          <select id="id_control" name="id_control[]" class="form-control select2 selectpicker" onchange="get_question(this.value)" multiple="multiple"  data-live-search="true" required>
            <?php foreach ($catego_control as $key => $donne) { ?>
            <option value="<?=$donne['ID_TYPE']?>"><?=str_replace("_", " ", $donne['DESCRIPTION'])?> </option>
            <?php } ?>
          </select>
      
       </div>


      <div class="col-md-12">
        <label for="id_question_repo" >Action</label>
         <select id="id_question_repo" name="id_question_repo"  class="form-control select33 selectpicker" multiple="multiple" data-actions-box="true"  data-live-search="true" required>
             
         </select>
      </div>

      <!-- <div class="col-md-4">
        <label for="DateAff">Date</label>
        <input type="date" class="form-control" id="DateAff" value="<?=date('d-m-Y')?>">
      </div>
 -->
      <div class="col-md-3">
        <label for="TempsA">De</label>
        <input type="datetime-local" class="form-control" id="TempsA" >
      </div>

       <div class="col-md-3">
        <label for="TempsB">A</label>
        <input type="datetime-local" class="form-control" id="TempsB" >
      </div>
      
    </div>
   
    <div class="form-group">
      <label for="exampleFormControlTextarea1">Commentaire</label>
      <textarea class="form-control" id="Commentaires" rows="3" placeholder="..."></textarea>
    </div>

    <input type="hidden" id="type_aff_id" name="type_aff_id">
  </form>
  

  </div>
  <div class="modal-footer" >
     
      <button id="btn_quiterx" type="button" class="btn btn-primary" onclick="save_affectation_initial()" >Envoyer</button>
      <button id="btn_quiter" type="button" class="btn btn-danger" data-dismiss="modal" onclick="validation_form()">Annuler</button>
  </div>
</div>
</div>
</div>
</html>
<script type="text/javascript">
  $(document).ready(function() {
    liste();

  });
</script>





< <script type="text/javascript">
  function liste()
  {
  $('#message').delay('slow').fadeOut(3000);
  $("#reponse1").DataTable({
  "destroy" : true,
  "processing":true,
  "serverSide":true,
  "oreder":[],
  "ajax":{
  url: "<?php echo base_url('PSR/Poste_Pnb/listing/'); ?>",
  type:"POST",
  data : { },
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
   $('.select2').select2();
  function affectation_new(id = 0){
    $('#LieuxAffect').modal()
    $('#Adresse_iput').hide()
    $('#type_aff_id').val(2)
    $('#lieux_id_aff').val(id)
    
    // alert(id)
    $.ajax({
          url : "<?=base_url()?>geo/Elements_Pnb/affectation_new/"+id,
          type : "GET",
          dataType: "JSON",
          cache:false,
          beforeSend:function () { 
            //alert_encours()
          },
          success:function(data) {
            // $('#Agents').html("");
            $('#Agents').html(data.elemnt.html)
       
            $('#TempsA').val(data.elemnt.date_a)
            $('#TempsB').val(data.elemnt.date_b)
            $('#Commentaires').val(data.elemnt.commentaires)
            console.log(data.elemnt.date_b)
            console.log(data.elemnt.date_a)
            $('#control_catego').html(data.catego.categos)
            $('#id_control').html(data.catego.ty_ctrl)
            $('#id_question_repo').html(data.catego.quest_ctrl)
            console.log(data)
          },
          error:function() {
            alert_erro("Message non envoyer problème soit de connexion")
          }
      });
   }
   function save_affectation_initial(){

    if ($('#type_aff_id').val() == 1) {
       sendAffectation_une()
    }else if ($('#type_aff_id').val() == 2) {
       sendAffectation_deux()
    }
    
  
}

 function sendAffectation_une(){

              var AgentsOption = document.getElementById('Agents').selectedOptions;
              var Agents = Array.from(AgentsOption).map(({ value }) => value);

              var categOption = document.getElementById('control_catego').selectedOptions;
              var control_catego = Array.from(categOption).map(({ value }) => value);

              var controlOption = document.getElementById('id_control').selectedOptions;
              var id_control = Array.from(controlOption).map(({ value }) => value);

              var questOption = document.getElementById('id_question_repo').selectedOptions;
              var id_question_repo = Array.from(questOption).map(({ value }) => value);
              
              var pays_id =$('#pays_id').val();
              var province_id =$('#province_id').val();
              var latlong_donne =$('#latlong_donne').val();
              var Lieux =$('#Lieux').val();
              var DateAff = ""

              var TempsA =$('#TempsA').val();
              var TempsB =$('#TempsB').val();
              var Commentaires =$('#Commentaires').val();

              // alert(province_id)

              $.ajax({
                    url : "<?=base_url()?>geo/Elements_Pnb/sendAffectation/",
                    type : "POST",
                    dataType: "JSON",
                    cache:false,
                    data: {
                           Agents: Agents,
                           control_catego: control_catego,
                           id_control: id_control,
                           id_question_repo: id_question_repo,

                           pays_id : pays_id,
                           province_id : province_id,
                           latlong_donne : latlong_donne,
                           Lieux : Lieux,

                           DateAff : DateAff,
                           TempsA : TempsA,
                           TempsB : TempsB,
                           Commentaires : Commentaires
                    },
                    beforeSend:function () { 
                     
                      alert_encours()
                    },
                    success:function(data) {

                      // document.getElementById("myformune").reset(); 
                      sucess_alert()  
                      $('#LieuxAffect').modal('hide')
                       liste();
                       getMaps();


                    },
                    error:function() {
                      alert_erro("Message non envoyer problème soit de connexion")
                    }
                });


        

  }
 function sucess_alert(){

    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Your work has been saved',
        showConfirmButton: false,
        timer: 1500
      })
  }
   function alert_erro(message){

         Swal.fire({
                   icon: 'error',
                   title: message,
                   text: 'Veillez réessayer plus tard merci!',
                   //footer: '<a href="<?=base_url()?>?</a>'
                 })
 }


  function alert_encours(message = ""){

         Swal.fire({
                 title: 'Connexion encours !',
                 html: 'Veillez patienter <b></b>  sécondes prés ...',
                 timer: 6000,
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
  function speeck_text(arry = null){
      

      var msg = new SpeechSynthesisUtterance();
      
      var voices = window.speechSynthesis.getVoices();
      // msg.voice = speechSynthesis.getVoices().filter(function(voice) { return voice.name == 'Whisper'; })[0];
      msg.voice = voices[10]; // Note: some voices don't support altering params
      msg.voiceURI = 'native';
      msg.volume = 1; // 0 to 1
      msg.rate = 0.8; // 0.1 to 10
      msg.pitch = 1.9; //0 to 2
      msg.text = arry['message'];
      msg.lang = arry['langue'];

      msg.onend = function(e) {
          //console.log('Finished in ' + event.elapsedTime + ' seconds.');
      };
      speechSynthesis.speak(msg);

    }
  function parler_label(){ 

        //if($('#axeaffect').is(':checked')){

           var mess = [];
           mess['message'] = $('#Commentaires').val();
           mess['langue'] = 'fr-FR';
           speeck_text(mess)
          console.log(mess)
     // }

    }
function sendAffectation_deux(){
  

        parler_label()
        console.log($('#type_aff_id').val()+' '+$('#lieux_id_aff').val())

        var AgentsOption = document.getElementById('Agents').selectedOptions;
        var Agents = Array.from(AgentsOption).map(({ value }) => value);

        var categOption = document.getElementById('control_catego').selectedOptions;
        var control_catego = Array.from(categOption).map(({ value }) => value);

        var controlOption = document.getElementById('id_control').selectedOptions;
        var id_control = Array.from(controlOption).map(({ value }) => value);

        var questOption = document.getElementById('id_question_repo').selectedOptions;
        var id_question_repo = Array.from(questOption).map(({ value }) => value);
        
        var lieux_id_aff =$('#lieux_id_aff').val();

        var type_aff_id =$('#type_aff_id').val();
        
        var TempsA =$('#TempsA').val();
        var TempsB =$('#TempsB').val();
        var Commentaires =$('#Commentaires').val();


        $.ajax({
              url : "<?=base_url()?>geo/Elements_Pnb/sendAffectation_deux/",
              type : "POST",
              dataType: "JSON",
              cache:false,
              data: {
                     Agents: Agents,
                     control_catego: control_catego,
                     id_control: id_control,
                     id_question_repo: id_question_repo,

                     lieux_id_aff : lieux_id_aff,
                     type_aff_id : type_aff_id,

                     DateAff : "2020",
                     TempsA : TempsA,
                     TempsB : TempsB,
                     Commentaires : Commentaires
              },
              beforeSend:function () { 
               
                alert_encours()
              },
              success:function(data) {

                // document.getElementById("myformune").reset(); 
                sucess_alert()  
                $('#LieuxAffect').modal('hide')
                liste();
                 getMaps();

              },
              error:function() {
                alert_erro("Message non envoyer problème soit de connexion")
              }
          });


 }
  </script>
  <script type="text/javascript">
  $(document).ready(function() {
    $('#Agents_deux').select2();

    $("#chkall_agent").click(function(){
        if($("#chkall_agent").is(':checked')){
            $("#Agents_deux > option").prop("selected", "selected");
            $("#Agents_deux").trigger("change");
        } else {
            // $("#Agents_deux").html("");
            $("#Agents_deux > option").removeAttr("selected", "selected");
            $("#Agents_deux").trigger("change");
        }
    });
});
</script>
<script>
    

var $eventLog = $(".js-event-log");
var $eventSelect = $(".select33");


$eventSelect.select2();

$eventSelect.chosen({disable_search_threshold: 10});

$(".select2").chosen({disable_search_threshold: 10});

$eventSelect.on("select2:open", function (e) { log("select2:open", e); });
$eventSelect.on("select2:close", function (e) { log("select2:close", e); });
$eventSelect.on("select2:select", function (e) { log("select2:select", e); });
$eventSelect.on("select2:unselect", function (e) { log("select2:unselect", e); });

$eventSelect.on("change", function (e) { log("change"); });

function log (name, evt) {
  if (!evt) {
    var args = "{}";
  } else {
    var args = JSON.stringify(evt.params, function (key, value) {
      if (value && value.nodeName) return "[DOM node]";
      if (value instanceof $.Event) return "[$.Event]";
      return value;
    });
  }
  var $e = $("<li>" + name + " -> " + args + "</li>");
  $eventLog.append($e);
  $e.animate({ opacity: 1 }, 10000, 'linear', function () {
    $e.animate({ opacity: 0 }, 2000, 'linear', function () {
      $e.remove();
    });
  });
}
  function getTypeControl(id_control = null){
    

    var options_id_control = document.getElementById('control_catego').selectedOptions;
    var values_id_control = Array.from(options_id_control).map(({ value }) => value);
    console.log(values_id_control);


    $.ajax({
          url : "<?=base_url()?>geo/Elements_Pnb/getTypeControl/",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {
                 values_id_control:values_id_control
          },
          success:function(data) {
            
              $('#id_control').html(data.htmls)
                
          }
          
      });

  }



 
  
  function get_question(id_control = null){
    

    var options_id_control = document.getElementById('id_control').selectedOptions;
    var values_id_control = Array.from(options_id_control).map(({ value }) => value);
    console.log(values_id_control);


    $.ajax({
          url : "<?=base_url()?>geo/Elements_Pnb/get_question/",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {
                 values_id_control:values_id_control
          },
          success:function(data) {
              $('#id_question_repo').html(data.htmls)
                
          }
          
      });

  }
</script>