<?php

 // Police judiciaire

class Pj_declarations extends CI_Controller
  {    
    function index()
  {
   
   $requete2=$this->Modele->getRequete("SELECT `ID_DECLARATION` as ID,STATUT,COUNT(`ID_DECLARATION`) as NBR FROM `pj_declarations` WHERE  `ID_DECLARATION` GROUP BY STATUT,ID_DECLARATION");


   $requete3=$this->Modele->getRequete("SELECT `ID_DECLARATION` as id,`DATE_VOLER`,COUNT(`ID_DECLARATION`) as nbr FROM `pj_declarations` WHERE 1 GROUP BY `DATE_VOLER`,ID_DECLARATION");

   $nombre2=0;
   $donnees2="";
   $nombre3=0;
   $donnees3="";


   foreach ($requete2 as $value) 
   {
  $nombre2=$nombre2+$value['NBR'];
  $name = (($value['STATUT'])==0) ? "volé" : "trouvé" ;
  $name = str_replace("\n","",$name);
  $name = str_replace("\r","",$name);
  $name = str_replace("\t","",$name);
  $nb = (!empty($value['NBR'])) ? $value['NBR'] : "0" ;
   
  $key_id=(($value['STATUT'])==0) ? "vole" : "trouve";
  $donnees2.="{name:'".str_replace("'","\'",$name)."', low:".$nb.",key:'".$key_id."'},";
   }


   foreach ($requete3 as $value)
   {
  $nombre3=$nombre3+$value['nbr'];
  $name = (!empty($value['DATE_VOLER'])) ? $value['DATE_VOLER'] : "Aucun" ;

  $name = str_replace("\n","",$name);
  $name = str_replace("\r","",$name);
  $name = str_replace("\t","",$name);
  $nb = (!empty($value['nbr'])) ? $value['nbr'] : "0" ;
   
  $key_id= $value['DATE_VOLER'];
  $donnees3.="{name:'".str_replace("'","\'",$name)."', low:".$nb.",key:'".$key_id."'},";
   }

  

  $data['title']='Espace de suivi ';


  $data['donnees2']=$donnees2;
  $data['nombre2']=$nombre2;

  $data['donnees3']=$donnees3;
  $data['nombre3']=$nombre3;


  $this->load->view('pj_declarations_view',$data);
  }

  //POLICE JUDICIARE NOMBRE DE VOITURE ENREGISTRER

  function detailVolee()
  {
  	$KEY=$this->input->post('key');
    $break=explode(".", $KEY);
    $ab=$KEY;


    $query_principal="SELECT * FROM `pj_declarations` WHERE STATUT = 0";


    $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $limit='LIMIT 0,10';


    if($_POST['length'] != -1){
    $limit='LIMIT '.$_POST["start"].','.$_POST["length"];

    }

    $order_by='';

    $order_column=array('ID_DECLARATION','NUMERO_PLAQUE','NOM_DECLARANT','PRENOM_DECLARANT','COULEUR_VOITURE','MARQUE_VOITURE');

    $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY STATUT ASC';

    $search = !empty($_POST['search']['value']) ? "AND (NUMERO_PLAQUE LIKE '%$var_search%' OR NOM_DECLARANT LIKE '%$var_search%' )":''; 


    $critaire="WHERE NUMERO_PLAQUE = ".$ab;
    $group_by="";


    $critaire = '';

    $query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$group_by.'  '.$order_by.'   '.$limit;
    $query_filter = $query_principal.' '.$critaire.' '.$search;




   $fetch_data = $this->Modele->datatable($query_secondaire);
   $u=0;
   $data = array();
   foreach ($fetch_data as $row)  
   {

   $u++;
   $intrant=array();
   $intrant[] = $u;                              
   $intrant[] =$row->NOM_DECLARANT;
   $intrant[] =$row->NUMERO_PLAQUE;
   $intrant[] =$row->PRENOM_DECLARANT;
   $intrant[] =$row->COULEUR_VOITURE;
   $intrant[] =$row->MARQUE_VOITURE;
   
  
  

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

function detailTrouve()
  {
    $KEY=$this->input->post('key');
    $break=explode(".", $KEY);
    $ab=$KEY;


    $query_principal="SELECT * FROM `pj_declarations` WHERE STATUT = 1";


    $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $limit='LIMIT 0,10';


    if($_POST['length'] != -1){
    $limit='LIMIT '.$_POST["start"].','.$_POST["length"];

    }

    $order_by='';

    $order_column=array('ID_DECLARATION ','NUMERO_PLAQUE','NOM_DECLARANT','PRENOM_DECLARANT','COULEUR_VOITURE','MARQUE_VOITURE');

    $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE ASC';

    $search = !empty($_POST['search']['value']) ? "AND (NUMERO_PLAQUE LIKE '%$var_search%' OR NOM_DECLARANT LIKE '%$var_search%' )":''; 


    $critaire="WHERE NUMERO_PLAQUE = ".$ab;
    $group_by="";


    $critaire = '';

    $query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$group_by.'  '.$order_by.'   '.$limit;
    $query_filter = $query_principal.' '.$critaire.' '.$search;




   $fetch_data = $this->Modele->datatable($query_secondaire);
   $u=0;
   $data = array();
   foreach ($fetch_data as $row)  
   {

   $u++;
   $intrant=array();
   $intrant[] = $u;
   $intrant[] =$row->NUMERO_PLAQUE;
   $intrant[] =$row->NOM_DECLARANT;
   $intrant[] =$row->PRENOM_DECLARANT;
   $intrant[] =$row->COULEUR_VOITURE;
   $intrant[] =$row->MARQUE_VOITURE;
   
  
  

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






   //POLICE JUDICIARE DATE D'ENREGISTREMENT

    function detailEnregistrement()
    {
    $date=$this->input->post('key');

    $query_principal="SELECT * FROM pj_declarations WHERE DATE_VOLER = '$date'";


    $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $limit='LIMIT 0,10';


    if($_POST['length'] != -1){
    $limit='LIMIT '.$_POST["start"].','.$_POST["length"];

    }

    $order_by='';

    $order_column=array('ID_DECLARATION','NUMERO_PLAQUE','NOM_DECLARANT','PRENOM_DECLARANT','COULEUR_VOITURE','MARQUE_VOITURE','DATE_VOLER');

    $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY DATE_VOLER ASC';

    $search = !empty($_POST['search']['value']) ? "(AND DATE_VOLER LIKE '%$var_search%' )":''; 


    $critaire="";
    $group_by="";


    $critaire = '';

    $query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$group_by.'  '.$order_by.'   '.$limit;
    $query_filter = $query_principal.' '.$critaire.' '.$search;

   $fetch_data = $this->Modele->datatable($query_secondaire);
   $u=0;
   $data = array();
   foreach ($fetch_data as $row)  
   {

   $u++;
   $intrant=array();
   $intrant[] = $u;
   $intrant[] =$row->NUMERO_PLAQUE;
   $intrant[] =$row->ID_DECLARATION;
   $intrant[] =$row->PRENOM_DECLARANT;
   $intrant[] =$row->COULEUR_VOITURE;
   $intrant[] =$row->MARQUE_VOITURE;
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