<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php'; ?>


<script src='https://api.mapbox.com/mapbox.js/v3.2.0/mapbox.js'></script>
<link href='https://api.mapbox.com/mapbox.js/v3.2.0/mapbox.css' rel='stylesheet' />
 <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/leaflet.markercluster.js'></script>
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.css' rel='stylesheet' />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.Default.css' rel='stylesheet' />
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' /> 


<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-zoomslider/v0.7.0/L.Control.Zoomslider.js'></script>
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-zoomslider/v0.7.0/L.Control.Zoomslider.css' rel='stylesheet'/>



<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>


<style>
/* Adjustments to account for mapbox.css box-sizing rules */
.leaflet-control-zoomslider-knob { width:7px; height:2px; }
.leaflet-container .leaflet-control-zoomslider-body {
  -webkit-box-sizing:content-box;
     -moz-box-sizing:content-box;
          box-sizing:content-box;
  }
</style>


<style type="text/css">
  .card{
  border-width: 0px;
  font-size: 14px;
  margin: 0px;
  padding: 0px;
}



.card-header{
  margin-top: -11px;
  margin-left: -11px;
  margin-right: -11px;
  text-align: center;
  background-color: black;
  color: white;
}
.card-footer{
  margin-bottom: -12px;
  margin-left: -11px;
  margin-right: -11px;
  padding-right: -8px
  padding-left: -8px
}

.card-body{
  margin-left: -13px;
  margin-right: -13px;
  margin-bottom: -13px;
}
.ui-coordinates {
  background:rgba(0,0,0,0.5);
  position:absolute;
  top:280px;right:15px;
  z-index:1;
  bottom:10px;
  right:20px;
  padding:5px 10px;
  color:#fff;
  font-size:12px;
  border-radius:3px;
  max-height:220px;
 
  width:250px;
  }
</style>
<style>
.legend label,
.legend span {
  display:block;
  float:left;
  height:15px;
  width:20%;
  text-align:center;
  font-size:9px;
  color:#808080;
  }
</style>

<style type="text/css">
   .mapbox-improve-map{
    display: none;
  }
  
      .leaflet-control-attribution{
    display: none !important;
}
.leaflet-control-attribution{
    display: none !important;
}


.mapbox-logo {
  display: none;
}

 .animated-icon{
  width: 25px;
  height: 25px;
  background-color: rgba(255,255,255,0.5);
  border-radius: 50%;
  box-shadow: 0px 0px 20px red;
  transition: all 1s;
}


#donnIdentite {
  
  position: relative;
  width: auto;
  margin: .5rem;
  max-height: 80%;
  overflow-x: hidden;
  overflow-y: auto;
  /*pointer-events: none;*/


}


#divIdentite{
  top: 5%;
  width: 500px;
  max-height: 90%;
  overflow-x: hidden;
  overflow-y: auto;
  background: #fff;
  position: fixed;
  z-index: 1060;
  right: 20%;
  left: 18.3%;
  visibility: hidden;
}
</style>
<style>
  
  .css-icon {

  }

  .gps_ring { 
    border: 7px solid green;
     -webkit-border-radius: 30px;
     height: 48px;
     width: 48px;   
     margin-left: -10px;
     margin-top: -15px;
      -webkit-animation: pulsate 1s ease-out;
      -webkit-animation-iteration-count: infinite; 
      /*opacity: 0.0*/
  }


  .gps_ringNew { 
    border: 7px solid #F30707;
     -webkit-border-radius: 30px;
     height: 48px;
     width: 48px;   
     margin-left: -10px;
     margin-top: -15px;
      -webkit-animation: pulsate 1s ease-out;
      -webkit-animation-iteration-count: infinite; 
      /*opacity: 0.0*/
  }

  .gps_ringOld { 
    border: 7px solid #000;
     -webkit-border-radius: 30px;
     height: 20px;
     width: 20px;   
     margin-left: 0px;
     margin-top: 0px;
      -webkit-animation: pulsate 1s ease-out;
      -webkit-animation-iteration-count: infinite; 
      /*opacity: 0.0*/
  }
  
  @-webkit-keyframes pulsate {
        0% {-webkit-transform: scale(0.1, 0.1); opacity: 0.0;}
        50% {opacity: 1.0;}
        100% {-webkit-transform: scale(1.2, 1.2); opacity: 0.0;}
  }
  </style>

 
<style>
/* Adjustments to account for mapbox.css box-sizing rules */
.leaflet-control-zoomslider-knob { width:7px; height:2px; }
.leaflet-container .leaflet-control-zoomslider-body {
  -webkit-box-sizing:content-box;
     -moz-box-sizing:content-box;
          box-sizing:content-box;
  }
</style>


<style type="text/css">
  .card{
  border-width: 0px;
  font-size: 14px;
  margin: 0px;
  padding: 0px;
}



.card-header{
  margin-top: -11px;
  margin-left: -11px;
  margin-right: -11px;
  text-align: center;
  background-color: black;
  color: white;
}
.card-footer{
  margin-bottom: -12px;
  margin-left: -11px;
  margin-right: -11px;
  padding-right: -8px
  padding-left: -8px
}

.card-body{
  margin-left: -13px;
  margin-right: -13px;
  margin-bottom: -13px;
}
.ui-coordinates {
  background:rgba(0,0,0,0.5);
  position:absolute;
  top:280px;right:15px;
  z-index:1;
  bottom:10px;
  right:20px;
  padding:5px 10px;
  color:#fff;
  font-size:12px;
  border-radius:3px;
  max-height:220px;
 
  width:250px;
  }
</style>
<style>
.legend label,
.legend span {
  display:block;
  float:left;
  height:15px;
  max-width:25%;
  text-align:center;
  font-size:9px;
  color:#808080;
  }
</style>

<style type="text/css">
   .mapbox-improve-map{
    display: none;
  }
  
      .leaflet-control-attribution{
    display: none !important;
}
.leaflet-control-attribution{
    display: none !important;
}


.mapbox-logo {
  display: none;
}

 .animated-icon{
  width: 25px;
  height: 25px;
  background-color: rgba(255,255,255,0.5);
  border-radius: 50%;
  box-shadow: 0px 0px 20px red;
  transition: all 1s;
}
</style>
<style>

  .profile-header {
    transform: translateY(5rem);
}
  
  .css-icon {

  }

  .gps_ring { 
    border: 7px solid #F30707;
     -webkit-border-radius: 30px;
     height: 20px;
     width: 20px;   
     margin-left: -10px;
     margin-top: -15px;
      -webkit-animation: pulsate 1s ease-out;
      -webkit-animation-iteration-count: infinite; 
      /*opacity: 0.0*/
  }
  
  @-webkit-keyframes pulsate {
        0% {-webkit-transform: scale(0.1, 0.1); opacity: 0.0;}
        50% {opacity: 1.0;}
        100% {-webkit-transform: scale(1.2, 1.2); opacity: 0.0;}
  }
  </style>

 
<body class="hold-transition sidebar-mini layout-fixed">


   <div>

               <div class="card w-80" id="divIdentite">
                  <div class="card-header">
                     <span>PSR <a style="float: right;color: #fff;font-size: 20px;" href="#" onclick="cashImage()"><i class="fa fa-times"></i></a></span> <br>
                  </div>
                  <div class="card-body" id="donnIdentite">
              
                  </div>
                </div>
              </div>


 <audio style="display: none;" id="xhhh"  controls src="<?=base_url('uploads/sons.mpga')?>"  >
            <code>audio</code>
</audio>
  <div class="wrapper">

    <!-- Navbar -->
    <?php include VIEWPATH.'templates/navbar.php'; ?>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include VIEWPATH.'templates/sidebar.php'; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-8">
             <h4 class="m-0">Signalement</h4>
           </div><!-- /.col -->

           
           <div class="col-sm-4 text-right">


            <span style="margin-right: 15px">
              <div class="row">
              <div class="col-sm-6" style="float:right;">
              </div>

              </div>
            </span>

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->


      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">

        <div class="col-md-12 col-xl-12 grid-margin stretch-card">

          <div class="card">
        
            <div class="card-body">
      

                <?= $this->session->flashdata('message');?>

                <div id="reload_page">
              <div class="row">
              <div class="col-md-12">
                <center>

                  <img height="50" src="<?php echo base_url() ?>upload/reload.gif">
               
                </center>
              </div>
            </div>


            </div>

             
           
          <div id="mapview">

         </div>

         

                
              </div>


              <!--  VOS CODE ICI  -->



            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>          
</div>


</section>


<!-- /.content -->
</div>

</div>
</div>







<!-- MODAL POUR LE DETAIL -->
<!-- <div class="modal fade" id="incident">
 <div class="modal-dialog modal-lg" >
   <div class="modal-content">
     <div class="modal-header">
      <div id="title"><H4>LISTE DES INCIDENTS</H4></div>
      <div class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </div>
   </div>
   <div class="modal-body" >
    
    <div class="col-md-12 table-responsive">
    <table id='reponse' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
      <thead>
        <tr>
          <td>Numero</td>
          <td>Description</td> 
          <td>Montant</td>
          <td>Statut</td>
          <td>Date</td>
         
        </tr>
      </thead>
    </table>
  </div>

  </div>
  <div class="modal-footer"> 
    <button id="btn_quiter" type="button" class="btn btn-primary" class='close' data-dismiss='modal'>Quitter</button>
  </div>
</div>
</div>
</div> -->
















<!-- ./wrapper -->
<?php include VIEWPATH.'templates/footer.php'; ?>
</body>
</html>



<script type="text/javascript">

  $(document).ready(function(){
    getMaps();
     
  
    // setInterval(function() {
    //     check_new();

    //   },1000);


    });

    function getMaps(ID=null){

      
      

    var PROVINCE_ID =$('#PROVINCE_ID').val();

    var ID =ID;
   
 

        $.ajax({
          url : "<?=base_url()?>geo/Signalement/get_carte/",
          type : "POST",
          dataType: "JSON",
          cache:false,
         
         data: {PROVINCE_ID:PROVINCE_ID,ID:ID},
          beforeSend:function () { 

            $('#reload_page').show();
            $('#mapview').hide();
          },
          success:function(data) {

            
            $('#mapview').show();
            var x = document.getElementById("myAudio"); 

            if (data.id==1) 
            {
              xhhh.play(); 
            }

            // alert(data.id)
           
           $('#mapview').html(data.cartes);
           // $("#d_table1").DataTable();
            $('#reload_page').hide();
          },
          error:function() {
            $('#carte_').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher la carte! Veuillez réessayer</div>');
          }
      });
    }

     


  </script>

  <script type="text/javascript">


  function getincident(id) { 

   $('#title').text('Liste des incidents');

   var PROVINCE_ID=$('#PROVINCE_ID').val();


   $('#incident').modal();
   
   $("#reponse").DataTable({
    "destroy" : true,
    "processing":true,
    "serverSide":true,
    "oreder":[],
    "ajax":{
      url: "<?php echo base_url('geo/Elements_Pnb/getincident/');?>"+id, 
      type:"POST",
      data : {PROVINCE_ID:PROVINCE_ID},
      beforeSend : function() {
      }
    },
    lengthMenu: [[10,50, 100, -1], [10,50, 100, "All"]],
    pageLength: 10,
    "columnDefs":[{
      "targets":[],
      "orderable":false
    }],
    dom: 'Bfrtlip',
    buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print'  ],
    language: {
      "sProcessing":     "Traitement en cours...",
      "sSearch":         "Rechercher&nbsp;:",
      "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
      "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      "sInfoPostFix":    "",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
      "oPaginate": {
        "sFirst":      "Premier",
        "sPrevious":   "Pr&eacute;c&eacute;dent",
        "sNext":       "Suivant",
        "sLast":       "Dernier"
      },
      "oAria": {
        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
      }
    }
  });


 }

</script>

<script type="text/javascript">
   function check_new() 
      {
        $.ajax({
          url : "<?=base_url()?>geo/Signalement/check_new",
          type : "GET",
          dataType: "JSON",
          cache:false,
          success:function(data) {
          
          var nbrAlert = $('#nbrAlert').val()


            if (data.nbr > Number(nbrAlert)) {
              $('#nbrAlert').val(data.nbr)
              getMaps();
              
            }
          }
        });
      }

</script>

    
   

<script>
    function submit_f(){
    
    myform.submit();
  }
  
</script>
   









<!-- MODAL POUR LE DETAIL -->
<div class="modal fade" id="detailVehicule">
 <div class="modal-dialog modal-lg" >
   <div class="modal-content">
     <div class="modal-header" style="background: #000;">
      <div id="title"><h5 id="titreModal" style="color:#fff"></h5></div>
      <div class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true" style="color:#fff;">&times;</span>
     </div>
   </div>
   <div class="modal-body" >
    
  <div class="col-md-12 table-responsive" id="donness">

   
  </div>

  </div>
  
</div>
</div>
</div>


<!-- 
infrationsData
IDsignalement
montantAmende
Imatriculation
TotaleSomme
CommentaireData
 -->

 <input type="hidden" name="nbrAlert" id="nbrAlert" value="<?=$nbr?>"> 


   <script type="text/javascript">

                $("#divIdentite").css("visibility", "hidden")

                function cashImage(){
                  $('#donnIdentite').html("");
                  $('#divIdentite').delay(100).hide('show')
                  $("#divIdentite").css("visibility", "hidden")
                }
                  function getDetailControl(src){
                  // alert(id)
                    $("#divIdentite").css("visibility", "visible")
                    $('#divIdentite').delay(100).show('hide')
                  
                  var img=src.split('@')
                  var imgsrc=""
                      for (var i = 0; i < img.length; i++) {
                       // alert(img[i]);
                       imgsrc+='<img   class="card-img-top" src="'+img[i]+'"><br>'
                     }

                  $('#donnIdentite').html(imgsrc);
                 
                  console.log(imgsrc)

                       /* $.ajax({
                          url : "<?=base_url()?>PSR/Historique/getIdentite/"+id,
                          type : "GET",
                          dataType: "JSON",
                          success:function(data) {
                           $('#donnIdentite').html(data.views_detail)
                         },
                         error:function() {

                          $('#divIdentite').html('<div class="alert alert-danger">Erreur : Impossible d\'afficher cette page! Veuillez réessayer</div>');
                             
                         $('#divIdentite').delay(100).hide('show')
                        }
                       });

                        //document.getElementById('imgesss').src = src

                       */

                }
              </script>

<script  type="text/javascript">


   

    function save_data(){
      var description = "";
      var somme = 0;
      $('input[name="donneIfra"]').each(function() {
            if($(this).is(":checked")){
                    /*alert(this.title);*/
                    description+= this.title+",";
                    somme +=  Number(this.value);

            }
      });
      
      $('#montantAmende').val(somme);
      $('#infrationsData').val(description);
      $('#TotaleSomme').html(somme.toLocaleString('fr'));

      return 1;
  }


  function saveDonne(){
    
   var donne =  save_data();

   if(donne == 1){

      var infrationsData = $('#infrationsData').val()
      var IDsignalement = $('#IDsignalement').val()
      var montantAmende = $('#montantAmende').val()
      var Imatriculation = $('#Imatriculation').val()
      var CommentaireData = $('#CommentaireData').val()

    
      var form = new FormData()

      form.append("infrationsData", infrationsData)
      form.append("IDsignalement", IDsignalement)
      form.append("montantAmende", montantAmende)
      form.append("Imatriculation", Imatriculation)
      form.append("CommentaireData", CommentaireData)

      var donne =  {infrationsData:infrationsData,
                   IDsignalement:IDsignalement,
                   montantAmende:montantAmende,
                   Imatriculation:Imatriculation,
                   CommentaireData:CommentaireData
                 }

       //alert(infrationsData+"\n"+IDsignalement+"\n"+montantAmende+"\n"+Imatriculation+"\n"+CommentaireData+"\n");


      console.log(JSON.stringify(donne))

      $.ajax({
          url : "<?=base_url()?>geo/Signalement/saveVerbalisation",
          type : "POST",
          dataType: "JSON",
          cache:false,
          data: donne,
          
          success:function(data) {
            //success()
            $('#detailVehicule').modal('hide');
            getMaps();
          
          }

      });


       }


  }






function number_format(num){

  var stringNum = num.toString();
  stringNum = stringNum.split("");
  c = 0;
  if (stringNum.length>3) {
    for (i=stringNum.length; i>-1; i--) {
      if ( (c==3) && ((stringNum.length-i)!=stringNum.length) ) {
        stringNum.splice(i, 0, " ");
        c=0;
      }
      c++
    }
    return stringNum;
  }
  return num;
}








  
  function get_detail_vehicule(id = 1){

     $('.mapIconVehicu').css('color','green')

     $('#detailVehicule').modal();

     $('#mapIconVehicu'+id).css('color','yellow')

     $.ajax({
          url : "<?=base_url()?>geo/Signalement/get_detail_vehicule/"+id,
          type : "GET",
          dataType: "JSON",
          cache:false,
          success:function(data) {
             
             $('#titreModal').html(data.titre);
             $('#donness').html(data.donne);

          }


        });
      
     

  }








function encours(){
  
              Swal.fire({
                 title: 'Traitement encours !',
                 html: 'Veillez patienter <b></b>  sécondes prés ...',
                 timer: 15000,
                 timerProgressBar: true,
                 didOpen: () => {
                   Swal.showLoading()
                   const b = Swal.getHtmlContainer().querySelector('b')
                   timerInterval = setInterval(() => {
                     b.textContent = Swal.getTimerLeft()
                   }, 100)
                 },
                 willClose: () => {
                   clearInterval(timerInterval)
                 }
               }).then((result) => {
               /* Read more about handling dismissals below */
                 if (result.dismiss === Swal.DismissReason.timer) {
                  console.log('I was closed by the timer')
                 }
               })

} 


function success(message=""){
         
         Swal.fire("Verbalisation effectuée avec succès !", 'L\'amende sera payer via banque ou mobileMony', "success");

} 

function erreur(message =""){

          Swal.fire({
                icon: 'error',
                title: 'Erreur...',
                text: message,
                   //footer: '<a href="<?=base_url()?>?</a>'
              })
}
  
</script>