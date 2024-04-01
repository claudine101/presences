<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH . 'templates/header.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
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
              <a href="<?= base_url('ihm/Chaussee/index') ?>" class='btn btn-primary float-right'>
                <i class="nav-icon fas fa-list ul"></i>
                Liste
              </a>
            </div><!-- /.col -->
          </div>
        </div><!-- /.container-fluid -->
      </section>

     
     <style type="text/css">
       #imageGet{
        width: 60px;
        height: 60px;
       }
     </style>




      <!-- Main content -->
      <section class="content">
        <div class="col-md-12 col-xl-12 grid-margin stretch-card">

          <div class="card">
            <div class="card-body">
              
            
              <div class="col-lg-12">
                 <div class="row">
                    
                    
                    <div class="col-lg-1">
                      
                         <label for="text" style="font-size: 20px;" id="fileName"></label>
                         <label class="label" data-toggle="tooltip" title="Attacher un fichier">
                           <font style="font-size: 40PX;color: green" ><i class="fas fa-image rounded" id="avatar" alt="avatar"></i></font>
                           <input type="file" class="sr-only" id="PHOTO" name="PHOTO" accept="image/*" required>
                         </label>

                    </div>

                     <div class="col-lg-1">
                        <input type="hidden" name="ImageLink" id="ImageLink">
                        <a class="btn btn-md" data-toggle="modal" data-target="#PaiementModal" style="top:-5px" onclick="cameraGet()" id="newImagePrise">
                        <font style="font-size: 38PX;color: green" ><i class="fas fa-camera"></i></font></a>                       
                    </div>

                  
                  </div>


                  <div class="col-md-12" style="margin-top:31px;">
                    <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Ajouter</button>
                  </div>



                </form>

             

                <div class='modal fade' id='PaiementModal'>
                  <div class='modal-dialog modal-lg'>
                    <div class='modal-content'>


                      <div class='modal-body'>
                        <center>
                          <video id="video" width="500"  height="480" autoplay style="border: 1px solid black;"></video>
                          <canvas id="canvas" width="500" height="480" ></canvas>
                        </center>
                           
                      </div>

                      <div class='modal-footer'>
                        <span id="changeMode"><button onclick="canvasGet()" class='btn btn-warning btn-md' type="button">Capturer</button></span>
                        <button class='btn btn-primary btn-md'  onclick="cameraGetNew()">Annuler</button>

                       <!--  data-dismiss='modal' -->
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</body>

<!-- <canvas id="canvas" width="480" height="480"></canvas> -->

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
  download(canvas.toDataURL("image/png"), generate_code(7)+".png");
  console.log(image)
  $('#ImageLink').val(canvas.toDataURL("image/png"));
  $('#newImagePrise').html(image);
 
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





// document.getElementById("snap").addEventListener("click", function() {
// });


/*function convertImageToCanvas(image) {
  var canvas = document.createElement("canvas");
  canvas.width = image.width;
  canvas.height = image.height;
  canvas.getContext("2d").drawImage(image, 0, 0);

  return canvas;
}*/





  function saveDonne() {

    var FR = $('#FR').val()
    var ENG = $('#ENG').val()
    var KIR = $('#KIR').val()
    var KISW = $('#KISW').val()

    var form = new FormData();

    form.append("FR", FR)
    form.append("ENG", ENG)
    form.append("KIR", KIR)
    form.append("KISW", KISW)
    $.ajax({
      url: "<?= base_url() ?>ihm/Chaussee/saveForma",
      type: "POST",
      dataType: "JSON",
      cache: false,
      data: form,
      processData: false,
      contentType: false,
      beforeSend: function() {},
      success: function(data) {

        $('#QUESTIONNAIRE_TRADUCTION').val(JSON.stringify(data))
        $('#PaiementModal').modal('hide')
      }

    });

  }
</script>