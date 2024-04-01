<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Send_whatspp
{
	protected $CI;

	public function __construct()
	{
	    $this->CI = & get_instance();
      $this->CI->load->library('email');
      $this->CI->load->model('Modele');
	}



    function sendMessage($chatId, $text){
        $data = array('chatId'=>$chatId,'body'=>$text);
        return $this->sendMessage_Whatspp('message',$data);
    }



    function file($chatId, $text = ''){

        $format = 'https://giowm1223.siteground.biz/webmail/roundcube/skins/elastic/images/logo.svg?s=1591528318';
        // $chatId = '25768738051-1612370580@g.us';
        $data = array(
                        'chatId'=>$chatId,
                        'body'=>$format,
                        'filename'=>'Rapport',
                        'caption'=> '$text'
                    );
           $chec = $this->sendMessage_Whatspp('sendFile',$data);
           print_r($chec);
       
    }

  


   // function promoteGroupParticipant(){

   //  $telephones = $this->Model->getRequete("SELECT `ID_NUMBER`,REPLACE(`TELEPHONE`,' ','') AS TELEPHONE,`STATUT_ID`,`EXISTE_ID` FROM `mbx_group` WHERE STATUT_ID=1");

   //  foreach ($telephones as $key => $value) {
    
   //  $data = array(
   //                'groupId'=>"25761741956-1626442398@g.us",
   //                'participantChatId'=>"",
   //                'participantPhone'=> $value['TELEPHONE'],
   //            );

   //  $rest = $this->sendMessage_Whatspp('promoteGroupParticipant',$data);
   //  print_r($rest);


   //  }


   function chec_number_unique($numero="2576174195"){

    $rest = $this->test_numero($numero);
    $reponse = ($rest=='exists') ? 1 : 0;
    return $reponse;
  
    }
    


    function test_numero($numero="25765897512"){

    $Api_compte = 'api';
    $token = 'yga7fggbsblupgx2';
    $instance = '393190';
    $method = "checkPhone";
    $url = 'https://'.$Api_compte.'.chat-api.com/instance'.$instance.'/'.$method.'?token='.$token.'&phone='.$numero;

    $result = file_get_contents($url); // Send a request
    $data = json_decode($result, 1); 

    return $data['result'];
    //https://api.chat-api.com/instance307961/checkPhone?token=w5g4w743idggjjyv&phone=25761741956

    }




    function sendMessage_Whatspp($method,$data){


        $Api_compte = 'api';
        $token = 'yga7fggbsblupgx2';
        $instance = '393190';

        $url = 'https://'.$Api_compte.'.chat-api.com/instance'.$instance.'/'.$method.'?token='.$token;
        if(is_array($data)){ $data = json_encode($data);}
        $options = stream_context_create(['http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => $data
        ]]);
        $response = file_get_contents($url,false,$options);
        //file_put_contents('requests.log',$response.PHP_EOL,FILE_APPEND);}
        //print_r($response);
        return $response;

    }







}

?>