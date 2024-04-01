<?php

class Nombre_De_Commande_Par_Statut extends CI_Controller
 {

 function index ()
 {
 
 $criteres="";

 $statut=$this->Modele->getRequete("SELECT k.ID_STATUS_COMMANDE as ID, DESCRIPTION as STATUS, COUNT(k.ID_COMMANDE) as NBRE FROM commandes k JOIN commande_status mr on mr.ID_STATUS_COMMANDE=k.ID_STATUS_COMMANDE WHERE 1 ".$criteres." GROUP BY k.ID_STATUS_COMMANDE");

 $nombre2=0;
 $donnee="";
 

 foreach ($statut as $value) 
 {
 $nombre2=$nombre2+$value['NBRE'];
 $name = (!empty($value['STATUS'])) ? $value['STATUS'] : "Aucun" ;
 $nb = (!empty($value['NBRE'])) ? $value['NBRE'] : "0" ;


 $key_id=($value['ID']>0) ? $value['ID'] : "0" ;
 $donnee.="{name:'".str_replace("'","\'",$name)."', low:".$nb.",key:'".$key_id."'},";

 }
 //print_r($nombre2);exit();

 $data['title']='Rapport sur les Commande par Statut';
 $data['donnee']=$donnee;
 $data['nombre2']=$nombre2;
 

 $this->load->view('Nombre_De_Commande_Par_Statut_View',$data);

 }

   function statutDetail()

 {
  
  $KEY=$this->input->post('key');
  $break=explode(".",$KEY);
  $ID=$KEY;

  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

  $query_principal=("SELECT `NOM_LIVRAISON`,`PRENOM_LIVRAISON` FROM `commandes` WHERE 1 and `ID_STATUS_COMMANDE`=".$ID."");


  $limit='LIMIT 0,10';
  if($_POST['length'] != -1)
{
  $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
}
  $order_by='';
  if($_POST['order']['0']['column']!=0)
{
  $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY DESCRIPTION   DESC';
}

  $search = !empty($_POST['search']['value']) ? (" AND (DESCRIPTION LIKE '%$var_search%' OR  DATE LIKE '%$var_search%'  ) ") : '';


  $critaire="";


  $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
  $query_filter=$query_principal.' '.$critaire.''.$search;



  $fetch_data = $this->Modele->datatable($query_secondaire);
  $u=0;
  $data = array();
  foreach ($fetch_data as $row)  
{

  $u++;
  $intrant=array();
  $intrant[] = $u;
  $intrant[] =$row->NOM_LIVRAISON;
  $intrant[] =$row->PRENOM_LIVRAISON;
  // $intrant[] =$row->MONTANT;

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