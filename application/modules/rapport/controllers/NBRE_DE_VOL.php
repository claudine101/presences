<?php
class NBRE_DE_VOL extends CI_Controller
{

function index()
{

   $date_insert=$this->input->post('date_insert');
   // print_r($date_insert);//exit();
    $condition='';
    $condition1='';
    if(!empty($date_insert)) {
      $condition .=  'and date_format(s.DATE_INSERTION,"%d-%m-%Y")="'.$date_insert.'"';
    }


    $statu=$this->input->post('STATUT');
    //var_dump($statu);


    
    if($statu!=null) {
      $condition1 =  ' and STATUT='.$statu;
    }

   
 $validation=$this->Modele->getRequete('SELECT `VALIDATION` as ID,COUNT(s.VALIDATION) as NBRE ,IF(VALIDATION=1,"valide","non valide") as VALIDATION FROM sign_tampo_pj s LEFT JOIN obr_immatriculations_voitures o on s.ID_OBR=o.ID_IMMATRICULATION WHERE 1 '.$condition.' GROUP BY s.VALIDATION');

//print_r($validation);exit();
$statut=$this->Modele->getRequete('SELECT STATUT as id,COUNT(s.STATUT) as Nbre ,IF(STATUT=1,"trouve","non trouve") as Stat FROM sign_tampo_pj s LEFT JOIN obr_immatriculations_voitures o on s.ID_OBR=o.ID_IMMATRICULATION WHERE 1 '.$condition1.' GROUP BY s.STATUT');   

  
 $nombre1=0;
 $donne1="";
 $nombre=0;
 $donne="";

 foreach ($validation as $value) 
 {
 
 $nombre+=$value['NBRE'];
 $name = (!empty($value['VALIDATION'])) ? $value['VALIDATION'] : "Aucun";
 $nb = (!empty($value['NBRE'])) ? $value['NBRE'] : "0" ;


 $key_id=($value['ID']>0) ? $value['ID'] : "0" ;
 $donne.="{name:'".str_replace("'","\'",$name)."', y:".$nb.",key:'".$key_id."'},";

 }

  foreach ($statut as $value) 
 {

   $nombre1+=$value['Nbre'];
   $name= (!empty($value['Stat'])) ? $value['Stat'] : "Aucun";
   $nb=(!empty($value['Nbre'])) ? $value['Nbre']: "0";
   
   $key_id=($value['id']>0) ? $value['id'] : "0" ;
   $donne1.="{name:'".str_replace("'","\'",$name)."', y:".$nb.",key:'".$key_id."'},";
    // print_r($donne1);exit();
 }
  

 $data['title']="DECLARATION DE VOL";
 $data['donne']=$donne;
 $data['donne1']=$donne1;
 $data['nombre1']=$nombre1;
 $data['nombre']=$nombre;


 $date=$this->Modele->getRequete('SELECT date_format(`DATE_INSERTION`,"%d-%m-%Y") as date_insert FROM sign_tampo_pj WHERE 1 GROUP BY date_format(`DATE_INSERTION`,"%d-%m-%Y")');

$stat=$this->Modele->getRequete('SELECT STATUT,IF(STATUT=1,"trouve","non trouve") as Statut FROM `sign_tampo_pj` WHERE 1 GROUP BY STATUT');


 $data['statut']=$stat;
 $data['date']=$date;



 $data=$this->load->view('NBRE_DE_VOL_V',$data);

   }


 function detailVal()
 {
  $KEY=$this->input->post('key');
    $date_insert=$this->input->post('date_insert');
   // print_r($date_insert);//exit();
    $condition='';
    if(!empty($date_insert)) {
      $condition .=  ' and date_format(s.DATE_INSERTION,"%d-%m-%Y")="'.$date_insert.'"';
    }

  $break=explode(".",$KEY);
  $ID=$KEY;
 // print_r($ID);exit();

  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

   $query_principal=('SELECT `ID_TAMPO_PJ`,s.DATE_INSERTION,c.COULEUR, o.NUMERO_PLAQUE,concat(o.NOM_PROPRIETAIRE," ",o.NOM_PROPRIETAIRE) as NOM,s.VALIDATION,`NUMERO_SERIE`,`DATE_VOLER`, IF(VALIDATION=1,"valide","non valide") as VALIDATION FROM sign_tampo_pj s  LEFT JOIN obr_immatriculations_voitures o on s.ID_OBR=o.ID_IMMATRICULATION LEFT JOIN type_couleur c on s.ID_COULEUR=c.ID_TYPE_COULEUR WHERE 1 '.$condition.' AND s.VALIDATION='.$ID);


   $limit='LIMIT 0,10';
    if($_POST['length'] != -1)
  {
  $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
  }

   $order_by='';
   if($_POST['order']['0']['column']!=0)
   	{
  $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY VALIDATION   DESC';
   }
    
  $search = !empty($_POST['search']['value']) ? (" AND (VALIDATION LIKE '%$var_search%') ") : '';


  $query_secondaire=$query_principal.' '.$search.' '.$order_by.'   '.$limit;
  $query_filter=$query_principal.' '.$search;


  $fetch_data = $this->Modele->datatable($query_secondaire);
  $u=0;
  $data = array();
   foreach ($fetch_data as $row)  
{

  $u++;
  $intrant=array();
  $intrant[] = $u;
  $intrant[] =$row->DATE_INSERTION;
  $intrant[] =$row->COULEUR;
  $intrant[] =$row->NUMERO_PLAQUE;
  $intrant[] =$row->NOM;
  $intrant[] =$row->VALIDATION;
  $intrant[] =$row->NUMERO_SERIE;
  $intrant[] =$row->DATE_VOLER;
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

  function detailStatut()
  {
  	$KEY=$this->input->post('key');

  	// $statut=$this->input->post('statut');

  	// $condition1='';
   // if(!empty($statut)) {
   //    $condition1.=  'and STATUT= "'.$statut.'"';
   //  }
  	$break=explode(".",$KEY);
    $id=$KEY;


  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

  $query_principal=('SELECT STATUT,`ID_TAMPO_PJ`,s.DATE_INSERTION,c.COULEUR, o.NUMERO_PLAQUE,concat(o.NOM_PROPRIETAIRE," ",o.NOM_PROPRIETAIRE) as NOM,`NUMERO_SERIE`,`DATE_VOLER`, IF(STATUT=1,"trouve","non trouve") as STATUT FROM sign_tampo_pj s LEFT JOIN obr_immatriculations_voitures o on s.ID_OBR=o.ID_IMMATRICULATION LEFT JOIN type_couleur c on s.ID_COULEUR=c.ID_TYPE_COULEUR WHERE 1  AND s.STATUT='.$id);


    $limit='LIMIT 0,10';
   	 if($_POST['length'] != -1)
     {
    $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
    }

    $order_by='';

      if($_POST['order']['0']['column']!=0)
   {
   $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE  DESC';
   }
   
   $search = !empty($_POST['search']['value']) ? (" AND (NUMERO_PLAQUE LIKE '%$var_search%')") : '';
    

   $query_secondaire=$query_principal.' '.$search.' '.$order_by.'   '.$limit;
   $query_filter=$query_principal.' '.$search;


   $fetch_data = $this->Modele->datatable($query_secondaire);
   $u=1;
   $data = array();


   foreach ($fetch_data as $row)
  {


  $intrant=array();
  $intrant[] = $u++;
  $intrant[] =$row->STATUT;
  $intrant[] =$row->DATE_INSERTION;
  $intrant[] =$row->COULEUR;
  $intrant[] =$row->NUMERO_PLAQUE;
  $intrant[] =$row->NOM;
  $intrant[] =$row->NUMERO_SERIE;
  $intrant[] =$row->DATE_VOLER;
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