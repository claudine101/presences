
<?php
 /// EDMOND :dashboard des CONTROL
class Dashboard_controle_tech extends CI_Controller
      {
function index(){

$dattes=$this->Model->getRequete("SELECT DISTINCT date_format(otraco_controles.`DATE_INSERTION`,'%Y') AS mois FROM otraco_controles ORDER BY  mois ASC");
  $mois=$this->input->post('mois');



$data['dattes']=$dattes;
$this->load->view('Dashboard_Controle_Tech_View',$data);
     }

    
function detail()
    {
    
  $mois=$this->input->post('mois');
  $jour=$this->input->post('jour');
  $heure=$this->input->post('heure');
 $KEY=$this->input->post('key');
 $KEY2=$this->input->post('key2');
$break=explode(".",$KEY2);
$ID=$KEY2;
        
$criteres_date="";

        
if(!empty($mois)){

$criteres_date.=" AND date_format(otraco_controles.`DATE_INSERTION`,'%Y')='".$mois."'"; 
        }

if(!empty($jour)){

$criteres_date.=" AND date_format(otraco_controles.`DATE_INSERTION`,'%Y-%m')='".$jour."'";
        }



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal=" SELECT `NUMERO_CARTE_ROSE`,otraco_controles.`NUMERO_PLAQUE`,`MARQUE_VOITURE`,`PROPRIETAIRE`,`PRENOM_PROPRIETAIRE`,`TELEPHONE`,`PROVINCE`,`ANNEE_FABRICATION`,`MODELE_VOITURE` FROM `otraco_controles` LEFT JOIN obr_immatriculations_voitures ON obr_immatriculations_voitures.NUMERO_PLAQUE=otraco_controles.NUMERO_PLAQUE WHERE 1 ".$criteres_date."  ";

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

        $search = !empty($_POST['search']['value']) ? ("AND (NUMERO_CARTE_ROSE LIKE '%$var_search%'  OR otraco_controles.`NUMERO_PLAQUE` LIKE '%$var_search%' OR MARQUE_VOITURE LIKE '%$var_search%' OR PROPRIETAIRE LIKE '%$var_search%' OR PROVINCE LIKE '%$var_search%' ) ") : '';   

         $critaire='';

        
       if(!empty($mois) && empty($jour)){
       if($ID==5){  

         $critaire=" AND otraco_controles.`NUMERO_PLAQUE` NOT IN (SELECT NUMERO_PLAQUE from historiques WHERE ID_CONTROLE_TECHNIQUE_PEINE IS NOT NULL) AND date_format(otraco_controles.DATE_INSERTION,'%Y-%m')='".$KEY."'";


        }elseif($ID==4){  

        $critaire=" AND otraco_controles.`NUMERO_PLAQUE` IN (SELECT NUMERO_PLAQUE from historiques WHERE ID_CONTROLE_TECHNIQUE_PEINE IS NOT NULL) AND date_format(otraco_controles.DATE_INSERTION,'%Y-%m')='".$KEY."'";


        }elseif($ID==3){  

        $critaire=" AND `DATE_VALIDITE` <NOW() AND date_format(otraco_controles.DATE_INSERTION,'%Y-%m')='".$KEY."'";


        }elseif ($ID==2) { 

          $critaire=" AND `DATE_VALIDITE` >=NOW() AND date_format(otraco_controles.DATE_INSERTION,'%Y-%m')='".$KEY."'";
        }
        elseif ($ID==1) {

            $critaire=" AND date_format(otraco_controles.DATE_INSERTION,'%Y-%m')='".$KEY."'";
        }
        }
        elseif(!empty($mois) && !empty($jour)){
        if($ID==5){  

        $critaire=" AND otraco_controles.`NUMERO_PLAQUE` NOT IN (SELECT NUMERO_PLAQUE from historiques WHERE ID_CONTROLE_TECHNIQUE_PEINE IS NOT NULL) AND date_format(otraco_controles.DATE_INSERTION,'%Y-%m-%d')='".$KEY."'";


        }elseif($ID==4){  

        $critaire=" AND otraco_controles.`NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from historiques WHERE ID_CONTROLE_TECHNIQUE_PEINE IS NOT NULL) AND date_format(otraco_controles.DATE_INSERTION,'%Y-%m-%d')='".$KEY."'";


        }elseif($ID==3){  

        $critaire=" AND `DATE_VALIDITE` <NOW() AND date_format(otraco_controles.DATE_INSERTION,'%Y-%m-%d')='".$KEY."'";


        }elseif ($ID==2) { 

          $critaire=" AND `DATE_VALIDITE` >=NOW() AND date_format(otraco_controles.DATE_INSERTION,'%Y-%m-%d')='".$KEY."'";
        }
        elseif ($ID==1) {

            $critaire="  AND date_format(otraco_controles.DATE_INSERTION,'%Y-%m-%d')='".$KEY."'";
        }    
        } 
        else{
             if($ID==5){  

        $critaire=" AND otraco_controles.`NUMERO_PLAQUE` NOT IN (SELECT NUMERO_PLAQUE from historiques WHERE ID_CONTROLE_TECHNIQUE_PEINE IS NOT NULL) AND date_format(otraco_controles.DATE_INSERTION,'%Y')='".$KEY."'";


        }elseif($ID==4){  

        $critaire=" AND otraco_controles.`NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from historiques WHERE ID_CONTROLE_TECHNIQUE_PEINE IS NOT NULL) AND date_format(otraco_controles.DATE_INSERTION,'%Y')='".$KEY."'";


        }elseif($ID==3){  

        $critaire=" AND `DATE_VALIDITE` <NOW() AND date_format(otraco_controles.DATE_INSERTION,'%Y')='".$KEY."'";


        }elseif ($ID==2) { 

          $critaire=" AND `DATE_VALIDITE` >=NOW() AND date_format(otraco_controles.DATE_INSERTION,'%Y')='".$KEY."'";
        }
        elseif ($ID==1) {

            $critaire="  AND date_format(otraco_controles.DATE_INSERTION,'%Y')='".$KEY."'";
        }
        }
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);
        $u=0;
        $data = array();
        foreach ($fetch_data as $row) 
        {

   

      if($ID==3 OR $ID==2)
      {
         $exite=$this->Model->getRequeteOne('SELECT MAX(`DATE_VALIDITE`) as valide,`DATE_DEBUT` FROM `otraco_controles` WHERE NUMERO_PLAQUE="'.$row->NUMERO_PLAQUE.'" GROUP BY DATE_DEBUT,DATE_VALIDITE');
         $intrant[] =$exite['DATE_DEBUT'];
         $intrant[] =$exite['valide'];
       $var_lieu = (!empty($exite['DATE_DEBUT'])) ? $exite['DATE_DEBUT'] : '' ;
       $var_lieu1 = (!empty($exite['valide'])) ? $exite['valide'] : '' ;
      }else{
     $var_lieu ='' ;
       $var_lieu1 = '' ;

      }

    
         $u++;
         $intrant=array();
         $intrant[] = $u;
        $intrant[] =$row->PROPRIETAIRE;
         $intrant[] =$row->TELEPHONE;
          $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NUMERO_CARTE_ROSE;
         $intrant[] =$row->MODELE_VOITURE;
         $intrant[] =$var_lieu;
         $intrant[] =$var_lieu1;
         $intrant[] =$row->PROVINCE;
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

if
(empty($mois)){

$categorie="date_format(otraco_controles.`DATE_INSERTION`,'%Y')";
$criteres1.="";
}
if
(!empty($mois)){


$criteres1.=" AND date_format(otraco_controles.`DATE_INSERTION`,'%Y')='".$mois."'";

$categorie="date_format(otraco_controles.`DATE_INSERTION`,'%Y-%m')";


  }

  if(!empty($jour)){
     $criteres1.=" AND date_format(otraco_controles.`DATE_INSERTION`,'%Y-%m')= '".$jour."'  ";


    $categorie="date_format(otraco_controles.`DATE_INSERTION`,'%Y-%m-%d')";
    
         }
if(!empty($heure)){
     $criteres1.=" AND date_format(otraco_controles.`DATE_INSERTION`,'%Y-%m-%d')= '".$heure."'  ";

$categorie="date_format(otraco_controles.`DATE_INSERTION`,'%Y-%m-%d')";
    
         }

  $datte=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(otraco_controles.`DATE_INSERTION`, "%Y-%m") as mois from otraco_controles where DATE_FORMAT(otraco_controles.`DATE_INSERTION`, "%Y")="'.$mois.'" ORDER BY mois DESC');

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

      ////
$datjour=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(otraco_controles.DATE_INSERTION, "%Y-%m-%d") as mois from otraco_controles where DATE_FORMAT(otraco_controles.DATE_INSERTION, "%Y-%m")="'.$jour.'" ORDER BY mois DESC');

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

    $control=$this->Model->getRequete("SELECT ".$categorie." AS mois,COUNT(`ID_CONTROLE`) AS envoye,(SELECT COUNT(ID_CONTROLE) FROM otraco_controles WHERE `DATE_VALIDITE` <NOW() AND ".$categorie." = mois) AS expire,(SELECT COUNT(ID_CONTROLE) FROM otraco_controles WHERE `DATE_VALIDITE` >=NOW() AND ".$categorie." = mois) AS valable,(SELECT COUNT(ID_CONTROLE) FROM otraco_controles WHERE `NUMERO_PLAQUE` in (SELECT NUMERO_PLAQUE from historiques WHERE ID_CONTROLE_TECHNIQUE_PEINE IS NOT NULL) AND ".$categorie." = mois) AS controle,(SELECT COUNT(ID_CONTROLE) FROM otraco_controles WHERE `NUMERO_PLAQUE`not in (SELECT NUMERO_PLAQUE from historiques WHERE ID_CONTROLE_TECHNIQUE_PEINE IS NOT NULL) AND ".$categorie." = mois) AS non_controle FROM otraco_controles WHERE 1 ".$criteres1." GROUP BY mois ORDER BY mois ASC"); 



$immaeny_categorie=" ";
$immavalable_categorie=" ";  
$immaexpire_categorie=" ";
$immacontrole_categorie=" ";
$immadnon_categorie=" ";

$immacat_envoy=0;
$immacat_valable=0;
$immacat_exp=0;
$immacat_controle=0;
$immacat_non=0;
 foreach ($control as  $value) {  
      
      
$key_id1=($value['mois']>0) ? $value['mois'] : "0" ;
$sommeeny=($value['envoye']>0) ? $value['envoye'] : "0" ;
$sommevalable=($value['valable']>0) ? $value['valable'] : "0" ;
$sommecontrole=($value['controle']>0) ? $value['controle'] : "0" ;
$sommeexp=($value['expire']>0) ? $value['expire'] : "0" ;
$sommenon=($value['non_controle']>0) ? $value['non_controle'] : "0" ;
$immaeny_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $sommeeny." ,key2:1,key:'". $key_id1."'},";
$immavalable_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $sommevalable.",key2:2,key:'". $key_id1."'},";
$immaexpire_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $sommeexp.",key2:3,key:'". $key_id1."'},";
$immacontrole_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $sommecontrole.",key2:4,key:'". $key_id1."'},";
$immadnon_categorie.="{name:'".str_replace("'","\'", $value['mois'])."', y:". $sommenon.",key2:5,key:'". $key_id1."'},";

$immacat_envoy=$immacat_envoy+$value['envoye'];
$immacat_valable=$immacat_valable+$value['valable']; 
$immacat_exp=$immacat_exp+$value['expire'];
$immacat_controle=$immacat_controle+$value['controle'];
$immacat_non=$immacat_non+$value['non_controle'];

     
     }
   
     $rapp="<script type=\"text/javascript\">
    Highcharts.chart('container', {
   
chart: {
        type: 'column'
    },
    title: {
        text: '<b> Rapport  </b> du ".date('d-m-Y')." '
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
$(\"#titre\").html(\" Détail \");
$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_controle_tech/detail')."\",
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
        name:'Controles envoyés : (".number_format($immacat_envoy,0,',',' ').")',
        borderColor:\"#FFFF00\",
        data: [".$immaeny_categorie."]
    },
     {
        color: 'yellow',
        name:'Controles valable : (".number_format($immacat_valable,0,',',' ').")',
        borderColor:\"#f00000\",
        data: [".$immavalable_categorie."]
    },
    {
        color: 'pink',
        name:'Controles expirés : (".number_format($immacat_exp,0,',',' ').")',
        borderColor:\"#90EE90\", 
        data: [".$immaexpire_categorie."]
    },
    {
        color: '#582900',
        name:'Deja controlé : (".number_format($immacat_controle,0,',',' ').")',
        borderColor:\"#90EE90\", 
        data: [".$immacontrole_categorie."]
    }
    ,
    {
        color: '#000000',
        name:'Non encore controlé : (".number_format($immacat_non,0,',',' ').")',
        borderColor:\"#90EE90\", 
        data: [".$immadnon_categorie."]
    }
    ]

});
</script>
     ";



echo json_encode(array('rapp'=>$rapp,'select_month'=>$mois_select,'selectjour'=>$selectjour));
    }


}
?>




