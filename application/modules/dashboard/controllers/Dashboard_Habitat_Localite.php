
<?php
 /// EDMOND :dashboard des menage
//Fait par edmond le 22/3/2022
class Dashboard_Habitat_Localite extends CI_Controller
      {
function index(){  
$province=$this->Model->getRequete("SELECT `PROVINCE_ID`,`PROVINCE_NAME` FROM `syst_provinces` WHERE 1 ORDER BY PROVINCE_NAME ASC");
$data['province']=$province;
$cours=date('Y');

$this->load->view('Dashboard_Habitat_Localite_View',$data);
     }
function str_replacecatego($name)
  {

$catego=str_replace("'"," ",$name);
$catego=str_replace("  "," ",$catego);
$catego=str_replace("\n"," ",$catego);
$catego=str_replace("\t"," ",$catego);
$catego=str_replace("@"," ",$catego);
$catego=str_replace("&"," ",$catego);
$catego=str_replace(">"," ",$catego);
$catego=str_replace("   "," ",$catego);
$catego=str_replace("?"," ",$catego);
$catego=str_replace("#"," ",$catego);
$catego=str_replace("%"," ",$catego);
$catego=str_replace("%!"," ",$catego);
$catego=str_replace(""," ",$catego);


return $catego;
}
 //detail sur les assurences   
function detail()
    {
$KEY=$this->input->post('key');
$KEY2=$this->input->post('key2');
$PROVINCE_ID=$this->input->post('PROVINCE_ID');
$COMMUNE_ID=$this->input->post('COMMUNE_ID');
$ZONE_ID=$this->input->post('ZONE_ID');
$COLLINE_ID=$this->input->post('COLLINE_ID');
$AVENUE_ID=$this->input->post('AVENUE_ID');
$cond='';
if(!empty($PROVINCE_ID)){

$cond.=" AND syst_provinces.PROVINCE_ID=".$PROVINCE_ID;

}
if(!empty($COMMUNE_ID)){
$cond.=" AND syst_communes.COMMUNE_ID=".$COMMUNE_ID;

}
if(!empty($ZONE_ID)){

$cond.=" AND syst_zones.ZONE_ID=".$ZONE_ID;

}
if(!empty($COLLINE_ID)){

 $cond.=" AND syst_collines.COLLINE_ID=".$COLLINE_ID; 
 
 }   
if(!empty($AVENUE_ID)){

$cond.=' AND syst_avenue.AVENUE_ID='.$AVENUE_ID;
} 

$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     

 $query_principal="SELECT CONCAT(NOM,' ',NOM) AS NOM,NUMERO_IDENTITE,NUMERO_TELEPHONE,DATE_NAISSANCE,menage_appartements.ID_APPARTEMENT,menage_appartements.NUMERO_APPARTEMENT,menage_appartements.NOM_APPARTEMENT,menage_maisons.NUMERO_MAISON,syst_collines.COLLINE_NAME,syst_zones.ZONE_NAME,syst_communes.COMMUNE_NAME,syst_provinces.PROVINCE_NAME FROM  menage_habitants JOIN menage_appartement_habitants ON menage_appartement_habitants.ID_HABITANT=menage_habitants.ID_HABITANT JOIN menage_appartements ON menage_appartements.ID_APPARTEMENT=menage_appartement_habitants.ID_APPARTEMENT JOIN  menage_maisons ON menage_maisons.ID_MAISON=menage_appartements.ID_MAISON JOIN syst_collines ON syst_collines.COLLINE_ID=menage_maisons.COLLINE_ID JOIN syst_zones ON syst_zones.ZONE_ID=syst_collines.ZONE_ID JOIN syst_communes  ON syst_communes.COMMUNE_ID=syst_zones.COMMUNE_ID JOIN syst_provinces ON syst_provinces.PROVINCE_ID=syst_communes.PROVINCE_ID WHERE 1   "; 


        $limit='LIMIT 0,10';
        if($_POST['length'] != -1)
        {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $order_by='';
        if($_POST['order']['0']['column']!=0)
        {
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY DATE_VALIDITE  DESC'; 
        }

        $search = !empty($_POST['search']['value']) ? ("AND (syst_collines.COLLINE_NAME LIKE '%$var_search%'  OR syst_zones.ZONE_NAME LIKE '%$var_search%' OR syst_communes.COMMUNE_NAME LIKE '%$var_search%' OR syst_provinces.PROVINCE_NAME LIKE '%$var_search%' OR CONCAT(NOM,' ',NOM)  LIKE '%$var_search%' OR NUMERO_IDENTITE LIKE '%$var_search%'OR NUMERO_TELEPHONE LIKE '%$var_search%' OR DATE_NAISSANCE LIKE '%$var_search%' ) ") : ''; 


          

$critaire=" AND syst_provinces.PROVINCE_ID=".$KEY;

if(empty($PROVINCE_ID)){

$critaire=" AND syst_provinces.PROVINCE_ID=".$KEY;

}
if(!empty($PROVINCE_ID)){

$critaire=" AND syst_communes.COMMUNE_ID=".$KEY;

}
if(!empty($COMMUNE_ID)){
$critaire=" AND syst_zones.ZONE_ID=".$KEY;

}
if(!empty($ZONE_ID)){

$critaire=" AND syst_collines.COLLINE_ID=".$KEY;

}
if(!empty($COLLINE_ID)){

$critaire=" AND syst_collines.COLLINE_ID=".$KEY; 
 
 }
 if(!empty($AVENUE_ID)){

$critaire=" AND menage_maisons.ID_MAISON=".$KEY; 
 
 }

 

        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;

        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);

        $data = array();
        foreach ($fetch_data as $row) 
        {
        

         $intrant=array();
         $coll = (! empty($row->ID_MAISON)) ?$row->ID_MAISON: 0 ;
       
        $chef=$this->Model->getRequeteOne("SELECT concat(`NOM`,' ',`PRENOM`) AS NOM FROM menage_appartements JOIN menage_appartement_habitants ON menage_appartement_habitants.ID_APPARTEMENT=menage_appartements.ID_APPARTEMENT JOIN `menage_habitants` ON menage_habitants.ID_HABITANT=menage_appartement_habitants.ID_HABITANT  WHERE menage_appartement_habitants.ID_HABITANT_ROLE=1 AND ID_MAISON=".$coll);
        $chef1 = (! empty($chef['NOM'])) ?$chef['NOM']: 'N/A' ;
         $intrant[] =$row->NOM;
         $intrant[] =$row->NUMERO_IDENTITE;
         $intrant[] =$row->NUMERO_TELEPHONE;
         $intrant[] =$row->DATE_NAISSANCE;
         $intrant[] =$row->NUMERO_MAISON;
          $intrant[] =$chef1;
         $intrant[] =$row->COLLINE_NAME." ".$row->ZONE_NAME." ".$row->COMMUNE_NAME." ".$row->PROVINCE_NAME;

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

$PROVINCE_ID=$this->input->post('PROVINCE_ID');
$COMMUNE_ID=$this->input->post('COMMUNE_ID');
$ZONE_ID=$this->input->post('ZONE_ID');
$COLLINE_ID=$this->input->post('COLLINE_ID');
$AVENUE_ID=$this->input->post('AVENUE_ID');
$categories='syst_provinces.PROVINCE_NAME';
$categorieid='syst_provinces.PROVINCE_ID';

$cond='';
$num='';
if (empty($PROVINCE_ID)) {
$categories='syst_provinces.PROVINCE_NAME';
$categorieid='syst_provinces.PROVINCE_ID';
$titre='par province';
}
if(!empty($PROVINCE_ID)){

$categories='syst_communes.COMMUNE_NAME';
$categorieid='syst_communes.COMMUNE_ID';
$cond.=' AND syst_provinces.PROVINCE_ID='.$PROVINCE_ID;
$titre='par commune';
if(!empty($COMMUNE_ID)){
$categories='syst_zones.ZONE_NAME';
$categorieid='syst_zones.ZONE_ID';
$cond.=' AND syst_communes.COMMUNE_ID='.$COMMUNE_ID;
$titre='par zone';
if(!empty($ZONE_ID)){
$categories='syst_collines.COLLINE_NAME';
$categorieid='syst_collines.COLLINE_ID';
$cond.=' AND syst_zones.ZONE_ID='.$ZONE_ID;
$titre='par colline';
if(!empty($COLLINE_ID)){
$categories='syst_avenue.AVENUE_NAME';
$categorieid='syst_avenue.AVENUE_ID';
$cond.=' AND syst_collines.COLLINE_ID='.$COLLINE_ID;
$titre='par avenue';
if(!empty($AVENUE_ID)){
$categories='menage_maisons.NUMERO_MAISON';
$categorieid='menage_maisons.ID_MAISON';
$cond.=' AND syst_avenue.AVENUE_ID='.$AVENUE_ID;
$titre='par maison';
$num="No  ";
}
}
}
}
}


$menage_habiatat=$this->Model->getRequete("SELECT ".$categorieid." as ID,".$categories." AS NAME,COUNT(menage_habitants.ID_HABITANT) AS NBRE FROM  menage_habitants JOIN menage_appartement_habitants ON menage_appartement_habitants.ID_HABITANT=menage_habitants.ID_HABITANT JOIN menage_appartements ON menage_appartements.ID_APPARTEMENT=menage_appartement_habitants.ID_APPARTEMENT JOIN  menage_maisons ON menage_maisons.ID_MAISON=menage_appartements.ID_MAISON JOIN syst_collines ON syst_collines.COLLINE_ID=menage_maisons.COLLINE_ID JOIN syst_zones ON syst_zones.ZONE_ID=syst_collines.ZONE_ID JOIN syst_communes  ON syst_communes.COMMUNE_ID=syst_zones.COMMUNE_ID JOIN syst_provinces ON syst_provinces.PROVINCE_ID=syst_communes.PROVINCE_ID JOIN syst_avenue ON menage_maisons.ID_AVENUE=syst_avenue.AVENUE_ID WHERE 1 ".$cond." GROUP BY ".$categorieid.",".$categories."");


$menage_habiatat_categorie=" ";
$menage_habiatat_total=0;

foreach ($menage_habiatat as  $value) {  

$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;

$menage_habiatat_categorie.="{name:'".$num."".$this->str_replacecatego($value['NAME'])."', y:".$value['NBRE'].",key2:1,key:'".$key_id1."'},";
$menage_habiatat_total=$menage_habiatat_total+$value['NBRE'];

}



 $rapphab="<script type=\"text/javascript\">
Highcharts.chart('containerhab', {

chart: {
type: 'column'
},
title: {
text: '<b>Rapport des habitats ".$titre."</b><br> Total=".number_format($menage_habiatat_total,0,',',' ')."'
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
click: function(){
$(\"#titre\").html(\"Détail\");   
$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Habitat_Localite/detail')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
 PROVINCE_ID:$('#PROVINCE_ID').val(), 
COMMUNE_ID:$('#COMMUNE_ID').val(),
ZONE_ID:$('#ZONE_ID').val(),
COLLINE_ID:$('#COLLINE_ID').val(),
AVENUE_ID:$('#AVENUE_ID').val(),


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
showInLegend: false
}
}, 
credits: {
enabled: true,
href: \"\",
text: \"Mediabox\"
},

series: [
{

colorByPoint: true,
name:'Documents',
data: [".$menage_habiatat_categorie."]
}
]
});
</script>
";


$comm= '<option selected="" disabled="">séléctionner</option>';
$cd= '<option selected="" disabled="">séléctionner</option>';
$zon= '<option selected="" disabled="">séléctionner</option>';
$col= '<option selected="" disabled="">séléctionner</option>';
$av= '<option selected="" disabled="">séléctionner</option>';


if (!empty($PROVINCE_ID)) {

$critere['PROVINCE_ID'] = $PROVINCE_ID;

$communes = $this->Model->getList('syst_communes', $critere);


foreach ($communes as $commun) {
if (!empty($COMMUNE_ID)) {
  
if ($COMMUNE_ID==$commun['COMMUNE_ID']) {
$comm.= "<option value ='".$commun['COMMUNE_ID']."' selected>".$commun['COMMUNE_NAME']."</option>";
}
else{
$comm.= "<option value ='".$commun['COMMUNE_ID']."'>".$commun['COMMUNE_NAME']."</option>";
}

}else{
$comm.= "<option value ='".$commun['COMMUNE_ID']."'>".$commun['COMMUNE_NAME']."</option>";
}
}
}

if (!empty($COMMUNE_ID)) {
  $critere2['COMMUNE_ID'] = $COMMUNE_ID;
  $zones = $this->Model->getList('syst_zones', $critere2);
  


  foreach ($zones as $zo) {
  if (!empty($ZONE_ID)) {
  if ($ZONE_ID==$zo['ZONE_ID']) {
  $zon.= "<option value ='".$zo['ZONE_ID']."' selected>".$zo['ZONE_NAME']."</option>";
  }
  else{
  $zon.= "<option value ='".$zo['ZONE_ID']."'>".$zo['ZONE_NAME']."</option>";
  }
  
  }else{
  $zon.= "<option value ='".$zo['ZONE_ID']."'>".$zo['ZONE_NAME']."</option>";
  } 
  }

}

if (!empty($COMMUNE_ID)) {
  $critere2['COMMUNE_ID'] = $COMMUNE_ID;
  
    }

if (!empty($ZONE_ID)) {
  $critere1['ZONE_ID'] = $ZONE_ID;
  $collines = $this->Model->getList('syst_collines', $critere1);

foreach ($collines as $coll) {
  if (!empty($COLLINE_ID)) {
  if ($COLLINE_ID==$coll['COLLINE_ID']) {
  $col.= "<option value ='".$coll['COLLINE_ID']."' selected>".$coll['COLLINE_NAME']."</option>";
  }
  else{
  $col.= "<option value ='".$coll['COLLINE_ID']."'>".$coll['COLLINE_NAME']."</option>";
  }
  
  }else{
  $col.= "<option value ='".$coll['COLLINE_ID']."'>".$coll['COLLINE_NAME']."</option>";
      } 
    }

 }

 if (!empty($COLLINE_ID)) {
  $critereed['COLLINE_ID'] = $COLLINE_ID;
  $avenues = $this->Model->getList('syst_avenue', $critereed);

foreach ($avenues as $avv) {
  if (!empty($AVENUE_ID)) {
  if ($AVENUE_ID==$avv['AVENUE_ID']) {
  $av.= "<option value ='".$avv['AVENUE_ID']."' selected>".$avv['AVENUE_NAME']."</option>";
  }
  else{
  $av.= "<option value ='".$avv['AVENUE_ID']."'>".$avv['AVENUE_NAME']."</option>";
  }
  
  }else{
  $av.= "<option value ='".$avv['AVENUE_ID']."'>".$avv['AVENUE_NAME']."</option>";
      } 
    }

 }

echo json_encode(array('rapphab'=>$rapphab,'comm'=>$comm,'zon'=>$zon,'col'=>$col,'av'=>$av));  

    }


}
?>




