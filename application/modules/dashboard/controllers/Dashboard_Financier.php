<?php

class Dashboard_Financier extends CI_Controller
{

          function index()
          {

        
                  
$dattes=$this->Model->getRequete("SELECT DISTINCT date_format(DATE_INSERTION,'%Y') AS mois FROM historiques ORDER BY  mois DESC");

  
$data['dattes']=$dattes;
$DATEtet=date('Y');
$data['anneesonne'] =$this->Model->getRequeteOne('SELECT DISTINCT DATE_FORMAT(DATE_INSERTION, "%Y") as ANNh from historiques where DATE_FORMAT(DATE_INSERTION, "%Y")='.$DATEtet.' ');

  
 $this->load->view("Dashboard_Financier_View", $data);
          }

      function detailsignd()
    {
    
  $mois=$this->input->post('mois');  
 $IS_PAID=$this->input->post('IS_PAID');
  $jour=$this->input->post('jour');
  $DATE2=$this->input->post('DATE2');
  $DATE1=$this->input->post('DATE1');

 $KEY=$this->input->post('key');
 $KEY2=$this->input->post('key2');
$break=explode(".",$KEY2);
$ID=$KEY2;
        
$criteres_date=""; 


if ($ID!="") {

 $criteres_date .= " and signalement_civil_agent_new.IS_ANNULE = ". $ID." ";

                   
                    }        

$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $query_principal = "SELECT `IMAGE_UNE`,`PLAQUE_NUMERO`,IF(IS_ANNULE=1,'Annule','Mentenue') AS ANNULE,NOM_UTILISATEUR,NOM_CITOYEN,`DATE_SIGNAL`,IF(ID_CATEGORIE_SIGNALEMENT=1, 'Voiture','Agent') AS CATEGORIE,`AMANDE_EQUIVAUX` FROM `signalement_civil_agent_new` LEFT JOIN utilisateurs on utilisateurs.ID_UTILISATEUR=signalement_civil_agent_new.ID_UTILISATEUR  WHERE 1 ".$criteres_date." and AMANDE_EQUIVAUX <> 0 ";



    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $limit = 'LIMIT 0,10';


    if ($_POST['length'] != -1) {
      $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }

    $order_by = '';


    $order_column = array('DATE_SIGNAL', 'PLAQUE_NUMERO', 'NOM_UTILISATEUR', 'AMANDE_EQUIVAUX');
    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_SIGNAL DESC ';

    $search = !empty($_POST['search']['value']) ? ("AND PLAQUE_NUMERO LIKE '%$var_search%' ") : '';

    $critaire = '';


if(!empty($mois)  && !empty($jour) && !empty($DATE1) && empty($DATE2)) {

  $critaire = " and DATE_FORMAT(DATE_SIGNAL, '%d-%m-%Y')='" . $DATE1."' and DATE_FORMAT(DATE_SIGNAL,'%H')='" . $KEY."'";

   
      }else if(!empty($mois)  && !empty($jour) && empty($DATE1) && !empty($DATE2)){
      $critaire = " and DATE_FORMAT(DATE_SIGNAL, '%d-%m-%Y')='" . $DATE2."' and DATE_FORMAT(DATE_SIGNAL,'%H')='" . $KEY."'";  
      }else{
      $critaire = " and DATE_FORMAT(DATE_SIGNAL, '%d-%m-%Y')='" . $KEY."'";  
      }

    $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

    $fetch_psr = $this->Modele->datatable($query_secondaire);
    $data = array();

    foreach ($fetch_psr as $row) {

      $sub_array[] = $row->NOM_UTILISATEUR;
      $sub_array[] = $row->PLAQUE_NUMERO;
      $sub_array[] =$row->CATEGORIE;
      $sub_array[] =$row->ANNULE;
      $sub_array[] =$row->DATE_SIGNAL;
      $sub_array[] =$row->AMANDE_EQUIVAUX; 
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


          

   //detail des amandes   
function detail()
    {
    
  $mois=$this->input->post('mois');  
  $ID_ASSUREUR=$this->input->post('ID_ASSUREUR');
  $jour=$this->input->post('jour');
  $DATE2=$this->input->post('DATE2');
  $DATE1=$this->input->post('DATE1');
  $IS_PAID=$this->input->post('IS_PAID');
      
 $KEY=$this->input->post('key');
 $KEY2=$this->input->post('key2');
$break=explode(".",$KEY2);
$ID=$KEY2;
        
$criteres_date=""; 


if ($ID!="") {

 $criteres_date .= " and h.ID_HISTORIQUE_STATUT = ". $ID." ";

                   
                    } 



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $query_principal = 'SELECT h.ID_COMPORTEMENT, h.RAISON_ANNULATION, ID_CONTROLE_MARCHANDISE,ID_HISTORIQUE,h.ID_CONTROLE,h.ID_HISTORIQUE_CATEGORIE, hc.DESCRIPTION as historique_categorie,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_IMMATRICULATIO_PEINE) AS IMMATRICULATION,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_ASSURANCE_PEINE) AS ASSURANCE,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_CONTROLE_TECHNIQUE_PEINE) AS CONTROL_TECHNIQUE,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_VOL_PEINE) AS VOL,(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_PERMIS_PEINE) AS PERMIS_PEINE, h.NUMERO_PLAQUE ,ID_IMMATRICULATIO_PEINE,ID_ASSURANCE_PEINE,ID_CONTROLE_TECHNIQUE_PEINE,ID_VOL_PEINE,ID_PERMIS_PEINE, NUMERO_PERMIS, concat(pe.NOM," ",pe.PRENOM) as user,pe.NUMERO_MATRICULE,pe.ID_PSR_ELEMENT, h.LATITUDE, h.LONGITUDE,h.DATE_INSERTION,h.MONTANT,h.IS_PAID,ID_CONTROLE_EQUIPEMENT,ID_SIGNALEMENT FROM historiques h LEFT JOIN historiques_categories hc ON h.ID_HISTORIQUE_CATEGORIE=hc.ID_CATEGORIE LEFT JOIN utilisateurs us ON us.ID_UTILISATEUR=h.ID_UTILISATEUR  LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT = us.PSR_ELEMENT_ID WHERE 1 AND IS_FINISHED=1 AND h.MONTANT<>0 '.$criteres_date.' ';



    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $limit = 'LIMIT 0,10';


    if ($_POST['length'] != -1) {
      $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }

    $order_by = '';


    $order_column = array('user', 'DATE_INSERTION', 'historique_categorie', 'RAISON_ANNULATION', 'NUMERO_PLAQUE', 'NUMERO_PERMIS', 'MONTANT', 'IS_PAID', 'DATE_INSERTION');
    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_INSERTION DESC ';

    $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%' ") : '';

    $critaire = '';

    if(!empty($mois)  && !empty($jour) && !empty($DATE1) && empty($DATE2)) {

  $critaire = " and DATE_FORMAT(h.`DATE_INSERTION`, '%d-%m-%Y')='" . $DATE1."' and DATE_FORMAT(h.`DATE_INSERTION`,'%H')='" . $KEY."'";

   
      }else if(!empty($mois)  && !empty($jour) && empty($DATE1) && !empty($DATE2)){
      $critaire = " and DATE_FORMAT(h.`DATE_INSERTION`, '%d-%m-%Y')='" . $DATE2."' and DATE_FORMAT(h.`DATE_INSERTION`,'%H')='" . $KEY."'";  
      }else{
      $critaire = " and DATE_FORMAT(h.`DATE_INSERTION`, '%d-%m-%Y')='" . $KEY."'";  
      }

    $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

    $fetch_psr = $this->Modele->datatable($query_secondaire);
    $data = array();

    foreach ($fetch_psr as $row) {

      $controleMarch = '';
      $controleSignale = '';
      $controleSignalement = '';
      $controleEquipement = '';
      $controleEquipe = '';
      $controlePhysique = '';
      $controlePhy = '';
      $infraplaque = '';
      $infrassur = '';
      $infracontrp = '';
      $infravol = '';
      $infrapermis = '';
      $plaque = '';
      $permis = '';
      $AutresControles = '';
      $option = '';




      if ($row->ID_COMPORTEMENT != Null) {
        $comportementPermis = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $comportementPermis = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }


      $comportPermis = "<a hre='#' data-toggle='modal'
      data-target='#detailComport" . $row->ID_HISTORIQUE . "'>" . $comportementPermis . "</a>";


      $comportPermis .= "<div class='modal fade' id='detailComport" . $row->ID_HISTORIQUE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du Control permis</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_COMPORTEMENT != Null) {
        $comportPermis .= $this->getDetailComport($row->ID_COMPORTEMENT);
      }

      $comportPermis .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";






      if ($row->IMMATRICULATION != Null) {
        $infra = $row->IMMATRICULATION;
      } else {
        $infra = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
      }
      if ($row->ASSURANCE != Null) {
        $infrassur = $row->ASSURANCE;
      } else {
        $infrassur = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
      }
      if ($row->CONTROL_TECHNIQUE != Null) {
        $infracontrp = $row->CONTROL_TECHNIQUE;
      } else {
        $infracontrp = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
      }
      if ($row->VOL != Null) {
        $infravol = $row->VOL;
      } else {
        $infravol = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-times"></i></a>';
      }
      if ($row->PERMIS_PEINE != Null) {
        $infrapermis = $row->PERMIS_PEINE;
      } else {
        $infrapermis = !empty($row->NUMERO_PERMIS) ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }

      if ($row->NUMERO_PLAQUE != Null) {
        $plaques = $this->getPlaques($row->NUMERO_PLAQUE);

        if ($plaques != null) {
          $plaque = "<a  class='btn btn-md dt-button btn-sm' href='" . base_url('PSR/Obr_Immatriculation/show_vehicule/' . $plaques . '/' . $row->NUMERO_PLAQUE) . "'>" . $row->NUMERO_PLAQUE . "</a>";
        } else {
          $plaque = "<div class='btn btn-outline-danger''>" . $row->NUMERO_PLAQUE . "</div>";
        }
      } else {
        $plaque = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }
      if ($row->MONTANT != Null) {
        $montant = $row->MONTANT;
      } else {
        $montant = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
      }
      if ($row->NUMERO_PERMIS != Null) {
        $idPermit = $this->getPermis($row->NUMERO_PERMIS);

        if ($idPermit != null) {
          $permis = "<a  class='btn btn-md dt-button btn-sm' href='" . base_url('ihm/
            Permis/index/' . $idPermit) . "'>" . $row->NUMERO_PERMIS . "</a>";
        } else {
          $permis = "<span style='color :red'>" . $row->NUMERO_PERMIS . "</span>";
        }
      } else {
        $permis = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }

      if ($row->ID_CONTROLE != Null) {
        $controlePhy = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $controlePhysique = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }

      if ($row->ID_CONTROLE_EQUIPEMENT != Null) {
        $controleEquipe = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $controleEquipe = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }

      if ($row->ID_SIGNALEMENT != Null) {
        $controleSignale = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $controleSignalement = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }


      if ($row->ID_CONTROLE_MARCHANDISE != Null) {
        $controleMarch = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $controleMarch = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }



      $detailMarch = "<a hre='#' data-toggle='modal'
      data-target='#detailMarchs" . $row->ID_HISTORIQUE . "'>" . $controleMarch . "</a>";


      $detailMarch .= "<div class='modal fade' id='detailMarchs" . $row->ID_HISTORIQUE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du Controle Machandise</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_CONTROLE_MARCHANDISE != Null) {
        $detailMarch .= $this->getDetailMarchandise($row->ID_CONTROLE_MARCHANDISE);
      }

      $detailMarch .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";



      $detailSign = '';

      $detailSign .= "<a hre='#' data-toggle='modal'
      data-target='#detail" . $row->ID_SIGNALEMENT . "'>" . $controleSignale . "</a>";
      $detailSign .= "
      <div class='modal fade' id='detail" . $row->ID_SIGNALEMENT . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du Controle Pysique</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_SIGNALEMENT != Null) {
        $detailSign .= $this->getDetaisSign($row->ID_SIGNALEMENT);
      }

      $detailSign .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";

      $detail = '';

      $detail .= "<a hre='#' data-toggle='modal'
      data-target='#detail" . $row->ID_CONTROLE . "'>" . $controlePhy . "</a>";
      $detail .= "
      <div class='modal fade' id='detail" . $row->ID_CONTROLE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du controle Physique</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_CONTROLE != Null) {
        $detail .= $this->getDetais($row->ID_CONTROLE);
      }

      $detail .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";



      $detailEqui = '';

      $detailEqui .= "<a hre='#' data-toggle='modal'
      data-target='#detailEquips" . $row->ID_CONTROLE_EQUIPEMENT . "'>" . $controleEquipe . "</a>";
      $detailEqui .= "
      <div class='modal fade' id='detailEquips" . $row->ID_CONTROLE_EQUIPEMENT . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du Controle Equipement</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_CONTROLE_EQUIPEMENT != Null) {
        $detailEqui .= $this->getDetailEQUI($row->ID_CONTROLE_EQUIPEMENT);
      }

      $detailEqui .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";



      $detailInfraimmatri = '';

      $detailInfraimmatri .= "<a hre='#' data-toggle='modal'
      data-target='#detailIMP" . $row->ID_IMMATRICULATIO_PEINE . "'><span style='color: red'>" . $infra . "</spa></a>";
      $detailInfraimmatri .= "
      <div class='modal fade' id='detailIMP" . $row->ID_IMMATRICULATIO_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";

      if ($row->ID_IMMATRICULATIO_PEINE != Null) {
        $detailInfraimmatri .= $this->getInfraImmatri($row->ID_IMMATRICULATIO_PEINE);
      }

      $detailInfraimmatri .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";

      $detailInfrassur = '';

      $detailInfrassur .= "<a hre='#' data-toggle='modal'
      data-target='#detailASSUR" . $row->ID_ASSURANCE_PEINE . "'><span style='color: red'>" . $infrassur . "</span></a>";
      $detailInfrassur .= "
      <div class='modal fade' id='detailASSUR" . $row->ID_ASSURANCE_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      $detailInfrassur .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";


      $detailInfrcontroltechnique = '';

      $detailInfrcontroltechnique .= "<a hre='#' data-toggle='modal'
      data-target='#detailCNTP" . $row->ID_CONTROLE_TECHNIQUE_PEINE . "'><span style='color: red'>" . $infracontrp . "</span></a>";
      $detailInfrcontroltechnique .= "
      <div class='modal fade' id='detailCNTP" . $row->ID_CONTROLE_TECHNIQUE_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";

      if ($row->ID_CONTROLE_TECHNIQUE_PEINE != Null) {
        $detailInfrcontroltechnique .= $this->getInfracontroleTechnique($row->ID_CONTROLE_TECHNIQUE_PEINE);
      }

      $detailInfrcontroltechnique .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";

      $detailInfravol = '';

      $detailInfravol .= "<a hre='#' data-toggle='modal'
      data-target='#detailVOL" . $row->ID_VOL_PEINE . "'><span style='color: red'>" . $infravol . "</span></a>";
      $detailInfravol .= "
      <div class='modal fade' id='detailVOL" . $row->ID_VOL_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";

      if ($row->ID_VOL_PEINE != Null) {
        $detailInfravol .= $this->getInfraVol($row->ID_VOL_PEINE);
      }

      $detailInfravol .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";


      $detailInfrapermis = '';

      $detailInfrapermis .= "<a hre='#' data-toggle='modal'
      data-target='#detailPMSP" . $row->ID_PERMIS_PEINE . "'><span style='color: red'>" . $infrapermis . "</span></a>";
      $detailInfrapermis .= "
      <div class='modal fade' id='detailPMSP" . $row->ID_PERMIS_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";

      if ($row->ID_PERMIS_PEINE != Null) {
        $detailInfrapermis .= $this->getInfraPermis($row->ID_PERMIS_PEINE);
      }

      $detailInfrapermis .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";


      $option = '<div class="dropdown ">
      <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-cog"></i>
      Action
      <span class="caret"></span></a>
      <ul class="dropdown-menu dropdown-menu-left">
      ';

      $option .= "<li><a hre='#' data-toggle='modal'
      data-target='#mydelete" . $row->ID_HISTORIQUE . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
      $option .= "<li><a class='btn-md' href='" . base_url('PSR/Historique/getDetail/' . $row->ID_HISTORIQUE) . "'><label class='text-info'>&nbsp;&nbsp;Detail</label></a></li>";

      $option .= " </ul>
      </div>
      <div class='modal fade' id='mydelete" . $row->ID_HISTORIQUE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-body'>
      <center><h5><strong>Voulez-vous supprimer l'historique de?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->historique_categorie . "</i></b></h5></center>
      </div>

      <div class='modal-footer'>
      <a class='btn btn-danger btn-md' href='" . base_url('PSR/Historique/delete/' . $row->ID_HISTORIQUE) . "'>Supprimer</a>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";


      $stat = '';

      if ($row->IS_PAID == 1) {
        $val_stat = '<button class="btn btn-info" style="white-space: nowrap">Payé</button>';
      } else {
        $val_stat = '<button class="btn btn-outline-info" style="white-space: nowrap">Non payé</button>';
      }

      $stat .= "<a href='#' data-toggle='modal'
      data-target='#stat" . $row->ID_HISTORIQUE . "'><font color='blue'>&nbsp;&nbsp;" . $val_stat . "</font></a>";

     

      $option = "<a class='btn  btn-sm btn-outline-secondary' onclick='getDetailControl(".$row->ID_HISTORIQUE.")'  href='#'>🧐voir plus...</a>";

      $sub_array = array();
      $sub_array[] =  '<a class="nav-link" href="#"><table> <tbody><tr><td><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="https://app.mediabox.bi/wasiliEate/uploads/personne.png"></td><td>' . str_replace(" ", "<span style='color:#dee2e6'>_</span>", $row->user) . '<br>' . $row->NUMERO_MATRICULE . '</td></tr></tbody></table></a>';

      $sub_array[] = "<div class='text-center text-sm'>".(new DateTime($row->DATE_INSERTION, new DateTimeZone("Africa/Bujumbura")))->format('d-m-Y') . '<br>'.(new DateTime($row->DATE_INSERTION, new DateTimeZone("Africa/Bujumbura")))->format('H:i')."</div>";
      $sub_array[] = ucfirst(str_replace('Contrôle ', '', $row->historique_categorie));
      if($row->RAISON_ANNULATION == null) {
        $annule = "<span class='btn btn-outline-info disabled'>Non</span>";
      } else {
        $annule = "<span class='btn btn-danger'>Oui</span>";
      }
      $sub_array[] = $annule;
      $sub_array[] = $plaque;
      $sub_array[] = $permis;
      $montant =  !empty($montant) ? number_format(floatval($montant), 0, ',', ' ') : 0;
      $sub_array[] = "<b style='float:right'>" . $montant . "</b>";
      $sub_array[] = $stat;

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


public function get_rapport(){ 

$mois=$this->input->post('mois');
$jour=$this->input->post('jour');
$DATE1=$this->input->post('DATE1');
$DATE2=$this->input->post('DATE2');
$IS_PAID=$this->input->post('IS_PAID');



$datte="";
$deter="";




if((!empty($mois)  && empty($jour) && !empty($DATE1) && !empty($DATE2)) || (!empty($mois)  && !empty($jour) && !empty($DATE1) && !empty($DATE2)) ){

   $coloneHisto = "DATE_FORMAT(`DATE_INSERTION`,'%d-%m-%Y')";
  $coloneSignalement = "DATE_FORMAT(`DATE_SIGNAL`,'%d-%m-%Y')";
  $criteres_signal = " and DATE_FORMAT(DATE_SIGNAL, '%Y-%m-%d') BETWEEN '" . $DATE1."' AND '" . $DATE2."' ";
  $criteres_histo = " and DATE_FORMAT(DATE_INSERTION, '%Y-%m-%d') BETWEEN '" . $DATE1."' AND '" . $DATE2."'";
$titre="du  ".strftime('%d-%m-%Y',strtotime($DATE1))."  au ".strftime('%d-%m-%Y',strtotime($DATE2))."  ";
$deter=""; 
      }

if((!empty($mois) && empty($jour) && empty($DATE1) && empty($DATE2)) || (!empty($mois) && !empty($jour) && empty($DATE1) && empty($DATE2))){


   if (!empty($jour)) 
   {
     $jour=$jour;
   }
   else
   {
 
   $my_month =$this->Model->getRequeteOne('SELECT max(DATE_FORMAT(DATE_INSERTION, "%Y-%m")) as mois from historiques where DATE_FORMAT(DATE_INSERTION, "%Y")="'.$mois.'"  ORDER BY mois DESC');
   $jour=$my_month['mois'];

   }

$coloneHisto = "DATE_FORMAT(`DATE_INSERTION`,'%d-%m-%Y')";
  $coloneSignalement = "DATE_FORMAT(`DATE_SIGNAL`,'%d-%m-%Y')";
  $criteres_signal = " and DATE_FORMAT(DATE_SIGNAL, '%Y-%m')= '" . $jour."' ";
  $criteres_histo = " and DATE_FORMAT(DATE_INSERTION, '%Y-%m') = '" . $jour."'";
$titre="du  ".strftime('%m-%Y',strtotime($jour))."  ";
  $deter="";  
      }

if(!empty($mois) && !empty($jour) && !empty($DATE1) && empty($DATE2)){

$coloneHisto = "DATE_FORMAT(`DATE_INSERTION`,'%H')";
  $coloneSignalement = "DATE_FORMAT(`DATE_SIGNAL`,'%H')";
  $criteres_signal = " and DATE_FORMAT(DATE_SIGNAL, '%Y-%m-%d')='" . $DATE1."'";
  $criteres_histo = " and DATE_FORMAT(DATE_INSERTION, '%Y-%m-%d')='" . $DATE1."'";
  $titre="du  ".strftime('%d-%m-%Y',strtotime($DATE1))." ";

    $deter=" H";
      }

if(!empty($mois)  && !empty($jour) && empty($DATE1) && !empty($DATE2)) {

$coloneHisto = "DATE_FORMAT(`DATE_INSERTION`,'%H')";
  $coloneSignalement = "DATE_FORMAT(`DATE_SIGNAL`,'%H')";
  $criteres_signal = " and DATE_FORMAT(DATE_SIGNAL, '%Y-%m-%d')='" . $DATE2."'";
  $criteres_histo = " and DATE_FORMAT(DATE_INSERTION, '%Y-%m-%d')='" . $DATE2."'";
  $titre="du  ".strftime('%d-%m-%Y',strtotime($DATE2))." ";
  $deter=" H";  
      }





$datte=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(DATE_INSERTION, "%Y-%m") as mois from historiques where DATE_FORMAT(DATE_INSERTION, "%Y")="'.$mois.'" AND DATE_FORMAT(DATE_INSERTION, "%Y-%m")!="'.date('Y-m').'"  ORDER BY mois DESC');
if ($mois==date('Y')) {
$mois_select="<option value='".date('Y-m')."'>".date('Y-m')."</option>";
}
else
{
$mois_select="";
}
    foreach ($datte as $value)
         {

        if ($jour==$value['mois'])
              {
      $mois_select.="<option value='".$value['mois']."' selected>".$value['mois']."</option>";
                                } else{ 
    $mois_select.="<option value='".$value['mois']."'>".$value['mois']."</option>";
      } 
      } 



                    $nombresign = 0;
                    $nombrehist = 0;
                    $nombre = 0;
                    $nombrean = 0;
                    $nombre2v = 0;
                    $nombre2ap = 0;
                    $nombre2ann = 0;
                    $nombre2 = 0;


                    $catego = "";
                    $catego2 = "";

                    $datas2 = '';
                    $datas2v = '';
                    $datas2ap = '';
                    $datas2ann = '';
                    $datas = "";
                    $datasan = "";

                    $Amendes_hatt = $this->Modele->getRequete("SELECT ".$coloneHisto." as DATE_h,SUM(MONTANT) as att FROM `historiques` where 1 AND IS_FINISHED=1 ".$criteres_histo." and ID_HISTORIQUE_STATUT =1 AND IS_FINISHED=1 and ID_SIGNALEMENT IS NULL GROUP BY DATE_h ORDER BY DATE_h ASC");
                    $Amendes_hvalidp = $this->Modele->getRequete(" SELECT ".$coloneHisto." as DATE_h,SUM(MONTANT) as validp FROM `historiques` where 1 AND IS_FINISHED=1 ".$criteres_histo." and ID_HISTORIQUE_STATUT =2 AND IS_FINISHED=1 and ID_SIGNALEMENT IS NULL GROUP BY DATE_h ORDER BY DATE_h ASC");

                    $Amendes_hvalidap = $this->Modele->getRequete(" SELECT ".$coloneHisto." as DATE_h,SUM(MONTANT) as validap FROM `historiques` where 1 AND IS_FINISHED=1 ".$criteres_histo." and ID_HISTORIQUE_STATUT =3 AND IS_FINISHED=1 and ID_SIGNALEMENT IS NULL GROUP BY DATE_h ORDER BY DATE_h ASC");

                    $Amendes_hannule = $this->Modele->getRequete(" SELECT ".$coloneHisto." as DATE_h,SUM(MONTANT) as annule FROM `historiques` where 1 AND IS_FINISHED=1 ".$criteres_histo." and ID_HISTORIQUE_STATUT =4 AND IS_FINISHED=1 and ID_SIGNALEMENT IS NULL GROUP BY DATE_h ORDER BY DATE_h ASC");
                    


                   

                   

                    $Amendes_s = $this->Modele->getRequete("SELECT  ".$coloneSignalement." as DATE_s,(SELECT SUM(AMANDE_EQUIVAUX) FROM signalement_civil_agent_new where ".$coloneSignalement." = DATE_s ". $criteres_signal ." AND IS_ANNULE =0) AS tenue,(SELECT SUM(AMANDE_EQUIVAUX) FROM signalement_civil_agent_new where ".$coloneSignalement." = DATE_s and AMANDE_EQUIVAUX <> 0 ". $criteres_signal ." AND IS_ANNULE =1) AS annul FROM signalement_civil_agent_new  LEFT JOIN  historiques ON historiques.ID_SIGNALEMENT=signalement_civil_agent_new.ID_SIGNALEMENT_NEW where 1 and AMANDE_EQUIVAUX <> 0 AND historiques.ID_SIGNALEMENT=1 ". $criteres_signal ." GROUP BY DATE_s");


                     
      
                    if (!empty($Amendes_s)) {
                 
                        foreach ($Amendes_s as  $value) {
                            $mm = !empty($value['tenue']) ? $value['tenue'] : 0;
                            $mman = !empty($value['annul']) ? $value['annul'] : 0;
                            $date  =  !empty($value['DATE_s']) ? $value['DATE_s'] : date('d-m-Y');
                            $catego .= "'" . $date . " ".$deter."',";
                            $datas .="{y:".$mm.",key:'".$date."',key2:0},";
                            $datasan .="{y:".$mman.",key:'".$date."',key2:1},";
                            $nombre += $mm;
                            $nombrean += $mman;
                            $nombresign =$mm+$mman;
                        }

                          
                    }else{

                            $mm = 0;
                            $mman = 0;
                            $date  =  date('d-m-Y');
                            $catego .= "'" . $date . " ',";
                            $datas .="{y:".$mm.",key:'".$date."',key2:0},";
                            $datasan .="{y:".$mman.",key:'".$date."',key2:1},";
                            $nombre += $mm;
                            $nombrean += $mman;
                            $nombresign =$mm+$mman;
                    

                    }

$data_att=" "; 
$data_valip=" ";
$data_valap=" ";
$data_ann=" ";
$total_att=0; 
$total_valip=0;
$total_valap=0;
$total_ann=0;

 foreach ($Amendes_hatt as  $value) {  
            
$key_id1=!empty($value['DATE_h']) ? $value['DATE_h'] : date('d-m-Y');
$sommeatt=($value['att']>0) ? $value['att'] : "0" ;
$date  =  !empty($value['DATE_h']) ? $value['DATE_h']." ".$deter." " : date('d-m-Y');
$data_att.="{name:'".str_replace("'","\'", $date)."', y:". $sommeatt." ,key2:1,key:'". $key_id1."'},";

$total_att=$total_att+$value['att'];
  
     }

foreach ($Amendes_hvalidp as  $value) {  
            
$key_id1=!empty($value['DATE_h']) ? $value['DATE_h'] : date('d-m-Y');
$sommevalip=($value['validp']>0) ? $value['validp'] : "0" ;
$date  =  !empty($value['DATE_h']) ? $value['DATE_h']." ".$deter." " : date('d-m-Y');
$data_valip.="{name:'".str_replace("'","\'", $date)."', y:". $sommevalip." ,key2:2,key:'". $key_id1."'},";

$total_valip=$total_valip+$value['validp'];
  
     }

foreach ($Amendes_hvalidap as  $value) {  
            
$key_id1=!empty($value['DATE_h']) ? $value['DATE_h'] : date('d-m-Y');
$sommevalap=($value['validap']>0) ? $value['validap'] : "0" ;
$date  =  !empty($value['DATE_h']) ? $value['DATE_h']." ".$deter." " : date('d-m-Y');
$data_valap.="{name:'".str_replace("'","\'", $date)."', y:". $sommevalap." ,key2:3,key:'". $key_id1."'},";

$total_valap=$total_valap+$value['validap'];
  
     }

foreach ($Amendes_hannule as  $value) {  
            
$key_id1=!empty($value['DATE_h']) ? $value['DATE_h'] : date('d-m-Y');
$sommeann=($value['annule']>0) ? $value['annule'] : "0" ;
$date  =  !empty($value['DATE_h']) ? $value['DATE_h']." ".$deter." " : date('d-m-Y');
$data_ann.="{name:'".str_replace("'","\'", $date)."', y:". $sommeann." ,key2:4,key:'". $key_id1."'},";

$total_ann=$total_ann+$value['annule'];
  
     }



                    $catego .= "@";
                    $catego = str_replace(",@", "", $catego);



                    $datas .= "@";
                    $datas = str_replace(",@", "", $datas);
                    $datasan .= "@";
                    $datasan = str_replace(",@", "", $datasan);


   
     $rapp="<script type=\"text/javascript\">
     Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: ' Total Amende par signalement ".$titre."'
    },  
    subtitle: {
        text: '".number_format($nombresign,0,',',' ')." FBU'
    },
  
    xAxis: {
        categories: [".$catego."]
    },
    yAxis: {
        title: {
            text: 'Amende (FBU)'
        }
    },
    plotOptions: {
        line: {
             pointPadding: 0.2,
            borderWidth: 0,
            depth: 40,
             cursor:'pointer',
             point:{
                events: {
                  click: function(){
$(\"#titre1\").html(\"Détails des amades  \");
$(\"#myModal1\").modal();
var row_count ='1000000';
$(\"#mytable1\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Financier/detailsignd')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
 mois:$('#mois').val(), 
jour:$('#jour').val(),
DATE2:$('#DATE2').val(),
DATE1:$('#DATE1').val(),
ID_ASSUREUR:$('#ID_ASSUREUR').val(),

}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: [
'excel', 'print','pdf'
],
language: {
\"sProcessing\":     \"Traitement en cours...\",
\"sSearch\":         \"Rechercher&nbsp;:\",
\"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
\"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
\"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
\"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
 \"sInfoPostFix\":    \"\",
\"sLoadingRecords\": \"Chargement en cours...\",
\"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
\"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
\"oPaginate\": {
\"sFirst\":      \"Premier\",
\"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
\"sNext\":       \"Suivant\",
\"sLast\":       \"Dernier\"
},
 \"oAria\": {
\"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
 \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
}
}
                              
});


                           

                   }
               }
           },
           dataLabels: {
             enabled: true,
             format: '{point.y:f}'
         },
         showInLegend: true
     }
 }, 
     credits: {
  enabled: true,
  href: \"\",
  text: \"Mediabox\"
},
    series: [{
        name: 'Amendes retenues: (" . number_format($nombre, 0, '.', ' ') . ")',
        color:'green',
        data: [".$datas."]
    },
    {
        name: 'Amendes annulées : (" . number_format($nombrean, 0, '.', ' ') . ")',
        color:'red',
        data: [".$datasan."]
    }]
});
</script>
     ";


$rapp1="<script type=\"text/javascript\">
    Highcharts.chart('container1', {
    chart: {
        type: 'column'
    },
    title: {
        text: ' Amendes totales par contrôle ".$titre."'
    },
    subtitle: {
        text: '".number_format($total_att+$total_valip+$total_valap+$total_ann,0,',',' ')." FBU'

    },
    xAxis: {
         type: 'category',
    },
    yAxis: {
        title: {
            text: 'Amende (FBU)'
        }
    },
    plotOptions: {
        column: {
             pointPadding: 0.2,
            borderWidth: 0,
            depth: 40,
             cursor:'pointer',
             point:{
                events: {
                  click: function(){
$(\"#titre\").html(\"Détails des amades \");
$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Financier/detail')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
 mois:$('#mois').val(), 
jour:$('#jour').val(),
DATE2:$('#DATE2').val(),
DATE1:$('#DATE1').val(),
ID_ASSUREUR:$('#ID_ASSUREUR').val(),

}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: [
'excel', 'print','pdf'
],
language: {
\"sProcessing\":     \"Traitement en cours...\",
\"sSearch\":         \"Rechercher&nbsp;:\",
\"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
\"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
\"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
\"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
 \"sInfoPostFix\":    \"\",
\"sLoadingRecords\": \"Chargement en cours...\",
\"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
\"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
\"oPaginate\": {
\"sFirst\":      \"Premier\",
\"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
\"sNext\":       \"Suivant\",
\"sLast\":       \"Dernier\"
},
 \"oAria\": {
\"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
 \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
}
}
                              
});


                           

                   }
               }
           },
           dataLabels: {
             enabled: true,
             format: '{point.y:,f}'
         },
         showInLegend: true
     }
 }, 
     credits: {
  enabled: true,
  href: \"\",
  text: \"Mediabox\"
},
    series: [{
        name: 'Amendes en attente de validation : (" . number_format($total_att, 0, '.', ' ') . ")',

        color:'orange',
        data: [".$data_att."  ]
    },
    {
        name: 'Amendes validées par la police au poste de contrôle : (" . number_format($total_valip, 0, '.', ' ') . ")',
        color:'green',
        data: [".$data_valip."  ]
    }
    ,
    {
        name: 'Amendes validées après traitement par le Centre des Opérations : (" . number_format($total_valap, 0, '.', ' ') . ")',
        color:'blue',
        data: [".$data_valap."  ]
    }
    ,
    {
        name: 'Amendes annulées par la police au poste de contrôle : (" . number_format($total_ann, 0, '.', ' ') . ")',
        color:'red',
        data: [".$data_ann."  ]
    }]
});
</script>
     ";

echo json_encode(array('rapp'=>$rapp,'rapp1'=>$rapp1,'select_month'=>$mois_select));
    }
  function getPlaques($plaque)
  {
    $plaque = $this->Modele->getRequeteOne("SELECT * FROM obr_immatriculations_voitures WHERE NUMERO_PLAQUE='" . $plaque . "'");
    if ($plaque != NULL) {
      return $plaque['ID_IMMATRICULATION'];
    } else {
      return 0;
    }
    //print_r($plaque);
  }

  function getPermis($permis)
  {
    $permis = $this->Modele->getRequeteOne("SELECT * FROM `chauffeur_permis` WHERE 1 AND NUMERO_PERMIS ='" . $permis . "'");
    if ($permis != NULL) {
      return $permis['ID_PERMIS'];
    } else {
      return 0;
    }
    //print_r($plaque);
  }
function getInfraVol($id_immatri = 0)
  {

    $dataDetail = 'SELECT ID_INFRA_PEINE, ID_INFRA_INFRACTION, AMENDES, MONTANT, POINTS FROM infra_peines WHERE 1 AND ID_INFRA_INFRACTION= ' . $id_immatri;


    $htmlDetail = "<div class='table-responsive'>
    <b>".$this->getIfraction($id_immatri)."</b>
    <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
    <thead>
    <tr>
    <th>Application</th>
    <th>Montant(FBU)</th>
    </tr>
    </thead>

    <tbody>";

    $total = 0;
    foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

      $total += $value['MONTANT'];
      $htmlDetail .= "<tr>
      <td>" . $value['AMENDES'] . "</td>
      <td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . "</span></td>
      </tr>";
    }

    $htmlDetail .= "<tr>
    <th>Total</th>
    <th><span style='float:right'>" . number_format($total, 0, '.', ' ') . "</th>
    </span></tr>";


    $htmlDetail .= "</tbody></table>
    </div>";


    return $htmlDetail;
  }


  function getInfracontroleTechnique($technique)
  {

    $dataDetail = 'SELECT ID_INFRA_PEINE, ID_INFRA_INFRACTION, AMENDES, MONTANT, POINTS FROM infra_peines WHERE 1 AND ID_INFRA_INFRACTION= ' . $technique;


    $htmlDetail = "<div class='table-responsive'>
    <b>".$this->getIfraction($technique)."</b>
    <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
    <thead>
    <tr>
    <th>Application</th>
    <th>Montant(FBU)</th>
    </tr>
    </thead>

    <tbody>";

    $total = 0;
    foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

      $total += $value['MONTANT'];
      $htmlDetail .= "<tr>
      <td>" . $value['AMENDES'] . "</td>
      <td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . "</span></td>
      </tr>";
    }

    $htmlDetail .= "</tbody></table>
    </div>";


    return $htmlDetail;
  }
    function getInfraImmatri($id_immatri = 0)
  {

    $dataDetail = 'SELECT ID_INFRA_PEINE, ID_INFRA_INFRACTION, AMENDES, MONTANT, POINTS FROM infra_peines WHERE 1 AND ID_INFRA_INFRACTION= ' . $id_immatri;
    // print_r($this->Modele->getRequete($dataDetail));die();

    $htmlDetail = "<div class='table-responsive'>

    <b>".$this->getIfraction($id_immatri)."</b>
    <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
    <thead>
    <tr>
    <th>Application</th>
    <th>Montant(FBU)</th>
    </tr>
    </thead>
    <tbody>";


    $total = 0;
    foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

      $total += $value['MONTANT'];
      $htmlDetail .= "<tr>
      <td>" . $value['AMENDES'] . "</td>
      <td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . "</span></td>
      </tr>";
    }

    $htmlDetail .= "<tr>
    <th>Total</th>
    <th><span style='float:right'>".number_format($total, 0, '.', ' ')."</th>
    </span></tr>";


    // </div></th>
    //                </tr>";

    $htmlDetail .= "</tbody></table>
    </div>";


    return $htmlDetail;
  }

  function getIfraction($id){

    $dataDetail = 'SELECT `NIVEAU_ALERTE` FROM `infra_infractions` WHERE `ID_INFRA_INFRACTION`= ' . $id;
    $donne = $this->Modele->getRequeteOne($dataDetail);

       //print_r($id);exit();

    return $donne['NIVEAU_ALERTE'];

  }

  function gethistoControl($id){

    $query_principal = 'SELECT h.ID_COMPORTEMENT, ID_CONTROLE_MARCHANDISE,ID_HISTORIQUE,h.ID_CONTROLE,h.ID_HISTORIQUE_CATEGORIE, hc.DESCRIPTION as historique_categorie,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_IMMATRICULATIO_PEINE) AS IMMATRICULATION,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_ASSURANCE_PEINE) AS ASSURANCE,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_CONTROLE_TECHNIQUE_PEINE) AS CONTROL_TECHNIQUE,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_VOL_PEINE) AS VOL,(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_PERMIS_PEINE) AS PERMIS_PEINE, h.NUMERO_PLAQUE ,ID_IMMATRICULATIO_PEINE,ID_ASSURANCE_PEINE,ID_CONTROLE_TECHNIQUE_PEINE,ID_VOL_PEINE,ID_PERMIS_PEINE, NUMERO_PERMIS, concat(pe.NOM," ",pe.PRENOM) as user,pe.NUMERO_MATRICULE,pe.ID_PSR_ELEMENT, h.LATITUDE, h.LONGITUDE,h.DATE_INSERTION,h.MONTANT,h.IS_PAID,ID_CONTROLE_EQUIPEMENT,ID_SIGNALEMENT FROM historiques h LEFT JOIN historiques_categories hc ON h.ID_HISTORIQUE_CATEGORIE=hc.ID_CATEGORIE LEFT JOIN utilisateurs us ON us.ID_UTILISATEUR=h.ID_UTILISATEUR  LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT = us.PSR_ELEMENT_ID WHERE 1 and ID_HISTORIQUE='.$id;




    $data=$this->Modele->getRequeteOne($query_principal);

    $controle='';
    $controle_technique='';
    $assurance='';
    $permis='';
    $vol='';
    $comportement='';
    $detailControle='';
    $equipement='';

    $marchandise='';
    $titre = $data['historique_categorie'].' de la plaque '.$data['NUMERO_PLAQUE'].' '.$data['DATE_INSERTION'];
     //print_r($data['ID_IMMATRICULATIO_PEINE']);exit();
    if($data['ID_IMMATRICULATIO_PEINE'] !=null){
      $controle=$this->getInfraImmatri($data['ID_IMMATRICULATIO_PEINE']);
    }

    //print_r($controle);exit();
    
    if($data['ID_CONTROLE_TECHNIQUE_PEINE'] !=null){
      $controle_technique =$this->getInfracontroleTechnique($data['ID_CONTROLE_TECHNIQUE_PEINE']) ;
    }

    if($data['ID_ASSURANCE_PEINE'] !=null){
      $assurance =$this->getInfrassur($data['ID_ASSURANCE_PEINE']);
    }

    if($data['ID_VOL_PEINE'] !=null){
      $vol =$this->getInfraVol($data['ID_VOL_PEINE']);
      
    }

    if($data['ID_PERMIS_PEINE'] !=null){
      $permis =$this->getInfraPermis($data['ID_PERMIS_PEINE']);
      
    }


    if($data['ID_COMPORTEMENT'] !=null){
      $comportement =$this->getDetailComport($data['ID_COMPORTEMENT']);
      
    }

    if($data['ID_CONTROLE'] !=null){
      $detailControle =$this->getDetais($data['ID_CONTROLE']);
      
    }

    if($data['ID_CONTROLE_EQUIPEMENT'] !=null){
      $equipement =$this->getDetailEQUI($data['ID_CONTROLE_EQUIPEMENT']);
      
    }

    if($data['ID_CONTROLE_MARCHANDISE'] !=null){
      $marchandise =$this->getDetailMarchandise($data['ID_CONTROLE_MARCHANDISE']);
      
    }


    

       //print_r($controle_technique);exit();

    $data['immatriculation'] = $controle;
    $data['vol'] = $vol;
    $data['assurance'] = $assurance;
    $data['permis'] = $permis;
    $data['controle_technique'] = $controle_technique;
    $data['comportement'] = $comportement;
    $data['detailControle'] = $detailControle;
    $data['equipement'] = $equipement;
    $data['marchandise'] = $marchandise;


    $data['historique'] = $query_principal;
    $data['title'] = 'Contrôle ';

    $map = $this->load->view('detail_view_map', $data, TRUE);
    $output = array('views_detail' => $map, 'id' => $id,'titres'=>$titre);
    echo json_encode($output);



  }

    function getInfraPermis($id_immatri = 0)
  {
    $dataDetail = 'SELECT ID_INFRA_PEINE, ID_INFRA_INFRACTION, AMENDES, MONTANT, POINTS FROM infra_peines WHERE 1 AND ID_INFRA_INFRACTION= ' . $id_immatri;


    $htmlDetail = "<div class='table-responsive'>
    <b>".$this->getIfraction($id_immatri)."</b>
    <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
    <thead>
    <tr>
    <th>Application</th>
    <th>Montant(FBU)</th>
    </tr>
    </thead>

    <tbody>";

    $total = 0;
    foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

      $total += $value['MONTANT'];
      $htmlDetail .= "<tr>
      <td>" . $value['AMENDES'] . "</td>
      <td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . "</span></td>
      </tr>";

    }

    $htmlDetail .= "<tr>
    <th>Total</th>
    <th><span style='float:right'>" . number_format($total, 0, '.', ' ') . "</th>
    </span></tr>";

    

    $htmlDetail .= "</tbody></table>
    </div>";


    return $htmlDetail;
  }
function getDetailComport($id_control = 0)
  {

    $dataDetail = 'SELECT au.ID_AUTRES_CONTROLES,q.ID_CONTROLES_QUESTIONNAIRES,q.INFRACTIONS,q.MONTANT,au.DESCRP_REPONSE,au.IMAGE_1,au.IMAGE_2,au.IMAGE_3, acqr.REPONSE_DECRP,q.NEED_IDENTITE FROM historiques h JOIN autres_controles au on au.ID_CONTROLE_PLAQUE =h.ID_COMPORTEMENT JOIN autres_controles_questionnaires q on q.ID_CONTROLES_QUESTIONNAIRES=au.ID_CONTROLES_QUESTIONNAIRES LEFT JOIN autres_contr_quest_rp acqr on acqr.ID_REPONSE=au.ID_REPONSE  WHERE h.ID_COMPORTEMENT = ' . $id_control;

    $htmlDetail="";
    $image="";
    $total = 0;
    $htmlDetail .= "<div class='table-responsive'><b></b>
    <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
    <thead>
    <tr>
    <th>Application</th>
    <th>Montant(FBU)</th>
    <th>Img</th>
    <th>Identité</th>";
    $htmlDetail .="</thead>

    <tbody>";
        


    foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

      if(!empty($value['IMAGE_1'])){
        $image.=$value['IMAGE_1']."#";
      }
      if(!empty($value['IMAGE_2'])){
        $image.=$value['IMAGE_2']."#";
      }
      if(!empty($value['IMAGE_3'])){
        $image.=$value['IMAGE_3'];
      }



      if(!empty($image)){
        $imagedata ="<a href='#' title='". $image."' onclick='showviewImage(this.title)'><i class='fa fa-eye'></i></a>";
      }else{
        $imagedata="";
      }


       if($value['NEED_IDENTITE']==1){
        $optidentite = "<a class='btn  btn-sm btn-outline-secondary' onclick='getIdentite(".$value['ID_CONTROLES_QUESTIONNAIRES'].")'  href='#'>🧐concernés(".$this->getNombreConcerne($value['ID_CONTROLES_QUESTIONNAIRES']).")</a>";
       }else{
        $optidentite ="";
       }
    



      $total += $value['MONTANT'];
      $reponse=!empty($value['REPONSE_DECRP']) ? "(".$value['REPONSE_DECRP'].")" : "";
      $description=!empty($value['DESCRP_REPONSE']) ? "(".$value['DESCRP_REPONSE'].")" : "";

      $htmlDetail .= "<tr>
      <td>" . $value['INFRACTIONS']. $reponse. $description."</td>
      <td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . "</span></td>
      <td>".$imagedata."</td>

      <td>".$optidentite."</td>

      </tr>";
      //$descri=; 

    }
    $htmlDetail .= "<tr>
    <th >Total</th>
    <th colspan='3'><span style='float:right'>" . number_format($total, 0, '.', ' ') . "</th>
    </span>
    </tr>";

    $htmlDetail .= "</tbody></table>
    </div>";


    return $htmlDetail;
  }
function getDetailMarchandise($id_control = 0)
  {
    $dataDetail = 'SELECT au.ID_AUTRES_CONTROLES,q.ID_CONTROLES_QUESTIONNAIRES,q.INFRACTIONS,q.MONTANT,au.DESCRP_REPONSE,au.IMAGE_1,au.IMAGE_2,au.IMAGE_3, acqr.REPONSE_DECRP,q.NEED_IDENTITE FROM historiques h JOIN autres_controles au on au.ID_CONTROLE_PLAQUE =h.ID_CONTROLE_MARCHANDISE JOIN autres_controles_questionnaires q on q.ID_CONTROLES_QUESTIONNAIRES=au.ID_CONTROLES_QUESTIONNAIRES LEFT JOIN autres_contr_quest_rp acqr on acqr.ID_REPONSE=au.ID_REPONSE WHERE h.ID_CONTROLE_MARCHANDISE= ' . $id_control;





    $htmlDetail="";
    $image="";
    $total = 0;
    $htmlDetail .= "<div class='table-responsive'><b></b>
    <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
    <thead>
    <tr>
    <th>Application</th>
    <th>Montant(FBU)</th>
    <th>Img</th>
    <th>Identite</th>";
    $htmlDetail .="</thead>

    <tbody>";
        


    foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

      if(!empty($value['IMAGE_1'])){
        $image.=$value['IMAGE_1']."#";
      }
      if(!empty($value['IMAGE_2'])){
        $image.=$value['IMAGE_2']."#";
      }
      if(!empty($value['IMAGE_3'])){
        $image.=$value['IMAGE_3'];
      }



      if(!empty($image)){
        $imagedata ="<a href='#' title='". $image."' onclick='showviewImage(this.title)'><i class='fa fa-eye'></i></a>";
      }else{
        $imagedata="";
      }


       if($value['NEED_IDENTITE']==1){
        $optidentite = "<a class='btn  btn-sm btn-outline-secondary' onclick='getIdentite(".$value['ID_CONTROLES_QUESTIONNAIRES'].")'  href='#'>🧐concernés(".$this->getNombreConcerne($value['ID_CONTROLES_QUESTIONNAIRES']).")</a>";
       }else{
        $optidentite ="";
       }
    



      $total += $value['MONTANT'];
      $reponse=!empty($value['REPONSE_DECRP']) ? "(".$value['REPONSE_DECRP'].")" : "";
      $description=!empty($value['DESCRP_REPONSE']) ? "(".$value['DESCRP_REPONSE'].")" : "";

      $htmlDetail .= "<tr>
      <td>" . $value['INFRACTIONS']. $reponse. $description."</td>
      <td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . "</span></td>
      <td>".$imagedata."</td>

      <td>".$optidentite."</td>

      </tr>";
      //$descri=; 

    }
    $htmlDetail .= "<tr>
    <th >Total</th>
    <th colspan='3'><span style='float:right'>" . number_format($total, 0, '.', ' ') . "</th>
    </span>
    </tr>";

    $htmlDetail .= "</tbody></table>
    </div>";



    
    return $htmlDetail;
  }
function getDetais($id_control = 0)
  {

    $dataDetail = 'SELECT au.ID_AUTRES_CONTROLES,q.NEED_IDENTITE,q.ID_CONTROLES_QUESTIONNAIRES, q.INFRACTIONS,q.MONTANT,au.DESCRP_REPONSE,au.IMAGE_1,au.IMAGE_2,au.IMAGE_3, acqr.REPONSE_DECRP FROM historiques h JOIN autres_controles au on au.ID_CONTROLE_PLAQUE =h.ID_CONTROLE JOIN autres_controles_questionnaires q on q.ID_CONTROLES_QUESTIONNAIRES=au.ID_CONTROLES_QUESTIONNAIRES LEFT JOIN autres_contr_quest_rp acqr on acqr.ID_REPONSE=au.ID_REPONSE  WHERE h.ID_CONTROLE='.$id_control.' ' ;


    $htmlDetail="";
    $image="";
    $total = 0;
    $htmlDetail .= "<div class='table-responsive'><b></b>
    <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
    <thead>
    <tr>
    <th>Application</th>
    <th>Montant(FBU)</th>
    <th>Img</th>
    <th>Identité</th>";
    $htmlDetail .="</thead>

    <tbody>";
        


    foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

      if(!empty($value['IMAGE_1'])){
        $image.=$value['IMAGE_1']."#";
      }
      if(!empty($value['IMAGE_2'])){
        $image.=$value['IMAGE_2']."#";
      }
      if(!empty($value['IMAGE_3'])){
        $image.=$value['IMAGE_3'];
      }



      if(!empty($image)){
        $imagedata ="<a href='#' title='". $image."' onclick='showviewImage(this.title)'><i class='fa fa-eye'></i></a>";
      }else{
        $imagedata="";
      }


       if($value['NEED_IDENTITE']==1){
        $optidentite = "<a class='btn  btn-sm btn-outline-secondary' onclick='getIdentite(".$value['ID_CONTROLES_QUESTIONNAIRES'].")'  href='#'>🧐concernés(".$this->getNombreConcerne($value['ID_CONTROLES_QUESTIONNAIRES']).")</a>";
       }else{
        $optidentite ="";
       }
    



      $total += $value['MONTANT'];
      $reponse=!empty($value['REPONSE_DECRP']) ? "(".$value['REPONSE_DECRP'].")" : "";
      $description=!empty($value['DESCRP_REPONSE']) ? "(".$value['DESCRP_REPONSE'].")" : "";

      $htmlDetail .= "<tr>
      <td>" . $value['INFRACTIONS']. $reponse. $description."</td>
      <td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . "</span></td>
      <td>".$imagedata."</td>

      <td>".$optidentite."</td>

      </tr>";
      //$descri=; 

    }
    $htmlDetail .= "<tr>
    <th >Total</th>
    <th colspan='3'><span style='float:right'>" . number_format($total, 0, '.', ' ') . "</th>
    </span>
    </tr>";

    $htmlDetail .= "</tbody></table>
    </div>";


    return $htmlDetail;



    return $htmlDetail;
  }

  function getDetailEQUI($id_control = 0)
  {

    $dataDetail = 'SELECT au.ID_AUTRES_CONTROLES,q.INFRACTIONS,q.MONTANT,au.DESCRP_REPONSE,au.IMAGE_1,au.IMAGE_2,au.IMAGE_3, acqr.REPONSE_DECRP, acri.NOM, acri.PRENOM, acri.NATIONNALITE_ID, acri.SEXE, acri.CNI, acri.TELEPHONE, acri.DATE_NAISSANCE,q.NEED_IDENTITE FROM historiques h JOIN autres_controles au on au.ID_CONTROLE_PLAQUE =h.ID_CONTROLE_EQUIPEMENT JOIN autres_controles_questionnaires q on q.ID_CONTROLES_QUESTIONNAIRES=au.ID_CONTROLES_QUESTIONNAIRES LEFT JOIN autres_contr_quest_rp acqr on acqr.ID_REPONSE=au.ID_REPONSE LEFT JOIN autres_contr_rep_identite acri on acri.ID_AUTRES_CONTROLES=au.ID_AUTRES_CONTROLES WHERE h.ID_CONTROLE_EQUIPEMENT= '. $id_control;


    $htmlDetail="";
    $image="";
    $total = 0;
    $htmlDetail .= "<div class='table-responsive'><b></b>
    <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
    <thead>
    <tr>
    <th>Application</th>
    <th>Montant(FBU)</th> <th>Img</th>";
    $htmlDetail .="</thead>

    <tbody>";

    foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

      if(!empty($value['IMAGE_1'])){
        $image.=$value['IMAGE_1']."#";
      }
      if(!empty($value['IMAGE_2'])){
        $image.=$value['IMAGE_2']."#";
      }
      if(!empty($value['IMAGE_3'])){
        $image.=$value['IMAGE_3'];
      }



      if(!empty($image)){
        $imagedata ="<a href='#' title='". $image."' onclick='showviewImage(this.title)'><i class='fa fa-eye'></i></a>
        </tr>";
      }else{
        $imagedata="";
      }

      if($value['NEED_IDENTITE']==1){
        $optidentite = "<a class='btn  btn-sm btn-outline-secondary' onclick='getIdentite(".$value['ID_AUTRES_CONTROLES'].")'  href='#'>🧐voir plus...</a>";
       }else{
        $optidentite ="";
       }



      $total += $value['MONTANT'];
      $reponse=!empty($value['REPONSE_DECRP']) ? "(".$value['REPONSE_DECRP'].")" : "";
      $description=!empty($value['DESCRP_REPONSE']) ? "(".$value['DESCRP_REPONSE'].")" : "";

      $htmlDetail .= "<tr>
      <td>" . $value['INFRACTIONS']. $reponse. $description."</td>
      <td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . "</span></td>
      <td>".$imagedata.$optidentite."</td>
      </tr>";
      //$descri=; 

    }
    $htmlDetail .= "<tr>
    <th >Total</th>
    <th colspan='2'><span style='float:right'>" . number_format($total, 0, '.', ' ') . "</th>
    </span>
    </tr>";

    $htmlDetail .= "</tbody></table>
    </div>";

    return $htmlDetail;
  }


}
?>