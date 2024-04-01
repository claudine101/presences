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
    $BDS_ID=$this->CI->Modele->getOne('bds_cds',array('CDS_ID'=>$CDS_ID))['BDS_ID'];
    if (empty($BDS_ID)) {
        # code...
        $BDS_ID=-1;
    }
    return $BDS_ID;//$this->CI->Modele->getOne('bds_cds',array('CDS_ID'=>$CDS_ID))['BDS_ID'];
  }

  public function getCdsDependance($INTERVENANT_RH_ID){
    $CDS_ID=$this->CI->Modele->getOne('cds_asc',array('INTERVENANT_RH_ID'=>$INTERVENANT_RH_ID))['CDS_ID'];
    if (empty($CDS_ID)) {
        # code...
        $CDS_ID=-1;
    }
    return $CDS_ID;
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


   // function send_mail($emailTo = array(), $subjet, $cc_emails = array(), $message, $attach = array()) {

   //      $config['protocol'] = 'smtp';
   //      $config['smtp_host'] = 'ssl://chui.afriregister.com';
   //      $config['smtp_port'] = 465;
   //     // $config['smtp_port'] = 587;
   //      $config['smtp_user'] = 'app.booking@tourisme.gov.bi';
   //      $config['smtp_pass'] = '0UrWcD8_KRE,';
   //      $config['mailtype'] = 'html';
   //      $config['charset'] = 'UTF-8';
   //      $config['wordwrap'] = TRUE;
   //      $config['smtp_timeout'] = 20;
   //      $config['newline'] = "\r\n";
   //      $this->CI->email->initialize($config);
   //      $this->CI->email->set_mailtype("html");
   //      $this->CI->email->from('app.booking@tourisme.gov.bi', 'Booking system');
   //      $this->CI->email->to($emailTo);
   //      $this->CI->email->cc($cc_emails);
   //      /*if (!empty($cc_emails)) {
   //          foreach ($cc_emails as $key => $value) {
   //              $this->CI->email->cc($value);
   //          }
   //      }*/
   //      $this->CI->email->subject($subjet);
   //      $this->CI->email->message($message);

   //      if (!empty($attach)) {
   //          foreach ($attach as $att)
   //              $this->CI->email->attach($att);
   //      }
   //      if (!$this->CI->email->send()) {
   //          show_error($this->CI->email->print_debugger());
   //      }
   //          else;
   //     // echo $this->CI->email->print_debugger();
   //  }




    //  public function mois_jour_litterale($str = '222') // Change une date aaaa/mm/dd en dd mois aaaa
    // {
    // // Récupère la date dans des variables
    // list($annee, $mois, $jour) = explode("-", $str);
    // // Retire le 0 des jours
    // if ($jour=="00") $jour="";
    // elseif (substr($jour, 0, 1)=="0") $jour=substr($jour, 1, 1);
    // // Met le mois en littéral
    // $moisli{1} = "janvier";
    // $moisli{2} = "février";
    // $moisli{3} = "mars";
    // $moisli{4} = "avril";
    // $moisli{5} = "mai";
    // $moisli{6} = "juin";
    // $moisli{7} = "juillet";
    // $moisli{8} = "août";
    // $moisli{9} = "septembre";
    // $moisli{10} = "octobre";
    // $moisli{11} = "novembre";
    // $moisli{12} = "décembre";


    // $jourli{1} = "premier";
    // $jourli{2} = "deuxième";
    // $jourli{3} = "troisième";
    // $jourli{4} = "quatrième";
    // $jourli{5} = "cinquième";
    // $jourli{6} = "sixième";
    // $jourli{7} = "septième";
    // $jourli{8} = "huitième";
    // $jourli{9} = "neuvième";
    // $jourli{10} = "dixième";
    // $jourli{11} = "onzième";
    // $jourli{12} = "douzième";
    // $jourli{13} = "treizième";
    // $jourli{14} = "quatrième";
    // $jourli{15} = "quinzième";
    // $jourli{16} = "seizième";
    // $jourli{17} = "dix-septième";
    // $jourli{18} = "dix-huitième";
    // $jourli{19} = "dix-neuvième";
    // $jourli{20} = "vingtième";
    // $jourli{21} = "vingt unième";
    // $jourli{22} = "vingt deuxième";
    // $jourli{23} = "vingt troisième";
    // $jourli{24} = "vingt quatrième";
    // $jourli{25} = "vingt cinquième";
    // $jourli{26} = "vingt sixième";
    // $jourli{27} = "vingt septième";
    // $jourli{28} = "vingt huitième";
    // $jourli{29} = "vingt neuvième";
    // $jourli{30} = "trentième";
    // $jourli{31} = "le trente-et-unième";




    // $anneeli{2020} = "deux mille vingt";
    // $anneeli{2021} = "deux mille vingt-un";
    // $anneeli{2022} = "deux mille vingt deux ";
    // $anneeli{2023} = "deux mille vingt trois ";
    // $anneeli{2024} = "deux mille vingt quatre ";
    // $anneeli{2025} = "deux mille vingt cinq ";
    // $anneeli{2026} = "deux mille vingt six ";
    // $anneeli{2027} = "deux mille vingt sept ";
    // $anneeli{2028} = "deux mille vingt huit ";
    // $anneeli{2029} = "deux mille vingt neuf ";
    // $anneeli{2030} = "deux mille trente";
    // $anneeli{2031} = "deux mille trente-un";
    // $anneeli{2032} = "deux mille trente deux";
    // $anneeli{2033} = "deux mille trente trois";
    // $anneeli{2034} = "deux mille trente quatre";
    // $anneeli{2035} = "deux mille trente cinq ";
    // $anneeli{2036} = "deux mille trente six";
    // $anneeli{2037} = "deux mille trente sept";
    // $anneeli{2038} = "deux mille trente huit";
    // $anneeli{2039} = "deux mille trente neuf";
    // $anneeli{2040} = "deux mille quarante";
    // $anneeli{2041} = "deux mille quarante un";
    // $anneeli{2042} = "deux mille quarante deux";
    // $anneeli{2043} = "deux mille quarante trois";
    // $anneeli{2044} = "deux mille quarante quatre";
    // $anneeli{2045} = "deux mille quarante cinq";
    // $anneeli{2046} = "deux mille quarante six";
    // $anneeli{2047} = "deux mille quarante sept";
    // $anneeli{2048} = "deux mille quarante huit";
    // $anneeli{2049} = "deux mille quarante neuf ";
    // $anneeli{2050} = "deux mille cinquante";





    // if (substr($mois, 0, 1)=="0") $mois=substr($mois, 1, 1);
    // $mois = $moisli[$mois];


    // if (substr($jour, 0, 1)=="0") $jour=substr($jour, 1, 1);
    // $jour = $jourli[$jour];

    // if (substr($annee, 0, 1)=="0") $annee=substr($annee, 1, 1);
    // $annee = $anneeli[$annee];



    // $str = 'L\'an '.$annee.' le '. $jour.' jour du mois de '.$mois.',';
    // return $str;

    // }
//added by @jules_ndihokubwayo@mediabox.bi
    public function get_valeur_annuelle($id_district,$id_intrant)
    {
        # code...
        $sql  = 'SELECT `INTRANT_MEDICAUX_ID` FROM `maladies_intrant` mi JOIN maladies m ON mi.`MALADIE_ID`=m.MALADIE_ID WHERE m.MALADIE_CODE LIKE \'PALU\'';
        $intr=$this->CI->Modele->getRequete($sql);
        foreach ($intr as $key) {
            # code...
            $array_int[]=$key['INTRANT_MEDICAUX_ID'];
        }

        $estimation_intrants=$this->CI->Modele->getOne('estimation_intrants',
            array('ID_INTRANT_MEDICAUX'=>$id_intrant,'INTERVENANT_STRUCTURE_ID'=>$id_district));
        $QUANTITE_ANNUEL=$estimation_intrants['QUANTITE_ANNUEL'];
        $QUANTITE_MENSUEL=$estimation_intrants['QUANTITE_MENSUEL'];

        if (empty($QUANTITE_ANNUEL)) {
            # code...
            $QUANTITE_ANNUEL=0;
        }
        if (in_array($id_intrant, $array_int)) {
            # code...
            $sql  = 'SELECT `ID`,`TAUX` FROM `estimation_intrants_paludisme` WHERE 1';
            $TOTAL_QUANTITE_ANNUEL=0;
            $estm = $this->CI->Modele->getRequete($sql);
            foreach ($estm as $key) {
                # code...
                $taux=($estimation_intrants['QUANTITE_MENSUEL']*$key['TAUX'])/100;
                $TOTAL_QUANTITE_ANNUEL+=$QUANTITE_MENSUEL+$taux;


            }
            $QUANTITE_ANNUEL=$TOTAL_QUANTITE_ANNUEL;

        }
        return round($QUANTITE_ANNUEL);

    }
   //trouver le seuil mensuel par intrant chez camebu
    public function get_valeur_mensuelle_camebu($id_intrant)
    {
        # code...
        $sql  = 'SELECT `INTRANT_MEDICAUX_ID` FROM `maladies_intrant` mi JOIN maladies m ON mi.`MALADIE_ID`=m.MALADIE_ID WHERE m.MALADIE_CODE LIKE \'PALU\'';
        $intr=$this->CI->Modele->getRequete($sql);
        foreach ($intr as $key) {
            # code...
            $array_int[]=$key['INTRANT_MEDICAUX_ID'];
        }
        $sql_qt_mns  = 'SELECT SUM(`QUANTITE_MENSUEL`) qt_mns FROM `estimation_intrants` WHERE `ID_INTRANT_MEDICAUX`='.$id_intrant;

        $estimation_intrants=$this->CI->Modele->getRequeteOne($sql_qt_mns);
        $QUANTITE_MENSUEL=$estimation_intrants['qt_mns'];

        if (empty($QUANTITE_MENSUEL)) {
            # code...
            $QUANTITE_MENSUEL=0;
        }
        if (in_array($id_intrant, $array_int)) {
            # code...
            $sql  = 'SELECT `ID`,`TAUX` FROM `estimation_intrants_paludisme` WHERE 1';
            $TOTAL_QUANTITE_MENSUELLE=0;
            $estm = $this->CI->Modele->getRequete($sql);
            $taux_c=0;
            foreach ($estm as $key) {
                # code...
                $taux_c+=$key['TAUX'];


            }
            $taux=($estimation_intrants['qt_mns']*$taux_c)/100;
            $TOTAL_QUANTITE_MENSUELLE+=$QUANTITE_MENSUEL+$taux;
            $QUANTITE_MENSUEL=$TOTAL_QUANTITE_MENSUELLE;

        }
        return round($QUANTITE_MENSUEL);

    }
    public function get_valeur_mensuelle($id_district,$id_intrant)
    {
        # code...
        if (empty($id_intrant)) {
            # code...
            $id_intrant=0;
        }
        
        $sql  = 'SELECT `INTRANT_MEDICAUX_ID` FROM `maladies_intrant` mi JOIN maladies m ON mi.`MALADIE_ID`=m.MALADIE_ID WHERE m.MALADIE_CODE LIKE \'PALU\' AND INTRANT_MEDICAUX_ID='.$id_intrant;
        $intr=$this->CI->Modele->getRequeteOne($sql);


        $estimation_intrants=$this->CI->Modele->getOne('estimation_intrants',
            array('ID_INTRANT_MEDICAUX'=>$id_intrant,'INTERVENANT_STRUCTURE_ID'=>$id_district));
        $QUANTITE_ANNUEL=$estimation_intrants['QUANTITE_ANNUEL'];
        $QUANTITE_MENSUEL=$estimation_intrants['QUANTITE_MENSUEL'];
        $QUANTITE_MENSU=$estimation_intrants['QUANTITE_MENSUEL'];
        if (empty($QUANTITE_MENSUEL)) {
            # code...
            $QUANTITE_MENSUEL=0;
        }
        if (intval($intr['INTRANT_MEDICAUX_ID'])>0) {
            # code...
            $sql  = 'SELECT `TAUX` FROM `estimation_intrants_paludisme` WHERE `ID`='.date('m');
            $TOTAL_QUANTITE_MENSUELLE=0;

            $estm = $this->CI->Modele->getRequeteOne($sql);
            
                # code...
                $taux=($estimation_intrants['QUANTITE_MENSUEL']*$estm['TAUX'])/100;
                $TOTAL_QUANTITE_MENSUELLE=$QUANTITE_MENSUEL+$taux;


        
            $QUANTITE_MENSU=$TOTAL_QUANTITE_MENSUELLE;

        }
        return round($QUANTITE_MENSU);

    }
    public function get_valeur_mensuelle_cds($id_district,$id_intrant)
    {
        # code...
        $sql_nbre_cds  = 'SELECT COUNT(`CDS_ID`) nbre_cds FROM `bds_cds` WHERE `BDS_ID`='.$id_district;
        $nbre_cds=$this->CI->Modele->getRequeteOne($sql_nbre_cds);

        $sql  = 'SELECT `INTRANT_MEDICAUX_ID` FROM `maladies_intrant` mi JOIN maladies m ON mi.`MALADIE_ID`=m.MALADIE_ID WHERE m.MALADIE_CODE LIKE \'PALU\' AND INTRANT_MEDICAUX_ID='.$id_intrant;
        $intr=$this->CI->Modele->getRequeteOne($sql);


        $estimation_intrants=$this->CI->Modele->getOne('estimation_intrants',
            array('ID_INTRANT_MEDICAUX'=>$id_intrant,'INTERVENANT_STRUCTURE_ID'=>$id_district));
        $QUANTITE_ANNUEL=$estimation_intrants['QUANTITE_ANNUEL'];
        $QUANTITE_MENSUEL=$estimation_intrants['QUANTITE_MENSUEL'];
        $QUANTITE_MENSU=$estimation_intrants['QUANTITE_MENSUEL'];
        if (empty($QUANTITE_MENSUEL)) {
            # code...
            $QUANTITE_MENSUEL=0;
        }
        if (intval($intr['INTRANT_MEDICAUX_ID'])>0) {
            # code...
            $sql  = 'SELECT `TAUX` FROM `estimation_intrants_paludisme` WHERE `ID`='.date('m');
            $TOTAL_QUANTITE_MENSUELLE=0;

            $estm = $this->CI->Modele->getRequeteOne($sql);
            
                # code...
                $taux=($estimation_intrants['QUANTITE_MENSUEL']*$estm['TAUX'])/100;
                $TOTAL_QUANTITE_MENSUELLE=$QUANTITE_MENSUEL+$taux;


        
            $QUANTITE_MENSU=$TOTAL_QUANTITE_MENSUELLE;

        }
        if (empty($nbre_cds['nbre_cds']) || $nbre_cds['nbre_cds']==0) {
            # code...
            $nbre_cds['nbre_cds']=1;
        }
        return round($QUANTITE_MENSU/$nbre_cds['nbre_cds']) ;

    }
    public function get_stock_intervenant($ID_STRUCTURE_INTERVENANT_ID=6)
    {
        # code...
        $sql  = 'SELECT `INTRANT_MEDICAUX_ID`,`INTRANT_MEDICAUX_CODE`,`INTRANT_MEDICAUX_DESCR` FROM `intrant_medicaux` WHERE `INTRANT_MEDICAUX_ID` IN (SELECT stock_intervenat.INTRANT_ID FROM stock_intervenat WHERE stock_intervenat.INTERVENANT_STRUCTURE_ID='.$ID_STRUCTURE_INTERVENANT_ID.')';
        $intrant_medicaux = $this->CI->Modele->getRequete($sql);

        $table="<table class='table table-sm table-bordered'><tr><th scope='col'>Structure</th>";
        foreach ($intrant_medicaux as $key) {
            # code...
          $table.='<th scope="col">
          <span class="tooltipp">
            <p class="topp">
            '.$key['INTRANT_MEDICAUX_DESCR'].'
            </p>            
            '.str_replace("-", "", $key['INTRANT_MEDICAUX_CODE']).'</th>
          </span>
          <?php } ?>
        <!--   </span> -->
          
        ';
        }
        $table.='</tr>';
        $sql_struct  = 'SELECT `INTERVENANT_STRUCTURE_ID`,`INTERVENANT_STRUCTURE_DESCR` FROM `intervenants_structure` WHERE `INTERVENANT_STRUCTURE_ID`='.$ID_STRUCTURE_INTERVENANT_ID;
        $intervenants_structure = $this->CI->Modele->getRequete($sql_struct);
        foreach ($intervenants_structure as $key_srtc) {
            # code...
            $table.='<tr><td>'.$key_srtc['INTERVENANT_STRUCTURE_DESCR'].'</td>';
            foreach ($intrant_medicaux as $value) {
                # code...
               $sql_stck  = 'SELECT SUM(`QUANTITE`) QTE_DISPO FROM `stock_intervenat` WHERE `INTERVENANT_STRUCTURE_ID`='.$key_srtc['INTERVENANT_STRUCTURE_ID'].' AND `INTRANT_ID`='.$value['INTRANT_MEDICAUX_ID'];
               $stk = $this->CI->Modele->getRequeteOne($sql_stck);
               $table.='<td><center>'.number_format($stk['QTE_DISPO'],0,' ',' ').'</center></td>';
            }
            $table.='</tr>';
        }
        $table.="</table>";
        return $table; 
    }
    // public function get_valeur_mensuelle_camebu($id_district,$id_intrant)
    // {
    //     # code...
    //     $sql_nbre_cds  = 'SELECT COUNT(`CDS_ID`) nbre_cds FROM `bds_cds` WHERE `BDS_ID`='.$id_district;
    //     $nbre_cds=$this->CI->Modele->getRequeteOne($sql_nbre_cds);

    //     $sql  = 'SELECT `INTRANT_MEDICAUX_ID` FROM `maladies_intrant` mi JOIN maladies m ON mi.`MALADIE_ID`=m.MALADIE_ID WHERE m.MALADIE_CODE LIKE \'PALU\' AND INTRANT_MEDICAUX_ID='.$id_intrant;
    //     $intr=$this->CI->Modele->getRequeteOne($sql);


    //     $estimation_intrants=$this->CI->Modele->getOne('estimation_intrants',
    //         array('ID_INTRANT_MEDICAUX'=>$id_intrant,'INTERVENANT_STRUCTURE_ID'=>$id_district));
    //     $QUANTITE_ANNUEL=$estimation_intrants['QUANTITE_ANNUEL'];
    //     $QUANTITE_MENSUEL=$estimation_intrants['QUANTITE_MENSUEL'];
    //     $QUANTITE_MENSU=$estimation_intrants['QUANTITE_MENSUEL'];
    //     if (empty($QUANTITE_MENSUEL)) {
    //         # code...
    //         $QUANTITE_MENSUEL=0;
    //     }
    //     if (intval($intr['INTRANT_MEDICAUX_ID'])>0) {
    //         # code...
    //         $sql  = 'SELECT `TAUX` FROM `estimation_intrants_paludisme` WHERE `ID`='.date('m');
    //         $TOTAL_QUANTITE_MENSUELLE=0;

    //         $estm = $this->CI->Modele->getRequeteOne($sql);
            
    //             # code...
    //             $taux=($estimation_intrants['QUANTITE_MENSUEL']*$estm['TAUX'])/100;
    //             $TOTAL_QUANTITE_MENSUELLE=$QUANTITE_MENSUEL+$taux;


        
    //         $QUANTITE_MENSU=$TOTAL_QUANTITE_MENSUELLE;

    //     }
    //     return round($QUANTITE_MENSU/$nbre_cds['nbre_cds']) ;

    // }
/*---------------------------------------------------------------*/
/*
    Titre : Affiche la date littérale en Fran&ccedil;ais                                                                 
                                                                                                                          
    URL   : https://phpsources.net/code_s.php?id=343
    Auteur           : frankoi                                                                                            
    Date édition     : 21 Fév 2008                                                                                        
    Date mise à jour : 05 Sept 2019                                                                                      
    Rapport de la maj:                                                                                                    
    - fonctionnement du code vérifié                                                                                    
*/
/*---------------------------------------------------------------*/

    // function MeF_Date($str) // Change une date aaaa/mm/dd en dd mois aaaa
    // {
    // // Récupère la date dans des variables
    // list($annee, $mois, $jour) = explode("-", $str);
    // // Retire le 0 des jours
    // if ($jour=="00") $jour="";
    // elseif (substr($jour, 0, 1)=="0") $jour=substr($jour, 1, 1);
    // // Met le mois en littéral
    // $moisli{1} = "janvier";
    // $moisli{2} = "février";
    // $moisli{3} = "mars";
    // $moisli{4} = "avril";
    // $moisli{5} = "mai";
    // $moisli{6} = "juin";
    // $moisli{7} = "juillet";
    // $moisli{8} = "août";
    // $moisli{9} = "septembre";
    // $moisli{10} = "octobre";
    // $moisli{11} = "novembre";
    // $moisli{12} = "décembre";
    // if (substr($mois, 0, 1)=="0") $mois=substr($mois, 1, 1);
    // $mois = $moisli[$mois];
    // // Met en forme 
    // $str = $jour.' '.$mois.' '.$annee;
    // return $str;
    // }

}

?>
