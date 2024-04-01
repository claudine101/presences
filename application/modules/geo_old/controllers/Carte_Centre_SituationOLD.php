<?php


///Ir NTWARI Raoul  ----------- CARTE DES ALERTES POUR LES INCIDENTS

class Carte_Centre_Situation extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }



  function getInfo_permis($permis = null){

    $getpermis =  $this->Model->getRequeteOne('SELECT `NUMERO_PERMIS`,`NOM_PROPRIETAIRE`,`CATEGORIES`,`DATE_DELIVER`,`DATE_EXPIRATION`,`POINTS` FROM `chauffeur_permis_tampos` WHERE `NUMERO_PERMIS`="'.$permis.'" ORDER BY `ID_PERMIS` DESC LIMIT 1 ');

    return !empty($getpermis) ? $getpermis : null;


  }



  function index()
  {

    $data['annees']=$this->Model->getRequete("SELECT DISTINCT date_format(historiques.DATE_INSERTION,'%Y') AS annee FROM historiques WHERE RAISON_ANNULATION IS NULL ORDER BY  annee ASC");
    $data['mois']=$this->Model->getRequete("SELECT DISTINCT date_format(historiques.DATE_INSERTION,'%m') AS mois FROM historiques WHERE RAISON_ANNULATION IS NULL ORDER BY  mois ASC");
    $data['jours']=$this->Model->getRequete("SELECT DISTINCT date_format(historiques.DATE_INSERTION,'%d') AS jours FROM historiques WHERE RAISON_ANNULATION IS NULL ORDER BY  jours ASC");

    if (empty($this->session->userdata('USER_NAME'))) {
      redirect(base_url());
    } else {
      $this->load->view('Carte_Centre_Situation_View',$data);
    }  
  }


  public function Recherche()
  {
      $key_search = $this->input->post('search');

      $critere_recherche = "";
      if(!empty($key_search)){
          $critere_recherche = ' AND psr_elements.NOM LIKE "%'.$key_search.'%" OR  psr_elements.PRENOM LIKE "%'.$key_search.'%" OR  psr_elements.NUMERO_MATRICULE LIKE "%'.$key_search.'%"';  
          }

      $requete_data = $this->Model->getRequete("SELECT NOM,PRENOM,NUMERO_MATRICULE,ID_PSR_ELEMENT from  psr_elements WHERE 1 ".$critere_recherche." ");

      // print_r($requete_data);exit();
      // href="'.base_url().'geo/Carte_Centre_Situation/get_carte/'.$key['ID_PSR_ELEMENT'].'"

      $result_data = '';
      $data_empty= 'Aucun élément trouvé';

      if (!empty($requete_data)) {

        foreach ($requete_data as $key )
        {
            $string =  $key['NOM'].' '.$key['PRENOM']; 
            $matricule =  $key['NUMERO_MATRICULE']; 

          // $result_data.='<a title='.$key['NOM'].' onclick="getMaps('.$key['ID_PSR_ELEMENT'].')" href="javascript:;">'.$string.'</a>';
          $result_data.='<a title='.$key['NOM'].' onclick="getMaps('.$key['ID_PSR_ELEMENT'].')" href="javascript:;"><ul style="margin-top: 3px" class="list-group"><li class="list-group-item"><i class="fa fa-user"> </i> '.$string.'<br><i class="fa fa-barcode"> </i> '.$matricule.'</li></ul></a>';

        }
      }
      
      // $result_data.='';

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



  function get_carte($value = '')
  {

    $zoom = 8;
    $coord = '-3.4313888,29.9079177';
    $ID = $this->input->post('ID');
    $crit = '';


    $annee=$this->input->post('annee');  
    $jour=$this->input->post('jour');
    $mois=$this->input->post('mois');
    $NUMERO_PLAQUE=$this->input->post('NUMERO_PLAQUE');
    $NUMERO_PERMIS=$this->input->post('NUMERO_PERMIS');
    $IS_PAID=$this->input->post('IS_PAID');
    $ID_CATEGORIE=$this->input->post('ID_CATEGORIE');
    $ID_PSR_ELEMENT=$this->input->post('ID_PSR_ELEMENT');
    $search=$this->input->post('search');

    
    
    $ID_CATEGORIE_NEW=$this->input->post('ID_CATEGORIE_NEW');
  
    $conduction="";

    if (!empty($ID_CATEGORIE_NEW)){
     $conduction.="  AND  h.ID_HISTORIQUE_CATEGORIE=".$ID_CATEGORIE_NEW." "; 
     }

    if ($ID_PSR_ELEMENT != ""){
       $conduction.="  AND  e.ID_PSR_ELEMENT=".$ID_PSR_ELEMENT." "; 
     }

    if ($IS_PAID != ""){
       $conduction.="  AND  h.IS_PAID=".$IS_PAID." "; 
     }

    if (!empty($ID_CATEGORIE)){
     $conduction.="  AND  h.ID_HISTORIQUE_CATEGORIE=".$ID_CATEGORIE." "; 
     }

    if(!empty($annee)){
      $conduction.=" AND date_format(h.DATE_INSERTION,'%Y')='".$annee."' ";
    }

    if(!empty($mois)){
     $conduction.=" AND date_format(h.DATE_INSERTION,'%m')= '".$mois."'  ";
    }

    if(!empty($jour)){
     $conduction.=" AND date_format(h.DATE_INSERTION,'%d')= '".$jour."'  ";
    }

    if (!empty($NUMERO_PLAQUE)) {
     $conduction.=' AND h.NUMERO_PLAQUE LIKE "%'.$NUMERO_PLAQUE.'%" '; 
    }

    if (!empty($NUMERO_PERMIS)) {
     $conduction.=' AND h.NUMERO_PERMIS LIKE "%'.$NUMERO_PERMIS.'%" ';
    }

    $conduction = !empty($conduction) ? $conduction : " AND date_format(h.DATE_INSERTION,'%Y-%m')= '".date('Y-m')."' ";

    $data_donne = '';

     $maxId = $this->Model->getRequeteOne('SELECT MAX(ID_HISTORIQUE) as maxID FROM historiques h JOIN historiques_categories c on h.ID_HISTORIQUE_CATEGORIE=c.ID_CATEGORIE LEFT JOIN utilisateurs u on u.ID_UTILISATEUR=h.ID_UTILISATEUR LEFT JOIN psr_elements e on e.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID WHERE 1 '.$conduction);


    $requete = $this->Model->getRequete('SELECT e.ID_PSR_ELEMENT,e.TELEPHONE,ID_RAISON,MONTANT, IF(IS_PAID=1,"Paié","Non Paié") as PAID,`ID_HISTORIQUE`,h.LATITUDE,h.LONGITUDE,ID_HISTORIQUE_CATEGORIE,c.DESCRIPTION, c.COLOR,c.MARK, h.DATE_INSERTION,e.ID_PSR_ELEMENT,e.NUMERO_MATRICULE,e.NOM,e.PRENOM,NUMERO_PLAQUE as NUMERO, NUMERO_PERMIS,a.LIEU_EXACTE FROM historiques h JOIN historiques_categories c on h.ID_HISTORIQUE_CATEGORIE=c.ID_CATEGORIE LEFT JOIN utilisateurs u on u.ID_UTILISATEUR=h.ID_UTILISATEUR LEFT JOIN psr_elements e on e.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID LEFT JOIN psr_element_affectation ea ON ea.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID LEFT JOIN psr_affectatations a on a.PSR_AFFECTATION_ID=ea.PSR_AFFECTATION_ID WHERE 1 '.$conduction.' ');

    // print_r($requete);exit();

    $i = 0;
    $dernier = count($requete);
    $plaques = 0;
    $permis = 0;
    $physique = 0;
    $Scan = 0;
    $station = 0;
    $radar = 0;

    foreach ($requete as $key => $value) {

      $i++;

      $statut = 0;


      if ($value['ID_HISTORIQUE'] == $maxId['maxID']) {
        $statut = 1;
      }



      $numero = $value['NUMERO'];
      $permis = !empty($value['NUMERO_PERMIS']) ? $this->remplace_lettre($value['NUMERO_PERMIS']) : '---';

      $DESCRIPTION = $this->remplace_lettre($value['DESCRIPTION']);
      $DESCRIPTION = trim(str_replace('"', '\"', $DESCRIPTION));
      $DESCRIPTION = str_replace("\n", "", $DESCRIPTION);
      $DESCRIPTION = str_replace("\r", "", $DESCRIPTION);
      $DESCRIPTION = str_replace("\t", "", $DESCRIPTION);



      $DATE_INSERTION = $value['DATE_INSERTION'];
      $NUMERO_MATRICULE = $value['NUMERO_MATRICULE'];

      $lat = $value['LATITUDE'];
      $long = $value['LONGITUDE'];

      $provinces = $value['NUMERO_MATRICULE'];

      $color = '';
      $marker = '';
      $annule = 0;

      
      if (!empty($value['ID_RAISON'])) {
        $color = '848484';
        $marker = 'civic-building';
        $annule = 2;
        $Scan++;
      }else{
        $color = $value['COLOR'];
        $marker = $value['MARK'];
        $annule = 1;
      }


      $amande = !empty($value['MONTANT']) ? number_format($value['MONTANT'], 0, ',', ' ') . " FBU (" . $value['PAID'] . ")" : "000 FBU";

      $data_donne .= $lat . '<>' . $long . '<>' . $this->remplace_lettre($DESCRIPTION) . '<>' . $this->remplace_lettre($value['NUMERO']) . '<>' . $DATE_INSERTION . '<>' .$this->remplace_lettre($value['NOM'].' '.$value['PRENOM']) . '<>' . $statut . '<>' . $NUMERO_MATRICULE . '<>' . $value['ID_HISTORIQUE_CATEGORIE'] . '<>' . $this->remplace_lettre($plaques) . '<>' . $this->remplace_lettre($permis) . '<>' . $physique . '<>' . $Scan . '<>' . $amande . '<>' . $this->remplace_lettre($value['LIEU_EXACTE']) .'<>'. $value['ID_HISTORIQUE']. '<>'. $annule. '<>' .$color. '<>' .$marker. '<>'.$value['ID_PSR_ELEMENT']. '<>' .$value['TELEPHONE']. '<>' .$permis. '<>' . '$';
    }

    // print_r($data_donne);exit();

    $labe = $this->Model->getRequete("SELECT COUNT(ID_HISTORIQUE_CATEGORIE) as nombr,ID_HISTORIQUE_CATEGORIE,ca.DESCRIPTION,ca.COLOR FROM historiques h JOIN historiques_categories ca on h.ID_HISTORIQUE_CATEGORIE=ca.ID_CATEGORIE  LEFT JOIN utilisateurs u on u.ID_UTILISATEUR=h.ID_UTILISATEUR LEFT JOIN psr_elements e on e.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID WHERE ID_RAISON is null ".$conduction." GROUP BY ID_HISTORIQUE_CATEGORIE ,ca.DESCRIPTION,ca.COLOR ");

    $ihm = "";

    $js = "";

    foreach ($labe as $key => $labe) {
    $ihm.= "<tr>
         <td width='100%'><span style='width: 15px;height: 15px;border-radius: 10px;background:#".$labe['COLOR']."' ;'></span>&emsp;<input type='checkbox' checked  name='opt".$labe['ID_HISTORIQUE_CATEGORIE']."'> ".ucfirst($labe['DESCRIPTION'])." (<a href='#' onclick='getincident(1)'>".number_format($labe['nombr'],0,',',' ')."</a>)</td>
         </tr>";

    $js.= '$(\'input[name="opt'.$labe['ID_HISTORIQUE_CATEGORIE'].'"]\').click(function(){
  
            if($(this).is(":checked")){
                 
                map.addLayer(markers'.$labe['ID_HISTORIQUE_CATEGORIE'].');
              

            }else if($(this).is(":not(:checked)")){

                
                map.removeLayer(markers'.$labe['ID_HISTORIQUE_CATEGORIE'].');
             
            }
            });';
    }




    //print_r($data_donne);die();
    $data['labels'] = $ihm;
    $data['jsfiltre'] = $js;


    $data['data_donne'] = $data_donne;
    $data['plaques'] = $plaques;
    $data['permis'] = $permis;
    $data['physique'] = $physique;
    $data['Scan'] = $Scan;

    // $data['PROVINCE_ID'] = 3;
    // $data['provinces'] = $this->Model->getRequete('SELECT * FROM syst_provinces WHERE 1 ');




    $data['categorie']=$this->Model->getRequete('SELECT ID_CATEGORIE,DESCRIPTION FROM `historiques_categories` WHERE 1'); 



    $data['dernier'] = $this->Model->getRequeteOne('SELECT e.ID_PSR_ELEMENT,e.TELEPHONE,ID_RAISON,MONTANT, IF(IS_PAID=1,"Paié","Non Paié") as PAID,`ID_HISTORIQUE`,h.LATITUDE,h.LONGITUDE,ID_HISTORIQUE_CATEGORIE,c.DESCRIPTION, c.COLOR,c.MARK, h.DATE_INSERTION,e.NUMERO_MATRICULE,e.NOM,e.PRENOM,NUMERO_PLAQUE as NUMERO,a.LIEU_EXACTE FROM historiques h JOIN historiques_categories c on h.ID_HISTORIQUE_CATEGORIE=c.ID_CATEGORIE LEFT JOIN utilisateurs u on u.ID_UTILISATEUR=h.ID_UTILISATEUR LEFT JOIN psr_elements e on e.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID LEFT JOIN psr_element_affectation ea ON ea.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID LEFT JOIN psr_affectatations a on a.PSR_AFFECTATION_ID=ea.PSR_AFFECTATION_ID WHERE 1 '.$conduction.'  ORDER BY h.ID_HISTORIQUE DESC LIMIT 1 ');

    if ($ID == 1) {
      $zoom = 18;
      $coord = '' . $data['dernier']['LATITUDE'] . ',' . $data['dernier']['LONGITUDE'] . '';
    }




    $data['dernier_2'] = $this->Model->getRequete('SELECT e.ID_PSR_ELEMENT,e.TELEPHONE,ID_RAISON,MONTANT, IF(IS_PAID=1,"Paié","Non Paié") as PAID,`ID_HISTORIQUE`,h.LATITUDE,h.LONGITUDE,ID_HISTORIQUE_CATEGORIE,c.DESCRIPTION, c.COLOR,c.MARK, h.DATE_INSERTION,e.NUMERO_MATRICULE,e.NOM,e.PRENOM,NUMERO_PLAQUE as NUMERO,a.LIEU_EXACTE FROM historiques h JOIN historiques_categories c on h.ID_HISTORIQUE_CATEGORIE=c.ID_CATEGORIE LEFT JOIN utilisateurs u on u.ID_UTILISATEUR=h.ID_UTILISATEUR LEFT JOIN psr_elements e on e.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID LEFT JOIN psr_element_affectation ea ON ea.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID LEFT JOIN psr_affectatations a on a.PSR_AFFECTATION_ID=ea.PSR_AFFECTATION_ID WHERE 1  '.$conduction.' ORDER BY h.ID_HISTORIQUE DESC LIMIT 10');

    $data['zoom'] = $zoom;
    $data['coord'] = $coord;
    $data['annee'] = $annee;
    $data['jour'] = $jour;
    $data['mois'] = $mois;
    $data['NUMERO_PLAQUE'] = $NUMERO_PLAQUE;
    $data['NUMERO_PERMIS'] = $NUMERO_PERMIS;
    $data['IS_PAID'] = $IS_PAID;
    $data['ID_CATEGORIE'] = $ID_CATEGORIE;
    $data['search'] = $search;

    $map = $this->load->view('Get_Situation', $data, TRUE);
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

    $get = $this->Model->getRequeteOne('SELECT COUNT(*) AS Nbr,ID_HISTORIQUE_CATEGORIE FROM historiques WHERE NEW=0 GROUP by ID_HISTORIQUE_CATEGORIE LIMIT 1');

    $send = 0;
    if ($get['Nbr'] > 0) {
      $send = 1;
      $this->Model->update('historiques', array('NEW' => 0), array('NEW' => 1));
    }


    $output = array('nbr' => $send,'catego' => $get['ID_HISTORIQUE_CATEGORIE']);
    echo json_encode($output);
  }



  function remplace_lettre($message = "")
  {

    $message = str_replace('é', 'e', $message);

      $message = trim(str_replace('"', '\"', $message));
      $message = str_replace("\n", "", $message);
      $message = str_replace("\r", "", $message);
      $message = str_replace("\t", "", $message);
      $message = str_replace("'", "\'", $message);

    return  $message;
  }
}
