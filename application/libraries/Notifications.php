<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notifications
{
	protected $CI;

	public function __construct()
	{
	    $this->CI = & get_instance();
      $this->CI->load->library('email');
      $this->CI->load->model('Modele');
	}
public function notificationApk($data=array())
    {

        $url = 'http://app.mediabox.bi:2522/signalements/send_one_notification';
        if(is_array($data)){ $data = json_encode($data);}
        $options = stream_context_create(['http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => $data
        ]]);

        // print_r(json_encode($data));

        $response = file_get_contents($url,false,$options);
        return $response;

        /*{
           "TITRE":"BPS ET PMS et psr",
           "CONTENU":"Point dans 10 min pas le chef",
           "tokens":["ExponentPushToken[5pghF_HFswEKb3aUxMLPHd]"]
        }*/
        
    }


    public function send_sms_econet($data=array())
    {

        $url = 'http://app.mediabox.bi:1124/sms';
        if(is_array($data)){ $data = json_encode($data);}
        $options = stream_context_create(['http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => $data
        ]]);

        // print_r(json_encode($data));

        $response = file_get_contents($url,false,$options);
        return $response;

        /*{
           "TITRE":"BPS ET PMS et psr",
           "CONTENU":"Point dans 10 min pas le chef",
           "tokens":["ExponentPushToken[
           5pghF_HFswEKb3aUxMLPHd]"]
        }*/
        
    }
function getToken(){

        $data = array('email'=> 'ndayisabaclaudine@hotmail.com', 'password'=> '61236061');
      // $data = array('email'=> 'alphonse@mediabox.bi', 'password'=> '61395170');
        $header [] = 'Content-Type:application/json';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://app.mediabox.bi:2522/users/login');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($curl);
    
        return $result;
    }



    function control_rapid($data = array()){

        $header = array();

        $token = json_decode($this->getToken());
     
        $header [0] = 'authorization:bearer '.$token->TOKEN.'';
       
        $header [1] = 'Content-Type:application/json';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'http://app.mediabox.bi:2522/plaques/check_plaques');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($curl);
      
        return $result;

    }

    function control_permis($data = array()){

        $header = array();

        $token = json_decode($this->getToken());
     
        $header [0] = 'authorization:bearer '.$token->TOKEN.'';
       
        $header [1] = 'Content-Type:application/json';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'http://app.mediabox.bi:2522/permis/control_permis');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($curl);
      
        return $result;

    }
   function getMois($key){

            $moisli = array();
            $moisli[0] = "";
            $moisli[1] = "janvier";
            $moisli[2] = "février";
            $moisli[3] = "mars";
            $moisli[4] = "avril";
            $moisli[5] = "mai";
            $moisli[6] = "juin";
            $moisli[7] = "juillet";
            $moisli[8] = "août";
            $moisli[9] = "septembre";
            $moisli[10] = "octobre";
            $moisli[11] = "novembre";
            $moisli[12] = "décembre";

            return $moisli[$key];


    }



    public function send_sms_smpp($string_tel = NULL, $string_msg)
    {
        $data = '{"phone":' . $string_tel . ',"txt_message":"' . $this->remplace_lettre($string_msg) . '"}';

        $header = array();
        $header[1] = 'Content-Type:application/json';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://app.mediabox.bi:3367/sms');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($curl);
        // $result = json_decode($result);

        return $result;
    }



     function remplace_lettre($message = "")
  {

      $message = str_replace('é', 'e', $message);
      $message = str_replace('è', 'e', $message);
      $message = str_replace('ê', 'e', $message);
      $message = str_replace('â', 'a', $message);
      $message = str_replace('û', 'u', $message);

      $message = str_replace('ô', 'o', $message);
      $message = str_replace('ù', 'u', $message);
      $message = str_replace('ç', 'c', $message);
      $message = str_replace('à', 'a', $message);
     
      $message = trim(str_replace("'"," ", $message));
      $message = str_replace("\n", "", $message);
      $message = str_replace("\r", "", $message);
      $message = str_replace("\t", "", $message);


    return  $message;
  }


  function send_mail($emailTo = array(), $subjet, $cc_emails = array(), $message, $attach = array())
 {


        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://mamba.afriregister.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = 'alexis@mediabox.bi';
        $config['smtp_pass'] = 'Badia@79839653';
        $config['mailtype'] = 'html';
        $config['charset'] = 'UTF-8';
        $config['wordwrap'] = TRUE;
        $config['smtp_timeout'] = 20;
        $config['newline'] = "\r\n";
        $this->CI->email->initialize($config);
        $this->CI->email->set_mailtype("html");

    
        $this->CI->email->from('alexis@mediabox.bi', 'PSR BURUNDI');
        $this->CI->email->to($emailTo);
       // $this->CI->email->bcc('ismael@mediabox.bi');
        if (!empty($cc_emails)) {
            foreach ($cc_emails as $key => $value) {
                $this->CI->email->cc($value);
            }
        }
        $this->CI->email->subject($subjet);
        $this->CI->email->message($message);

        if (!empty($attach)) {
            foreach ($attach as $att)
                $this->CI->email->attach($att);
        }
        $this->CI->email->send();
       /* if (!$this->CI->email->send()) {
            show_error($this->CI->email->print_debugger());
        } 
            else;*/
       // echo $this->CI->email->print_debugger();


  }





public function send_sms($string_tel = NULL,$string_msg)
   {
        $data = '{"urns": ["tel:' . $string_tel . '"],"text":"' . $string_msg . '"}';

        $header = array();
        //$header [0] = 'Authorization:Token 9108b54d0c57ce3b170faeb288f6319d0b498686';
        $header [0] = 'Authorization:Token b6d64c9bbe3824032530c07f2b0c0f7f404087d2';
          //pas d'espace entre Authori et : et Token

        $header [1] = 'Content-Type:application/json';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://sms.ubuviz.com/api/v2/broadcasts.json');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($curl);
       // $result = json_decode($result);

        return $result;
   }

   public function generate_UIID($taille)
   {
     $Caracteres = 'ABCDEFGHIJKLMPQRSTUVXWYZ0123456789';
      $QuantidadeCaracteres = strlen($Caracteres);
      $QuantidadeCaracteres--;

      $Hash=NULL;
        for($x=1;$x<=$taille;$x++){
            $Posicao = rand(0,$QuantidadeCaracteres);
            $Hash .= substr($Caracteres,$Posicao,1);
        }

        return $Hash;
   }

    public function generate_password($taille)
   {
     $Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
      $QuantidadeCaracteres = strlen($Caracteres);
      $QuantidadeCaracteres--;

      $Hash=NULL;
        for($x=1;$x<=$taille;$x++){
            $Posicao = rand(0,$QuantidadeCaracteres);
            $Hash .= substr($Caracteres,$Posicao,1);
        }
        return $Hash;
   }


   public function generateQrcode($data,$name)
   {
      if(!is_dir('uploads/qrcode')) //create the folder if it does not already exists
       {
          mkdir('uploads/qrcode',0777,TRUE);
       }
      $Ciqrcode = new Ciqrcode();
      $params['data'] = $data;
      $params['level'] = 'H';
      $params['size'] = 10;
      $params['overwrite'] = TRUE;
      $params['savename'] = FCPATH . 'uploads/qrcode/' . $name . '.png';
      $Ciqrcode->generate($params);
   }


function pluralize( $count, $text )
{ if($text!='mois'){
    return $count . ( ( $count == 1 ) ? ( " $text" ) : ( " ${text}s" ) );
  }else{
     return $count . ( ( $count == 1 ) ? ( " $text" ) : ( " ${text}" ) );

  }
}

function ago($date1,$date2)
{

    $interval = date_create($date2)->diff( date_create($date1) );
    $suffix = "";
    if ( $v = $interval->y >= 1 ) return $this->pluralize( $interval->y, 'An' ) . $suffix;
    if ( $v = $interval->m >= 1 ) return $this->pluralize( $interval->m, 'Moi' ) . $suffix;
    if ( $v = $interval->d >= 1 ) return $this->pluralize( $interval->d, 'Jr' ) . $suffix;
    if ( $v = $interval->h >= 1 ) return $this->pluralize( $interval->h, 'hr' ) . $suffix;
    if ( $v = $interval->i >= 1 ) return $this->pluralize( $interval->i, 'min' ) . $suffix;
    return $this->pluralize( $interval->s, 'sec' ) . $suffix;
}

// public function gestion_phase($SOUS_PROJET_ID=0,$ID_PHASE)
// {
//       $this->CI->load->Modele('Modele');
//     if ($SOUS_PROJET_ID>0 && $ID_PHASE>0) {

// $this->Modele->update('sp_sous_projet',array('SOUS_PROJET_ID'=>$SOUS_PROJET_ID),array('ID_PHASE'=>$ID_PHASE));
// $this->Modele->create('Sp_sous_projet_historique_phase',array('DATE_ENTREE'=>date('Y-m-d h:i:s'),'ID_PHASE'=>$ID_PHASE,'ID_USER'=>$this->session->userdata('PRDAIGL_INTERVENANT_ID')));


// $Phase_anteriere=$this->Modele->getOne('Sp_sous_projet_historique_phase',array('SOUS_PROJET_ID'=>$SOUS_PROJET_ID,'ID_PHASE'=>$ID_PHASE-1));
// if(empty($Phase_anteriere)){
//   if($ID_PHASE==6 OR $ID_PHASE==14) {
//    $Phase_anteriere=$this->Modele->getOne('Sp_sous_projet_historique_phase',array('SOUS_PROJET_ID'=>$SOUS_PROJET_ID,'ID_PHASE'=>$ID_PHASE-2));

//   }


// }
// if(!empty($Phase_anteriere)){

// $this->Modele->update('Sp_sous_projet_historique_phase',array('SOUS_PROJET_ID'=>$Phase_anteriere['SOUS_PROJET_ID']),array('DATE_SORTIE'=>date('Y-m-d h:i:s') ));
// $data['message']='<div class="alert alert-success text-center" id="message">'."Mise à jour d'un Sous Projet est faite avec succès".'</div>';
//      $this->session->set_flashdata($data);
//     }else{
// $data['message']='<div class="alert alert-danger text-center" id="message">'."Mise à jour d'un Sous Projet echoué, pas de correspondence !!!".'</div>';
//      $this->session->set_flashdata($data);
//     }
//  return $data;

// }
// redirect(base_url());
// }
}

?>
