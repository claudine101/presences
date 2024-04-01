<?php

/**
 *
 *	Element de la police 
 **/
class Chefs_menage extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}


	public function have_droit()
	{
		if ($this->session->userdata('GESTION_CHEF_MENAGE') != 1) {

			redirect(base_url());
		}
	}
	function index()
	{
		$data['title'] = 'Autorité  des ménages';
		$data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');

		$this->load->view('Manage_List_view', $data);
	}

	function listing()
	{
	    $ID_PROVINCE = $this->input->post('ID_PROVINCE');
	    $ID_COMMUNE = $this->input->post('ID_COMMUNE');
	    $ID_ZONE = $this->input->post('ID_ZONE');
	    $ID_COLLINE = $this->input->post('ID_COLLINE');

	    $critere_profil = "";
	    $critere_province = "";
	    $critere_commune = "";
	    $critere_zone = "";
	    $critere_colline = "";
        $critere_province = !empty($ID_PROVINCE) ? "  AND sp.PROVINCE_ID=".$ID_PROVINCE." ":"";
        $critere_commune = !empty($ID_COMMUNE) ? "  AND sc.COMMUNE_ID=".$ID_COMMUNE." ":"";
        $critere_zone = !empty($ID_ZONE) ? "  AND sz.ZONE_ID=".$ID_ZONE." ":"";
        $critere_colline = !empty($ID_COLLINE) ? "  AND sco.COLLINE_ID=".$ID_COLLINE." ":"";
		$i = 1;
		$query_principal = 'SELECT  mf.ID_CHEF,IF(mf.SEXE = "H","mr","md") as SEXE,mf.DATE_INSERT,mf.DATE_NAISSANCE,mf.NOM, PRENOM, mf.NUMERO_MATRICULE,sp.PROVINCE_NAME AS province, sc.COMMUNE_NAME AS commune ,sz.ZONE_NAME AS zone, sco.COLLINE_NAME AS Colline, mf.TELEPHONE, mf.EMAIL,mf.PHOTO,  mf.IS_ACTIF FROM  menage_chefs  mf  LEFT JOIN syst_provinces sp ON mf.PROVINCE_ID=sp.PROVINCE_ID LEFT JOIN syst_communes sc ON sc.COMMUNE_ID=mf.COMMUNE_ID LEFT JOIN syst_zones sz on sz.ZONE_ID=mf.ZONE_ID LEFT JOIN syst_collines sco ON sco.COLLINE_ID=mf.COLLINE_ID WHERE 1 '.$critere_province.' '.$critere_commune.' '.$critere_zone.' '.$critere_colline.' '.$critere_profil ;
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
 $var_search=str_replace("'", "\'", $var_search);
		

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';


		$order_column = array('NOM', 'PRENOM', 'NUMERO_MATRICULE', 'province', 'commune', 'zone', 'Colline', 'TELEPHONE','DATE_INSERT' );

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM,PRENOM ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM LIKE '%$var_search%' OR PRENOM LIKE '%$var_search%' OR NUMERO_MATRICULE LIKE '%$var_search%'  ") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_psr = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_psr as $row) {

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#'  id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='supprimer(".$row->ID_CHEF.",this.title,this.id)'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('menage/Chefs_menage/getOne/' . $row->ID_CHEF) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			// $option .= "<li><a class='btn-md' href='" . base_url('menage/Chefs_menage_affectation/ajouter/' . $row->ID_CHEF) . "'><label class='text-info'>&nbsp;&nbsp;Affecter</label></a></li>";
			$option .= " </ul></div>";
			$source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			$sub_array = array();
			$sub_array[] = '<table> <tbody><tr><td><a title="' . $source . '" href="#" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM . '</td></tr></tbody></table></a>';
			$sub_array[] =  $this->notifications->ago($row->DATE_NAISSANCE, date('Y-m-d'));
			$sub_array[] = $row->NUMERO_MATRICULE;
			$sub_array[] = $row->province;
			$sub_array[] = $row->commune;
			$sub_array[] = $row->zone;
			$sub_array[] = $row->Colline;
			$sub_array[] = $row->TELEPHONE . "<br>" . $row->EMAIL;
			$sub_array[] = $row->DATE_INSERT;
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

	function ajouter()
	{
		$data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
		$data['profils'] = $this->Model->getRequete('SELECT PROFIL_ID, STATUT FROM profil WHERE CODE_PROFIL=20 OR  CODE_PROFIL=21  OR  CODE_PROFIL=22 OR CODE_PROFIL=23   ORDER BY STATUT ASC');
		$data['grade'] = $this->Model->getRequete('SELECT `ID_GRADE`,`GRADE` FROM `psr_grade` WHERE 1 ORDER BY `GRADE`');

		$data['title'] = 'Autorite  des menages';
		$this->load->view('Menage_add_view', $data);
	}

	function get_communes($ID_PROVINCE = 0)
	{
		$communes = $this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID=' . $ID_PROVINCE . ' ORDER BY COMMUNE_NAME ASC');
		$html = '<option value="">---selectionner---</option>';
		foreach ($communes as $key) {
			$html .= '<option value="' . $key['COMMUNE_ID'] . '">' . $key['COMMUNE_NAME'] . '</option>';
		}
		echo json_encode($html);
	}

	function get_zones($ID_COMMUNE = 0)
	{
		$zones = $this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID=' . $ID_COMMUNE . ' ORDER BY ZONE_NAME ASC');
		$html = '<option value="">---selectionner---</option>';
		foreach ($zones as $key) {
			$html .= '<option value="' . $key['ZONE_ID'] . '">' . $key['ZONE_NAME'] . '</option>';
		}
		echo json_encode($html);
	}

	function get_collines($ID_ZONE = 0)
	{
		$collines = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID=' . $ID_ZONE . ' ORDER BY COLLINE_NAME ASC');
		$html = '<option value="">---selectionner---</option>';
		foreach ($collines as $key) {
			$html .= '<option value="' . $key['COLLINE_ID'] . '">' . $key['COLLINE_NAME'] . '</option>';
		}
		echo json_encode($html);
	}



	function add()
	{
		$this->form_validation->set_rules('NOM', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PRENOM', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NUMERO_MATRICULE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('TELEPHONE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('EMAIL', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		// $this->form_validation->set_rules('PROFIL_ID', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('DATE_NAISSANCE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {


			$file = $_FILES['PHOTO'];
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
			$this->upload->do_upload("PHOTO");
			$info = $this->upload->data();

			if ($file == '') {
				$pathfile = base_url() . 'uploads/sevtb.png';
			} else {
				$pathfile = base_url() . '/uploads/Gestion_Publication_Menu/' . $photonames . $info['file_ext'];
			}


			$camerasImage = $this->input->post('ImageLink');

			if (!empty($camerasImage)) {

				$dir = FCPATH.'/uploads/cameraImagePsr/';
			      if (!is_dir(FCPATH . '/uploads/cameraImagePsr/')) {
				  mkdir(FCPATH . '/uploads/cameraImagePsr/', 0777, TRUE);
			    }

                $photonames = date('ymdHisa');
                $pathfile = base_url() . 'uploads/cameraImagePsr/' . $photonames .".png";
			    $pathfiless = FCPATH . '/uploads/cameraImagePsr/' . $photonames .".png";
			    $file_name = $photonames .".png";

			    $img = $this->input->post('ImageLink'); // Your data 'data:image/png;base64,AAAFBfj42Pj4';
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                file_put_contents($pathfiless, $data);

				//echo "<img src='".$path."' >";
				
			}
			$nom = $this->input->post('NOM');
			$prenom = $this->input->post('PRENOM');
			$matricule = $this->input->post('NUMERO_MATRICULE');
			$telephone = $this->input->post('TELEPHONE');
			$email = $this->input->post('EMAIL');
			$profil = $this->input->post('PROFIL_ID');

			$data_insert = array(

				'NOM' => $nom,
				'PRENOM' => $prenom,
				'NUMERO_MATRICULE' => $matricule,
				'PROVINCE_ID' => $this->input->post('ID_PROVINCE'),
				'COMMUNE_ID' => $this->input->post('ID_COMMUNE'),
				'ZONE_ID' => $this->input->post('ID_ZONE'),
				'COLLINE_ID' => $this->input->post('ID_COLLINE'),
				'TELEPHONE' => $telephone,
				'EMAIL' => $email,
				'DATE_NAISSANCE' => $this->input->post('DATE_NAISSANCE'),
				// 'ID_GRADE' => $this->input->post('ID_GRADE'),
				'SEXE' => $this->input->post('SEXE'),
				'PHOTO' => $pathfile
			);
			 // print_r($data_insert); die();
			$table = 'menage_chefs';
			$idPolice = $this->Modele->insert_last_id($table, $data_insert);
			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('menage/Chefs_menage/'));
		}
	}
	function affectation($id = 0)
	{
		$data['title'] = 'Affectation de l\'Autorite  des menages';
		$data['element_affect']=$id;
		$data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
		$data['profils'] = $this->Model->getRequete('SELECT PROFIL_ID, STATUT FROM profil WHERE CODE_PROFIL=20 OR  CODE_PROFIL=21  OR  CODE_PROFIL=22 OR CODE_PROFIL=23   ORDER BY STATUT ASC');
		$data['grade'] = $this->Model->getRequete('SELECT `ID_GRADE`,`GRADE` FROM `psr_grade` WHERE 1 ORDER BY `GRADE`');
		$this->load->view('Menage_affectation_view', $data);
	}
	function getOne($id = 0)
	{
		$membre = $this->Modele->getRequeteOne('SELECT * FROM menage_chefs WHERE  ID_CHEF=' . $id);

		$data['profils'] = $this->Model->getRequete('SELECT PROFIL_ID, STATUT FROM profil WHERE CODE_PROFIL=20 OR  CODE_PROFIL=21  OR  CODE_PROFIL=22 OR CODE_PROFIL=23  ORDER BY STATUT ASC');

		$data['user'] = $this->Model->getRequeteOne('SELECT `PROFIL_ID` FROM `utilisateurs` WHERE `PSR_ELEMENT_ID`='.$id);

		$data['membre'] = $membre;
		$data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
		$data['communes'] = $this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID=' . $membre['PROVINCE_ID'] . ' ORDER BY COMMUNE_NAME ASC');
		$data['zones'] = $this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID=' . $membre['COMMUNE_ID'] . ' ORDER BY ZONE_NAME ASC');
		$data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID=' . $membre['ZONE_ID'] . ' ORDER BY COLLINE_NAME ASC');

		$data['title'] = "Modification";
		$this->load->view('Menange_update_view', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('NOM', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PRENOM', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NUMERO_MATRICULE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('TELEPHONE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('EMAIL', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		$id = $this->input->post('ID_CHEF');

		if ($this->form_validation->run() == FALSE) {
			//$id=$this->input->post('ID_GERANT');

			$this->getOne();
		} else {

			$file = $_FILES['PHOTO'];
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
			$this->upload->do_upload("PHOTO");
			$info = $this->upload->data();

			if ($file == '') {
				$pathfile = base_url() . 'uploads/sevtb.png';
			} else {
				$pathfile = base_url() . '/uploads/Gestion_Publication_Menu/' . $photonames . $info['file_ext'];
			}
			$id = $this->input->post('ID_CHEF');
			$telephone = $this->input->post('TELEPHONE');
			$email = $this->input->post('EMAIL');
			$profil = $this->input->post('PROFIL_ID');
            if (!empty($_FILES['PHOTO']['name'])) {
           
			$data = array(
				'NOM' => $this->input->post('NOM'),
				'PRENOM' => $this->input->post('PRENOM'),
				'NUMERO_MATRICULE' => $this->input->post('NUMERO_MATRICULE'),
				'PROVINCE_ID' => $this->input->post('ID_PROVINCE'),
				'COMMUNE_ID' => $this->input->post('ID_COMMUNE'),
				'ZONE_ID' => $this->input->post('ID_ZONE'),
				'COLLINE_ID' => $this->input->post('ID_COLLINE'),
				'TELEPHONE' => $this->input->post('TELEPHONE'),
				// 'ID_GRADE' => $this->input->post('ID_GRADE'),
				'SEXE' => $this->input->post('SEXE'),
				'EMAIL' => $email,
				'PHOTO' => $pathfile
			);

            }else{

			$data = array(
				'NOM' => $this->input->post('NOM'),
				'PRENOM' => $this->input->post('PRENOM'),
				'NUMERO_MATRICULE' => $this->input->post('NUMERO_MATRICULE'),
				'PROVINCE_ID' => $this->input->post('ID_PROVINCE'),
				'COMMUNE_ID' => $this->input->post('ID_COMMUNE'),
				'ZONE_ID' => $this->input->post('ID_ZONE'),
				'COLLINE_ID' => $this->input->post('ID_COLLINE'),
				'TELEPHONE' => $this->input->post('TELEPHONE'),
				// 'ID_GRADE' => $this->input->post('ID_GRADE'),
				'SEXE' => $this->input->post('SEXE'),
				'EMAIL' => $email
				// 'PHOTO' => $pathfile
            );
      
            }


			$data_User = array(
				'NOM_UTILISATEUR' => $email,
				'MOT_DE_PASSE' => md5($telephone),
				'PROFIL_ID' => $profil,
				'PSR_ELEMENT_ID' => $id,
			);
			$this->Modele->update('menage_chefs', array('ID_CHEF' => $id), $data);
			$this->Modele->updateData('utilisateurs', $data_User, array('PSR_ELEMENT_ID' => $id));

			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('menage/Chefs_menage/'));
		}
	}

	function delete()
	{
		$table = "menage_chefs";
		$criteres['ID_CHEF'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
        print_r(json_encode(1));
	}

	function get_avenues($COLLINE_ID = 0,$ID_AVENUE=0)
	{
		$avenues = $this->Model->getRequete('SELECT AVENUE_ID,AVENUE_NAME FROM syst_avenue WHERE 	COLLINE_ID=' . $COLLINE_ID . ' ORDER BY AVENUE_NAME ASC');
		$html = '<option value="">---selectionner---</option>
		 <option value="0">Autre</option>';
		foreach ($avenues as $key) {
			if($ID_AVENUE==$key['AVENUE_ID']){
			$html .= '<option selected value="' . $key['AVENUE_ID'] . '">' . $key['AVENUE_NAME'] . '</option>';
			}
			else{
			$html .= '<option value="' . $key['AVENUE_ID'] . '">' . $key['AVENUE_NAME'] . '</option>';
			}
		}
		echo json_encode($html);
	}
function save_avenue()
	{

		 $data_avenue = array(
          'AVENUE_NAME'=>$this->input->post('AVENUE_NAME'),
          'COLLINE_ID'=>$this->input->post('ID_COLLINE'),
          );
         $table = 'syst_avenue';
         $id = $this->Modele->insert_last_id($table, $data_avenue);
         echo json_encode(array('id'=>$id));
	}


}
