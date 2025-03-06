
<?php
class Dashboard_hebdomadaire extends CI_Controller
{
function __construct()
{
    parent::__construct();
    $this->have_droit();
}
public function have_droit()
{
    if ($this->session->userdata('ID_PROFIL') != 2 && $this->session->userdata('ID_PROFIL') != 5 && $this->session->userdata('ID_PROFIL') != 4) {
        redirect('Login');
        }
}
function index(){

    $dattes=$this->Model->getRequete("SELECT DISTINCT date_format(presences.`DATE_PRESENCE`,'%Y') AS mois FROM presences ORDER BY  mois ASC");
    $agences=$this->Model->getRequete("SELECT ID_AGENCE, DESCRIPTION FROM agences WHERE 1");
    $data['agences']=$agences;
    

    $data['dattes']=$dattes;
    $data['agences']=$agences;


    $this->load->view('Dashboard_hebdomadaire_View',$data);
}

function detail_conges()
{
    $avant=$this->input->post('avant');
    $agence=$this->input->post('agence');
    $jour=$this->input->post('jour');
    $KEY=$this->input->post('key');
  //   $agence=$this->input->post('agence');
  //  echo($agence);
  $critaire_agence='';
  $critaire_avant='';
  
  if(!empty($agence)){
      $critaire_agence.=" AND e.`ID_AGENCE`= ".$agence." ";
  }
  $avant=$this->input->post('avant');
  
  if(!empty($avant)){
      if($avant=='AM'){
          $critaire_avant.=" AND periode LIKE  '%AM%'";
  
      }
      else{
      $critaire_avant.=" AND periode LIKE  '%PM%'";
  
      }
  
   }
  $critere = " ";
  $ID_MOTIF=$this->input->post('key2');
  $critere = "AND a.ID_MOTIF=".$ID_MOTIF." AND DATE_FORMAT(a.DATE_CONGE, '%Y-%m-%d') = '".$KEY."'";




$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal="
SELECT  e.*,a.DATE_CONGE,a.periode,ag.DESCRIPTION
    FROM employes e  LEFT JOIN  agences  ag on ag.ID_AGENCE=e.ID_AGENCE LEFT JOIN  conges a ON e.ID_UTILISATEUR=a.ID_UTILISATEUR
      WHERE 1 AND
      `DATE_CONGE` >= CURDATE() - INTERVAL (WEEKDAY(CURDATE()) + 1) DAY  -- début de la semaine en cours (lundi)
      AND `DATE_CONGE` < CURDATE() - INTERVAL WEEKDAY(CURDATE()) DAY + INTERVAL 1 WEEK -- fin de la semaine en cours (dimanche)
      
      ".$critere." 
      "   . $critaire_avant."  "   . $critaire_agence."  
";

        $limit='LIMIT 0,10';
        if($_POST['length'] != -1)
        {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $order_by='';
        if($_POST['order']['0']['column']!=0)
        {
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY ID_PRESENCE ASC'; 
        }

        $search = !empty($_POST['search']['value']) ? ("AND (NOM_EMPLOYE LIKE '%$var_search%'  OR PRENOM_EMPLOYE LIKE '%$var_search%' OR EMAIL_EMPLOYE LIKE '%$var_search%'  ) ") : '';


        $critaire='';
        if(!empty($mois) && empty($jour)){
        

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
            $source = !empty($row->PHOTO_EMPLOYE) ? $row->PHOTO_EMPLOYE : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
            $intrant[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM_EMPLOYE . ' ' . $row->PRENOM_EMPLOYE . '</td></tr></tbody></table></a>';
			$intrant[] = '<table> <tbody><tr><td>' . $row->TELEPHONE_EMPLOYE . ' ' . $row->EMAIL_EMPLOYE . '</td></tr></tbody></table></a>';
            $intrant[] =$row->DESCRIPTION;
            $intrant[] =$row->DATE_CONGE;
            $intrant[] =$row->periode;

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

function detail_absants()
{
    $avant=$this->input->post('avant');
    $agence=$this->input->post('agence');
    $jour=$this->input->post('jour');
    $KEY=$this->input->post('key');
  //   $agence=$this->input->post('agence');
  //  echo($agence);
  $critaire_agence='';
  $critaire_avant='';
  
  if(!empty($agence)){
      $critaire_agence.=" AND e.`ID_AGENCE`= ".$agence." ";
  }
  
  if(!empty($avant)){
      if($avant=='AM'){
          $critaire_avant.=" AND periode LIKE  '%AM%'";
  
      }
      else{
      $critaire_avant.=" AND periode LIKE  '%PM%'";
  
      }
  
   }
  $critere = " ";

  $critere = " AND DATE_FORMAT(a.date_absence, '%Y-%m-%d') = '".$KEY."'";




$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal="
SELECT  e.*,a.date_absence,a.periode,ag.DESCRIPTION
    FROM employes e  LEFT JOIN  agences  ag on ag.ID_AGENCE=e.ID_AGENCE LEFT JOIN  absences a ON e.ID_UTILISATEUR=a.id_utilisateur
      WHERE DATE(a.date_absence) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') AND CURDATE() ".$critere." 
      "   . $critaire_avant."  "   . $critaire_agence."  
";

        $limit='LIMIT 0,10';
        if($_POST['length'] != -1)
        {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $order_by='';
        $order_column = array('ID_PRESENCE','DATE_PRESENCE', 'STATUT');
        if($_POST['order']['0']['column']!=0)
        {
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY ID_PRESENCE ASC'; 
        }

        $search = !empty($_POST['search']['value']) ? ("AND (NOM_EMPLOYE LIKE '%$var_search%'  OR PRENOM_EMPLOYE LIKE '%$var_search%' OR EMAIL_EMPLOYE LIKE '%$var_search%'  ) ") : '';


        $critaire='';
        if(!empty($mois) && empty($jour)){
        

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
            $source = !empty($row->PHOTO_EMPLOYE) ? $row->PHOTO_EMPLOYE : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
            $intrant[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM_EMPLOYE . ' ' . $row->PRENOM_EMPLOYE . '</td></tr></tbody></table></a>';
			$intrant[] = '<table> <tbody><tr><td>' . $row->TELEPHONE_EMPLOYE . ' ' . $row->EMAIL_EMPLOYE . '</td></tr></tbody></table></a>';
            $intrant[] =$row->DESCRIPTION;
            $intrant[] =$row->date_absence;
            $intrant[] =$row->periode;

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
function details($agence=0)
{
    
  $avant=$this->input->post('avant');
  $jour=$this->input->post('jour');
  $KEY=$this->input->post('key');
//   $agence=$this->input->post('agence');
    // print_r($agence);
    // exit();
    $criteres1="";
    $criteres3="";
    
    if(!empty($agence)){
    $criteres1.=" AND a.`ID_AGENCE`= ".$agence." ";
    }
    if(!empty($avant)){
    if($avant=='AM'){
        $criteres3.=" AND TIME(`DATE_PRESENCE`)<'12:00:00' ";
    }
    else{
        $criteres3.=" AND TIME(`DATE_PRESENCE`)>='12:00:00' ";
    }
  }
$KEY2=$this->input->post('key2');
$break=explode(".",$KEY2);
$ID=$KEY2;

$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal=" SELECT  e.PHOTO_EMPLOYE,a.DESCRIPTION,
 e.DATE_NAISSANCE_EMPLOYE,e.SEXE_EMPLOYE,p.ID_PRESENCE,p.DATE_PRESENCE,
  p.QR_CODE_PRES_ID, p.ID_UTILISATEUR ,e.NOM_EMPLOYE,e.PRENOM_EMPLOYE,
  e.NUMERO_CNI_EMPLOYE,e.TELEPHONE_EMPLOYE,e.EMAIL_EMPLOYE ,p.MOTIF,p.STATUT
  FROM presences p JOIN employes e ON e.ID_UTILISATEUR=p.ID_UTILISATEUR 
   JOIN agences a ON a.ID_AGENCE=e.ID_AGENCE WHERE 1 ";


        $limit='LIMIT 0,10';
        if($_POST['length'] != -1)
        {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $order_by='';
        if($_POST['order']['0']['column']!=0)
        {
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY PRENOM_EMPLOYE  ASC'; 
        }

        $search = !empty($_POST['search']['value']) ? ("AND (NOM_EMPLOYE LIKE '%$var_search%'  OR PRENOM_EMPLOYE LIKE '%$var_search%' OR EMAIL_EMPLOYE LIKE '%$var_search%' OR TELEPHONE_EMPLOYE LIKE '%$var_search%'  ) ") : '';


        $critaire='';
        if($ID==1){  

        $critaire=" AND date_format(p.`DATE_PRESENCE`,'%Y-%m-%d') LIKE '%".$KEY."%'";

        }elseif ($ID==2) { 

          $critaire=" AND  `STATUT`=1 AND date_format(p.`DATE_PRESENCE`,'%Y-%m-%d') LIKE '%".$KEY."%'";
        }
        elseif ($ID==3) { 

          $critaire=" AND  `STATUT`=0 AND date_format(p.`DATE_PRESENCE`,'%Y-%m-%d') LIKE '%".$KEY."%'";

        }
        elseif ($ID==4) { 

            $critaire=" AND  `STATUT`=2 AND date_format(p.`DATE_PRESENCE`,'%Y-%m-%d') LIKE '%".$KEY."%'";

            }
               
       
        $query_secondaire=$query_principal.'  '.$critaire.' '.$criteres1.' '.$criteres3.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.''.$critaire.' '.$criteres1.' '.$criteres3.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {    $statut='';
            if($row->STATUT==2){
                $statut=$row->MOTIF;
            }
            elseif($row->STATUT==0){
              $statut='retard';
            }
            else{
                $statut='Ponctuel';
            }
            $u++;
            $intrant=array();
            $intrant[] = $u;
            $source = !empty($row->PHOTO_EMPLOYE) ? $row->PHOTO_EMPLOYE : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
            $intrant[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM_EMPLOYE . ' ' . $row->PRENOM_EMPLOYE . '</td></tr></tbody></table></a>';
			$intrant[] = '<table> <tbody><tr><td>' . $row->TELEPHONE_EMPLOYE . ' ' . $row->EMAIL_EMPLOYE . '</td></tr></tbody></table></a>';
            $intrant[] =$row->DESCRIPTION;
            $intrant[] =$row->DATE_PRESENCE;
            $intrant[] =$statut;


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


    public function get_rapport_user(){ 
        $agence=$this->input->post('agence');
        $avant=$this->input->post('avant');
        
        $datte="";
        $criteres1="";
        $criteres2="";
        $criteres3="";
        $criteres4="";
        $criteres5="";
        
        $categorie="";
        $titre=" ".strftime('%d-%m-%Y',strtotime(date('Y-m-d')));
        
                 if(!empty($agence)){
                    $criteres1.=" AND agences.`ID_AGENCE`= ".$agence." ";
                    $criteres4.=" AND e.`ID_AGENCE`= ".$agence." ";

        
                 }
                 if(!empty($avant)){
                    if($avant=='AM'){
                        $criteres3.=" AND TIME(`DATE_PRESENCE`)<'12:00:00' ";
                        $criteres5.=" AND  periode LIKE  '%AM%'";

        
                    }
                    else{
                    $criteres3.=" AND TIME(`DATE_PRESENCE`)>='12:00:00' ";
                    $criteres5.=" AND  periode LIKE  '%PM%'";

        
                    }
        
                 }
    
          $control=$this->Model->getRequete("SELECT
          DAYNAME(`DATE_PRESENCE`) AS day_of_week,
          COUNT(`ID_PRESENCE`) AS tout,
          DATE_FORMAT(`DATE_PRESENCE`, '%Y-%m-%d') as annees,
          (SELECT COUNT(`ID_UTILISATEUR`) FROM employes WHERE ID_UTILISATEUR NOT IN (SELECT (`ID_UTILISATEUR`) FROM presences) ) as absant,
            SUM(CASE WHEN (`STATUT`) =1 THEN 1 ELSE 0 END) AS number_of_punctuals,
        SUM(CASE WHEN (`STATUT`) =0 THEN 1 ELSE 0 END) AS  number_of_lates,
          SUM(CASE WHEN (`STATUT`) =2 THEN 1 ELSE 0 END) AS  number_of_just
      FROM
          presences JOIN  employes ON employes.ID_UTILISATEUR=presences.ID_UTILISATEUR JOIN agences on agences.ID_AGENCE=employes.ID_AGENCE
      WHERE DATE(DATE_PRESENCE) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') AND CURDATE()    ".$criteres1."  ".$criteres3." AND
          `DATE_PRESENCE` >= CURDATE() - INTERVAL (WEEKDAY(CURDATE()) + 1) DAY  -- début de la semaine en cours (lundi)
          AND `DATE_PRESENCE` < CURDATE() - INTERVAL WEEKDAY(CURDATE()) DAY + INTERVAL 1 WEEK -- fin de la semaine en cours (dimanche)
      GROUP BY
          DAYOFWEEK(`DATE_PRESENCE`)
      ORDER BY
          DAYOFWEEK(`DATE_PRESENCE`);
          ");
    
    $retards=" ";
    $ponctuels=" ";
    $justifies=" ";

    $immacontrole_categorie=" ";
    $immadeclare_categorie=" ";
    $immadeclare_categoriev=" ";
    $immadeclare_categoriet=" ";
    
    $retard_traite=0;
    $ponctuel_traite=0;
    $presence_traite=0;
    $justifies_traite=0;
    
     foreach ($control as  $value) {
          
        $key_id1=($value['annees']>0) ? $value['annees'] : "0" ;

        $sommeretards=($value['number_of_lates']>0) ? $value['number_of_lates'] : "0" ;
        $sommeponctuals=($value['number_of_punctuals']>0) ? $value['number_of_punctuals'] : "0" ;
        $sommejust=($value['number_of_just']>0) ? $value['number_of_just'] : "0" ;


        $sommeexpt=($value['tout']>0) ? $value['tout'] : "0" ;

        $retards.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeretards.",key2:3,key:'". $key_id1."'},";
        $ponctuels.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeponctuals.",key2:2,key:'". $key_id1."'},";
        $justifies.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommejust.",key2:4,key:'". $key_id1."'},";

        $immadeclare_categoriet.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeexpt.",key2:1,key:'". $key_id1."'},";
  
        $retard_traite=$retard_traite+$value['number_of_lates'];
        $ponctuel_traite=$ponctuel_traite+$value['number_of_punctuals'];
        $justifies_traite=$justifies_traite+$value['number_of_just'];

        $presence_traite=$presence_traite+$value['tout'];
        
        
    }
    

$absants=$this->Model->getRequete("SELECT DATE_FORMAT(a.date_absence, '%Y-%m-%d') as mois, DAYNAME(a.date_absence) AS day_of_week, COUNT(a.id_utilisateur) AS nombre_absents
FROM absences a  LEFT JOIN employes e ON e.ID_UTILISATEUR=a.id_utilisateur
WHERE DATE(a.date_absence) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') AND CURDATE()    AND
  `date_absence` >= CURDATE() - INTERVAL (WEEKDAY(CURDATE()) + 1) DAY  -- début de la semaine en cours (lundi)
  AND `date_absence` < CURDATE() - INTERVAL WEEKDAY(CURDATE()) DAY + INTERVAL 1 WEEK -- fin de la semaine en cours (dimanche)
".$criteres4."  ".$criteres5." 
GROUP BY
  DAYOFWEEK(`date_absence`)
ORDER BY
  DAYOFWEEK(`date_absence`);"
  );

$nombre=0;
  $donne="";

$immatraite_categories=" ";
$immacat_traites=0;

  foreach ($absants as $value) 
  {
   

         
$key_id1=($value['mois']>0) ? $value['mois'] : "0" ;
$sommeAbsants=($value['nombre_absents']>0) ? $value['nombre_absents'] : "0" ;
;
$immatraite_categories.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeAbsants.",key2:1,key:'". $key_id1."'},";

$immacat_traites=$immacat_traites+$value['nombre_absents'];

  }
       

  $rapp_absent="<script type=\"text/javascript\">
  Highcharts.chart('container1', {
 
title: {
      text: '<b> Rapport  des absences jusqu\'à le   ".$titre."  </b> '
  },
  subtitle: {
      text: ''
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


click: function()
{
$(\"#titrea\").html(\"Les absants \");
$(\"#myModala\").modal();
var row_count ='1000000';
$(\"#mytablea\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_hebdomadaire/detail_absants')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
avant:$('#avant').val(),
agence:$('#ID_AGENCE').val()
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
\"sInfoFiltered\":   \"\",
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
text: \"RECECA-INKINGI\"
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
series: [

  {
      type: 'column',
      color: 'red',
      name:'Absants: (".number_format($immacat_traites,0,',',' ').")',
      data: [".$immatraite_categories."]
  } ]
});
</script>
   ";






   $conges=$this->Model->getRequete("SELECT DATE_FORMAT(a.DATE_CONGE, '%Y-%m-%d') as mois,
   SUM(CASE WHEN (a.ID_MOTIF) =1 THEN 1 ELSE 0 END) AS conges,
          SUM(CASE WHEN (a.ID_MOTIF) =2 THEN 1 ELSE 0 END) AS  permission, 
          SUM(CASE WHEN (a.ID_MOTIF) =3 THEN 1 ELSE 0 END) AS  Surterrain,
          SUM(CASE WHEN (a.ID_MOTIF) =4 THEN 1 ELSE 0 END) AS  Mission, 
          SUM(CASE WHEN (a.ID_MOTIF) =5 THEN 1 ELSE 0 END) AS  Formation, DAYNAME(a.DATE_CONGE) AS day_of_week, COUNT(a.ID_UTILISATEUR) AS nombre_absents
   FROM conges a  LEFT JOIN employes e ON e.ID_UTILISATEUR=a.ID_UTILISATEUR
   WHERE DATE(a.DATE_CONGE) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') AND CURDATE()   AND
     `DATE_CONGE` >= CURDATE() - INTERVAL (WEEKDAY(CURDATE()) + 1) DAY  -- début de la semaine en cours (lundi)
     AND `DATE_CONGE` < CURDATE() - INTERVAL WEEKDAY(CURDATE()) DAY + INTERVAL 1 WEEK -- fin de la semaine en cours (dimanche)
   ".$criteres4."  ".$criteres5." 
   GROUP BY
     DAYOFWEEK(`DATE_CONGE`)
   ORDER BY
     DAYOFWEEK(`DATE_CONGE`);"
     );
   
     $nombre=0;
     $donne="";
     
     $conge_categories=" ";
     $conge_traites=0;
     
     $permission_categories=" ";
     $permission_traites=0;
     
     $terrain_categories=" ";
     $terrain_traites=0;
     
     $mission_categories=" ";
     $mission_traites=0;
     
     $formation_categories=" ";
     $formation_traites=0;
     
     foreach ($conges as $value) 
     { 
     $key_id1=($value['mois']>0) ? $value['mois'] : "0" ;
     $sommeConges=($value['conges']>0) ? $value['conges'] : "0" ;;
     $conge_categories.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeConges.",key2:1,key:'". $key_id1."'},";
     $conge_traites=$conge_traites+$value['conges'];
     
     
     $sommePermissions=($value['permission']>0) ? $value['permission'] : "0" ;
     $permission_categories.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommePermissions.",key2:2,key:'". $key_id1."'},";
     $permission_traites=$permission_traites+$value['permission'];
     
     $sommeTerrains=($value['Surterrain']>0) ? $value['Surterrain'] : "0" ;
     $terrain_categories.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeTerrains.",key2:3,key:'". $key_id1."'},";
     $terrain_traites=$terrain_traites+$value['Surterrain'];
     
     $sommeMissions=($value['Mission']>0) ? $value['Mission'] : "0" ;
     $mission_categories.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeMissions.",key2:4,key:'". $key_id1."'},";
     $mission_traites=$mission_traites+$value['Mission'];
     
     $sommeFormations=($value['Formation']>0) ? $value['Formation'] : "0" ;
     $formation_categories.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeFormations.",key2:5,key:'". $key_id1."'},";
     $formation_traites=$formation_traites+$value['Formation'];
     
     
     }
       
          
   
     $rapp_conge="<script type=\"text/javascript\">
     Highcharts.chart('container2', {
    
   title: {
         text: '<b> Rapport des absences justifiées jusqu\'à le   ".$titre."  </b> '
     },
     subtitle: {
         text: ''
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
   
   
   click: function()
   {
        if(this.key2==1){
        $(\"#titreb\").html(\" Détails de tous les employés en congé \");
        }else if(this.key2==2){
        $(\"#titreb\").html(\" Détails de tous les employés malades\");
        }
        else if(this.key2==3){
        $(\"#titreb\").html(\" Détails de tous les employés sur le terrain\");
        }
        else if(this.key2==4){
        $(\"#titreb\").html(\"Détails de tous les employés en mission\");
        }
        else{
        $(\"#titreb\").html(\"Détails de tous les employés en formation \");   
        }
   $(\"#myModalb\").modal();
   var row_count ='1000000';
   $(\"#mytableb\").DataTable({
   \"processing\":true,
   \"serverSide\":true,
   \"bDestroy\": true,
   \"oreder\":[],
   \"ajax\":{
   url:\"".base_url('dashboard/Dashboard_hebdomadaire/detail_conges')."\",
   type:\"POST\",
   data:{
   key:this.key,
   key2:this.key2,
   avant:$('#avant').val(),
   agence:$('#ID_AGENCE').val()
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
   \"sInfoFiltered\":   \"\",
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
   text: \"RECECA-INKINGI\"
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
   series: [
{
 type: 'column',
color: '#8FBC8F',
 name:'En congé: (".number_format($conge_traites,0,',',' ').")',
 data: [".$conge_categories."]
} ,
 {
 type: 'column',
color: '#A9A9A9',
 name:'Malades: (".number_format($permission_traites,0,',',' ').")',
 data: [".$permission_categories."]
},{
 type: 'column',
color: '#FFA07A',
 name:'Sur  terrain: (".number_format($terrain_traites,0,',',' ').")',
 data: [".$terrain_categories."]
},
{
 type: 'column',
color: '#4682B4',
 name:'En mission: (".number_format($mission_traites,0,',',' ').")',
 data: [".$mission_categories."]
},
{
 type: 'column',
color: '#FFD700',
 name:'Formation: (".number_format($formation_traites,0,',',' ').")',
 data: [".$formation_categories."]
}
]
   });
   </script>
      ";
   


$rapp="<script type=\"text/javascript\">
        Highcharts.chart('container', {
       
    chart: {
            type: 'column'
        },
        title: {
            text: '<b> Rapport  des presences jusqu\'à le   ".$titre." </b>'
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
    \"order\":[[1,'DESC']],
    \"ajax\":{
    url:\"".base_url('dashboard/Dashboard_hebdomadaire/details/' . $this->input->post('agence'))."\",
    type:\"POST\",
    data:{
    key:this.key,
    key2:this.key2,
    agance:$('#ID_AGENCE').val(),
    avant:$('#avant').val(),
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
    \"sInfoFiltered\":   \"\",
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
      text: \"RECECA-INKINGI\"
    },
    
        series: [
        
        {
            color: 'orange',
            name:'Retards : (".number_format($retard_traite,0,',',' ').")',
            data: [".$retards."]
        },
         {
            color: 'green',
             name:'Ponctuels: (".number_format($ponctuel_traite,0,',',' ').")', 
            data: [".$ponctuels."]
        },
     {
        color: '#9ACD32',
         name:'Retard justifies: (".number_format($justifies_traite,0,',',' ').")', 
        data: [".$justifies."]
    }
        
        ]
    
    });
    </script>
         ";
    
    echo json_encode(array('rapp'=>$rapp, 'rapp_absent'=>$rapp_absent, 'rapp_conge'=>$rapp_conge));
}

}
    



?>