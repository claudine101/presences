<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php';?>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include VIEWPATH.'templates/navbar.php'; ?>
    <!-- Main Sidebar Container -->
    <?php include VIEWPATH.'templates/sidebar.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-9">

              <h4 class="m-0"><?=$title?></h4>
            </div><!-- /.col -->

            <div class="col-sm-3">
              <a href="<?=base_url('PSR/Prs_institution/retour')?>" class='btn btn-primary float-right'>
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

                <!-- <form  name="myform" method="post" class="form-horizontal" action="<?//= base_url('PSR/Prs_institution/add'); ?>" enctype="multipart/form-data"> -->


                  <form enctype="multipart/form-data" name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Prs_institution/add'); ?>">

                 <div class="row">
                  
                  <div class="col-md-6">
                    <label for="nom_instutition"> Nom de l'institution</label>
                    <input type="text" name="nom_instutition" autocomplete="off" id="nom_instutition" value="<?= set_value('nom_instutition') ?>"  class="form-control">
                    
                    <?php echo form_error('nom_instutition', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="personne"> Personne de contact</label>
                    <input type="text" name="personne" autocomplete="off" id="personne" value="<?= set_value('personne') ?>"  class="form-control">
                    
                    <?php echo form_error('personne', '<div class="text-danger">', '</div>'); ?> 
                  </div>

                  <div class="col-md-6">
                    <label for="telephone">Téléphone</label>
                    <input type="text" name="telephone" autocomplete="off" id="telephone" value="<?= set_value('telephone') ?>"  class="form-control">
                    
                    <?php echo form_error('telephone', '<div class="text-danger">', '</div>'); ?> 
                  </div>
                  <div class="col-md-6">
                    <label for="email">Email</label>
                    <input type="text" name="email" autocomplete="off" id="email" value="<?= set_value('email') ?>" onkeydown="valide_fn_mail()" onkeyup="valide_fn_mail()" class="form-control">
                    
                    <?php echo form_error('email', '<div class="text-danger" id="EEEE">', '</div>'); ?>
                    <font color="red" id="errorEMAIL"></font>
                  </div>

                  <div class="col-md-6">
                    <label for="adresse">Adresse</label>
                    <input type="text" name="adresse" autocomplete="off" id="adresse" value="<?= set_value('adresse') ?>"  class="form-control">
                    
                    <?php echo form_error('adresse', '<div class="text-danger">', '</div>'); ?> 
                  </div>

                  <!-- <div class="col-md-6">
                    <label for="signature">Logo</label>
                    <input type="file" name="signature" autocomplete="off" id="signature" value="<?//= set_value('signature') ?>"  class="form-control" accept="image/*">
                    
                    <?php// echo form_error('signature', '<div class="text-danger">', '</div>'); ?> 
                  </div> -->

                   <div class="col-md-6 row">
                      <div class="col-md-1">
                        <label for="text" style="font-size: 10px;top:" id="fileName"></label></BR>
                        <label class="label" data-toggle="tooltip" title="Attacher un fichier">
                          <font style="font-size: 40PX;color: green"><i class="fas fa-image rounded" id="avatar" alt="avatar"></i></font>
                          <input type="file" class="sr-only" id="PHOTO" name="PHOTO" accept="image/*" >
                        </label>
                      </div>
                     <div class="col-md-6" style="margin-top:-8px">
                        <label for="text" style="font-size: 5px;" id="fileName"></label>
                        <div class="col-md-12" style="margin-top: 5px" id="resultGet"></div>                    
                      </div> 
                    </div>

                </div>

                <div class="col-md-6" style="margin-top:31px;">
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

<?php include VIEWPATH.'templates/footer.php'; ?>





<script type="text/javascript">
  $('#telephone').on('input change',function()
  {

    $(this).val($(this).val().replace(/[^0-9]*$/gi, ''));
    $(this).val($(this).val().replace(' ', ''));
    var subStr = this.value.substring(0,1);

    if (subStr != '+') {
      $('[name = "telephone"]').val('+257');
    }

    if($(this).val().length == 12)
    {
      $('#telephone').text('');
    }
    else
    {
      $('#telephone').text('Numéro invalide ');
      if($(this).val().length > 12)
      {
        $(this).val(this.value.substring(0,12));
        $('#telephone').text('');
      }

    }

  });
</script>

<script type="text/javascript">
  function valide_fn_mail()
  {
    var EMAIL = $('#email').val();
    // alert(EMAIL);
    var email= /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var statut=1;

    $('#errorEMAIL').html('');


    if(!email.test($('#email').val()))
    {
      $('#errorEMAIL').html('Email est invalide');
      $('#EEEE').text('');
      statut=2
    }

    if(statut==1)
    {
      $('#add_form').submit();
    }

  }

</script>


<!--  -->


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

