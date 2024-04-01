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
                            $datas .=  $mm . ",";
                            $nombre += $mm;
                        }

                          
                    }else{

                            $mm = 0;
                            $date  =  date('d-m-Y');
                            $catego .= "'" . $date . "',";
                            $datas .=  $mm . ",";
                            $nombre += $mm;

                    }



                    if (!empty($Amendes_h)) {

                        foreach ($Amendes_h as  $value) {
                            $mm = !empty($value['MONTANT']) ? $value['MONTANT'] : 0;
                            $date  =  !empty($value['DATE_h']) ? $value['DATE_h'] : date('d-m-Y');
                            $catego2 .= "'" . $date . "',";
                            $datas2 .=  $mm . ",";
                            $nombre2 += $mm;
                       }
                       
                    }else{

                            $mm =  0;
                            $date  =  date('d-m-Y');
                            $catego2 .= "'" . $date . "',";
                            $datas2 .=  $mm . ",";
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

  
                    $this->load->view("Rapport_Financier_V", $data);
          }




          function gettexts($text = "0")
          {

                    if (!empty($text)) {
                              $test = (strlen($text) == 1) ? '0' . $text : $text;
                              return $test;
                    }
          }
}
