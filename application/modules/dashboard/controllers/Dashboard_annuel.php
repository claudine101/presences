
<?php
class Dashboard_annuel extends CI_Controller
      {
        function __construct()
        {
            parent::__construct();
            $this->have_droit();
        }
        public function have_droit()
        {
            if ($this->session->userdata('ID_PROFIL') != 5 && $this->session->userdata('ID_PROFIL') != 3 && $this->session->userdata('ID_PROFIL') != 2) {
                redirect('Login');
           }
           
        }
        function index(){

            $dattes=$this->Model->getRequete("SELECT DISTINCT date_format(p.`DATE_PRESENCE`,'%Y') AS mois FROM presences  p ORDER BY  mois ASC");
  
            $agences=$this->Model->getRequete("SELECT ID_AGENCE, DESCRIPTION FROM agences WHERE 1");
            $data['agences']=$agences;
            $data['dattes']=$dattes;

                $this->load->view('Dashboard_annuel_View',$data);
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
                 
        $dates=$this->input->post('DATE_PRESENCE');
        $criteres_date1="";
        $criteres_date2="";
        $criteres_date3="";

                 if(!empty($dates)){
                    $criteres_date1.=" AND date_format(presences.`DATE_PRESENCE`,'%Y-%m-%d')= '".$dates."'  ";
                    $criteres_date2.=" AND date_format(a.date_absence,'%Y-%m-%d')= '".$dates."'  ";
                    $criteres_date3.=" AND date_format(a.DATE_CONGE,'%Y-%m-%d')= '".$dates."'  ";
                  }
    
          $control=$this->Model->getRequete("SELECT
             MONTHNAME(`DATE_PRESENCE`) AS day_of_week,
              DATE_FORMAT(`DATE_PRESENCE`, '%m') as annees,
              (SELECT COUNT(`ID_UTILISATEUR`) FROM employes WHERE ID_UTILISATEUR NOT IN (SELECT (`ID_UTILISATEUR`) FROM presences) ) as absant,
             SUM(CASE WHEN (`STATUT`) =1 THEN 1 ELSE 0 END) AS number_of_punctuals,
          SUM(CASE WHEN (`STATUT`) =0 THEN 1 ELSE 0 END) AS  number_of_lates
          FROM
              presences JOIN  employes ON employes.ID_UTILISATEUR=presences.ID_UTILISATEUR JOIN agences on agences.ID_AGENCE=employes.ID_AGENCE
          WHERE 1".$criteres1."  ".$criteres3."  ".$criteres_date1."
          GROUP BY
              MONTH(`DATE_PRESENCE`)
          ORDER BY
              MONTH(`DATE_PRESENCE`);
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
    $nbres=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre FROM presences WHERE  DATE_FORMAT(DATE_PRESENCE, '%Y-%m-%d') = CURDATE() AND  ID_UTILISATEUR=".$this->session->userdata('ID_UTILISATEUR')."");
    $nbre=$nbres['Nbre'];

    $absants=$this->Model->getRequete("SELECT DATE_FORMAT(a.date_absence, '%m') as mois, MONTHNAME(a.date_absence) AS day_of_week, COUNT(a.id_utilisateur) AS nombre_absents
        FROM absences a  LEFT JOIN employes e ON e.ID_UTILISATEUR=a.id_utilisateur
        WHERE DATE(a.date_absence) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') AND CURDATE() ".$criteres4."  ".$criteres5." " .$criteres_date2."
        GROUP BY mois
        ORDER BY mois"
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
url:\"".base_url('dashboard/Dashboard_annuel/detail_absants/' . $this->input->post('agence'))."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
agance:$('#ID_AGENCE').val(),
avant:$('#avant').val(),
DATE_PRESENCE:$('#DATE_PRESENCE').val()
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


   
$conges=$this->Model->getRequete("SELECT DATE_FORMAT(a.DATE_CONGE, '%m') as mois, MONTHNAME(a.DATE_CONGE) AS day_of_week, COUNT(a.ID_UTILISATEUR) AS nombre_absents,
    SUM(CASE WHEN (a.ID_MOTIF) =1 THEN 1 ELSE 0 END) AS conges,
          SUM(CASE WHEN (a.ID_MOTIF) =2 THEN 1 ELSE 0 END) AS  permission, 
          SUM(CASE WHEN (a.ID_MOTIF) =3 THEN 1 ELSE 0 END) AS  Surterrain,
          SUM(CASE WHEN (a.ID_MOTIF) =4 THEN 1 ELSE 0 END) AS  Mission, 
          SUM(CASE WHEN (a.ID_MOTIF) =5 THEN 1 ELSE 0 END) AS  Formation
   FROM conges a  LEFT JOIN employes e ON e.ID_UTILISATEUR=a.ID_UTILISATEUR
   WHERE DATE(a.DATE_CONGE) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') AND CURDATE() ".$criteres4."  ".$criteres5." ".$criteres_date3."
   GROUP BY mois
   ORDER BY mois"
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
$(\"#titreb\").html(\" Détails de tous les employés en permission\");
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
url:\"".base_url('dashboard/Dashboard_annuel/detail_conges/' . $this->input->post('agence'))."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
agance:$('#ID_AGENCE').val(),
avant:$('#avant').val(),
DATE_PRESENCE:$('#DATE_PRESENCE').val()


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
    url:\"".base_url('dashboard/Dashboard_annuel/detail_presence/' . $this->input->post('agence'))."\",
    type:\"POST\",
    data:{
    key:this.key,
    key2:this.key2,
    agance:$('#ID_AGENCE').val(),
    avant:$('#avant').val(),
    DATE_PRESENCE:$('#DATE_PRESENCE').val()

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
    
    echo json_encode(array('rapp'=>$rapp,'rapp_conge'=>$rapp_conge, 'rapp_absent'=>$rapp_absent,'nbres'=>$nbre));
}


   function detail_absants($agence=0)
   {
       
     $avant=$this->input->post('avant');
     $KEY=$this->input->post('key');
     $criteres1="";
     $criteres3="";
   
   if(!empty($agence)){
   $criteres1.=" AND e.`ID_AGENCE`= ".$agence." ";
   }
   if(!empty($avant)){
   if($avant=='AM'){
       $criteres3.=" AND periode LIKE  '%AM%'";
   }
   else{
       $criteres3.=" AND periode LIKE  '%PM%'";
   }
 }

 $dates=$this->input->post('DATE_PRESENCE');
        $criteres_date2="";
        if(!empty($dates)){
        $criteres_date2.=" AND date_format(a.date_absence,'%Y-%m-%d')= '".$dates."'  ";
        }

  $critere = " ";

  $critere = " AND DATE_FORMAT(a.date_absence, '%m') = '".$KEY."'";




$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal="
SELECT  e.*,a.date_absence,ag.DESCRIPTION,a.periode
    FROM employes e LEFT JOIN  agences  ag on ag.ID_AGENCE=e.ID_AGENCE LEFT JOIN  absences a ON e.ID_UTILISATEUR=a.id_utilisateur
      WHERE DATE(a.date_absence) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') AND CURDATE() ".$critere." ".$criteres1." ".$criteres3." ".$criteres_date2."
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
  
    function detail_conges($agence=0)
    {
        
      $avant=$this->input->post('avant');
      $KEY=$this->input->post('key');
      $criteres1="";
      $criteres3="";
    
    if(!empty($agence)){
    $criteres1.=" AND e.`ID_AGENCE`= ".$agence." ";
    }
    if(!empty($avant)){
    if($avant=='AM'){
        $criteres3.=" AND periode LIKE  '%AM%'";
    }
    else{
        $criteres3.=" AND periode LIKE  '%PM%'";
    }
  }
 
 
  $dates=$this->input->post('DATE_PRESENCE');
  $criteres_date3="";

    if(!empty($dates)){
        $criteres_date3.=" AND date_format(a.DATE_CONGE,'%Y-%m-%d')= '".$dates."'  ";
    }
 
 
   $critere = " ";
   $ID_MOTIF=$this->input->post('key2');
   $critere = "AND a.ID_MOTIF=".$ID_MOTIF." AND DATE_FORMAT(a.DATE_CONGE, '%m') = '".$KEY."'";
 
 
 
 
 $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     
 
 
 $query_principal="
 SELECT  e.*,a.DATE_CONGE,ag.DESCRIPTION,a.periode
     FROM employes e LEFT JOIN  agences  ag on ag.ID_AGENCE=e.ID_AGENCE LEFT JOIN  conges a ON e.ID_UTILISATEUR=a.ID_UTILISATEUR
       WHERE DATE(a.DATE_CONGE) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') AND CURDATE() ".$critere." ".$criteres1." ".$criteres3." ".$criteres_date3."
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
             "data" => $data,

         );
 
         echo json_encode($output);
     }
        function detail_presence($agence=0)
        {
            
          $avant=$this->input->post('avant');
          $KEY=$this->input->post('key');
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
      $dates=$this->input->post('DATE_PRESENCE');
      $criteres_date1="";
    
        if(!empty($dates)){
            $criteres_date1.=" AND date_format(p.`DATE_PRESENCE`,'%Y-%m-%d')= '".$dates."'  ";
        }
     
      $KEY2=$this->input->post('key2');
        $break=explode(".",$KEY2);
        $ID=$KEY2;
        
        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     
        
        
        $query_principal=" SELECT a.DESCRIPTION,e.PHOTO_EMPLOYE, e.DATE_NAISSANCE_EMPLOYE,e.SEXE_EMPLOYE,p.ID_PRESENCE,p.DATE_PRESENCE, p.QR_CODE_PRES_ID, p.ID_UTILISATEUR ,e.NOM_EMPLOYE,e.PRENOM_EMPLOYE,e.NUMERO_CNI_EMPLOYE,e.TELEPHONE_EMPLOYE,e.EMAIL_EMPLOYE FROM presences 
        p JOIN employes e ON e.ID_UTILISATEUR=p.ID_UTILISATEUR  JOIN agences a ON a.ID_AGENCE=e.ID_AGENCE WHERE 1 ";
        
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
                
                  $critaire=" AND  `STATUT`=1 AND date_format(p.`DATE_PRESENCE`,'%m') LIKE '%".$KEY."%'";
                

                  $critaire='';
        if($ID==1){  

        $critaire=" AND date_format(p.`DATE_PRESENCE`,'%Y-%m-%d') LIKE '%".$KEY."%'";

        }elseif ($ID==2) { 

          $critaire=" AND  `STATUT`=1 AND date_format(p.`DATE_PRESENCE`,'%Y-%m-%d') LIKE '%".$KEY."%'";
        }
        elseif ($ID==3) { 

          $critaire=" AND  `STATUT`=0 AND date_format(p.`DATE_PRESENCE`,'%Y-%m-%d') LIKE '%".$KEY."%'";

        }
               
                $query_secondaire=$query_principal.'  '.$critaire.' '.$criteres3.' '.$criteres1.' '.$criteres_date1.' '.$search.' '.$order_by.'   '.$limit;
                $query_filter=$query_principal.'  '.$critaire.' '.$criteres1.' '.$criteres3.' '.$criteres_date1.' '.$search;
        
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
            function listing()
	{

		$i = 1;

		$query_principal = '
        SELECT 
     e.*, 
    (SELECT COUNT(p.ID_PRESENCE) 
     FROM presences p 
     WHERE p.STATUT = 1 AND p.ID_UTILISATEUR = e.ID_UTILISATEUR) AS presences, 
    (SELECT COUNT(p.ID_PRESENCE) 
     FROM presences p 
     WHERE p.STATUT = 0 AND p.ID_UTILISATEUR = e.ID_UTILISATEUR) AS retards ,
     (SELECT COUNT(a.id_utilisateur) 
     FROM absences a
     WHERE 1 AND a.id_utilisateur = e.ID_UTILISATEUR) AS absences ,
     (SELECT COUNT(c.ID_UTILISATEUR) 
     FROM conges c
     WHERE c.ID_MOTIF=1 AND c.ID_UTILISATEUR = e.ID_UTILISATEUR) AS conges,
     
     (SELECT COUNT(c.ID_UTILISATEUR) 
     FROM conges c
     WHERE c.ID_MOTIF=2 AND c.ID_UTILISATEUR = e.ID_UTILISATEUR) AS malades,
     (SELECT COUNT(c.ID_UTILISATEUR) 
     FROM conges c
     WHERE c.ID_MOTIF=3 AND c.ID_UTILISATEUR = e.ID_UTILISATEUR) AS surTerrains,
     (SELECT COUNT(c.ID_UTILISATEUR) 
     FROM conges c
     WHERE c.ID_MOTIF=4 AND c.ID_UTILISATEUR = e.ID_UTILISATEUR) AS enMissions,
     (SELECT COUNT(c.ID_UTILISATEUR) 
     FROM conges c
     WHERE c.ID_MOTIF=5 AND c.ID_UTILISATEUR = e.ID_UTILISATEUR) AS enFormations
FROM 
    employes e  WHERE e.s
    
        ';
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,100';

		// if ($_POST['length'] != -1) {
		// 	$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		// }

		$order_by = '';
		
		// $order_column = array('ID_EMPLOYE','NOM_EMPLOYE', 'presences','retards','conges', 'IS_ACTIVE_EMPLOYE','DESCRIPTION','COLLINE_NAME');
		$order_column = array('ID_EMPLOYE','NOM_EMPLOYE', 'presences','retards','conges', 'malades','surTerrains','enMissions','enFormations');


		$order_by = isset($_POST['order']) ? 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM_EMPLOYE DESC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM_EMPLOYE LIKE '%$var_search%'") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . ' LIMIT 0,100 ';
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_infraction = $this->Modele->datatable($query_secondaire);
		$data = array();
		$u=0;
		foreach ($fetch_infraction as $row) {
		
			$sub_array = array();
			$u=++$u;
			$source = !empty($row->PHOTO_EMPLOYE) ? $row->PHOTO_EMPLOYE : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			
			$sub_array[]=$u;
			$sub_array[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM_EMPLOYE . ' ' . $row->PRENOM_EMPLOYE . '</td></tr></tbody></table></a>';
			$sub_array[] = $row->presences;
            $sub_array[] = $row->retards;
			$sub_array[] = $row->conges;
            $sub_array[] = $row->malades;
            $sub_array[] = $row->surTerrains;
			$sub_array[] = $row->enMissions;
			$sub_array[] = $row->enFormations;
			$sub_array[] = '<strong style="color: red;">'.($row->presences+$row->retards+$row->conges+$row->malades+$row->surTerrains+ $row->enMissions+$row->enFormations).'</strong>';


			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST['draw']),
			"recordsTotal" => $this->Modele->all_data($query_principal),
			"recordsFiltered" => $this->Modele->filtrer($query_filter),
			"data" => $data
		);
		echo json_encode($output);
	}
        }
        
    

?>