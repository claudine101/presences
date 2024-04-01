<?php
class Validation_signalement extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		// $this->have_droit();
	}
	public function have_droit()
   {
    if ($this->session->userdata('SIGNALEMENT') != 1 )  {
     redirect(base_url());
    }
   }
	 function index()     
	 {
    $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');
    $criteres_signa = "";
     $id_utilisateur = $this->session->userdata('USER_ID');
     $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);
     if($profil['PROFIL_ID']==17 || $profil['PROFIL_ID']==1)
     {
       $Nbre_nouveau = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM  signalement_civil_agent_new  WHERE ID_ALERT_STATUT=1');

        $Nbre_valide = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM signalement_civil_agent_histo_traitement  WHERE STATUT_ID=2 AND ID_UTILISATEUR='.$id_utilisateur);

       $Nbre_rejette = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM signalement_civil_agent_histo_traitement WHERE STATUT_ID=5 AND ID_UTILISATEUR='.$id_utilisateur);
      
     
      $data['Nbre_nouveau']=$Nbre_nouveau['Nombre'];
      $data['Nbre_valide']=$Nbre_valide['Nombre'];
      $data['Nbre_rejette']=$Nbre_rejette['Nombre'];
      

      
     }
     else if($profil['PROFIL_ID']==18)
     {
      $Nbre_nouveau = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM  signalement_civil_agent_new  WHERE ID_ALERT_STATUT=2');

        $Nbre_valide = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM signalement_civil_agent_histo_traitement  WHERE STATUT_ID=3 AND ID_UTILISATEUR='.$id_utilisateur);

       $Nbre_rejette = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM signalement_civil_agent_histo_traitement WHERE STATUT_ID=5 AND ID_UTILISATEUR='.$id_utilisateur);

      $data['Nbre_nouveau']=$Nbre_nouveau['Nombre'];
      $data['Nbre_valide']=$Nbre_valide['Nombre'];
      $data['Nbre_rejette']=$Nbre_rejette['Nombre'];
      
     }
     else if($profil['PROFIL_ID']==19)
     {
        $Nbre_nouveau = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM  signalement_civil_agent_new  WHERE ID_ALERT_STATUT=3');

        $Nbre_valide = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM signalement_civil_agent_histo_traitement  WHERE STATUT_ID=4 AND ID_UTILISATEUR='.$id_utilisateur);

       $Nbre_rejette = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM signalement_civil_agent_histo_traitement WHERE STATUT_ID=5 AND ID_UTILISATEUR='.$id_utilisateur);

      $data['Nbre_nouveau']=$Nbre_nouveau['Nombre'];
      $data['Nbre_valide']=$Nbre_valide['Nombre'];
      $data['Nbre_rejette']=$Nbre_rejette['Nombre'];
      
     }
      $data['DATE_UNE'] = $DATE_UNE;  
      $data['DATE_DEUX'] = $DATE_DEUX;
        $avisList = $this->Model->getRequete('SELECT * FROM signalement_avis_traitement WHERE 1');
        $select="";
        $select.=" <select name='signalement_avis_valider' id='signalement_avis_valider' class='form-control'>
                   <option value=''>Sélectionner</option>";
                    foreach ($avisList as $val) { 
                      $select.="<option  value='".$val['ID_AVIS_SIGNALEMENT']." '>".$val['AVIS']."</option>";
                    }
      $select.="</select>";
      $avisRejetter = $this->Model->getRequete('SELECT * FROM signalement_avis_traitement_rejetter WHERE 1');
        $selectRejetter="";
        $selectRejetter.=" <select  name='signalement_avis_rejetter' id='signalement_avis_rejetter' class='form-control' required>
                   <option value=''>Sélectionner</option>";
                    foreach ($avisRejetter as $vale) { 
               $selectRejetter.="<option  value='".$vale['ID_AVIS_SIGNALEMENT_REJETTER']." '>".$vale['AVIS']."</option>";
                    }
                 $selectRejetter.="</select>";

      $data['selectAvisValide'] =  $select;
      $data['selectAvisRejetter'] = $selectRejetter;
	    $data['title'] = 'Signalement';
      $categories = $this->Modele->getRequete('SELECT * FROM civil_alerts_types');
      $data['categories'] = $categories;
	    $this->load->view('validation/Validation_List_View', $data);
	 }
   public function rejette_alls()
   {
     $ID_SIGNALEMENT_NEW =  $this->input->post('ID_SIGNALEMENT_NEW');
     $SIGNALEMENT_AVIS_REJETTER=$this->input->post('SIGNALEMENT_AVIS_REJETTER');

     foreach ($ID_SIGNALEMENT_NEW as $key => $value) {
      $this->rejette_all($value,$SIGNALEMENT_AVIS_REJETTER);

     }
     echo json_encode(array('message'=>'Confirmé'));
   }
   public function save_alls()
   {
     $ID_SIGNALEMENT_NEW =  $this->input->post('ID_SIGNALEMENT_NEW');
     $SIGNALEMENT_AVIS_VALIDER=$this->input->post('SIGNALEMENT_AVIS_VALIDER');
     foreach ($ID_SIGNALEMENT_NEW as $key => $value) {
      $this->save_all($value,$SIGNALEMENT_AVIS_VALIDER);
     }
     echo json_encode(array('message'=>'Confirmé'));
   }
   public function rejette($id)
   {
    $date =date('Y-m-d:H-i');
    $id_utilisateur = $this->session->userdata('USER_ID');
    $id_avis_signalement =$this->input->post('signalement_avis_rej');
    $data = array('ID_SIGNALEMENT_NEW' =>$id ,
                      'STATUT_ID' =>5,
                      'ID_AVIS_SIGNALEMENT' =>$id_avis_signalement,
                      'ID_UTILISATEUR' =>$id_utilisateur,
                      'DATE_TRAITEMENT'=>$date
                     );
        
    $this->Modele->create('signalement_civil_agent_histo_traitement',$data);
    $this->Modele->update('signalement_civil_agent_new', array('ID_SIGNALEMENT_NEW'=>$id ),array('ID_ALERT_STATUT'=>5));
  redirect(base_url('PSR/Validation_signalement/'));

   }
   public function rejette_all($id, $id_avis_signalement)
   {
    $date =date('Y-m-d:H-i');
    $id_utilisateur = $this->session->userdata('USER_ID');
     $data = array('ID_SIGNALEMENT_NEW' =>$id ,
                      'STATUT_ID' =>5,
                      'ID_AVIS_SIGNALEMENT' =>$id_avis_signalement,
                      'ID_UTILISATEUR' =>$id_utilisateur,
                      'DATE_TRAITEMENT'=>$date
                     );
        
    $this->Modele->create('signalement_civil_agent_histo_traitement',$data);
     $this->Modele->update('signalement_civil_agent_new', array('ID_SIGNALEMENT_NEW'=>$id ),array('ID_ALERT_STATUT'=>5));
      $donne=array('message'=>'Confirmé');
    return $donne ;
   }
  
	  public function save($id)
    {
        $date =date('Y-m-d:H-i');
        $id_utilisateur = $this->session->userdata('USER_ID');
        $id_avis_signalement =$this->input->post('signalement_avis');

        $this->form_validation->set_rules('signalement_avis', '', 'trim|required', array('required' => '<font style="color:red;size:2px;"></font>'));
      if ($this->form_validation->run() == FALSE) {
            $data['sms']='<div class="alert alert-success text-center" id ="sms">Avis est Obligatoire.</div>';
            $this->session->set_flashdata($data);
          redirect(base_url('PSR/Validation_signalement/'));
    } 
    else {
        $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);

          if($profil['PROFIL_ID']==17 || $profil['PROFIL_ID']==1)
          {
              $data = array('ID_SIGNALEMENT_NEW' =>$id ,
                      'STATUT_ID' =>2,
                      'ID_AVIS_SIGNALEMENT' =>$id_avis_signalement,
                      'ID_UTILISATEUR' =>$id_utilisateur,
                      'DATE_TRAITEMENT'=>$date
                     );
                $this->Modele->create('signalement_civil_agent_histo_traitement',$data);

               $this->Modele->update('signalement_civil_agent_new', array('ID_SIGNALEMENT_NEW'=>$id ),array('ID_ALERT_STATUT'=>2));
          }
          else if($profil['PROFIL_ID']==18)
          {
               $data = array('ID_SIGNALEMENT_NEW' =>$id ,
                      'STATUT_ID' =>3,
                      'ID_AVIS_SIGNALEMENT' =>$id_avis_signalement,
                      'ID_UTILISATEUR' =>$id_utilisateur,
                      'DATE_TRAITEMENT'=>$date
                     );
        
                $this->Modele->create('signalement_civil_agent_histo_traitement',$data);
               $this->Modele->update('signalement_civil_agent_new', array('ID_SIGNALEMENT_NEW'=>$id ),array('ID_ALERT_STATUT'=>3));
          }
          else if($profil['PROFIL_ID']==19)
         {
            $data = array('ID_SIGNALEMENT_NEW' =>$id ,
                      'STATUT_ID' =>4,
                      'ID_AVIS_SIGNALEMENT' =>$id_avis_signalement,
                      'ID_UTILISATEUR' =>$id_utilisateur,
                      'DATE_TRAITEMENT'=>$date
                     );
        
                $this->Modele->create('signalement_civil_agent_histo_traitement',$data);
               $this->Modele->update('signalement_civil_agent_new', array('ID_SIGNALEMENT_NEW'=>$id ),array('ID_ALERT_STATUT'=>4));
         }

        $data['sms']='<div class="alert alert-success text-center" id ="sms">Opération faite avec succes.</div>';
     $this->session->set_flashdata($data);
    redirect(base_url('PSR/Validation_signalement/'));

   }
 }
 public function save_all($id,$id_avis_signalement)
    {
        $date =date('Y-m-d:H-i');
        $id_utilisateur = $this->session->userdata('USER_ID');
        $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);

          if($profil['PROFIL_ID']==17 || $profil['PROFIL_ID']==1)
          {
              $data = array('ID_SIGNALEMENT_NEW' =>$id ,
                      'STATUT_ID' =>2,
                      'ID_AVIS_SIGNALEMENT' =>$id_avis_signalement,
                      'ID_UTILISATEUR' =>$id_utilisateur,
                      'DATE_TRAITEMENT'=>$date
                     );
                $this->Modele->create('signalement_civil_agent_histo_traitement',$data);

               $this->Modele->update('signalement_civil_agent_new', array('ID_SIGNALEMENT_NEW'=>$id ),array('ID_ALERT_STATUT'=>2));
          }
          else if($profil['PROFIL_ID']==18)
          {
               $data = array('ID_SIGNALEMENT_NEW' =>$id ,
                      'STATUT_ID' =>3,
                      'ID_AVIS_SIGNALEMENT' =>$id_avis_signalement,
                      'ID_UTILISATEUR' =>$id_utilisateur,
                      'DATE_TRAITEMENT'=>$date
                     );
        
                $this->Modele->create('signalement_civil_agent_histo_traitement',$data);
               $this->Modele->update('signalement_civil_agent_new', array('ID_SIGNALEMENT_NEW'=>$id ),array('ID_ALERT_STATUT'=>3));
          }
          else if($profil['PROFIL_ID']==19)
         {
            $data = array('ID_SIGNALEMENT_NEW' =>$id ,
                      'STATUT_ID' =>4,
                      'ID_AVIS_SIGNALEMENT' =>$id_avis_signalement,
                      'ID_UTILISATEUR' =>$id_utilisateur,
                      'DATE_TRAITEMENT'=>$date
                     );
        
                $this->Modele->create('signalement_civil_agent_histo_traitement',$data);
               $this->Modele->update('signalement_civil_agent_new', array('ID_SIGNALEMENT_NEW'=>$id ),array('ID_ALERT_STATUT'=>4));
         }

        $data['sms']='<div class="alert alert-success text-center" id ="sms">Opération faite avec succes.</div>';
     $this->session->set_flashdata($data);
    $donne=array('message'=>'Confirmé');
    return $donne ;
 }
function listing_valide()
{
    $id=$this->session->userdata('USER_ID');
    $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');
    $TYPE = $this->input->post('TYPE');

    $criteres_signa = "";
    $criteres_type = "";
    if(!empty($TYPE) ){
     $criteres_type = " AND  cat.ID_TYPE=".$TYPE;
    }
      if(!empty($DATE_UNE) && empty($DATE_DEUX)){

          $criteres_signa = " and DATE_FORMAT(scan.DATE_SIGNAL, '%Y-%m-%d')='" . $DATE_UNE."'";

         }
         if(empty($DATE_UNE) && !empty($DATE_DEUX)){

          $criteres_signa = " and DATE_FORMAT(scan.DATE_SIGNAL, '%Y-%m-%d')='" . $DATE_DEUX."'";

         }
        if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
        $criteres_signa = " and DATE_FORMAT(scan.DATE_SIGNAL, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";
            
        }
  $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id);
   if($profil['PROFIL_ID']==17 || $profil['PROFIL_ID']==1)
  {
  $query_principal = "SELECT scan.PLAQUE_NUMERO,scan.DESCRIPTION_PLAQUE,scan.COMMENTAIRE,scan.DATE_SIGNAL,scan.ID_AUTRE_CONTROL,scan.ID_SIGNALEMENT_NEW,cas.NOM AS STATUT, cat.DESCRIPTION,pe.PHOTO, u.NOM_CITOYEN,u.PRENOM_CITOYEN ,pe.NOM,pe.PRENOM,scan.IMAGE_UNE,scan.IMAGE_DEUX,scan.IMAGE_TROIS,scan.DATE_SIGNAL  FROM signalement_civil_agent_new scan LEFT JOIN signalement_civil_agent_histo_traitement uu  ON uu.ID_SIGNALEMENT_NEW=scan.ID_SIGNALEMENT_NEW LEFT JOIN utilisateurs u  ON u.ID_UTILISATEUR=scan.ID_UTILISATEUR LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID  LEFT JOIN civil_alerts_types cat ON cat.ID_TYPE=scan.ID_CATEGORIE_SIGNALEMENT  LEFT JOIN civil_alerts_statuts cas ON cas.ID_ALERT_STATUT=scan.ID_ALERT_STATUT
            WHERE   uu.STATUT_ID=2 AND  uu.ID_UTILISATEUR=".$id." ".$criteres_signa ." ".$criteres_type;
}
else if($profil['PROFIL_ID']==18)
{
  $query_principal = "SELECT scan.DATE_SIGNAL,scan.ID_AUTRE_CONTROL,scan.ID_SIGNALEMENT_NEW,cas.NOM AS STATUT, cat.DESCRIPTION,pe.PHOTO, u.NOM_CITOYEN,u.PRENOM_CITOYEN ,pe.NOM,pe.PRENOM,scan.IMAGE_UNE,scan.IMAGE_DEUX,scan.IMAGE_TROIS,scan.DATE_SIGNAL  FROM signalement_civil_agent_new scan LEFT JOIN signalement_civil_agent_histo_traitement uu  ON uu.ID_SIGNALEMENT_NEW=scan.ID_SIGNALEMENT_NEW LEFT JOIN utilisateurs u  ON u.ID_UTILISATEUR=scan.ID_UTILISATEUR LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID  LEFT JOIN civil_alerts_types cat ON cat.ID_TYPE=scan.ID_CATEGORIE_SIGNALEMENT  LEFT JOIN civil_alerts_statuts cas ON cas.ID_ALERT_STATUT=scan.ID_ALERT_STATUT
            WHERE   uu.STATUT_ID=3 AND  uu.ID_UTILISATEUR=".$id." ".$criteres_signa ." ".$criteres_type;
}
else if($profil['PROFIL_ID']==19){
 $query_principal = "SELECT scan.DATE_SIGNAL,scan.ID_AUTRE_CONTROL,scan.ID_SIGNALEMENT_NEW,cas.NOM AS STATUT, cat.DESCRIPTION,pe.PHOTO, u.NOM_CITOYEN,u.PRENOM_CITOYEN ,pe.NOM,pe.PRENOM,scan.IMAGE_UNE,scan.IMAGE_DEUX,scan.IMAGE_TROIS,scan.DATE_SIGNAL  FROM signalement_civil_agent_new scan LEFT JOIN signalement_civil_agent_histo_traitement uu  ON uu.ID_SIGNALEMENT_NEW=scan.ID_SIGNALEMENT_NEW LEFT JOIN utilisateurs u  ON u.ID_UTILISATEUR=scan.ID_UTILISATEUR LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID  LEFT JOIN civil_alerts_types cat ON cat.ID_TYPE=scan.ID_CATEGORIE_SIGNALEMENT  LEFT JOIN civil_alerts_statuts cas ON cas.ID_ALERT_STATUT=scan.ID_ALERT_STATUT
            WHERE   uu.STATUT_ID=4 AND  uu.ID_UTILISATEUR=".$id." ".$criteres_signa ." ".$criteres_type;
}
 $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
 $var_search=str_replace("'", "\'", $var_search);


        $limit = 'LIMIT 0,10';

        if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by = '';
        $order_column = array('NOM','PLAQUE_NUMERO','DESCRIPTION_PLAQUE','COMMENTAIRE','DESCRIPTION','PHOTO','STATUT','DATE_SIGNAL');

        $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_SIGNAL ASC';
        $search = !empty($_POST['search']['value']) ? ("AND DATE_SIGNAL LIKE '%$var_search%'  ") : '';


        $critaire = '';

        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

        $fetch_psr = $this->Modele->datatable($query_secondaire);
        $data = array();
       foreach ($fetch_psr as $row) {
            $sub_array=array();
            // $sub_array[] = '<input type="checkbox" value="'.$row->ID_SIGNALEMENT_NEW.'"name="SIGNALEMENT_ID" onchange="one_checked()">';
            if($row->NOM_CITOYEN!=null){
             $source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
             $sub_array[] = '<table> <tbody><tr><td><a title="' . $source . '" href="#" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM_CITOYEN . ' ' . $row->PRENOM_CITOYEN . '</td></tr></tbody></table></a>';
            }
            else{
              $source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
              $sub_array[] = '<table> <tbody><tr><td><a title="' . $source . '" href="#" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM . '</td></tr></tbody></table></a>';
            }
            $sub_array[] = (!empty($row->PLAQUE_NUMERO)) ?$row->PLAQUE_NUMERO:'N/A';
            $sub_array[] = (!empty($row->DESCRIPTION_PLAQUE)) ?$row->DESCRIPTION_PLAQUE:'N/A';
            $sub_array[] = (!empty($row->COMMENTAIRE)) ?$row->COMMENTAIRE:'N/A';
            $sub_array[] = (!empty($row->DESCRIPTION)) ?$row->DESCRIPTION:'N/A';

         $questionList = $this->Model->getRequete('SELECT acq.INFRACTIONS,acqr.REPONSE_DECRP FROM  autres_controles ac  LEFT JOIN autres_controles_questionnaires acq on acq.ID_CONTROLES_QUESTIONNAIRES= ac.ID_CONTROLES_QUESTIONNAIRES LEFT  JOIN  autres_contr_quest_rp acqr ON acqr.ID_REPONSE=ac.ID_REPONSE   WHERE ac.ID_CONTROLE_PLAQUE ='.$row->ID_AUTRE_CONTROL.'');
         $html="";
         $no=0;
        foreach ($questionList as $value) { 
          $no++;
          $pres = !empty($value['REPONSE_DECRP']) ? "=> ".$value['REPONSE_DECRP'] : "";
                     $html.="<p> ".$no.". ".$value['INFRACTIONS']."". $pres."</p> ";

                    }

            $option=" 
          <div class='modal fade' id='myPicture" .  $row->ID_SIGNALEMENT_NEW . "'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                  <div class='modal-header' style='background: black;'>
            <div id='title'><b>Détails<h4 
            style='color:#fff;font-size: 18px;'></h4>
            </div>
            <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </div>
         </div>
                    <div class='modal-body'>

                      <div class='col-md-12'>
          
                       ".$html. "
         
                       <div class='col-md-12 row'>
                       
                            <div class='col-md-6'>
                              <img style='width:100%'  src='" . $row->IMAGE_UNE . "'>
                            </div>
                            <div class='col-md-6'>
                              <img style='width:100%'  src='" . $row->IMAGE_DEUX. "'>
                            </div>

                             <div class='col-md-6'>
                              <img style='width:100%'  src='" . $row->IMAGE_TROIS. "'>
                            </div>

                        </div>

                       </div>
                    

                    </div>

                    <div class='modal-footer'>
                    
                   
                    <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
               </div>
             </div>
            </div>
          </div>
          ";

            $img1 =  (!empty($row->IMAGE_UNE)) ?  "<td><a class='btn-md'  href='#' data-toggle='modal'
                     data-target='#myPicture" . $row->ID_SIGNALEMENT_NEW . "'><font color='red'><img style='width:20px' src='" . $row->IMAGE_UNE . "'></a></td>" : "";

            $img2 =  (!empty($row->IMAGE_DEUX)) ?  "<td><a class='btn-md'  href='#' data-toggle='modal'
                     data-target='#myPicture" . $row->ID_SIGNALEMENT_NEW . "'><font color='red'><img style='width:20px' src='" . $row->IMAGE_DEUX . "'></a></td>" : "";

            $img3 =  (!empty($row->IMAGE_TROIS)) ?  "<td><a class='btn-md'  href='#' data-toggle='modal'
                     data-target='#myPicture" . $row->ID_SIGNALEMENT_NEW . "'><font color='red'><img style='width:20px' src='" . $row->IMAGE_TROIS . "'></a></td>" : "";

            $sub_array[]= "<table><tr>".$img1.$img2.$img3."</tr><table> ".$option;
           

            $sub_array[] = $row->STATUT;
            $sub_array[] = $row->DATE_SIGNAL;
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

   function listing()
   {
    $id=$this->session->userdata('USER_ID');
    $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');
    $TYPE = $this->input->post('TYPE');
    $criteres_signa = "";
    $criteres_type = "";
    if(!empty($TYPE) ){
     $criteres_type = " AND  cat.ID_TYPE=".$TYPE;
    }
    
      if(!empty($DATE_UNE) && empty($DATE_DEUX)){

          $criteres_signa = " AND DATE_FORMAT(scan.DATE_SIGNAL, '%Y-%m-%d')='" . $DATE_UNE."'";

         }
         if(empty($DATE_UNE) && !empty($DATE_DEUX)){

          $criteres_signa = " and DATE_FORMAT(scan.DATE_SIGNAL, '%Y-%m-%d')='" . $DATE_DEUX."'";

         }
        if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {

        $criteres_signa = " and DATE_FORMAT(scan.DATE_SIGNAL, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";
            
        }
    $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id);
   if($profil['PROFIL_ID']==17 || $profil['PROFIL_ID']==1)
   {
     $query_principal = "SELECT scan.PLAQUE_NUMERO,scan.DESCRIPTION_PLAQUE,scan.COMMENTAIRE,scan.DATE_SIGNAL,scan.ID_AUTRE_CONTROL,scan.ID_SIGNALEMENT_NEW,cas.NOM AS STATUT, cat.DESCRIPTION,pe.PHOTO, u.NOM_CITOYEN,u.PRENOM_CITOYEN ,pe.NOM,pe.PRENOM,scan.IMAGE_UNE,scan.IMAGE_DEUX,scan.IMAGE_TROIS,scan.DATE_SIGNAL  FROM signalement_civil_agent_new scan LEFT JOIN utilisateurs u  ON u.ID_UTILISATEUR=scan.ID_UTILISATEUR LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID  LEFT JOIN civil_alerts_types cat ON cat.ID_TYPE=scan.ID_CATEGORIE_SIGNALEMENT  LEFT JOIN civil_alerts_statuts cas ON cas.ID_ALERT_STATUT=scan.ID_ALERT_STATUT
            WHERE  cas.ID_ALERT_STATUT=1 ".$criteres_signa ." ".$criteres_type;
}
else if($profil['PROFIL_ID']==18)
{
  $query_principal = "SELECT scan.PLAQUE_NUMERO,scan.DESCRIPTION_PLAQUE,scan.COMMENTAIRE,scan.DATE_SIGNAL,scan.ID_AUTRE_CONTROL,scan.ID_SIGNALEMENT_NEW,cas.NOM AS STATUT, cat.DESCRIPTION,pe.PHOTO, u.NOM_CITOYEN,u.PRENOM_CITOYEN ,pe.NOM,pe.PRENOM,scan.IMAGE_UNE,scan.IMAGE_DEUX,scan.IMAGE_TROIS,scan.DATE_SIGNAL  FROM signalement_civil_agent_new scan LEFT JOIN utilisateurs u  ON u.ID_UTILISATEUR=scan.ID_UTILISATEUR LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID  LEFT JOIN civil_alerts_types cat ON cat.ID_TYPE=scan.ID_CATEGORIE_SIGNALEMENT  LEFT JOIN civil_alerts_statuts cas ON cas.ID_ALERT_STATUT=scan.ID_ALERT_STATUT
            WHERE  cas.ID_ALERT_STATUT=2 ".$criteres_signa ." ".$criteres_type;
}
else if($profil['PROFIL_ID']==19){
  $query_principal = "SELECT scan.PLAQUE_NUMERO,scan.DESCRIPTION_PLAQUE,scan.COMMENTAIRE,scan.DATE_SIGNAL,scan.ID_AUTRE_CONTROL,scan.ID_SIGNALEMENT_NEW,cas.NOM AS STATUT, cat.DESCRIPTION,pe.PHOTO, u.NOM_CITOYEN,u.PRENOM_CITOYEN ,pe.NOM,pe.PRENOM,scan.IMAGE_UNE,scan.IMAGE_DEUX,scan.IMAGE_TROIS,scan.DATE_SIGNAL  FROM signalement_civil_agent_new scan LEFT JOIN utilisateurs u  ON u.ID_UTILISATEUR=scan.ID_UTILISATEUR LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID  LEFT JOIN civil_alerts_types cat ON cat.ID_TYPE=scan.ID_CATEGORIE_SIGNALEMENT  LEFT JOIN civil_alerts_statuts cas ON cas.ID_ALERT_STATUT=scan.ID_ALERT_STATUT WHERE  cas.ID_ALERT_STATUT=3 ".$criteres_signa ." ".$criteres_type;
}
    

            $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
           $var_search=str_replace("'", "\'", $var_search);


        $limit = 'LIMIT 0,10';

        if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }

        $order_by = '';

        $order_column = array('NOM','PLAQUE_NUMERO','DESCRIPTION_PLAQUE','COMMENTAIRE','DESCRIPTION','PHOTO','STATUT','DATE_SIGNAL');


        $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_SIGNAL ASC';

        $search = !empty($_POST['search']['value']) ? ("AND DATE_SIGNAL LIKE '%$var_search%'  ") : '';
        $critaire = '';
        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

        $fetch_psr = $this->Modele->datatable($query_secondaire);
        $data = array();
        foreach ($fetch_psr as $row) {
            $sub_array=array();
            // $sub_array[] = '<input type="checkbox" value="'.$row->ID_SIGNALEMENT_NEW.'"name="SIGNALEMENT_ID" onchange="one_checked()">';
            if($row->NOM_CITOYEN!=null){
             $source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
             $sub_array[] = '<table> <tbody><tr><td><a title="' . $source . '" href="#" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM_CITOYEN . ' ' . $row->PRENOM_CITOYEN . '</td></tr></tbody></table></a>';
            }
            else{
              $source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
              $sub_array[] = '<table> <tbody><tr><td><a title="' . $source . '" href="#" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM . '</td></tr></tbody></table></a>';
            }
            $sub_array[] = (!empty($row->PLAQUE_NUMERO)) ?$row->PLAQUE_NUMERO:'N/A';
            $sub_array[] = (!empty($row->DESCRIPTION_PLAQUE)) ?$row->DESCRIPTION_PLAQUE:'N/A';
            $sub_array[] = (!empty($row->COMMENTAIRE)) ?$row->COMMENTAIRE:'N/A';
            $sub_array[] = (!empty($row->DESCRIPTION)) ?$row->DESCRIPTION:'N/A';
            $img1 =  (!empty($row->IMAGE_UNE)) ?  "<td><a class='btn-md'  href='#' data-toggle='modal'
                     data-target='#myPicture" . $row->ID_SIGNALEMENT_NEW . "'><font color='red'><img style='width:20px' src='" . $row->IMAGE_UNE . "'></a></td>" : "";

            $img2 =  (!empty($row->IMAGE_DEUX)) ?  "<td><a class='btn-md'  href='#' data-toggle='modal'
                     data-target='#myPicture" . $row->ID_SIGNALEMENT_NEW . "'><font color='red'><img style='width:20px' src='" . $row->IMAGE_DEUX . "'></a></td>" : "";

            $img3 =  (!empty($row->IMAGE_TROIS)) ?  "<td><a class='btn-md'  href='#' data-toggle='modal'
                     data-target='#myPicture" . $row->ID_SIGNALEMENT_NEW . "'><font color='red'><img style='width:20px' src='" . $row->IMAGE_TROIS . "'></a></td>" : "";

            $sub_array[]= "<table><tr>".$img1.$img2.$img3."</tr><table> ";
           

            $sub_array[] = $row->STATUT;
            $sub_array[] = $row->DATE_SIGNAL;


       $questionList = $this->Model->getRequete('SELECT acq.INFRACTIONS,acqr.REPONSE_DECRP FROM  autres_controles ac  LEFT JOIN autres_controles_questionnaires acq on acq.ID_CONTROLES_QUESTIONNAIRES= ac.ID_CONTROLES_QUESTIONNAIRES LEFT  JOIN  autres_contr_quest_rp acqr ON acqr.ID_REPONSE=ac.ID_REPONSE   WHERE ac.ID_CONTROLE_PLAQUE ='.$row->ID_AUTRE_CONTROL.'');
        $avisList = $this->Model->getRequete('SELECT * FROM signalement_avis_traitement WHERE 1');
        $select="";
        $select.=" <select  name='signalement_avis' id='signalement_avis' class='form-control' required>
                   <option value=''>Sélectionner</option>";
                    foreach ($avisList as $val) { 
               $select.="<option  value='".$val['ID_AVIS_SIGNALEMENT']." '>".$val['AVIS']."</option>";
                    }
                 $select.="</select>";
                 
                  $avisRejetter = $this->Model->getRequete('SELECT * FROM signalement_avis_traitement_rejetter WHERE 1');
        $selectRejetter="";
        $selectRejetter.=" <select  name='signalement_avis_rej' id='signalement_avis_rej' class='form-control' required>
                   <option value=''>Sélectionner</option>";
                    foreach ($avisRejetter as $vale) { 
               $selectRejetter.="<option  value='".$vale['ID_AVIS_SIGNALEMENT_REJETTER']." '>".$vale['AVIS']."</option>";
                    }
                 $selectRejetter.="</select>";



                       
       $html="";
       $no=0;

       

        foreach ($questionList as $value) { 
          $no++;

          $pres = !empty($value['REPONSE_DECRP']) ? "=> ".$value['REPONSE_DECRP'] : "";
                     $html.="<p> ".$no.". ".$value['INFRACTIONS']."". $pres."</p> ";

                    }

            $option='</div><div class="dropdown">
                       <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-cog"></i>
            Action<span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-menu-left">
              ';
                  
                   $option .= "<li><a class='btn-md'  href='#' data-toggle='modal'
                     data-target='#myAccepte" . $row->ID_SIGNALEMENT_NEW . "'><font >&nbsp;&nbsp;Valider</font></a></li>";
                   $option .= "<li><a class='btn-md'  href='#' data-toggle='modal'
                     data-target='#mydelete" . $row->ID_SIGNALEMENT_NEW . "'><font color='red'>&nbsp;&nbsp;Rejetter</font></a></li>";
                  $option .= " </ul>
              </div>


            <div class='modal fade' id='mydelete" .$row->ID_SIGNALEMENT_NEW."'>
                <div class='modal-dialog'>

                <div class='modal-header' style='background: black;'>
            <div id='title'><b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'>Annulation d'un signalement</h4></b></div>

            <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </div>
         </div>
                  <div class='modal-content'>
                    <div class='modal-body'>

               <form id='myForm1".$row->ID_SIGNALEMENT_NEW."'action=".base_url('PSR/Validation_signalement/rejette/'.$row->ID_SIGNALEMENT_NEW)." method='post' autocomplete='off'>
                   <div class='col-md-12 mt-4'>
                   <label>Avis</label>
                      ".$selectRejetter."
                      </div> 
                   <div class='col-md-12 mt-4'>
                   </div> 
                    </div>
                    <div class='modal-footer'>
                    <button type='button' onclick='subForm_delete(".$row->ID_SIGNALEMENT_NEW.")' class='btn btn-primary btn-md' >Rejetter</button> </form> 
                    </form>
                    <div class='modal-footer'>
                    <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
               </div>
             </div>
            </div>
          </div>
          </div>
          <div class='modal fade' id='myAccepte" .  $row->ID_SIGNALEMENT_NEW . "'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                  <div class='modal-header' style='background: black;'>
            <div id='title'><b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'>Votre avis sur ce signalement</h4></b></div>

            <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </div>
         </div>
                    <div class='modal-body'>
                    <form id='myForm".$row->ID_SIGNALEMENT_NEW."'action=".base_url('PSR/Validation_signalement/save/'.$row->ID_SIGNALEMENT_NEW)." method='post' autocomplete='off'>
                   <div class='col-md-12 mt-4'>
                   <label>Avis</label>
                      ".$select."
                      </div> 
                   <div class='col-md-12 mt-4'>
                   
                   </div> 
                    
                    </div>

                    <div class='modal-footer'>
                    <button type='button' onclick='subForm_valide(".$row->ID_SIGNALEMENT_NEW.")' class='btn btn-primary btn-md' >Envoyer</button> </form> 
           </form> 

                    <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
               </div>
             </div>
            </div>
          </div>
          <div class='modal fade' id='myPicture" .  $row->ID_SIGNALEMENT_NEW . "'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                  <div class='modal-header' style='background: black;'>
            <div id='title'><b>Détails<h4 
            style='color:#fff;font-size: 18px;'></h4>

            </div>

            <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </div>
         </div>
                    <div class='modal-body'>

                      <div class='col-md-12'>
          
                       ".$html. "
         
                       <div class='col-md-12 row'>
                       
                            <div class='col-md-6'>
                              <img style='width:100%'  src='" . $row->IMAGE_UNE . "'>
                            </div>
                            <div class='col-md-6'>
                              <img style='width:100%'  src='" . $row->IMAGE_DEUX. "'>
                            </div>

                             <div class='col-md-6'>
                              <img style='width:100%'  src='" . $row->IMAGE_TROIS. "'>
                            </div>

                        </div>

                       </div>
                    

                    </div>

                    <div class='modal-footer'>
                    
                   
                    <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
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


function listing_rejette()
{
    $DATE_UNE = $this->input->post('DATE_UNE');
    $DATE_DEUX = $this->input->post('DATE_DEUX');
    $TYPE = $this->input->post('TYPE');
     $criteres_signa = "";
     $criteres_type = "";
    if(!empty($TYPE) ){
     $criteres_type = " AND  cat.ID_TYPE=".$TYPE;
    }
      if(!empty($DATE_UNE) && empty($DATE_DEUX)){

          $criteres_signa = " and DATE_FORMAT(scan.DATE_SIGNAL, '%Y-%m-%d')='" . $DATE_UNE."'";

         }
         if(empty($DATE_UNE) && !empty($DATE_DEUX)){

          $criteres_signa = " and DATE_FORMAT(scan.DATE_SIGNAL, '%Y-%m-%d')='" . $DATE_DEUX."'";

         }
        if (!empty($DATE_UNE) && !empty($DATE_DEUX)) {
        $criteres_signa = " and DATE_FORMAT(scan.DATE_SIGNAL, '%Y-%m-%d') between  '" . $DATE_UNE."'  AND  '" . $DATE_DEUX."'";
            
        }
    $id=$this->session->userdata('USER_ID');
    $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id);
   
   $query_principal = "SELECT scan.PLAQUE_NUMERO,scan.DESCRIPTION_PLAQUE,scan.COMMENTAIRE, scan.DATE_SIGNAL,scan.ID_AUTRE_CONTROL,scan.ID_SIGNALEMENT_NEW,cas.NOM AS STATUT, cat.DESCRIPTION,pe.PHOTO, u.NOM_CITOYEN,u.PRENOM_CITOYEN ,pe.NOM,pe.PRENOM,scan.IMAGE_UNE,scan.IMAGE_DEUX,scan.IMAGE_TROIS,scan.DATE_SIGNAL  FROM signalement_civil_agent_new scan LEFT JOIN signalement_civil_agent_histo_traitement uu  ON uu.ID_SIGNALEMENT_NEW=scan.ID_SIGNALEMENT_NEW LEFT JOIN utilisateurs u  ON u.ID_UTILISATEUR=scan.ID_UTILISATEUR LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID  LEFT JOIN civil_alerts_types cat ON cat.ID_TYPE=scan.ID_CATEGORIE_SIGNALEMENT  LEFT JOIN civil_alerts_statuts cas ON cas.ID_ALERT_STATUT=scan.ID_ALERT_STATUT
            WHERE   uu.STATUT_ID=5 AND  uu.ID_UTILISATEUR=".$id." ".$criteres_signa ." ".$criteres_type;
     $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
      $var_search=str_replace("'", "\'", $var_search);


        $limit = 'LIMIT 0,10';

        if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }

        $order_by = '';
        $order_column = array('NOM','PLAQUE_NUMERO','DESCRIPTION_PLAQUE','COMMENTAIRE','DESCRIPTION','PHOTO','STATUT','DATE_SIGNAL');

        $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_SIGNAL ASC';

        $search = !empty($_POST['search']['value']) ? ("AND DATE_SIGNAL LIKE '%$var_search%'  ") : '';


        $critaire = '';

        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

        $fetch_psr = $this->Modele->datatable($query_secondaire);
        $data = array();
        foreach ($fetch_psr as $row) {
            $sub_array=array();
            // $sub_array[] = '<input type="checkbox" value="'.$row->ID_SIGNALEMENT_NEW.'"name="SIGNALEMENT_ID" onchange="one_checked()">';
            if($row->NOM_CITOYEN!=null){
             $source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
             $sub_array[] = '<table> <tbody><tr><td><a title="' . $source . '" href="#" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM_CITOYEN . ' ' . $row->PRENOM_CITOYEN . '</td></tr></tbody></table></a>';
            }
            else{
              $source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
              $sub_array[] = '<table> <tbody><tr><td><a title="' . $source . '" href="#" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM . '</td></tr></tbody></table></a>';
            }
            $sub_array[] = (!empty($row->PLAQUE_NUMERO)) ?$row->PLAQUE_NUMERO:'N/A';
            $sub_array[] = (!empty($row->DESCRIPTION_PLAQUE)) ?$row->DESCRIPTION_PLAQUE:'N/A';
            $sub_array[] = (!empty($row->COMMENTAIRE)) ?$row->COMMENTAIRE:'N/A';
            $sub_array[] = (!empty($row->DESCRIPTION)) ?$row->DESCRIPTION:'N/A';

         $questionList = $this->Model->getRequete('SELECT acq.INFRACTIONS,acqr.REPONSE_DECRP FROM  autres_controles ac  LEFT JOIN autres_controles_questionnaires acq on acq.ID_CONTROLES_QUESTIONNAIRES= ac.ID_CONTROLES_QUESTIONNAIRES LEFT  JOIN  autres_contr_quest_rp acqr ON acqr.ID_REPONSE=ac.ID_REPONSE   WHERE ac.ID_CONTROLE_PLAQUE ='.$row->ID_AUTRE_CONTROL.'');
         $html="";
         $no=0;
        foreach ($questionList as $value) { 
          $no++;
          $pres = !empty($value['REPONSE_DECRP']) ? "=> ".$value['REPONSE_DECRP'] : "";
                     $html.="<p> ".$no.". ".$value['INFRACTIONS']."". $pres."</p> ";

                    }

            $option=" 
          <div class='modal fade' id='myPicture" .  $row->ID_SIGNALEMENT_NEW . "'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                  <div class='modal-header' style='background: black;'>
            <div id='title'><b>Détails<h4 
            style='color:#fff;font-size: 18px;'></h4>
            </div>
            <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </div>
         </div>
                    <div class='modal-body'>

                      <div class='col-md-12'>
          
                       ".$html. "
         
                       <div class='col-md-12 row'>
                       
                            <div class='col-md-6'>
                              <img style='width:100%'  src='" . $row->IMAGE_UNE . "'>
                            </div>
                            <div class='col-md-6'>
                              <img style='width:100%'  src='" . $row->IMAGE_DEUX. "'>
                            </div>

                             <div class='col-md-6'>
                              <img style='width:100%'  src='" . $row->IMAGE_TROIS. "'>
                            </div>

                        </div>

                       </div>
                    

                    </div>

                    <div class='modal-footer'>
                    
                   
                    <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
               </div>
             </div>
            </div>
          </div>
          ";

            $img1 =  (!empty($row->IMAGE_UNE)) ?  "<td><a class='btn-md'  href='#' data-toggle='modal'
                     data-target='#myPicture" . $row->ID_SIGNALEMENT_NEW . "'><font color='red'><img style='width:20px' src='" . $row->IMAGE_UNE . "'></a></td>" : "";

            $img2 =  (!empty($row->IMAGE_DEUX)) ?  "<td><a class='btn-md'  href='#' data-toggle='modal'
                     data-target='#myPicture" . $row->ID_SIGNALEMENT_NEW . "'><font color='red'><img style='width:20px' src='" . $row->IMAGE_DEUX . "'></a></td>" : "";

            $img3 =  (!empty($row->IMAGE_TROIS)) ?  "<td><a class='btn-md'  href='#' data-toggle='modal'
                     data-target='#myPicture" . $row->ID_SIGNALEMENT_NEW . "'><font color='red'><img style='width:20px' src='" . $row->IMAGE_TROIS . "'></a></td>" : "";

            $sub_array[]= "<table><tr>".$img1.$img2.$img3."</tr><table> ".$option;
           

            $sub_array[] = $row->STATUT;
            $sub_array[] = $row->DATE_SIGNAL;
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