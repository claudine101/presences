
<?php
 /// EDMOND :dashboard des Immatriculation
class Dashboard_Immatriculation_obr extends CI_Controller
      {
function index(){

$dattes=$this->Model->getRequete("SELECT DISTINCT date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y') AS mois FROM obr_immatriculations_voitures ORDER BY  mois ASC");
  
$data['dattes']=$dattes;
$this->load->view('Dashboard_Imatriculation_obr_View',$data);
     }

function detail()
    {
    
  $mois=$this->input->post('mois');
  $jour=$this->input->post('jour');
 $KEY=$this->input->post('key');
        
$criteres_date="";
 
        
if(!empty($mois)){

$criteres_date.=" AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y')='".$mois."'"; 
        }

if(!empty($jour)){

$criteres_date.=" AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m')='".$jour."'";
        }



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal=" SELECT `NUMERO_CARTE_ROSE`,`NUMERO_PLAQUE`,`MARQUE_VOITURE`,`NOM_PROPRIETAIRE`,`PRENOM_PROPRIETAIRE`,`TELEPHONE`,`PROVINCE`,`ANNEE_FABRICATION`,`MODELE_VOITURE` FROM `obr_immatriculations_voitures` WHERE 1 ".$criteres_date." ";

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

        $search = !empty($_POST['search']['value']) ? ("AND (NUMERO_CARTE_ROSE LIKE '%$var_search%'  OR NUMERO_PLAQUE LIKE '%$var_search%' OR MARQUE_VOITURE LIKE '%$var_search%' OR NOM_PROPRIETAIRE LIKE '%$var_search%' OR PRENOM_PROPRIETAIRE LIKE '%$var_search%' OR PROVINCE LIKE '%$var_search%' ) ") : '';   

     

        
   $critaire=" ";
     if(!empty($mois) && empty($jour)){
      
        $critaire="  AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m')='".$KEY."'";
        }
        elseif(!empty($mois) && !empty($jour)){
      

        $critaire="  AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m-%d')='".$KEY."'";

        }else{
        $critaire="  AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y')='".$KEY."'";
        }
        
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
        $intrant[] =$row->NOM_PROPRIETAIRE."  ".$row->PRENOM_PROPRIETAIRE;
         $intrant[] =$row->TELEPHONE;
          $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_CARTE_ROSE;
         $intrant[] =$row->MODELE_VOITURE;
         $intrant[] =$row->PROVINCE;
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
 $KEY=$this->input->post('key');
 $KEY2=$this->input->post('key2');
$break=explode(".",$KEY2);
$ID=$KEY2;
        
$criteres_date="";
if( empty($mois)){

$mois=date('Y');
$criteres_date.=" ";
        }  
        
if(!empty($mois)){

$criteres_date.=" AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y')='".$mois."'"; 
        }

if(!empty($jour)){

$criteres_date.=" AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m')='".$jour."'";
        }



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal=" SELECT `NUMERO_CARTE_ROSE`,`NUMERO_PLAQUE`,`MARQUE_VOITURE`,`NOM_PROPRIETAIRE`,`PRENOM_PROPRIETAIRE`,`TELEPHONE`,`PROVINCE`,`ANNEE_FABRICATION`,`MODELE_VOITURE` FROM `obr_immatriculations_voitures` WHERE 1 ".$criteres_date." ";

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

        $search = !empty($_POST['search']['value']) ? ("AND (NUMERO_CARTE_ROSE LIKE '%$var_search%'  OR NUMERO_PLAQUE LIKE '%$var_search%' OR MARQUE_VOITURE LIKE '%$var_search%' OR NOM_PROPRIETAIRE LIKE '%$var_search%' OR PRENOM_PROPRIETAIRE LIKE '%$var_search%' OR PROVINCE LIKE '%$var_search%' ) ") : '';   



        $critaire=" AND `CATEGORIE_USAGE`='".$KEY."'";


       
        
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
        $intrant[] =$row->NOM_PROPRIETAIRE."  ".$row->PRENOM_PROPRIETAIRE;
         $intrant[] =$row->TELEPHONE;
          $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_CARTE_ROSE;
         $intrant[] =$row->MODELE_VOITURE;
         $intrant[] =$row->PROVINCE;
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
 $KEY=$this->input->post('key');
 $KEY2=$this->input->post('key2');
$break=explode(".",$KEY2);
$ID=$KEY2;
        
$criteres_date="";
if( empty($mois)){


$criteres_date.=" ";
        }  
        
if(!empty($mois)){

$criteres_date.=" AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y')='".$mois."'"; 
        }

if(!empty($jour)){

$criteres_date.=" AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m')='".$jour."'";
        }



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal=" SELECT `NUMERO_CARTE_ROSE`,`NUMERO_PLAQUE`,`MARQUE_VOITURE`,`NOM_PROPRIETAIRE`,`PRENOM_PROPRIETAIRE`,`TELEPHONE`,`PROVINCE`,`ANNEE_FABRICATION`,`MODELE_VOITURE` FROM `obr_immatriculations_voitures` WHERE 1 ".$criteres_date." ";

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

        $search = !empty($_POST['search']['value']) ? ("AND (NUMERO_CARTE_ROSE LIKE '%$var_search%'  OR NUMERO_PLAQUE LIKE '%$var_search%' OR MARQUE_VOITURE LIKE '%$var_search%' OR NOM_PROPRIETAIRE LIKE '%$var_search%' OR PRENOM_PROPRIETAIRE LIKE '%$var_search%' OR PROVINCE LIKE '%$var_search%' ) ") : '';   

     

       $critaire='';


        if(!empty($mois) && empty($jour)){
      
        if($ID==1){  

        $critaire="  AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m')='".$KEY."'";


        }elseif ($ID==2) { 

          $critaire=" AND `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from assurances_vehicules WHERE 1 ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m')='".$KEY."'";
        }
        elseif ($ID==3) {

            $critaire=" AND `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from otraco_controles WHERE 1 ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m')='".$KEY."'";
        }
         elseif ($ID==4) {

        $critaire=" AND `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from pj_declarations WHERE 1 ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m')='".$KEY."'";
        }
         elseif ($ID==5) {

        $critaire=" AND `NUMERO_PLAQUE` NOT IN (SELECT NUMERO_PLAQUE from historiques WHERE ID_IMMATRICULATIO_PEINE IS NOT NULL ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m')='".$KEY."'";
        }
        elseif ($ID==6) {

        $critaire=" AND `NUMERO_PLAQUE` IN (SELECT NUMERO_PLAQUE from historiques WHERE ID_IMMATRICULATIO_PEINE IS NOT NULL ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m')='".$KEY."'";
        }
        }
        
        elseif(!empty($mois) && !empty($jour)){
        if($ID==1){  

        $critaire="  AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m-%d')='".$KEY."'";


        }elseif ($ID==2) { 

          $critaire=" AND `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from assurances_vehicules WHERE 1 ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m-%d')='".$KEY."'";
        }
        elseif ($ID==3) {

            $critaire=" AND `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from otraco_controles WHERE 1 ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m-%d')='".$KEY."'";
        } 
        elseif ($ID==4) {

            $critaire=" AND `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from pj_declarations WHERE 1 ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m-%d')='".$KEY."'";
        } elseif ($ID==5) {

            $critaire=" AND `NUMERO_PLAQUE` NOT IN (SELECT NUMERO_PLAQUE from historiques WHERE ID_IMMATRICULATIO_PEINE IS NOT NULL ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m-%d')='".$KEY."'";
        }
        elseif ($ID==6) {

            $critaire=" AND `NUMERO_PLAQUE` IN (SELECT NUMERO_PLAQUE from historiques WHERE ID_IMMATRICULATIO_PEINE IS NOT NULL ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m-%d')='".$KEY."'";
        }   
        }else{


                    if($ID==1){  

        $critaire="  AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y')='".$KEY."'";


        }elseif ($ID==2) { 

          $critaire=" AND `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from assurances_vehicules WHERE 1 ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y')='".$KEY."'";
        }
        elseif ($ID==3) {

            $critaire=" AND `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from otraco_controles WHERE 1 ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y')='".$KEY."'";
        }
         elseif ($ID==4) {

        $critaire=" AND `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from pj_declarations WHERE 1 ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y')='".$KEY."'";
        }
        elseif ($ID==5) {

        $critaire=" AND `NUMERO_PLAQUE` NOT IN (SELECT NUMERO_PLAQUE from historiques WHERE ID_IMMATRICULATIO_PEINE IS NOT NULL ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y')='".$KEY."'";
        }
      elseif ($ID==6) {

        $critaire=" AND `NUMERO_PLAQUE`  IN (SELECT NUMERO_PLAQUE from historiques WHERE ID_IMMATRICULATIO_PEINE IS NOT NULL ) AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y')='".$KEY."'";
        }
        }
        
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
        $intrant[] =$row->NOM_PROPRIETAIRE."  ".$row->PRENOM_PROPRIETAIRE;
         $intrant[] =$row->TELEPHONE;
          $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_CARTE_ROSE;
         $intrant[] =$row->MODELE_VOITURE;
         $intrant[] =$row->PROVINCE;
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


$datte="";
$criteres1="";
$criteres2="";
$categorie="";

if
(empty($mois)){

$categorie="date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y')";
$criteres1.="";
}
if
(!empty($mois)){


$criteres1.=" AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y')='".$mois."'";

$categorie="date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m')";


  }

  if(!empty($jour)){
     $criteres1.=" AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m')= '".$jour."'  ";


    $categorie="date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m-%d')";
    
         }
if(!empty($heure)){
     $criteres1.=" AND date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m-%d')= '".$heure."'  ";

$categorie="date_format(obr_immatriculations_voitures.`DATE_INSERTION`,'%Y-%m-%d')";
    
         }
  $datte=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(obr_immatriculations_voitures.`DATE_INSERTION`, "%Y-%m") as mois from obr_immatriculations_voitures where DATE_FORMAT(obr_immatriculations_voitures.`DATE_INSERTION`, "%Y")="'.$mois.'" ORDER BY mois DESC');

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

////
$datjour=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(obr_immatriculations_voitures.DATE_INSERTION, "%Y-%m-%d") as mois from obr_immatriculations_voitures where DATE_FORMAT(obr_immatriculations_voitures.DATE_INSERTION, "%Y-%m")="'.$jour.'" ORDER BY mois DESC');

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


      $control=$this->Model->getRequete("SELECT DISTINCT ".$categorie." AS mois,COUNT(`ID_IMMATRICULATION`) AS NBRE,(SELECT COUNT(ID_IMMATRICULATION) FROM obr_immatriculations_voitures WHERE `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from assurances_vehicules WHERE 1 ) AND ".$categorie."=mois ) as assure,(SELECT COUNT(ID_IMMATRICULATION) FROM obr_immatriculations_voitures WHERE `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from otraco_controles WHERE 1 ) AND ".$categorie."=mois ) as controle,(SELECT COUNT(ID_IMMATRICULATION) FROM obr_immatriculations_voitures WHERE `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from pj_declarations WHERE 1 ) AND ".$categorie."=mois ) as declares,(SELECT COUNT(ID_IMMATRICULATION) FROM obr_immatriculations_voitures WHERE `NUMERO_PLAQUE` NOT IN (SELECT NUMERO_PLAQUE from historiques WHERE ID_IMMATRICULATIO_PEINE IS NOT NULL ) AND ".$categorie."=mois ) as non_controle,(SELECT COUNT(ID_IMMATRICULATION) FROM obr_immatriculations_voitures WHERE `NUMERO_PLAQUE`  IN (SELECT NUMERO_PLAQUE from historiques WHERE ID_IMMATRICULATIO_PEINE IS NOT NULL ) AND ".$categorie."=mois ) as controle  FROM obr_immatriculations_voitures WHERE 1 ".$criteres1."   GROUP BY mois ORDER BY mois ASC");
 
 $immatr=$this->Model->getRequete("SELECT DISTINCT ".$categorie." AS mois,COUNT(`ID_IMMATRICULATION`) AS NBRE FROM obr_immatriculations_voitures WHERE 1 ".$criteres1." GROUP BY mois ORDER BY mois ASC");





$immatr_categorie=" ";
$immatr_total=0;

 foreach ($immatr as  $value) {
      
      
$key_id1=($value['mois']>0) ? $value['mois'] : "0" ;
$somme=($value['NBRE']>0) ? $value['NBRE'] : "0" ;
$immatr_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $somme.",key:'". $key_id1."'},";
$immatr_total=$immatr_total+$value['NBRE'];
     
     }


$immacat=$this->Model->getRequete("SELECT DISTINCT `CATEGORIE_USAGE` AS NAME, COUNT(`ID_IMMATRICULATION`) AS NBRE FROM `obr_immatriculations_voitures` WHERE 1 ".$criteres1." GROUP BY NAME ORDER BY NAME DESC");
$immacat_categorie=" ";
$immacat_total=0;

 foreach ($immacat as  $value) {
      
      
$key_id1=(!empty($value['NAME'])) ? $value['NAME'] : "null" ;
$somme=($value['NBRE']>0) ? $value['NBRE'] : "0" ;
$immacat_categorie.="{name:'".str_replace("'","\'", $value['NAME'])." : ". $somme."', y:". $somme.",key:'". $key_id1."'},";

$immacat_total=$immacat_total+$value['NBRE'];
     
     }


$immatraite_categorie=" ";
$immaassure_categorie=" ";     
$immacontrole_categorie=" ";
$immadeclare_categorie=" ";
$immadenon_categorie=" ";
$immadenon_categoriev=" ";
$immatr_sommtraite=0;
$immatr_sommeassur=0;
$immatr_sommedecl=0;
$immatr_sommecontrol=0;
$immatr_noncontrol=0;
$immatr_noncontrolv=0;

 foreach ($control as  $value) {
      
      
$key_id1=($value['mois']>0) ? $value['mois'] : "0" ;
$sommtraite=($value['NBRE']>0) ? $value['NBRE'] : "0" ;
$sommecontrol=($value['controle']>0) ? $value['controle'] : "0" ;
$sommeassur=($value['assure']>0) ? $value['assure'] : "0" ;
$sommedecl=($value['declares']>0) ? $value['declares'] : "0" ;
$sommenon=($value['non_controle']>0) ? $value['non_controle'] : "0" ; 
$sommenonv=($value['controle']>0) ? $value['controle'] : "0" ;
$immatraite_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $sommtraite.",key2:1,key:'". $key_id1."'},";
$immaassure_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $sommeassur.",key2:2,key:'". $key_id1."'},";
$immacontrole_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $sommecontrol.",key2:3,key:'". $key_id1."'},";
$immadeclare_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:".$sommedecl.",key2:4,key:'". $key_id1."'},";
$immadenon_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:".$sommenon.",key2:5,key:'". $key_id1."'},";
$immadenon_categoriev.="{name:'".str_replace("'","\'", $value['mois'])."', y:".$sommenonv.",key2:6,key:'". $key_id1."'},";
$immatr_sommtraite=$immatr_sommtraite+$value['NBRE'];
$immatr_sommecontrol=$immatr_sommecontrol+$value['controle'];
$immatr_sommeassur=$immatr_sommeassur+$value['assure'];
$immatr_sommedecl=$immatr_sommedecl+$value['declares'];
$immatr_noncontrol=$immatr_noncontrol+$value['non_controle'];
$immatr_noncontrolv=$immatr_noncontrolv+$value['controle'];
     
     }

   
     $rapp="<script type=\"text/javascript\">
    Highcharts.chart('container', {
    chart: {
        type: 'columnpyramid'
    },
    title: {
        text: '<b>  Enregistrement des Immatriculations  </b><br>  Le ".date('d-m-Y')." '
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
$(\"#titre\").html(\"Détail \");
$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Immatriculation_obr/detail')."\",
type:\"POST\",
data:{
key:this.key,
 mois:$('#mois').val(),
jour:$('#jour').val(),
heure:$('#heure').val(), 

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
        name:'Immatriculation : (".number_format($immatr_total,0,',',' ').")',
        data: [".$immatr_categorie."]
    },
    
    ]
});
</script>
     ";

     $rapp1="<script type=\"text/javascript\">

   Highcharts.chart('container1', {
           chart: {
        type: 'pie',
       
    },
    title: {
        text: '<b>Immatriculation  par catégories  </b><br>  Le ".date('d-m-Y')." '
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
$(\"#titre\").html(\"Détail \");
$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Immatriculation_obr/detail1')."\",
type:\"POST\",
data:{
key:this.key,
 mois:$('#mois').val(),
jour:$('#jour').val(),
heure:$('#heure').val(),

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
         showInLegend: true
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
      data: [".$immacat_categorie."]
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
        text: '<b>Status des Immatriculations  </b><br> Rapport du ".date('d-m-Y')." '
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
$(\"#titre\").html(\"Détail \");
$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Immatriculation_obr/detail2')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
 mois:$('#mois').val(),
jour:$('#jour').val(),
heure:$('#heure').val(),

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
        name:'Immatriculation enregistrée : (".number_format($immatr_sommtraite,0,',',' ').")',
        data: [".$immatraite_categorie."]
    },
     {
        color: 'orange',
         name:'Immatriculation avec  assurence  : (".number_format($immatr_sommeassur,0,',',' ').")',
        data: [".$immaassure_categorie."]
    },
    {
        color: 'blue',
        name:'Immatriculation avec contrôle technique  : (".number_format($immatr_sommecontrol,0,',',' ').")',
        data: [".$immacontrole_categorie."]
    },   
    {
        color: '#01845d',
        name:'Immatriculation declaré volé  : (".number_format($immatr_sommedecl,0,',',' ').")',
        data: [".$immadeclare_categorie."]
    },
     {
        color: '#f400da',
        name:'Immatriculation contrôlé : (".number_format($immatr_noncontrolv,0,',',' ').")',
        data: [".$immadenon_categoriev."]
    },
    {
        color: '#000000',
        name:'Immatriculation non encore contrôlé  : (".number_format($immatr_noncontrol,0,',',' ').")',
        data: [".$immadenon_categorie."]
    }
    ]

});
</script>
     ";


echo json_encode(array('rapp'=>$rapp,'rapp1'=>$rapp1,'rapp2'=>$rapp2,'select_month'=>$mois_select,'selectjour'=>$selectjour));
    }


}
?>






