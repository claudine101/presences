
<?php
class Dashboard_hebdomadaires extends CI_Controller
      {
function index(){

                $dattes=$this->Model->getRequete("SELECT DISTINCT date_format(presences.`DATE_PRESENCE`,'%Y') AS mois FROM presences ORDER BY  mois ASC");
                $agences=$this->Model->getRequete("SELECT ID_AGENCE, DESCRIPTION FROM agences WHERE 1");
                

                $data['dattes']=$dattes;
                $data['agences']=$agences;


                $this->load->view('Dashboard_hebdomadaire_View',$data);
     }
            function presentes(){

                    $dattes=$this->Model->getRequeteOne("SELECT * FROM utilisateurs u JOIN employes e ON e.ID_UTILISATEUR=u.ID_UTILISATEUR WHERE  u.ID_UTILISATEUR=".$this->session->userdata('ID_UTILISATEUR')."");
                    $nbres=$this->Model->getRequeteOne("SELECT COUNT(*) as Nbre FROM presences WHERE  DATE_FORMAT(DATE_PRESENCE, '%Y-%m-%d') = CURDATE() AND  ID_UTILISATEUR=".$this->session->userdata('ID_UTILISATEUR')."");
                    
                    $data['data']=$dattes;
                    $data['nbre']=$nbres['Nbre'];

                    $this->load->view('Profil_View',$data);
            }
            public function upload() {
        if ($_FILES['qr_code_image']['name']) {
            // Configuration du téléchargement
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('qr_code_image')) {
                // Erreur de téléchargement
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                // $this->load->view('arrival_form', $error);
            } else {
                // Téléchargement réussi
                $uploadData = $this->upload->data();
                $filePath = $uploadData['full_path'];

                // Décoder le QR code
                $qrCode = $this->decodeQrCode($filePath);

                if ($qrCode) {
                    // Enregistrer l'arrivée
                    $this->load->model('Arrival_model');
                    $result = $this->Model->registerArrival($qrCode);

                    if ($result) {
                        echo "Arrivée enregistrée avec succès";
                    } else {
                        echo "Erreur lors de l'enregistrement de l'arrivée";
                    }
                } else {
                    echo "Erreur lors de la lecture du QR code";
                }
            }
        }
    }

    private function decodeQrCode($filePath) {
        // Utiliser une bibliothèque pour lire le QR code
        // Par exemple, utiliser ZBar ou une autre bibliothèque compatible avec PHP
        $command = escapeshellcmd("zbarimg -q --raw " . $filePath);
        $output = shell_exec($command);

        return trim($output);
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

public function get_rapport(){ 

$agence=$this->input->post('agence');
$datte="";
$criteres1="";
$criteres2="";

$categorie="";
$titre="du  ".strftime('%d-%m-%Y',strtotime(date('Y-m-d')));

         if(!empty($agence)){
            $criteres1.=" AND agences.`ID_AGENCE`= ".$agence." ";

         }

      $control=$this->Model->getRequete("SELECT
          DAYNAME(`DATE_PRESENCE`) AS day_of_week,
          COUNT(`ID_PRESENCE`) AS tout,
          DATE_FORMAT(`DATE_PRESENCE`, '%Y-%m-%d') as annees,
          (SELECT COUNT(`ID_UTILISATEUR`) FROM employes WHERE ID_UTILISATEUR NOT IN (SELECT (`ID_UTILISATEUR`) FROM presences) ) as absant,
          SUM(CASE WHEN TIME(`DATE_PRESENCE`) > '07:40:00' THEN 1 ELSE 0 END) AS number_of_lates,
          SUM(CASE WHEN TIME(`DATE_PRESENCE`) <= '07:40:00' THEN 1 ELSE 0 END) AS number_of_punctuals
      FROM
          presences JOIN  employes ON employes.ID_UTILISATEUR=presences.ID_UTILISATEUR JOIN agences on agences.ID_AGENCE=employes.ID_AGENCE
      WHERE 1 ".$criteres1." AND
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
      $sommeexpt=($value['tout']>0) ? $value['tout'] : "0" ;
      $retards.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeretards.",key2:3,key:'". $key_id1."'},";
      $ponctuels.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeponctuals.",key2:2,key:'". $key_id1."'},";
      $immadeclare_categoriet.="{name:'".str_replace("'","\'", $value['day_of_week'])."', y:". $sommeexpt.",key2:1,key:'". $key_id1."'},";

      $retard_traite=$retard_traite+$value['number_of_lates'];
      $ponctuel_traite=$ponctuel_traite+$value['number_of_punctuals'];
      $presence_traite=$presence_traite+$value['tout'];
    
}
   
     $rapp="<script type=\"text/javascript\">
    Highcharts.chart('container', {
   
chart: {
        type: 'column'
    },
    title: {
        text: '<b> Rapport  </b> ".$titre." '
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
url:\"".base_url('dashboard/Dashboard_hebdomadaire/detail/' . $this->input->post('agence'))."\",
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
  text: \"RECECA-INKINGI\"
},

    series: [
    {
        color: '#90EE90',
        name:'Employés présents: (".number_format($presence_traite,0,',',' ').")', 
        borderColor:\"#90EE90\", 
        data: [".$immadeclare_categoriet."]  
    },
    {
        color: 'red',
        name:'Employés en retard : (".number_format($retard_traite,0,',',' ').")',
        data: [".$retards."]
    },
     {
        color: 'green',
         name:'Employés ponctuels: (".number_format($ponctuel_traite,0,',',' ').")', 
        data: [".$ponctuels."]
    }
    
    ]

});
</script>
     ";



echo json_encode(array('rapp'=>$rapp));
    }



public function get_rapport_user(){ 

    $agence=$this->input->post('agence');
    $datte="";
    $criteres1="";
    $criteres2="";
    
    $categorie="";
    $titre="du  ".strftime('%d-%m-%Y',strtotime(date('Y-m-d')));
    
             if(!empty($agence)){
                $criteres1.=" AND agences.`ID_AGENCE`= ".$agence." ";
    
             }
    
          $control=$this->Model->getRequete("SELECT
             MONTHNAME(`DATE_PRESENCE`) AS day_of_week,
              COUNT(`ID_PRESENCE`) AS tout,
              DATE_FORMAT(`DATE_PRESENCE`, '%m') as annees,
              (SELECT COUNT(`ID_UTILISATEUR`) FROM employes WHERE ID_UTILISATEUR NOT IN (SELECT (`ID_UTILISATEUR`) FROM presences) ) as absant,
             SUM(CASE WHEN (`STATUT`) =1 THEN 1 ELSE 0 END) AS number_of_punctuals,
          SUM(CASE WHEN (`STATUT`) =0 THEN 1 ELSE 0 END) AS  number_of_lates
          FROM
              presences JOIN  employes ON employes.ID_UTILISATEUR=presences.ID_UTILISATEUR JOIN agences on agences.ID_AGENCE=employes.ID_AGENCE
          WHERE presences.ID_UTILISATEUR= ".$this->session->userdata('ID_UTILISATEUR')."
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
       
         $rapp="<script type=\"text/javascript\">
        Highcharts.chart('container', {
       
    chart: {
            type: 'column'
        },
        title: {
            text: '<b> Rapport   </b> ".$titre." '
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
    url:\"".base_url('dashboard/Dashboard_hebdomadaire/detail1/' . $this->input->post('agence'))."\",
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
      text: \"RECECA-INKINGI\"
    },
    
        series: [
        {
            color: '#90EE90',
            name:'Nombres de  présences: (".number_format($presence_traite,0,',',' ').")', 
            borderColor:\"#90EE90\", 
            data: [".$immadeclare_categoriet."]  
        },
        {
            color: 'red',
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
    
    
    
    echo json_encode(array('rapp'=>$rapp));
        }
function presenter()
	{
		$data = $this->Modele->getOne('qr_code_presence', array('IS_ACTIVE' =>1));
       // Obtenir la date et l'heure actuelles
        $dateCurrent = new DateTime();
        $date_arrive = $this->Modele->getOne('arrivees', array('ID_ARRIVE' => $this->session->userdata('ID_ARRIVE')));
        date_default_timezone_set('Europe/Paris');
        date_default_timezone_set('Africa/Bujumbura');
       
        $targetTimeAM = ($date_arrive['HEURES']);
       
        $targetTimePM = new DateTime('14:00');
        // Récupérer l'heure actuelle au format H:i:s
        $currentTime = date('H:i:s');

        $current_time = new DateTime($currentTime);
        $arrival_time = new DateTime($targetTimeAM);
        // $arrival_timePm = new DateTime($targetTimePM);

       
        // Formater la date actuelle pour obtenir AM ou PM
        $formattedDate = $dateCurrent->format('A');
       
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
                'STATUT'=>$statu
			);
			$table = 'presences';
			$this->Modele->create($table, $data_insert);
			echo json_encode(1);
		}



 function detail1($agence=0)
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
	}
    

?>