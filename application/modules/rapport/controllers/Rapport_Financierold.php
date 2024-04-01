<?php

class Rapport_Financier extends CI_Controller
{

  function index()
  {

    $annees = $this->Model->getRequete('SELECT DISTINCT date_format(DATE_INSERT,"%Y") AS ANNEE FROM historique_signalement WHERE 1  ORDER BY ANNEE');

    $ANNEE = $this->input->post('ANNEE');
    $MOIS = $this->input->post('MOIS');
    $DAYS = $this->input->post('DAYS');
    $criteres = "";
    $critere_date = "";
    $date = '';
    $mois = '';
    $jour = '';

    if (empty($ANNEE)) {
      $mois = date('Y-m-d');

      $critere_date .= " AND  date_format(`historique_signalement`.`DATE_INSERT`,'%Y') = '" . $mois . "' ";
    } else {
      $critere_date .= " AND  date_format(`historique_signalement`.`DATE_INSERT`,'%Y') = '" . $ANNEE . "' ";
    }

    if (!empty($ANNEE)) {
      $mois = $this->Model->getRequete("SELECT DISTINCT  date_format(`historique_signalement`.`DATE_INSERT`,'%m') AS MOIS FROM historique_signalement WHERE date_format(`historique_signalement`.`DATE_INSERT`,'%Y')=" . $ANNEE);

      $criteres .= " AND date_format(DATE_INSERT,'%Y')=" . $ANNEE;
      // $criteres="AND date_format(DATE_COMMANDE,'%Y-%m-%d')='".$DATE1."'";

      if (!empty($MOIS)) {
        $jour = $this->Model->getRequete('SELECT DISTINCT  date_format(`historique_signalement`.`DATE_INSERT`,"%d") AS DAYS FROM historique_signalement WHERE date_format(`historique_signalement`.`DATE_INSERT`,"%Y")="' . $ANNEE . '" AND date_format(`historique_signalement`.`DATE_INSERT`,"%m")="' . $MOIS . '" ORDER BY DAYS DESC');

        $criteres .= " AND date_format(DATE_INSERT,'%m')='" . $MOIS . "'";
      }
    }


    //Amendes/jour
    $Amendes_s = $this->Modele->getRequete("SELECT SUM(`AMENDE`)as AMENDE, DATE_FORMAT(`DATE_INSERT`,'%d-%m-%Y') as DATE_s FROM `historique_signalement` where 1 " . $criteres . " GROUP BY DATE_FORMAT(`DATE_INSERT`,'%d-%m-%Y') ");

    //Amendes/signalement
    $Amendes_h = $this->Modele->getRequete("SELECT SUM(`MONTANT`) as MONTANT, DATE_FORMAT(`DATE_INSERTION`,'%d-%m-%Y') as DATE_h FROM `historiques`GROUP BY DATE_FORMAT(`DATE_INSERTION`, '%d-%m-%Y') ");


    $nombre = 0;
    $nombre2 = 0;


    $catego = "";
    $catego2 = "";

    $datas = '';
    $datas2 = 0;



    if (empty($DAYS)) {

      if (!empty($Amendes_s)) {

        foreach ($Amendes_s as  $value) {
          $mm = !empty($value['AMENDE']) ? $value['AMENDE'] : 0;
          $date  =  !empty($value['DATE_s']) ? $value['DATE_s'] : date('d-m-Y');
          $catego .= "'" . $date . "',";
          $datas .=  $mm . ",";
          $nombre += $value['AMENDE'];
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

        $requete =  $this->Modele->getRequeteOne("SELECT SUM(`AMENDE`)as AMENDE, DATE_FORMAT(`DATE_INSERT`,'%d-%m-%Y %H') as heure FROM `historique_signalement` WHERE 1  and DATE_FORMAT(DATE_INSERT, '%d-%m-%Y %H')='" . $condu . "' GROUP BY heure");

        $mm = !empty($requete['AMENDE']) ? $requete['AMENDE'] : 0;

        $catego .= "'" . $hors . "h',";
        $datas .=  $mm . ",";
        $nombre += $mm;
      }
    }


    $catego .= "@";
    //  print_r($datas);die();
    $catego = str_replace(",@", "", $catego);

    $datas .= "@";
    $datas = str_replace(",@", "", $datas);


    if (!empty($Amendes_h)) {

      foreach ($Amendes_h as  $value) {
        $mm = !empty($value['MONTANT']) ? $value['MONTANT'] : 0;
        $date  =  !empty($value['DATE_h']) ? $value['DATE_h'] : date('d-m-Y');
        $catego2 .= "'" . $date . "',";
        $datas2 .=  $mm . ",";
        $nombre2 += $value['MONTANT'];
      }
    } else {

      $mm = 0;
      $date  =   date('d-m-Y');
      $catego2 .= "'" . $date . "',";
      $datas2 .=  $mm . ",";
      $nombre2 += $mm;
    }


    $catego2 .= "@";
    $catego2 = str_replace(",@", "", $catego2);

    $datas2 .= "@";
    $datas2 = str_replace(",@", "", $datas2);


    $data['catego'] = $catego;
    $data['catego2'] = $catego2;
    $data['datas2'] = $datas2;
    $data['datas'] = $datas;



    //$data['donne'] = $donne;
    $data['total'] = $nombre;
    $data['total2'] = $nombre2;


    $data['ANNEE'] = $ANNEE;
    $data['MOIS'] = $MOIS;
    $data['DAYS'] = $DAYS;

    $data['annees'] = $annees;
    $data['mois'] = $mois;
    $data['jour'] = $jour;





    $data['title'] = "Rapport Financier";


    $this->load->view("Rapport_Financier_V", $data);
  }
}
