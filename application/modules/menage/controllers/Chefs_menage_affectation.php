<?php

class Chefs_menage_affectation extends CI_Controller
{
     function __construct()
     {
          parent::__construct();
          $this->have_droit();
     }


     public function have_droit()
     {
          if ($this->session->userdata('GESTION_CHEF_MENAGE') != 1) {

               redirect(base_url());
          }
     }
     function index()
     {
          $data['title'] = "Affectation";
          $data['profils'] = $this->Model->getRequete('SELECT PROFIL_ID, STATUT FROM profil WHERE CODE_PROFIL=20 OR  CODE_PROFIL=21  OR  CODE_PROFIL=22 OR CODE_PROFIL=23 ORDER BY STATUT ASC');
          $this->load->view('chefs_menage_affect_List_view', $data);
     }
     function listing()
     {
          $PROFIL_ID = $this->input->post('PROFIL_ID');
          $critere_profil = !empty($PROFIL_ID) ? " AND u.PROFIL_ID=".$PROFIL_ID." ":"";
          $i = 1;
          $query_principal = "SELECT p.STATUT,p.PROFIL_ID,mca.ID_AFFECTATION,mca.DATE_DEBUT,mca.DATE_FIN,mc.NOM,mc.PRENOM,mc.IS_ACTIF,mc.DATE_INSERT,mc.PHOTO FROM menage_chefs mc JOIN menage_chef_affectations mca ON mca.ID_CHEF=mc.ID_CHEF LEFT JOIN  utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN profil p ON p.PROFIL_ID=u.PROFIL_ID  WHERE 1  " .$critere_profil ;


          $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
          $var_search=str_replace("'", "\'", $var_search);
          $limit = 'LIMIT 0,10';
          if ($_POST['length'] != -1) {
               $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
          }
          $order_by = '';

          $order_column = array('NOM', 'PRENOM', 'ID_AFFECTATION', 'DATE_DEBUT', 'DATE_FIN', 'STATUT', 'DATE_INSERT');

          $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM,PRENOM DESC';

          $search = !empty($_POST['search']['value']) ? ("AND NOM LIKE '%$var_search%'  OR PRENOM LIKE '%$var_search%'  ") : '';


          $critaire = '';

          $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
          $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;


          $fetch_psr = $this->Modele->datatable($query_secondaire);
          $data = array();

         
          foreach ($fetch_psr as $row) {
               $option = '<div class="dropdown ">
               <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
               <i class="fa fa-cog"></i>
               Action
               <span class="caret"></span></a>
               <ul class="dropdown-menu dropdown-menu-left">
               ';

               $option .= "<li><a hre='#'  id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='supprimer(".$row->ID_AFFECTATION.",this.title,this.id)' ><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
               $option .= "<li><a class='btn-md' href='" . base_url('menage/Chefs_menage_affectation/getOne/' . $row->ID_AFFECTATION) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
               $option .= " </ul></div>";
               $source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";

               $sub_array = array();
               $sub_array[] = '<table> <tbody><tr><td><a title="' . $source . '" href="#" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM . ' </td></tr></tbody></table></a>';
               $sub_array[] = $row->STATUT;
               // <font style="font-size:10px;color:red"><i class="far fa-comment-dots"></i></font>
                $sub_array[] = $this->get_lieu($row->ID_AFFECTATION,$row->PROFIL_ID);
               $sub_array[] = $row->DATE_DEBUT;
               $sub_array[] = $row->DATE_FIN;
               $sub_array[] = $row->IS_ACTIF==1 ?'<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
               $sub_array[] = $row->DATE_INSERT;
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

     function ajouter($ID_CHEF=0)
     {
          // $data['postes'] = $this->Modele->getRequete('SELECT `ID_AFFECTATION`,`LIEU_EXACTE` FROM `menage_chef_affectations` WHERE 1');
          $data['chefId']=$ID_CHEF;
          $data['polices'] = $this->Modele->getRequete('SELECT `ID_CHEF`, concat(`NOM`," ",`PRENOM`," (",`NUMERO_MATRICULE`,")") as PNB FROM  menage_chefs  WHERE ID_CHEF not IN (SELECT ID_CHEF FROM menage_chef_affectations) ORDER by `NOM`,`PRENOM`,`NUMERO_MATRICULE`');
          $data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
          $data['profils'] = $this->Model->getRequete('SELECT PROFIL_ID, CODE_PROFIL,STATUT FROM profil WHERE CODE_PROFIL=20 OR  CODE_PROFIL=21  OR  CODE_PROFIL=22 OR CODE_PROFIL=23   ORDER BY STATUT ASC');

          $data['title'] = "Nouvelle Affectation";

          $this->load->view('chefs_menage_affect_add_view', $data);
     }
    function get_lieu($id,$id_profil){
     $CODE_PROFIL = $this->Modele->getRequeteOne('SELECT CODE_PROFIL FROM profil WHERE PROFIL_ID = '.$id_profil);
      $Lieu_exacte='';
     if($CODE_PROFIL['CODE_PROFIL']==20){
           $lieu = $this->Modele->getRequeteOne('SELECT q.AVENUE_NAME AS Lieu FROM menage_chef_affectations   mca    LEFT JOIN syst_avenue q ON q.AVENUE_ID=mca.ID_AVENUE WHERE  mca.ID_AFFECTATION='.$id);
     }
     else if($CODE_PROFIL['CODE_PROFIL']==21){
       $lieu = $this->Modele->getRequeteOne('SELECT sz.ZONE_NAME as Lieu  FROM menage_chef_affectations   mca LEFT JOIN syst_zones sz ON sz.ZONE_ID=mca.ZONE_ID WHERE  mca.ID_AFFECTATION= '.$id);   
     }
     else if($CODE_PROFIL['CODE_PROFIL']==22){
         $lieu = $this->Modele->getRequeteOne('SELECT sco.COLLINE_NAME AS Lieu FROM menage_chef_affectations   mca LEFT JOIN syst_collines sco ON sco.COLLINE_ID=mca.COLLINE_ID  WHERE  mca.ID_AFFECTATION= '.$id);
     }
     else if($CODE_PROFIL['CODE_PROFIL']==23){
         $lieu = $this->Modele->getRequeteOne('SELECT  sp.PROVINCE_NAME as Lieu FROM menage_chef_affectations   mca LEFT JOIN syst_provinces sp ON sp.PROVINCE_ID=mca.PROVINCE_ID WHERE  mca.ID_AFFECTATION= '.$id); 
     }
     else{}
      return  !empty($lieu['Lieu']) ? $lieu['Lieu'] : 'N/A';
     }

     function add()
     {
         $zone=$this->input->post('ID_ZONE');
         $colline=$this->input->post('ID_COLLINE');
         $avenue=$this->input->post('ID_AVENUE');
         $autre=$this->input->post('AUTRE');
       $user = $this->Modele->getRequeteOne('SELECT mc.PHOTO,mc.NOM ,mc.PRENOM,mc.TELEPHONE,mc.EMAIL FROM menage_chefs mc WHERE mc.ID_CHEF= '. $this->input->post('ID_CHEF'));
       
          $PROFIL_ID = $this->Modele->getRequeteOne('SELECT PROFIL_ID FROM profil WHERE CODE_PROFIL = '. $this->input->post('CODE_PROFIL'));
         // print_r($PROFIL_ID['PROFIL_ID']);
         // exit();
     if(!empty($autre)){

           $data_User = array(
                    'NOM_UTILISATEUR' => $user['EMAIL'],
                    'MOT_DE_PASSE' => md5($user['TELEPHONE']),
                    'PROFIL_ID' => $PROFIL_ID['PROFIL_ID'],
                    'ICON_LOGO' => $user['PHOTO'],
                    'PSR_ELEMENT_ID' => $this->input->post('ID_CHEF'),
               );
             $table = 'utilisateurs';
            $idUsers = $this->Modele->insert_last_id($table, $data_User);
            $data_avenue = array(
          'AVENUE_NAME'=>$autre,
          'COLLINE_ID'=>$colline);
          $table = 'syst_avenue';
          $avenueId = $this->Modele->insert_last_id($table, $data_avenue);
          $data_insert = array(
          'ID_CHEF' => $this->input->post('ID_CHEF'),
          'DATE_DEBUT' => $this->input->post('DATE_DEBUT'),
          'DATE_FIN' => $this->input->post('DATE_FIN'),
          'PROVINCE_ID' => $this->input->post('ID_PROVINCE'),
          'COMMUNE_ID' => $this->input->post('ID_COMMUNE'),
          'ZONE_ID' => $zone ,
          'COLLINE_ID' => $colline ,
          'ID_AVENUE' => $avenueId,
          'ID_UTILISATEUR' => $idUsers
          );
          
          $table_affect = 'menage_chef_affectations';
          $this->Modele->create($table_affect, $data_insert);
              
               $subjet = 'creation de mot de passe';

               $message = $user['NOM'] . " " . $$user['PRENOM'] . ",<br>Vos ids de connexion sur application PSR sont<br>
               <div>nom d'utilisateur <b>" . $user['EMAIL'] . "</b><br>Mot de passe<b> " .$user['TELEPHONE']. "</b>
               ";


               $sms = ucfirst($user['NOM']) . " " . $$user['PRENOM'] . ",Vos ids sur PSR sont username:" . $user['EMAIL'] . "; password: " .$user['TELEPHONE']. "";

               
               //$this->send_sms_smpp(trim($telephone), $sms);
               $this->notifications->send_mail($user['EMAIL'], $subjet, null, $message, null);


          $data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
          $this->session->set_flashdata($data);
          redirect(base_url('menage/Chefs_menage_affectation/index'));
          }
          else{
         
           $user = $this->Modele->getRequeteOne('SELECT mc.PHOTO, mc.NOM ,mc.PRENOM,mc.TELEPHONE,mc.EMAIL FROM menage_chefs mc WHERE mc.ID_CHEF= '. $this->input->post('ID_CHEF'));
          
           $data_User = array(
                    'NOM_UTILISATEUR' => $user['EMAIL'],
                    'MOT_DE_PASSE' => md5($user['TELEPHONE']),
                    'ICON_LOGO' => $user['PHOTO'],
                    'PROFIL_ID' => $PROFIL_ID['PROFIL_ID'],
                    'PSR_ELEMENT_ID' => $this->input->post('ID_CHEF'),
               );
             $table = 'utilisateurs';
                       $idUsers = $this->Modele->insert_last_id($table, $data_User);

           $data_insert = array(
          'ID_CHEF' => $this->input->post('ID_CHEF'),
          'DATE_DEBUT' => $this->input->post('DATE_DEBUT'),
          'DATE_FIN' => $this->input->post('DATE_FIN'),
          'PROVINCE_ID' => $this->input->post('ID_PROVINCE'),
          'COMMUNE_ID' => $this->input->post('ID_COMMUNE'),
          'ZONE_ID' => $zone ? $zone :null,
          'COLLINE_ID' => $colline ? $colline :null,
          'ID_AVENUE' => $avenue ? $avenue :null,
          'ID_UTILISATEUR' => $idUsers

          // 'STATUT' => 1,
          );
          
           $table_affect = 'menage_chef_affectations';
          $this->Modele->create($table_affect, $data_insert);
               $subjet = 'creation de mot de passe';

               $message = $user['NOM'] . " " . $$user['PRENOM'] . ",<br>Vos ids de connexion sur application PSR sont<br>
               <div>nom d'utilisateur <b>" . $user['EMAIL'] . "</b><br>Mot de passe<b> " .$user['TELEPHONE']. "</b>
               ";


               $sms = ucfirst($user['NOM']) . " " . $$user['PRENOM'] . ",Vos ids sur PSR sont username:" . $user['EMAIL'] . "; password: " .$user['TELEPHONE']. "";

               
               //$this->send_sms_smpp(trim($telephone), $sms);
               $this->notifications->send_mail($user['EMAIL'], $subjet, null, $message, null);


          $data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
          $this->session->set_flashdata($data);
          redirect(base_url('menage/Chefs_menage_affectation/index'));

          }
         
     }


     function getOne($id = 0)
     {

          // $data['postes'] = $this->Modele->getRequete('SELECT `PSR_AFFECTATION_ID`,`LIEU_EXACTE` FROM `menage_chef_affectations` WHERE 1');

          $data['polices'] = $this->Modele->getRequete('SELECT `ID_CHEF`, concat(`NOM`," ",`PRENOM`," (",`NUMERO_MATRICULE`,")") as PNB FROM  menage_chefs  WHERE ID_CHEF  IN (SELECT ID_CHEF FROM menage_chef_affectations) ORDER by `NOM`,`PRENOM`,`NUMERO_MATRICULE`');
          $data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
          $data['profils'] = $this->Model->getRequete('SELECT PROFIL_ID, CODE_PROFIL,STATUT FROM profil WHERE CODE_PROFIL=20 OR  CODE_PROFIL=21  OR  CODE_PROFIL=22 OR CODE_PROFIL=23   ORDER BY STATUT ASC');

           $membre=$this->Model->getRequeteOne("SELECT p.CODE_PROFIL,mca.*,u.PROFIL_ID,p.CODE_PROFIL,DATE_FORMAT(mca.DATE_FIN, '%Y-%m-%d') AS dateFin,DATE_FORMAT(mca.DATE_DEBUT, '%Y-%m-%d') AS dateDebut  FROM menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN profil p ON p.PROFIL_ID=u.PROFIL_ID WHERE mca.ID_AFFECTATION=".$id);   
           // print_r($membre)  ;
           // exit();
         $data['membre']=$membre;
        $data['communes'] = $this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID=' . $membre['PROVINCE_ID'] . ' ORDER BY COMMUNE_NAME ASC');
          $data['zones'] = $this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID=' . $membre['COMMUNE_ID'] . ' ORDER BY ZONE_NAME ASC');
          $data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID=' . $membre['ZONE_ID'] . ' ORDER BY COLLINE_NAME ASC');
          if(!empty($membre['COLLINE_ID']))
          {
               $data['avenues'] = $this->Model->getRequete('SELECT AVENUE_ID,AVENUE_NAME FROM syst_avenue WHERE COLLINE_ID=' . $membre['COLLINE_ID'] . ' ORDER BY AVENUE_NAME ASC');
          }

          $data['title'] = "Modifier une Affectation";
          // print_r($data['membre']);
          // exit();
          $this->load->view('menage/chefs_menage_affect_update_view', $data);
     }


     function delete()
     {
          $table = "menage_chef_affectations";
          $table_users = "utilisateurs";

          $criteres['ID_AFFECTATION'] = $this->uri->segment(4);
          $user = $this->Modele->getRequeteOne('SELECT ID_UTILISATEUR FROM menage_chef_affectations  WHERE ID_AFFECTATION='.$this->uri->segment(4));
          $criteres_users['ID_UTILISATEUR'] = $user['ID_UTILISATEUR'];

          $data['rows'] = $this->Modele->delete($table, $criteres);
          $this->Modele->delete($table_users, $criteres_users);
          print_r(json_encode(1));
     }


     function update()
     {

          $ID_AFFECTATION =  $this->input->post('ID_AFFECTATION');
          $PROFIL_ID = $this->Modele->getRequeteOne('SELECT PROFIL_ID FROM profil WHERE CODE_PROFIL = '. $this->input->post('CODE_PROFIL'));
           $data_insert = array(
               'ID_CHEF' => $this->input->post('ID_CHEF'),
               'DATE_DEBUT' => $this->input->post('DATE_DEBUT'),
               'DATE_FIN' => $this->input->post('DATE_FIN'),
               'PROVINCE_ID' => $this->input->post('ID_PROVINCE'),
               'COMMUNE_ID' => $this->input->post('ID_COMMUNE'),
               'ZONE_ID' => $this->input->post('ID_ZONE'),
               'COLLINE_ID' => $this->input->post('ID_COLLINE'),
               'ID_AVENUE' => $this->input->post('ID_AVENUE'),
               // 'ID_PROFIL' => $PROFIL_ID['PROFIL_ID']
               // 'STATUT' => 1,
          );




          $don =  $this->Modele->update('menage_chef_affectations', array('ID_AFFECTATION' => $ID_AFFECTATION), $data_insert);


          $data['message'] = '<div class="alert alert-success text-center" id="message">Modification fait avec succès</div>';
          $this->session->set_flashdata($data);

          redirect(base_url('menage/Chefs_menage_affectation'));
     }
}
