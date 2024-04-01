
<?php
 /// EDMOND :dashboard des menage
//Fait par edmond le 22/3/2022
class Dashboard_Menage extends CI_Controller
      {
function index(){  
$province=$this->Model->getRequete("SELECT `PROVINCE_ID`,`PROVINCE_NAME` FROM `syst_provinces` WHERE 1 ORDER BY PROVINCE_NAME ASC");
$data['province']=$province;
$cours=date('Y');

$this->load->view('Dashboard_Menage_View',$data);
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



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     
$query_principal='';
if ($KEY2==1) {   
$query_principal="SELECT syst_collines.COLLINE_ID,syst_collines.COLLINE_NAME,syst_zones.ZONE_NAME,syst_communes.COMMUNE_NAME,syst_provinces.PROVINCE_NAME FROM syst_collines JOIN syst_zones ON syst_zones.ZONE_ID=syst_collines.ZONE_ID JOIN syst_communes ON syst_communes.COMMUNE_ID=syst_zones.COMMUNE_ID JOIN syst_provinces ON syst_provinces.PROVINCE_ID=syst_communes.PROVINCE_ID WHERE 1 ".$cond." ";
}
elseif ($KEY2==2) {
$query_principal="SELECT syst_avenue.AVENUE_ID,syst_avenue.AVENUE_NAME,syst_collines.COLLINE_NAME,syst_zones.ZONE_NAME,syst_communes.COMMUNE_NAME,syst_provinces.PROVINCE_NAME FROM syst_avenue JOIN syst_collines  ON syst_collines.COLLINE_ID=syst_avenue.COLLINE_ID JOIN syst_zones ON syst_zones.ZONE_ID=syst_collines.ZONE_ID JOIN syst_communes ON syst_communes.COMMUNE_ID=syst_zones.COMMUNE_ID JOIN syst_provinces ON syst_provinces.PROVINCE_ID=syst_communes.PROVINCE_ID WHERE 1 ".$cond." ";
}elseif ($KEY2==3) {
$query_principal="SELECT menage_maisons.ID_MAISON,menage_maisons.NUMERO_MAISON,syst_collines.COLLINE_NAME,syst_zones.ZONE_NAME,syst_communes.COMMUNE_NAME,syst_provinces.PROVINCE_NAME FROM menage_maisons JOIN syst_collines  ON syst_collines.COLLINE_ID=menage_maisons.COLLINE_ID JOIN syst_zones ON syst_zones.ZONE_ID=syst_collines.ZONE_ID JOIN syst_communes ON syst_communes.COMMUNE_ID=syst_zones.COMMUNE_ID JOIN syst_provinces ON syst_provinces.PROVINCE_ID=syst_communes.PROVINCE_ID WHERE 1 ".$cond." ";
}else{
  
 $query_principal="SELECT menage_appartements.ID_APPARTEMENT,menage_appartements.NUMERO_APPARTEMENT,menage_appartements.NOM_APPARTEMENT,menage_maisons.NUMERO_MAISON,syst_collines.COLLINE_NAME,syst_zones.ZONE_NAME,syst_communes.COMMUNE_NAME,syst_provinces.PROVINCE_NAME FROM `menage_appartements` JOIN  `menage_maisons` ON menage_maisons.ID_MAISON=menage_appartements.ID_MAISON JOIN syst_collines  ON syst_collines.COLLINE_ID=menage_maisons.COLLINE_ID JOIN syst_zones ON syst_zones.ZONE_ID=syst_collines.ZONE_ID JOIN syst_communes ON syst_communes.COMMUNE_ID=syst_zones.COMMUNE_ID JOIN syst_provinces ON syst_provinces.PROVINCE_ID=syst_communes.PROVINCE_ID WHERE 1 ".$cond." "; 
}



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

        $search = !empty($_POST['search']['value']) ? ("AND (syst_collines.COLLINE_NAME LIKE '%$var_search%'  OR syst_zones.ZONE_NAME LIKE '%$var_search%' OR syst_communes.COMMUNE_NAME LIKE '%$var_search%' OR syst_provinces.PROVINCE_NAME LIKE '%$var_search%' ) ") : '';   

        $critaire=' ';

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

 

        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;

        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);

        $data = array();
        foreach ($fetch_data as $row) 
        {
        

         $intrant=array();
         if ($KEY2==1) {
          $coll = (! empty($row->COLLINE_ID)) ?$row->COLLINE_ID: 0 ;
          $chef=$this->Model->getRequeteOne("SELECT CONCAT(NOM,'  ',PRENOM) AS NOM FROM menage_chefs JOIN menage_chef_affectations ON menage_chef_affectations.ID_CHEF=menage_chefs.ID_CHEF  WHERE menage_chef_affectations.COLLINE_ID=".$coll." AND ID_UTILISATEUR  IN (SELECT `ID_UTILISATEUR` FROM `utilisateurs` WHERE `PROFIL_ID` =21)");
           $chef1 = (! empty($chef['NOM'])) ?$chef['NOM']: 'N/A' ;
        $nbre = $this->getNbre_habitant($KEY2,$coll);
         $intrant[] =$row->COLLINE_NAME;
         $intrant[] =$row->ZONE_NAME;
         $intrant[] =$row->COMMUNE_NAME;
         $intrant[] =$row->PROVINCE_NAME;
         $intrant[] =$nbre;
         $intrant[] =$chef1;
         }else if ($KEY2==2) {
        $coll = (! empty($row->AVENUE_ID)) ?$row->AVENUE_ID: 0 ;
        $nbre = $this->getNbre_habitant($KEY2,$coll);
        $chef=$this->Model->getRequeteOne("SELECT CONCAT(NOM,'  ',PRENOM) AS NOM FROM menage_chefs JOIN menage_chef_affectations ON menage_chef_affectations.ID_CHEF=menage_chefs.ID_CHEF  WHERE menage_chef_affectations.ID_AVENUE=".$coll." AND ID_UTILISATEUR  IN (SELECT `ID_UTILISATEUR` FROM `utilisateurs` WHERE `PROFIL_ID` =20)");
        $chef1 = (! empty($chef['NOM'])) ?$chef['NOM']: 'N/A' ;
        $intrant[] =$row->AVENUE_NAME;
        $intrant[] =$row->COLLINE_NAME;
         $intrant[] =$row->ZONE_NAME;
         $intrant[] =$row->COMMUNE_NAME;   
         $intrant[] =$row->PROVINCE_NAME;
         $intrant[] =$nbre;
          $intrant[] =$chef1;
         }else if ($KEY2==3) {
          $coll = (! empty($row->ID_MAISON)) ?$row->ID_MAISON: 0 ;
        $nbre = $this->getNbre_habitant($KEY2,$coll);

        $chef=$this->Model->getRequeteOne("SELECT concat(`NOM`,' ',`PRENOM`) AS NOM FROM menage_appartements JOIN menage_appartement_habitants ON menage_appartement_habitants.ID_APPARTEMENT=menage_appartements.ID_APPARTEMENT JOIN `menage_habitants` ON menage_habitants.ID_HABITANT=menage_appartement_habitants.ID_HABITANT  WHERE menage_appartement_habitants.ID_HABITANT_ROLE=1 AND ID_MAISON=".$coll);
        $chef1 = (! empty($chef['NOM'])) ?$chef['NOM']: 'N/A' ;
         $intrant[] =$row->NUMERO_MAISON;
          $intrant[] =$row->COLLINE_NAME;
         $intrant[] =$row->ZONE_NAME;
         $intrant[] =$row->COMMUNE_NAME;
         $intrant[] =$row->PROVINCE_NAME;
         $intrant[] =$nbre;
          $intrant[] =$chef1;
         }else if ($KEY2==4) {
          $coll = (! empty($row->ID_APPARTEMENT)) ?$row->ID_APPARTEMENT: 0 ;
        $nbre = $this->getNbre_habitant($KEY2,$coll);
        $intrant[] =$row->NUMERO_APPARTEMENT;
        $intrant[] =$row->NOM_APPARTEMENT;
        $intrant[] =$row->NUMERO_MAISON;
          $intrant[] =$row->COLLINE_NAME;
         $intrant[] =$row->ZONE_NAME;
         $intrant[] =$row->COMMUNE_NAME;
         $intrant[] =$row->PROVINCE_NAME;
         $intrant[] =$nbre;

         }
         
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
function getNbre_appertement($id)
    {
$nbre = $this->Modele->getRequeteOne('SELECT mm.ID_MAISON, COUNT(ma.ID_APPARTEMENT) AS nbre FROM  menage_maisons mm LEFT JOIN menage_appartements ma ON ma.ID_MAISON=mm.ID_MAISON WHERE mm.ID_MAISON='.$id.' GROUP BY mm.ID_MAISON ');
      return  !empty($nbre['nbre']) ? $nbre['nbre'] : 0;

     }

     function getNbre_habitant($id,$value)   
    {
      $cond='';
      if ($id==1) {
     $cond=' AND mh.COLLINE_ID='.$value;
      }else if ($id==2) {
     $cond=' AND mh.ID_AVENUE='.$value;
      }else if ($id==3) {
      $cond=' AND mah.ID_APPARTEMENT IN (" SELECT `ID_APPARTEMENT` FROM `menage_appartements` WHERE `ID_MAISON`='.$value.'")';
      }elseif ($id==4) {
       $cond=' AND mah.ID_APPARTEMENT='.$value;
      }



  $nbre = $this->Modele->getRequeteOne('SELECT COUNT(mh.ID_HABITANT) as nbre FROM menage_habitants mh LEFT JOIN menage_appartement_habitants mah ON mah.ID_HABITANT=mh.ID_HABITANT LEFT JOIN menage_appartements ma ON ma.ID_APPARTEMENT=mah.ID_APPARTEMENT WHERE 1 '.$cond.'');
      return  !empty($nbre['nbre']) ? $nbre['nbre'] : 0;

     }
     function get_responsable($id)
     {
$respo = $this->Modele->getRequeteOne('SELECT mh.NOM,mh.PRENOM FROM menage_habitants mh LEFT JOIN menage_appartement_habitants mah ON mah.ID_HABITANT=mh.ID_HABITANT LEFT JOIN menage_appartements ma ON ma.ID_APPARTEMENT=mah.ID_APPARTEMENT WHERE ma.ID_APPARTEMENT='.$id.' AND mah.ID_HABITANT_ROLE=1');
          return  $respo['NOM'].'  '.$respo['PRENOM'] ;

     }
    
public function get_rapport(){ 

$PROVINCE_ID=$this->input->post('PROVINCE_ID');
$COMMUNE_ID=$this->input->post('COMMUNE_ID');
$ZONE_ID=$this->input->post('ZONE_ID');
$COLLINE_ID=$this->input->post('COLLINE_ID');
$categories='syst_provinces.PROVINCE_NAME';
$categorieid='syst_provinces.PROVINCE_ID';

$cond='';
if (empty($PROVINCE_ID)) {
$categories='syst_provinces.PROVINCE_NAME';
$categorieid='syst_provinces.PROVINCE_ID';

}
if(!empty($PROVINCE_ID)){

$categories='syst_communes.COMMUNE_NAME';
$categorieid='syst_communes.COMMUNE_ID';
$cond.=' AND syst_provinces.PROVINCE_ID='.$PROVINCE_ID;
if(!empty($COMMUNE_ID)){
$categories='syst_zones.ZONE_NAME';
$categorieid='syst_zones.ZONE_ID';
$cond.=' AND syst_communes.COMMUNE_ID='.$COMMUNE_ID;
if(!empty($ZONE_ID)){
$categories='syst_collines.COLLINE_NAME';
$categorieid='syst_collines.COLLINE_ID';
$cond.=' AND syst_zones.ZONE_ID='.$ZONE_ID;
if(!empty($COLLINE_ID)){
$categories='syst_collines.COLLINE_NAME';
$categorieid='syst_collines.COLLINE_ID';
$cond.=' AND syst_collines.COLLINE_ID='.$COLLINE_ID;
}
}
}
}


$menage_colline=$this->Model->getRequete("SELECT ".$categorieid." as ID,".$categories." AS NAME, COUNT(`COLLINE_ID`) AS NBRE FROM `syst_collines` JOIN syst_zones ON syst_zones.ZONE_ID=syst_collines.ZONE_ID JOIN syst_communes ON syst_communes.COMMUNE_ID=syst_zones.COMMUNE_ID JOIN syst_provinces ON syst_provinces.PROVINCE_ID=syst_communes.PROVINCE_ID WHERE 1 ".$cond." GROUP BY ".$categorieid.",".$categories."");


$menage_colline_categorie=" ";
$menage_colline_total=0;

foreach ($menage_colline as  $value) {  

$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;

$menage_colline_categorie.="{name:'".$this->str_replacecatego($value['NAME'])."', y:".$value['NBRE'].",key2:1,key:'".$key_id1."'},";
$menage_colline_total=$menage_colline_total+$value['NBRE'];

}

$menage_avenue=$this->Model->getRequete("SELECT ".$categorieid." as ID,".$categories." AS NAME, COUNT(`AVENUE_ID`) AS NBRE FROM `syst_avenue` JOIN syst_collines ON syst_collines.COLLINE_ID=syst_avenue.COLLINE_ID JOIN syst_zones ON syst_zones.ZONE_ID=syst_collines.ZONE_ID JOIN syst_communes ON syst_communes.COMMUNE_ID=syst_zones.COMMUNE_ID JOIN syst_provinces ON syst_provinces.PROVINCE_ID=syst_communes.PROVINCE_ID WHERE 1 ".$cond." GROUP BY ".$categorieid.",".$categories."");

//SELECT `CODE_PROFIL` FROM `profil` WHERE  

$menage_avenue_categorie=" ";
$menage_avenue_total=0;

foreach ($menage_avenue as  $value) {  

$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;

$menage_avenue_categorie.="{name:'".$this->str_replacecatego($value['NAME'])."', y:".$value['NBRE'].",key2:2,key:'".$key_id1."'},";
$menage_avenue_total=$menage_avenue_total+$value['NBRE'];

}


$menage_menage=$this->Model->getRequete("SELECT ".$categorieid." as ID,".$categories." AS NAME,COUNT(`ID_MAISON`)  AS NBRE FROM `menage_maisons` JOIN syst_collines ON syst_collines.COLLINE_ID=menage_maisons.COLLINE_ID JOIN syst_zones ON syst_zones.ZONE_ID=syst_collines.ZONE_ID JOIN syst_communes  ON syst_communes.COMMUNE_ID=syst_zones.COMMUNE_ID JOIN syst_provinces ON syst_provinces.PROVINCE_ID=syst_communes.PROVINCE_ID WHERE 1 ".$cond." GROUP BY ".$categorieid.",".$categories."");

//SELECT `CODE_PROFIL` FROM `profil` WHERE  

$menage_menage_categorie=" ";
$menage_menage_total=0;

foreach ($menage_menage as  $value) {  

$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;

$menage_menage_categorie.="{name:'".$this->str_replacecatego($value['NAME'])."', y:".$value['NBRE'].",key2:3,key:'".$key_id1."'},";
$menage_menage_total=$menage_menage_total+$value['NBRE'];

}

$menage_appart=$this->Model->getRequete("SELECT ".$categorieid." as ID,".$categories." AS NAME,COUNT(`ID_APPARTEMENT`) AS NBRE FROM `menage_appartements` JOIN  `menage_maisons` ON menage_maisons.ID_MAISON=menage_appartements.ID_MAISON JOIN syst_collines ON syst_collines.COLLINE_ID=menage_maisons.COLLINE_ID JOIN syst_zones ON syst_zones.ZONE_ID=syst_collines.ZONE_ID JOIN syst_communes  ON syst_communes.COMMUNE_ID=syst_zones.COMMUNE_ID JOIN syst_provinces ON syst_provinces.PROVINCE_ID=syst_communes.PROVINCE_ID WHERE 1 ".$cond." GROUP BY ".$categorieid.",".$categories."");

//SELECT `CODE_PROFIL` FROM `profil` WHERE  





$menage_appart_categorie=" ";
$menage_appart_total=0;

foreach ($menage_appart as  $value) {  

$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;

$menage_appart_categorie.="{name:'".$this->str_replacecatego($value['NAME'])."', y:".$value['NBRE'].",key2:4,key:'".$key_id1."'},";
$menage_appart_total=$menage_appart_total+$value['NBRE'];

}

 $rappcol="<script type=\"text/javascript\">
Highcharts.chart('containercol', {

chart: {
type: 'column'
},
title: {
text: '<b>Rapport de collines</b><br> Total=".number_format($menage_colline_total,0,',',' ')."'
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
url:\"".base_url('dashboard/Dashboard_Menage/detail')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
 PROVINCE_ID:$('#PROVINCE_ID').val(), 
COMMUNE_ID:$('#COMMUNE_ID').val(),
ZONE_ID:$('#ZONE_ID').val(),
COLLINE_ID:$('#COLLINE_ID').val(),
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
data: [".$menage_colline_categorie."]
}
]
});
</script>
";


$rapp="<script type=\"text/javascript\">

Highcharts.chart('container', {

chart: {
type: 'area'
},
title: {
text: '<b>Rapport des avenues</b><br> Total=".number_format($menage_avenue_total,0,',',' ')."'
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
area: {
pointPadding: 0.2,
borderWidth: 0,
depth: 40,
cursor:'pointer',
point:{
events: {
click: function(){
$(\"#titre1\").html(\"Détail\");   
$(\"#myModal1\").modal();
var row_count ='1000000';
$(\"#mytable1\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Menage/detail')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
 PROVINCE_ID:$('#PROVINCE_ID').val(), 
COMMUNE_ID:$('#COMMUNE_ID').val(),
ZONE_ID:$('#ZONE_ID').val(),
COLLINE_ID:$('#COLLINE_ID').val(),
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
name:'Avenues',
data: [".$menage_avenue_categorie."]
}
]
});

 </script>";

$rapp1="<script type=\"text/javascript\">

Highcharts.chart('container1', {

chart: {
type: 'line'
},
title: {
text: '<b>Rapport des ménages</b><br> Total=".number_format($menage_menage_total,0,',',' ')."'
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
click: function(){
$(\"#titre2\").html(\"Détail\");   
$(\"#myModal2\").modal();
var row_count ='1000000';
$(\"#mytable2\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Menage/detail')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
 PROVINCE_ID:$('#PROVINCE_ID').val(), 
COMMUNE_ID:$('#COMMUNE_ID').val(),
ZONE_ID:$('#ZONE_ID').val(),
COLLINE_ID:$('#COLLINE_ID').val(),
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
name:'menages',
data: [".$menage_menage_categorie."]
}
]
});

 </script>";


$rapp2="<script type=\"text/javascript\">
Highcharts.chart('container2', {

chart: {
type: 'column'
},
title: {
text: '<b>Rapport des appartements</b><br> Total=".number_format($menage_appart_total,0,',',' ')."'
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
$(\"#titre3\").html(\"Détail\");   
$(\"#myModal3\").modal();
var row_count ='1000000';
$(\"#mytable3\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Menage/detail')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
 PROVINCE_ID:$('#PROVINCE_ID').val(), 
COMMUNE_ID:$('#COMMUNE_ID').val(),
ZONE_ID:$('#ZONE_ID').val(),
COLLINE_ID:$('#COLLINE_ID').val(),
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
name:'Appartements',
data: [".$menage_appart_categorie."]
}
]
});
</script>
";

$comm= '<option selected="" disabled="">séléctionner</option>';
$cd= '<option selected="" disabled="">séléctionner</option>';
$zon= '<option selected="" disabled="">séléctionner</option>';
$col= '<option selected="" disabled="">séléctionner</option>';


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

echo json_encode(array('rapp'=>$rapp,'rapp1'=>$rapp1,'rapp2'=>$rapp2,'rappcol'=>$rappcol,'comm'=>$comm,'zon'=>$zon,'col'=>$col));

    }


}
?>




