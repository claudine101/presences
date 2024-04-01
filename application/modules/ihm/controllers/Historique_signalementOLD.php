<?php
class  Historique_signalement extends CI_Controller
{
  function index()
  {
    $data['title'] = "Signalements traités";
    $this->load->view('historique/historique_signalement_list', $data);
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

    $message = trim(str_replace("'", " ", $message));
    $message = str_replace("\n", "", $message);
    $message = str_replace("\r", "", $message);
    $message = str_replace("\t", "", $message);


    return  $message;
  }


  function confirmEcocashPaid($txi_id = 0)
  {

    $this->Modele->update('historique_signalement', array('TNX_ID' => $txi_id), array('STATUT_PAYE' => 1));

    echo $txi_id;
  }

  public function send_sms_smpp($string_tel = NULL, $string_msg)
  {

    return $this->notifications->send_sms_smpp($string_tel, $string_msg);;
  }


  function validations($id = 0, $idhis = 0)
  {
    $stat = 4;
    $datas =  array(
      'VALIDATION' => 1,
      'STATUT_TRAITEMENT' => $stat
    );

    $datl = array(
      'ID_SIGNALEMET' => $id,
      'USER_ID' => $this->session->userdata('USER_ID'),
      'STATUT_TRAITEMENT' => $stat
    );

    $data_update = $this->Model->getRequeteOne('SELECT ID_HISTO_SIGNALEMMENT,pr.STATUT, obr.NUMERO_PLAQUE,obr.NOM_PROPRIETAIRE,ca.STATUT_TRAITEMENT,sv.DESCRIPTION, DESCRIPTION_INFRATION, obr.TELEPHONE, AMENDE,sv.ID_STATUT,STATUT_PAYE, IF(STATUT_PAYE=1, "payé" ,"non payé") AS STATUT_PAY ,hs.VALIDATION, DATE_INSERT,sv.DESCRIPTION as STATUT_TRAITEM,sv.ID_STATUT as status,obr.MARQUE_VOITURE, ca.CIVIL_DESCRIPTION, user.NOM_UTILISATEUR,COMMENATAIRE FROM historique_signalement hs LEFT JOIN obr_immatriculations_voitures obr on obr.ID_IMMATRICULATION=hs.ID_IMMATICULATION LEFT JOIN utilisateurs user ON user.ID_UTILISATEUR=hs.USER_ID LEFT JOIN profil pr ON pr.PROFIL_ID=user.PROFIL_ID LEFT JOIN civil_alerts ca ON ca.ID_ALERT=hs.ID_ALERT LEFT JOIN statut_validation sv ON sv.ID_STATUT=hs.STATUT_TRAITEMENT  WHERE 1 AND ID_HISTO_SIGNALEMMENT=' . $id);

    $this->Modele->update('historique_signalement', array('ID_HISTO_SIGNALEMMENT' => $id), $datas);


    $table1 = 'histo_validation_vol';
    $this->Modele->create($table1, $datl);

    $sms = $data_update['NOM_PROPRIETAIRE'] . " " . $data_update['PRENOM_PROPRIETAIRE'] . ",votre vehicule " . $data_update['MARQUE_VOITURE'] . " plaque " . $data_update['NUMERO_PLAQUE'] . " est verbalise par la PNB  amende : " . number_format($data_update['AMENDE'], 0, ',', " ") . " FBU a payer dans un delais de 72h";

    $this->send_sms_smpp($data_update['TELEPHONE'], $sms);

    $this->sendVerbalisationMessage($id);

    $data['message'] = '<div class="alert alert-success text-center" id="message">La demande est prise en charge avec succès</div>';
    $this->session->set_flashdata($data);
    redirect(base_url('ihm/Historique_signalement/'));
  }


  function sendVerbalisationMessage($id)
  {

    $police = $this->Model->getRequeteOne('SELECT ID_HISTO_SIGNALEMMENT,pr.STATUT,concat(obr.NOM_PROPRIETAIRE," ",obr.PRENOM_PROPRIETAIRE) as name, obr.NUMERO_PLAQUE,ca.STATUT_TRAITEMENT,sv.DESCRIPTION, DESCRIPTION_INFRATION, AMENDE,sv.ID_STATUT,STATUT_PAYE, IF(STATUT_PAYE=1, "payé" ,"non payé") AS STATUT_PAY ,hs.VALIDATION, DATE_INSERT,sv.DESCRIPTION as STATUT_TRAITEM,sv.ID_STATUT as status, ca.CIVIL_DESCRIPTION,ca.IMAGE_1,ca.IMAGE_2,ca.IMAGE_3, user.NOM_UTILISATEUR,COMMENATAIRE FROM historique_signalement hs LEFT JOIN obr_immatriculations_voitures obr on obr.ID_IMMATRICULATION=hs.ID_IMMATICULATION LEFT JOIN utilisateurs user ON user.ID_UTILISATEUR=hs.USER_ID LEFT JOIN profil pr ON pr.PROFIL_ID=user.PROFIL_ID LEFT JOIN civil_alerts ca ON ca.ID_ALERT=hs.ID_ALERT LEFT JOIN statut_validation sv ON sv.ID_STATUT=hs.STATUT_TRAITEMENT  WHERE 1 AND ID_HISTO_SIGNALEMMENT=' . $id);


    $tokens =  $this->Model->getRequete('SELECT n.TOKEN,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,e.TELEPHONE FROM notification_tokens n JOIN utilisateurs u on n.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON e.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID WHERE 1');

    if (!empty($tokens)) {

      $tokns = array();

      $nom = "";

      foreach ($tokens as $key => $value) {

        $tokns[] = $value['TOKEN'];

        $phoneNumber = str_replace(' ', '', $value['TELEPHONE']);

        $nom =  str_replace(' ', '', $value['NOM']) . ' ' . str_replace(' ', '', $value['PRENOM']) . ' (' . str_replace(' ', '', $value['NUMERO_MATRICULE']) . ")";
      }

      $MessageText = " on vient de verbaliser Mr/Mde " . $police['name'] . " , sur la faute de " . $police['DESCRIPTION_INFRATION'] . " ";

      $titre =  " Historique Signalement";

      $messageAgent =  $nom . ",\n" . $MessageText;

      $donnes = array(
        'TITRE' => $titre,
        'CONTENU' => $messageAgent,
        'tokens' => $tokns
      );

      //print_r($donnes);exit();

      $this->notifications->notificationApk($donnes);

      $data = array(
        'USER_ID' => $this->session->userdata('USER_ID'),
        'MESSAGE' => $messageAgent,
        'TELEPHONE' => $phoneNumber,
        'NUMERO_PLAQUE' => 'PSR',
        'IS_AGENT_PSR' => 1,
        'STATUT' => 1,
        'ID_PSR_ELEMENT' => 0
      );

      $this->notifications->send_sms_smpp($phoneNumber, $messageAgent);
    }

    $test = $this->Model->create('notifications', $data);

    if ($test) {
      echo '1';
    } else {
      echo '0';
    }
  }


  function getDetaisSign($id_control = 0)
  {

    $dataDetail = "SELECT us.NOM_UTILISATEUR,st.DESCRIPTION,DATE_FORMAT(hvv.DATE_INSERTION, '%d-%m-%Y') AS date  FROM histo_validation_signalement  hvv LEFT JOIN historique_signalement  stp on stp.ID_HISTO_SIGNALEMMENT =hvv.ID_SIGNALEMET LEFT JOIN utilisateurs us on us.ID_UTILISATEUR=hvv.USER_ID LEFT JOIN statut_validation st ON st.ID_STATUT=hvv.STATUT_TRAITEMENT WHERE 1 AND hvv.ID_SIGNALEMET=" . $id_control;


    $htmlDetail = "<div class='table-responsive'>
    <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
    <thead>
    <tr>
    <th>Utilisateur</th>
    <th>Statut</th>
    <th>Date</th>
    </tr>
    </thead>

    <tbody>";

    $total = 0;
    foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {



      $htmlDetail .= "<tr>
      <td>" . $value['NOM_UTILISATEUR'] . "</td>
      <td>" . $value['DESCRIPTION'] . "</td>
      <td>" . $value['date'] . "</td>
      </tr>";
    }

    $htmlDetail .= "</tbody></table>
    </div>";


    return $htmlDetail;
  }

  function validation_final($id = 0, $idhis = 0)
  {
    $status = 2;
    $datas = array(
      "VALIDATION" => 0,
      "STATUT_TRAITEMENT" => $status,
    );
    $data1 = array(
      'ID_SIGNALEMET' => $id,
      'USER_ID' => $this->session->userdata('USER_ID'),
      'STATUT_TRAITEMENT' => $status,
    );
    $table = 'histo_validation_signalement ';
    $this->Modele->create($table, $data1);
    $this->Modele->update('historique_signalement', array('ID_HISTO_SIGNALEMMENT ' => $id), $datas);

    $data['message'] = '<div class="alert alert-success text-center" id="message">La demande est prise en charge avec succès</div>';
    $this->session->set_flashdata($data);
    redirect(base_url('ihm/Historique_signalement/'));
  }



  function listing()
  {

    $condition1 = "";


    if ($this->session->userdata('PROFIL_ID') == 1) {
      $condition1 = " AND hs.STATUT_TRAITEMENT=2 or hs.STATUT_TRAITEMENT=4";
    } else if ($this->session->userdata('PROFIL_ID') == 11) {
      $condition1 = " AND hs.STATUT_TRAITEMENT=1";
    }
    $query_principal = 'SELECT ID_HISTO_SIGNALEMMENT,pr.STATUT, obr.NUMERO_PLAQUE,ca.STATUT_TRAITEMENT,sv.DESCRIPTION, DESCRIPTION_INFRATION, AMENDE,sv.ID_STATUT,STATUT_PAYE, IF(STATUT_PAYE=1, "payé" ,"non payé") AS STATUT_PAY ,hs.VALIDATION, DATE_INSERT,sv.DESCRIPTION as STATUT_TRAITEM,sv.ID_STATUT as status, ca.CIVIL_DESCRIPTION,ca.IMAGE_1,ca.IMAGE_2,ca.IMAGE_3, user.NOM_UTILISATEUR,COMMENATAIRE FROM historique_signalement hs LEFT JOIN obr_immatriculations_voitures obr on obr.ID_IMMATRICULATION=hs.ID_IMMATICULATION LEFT JOIN utilisateurs user ON user.ID_UTILISATEUR=hs.USER_ID LEFT JOIN profil pr ON pr.PROFIL_ID=user.PROFIL_ID LEFT JOIN civil_alerts ca ON ca.ID_ALERT=hs.ID_ALERT LEFT JOIN statut_validation sv ON sv.ID_STATUT=hs.STATUT_TRAITEMENT  WHERE 1' . $condition1;


    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $limit = 'LIMIT 0,10';

    if ($_POST['length'] != -1) {



      $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }

    $order_by = '';

    $order_column = array('NUMERO_PLAQUE', 'DESCRIPTION_INFRATION', 'AMENDE', 'STATUT_PAYE', 'CIVIL_DESCRIPTION', 'NOM_UTILISATEUR');

    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY ID_HISTO_SIGNALEMMENT ASC';

    $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%' OR NOM_UTILISATEUR LIKE '%$var_search%' OR DESCRIPTION_INFRATION LIKE '%$var_search%' OR AMENDE LIKE '%$var_search%' ") : '';
    $critaire = '';

    $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;



    $fetch_peine = $this->Modele->datatable($query_secondaire);
    $data = array();


    foreach ($fetch_peine as $row) {

      $image = '';

      if ($row->IMAGE_1 || $row->IMAGE_2 || $row->IMAGE_3) {
        $img = '<span class = "btn btn-success btn-sm " ><i class = "fa fa-eye" ></i></span>';
      } else {
        $img = 'Pas de Photo';
      }


      $option = '<div class="dropdown ">
  <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
  <i class="fa fa-cog"></i>
  Action
  <span class="caret"></span></a>
  <ul class="dropdown-menu dropdown-menu-left">
  ';
      $option .= "<li><a hre='#' data-toggle='modal'
  data-target='#mydelete" . $row->ID_HISTO_SIGNALEMMENT . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
      if ($this->session->userdata('PROFIL_ID') == 11) {
        $option .= "<li><a href='#' data-toggle='modal'
    data-target='#stat2" . $row->ID_HISTO_SIGNALEMMENT  . "'><label class='text-secondary'>&nbsp;&nbsp;OPJ</label></a></li>";
      } else {
        $option .= "";
      }


      $option .= " </ul>
  </div>
  <div class='modal fade' id='mydelete" . $row->ID_HISTO_SIGNALEMMENT . "'>
  <div class='modal-dialog'>
  <div class='modal-content'>

  <div class='modal-body'>
  <center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i> " . $row->NUMERO_PLAQUE . " " . $row->NOM_UTILISATEUR . " </i></b></h5></center>
  </div>

  <div class='modal-footer'>
  <a class='btn btn-danger btn-md' href='" . base_url('ihm/Historique_signalement/delete/' . $row->ID_HISTO_SIGNALEMMENT) . "'>Supprimer</a>
  <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
  </div>

  </div>
  </div>
  </div> ";

      $option .= " 
  <div class='modal fade' id='stat2" .  $row->ID_HISTO_SIGNALEMMENT  . "'>
  <div class='modal-dialog'>
  <div class='modal-content'>

  <div class='modal-body'>
  <center>
  <p> Voulez-vous accorder la suite à cette demande?<br></center>
  </div>

  <div class='modal-footer'>
  <a class='btn btn-primary btn-md' href='" . base_url('ihm/Historique_signalement/validation_final/' . $row->ID_HISTO_SIGNALEMMENT  . '/' . $row->status) . "'>Valider</a>
  <button class='btn btn-danger btn-md' data-dismiss='modal'>Quitter</button>
  </div>

  </div>
  </div>
  </div>";

      $validation  = "<a hre='#' data-toggle='modal'
  data-target='#validations" . $row->ID_HISTO_SIGNALEMMENT  . "'><font color='red'>&nbsp;&nbsp;No Validé</font></a>";

      $valid = ($row->VALIDATION == 0) ? $validation : "<b style='color:green'>Validé</b>";

      $option .= "
  <div class='modal fade' id='validations" . $row->ID_HISTO_SIGNALEMMENT  . "'>
  <div class='modal-dialog'>
  <div class='modal-content'>

  <div class='modal-body'>
  <center><h5 style='color:black'>Voulez-vous prendre en charge cette demande de <br> " . $row->NOM_UTILISATEUR . "</i></b></h5></center>
  </div>

  <div class='modal-footer'>
  <a class='btn btn-success btn-md' href='" . base_url('ihm/Historique_signalement/validations/' . $row->ID_HISTO_SIGNALEMMENT  . '/' . $row->status) . "'>valider</a>
  <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
  </div>

  </div>
  </div>
  </div>";

      $var = "<span  class='btn btn-md dt-button btn-sm'>Historique</span>";

      $detailSign = '';

      $detailSign .= "<a hre='#' data-toggle='modal'
  data-target='#detail" . $row->ID_HISTO_SIGNALEMMENT  . "'>" . $var . "</a>";
      $detailSign .= "
  <div class='modal fade' id='detail" . $row->ID_HISTO_SIGNALEMMENT  . "'>
  <div class='modal-dialog'>
  <div class='modal-content'>
  <div class='modal-header'>
  <h5 class='modal-title'>Detail de controle</h5>
  <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
  </div>
  <div class='modal-body'>";


      if ($row->ID_HISTO_SIGNALEMMENT  != Null) {
        $detailSign .= $this->getDetaisSign($row->ID_HISTO_SIGNALEMMENT);
      }

      $detailSign .= "
  </div>
  <div class='modal-footer'>
  <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
  </div>

  </div>
  </div>
  </div>";

      $image = "<a hre='#' data-toggle='modal'
      data-target='#image" . $row->ID_HISTO_SIGNALEMMENT . "'>" . $img . "</a>";
      $image .= "
      <div class='modal fade' id='image" . $row->ID_HISTO_SIGNALEMMENT . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>

      <div class='modal-body'>
      <center>
      <p><b>" . $row->DESCRIPTION . "</b></center></p>";

      if (!empty($row->IMAGE_1)) {
        $image .= "<img style='width:50%' src='" . $row->IMAGE_1 . "'>";
      }


      if (!empty($row->IMAGE_2)) {
        $image .= "<img style='width:50%' src='" . $row->IMAGE_2 . "'>";
      }

      if (!empty($row->IMAGE_3)) {
        $image .= "<img style='width:50%' src='" . $row->IMAGE_3 . "'>";
      }



      $image .= "</div>

      <div class='modal-footer'>
      
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";


      $val_stdu = '';
      $val_stat = '';


      if ($row->VALIDATION == 1) {
        $val_stdu = '<span style="color : green">validé</span>';
      } else {
        $val_stat = '<span style="color :red ">non validé </span>';
      }



      $sub_array = array();
      $sub_array[] = '<table> <tbody><tr><td>' . $row->NOM_UTILISATEUR . '<br>' . $row->DESCRIPTION . '</td></tr></tbody></table>';
      $sub_array[] = date("d-m-Y", strtotime($row->DATE_INSERT));
      $sub_array[] = $row->NUMERO_PLAQUE;
      $sub_array[] = $row->DESCRIPTION_INFRATION;
      // $sub_array[]="<span style='float:right'>".number_format($row->AMENDE,0,',',' ')."</span>";
      $sub_array[] = $row->CIVIL_DESCRIPTION;
      if ($this->session->userdata('PROFIL_ID') == 1) {
        $sub_array[] = $valid . '<br>' . $detailSign;
      } else {
        $sub_array[] = 'non validé';
      }
      //$sub_array[]=$row->STATUT_TRAITEM ? $row->STATUT_TRAITEM : 'encours..';
      //$sub_array[]=$row->STATUT_PAY;
      $sub_array[] = $image;
      $sub_array[] = $option;
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

  function delete()
  {

    $table = "historique_signalement";
    $criteres['ID_HISTO_SIGNALEMMENT'] = $this->uri->segment(4);
    $data['rows'] = $this->Modele->getOne($table, $criteres);
    $this->Modele->delete($table, $criteres);

    $data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
    $this->session->set_flashdata($data);
    redirect(base_url('ihm/Historique_signalement'));
  }

  function PayementEcocash($id, $amande)
  {

    $url = 'http://app.mediabox.bi/api_ussd_php/Api_client_ecocash';
    $clientPhone = $this->input->post('Telephone');

    $data = array(
      'VENDEUR_PHONE' => '71028884',
      'AMOUNT' => '100',
      'CLIENT_PHONE' => $clientPhone,
      'INSTANCE_TOKEN' => '36'
    );
    $send = $this->httpPost($url, json_encode($data));
    print_r($send);
    die();
  }




  function httpPost()
  {
    $AMENDE =  $this->input->post('AMENDE');
    $Telephone =  $this->input->post('Telephone');
    $ID_HISTO_SIGNALEMMENT =  $this->input->post('ID_HISTO_SIGNALEMMENT');

    $data = array(
      "VENDEUR_PHONE" => "79839653", "AMOUNT" => $AMENDE,
      "CLIENT_PHONE" => $Telephone, "INSTANCE_TOKEN" => "202022"
    );

    $url = 'http://app.mediabox.bi/api_ussd_php/Api_client_ecocash';
    if (is_array($data)) {
      $data = json_encode($data);
    }
    $options = stream_context_create(['http' => [
      'method'  => 'POST',
      'header'  => 'Content-type: application/json',
      'content' => $data
    ]]);
    $response = file_get_contents($url, false, $options);

    $respon = json_decode($response);

    if ($respon->statut == "200") {
      $this->Modele->update('historique_signalement', array('ID_HISTO_SIGNALEMMENT' => $ID_HISTO_SIGNALEMMENT), array('TNX_ID' => $respon->txn_id));
    }

    print_r($response);
  }


  function confirm()
  {

    $table = "historique_signalement";
    $criteres['ID_HISTO_SIGNALEMMENT'] = $this->uri->segment(4);
    $data['rows'] = $this->Modele->getOne($table, $criteres);
    $this->Modele->update($table, $criteres, array('STATUT_PAYE' => 1));

    $data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est confirmé avec succès</div>';
    $this->session->set_flashdata($data);
    redirect(base_url('ihm/Historique_signalement'));
  }
}
