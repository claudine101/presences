<?php
class Commentaire extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    // $this->have_droit();
  }
    public function have_droit()
    {
      if ($this->session->userdata('ASSURANCE') != 1 && $this->session->userdata('CONSTANT_SUR_CONTROLE') != 1) {
       redirect(base_url());
      }
     }
     public function get_concerne($ID_TYPE_VERIFICATION,$ID_HISTORIQUE)
    {
        $proprietaire='';
        if($ID_TYPE_VERIFICATION==6){
            $Concerne = $this->Modele->getRequeteOne('SELECT cp.NOM_PROPRIETAIRE FROM historiques h   LEFT JOIN chauffeur_permis cp ON h.NUMERO_PERMIS=cp.NUMERO_PERMIS WHERE h.ID_HISTORIQUE='.$ID_HISTORIQUE);
        }
        else{
            $Concerne = $this->Modele->getRequeteOne('SELECT oip.NOM_PROPRIETAIRE FROM historiques h   LEFT JOIN obr_immatriculations_voitures oip ON h.NUMERO_PLAQUE=oip.NUMERO_PLAQUE WHERE h.ID_HISTORIQUE='.$ID_HISTORIQUE);
        }
        return $Concerne['NOM_PROPRIETAIRE'];
    }
     public function get_assureur($ID_COMMENTAIRE_VERIFICATION)
    {
      $assureur = $this->Modele->getRequeteOne('SELECT a.ASSURANCE FROM historique_commentaire_verification hcv  LEFT JOIN  historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION 
          LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID
           LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  WHERE hcv.ID_COMMENTAIRE_VERIFICATION='.$ID_COMMENTAIRE_VERIFICATION);
           return $assureur['ASSURANCE'];
    }
    public function get_peines($ID_TYPE_VERIFICATION,$ID_HISTORIQUE)
    {
        if($ID_TYPE_VERIFICATION==1){
         $peine = $this->Modele->getRequeteOne('SELECT ii.NIVEAU_ALERTE  FROM infra_infractions ii LEFT JOIN historiques h ON h.ID_IMMATRICULATIO_PEINE=ii.ID_INFRA_INFRACTION WHERE h.ID_HISTORIQUE='.$ID_HISTORIQUE);
        }
        else if($ID_TYPE_VERIFICATION==2){
         $peine = $this->Modele->getRequeteOne('SELECT ii.NIVEAU_ALERTE  FROM infra_infractions ii LEFT JOIN historiques h ON h.ID_ASSURANCE_PEINE=ii.ID_INFRA_INFRACTION WHERE h.ID_HISTORIQUE='.$ID_HISTORIQUE);
        }
        else if($ID_TYPE_VERIFICATION==3){
         $peine = $this->Modele->getRequeteOne('SELECT ii.NIVEAU_ALERTE  FROM infra_infractions ii LEFT JOIN historiques h ON h.ID_CONTROLE_TECHNIQUE_PEINE=ii.ID_INFRA_INFRACTION WHERE h.ID_HISTORIQUE='.$ID_HISTORIQUE);
        }
        else if($ID_TYPE_VERIFICATION==4){
         $peine = $this->Modele->getRequeteOne('SELECT ii.NIVEAU_ALERTE  FROM infra_infractions ii LEFT JOIN historiques h ON h.ID_VOL_PEINE=ii.ID_INFRA_INFRACTION WHERE h.ID_HISTORIQUE='.$ID_HISTORIQUE);
        }
        else if($ID_TYPE_VERIFICATION==6){
         $peine = $this->Modele->getRequeteOne('SELECT ii.NIVEAU_ALERTE  FROM infra_infractions ii LEFT JOIN historiques h ON h.ID_PERMIS_PEINE=ii.ID_INFRA_INFRACTION WHERE h.ID_HISTORIQUE='.$ID_HISTORIQUE);
        }
        else if($ID_TYPE_VERIFICATION==8){
         $peine = $this->Modele->getRequeteOne('SELECT ii.NIVEAU_ALERTE  FROM infra_infractions ii LEFT JOIN historiques h ON h.ID_TRANSPORT_PEINE=ii.ID_INFRA_INFRACTION WHERE h.ID_HISTORIQUE='.$ID_HISTORIQUE);
        }
        else{
            $peine ="";
        }
        return  !empty($peine['NIVEAU_ALERTE']) ? $peine['NIVEAU_ALERTE'] : 'N/A';

    }
  function save_all()
  {
    $ID_COMMENTAIRE_VERIFICATION =  $this->input->post('ID_COMMENTAIRE_VERIFICATION');

     // foreach ($ID_COMMENTAIRE_VERIFICATION as $key => $value) {
        $historique = $this->Modele->getRequeteOne('SELECT h.ID_HISTORIQUE,hcv.ID_TYPE_VERIFICATION,h.NUMERO_PLAQUE,h.NUMERO_PERMIS FROM historique_commentaire_verification hcv LEFT JOIN historiques h ON h.ID_HISTORIQUE=hcv.ID_HISTORIQUE WHERE  ID_COMMENTAIRE_VERIFICATION='.$ID_COMMENTAIRE_VERIFICATION);
        // print_r( $historique);
        // exit();
        $all_valide = $this->Modele->getRequeteOne('SELECT COUNT(*) AS valide ,hcv.ID_COMMENTAIRE_VERIFICATION ,hcv.ID_TYPE_VERIFICATION FROM historique_commentaire_controls  hcc  LEFT JOIN historique_commentaire_verification hcv ON hcv.ID_COMMENTAIRE_VERIFICATION=hcc.ID_COMMENTAIRE_VERIFICATION WHERE hcc.POSISTION_NOW=1 AND hcv.ID_COMMENTAIRE_VERIFICATION='.$ID_COMMENTAIRE_VERIFICATION.' GROUP BY hcv.ID_COMMENTAIRE_VERIFICATION ,hcv.ID_TYPE_VERIFICATION');

            if($all_valide['valide']>0)
            {
              
              $this->maintenir($historique['ID_HISTORIQUE'],$historique['ID_TYPE_VERIFICATION'],$ID_COMMENTAIRE_VERIFICATION,$historique['NUMERO_PLAQUE'],$historique['NUMERO_PERMIS']);
           }
           else
           {
            $this->annuler_all($historique['ID_HISTORIQUE'],$historique['ID_TYPE_VERIFICATION']);
           }
      // }
}
function envoyer_all()
{
    $HISTO_ID_COMMENTAIRE =  $this->input->post('HISTO_ID_COMMENTAIRE');
     foreach ($HISTO_ID_COMMENTAIRE as $key => $value) {
       $historique = $this->Modele->getRequeteOne('
              SELECT hcv.ID_HISTORIQUE,hcv.ID_TYPE_VERIFICATION,hcv.ID_COMMENTAIRE_VERIFICATION FROM historique_commentaire_controls hcc LEFT JOIN historique_commentaire_verification hcv ON hcv.ID_COMMENTAIRE_VERIFICATION=hcc.ID_COMMENTAIRE_VERIFICATION  WHERE hcc.HISTO_COMMENTAIRE_ID='.$value);

    $this->save_institution($historique['ID_HISTORIQUE'],$historique['ID_TYPE_VERIFICATION'],
                 $historique['ID_COMMENTAIRE_VERIFICATION'],$value);


     }
}
function envoyer_all_assur()
{
    $HISTO_COMMENTAIRE_ID =  $this->input->post('HISTO_COMMENTAIRE_ID');
    $ID_ASSUREUR =  $this->input->post('ID_ASSUREUR');
     foreach ($HISTO_COMMENTAIRE_ID as $key => $value) {
       $historique = $this->Modele->getRequeteOne('
              SELECT hcv.ID_HISTORIQUE,hcv.ID_TYPE_VERIFICATION,hcv.ID_COMMENTAIRE_VERIFICATION FROM historique_commentaire_controls hcc LEFT JOIN historique_commentaire_verification hcv ON hcv.ID_COMMENTAIRE_VERIFICATION=hcc.ID_COMMENTAIRE_VERIFICATION  WHERE hcc.HISTO_COMMENTAIRE_ID='.$value);

    $this->save_assurareur($historique['ID_HISTORIQUE'],$historique['ID_TYPE_VERIFICATION'],
                 $historique['ID_COMMENTAIRE_VERIFICATION'],$value,$ID_ASSUREUR);


     }
}
  function index()
  {
    $data['title'] = 'Historique  des vérifications  avec constat';
    $this->load->view('commentaire/Commentaire_List_View', $data);
  }

 //POUR AFFICHAG DE TOUT  LES CONSTANTS
  function all_const()
  {
    $id=$this->session->userdata('USER_ID');
    $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID,ass.ASSURANCE FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID LEFT JOIN assureur ass ON ass.ID_UTILISATEUR=u.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id);
    $type_verification = $this->Modele->getRequete('SELECT * FROM type_verification');
    $data['type_verification'] = $type_verification;
    if($profil['PROFIL_ID']==1)
    {
      $data['title'] = 'Historique des constats';
    }
    else{
      $data['title'] = 'Historique des traitements de constat';
    }
    if($profil['PROFIL_ID']==1)
    {
        $Nbre_nouveau = $this->Modele->getRequeteOne('SELECT COUNT(DISTINCT h.ID_HISTORIQUE, hcv.ID_TYPE_VERIFICATION,hc.COMMENTAIRE_ID) AS Nombre FROM historiques h LEFT JOIN historique_commentaire_verification hcv ON hcv.ID_HISTORIQUE=h.ID_HISTORIQUE LEFT JOIN historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN historique_commentaire hc ON hc.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID
          WHERE hcv.STATUT_FIN_TRAITEMENT=0  AND  hcc.HISTO_COMMENTAIRE_ID NOT IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat )');
      
      $Nbre_encours=$this->Modele->getRequeteOne('SELECT COUNT(htc.HISTO_COMMENTAIRE_ID) AS Nombre  FROM histo_traitement_constat  htc WHERE htc.ID_CONST_STATUT_TRAITE=2');

      $Nbre_avis=$this->Modele->getRequeteOne('SELECT COUNT(DISTINCT h.ID_HISTORIQUE,hcv.ID_TYPE_VERIFICATION) AS Nombre FROM historiques h LEFT JOIN historique_commentaire_verification hcv ON hcv.ID_HISTORIQUE=h.ID_HISTORIQUE LEFT JOIN historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID WHERE htc.ID_CONST_STATUT_TRAITE=3  AND hcv.STATUT_FIN_TRAITEMENT=1');
      
      $Nbre_maintenir = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM historique_commentaire_verification hcv LEFT JOIN historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN historiques h ON h.ID_HISTORIQUE=hcv.ID_HISTORIQUE LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID WHERE htc.ID_CONST_STATUT_TRAITE=5 AND   hcc.HISTO_COMMENTAIRE_ID   IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat)');

      $Nbre_annuler = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM historique_commentaire_verification hcv LEFT JOIN historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN historiques h ON h.ID_HISTORIQUE=hcv.ID_HISTORIQUE LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID
           WHERE htc.ID_CONST_STATUT_TRAITE=4 AND   hcc.HISTO_COMMENTAIRE_ID   IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat)');

     
      $data['Nbre_nouveau']=$Nbre_nouveau['Nombre'];
      $data['Nbre_maintenir']=$Nbre_maintenir['Nombre'];
      $data['Nbre_canceler']=$Nbre_annuler['Nombre'];
      $data['Nbre_encours']=$Nbre_encours['Nombre'];
      $data['Nbre_avis']=$Nbre_avis['Nombre'];


        $AssureurList=$this->Modele->getListOrder("assureur","ASSURANCE");
        $html=" <select name='assureur' id='assureur' class='form-control'>
                   <option value=''>Sélectionner un assureurs</option>";
                    foreach ($AssureurList as $value) { 
                     $html.="<option value='".$value['ID_ASSUREUR']." '>".$value['ASSURANCE']."</option>";
                    }
                 $html.="</select>";
        $data['html']=$html;
      $this->load->view('commentaire/Constant_List_view', $data);
    }
    else if($profil['PROFIL_ID']==2)
    {
      $Nbre_transmis = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  LEFT JOIN  assureur a ON  a.ID_ASSUREUR=htc.ID_ASSUREUR WHERE ID_CONST_STATUT_TRAITE=2 AND a.ID_ASSUREUR=' .$this->session->userdata('ID_INSTITUTION').'');

      $Nbre_retours = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  LEFT JOIN  assureur a ON  a.ID_ASSUREUR=htc.ID_ASSUREUR WHERE ID_CONST_STATUT_TRAITE=3 AND a.ID_ASSUREUR='.$this->session->userdata('ID_INSTITUTION').'');
      
       $data['Nbre_transmis']=$Nbre_transmis['Nombre'];
       $data['Nbre_retours']=$Nbre_retours['Nombre'];
       $Avis = $this->Model->getRequete('SELECT * FROM histo_consta_avis_partenaire WHERE 1');
        $html="";
         $html.="<select name='avisePartenaire' id='avisePartenaire' class='form-control'>
                   <option value=''>Sélectionner</option>";
                    foreach ($Avis as $value) { 
                     $html.="<option  value='".$value['ID_AVIS_PARTENAIRE']." '>".$value['AVIS_PARTENAIRE']."</option>";
                    }
        $html.="</select>";
        $data['Avis_partenaire']=$html;
       $this->load->view('commentaire/Constant_parte_List_view', $data);
    }
    // else if($profil['PROFIL_ID']==3 || $profil['PROFIL_ID']=4 || $profil['PROFIL_ID']=5 || $profil['PROFIL_ID']=6 )
    // {
      
else if($profil['PROFIL_ID']==3)
{

      $Nbre_transmis = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM historique_commentaire_verification hcv LEFT JOIN historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN historiques h ON h.ID_HISTORIQUE=hcv.ID_HISTORIQUE LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID
        WHERE htc.ID_TYPE_VERIFICATION=1 AND htc.ID_CONST_STATUT_TRAITE=2 AND   hcc.HISTO_COMMENTAIRE_ID   IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat) ');

      $Nbre_retours = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM historique_commentaire_verification hcv LEFT JOIN historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN historiques h ON h.ID_HISTORIQUE=hcv.ID_HISTORIQUE LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID
        WHERE htc.ID_TYPE_VERIFICATION=1 AND htc.ID_CONST_STATUT_TRAITE=3 AND   hcc.HISTO_COMMENTAIRE_ID IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat)');

       $data['Nbre_transmis']=$Nbre_transmis['Nombre'];
      $data['Nbre_retours']=$Nbre_retours['Nombre'];
       $Avis = $this->Model->getRequete('SELECT * FROM histo_consta_avis_partenaire WHERE 1');
       $html="";
         $html.="<select name='avisePartenaire' id='avisePartenaire' class='form-control'>
                   <option value=''>Sélectionner </option>";
                    foreach ($Avis as $value) { 
                     $html.="<option  value='".$value['ID_AVIS_PARTENAIRE']." '>".$value['AVIS_PARTENAIRE']."</option>";
                    }
        $html.="</select>";
        $data['Avis_partenaire']=$html;

      $this->load->view('commentaire/Constant_instution_List_view', $data);
}
else if($profil['PROFIL_ID']==4)
{
      $Nbre_transmis = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM historique_commentaire_verification hcv LEFT JOIN historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN historiques h ON h.ID_HISTORIQUE=hcv.ID_HISTORIQUE LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID
        WHERE htc.ID_TYPE_VERIFICATION=4 AND htc.ID_CONST_STATUT_TRAITE=2 AND   hcc.HISTO_COMMENTAIRE_ID   IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat)

        ');
      $Nbre_retours = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  WHERE htc.ID_TYPE_VERIFICATION=4 AND ID_CONST_STATUT_TRAITE=3 ');
      $data['Nbre_transmis']=$Nbre_transmis['Nombre'];
      $data['Nbre_retours']=$Nbre_retours['Nombre'];
       $Avis = $this->Model->getRequete('SELECT * FROM histo_consta_avis_partenaire WHERE 1');
        $html="";
         $html.=" <select name='avisePartenaire' id='avisePartenaire' class='form-control'>
                   <option value=''>Sélectionner </option>";
                    foreach ($Avis as $value) { 
                     $html.="<option  value='".$value['ID_AVIS_PARTENAIRE']." '>".$value['AVIS_PARTENAIRE']."</option>";
                    }
        $html.="</select>";
        $data['Avis_partenaire']=$html;
     $this->load->view('commentaire/Constant_instution_List_view', $data);
}
else if($profil['PROFIL_ID']==5)
{
       $Nbre_transmis = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM historique_commentaire_verification hcv LEFT JOIN historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN historiques h ON h.ID_HISTORIQUE=hcv.ID_HISTORIQUE LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID WHERE (htc.ID_TYPE_VERIFICATION=3 OR htc.ID_TYPE_VERIFICATION=8) AND htc.ID_CONST_STATUT_TRAITE=2 AND   hcc.HISTO_COMMENTAIRE_ID   IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat)');

      $Nbre_retours = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM historique_commentaire_verification hcv LEFT JOIN historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN historiques h ON h.ID_HISTORIQUE=hcv.ID_HISTORIQUE LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID
        WHERE (htc.ID_TYPE_VERIFICATION=3 OR htc.ID_TYPE_VERIFICATION=8 )AND htc.ID_CONST_STATUT_TRAITE=3 AND   hcc.HISTO_COMMENTAIRE_ID   IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat)');
      $data['Nbre_transmis']=$Nbre_transmis['Nombre'];
      $data['Nbre_retours']=$Nbre_retours['Nombre'];
       $Avis = $this->Model->getRequete('SELECT * FROM histo_consta_avis_partenaire WHERE 1');
        $html="";
         $html.=" <select name='avisePartenaire' id='avisePartenaire' class='form-control'>
                   <option value=''>Sélectionner </option>";
                    foreach ($Avis as $value) { 
                     $html.="<option  value='".$value['ID_AVIS_PARTENAIRE']." '>".$value['AVIS_PARTENAIRE']."</option>";
                    }
        $html.="</select>";
        $data['Avis_partenaire']=$html;
     $this->load->view('commentaire/Constant_instution_List_view', $data);  
}
else if($profil['PROFIL_ID']==6)
{
      $Nbre_transmis = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  WHERE htc.ID_TYPE_VERIFICATION=6 AND ID_CONST_STATUT_TRAITE=2');
      $Nbre_retours = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  WHERE htc.ID_TYPE_VERIFICATION=6 AND ID_CONST_STATUT_TRAITE=3');
      $data['Nbre_transmis']=$Nbre_transmis['Nombre'];
      $data['Nbre_retours']=$Nbre_retours['Nombre'];

       $Avis = $this->Model->getRequete('SELECT * FROM histo_consta_avis_partenaire WHERE 1');
        $html="";
         $html.=" <select name='avisePartenaire' id='avisePartenaire' class='form-control'>
                   <option value=''>Sélectionner</option>";
                    foreach ($Avis as $value) { 
                     $html.="<option  value='".$value['ID_AVIS_PARTENAIRE']." '>".$value['AVIS_PARTENAIRE']."</option>";
                    }
        $html.="</select>";
        $data['Avis_partenaire']=$html;
     $this->load->view('commentaire/Constant_instution_List_view', $data);
}
    else{
       redirect(base_url());
    }
   
  }
   function listing(){
        $i = 1;
        $query_principal = "SELECT DISTINCT histo.NUMERO_PERMIS,tv.ID_TYPE_VERIFICATION ,histo.ID_HISTORIQUE,histo.NUMERO_PLAQUE,histo.DATE_INSERTION FROM  historiques histo LEFT JOIN  historique_commentaire_verification  hcv ON hcv.ID_HISTORIQUE=histo.ID_HISTORIQUE 
            LEFT JOIN  type_verification tv ON tv.ID_TYPE_VERIFICATION=hcv.ID_TYPE_VERIFICATION
            WHERE histo.ID_HISTORIQUE_STATUT=1";

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search=str_replace("'", "\'", $var_search);


        $limit = 'LIMIT 0,10';

        if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }

        $order_by = '';

        $order_column = array('DATE_INSERTION');

        $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY histo.DATE_INSERTION DESC';

        $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%' OR  ") : '';



        $critaire = '';

        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

        $fetch_psr = $this->Modele->datatable($query_secondaire);
        $data = array();
        foreach ($fetch_psr as $row) {

         $obr = $this->Modele->getRequeteOne('SELECT COUNT(ID_HISTORIQUE)  as count FROM historique_commentaire_verification WHERE  ID_TYPE_VERIFICATION=1 AND ID_HISTORIQUE='.$row->ID_HISTORIQUE.'');
          
         $assurance = $this->Modele->getRequeteOne('SELECT COUNT(ID_HISTORIQUE)  as count FROM historique_commentaire_verification WHERE  ID_TYPE_VERIFICATION=2 AND ID_HISTORIQUE='.$row->ID_HISTORIQUE.'');
          
          $otraco = $this->Modele->getRequeteOne('SELECT COUNT(ID_HISTORIQUE)  as count FROM historique_commentaire_verification WHERE  ID_TYPE_VERIFICATION=3 AND ID_HISTORIQUE='.$row->ID_HISTORIQUE.'');

          $police = $this->Modele->getRequeteOne('SELECT COUNT(ID_HISTORIQUE)  as count FROM historique_commentaire_verification WHERE  ID_TYPE_VERIFICATION=4 AND ID_HISTORIQUE='.$row->ID_HISTORIQUE.'');

         // $interpol = $this->Modele->getRequeteOne('SELECT COUNT(ID_HISTORIQUE)  as count FROM historique_commentaire_verification WHERE  ID_TYPE_VERIFICATION=5 AND ID_HISTORIQUE='.$row->ID_HISTORIQUE.'');
         $psr = $this->Modele->getRequeteOne('SELECT COUNT(ID_HISTORIQUE)  as count FROM historique_commentaire_verification WHERE  ID_TYPE_VERIFICATION=6 AND ID_HISTORIQUE='.$row->ID_HISTORIQUE.'');
         // $parking = $this->Modele->getRequeteOne('SELECT COUNT(ID_HISTORIQUE)  as count FROM historique_commentaire_verification WHERE  ID_TYPE_VERIFICATION=7 AND ID_HISTORIQUE='.$row->ID_HISTORIQUE.'');
         $transport = $this->Modele->getRequeteOne('SELECT COUNT(ID_HISTORIQUE)  as count FROM historique_commentaire_verification WHERE  ID_TYPE_VERIFICATION=8 AND ID_HISTORIQUE='.$row->ID_HISTORIQUE.'');


          $sub_array = array();
          //$sub_array[]=$i++;
       $sub_array[] = $row->NUMERO_PLAQUE?$row->NUMERO_PLAQUE:$row->NUMERO_PERMIS;
       $sub_array[] = $row->DATE_INSERTION;
       $option = "<a class='btn  btn-sm btn-outline-primary'  id='".$row->NUMERO_PLAQUE."' title='".$row->DATE_INSERTION."' onclick='getDetail(".$row->ID_HISTORIQUE.",".$row->ID_TYPE_VERIFICATION.",this.title, this.id)'  href='#'>";

      $sub_array[] = $obr['count']!=0 ?$option.$obr['count']."</a>" :'aucun';
      $sub_array[] = $assurance['count']==0 ?'aucun':$option.$assurance['count']."</a";
      $sub_array[] = $otraco['count']!=0 ?$option.$otraco['count']."</a>"  :'aucun';
      $sub_array[] = $police['count']!=0 ?$option.$police['count']."</a":'aucun';
      // $sub_array[] = $interpol['count']!=0 ?$option.$interpol['count']."</a" :'aucun';
       $sub_array[] = $psr['count']!=0 ?$option.$psr['count']."</a":'aucun';
       // $sub_array[] = $parking['count']!=0 ?$option.$parking['count']."</a":'aucun';
       $sub_array[] = $transport['count']!=0 ?$option.$transport['count']."</a"  :'aucun';
       $data[] = $sub_array;
      }
      $output = array(
          "draw" => intval($_POST['draw']),
          "recordsTotal" => $this->Modele->all_data($query_principal),
          "recordsFiltered" => $this->Modele->filtrer($query_filter),
          "data" => $data
        );
        echo json_encode($output);
  }
  function detail_transmis($id,$verification)
 {
    $query_principal ="SELECT htc.MOTIF,hcap.AVIS_PARTENAIRE,htc.DATE_TRAITEMENT_COP , hcc.HISTO_COMMENTAIRE_ID,hcv.ID_HISTORIQUE, hcv.STATUT_FIN_TRAITEMENT, hcv.DATE_CONSTAT,hcv.ID_TYPE_VERIFICATION,  hc.IS_VALIDE_SOURCE,hcc.PHOTO_COMMANTAIRE,hc.COMMENTAIRE_TEXT,hcc.PHOTO_COMMANTAIRE FROM  historique_commentaire_controls hcc LEFT JOIN  historique_commentaire hc ON hc.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID LEFT  JOIN historique_commentaire_verification hcv ON hcv.ID_COMMENTAIRE_VERIFICATION=hcc.ID_COMMENTAIRE_VERIFICATION 
    LEFT JOIN  histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE
     WHERE  hcc.HISTO_COMMENTAIRE_ID  IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat)
        AND hcc.ID_COMMENTAIRE_VERIFICATION=".$id;
         $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
         $var_search=str_replace("'", "\'", $var_search);

         $limit = 'LIMIT 0,10';
         if ($_POST['length'] != -1) {
           $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
         }

         $order_by = '';

         $order_column = array('COMMENTAIRE_TEXT', 'DATE_CONSTAT');

         $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_CONSTAT DESC';

         $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';

         $critaire = '';
         $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' ;
         $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;
         $fetch_psr = $this->Modele->datatable($query_secondaire);
         $data = array();
         $n=1;
         foreach ($fetch_psr as $row) {
          $sub_array=array();
           $sub_array[] = $n++;
           $sub_array[] = $row->COMMENTAIRE_TEXT;
           $sub_array[] = $row->AVIS_PARTENAIRE;
           $sub_array[] = $row->MOTIF;

           if (!empty($row->PHOTO_COMMANTAIRE)) {
                    $sub_array[]= "<a href='#'  title='" . $row->PHOTO_COMMANTAIRE . "' onclick='get_imag(this.title)' ><img style='width:15px' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
                }
                else{
                    $sub_array[]= "Aucun";
                }
           $sub_array[] = $row->DATE_TRAITEMENT_COP;
           $data[] = $sub_array;
         }
         $output = array(
           "recordsTotal" => $this->Modele->all_data($query_principal),
           "recordsFiltered" => $this->Modele->filtrer($query_filter),
           "data" => $data
         );
         echo json_encode($output);
 }
 function detail($id,$verification)
 {

        $query_principal ="SELECT hc.COMMENTAIRE_ID,hcv.ID_COMMENTAIRE_VERIFICATION, hcc.HISTO_COMMENTAIRE_ID,hcv.ID_HISTORIQUE, hcv.STATUT_FIN_TRAITEMENT, hcv.DATE_CONSTAT,hcv.ID_TYPE_VERIFICATION,  hc.IS_VALIDE_SOURCE,hcc.PHOTO_COMMANTAIRE,hc.COMMENTAIRE_TEXT,hcc.PHOTO_COMMANTAIRE FROM  historique_commentaire_controls hcc LEFT JOIN  historique_commentaire hc ON hc.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID LEFT  JOIN historique_commentaire_verification hcv ON hcv.ID_COMMENTAIRE_VERIFICATION=hcc.ID_COMMENTAIRE_VERIFICATION WHERE  hcc. POSISTION_NOW=0 AND hcc.HISTO_COMMENTAIRE_ID NOT  IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat) AND hcc.ID_COMMENTAIRE_VERIFICATION=".$id;

         $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
         $var_search=str_replace("'", "\'", $var_search);
         $limit = 'LIMIT 0,10';
         if ($_POST['length'] != -1) {
           $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
         }

         $order_by = '';

         $order_column = array('COMMENTAIRE_TEXT', 'DATE_CONSTAT');

         $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_CONSTAT DESC';

         $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';

         $critaire = '';

         $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' ;
         $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

         $fetch_psr = $this->Modele->datatable($query_secondaire);
         $data = array();
         foreach ($fetch_psr as $row) {

          
          $sub_array=array();
                      
           $sub_array[] = '<input type="checkbox" value="'.$row->HISTO_COMMENTAIRE_ID.'"name="COMMENTAIRE_ID" onchange="one_checked()">';
           $sub_array[] = $row->COMMENTAIRE_TEXT;
           if (!empty($row->PHOTO_COMMANTAIRE)) {
            $sub_array[]= "<a href='#'  title='" . $row->PHOTO_COMMANTAIRE . "' onclick='get_imag(this.title)' ><img style='width:15px' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
          }
          else{
            $sub_array[]= "Aucun";

          }
        $html="";
        if($row->ID_TYPE_VERIFICATION==2 && $row->IS_VALIDE_SOURCE==0)
        {
         $AssureurList=$this->Modele->getListOrder("assureur","ASSURANCE");
         $html.=" <select name='ID_ASSUREUR_ALL' id='ID_ASSUREUR_ALL' class='form-control'>
                   <option value=''>Sélectionner un assureur </option>";
                    foreach ($AssureurList as $value) { 
                     $html.="<option value='".$value['ID_ASSUREUR']." '>".$value['ASSURANCE']."</option>";
                    }
                 $html.="</select>";
        }
        if($verification==2)
        {
           $option = '';
           $option .= "<a class='btn btn-outline-primary' hre='#' data-toggle='modal'
              data-target='#mydelete" . $row->HISTO_COMMENTAIRE_ID . "'><font class='text-info'>&nbsp;&nbsp;Avis</font></a></li></ul> </div>";
           
          $option .= "<div class='modal fade' id='mydelete". $row->HISTO_COMMENTAIRE_ID."'>
          <div class='modal-dialog'>
          <div class='modal-content'>
          <div class='modal-body'>
           <form id='myForm".$row->HISTO_COMMENTAIRE_ID."' action=".base_url('PSR/Commentaire/save') ." method='post' autocomplete='off'>
          <label>Assureur</label>
          ".$html."
          
           <input type='hidden' value=".$row->ID_HISTORIQUE."  name='id_historique' id='id_historique' placeholder='Adresse'> 
            <input type='hidden' value=".$row->ID_TYPE_VERIFICATION."class='form-control' name='id_type_verification' id='id_type_verification' placeholder='Adresse'> 
            <input type='hidden' value=".$row->ID_COMMENTAIRE_VERIFICATION." name='commentaire_verification' id='commentaire_verification' placeholder='commentaire_verification'> 
            <input type='hidden' value=".$row->HISTO_COMMENTAIRE_ID."class='form-control' name='histo_commentaire_id' id='histo_commentaire_id' placeholder='Adresse'> 
          </div>
          <div class='modal-footer'>
          <button type='button' onclick='subForm(".$row->HISTO_COMMENTAIRE_ID.")' class='btn btn-primary btn-md' >Envoyer</button> </form> 
          <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
          </div>
          </div>
          </div>
          </div>";
         
            
           $sub_array[] = $option;
        }
else
{
   
   $option = "<form  id='subForm_inst".$row->HISTO_COMMENTAIRE_ID."' action=".base_url('PSR/Commentaire/save') ." method='post' autocomplete='off'>
   <input type='hidden' value=".$row->ID_HISTORIQUE."  name='id_historique' id='id_historique' placeholder='Adresse'> 
    <input type='hidden' value=".$row->ID_TYPE_VERIFICATION."class='form-control' name='id_type_verification' id='id_type_verification' placeholder='Adresse'> 
    <input type='hidden' value=".$row->HISTO_COMMENTAIRE_ID."class='form-control' name='histo_commentaire_id' id='histo_commentaire_id' placeholder='Adresse'>
    <input type='hidden' value=".$row->ID_COMMENTAIRE_VERIFICATION." name='commentaire_verification' id='commentaire_verification' placeholder='commentaire_verification'>  
   
    <button type='button' onclick='subForm_inst(".$row->HISTO_COMMENTAIRE_ID.")' class='btn btn-primary btn-md' >Envoyer</button>
    </form> ";
   $sub_array[] = $option;
}     
           $data[] = $sub_array;
         }
 
         $output = array(
           // "draw" => intval($_POST['draw']),
           "recordsTotal" => $this->Modele->all_data($query_principal),
           "recordsFiltered" => $this->Modele->filtrer($query_filter),
           "data" => $data
         );
         echo json_encode($output);
  }
  function detail_const($id)
 {
       $query_principal= "SELECT h.NUMERO_PERMIS,hcap.AVIS_PARTENAIRE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
        LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE WHERE  htc.HISTO_TRAITEMENT_CONSTANT_ID=".$id;

       $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
       $var_search=str_replace("'", "\'", $var_search);

        $limit = 'LIMIT 0,10';

        if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }

        $order_by = '';

        $order_column = array('NUMERO_PLAQUE', 'DATE');

        $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_INSERTION ASC';

        $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';


        $critaire = '';

        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' ;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

         $fetch_psr = $this->Modele->datatable($query_secondaire);
         $data = array();
         foreach ($fetch_psr as $row) {
          foreach ($fetch_psr as $row) {
            $sub_array=array();
            $sub_array[] = $row->ASSURANCE;
            $sub_array[] = $row->AVIS_PARTENAIRE?$row->AVIS_PARTENAIRE:'En attente avis du partenaire';
            $sub_array[] = $row->DATE_TRAITEMENT_COP;
            $option = '<div class="dropdown ">
                       <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-cog"></i>
            Action<span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-menu-left">
              ';

                  $option .= "<li><a class='btn-md' hre='#' data-toggle='modal'
              data-target='#mydelete" . $row->HISTO_TRAITEMENT_CONSTANT_ID . "'><font color='red'>&nbsp;&nbsp;Annuler</font></a></li>";
                  $option .= "<li><a class='btn-md' href='" . base_url('PSR/Commentaire/getOne/' . $row->HISTO_TRAITEMENT_CONSTANT_ID) . "'><label class='text-info'>&nbsp;&nbsp;Detailler</label></a></li>";
                  $option .= " </ul>
              </div>
              <div class='modal fade' id='mydelete" .  $row->HISTO_TRAITEMENT_CONSTANT_ID . "'>
              <div class='modal-dialog'>
              <div class='modal-content'>";
             $sub_array[] = $option;
            $data[] = $sub_array;
        }
        $output = array(
           "draw" => intval($_POST['draw']),
           "recordsTotal" => $this->Modele->all_data($query_principal),
           "recordsFiltered" => $this->Modele->filtrer($query_filter),
           "data" => $data
         );
         echo json_encode($output);
          }
           }
  public function save_institution($id_historique,$id_type_verification,$commentaire_verification,$histo_commentaire_id)
  {
        $id_assureur = $this->input->post('assureur');
        $date =date('Y-m-d:H-i');
        $id_utilisateur = $this->session->userdata('USER_ID');
        $data = array('ID_HISTORIQUE' =>$id_historique ,
                      'ID_TYPE_VERIFICATION' =>$id_type_verification,
                      'HISTO_COMMENTAIRE_ID' =>$histo_commentaire_id,
                      'ID_ASSUREUR' =>0,
                      'DATE_TRAITEMENT_COP'=>$date,
                      'ID_CONST_STATUT_TRAITE'=>2,
                      'ID_UTILISATEUR_COP'=>$id_utilisateur
                     );
       $all_valide = $this->Modele->getRequeteOne('SELECT COUNT(*) AS valide ,hcv.ID_COMMENTAIRE_VERIFICATION ,hcv.ID_TYPE_VERIFICATION FROM historique_commentaire_controls  hcc  LEFT JOIN historique_commentaire_verification hcv ON hcv.ID_COMMENTAIRE_VERIFICATION=hcc.ID_COMMENTAIRE_VERIFICATION WHERE hcc.POSISTION_NOW=0 AND hcv.ID_COMMENTAIRE_VERIFICATION='.$commentaire_verification.' GROUP BY hcv.ID_COMMENTAIRE_VERIFICATION ,hcv.ID_TYPE_VERIFICATION ');

        // if( $all_valide['valide']==1)
        // {
        //   $this->Modele->update('historique_commentaire_verification', array('ID_COMMENTAIRE_VERIFICATION'=>$commentaire_verification ),array('STATUT_FIN_TRAITEMENT'=>1));
        // }
        // $this->Modele->update('historique_commentaire_controls', array('HISTO_COMMENTAIRE_ID'=>$histo_commentaire_id ),array('POSISTION_NOW'=>1));
        $this->Modele->create('histo_traitement_constat',$data);
       // $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id_historique ),array('ID_HISTORIQUE_STATUT'=>5));

        $data['sms']='<div class="alert alert-success text-center" id ="sms">Opération faite avec succes.</div>';
  $this->session->set_flashdata($data);
     print_r(json_encode(1));
  }
  public function save()
  {
    $id_historique =$this->input->post('id_historique');
    $id_type_verification=$this->input->post('id_type_verification');
    $commentaire_verification=$this->input->post('commentaire_verification');
    $histo_commentaire_id=$this->input->post('histo_commentaire_id');
    $id_assureur = $this->input->post('assureurIds');
        $date =date('Y-m-d:H-i');
        $id_utilisateur = $this->session->userdata('USER_ID');
        if($id_type_verification!=2)
        {
          $data = array('ID_HISTORIQUE' =>$id_historique ,
                      'ID_TYPE_VERIFICATION' =>$id_type_verification,
                      'HISTO_COMMENTAIRE_ID' =>$histo_commentaire_id,
                      'ID_ASSUREUR' =>0,
                      'DATE_TRAITEMENT_COP'=>$date,
                      'ID_CONST_STATUT_TRAITE'=>2,
                      'ID_UTILISATEUR_COP'=>$id_utilisateur
                     );
        }
        else{
          $data = array('ID_HISTORIQUE' =>$id_historique ,
                      'ID_TYPE_VERIFICATION' =>$id_type_verification,
                      'HISTO_COMMENTAIRE_ID' =>$histo_commentaire_id,
                      'ID_ASSUREUR' =>$id_assureur,
                      'DATE_TRAITEMENT_COP'=>$date,
                      'ID_CONST_STATUT_TRAITE'=>2,
                      'ID_UTILISATEUR_COP'=>$id_utilisateur
                     );  
        }
        
        $this->Modele->create('histo_traitement_constat',$data);
        $data['sms']='<div class="alert alert-success text-center" id ="sms">Opération faite avec succes.</div>';
        $this->session->set_flashdata($data);
       redirect(base_url('PSR/Commentaire/all_const'));

  }
public function save_assurareur($id_historique,$id_type_verification,$commentaire_verification,$histo_commentaire_id,$id_assureur)
  {
        $date =date('Y-m-d:H-i');
        $id_utilisateur = $this->session->userdata('USER_ID');
           $data = array('ID_HISTORIQUE' =>$id_historique ,
                      'ID_TYPE_VERIFICATION' =>$id_type_verification,
                      'ID_ASSUREUR' =>$id_assureur,
                      'HISTO_COMMENTAIRE_ID' =>$histo_commentaire_id,
                      'DATE_TRAITEMENT_COP'=>$date,
                      'ID_CONST_STATUT_TRAITE'=>2,
                      'ID_UTILISATEUR_COP'=>$id_utilisateur
                     );
       $all_valide = $this->Modele->getRequeteOne('SELECT COUNT(*) AS valide ,hcv.ID_COMMENTAIRE_VERIFICATION ,hcv.ID_TYPE_VERIFICATION FROM historique_commentaire_controls  hcc  LEFT JOIN historique_commentaire_verification hcv ON hcv.ID_COMMENTAIRE_VERIFICATION=hcc.ID_COMMENTAIRE_VERIFICATION WHERE hcc.POSISTION_NOW=0 AND hcv.ID_COMMENTAIRE_VERIFICATION='.$commentaire_verification.' GROUP BY hcv.ID_COMMENTAIRE_VERIFICATION ,hcv.ID_TYPE_VERIFICATION');
        
        $this->Modele->create('histo_traitement_constat',$data);
        $data['sms']='<div class="alert alert-success text-center" id ="sms">Opération faite avec succes.</div>';
       $this->session->set_flashdata($data);
       print_r(json_encode(1));
 }

 public function update($id)
 {
        $id_avis = $this->input->post('avis');
        $motif = $this->input->post('motif');
        $histo_commentaire_id = $this->input->post('histo_commentaire_id');
        $date =date('Y-m-d:H-i');
        $this->Modele->update('histo_traitement_constat', array('HISTO_TRAITEMENT_CONSTANT_ID'=>$id),array('ID_AVIS_PARTENAIRE'=>$id_avis,'ID_CONST_STATUT_TRAITE'=>3,'MOTIF'=>$motif,'DATE_TRAITEMENT_PARTENAIRE'=>$date));
        $this->Modele->update('historique_commentaire_controls', array('HISTO_COMMENTAIRE_ID'=>$histo_commentaire_id),array('POSISTION_NOW'=>$id_avis));

        $data['sms']='<div class="alert alert-success text-center" id ="sms">Opération faite avec succes.</div>';
  $this->session->set_flashdata($data);
  redirect(base_url('PSR/Commentaire/all_const'));
  // }

 }
 public function approuver($id,$id_histo,$id_type)
 {
        
        $date =date('Y-m-d:H-i');
        $this->Modele->create('histo_traitement_constat',array('ID_AVIS_PARTENAIRE'=>1,'ID_CONST_STATUT_TRAITE'=>3,'MOTIF'=>"",'DATE_TRAITEMENT_PARTENAIRE'=>$date,'ID_HISTORIQUE'=>$id_histo,'HISTO_COMMENTAIRE_ID'=>$id,'ID_TYPE_VERIFICATION'=>$id_type));

        $this->Modele->update('historique_commentaire_controls', array('HISTO_COMMENTAIRE_ID'=>$id),array('POSISTION_NOW'=>1));
        $typeVerification = $this->Modele->getRequeteOne('SELECT ID_COMMENTAIRE_VERIFICATION FROM  historique_commentaire_controls WHERE HISTO_COMMENTAIRE_ID='.$id);
        
        $verifictaion_position = $this->Modele->getRequeteOne('SELECT COUNT(*) as nbre,ID_COMMENTAIRE_VERIFICATION FROM historique_commentaire_controls hcc  WHERE ID_COMMENTAIRE_VERIFICATION='.$typeVerification['ID_COMMENTAIRE_VERIFICATION'] .' AND POSISTION_NOW=0 GROUP by  ID_COMMENTAIRE_VERIFICATION');

            if($verifictaion_position['nbre']==0)
            {
             $this->Modele->update('historique_commentaire_verification', array('ID_COMMENTAIRE_VERIFICATION'=>$typeVerification['ID_COMMENTAIRE_VERIFICATION']),array('STATUT_FIN_TRAITEMENT'=>1));

                 $historique = $this->Modele->getRequeteOne('SELECT ID_HISTORIQUE FROM  historique_commentaire_verification  WHERE ID_COMMENTAIRE_VERIFICATION='.$typeVerification['ID_COMMENTAIRE_VERIFICATION']);
        
                  $verifictaion_fin = $this->Modele->getRequeteOne('SELECT COUNT(*) as nbre,ID_HISTORIQUE FROM historique_commentaire_verification hcc  WHERE ID_HISTORIQUE='.$historique['ID_HISTORIQUE'] .' AND STATUT_FIN_TRAITEMENT=0 GROUP by  ID_HISTORIQUE');
                  if($verifictaion_fin['nbre']==0)
                 {
                 $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$historique['ID_HISTORIQUE']),array('ID_HISTORIQUE_STATUT'=>6));
                }
            }
print_r(json_encode(1));
  // }

 }
 public function update_all($id,$id_avis, $motif,$histo_commentaire_id)
 {
        $date =date('Y-m-d:H-i');
        $this->Modele->update('histo_traitement_constat', array('HISTO_TRAITEMENT_CONSTANT_ID'=>$id),array('ID_AVIS_PARTENAIRE'=>$id_avis,'ID_CONST_STATUT_TRAITE'=>3,'MOTIF'=>$motif,'DATE_TRAITEMENT_PARTENAIRE'=>$date));
        $this->Modele->update('historique_commentaire_controls', array('HISTO_COMMENTAIRE_ID'=>$histo_commentaire_id),array('POSISTION_NOW'=>$id_avis));

        $typeVerification = $this->Modele->getRequeteOne('SELECT ID_COMMENTAIRE_VERIFICATION FROM  historique_commentaire_controls WHERE HISTO_COMMENTAIRE_ID='.$histo_commentaire_id);
        
        $verifictaion_position = $this->Modele->getRequeteOne('SELECT COUNT(*) as nbre,ID_COMMENTAIRE_VERIFICATION FROM historique_commentaire_controls hcc  WHERE ID_COMMENTAIRE_VERIFICATION='.$typeVerification['ID_COMMENTAIRE_VERIFICATION'] .' AND POSISTION_NOW=0 GROUP by  ID_COMMENTAIRE_VERIFICATION');

            if($verifictaion_position['nbre']==0)
            {
             $this->Modele->update('historique_commentaire_verification', array('ID_COMMENTAIRE_VERIFICATION'=>$typeVerification['ID_COMMENTAIRE_VERIFICATION']),array('STATUT_FIN_TRAITEMENT'=>1));

                 $historique = $this->Modele->getRequeteOne('SELECT ID_HISTORIQUE FROM  historique_commentaire_verification  WHERE ID_COMMENTAIRE_VERIFICATION='.$typeVerification['ID_COMMENTAIRE_VERIFICATION']);
        
                  $verifictaion_fin = $this->Modele->getRequeteOne('SELECT COUNT(*) as nbre,ID_HISTORIQUE FROM historique_commentaire_verification hcc  WHERE ID_HISTORIQUE='.$historique['ID_HISTORIQUE'] .' AND STATUT_FIN_TRAITEMENT=0 GROUP by  ID_HISTORIQUE');
                  if($verifictaion_fin['nbre']==0)
                 {
                 $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$historique['ID_HISTORIQUE']),array('ID_HISTORIQUE_STATUT'=>6));
                }
            }
            echo (1);
 }
public function avise_all()
{
        $id_avis = $this->input->post('ID_AVIS');
        $motif = $this->input->post('MOTIF');
        $HISTO=  $this->input->post('HISTO_COMMENTAIRE_ID');
        foreach ($HISTO as $key => $value) 
        {
            $constant = $this->Modele->getRequeteOne('SELECT htc.HISTO_TRAITEMENT_CONSTANT_ID FROM histo_traitement_constat htc  WHERE htc.HISTO_COMMENTAIRE_ID='.$value);
            $this->update_all($constant['HISTO_TRAITEMENT_CONSTANT_ID'],
            $id_avis, $motif,$value);
        }
 }
 //MISE A JOUR SI UN INSTUTION DONNER UN  AVIS
 public function updateInstution($id)
 {
    $id_avis = $this->input->post('avis');
    $motif = $this->input->post('motif');
    $histo_commentaire_id=$this->input->post('histo_commentaire_id');
    $date =date('Y-m-d:H-i');
   
        $this->Modele->update('histo_traitement_constat', array('HISTO_TRAITEMENT_CONSTANT_ID'=>$id),array('ID_AVIS_PARTENAIRE'=>$id_avis,'ID_CONST_STATUT_TRAITE'=>3,'MOTIF'=>$motif,'DATE_TRAITEMENT_PARTENAIRE'=>$date));
        $this->Modele->update('historique_commentaire_controls', array('HISTO_COMMENTAIRE_ID'=>$histo_commentaire_id),array('POSISTION_NOW'=>$id_avis));

        $typeVerification = $this->Modele->getRequeteOne('SELECT ID_COMMENTAIRE_VERIFICATION FROM  historique_commentaire_controls WHERE HISTO_COMMENTAIRE_ID='.$histo_commentaire_id);
        
        $verifictaion_position = $this->Modele->getRequeteOne('SELECT COUNT(*) as nbre,ID_COMMENTAIRE_VERIFICATION FROM historique_commentaire_controls hcc  WHERE ID_COMMENTAIRE_VERIFICATION='.$typeVerification['ID_COMMENTAIRE_VERIFICATION'] .' AND POSISTION_NOW=0 GROUP by  ID_COMMENTAIRE_VERIFICATION');

            if($verifictaion_position['nbre']==0)
            {
             $this->Modele->update('historique_commentaire_verification', array('ID_COMMENTAIRE_VERIFICATION'=>$typeVerification['ID_COMMENTAIRE_VERIFICATION']),array('STATUT_FIN_TRAITEMENT'=>1));

                 $historique = $this->Modele->getRequeteOne('SELECT ID_HISTORIQUE FROM  historique_commentaire_verification  WHERE ID_COMMENTAIRE_VERIFICATION='.$typeVerification['ID_COMMENTAIRE_VERIFICATION']);
        
                  $verifictaion_fin = $this->Modele->getRequeteOne('SELECT COUNT(*) as nbre,ID_HISTORIQUE FROM historique_commentaire_verification hcc  WHERE ID_HISTORIQUE='.$historique['ID_HISTORIQUE'] .' AND STATUT_FIN_TRAITEMENT=0 GROUP by  ID_HISTORIQUE');
                  if($verifictaion_fin['nbre']==0)
                 {
                 $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$historique['ID_HISTORIQUE']),array('ID_HISTORIQUE_STATUT'=>6));
                }
            }
  print_r(json_encode(1));

 }
 public function constant_partenaire()
 {
  $query_principal= "SELECT h.NUMERO_PERMIS, hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  WHERE  a.ID_UTILISATEUR=".$this->session->userdata('USER_ID');

  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
  $var_search=str_replace("'", "\'", $var_search);

        $limit = 'LIMIT 0,10';

        if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }

        $order_by = '';

        $order_column = array('NUMERO_PLAQUE', 'DATE');

        $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_INSERTION ASC';

        $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';


        $critaire = '';

        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' ;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

        $fetch_psr = $this->Modele->datatable($query_secondaire);
        $Avis=$this->Modele->getListOrder("histo_consta_avis_partenaire","AVIS_PARTENAIRE");

        $html="";
         $html.=" <select name='ID_AVIS_PARTENAIRE' id='ID_AVIS_PARTENAIRE'  class='form-control'>
                   <option value=''>Sélectionner </option>";
                    foreach ($Avis as $value) { 
                     $html.="<option selected='' value='".$value['ID_AVIS_PARTENAIRE']." '>".$value['AVIS_PARTENAIRE']."</option>";
                    }
                 $html.="</select>";
        $data = array();
        foreach ($fetch_psr as $row) {
            $sub_array=array();
            $sub_array[] = $row->NUMERO_PLAQUE?$row->NUMERO_PLAQUE:$row->NUMERO_PERMIS;
             $sub_array[]= "<a href='#'  title='" . $row->PHOTO_COMMANTAIRE . "' onclick='get_imag(this.title)' >".$row->COMMENTAIRE_TEXT."</a>";
            if (!empty($row->PHOTO_COMMANTAIRE)) {
         $sub_array[]= "<a href='#'  title='" . $row->PHOTO_COMMANTAIRE . "' onclick='get_imag(this.title)' ><img style='width:15px' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
        }

        else{
         $sub_array[]= "Aucun";

        }
            $sub_array[] = $row->DATE_TRAITEMENT_COP;
        
            $option = '
              ';

                  $option .= "<a class='btn btn-outline-primary' hre='#' data-toggle='modal'
              data-target='#mydelete" . $row->HISTO_TRAITEMENT_CONSTANT_ID . "'><font class='text-info'>&nbsp;&nbsp;Aviser</font></a></li>";
                  
                  $option .= " 
              </div>
              <div class='modal fade' id='mydelete" .  $row->HISTO_TRAITEMENT_CONSTANT_ID . "'>
              <div class='modal-dialog'>
              <div class='modal-content'>
              <div class='modal-header' style='background: black'>
                  <div id='title'><b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'>Avis </h4>

                  </div>
                  <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
                   <span aria-hidden='true'>&times;</span>
                  </div>
              </div>
                 
              <div class='modal-body'>
                  <form action=".base_url('PSR/Commentaire/update/'.$row->HISTO_TRAITEMENT_CONSTANT_ID)." method='post' autocomplete='off'>
                  ".$html."
                 <input type='text' value='' class='form-control' name='motif' id='motif' placeholder='Motif'> 
                      <div class='col-md-12 mt-4'>
                            <input type='submit' class='btn btn-outline-primary form-control' value='Envoyer'>
                      </div> 
                      </form>
              </div>";
          $sub_array[] = $option;
            $data[] = $sub_array;
        }
        $output = array(
           "draw" => intval($_POST['draw']),
           "recordsTotal" => $this->Modele->all_data($query_principal),
           "recordsFiltered" => $this->Modele->filtrer($query_filter),
           "data" => $data
         );
         echo json_encode($output);
 }

 //POUR LES ASSUREURS:NOUVEAU CONSTANT
 public function constant_noTraite()
 {
    $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');
    $criteres_signa = "";
      if(!empty($DATE_UNE) && empty($DATE_DEUX)){
         $criteres_signa = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d')='" . $DATE_UNE."'";
         }
         if(empty($DATE_UNE) && !empty($DATE_DEUX)){
          $criteres_signa = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d')='" . $DATE_DEUX."'";
         }
        if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
        $criteres_signa = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";   
        }
   $query_principal= "SELECT htc.HISTO_TRAITEMENT_CONSTANT_ID,hcv.ID_COMMENTAIRE_VERIFICATION,hcc.HISTO_COMMENTAIRE_ID,hcc.PHOTO_COMMANTAIRE,hc.COMMENTAIRE_TEXT,pa.LIEU_EXACTE,hcv.DATE_CONSTAT, hcv.ID_COMMENTAIRE_VERIFICATION,hcv.COMMENTAIRE,tv.VERIFICATION, tv.ID_TYPE_VERIFICATION ,histo.ID_HISTORIQUE,histo.NUMERO_PERMIS,histo.NUMERO_PLAQUE,histo.NUMERO_PERMIS FROM  historiques histo LEFT JOIN  historique_commentaire_verification  hcv ON hcv.ID_HISTORIQUE=histo.ID_HISTORIQUE LEFT JOIN  type_verification tv ON tv.ID_TYPE_VERIFICATION=hcv.ID_TYPE_VERIFICATION LEFT JOIN  historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=histo.ID_UTILISATEUR LEFT JOIN  psr_affectatations pa ON pa.PSR_AFFECTATION_ID=histo.PSR_AFFECTATION_ID LEFT JOIN historique_commentaire hc ON hc.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID
     LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  WHERE  htc.ID_CONST_STATUT_TRAITE=2 ".$criteres_signa." AND a.ID_ASSUREUR=".$this->session->userdata('ID_INSTITUTION');
     $Avis = $this->Model->getRequete('SELECT * FROM histo_consta_avis_partenaire WHERE 1');
  

  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
  $var_search=str_replace("'", "\'", $var_search);
    $limit = 'LIMIT 0,10';
    if ($_POST['length'] != -1){
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }
    $order_by = '';
    $order_column = array('NUMERO_PLAQUE','ID_TYPE_VERIFICATION','LIEU_EXACTE','VERIFICATION','COMMENTAIRE_TEXT','DATE_CONSTAT',);
    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY  DATE_INSERTION DESC';
    $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';
    $critaire = '';
    $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;
    $fetch_psr = $this->Modele->datatable($query_secondaire);
    $data = array();
    foreach ($fetch_psr as $row) {
       $sub_array = array();
       $sub_array[] = $row->NUMERO_PLAQUE?$row->NUMERO_PLAQUE:$row->NUMERO_PERMIS;
       $sub_array[] = $this->get_concerne($row->ID_TYPE_VERIFICATION,$row->ID_HISTORIQUE);
       $sub_array[] =$row->LIEU_EXACTE;
       $sub_array[] =$row->VERIFICATION;
       $peines=$this->get_peines($row->ID_TYPE_VERIFICATION,$row->ID_HISTORIQUE);
      $long=strlen($peines);
        if($long<=35)
        {
            $sub_array[] = substr($peines,0,35);
        }
        else{
          $sub_array[] = "<a  hre='#' data-toggle='modal'
              data-target='#Peines" . $row->HISTO_COMMENTAIRE_ID . "'>".substr($peines,0,35)."..."."</a>";
        }
       $sub_array[] = $row->COMMENTAIRE_TEXT;
       if (!empty($row->PHOTO_COMMANTAIRE)) {
            $sub_array[]= "<a href='#'  title='" . $row->PHOTO_COMMANTAIRE . "' onclick='get_imag(this.title)' ><img style='width:15px' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
        }
        else{
            $sub_array[]= "Aucun";
        }
        $sub_array[] = $row->DATE_CONSTAT;
        $html="";
       $html.=" <select name='avise' id='avise".$row->HISTO_COMMENTAIRE_ID."'  class='form-control'>
                   <option value=''>Sélectionner </option>";
                    foreach ($Avis as $value) { 
                     $html.="<option  value='".$value['ID_AVIS_PARTENAIRE']." '>".$value['AVIS_PARTENAIRE']."</option>";
                    }
        $html.="</select>";
        $option = '';
        $option .= "<a class='btn btn-outline-primary' hre='#' data-toggle='modal'
              data-target='#institution" . $row->HISTO_COMMENTAIRE_ID . "'><font class='text-info'>&nbsp;&nbsp;Avis</font></a></li>";
          $option .= " 
              </div>
          <div class='modal fade' id='institution" .  $row->HISTO_COMMENTAIRE_ID . "'>
          <div class='modal-dialog'>
          <div class='modal-content'>
            <div class='modal-header' style='background: black;'>
            <div id='title'><b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'>Avis après vérification en interne</h4>
            </div>
            <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </div>
         </div>
          <div class='modal-body'>
          

            <form id='myFormAviseInstution' action=".base_url('PSR/Commentaire/updateInstution/'.$row->HISTO_TRAITEMENT_CONSTANT_ID)." method='post' autocomplete='off'>
                 <div class='form-group'>
                   
                   ".$html."
                 </div>
                <div class='form-group'>
                 <label for='exampleFormControlTextarea1'>Motif</label>
                  <textarea name='motif' id='motif".$row->HISTO_COMMENTAIRE_ID."' class='form-control'  rows='3' placeholder='Motif...'></textarea>
                </div>
                
                <input type='hidden' value=".$row->HISTO_COMMENTAIRE_ID."  name='histo_commentaire_id' id='histo_commentaire_id' placeholder='Adresse'> 
            </form>

          <div class='modal-footer'>
          <button type='submit' onclick='save_all_assur(".$row->HISTO_COMMENTAIRE_ID.")' class='btn btn-primary btn-md' >Envoyer</button> </form> 
          <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
          </div>
          </div>
          </div>
          </div>




        <div class='modal fade' id='Peines" .  $row->HISTO_COMMENTAIRE_ID . "'>
          <div class='modal-dialog'>
          <div class='modal-content'>
            <div class='modal-header' style='background: black;'>
            <div id='title'><b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'> Peines</h4>
            </div>
            <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </div>
         </div>
          <div class='modal-body'>
          ".$peines."
          </div>
          </div>
          </div>
          </div>



          ";
          $sub_array[] = $option;
          $data[] = $sub_array;
        }
        $output = array(
           "draw" => intval($_POST['draw']),
           "recordsTotal" => $this->Modele->all_data($query_principal),
           "recordsFiltered" => $this->Modele->filtrer($query_filter),
           "data" => $data
         );
         echo json_encode($output);
 }
 //POUR LES INSTUTIONS: NOUVEAU CONSTANT 
 public function constant_noTraite_instution()
 {

    $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');
    $criteres_signa = "";
      if(!empty($DATE_UNE) && empty($DATE_DEUX)){
         $criteres_signa = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d')='" . $DATE_UNE."'";
         }
         if(empty($DATE_UNE) && !empty($DATE_DEUX)){
          $criteres_signa = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d')='" . $DATE_DEUX."'";
         }
        if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
        $criteres_signa = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";   
        }
  $id=$this->session->userdata('USER_ID');
  $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID,ass.ASSURANCE FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID LEFT JOIN assureur ass ON ass.ID_UTILISATEUR=u.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id);
   $query_principal= "";
   $Avis = $this->Model->getRequete('SELECT * FROM histo_consta_avis_partenaire WHERE 1');
  
    
if($profil['PROFIL_ID']==3){
   $query_principal = "SELECT htc.DATE_TRAITEMENT_COP,htc.HISTO_TRAITEMENT_CONSTANT_ID,hcv.ID_COMMENTAIRE_VERIFICATION,hcc.HISTO_COMMENTAIRE_ID,hcc.PHOTO_COMMANTAIRE,hc.COMMENTAIRE_TEXT,pa.LIEU_EXACTE,hcv.DATE_CONSTAT, hcv.ID_COMMENTAIRE_VERIFICATION,hcv.COMMENTAIRE,tv.VERIFICATION, tv.ID_TYPE_VERIFICATION ,histo.ID_HISTORIQUE,histo.NUMERO_PERMIS,histo.NUMERO_PLAQUE,histo.NUMERO_PERMIS FROM  historiques histo LEFT JOIN  historique_commentaire_verification  hcv ON hcv.ID_HISTORIQUE=histo.ID_HISTORIQUE LEFT JOIN  type_verification tv ON tv.ID_TYPE_VERIFICATION=hcv.ID_TYPE_VERIFICATION LEFT JOIN  historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=histo.ID_UTILISATEUR LEFT JOIN  psr_affectatations pa ON pa.PSR_AFFECTATION_ID=histo.PSR_AFFECTATION_ID LEFT JOIN historique_commentaire hc ON hc.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID
     WHERE tv.ID_TYPE_VERIFICATION=1 AND htc.ID_CONST_STATUT_TRAITE=2   AND hcc. POSISTION_NOW=0 AND hcc.HISTO_COMMENTAIRE_ID  IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat) ".$criteres_signa ;
}
else if($profil['PROFIL_ID']==4){ 
  $query_principal = "SELECT htc.DATE_TRAITEMENT_COP,htc.HISTO_TRAITEMENT_CONSTANT_ID,hcv.ID_COMMENTAIRE_VERIFICATION,hcc.HISTO_COMMENTAIRE_ID,hcc.PHOTO_COMMANTAIRE,hc.COMMENTAIRE_TEXT,pa.LIEU_EXACTE,hcv.DATE_CONSTAT, hcv.ID_COMMENTAIRE_VERIFICATION,hcv.COMMENTAIRE,tv.VERIFICATION, tv.ID_TYPE_VERIFICATION ,histo.ID_HISTORIQUE,histo.NUMERO_PERMIS,histo.NUMERO_PLAQUE,histo.NUMERO_PERMIS FROM  historiques histo LEFT JOIN  historique_commentaire_verification  hcv ON hcv.ID_HISTORIQUE=histo.ID_HISTORIQUE LEFT JOIN  type_verification tv ON tv.ID_TYPE_VERIFICATION=hcv.ID_TYPE_VERIFICATION LEFT JOIN  historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=histo.ID_UTILISATEUR LEFT JOIN  psr_affectatations pa ON pa.PSR_AFFECTATION_ID=histo.PSR_AFFECTATION_ID LEFT JOIN historique_commentaire hc ON hc.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID
     WHERE tv.ID_TYPE_VERIFICATION=4 AND htc.ID_CONST_STATUT_TRAITE=2   AND hcc. POSISTION_NOW=0 AND hcc.HISTO_COMMENTAIRE_ID  IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat) ".$criteres_signa;
}
else if($profil['PROFIL_ID']==5)
{
   $query_principal = "SELECT htc.DATE_TRAITEMENT_COP,htc.HISTO_TRAITEMENT_CONSTANT_ID,hcv.ID_COMMENTAIRE_VERIFICATION,hcc.HISTO_COMMENTAIRE_ID,hcc.PHOTO_COMMANTAIRE,hc.COMMENTAIRE_TEXT,pa.LIEU_EXACTE,hcv.DATE_CONSTAT, hcv.ID_COMMENTAIRE_VERIFICATION,hcv.COMMENTAIRE,tv.VERIFICATION, tv.ID_TYPE_VERIFICATION ,histo.ID_HISTORIQUE,histo.NUMERO_PERMIS,histo.NUMERO_PLAQUE,histo.NUMERO_PERMIS FROM  historiques histo LEFT JOIN  historique_commentaire_verification  hcv ON hcv.ID_HISTORIQUE=histo.ID_HISTORIQUE LEFT JOIN  type_verification tv ON tv.ID_TYPE_VERIFICATION=hcv.ID_TYPE_VERIFICATION LEFT JOIN  historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=histo.ID_UTILISATEUR LEFT JOIN  psr_affectatations pa ON pa.PSR_AFFECTATION_ID=histo.PSR_AFFECTATION_ID LEFT JOIN historique_commentaire hc ON hc.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID
     WHERE (tv.ID_TYPE_VERIFICATION=3 OR htc.ID_TYPE_VERIFICATION=8) AND htc.ID_CONST_STATUT_TRAITE=2   AND hcc. POSISTION_NOW=0 AND hcc.HISTO_COMMENTAIRE_ID  IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat) ".$criteres_signa ;
}
else if($profil['PROFIL_ID']==6)
{
   $query_principal = "SELECT htc.DATE_TRAITEMENT_COP,htc.HISTO_TRAITEMENT_CONSTANT_ID,hcv.ID_COMMENTAIRE_VERIFICATION,hcc.HISTO_COMMENTAIRE_ID,hcc.PHOTO_COMMANTAIRE,hc.COMMENTAIRE_TEXT,pa.LIEU_EXACTE,hcv.DATE_CONSTAT, hcv.ID_COMMENTAIRE_VERIFICATION,hcv.COMMENTAIRE,tv.VERIFICATION, tv.ID_TYPE_VERIFICATION ,histo.ID_HISTORIQUE,histo.NUMERO_PERMIS,histo.NUMERO_PLAQUE,histo.NUMERO_PERMIS FROM  historiques histo LEFT JOIN  historique_commentaire_verification  hcv ON hcv.ID_HISTORIQUE=histo.ID_HISTORIQUE LEFT JOIN  type_verification tv ON tv.ID_TYPE_VERIFICATION=hcv.ID_TYPE_VERIFICATION LEFT JOIN  historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=histo.ID_UTILISATEUR LEFT JOIN  psr_affectatations pa ON pa.PSR_AFFECTATION_ID=histo.PSR_AFFECTATION_ID LEFT JOIN historique_commentaire hc ON hc.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID
     WHERE tv.ID_TYPE_VERIFICATION=6 AND htc.ID_CONST_STATUT_TRAITE=2   AND hcc. POSISTION_NOW=0 AND hcc.HISTO_COMMENTAIRE_ID  IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat) ".$criteres_signa ;
}
    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
    $var_search=str_replace("'", "\'", $var_search);
    $limit = 'LIMIT 0,10';
    if ($_POST['length'] != -1){
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }
    $order_by = '';
    $order_column = array('NUMERO_PLAQUE','ID_TYPE_VERIFICATION','LIEU_EXACTE','VERIFICATION','COMMENTAIRE_TEXT','PHOTO_COMMANTAIRE','DATE_TRAITEMENT_COP','DATE_TRAITEMENT_COP');
    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY  DATE_INSERTION DESC';
    $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';
    $critaire = '';
    $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;
    $fetch_psr = $this->Modele->datatable($query_secondaire);
    $data = array();
    foreach ($fetch_psr as $row) {
       $sub_array = array();
       $sub_array[] = $row->NUMERO_PLAQUE?$row->NUMERO_PLAQUE:$row->NUMERO_PERMIS;
       $sub_array[] = $this->get_concerne($row->ID_TYPE_VERIFICATION,$row->ID_HISTORIQUE);
       $sub_array[] =$row->LIEU_EXACTE;
       $sub_array[] =$row->VERIFICATION;
       $peines=$this->get_peines($row->ID_TYPE_VERIFICATION,$row->ID_HISTORIQUE);
      $long=strlen($peines);
        if($long<=35)
        {
            $sub_array[] = substr($peines,0,35);
        }
        else{
          $sub_array[] = "<a  hre='#' data-toggle='modal'
              data-target='#Peines" . $row->HISTO_COMMENTAIRE_ID . "'>".substr($peines,0,35)."..."."</a>";
        }
       $sub_array[] = $row->COMMENTAIRE_TEXT;
       if (!empty($row->PHOTO_COMMANTAIRE)) {
            $sub_array[]= "<a href='#'  title='" . $row->PHOTO_COMMANTAIRE . "' onclick='get_imag(this.title)' ><img style='width:15px' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
        }
        else{
            $sub_array[]= "Aucun";
        }
        $sub_array[] = $row->DATE_TRAITEMENT_COP;
        $html="";
       $html.=" <select name='avise' id='avise".$row->HISTO_COMMENTAIRE_ID."'  class='form-control'>
                   <option value=''>Sélectionner</option>";
                    foreach ($Avis as $value) { 
                     $html.="<option  value='".$value['ID_AVIS_PARTENAIRE']." '>".$value['AVIS_PARTENAIRE']."</option>";
                    }
        $html.="</select>";
        $option = '';
        $option .= "<a class='btn btn-outline-primary' href='#' data-toggle='modal'
              data-target='#institution" . $row->HISTO_COMMENTAIRE_ID . "'><font class='text-info'>&nbsp;&nbsp;Avis</font></a></li>";
          $option .= " 
              </div>
          <div class='modal fade' id='institution" .  $row->HISTO_COMMENTAIRE_ID . "'>
          <div class='modal-dialog'>
          <div class='modal-content'>
            <div class='modal-header' style='background: black;'>
            <div id='title'><b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'>Avis après vérification en interne</h4>
            </div>
            <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </div>
         </div>
          <div class='modal-body'>
          

            <form id='myFormAviseInstution' action=".base_url('PSR/Commentaire/updateInstution/'.$row->HISTO_TRAITEMENT_CONSTANT_ID)." method='post' autocomplete='off'>
                 <div class='form-group'>
                   
                   ".$html."
                 </div>
                <div class='form-group'>
                 <label for='exampleFormControlTextarea1'>Motif</label>
                  <textarea name='motif' id='motif".$row->HISTO_COMMENTAIRE_ID."' class='form-control'  rows='3' placeholder='Motif...'></textarea>
                </div>
                
                <input type='hidden' value=".$row->HISTO_COMMENTAIRE_ID."  name='histo_commentaire_id' id='histo_commentaire_id' placeholder='Adresse'> 
            </form>

          <div class='modal-footer'>
          <button type='submit' onclick='save_all_instution(".$row->HISTO_COMMENTAIRE_ID.")' class='btn btn-primary btn-md' >Envoyer</button> </form> 
          <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
          </div>
          </div>
          </div>
          </div>




        <div class='modal fade' id='Peines" .  $row->HISTO_COMMENTAIRE_ID . "'>
          <div class='modal-dialog'>
          <div class='modal-content'>
            <div class='modal-header' style='background: black;'>
            <div id='title'><b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'> Peines</h4>
            </div>
            <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </div>
         </div>
          <div class='modal-body'>
          ".$peines."
          </div>
          </div>
          </div>
          </div>



          ";
          $sub_array[] = $option;
          $data[] = $sub_array;
        }
        $output = array(
           "draw" => intval($_POST['draw']),
           "recordsTotal" => $this->Modele->all_data($query_principal),
           "recordsFiltered" => $this->Modele->filtrer($query_filter),
           "data" => $data
         );
         echo json_encode($output);
 }
 //POUR LES INSTUTIONS: CONSTANT RETOURS COP
 public function constant_avise_instution()
 {
  $id=$this->session->userdata('USER_ID');
  $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID,ass.ASSURANCE FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID LEFT JOIN assureur ass ON ass.ID_UTILISATEUR=u.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id);
    $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');
    $criteres_signa = "";
      if(!empty($DATE_UNE) && empty($DATE_DEUX)){
         $criteres_signa = " and DATE_FORMAT(htc.DATE_TRAITEMENT_PARTENAIRE, '%Y-%m-%d')='" . $DATE_UNE."'";
         }
         if(empty($DATE_UNE) && !empty($DATE_DEUX)){
          $criteres_signa = " and DATE_FORMAT(htc.DATE_TRAITEMENT_PARTENAIRE, '%Y-%m-%d')='" . $DATE_DEUX."'";
         }
        if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
        $criteres_signa = " and DATE_FORMAT(htc.DATE_TRAITEMENT_PARTENAIRE, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";   
        }
   $query_principal= "";
if($profil['PROFIL_ID']==3)
{
  $Avis = $this->Model->getRequete('SELECT * FROM histo_consta_avis_partenaire WHERE ID_AVIS_PARTENAIRE=1');
  $query_principal= "SELECT h.NUMERO_PERMIS,h.DATE_INSERTION,hcap.AVIS_PARTENAIRE,htc.MOTIF,hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE    WHERE tv.ID_TYPE_VERIFICATION=1 AND htc.ID_CONST_STATUT_TRAITE=3  ".$criteres_signa ;
}
else if($profil['PROFIL_ID']==4)
{
   $query_principal= "SELECT h.NUMERO_PERMIS, h.DATE_INSERTION,hcap.AVIS_PARTENAIRE,htc.MOTIF,hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE   WHERE tv.ID_TYPE_VERIFICATION=4 AND htc.ID_CONST_STATUT_TRAITE=3 ".$criteres_signa ;
}
else if($profil['PROFIL_ID']==5)
{
   $query_principal= "SELECT h.NUMERO_PERMIS,h.DATE_INSERTION,hcap.AVIS_PARTENAIRE,htc.MOTIF,hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE  WHERE (tv.ID_TYPE_VERIFICATION=3 OR tv.ID_TYPE_VERIFICATION=8 )AND htc.ID_CONST_STATUT_TRAITE=3 ".$criteres_signa ;
}
else 
{
   $query_principal= "SELECT h.NUMERO_PERMIS,h.DATE_INSERTION,hcap.AVIS_PARTENAIRE,htc.MOTIF,hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE    WHERE tv.ID_TYPE_VERIFICATION=6 AND htc.ID_CONST_STATUT_TRAITE=3 ".$criteres_signa;
}
 $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
 $var_search=str_replace("'", "\'", $var_search);
        $limit = 'LIMIT 0,10';

        if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by = '';

        $order_column = array('NUMERO_PLAQUE','COMMENTAIRE_TEXT','PHOTO_COMMANTAIRE','AVIS_PARTENAIRE','MOTIF', 'DATE_INSERTION','DATE_TRAITEMENT_PARTENAIRE');
        $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_INSERTION ASC';

        $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';


        $critaire = '';

        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' ;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

        $fetch_psr = $this->Modele->datatable($query_secondaire);
        $html="";
        $data = array();
        foreach ($fetch_psr as $row) {
            $sub_array=array();
            $sub_array[] = $row->NUMERO_PLAQUE?$row->NUMERO_PLAQUE:$row->NUMERO_PERMIS;
             $sub_array[]= "<a href='#'  title='" . $row->PHOTO_COMMANTAIRE . "' onclick='get_imag(this.title)' >".$row->COMMENTAIRE_TEXT."</a>";
            if (!empty($row->PHOTO_COMMANTAIRE)) {
            $sub_array[]= "<a href='#'  title='" . $row->PHOTO_COMMANTAIRE . "' onclick='get_imag(this.title)' ><img style='width:15px' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
        }
        else{
         $sub_array[]= "Aucun";

        }
         $sub_array[] = $row->AVIS_PARTENAIRE; 
         $sub_array[] = $row->MOTIF; 
         $sub_array[] = $row->DATE_INSERTION;
         $sub_array[] = $row->DATE_TRAITEMENT_PARTENAIRE; 
         $data[] = $sub_array;
        }
        $output = array(
           "draw" => intval($_POST['draw']),
           "recordsTotal" => $this->Modele->all_data($query_principal),
           "recordsFiltered" => $this->Modele->filtrer($query_filter),
           "data" => $data
         );
         echo json_encode($output);
 }
 //LES CONSTANTS VALIDE PAR LES PARTENAIRES
public function constant_valide()
{
         $typeVerification = $this->input->post('typeVerification');
         $DATE_UNE = $this->input->post('DATE_UNE');
         $DATE_DEUX = $this->input->post('DATE_DEUX');
         
        $criteres_date = "";
        if(!empty($DATE_UNE) && empty($DATE_DEUX)){
           $criteres_date = " and DATE_FORMAT(histo.DATE_INSERTION, '%Y-%m-%d')='" . $DATE_UNE."'";
           }
           if(empty($DATE_UNE) && !empty($DATE_DEUX)){
            $criteres_date = " and DATE_FORMAT(histo.DATE_INSERTION, '%Y-%m-%d')='" . $DATE_DEUX."'";
           }
          if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
          $criteres_date = " and DATE_FORMAT(histo.DATE_INSERTION, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";   
          }
         $critere_verification = !empty($typeVerification) ? "  AND tv.ID_TYPE_VERIFICATION=".$typeVerification." ":"";
          $query_principal = "SELECT hcv.STATUT_FIN_TRAITEMENT, hcv.ID_COMMENTAIRE_VERIFICATION,hcv.COMMENTAIRE,histo.ID_UTILISATEUR,u.NOM_UTILISATEUR,u.PRENOM_CITOYEN,u.PROFIL_ID, COUNT(hcv.ID_COMMENTAIRE_VERIFICATION) AS Nbre ,tv.VERIFICATION, tv.ID_TYPE_VERIFICATION,histo.ID_HISTORIQUE,histo.NUMERO_PERMIS,histo.NUMERO_PLAQUE,histo.DATE_INSERTION,histo.NUMERO_PERMIS FROM  historiques histo LEFT JOIN  historique_commentaire_verification  hcv ON hcv.ID_HISTORIQUE=histo.ID_HISTORIQUE LEFT JOIN  type_verification tv ON tv.ID_TYPE_VERIFICATION=hcv.ID_TYPE_VERIFICATION LEFT JOIN  historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=histo.ID_UTILISATEUR
          LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID
                WHERE hcv.STATUT_FIN_TRAITEMENT=1 AND  htc.ID_CONST_STATUT_TRAITE=3". $critere_verification."  " . $criteres_date."  AND hcc.HISTO_COMMENTAIRE_ID  IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat) GROUP BY  hcv.STATUT_FIN_TRAITEMENT, hcv.ID_COMMENTAIRE_VERIFICATION,hcv.COMMENTAIRE,histo.ID_UTILISATEUR,u.NOM_UTILISATEUR,u.PRENOM_CITOYEN,u.PROFIL_ID,tv.VERIFICATION, tv.ID_TYPE_VERIFICATION,histo.ID_HISTORIQUE,histo.NUMERO_PERMIS,histo.NUMERO_PLAQUE,histo.DATE_INSERTION,histo.NUMERO_PERMIS" ;

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
         $var_search=str_replace("'", "\'", $var_search);

        $limit = 'LIMIT 0,10';

        if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }

        $order_by = '';
         $order_column = array('NUMERO_PLAQUE','COMMENTAIRE','DATE_INSERTION','STATUT_FIN_TRAITEMENT','');
        $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';
        $critaire = '';
        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search ;
        // . ' ' . $order_by . '   ' ;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;
        $fetch_psr = $this->Modele->datatable($query_secondaire);
        $data = array();
        foreach ($fetch_psr as $row) {
      $all_valide = $this->Modele->getRequeteOne('SELECT COUNT(*) AS valide ,hcv.ID_COMMENTAIRE_VERIFICATION ,hcv.ID_TYPE_VERIFICATION FROM historique_commentaire_controls  hcc  LEFT JOIN historique_commentaire_verification hcv ON hcv.ID_COMMENTAIRE_VERIFICATION=hcc.ID_COMMENTAIRE_VERIFICATION WHERE hcc.POSISTION_NOW=0 AND hcv.ID_COMMENTAIRE_VERIFICATION='.$row->ID_COMMENTAIRE_VERIFICATION .' GROUP BY hcv.ID_COMMENTAIRE_VERIFICATION ,hcv.ID_TYPE_VERIFICATION');
         if($all_valide['valide']==0)
         {
       $sub_array = array();
       $sub_array[]='<input type="checkbox" onchange="one_check()" value="'.$row->ID_COMMENTAIRE_VERIFICATION.'" name="CONSTAT_ID" id="CONSTAT_ID" >';
       $sub_array[] = $row->NUMERO_PLAQUE?$row->NUMERO_PLAQUE:$row->NUMERO_PERMIS;
       $sub_array[] = "<a class='badge badge-primary'  id='".$row->NUMERO_PLAQUE."' title='".$row->DATE_INSERTION."' onclick='getDetail_transmis(".$row->ID_COMMENTAIRE_VERIFICATION.",".$row->ID_TYPE_VERIFICATION.",this.title, this.id)'  href='#'>".$row->Nbre. "</a>".$row->VERIFICATION ;
       $sub_array[] =$row->ID_TYPE_VERIFICATION!=2 ? $row->VERIFICATION:((!empty($this->get_assureur($row->ID_COMMENTAIRE_VERIFICATION))) ? $this->get_assureur($row->ID_COMMENTAIRE_VERIFICATION):'N/A');
       // $sub_array[] = $row->COMMENTAIRE;
       $all_valide = $this->Modele->getRequeteOne('SELECT COUNT(*) AS valide ,hcv.ID_COMMENTAIRE_VERIFICATION ,hcv.ID_TYPE_VERIFICATION FROM historique_commentaire_controls  hcc  LEFT JOIN historique_commentaire_verification hcv ON hcv.ID_COMMENTAIRE_VERIFICATION=hcc.ID_COMMENTAIRE_VERIFICATION WHERE hcc.POSISTION_NOW=0 AND hcv.ID_COMMENTAIRE_VERIFICATION='.$row->ID_COMMENTAIRE_VERIFICATION .' GROUP BY hcv.ID_COMMENTAIRE_VERIFICATION ,hcv.ID_TYPE_VERIFICATION');
       $sub_array[] = $row->STATUT_FIN_TRAITEMENT==0 ? "Encours":"Fin";
       // $sub_array[] = $row->NOM_UTILISATEUR;
       $sub_array[] = $row->DATE_INSERTION;
        $option ="";
        $all_valide = $this->Modele->getRequeteOne('SELECT COUNT(*) AS valide ,hcv.ID_COMMENTAIRE_VERIFICATION ,hcv.ID_TYPE_VERIFICATION FROM historique_commentaire_controls  hcc  LEFT JOIN historique_commentaire_verification hcv ON hcv.ID_COMMENTAIRE_VERIFICATION=hcc.ID_COMMENTAIRE_VERIFICATION WHERE hcc.POSISTION_NOW=1 AND hcv.ID_COMMENTAIRE_VERIFICATION='.$row->ID_COMMENTAIRE_VERIFICATION.' GROUP BY hcv.ID_COMMENTAIRE_VERIFICATION ,hcv.ID_TYPE_VERIFICATION');

            if($all_valide['valide']>0)
            {
              $option .= "<a class='btn btn-outline-primary' onclick='save_all(".$row->ID_COMMENTAIRE_VERIFICATION.")'><font >&nbsp;&nbsp;Valider </font></a>";
           }
           else
           {
            $option .= "<a class='btn btn-outline-primary' onclick='save_all(".$row->ID_COMMENTAIRE_VERIFICATION.")'><font color='red'>&nbsp;&nbsp;Rejetter </font></a>";
           }
     
      $sub_array[] = $option;
       $data[] = $sub_array;
      }
      }
        $output = array(
           "draw" => intval($_POST['draw']),
           "recordsTotal" => $this->Modele->all_data($query_principal),
           "recordsFiltered" => $this->Modele->filtrer($query_filter),
           "data" => $data
         );
         echo json_encode($output);
 }
public function constant_avis_parte()
 {
    $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');
    $criteres_signa = "";
      if(!empty($DATE_UNE) && empty($DATE_DEUX)){
         $criteres_signa = " and DATE_FORMAT(htc.DATE_TRAITEMENT_PARTENAIRE, '%Y-%m-%d')='" . $DATE_UNE."'";
         }
         if(empty($DATE_UNE) && !empty($DATE_DEUX)){
          $criteres_signa = " and DATE_FORMAT(htc.DATE_TRAITEMENT_PARTENAIRE, '%Y-%m-%d')='" . $DATE_DEUX."'";
         }
        if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
        $criteres_signa = " and DATE_FORMAT(htc.DATE_TRAITEMENT_PARTENAIRE, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";   
        }
    $query_principal= "SELECT h.NUMERO_PERMIS,h.DATE_INSERTION,hcap.AVIS_PARTENAIRE,htc.MOTIF,hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE  WHERE  htc.ID_CONST_STATUT_TRAITE=3 ".$criteres_signa ." AND a.ID_ASSUREUR=".$this->session->userdata('ID_INSTITUTION');

  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
  $var_search=str_replace("'", "\'", $var_search);

        $limit = 'LIMIT 0,10';

        if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }

        $order_by = '';

        $order_column = array('NUMERO_PLAQUE','COMMENTAIRE_TEXT','PHOTO_COMMANTAIRE','AVIS_PARTENAIRE','MOTIF', 'DATE_INSERTION','DATE_TRAITEMENT_PARTENAIRE');

        $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_INSERTION ASC';

        $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';


        $critaire = '';

        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' ;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

        $fetch_psr = $this->Modele->datatable($query_secondaire);
        $Avis=$this->Modele->getListOrder("histo_consta_avis_partenaire","AVIS_PARTENAIRE");

        $html="";
         $html.=" <select name='ID_AVIS_PARTENAIRE' id='ID_AVIS_PARTENAIRE'  class='form-control'>
                   <option value=''>Sélectionner un assureur</option>";
                    foreach ($Avis as $value) { 
                     $html.="<option selected='' value='".$value['ID_AVIS_PARTENAIRE']." '>".$value['AVIS_PARTENAIRE']."</option>";
                    }
                 $html.="</select>";
        $data = array();
        foreach ($fetch_psr as $row) {
            $sub_array=array();
            $sub_array[] = $row->NUMERO_PLAQUE?$row->NUMERO_PLAQUE:$row->NUMERO_PERMIS;
             $sub_array[]= "<a href='#'  title='" . $row->PHOTO_COMMANTAIRE . "' onclick='get_imag(this.title)' >".$row->COMMENTAIRE_TEXT."</a>";
            if (!empty($row->PHOTO_COMMANTAIRE)) {
         $sub_array[]= "<a href='#'  title='" . $row->PHOTO_COMMANTAIRE . "' onclick='get_imag(this.title)' ><img style='width:15px' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
        }

        else{
         $sub_array[]= "Aucun";

        }
        $sub_array[] = $row->AVIS_PARTENAIRE; 
         $sub_array[] = $row->MOTIF; 
        $sub_array[] = $row->DATE_INSERTION;
         $sub_array[] = $row->DATE_TRAITEMENT_PARTENAIRE; 
        
          
            $data[] = $sub_array;
        }
        $output = array(
           "draw" => intval($_POST['draw']),
           "recordsTotal" => $this->Modele->all_data($query_principal),
           "recordsFiltered" => $this->Modele->filtrer($query_filter),
           "data" => $data
         );
         echo json_encode($output);
 }
  public function constant()
 {
  
  $query_principal= "SELECT h.NUMERO_PERMIS,h.DATE_INSERTION,hcst.DESCRIPTION_STATUT,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR LEFT JOIN histo_const_statut_traitement hcst ON hcst.ID_CONST_STATUT_TRAITE=htc.ID_CONST_STATUT_TRAITE WHERE 1";

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search=str_replace("'", "\'", $var_search);
        $limit = 'LIMIT 0,10';

        if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }

        $order_by = '';

        $order_column = array('NUMERO_PLAQUE', 'DATE');

        $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_INSERTION ASC';

        $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';


        $critaire = '';

        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' ;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

        $fetch_psr = $this->Modele->datatable($query_secondaire);
        $data = array();
        foreach ($fetch_psr as $row) {
            $sub_array=array();
            $sub_array[] = $row->NUMERO_PLAQUE?$row->NUMERO_PLAQUE:$row->NUMERO_PERMIS;
            $sub_array[] = $row->VERIFICATION;
            if($row->ASSURANCE!=null)
            {
             $sub_array[] = $row->ASSURANCE;
            }
            else{
             $sub_array[] = $row->VERIFICATION;
            }
            $sub_array[] = $row->COMMENTAIRE_TEXT;
            $sub_array[] = $row->DESCRIPTION_STATUT;
            $sub_array[] = $row->DATE_INSERTION;
            $data[] = $sub_array;
        }
        $output = array(
           "draw" => intval($_POST['draw']),
           "recordsTotal" => $this->Modele->all_data($query_principal),
           "recordsFiltered" => $this->Modele->filtrer($query_filter),
           "data" => $data
         );
         echo json_encode($output);
 }
 //NOUVEAU CONSTANT
 public function constant_nouveau()
 {  
    $typeVerification = $this->input->post('typeVerification');
    $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX'); $criteres_date = "";
     $criteres_date = "";
        if(!empty($DATE_UNE) && empty($DATE_DEUX)){
           $criteres_date = " and DATE_FORMAT(hcv.DATE_CONSTAT, '%Y-%m-%d')='" . $DATE_UNE."'";
           }
           if(empty($DATE_UNE) && !empty($DATE_DEUX)){
            $criteres_date = " and DATE_FORMAT(hcv.DATE_CONSTAT, '%Y-%m-%d')='" . $DATE_DEUX."'";
           }
          if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
          $criteres_date = " and DATE_FORMAT(hcv.DATE_CONSTAT, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";   
          }
    $critere_verification = !empty($typeVerification) ? "  AND tv.ID_TYPE_VERIFICATION=".$typeVerification." ":"";
    $query_principal = "SELECT  hcv.ID_COMMENTAIRE_VERIFICATION,hcc.HISTO_COMMENTAIRE_ID,hcc.PHOTO_COMMANTAIRE,hc.COMMENTAIRE_TEXT,pa.LIEU_EXACTE,hcv.DATE_CONSTAT, hcv.ID_COMMENTAIRE_VERIFICATION,hcv.COMMENTAIRE,tv.VERIFICATION, tv.ID_TYPE_VERIFICATION ,histo.ID_HISTORIQUE,histo.NUMERO_PERMIS,histo.NUMERO_PLAQUE,histo.NUMERO_PERMIS FROM  historiques histo LEFT JOIN  historique_commentaire_verification  hcv ON hcv.ID_HISTORIQUE=histo.ID_HISTORIQUE LEFT JOIN  type_verification tv ON tv.ID_TYPE_VERIFICATION=hcv.ID_TYPE_VERIFICATION LEFT JOIN  historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=histo.ID_UTILISATEUR LEFT JOIN  psr_affectatations pa ON pa.PSR_AFFECTATION_ID=histo.PSR_AFFECTATION_ID LEFT JOIN historique_commentaire hc ON hc.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID
        WHERE hcv.STATUT_FIN_TRAITEMENT=0   AND  hcc.POSISTION_NOW=0". $critere_verification." ".$criteres_date." AND hcc. POSISTION_NOW=0 AND hcc.HISTO_COMMENTAIRE_ID NOT  IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat) " ;
     $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
     $var_search=str_replace("'", "\'", $var_search);
    $limit = 'LIMIT 0,10';
    if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }
    $order_by = '';
    $order_column = array('NUMERO_PLAQUE','ID_TYPE_VERIFICATION','LIEU_EXACTE','VERIFICATION','COMMENTAIRE_TEXT','DATE_CONSTAT','PHOTO_COMMANTAIRE','DATE_CONSTAT');
    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY  DATE_INSERTION DESC';
    $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';
    $critaire = '';
    $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;
    $fetch_psr = $this->Modele->datatable($query_secondaire);
    $data = array();
    foreach ($fetch_psr as $row) {
       $sub_array = array();
       $sub_array[] = $row->NUMERO_PLAQUE?$row->NUMERO_PLAQUE:$row->NUMERO_PERMIS;
       $sub_array[] = $this->get_concerne($row->ID_TYPE_VERIFICATION,$row->ID_HISTORIQUE);
       $sub_array[] =$row->LIEU_EXACTE;
       $sub_array[] =$row->VERIFICATION;
      $peines=$this->get_peines($row->ID_TYPE_VERIFICATION,$row->ID_HISTORIQUE);
      $long=strlen($peines);
        if($long<=35)
        {
            $sub_array[] = substr($peines,0,35);
        }
        else{
          $sub_array[] = "<a  hre='#' data-toggle='modal'
              data-target='#Peines" . $row->HISTO_COMMENTAIRE_ID . "'>".substr($peines,0,35)."..."."</a>";
        }
       
       $sub_array[] = $row->COMMENTAIRE_TEXT;
       if (!empty($row->PHOTO_COMMANTAIRE)) {
            $sub_array[]= "<a href='#'  title='" . $row->PHOTO_COMMANTAIRE . "' onclick='get_imag(this.title)' ><img style='width:15px' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
        }
        else{
            $sub_array[]= "Aucun";
        }
       $sub_array[] = $row->DATE_CONSTAT;
       $assurance="";
    $AssureurList=$this->Modele->getListOrder("assureur","ASSURANCE");
    $assurance.=" <select name='assureurIds' id='assureurIds".$row->HISTO_COMMENTAIRE_ID."' class='form-control'>
    <option value=''>Sélectionner </option>";
      foreach ($AssureurList as $value) { 
            $assurance.="<option value='".$value['ID_ASSUREUR']." '>".$value['ASSURANCE']."</option>";
      }
    $assurance.="</select>";
    
       $option='</div><div class="dropdown">
                       <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-cog"></i>
            Action<span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-menu-left">
              ';
                  if($row->ID_TYPE_VERIFICATION==2){
         $option .= "<li><a class='btn-md'  href='#' data-toggle='modal'
                     data-target='#myAssurance" . $row->HISTO_COMMENTAIRE_ID . "'><font >&nbsp;&nbsp;Envoyer au  partenaire</font></a></li>";
        }
        else{
           $option .= "<li><a class='btn-md' onclick='subForm(".$row->HISTO_COMMENTAIRE_ID.")'><font >&nbsp;&nbsp;Envoyer au  partenaire </font></a></li>";
        }
                   $option .= "
                     <li><a class='btn-md' onclick='supprimer(".$row->HISTO_COMMENTAIRE_ID.")'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
                     $option .= "
                     <li><a class='btn-md' onclick='maintenir_direct(".$row->HISTO_COMMENTAIRE_ID.",".$row->ID_HISTORIQUE.",".$row->ID_TYPE_VERIFICATION.")'><font >&nbsp;&nbsp;Aprouver directe </font></a></li>";
                  $option .= " </ul>
              </div>


            <div class='modal fade' id='myAssurance" .$row->HISTO_COMMENTAIRE_ID."'>
              <div class='modal-dialog'>
                <div class='modal-header' style='background: black;'>
                    <div id='title'>
                       <b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'>Choissir  l'assureur </h4></b>
                    </div>
                    <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
                       <span aria-hidden='true'>&times;</span>
                    </div>
                </div>
                <div class='modal-content'>
                    <div class='modal-body'>
                         <form id='myForm".$row->HISTO_COMMENTAIRE_ID."' action=".base_url('PSR/Commentaire/save') ." method='post' autocomplete='off'>
                                <label>Assureurs</label>
                                 ".$assurance."
                               <input type='hidden' value=".$row->ID_HISTORIQUE."  name='id_historique' id='id_historique' placeholder='Adresse'> 
                               <input type='hidden' value=".$row->ID_TYPE_VERIFICATION."  name='id_type_verification' id='id_type_verification' placeholder='Adresse'> 
                              <input type='hidden' value=".$row->ID_COMMENTAIRE_VERIFICATION."  name='commentaire_verification' id='commentaire_verification' placeholder='commentaire_verification'> 
                              <input type='hidden' value=".$row->HISTO_COMMENTAIRE_ID."  name='histo_commentaire_id' id='histo_commentaire_id' placeholder='Adresse'> 
                   </div>
                   <div class='modal-footer'>
                           <button type='button' onclick='subForm(".$row->HISTO_COMMENTAIRE_ID.")' class='btn btn-primary btn-md' >Envoyer</button> 
                          </form> 
                             <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
                   </div>
               </div>

            </div>
          </div>
          </div> 


          <div class='modal fade' id='Peines" .  $row->HISTO_COMMENTAIRE_ID . "'>
          <div class='modal-dialog'>
          <div class='modal-content'>
            <div class='modal-header' style='background: black;'>
            <div id='title'><b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'> Peines</h4>
            </div>
            <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </div>
         </div>
          <div class='modal-body'>
          ".$peines."
          </div>
          </div>
          </div>
          </div>";
        
        $sub_array[]= $option;
        $data[] = $sub_array;
    }
    $output = array(
      "draw" => intval($_POST['draw']),
      "recordsTotal" => $this->Modele->all_data($query_principal),
      "recordsFiltered" => $this->Modele->filtrer($query_filter),
      "data" => $data
    );
    echo json_encode($output);
 }
 public function constant_encours()
 {  
    $html="";
    $AssureurList=$this->Modele->getListOrder("assureur","ASSURANCE");
    $html.=" <select name='ID_ASSUREUR_ALL' id='ID_ASSUREUR_ALL' class='form-control'>
    <option value=''>Sélectionner un assureur </option>";
      foreach ($AssureurList as $value) { 
            $html.="<option value='".$value['ID_ASSUREUR']." '>".$value['ASSURANCE']."</option>";
      }
    $html.="</select>";

    $typeVerification = $this->input->post('typeVerification');
    $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');

    $criteres_date = "";
        if(!empty($DATE_UNE) && empty($DATE_DEUX)){
           $criteres_date = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d')='" . $DATE_UNE."'";
           }
           if(empty($DATE_UNE) && !empty($DATE_DEUX)){
            $criteres_date = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d')='" . $DATE_DEUX."'";
           }
          if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
          $criteres_date = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";   
          }
    $critere_verification = !empty($typeVerification) ? "  AND tv.ID_TYPE_VERIFICATION=".$typeVerification." ":"";
    $query_principal = "SELECT htc.DATE_TRAITEMENT_COP, hcv.ID_COMMENTAIRE_VERIFICATION,hcc.HISTO_COMMENTAIRE_ID,hcc.PHOTO_COMMANTAIRE,hc.COMMENTAIRE_TEXT,pa.LIEU_EXACTE,hcv.DATE_CONSTAT, hcv.ID_COMMENTAIRE_VERIFICATION,hcv.COMMENTAIRE,tv.VERIFICATION, tv.ID_TYPE_VERIFICATION ,histo.ID_HISTORIQUE,histo.NUMERO_PERMIS,histo.NUMERO_PLAQUE,histo.NUMERO_PERMIS FROM  historiques histo LEFT JOIN  historique_commentaire_verification  hcv ON hcv.ID_HISTORIQUE=histo.ID_HISTORIQUE LEFT JOIN  type_verification tv ON tv.ID_TYPE_VERIFICATION=hcv.ID_TYPE_VERIFICATION LEFT JOIN  historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=histo.ID_UTILISATEUR LEFT JOIN  psr_affectatations pa ON pa.PSR_AFFECTATION_ID=histo.PSR_AFFECTATION_ID LEFT JOIN historique_commentaire hc ON hc.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID 
    LEFT JOIN histo_traitement_constat htc ON htc.HISTO_COMMENTAIRE_ID=hcc.HISTO_COMMENTAIRE_ID
        WHERE htc.ID_CONST_STATUT_TRAITE=2 ". $critere_verification." ".$criteres_date." AND hcc. POSISTION_NOW=0 AND hcc.HISTO_COMMENTAIRE_ID  IN (SELECT HISTO_COMMENTAIRE_ID FROM histo_traitement_constat) " ;
     $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
     $var_search=str_replace("'", "\'", $var_search);
    $limit = 'LIMIT 0,10';
    if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }
    $order_by = '';
    $order_column = array('NUMERO_PLAQUE','ID_TYPE_VERIFICATION','LIEU_EXACTE','VERIFICATION','COMMENTAIRE_TEXT','COMMENTAIRE_TEXT','COMMENTAIRE_TEXT','PHOTO_COMMANTAIRE','DATE_TRAITEMENT_COP');
    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY  DATE_INSERTION DESC';
    $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';
    $critaire = '';
    $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;
    $fetch_psr = $this->Modele->datatable($query_secondaire);
    $data = array();
    foreach ($fetch_psr as $row) {
       $sub_array = array();
       $sub_array[] = $row->NUMERO_PLAQUE?$row->NUMERO_PLAQUE:$row->NUMERO_PERMIS;
       $sub_array[] = $this->get_concerne($row->ID_TYPE_VERIFICATION,$row->ID_HISTORIQUE);
       $sub_array[] =$row->LIEU_EXACTE;
       $sub_array[] =$row->VERIFICATION;
       $sub_array[] =$row->ID_TYPE_VERIFICATION!=2 ? $row->VERIFICATION:((!empty($this->get_assureur($row->ID_COMMENTAIRE_VERIFICATION))) ? $this->get_assureur($row->ID_COMMENTAIRE_VERIFICATION):'N/A');
       $peines=$this->get_peines($row->ID_TYPE_VERIFICATION,$row->ID_HISTORIQUE);
      $long=strlen($peines);
        if($long<=35)
        {
            $sub_array[] = substr($peines,0,35);
        }
        else{
          $sub_array[] = "<a  hre='#' data-toggle='modal'
              data-target='#Peinestrans" . $row->HISTO_COMMENTAIRE_ID . "'>".substr($peines,0,35)."..."."</a>
              <div class='modal fade' id='Peinestrans" .  $row->HISTO_COMMENTAIRE_ID . "'>
          <div class='modal-dialog'>
          <div class='modal-content'>
            <div class='modal-header' style='background: black;'>
            <div id='title'><b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'> Peines</h4>
            </div>
            <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </div>
         </div>
          <div class='modal-body'>".$peines."
          </div>
          </div>
          </div>
          </div>";
        }
       $sub_array[] = $row->COMMENTAIRE_TEXT;
       if (!empty($row->PHOTO_COMMANTAIRE)) {
            $sub_array[]= "<a href='#'  title='" . $row->PHOTO_COMMANTAIRE . "' onclick='get_imag(this.title)' ><img style='width:15px' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
        }
        else{
            $sub_array[]= "Aucun";
        }
        $sub_array[] = $row->DATE_TRAITEMENT_COP;
        $data[] = $sub_array;
    }
    $output = array(
      "draw" => intval($_POST['draw']),
      "recordsTotal" => $this->Modele->all_data($query_principal),
      "recordsFiltered" => $this->Modele->filtrer($query_filter),
      "data" => $data
    );
    echo json_encode($output);
 } 
//LES CONSTANTS MAINTIENTS
 public function constant_maintenir()
 {
  $typeVerification = $this->input->post('typeVerification');
    $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');
         
    $critere_verification = !empty($typeVerification) ? "  AND tv.ID_TYPE_VERIFICATION=".$typeVerification." ":"";
    
    $criteres_date = "";
        if(!empty($DATE_UNE) && empty($DATE_DEUX)){
           $criteres_date = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d')='" . $DATE_UNE."'";
           }
           if(empty($DATE_UNE) && !empty($DATE_DEUX)){
            $criteres_date = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d')='" . $DATE_DEUX."'";
           }
          if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
          $criteres_date = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";   
          }

    $query_principal= "SELECT tv.ID_TYPE_VERIFICATION,hcc.ID_COMMENTAIRE_VERIFICATION, hcap.AVIS_PARTENAIRE,h.NUMERO_PERMIS, h.DATE_INSERTION,hcst.DESCRIPTION_STATUT,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
      LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR LEFT JOIN histo_const_statut_traitement hcst ON hcst.ID_CONST_STATUT_TRAITE=htc.ID_CONST_STATUT_TRAITE LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE WHERE hcst.ID_CONST_STATUT_TRAITE=5 ".$critere_verification." ".$criteres_date;

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search=str_replace("'", "\'", $var_search);
        $limit = 'LIMIT 0,10';

        if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }

        $order_by = '';

        $order_column = array('NUMERO_PLAQUE','VERIFICATION','VERIFICATION','ASSURANCE','COMMENTAIRE_TEXT','DESCRIPTION_STATUT','AVIS_PARTENAIRE','MOTIF','DATE_TRAITEMENT_COP');

        $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_TRAITEMENT_COP DESC';

        $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';


        $critaire = '';

        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' ;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

        $fetch_psr = $this->Modele->datatable($query_secondaire);
        $data = array();
        foreach ($fetch_psr as $row) {
            $sub_array=array();
            $sub_array[] = $row->NUMERO_PLAQUE?$row->NUMERO_PLAQUE:$row->NUMERO_PERMIS;
            $sub_array[] =$row->VERIFICATION;
            $sub_array[] =$row->ID_TYPE_VERIFICATION!=2 ? $row->VERIFICATION:((!empty($this->get_assureur($row->ID_COMMENTAIRE_VERIFICATION))) ? $this->get_assureur($row->ID_COMMENTAIRE_VERIFICATION):'N/A');
            $sub_array[] = $row->COMMENTAIRE_TEXT;
            $sub_array[] = $row->AVIS_PARTENAIRE;
            $sub_array[] = $row->MOTIF;
            $sub_array[] = $row->DESCRIPTION_STATUT;
            $sub_array[] = $row->DATE_TRAITEMENT_COP;
            $data[] = $sub_array;
        }
        $output = array(
           "draw" => intval($_POST['draw']),
           "recordsTotal" => $this->Modele->all_data($query_principal),
           "recordsFiltered" => $this->Modele->filtrer($query_filter),
           "data" => $data
         );
         echo json_encode($output);
 }
//LES CONSTANT REJETTER
 public function constant_annuler()
 {
   $typeVerification = $this->input->post('typeVerification');
    $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');
    $criteres_date = "";
        if(!empty($DATE_UNE) && empty($DATE_DEUX)){
           $criteres_date = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d')='" . $DATE_UNE."'";
           }
           if(empty($DATE_UNE) && !empty($DATE_DEUX)){
            $criteres_date = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d')='" . $DATE_DEUX."'";
           }
          if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
          $criteres_date = " and DATE_FORMAT(htc.DATE_TRAITEMENT_COP, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";   
          }
         
    $critere_verification = !empty($typeVerification) ? "  AND tv.ID_TYPE_VERIFICATION=".$typeVerification." ":"";
    $query_principal= "SELECT  hcv.ID_COMMENTAIRE_VERIFICATION,tv.ID_TYPE_VERIFICATION,h.NUMERO_PERMIS,  hcap.AVIS_PARTENAIRE, h.DATE_INSERTION,hcst.DESCRIPTION_STATUT,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
      LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR LEFT JOIN histo_const_statut_traitement hcst ON hcst.ID_CONST_STATUT_TRAITE=htc.ID_CONST_STATUT_TRAITE LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE LEFT JOIN historique_commentaire_verification hcv ON hcv.ID_COMMENTAIRE_VERIFICATION=hcc.ID_COMMENTAIRE_VERIFICATION WHERE hcst.ID_CONST_STATUT_TRAITE=4".$critere_verification." ".$criteres_date;

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search=str_replace("'", "\'", $var_search);
        $limit = 'LIMIT 0,10';

        if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }

        $order_by = '';

        $order_column = array('NUMERO_PLAQUE','VERIFICATION','VERIFICATION','ASSURANCE','COMMENTAIRE_TEXT','DESCRIPTION_STATUT','DATE_TRAITEMENT_COP','AVIS_PARTENAIRE','MOTIF');

        $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_TRAITEMENT_COP DESC';

        $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';
        $critaire = '';
        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' ;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;
        $fetch_psr = $this->Modele->datatable($query_secondaire);
        $data = array();
        foreach ($fetch_psr as $row) {
            $sub_array=array();
           $sub_array[] = $row->NUMERO_PLAQUE?$row->NUMERO_PLAQUE:$row->NUMERO_PERMIS;
            $sub_array[] = $row->VERIFICATION;
            $sub_array[] =$row->ID_TYPE_VERIFICATION!=2 ? $row->VERIFICATION:((!empty($this->get_assureur($row->ID_COMMENTAIRE_VERIFICATION))) ? $row->ASSURANCE:'N/A');
            $sub_array[] = $row->COMMENTAIRE_TEXT;
            $sub_array[] = $row->AVIS_PARTENAIRE;
            $sub_array[] = $row->MOTIF;
            $sub_array[] = $row->DESCRIPTION_STATUT;
            $sub_array[] = $row->DATE_TRAITEMENT_PARTENAIRE;
            $data[] = $sub_array;
        }
        $output = array(
           "draw" => intval($_POST['draw']),
           "recordsTotal" => $this->Modele->all_data($query_principal),
           "recordsFiltered" => $this->Modele->filtrer($query_filter),
           "data" => $data
         );
         echo json_encode($output);
 }
   //REJETTER LES AMANDES
public function annuler_all($id,$id2)
 {
  $Montant = $this->Modele->getRequeteOne('SELECT MONTANT, IMMATRICULATION_PEINE_MONTANT, ASSURANCE_PEINE_MONTANT,  CONTROLE_TECHNIQUE_PEINE_MONTANT,TRANSPORT_PEINE_MONTANT,VOL_PEINE_MONTANT,PERMIS_PEINE_MONTANT,MONTANT_TOTAL FROM historiques WHERE ID_HISTORIQUE='.$id);
   $Avis = array();
    
  $date =date('Y-m-d:H-i');

  if($id2==1)  
  { //TYPE DE VERIFICATION OBR
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array('IS_ANNULE_OBR'=>1,'MONTANT_TOTAL'=>$Montant['MONTANT']-$Montant['IMMATRICULATION_PEINE_MONTANT']));
  }   
  else if($id2==2)  
  { //TYPE DE VERIFICATION ASSURANCE
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array('IS_ANNULE_ASSURANCE'=>1,'MONTANT_TOTAL'=>$Montant['MONTANT']-$Montant['ASSURANCE_PEINE_MONTANT']));
  } 
  else if($id2==3)  
  {
     //TYPE DE VERIFICATION OTRACO
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array('IS_ANNULE_CONTROL_TECH'=>1,'MONTANT'=>$Montant['MONTANT']-$Montant['CONTROLE_TECHNIQUE_PEINE_MONTANT']));
     
  }  
  else if($id2==4)  
  { //TYPE DE VERIFICATION PJ
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array('IS_ANNULE_PJ'=>1,'MONTANT'=>$Montant['MONTANT']-$Montant['VOL_PEINE_MONTANT']));
  } 
  else if($id2==6)  
  {
  //TYPE DE VERIFICATION PSR
  $amandes=$Montant['PERMIS_PEINE_MONTANT'];
  $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array('IS_ANNULE_PERMIS'=>1,'MONTANT'=>$Montant['MONTANT']-$Montant['PERMIS_PEINE_MONTANT']));
  } 
  else if($id2==7)  
  {
     //TYPE DE VERIFICATION PARKING
  } 
  else if($id2==8)  
  {
     //TYPE DE VERIFICATION TRANSPORT
     // $amandes=$Montant['PERMIS_PEINE_MONTANT'];
 
  } 
 $this->Modele->update('histo_traitement_constat', array('ID_HISTORIQUE'=>$id,'ID_TYPE_VERIFICATION'=>$id2),array('ID_CONST_STATUT_TRAITE'=>5,'DATE_TRAITEMENT_COP'=>$date));
 $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id ),array('ID_HISTORIQUE_STATUT'=>6)
       );
        $data['sms']='<div class="alert alert-success text-center" id ="sms">Opération faite avec succes.</div>';
  $this->session->set_flashdata($data);
  print_r(json_encode(1));
  // }

 }
 public function supprimer($id)
 {
   $this->Modele->delete('historique_commentaire_controls', array('HISTO_COMMENTAIRE_ID'=>$id));
         print_r(json_encode(1));

 }
public function maintenir($id,$id2,$id_commentaire,$numero_plaque,$numero_permis)
 {
        $date =date('Y-m-d:H-i');
       //  $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array(' ID_HISTORIQUE_STATUT'=>3)
       // );
         $this->Modele->update('histo_traitement_constat', array('ID_HISTORIQUE'=>$id,'ID_TYPE_VERIFICATION'=>$id2,),array('ID_CONST_STATUT_TRAITE'=>4,'DATE_TRAITEMENT_COP'=>$date)
       );
$this->sendNotifactions($id,$id_commentaire,$numero_plaque,$numero_permis);
        $data['sms']='<div class="alert alert-success text-center" id ="sms">Opération faite avec succes.</div>';
  $this->session->set_flashdata($data);
    print_r(json_encode(1));
 }
public function save_alls()
{
    $ID_COMMENTAIRE_VERIFICATION =  $this->input->post('ID_COMMENTAIRE_VERIFICATION');
     foreach ($ID_COMMENTAIRE_VERIFICATION as $key => $value) {
        $historique = $this->Modele->getRequeteOne('SELECT h.ID_HISTORIQUE,hcv.ID_TYPE_VERIFICATION,h.NUMERO_PLAQUE,h.NUMERO_PERMIS FROM historique_commentaire_verification hcv LEFT JOIN historiques h ON h.ID_HISTORIQUE=hcv.ID_HISTORIQUE WHERE  ID_COMMENTAIRE_VERIFICATION='.$value);
        $all_valide = $this->Modele->getRequeteOne('SELECT COUNT(*) AS valide ,hcv.ID_COMMENTAIRE_VERIFICATION ,hcv.ID_TYPE_VERIFICATION FROM historique_commentaire_controls  hcc  LEFT JOIN historique_commentaire_verification hcv ON hcv.ID_COMMENTAIRE_VERIFICATION=hcc.ID_COMMENTAIRE_VERIFICATION WHERE hcc.POSISTION_NOW=1 AND hcv.ID_COMMENTAIRE_VERIFICATION='.$value.' GROUP BY hcv.ID_COMMENTAIRE_VERIFICATION ,hcv.ID_TYPE_VERIFICATION');

            if($all_valide['valide']>0)
            {
              
              $this->maintenir($historique['ID_HISTORIQUE'],$historique['ID_TYPE_VERIFICATION'],$value,$historique['NUMERO_PLAQUE'],$historique['NUMERO_PERMIS']);
           }
           else
           {
            $this->annuler_all($historique['ID_HISTORIQUE'],$historique['ID_TYPE_VERIFICATION']);
           }
      }
}
function sendNotifactions($id_historique,$id_commentaire,$numero_plaque,$numero_permis){
           if (!empty($numero_plaque)) 
           {
            $tokens = $this->Model->getRequete('SELECT h.NUMERO_PERMIS,h.CODE_REFERENCE,h.DATE_INSERTION,hcv.ID_TYPE_VERIFICATION,h.MONTANT,h.IMMATRICULATION_PEINE_MONTANT, h.ASSURANCE_PEINE_MONTANT,  h.CONTROLE_TECHNIQUE_PEINE_MONTANT,h.TRANSPORT_PEINE_MONTANT,h.VOL_PEINE_MONTANT,h.PERMIS_PEINE_MONTANT,h.MONTANT_TOTAL,h.DATE_INSERTION,pa.LIEU_EXACTE,u.ID_UTILISATEUR,n.TOKEN,u.PRENOM_CITOYEN,u.NOM_CITOYEN,u.NUMERO_CITOYEN,uc.NUMERO_PLAQUE FROM notification_tokens n JOIN utilisateurs u on n.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN utilisateur_vehicule  uc ON uc.ID_UTILISATEUR=u.ID_UTILISATEUR LEFT JOIN historiques h ON h.NUMERO_PLAQUE=uc.NUMERO_PLAQUE LEFT JOIN historique_commentaire_verification hcv ON hcv.ID_HISTORIQUE=h.ID_HISTORIQUE LEFT JOIN   psr_affectatations  pa ON pa.PSR_AFFECTATION_ID=h.PSR_AFFECTATION_ID  WHERE hcv.ID_COMMENTAIRE_VERIFICATION='.$id_commentaire.' AND h.ID_HISTORIQUE='.$id_historique);
               if (!empty($tokens)) {
                
                $tokesss = array();
                $amandes=0;
                $nom = "";
                foreach ($tokens as $key => $value) {

                  $tokns = array();
                  $tokns['TOKEN'] = $value['TOKEN'];
                  $tokns['TO_ID_UTILISATEU'] = $value['ID_UTILISATEUR'];

                  $phoneNumber = str_replace(' ','',$value['NUMERO_CITOYEN']);

                  $nom =  str_replace(' ','',$value['NOM_CITOYEN']).' '.str_replace(' ','',$value['PRENOM_CITOYEN']).' N° '.str_replace(' ','',$value['NUMERO_PLAQUE'])."";
                  $tokesss[] = $tokns;
                  
                  }
                  

                  $titre =  "Controle routiere :".$value['NUMERO_PLAQUE'];

                  // $temps = $this->notifications->ago($value['DATE_DEBUT'],$value['DATE_FIN']);
                  $messageVehicule = " Controle routier de votre véhicule : ".$value['NUMERO_PLAQUE']." , ".$value['DATE_INSERTION']." à ".$value['LIEU_EXACTE'].".  Amandes à payer : ".$value['MONTANT']."Fbu . Code du controle:".$value['CODE_REFERENCE']. "   Merci";
                  $donnes = array(
                   'TITRE'=>$titre,
                   'CONTENU'=>$messageVehicule,
                   'tokens'=> $tokesss
                  );
                  $this->notifications->notificationApk($donnes);
                  
                  $data = array(
                    'USER_ID'=>$this->session->userdata('USER_ID'),
                    'MESSAGE'=> $messageVehicule,
                    'TELEPHONE'=>$value['NUMERO_CITOYEN'],
                    'NUMERO_PLAQUE'=>$value['NUMERO_PLAQUE'],
                    'IS_AGENT_PSR'=>1,
                    'STATUT'=>1,
                    'ID_PSR_ELEMENT'=>$this->session->userdata('PSR_ELEMENT')

                  );

                  // //$this->notifications->send_sms_smpp($phoneNumber, $messageAgent);
                  $test = $this->Model->create('notifications',$data);
                  
              }
         }
         if (!empty($numero_permis)) 
           {
            $tokens = $this->Model->getRequete('SELECT h.NUMERO_PERMIS,h.CODE_REFERENCE,h.DATE_INSERTION,h.MONTANT,pa.LIEU_EXACTE,u.ID_UTILISATEUR,n.TOKEN ,u.PRENOM_CITOYEN,u.NOM_CITOYEN,u.NUMERO_CITOYEN FROM notification_tokens n JOIN utilisateurs u on n.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN utilisateur_permis  up ON up.ID_UTILISATEUR=u.ID_UTILISATEUR LEFT JOIN historiques h ON h.NUMERO_PERMIS=up.NUMERO_PERMIS LEFT JOIN historique_commentaire_verification hcv ON hcv.ID_HISTORIQUE=h.ID_HISTORIQUE LEFT JOIN   psr_affectatations  pa ON pa.PSR_AFFECTATION_ID=h.PSR_AFFECTATION_ID  WHERE hcv.ID_COMMENTAIRE_VERIFICATION='.$id_commentaire.' AND h.ID_HISTORIQUE='.$id_historique);
               if (!empty($tokens)) {
                
                $tokesss = array();
                $amandes=0;
                $nom = "";
                foreach ($tokens as $key => $value) {

                  $tokns = array();
                  $tokns['TOKEN'] = $value['TOKEN'];
                  $tokns['TO_ID_UTILISATEUR'] = $value['ID_UTILISATEUR'];

                  $phoneNumber = str_replace(' ','',$value['NUMERO_CITOYEN']);
                  $nom =  str_replace(' ','',$value['NOM_CITOYEN']).' '.str_replace(' ','',$value['PRENOM_CITOYEN']).' N° '.str_replace(' ','',$value['NUMERO_PERMIS'])."";
                  $tokesss[] = $tokns;
                  }
                  $titre =  "Controle routiere  :".$value['NUMERO_PERMIS'];
                  // $temps = $this->notifications->ago($value['DATE_DEBUT'],$value['DATE_FIN']);
                  $messagePermis = " Controle routier de votre permis de conduire : ".$value['NUMERO_PERMIS']." , ".$value['DATE_INSERTION']." à ".$value['LIEU_EXACTE'].".  Amandes à payer : ".$value['MONTANT']."Fbu . Code du controle:".$value['CODE_REFERENCE']. "   Merci";
                  $donnes = array(
                   'TITRE'=>$titre,
                   'CONTENU'=>$messagePermis,
                   'tokens'=> $tokesss
                  );
                  $this->notifications->notificationApk($donnes);
                  
                  $data = array(
                    'USER_ID'=>$this->session->userdata('USER_ID'),
                    'MESSAGE'=> $messagePermis,
                    'TELEPHONE'=>$value['NUMERO_CITOYEN'],
                    'NUMERO_PLAQUE'=>$value['NUMERO_PERMIS'],
                    'IS_AGENT_PSR'=>1,
                    'STATUT'=>1,
                    'ID_PSR_ELEMENT'=>$this->session->userdata('PSR_ELEMENT')
                  );
                  // //$this->notifications->send_sms_smpp($phoneNumber, $messageAgent);
                  $test = $this->Model->create('notifications',$data);
              }
         }

    }


}



?>