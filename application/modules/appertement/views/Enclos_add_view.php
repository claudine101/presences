<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">

<style type="text/css">
       #imageGet{
        width: 90px;
        height: 80px;
       }
     </style>

  <div class="wrapper">
    <!-- Navbar -->
    <?php include VIEWPATH . 'templates/navbar.php'; ?>
    <!-- Main Sidebar Container -->
    <?php include VIEWPATH . 'templates/sidebar.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-9">
              <div id="titleNouveau"><h4  class="m-0"><?= $title ?></h4></div>
              <div id="titleAffectation"><h4  style="display: none;" class="m-0">Affectation autorite des menages</h4></div>

            </div><!-- /.col -->

            <div class="col-sm-3">
              <a href="<?= base_url('appertement/Enclos/index') ?>" class='btn btn-primary float-right'>
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

                <form enctype="multipart/form-data" name="myform" method="post" class="form-horizontal" action="<?= base_url('appertement/Enclos/add'); ?>">
                  <div id="add">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="FName">Nom</label>
                      <input type="text" name="NOM" autocomplete="off" id="NOM" value="<?= set_value('NOM') ?>" class="form-control" >
                      <?php echo form_error('NOM', '<div class="text-danger">', '</div>'); ?>

                    </div>


                    <div class="col-md-6">
                      <label for="FName">Prenom</label>
                      <input type="text" name="PRENOM" autocomplete="off" id="PRENOM" value="<?= set_value('PRENOM') ?>" class="form-control">
                      <?php echo form_error('PRENOM', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Téléphone</label>
                      <input type="tel" name="TELEPHONE" autocomplete="off" id="TELEPHONE" value="<?= set_value('TELEPHONE') ?>" class="form-control">
                      <?php echo form_error('TELEPHONE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Email</label>
                      <input type="text" name="EMAIL" autocomplete="off" id="EMAIL" value="<?= set_value('EMAIL') ?>" class="form-control">

                      <?php echo form_error('EMAIL', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName">Numero enclos</label>
                      <input type="text" name="NUMERO_MAISON" autocomplete="off" id="NUMERO_MAISON" value="<?= set_value('NUMERO_MAISON') ?>" class="form-control">

                      <?php echo form_error('NUMERO_MAISON', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <?php if($profil==20) { ?>
                      <input type="hidden" name="ID_AVENUE" autocomplete="off" id="ID_AVENUE" value="<?=$AVENUES?>" class="form-control">
                      <input type="hidden" name="ID_COLLINE" autocomplete="off" id="ID_COLLINE" value="<?=$COLLINES?>" class="form-control">

                     <!-- CHEF DE SECTEUR -->
                    <?php } 

                    elseif($profil==22) { ?>
                      <div class="col-md-6">
                      <label for="Ftype">Avenues</label>
                        <select class="form-control" name="AVENUE_ID" id="AVENUE_ID"  onchange="getAutreAvenue(this.value)">
                            <option value="">---Sélectionner---</option>
                            <option value="0">autre</option>
                            <?php
                            foreach ($avenues as $value) {
                            ?>
                              <option value="<?= $value['AVENUE_ID'] ?>"><?= $value['AVENUE_NAME'] ?></option>
                            <?php
                            }
                            ?>
                          </select>
                      </div>
                       <div id="autre_description" class="col-md-6 row" style="display:none">
                     
                      <input type="text" class="form-control col-md-10" id="AVENUE_NAME" placeholder="Autre serie" name="AVENUE_NAME"><span class="col-md-1"></span>
                      <button type="button" class="btn btn-outline-success btn-sm  float-right  col-md-1" onclick="save_newAvenue()"><i class="nav-icon fas fa-plus"></i></button>
                    
                    </div>
                        <input type="hidden" name="ID_COLLINE" autocomplete="off" id="ID_COLLINE" value="<?=$COLLINES?>" class="form-control">

                    <?php }
                    elseif($profil==21) { ?>
                      
                   <div class="col-md-6">
                      <label for="Ftype">Colline</label>
                      <select class="form-control" name="ID_COLLINE" id="ID_COLLINE" onchange="get_avenues();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_colline"></font></div> -->
                      <?php echo form_error(' ID_COLLINE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="Ftype">avenue</label>
                      <!-- <select class="form-control" name="ID_AVENUE" id="ID_AVENUE" onchange="autre();"> -->
                    <select class="form-control" name="ID_AVENUE" id="ID_AVENUE" onchange="getAutreAvenue(this.value)">
                        
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_colline"></font></div> -->
                      <?php echo form_error('ID_AVENUE', '<div class="text-danger">', '</div>'); ?>
                   
                    </div>
                     <div id="autre_description" class="col-md-6 row" style="display:none">
                     
                      <input type="text" class="form-control col-md-10" id="AVENUE_NAME" placeholder="Autre serie" name="AVENUE_NAME"><span class="col-md-1"></span>
                      <button type="button" class="btn btn-outline-success btn-sm  float-right  col-md-1" onclick="save_newAvenue()"><i class="nav-icon fas fa-plus"></i></button>
                    
                    </div>
                    
                    <?php }
                    else{ ?>
                      <div class="col-md-6">
                      <label for="Ftype">Province</label>
                      <select required class="form-control" name="ID_PROVINCE" id="ID_PROVINCE" onchange="get_communes();">
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($provinces as $value) {
                        ?>
                          <option value="<?= $value['PROVINCE_ID'] ?>"><?= $value['PROVINCE_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <!-- <div><font color="red" id="error_province"></font></div>  -->
                      <?php echo form_error('ID_PROVINCE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="Ftype">Commune</label>
                      <select required class="form-control" name="ID_COMMUNE" id="ID_COMMUNE" onchange="get_zones();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_commune"></font></div> -->
                      <?php echo form_error('ID_COMMUNE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="Ftype">Zone</label>
                      <select class="form-control" name="ID_ZONE" id="ID_ZONE" onchange="get_collines();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_zone"></font></div> -->
                      <?php echo form_error('ID_ZONE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="Ftype">Colline</label>
                      <select class="form-control" name="ID_COLLINE" id="ID_COLLINE" onchange="get_avenues();">
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_colline"></font></div> -->
                      <?php echo form_error(' ID_COLLINE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="Ftype">avenue</label>
                      <!-- <select class="form-control" name="ID_AVENUE" id="ID_AVENUE" onchange="autre();"> -->
                    <select class="form-control" name="ID_AVENUE" id="ID_AVENUE" onchange="getAutreAvenue(this.value)">
                        
                        <option value="">---Sélectionner---</option>
                      </select>
                      <!-- <div><font color="red" id="error_colline"></font></div> -->
                      <?php echo form_error('ID_AVENUE', '<div class="text-danger">', '</div>'); ?>
                   
                    </div>
                     <div id="autre_description" class="col-md-6 row" style="display:none">
                     
                      <input type="text" class="form-control col-md-10" id="AVENUE_NAME" placeholder="Autre serie" name="AVENUE_NAME"><span class="col-md-1"></span>
                      <button type="button" class="btn btn-outline-success btn-sm  float-right  col-md-1" onclick="save_newAvenue()"><i class="nav-icon fas fa-plus"></i></button>
                    
                    </div>
                    
                    <?php } ?>
                    <div class="col-md-6">
                      <label for="FName">Adresse</label>
                      <input type="tel" name="ADRESSE" autocomplete="off" id="ADRESSE" value="<?= set_value('ADRESSE') ?>" class="form-control">
                      <?php echo form_error('ADRESSE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-12" style="margin-top:31px;">
                      <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
                    </div>
                  </div>
                   </div>


                  <!-- SUIVANT -->
                  
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



<!-- MODAL IMAGE CAMERA -->



  <div class='modal fade' id='PaiementModal'>
    <div class='modal-dialog modal-lg'>
      <div class='modal-content'>
        <div class="modal-header" style="background-color: #000;color: #fff;">
          <h5 class="modal-title" id="staticBackdropLabel"></h5>
          <span class="btn btn-default btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></span>
        </div>
        <div class='modal-body'>
          <center>
            <video id="video" width="500"  height="480" autoplay style="border: 1px solid black;"></video>
            <canvas id="canvas" width="500" height="480" ></canvas>
          </center>
        </div>
        <div class='modal-footer'><center>
          <span id="changeMode" style=""><button onclick="canvasGet()" class='btn btn-warning btn-md' type="button">Capturer</button></span>
          <button class='btn btn-default btn-md'  onclick="cameraGetNew()">Annuler</button></center>

          <!--  data-dismiss='modal' -->
        </div>
      </div>
    </div>
  </div>

<?php include VIEWPATH . 'templates/footer.php'; ?>

<script type="text/javascript">
  $(document).ready(function() {
    add();
  });
  $('#canvas').hide()
  
 function add(){
  $('#add').show()
  $('#suivant').hide()
  $('titleNouveau').hide()
  $('titleAffectation').hide()
  }
  function suivant(){
  $('#add').hide()
  $('#suivant').show()
  $('titleNouveau').hide()
  $('titleAffectation').hide()
  }

function cameraGetNew(){
  $('#video').show()
  $('#canvas').hide()
  $('#changeMode').html('<button onclick="canvasGet()" class="btn btn-warning btn-md" type="button">Capturer</button>')
}

function convertCanvasToImage() {
  var canvas = document.getElementById('canvas');
  var image = new Image();
  image.id = "imageGet"
  image.src = canvas.toDataURL("image/png");
  var type = 'image/png';
  var imgName = generate_code(7)+".png";
  download(canvas.toDataURL("image/png"), imgName);
  // $('#PHOTO').val(image);
  console.log(image)
  $('#ImageLink').val(canvas.toDataURL("image/png"));
  $('#resultGet').html(image);
}
function cameraGet(){
  $('#video').show()
  $('#canvas').hide()

  var video = document.getElementById('video');
  // Get access to the camera!
  if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
      // Not adding `{ audio: true }` since we only want video now
      navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
          //video.src = window.URL.createObjectURL(stream);
          video.srcObject = stream;
          video.play();
      });
  }
}

function canvasGet(){

  var canvas = document.getElementById('canvas');
  var context = canvas.getContext('2d');
  var video = document.getElementById('video');
  context.drawImage(video, 0, 0, 500, 480);

  $('#video').hide()
  $('#canvas').show()
  $('#changeMode').html('<button onclick="convertCanvasToImage()" class="btn btn-success" data-dismiss="modal" type="button">Terminer</button>')
}
function download(dataurl, filename) {
  const link = document.createElement("a");
  link.href = dataurl;
  link.download = filename;
  link.click();
}



function generate_code(taille=0){

    var Caracteres = '0123456789'; 
    var QuantidadeCaracteres = Caracteres.length; 
    QuantidadeCaracteres--; 
    var Hash= ''; 
      for(var x =1; x <= taille; x++){ 
          var Posicao = Math.floor(Math.random() * QuantidadeCaracteres);
          Hash +=  Caracteres.substr(Posicao, 1); 
      }
      return "25"+Hash; 
}

</script>
<script>
  get_test()
  function get_communes(){
    var ID_PROVINCE = $('#ID_PROVINCE').val();
    if (ID_PROVINCE == '') {
      $('#ID_COMMUNE').html('<option value="">---Sélectionner---</option>');
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    }
    else { 
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>appertement/Enclos/get_communes/" + ID_PROVINCE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COMMUNE').html(data);
        }
      });
    }
  }

  function get_zones() {
    var ID_COMMUNE = $('#ID_COMMUNE').val();
    if (ID_COMMUNE == '') {
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>appertement/Enclos/get_zones/" + ID_COMMUNE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_ZONE').html(data);
        }
      });

    }
  }
  function get_collines(){
    var ID_ZONE = $('#ID_ZONE').val();
    if (ID_ZONE == '') {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>appertement/Enclos/get_collines/" + ID_ZONE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COLLINE').html(data);
        }
      });

    }
  }
  function get_avenues(ID_AVENUE=0){
    var ID_COLLINE = $('#ID_COLLINE').val();
    if (ID_COLLINE == '') {
      $('#ID_AVENUE').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>Appertement/Enclos/get_avenuesAdd/" + ID_COLLINE+"/"+ID_AVENUE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_AVENUE').html(data);
        }
      });

    }
  }

  function getAutreAvenue(id = 0){
  if (id == 0) {
    $('#autre_description').show()
  }else{
     $('#autre_description').hide()
  }

}
 function save_newAvenue(){
   var AVENUE_NAME = $('#AVENUE_NAME').val();
   if (ID_COLLINE == "") {
    $('#ID_COLLINE').css('border-color','red');
  }else if (AVENUE_NAME == "") {
    $('#ID_COLLINE').css('border-color','green');
    $('#AVENUE_NAME').css('border-color','red');
  }else{
    $('#ID_COLLINE').css('border-color','green');
    $('#AVENUE_NAME').css('border-color','green');

    var ID_COLLINE = $('#ID_COLLINE').val();
    var AVENUE_NAME = $('#AVENUE_NAME').val();

    var dataU = new FormData();
    dataU.append('ID_COLLINE',ID_COLLINE);
    dataU.append('AVENUE_NAME',AVENUE_NAME);
    $.ajax({
      url : "<?= base_url() ?>Appertement/Enclos/save_avenue",
      type : "POST",
      dataType: "JSON",
      data : dataU,
      processData: false,
      contentType: false,
      success:function(data) {
        $('#AVENUE_NAME').val("");
        get_avenues(data.id)
        $('#autre_description').hide()
      },
    });
  }

}
 function get_communes_affectation(){
    var ID_PROVINCE_AFFECTATION = $('#ID_PROVINCE_AFFECTATION').val();
    if (ID_PROVINCE_AFFECTATION == '') {
      $('#ID_COMMUNE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $('#ID_ZONE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>appertement/Enclos/get_communes/" + ID_PROVINCE_AFFECTATION,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COMMUNE_AFFECTATION').html(data);
        }
      });

    }
  }
  function get_zones_affectation() {
    var ID_COMMUNE_AFFECTATION = $('#ID_COMMUNE_AFFECTATION').val();
    if (ID_COMMUNE_AFFECTATION == '') {
      $('#ID_ZONE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_COLLINE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>appertement/Enclos/get_zones/" + ID_COMMUNE_AFFECTATION,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_ZONE_AFFECTATION').html(data);
        }
      });

    }
  }


  function get_collines_affectation() {
    var ID_ZONE_AFFECTATION = $('#ID_ZONE_AFFECTATION').val();
    alert(ID_ZONE)
    if (ID_ZONE == '') {
      $('#ID_COLLINE_AFFECTATION').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>appertement/Enclos/get_collines/" + ID_ZONE_AFFECTATION,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COLLINE_AFFECTATION').html(data);
        }
      });

    }
  }

  
</script>
<script type="text/javascript">
  function readURL(input) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        //alert(e.target.result);
        $('#buttonFile').delay(100).show('hide');
        let myArr = e.target.result;
        const myArrData = myArr.split(":");
        let deux_name = myArrData[1].split("/");

        if (deux_name[0] == 'image') {
          var back_lect = '<img  height="80" src="' + e.target.result + '">';
          $('#resultGet').html(back_lect);
        } else {
          $('#resultGet').html('');
        }

      }

      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

  $("#PHOTO").change(function() {
    readURL(this);
  });
</script>

<script type="text/javascript">
  $(function() {
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1; // jan=0; feb=1 .......
    var day = dtToday.getDate();
    var year = dtToday.getFullYear() - 18;
    if (month < 10)
      month = '0' + month.toString();
    if (day < 10)
      day = '0' + day.toString();
    var minDate = year + '-' + month + '-' + day;
    var maxDate = year + '-' + month + '-' + day;
    $('#DATE_NAISSANCE').attr('max', maxDate);
  });
</script>