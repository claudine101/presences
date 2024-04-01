<?php

//CLAUDE NIYO 

class Dashboard_Controles_Tech extends CI_Controller
{    
    function index()
    {
  

        $date=$this->Modele->getRequete("SELECT DISTINCT date_format(`historiques`.`DATE_INSERTION`,'%Y') AS ANNEE FROM historiques ORDER BY ANNEE ASC;");

       $ANNEE=$this->input->post('ANNEE');
      $MOIS=$this->input->post('MOIS');
      $DAYS=$this->input->post('DAYS');
      $criteres='';
      $date1='';
      $date2='';
       if (!empty($ANNEE))
     {
        $date1=$this->Modele->getRequete("SELECT DISTINCT date_format(`historiques`.`DATE_INSERTION`,'%m') AS MOIS FROM historiques WHERE date_format(`historiques`.`DATE_INSERTION`,'%Y')=".$ANNEE);

        $criteres.=" AND date_format(DATE_INSERTION,'%Y')=".$ANNEE;

    if (!empty($MOIS))
    {
      $date2=$this->Modele->getRequete('SELECT DISTINCT  date_format(`historiques`.`DATE_INSERTION`,"%d") AS DAYS FROM historiques WHERE date_format(`historiques`.`DATE_INSERTION`,"%Y")="'.$ANNEE.'" AND date_format(`historiques`.`DATE_INSERTION`,"%m")="'.$MOIS.'" ORDER BY DAYS DESC');
      $criteres.=" AND date_format(DATE_INSERTION,'%m')='".$MOIS."'";
}

if (!empty($DAYS))
    {
      
      $criteres.=" AND date_format(DATE_INSERTION,'%d')='".$DAYS."'";      
}
}

//Evolution journalière
$requete=$this->Modele->getRequete("SELECT  date_format(DATE_INSERTION,'%Y-%m-%d') AS DATE, COUNT(ID_CONTROLE_TECHNIQUE_PEINE) AS NBR FROM historiques WHERE 1".$criteres." GROUP BY DATE");
 $nombre=0;
 $donnees="";
 foreach ($requete as  $value) {
  
  $nombre=$nombre+$value['NBR'];
  $name = (!empty($value['DATE'])) ? $value['DATE'] : "Aucun" ;
  $nb = (!empty($value['NBR'])) ? $value['NBR'] : "0" ;
   
  $donnees.="{name:'".str_replace("'","\'",$name)."', y:".$nb.",key:'".$value['DATE']."'},";
 
    }

  //EVOLUTION MENSUELLE
    $requete1=$this->Modele->getRequete(" SELECT date_format(DATE_INSERTION,'%Y-%M') AS DATE, COUNT(ID_CONTROLE_TECHNIQUE_PEINE) AS NBR FROM historiques  WHERE 1 ".$criteres." GROUP BY DATE");


  $nombre1=0;
 $donnees1="";
 foreach ($requete1 as  $value) {
  
  $nombre1=$nombre1+$value['NBR'];
  $name = (!empty($value['DATE'])) ? $value['DATE'] : "Aucun" ;
  $nb = (!empty($value['NBR'])) ? $value['NBR'] : "0" ;
   
  //$key_id=($value['ID']>0) ? $value['ID'] : "0" ;
  $donnees1.="{name:'".str_replace("'","\'",$name)."', y:".$nb.",key:'".$value['DATE']."'},";
 
    }
  



  $requete2=$this->Modele->getRequete("SELECT  `ID_CONTROLE_TECHNIQUE_PEINE` AS ID,AMENDES , COUNT(`ID_HISTORIQUE`) as NBR FROM historiques 
 JOIN infra_peines  ON historiques.ID_CONTROLE_TECHNIQUE_PEINE=infra_peines.ID_INFRA_PEINE WHERE  NUMERO_PLAQUE IS NOT NULL  ".$criteres." GROUP BY ID_CONTROLE_TECHNIQUE_PEINE, AMENDES");


  $requete3=$this->Modele->getRequete("SELECT ID_ASSURANCE_PEINE AS id,AMENDES,COUNT(`ID_HISTORIQUE`) as nbr FROM historiques 
    JOIN infra_peines  ON historiques.ID_ASSURANCE_PEINE=infra_peines.ID_INFRA_PEINE WHERE  ID_ASSURANCE_PEINE  IS NOT NULL ".$criteres."  GROUP BY  AMENDES,ID_ASSURANCE_PEINE");

  $nombre2=0;
 $donnees2="";
 $nombre3=0;
 $donnees3="";
 foreach ($requete2 as  $value) {
  
  $nombre2=$nombre2+$value['NBR'];
  $names = (!empty($value['AMENDES'])) ? $value['AMENDES'] : "Aucun" ;
  $nb = (!empty($value['NBR'])) ? $value['NBR'] : "0" ;
   
  $key_id=($value['ID']>0) ? $value['ID'] : "0" ;
  $donnees2.="{name:'".str_replace("'","\'",$names)."', low:".$nb.",key:'".$key_id."'},";

    }

    foreach ($requete3 as  $value) {
  
  $nombre3=$nombre3+$value['nbr'];
  $name = (!empty($value['AMENDES'])) ? $value['AMENDES'] : "Aucun" ;
  $nb = (!empty($value['nbr'])) ? $value['nbr'] : "0" ;
   
  $key_id=($value['id']>0) ? $value['id'] : "0" ;
  $donnees3.="{name:'".str_replace("'","\'",$name)."', low:".$nb.",key:'".$key_id."'},";

    }



    
    


    $data['title']='Espace de suivi ';
    $data['donnees']=$donnees;
    $data['nombre']=$nombre;

    $data['donnees1']=$donnees1;
    $data['nombre1']=$nombre1;

    $data['donnees2']=$donnees2;
    $data['nombre2']=$nombre2;

 $data['donnees3']=$donnees3;
    $data['nombre3']=$nombre3;


   $data['year']=$date;
    $data['month']=$date1;
    $data['jour']=$date2;

    $data['ANNEE']=$ANNEE;
    $data['DAYS']=$DAYS;
    $data['MOIS']=$MOIS;




$this->load->view('Dashboard_Controles_view',$data);
}



//details sur le controles technique
function detailControle()
{ 
 
  $KEY=$this->input->post('key');
  $break=explode(".",$KEY);
  $ID=$KEY;

  $ANNEE=$this->input->post('ANNEE');
 $MOIS=$this->input->post('MOIS');
 $DAYS=$this->input->post('DAYS');

$criteres='';
  $criteres2='';
  
 if (!empty($ANNEE)){

  $criteres.="AND date_format(DATE_INSERTION,'%Y')=".$ANNEE." ";

 }

 if (!empty($MOIS)) {

  $criteres=" AND date_format(DATE_INSERTION,'%m')='".$MOIS."'";
 }

 if (!empty($DAYS)) {
   $criteres=" AND date_format(DATE_INSERTION,'%d')='".$DAYS."'";
 }

 

$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;


$query_principal="SELECT AMENDES, NUMERO_PLAQUE , date_format(DATE_INSERTION,'%Y/%m-%d')AS DATE  FROM `historiques` JOIN infra_peines ON historiques.ID_CONTROLE_TECHNIQUE_PEINE=infra_peines.ID_INFRA_PEINE WHERE `NUMERO_PLAQUE` IS NOT NULL ".$criteres." ".$criteres2."";

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

$search = !empty($_POST['search']['value']) ? (" AND (NUMERO_PLAQUE LIKE '%$var_search%'  ) ") : '';


 $critaire=" AND ID_CONTROLE_TECHNIQUE_PEINE=".$ID;
 $group_by="GROUP BY AMENDES,ID_CONTROLE_TECHNIQUE_PEINE,NUMERO_PLAQUE,DATE_INSERTION";

$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$group_by.' '.$order_by.'   '.$limit;
$query_filter=$query_principal.' '.$critaire.''.$search;



$fetch_data = $this->Modele->datatable($query_secondaire);
$u=0;
$data = array();
foreach ($fetch_data as $row)  
{

  $u++;
  $intrant=array();
  $intrant[] = $u;
  $intrant[] =$row->NUMERO_PLAQUE;
  $intrant[] =$row->AMENDES;
    $intrant[] =$row->DATE;
  
  
 

  $data[] = $intrant;
}
//print_r($data[0]);exit();
$output = array(
  "draw" => intval($_POST['draw']),
  "recordsTotal" =>$this->Modele->all_data($query_principal),
  "recordsFiltered" => $this->Modele->filtrer($query_filter),
  "data" => $data
);
echo json_encode($output);
}


//details sur les Assurances
function detailAssurance()
{ 
  $KEY=$this->input->post('key');
  $break=explode(".",$KEY);
  $ab=$KEY;
  $ANNEE=$this->input->post('ANNEE');
 $MOIS=$this->input->post('MOIS');
 $DAYS=$this->input->post('DAYS');


$criteres='';
  $criteres2='';
  
 if (!empty($ANNEE)){

  $criteres.="AND date_format(DATE_INSERTION,'%Y')=".$ANNEE." ";

 }

 if (!empty($MOIS)) {

  $criteres=" AND date_format(DATE_INSERTION,'%m')='".$MOIS."'";
 }

 if (!empty($DAYS)) {
   $criteres=" AND date_format(DATE_INSERTION,'%d')='".$DAYS."'";
 }

 

$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;


$query_principal="SELECT ID_ASSURANCE_PEINE,AMENDES, NUMERO_PLAQUE,date_format(DATE_INSERTION,'%Y/%m-%d')AS DATE   FROM `historiques` JOIN infra_peines ON historiques.ID_ASSURANCE_PEINE=infra_peines.ID_INFRA_PEINE WHERE `NUMERO_PLAQUE` IS NOT NULL ".$criteres." ".$criteres2."";

$limit='LIMIT 0,10';
if($_POST['length'] != -1)
{
  $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
}
$order_by='';
if($_POST['order']['0']['column']!=0)
{
  $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE  ,ID_ASSURANCE_PEINE DESC';
}

$search = !empty($_POST['search']['value']) ? (" AND (NUMERO_PLAQUE LIKE '%$var_search%'  ) ") : '';


 $critaire=" AND ID_ASSURANCE_PEINE=".$ab;
 $group_by="GROUP BY AMENDES,ID_ASSURANCE_PEINE,NUMERO_PLAQUE,DATE_INSERTION";


$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$group_by.' '.$order_by.'   '.$limit;
$query_filter=$query_principal.' '.$critaire.''.$search.' '.$group_by;



$fetch_data = $this->Modele->datatable($query_secondaire);
$u=0;
$data = array();
foreach ($fetch_data as $row)  
{

  $u++;
  $intrant=array();
  $intrant[] = $u;
  $intrant[] =$row->NUMERO_PLAQUE;
  $intrant[] =$row->AMENDES;
  $intrant[] =$row->DATE;
  
  
 

  $data[] = $intrant;
}
//print_r($data[0]);exit();
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
