<?php

/**
 *
 *	 
 **/
class Verif_Permis extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		if ($this->session->userdata('IHM') != 1) {

			redirect(base_url());
		}
	}


	function index()
	{
		$data['title'] = 'Registre des voitures et chauffeurs';
		$this->load->view('Verif_List_View', $data);
	}




	function listing()
	{

		$query_principal = 'SELECT ID_IMMATRICULATION_PERMIS,obr.ID_IMMATRICULATION,obr.NUMERO_PLAQUE,cp.ID_PERMIS,cp.NUMERO_PERMIS,cp.NOM_PROPRIETAIRE, imm.DATE_INSERTION FROM immatriculation_permis imm LEFT JOIN obr_immatriculations_voitures obr ON imm.ID_OBR=obr.ID_IMMATRICULATION LEFT JOIN chauffeur_permis cp ON imm.ID_PSR=cp.ID_PERMIS WHERE 1';



		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		 $var_search=str_replace("'", "\'", $var_search);

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';

		$order_column = array('NUMERO_PLAQUE', 'NUMERO_PERMIS', 'NOM_PROPRIETAIRE', 'DATE_INSERTION');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE ASC';

		$search = !empty($_POST['search']['value']) ? ("AND obr.NUMERO_PLAQUE LIKE '%$var_search%'  OR cp.NUMERO_PERMIS LIKE '%$var_search%'") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_PSR = $this->Modele->datatable($query_secondaire);
		$data = array();


		foreach ($fetch_PSR as $row) {


			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_IMMATRICULATION_PERMIS . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Verif_Permis/getOne/' . $row->ID_IMMATRICULATION_PERMIS . '/' . $row->ID_IMMATRICULATION . '/' . $row->ID_PERMIS) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";


			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" . $row->ID_IMMATRICULATION_PERMIS . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5 style='color:black'><strong>Voulez-vous supprimer la plaque ?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->NUMERO_PLAQUE . " du " . $row->DATE_INSERTION . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Verif_Permis/delete/' . $row->ID_IMMATRICULATION_PERMIS) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$sub_array = array();
			// $sub_array[] = $row->DATE_INSERTION;


			$sub_array[] = "<a  class='btn btn-md dt-button btn-sm' href='" . base_url('PSR/Obr_Immatriculation/show_vehicule/' . $row->ID_IMMATRICULATION . '/' . $row->NUMERO_PLAQUE) . "'>" . $row->NUMERO_PLAQUE . "</a>";
			$sub_array[] = "<a  class='btn btn-md dt-button btn-sm' href='" . base_url('ihm/Permis/index/' . $row->ID_PERMIS) . "'>" . $row->NUMERO_PERMIS . "</a>";
			$sub_array[] = $row->NOM_PROPRIETAIRE;
			$sub_array[] = $row->DATE_INSERTION;
			// $sub_array[] =  !empty($row->CIVIL_DESCRIPTION) ? "<span title='" . $row->CIVIL_DESCRIPTION . "'>commentaire ...</span>" : '-';






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
		$data['plaques'] = $this->Model->getRequete('SELECT ID_IMMATRICULATION, NUMERO_PLAQUE FROM obr_immatriculations_voitures WHERE 1 ORDER BY NUMERO_PLAQUE ASC');

		$data['permis'] = $this->Model->getRequete('SELECT ID_PERMIS , NUMERO_PERMIS FROM chauffeur_permis WHERE 1 ORDER BY NUMERO_PERMIS ASC');



		$data['title'] = 'Correspondance de Véhicule';
		$this->load->view('verif_Permis_Add_View', $data);
	}



	function add()
	{

		$getPermis = $this->Modele->getOne('chauffeur_permis', array('NUMERO_PERMIS' => trim($this->input->post('ID_PSR'))));
		$getPlaques = $this->Modele->getOne('obr_immatriculations_voitures', array('NUMERO_PLAQUE' => trim($this->input->post('ID_OBR'))));




		if (!empty($getPermis) && !empty($getPlaques)) {



			$data_insert = array(

				'ID_OBR' => $getPlaques['ID_IMMATRICULATION'],

				'ID_PSR' => $getPermis['ID_PERMIS'],

			);


			$table = ' immatriculation_permis';


			$this->Modele->create($table, $data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout est faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Verif_Permis/'));
		} else {

			$data['message'] = '<div class="alert alert-danger text-center" id="message">le déclarant n\'est pas reconnu comme chauffeur ou La Plaque n\'existe pas</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Verif_Permis/ajouter'));
		}
	}


	function getOne($idplaquepermis, $idPlaque, $idPermis)

	{
		$data['datas'] = $this->Modele->getOne('immatriculation_permis', array('ID_IMMATRICULATION_PERMIS' => $idplaquepermis));
		$data['plaques'] = $this->Modele->getOne('obr_immatriculations_voitures', array('ID_IMMATRICULATION' => $idPlaque));
		$data['permis'] = $this->Modele->getOne('chauffeur_permis', array('ID_PERMIS' => $idPermis));
		// print_r($data['data']);
		// exit();

		$data['title'] = "Modification d'une Attribution";
		$this->load->view('Verif_Modif_View', $data);
	}



	function update()
	{



		$this->form_validation->set_rules('ID_OBR', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('ID_PSR', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));



		$id = $this->input->post('ID_IMMATRICULATION_PERMIS');

		if ($this->form_validation->run() == FALSE) {
			//$id=$this->input->post('ID_GERANT');

			$this->getOne($id);
		} else {



			$data = array(
				'ID_IMMATRICULATION_PERMIS' => $this->input->post('ID_IMMATRICULATION_PERMIS'),
				'ID_OBR' => $this->input->post('ID_OBR'),
				'ID_PSR' => $this->input->post('ID_PSR'),




			);


			$this->Modele->update('immatriculation_permis', array('ID_IMMATRICULATION_PERMIS' => $id), $data);


			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification  est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Verif_Permis/'));
		}
	}


	function delete()
	{
		$table = "immatriculation_permis";
		$criteres['ID_IMMATRICULATION_PERMIS'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">La voiture est supprimée avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Verif_Permis/'));
	}
}
