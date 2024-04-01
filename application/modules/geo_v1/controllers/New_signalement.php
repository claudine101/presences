<?php

class New_signalement extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }
  public function have_droit()
  {
    if ($this->session->userdata('MAP_SIGNALEMENT') != 1) {
      redirect(base_url());
    }
  }
  function control_rapid(){

    $numeroPlaque = $this->input->post('numeroPlaque');
    $lat = $this->input->post('lat');
    $long = $this->input->post('long');
    $id = $this->input->post('id');

    $donne = array( 'numeroPlaque'  =>  $numeroPlaque,
                    'lat'           =>  $lat,
                    'long'          =>  $long,
                    'controleType'  =>  1
                     );


    /*$data = $this->notifications->control_rapid($donne);*/

    $data =   array('ID_SIGNALEMENT_NEW'  =>  $this->input->post('id_signnew'),
                    'STATUT_ID'           =>  1,
                    'ID_AVIS_SIGNALEMENT' => 1,
                    'ID_UTILISATEUR'      =>  $this->session->userdata('USER_ID'),
                    'DATE_TRAITEMENT'     =>  date('Y-m-d H:i:s')
                     );
    $donne = $this->Modele->create('signalement_civil_agent_histo_traitement', $data);
    
    print_r($data);
  }
  // CONTOLE RAPIDE 
  public function controle_rapide()
  { 
      $NUMERO_PLAQUE = $this->input->post('NUMERO_PLAQUE');
      $ID_SIGNALEMENT_NEW = $this->input->post('ID_SIGNALEMENT_NEW');
      $MONTANT_AMANDE = $this->input->post('MONTANT_AMANDE');
      $ID_AUTRE_CONTROL = $this->input->post('ID_AUTRE_CONTROL');

      // $lat = $this->input->post('lat');
      // $long = $this->input->post('long');

      $lat = "-3.45298";
      $long = "29.68734";
      $donne = array( 'numeroPlaque'  =>  $NUMERO_PLAQUE,
                      'lat'           =>  $lat,
                      'long'          =>  $long,
                      'controleType'  =>  1
                       );
         $data = $this->notifications->control_rapid($donne);
         $result=json_decode($data);
         if(!empty($result))
         { 
             $montants = $this->Modele->getRequeteOne('SELECT MONTANT,MONTANT_TOTAL FROM historiques  WHERE ID_HISTORIQUE='.$result->ID_HISTORIQUE );
            $data = array(
              'HAS_SIGNALEMENTS' =>1,
              'MONTANT_SIGNALEMENTS' => $MONTANT_AMANDE,
              'MONTANT' => $montants['MONTANT']+$MONTANT_AMANDE,
              'MONTANT_TOTAL' =>$montants['MONTANT_TOTAL']+$MONTANT_AMANDE,
              'ID_SIGNALEMENT' => $ID_AUTRE_CONTROL,
             );
            $this->Modele->update('historiques', array('ID_HISTORIQUE' =>$result->ID_HISTORIQUE), $data);


      $get=$this->Modele->getOne('signalement_civil_agent_new',array('ID_SIGNALEMENT_NEW'=>$ID_SIGNALEMENT_NEW));

      if(!empty($get))
      {
          $NUMERO_PLAQUE = $this->input->post('NUMERO_PLAQUE');

          if (!empty($NUMERO_PLAQUE)) {
            $data = array(
                'ID_ALERT_STATUT' => 1,
                'COMMENTAIRE' => $this->input->post('COMMENTAIRE'),
                'PLAQUE_NUMERO' => $this->input->post('NUMERO_PLAQUE')
              );
          }else{
            $data = array(
                'ID_ALERT_STATUT' => 1,
                'COMMENTAIRE' => $this->input->post('COMMENTAIRE'),
                // 'PLAQUE_NUMERO' => $this->input->post('PLAQUE_NUMERO')
              );
          }
      }
      $this->Modele->update('signalement_civil_agent_new',array('ID_SIGNALEMENT_NEW'=>$ID_SIGNALEMENT_NEW),$data);

      $data_insert = array(
        'ID_SIGNALEMENT_NEW' => $ID_SIGNALEMENT_NEW,
        'STATUT_ID' => 1,
        'ID_AVIS_SIGNALEMENT' => 1,//Confirmer
        'ID_UTILISATEUR' => $this->session->userdata('USER_ID'),
        'DATE_TRAITEMENT' => date('Y-m-d'),
      );
      $this->Modele->create('signalement_civil_agent_histo_traitement', $data_insert);
      
      $message='<div class="alert alert-success text-center" id="message">L\'action est faite avec succès</div>';
      $donnes =  array('message'=>$message,'result'=>$result);

            echo  json_encode($donnes);
         }
         else{

         }
  }
  function get_detail_signal($id = null){
      $vehicule = $this->Modele->getRequeteOne('SELECT s.*,ty.DESCRIPTION as TYPE_SIGNAL,ty.IMAGE,st.COLOR,ty.MARK,st.NOM as STATUT, u.PRENOM_CITOYEN,u.NOM_CITOYEN,u.SEXE,u.PSR_ELEMENT_ID,e.NOM as NOM_AGENT, e.PRENOM as PRENOM_AGENT, e.TELEPHONE AS TEL_AGENT, e.SEXE AS SEXE_AGENT, u.PSR_ELEMENT_ID,u.NOM_UTILISATEUR FROM signalement_civil_agent_new s JOIN civil_alerts_types ty ON s.ID_CATEGORIE_SIGNALEMENT=ty.ID_TYPE LEFT JOIN civil_alerts_statuts st on s.ID_ALERT_STATUT=st.ID_ALERT_STATUT LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=s.ID_UTILISATEUR LEFT JOIN psr_elements e on e.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID WHERE ID_SIGNALEMENT_NEW=' . $id);

    $donne =  $this->Modele->getRequete('SELECT q.ID_CONTROLES_QUESTIONNAIRES,INFRACTIONS,q.MONTANT,r.REPONSE_DECRP FROM autres_controles c LEFT JOIN autres_controles_questionnaires q on q.ID_CONTROLES_QUESTIONNAIRES=c.ID_CONTROLES_QUESTIONNAIRES LEFT JOIN autres_contr_quest_rp r on r.ID_REPONSE=c.ID_REPONSE WHERE c.ID_CONTROLE_PLAQUE= ' . $vehicule['ID_AUTRE_CONTROL']);
    $test = '<div class="form-group form-check">
                  <table width="100%" class="table table-borderless table-sm table-striped ">';

    $totals = 0;
     if ($vehicule['PSR_ELEMENT_ID'] > 0) {
            $nom = $vehicule['NOM_AGENT']." ".$vehicule['PRENOM_AGENT'];
            $sex =  "";
            $phone = $vehicule['TEL_AGENT'];
            
            if ($vehicule['SEXE_AGENT'] == "H"){
              $sex.= "Mr l'agent,";
            }else{
              $sex.= "Md l'agent,";
            }


          }else{
            $nom = $vehicule['PRENOM_CITOYEN']." ".$vehicule['NOM_CITOYEN'];
            $sex = "";
            $phone = $vehicule['NOM_UTILISATEUR'];

            if ($vehicule['SEXE'] == 0){
               $sex .= "Mr,";
            }else{
              $sex .= "Md,";
            }

          }

          if ($vehicule['ID_CATEGORIE_SIGNALEMENT'] > 2) {
            $prefix = "";
          }else{
            $prefix = "Signalement pour ";
          }

          if ($vehicule['ID_CATEGORIE_SIGNALEMENT'] == 1 && $vehicule['HAVE_SEE_PLAQUE'] == 1) {
            $plaques = '&nbsp; Plaque:  <b> '.$vehicule['PLAQUE_NUMERO'].'</b><br>';
          }else{
            $plaques = "";
          }





    $autre ="";
   

    foreach ($donne as $key => $value) {

      $totals += $value["MONTANT"];

      $infra =  (!empty($value["REPONSE_DECRP"])) ? $value["INFRACTIONS"]. ', <b>' . $value["REPONSE_DECRP"] . '</b>' : $value["INFRACTIONS"];
     
      $autre .= '
              <tr>
               <td>
               <input type="checkbox" onchange="save_data()" class="form-check-input" name="donneIfra" title="' . $value["INFRACTIONS"] . '=>' . $value["REPONSE_DECRP"] . ' ' . number_format($value["MONTANT"], 0, ',', ' ') . ' FBU"  id="donneIfra' . $value["ID_CONTROLES_QUESTIONNAIRES"] . '" value="' . $value["MONTANT"] . '" checked>
                <label class="form-check-label" for="donneIfra' . $value["ID_CONTROLES_QUESTIONNAIRES"] . '">' . $infra. '</label>
               </td>

               <td width="20%">
               <span style="float:right">' . number_format($value["MONTANT"], 0, ',', ' ') . '</span> 
               </td>

              </tr>
              ';
    }


     $test .= '
              <tr>
               <td width="60%"><b>Incidents</b>
               </td>

               <td width="40%">
               <span style="float:right"><span id="TotaleSomme">' . number_format($totals, 0, ',', ' ') . '</span>  ' .$vehicule['CURRENT'].'</span> 
               </td>

              </tr>
              '.$autre;


    $test .= '</table>
                    
              <p class="font-italic mb-0">' . $vehicule['DESCRIPTION_PLAQUE'] . '</p>';


    $profils = base_url("upload/personne.png");
    $image1 = !empty($vehicule['IMAGE_UNE']) ? '<div class="col-lg-6 mb-2 pr-lg-1"><img src="' . $vehicule['IMAGE_UNE'] . '" alt="" class="img-fluid rounded shadow-sm"></div>' : '';
    $image2 = !empty($vehicule['IMAGE_DEUX']) ? '<div class="col-lg-6 mb-2 pr-lg-1"><img src="' . $vehicule['IMAGE_DEUX'] . '" alt="" class="img-fluid rounded shadow-sm"></div>' : "";
    $image3 = !empty($vehicule['IMAGE_TROIS']) ? '<div class="col-lg-6 mb-2 pr-lg-1"><img src="' . $vehicule['IMAGE_TROIS'] . '" alt="" class="img-fluid rounded shadow-sm"></div>' : "";

    $plaques = !empty($vehicule['PLAQUE_NUMERO']) ? '<h4 class="mt-0 mb-0 text-left"><b>'.$vehicule['PLAQUE_NUMERO'].'<b></h4><input type="hidden" id="plaque_numbers" value="'.$vehicule['PLAQUE_NUMERO'].'" >' : '<label class="mt-0 mb-0 text-left">Numéro de la plaque <label> &nbsp; &nbsp; <input type="text" id="plaque_numbers" value="'.$vehicule['PLAQUE_NUMERO'].'">';


    $datas = '<div class="row py-1 px-1">
      <div class="col-xl-12 col-md-12 col-sm-12 mx-auto">

        <!-- Profile widget -->
        <div class="bg-white shadow rounded overflow-hidden">
            
            <div class="px-12 pt-0 pb-12 bg-dark row">
            <div class="col-md-12">

                <div class="media align-items-end profile-header" style="padding: 5px">
                   '. $plaques.'

                </div>
                </div>
            </div>
              <div class="col-md-12">

                    <form>
                      
                      ' . $test . '


                       <input type="hidden" id="ID_SIGNALEMENT_NEW" name="ID_SIGNALEMENT_NEW" value="' . $id . '">
                       <input type="hidden" id="ID_AUTRE_CONTROL" name="ID_AUTRE_CONTROL" value="' . $vehicule['ID_AUTRE_CONTROL'] . '">
                       <input type="hidden" id="ID_AUTRE_CONTROL" name="ID_AUTRE_CONTROL" value="' . $vehicule['ID_AUTRE_CONTROL'] . '">
                       <input type="hidden" id="MONTANT_AMANDE" name="MONTANT_AMANDE" value="' . $totals . '">
                       <input type="hidden" id="ID_HISTORIQUE" name="ID_HISTORIQUE" value="' . $vehicule['ID_SIGNALEMENT_NEW'] . '">

                       <div class="form-group">
                        <label for="exampleInputEmail1">Commentaire</label>
                        <textarea rows="3" class="form-control" id="COMMENTAIRE_VALID" aria-describedby="emailHelp"></textarea rows="2">
                        
                      </div>

                    </form>

                 </div>
            </div>

            <div class="py-4 px-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <label>Attaches</label>
                </div>
                <div class="row">
                   ' . $image1 . '
                   ' . $image2 . '
                   ' . $image3 . '
                    
                </div>
               ';

       

    $titre = '<div class="profile mr-2"><h4 class="mt-0 mb-0 text-left">Auteur ' . $sex . ' ' . $nom . ' </h4>
                    <span class="small mb-4 text-left"> Tél : ' . $phone . '</span><br>
                    <span class="small mb-4 text-left"> statut : ' . $vehicule['STATUT'] . '</span><br>
                    <span class="small mb-4 text-left"> Date : ' . $vehicule['DATE_SIGNAL'] . '</span>
                    
                    </div>';

      $btn1 = '';
      $btn2 = '';
      $btn3 = '';

      if ($vehicule['ID_ALERT_STATUT']==0) {
        $btn3 = "<div id='voir'><button id='idbutton' type='button'  onclick='save()' class='btn btn-primary btn-md' >Prévalider</button></div>";
      }
      else{
        $btn3 = "<button id='idbutton' type='button' id='' onclick='show_vehicule()' class='btn btn-primary btn-md' >Voir les documents</button>";
      }
      if ($vehicule['IS_ANNULE']==0) {
        $btn2 = '<button type="button" class="btn btn-info"  onclick="demissio_modal('.$vehicule['ID_SIGNALEMENT_NEW'].')">Annuler</button>';
      }
      $btn4 = '<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>';
    
     
    $btn_data = ''.$btn1.' '.$btn3.''.$btn2.''.$btn4;

    $donnes =  array('titre' => $titre, 'donne' => $datas, 'btn_data'=>$btn_data);

    echo json_encode($donnes);


  }

  function check_position()
  {
      $id = $this->input->post('id');
      $get=$this->Modele->getOne('signalement_civil_agent_new',array('ID_SIGNALEMENT_NEW'=>$id));

      if(!empty($get))
      {
          $PLAQUE_NUMERO = $this->input->post('PLAQUE_NUMERO');

          if (!empty($PLAQUE_NUMERO)) {
            $data = array(
                'ID_ALERT_STATUT' => 1,
                'COMMENTAIRE' => $this->input->post('COMMENTAIRE'),
                'PLAQUE_NUMERO' => $this->input->post('PLAQUE_NUMERO')
              );
          }else{
            $data = array(
                'ID_ALERT_STATUT' => 1,
                'COMMENTAIRE' => $this->input->post('COMMENTAIRE'),
                // 'PLAQUE_NUMERO' => $this->input->post('PLAQUE_NUMERO')
              );
          }
      }
      $this->Modele->update('signalement_civil_agent_new',array('ID_SIGNALEMENT_NEW'=>$id),$data);

      $data_insert = array(
        'ID_SIGNALEMENT_NEW' => $id,
        'STATUT_ID' => 1,
        'ID_AVIS_SIGNALEMENT' => 1,//Confirmer
        'ID_UTILISATEUR' => $this->session->userdata('USER_ID'),
        'DATE_TRAITEMENT' => date('Y-m-d'),
      );
      $this->Modele->create('signalement_civil_agent_histo_traitement', $data_insert);
      
      $message='<div class="alert alert-success text-center" id="message">L\'action est faite avec succès</div>';
      $donnes =  array('message'=>$message);
      echo json_encode($donnes);
  }


  function demissio_modal()
  {
      $id = $this->input->post('id');
      $get=$this->Modele->getOne('signalement_civil_agent_new',array('ID_SIGNALEMENT_NEW'=>$id));

      if(!empty($get))
      {
          $PLAQUE_NUMERO = $this->input->post('PLAQUE_NUMERO');
          
          if (!empty($PLAQUE_NUMERO)) {
            $data = array(
                'IS_ANNULE' => 1,
                'COMMENTAIRE' => $this->input->post('COMMENTAIRE'),
                'PLAQUE_NUMERO' => $this->input->post('PLAQUE_NUMERO')
              );
          }else{
            $data = array(
                'IS_ANNULE' => 1,
                'COMMENTAIRE' => $this->input->post('COMMENTAIRE'),
                // 'PLAQUE_NUMERO' => $this->input->post('PLAQUE_NUMERO')
              );
          }
      }
      $this->Modele->update('signalement_civil_agent_new',array('ID_SIGNALEMENT_NEW'=>$id),$data);

      $data_insert = array(
        'ID_SIGNALEMENT_NEW' => $id,
        'STATUT_ID' => 1,
        'ID_AVIS_SIGNALEMENT' => 0,//Annuler
        'ID_UTILISATEUR' => $this->session->userdata('USER_ID'),
        'DATE_TRAITEMENT' => date('Y-m-d'),
      );
      $this->Modele->create('signalement_civil_agent_histo_traitement', $data_insert);
      
      $message='<div class="alert alert-success text-center" id="message">L\'action est faite avec succès</div>';
      $donnes =  array('message'=>$message);
      echo json_encode($donnes);
  }












  function index(){

      $data['donne'] = null;

      $this->load->view('New_signalement_view', $data);
  }


  public function Recherche()
  {
      $key_search = $this->input->post('term');

      $requete_data = $this->Model->getRequete("SELECT u.ID_UTILISATEUR, u.NOM_CITOYEN,u.PRENOM_CITOYEN, u.PROFIL_ID, e.NOM, e.PRENOM,p.STATUT FROM utilisateurs u LEFT JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT JOIN profil p on p.PROFIL_ID=u.PROFIL_ID WHERE 1 AND (e.NOM LIKE '%".$key_search."%' OR e.PRENOM LIKE '%".$key_search."%' OR u.NOM_CITOYEN LIKE '%".$key_search."%') AND p.PROFIL_ID in(7,6)");


      $count = count($requete_data); ;

      if ($count<=5) {
        $result_data= '<ul class="list-group">';
      }else{
        $result_data= '<ul class="list-group scroller">';
      }
      
      if (!empty($requete_data)) {
        foreach ($requete_data as $key )
        {
           if ($key['PROFIL_ID']==6) {
              $string =  $key['NOM'].' '.$key['NOM']. '('.$key['STATUT'].')';
           }else{
              $string =  $key['NOM_CITOYEN'].' '.$key['PRENOM_CITOYEN']. '('.$key['STATUT'].')';
           }

          $result_data.='<li class="list-group-item" >
             <a style="color:black;font-size:13px" onclick="get_data('.$key['ID_UTILISATEUR'].')"  href="javascript:;" title="'.$string.'" class="title"><b>'.$string.'</b></a>
        </li>';

        }
      }
      
      $result_data.='</ul>';

      $data_empty='<ul class="list-group"><li class="list-group-item" >Aucun élément a été trouvé avec <span style="color:blue"> '.$key_search.'</span></li></ul>';

      if (empty($key_search)) {

        $data_empty = '';
        $result_data = '';
      }

      if(empty($requete_data))
      {
        echo $data_empty;
      }
      else
      {
        echo $result_data;
      }
    }





  function get_carte(){

    $zoom = 12;
    $coord = '-3.3752982,29.2843385';

    $data['zoom'] = $zoom;
    $data['coord'] = $coord;

    $NUMERO_PLAQUE=$this->input->post('NUMERO_PLAQUE');
    $DATE1=$this->input->post('DATE1');
    $DATE2=$this->input->post('DATE2');
    $ID_TYPE=$this->input->post('ID_TYPE');
    $ID_ALERT_STATUT= $this->input->post('ID_ALERT_STATUT');
    $ID_UTILISATEUR=$this->input->post('ID_UTILISATEUR');

    $conduction="";

    if (!empty($NUMERO_PLAQUE)){
     $conduction.="  AND  s.PLAQUE_NUMERO=".$NUMERO_PLAQUE.""; 
     }

    if ($DATE1 != "" AND $DATE2 !=""){
       $conduction.="  AND s.DATE_SIGNAL BETWEEN date_format(".$DATE1.",'%Y %m %d') AND date_format(".$DATE2.",'%Y %m %d') "; 
     }

    if (!empty($ID_TYPE)){
     $conduction.="  AND  s.ID_CATEGORIE_SIGNALEMENT=".$ID_TYPE.""; 
     }

    // if(!empty($ID_ALERT_STATUT)){
    //   $conduction.="  AND  s.ID_ALERT_STATUT=".$ID_ALERT_STATUT."";
    // }

    if(!empty($ID_UTILISATEUR)){
     $conduction.="  AND  s.ID_UTILISATEUR=".$ID_UTILISATEUR."";
    }


    $id_max = $this->Model->getRequeteOne('SELECT max(ID_SIGNALEMENT_NEW) as id FROM signalement_civil_agent_new WHERE 1 ');

    $gets = $this->Model->getRequete('SELECT s.*,ty.DESCRIPTION as TYPE_SIGNAL,ty.IMAGE,st.COLOR,ty.MARK,st.NOM as STATUT, u.PRENOM_CITOYEN,u.NOM_CITOYEN,u.SEXE,u.PSR_ELEMENT_ID,e.NOM as NOM_AGENT, e.PRENOM as PRENOM_AGENT, e.TELEPHONE AS TEL_AGENT, e.SEXE AS SEXE_AGENT, u.PSR_ELEMENT_ID,u.NOM_UTILISATEUR FROM signalement_civil_agent_new s JOIN civil_alerts_types ty ON s.ID_CATEGORIE_SIGNALEMENT=ty.ID_TYPE LEFT JOIN civil_alerts_statuts st on s.ID_ALERT_STATUT=st.ID_ALERT_STATUT LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=s.ID_UTILISATEUR LEFT JOIN psr_elements e on e.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID WHERE 1 '.$conduction.' ');


    // print_r($gets);

    $data['NUMERO_PLAQUE'] = $NUMERO_PLAQUE;
    $data['DATE1'] = $DATE1;
    $data['DATE2'] = $DATE2;
    $data['ID_TYPE'] = $ID_TYPE;
    $data['ID_ALERT_STATUT'] = $ID_ALERT_STATUT;


    $data['donne'] = json_encode($gets);
    $data['id_max'] =  $id_max['id'];
    $data['autreData'] =  $data;
    $legande = $this->get_legande();
    $data['markers'] = $legande;
    $map = $this->load->view('New_signalement_view_get', $data, TRUE);
    $output = array('cartes' => $map, 'autreData'=>$data, 'get_legande'=>$legande);

    echo json_encode($output);


  
  }



  function get_legande($criter = null){



    $titre_action = $this->Model->getRequete('SELECT COUNT(s.ID_SIGNALEMENT_NEW) as nbr,ty.DESCRIPTION as TYPE_SIGNAL,ty.IMAGE,ty.ID_TYPE,ty.MARK FROM signalement_civil_agent_new s JOIN civil_alerts_types ty ON s.ID_CATEGORIE_SIGNALEMENT=ty.ID_TYPE  WHERE 1 GROUP BY ty.DESCRIPTION,ty.IMAGE,ty.ID_TYPE,ty.MARK;
 ');

    $html_titr       = "";
    $marker_all      = "";
    $marker_add_all  = "";

    $u =0;
    $filtr_checkbox = "<script>";
    
    $criters =  !empty($criter) ? " and ".$criter." " : " ";

    foreach ($titre_action as $key => $value) {

         $crit = $criters." AND ty.ID_TYPE = ".$value['ID_TYPE']." ";

         $u += $value['nbr'];
         $html_titr .= "<img src='". $value['IMAGE']."' width='15' height='15' style='border-radius:50%;background:#c5c7ca;padding:2px'> &nbsp; <label for='singTilt". $value['ID_TYPE']."' >  ". $value['TYPE_SIGNAL']." </label> (". $value['nbr'].")</b><br>";
         $donne = $this->statut_legand($crit);

         $html_titr .= $donne['checbox'];

         $filtr_checkbox .= $donne['filtre'];

         $marker_all .= $donne['marker']."\n";

         $marker_add_all .= $donne['marker_add']."\n";

         /*$html_titr .= "<img src='". $value['IMAGE']."' width='20' height='20' style='border-radius:50%;background:#c5c7ca;padding:2px'> &nbsp; <input type='checkbox' id='singTilt". $value['IMAGE']."' name='singTilt". $value['ID_TYPE']."'> <label for='singTilt". $value['ID_TYPE']."' >  ". $value['TYPE_SIGNAL']." </label> (". $value['nbr'].")</b><br>";*/

        
    }

    $filtr_checkbox .= "</script>";
    
    return array('total'=> $u,'html_titr'=>$html_titr, 'filtr_checkbox'=>$filtr_checkbox, 'marker_all'=>$marker_all , 'marker_add_all'=>$marker_add_all);


  }



  function statut_legand($criters = null){

    $titre_action = $this->Model->getRequete('SELECT COUNT(s.ID_SIGNALEMENT_NEW) as nbr,ty.ID_TYPE,s.ID_ALERT_STATUT,ast.NOM,ty.MARK,ast.COLOR FROM signalement_civil_agent_new s JOIN civil_alerts_types ty ON s.ID_CATEGORIE_SIGNALEMENT=ty.ID_TYPE JOIN civil_alerts_statuts ast on ast.ID_ALERT_STATUT=s.ID_ALERT_STATUT WHERE 1 '.$criters.' GROUP BY ast.NOM,s.ID_ALERT_STATUT,ty.ID_TYPE,ty.MARK ,ast.COLOR');

    $html_titr = "";
    $check =  " ";

    $marker = "";
    $marker_add = '';

    $u =0;
    foreach ($titre_action as $key => $value) {
         $u += $value['nbr'];
         $html_titr .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='https://a.tiles.mapbox.com/v4/marker/pin-m-". $value['MARK']."+". $value['COLOR'].".png?access_token=pk.eyJ1IjoibWFydGlubWVkaWFib3giLCJhIjoiY2s4OXc1NjAxMDRybzNobTE2dmo1a3ZndCJ9.W9Cm7Pjp25FQ00bII9Be6Q' height='50' ><input type='checkbox' id='singOption".$value['ID_ALERT_STATUT']."_".$value['ID_TYPE']."' checked name='singOption".$value['ID_ALERT_STATUT']."_".$value['ID_TYPE']."'> <label for='singOption".$value['ID_ALERT_STATUT']."_".$value['ID_TYPE']."' >  ". $value['NOM']." </label> (". $value['nbr'].")</b><br>";

         $check .= '
                   $(\'input[name="singOption'.$value['ID_ALERT_STATUT'].'_'.$value['ID_TYPE'].'"]\').click(function(){
                    if($(this).is(":checked")){
                      /*alert(1);*/
                        map.addLayer('.$value['MARK'].$value['ID_TYPE'].'_'.$value['ID_ALERT_STATUT'].');
                    }else if($(this).is(":not(:checked)")){
                        /*alert(0);*/
                        map.removeLayer('.$value['MARK'].$value['ID_TYPE'].'_'.$value['ID_ALERT_STATUT'].');

                    }
                  }); map.addLayer('.$value['MARK'].$value['ID_TYPE'].'_'.$value['ID_ALERT_STATUT'].');   ';

        $marker .= 'var '.$value['MARK'].$value['ID_TYPE'].'_'.$value['ID_ALERT_STATUT'].' =  new L.MarkerClusterGroup();  ';

        $marker_add .= 'if (item[i].ID_CATEGORIE_SIGNALEMENT == '.$value['ID_TYPE'].' && item[i].ID_ALERT_STATUT == '.$value['ID_ALERT_STATUT'].') {
                 '.$value['MARK'].$value['ID_TYPE'].'_'.$value['ID_ALERT_STATUT'].'.addLayer(marke1);
                }';


    } 

    $donne = array('filtre'=>$check, 'checbox'=>$html_titr, 'marker'=>$marker,  'marker_add'=>$marker_add);
    return $donne;



  }

  

}
