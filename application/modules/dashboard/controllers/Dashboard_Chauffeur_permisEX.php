
<?php
 /// EDMOND :dashboard des permis
class Dashboard_Chauffeur_permis extends CI_Controller
      {
function index(){

$dattes=$this->Model->getRequete("SELECT DISTINCT date_format(chauffeur_permis.DATE_DELIVER,'%Y') AS mois FROM chauffeur_permis ORDER BY  mois DESC");


$data['dattes']=$dattes;
$DATEtet=date('Y');
$data['anneesonne'] =$this->Model->getRequeteOne('SELECT DISTINCT DATE_FORMAT(DATE_DELIVER, "%Y") as ANNh from chauffeur_permis where DATE_FORMAT(DATE_DELIVER, "%Y")='.$DATEtet.' ');
$this->load->view('Dashboard_Chauffeur_Permis_View',$data);
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
$datte_current="CURRENT_TIMESTAMP";    
if(!empty($mois)){

$criteres_date.=" AND date_format(chauffeur_permis.DATE_DELIVER,'%Y')='".$mois."'";
$datte_current="CURRENT_TIMESTAMP"; 
        }

if(!empty($jour)){
$criteres_date.=" AND date_format(chauffeur_permis.DATE_DELIVER,'%Y-%m')='".$jour."'";
$datte_current="CURRENT_TIMESTAMP";
        }

if(!empty($heure)){
$criteres_date.=" AND date_format(chauffeur_permis.DATE_DELIVER,'%Y-%m-%d')= '".$heure."'  ";
$datte_current="CURRENT_TIMESTAMP";
    
}




$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal=" SELECT  `NUMERO_PERMIS`, `NOM_PROPRIETAIRE`, `CATEGORIES`, `DATE_NAISSANCE`, `DATE_DELIVER`, `DATE_EXPIRATION`, `POINTS` FROM `chauffeur_permis` WHERE 1 ".$criteres_date." ";

        $limit='LIMIT 0,10';
        if($_POST['length'] != -1)
        {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $order_by='';
        if($_POST['order']['0']['column']!=0)
        {
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM_PROPRIETAIRE  ASC'; 
        }

        $search = !empty($_POST['search']['value']) ? ("AND (NUMERO_PERMIS LIKE '%$var_search%'  OR CATEGORIES LIKE '%$var_search%' OR DATE_NAISSANCE LIKE '%$var_search%' OR DATE_EXPIRATION LIKE '%$var_search%' OR DATE_DELIVER LIKE '%$var_search%' OR NOM_PROPRIETAIRE LIKE '%$var_search%' ) ") : '';   


 $critaire='';

if
(empty($mois)){
if($ID==1){  

        $critaire=" AND date_format(DATE_DELIVER,'%Y') ='".$KEY."' ";


        }elseif($ID==3){  

        $critaire=" AND (TIMESTAMPDIFF(day, `DATE_EXPIRATION`, ".$datte_current.") > 0) AND date_format(DATE_DELIVER,'%Y') ='".$KEY."'";


        }elseif($ID==2){  

        $critaire="AND (TIMESTAMPDIFF(day, `DATE_EXPIRATION`, ".$datte_current.") <= 0) AND date_format(DATE_DELIVER,'%Y') ='".$KEY."'";


}
}
else if(!empty($mois)){
if($ID==1){  

        $critaire=" AND date_format(DATE_DELIVER,'%Y-%m') ='".$KEY."' ";


        }elseif($ID==3){  

        $critaire=" AND (TIMESTAMPDIFF(day, `DATE_EXPIRATION`, ".$datte_current.") > 0) AND date_format(DATE_DELIVER,'%Y-%m') ='".$KEY."'";


        }elseif($ID==2){  

        $critaire="AND (TIMESTAMPDIFF(day, `DATE_EXPIRATION`, ".$datte_current.") <= 0) AND date_format(DATE_DELIVER,'%Y-%m') ='".$KEY."'";


}
}
  if(!empty($jour)){
if($ID==1){  

 $critaire=" AND date_format(DATE_DELIVER,'%Y-%m-%d') ='".$KEY."' ";


}elseif($ID==3){  

$critaire=" AND (TIMESTAMPDIFF(day, `DATE_EXPIRATION`, ".$datte_current.") > 0) AND date_format(DATE_DELIVER,'%Y-%m-%d') ='".$KEY."'";


}elseif($ID==2){  

$critaire="AND (TIMESTAMPDIFF(day, `DATE_EXPIRATION`, ".$datte_current.") <= 0) AND date_format(DATE_DELIVER,'%Y-%m-%d') ='".$KEY."'";


}
}
if(!empty($heure)){
if($ID==1){  

 $critaire=" AND date_format(DATE_DELIVER,'%Y-%m-%d') ='".$KEY."' ";


}elseif($ID==3){  

$critaire=" AND (TIMESTAMPDIFF(day, `DATE_EXPIRATION`, ".$datte_current.") > 0) AND date_format(DATE_DELIVER,'%Y-%m-%d') ='".$KEY."'";


}elseif($ID==2){  

$critaire="AND (TIMESTAMPDIFF(day, `DATE_EXPIRATION`, ".$datte_current.") <= 0) AND date_format(DATE_DELIVER,'%Y-%m-%d') ='".$KEY."'";


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
        $intrant[] =$row->NOM_PROPRIETAIRE;
         $intrant[] =$row->DATE_NAISSANCE;
          $intrant[] ='<a href="#" title="'.$row->NUMERO_PERMIS.'" onclick="get_donne_permis(this.title)">'.$row->NUMERO_PERMIS.'</a>';
         $intrant[] =$row->CATEGORIES;
         $intrant[] =$row->DATE_DELIVER;
         $intrant[] =$row->DATE_EXPIRATION;
          $intrant[] =$row->POINTS;
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
$datte_current="CURRENT_TIMESTAMP";
$titre="du  ".strftime('%d-%m-%Y',strtotime(date('Y-m-d')));


if
(empty($mois)){
$titre="du  ".strftime('%d-%m-%Y',strtotime(date('Y-m-d')));
$categorie="date_format(c.DATE_DELIVER,'%Y')";
$categorieid="date_format(c.DATE_DELIVER,'%Y')";
$datte_current="CURRENT_TIMESTAMP";
$criteres1.=" ";
}
if(!empty($mois)){

$criteres1.=" AND date_format(c.DATE_DELIVER,'%Y')='".$mois."'";
$titre="en  ".strftime('%Y',strtotime($mois))." ";
$categorie="date_format(c.DATE_DELIVER,'%Y-%m')";
$categorieid="date_format(c.DATE_DELIVER,'%Y-%m')";
$datte_current="CURRENT_TIMESTAMP";

  }

  if(!empty($jour)){

$criteres1.=" AND date_format(c.DATE_DELIVER,'%Y-%m')= '".$jour."'  ";

$titre="en  ".strftime('%m-%Y',strtotime($jour));
$categorie="date_format(c.DATE_DELIVER,'%Y-%m-%d')";
$categorieid="date_format(c.DATE_DELIVER,'%Y-%m-%d')";
$datte_current="CURRENT_TIMESTAMP"; 
         }
if(!empty($heure)){
$criteres1.=" AND date_format(c.DATE_DELIVER,'%Y-%m-%d')= '".$heure."'  ";

$categorie="date_format(c.DATE_DELIVER,'%Y-%m-%d')";
$categorieid="date_format(c.DATE_DELIVER,'%Y-%m-%d')";
$titre="du  ".strftime('%d-%m-%Y',strtotime($heure));
$datte_current="CURRENT_TIMESTAMP";   
         }

  $datte=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(chauffeur_permis.DATE_DELIVER, "%Y-%m") as mois from chauffeur_permis where DATE_FORMAT(chauffeur_permis.DATE_DELIVER, "%Y")="'.$mois.'" ORDER BY mois DESC');

  $mois_select="<option selected value=''>séléctionner</option>";

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
$datjour=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(chauffeur_permis.DATE_DELIVER, "%Y-%m-%d") as mois from chauffeur_permis where DATE_FORMAT(chauffeur_permis.DATE_DELIVER, "%Y-%m")="'.$jour.'" ORDER BY mois DESC');

  $selectjour="<option  selected value=''>séléctionner</option>";

    foreach ($datjour as $value)
         {

        if ($heure==$value['mois'])
              {
      $selectjour.="<option value='".$value['mois']."' selected>".$value['mois']."</option>";
                                } else{ 
    $selectjour.="<option value='".$value['mois']."'>".$value['mois']."</option>";
      } 
      }



 $control=$this->Model->getRequete(" SELECT COUNT(`ID_PERMIS`) as envoye, ".$categorieid." id , (SELECT COUNT(`ID_PERMIS`) FROM chauffeur_permis c WHERE (TIMESTAMPDIFF(day, `DATE_EXPIRATION`, ".$datte_current.") > 0) AND ".$categorieid." = id ".$criteres1." ) as expire ,(SELECT COUNT(`ID_PERMIS`) FROM chauffeur_permis c WHERE (TIMESTAMPDIFF(day, `DATE_EXPIRATION`, ".$datte_current.") <= 0) AND ".$categorieid." = id  ".$criteres1." ) as valable ,".$categorie." as assure FROM chauffeur_permis c   where 1 ".$criteres1."  GROUP by assure, id ORDER BY assure ASC ");    


$immaeny_categorie=" "; 
$immavalable_categorie=" ";  
$immaexpire_categorie=" ";

$immacat_envoy=0;
$immacat_valable=0;
$immacat_exp=0;

 foreach ($control as  $value) {
     
$key_id1=($value['id']>0) ? $value['id'] : "0" ;

$sommeeny=($value['envoye']>0) ? $value['envoye'] : "0" ;
$sommevalable=($value['valable']>0) ? $value['valable'] : "0" ;
$sommeexp=($value['expire']>0) ? $value['expire'] : "0" ;
$immaeny_categorie.="{name:'".str_replace("'","\'", $value['assure'])."', y:". $sommeeny." ,key2:1,key:'". $key_id1."'},";
$immavalable_categorie.="{name:'".str_replace("'","\'", $value['assure'])."', y:". $sommevalable.",key2:2,key:'". $key_id1."'},";
$immaexpire_categorie.="{name:'".str_replace("'","\'", $value['assure'])."', y:". $sommeexp.",key2:3,key:'". $key_id1."'},";


$immacat_envoy=$immacat_envoy+$value['envoye'];
$immacat_valable=$immacat_valable+$value['valable']; 
$immacat_exp=$immacat_exp+$value['expire'];

     
     }
   
     $rapp="<script type=\"text/javascript\">
    Highcharts.chart('container', {
   
chart: {
        type: 'column'
    },
    title: {
        text: '<b> Rapport des permis  </b> <br> Total : (".number_format($immacat_envoy,0,',',' ').") '
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
             stacking: 'normal',
            borderWidth: 0,
            depth: 40,
             cursor:'pointer',
             point:{
                events: {
 
 
click: function(){

if(this.key2==1){

$(\"#titre\").html(\"  Détail des tous les permis \");
}else if(this.key2==2){
$(\"#titre\").html(\" Détail des permis valides\");
}else{
 $(\"#titre\").html(\" Détail des permis expirées\");   
}

$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Chauffeur_permis/detail')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
keyed:this.keyed,
 mois:$('#mois').val(), 
jour:$('#jour').val(),
heure:$('#heure').val(),
ID_ASSUREUR:$('#ID_ASSUREUR').val(),

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
        name:'Nombre total des permis : (".number_format($immacat_envoy,0,',',' ').")',
        borderColor:\"#FFFF00\",
        data: [".$immaeny_categorie."]
    },
     {
        color: '#6610f2',
        name:'Permis valides : (".number_format($immacat_valable,0,',',' ').")',
        borderColor:\"#f00000\",
        data: [".$immavalable_categorie."]
    },
    {
        color: 'red',
        name:'permis expirés : (".number_format($immacat_exp,0,',',' ').")',
        borderColor:\"#90EE90\", 
        data: [".$immaexpire_categorie."]
    }
    ]

});

</script>
     ";

echo json_encode(array('rapp'=>$rapp,'select_month'=>$mois_select,'selectjour'=>$selectjour));
    }


}
?>






