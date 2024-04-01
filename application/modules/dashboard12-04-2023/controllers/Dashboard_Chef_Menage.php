
<?php
 /// EDMOND :dashboard des chefs des menages
//Fait par edmond le 15/3/2022
class Dashboard_Chef_Menage extends CI_Controller
      {
function index(){  
$province=$this->Model->getRequete("SELECT `PROVINCE_ID`,`PROVINCE_NAME` FROM `syst_provinces` WHERE 1 ORDER BY PROVINCE_NAME ASC");
$data['province']=$province;
$cours=date('Y');

$this->load->view('Dashboard_Chef_Menage_View',$data);
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
$cond1='';
$cond2='';


if(!empty($PROVINCE_ID)){

$cond.=" AND menage_chef_affectations.PROVINCE_ID=".$PROVINCE_ID;

if(!empty($COMMUNE_ID)){

$cond.=" AND menage_chef_affectations.COMMUNE_ID=".$COMMUNE_ID;

if(!empty($ZONE_ID)){

$cond1.=" AND menage_chef_affectations.ZONE_ID=".$ZONE_ID;
if(!empty($COLLINE_ID)){

 $cond2.=" AND menage_chef_affectations.COLLINE_ID=".$COLLINE_ID; 

}
}
}
}

if ($KEY2==1) {
$cond.=' AND ID_UTILISATEUR IN (SELECT `ID_UTILISATEUR` FROM `utilisateurs` WHERE `PROFIL_ID` =25)';
}else if($KEY2==2){
$cond.=' AND ID_UTILISATEUR IN (SELECT `ID_UTILISATEUR` FROM `utilisateurs` WHERE `PROFIL_ID` =26)  '.$cond1.'' ;
}
else if($KEY2==3){
$cond.=' AND ID_UTILISATEUR IN (SELECT `ID_UTILISATEUR` FROM `utilisateurs` WHERE `PROFIL_ID` =24) '.$cond1.' '.$cond2.'';
}

$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal="SELECT CONCAT(NOM,' ',PRENOM) AS chef,`NUMERO_MATRICULE`,`DATE_NAISSANCE`,`TELEPHONE`,`EMAIL`,`PHOTO`,syst_provinces.PROVINCE_NAME,syst_communes.COMMUNE_NAME,syst_zones.ZONE_NAME,syst_collines.COLLINE_NAME FROM `menage_chefs` JOIN menage_chef_affectations ON menage_chef_affectations.ID_CHEF=menage_chefs.ID_CHEF LEFT JOIN syst_provinces ON syst_provinces.PROVINCE_ID=menage_chef_affectations.PROVINCE_ID LEFT JOIN syst_communes ON syst_communes.COMMUNE_ID=menage_chef_affectations.COMMUNE_ID LEFT JOIN syst_zones ON syst_zones.ZONE_ID=menage_chef_affectations.ZONE_ID LEFT JOIN syst_collines ON syst_collines.COLLINE_ID=menage_chef_affectations.COLLINE_ID  WHERE 1 ".$cond." ";

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

        $search = !empty($_POST['search']['value']) ? ("AND (CONCAT(NOM,' ',PRENOM) LIKE '%$var_search%'  OR `NUMERO_MATRICULE` LIKE '%$var_search%' OR `DATE_NAISSANCE` LIKE '%$var_search%' OR `TELEPHONE` LIKE '%$var_search%' OR syst_provinces.PROVINCE_NAME LIKE '%$var_search%' OR syst_communes.COMMUNE_NAME LIKE '%$var_search%' OR syst_zones.ZONE_NAME LIKE '%$var_search%' OR syst_collines.COLLINE_NAME LIKE '%$var_search%' ) ") : '';   

        $critaire=' ';

if(empty($PROVINCE_ID)){
  $critaire=" AND menage_chef_affectations.PROVINCE_ID=".$KEY;
}


if(!empty($PROVINCE_ID)){
$critaire=" AND menage_chef_affectations.COMMUNE_ID=".$KEY;

}
if(!empty($COMMUNE_ID)){

$critaire=" AND menage_chef_affectations.ZONE_ID=".$KEY;

}

 if(!empty($ZONE_ID)){
if ($KEY2==2 || $KEY2==3) {
 $critaire=" AND menage_chef_affectations.COLLINE_ID=".$KEY; 
}else{
  $critaire=" AND menage_chef_affectations.ZONE_ID=".$KEY;

}

 
 } 
  if(!empty($COLLINE_ID)){
  if ($KEY2==3) {
  $critaire=" AND menage_chef_affectations.ID_AVENUE=".$KEY;
 }else if ($KEY2==2) {
 $critaire=" AND menage_chef_affectations.COLLINE_ID=".$KEY; 
 }else{
 $critaire=" AND menage_chef_affectations.ZONE_ID=".$KEY; 
 }
 }
 
 
    
        $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;

        $query_filter=$query_principal.'  '.$critaire.' '.$search;

        $fetch_data = $this->Model->datatable($query_secondaire);

        $data = array();
        foreach ($fetch_data as $row) 
        {
if (!empty($row->PHOTO)) {
 $source = $row->PHOTO;
}
$source = base_url()."/uploads/personne.png";          

         $intrant=array();
         $intrant[] = '<table> <tbody><tr><td><a href="' . $source. '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->chef . ' </td></tr></tbody></table></a>';
        $intrant[] =$row->NUMERO_MATRICULE;
         $intrant[] =$row->TELEPHONE;
         $intrant[] =$row->EMAIL;
         $intrant[] =$row->PROVINCE_NAME." ".$row->COMMUNE_NAME." ".$row->ZONE_NAME." ".$row->COLLINE_NAME;
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

$DATE1=$this->input->post('DATE1');
$DATE2=$this->input->post('DATE2');
$PROVINCE_ID=$this->input->post('PROVINCE_ID');
$COMMUNE_ID=$this->input->post('COMMUNE_ID');
$ZONE_ID=$this->input->post('ZONE_ID');
$COLLINE_ID=$this->input->post('COLLINE_ID');
$categories='syst_provinces.PROVINCE_NAME';
$categorieid='syst_provinces.PROVINCE_ID';
$catemenage='menage_chefs.PROVINCE_ID';
$localite='syst_provinces';

$categories1='syst_provinces.PROVINCE_NAME';
$categorieid1='syst_provinces.PROVINCE_ID';
$catemenage1='affect.PROVINCE_ID';
$localite1='syst_provinces';

$categories2='syst_provinces.PROVINCE_NAME';
$categorieid2='syst_provinces.PROVINCE_ID';
$catemenage2='affect.PROVINCE_ID';
$localite2='syst_provinces';
$cond='';
$cond1='';
$cond2='';
if( !empty($DATE1) && !empty($DATE2) ){
$cond=" and DATE_FORMAT(DATE_INSERT, '%Y-%m-%d') BETWEEN '" . $DATE1."' AND '" . $DATE2."'";

      }
if( !empty($DATE1) && empty($DATE2) ){
$cond=" and DATE_FORMAT(DATE_INSERT, '%Y-%m-%d') BETWEEN '" . $DATE1."' AND '" . $DATE2."'";

      }
if( empty($DATE1) && !empty($DATE2) ){
$cond=" and DATE_FORMAT(DATE_INSERT, '%Y-%m-%d') BETWEEN '" . $DATE1."' AND '" . $DATE2."'";

      }
if (empty($PROVINCE_ID)) {
$categories='syst_provinces.PROVINCE_NAME';
$categorieid='syst_provinces.PROVINCE_ID';
$catemenage='affect.PROVINCE_ID';
$localites='syst_provinces';

$categories1='syst_provinces.PROVINCE_NAME';
$categorieid1='syst_provinces.PROVINCE_ID';
$catemenage1='affect.PROVINCE_ID';
$localites1='syst_provinces';

$categories2='syst_provinces.PROVINCE_NAME';
$categorieid2='syst_provinces.PROVINCE_ID';
$catemenage2='affect.PROVINCE_ID';
$localites2='syst_provinces';
$localititre='province';
}
if(!empty($PROVINCE_ID)){

$categories='syst_communes.COMMUNE_NAME';
$categorieid='syst_communes.COMMUNE_ID';
$catemenage='affect.COMMUNE_ID';
$cond.=" AND affect.PROVINCE_ID=".$PROVINCE_ID;

$localite='syst_communes';

$categories1='syst_communes.COMMUNE_NAME';
$categorieid1='syst_communes.COMMUNE_ID';
$catemenage1='affect.COMMUNE_ID';
$cond1.=" AND affect.PROVINCE_ID=".$PROVINCE_ID;

$localite1='syst_communes';

$categories2='syst_communes.COMMUNE_NAME';
$categorieid2='syst_communes.COMMUNE_ID';
$catemenage2='affect.COMMUNE_ID';
$cond2.=" AND affect.PROVINCE_ID=".$PROVINCE_ID;

$localite2='syst_communes';

$localititre='commune';
if(!empty($COMMUNE_ID)){
$categories='syst_zones.ZONE_NAME';
$categorieid='syst_zones.ZONE_ID';
$catemenage='affect.ZONE_ID';
$localite='syst_zones';
$cond.=" AND affect.COMMUNE_ID=".$COMMUNE_ID;

$categories1='syst_zones.ZONE_NAME';
$categorieid1='syst_zones.ZONE_ID';
$catemenage1='affect.ZONE_ID';
$localite1='syst_zones';
$cond1.=" AND affect.COMMUNE_ID=".$COMMUNE_ID;

$categories2='syst_zones.ZONE_NAME';
$categorieid2='syst_zones.ZONE_ID';
$catemenage2='affect.ZONE_ID';
$localite2='syst_zones';
$cond2.=" AND affect.COMMUNE_ID=".$COMMUNE_ID;

$localititre='zone';
if(!empty($ZONE_ID)){
$categories1='syst_collines.COLLINE_NAME';
$categorieid1='syst_collines.COLLINE_ID';
$catemenage1='affect.COLLINE_ID';
$localite1='syst_collines';
$categories2='syst_collines.COLLINE_NAME';
$categorieid2='syst_collines.COLLINE_ID';
$catemenage2='affect.COLLINE_ID';
$localite2='syst_collines';

$localititre='colline';
$cond1.=" AND affect.ZONE_ID=".$ZONE_ID;
$cond2.=" AND affect.ZONE_ID=".$ZONE_ID;
if(!empty($COLLINE_ID)){
$categories2='syst_avenue.AVENUE_NAME';
$categorieid2='syst_avenue.AVENUE_ID';
$catemenage2='affect.ID_AVENUE';
$localite2='syst_avenue';
$localititre='avenue';
 $cond2.=" AND affect.COLLINE_ID=".$COLLINE_ID; 
}
}
}
}

$menage_chef_zone=$this->Model->getRequete("SELECT ".$categories." as NAME,".$catemenage." AS ID,COUNT(CASE WHEN ID_UTILISATEUR IN (SELECT `ID_UTILISATEUR` FROM `utilisateurs` WHERE `PROFIL_ID` =25) THEN 1 END) AS ZONE FROM `menage_chefs`  LEFT JOIN (SELECT ID_CHEF,ID_UTILISATEUR,PROVINCE_ID,COMMUNE_ID,ZONE_ID,COLLINE_ID,ID_AVENUE FROM menage_chef_affectations WHERE 1 AND (TIMESTAMPDIFF(day, `DATE_FIN`, CURRENT_TIMESTAMP) <= 0)) AS affect ON affect.ID_CHEF=menage_chefs.ID_CHEF JOIN ".$localite." ON ".$categorieid."=".$catemenage." WHERE 1 ".$cond." GROUP BY ".$categories.",".$catemenage."");


$menage_chef_zone_categorie=" ";
$menage_chef_zone_total=0;

foreach ($menage_chef_zone as  $value) {  

$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;

$menage_chef_zone_categorie.="{name:'".$this->str_replacecatego($value['NAME'])."', y:".$value['ZONE'].",key2:1,key:'".$key_id1."'},";
$menage_chef_zone_total=$menage_chef_zone_total+$value['ZONE'];

}


$menage_chef_colline=$this->Model->getRequete("SELECT ".$categories1." as NAME,".$catemenage1." AS ID,COUNT(CASE WHEN ID_UTILISATEUR IN (SELECT `ID_UTILISATEUR` FROM `utilisateurs` WHERE `PROFIL_ID` =26) THEN 1 END) AS COLLINE FROM `menage_chefs`  LEFT JOIN (SELECT ID_CHEF,ID_UTILISATEUR,PROVINCE_ID,COMMUNE_ID,ZONE_ID,COLLINE_ID,ID_AVENUE FROM menage_chef_affectations WHERE 1 AND (TIMESTAMPDIFF(day, `DATE_FIN`, CURRENT_TIMESTAMP) <= 0)) AS affect ON affect.ID_CHEF=menage_chefs.ID_CHEF JOIN ".$localite1." ON ".$categorieid1."=".$catemenage1." WHERE 1 ".$cond1." GROUP BY ".$categories1.",".$catemenage1."");


$menage_chef_colline_categorie=" ";
$menage_chef_colline_total=0;

foreach ($menage_chef_colline as  $value) {  

$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;

$menage_chef_colline_categorie.="{name:'".$this->str_replacecatego($value['NAME'])."', y:".$value['COLLINE'].",key2:2,key:'".$key_id1."'},";
$menage_chef_colline_total=$menage_chef_colline_total+$value['COLLINE'];

}

$menage_chef_secteur=$this->Model->getRequete("SELECT ".$categories2." as NAME,".$catemenage2." AS ID,COUNT(CASE WHEN ID_UTILISATEUR IN (SELECT `ID_UTILISATEUR` FROM `utilisateurs` WHERE `PROFIL_ID` =25) THEN 1 END) AS SECTRUR FROM `menage_chefs`  LEFT JOIN (SELECT ID_CHEF,ID_UTILISATEUR,PROVINCE_ID,COMMUNE_ID,ZONE_ID,COLLINE_ID,ID_AVENUE FROM menage_chef_affectations WHERE 1 AND (TIMESTAMPDIFF(day, `DATE_FIN`, CURRENT_TIMESTAMP) <= 0)) AS affect ON affect.ID_CHEF=menage_chefs.ID_CHEF JOIN ".$localite2." ON ".$categorieid2."=".$catemenage2." WHERE 1 ".$cond2." GROUP BY ".$categories2.",".$catemenage2."");


$menage_chef_secteur_categorie=" ";
$menage_chef_secteur_total=0;

foreach ($menage_chef_secteur as  $value) {  

$key_id1=($value['ID']>0) ? $value['ID'] : "0" ;

$menage_chef_secteur_categorie.="{name:'".$this->str_replacecatego($value['NAME'])."', y:".$value['SECTRUR'].",key2:3,key:'".$key_id1."'},";
$menage_chef_secteur_total=$menage_chef_secteur_total+$value['SECTRUR'];

}


 $rapp="<script type=\"text/javascript\">
Highcharts.chart('container', {

chart: {
type: 'column'
},
title: {
text: '<b>Rapport de chefs des zones</b><br> Total=".number_format($menage_chef_zone_total,0,',',' ')."'
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
url:\"".base_url('dashboard/Dashboard_Chef_Menage/detail')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
DATE1:$('#DATE1').val(),
DATE2:$('#DATE2').val(),
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
data: [".$menage_chef_zone_categorie."]
}
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
text: '<b>Rapport de chefs des quartiers / collines</b><br> Total=".number_format($menage_chef_colline_total,0,',',' ')."'
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
$(\"#titre\").html(\"Détail\");   
$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Chef_Menage/detail')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
DATE1:$('#DATE1').val(),
DATE2:$('#DATE2').val(),
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
data: [".$menage_chef_colline_categorie."]
}
]
});
</script>
";


$rapp2="<script type=\"text/javascript\">

Highcharts.chart('container2', {

chart: {
type: 'area'
},
title: {
text: '<b>Rapport de chefs des secteurs</b><br> Total=".number_format($menage_chef_secteur_total,0,',',' ')."'
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
$(\"#titre\").html(\"Détail\");   
$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Chef_Menage/detail')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
DATE1:$('#DATE1').val(),
DATE2:$('#DATE2').val(),
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
name:'Chefs',
data: [".$menage_chef_secteur_categorie."]
}
]
});

 </script>";

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

echo json_encode(array('rapp'=>$rapp,'rapp1'=>$rapp1,'rapp2'=>$rapp2,'comm'=>$comm,'zon'=>$zon,'col'=>$col));

    }


}
?>




