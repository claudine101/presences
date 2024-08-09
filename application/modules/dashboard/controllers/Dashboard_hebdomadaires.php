
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
            if ($this->session->userdata('ID_PROFIL') != 3 && $this->session->userdata('ID_PROFIL') != 2 && $this->session->userdata('ID_PROFIL') != 1) {
                redirect('Login');
           }
           
        }
        function index(){

                $dattes=$this->Model->getRequeteOne("SELECT * FROM utilisateurs u JOIN employes e ON e.ID_UTILISATEUR=u.ID_UTILISATEUR WHERE  u.ID_UTILISATEUR=".$this->session->userdata('ID_UTILISATEUR')."");
                $nbres=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre FROM presences WHERE  DATE_FORMAT(DATE_PRESENCE, '%Y-%m-%d') = CURDATE() AND  ID_UTILISATEUR=".$this->session->userdata('ID_UTILISATEUR')."");
                $absances=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre FROM absences a WHERE  DATE_FORMAT(a.date_absence, '%Y-%m-%d') = CURDATE() AND  a.id_utilisateur=".$this->session->userdata('ID_UTILISATEUR')."");
                
                $data['nbre']=$nbres['Nbre'];

                $data['data']=$dattes;
                $data['nbre']=$nbres['Nbre'];

                $this->load->view('Profil_View',$data);
        }
    
    public function get_rapport_user(){ 

    $avant=$this->input->post('avant');
    $critaire_avant='';
    $critaire_avants='';

    if(!empty($avant)){
        if($avant=='AM'){
            $critaire_avant.=" AND TIME(`DATE_PRESENCE`)<='12:00:00' ";
            $critaire_avants.=" AND  periode LIKE  '%PM%'";
        }
        else{
        $critaire_avant.=" AND TIME(`DATE_PRESENCE`)>'12:00:00' ";
        $critaire_avants.=" AND  periode LIKE  '%AM%'";
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
          SUM(CASE WHEN (`STATUT`) =0 THEN 1 ELSE 0 END) AS  number_of_lates
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
          $sommeexpt=($value['tout']>0) ? $value['tout'] : "0" ;
          $retards.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeretards.",key2:3,key:'". $key_id1."'},";
          $ponctuels.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeponctuals.",key2:2,key:'". $key_id1."'},";
          $immadeclare_categoriet.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeexpt.",key2:1,key:'". $key_id1."'},";
    
          $retard_traite=$retard_traite+$value['number_of_lates'];
          $ponctuel_traite=$ponctuel_traite+$value['number_of_punctuals'];
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
        name:'Retard : (".number_format($retard_traite,0,',',' ').")',
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
          $immadeclare_categoriet.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeexpt.",key2:1,key:'". $key_id1."'},";
    
          $retard_traite=$retard_traite+$value['nombre_absents'];
          $ponctuel_traite=$ponctuel_traite+$value['nombre_absents'];
          
        
    }

         $rapp_absant="<script type=\"text/javascript\">
        Highcharts.chart('container1', {
       
    chart: {
            type: 'column'
        },
        title: {
            text: '<b> Rapport de mes absances jusqu\'à le   ".$titre." </b>'
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
            color: 'red',
            name:'Absants : (".number_format($retard_traite,0,',',' ').")',
            data: [".$retards."]
        }
        
        ]
    
    });
    </script>
         ";
    
    echo json_encode(array('rapp'=>$rapp, 'rapp_absant'=>$rapp_absant,'nbres'=>$nbre));
}
    function presenter()
	{
		$data = $this->Modele->getOne('qr_code_presences', array('IS_ACTIVE' =>1));
       // Obtenir la date et l'heure actuelles
        $dateCurrent = new DateTime();
        $date_arrive = $this->Modele->getOne('arrives', array('ID_ARRIVE' => $this->session->userdata('ID_ARRIVE')));
        $date_arrive_pm = $this->Modele->getOne('arrives_pm', array('ID_ARRIVE_PM' => $this->session->userdata('ID_ARRIVE_PM')));
        
        date_default_timezone_set('Europe/Paris');
        date_default_timezone_set('Africa/Bujumbura');
       
        $targetTimeAM = ($date_arrive['HEURES']);
        $targetTimePM = ($date_arrive_pm['HEURES']);

       
        // $targetTimePM = new DateTime('14:15');
        // Récupérer l'heure actuelle au format H:i:s
        $currentTime = date('H:i:s');
        $current_time = new DateTime($currentTime);
        $time= new DateTime($targetTimeAM);
        $time_pm= new DateTime($targetTimePM);
        $arrival_time_pm=$time_pm->modify('+15 minutes');

        // Ajouter 15 minutes
        $arrival_time=$time->modify('+15 minutes');
       
    //   print_r($arrival_time);
    //   exit();
        // Formater la date actuelle pour obtenir AM ou PM
        $formattedDate =$current_time->add(new DateInterval('PT1H'))->format('A');
        $statu=0;
        if ($current_time<$arrival_time) {
            $statu=1;
        } 
        elseif (($current_time < $arrival_time_pm) && $formattedDate=="PM" ) {
            $statu=1;
        } else {
            $statu=0;
        }
        //print_r($statu);
        //print_r($current_time);
        //print_r($targetTimePM);
        //print_r($formattedDate);
        //exit();
			$data_insert = array(
				'ID_UTILISATEUR' => $this->session->userdata('ID_UTILISATEUR'),
                'QR_CODE_PRES_ID'=>$data['QR_CODE_PRES_ID'],
                'STATUT'=>$statu
			);
			$table = 'presences';
			$this->Modele->create($table, $data_insert);
            
            echo json_encode(1);

		}

    function getNbre()
    {
        $nbres=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre FROM presences WHERE  DATE_FORMAT(DATE_PRESENCE, '%Y-%m-%d') = CURDATE() AND  ID_UTILISATEUR=".$this->session->userdata('ID_UTILISATEUR')."");
        $nbre=$nbres['Nbre'];
        echo json_encode(array('nbres'=>$nbre));
    }        

 function detail($agence=0)
{
    
        $mois=$this->input->post('mois');
        $jour=$this->input->post('jour');
        $KEY=$this->input->post('key');
        //   $agence=$this->input->post('agence');
        //  echo($agence);
        $critaire_agence='';
        if($agence!=0){
            $critaire_agence.=" AND a.`ID_AGENCE`= ".$agence." ";
        }
        $KEY2=$this->input->post('key2');
        $break=explode(".",$KEY2);
        $ID=$KEY2;

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


        $query_principal=" SELECT `ID_PRESENCE`, `ID_UTILISATEUR`, `QR_CODE_PRES_ID`, `STATUT`, `DATE_PRESENCE` FROM `presences` WHERE  ID_UTILISATEUR= ".$this->session->userdata('ID_UTILISATEUR')."";

                $limit='LIMIT 0,10';
                if($_POST['length'] != -1)
                {
                    $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
                }
                $order_by='';
                if($_POST['order']['0']['column']!=0)
                {
                    $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY DATE_PRESENCE  ASC'; 
                }

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
            
                $query_secondaire=$query_principal.'  '.$critaire.' '.$critaire_agence.' '.$search.' '.$order_by.'   '.$limit;
                $query_filter=$query_principal.'  '.$critaire.' '.$critaire_agence.' '.$search;

                $fetch_data = $this->Model->datatable($query_secondaire);
                $u=0;
                $data = array();
                foreach ($fetch_data as $row) 
                {  
                    $u++;
                    $intrant=array();
                    $intrant[] = $u;
                    $intrant[] =$row->DATE_PRESENCE;
                    $intrant[] =$row->STATUT;
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
    
        $mois=$this->input->post('mois');
        $jour=$this->input->post('jour');
        $KEY=$this->input->post('key');
        //   $agence=$this->input->post('agence');
        //  echo($agence);
        $critaire_agence='';
        if($agence!=0){
            $critaire_agence.=" AND a.`ID_AGENCE`= ".$agence." ";
        }
        $KEY2=$this->input->post('key2');
        $break=explode(".",$KEY2);
        $ID=$KEY2;

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


        $query_principal=" 
            SELECT  e.*,a.date_absence,a.periode
                FROM employes e LEFT JOIN  absences a ON e.ID_UTILISATEUR=a.id_utilisateur
                WHERE DATE(a.date_absence) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') AND CURDATE() and   a.id_utilisateur=".$this->session->userdata('ID_UTILISATEUR')."
            ";
        
            $limit='LIMIT 0,10';
            if($_POST['length'] != -1)
            {
                $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
            }
            $order_by='';
            if($_POST['order']['0']['column']!=0)
            {
                $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY date_absence  ASC'; 
            }

            $search = !empty($_POST['search']['value']) ? ("AND (date_absence LIKE '%$var_search%'  ) ") : '';
                $critaire='';
                

                $critaire=" AND  date_format(a.date_absence,'%m') LIKE '%".$KEY."%'";

                
            
                $query_secondaire=$query_principal.'  '.$critaire.' '.$critaire_agence.' '.$search.' '.$order_by.'   '.$limit;
                $query_filter=$query_principal.'  '.$critaire.' '.$critaire_agence.' '.$search;

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
	}
    

?>