

<?php

class Dash_alert_Police extends CI_Controller
{

  function index()
  {
    $i = 1;
    $date = $this->input->post('date');
    $val = $this->input->post('ID_TYPE');
    $chaussee = $this->input->post('ID_CHAUSSEE');

    $conditon = '';

    $conditon = !empty($date) ? " AND DATE_FORMAT(ca.DATE_INSERTION, '%d-%m-%Y')='" . $date . "'" : "";
    $conditon .= !empty($val) ? " AND ID_ALERT_TYPE =" . $val : "";
    $conditon .= !empty($chaussee) ? " AND ca.ID_CHAUSSEE =" . $chaussee : "";

    $Alerts = $this->Modele->getRequete("SELECT ca.ID_ALERT_TYPE as ID, COUNT(ca.ID_ALERT) AS Nbre, cat.DESCRIPTION as alert  FROM civil_alerts ca LEFT JOIN civil_alerts_types cat ON cat.ID_TYPE=ca.ID_ALERT_TYPE LEFT JOIN utilisateurs us on us.ID_UTILISATEUR=ca.ID_UTILISATEUR  LEFT JOIN chaussee ch ON ch.ID_CHAUSSEE=ca.ID_CHAUSSEE WHERE 1 " . $conditon . " GROUP BY alert,ca.ID_ALERT_TYPE");

    $nombre = 0;
    $donne = "";



    foreach ($Alerts as $value) {
      $nombre += $value['Nbre'];
      $name = (!empty($value['alert'])) ? $value['alert'] : "Aucun";
      $nb = (!empty($value['Nbre'])) ? $value['Nbre'] : "0";



      $key_id = ($value['ID'] > 0) ? $value['ID'] : "0";
      $donne .= "{name:'" . str_replace("'", "\'", $name) . "', y:" . $nb . ",key:" . $key_id . "},";
    }

    //print_r($donne);exit();
    $data['title'] = "Rapport sur les alertes";
    $data['donne'] = $donne;
    $data['nombre'] = $nombre;

    $date = $this->Modele->getRequete('SELECT date_format(DATE_INSERTION,"%d-%m-%Y") as date FROM civil_alerts WHERE 1 GROUP BY date_format(DATE_INSERTION,"%d-%m-%Y")');
    $alerts = $this->Modele->getRequete('SELECT ID_TYPE, DESCRIPTION FROM civil_alerts_types WHERE 1 GROUP BY DESCRIPTION,ID_TYPE');
    $chaussee = $this->Modele->getRequete('SELECT ID_CHAUSSEE, NOM_CHAUSSE FROM chaussee WHERE 1 GROUP BY NOM_CHAUSSE,ID_CHAUSSEE');


    $data['date'] = $date;
    $data['alerts'] = $alerts;
    $data['chaussee'] = $chaussee;



    $data = $this->load->view('dash_alert_Police_v', $data);
  }


  function detailChausse()
  {
    $KEY = $this->input->post('key');

    $date = $this->input->post('date');
    $chaussee = $this->input->post('ID_CHAUSSEE');

    $condition = '';
    if (!empty($date)) {
      $condition .=  ' and DATE_FORMAT(ca.DATE_INSERTION, "%d-%m-%Y")="' . $date . '"';
    }
    $condition .= !empty($chaussee) ? " AND ca.ID_CHAUSSEE =" . $chaussee : "";
    $break = explode(".", $KEY);

    $ID = $KEY;

    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $query_principal = ('SELECT ID_ALERT,ca.ID_ALERT_TYPE,concat( us.NOM_CITOYEN,"",us.PRENOM_CITOYEN) as name,us.NOM_UTILISATEUR,cat.DESCRIPTION, ID_IMMATICULATION, CIVIL_DESCRIPTION, ch.NOM_CHAUSSE, IMAGE_1, IMAGE_2, IMAGE_3, ca.LATITUDE, ca.LONGITUDE, DELETED_AT, DATE_FORMAT(ca.DATE_INSERTION, "%d-%m-%Y") as date_insert FROM civil_alerts ca LEFT JOIN civil_alerts_types cat ON cat.ID_TYPE=ca.ID_ALERT_TYPE LEFT JOIN utilisateurs us on us.ID_UTILISATEUR=ca.ID_UTILISATEUR  LEFT JOIN chaussee ch ON ch.ID_CHAUSSEE=ca.ID_CHAUSSEE  WHERE 1 ' . $condition . ' AND ID_ALERT_TYPE=' . $ID);


    $limit = 'LIMIT 0,10';
    if ($_POST['length'] != -1) {
      $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }

    $order_by = '';

    if ($_POST['order']['0']['column'] != 0) {
      $order_by = isset($_POST['order']) ? ' ORDER BY ' . $_POST['order']['0']['column'] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY date_insert  DESC';
    }

    $search = !empty($_POST['search']['value']) ? (" AND (NOM_CHAUSSE LIKE '%$var_search%' OR  date_insert LIKE '%$var_search%'  ) ") : '';

    $query_secondaire = $query_principal . ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $search;


    $fetch_data = $this->Modele->datatable($query_secondaire);
    $u = 1;
    $data = array();
    foreach ($fetch_data as $row) {
      $intrant = array();
      $intrant[] = $u++;
      $intrant[] = '<table> <tbody><tr><td><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="https://app.mediabox.bi/wasiliEate/uploads/personne.png"></td><td>' . $row->name . ' <font style="font-size:10px;color:red"><i class="far fa-comment-dots"></i></font></td></tr></tbody></table>';
      $intrant[] = $row->NOM_CHAUSSE;
      $intrant[] = $row->DESCRIPTION;
      $intrant[] = $row->CIVIL_DESCRIPTION;
      $intrant[] = $row->date_insert;

      $data[] = $intrant;
    }

    $output = array(
      "draw" => intval($_POST['draw']),
      "recordsTotal" => $this->Modele->all_data($query_principal),
      "recordsFiltered" => $this->Modele->filtrer($query_filter),
      "data" => $data
    );

    echo json_encode($output);
  }

  // function getRapport(){

  // }

}
?>