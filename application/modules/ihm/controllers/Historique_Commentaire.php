<?php

class Historique_Commentaire extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->have_droit();
    }

    public function have_droit()
    {
        if ($this->session->userdata('INFRACTION') != 1) {

            redirect(base_url());
        }
    }
	function index()
	{
		$data['title'] = "Commentaires";
		$type_verification = $this->Modele->getRequete(' SELECT ID_TYPE_VERIFICATION, VERIFICATION FROM type_verification WHERE 1 ORDER BY VERIFICATION');
		$data['type_verification'] = $type_verification;
		$this->load->view('Historique_Commentaire_List_View', $data);
	}

	function listing()
	{
		$i = 1;
		$verifications = $this->input->post('ID_TYPE_VERIFICATION');

		$critere_command = !empty($verifications) ? "and type_verification.ID_TYPE_VERIFICATION= " . $verifications . " " : "";
		$query_principal = "SELECT `COMMENTAIRE_ID`,type_verification.VERIFICATION,`COMMENTAIRE_TEXT`,`COMMENTAIRE_TEXT_TRADUCTION` FROM `historique_commentaire`  join type_verification  on historique_commentaire.ID_TYPE_VERIFICATION=type_verification.ID_TYPE_VERIFICATION WHERE 1 ". $critere_command ;


		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		

		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {

			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}


		$order_by = '';

		$order_column = array('COMMENTAIRE_TEXT');


		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY COMMENTAIRE_TEXT ASC';

		$search = !empty($_POST['search']['value']) ? ("AND COMMENTAIRE_TEXT LIKE '%$var_search%' ") : '';

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
			data-target='#mydelete" . $row->COMMENTAIRE_ID . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Historique_Commentaire/getOne/' . $row->COMMENTAIRE_ID) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" . $row->COMMENTAIRE_ID . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->COMMENTAIRE_TEXT . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Historique_Commentaire/delete/' . $row->COMMENTAIRE_ID) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>
			</div>
			</div>
			</div>";

			$sub_array = array();
			$sub_array[] = $row->COMMENTAIRE_TEXT;
			$sub_array[] = $row->VERIFICATION;
		//	$sub_array[] = $row->COMMENTAIRE_TEXT_TRADUCTION;

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
	  $data['veriff'] = $this->Modele->getRequete('SELECT `ID_TYPE_VERIFICATION`,`VERIFICATION` FROM `type_verification` WHERE 1');
		$data['title'] = 'Nouveau commentaire';
		$this->load->View('ihm/Historique_Commentaire_Add_View', $data);
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

		$this->form_validation->set_rules('COMMENTAIRE_TEXT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_TYPE_VERIFICATION', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		// $this->form_validation->set_rules('DESCRIPTION', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));



		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$data_insert = array(

				'COMMENTAIRE_TEXT' => $this->input->post('COMMENTAIRE_TEXT'),
				'ID_TYPE_VERIFICATION' => $this->input->post('ID_TYPE_VERIFICATION'),

				'COMMENTAIRE_TEXT_TRADUCTION' => $this->input->post('COMMENTAIRE_TEXT_TRADUCTION'),
			);

			$table = 'historique_commentaire';
			$this->Modele->create($table, $data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout est fait avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Historique_Commentaire/index'));
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

	function getOne($id)
	{
		$data['veriff'] = $this->Modele->getRequete('SELECT `ID_TYPE_VERIFICATION`,`VERIFICATION` FROM `type_verification` WHERE 1');
		$data['data'] = $this->Modele->getOne('historique_commentaire', array('COMMENTAIRE_ID' => $id));
		$data['title'] = 'Modification de Commentaire';
		$this->load->view('Historique_Commentaire_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('COMMENTAIRE_TEXT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_TYPE_VERIFICATION', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$id = $this->input->post('COMMENTAIRE_ID');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {
			$id = $this->input->post('COMMENTAIRE_ID');

			$data = array(
				'COMMENTAIRE_TEXT' => $this->input->post('COMMENTAIRE_TEXT'),
				'ID_TYPE_VERIFICATION' => $this->input->post('ID_TYPE_VERIFICATION'),
				'COMMENTAIRE_TEXT_TRADUCTION' => $this->input->post('COMMENTAIRE_TEXT_TRADUCTION'),
			);

			$this->Modele->update('historique_commentaire', array('COMMENTAIRE_ID' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification de l\'historique"est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Historique_Commentaire'));
		}
	}


	function delete()
	{
		$table = "historique_commentaire";
		$criteres['COMMENTAIRE_ID'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Historique_Commentaire'));
	}
}
