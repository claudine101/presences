<?php

/**
 *
 *	 
 **/
class Vol_Controller extends CI_Controller
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
		$data['title'] = 'Registre des véhicules déclarés volés ';
		$this->load->view('Vol_list', $data);
	}

	function getDetaisSign($id_control = 0)
	{

		$dataDetail = "SELECT us.NOM_UTILISATEUR,st.DESCRIPTION,DATE_FORMAT(hvv.DATE_INSERTION, '%d-%m-%Y') AS date  FROM histo_validation_vol hvv LEFT JOIN sign_tampo_pj stp on stp.ID_TAMPO_PJ=hvv.ID_SIGNALEMET LEFT JOIN utilisateurs us on us.ID_UTILISATEUR=hvv.USER_ID LEFT JOIN statut_validation st ON st.ID_STATUT=hvv.STATUT_TRAITEMENT WHERE 1 AND hvv.ID_SIGNALEMET=" . $id_control;


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

		$data_update = $this->Model->getRequeteOne('SELECT pj.DATE_VOLER,pj.MARQUE_VOITURE,tp.COULEUR as COULEUR_VOITURE,obr.NUMERO_PLAQUE,pj.NUMERO_PERMIS,p.NOM_PROPRIETAIRE as NOM_DECLARANT,pj.DESCRIPTION, obr.TELEPHONE  FROM sign_tampo_pj pj LEFT JOIN obr_immatriculations_voitures obr ON pj.ID_OBR=obr.ID_IMMATRICULATION LEFT JOIN type_couleur tp ON pj.ID_COULEUR=tp.ID_TYPE_COULEUR LEFT JOIN chauffeur_permis p on p.NUMERO_PERMIS=pj.NUMERO_PERMIS WHERE ID_TAMPO_PJ=' . $id);



		if (!empty($data_update['NUMERO_PERMIS'])) {

			$data_insert = array(
				'NUMERO_PLAQUE' => $data_update['NUMERO_PLAQUE'],
				'NOM_DECLARANT' => $data_update['NOM_DECLARANT'],
				'PRENOM_DECLARANT' => ".",
				'COULEUR_VOITURE' => $data_update['COULEUR_VOITURE'],
				'MARQUE_VOITURE' => $data_update['MARQUE_VOITURE'],
				'DATE_VOLER' => $data_update['DATE_VOLER'],
			);

			$table = 'pj_declarations';
			$this->Modele->create($table, $data_insert);
			$this->Modele->update('sign_tampo_pj', array('ID_TAMPO_PJ' => $id), $datas);


			$table1 = 'histo_validation_vol';
			$this->Modele->create($table1, $datl);
			$sms = "Mr " . $data_update['NOM_DECLARANT'] . ", on a validé la déclaration du vol de votre voiture plaque " . $data_update['NUMERO_PLAQUE'] . "  ";

			$this->send_sms_smpp($data_update['TELEPHONE'], $sms);


			$this->sendVolMessage($id);

			$data['message'] = '<div class="alert alert-success text-center" id="message">La demande est prise en charge avec succès</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Vol_Controller/'));
		} else {

			$data['message'] = '<div class="alert alert-danger text-center" id="message">le déclarant n\'est pas reconnu comme chauffeur</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Vol_Controller/'));
		}
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
		$table = 'histo_validation_vol';
		$this->Modele->create($table, $data1);
		$this->Modele->update('sign_tampo_pj', array('ID_TAMPO_PJ' => $id), $datas);

		$data['message'] = '<div class="alert alert-success text-center" id="message">La demande est prise en charge avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Vol_Controller/'));
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
		$table = 'histo_validation_vol';
		$this->Modele->create($table, $data1);
		$this->Modele->update('sign_tampo_pj', array('ID_TAMPO_PJ' => $id), $datas);

		$data['message'] = '<div class="alert alert-success text-center" id="message">La demande est prise en charge avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Vol_Controller/'));
	}

	function sendVolMessage($id)
	{

		$police = $this->Model->getRequeteOne('SELECT ID_TAMPO_PJ,pj.NUMERO_SERIE,type_couleur.COULEUR,obr.ID_IMMATRICULATION,obr.NUMERO_PLAQUE,IMAGE_1, IMAGE_2,pj.MARQUE_VOITURE,DATE_VOLER,STATUT,VALIDATION,pj.DATE_INSERTION,us.NOM_UTILISATEUR, pj.NUMERO_PERMIS,c.NOM_PROPRIETAIRE,c.ID_PERMIS, pj.DESCRIPTION ,sv.DESCRIPTION as STATUT_TRAITEM,sv.ID_STATUT as status,hvv.ID_SIGNALEMET,pj.STATUT_TRAITEMENT FROM sign_tampo_pj pj LEFT JOIN utilisateurs us on us.ID_UTILISATEUR=pj.USER_ID LEFT JOIN obr_immatriculations_voitures obr ON obr.ID_IMMATRICULATION=pj.ID_OBR LEFT JOIN type_couleur on type_couleur.ID_TYPE_COULEUR =pj.ID_COULEUR LEFT JOIN chauffeur_permis c ON TRIM(c.NUMERO_PERMIS)=TRIM(pj.NUMERO_PERMIS) LEFT JOIN statut_validation sv on sv.ID_STATUT=pj.STATUT_TRAITEMENT LEFT JOIN histo_validation_vol hvv ON hvv.ID_SIGNALEMET=pj.ID_TAMPO_PJ WHERE 1 AND ID_TAMPO_PJ=' . $id);


		$tokens =  $this->Model->getRequete('SELECT n.TOKEN,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,e.TELEPHONE FROM notification_tokens n JOIN utilisateurs u on n.ID_UTILISATEUR=u.ID_UTILISATEUR JOIN psr_elements e ON e.ID_PSR_ELEMENT=u.PSR_ELEMENT_ID WHERE 1');

		if (!empty($tokens)) {

			$tokns = array();

			$nom = "";

			foreach ($tokens as $key => $value) {

				$tokns[] = $value['TOKEN'];

				$phoneNumber = str_replace(' ', '', $value['TELEPHONE']);

				$nom =  str_replace(' ', '', $value['NOM']) . ' ' . str_replace(' ', '', $value['PRENOM']) . ' (' . str_replace(' ', '', $value['NUMERO_MATRICULE']) . ")";
			}

			$MessageText = " la voiture avec  la plaque " . $police['NUMERO_PLAQUE'] . " de " . $police['NUMERO_PLAQUE'] . " est déclaré voler; Veillew l'arreter quand vous le verra !";

			$titre =  "Signalement de Vol";

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
		$condition1 = "";

		if ($this->session->userdata('PROFIL_ID') == 10) {
			$condition1 = " AND pj.STATUT_TRAITEMENT=3";
		} else if ($this->session->userdata('PROFIL_ID') == 11) {
			$condition1 = " AND pj.STATUT_TRAITEMENT=1";
		}
		$query_principal = 'SELECT ID_TAMPO_PJ,pj.NUMERO_SERIE,type_couleur.COULEUR,obr.ID_IMMATRICULATION,obr.NUMERO_PLAQUE,IMAGE_1, IMAGE_2,pj.MARQUE_VOITURE,DATE_VOLER,STATUT,VALIDATION,pj.DATE_INSERTION,us.NOM_UTILISATEUR, pj.NUMERO_PERMIS,c.NOM_PROPRIETAIRE,c.ID_PERMIS, pj.DESCRIPTION ,sv.DESCRIPTION as STATUT_TRAITEM,sv.ID_STATUT as status,hvv.ID_SIGNALEMET,pj.STATUT_TRAITEMENT FROM sign_tampo_pj pj LEFT JOIN utilisateurs us on us.ID_UTILISATEUR=pj.USER_ID LEFT JOIN obr_immatriculations_voitures obr ON obr.ID_IMMATRICULATION=pj.ID_OBR LEFT JOIN type_couleur on type_couleur.ID_TYPE_COULEUR =pj.ID_COULEUR LEFT JOIN chauffeur_permis c ON TRIM(c.NUMERO_PERMIS)=TRIM(pj.NUMERO_PERMIS) LEFT JOIN statut_validation sv on sv.ID_STATUT=pj.STATUT_TRAITEMENT LEFT JOIN histo_validation_vol hvv ON hvv.ID_SIGNALEMET=pj.ID_TAMPO_PJ WHERE 1 ' . $condition1 . ' GROUP BY ID_TAMPO_PJ ,c.NOM_PROPRIETAIRE,c.ID_PERMIS';



		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';

		$order_column = array('NUMERO_PLAQUE', 'NUMERO_SERIE', 'MARQUE_VOITURE', 'COULEUR', 'DATE_VOLER', 'STATUT', 'NOM_UTILISATEUR', 'IMAGE_1', 'IMAGE_2', 'IMAGE_2','DATE_INSERTION');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NUMERO_PLAQUE ASC';

		$search = !empty($_POST['search']['value']) ? ("AND obr.NUMERO_PLAQUE LIKE '%$var_search%'  OR pj.MARQUE_VOITURE LIKE '%$var_search%'") : '';

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
			if ($row->IMAGE_1 || $row->IMAGE_2) {
				$img = '<span class = "btn btn-success btn-sm " ><i class = "fa fa-eye" ></i></span>';
			} else {
				$img = 'N/A';
			}
			$var = "<span  class='btn btn-md dt-button btn-sm'>Historique</span>";


			$detailSign = '';

			$detailSign .= "<a hre='#' data-toggle='modal'
			data-target='#detail" . $row->ID_TAMPO_PJ . "'>" . $var . "</a>";
			$detailSign .= "
			<div class='modal fade' id='detail" . $row->ID_TAMPO_PJ . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
			<h5 class='modal-title'>Detail de controle</h5>
			<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>";


			if ($row->ID_TAMPO_PJ != Null) {
				$detailSign .= $this->getDetaisSign($row->ID_TAMPO_PJ);
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
			data-target='#mydelete" . $row->ID_TAMPO_PJ . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Vol_Controller/getOne/' . $row->ID_TAMPO_PJ) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			if ($this->session->userdata('PROFIL_ID') == 10) {
				$option .= "<li><a href='#' data-toggle='modal'
				data-target='#stat1" . $row->ID_TAMPO_PJ . "'><label class='text-primary'>&nbsp;&nbsp;Superviseur</label></a></li>";
			} else {
				$option .= "";
			}
			if ($this->session->userdata('PROFIL_ID') == 11) {
				$option .= "<li><a href='#' data-toggle='modal'
				data-target='#stat2" . $row->ID_TAMPO_PJ . "'><label class='text-secondary'>&nbsp;&nbsp;OPJ</label></a></li>";
			} else {
				$option .= "";
			}


			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" . $row->ID_TAMPO_PJ . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer la plaque ?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->NUMERO_PLAQUE . " du " . $row->DATE_INSERTION . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Vol_Controller/delete/' . $row->ID_TAMPO_PJ) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$option .= " 
			<div class='modal fade' id='stat1" .  $row->ID_TAMPO_PJ . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center>
			<p> Voulez-vous confirmer le vol?<br></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-primary btn-md' href='" . base_url('PSR/Vol_Controller/validation_Premier/' . $row->ID_TAMPO_PJ . '/' . $row->status) . "'>Valider</a>
			<button class='btn btn-danger btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$option .= " 
			<div class='modal fade' id='stat2" .  $row->ID_TAMPO_PJ . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center>
			<p> Voulez-vous accorder la suite à cette demande?<br></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-primary btn-md' href='" . base_url('PSR/Vol_Controller/validation_final/' . $row->ID_TAMPO_PJ . '/' . $row->status) . "'>Valider</a>
			<button class='btn btn-danger btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$image = "<a hre='#' data-toggle='modal'
			data-target='#image" . $row->ID_TAMPO_PJ . "'>" . $img . "</a>";
			$image .= "
			<div class='modal fade' id='image" . $row->ID_TAMPO_PJ . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center>
			<p><b>Photos du véhicule</b></center></p>";

			if (!empty($row->IMAGE_1)) {
				$image .= "<img style='width:50%' src='" . $row->IMAGE_1 . "'>";
			}


			if (!empty($row->IMAGE_2)) {
				$image .= "<img style='width:50%' src='" . $row->IMAGE_2 . "'>";
			}




			$image .= "</div>

			<div class='modal-footer'>
			
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			// $sub_array[] = $row->DATE_INSERTION;
			$name = '<table> <tbody><tr><td><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="https://app.mediabox.bi/wasiliEate/uploads/personne.png"></td><td>' . $row->NOM_PROPRIETAIRE . ' </td></tr></tbody></table>';
			$sub_array[] = !empty($row->NOM_PROPRIETAIRE) ? $name : 'N/A';

			$sub_array[] = "<a title='".$row->NUMERO_PERMIS."' onclick='show_permis(this.title)' class='btn btn-md dt-button btn-sm' href='#'>" .$row->NUMERO_PERMIS. "</a>";

			if ($row->ID_IMMATRICULATION != null) {
				$sub_array[] = "<a title='".$row->NUMERO_PLAQUE."' onclick='show_vehicule(this.title)' class='btn btn-md dt-button btn-sm' href='#'>" .$row->NUMERO_PLAQUE. "</a>";
			} else {
				$sub_array[] = "<span style='color :red'>" . $row->NUMERO_PLAQUE . "</span>";
			}


			$sub_array[] = $row->NUMERO_SERIE;
			$sub_array[] = $row->MARQUE_VOITURE . '(' . $row->COULEUR . ')';
			$sub_array[] = $row->DATE_VOLER;
			$validation  = "<a hre='#' data-toggle='modal'
			data-target='#validations" . $row->ID_TAMPO_PJ . "'><font color='black'>&nbsp;&nbsp;No Validé</font></a>";
			$stat = "<a hre='#' data-toggle='modal'
			data-target='#change" . $row->ID_TAMPO_PJ . "'><font color='black'>&nbsp;&nbsp;Non Trouvé</font></a>";

			$valid = ($row->VALIDATION == 0) ? $validation : "<b style='color:green'>Validé</b>";

			$st = ($row->STATUT == 0) ? $stat : "<b style='color:green'>Trouvé</b>";

			$option .= "
			<div class='modal fade' id='validations" . $row->ID_TAMPO_PJ . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5 style='color:black'>Voulez-vous prendre en charge cette demande de <br> " . $row->NOM_UTILISATEUR . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-success btn-md' href='" . base_url('PSR/Vol_Controller/validations/' . $row->ID_TAMPO_PJ . '/' . $row->status) . "'>valider</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$option .= "
			<div class='modal fade' id='change" . $row->ID_TAMPO_PJ . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5 style='color:black'>Avez-vous Trouvée le véhicule  immatriculé<br> " . $row->NUMERO_PLAQUE . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-success btn-md' href='" . base_url('PSR/Vol_Controller/Change/' . $row->ID_TAMPO_PJ) . "'>Oui</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Non</button>
			</div>

			</div>
			</div>
			</div>";


			$sub_array[] = date("d-m-Y", strtotime($row->DATE_INSERTION));;
			if ($this->session->userdata('PROFIL_ID') == 1) {
				$sub_array[] = $valid . '<br>' . $detailSign;
			} else {
				$sub_array[] = 'N/A';
			}

			$sub_array[] = $st;
			$sub_array[] = $row->STATUT_TRAITEM;
			$sub_array[] = $image;
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
		$data['plaques'] = $this->Model->getRequete('SELECT ID_IMMATRICULATION, NUMERO_PLAQUE FROM obr_immatriculations_voitures WHERE 1 ORDER BY NUMERO_PLAQUE ASC');
		$data['couleur'] = $this->Model->getRequete('SELECT ID_TYPE_COULEUR ,COULEUR FROM type_couleur WHERE 1');
		$data['title'] = 'Nouvelle Déclaration';
		$this->load->view('Vol_Add_View', $data);
	}


	function getPermis($permis = 0)
	{

		$donne = $this->Model->getOne('chauffeur_permis', array('NUMERO_PERMIS' => trim($permis)));
		if (!empty($donne)) {
			return 1;
		} else {
			return 0;
		}
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
     //POUR  INSERER DANS LA BASE DE DONNE
	function add()
	{


		if ($this->getPermis($this->input->post('NUMERO_PERMIS')) == 1) {

			$file = $_FILES['PHOTO'];
			$path = './uploads/pjVoles/';
			if (!is_dir(FCPATH . '/uploads/pjVoles/')) {
				mkdir(FCPATH . '/uploads/pjVoles/', 0777, TRUE);
			}

			$thepath = base_url() . 'uploads/pjVoles/';
			$config['upload_path'] = './uploads/pjVoles/';
			$photonames = date('ymdHisa');
			$config['file_name'] = $photonames;
			$config['allowed_types'] = '*';
			$this->upload->initialize($config);
			$this->upload->do_upload("PHOTO");
			$info = $this->upload->data();

			if ($file == '') {
				$pathfile = base_url() . 'uploads/sevtb.png';
			} else {
				$pathfile = base_url() . '/uploads/pjVoles/' . $photonames . $info['file_ext'];
			}

			$data_insert = array(

				'NUMERO_SERIE' => $this->input->post('NUMERO_SERIE'),
				'ID_OBR' => $this->input->post('ID_IMMATRICULATION'),
				'ID_COULEUR' => $this->input->post('ID_TYPE_COULEUR'),
				'MARQUE_VOITURE' => $this->input->post('MARQUE_VOITURE'),
				'DATE_VOLER' => $this->input->post('DATE_VOLER'),
				'NUMERO_PERMIS' => $this->input->post('NUMERO_PERMIS'),
				'DESCRIPTION' => $this->input->post('DESCRIPTION'),
				'LATITUDE' => '1',
				'LONGITUDE' => '1',
				'IMAGE_1' => $pathfile
			);

			$table = 'sign_tampo_pj';
			$idSign = $this->Modele->insert_last_id($table, $data_insert);
			//$this->Modele->create($table, $data_insert);

			$datal = array(
				"ID_SIGNALEMET" => $idSign,
				"USER_ID" => $this->session->userdata('USER_ID'),
				"STATUT_TRAITEMENT" => 0,
			);
			$this->Modele->create('histo_validation_vol', $datal);
			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Vol_Controller/'));
		} else {

			$data['message'] = '<div class="alert alert-danger text-center" id="message">Le déclarant n\'est pas reconnu par PSR</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Vol_Controller/ajouter'));
		}
	}




	function getOne($id)

	{

		$data['couleur'] = $this->Model->getRequete('SELECT ID_TYPE_COULEUR ,COULEUR FROM type_couleur WHERE 1');

		$data['data'] = $this->Modele->getOne('sign_tampo_pj', array('ID_TAMPO_PJ' => $id));


		$data['title'] = "Modification d'une Déclaration";
		$this->load->view('Vol_Modif_View', $data);
	}

	function change($id = 0)
	{

		$data =  array('STATUT' => 1);
		$this->Modele->update('sign_tampo_pj', array('ID_TAMPO_PJ' => $id), $data);
		$data['message'] = '<div class="alert alert-success text-center" id="message">le statut de déclaration est modifié avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Vol_Controller/'));
	}


	function update()
	{

		$this->form_validation->set_rules('NUMERO_SERIE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('MARQUE_VOITURE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		$this->form_validation->set_rules('DATE_VOLER', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		$id = $this->input->post('ID_TAMPO_PJ');

		if ($this->form_validation->run() == FALSE) {
			//$id=$this->input->post('ID_GERANT');

			$this->getOne($id);
		} else {



			$data = array(
				'ID_TAMPO_PJ' => $this->input->post('ID_TAMPO_PJ'),
				'NUMERO_SERIE' => $this->input->post('NUMERO_SERIE'),
				'MARQUE_VOITURE' => $this->input->post('MARQUE_VOITURE'),
				'ID_COULEUR' => $this->input->post('ID_TYPE_COULEUR'),
				'DATE_VOLER' => $this->input->post('DATE_VOLER'),

			);


			$this->Modele->update('sign_tampo_pj', array('ID_TAMPO_PJ' => $id), $data);


			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification  est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('PSR/Vol_Controller/'));
		}
	}


	function delete()
	{
		$table = "sign_tampo_pj";
		$criteres['ID_TAMPO_PJ'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">La voiture est supprimée avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Vol_Controller/'));
	}
}
