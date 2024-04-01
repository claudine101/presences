<?php

//CLAUDE NIYO 

class Dashboard_Otraco extends CI_Controller
{    
    function index()
    {
  
//requete pour retourner les voitures dont le controle technique expire par rapport à la date actuelle 


      $requete=$this->Modele->getRequete("
SELECT *, if(`DATE_VALIDITE` < CURRENT_DATE(),'invalide','valide') AS name,COUNT(ID_CONTROLE)AS NBRE FROM `otraco_controles` WHERE 1 GROUP BY name,ID_CONTROLE");


      $requete2=$this->Modele->getRequete("SELECT *, if(DATE_VALIDITE < CURRENT_DATE(),'invalide','valide') AS name,COUNT(`ID_ASSURANCE`)AS NBRE FROM `assurances_vehicules` WHERE 1 GROUP BY name,ID_ASSURANCE");
      

 $nombre=0;
 $nombre1=0;
 
 $donnees="";
 $donnees1="";
 

 //$categorie1='';
 foreach ($requete as  $value) {
  
  $nombre=$nombre+$value['NBRE'];
  if($value['name']=="invalide"){
    $couleur='color:"black"';

  }
  if($value['name']=="valide"){
    $couleur='color:"blue"';
    
  }
  $name=(!empty($value['name']))? $value['name']:'AUCUN ELEMENT';
  $nbre=(!empty($value['NBRE']))? $value['NBRE']:'0';




  $donnees.="{name:'".str_replace("'","\'",$name).": ".$nbre."', y:".$nbre.",key:'".$value['name']."',".$couleur."},";
 }

foreach ($requete2 as  $value) {
  
  $nombre1=$nombre1+$value['NBRE'];
  if($value['name']=="invalide"){
    $couleur='color:"black"';

  }
  if($value['name']=="valide"){
    $couleur='color:"blue"';
    
  }
  $name=(!empty($value['name']))? $value['name']:'AUCUN ELEMENT';
  $nbre=(!empty($value['NBRE']))? $value['NBRE']:'0';




  $donnees1.="{name:'".str_replace("'","\'",$name)." :".$nbre."', y:".$nbre.",key:'".$value['name']."',".$couleur."},";
 }


//print_r($donnees);exit();

    
    $data['title']='Espace Contrôle ';
    $data['donnees']=$donnees;
    $data['nom']=$nombre;
     $data['nombre']=$nombre1;
      $data['donnees1']=$donnees1;

   // print_r($donnees1);
   // exit();
$this->load->view('Otraco_V',$data);




}
function detailControle()
 { 

  $KEY=$this->input->post('key');
  $break=explode(".",$KEY);
  $ID=$KEY;
  
$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

$query_principal="SELECT ID_CONTROLE,NUMERO_CONTROLE,NUMERO_PLAQUE,NUMERO_CHASSIS,PROPRIETAIRE,DATE_DEBUT,DATE_VALIDITE,TYPE_VEHICULE FROM otraco_controles WHERE 1";

$limit='LIMIT 0,10';
if($_POST['length'] != -1)
{
  $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
}
$order_by='';
if($_POST['order']['0']['column']!=0)
{
  $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE   DESC';
}

$search = !empty($_POST['search']['value']) ? (" AND (otraco_controles.NUMERO_PLAQUE LIKE '%$var_search%' OR  otraco_controles.TYPE_VEHICULE LIKE '%$var_search%' OR  otraco_controles.PROPRIETAIRE LIKE '%$var_search%' OR `otraco_controles`.`PROPRIETAIRE` LIKE '%$var_search%' ) ") : '';

$critaire = ($ID=='invalide') ? 'AND `DATE_VALIDITE` < CURRENT_DATE()' :'AND `DATE_VALIDITE` >= CURRENT_DATE()';



$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
$query_filter=$query_principal.' '.$critaire.' '.$search;



$fetch_data = $this->Modele->datatable($query_secondaire);
$u=0;
$data = array();
foreach ($fetch_data as $row)  
{


  $u++;
  $intrant=array();
  $intrant[] = $u;
  $intrant[] =$row->NUMERO_PLAQUE;
  $intrant[] =$row->DATE_VALIDITE;    
  $intrant[] =$row->TYPE_VEHICULE;
 $intrant[] =$row->PROPRIETAIRE;
 

  $data[] = $intrant;
}

$output = array(
  "draw" => intval($_POST['draw']),
  "recordsTotal" =>$this->Modele->all_data($query_principal),
  "recordsFiltered" => $this->Modele->filtrer($query_filter),
  "data" => $data
);

echo json_encode($output);
}

function detailAssurance(){


  $KEY=$this->input->post('key');
  $break=explode(".",$KEY);
  $ID=$KEY;
  
$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

$query_principal="SELECT `ID_ASSURANCE`,`NUMERO_PLAQUE`,assurances_vehicules.ID_ASSUREUR,assureur.ASSURANCE,`DATE_VALIDITE`,`PLACES_ASSURES`,`TYPE_ASSURANCE`,`TYPE_ASSURANCE`,`NOM_PROPRIETAIRE` FROM `assurances_vehicules` LEFT JOIN assureur ON assureur.ID_ASSUREUR=assurances_vehicules.ID_ASSUREUR WHERE 1";

$limit='LIMIT 0,10';
if($_POST['length'] != -1)
{
  $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
}
$order_by='';
if($_POST['order']['0']['column']!=0)
{
  $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE   DESC';
}

$search = !empty($_POST['search']['value']) ? (" AND (assurances_vehicules.NUMERO_PLAQUE LIKE '%$var_search%' OR  ASSURANCE LIKE '%$var_search%' OR   `assurances_vehicules`.`NOM_PROPRIETAIRE` LIKE '%$var_search%' ) ") : '';

$critaire = ($ID=='invalide') ? 'AND `DATE_VALIDITE` < CURRENT_DATE()' :'AND `DATE_VALIDITE` >= CURRENT_DATE()';



$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
$query_filter=$query_principal.' '.$critaire.' '.$search;



$fetch_data = $this->Modele->datatable($query_secondaire);
$u=0;
$data = array();
foreach ($fetch_data as $row)  
{


  $u++;
  $intrant=array();
  $intrant[] = $u;
  $intrant[] =$row->NUMERO_PLAQUE;
  $intrant[] =$row->ASSURANCE;
  $intrant[] =$row->DATE_VALIDITE;    
  $intrant[] =$row->PLACES_ASSURES;
 $intrant[] =$row->NOM_PROPRIETAIRE;
 

  $data[] = $intrant;
}

$output = array(
  "draw" => intval($_POST['draw']),
  "recordsTotal" =>$this->Modele->all_data($query_principal),
  "recordsFiltered" => $this->Modele->filtrer($query_filter),
  "data" => $data
);

echo json_encode($output);
}

}
?>