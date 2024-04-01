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
  if ($this->session->userdata('ASSURANCE') != 1 && $this->session->userdata('PSR_ELEMENT') != 1) {
   redirect(base_url());
  }
 }

	function index()
  {
    $data['title'] = 'Historique  des vérifications  avec constant';
    $this->load->view('commentaire/Commentaire_List_View', $data);
  }
  function all_const()
  {
   $id=$this->session->userdata('USER_ID');
  $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID,ass.ASSURANCE FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID LEFT JOIN assureur ass ON ass.ID_UTILISATEUR=u.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id);

    

    if($profil['PROFIL_ID']==2)
    {

      $data['title'] = 'Historique des traitements de constant';
    }
    else{
    $data['title'] = 'Historique des constants';
    }
    if($profil['PROFIL_ID']==1)
    {
      $Nbre_maintenir = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat WHERE ID_CONST_STATUT_TRAITE=5');
      $Nbre_annuler = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat WHERE ID_CONST_STATUT_TRAITE=4');
      $Nbre_encours = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat WHERE ID_CONST_STATUT_TRAITE=1');
       $Nbre_avis = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat WHERE ID_CONST_STATUT_TRAITE=3');

      $data['Nbre_maintenir']=$Nbre_maintenir['Nombre'];
      $data['Nbre_canceler']=$Nbre_annuler['Nombre'];
      $data['Nbre_encours']=$Nbre_encours['Nombre'];
      $data['Nbre_avis']=$Nbre_avis['Nombre'];

    $this->load->view('commentaire/Constant_List_view', $data);
    }
    else if($profil['PROFIL_ID']==2)
    {
       
      $Nbre_transmis = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  LEFT JOIN  assureur a ON  a.ID_ASSUREUR=htc.ID_ASSUREUR WHERE ID_CONST_STATUT_TRAITE=2 AND a.ID_UTILISATEUR=' .$this->session->userdata('USER_ID').'');

      $Nbre_retours = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  LEFT JOIN  assureur a ON  a.ID_ASSUREUR=htc.ID_ASSUREUR WHERE ID_CONST_STATUT_TRAITE=3 AND a.ID_UTILISATEUR='.$this->session->userdata('USER_ID').'');

      
       $data['Nbre_transmis']=$Nbre_transmis['Nombre'];
      $data['Nbre_retours']=$Nbre_retours['Nombre'];
      
     $this->load->view('commentaire/Constant_parte_List_view', $data);
    }
    else if($profil['PROFIL_ID']==3 || $profil['PROFIL_ID']=4 || $profil['PROFIL_ID']=5 || $profil['PROFIL_ID']=6 )
    {
      
      if($profil['PROFIL_ID']==3)
{
  $Nbre_transmis = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  LEFT JOIN  assureur a ON  a.ID_ASSUREUR=htc.ID_ASSUREUR WHERE htc.ID_TYPE_VERIFICATION=1 AND ID_CONST_STATUT_TRAITE=2 AND a.ID_UTILISATEUR=' .$this->session->userdata('USER_ID').'');

      $Nbre_retours = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  LEFT JOIN  assureur a ON  a.ID_ASSUREUR=htc.ID_ASSUREUR WHERE htc.ID_TYPE_VERIFICATION=1 AND htc.ID_CONST_STATUT_TRAITE=3 AND a.ID_UTILISATEUR='.$this->session->userdata('USER_ID').'');

      
       $data['Nbre_transmis']=$Nbre_transmis['Nombre'];
      $data['Nbre_retours']=$Nbre_retours['Nombre'];

}
else if($profil['PROFIL_ID']==4)
{
  $Nbre_transmis = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  LEFT JOIN  assureur a ON  a.ID_ASSUREUR=htc.ID_ASSUREUR WHERE htc.ID_TYPE_VERIFICATION=4 AND ID_CONST_STATUT_TRAITE= AND a.ID_UTILISATEUR=' .$this->session->userdata('USER_ID').'');

      $Nbre_retours = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  LEFT JOIN  assureur a ON  a.ID_ASSUREUR=htc.ID_ASSUREUR WHERE htc.ID_TYPE_VERIFICATION=4 AND htc.ID_CONST_STATUT_TRAITE=3 AND a.ID_UTILISATEUR='.$this->session->userdata('USER_ID').'');

      
       $data['Nbre_transmis']=$Nbre_transmis['Nombre'];
      $data['Nbre_retours']=$Nbre_retours['Nombre'];
}
else if($profil['PROFIL_ID']==5)
{
       $Nbre_transmis = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  LEFT JOIN  assureur a ON  a.ID_ASSUREUR=htc.ID_ASSUREUR WHERE htc.ID_TYPE_VERIFICATION=3 AND ID_CONST_STATUT_TRAITE=2 AND a.ID_UTILISATEUR=' .$this->session->userdata('USER_ID').'');

      $Nbre_retours = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  LEFT JOIN  assureur a ON  a.ID_ASSUREUR=htc.ID_ASSUREUR WHERE htc.ID_TYPE_VERIFICATION=3 AND htc.ID_CONST_STATUT_TRAITE=3 AND a.ID_UTILISATEUR='.$this->session->userdata('USER_ID').'');

      
       $data['Nbre_transmis']=$Nbre_transmis['Nombre'];
      $data['Nbre_retours']=$Nbre_retours['Nombre'];

      
       $data['Nbre_transmis']=$Nbre_transmis['Nombre'];
      $data['Nbre_retours']=$Nbre_retours['Nombre'];
  
}
else if($profil['PROFIL_ID']==6)
{
     $Nbre_transmis = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  LEFT JOIN  assureur a ON  a.ID_ASSUREUR=htc.ID_ASSUREUR WHERE htc.ID_TYPE_VERIFICATION=6 AND ID_CONST_STATUT_TRAITE=2 AND a.ID_UTILISATEUR=' .$this->session->userdata('USER_ID').'');

      $Nbre_retours = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_traitement_constat htc  LEFT JOIN  assureur a ON  a.ID_ASSUREUR=htc.ID_ASSUREUR WHERE htc.ID_TYPE_VERIFICATION=6 AND htc.ID_CONST_STATUT_TRAITE=3 AND a.ID_UTILISATEUR='.$this->session->userdata('USER_ID').'');

      
       $data['Nbre_transmis']=$Nbre_transmis['Nombre'];
      $data['Nbre_retours']=$Nbre_retours['Nombre'];
  
}
     $this->load->view('commentaire/Constant_instution_List_view', $data);
    }
    else{
       redirect(base_url());
    }
   
  }
   function listing(){
        $i = 1;
        $query_principal = "SELECT DISTINCT tv.ID_TYPE_VERIFICATION ,histo.ID_HISTORIQUE,histo.NUMERO_PLAQUE,histo.DATE_INSERTION FROM  historiques histo LEFT JOIN  historique_commentaire_verification  hcv ON hcv.ID_HISTORIQUE=histo.ID_HISTORIQUE 
            LEFT JOIN  type_verification tv ON tv.ID_TYPE_VERIFICATION=hcv.ID_TYPE_VERIFICATION
            WHERE histo.ID_HISTORIQUE_STATUT=1";

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

        $limit = 'LIMIT 0,10';

        if ($_POST['length'] != -1) {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }

        $order_by = '';

        $order_column = array('NUMERO_PLAQUE', 'DATE');

        $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_INSERTION ASC';

        $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%'  ") : '';


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
       $sub_array[] = $row->NUMERO_PLAQUE;
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
 function detail($id,$verification)
 {
         $query_principal = " 
             SELECT htc.ID_ASSUREUR,  hc.IS_VALIDE_SOURCE,hc.COMMENTAIRE_ID,tv.ID_TYPE_VERIFICATION,histo.ID_HISTORIQUE,hcc.PHOTO_COMMANTAIRE,hc.COMMENTAIRE_TEXT,hcc.PHOTO_COMMANTAIRE FROM  historiques histo LEFT JOIN  historique_commentaire_verification  hcv ON hcv.ID_HISTORIQUE=histo.ID_HISTORIQUE 
             LEFT JOIN  type_verification tv ON tv.ID_TYPE_VERIFICATION=hcv.ID_TYPE_VERIFICATION LEFT JOIN  historique_commentaire_controls hcc ON hcc.ID_COMMENTAIRE_VERIFICATION=hcv.ID_COMMENTAIRE_VERIFICATION 
             LEFT JOIN historique_commentaire hc ON hc.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID LEFT JOIN  histo_traitement_constat htc ON htc.ID_HISTORIQUE=histo.ID_HISTORIQUE
             WHERE histo.ID_HISTORIQUE_STATUT=1 AND histo.ID_HISTORIQUE=".$id;
         $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
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
           // $sub_array[] = $row->NUMERO_PLAQUE;
           $sub_array[] = $row->COMMENTAIRE_TEXT;
           if (!empty($row->PHOTO_COMMANTAIRE)) {
     				$sub_array[]= "<a target='_blank' href='" . $row->PHOTO_COMMANTAIRE . "' ><img style='width:20%' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
     			}

     			else{
     				$sub_array[]= "Aucun";

     			}
        $html="";
        if($row->ID_TYPE_VERIFICATION==2 && $row->IS_VALIDE_SOURCE==0)
        {
         $AssureurList=$this->Modele->getListOrder("assureur","ASSURANCE");
           // $AssureurList = $this->Model->getRequete('SELECT * FROM assureur WHERE ID_ASSUREUR='.$row->ID_ASSUREUR.'');
         $html.=" <select name='assureur' id='assureur' class='form-control'>
                   <option value=''>Sélectionner un assureur</option>";
                    foreach ($AssureurList as $value) { 
                     $html.="<option selected=''value='".$value['ID_ASSUREUR']." '>".$value['ASSURANCE']."</option>";
                    }
                 $html.="</select>";
        }
        if($verification==2)
        {


           $option = '
              ';

                  $option .= "<a class='btn btn-outline-primary' hre='#' data-toggle='modal'
              data-target='#mydelete" . $row->COMMENTAIRE_ID . "'><font class='text-info'>&nbsp;&nbsp;Envoyer</font></a></li>";
                  
                  $option .= " </ul>
          </div>
          <div class='modal fade' id='mydelete" .  $row->COMMENTAIRE_ID . "'>
          <div class='modal-dialog'>
          <div class='modal-content'>

          <div class='modal-body'>
           <form id='myForm".$row->ID_HISTORIQUE."' action=".base_url('PSR/Commentaire/save') ." method='post' autocomplete='off'>
          <label>Assureur</label>
          ".$html."
          
           <input type='hidden' value=".$row->ID_HISTORIQUE."class='form-control' name='id_historique' id='id_historique' placeholder='Adresse'> 
            <input type='hidden' value=".$row->ID_TYPE_VERIFICATION."class='form-control' name='id_type_verification' id='id_type_verification' placeholder='Adresse'> 
            <input type='hidden' value=".$row->COMMENTAIRE_ID."class='form-control' name='histo_commentaire_id' id='histo_commentaire_id' placeholder='Adresse'> 
          </div>

          <div class='modal-footer'>
          <button type='button' onclick='subForm(".$row->ID_HISTORIQUE.")' class='btn btn-primary btn-md' >Envoyer</button> </form> 
          <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
          
          </div>

          </div>
          </div>
          </div>";
         
        //    $option = '<div class="dropdown ">
        //            <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
        //   <i class="fa fa-cog"></i>
        // Action<span class="caret"></span></a>
        //   <ul class="dropdown-menu dropdown-menu-left">
        //   ';

        //       $option .= "<li><a class='btn-md' hre='#' data-toggle='modal'
        //   data-target='#mydelete" . $row->COMMENTAIRE_ID . "'><font color='red'>&nbsp;&nbsp;traiter</font></a></li>";
        //       $option .= "<li><a class='btn-md' href='" . base_url('PSR/Commentaire/getOne/' . $row->COMMENTAIRE_ID) . "'><label class='text-info'>&nbsp;&nbsp;Annulr</label></a></li>";
            
           $sub_array[] = $option;
        }
     
     if($row->ID_TYPE_VERIFICATION==2 && $row->IS_VALIDE_SOURCE==0)
        {
         $AssureurList=$this->Modele->getListOrder("assureur","ASSURANCE");
         $html.=" <select name='assureur' id='assureur' class='form-control'>
                   <option value=''>Sélectionner un assureur</option>";
                    foreach ($AssureurList as $value) { 
                     $html.="<option selected=''value='".$value['ID_ASSUREUR']." '>".$value['ASSURANCE']."</option>";
                    }
                 $html.="</select>";
        }
if($verification==2)
{
   $option = '<div class="dropdown ">
           <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
  <i class="fa fa-cog"></i>
Action<span class="caret"></span></a>
  <ul class="dropdown-menu dropdown-menu-left">
  ';

      $option .= "<li><a class='btn-md' hre='#' data-toggle='modal'
  data-target='#mydelete" . $row->COMMENTAIRE_ID . "'><font color='red'>&nbsp;&nbsp;traiter</font></a></li>";
      $option .= "<li><a class='btn-md' href='" . base_url('PSR/Commentaire/getOne/' . $row->COMMENTAIRE_ID) . "'><label class='text-info'>&nbsp;&nbsp;Annuler</label></a></li>";
      $option .= " </ul>
  </div>
  <div class='modal fade' id='mydelete" .  $row->COMMENTAIRE_ID . "'>
  <div class='modal-dialog'>
  <div class='modal-content'>

  <div class='modal-body'>
   <form action=".base_url('PSR/Commentaire/save') ." method='post' autocomplete='off'>
  ".$html."
  
   <input type='hidden' value=".$row->ID_HISTORIQUE."class='form-control' name='id_historique' id='id_historique' placeholder='Adresse'> 
    <input type='hidden' value=".$row->ID_TYPE_VERIFICATION."class='form-control' name='id_type_verification' id='id_type_verification' placeholder='Adresse'> 
    <input type='hidden' value=".$row->COMMENTAIRE_ID."class='form-control' name='histo_commentaire_id' id='histo_commentaire_id' placeholder='Adresse'> 
    <div class='col-md-6 mt-4'>
                            <input type='submit' class='btn btn-outline-primary form-control' value='Enregistrer'>
                          </div>  

    </form> 
  
  </div>

  <div class='modal-footer'>
  <button class='btn btn-primary btn-md' data-dismiss='modal'>Envoyer</button>
  <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
  
  </div>

  </div>
  </div>
  </div>";
   $sub_array[] = $option;
}  
else
{
   
   $option = "<form action=".base_url('PSR/Commentaire/save') ." method='post' autocomplete='off'>
   <input type='hidden' value=".$row->ID_HISTORIQUE."class='form-control' name='id_historique' id='id_historique' placeholder='Adresse'> 
    <input type='hidden' value=".$row->ID_TYPE_VERIFICATION."class='form-control' name='id_type_verification' id='id_type_verification' placeholder='Adresse'> 
    <input type='hidden' value=".$row->COMMENTAIRE_ID."class='form-control' name='histo_commentaire_id' id='histo_commentaire_id' placeholder='Adresse'> 
    <div class='col-md-6 mt-4'>
        <input type='submit' class='btn btn-outline-primary ' value='Envoyer'
    </div>  

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
       $query_principal= "SELECT hcap.AVIS_PARTENAIRE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
        LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE WHERE  htc.HISTO_TRAITEMENT_CONSTANT_ID=".$id;

       $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

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
  public function save()
 {

  // if ($this->form_validation->run()==FALSE) {
  //  // $this->add();
  // }else{
        $id_assureur = $this->input->post('assureur');
        $id_historique = $this->input->post('id_historique');
        $id_type_verification = $this->input->post('id_type_verification');
        $histo_commentaire_id = $this->input->post('histo_commentaire_id');
        $date =date('Y-m-d:H-i');
        $id_utilisateur = $this->session->userdata('USER_ID');
       
        $data = array('ID_HISTORIQUE' =>$id_historique ,
                      'ID_TYPE_VERIFICATION' =>$id_type_verification,
                      'ID_ASSUREUR' =>$id_assureur,
                      'HISTO_COMMENTAIRE_ID' =>$histo_commentaire_id,
                      'DATE_TRAITEMENT_COP'=>$date,
                      'ID_UTILISATEUR_COP'=>$id_utilisateur
                     );
        
        $this->Modele->create('histo_traitement_constat',$data);
        $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id_historique ),array('ID_HISTORIQUE_STATUT'=>5)
       );
        $data['sms']='<div class="alert alert-success text-center" id ="sms">Opération faite avec succes.</div>';
  $this->session->set_flashdata($data);
  redirect(base_url('PSR/Commentaire/all_const'));
  // }

 }
 public function update($id)
 {
        $id_avis = $this->input->post('avis');
        $motif = $this->input->post('motif');
        $date =date('Y-m-d:H-i');
        $this->Modele->update('histo_traitement_constat', array('HISTO_TRAITEMENT_CONSTANT_ID'=>$id),array('ID_AVIS_PARTENAIRE'=>$id_avis,'ID_CONST_STATUT_TRAITE'=>2,'MOTIF'=>$motif,'DATE_TRAITEMENT_PARTENAIRE'=>$date)
       );

        $data['sms']='<div class="alert alert-success text-center" id ="sms">Opération faite avec succes.</div>';
  $this->session->set_flashdata($data);
  redirect(base_url('PSR/Commentaire/all_const'));
  // }

 }
  public function updateInstution($id)
 {
        $id_avis = $this->input->post('avis');
        $motif = $this->input->post('motif');
        $date =date('Y-m-d:H-i');
        $this->Modele->update('histo_traitement_constat', array('HISTO_TRAITEMENT_CONSTANT_ID'=>$id),array('ID_AVIS_PARTENAIRE'=>$id_avis,'ID_CONST_STATUT_TRAITE'=>5,'MOTIF'=>$motif,'DATE_TRAITEMENT_PARTENAIRE'=>$date)
       );

        $data['sms']='<div class="alert alert-success text-center" id ="sms">Opération faite avec succes.</div>';
  $this->session->set_flashdata($data);
  redirect(base_url('PSR/Commentaire/all_const'));
  // }

 }
 public function constant_partenaire()
 {
  
  $query_principal= "SELECT hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  WHERE  a.ID_UTILISATEUR=".$this->session->userdata('USER_ID');

  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

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
         $html.=" <select name='avis' id='avis' class='form-control'>
                   <option value=''>Sélectionner un assureur</option>";
                    foreach ($Avis as $value) { 
                     $html.="<option selected='' value='".$value['ID_AVIS_PARTENAIRE']." '>".$value['AVIS_PARTENAIRE']."</option>";
                    }
                 $html.="</select>";
        $data = array();
        foreach ($fetch_psr as $row) {
            $sub_array=array();
            $sub_array[] = $row->NUMERO_PLAQUE; 
             $sub_array[]= "<a target='_blank' href='" . $row->PHOTO_COMMANTAIRE . "' >".$row->COMMENTAIRE_TEXT."</a>";
            if (!empty($row->PHOTO_COMMANTAIRE)) {
         $sub_array[]= "<a target='_blank' href='" . $row->PHOTO_COMMANTAIRE . "' ><img style='width:20%' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
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
 public function constant_noTraite()
 {
  
  $query_principal= "SELECT hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  WHERE htc.ID_CONST_STATUT_TRAITE=1 AND a.ID_UTILISATEUR=".$this->session->userdata('USER_ID');

  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

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
         $Avis = $this->Model->getRequete('SELECT * FROM histo_consta_avis_partenaire WHERE ID_TYPE_VERIFICATION=2');


        $html="";
         $html.=" <select name='avis' id='avis' class='form-control'>
                   <option value=''>Sélectionner un avis</option>";
                    foreach ($Avis as $value) { 
                     $html.="<option  value='".$value['ID_AVIS_PARTENAIRE']." '>".$value['AVIS_PARTENAIRE']."</option>";
                    }
                 $html.="</select>";
        $data = array();
        foreach ($fetch_psr as $row) {
            $sub_array=array();
            $sub_array[] = $row->NUMERO_PLAQUE; 
             $sub_array[]= "<a target='_blank' href='" . $row->PHOTO_COMMANTAIRE . "' >".$row->COMMENTAIRE_TEXT."</a>";
            if (!empty($row->PHOTO_COMMANTAIRE)) {
         $sub_array[]= "<a target='_blank' href='" . $row->PHOTO_COMMANTAIRE . "' ><img style='width:20%' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
        }

        else{
         $sub_array[]= "Aucun";

        }
            $sub_array[] = $row->DATE_TRAITEMENT_COP;
             $option = '
              ';

                  $option .= "<div id='button1'><a  onclick='isChicked(".$row->ID_HISTORIQUE.",".$row->HISTO_TRAITEMENT_CONSTANT_ID .")' class='btn btn-outline-primary' href='#' data-toggle='modal'
              data-target='#mydelete" . $row->HISTO_TRAITEMENT_CONSTANT_ID . "'><font class='text-info'>&nbsp;&nbsp;Aviser</font></a></div>";
                  
                  $option .= " 
              </div>
              <div class='modal fade' id='mydelete" .  $row->HISTO_TRAITEMENT_CONSTANT_ID . "'>
              <div class='modal-dialog'>
              <div class='modal-content'>
              <div class='modal-header' style='background: black'>
                  <div id='title'><b><h4 id='donneTitre' style='color:#fff;font-size: 18px;'>Avis ".$row->NUMERO_PLAQUE." </h4>

                  </div>
                  <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
                   <span aria-hidden='true'>&times;</span>
                  </div>
              </div>
                 
              <div class='modal-body'>
                  <form action=".base_url('PSR/Commentaire/update/'.$row->HISTO_TRAITEMENT_CONSTANT_ID)." method='post' autocomplete='off'>
                   <div class='col-md-12 mt-4'>
                   <label>Avis</label>
                      ".$html."
                      </div> 
                   <div class='col-md-12 mt-4'>
                    <input type='text' value='' class='form-control' name='motif' id='motif' placeholder='Motif'> 
                   </div> 
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

 public function constant_noTraite_instution()
 {
  $id=$this->session->userdata('USER_ID');
  $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID,ass.ASSURANCE FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID LEFT JOIN assureur ass ON ass.ID_UTILISATEUR=u.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id);
   $query_principal= "";
   $Avis = array();
    
if($profil['PROFIL_ID']==3)
{
$Avis = $this->Model->getRequete('SELECT * FROM histo_consta_avis_partenaire WHERE ID_TYPE_VERIFICATION=1');
  $query_principal= "SELECT hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  WHERE tv.ID_TYPE_VERIFICATION=1 AND htc.ID_CONST_STATUT_TRAITE=1  " ;
}
else if($profil['PROFIL_ID']==4)
{
$Avis = $this->Model->getRequete('SELECT * FROM histo_consta_avis_partenaire WHERE ID_TYPE_VERIFICATION=4');

   $query_principal= "SELECT hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  WHERE tv.ID_TYPE_VERIFICATION=4 AND htc.ID_CONST_STATUT_TRAITE=1  " ;
}
else if($profil['PROFIL_ID']==5)
{
   $Avis = $this->Model->getRequete('SELECT * FROM histo_consta_avis_partenaire WHERE ID_TYPE_VERIFICATION=3');
   $query_principal= "SELECT hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  WHERE tv.ID_TYPE_VERIFICATION=3 AND htc.ID_CONST_STATUT_TRAITE=1  " ;
  
}
else if($profil['PROFIL_ID']==6)
{
   $Avis = $this->Model->getRequete('SELECT * FROM histo_consta_avis_partenaire WHERE ID_TYPE_VERIFICATION=6');
   $query_principal= "SELECT hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  WHERE tv.ID_TYPE_VERIFICATION=6 AND htc.ID_CONST_STATUT_TRAITE=1  " ;
  
}

  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

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

        $html="";
         $html.=" <select name='avis' id='avis' class='form-control'>
                   <option value=''>Sélectionner un assureur</option>";
                    foreach ($Avis as $value) { 
                     $html.="<option selected='' value='".$value['ID_AVIS_PARTENAIRE']." '>".$value['AVIS_PARTENAIRE']."</option>";
                    }
                 $html.="</select>";
        $data = array();
        foreach ($fetch_psr as $row) {
            $sub_array=array();
            $sub_array[] = $row->NUMERO_PLAQUE; 
             $sub_array[]= "<a target='_blank' href='" . $row->PHOTO_COMMANTAIRE . "' >".$row->COMMENTAIRE_TEXT."</a>";
            if (!empty($row->PHOTO_COMMANTAIRE)) {
         $sub_array[]= "<a target='_blank' href='" . $row->PHOTO_COMMANTAIRE . "' ><img style='width:20%' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
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
                  <form action=".base_url('PSR/Commentaire/updateInstution/'.$row->HISTO_TRAITEMENT_CONSTANT_ID)." method='post' autocomplete='off'>
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

 public function constant_avise_instution()
 {
  $id=$this->session->userdata('USER_ID');
  $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID,ass.ASSURANCE FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID LEFT JOIN assureur ass ON ass.ID_UTILISATEUR=u.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id);
   $query_principal= "";
if($profil['PROFIL_ID']==3)
{
  $Avis = $this->Model->getRequete('SELECT * FROM histo_consta_avis_partenaire WHERE ID_AVIS_PARTENAIRE=1');
  $query_principal= "SELECT h.DATE_INSERTION,hcap.AVIS_PARTENAIRE,htc.MOTIF,hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE    WHERE tv.ID_TYPE_VERIFICATION=1 AND htc.ID_CONST_STATUT_TRAITE=5  " ;
}
else if($profil['PROFIL_ID']==4)
{
   $query_principal= "SELECT h.DATE_INSERTION,hcap.AVIS_PARTENAIRE,htc.MOTIF,hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE   WHERE tv.ID_TYPE_VERIFICATION=4 AND htc.ID_CONST_STATUT_TRAITE=5  " ;
}
else if($profil['PROFIL_ID']==5)
{
   $query_principal= "SELECT h.DATE_INSERTION,hcap.AVIS_PARTENAIRE,htc.MOTIF,hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE  WHERE tv.ID_TYPE_VERIFICATION=3 AND htc.ID_CONST_STATUT_TRAITE=5  " ;
  
}
else 
{
   $query_principal= "SELECT h.DATE_INSERTION,hcap.AVIS_PARTENAIRE,htc.MOTIF,hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE    WHERE tv.ID_TYPE_VERIFICATION=6 AND htc.ID_CONST_STATUT_TRAITE=5  " ;
  
}

 $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

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
        $html="";
         // $html.=" <select name='avis' id='avis' class='form-control'>
         //           <option value=''>Sélectionner un assureur</option>";
         //            foreach ($Avis as $value) { 
         //             $html.="<option selected='' value='".$value['ID_AVIS_PARTENAIRE']." '>".$value['AVIS_PARTENAIRE']."</option>";
         //            }
         //         $html.="</select>";
        $data = array();
        foreach ($fetch_psr as $row) {
            $sub_array=array();
            $sub_array[] = $row->NUMERO_PLAQUE; 
             $sub_array[]= "<a target='_blank' href='" . $row->PHOTO_COMMANTAIRE . "' >".$row->COMMENTAIRE_TEXT."</a>";
            if (!empty($row->PHOTO_COMMANTAIRE)) {
         $sub_array[]= "<a target='_blank' href='" . $row->PHOTO_COMMANTAIRE . "' ><img style='width:20%' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
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
  public function constant_avis_parte()
 {
  
  $query_principal= "SELECT h.DATE_INSERTION,hcap.AVIS_PARTENAIRE,htc.MOTIF,hcc.PHOTO_COMMANTAIRE,h.ID_HISTORIQUE,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR  LEFT JOIN histo_consta_avis_partenaire hcap ON hcap.ID_AVIS_PARTENAIRE=htc.ID_AVIS_PARTENAIRE  WHERE  htc.ID_CONST_STATUT_TRAITE=2 AND a.ID_UTILISATEUR=".$this->session->userdata('USER_ID');

  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

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
         $html.=" <select name='avis' id='avis' class='form-control'>
                   <option value=''>Sélectionner un assureur</option>";
                    foreach ($Avis as $value) { 
                     $html.="<option selected='' value='".$value['ID_AVIS_PARTENAIRE']." '>".$value['AVIS_PARTENAIRE']."</option>";
                    }
                 $html.="</select>";
        $data = array();
        foreach ($fetch_psr as $row) {
            $sub_array=array();
            $sub_array[] = $row->NUMERO_PLAQUE; 
             $sub_array[]= "<a target='_blank' href='" . $row->PHOTO_COMMANTAIRE . "' >".$row->COMMENTAIRE_TEXT."</a>";
            if (!empty($row->PHOTO_COMMANTAIRE)) {
         $sub_array[]= "<a target='_blank' href='" . $row->PHOTO_COMMANTAIRE . "' ><img style='width:20%' src='" . $row->PHOTO_COMMANTAIRE . "'></a>";
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
  
  $query_principal= "SELECT h.DATE_INSERTION,hcst.DESCRIPTION_STATUT,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR LEFT JOIN histo_const_statut_traitement hcst ON hcst.ID_CONST_STATUT_TRAITE=htc.ID_CONST_STATUT_TRAITE WHERE 1";

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
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
            $sub_array[] = $row->NUMERO_PLAQUE; 
            $sub_array[] = $row->VERIFICATION;
            $sub_array[] = $row->ASSURANCE;
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
 public function constant_encours()
 {
  
    $query_principal= "SELECT h.DATE_INSERTION,hcst.DESCRIPTION_STATUT,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
      LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR LEFT JOIN histo_const_statut_traitement hcst ON hcst.ID_CONST_STATUT_TRAITE=htc.ID_CONST_STATUT_TRAITE WHERE h.ID_HISTORIQUE_STATUT=5 AND hcst.ID_CONST_STATUT_TRAITE=1 ";

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
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
            $sub_array[] = $row->NUMERO_PLAQUE; 
            $sub_array[] = $row->VERIFICATION;
            $sub_array[] = $row->ASSURANCE;
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
 public function constant_maintenir()
 {
  
    $query_principal= "SELECT h.DATE_INSERTION,hcst.DESCRIPTION_STATUT,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
      LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR LEFT JOIN histo_const_statut_traitement hcst ON hcst.ID_CONST_STATUT_TRAITE=htc.ID_CONST_STATUT_TRAITE WHERE hcst.ID_CONST_STATUT_TRAITE=5";

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
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
            $sub_array[] = $row->NUMERO_PLAQUE; 
            $sub_array[] = $row->VERIFICATION;
            $sub_array[] = $row->ASSURANCE;
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

 public function constant_annuler()
 {
  
    $query_principal= "SELECT h.DATE_INSERTION,hcst.DESCRIPTION_STATUT,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
      LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR LEFT JOIN histo_const_statut_traitement hcst ON hcst.ID_CONST_STATUT_TRAITE=htc.ID_CONST_STATUT_TRAITE WHERE hcst.ID_CONST_STATUT_TRAITE=4";

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
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
            $sub_array[] = $row->NUMERO_PLAQUE; 
            $sub_array[] = $row->VERIFICATION;
            $sub_array[] = $row->ASSURANCE;
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
  public function constant_valide()
 {
  
  $query_principal= "SELECT tv.ID_TYPE_VERIFICATION,h.ID_HISTORIQUE,h.DATE_INSERTION,hcst.DESCRIPTION_STATUT,htc.HISTO_TRAITEMENT_CONSTANT_ID, htc.ID_UTILISATEUR_COP,htc.ID_CONST_STATUT_TRAITE,htc.DATE_TRAITEMENT_COP,htc.DATE_TRAITEMENT_PARTENAIRE,htc.ID_AVIS_PARTENAIRE,htc.MOTIF,a.ASSURANCE,hco.COMMENTAIRE_TEXT,h.NUMERO_PLAQUE,tv.VERIFICATION FROM histo_traitement_constat htc LEFT JOIN historiques h ON h.ID_HISTORIQUE=htc.ID_HISTORIQUE
    LEFT JOIN type_verification tv ON tv.ID_TYPE_VERIFICATION=htc.ID_TYPE_VERIFICATION LEFT JOIN historique_commentaire_controls hcc ON hcc.HISTO_COMMENTAIRE_ID=htc.HISTO_COMMENTAIRE_ID  LEFT JOIN historique_commentaire hco ON hco.COMMENTAIRE_ID=hcc.COMMENTAIRE_ID  LEFT JOIN assureur a ON a.ID_ASSUREUR=htc.ID_ASSUREUR LEFT JOIN histo_const_statut_traitement hcst ON hcst.ID_CONST_STATUT_TRAITE=htc.ID_CONST_STATUT_TRAITE WHERE  hcst.ID_CONST_STATUT_TRAITE=3";

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
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
            $sub_array[] = $row->NUMERO_PLAQUE; 
            $sub_array[] = $row->VERIFICATION;
            $sub_array[] = $row->ASSURANCE;
            $sub_array[] = $row->COMMENTAIRE_TEXT;
            $sub_array[] = $row->DESCRIPTION_STATUT;
            $sub_array[] = $row->DATE_INSERTION;
            $option = '<div class="dropdown">
                       <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-cog"></i>
            Action<span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-menu-left">
              ';
                  
                   $option .= "<li><a class='btn-md'  href='#' data-toggle='modal'
                     data-target='#myAccepte" . $row->ID_HISTORIQUE . "'><font >&nbsp;&nbsp;Maintenir</font></a></li>";
                   $option .= "<li><a class='btn-md'  href='#' data-toggle='modal'
                     data-target='#mydelete" . $row->ID_HISTORIQUE . "'><font color='red'>&nbsp;&nbsp;Annuler</font></a></li>";
                  $option .= " </ul>
              </div>

               <div class='modal fade' id='mydelete" .  $row->ID_HISTORIQUE . "'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-body'>
                     <center><h5><strong>Voulez-vous Annuler?</strong> <br><b style='background-color:prink;color:green;'><i> Le constant de  type " . $row->VERIFICATION . " faite le " . $row->DATE_INSERTION . "</i></b></h5>
                     </center>
                    </div>

                    <div class='modal-footer'>
                    <a class='btn btn-outline-danger btn-md' href='" . base_url('PSR/Commentaire/canceler/' . $row->ID_HISTORIQUE .'/'.$row->ID_TYPE_VERIFICATION) . "'>Annuler</a>
                    <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
               </div>
             </div>
            </div>
          </div>
          <div class='modal fade' id='myAccepte" .  $row->ID_HISTORIQUE . "'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-body'>
                     <center><h5><strong>Voulez-vous Maintenir?</strong> <br><b style='background-color:prink;color:green;'><i> Le constant de  type " . $row->VERIFICATION . " faite le " . $row->DATE_INSERTION . "</i></b></h5>
                     </center>
                    </div>

                    <div class='modal-footer'>
                    
                    <a class='btn btn-outline-danger btn-md' href='" . base_url('PSR/Commentaire/maintenir/' . $row->ID_HISTORIQUE .'/'.$row->ID_TYPE_VERIFICATION) . "'>Annuler</a>
                    <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
               </div>
             </div>
            </div>
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

  public function canceler($id,$id2)
 {
  $Montant = $this->Modele->getRequeteOne('SELECT IMMATRICULATION_PEINE_MONTANT, ASSURANCE_PEINE_MONTANT,  CONTROLE_TECHNIQUE_PEINE_MONTANT,TRANSPORT_PEINE_MONTANT,VOL_PEINE_MONTANT,PERMIS_PEINE_MONTANT,MONTANT_TOTAL FROM historiques WHERE ID_HISTORIQUE='.$id);
   $query_principal= "";
   $Avis = array();
    
if($profil['PROFIL_ID']==3)
  $date =date('Y-m-d:H-i');

  if($id2==1)  
  { //TYPE DE VERIFICATION OBR
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array(' IS_ANNULE_OBR'=>1));

  }   
  else if($id2==2)  
  { //TYPE DE VERIFICATION ASSURANCE
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array('IS_ANNULE_ASSURANCE'=>1,'MONTANT_TOTAL'=>$Montant['MONTANT_TOTAL']-$Montant['ASSURANCE_PEINE_MONTANT']));
  } 
  else if($id2==3)  
  {
     //TYPE DE VERIFICATION OTRACO
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array('IS_ANNULE_CONTROL_TECH'=>1,'MONTANT_TOTAL'=>$Montant['MONTANT_TOTAL']-$Montant['CONTROLE_TECHNIQUE_PEINE_MONTANT']));
     
  }  
  else if($id2==4)  
  { //TYPE DE VERIFICATION PJ
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array('IS_ANNULE_PJ'=>1)) ; 
    
  } 
  else if($id2==5)  
  {
     //TYPE DE VERIFICATION INTERPOL
     // $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array(' IS_ANNULE_PERMIS'=>1)
    
  } 
  else if($id2==6)  
  {
  //TYPE DE VERIFICATION PSR
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array('IS_ANNULE_PERMIS'=>1));

  } 
  else if($id2==7)  
  {
     //TYPE DE VERIFICATION PARKING
  } 
  else if($id2==8)  
  {
     //TYPE DE VERIFICATION TRANSPORT
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array('IS_ANNULE_TRANSPORT'=>1)); 
  } 
       
         $this->Modele->update('histo_traitement_constat', array('ID_HISTORIQUE'=>$id),array('ID_CONST_STATUT_TRAITE'=>4,'DATE_TRAITEMENT_COP'=>$date));
 $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id_historique ),array('ID_HISTORIQUE_STATUT'=>6)
       );

        $data['sms']='<div class="alert alert-success text-center" id ="sms">Opération faite avec succes.</div>';
  $this->session->set_flashdata($data);
  redirect(base_url('PSR/Commentaire/all_const'));
  // }

 }

  public function maintenir($id,$id2)
 {
  $date =date('Y-m-d:H-i');
       

       if($id2==1)  
  { //TYPE DE VERIFICATION OBR
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array(' IS_ANNULE_OBR'=>0));

  }   
  else if($id2==2)  
  { //TYPE DE VERIFICATION ASSURANCE
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array(' IS_ANNULE_ASSURANCE'=>0));
  } 
  else if($id2==3)  
  {
     //TYPE DE VERIFICATION OTRACO
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array('IS_ANNULE_CONTROL_TECH'=>0));
     
  }  
  else if($id2==4)  
  { //TYPE DE VERIFICATION PJ
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array('IS_ANNULE_PJ'=>0)) ; 
    
  } 
  else if($id2==5)  
  {
     //TYPE DE VERIFICATION INTERPOL
     // $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array(' IS_ANNULE_PERMIS'=>1)
    
  } 
  else if($id2==6)  
  {
  //TYPE DE VERIFICATION PSR
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array('IS_ANNULE_PERMIS'=>0));

  } 
  else if($id2==7)  
  {
     //TYPE DE VERIFICATION PARKING
  } 
  else if($id2==8)  
  {
     //TYPE DE VERIFICATION TRANSPORT
     $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array('IS_ANNULE_TRANSPORT'=>0)); 
  } 
       
        $this->Modele->update('historiques', array('ID_HISTORIQUE'=>$id),array(' ID_HISTORIQUE_STATUT'=>3)
       );
         $this->Modele->update('histo_traitement_constat', array('ID_HISTORIQUE'=>$id),array('ID_CONST_STATUT_TRAITE'=>5,'DATE_TRAITEMENT_COP'=>$date)
       );

        $data['sms']='<div class="alert alert-success text-center" id ="sms">Opération faite avec succes.</div>';
  $this->session->set_flashdata($data);
  redirect(base_url('PSR/Commentaire/all_const'));
  // }

 }
}