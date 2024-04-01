ph<!DOCTYPE html>
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
    <a href="<?=base_url('ihm/Grade/index')?>" class='btn btn-primary float-right'>
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

<form  name="myform" method="post" class="form-horizontal" action="<?= base_url('ihm/Grade/add'); ?>" >
              
                

               <div class="row">

                  <div class="col-md-6">

                    <label for="FName" id="Titre_langue">Type controle</label>
                    
                    <input type="text" name="description" autocomplete="off" id="description"   class="form-control">
                    
    
                  </div>
                                    
      
                  <div class="col-md-2" style="margin-top:31px;">
                    <button type="button" style="float: right;" class="btn btn-primary" onclick="saveLangue()"><span class="fas fa-save"></span>Ajouter autre langue</button>
                  </div>
                </div> 

                 <br>

                 <table class="table table-striped table-hover table-condensed small-top-margin" id="MyTable">
                            <thead>
    
                            </thead>
                            <tbody id="MyTable_Body"></tbody>
                        </table>

              
                 <button type="button"class="btn btn-warning" onclick="Enregistrer()"><span class="fas fa-save"></span> Enregistrer</button></button>          
                </div>
                </div>

                        <!-- <div class="row">
                          
                        </div> -->
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
      
      function  saveLangue() {
        
        var text = $('#description').val()

        if (text != "") {
           save_repose_autre()
        }else{
           $('#description').focus();
        }


          
      }


 function Enregistrer(){

  if(sessionStorage.length == 4){

  var descp = '';
  var u = 0;
  var langue = "";

  var form =  new FormData();

  for (var i = 0; i < sessionStorage.length; i++) {

    var g = u++;

    if (g == 0) {
       form.append("FR",sessionStorage.getItem([i]))
    }

    if (g == 1) {
       form.append("ENG",sessionStorage.getItem([i]))
    }

    if (g == 2) {
       form.append("KIR",sessionStorage.getItem([i]))
    }

    if (g == 3) {
       form.append("KISW",sessionStorage.getItem([i]))
    }

  }

  
   $.ajax({
        url : "<?=base_url()?>ihm/Grade/saveForma",
        type : "POST",
        dataType: "JSON",
        cache:false,
        data: form,
        processData: false,  
        contentType: false, 
        beforeSend:function () { 
        }, 
        success:function(data) {
          sessionStorage.clear();
          alert(data);

        }

    }); 



  }
   

 }








 function verifier_save(){
      
      var newDonne = $('#description').val();
      var exist = 0;

      for (var i = 0; i < sessionStorage.length; i++) {
         if (sessionStorage.getItem([i]) == newDonne) {
         exist = 1;
         }
        
      }

      return Number(exist);
    
  }




    function delet_data_session(key){

      sessionStorage.removeItem(Number(key));
      controlLabel()
      document.getElementById('MyTable_Body').innerHTML = getSessionMemoir();

    }
   
   document.getElementById('Titre_langue').innerHTML = "type contre en (français)";

   function controlLabel(){
    document.getElementById('Titre_langue').innerHTML = "type contre en (français)";
    if (sessionStorage.length <= 0) {
      document.getElementById('Titre_langue').innerHTML = "type contre en (français)";
    }else if (sessionStorage.length <= 1){
      document.getElementById('Titre_langue').innerHTML = "type contre en (anglais)";
    }else if (sessionStorage.length <= 2){
      document.getElementById('Titre_langue').innerHTML = "type contre en (kirundi)";
    }else if (sessionStorage.length <= 3){
      document.getElementById('Titre_langue').innerHTML = "type contre en (swahili)";
    }

   }



  function save_repose_autre(){
    
    var AUTRE_DESCRIPTION =  $('#description').val();

      const check = verifier_save();
      /*alert(check);*/
      if (check !=1) {
        var j =  Number(myMaxkey());
        if (j==99) {
          sessionStorage.setItem(0, $('#description').val());
        }else{
          var op = 1;
          var key = Number(j);
          sessionStorage.setItem(key, $('#description').val());
        //alert(myMaxkey());
        }

      }else{
        console.log('exist déjà !');
      }
    /*alert(sessionStorage.getItem(myMaxkey()));*/
    document.getElementById('MyTable_Body').innerHTML = getSessionMemoir();
    
  }



    function myMaxkey_PouxActiv(){
        var maxKey = 0;
        let n = 0;
        while (n < sessionStorage.length) {
        maxKey = n++;
        }

        /*alert(maxKey);*/
        return maxKey;

    }



    function myMaxkey(){
        var maxKey = 0;
        for (var i = 0; i < sessionStorage.length; i++) {
        maxKey = i;
        /*alert(sessionStorage.getItem([i]));*/
        }

        if (sessionStorage.length < 1) {
           return 99;
        }else{
          return i;
        }
        
    }


    function getLangueAutre(id = 0){

      var langueSigle = "";
      
      if (id == 1) {
         var langueSigle = "français";
      }
      if (id == 2){
         var langueSigle = "anglais";
      }

      if (id == 3){
         var langueSigle = "kirundi";
      }

      if (id == 4){
        var langueSigle = "swahili";
      }

      return langueSigle;
    }




    function getSessionMemoir(){
        let medonne = '';
        let u = 1;
     
        for (var i = 0; i < sessionStorage.length; i++) {
        maxKey = i;
        var g = u++;
       

        if (i == myMaxkey_PouxActiv()) {
            medonne += '<tr><td>'+getLangueAutre(g)+'</td><td>'+sessionStorage.getItem([i])+'</td><td><button type="button" onclick="delet_data_session('+i+')" class="btn btn-danger btn-sm" id="saveBtn">🚫</button></td></tr>';
        }else{
            medonne += '<tr><td>'+getLangueAutre(g)+'</td><td>'+sessionStorage.getItem([i])+'</td><td><button type="button"  class="btn btn-default btn-sm" id="saveBtn" disabled>🚫</button></td></tr>';
        }

       
        }

        // alert(myMaxkey_PouxActiv());
        return medonne;
    }









    function saveDonne(){

      var FR = $('#FR').val()
      var ENG = $('#ENG').val()
      var KIR = $('#KIR').val()
      var KISW = $('#KISW').val()

      var form =  new FormData();

      form.append("FR",FR)
      form.append("ENG",ENG)
      form.append("KIR",KIR)
      form.append("KISW",sKISW)
      $.ajax({
        url : "<?=base_url()?>ihm/Grade/saveForma",
        type : "POST",
        dataType: "JSON",
        cache:false,
        data: form,
        processData: false,  
        contentType: false, 
        beforeSend:function () { 
        }, 
        success:function(data) {
          
          alert(data);

        }

    }); 

    }

   

    </script>