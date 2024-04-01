<?php

/**
 *NTAHIMPERA Martin Luther King
 *	profil 
 **/
class  Profil extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		 if ($this->session->userdata('PARAMETRE') != 1) {

               redirect(base_url());
          }
	}

	function index()
	{
		$data['title'] = 'Liste des profils';
		$this->load->view('profil/profil_list', $data);
	}

	function listing()
	{

		$i = 1;
		$query_principal = 'SELECT PROFIL_ID, STATUT FROM profil WHERE 1';
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';

		$order_column = array('STATUT');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY STATUT DESC';

		$search = !empty($_POST['search']['value']) ? ("AND STATUT LIKE '%$var_search%'") : '';

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
			data-target='#mydelete" . $row->PROFIL_ID . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Profil/getOne/' . $row->PROFIL_ID) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->PROFIL_ID . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->STATUT . " </i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Profil/delete/' . $row->PROFIL_ID) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();

			$sub_array[] = $row->STATUT;
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

		$data['title'] = 'Nouvelle Profil';
		$this->load->view('PSR/profil/profil_add_v', $data);
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
	function add()
	{
		$this->form_validation->set_rules('STATUT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$data_insert = array(

				'STATUT' => $this->input->post('STATUT'),
			);
			$table = 'profil';
			$this->Modele->create($table, $data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/profil/'));
		}
	}

	function getOne($id)
	{
		$data['data'] = $this->Modele->getOne('profil', array('PROFIL_ID' => $id));

		$data['title'] = 'Modification du status';
		$this->load->view('PSR/profil/profil_update_v', $data);
	}

	function update()
	{

		$this->form_validation->set_rules('STATUT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$id = $this->input->post('PROFIL_ID');

		if ($this->form_validation->run() == FALSE) {


			$this->getOne($id);
		} else {
			$id = $this->input->post('PROFIL_ID');

			$data = array(
				'STATUT' => $this->input->post('STATUT'),
			);

			$this->Modele->update('profil', array('PROFIL_ID' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('PSR/profil/'));
		}
	}

	function delete()
	{
		$table = "profil";
		$criteres['PROFIL_ID'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/profil'));
	}
}
