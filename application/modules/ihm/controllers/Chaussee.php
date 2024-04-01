<?php
class Chaussee extends CI_Controller
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
		$data['title'] = "Liste de chaussée";
		$this->load->view('Chausse_List_V', $data);
	}

	function listing()
	{
		$i = 1;
		$query_principal = "SELECT `ID_CHAUSSEE`, `NOM_CHAUSSE` FROM `chaussee` WHERE 1";

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		

		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {

			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}


		$order_by = '';

		$order_column = array('NOM_CHAUSSE');


		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM_CHAUSSE ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM_CHAUSSE LIKE '%$var_search%' ") : '';


		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;


		$fetch_peine = $this->Modele->datatable($query_secondaire);
		$data = array();




		foreach ($fetch_peine as $row) {

			$done = $this->Modele->getOne('chaussee', array('ID_CHAUSSEE' => $row->ID_CHAUSSEE));
			$array = json_decode($done['NOM_CHAUSSE'], true);



			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_CHAUSSEE . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Chaussee/getOne/' . $row->ID_CHAUSSEE) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_CHAUSSEE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h4 style='color:black;'><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->NOM_CHAUSSE . "</i></b></h4></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Chaussee/delete/' . $row->ID_CHAUSSEE) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();

			$sub_array[] = $row->NOM_CHAUSSE;
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
		//$data['COULEUR']=$this->Modele->getRequete('SELECT `ID_CHAUSSEE`, `NOM_CHAUSSE` FROM `chaussee` WHERE 1');

		$data['title'] = 'Nouvelle chaussée';
		$this->load->View('ihm/Chausse_Add_V', $data);
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
	function add()
	{

		$this->form_validation->set_rules('NOM_CHAUSSE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('QUESTIONNAIRE_TRADUCTION', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$data_insert = array(

				'NOM_CHAUSSE' => $this->input->post('NOM_CHAUSSE'),
				'QUESTIONNAIRE_TRADUCTION' => $this->input->post('QUESTIONNAIRE_TRADUCTION'),
			);

			$table = 'chaussee';
			$this->Modele->create($table, $data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Chaussee/index'));
		}
	}

	function getOne($id)
	{
		
		$data['data'] = $this->Modele->getOne('chaussee', array('ID_CHAUSSEE' => $id));

		$data['title'] = 'Modification de Chaussée';

		$this->load->view('Chausse_Update_V', $data);
	}


	function update()
	{
		//$this->form_validation->set_rules('ID_CHAUSSEE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NOM_CHAUSSE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		$id = $this->input->post('ID_CHAUSSEE');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {
			$id = $this->input->post('ID_CHAUSSEE');

			$data = array(
				'NOM_CHAUSSE' => $this->input->post('NOM_CHAUSSE'),
				'QUESTIONNAIRE_TRADUCTION' => $this->input->post('QUESTIONNAIRE_TRADUCTION'),
			);

			$this->Modele->update('chaussee', array('ID_CHAUSSEE' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Chaussee'));
		}
	}


	function delete()
	{
		$table = "chaussee";
		$criteres['ID_CHAUSSEE'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Chaussee'));
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
}
