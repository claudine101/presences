<?php

/**
 *NDAYISABA Claudine
 *	CRUD DE TABLE Etagere
 **/
class  Etagere extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		// $this->have_droit();
	}

	public function have_droit()
	{
		if ($this->session->userdata('ID_ETAGERE') != 2 && $this->session->userdata('ID_ETAGERE') != 5 && $this->session->userdata('ID_ETAGERE') != 4) {
			// redirect(base_url());
			redirect('Login');
		}
	}

	function index()
	{
		$data['title'] = 'Liste des étagères';
		$data['services'] = $this->Modele->getRequete('SELECT * FROM service WHERE 1 order by DESCRIPTION ASC');
		$this->load->view('etagere/Etagere_List_View', $data);
	}

	function listing()
	{
		$i = 1;
		$condition = '';
        $service = $this->input->post('ID_SERVICE');
        if (!empty($service)) {
             $condition .=  ' AND s.ID_SERVICE= "' . $service . '"';
        }
		$query_principal = 'SELECT e.ID_ETAGERE, e.DESIGNATION ,s.ID_SERVICE,s.DESCRIPTION FROM etagere e LEFT JOIN service s ON s.ID_SERVICE=e.ID_SERVICE WHERE 1'. $condition . ' ';
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';

		$order_column = array('ID_ETAGERE','DESIGNATION','DESCRIPTION');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DESIGNATION DESC';

		$search = !empty($_POST['search']['value']) ? ("AND DESIGNATION LIKE '%$var_search%' OR DESCRIPTION LIKE '%$var_search%'") : '';

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
			data-target='#mydelete" . $row->ID_ETAGERE . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('archive/Etagere/getOne/' . $row->ID_ETAGERE) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_ETAGERE. "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->DESIGNATION . " </i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('archive/Etagere/delete/' . $row->ID_ETAGERE) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";
			$sub_array = array();
			$u=++$u;
			$sub_array[]=$u;
			$sub_array[] = $row->DESIGNATION;
			$sub_array[] = $row->DESCRIPTION;
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
		$data['title'] = 'Nouvelle étagère';
		$data['services'] = $this->Modele->getRequete('SELECT * FROM service WHERE 1 order by DESCRIPTION ASC');
		$this->load->view('etagere/Etagere_Add_View', $data);
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
		$this->form_validation->set_rules('DESIGNATION', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_SERVICE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$data_insert = array(

				'DESIGNATION' => $this->input->post('DESIGNATION'),
				'ID_SERVICE'=> $this->input->post('ID_SERVICE'),
			);
			$table = 'etagere';
			$this->Modele->create($table, $data_insert);
			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('archive/Etagere/'));
		}
	}

	function getOne($id)
	{
		$etageres = $this->Modele->getOne('etagere', array('ID_ETAGERE' => $id));
		$serv = $this->Modele->getOne('service', array('ID_SERVICE' => $etageres['ID_SERVICE']));
		$data['data'] = $etageres;
		$data['selectServ'] = $serv;
		$data['services'] = $this->Modele->getRequete('SELECT * FROM service WHERE 1 order by DESCRIPTION ASC');

		
		$data['title'] = "Modification de l'étagère";
		$this->load->view('etagere/Etagere_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('DESIGNATION', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_SERVICE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$id = $this->input->post('ID_ETAGERE');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {
			$id = $this->input->post('ID_ETAGERE');

			$data = array(
				'DESIGNATION' => $this->input->post('DESIGNATION'),
				'ID_SERVICE'=> $this->input->post('ID_SERVICE')
			);
			$this->Modele->update('etagere', array('ID_ETAGERE' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du profil est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('archive/Etagere/'));
		}
	}

	function delete()
	{
		$table = "etagere";
		$criteres['ID_ETAGERE'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
		$data['message'] = '<div class="alert alert-success text-center" id="message">L\'element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('archive/Etagere'));
	}
}
