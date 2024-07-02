<?php

/**
 *NDAYISABA Claudine
 *	CRUD DE TABLE Partie_politique
 **/
class  Partie_politique extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		if ($this->session->userdata('ID_PROFIL') != 2) {

			redirect(base_url());
		}
	}

	function index()
	{
		$data['title'] = 'Liste des partis politiques';
		$this->load->view('partie_politique/Partie_politique_List_View', $data);
	}

	function listing()
	{

		$i = 1;
		$query_principal = 'SELECT ID_PARTIE_POLITIQUE , DESCRPTION FROM partie_politiques WHERE 1';
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';

		$order_column = array('ID_PARTIE_POLITIQUE','DESCRPTION');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DESCRPTION DESC';

		$search = !empty($_POST['search']['value']) ? ("AND DESCRPTION LIKE '%$var_search%'") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . ' ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_infraction = $this->Modele->datatable($query_secondaire);
		$data = array();
		$u=0;
		foreach ($fetch_infraction as $row) {
			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_PARTIE_POLITIQUE  . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Partie_politique/getOne/' . $row->ID_PARTIE_POLITIQUE ) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_PARTIE_POLITIQUE  . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->DESCRPTION . " </i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Partie_politique/delete/' . $row->ID_PARTIE_POLITIQUE ) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";
			$sub_array = array();
			$u=++$u;
			$sub_array[]=$u;
			$sub_array[] = $row->DESCRPTION;
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
		$data['title'] = 'Nouveau parti politique';
		$this->load->view('partie_politique/Partie_politique_Add_View', $data);
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
		$this->form_validation->set_rules('DESCRPTION', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$data_insert = array(

				'DESCRPTION' => $this->input->post('DESCRPTION'),
			);
			$table = 'partie_politiques';
			$this->Modele->create($table, $data_insert);
			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Partie_politique/'));
		}
	}

	function getOne($id)
	{
		$data['data'] = $this->Modele->getOne('partie_politiques', array('ID_PARTIE_POLITIQUE ' => $id));
		$data['title'] = 'Modification du parti politique';
		$this->load->view('partie_politique/Partie_politique_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('DESCRPTION', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$id = $this->input->post('ID_PARTIE_POLITIQUE ');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {
			$id = $this->input->post('ID_PARTIE_POLITIQUE');

			$data = array(
				'DESCRPTION' => $this->input->post('DESCRPTION'),
			);
			$this->Modele->update('partie_politiques', array('ID_PARTIE_POLITIQUE ' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du parti politique est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Partie_politique/'));
		}
	}

	function delete()
	{
		$table = "partie_politiques";
		$criteres['ID_PARTIE_POLITIQUE '] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
		$data['message'] = '<div class="alert alert-success text-center" id="message">L\'element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Partie_politique/'));
	}
}
