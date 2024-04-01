<?php

class Acc_Par_Chaussee extends CI_Controller
{

  function index()
  {
    $date_insert=$this->input->post('date_insert');
   // print_r($date_insert);//exit();
    $condition='';
    if(!empty($date_insert)) {
      $condition .=  ' and date_format(`DATE_INSERTION`,"%d-%m-%Y")="'.$date_insert.'"';
    }

    $gravite=$this->input->post('ID_TYPE_GRAVITE');

    if(!empty($gravite)) {
      $condition .=  ' and ID_GRAVITE="'.$gravite.'"';
    }

    //print_r($condition);
  	$i=1;
  	$Chaussee=$this->Modele->getRequete("SELECT c.ID_CHAUSSEE as ID,COUNT(acc.ID_SIGN_ACCIDENT) as NBRE,c.NOM_CHAUSSE as CHAUSSE FROM sign_accident acc left JOIN chaussee c on acc.ID_CHAUSSEE=c.ID_CHAUSSEE WHERE 1  ".$condition."  GROUP BY  CHAUSSE");

  	$nombre=0;
  	$donne="";



  	foreach ($Chaussee as $value) 
  	{
  	   $nombre=$nombre+$value['NBRE'];
  	   $name= (!empty($value['CHAUSSE'])) ? $value['CHAUSSE']: "Aucun";
  	   $nb= (!empty($value['NBRE'])) ? $value['NBRE']: "0";



  	   $key_id=($value['ID']>0) ? $value['ID'] : "0" ;
  	   $donne.="{name:'".str_replace("'","\'",$name)."', y:".$nb.",key:".$key_id."},";
  	}
  
  	
  	$data['title']="Rapport sur les nombres d'accidents par Chaussee";
  	$data['donne']=$donne;
  	$data['nombre']=$nombre;


    $gravite=$this->Modele->getRequete('SELECT `ID_TYPE_GRAVITE` ,`DESCRIPTION` as gravite FROM `type_gravite` WHERE 1 order by DESCRIPTION');

  	
    $date=$this->Modele->getRequete('SELECT date_format(`DATE_INSERTION`,"%d-%m-%Y") as date_insert FROM `sign_accident` WHERE 1 GROUP BY date_format(`DATE_INSERTION`,"%d-%m-%Y")');


    $data['gravite']=$gravite; 
    $data['date']=$date;

    
    $data=$this->load->view('Acc_Par_Chaussee_V',$data);

   }


   function detailChausse()
   {
   	
   $KEY=$this->input->post('key');

   $gravite=$this->input->post('gravite');

   $condition='';
   if(!empty($gravite)) {
      $condition .=  ' and a.ID_GRAVITE="'.$gravite.'"';
    }


   	$break=explode(".", $KEY);
   	$ID=$KEY;

   	$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

   	$query_principal=('SELECT c.NOM_CHAUSSE,`PLAQUE`,If(VALIDATION=1,"valide","invalide") as VALIDATION, a.DESCRIPTION , c.NOM_CHAUSSE,a.LONGITUDE, a.LATITUDE, `DATE_INSERTION`,g.DESCRIPTION as GRAVITE FROM sign_accident a JOIN chaussee c on a.ID_CHAUSSEE=c.ID_CHAUSSEE join type_gravite g on g.ID_TYPE_GRAVITE=a.ID_GRAVITE WHERE 1 '.$condition.'  and c.ID_CHAUSSEE='.$ID);


   	$limit='LIMIT 0,10';
   	 if($_POST['length'] != -1)
  {
  $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
  }

  $order_by='';

    if($_POST['order']['0']['column']!=0)
 {
  $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY PLAQUE  DESC';
 }
   
  $search = !empty($_POST['search']['value']) ? (" AND (PLAQUE LIKE '%$var_search%' OR  DATE LIKE '%$var_search%'  ) ") : '';

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
  $intrant[] =$row->NOM_CHAUSSE;
  $intrant[] =$row->PLAQUE;
  $intrant[] =$row->GRAVITE;
  $intrant[] =$row->VALIDATION;
  $intrant[] =$row->DESCRIPTION;
  $intrant[] =$row->DATE_INSERTION;

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
