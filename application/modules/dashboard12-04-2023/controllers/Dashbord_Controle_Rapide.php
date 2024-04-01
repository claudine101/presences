
<?php
 /// EDMOND :dashboard des grobal
class Dashbord_Controle_Rapide extends CI_Controller
      {
function index(){

$dattes=$this->Model->getRequete("SELECT DISTINCT date_format(historiques.DATE_INSERTION,'%Y') AS mois FROM historiques WHERE RAISON_ANNULATION IS NULL ORDER BY  mois ASC");

//$paid=$this->Model->getRequete('SELECT DISTINCT IS_PAID,if(IS_PAID=0, "Est payé", " Pas encore payé") AS NOM FROM historiques  WHERE RAISON_ANNULATION IS NULL');
$categorie=$this->Model->getRequete('SELECT ID_CATEGORIE,DESCRIPTION FROM `historiques_categories` WHERE 1');     
$data['dattes']=$dattes;
//$data['paid']=$paid;
$data['categorie']=$categorie;
$this->load->view('Dashboard_Controle_Rapide_View',$data);
     }

    
function detail()
    {
  $mois=$this->input->post('mois');
  $jour=$this->input->post('jour');
  $heure=$this->input->post('heure');
$NUMERO_PLAQUE=$this->input->post('NUMERO_PLAQUE');
$NUMERO_PERMIS=$this->input->post('NUMERO_PERMIS');
$IS_PAID=$this->input->post('IS_PAID');
$ID_CATEGORIE=$this->input->post('ID_CATEGORIE');

 $KEY=$this->input->post('key');
 $KEY2=$this->input->post('key2');
$break=explode(".",$KEY2);
$ID=$KEY2;
$criteres1="";
$cripaid="";
$categorie="";
$plaque='';
 $search='';
        
$criteres_date="";

        
if(!empty($mois)){

$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y')='".$mois."'"; 
        }

if(!empty($jour)){

$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y-%m')='".$jour."'";
        }
  if(!empty($heure)){
     
$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y-%m-%d')= '".$heure."'  ";
    
         }

if ($IS_PAID != ''){
   $cripaid.="  AND  h.IS_PAID=".$IS_PAID;
     
 }
 if (!empty($ID_CATEGORIE)){
   $categorie.="  AND  h.ID_HISTORIQUE_CATEGORIE=".$ID_CATEGORIE;
     
 }


 if (!empty($NUMERO_PLAQUE)) {
   $search=' and h.NUMERO_PLAQUE like "%'.$NUMERO_PLAQUE.'%"'; 
 }

 if (!empty($NUMERO_PERMIS)) {
   $plaque=' and h.NUMERO_PERMIS like "%'.$NUMERO_PERMIS.'%"'; 
 }



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     
$query_principal=" ";

 if (!empty($KEY)) {
  $query_principal=" SELECT  e.ID_PSR_ELEMENT,h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,h.DATE_INSERTION,p.MONTANT FROM `historiques` h LEFT JOIN infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_ASSURANCE_PEINE LEFT JOIN infra_peines p ON p.ID_INFRA_INFRACTION=i.ID_INFRA_INFRACTION LEFT JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR LEFT JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT  WHERE RAISON_ANNULATION IS NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1  ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie." ";
        }else{
      $query_principal=" SELECT  e.ID_PSR_ELEMENT,h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,h.DATE_INSERTION,p.MONTANT FROM `historiques` h LEFT JOIN infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_ASSURANCE_PEINE LEFT JOIN infra_peines p ON p.ID_INFRA_INFRACTION=i.ID_INFRA_INFRACTION LEFT JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR LEFT JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT  WHERE RAISON_ANNULATION IS NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie."  ";   
        }



        $limit='LIMIT 0,10';
        if($_POST['length'] != -1)
        {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $order_by='';
        if($_POST['order']['0']['column']!=0)
        {
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE  ASC'; 
        }

        $search = !empty($_POST['search']['value']) ? ("AND (h.NUMERO_PLAQUE LIKE '%$var_search%'  OR h.NUMERO_PERMIS LIKE '%$var_search%' OR e.NOM LIKE '%$var_search%' OR e.PRENOM LIKE '%$var_search%' OR e.NUMERO_MATRICULE LIKE '%$var_search%' OR af.LIEU_EXACTE LIKE '%$var_search%' OR h.DATE_INSERTION LIKE '%$var_search%' ) ") : '';   
        if (!empty($KEY)) {
         $critaire=' AND h.ID_ASSURANCE_PEINE='.$KEY;
        }else{
         $critaire=' AND h.ID_ASSURANCE_PEINE IS NULL ';   
        }
        

    
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {
$lieu='';
$affid=$this->Model->getRequeteOne(" SELECT PSR_AFFECTATION_ID FROM psr_element_affectation WHERE ID_PSR_ELEMENT=".$row->ID_PSR_ELEMENT."  ");
if (!empty($affid['PSR_AFFECTATION_ID'])) {
$affecta=$this->Model->getRequeteOne(" SELECT LIEU_EXACTE FROM psr_affectatations WHERE PSR_AFFECTATION_ID=".$affid['PSR_AFFECTATION_ID']."  ");
$lieu=$affecta['LIEU_EXACTE']; 
}else{
$lieu='';
}

    
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_PERMIS;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$lieu;
         $intrant[] =$row->MONTANT;
         $intrant[] =$row->DATE_INSERTION;
         $data[] = $intrant;
          }

        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" =>$this->Model->all_data($query_principal),
            "recordsFiltered" => $this->Model->filtrer($query_filter),
            "data" => $data
        );

        echo json_encode($output);
    }
    function detail1()
    {
    
  $mois=$this->input->post('mois');
  $jour=$this->input->post('jour');
  $heure=$this->input->post('heure');
$NUMERO_PLAQUE=$this->input->post('NUMERO_PLAQUE');
$NUMERO_PERMIS=$this->input->post('NUMERO_PERMIS');
$IS_PAID=$this->input->post('IS_PAID');
$ID_CATEGORIE=$this->input->post('ID_CATEGORIE');

 $KEY=$this->input->post('key');
 $KEY2=$this->input->post('key2');
$break=explode(".",$KEY2);
$ID=$KEY2;
$criteres1="";
$cripaid="";
$categorie="";
$plaque='';
 $search='';
        
$criteres_date="";

        
if(!empty($mois)){

$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y')='".$mois."'"; 
        }

if(!empty($jour)){

$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y-%m')='".$jour."'";
        }
  if(!empty($heure)){
     
$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y-%m-%d')= '".$heure."'  ";
    
         }

if ($IS_PAID != ''){
   $cripaid.="  AND  h.IS_PAID=".$IS_PAID;
     
 }
 if (!empty($ID_CATEGORIE)){
   $categorie.="  AND  h.ID_HISTORIQUE_CATEGORIE=".$ID_CATEGORIE;
     
 }


 if (!empty($NUMERO_PLAQUE)) {
   $search=' and h.NUMERO_PLAQUE like "%'.$NUMERO_PLAQUE.'%"'; 
 }

 if (!empty($NUMERO_PERMIS)) {
   $plaque=' and h.NUMERO_PERMIS like "%'.$NUMERO_PERMIS.'%"'; 
 }



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     
$query_principal=" ";

 if (!empty($KEY)) {
  $query_principal=" SELECT e.ID_PSR_ELEMENT,h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,h.DATE_INSERTION,p.MONTANT FROM `historiques` h LEFT join infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_CONTROLE_TECHNIQUE_PEINE LEFT JOIN infra_peines p ON p.ID_INFRA_INFRACTION=i.ID_INFRA_INFRACTION LEFT JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR LEFT JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT  WHERE RAISON_ANNULATION IS NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie." ";
        }else{
      $query_principal=" SELECT e.ID_PSR_ELEMENT,h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,h.DATE_INSERTION,p.MONTANT FROM `historiques` h LEFT JOIN infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_CONTROLE_TECHNIQUE_PEINE LEFT JOIN infra_peines p ON p.ID_INFRA_INFRACTION=i.ID_INFRA_INFRACTION LEFT JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR LEFT JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT  WHERE RAISON_ANNULATION IS NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie."  ";   
        }



        $limit='LIMIT 0,10';
        if($_POST['length'] != -1)
        {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $order_by='';
        if($_POST['order']['0']['column']!=0)
        {
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE  ASC'; 
        }

        $search = !empty($_POST['search']['value']) ? ("AND (h.NUMERO_PLAQUE LIKE '%$var_search%'  OR h.NUMERO_PERMIS LIKE '%$var_search%' OR e.NOM LIKE '%$var_search%' OR e.PRENOM LIKE '%$var_search%' OR e.NUMERO_MATRICULE LIKE '%$var_search%' OR h.DATE_INSERTION LIKE '%$var_search%' ) ") : '';   
        if (!empty($KEY)) {
         $critaire=' AND h.ID_CONTROLE_TECHNIQUE_PEINE='.$KEY;
        }else{
         $critaire=' AND h.ID_CONTROLE_TECHNIQUE_PEINE IS NULL ';   
        }
        

    
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {

          $lieu='';
$affid=$this->Model->getRequeteOne(" SELECT PSR_AFFECTATION_ID FROM psr_element_affectation WHERE ID_PSR_ELEMENT=".$row->ID_PSR_ELEMENT."  ");
if (!empty($affid['PSR_AFFECTATION_ID'])) {
$affecta=$this->Model->getRequeteOne(" SELECT LIEU_EXACTE FROM psr_affectatations WHERE PSR_AFFECTATION_ID=".$affid['PSR_AFFECTATION_ID']."  ");
$lieu=$affecta['LIEU_EXACTE']; 
}else{
$lieu='';
}
    
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_PERMIS;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$lieu;
         $intrant[] =$row->MONTANT;
         $intrant[] =$row->DATE_INSERTION;
         $data[] = $intrant;
          }

        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" =>$this->Model->all_data($query_principal),
            "recordsFiltered" => $this->Model->filtrer($query_filter),
            "data" => $data
        );

        echo json_encode($output);
    }
    function detail2() 
    {
    
   $mois=$this->input->post('mois');
  $jour=$this->input->post('jour');
  $heure=$this->input->post('heure');
$NUMERO_PLAQUE=$this->input->post('NUMERO_PLAQUE');
$NUMERO_PERMIS=$this->input->post('NUMERO_PERMIS');
$IS_PAID=$this->input->post('IS_PAID');
$ID_CATEGORIE=$this->input->post('ID_CATEGORIE');

 $KEY=$this->input->post('key');
 $KEY2=$this->input->post('key2');
$break=explode(".",$KEY2);
$ID=$KEY2;
$criteres1="";
$cripaid="";
$categorie="";
$plaque='';
 $search='';
        
$criteres_date="";

        
if(!empty($mois)){

$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y')='".$mois."'"; 
        }

if(!empty($jour)){

$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y-%m')='".$jour."'";
        }
  if(!empty($heure)){
     
$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y-%m-%d')= '".$heure."'  ";
    
         }

if ($IS_PAID != ''){
   $cripaid.="  AND  h.IS_PAID=".$IS_PAID;
     
 }
 if (!empty($ID_CATEGORIE)){
   $categorie.="  AND  h.ID_HISTORIQUE_CATEGORIE=".$ID_CATEGORIE;
     
 }


 if (!empty($NUMERO_PLAQUE)) {
   $search=' and h.NUMERO_PLAQUE like "%'.$NUMERO_PLAQUE.'%"'; 
 }

 if (!empty($NUMERO_PERMIS)) {
   $plaque=' and h.NUMERO_PERMIS like "%'.$NUMERO_PERMIS.'%"'; 
 }

$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     
$query_principal=" ";

 if (!empty($KEY)) {
  $query_principal=" SELECT e.ID_PSR_ELEMENT,h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,h.DATE_INSERTION,p.MONTANT FROM `historiques` h LEFT join infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_VOL_PEINE LEFT JOIN infra_peines p ON p.ID_INFRA_INFRACTION=i.ID_INFRA_INFRACTION JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR LEFT JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT WHERE RAISON_ANNULATION IS NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1 AND p.MONTANT<>0  ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie." ";
        }else{
    $query_principal=" SELECT e.ID_PSR_ELEMENT,h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,h.DATE_INSERTION,p.MONTANT FROM `historiques` h LEFT JOIN infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_VOL_PEINE LEFT JOIN infra_peines p ON p.ID_INFRA_INFRACTION=i.ID_INFRA_INFRACTION LEFT JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR LEFT JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT  WHERE RAISON_ANNULATION IS NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1  ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie." ";   
        }



        $limit='LIMIT 0,10';
        if($_POST['length'] != -1)
        {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $order_by='';
        if($_POST['order']['0']['column']!=0)
        {
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE  ASC'; 
        }

        $search = !empty($_POST['search']['value']) ? ("AND (h.NUMERO_PLAQUE LIKE '%$var_search%'  OR h.NUMERO_PERMIS LIKE '%$var_search%' OR e.NOM LIKE '%$var_search%' OR e.PRENOM LIKE '%$var_search%' OR e.NUMERO_MATRICULE LIKE '%$var_search%'  OR h.DATE_INSERTION LIKE '%$var_search%' ) ") : '';   
        if (!empty($KEY)) {
         $critaire=' AND h.ID_VOL_PEINE='.$KEY;
        }else{
         $critaire=' AND h.ID_VOL_PEINE IS NULL ';   
        }
        

    
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {
$lieu='';
$affid=$this->Model->getRequeteOne(" SELECT PSR_AFFECTATION_ID FROM psr_element_affectation WHERE ID_PSR_ELEMENT=".$row->ID_PSR_ELEMENT."  ");
if (!empty($affid['PSR_AFFECTATION_ID'])) {
$affecta=$this->Model->getRequeteOne(" SELECT LIEU_EXACTE FROM psr_affectatations WHERE PSR_AFFECTATION_ID=".$affid['PSR_AFFECTATION_ID']."  ");
$lieu=$affecta['LIEU_EXACTE']; 
}else{
$lieu='';
}
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_PERMIS;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$lieu;
         $intrant[] =$row->MONTANT;
         $intrant[] =$row->DATE_INSERTION;
         $data[] = $intrant;
          }

        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" =>$this->Model->all_data($query_principal),
            "recordsFiltered" => $this->Model->filtrer($query_filter),
            "data" => $data
        );

        echo json_encode($output);
    }
    function detail4() 
    {
    
 $mois=$this->input->post('mois');
  $jour=$this->input->post('jour');
  $heure=$this->input->post('heure');
$NUMERO_PLAQUE=$this->input->post('NUMERO_PLAQUE');
$NUMERO_PERMIS=$this->input->post('NUMERO_PERMIS');
$IS_PAID=$this->input->post('IS_PAID');
$ID_CATEGORIE=$this->input->post('ID_CATEGORIE');

 $KEY=$this->input->post('key');
 $KEY2=$this->input->post('key2');
$break=explode(".",$KEY2);
$ID=$KEY2;
$criteres1="";
$cripaid="";
$categorie="";
$plaque='';
 $search='';
        
$criteres_date="";

        
if(!empty($mois)){

$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y')='".$mois."'"; 
        }

if(!empty($jour)){

$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y-%m')='".$jour."'";
        }
  if(!empty($heure)){
     
$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y-%m-%d')= '".$heure."'  ";
    
         }

if ($IS_PAID != ''){
   $cripaid.="  AND  h.IS_PAID=".$IS_PAID;
     
 }
 if (!empty($ID_CATEGORIE)){
   $categorie.="  AND  h.ID_HISTORIQUE_CATEGORIE=".$ID_CATEGORIE;
     
 }


 if (!empty($NUMERO_PLAQUE)) {
   $search=' and h.NUMERO_PLAQUE like "%'.$NUMERO_PLAQUE.'%"'; 
 }

 if (!empty($NUMERO_PERMIS)) {
   $plaque=' and h.NUMERO_PERMIS like "%'.$NUMERO_PERMIS.'%"'; 
 }



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     
$query_principal=" ";

 if (!empty($KEY)) {
  $query_principal=" SELECT e.ID_PSR_ELEMENT,h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,h.DATE_INSERTION,p.MONTANT FROM `historiques` h LEFT JOIN infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_PERMIS_PEINE LEFT JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR LEFT JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN infra_peines p ON p.ID_INFRA_INFRACTION=i.ID_INFRA_INFRACTION WHERE RAISON_ANNULATION IS NULL AND h.NUMERO_PERMIS IS NOT NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1   ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie." ";
        }else{
      $query_principal=" SELECT e.ID_PSR_ELEMENT,h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,h.DATE_INSERTION,p.MONTANT FROM `historiques` h LEFT JOIN infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_PERMIS_PEINE LEFT JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR LEFT JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN infra_peines p ON p.ID_INFRA_INFRACTION=i.ID_INFRA_INFRACTION WHERE RAISON_ANNULATION IS NULL AND h.NUMERO_PERMIS IS NOT NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie."  ";   
        }



        $limit='LIMIT 0,10';
        if($_POST['length'] != -1)
        {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $order_by='';
        if($_POST['order']['0']['column']!=0)
        {
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE  ASC'; 
        }

        $search = !empty($_POST['search']['value']) ? ("AND (h.NUMERO_PLAQUE LIKE '%$var_search%'  OR h.NUMERO_PERMIS LIKE '%$var_search%' OR e.NOM LIKE '%$var_search%' OR e.PRENOM LIKE '%$var_search%' OR e.NUMERO_MATRICULE LIKE '%$var_search%' OR h.DATE_INSERTION LIKE '%$var_search%' ) ") : '';   
        if (!empty($KEY)) {
         $critaire=' AND h.ID_PERMIS_PEINE='.$KEY;
        }else{
         $critaire=' AND h.ID_PERMIS_PEINE IS NULL ';   
        }
        

    
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {

  $lieu='';
$affid=$this->Model->getRequeteOne(" SELECT PSR_AFFECTATION_ID FROM psr_element_affectation WHERE ID_PSR_ELEMENT=".$row->ID_PSR_ELEMENT."  ");
if (!empty($affid['PSR_AFFECTATION_ID'])) {
$affecta=$this->Model->getRequeteOne(" SELECT LIEU_EXACTE FROM psr_affectatations WHERE PSR_AFFECTATION_ID=".$affid['PSR_AFFECTATION_ID']."  ");
$lieu=$affecta['LIEU_EXACTE']; 
}else{
$lieu='';
}
    
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_PERMIS;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$lieu;
         $intrant[] =$row->MONTANT;
         $intrant[] =$row->DATE_INSERTION;
         $data[] = $intrant;
          }

        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" =>$this->Model->all_data($query_principal),
            "recordsFiltered" => $this->Model->filtrer($query_filter),
            "data" => $data
        );

        echo json_encode($output);
    }
    function detail3()  
    {
  $mois=$this->input->post('mois');
  $jour=$this->input->post('jour');
  $heure=$this->input->post('heure');
$NUMERO_PLAQUE=$this->input->post('NUMERO_PLAQUE');
$NUMERO_PERMIS=$this->input->post('NUMERO_PERMIS');
$IS_PAID=$this->input->post('IS_PAID');
$ID_CATEGORIE=$this->input->post('ID_CATEGORIE');

 $KEY=$this->input->post('key');
 $KEY2=$this->input->post('key2');
$break=explode(".",$KEY2);
$ID=$KEY2;
$criteres1="";
$cripaid="";
$categorie="";
$plaque='';
 $search='';
        
$criteres_date="";

        
if(!empty($mois)){

$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y')='".$mois."'"; 
        }

if(!empty($jour)){

$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y-%m')='".$jour."'";
        }
  if(!empty($heure)){
     
$criteres_date.=" AND date_format(h.DATE_INSERTION,'%Y-%m-%d')= '".$heure."'  ";
    
         }

if ($IS_PAID != ''){
   $cripaid.="  AND  h.IS_PAID=".$IS_PAID;
     
 }
 if (!empty($ID_CATEGORIE)){
   $categorie.="  AND  h.ID_HISTORIQUE_CATEGORIE=".$ID_CATEGORIE;
     
 }


 if (!empty($NUMERO_PLAQUE)) {
   $search=' and h.NUMERO_PLAQUE like "%'.$NUMERO_PLAQUE.'%"'; 
 }

 if (!empty($NUMERO_PERMIS)) {
   $plaque=' and h.NUMERO_PERMIS like "%'.$NUMERO_PERMIS.'%"'; 
 }



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     
$query_principal=" ";

 if (!empty($KEY)) {

  $query_principal=" SELECT e.ID_PSR_ELEMENT,h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,h.DATE_INSERTION,p.MONTANT FROM `historiques` h LEFT join infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_PERMIS_PEINE LEFT JOIN infra_peines p ON p.ID_INFRA_INFRACTION=i.ID_INFRA_INFRACTION LEFT JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR LEFT JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT  WHERE RAISON_ANNULATION IS NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie."  ";
        }else{
      $query_principal=" SELECT e.ID_PSR_ELEMENT,h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,h.DATE_INSERTION,p.MONTANT FROM `historiques` h LEFT JOIN infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_PERMIS_PEINE LEFT JOIN infra_peines p ON p.ID_INFRA_INFRACTION=i.ID_INFRA_INFRACTION LEFT JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR LEFT JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT  WHERE RAISON_ANNULATION IS NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie."  ";   
        }



        $limit='LIMIT 0,10';
        if($_POST['length'] != -1)
        {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $order_by='';
        if($_POST['order']['0']['column']!=0)
        {
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE  ASC'; 
        }

        $search = !empty($_POST['search']['value']) ? ("AND (h.NUMERO_PLAQUE LIKE '%$var_search%'  OR h.NUMERO_PERMIS LIKE '%$var_search%' OR e.NOM LIKE '%$var_search%' OR e.PRENOM LIKE '%$var_search%' OR e.NUMERO_MATRICULE LIKE '%$var_search%'  OR h.DATE_INSERTION LIKE '%$var_search%' ) ") : '';   
        if (!empty($KEY)) {
         $critaire=' AND h.ID_IMMATRICULATIO_PEINE='.$KEY; 
        }else{
         $critaire=' AND h.ID_IMMATRICULATIO_PEINE IS NULL ';   
        }
        

    
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {

          $lieu='';
$affid=$this->Model->getRequeteOne(" SELECT PSR_AFFECTATION_ID FROM psr_element_affectation WHERE ID_PSR_ELEMENT=".$row->ID_PSR_ELEMENT."  ");
if (!empty($affid['PSR_AFFECTATION_ID'])) {
$affecta=$this->Model->getRequeteOne(" SELECT LIEU_EXACTE FROM psr_affectatations WHERE PSR_AFFECTATION_ID=".$affid['PSR_AFFECTATION_ID']."  ");
$lieu=$affecta['LIEU_EXACTE']; 
}else{
$lieu='';
}
    
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_PERMIS;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$lieu;
         $intrant[] =$row->MONTANT;
         $intrant[] =$row->DATE_INSERTION;
         $data[] = $intrant;
          }

        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" =>$this->Model->all_data($query_principal),
            "recordsFiltered" => $this->Model->filtrer($query_filter),
            "data" => $data
        );

        echo json_encode($output);
    }

public function get_rapport(){ 

$mois=$this->input->post('mois');  
$jour=$this->input->post('jour');
$heure=$this->input->post('heure');
$NUMERO_PLAQUE=$this->input->post('NUMERO_PLAQUE');
$NUMERO_PERMIS=$this->input->post('NUMERO_PERMIS');
$IS_PAID=$this->input->post('IS_PAID');
$ID_CATEGORIE=$this->input->post('ID_CATEGORIE');

$datte="";
$datjour="";
$criteres1="";
$cripaid="";
$categorie="";

if ($IS_PAID != ""){
   $cripaid.="  AND  h.IS_PAID=".$IS_PAID;
     
 }
 if (!empty($ID_CATEGORIE)){
   $categorie.="  AND  h.ID_HISTORIQUE_CATEGORIE=".$ID_CATEGORIE;
     
 }

if
(!empty($mois)){


$criteres1.=" AND date_format(h.DATE_INSERTION,'%Y')='".$mois."'";

  }

  if(!empty($jour)){
     $criteres1.=" AND date_format(h.DATE_INSERTION,'%Y-%m')= '".$jour."'  ";
    
         }
          if(!empty($heure)){
     $criteres1.=" AND date_format(h.DATE_INSERTION,'%Y-%m-%d')= '".$heure."'  ";
    
         }

  $datte=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(historiques.DATE_INSERTION, "%Y-%m") as mois from historiques where RAISON_ANNULATION IS NULL AND DATE_FORMAT(historiques.DATE_INSERTION, "%Y")="'.$mois.'" ORDER BY mois DESC');

  $mois_select="<option selected='' disabled=''>séléctionner</option>";

    foreach ($datte as $value)
         {

        if ($jour==$value['mois'])
              {
      $mois_select.="<option value='".$value['mois']."' selected>".$value['mois']."</option>";
                                } else{ 
    $mois_select.="<option value='".$value['mois']."'>".$value['mois']."</option>";
      } 
      } 

$datjour=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(historiques.DATE_INSERTION, "%Y-%m-%d") as mois from historiques where RAISON_ANNULATION IS NULL AND  DATE_FORMAT(historiques.DATE_INSERTION, "%Y-%m")="'.$jour.'" ORDER BY mois DESC');

  $selectjour="<option selected='' disabled=''>séléctionner</option>";

    foreach ($datjour as $value)
         {

        if ($heure==$value['mois'])
              {
      $selectjour.="<option value='".$value['mois']."' selected>".$value['mois']."</option>";
                                } else{ 
    $selectjour.="<option value='".$value['mois']."'>".$value['mois']."</option>";
      } 
      } 


 $search='';

 if (!empty($NUMERO_PLAQUE)) {
   $search=' and h.NUMERO_PLAQUE like "%'.$NUMERO_PLAQUE.'%"'; 
 }

 $plaque='';

 if (!empty($NUMERO_PERMIS)) {
   $plaque=' and h.NUMERO_PERMIS like "%'.$NUMERO_PERMIS.'%"'; 
 }



$assurence=$this->Model->getRequete("SELECT i.NIVEAU_ALERTE ,h.ID_ASSURANCE_PEINE AS ID,COUNT(h.ID_HISTORIQUE) as NBRE,(SELECT SUM(MONTANT) FROM infra_peines WHERE ID_INFRA_INFRACTION=ID )*COUNT(h.ID_ASSURANCE_PEINE) AS amande FROM `historiques` h LEFT JOIN infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_ASSURANCE_PEINE WHERE RAISON_ANNULATION IS NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1 ".$search."  ".$plaque." ".$criteres1." ".$cripaid." ".$categorie." GROUP BY h.ID_ASSURANCE_PEINE,i.NIVEAU_ALERTE");

$assurence_categorie=" ";
$assurence_categorie_monta=" ";
$assurence_categorie_total=0;
$assurence_categorie_total_monta=0;
 
 foreach ($assurence as  $value) {
      
       
$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$nom=(!empty($value['NIVEAU_ALERTE'])) ? $value['NIVEAU_ALERTE'] : "Assurence trouvé" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$assurence_categorie_monta.="{name:'".str_replace("'","\'", $nom)."', y:". $monta.",key:'". $key_id1."'},";
$assurence_categorie.="{name:'".str_replace("'","\'", $nom)."', y:". $nbre.",key:'". $key_id1."'},";
$assurence_categorie_total=$assurence_categorie_total+$value['NBRE'];
$assurence_categorie_total_monta=$assurence_categorie_total_monta+$value['amande'];
    
     }
//techn   
$techn=$this->Model->getRequete("SELECT i.NIVEAU_ALERTE ,h.ID_CONTROLE_TECHNIQUE_PEINE AS ID,COUNT(h.ID_HISTORIQUE) as NBRE,(SELECT SUM(MONTANT) FROM infra_peines WHERE ID_INFRA_INFRACTION=ID )*COUNT(h.ID_CONTROLE_TECHNIQUE_PEINE) AS amande FROM `historiques` h LEFT JOIN infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_CONTROLE_TECHNIQUE_PEINE WHERE RAISON_ANNULATION IS NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1 ".$search."  ".$plaque." ".$criteres1." ".$cripaid." ".$categorie." GROUP BY h.ID_CONTROLE_TECHNIQUE_PEINE,i.NIVEAU_ALERTE");

$techn_categorie=" ";
$techn_categorie_monta=" ";
$techn_categorie_total=0;
$techn_categorie_total_monta=0;
 
 foreach ($techn as  $value) {
      
      
$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$nom=(!empty($value['NIVEAU_ALERTE'])) ? $value['NIVEAU_ALERTE'] : "Controle technique trouvé" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$techn_categorie_monta.="{name:'".str_replace("'","\'", $value['NIVEAU_ALERTE'])."', y:". $monta.",key:'". $key_id1."'},";
$techn_categorie.="{name:'".str_replace("'","\'", $nom)." : ".number_format($nbre,0,',',' ')." => (".number_format($monta,0,',',' ')." FBU)', y:". $nbre.",key:'". $key_id1."'},";
$techn_categorie_total=$techn_categorie_total+$value['NBRE'];
$techn_categorie_total_monta=$techn_categorie_total_monta+$value['amande'];

    
     }

     ///pj

$pj=$this->Model->getRequete("SELECT i.NIVEAU_ALERTE ,h.ID_VOL_PEINE AS ID,COUNT(h.ID_HISTORIQUE) as NBRE,(SELECT SUM(MONTANT) FROM infra_peines WHERE ID_INFRA_INFRACTION=ID )*COUNT(h.ID_VOL_PEINE) AS amande FROM `historiques` h LEFT JOIN infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_VOL_PEINE WHERE RAISON_ANNULATION IS NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1 ".$search."  ".$plaque." ".$criteres1." ".$cripaid." ".$categorie." GROUP BY h.ID_VOL_PEINE,i.NIVEAU_ALERTE");

$pj_categorie=" ";
$pj_categorie_monta=" ";
$pj_categorie_total=0;
$pj_categorie_total_monta=0;
 
 foreach ($pj as  $value) {
      
      
$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nom=(!empty($value['NIVEAU_ALERTE'])) ? $value['NIVEAU_ALERTE'] : "Vehicule trouvé" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$pj_categorie_monta.="{name:'".str_replace("'","\'", $nom)."', y:". $monta.",key:'". $key_id1."'},";
$pj_categorie.="{name:'".str_replace("'","\'", $nom)."', y:". $nbre.",key:'". $key_id1."'},";
$pj_categorie_total=$pj_categorie_total+$value['NBRE'];
$pj_categorie_total_monta=$pj_categorie_total_monta+$value['amande'];
    
     }



///permis

$permis=$this->Model->getRequete("SELECT i.NIVEAU_ALERTE ,h.ID_PERMIS_PEINE AS ID,COUNT(h.ID_HISTORIQUE) as NBRE,(SELECT SUM(MONTANT) FROM infra_peines WHERE ID_INFRA_INFRACTION=ID )*COUNT(h.ID_PERMIS_PEINE) AS amande FROM `historiques` h LEFT JOIN infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_PERMIS_PEINE WHERE RAISON_ANNULATION IS NULL AND h.NUMERO_PERMIS IS NOT NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1 ".$search."  ".$plaque." ".$criteres1." ".$cripaid." ".$categorie." GROUP BY h.ID_PERMIS_PEINE,i.NIVEAU_ALERTE");

$permis_categorie=" ";
$permis_categorie_monta=" ";
$permis_categorie_total=0;
$permis_categorie_total_monta=0;
 
 foreach ($permis as  $value) {
      
      
$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nom=(!empty($value['NIVEAU_ALERTE'])) ? $value['NIVEAU_ALERTE'] : "Permis trouvé" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$permis_categorie_monta.="{name:'".str_replace("'","\'", $nom)."', y:". $monta.",key:'". $key_id1."'},";
$permis_categorie.="{name:'".str_replace("'","\'", $nom)."', y:". $nbre.",key:'". $key_id1."'},";
$permis_categorie_total=$permis_categorie_total+$value['NBRE'];
$permis_categorie_total_monta=$permis_categorie_total_monta+$value['amande'];
    
     }

///immatricula

$immatricula=$this->Model->getRequete("SELECT i.NIVEAU_ALERTE ,h.ID_IMMATRICULATIO_PEINE AS ID,COUNT(h.ID_HISTORIQUE) as NBRE,(SELECT SUM(MONTANT) FROM infra_peines WHERE ID_INFRA_INFRACTION=ID )*COUNT(h.ID_IMMATRICULATIO_PEINE) AS amande FROM `historiques` h LEFT JOIN infra_infractions i ON i.ID_INFRA_INFRACTION=h.ID_IMMATRICULATIO_PEINE WHERE RAISON_ANNULATION IS NULL AND (h.IS_ANNULE=0 OR h.IS_ANNULE IS NULL) AND h.IS_FINISHED=1 ".$search."  ".$plaque." ".$criteres1." ".$cripaid." ".$categorie." GROUP BY h.ID_IMMATRICULATIO_PEINE,i.NIVEAU_ALERTE");

$immatricula_categorie=" ";
$immatricula_categorie_monta=" ";
$immatricula_categorie_total=0;
$immatricula_categorie_total_monta=0;
 
 foreach ($immatricula as  $value) {
      
      
$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nom=(!empty($value['NIVEAU_ALERTE'])) ? $value['NIVEAU_ALERTE'] : "Immatriculation trouvé" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$immatricula_categorie_monta.="{name:'".str_replace("'","\'", $nom)."', y:". $monta.",key:'". $key_id1."'},";
$immatricula_categorie.="{name:'".str_replace("'","\'", $nom)."', y:". $nbre.",key:'". $key_id1."'},";
$immatricula_categorie_total=$immatricula_categorie_total+$value['NBRE'];
$immatricula_categorie_total_monta=$immatricula_categorie_total_monta+$value['amande'];
    
     }
   
    $rapp="<script type=\"text/javascript\">
    Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },

    legend: {
        symbolWidth: 40
    },

    title: {
        text: '<b>Contrôle des assurances </b>  du ".date('d-m-Y')." <br> Total=(".number_format($assurence_categorie_total,0,',',' ').") '
    },

    subtitle: {
        text: ''
    },

    yAxis: {
        title: {
            text: ' '
        },
        accessibility: {
            description: ''
        }
    },

    xAxis: {
        title: {
            text: ''
        },
        accessibility: {
            description: ''
        },
                        type: 'category'

                    },

   tooltip: {
        pointFormat: '{series.name}: <b>{point.y:.0f}</b>'
    },

    plotOptions: {
        bar: {
       cursor:'pointer',
                        point:{
                            events: {
                                 click: function()
                                 {

                               
                               $(\"#titre\").html(\"Détails \");
                                  
                                   $(\"#myModal\").modal();
                                 

                  var row_count ='1000000';
                   $(\"#mytable\").DataTable({
                        \"processing\":true,
                        \"serverSide\":true,
                        \"bDestroy\": true,
                        \"oreder\":[],
                        \"ajax\":{
                            url:\"".base_url('dashboard/Dashbord_Controle_Rapide/detail')."\",
                       type:\"POST\",
                       data:{
                         key:this.key, 
                                 key2:this.key2,
                                mois:$('#mois').val(),
                                jour:$('#jour').val(),
                                heure:$('#heure').val(),
                                NUMERO_PLAQUE:$('#NUMERO_PLAQUE').val(),
                                 NUMERO_PERMIS:$('#NUMERO_PERMIS').val(),
                                  IS_PAID:$('#IS_PAID').val(),
                                  ID_CATEGORIE:$('#ID_CATEGORIE').val()
                                  
                                }
                        },
                        lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
                    pageLength: 10,
                            \"columnDefs\":[{
                             \"targets\":[],
                             \"orderable\":false
                               }],

                         dom: 'Bfrtlip',
                         buttons: [
                           'excel', 'print','pdf'
                            ],
                       language: {
                                \"sProcessing\":     \"Traitement en cours...\",
                                \"sSearch\":         \"Rechercher&nbsp;:\",
                                \"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
                                \"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
                                \"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
                                \"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
                                \"sInfoPostFix\":    \"\",
                                \"sLoadingRecords\": \"Chargement en cours...\",
                                \"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
                                \"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
                                \"oPaginate\": {
                                  \"sFirst\":      \"Premier\",
                                  \"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
                                  \"sNext\":       \"Suivant\",
                                  \"sLast\":       \"Dernier\"
                                },
                                \"oAria\": {
                                  \"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
                                  \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
                                }
                            }
                              
                    });

                              }
                           }
                        },
          dataLabels: {
             enabled: true,
             format: '{point.y:f}'
         },
         showInLegend: false
        }
    }, 
 credits: {
              enabled: true,
              href: \"\",
              text: \"Mediabox\"
      },

series: [

{
    
     name: 'Infractions (".number_format($assurence_categorie_total,0,',',' ').")',
    data: [".$assurence_categorie."],
    color:\"purple\"
},

// {
//    name: 'Montant (".number_format($assurence_categorie_total_monta,0,',',' ')." FBU)',
//     data: [".$assurence_categorie_monta."],
//     color: \"green\"
// },

],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 550
            },
            chartOptions: {
                chart: {
                    spacingLeft: 3,
                    spacingRight: 3
                },
                legend: {
                    itemWidth: 150
                },
                xAxis: {
                    type: 'category',
                    title: ''
                },
                yAxis: {
                    visible: false
                }
            }
        }]
    }
});
  
  </script>";

  $rapp0="<script type=\"text/javascript\">
    Highcharts.chart('container0', {
    chart: {
        type: 'pie'
    },

    legend: {
        symbolWidth: 40
    },

    title: {
        text: '<b>Amandes sur contrôle des assurances </b>  du ".date('d-m-Y')." <br> Amande = (".number_format($assurence_categorie_total_monta,0,',',' ')." FBU) '
    },

    subtitle: {
        text: ''
    },

    yAxis: {
        title: {
            text: ' '
        },
        accessibility: {
            description: ''
        }
    },

    xAxis: {
        title: {
            text: ''
        },
        accessibility: {
            description: ''
        },
                        type: 'category'

                    },

   tooltip: {
        pointFormat: '{series.name}: <b>{point.y:.0f}</b>'
    },

    plotOptions: {
        pie: {
       cursor:'pointer',
                        point:{
                            events: {
                                 click: function()
                                 {

                               
                               $(\"#titre\").html(\"Détails \");
                                  
                                   $(\"#myModal\").modal();
                                 

                  var row_count ='1000000';
                   $(\"#mytable\").DataTable({
                        \"processing\":true,
                        \"serverSide\":true,
                        \"bDestroy\": true,
                        \"oreder\":[],
                        \"ajax\":{
                            url:\"".base_url('dashboard/Dashbord_Controle_Rapide/detail')."\",
                       type:\"POST\",
                       data:{
                         key:this.key, 
                                 key2:this.key2,
                                mois:$('#mois').val(),
                                jour:$('#jour').val(),
                                heure:$('#heure').val(),
                                NUMERO_PLAQUE:$('#NUMERO_PLAQUE').val(),
                                 NUMERO_PERMIS:$('#NUMERO_PERMIS').val(),
                                  IS_PAID:$('#IS_PAID').val(),
                                  ID_CATEGORIE:$('#ID_CATEGORIE').val()
                                  
                                }
                        },
                        lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
                    pageLength: 10,
                            \"columnDefs\":[{
                             \"targets\":[],
                             \"orderable\":false
                               }],

                         dom: 'Bfrtlip',
                         buttons: [
                           'excel', 'print','pdf'
                            ],
                       language: {
                                \"sProcessing\":     \"Traitement en cours...\",
                                \"sSearch\":         \"Rechercher&nbsp;:\",
                                \"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
                                \"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
                                \"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
                                \"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
                                \"sInfoPostFix\":    \"\",
                                \"sLoadingRecords\": \"Chargement en cours...\",
                                \"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
                                \"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
                                \"oPaginate\": {
                                  \"sFirst\":      \"Premier\",
                                  \"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
                                  \"sNext\":       \"Suivant\",
                                  \"sLast\":       \"Dernier\"
                                },
                                \"oAria\": {
                                  \"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
                                  \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
                                }
                            }
                              
                    });

                              }
                           }
                        },
          dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y:.0f}',
                          connectorColor: 'silver'
             },
            showInLegend: false
        }
    }, 
 credits: {
              enabled: true,
              href: \"\",
              text: \"Mediabox\"
      },

series: [

 {    name: 'Montant (".number_format($assurence_categorie_total_monta,0,',',' ')." FBU)',
   data: [".$assurence_categorie_monta."],
    color: \"green\"
 },

],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 550
            },
            chartOptions: {
                chart: {
                    spacingLeft: 3,
                    spacingRight: 3
                },
                legend: {
                    itemWidth: 150
                },
                xAxis: {
                    type: 'category',
                    title: ''
                },
                yAxis: {
                    visible: false
                }
            }
        }]
    }
});
  
  </script>";

   $rapp1="<script type=\"text/javascript\">
   Highcharts.chart('container1', {
           chart: {
        type: 'pie',
       
    },
    title: {
        text: '<b>Contrôle technique </b>  du ".date('d-m-Y')." '
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
  
    plotOptions: {
        pie: {
             allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
       cursor:'pointer',
             point:{
                events: {
 click: function()
{
$(\"#titre\").html(\"Détails \");
$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashbord_Controle_Rapide/detail1')."\",
type:\"POST\",
data:{
key:this.key, 
                                 key1:this.key1,
                                mois:$('#mois').val(),
                                jour:$('#jour').val(),
                                heure:$('#heure').val(),
                                NUMERO_PLAQUE:$('#NUMERO_PLAQUE').val(),
                                 NUMERO_PERMIS:$('#NUMERO_PERMIS').val(),
                                  IS_PAID:$('#IS_PAID').val(),
                                  ID_CATEGORIE:$('#ID_CATEGORIE').val()
}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: [
'excel', 'print','pdf'
],
language: {
\"sProcessing\":     \"Traitement en cours...\",
\"sSearch\":         \"Rechercher&nbsp;:\",
\"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
\"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
\"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
\"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
 \"sInfoPostFix\":    \"\",
\"sLoadingRecords\": \"Chargement en cours...\",
\"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
\"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
\"oPaginate\": {
\"sFirst\":      \"Premier\",
\"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
\"sNext\":       \"Suivant\",
\"sLast\":       \"Dernier\"
},
 \"oAria\": {
\"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
 \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
}
}
                              
});


                           

                   }
               }
           },
         showInLegend: false
     }
 },

    credits: {
  enabled: true,
  href: \"\",
  text: \"Mediabox\"
},      
    series: [{
        type: 'pie',
        name: 'Browser share',
        data: [".$techn_categorie."]
    }]
});
</script>
     ";
 $rapp2="<script type=\"text/javascript\">
    Highcharts.chart('container2', {
   
chart: {
        type: 'column'
    },
    title: {
        text: '<b> Contrôle pj (Interpole)  </b>  du ".date('d-m-Y')." '
    },
    subtitle: {
        text: ''
    },
    xAxis: {
          type: 'category',
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    tooltip: {
        headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
        pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
            '<td style=\"padding:0\"><b>{point.y:.f} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
             pointPadding: 0.2,
            borderWidth: 0,
            depth: 40,
             cursor:'pointer',
             point:{
                events: {
                  click: function()
{
$(\"#titre\").html(\"Détails \");
$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashbord_Controle_Rapide/detail2')."\",
type:\"POST\",
data:{
key:this.key, 
                                 key1:this.key1,
                                mois:$('#mois').val(),
                                jour:$('#jour').val(),
                                heure:$('#heure').val(),
                                NUMERO_PLAQUE:$('#NUMERO_PLAQUE').val(),
                                 NUMERO_PERMIS:$('#NUMERO_PERMIS').val(),
                                  IS_PAID:$('#IS_PAID').val(),
                                  ID_CATEGORIE:$('#ID_CATEGORIE').val()

}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: [
'excel', 'print','pdf'
],
language: {
\"sProcessing\":     \"Traitement en cours...\",
\"sSearch\":         \"Rechercher&nbsp;:\",
\"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
\"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
\"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
\"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
 \"sInfoPostFix\":    \"\",
\"sLoadingRecords\": \"Chargement en cours...\",
\"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
\"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
\"oPaginate\": {
\"sFirst\":      \"Premier\",
\"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
\"sNext\":       \"Suivant\",
\"sLast\":       \"Dernier\"
},
 \"oAria\": {
\"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
 \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
}
}
                              
});


                           

                   }
               }
           },
           dataLabels: {
             enabled: true,
             format: '{point.y:f}'
         },
         showInLegend: true
     }
 }, 
 credits: {
  enabled: true,
  href: \"\",
  text: \"Mediabox\"
},

    series: [
    {
        
        color: 'green',
        name:'Nombre : (".number_format($pj_categorie_total,0,',',' ').")',
        data: [".$pj_categorie."]
    },
     {
        color: 'yellow',  
        name:'Montant : (".number_format($pj_categorie_total_monta,0,',',' ')." FBU)',
        data: [".$pj_categorie_monta."]
    },
    
    ]

});
</script>
     ";
     $rapp3="<script type=\"text/javascript\">
    Highcharts.chart('container3', {
   
chart: {
        type: 'bar'
    },
    title: {
        text: '<b> Contrôle des Immatriculation  </b>  du ".date('d-m-Y')." '
    },
    subtitle: {
        text: ''
    },
    xAxis: {
          type: 'category',
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    tooltip: {
        headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
        pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
            '<td style=\"padding:0\"><b>{point.y:.f} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        bar: {
             pointPadding: 0.2,
            borderWidth: 0,
            depth: 40,
             cursor:'pointer',
             point:{
                events: {
                  click: function()
{
$(\"#titre\").html(\"Détails \");
$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashbord_Controle_Rapide/detail3')."\",
type:\"POST\",
data:{
key:this.key, 
                                 key1:this.key1,
                                mois:$('#mois').val(),
                                jour:$('#jour').val(),
                                heure:$('#heure').val(),
                                NUMERO_PLAQUE:$('#NUMERO_PLAQUE').val(),
                                 NUMERO_PERMIS:$('#NUMERO_PERMIS').val(),
                                  IS_PAID:$('#IS_PAID').val(),
                                  ID_CATEGORIE:$('#ID_CATEGORIE').val()

}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: [
'excel', 'print','pdf'
],
language: {
\"sProcessing\":     \"Traitement en cours...\",
\"sSearch\":         \"Rechercher&nbsp;:\",
\"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
\"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
\"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
\"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
 \"sInfoPostFix\":    \"\",
\"sLoadingRecords\": \"Chargement en cours...\",
\"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
\"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
\"oPaginate\": {
\"sFirst\":      \"Premier\",
\"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
\"sNext\":       \"Suivant\",
\"sLast\":       \"Dernier\"
},
 \"oAria\": {
\"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
 \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
}
}
                              
});


                           

                   }
               }
           },
           dataLabels: {
             enabled: true,
             format: '{point.y:f}'
         },
         showInLegend: true
     }
 }, 
 credits: {
  enabled: true,
  href: \"\",
  text: \"Mediabox\"
},

    series: [
    {
        
        color: 'pink',
        name:'Nombre : (".number_format($immatricula_categorie_total,0,',',' ').")',
        data: [".$immatricula_categorie."]
    },
     {
        color: 'green',  
        name:'Montant : (".number_format($immatricula_categorie_total_monta,0,',',' ')." FBU)',
        data: [".$immatricula_categorie_monta."]
    },
    
    ]

});
</script>
     "; 

    $rapp4="<script type=\"text/javascript\">
    Highcharts.chart('container4', {
    chart: {
        type: 'spline'
    },

    legend: {
        symbolWidth: 40
    },

    title: {
        text: '<b>Contrôle des permis de conduire </b>  du ".date('d-m-Y')." '
    },

    subtitle: {
        text: ''
    },

    yAxis: {
        title: {
            text: ' '
        },
        accessibility: {
            description: ''
        }
    },

    xAxis: {
        title: {
            text: ''
        },
        accessibility: {
            description: ''
        },
                        type: 'category'

                    },

    tooltip: {
        valueSuffix: ' '
    },

    plotOptions: {
        spline: {
       cursor:'pointer',
                        point:{
                            events: {
                                 click: function()
                                 {

                               
                               $(\"#titre\").html(\"Détails \");
                                  
                                   $(\"#myModal\").modal();
                                 

                  var row_count ='1000000';
                   $(\"#mytable\").DataTable({
                        \"processing\":true,
                        \"serverSide\":true,
                        \"bDestroy\": true,
                        \"oreder\":[],
                        \"ajax\":{
                            url:\"".base_url('dashboard/Dashbord_Controle_Rapide/detail4')."\",
                            type:\"POST\",
                            data:{
                             key:this.key, 
                                 key1:this.key1,
                                mois:$('#mois').val(),
                                jour:$('#jour').val(),
                                heure:$('#heure').val(),
                                NUMERO_PLAQUE:$('#NUMERO_PLAQUE').val(),
                                 NUMERO_PERMIS:$('#NUMERO_PERMIS').val(),
                                  IS_PAID:$('#IS_PAID').val(),
                                  ID_CATEGORIE:$('#ID_CATEGORIE').val()
                                  
                                }
                        },
                        lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
                    pageLength: 10,
                            \"columnDefs\":[{
                             \"targets\":[],
                             \"orderable\":false
                               }],

                         dom: 'Bfrtlip',
                         buttons: [
                           'excel', 'print','pdf'
                            ],
                       language: {
                                \"sProcessing\":     \"Traitement en cours...\",
                                \"sSearch\":         \"Rechercher&nbsp;:\",
                                \"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
                                \"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
                                \"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
                                \"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
                                \"sInfoPostFix\":    \"\",
                                \"sLoadingRecords\": \"Chargement en cours...\",
                                \"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
                                \"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
                                \"oPaginate\": {
                                  \"sFirst\":      \"Premier\",
                                  \"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
                                  \"sNext\":       \"Suivant\",
                                  \"sLast\":       \"Dernier\"
                                },
                                \"oAria\": {
                                  \"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
                                  \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
                                }
                            }
                              
                    });

                              }
                           }
                        },
           dataLabels: {
              enabled: true,
               format: '{point.y:,f} '
            },
            showInLegend: true
        }
    }, 
 credits: {
              enabled: true,
              href: \"\",
              text: \"Mediabox\"
      },

series: [

{
    name: 'Nombre des permis(".number_format($permis_categorie_total,0,',',' ')." )', 
    data: [".$permis_categorie."],
    dashStyle: 'DashDot',
    color: \"purple\"
},

{
    name: 'Montant (".number_format($permis_categorie_total_monta,0,',',' ')." FBU)',
    data: [".$permis_categorie_monta."],
    dashStyle: 'DashDot',
    color: \"green\"
},

],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 550
            },
            chartOptions: {
                chart: {
                    spacingLeft: 3,
                    spacingRight: 3
                },
                legend: {
                    itemWidth: 150
                },
                xAxis: {
                    type: 'category',
                    title: ''
                },
                yAxis: {
                    visible: false
                }
            }
        }]
    }
});
  

  </script>";


echo json_encode(array('rapp'=>$rapp,'rapp0'=>$rapp0,'rapp1'=>$rapp1,'rapp2'=>$rapp2,'rapp3'=>$rapp3,'rapp4'=>$rapp4,'select_month'=>$mois_select,'selectjour'=>$selectjour));
    }


}
?>




