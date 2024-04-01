<?php

class Signalement_Citoyen extends CI_Controller
{

function index()
{
 
  //nombre de controle de signalement citoyen

  $signal=$this->Modele->getRequete('SELECT COUNT(`CIVIL_DESCRIPTION`)as SIGNALEMENT,COUNT(`STATUT_TRAITEMENT`)as STATUT, date_format(`DATE_INSERTION`,"%d-%m-%Y")as DATES FROM `civil_alerts` WHERE 1 GROUP BY date_format(`DATE_INSERTION`,"%d-%m-%Y")');



  $nombre=0;
  $nombre2=0;

  $donne = "";
  $catego = "";
  $datas = 0;
  $datas2 = 0;


   foreach ($signal as $value) 
   {
    
   $catego.= "'".$value['DATES']."',";
   $datas .=  $value['SIGNALEMENT'].",";

   $datas2 .=  $value['STATUT'].",";

   $nombre+=$value['SIGNALEMENT'];
   $nombre2+=$value['STATUT'];

  }

  $catego.= "@";
  $catego= str_replace(",@", "", $catego);

  $datas.= "@";
  $datas = str_replace(",@", "", $datas);

  $datas2.= "@";
  $datas2 = str_replace(",@", "", $datas2);

  $donne .="{
        name: 'Signalement',
        data: [".$datas."]
    },";

$donne .="{
        name: 'Statut',
        data: [".$datas2."]
    },";


$data['catego'] = $catego;
$data['donne'] = $donne;
$data['total'] = $nombre;
$data['total2'] = $nombre2;


$data['title']="SIGNALEMENT";

$this->load->view('Signalement_Citoyen_V',$data);


}	

}
?>