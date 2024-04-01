<?php

/**
 *
 *	 
 **/
class Civil_alert extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		if ($this->session->userdata('PSR_ELEMENT') != 1 && $this->session->userdata('SIGNALEMENT') != 1) {

			redirect(base_url());
		}
	}
	function index()
	{
		$data['title'] = 'Alertes des Citoyens';
		$this->load->view('civil_alert_list_v', $data);
	}

	function listing()
	{
		$i = 1;
		$query_principal = 'SELECT ID_ALERT,concat(us.NOM_CITOYEN, " ", us.PRENOM_CITOYEN) as name, civil_alerts_types.DESCRIPTION, obr.NUMERO_PLAQUE, CIVIL_DESCRIPTION, IMAGE_1, IMAGE_2, IMAGE_3, cia.DATE_INSERTION FROM civil_alerts cia LEFT JOIN utilisateurs us on us.ID_UTILISATEUR=cia.ID_UTILISATEUR LEFT JOIN obr_immatriculations_voitures obr ON obr.ID_IMMATRICULATION=cia.ID_IMMATICULATION  LEFT JOIN civil_alerts_types on civil_alerts_types.ID_TYPE=cia.ID_ALERT_TYPE WHERE 1';



		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';

		$order_column = array('NUMERO_PLAQUE', 'NOM_UTILISATEUR', 'DESCRIPTION', 'CIVIL_DESCRIPTION', 'IMAGE_1', 'IMAGE_2', 'IMAGE_3');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%' OR NOM_UTILISATEUR LIKE '%$var_search%' OR CIVIL_DESCRIPTION LIKE '%$var_search%'  OR DESCRIPTION LIKE '%$var_search%'") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_psr = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_psr as $row) {
			$image = '';
			if ($row->NUMERO_PLAQUE) {
				$plaque = $row->NUMERO_PLAQUE;
			} else {
				$plaque = 'N/A';
			}
			if ($row->IMAGE_1 || $row->IMAGE_2 || $row->IMAGE_3) {
				$img = '<span class = "btn btn-success btn-sm " ><i class = "fa fa-eye" ></i></span>';
			} else {
				$img = 'N/A';
			}

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_ALERT . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" . $row->ID_ALERT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer l'historique de?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->DESCRIPTION . " du " . $row->DATE_INSERTION . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Civil_alert/delete/' . $row->ID_ALERT) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$image = "<a hre='#' data-toggle='modal'
			data-target='#image" . $row->ID_ALERT . "'>" . $img . "</a>";
			$image .= "
			<div class='modal fade' id='image" . $row->ID_ALERT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center>
			<p><b>" . $row->DESCRIPTION . "</b></center></p>";

			if (!empty($row->IMAGE_1)) {
				$image .= "<img style='width:50%' src='http://app.mediabox.bi:1997/images/alerts/" . $row->IMAGE_1 . "'>";
			}


			if (!empty($row->IMAGE_2)) {
				$image .= "<img style='width:50%' src='http://app.mediabox.bi:1997/images/alerts/" . $row->IMAGE_2 . "'>";
			}

			if (!empty($row->IMAGE_3)) {
				$image .= "<img style='width:50%' src='http://app.mediabox.bi:1997/images/alerts/" . $row->IMAGE_3 . "'>";
			}



			$image .= "</div>

			<div class='modal-footer'>
			
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>

			";

			$sub_array = array();
			// $sub_array[] = $row->DATE_INSERTION;
			$sub_array[] = '<table> <tbody><tr><td><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="https://app.mediabox.bi/wasiliEate/uploads/personne.png"></td><td>' . $row->name . ' <font style="font-size:10px;color:red"><i class="far fa-comment-dots"></i></font></td></tr></tbody></table>';
			$sub_array[] = $row->DESCRIPTION;
			$sub_array[] = $plaque;
			$sub_array[] =  !empty($row->CIVIL_DESCRIPTION) ? "<span title='" . $row->CIVIL_DESCRIPTION . "'>commentaire ...</span>" : '-';
			$sub_array[] = $image;
			$sub_array[] = $row->DATE_INSERTION;
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

	function delete()
	{
		$table = "civil_alerts";
		$criteres['ID_ALERT'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Civil_alert'));
	}
}
