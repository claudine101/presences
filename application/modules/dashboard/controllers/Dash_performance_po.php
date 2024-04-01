<?php

//CLAUDE NIYO 

class Dash_performance_police extends CI_Controller
{    
  function index()
  {

   $annees=$this->Model->getRequete('SELECT DISTINCT date_format(h.DATE_INSERTION,"%Y") AS ANNEE FROM historiques h WHERE 1  ORDER BY ANNEE'); 
  // $status=$this->Model->getRequete('SELECT IF(IS_PAID=1,"Payé", "Non Payé") AS STATUT FROM historiques h WHERE 1  ORDER BY statut'); 

   $ANNEE=$this->input->post('ANNEE');
   $MOIS=$this->input->post('MOIS');
   $DAYS=$this->input->post('DAYS');
   $STATUT=$this->input->post('STATUT');

   $criteres="";
   $critere_date="";
   $date='';
   $mois='';
   $jour='';
   $heures='';

   if(empty($ANNEE)){
    $mois=date('Y-m-d');

    $critere_date.=" AND  date_format(h.`DATE_INSERTION`,'%Y') = '".$mois."' ";
  }
  else{
   $critere_date.=" AND  date_format(h.`DATE_INSERTION`,'%Y') = '".$ANNEE."' ";
 } 


 if (!empty($ANNEE))
 {
  $mois=$this->Model->getRequete("SELECT DISTINCT  date_format(h.`DATE_INSERTION`,'%m') AS MOIS FROM historiques h WHERE date_format(h.`DATE_INSERTION`,'%Y')=".$ANNEE);

  $criteres.=" AND date_format(h.DATE_INSERTION,'%Y')=".$ANNEE;
         

  if (!empty($MOIS))
  {
    $jour=$this->Model->getRequete('SELECT DISTINCT  date_format(h.`DATE_INSERTION`,"%d") AS DAYS FROM historiques h WHERE date_format(h.`DATE_INSERTION`,"%Y")="'.$ANNEE.'" AND date_format(h.`DATE_INSERTION`,"%m")="'.$MOIS.'" ORDER BY DAYS DESC');

    $criteres.=" AND date_format(h.DATE_INSERTION,'%m')=".$MOIS;

  }
  if (!empty($DAYS))
  { 
    $criteres.=" AND date_format(h.DATE_INSERTION,'%d')=".$DAYS;  
  }
} 
if($STATUT){
  $criteres.=" AND IS_PAID =".$STATUT;
}

$rapport = $this->Modele->getRequete("SELECT COUNT(ID_HISTORIQUE) as Nbre,concat(psr.NOM,' ',psr.PRENOM)  as name FROM historiques h JOIN utilisateurs u ON u.ID_UTILISATEUR=h.ID_UTILISATEUR LEFT JOIN psr_elements psr ON psr.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID  WHERE 1 AND u.PROFIL_ID=6 ".$criteres." GROUP BY name");


$requete2=$this->Modele->getRequete("SELECT SUM(`MONTANT`) AS AMANDE,concat(psr.NOM,' ',psr.PRENOM)  as name FROM historiques h JOIN utilisateurs u ON u.ID_UTILISATEUR=h.ID_UTILISATEUR LEFT JOIN psr_elements psr ON psr.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID  WHERE 1 AND u.PROFIL_ID=6 ".$criteres." GROUP BY name");


$nombre = 0;

$donne = "";
$catego = "";
$datas = 0;


$nombre1=0;
$donne1 = "";

$categos="";
$data1='';
$i=0;


if (!empty($rapport)) {

    foreach ($rapport as  $value) {
      $mm = !empty($value['Nbre']) ? $value['Nbre'] : 0;
      $name  =  !empty($value['name']) ? $value['name'] : 'police';
      $catego .= "'" . $name . "',";
      $datas .=  $mm . ",";
      $nombre += $value['Nbre'];
    }

 //  foreach ($rapport as $value) 
 //  {
 //   $nombre=$nombre+$value['Nbre'];
 //   $name= (!empty($value['name'])) ? $value['name'].' (23)': "Aucun";
 //   $nb= (!empty($value['Nbre'])) ? $value['Nbre']: "0";


 //   $i++;
 //   $key_id=($i>0) ? $i : "0" ;
 //   $donne.="{name:'".str_replace("'","\'",$name)."', y:".$nb.",key:".$key_id."},";
 // }
} else {

  $mm = 0;
  $name  =   'police';
  $catego .= "'" . $name . "',";
  $datas .=  $mm . ",";
  $nombre += $mm;
}


$catego .= "@";
$catego = str_replace(",@", "", $catego);

$datas .= "@";
$datas = str_replace(",@", "", $datas);

$donne .= "{
  name: 'Nombre de contole',
  data: [" . $datas . "]
},";


 
if (!empty($requete2)) {

  foreach ($requete2 as  $value) {
    $mm = !empty($value['AMANDE']) ? $value['AMANDE'] : 0;
    $name  =  !empty($value['name']) ? $value['name'] : date('d-m-Y');
    $categos .= "'" . $name . "',";
    $data1 .=  $mm . ",";


    //echo $value['AMANDE'].'<br>';

    $nombre1 += $value['AMANDE'];

  }
} else {

  $mm = 0;
  $date  = 'police';
  $categos .= "'" . $date . "',";
  $data1 .=  $mm . ",";
  $nombre1 += $mm;
}

$categos .= "@";
$categos = str_replace(",@", "", $categos);

$data1 .= "@";
$data1 = str_replace(",@", "", $data1);







// $donne1 .= "{
//   name: 'Amande',
//   data: [" . $data1 . "]
// },";
 


$data['title']='Performance de fonctionnel de la police ';
$data['catego'] = $catego;
$data['donne'] = $donne;
$data['total'] = $nombre;


$data['categos'] = $categos;
$data['donne1'] = $data1;
$data['total1'] = $nombre1;
//print_r($data['$nombre1']);exit();

$data['ANNEE']=$ANNEE;
$data['MOIS']=$MOIS;
$data['DAYS']=$DAYS;
//$data['statut']=$status;

$data['annees']=$annees;
$data['mois']=$mois;
$data['jour']=$jour;
$this->load->view('dash_performance_police_v',$data);




}




}
