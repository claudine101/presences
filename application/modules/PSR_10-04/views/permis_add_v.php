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
              <a href="<?= base_url('PSR/Chauffeur_permis/index') ?>" class='btn btn-primary float-right'>
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

                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('PSR/Chauffeur_permis/add'); ?>">

                  <div class="row">
                    <div class="col-md-6">
                      <label for="FName"> N° Permis</label>
                      <input type="text" name="NUMERO_PERMIS" autocomplete="off" id="NUMERO_PERMIS" value="<?= set_value('NUMERO_PERMIS') ?>" class="form-control">

                      <?php echo form_error('NUMERO_PERMIS', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName">Propriètaire</label>
                      <input type="text" name="NOM_PROPRIETAIRE" autocomplete="off" id="NOM_PROPRIETAIRE" value="<?= set_value('NOM_PROPRIETAIRE') ?>" class="form-control">

                      <?php echo form_error('NOM_PROPRIETAIRE', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Catégorie</label>
                      <input type="text" name="CATEGORIES" autocomplete="off" id="CATEGORIES" value="<?= set_value('CATEGORIES') ?>" class="form-control">

                      <?php echo form_error('CATEGORIES', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Date de naissance</label>
                      <input type="date" name="DATE_NAISSANCE" autocomplete="off" id="DATE_NAISSANCE" value="<?= set_value('DATE_NAISSANCE') ?>" class="form-control">

                      <?php echo form_error('DATE_NAISSANCE', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="col-md-6">
                      <label for="FName"> Date de Livraison</label>
                      <input type="date" name="DATE_DELIVER" autocomplete="off" id="DATE_DELIVER" value="<?= set_value('DATE_DELIVER') ?>" class="form-control">

                      <?php echo form_error('DATE_DELIVER', '<div class="text-danger">', '</div>'); ?>
                    </div>
                    <div class="col-md-6">
                      <label for="FName"> Date d'éxpiration</label>
                      <input type="date" name="DATE_EXPIRATION" autocomplete="off" id="DATE_EXPIRATION" value="<?= set_value('DATE_EXPIRATION') ?>" class="form-control">

                      <?php echo form_error('DATE_EXPIRATION', '<div class="text-danger">', '</div>'); ?>
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

<?php include VIEWPATH . 'templates/footer.php'; ?>

<script>
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

<!-- <script type="text/javascript">
  function dobcheck() {
    var birth = document.getElementById('DATE_NAISSANCE')
    if (birth != "") {

      var record = document.getElementById('DATE_NAISSANCE').value.trim();
      var currentdate = new Date();
      var day1 = currentdate3.getDate();
      var month1 = currentdate3.getMonth();
      month1++;
      var year11 = currentdate3.getFullYear() - 17;
      var year2 = currentdate3.getFullYear() - 100;
      var record_day1 = record.split("/");
      var sum = record_day1[1] + '/' + record_day1[0] + '/' + record_day1[2];
      var current = month1 + '/' + day1 + '/' + year11;
      var current1 = month1 + '/' + day1 + '/' + year2;
      var d1 = new Date(current)
      var d2 = new Date(current1)
      var record1 = new Date(sum);
      if (record1 > d1) {

        alert("Sorry ! Minors need parential guidance to use this website");
        document.getElementById('DATE_NAISSANCE').blur();
        document.getElementById('DATE_NAISSANCE').value = "";
        document.getElementById('DATE_NAISSANCE').focus();
        return false;
      }
    }
  }
</script> -->