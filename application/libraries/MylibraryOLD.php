<?php

class Mylibrary
{
      protected $CI;
	function __construct()
	{
	    $this->CI = & get_instance();
      $this->CI->load->library('email');
      $this->CI->load->model('Modele');
	}

	public function getOne($table, $array)
	{
		return $this->CI->Modele->getOne($table,$array);
	}
  public function getBdsDependance($CDS_ID){
    return $this->CI->Modele->getOne('bds_cds',array('CDS_ID'=>$CDS_ID))['BDS_ID'];
  }

  public function getCdsDependance($INTERVENANT_RH_ID){
    return $this->CI->Modele->getOne('cds_asc',array('INTERVENANT_RH_ID'=>$INTERVENANT_RH_ID))['CDS_ID'];
  }

  public function get_permission($url)
	{
		//echo $url;
		$autorised = 0;
		if(empty($this->CI->Model->getOne('admin_fonctionnalites',array('FONCTIONNALITE_URL'=>$url)))){
          $autorised =1;
		}else{
			$data = $this->CI->Model->get_permission($url);

		  if(!empty($data))
		  	{
		  		$autorised =1;
		  	}
	  }

	  return $autorised;
	}

	public function loadjs()
	{
		$file = $this->CI->router->class;
		echo '<script src="'.base_url().'js/modules/'.$file.'.js"></script>';
	}

	public function generate_password($taille)
   {
     $Caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVXWYZ0123456789,.@{-_/#';
      $QuantidadeCaracteres = strlen($Caracteres);
      $QuantidadeCaracteres--;

      $Hash=NULL;
        for($x=1;$x<=$taille;$x++){
            $Posicao = rand(0,$QuantidadeCaracteres);
            $Hash .= substr($Caracteres,$Posicao,1);
        }
        return $Hash;
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
        $this->CI->email->from('app.booking@tourisme.gov.bi', 'Booking system');
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




     public function mois_jour_litterale($str) // Change une date aaaa/mm/dd en dd mois aaaa
    {
    // Récupère la date dans des variables
    list($annee, $mois, $jour) = explode("-", $str);
    // Retire le 0 des jours
    if ($jour=="00") $jour="";
    elseif (substr($jour, 0, 1)=="0") $jour=substr($jour, 1, 1);
    // Met le mois en littéral
    $moisli{1} = "janvier";
    $moisli{2} = "février";
    $moisli{3} = "mars";
    $moisli{4} = "avril";
    $moisli{5} = "mai";
    $moisli{6} = "juin";
    $moisli{7} = "juillet";
    $moisli{8} = "août";
    $moisli{9} = "septembre";
    $moisli{10} = "octobre";
    $moisli{11} = "novembre";
    $moisli{12} = "décembre";


    $jourli{1} = "premier";
    $jourli{2} = "deuxième";
    $jourli{3} = "troisième";
    $jourli{4} = "quatrième";
    $jourli{5} = "cinquième";
    $jourli{6} = "sixième";
    $jourli{7} = "septième";
    $jourli{8} = "huitième";
    $jourli{9} = "neuvième";
    $jourli{10} = "dixième";
    $jourli{11} = "onzième";
    $jourli{12} = "douzième";
    $jourli{13} = "treizième";
    $jourli{14} = "quatrième";
    $jourli{15} = "quinzième";
    $jourli{16} = "seizième";
    $jourli{17} = "dix-septième";
    $jourli{18} = "dix-huitième";
    $jourli{19} = "dix-neuvième";
    $jourli{20} = "vingtième";
    $jourli{21} = "vingt unième";
    $jourli{22} = "vingt deuxième";
    $jourli{23} = "vingt troisième";
    $jourli{24} = "vingt quatrième";
    $jourli{25} = "vingt cinquième";
    $jourli{26} = "vingt sixième";
    $jourli{27} = "vingt septième";
    $jourli{28} = "vingt huitième";
    $jourli{29} = "vingt neuvième";
    $jourli{30} = "trentième";
    $jourli{31} = "le trente-et-unième";




    $anneeli{2020} = "deux mille vingt";
    $anneeli{2021} = "deux mille vingt-un";
    $anneeli{2022} = "deux mille vingt deux ";
    $anneeli{2023} = "deux mille vingt trois ";
    $anneeli{2024} = "deux mille vingt quatre ";
    $anneeli{2025} = "deux mille vingt cinq ";
    $anneeli{2026} = "deux mille vingt six ";
    $anneeli{2027} = "deux mille vingt sept ";
    $anneeli{2028} = "deux mille vingt huit ";
    $anneeli{2029} = "deux mille vingt neuf ";
    $anneeli{2030} = "deux mille trente";
    $anneeli{2031} = "deux mille trente-un";
    $anneeli{2032} = "deux mille trente deux";
    $anneeli{2033} = "deux mille trente trois";
    $anneeli{2034} = "deux mille trente quatre";
    $anneeli{2035} = "deux mille trente cinq ";
    $anneeli{2036} = "deux mille trente six";
    $anneeli{2037} = "deux mille trente sept";
    $anneeli{2038} = "deux mille trente huit";
    $anneeli{2039} = "deux mille trente neuf";
    $anneeli{2040} = "deux mille quarante";
    $anneeli{2041} = "deux mille quarante un";
    $anneeli{2042} = "deux mille quarante deux";
    $anneeli{2043} = "deux mille quarante trois";
    $anneeli{2044} = "deux mille quarante quatre";
    $anneeli{2045} = "deux mille quarante cinq";
    $anneeli{2046} = "deux mille quarante six";
    $anneeli{2047} = "deux mille quarante sept";
    $anneeli{2048} = "deux mille quarante huit";
    $anneeli{2049} = "deux mille quarante neuf ";
    $anneeli{2050} = "deux mille cinquante";





    if (substr($mois, 0, 1)=="0") $mois=substr($mois, 1, 1);
    $mois = $moisli[$mois];


    if (substr($jour, 0, 1)=="0") $jour=substr($jour, 1, 1);
    $jour = $jourli[$jour];

    if (substr($annee, 0, 1)=="0") $annee=substr($annee, 1, 1);
    $annee = $anneeli[$annee];



    $str = 'L\'an '.$annee.' le '. $jour.' jour du mois de '.$mois.',';
    return $str;

    }



}
?>
