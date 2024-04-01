<?php
class Montant_Payer_Par_Date extends CI_Controller
{


function index()
{

$i=1;
$montant=$this->Modele->getRequete('SELECT   date_format(h.DATE_INSERTION,"%d-%m-%Y") as DATE,sum(h.MONTANT) as NBRE FROM historiques h WHERE 1 and IS_PAID=1 GROUP BY date_format(h.DATE_INSERTION,"%d-%m-%Y")');


$montant_not_paid=$this->Modele->getRequete('SELECT   date_format(h.DATE_INSERTION,"%d-%m-%Y") as DATE,sum(h.MONTANT) as NBR FROM historiques h WHERE 1 and IS_PAID=0 GROUP BY date_format(h.DATE_INSERTION,"%d-%m-%Y")');



  $nombre1=0;
  $donnee1="";
  $nombre=0;
  $donnee="";


  foreach ($montant_not_paid as $value) 
  {
  	$nombre1+=$value['NBR'];
  	$name=(!empty(['DATE'])) ? $value['DATE']: "Aucun";
  	$nb=(!empty(['NBR'])) ? $value['NBR']: "0";



  	$key_id=(!empty($value['DATE'])) ? str_replace("-", "", $value['DATE']) : "0" ;
    $donnee1.="{name:'".str_replace("'","\'",$name)."', y:".$nb.",key:".$key_id."},";
  }





   foreach ($montant as $value)
   {
     $nombre+=$value['NBRE'];
     $name=(!empty($value['DATE'])) ? $value['DATE']: "Aucun";
     $nb= (!empty($value['NBRE'])) ? $value['NBRE']: "0";


      $key_id=(!empty($value['DATE'])) ? str_replace("-", "", $value['DATE']) : "0" ;
      $donnee.="{name:'".str_replace("'","\'",$name)."', y:".$nb.",key:".$key_id."},";
   }

   $data['title']="Rapport sur les montant par date";
   $data['nombre1']=$nombre1;
   $data['donnee1']=$donnee1;

   $data['nombre']=$nombre;
   $data['donnee']=$donnee;



   $data=$this->load->view('Montant_Payer_Par_Date_V.php',$data);


}

 function detailMontant()
 {
  
  $KEY=$this->input->post('key');
  $break=explode(".",$KEY);
  $ID=$KEY;


  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

  $query_principal="SELECT `ID_HISTORIQUE`, `NUMERO_PLAQUE`, `NUMERO_PERMIS`, `MONTANT`,if(IS_PAID=1,'Paid','Not paid') as IS_PAID, `DATE_INSERTION` FROM `historiques` WHERE 1 and date_format(DATE_INSERTION,'%d%m%Y') ='".$ID."'";

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


   $search = !empty($_POST['search']['value']) ? (" AND (NUMERO_PLAQUE LIKE '%$var_search%' OR  DATE_INSERTION LIKE '%$var_search%'  ) ") : '';


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
  $intrant[] =$row->NUMERO_PLAQUE;
  //$intrant[] =$row->NUMERO_PERMIS;
  $intrant[] =$row->MONTANT;
  $intrant[] =$row->IS_PAID;
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
  
  function detailNotPaid()
  {

  $KEY=$this->input->post('key');
  $break=explode(".",$KEY);
  $ID=$KEY;


  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

  $query_principal="SELECT `ID_HISTORIQUE`, `NUMERO_PLAQUE`, `NUMERO_PERMIS`, `MONTANT`,if(IS_PAID=1,'Paid','Not paid') as IS_PAID, `DATE_INSERTION` FROM `historiques` WHERE 1 and date_format(DATE_INSERTION,'%d%m%Y') ='".$ID."'";

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


   $search = !empty($_POST['search']['value']) ? (" AND (NUMERO_PLAQUE LIKE '%$var_search%' OR  DATE_INSERTION LIKE '%$var_search%'  ) ") : '';


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
  $intrant[] =$row->NUMERO_PLAQUE;
  $intrant[] =$row->NUMERO_PERMIS;
  $intrant[] =$row->MONTANT;
  $intrant[] =$row->IS_PAID;
  //$intrant[] =$row->DATE_INSERTION;
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