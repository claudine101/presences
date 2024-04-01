
<?php
 /// EDMOND :dashboard des assurences
//ameliore par edmond le 10/1/2022
class Dashboard_Vehecule_Assure extends CI_Controller
      {
function index(){  

$dattes=$this->Model->getRequete("SELECT DISTINCT date_format(assurances_vehicules.DATE_INSERTION,'%Y') AS mois FROM assurances_vehicules ORDER BY  mois ASC");
$assurence=$this->Model->getRequete("SELECT `ID_ASSUREUR`,`ASSURANCE` FROM `assureur` WHERE 1 ORDER by ASSURANCE ASC");
  
$data['dattes']=$dattes;
$data['assurence']=$assurence;

$this->load->view('Dashboard_Vehicule_Assure_View',$data);
     }

 //detail sur les assurences   
function detail()
    {
    
  $mois=$this->input->post('mois');  
  $ID_ASSUREUR=$this->input->post('ID_ASSUREUR');
  $jour=$this->input->post('jour');
  $DATE1=$this->input->post('DATE1');
  $DATE2=$this->input->post('DATE2');
 $KEY=$this->input->post('key');
 $KEY2=$this->input->post('key2');
$break=explode(".",$KEY2);
$ID=$KEY2;
        
$criteres_date=""; 
$datte_current="CURRENT_TIMESTAMP";


    
if ($this->session->userdata('PROFIL_ID') == 2) {
      $criteres_date.=" AND assurances_vehicules.ID_ASSUREUR=".$this->session->userdata('ID_INSTITUTION')."";
}else if(!empty($ID_ASSUREUR)){
      $criteres_date.=" AND assurances_vehicules.ID_ASSUREUR=".$ID_ASSUREUR."";
}


// if(!empty($ID_ASSUREUR)){

// $criteres_date.=" AND assurances_vehicules.ID_ASSUREUR=".$ID_ASSUREUR.""; 
//         }
        
if(!empty($mois)){

$criteres_date.=" AND date_format(assurances_vehicules.DATE_INSERTION,'%Y')='".$mois."'";
$datte_current="'".$mois."-12-31'";

        }

if(!empty($jour)){

$criteres_date.=" AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m')='".$jour."'";
$datte_current="'".$jour."-31'"; 
        }
if(!empty($DATE1)  && !empty($DATE2)){

$criteres_date.=" AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m-%d') BETWEEN '".$DATE1."' AND '".$DATE2."' ";
$datte_current="'".$DATE1."'"; 
        }
    if(!empty($DATE1)  && empty($DATE2)){

$criteres_date.=" AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m-%d')='".$DATE1."'";
$datte_current="'".$DATE1."'"; 
        }
       if(empty($DATE1)  && !empty($DATE2)){

$criteres_date.=" AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m-%d')='".$DATE2."'";
$datte_current="'".$DATE2."'"; 
        }



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;     


$query_principal=" SELECT `NUMERO_ASSURANCE`,ASSURANCE,`NUMERO_PLAQUE`,`DATE_DEBUT`,`DATE_VALIDITE`,`PLACES_ASSURES`,`TYPE_ASSURANCE`,NOM_PROPRIETAIRE,DATE_INSERTION FROM `assurances_vehicules` LEFT JOIN assureur ON assureur.ID_ASSUREUR=assurances_vehicules.ID_ASSUREUR WHERE 1 ".$criteres_date." ";

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

        $search = !empty($_POST['search']['value']) ? ("AND (NUMERO_ASSURANCE LIKE '%$var_search%'  OR ASSURANCE LIKE '%$var_search%' OR NUMERO_PLAQUE LIKE '%$var_search%' OR DATE_DEBUT LIKE '%$var_search%' OR TYPE_ASSURANCE LIKE '%$var_search%' OR NOM_PROPRIETAIRE LIKE '%$var_search%' OR DATE_VALIDITE LIKE '%$var_search%' ) ") : '';   

        $critaire='';





  if (empty($ID_ASSUREUR)) {
      # code...
  
       if($ID==1){  

        $critaire=" AND assurances_vehicules.ID_ASSUREUR =".$KEY." ";


        }elseif($ID==3){  

        $critaire=" AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") > 0) AND assurances_vehicules.ID_ASSUREUR =".$KEY."";


        }elseif($ID==2){  

        $critaire="AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") <= 0) AND assurances_vehicules.ID_ASSUREUR =".$KEY."";


        }
}else{
if
(empty($mois)){
if($ID==1){  

        $critaire=" AND date_format(assurances_vehicules.DATE_INSERTION,'%Y') ='".$KEY."' ";


        }elseif($ID==3){  

        $critaire=" AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") > 0) AND date_format(assurances_vehicules.DATE_INSERTION,'%Y') ='".$KEY."'";


        }elseif($ID==2){  

        $critaire="AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") <= 0) AND date_format(assurances_vehicules.DATE_INSERTION,'%Y') ='".$KEY."'";


}
}
else if(!empty($mois)){
if($ID==1){  

        $critaire=" AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m') ='".$KEY."' ";


        }elseif($ID==3){  

        $critaire=" AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") > 0) AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m') ='".$KEY."'";


        }elseif($ID==2){  

        $critaire="AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") <= 0) AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m') ='".$KEY."'";


}
}
  if(!empty($jour)){
if($ID==1){  

 $critaire=" AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m-%d') ='".$KEY."' ";


}elseif($ID==3){  

$critaire=" AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") > 0) AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m-%d') ='".$KEY."'";


}elseif($ID==2){  

$critaire="AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") <= 0) AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m-%d') ='".$KEY."'";


}
}
if(!empty($DATE1)  && !empty($DATE2)){
if($ID==1){  

 $critaire=" AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m-%d') ='".$KEY."' ";


}elseif($ID==3){  

$critaire=" AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") > 0) AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m-%d') ='".$KEY."'";


}elseif($ID==2){  

$critaire="AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") <= 0) AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m-%d') ='".$KEY."'";


}
}

if(!empty($DATE1)  && !empty($DATE2)){
if($ID==1){  

 $critaire=" AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m-%d') ='".$KEY."' ";


}elseif($ID==3){  

$critaire=" AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") > 0) AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m-%d') ='".$KEY."'";


}elseif($ID==2){  

$critaire="AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") <= 0) AND date_format(assurances_vehicules.DATE_INSERTION,'%Y-%m-%d') ='".$KEY."'";


}
}

if(empty($DATE1)  && !empty($DATE2)){
if($ID==1){  

 $critaire=" AND date_format(assurances_vehicules.DATE_INSERTION,'%H') ='".$KEY."' ";


}elseif($ID==3){  

$critaire=" AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") > 0) AND date_format(assurances_vehicules.DATE_INSERTION,'%H') ='".$KEY."'";


}elseif($ID==2){  

$critaire=" AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") <= 0) AND date_format(assurances_vehicules.DATE_INSERTION,'%H') ='".$KEY."'";


}
}

if(!empty($DATE1) && empty($DATE2)){
if($ID==1){  

 $critaire=" AND date_format(assurances_vehicules.DATE_INSERTION,'%H') ='".$KEY."' ";


}elseif($ID==3){  

$critaire="  AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") > 0) AND date_format(assurances_vehicules.DATE_INSERTION,'%H') ='".$KEY."'";


}elseif($ID==2){  

$critaire=" AND (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") <= 0) AND date_format(assurances_vehicules.DATE_INSERTION,'%H') ='".$KEY."'";


}
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
        $intrant[] =$row->NUMERO_PLAQUE;
         $intrant[] =$row->NOM_PROPRIETAIRE;
         $intrant[] =$row->ASSURANCE;
        $intrant[] =$row->TYPE_ASSURANCE;
         $intrant[] =$row->PLACES_ASSURES;
         $intrant[] =$row->DATE_DEBUT;
         $intrant[] =$row->DATE_VALIDITE;
         $intrant[] =$row->NUMERO_ASSURANCE;
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
$DATE1=$this->input->post('DATE1');
$DATE2=$this->input->post('DATE2');
$ID_ASSUREUR=$this->input->post('ID_ASSUREUR');
$mesure='';


$datte="";
$criteres1="";
$criteres2="";
$categorie="";
$datte_current="CURRENT_TIMESTAMP";
$titre="du  ".strftime('%d-%m-%Y',strtotime(date('Y-m-d')));

if(!empty($ID_ASSUREUR)){

$criteres1.=" AND s.ID_ASSUREUR=".$ID_ASSUREUR.""; 

if
(empty($mois)){
$titre="du  ".strftime('%d-%m-%Y',strtotime(date('Y-m-d')));
$categorie="date_format(s.DATE_INSERTION,'%Y')";
$categorieid="date_format(s.DATE_INSERTION,'%Y')";
$datte_current="CURRENT_TIMESTAMP";
$criteres1.="";
}
if(!empty($mois)){


$criteres1.=" AND date_format(s.DATE_INSERTION,'%Y')='".$mois."'";
$titre="en  ".strftime('%Y',strtotime($mois))." ";
$categorie="date_format(s.DATE_INSERTION,'%Y-%m')";
$categorieid="date_format(s.DATE_INSERTION,'%Y-%m')";
$datte_current="'".$mois."-12-31'";
$mesure='';
  }

  if(!empty($jour)){
$criteres1.=" AND date_format(s.DATE_INSERTION,'%Y-%m')= '".$jour."'  ";

$titre="en  ".strftime('%m-%Y',strtotime($jour));
$categorie="date_format(s.DATE_INSERTION,'%Y-%m-%d')";
$categorieid="date_format(s.DATE_INSERTION,'%Y-%m-%d')";
$datte_current="'".$jour."-31'"; 
$mesure=''; 
         }
 if(!empty($DATE1)  && !empty($DATE2)){
$criteres1.=" AND date_format(s.DATE_INSERTION,'%Y-%m-%d') BETWEEN  '".$DATE1."' AND '".$DATE2."'  ";

$titre="en  ".strftime('%m-%Y',strtotime($jour));
$categorie="date_format(s.DATE_INSERTION,'%Y-%m-%d')";
$categorieid="date_format(s.DATE_INSERTION,'%Y-%m-%d')";
$datte_current="'".$jour."-31'";
$mesure='';  
         }
if(!empty($DATE1)  && empty($DATE2)){
$criteres1.=" AND date_format(s.DATE_INSERTION,'%Y-%m-%d')= '".$DATE1."'  ";

$categorie="date_format(s.DATE_INSERTION,'%H')";
$categorieid="date_format(s.DATE_INSERTION,'%H')";
$titre="du  ".strftime('%d-%m-%Y',strtotime($heure));
$datte_current="'".$DATE1."'";
$mesure='H';   
         }
if(empty($DATE1)  && !empty($DATE2)){
$criteres1.=" AND date_format(s.DATE_INSERTION,'%Y-%m-%d')= '".$DATE2."'  ";

$categorie="date_format(s.DATE_INSERTION,'%H')";
$categorieid="date_format(s.DATE_INSERTION,'%H')";
$titre="du  ".strftime('%d-%m-%Y',strtotime($heure));
$datte_current="'".$DATE2."'"; 
$mesure='H';  
         }

    }else{
    $categorie="su.ASSURANCE";
$categorieid="s.ID_ASSUREUR";
if
(empty($mois)){
$titre="du  ".strftime('%d-%m-%Y',strtotime(date('Y-m-d')));
$categorie="su.ASSURANCE";
$categorieid="s.ID_ASSUREUR";
$datte_current="CURRENT_TIMESTAMP";
$criteres1.="";
}
if(!empty($mois)){
  

$criteres1.=" AND date_format(s.DATE_INSERTION,'%Y')='".$mois."'";
$titre="en  ".strftime('%Y',strtotime($mois))." ";
$categorie="su.ASSURANCE";
$categorieid="s.ID_ASSUREUR";
$datte_current="'".$mois."-12-31'";

  }

  if(!empty($jour)){
$criteres1.=" AND date_format(s.DATE_INSERTION,'%Y-%m')= '".$jour."'  ";

$titre="en  ".strftime('%m-%Y',strtotime($jour));
$categorie="su.ASSURANCE";
$categorieid="s.ID_ASSUREUR";
$datte_current="'".$jour."-31'";  
         }
if(!empty($DATE1)  && !empty($DATE2)){
$criteres1.=" AND date_format(s.DATE_INSERTION,'%Y-%m-%d') BETWEEN  '".$DATE1."' AND '".$DATE2."'  ";
$categorie="su.ASSURANCE";
$categorieid="s.ID_ASSUREUR";
$titre="du  ".strftime('%d-%m-%Y',strtotime($heure));
$datte_current="'".$DATE1."'";   
         }
    if(!empty($DATE1)  && empty($DATE2)){
$criteres1.=" AND date_format(s.DATE_INSERTION,'%Y-%m-%d') =  '".$DATE1."'  ";
$categorie="su.ASSURANCE";
$categorieid="s.ID_ASSUREUR";
$titre="du  ".strftime('%d-%m-%Y',strtotime($heure));
$datte_current="'".$DATE1."'";   
         }
          if(!empty($DATE1)  && !empty($DATE2)){
$criteres1.=" AND date_format(s.DATE_INSERTION,'%Y-%m-%d') = '".$DATE2."'  ";
$categorie="su.ASSURANCE";
$categorieid="s.ID_ASSUREUR";
$titre="du  ".strftime('%d-%m-%Y',strtotime($heure));
$datte_current="'".$DATE2."'";   
         }

    }


  $datte=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(assurances_vehicules.DATE_INSERTION, "%Y-%m") as mois from assurances_vehicules where DATE_FORMAT(assurances_vehicules.DATE_INSERTION, "%Y")="'.$mois.'" ORDER BY mois DESC');

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
$datjour=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(assurances_vehicules.DATE_INSERTION, "%Y-%m-%d") as mois from assurances_vehicules where DATE_FORMAT(assurances_vehicules.DATE_INSERTION, "%Y-%m")="'.$jour.'" ORDER BY mois DESC');

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

      


 $control=$this->Model->getRequete(" SELECT COUNT(`ID_ASSURANCE`) as envoye, ".$categorieid." id , (SELECT COUNT(`ID_ASSURANCE`) FROM assurances_vehicules s WHERE (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") > 0) AND ".$categorieid." = id ".$criteres1." ) as expire ,(SELECT COUNT(`ID_ASSURANCE`) FROM assurances_vehicules s WHERE (TIMESTAMPDIFF(day, `DATE_VALIDITE`, ".$datte_current.") <= 0) AND ".$categorieid." = id  ".$criteres1." ) as valable ,".$categorie." as assure FROM assurances_vehicules s JOIN assureur su ON s.ID_ASSUREUR=su.ID_ASSUREUR  where 1 ".$criteres1."  GROUP by assure, id ORDER BY assure ASC ");

$immaeny_categorie=" "; 
$immavalable_categorie=" ";  
$immaexpire_categorie=" ";

$immacat_envoy=0;
$immacat_valable=0;
$immacat_exp=0;

 foreach ($control as  $value) {
     
$key_id1=($value['id']>0) ? $value['id'] : "0" ;
$ass=$this->Model->getRequeteOne(" SELECT `ID_ASSUREUR`,`ASSURANCE` FROM `assureur` WHERE ID_ASSUREUR=".$key_id1." ORDER by ASSURANCE ASC ");
if (!empty($ass['ASSURANCE'])) {
 $ked=$ass['ASSURANCE'];
 }else{
$ass=$this->Model->getRequeteOne(" SELECT `ID_ASSUREUR`,`ASSURANCE` FROM `assureur` WHERE ID_ASSUREUR=".$ID_ASSUREUR." ORDER by ASSURANCE ASC ");
 $ked=$ass['ASSURANCE'];    
 }

$sommeeny=($value['envoye']>0) ? $value['envoye'] : "0" ;
$sommevalable=($value['valable']>0) ? $value['valable'] : "0" ;
$sommeexp=($value['expire']>0) ? $value['expire'] : "0" ;
$immaeny_categorie.="{name:'".str_replace("'","\'", $value['assure'])." ".$mesure."', y:". $sommeeny." ,key2:1,key:'". $key_id1."',keyed:'". $ked."'},";
$immavalable_categorie.="{name:'".str_replace("'","\'", $value['assure'])." ".$mesure."', y:". $sommevalable.",key2:2,key:'". $key_id1."',keyed:'". $ked."'},";
$immaexpire_categorie.="{name:'".str_replace("'","\'", $value['assure'])." ".$mesure."', y:". $sommeexp.",key2:3,key:'". $key_id1."',keyed:'". $ked."'},";


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
        text: '<b> Rapport des assurances  </b> <br> Total : (".number_format($immacat_envoy,0,',',' ').") '
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
        series: {
             pointPadding: 0.2,
            borderWidth: 0,
            depth: 40,
             cursor:'pointer',
             point:{
                events: {
 
 
click: function(){

if(this.key2==1){

$(\"#titre\").html(this.keyed+\" : Détail des toutes les assurances \");
}else if(this.key2==2){
$(\"#titre\").html(this.keyed+\" : Détail des assurances valides\");
}else{
 $(\"#titre\").html(this.keyed+\" : Détail des assurances expirées\");   
}

$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Vehecule_Assure/detail')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2,
keyed:this.keyed,
 mois:$('#mois').val(), 
jour:$('#jour').val(),
DATE1:$('#DATE1').val(),
DATE2:$('#DATE2').val(),
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
      type: 'column',
       color: 'red',
        name:'Assurances expirées : (".number_format($immacat_exp,0,',',' ').")',
        borderColor:\"#FFFF00\",
        data: [".$immaexpire_categorie."]
    },
     {
      type: 'column',
        color: '#6610f2',
        name:'Assurances valides : (".number_format($immacat_valable,0,',',' ').")',
        borderColor:\"#f00000\",
        data: [".$immavalable_categorie."]
    },
    {
        type: 'spline',
        
        name:'Nombre total d\'assurances : (".number_format($immacat_envoy,0,',',' ').")',
        
         data: [".$immaeny_categorie."],
          marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        }
       
    }
    ]

});

</script>
     ";



echo json_encode(array('rapp'=>$rapp,'select_month'=>$mois_select,'selectjour'=>$selectjour));
    }


}
?>




