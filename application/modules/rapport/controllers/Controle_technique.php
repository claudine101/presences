<?php
class Controle_technique extends CI_Controller
{


function index()
{

//Vrai Controle Technique
$VraiControleTechnique=$this->Modele->getRequeteOne("SELECT COUNT(DISTINCT `NUMERO_PLAQUE`)as NBR FROM `otraco_controles` WHERE 1");

//Controle Technique Verifier
$ControleTechniqueVerifier=$this->Modele->getRequeteOne("SELECT COUNT(DISTINCT `NUMERO_PLAQUE`)as NBR FROM `historiques` WHERE `NUMERO_PLAQUE` IS NOT NULL AND `NUMERO_PLAQUE` IN (SELECT `NUMERO_PLAQUE`FROM `otraco_controles` GROUP BY `NUMERO_PLAQUE`) ");


//Faut Controle technique
$FautControleTechnique=$this->Modele->getRequeteOne("SELECT COUNT(DISTINCT NUMERO_PLAQUE)as NBR FROM `historiques` WHERE `NUMERO_PLAQUE` IS NOT NULL AND NUMERO_PLAQUE NOT IN (SELECT `NUMERO_PLAQUE` FROM `otraco_controles` WHERE 1 GROUP BY `NUMERO_PLAQUE`)");


$data['title']="Rapport sur les Controle Technique";

$data['otraco']=$VraiControleTechnique['NBR'];
$data['FautControleTechnique']=$FautControleTechnique['NBR'];
$data['ControleTechniqueVerifier']=$ControleTechniqueVerifier['NBR'];



$this->load->view('Otraco_Control_View',$data);


}
}

?>