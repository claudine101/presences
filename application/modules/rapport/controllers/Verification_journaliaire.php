<?php

class Verification_journaliaire extends CI_Controller
{

function index()
{

//Nombre de controle physique par vehicule
$controllerVehicule=$this->Modele->getRequete("SELECT COUNT(`NUMERO_PLAQUE`) as PLAQUE , COUNT(`NUMERO_PERMIS`) as PERMIS ,DATE_FORMAT(`DATE_INSERTION`, '%d-%m-%Y') AS DATEV FROM `historiques` GROUP BY DATE_FORMAT(`DATE_INSERTION`, '%d-%m-%Y')"); 


$nombre=0;
$nombre2=0;

$donne = "";
$catego = "";
$datas = 0;
$datas2 = 0;


foreach ($controllerVehicule as  $value) 
{

$catego.= "'".$value['DATEV']."',";
$datas .=  $value['PLAQUE'].",";

$datas2 .=  $value['PERMIS'].",";

$nombre+=$value['PLAQUE'];
$nombre2+=$value['PERMIS'];

}
$catego.= "@";
$catego= str_replace(",@", "", $catego);

$datas.= "@";
$datas = str_replace(",@", "", $datas);

$datas2.= "@";
$datas2 = str_replace(",@", "", $datas2);


$donne .="{
        name: 'plaque',
        data: [".$datas."]
    },";

$donne .="{
        name: 'Permis',
        data: [".$datas2."]
    },";


$data['catego'] = $catego;
$data['donne'] = $donne;
$data['total'] = $nombre;
$data['total2'] = $nombre2;



$data['title']="Rapport sur le Nombre de controle physique par vehicule";

$this->load->view('verification_journaliaire_v',$data);

}


}
