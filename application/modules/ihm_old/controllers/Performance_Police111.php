<?php

class Performance_Police extends CI_Controller{

function index ($ID = 0){
 
//$ID = 5;

$agent = $this->Modele->getRequeteOne("SELECT e.ID_PSR_ELEMENT,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,e.DATE_NAISSANCE,e.PHOTO,p.PROVINCE_NAME as PROV_NAISSANCE,c.COMMUNE_NAME as COM_NAISSANCE,z.ZONE_NAME as ZONE_NAISSANCE,co.COLLINE_NAME as COLL_NAISSANCE,e.TELEPHONE,e.EMAIL,pr.PROVINCE_NAME as PROV_AFFECT,cm.COMMUNE_NAME as COMM_AFFECT,zo.ZONE_NAME as ZON_AFFECT, col.COLLINE_NAME as COLLINE_AFFECT,a.LIEU_EXACTE,a.LATITUDE,a.LONGITUDE FROM psr_elements e LEFT JOIN psr_affectatations a ON e.ID_PSR_ELEMENT=a.ID_PSR_ELEMENT LEFT JOIN syst_provinces p on p.PROVINCE_ID=e.PROVINCE_ID LEFT JOIN syst_communes c on c.COMMUNE_ID=e.COMMUNE_ID LEFT JOIN syst_zones z on z.ZONE_ID=e.ZONE_ID LEFT JOIN syst_collines co ON e.COLLINE_ID=co.COLLINE_ID LEFT JOIN syst_provinces pr on pr.PROVINCE_ID=a.PROVINCE_ID LEFT JOIN syst_communes cm on cm.COMMUNE_ID=a.COMMUNE_ID LEFT JOIN syst_zones zo on zo.ZONE_ID=a.ZONE_ID LEFT JOIN syst_collines col ON a.COLLINE_ID=col.COLLINE_ID WHERE e.ID_PSR_ELEMENT=".$ID);

$rapport = $this->Modele->getRequete("SELECT SUM(`MONTANT`) AS AMANDE, DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y') AS JOURS FROM historiques h JOIN utilisateurs u ON u.ID_UTILISATEUR=h.ID_UTILISATEUR  WHERE u.PSR_ELEMENT_ID=".$ID." GROUP by DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y')");

$nombre=0;

$donne = "";
$catego = "";
$datas = 0;


foreach ($rapport as  $value) 
{

$catego.= "'".$value['JOURS']."',";
$datas .=  $value['AMANDE'].",";
$nombre+=$value['AMANDE'];

}

$catego.= "@";
$catego= str_replace(",@", "", $catego);

$datas.= "@";
$datas = str_replace(",@", "", $datas);


$donne .="{
        name: 'Amande',
        data: [".$datas."]
    },";


$data['catego'] = $catego;
$data['donne'] = $donne;
$data['total'] = $nombre;

// print_r($catego.$donne);
// exit();

$data['title']="Tableau de bord d'un agent";
$data['agent'] = $agent;
$this->load->view('Performance_Police_View',$data);

}









}

?>