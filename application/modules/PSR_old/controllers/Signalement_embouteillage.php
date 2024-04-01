<?php

/**
 *
 *	 
 **/
class Signalement_embouteillage extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		if ($this->session->userdata('SIGNALEMENT') != 1 && $this->session->userdata('PSR_ELEMENT') != 1) {

			redirect(base_url());
		}
	}
	function index()
	{
		$data['title'] = 'Alertes les embouteillages';
		$this->load->view('signaler/signaler_embouch_list_v', $data);
	}

	function getDetaisSign($id_control = 0)
	{

		$dataDetail = "SELECT us.NOM_UTILISATEUR,st.DESCRIPTION,DATE_FORMAT(hvv.DATE_INSERTION, '%d-%m-%Y') AS date  FROM histo_validation_ambouteillage hvv LEFT JOIN sign_ambouteillage stp on stp.ID_AMBOUTEILLAGE=hvv.ID_SIGNALEMET LEFT JOIN utilisateurs us on us.ID_UTILISATEUR=hvv.USER_ID LEFT JOIN statut_validation st ON st.ID_STATUT=hvv.STATUT_TRAITEMENT WHERE 1 AND hvv.ID_SIGNALEMET=" . $id_control;


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
		$table = 'histo_validation_ambouteillage';
		$this->Modele->create($table, $data1);
		$this->Modele->update('sign_ambouteillage', array('ID_AMBOUTEILLAGE' => $id), $datas);

		$data['message'] = '<div class="alert alert-success text-center" id="message">La demande est prise en charge avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Signalement_embouteillage/'));
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
		$table = 'histo_validation_ambouteillage';
		$this->Modele->create($table, $data1);
		$this->Modele->update('sign_ambouteillage', array('ID_AMBOUTEILLAGE' => $id), $datas);

		// $this->sendEmbouteillageMessage($id);

		$data['message'] = '<div class="alert alert-success text-center" id="message">La demande est prise en charge avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Signalement_embouteillage/'));
	}


	function sendEmbouteillageMessage($id)
	{

		$police = $this->Model->getRequeteOne('SELECT ID_AMBOUTEILLAGE, sa.ID_CHAUSSEE ,chaussee.NOM_CHAUSSE,us.NOM_UTILISATEUR, CAUSE,concat(us.NOM_CITOYEN, " ", us.PRENOM_CITOYEN) as name, IMAGE_1, IMAGE_2, IMAGE_3, VALIDATION, sa.LONGITUDE, sa.LATITUDE, USER_ID, sa.DATE_INSERTION,sv.ID_STATUT as status,sv.DESCRIPTION as STATUT_TRAITEM,sa.STATUT_TRAITEMENT  FROM sign_ambouteillage sa LEFT JOIN utilisateurs us ON us.ID_UTILISATEUR=sa.USER_ID LEFT JOIN chaussee ON chaussee.ID_CHAUSSEE=sa.ID_CHAUSSEE  LEFT JOIN statut_validation sv on sv.ID_STATUT=sa.STATUT_TRAITEMENT WHERE 1 AND ID_AMBOUTEILLAGE=' . $id);


		$tokens =  $this->Model->getRequete('SELECT n.TOKEN,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,e.TELEPHONE FROM notification_tokens n JOIN utilisateurs u on n.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON e.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID WHERE 1');

		// print_r($tokens);
		// exit();

		if (!empty($tokens)) {

			$tokns = array();

			$nom = "";

			foreach ($tokens as $key => $value) {

				$tokns[] = $value['TOKEN'];

				$phoneNumber = str_replace(' ', '', $value['TELEPHONE']);

				$nom =  str_replace(' ', '', $value['NOM']) . ' ' . str_replace(' ', '', $value['PRENOM']) . ' (' . str_replace(' ', '', $value['NUMERO_MATRICULE']) . ")";
			}



			$MessageText = " on vient de contaster l'embouteillage sur la route " . $police['NOM_CHAUSSE'] . " , Veillez envoyer les agents pour débloquer la situation";

			$titre =  "Signalement embouteillage";

			$messageAgent =  $nom . ",\n" . $MessageText;

			$donnes = array(
				'TITRE' => $titre,
				'CONTENU' => $messageAgent,
				'tokens' => $tokns
			);

			//print_r($donnes);exit();

			$this->notifications->notificationApk($donnes);

			$data = array(
				'USER_ID' => $this->session->userdata('USER_ID'),
				'MESSAGE' => $messageAgent,
				'TELEPHONE' => $phoneNumber,
				'NUMERO_PLAQUE' => 'PSR',
				'IS_AGENT_PSR' => 1,
				'STATUT' => 1,
				'ID_PSR_ELEMENT' => 0
			);

			$this->notifications->send_sms_smpp($phoneNumber, $messageAgent);
		}

		$test = $this->Model->create('notifications', $data);

		if ($test) {
			echo '1';
		} else {
			echo '0';
		}
	}


	function listing()
	{
		$i = 1;

		$condition1 = "";

		if ($this->session->userdata('PROFIL_ID') == 10) {
			$condition1 = " AND STATUT_TRAITEMENT=3";
		} else if ($this->session->userdata('PROFIL_ID') == 11) {
			$condition1 = " AND STATUT_TRAITEMENT=1";
		}



		$query_principal = 'SELECT ID_AMBOUTEILLAGE, sa.ID_CHAUSSEE ,chaussee.NOM_CHAUSSE,us.NOM_UTILISATEUR, CAUSE,concat(us.NOM_CITOYEN, " ", us.PRENOM_CITOYEN) as name, IMAGE_1, IMAGE_2, IMAGE_3, VALIDATION, sa.LONGITUDE, sa.LATITUDE, USER_ID, sa.DATE_INSERTION,sv.ID_STATUT as status,sv.DESCRIPTION as STATUT_TRAITEM,sa.STATUT_TRAITEMENT  FROM sign_ambouteillage sa LEFT JOIN utilisateurs us ON us.ID_UTILISATEUR=sa.USER_ID LEFT JOIN chaussee ON chaussee.ID_CHAUSSEE=sa.ID_CHAUSSEE  LEFT JOIN statut_validation sv on sv.ID_STATUT=sa.STATUT_TRAITEMENT WHERE 1' . $condition1;


		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';

		$order_column = array('NOM_CHAUSSE', 'CAUSE', 'name', 'IMAGE_1', 'IMAGE_2', 'IMAGE_3');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_INSERTION ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM_CHAUSSE LIKE '%$var_search%' OR CAUSE LIKE '%$var_search%' ") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_psr = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_psr as $row) {
			$image = '';
			$stat = '';
			$val_stdu = '';
			$val_stat = '';


			if ($row->VALIDATION == 1) {
				$val_stdu = '<span style="color : green">validé</span>';
			} else {
				$val_stat = '<span style="color :red ">non validé </span>';
			}
			if ($row->IMAGE_1 || $row->IMAGE_2 || $row->IMAGE_3) {
				$img = '<span class = "btn btn-success btn-sm " ><i class = "fa fa-eye" ></i></span>';
			} else {
				$img = "pas d'Image";
			}



			$var = "<span  class='btn btn-md dt-button btn-sm'>Historique</span>";


			$detailSign = '';

			$detailSign .= "<a hre='#' data-toggle='modal'
			data-target='#detail" . $row->ID_AMBOUTEILLAGE . "'>" . $var . "</a>";
			$detailSign .= "
			<div class='modal fade' id='detail" . $row->ID_AMBOUTEILLAGE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
			<h5 class='modal-title'>Detail de controle</h5>
			<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>";


			if ($row->ID_AMBOUTEILLAGE != Null) {
				$detailSign .= $this->getDetaisSign($row->ID_AMBOUTEILLAGE);
			}

			$detailSign .= "
			</div>
			<div class='modal-footer'>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_AMBOUTEILLAGE . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Signalement_embouteillage/getOne/' . $row->ID_AMBOUTEILLAGE) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			if ($this->session->userdata('PROFIL_ID') == 10) {
				$option .= "<li><a href='#' data-toggle='modal'
				data-target='#stat1" . $row->ID_AMBOUTEILLAGE . "'><label class='text-primary'>&nbsp;&nbsp;Superviseur</label></a></li>";
			} else {
				$option .= "";
			}
			if ($this->session->userdata('PROFIL_ID') == 11) {
				$option .= "<li><a href='#' data-toggle='modal'
				data-target='#stat2" . $row->ID_AMBOUTEILLAGE . "'><label class='text-secondary'>&nbsp;&nbsp;OPJ</label></a></li>";
			} else {
				$option .= "";
			}


			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" . $row->ID_AMBOUTEILLAGE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer l'historique de?</strong> <br><b style='background-color:prink;color:green;'><i>l 'accident du " . $row->DATE_INSERTION . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Signalement_embouteillage/delete/' . $row->ID_AMBOUTEILLAGE) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$option .= " 
			<div class='modal fade' id='stat1" .  $row->ID_AMBOUTEILLAGE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center>
			<p> Voulez-vous confirmer le vol?<br></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-primary btn-md' href='" . base_url('PSR/Signalement_embouteillage/validation_Premier/' . $row->ID_AMBOUTEILLAGE . '/' . $row->status) . "'>Valider</a>
			<button class='btn btn-danger btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$option .= " 
			<div class='modal fade' id='stat2" .  $row->ID_AMBOUTEILLAGE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center>
			<p> Voulez-vous accorder la suite à cette demande?<br></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-primary btn-md' href='" . base_url('PSR/Signalement_embouteillage/validation_final/' . $row->ID_AMBOUTEILLAGE . '/' . $row->status) . "'>Valider</a>
			<button class='btn btn-danger btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$image = "<a hre='#' data-toggle='modal'
			data-target='#image" . $row->ID_AMBOUTEILLAGE . "'>" . $img . "</a>";
			$image .= "
			<div class='modal fade' id='image" . $row->ID_AMBOUTEILLAGE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center>
			<p><b>Images</b></center></p>";

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
			$stat .= "<a href='#' data-toggle='modal'
			data-target='#stat" . $row->ID_AMBOUTEILLAGE . "'><font color='blue'>&nbsp;&nbsp;" . $val_stat . "</font></a>";

			$stat .= " 
			<div class='modal fade' id='stat" .  $row->ID_AMBOUTEILLAGE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center>
			<p> Voulez-vous autoriser l'intervation sur l' embouteillage survenue sur la rue " . $row->NOM_CHAUSSE . "?<br></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-primary btn-md' href='" . base_url('PSR/Signalement_embouteillage/change_statut/' . $row->ID_AMBOUTEILLAGE . '/' . $row->VALIDATION . '/' . $row->status) . "'>Changer</a>
			<button class='btn btn-danger btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$sub_array = array();

			$name = '<table> <tbody><tr><td><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="https://app.mediabox.bi/wasiliEate/uploads/personne.png"></td><td>' . $row->name . ' <br>' . $row->NOM_UTILISATEUR . '</td></tr>
			</tbody></table>';
			$sub_array[] = !empty($row->name) ? $name : 'N/A';
			$sub_array[] = $row->NOM_CHAUSSE;
			$sub_array[] = $row->CAUSE;
			if ($this->session->userdata('PROFIL_ID') == 1) {
				$sub_array[] = ($val_stdu ? $val_stdu : $stat) . '<br>' . $detailSign;
			} else {
				$sub_array[] = 'Non validé';
			}
			$sub_array[] = $image;
			$sub_array[] = $row->STATUT_TRAITEM;
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



	function change_statut($ID_DECLARATION, $STATUT, $idhis)
	{
		// print_r($ID_DECLARATION,$STATUT);
		// exit();
		if ($STATUT == 1) {
			$val = 0;
		}

		if ($STATUT == 0) {
			$val = 1;
		}

		$stat = 4;
		$datas =  array(
			'VALIDATION' => $val,
			'STATUT_TRAITEMENT' => $stat
		);

		$datl = array(
			'ID_SIGNALEMET' => $ID_DECLARATION,
			'USER_ID' => $this->session->userdata('USER_ID'),
			'STATUT_TRAITEMENT' => $stat
		);

		$table = 'histo_validation_ambouteillage';
		$this->Modele->create($table, $datl);

		$this->Modele->update('sign_ambouteillage', array('ID_AMBOUTEILLAGE' => $ID_DECLARATION), $datas);

		$this->sendEmbouteillageMessage($ID_DECLARATION);

		$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du statut est faite avec succès</div>';
		$this->session->set_flashdata($datas);
		redirect(base_url('PSR/Signalement_embouteillage'));
	}

	function ajouter()
	{
		$data['gravites'] = $this->Model->getRequete('SELECT ID_TYPE_GRAVITE, DESCRIPTION FROM type_gravite WHERE 1 ORDER BY DESCRIPTION ASC');
		$data['chausses'] = $this->Model->getRequete('SELECT ID_CHAUSSEE, NOM_CHAUSSE FROM chaussee  WHERE 1 ORDER BY NOM_CHAUSSE ASC');
		$data['users'] = $this->Model->getRequete('SELECT ID_UTILISATEUR,NOM_CITOYEN,PRENOM_CITOYEN FROM utilisateurs WHERE 1  and PROFIL_ID=7 ORDER BY NOM_CITOYEN ASC');


		$data['title'] = 'Nouvelle  Embouteillage';
		$this->load->view('signaler/signaler_embouch_add_v', $data);
	}

	function add()
	{

		$this->form_validation->set_rules('ID_CHAUSSEE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		$this->form_validation->set_rules('CAUSE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$file = $_FILES['IMAGE_1'];
			$path = './uploads/Gestion_Publication_Menu/';
			if (!is_dir(FCPATH . '/uploads/Gestion_Publication_Menu/')) {
				mkdir(FCPATH . '/uploads/Gestion_Publication_Menu/', 0777, TRUE);
			}

			$thepath = base_url() . 'uploads/Gestion_Publication_Menu/';
			$config['upload_path'] = './uploads/Gestion_Publication_Menu/';
			$photonames = date('ymdHisa');
			$config['file_name'] = $photonames;
			$config['allowed_types'] = '*';
			$this->upload->initialize($config);
			$this->upload->do_upload("IMAGE_1");
			$info = $this->upload->data();

			if ($file == '') {
				$pathfile = base_url() . 'uploads/sevtb.png';
			} else {
				$pathfile = base_url() . '/uploads/Gestion_Publication_Menu/' . $photonames . $info['file_ext'];
			}


			$data_insert = array(

				'ID_CHAUSSEE' => $this->input->post('ID_CHAUSSEE'),
				'CAUSE' => $this->input->post('CAUSE'),
				'IMAGE_1' => $pathfile,
				'USER_ID' => $this->session->userdata('USER_ID')
			);

			$table = 'sign_ambouteillage';
			$idSign = $this->Modele->insert_last_id($table, $data_insert);
			//$this->Modele->create($table,$data_insert);
			$datal = array(
				"ID_SIGNALEMET" => $idSign,
				"USER_ID" => $this->session->userdata('USER_ID'),
				"STATUT_TRAITEMENT" => 3,
			);
			$this->Modele->create('histo_validation_ambouteillage', $datal);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Signalement_embouteillage/index'));
		}
	}

	function getOne($id = 0)
	{
		$data['datas'] = $this->Modele->getOne('sign_ambouteillage', array('ID_AMBOUTEILLAGE' => $id));

		$data['chausses'] = $this->Model->getRequete('SELECT ID_CHAUSSEE, NOM_CHAUSSE FROM chaussee  WHERE 1');

		$data['users'] = $this->Model->getRequete('SELECT ID_UTILISATEUR,NOM_CITOYEN,PRENOM_CITOYEN FROM utilisateurs WHERE 1  and PROFIL_ID=7 ORDER BY NOM_CITOYEN ASC');

		$data['title'] = "Modification du siganlement";
		$this->load->view('signaler/signaler_embouch_update_v', $data);
	}



	function update()
	{


		$id = $this->input->post('ID_AMBOUTEILLAGE');


		$dataff = array(
			'ID_CHAUSSEE' => $this->input->post('ID_CHAUSSEE'),
			'CAUSE' => $this->input->post('CAUSE'),
			'USER_ID' => $this->session->userdata('USER_ID'),
		);

		//print_r($id);die();

		$test = $this->Modele->update('sign_ambouteillage', array('ID_AMBOUTEILLAGE' => $id), $dataff);

		$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
		$this->session->set_flashdata($datas);
		redirect(base_url('PSR/Signalement_embouteillage/'));
	}




	function delete()
	{
		$table = "sign_ambouteillage";
		$criteres['ID_AMBOUTEILLAGE'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Signalement_embouteillage'));
	}
}
