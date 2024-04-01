
<?php
 /// EDMOND :dashboard controle physique
class Dashboard_Controle_Physique extends CI_Controller
      {
function index(){

$dattes=$this->Model->getRequete("SELECT DISTINCT date_format(historiques.DATE_INSERTION,'%Y') AS mois FROM historiques WHERE RAISON_ANNULATION IS NULL ORDER BY  mois ASC");

$categorie=$this->Model->getRequete('SELECT ID_CATEGORIE,DESCRIPTION FROM `historiques_categories` WHERE 1');     
$data['dattes']=$dattes;

$data['categorie']=$categorie;
$this->load->view('Dashboard_Controle_Physique_View',$data);
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


$query_principal=" SELECT h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,af.LIEU_EXACTE,h.DATE_INSERTION FROM `historiques` h JOIN autres_controles a ON h.ID_CONTROLE=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN psr_element_affectation ps ON e.ID_PSR_ELEMENT=ps.ID_PSR_ELEMENT LEFT JOIN psr_affectatations af ON af.PSR_AFFECTATION_ID=ps.PSR_AFFECTATION_ID  WHERE RAISON_ANNULATION IS NULL  AND ps.IS_ACTIVE=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie." ";

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
     
        $critaire=' AND q.ID_CONTROLES_QUESTIONNAIRES='.$KEY;
    
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {
    
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_PERMIS;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$row->LIEU_EXACTE;
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


$query_principal=" SELECT h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,af.LIEU_EXACTE,h.DATE_INSERTION FROM `historiques` h JOIN autres_controles a ON h.ID_CONTROLE_EQUIPEMENT=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN psr_element_affectation ps ON e.ID_PSR_ELEMENT=ps.ID_PSR_ELEMENT LEFT JOIN psr_affectatations af ON af.PSR_AFFECTATION_ID=ps.PSR_AFFECTATION_ID  WHERE RAISON_ANNULATION IS NULL AND ps.IS_ACTIVE=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie." ";

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

        $critaire=' AND q.ID_CONTROLES_QUESTIONNAIRES='.$KEY;
    
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {
    
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_PERMIS;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$row->LIEU_EXACTE;
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


$query_principal=" SELECT h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,af.LIEU_EXACTE,h.DATE_INSERTION FROM `historiques` h JOIN autres_controles a ON h.ID_SIGNALEMENT=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN psr_element_affectation ps ON e.ID_PSR_ELEMENT=ps.ID_PSR_ELEMENT LEFT JOIN psr_affectatations af ON af.PSR_AFFECTATION_ID=ps.PSR_AFFECTATION_ID  WHERE RAISON_ANNULATION IS NULL AND ps.IS_ACTIVE=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie." ";

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

        $critaire=' AND q.ID_CONTROLES_QUESTIONNAIRES='.$KEY;
    
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {
    
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_PERMIS;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$row->LIEU_EXACTE;
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


$query_principal=" SELECT h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,af.LIEU_EXACTE,h.DATE_INSERTION FROM `historiques` h JOIN autres_controles a ON h.ID_COMPORTEMENT=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN psr_element_affectation ps ON e.ID_PSR_ELEMENT=ps.ID_PSR_ELEMENT LEFT JOIN psr_affectatations af ON af.PSR_AFFECTATION_ID=ps.PSR_AFFECTATION_ID  WHERE RAISON_ANNULATION IS NULL AND ps.IS_ACTIVE=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie." ";

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

        $critaire=' AND q.ID_CONTROLES_QUESTIONNAIRES='.$KEY;
    
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {
    
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_PERMIS;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$row->LIEU_EXACTE;
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


$query_principal=" SELECT h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,af.LIEU_EXACTE,h.DATE_INSERTION FROM `historiques` h JOIN autres_controles a ON h.ID_CONTROLE_MARCHANDISE=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN psr_element_affectation ps ON e.ID_PSR_ELEMENT=ps.ID_PSR_ELEMENT LEFT JOIN psr_affectatations af ON af.PSR_AFFECTATION_ID=ps.PSR_AFFECTATION_ID  WHERE RAISON_ANNULATION IS NULL AND ps.IS_ACTIVE=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie." ";

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

        $critaire=' AND q.ID_CONTROLES_QUESTIONNAIRES='.$KEY;
    
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {
    
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_PERMIS;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$row->LIEU_EXACTE;
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

    function detailradar()
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


$query_principal=" SELECT h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,af.LIEU_EXACTE,h.DATE_INSERTION FROM `historiques` h JOIN autres_controles a ON h.ID_RADAR=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN psr_element_affectation ps ON e.ID_PSR_ELEMENT=ps.ID_PSR_ELEMENT LEFT JOIN psr_affectatations af ON af.PSR_AFFECTATION_ID=ps.PSR_AFFECTATION_ID  WHERE RAISON_ANNULATION IS NULL AND ps.IS_ACTIVE=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie." ";

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

        $critaire=' AND q.ID_CONTROLES_QUESTIONNAIRES='.$KEY;
    
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {
    
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_PERMIS;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$row->LIEU_EXACTE;
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
function detailparking()
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


$query_principal=" SELECT h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,af.LIEU_EXACTE,h.DATE_INSERTION FROM `historiques` h JOIN autres_controles a ON h.ID_PARKING=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN psr_element_affectation ps ON e.ID_PSR_ELEMENT=ps.ID_PSR_ELEMENT LEFT JOIN psr_affectatations af ON af.PSR_AFFECTATION_ID=ps.PSR_AFFECTATION_ID  WHERE RAISON_ANNULATION IS NULL AND ps.IS_ACTIVE=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie." ";

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

        $critaire=' AND q.ID_CONTROLES_QUESTIONNAIRES='.$KEY;
    
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {
    
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_PERMIS;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$row->LIEU_EXACTE;
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
 function detailsignale()
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


$query_principal=" SELECT h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,af.LIEU_EXACTE,h.DATE_INSERTION FROM `historiques` h JOIN autres_controles a ON h.ID_SIGNALEMENT=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN psr_element_affectation ps ON e.ID_PSR_ELEMENT=ps.ID_PSR_ELEMENT LEFT JOIN psr_affectatations af ON af.PSR_AFFECTATION_ID=ps.PSR_AFFECTATION_ID  WHERE RAISON_ANNULATION IS NULL AND ps.IS_ACTIVE=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie." ";

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

        $critaire=' AND q.ID_CONTROLES_QUESTIONNAIRES='.$KEY;
    
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {
    
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_PERMIS;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$row->LIEU_EXACTE;
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
function detailstation()
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


$query_principal=" SELECT h.NUMERO_PLAQUE,h.NUMERO_PERMIS,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,af.LIEU_EXACTE,h.DATE_INSERTION FROM `historiques` h JOIN autres_controles a ON h.ID_STATIONNEMENT=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES JOIN utilisateurs u ON h.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN psr_element_affectation ps ON e.ID_PSR_ELEMENT=ps.ID_PSR_ELEMENT LEFT JOIN psr_affectatations af ON af.PSR_AFFECTATION_ID=ps.PSR_AFFECTATION_ID  WHERE RAISON_ANNULATION IS NULL AND ps.IS_ACTIVE=1 ".$search."  ".$plaque." ".$criteres_date." ".$cripaid." ".$categorie." ";

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

        $critaire=' AND q.ID_CONTROLES_QUESTIONNAIRES='.$KEY;
    
        
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {
    
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_PERMIS;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$row->LIEU_EXACTE;
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

if ($IS_PAID != ''){
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

  $datte=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(historiques.DATE_INSERTION, "%Y-%m") as mois from historiques where DATE_FORMAT(historiques.DATE_INSERTION, "%Y")="'.$mois.'" ORDER BY mois DESC');

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

$datjour=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(historiques.DATE_INSERTION, "%Y-%m-%d") as mois from historiques where DATE_FORMAT(historiques.DATE_INSERTION, "%Y-%m")="'.$jour.'" AND RAISON_ANNULATION IS NULL ORDER BY mois DESC');

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



$physi=$this->Model->getRequete("SELECT a.ID_CONTROLES_QUESTIONNAIRES AS ID, CONCAT(CONCAT(q.INFRACTIONS, ' ('),q.DESCRIPTION, ')')
 AS NOM,COUNT(q.ID_CONTROLES_QUESTIONNAIRES) as NBRE, SUM(q.MONTANT) as amande FROM `historiques` h JOIN autres_controles a ON h.ID_CONTROLE=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES WHERE RAISON_ANNULATION IS NULL ".$search."  ".$plaque." ".$criteres1." ".$cripaid." ".$categorie." GROUP BY a.ID_CONTROLES_QUESTIONNAIRES,q.INFRACTIONS,q.DESCRIPTION");

$physi_categorie=" ";
$physi_categorie_monta=" ";
$physi_categorie_total=0;
$physi_categorie_total_monta=0;
 
 foreach ($physi as  $value) {
      
      
$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$physi_categorie_monta.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $monta.",key:'". $value['ID']."'},";
$physi_categorie.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $nbre.",key:'". $value['ID']."'},";
$physi_categorie_total=$physi_categorie_total+$value['NBRE'];
$physi_categorie_total_monta=$physi_categorie_total_monta+$value['amande'];
    
     }
//equi
$equip=$this->Model->getRequete("SELECT a.ID_CONTROLES_QUESTIONNAIRES AS ID, CONCAT(CONCAT(q.INFRACTIONS, ' ('),q.DESCRIPTION, ')')
 AS NOM,COUNT(q.ID_CONTROLES_QUESTIONNAIRES) as NBRE, SUM(q.MONTANT) as amande FROM `historiques` h JOIN autres_controles a ON h.ID_CONTROLE_EQUIPEMENT=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES WHERE RAISON_ANNULATION IS NULL ".$search." ".$plaque." ".$criteres1." ".$cripaid." ".$categorie." GROUP BY a.ID_CONTROLES_QUESTIONNAIRES,q.INFRACTIONS,q.DESCRIPTION");

$equip_categorie=" ";
$equip_categorie_monta=" ";
$equip_categorie_total=0;
$equip_categorie_total_monta=0;
 
 foreach ($equip as  $value) {
      
      
$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;

$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$equip_categorie.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $monta.",key:'". $value['ID']."'},";
$equip_categorie_monta.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $nbre.",key:'". $value['ID']."'},";

$equip_categorie_total=$equip_categorie_total+$value['NBRE'];
$equip_categorie_total_monta=$equip_categorie_total_monta+$value['amande'];


    
     }

     ///signal

$signale=$this->Model->getRequete("SELECT a.ID_CONTROLES_QUESTIONNAIRES AS ID, CONCAT(CONCAT(q.INFRACTIONS, ' ('),q.DESCRIPTION, ')')
 AS NOM,COUNT(q.ID_CONTROLES_QUESTIONNAIRES) as NBRE, SUM(q.MONTANT) as amande FROM `historiques` h JOIN autres_controles a ON h.ID_SIGNALEMENT=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES WHERE RAISON_ANNULATION IS NULL ".$search." ".$plaque." ".$criteres1." ".$cripaid." ".$categorie." GROUP BY a.ID_CONTROLES_QUESTIONNAIRES,q.INFRACTIONS,q.DESCRIPTION");

$signale_categorie=" ";
$signale_categorie_monta=" ";
$signale_categorie_total=0;
$signale_categorie_total_monta=0;
 
 foreach ($signale as  $value) {

$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$signale_categorie.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $monta.",key:'". $value['ID']."'},";
$signale_categorie_monta.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $nbre.",key:'". $value['ID']."'},";
      
$signale_categorie_total=$signale_categorie_total+$value['NBRE'];
$signale_categorie_total_monta=$signale_categorie_total_monta+$value['amande'];
    
     }



///comport

$comport=$this->Model->getRequete("SELECT a.ID_CONTROLES_QUESTIONNAIRES AS ID, CONCAT(CONCAT(q.INFRACTIONS, ' ('),q.DESCRIPTION, ')')
 AS NOM,COUNT(q.ID_CONTROLES_QUESTIONNAIRES) as NBRE, SUM(q.MONTANT) as amande FROM `historiques` h JOIN autres_controles a ON h.ID_COMPORTEMENT=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES WHERE RAISON_ANNULATION IS NULL ".$search." ".$plaque." ".$criteres1." ".$cripaid." ".$categorie." GROUP BY a.ID_CONTROLES_QUESTIONNAIRES,q.INFRACTIONS,q.DESCRIPTION");

$comport_categorie=" ";
$comport_categorie_monta=" ";
$comport_categorie_total=0;
$comport_categorie_total_monta=0;
 
 foreach ($comport as  $value) {
      
      
$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$comport_categorie_monta.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $monta.",key:'". $value['ID']."'},";
$comport_categorie.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $nbre.",key:'". $value['ID']."'},";
$comport_categorie_total=$comport_categorie_total+$value['NBRE'];
$comport_categorie_total_monta=$comport_categorie_total_monta+$value['amande'];
    
     }

///march

$march=$this->Model->getRequete("SELECT a.ID_CONTROLES_QUESTIONNAIRES AS ID, CONCAT(CONCAT(q.INFRACTIONS, ' ('),q.DESCRIPTION, ')')
 AS NOM,COUNT(q.ID_CONTROLES_QUESTIONNAIRES) as NBRE, SUM(q.MONTANT) as amande FROM `historiques` h JOIN autres_controles a ON h.ID_CONTROLE_MARCHANDISE=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES WHERE RAISON_ANNULATION IS NULL ".$search." ".$plaque." ".$criteres1." ".$cripaid." ".$categorie." GROUP BY a.ID_CONTROLES_QUESTIONNAIRES,q.INFRACTIONS,q.DESCRIPTION");

$march_categorie=" ";
$march_categorie_monta=" ";
$march_categorie_total=0;
$march_categorie_total_monta=0;
 
 foreach ($march as  $value) {
      
      
$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$march_categorie_monta.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $monta.",key:'". $value['ID']."'},";
$march_categorie.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $nbre.",key:'". $value['ID']."'},";
$march_categorie_total=$march_categorie_total+$value['NBRE'];
$march_categorie_total_monta=$march_categorie_total_monta+$value['amande'];
    
     }


///radar

$radar=$this->Model->getRequete("SELECT a.ID_CONTROLES_QUESTIONNAIRES AS ID, CONCAT(CONCAT(q.INFRACTIONS, ' ('),q.DESCRIPTION, ')')
 AS NOM,COUNT(q.ID_CONTROLES_QUESTIONNAIRES) as NBRE, SUM(q.MONTANT) as amande FROM `historiques` h JOIN autres_controles a ON h.ID_RADAR=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES WHERE RAISON_ANNULATION IS NULL ".$search." ".$plaque." ".$criteres1." ".$cripaid." ".$categorie." GROUP BY a.ID_CONTROLES_QUESTIONNAIRES,q.INFRACTIONS,q.DESCRIPTION");

$radar_categorie=" ";
$radar_categorie_monta=" ";
$radar_categorie_total=0;
$radar_categorie_total_monta=0;
 
 foreach ($radar as  $value) {
      
      
$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;



$radar_categorie.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $nbre.",key:'". $value['ID']."'},";
$radar_categorie_total=$radar_categorie_total+$value['NBRE'];
$radar_categorie_total_monta=$radar_categorie_total_monta+$value['amande'];
$radar_categorie_monta.="{name:'Montant : ".number_format($radar_categorie_total_monta,0,',',' ')." FBU', y:". $monta.",key:'". $value['ID']."'},";
    
     }

///parking

$parking=$this->Model->getRequete("SELECT a.ID_CONTROLES_QUESTIONNAIRES AS ID, CONCAT(CONCAT(q.INFRACTIONS, ' ('),q.DESCRIPTION, ')')
 AS NOM,COUNT(q.ID_CONTROLES_QUESTIONNAIRES) as NBRE, SUM(q.MONTANT) as amande FROM `historiques` h JOIN autres_controles a ON h.ID_PARKING=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES WHERE RAISON_ANNULATION IS NULL ".$search." ".$plaque." ".$criteres1." ".$cripaid." ".$categorie." GROUP BY a.ID_CONTROLES_QUESTIONNAIRES,q.INFRACTIONS,q.DESCRIPTION");

$parking_categorie=" ";
$parking_categorie_monta=" ";
$parking_categorie_total=0;
$parking_categorie_total_monta=0;
 
 foreach ($parking as  $value) {
      
      
$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;

$parking_categorie.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $nbre.",key:'". $value['ID']."'},";
$parking_categorie_total=$parking_categorie_total+$value['NBRE'];
$parking_categorie_total_monta=$parking_categorie_total_monta+$value['amande'];
$parking_categorie_monta.="{name:'Montant : ".number_format($parking_categorie_total_monta,0,',',' ')." FBU', y:". $monta.",key:'". $value['ID']."'},";
    
     }

///station

$station=$this->Model->getRequete("SELECT a.ID_CONTROLES_QUESTIONNAIRES AS ID, CONCAT(CONCAT(q.INFRACTIONS, ' ('),q.DESCRIPTION, ')')
 AS NOM,COUNT(q.ID_CONTROLES_QUESTIONNAIRES) as NBRE, SUM(q.MONTANT) as amande FROM `historiques` h JOIN autres_controles a ON h.ID_STATIONNEMENT=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES WHERE RAISON_ANNULATION IS NULL ".$search." ".$plaque." ".$criteres1." ".$cripaid." ".$categorie." GROUP BY a.ID_CONTROLES_QUESTIONNAIRES,q.INFRACTIONS,q.DESCRIPTION");

$station_categorie=" ";
$station_categorie_monta=" ";
$station_categorie_total=0;
$station_categorie_total_monta=0;
 
 foreach ($station as  $value) {
      
      
$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$station_categorie_monta.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $monta.",key:'". $value['ID']."'},";
$station_categorie.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $nbre.",key:'". $value['ID']."'},";
$station_categorie_total=$station_categorie_total+$value['NBRE'];
$station_categorie_total_monta=$station_categorie_total_monta+$value['amande'];
    
     }


//signale

$signale=$this->Model->getRequete("SELECT a.ID_CONTROLES_QUESTIONNAIRES AS ID, CONCAT(CONCAT(q.INFRACTIONS, ' ('),q.DESCRIPTION, ')')
 AS NOM,COUNT(q.ID_CONTROLES_QUESTIONNAIRES) as NBRE, SUM(q.MONTANT) as amande FROM `historiques` h JOIN autres_controles a ON h.ID_SIGNALEMENT=a.ID_CONTROLE_PLAQUE JOIN autres_controles_questionnaires q On a.ID_CONTROLES_QUESTIONNAIRES=q.ID_CONTROLES_QUESTIONNAIRES WHERE RAISON_ANNULATION IS NULL ".$search." ".$plaque." ".$criteres1." ".$cripaid." ".$categorie." GROUP BY a.ID_CONTROLES_QUESTIONNAIRES,q.INFRACTIONS,q.DESCRIPTION");

$signale_categorie=" ";
$signale_categorie_monta=" ";
$signale_categorie_total=0;
$signale_categorie_total_monta=0;
 
 foreach ($signale as  $value) {
      
      
$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;
$monta=($value['amande']>0) ? $value['amande'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$signale_categorie_monta.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $monta.",key:'". $value['ID']."'},";
$signale_categorie.="{name:'".str_replace("'","\'", $value['NOM'])."', y:". $nbre.",key:'". $value['ID']."'},";
$signale_categorie_total=$signale_categorie_total+$value['NBRE'];
$signale_categorie_total_monta=$signale_categorie_total_monta+$value['amande'];
    
     }


   
     $rapp="<script type=\"text/javascript\">


    Highcharts.chart('container', {
    chart: {
        type: 'line'
    },

    legend: {
        symbolWidth: 40
    },

    title: {
        text: '<b>Contrôle physique </b> du ".date('d-m-Y')." '
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
        line: {
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
                            url:\"".base_url('dashboard/Dashboard_Controle_Physique/detail')."\",
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
    name: 'Infractions (".number_format($physi_categorie_total,0,',',' ').")',
    data: [".$physi_categorie."],

    color: \"purple\"
},

{
    
    name: 'Montant (".number_format($physi_categorie_total_monta,0,',',' ')." FBU)',
    data: [".$physi_categorie_monta."],
   
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
        type: 'area'
    },
    title: {
        text: '<b>Contrôle équipement </b>  du ".date('d-m-Y')." '
    },
    subtitle: {
        text: '',
        align: 'right',
        verticalAlign: 'bottom'
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 100,
        y: 70,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Y-Axis'
        }
    },
    plotOptions: {
        area: {
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
                            url:\"".base_url('dashboard/Dashboard_Controle_Physique/detail1')."\",
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
    series: [{

        name: 'Montant (".number_format($equip_categorie_total_monta,0,',',' ')." FBU)',
        data: [".$equip_categorie_monta."]
    }, {
        name: 'Infractions (".number_format($equip_categorie_total,0,',',' ')." )',
        data: [".$equip_categorie."]
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
        text: '<b> Contrôle signalement  </b>  du ".date('d-m-Y')." '
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
url:\"".base_url('dashboard/Dashboard_Controle_Physique/detail2')."\",
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
        name:'Infractions : (".number_format($signale_categorie_total,0,',',' ').")',
        data: [".$signale_categorie."]
    },
     {
        color: '#e36903',  
        name:'Montant : (".number_format($signale_categorie_total_monta,0,',',' ')." FBU)',
        data: [".$signale_categorie_monta."]
    },
    ]

});
</script>
     ";

 $rapp3="<script type=\"text/javascript\">
    Highcharts.chart('container3', {
    chart: {
        type: 'columnpyramid'
    },
    title: {
         text: '<b> Contrôle marchandise ou passager </b> du ".date('d-m-Y')." '
    },
    colors: ['#C79D6D', '#B5927B', '#CE9B84', '#B7A58C', '#C7A58C'],
    xAxis: {
        crosshair: true,
        labels: {
            style: {
                fontSize: '14px'
            }
        },
        type: 'category'
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    tooltip: {
        valueSuffix: ' '
    },plotOptions: {
        columnpyramid: {
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
url:\"".base_url('dashboard/Dashboard_Controle_Physique/detail3')."\",
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
        
        color: 'green',
        name:'Infractions : (".number_format($march_categorie_total,0,',',' ').")',
        data: [".$march_categorie."]
    },
     {
        color: '#9f0061',  
        name:'Montant : (".number_format($march_categorie_total_monta,0,',',' ')." FBU)',
        data: [".$march_categorie_monta."]
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
        text: '<b>Contrôle comportement </b>  du ".date('d-m-Y')." '
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
                            url:\"".base_url('dashboard/Dashboard_Controle_Physique/detail4')."\",
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
    
    name: 'Infractions (".number_format($comport_categorie_total,0,',',' ').")',
    data: [".$comport_categorie."],
    dashStyle: 'DashDot',
    color: \"purple\"
},

{
    name: 'Montant (".number_format($comport_categorie_total_monta,0,',',' ')." FBU)',
    data: [".$comport_categorie_monta."],
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


  $rapp5="<script type=\"text/javascript\">
 Highcharts.chart('container5', {
   
title: {
        text: '<b>Contrôle par radar </b>  du ".date('d-m-Y')." '
    },
    subtitle: {
        text: ' '
    },
    xAxis: {
        type: 'category', 
    },
         plotOptions: {
        series: {
             pointPadding: 0.2,
            
            borderWidth: 0,
            depth: 40,
             cursor:'pointer',
             point:{
                events: {
 
 
click: function(){

 $(\"#titre\").html(\"Détails \");
                                  
            $(\"#myModal\").modal();
                                 

                  var row_count ='1000000';
                   $(\"#mytable\").DataTable({
                        \"processing\":true,
                        \"serverSide\":true,
                        \"bDestroy\": true,
                        \"oreder\":[],
                        \"ajax\":{
                            url:\"".base_url('dashboard/Dashboard_Controle_Physique/detailradar')."\",
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
             format: '{point.y:0,f}'
         },
         showInLegend: true
     }
 }, 
 credits: {
  enabled: true,
  href: \"\",
  text: \"Mediabox\"
},
      labels: {
        items: [{
            html: '',
            style: {
                left: '50px',
                top: '18px',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'black'
            }
        }]
    },
 series: [{
        type: 'pie',
        color: 'blue',
        name:'Infractions : (".number_format($radar_categorie_total_monta,0,',',' ').")',
        borderColor:\"#f00000\",
        data: [".$radar_categorie_monta."]
    },  {
        type: 'columnpyramid',
        color: 'green',
         name:'Infractions : (".number_format($radar_categorie_total,0,',',' ').")',
        data: [".$radar_categorie."],
          marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        }      
    }]
});
</script>
     ";

$rapp6="<script type=\"text/javascript\">
 Highcharts.chart('container6', {
   
title: {
        text: '<b>Contrôle de parking </b>  du ".date('d-m-Y')." '
    },
    subtitle: {
        text: ' '
    },
    xAxis: {
        type: 'category', 
    },
         plotOptions: {
        series: {
             pointPadding: 0.2,
            
            borderWidth: 0,
            depth: 40,
             cursor:'pointer',
             point:{
                events: {
 
 
click: function(){

 $(\"#titre\").html(\"Détails \");
                                  
                                   $(\"#myModal\").modal();
                                 

                  var row_count ='1000000';
                   $(\"#mytable\").DataTable({
                        \"processing\":true,
                        \"serverSide\":true,
                        \"bDestroy\": true,
                        \"oreder\":[],
                        \"ajax\":{
                            url:\"".base_url('dashboard/Dashboard_Controle_Physique/detailparking')."\",
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
             format: '{point.y:0,f}'
         },
         showInLegend: true
     }
 }, 
 credits: {
  enabled: true,
  href: \"\",
  text: \"Mediabox\"
},
      labels: {
        items: [{
            html: '',
            style: {
                left: '50px',
                top: '18px',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'black'
            }
        }]
    },
 series: [{
        type: 'pie',
        color: 'blue',
        name:'Infractions : (".number_format($parking_categorie_total_monta,0,',',' ').")',
        borderColor:\"#f00000\",
        data: [".$parking_categorie_monta."]
    },  {
        type: 'bar',
        color: 'green',
         name:'Infractions : (".number_format($parking_categorie_total,0,',',' ').")',
        data: [".$parking_categorie."],
          marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        }  
       
    }]
});
</script>
     ";

$rapp7="<script type=\"text/javascript\">
 Highcharts.chart('container7', {
   
title: {
        text: '<b>Contrôle signalement </b>  du ".date('d-m-Y')." '
    },
    subtitle: {
        text: ' '
    },
    xAxis: {
        type: 'category', 
    },
         plotOptions: {
        series: {
             pointPadding: 0.2,
            
            borderWidth: 0,
            depth: 40,
             cursor:'pointer',
             point:{
                events: {
 
 
click: function(){

 $(\"#titre\").html(\"Détails \");
                                  
                                   $(\"#myModal\").modal();
                                 

                  var row_count ='1000000';
                   $(\"#mytable\").DataTable({
                        \"processing\":true,
                        \"serverSide\":true,
                        \"bDestroy\": true,
                        \"oreder\":[],
                        \"ajax\":{
                            url:\"".base_url('dashboard/Dashboard_Controle_Physique/detailsignale')."\",
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
             format: '{point.y:0,f}'
         },
         showInLegend: true
     }
 }, 
 credits: {
  enabled: true,
  href: \"\",
  text: \"Mediabox\"
},
      labels: {
        items: [{
            html: '',
            style: {
                left: '50px',
                top: '18px',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'black'
            }
        }]
    },
 series: [{
        type: 'columnpyramid',
        color: 'blue',
        name:'Montant : (".number_format($signale_categorie_total_monta,0,',',' ').")',
        borderColor:\"#f00000\",
        data: [".$signale_categorie_monta."]
    },  {
        type: 'line',
        color: 'green',
         name:'Infractions : (".number_format($signale_categorie_total,0,',',' ').")',
        data: [".$signale_categorie."],
          marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        }  
       
    }]
});
</script>
     ";

$rapp8="<script type=\"text/javascript\">
 Highcharts.chart('container8', {
   
title: {
        text: '<b>Contrôle stationnement </b>  du ".date('d-m-Y')." '
    },
    subtitle: {
        text: ' '
    },
    xAxis: {
        type: 'category', 
    },
         plotOptions: {
        series: {
             pointPadding: 0.2,
            
            borderWidth: 0,
            depth: 40,
             cursor:'pointer',
             point:{
                events: {
 
 
click: function(){

 $(\"#titre\").html(\"Détails \");
                                  
                                   $(\"#myModal\").modal();
                                 

                  var row_count ='1000000';
                   $(\"#mytable\").DataTable({
                        \"processing\":true,
                        \"serverSide\":true,
                        \"bDestroy\": true,
                        \"oreder\":[],
                        \"ajax\":{
                            url:\"".base_url('dashboard/Dashboard_Controle_Physique/detailstation')."\",
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
             format: '{point.y:0,f}'
         },
         showInLegend: true
     }
 }, 
 credits: {
  enabled: true,
  href: \"\",
  text: \"Mediabox\"
},
      labels: {
        items: [{
            html: '',
            style: {
                left: '50px',
                top: '18px',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'black'
            }
        }]
    },
 series: [{
        type: 'column',
        color: 'blue',
        name:'Montant : (".number_format($station_categorie_total_monta,0,',',' ').")',
        borderColor:\"#f00000\",
        data: [".$station_categorie_monta."]
    },  {
        type: 'spline',
        color: 'green',
         name:'Infractions : (".number_format($station_categorie_total,0,',',' ').")',
        data: [".$station_categorie."],
          marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        }  
       
    }]
});
</script>
     ";



echo json_encode(array('rapp'=>$rapp,'rapp1'=>$rapp1,'rapp2'=>$rapp2,'rapp3'=>$rapp3,'rapp4'=>$rapp4,'rapp5'=>$rapp5,'rapp6'=>$rapp6,'rapp7'=>$rapp7,'rapp8'=>$rapp8,'select_month'=>$mois_select,'selectjour'=>$selectjour));
    }


}  
?>




