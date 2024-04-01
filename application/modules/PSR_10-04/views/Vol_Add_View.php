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
              <a href="<?= base_url('PSR/Vol_Controller/index') ?>" class='btn btn-primary float-right'>
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
              <?= $this->session->flashdata('message'); ?>
              <div class="col-md-12">

                <form enctype="multipart/form-data" name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Vol_Controller/add'); ?>">

                  <div class="row">
                    <div class="col-md-6">
                      <label for="Ftype">Plaque</label>

                       <input type="text" name="ID_IMMATRICULATION"  id="ID_IMMATRICULATION" value="<?= set_value('ID_IMMATRICULATION') ?>" class="form-control" required>
                   
                      <!-- <div><font color="red" id="error_province"></font></div>  -->
                      <?php echo form_error('ID_IMMATRICULATION', '<div class="text-danger">', '</div>'); ?>
                    </div>


                    <div class="col-md-3">
                      <label for="FName"> Couleur </label>
                      <select class="form-control" name="ID_TYPE_COULEUR" id="ID_TYPE_COULEUR" onchange="getAutreAvenue(this.value)" required>

                        <option value="">Sélectionner</option>
                        <?php
                        foreach ($couleur as $key_marque) {
                          if ($key_marque['ID_TYPE_COULEUR'] == set_value('ID_TYPE_COULEUR')) { ?>
                            <option value="<?= $key_marque['ID_TYPE_COULEUR'] ?>" selected=''><?= $key_marque['COULEUR'] ?></option>
                          <?php } else { ?>
                            <option value="<?= $key_marque['ID_TYPE_COULEUR'] ?>"><?= $key_marque['COULEUR'] ?></option>
                        <?php
                          }
                        }

                        ?>

                      </select>
                    </div>



                     <div id="autre_description" class="col-md-3 row" style="display:none">
                     <label for="Ftype" style="color:green">Nouvelle couleur</label>
                      <input type="text" class="form-control col-md-10" id="AUTRE_COLOR" placeholder="Autre serie" name="AUTRE_COLOR"><span class="col-md-1"></span>
                      <button type="button" class="btn btn-outline-success btn-sm  float-right  col-md-1" onclick="save_newAvenue()"><i class="nav-icon fas fa-plus"></i></button>
                    </div>







                    <div class="col-md-6">
                      <label for="FName"> Marque</label>
                      <input type="text" name="MARQUE_VOITURE" autocomplete="off" id="MARQUE_VOITURE" value="<?= set_value('MARQUE_VOITURE') ?>" class="form-control" required>

                      <?php echo form_error('MARQUE_VOITURE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="FName"> Date du vol</label>
                        <input type="date" name="DATE_VOLER" autocomplete="off" id="DATE_VOLER" value="<?= set_value('DATE_VOLER') ?>" class="form-control" required>

                        <?php echo form_error('DATE_VOLER', '<div class="text-danger">', '</div>'); ?>
                      </div>
                      <div class="col-md-6">
                        <label for="FName">Numero de Série</label>
                        <input type="text" name="NUMERO_SERIE" autocomplete="off" id="NUMERO_SERIE" value="<?= set_value('NUMERO_SERIE') ?>" class="form-control" required>

                        <?php echo form_error('NUMERO_SERIE', '<div class="text-danger">', '</div>'); ?>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <label for="FName">NUMERO PERMIS</label>
                      <input type="text" name="NUMERO_PERMIS" autocomplete="off" id="NUMERO_PERMIS" value="<?= set_value('NUMERO_PERMIS') ?>" class="form-control" required>

                    </div>




                    <div class="row">
                      <div class="col-md-6">
                        <label for="text" style="font-size: 10px;" id="fileName"></label></BR>
                        <label class="label" data-toggle="tooltip" title="Attacher un fichier">
                          <font style="font-size: 40PX;color: green"><i class="fas fa-image rounded" id="avatar" alt="avatar"></i></font>
                          <input type="file" class="sr-only" id="PHOTO" name="PHOTO" accept="image/*" required>
                        </label>
                      </div>
                      <div class="col-md-6" style="margin-top: 5px" id="resultGet"></div>


                      <div class="col-md-12" style="margin-top:31px;">
                        <button type="submit" style="float: right;" class="btn btn-primary"><span class="fas fa-save"></span> Enregistrer</button>
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
<script type="text/javascript">
  $('#message').delay('slow').fadeOut(3000);

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



    function getAutreAvenue(id = 0){
  if (id == 0) {
    $('#autre_description').show()
    $('#AUTRE_COLOR').focus()
  }else{
     $('#autre_description').hide()
  }




  function save_newAvenue(){
   var AUTRE_COLOR = $('#AUTRE_COLOR').val();
   if (ID_IMMATRICULATION == "") {
    $('#ID_IMMATRICULATION').css('border-color','red');
  }else if (AUTRE_COLOR == "") {
    $('#ID_IMMATRICULATION').css('border-color','green');
    $('#AUTRE_COLOR').css('border-color','red');
  }else{
    $('#ID_IMMATRICULATION').css('border-color','green');
    $('#AUTRE_COLOR').css('border-color','green');

    var ID_IMMATRICULATION = $('#ID_IMMATRICULATION').val();
    var AUTRE_COLOR = $('#AUTRE_COLOR').val();

    var dataU = new FormData();
    dataU.append('ID_IMMATRICULATION',ID_IMMATRICULATION);
    dataU.append('AUTRE_COLOR',AUTRE_COLOR);
    $.ajax({
      url : "<?= base_url() ?>menage/Chefs_menage/save_avenue",
      type : "POST",
      dataType: "JSON",
      data : dataU,
      processData: false,
      contentType: false,
      success:function(data) {
        $('#AUTRE_COLOR').val("");
        get_avenues(data.id)
        $('#autre_description').hide()
      },
    });
  }

}
  function autre(){
   var ID_AVENUE = $('#ID_AVENUE').val();
   if(ID_AVENUE=='Autre'){
   $('#autre_avenue').show()
   }
   else{
   $('#autre_avenue').hide()
   }
  }


</script>


<?php include VIEWPATH . 'templates/footer.php'; ?>