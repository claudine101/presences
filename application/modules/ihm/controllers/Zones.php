<?php

/**
 *NDAYISABA Claudine
 *	CRUD DE TABLE Zones
 **/
class  Zones extends CI_Controller
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
		$data['title'] = 'Liste des zones';
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
		$this->load->view('zones/Zone_List_View', $data);
	}

	function listing()
	{

		$i = 1;

		$PROVINCE_ID = $this->input->post('PROVINCE_ID');
	    $COMMUNE_ID = $this->input->post('COMMUNE_ID');
	 
	    $critere_province = "";
	    $critere_commune = "";

       
        $critere_province = !empty($PROVINCE_ID) ? "  AND pro.PROVINCE_ID=".$PROVINCE_ID." ":"";
        $critere_commune = !empty($COMMUNE_ID) ? "  AND co.COMMUNE_ID=".$COMMUNE_ID." ":"";
       
		$query_principal = 'SELECT zo.ZONE_ID ,zo.ZONE_NAME, zo.LATITUDE, zo.LONGITUDE, co.COMMUNE_ID, co.COMMUNE_NAME,pro.PROVINCE_ID  ,pro.PROVINCE_NAME FROM syst_zones zo JOIN syst_communes co ON zo.COMMUNE_ID=co.COMMUNE_ID JOIN syst_provinces pro ON pro.PROVINCE_ID=co.PROVINCE_ID WHERE 1'. $critere_province . ''. $critere_commune . ' ';
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';
		
		$order_column = array('ZONE_ID', 'ZONE_NAME','COMMUNE_NAME','PROVINCE_NAME', 'LATITUDE', 'LONGITUDE');

		$order_by = isset($_POST['order']) ? 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY ZONE_NAME DESC';

		$search = !empty($_POST['search']['value']) ? ("AND ZONE_NAME LIKE '%$var_search%'") : '';

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
			data-target='#mydelete" . $row->ZONE_ID   . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Zones/getOne/' . $row->ZONE_ID  ) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ZONE_ID   . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->ZONE_NAME . " </i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Zones/delete/' . $row->ZONE_ID  ) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";
			$sub_array = array();
			$u=++$u;
			$sub_array[]=$u;
			$sub_array[] = $row->ZONE_NAME;
			$sub_array[] = $row->COMMUNE_NAME;
			$sub_array[] = $row->PROVINCE_NAME;
            $sub_array[] = $row->LATITUDE;
            $sub_array[] = $row->LONGITUDE;
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
		$data['title'] = 'Nouvelle Zone';
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
		$this->load->view('zones/Zone_Add_View', $data);
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
		$this->form_validation->set_rules('COMMUNE_ID', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ZONE_NAME', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('LATITUDE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('LONGITUDE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
        if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$data_insert = array(
				'COMMUNE_ID' => $this->input->post('COMMUNE_ID'),
				'ZONE_NAME' => $this->input->post('ZONE_NAME'),
				'LATITUDE' => $this->input->post('LATITUDE'),
				'LONGITUDE' => $this->input->post('LONGITUDE'),
			);
			$table = 'syst_zones';
			$this->Modele->create($table, $data_insert);
			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Zones/'));
		}
	}

	function getOne($id)
	{
		$zone = $this->Modele->getOne('syst_zones', array('ZONE_ID' => $id));
		$commun = $this->Modele->getOne('syst_communes', array('COMMUNE_ID' => $zone['COMMUNE_ID']));
		$prov = $this->Modele->getOne('syst_provinces', array('PROVINCE_ID' => $commun['PROVINCE_ID']));


		$data['communes'] = $this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID=' . $prov['PROVINCE_ID'] . ' ORDER BY COMMUNE_NAME ASC');
		
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
		

		$data['data'] = $zone;
		$data['selectComm'] = $commun;
		$data['selectProv'] = $prov;

	
		$data['title'] = 'Modification du zone';
		$this->load->view('zones/Zone_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('PROVINCE_ID', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('COMMUNE_ID', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ZONE_NAME', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('LATITUDE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('LONGITUDE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$id = $this->input->post('ZONE_ID');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {
			$id = $this->input->post('ZONE_ID');
			$data = array(
				'COMMUNE_ID' => $this->input->post('COMMUNE_ID'),
				'ZONE_NAME' => $this->input->post('ZONE_NAME'),
				'LATITUDE' => $this->input->post('LATITUDE'),
				'LONGITUDE' => $this->input->post('LONGITUDE'),
			);
			$this->Modele->update('syst_zones', array('ZONE_ID' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du zone est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Zones/'));
		}
	}

	function delete()
	{
		$table = "syst_zones";
		$criteres['ZONE_ID'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
		$data['message'] = '<div class="alert alert-success text-center" id="message">L\'element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Zones/'));
	}
}
