
<?php
class Dashboard_hebdomadaires extends CI_Controller
      {
        function __construct()
        {
            parent::__construct();
            $this->have_droit();
        }
        public function have_droit()
        {
            if ($this->session->userdata('ID_PROFIL') != 3 && $this->session->userdata('ID_PROFIL') != 2  && $this->session->userdata('ID_PROFIL') != 5) {
                redirect('Login');
           }
           
        }
        function index(){

                $dattes=$this->Model->getRequeteOne("SELECT * FROM utilisateurs u JOIN employes e ON e.ID_UTILISATEUR=u.ID_UTILISATEUR WHERE  u.ID_UTILISATEUR=".$this->session->userdata('ID_UTILISATEUR')."");
		        $data['motif'] = $this->Modele->getRequete('SELECT * FROM motif WHERE 1 order by ID_MOTIF ASC');
                $absants=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre FROM absences WHERE  DATE_FORMAT(date_absence, '%Y-%m-%d') = CURDATE() AND  id_utilisateur=".$this->session->userdata('ID_UTILISATEUR')."");
                
                $nbres=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre FROM presences WHERE  DATE_FORMAT(DATE_PRESENCE, '%Y-%m-%d') = CURDATE() AND  ID_UTILISATEUR=".$this->session->userdata('ID_UTILISATEUR')."");
                $data['nbre']=$nbres['Nbre'];
                $data['data']=$dattes;
                
                $data['nbre']=( $absants['Nbre']+$nbres['Nbre']);

                $this->load->view('Profil_View',$data);
        }
    
    public function get_rapport_user(){ 

    $avant=$this->input->post('avant');
    $critaire_avant='';
    $critaire_avants='';

    if(!empty($avant)){
        if($avant=='AM'){
            $critaire_avant.=" AND TIME(`DATE_PRESENCE`)<='12:00:00' ";
            $critaire_avants.=" AND  periode LIKE  '%AM%'";
        }
        else{
        $critaire_avant.=" AND TIME(`DATE_PRESENCE`)>'12:00:00' ";
        $critaire_avants.=" AND  periode LIKE  '%PM%'";
        }
     }

    $datte="";
    $criteres1="";
    $criteres2="";
    
    $categorie="";
    $titre="".strftime('%d-%m-%Y',strtotime(date('Y-m-d')));
             
        
    
          $control=$this->Model->getRequete("SELECT
             MONTHNAME(`DATE_PRESENCE`) AS day_of_week,
              COUNT(`ID_PRESENCE`) AS tout,
              DATE_FORMAT(`DATE_PRESENCE`, '%m') as annees,
              (SELECT COUNT(`ID_UTILISATEUR`) FROM employes WHERE ID_UTILISATEUR NOT IN (SELECT (`ID_UTILISATEUR`) FROM presences) ) as absant,
             SUM(CASE WHEN (`STATUT`) =1 THEN 1 ELSE 0 END) AS number_of_punctuals,
          SUM(CASE WHEN (`STATUT`) =0 THEN 1 ELSE 0 END) AS  number_of_lates,
          SUM(CASE WHEN (`STATUT`) =2 THEN 1 ELSE 0 END) AS  number_of_just

          FROM
              presences JOIN  employes ON employes.ID_UTILISATEUR=presences.ID_UTILISATEUR JOIN agences on agences.ID_AGENCE=employes.ID_AGENCE
          WHERE presences.ID_UTILISATEUR= ".$this->session->userdata('ID_UTILISATEUR')." ". $critaire_avant."
          GROUP BY
              MONTH(`DATE_PRESENCE`)
          ORDER BY
              MONTH(`DATE_PRESENCE`);
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
    $nbres=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre FROM presences WHERE  DATE_FORMAT(DATE_PRESENCE, '%Y-%m-%d') = CURDATE() AND  ID_UTILISATEUR=".$this->session->userdata('ID_UTILISATEUR')."");
    $nbre=$nbres['Nbre'];

    $rapp="<script type=\"text/javascript\">
    Highcharts.chart('container', {
   
chart: {
        type: 'column'
    },
    title: {
        text: '<b> Rapport  de mes presences  jusqu\'à le ".$titre." </b> '
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
url:\"".base_url('dashboard/Dashboard_hebdomadaires/detail/' . $this->input->post('agence'))."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
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
  text: \"RECECA-INKINGI\"
},

    series: [

    {
        color: 'orange',
        name:'Retard : (".number_format($retard_traite,0,',',' ').")',
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




    
    

   $controlabsants=$this->Model->getRequete("SELECT DATE_FORMAT(a.date_absence, '%m') as mois, MONTHNAME(a.date_absence) AS day_of_week, COUNT(a.id_utilisateur) AS nombre_absents
   FROM absences a  LEFT JOIN employes e ON e.ID_UTILISATEUR=a.id_utilisateur
   WHERE DATE(a.date_absence) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') AND CURDATE() AND a.id_utilisateur= ".$this->session->userdata('ID_UTILISATEUR')." ".$critaire_avants."
   GROUP BY mois
   ORDER BY mois");

     $retards=" ";
    $ponctuels=" ";
    $immacontrole_categorie=" ";
    $immadeclare_categorie=" ";
    $immadeclare_categoriev=" ";
    $immadeclare_categoriet=" ";
    $retard_traite=0;
    $ponctuel_traite=0;
    $presence_traite=0;
    
     foreach ($controlabsants as  $value) {
          
          $key_id1=($value['mois']>0) ? $value['mois'] : "0" ;
          $sommeretards=($value['nombre_absents']>0) ? $value['nombre_absents'] : "0" ;
          $sommeponctuals=($value['nombre_absents']>0) ? $value['nombre_absents'] : "0" ;
        
          $retards.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeretards.",key2:3,key:'". $key_id1."'},";
          $ponctuels.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeponctuals.",key2:2,key:'". $key_id1."'},";
        //   $immadeclare_categoriet.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeexpt.",key2:1,key:'". $key_id1."'},";
    
          $retard_traite=$retard_traite+$value['nombre_absents'];
          $ponctuel_traite=$ponctuel_traite+$value['nombre_absents'];
          
        
    }

         $rapp_absant="<script type=\"text/javascript\">
        Highcharts.chart('container1', {
       
    chart: {
            type: 'column'
        },
        title: {
            text: '<b> Rapport de mes absences jusqu\'à le   ".$titre." </b>'
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
    $(\"#titre1\").html(\"Détail \");
    $(\"#myModal1\").modal();
    var row_count ='1000000';
    $(\"#mytable1\").DataTable({
    \"processing\":true,
    \"serverSide\":true,
    \"bDestroy\": true,
    \"order\":[[1,'DESC']],
    \"ajax\":{
    url:\"".base_url('dashboard/Dashboard_hebdomadaires/detail_absant/' . $this->input->post('agence'))."\",
    type:\"POST\",
    data:{
    key:this.key,
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
      text: \"RECECA-INKINGI\"
    },
    
        series: [
       
        {
            color: 'red',
            name:'Absants : (".number_format($retard_traite,0,',',' ').")',
            data: [".$retards."]
        }
        
        ]
    
    });
    </script>
         ";
    


$controlconges=$this->Model->getRequete("SELECT DATE_FORMAT(a.DATE_CONGE, '%m') as mois, MONTHNAME(a.DATE_CONGE) AS day_of_week,
 SUM(CASE WHEN (a.ID_MOTIF) =1 THEN 1 ELSE 0 END) AS conges,
          SUM(CASE WHEN (a.ID_MOTIF) =2 THEN 1 ELSE 0 END) AS  permission, 
          SUM(CASE WHEN (a.ID_MOTIF) =3 THEN 1 ELSE 0 END) AS  Surterrain,
          SUM(CASE WHEN (a.ID_MOTIF) =4 THEN 1 ELSE 0 END) AS  Mission, 
          SUM(CASE WHEN (a.ID_MOTIF) =5 THEN 1 ELSE 0 END) AS  Formation, COUNT(a.ID_UTILISATEUR) AS nombre_absents
FROM conges a  LEFT JOIN employes e ON e.ID_UTILISATEUR=a.ID_UTILISATEUR
WHERE DATE(a.DATE_CONGE) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') AND CURDATE() AND a.ID_UTILISATEUR= ".$this->session->userdata('ID_UTILISATEUR')." ".$critaire_avants."
GROUP BY mois
ORDER BY mois");

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

foreach ($controlconges as $value) 
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
    
 chart: {
         type: 'column'
     },
     title: {
         text: '<b> Rapport de mes absences justifiées jusqu\'à le   ".$titre." </b>'
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
 if(this.key2==1){
$(\"#titre2\").html(\" Détails de tous les jours où je suis en congé \");
}else if(this.key2==2){
$(\"#titre2\").html(\"  Détails de tous les jours où je suis malade\");
}
else if(this.key2==3){
$(\"#titre2\").html(\"Détails de tous les jours où je suis sur le terrain\");
}
else if(this.key2==4){
$(\"#titre2\").html(\"Détails de tous les jours où je suis en mission\");
}
else{
 $(\"#titre2\").html(\"Détails de tous les jours où je suis en formation \");   
}
 $(\"#myModal2\").modal();
 var row_count ='1000000';
 $(\"#mytable2\").DataTable({
 \"processing\":true,
 \"serverSide\":true,
 \"bDestroy\": true,
 \"order\":[[1,'DESC']],
 \"ajax\":{
 url:\"".base_url('dashboard/Dashboard_hebdomadaires/detail_conge/' . $this->input->post('agence'))."\",
 type:\"POST\",
 data:{
 key:this.key,
 key2:this.key2,
 avant:$('#avant').val(),
 
 
 }
 },
 lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
 pageLength: 10,
 \"columnDefs\":[{
 \"targets\":[],
 \"orderable\":true
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
   text: \"RECECA-INKINGI\"
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
 name:'Malade: (".number_format($permission_traites,0,',',' ').")',
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
 
 echo json_encode(array('rapp'=>$rapp, 'rapp_absant'=>$rapp_absant, 'rapp_conge'=>$rapp_conge,'nbres'=>$nbre));
}




    function presenter()
	{
        date_default_timezone_set('Africa/Bujumbura');
		$data = $this->Modele->getOne('qr_code_presences', array('IS_ACTIVE' =>1));
       // Obtenir la date et l'heure actuelles
        $date_arrive = $this->Modele->getOne('arrives', array('ID_ARRIVE' => $this->session->userdata('ID_ARRIVE')));
        
        $date_arrive_pm = $this->Modele->getOne('arrives_pm', array('ID_ARRIVE_PM' => $this->session->userdata('ID_ARRIVE_PM')));
       
        $targetTimeAM = ($date_arrive['HEURES']);
        $targetTimePM = new DateTime($date_arrive_pm['HEURES']);

        
        // $targetTimePM = new DateTime('14:15');
        // Récupérer l'heure actuelle au format H:i:s
        $currentTime = date('H:i:s');
        $current_time = new DateTime($currentTime);
        $time= new DateTime($targetTimeAM);

        // Ajouter 15 minutes
        $arrival_time=$time->modify('+00 minutes');
       
    
        // Formater la date actuelle pour obtenir AM ou PM

        $formattedDate = $current_time->add(new DateInterval('PT1H'))->format('A');
        $statu=0;
        if ($current_time<$arrival_time) {
            $statu=1;
        } 
        elseif (($current_time < $targetTimePM) && $formattedDate=="PM" ) {
            $statu=1;
        } else {
            $statu=0;
        }

       
			$data_insert = array(
				'ID_UTILISATEUR' => $this->session->userdata('ID_UTILISATEUR'),
                'QR_CODE_PRES_ID'=>$data['QR_CODE_PRES_ID'],
                'STATUT'=>(!empty($this->input->post('motif')))?2:$statu,
                'MOTIF'=>$this->input->post('motif'),

			);
        $nbrespr=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre 
                FROM presences 
                WHERE DATE(DATE_PRESENCE) = CURDATE() 
                AND DATE_FORMAT(DATE_PRESENCE, '%p') = '".$formattedDate."'
                AND ID_UTILISATEUR = ".$this->session->userdata('ID_UTILISATEUR')."");

        $nbrescon=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre 
                FROM conges 
                WHERE DATE(DATE_CONGE) = CURDATE() 
                AND periode = '".$formattedDate."'
                AND ID_UTILISATEUR = ".$this->session->userdata('ID_UTILISATEUR')."");
                
         $nbresab=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre 
                FROM absences 
                WHERE DATE(date_absence) = CURDATE() 
                AND periode = '".$formattedDate."'
                AND ID_UTILISATEUR = ".$this->session->userdata('ID_UTILISATEUR')."");

            $nbre=$nbrespr['Nbre']+$nbrescon['Nbre']+$nbresab['Nbre'];
			 if($nbre==0){
                $table = 'presences';
                $this->Modele->create($table, $data_insert);
            echo json_encode(1);

            }

		}

    function getNbre()
    {
        // $nbres=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre FROM presences WHERE  DATE_FORMAT(DATE_PRESENCE, '%Y-%m-%d') = CURDATE() AND  ID_UTILISATEUR=".$this->session->userdata('ID_UTILISATEUR')."");
        // $conges=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre FROM conges WHERE  DATE_FORMAT(DATE_CONGE, '%Y-%m-%d') = CURDATE() AND  ID_UTILISATEUR=".$this->session->userdata('ID_UTILISATEUR')."");
        // $absants=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre FROM absences WHERE  DATE_FORMAT(date_absence, '%Y-%m-%d') = CURDATE() AND  id_utilisateur=".$this->session->userdata('ID_UTILISATEUR')."");
        
        // $nbre=( $absants['Nbre']+$nbres['Nbre']+$conges['Nbre']);
        
        // echo json_encode(array('nbres'=>$nbre));

        

        $nbrespr=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre 
                FROM presences 
                WHERE DATE(DATE_PRESENCE) = CURDATE() 
                AND DATE_FORMAT(DATE_PRESENCE, '%p') = 'AM'
                AND ID_UTILISATEUR = ".$this->session->userdata('ID_UTILISATEUR')."");

        $nbrescon=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre 
                FROM conges 
                WHERE DATE(DATE_CONGE) = CURDATE() 
                AND periode = 'AM'
                AND ID_UTILISATEUR = ".$this->session->userdata('ID_UTILISATEUR')."");
                
        $nbresab=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre 
                FROM absences 
                WHERE DATE(date_absence) = CURDATE() 
                AND periode = 'AM'
                AND ID_UTILISATEUR = ".$this->session->userdata('ID_UTILISATEUR')."");


        $nbresprPM=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre 
                FROM presences 
                WHERE DATE(DATE_PRESENCE) = CURDATE() 
                AND DATE_FORMAT(DATE_PRESENCE, '%p') = 'PM'
                AND ID_UTILISATEUR = ".$this->session->userdata('ID_UTILISATEUR')."");

        $nbresconPM=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre 
                FROM conges 
                WHERE DATE(DATE_CONGE) = CURDATE() 
                AND periode = 'PM'
                AND ID_UTILISATEUR = ".$this->session->userdata('ID_UTILISATEUR')."");
                
        $nbresabPM=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre 
                FROM absences 
                WHERE DATE(date_absence) = CURDATE() 
                AND periode = 'PM'
                AND ID_UTILISATEUR = ".$this->session->userdata('ID_UTILISATEUR')."");

    $nbreAM=$nbrespr['Nbre']+$nbrescon['Nbre']+$nbresab['Nbre'];
    $nbrePM=$nbresprPM['Nbre']+$nbresconPM['Nbre']+$nbresabPM['Nbre'];
    echo json_encode(array('nbreAM'=>$nbreAM,'nbrePM'=>$nbrePM));
    }        

 function detail($agence=0)
{
    
    $critaire_avant="";
    $avant=$this->input->post('avant');
    $KEY=$this->input->post('key');

   if(!empty($avant)){
    if($avant=='AM'){
        $critaire_avant.=" AND TIME(`DATE_PRESENCE`)<='12:00:00' ";
    }
    else{
    $critaire_avant.=" AND TIME(`DATE_PRESENCE`)>'12:00:00' ";
    }
   }
        $KEY2=$this->input->post('key2');
        $break=explode(".",$KEY2);
        $ID=$KEY2;

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


        $query_principal=" SELECT `ID_PRESENCE`, `ID_UTILISATEUR`, `QR_CODE_PRES_ID`, `STATUT`,`MOTIF`, `DATE_PRESENCE` FROM `presences` WHERE  ID_UTILISATEUR= ".$this->session->userdata('ID_UTILISATEUR')."";

                $order_column = array('ID_PRESENCE','DATE_PRESENCE', 'STATUT');

                $limit='LIMIT 0,10';
                if($_POST['length'] != -1)
                {
                    $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
                }
               

		        $order_by = isset($_POST['order']) ? 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_PRESENCE DESC';

                $search = !empty($_POST['search']['value']) ? ("AND (DATE_PRESENCE LIKE '%$var_search%'  OR STATUT LIKE '%$var_search%' ) ") : '';


                $critaire='';
                if($ID==1){  

                $critaire=" AND date_format(`DATE_PRESENCE`,'%m') LIKE '%".$KEY."%'";

                }elseif ($ID==2) { 

                $critaire=" AND  `STATUT`=1 AND date_format(`DATE_PRESENCE`,'%m') LIKE '%".$KEY."%'";

                }
                elseif ($ID==3) { 

                $critaire=" AND  `STATUT`=0 AND date_format(`DATE_PRESENCE`,'%m') LIKE '%".$KEY."%'";

                }
                elseif ($ID==4) { 

                    $critaire=" AND  `STATUT`=2 AND date_format(`DATE_PRESENCE`,'%m') LIKE '%".$KEY."%'";
    
                    }
            
                $query_secondaire=$query_principal.'  '.$critaire.' '.$critaire_avant.' '.$search.' '.$order_by.'   '.$limit;
                $query_filter=$query_principal.'  '.$critaire.' '.$critaire_avant.' '.$search;

                $fetch_data = $this->Model->datatable($query_secondaire);
                $u=0;
                $data = array();
                foreach ($fetch_data as $row) 
                {  
                    $statut='';
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



        function detail_absant($agence=0)
        {
         $critaire_avant="";
         $avant=$this->input->post('avant');
         $KEY=$this->input->post('key');
  
        if(!empty($avant)){
            if($avant=='AM'){
                $critaire_avant.=" AND periode LIKE  '%AM%'";
        
            }
            else{
            $critaire_avant.=" AND periode LIKE  '%PM%'";
        
            }
        }
        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


        $query_principal=" 
            SELECT  e.*,a.date_absence,a.periode
                FROM employes e LEFT JOIN  absences a ON e.ID_UTILISATEUR=a.id_utilisateur
                WHERE DATE(a.date_absence) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') AND CURDATE() and   a.id_utilisateur=".$this->session->userdata('ID_UTILISATEUR')."
            ";
            $order_column = array('id','date_absence', 'periode');

            $limit='LIMIT 0,10';
            if($_POST['length'] != -1)
            {
                $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
            }
           

            $order_by = isset($_POST['order']) ? 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY date_absence DESC';


            $search = !empty($_POST['search']['value']) ? ("AND (date_absence LIKE '%$var_search%'  ) ") : '';
                $critaire='';
                

                $critaire=" AND  date_format(a.date_absence,'%m') LIKE '%".$KEY."%'";

                
            
                $query_secondaire=$query_principal.'  '.$critaire.' '.$critaire_avant.' '.$search.' '.$order_by.'   '.$limit;
                $query_filter=$query_principal.'  '.$critaire.' '.$critaire_avant.' '.$search;

                $fetch_data = $this->Model->datatable($query_secondaire);
                $u=0;
                $data = array();
                foreach ($fetch_data as $row) 
                {  
                    $u++;
                    $intrant=array();
                    $intrant[] = $u;
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
        function declarer()
        {
            
                $periode = $this->input->post('PERIODE');
                
                   if(!empty($periode)){
                        // Prepare data for 22/08/2024 PM OU AM
                        $data = array(
                            'ID_UTILISATEUR' => $this->input->post('ID_UTILISATEUR'),
                            'DATE_CONGE' => $this->input->post('DEBUT'),
                            'ID_MOTIF' => $this->input->post('ID_MOTIF'),
                            'periode' =>$periode==2?'PM' :'AM'
                        );

                        $table = 'conges';
                        $tables = 'absences';
                        $tables1 = 'presences';
                        $critere="";
                        if($periode==2){
                         $critere="PM";
                        }
                        else{
                         $critere="AM";
                        }
                        $this->Modele->deleteDataWiths($table,$this->input->post('ID_UTILISATEUR'), $this->input->post('DEBUT'));
                        $this->Modele->deleteDataWith($tables,$this->input->post('ID_UTILISATEUR'), $this->input->post('DEBUT'));
                        $this->Modele->deleteDataWithDateFormat($tables1,$this->input->post('ID_UTILISATEUR'), $critere);

                        $this->Modele->create($table, $data);
                        echo json_encode(1);
                   }
                   else {
                   // Insert FULL days from 23/08/2024 to 25/08/2024
				//Récupération des dates de début et de fin
						$start_date = $this->input->post('DEBUT');
						$end_date = $this->input->post('FIN');
                        $id=$this->input->post('ID_UTILISATEUR');
						// Conversion en timestamps
						$current_date = strtotime($start_date);
						$end_date = strtotime($end_date);

						// Récupération de l'ID utilisateur et du motif
						// $id_utilisateur = $this->input->post('ID_UTILISATEUR');
						$id_motif = $this->input->post('ID_MOTIF');

						// Boucle sur chaque jour de l'intervalle
						while ($current_date <= $end_date) {
							// Récupération du jour de la semaine (1 = lundi, 7 = dimanche)
							$day_of_week = date('N', $current_date);

							// Exclure les week-ends (samedi et dimanche)
							if ($day_of_week != 7 && $day_of_week != 6) {
								// Préparation des données pour la matinée (AM) et l'après-midi (PM)
								$data_am = array(
									'ID_UTILISATEUR' => $id,
									'DATE_CONGE' => date('Y-m-d', $current_date),
									'periode' => 'AM',
									'ID_MOTIF' => $id_motif,
								);

								$data_pm = array(
									'ID_UTILISATEUR' => $id,
									'DATE_CONGE' => date('Y-m-d', $current_date),
									'periode' => 'PM',
									'ID_MOTIF' => $id_motif,
								);

								// Tables pour supprimer les données existantes
								$table_conges = 'conges';
								$table_absences = 'absences';
								$table_presences = 'presences';

								// Suppression des enregistrements existants pour la date
								$this->Modele->deleteDataWiths($table_conges, $id, date('Y-m-d', $current_date));
								$this->Modele->deleteDataWith($table_absences, $id, date('Y-m-d', $current_date));
								$this->Modele->deleteDataWithDateFormats($table_presences, $id, date('Y-m-d', $current_date));

								// Insertion des nouveaux enregistrements (AM et PM)
								$this->Modele->create($table_conges, $data_am);
								$this->Modele->create($table_conges, $data_pm);
							}

							// Passer au jour suivant
							$current_date = strtotime('+1 day', $current_date);
                        
                    }
                        echo json_encode(1);
                   }
              
        }
        
        function detail_conge($agence=0)
        {
     
            $critaire_avant="";
            $avant=$this->input->post('avant');
            $KEY=$this->input->post('key');
     
           if(!empty($avant)){
               if($avant=='AM'){
                   $critaire_avant.=" AND periode LIKE  '%AM%'";
           
               }
               else{
               $critaire_avant.=" AND periode LIKE  '%PM%'";
           
               }
           }
 
         $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     
 
 
         $query_principal=" 
             SELECT  e.*,a.DATE_CONGE,a.PERIODE
                 FROM employes e LEFT JOIN  conges a ON e.ID_UTILISATEUR=a.id_utilisateur
                 WHERE DATE(a.DATE_CONGE) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') AND CURDATE() and   a.id_utilisateur=".$this->session->userdata('ID_UTILISATEUR')."
             ";
         
             $order_column = array('ID_CONGE ','DATE_CONGE', 'PERIODE');

            $limit='LIMIT 0,10';
            if($_POST['length'] != -1)
            {
                $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
            }
           

            $order_by = isset($_POST['order']) ? 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_CONGE DESC';

             $search = !empty($_POST['search']['value']) ? ("AND (DATE_CONGE LIKE '%$var_search%'  ) ") : '';
                 $critaire='';
                 
                 $ID_MOTIF=$this->input->post('key2');
               
                 $critaire= "AND a.ID_MOTIF=".$ID_MOTIF." AND  date_format(a.DATE_CONGE,'%m') LIKE '%".$KEY."%'";
 
                 
             
                 $query_secondaire=$query_principal.'  '.$critaire.' '.$critaire_avant.' '.$search.' '.$order_by.'   '.$limit;
                 $query_filter=$query_principal.'  '.$critaire.' '.$critaire_avant.' '.$search;
 
                 $fetch_data = $this->Model->datatable($query_secondaire);
                 $u=0;
                 $data = array();
                 foreach ($fetch_data as $row) 
                 {  
                     $u++;
                     $intrant=array();
                     $intrant[] = $u;
                     $intrant[] =$row->DATE_CONGE;
                      $intrant[] =$row->PERIODE;
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
	}
    

?>