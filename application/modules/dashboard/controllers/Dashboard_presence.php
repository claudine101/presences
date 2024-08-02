
<?php
 /// EDMOND :dashboard des Immatriculation
class Dashboard_presence extends CI_Controller
{
          function __construct()
            {
                parent::__construct();
                $this->have_droit();
            }
            public function have_droit()
            {
              if ($this->session->userdata('ID_PROFIL') != 2 && $this->session->userdata('ID_PROFIL') != 5 && $this->session->userdata('ID_PROFIL') != 4) {
                // redirect(base_url());
                redirect('Login');
              }
            }
function index(){

$dattes=$this->Model->getRequete("SELECT DISTINCT date_format(p.`DATE_PRESENCE`,'%Y') AS mois FROM presences  p ORDER BY  mois ASC");
  

$data['dattes']=$dattes;

$this->load->view('Dashboard_presence_View',$data);
     }
function detail()
{
  $mois=$this->input->post('mois');
  $jour=$this->input->post('jour');
  $KEY=$this->input->post('key');
  $KEY2=$this->input->post('key2');
  $break=explode(".",$KEY2);
  $ID=$KEY2;
        
$criteres_date="";

if(!empty($mois)){

$criteres_date.=" AND date_format(p.`DATE_PRESENCE`,'%Y')='".$mois."'"; 
        }

if(!empty($jour)){

$criteres_date.=" AND date_format(p.`DATE_PRESENCE`,'%Y-%m')='".$jour."'";
        }



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal=" SELECT  e.DATE_NAISSANCE_EMPLOYE,e.SEXE_EMPLOYE,p.ID_PRESENCE,p.DATE_PRESENCE, p.QR_CODE_PRES_ID, p.ID_UTILISATEUR ,e.NOM_EMPLOYE,e.PRENOM_EMPLOYE,e.NUMERO_CNI_EMPLOYE,e.TELEPHONE_EMPLOYE,e.EMAIL_EMPLOYE FROM presences p JOIN employes e ON e.ID_UTILISATEUR=p.ID_UTILISATEUR WHERE 1 ".$criteres_date." ";

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
        if($ID==1){  

        $critaire=" AND  `STATUT`=1 AND date_format(p.`DATE_PRESENCE`,'%Y-%m')='".$KEY."'";


        }elseif ($ID==2) { 

          $critaire=" AND  `STATUT` !=1 AND date_format(p.`DATE_PRESENCE`,'%Y-%m')='".$KEY."'";
        }
        elseif ($ID==3) { 

          $critaire=" AND  `ID_PRESENCE`  IN (SELECT ID_PRESENCEfrom historiques WHERE 1) AND date_format(p.`DATE_PRESENCE`,'%Y-%m')='".$KEY."'";
        }
        elseif ($ID==4) { 

          $critaire=" AND  `ID_PRESENCE` NOT IN (SELECT ID_PRESENCEfrom historiques WHERE 1) AND date_format(p.`DATE_PRESENCE`,'%Y-%m')='".$KEY."'";
        }
        elseif ($ID==5) { 

          $critaire=" AND date_format(p.`DATE_PRESENCE`,'%Y-%m')='".$KEY."'";
        }
       }elseif(!empty($mois) && !empty($jour)){
        if($ID==1){  

        $critaire=" AND  `STATUT`=1 AND date_format(p.`DATE_PRESENCE`,'%Y-%m-%d')='".$KEY."'";


        }elseif ($ID==2) { 

          $critaire=" AND  `STATUT` !=1 AND date_format(p.`DATE_PRESENCE`,'%Y-%m-%d')='".$KEY."'";
        }
        
       
        elseif ($ID==5) { 

          $critaire=" AND date_format(p.`DATE_PRESENCE`,'%Y-%m-%d')='".$KEY."'";
        }
        
        }else{
            if($ID==1){  

        $critaire=" AND  `STATUT`=1 AND date_format(p.`DATE_PRESENCE`,'%Y')='".$KEY."'";


        }elseif ($ID==2) { 

          $critaire=" AND  `STATUT` !=1 AND date_format(p.`DATE_PRESENCE`,'%Y')='".$KEY."'";
        }
     
         elseif ($ID==5) { 

          $critaire="  AND date_format(p.`DATE_PRESENCE`,'%Y')='".$KEY."'";
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
            $intrant[] =$row->NOM_EMPLOYE;
            $intrant[] =$row->PRENOM_EMPLOYE;
            $intrant[] =$row->EMAIL_EMPLOYE;
            $intrant[] =$row->TELEPHONE_EMPLOYE;
            $intrant[] =$row->DATE_NAISSANCE_EMPLOYE;
            //  $intrant[] =$row->SEXE_EMPLOYE;
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

$mois=$this->input->post('mois');
$jour=$this->input->post('jour');
$heure=$this->input->post('heure');


$datte="";
$criteres1="";
$criteres2="";

$categorie="";
$titre="du  ".strftime('%d-%m-%Y',strtotime(date('Y-m-d')));

if
(empty($mois)){
$titre="du  ".strftime('%d-%m-%Y',strtotime(date('Y-m-d')));
$categorie="date_format(p.`DATE_PRESENCE`,'%Y')";
$criteres1.="";
}
if
(!empty($mois)){

$titre="en  ".$mois."";
$criteres1.=" AND date_format(p.`DATE_PRESENCE`,'%Y')='".$mois."'";

$categorie="date_format(p.`DATE_PRESENCE`,'%Y-%m')";


  }

  if(!empty($jour)){
     $criteres1.=" AND date_format(p.`DATE_PRESENCE`,'%Y-%m')= '".$jour."'  ";

    $titre="du mois  ".strftime('%m-%Y',strtotime($jour));
    $categorie="date_format(p.`DATE_PRESENCE`,'%Y-%m-%d')";
    
         }
if(!empty($heure)){
     $titre="du  ".strftime('%d-%m-%Y',strtotime($heure));
     $criteres1.=" AND date_format(p.`DATE_PRESENCE`,'%Y-%m-%d')= '".$heure."'  ";

$categorie="date_format(p.`DATE_PRESENCE`,'%Y-%m-%d')";
    
         }

  $datte=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(p.DATE_PRESENCE, "%Y-%m") as mois from presences p where DATE_FORMAT(p.`DATE_PRESENCE`, "%Y")="'.$mois.'" ORDER BY mois DESC');

  $mois_select="<option selected='' disabled=''>Sélectionner</option>";

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
$datjour=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(p.DATE_PRESENCE, "%Y-%m-%d") as mois from presences p where DATE_FORMAT(p.DATE_PRESENCE, "%Y-%m")="'.$jour.'" ORDER BY mois DESC');

  $selectjour="<option selected='' disabled=''>Sélectionner</option>";

    foreach ($datjour as $value)
         {

        if ($heure==$value['mois'])
              {
      $selectjour.="<option value='".$value['mois']."' selected>".$value['mois']."</option>";
                                } else{ 
    $selectjour.="<option value='".$value['mois']."'>".$value['mois']."</option>";
      } 
      } 

$control=$this->Model->getRequete("SELECT DISTINCT ".$categorie." AS mois,COUNT(p.`ID_PRESENCE`) AS tout,(SELECT COUNT(p.`ID_PRESENCE`) FROM presences p WHERE `STATUT`=1 AND ".$categorie."=mois ) as trouve,(SELECT COUNT(p.`ID_PRESENCE`) FROM presences p WHERE `STATUT`!=1 AND ".$categorie."=mois ) as pas_trouve FROM presences p where 1 ".$criteres1." GROUP BY mois ORDER BY mois ASC");


$immatraite_categorie=" ";
$immaassure_categorie=" ";
$immacontrole_categorie=" ";
$immadeclare_categorie=" ";

$immadeclare_categoriet=" ";
$immacat_traite=0;
$immacat_controle=0;

$immacat_controlet=0;

 foreach ($control as  $value) {
      
      
$key_id1=($value['mois']>0) ? $value['mois'] : "0" ;
$sommetrouve=($value['trouve']>0) ? $value['trouve'] : "0" ;
$sommeexp=($value['pas_trouve']>0) ? $value['pas_trouve'] : "0" ;
$sommeexpt=($value['tout']>0) ? $value['tout'] : "0" ;
$immatraite_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $sommetrouve.",key2:1,key:'". $key_id1."'},";
$immaassure_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $sommeexp.",key2:2,key:'". $key_id1."'},";
$immadeclare_categoriet.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $sommeexpt.",key2:5,key:'". $key_id1."'},";
$immacat_traite=$immacat_traite+$value['trouve'];
$immacat_controle=$immacat_controle+$value['pas_trouve'];
$immacat_controlet=$immacat_controlet+$value['tout'];
    
     }
   
     $rapp="<script type=\"text/javascript\">
    Highcharts.chart('container', {
   
title: {
        text: '<b> Rapport  </b> ".$titre." '
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
$(\"#titre\").html(\"Détails \");
$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_presence/detail')."\",
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
        type: 'spline',
        
        color: '#90EE90',
        name:'Employés présents : (".number_format($immacat_controlet,0,',',' ').")',
        borderColor:\"#90EE90\", 
        data: [".$immadeclare_categoriet."],
          marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        }
       
    }
,
    {
        type: 'columnpyramid',
        color: '#000080',
        name:'Employés ponctuels: (".number_format($immacat_traite,0,',',' ').")',
        data: [".$immatraite_categorie."]
    },
    {
        type: 'columnpyramid',
       color: '#FF00FF',
         name:' Employés en retard : (".number_format($immacat_controle,0,',',' ').")',
        data: [".$immaassure_categorie."]
    }  ]
});
</script>
     ";



echo json_encode(array('rapp'=>$rapp,'select_month'=>$mois_select,'selectjour'=>$selectjour));
    }


}
?>