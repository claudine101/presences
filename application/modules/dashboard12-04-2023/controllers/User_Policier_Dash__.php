<?php
class User_Policier_Dash extends CI_Controller
{

   function index()
    {
  
//requete pour retourner les voitures dont le controle technique expire par rapport à la date actuelle 


      $requete=$this->Modele->getRequete('SELECT COUNT(ID_UTILISATEUR)AS nombre,u.DATE_INSERTION,pg.GRADE FROM `utilisateurs` u LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID LEFT JOIN psr_grade pg ON pg.ID_GRADE=pe.ID_GRADE WHERE PROFIL_ID=6 AND u.IS_ACTIF=1 GROUP BY pg.GRADE,u.DATE_INSERTION');


      $requete1=$this->Modele->getRequete('SELECT COUNT(ID_UTILISATEUR)AS nombre,pg.ID_GRADE AS ID,u.DATE_INSERTION FROM `utilisateurs` u LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID LEFT JOIN psr_grade pg ON pg.ID_GRADE=pe.ID_GRADE WHERE PROFIL_ID=6 AND u.IS_ACTIF=1 GROUP BY pg.ID_GRADE,u.DATE_INSERTION');



     
 $nombre=0;
 
 $donnees="";
 $nombre1=0;
 
 $donnees1="";

 //$categorie1='';
 foreach ($requete as  $value) {
  
  $nombre=$nombre+$value['nombre'];
  
 
  $name=(!empty($value['GRADE']))? $value['GRADE']:'aucun enregistrement';
  $nbre=(!empty($value['nombre']))? $value['nombre']:'0';




  $donnees.="{name:'".str_replace("'","\'",$name)."', y:".$nbre."},";
 }

 foreach ($requete1 as  $value) {
  
  $nombre1=$nombre1+$value['nombre'];
  
 
  $name=(!empty($value['DATE_INSERTION']))? $value['DATE_INSERTION']:'aucun enregistrement';
  $nbre=(!empty($value['nombre']))? $value['nombre']:'0';

     $key_id=($value['DATE_INSERTION']>0) ? $value['DATE_INSERTION'] : "0" ;


  $donnees1.="{name:'".str_replace("'","\'",$name)."', y:".$nbre.",key:'".$key_id."'},";
 }


    
    $data['title']='Statut des Officiers connectés ';
    $data['donnees']=$donnees;
    $data['nom']=$nombre;
     $data['donnees1']=$donnees1;
    $data['nom1']=$nombre1;
    // $data['name']=$name;


$this->load->view('User_Policier_View',$data);

}

function detailUsers(){

     $KEY=$this->input->post('key');
  $break=explode(".",$KEY);
  $ab=$KEY;
$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

$query_principal='SELECT ID_UTILISATEUR ,pg.ID_GRADE,CONCAT(pe.NOM," ",pe.PRENOM) AS NAME,u.DATE_INSERTION ,pg.GRADE FROM `utilisateurs` u LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID LEFT JOIN psr_grade pg ON pg.ID_GRADE=pe.ID_GRADE WHERE PROFIL_ID=6 AND u.IS_ACTIF=1';

$limit='LIMIT 0,10';
if($_POST['length'] != -1)
{
  $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
}
$order_by='';
if($_POST['order']['0']['column']!=0)
{
  $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NAME  DESC';
}

$search = !empty($_POST['search']['value']) ? (" AND (NAME LIKE '%$var_search%') ") : '';


$critaire="AND u.DATE_INSERTION=".$ab;
 //$group_by="GROUP BY ID_UTILISATEUR";

$query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
$query_filter=$query_principal.'  '.$critaire.' '.$search;



$fetch_data = $this->Modele->datatable($query_secondaire);
$u=0;
$data = array();
foreach ($fetch_data as $row)  
{



  $u++;
  $intrant=array();
  $intrant[] = $u;
  $intrant[] =$row->NAME;
  $intrant[] =$row->DATE_INSERTION;
  $intrant[] =$row->GRADE;    

 

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