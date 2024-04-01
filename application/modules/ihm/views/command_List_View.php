<!DOCTYPE html>
<html lang="en">
<?php include VIEWPATH.'templates/header.php'; ?>



<style type="text/css">

/*body{
    background:#eee;    
}*/
.chat-list {
    padding: 0;
    font-size: .8rem;
}

.chat-list li {
    margin-bottom: 10px;
    overflow: auto;
    color: #ffffff;
}

.chat-list .chat-img {
    float: left;
    width: 48px;
}

.chat-list .chat-img img {
    -webkit-border-radius: 50px;
    -moz-border-radius: 50px;
    border-radius: 50px;
    width: 100%;
}

.chat-list .chat-message {
    -webkit-border-radius: 50px;
    -moz-border-radius: 50px;
    border-radius: 50px;
    background: #5a99ee;
    display: inline-block;
    padding: 10px 20px;
    position: relative;
}

.chat-list .chat-message:before {
    content: "";
    position: absolute;
    top: 15px;
    width: 0;
    height: 0;
}

.chat-list .chat-message h5 {
    margin: 0 0 5px 0;
    font-weight: 600;
    line-height: 100%;
    font-size: .9rem;
}

.chat-list .chat-message p {
    line-height: 18px;
    margin: 0;
    padding: 0;
}

.chat-list .chat-body {
    margin-left: 20px;
    float: left;
    width: 70%;
}

.chat-list .in .chat-message:before {
    left: -12px;
    border-bottom: 20px solid transparent;
    border-right: 20px solid #5a99ee;
}

.chat-list .out .chat-img {
    float: right;
}

.chat-list .out .chat-body {
    float: right;
    margin-right: 20px;
    text-align: right;
}

.chat-list .out .chat-message {
    background: #fc6d4c;
}

.chat-list .out .chat-message:before {
    right: -12px;
    border-bottom: 20px solid transparent;
    border-left: 20px solid #fc6d4c;
}

.card .card-header:first-child {
    -webkit-border-radius: 0.3rem 0.3rem 0 0;
    -moz-border-radius: 0.3rem 0.3rem 0 0;
    border-radius: 0.3rem 0.3rem 0 0;
}
.card .card-header {
    background: #17202b;
    border: 0;
    font-size: 1rem;
    padding: .65rem 1rem;
    position: relative;
    font-weight: 600;
    color: #ffffff;
}

.content{
    margin-top:40px;    
}
</style>
<body class="hold-transition sidebar-mini layout-fixed">
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
             <h4 class="m-0"><?=$title?></h4>
           </div><!-- /.col -->

           
           <div class="col-sm-4 text-right">


            <span style="margin-right: 15px">
              <div class="row">
              <div class="col-sm-6" style="float:right;">
              </div>

                
                <div class="col-sm-6" style="float:right;">
                  <a href="<?=base_url('ihm/Menu/ajouter')?>" style="width: 100px;" class='btn btn-primary btn-sm float-right'>
                    <i class="nav-icon fas fa-plus"></i>
                    Menu
                  </a>
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
            <div class="row">

            <?php if ($this->session->userdata('PROFIL_ID') == 1) { ?>
               
            <div class="col-md-3">
              <label>Vendeur</label><br>
              
              <select class="form-control input-sm" name="ID_RESTAURANT" id="ID_RESTAURANT" onchange="liste()">    
                      <option value="">-----Sélectionner----</option>
                      <?php 
                      foreach ($mes_resto as $key_menu) 
                      {
                        if ($key_menu['ID_RESTAURANT'] == $this->session->userdata('ID_RESTAURANT')){?>
                            <option value="<?= $key_menu['ID_RESTAURANT'] ?>" selected><?= $key_menu['NOM_RESTAURANT'] ?></option>
                          <?php } else {?>
                            <option value="<?= $key_menu['ID_RESTAURANT'] ?>"><?=$key_menu['NOM_RESTAURANT'] ?></option>
                            <?php 
                          }
                        }

                        ?>

                      </select>
            </div>

            <?php } ?>

            <div class="col-md-3">
              <label>Statut</label><br>

              <select class="form-control input-sm" name="ID_STATUS_COMMANDE" id="ID_STATUS_COMMANDE" onchange='liste()'> 
                <option value="">Sélectionner</option>
                <?php foreach ($commande_status as $key) { ?>
                <option value="<?php echo $key['ID_STATUS_COMMANDE']?>"><?php echo $key['DESCRIPTION']?></option>
                <?php } ?>
              </select>

            </div>
            </div>
             
                <br>
                <?=  $this->session->flashdata('message');?>
                <div class="table-responsive">
                  <table id='reponse1' class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
                    <thead>
                      <tr>
                        
                        <th>Client</th>
                        <th>Commande</th>
                        <th>Contacts</th>
                        
                        <th>Adresse</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>PT HTV (BIF)</th>
                        <th data-orderable="false">Options</th>
                        
                      </tr>
                    </thead>
                  </table>
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

<!-- ./wrapper -->
<?php include VIEWPATH.'templates/footer.php'; ?>
</body>
</html>

<!-- MODAL POUR LE chatte avec le client -->



<div class="modal fade" id="chat_modal"  data-backdrop="static" tabindex="-1" aria-labelledby="modalMissionLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
    
      <div class="modal-body">

      <div class="container content">
      <div class="row">


        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">

          <div class="card-header">Message  <span class="modal-title btn" data-dismiss="modal" aria-label="Close" style="float: right;color: #fff">X</span>
          </div>

            <div class="card-body height3" >

              <ul class="chat-list" id="chat_listes">
              </ul>

              <textarea class="form-control" name="CONTENU" id="CONTENU" placeholder="Message..."></textarea>
              <span style="float: right;">
              <button type="botton" class="btn btn-info"  onclick="save_messag_send()" style="position: relative;float:left;margin-top:-39px;"><i class="fas fa-paper-plane"></i></i></button>
              </span>
            </div>
          </div>
        </div>



    </div>
</div>




      </div>
    </div>
  </div>
</div>
</div>


<!-- ######< modal pour l'importation du fichier excel  >####### -->


<!-- #####<! modal pour l'importation du fichier excel  >####### -->




<script type="text/javascript">



function save_messag_send(){


  if ($('#CONTENU').val() == "") {
     $('#CONTENU').focus()
     $('#CONTENU').css('border-color','red')
  }else if ($('#ID_COMMANDE_NEW').val() == "") {
     alert('Aucune commande trouvée !!!');
  }else{
     var ID_COMMANDE = $('#ID_COMMANDE_NEW').val()
     var CONTENU = $('#CONTENU').val()

    $.ajax({
        url : "<?=base_url()?>ihm/Chatting/save_messag_send/",
        type : "POST",
        dataType: "JSON",
        data : {ID_COMMANDE : ID_COMMANDE,
                CONTENU : CONTENU},
        beforeSend:function () { 
              $('#chat_listes').html('<span id="error_message"><br><center><font color="#dee2e6" style="font-size:10px;margin-top:100px;margin-bottom:20px"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></font></center></span>');
              // getMessagePat($('#PARTENAIRE_ID_FITRE').val());
        },
        error:function() {
              $('#chat_listes').html('<div class="alert alert-danger" id="error_message">Erreur : Impossible d\'afficher les messages! </div>');
        }, 
        success:function(data) {
          $('#CONTENU').css('border-color','#dee2e6')
          $('#chat_listes').html(data.doones);
         
          $('#CONTENU').val("")
        }  
    });

  }


}


function get_message(id_comm = 0){

  $('#chat_modal').modal()

   $.ajax({
        url : "<?=base_url()?>ihm/Chatting/chattes/"+id_comm,
        type : "POST",
        dataType: "JSON",
        beforeSend:function () { 
              $('#chat_listes').html('<span id="error_message"><br><center><font color="#dee2e6" style="font-size:10px;margin-top:100px;margin-bottom:20px"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></font></center></span>');
              // getMessagePat($('#PARTENAIRE_ID_FITRE').val());
        },
        error:function() {
              $('#chat_listes').html('<div class="alert alert-danger" id="error_message">Erreur : Impossible d\'afficher les messages! </div>');
        }, 
        success:function(data) {
         $('#chat_listes').html(data.doones);
        }  
    });


}






function get_driver(id, id_comm){

  //alert(id+' '+id_comm)

  let donne_driver = `<?=$select_libr?>`;

  if (id == 3) {
     $('#div_driver'+id_comm+'').html(donne_driver);
  }else{
     $('#div_driver'+id_comm+'').html('');
  }

 
}

 function save_donnes(id){

  if (id == 3) {
 
 alert(id);
 
  if($('#ID_LIVREUR').val() == "") {
     $('#ID_LIVREUR').focus()
  }else if($('#NUMERO_COURSE_WASILI').val() == "") {
     $('#NUMERO_COURSE_WASILI').focus()
  }else{
    $('#myForm'+id).submit()
  }

 }else{

   $('#myForm'+id).submit()

 }

    
 }



 $(document).ready(function(){
  liste();
  
});
</script>
<script type="text/javascript">
  function liste() 
  {  
    var ID_RESTAURANT=$('#ID_RESTAURANT').val()
    $('#message').delay('slow').fadeOut(3000);

    $("#reponse1").DataTable({
      "destroy" : true,
      "processing":true,
      "serverSide":true,
      "oreder":[],
      "ajax":{
        url: "<?php echo base_url('ihm/visualisation_commandes/listing/');?>", 
        type:"POST",
        data : { ID_RESTAURANT_UNE: $('#ID_RESTAURANT').val(),
                 ID_STATUS_COMMANDE : $('#ID_STATUS_COMMANDE').val(),
                 ID_RESTAURANT : $('#ID_RESTAURANT_NEW').val()
               },
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
  function get_hist(title,id) { 
    $('#title1').html(title);
    var row_count=1000000; 
    var link='<?= base_url(); ?>ihm/Visualisation_Commandes/detail/'+id;

    var table = $('#detai-INFO').DataTable({ 
     'ajax': {
       'url': link
     }, 
     "destroy" : true, 
     'columnDefs': [{
       'stateSave': true,
       'bDestroy': true,
       'processing':true,
       'serverSide':true,
       'searchable': false,
       'orderable': false,
       'className': 'dt-body-center', 
       

     }],

     dom: 'Bfrtlip',
     lengthMenu: [[10,50, 100, row_count], [10,50, 100, "All"]],
     exportOptions: { columns: [ 0, 1, 2, 3, 4]  },
     pageLength: 10,
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
    },
    'order': [[1, 'asc']]
  });

    
  }
</script>

