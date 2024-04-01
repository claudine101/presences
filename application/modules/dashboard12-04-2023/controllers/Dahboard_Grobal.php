
<?php
 /// EDMOND :dashboard des grobal
class Dahboard_Grobal extends CI_Controller
      {
function index(){  

$dattes=$this->Model->getRequete("SELECT DISTINCT date_format(civil_alerts.DATE_INSERTION,'%Y') AS mois FROM civil_alerts ORDER BY  mois ASC");

    
$data['dattes']=$dattes;

$this->load->view('Dashboard_Gobal_View',$data);
     }

    
function detail()
    {
    
  $mois=$this->input->post('mois');
  $jour=$this->input->post('jour');
  $heure=$this->input->post('heure');
$NUMERO_PLAQUE=$this->input->post('NUMERO_PLAQUE');
$NUMERO_PERMIS=$this->input->post('NUMERO_PERMIS');


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

$criteres_date.=" AND date_format(c.DATE_INSERTION,'%Y')='".$mois."'"; 
        }

if(!empty($jour)){

$criteres_date.=" AND date_format(c.DATE_INSERTION,'%Y-%m')='".$jour."'";
        }
  if(!empty($heure)){
$criteres_date.=" AND date_format(c.DATE_INSERTION,'%Y-%m-%d')= '".$heure."'  ";
    
         }




 if (!empty($NUMERO_PLAQUE)) {
   $search=' and obr.NUMERO_PLAQUE like "%'.$NUMERO_PLAQUE.'%"'; 
 }





$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal="SELECT q.INFRACTIONS,q.MONTANT,obr.NUMERO_PLAQUE,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,af.LIEU_EXACTE,c.DATE_INSERTION FROM civil_alerts c JOIN civil_alerts_details d ON c.ID_ALERT=d.ID_CIVIL_ALERT JOIN autres_controles_questionnaires q ON q.ID_CONTROLES_QUESTIONNAIRES=d.ID_QUESTIONNAIRE LEFT JOIN  historique_signalement hist ON hist.ID_ALERT=c.ID_ALERT LEFT JOIN obr_immatriculations_voitures obr ON obr.ID_IMMATRICULATION=hist.ID_IMMATICULATION JOIN utilisateurs u ON c.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN psr_element_affectation ps ON e.ID_PSR_ELEMENT=ps.ID_PSR_ELEMENT LEFT JOIN psr_affectatations af ON af.PSR_AFFECTATION_ID=ps.PSR_AFFECTATION_ID   WHERE 1 AND c.ID_ALERT_TYPE=1 ".$search."  ".$plaque." ".$criteres_date." ";

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

        

        $search = !empty($_POST['search']['value']) ? ("AND (q.INFRACTIONS LIKE '%$var_search%'  OR q.MONTANT LIKE '%$var_search%' OR e.NOM LIKE '%$var_search%' OR e.PRENOM LIKE '%$var_search%' OR e.NUMERO_MATRICULE LIKE '%$var_search%' OR af.LIEU_EXACTE LIKE '%$var_search%' OR c.DATE_INSERTION LIKE '%$var_search%' ) ") : '';   
     
        $critaire=' AND q.INFRACTIONS="'.$KEY.'"';
    
        
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
        $intrant[] =$row->INFRACTIONS;
         $intrant[] =$row->NUMERO_PLAQUE;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
         $retVal = ($row->MONTANT>0) ? number_format($row->MONTANT,0,',',' ').' FBU' : 'Sans' ;
        $intrant[] =$retVal;
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

$criteres_date.=" AND date_format(c.DATE_INSERTION,'%Y')='".$mois."'"; 
        }

if(!empty($jour)){

$criteres_date.=" AND date_format(c.DATE_INSERTION,'%Y-%m')='".$jour."'";
        }
  if(!empty($heure)){
    $criteres_date.=" AND date_format(c.DATE_INSERTION,'%Y-%m-%d')= '".$heure."'  ";
    
         }




 if (!empty($NUMERO_PLAQUE)) {
   $search=' and h.NUMERO_PLAQUE like "%'.$NUMERO_PLAQUE.'%"'; 
 }

 



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal=" SELECT q.INFRACTIONS,q.MONTANT,obr.NUMERO_PLAQUE,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,af.LIEU_EXACTE,c.DATE_INSERTION FROM civil_alerts c JOIN civil_alerts_details d ON c.ID_ALERT=d.ID_CIVIL_ALERT JOIN autres_controles_questionnaires q ON q.ID_CONTROLES_QUESTIONNAIRES=d.ID_QUESTIONNAIRE LEFT JOIN  historique_signalement hist ON hist.ID_ALERT=c.ID_ALERT LEFT JOIN obr_immatriculations_voitures obr ON obr.ID_IMMATRICULATION=hist.ID_IMMATICULATION JOIN utilisateurs u ON c.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN psr_element_affectation ps ON e.ID_PSR_ELEMENT=ps.ID_PSR_ELEMENT LEFT JOIN psr_affectatations af ON af.PSR_AFFECTATION_ID=ps.PSR_AFFECTATION_ID   WHERE 1 AND c.ID_ALERT_TYPE=2 ".$search."  ".$plaque." ".$criteres_date."  ";

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

                $search = !empty($_POST['search']['value']) ? ("AND (q.INFRACTIONS LIKE '%$var_search%'  OR q.MONTANT LIKE '%$var_search%' OR e.NOM LIKE '%$var_search%' OR e.PRENOM LIKE '%$var_search%' OR e.NUMERO_MATRICULE LIKE '%$var_search%' OR af.LIEU_EXACTE LIKE '%$var_search%' OR c.DATE_INSERTION LIKE '%$var_search%' ) ") : '';   
     
        $critaire=' AND q.INFRACTIONS="'.$KEY.'"';
    
        
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
        $intrant[] =$row->INFRACTIONS;
         $intrant[] =$row->NUMERO_PLAQUE;
          $intrant[] =$row->NOM."  ".$row->PRENOM;
          $retVal = ($row->MONTANT>0) ? number_format($row->MONTANT,0,',',' ').' FBU' : 'Sans' ;
        $intrant[] =$retVal;
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

$criteres_date.=" AND date_format(c.DATE_INSERTION,'%Y')='".$mois."'"; 
        }

if(!empty($jour)){

$criteres_date.=" AND date_format(c.DATE_INSERTION,'%Y-%m')='".$jour."'";
        }
  if(!empty($heure)){
$criteres_date.=" AND date_format(c.DATE_INSERTION,'%Y-%m-%d')= '".$heure."'  ";
    
         }


 if (!empty($NUMERO_PLAQUE)) {
   $search=' and h.NUMERO_PLAQUE like "%'.$NUMERO_PLAQUE.'%"'; 
 }

 


$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal=" SELECT q.INFRACTIONS,q.MONTANT,obr.NUMERO_PLAQUE,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,af.LIEU_EXACTE,c.DATE_INSERTION FROM civil_alerts c JOIN civil_alerts_details d ON c.ID_ALERT=d.ID_CIVIL_ALERT JOIN autres_controles_questionnaires q ON q.ID_CONTROLES_QUESTIONNAIRES=d.ID_QUESTIONNAIRE LEFT JOIN  historique_signalement hist ON hist.ID_ALERT=c.ID_ALERT LEFT JOIN obr_immatriculations_voitures obr ON obr.ID_IMMATRICULATION=hist.ID_IMMATICULATION JOIN utilisateurs u ON c.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON u.PSR_ELEMENT_ID=e.ID_PSR_ELEMENT LEFT JOIN psr_element_affectation ps ON e.ID_PSR_ELEMENT=ps.ID_PSR_ELEMENT LEFT JOIN psr_affectatations af ON af.PSR_AFFECTATION_ID=ps.PSR_AFFECTATION_ID   WHERE 1 AND c.ID_ALERT_TYPE=3 ".$search."  ".$plaque." ".$criteres_date." ";

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

        $search = !empty($_POST['search']['value']) ? ("AND (q.INFRACTIONS LIKE '%$var_search%'  OR q.MONTANT LIKE '%$var_search%' OR e.NOM LIKE '%$var_search%' OR e.PRENOM LIKE '%$var_search%' OR e.NUMERO_MATRICULE LIKE '%$var_search%' OR af.LIEU_EXACTE LIKE '%$var_search%' OR c.DATE_INSERTION LIKE '%$var_search%' ) ") : '';   
     
        $critaire=' AND q.INFRACTIONS="'.$KEY.'"';
    
        
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
        $intrant[] =$row->INFRACTIONS;  
         $intrant[] =$row->NUMERO_PLAQUE;
        $intrant[] =$row->NOM."  ".$row->PRENOM;
        $retVal = ($row->MONTANT>0) ? number_format($row->MONTANT,0,',',' ').' FBU' : 'Sans' ;
        $intrant[] =$retVal;
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

$datte="";
$datjour="";
$criteres1="";
$cripaid="";
$categorie="";


if
(!empty($mois)){


$criteres1.=" AND date_format(c.DATE_INSERTION,'%Y')='".$mois."'";

  }

  if(!empty($jour)){
     $criteres1.=" AND date_format(c.DATE_INSERTION,'%Y-%m')= '".$jour."'  ";
    
         }
          if(!empty($heure)){
     $criteres1.=" AND date_format(c.DATE_INSERTION,'%Y-%m-%d')= '".$heure."'  ";
    
         }


  $datte=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(civil_alerts.DATE_INSERTION, "%Y-%m") as mois from civil_alerts where DATE_FORMAT(civil_alerts.DATE_INSERTION, "%Y")="'.$mois.'" ORDER BY mois DESC');

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


$datjour=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(civil_alerts.DATE_INSERTION, "%Y-%m-%d") as mois from civil_alerts where DATE_FORMAT(civil_alerts.DATE_INSERTION, "%Y-%m")="'.$jour.'" ORDER BY mois DESC');

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
$plaque='';
 if (!empty($NUMERO_PLAQUE)) {
   $search=' and obr.NUMERO_PLAQUE like "%'.$NUMERO_PLAQUE.'%"'; 
 }





$vehicule=$this->Model->getRequete("SELECT q.INFRACTIONS,COUNT(d.ID_QUESTIONNAIRE) AS NBRE,SUM(q.MONTANT) AS MONTA FROM civil_alerts c JOIN civil_alerts_details d ON c.ID_ALERT=d.ID_CIVIL_ALERT JOIN autres_controles_questionnaires q ON q.ID_CONTROLES_QUESTIONNAIRES=d.ID_QUESTIONNAIRE LEFT JOIN  historique_signalement hist ON hist.ID_ALERT=c.ID_ALERT LEFT JOIN obr_immatriculations_voitures obr ON obr.ID_IMMATRICULATION=hist.ID_IMMATICULATION   WHERE 1 AND c.ID_ALERT_TYPE=1  ".$search." ".$plaque." ".$criteres1." GROUP BY q.INFRACTIONS");

$vehicule_categorie=" ";
$vehicule_categorie_monta=" ";
$vehicule_categorie_total=0;
$vehicule_categorie_total_monta=0;
 
 foreach ($vehicule as  $value) {  
      
      

$key_id1=(!empty(str_replace("'","\'", $value['INFRACTIONS']))) ? str_replace("'","\'", $value['INFRACTIONS']) : "NULL" ;
$monta=($value['MONTA']>0) ? $value['MONTA'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$vehicule_categorie_monta.="{name:'".str_replace("'","\'", $value['INFRACTIONS'])."', y:". $monta.",key:'".$key_id1."'},";
$vehicule_categorie.="{name:'".str_replace("'","\'", $value['INFRACTIONS'])."', y:". $nbre.",key:'".$key_id1."'},";
$vehicule_categorie_total=$vehicule_categorie_total+$value['NBRE'];
$vehicule_categorie_total_monta=$vehicule_categorie_total_monta+$value['MONTA'];
    
     }

$police=$this->Model->getRequete("SELECT q.INFRACTIONS,COUNT(d.ID_QUESTIONNAIRE) AS NBRE,SUM(q.MONTANT) AS MONTA FROM civil_alerts c JOIN civil_alerts_details d ON c.ID_ALERT=d.ID_CIVIL_ALERT JOIN autres_controles_questionnaires q ON q.ID_CONTROLES_QUESTIONNAIRES=d.ID_QUESTIONNAIRE LEFT JOIN  historique_signalement hist ON hist.ID_ALERT=c.ID_ALERT LEFT JOIN obr_immatriculations_voitures obr ON obr.ID_IMMATRICULATION=hist.ID_IMMATICULATION   WHERE 1 AND c.ID_ALERT_TYPE=2 ".$search." ".$plaque." ".$criteres1." GROUP BY q.INFRACTIONS");

$police_categorie=" ";
$police_categorie_monta=" ";
$police_categorie_total=0;
$police_categorie_total_monta=0;
 
 foreach ($police as  $value) {  
      
      
$key_id1=(!empty(str_replace("'","\'", $value['INFRACTIONS']))) ? str_replace("'","\'", $value['INFRACTIONS']) : "NULL" ;
$monta=($value['MONTA']>0) ? $value['MONTA'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$police_categorie_monta.="{name:'".str_replace("'","\'", $value['INFRACTIONS'])."', y:". $monta.",key:'".$key_id1."'},";
$police_categorie.="{name:'".str_replace("'","\'", $value['INFRACTIONS'])."', y:". $nbre.",key:'".$key_id1."'},";
$police_categorie_total=$police_categorie_total+$value['NBRE'];
$police_categorie_total_monta=$police_categorie_total_monta+$value['MONTA'];
    
     }

$controle=$this->Model->getRequete("SELECT q.INFRACTIONS,COUNT(d.ID_QUESTIONNAIRE) AS NBRE,SUM(q.MONTANT) AS MONTA FROM civil_alerts c JOIN civil_alerts_details d ON c.ID_ALERT=d.ID_CIVIL_ALERT JOIN autres_controles_questionnaires q ON q.ID_CONTROLES_QUESTIONNAIRES=d.ID_QUESTIONNAIRE LEFT JOIN  historique_signalement hist ON hist.ID_ALERT=c.ID_ALERT LEFT JOIN obr_immatriculations_voitures obr ON obr.ID_IMMATRICULATION=hist.ID_IMMATICULATION   WHERE 1 AND c.ID_ALERT_TYPE=3 ".$search." ".$plaque." ".$criteres1." GROUP BY q.INFRACTIONS");

$controle_categorie=" ";
$controle_categorie_monta=" ";
$controle_categorie_total=0;
$controle_categorie_total_monta=0;
 
 foreach ($controle as  $value) {  
      
      

$key_id1=(!empty(str_replace("'","\'", $value['INFRACTIONS']))) ? str_replace("'","\'", $value['INFRACTIONS']) : "NULL" ;
$monta=($value['MONTA']>0) ? $value['MONTA'] : "0" ;
$nbre=($value['NBRE']>0) ? $value['NBRE'] : "0" ;


$controle_categorie_monta.="{name:'".str_replace("'","\'", $value['INFRACTIONS'])."', y:". $monta.",key:'".$key_id1."'},";
$controle_categorie.="{name:'".str_replace("'","\'", $value['INFRACTIONS'])."', y:". $nbre.",key:'".$key_id1."'},";
$controle_categorie_total=$controle_categorie_total+$value['NBRE'];
$controle_categorie_total_monta=$controle_categorie_total_monta+$value['MONTA'];
    
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
        text: '<b> Signalement des véhicule </b> du ".date('d-m-Y')." '
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
                            url:\"".base_url('dashboard/Dahboard_Grobal/detail')."\",
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
     name: 'Infractions (".number_format($vehicule_categorie_total,0,',',' ').")',
    data: [".$vehicule_categorie."],

    color: \"purple\"
},

{
   
    name: 'Montant (".number_format($vehicule_categorie_total_monta,0,',',' ')." FBU)',
    data: [".$vehicule_categorie_monta."],

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
        type: 'column'
    },
    title: {
        text: '<b>Signalement des policiers </b> du ".date('d-m-Y')." '
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
url:\"".base_url('dashboard/Dahboard_Grobal/detail1')."\",
type:\"POST\",
data:{
key:this.key, 
                                 key1:this.key1,
                                mois:$('#mois').val(),
                                jour:$('#jour').val(),
                                heure:$('#heure').val(),
                                NUMERO_PLAQUE:$('#NUMERO_PLAQUE').val(),
                                 
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
        name:'Nombre : (".number_format($police_categorie_total,0,',',' ').")',
        data: [".$police_categorie."]
    },
     {
        color: 'yellow',  
        name:'Montant : (".number_format($police_categorie_total_monta,0,',',' ')." FBU)',
        data: [".$police_categorie_monta."]
    },
    ]

});
</script>
     ";
$rapp2="<script type=\"text/javascript\">
    Highcharts.chart('container2', {
    chart: {
        type: 'spline'
    },

    legend: {
        symbolWidth: 40
    },

    title: {
        text: '<b>Signalement des contrôles </b> du ".date('d-m-Y')."'
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
                            url:\"".base_url('dashboard/Dahboard_Grobal/detail2')."\",
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
        
        color: 'pink',
        name:'Nombre : (".number_format($controle_categorie_total,0,',',' ').")',
        data: [".$controle_categorie."]
    },
     {
        color: 'green',  
        name:'Montant : (".number_format($controle_categorie_total_monta,0,',',' ')." FBU)',
        data: [".$controle_categorie_monta."]
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


echo json_encode(array('rapp'=>$rapp,'rapp1'=>$rapp1,'rapp2'=>$rapp2,'select_month'=>$mois_select,'selectjour'=>$selectjour));
    }


}
?>




