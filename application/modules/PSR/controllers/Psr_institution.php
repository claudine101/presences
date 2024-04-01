<?php

/**
 * Auteur NDAYISABA CLAUDINE
 * email prof:claudine@mediabox.bi
 * En date du 04/04/2023 a partir de 8h
 *	CRUD PSR INSTITUTION
 **/
class Psr_institution extends CI_Controller
{
    function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}
	public function have_droit()
	{
		if ($this->session->userdata('PSR_ELEMENT') != 1 ) {

			redirect(base_url());
		}
	}
	function index()
	{
		$paiement = array(
		    "Non payée" => "2",
		    "Payée" => "1");
		$data['paiement']=$paiement;
		$statuts = array(
		    "Activer" => "1",
		    "Désactiver" => "2");
		$data['statuts']=$statuts;
		$data['title']=" Institutions";
		$this->load->view('institution/Psr_institution_List_View',$data);
	}
	
	//Fonctions pour afficher les nombres de chauffeurs
	function get_vehicule($id){
		$chauffeur=$this->Model->getRequeteOne('SELECT COUNT(uv.ID_PSR_INSTITUTION)  AS nbre FROM  utilisateur_vehicule uv  WHERE uv.ID_PSR_INSTITUTION='.$id);
          return  !empty($chauffeur['nbre']) ? $chauffeur['nbre'] : 0;

	}

	//Fonctions pour afficher les nombres des vehicules  
	function get_chauffeur($id){
		$vehicule=$this->Model->getRequeteOne('SELECT COUNT(up.ID_PSR_INSTITUTION)  AS nbre FROM  utilisateur_permis  up  WHERE up.ID_PSR_INSTITUTION='.$id);
		return  !empty($vehicule['nbre']) ? $vehicule['nbre'] : 0;

	}
	//fonction pour lister les donnees dans la table
	function listing()
	{
		$i=1;
		$STATUT = $this->input->post('STATUT');
		$criteres_statut="";
          if (!empty($STATUT)){
               if ($STATUT==2)
               {
                $STATUT=0;
               }
                $criteres_statut=" AND psr_institution.IS_ACTIF=".$STATUT;
                if ($STATUT==0)
               {
                $STATUT=2;
               }
              }
		$query_principal='SELECT psr_institution.ID_PSR_INSTITUTION,concat(NOM_INSTITUTION," ",LOGO_INSTITUTION)as logo, psr_institution.NOM_INSTITUTION,psr_institution.IS_ACTIF, psr_institution.PERSONNE_CONTACT, psr_institution.TELEPHONE_PERSONNE,psr_institution.EMAIL_PERSONNE,psr_institution.ADRESSE,psr_institution.LOGO_INSTITUTION,psr_institution.DATE_ENREGISTREMENT FROM psr_institution where 1 and  ID_PSR_INSTITUTION >1 '.$criteres_statut;
		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit='LIMIT 0,10';
		if($_POST['length'] != -1){
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		$order_by='';
		$order_column=array('psr_institution.ID_PSR_INSTITUTION','psr_institution.NOM_INSTITUTION','psr_institution.PERSONNE_CONTACT','psr_institution.TELEPHONE_PERSONNE','psr_institution.EMAIL_PERSONNE','psr_institution.ADRESSE','psr_institution.LOGO_INSTITUTION ','psr_institution.DATE_ENREGISTREMENT');
		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY psr_institution.NOM_INSTITUTION ASC';

		$search = !empty($_POST['search']['value']) ? ("AND psr_institution.NOM_INSTITUTION LIKE '%$var_search%'or PERSONNE_CONTACT LIKE '%$var_search%' or TELEPHONE_PERSONNE LIKE '%$var_search%'or EMAIL_PERSONNE LIKE '%$var_search%'or ADRESSE LIKE '%$var_search%'or LOGO_INSTITUTION LIKE '%$var_search%'or DATE_ENREGISTREMENT LIKE '%$var_search%'  "):'';     

		$critaire = '';

		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;

		$fetch_psr = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_psr as $row)
		{
			$nbre_vehicule=$this->get_vehicule($row->ID_PSR_INSTITUTION);
			$nbre_chauffeur=$this->get_chauffeur($row->ID_PSR_INSTITUTION);
			$montant_permis=$this->getMontant_permis($row->ID_PSR_INSTITUTION);
			$montant_vehicule=$this->getMontant($row->ID_PSR_INSTITUTION);

              if($row->IS_ACTIF==0)
              {   $labelle='Activer';
                  $color = 'green';
                  $btn = 'btn-danger';
              }else {
                  $labelle='Désactiver';
                  $color = 'red';
                  $btn = 'btn-success';
              }

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_PSR_INSTITUTION . "'>
			<label class='text-danger'>&nbsp;&nbsp;Supprimer</label></a></li>


			";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Psr_institution/getOne/'.$row->ID_PSR_INSTITUTION)."'><label class='text-secondary'>&nbsp;&nbsp;Modifier</label></a></li>";

			$option .= "<li><a class='btn-md' href='#' onclick='chauffeur(".$row->ID_PSR_INSTITUTION.")'><label class='text-secondary'>&nbsp;&nbsp;Chauffeur(".$nbre_chauffeur.")</label></a></li>";
			$option .= "<li><a class='btn-md' href='#' onclick='vehicule(".$row->ID_PSR_INSTITUTION.")'><label class='text-secondary'>&nbsp;&nbsp;Véhicule(".$nbre_vehicule.")</label></a></li>";
               $option .= "<li><a class='btn-md' href='#' title=".$row->NOM_INSTITUTION." onclick='amende_permis(".$row->ID_PSR_INSTITUTION.",this.title)'><label class='text-secondary'>&nbsp;&nbsp;Amende pemis</label></a></li>";
               $option .="<li><a class='btn-md' href='#' title=".$row->NOM_INSTITUTION."  onclick='amende_vehicule(".$row->ID_PSR_INSTITUTION.",this.title)'><label class='text-secondary'>&nbsp;&nbsp;Amende Véhicule</label></a></li>";
               $row->IS_ACTIF==0 ?
               $option .= "<li><hre='#'  id='".$row->NOM_INSTITUTION."'  title='".$row->NOM_INSTITUTION."'  onclick='activer(".$row->ID_PSR_INSTITUTION.",this.title,this.id)'><label class='text-secondary'>&nbsp;&nbsp;".$labelle."</label></a></li>":$option .= "<li><hre='#'  id='".$row->NOM_INSTITUTION."'  title='".$row->NOM_INSTITUTION."'  onclick='desactiver(".$row->ID_PSR_INSTITUTION.",this.title,this.id)'><label class='text-danger'>&nbsp;&nbsp;".$labelle."</label></a></li>";

			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_PSR_INSTITUTION . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" .$row->NOM_INSTITUTION."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Psr_institution/delete/'.$row->ID_PSR_INSTITUTION) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			$source = !empty($row->LOGO_INSTITUTION) ? $row->LOGO_INSTITUTION : base_url()."/uploads/personne.png";
			$sub_array[] = '<table> <tbody><tr><td><a title="' . $source . '" href="#" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM_INSTITUTION . ' </td></tr></tbody></table></a>';
			$sub_array[]=$row->PERSONNE_CONTACT;
			$sub_array[]=$row->TELEPHONE_PERSONNE; 
			$sub_array[]=$row->EMAIL_PERSONNE;
			$sub_array[]=$row->ADRESSE;	
			if ($row->IS_ACTIF==1) {
                    $sub_array[]='<center><div class=" btn-sm"><i title="Activer" class="fa fa-check" aria-hidden="true"></i></div></center>';
               } else {
                    $sub_array[]='<center><div class=" btn-sm"><i title="Désactiver" class="fa fa-times" aria-hidden="true"></i></div></center>';

               }
			$sub_array[] ="
                <a class = 'btn btn-success btn-sm ' onclick='chauffeur(".$row->ID_PSR_INSTITUTION.")' style='float:right' ><span class = ''>".$nbre_chauffeur."</span></a>";
                $sub_array[] ="
                <a class = 'btn btn-success btn-sm ' onclick='vehicule(".$row->ID_PSR_INSTITUTION.")' style='float:right' ><span class = ''>".$nbre_chauffeur."</span></a>";
                $sub_array[]="
                <a class = 'btn btn-success btn-sm ' title=".$row->NOM_INSTITUTION." onclick='amende_permis(".$row->ID_PSR_INSTITUTION.",this.title)' style='float:right'><span class = ''>".$montant_permis."</span></a>";	
		
			$sub_array[]="
                <a class = 'btn btn-success btn-sm ' title=".$row->NOM_INSTITUTION." onclick='amende_vehicule(".$row->ID_PSR_INSTITUTION.",this.title)' style='float:right'><span class = ''>".$montant_vehicule."</span></a>";	

			$sub_array[]=$row->DATE_ENREGISTREMENT;		
			$sub_array[]=$option;   
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST['draw']),
			"recordsTotal" =>$this->Modele->all_data($query_principal),
			"recordsFiltered" => $this->Modele->filtrer($query_filter),
			"data" => $data
		);
		echo json_encode($output);

	}



   // fonction retour a la page des listes
	public function retour(){
		$this->index();
	}

	//function pour aller dans un formulaire d'insertion

	public function ajouter(){
		$data['title']=" Nouveau institution PSR";

		$this->load->view('institution/Psr_institution_Add_View',$data);

	}
    // POUR  VERIFIER SI  LA VALEUR D'UN POUR CONTIENT LE CARACTERE ' "' 
	function validate_name($name)
     {
               if (preg_match('/"/',$name)) {
                 $this->form_validation->set_message("validate_name","Le champ contient des caractères non valides");
                return FALSE;
               }
               else{
                    return TRUE;
               }
             
     }

// fonction d'insertion dans la base de donnee

  
	function add()
	{
		$this->form_validation->set_rules('nom_instutition','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('personne','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('telephone','', 'trim|required|callback_validate_name|is_unique[psr_institution.TELEPHONE_PERSONNE]',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>',
			'is_unique'=>'<font style="color:red;font-size:8px,">Ce numéro de téléphone existe </font>'));

		$this->form_validation->set_rules('email','', 'trim|required|callback_validate_name|is_unique[psr_institution.EMAIL_PERSONNE]',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>',
			'is_unique'=>'<font style="color:red;font-size:8px,">Email existe </font>'));

		$this->form_validation->set_rules('adresse','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if($this->form_validation->run() == FALSE)
		{
			$this->ajouter();
		}else{


			$file= $_FILES['PHOTO'];
			$path='./uploads/Gestion_Publication_Menu/';
			if(!is_dir(FCPATH.'/uploads/Gestion_Publication_Menu/')){
				mkdir(FCPATH.'/uploads/Gestion_Publication_Menu/', 0777, TRUE);
			}

			$thepath= base_url().'uploads/Gestion_Publication_Menu/';
			$config['upload_path']= './uploads/Gestion_Publication_Menu/';
			$photonames= date('ymdHisa');
			$config['file_name']=$photonames;
			$config['allowed_types']= '*';
			$this->upload->initialize($config);
			$this->upload->do_upload("PHOTO");
			$info=$this->upload->data();

			if($file==''){
				$pathfile= base_url().'uploads/sevtb.png';
			}else{
				$pathfile= base_url().'/uploads/Gestion_Publication_Menu/'.$photonames.$info['file_ext'];
			}        

			$nom_instutition= $this->input->post('nom_instutition');
			$personne= $this->input->post('personne');
			$telephone= $this->input->post('telephone');
			$email= $this->input->post('email');
			$adresse= $this->input->post('adresse');

			$data_insert=array(

				'NOM_INSTITUTION'=>$nom_instutition,
				'PERSONNE_CONTACT'=>$personne,
				'TELEPHONE_PERSONNE'=>$telephone,
				'EMAIL_PERSONNE'=>$email,
				'ADRESSE'=>$adresse,
				'LOGO_INSTITUTION'=>$pathfile
			);
			//print_r($data_insert); die();
			$table='psr_institution';
			$this->Modele->create($table,$data_insert);
			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'enregistrement d'une institution PSR est fait avec succès" . '</div>';
			$this->session->set_flashdata($data);

			redirect(base_url('PSR/Psr_institution'));

		}

	}

	public function getOne($id_psr)
	{
		$prs=$this->Model->getRequeteOne('SELECT `ID_PSR_INSTITUTION`, `NOM_INSTITUTION`, `PERSONNE_CONTACT`, `TELEPHONE_PERSONNE`, `EMAIL_PERSONNE`, `ADRESSE`, `LOGO_INSTITUTION`, `DATE_ENREGISTREMENT` FROM `psr_institution` WHERE ID_PSR_INSTITUTION='.$id_psr);
		$data['prs']=$prs;
		$data['title'] = "Modification d'une institution PSR";

		$this->load->view('institution/Psr_institution_Edit_View', $data);
	}


	public function Edit()
	{
		$id_inst = $this->input->post('id_inst');
		$this->form_validation->set_rules('nom_instutition','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('personne','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('telephone','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('email','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('adresse','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if($this->form_validation->run() == FALSE)
		{
			$this->getOne($id_inst);
		}else{


			$file= $_FILES['PHOTO'];
			$path='./uploads/Gestion_Publication_Menu/';
			if(!is_dir(FCPATH.'/uploads/Gestion_Publication_Menu/')){
				mkdir(FCPATH.'/uploads/Gestion_Publication_Menu/', 0777, TRUE);
			}

			$thepath= base_url().'uploads/Gestion_Publication_Menu/';
			$config['upload_path']= './uploads/Gestion_Publication_Menu/';
			$photonames= date('ymdHisa');
			$config['file_name']=$photonames;
			$config['allowed_types']= '*';
			$this->upload->initialize($config);
			$this->upload->do_upload("PHOTO");
			$info=$this->upload->data();

			if($file==''){
				$pathfile= base_url().'uploads/sevtb.png';
			}else{
				$pathfile= base_url().'/uploads/Gestion_Publication_Menu/'.$photonames.$info['file_ext'];
			}        

			$nom_instutition= $this->input->post('nom_instutition');
			$personne= $this->input->post('personne');
			$telephone= $this->input->post('telephone');
			$email= $this->input->post('email');
			$adresse= $this->input->post('adresse');

			$data_insert=array(

				'NOM_INSTITUTION'=>$nom_instutition,
				'PERSONNE_CONTACT'=>$personne,
				'TELEPHONE_PERSONNE'=>$telephone,
				'EMAIL_PERSONNE'=>$email,
				'ADRESSE'=>$adresse,
				'LOGO_INSTITUTION'=>$pathfile
			);
			
			$this->Model->update('psr_institution',array('ID_PSR_INSTITUTION'=>$id_inst),$data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">L\'institution PSR a été modifié avec succès</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Psr_institution'));

		}

	}

//function supprimer
	public function delete($ID){
		$this->Model->delete('psr_institution',array('ID_PSR_INSTITUTION'=>$ID));
		$data['message'] = '<div class="alert alert-success text-center" id="message">' . " L'institution PSR a été Supprimé  avec succès" . '</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Psr_institution')); 
	}

     //fonction pour lister les chauffeurs d'une institution


	function chauffeur($id)
	{
		
		$query_principal = "SELECT cp.POINTS, cp.ID_PERMIS, cp.NUMERO_PERMIS, cp.NOM_PROPRIETAIRE, cp.CATEGORIES, cp.DATE_NAISSANCE, cp.DATE_DELIVER, cp.DATE_EXPIRATION,cp.TELEPHONE,cp.LOGO_PROFIL,pi.NOM_INSTITUTION FROM utilisateur_permis up LEFT  JOIN chauffeur_permis cp ON cp.ID_PERMIS=up.ID_PERMIS LEFT JOIN psr_institution pi ON pi.ID_PSR_INSTITUTION=up.ID_PSR_INSTITUTION  LEFT JOIN immatriculation_permis ip ON ip.ID_IMMATRICULATION_PERMIS=cp.ID_PERMIS WHERE 1 AND pi.ID_PSR_INSTITUTION=".$id ;

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';


		$order_column = array('NOM_PROPRIETAIRE','NUMERO_PERMIS','POINTS','TELEPHONE', 'CATEGORIES','NOM_INSTITUTION', 'DATE_NAISSANCE', 'DATE_DELIVER', 'DATE_EXPIRATION');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY Nom ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NUMERO_PERMIS LIKE '%$var_search%' OR NOM_PROPRIETAIRE LIKE '%$var_search%' OR CATEGORIES LIKE '%$var_search%'  ") : '';

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

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_PERMIS . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Chauffeur_permis/getOne/' . $row->ID_PERMIS) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= "<li>
              <a class='btn-md' title='".$row->NUMERO_PERMIS."' onclick='show_permis(this.title)' class='btn btn-md dt-button btn-sm' href='#'><label class='text-info'>&nbsp;&nbsp;TB Permis</label></a>
			</li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" . $row->ID_PERMIS . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->NOM_PROPRIETAIRE . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Chauffeur_permis/delete/' . $row->ID_PERMIS) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$debut = date("d-m-Y", strtotime($row->DATE_DELIVER));
			$fin = date("d-m-Y", strtotime($row->DATE_EXPIRATION));

			$source = !empty($row->LOGO_PROFIL) ? $row->LOGO_PROFIL : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			$sub_array = array();
			$sub_array[] = '<table> <tbody><tr><td><a title="' . $source . '" href="#" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>'.$row->NOM_PROPRIETAIRE.'</td></tr></tbody></table></a>';

			$sub_array[] = "<a title='".$row->NUMERO_PERMIS."' onclick='show_permis(this.title)' class='btn btn-md dt-button btn-sm' href='#'>" .$row->NUMERO_PERMIS. "</a>";
			$sub_array[] = $row->POINTS;
			$sub_array[] = !empty($row->TELEPHONE)?$row->TELEPHONE:'N/A';
			$sub_array[] = $row->CATEGORIES;
			$sub_array[] = !empty($row->NOM_INSTITUTION)?$row->NOM_INSTITUTION:'N/A';
			$sub_array[] = $this->notifications->ago($row->DATE_NAISSANCE, date('Y-m-d'));
			$sub_array[] = $debut;
			$sub_array[] = $fin;
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
	//fonction pour lister les vehicules d'une institution


	function vehicule($id)
	{

		$query_principal = "SELECT obr.ID_IMMATRICULATION,  obr.NUMERO_CARTE_ROSE,  obr.NUMERO_PLAQUE,  obr.CATEGORIE_PLAQUE,  obr.MARQUE_VOITURE,  obr.NUMERO_CHASSIS,  obr.NOMBRE_PLACE,  obr.NOM_PROPRIETAIRE,  obr.PRENOM_PROPRIETAIRE,  obr.NUMERO_IDENTITE,  obr.CATEGORIE_PROPRIETAIRE,  obr.CATEGORIE_USAGE,  obr.PUISSANCE,  obr.COULEUR,  obr.ANNEE_FABRICATION,  obr.DATE_INSERTION,  obr.MODELE_VOITURE,  obr.POIDS,  obr.TYPE_CARBURANT,  obr.TAXE_DMC,  obr.NIF,  obr.TELEPHONE,  obr.EMAIL,  obr.DATE_DELIVRANCE FROM utilisateur_vehicule uv LEFT JOIN  obr_immatriculations_voitures obr  ON
               obr.NUMERO_PLAQUE=uv.NUMERO_PLAQUE LEFT JOIN 
               psr_institution p ON p.ID_PSR_INSTITUTION=uv.ID_PSR_INSTITUTION  
               WHERE 1 AND p.ID_PSR_INSTITUTION=".$id;

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);


		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';


		$order_column = array('obr.NUMERO_CARTE_ROSE', 'obr.NUMERO_PLAQUE', 'obr.CATEGORIE_PLAQUE', 'obr.MARQUE_VOITURE', 'obr.NUMERO_CHASSIS', 'obr.NOMBRE_PLACE', 'obr.NOM_PROPRIETAIRE', 'obr.PRENOM_PROPRIETAIRE', 'obr.NUMERO_IDENTITE', 'obr.CATEGORIE_PROPRIETAIRE', 'obr.CATEGORIE_USAGE', 'obr.PUISSANCE', 'obr.COULEUR', 'obr.ANNEE_FABRICATION', 'obr.DATE_INSERTION', 'obr.MODELE_VOITURE', 'obr.POIDS', 'obr.TYPE_CARBURANT', 'obr.TAXE_DMC', 'obr.NIF', 'obr.DATE_DELIVRANCE');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM,PRENOM ASC';

		$search = !empty($_POST['search']['value']) ? ("AND obr.NUMERO_CARTE_ROSE LIKE '%$var_search%' OR obr.NUMERO_PLAQUE LIKE '%$var_search%' OR obr.NOM_PROPRIETAIRE LIKE '%$var_search%'  ") : '';

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

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_IMMATRICULATION . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Obr_Immatriculation/getOne/' . $row->ID_IMMATRICULATION) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= "<li>
                     <a class='btn-md' title='".$row->NUMERO_PLAQUE."' onclick='show_vehicule_detail(this.title)' class='btn btn-md dt-button btn-sm' href='#'><label class='text-info'>&nbsp;&nbsp;Tableau de bord</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_IMMATRICULATION . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->NOM_PROPRIETAIRE . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Obr_Immatriculation/delete/' . $row->ID_IMMATRICULATION) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			$source = !empty($row->PHOTO) ? $row->PHOTO : base_url()."/uploads/personne.png";

			
			$sub_array[] =  '<table> <tbody><tr><td><a title="' . $source . '" href="#" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:25px;height:25px" src="' . $source . '"></a></td><td>' . $row->NOM_PROPRIETAIRE . ' ' . $row->PRENOM_PROPRIETAIRE . '</td></tr></tbody></table></a>';

			$sub_array[] = "<a title='".$row->NUMERO_PLAQUE."' onclick='show_vehicule_detail(this.title)' class='btn btn-md dt-button btn-sm' href='#'>" .$row->NUMERO_PLAQUE. "</a>";


			$sub_array[] = !empty($row->NUMERO_CARTE_ROSE) ? $row->NUMERO_CARTE_ROSE : '---';

			$sub_array[] = $row->TELEPHONE . "<br>" . $row->EMAIL;

			$sub_array[] = $row->CATEGORIE_PLAQUE;
			$sub_array[] = $row->MARQUE_VOITURE;
			$sub_array[] = $row->NUMERO_CHASSIS;
			$sub_array[] = $row->NOMBRE_PLACE;
			
			$sub_array[] = $row->NUMERO_IDENTITE;
			$sub_array[] = $row->CATEGORIE_PROPRIETAIRE;
			$sub_array[] = $row->CATEGORIE_USAGE;
			$sub_array[] = $row->PUISSANCE;
			$sub_array[] = $row->COULEUR;
			$sub_array[] = $row->ANNEE_FABRICATION;
			$sub_array[] = $row->MODELE_VOITURE;
			$sub_array[] = $row->POIDS;
			$sub_array[] = $row->TYPE_CARBURANT;
			$sub_array[] = $row->TAXE_DMC;
			$sub_array[] = $row->NIF;
			
			$sub_array[] = $row->DATE_DELIVRANCE;
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


	//fonction pour recuperer l'institution  afficher  en title de la modal
	function getInstitution($id_psr){
		$pesseur=$this->Model->getRequeteOne('SELECT `ID_PSR_INSTITUTION`, `NOM_INSTITUTION`, `PERSONNE_CONTACT`, `TELEPHONE_PERSONNE`, `EMAIL_PERSONNE`, `ADRESSE`, `LOGO_INSTITUTION`, `DATE_ENREGISTREMENT` FROM `psr_institution` WHERE ID_PSR_INSTITUTION='.$id_psr);

		echo json_encode($pesseur);
	}
	//fonction pour recuperer amendes totaux dune 'institution  
	function getMontant($id_psr){

    $DATE1 = $this->input->post('DATE1');  
    $DATE2 = $this->input->post('DATE2');  
    $STATUT = $this->input->post('STATUT');
    $NUMERO_PLAQUE = $this->input->post('NUMERO_PLAQUE');

    $criteres_numero =" ";
    $criteres_date = "";
    $criteres_statut= "";
    if(!empty($NUMERO_PLAQUE) ){
           $criteres_date = "AND h.NUMERO_PLAQUE LIKE '%" . $NUMERO_PLAQUE."%'";
           }
        if(!empty($DATE1) && empty($DATE2)){
           $criteres_date = "AND DATE_FORMAT(h.DATE_INSERTION, '%Y-%m-%d')='" . $DATE1."'";
           }
           if(empty($DATE1) && !empty($DATE2)){
            $criteres_date = " AND DATE_FORMAT(h.DATE_INSERTION, '%Y-%m-%d')='" . $DATE2."'";
           }
          if (!empty($DATE1) && !empty($DATE2)) {
          $criteres_date = " AND DATE_FORMAT(h.DATE_INSERTION, '%Y-%m-%d') between  '". $DATE1."'  AND  '" .$DATE2."'";   
          }   
          if (!empty($STATUT)){
               if ($STATUT==2)
               {
                $STATUT=0;
               }
                $criteres_statut=" AND h.IS_PAID=".$STATUT;
                if ($STATUT==0)
               {
                $STATUT=2;
               }
              }
		$montant=$this->Model->getRequeteOne('SELECT SUM(h.MONTANT_TOTAL)  AS montant FROM historiques h LEFT JOIN utilisateur_vehicule uv on uv.NUMERO_PLAQUE=h.NUMERO_PLAQUE  WHERE uv.ID_PSR_INSTITUTION='.$id_psr.''.$criteres_numero.' '.$criteres_date.' '.$criteres_statut);
		$montantFormat =  !empty($montant) ? number_format(floatval($montant['montant']), 0, ',', ' ') : 0;
		return  $montantFormat;

	}
	//fonction pour recuperer amendes totaux dune 'institution  
	function getMontant_permis($id_psr){

    $DATE1 = $this->input->post('DATE1');  
    $DATE2 = $this->input->post('DATE2');  
    $STATUT = $this->input->post('STATUT');
    $NUMERO_PERMIS = $this->input->post('NUMERO_PERMIS');

    $criteres_numero =" ";
    $criteres_date = "";
    $criteres_statut= "";
    if(!empty($NUMERO_PERMIS) ){
           $criteres_date = "AND h.NUMERO_PERMIS LIKE '%" . $NUMERO_PERMIS."%'";
           }
        if(!empty($DATE1) && empty($DATE2)){
           $criteres_date = "AND DATE_FORMAT(h.DATE_INSERTION, '%Y-%m-%d')='" . $DATE1."'";
           }
           if(empty($DATE1) && !empty($DATE2)){
            $criteres_date = " AND DATE_FORMAT(h.DATE_INSERTION, '%Y-%m-%d')='" . $DATE2."'";
           }
          if (!empty($DATE1) && !empty($DATE2)) {
          $criteres_date = " AND DATE_FORMAT(h.DATE_INSERTION, '%Y-%m-%d') between  '". $DATE1."'  AND  '" .$DATE2."'";   
          }   
          if (!empty($STATUT)){
               if ($STATUT==2)
               {
                $STATUT=0;
               }
                $criteres_statut=" AND h.IS_PAID=".$STATUT;
                if ($STATUT==0)
               {
                $STATUT=2;
               }
              }
		$montant=$this->Model->getRequeteOne('SELECT SUM(h.MONTANT_TOTAL)  AS montant FROM historiques h LEFT JOIN utilisateur_permis  up on up.NUMERO_PERMIS=h.NUMERO_PERMIS  WHERE up.ID_PSR_INSTITUTION='.$id_psr.''.$criteres_numero.' '.$criteres_date.' '.$criteres_statut);
		$montantFormat =  !empty($montant) ? number_format(floatval($montant['montant']), 0, ',', ' ') : 0;
		return  $montantFormat;
	}
  //fOnction pour afficher les amendes vehicule d'une institution
   function amende_vehicule($id=0){
    
    $DATE1 = $this->input->post('DATE1');  
    $DATE2 = $this->input->post('DATE2');  
    $STATUT = $this->input->post('STATUT');
    $NUMERO_PLAQUE = $this->input->post('NUMERO_PLAQUE');

    $criteres_numero =" ";
    $criteres_date = "";
    $criteres_statut= "";
    if(!empty($NUMERO_PLAQUE) ){
           $criteres_date = "AND h.NUMERO_PLAQUE LIKE '%" . $NUMERO_PLAQUE."%'";
           }
        if(!empty($DATE1) && empty($DATE2)){
           $criteres_date = "AND DATE_FORMAT(h.DATE_INSERTION, '%Y-%m-%d')='" . $DATE1."'";
           }
           if(empty($DATE1) && !empty($DATE2)){
            $criteres_date = " AND DATE_FORMAT(h.DATE_INSERTION, '%Y-%m-%d')='" . $DATE2."'";
           }
          if (!empty($DATE1) && !empty($DATE2)) {
          $criteres_date = " AND DATE_FORMAT(h.DATE_INSERTION, '%Y-%m-%d') between  '". $DATE1."'  AND  '" .$DATE2."'";   
          }   
          if (!empty($STATUT)){
               if ($STATUT==2)
               {
                $STATUT=0;
               }
                $criteres_statut=" AND h.IS_PAID=".$STATUT;
                if ($STATUT==0)
               {
                $STATUT=2;
               }
              }
    
    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
    $query_principal = 'SELECT h.ID_COMPORTEMENT, h.RAISON_ANNULATION, ID_CONTROLE_MARCHANDISE,ID_HISTORIQUE,h.ID_CONTROLE,h.ID_HISTORIQUE_CATEGORIE, hc.DESCRIPTION as historique_categorie,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_IMMATRICULATIO_PEINE) AS IMMATRICULATION,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_ASSURANCE_PEINE) AS ASSURANCE,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_CONTROLE_TECHNIQUE_PEINE) AS CONTROL_TECHNIQUE,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_VOL_PEINE) AS VOL,(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_PERMIS_PEINE) AS PERMIS_PEINE, h.NUMERO_PLAQUE ,ID_IMMATRICULATIO_PEINE,ID_ASSURANCE_PEINE,ID_CONTROLE_TECHNIQUE_PEINE,ID_VOL_PEINE,ID_PERMIS_PEINE, NUMERO_PERMIS, concat(pe.NOM," ",pe.PRENOM) as user,pe.NUMERO_MATRICULE,pe.ID_PSR_ELEMENT, h.LATITUDE, h.LONGITUDE,h.DATE_INSERTION,h.MONTANT_TOTAL,h.IS_PAID,ID_CONTROLE_EQUIPEMENT,ID_SIGNALEMENT FROM historiques h LEFT JOIN historiques_categories hc ON h.ID_HISTORIQUE_CATEGORIE=hc.ID_CATEGORIE LEFT JOIN utilisateurs us ON us.ID_UTILISATEUR=h.ID_UTILISATEUR  LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT = us.PSR_ELEMENT_ID LEFT JOIN utilisateur_vehicule uv on uv.NUMERO_PLAQUE=h.NUMERO_PLAQUE  WHERE uv.ID_PSR_INSTITUTION= '.$id.'  '.$criteres_date . ' '.$criteres_statut;

    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
    $limit = 'LIMIT 0,10';
    if ($_POST['length'] != -1) {
      $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }
    $order_by = '';
    $order_column = array('user', 'DATE_INSERTION', 'historique_categorie', 'RAISON_ANNULATION', 'NUMERO_PLAQUE', 'NUMERO_PERMIS', 'MONTANT_TOTAL', 'IS_PAID', 'DATE_INSERTION');
    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_INSERTION DESC ';

    $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%' ") : '';



    $query_secondaire = $query_principal .  ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $search;

    $fetch_psr = $this->Modele->datatable($query_secondaire);
    $data = array();

    foreach ($fetch_psr as $row) {

      $controleMarch = '';
      $controleSignale = '';
      $controleSignalement = '';
      $controleEquipement = '';
      $controleEquipe = '';
      $controlePhysique = '';
      $controlePhy = '';
      $infraplaque = '';
      $infrassur = '';
      $infracontrp = '';
      $infravol = '';
      $infrapermis = '';
      $plaque = '';
      $permis = '';
      $AutresControles = '';
      $option = '';




      if ($row->ID_COMPORTEMENT != Null) {
        $comportementPermis = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $comportementPermis = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }


      $comportPermis = "<a hre='#' data-toggle='modal'
      data-target='#detailComport" . $row->ID_HISTORIQUE . "'>" . $comportementPermis . "</a>";


      $comportPermis .= "<div class='modal fade' id='detailComport" . $row->ID_HISTORIQUE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du Control permis</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_COMPORTEMENT != Null) {
        $comportPermis .= $this->getDetailComport($row->ID_COMPORTEMENT);
      }


      $comportPermis .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";






      if ($row->IMMATRICULATION != Null) {
        $infra = $row->IMMATRICULATION;
      } else {
        $infra = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
      }
      if ($row->ASSURANCE != Null) {
        $infrassur = $row->ASSURANCE;
      } else {
        $infrassur = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
      }
      if ($row->CONTROL_TECHNIQUE != Null) {
        $infracontrp = $row->CONTROL_TECHNIQUE;
      } else {
        $infracontrp = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
      }
      if ($row->VOL != Null) {
        $infravol = $row->VOL;
      } else {
        $infravol = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-times"></i></a>';
      }
      if ($row->PERMIS_PEINE != Null) {
        $infrapermis = $row->PERMIS_PEINE;
      } else {
        $infrapermis = !empty($row->NUMERO_PERMIS) ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }

      if ($row->NUMERO_PLAQUE != Null) {
        $plaques = $this->getPlaques($row->NUMERO_PLAQUE);

        if ($plaques != null) {
          $plaque = "<a title='".$row->NUMERO_PLAQUE."' onclick='show_vehicule_detail(this.title)' class='btn btn-md dt-button btn-sm' href='#'>" . $row->NUMERO_PLAQUE . "</a>";
        } else {
          $plaque = "<div class='btn btn-outline-danger''>" . $row->NUMERO_PLAQUE . "</div>";
        }
      } else {
        $plaque = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }
      if ($row->MONTANT_TOTAL != Null) {
        $montant = $row->MONTANT_TOTAL;
      } else {
        $montant = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
      }
      if ($row->NUMERO_PERMIS != Null) {
        $idPermit = $this->getPermis($row->NUMERO_PERMIS);

        if ($idPermit != null) {
          $permis = "<a title='".$row->NUMERO_PERMIS."' onclick='show_permis(this.title)' class='btn btn-md dt-button btn-sm' href='#'>" . $row->NUMERO_PERMIS . "</a>";
        } else {
          $permis = "<span style='color :red'>" . $row->NUMERO_PERMIS . "</span>";
        }
      } else {
        $permis = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }

      if ($row->ID_CONTROLE != Null) {
        $controlePhy = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $controlePhysique = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }

      if ($row->ID_CONTROLE_EQUIPEMENT != Null) {
        $controleEquipe = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $controleEquipe = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }

      if ($row->ID_SIGNALEMENT != Null) {
        $controleSignale = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $controleSignalement = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }


      if ($row->ID_CONTROLE_MARCHANDISE != Null) {
        $controleMarch = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $controleMarch = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }



      $detailMarch = "<a hre='#' data-toggle='modal'
      data-target='#detailMarchs" . $row->ID_HISTORIQUE . "'>" . $controleMarch . "</a>";


      $detailMarch .= "<div class='modal fade' id='detailMarchs" . $row->ID_HISTORIQUE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du Controle Machandise</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_CONTROLE_MARCHANDISE != Null) {
        $detailMarch .= $this->getDetailMarchandise($row->ID_CONTROLE_MARCHANDISE);
      }

      $detailMarch .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";



      $detailSign = '';

      $detailSign .= "<a hre='#' data-toggle='modal'
      data-target='#detail" . $row->ID_SIGNALEMENT . "'>" . $controleSignale . "</a>";
      $detailSign .= "
      <div class='modal fade' id='detail" . $row->ID_SIGNALEMENT . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du Controle Pysique</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_SIGNALEMENT != Null) {
        // $detailSign .= $this->getDetaisSign($row->ID_SIGNALEMENT);
      }

      $detailSign .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";

      $detail = '';

      $detail .= "<a hre='#' data-toggle='modal'
      data-target='#detail" . $row->ID_CONTROLE . "'>" . $controlePhy . "</a>";
      $detail .= "
      <div class='modal fade' id='detail" . $row->ID_CONTROLE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du controle Physique</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_CONTROLE != Null) {
        $detail .= $this->getDetais($row->ID_CONTROLE);
      }

      $detail .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";



      $detailEqui = '';

      $detailEqui .= "<a hre='#' data-toggle='modal'
      data-target='#detailEquips" . $row->ID_CONTROLE_EQUIPEMENT . "'>" . $controleEquipe . "</a>";
      $detailEqui .= "
      <div class='modal fade' id='detailEquips" . $row->ID_CONTROLE_EQUIPEMENT . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du Controle Equipement</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_CONTROLE_EQUIPEMENT != Null) {
        $detailEqui .= $this->getDetailEQUI($row->ID_CONTROLE_EQUIPEMENT);
      }

      $detailEqui .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";



      $detailInfraimmatri = '';

      $detailInfraimmatri .= "<a hre='#' data-toggle='modal'
      data-target='#detailIMP" . $row->ID_IMMATRICULATIO_PEINE . "'><span style='color: red'>" . $infra . "</spa></a>";
      $detailInfraimmatri .= "
      <div class='modal fade' id='detailIMP" . $row->ID_IMMATRICULATIO_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";

      if ($row->ID_IMMATRICULATIO_PEINE != Null) {
        $detailInfraimmatri .= $this->getInfraImmatri($row->ID_IMMATRICULATIO_PEINE);
      }

      $detailInfraimmatri .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";

      $detailInfrassur = '';

      $detailInfrassur .= "<a hre='#' data-toggle='modal'
      data-target='#detailASSUR" . $row->ID_ASSURANCE_PEINE . "'><span style='color: red'>" . $infrassur . "</span></a>";
      $detailInfrassur .= "
      <div class='modal fade' id='detailASSUR" . $row->ID_ASSURANCE_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      $detailInfrassur .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";


      $detailInfrcontroltechnique = '';

      $detailInfrcontroltechnique .= "<a hre='#' data-toggle='modal'
      data-target='#detailCNTP" . $row->ID_CONTROLE_TECHNIQUE_PEINE . "'><span style='color: red'>" . $infracontrp . "</span></a>";
      $detailInfrcontroltechnique .= "
      <div class='modal fade' id='detailCNTP" . $row->ID_CONTROLE_TECHNIQUE_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";

      if ($row->ID_CONTROLE_TECHNIQUE_PEINE != Null) {
        $detailInfrcontroltechnique .= $this->getInfracontroleTechnique($row->ID_CONTROLE_TECHNIQUE_PEINE);
      }

      $detailInfrcontroltechnique .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";

      $detailInfravol = '';

      $detailInfravol .= "<a hre='#' data-toggle='modal'
      data-target='#detailVOL" . $row->ID_VOL_PEINE . "'><span style='color: red'>" . $infravol . "</span></a>";
      $detailInfravol .= "
      <div class='modal fade' id='detailVOL" . $row->ID_VOL_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";

      if ($row->ID_VOL_PEINE != Null) {
        $detailInfravol .= $this->getInfraVol($row->ID_VOL_PEINE);
      }

      $detailInfravol .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";


      $detailInfrapermis = '';

      $detailInfrapermis .= "<a hre='#' data-toggle='modal'
      data-target='#detailPMSP" . $row->ID_PERMIS_PEINE . "'><span style='color: red'>" . $infrapermis . "</span></a>";
      $detailInfrapermis .= "
      <div class='modal fade' id='detailPMSP" . $row->ID_PERMIS_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";

      if ($row->ID_PERMIS_PEINE != Null) {
        $detailInfrapermis .= $this->getInfraPermis($row->ID_PERMIS_PEINE);
      }

      $detailInfrapermis .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";


    

      $stat = '';

      if ($row->IS_PAID == 1) {
        $val_stat = '<button class="btn btn-info" style="white-space: nowrap">Payé</button>';
      } else {
        $val_stat = '<button class="btn btn-outline-info" style="white-space: nowrap">Non payé</button>';
      }

      $stat .= "<a href='#' data-toggle='modal'
      data-target='#stat" . $row->ID_HISTORIQUE . "'><font color='blue'>&nbsp;&nbsp;" . $val_stat . "</font></a>";
      $sub_array = array();
      $sub_array[] =  '<a class="nav-link" href="#"><table> <tbody><tr><td><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="https://app.mediabox.bi/wasiliEate/uploads/personne.png"></td><td>' . str_replace(" ", "<span style='color:#dee2e6'>_</span>", $row->user) . '<br>' . $row->NUMERO_MATRICULE . '</td></tr></tbody></table></a>';

      $sub_array[] = "<div class='text-center text-sm'>".(new DateTime($row->DATE_INSERTION, new DateTimeZone("Africa/Bujumbura")))->format('d-m-Y') . '<br>'.(new DateTime($row->DATE_INSERTION, new DateTimeZone("Africa/Bujumbura")))->format('H:i')."</div>";
      $sub_array[] = ucfirst(str_replace('Contrôle ', '', $row->historique_categorie));
      $option = "<a class='btn  btn-sm btn-outline-secondary' onclick='getDetailControl(".$row->ID_HISTORIQUE.")'  href='#'>🧐voir plu...</a>";
      if($row->RAISON_ANNULATION == null) {
        $annule = "<span class='btn btn-outline-info disabled'>Non</span>";
      } else {
        $annule = "<span class='btn btn-danger'>Oui</span>";
      }
      $sub_array[] = $annule;
      $sub_array[] = $plaque;
      $sub_array[] = $permis;
      $montant =  !empty($montant) ? number_format(floatval($montant), 0, ',', ' ') : 0;
      $sub_array[] = "<b style='float:right'>" . $montant . "</b>";
      $sub_array[] = $stat;
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
  

  //fOnction pour afficher les amendes permis d'une institution
   function amende_permis($id=0){
    $DATE1 = $this->input->post('DATE1');  
    $DATE2 = $this->input->post('DATE2');  
    $STATUT = $this->input->post('STATUT');
    $NUMERO_PERMIS = $this->input->post('NUMERO_PERMIS');

    $criteres_numero =" ";
    $criteres_date = "";
    $criteres_statut= "";
    if(!empty($NUMERO_PERMIS) ){
           $criteres_date = "AND h.NUMERO_PERMIS LIKE '%" . $NUMERO_PERMIS."%'";
           }
        if(!empty($DATE1) && empty($DATE2)){
           $criteres_date = "AND DATE_FORMAT(h.DATE_INSERTION, '%Y-%m-%d')='" . $DATE1."'";
           }
           if(empty($DATE1) && !empty($DATE2)){
            $criteres_date = " AND DATE_FORMAT(h.DATE_INSERTION, '%Y-%m-%d')='" . $DATE2."'";
           }
          if (!empty($DATE1) && !empty($DATE2)) {
          $criteres_date = " AND DATE_FORMAT(h.DATE_INSERTION, '%Y-%m-%d') between  '". $DATE1."'  AND  '" .$DATE2."'";   
          }   
          if (!empty($STATUT)){
               if ($STATUT==2)
               {
                $STATUT=0;
               }
                $criteres_statut=" AND h.IS_PAID=".$STATUT;
                if ($STATUT==0)
               {
                $STATUT=2;
               }
              }
    
    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
    $query_principal = 'SELECT cp.POINTS,h.ID_COMPORTEMENT, h.RAISON_ANNULATION, ID_CONTROLE_MARCHANDISE,ID_HISTORIQUE,h.ID_CONTROLE,h.ID_HISTORIQUE_CATEGORIE, hc.DESCRIPTION as historique_categorie,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_IMMATRICULATIO_PEINE) AS IMMATRICULATION,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_ASSURANCE_PEINE) AS ASSURANCE,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_CONTROLE_TECHNIQUE_PEINE) AS CONTROL_TECHNIQUE,
    (SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_VOL_PEINE) AS VOL,(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_PERMIS_PEINE) AS PERMIS_PEINE, h.NUMERO_PLAQUE ,ID_IMMATRICULATIO_PEINE,ID_ASSURANCE_PEINE,ID_CONTROLE_TECHNIQUE_PEINE,ID_VOL_PEINE,ID_PERMIS_PEINE, h.NUMERO_PERMIS, concat(pe.NOM," ",pe.PRENOM) as user,pe.NUMERO_MATRICULE,pe.ID_PSR_ELEMENT, h.LATITUDE, h.LONGITUDE,h.DATE_INSERTION,h.MONTANT,h.IS_PAID,ID_CONTROLE_EQUIPEMENT,ID_SIGNALEMENT FROM historiques h LEFT JOIN historiques_categories hc ON h.ID_HISTORIQUE_CATEGORIE=hc.ID_CATEGORIE LEFT JOIN utilisateurs us ON us.ID_UTILISATEUR=h.ID_UTILISATEUR  LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT = us.PSR_ELEMENT_ID LEFT JOIN utilisateur_permis up ON up.NUMERO_PERMIS=h.NUMERO_PERMIS LEFT JOIN chauffeur_permis cp ON cp.NUMERO_PERMIS=up.NUMERO_PERMIS WHERE up.ID_PSR_INSTITUTION= '.$id.'  '.$criteres_date . ' '.$criteres_statut;
    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
    $limit = 'LIMIT 0,10';
    if ($_POST['length'] != -1) {
      $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }
    $order_by = '';
    $order_column = array('user', 'DATE_INSERTION', 'historique_categorie', 'RAISON_ANNULATION', 'NUMERO_PLAQUE', 'NUMERO_PERMIS','POINTS', 'MONTANT', 'IS_PAID', 'DATE_INSERTION');
    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_INSERTION DESC ';

    $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%' ") : '';



    $query_secondaire = $query_principal .  ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $search;

    $fetch_psr = $this->Modele->datatable($query_secondaire);
    $data = array();

    foreach ($fetch_psr as $row) {

      $controleMarch = '';
      $controleSignale = '';
      $controleSignalement = '';
      $controleEquipement = '';
      $controleEquipe = '';
      $controlePhysique = '';
      $controlePhy = '';
      $infraplaque = '';
      $infrassur = '';
      $infracontrp = '';
      $infravol = '';
      $infrapermis = '';
      $plaque = '';
      $permis = '';
      $AutresControles = '';
      $option = '';




      if ($row->ID_COMPORTEMENT != Null) {
        $comportementPermis = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $comportementPermis = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }


      $comportPermis = "<a hre='#' data-toggle='modal'
      data-target='#detailComport" . $row->ID_HISTORIQUE . "'>" . $comportementPermis . "</a>";


      $comportPermis .= "<div class='modal fade' id='detailComport" . $row->ID_HISTORIQUE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du Control permis</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_COMPORTEMENT != Null) {
        $comportPermis .= $this->getDetailComport($row->ID_COMPORTEMENT);
      }


      $comportPermis .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";






      if ($row->IMMATRICULATION != Null) {
        $infra = $row->IMMATRICULATION;
      } else {
        $infra = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
      }
      if ($row->ASSURANCE != Null) {
        $infrassur = $row->ASSURANCE;
      } else {
        $infrassur = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
      }
      if ($row->CONTROL_TECHNIQUE != Null) {
        $infracontrp = $row->CONTROL_TECHNIQUE;
      } else {
        $infracontrp = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
      }
      if ($row->VOL != Null) {
        $infravol = $row->VOL;
      } else {
        $infravol = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-times"></i></a>';
      }
      if ($row->PERMIS_PEINE != Null) {
        $infrapermis = $row->PERMIS_PEINE;
      } else {
        $infrapermis = !empty($row->NUMERO_PERMIS) ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }

      if ($row->NUMERO_PLAQUE != Null) {
        $plaques = $this->getPlaques($row->NUMERO_PLAQUE);

        if ($plaques != null) {
          $plaque = "<a title='".$row->NUMERO_PLAQUE."' onclick='show_vehicule_detail(this.title)' class='btn btn-md dt-button btn-sm' href='#'>" . $row->NUMERO_PLAQUE . "</a>";
        } else {
          $plaque = "<div class='btn btn-outline-danger''>" . $row->NUMERO_PLAQUE . "</div>";
        }
      } else {
        $plaque = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }
      if ($row->MONTANT != Null) {
        $montant = $row->MONTANT;
      } 
      else {
        $montant = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
      }
      if ($row->NUMERO_PERMIS != Null) {
        $idPermit = $this->getPermis($row->NUMERO_PERMIS);

        if ($idPermit != null) {
          $permis = "<a title='".$row->NUMERO_PERMIS."' onclick='show_permis(this.title)' class='btn btn-md dt-button btn-sm' href='#'>" . $row->NUMERO_PERMIS . "</a>";
        } else {
          $permis = "<span style='color :red'>" . $row->NUMERO_PERMIS . "</span>";
        }
      } else {
        $permis = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }

      if ($row->ID_CONTROLE != Null) {
        $controlePhy = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $controlePhysique = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }

      if ($row->ID_CONTROLE_EQUIPEMENT != Null) {
        $controleEquipe = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $controleEquipe = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }

      if ($row->ID_SIGNALEMENT != Null) {
        $controleSignale = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $controleSignalement = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }


      if ($row->ID_CONTROLE_MARCHANDISE != Null) {
        $controleMarch = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
      } else {
        $controleMarch = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
      }



      $detailMarch = "<a hre='#' data-toggle='modal'
      data-target='#detailMarchs" . $row->ID_HISTORIQUE . "'>" . $controleMarch . "</a>";


      $detailMarch .= "<div class='modal fade' id='detailMarchs" . $row->ID_HISTORIQUE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du Controle Machandise</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_CONTROLE_MARCHANDISE != Null) {
        $detailMarch .= $this->getDetailMarchandise($row->ID_CONTROLE_MARCHANDISE);
      }

      $detailMarch .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";



      $detailSign = '';

      $detailSign .= "<a hre='#' data-toggle='modal'
      data-target='#detail" . $row->ID_SIGNALEMENT . "'>" . $controleSignale . "</a>";
      $detailSign .= "
      <div class='modal fade' id='detail" . $row->ID_SIGNALEMENT . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du Controle Pysique</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_SIGNALEMENT != Null) {
        // $detailSign .= $this->getDetaisSign($row->ID_SIGNALEMENT);
      }

      $detailSign .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";

      $detail = '';

      $detail .= "<a hre='#' data-toggle='modal'
      data-target='#detail" . $row->ID_CONTROLE . "'>" . $controlePhy . "</a>";
      $detail .= "
      <div class='modal fade' id='detail" . $row->ID_CONTROLE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du controle Physique</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_CONTROLE != Null) {
        $detail .= $this->getDetais($row->ID_CONTROLE);
      }

      $detail .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";



      $detailEqui = '';

      $detailEqui .= "<a hre='#' data-toggle='modal'
      data-target='#detailEquips" . $row->ID_CONTROLE_EQUIPEMENT . "'>" . $controleEquipe . "</a>";
      $detailEqui .= "
      <div class='modal fade' id='detailEquips" . $row->ID_CONTROLE_EQUIPEMENT . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail du Controle Equipement</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      if ($row->ID_CONTROLE_EQUIPEMENT != Null) {
        $detailEqui .= $this->getDetailEQUI($row->ID_CONTROLE_EQUIPEMENT);
      }

      $detailEqui .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";



      $detailInfraimmatri = '';

      $detailInfraimmatri .= "<a hre='#' data-toggle='modal'
      data-target='#detailIMP" . $row->ID_IMMATRICULATIO_PEINE . "'><span style='color: red'>" . $infra . "</spa></a>";
      $detailInfraimmatri .= "
      <div class='modal fade' id='detailIMP" . $row->ID_IMMATRICULATIO_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";

      if ($row->ID_IMMATRICULATIO_PEINE != Null) {
        $detailInfraimmatri .= $this->getInfraImmatri($row->ID_IMMATRICULATIO_PEINE);
      }

      $detailInfraimmatri .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";

      $detailInfrassur = '';

      $detailInfrassur .= "<a hre='#' data-toggle='modal'
      data-target='#detailASSUR" . $row->ID_ASSURANCE_PEINE . "'><span style='color: red'>" . $infrassur . "</span></a>";
      $detailInfrassur .= "
      <div class='modal fade' id='detailASSUR" . $row->ID_ASSURANCE_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";


      $detailInfrassur .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";


      $detailInfrcontroltechnique = '';

      $detailInfrcontroltechnique .= "<a hre='#' data-toggle='modal'
      data-target='#detailCNTP" . $row->ID_CONTROLE_TECHNIQUE_PEINE . "'><span style='color: red'>" . $infracontrp . "</span></a>";
      $detailInfrcontroltechnique .= "
      <div class='modal fade' id='detailCNTP" . $row->ID_CONTROLE_TECHNIQUE_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";

      if ($row->ID_CONTROLE_TECHNIQUE_PEINE != Null) {
        $detailInfrcontroltechnique .= $this->getInfracontroleTechnique($row->ID_CONTROLE_TECHNIQUE_PEINE);
      }

      $detailInfrcontroltechnique .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";

      $detailInfravol = '';

      $detailInfravol .= "<a hre='#' data-toggle='modal'
      data-target='#detailVOL" . $row->ID_VOL_PEINE . "'><span style='color: red'>" . $infravol . "</span></a>";
      $detailInfravol .= "
      <div class='modal fade' id='detailVOL" . $row->ID_VOL_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";

      if ($row->ID_VOL_PEINE != Null) {
        $detailInfravol .= $this->getInfraVol($row->ID_VOL_PEINE);
      }

      $detailInfravol .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";


      $detailInfrapermis = '';

      $detailInfrapermis .= "<a hre='#' data-toggle='modal'
      data-target='#detailPMSP" . $row->ID_PERMIS_PEINE . "'><span style='color: red'>" . $infrapermis . "</span></a>";
      $detailInfrapermis .= "
      <div class='modal fade' id='detailPMSP" . $row->ID_PERMIS_PEINE . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>
      <div class='modal-header'>
      <h5 class='modal-title'>Detail de controle</h5>
      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>";

      if ($row->ID_PERMIS_PEINE != Null) {
        $detailInfrapermis .= $this->getInfraPermis($row->ID_PERMIS_PEINE);
      }

      $detailInfrapermis .= "
      </div>
      <div class='modal-footer'>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";


    

      $stat = '';

      if ($row->IS_PAID == 1) {
        $val_stat = '<button class="btn btn-info" style="white-space: nowrap">Payé</button>';
      } else {
        $val_stat = '<button class="btn btn-outline-info" style="white-space: nowrap">Non payé</button>';
      }

      $stat .= "<a href='#' data-toggle='modal'
      data-target='#stat" . $row->ID_HISTORIQUE . "'><font color='blue'>&nbsp;&nbsp;" . $val_stat . "</font></a>";

     

    

      $sub_array = array();
      $sub_array[] =  '<a class="nav-link" href="#"><table> <tbody><tr><td><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="https://app.mediabox.bi/wasiliEate/uploads/personne.png"></td><td>' . str_replace(" ", "<span style='color:#dee2e6'>_</span>", $row->user) . '<br>' . $row->NUMERO_MATRICULE . '</td></tr></tbody></table></a>';

      $sub_array[] = "<div class='text-center text-sm'>".(new DateTime($row->DATE_INSERTION, new DateTimeZone("Africa/Bujumbura")))->format('d-m-Y') . '<br>'.(new DateTime($row->DATE_INSERTION, new DateTimeZone("Africa/Bujumbura")))->format('H:i')."</div>";
      $sub_array[] = ucfirst(str_replace('Contrôle ', '', $row->historique_categorie));
      if($row->RAISON_ANNULATION == null) {
        $annule = "<span class='btn btn-outline-info disabled'>Non</span>";
      } else {
        $annule = "<span class='btn btn-danger'>Oui</span>";
      }
      $option = "<a class='btn  btn-sm btn-outline-secondary' onclick='getDetailControl(".$row->ID_HISTORIQUE.")'  href='#'>🧐voir plu...</a>";
      $sub_array[] = $annule;
      $sub_array[] = $plaque;
      $sub_array[] = $permis;
      $sub_array[] =$row->POINTS;
      $montant =  !empty($montant) ? number_format(floatval($montant), 0, ',', ' ') : 0;
      $sub_array[] = "<b style='float:right'>" . $montant . "</b>";
      $sub_array[] = $stat;
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

  function getDetailMarchandise($id_control = 0)
  {
    $dataDetail = 'SELECT au.ID_AUTRES_CONTROLES,q.ID_CONTROLES_QUESTIONNAIRES,q.INFRACTIONS,q.MONTANT,au.DESCRP_REPONSE,au.IMAGE_1,au.IMAGE_2,au.IMAGE_3, acqr.REPONSE_DECRP,q.NEED_IDENTITE FROM historiques h JOIN autres_controles au on au.ID_CONTROLE_PLAQUE =h.ID_CONTROLE_MARCHANDISE JOIN autres_controles_questionnaires q on q.ID_CONTROLES_QUESTIONNAIRES=au.ID_CONTROLES_QUESTIONNAIRES LEFT JOIN autres_contr_quest_rp acqr on acqr.ID_REPONSE=au.ID_REPONSE WHERE h.ID_CONTROLE_MARCHANDISE= ' . $id_control;





    $htmlDetail="";
    $image="";
    $total = 0;
    $htmlDetail .= "<div class='table-responsive'><b></b>
    <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
    <thead>
    <tr>
    <th>Application</th>
    <th>Montant(FBU)</th>
    <th>Img</th>
    <th>Identite</th>";
    $htmlDetail .="</thead>

    <tbody>";
        


    foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

      if(!empty($value['IMAGE_1'])){
        $image.=$value['IMAGE_1']."#";
      }
      if(!empty($value['IMAGE_2'])){
        $image.=$value['IMAGE_2']."#";
      }
      if(!empty($value['IMAGE_3'])){
        $image.=$value['IMAGE_3'];
      }



      if(!empty($image)){
        $imagedata ="<a href='#' title='". $image."' onclick='showviewImage(this.title)'><i class='fa fa-eye'></i></a>";
      }else{
        $imagedata="";
      }


       if($value['NEED_IDENTITE']==1){
        $optidentite = "<a class='btn  btn-sm btn-outline-secondary' onclick='getIdentite(".$value['ID_CONTROLES_QUESTIONNAIRES'].")'  href='#'>🧐concernés(".$this->getNombreConcerne($value['ID_CONTROLES_QUESTIONNAIRES']).")</a>";
       }else{
        $optidentite ="";
       }
    



      $total += $value['MONTANT'];
      $reponse=!empty($value['REPONSE_DECRP']) ? "(".$value['REPONSE_DECRP'].")" : "";
      $description=!empty($value['DESCRP_REPONSE']) ? "(".$value['DESCRP_REPONSE'].")" : "";

      $htmlDetail .= "<tr>
      <td>" . $value['INFRACTIONS']. $reponse. $description."</td>
      <td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . "</span></td>
      <td>".$imagedata."</td>

      <td>".$optidentite."</td>

      </tr>";
      //$descri=; 

    }
    $htmlDetail .= "<tr>
    <th >Total</th>
    <th colspan='3'><span style='float:right'>" . number_format($total, 0, '.', ' ') . "</th>
    </span>
    </tr>";

    $htmlDetail .= "</tbody></table>
    </div>";



    
    return $htmlDetail;
  }
  function getDetais($id_control = 0)
	{

		$dataDetail = 'SELECT au.ID_AUTRES_CONTROLES,q.NEED_IDENTITE,q.ID_CONTROLES_QUESTIONNAIRES, q.INFRACTIONS,q.MONTANT,au.DESCRP_REPONSE,au.IMAGE_1,au.IMAGE_2,au.IMAGE_3, acqr.REPONSE_DECRP FROM historiques h JOIN autres_controles au on au.ID_CONTROLE_PLAQUE =h.ID_CONTROLE JOIN autres_controles_questionnaires q on q.ID_CONTROLES_QUESTIONNAIRES=au.ID_CONTROLES_QUESTIONNAIRES LEFT JOIN autres_contr_quest_rp acqr on acqr.ID_REPONSE=au.ID_REPONSE  WHERE h.ID_CONTROLE='.$id_control.' ' ;


		$htmlDetail="";
		$image="";
		$total = 0;
		$htmlDetail .= "<div class='table-responsive'><b></b>
		<table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
		<thead>
		<tr>
		<th>Application</th>
		<th>Montant(FBU)</th>
		<th>Img</th>
		<th>Identité</th>";
		$htmlDetail .="</thead>

		<tbody>";
        


		foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

			if(!empty($value['IMAGE_1'])){
				$image.=$value['IMAGE_1']."#";
			}
			if(!empty($value['IMAGE_2'])){
				$image.=$value['IMAGE_2']."#";
			}
			if(!empty($value['IMAGE_3'])){
				$image.=$value['IMAGE_3'];
			}



			if(!empty($image)){
				$imagedata ="<a href='#' title='". $image."' onclick='showviewImage(this.title)'><i class='fa fa-eye'></i></a>";
			}else{
				$imagedata="";
			}


			 if($value['NEED_IDENTITE']==1){
			 	$optidentite = "<a class='btn  btn-sm btn-outline-secondary' onclick='getIdentite(".$value['ID_CONTROLES_QUESTIONNAIRES'].")'  href='#'>🧐concernés(".$this->getNombreConcerne($value['ID_CONTROLES_QUESTIONNAIRES']).")</a>";
			 }else{
			 	$optidentite ="";
			 }
		



			$total += $value['MONTANT'];
			$reponse=!empty($value['REPONSE_DECRP']) ? "(".$value['REPONSE_DECRP'].")" : "";
			$description=!empty($value['DESCRP_REPONSE']) ? "(".$value['DESCRP_REPONSE'].")" : "";

			$htmlDetail .= "<tr>
			<td>" . $value['INFRACTIONS']. $reponse. $description."</td>
			<td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . "</span></td>
			<td>".$imagedata."</td>

			<td>".$optidentite."</td>

			</tr>";
			//$descri=;	

		}
		$htmlDetail .= "<tr>
		<th >Total</th>
		<th colspan='3'><span style='float:right'>" . number_format($total, 0, '.', ' ') . "</th>
		</span>
		</tr>";

		$htmlDetail .= "</tbody></table>
		</div>";


		return $htmlDetail;



		return $htmlDetail;
	}

  function getDetailComport($id_control = 0)
  {

    $dataDetail = 'SELECT au.ID_AUTRES_CONTROLES,q.ID_CONTROLES_QUESTIONNAIRES,q.INFRACTIONS,q.MONTANT,au.DESCRP_REPONSE,au.IMAGE_1,au.IMAGE_2,au.IMAGE_3, acqr.REPONSE_DECRP,q.NEED_IDENTITE FROM historiques h JOIN autres_controles au on au.ID_CONTROLE_PLAQUE =h.ID_COMPORTEMENT JOIN autres_controles_questionnaires q on q.ID_CONTROLES_QUESTIONNAIRES=au.ID_CONTROLES_QUESTIONNAIRES LEFT JOIN autres_contr_quest_rp acqr on acqr.ID_REPONSE=au.ID_REPONSE  WHERE h.ID_COMPORTEMENT = ' . $id_control;

    $htmlDetail="";
    $image="";
    $total = 0;
    $htmlDetail .= "<div class='table-responsive'><b></b>
    <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
    <thead>
    <tr>
    <th>Application</th>
    <th>Montant(FBU)</th>
    <th>Img</th>
    <th>Identité</th>";
    $htmlDetail .="</thead>

    <tbody>";
        


    foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

      if(!empty($value['IMAGE_1'])){
        $image.=$value['IMAGE_1']."#";
      }
      if(!empty($value['IMAGE_2'])){
        $image.=$value['IMAGE_2']."#";
      }
      if(!empty($value['IMAGE_3'])){
        $image.=$value['IMAGE_3'];
      }



      if(!empty($image)){
        $imagedata ="<a href='#' title='". $image."' onclick='showviewImage(this.title)'><i class='fa fa-eye'></i></a>";
      }else{
        $imagedata="";
      }


       if($value['NEED_IDENTITE']==1){
        $optidentite = "<a class='btn  btn-sm btn-outline-secondary' onclick='getIdentite(".$value['ID_CONTROLES_QUESTIONNAIRES'].")'  href='#'>🧐concernés(".$this->getNombreConcerne($value['ID_CONTROLES_QUESTIONNAIRES']).")</a>";
       }else{
        $optidentite ="";
       }
    



      $total += $value['MONTANT'];
      $reponse=!empty($value['REPONSE_DECRP']) ? "(".$value['REPONSE_DECRP'].")" : "";
      $description=!empty($value['DESCRP_REPONSE']) ? "(".$value['DESCRP_REPONSE'].")" : "";

      $htmlDetail .= "<tr>
      <td>" . $value['INFRACTIONS']. $reponse. $description."</td>
      <td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . "</span></td>
      <td>".$imagedata."</td>

      <td>".$optidentite."</td>

      </tr>";
      //$descri=; 

    }
    $htmlDetail .= "<tr>
    <th >Total</th>
    <th colspan='3'><span style='float:right'>" . number_format($total, 0, '.', ' ') . "</th>
    </span>
    </tr>";

    $htmlDetail .= "</tbody></table>
    </div>";


    return $htmlDetail;
  }
   function getPlaques($plaque)
  {
    $plaque = $this->Modele->getRequeteOne("SELECT * FROM obr_immatriculations_voitures WHERE NUMERO_PLAQUE='" . $plaque . "'");
    if ($plaque != NULL) {
      return $plaque['ID_IMMATRICULATION'];
    } else {
      return 0;
    }
    //print_r($plaque);
  }
  function getPermis($permis)
  {
    $permis = $this->Modele->getRequeteOne("SELECT * FROM `chauffeur_permis` WHERE 1 AND NUMERO_PERMIS ='" . $permis . "'");
    if ($permis != NULL) {
      return $permis['ID_PERMIS'];
    } else {
      return 0;
    }
    //print_r($plaque);
  }
  function getIfraction($id){

    $dataDetail = 'SELECT `NIVEAU_ALERTE` FROM `infra_infractions` WHERE `ID_INFRA_INFRACTION`= ' . $id;
    $donne = $this->Modele->getRequeteOne($dataDetail);

       //print_r($id);exit();

    return $donne['NIVEAU_ALERTE'];

  }
  function getInfraPermis($id_immatri = 0)
  {
    $dataDetail = 'SELECT ID_INFRA_PEINE, ID_INFRA_INFRACTION, AMENDES, MONTANT, POINTS FROM infra_peines WHERE 1 AND ID_INFRA_INFRACTION= ' . $id_immatri;


    $htmlDetail = "<div class='table-responsive'>
    <b>".$this->getIfraction($id_immatri)."</b>
    <table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
    <thead>
    <tr>
    <th>Application</th>
    <th>Montant(FBU)</th>
    </tr>
    </thead>

    <tbody>";

    $total = 0;
    foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

      $total += $value['MONTANT'];
      $htmlDetail .= "<tr>
      <td>" . $value['AMENDES'] . "</td>
      <td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . "</span></td>
      </tr>";

    }

    $htmlDetail .= "<tr>
    <th>Total</th>
    <th><span style='float:right'>" . number_format($total, 0, '.', ' ') . "</th>
    </span></tr>";

    

    $htmlDetail .= "</tbody></table>
    </div>";


    return $htmlDetail;
  }
  function activer($id)
     {
        $this->Modele->update('psr_institution',array('ID_PSR_INSTITUTION'=>$id),array('IS_ACTIF'=>1));
        $this->Modele->update('utilisateurs',array('ID_INSTITUTION'=>$id),array('IS_ACTIF'=>1));
        print_r(json_encode(1));
     }
     function desactiver($id)
     {
           $this->Modele->update('psr_institution',array('ID_PSR_INSTITUTION'=>$id),array('IS_ACTIF'=>0));
           $this->Modele->update('utilisateurs',array('ID_INSTITUTION'=>$id),array('IS_ACTIF'=>0));
        print_r(json_encode(1));
     }






}
