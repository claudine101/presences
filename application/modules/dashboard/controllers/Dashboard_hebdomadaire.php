
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
SELECT  e.*,a.date_absence,a.periode
    FROM employes e LEFT JOIN  absences a ON e.ID_UTILISATEUR=a.id_utilisateur
      WHERE DATE(a.date_absence) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') AND CURDATE() ".$critere." 
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
            $intrant[] =$row->NOM_EMPLOYE;
            $intrant[] =$row->PRENOM_EMPLOYE;
            $intrant[] =$row->EMAIL_EMPLOYE;
            $intrant[] =$row->TELEPHONE_EMPLOYE;
            $intrant[] =$row->periode;
            //  $intrant[] =$row->SEXE_EMPLOYE;
            $intrant[] =$row->date_absence;
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


$query_principal=" SELECT a.DESCRIPTION, e.DATE_NAISSANCE_EMPLOYE,e.SEXE_EMPLOYE,p.ID_PRESENCE,p.DATE_PRESENCE, p.QR_CODE_PRES_ID, p.ID_UTILISATEUR ,e.NOM_EMPLOYE,e.PRENOM_EMPLOYE,e.NUMERO_CNI_EMPLOYE,e.TELEPHONE_EMPLOYE,e.EMAIL_EMPLOYE FROM presences p JOIN employes e ON e.ID_UTILISATEUR=p.ID_UTILISATEUR  JOIN agences a ON a.ID_AGENCE=e.ID_AGENCE WHERE 1 ";

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
        // $critaire1="AND`STAUT`=0AND date_format(p.`DATE_PRESENCE`,'%Y-%m-%d') LIKE '%".$KEY."%'";
// '.$critaire1.'
       
        $query_secondaire=$query_principal.'  '.$critaire.' '.$criteres1.' '.$criteres3.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.''.$critaire.' '.$criteres1.' '.$criteres3.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {  
            $u++;
            $intrant=array();
            $intrant[] = $u;
            $intrant[] =$row->NOM_EMPLOYE;
            $intrant[] =$row->PRENOM_EMPLOYE;
            $intrant[] =$row->EMAIL_EMPLOYE;
            $intrant[] =$row->TELEPHONE_EMPLOYE;
            $intrant[] =$row->DESCRIPTION;
            $intrant[] =$row->DATE_PRESENCE;
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
          SUM(CASE WHEN (`STATUT`) =0 THEN 1 ELSE 0 END) AS  number_of_lates
      FROM
          presences JOIN  employes ON employes.ID_UTILISATEUR=presences.ID_UTILISATEUR JOIN agences on agences.ID_AGENCE=employes.ID_AGENCE
      WHERE 1 ".$criteres1."  ".$criteres3." AND
          `DATE_PRESENCE` >= CURDATE() - INTERVAL (WEEKDAY(CURDATE()) + 1) DAY  -- début de la semaine en cours (lundi)
          AND `DATE_PRESENCE` < CURDATE() - INTERVAL WEEKDAY(CURDATE()) DAY + INTERVAL 1 WEEK -- fin de la semaine en cours (dimanche)
      GROUP BY
          DAYOFWEEK(`DATE_PRESENCE`)
      ORDER BY
          DAYOFWEEK(`DATE_PRESENCE`);
          ");
    
    
    $retards=" ";
    $ponctuels=" ";
    $immacontrole_categorie=" ";
    $immadeclare_categorie=" ";
    $immadeclare_categoriev=" ";
    $immadeclare_categoriet=" ";
    $retard_traite=0;
    $ponctuel_traite=0;
    $presence_traite=0;
    
     foreach ($control as  $value) {
          
          $key_id1=($value['annees']>0) ? $value['annees'] : "0" ;
          $sommeretards=($value['number_of_lates']>0) ? $value['number_of_lates'] : "0" ;
          $sommeponctuals=($value['number_of_punctuals']>0) ? $value['number_of_punctuals'] : "0" ;
          $retards.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeretards.",key2:3,key:'". $key_id1."'},";
          $ponctuels.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeponctuals.",key2:2,key:'". $key_id1."'},";
    
          $retard_traite=$retard_traite+$value['number_of_lates'];
          $ponctuel_traite=$ponctuel_traite+$value['number_of_punctuals'];
        
    }
    

    $absants=$this->Model->getRequete("SELECT DATE_FORMAT(a.date_absence, '%Y-%m-%d') as mois, DAYNAME(a.date_absence) AS day_of_week, COUNT(a.id_utilisateur) AS nombre_absents
FROM absences a  LEFT JOIN employes e ON e.ID_UTILISATEUR=a.id_utilisateur
WHERE 1  AND
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
      text: '<b> Rapport  des absances jusqu\'à le   ".$titre."  </b> '
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
        }
        
        ]
    
    });
    </script>
         ";
    
    echo json_encode(array('rapp'=>$rapp, 'rapp_absent'=>$rapp_absent));
}

}
    



?>