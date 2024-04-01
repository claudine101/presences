<?php




class Elements_Pnb extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->have_droit();
  }
  public function have_droit()
  {
    if ( $this->session->userdata('MAP_AGENT_POLICE') != 1) {

      redirect(base_url());
     }
  }
  function sendAffectation_deux()
  {

  

  $lieux_id_aff = $this->input->post('lieux_id_aff');
  $type_aff_id = $this->input->post('type_aff_id');


  $Agents = !empty($this->input->post('Agents')) ? $this->input->post('Agents') : array();
  $control_catego = !empty($this->input->post('control_catego')) ? $this->input->post('control_catego') : array();
  $id_control = !empty($this->input->post('id_control')) ? $this->input->post('id_control') : array();
  $id_question_repo = !empty($this->input->post('id_question_repo')) ? $this->input->post('id_question_repo') : array();

  $pays_id = $this->input->post('pays_id');
  $province_id = $this->input->post('province_id');
  $latlong_donne = $this->input->post('latlong_donne');
  $Lieux = $this->input->post('Lieux');

  $DateAff = $this->input->post('DateAff');
  $TempsA = $this->input->post('TempsA');
  $TempsB = $this->input->post('TempsB');
  $Commentaires = $this->input->post('Commentaires');



  $id_affect_lieux = $lieux_id_aff;

  $do = 0;

     if ($id_affect_lieux > 0) {
   
        
        foreach ($Agents as $key => $value) {

            if ($value > 0) {
            

                $update = array('IS_ACTIVE' => 0);
                $test = $this->Modele->update('psr_element_affectation', array('ID_PSR_ELEMENT' => $value), $update);
            
                $data_insert = array(
                                     'ID_PSR_ELEMENT' => $value,
                                     'PSR_AFFECTATION_ID' => $id_affect_lieux,
                                     'DATE_DEBUT' => $TempsA,
                                     'DATE_FIN' => $TempsB,
                                     'COMMENTAIRES' => $Commentaires,
                                     'IS_ACTIVE' => 1,
                                    );

                $table = 'psr_element_affectation';
                $ELEMENT_AFFECT_ID = $this->Modele->insert_last_id($table, $data_insert);

                $data_catego = array(
                                     'ELEMENT_AFFECT_ID' => $ELEMENT_AFFECT_ID,
                                     'control_catego' => $control_catego,
                                     'id_control' => $id_control,
                                     'id_question_repo' => $id_question_repo,
                                    );
                $do = $this->sendMessage_autre(array('id'=>$value));
                $this->save_catego_ctrl($data_catego);
              
            }   

        }


      }
        
      print_r(json_encode($do));

    

  }



  function get_question_control($las_quest,$new_ty_ctrl = array())
  {

     $html = "";
     $arr_x = array();

      if (!empty($las_quest)) {
          $requete = $this->Model->getRequete('SELECT `ID_CONTROLES_QUESTIONNAIRES` FROM `psr_element_affect_ctrl_question` WHERE `AFFECT_TYPE_CNTROL_ID`='.$las_quest);
            foreach ($requete as $key) {
              $arr_x[] = $key['ID_CONTROLES_QUESTIONNAIRES'];
            }
      }
            
      $new_ty_ctrl = $this->Model->getRequete('SELECT `ID_CONTROLES_QUESTIONNAIRES` ,`INFRACTIONS` FROM `autres_controles_questionnaires` WHERE 1 ');
       
        if (empty($arr_x)) {
          $html.= '<option value="0" selected>Recherche... </option>';
        }
          $id = 0;
          foreach ($new_ty_ctrl as $key => $value) {
            $selected =  '';
            $id ++;
              if (in_array($value['ID_CONTROLES_QUESTIONNAIRES'], $arr_x)) {
                 $html.= '<option value="'.$value['ID_CONTROLES_QUESTIONNAIRES'].'" selected > '.$id.'. '.$value['INFRACTIONS'].' </option>';
              }else{
                 $html.= '<option value="'.$value['ID_CONTROLES_QUESTIONNAIRES'].'" >'.$id.'. '.$value['INFRACTIONS'].' </option>';
              }
          }
              
    
       
      return $html;
  
  }


  function get_type_control($last_catego, $catego = array()){
    
     $html = "";
     $arr_x = array();

     $las_quest = 0;

      if (!empty($last_catego)) {
          $requete = $this->Model->getRequete('SELECT `AFFECT_TYPE_CNTROL_ID`,`ID_TYPE_CONTROLE` FROM `psr_element_affect_type_ctrl` WHERE `CATEGO_CONTROL_ID`='.$last_catego);

          foreach ($requete as $key) {
            $arr_x[] = $key['ID_TYPE_CONTROLE'];
            $las_quest = $key['AFFECT_TYPE_CNTROL_ID'];
          }

      }
            
      $new_ty_ctrl = $this->Model->getRequete('SELECT `ID_QUESTIONNAIRE_CATEGORIES`,`CATEGORIES` FROM `quetionnaire_categories` WHERE 1 ');
       
        if (empty($arr_x)) {
          $html.= '<option value="0" selected>Recherche... </option>';
        }
          $id = 0;
          foreach ($new_ty_ctrl as $key => $value) {
            $selected =  '';
            $id ++;
              if (in_array($value['ID_QUESTIONNAIRE_CATEGORIES'], $arr_x)) {
                 $html.= '<option value="'.$value['ID_QUESTIONNAIRE_CATEGORIES'].'" selected > '.$id.'. '.$value['CATEGORIES'].' </option>';
              }else{
                 $html.= '<option value="'.$value['ID_QUESTIONNAIRE_CATEGORIES'].'" >'.$id.'. '.$value['CATEGORIES'].' </option>';
              }
          }
            
        $quest_ctrl = $this->get_question_control($las_quest,$new_ty_ctrl);

        $donne['ty_cntrls'] = $html;
        $donne['quest_ctrl'] = $quest_ctrl;
              
      return $donne;

  }


  function get_histo_catego($id_aff = null){
     
     $catego = $this->Model->getRequeteOne("SELECT `ELEMENT_AFFECT_ID` FROM `psr_element_affectation` WHERE 1 AND `PSR_AFFECTATION_ID`=".$id_aff." and `IS_ACTIVE`=1 LIMIT 1");
     $html = "";
     $arr_x = array();

      $las_catego = 0;
      if (!empty($catego)) {
         $catego_ex = $this->Model->getRequete('SELECT CATEGO_CONTROL_ID,`ID_CATEGORIE` FROM `psr_element_affect_catego_ctrl` WHERE `ELEMENT_AFFECT_ID`='.$catego['ELEMENT_AFFECT_ID']);
            foreach ($catego_ex as $key) {
              $arr_x[] = $key['ID_CATEGORIE'];
              $las_catego = $key['CATEGO_CONTROL_ID'];
            }
      }
            
      $new_catego = $this->Model->getRequete('SELECT `ID_CATEGORIE`,`DESCRIPTION` FROM `historiques_categories` WHERE 1');
       
        if (empty($arr_x)) {
          $html.= '<option value="0" selected>Recherche... </option>';
        }
    
          foreach ($new_catego as $key => $value) {
            $selected =  '';
          
              if (in_array($value['ID_CATEGORIE'], $arr_x)) {
                 $html.= '<option value="'.$value['ID_CATEGORIE'].'" selected > '.$value['DESCRIPTION'].' </option>';
              }else{
                 $html.= '<option value="'.$value['ID_CATEGORIE'].'" >'.$value['DESCRIPTION'].' </option>';
              }
          }


        $ty_ctrl = $this->get_type_control($las_catego,$new_catego);

        $donne['ty_ctrl'] = $ty_ctrl['ty_cntrls'];
        $donne['quest_ctrl'] = $ty_ctrl['quest_ctrl'];
        $donne['categos'] = $html;
              

      return $donne;
     
  }


  function get_element_police($id =0){

    $lieux_avant = $this->Model->getRequete('SELECT ea.ID_PSR_ELEMENT,ea.DATE_DEBUT,ea.DATE_FIN,ea.COMMENTAIRES FROM psr_element_affectation ea JOIN psr_affectatations a on a.PSR_AFFECTATION_ID=ea.PSR_AFFECTATION_ID WHERE 1 AND ea.IS_ACTIVE=1 AND ea.PSR_AFFECTATION_ID='.$id);

    $arr_x       = array();
    $date_a      = '';
    $date_b      = '';
    $commentaire = '';

    foreach ($lieux_avant as $key) {

      $arr_x[]     =  $key['ID_PSR_ELEMENT'];
      $date_a      =  $key['DATE_DEBUT'];
      $date_b      =  $key['DATE_FIN'];
      $commentaire =  $key['COMMENTAIRES'];

    }

    $new_elemnt = $this->Model->getRequete('SELECT e.ID_PSR_ELEMENT,e.TELEPHONE,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,e.SEXE FROM psr_elements e WHERE 1 order by e.NOM,e.PRENOM');

     $html = "";
     
        if (empty($arr_x)) {
        $html.= '<option value="0" selected>Recherche... </option>';
        }
     
    
        foreach ($new_elemnt as $key => $value) {
          $selected =  '';
          $sexe =  ($value['SEXE']=="H") ? "🧑🏼‍✈️":"👮🏻";

          if (in_array($value['ID_PSR_ELEMENT'], $arr_x)) {
            $html.= '<option value="'.$value['ID_PSR_ELEMENT'].'" selected >'.$sexe.' '.$value['NOM'].' '.$value['PRENOM'].' Tel:'.$value['TELEPHONE'].' </option>';
          }else{
             $html.= '<option value="'.$value['ID_PSR_ELEMENT'].'" >'.$sexe.' '.$value['NOM'].' '.$value['PRENOM'].' Tel:'.$value['TELEPHONE'].' </option>';
          }

          // print_r(in_array("'".$value['ID_PSR_ELEMENT']."'", $arr_x));

      }

      $donne['date_a']        = $this->forma_date($date_a);
      $donne['date_b']        = $this->forma_date($date_b);
      $donne['html']          = $html;
      $donne['commentaires']  = $commentaire;

      return $donne;
                  
  }
  
   function forma_date($date)
   {
        
    $dat=date_create($date);
    $dates = date_format($dat,"Y-m-d H:i");
    return $dates;

   }



  function affectation_new($id='')
  {
   
   $elemnt = $this->get_element_police($id);

   $catego = $this->get_histo_catego($id);

   print_r(json_encode(array('elemnt'=>$elemnt, 'catego'=>$catego)));


    
  }

  


  function save_adress($arr_adress = array())
  {
    
      $donnes_prov = $this->Modele->getRequeteOne('SELECT `PROVINCE_ID` FROM `syst_provinces` WHERE `PROVINCE_NAME` LIKE "%'.$arr_adress['province_id'].'%" AND PAYS_CODE = "'.$arr_adress['pays_id'].'" LIMIT 1 ');

      $cood = explode(',', $arr_adress['latlong_donne']);
     
      if(empty($donnes_prov)) {
         $provData =  array(
                             'PROVINCE_NAME'      => $arr_adress['province_id'],
                             'OBJECTIF'           => 2000000,
                             'PROVINCE_LATITUDE'  => $cood[0],
                             'PROVINCE_LONGITUDE' => $cood[1],
                             'PAYS_CODE'          => $arr_adress['pays_id'],
                           );
          $prov_id_last = $this->Modele->insert_last_id('syst_provinces', $provData);

      }else{

          $prov_id_last = $donnes_prov['PROVINCE_ID'];
      }



      $data_insert = array(
        'PAYS_CODE' => $arr_adress['pays_id'],
        'PROVINCE_ID' => $prov_id_last,
        'COMMUNE_ID' => 0,
        'ZONE_ID' => 0,
        'COLLINE_ID' => 0,
        'LIEU_EXACTE' => str_replace(","," ",$arr_adress['Lieux']),
        'LATITUDE' => $cood[0],
        'LONGITUDE' => $cood[1]
      );

      $table = 'psr_affectatations';
      $id_affect_lieux = $this->Modele->insert_last_id($table, $data_insert);
      return $id_affect_lieux;
  }
  


 public function sendAffectation()
 {


  $Agents = !empty($this->input->post('Agents')) ? $this->input->post('Agents') : array();
  $control_catego = !empty($this->input->post('control_catego')) ? $this->input->post('control_catego') : array();
  $id_control = !empty($this->input->post('id_control')) ? $this->input->post('id_control') : array();
  $id_question_repo = !empty($this->input->post('id_question_repo')) ? $this->input->post('id_question_repo') : array();

  $pays_id = $this->input->post('pays_id');
  $province_id = $this->input->post('province_id');
  $latlong_donne = $this->input->post('latlong_donne');
  $Lieux = $this->input->post('Lieux');

  $DateAff = $this->input->post('DateAff');
  $TempsA = $this->input->post('TempsA');
  $TempsB = $this->input->post('TempsB');
  $Commentaires = $this->input->post('Commentaires');


  $arr_adress = array(
                       'pays_id'=> $pays_id, 
                       'province_id'=> $province_id, 
                       'Lieux'=> $Lieux, 
                       'latlong_donne'=> $latlong_donne, 
                      );

  $id_affect_lieux = $this->save_adress($arr_adress);

  $do = 0;

     if ($id_affect_lieux > 0) {
   
        
        foreach ($Agents as $key => $value) {

            if ($value > 0) {
            

                $update = array('IS_ACTIVE' => 0);
                $test = $this->Modele->update('psr_element_affectation', array('ID_PSR_ELEMENT' => $value), $update);
            
                $data_insert = array(
                                     'ID_PSR_ELEMENT' => $value,
                                     'PSR_AFFECTATION_ID' => $id_affect_lieux,
                                     'DATE_DEBUT' => $TempsA,
                                     'DATE_FIN' => $TempsB,
                                     'COMMENTAIRES' => $Commentaires,
                                     'IS_ACTIVE' => 1,
                                    );

                $table = 'psr_element_affectation';
                $ELEMENT_AFFECT_ID = $this->Modele->insert_last_id($table, $data_insert);

                $data_catego = array(
                                     'ELEMENT_AFFECT_ID' => $ELEMENT_AFFECT_ID,
                                     'control_catego' => $control_catego,
                                     'id_control' => $id_control,
                                     'id_question_repo' => $id_question_repo,
                                    );
                $do = $this->sendMessage_autre(array('id'=>$value));
                $this->save_catego_ctrl($data_catego);
              
            }   

        }


      }
        
      print_r(json_encode($do));
   
 }



 function save_catego_ctrl($datas = array()){

    if (!empty($datas['ELEMENT_AFFECT_ID'])) {

      foreach ($datas['control_catego'] as $key => $catego) {

        if ($datas['ELEMENT_AFFECT_ID'] > 0 && $catego > 0) {
            $data_insert = array(
                      'ELEMENT_AFFECT_ID' => $datas['ELEMENT_AFFECT_ID'],
                      'ID_CATEGORIE' => $catego,
                    );

            $table = 'psr_element_affect_catego_ctrl';

            $CATEGO_CONTROL_ID = $this->Modele->insert_last_id($table, $data_insert);

            $data_cntrl = array(
                          'CATEGO_CONTROL_ID' => $CATEGO_CONTROL_ID,
                          'id_control' => $datas['id_control'],
                          'id_question_repo' => $datas['id_question_repo'],
                          
                        );
        }
        
       
        $this->save_type_ctrl($data_cntrl);
      }

    }

 }




  function save_type_ctrl($datas = array()){

    if (!empty($datas['CATEGO_CONTROL_ID'])) {

      foreach ($datas['id_control'] as $key => $type_cntl) {

            if ($type_cntl > 0 && $datas['CATEGO_CONTROL_ID'] > 0) {
                   $data_insert = array(
                              'CATEGO_CONTROL_ID' => $datas['CATEGO_CONTROL_ID'],
                              'ID_TYPE_CONTROLE' => $type_cntl,
                            );

                $table = 'psr_element_affect_type_ctrl';

                $AFFECT_TYPE_CNTROL_ID = $this->Modele->insert_last_id($table, $data_insert);

                $data_quest = array(
                              'AFFECT_TYPE_CNTROL_ID' => $AFFECT_TYPE_CNTROL_ID,
                              'id_question_repo' => $datas['id_question_repo'],
                              );
        }
        
       
            
        $this->save_question_ctrl($data_quest);
      }

    }

 }




 function save_question_ctrl($datas = array()){

    if (!empty($datas['AFFECT_TYPE_CNTROL_ID'])) {

      foreach ($datas['id_question_repo'] as $key => $quest_cntl) {

        if ($quest_cntl > 0 && $datas['AFFECT_TYPE_CNTROL_ID'] > 0) {
        
            $data_insert = array(
                          'AFFECT_TYPE_CNTROL_ID' => $datas['AFFECT_TYPE_CNTROL_ID'],
                          'ID_CONTROLES_QUESTIONNAIRES' => $quest_cntl,
                        );

            $table = 'psr_element_affect_ctrl_question';

            $ID_CONTROLES_QUESTIONNAIRES  = $this->Modele->insert_last_id($table, $data_insert);
         
        }
       

      }

    }

 }









  public function get_control_catego(){

    $inputs = !empty($this->input->post('values_id_control')) ? $this->input->post('values_id_control') : array();
    $donne = "";
    $condiction = "";
    $html = "";

       
     
      if (!empty($inputs)) {
        
        foreach ($inputs as $key => $value) {
          if($value > 0){
            $donne.= $value.",";
          }
        }

        $donne .= "@";
        $donnes = str_replace(",@","",$donne);
        
        if (in_array("1", $inputs)){
           $condiction = (' WHERE ID_CATEGORIE in('.$donnes.')'); 
        }

        $get_donne = $this->Model->getRequete("SELECT `ID_QUESTIONNAIRE_CATEGORIES`,`CATEGORIES` FROM `quetionnaire_categories` ".$condiction." ORDER BY `CATEGORIES`");
        
        foreach ($get_donne as $key => $value) {
          $html .= '<option value="'.$value['ID_QUESTIONNAIRE_CATEGORIES'].'">'.$value['CATEGORIES'].' </option>';
        }
        
      }

      print_r(json_encode(array('htmls'=>$html)));
    
  }

   

     function get_cateco_contrl_une($id=0)
  {
   $catego = $this->Model->getRequeteOne('SELECT `ID_CATEGORIE`,`DESCRIPTION` FROM `historiques_categories` WHERE `ID_CATEGORIE`='.$id);
   return $catego['DESCRIPTION'];
  }



  function get_catego_ctrlss($donnes = 0, $arr_x = array())
  {
        $condiction = ' WHERE ID_CATEGORIE='.$donnes;

        $html = "";

        $get_donne = $this->Model->getRequete("SELECT `ID_QUESTIONNAIRE_CATEGORIES` ,`CATEGORIES`  FROM `quetionnaire_categories` ".$condiction." ORDER BY `CATEGORIES` ");
        $i = 0;
        foreach ($get_donne as $key => $value) {
          $i ++;
            if (in_array($value['ID_QUESTIONNAIRE_CATEGORIES'], $arr_x)) {
                 $html.= '<option value="'.$value['ID_QUESTIONNAIRE_CATEGORIES'].'" selected >'.$i.'. '.$value['CATEGORIES'].' </option>';
            }else{
               $html.= '<option value="'.$value['ID_QUESTIONNAIRE_CATEGORIES'].'" >'.$i.'. '.$value['CATEGORIES'].' </option>';
            }
        }

        return $html;
        
  }



  function getTypeControl(){

      $inputs = !empty($this->input->post('values_id_control')) ? $this->input->post('values_id_control') : array();

      $condiction = "";
      $html = "";
      if (!empty($inputs)) {
        $i = 0;
        foreach ($inputs as $key => $value) {
          $i ++;
          $html.= '<optgroup label="'.$i.'. '.$this->get_cateco_contrl_une($value).'"> '.$this->get_catego_ctrlss($value).'</optgroup>';
        }

      }

      print_r(json_encode(array('htmls'=>$html)));

      
    }


   
   
   function get_question(){

      $inputs = !empty($this->input->post('values_id_control')) ? $this->input->post('values_id_control') : array();

      $condiction = "";
      $html = "";
      if (!empty($inputs)) {
        $i = 0;
        foreach ($inputs as $key => $value) {
          $i ++;
          $html.= '<optgroup label="'.$i.'. '.$this->get_cateco_contrl($value).'"> '.$this->get_question_for($value).'</optgroup>';
        }

      }

      print_r(json_encode(array('htmls'=>$html)));

      
    }


  
  function get_cateco_contrl($id=0)
  {
   $catego = $this->Model->getRequeteOne('SELECT `ID_QUESTIONNAIRE_CATEGORIES` ,`CATEGORIES`  FROM `quetionnaire_categories` WHERE ID_QUESTIONNAIRE_CATEGORIES='.$id);
   return $catego['CATEGORIES'];
  }




  function get_question_for($donnes= 0)
  {
        $condiction = ' WHERE ID_QUESTIONNAIRE_CATEGORIES ='.$donnes;

        $html = "";

        $get_donne = $this->Model->getRequete("SELECT `ID_CONTROLES_QUESTIONNAIRES`,`INFRACTIONS`,`MONTANT` FROM `autres_controles_questionnaires`  ".$condiction." ORDER BY `INFRACTIONS`,`MONTANT` ");
        $i = 0;
        foreach ($get_donne as $key => $value) {
          $i ++;
          $html .= '<option value="'.$value['ID_CONTROLES_QUESTIONNAIRES'].'">'.$i.'. '.$value['INFRACTIONS'].' </option>';
        }

        return $html;
        
  }



  function index()
  {

    if (empty($this->session->userdata('USER_NAME'))) {
      redirect(base_url());
    } else {


      $donne['lieux'] = 0;
      $donne['nonActif'] = 0;
      $donne['actif'] = 0;

      $donne['donne_pnb'] = $this->Model->getRequete('SELECT `ID_PSR_ELEMENT`,`SEXE`,`NOM`,`PRENOM`,`NUMERO_MATRICULE`,`TELEPHONE`,`PHOTO` FROM `psr_elements` WHERE 1 ORDER BY `NOM`,`PRENOM`,`TELEPHONE`');

      $donne['catego_histo'] =  $this->Model->getRequete('SELECT `ID_CATEGORIE`,`DESCRIPTION` FROM `historiques_categories` WHERE 1 ORDER by `DESCRIPTION` ');

      $donne['catego_control'] =  $this->Model->getRequete('SELECT `ID_QUESTIONNAIRE_CATEGORIES` AS ID_TYPE,`CATEGORIES` AS DESCRIPTION FROM `quetionnaire_categories` WHERE 1 ORDER BY `CATEGORIES`');

      $this->load->view('Elements_Pnb_view',$donne);
    }
  }


  function sendMessage(){

    $IdAgents = $this->input->post('IdAgents');
    //$IdAgents = 16;
    $phoneNumber = $this->input->post('phoneNumber');
    $MessageText = $this->input->post('MessageText');

    $police =  !empty($IdAgents) ? $IdAgents : 0;

    $tokens =  $this->Model->getRequete('SELECT u.ID_UTILISATEUR,n.TOKEN,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,e.TELEPHONE FROM notification_tokens n JOIN utilisateurs u on n.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON e.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID WHERE u.PSR_ELEMENT_ID='.$police);




     
    if (!empty($tokens)) {
      
      $tokesss = array();

      $nom = "";

        foreach ($tokens as $key => $value) {

            $tokns = array();
            $tokns['TOKEN'] = $value['TOKEN'];
            $tokns['TO_ID_UTILISATEU'] = $value['ID_UTILISATEUR'];

            $phoneNumber = str_replace(' ','',$value['TELEPHONE']);

            //$nom =  str_replace(' ','',$value['NOM']).' '.str_replace(' ','',$value['PRENOM']).' N° '.str_replace(' ','',$value['NUMERO_MATRICULE'])."";
            $tokesss[] = $tokns;

            $nom = "";
        
        }

        $titre =  "Centre de contrôle";

        $messageAgent = $MessageText;

        $donnes = array(
         'TITRE'=>$titre,
         'CONTENU'=>$messageAgent,
         'tokens'=>$tokesss
        );

        $this->notifications->notificationApk($donnes);

        $data = array(
          'USER_ID'=>$this->session->userdata('USER_ID'),
          'MESSAGE'=> $messageAgent,
          'TELEPHONE'=>$phoneNumber,
          'NUMERO_PLAQUE'=>'PSR',
          'IS_AGENT_PSR'=>1,
          'STATUT'=>1,
          'ID_PSR_ELEMENT'=>$IdAgents
        );

        //$this->notifications->send_sms_smpp($phoneNumber, $messageAgent);


        $test = $this->Model->create('notifications',$data);



        if ($test) {
          echo '1';
        }else{
          echo '0';
        }
        
        exit();


    }
    
  

   echo '0';

  }





  function get_carte($value = ''){

    $zoom = 12;
    $coord = '-3.3752982,29.2843385';
    $Agents = $this->input->post('Agents');



    $ID = $this->input->post('ID');
    $crit = '';

   

    $donne = "";
    $condiction = "";

    if (!empty($Agents)) {
        
        foreach ($Agents as $key => $value) {
          $donne.= $value.",";
        }

        $donne .= "@";
        $donnes = str_replace(",@","",$donne);
        
        $condiction = (' AND ea.ID_PSR_ELEMENT in('.$donnes.')'); 
    }

   
    $requete = $this->Model->getRequete('SELECT e.TELEPHONE,e.PHOTO, u.IS_ACTIF,NOM_UTILISATEUR,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,u.LATITUDE as lat,u.LONGITUDE as log, a.LATITUDE,a.LONGITUDE,u.PSR_ELEMENT_ID,ea.DATE_DEBUT,ea.DATE_FIN,a.LIEU_EXACTE FROM utilisateurs u LEFT JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN psr_element_affectation ea ON ea.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID JOIN psr_affectatations a on a.PSR_AFFECTATION_ID=ea.PSR_AFFECTATION_ID WHERE 1 AND `PROFIL_ID` IN(6,12,1) AND ea.IS_ACTIVE=1 '.$condiction);

    
    $actif = 0;
    $nonActif = 0;

    $i = 0;

    $totalPnb = 0;

    $data_donne = "";

    foreach ($requete as $key => $value) {

      $i++;
      
      $lat = $value['LATITUDE'];
      $long = $value['LONGITUDE'];

      $lat_user = !empty($value['lat']) ? $value['lat'] : $lat;
      $long_user = !empty($value['log']) ? $value['log'] : $long;

      $color = '';
      $marker = '';

      if ($value['IS_ACTIF'] == 1) {
        $color = 'FF8000';
        $marker = '';
        $actif++;
      }

      if ($value['IS_ACTIF'] == 0) {
        $color = '3e9ceb';
        $marker = 'amusement';
        $nonActif++;
      }
     
      $total = $actif + $nonActif;
      $totalPnb = number_format($total, 0, ',', ' ');

      $nom = $this->remplace_lettre($value['NOM']);
      $Prenom = $this->remplace_lettre($value['PRENOM']);
      $matricule = $this->remplace_lettre($value['NUMERO_MATRICULE']);

      $statut = $this->remplace_lettre($value['IS_ACTIF']);
      $email = $this->remplace_lettre($value['NOM_UTILISATEUR']);
      $dateA = $this->remplace_lettre($value['DATE_DEBUT']);
      $dateB = $this->remplace_lettre($value['DATE_FIN']);
      $lieu = $this->remplace_lettre($value['LIEU_EXACTE']);

      $phone = $this->remplace_lettre($value['TELEPHONE']);

      $photo = !empty($value['PHOTO']) ? $value['PHOTO'] : base_url("upload/personne.png");

      $idpolice = $value['PSR_ELEMENT_ID'];

      

      $data_donne .= $lat . '<>' . $long . '<>' . $nom . '<>' . $Prenom. '<>' . $matricule . '<>' . $statut . '<>' . $photo . '<>' . $idpolice . '<>' . $email . '<>' . $dateA . '<>' . $dateB . '<>' . $lieu . '<>' . $phone . '<>'. $lat_user . '<>' . $long_user . '<>' . '$';
    }



    $data_poste = "";
      
    $affectation = $this->Model->getRequete('SELECT `PSR_AFFECTATION_ID` as id,p.PROVINCE_NAME,c.COMMUNE_NAME,z.ZONE_NAME,co.COLLINE_NAME,a.LIEU_EXACTE,a.LATITUDE,a.LONGITUDE, (SELECT COUNT(e.PSR_AFFECTATION_ID) FROM psr_element_affectation e WHERE e.PSR_AFFECTATION_ID=id AND e.IS_ACTIVE=1 GROUP BY e.PSR_AFFECTATION_ID) as nmbrePNB FROM psr_affectatations a LEFT JOIN syst_provinces p on p.PROVINCE_ID=a.PROVINCE_ID LEFT JOIN syst_communes c on c.COMMUNE_ID=a.COMMUNE_ID LEFT JOIN syst_zones z on z.ZONE_ID=a.ZONE_ID LEFT JOIN syst_collines co ON co.COLLINE_ID=a.COLLINE_ID  WHERE a.LIEU_EXACTE !="" and a.LATITUDE !=""');
      
      $lieu = 0;
    
      foreach ($affectation as $key => $value) {

      $lieu++;

      $lat=floatval(trim($value['LATITUDE']));
      $long=floatval(trim($value['LONGITUDE']));

      $color = 'green';
      $royon = 0.5;

      $lieux = $this->remplace_lettre($value['LIEU_EXACTE']);
      //$lieux = 'test';
      $provice = $this->remplace_lettre($value['PROVINCE_NAME']);
      $commune = $this->remplace_lettre($value['COMMUNE_NAME']);
      $zone = $this->remplace_lettre($value['ZONE_NAME']);
      $colline = $this->remplace_lettre($value['COLLINE_NAME']);

      $id = $value['id'];

      $nmbrePNB = !empty($value['nmbrePNB']) ? $value['nmbrePNB'] : 0;

      $data_poste .= $lat.'<>'.$long.'<>'.$lieux.'<>'.$provice.'<>'.$commune . '<>' . $zone . '<>'.$colline.'<>'.$nmbrePNB.'<>'.$id .'<>'.$royon .'<>'. '$';
      
      }
  

   $data['gernier'] = $this->Model->getRequeteOne('SELECT `LATITUDE`,`LONGITUDE` FROM `psr_affectatations` WHERE 1 ORDER BY `PSR_AFFECTATION_ID` DESC LIMIT 1 ');
    
    
    $data['data_poste'] = $data_poste;
   

    $data['data_donne'] = $data_donne;
 

    $data['actif'] = $actif;
    $data['lieux'] = $lieu;
    $data['nonActif'] = $nonActif;
    $data['totalPnb'] = $totalPnb;

    $data['PROVINCE_ID'] = 3;

    $data['provinces'] = $this->Model->getRequete('SELECT * FROM syst_provinces WHERE 1 ');

    $data['zoom'] = $zoom;
    $data['coord'] = $coord;

    

    // $donne['catego_histo'] =  $this->Model->getRequete('SELECT `ID_CATEGORIE`,`DESCRIPTION` FROM `historiques_categories` WHERE 1 ORDER by `DESCRIPTION` ');

    // $donne['catego_control'] =  $this->Model->getRequete('SELECT `ID_QUESTIONNAIRE_CATEGORIES` AS ID_TYPE,`CATEGORIES` AS DESCRIPTION FROM `quetionnaire_categories` WHERE 1 ORDER BY `CATEGORIES`');



    $map = $this->load->view('Get_Element_pnb', $data, TRUE);
    $output = array('cartes' => $map, 'id' => $ID, 'autreData'=>$data);


    echo json_encode($output);
  }




   function check_new()
  {

    $get = $this->Model->getRequeteOne('SELECT COUNT(*) AS Nbr FROM historiques WHERE NEW=0');
    $send = 0;
    if ($get['Nbr'] > 0) {
      $send = 1;
      $this->Model->update('historiques', array('NEW' => 0), array('NEW' => 1));
    }


    $output = array('nbr' => $send);
    echo json_encode($output);
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



  //  FONCTION POUR CALCULER LA DISTANCE
         function calcule_distance($point1,$point2,$unite="km",$precision=2)
         {
            //recuperation de l'instance de codeigniter
              $ci = & get_instance();



              $degrees = rad2deg(acos((sin(deg2rad($point1["lat"]))*sin(deg2rad($point2["lat"]))) + (cos(deg2rad($point1["lat"]))*cos(deg2rad($point2["lat"]))*cos(deg2rad($point1["long"]-$point2["long"])))));
              // Conversion de la distance en degrés à l'unité choisie (kilomètres, milles ou milles nautiques)
              switch($unite) {
              case 'km':
              $distance = $degrees * 111.13384; // 1 degré = 111,13384 km, sur base du diamètre moyen de la Terre (12735 km)
              break;
              case 'mi':
              $distance = $degrees * 69.05482; // 1 degré = 69,05482 milles, sur base du diamètre moyen de la Terre (7913,1 milles)
              break;
              case 'nmi':
              $distance =  $degrees * 59.97662; // 1 degré = 59.97662 milles nautiques, sur base du diamètre moyen de la Terre (6,876.3 milles nautiques)
              }
              return array(round($distance, $precision)." ".$unite);     

        }





















function sendMessage_autre($Agents = array()){

          if (!empty($Agents['id'])) {
        
              $tokens =  $this->Model->getRequete('SELECT u.ID_UTILISATEUR,n.TOKEN,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,e.TELEPHONE,a.LIEU_EXACTE,a.LATITUDE,a.LONGITUDE,eff.DATE_DEBUT,eff.DATE_FIN FROM notification_tokens n JOIN utilisateurs u on n.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON e.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID LEFT JOIN psr_element_affectation eff on e.ID_PSR_ELEMENT=eff.ID_PSR_ELEMENT LEFT JOIN psr_affectatations a on eff.PSR_AFFECTATION_ID=a.PSR_AFFECTATION_ID WHERE 1 and eff.IS_ACTIVE=1  and u.PSR_ELEMENT_ID ='.$Agents['id']);
               
              if (!empty($tokens)) {
                
                $tokesss = array();

                $nom = "";

                foreach ($tokens as $key => $value) {

                  $tokns = array();
                  $tokns['TOKEN'] = $value['TOKEN'];
                  $tokns['TO_ID_UTILISATEU'] = $value['ID_UTILISATEUR'];

                  $phoneNumber = str_replace(' ','',$value['TELEPHONE']);

                  $nom =  str_replace(' ','',$value['NOM']).' '.str_replace(' ','',$value['PRENOM']).' N° '.str_replace(' ','',$value['NUMERO_MATRICULE'])."";
                  $tokesss[] = $tokns;
                  
                  }
                  

                  $titre =  "Affectation";

                  $temps = $this->notifications->ago($value['DATE_DEBUT'],$value['DATE_FIN']);

                  $messageAgent = "Agent ".$nom.",Vous êtes affecté pour ".$temps." ".$value['LIEU_EXACTE'].", le système tient compte directement de la nouvelle affectation.Veuillez vous présenter à votre nouveau poste.";

                  $donnes = array(
                   'TITRE'=>$titre,
                   'CONTENU'=>$messageAgent,
                   'tokens'=> $tokesss
                  );

                  $this->notifications->notificationApk($donnes);

                  $data = array(
                    'USER_ID'=>$this->session->userdata('USER_ID'),
                    'MESSAGE'=> $messageAgent,
                    'TELEPHONE'=>$value['TELEPHONE'],
                    'NUMERO_PLAQUE'=>'PSR',
                    'IS_AGENT_PSR'=>1,
                    'STATUT'=>1,
                    'ID_PSR_ELEMENT'=>$Agents['id']
                  );

                  //$this->notifications->send_sms_smpp($phoneNumber, $messageAgent);


                  $test = $this->Model->create('notifications',$data);



                  if ($test) {
                    $a = '1';
                  }else{
                    $a = '0';
                  }
                  
                  return $a;
              }
              
           
         }
 

   

  }






}
