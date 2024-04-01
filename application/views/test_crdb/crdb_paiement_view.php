<!DOCTYPE HTML>

<html>

<head>
          <title>Virtual Payment Client Example</title>
         <?php include VIEWPATH.'templates/header.php'; ?>
        


        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>



            <form  id="form1" action="<?= base_url('Crdb_paiement/submitPayment') ?>" method="post" accept-charset="UTF-8" >

                <table width="80%" align="center" border="0" cellpadding='0' cellspacing='0'>
                    <tr>
                        <td>

                            <input type="hidden" id="vpc_resquest_id" name="vpc_resquest_id" value="243">
                             <!-- get user input -->
                            <input type="hidden" name="Title" value="Visa d'entre au burundi">
                            <!-- Virtual Payment Client URL:&nbsp;-->
                            <input type="hidden" name="virtualPaymentClientURL" size="65" value="https://migs-mtf.mastercard.com.au/vpcpay" maxlength="250" />
                            <!-- Basic 3-Party Transaction Fields -->
                            <input type="hidden" name="vpc_Version" value="1" size="20" maxlength="8" />
                            <!-- Command Type -->
                            <input type="hidden" name="vpc_Command" value="pay" size="20" maxlength="16" />
                            <!-- Merchant AccessCode -->
                            <input type="hidden" name="vpc_AccessCode" value="49F34C3D" size="20" maxlength="8" />
                            <label>Merchant Transaction Reference:</label>
                            <input type="hidden" id="vpc_MerchTxnRef" id="vpc_MerchTxnRef" name="vpc_MerchTxnRef" value="<?=$this->notifications->generate_UIID(20)?>" /></td>
                            <!-- MerchantID: -->
                            <input type="hidden" name="vpc_Merchant" value="CARDCENTRE01" size="20" maxlength="16" />
                            <!-- Transaction OrderInfo: -->
                            <input type="hidden" name="vpc_OrderInfo" value="ORDER958743" size="20" maxlength="34" /></td>
                            <label>Purchase Amount:</label>
                            <input type="number" id="vpc_Amount" name="vpc_Amount" value="1" maxlength="10" />
                            <!-- Receipt ReturnURL: -->
                            <input type="hidden" name="vpc_ReturnURL" size="65" value="<?=base_url('Crdb_paiement/calback_test')?>" maxlength="250" />
                            <!-- Payment Server Display Language Locale: -->
                            <input type="text" id="vpc_Locale" name="vpc_Locale" value="fr_FR" maxlength="10" />
                            <label>Currency: </label>
                            <input type="text" id="vpc_Currency" name="vpc_Currency" value="USD" maxlength="10" readonly />

                            <button type="button" NAME="SubButL" onclick="send_form()" class="btn btn-success btn-sm">Pay Now!</button>
                                        
                        </td>
                    </tr>

                </table>

            </form>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Paiement <span id="heure_exacte"></span> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="donness">
                   
                  </div>
                </div>
              </div>
            </div>
</body>

<head>
        
</head>




</html>

<script>


    function send_form(){
        

        var allInputs = $('form[id=form1]').find(':input') 
        var formChildren = $( "form > *" );

        var formDatas = { };

           for (var i = 0; i < allInputs.length; i++) {

            formDatas[allInputs[i].name] = allInputs[i].value
           }

            // console.log(formDatas)

            $.ajax({
                  url : "<?= base_url('Crdb_paiement/submitPayment') ?>",
                  type : "POST",
                  dataType: "JSON",
                  data : formDatas,
                  cache:false,
                  success:function(data) {

                    $('#exampleModal').modal()
                    $('#donness').html(data.urls)

                     setInterval(function() {
                        
                        $.ajax({
                              url : "<?= base_url('Crdb_paiement/check_confirm/') ?>"+$('#vpc_MerchTxnRef').val(),
                              type : "GET",
                              dataType: "JSON",
                              cache:false,
                              success:function(data) {
                                    console.log(data);
                                    if (data == 555) {
                                      window.location.assign(window.location.href)
                                    }
                              }

                          });

                      },1000);
 
                  },
                  error:function(data) {
                    alert_erro("Message non envoyer problème soit de connexion")
                  }
            });

         


     }

       function alert_erro(message = ""){

         Swal.fire({
                   icon: 'error',
                   title: message,
                   text: 'Veillez réessayer plus tard merci!',
                   //footer: '<a href="<?=base_url()?>?</a>'
                 })
        }


 

</script>

<?php include VIEWPATH.'templates/footer.php'; ?>