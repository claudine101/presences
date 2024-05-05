<?php




class Signalement extends CI_Controller
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
  function saveVerbalisation()
  {

    $infrationsData = $this->input->post("infrationsData");
    $IDsignalement = $this->input->post("IDsignalement");
    $montantAmende = $this->input->post("montantAmende");
    $Imatriculation = $this->input->post("Imatriculation");
    $CommentaireData = $this->input->post("CommentaireData");

    $donne =  array(
      'DESCRIPTION_INFRATION' => $infrationsData,
      'USER_ID' => $this->session->userdata('USER_ID'),
      'ID_ALERT' => $IDsignalement,
      'AMENDE' => $montantAmende,
      'ID_IMMATICULATION' => $Imatriculation,
      'COMMENATAIRE' => $CommentaireData
    );
    $this->Modele->create("historique_signalement", $donne);

    $user = $this->Modele->getRequeteOne('SELECT EMAIL,`NOM_PROPRIETAIRE`,`PRENOM_PROPRIETAIRE`,`TELEPHONE`,NUMERO_PLAQUE,MARQUE_VOITURE FROM `obr_immatriculations_voitures` WHERE `ID_IMMATRICULATION`=' . $Imatriculation);

    $string_msg = $user['NOM_PROPRIETAIRE'] . " " . $user['PRENOM_PROPRIETAIRE'] . "\nvotre véhicule " . $user['MARQUE_VOITURE'] . " immatriculé " . $user['NUMERO_PLAQUE'] . " vient d'être verbalisé pour " . str_replace("\n", ",", $infrationsData) . " Totale: " . number_format($montantAmende, 0, ',', " ") . " FBU à payer dans un délais de 72h";

    $sms = $user['NOM_PROPRIETAIRE'] . " " . $user['PRENOM_PROPRIETAIRE'] . ",votre vehicule " . $user['MARQUE_VOITURE'] . " plaque " . $user['NUMERO_PLAQUE'] . " est verbalise par la RECECA-INKINGI  amende : " . number_format($montantAmende, 0, ',', " ") . " FBU a payer dans un delais de 72h";


    // $reponse = $this->notifications->send_sms_smpp($user['TELEPHONE'], $sms);

    $emailTo =  $user['EMAIL'];

    //$this->notifications->send_mail($emailTo , 'Verbalisation RECECA-INKINGI', null, $string_msg, null);



    $stat = 3;
    $datass =  array(
      'VALIDATION' => 0,
      'STATUT_TRAITEMENT' => 1,
    );

    $datl = array(
      'ID_SIGNALEMET' => $IDsignalement,
      'USER_ID' => $this->session->userdata('USER_ID'),
      'STATUT_TRAITEMENT' => 1,
    );

    $this->Modele->update('civil_alerts', array('ID_ALERT' => $IDsignalement), $datass);

    $table1 = 'histo_validation_signalement';
    $this->Modele->create($table1, $datl);

    $notif_data = array(
      "USER_ID" => $this->session->userdata('USER_ID'),
      "MESSAGE" => $string_msg,
      "TELEPHONE" => $user['TELEPHONE'],
      "NUMERO_PLAQUE" => $user['NUMERO_PLAQUE'],
      "STATUT" => 1,
    );

    $this->Modele->create('notifications', $notif_data);

    print_r(1);

  }


  function get_detail_vehicule($id = 0)
  {

    $vehicule = $this->Modele->getRequeteOne('SELECT am.IMAGE_1,am.IMAGE_2,am.IMAGE_3 ,im.ID_IMMATRICULATION,im.NUMERO_PLAQUE,im.NOM_PROPRIETAIRE,im.PRENOM_PROPRIETAIRE,im.TELEPHONE,c.NOM_CHAUSSE,profil.STATUT,u.NOM_UTILISATEUR,am.CIVIL_DESCRIPTION,am.DATE_INSERTION,am.ID_CONTROLE_PLAQUE FROM civil_alerts am LEFT JOIN chaussee c on c.ID_CHAUSSEE=am.ID_CHAUSSEE JOIN obr_immatriculations_voitures im on im.ID_IMMATRICULATION=am.ID_IMMATICULATION JOIN utilisateurs u on u.ID_UTILISATEUR=am.ID_UTILISATEUR LEFT JOIN profil on profil.PROFIL_ID=u.PROFIL_ID WHERE am.ID_ALERT=' . $id);

    $donne =  $this->Modele->getRequete('SELECT q.ID_CONTROLES_QUESTIONNAIRES,INFRACTIONS,q.MONTANT,r.REPONSE_DECRP FROM autres_controles c JOIN autres_controles_questionnaires q on q.ID_CONTROLES_QUESTIONNAIRES=c.ID_CONTROLES_QUESTIONNAIRES LEFT JOIN autres_contr_quest_rp r on r.ID_REPONSE=c.ID_REPONSE WHERE c.ID_CONTROLE_PLAQUE= ' . $vehicule['ID_CONTROLE_PLAQUE']);

    $test = '<div class="form-group form-check">
                  <table width="100%">';

    $totals = 0;

    $test .= '
              <tr>
               <td width="80%">
               </td>

               <th width="20%">
               <span style="float:right">FBU</span> 
               </th>

              </tr>
              ';

    foreach ($donne as $key => $value) {

      $totals += $value["MONTANT"];

      $infra =  (!empty($value["REPONSE_DECRP"])) ? $value["INFRACTIONS"]. '(' . $value["REPONSE_DECRP"] . ')' : $value["INFRACTIONS"];
     
      $test .= '
              <tr>
               <td width="80%">
               <input type="checkbox" onchange="save_data()" class="form-check-input" name="donneIfra" title="' . $value["INFRACTIONS"] . '(' . $value["REPONSE_DECRP"] . ')' . number_format($value["MONTANT"], 0, ',', ' ') . ' FBU"  id="donneIfra' . $value["ID_CONTROLES_QUESTIONNAIRES"] . '" value="' . $value["MONTANT"] . '" checked>
               <label class="form-check-label" for="donneIfra' . $value["ID_CONTROLES_QUESTIONNAIRES"] . '">' . $infra. '</label></td>

               <th width="20%">
               <span style="float:right">' . number_format($value["MONTANT"], 0, ',', ' ') . '</span> 
               </th>

              </tr>
              ';
    }

    $test .= '
              <tr>
               <th width="80%">
               <label class="form-check-label">Totale</label></th>
               <th width="20%">
               <span style="float:right" id="TotaleSomme">' . number_format($totals, 0, ',', ' ') . '</span> 
               </th>

              </tr>
              ';

    $test .= '</table>
             </div>';

    $profils = base_url("upload/personne.png");
    $image1 = !empty($vehicule['IMAGE_1']) ? '<div class="col-lg-12 mb-2 pr-lg-1"><img src="' . $vehicule['IMAGE_1'] . '" alt="" class="img-fluid rounded shadow-sm"></div>' : '';
    $image2 = !empty($vehicule['IMAGE_2']) ? '<div class="col-lg-6 mb-2 pr-lg-1"><img src="' . $vehicule['IMAGE_2'] . '" alt="" class="img-fluid rounded shadow-sm"></div>' : "";
    $image3 = !empty($vehicule['IMAGE_3']) ? '<div class="col-lg-6 mb-2 pr-lg-1"><img src="' . $vehicule['IMAGE_3'] . '" alt="" class="img-fluid rounded shadow-sm"></div>' : "";


    $datas = '<div class="row py-1 px-1">
      <div class="col-xl-12 col-md-12 col-sm-12 mx-auto">

        <!-- Profile widget -->
        <div class="bg-white shadow rounded overflow-hidden">
            
            <div class="px-4 pt-0 pb-4 bg-dark row">
            <div class="col-md-6">
                <div class="media align-items-end profile-header">
                    <div class="profile mr-3"><img src="' . $profils . '" alt="..." width="130" class="rounded mb-2 img-thumbnail"><a href="#" class="btn btn-dark btn-sm btn-block">' . $vehicule['NOM_PROPRIETAIRE'] . '<br>' . $vehicule['PRENOM_PROPRIETAIRE'] . '</a></div>
                    <div class="media-body mb-5 text-white">
                        <h4 class="mt-0 mb-0">' . $vehicule['NUMERO_PLAQUE'] . '</h4>
                        <p class="small mb-4"> <i class="fa fa-map-marker mr-2"></i>' . $vehicule['NOM_CHAUSSE'] . '</p>
                    </div>
                </div>

            </div>


             <div class="col-md-6">

<form>

 <div class="form-group"><br>
    <label for="exampleInputEmail1">Verbalisation</label><br>
  </div>
  
  ' . $test . '

   <input type="hidden" id="infrationsData" name="infrationsData">
   <input type="hidden" id="IDsignalement" name="IDsignalement" value="' . $id . '">
   <input type="hidden" id="montantAmende" name="montantAmende">
   <input type="hidden" id="Imatriculation" name="Imatriculation" value="' . $vehicule['ID_IMMATRICULATION'] . '">

   <div class="form-group">
    <label for="exampleInputEmail1">Commentaire</label>
    <input type="text" class="form-control" id="CommentaireData" aria-describedby="emailHelp" placeholder="Commentaire ....">
  </div>


  <button type="button" class="btn btn-primary" onclick="saveDonne()">Confirmer</button>
</form>
            </div>

            </div>

           

           
            <div class="bg-light p-4 d-flex justify-content-end text-center">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <h5 class="font-weight-bold mb-0 d-block"></h5><small class="text-muted"> <i class="fa fa-picture-o mr-1"></i>Signaler par ' . $vehicule['STATUT'] . '</small>
                    </li>
                    <li class="list-inline-item">
                        <h5 class="font-weight-bold mb-0 d-block"></h5><small class="text-muted"> <i class="fa fa-user-circle-o mr-1"></i>' . $vehicule['DATE_INSERTION'] . '</small>
                    </li>
                </ul>
            </div>

            <div class="py-4 px-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0">Images</h5><a href="#" class="btn btn-link text-muted"></a>
                </div>
                <div class="row">
                   ' . $image1 . '
                   ' . $image2 . '
                   ' . $image3 . '
                    
                </div>
                <div class="py-4">
                    <h6 class="mb-3">' . $vehicule['STATUT'] . ' commentaire</h6>
                    <div class="p-4 bg-light rounded shadow-sm">
                        <p class="font-italic mb-0">' . $vehicule['CIVIL_DESCRIPTION'] . '</p>
                        
                    </div>
                </div>';

    $titre = '<div class="profile mr-2"><h4 class="mt-0 mb-0 text-center">' . $vehicule['NUMERO_PLAQUE'] . '</h4>
                    <p class="small mb-4 text-center"> <i class="fa fa-phone mr-2"></i>' . $vehicule['TELEPHONE'] . '</p>
                    </div>';

    $donnes =  array('titre' => $titre, 'donne' => $datas);

    echo json_encode($donnes);
  }



  function index()
  {

    if (empty($this->session->userdata('USER_NAME'))) {
      redirect(base_url());
    } else {

      $get = $this->Model->getRequeteOne('SELECT COUNT(ID_ALERT) AS Nbr FROM civil_alerts WHERE ID_IMMATICULATION !="" ');

      $data['nbr'] = $get['Nbr'];

      $this->load->view('Signalement_view', $data);
    }
  }


  function get_carte($value = '')
  {

    $zoom = 8;
    $coord = '-3.4313888,29.9079177';
    $PROVINCE_ID = $this->input->post('PROVINCE_ID');
    $ID = $this->input->post('ID');
    $crit = '';

    if (!empty($PROVINCE_ID)) {
      $crit = ' AND incident_declaration.PROVINCE_ID=' . $PROVINCE_ID . '';
    }





    /*Signalement civile vehicule*/


    $vehicule =  $this->Model->getRequete('SELECT `ID_ALERT` as id,am.STATUT_TRAITEMENT,am.VALIDATION,am.LATITUDE,am.LONGITUDE,am.IMAGE_1,am.IMAGE_2,am.IMAGE_3,(SELECT ID_ALERT FROM historique_signalement WHERE ID_ALERT = id) as exist,(SELECT AMENDE FROM historique_signalement WHERE ID_ALERT = id) as amande ,im.NUMERO_PLAQUE,im.NOM_PROPRIETAIRE,im.PRENOM_PROPRIETAIRE,im.TELEPHONE,c.NOM_CHAUSSE,profil.STATUT,u.NOM_UTILISATEUR,am.CIVIL_DESCRIPTION,am.DATE_INSERTION , (SELECT MAX(q.INFRACTIONS) FROM civil_alerts_details c JOIN autres_controles_questionnaires q on q.ID_CONTROLES_QUESTIONNAIRES=c.ID_QUESTIONNAIRE WHERE c.ID_CIVIL_ALERT= id) as infration FROM civil_alerts am LEFT JOIN chaussee c on c.ID_CHAUSSEE=am.ID_CHAUSSEE JOIN obr_immatriculations_voitures im on im.ID_IMMATRICULATION=am.ID_IMMATICULATION JOIN utilisateurs u on u.ID_UTILISATEUR=am.ID_UTILISATEUR LEFT JOIN profil on profil.PROFIL_ID=u.PROFIL_ID WHERE `ID_ALERT_TYPE`=1 and ID_IMMATICULATION !=""  ');





    $vehiSin = 0;
    $vehicule_detail = '';

    foreach ($vehicule as $key => $value) {

      $vehiSin++;

      $lat = !empty($value['LATITUDE']) ? $value['LATITUDE'] : 0;
      $long = !empty($value['LONGITUDE']) ? $value['LONGITUDE'] : 0;

      $user = $this->remplace_lettre($value['NOM_UTILISATEUR']);
      $profil = $this->remplace_lettre($value['STATUT']);

      $cause = $this->remplace_lettre($value['id']);
      $date = $this->remplace_lettre($value['DATE_INSERTION']);
      $infration  =  $this->remplace_lettre($value['infration']);

      $NUMERO_PLAQUE  =  $this->remplace_lettre($value['NUMERO_PLAQUE']);
      $NOM_PROPRIETAIRE  =  $this->remplace_lettre($value['NOM_PROPRIETAIRE']) . "<span style='color:#fff'>_</span>" . $this->remplace_lettre($value['PRENOM_PROPRIETAIRE']);
      $TELEPHONE  =  $this->remplace_lettre($value['TELEPHONE']);

      $chausseRn = $this->remplace_lettre($value['NOM_CHAUSSE']);

      $CIVIL_DESCRIPTION = $this->remplace_lettre($value['CIVIL_DESCRIPTION']);

      //$imageVehicule = !empty($value['IMAGE_1']) ? $value['IMAGE_1'] : base_url("upload/personne.png");

      $imageVehicule = base_url("upload/personne.png");

      $exist = !empty($value['exist']) ? 1 : 0;

      $imageVehicule = "";
      if(!empty($value['IMAGE_1'])){
        $imageVehicule.=$value['IMAGE_1']."@";
      }
      if(!empty($value['IMAGE_2'])){
        $imageVehicule.=$value['IMAGE_2']."@";
      }
      if(!empty($value['IMAGE_3'])){
        $imageVehicule.=$value['IMAGE_3'];
      }

      $is_traiter = $value['STATUT_TRAITEMENT'] ;
     
      $is_valide = $value['VALIDATION'];

      $amande = !empty($value['amande']) ? $value['amande'] : 0;


     

      $vehicule_detail .= $lat . "<>" . $long . "<>" . $user . "<>" . $profil . "<>" . $NUMERO_PLAQUE . "<>" . $cause . "<>" . $date . "<>" . $imageVehicule . "<>" . $chausseRn . "<>" . $infration . " et...<>" . $NUMERO_PLAQUE . "<>" . $NOM_PROPRIETAIRE . "<>" . $TELEPHONE . "<>" . $CIVIL_DESCRIPTION . "<>" . $value['id'] . "<>" . $exist . "<>" .$is_traiter . "<>" .$is_valide . "<>". $amande . "<>" . "$";
    }



    $data['vehicule_detail'] = $vehicule_detail;
    $data['nombreVehicule'] = number_format($vehiSin, 0, ',', ' ');



    /*Accident*/




    $data_accident = '';

    $accidentData = $this->Model->getRequete('SELECT IMAGE_1,s.LONGITUDE,s.LATITUDE,s.DATE_INSERTION,c.NOM_CHAUSSE,g.DESCRIPTION as GAVITE,ID_SIGN_ACCIDENT,u.NOM_UTILISATEUR, profil.STATUT,s.ID_GRAVITE FROM sign_accident s JOIN type_gravite g on s.ID_GRAVITE=g.ID_TYPE_GRAVITE JOIN chaussee c on c.ID_CHAUSSEE=s.ID_CHAUSSEE JOIN utilisateurs u on u.ID_UTILISATEUR=s.USER_ID LEFT JOIN profil on profil.PROFIL_ID=u.PROFIL_ID  WHERE 1');

    $accident = 0;

    foreach ($accidentData as $key => $value) {

      $accident++;

      $lat = !empty($value['LATITUDE']) ? $value['LATITUDE'] : 0;
      $long = !empty($value['LONGITUDE']) ? $value['LONGITUDE'] : 0;

      $user = $this->remplace_lettre($value['NOM_UTILISATEUR']);
      $profil = $this->remplace_lettre($value['STATUT']);
      $matricule = $this->remplace_lettre($value['NOM_CHAUSSE']);
      $gravite = $this->remplace_lettre($value['GAVITE']);
      $date = $this->remplace_lettre($value['DATE_INSERTION']);

      $route = $this->remplace_lettre($value['NOM_CHAUSSE']);

      $photo = !empty($value['IMAGE_1']) ? $value['IMAGE_1'] : base_url("upload/personne.png");


      $data_accident .= $lat . '<>' . $long . '<>' . $user . '<>' . $profil . '<>' . $matricule . '<>' . $gravite . '<>' . $date . '<>' . $photo . '<>' . $route . '<>' . '$';
    }

    $data['data_accident'] = $data_accident;
    $data['accident'] = number_format($accident, 0, ',', ' ');


    /*Embouteillage*/



    $embouteailla =  $this->Model->getRequete('SELECT CAUSE,am.LATITUDE, am.LONGITUDE,`IMAGE_1`, c.NOM_CHAUSSE,profil.STATUT,u.NOM_UTILISATEUR,am.DATE_INSERTION FROM sign_ambouteillage am JOIN chaussee c on c.ID_CHAUSSEE=am.ID_CHAUSSEE JOIN utilisateurs u on u.ID_UTILISATEUR=am.USER_ID LEFT JOIN profil on profil.PROFIL_ID=u.PROFIL_ID ');


    $embout = 0;
    $data_emboutaill = '';

    foreach ($embouteailla as $key => $value) {

      $embout++;

      $lat = !empty($value['LATITUDE']) ? $value['LATITUDE'] : 0;
      $long = !empty($value['LONGITUDE']) ? $value['LONGITUDE'] : 0;

      $user = $this->remplace_lettre($value['NOM_UTILISATEUR']);
      $profil = $this->remplace_lettre($value['STATUT']);
      $matricule = $this->remplace_lettre($value['NOM_CHAUSSE']);
      $cause = $this->remplace_lettre($value['CAUSE']);
      $date = $this->remplace_lettre($value['DATE_INSERTION']);

      $route = $this->remplace_lettre($value['NOM_CHAUSSE']);

      $photo = !empty($value['IMAGE_1']) ? $value['IMAGE_1'] : base_url("upload/personne.png");

      $data_emboutaill .= $lat . '<>' . $long . '<>' . $user . '<>' . $profil . '<>' . $matricule . '<>' . $cause . '<>' . $date . '<>' . $photo . '<>' . $route . '<>' . '$';
    }



    $data['data_emboutaill'] = $data_emboutaill;
    $data['embout'] = number_format($embout, 0, ',', ' ');



    /*signalement vol*/


    $vols =  $this->Model->getRequete('SELECT co.COULEUR,`STATUT`, o.NUMERO_PLAQUE,o.CATEGORIE_PLAQUE,o.MARQUE_VOITURE,`IMAGE_1`,`NUMERO_SERIE`,`DATE_VOLER`,`ID_OBR`,s.DATE_INSERTION,s.NUMERO_PERMIS,u.NOM_PROPRIETAIRE,s.`LATITUDE`,s.`LONGITUDE` FROM sign_tampo_pj s JOIN chauffeur_permis u on trim(u.NUMERO_PERMIS)=trim(s.NUMERO_PERMIS) JOIN obr_immatriculations_voitures o on o.ID_IMMATRICULATION= s.ID_OBR JOIN type_couleur co on co.ID_TYPE_COULEUR=s.`ID_COULEUR` ');


    $vol = 0;
    $data_vols = '';

    foreach ($vols as $key => $value) {

      $vol++;

      $lat = !empty($value['LATITUDE']) ? $value['LATITUDE'] : 0;
      $long = !empty($value['LONGITUDE']) ? $value['LONGITUDE'] : 0;

      $nom = $this->remplace_lettre($value['NOM_PROPRIETAIRE']);
      $permis = $this->remplace_lettre($value['NUMERO_PERMIS']);
      $plaque = $this->remplace_lettre($value['NUMERO_PLAQUE']);

      $dateVol = $this->remplace_lettre($value['DATE_VOLER']);
      $date = $this->remplace_lettre($value['DATE_INSERTION']);

      $photo = !empty($value['IMAGE_1']) ? $value['IMAGE_1'] : base_url("upload/personne.png");


      $couleur = $this->remplace_lettre($value['COULEUR']);
      $serie = $this->remplace_lettre($value['NUMERO_SERIE']);
      $catego = $this->remplace_lettre($value['CATEGORIE_PLAQUE']);
      $marque = $this->remplace_lettre($value['MARQUE_VOITURE']);


      $data_vols .= $lat . '<>' . $long . '<>' . $nom . '<>' . $permis . '<>' . $plaque . '<>' . $dateVol . '<>' . $date . '<>' . $couleur . '<>' . $serie . '<>' . $catego . '<>' . $marque . '<>' . $photo . '<>'  . '$';
    }



    $data['data_vols'] = $data_vols;
    $data['vol'] = number_format($vol, 0, ',', ' ');






    $data['PROVINCE_ID'] = 3;

    $data['provinces'] = $this->Model->getRequete('SELECT * FROM syst_provinces WHERE 1 ');

    $data['zoom'] = $zoom;
    $data['coord'] = $coord;


    $map = $this->load->view('Signalement_get', $data, TRUE);
    $output = array('cartes' => $map, 'id' => $ID);


    //print_r($data_donne);die();

    echo json_encode($output);
  }




  public function getincident($id, $type = null)
  {
    $crito = '';
    $PROVINCE_ID = $this->input->post('PROVINCE_ID');


    if (!empty($PROVINCE_ID)) {
      $crito = ' and incident_declaration.PROVINCE_ID=' . $PROVINCE_ID . '';
    }


    $query_principal = 'SELECT MONTANT, IF(IS_PAID=1,"Paié","Non Paié") as PAID,`ID_HISTORIQUE`,h.LATITUDE,h.LONGITUDE,ID_HISTORIQUE_CATEGORIE,c.DESCRIPTION,h.DATE_INSERTION,e.NUMERO_MATRICULE,IF(`NUMERO_PERMIS` is NULL,`NUMERO_PLAQUE`, NUMERO_PERMIS) as NUMERO FROM historiques h JOIN historiques_categories c on h.ID_HISTORIQUE_CATEGORIE=c.ID_CATEGORIE LEFT JOIN utilisateurs u on u.ID_UTILISATEUR=h.ID_UTILISATEUR LEFT JOIN psr_elements e on e.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID WHERE 1 AND h.ID_HISTORIQUE_CATEGORIE=' . $id;


    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $limit = 'LIMIT 0,10';


    if ($_POST['length'] != -1) {
      $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }
    $order_by = '';

    $order_column = array('ID_HISTORIQUE', 'DATE_INSERTION');

    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY ID_HISTORIQUE   DESC';

    $search = !empty($_POST['search']['value']) ? (" AND  (NOM LIKE '%$var_search%' OR DATE_INSERTION LIKE '%$var_search%' OR NUMERO_MATRICULE LIKE '%$var_search%' OR DESCRIPTION LIKE '%$var_search%')  ") : '';

    $critaire = '';

    $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;


    $fetch_op = $this->Modele->datatable($query_secondaire);
    $data = array();
    foreach ($fetch_op as $row) {



      $sexe = 'Homme';


      $sub_array = array();
      $sub_array[] = $row->NUMERO;
      $sub_array[] = $row->DESCRIPTION;
      $sub_array[] = "<span style='float:right'>" . number_format($row->MONTANT, 0, '.', ' ') . " FBU</span>";
      $sub_array[] = $row->PAID;
      $sub_array[] = $row->DATE_INSERTION;



      $data[] = $sub_array;
    }
    $output = array(
      "draw" => intval($_POST['draw']),
      "recordsTotal" => $this->Modele->all_data($query_principal),
      "recordsFiltered" => $this->Modele->filtrer($query_filter),
      "data" => $data
    );
    echo json_encode($output);
  }




  public function check_new()
  {

    $get = $this->Model->getRequeteOne('SELECT COUNT(ID_ALERT) AS Nbr FROM civil_alerts WHERE ID_IMMATICULATION !=""');
    $output = array('nbr' => $get['Nbr']);
    echo json_encode($output);
  }



  function remplace_lettre($message = "")
  {

    $message = str_replace('é', 'e', $message);
    $message = trim(str_replace('"', '\"', $message));
    $message = str_replace("\n", "", $message);
    $message = str_replace("\r", "", $message);
    $message = str_replace("\t", "", $message);


    return  $message;
  }
}
