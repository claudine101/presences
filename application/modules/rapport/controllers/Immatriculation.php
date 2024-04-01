<?php
class Immatriculation extends CI_Controller
{


function index()

	{
	

   //Vrai Immatriculation
$vraiIM=$this->Modele->getRequeteOne("SELECT COUNT(DISTINCT NUMERO_PLAQUE)as NBR  FROM `obr_immatriculations_voitures` WHERE 1 ");


$Verifie_VraiIM=$this->Modele->getRequeteOne("SELECT COUNT(DISTINCT NUMERO_PLAQUE)as NBR FROM `historiques` WHERE `NUMERO_PLAQUE` IS NOT NULL AND NUMERO_PLAQUE IN (SELECT `NUMERO_PLAQUE`FROM `obr_immatriculations_voitures` GROUP BY `NUMERO_PLAQUE`) ");



   //Faut Immatriculation	
 $fautIM=$this->Modele->getRequeteOne("SELECT COUNT(DISTINCT NUMERO_PLAQUE)as NBR FROM `historiques` WHERE `NUMERO_PLAQUE` IS NOT NULL AND NUMERO_PLAQUE NOT IN (SELECT `NUMERO_PLAQUE` FROM `obr_immatriculations_voitures` WHERE 1 GROUP BY `NUMERO_PLAQUE`)");



   $data['obr']=$vraiIM['NBR']; 
   $data['FautImmatriculation']=$fautIM['NBR'];
   $data['Vrai_immatriculation']=$Verifie_VraiIM['NBR'];

   $data['title']="Rapport sur les Immatriculation";

   
 

   $this->load->view('Immatriculation_View',$data);

  }
  }

  ?>