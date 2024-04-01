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

              <h4 class="m-0"><?= $title ?></h4>
            </div><!-- /.col -->

            <div class="col-sm-3">
              <a href="<?= base_url('ihm/Fourriere/index') ?>" class='btn btn-primary float-right'>
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
              <?= $message; ?>
              <div class="col-md-12">

                <form enctype="multipart/form-data" name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Fourriere/update'); ?>">

                  <div class="row">
                    <div class="col-md-6">
                      <label for="FName">Numero de la plaque</label>
                      <input type="text" name="NUMERO_PLAQUE" autocomplete="off" id="NUMERO_PLAQUE" value="<?= $fourriere['NUMERO_PLAQUE'] ?>" class="form-control">
                      <?php echo form_error('NUMERO_PLAQUE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                  <!--  <div class="col-md-6">
                      <label for="FName">Carte rose</label>
                      <input type="text" name="CARTE_ROSE" autocomplete="off" id="CARTE_ROSE" value="<?= $rose ?>" class="form-control">
                      <?php echo form_error('CARTE_ROSE', '<div class="text-danger">', '</div>'); ?>
                    </div> -->

                    <div class="col-md-6">
                      <label for="FName">Fourrière</label>
                      <input type="text" name="NOM_FOURRIERE" autocomplete="off" id="NOM_FOURRIERE" value="<?= $fourriere['NOM_FOURRIERE'] ?>" class="form-control">

                      <?php echo form_error('NOM_FOURRIERE', '<div class="text-danger">', '</div>'); ?>

                    </div>
                   

                    <div class="col-md-6">
                      <label for="FName">NIF</label>
                      <input type="tel" name="NIF" autocomplete="off" id="NIF" value="<?= $fourriere['NIF'] ?>" class="form-control">
                      <?php echo form_error('NIF', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="col-md-6">
                      <input type="hidden" class="form-control" name="ID_FOURRIERE" value="<?= $fourriere['ID_FOURRIERE'] ?>">
                      <label for="FName"> Nom du responsable</label>
                      <input type="text" name="NON_DU_RESPONSABLE" autocomplete="off" id="NON_DU_RESPONSABLE" value="<?= $fourriere['NON_DU_RESPONSABLE'] ?>" class="form-control">
                      <?php echo form_error('NON_DU_RESPONSABLE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Email</label>
                      <input type="text" name=" EMAIL_FROURRIERE" autocomplete="off" id=" EMAIL_FROURRIERE" value="<?= $fourriere['EMAIL_FROURRIERE'] ?>" class="form-control">
                      <?php echo form_error(' EMAIL_FROURRIERE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                     <div class="col-md-6">
                      <label for="FName">Téléphone</label>
                      <input type="text" name=" TELEPHONE_FOURRIERE" autocomplete="off" id=" TELEPHONE_FOURRIERE" value="<?= $fourriere['TELEPHONE_FOURRIERE'] ?>" class="form-control">
                      <?php echo form_error(' TELEPHONE_FOURRIERE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="Ftype">Type de la fourrière</label>
                      <select class="form-control" name="TYPE_FOURRIERE" id="TYPE_FOURRIERE">
                        <!-- <option value="">---Sélectionner---</option> -->
                        <?php

                        foreach ($types as $value) {

                          $selected = "";
                          if ($value['ID_TYPE_FOURR'] == $fourriere['TYPE_FOURRIERE']) {
                            $selected = "selected";
                          }
                        ?>
                          <option value="<?= $value['ID_TYPE_FOURR'] ?>" <?= $selected ?>><?= $value['TYPE_FOURRIERE'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <!-- <div><font color="red" id="error_province"></font></div>  -->
                      <?php echo form_error('TYPE_FOURRIERE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    

                    <div class="col-md-6">
                      <label for="FName">Adresse</label>
                      <input type="text" name="ADRESSE" autocomplete="off" id="ADRESSE" value="<?= $fourriere['ADRESSE'] ?>" class="form-control">
                      <?php echo form_error('ADRESSE', '<div class="text-danger">', '</div>'); ?>

                    </div>
                    
                    <div class="col-md-6">
                      <label for="Ftype">Province</label>
                      <select class="form-control" name="ID_PROVINCE" id="ID_PROVINCE" onchange="get_communes();">
                        <!-- <option value="">---Sélectionner---</option> -->
                        <?php

                        foreach ($provinces as $value) {

                          $selected = "";
                          if ($value['PROVINCE_ID'] == $fourriere['PROVINCE_ID']) {
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
                        <label for="text" style="font-size: 5px;" id="fileName"></label>
                        <div class="col-md-12" style="margin-top: 5px" id="resultGet"></div>                    
                      </div>


                    
                    </div>

                    <div class="col-md-12" style="margin-top:31px;">
                      <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
                    </div>
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
  
  $('#canvas').hide()


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

  function get_communes() {
    var ID_PROVINCE = $('#ID_PROVINCE').val();
    if (ID_PROVINCE == '') {
      $('#ID_COMMUNE').html('<option value="">---Sélectionner---</option>');
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $('#ID_ZONE').html('<option value="">---Sélectionner---</option>');
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
      $.ajax({
        url: "<?= base_url() ?>ihm/Fourriere/get_communes/" + ID_PROVINCE,
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
        url: "<?= base_url() ?>ihm/Fourriere/get_zones/" + ID_COMMUNE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_ZONE').html(data);
        }
      });

    }
  }


  function get_collines() {
    var ID_ZONE = $('#ID_ZONE').val();
    if (ID_ZONE == '') {
      $('#ID_COLLINE').html('<option value="">---Sélectionner---</option>');
    } else {
      $.ajax({
        url: "<?= base_url() ?>ihm/Fourriere/get_collines/" + ID_ZONE,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#ID_COLLINE').html(data);
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
    $('#DATE_NAISSANCE').attr('max', maxDate);
  });
</script>