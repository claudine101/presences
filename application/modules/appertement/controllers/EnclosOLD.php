<?php
/**
 *
 *	Element de la police 
 **/
class Enclos extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}


   public function replace($value='')
   {
   	$valueB = str_replace(' ','<span style="color:#fff">_</span>',$value);
   	return $valueB;
   }

	public function have_droit()
	{
		if ($this->session->userdata('CHEF_MENAGE') != 1) {

			redirect(base_url());
		}
	}
	function index()
	{
		$data['title'] = 'Enclos';
		$id_utilisateur = $this->session->userdata('USER_ID');

      $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      $data['profil'] =$profil['PROFIL_ID'];

      $lieu='';
      //CHEF DE SECTEUR
      if($profil['PROFIL_ID']==20){
       $name = $this->Model->getRequeteOne('SELECT sa.AVENUE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mca.ID_AVENUE  WHERE u.ID_UTILISATEUR='.$id_utilisateur);

       $lieu=' se trouvant dans l\'avenue:'.$name['name'];
       $data['name'] = $lieu ;
		 $this->load->view('Enclos_List_view', $data);
      }
      //CHEF DE QUARTIER
      else if($profil['PROFIL_ID']==22){
      	$name = $this->Model->getRequeteOne('SELECT sc.COLLINE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN  syst_collines sc ON sc.COLLINE_ID=mca.COLLINE_ID  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
         $lieu=' se trouvant dans le quartier:'.$name['name'];
      	$quartier = $this->Modele->getRequeteOne('SELECT mca.COLLINE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      	$data['avenues'] = $this->Model->getRequete('SELECT AVENUE_ID,AVENUE_NAME FROM syst_avenue WHERE COLLINE_ID='.$quartier ['COLLINE_ID'].' ORDER BY AVENUE_NAME ASC');
      	$data['name'] = $lieu ;
		 $this->load->view('Enclos_List_view', $data);
      	
      }
      //CHEF DE ZONE
      else if($profil['PROFIL_ID']==21){
      	$name = $this->Model->getRequeteOne('SELECT sz.ZONE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mca.ID_AVENUE LEFT JOIN syst_zones sz ON sz.ZONE_ID=mca.ZONE_ID  WHERE u.ID_UTILISATEUR='.$id_utilisateur);

         $lieu=' se trouvant dans la zone:'.$name['name'];
      	$zone = $this->Modele->getRequeteOne('SELECT mca.ZONE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      	$data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID='.$zone['ZONE_ID'].' ORDER BY COLLINE_NAME ASC');
      	$data['name'] = $lieu ;
		 $this->load->view('Enclos_List_view', $data);
      }
      else{
      	$data['name'] = '';
		$data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
		$data['roles'] = $this->Model->getRequete('SELECT ID_HABITANT_ROLE, NOM_ROLE FROM menage_habitants_roles WHERE 1  ORDER BY NOM_ROLE ASC');
		$data['eta_civils'] = $this->Model->getRequete('SELECT ID_ETAT_CIVIL, 	DESCRIPTION FROM menage_habitant_etat_civils WHERE 1  ORDER BY DESCRIPTION ASC');
		$data['fonctions'] = $this->Model->getRequete('SELECT ID_FONCTION, FONCTION_NAME FROM menage_habitant_fonctions WHERE 1  ORDER BY FONCTION_NAME ASC');
		 $this->load->view('Enclos_List_view', $data);

		 // $this->load->view('Habitant_all_view', $data);
      }
	}
	function listing()
	{
		$ID_PROVINCE = $this->input->post('ID_PROVINCE');
	    $ID_COMMUNE = $this->input->post('ID_COMMUNE');
	    $ID_ZONE = $this->input->post('ID_ZONE');
	    $ID_COLLINE = $this->input->post('ID_COLLINE');
	    $ID_AVENUE = $this->input->post('ID_AVENUE');


	    $critere_profil = "";
	    $critere_province = "";
	    $critere_commune = "";
	    $critere_zone = "";
	    $critere_colline = "";
	    $critere_avenue = "";


       
        $critere_province = !empty($ID_PROVINCE) ? "  AND sp.PROVINCE_ID=".$ID_PROVINCE." ":"";
        $critere_commune = !empty($ID_COMMUNE) ? "  AND sc.COMMUNE_ID=".$ID_COMMUNE." ":"";
        $critere_zone = !empty($ID_ZONE) ? "  AND sz.ZONE_ID=".$ID_ZONE." ":"";
        $critere_colline = !empty($ID_COLLINE) ? "  AND sco.COLLINE_ID=".$ID_COLLINE." ":"";
        $critere_avenue = !empty($ID_AVENUE) ? "  AND sa.AVENUE_ID=".$ID_AVENUE." ":"";
		$i = 1;
      $id_utilisateur = $this->session->userdata('USER_ID');
		$profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      $critere_lieu='';
      //CHEF DES SECTEUR
      if($profil['PROFIL_ID']==20 ){
      	//RECUPERATION DE L'AVENUE
         $avenue = $this->Modele->getRequeteOne('SELECT mca.ID_AVENUE  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
          $critere_lieu=' AND sa.AVENUE_ID='.$avenue['ID_AVENUE'];
      }
     //CHEF DE QUARTIER
     else if($profil['PROFIL_ID']==22)
     {
       $quartier = $this->Modele->getRequeteOne('SELECT mca.COLLINE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
          $critere_lieu=' AND sco.COLLINE_ID ='.$quartier['COLLINE_ID'];
     }
     //CHEF DE ZONE
     else if($profil['PROFIL_ID']==21)
     {
       $zone = $this->Modele->getRequeteOne('SELECT mca.ZONE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
       $critere_lieu=' AND sz.ZONE_ID ='.$zone['ZONE_ID'];
     }
     //MERE DE LA VILLE
     else 
     {
     	 $critere_lieu='';
     }
		$query_principal = 'SELECT mm.CODE_MAISON, mm.ADRESSE, mm.ID_MAISON, sa.AVENUE_NAME as avenue,u.NOM_CITOYEN,u.PRENOM_CITOYEN ,u.NUMERO_CITOYEN,u.NOM_UTILISATEUR, mm.DATE_INSERTION, sp.PROVINCE_NAME AS province, sc.COMMUNE_NAME AS commune ,sz.ZONE_NAME AS zone,mm.NUMERO_MAISON	, sco.COLLINE_NAME AS Colline FROM  menage_maisons mm LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mm.ID_AVENUE LEFT JOIN syst_collines sco ON sco.COLLINE_ID=mm.COLLINE_ID  LEFT JOIN syst_zones sz on sz.ZONE_ID=sco.ZONE_ID LEFT JOIN syst_communes sc ON sc.COMMUNE_ID=sz.COMMUNE_ID LEFT JOIN syst_provinces sp ON sp.PROVINCE_ID=sc.PROVINCE_ID  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mm.ID_UTILISATEUR WHERE 1 '.$critere_lieu.' ' .$critere_province.' '.$critere_commune.' '.$critere_zone.' '.$critere_colline .' '.$critere_avenue;

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$limit = 'LIMIT 0,10';
		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}
		$order_by = '';
		$order_column = array('NOM_CITOYEN', 'PRENOM_CITOYEN ', 'province', 'commune', 'zone', 'Colline', 'avenue', 'DATE_INSERTION');
		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_INSERTION ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM LIKE '%$var_search%' OR NOM_CITOYEN LIKE '%$var_search%' OR PRENOM_CITOYEN  LIKE '%$var_search%' OR NUMERO_MAISON  LIKE '%$var_search%' ") : '';

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

			$option .= "<li><a hre='#' ' id='".$row->PRENOM_CITOYEN ."'  title='".$row->NOM_CITOYEN ."'  onclick='supprimer_enclos(".$row->ID_MAISON.",this.title,this.id)'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";

			$option .= "<li><a class='btn-md' href='" . base_url('appertement/Enclos/getOne/' . $row->ID_MAISON) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= "<li></li>";
			$option .= "<li><a class='btn-md'  href='#' data-toggle='modal'
              data-target='#nouveau" . $row->ID_MAISON . "' ><label class='text-info'>Ajouter appertement</label></a></li>
			";
			$option .= " </ul>
			</div>
       <div class='modal fade' id='nouveau". $row->ID_MAISON."'>
          <div class='modal-dialog'>
          <div class='modal-content'>
          <div class='modal-header' style='background: black;'>
         <div id='title'><b><h4 id='appertement_titre' style='color:#fff;font-size: 18px;'>Nouveau appartement  dans l'enclos N°".$row->NUMERO_MAISON."</h4>
              
            </div>
            <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </div>
         </div>
          <div class='modal-body'>
           <form id='myForm".$row->ID_MAISON."' action=".base_url('appertement/Enclos/save') ." method='post' autocomplete='off'>
                <div class='col-md-6'>
                      <label for='FName'>N° appartement</label>
                      <input type='text' name='NUMERO_APPARTEMENT' autocomplete='off' id='NUMERO_APPARTEMENT	' value='' class='form-control'>
                     
                    </div>
                <div class='col-md-6'>
                      <label for='FName'>Nombre de Chambre</label>
                      <input type='hidden' name='ID_MAISON' autocomplete='off' id='ID_MAISON' value='".$row->ID_MAISON."' class='form-control'>
                      <input type='text' name='CHAMBRE' autocomplete='off' id='ADRESSE' value='' class='form-control'>
                     
                    </div>
          </div>
          <div class='modal-footer'>
          <button type='button' id='".$row->PRENOM_CITOYEN ."'  title='".$row->NOM_CITOYEN ."' onclick='subForm(".$row->ID_MAISON.",this.title,this.id)' class='btn btn-primary btn-md' >Enregistrer</button> </form> 
          <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter</button>
          </div>
          </div>
          </div>
          </div>
			";
			$source =  "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			$sub_array = array();
			$sub_array[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM_CITOYEN . ' ' . $row->PRENOM_CITOYEN . '</td></tr></tbody></table></a>';
			$sub_array[] = $row->NUMERO_CITOYEN;
			$sub_array[] = $row->NOM_UTILISATEUR;
			$sub_array[] = $row->NUMERO_MAISON	;
			$sub_array[] = $row->CODE_MAISON	?$row->CODE_MAISON:'N/A';
			$sub_array[] = $row->Colline.' ,'.$row->avenue.','.$row->ADRESSE;
			$sub_array[] = $row->province.' ,'.$row->commune.', '.$row->zone;
			$nbre = $this->getNbre_appertement($row->ID_MAISON);
            $nbre!=0 ?
            $sub_array[] ="<a class='btn-md' href='#' id='".$row->NUMERO_MAISON ."'  title='".$row->NUMERO_MAISON ."' onclick='getDetail(".$row->ID_MAISON.",this.title,this.id)'><label class='text-info'>&nbsp;&nbsp;".$nbre."</label><i class='fas fa-eye'></i></a>":$sub_array[]=$nbre;
			$sub_array[] = $row->DATE_INSERTION;
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
	function ajouter()
	{
		$data['title'] = 'Nouveau enclos';
		$id_utilisateur = $this->session->userdata('USER_ID');
      $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      $data['profil'] =$profil['PROFIL_ID'];
      $lieu='';
      //CHEF DE SECTEUR
      if($profil['PROFIL_ID']==20){
       $name = $this->Model->getRequeteOne('SELECT sa.AVENUE_ID,sa.COLLINE_ID ,sa.AVENUE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mca.ID_AVENUE  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
       // print_r( $name);
       // exit();
      $data['AVENUES'] =$name['AVENUE_ID'];
      $data['COLLINES'] =$name['COLLINE_ID'];
       $lieu=' se trouvant dans l\'avenue:'.$name['name'];
      }
      //CHEF DE QUARTIER
      else if($profil['PROFIL_ID']==22){
      	$name = $this->Model->getRequeteOne('SELECT sc.COLLINE_ID,sc.COLLINE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR   LEFT JOIN syst_collines sc ON sc.COLLINE_ID=mca.COLLINE_ID  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
         $data['COLLINES'] =$name['COLLINE_ID'];
        
         $lieu=' se trouvant dans le quartier:'.$name['name'];
      	$quartier = $this->Modele->getRequeteOne('SELECT mca.COLLINE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      	$data['avenues'] = $this->Model->getRequete('SELECT AVENUE_ID,AVENUE_NAME FROM syst_avenue WHERE COLLINE_ID='.$quartier ['COLLINE_ID'].' ORDER BY AVENUE_NAME ASC');
      }
      //CHEF DE ZONE
      else if($profil['PROFIL_ID']==21){
      	$name = $this->Model->getRequeteOne('SELECT sz.ZONE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN  syst_zones sz ON sz.ZONE_ID=mca.ZONE_ID  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
         $lieu=' se trouvant dans la zone:'.$name['name'];
      	$zone = $this->Modele->getRequeteOne('SELECT mca.ZONE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      	$data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID='.$zone['ZONE_ID'].' ORDER BY COLLINE_NAME ASC');
      }
      else{
		$data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
      }
      $data['name'] = $lieu ;
		$this->load->view('Enclos_add_view', $data);
	}

     function add()
     {
 
         $autre=$this->input->post('AUTRE');
         $userId='';
         $avenueId='';
         if(!empty($autre)){
	          $data_avenue = array(
	          'AVENUE_NAME'=>$autre,
	          'COLLINE_ID'=>$this->input->post('ID_COLLINE'));
	          $table = 'syst_avenue';
	          $avenueId = $this->Modele->insert_last_id($table, $data_avenue);
         }
         else{
            $avenueId=$this->input->post('ID_AVENUE');
         }
     	$user = $this->Modele->getRequeteOne("SELECT ID_UTILISATEUR, NOM_UTILISATEUR FROM utilisateurs   WHERE MOT_DE_PASSE='". md5($this->input->post('TELEPHONE')) ."'" );

     	if(!empty($user)){
          $userId=$user['ID_UTILISATEUR'];
     	}
     	else{
          $data_users = array(
          'NOM_UTILISATEUR'=>$this->input->post('EMAIL'),
          'MOT_DE_PASSE'=>md5($this->input->post('TELEPHONE')),
          'PROFIL_ID'=>7,
          'NOM_CITOYEN'=>$this->input->post('PRENOM'),
          'PRENOM_CITOYEN'=>$this->input->post('NOM'),
          'NUMERO_CITOYEN'=>$this->input->post('TELEPHONE'));
          $table = 'utilisateurs';
          $lastInsertId = $this->Modele->insert_last_id($table, $data_users);
          $userId=$lastInsertId ;
           $subjet = 'creation de mot de passe';

            $message =$this->input->post('NOM') . " ".$this->input->post('PRENOM'). ",<br>Vos ids de connexion sur application PSR sont<br>
               <div>nom d'utilisateur <b>" .$this->input->post('EMAIL') . "</b><br>Mot de passe<b> " .$this->input->post('TELEPHONE'). "</b> ";
            $sms = ucfirst($this->input->post('NOM')) . " " .$this->input->post('TELEPHONE'). ",Vos ids sur PSR sont username:" . $this->input->post('EMAIL') . "; password: ". $this->input->post('TELEPHONE'). "";

               
               //$this->send_sms_smpp(trim($telephone), $sms);
               $this->notifications->send_mail($this->input->post('EMAIL'), $subjet, null, $message, null);
     	}
          

          $code =date('YmdHis').''.$avenueId.''.$this->input->post('NUMERO_MAISON');
     	
          $data_enclos = array(
          'ID_UTILISATEUR'=>$userId,
          'COLLINE_ID'=>$this->input->post('ID_COLLINE'),
          'ID_AVENUE' =>$avenueId ,
          'ADRESSE' => $this->input->post('ADRESSE'),
	       'NUMERO_MAISON' => $this->input->post('NUMERO_MAISON'),
	       'CODE_MAISON'=>$code,
          'LONGITUDE'=>-1,
          'LATITUDE'=>-1
          );

          $table = 'menage_maisons';
			 $this->Modele->insert_last_id($table, $data_enclos);
          redirect(base_url('appertement/Enclos/index'));
          }
       function delete()
	   {
		$table = "menage_maisons";
		$criteres['ID_MAISON'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
		print_r(json_encode(1));
	  }
	  function delete_habitant()
     {
          $table = "menage_habitants";
          $criteres['ID_HABITANT'] = $this->uri->segment(4);
          $data['rows'] = $this->Modele->delete($table, $criteres);
          $this->Modele->delete($table, $criteres);
		    print_r(json_encode(1));
     }
	  function getOne($id = 0)
	{
		$membre = $this->Modele->getRequeteOne('SELECT * fROM  menage_maisons mm LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mm.ID_AVENUE LEFT JOIN syst_collines sco ON sco.COLLINE_ID=mm.COLLINE_ID  LEFT JOIN syst_zones sz on sz.ZONE_ID=sco.ZONE_ID LEFT JOIN syst_communes sc ON sc.COMMUNE_ID=sz.COMMUNE_ID LEFT JOIN syst_provinces sp ON sp.PROVINCE_ID=sc.PROVINCE_ID  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mm.ID_UTILISATEUR WHERE mm.ID_MAISON=' . $id);

	
		$data['membre'] = $membre;
		
     
     $id_utilisateur = $this->session->userdata('USER_ID');
      $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      $data['profil'] =$profil['PROFIL_ID'];
      $lieu='';
      //CHEF DE SECTEUR
      if($profil['PROFIL_ID']==20){
       $name = $this->Model->getRequeteOne('SELECT sa.AVENUE_ID,sa.COLLINE_ID ,sa.AVENUE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mca.ID_AVENUE  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
       // print_r( $name);
       // exit();
      $data['AVENUES'] =$name['AVENUE_ID'];
      $data['COLLINES'] =$name['COLLINE_ID'];
       $lieu=' se trouvant dans l\'avenue:'.$name['name'];
      }
      //CHEF DE QUARTIER
      else if($profil['PROFIL_ID']==22){
      	$name = $this->Model->getRequeteOne('SELECT sc.COLLINE_ID,sc.COLLINE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR   LEFT JOIN syst_collines sc ON sc.COLLINE_ID=mca.COLLINE_ID  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
         $data['COLLINES'] =$name['COLLINE_ID'];
        
         $lieu=' se trouvant dans le quartier:'.$name['name'];
      	$quartier = $this->Modele->getRequeteOne('SELECT mca.COLLINE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      	$data['avenues'] = $this->Model->getRequete('SELECT AVENUE_ID,AVENUE_NAME FROM syst_avenue WHERE COLLINE_ID='.$quartier ['COLLINE_ID'].' ORDER BY AVENUE_NAME ASC');
      }
      //CHEF DE ZONE
      else if($profil['PROFIL_ID']==21){
      	$name = $this->Model->getRequeteOne('SELECT sz.ZONE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN  syst_zones sz ON sz.ZONE_ID=mca.ZONE_ID  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
         $lieu=' se trouvant dans la zone:'.$name['name'];
      	$zone = $this->Modele->getRequeteOne('SELECT mca.ZONE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      	$data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID='.$zone['ZONE_ID'].' ORDER BY COLLINE_NAME ASC');
      	$data['avenues'] = $this->Model->getRequete('SELECT AVENUE_ID,AVENUE_NAME FROM syst_avenue WHERE COLLINE_ID='.$membre['COLLINE_ID'].' ORDER BY AVENUE_NAME ASC');
      }
      else{
      	$data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');

		$data['communes'] = $this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID=' . $membre['PROVINCE_ID'] . ' ORDER BY COMMUNE_NAME ASC');
		$data['zones'] = $this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID=' . $membre['COMMUNE_ID'] . ' ORDER BY ZONE_NAME ASC');
		$data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID=' . $membre['ZONE_ID'] . ' ORDER BY COLLINE_NAME ASC');
		$data['avenues'] = $this->Model->getRequete('SELECT AVENUE_ID,AVENUE_NAME FROM syst_avenue WHERE COLLINE_ID=' . $membre['COLLINE_ID'] . ' ORDER BY AVENUE_NAME ASC');
      }
		$data['title'] = "Modifier les informations d'un enclos";
		$this->load->view('Enclos_update_view', $data);
	}
	function update()
     {
		$id = $this->input->post('ID_MAISON');
		$phone_old = $this->input->post('phone_old');
		$phone = $this->input->post('phone');

         $autre=$this->input->post('AUTRE');
         $userId='';
         $avenueId='';
         if(!empty($autre)){
	          $data_avenue = array(
	          'AVENUE_NAME'=>$autre,
	          'COLLINE_ID'=>$this->input->post('ID_COLLINE'));
	          $table = 'syst_avenue';
	          $avenueId = $this->Modele->insert_last_id($table, $data_avenue);
         }
         else{
            $avenueId=$this->input->post('ID_AVENUE');
         }
     	
          $data_users = array(
          'NOM_UTILISATEUR'=>$this->input->post('EMAIL'),
          'MOT_DE_PASSE'=>md5($this->input->post('phone')),
          'PROFIL_ID'=>7,
          'NOM_CITOYEN'=>$this->input->post('PRENOM'),
          'PRENOM_CITOYEN'=>$this->input->post('NOM'),
          'NUMERO_CITOYEN'=>$this->input->post('phone'));
          
          $this->Modele->update('utilisateurs', array('NUMERO_CITOYEN' => $phone_old), $data_users);
          // $userId=$lastInsertId ;
           $subjet = 'creation de mot de passe';

               $message =$this->input->post('NOM') . " ".$this->input->post('PRENOM'). ",<br>Vos ids de connexion sur application PSR sont<br>
               <div>nom d'utilisateur <b>" .$this->input->post('EMAIL') . "</b><br>Mot de passe<b> " .$this->input->post('phone'). "</b>
               ";


               $sms = ucfirst($this->input->post('NOM')) . " " .$this->input->post('TELEPHONE'). ",Vos ids sur PSR sont username:" . $this->input->post('EMAIL') . "; password: ". $this->input->post('TELEPHONE'). "";

               
               //$this->send_sms_smpp(trim($telephone), $sms);
               $this->notifications->send_mail($this->input->post('EMAIL'), $subjet, null, $message, null);
         
          $data_enclos = array(
          'COLLINE_ID'=>$this->input->post('ID_COLLINE'),
          'ID_AVENUE' => $avenueId ,
          'ADRESSE' => $this->input->post('ADRESSE'),
          
          );
         
		$this->Modele->update('menage_maisons', array('ID_MAISON' => $id), $data_enclos);
          redirect(base_url('appertement/Enclos/index'));
          }

     function get_appartement($ID_MAISON){
          	$i = 1;
		$query_principal = 'SELECT ma.NUMERO_APPARTEMENT,mm.NUMERO_MAISON,ma.NUMERO_APPARTEMENT,ma.DATE_INSERTION,ma.ID_MAISON, ma.ID_APPARTEMENT,ma.NOMBRE_CHAMBRE  FROM menage_appartements ma Left join menage_maisons mm on mm.ID_MAISON=ma.ID_MAISON  WHERE mm.ID_MAISON='.$ID_MAISON;

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';


		$order_column = array('NUMERO_APPARTEMENT','NOMBRE_CHAMBRE','NUMERO_APPARTEMENT','DATE_INSERTION');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOMBRE_CHAMBRE ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NOMBRE_CHAMBRE LIKE '%$var_search%' OR NUMERO_APPARTEMENT LIKE '%$var_search%'") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_psr = $this->Modele->datatable($query_secondaire);
		$data = array();
        $no =0;
        $option='';
		foreach ($fetch_psr as $row) {
		 	$no++;
			$sub_array = array();
			$source =  "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			$respo = $this->get_responsable($row->ID_APPARTEMENT);
			$sub_array[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' .$respo.'</td></tr></tbody></table></a>';

			$sub_array[] = $row->NUMERO_APPARTEMENT;
			$nbre = $this->getNbre_habitant($row->ID_APPARTEMENT);
            $nbre!=0 ?
            $sub_array[] ="<a class='btn-md' href='#' id='".$row->NUMERO_MAISON."'  title='".$row->NUMERO_APPARTEMENT ."' onclick='getHabitant(".$row->ID_APPARTEMENT.",this.title,this.id)'><label class='text-info'>&nbsp;&nbsp;".$nbre."</label><i class='fas fa-eye'></i></a>":$sub_array[]=$nbre;
			$sub_array[] = $row->NOMBRE_CHAMBRE;
			$sub_array[] = $row->DATE_INSERTION;

			$option = "
			<div class='dropdown '>
				   <a class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown'>
				     <i class='fa fa-cog'></i>
				      Action
				      <span class='caret'></span>
				    </a>
			       <ul class='dropdown-menu dropdown-menu-lef'>
			       <li>
				       <a class='btn-md'  href='#' onclick='show_edit_modal(" . $row->ID_APPARTEMENT . ")' >
				       <label class='text-info'>&nbsp;&nbsp;Modifier</label>
				       </a>
			       </li>
			       <li>
			          <a class='btn-md' href='". base_url('appertement/Enclos/ajouter_habitant/' . $row->ID_APPARTEMENT) ."'><label class='text-info'>&nbsp;&nbsp;habitant <i class='nav-icon fas fa-plus'></i></label></a>
			        </li>
			        <li>
				        <a href='#' id='".$row->NUMERO_APPARTEMENT."' onclick='supprimer(".$row->ID_APPARTEMENT.",this.id)'><font color='red'>&nbsp;&nbsp;Supprimer</font>
				        </a>
			        </li>
			        </ul>
	            </div>

               <div class='modal fade' id='edit". $row->ID_APPARTEMENT."'>
                  <div class='modal-dialog'>
                    <div class='modal-content'>
                       <div class='modal-header' style='background: black;'>
                       <div id='title'><b><h4 id='appertement_titre' style='color:#fff;font-size: 18px;'>Modifier appartement  se trouvant dans l'enclos N°".$row->NUMERO_MAISON."</h4>
                        </div>
                           <div class='close' style='color:#fff' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                           </div>
                        </div>
                        <div class='modal-body'>
                           <form id='myForm_edit".$row->ID_APPARTEMENT."' action=".base_url('appertement/Enclos/update_appartement') ." method='post' autocomplete='off'>
                           <div class='col-md-6'>
	                              <label for='FName'>N° appartement</label>
	                              <input type='text'name='NUMERO_APPARTEMENT' autocomplete='off' id='NUMERO_APPARTEMENT' value='".$row->NUMERO_APPARTEMENT."' class='form-control'>
                             </div>
                             <div class='col-md-6'>
	                              <label for='FName'>Nombre de Chambre</label>
	                              <input type='hidden' name='ID_APPARTEMENT' autocomplete='off' id='ID_APPARTEMENT' value='".$row->ID_APPARTEMENT."' class='form-control'>
	                              <input type='text' name='NOMBRE_CHAMBRE' autocomplete='off' id='NOMBRE_CHAMBRE' value='".$row->NOMBRE_CHAMBRE."' class='form-control'>
                             </div>
                             <div class='modal-footer'>
                                 <button type='button' id='".$row->NOMBRE_CHAMBRE ."'  title='".$row->NUMERO_APPARTEMENT ."' onclick='subForm_edit(".$row->ID_APPARTEMENT.",this.title,this.id)' class='btn btn-primary btn-md' >Enregistrer
                                 </button> 
                         </form> 
                         <button class='btn btn-outline-primary btn-md' data-dismiss='modal'>Quitter
                         </button>
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
    public function save()
    {
       $ID_MAISON =$this->input->post('ID_MAISON');
       $CHAMBRE=$this->input->post('CHAMBRE');
       $NUMERO_APPARTEMENT	=$this->input->post('NUMERO_APPARTEMENT');
       $data = array('ID_MAISON' =>$ID_MAISON ,
                      'NOMBRE_CHAMBRE' =>$CHAMBRE,
                      'NUMERO_APPARTEMENT'=>$NUMERO_APPARTEMENT	
                     );  
        $this->Modele->create('menage_appartements',$data);
          redirect(base_url('appertement/Enclos/index'));

    }
    function getNbre_appertement($id)
    {
       $nbre = $this->Modele->getRequeteOne('SELECT mm.ID_MAISON, COUNT(ma.ID_APPARTEMENT) AS nbre FROM  menage_maisons mm LEFT JOIN menage_appartements ma ON ma.ID_MAISON=mm.ID_MAISON WHERE mm.ID_MAISON='.$id.' GROUP BY mm.ID_MAISON ');
      return  !empty($nbre['nbre']) ? $nbre['nbre'] : 0;

     }

     function getNbre_habitant($id)
    {
       $nbre = $this->Modele->getRequeteOne('SELECT ma.ID_APPARTEMENT,COUNT(mh.ID_HABITANT) as nbre FROM menage_habitants mh LEFT JOIN menage_appartement_habitants mah ON mah.ID_HABITANT=mh.ID_HABITANT LEFT JOIN menage_appartements ma ON ma.ID_APPARTEMENT=mah.ID_APPARTEMENT WHERE ma.ID_APPARTEMENT='.$id.' GROUP BY ma.ID_APPARTEMENT');
      return  !empty($nbre['nbre']) ? $nbre['nbre'] : 0;

     }
     function get_responsable($id)
     {
       $respo = $this->Modele->getRequeteOne('SELECT mh.NOM,mh.PRENOM FROM menage_habitants mh LEFT JOIN menage_appartement_habitants mah ON mah.ID_HABITANT=mh.ID_HABITANT LEFT JOIN menage_appartements ma ON ma.ID_APPARTEMENT=mah.ID_APPARTEMENT WHERE ma.ID_APPARTEMENT='.$id.' AND mah.ID_HABITANT_ROLE=1');
          return  $respo['NOM'].'  '.$respo['PRENOM'] ;

     }
    public function update_appartement()
    {
       $ID_APPARTEMENT =$this->input->post('ID_APPARTEMENT');
       $NUMERO_APPARTEMENT	 =$this->input->post('NUMERO_APPARTEMENT');
       $NOMBRE_CHAMBRE=$this->input->post('NOMBRE_CHAMBRE');
       $data = array( 'NOMBRE_CHAMBRE' =>$NOMBRE_CHAMBRE,'NUMERO_APPARTEMENT' => $NUMERO_APPARTEMENT);  
       $this->Modele->update('menage_appartements', array('ID_APPARTEMENT' => $ID_APPARTEMENT), $data);
          redirect(base_url('appertement/Enclos/index'));

    }
    public function delete_appartement()
    {
       $table = " menage_appartements";
		$criteres['ID_APPARTEMENT'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('appertement/Enclos/'));
    }
    public function supprimer($id)
    {
       $table = " menage_appartements";
		$criteres['ID_APPARTEMENT'] = $id;
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
        print_r(json_encode(1));
    }
     public function ajouter_habitant($id=0)
    {
    	$title="";
    	if(!empty($id)){
       $enclos = $this->Modele->getRequeteOne('SELECT ma.NUMERO_APPARTEMENT,mm.NUMERO_MAISON FROM menage_appartements ma LEFT JOIN menage_maisons mm ON mm.ID_MAISON=ma.ID_MAISON   WHERE ma.ID_APPARTEMENT='.$id);
          $title=" dans l'enclos N° ".$enclos['NUMERO_MAISON']." ,appertement N°  ".$enclos['NUMERO_APPARTEMENT'];
    	}
    	else{

    	}
    	$data['title'] = 'Nouveau habitant'.$title;
    	
    	$data['ID_APPARTEMENT'] =$id;
     $id_utilisateur = $this->session->userdata('USER_ID');
      $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      $data['profil'] =$profil['PROFIL_ID'];
      $lieu='';
      //CHEF DE SECTEUR
      if($profil['PROFIL_ID']==20){
       $name = $this->Model->getRequeteOne('SELECT sa.AVENUE_ID,sa.COLLINE_ID ,sa.AVENUE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mca.ID_AVENUE  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
       // print_r( $name);
       // exit();
      $data['AVENUES'] =$name['AVENUE_ID'];
      $data['COLLINES'] =$name['COLLINE_ID'];
       $lieu=' se trouvant dans l\'avenue:'.$name['name'];
       $data['appartement'] = $this->Model->getRequete('SELECT ma.NUMERO_APPARTEMENT,ma.ID_APPARTEMENT, ma.NOMBRE_CHAMBRE FROM menage_appartements ma  LEFT JOIN menage_maisons mm ON mm.ID_MAISON=ma.ID_MAISON LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mm.ID_AVENUE    WHERE sa.AVENUE_ID='.$name['AVENUE_ID']);
      }
      //CHEF DE QUARTIER
      else if($profil['PROFIL_ID']==22){
      	$name = $this->Model->getRequeteOne('SELECT sc.COLLINE_ID,sc.COLLINE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR   LEFT JOIN syst_collines sc ON sc.COLLINE_ID=mca.COLLINE_ID  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
         $data['COLLINES'] =$name['COLLINE_ID'];
        
         $lieu=' se trouvant dans le quartier:'.$name['name'];
      	$quartier = $this->Modele->getRequeteOne('SELECT mca.COLLINE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      	$data['avenues'] = $this->Model->getRequete('SELECT AVENUE_ID,AVENUE_NAME FROM syst_avenue WHERE COLLINE_ID='.$quartier ['COLLINE_ID'].' ORDER BY AVENUE_NAME ASC');
      	$data['appartement'] = $this->Model->getRequete('SELECT ma.ID_APPARTEMENT, ma.NOMBRE_CHAMBRE FROM menage_appartements ma  LEFT JOIN menage_maisons mm ON mm.ID_MAISON=ma.ID_MAISON LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mm.ID_AVENUE LEFT JOIN syst_collines sc ON sc.COLLINE_ID=sa.COLLINE_ID   WHERE sc.COLLINE_ID='.$quartier['COLLINE_ID']);
      }
      //CHEF DE ZONE
      else if($profil['PROFIL_ID']==21){
      	$name = $this->Model->getRequeteOne('SELECT sz.ZONE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN  syst_zones sz ON sz.ZONE_ID=mca.ZONE_ID  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
         $lieu=' se trouvant dans la zone:'.$name['name'];
      	$zone = $this->Modele->getRequeteOne('SELECT mca.ZONE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      	$data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID='.$zone['ZONE_ID'].' ORDER BY COLLINE_NAME ASC');
      	$data['appartement'] = $this->Model->getRequete('SELECT ma.ID_APPARTEMENT, ma.NOMBRE_CHAMBRE FROM menage_appartements ma  LEFT JOIN menage_maisons mm ON mm.ID_MAISON=ma.ID_MAISON LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mm.ID_AVENUE LEFT JOIN syst_collines sc ON sc.COLLINE_ID=sa.COLLINE_ID  LEFT JOIN syst_zones sz ON sz.ZONE_ID=sc.ZONE_ID  WHERE sz.ZONE_ID='.$zone['ZONE_ID']);
      }
      else{
		$data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
		$data['appartement'] = $this->Model->getRequete('SELECT ma.ID_APPARTEMENT, ma.NOMBRE_CHAMBRE FROM menage_appartements ma  WHERE 1');
      }
      $data['name'] = $lieu ;

		$data['roles'] = $this->Model->getRequete('SELECT ID_HABITANT_ROLE, NOM_ROLE FROM menage_habitants_roles WHERE 1  ORDER BY NOM_ROLE ASC');
		$data['eta_civils'] = $this->Model->getRequete('SELECT ID_ETAT_CIVIL, 	DESCRIPTION FROM menage_habitant_etat_civils WHERE 1  ORDER BY DESCRIPTION ASC');
		$data['fonctions'] = $this->Model->getRequete('SELECT ID_FONCTION, FONCTION_NAME FROM menage_habitant_fonctions WHERE 1  ORDER BY FONCTION_NAME ASC');
		
		$this->load->view('Habitant_add_view', $data);
    }








// habitant






    function add_habitant()
	{
		$this->form_validation->set_rules('NOM', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PRENOM', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('CNI', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DATE_DELIVRANCE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PERE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
	    $this->form_validation->set_rules('MERE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
	    $this->form_validation->set_rules('NUMERO_TELEPHONE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DATE_NAISSANCE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		

		if ($this->form_validation->run() == FALSE) {
			$this->ajouter_habitant();
		} else {


			$file = $_FILES['PHOTO'];
			$path = './uploads/Gestion_Publication_Menu/';
			if (!is_dir(FCPATH . '/uploads/Gestion_Publication_Menu/')) {
				mkdir(FCPATH . '/uploads/Gestion_Publication_Menu/', 0777, TRUE);
			}

			$thepath = base_url() . 'uploads/Gestion_Publication_Menu/';
			$config['upload_path'] = './uploads/Gestion_Publication_Menu/';
			$photonames = date('ymdHisa');
			$config['file_name'] = $photonames;
			$config['allowed_types'] = '*';
			$this->upload->initialize($config);
			$this->upload->do_upload("PHOTO");
			$info = $this->upload->data();

			if ($file == '') {
				$pathfile = base_url() . 'uploads/sevtb.png';
			} else {
				$pathfile = base_url() . '/uploads/Gestion_Publication_Menu/' . $photonames . $info['file_ext'];
			}


			$camerasImage = $this->input->post('ImageLink');

			if (!empty($camerasImage)) {

				$dir = FCPATH.'/uploads/cameraImagePsr/';
			      if (!is_dir(FCPATH . '/uploads/cameraImagePsr/')) {
				  mkdir(FCPATH . '/uploads/cameraImagePsr/', 0777, TRUE);
			    }

                $photonames = date('ymdHisa');
                $pathfile = base_url() . 'uploads/cameraImagePsr/' . $photonames .".png";
			    $pathfiless = FCPATH . '/uploads/cameraImagePsr/' . $photonames .".png";
			    $file_name = $photonames .".png";

			    $img = $this->input->post('ImageLink'); // Your data 'data:image/png;base64,AAAFBfj42Pj4';
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                file_put_contents($pathfiless, $data);

				//echo "<img src='".$path."' >";
				
			}
		$autre=$this->input->post('AUTRE');
         $avenueId='';
		if(!empty($autre)){
         $data_avenue = array(
          'AVENUE_NAME'=>$autre,
          'COLLINE_ID'=>$this->input->post('ID_COLLINE'));
          $table = 'syst_avenue';
          $avenueId = $this->Modele->insert_last_id($table, $data_avenue);
        }
        else{
        	$avenueId =$this->input->post('ID_AVENUE');
        }

$data_insert = array(

	'NOM' => $this->input->post('NOM'),
	'PRENOM' => $this->input->post('PRENOM'),
	'NUMERO_IDENTITE' => $this->input->post('CNI'),
	'LIEU_DELIVRANCE' => $this->input->post('LIEU_DELIVRANCE'),
	'DATE_DELIVRANCE' => $this->input->post('DATE_DELIVRANCE'),
	'PERE' => $this->input->post('PERE'),
	'MERE' => $this->input->post('MERE'),
	'NUMERO_TELEPHONE' => $this->input->post('NUMERO_TELEPHONE'),
	'COLLINE_ID' => $this->input->post('ID_COLLINE'),
	'ID_AVENUE' => $avenueId,
	'DATE_NAISSANCE' => $this->input->post('DATE_NAISSANCE'),
	'ID_SEXE' => $this->input->post('SEXE'),
	'ID_ETAT_CIVIL' => $this->input->post('ID_ETAT_CIVIL'),
	'ID_FONCTION' => $this->input->post('ID_FONCTION'),
	'PHOTO' => $pathfile
);

			$table = 'menage_habitants';
			$idHabitant = $this->Modele->insert_last_id($table, $data_insert);

		$data_appa = array(
          'ID_APPARTEMENT'=>$this->input->post('ID_APPARTEMENT'),
          'ID_HABITANT'=>$idHabitant,
          'ID_HABITANT_ROLE'=>$this->input->post('ID_HABITANT_ROLE')
          );
         $table = 'menage_appartement_habitants';
         $this->Modele->insert_last_id($table, $data_appa);
		
		$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('appertement/Enclos/'));
		}
	}
	function habitant()
	{
		$data['title'] = 'Habitant';
		$id_utilisateur = $this->session->userdata('USER_ID');

      $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      $data['profil'] =$profil['PROFIL_ID'];
      $lieu='';
      //CHEF DE SECTEUR
      if($profil['PROFIL_ID']==20){
       $name = $this->Model->getRequeteOne('SELECT sa.AVENUE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mca.ID_AVENUE  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
       $lieu=' se trouvant dans l\'avenue:'.$name['name'];
      }
      //CHEF DE QUARTIER
      else if($profil['PROFIL_ID']==22){
      	$name = $this->Model->getRequeteOne('SELECT sc.COLLINE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN  syst_collines sc ON sc.COLLINE_ID=mca.COLLINE_ID  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
         $lieu=' se trouvant dans le quartier:'.$name['name'];
      	$quartier = $this->Modele->getRequeteOne('SELECT mca.COLLINE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      	$data['avenues'] = $this->Model->getRequete('SELECT AVENUE_ID,AVENUE_NAME FROM syst_avenue WHERE COLLINE_ID='.$quartier ['COLLINE_ID'].' ORDER BY AVENUE_NAME ASC');
      	
      }
      //CHEF DE ZONE
      else if($profil['PROFIL_ID']==21){
      	$name = $this->Model->getRequeteOne('SELECT sz.ZONE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mca.ID_AVENUE LEFT JOIN syst_zones sz ON sz.ZONE_ID=mca.ZONE_ID  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
         $lieu=' se trouvant dans la zone:'.$name['name'];
      	$zone = $this->Modele->getRequeteOne('SELECT mca.ZONE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      	$data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID='.$zone['ZONE_ID'].' ORDER BY COLLINE_NAME ASC');
      }
      else{
      	$lieu='';
		$data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
      }
      $data['name'] = $lieu ;
		$data['roles'] = $this->Model->getRequete('SELECT ID_HABITANT_ROLE, NOM_ROLE FROM menage_habitants_roles WHERE 1  ORDER BY NOM_ROLE ASC');
		$data['eta_civils'] = $this->Model->getRequete('SELECT ID_ETAT_CIVIL, 	DESCRIPTION FROM menage_habitant_etat_civils WHERE 1  ORDER BY DESCRIPTION ASC');
		$data['fonctions'] = $this->Model->getRequete('SELECT ID_FONCTION, FONCTION_NAME FROM menage_habitant_fonctions WHERE 1  ORDER BY FONCTION_NAME ASC');

		//-----------------POUR LES VALIDATIONS-------------------------
		$id_utilisateur = $this->session->userdata('USER_ID');
      $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);
        
      //CHEF DES SECTEUR
      if($profil['PROFIL_ID']==20 ){
      	//RECUPERATION DE L'AVENUE
         $secteur = $this->Modele->getRequeteOne('SELECT mca.ID_AVENUE  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);

         $Nbre_nouveau = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM  menage_habitants mh  WHERE ID_HABITANT NOT IN (SELECT ID_HABITANT FROM histo_validation_habitant WHERE 1 ) AND mh.ID_AVENUE= '.$secteur['ID_AVENUE']);
         $Nbre_valide = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_validation_habitant hvh LEFT JOIN menage_habitants mh ON mh.ID_HABITANT=hvh.ID_HABITANT  WHERE ID_STATUT=1 AND mh.ID_AVENUE='.$secteur['ID_AVENUE']);
         $Nbre_rejette = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM histo_validation_habitant hvh LEFT JOIN menage_habitants mh ON mh.ID_HABITANT=hvh.ID_HABITANT  WHERE ID_STATUT=4 AND mh.ID_AVENUE='.$secteur['ID_AVENUE']);
      
      $data['Nbre_nouveau']=$Nbre_nouveau['Nombre'];
      $data['Nbre_valide']=$Nbre_valide['Nombre'];
      $data['Nbre_rejette']=$Nbre_rejette['Nombre'];
	$this->load->view('Habitant_List_view', $data);

      // print_r($data['Nbre_nouveau']);
      // exit();
         
      }
     //CHEF DE QUARTIER
     else if($profil['PROFIL_ID']==22)
     {
       $quartier = $this->Modele->getRequeteOne('SELECT mca.COLLINE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
          
         $Nbre_nouveau = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM  menage_habitants mh  LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mh.ID_AVENUE
             LEFT JOIN syst_collines sc ON sc.COLLINE_ID=sa.COLLINE_ID LEFT JOIN  histo_validation_habitant hvh ON hvh.ID_HABITANT=mh.ID_HABITANT
              WHERE hvh.ID_STATUT=1  AND sc.COLLINE_ID= '.$quartier['COLLINE_ID']);

         $Nbre_valide = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM  menage_habitants mh  LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mh.ID_AVENUE
             LEFT JOIN syst_collines sc ON sc.COLLINE_ID=sa.COLLINE_ID LEFT JOIN  histo_validation_habitant hvh ON hvh.ID_HABITANT=mh.ID_HABITANT
              WHERE hvh.ID_STATUT=2  AND sc.COLLINE_ID= '.$quartier['COLLINE_ID']);
         $Nbre_rejette = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM  menage_habitants mh  LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mh.ID_AVENUE
             LEFT JOIN syst_collines sc ON sc.COLLINE_ID=sa.COLLINE_ID LEFT JOIN  histo_validation_habitant hvh ON hvh.ID_HABITANT=mh.ID_HABITANT
              WHERE hvh.ID_STATUT=4  AND sc.COLLINE_ID= '.$quartier['COLLINE_ID']);
      
      $data['Nbre_nouveau']=$Nbre_nouveau['Nombre'];
      $data['Nbre_valide']=$Nbre_valide['Nombre'];
      $data['Nbre_rejette']=$Nbre_rejette['Nombre'];
	$this->load->view('Habitant_List_view', $data);
     
     }
     //CHEF DE ZONE
     else if($profil['PROFIL_ID']==21)
     {
       $zone = $this->Modele->getRequeteOne('SELECT mca.ZONE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
       $Nbre_nouveau = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM  menage_habitants mh  LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mh.ID_AVENUE LEFT JOIN syst_collines sc ON sc.COLLINE_ID=sa.COLLINE_ID LEFT JOIN  histo_validation_habitant hvh ON hvh.ID_HABITANT=mh.ID_HABITANT LEFT JOIN syst_zones sz on sz.ZONE_ID=sc.ZONE_ID WHERE hvh.ID_STATUT=2  AND sz.ZONE_ID='.$zone['ZONE_ID']);

         $Nbre_valide = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM  menage_habitants mh  LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mh.ID_AVENUE LEFT JOIN syst_collines sc ON sc.COLLINE_ID=sa.COLLINE_ID LEFT JOIN  histo_validation_habitant hvh ON hvh.ID_HABITANT=mh.ID_HABITANT LEFT JOIN syst_zones sz on sz.ZONE_ID=sc.ZONE_ID WHERE hvh.ID_STATUT=3  AND sz.ZONE_ID='.$zone['ZONE_ID']);

         $Nbre_rejette = $this->Modele->getRequeteOne('SELECT COUNT(*) AS Nombre FROM  menage_habitants mh  LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mh.ID_AVENUE LEFT JOIN syst_collines sc ON sc.COLLINE_ID=sa.COLLINE_ID LEFT JOIN  histo_validation_habitant hvh ON hvh.ID_HABITANT=mh.ID_HABITANT LEFT JOIN syst_zones sz on sz.ZONE_ID=sc.ZONE_ID WHERE hvh.ID_STATUT=4  AND sz.ZONE_ID='.$zone['ZONE_ID']);

         $data['Nbre_nouveau']=$Nbre_nouveau['Nombre'];
         $data['Nbre_valide']=$Nbre_valide['Nombre'];
         $data['Nbre_rejette']=$Nbre_rejette['Nombre'];
	$this->load->view('Habitant_List_view', $data);

     }
     //MERE DE LA VILLE
     else 
     {
	   $this->load->view('Habitant_all_view', $data);
     	 
     }
	//-----------------FIN POUR LES VALIDATIONS-------------------------
	}

	//HABITANT NOUVEAU
   function listing_habitant_nouveau($ID_APPARTEMENT=0)
	{
		$id_utilisateur = $this->session->userdata('USER_ID');
		$profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      $critere_lieu='';
      $critere_nouveau='';

      //CHEF DES SECTEUR
      if($profil['PROFIL_ID']==20 ){
      	//RECUPERATION DE L'AVENUE
         $avenue = $this->Modele->getRequeteOne('SELECT mca.ID_AVENUE  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
          $critere_lieu=' AND mh.ID_AVENUE='.$avenue['ID_AVENUE'];
          $critere_nouveau=' WHERE  mh.ID_HABITANT NOT IN (SELECT ID_HABITANT FROM histo_validation_habitant WHERE 1)   ';
      }
     //CHEF DE QUARTIER
     else if($profil['PROFIL_ID']==22)
     {
       $quartier = $this->Modele->getRequeteOne('SELECT mca.COLLINE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
          $critere_lieu=' AND sco.COLLINE_ID ='.$quartier['COLLINE_ID'];
          $critere_nouveau=' LEFT JOIN histo_validation_habitant hvh ON hvh.ID_HABITANT=mh.ID_HABITANT WHERE hvh.ID_STATUT=1';
     }
     //CHEF DE ZONE
     else if($profil['PROFIL_ID']==21)
     {
       $zone = $this->Modele->getRequeteOne('SELECT mca.ZONE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
       $critere_lieu=' AND sz.ZONE_ID ='.$zone['ZONE_ID'];
       $critere_nouveau=' LEFT JOIN histo_validation_habitant hvh ON hvh.ID_HABITANT=mh.ID_HABITANT WHERE hvh.ID_STATUT=2';

     }
     //MERE DE LA VILLE
     else 
     {
     	 $critere_lieu='';

     }
       $ID_PROVINCE = $this->input->post('ID_PROVINCE');
	    $ID_COMMUNE = $this->input->post('ID_COMMUNE');
	    $ID_ZONE = $this->input->post('ID_ZONE');
	    $ID_COLLINE = $this->input->post('ID_COLLINE');
	    $ID_FONCTION = $this->input->post('ID_FONCTION');
	    $ID_HABITANT_ROLE = $this->input->post('ID_HABITANT_ROLE');

	    $critere_profil = "";
	    $critere_province = "";
	    $critere_commune = "";
	    $critere_zone = "";
	    $critere_colline = "";
	    $critere_fonction = "";
	    $critere_role = "";

        $critere_province = !empty($ID_PROVINCE) ? "  AND sp.PROVINCE_ID=".$ID_PROVINCE." ":"";
        $critere_commune = !empty($ID_COMMUNE) ? "  AND sc.COMMUNE_ID=".$ID_COMMUNE." ":"";
        $critere_zone = !empty($ID_ZONE) ? "  AND sz.ZONE_ID=".$ID_ZONE." ":"";
        $critere_colline = !empty($ID_COLLINE) ? "  AND sco.COLLINE_ID=".$ID_COLLINE." ":"";
        $critere_fonction = !empty($ID_FONCTION) ? "  AND mhf.ID_FONCTION=".$ID_FONCTION." ":"";
        $critere_role = !empty($ID_HABITANT_ROLE) ? "  AND mhr.ID_HABITANT_ROLE=".$ID_HABITANT_ROLE." ":"";
		$i = 1;
		$query_principal = 'SELECT mh.IMAGE1_CNI,mh.IMAGE2_CNI,mh.IMAGE_MERE,mh.IMAGE_PERE,mh.ID_HABITANT, mh.ID_HABITANT,mh.NOM,mh.PRENOM ,mh.NUMERO_IDENTITE,mh.DATE_DELIVRANCE,mh.LIEU_DELIVRANCE,mh.PERE,mh.MERE,mh.NUMERO_TELEPHONE,mh.DATE_NAISSANCE,mh.PHOTO, mh.ID_SEXE,sp.PROVINCE_NAME AS province, sc.COMMUNE_NAME AS commune ,sz.ZONE_NAME AS zone, sco.COLLINE_NAME AS Colline ,sa.AVENUE_NAME AS avenue ,mhf.FONCTION_NAME,mhec.DESCRIPTION,mhr.NOM_ROLE FROM  menage_habitants mh    LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mh.ID_AVENUE LEFT JOIN syst_collines sco  ON  sco.COLLINE_ID=sa.COLLINE_ID LEFT JOIN syst_zones sz on sz.ZONE_ID=sco.ZONE_ID LEFT JOIN syst_communes sc ON sc.COMMUNE_ID=sz.COMMUNE_ID  LEFT JOIN syst_provinces sp ON sc.PROVINCE_ID=sp.PROVINCE_ID  LEFT JOIN  menage_habitant_fonctions mhf on mhf.ID_FONCTION=mh.ID_FONCTION LEFT JOIN menage_habitant_etat_civils mhec ON mhec.ID_ETAT_CIVIL=mh.ID_ETAT_CIVIL LEFT JOIN menage_appartement_habitants mah ON mah.ID_HABITANT=mh.ID_HABITANT LEFT JOIN menage_appartements ma ON ma.ID_APPARTEMENT=mah.ID_APPARTEMENT LEFT JOIN menage_habitants_roles mhr ON mhr.ID_HABITANT_ROLE=mah.ID_HABITANT_ROLE '. $critere_nouveau.''.$critere_lieu.' '.$critere_province.' '.$critere_commune.' '.$critere_zone.' '.$critere_colline.' '.$critere_fonction .' '.$critere_role;

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';


		$order_column = array('NOM', 'PRENOM', 'NUMERO_IDENTITE', 'LIEU_DELIVRANCE', 'DATE_DELIVRANCE', 'PERE', 'MERE', 'NUMERO_TELEPHONE', 'colline', 'avenue','province', 'commune', 'zone', 'DATE_NAISSANCE', 'SEXE', 'DESCRIPTION', 'FONCTION_NAME', 'NOM_ROLE');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM,PRENOM ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM LIKE '%$var_search%' OR PRENOM LIKE '%$var_search%' OR NUMERO_IDENTITE LIKE '%$var_search%'  ") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by ;
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

			$option .= "<li><a hre='#' id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='supprimer(".$row->ID_HABITANT.",this.title,this.id) '><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('appertement/Enclos/getOne_habitant/' . $row->ID_HABITANT) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			
			$option .= "<li><a hre='#' id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='valider(".$row->ID_HABITANT.",this.title,this.id) '><label class='text-info'>&nbsp;&nbsp;Visiter</label></a></li>";
			$option .= "<li><a hre='#' id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='soupçonner(".$row->ID_HABITANT.",this.title,this.id) '><label class='text-info'>&nbsp;&nbsp;soupçonner</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_HABITANT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->ID_SEXE . "," . $row->NOM . " " . $row->PRENOM . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('appertement/Enclos/delete_habitant/' . $row->ID_HABITANT) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			$sourceParents = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
	
         

			$sub_array = array();
			$sub_array[] = '<table> <tbody><tr><td><a href="#"  title="'  . $source . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM . '</td></tr></tbody></table></a>';
			
			$sub_array[] = '<table> <tbody><tr>
			<td><a href="#""  title="'  . $row->IMAGE1_CNI . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE1_CNI . '"></a></td>
			<td><a href="#""  title="'  . $row->IMAGE2_CNI . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE2_CNI . '"></a></td>
			<td> N°' .$row->NUMERO_IDENTITE.'<br>'.$row->DATE_DELIVRANCE. '</td></tr></tbody></table></a>';
			$sub_array[] = '<table> <tbody><tr>
			<td>'.$this->replace($row->PERE).''.$this->replace($row->MERE).'</td>
			</tr></tbody></table></a>';
			$sub_array[] =  $this->notifications->ago($row->DATE_NAISSANCE, date('Y-m-d'));
			$sub_array[] = $row->NUMERO_TELEPHONE;
			$sub_array[] = $row->avenue.' '.$row->Colline;
			$sub_array[] = $row->zone.' '.$row->commune.' '.$row->province;
			$sub_array[] = $row->DESCRIPTION;
			$sub_array[] = $row->FONCTION_NAME;
			$sub_array[] = $row->NOM_ROLE;
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
 public function listing_habitant_all(){
 	    $ID_PROVINCE = $this->input->post('ID_PROVINCE');
	    $ID_COMMUNE = $this->input->post('ID_COMMUNE');
	    $ID_ZONE = $this->input->post('ID_ZONE');
	    $ID_COLLINE = $this->input->post('ID_COLLINE');
	    $ID_AVENUE = $this->input->post('ID_AVENUE');
	    $ID_FONCTION = $this->input->post('ID_FONCTION');
	    $ID_HABITANT_ROLE = $this->input->post('ID_HABITANT_ROLE');

	    $critere_profil = "";
	    $critere_province = "";
	    $critere_commune = "";
	    $critere_zone = "";
	    $critere_avenue = "";
	    $critere_colline = "";
	    $critere_fonction = "";
	    $critere_role = "";

        $critere_province = !empty($ID_PROVINCE) ? "  AND sp.PROVINCE_ID=".$ID_PROVINCE." ":"";
        $critere_commune = !empty($ID_COMMUNE) ? "  AND sc.COMMUNE_ID=".$ID_COMMUNE." ":"";
        $critere_zone = !empty($ID_ZONE) ? "  AND sz.ZONE_ID=".$ID_ZONE." ":"";
        $critere_colline = !empty($ID_COLLINE) ? "  AND sco.COLLINE_ID=".$ID_COLLINE." ":"";
        $critere_avenue = !empty($ID_AVENUE) ? "  AND sa.AVENUE_ID=".$ID_AVENUE." ":"";
        $critere_fonction = !empty($ID_FONCTION) ? "  AND mhf.ID_FONCTION=".$ID_FONCTION." ":"";
        $critere_role = !empty($ID_HABITANT_ROLE) ? "  AND mhr.ID_HABITANT_ROLE=".$ID_HABITANT_ROLE." ":"";
		$i = 1;
		$query_principal = 'SELECT mh.IMAGE_MERE,mh.IMAGE_PERE,mh.IMAGE1_CNI,mh.IMAGE2_CNI,mh.ID_HABITANT, mh.ID_HABITANT,mh.NOM,mh.PRENOM ,mh.NUMERO_IDENTITE,mh.DATE_DELIVRANCE,mh.LIEU_DELIVRANCE,mh.PERE,mh.MERE,mh.NUMERO_TELEPHONE,mh.DATE_NAISSANCE,mh.PHOTO, mh.ID_SEXE,sp.PROVINCE_NAME AS province, sc.COMMUNE_NAME AS commune ,sz.ZONE_NAME AS zone, sco.COLLINE_NAME AS Colline ,sa.AVENUE_NAME AS avenue ,mhf.FONCTION_NAME,mhec.DESCRIPTION,mhr.NOM_ROLE FROM  menage_habitants mh    LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mh.ID_AVENUE LEFT JOIN syst_collines sco  ON  sco.COLLINE_ID=sa.COLLINE_ID LEFT JOIN syst_zones sz on sz.ZONE_ID=sco.ZONE_ID LEFT JOIN syst_communes sc ON sc.COMMUNE_ID=sz.COMMUNE_ID  LEFT JOIN syst_provinces sp ON sc.PROVINCE_ID=sp.PROVINCE_ID  LEFT JOIN  menage_habitant_fonctions mhf on mhf.ID_FONCTION=mh.ID_FONCTION LEFT JOIN menage_habitant_etat_civils mhec ON mhec.ID_ETAT_CIVIL=mh.ID_ETAT_CIVIL LEFT JOIN menage_appartement_habitants mah ON mah.ID_HABITANT=mh.ID_HABITANT LEFT JOIN menage_appartements ma ON ma.ID_APPARTEMENT=mah.ID_APPARTEMENT LEFT JOIN menage_habitants_roles mhr ON mhr.ID_HABITANT_ROLE=mah.ID_HABITANT_ROLE WHERE 1'.$critere_province.' '.$critere_commune.' '.$critere_zone.' '.$critere_colline.' '.$critere_fonction .' '.$critere_role.' '.$critere_avenue;

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';


		$order_column = array('NOM', 'PRENOM', 'NUMERO_IDENTITE', 'LIEU_DELIVRANCE', 'DATE_DELIVRANCE', 'PERE', 'MERE', 'NUMERO_TELEPHONE', 'colline', 'avenue','province', 'commune', 'zone', 'DATE_NAISSANCE', 'SEXE', 'DESCRIPTION', 'FONCTION_NAME', 'NOM_ROLE');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM,PRENOM ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM LIKE '%$var_search%' OR PRENOM LIKE '%$var_search%' OR NUMERO_IDENTITE LIKE '%$var_search%'  ") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by ;
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

			$option .= "<li><a hre='#' id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='supprimer(".$row->ID_HABITANT.",this.title,this.id) '><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('appertement/Enclos/getOne_habitant/' . $row->ID_HABITANT) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			
			$option .= "<li><a hre='#' id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='valider(".$row->ID_HABITANT.",this.title,this.id) '><label class='text-info'>&nbsp;&nbsp;Visiter</label></a></li>";
			$option .= "<li><a hre='#' id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='soupçonner(".$row->ID_HABITANT.",this.title,this.id) '><label class='text-info'>&nbsp;&nbsp;soupçonner</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_HABITANT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->ID_SEXE . "," . $row->NOM . " " . $row->PRENOM . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('appertement/Enclos/delete_habitant/' . $row->ID_HABITANT) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			$sourceParents = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
	
         

			$sub_array = array();
			$sub_array[] = '<table> <tbody><tr><td><a href="#"  title="'  . $source . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM . '</td></tr></tbody></table></a>';
			
			$sub_array[] = '<table> <tbody><tr>
			<td><a href="#""  title="'  . $row->IMAGE1_CNI . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE1_CNI . '"></a></td>
			<td><a href="#""  title="'  . $row->IMAGE2_CNI . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE2_CNI . '"></a></td>
			<td> N°' .$row->NUMERO_IDENTITE.'<br>'.$row->DATE_DELIVRANCE. '</td></tr></tbody></table></a>';
			$sub_array[] = '<table> <tbody><tr>
			<td><i>Père:</i> '.$row->PERE.'</td>
			<td><i>Mère:</i> '.$row->MERE.'</td>
			</tr></tbody></table></a>';
			$sub_array[] =  $this->notifications->ago($row->DATE_NAISSANCE, date('Y-m-d'));
			$sub_array[] = $row->NUMERO_TELEPHONE;
			$sub_array[] = $row->avenue.' '.$row->Colline;
			$sub_array[] = $row->zone.' '.$row->commune.' '.$row->province;
			$sub_array[] = $row->DESCRIPTION;
			$sub_array[] = $row->FONCTION_NAME;
			$sub_array[] = $row->NOM_ROLE;
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
	//HABITANT VALIDE
	function listing_habitant_valide($ID_APPARTEMENT=0)
	{
       $id_utilisateur = $this->session->userdata('USER_ID');
		$profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      $critere_lieu='';
      $critere_nouveau='';
      //CHEF DES SECTEUR
      if($profil['PROFIL_ID']==20 || $profil['PROFIL_ID']==1){
      	//RECUPERATION DE L'AVENUE
         $secteur = $this->Modele->getRequeteOne('SELECT mca.ID_AVENUE  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
          $critere_lieu=' AND mh.ID_AVENUE='.$secteur['ID_AVENUE'];
          $critere_nouveau=' LEFT JOIN histo_validation_habitant hvh ON hvh.ID_HABITANT=mh.ID_HABITANT WHERE hvh.ID_STATUT=1';
      }
     //CHEF DE QUARTIER
     else if($profil['PROFIL_ID']==22)
     {
       $quartier = $this->Modele->getRequeteOne('SELECT mca.COLLINE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
          $critere_lieu=' AND sco.COLLINE_ID ='.$quartier['COLLINE_ID'];
          $critere_nouveau=' LEFT JOIN histo_validation_habitant hvh ON hvh.ID_HABITANT=mh.ID_HABITANT WHERE hvh.ID_STATUT=2';

     }
     //CHEF DE ZONE
     else if($profil['PROFIL_ID']==21)
     {
       $zone = $this->Modele->getRequeteOne('SELECT mca.ZONE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
       $critere_lieu=' AND sz.ZONE_ID ='.$zone['ZONE_ID'];
       $critere_nouveau=' LEFT JOIN histo_validation_habitant hvh ON hvh.ID_HABITANT=mh.ID_HABITANT WHERE hvh.ID_STATUT=3';

       
     }
     //MERE DE LA VILLE
     else 
     {
     	 $critere_lieu='';
     }
       $ID_PROVINCE = $this->input->post('ID_PROVINCE');
	    $ID_COMMUNE = $this->input->post('ID_COMMUNE');
	    $ID_ZONE = $this->input->post('ID_ZONE');
	    $ID_COLLINE = $this->input->post('ID_COLLINE');
	    $ID_FONCTION = $this->input->post('ID_FONCTION');
	    $ID_HABITANT_ROLE = $this->input->post('ID_HABITANT_ROLE');


	    $critere_profil = "";
	    $critere_province = "";
	    $critere_commune = "";
	    $critere_zone = "";
	    $critere_colline = "";
	    $critere_fonction = "";
	    $critere_role = "";

       
        $critere_province = !empty($ID_PROVINCE) ? "  AND sp.PROVINCE_ID=".$ID_PROVINCE." ":"";
        $critere_commune = !empty($ID_COMMUNE) ? "  AND sc.COMMUNE_ID=".$ID_COMMUNE." ":"";
        $critere_zone = !empty($ID_ZONE) ? "  AND sz.ZONE_ID=".$ID_ZONE." ":"";
        $critere_colline = !empty($ID_COLLINE) ? "  AND sco.COLLINE_ID=".$ID_COLLINE." ":"";
         $critere_fonction = !empty($ID_FONCTION) ? "  AND mhf.ID_FONCTION=".$ID_FONCTION." ":"";
          $critere_role = !empty($ID_HABITANT_ROLE) ? "  AND mhr.ID_HABITANT_ROLE=".$ID_HABITANT_ROLE." ":"";
		$i = 1;
		$query_principal = 'SELECT mh.IMAGE1_CNI,mh.IMAGE2_CNI,mh.IMAGE_MERE,mh.IMAGE_PERE,mh.ID_HABITANT, mh.ID_HABITANT,mh.NOM,mh.PRENOM ,mh.NUMERO_IDENTITE,mh.DATE_DELIVRANCE,mh.LIEU_DELIVRANCE,mh.PERE,mh.MERE,mh.NUMERO_TELEPHONE,mh.DATE_NAISSANCE,mh.PHOTO, mh.ID_SEXE,sp.PROVINCE_NAME AS province, sc.COMMUNE_NAME AS commune ,sz.ZONE_NAME AS zone, sco.COLLINE_NAME AS Colline ,sa.AVENUE_NAME AS avenue ,mhf.FONCTION_NAME,mhec.DESCRIPTION,mhr.NOM_ROLE FROM  menage_habitants mh    LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mh.ID_AVENUE LEFT JOIN syst_collines sco  ON  sco.COLLINE_ID=sa.COLLINE_ID LEFT JOIN syst_zones sz on sz.ZONE_ID=sco.ZONE_ID LEFT JOIN syst_communes sc ON sc.COMMUNE_ID=sz.COMMUNE_ID  LEFT JOIN syst_provinces sp ON sc.PROVINCE_ID=sp.PROVINCE_ID  LEFT JOIN  menage_habitant_fonctions mhf on mhf.ID_FONCTION=mh.ID_FONCTION LEFT JOIN menage_habitant_etat_civils mhec ON mhec.ID_ETAT_CIVIL=mh.ID_ETAT_CIVIL LEFT JOIN menage_appartement_habitants mah ON mah.ID_HABITANT=mh.ID_HABITANT LEFT JOIN menage_appartements ma ON ma.ID_APPARTEMENT=mah.ID_APPARTEMENT LEFT JOIN menage_habitants_roles mhr ON mhr.ID_HABITANT_ROLE=mah.ID_HABITANT_ROLE '.$critere_nouveau.' '.$critere_lieu.' '.$critere_province.' '.$critere_commune.' '.$critere_zone.' '.$critere_colline.' '.$critere_fonction .' '.$critere_role;

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}
		$order_by = '';
		$order_column = array('NOM', 'PRENOM', 'NUMERO_IDENTITE', 'LIEU_DELIVRANCE', 'DATE_DELIVRANCE', 'PERE', 'MERE', 'NUMERO_TELEPHONE', 'colline', 'avenue','province', 'commune', 'zone', 'DATE_NAISSANCE', 'SEXE', 'DESCRIPTION', 'FONCTION_NAME', 'NOM_ROLE');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM,PRENOM ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM LIKE '%$var_search%' OR PRENOM LIKE '%$var_search%' OR NUMERO_IDENTITE LIKE '%$var_search%'  ") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by ;
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

			$option .= "<li><a hre='#' id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='supprimer(".$row->ID_HABITANT.",this.title,this.id) '><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('appertement/Enclos/getOne_habitant/' . $row->ID_HABITANT) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			
			$option .= "<li><a hre='#' id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='valider(".$row->ID_HABITANT.",this.title,this.id) '><label class='text-info'>&nbsp;&nbsp;Visiter</label></a></li>";
			$option .= "<li><a hre='#' id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='soupçonner(".$row->ID_HABITANT.",this.title,this.id) '><label class='text-info'>&nbsp;&nbsp;soupçonner</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_HABITANT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->ID_SEXE . "," . $row->NOM . " " . $row->PRENOM . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('appertement/Enclos/delete_habitant/' . $row->ID_HABITANT) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			$sourceParents = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
	
         

			$sub_array = array();
			$sub_array[] = '<table> <tbody><tr><td><a href="#"  title="'  . $source . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM . '</td></tr></tbody></table></a>';
			
			$sub_array[] = '<table> <tbody><tr>
			<td><a href="#""  title="'  . $row->IMAGE1_CNI . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE1_CNI . '"></a></td>
			<td><a href="#""  title="'  . $row->IMAGE2_CNI . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE2_CNI . '"></a></td>
			<td> N°' .$row->NUMERO_IDENTITE.'<br>'.$row->DATE_DELIVRANCE. '</td></tr></tbody></table></a>';
			$sub_array[] = '<table> <tbody><tr>
			<td><a href="#""  title="'  . $row->IMAGE_PERE . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE_PERE . '"></a>'.$row->PERE.'</td>
			<td><a href="#""  title="'  . $row->IMAGE_MERE . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE_MERE . '"></a>'.$row->MERE.'</td>
			</tr></tbody></table></a>';
			$sub_array[] =  $this->notifications->ago($row->DATE_NAISSANCE, date('Y-m-d'));
			$sub_array[] = $row->NUMERO_TELEPHONE;
			$sub_array[] = $row->avenue.' '.$row->Colline;
			$sub_array[] = $row->zone.' '.$row->commune.' '.$row->province;
			$sub_array[] = $row->DESCRIPTION;
			$sub_array[] = $row->FONCTION_NAME;
			$sub_array[] = $row->NOM_ROLE;
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
	//HABITANT  REJETTE
	function listing_habitant_rejette($ID_APPARTEMENT=0)
	{
       $id_utilisateur = $this->session->userdata('USER_ID');
		$profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      $critere_lieu='';
      //CHEF DES SECTEUR
      if($profil['PROFIL_ID']==20 || $profil['PROFIL_ID']==1){
      	//RECUPERATION DE L'AVENUE
         $secteur = $this->Modele->getRequeteOne('SELECT mca.ID_AVENUE  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
          $critere_lieu=' AND mh.ID_AVENUE='.$secteur['ID_AVENUE'];
      }
     //CHEF DE QUARTIER
     else if($profil['PROFIL_ID']==22)
     {
       $quartier = $this->Modele->getRequeteOne('SELECT mca.COLLINE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
          $critere_lieu=' AND sco.COLLINE_ID ='.$quartier['COLLINE_ID'];

     }
     //CHEF DE ZONE
     else if($profil['PROFIL_ID']==21)
     {
       $zone = $this->Modele->getRequeteOne('SELECT mca.ZONE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
       $critere_lieu=' AND sz.ZONE_ID ='.$zone['ZONE_ID'];
     }
     //MERE DE LA VILLE
     else 
     {
     	 $critere_lieu='';
     }

       $ID_PROVINCE = $this->input->post('ID_PROVINCE');
	    $ID_COMMUNE = $this->input->post('ID_COMMUNE');
	    $ID_ZONE = $this->input->post('ID_ZONE');
	    $ID_COLLINE = $this->input->post('ID_COLLINE');
	    $ID_FONCTION = $this->input->post('ID_FONCTION');
	    $ID_HABITANT_ROLE = $this->input->post('ID_HABITANT_ROLE');


	    $critere_profil = "";
	    $critere_province = "";
	    $critere_commune = "";
	    $critere_zone = "";
	    $critere_colline = "";
	    $critere_fonction = "";
	    $critere_role = "";

       
        $critere_province = !empty($ID_PROVINCE) ? "  AND sp.PROVINCE_ID=".$ID_PROVINCE." ":"";
        $critere_commune = !empty($ID_COMMUNE) ? "  AND sc.COMMUNE_ID=".$ID_COMMUNE." ":"";
        $critere_zone = !empty($ID_ZONE) ? "  AND sz.ZONE_ID=".$ID_ZONE." ":"";
        $critere_colline = !empty($ID_COLLINE) ? "  AND sco.COLLINE_ID=".$ID_COLLINE." ":"";
         $critere_fonction = !empty($ID_FONCTION) ? "  AND mhf.ID_FONCTION=".$ID_FONCTION." ":"";
          $critere_role = !empty($ID_HABITANT_ROLE) ? "  AND mhr.ID_HABITANT_ROLE=".$ID_HABITANT_ROLE." ":"";
		$i = 1;
		$query_principal = 'SELECT mh.IMAGE1_CNI,mh.IMAGE2_CNI,mh.IMAGE_MERE,mh.IMAGE_PERE, mh.ID_HABITANT, mh.ID_HABITANT,mh.NOM,mh.PRENOM ,mh.NUMERO_IDENTITE,mh.DATE_DELIVRANCE,mh.LIEU_DELIVRANCE,mh.PERE,mh.MERE,mh.NUMERO_TELEPHONE,mh.DATE_NAISSANCE,mh.PHOTO, mh.ID_SEXE,sp.PROVINCE_NAME AS province, sc.COMMUNE_NAME AS commune ,sz.ZONE_NAME AS zone, sco.COLLINE_NAME AS Colline ,sa.AVENUE_NAME AS avenue ,mhf.FONCTION_NAME,mhec.DESCRIPTION,mhr.NOM_ROLE FROM  menage_habitants mh    LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mh.ID_AVENUE LEFT JOIN syst_collines sco  ON  sco.COLLINE_ID=sa.COLLINE_ID LEFT JOIN syst_zones sz on sz.ZONE_ID=sco.ZONE_ID LEFT JOIN syst_communes sc ON sc.COMMUNE_ID=sz.COMMUNE_ID  LEFT JOIN syst_provinces sp ON sc.PROVINCE_ID=sp.PROVINCE_ID  LEFT JOIN  menage_habitant_fonctions mhf on mhf.ID_FONCTION=mh.ID_FONCTION LEFT JOIN menage_habitant_etat_civils mhec ON mhec.ID_ETAT_CIVIL=mh.ID_ETAT_CIVIL LEFT JOIN menage_appartement_habitants mah ON mah.ID_HABITANT=mh.ID_HABITANT LEFT JOIN menage_appartements ma ON ma.ID_APPARTEMENT=mah.ID_APPARTEMENT LEFT JOIN menage_habitants_roles mhr ON mhr.ID_HABITANT_ROLE=mah.ID_HABITANT_ROLE LEFT JOIN histo_validation_habitant hvh ON hvh.ID_HABITANT=mh.ID_HABITANT
		   WHERE 1 AND  hvh.ID_STATUT=4'.$critere_lieu.' '.$critere_province.' '.$critere_commune.' '.$critere_zone.' '.$critere_colline.' '.$critere_fonction .' '.$critere_role;

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';


		$order_column = array('NOM', 'PRENOM', 'NUMERO_IDENTITE', 'LIEU_DELIVRANCE', 'DATE_DELIVRANCE', 'PERE', 'MERE', 'NUMERO_TELEPHONE', 'colline', 'avenue','province', 'commune', 'zone', 'DATE_NAISSANCE', 'SEXE', 'DESCRIPTION', 'FONCTION_NAME', 'NOM_ROLE');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM,PRENOM ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM LIKE '%$var_search%' OR PRENOM LIKE '%$var_search%' OR NUMERO_IDENTITE LIKE '%$var_search%'  ") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by ;
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

			$option .= "<li><a hre='#' id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='supprimer(".$row->ID_HABITANT.",this.title,this.id) '><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('appertement/Enclos/getOne_habitant/' . $row->ID_HABITANT) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			
			$option .= "<li><a hre='#' id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='valider(".$row->ID_HABITANT.",this.title,this.id) '><label class='text-info'>&nbsp;&nbsp;Visiter</label></a></li>";
			$option .= "<li><a hre='#' id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='soupçonner(".$row->ID_HABITANT.",this.title,this.id) '><label class='text-info'>&nbsp;&nbsp;soupçonner</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_HABITANT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->ID_SEXE . "," . $row->NOM . " " . $row->PRENOM . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('appertement/Enclos/delete_habitant/' . $row->ID_HABITANT) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			$sourceParents = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
	
         

			$sub_array = array();
			$sub_array[] = '<table> <tbody><tr><td><a href="#"  title="'  . $source . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM . '</td></tr></tbody></table></a>';
			
			$sub_array[] = '<table> <tbody><tr>
			<td><a href="#""  title="'  . $row->IMAGE1_CNI . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE1_CNI . '"></a></td>
			<td><a href="#""  title="'  . $row->IMAGE2_CNI . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE2_CNI . '"></a></td>
			<td> N°' .$row->NUMERO_IDENTITE.'<br>'.$row->DATE_DELIVRANCE. '</td></tr></tbody></table></a>';
			$sub_array[] = '<table> <tbody><tr>
			<td><a href="#""  title="'  . $row->IMAGE_PERE . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE_PERE . '"></a>'.$row->PERE.'</td>
			<td><a href="#""  title="'  . $row->IMAGE_MERE . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE_MERE . '"></a>'.$row->MERE.'</td>
			</tr></tbody></table></a>';
			$sub_array[] =  $this->notifications->ago($row->DATE_NAISSANCE, date('Y-m-d'));
			$sub_array[] = $row->NUMERO_TELEPHONE;
			$sub_array[] = $row->avenue.' '.$row->Colline;
			$sub_array[] = $row->zone.' '.$row->commune.' '.$row->province;
			$sub_array[] = $row->DESCRIPTION;
			$sub_array[] = $row->FONCTION_NAME;
			$sub_array[] = $row->NOM_ROLE;
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
	function get_habitant($ID_APPARTEMENT=0)
	{
		$query_principal = 'SELECT mh.IMAGE1_CNI,mh.IMAGE2_CNI,mh.IMAGE_PERE,mh.IMAGE_MERE,mh.ID_HABITANT, mh.ID_HABITANT,mh.NOM,mh.PRENOM ,mh.NUMERO_IDENTITE,mh.DATE_DELIVRANCE,mh.LIEU_DELIVRANCE,mh.PERE,mh.MERE,mh.NUMERO_TELEPHONE,mh.DATE_NAISSANCE,mh.PHOTO, mh.ID_SEXE,sp.PROVINCE_NAME AS province, sc.COMMUNE_NAME AS commune ,sz.ZONE_NAME AS zone, sco.COLLINE_NAME AS Colline ,sa.AVENUE_NAME AS avenue ,mhf.FONCTION_NAME,mhec.DESCRIPTION,mhr.NOM_ROLE FROM  menage_habitants mh    LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mh.ID_AVENUE LEFT JOIN syst_collines sco  ON  sco.COLLINE_ID=sa.COLLINE_ID LEFT JOIN syst_zones sz on sz.ZONE_ID=sco.ZONE_ID LEFT JOIN syst_communes sc ON sc.COMMUNE_ID=sz.COMMUNE_ID  LEFT JOIN syst_provinces sp ON sc.PROVINCE_ID=sp.PROVINCE_ID  LEFT JOIN  menage_habitant_fonctions mhf on mhf.ID_FONCTION=mh.ID_FONCTION LEFT JOIN menage_habitant_etat_civils mhec ON mhec.ID_ETAT_CIVIL=mh.ID_ETAT_CIVIL LEFT JOIN menage_appartement_habitants mah ON mah.ID_HABITANT=mh.ID_HABITANT LEFT JOIN menage_appartements ma ON ma.ID_APPARTEMENT=mah.ID_APPARTEMENT LEFT JOIN menage_habitants_roles mhr ON mhr.ID_HABITANT_ROLE=mah.ID_HABITANT_ROLE WHERE mah.ID_APPARTEMENT= '.$ID_APPARTEMENT;

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';


		$order_column = array('NOM', 'PRENOM', 'NUMERO_IDENTITE', 'LIEU_DELIVRANCE', 'DATE_DELIVRANCE', 'PERE', 'MERE', 'NUMERO_TELEPHONE', 'colline', 'avenue','province', 'commune', 'zone', 'DATE_NAISSANCE', 'SEXE', 'DESCRIPTION', 'FONCTION_NAME', 'NOM_ROLE');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM,PRENOM ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM LIKE '%$var_search%' OR PRENOM LIKE '%$var_search%' OR NUMERO_IDENTITE LIKE '%$var_search%'  ") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by ;
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
			$option .= "<li><a hre='#' id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='supprimer_habitant(".$row->ID_HABITANT.",this.title,this.id)'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('appertement/Enclos/getOne_habitant/' . $row->ID_HABITANT) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			
			$option .= " </ul>
			</div>
			";
			$source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";

			$sub_array = array();

$sub_array[] = '<table> <tbody><tr><td><a href="#"  title="'  . $source . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM . '</td></tr></tbody></table></a>';
			
			$sub_array[] = '<table> <tbody><tr>
			<td><a href="#""  title="'  . $row->IMAGE1_CNI . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE1_CNI . '"></a></td>
			<td><a href="#""  title="'  . $row->IMAGE2_CNI . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE2_CNI . '"></a></td>
			<td> N°' .$row->NUMERO_IDENTITE.'<br>'.$row->DATE_DELIVRANCE. '</td></tr></tbody></table></a>';
			// $sub_array[] = '<table> <tbody><tr>
			// <td><a href="#""  title="'  . $row->IMAGE_PERE . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE_PERE . '"></a>'.$row->PERE.'</td>
			// <td><a href="#""  title="'  . $row->IMAGE_MERE . '" onclick="get_imag(this.title)" ><img alt="Avtar" style="width:20px;height:20px" src="' . $row->IMAGE_MERE . '"></a>'.$row->MERE.'</td>
			// </tr></tbody></table></a>';
			$sub_array[] = $row->NUMERO_TELEPHONE;
			$sub_array[] = $row->avenue.' '.$row->Colline;
			$sub_array[] = $row->zone.' '.$row->commune.' '.$row->province;

			$sub_array[] = $row->DESCRIPTION;
			$sub_array[] = $row->FONCTION_NAME;
			$sub_array[] = $row->NOM_ROLE;
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
	function getOne_habitant($id)
	{
		$membre = $this->Modele->getRequeteOne('SELECT  mh.ID_HABITANT,mh.NOM,mh.PRENOM ,mh.NUMERO_IDENTITE,mh.DATE_DELIVRANCE,mh.LIEU_DELIVRANCE,mh.PERE,mh.MERE,mh.NUMERO_TELEPHONE,mh.DATE_NAISSANCE,mh.PHOTO,    IF(mh.ID_SEXE = "H","mr","md") as SEXE,sp.PROVINCE_ID, sc.COMMUNE_ID ,sz.ZONE_ID, sco.COLLINE_ID ,sa.AVENUE_ID ,mhf.ID_FONCTION,mhec.ID_ETAT_CIVIL,mhr.ID_HABITANT_ROLE FROM  menage_habitants mh    LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mh.ID_AVENUE LEFT JOIN syst_collines sco  ON  sco.COLLINE_ID=sa.COLLINE_ID LEFT JOIN syst_zones sz on sz.ZONE_ID=sco.ZONE_ID LEFT JOIN syst_communes sc ON sc.COMMUNE_ID=sz.COMMUNE_ID  LEFT JOIN syst_provinces sp ON sc.PROVINCE_ID=sp.PROVINCE_ID  LEFT JOIN  menage_habitant_fonctions mhf on mhf.ID_FONCTION=mh.ID_FONCTION LEFT JOIN menage_habitant_etat_civils mhec ON mhec.ID_ETAT_CIVIL=mh.ID_ETAT_CIVIL LEFT JOIN menage_appartement_habitants mah ON mah.ID_HABITANT=mh.ID_HABITANT LEFT JOIN menage_appartements ma ON ma.ID_APPARTEMENT=mah.ID_APPARTEMENT LEFT JOIN menage_habitants_roles mhr ON mhr.ID_HABITANT_ROLE=mah.ID_HABITANT_ROLE WHERE mh.ID_HABITANT=' . $id);
		$data['membre'] = $membre;
		
     $id_utilisateur = $this->session->userdata('USER_ID');
      $profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      $data['profil'] =$profil['PROFIL_ID'];
      $lieu='';
      //CHEF DE SECTEUR
      if($profil['PROFIL_ID']==20){
       $name = $this->Model->getRequeteOne('SELECT sa.AVENUE_ID,sa.COLLINE_ID ,sa.AVENUE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN syst_avenue sa ON sa.AVENUE_ID=mca.ID_AVENUE  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
       // print_r( $name);
       // exit();
      $data['AVENUES'] =$name['AVENUE_ID'];
      $data['COLLINES'] =$name['COLLINE_ID'];
       $lieu=' se trouvant dans l\'avenue:'.$name['name'];
      }
      //CHEF DE QUARTIER
      else if($profil['PROFIL_ID']==22){
      	$name = $this->Model->getRequeteOne('SELECT sc.COLLINE_ID,sc.COLLINE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR   LEFT JOIN syst_collines sc ON sc.COLLINE_ID=mca.COLLINE_ID  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
         $data['COLLINES'] =$name['COLLINE_ID'];
        
         $lieu=' se trouvant dans le quartier:'.$name['name'];
      	$quartier = $this->Modele->getRequeteOne('SELECT mca.COLLINE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      	$data['avenues'] = $this->Model->getRequete('SELECT AVENUE_ID,AVENUE_NAME FROM syst_avenue WHERE COLLINE_ID='.$quartier ['COLLINE_ID'].' ORDER BY AVENUE_NAME ASC');
      }
      //CHEF DE ZONE
      else if($profil['PROFIL_ID']==21){
      	$name = $this->Model->getRequeteOne('SELECT sz.ZONE_NAME as   name FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR LEFT JOIN  syst_zones sz ON sz.ZONE_ID=mca.ZONE_ID  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
         $lieu=' se trouvant dans la zone:'.$name['name'];
      	$zone = $this->Modele->getRequeteOne('SELECT mca.ZONE_ID  FROM  menage_chef_affectations mca  LEFT JOIN utilisateurs u ON u.ID_UTILISATEUR=mca.ID_UTILISATEUR  WHERE u.ID_UTILISATEUR='.$id_utilisateur);
      	$data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID='.$zone['ZONE_ID'].' ORDER BY COLLINE_NAME ASC');
      	$data['avenues'] = $this->Model->getRequete('SELECT AVENUE_ID,AVENUE_NAME FROM syst_avenue WHERE COLLINE_ID='.$membre['COLLINE_ID'].' ORDER BY AVENUE_NAME ASC');
      }
      else{
      	$data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');

		$data['communes'] = $this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID=' . $membre['PROVINCE_ID'] . ' ORDER BY COMMUNE_NAME ASC');
		$data['zones'] = $this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID=' . $membre['COMMUNE_ID'] . ' ORDER BY ZONE_NAME ASC');
		$data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID=' . $membre['ZONE_ID'] . ' ORDER BY COLLINE_NAME ASC');
		$data['avenues'] = $this->Model->getRequete('SELECT AVENUE_ID,AVENUE_NAME FROM syst_avenue WHERE COLLINE_ID=' . $membre['COLLINE_ID'] . ' ORDER BY AVENUE_NAME ASC');
      }
       $data['roles'] = $this->Model->getRequete('SELECT ID_HABITANT_ROLE, NOM_ROLE FROM menage_habitants_roles WHERE 1  ORDER BY NOM_ROLE ASC');
		$data['eta_civils'] = $this->Model->getRequete('SELECT ID_ETAT_CIVIL, 	DESCRIPTION FROM menage_habitant_etat_civils WHERE 1  ORDER BY DESCRIPTION ASC');
		$data['fonctions'] = $this->Model->getRequete('SELECT ID_FONCTION, FONCTION_NAME FROM menage_habitant_fonctions WHERE 1  ORDER BY FONCTION_NAME ASC');
		$data['appartement'] = $this->Model->getRequete('SELECT 	ID_APPARTEMENT, NOMBRE_CHAMBRE FROM menage_appartements WHERE 1  ORDER BY NOMBRE_CHAMBRE ASC');
		$data['title'] = "Modifier les informations d'un habitant ";
		$this->load->view('Habitant_update_view', $data);
	}
	function update_habitant()
	{
		$this->form_validation->set_rules('NOM', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PRENOM', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('CNI', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DATE_DELIVRANCE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PERE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
	    $this->form_validation->set_rules('MERE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
	    $this->form_validation->set_rules('NUMERO_TELEPHONE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DATE_NAISSANCE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
         $id= $this->input->post('ID_HABITANT');
		if ($this->form_validation->run() == FALSE) {
			$this->getOne_habitant($id);
		} else {


			$file = $_FILES['PHOTO'];
			$path = './uploads/Gestion_Publication_Menu/';
			if (!is_dir(FCPATH . '/uploads/Gestion_Publication_Menu/')) {
				mkdir(FCPATH . '/uploads/Gestion_Publication_Menu/', 0777, TRUE);
			}

			$thepath = base_url() . 'uploads/Gestion_Publication_Menu/';
			$config['upload_path'] = './uploads/Gestion_Publication_Menu/';
			$photonames = date('ymdHisa');
			$config['file_name'] = $photonames;
			$config['allowed_types'] = '*';
			$this->upload->initialize($config);
			$this->upload->do_upload("PHOTO");
			$info = $this->upload->data();

			if ($file == '') {
				$pathfile = base_url() . 'uploads/sevtb.png';
			} else {
				$pathfile = base_url() . '/uploads/Gestion_Publication_Menu/' . $photonames . $info['file_ext'];
			}


			$camerasImage = $this->input->post('ImageLink');

			if (!empty($camerasImage)) {

				$dir = FCPATH.'/uploads/cameraImagePsr/';
			      if (!is_dir(FCPATH . '/uploads/cameraImagePsr/')) {
				  mkdir(FCPATH . '/uploads/cameraImagePsr/', 0777, TRUE);
			    }

                $photonames = date('ymdHisa');
                $pathfile = base_url() . 'uploads/cameraImagePsr/' . $photonames .".png";
			    $pathfiless = FCPATH . '/uploads/cameraImagePsr/' . $photonames .".png";
			    $file_name = $photonames .".png";

			    $img = $this->input->post('ImageLink'); // Your data 'data:image/png;base64,AAAFBfj42Pj4';
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                file_put_contents($pathfiless, $data);

				//echo "<img src='".$path."' >";
				
			}
         $autre=$this->input->post('AUTRE');
         $avenueId='';
		if(!empty($autre)){
         $data_avenue = array(
          'AVENUE_NAME'=>$autre,
          'COLLINE_ID'=>$this->input->post('ID_COLLINE'));
          $table = 'syst_avenue';
          $avenueId = $this->Modele->insert_last_id($table, $data_avenue);
        }
        else{
        	$avenueId =$this->input->post('ID_AVENUE');
        }

			$data_insert = array(

				'NOM' => $this->input->post('NOM'),
				'PRENOM' => $this->input->post('PRENOM'),
				'NUMERO_IDENTITE' => $this->input->post('CNI'),
				'LIEU_DELIVRANCE' => $this->input->post('LIEU_DELIVRANCE'),
				'DATE_DELIVRANCE' => $this->input->post('DATE_DELIVRANCE'),
				'PERE' => $this->input->post('PERE'),
				'MERE' => $this->input->post('MERE'),
				'NUMERO_TELEPHONE' => $this->input->post('NUMERO_TELEPHONE'),
				'COLLINE_ID' => $this->input->post('ID_COLLINE'),
				'ID_AVENUE' => $avenueId,
				'DATE_NAISSANCE' => $this->input->post('DATE_NAISSANCE'),
				'ID_SEXE' => $this->input->post('SEXE'),
				'ID_ETAT_CIVIL' => $this->input->post('ID_ETAT_CIVIL'),
				'ID_FONCTION' => $this->input->post('ID_HABITANT'),
				// 'PHOTO' => $pathfile
			);
			$this->Modele->update('menage_habitants', array('ID_HABITANT' => $this->input->post('ID_HABITANT')), $data_insert);

		$data_appa = array(
          'ID_APPARTEMENT'=>$this->input->post('ID_APPARTEMENT'),
          'ID_HABITANT_ROLE'=>$this->input->post('ID_HABITANT_ROLE')
          );
         $this->Modele->update('menage_appartement_habitants', array('ID_HABITANT' => $this->input->post('ID_HABITANT')), $data_appa);
		
		$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('appertement/Enclos/'));
		}
	}
	 public function valider($ID_HABITANT)
    {
      $id_utilisateur = $this->session->userdata('USER_ID');
		$profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);
		//CHEF DES SECTEUR
      if($profil['PROFIL_ID']==20 ){
        $data = array(
          'ID_HABITANT'=>$ID_HABITANT,
          'USER_ID'=>$id_utilisateur,
          'ID_STATUT'=>1);
         $table = 'histo_validation_habitant';
         $this->Modele->create($table, $data);
        }
      //CHEF DES QUARTIER
      else if($profil['PROFIL_ID']==22 ){
      	$data = array('ID_STATUT'=>2);
         $this->Modele->update('histo_validation_habitant', array('ID_HABITANT' =>$ID_HABITANT), $data);
        }
      //CHEF DES ZONE
      else if($profil['PROFIL_ID']==21 ){
      	$data = array('ID_STATUT'=>3);
         $this->Modele->update('histo_validation_habitant', array('ID_HABITANT' =>$ID_HABITANT), $data);
      }
      print_r(json_encode(1));
    }
    public function soupçonner($ID_HABITANT)
    {
      $id_utilisateur = $this->session->userdata('USER_ID');
		$profil = $this->Modele->getRequeteOne('SELECT pro.PROFIL_ID FROM profil pro LEFT JOIN utilisateurs u ON u.PROFIL_ID=pro.PROFIL_ID   WHERE u.ID_UTILISATEUR='.$id_utilisateur);
		if($profil['PROFIL_ID']==20 ){
         $data = array(
          'ID_HABITANT'=>$ID_HABITANT,
          'USER_ID'=>$id_utilisateur,
          'ID_STATUT'=>4);
         $table = 'histo_validation_habitant';
         $this->Modele->create($table, $data);
        }
      //CHEF DES QUARTIER
      else if($profil['PROFIL_ID']==22 ){
      	$data = array('ID_STATUT'=>4);
         $this->Modele->update('histo_validation_habitant', array('ID_HABITANT' =>$ID_HABITANT), $data);
      }
      //CHEF DES ZONE
      else if($profil['PROFIL_ID']==21 ){
      	$data = array('ID_STATUT'=>4);
         $this->Modele->update('histo_validation_habitant', array('ID_HABITANT' =>$ID_HABITANT), $data);
      }
      print_r(json_encode(1));
    }
    function get_avenues($COLLINE_ID = 0)
	{
		$avenues = $this->Model->getRequete('SELECT AVENUE_ID,AVENUE_NAME FROM syst_avenue WHERE 	COLLINE_ID=' . $COLLINE_ID . ' ORDER BY AVENUE_NAME ASC');
		$html = '<option value="">---selectionner---</option>
		 ';
		foreach ($avenues as $key) {
			$html .= '<option value="' . $key['AVENUE_ID'] . '">' . $key['AVENUE_NAME'] . '</option>';
		}
		echo json_encode($html);
	}
	function get_avenuesAdd($COLLINE_ID = 0)
	{
		$avenues = $this->Model->getRequete('SELECT AVENUE_ID,AVENUE_NAME FROM syst_avenue WHERE 	COLLINE_ID=' . $COLLINE_ID . ' ORDER BY AVENUE_NAME ASC');
		$html = '<option value="">---selectionner---</option>
		 <option value="Autre"><input type="checkbox">
                      <label>Autre avenue</label>
                    </option>';
		foreach ($avenues as $key) {
			$html .= '<option value="' . $key['AVENUE_ID'] . '">' . $key['AVENUE_NAME'] . '</option>';
		}
		echo json_encode($html);
	}
	function get_communes($ID_PROVINCE = 0)
	{
		$communes = $this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID=' . $ID_PROVINCE . ' ORDER BY COMMUNE_NAME ASC');
		$html = '<option value="">---selectionner---</option>';
		foreach ($communes as $key) {
			$html .= '<option value="' . $key['COMMUNE_ID'] . '">' . $key['COMMUNE_NAME'] . '</option>';
		}
		echo json_encode($html);
	}

	function get_zones($ID_COMMUNE = 0)
	{
		$zones = $this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID=' . $ID_COMMUNE . ' ORDER BY ZONE_NAME ASC');
		$html = '<option value="">---selectionner---</option>';
		foreach ($zones as $key) {
			$html .= '<option value="' . $key['ZONE_ID'] . '">' . $key['ZONE_NAME'] . '</option>';
		}
		echo json_encode($html);
	}

	function get_collines($ID_ZONE = 0)
	{
		$collines = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID=' . $ID_ZONE . ' ORDER BY COLLINE_NAME ASC');
		$html = '<option value="">---selectionner---</option>';
		foreach ($collines as $key) {
			$html .= '<option value="' . $key['COLLINE_ID'] . '">' . $key['COLLINE_NAME'] . '</option>';
		}
		echo json_encode($html);
	}

}
	