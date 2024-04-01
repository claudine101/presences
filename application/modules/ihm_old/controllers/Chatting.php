<?php

/*Alhonse*/

defined('BASEPATH') OR exit('No direct script access allowed');

  class Chatting extends CI_Controller {

 
    function chattes($ID_COMMANDE= 0){

    	$donn = $this->Modele->getRequeteOne("SELECT rs.ID_RESTAURANT,rs.NOM_RESTAURANT,rs.IMAGE,cl.NOM,c.DATE_COMMANDE FROM commande_details d LEFT JOIN menu_restaurants r on r.ID_MENU_RESTAURANT=d.ID_MENU_RESTO JOIN restaurants rs ON rs.ID_RESTAURANT=r.ID_RESTAURANT JOIN commandes c on c.ID_COMMANDE=d.ID_COMMANDE JOIN clients cl on c.ID_CLIENT=cl.ID_CLIENT WHERE c.ID_COMMANDE=  ".$ID_COMMANDE);

    	$messages_chat = $this->Modele->getRequete('SELECT `DATE_MESSAGE`,`ID_RESTO`,`CONTENU` FROM `commande_messages` WHERE `ID_COMMANDE`='.$ID_COMMANDE.' ORDER BY `ID_COMMANDE_MESSAGE` ASC');

    	$message = '';

    	foreach ($messages_chat as $key => $value) {

    	$date = date('H:i', strtotime($value['DATE_MESSAGE']));

    	if (!empty($value['ID_RESTO'])) {
    	
    	$message .=' <li class="out">
                  <div class="chat-img">
                    <img alt="Avtar" src="'.$donn['IMAGE'].'" >
                  </div>
                  <div class="chat-body">
                    <div class="chat-message">
                      <h5>🕘'.$date.'  <B>'.ucfirst($donn['NOM_RESTAURANT']).'</B></h5> 
                      <p>'.ucfirst($value['CONTENU']).'</p>
                    </div>
                  </div>
                </li>';
        }else{ 

        $message .=' <li class="in">
                  <div class="chat-img">
                    <img alt="Avtar" src="'.base_url('uploads/personne.png').'">
                  </div>
                  <div class="chat-body">
                    <div class="chat-message">
                      <h5><B>'.ucfirst($donn['NOM']).' </B>  '.$date.'🕘</h5>
                      <p>'.ucfirst($value['CONTENU']).'</p><br>
                    </div>
                  </div>
                </li>';
        }  

    	}


        $message .='<input type="hidden" id="ID_COMMANDE_NEW" name="ID_COMMANDE_NEW" value="'.$ID_COMMANDE.'">';
        $message .='<input type="hidden" id="ID_RESTAURANT_NEW" name="ID_RESTAURANT_NEW" value="'.$donn['ID_RESTAURANT'].'">';


        $daonne = array('doones'=>$message, 'titre'=>ucfirst($donn['NOM_RESTAURANT']).' '.ucfirst($donn['NOM']));
    	echo json_encode($daonne);



    }


    function save_messag_send(){
       
       $ID_COMMANDE = $this->input->post('ID_COMMANDE');
       $CONTENU = $this->input->post('CONTENU');
       $ID_RESTO = $this->session->userdata('ID_RESTAURANT');

       // $data_arry = array('ID_COMMANDE'=>$ID_COMMANDE, 'CONTENU'=>$CONTENU, 'ID_RESTO'=>$ID_RESTO);

       // $this->Modele->create('commande_messages',$data_arry);

       $data =  array('ID_RESTO'=>$ID_RESTO, 'CONTENU'=>$CONTENU, 'ID_STATUS_COMMANDE'=>1);


        $url = 'http://app.mediabox.bi:1780/messages/'.$ID_COMMANDE;
          if(is_array($data)){ $data = json_encode($data);}
          $options = stream_context_create(['http' => [
          'method'  => 'POST',
          'header'  => 'Content-type: application/json',
          'content' => $data
          ]]);
          $response = file_get_contents($url,false,$options);

          $this->chattes($ID_COMMANDE);

    }



    




}



