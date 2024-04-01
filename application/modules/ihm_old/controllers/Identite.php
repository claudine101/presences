<?php
class Identite extends CI_Controller
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

		$data['title'] = 'Listes des identités';
		$this->load->view('Identite_List_V', $data);
	}




	function listing()
	{

		$query_principal = 'SELECT `ID_IDENTITE`,f.CommonName as NATIONALITE,co.DESCRP_REPONSE, concat(`NOM`,"" "" ,`PRENOM`) as NOM,IF(SEXE=1,"Homme","Femme") as SEXE, `CNI`, `TELEPHONE`, `DATE_NAISSANCE`, `PHOTO`, `DATE_INSERT` FROM autres_contr_rep_identite id JOIN autres_controles co ON id.ID_AUTRES_CONTROLES=co.ID_AUTRES_CONTROLES JOIN countries f on f.COUNTRY_ID=id.NATIONNALITE_ID WHERE 1';

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);

		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';


		$order_column = array('ID_IDENTITE', 'DESCRP_REPONSE', 'NATIONALITE', 'NOM', 'SEXE', 'CNI', 'TELEPHONE', 'DATE_NAISSANCE', 'PHOTO');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM LIKE '%$var_search%'") : '';


		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_peine = $this->Modele->datatable($query_secondaire);
		$data = array();


		//print_r($fetch_peine);die();


		foreach ($fetch_peine as $row) {
			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_IDENTITE . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";

			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Identite/getOne/' . $row->ID_IDENTITE) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";


			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" . $row->ID_IDENTITE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>


			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->DESCRP_REPONSE . " " . $row->NATIONALITE . " " . $row->NOM . " " . $row->SEXE . " " . $row->CNI . " " . $row->TELEPHONE . " " . $row->DATE_NAISSANCE . " " . $row->PHOTO . "</i></b></h5></center>
			</div>

		  <div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Identite/delete/' . $row->ID_IDENTITE) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>


           </div>
			</div>
			</div>";

			$sub_array = array();
			//$sub_array[]=$row->ID_IDENTITE;

			$img = '<img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="https://app.mediabox.bi/wasiliEate/uploads/personne.png">';

			if (!empty($row->PHOTO)) {
				$img = '<img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $row->PHOTO . '">';
			}
			$sub_array[] = $img;
			$sub_array[] = $this->notifications->ago($row->DATE_NAISSANCE, date('Y-m-d'));
			$sub_array[] = $row->DESCRP_REPONSE ? $row->DESCRP_REPONSE : 'N/A';
			$sub_array[] = $row->NATIONALITE;
			$sub_array[] = $row->NOM;
			$sub_array[] = $row->SEXE;
			$sub_array[] = $row->CNI;
			$sub_array[] = $row->TELEPHONE;


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



	public function upload_file1($input_name)
	{
		$nom_file = $_FILES[$input_name]['tmp_name'];
		$nom_champ = $_FILES[$input_name]['name'];

		print_r($nom_champ);
		die();
		$repertoire_fichier = FCPATH . 'uploads/dossiers_photo';
		$code = uniqid();
		$fichier = basename($code . '_' . $nom_champ);

		if (!is_dir($repertoire_fichier)) {
			mkdir($repertoire_fichier, 0777, TRUE);
		}
		move_uploaded_file($nom_file, $repertoire_fichier . $fichier);
		return base_url() . 'uploads/dossiers_photo' . $code . '_' . $nom_champ;
	}



	function getOne()
	{

		$id = $this->uri->segment(4);

		$data['datas'] = $this->Modele->getOne('autres_contr_rep_identite', array('ID_IDENTITE' => $id));

		$data['title'] = "MODIFICATION";

		$data['controle'] = $this->Modele->getRequete('SELECT `ID_AUTRES_CONTROLES`, `DESCRP_REPONSE` FROM `autres_controles` WHERE 1');

		// print_r($data['controle']);die();

		$data['nationalite'] = $this->Modele->getRequete('SELECT `COUNTRY_ID`,`CommonName` FROM `countries` WHERE 1');

		$this->load->view('Identite_update_V', $data);
	}

	function update()
	{

		$this->form_validation->set_rules('ID_AUTRES_CONTROLES', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NOM', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NATIONNALITE_ID', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('SEXE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('CNI', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('TELEPHONE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		//$this->form_validation->set_rules('PHOTO_NOUVEAU','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));



		$id = $this->input->post('ID_IDENTITE');

		if ($this->form_validation->run() == FALSE) {


			// $this->getOne();
			$id = $this->input->post('ID_IDENTITE');

			$data['datas'] = $this->Modele->getOne('autres_contr_rep_identite', array('ID_IDENTITE' => $id));

			$data['title'] = "MODIFICATION";

			$data['controle'] = $this->Modele->getRequete('SELECT `ID_AUTRES_CONTROLES`, `DESCRP_REPONSE` FROM `autres_controles` WHERE 1');

			// print_r($data['controle']);die();

			$data['nationalite'] = $this->Modele->getRequete('SELECT `COUNTRY_ID`,`CommonName` FROM `countries` WHERE 1');

			$this->load->view('Identite_update_V', $data);
		} else {

			//    $picture_nouveau=$this->upload_file1('PHOTO_NOUVEAU');
			// $picture_ancien=$this->input->post('PHOTO_ANCIEN');

			if (!empty($_FILES['PHOTO_NOUVEAU'])) {

				//print_r($_FILES['PHOTO_NOUVEAU']);
				// $photo=$this->upload_file1($this->input->post('PHOTO_NOUVEAU'));
				$file = $_FILES['PHOTO_NOUVEAU'];
				$path = './uploads/dossiers_photo/';
				if (!is_dir(FCPATH . '/uploads/dossiers_photo/')) {
					mkdir(FCPATH . '/uploads/dossiers_photo/', 0777, TRUE);
				}
				$thepath = base_url() . 'uploads/dossiers_photo/';
				$config['upload_path'] = './uploads/dossiers_photo/';
				$photonames = date('ymdHisa');
				$config['file_name'] = $photonames;
				$config['allowed_types'] = '*';
				$this->upload->initialize($config);
				$this->upload->do_upload("PHOTO_NOUVEAU");
				$info = $this->upload->data();

				if ($file == '') {
					$photo = base_url() . 'uploads/sevtb.png';
				} else {
					$photo = base_url() . '/uploads/dossiers_photo/' . $photonames . $info['file_ext'];
				}
			} else {
				$photo = '';
			}

			$id = $this->input->post('ID_IDENTITE');

			$data = array(
				'ID_AUTRES_CONTROLES' => $this->input->post('ID_AUTRES_CONTROLES'),
				'NOM' => $this->input->post('NOM'),
				'NATIONNALITE_ID' => $this->input->post('NATIONNALITE_ID'),
				'SEXE' => $this->input->post('SEXE'),
				'CNI' => $this->input->post('CNI'),
				'TELEPHONE' => $this->input->post('TELEPHONE'),
				'PHOTO' => $photo
			);

			$this->Modele->update('autres_contr_rep_identite', array('ID_IDENTITE' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Identite/index'));
		}
	}


	function delete()
	{
		$table = "autres_contr_rep_identite";
		$criteres['ID_IDENTITE'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">Element supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Identite'));
	}
}
