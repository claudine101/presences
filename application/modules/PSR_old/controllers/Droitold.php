<?php

/**
 *NTAHIMPERA Martin Luther King
 *	Element de la police 
 **/
class Droit extends CI_Controller
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
		$data['title'] = 'Matrice';
		$this->load->view('droit/droit_list', $data);
	}

	function listing()
	{
		$i = 1;
		$query_principal = 'SELECT ID_DROIT, INFRACTION, PSR_ELEMENT, PEINES, AFFECTATION, PERMIS, DECLARATION, IMMATRICULATION, CONTROLE_TECHNIQUE, ASSURANCE,QUESTIONNAIRE, pr.STATUT AS STATUS FROM droits dr LEFT JOIN profil pr ON pr.PROFIL_ID=dr.PROFIL_ID WHERE 1';

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';
		$order_column = array('STATUS', 'INFRACTION', 'PSR_ELEMENT', 'PEINES', 'AFFECTATION', 'PERMIS', 'DECLARATION', 'IMMATRICULATION', 'CONTROLE_TECHNIQUE', 'ASSURANCE', 'QUESTIONNAIRE', 'STATUT');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY PEINES,PERMIS ASC';

		$search = !empty($_POST['search']['value']) ? ("AND STATUT LIKE '%$var_search%' ") : '';

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
			data-target='#mydelete" . $row->ID_DROIT . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Droit/getOne/' . $row->ID_DROIT) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_DROIT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->ID_DROIT . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Droit/delete/' . $row->ID_DROIT) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			//$sub_array[] = $i++;
			$sub_array[] = $row->INFRACTION == 1 ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->PSR_ELEMENT ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->PEINES ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->AFFECTATION ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->PERMIS ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->DECLARATION ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->IMMATRICULATION ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->CONTROLE_TECHNIQUE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->ASSURANCE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->QUESTIONNAIRE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->STATUS;
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
		$data['profils'] = $this->Model->getRequete('SELECT PROFIL_ID, STATUT FROM profil WHERE 1 ORDER BY STATUT ASC');
		$data['title'] = 'Nouveau Element';
		$this->load->view('droit/droit_add_v', $data);
	}




	function add()
	{

		$this->form_validation->set_rules('PROFIL_ID', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {
			if ($this->input->post('INFRACTION') != null) {
				$infraction = 1;
			} else {
				$infraction = 0;
			}
			if ($this->input->post('PSR_ELEMENT') != null) {
				$psr = 1;
			} else {
				$psr = 0;
			}
			if ($this->input->post('PEINES') != null) {
				$peines = 1;
			} else {
				$peines = 0;
			}
			if ($this->input->post('AFFECTATION') != null) {
				$affectation = 1;
			} else {
				$affectation = 0;
			}
			if ($this->input->post('PERMIS') != null) {
				$permis = 1;
			} else {
				$permis = 0;
			}
			if ($this->input->post('DECLARATION') != null) {
				$declaration = 1;
			} else {
				$declaration = 0;
			}
			if ($this->input->post('IMMATRICULATION') != null) {
				$immatriculation = 1;
			} else {
				$immatriculation = 0;
			}
			if ($this->input->post('CONTROLE_TECHNIQUE') != null) {
				$controle = 1;
			} else {
				$controle = 0;
			}
			if ($this->input->post('ASSURANCE') != null) {
				$assurance = 1;
			} else {
				$assurance = 0;
			}
			if ($this->input->post('QUESTIONNAIRE') != null) {
				$questionnaire = 1;
			} else {
				$questionnaire = 0;
			}


			$data_insert = array(
				'PROFIL_ID' => $this->input->post('PROFIL_ID'),
				'INFRACTION' => $infraction,
				'PSR_ELEMENT' => $psr,
				'PEINES' => $peines,
				'AFFECTATION' => $affectation,
				'PERMIS' => $permis,
				'DECLARATION' => $declaration,
				'IMMATRICULATION' => $immatriculation,
				'CONTROLE_TECHNIQUE' => $controle,
				'ASSURANCE' => $assurance,
				'QUESTIONNAIRE' => $questionnaire,
			);
			$table = 'droits';
			$this->Modele->create($table, $data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Droit/'));
		}
	}

	function getOne()
	{
		$id = $this->uri->segment(4);
		$data['data'] = $this->Modele->getOne('droits', array('ID_DROIT' => $id));
		$data['profils'] = $this->Model->getRequete('SELECT PROFIL_ID, STATUT FROM profil WHERE 1 ORDER BY STATUT ASC');


		// print_r($data['data']); die();
		$checinfra = '';
		$checkPsr = '';
		$checkpeine = '';
		$checkaffect = '';
		$checkPermis = '';
		$checkDecla = '';
		$checkimma = '';
		$checkcont = '';
		$checkAss = '';
		$checkQues = '';

		if ($data['data']['INFRACTION'] == 1) {
			$checinfra = 'checked';
		}
		if ($data['data']['PSR_ELEMENT'] == 1) {
			$checkPsr = 'checked';
		}
		if ($data['data']['PEINES'] == 1) {
			$checkpeine = 'checked';
		}
		if ($data['data']['AFFECTATION'] == 1) {
			$checkaffect = 'checked';
		}
		if ($data['data']['PERMIS'] == 1) {
			$checkPermis = 'checked';
		}
		if ($data['data']['DECLARATION'] == 1) {
			$checkDecla = 'checked';
		}
		if ($data['data']['IMMATRICULATION'] == 1) {
			$checkimma = 'checked';
		}
		if ($data['data']['CONTROLE_TECHNIQUE'] == 1) {
			$checkcont = 'checked';
		}
		if ($data['data']['ASSURANCE'] == 1) {
			$checkAss = 'checked';
		}
		if ($data['data']['QUESTIONNAIRE'] == 1) {
			$checkQues = 'checked';
		}

		$data['chec1'] = $checinfra;
		$data['chec2'] = $checkPsr;
		$data['chec3'] = $checkpeine;
		$data['chec4'] = $checkaffect;
		$data['chec5'] = $checkPermis;
		$data['chec6'] = $checkDecla;
		$data['chec7'] = $checkimma;
		$data['chec8'] = $checkcont;
		$data['chec9'] = $checkAss;
		$data['chec10'] = $checkQues;
		$data['title'] = "Modification d'un Police";
		$this->load->view('droit/droit_update_v', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('PROFIL_ID', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		$id = $this->input->post('ID_DROIT');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne();
		} else {
			$id = $this->input->post('ID_DROIT');

			if ($this->input->post('INFRACTION') != null) {
				$infraction = 1;
			} else {
				$infraction = 0;
			}
			if ($this->input->post('PSR_ELEMENT') != null) {
				$psr = 1;
			} else {
				$psr = 0;
			}
			if ($this->input->post('PEINES') != null) {
				$peines = 1;
			} else {
				$peines = 0;
			}
			if ($this->input->post('AFFECTATION') != null) {
				$affectation = 1;
			} else {
				$affectation = 0;
			}
			if ($this->input->post('PERMIS') != null) {
				$permis = 1;
			} else {
				$permis = 0;
			}
			if ($this->input->post('DECLARATION') != null) {
				$declaration = 1;
			} else {
				$declaration = 0;
			}
			if ($this->input->post('IMMATRICULATION') != null) {
				$immatriculation = 1;
			} else {
				$immatriculation = 0;
			}
			if ($this->input->post('CONTROLE_TECHNIQUE') != null) {
				$controle = 1;
			} else {
				$controle = 0;
			}
			if ($this->input->post('ASSURANCE') != null) {
				$assurance = 1;
			} else {
				$assurance = 0;
			}
			if ($this->input->post('QUESTIONNAIRE') != null) {
				$questionnaire = 1;
			} else {
				$questionnaire = 0;
			}
			$data = array(
				'PROFIL_ID' => $this->input->post('PROFIL_ID'),
				'INFRACTION' => $infraction,
				'PSR_ELEMENT' => $psr,
				'PEINES' => $peines,
				'AFFECTATION' => $affectation,
				'PERMIS' => $permis,
				'DECLARATION' => $declaration,
				'IMMATRICULATION' => $immatriculation,
				'CONTROLE_TECHNIQUE' => $controle,
				'ASSURANCE' => $assurance,
				'QUESTIONNAIRE' => $questionnaire,
			);

			$this->Modele->update('droits', array('ID_DROIT' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('PSR/Droit/'));
		}
	}

	function delete()
	{
		$table = "droits";
		$criteres['ID_DROIT'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Droit'));
	}
}
