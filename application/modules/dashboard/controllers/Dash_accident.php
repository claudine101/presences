<?php

//CLAUDE NIYO 

class Dash_accident extends CI_Controller
{
    function index()
    {

        $annees = $this->Model->getRequete('SELECT DISTINCT date_format(sign_accident.DATE_INSERTION,"%Y") AS ANNEE FROM sign_accident WHERE 1  ORDER BY ANNEE');

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

            $critere_date .= " AND  date_format(`sign_accident`.`DATE_INSERTION`,'%Y') = '" . $mois . "' ";
        } else {
            $critere_date .= " AND  date_format(`sign_accident`.`DATE_INSERTION`,'%Y') = '" . $ANNEE . "' ";
        }


        if (!empty($ANNEE)) {
            $mois = $this->Model->getRequete("SELECT DISTINCT  date_format(`sign_accident`.`DATE_INSERTION`,'%m') AS MOIS FROM sign_accident WHERE date_format(`sign_accident`.`DATE_INSERTION`,'%Y')=" . $ANNEE);

            $criteres .= " AND date_format(DATE_INSERTION,'%Y')=" . $ANNEE;
            // $criteres="AND date_format(DATE_COMMANDE,'%Y-%m-%d')='".$DATE1."'";

            if (!empty($MOIS)) {
                $jour = $this->Model->getRequete('SELECT DISTINCT  date_format(`sign_accident`.`DATE_INSERTION`,"%d") AS DAYS FROM sign_accident WHERE date_format(`sign_accident`.`DATE_INSERTION`,"%Y")="' . $ANNEE . '" AND date_format(`sign_accident`.`DATE_INSERTION`,"%m")="' . $MOIS . '" ORDER BY DAYS DESC');

                $criteres .= " AND date_format(DATE_INSERTION,'%Y-%m')='" . $ANNEE . "-" . $MOIS . "'";
            }
        }


        $requete = $this->Modele->getRequete("SELECT  COUNT(ID_SIGN_ACCIDENT) as Nbre,  DATE_FORMAT(DATE_INSERTION, '%d-%m-%Y') as date FROM sign_accident WHERE 1 " . $criteres . " GROUP BY DATE_INSERTION");


        $requete2 = $this->Modele->getRequete("SELECT COUNT(ID_SIGN_ACCIDENT) as NBRE, ch.NOM_CHAUSSE as chausse FROM sign_accident sign LEFT JOIN chaussee ch ON ch.ID_CHAUSSEE=sign.ID_CHAUSSEE WHERE 1 " . $criteres . " GROUP BY chausse");


        $nombre = 0;
        $nombre1 = 0;

        $donnees = "";
        $donnees1 = "";
        $categorie = "";


        //$categorie1='';
        $i = 0;
        foreach ($requete as  $value) {

            $nombre += $value['Nbre'];

            $name = (!empty($value['date'])) ? $value['date'] : 'AUCUN ELEMENT';
            $nbre = (!empty($value['Nbre'])) ? $value['Nbre'] : '0';
            $i++;
            $key_id = ($i > 0) ? $i : "0";
            $donnees .= "{name:'" . str_replace("'", "\'", $name) . "', y:" . $nbre . ",key:" . $key_id . "},";
        }




        foreach ($requete2 as  $value) {
            // $categorie.="'".$value['chausse']."',";
            $nombre1 += $value['NBRE'];

            $name = (!empty($value['chausse'])) ? $value['chausse'] : 'AUCUN ELEMENT';
            $nbre = (!empty($value['NBRE'])) ? $value['NBRE'] : '0';

            $i++;
            $key_id = ($i > 0) ? $i : "0";
            $donnees1 .= "{name:'" . str_replace("'", "\'", $name) . "', y:" . $nbre . ",key:" . $key_id . "},";
        }



        if (!empty($DAYS)) {

            $donnees = "";
            $nombre = "";

            for ($heures = 0; $heures < 24; $heures++) {

                $hors =  (strlen($heures) == 1) ? '0' . $heures : $heures;
                $condu = $DAYS . '-' . $MOIS . '-' . $ANNEE . ' ' . $hors;

                $id = !empty($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

                $requet =  $this->Modele->getRequeteOne("SELECT COUNT(ID_SIGN_ACCIDENT) as Nbre,DATE_FORMAT(DATE_INSERTION, '%d-%m-%Y %H') as heure FROM sign_accident sign LEFT JOIN chaussee ch ON ch.ID_CHAUSSEE=sign.ID_CHAUSSEE WHERE 1  and DATE_FORMAT(DATE_INSERTION, '%d-%m-%Y %H')='" . $condu . "' GROUP BY heure");


                $name = $hors . 'h';
                $nbre = (!empty($requet['Nbre'])) ? $requet['Nbre'] : '0';
                $i++;
                $key_id = ($i > 0) ? $i : "0";
                $donnees .= "{name:'" . str_replace("'", "\'", $name) . "', y:" . $nbre . ",key:" . $key_id . "},";
            }
        }


        //print_r($donnees1);exit();


        $data['title'] = 'Rapports des accidents';
        $data['donnees'] = $donnees;
        $data['nombre'] = $nombre;
        $data['nombre1'] = $nombre1;
        $data['donnees1'] = $donnees1;
        $data['categorie'] = $categorie;

        $data['ANNEE'] = $ANNEE;
        $data['MOIS'] = $MOIS;
        $data['DAYS'] = $DAYS;

        $data['annees'] = $annees;
        $data['mois'] = $mois;
        $data['jour'] = $jour;
        $this->load->view('dash_accident_v', $data);
    }
    function detailControle()
    {

        $KEY = $this->input->post('key');
        $break = explode(".", $KEY);
        $ID = $KEY;


        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

        $query_principal = "SELECT ID_CONTROLE,NUMERO_CONTROLE,NUMERO_PLAQUE,NUMERO_CHASSIS,PROPRIETAIRE,DATE_DEBUT,DATE_VALIDITE,TYPE_VEHICULE FROM otraco_controles WHERE 1";

        $limit = 'LIMIT 0,10';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by = '';
        if ($_POST['order']['0']['column'] != 0) {
            $order_by = isset($_POST['order']) ? ' ORDER BY ' . $_POST['order']['0']['column'] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE   DESC';
        }

        $search = !empty($_POST['search']['value']) ? (" AND (otraco_controles.NUMERO_PLAQUE LIKE '%$var_search%' OR  otraco_controles.TYPE_VEHICULE LIKE '%$var_search%' OR  otraco_controles.PROPRIETAIRE LIKE '%$var_search%' OR `otraco_controles`.`PROPRIETAIRE` LIKE '%$var_search%' ) ") : '';

        $critaire = ($ID == 'invalide') ? 'AND `DATE_VALIDITE` < CURRENT_DATE()' : 'AND `DATE_VALIDITE` >= CURRENT_DATE()';



        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;



        $fetch_data = $this->Modele->datatable($query_secondaire);
        $u = 1;
        $data = array();
        foreach ($fetch_data as $row) {



            $intrant = array();
            $intrant[] = $u++;
            $intrant[] = $row->NUMERO_PLAQUE;
            $intrant[] = $row->DATE_VALIDITE;
            $intrant[] = $row->TYPE_VEHICULE;
            $intrant[] = $row->PROPRIETAIRE;


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

    function detailAssurance()
    {


        $KEY = $this->input->post('key');
        $break = explode(".", $KEY);
        $ID = $KEY;

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

        $query_principal = "SELECT `ID_ASSURANCE`,`NUMERO_PLAQUE`,assurances_vehicules.ID_ASSUREUR,assureur.ASSURANCE,`DATE_VALIDITE`,`PLACES_ASSURES`,`TYPE_ASSURANCE`,`TYPE_ASSURANCE`,`NOM_PROPRIETAIRE` FROM `assurances_vehicules` LEFT JOIN assureur ON assureur.ID_ASSUREUR=assurances_vehicules.ID_ASSUREUR WHERE 1 ";

        $limit = 'LIMIT 0,10';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by = '';
        if ($_POST['order']['0']['column'] != 0) {
            $order_by = isset($_POST['order']) ? ' ORDER BY ' . $_POST['order']['0']['column'] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE   DESC';
        }

        $search = !empty($_POST['search']['value']) ? (" AND (assurances_vehicules.NUMERO_PLAQUE LIKE '%$var_search%' OR  ASSURANCE LIKE '%$var_search%' OR   `assurances_vehicules`.`NOM_PROPRIETAIRE` LIKE '%$var_search%' ) ") : '';

        $critaire = ($ID == 'invalide') ? 'AND `DATE_VALIDITE` < CURRENT_DATE()' : 'AND `DATE_VALIDITE` >= CURRENT_DATE()';



        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;



        $fetch_data = $this->Modele->datatable($query_secondaire);
        $u = 1;
        $data = array();
        foreach ($fetch_data as $row) {



            $intrant = array();
            $intrant[] = $u++;
            $intrant[] = $row->NUMERO_PLAQUE;
            $intrant[] = $row->ASSURANCE;
            $intrant[] = $row->DATE_VALIDITE;
            $intrant[] = $row->PLACES_ASSURES;
            $intrant[] = $row->NOM_PROPRIETAIRE;


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
