<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">

<style type="text/css">
       #imageGet{
        width: 100px;
        height: 100px;
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
              <a href="<?= base_url('donnees/Candidats/index') ?>" class='btn btn-primary float-right'>
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

                <form enctype="multipart/form-data" name="myform" method="post" class="form-horizontal" action="<?= base_url('donnees/Candidats/update'); ?>">
                  <div id="add">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="FName">Nom</label>
                      <input type="hidden" class="form-control" name="ID_CANDIDAT" value="<?= $data['ID_CANDIDAT'] ?>">
                      <input type="text" name="NOM_CANDIDAT" autocomplete="off" id="NOM_CANDIDAT" value="<?= $data['NOM_CANDIDAT'] ?>"  class="form-control" >
                      <?php echo form_error('NOM_CANDIDAT', '<div class="text-danger">', '</div>'); ?>
                    </div>


                    <div class="col-md-6">
                      <label for="FName">Prenom</label>
                      <input type="text" name="PRENOM_CANDIDAT" autocomplete="off" id="PRENOM_CANDIDAT" value="<?= $data['PRENOM_CANDIDAT'] ?>"  class="form-control">
                      <?php echo form_error('PRENOM_CANDIDAT', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName">Numero CNI</label>
                      <input type="text" name="NUMERO_CNI_CANDIDAT" autocomplete="off" id="NUMERO_CNI_CANDIDAT" value="<?= $data['NUMERO_CNI_CANDIDAT'] ?>" class="form-control">
                      <?php echo form_error('NUMERO_CNI_CANDIDAT', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName">Téléphone</label>
                      <input type="tel" name="TELEPHONE_CANDIDAT" autocomplete="off" id="TELEPHONE_CANDIDAT"  value="<?= $data['TELEPHONE_CANDIDAT'] ?>" class="form-control">

                      <?php echo form_error('TELEPHONE_CANDIDAT', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Email</label>
                      <input type="text" name="EMAIL_CANDIDAT" autocomplete="off" id="EMAIL_CANDIDAT" value="<?= $data['EMAIL_CANDIDAT'] ?>" class="form-control">

                      <?php echo form_error('EMAIL_CANDIDAT', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Date de naissance</label>
                       <input type="date" name="DATE_NAISSANCE_CANDIDAT" autocomplete="off" id="DATE_NAISSANCE_CANDIDAT" value="<?= $data['DATE_NAISSANCE_CANDIDAT'] ?>" class="form-control">
                      <?php echo form_error('DATE_NAISSANCE_CANDIDAT', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <?php 
                     ?>
                    <div class="col-md-6">
                    <?php
                          $sexes = array(
                            array("SEXE" => "H", "DESCRIPTION" => "Homme"),
                            array("SEXE" => "F", "DESCRIPTION" => "Femme")
                        );

                        ?>
                      <label for="Ftype">Sexe</label>
                      <select class="form-control" name="SEXE_CANDIDAT" id="SEXE_CANDIDAT">
                        <option value="">---Sélectionner---</option>

                        <?php
                        foreach ($sexes as $value) {
                          $selected = "";
                          if ($value['SEXE'] == $data['SEXE_CANDIDAT']) {
                            $selected = "selected";
                          }

                        ?>
                          <option value="<?= $value['SEXE'] ?>" <?= $selected ?> ><?= $value['DESCRIPTION'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('SEXE_CANDIDAT', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="Ftype">Postes</label>
                      <select class="form-control" name="ID_POSTE" id="ID_POSTE">
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($postes as $value) {
                          $selected = "";
                          if ($value['ID_POSTE'] == $data['ID_POSTE']) {
                            $selected = "selected";
                          }

                        ?>
                          <option value="<?= $value['ID_POSTE'] ?>" <?= $selected ?> ><?= $value['DESCRIPTION'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('ID_POSTE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="Ftype">Parti politique</label>
                      <select class="form-control" name="ID_PARTIE_POLITIQUE" id="ID_PARTIE_POLITIQUE">
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($partis as $value) {
                          $selected = "";
                          if ($value['ID_PARTIE_POLITIQUE'] == $data['ID_PARTIE_POLITIQUE']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['ID_PARTIE_POLITIQUE'] ?>"  <?= $selected ?> ><?= $value['DESCRIPTION'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <!-- <div><font color="red" id="error_province"></font></div>  -->
                      <?php echo form_error('ID_PARTIE_POLITIQUE', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="col-md-6">
                      <label for="Ftype">Province</label>
                      <select class="form-control" name="PROVINCE_ID" id="PROVINCE_ID" onchange='get_communes()'>
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($provinces as $value) {

                          $selected = "";
                          if ($value['PROVINCE_ID'] == $selectProv['PROVINCE_ID']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['PROVINCE_ID'] ?>" <?= $selected ?>><?= $value['PROVINCE_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('PROVINCE_ID', '<div class="text-danger">', '</div>'); ?> 

                    </div>
                    <div class="col-md-6">
                      <label for="Ftype">Commune</label>
                      <select class="form-control" name="COMMUNE_ID" id="COMMUNE_ID" onchange='get_zones() '>
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($communes as $value) {

                          $selected = "";
                          if ($value['COMMUNE_ID'] == $selectComm['COMMUNE_ID']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['COMMUNE_ID'] ?>" <?= $selected ?>><?= $value['COMMUNE_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('COMMUNE_ID', '<div class="text-danger">', '</div>'); ?> 

                    </div>
                    <div class="col-md-6">
                      <label for="Ftype">Zone</label>
                      <select class="form-control" name="ZONE_ID" id="ZONE_ID"  onchange="get_collines();">
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($zones as $value) {

                          $selected = "";
                          if ($value['ZONE_ID'] == $selectZon['ZONE_ID']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['ZONE_ID'] ?>" <?= $selected ?>><?= $value['ZONE_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('ZONE_ID', '<div class="text-danger">', '</div>'); ?> 

                    </div>

                    <div class="col-md-6">
                      <label for="Ftype">Collines</label>
                      <select class="form-control" name="ID_COLLINE_CANDIDAT" id="ID_COLLINE_CANDIDAT" >
                        <option value="">---Sélectionner---</option>
                        <?php
                        foreach ($collines as $value) {

                          $selected = "";
                          if ($value['COLLINE_ID'] == $selectColl['COLLINE_ID']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['COLLINE_ID'] ?>" <?= $selected ?>><?= $value['COLLINE_NAME'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <?php echo form_error('COLLINE_ID', '<div class="text-danger">', '</div>'); ?> 

                    </div>
                    

                    <div class="col-md-6 row">
                      <div class="col-md-1">
                        <label for="text" style="font-size: 10px;top:" id="fileName"></label></BR>
                        <label class="label" data-toggle="tooltip" title="Attacher un fichier">
                          <font style="font-size: 40PX;color: green"><i class="fas fa-image rounded" id="avatar" alt="avatar"></i></font>
                          <input type="file" class="sr-only" id="PHOTO" name="PHOTO" accept="image/*" >
                        </label>
                      </div>

                      <div class="col-md-1" style="margin-top:-8px">
                        <label for="text" style="font-size: 5px;" id="fileName"></label>
                        <input type="hidden" name="ImageLink" id="ImageLink">
                        <a class="btn btn-md" data-toggle="modal" data-target="#PaiementModal" style="top:-10px" onclick="cameraGet()" id="newImagePrise">
                        <font style="font-size: 40PX;color: green" ><i class="fas fa-camera"></i></font></a>                       
                      </div>
                       <div class="col-md-6" style="margin-top:-8px">
                        <label for="text" style="font-size: 100px;" id="fileName"></label>
                        <div class="col-md-12" style="margin-top:-8px;margin-left:10px" style="margin-top: 5px" id="resultGet"></div>                   
                      </div>
                    </div>
                    <div class="col-md-12" style="margin-top:31px;">
                      <!-- <a href="#" class="next">suivant &raquo;</a>
                      <button type="button" style="float: right;" onclick='suivant()' class="btn btn-primary"><span class="fas fa-save"></span> suivant</button> -->
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
    var PROVINCE_ID = $('#PROVINCE_ID').val();
    if (PROVINCE_ID == '') {
      $('#COMMUNE_ID').html('<option value="">---Sélectionner---</option>');
      $('#ZONE_ID').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE_CANDIDAT').html('<option value="">---Sélectionner---</option>');
    }
    else { 
      $('#ZONE_ID').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE_CANDIDAT').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_communes/" + PROVINCE_ID,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#COMMUNE_ID').html(data);
        }
      });
    }
  }

  function get_zones() {
    var COMMUNE_ID = $('#COMMUNE_ID').val();
    if (COMMUNE_ID == '') {
      $('#ZONE_ID').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE_CANDIDAT').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_COLLINE_CANDIDAT').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_zones/" + COMMUNE_ID,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ZONE_ID').html(data);
        }
      });

    }
  }
  function get_collines(){
    var ZONE_ID = $('#ZONE_ID').val();
    if (ZONE_ID == '') {
      $('#ID_COLLINE_CANDIDAT').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_collines/" + ZONE_ID,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COLLINE_CANDIDAT').html(data);
        }
      });

    }
  }

 function get_communes_affectation(){
    var PROVINCE_ID_AFFECTATION = $('#PROVINCE_ID_AFFECTATION').val();
    if (PROVINCE_ID_AFFECTATION == '') {
      $('#COMMUNE_ID_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $('#ZONE_ID_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE_CANDIDAT_AFFECTATION').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ZONE_ID').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE_CANDIDAT').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_communes/" + PROVINCE_ID_AFFECTATION,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#COMMUNE_ID_AFFECTATION').html(data);
        }
      });

    }
  }
  function get_zones_affectation() {
    var COMMUNE_ID_AFFECTATION = $('#COMMUNE_ID_AFFECTATION').val();
    if (COMMUNE_ID_AFFECTATION == '') {
      $('#ZONE_ID_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE_CANDIDAT_AFFECTATION').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_COLLINE_CANDIDAT_AFFECTATION').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_zones/" + COMMUNE_ID_AFFECTATION,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ZONE_ID_AFFECTATION').html(data);
        }
      });

    }
  }


  function get_collines_affectation() {
    var ZONE_ID_AFFECTATION = $('#ZONE_ID_AFFECTATION').val();
    alert(ZONE_ID)
    if (ZONE_ID == '') {
      $('#ID_COLLINE_CANDIDAT_AFFECTATION').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>ihm/Provinces/get_collines/" + ZONE_ID_AFFECTATION,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COLLINE_CANDIDAT_AFFECTATION').html(data);
        }
      });

    }
  }
  //  function get_test()
  // {
  //    alert()

  //     $.ajax(
  //     {
  //       url:"https://api.eacpass.eac.int/data-integration/api/check",
  //       type:"GET",
  //       dataType:"JSON",
  //       success: function(data)
  //       {        
  //         console.log(data)
  //       }
  //     });


  // }
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
    $('#DATE_NAISSANCE_CANDIDAT').attr('max', maxDate);
  });
</script>