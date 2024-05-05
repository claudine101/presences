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

              <h4 class="m-0"style="color:blue"><?=$title?></h4>
            </div><!-- /.col -->

            <div class="col-sm-3">
              <a href="<?=base_url('administration/Droit/index')?>" class='btn btn-primary float-right'>
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

                <form  name="myform" method="post" class="form-horizontal" action="<?= base_url('administration/Droit/add'); ?>" >

                  <div class="row">
                    <div class="col-md-6">
                     <label for="Ftype">Profil</label>
                     <select required class="form-control" name="ID_PROFIL" id="ID_PROFIL">
                          <option value="">---Sélectionner---</option>
                          <?php
                            foreach ($profils as $value)
                            {
                          ?>
                          <option value="<?=$value['ID_PROFIL']?>"><?=$value['STATUT']?></option>
                          <?php
                            }
                          ?>
                        </select>

                    <?php echo form_error('ID_PROFIL', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2" style="margin-top:30pX">
                      <input type="checkbox" name="checkAll" onchange="cocher_all()" id="checkAll">
                      <label>Cocher tout</label>
                    </div>
                    <!-- <div class="col-md-2" style="margin-top:30pX">
                       <button id="selections" onclick='subForm()' class='btn btn-primary btn-sm' disabled>
                        <span class="badge badge-danger" id="nombress">0</span>
                          Soumettre
                        </button>
                    </div> -->
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label>Les droits</label>
                      <div class="row">
                    
              <div class="col-md-6">
              
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="IHM" value="1" id="IHM">
                <label class="form-check-label" for="IHM">
                  IHM
                </label>
              </div>
             
              </div>

              </div>


                      
          </div>
          

      </div>
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

<?php include VIEWPATH.'templates/footer.php'; ?>


<script type="text/javascript">
  function send()
  {
    var test=$('#PERMIS').val();
    alert(test);
  }
   function cocher_all(){
     const firstInput = document.getElementsByName('checkAll');
     var i = 0;
            if (firstInput[0].checked) {
                $("input[type=checkbox]").each(function() {
               this.checked = true; 
                   if (this.value > 0) {
                      i++
                      console.log(this.value)
                   }
                                      
            });
            }else{
               $(':checkbox').each(function() {
               this.checked = false;                       
            });
          }
       if(i>0){
          $('#selections').prop('disabled',false)
        }
        else{
          $('#selections').prop('disabled',true)
        }
        $('#nombress').html(i)


 }
 function subForm()
 {
    Swal.fire({
      title: 'Souhaitez-vous consulter l\'avis du  partenaire pour le traitement de ce constat?',
      showDenyButton: true,
      // showCancelButton: true,
      confirmButtonText: 'oui',
      denyButtonText: `Non`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $('#myForm').submit()
        Swal.fire('Confirmé!', '', 'success')
      } else if (result.isDenied) {
        Swal.fire('Non Confirmé', '', 'info')
      }
    })
    
 }
</script>














