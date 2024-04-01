<?php

//CLAUDE NIYO 

class Otraco_Dash extends CI_Controller
{    
    function index()
    {
  
//requete pour retourner les voitures dont le controle technique expire ds 3 jours


$requete=$this->Modele->getRequete("SELECT ID_CONTROLE as ID ,date_format(DATE_VALIDITE,'%Y') AS ANNEE,NUMERO_PLAQUE,DATEDIFF( DATE(`DATE_VALIDITE`),CURRENT_DATE()
) AS JOURS_REST,COUNT(ID_CONTROLE) AS NBRE FROM `otraco_controles` WHERE DATE(`DATE_VALIDITE`) >= CURRENT_DATE() AND DATEDIFF(CURRENT_DATE(), DATE(`DATE_VALIDITE`)) >= -3 GROUP BY DATE_VALIDITE ,ID_CONTROLE,NUMERO_PLAQUE");
 $nombre=0;
 $donnees="";
 //$name="";
 $categorie1='';
 foreach ($requete as  $value) {
  
  $nombre=$nombre+$value['NBRE'];
  $name = (!empty($value['NUMERO_PLAQUE'])) ? $value['NUMERO_PLAQUE'] : "Aucun" ;
  $nb = (!empty($value['JOURS_REST'])) ? $value['JOURS_REST'] : "0" ;
  $key_id=($value['ID']>0) ? $value['ID'] : "0" ;
  $nom=str_replace("'", "\'", $name);
    $categorie1 .= $nom."',";
   
  $donnees.="{name:'".str_replace("'","\'",$name)."', y:".$nb.",key:'".$key_id."'},";
 
    }


   // $data['categorie1']=$categorie1;
    $data['title']='Espace Otraco ';
    $data['donnees']=$donnees;
    $data['nombre']=$nombre;
    //$data['name']=$name;


//      $nom=explode(',', $donnees);

 // print_r($categorie1);
 // exit();
    


$this->load->view('Otraco_View',$data);
}



//details sur le controles technique
function detailControle()
 { 
}






}

?>
