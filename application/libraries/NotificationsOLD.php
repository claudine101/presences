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
      $this->CI->load->model('Model');
	}



function send_mail($emailTo = array(), $subjet, $cc_emails = array(), $message, $attach = array()) {

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://chui.afriregister.com';
        $config['smtp_port'] = 465;
       // $config['smtp_port'] = 587;
        $config['smtp_user'] = 'app.booking@tourisme.gov.bi';
        $config['smtp_pass'] = '0UrWcD8_KRE,';
        $config['mailtype'] = 'html';
        $config['charset'] = 'UTF-8';
        $config['wordwrap'] = TRUE;
        $config['smtp_timeout'] = 20;
        $config['newline'] = "\r\n";
        $this->CI->email->initialize($config);
        $this->CI->email->set_mailtype("html");
        $this->CI->email->from('app.booking@tourisme.gov.bi', 'Acquasys');
        $this->CI->email->to($emailTo);
        $this->CI->email->cc($cc_emails);
        /*if (!empty($cc_emails)) {
            foreach ($cc_emails as $key => $value) { 
                $this->CI->email->cc($value);
            }
        }*/
        $this->CI->email->subject($subjet);
        $this->CI->email->message($message);

        if (!empty($attach)) {
            foreach ($attach as $att)
                $this->CI->email->attach($att);
        }
        if (!$this->CI->email->send()) {
            show_error($this->CI->email->print_debugger());
        } 
            else;
       // echo $this->CI->email->print_debugger();
    }


   public function smtp_mail($emailTo,$subjet,$cc_emails=NULL,$message,$attach=NULL)
   {     
        $this->CI = & get_instance();
        $this->CI->load->library('email');
        $config['protocol'] = 'smtp';
        //$config['smtp_crypto'] = 'tls';
        $config['smtp_host'] = 'ssl://twiga.afriregister.co.ke';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = 'helpdesk_comesa@mediabox.bi';
        $config['smtp_pass'] = 'mediabox@comesa2018';
        $config['mailtype'] = 'html';
        $config['charset'] = 'UTF-8';
        $config['wordwrap'] = TRUE;
        $config['smtp_timeout'] = 20;
       // $config['priority'] = '1';


        $this->CI->email->initialize($config);
        $this->CI->email->set_mailtype("html");

        // Load email library and passing configured values to email library 
        $this->CI->load->library('email', $config);
        $this->CI->email->set_newline("\r\n");

        $this->CI->email->from('helpdesk_comesa@mediabox.bi', 'MIFA Projet');
        $this->CI->email->to($emailTo);
        //$this->CI->email->bcc('pacifique@mediabox.bi');

          if (!empty($cc_emails)) {
          foreach ($cc_emails as $key => $value) {
          $this->CI->email->cc($value);
          }
          }
         
        $this->CI->email->subject($subjet);
        $this->CI->email->message($message);
        
        if(!empty($attach))
          {
            $this->email->attach($attach);
         }

        if (!$this->CI->email->send()) {
            show_error($this->CI->email->print_debugger());
        } else
            echo $this->CI->email->print_debugger();
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

    public function generate_password($taille)
   {
     $Caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVXWYZ0123456789'; 
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
      if(!is_dir('uploads/QRCODE')) //create the folder if it does not already exists   
       {
          mkdir('uploads/QRCODE',0777,TRUE);
       }

      $Ciqrcode = new Ciqrcode();
      $params['data'] = $data;
      $params['level'] = 'H';
      $params['size'] = 10;
      $params['overwrite'] = TRUE;
      $params['savename'] = FCPATH . 'uploads/QRCODE/' . $name . '.png';
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
    if ( $v = $interval->m >= 1 ) return $this->pluralize( $interval->m, 'Mois' ) . $suffix;
    if ( $v = $interval->d >= 1 ) return $this->pluralize( $interval->d, 'Jr' ) . $suffix;
    if ( $v = $interval->h >= 1 ) return $this->pluralize( $interval->h, 'hr' ) . $suffix;
    if ( $v = $interval->i >= 1 ) return $this->pluralize( $interval->i, 'min' ) . $suffix;
    return $this->pluralize( $interval->s, 'sec' ) . $suffix;
}

public function gestion_phase($SOUS_PROJET_ID=0,$ID_PHASE)
{
      $this->CI->load->Model('Model');
    if ($SOUS_PROJET_ID>0 && $ID_PHASE>0) {
        
$this->Model->update('sp_sous_projet',array('SOUS_PROJET_ID'=>$SOUS_PROJET_ID),array('ID_PHASE'=>$ID_PHASE));
$this->Model->create('Sp_sous_projet_historique_phase',array('DATE_ENTREE'=>date('Y-m-d h:i:s'),'ID_PHASE'=>$ID_PHASE,'ID_USER'=>$this->session->userdata('PRDAIGL_INTERVENANT_ID')));


$Phase_anteriere=$this->Model->getOne('Sp_sous_projet_historique_phase',array('SOUS_PROJET_ID'=>$SOUS_PROJET_ID,'ID_PHASE'=>$ID_PHASE-1));
if(empty($Phase_anteriere)){
  if($ID_PHASE==6 OR $ID_PHASE==14) {
   $Phase_anteriere=$this->Model->getOne('Sp_sous_projet_historique_phase',array('SOUS_PROJET_ID'=>$SOUS_PROJET_ID,'ID_PHASE'=>$ID_PHASE-2));   

  } 


}
if(!empty($Phase_anteriere)){

$this->Model->update('Sp_sous_projet_historique_phase',array('SOUS_PROJET_ID'=>$Phase_anteriere['SOUS_PROJET_ID']),array('DATE_SORTIE'=>date('Y-m-d h:i:s') ));
$data['message']='<div class="alert alert-success text-center" id="message">'."Mise à jour d'un Sous Projet est faite avec succès".'</div>';
     $this->session->set_flashdata($data);    
    }else{
$data['message']='<div class="alert alert-danger text-center" id="message">'."Mise à jour d'un Sous Projet echoué, pas de correspondence !!!".'</div>';
     $this->session->set_flashdata($data);
    }
 return $data;
    
}
redirect(base_url());
}
}

?>
