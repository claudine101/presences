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

	function getDetaisSign($id_control = 0)
	{

		$dataDetail = "SELECT us.NOM_UTILISATEUR,st.DESCRIPTION,DATE_FORMAT(hvv.DATE_INSERTION, '%d-%m-%Y') AS date  FROM histo_validation_civil hvv LEFT JOIN civil_alerts stp on stp.ID_ALERT=hvv.ID_SIGNALEMET LEFT JOIN utilisateurs us on us.ID_UTILISATEUR=hvv.USER_ID LEFT JOIN statut_validation st ON st.ID_STATUT=hvv.STATUT_TRAITEMENT WHERE 1 AND hvv.ID_SIGNALEMET=" . $id_control;


		$htmlDetail = "<div class='table-responsive'>
		<table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
		<thead>
		<tr>
		<th>Utilisateur</th>
		<th>Statut</th>
		<th>Date</th>
		</tr>
		</thead>

		<tbody>";

		$total = 0;
		foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {



			$htmlDetail .= "<tr>
			<td>" . $value['NOM_UTILISATEUR'] . "</td>
			<td>" . $value['DESCRIPTION'] . "</td>
			<td>" . $value['date'] . "</td>
			</tr>";
		}

		$htmlDetail .= "</tbody></table>
		</div>";


		return $htmlDetail;
	}



	function validations($id = 0, $idhis = 0)
	{
		$stat = 4;
		$datas =  array(
			'VALIDATION' => 1,
			'STATUT_TRAITEMENT' => $stat
		);

		$datl = array(
			'ID_SIGNALEMET' => $id,
			'USER_ID' => $this->session->userdata('USER_ID'),
			'STATUT_TRAITEMENT' => $stat
		);

		$data_update = $this->Model->getRequeteOne('SELECT ID_ALERT,concat(us.NOM_CITOYEN, " ", us.PRENOM_CITOYEN) as name, civil_alerts_types.DESCRIPTION, obr.NUMERO_PLAQUE, CIVIL_DESCRIPTION, IMAGE_1, IMAGE_2, IMAGE_3, cia.DATE_INSERTION,sv.DESCRIPTION as STATUT_TRAITEM,sv.ID_STATUT as status,c.NOM_CHAUSSE,cia.VALIDATION,us.NOM_UTILISATEUR,obr.TELEPHONE,hvv.ID_SIGNALEMET,cia.STATUT_TRAITEMENT FROM civil_alerts cia LEFT JOIN utilisateurs us on us.ID_UTILISATEUR=cia.ID_UTILISATEUR LEFT JOIN obr_immatriculations_voitures obr ON obr.ID_IMMATRICULATION=cia.ID_IMMATICULATION  LEFT JOIN civil_alerts_types on civil_alerts_types.ID_TYPE=cia.ID_ALERT_TYPE LEFT JOIN statut_validation sv on sv.ID_STATUT=cia.STATUT_TRAITEMENT LEFT JOIN histo_validation_vol hvv ON hvv.ID_SIGNALEMET=cia.ID_ALERT LEFT JOIN chaussee c ON c.ID_CHAUSSEE=cia.ID_CHAUSSEE WHERE ID_ALERT=' . $id);

		$this->Modele->update('civil_alerts', array('ID_ALERT' => $id), $datas);


		$table1 = 'histo_validation_civil';
		$this->Modele->create($table1, $datl);
		$sms = "Mr " . $data_update['name'] . ", votre de mande est prise en charge par la PNB " . date("d-m-Y", strtotime($data_update['DATE_INSERTION'])) . " ";

		$test = $this->send_sms_smpp($data_update['TELEPHONE'], $sms);

		// print_r($test);
		// exit();

		$notif_data = array(
			"USER_ID" => $this->session->userdata('USER_ID'),
			"MESSAGE" => $sms,
			"TELEPHONE" => $data_update['TELEPHONE'],
			"NUMERO_PLAQUE" => $data_update['NUMERO_PLAQUE'],
			"STATUT" => 1,
		);

		$this->Modele->create('notifications', $notif_data);

		$data['message'] = '<div class="alert alert-success text-center" id="message">La demande est prise en charge avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Civil_alert/'));
		// } else {

		// 	$data['message'] = '<div class="alert alert-danger text-center" id="message">le déclarant n\'est pas reconnu comme chauffeur</div>';
		// 	$this->session->set_flashdata($data);
		// 	redirect(base_url('PSR/Civil_alert/'));
		// }
	}

	function validation_Premier($id = 0, $idhis = 0)
	{
		$data1 = array(
			'ID_SIGNALEMET' => $id,
			'USER_ID' => $this->session->userdata('USER_ID'),
			'STATUT_TRAITEMENT' => 1,
		);
		$datas = array(

			"VALIDATION" => 0,
			"STATUT_TRAITEMENT" => 1,
		);
		$table = 'histo_validation_civil';
		$this->Modele->create($table, $data1);
		$this->Modele->update('civil_alerts', array('ID_ALERT' => $id), $datas);

		$data['message'] = '<div class="alert alert-success text-center" id="message">La demande est prise en charge avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Civil_alert/'));
	}

	function validation_final($id = 0, $idhis = 0)
	{
		$status = 2;
		$datas = array(
			"VALIDATION" => 0,
			"STATUT_TRAITEMENT" => $status,
		);
		$data1 = array(
			'ID_SIGNALEMET' => $id,
			'USER_ID' => $this->session->userdata('USER_ID'),
			'STATUT_TRAITEMENT' => $status,
		);
		$table = 'histo_validation_civil';
		$this->Modele->create($table, $data1);
		$this->Modele->update('civil_alerts', array('ID_ALERT' => $id), $datas);

		$data['message'] = '<div class="alert alert-success text-center" id="message">La demande est prise en charge avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Civil_alert/'));
	}


	function listing()
	{
		$condition1 = "";

		if ($this->session->userdata('PROFIL_ID') == 1) {
			$condition1 = "";
		} else if ($this->session->userdata('PROFIL_ID') == 10) {
			$condition1 = " AND cia.STATUT_TRAITEMENT=3";
		} else if ($this->session->userdata('PROFIL_ID') == 11) {
			$condition1 = " AND cia.STATUT_TRAITEMENT=1";
		}
		$query_principal = 'SELECT ID_ALERT,concat(us.NOM_CITOYEN, " ", us.PRENOM_CITOYEN) as name, civil_alerts_types.DESCRIPTION, obr.NUMERO_PLAQUE, CIVIL_DESCRIPTION, IMAGE_1, IMAGE_2, IMAGE_3, cia.DATE_INSERTION,sv.DESCRIPTION as STATUT_TRAITEM,sv.ID_STATUT as status,c.NOM_CHAUSSE,cia.VALIDATION,us.NOM_UTILISATEUR,hvv.ID_SIGNALEMET,cia.STATUT_TRAITEMENT FROM civil_alerts cia LEFT JOIN utilisateurs us on us.ID_UTILISATEUR=cia.ID_UTILISATEUR LEFT JOIN obr_immatriculations_voitures obr ON obr.ID_IMMATRICULATION=cia.ID_IMMATICULATION  LEFT JOIN civil_alerts_types on civil_alerts_types.ID_TYPE=cia.ID_ALERT_TYPE LEFT JOIN statut_validation sv on sv.ID_STATUT=cia.STATUT_TRAITEMENT LEFT JOIN histo_validation_vol hvv ON hvv.ID_SIGNALEMET=cia.ID_ALERT LEFT JOIN chaussee c ON c.ID_CHAUSSEE=cia.ID_CHAUSSEE WHERE 1' . $condition1;



		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
         
		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';

		$order_column = array('NOM_UTILISATEUR', 'NUMERO_PLAQUE', 'DESCRIPTION', 'CIVIL_DESCRIPTION', 'IMAGE_1', 'IMAGE_2', 'IMAGE_3','DATE_INSERTION');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM_UTILISATEUR ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%' OR NOM_UTILISATEUR LIKE '%$var_search%' OR CIVIL_DESCRIPTION LIKE '%$var_search%'") : '';

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
				$img = 'Pas de Photo';
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
			if ($this->session->userdata('PROFIL_ID') == 10) {
				$option .= "<li><a href='#' data-toggle='modal'
				data-target='#stat1" . $row->ID_ALERT . "'><label class='text-primary'>&nbsp;&nbsp;Superviseur</label></a></li>";
			} else {
				$option .= "";
			}
			if ($this->session->userdata('PROFIL_ID') == 11) {
				$option .= "<li><a href='#' data-toggle='modal'
				data-target='#stat2" . $row->ID_ALERT . "'><label class='text-secondary'>&nbsp;&nbsp;OPJ</label></a></li>";
			} else {
				$option .= "";
			}

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
				$image .= "<img style='width:50%' src='" . $row->IMAGE_1 . "'>";
			}


			if (!empty($row->IMAGE_2)) {
				$image .= "<img style='width:50%' src='" . $row->IMAGE_2 . "'>";
			}

			if (!empty($row->IMAGE_3)) {
				$image .= "<img style='width:50%' src='" . $row->IMAGE_3 . "'>";
			}



			$image .= "</div>

			<div class='modal-footer'>
			
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$option .= " 
			<div class='modal fade' id='stat1" .  $row->ID_ALERT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center>
			<p> Voulez-vous confirmer l'alerte?<br></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-primary btn-md' href='" . base_url('PSR/Civil_alert/validation_Premier/' . $row->ID_ALERT . '/' . $row->status) . "'>Valider</a>
			<button class='btn btn-danger btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$option .= " 
			<div class='modal fade' id='stat2" .  $row->ID_ALERT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center>
			<p> Voulez-vous accorder la suite à cette demande?<br></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-primary btn-md' href='" . base_url('PSR/Civil_alert/validation_final/' . $row->ID_ALERT . '/' . $row->status) . "'>Valider</a>
			<button class='btn btn-danger btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";
			$var = "<span  class='btn btn-md dt-button btn-sm'>Historique</span>";

			$detailSign = '';

			$detailSign .= "<a hre='#' data-toggle='modal'
			data-target='#detail" . $row->ID_ALERT . "'>" . $var . "</a>";
			$detailSign .= "
			<div class='modal fade' id='detail" . $row->ID_ALERT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
			<h5 class='modal-title'>Detail de controle</h5>
			<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>";


			if ($row->ID_ALERT != Null) {
				$detailSign .= $this->getDetaisSign($row->ID_ALERT);
			}

			$detailSign .= "
			</div>
			<div class='modal-footer'>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";




			$sub_array = array();
			// $sub_array[] = $row->DATE_INSERTION;
			$sub_array[] = '<table> <tbody><tr><td><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="https://app.mediabox.bi/wasiliEate/uploads/personne.png"></td><td>' . $row->name . ' </td></tr></tbody></table>';
			//<font style="font-size:10px;color:red"><i class="far fa-comment-dots"></i></font>
			$sub_array[] = $row->DESCRIPTION;
			$sub_array[] = $plaque;
			$validation  = "<a hre='#' data-toggle='modal'
			data-target='#validations" . $row->ID_ALERT . "'><font color='black'>&nbsp;&nbsp;No Validé</font></a>";
			$valid = ($row->VALIDATION == 0) ? $validation : "<b style='color:green'>Validé</b>";

			$option .= "
			<div class='modal fade' id='validations" . $row->ID_ALERT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5 style='color:black'>Voulez-vous prendre en charge cette demande de <br> " . $row->NOM_UTILISATEUR . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-success btn-md' href='" . base_url('PSR/Civil_alert/validations/' . $row->ID_ALERT . '/' . $row->status) . "'>valider</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";
			if ($this->session->userdata('PROFIL_ID') == 1) {
				$sub_array[] = $valid . '<br>' . $detailSign;
			} else {
				$sub_array[] = 'Non validé';
			}

			$sub_array[] =  !empty($row->CIVIL_DESCRIPTION) ? "<span title='" . $row->CIVIL_DESCRIPTION . "'>commentaire ...</span>" : '-';
			$sub_array[] = $image;
			$sub_array[] = $row->STATUT_TRAITEM;
			$sub_array[] = date("d-m-Y", strtotime($row->DATE_INSERTION));
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

	public function send_sms_smpp($string_tel = NULL, $string_msg)
	{
		$data = '{"phone":' . $string_tel . ',"txt_message":"' . $string_msg . '"}';

		$header = array();
		$header[1] = 'Content-Type:application/json';

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://51.83.236.148:3030/sms');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		$result = curl_exec($curl);
		// $result = json_decode($result);

		return $result;
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
