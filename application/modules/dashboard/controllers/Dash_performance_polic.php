<?php

//

class Dash_performance_police extends CI_Controller
{
  function index()
  {

    $annees = $this->Model->getRequete('SELECT DISTINCT date_format(h.DATE_INSERTION,"%Y") AS ANNEE FROM historiques h WHERE 1  ORDER BY ANNEE');

    $ANNEE = $this->input->post('ANNEE');
    $MOIS = $this->input->post('MOIS');
    $DAYS = $this->input->post('DAYS');
    $criteres = "";
    $critere_date = "";
    $date = '';
    $mois = '';
    $jour = '';
    $heures = '';

    if (empty($ANNEE)) {
      $mois = date('Y-m-d');

      $critere_date .= " AND  date_format(h.`DATE_INSERTION`,'%Y') = '" . $mois . "' ";
    } else {
      $critere_date .= " AND  date_format(h.`DATE_INSERTION`,'%Y') = '" . $ANNEE . "' ";
    }


    if (!empty($ANNEE)) {
      $mois = $this->Model->getRequete("SELECT DISTINCT  date_format(h.`DATE_INSERTION`,'%m') AS MOIS FROM historiques h WHERE date_format(h.`DATE_INSERTION`,'%Y')=" . $ANNEE);

      $criteres .= " AND date_format(h.DATE_INSERTION,'%Y')=" . $ANNEE;
      // $criteres="AND date_format(DATE_COMMANDE,'%Y-%m-%d')='".$DATE1."'";

      if (!empty($MOIS)) {
        $jour = $this->Model->getRequete('SELECT DISTINCT  date_format(h.`DATE_INSERTION`,"%d") AS DAYS FROM historiques h WHERE date_format(h.`DATE_INSERTION`,"%Y")="' . $ANNEE . '" AND date_format(h.`DATE_INSERTION`,"%m")="' . $MOIS . '" ORDER BY DAYS DESC');

        $criteres .= " AND date_format(h.DATE_INSERTION,'%m')='" . $MOIS . "'";
      }
    }

    $rapport = $this->Modele->getRequete("SELECT SUM(`MONTANT`) AS AMANDE, DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y') AS JOURS FROM historiques h JOIN utilisateurs u ON u.ID_UTILISATEUR=h.ID_UTILISATEUR  WHERE 1 " . $criteres . " GROUP by DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y')");


    $requete2 = $this->Modele->getRequete("SELECT SUM(`MONTANT`) AS AMANDE,concat(psr.NOM,' ',psr.PRENOM)  as name FROM historiques h JOIN utilisateurs u ON u.ID_UTILISATEUR=h.ID_UTILISATEUR LEFT JOIN psr_elements psr ON psr.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID  WHERE 1 AND u.PROFIL_ID=6 GROUP BY name");


    $nombre = 0;

    $donne = "";
    $catego = "";
    $datas = 0;


    $nombre1 = 0;
    $donne1 = "";

    $categos = "";
    $data1 = 0;





    // $i=0;
    // foreach ($requete2 as  $value) {

    //   $nombre1+=$value['AMANDE'];

    //   $name=(!empty($value['chausse']))? $value['chausse']:'AUCUN ELEMENT';
    //   $nbre=(!empty($value['name']))? $value['name']:'0';

    //    $i ++;
    //   $key_id=($i >0) ? $i : "0" ;
    //   $donnees1.="{name:'".str_replace("'","\'",$name)."', y:".$nbre.",key:".$key_id."},";
    // }


    if (empty($DAYS)) {

      if (!empty($rapport)) {

        foreach ($rapport as  $value) {
          $mm = !empty($value['AMANDE']) ? $value['AMANDE'] : 0;
          $date  =  !empty($value['JOURS']) ? $value['JOURS'] : date('d-m-Y');
          $catego .= "'" . $date . "',";
          $datas .=  $mm . ",";
          $nombre += $value['AMANDE'];
        }
      } else {

        $mm = 0;
        $date  =   date('d-m-Y');
        $catego .= "'" . $date . "',";
        $datas .=  $mm . ",";
        $nombre += $mm;
      }
    } else {


      for ($heures = 0; $heures < 24; $heures++) {

        $hors =  (strlen($heures) == 1) ? '0' . $heures : $heures;
        $condu = $DAYS . '-' . $MOIS . '-' . $ANNEE . ' ' . $hors;

        $id = !empty($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $requete =  $this->Modele->getRequeteOne("SELECT SUM(`MONTANT`) AS AMANDE,DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y %H') FROM historiques h JOIN utilisateurs u ON u.ID_UTILISATEUR=h.ID_UTILISATEUR  WHERE 1 AND DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y %H')='" . $condu . "' GROUP BY DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y %H')");

        $mm = !empty($requete['AMANDE']) ? $requete['AMANDE'] : 0;

        $catego .= "'" . $hors . "h',";
        $datas .=  $mm . ",";
        $nombre += $mm;
      }
    }


    $catego .= "@";
    $catego = str_replace(",@", "", $catego);

    $datas .= "@";
    $datas = str_replace(",@", "", $datas);

    $donne .= "{
  name: 'Amande',
  data: [" . $datas . "]
},";


    if (!empty($requete2)) {

      foreach ($requete2 as  $value) {
        $mm = !empty($value['AMANDE']) ? $value['AMANDE'] : 0;
        $name  =  !empty($value['name']) ? $value['name'] : "police";
        $categos .= "'" . $name . "',";
        $data1 .=  $mm . ",";
        $nombre1 += $value['AMANDE'];
        // $donnees1.="{name:'".str_replace("'","\'",$name)."', y:".$nbre.",key:".$key_id."},";
      }
    } else {

      $mm = 0;
      $date  = 'police';
      $categos .= "'" . $date . "',";
      $data1 .=  $mm . ",";
      $nombre1 += $mm;
    }

    $categos .= "@";
    $categos = str_replace(",@", "", $categos);

    $data1 .= "@";
    $data1 = str_replace(",@", "", $data1);




    // $donne1 .= "{
    //   name: 'Amande',
    //   data: [" . $data1 . "]
    // },";



    $data['title'] = 'Performance de la police ';
    $data['catego'] = $catego;
    $data['donne'] = $donne;
    $data['total'] = $nombre;
    $data['trove'] = $DAYS;

    $data['categos'] = $categos;
    $data['donne1'] = $data1;
    $data['total1'] = $nombre1;
    // print_r($data['donne1']);exit();

    $data['ANNEE'] = $ANNEE;
    $data['MOIS'] = $MOIS;
    $data['DAYS'] = $DAYS;

    $data['annees'] = $annees;
    $data['mois'] = $mois;
    $data['jour'] = $jour;
    $this->load->view('dash_performance_police_v', $data);
  }
}
