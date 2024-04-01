<?php


///Ir NTWARI Raoul  ----------- CARTE DES ALERTES POUR LES INCIDENTS

class Carte_affectation_psr extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }


  function index()
  {

    if (empty($this->session->userdata('USER_NAME'))) {
      redirect(base_url());
    } else {
      $this->load->view('Carte_affectation_psr_View');
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


    $data_donne = '';

    $maxId = $this->Model->getRequeteOne('SELECT MAX(pa.PSR_AFFECTATION_ID) as maxID FROM psr_affectatations pa LEFT JOIN psr_element_affectation pea ON pea.PSR_AFFECTATION_ID=pa.PSR_AFFECTATION_ID LEFT JOIN psr_elements psr ON psr.ID_PSR_ELEMENT=pea.PSR_AFFECTATION_ID WHERE 1');


    $requete = $this->Model->getRequete('SELECT pa.PSR_AFFECTATION_ID,pa.LATITUDE,pa.LONGITUDE,IF(pea.IS_ACTIVE=1,"Affecté", "Non affecté") AS Affectation , pa.LIEU_EXACTE,pea.DATE_DEBUT,pea.DATE_FIN,concat(psr.NOM," ",psr.PRENOM) as Agent,psr.DATE_NAISSANCE,psr.NUMERO_MATRICULE,pea.IS_ACTIVE,psr.TELEPHONE,psr.EMAIL,psr.PHOTO,pea.DATE_INSERT FROM psr_affectatations pa LEFT JOIN psr_element_affectation pea ON pea.PSR_AFFECTATION_ID=pa.PSR_AFFECTATION_ID LEFT JOIN psr_elements psr ON psr.ID_PSR_ELEMENT=pea.PSR_AFFECTATION_ID WHERE 1 ORDER by pa.PSR_AFFECTATION_ID DESC');

    $i = 0;
    $dernier = count($requete);
    $Active = 0;
    $nonActive = 0;
    $physique = 0;
    $Scan = 0;

    foreach ($requete as $key => $value) {
     // print_r($value);die();

      $i++;

      $statut = 0;


      if ($value['PSR_AFFECTATION_ID'] == $maxId['maxID']) {
        $statut = 1;
      }

      $DATE_INSERTION = $value['DATE_INSERT'];
      $NUMERO_MATRICULE = $value['NUMERO_MATRICULE'];

      $lat = $value['LATITUDE'];
      $long = $value['LONGITUDE'];

      $agent = $value['Agent'];
      $affectation = $value['Affectation'];
      $LIEU_EXACTE = $value['LIEU_EXACTE'];
      $DATE_DEBUT = $value['DATE_DEBUT'];
      $DATE_FIN = $value['DATE_FIN'];
      $TELEPHONE = $value['TELEPHONE'];
      $EMAIL = $value['EMAIL'];
      $PHOTO = $value['PHOTO'];

      

      $color = '';
      $marker = '';
      if ($value['IS_ACTIVE'] == 1) {
        $color = 'FF8000';
        $marker = '';

        $Active++;
      }
     // print_r($Active);die();

      if ($value['IS_ACTIVE'] == 0) {
        $color = '3e9ceb';
        $marker = 'amusement';
        $nonActive++;
      }
     
     $police =$this->Modele->getRequeteOne('SELECT pa.PSR_AFFECTATION_ID, COUNT(pa.PSR_AFFECTATION_ID) as Nbr,pea.DATE_INSERT FROM  psr_affectatations pa LEFT JOIN psr_element_affectation pea ON pea.PSR_AFFECTATION_ID=pa.PSR_AFFECTATION_ID LEFT JOIN psr_elements psr ON psr.ID_PSR_ELEMENT=pea.PSR_AFFECTATION_ID WHERE 1 AND pa.PSR_AFFECTATION_ID='.$value['PSR_AFFECTATION_ID'].' GROUP BY PSR_AFFECTATION_ID');

     

      $data_donne .= $lat . '<>' . $long . '<>' . $LIEU_EXACTE . '<>' . $NUMERO_MATRICULE . '<>' . $DATE_INSERTION . '<>'.$agent.'<>' . $statut . '<>' . $police['Nbr'] . '<>'.$police['DATE_INSERT'] . '<>'. '$';
    }

        //print_r($data_donne);die();

    $data['data_donne'] = $data_donne;
    $data['Active'] = $Active;
    $data['nonActive'] = $nonActive;
  
    $data['PROVINCE_ID'] = 3;


    $data['provinces'] = $this->Model->getRequete('SELECT * FROM syst_provinces WHERE 1 ');


    $data['dernier'] = $this->Model->getRequeteOne('SELECT pa.PSR_AFFECTATION_ID,pa.LATITUDE,pa.LONGITUDE,IF(pea.IS_ACTIVE=1,"Affecté", "Non affecté") AS Affectation , pa.LIEU_EXACTE,pea.DATE_DEBUT,pea.DATE_FIN,concat(psr.NOM," ",psr.PRENOM) as Agent,psr.DATE_NAISSANCE,psr.NUMERO_MATRICULE,pea.IS_ACTIVE,psr.TELEPHONE,psr.EMAIL,psr.PHOTO,pea.DATE_INSERT FROM psr_affectatations pa LEFT JOIN psr_element_affectation pea ON pea.PSR_AFFECTATION_ID=pa.PSR_AFFECTATION_ID LEFT JOIN psr_elements psr ON psr.ID_PSR_ELEMENT=pea.PSR_AFFECTATION_ID WHERE 1 ORDER by pa.PSR_AFFECTATION_ID DESC LIMIT 1');

    if ($ID == 1) {
      $zoom = 18;
      $coord = '' . $data['dernier']['LATITUDE'] . ',' . $data['dernier']['LONGITUDE'] . '';
    }




    $data['dernier_2'] = $this->Model->getRequete('SELECT pa.PSR_AFFECTATION_ID,pa.LATITUDE,pa.LONGITUDE,IF(pea.IS_ACTIVE=1,"Affecté", "Non affecté") AS Affectation , pa.LIEU_EXACTE,pea.DATE_DEBUT,pea.DATE_FIN,concat(psr.NOM," ",psr.PRENOM) as Agent,psr.DATE_NAISSANCE,psr.NUMERO_MATRICULE,pea.IS_ACTIVE as IS_ACTIVE,psr.TELEPHONE,psr.EMAIL,psr.PHOTO,pea.DATE_INSERT FROM psr_affectatations pa LEFT JOIN psr_element_affectation pea ON pea.PSR_AFFECTATION_ID=pa.PSR_AFFECTATION_ID LEFT JOIN psr_elements psr ON psr.ID_PSR_ELEMENT=pea.PSR_AFFECTATION_ID WHERE 1 ORDER by pa.PSR_AFFECTATION_ID DESC LIMIT 10');

    $data['zoom'] = $zoom;
    $data['coord'] = $coord;


    $map = $this->load->view('Get_Situation_psr', $data, TRUE);
    $output = array('cartes' => $map, 'id' => $ID);
    echo json_encode($output);
  }



  public function getincident($id, $type = null)
  {
    $crito = '';
    $PROVINCE_ID = $this->input->post('PROVINCE_ID');


    if (!empty($PROVINCE_ID)) {
      $crito = ' and incident_declaration.PROVINCE_ID=' . $PROVINCE_ID . '';
    }


    $query_principal = 'SELECT pa.PSR_AFFECTATION_ID,pa.LATITUDE,pa.LONGITUDE,IF(pea.IS_ACTIVE=1,"Affecté", "Non affecté") AS Affectation , pa.LIEU_EXACTE,DATE_FORMAT(pea.DATE_DEBUT, "%d-%m-%Y") as date_debut,DATE_FORMAT(pea.DATE_FIN, "%d-%m-%Y") as date_fin,concat(psr.NOM," ",psr.PRENOM) as Agent,psr.DATE_NAISSANCE,psr.NUMERO_MATRICULE,psr.TELEPHONE,psr.EMAIL,psr.PHOTO,pea.IS_ACTIVE,pea.DATE_INSERT FROM psr_affectatations pa LEFT JOIN psr_element_affectation pea ON pea.PSR_AFFECTATION_ID=pa.PSR_AFFECTATION_ID LEFT JOIN psr_elements psr ON psr.ID_PSR_ELEMENT=pea.PSR_AFFECTATION_ID WHERE 1 AND pea.IS_ACTIVE ='.$id;


    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $limit = 'LIMIT 0,10';


    if ($_POST['length'] != -1) {
      $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }
    $order_by = '';

    $order_column = array('PSR_AFFECTATION_ID', 'DATE_INSERT');

    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY PSR_AFFECTATION_ID   DESC';

    $search = !empty($_POST['search']['value']) ? (" AND  (NOM LIKE '%$var_search%' OR DATE_INSERT LIKE '%$var_search%' OR NUMERO_MATRICULE LIKE '%$var_search%' OR Agent LIKE '%$var_search%')  ") : '';

    $critaire = '';

    $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;


    $fetch_op = $this->Modele->datatable($query_secondaire);
    $data = array();
    foreach ($fetch_op as $row) {



      //$sexe = 'Homme';

      $sub_array = array();
      $sub_array[] = $row->Agent;
      $sub_array[] = $row->Affectation;
      $sub_array[] = $row->LIEU_EXACTE;
      $sub_array[] = $row->date_debut;
      $sub_array[] = $row->date_fin;



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

    $get = $this->Model->getRequeteOne('SELECT COUNT(*) AS Nbr FROM psr_affectatations WHERE NEW=0');
    $send = 0;
    if ($get['Nbr'] > 0) {
      $send = 1;
      $this->Model->update('psr_affectatations', array('NEW' => 0), array('NEW' => 1));
    }


    $output = array('nbr' => $send);
    echo json_encode($output);
  }



  function remplace_lettre($message = "")
  {

    $message = str_replace('é', 'e', $message);

    return  $message;
  }
}
