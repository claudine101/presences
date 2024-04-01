<?php
class Question_Categorie extends CI_Controller
{
     function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		if ($this->session->userdata('PSR_ELEMENT') != 1) {

			redirect(base_url());
		}
	}
	function index()
	{
		$data['title'] = "Listes des catégories de questions";
		$this->load->view('Question_Categorie_List_V', $data);
	}

	function listing()
	{

		$query_principal = "SELECT `ID_QUESTIONNAIRE_CATEGORIES`, `CATEGORIES` FROM `quetionnaire_categories` WHERE 1";


		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);

		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {



			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';

		$order_column = array('CATEGORIES');


		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY CATEGORIES ASC';

		$search = !empty($_POST['search']['value']) ? ("AND CATEGORIES LIKE '%$var_search%' ") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_peine = $this->Modele->datatable($query_secondaire);
		$data = array();


		foreach ($fetch_peine as $row) {
			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_QUESTIONNAIRE_CATEGORIES . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Question_Categorie/getOne/' . $row->ID_QUESTIONNAIRE_CATEGORIES) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_QUESTIONNAIRE_CATEGORIES . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong style='color:black'>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->CATEGORIES . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Question_Categorie/delete/' . $row->ID_QUESTIONNAIRE_CATEGORIES) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			//$sub_array[]=$row->ID_QUESTIONNAIRE_CATEGORIES;
			$sub_array[] = $row->CATEGORIES;
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
		$data['CATEGORIES'] = $this->Modele->getRequete('SELECT `ID_QUESTIONNAIRE_CATEGORIES`, `CATEGORIES` FROM `quetionnaire_categories` WHERE 1');

		$data['title'] = "Nouvelle catégorie";
		$this->load->view('ihm/Question_Categorie_Add_V', $data);
	}

	function add()
	{

		$this->form_validation->set_rules('CATEGORIES', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$data_insert = array(

				'CATEGORIES' => $this->input->post('CATEGORIES'),
				'QUESTIONNAIRE_TRADUCTION' => $this->input->post('QUESTIONNAIRE_TRADUCTION'),
			);

			$table = 'quetionnaire_categories';
			$this->Modele->create($table, $data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Question_Categorie/index'));
		}
	}

	function getOne()
	{

		$id = $this->uri->segment(4);
		$data['data'] = $this->Modele->getOne('quetionnaire_categories', array('ID_QUESTIONNAIRE_CATEGORIES' => $id));

		$data['title'] = 'Modification d\'une catégorie';
		$this->load->view('Question_Categorie_Update_V', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('ID_QUESTIONNAIRE_CATEGORIES', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('CATEGORIES', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		$id = $this->input->post('ID_QUESTIONNAIRE_CATEGORIES');

		if ($this->form_validation->run() == FALSE) {


			$this->getOne();
		} else {
			$id = $this->input->post('ID_QUESTIONNAIRE_CATEGORIES');

			$data = array(
				'CATEGORIES' => $this->input->post('CATEGORIES'),
				'QUESTIONNAIRE_TRADUCTION' => $this->input->post('QUESTIONNAIRE_TRADUCTION'),
			);

			$this->Modele->update('quetionnaire_categories', array('ID_QUESTIONNAIRE_CATEGORIES' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Question_Categorie'));
		}
	}

	function saveForma()
	{
		$FR = $this->input->post('FR');
		$ENG = $this->input->post('ENG');
		$KIR = $this->input->post('KIR');
		$KISW = $this->input->post('KISW');

		$data  = array(
			'FR' => $FR,
			'ENG' => $ENG,
			'KIR' => $KIR,
			'KISW' => $KISW,
		);

		echo json_encode($data);
	}


	function delete()
	{
		$table = "quetionnaire_categories";
		$criteres['ID_QUESTIONNAIRE_CATEGORIES'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Question_Categorie'));
	}
}
