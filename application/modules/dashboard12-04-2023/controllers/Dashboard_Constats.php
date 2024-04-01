
<?php
  
#claude@mediabox.bi 
#Dashboard des constats
#Il contient les rapport
#Corriger par Edmond
#Le 10/01/2023
class Dashboard_Constats extends CI_Controller
      {

//Charger la vue avec la fonction index
function index(){ 
$dattes=$this->Model->getRequete("SELECT DISTINCT date_format(DATE_INSERTION,'%Y') AS mois FROM historiques ORDER BY  mois DESC");

  
$data['dattes']=$dattes;
$DATEtet=date('Y');
$data['anneesonne'] =$this->Model->getRequeteOne('SELECT DISTINCT DATE_FORMAT(DATE_INSERTION, "%Y") as ANNh from historiques where DATE_FORMAT(DATE_INSERTION, "%Y")='.$DATEtet.' ');
$this->load->view('Dashboard_Constats_View',$data);
     }

function detail_ver()
{
$KEY=$this->input->post('key');  
$KEY2=$this->input->post('key2');
$KEY3=$this->input->post('key3');
$mois=$this->input->post('mois');
$jour=$this->input->post('jour');
$DATE1=$this->input->post('DATE1');
$DATE2=$this->input->post('DATE2');
$ID_ASSUREUR=$this->input->post('ID_ASSUREUR'); 
$criteres="";
$critere_assureur="";
$criterev="";
if (!empty($KEY3)) {
 $criterev.=" AND histo_traitement_constat.`ID_CONST_STATUT_TRAITE`=".$KEY3;
if ($KEY2==2) {
 if(!empty($ID_ASSUREUR)){
  $critere_assureur.=" AND histo_traitement_constat.ID_ASSUREUR= '".$ID_ASSUREUR."'";

}
}else{
 $critere_assureur=""; 
}
}





if((!empty($mois)  && empty($jour) && !empty($DATE1) && !empty($DATE2)) || (!empty($mois)  && !empty($jour) && !empty($DATE1) && !empty($DATE2)) ){
$criteres=" and DATE_FORMAT(DATE_INSERTION, '%Y-%m-%d') BETWEEN '" . $DATE1."' AND '" . $DATE2."'";
      }

if((!empty($mois) && empty($jour) && empty($DATE1) && empty($DATE2)) || (!empty($mois) && !empty($jour) && empty($DATE1) && empty($DATE2))){

$criteres=" and DATE_FORMAT(historiques.DATE_INSERTION, '%Y-%m')= '" . $jour."' ";
 
      }

if(!empty($mois) && !empty($jour) && !empty($DATE1) && empty($DATE2)){

$criteres=" and DATE_FORMAT(historiques.DATE_INSERTION,'%Y-%m-%d')='" . $DATE1."'";

      }

if(!empty($mois)  && !empty($jour) && empty($DATE1) && !empty($DATE2)) {

$criteres=" and DATE_FORMAT(historiques.DATE_INSERTION,'%Y-%m-%d')='" .$DATE2."'";
      }



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null; 

    
$query_principal="SELECT hist.ID_HISTORIQUE,ID_TYPE_VERIFICATION ,DATES,VERIFICATION,hist.DATE_INSERTION,hist.NUMERO_PLAQUE,hist.NOM,hist.PRENOM,hist.CNI,COMMENTAIRE_TEXT FROM (SELECT type_verification.ID_TYPE_VERIFICATION,historique_commentaire.COMMENTAIRE_TEXT ,type_verification.VERIFICATION ,histo_traitement_constat.ID_HISTORIQUE,`HISTO_TRAITEMENT_CONSTANT_ID` FROM `histo_traitement_constat` JOIN type_verification ON type_verification.ID_TYPE_VERIFICATION=histo_traitement_constat.ID_TYPE_VERIFICATION JOIN  historique_commentaire_controls ON historique_commentaire_controls.HISTO_COMMENTAIRE_ID=histo_traitement_constat.HISTO_COMMENTAIRE_ID  JOIN historique_commentaire on  historique_commentaire.COMMENTAIRE_ID=historique_commentaire_controls.COMMENTAIRE_ID WHERE 1 ".$critere_assureur." ".$criterev.") as const join (SELECT DISTINCT historiques.ID_HISTORIQUE,historiques.DATE_INSERTION,historiques.NUMERO_PLAQUE,historiques.NOM,historiques.PRENOM,historiques.CNI,DATE_FORMAT(historiques.DATE_INSERTION,'%d-%m-%Y') AS DATES FROM historiques WHERE 1 ".$criteres." ) as hist ON hist.ID_HISTORIQUE=const.ID_HISTORIQUE ";


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

$search = !empty($_POST['search']['value']) ? ("AND ( VERIFICATION LIKE '%$var_search%' OR  
hist.DATE_INSERTION LIKE '%$var_search%' OR  
hist.NUMERO_PLAQUE LIKE '%$var_search%' OR  
COMMENTAIRE_TEXT LIKE '%$var_search%') ") : '';

if (empty($KEY3)) {
$critaire=' and ID_TYPE_VERIFICATION='.$KEY;
}
else{
 $critaire=" and DATES='".$KEY."' AND ID_TYPE_VERIFICATION=".$KEY2 ; 
}

$query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
$query_filter=$query_principal.'  '.$critaire.' '.$search;

$fetch_data = $this->Model->datatable($query_secondaire);
$u=0;
$data = array();
foreach ($fetch_data as $row) 
{
$infra_v='Null';  
if (($KEY2==1 OR $KEY==1)) {  
$hist = $this->Model->getOne('historiques',array('ID_HISTORIQUE' =>$row->ID_HISTORIQUE));
if (!empty($hist['ID_IMMATRICULATIO_PEINE'])) {
 $infra= $this->Model->getOne(' infra_infractions',array('ID_INFRA_INFRACTION' =>$hist['ID_IMMATRICULATIO_PEINE']));
$infra_v=$row->ID_HISTORIQUE;
}

}else if(($KEY2==2 OR $KEY==2)){
$hist = $this->Model->getOne('historiques',array('ID_HISTORIQUE' =>$row->ID_HISTORIQUE));
  if (!empty($hist['ID_ASSURANCE_PEINE'])) {
  $infra= $this->Model->getOne(' infra_infractions',array('ID_INFRA_INFRACTION' =>$hist['ID_ASSURANCE_PEINE']));
$infra_v=$infra['NIVEAU_ALERTE'];
  }

  
}else if(($KEY2==3 OR $KEY==3)){
$hist = $this->Model->getOne('historiques',array('ID_HISTORIQUE' =>$row->ID_HISTORIQUE));
if (!empty($hist['ID_CONTROLE_TECHNIQUE_PEINE'])) {
 $infra= $this->Model->getOne(' infra_infractions',array('ID_INFRA_INFRACTION' =>$hist['ID_CONTROLE_TECHNIQUE_PEINE'])); 
$infra_v=$infra['NIVEAU_ALERTE']; 
}

}else if(($KEY2==5 OR $KEY2==4 OR $KEY==5 OR $KEY==4)){

$hist = $this->Model->getOne('historiques',array('ID_HISTORIQUE' =>$row->ID_HISTORIQUE));
if (!empty($hist['ID_VOL_PEINE'])) {
$infra= $this->Model->getOne(' infra_infractions',array('ID_INFRA_INFRACTION' =>$hist['ID_VOL_PEINE']));
$infra_v=$infra['NIVEAU_ALERTE'];
}
   
}else if(($KEY2==6 OR $KEY==6)){
$hist = $this->Model->getOne('historiques',array('ID_HISTORIQUE' =>$row->ID_HISTORIQUE));
if (!empty($hist['ID_PERMIS_PEINE'])) {
 $infra= $this->Model->getOne(' infra_infractions',array('ID_INFRA_INFRACTION' =>$hist['ID_PERMIS_PEINE']));
$infra_v=$infra['NIVEAU_ALERTE'];
}
  
}else if(($KEY2==8 OR $KEY=8)){
$hist = $this->Model->getOne('historiques',array('ID_HISTORIQUE' =>$row->ID_HISTORIQUE));
if (!empty($hist['ID_TRANSPORT_PEINE'])) {
$infra= $this->Model->getOne(' infra_infractions',array('ID_INFRA_INFRACTION' =>$hist['ID_TRANSPORT_PEINE']));  
$infra_v=$infra['NIVEAU_ALERTE'];
}

}

$intrant=array();
$intrant[] =$row->NUMERO_PLAQUE;
$intrant[] =$row->VERIFICATION;
$intrant[] =$row->DATE_INSERTION;
$intrant[] =$infra_v;
$intrant[] =$row->COMMENTAIRE_TEXT;

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

 
//CHarger les rapports
public function get_rapport(){ 
$mois=$this->input->post('mois');
$jour=$this->input->post('jour');
$DATE1=$this->input->post('DATE1');
$DATE2=$this->input->post('DATE2');
$ID_ASSUREUR=$this->input->post('ID_ASSUREUR'); 
$datjour="";
$criteres="";
$criteres1="";
$criteres2="";
$critere_assureur="";
 $date_jour=date('d-m-Y');


$critere_assureur="";
if(!empty($ID_ASSUREUR)){
  $critere_assureur=" AND histo_traitement_constat.ID_ASSUREUR= '".$ID_ASSUREUR."'";

}




if((!empty($mois)  && empty($jour) && !empty($DATE1) && !empty($DATE2)) || (!empty($mois)  && !empty($jour) && !empty($DATE1) && !empty($DATE2)) ){
$criteres=" and DATE_FORMAT(DATE_INSERTION, '%Y-%m-%d') BETWEEN '" . $DATE1."' AND '" . $DATE2."'";
$deter=""; 
      }

if((!empty($mois) && empty($jour) && empty($DATE1) && empty($DATE2)) || (!empty($mois) && !empty($jour) && empty($DATE1) && empty($DATE2))){


   if (!empty($jour)) 
   {
     $jour=$jour;
   }
   else
   {
 
   $my_month =$this->Model->getRequeteOne('SELECT max(DATE_FORMAT(historiques.DATE_INSERTION, "%Y-%m")) as mois from historiques where DATE_FORMAT(historiques.DATE_INSERTION, "%Y")="'.$mois.'"  ORDER BY mois DESC');
   $jour=$my_month['mois'];

   }

$criteres=" and DATE_FORMAT(historiques.DATE_INSERTION, '%Y-%m')= '" . $jour."' ";
  
  $deter="";  
      }

if(!empty($mois) && !empty($jour) && !empty($DATE1) && empty($DATE2)){

$criteres=" and DATE_FORMAT(historiques.DATE_INSERTION,'%Y-%m-%d')='" . $DATE1."'";

    $deter=" H";
      }

if(!empty($mois)  && !empty($jour) && empty($DATE1) && !empty($DATE2)) {

$criteres=" and DATE_FORMAT(historiques.DATE_INSERTION,'%Y-%m-%d')='" . $DATE2."'";
  $deter=" H";  
      }





$datte=$this->Model->getRequete('SELECT DISTINCT DATE_FORMAT(historiques.DATE_INSERTION, "%Y-%m") as mois from historiques where DATE_FORMAT(historiques.DATE_INSERTION, "%Y")="'.$mois.'" AND DATE_FORMAT(historiques.DATE_INSERTION, "%Y-%m")!="'.date('Y-m').'"  ORDER BY mois DESC');
if ($mois==date('Y')) {
$mois_select="<option value='".date('Y-m')."'>".date('Y-m')."</option>";
}
else
{
$mois_select="";
}
    foreach ($datte as $value)
         {

        if ($jour==$value['mois'])
              {
      $mois_select.="<option value='".$value['mois']."' selected>".$value['mois']."</option>";
                                } else{ 
    $mois_select.="<option value='".$value['mois']."'>".$value['mois']."</option>";
      } 
      } 

     //


 $constats=$this->Model->getRequete("SELECT ID_TYPE_VERIFICATION AS ID,VERIFICATION AS NAME,COUNT(`HISTO_TRAITEMENT_CONSTANT_ID`) as NBRE FROM (SELECT type_verification.ID_TYPE_VERIFICATION ,type_verification.VERIFICATION ,histo_traitement_constat.ID_HISTORIQUE,`HISTO_TRAITEMENT_CONSTANT_ID` FROM `histo_traitement_constat` JOIN type_verification ON type_verification.ID_TYPE_VERIFICATION=histo_traitement_constat.ID_TYPE_VERIFICATION) as const join (SELECT DISTINCT historiques.ID_HISTORIQUE FROM historiques WHERE 1 ".$criteres.") as hist ON hist.ID_HISTORIQUE=const.ID_HISTORIQUE GROUP BY ID_TYPE_VERIFICATION ,VERIFICATION");


    $total_const=0;
    $donnees_constat='';
    foreach ($constats as $value){

        $nbre=($value['NBRE']>0) ? $value['NBRE'] : "0";           
        $total_const=$total_const+$value['NBRE'];
        $name = (!empty($value['NAME'])) ? $value['NAME'] : "Autres";
        $donnees_constat.="{name:'".trim(str_replace("'","\'", $name))." (". $nbre.")', y:". $nbre.",key:'".$value['ID']."'},";
    }

    $etapes=$this->Model->getRequete("SELECT `ID_CONST_STATUT_TRAITE`,`DESCRIPTION_STATUT` FROM `histo_const_statut_traitement` WHERE 1 ORDER BY ID_CONST_STATUT_TRAITE ASC");
$etapenameobr='';
$etapetotalobr=0;
$dataassobr='';
$keyobr='';
    foreach ($etapes as  $valueet) { 
$etapenameobr=$this->str_replacecatego($valueet['DESCRIPTION_STATUT']);
$keyobr=$valueet['ID_CONST_STATUT_TRAITE'];


    $Verification_obr=$this->Model->getRequete("SELECT DATES,COUNT(`HISTO_TRAITEMENT_CONSTANT_ID`) as NBRE FROM (SELECT type_verification.ID_TYPE_VERIFICATION ,type_verification.VERIFICATION ,histo_traitement_constat.ID_HISTORIQUE,`HISTO_TRAITEMENT_CONSTANT_ID` FROM `histo_traitement_constat` JOIN type_verification ON type_verification.ID_TYPE_VERIFICATION=histo_traitement_constat.ID_TYPE_VERIFICATION WHERE type_verification.`ID_TYPE_VERIFICATION`=1 AND `histo_traitement_constat`.`ID_CONST_STATUT_TRAITE`=".$keyobr.") as const join (SELECT DISTINCT historiques.ID_HISTORIQUE,DATE_FORMAT(historiques.DATE_INSERTION,'%d-%m-%Y') AS DATES FROM historiques WHERE 1 ".$criteres.") as hist ON hist.ID_HISTORIQUE=const.ID_HISTORIQUE GROUP BY DATES");

$Verificationcategorie_obr=" ";
$Verificationtoal_obr=0;

foreach ($Verification_obr as  $value) {  

$key_id1=($value['DATES']>0) ? $value['DATES'] : "0" ;

$Verificationcategorie_obr.="{name:'".$this->str_replacecatego($value['DATES'])."', y:".$value['NBRE'].",key:'".$key_id1."',key2:1,key3:'".$keyobr."',key4:'".$etapenameobr."'},";
$Verificationtoal_obr=$Verificationtoal_obr+$value['NBRE'];


}

$dataassobr.="{
        name:'".$etapenameobr." (".$Verificationtoal_obr.")',
        data: [".$Verificationcategorie_obr."]
    },";
 $etapetotalobr+=$Verificationtoal_obr;

}

$etapenameass='';
$etapetotalass=0;
$dataassass='';
$keyass='';
    foreach ($etapes as  $valueet) { 
$etapenameass=$this->str_replacecatego($valueet['DESCRIPTION_STATUT']);
$keyass=$valueet['ID_CONST_STATUT_TRAITE'];


    $Verification_ass=$this->Model->getRequete("SELECT DATES,COUNT(`HISTO_TRAITEMENT_CONSTANT_ID`) as NBRE FROM (SELECT type_verification.ID_TYPE_VERIFICATION ,type_verification.VERIFICATION ,histo_traitement_constat.ID_HISTORIQUE,`HISTO_TRAITEMENT_CONSTANT_ID` FROM `histo_traitement_constat` JOIN type_verification ON type_verification.ID_TYPE_VERIFICATION=histo_traitement_constat.ID_TYPE_VERIFICATION WHERE type_verification.`ID_TYPE_VERIFICATION`=2 AND `histo_traitement_constat`.`ID_CONST_STATUT_TRAITE`=".$keyass." ".$critere_assureur.") as const join (SELECT DISTINCT historiques.ID_HISTORIQUE,DATE_FORMAT(historiques.DATE_INSERTION,'%d-%m-%Y') AS DATES FROM historiques WHERE 1 ".$criteres.") as hist ON hist.ID_HISTORIQUE=const.ID_HISTORIQUE GROUP BY DATES");

$Verificationcategorie_ass=" ";
$Verificationtoal_ass=0;

foreach ($Verification_ass as  $value) {  

$key_id1=($value['DATES']>0) ? $value['DATES'] : "0" ;

$Verificationcategorie_ass.="{name:'".$this->str_replacecatego($value['DATES'])."', y:".$value['NBRE'].",key:'".$key_id1."',key2:2,key3:'".$keyass."',key4:'".$etapenameass."'},";
$Verificationtoal_ass=$Verificationtoal_ass+$value['NBRE'];


}

$dataassass.="{
        name:'".$etapenameass." (".$Verificationtoal_ass.")',
        data: [".$Verificationcategorie_ass."]
    },";
 $etapetotalass+=$Verificationtoal_ass;

}

$etapenameotra='';
$etapetotalotra=0;
$dataassotra='';
$keyotra='';
    foreach ($etapes as  $valueet) { 
$etapenameotra=$this->str_replacecatego($valueet['DESCRIPTION_STATUT']);
$keyotra=$valueet['ID_CONST_STATUT_TRAITE'];


    $Verification_otra=$this->Model->getRequete("SELECT DATES,COUNT(`HISTO_TRAITEMENT_CONSTANT_ID`) as NBRE FROM (SELECT type_verification.ID_TYPE_VERIFICATION ,type_verification.VERIFICATION ,histo_traitement_constat.ID_HISTORIQUE,`HISTO_TRAITEMENT_CONSTANT_ID` FROM `histo_traitement_constat` JOIN type_verification ON type_verification.ID_TYPE_VERIFICATION=histo_traitement_constat.ID_TYPE_VERIFICATION WHERE type_verification.`ID_TYPE_VERIFICATION`=3 AND `histo_traitement_constat`.`ID_CONST_STATUT_TRAITE`=".$keyotra.") as const join (SELECT DISTINCT historiques.ID_HISTORIQUE,DATE_FORMAT(historiques.DATE_INSERTION,'%d-%m-%Y') AS DATES FROM historiques WHERE 1 ".$criteres.") as hist ON hist.ID_HISTORIQUE=const.ID_HISTORIQUE GROUP BY DATES");


$Verificationcategorie_otra=" ";
$Verificationtoal_otra=0;

foreach ($Verification_otra as  $value) {  

$key_id1=($value['DATES']>0) ? $value['DATES'] : "0" ;

$Verificationcategorie_otra.="{name:'".$this->str_replacecatego($value['DATES'])."', y:".$value['NBRE'].",key:'".$key_id1."',key2:3,key3:'".$keyotra."',key4:'".$etapenameotra."'},";
$Verificationtoal_otra=$Verificationtoal_otra+$value['NBRE'];


}

$dataassotra.="{
        name:'".$etapenameotra." (".$Verificationtoal_otra.")',
        data: [".$Verificationcategorie_otra."]
    },";
 $etapetotalotra+=$Verificationtoal_otra;

}


$etapenamepolice='';
$etapetotalpolice=0;
$dataasspolice='';
$keypolice='';
    foreach ($etapes as  $valueet) { 
$etapenamepolice=$this->str_replacecatego($valueet['DESCRIPTION_STATUT']);
$keypolice=$valueet['ID_CONST_STATUT_TRAITE'];


    $Verification_police=$this->Model->getRequete("SELECT DATES,COUNT(`HISTO_TRAITEMENT_CONSTANT_ID`) as NBRE FROM (SELECT type_verification.ID_TYPE_VERIFICATION ,type_verification.VERIFICATION ,histo_traitement_constat.ID_HISTORIQUE,`HISTO_TRAITEMENT_CONSTANT_ID` FROM `histo_traitement_constat` JOIN type_verification ON type_verification.ID_TYPE_VERIFICATION=histo_traitement_constat.ID_TYPE_VERIFICATION WHERE type_verification.`ID_TYPE_VERIFICATION`=4 AND `histo_traitement_constat`.`ID_CONST_STATUT_TRAITE`=".$keypolice.") as const join (SELECT DISTINCT historiques.ID_HISTORIQUE,DATE_FORMAT(historiques.DATE_INSERTION,'%d-%m-%Y') AS DATES FROM historiques WHERE 1 ".$criteres.") as hist ON hist.ID_HISTORIQUE=const.ID_HISTORIQUE GROUP BY DATES");

$Verificationcategorie_police=" ";
$Verificationtoal_police=0;

foreach ($Verification_police as  $value) {  

$key_id1=($value['DATES']>0) ? $value['DATES'] : "0" ;

$Verificationcategorie_police.="{name:'".$this->str_replacecatego($value['DATES'])."', y:".$value['NBRE'].",key:'".$key_id1."',key2:4,key3:'".$keypolice."',key4:'".$etapenamepolice."'},";
$Verificationtoal_police=$Verificationtoal_police+$value['NBRE'];


}

$dataasspolice.="{
        name:'".$etapenamepolice." (".$Verificationtoal_police.")',
        data: [".$Verificationcategorie_police."]
    },";
 $etapetotalpolice+=$Verificationtoal_police;

}

$etapenameinterp='';
$etapetotalinterp=0;
$dataassinterp='';
$keyinterp='';
    foreach ($etapes as  $valueet) { 
$etapenameinterp=$this->str_replacecatego($valueet['DESCRIPTION_STATUT']);
$keyinterp=$valueet['ID_CONST_STATUT_TRAITE'];


    $Verification_interp=$this->Model->getRequete("SELECT DATES,COUNT(`HISTO_TRAITEMENT_CONSTANT_ID`) as NBRE FROM (SELECT type_verification.ID_TYPE_VERIFICATION ,type_verification.VERIFICATION ,histo_traitement_constat.ID_HISTORIQUE,`HISTO_TRAITEMENT_CONSTANT_ID` FROM `histo_traitement_constat` JOIN type_verification ON type_verification.ID_TYPE_VERIFICATION=histo_traitement_constat.ID_TYPE_VERIFICATION WHERE type_verification.`ID_TYPE_VERIFICATION`=5 AND `histo_traitement_constat`.`ID_CONST_STATUT_TRAITE`=".$keyinterp.") as const join (SELECT DISTINCT historiques.ID_HISTORIQUE,DATE_FORMAT(historiques.DATE_INSERTION,'%d-%m-%Y') AS DATES FROM historiques WHERE 1 ".$criteres.") as hist ON hist.ID_HISTORIQUE=const.ID_HISTORIQUE GROUP BY DATES");

$Verificationcategorie_interp=" ";
$Verificationtoal_interp=0;

foreach ($Verification_interp as  $value) {  

$key_id1=($value['DATES']>0) ? $value['DATES'] : "0" ;

$Verificationcategorie_interp.="{name:'".$this->str_replacecatego($value['DATES'])."', y:".$value['NBRE'].",key:'".$key_id1."',key2:5,key3:'".$keyinterp."',key4:'".$etapenameinterp."'},";
$Verificationtoal_interp=$Verificationtoal_interp+$value['NBRE'];


}

$dataassinterp.="{
        name:'".$etapenameinterp." (".$Verificationtoal_interp.")',
        data: [".$Verificationcategorie_interp."]
    },";
 $etapetotalinterp+=$Verificationtoal_interp;

}

$etapenamepsr='';
$etapetotalpsr=0;
$dataasspsr='';
$keypsr='';
    foreach ($etapes as  $valueet) { 
$etapenamepsr=$this->str_replacecatego($valueet['DESCRIPTION_STATUT']);
$keypsr=$valueet['ID_CONST_STATUT_TRAITE'];


    $Verification_psr=$this->Model->getRequete("SELECT DATES,COUNT(`HISTO_TRAITEMENT_CONSTANT_ID`) as NBRE FROM (SELECT type_verification.ID_TYPE_VERIFICATION ,type_verification.VERIFICATION ,histo_traitement_constat.ID_HISTORIQUE,`HISTO_TRAITEMENT_CONSTANT_ID` FROM `histo_traitement_constat` JOIN type_verification ON type_verification.ID_TYPE_VERIFICATION=histo_traitement_constat.ID_TYPE_VERIFICATION WHERE type_verification.`ID_TYPE_VERIFICATION`=6 AND `histo_traitement_constat`.`ID_CONST_STATUT_TRAITE`=".$keypsr.") as const join (SELECT DISTINCT historiques.ID_HISTORIQUE,DATE_FORMAT(historiques.DATE_INSERTION,'%d-%m-%Y') AS DATES FROM historiques WHERE 1 ".$criteres.") as hist ON hist.ID_HISTORIQUE=const.ID_HISTORIQUE GROUP BY DATES");

$Verificationcategorie_psr=" ";
$Verificationtoal_psr=0;

foreach ($Verification_psr as  $value) {  

$key_id1=($value['DATES']>0) ? $value['DATES'] : "0" ;

$Verificationcategorie_psr.="{name:'".$this->str_replacecatego($value['DATES'])."', y:".$value['NBRE'].",key:'".$key_id1."',key2:6,key3:'".$keypsr."',key4:'".$etapenamepsr."'},";
$Verificationtoal_psr=$Verificationtoal_psr+$value['NBRE'];


}

$dataasspsr.="{
        name:'".$etapenamepsr." (".$Verificationtoal_psr.")',
        data: [".$Verificationcategorie_psr."]
    },";
 $etapetotalpsr+=$Verificationtoal_psr;

}

$etapenameparking='';
$etapetotalparking=0;
$dataassparking='';
$keyparking='';
    foreach ($etapes as  $valueet) { 
$etapenameparking=$this->str_replacecatego($valueet['DESCRIPTION_STATUT']);
$keyparking=$valueet['ID_CONST_STATUT_TRAITE'];


    $Verification_parking=$this->Model->getRequete("SELECT DATES,COUNT(`HISTO_TRAITEMENT_CONSTANT_ID`) as NBRE FROM (SELECT type_verification.ID_TYPE_VERIFICATION ,type_verification.VERIFICATION ,histo_traitement_constat.ID_HISTORIQUE,`HISTO_TRAITEMENT_CONSTANT_ID` FROM `histo_traitement_constat` JOIN type_verification ON type_verification.ID_TYPE_VERIFICATION=histo_traitement_constat.ID_TYPE_VERIFICATION WHERE type_verification.`ID_TYPE_VERIFICATION`=7 AND `histo_traitement_constat`.`ID_CONST_STATUT_TRAITE`=".$keyparking.") as const join (SELECT DISTINCT historiques.ID_HISTORIQUE,DATE_FORMAT(historiques.DATE_INSERTION,'%d-%m-%Y') AS DATES FROM historiques WHERE 1 ".$criteres.") as hist ON hist.ID_HISTORIQUE=const.ID_HISTORIQUE GROUP BY DATES");

$Verificationcategorie_parking=" ";
$Verificationtoal_parking=0;

foreach ($Verification_parking as  $value) {  

$key_id1=($value['DATES']>0) ? $value['DATES'] : "0" ;

$Verificationcategorie_parking.="{name:'".$this->str_replacecatego($value['DATES'])."', y:".$value['NBRE'].",key:'".$key_id1."',key2:7,key3:'".$keyparking."',key4:'".$etapenameparking."'},";
$Verificationtoal_parking=$Verificationtoal_parking+$value['NBRE'];


}

$dataassparking.="{
        name:'".$etapenameparking." (".$Verificationtoal_parking.")',
        data: [".$Verificationcategorie_parking."]
    },";
 $etapetotalparking+=$Verificationtoal_parking;

}

$etapenametransp='';
$etapetotaltransp=0;
$dataasstransp='';
$keytransp='';
    foreach ($etapes as  $valueet) { 
$etapenametransp=$this->str_replacecatego($valueet['DESCRIPTION_STATUT']);
$keytransp=$valueet['ID_CONST_STATUT_TRAITE'];


    $Verification_transp=$this->Model->getRequete("SELECT DATES,COUNT(`HISTO_TRAITEMENT_CONSTANT_ID`) as NBRE FROM (SELECT type_verification.ID_TYPE_VERIFICATION ,type_verification.VERIFICATION ,histo_traitement_constat.ID_HISTORIQUE,`HISTO_TRAITEMENT_CONSTANT_ID` FROM `histo_traitement_constat` JOIN type_verification ON type_verification.ID_TYPE_VERIFICATION=histo_traitement_constat.ID_TYPE_VERIFICATION WHERE type_verification.`ID_TYPE_VERIFICATION`=8 AND `histo_traitement_constat`.`ID_CONST_STATUT_TRAITE`=".$keytransp.") as const join (SELECT DISTINCT historiques.ID_HISTORIQUE,DATE_FORMAT(historiques.DATE_INSERTION,'%d-%m-%Y') AS DATES FROM historiques WHERE 1 ".$criteres.") as hist ON hist.ID_HISTORIQUE=const.ID_HISTORIQUE GROUP BY DATES");

$Verificationcategorie_transp=" ";
$Verificationtoal_transp=0;

foreach ($Verification_transp as  $value) {  

$key_id1=($value['DATES']>0) ? $value['DATES'] : "0" ;

$Verificationcategorie_transp.="{name:'".$this->str_replacecatego($value['DATES'])."', y:".$value['NBRE'].",key:'".$key_id1."',key2:8,key3:'".$keytransp."',key4:'".$etapenametransp."'},";
$Verificationtoal_transp=$Verificationtoal_transp+$value['NBRE'];


}

$dataasstransp.="{
        name:'".$etapenametransp." (".$Verificationtoal_transp.")',
        data: [".$Verificationcategorie_transp."]
    },";
 $etapetotaltransp+=$Verificationtoal_transp;

}

$rapp="<script type=\"text/javascript\">
    Highcharts.chart('container', {
   
chart: {
        type: 'pie'
    },
    title: {
        text: '<b>Nombre de constats par type de vérification </b><br> Total=".$total_const." '
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
        pie: {
             pointPadding: 0.2,
            borderWidth: 0,
            depth: 40,
             cursor:'pointer',
             point:{
                events: {
                  click: function()
{
 
$(\"#titre2\").html(\" Liste constats par type de vérification \" + this.name);
$(\"#myModal2\").modal();
var row_count ='1000000';
$(\"#mytable2\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Constats/detail_ver')."\",
type:\"POST\",
data:{
key:this.key, 
mois:$('#mois').val(), 
jour:$('#jour').val(),
DATE2:$('#DATE2').val(),
DATE1:$('#DATE1').val(),
                               
                                 
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
             format: '{point.name:f}'
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
        name:'Nombre : ',
        data: [".$donnees_constat."]
    }
    
    ]

});
</script>
     ";




$rapp1="<script type=\"text/javascript\">

Highcharts.chart('container1', {

chart: {
type: 'column'
},
title: {
text: 'Traitement des constats par type de vérification OBR <br> Total=".number_format($etapetotalobr,0,',',' ')."'
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
  
$(\"#titre2\").html(\" Liste de constats par statut : \" + this.key4);
$(\"#myModal2\").modal();
var row_count ='1000000';
$(\"#mytable2\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Constats/detail_ver')."\",
type:\"POST\",
data:{
key:this.key, 
key2:this.key2, 
key3:this.key3,
mois:$('#mois').val(), 
jour:$('#jour').val(),
DATE2:$('#DATE2').val(),
DATE1:$('#DATE1').val(),
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
buttons: ['copy', 'csv', 'excel', 'pdf', 'print'
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
".$dataassobr."
]
});

 </script>";

$rapp2="<script type=\"text/javascript\">

Highcharts.chart('container2', {

chart: {
type: 'line'
},
title: {
text: 'Traitement des constats par type de vérification ASSURENCE <br> Total=".number_format($etapetotalass,0,',',' ')."'
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
$(\"#titre2\").html(\" Liste de constats par statut : \" + this.key4);
$(\"#myModal2\").modal();
var row_count ='1000000';
$(\"#mytable2\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Constats/detail_ver')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2, 
key3:this.key3,
mois:$('#mois').val(), 
jour:$('#jour').val(),
DATE2:$('#DATE2').val(),
DATE1:$('#DATE1').val(),

}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: ['copy', 'csv', 'excel', 'pdf', 'print'
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
".$dataassass."
]
});

 </script>";

 $rapp3="<script type=\"text/javascript\">

Highcharts.chart('container3', {

chart: {
type: 'area'
},
title: {
text: 'Traitement des constats par type de vérification OTRACO <br> Total=".number_format($etapetotalotra,0,',',' ')."'
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
click: function()
{
$(\"#titre2\").html(\" Liste de constats par statut : \" + this.key4);
$(\"#myModal2\").modal();
var row_count ='1000000';
$(\"#mytable2\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Constats/detail_ver')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2, 
key3:this.key3,
mois:$('#mois').val(), 
jour:$('#jour').val(),
DATE2:$('#DATE2').val(),
DATE1:$('#DATE1').val(),

}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: ['copy', 'csv', 'excel', 'pdf', 'print'
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
".$dataassotra."
]
});

 </script>";

 $rapp4="<script type=\"text/javascript\">

Highcharts.chart('container4', {

chart: {
type: 'column'
},
title: {
text: 'Traitement des constats par type de vérification POLICE JURDIQUE <br> Total=".number_format($etapetotalpolice,0,',',' ')."'
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
$(\"#titre2\").html(\" Liste de constats par statut : \" + this.key4);
$(\"#myModal2\").modal();
var row_count ='1000000';
$(\"#mytable2\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Constats/detail_ver')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2, 
key3:this.key3,
mois:$('#mois').val(), 
jour:$('#jour').val(),
DATE2:$('#DATE2').val(),
DATE1:$('#DATE1').val(),

}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: ['copy', 'csv', 'excel', 'pdf', 'print'
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
".$dataasspolice."
]
});
 </script>";

 $rapp5="<script type=\"text/javascript\">
Highcharts.chart('container5', {

chart: {
type: 'spline'
},
title: {
text: 'Traitement des constats par type de vérification INTERPOLE <br> Total=".number_format($etapetotalinterp,0,',',' ')."'
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
spline: {
pointPadding: 0.2,
borderWidth: 0,
depth: 40,
cursor:'pointer',
point:{
events: {
click: function()
{
$(\"#titre2\").html(\" Liste de constats par statut : \" + this.key4);
$(\"#myModal2\").modal();
var row_count ='1000000';
$(\"#mytable2\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Constats/detail_ver')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2, 
key3:this.key3,
mois:$('#mois').val(), 
jour:$('#jour').val(),
DATE2:$('#DATE2').val(),
DATE1:$('#DATE1').val(),

}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: ['copy', 'csv', 'excel', 'pdf', 'print'
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
".$dataassinterp."
]
});
 </script>";

$rapp6="<script type=\"text/javascript\">

Highcharts.chart('container6', {

chart: {
type: 'area'
},
title: {
text: 'Traitement des constats par type de vérification PSR <br> Total=".number_format($etapetotalpsr,0,',',' ')."'
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
click: function()
{
$(\"#titre2\").html(\" Liste de constats par statut : \" + this.key4);
$(\"#myModal2\").modal();
var row_count ='1000000';
$(\"#mytable2\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Constats/detail_ver')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2, 
key3:this.key3,
mois:$('#mois').val(), 
jour:$('#jour').val(),
DATE2:$('#DATE2').val(),
DATE1:$('#DATE1').val(),

}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: ['copy', 'csv', 'excel', 'pdf', 'print'
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
".$dataasspsr."
]
});

 </script>";


 $rapp7="<script type=\"text/javascript\">

Highcharts.chart('container7', {

chart: {
type: 'area'
},
title: {
text: 'Traitement des constats par type de vérification PARKING <br> Total=".number_format($etapetotalparking,0,',',' ')."'
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
click: function()
{
$(\"#titre2\").html(\" Liste de constats par statut : \" + this.key4);
$(\"#myModal2\").modal();
var row_count ='1000000';
$(\"#mytable2\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Constats/detail_ver')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2, 
key3:this.key3,
mois:$('#mois').val(), 
jour:$('#jour').val(),
DATE2:$('#DATE2').val(),
DATE1:$('#DATE1').val(),

}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: ['copy', 'csv', 'excel', 'pdf', 'print'
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
".$dataassparking."
]
});

 </script>";

 $rapp8="<script type=\"text/javascript\">

Highcharts.chart('container8', {

chart: {
type: 'column'
},
title: {
text: 'Traitement des constats par type de vérification TRANSPORT <br> Total=".number_format($etapetotaltransp,0,',',' ')."'
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
$(\"#titre2\").html(\" Liste de constats par statut : \" + this.key4);
$(\"#myModal2\").modal();
var row_count ='1000000';
$(\"#mytable2\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_Constats/detail_ver')."\",
type:\"POST\",
data:{
key:this.key,
key2:this.key2, 
key3:this.key3,
mois:$('#mois').val(), 
jour:$('#jour').val(),
DATE2:$('#DATE2').val(),
DATE1:$('#DATE1').val(),

}
},
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
}],
dom: 'Bfrtlip',
buttons: ['copy', 'csv', 'excel', 'pdf', 'print'
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
".$dataasstransp."
]
});

 </script>";


$assureurs=$this->Model->getRequete('SELECT `ID_ASSUREUR`,`ASSURANCE` FROM `assureur` WHERE 1');
$assurances="<option selected='' disabled=''>séléctionner</option>";
    foreach ($assureurs as $value) {
        if (!empty($ID_ASSUREUR)) {

            if ($ID_ASSUREUR==$value['ID_ASSUREUR']) {
                $assurances.= "<option value ='".$value['ID_ASSUREUR']."' selected>".$value['ASSURANCE']."</option>";
            }
            else{
                $assurances.= "<option value ='".$value['ID_ASSUREUR']."'>".$value['ASSURANCE']."</option>";
            }

        }else{
            $assurances.= "<option value ='".$value['ID_ASSUREUR']."'>".$value['ASSURANCE']."</option>";
        }
    }

echo json_encode(array('rapp'=>$rapp,'rapp1'=>$rapp1,'rapp2'=>$rapp2,'rapp3'=>$rapp3,'rapp4'=>$rapp4,'rapp5'=>$rapp5,'rapp6'=>$rapp6,'rapp7'=>$rapp7,'rapp8'=>$rapp8,'select_month'=>$mois_select,'assurances'=>$assurances));

    }
//rapport de traitement des constats par type de verification
   

   //Details du rapport des constats par type de verification 


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
}
?>




