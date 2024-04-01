<?php

class Type_Verification extends CI_Controller
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
		$data['title'] = "Listes de source de vérification";
		$this->load->view('Type_Verification_List_V', $data);
	}

	function listing()
	{
		$query_principal = "SELECT `ID_TYPE_VERIFICATION`, `VERIFICATION` FROM `type_verification` WHERE 1";


		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);


		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {



			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}


		$order_by = '';

		$order_column = array('VERIFICATION');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY VERIFICATION ASC';

		$search = !empty($_POST['search']['value']) ? ("AND VERIFICATION LIKE '%$var_search%' ") : '';

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
			data-target='#mydelete" . $row->ID_TYPE_VERIFICATION . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Type_Verification/getOne/' . $row->ID_TYPE_VERIFICATION) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_TYPE_VERIFICATION . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->VERIFICATION . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Type_Verification/delete/' . $row->ID_TYPE_VERIFICATION) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			$sub_array[] = $row->VERIFICATION;
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
		$data['VERIFICATION'] = $this->Modele->getRequete('SELECT `ID_TYPE_VERIFICATION`, `VERIFICATION` FROM `type_verification` WHERE 1');

		$data['title'] = 'Nouvelle vérifiction';
		$this->load->view('ihm/Type_Verification_Add_V', $data);
	}

	function add()
	{
		$this->form_validation->set_rules('VERIFICATION', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$data_insert = array(

				'VERIFICATION' => $this->input->post('VERIFICATION'),
			);

			$table = 'type_verification';
			$this->Modele->create($table, $data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Type_Verification/index'));
		}
	}


	function getOne()
	{
		$id = $this->uri->segment(4);
		$data['data'] = $this->Modele->getOne('type_verification', array('ID_TYPE_VERIFICATION' => $id));

		$data['title'] = 'Modification d\'une source de vérifiction';
		//$data['king'] = $this->Modele->getRequete('SELECT `ID_TYPE_COULEUR`,`COULEUR` FROM `type_couleur` WHERE 1');
		$this->load->view('Type_Verification_Update_V', $data);
	}

	function update()
	{
		// $this->form_validation->set_rules('ID_TYPE_VERIFICATION','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('VERIFICATION', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		$id = $this->input->post('ID_TYPE_VERIFICATION');

		if ($this->form_validation->run() == FALSE) {


			$this->getOne();
		} else {
			$id = $this->input->post('ID_TYPE_VERIFICATION');

			$data = array(
				'VERIFICATION' => $this->input->post('VERIFICATION'),
			);

			$this->Modele->update('type_verification', array('ID_TYPE_VERIFICATION' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Type_Verification'));
		}
	}


	function delete()
	{
		$table = "type_verification";
		$criteres['ID_TYPE_VERIFICATION'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Type_Verification'));
	}
}
