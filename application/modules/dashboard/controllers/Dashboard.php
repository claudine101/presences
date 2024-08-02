
<?php
 /// EDMOND :dashboard des Immatriculation
class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->have_droit();
    }
    public function have_droit()
    {
        if ($this->session->userdata('ID_PROFIL') != 4|| $this->session->userdata('ID_PROFIL') != 2) {

            redirect(base_url());
        }
    }
    
function index(){

$dattes=$this->Model->getRequete("SELECT DISTINCT date_format(presences.`DATE_PRESENCE`,'%Y') AS mois FROM presences ORDER BY  mois ASC");
  
$data['dattes']=$dattes;
$this->load->view('Dashboard_View',$data);
     }

function detail()
{
    
  $mois=$this->input->post('mois');
  $jour=$this->input->post('jour');
  $KEY=$this->input->post('key');
        
  $criteres_date="";
 
        
if(!empty($mois)){
      $criteres_date.=" AND date_format(presences.`DATE_PRESENCE`,'%Y')='".$mois."'"; 
}

if(!empty($jour)){

     $criteres_date.=" AND date_format(presences.`DATE_PRESENCE`,'%Y-%m')='".$jour."'";
}



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal=" SELECT  `ID_PRESENCE`, `QR_CODE_PRES_ID`, `ID_UTILISATEUR` FROM `presences` WHERE 1 ".$criteres_date." ";

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

        $search = !empty($_POST['search']['value']) ? ("AND (ID_PRESENCE LIKE '%$var_search%'  OR QR_CODE_PRES_ID LIKE '%$var_search%'' OR ID_UTILISATEUR LIKE '%$var_search%'  ) ") : '';


        
   $critaire=" ";
     if(!empty($mois) && empty($jour)){
      
        $critaire="  AND date_format(presences.`DATE_PRESENCE`,'%Y-%m')='".$KEY."'";
        }
        elseif(!empty($mois) && !empty($jour)){
      

        $critaire="  AND date_format(presences.`DATE_PRESENCE`,'%Y-%m-%d')='".$KEY."'";

        }else{
        $critaire="  AND date_format(presences.`DATE_PRESENCE`,'%Y')='".$KEY."'";
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
        $intrant[] =$row->QR_CODE_PRES_ID."  ".$row->ID_UTILISATEUR;
         $intrant[] =$retVal;
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

    function detail1()
    {
        
      $mois=$this->input->post('mois');
      $jour=$this->input->post('jour');
      $KEY=$this->input->post('key');
            
      $criteres_date="";
     
            
    if(!empty($mois)){
          $criteres_date.=" AND date_format(presences.`DATE_PRESENCE`,'%Y')='".$mois."'"; 
    }
    
    if(!empty($jour)){
    
         $criteres_date.=" AND date_format(presences.`DATE_PRESENCE`,'%Y-%m')='".$jour."'";
    }
    
    
    
    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     
    
    
    $query_principal=" SELECT  `ID_PRESENCE`, `QR_CODE_PRES_ID`, `ID_UTILISATEUR` FROM `presences` WHERE 1 ".$criteres_date." ";
    
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
    
            $search = !empty($_POST['search']['value']) ? ("AND (ID_PRESENCE LIKE '%$var_search%'  OR QR_CODE_PRES_ID LIKE '%$var_search%'' OR ID_UTILISATEUR LIKE '%$var_search%'  ) ") : '';
    
    
            
       $critaire=" ";
         if(!empty($mois) && empty($jour)){
          
            $critaire="  AND date_format(presences.`DATE_PRESENCE`,'%Y-%m')='".$KEY."'";
            }
            elseif(!empty($mois) && !empty($jour)){
          
    
            $critaire="  AND date_format(presences.`DATE_PRESENCE`,'%Y-%m-%d')='".$KEY."'";
    
            }else{
            $critaire="  AND date_format(presences.`DATE_PRESENCE`,'%Y')='".$KEY."'";
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
            $intrant[] =$row->QR_CODE_PRES_ID."  ".$row->ID_UTILISATEUR;
             $intrant[] =$retVal;
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
function detail2()
{
    
  $mois=$this->input->post('mois');
  $jour=$this->input->post('jour');
  $KEY=$this->input->post('key');
        
  $criteres_date="";
 
        
if(!empty($mois)){
      $criteres_date.=" AND date_format(presences.`DATE_PRESENCE`,'%Y')='".$mois."'"; 
}

if(!empty($jour)){

     $criteres_date.=" AND date_format(presences.`DATE_PRESENCE`,'%Y-%m')='".$jour."'";
}



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal=" SELECT  `ID_PRESENCE`, `QR_CODE_PRES_ID`, `ID_UTILISATEUR` FROM `presences` WHERE 1 ".$criteres_date." ";

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

        $search = !empty($_POST['search']['value']) ? ("AND (ID_PRESENCE LIKE '%$var_search%'  OR QR_CODE_PRES_ID LIKE '%$var_search%'' OR ID_UTILISATEUR LIKE '%$var_search%'  ) ") : '';


        
   $critaire=" ";
     if(!empty($mois) && empty($jour)){
      
        $critaire="  AND date_format(presences.`DATE_PRESENCE`,'%Y-%m')='".$KEY."'";
        }
        elseif(!empty($mois) && !empty($jour)){
      

        $critaire="  AND date_format(presences.`DATE_PRESENCE`,'%Y-%m-%d')='".$KEY."'";

        }else{
        $critaire="  AND date_format(presences.`DATE_PRESENCE`,'%Y')='".$KEY."'";
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
        $intrant[] =$row->QR_CODE_PRES_ID."  ".$row->ID_UTILISATEUR;
         $intrant[] =$retVal;
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

$categorie="date_format(presences.`DATE_PRESENCE`,'%Y')";
$criteres1.="";
$titre="du  ".strftime('%d-%m-%Y',strtotime(date('Y-m-d')));
}
if
(!empty($mois)){

$titre="en  ".$mois."";
$criteres1.=" AND date_format(presences.`DATE_PRESENCE`,'%Y')='".$mois."'";

$categorie="date_format(presences.`DATE_PRESENCE`,'%Y-%m')";


  }

  if(!empty($jour)){
     $criteres1.=" AND date_format(presences.`DATE_PRESENCE`,'%Y-%m')= '".$jour."'  ";
$titre="du mois  ".strftime('%m-%Y',strtotime($jour));

    $categorie="date_format(presences.`DATE_PRESENCE`,'%Y-%m-%d')";
    
         }
if(!empty($heure)){
     $criteres1.=" AND date_format(presences.`DATE_PRESENCE`,'%Y-%m-%d')= '".$heure."'  ";
$titre="du  ".strftime('%d-%m-%Y',strtotime($heure));
$categorie="date_format(presences.`DATE_PRESENCE`,'%Y-%m-%d')";
    
         }
  $datte=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(presences.`DATE_PRESENCE`, "%Y-%m") as mois from presences where DATE_FORMAT(presences.`DATE_PRESENCE`, "%Y")="'.$mois.'" ORDER BY mois DESC');

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
$datjour=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(presences.DATE_PRESENCE, "%Y-%m-%d") as mois from presences where DATE_FORMAT(presences.DATE_PRESENCE, "%Y-%m")="'.$jour.'" ORDER BY mois DESC');

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



      $control=$this->Model->getRequete("SELECT DISTINCT ".$categorie." AS mois,COUNT(`ID_IMMATRICULATION`) AS NBRE,(SELECT COUNT(ID_IMMATRICULATION) FROM presences WHERE 1 AND ".$categorie."=mois ) as assure,(SELECT COUNT(ID_IMMATRICULATION) FROM presences WHERE `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from otraco_controles WHERE 1 ) AND ".$categorie."=mois ) as controle,(SELECT COUNT(ID_IMMATRICULATION) FROM presences WHERE `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from pj_declarations WHERE 1 ) AND ".$categorie."=mois ) as declares FROM presences WHERE 1 ".$criteres1."   GROUP BY mois ORDER BY mois ASC");
 
 $immatr=$this->Model->getRequete("SELECT DISTINCT ".$categorie." AS mois,COUNT(`ID_IMMATRICULATION`) AS NBRE FROM presences WHERE 1 ".$criteres1." GROUP BY mois ORDER BY mois ASC");





$immatr_categorie=" ";
$immatr_total=0;

 foreach ($immatr as  $value) {
      
      
$key_id1=($value['mois']>0) ? $value['mois'] : "0" ;
$somme=($value['NBRE']>0) ? $value['NBRE'] : "0" ;
$immatr_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $somme.",key:'". $key_id1."'},";
$immatr_total=$immatr_total+$value['NBRE'];
     
     }


$immacat=$this->Model->getRequete("SELECT DISTINCT `CATEGORIE_USAGE` AS NAME, COUNT(`ID_IMMATRICULATION`) AS NBRE FROM `presences` WHERE 1 ".$criteres1." GROUP BY NAME ORDER BY NAME DESC");
$immacat_categorie=" ";
$immacat_total=0;

 foreach ($immacat as  $value) {
      
      
$key_id1=(!empty($value['NAME'])) ? $value['NAME'] : "null" ;
$somme=($value['NBRE']>0) ? $value['NBRE'] : "0" ;
$immacat_categorie.="{name:'".str_replace("'","\'", $value['NAME'])." ', y:". $somme.",key:'". $key_id1."'},";


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

$immatraite_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $sommtraite.",key2:1,key:'". $key_id1."'},";
$immaassure_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $sommeassur.",key2:2,key:'". $key_id1."'},";
$immacontrole_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $sommecontrol.",key2:3,key:'". $key_id1."'},";
$immadeclare_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:".$sommedecl.",key2:4,key:'". $key_id1."'},";

$immatr_sommtraite=$immatr_sommtraite+$value['NBRE'];
$immatr_sommecontrol=$immatr_sommecontrol+$value['controle'];
$immatr_sommeassur=$immatr_sommeassur+$value['assure'];
$immatr_sommedecl=$immatr_sommedecl+$value['declares'];

     }

   
     $rapp="<script type=\"text/javascript\">
    Highcharts.chart('container', {
    chart: {
        type: 'columnpyramid'
    },
    title: {
        text: '<b>  Enregistrement des Immatriculations  </b><br>  ".$titre." '
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
        color: '#FFA500',  
        name:'Immatriculations : (".number_format($immatr_total,0,',',' ').")',
        data: [".$immatr_categorie."]
    },
    
    ]
});
</script>
     ";

     $rapp1="<script type=\"text/javascript\">

    Highcharts.chart('container1', {
   
chart: {
        type: 'line'
    },
    title: { 
        text: '<b>Immatriculation  par catégories  </b><br>  ".$titre." <br> Total=".number_format($immacat_total,0,',',' ')."'
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
        line: {
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
           dataLabels: {
             enabled: true,
             format: '{point.y:f}'
         },
         showInLegend: false
     }
 }, 
 credits: {
  enabled: true,
  href: \"\",
  text: \"Mediabox\"
},

    series: [
    {color:'#800000',
        name:'Nombre',
        data: [".$immacat_categorie."]
    }
    ]

});
</script>
     ";
 $rapp2="<script type=\"text/javascript\">
    Highcharts.chart('container2', {
   
chart: {
        type: 'column'
    },
    title: {
        text: '<b>Statut d’immatriculation  </b><br>  ".$titre." '
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
        name:'Immatriculations enregistrées: (".number_format($immatr_sommtraite,0,',',' ').")',
        data: [".$immatraite_categorie."]
    },
     {
        color: '#7FFFD4',
         name:'Immatriculations avec  assurance  : (".number_format($immatr_sommeassur,0,',',' ').")',
        data: [".$immaassure_categorie."]
    },
    {
        color: 'blue',
        name:'Immatriculations avec contrôle technique  : (".number_format($immatr_sommecontrol,0,',',' ').")',
        data: [".$immacontrole_categorie."]
    },   
    {
        color: 'red',
        name:'Immatriculations déclarées volées  : (".number_format($immatr_sommedecl,0,',',' ').")',
        data: [".$immadeclare_categorie."]
    }

    ]

});
</script>
     ";


echo json_encode(array('rapp'=>$rapp,'rapp1'=>$rapp1,'rapp2'=>$rapp2,'select_month'=>$mois_select,'selectjour'=>$selectjour));
    }


}
?>






