<?php

class Autres_controles_plaques extends CI_Controller
{

function index()
{

//Nombre de controle physique par vehicule
$controllerVehicule=$this->Modele->getRequete("SELECT COUNT(`ID_PLAQUE`) AS NBR,`NUMERO_PLAQUE` FROM autres_controles_plaques p LEFT JOIN obr_immatriculations_voitures obr on obr.ID_IMMATRICULATION=p.ID_PLAQUE WHERE 1 AND p.ID_PLAQUE IS NOT NULL GROUP by NUMERO_PLAQUE"); 


$nombre=0;

$donne = "";
$catego = "";
$datas =0;


foreach ($controllerVehicule as  $value) 
{

$catego.= "'".$value['NUMERO_PLAQUE']."',";
$datas .=  $value['NBR'].",";

$nombre+=$value['NBR'];

}
$catego.= "@";
$catego= str_replace(",@", "", $catego);

$datas.= "@";
$datas = str_replace(",@", "", $datas);


$donne .="{
        name: 'Contol psr',
        data: [".$datas."]
    },";


$data['catego'] = $catego;
$data['donne'] = $donne;
$data['total'] = $nombre;


$data['title']="Rapport sur le Nombre de controle physique par vehicule";

$this->load->view('autres_controles_plaques_view',$data);

}


}
