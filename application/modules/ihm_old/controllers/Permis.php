<?php
class Permis extends CI_Controller
{

    function index($id=0)
    {

        $Permis=$this->Modele->getRequeteOne("SELECT `ID_PERMIS`, `NUMERO_PERMIS`, `NOM_PROPRIETAIRE`, `CATEGORIES`, `DATE_NAISSANCE`, `DATE_DELIVER`, `DATE_EXPIRATION` FROM `chauffeur_permis` WHERE ID_PERMIS=".$id);

        $rapport = $this->Modele->getRequete("SELECT SUM(q.MONTANT) as AMENDE_PERMIS,SUM(q.POURCENTAGE) as POINT_PERMIS, date_format(DATE_INSERTION, '%d-%m-%Y') AS dateChec FROM historiques h JOIN autres_controles co on h.ID_COMPORTEMENT=co.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q on co.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES WHERE 1 and `HAS_PERMIS`=1 and `NUMERO_PERMIS`='".$Permis['NUMERO_PERMIS']."' GROUP by date_format(DATE_INSERTION, '%d-%m-%Y')");

        $carte=$this->Modele->getRequete('SELECT LATITUDE, LONGITUDE,DATE_INSERTION FROM historiques WHERE 1 AND NUMERO_PERMIS= "'.$Permis['NUMERO_PERMIS'].'"');

        $nombre=0;

        $nombrePoint = 0;
        $nombreAmende = 0;

        $donne = "";
        $catego = "";
        $Points = "";
        $Amendes = "";
        $donne_carte="";

        if (!empty($rapport)) {

            foreach ($rapport as  $value) 
            {
                $mm = !empty($value['AMENDE_PERMIS']) ? $value['AMENDE_PERMIS']/1000 : 0;
                $nn= !empty($value['POINT_PERMIS']) ? $value['POINT_PERMIS'] : 0;

                $date  =  !empty($value['JOURS']) ? $value['JOURS'] : date('d-m-Y');
                $catego.= "'".$date."',";
                $Points .=  $nn.",";
                $Amendes .=  $mm.",";

                $nombrePoint+=$value['POINT_PERMIS'];
                $nombreAmende+=$value['AMENDE_PERMIS'];

            }

        }else{

            $mm = 0;
            $nn = 0;
            $date  =   date('d-m-Y');
            $catego.= "'".$date."',";

              
            $Points .=  $mm.",";
            $Amendes .=  $nn.",";

            $nombrePoint+=$mm;
            $nombreAmende+=$mm;
        }

        $catego.= "@";
        $catego= str_replace(",@", "", $catego);

        $Points.= "@";
        $Points = str_replace(",@", "", $Points);

        $Amendes.= "@";
        $Amendes = str_replace(",@", "", $Amendes);


        $donne .="{
        name: 'Points (".$nombrePoint.")',
        data: [".$Points."]
        }, {
        name: 'Amendes (".number_format($nombreAmende, 0, ',', ' ')." BIF)',
        data: [".$Amendes."]
        }";



        
        foreach ($carte as $key => $value) {

           $lat=$value['LATITUDE'] != null ? $value['LATITUDE'] : 1;
           $long=$value['LONGITUDE'] != null ? $value['LONGITUDE'] : 1;

            $donne_carte.='var fixedMarker = L.marker(new L.LatLng('.$lat.','.$long.'), {
                icon: L.mapbox.marker.icon({
                    "marker-color": "ff8888"
                    })
                }).bindPopup("<center><b>'.$Permis["NOM_PROPRIETAIRE"].'</b><br>'.$Permis["NUMERO_PERMIS"].'<br>'.$Permis["CATEGORIES"].'</center>").addTo(map);';

            }



            $data['donne_carte']=$donne_carte;

            $data['catego'] = $catego;
            $data['donne'] = $donne;
            $data['totalPoint'] = $nombrePoint;
            $data['totalAmende'] = $nombreAmende;

            $data['title']= "Permis Utilisateur";
            $data['Permis']=$Permis;
            $data=$this->load->view('Permis_View',$data);

        }





    }
?>