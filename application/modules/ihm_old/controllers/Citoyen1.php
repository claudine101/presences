<?php

/**
 * Vanny
 * Gestion de publication de menu
 */
class Citoyen extends CI_Controller
{

	function __construct()
	{
		# code...
		parent::__construct();
	}
	function index()
	{
		$data['title'] = 'Espace Citoyen';
		$this->load->view('Citoyen_List_View', $data);
	}

	function listing()
	{
		$i = 1;
		$query_principal = 'SELECT ID_UTILISATEUR, NOM_UTILISATEUR, MOT_DE_PASSE, PROFIL_ID, PSR_ELEMENT_ID, NOM_CITOYEN, PRENOM_CITOYEN, NUMERO_CITOYEN, SEXE, CNI FROM utilisateurs WHERE 1 AND PROFIL_ID=7';


		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}
		$order_by = '';



		$order_column = array('ID_UTILISATEUR', 'NOM_UTILISATEUR', 'NOM_CITOYEN', 'PRENOM_CITOYEN', 'NUMERO_CITOYEN', 'CNI');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM_CITOYEN,PRENOM_CITOYEN ,CNI ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM_CITOYEN LIKE'%$var_search%' OR PRENOM_CITOYEN LIKE '%$var_search%' OR NOM_UTILISATEUR LIKE '%$var_search' OR CNI LIKE '%$var_search' ") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;


		$fetch_gerant = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_gerant as $row) {

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_UTILISATEUR . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Citoyen/getOne/' . $row->ID_UTILISATEUR) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_UTILISATEUR . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->NOM_CITOYEN . " " . $row->PRENOM_CITOYEN . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Citoyen/delete/' . $row->ID_UTILISATEUR) . "'>Supprimer</a>
			<buttoN class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = '<table> <tbody><tr><td><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="https://app.mediabox.bi/wasiliEate/uploads/personne.png"></td><td>' . $row->NOM_CITOYEN . ' ' . $row->PRENOM_CITOYEN. ' <font style="font-size:10px;color:red"><i class="far fa-comment-dots"></i></font></td></tr></tbody></table>';
			$sub_array[] = $row->NOM_UTILISATEUR;
			$sub_array[] = $row->NUMERO_CITOYEN;
			$sub_array[] = $row->CNI;
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

		$data['profil'] = $this->Modele->getRequete('SELECT PROFIL_ID,STATUT FROM `profil` WHERE 1');
		$data['title'] = ' Nouveau Citoyen';
		$this->load->view('Citoyen_Add_View', $data);
	}



	function add()
	{

		$this->form_validation->set_rules('NOM_CITOYEN', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PRENOM_CITOYEN', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NUMERO_CITOYEN', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('MOT_DE_PASSE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('PROFIL_ID', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('NOM_UTILISATEUR', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('CNI', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));





		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$pswd = $this->input->post('MOT_DE_PASSE');

			$data_insert = array(
				'NOM_UTILISATEUR' => $this->input->post('NOM_UTILISATEUR'),
				'MOT_DE_PASSE' => md5($pswd),
				'PROFIL_ID' => $this->input->post('PROFIL_ID'),
				//'PSR_ELEMENT_ID'=>$this->input->post(0),

				'NOM_CITOYEN' => $this->input->post('NOM_CITOYEN'),

				'PRENOM_CITOYEN' => $this->input->post('PRENOM_CITOYEN'),

				'NUMERO_CITOYEN' => $this->input->post('NUMERO_CITOYEN'),



				'CNI' => $this->input->post('CNI')
			);

			$table = 'utilisateurs';
			$this->Modele->create($table, $data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "enregistrement est faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Citoyen/'));
		}
	}

	function getOne()
	{

		$id = $this->uri->segment(4);
		$data['data'] = $this->Modele->getOne('utilisateurs', array('ID_UTILISATEUR' => $id));
		$data['profil'] = $this->Modele->getRequete('SELECT PROFIL_ID,STATUT FROM `profil` WHERE 1');

		$data['title'] = 'Modification du Citoyen';
		$this->load->view('Citoyen_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('NOM_CITOYEN', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PRENOM_CITOYEN', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NUMERO_CITOYEN', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('MOT_DE_PASSE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('PROFIL_ID', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('NOM_UTILISATEUR', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('CNI', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));




		$id = $this->input->post('ID_UTILISATEUR');



		if ($this->form_validation->run() == FALSE) {


			$this->getOne();
		} else {
			$id = $this->input->post('ID_UTILISATEUR');


			$data = array(
				'NOM_UTILISATEUR' => $this->input->post('NOM_UTILISATEUR'),
				'MOT_DE_PASSE' => $this->input->post('MOT_DE_PASSE'),
				'PROFIL_ID' => $this->input->post('PROFIL_ID'),
				'PSR_ELEMENT_ID' => 0,

				'NOM_CITOYEN' => $this->input->post('NOM_CITOYEN'),

				'PRENOM_CITOYEN' => $this->input->post('PRENOM_CITOYEN'),

				'NUMERO_CITOYEN' => $this->input->post('NUMERO_CITOYEN'),
				'CNI' => $this->input->post('CNI'),
			);



			$this->Modele->update('utilisateurs', array('ID_UTILISATEUR' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification de enregistrement est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Citoyen/'));
		}
	}

	function delete()
	{
		$table = "utilisateurs";
		$criteres['ID_UTILISATEUR'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">Le Citoyen  est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Citoyen'));
	}
}
