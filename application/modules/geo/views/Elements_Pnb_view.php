<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php'; ?>


<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
<script src='https://unpkg.com/@turf/turf/turf.js'></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style>
/* Adjustments to account for mapbox.css box-sizing rules */
.leaflet-control-zoomslider-knob { width:7px; height:2px; }
.leaflet-container .leaflet-control-zoomslider-body {
  -webkit-box-sizing:content-box;
     -moz-box-sizing:content-box;
          box-sizing:content-box;
  }
</style>
<style type="text/css">
  .card{
  border-width: 0px;
  font-size: 14px;
  margin: 0px;
  padding: 0px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
  color: #434393;

}

.card-header{
  margin-top: -11px;
  margin-left: -11px;
  margin-right: -11px;
  text-align: center;
  background-color: black;
  color: white;
}
.card-footer{
  margin-bottom: -12px;
  margin-left: -11px;
  margin-right: -11px;
  padding-right: -8px
  padding-left: -8px
}

.card-body{
  margin-left: -13px;
  margin-right: -13px;
  margin-bottom: -13px;
}
.ui-coordinates {
  background:rgba(0,0,0,0.5);
  position:absolute;
  top:280px;right:15px;
  z-index:1;
  bottom:10px;
  right:20px;
  padding:5px 10px;
  color:#fff;
  font-size:12px;
  border-radius:3px;
  max-height:220px;
 
  width:250px;
  }
</style>
<style>
.legend label,
.legend span {
  display:block;
  float:left;
  height:15px;
  width:20%;
  text-align:center;
  font-size:9px;
  color:#808080;
  }
</style>

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
}

 .animated-icon{
  width: 25px;
  height: 25px;
  background-color: rgba(255,255,255,0.5);
  border-radius: 50%;
  box-shadow: 0px 0px 20px red;
  transition: all 1s;
}
</style>
<style>
  
  .css-icon {

  }

  .gps_ring { 
    border: 7px solid #F30707;
     -webkit-border-radius: 30px;
     height: 48px;
     width: 48px;   
     margin-left: -10px;
     margin-top: -15px;
      -webkit-animation: pulsate 1s ease-out;
      -webkit-animation-iteration-count: infinite; 
      /*opacity: 0.0*/
  }
  
  @-webkit-keyframes pulsate {
        0% {-webkit-transform: scale(0.1, 0.1); opacity: 0.0;}
        50% {opacity: 1.0;}
        100% {-webkit-transform: scale(1.2, 1.2); opacity: 0.0;}
  }
  </style>

 
<style>
/* Adjustments to account for mapbox.css box-sizing rules */
.leaflet-control-zoomslider-knob { width:7px; height:2px; }
.leaflet-container .leaflet-control-zoomslider-body {
  -webkit-box-sizing:content-box;
     -moz-box-sizing:content-box;
          box-sizing:content-box;
  }
</style>


<style type="text/css">
  .card{
  border-width: 0px;
  font-size: 14px;
  margin: 0px;
  padding: 0px;
}



.card-header{
  margin-top: -11px;
  margin-left: -11px;
  margin-right: -11px;
  text-align: center;
  background-color: black;
  color: white;
}
.card-footer{
  margin-bottom: -12px;
  margin-left: -11px;
  margin-right: -11px;
  padding-right: -8px
  padding-left: -8px
}

.card-body{
  margin-left: -13px;
  margin-right: -13px;
  margin-bottom: -13px;
}
.ui-coordinates {
  background:rgba(0,0,0,0.5);
  position:absolute;
  top:280px;right:15px;
  z-index:1;
  bottom:10px;
  right:20px;
  padding:5px 10px;
  color:#fff;
  font-size:12px;
  border-radius:3px;
  max-height:220px;
 
  width:250px;
  }
</style>
<style>
.legend label,
.legend span {
  display:block;
  float:left;
  height:15px;
  width:20%;
  text-align:center;
  font-size:9px;
  color:#808080;
  }
</style>

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
}

 .animated-icon{
  width: 25px;
  height: 25px;
  background-color: rgba(255,255,255,0.5);
  border-radius: 50%;
  box-shadow: 0px 0px 20px red;
  transition: all 1s;
}
</style>
<style>
  
  .css-icon {

  }

  .gps_ring { 
    border: 7px solid #F30707;
     -webkit-border-radius: 30px;
     height: 48px;
     width: 48px;   
     margin-left: -10px;
     margin-top: -15px;
      -webkit-animation: pulsate 1s ease-out;
      -webkit-animation-iteration-count: infinite; 
      /*opacity: 0.0*/
  }
  
  @-webkit-keyframes pulsate {
        0% {-webkit-transform: scale(0.1, 0.1); opacity: 0.0;}
        50% {opacity: 1.0;}
        100% {-webkit-transform: scale(1.2, 1.2); opacity: 0.0;}
  }
  </style>

 
<body class="hold-transition sidebar-mini layout-fixed">


 <audio style="display: none;" id="xhhh"  controls src="<?=base_url('uploads/sons.mpga')?>"  >
            <code>audio</code>
</audio>
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
             <h4 class="m-0"><b>Postes d'affectation des fonctionnaires de la RECECA-INKINGI</b></h4>
           </div><!-- /.col -->

           
           <div class="col-sm-4 text-right">


            <span style="margin-right: 15px">
              <div class="row">
              <div class="col-sm-6" style="float:right;">
              </div>

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
      

                <?= $this->session->flashdata('message');?>


             

             
           



           <div class="row">

            
                
             

            <div class="col-md-8"  id="mapview" style="height: 630px;">
                            

              <!-- <div style="width: 100%;height: 650px;" id="mapview"></div> -->

            </div>


            <div class="col-md-4">


                <div class="col-md-12" style="margin-top: 0px;margin-bottom: 10px;border: 1px solid #fff;padding: 10px;border-bottom-left-radius: 8px;border-bottom-right-radius: 8px; border-top-left-radius: 8px;border-top-right-radius: 8px; ">
                      <label for="Lieux">Agent de Police</label>
                        <select id="Agents_deux" name="Agents_deux[]" class="form-control select2 selectpicker"  multiple="multiple"  data-live-search="true" onchange="getMaps()">
                          <?php foreach ($donne_pnb as $key => $donne) { ?>
                            <?php $sexe =  ($donne['SEXE']=="H") ? "🧑🏼‍✈️":"👮🏻"; ?>
                          <option value="<?=$donne['ID_PSR_ELEMENT']?>" ><img width="10" height="10" src="<?=$donne['PHOTO']?>" ><?=$sexe ?><?=$donne['NOM']?> <?=$donne['PRENOM']?>/Tél <?=$donne['TELEPHONE']?> </option>
                          <?php } ?>
                        </select>

                        <fieldset>
                            <legend></legend>

                            <div>
                              <input type="checkbox" id="chkall_agent" name="chkall_agent" checked>
                              <label for="chkall_agent">Tous les agents</label>
                            </div>

                            <div>
                              <input type="checkbox" id="axeaffect" name="axeaffect">
                              <label for="axeaffect">Créer un axe d'affectation </label>
                            </div>
                        </fieldset>
                    </div>






              <!-- -->

              <br>

              <br>

              <br>

                        
                <div id='legend' style='background: transparent;'>
                <strong>Légende</strong>

              <br>

              <br>
                <hr>
                <nav class='legend'>
                   
                   <table class="">

                   
                      <tr>
                       <td><img style="margin-top: 25px; height: 40px;" src="https://a.tiles.mapbox.com/v4/marker/pin-m-police+000.png?access_token=pk.eyJ1IjoibWFydGlubWVkaWFib3giLCJhIjoiY2s4OXc1NjAxMDRybzNobTE2dmo1a3ZndCJ9.W9Cm7Pjp25FQ00bII9Be6Q"></label></td>
                       <td>&emsp;<input type="checkbox" checked  name="opt3"><b style="color:#000;font-size: 15px"> Poste d'affectation RECECA-INKINGI (<a href="#" onclick="getincident(3)" id="lieux"><?=number_format($lieux,0,',',' ')?></a>) </b></td>
                       </tr>
                       <tr>
                       <td><label style='background:red;width: 16px;height: 15px;border-radius: 10px;'></label></td>
                       <td>&emsp;<input type="checkbox" checked  name="opt2"> Fonctionnaires de la RECECA-INKINGI non actif (<a href="#" onclick="getincident(1)" id="nonActif"><?=number_format($nonActif,0,',',' ')?></a>)</td>
                       </tr>
                       <tr>
                       <td><label style='background:#30d930;width: 16px;height: 15px;border-radius: 10px;'></label></td>
                       <td>&emsp;<input type="checkbox" checked  name="opt1"> Fonctionnaires de la RECECA-INKINGI Actif 
                         (<a href="#" onclick="getincident(2)" id="actif"><?=number_format($actif,0,',',' ')?></a>)</td>
                       </tr>
                             
                   </table>
                  
                   
                  <small>Source: <a href="#link to source">MediaBox</a></small>
                </nav>
              </div>  
              <br> 


              <br>
                  <button type="button" class="btn btn-primary form-control"><a href="<?php echo base_url();?>/PSR/Psr_elements/index" style="color:#fff"> Fonctionnaires de la RECECA-INKINGI >></a> </button>
               
              </div>


              </div>




<!-- 
          <div id="mapview">

         </div>
 -->
         

                
              </div>


              <!--  VOS CODE ICI  -->



            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>          
</div>


</section>


<!-- /.content -->
</div>

</div>
</div>






<!-- MODAL POUR LE DETAIL -->
<div class="modal fade" id="detailControl">
 <div class="modal-dialog modal-lg" >
   <div class="modal-content modal-lg">
     <div class="modal-header" style="background: black;">
      <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;">Détails</h4></b></div>

      <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </div>
   </div>
   <div class="modal-body" id="donnePerformance">
    
    </div>
  <div class="modal-footer"> 
   <!--  <button id="btn_quiter" type="button" class="btn btn-primary" class='close' data-dismiss='modal'>Quitter</button> -->
  </div>
</div>
</div>
</div>


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







<!-- MODAL POUR LE DETAIL -->
<div class="modal fade" id="MessagePolice">
 <div class="modal-dialog" >
    <div class="modal-content">
     <div class="modal-header" style="background: black;">
      <div id="title"><b><h4 id="donneTitre" style="color:#fff;font-size: 18px;">Nouveau message</h4></b></div>

      <div class="close" style="color:#fff" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </div>
   </div>
   <div class="modal-body" id="donneDeatail">

  <form>
    <input type="hidden" class="form-control" id="IdAgents">
    <div class="form-group">
      <label for="exampleFormControlInput1">Contact</label>
      <input type="number" class="form-control" id="phoneNumber" placeholder="71586523" readonly>
    </div>
   
    <div class="form-group">
      <label for="exampleFormControlTextarea1">Message</label>
      <textarea class="form-control" id="MessageText" rows="3" placeholder="Message..."></textarea>
    </div>
  </form>
  

  </div>
  <div class="modal-footer"> 
     <button id="btn_quiter" type="button" class="btn btn-primary" onclick="sendMessage()">Envoyer</button>
    <!-- <button id="btn_quiter" type="button" class="btn btn-primary" class='close' data-dismiss='modal'></button> -->
  </div>
</div>
</div>
</div>
















<!-- ./wrapper -->
<?php include VIEWPATH.'templates/footer.php'; ?>
</body>
</html>


<script type="text/javascript">


  
  function validation_form(){

      var allInputs = $('form[id=myformune]').find(':input') 
      var formChildren = $( "form > *" );

        var formDatas = { };

           for (var i = 0; i < allInputs.length; i++) {

            formDatas[allInputs[i].name] = allInputs[i].value

            // if ($('#'+allInputs[i].name+'').val() == "") {
            //    $('#'+allInputs[i].name+'').focus();
            // }

           }

            console.log(formDatas)

  }



</script>

<script>

function save_affectation_initial(){

    if ($('#type_aff_id').val() == 1) {
       sendAffectation_une()
    }else if ($('#type_aff_id').val() == 2) {
       sendAffectation_deux()
    }
    
  
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



</script>




<script type="text/javascript">
  
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

            
          },
          error:function() {
            alert_erro("Message non envoyer problème soit de connexion")
          }
      });
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
                 getMaps();

              },
              error:function() {
                alert_erro("Message non envoyer problème soit de connexion")
              }
          });


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

  function sendMessage(){
    
    if ($('#MessageText').val() == ''){

      $('#MessageText').focus()

    }else{

      $.ajax({
          url : "<?=base_url()?>geo/Elements_Pnb/sendMessage/",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {IdAgents:$('#IdAgents').val(),phoneNumber:$('#phoneNumber').val(),MessageText:$('#MessageText').val()},

          beforeSend:function () { 
            alert_encours()

          },
          success:function(data) {
            if (Number(data) == 1) {
              alert_succes("Message envoyé avec succès")
              $('#MessageText').val("")
              $('#MessagePolice').modal('hide')
            }else{
              alert_erro("Message non envoyer problème soit de connexion")
             
            }
            
           
          
          },
          error:function() {
            alert_erro("Message non envoyer problème soit de connexion")
          }
      });

    }

 
  }





  function alert_succes_chec(message){

         Swal.fire("Vérification de la facture avec succès!", message, "success");
 }


 function alert_succes(message){

         Swal.fire(message, '', "success");
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



  function get_detail_performance(id){

        $('#detailControl').modal()


        $.ajax({
          url : "<?=base_url()?>ihm/Performance_Police/getperformance/"+id,
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: {ID:id},
          beforeSend:function () { 
            $('#donnePerformance').html('<center><font color="#000"><i class="fas fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span></font></center>');
          },
          success:function(data) {
           $('#donnePerformance').html(data.cartes);
           //$('#perdoTitre').html(data.titres);
          
          },
          error:function() {
            $('#donnePerformance').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher cette page! Veuillez réessayer</div>');
          }
      });
   }


   function get_detail_Pdl(id = 0,phone = 0){

        // alert();

         $('#MessagePolice').modal()
        
         $('#phoneNumber').val(phone)

         $('#IdAgents').val(id)

      
     
    
    //window.location.href = '<?=base_url("ihm/Performance_Police/index/")?>'+id;
  }

  $(document).ready(function(){
    getMaps();
     
  
     setInterval(function() {
       $('#MessageText').focus()

      },1000);


     });

    function getMaps(ID=null){

      
    var AgentsOption = document.getElementById('Agents_deux').selectedOptions;
    var Agents = Array.from(AgentsOption).map(({ value }) => value);

   
    var ID =ID;
   
 

        $.ajax({
          url : "<?=base_url()?>geo/Elements_Pnb/get_carte/",
          type : "POST",
          dataType: "JSON",
          cache:false,
         
         data: {Agents:Agents,ID:ID},
          beforeSend:function () { 
             $('#mapview').html("");
            $('#mapview').html('<center style="margin-top: 250px;"><img height="50"   src="<?php echo base_url() ?>upload/reload.gif"></center>');
            
          },
          success:function(data) {

            
            $('#mapview').show();
            var x = document.getElementById("myAudio"); 

            if (data.id==1) 
            {
              xhhh.play(); 
            }

            // alert(data.id)S

              $('#mapview').html("");
           
           $('#mapview').html(data.cartes);

           //console.log(data.autreData)

           $('#actif').html(data.autreData.actif);
           $('#lieux').html(data.autreData.lieux);
           $('#nonActif').html(data.autreData.nonActif);
           $('#totalPnb').html(data.autreData.totalPnb);



           
           // $("#d_table1").DataTable();
            // $('#reload_page').hide();

            
            
          },
          error:function() {
            $('#carte_').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher la carte! Veuillez réessayer</div>');
          }
      });
    }

     


  </script>

  <script type="text/javascript">



  function getincident(id) { 

   $('#title').text('Liste des incidents');

   var PROVINCE_ID=$('#PROVINCE_ID').val();


   $('#incident').modal();
   
   $("#reponse").DataTable({
    "destroy" : true,
    "processing":true,
    "serverSide":true,
    "oreder":[],
    "ajax":{
      url: "<?php echo base_url('geo/Elements_Pnb/getincident/');?>"+id, 
      type:"POST",
      data : {PROVINCE_ID:PROVINCE_ID},
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

<script type="text/javascript">
   function check_new() 
      {
        $.ajax({
          url : "<?=base_url()?>geo/Elements_Pnb/check_new",
          type : "GET",
          dataType: "JSON",
          cache:false,
          success:function(data) {
           

            if (data.nbr==1) {
             
      
     
              getMaps(data.nbr);
              
            }
          }
        });
      }

</script>

    
   

<script>
    function submit_f(){
    
    myform.submit();
  }



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