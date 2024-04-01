<?php

class Amende_percu_journe extends CI_Controller
{

  function index()
  {

    $date_insert = $this->input->post('DateChec');
    $date_fin = $this->input->post('date_fin');

    if (empty($date_insert) or empty($date_fin)) {
          $date_insert = Date('Y-m-d');
          $date_fin = Date('Y-m-d');
    }
    $condition =  "'$date_insert' AND '$date_fin'";
    
    $data['date_insert'] =  $date_insert;
    $data['date_fin'] =  $date_fin;
    $Chaussee = $this->Modele->getRequete("SELECT SUM(MONTANT) as total,user.NOM_UTILISATEUR FROM historiques hs LEFT JOIN utilisateurs user on user.ID_UTILISATEUR=hs.ID_UTILISATEUR WHERE user.PROFIL_ID in(6,12)  AND DATE_FORMAT(hs.DATE_INSERTION, '%Y-%m-%d') BETWEEN $condition GROUP BY NOM_UTILISATEUR ");


    $nombre = 0;
    $donne = "";

    $i = 0 ;

    foreach ($Chaussee as $value) {
      $nombre = $nombre + $value['total'];
      $name = (!empty($value['NOM_UTILISATEUR'])) ? $value['NOM_UTILISATEUR'] : "Aucun";
      $nb = (!empty($value['total'])) ? $value['total'] : "0";

    $i ++;

      $key_id = $i;
      $donne .= "{name:'" . str_replace("'", "\'", $name) . "', y:" . $nb . ",key:" . $key_id . "},";
    }




    $data['title'] = "Performance des fonctionnaires de la PNB";
    $data['donne'] = $donne;
    $data['nombre'] = $nombre;

    $date = $this->Modele->getRequete('SELECT date_format(`DATE_INSERTION`,"%d-%m-%Y") as date_insert FROM `historiques` WHERE 1 GROUP BY date_format(`DATE_INSERTION`,"%d-%m-%Y")');

    $data['date'] = $date;


    $data = $this->load->view('amande_par_journe_v', $data);
  }


  function detailChausse()
  {

    $KEY = $this->input->post('key');

    $gravite = $this->input->post('gravite');

    $condition = '';
    if (!empty($gravite)) {
      $condition .=  ' and a.ID_GRAVITE="' . $gravite . '"';
    }


    $break = explode(".", $KEY);
    $ID = $KEY;

    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $query_principal = ('SELECT c.NOM_CHAUSSE,`PLAQUE`,If(VALIDATION=1,"valide","invalide") as VALIDATION, a.DESCRIPTION , c.NOM_CHAUSSE,a.LONGITUDE, a.LATITUDE, `DATE_INSERTION`,g.DESCRIPTION as GRAVITE FROM sign_accident a JOIN chaussee c on a.ID_CHAUSSEE=c.ID_CHAUSSEE join type_gravite g on g.ID_TYPE_GRAVITE=a.ID_GRAVITE WHERE 1 ' . $condition . '  and c.ID_CHAUSSEE=' . $ID);


    $limit = 'LIMIT 0,10';
    if ($_POST['length'] != -1) {
      $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }

    $order_by = '';

    if ($_POST['order']['0']['column'] != 0) {
      $order_by = isset($_POST['order']) ? ' ORDER BY ' . $_POST['order']['0']['column'] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY PLAQUE  DESC';
    }

    $search = !empty($_POST['search']['value']) ? (" AND (PLAQUE LIKE '%$var_search%' OR  DATE LIKE '%$var_search%'  ) ") : '';

    $query_secondaire = $query_principal . ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $search;


    $fetch_data = $this->Modele->datatable($query_secondaire);
    $u = 0;
    $data = array();
    foreach ($fetch_data as $row) {

      $u++;
      $intrant = array();
      $intrant[] = $u;
      $intrant[] = $row->NOM_CHAUSSE;
      $intrant[] = $row->PLAQUE;
      $intrant[] = $row->GRAVITE;
      $intrant[] = $row->VALIDATION;
      $intrant[] = $row->DESCRIPTION;
      $intrant[] = $row->DATE_INSERTION;

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
}
