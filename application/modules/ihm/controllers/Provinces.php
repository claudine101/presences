<?php

/**
 *NDAYISABA Claudine
 *	CRUD DE TABLE Provinces
 **/
class  Provinces extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		//  if ($this->session->userdata('PARAMETRE') != 1) {

        //        redirect(base_url());
        //   }
	}

	function index()
	{
		$data['title'] = 'Liste des provinces';
		$this->load->view('provinces/Province_List_View', $data);
	}

	function listing()
	{

		$i = 1;
		$query_principal = 'SELECT PROVINCE_ID, PROVINCE_NAME, OBJECTIF, PROVINCE_LATITUDE, PROVINCE_LONGITUDE, PAYS_CODE FROM syst_provinces WHERE 1';
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';
		
		$order_column = array('PROVINCE_ID', 'PROVINCE_NAME', 'PAYS_CODE', 'PROVINCE_LATITUDE', 'PROVINCE_LONGITUDE');

		$order_by = isset($_POST['order']) ? 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY PROVINCE_NAME DESC';

		$search = !empty($_POST['search']['value']) ? ("AND PROVINCE_NAME LIKE '%$var_search%'") : '';

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
			data-target='#mydelete" . $row->PROVINCE_ID   . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Provinces/getOne/' . $row->PROVINCE_ID  ) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->PROVINCE_ID   . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->PROVINCE_NAME . " </i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Provinces/delete/' . $row->PROVINCE_ID  ) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";
			$sub_array = array();
			$u=++$u;
			$sub_array[]=$u;
			$sub_array[] = $row->PROVINCE_NAME;
            $sub_array[] = $row->PAYS_CODE;
            $sub_array[] = $row->PROVINCE_LATITUDE;
            $sub_array[] = $row->PROVINCE_LONGITUDE;
            // $sub_array[] = $row->OBJECTIF;
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
		$data['title'] = 'Nouvelle province';
		$this->load->view('provinces/Province_Add_View', $data);
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
		$this->form_validation->set_rules('PROVINCE_NAME', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('PROVINCE_LATITUDE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('PROVINCE_LONGITUDE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
        if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$data_insert = array(
				'PROVINCE_NAME' => $this->input->post('PROVINCE_NAME'),
				'PROVINCE_LATITUDE' => $this->input->post('PROVINCE_LATITUDE'),
				'PROVINCE_LONGITUDE' => $this->input->post('PROVINCE_LONGITUDE'),

			);
			$table = 'syst_provinces';
			$this->Modele->create($table, $data_insert);
			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Provinces/'));
		}
	}

	function getOne($id)
	{
		$data['data'] = $this->Modele->getOne('syst_provinces', array('PROVINCE_ID' => $id));
		$data['title'] = 'Modification du poste';
		$this->load->view('provinces/Province_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('PROVINCE_NAME', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$id = $this->input->post('PROVINCE_ID');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {
			$id = $this->input->post('PROVINCE_ID');

			$data = array(
				'PROVINCE_NAME' => $this->input->post('PROVINCE_NAME'),
			);
			$this->Modele->update('syst_provinces', array('PROVINCE_ID' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du provinces est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Provinces/'));
		}
	}

	function delete()
	{
		$table = "syst_provinces";
		$criteres['PROVINCE_ID  '] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
		$data['message'] = '<div class="alert alert-success text-center" id="message">L\'element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Provinces/'));
	}

	function get_communes($ID_PROVINCE=0)
	{
		$communes=$this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID='.$ID_PROVINCE.' ORDER BY COMMUNE_NAME ASC');
		$html='<option value="">---selectionner---</option>';
		foreach ($communes as $key)
		{
			$html.='<option value="'.$key['COMMUNE_ID'].'">'.$key['COMMUNE_NAME'].'</option>';
		}
		echo json_encode($html);
	}

	function get_zones($ID_COMMUNE=0)
	{
		$zones=$this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID='.$ID_COMMUNE.' ORDER BY ZONE_NAME ASC');
		$html='<option value="">---selectionner---</option>';
		foreach ($zones as $key)
		{
			$html.='<option value="'.$key['ZONE_ID'].'">'.$key['ZONE_NAME'].'</option>';
		}
		echo json_encode($html);
	}

	function get_collines($ID_ZONE=0)
	{
		$collines=$this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID='.$ID_ZONE.' ORDER BY COLLINE_NAME ASC');
		$html='<option value="">---selectionner---</option>';
		foreach ($collines as $key)
		{
			$html.='<option value="'.$key['COLLINE_ID'].'">'.$key['COLLINE_NAME'].'</option>';
		}
		echo json_encode($html);
	}


}
