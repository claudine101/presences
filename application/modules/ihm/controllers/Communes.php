<?php

/**
 *NDAYISABA Claudine
 *	CRUD DE TABLE Communes
 **/
class  Communes extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		if ($this->session->userdata('ID_PROFIL') != 2 && $this->session->userdata('ID_PROFIL') != 5 && $this->session->userdata('ID_PROFIL') != 4) {
			// redirect(base_url());
			redirect('Login');
		}
	}

	function index()
	{
		$data['title'] = 'Liste des communes';
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
		$this->load->view('communes/Commune_List_View', $data);
	}

	function listing()
	{

		$i = 1;
		$condition = '';
        $province = $this->input->post('PROVINCE_ID');
        if (!empty($province)) {
             $condition .=  ' and co.PROVINCE_ID= "' . $province . '"';
        }
		$query_principal = 'SELECT COMMUNE_ID, COMMUNE_NAME,co.PROVINCE_ID  ,pro.PROVINCE_NAME, COMMUNE_LATITUDE, COMMUNE_LONGITUDE FROM syst_communes co JOIN syst_provinces pro ON pro.PROVINCE_ID=co.PROVINCE_ID WHERE 1'. $condition . ' ';
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';
		
		$order_column = array('COMMUNE_ID', 'COMMUNE_NAME','PROVINCE_NAME', 'COMMUNE_LATITUDE', 'COMMUNE_LONGITUDE');

		$order_by = isset($_POST['order']) ? 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY COMMUNE_NAME DESC';

		$search = !empty($_POST['search']['value']) ? ("AND COMMUNE_NAME LIKE '%$var_search%'") : '';

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
			data-target='#mydelete" . $row->COMMUNE_ID   . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Communes/getOne/' . $row->COMMUNE_ID  ) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->COMMUNE_ID   . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->COMMUNE_NAME . " </i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Communes/delete/' . $row->COMMUNE_ID  ) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";
			$sub_array = array();
			$u=++$u;
			$sub_array[]=$u;
			$sub_array[] = $row->COMMUNE_NAME;
			$sub_array[] = $row->PROVINCE_NAME;
            $sub_array[] = $row->COMMUNE_LATITUDE;
            $sub_array[] = $row->COMMUNE_LONGITUDE;
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
		$data['title'] = 'Nouvelle commune';
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
		$this->load->view('communes/Commune_Add_View', $data);
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
		$this->form_validation->set_rules('PROVINCE_ID', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('COMMUNE_NAME', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('COMMUNE_LATITUDE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('COMMUNE_LONGITUDE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
        if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$data_insert = array(
				'PROVINCE_ID' => $this->input->post('PROVINCE_ID'),
				'COMMUNE_NAME' => $this->input->post('COMMUNE_NAME'),
				'COMMUNE_LATITUDE' => $this->input->post('COMMUNE_LATITUDE'),
				'COMMUNE_LONGITUDE' => $this->input->post('COMMUNE_LONGITUDE'),

			);
			$table = 'syst_communes';
			$this->Modele->create($table, $data_insert);
			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Communes/'));
		}
	}

	function getOne($id)
	{
		$data['data'] = $this->Modele->getOne('syst_communes', array('COMMUNE_ID' => $id));
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
		$data['title'] = 'Modification du commune';
		$this->load->view('communes/Commune_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('PROVINCE_ID', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('COMMUNE_NAME', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('COMMUNE_LATITUDE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('COMMUNE_LONGITUDE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$id = $this->input->post('COMMUNE_ID');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {
			$id = $this->input->post('COMMUNE_ID');
			$data= array(
				'PROVINCE_ID' => $this->input->post('PROVINCE_ID'),
				'COMMUNE_NAME' => $this->input->post('COMMUNE_NAME'),
				'COMMUNE_LATITUDE' => $this->input->post('COMMUNE_LATITUDE'),
				'COMMUNE_LONGITUDE' => $this->input->post('COMMUNE_LONGITUDE'),

			);
			$this->Modele->update('syst_communes', array('COMMUNE_ID' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du communes est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Communes/'));
		}
	}

	function delete()
	{
		$table = "syst_communes";
		$criteres['COMMUNE_ID  '] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
		$data['message'] = '<div class="alert alert-success text-center" id="message">L\'element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Communes/'));
	}
}
