<?php

class Rapport_Financier extends CI_Controller
{

          function index()
          {

        
                    $annee_searc=$this->Modele->getRequete('SELECT DISTINCT date_format(DATE_INSERTION,"%Y") AS annee FROM historiques WHERE 1  ORDER BY annee DESC ');
                    $DATE_UNE = $this->input->post('DATE_UNE');
                    $DATE_DEUX = $this->input->post('DATE_DEUX');
                    $IS_PAID = $this->input->post('IS_PAID');

                    $ANNE = $this->input->post('ANNE');
                    $MOIS = $this->input->post('MOIS');
                    $mois_searc='';
                    $criteres_signal = "";
                    $criteres_histo = "";

                    $critere_date = "";
                    $date = '';
                    $mois = '';
                    $jour = '';

                    $coloneHisto = "DATE_FORMAT(`DATE_INSERTION`,'%Y')";
                    $coloneSignalement = "DATE_FORMAT(`DATE_INSERT`,'%Y')";
               

                    $nombre = 0;
                    $nombre2 = 0;


                    $catego = "";
                    $catego2 = "";

                    $datas = '';
                    $datas2 = "";

                    
                     if (!empty($ANNE)) {

                    $mois_searc=$this->Modele->getRequete('SELECT DISTINCT date_format(DATE_INSERTION,"%Y-%m") AS mois FROM historiques WHERE 1 AND  date_format(DATE_INSERTION,"%Y")="'.$ANNE.'" ORDER BY mois ASC ');

                       $criteres_signal = " and DATE_FORMAT(DATE_INSERT, '%Y')='" . $ANNE."'";
                       $criteres_histo = " and DATE_FORMAT(DATE_INSERTION, '%Y')='" . $ANNE."'";

                        $coloneHisto = "DATE_FORMAT(`DATE_INSERTION`,'%m-%Y')";
                        $coloneSignalement = "DATE_FORMAT(`DATE_INSERT`,'%m-%Y')";
                      
                    }


                    if (!empty($MOIS)) {
                    $criteres_signal = " and DATE_FORMAT(DATE_INSERT, '%Y-%m')='" . $MOIS."'";
                    $criteres_histo = " and DATE_FORMAT(DATE_INSERTION, '%Y-%m')='" . $MOIS."'";

                    $coloneHisto = "DATE_FORMAT(`DATE_INSERTION`,'%d-%m-%Y')";
                    $coloneSignalement = "DATE_FORMAT(`DATE_INSERT`,'%d-%m-%Y')";

                    }
$ego='';
if (!empty($ANNE) && !empty($ANNE)) {

if($MOIS==''.$ANNE.'-01' || $MOIS==''.$ANNE.'-03' || $MOIS==''.$ANNE.'-05' || $MOIS==''.$ANNE.'-07' || $MOIS==''.$ANNE.'-08' || $MOIS==''.$ANNE.'-10' || $MOIS==''.$ANNE.'-12'){
    $ego=31;
}elseif($MOIS==''.$ANNE.'-04' || $MOIS==''.$ANNE.'-06' || $MOIS==''.$ANNE.'-09' || $MOIS==''.$ANNE.'-011' ){
    $ego=30;
}elseif($MOIS==''.$ANNE.'-02'){
    $ego=28;
}
}


                    
    
        if(!empty($DATE_UNE) && empty($DATE_DEUX)){

        $criteres_signal = " and DATE_FORMAT(DATE_INSERT, '%Y-%m-%d')='" . $DATE_UNE."'";
        $criteres_histo = " and DATE_FORMAT(DATE_INSERTION, '%Y-%m-%d')='" . $DATE_UNE."'";

        $coloneHisto = "DATE_FORMAT(`DATE_INSERTION`,'%H')";
        $coloneSignalement = "DATE_FORMAT(`DATE_INSERT`,'%H')";

       }

     


          if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {

                       $criteres_signal = " and DATE_FORMAT(DATE_INSERT, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";
                       $criteres_histo = " and DATE_FORMAT(DATE_INSERTION, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";

                        $coloneHisto = "DATE_FORMAT(`DATE_INSERTION`,'%d-%m-%Y')";
                        $coloneSignalement = "DATE_FORMAT(`DATE_INSERT`,'%d-%m-%Y')";
                      
                    }


                    if (!empty($IS_PAID)) {

                       $criteres_signal .= " and STATUT_PAYE = ". $IS_PAID." ";
                       $criteres_histo .= " and IS_PAID = ". $IS_PAID." ";
                      
                    }


                 

                    $Amendes_h = $this->Modele->getRequete("SELECT SUM(`MONTANT`) as MONTANT, ".$coloneHisto." as DATE_h FROM `historiques`  where 1 " . $criteres_histo . "  GROUP BY DATE_h ");

                    $Amendes_s = $this->Modele->getRequete("SELECT SUM(`AMENDE`)as AMENDE, ".$coloneSignalement." as DATE_s FROM `historique_signalement` where 1 " . $criteres_signal . " GROUP BY DATE_s ");
                    

                    if (!empty($Amendes_s)) {
                 
                        foreach ($Amendes_s as  $value) {
                            $mm = !empty($value['AMENDE']) ? $value['AMENDE'] : 0;
                            $date  =  !empty($value['DATE_s']) ? $value['DATE_s'] : date('d-m-Y');
                            $catego .= "'" . $date . "',";
                            $datas .="{y:".$mm.",key:'".$date."'},";
                            $nombre += $mm;
                        }

                          
                    }else{

                            $mm = 0;
                            $date  =  date('d-m-Y');
                            $catego .= "'" . $date . "',";
                            $datas .="{y:".$mm.",key:'".$date."'},";
                            $nombre += $mm;

                    }



                    if (!empty($Amendes_h)) {

                        foreach ($Amendes_h as  $value) {
                            $mm = !empty($value['MONTANT']) ? $value['MONTANT'] : 0;
                            $date  =  !empty($value['DATE_h']) ? $value['DATE_h'] : date('d-m-Y');
                            $catego2 .= "'" . $date . "',";
                            $datas2 .="{y:".$mm.",key:'".$date."'},";
                            $nombre2 += $mm;
                       }
                       
                    }else{

                            $mm =  0;
                            $date  =  date('d-m-Y');
                            $catego2 .= "'" . $date . "',";
                            $datas2 .="{y:".$mm.",key:'".$date."'},";
                            $nombre2 += $mm;
                    }

                    $catego .= "@";
                    $catego = str_replace(",@", "", $catego);

                    $catego2 .= "@";
                    $catego2 = str_replace(",@", "", $catego2);


                    $datas .= "@";
                    $datas = str_replace(",@", "", $datas);

                    $datas2 .= "@";
                    $datas2 = str_replace(",@", "", $datas2);

                   


                    $data['catego'] = $catego;
                    $data['catego2'] = $catego2;
                    
                    $data['datas'] = $datas;
                    $data['datas2'] = $datas2;


                    $data['total'] = $nombre;
                    $data['total2'] = $nombre2;


                    $data['DATE_UNE'] = $DATE_UNE;  
                    $data['DATE_DEUX'] = $DATE_DEUX;
                    $data['IS_PAID'] = $IS_PAID;


                    $data['annee_searc'] = $annee_searc;
                    $data['mois_searc'] = $mois_searc;
                    $data['ANNE'] = $ANNE;  
                    $data['MOIS'] = $MOIS;

                
                    $data['title'] = "Rapport Financier";
                    $data['ego'] = $ego;

  
                    $this->load->view("Rapport_Financier_V", $data);
          }




          function gettexts($text = "0")
          {

                    if (!empty($text)) {
                              $test = (strlen($text) == 1) ? '0' . $text : $text;
                              return $test;
                    }
          }


          function detail()
    {
   $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');
    $IS_PAID = $this->input->post('IS_PAID');

    $ANNE = $this->input->post('ANNE');
    $MOIS = $this->input->post('MOIS'); 

   $KEY=$this->input->post('key');

   $criteres_histo ='';

if (!empty($ANNE)) {
$criteres_histo = " and DATE_FORMAT(DATE_INSERTION, '%Y')='" . $ANNE."'";
                      
}

if (!empty($MOIS)) {

$criteres_histo = " and DATE_FORMAT(DATE_INSERTION, '%Y-%m')='" . $MOIS."'";

                    }
if(!empty($DATE_UNE) && empty($DATE_DEUX)){

        $criteres_histo = " and DATE_FORMAT(DATE_INSERTION, '%Y-%m-%d')='" . $DATE_UNE."'";

       }


if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {

$criteres_histo = " and DATE_FORMAT(DATE_INSERTION, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";
    
}
if ($IS_PAID!= '') {

$criteres_histo .= " and IS_PAIDO = ". $IS_PAID." ";
                      
                    }
        



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal=" SELECT `NUMERO_PLAQUE`,`NUMERO_PERMIS`,`ID_UTILISATEUR`,`MONTANT`,`DATE_INSERTION`,`NOM`,`PRENOM`,`CNI` FROM `historiques`   WHERE 1 AND MONTANT IS NOT NULL  ".$criteres_histo." ";

        $limit='LIMIT 0,10';
        if($_POST['length'] != -1)
        {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $order_by='';
        if($_POST['order']['0']['column']!=0)
        {
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE  ASC'; 
        }

        $search = !empty($_POST['search']['value']) ? ("AND (NUMERO_PLAQUE LIKE '%$var_search%'  OR NUMERO_PERMIS LIKE '%$var_search%' OR MONTANT LIKE '%$var_search%' OR NOM LIKE '%$var_search%' OR PRENOM LIKE '%$var_search%' ) ") : ''; 

$critaire=" and DATE_FORMAT(`DATE_INSERTION`,'%Y')='" . $KEY."'";

if (!empty($ANNE)) {
$critaire = " and DATE_FORMAT(`DATE_INSERTION`,'%m-%Y')='" . $KEY."'";
                      
                    }

 if (!empty($MOIS)) {
                    
$critaire = " and DATE_FORMAT(`DATE_INSERTION`,'%d-%m-%Y')='" . $KEY."'";

}
if(!empty($DATE_UNE) && empty($DATE_DEUX)){

$critaire = " AND DATE_FORMAT(`DATE_INSERTION`,'%H')='" . $KEY."'";
    
       }

     
if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
 $critaire = "DATE_FORMAT(`DATE_INSERTION`,'%d-%m-%Y')='" . $KEY."'";
                       
                    }
        
       
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {

         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NOM.' '.$row->PRENOM;
         $intrant[] =$row->CNI;
          $intrant[] =$row->NUMERO_PERMIS;
         $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =number_format($row->MONTANT,0,',',' ').' FBU';
          $intrant[] =$row->DATE_INSERTION;
        
         $data[] = $intrant;
          }

        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" =>$this->Model->all_data($query_principal),
            "recordsFiltered" => $this->Model->filtrer($query_filter),
            "data" => $data
        );

        echo json_encode($output);
    }

     function detail1()
    {
   $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');
    $IS_PAID = $this->input->post('IS_PAID');

    $ANNE = $this->input->post('ANNE');
    $MOIS = $this->input->post('MOIS'); 

   $KEY=$this->input->post('key');

   $criteres_histo ='';

if (!empty($ANNE)) {
$criteres_histo = " and DATE_FORMAT(DATE_INSERT, '%Y')='" . $ANNE."'";
                      
}

if (!empty($MOIS)) {

$criteres_histo = " and DATE_FORMAT(DATE_INSERT, '%Y-%m')='" . $MOIS."'";

                    }
if(!empty($DATE_UNE) && empty($DATE_DEUX)){

        $criteres_histo = " and DATE_FORMAT(DATE_INSERT, '%Y-%m-%d')='" . $DATE_UNE."'";

       }


if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {

$criteres_histo = " and DATE_FORMAT(DATE_INSERT, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";
    
}
if ($IS_PAID!= '') {

$criteres_histo .= " and STATUT_PAYE = ". $IS_PAID." ";
                      
                    }
        



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal=" SELECT `AMENDE`,historique_signalement.DATE_INSERT,`DESCRIPTION_INFRATION`,obr_immatriculations_voitures.TELEPHONE,obr_immatriculations_voitures.NUMERO_PLAQUE,obr_immatriculations_voitures.NOM_PROPRIETAIRE,obr_immatriculations_voitures.PRENOM_PROPRIETAIRE FROM `historique_signalement` LEFT JOIN obr_immatriculations_voitures ON historique_signalement.ID_IMMATICULATION=obr_immatriculations_voitures.ID_IMMATRICULATION WHERE 1 AND AMENDE IS NOT NULL  ".$criteres_histo." ";

        $limit='LIMIT 0,10';
        if($_POST['length'] != -1)
        {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $order_by='';
        if($_POST['order']['0']['column']!=0)
        {
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE  ASC'; 
        }

        $search = !empty($_POST['search']['value']) ? ("AND (AMENDE LIKE '%$var_search%'  OR historique_signalement.DATE_INSERT LIKE '%$var_search%' OR DESCRIPTION_INFRATION LIKE '%$var_search%' OR obr_immatriculations_voitures.TELEPHONE LIKE '%$var_search%' OR obr_immatriculations_voitures.PRENOM_PROPRIETAIRE LIKE '%$var_search%' OR obr_immatriculations_voitures.NOM_PROPRIETAIRE LIKE '%$var_search%' ) ") : ''; 



$critaire=" and DATE_FORMAT(`DATE_INSERT`,'%Y')='" . $KEY."'";

if (!empty($ANNE)) {
$critaire = " and DATE_FORMAT(`DATE_INSERT`,'%m-%Y')='" . $KEY."'";
                      
                    }

 if (!empty($MOIS)) {
                    
$critaire = " and DATE_FORMAT(`DATE_INSERT`,'%d-%m-%Y')='" . $KEY."'";

}
if(!empty($DATE_UNE) && empty($DATE_DEUX)){

$critaire = " AND DATE_FORMAT(`DATE_INSERT`,'%H')='" . $KEY."'";
    
       }

     
if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
 $critaire = "DATE_FORMAT(`DATE_INSERT`,'%d-%m-%Y')='" . $KEY."'";
                       
                    }
        
       
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {

         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NOM_PROPRIETAIRE.' '.$row->PRENOM_PROPRIETAIRE;
         $intrant[] =$row->TELEPHONE;
         $intrant[] =$row->NUMERO_PLAQUE;
          $intrant[] =number_format($row->AMENDE,0,',',' ').' FBU';
         $intrant[] =$row->DATE_INSERT;
         
         $data[] = $intrant;
          }

        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" =>$this->Model->all_data($query_principal),
            "recordsFiltered" => $this->Model->filtrer($query_filter),
            "data" => $data
        );

        echo json_encode($output);
    }
}
