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
		// if ($this->session->userdata('PARAMETRE') != 1) {

		// 	redirect(base_url());
		// }
	}
	function index()
	{
		$data['title'] = 'Matrice';
		$this->load->view('droit/Droit_List_View', $data);
	}
	function listing()
	{
		$i = 1;
		$query_principal = 'SELECT   pr.STATUT AS STATUS ,dr.* FROM droits dr LEFT JOIN profils pr ON pr.ID_PROFIL=dr.ID_PROFIL WHERE 1';
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,10';
		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';
		$order_column = array('ID_DROIT','STATUS', 'IHM' );
		
		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY IHM ASC';

		$search = !empty($_POST['search']['value']) ? ("AND STATUT LIKE '%$var_search%' ") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_psr = $this->Modele->datatable($query_secondaire);
		$data = array();
		$u=0;
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
			$option .= "<li><a class='btn-md' href='" . base_url('administration/Droit/getOne/' . $row->ID_DROIT) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_DROIT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->ID_DROIT . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('administration/Droit/delete/' . $row->ID_DROIT) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			$u=++$u;
			$sub_array[]=$u;
			$sub_array[] = $row->STATUS;
			$sub_array[] = $row->IHM ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
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
		$data['profils'] = $this->Model->getRequete('SELECT ID_PROFIL, STATUT FROM profils WHERE 1 ORDER BY STATUT ASC');
		$data['title'] = 'Nouveau élément';
		$this->load->view('droit/Droit_Add_View', $data);
	}




	function add()
	{

		$this->form_validation->set_rules('ID_PROFIL', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {
		
			if ($this->input->post('IHM') != null) {
				$IHM = 1;
			} else {
				$IHM = 0;
			}
			$data_insert = array(
				'ID_PROFIL' => $this->input->post('ID_PROFIL'),
                'IHM' => $IHM,
			);
			
			$table = 'droits';
			$this->Modele->create($table, $data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('administration/Droit/'));
		}
	}

	function getOne()
	{
		$id = $this->uri->segment(4);
		$data['data'] = $this->Modele->getOne('droits', array('ID_DROIT' => $id));
		$data['profils'] = $this->Model->getRequete('SELECT ID_PROFIL, STATUT FROM profils WHERE 1 ORDER BY STATUT ASC');

        $IHM='';
       

		if ($data['data']['IHM'] == 1) {
			$IHM = 'checked';
		}
		$data['IHM'] = $IHM;

		$data['title'] = "Modification d'un Police";
		$this->load->view('droit/Droit_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('ID_PROFIL', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		$id = $this->input->post('ID_DROIT');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne();
		} else {
			$id = $this->input->post('ID_DROIT');

			if ($this->input->post('IHM') != null) {
				$IHM = 1;
			} else {
				$IHM = 0;
			}

			
			$data = array(
				'ID_PROFIL' => $this->input->post('ID_PROFIL'),
                'IHM' => $IHM,
            );
			$this->Modele->update('droits', array('ID_DROIT' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('administration/Droit/'));
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
		redirect(base_url('administration/Droit'));
	}
}
