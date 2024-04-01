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
              <a href="<?= base_url('PSR/Psr_elements/index') ?>" class='btn btn-primary float-right'>
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

                   <form   enctype="multipart/form-data" name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Utilisateur/add'); ?>" >

                  <div class="row">
                   
                   
                  <div class="col-md-6">
                    <label for="FName">Nom d'utilisateur</label>
                    <input type="text" name="NOM_UTILISATEUR" autocomplete="off" id="NOM_UTILISATEUR" value="<?= set_value('NOM_UTILISATEUR') ?>"  class="form-control">
                    
                    <?php echo form_error('NOM_UTILISATEUR', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                  
                  <div class="col-md-6">
                    <label for="FName">Mot de passe</label>
                    <input type="text" name="MOT_DE_PASSE" autocomplete="off" id="MOT_DE_PASSE" value="<?= set_value('MOT_DE_PASSE') ?>"  class="form-control">
                    
                    <?php echo form_error('MOT_DE_PASSE', '<div class="text-danger">', '</div>'); ?> 

                  </div>

                  
                  <div class="col-md-6">
                    <label for="FName">Carte Nationale d'Identité</label>
                    <input type="text" name="CNI" autocomplete="off" id="CNI" value="<?= set_value('CNI') ?>"  class="form-control">
                    
                    <?php echo form_error('CNI', '<div class="text-danger">', '</div>'); ?> 

                  </div>
                  <div class="col-md-6">
                    <label for="Ftype">Profil</label>
                    <select required class="form-control" name="CODE_PROFIL" id="CODE_PROFIL" onchange="get_instutitions(); " >
                      <option value="">---Sélectionner---</option>
                      <?php
                      foreach ($profils as $value)
                      {
                        ?>
                        <option value="<?=$value['CODE_PROFIL']?>"><?=$value['STATUT']?></option>
                        <?php
                      }
                      ?>
                    </select>
                    <!-- <div><font color="red" id="error_province"></font></div>  -->
                    <?php echo form_error('CODE_PROFIL', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <div id="assureur" style="display: none;" class="col-md-6">
                      <label for="Ftype">Assureur</label>
                      <select  class="form-control" name="ID_ASSUREUR" id="ID_ASSUREUR" >
                      <option value="">---Sélectionner---</option>
                      <?php
                      foreach ($assureurs as $value)
                      {
                        ?>
                        <option value="<?=$value['ID_ASSUREUR']?>"><?=$value['ASSURANCE']?></option>
                        <?php
                      }
                      ?>
                    </select>
                      <!-- <div><font color="red" id="error_zone"></font></div> -->
                      <?php echo form_error('ID_ASSUREUR', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div id="institution" style="display: none;" class="col-md-6">
                      <label for="Ftype">Institution</label>
                      <select  class="form-control" name="ID_PSR_INSTITUTION" id="ID_PSR_INSTITUTION" >
                      <option value="">---Sélectionner---</option>
                      <?php
                      foreach ($institutions as $value)
                      {
                        ?>
                        <option value="<?=$value['ID_PSR_INSTITUTION']?>"><?=$value['NOM_INSTITUTION']?></option>
                        <?php
                      }
                      ?>
                    </select>
                      <!-- <div><font color="red" id="error_colline"></font></div> -->
                      <?php echo form_error('ID_PSR_INSTITUTION', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="col-md-6 row">
                      <div class="col-md-1">
                        <label for="text" style="font-size: 10px;top:" id="fileName"></label></BR>
                        <label class="label" data-toggle="tooltip" title="Attacher un fichier">
                          <font style="font-size: 40PX;color: green"><i class="fas fa-image rounded" id="avatar" alt="avatar"></i></font>
                          <input type="file" class="sr-only" id="ICON_LOGO" name="ICON_LOGO" accept="image/*" >
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
  // $('#ICON_LOGO').val(image);
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

function get_instutitions() {
   var CODE_PROFIL = $('#CODE_PROFIL').val();
   alert(CODE_PROFIL)
    //UTILISATEUR D'UN ASSUREUR
    if(CODE_PROFIL=='AS2023')
    {
       $('#assureur').show()
       $('#institution').hide()
       $('#ID_ASSUREUR').prop('required',true)
       $('#ID_PSR_INSTITUTION').prop('required',false)

    }
    //UTILISATEUR D'UN INSTITUTION
    else if(CODE_PROFIL=='CI2023')
    {
       $('#assureur').hide()
       $('#institution').show()
       $('#ID_ASSUREUR').prop('required',false)
       $('#ID_PSR_INSTITUTION').prop('required',false)
    }
    //AUTRE UTILISATEUR 
    else{
      $('#assureur').hide()
       $('#institution').hide()
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

  $("#ICON_LOGO").change(function() {
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