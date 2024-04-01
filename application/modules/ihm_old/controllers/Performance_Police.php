<?php

class Performance_Police extends CI_Controller
{







          function getperformance($ID = 0)
        {

                //$ID = 5;


                $agent = $this->Modele->getRequeteOne("SELECT pa.DATE_DEBUT,pa.DATE_FIN,e.ID_PSR_ELEMENT,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,e.DATE_NAISSANCE,e.PHOTO,p.PROVINCE_NAME as PROV_NAISSANCE,c.COMMUNE_NAME as COM_NAISSANCE,z.ZONE_NAME as ZONE_NAISSANCE,co.COLLINE_NAME as COLL_NAISSANCE,e.TELEPHONE,e.EMAIL,pr.PROVINCE_NAME as PROV_AFFECT,cm.COMMUNE_NAME as COMM_AFFECT,zo.ZONE_NAME as ZON_AFFECT, col.COLLINE_NAME as COLLINE_AFFECT,a.LIEU_EXACTE,a.LATITUDE,a.LONGITUDE FROM psr_elements e LEFT JOIN psr_element_affectation pa ON e.ID_PSR_ELEMENT=pa.ID_PSR_ELEMENT LEFT JOIN  psr_affectatations a ON a.PSR_AFFECTATION_ID=pa.PSR_AFFECTATION_ID  LEFT JOIN syst_provinces p on p.PROVINCE_ID=e.PROVINCE_ID LEFT JOIN syst_communes c on c.COMMUNE_ID=e.COMMUNE_ID LEFT JOIN syst_zones z on z.ZONE_ID=e.ZONE_ID LEFT JOIN syst_collines co ON e.COLLINE_ID=co.COLLINE_ID LEFT JOIN syst_provinces pr on pr.PROVINCE_ID=a.PROVINCE_ID LEFT JOIN syst_communes cm on cm.COMMUNE_ID=a.COMMUNE_ID LEFT JOIN syst_zones zo on zo.ZONE_ID=a.ZONE_ID LEFT JOIN syst_collines col ON a.COLLINE_ID=col.COLLINE_ID WHERE 1 and e.ID_PSR_ELEMENT=" . $ID);

                $rapport = $this->Modele->getRequete("SELECT SUM(`MONTANT`) AS AMANDE, DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y') AS JOURS FROM historiques h JOIN utilisateurs u ON u.ID_UTILISATEUR=h.ID_UTILISATEUR  WHERE u.PSR_ELEMENT_ID=" . $ID . " GROUP by DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y')");

                $carte_rapport = $this->Modele->getRequete('SELECT h.ID_HISTORIQUE,h.LATITUDE,h.LONGITUDE,h.DATE_INSERTION,concat(psr.NOM," ", psr.PRENOM) as NOM, psr.NUMERO_MATRICULE FROM historiques h LEFT JOIN utilisateurs u on h.ID_UTILISATEUR=u.ID_UTILISATEUR LEFT JOIN psr_elements psr on u.PSR_ELEMENT_ID=psr.ID_PSR_ELEMENT WHERE h.ID_HISTORIQUE=' . $ID);

                $data['dateVerifi'] = $this->Model->getRequete("SELECT DATE_FORMAT(DATE_INSERTION, '%d-%m-%Y') AS DATE_VERIFIF  FROM `historiques` WHERE 1 GROUP by DATE_VERIFIF");

                $nombre = 0;

                $donne = "";
                $catego = "";
                $datas = 0;
                $donne_carte = '';

                $points = "";

                $dateDay = $this->input->post('DATE_VERIFIF');

        
               
                foreach ($carte_rapport as $key => $value) {

                        $lat = $value['LATITUDE'] != null ? $value['LATITUDE'] : 1;
                        $long = $value['LONGITUDE'] != null ? $value['LONGITUDE'] : 1;

                        $donne_carte .= 'var fixedMarker = L.marker(new L.LatLng(' . $lat . ',' . $long . '), {
                        icon: L.mapbox.marker.icon({
                            "marker-color": "ff8888"
                            })
                        }).bindPopup("<center><b>' . $agent["NOM"] . '</b><br>' . $agent["PRENOM"] . '<br>' . $agent["NUMERO_MATRICULE"] . '</center>").addTo(map);';
                }

      



       
        if (empty($dateDay)) {
        
                if (!empty($rapport)) {

                        foreach ($rapport as  $value) {
                                $mm = !empty($value['AMANDE']) ? $value['AMANDE'] : 0;
                                $date  =  !empty($value['JOURS']) ? $value['JOURS'] : date('d-m-Y');
                                $catego .= "'" . $date . "',";
                                $datas .=  $mm . ",";
                                $points .=   "200000,";
                                $nombre += $value['AMANDE'];
                        }
                } else {

                        $mm = 0;
                        $date  =   date('d-m-Y');
                        $catego .= "'" . $date . "',";
                        $datas .=  $mm . ",";
                        $nombre += $mm;

                        $points .=   "200000,";
                }

        }else{
                      

                        for ($heures=0; $heures < 24 ; $heures++) { 

                            $hors =  (strlen($heures) == 1) ? '0'.$heures : $heures;
                            $condu = $dateDay.' '.$hors;

                            $id = !empty($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

                               $requete=  $this->Modele->getRequeteOne("SELECT SUM(`MONTANT`) AS AMANDE,DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y %H') FROM historiques h JOIN utilisateurs u ON u.ID_UTILISATEUR=h.ID_UTILISATEUR  WHERE u.PSR_ELEMENT_ID='".$id."' AND DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y %H')='".$condu."' GROUP BY DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y %H')");

                                $mm = !empty($requete['AMANDE']) ? $requete['AMANDE'] : 0;
                                
                                $catego .= "'" . $hors . "h',";
                                $datas .=  $mm . ",";
                                $nombre += $mm;

                                $points .=   "200000,";
               
                        }


                   
        

        }



        

                $catego .= "@";
                $catego = str_replace(",@", "", $catego);

                $datas .= "@";
                $datas = str_replace(",@", "", $datas);

                $points .= "@";
                $points = str_replace(",@", "", $points);


                $donne = $datas;
                $donnePoint = $points;

                $data['donne_carte'] = $donne_carte;
                $data['catego'] = $catego;
                $data['donne'] = $donne;

                $data['donnePoint'] = $donnePoint;

                $data['total'] = $nombre;

                $data['trove'] = $dateDay;

                // print_r($catego.$donne);
                // exit();

                $data['title'] = "Tableau de bord d'un agent";
                $data['agent'] = $agent;
                

                $map = $this->load->view('Performance_Police_View_get', $data, TRUE);
                $output = array('cartes' => $map);

                echo json_encode($output);



        }











        function index($ID = 0)
        {

                //$ID = 5;

                $agent = $this->Modele->getRequeteOne("SELECT pa.DATE_DEBUT,pa.DATE_FIN,e.ID_PSR_ELEMENT,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,e.DATE_NAISSANCE,e.PHOTO,p.PROVINCE_NAME as PROV_NAISSANCE,c.COMMUNE_NAME as COM_NAISSANCE,z.ZONE_NAME as ZONE_NAISSANCE,co.COLLINE_NAME as COLL_NAISSANCE,e.TELEPHONE,e.EMAIL,pr.PROVINCE_NAME as PROV_AFFECT,cm.COMMUNE_NAME as COMM_AFFECT,zo.ZONE_NAME as ZON_AFFECT, col.COLLINE_NAME as COLLINE_AFFECT,a.LIEU_EXACTE,a.LATITUDE,a.LONGITUDE FROM psr_elements e LEFT JOIN psr_element_affectation pa ON e.ID_PSR_ELEMENT=pa.ID_PSR_ELEMENT LEFT JOIN  psr_affectatations a ON a.PSR_AFFECTATION_ID=pa.PSR_AFFECTATION_ID  LEFT JOIN syst_provinces p on p.PROVINCE_ID=e.PROVINCE_ID LEFT JOIN syst_communes c on c.COMMUNE_ID=e.COMMUNE_ID LEFT JOIN syst_zones z on z.ZONE_ID=e.ZONE_ID LEFT JOIN syst_collines co ON e.COLLINE_ID=co.COLLINE_ID LEFT JOIN syst_provinces pr on pr.PROVINCE_ID=a.PROVINCE_ID LEFT JOIN syst_communes cm on cm.COMMUNE_ID=a.COMMUNE_ID LEFT JOIN syst_zones zo on zo.ZONE_ID=a.ZONE_ID LEFT JOIN syst_collines col ON a.COLLINE_ID=col.COLLINE_ID WHERE 1 and  e.ID_PSR_ELEMENT=" . $ID);

                $rapport = $this->Modele->getRequete("SELECT SUM(`MONTANT`) AS AMANDE, DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y') AS JOURS FROM historiques h JOIN utilisateurs u ON u.ID_UTILISATEUR=h.ID_UTILISATEUR  WHERE u.PSR_ELEMENT_ID=" . $ID . " GROUP by DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y')");

                $carte_rapport = $this->Modele->getRequete('SELECT h.ID_HISTORIQUE,h.LATITUDE,h.LONGITUDE,h.DATE_INSERTION,concat(psr.NOM," ", psr.PRENOM) as NOM, psr.NUMERO_MATRICULE FROM historiques h LEFT JOIN utilisateurs u on h.ID_UTILISATEUR=u.ID_UTILISATEUR LEFT JOIN psr_elements psr on u.PSR_ELEMENT_ID=psr.ID_PSR_ELEMENT WHERE h.ID_HISTORIQUE=' . $ID);

                $data['dateVerifi'] = $this->Model->getRequete("SELECT DATE_FORMAT(DATE_INSERTION, '%d-%m-%Y') AS DATE_VERIFIF  FROM `historiques` WHERE 1 GROUP by DATE_VERIFIF");

                $nombre = 0;

                $donne = "";
                $catego = "";
                $datas = 0;
                $donne_carte = '';

                $points = "";

                $dateDay = $this->input->post('DATE_VERIFIF');

        
               
                foreach ($carte_rapport as $key => $value) {

                        $lat = $value['LATITUDE'] != null ? $value['LATITUDE'] : 1;
                        $long = $value['LONGITUDE'] != null ? $value['LONGITUDE'] : 1;

                        $donne_carte .= 'var fixedMarker = L.marker(new L.LatLng(' . $lat . ',' . $long . '), {
                        icon: L.mapbox.marker.icon({
                            "marker-color": "ff8888"
                            })
                        }).bindPopup("<center><b>' . $agent["NOM"] . '</b><br>' . $agent["PRENOM"] . '<br>' . $agent["NUMERO_MATRICULE"] . '</center>").addTo(map);';
                }

      



       
        if (empty($dateDay)) {
        
                if (!empty($rapport)) {

                        foreach ($rapport as  $value) {
                                $mm = !empty($value['AMANDE']) ? $value['AMANDE'] : 0;
                                $date  =  !empty($value['JOURS']) ? $value['JOURS'] : date('d-m-Y');
                                $catego .= "'" . $date . "',";
                                $datas .=  $mm . ",";
                                $points .=   "200000,";
                                $nombre += $value['AMANDE'];
                        }
                } else {

                        $mm = 0;
                        $date  =   date('d-m-Y');
                        $catego .= "'" . $date . "',";
                        $datas .=  $mm . ",";
                        $nombre += $mm;

                        $points .=   "200000,";
                }

        }else{
                      

                        for ($heures=0; $heures < 24 ; $heures++) { 

                            $hors =  (strlen($heures) == 1) ? '0'.$heures : $heures;
                            $condu = $dateDay.' '.$hors;

                            $id = !empty($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

                               $requete=  $this->Modele->getRequeteOne("SELECT SUM(`MONTANT`) AS AMANDE,DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y %H') FROM historiques h JOIN utilisateurs u ON u.ID_UTILISATEUR=h.ID_UTILISATEUR  WHERE u.PSR_ELEMENT_ID='".$id."' AND DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y %H')='".$condu."' GROUP BY DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y %H')");

                                $mm = !empty($requete['AMANDE']) ? $requete['AMANDE'] : 0;
                                
                                $catego .= "'" . $hors . "h',";
                                $datas .=  $mm . ",";
                                $nombre += $mm;

                                $points .=   "200000,";
               
                        }


                   
        

        }



        

                $catego .= "@";
                $catego = str_replace(",@", "", $catego);

                $datas .= "@";
                $datas = str_replace(",@", "", $datas);

                $points .= "@";
                $points = str_replace(",@", "", $points);


                $donne = $datas;
                $donnePoint = $points;

                $data['donne_carte'] = $donne_carte;
                $data['catego'] = $catego;
                $data['donne'] = $donne;

                $data['donnePoint'] = $donnePoint;

                $data['total'] = $nombre;

                $data['trove'] = $dateDay;

                // print_r($catego.$donne);
                // exit();

                $data['title'] = "Tableau de bord d'un agent";
                $data['agent'] = $agent;
                $this->load->view('Performance_Police_View', $data);
        }
}
