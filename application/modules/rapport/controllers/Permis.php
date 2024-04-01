<?php

class Permis extends CI_Controller
{ 


function index(){

//Faut permis 
$fautPM=$this->Modele->getRequeteOne("SELECT COUNT(DISTINCT NUMERO_PERMIS)as NBR FROM `historiques` WHERE `NUMERO_PERMIS` IS NOT NULL AND NUMERO_PERMIS NOT IN (SELECT `NUMERO_PERMIS`FROM `chauffeur_permis` GROUP BY `NUMERO_PERMIS`) ");

$Verifie_VraiPM=$this->Modele->getRequeteOne("SELECT COUNT(DISTINCT NUMERO_PERMIS)as NBR FROM `historiques` WHERE `NUMERO_PERMIS` IS NOT NULL AND NUMERO_PERMIS IN (SELECT `NUMERO_PERMIS`FROM `chauffeur_permis` GROUP BY `NUMERO_PERMIS`) ");

//Bon permis
$psr_permis=$this->Modele->getRequeteOne("SELECT COUNT(DISTINCT NUMERO_PERMIS)as NBR FROM chauffeur_permis ");


$data['permisPSR']=$psr_permis['NBR'];

$data['fautPermis']=$fautPM['NBR'];

$data['bonPermis']=$Verifie_VraiPM['NBR'];

$data['title']="Rapport sur les permis";



$this->load->view('Permis_view',$data);


}






} 
//}
?>