

<?php

class Dashboard_embouteillage extends CI_Controller
{

  function index()
  {
  	$i=1;
    $date=$this->input->post('date');
    $val=$this->input->post('VALIDATION');

    $conditon=''; 
    $conditon1='';
    $conditon= !empty($date) ? " AND DATE_FORMAT(sa.DATE_INSERTION, '%d-%m-%Y')='".$date."'" : "";
    $conditon1= !empty($val) ? " AND VALIDATION =".$val : "";
    
  	$Chaussee=$this->Modele->getRequete("SELECT sa.ID_AMBOUTEILLAGE as ID , COUNT(sa.ID_AMBOUTEILLAGE) AS Nbre, sa.ID_CHAUSSEE,c.NOM_CHAUSSE,sa.VALIDATION,sa.DATE_INSERTION FROM sign_ambouteillage sa LEFT JOIN chaussee c ON c.ID_CHAUSSEE=sa.ID_CHAUSSEE WHERE 1 ".$conditon." ".$conditon1." GROUP BY NOM_CHAUSSE,sa.ID_AMBOUTEILLAGE");

  	$nombre=0;
  	$donne="";



  	foreach ($Chaussee as $value) 
  	{
  	   $nombre+=$value['Nbre'];
  	   $name= (!empty($value['NOM_CHAUSSE'])) ? $value['NOM_CHAUSSE']: "Aucun";
  	   $nb= (!empty($value['Nbre'])) ? $value['Nbre']: "0";



  	   $key_id=($value['ID']>0) ? $value['ID'] : "0" ;
  	   $donne.="{name:'".str_replace("'","\'",$name)."', y:".$nb.",key:".$key_id."},";
  	}
  
  	//print_r($donne);exit();
  	$data['title']="Rapport sur les embouteillage par Chaussée";
  	$data['donne']=$donne;
  	$data['nombre']=$nombre;

    $date=$this->Modele->getRequete('SELECT date_format(DATE_INSERTION,"%d-%m-%Y") as date FROM sign_ambouteillage WHERE 1 GROUP BY date_format(DATE_INSERTION,"%d-%m-%Y")');
    $validate=$this->Modele->getRequete('SELECT VALIDATION,If(VALIDATION=1,"valide","invalide") as VALi FROM sign_ambouteillage WHERE 1 GROUP BY VALIDATION');


    $data['date']=$date;
    $data['validate']=$validate;

    
    $data=$this->load->view('dash_embouteillage_v',$data);

   }


   function detailChausse()
   {
   	$KEY=$this->input->post('key');
   	$break=explode(".", $KEY);
   	$ID=$KEY;

   	$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

   	$query_principal=('SELECT ID_AMBOUTEILLAGE, sa.ID_CHAUSSEE,c.NOM_CHAUSSE, CAUSE, IMAGE_1, IMAGE_2, IMAGE_3,If(VALIDATION=1,"valide","invalide") as VALIDATION, sa.LONGITUDE, sa.LATITUDE, USER_ID,DATE_FORMAT(DATE_INSERTION, "%d-%m-%Y") AS DATEV FROM sign_ambouteillage sa LEFT JOIN chaussee c ON c.ID_CHAUSSEE=sa.ID_CHAUSSEE WHERE 1 AND ID_AMBOUTEILLAGE='.$ID);


   	$limit='LIMIT 0,10';
   	 if($_POST['length'] != -1)
  {
  $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
  }

  $order_by='';

    if($_POST['order']['0']['column']!=0)
 {
  $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY CAUSE  DESC';
 }
   
  $search = !empty($_POST['search']['value']) ? (" AND (NOM_CHAUSSE LIKE '%$var_search%' OR  DATEV LIKE '%$var_search%'  ) ") : '';

  $query_secondaire=$query_principal.' '.$search.' '.$order_by.'   '.$limit;
  $query_filter=$query_principal.' '.$search;


  $fetch_data = $this->Modele->datatable($query_secondaire);
  $u=0;
  $data = array();
  foreach ($fetch_data as $row)
  {

  $u++;
  $intrant=array();
  $intrant[] = $u++;
  $intrant[] =$row->NOM_CHAUSSE;
  $intrant[] =$row->VALIDATION;
  $intrant[] =$row->CAUSE;
  $intrant[] =$row->DATEV;

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

 function getRapport(){

 }

 }
 ?>