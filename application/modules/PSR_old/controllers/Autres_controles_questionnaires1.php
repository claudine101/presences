<?php

/**
 *
 *	autres_controles_questionnaires (PSR) 
 **/

class Autres_controles_questionnaires extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$quetionnaire_categorie = $this->Modele->getRequete('SELECT ID_QUESTIONNAIRE_CATEGORIES, CATEGORIES FROM quetionnaire_categories WHERE 1 ORDER BY CATEGORIES');
		$data['quetionnaire_categorie'] = $quetionnaire_categorie;
		$data['title'] = 'AUTRES QUESTIONS DE CONTROLE';
		$this->load->view('autres_controles_questionnaire_List_view', $data);
	}

	function listing()
	{
		$verifications = $this->input->post('ID_QUESTIONNAIRE_CATEGORIES');

		$critere_command = !empty($verifications) ? " and quetionnaire_categories.ID_QUESTIONNAIRE_CATEGORIES = " . $verifications . " " : "";


		$query_principal = "SELECT ID_CONTROLES_QUESTIONNAIRES,quetionnaire_categories.ID_QUESTIONNAIRE_CATEGORIES,INFRACTIONS,DESCRIPTION,MONTANT,POURCENTAGE,quetionnaire_categories.CATEGORIES,MANIERE_REPONSE,LABEL_REPONSE,DESCR_LABEL,NEED_IDENTITE,NEED_IMAGE,ICON FROM autres_controles_questionnaires JOIN quetionnaire_categories ON quetionnaire_categories.ID_QUESTIONNAIRE_CATEGORIES=autres_controles_questionnaires.ID_QUESTIONNAIRE_CATEGORIES WHERE 1 " . $critere_command . " ";

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';

		$order_column = array('ID_CONTROLES_QUESTIONNAIRES', 'INFRACTIONS', 'DESCRIPTION', 'MONTANT', 'POURCENTAGE', 'CATEGORIES');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY INFRACTIONS,MONTANT,POURCENTAGE  ASC';

		$search = !empty($_POST['search']['value']) ? ("AND INFRACTIONS LIKE '%$var_search%' OR MONTANT LIKE '%$var_search%' OR CATEGORIES LIKE '%$var_search%'") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . ' ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_infraction = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_infraction as $row) {

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_CONTROLES_QUESTIONNAIRES . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Autres_controles_questionnaires/getOne/' . $row->ID_CONTROLES_QUESTIONNAIRES) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_CONTROLES_QUESTIONNAIRES . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->INFRACTIONS . " " . $row->MONTANT . " " . $row->CATEGORIES . " " . $row->POURCENTAGE . " </i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Autres_controles_questionnaires/delete/' . $row->ID_CONTROLES_QUESTIONNAIRES) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$manner = '';
			if ($row->MANIERE_REPONSE == 2) {
				$manner = "select";
			} else if ($row->MANIERE_REPONSE == 1) {
				$manner = "input";
			}

			$source = !empty($row->ICON) ? $row->ICON : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			$detail = '';
			if ($row->ID_CONTROLES_QUESTIONNAIRES) {
				$detail = "<a  class='btn btn-md dt-button btn-sm' href='" . base_url('ihm/DetailLabel/index/' . $row->ID_CONTROLES_QUESTIONNAIRES) . "'>" . $row->LABEL_REPONSE . "</a>";
			}

			$sub_array = array();
			$sub_array[] = '<img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '">';
			$sub_array[] = $row->INFRACTIONS;
			$sub_array[] = $row->DESCRIPTION != null ? $row->DESCRIPTION : "N/A";
			$sub_array[] = "<span style='float:right'>" . number_format($row->MONTANT, 0, '.', ' ') . " FBU</span>";
			$sub_array[] = $row->CATEGORIES;
			$sub_array[] = $manner != null ? $manner : "Pas besoin";
			$sub_array[] = $row->LABEL_REPONSE != Null ? $detail : "<a  class='btn btn-md dt-button btn-sm' href='" . base_url('ihm/DetailLabel/index/' . $row->ID_CONTROLES_QUESTIONNAIRES) . "'>Nouveau</a>";
			$sub_array[] = $row->DESCR_LABEL != Null ? $row->DESCR_LABEL : "N/A";
			$sub_array[] = $row->NEED_IDENTITE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->NEED_IMAGE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';

			$sub_array[] = $row->POURCENTAGE;
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

		$data['categorie_g'] = $this->Modele->getRequete('SELECT ID_QUESTIONNAIRE_CATEGORIES, CATEGORIES FROM quetionnaire_categories WHERE 1');
		$data['title'] = 'NOUVEAU CATEGORIE';

		$this->load->view('autres_controles_questionnaire_add_view', $data);
		//var_dump($data);die();
	}

	function add()

	{

		$this->form_validation->set_rules('ID_QUESTIONNAIRE_CATEGORIES', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('INFRACTION', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('MONTANT', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('POURCENTAGE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		// $this->form_validation->set_rules('MANIERE_REPONSE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		// $this->form_validation->set_rules('LABEL_REPONSE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		// $this->form_validation->set_rules('DESCR_LABEL', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));



		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			if (!empty($_FILES['PHOTO'])) {
				$file = $_FILES['PHOTO'];
				$path = './uploads/dossiers_photo/';
				if (!is_dir(FCPATH . '/uploads/dossiers_photo/')) {
					mkdir(FCPATH . '/uploads/dossiers_photo/', 0777, TRUE);
				}
				$thepath = base_url() . 'uploads/dossiers_photo/';
				$config['upload_path'] = './uploads/dossiers_photo/';
				$photonames = date('ymdHisa');
				$config['file_name'] = $photonames;
				$config['allowed_types'] = '*';
				$this->upload->initialize($config);
				$this->upload->do_upload("PHOTO");
				$info = $this->upload->data();

				if ($file == '') {
					$photo = base_url() . 'uploads/sevtb.png';
				} else {
					$photo = base_url() . '/uploads/dossiers_photo/' . $photonames . $info['file_ext'];
				}
			} else {
				$photo = '';
			}


			if ($this->input->post('NEED_IDENTITE') != null) {
				$needIdentite = 1;
			} else {
				$needIdentite = 0;
			}

			if ($this->input->post('NEED_IMAGE') != null) {
				$needImage = 1;
			} else {
				$needImage = 0;
			}

			$label = $this->input->post('LABEL_REPONSE');

			$data_insert = array(

				'ID_QUESTIONNAIRE_CATEGORIES' => $this->input->post('ID_QUESTIONNAIRE_CATEGORIES'),

				'INFRACTIONS' => $this->input->post('INFRACTION'),

				'DESCRIPTION' => $this->input->post('DESCRIPTION'),

				'MONTANT' => $this->input->post('MONTANT'),

				'POURCENTAGE' => $this->input->post('POURCENTAGE'),

				'MANIERE_REPONSE' => $this->input->post('MANIERE_REPONSE'),

				'LABEL_REPONSE' => $this->input->post('LABEL_REPONSE'),

				'DESCR_LABEL' => $this->input->post('DESCR_LABEL'),

				'NEED_IDENTITE' => $needIdentite,

				'NEED_IMAGE' => $needImage,

				'ICON' => $photo

			);

			$table = 'autres_controles_questionnaires';
			//$this->Modele->create($table, $data_insert);

			// $data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			// $this->session->set_flashdata($data);
			// redirect(base_url('PSR/Autres_controles_questionnaires'));
			$idSign = $this->Modele->insert_last_id($table, $data_insert);
			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			if ($label == null) {
				redirect(base_url('PSR/Autres_controles_questionnaires/'));
			} else {
				redirect(base_url('ihm/DetailLabel/index/' . $idSign));
			}
		}
	}

	function getOne($id = 0)
	{
		// $id=$this->uri->segment(4);
		$data['questions'] = $this->Modele->getRequeteOne('SELECT ID_CONTROLES_QUESTIONNAIRES, INFRACTIONS,DESCRIPTION, MONTANT, ID_QUESTIONNAIRE_CATEGORIES, POURCENTAGE,MANIERE_REPONSE,LABEL_REPONSE,DESCR_LABEL,NEED_IDENTITE,NEED_IMAGE,ICON FROM autres_controles_questionnaires WHERE ID_CONTROLES_QUESTIONNAIRES=' . $id);
		$data['categorie_g'] = $this->Modele->getRequete('SELECT ID_QUESTIONNAIRE_CATEGORIES, CATEGORIES FROM quetionnaire_categories WHERE 1');
		$checiDENTITE = '';
		$checimage = '';
		if ($data['questions']['NEED_IDENTITE'] == 1) {
			$checiDENTITE = 'checked';
		} else if ($data['questions']['NEED_IDENTITE'] != null) {
			$checiDENTITE = '';
		}

		if ($data['questions']['NEED_IMAGE'] == 1) {
			$checimage = 'checked';
		} else if ($data['questions']['NEED_IMAGE'] != null) {
			$checimage = '';
		}


		$data['chec1'] = $checiDENTITE;
		$data['chec2'] = $checimage;

		$data['title'] = 'MODIFICATION DES INFRACTIONS';
		$this->load->view('autres_controles_questionnaire_update_view', $data);
	}

	function update()
	{

		$this->form_validation->set_rules('ID_QUESTIONNAIRE_CATEGORIES', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('INFRACTIONS', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('MONTANT', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('POURCENTAGE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		// $this->form_validation->set_rules('MANIERE_REPONSE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		// $this->form_validation->set_rules('LABEL_REPONSE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		// $this->form_validation->set_rules('DESCR_LABEL', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));



		$id = $this->input->post('ID_CONTROLES_QUESTIONNAIRES');

		if ($this->form_validation->run() == FALSE) {

			$this->getOne();
		} else {

			//  print_r($_FILES['PHOTO']);die();

			$id = $this->input->post('ID_CONTROLES_QUESTIONNAIRES');
			if ($this->input->post('NEED_IDENTITE') != null) {
				$needIdentite = 1;
			} else {
				$needIdentite = 0;
			}

			if ($this->input->post('NEED_IMAGE') != null) {
				$needImage = 1;
			} else {
				$needImage = 0;
			}

			if (!empty($_FILES['PHOTO'])) {

				//print_r($_FILES['PHOTO']);
				// $photo=$this->upload_file1($this->input->post('PHOTO'));
				$file = $_FILES['PHOTO'];
				$path = './uploads/dossiers_photo/';
				if (!is_dir(FCPATH . '/uploads/dossiers_photo/')) {
					mkdir(FCPATH . '/uploads/dossiers_photo/', 0777, TRUE);
				}
				$thepath = base_url() . 'uploads/dossiers_photo/';
				$config['upload_path'] = './uploads/dossiers_photo/';
				$photonames = date('ymdHisa');
				$config['file_name'] = $photonames;
				$config['allowed_types'] = '*';
				$this->upload->initialize($config);
				$this->upload->do_upload("PHOTO");
				$info = $this->upload->data();

				if ($file == '') {
					$photo = base_url() . 'uploads/sevtb.png';
				} else {
					$photo = base_url() . '/uploads/dossiers_photo/' . $photonames . $info['file_ext'];
				}
			} else {
				$photo = '';
			}



			$data_update = array(

				'ID_QUESTIONNAIRE_CATEGORIES' => $this->input->post('ID_QUESTIONNAIRE_CATEGORIES'),

				'INFRACTIONS' => $this->input->post('INFRACTIONS'),

				'DESCRIPTION' => $this->input->post('DESCRIPTION'),

				'MONTANT' => $this->input->post('MONTANT'),

				'POURCENTAGE' => $this->input->post('POURCENTAGE'),

				'MANIERE_REPONSE' => $this->input->post('MANIERE_REPONSE'),

				'LABEL_REPONSE' => $this->input->post('LABEL_REPONSE'),

				'DESCR_LABEL' => $this->input->post('DESCR_LABEL'),

				'NEED_IDENTITE' => $needIdentite,

				'NEED_IMAGE' => $needImage,

				'ICON' => $photo

			);
			$this->Modele->update('autres_controles_questionnaires', array('ID_CONTROLES_QUESTIONNAIRES' => $id), $data_update);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification infraction et du montant se fait avec succes</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('PSR/Autres_controles_questionnaires/'));
		}
	}

	function delete()
	{
		$table = "autres_controles_questionnaires";
		$criteres['ID_CONTROLES_QUESTIONNAIRES'] = $this->uri->segment(4);
		$data['data'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">Infraction est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Autres_controles_questionnaires'));
	}
}
