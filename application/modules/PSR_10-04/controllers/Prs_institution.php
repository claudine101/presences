<?php

/**
 * Auteur HABIYAKARE Leonard
 * email prof:leonard@mediabox.bi
 * En date du 08/03/2023 a partir de 16h
 *	CRUD PSR INSTITUTION
 **/
class Prs_institution extends CI_Controller
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
		$data['title']=" Institutions";
		$this->load->view('Prs_institution_List_View',$data);
	}

	//fonction pour lister les donnees dans la table

	function listing()
	{

		$i=1;
		$query_principal='SELECT psr_institution.ID_PSR_INSTITUTION,concat(NOM_INSTITUTION," ",LOGO_INSTITUTION)as logo, psr_institution.NOM_INSTITUTION, psr_institution.PERSONNE_CONTACT, psr_institution.TELEPHONE_PERSONNE,psr_institution.EMAIL_PERSONNE,psr_institution.ADRESSE,psr_institution.LOGO_INSTITUTION,psr_institution.DATE_ENREGISTREMENT FROM psr_institution where 1 and  ID_PSR_INSTITUTION > 1 ';

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

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_PSR_INSTITUTION . "'>
			<label class='text-secondary'>&nbsp;&nbsp;Supprimer</label></a></li>


			";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Prs_institution/getOne/'.$row->ID_PSR_INSTITUTION)."'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";

			$option .= "<li><a class='btn-md' href='#' onclick='chauffeur(".$row->ID_PSR_INSTITUTION.")'><label class='text-success'>&nbsp;&nbsp;Chauffeur</label></a></li>";

			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_PSR_INSTITUTION . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" .$row->NOM_INSTITUTION."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Prs_institution/delete/'.$row->ID_PSR_INSTITUTION) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			// $sub_array[] = '<table> <tbody><tr><td><a href="' . $row->LOGO_INSTITUTION. '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $row->LOGO_INSTITUTION . '"></a></td><td>' . $row->NOM_INSTITUTION . ' </td></tr></tbody></table></a>';
			// $sub_array[]=$row->PERSONNE_CONTACT;
			// $sub_array[]=$row->TELEPHONE_PERSONNE; 
			// $sub_array[]=$row->EMAIL_PERSONNE;
			// $sub_array[]=$row->ADRESSE;	
			// $sub_array[]=$row->DATE_ENREGISTREMENT;		
			// $sub_array[]=$option;   
			// $data[] = $sub_array;


			$source = !empty($row->LOGO_INSTITUTION) ? $row->LOGO_INSTITUTION : base_url()."/uploads/personne.png";

			//$source = base_url()."/uploads/personne.png";

			$sub_array[] = '<table> <tbody><tr><td><a href="' . $source. '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM_INSTITUTION . ' </td></tr></tbody></table></a>';
			$sub_array[]=$row->PERSONNE_CONTACT;
			$sub_array[]=$row->TELEPHONE_PERSONNE; 
			$sub_array[]=$row->EMAIL_PERSONNE;
			$sub_array[]=$row->ADRESSE;	
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

		$this->load->view('Prs_institution_Add_View',$data);

	}
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

			redirect(base_url('PSR/Prs_institution'));

		}

	}

	public function getOne($id_psr)
	{
		$prs=$this->Model->getRequeteOne('SELECT `ID_PSR_INSTITUTION`, `NOM_INSTITUTION`, `PERSONNE_CONTACT`, `TELEPHONE_PERSONNE`, `EMAIL_PERSONNE`, `ADRESSE`, `LOGO_INSTITUTION`, `DATE_ENREGISTREMENT` FROM `psr_institution` WHERE ID_PSR_INSTITUTION='.$id_psr);
		$data['prs']=$prs;
		$data['title'] = "Modification d'une institution PSR";

		$this->load->view('Prs_institution_Edit_View', $data);
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
			redirect(base_url('PSR/Prs_institution'));

		}

	}

//function supprimer
	public function delete($ID){
		$this->Model->delete('psr_institution',array('ID_PSR_INSTITUTION'=>$ID));
		$data['message'] = '<div class="alert alert-success text-center" id="message">' . " L'institution PSR a été Supprimé  avec succès" . '</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Prs_institution')); 
	}

	//fonction pour lister les donnees dans la table 

	function detail($id)
	{
		$query_principal= 'SELECT chauffeur_permis.ID_PERMIS,chauffeur_permis.NUMERO_PERMIS,chauffeur_permis.NOM_PROPRIETAIRE,chauffeur_permis.SEXE,chauffeur_permis.POINTS,immatriculation_permis.NUMERO_PLAQUE,immatriculation_permis.TELEPHONE   FROM chauffeur_permis  JOIN obr_immatriculations_voitures ON obr_immatriculations_voitures.ID_IMMATRICULATION = chauffeur_permis.ID_PERMIS JOIN  immatriculation_permis ON immatriculation_permis.ID_IMMATRICULATION_PERMIS=chauffeur_permis.ID_PERMIS WHERE obr_immatriculations_voitures.ID_PSR_INSTITUTION='.$id ;

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$critaire='';

		$search = !empty($_POST['search']['value']) ? (" AND (chauffeur_permis.NUMERO_PERMIS LIKE '%$var_search%'or chauffeur_permis.NOM_PROPRIETAIRE LIKE '%$var_search%'or chauffeur_permis.POINTS LIKE '%$var_search%'or chauffeur_permis.SEXE LIKE'%$var_search%'or immatriculation_permis.NUMERO_PLAQUE LIKE '%$var_search%'or immatriculation_permis.TELEPHONE LIKE '%$var_search%' ) ") :'';
		$query_secondaire=$query_principal.'  '.$critaire.' '.$search;
		$query_filter=$query_principal.'  '.$critaire;
		$fetch_cov_frais = $this->Model->datatable($query_secondaire);
		$data = array();
		$u=1;

		foreach($fetch_cov_frais as $info)
		{
			$post=array(); 
			$source = base_url()."/uploads/personne.png";
			$post[] = '<table> <tbody><tr><td><a href="'.$source.'" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="'.$source.'"></a></td><td>'.$info->NOM_PROPRIETAIRE.' </td></tr></tbody></table></a>';
			$post[]=$info->NUMERO_PERMIS;
			$post[]=$info->NUMERO_PLAQUE;
			$post[]=$info->TELEPHONE;
			$post[]=$info->SEXE;
			$post[]=$info->POINTS;
			$data[]=$post;  
		}
		$output = array(
			"draw" => intval($_POST['draw']),
			"recordsTotal" =>$this->Model->all_data($query_principal),
			"recordsFiltered" => $this->Model->filtrer($query_filter),
			"data" => $data
		);
		echo json_encode($output);
	}

	//fonction pour recuperer les donnees 
	function getone1($id_psr){
		$pesseur=$this->Model->getRequeteOne('SELECT `ID_PSR_INSTITUTION`, `NOM_INSTITUTION`, `PERSONNE_CONTACT`, `TELEPHONE_PERSONNE`, `EMAIL_PERSONNE`, `ADRESSE`, `LOGO_INSTITUTION`, `DATE_ENREGISTREMENT` FROM `psr_institution` WHERE ID_PSR_INSTITUTION='.$id_psr);

		echo json_encode($pesseur);
	}


}
