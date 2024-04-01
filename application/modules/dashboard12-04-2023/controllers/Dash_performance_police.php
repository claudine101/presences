<?php

//CLAUDE NIYO 
//Corrigee par Edmond le 04/04/2023

class Dash_performance_police extends CI_Controller
{
  function index()
  {

    $annees = $this->Model->getRequete('SELECT DISTINCT date_format(h.DATE_INSERTION,"%Y") AS ANNEE FROM historiques h WHERE 1  ORDER BY ANNEE DESC');
    $cat = $this->Model->getRequete('SELECT `ID_CATEGORIE`,`DESCRIPTION` FROM `historiques_categories` WHERE 1 ORDER BY DESCRIPTION ASC');
 


    $ANNEE = $this->input->post('ANNEE');  
    $MOIS = $this->input->post('MOIS');
    $DAYS = $this->input->post('DAYS');
    $STATUT = $this->input->post('STATUT');
    $IS_ANNULE = $this->input->post('IS_ANNULE');
    $ID_CATEGORIE = $this->input->post('ID_CATEGORIE');
    $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');

    $criteres = "";
    $critere_date = "";
    $date = '';
    $mois = '';
    $jour = '';
    $heures = '';
    $ego2='';
    $ego1='';
    $ego='';

    

      


 if (!empty($ANNEE)) {


    $mois = $this->Model->getRequete("SELECT DISTINCT  date_format(h.`DATE_INSERTION`,'%m') AS MOIS FROM historiques h WHERE date_format(h.`DATE_INSERTION`,'%Y')=" .$ANNEE."   ORDER BY MOIS DESC");
     $criteres = " AND  date_format(h.`DATE_INSERTION`,'%Y') = '" . $ANNEE . "'  ";
  
  $ego2=$ANNEE.'-01-01';

$ego1=$ANNEE.'-12-31';


      }
    if ( !empty($MOIS)) {
    
 
    $criteres = " AND  date_format(h.`DATE_INSERTION`,'%Y') = ".$ANNEE ." AND  date_format(h.`DATE_INSERTION`,'%m') = " . $MOIS. "";
   


   if(in_array($MOIS,['01','03','05','07','08','10','12']))
{
    $ego=31;
}elseif(in_array($MOIS, ['04','06','09','11'])){
    $ego=30;
}elseif(in_array($MOIS, ['02'])){
    $ego=28;
}
$ego2=$ANNEE.'-'.$MOIS.'-01';
$ego1=$ANNEE.'-'.$MOIS.'-'.$ego;
        
     }

if(!empty($DATE_UNE) && empty($DATE_DEUX)){
 $criteres= "  AND date_format(h.DATE_INSERTION,'%d-%m-%Y')='" .strftime('%d-%m-%Y',strtotime($DATE_UNE))."'";

       }

  if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
  $criteres= "  AND date_format(h.DATE_INSERTION,'%d-%m-%Y') between '" .strftime('%d-%m-%Y',strtotime($DATE_UNE))."'  AND  '" .strftime('%d-%m-%Y',strtotime($DATE_DEUX))."'";

                      
                    }
   
   
    if ($STATUT) {
      $criteres .= " AND IS_PAID =".$STATUT;
    }
     if ($IS_ANNULE) {
      $criteres .= " AND IS_ANNULE =".$IS_ANNULE;
    }
    if ($ID_CATEGORIE) {
      $criteres .= " AND ID_HISTORIQUE_CATEGORIE =".$ID_CATEGORIE;
    }



 


    $rapport = $this->Modele->getRequete("SELECT h.ID_UTILISATEUR,COUNT(ID_HISTORIQUE) as Nbre,concat(psr.NOM,' ',psr.PRENOM)  as name FROM historiques h JOIN utilisateurs u ON u.ID_UTILISATEUR=h.ID_UTILISATEUR LEFT JOIN psr_elements psr ON psr.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID  WHERE 1 AND u.PROFIL_ID=6 " . $criteres . " GROUP BY name,h.ID_UTILISATEUR");
    


    $requete2 = $this->Modele->getRequete("SELECT h.ID_UTILISATEUR,SUM(`MONTANT`) AS AMANDE,concat(psr.NOM,' ',psr.PRENOM)  as name FROM historiques h JOIN utilisateurs u ON u.ID_UTILISATEUR=h.ID_UTILISATEUR LEFT JOIN psr_elements psr ON psr.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID  WHERE 1 AND u.PROFIL_ID=6 " . $criteres . " GROUP BY name,h.ID_UTILISATEUR");


    $nombre = 0;

    $donne = "";
    $catego = "";
    $datas = '';


    $nombre1 = 0;
    $donne1 = "";

    $categos = "";
    $data1 = '';
    $i = 0;


    if (!empty($rapport)) {

      foreach ($rapport as  $value) {
        $mm = !empty($value['Nbre']) ? $value['Nbre'] : 0;
        $name  =  !empty($value['name']) ? $value['name'] : 'police';
        $ID_UT  =  !empty($value['ID_UTILISATEUR']) ? $value['ID_UTILISATEUR'] : 0;
        $catego .= "'" .$this->str_replacecatego($name). "',";
        $datas .="{y:".$mm.",key:".$ID_UT."},";
        $nombre += $value['Nbre'];
      }


    } else {

      $mm = 0;
      $name  =   'police';
      $ID_UT  =  !empty($value['ID_UTILISATEUR']) ? $value['ID_UTILISATEUR'] : 0;
      $catego .= "'" .$this->str_replacecatego($name). "',";
      $datas .="{y:".$mm.",key:".$ID_UT."},";
      $nombre += $mm;
    }


    $catego .= "@";
    $catego = str_replace(",@", "", $catego);

    $datas .= "@";
    $datas = str_replace(",@", "", $datas);

    $donne .= "{
  name: 'Nombre de contole',
  data: [" . $datas . "]
},";



       if (!empty($requete2)) {

       foreach ($requete2 as  $value) {
        $mm = !empty($value['AMANDE']) ? $value['AMANDE'] : 0;
        $name  =  !empty($value['name']) ? $value['name'] : 'police';
        $ID_UT  =  !empty($value['ID_UTILISATEUR']) ? $value['ID_UTILISATEUR'] : 0;
        $categos .= "'" .$this->str_replacecatego($name)."',";
        $data1 .="{y:".$mm.",key:".$ID_UT."},";


        //echo $value['AMANDE'].'<br>';

        $nombre1 += $value['AMANDE'];
      }
    } else {

      $mm = 0;
      $name  = 'police';
      $categos .= "'" .$this->str_replacecatego($name). "',";
      $ID_UT  =  !empty($value['ID_UTILISATEUR']) ? $value['ID_UTILISATEUR'] : 0;
       $data1 .="{y:".$mm.",key:".$ID_UT."},";
      $nombre1 += $mm;
    }

    $categos .= "@";
    $categos = str_replace(",@", "", $categos);

    $data1 .= "@";
    $data1 = str_replace(",@", "", $data1);



    $data['title'] = 'Performance des fonctionnaires de la police ';
    $data['catego'] = $catego;
    $data['donne'] = $donne;
    $data['total'] = $nombre;


    $data['categos'] = $categos;
    $data['donne1'] = $data1;
    $data['total1'] = $nombre1;
    //print_r($data['$nombre1']);exit();

    $data['ANNEE'] = $ANNEE;
    $data['MOIS'] = $MOIS;
    

    $data['DATE_UNE'] = $DATE_UNE;  
    $data['DATE_DEUX'] = $DATE_DEUX;
    //$data['statut']=$status;

    $data['ego2'] = $ego2;
    $data['ego1'] = $ego1;

    

    $data['annees'] = $annees;
    $data['mois'] = $mois;
    $data['cat'] = $cat;
    $data['ID_CATEGORIE'] = $ID_CATEGORIE;

    
    $this->load->view('dash_performance_police_v', $data);
  }
//fOnction pour afficher la liste pour le detail
function detail()
    {
    
    $ANNEE = $this->input->post('ANNEE');  
    $MOIS = $this->input->post('MOIS');
    $DAYS = $this->input->post('DAYS');
    $STATUT = $this->input->post('STATUT');
    $IS_ANNULE = $this->input->post('IS_ANNULE');
    $ID_CATEGORIE = $this->input->post('ID_CATEGORIE');
    $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');
      
    $KEY=$this->input->post('key');
    $criteres =" ";


    if (!empty($ANNEE)) {

     $criteres = " AND  date_format(h.`DATE_INSERTION`,'%Y') = '" . $ANNEE . "'  ";
 
      }
    if ( !empty($MOIS)) {
   
    $criteres = " AND  date_format(h.`DATE_INSERTION`,'%Y') = ".$ANNEE ." AND  date_format(h.`DATE_INSERTION`,'%m') = " .$MOIS. "";
   
        
     }



if(!empty($DATE_UNE) && empty($DATE_DEUX)){
 $criteres = "   AND date_format(h.DATE_INSERTION,'%d-%m-%Y')='".strftime('%d-%m-%Y',strtotime($DATE_UNE))."'";

       }

  if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
  $criteres = "  AND date_format(h.DATE_INSERTION,'%d-%m-%Y') between  '".strftime('%d-%m-%Y',strtotime($DATE_UNE))."'  AND  '".strftime('%d-%m-%Y',strtotime($DATE_DEUX))."'";

                      
                    }

      
   
    if ($STATUT) {
      $criteres .= " AND IS_PAID =".$STATUT;
    }
     if ($IS_ANNULE) {
      $criteres .= " AND IS_ANNULE =".$IS_ANNULE;
    }
    if ($ID_CATEGORIE) {
      $criteres .= " AND ID_HISTORIQUE_CATEGORIE =".$ID_CATEGORIE;
    }


   $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $query_principal = 'SELECT h.ID_COMPORTEMENT, h.RAISON_ANNULATION, ID_CONTROLE_MARCHANDISE,ID_HISTORIQUE,h.ID_CONTROLE,h.ID_HISTORIQUE_CATEGORIE, hc.DESCRIPTION as historique_categorie,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_IMMATRICULATIO_PEINE) AS IMMATRICULATION,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_ASSURANCE_PEINE) AS ASSURANCE,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_CONTROLE_TECHNIQUE_PEINE) AS CONTROL_TECHNIQUE,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_VOL_PEINE) AS VOL,(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_PERMIS_PEINE) AS PERMIS_PEINE, h.NUMERO_PLAQUE ,ID_IMMATRICULATIO_PEINE,ID_ASSURANCE_PEINE,ID_CONTROLE_TECHNIQUE_PEINE,ID_VOL_PEINE,ID_PERMIS_PEINE, NUMERO_PERMIS, concat(pe.NOM," ",pe.PRENOM) as user,pe.NUMERO_MATRICULE,pe.ID_PSR_ELEMENT, h.LATITUDE, h.LONGITUDE,h.DATE_INSERTION,h.MONTANT,h.IS_PAID,ID_CONTROLE_EQUIPEMENT,ID_SIGNALEMENT FROM historiques h LEFT JOIN historiques_categories hc ON h.ID_HISTORIQUE_CATEGORIE=hc.ID_CATEGORIE LEFT JOIN utilisateurs us ON us.ID_UTILISATEUR=h.ID_UTILISATEUR  LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT = us.PSR_ELEMENT_ID WHERE 1  '.$criteres.' ';



    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $limit = 'LIMIT 0,10';


    if ($_POST['length'] != -1) {
      $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }

    $order_by = '';


    $order_column = array('user', 'DATE_INSERTION', 'historique_categorie', 'RAISON_ANNULATION', 'NUMERO_PLAQUE', 'NUMERO_PERMIS', 'MONTANT', 'IS_PAID', 'DATE_INSERTION');
    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_INSERTION DESC ';

    $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%' ") : '';

    $critaire = ' AND h.ID_UTILISATEUR='.$KEY;


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


    

      $stat = '';

      if ($row->IS_PAID == 1) {
        $val_stat = '<button class="btn btn-info" style="white-space: nowrap">Payé</button>';
      } else {
        $val_stat = '<button class="btn btn-outline-info" style="white-space: nowrap">Non payé</button>';
      }

      $stat .= "<a href='#' data-toggle='modal'
      data-target='#stat" . $row->ID_HISTORIQUE . "'><font color='blue'>&nbsp;&nbsp;" . $val_stat . "</font></a>";

     

    

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
  //fonction  pour reccuperer les matriculations
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

function str_replacecatego($name)
  {

$catego=str_replace("'"," ",$name);
$catego=str_replace("  "," ",$catego);
$catego=str_replace("\n"," ",$catego);
$catego=str_replace("\t"," ",$catego);
$catego=str_replace("@"," ",$catego);
$catego=str_replace("&"," ",$catego);
$catego=str_replace(">"," ",$catego);
$catego=str_replace("   "," ",$catego);
$catego=str_replace("?"," ",$catego);
$catego=str_replace("#"," ",$catego);
$catego=str_replace("%"," ",$catego);
$catego=str_replace("%!"," ",$catego);
$catego=str_replace(""," ",$catego);


return $catego;
}
}
