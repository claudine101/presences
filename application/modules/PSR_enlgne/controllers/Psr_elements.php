<?php

/**
 *
 *	Element de la police 
 **/
class Psr_elements extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}
    public function have_droit()
	{
		if ($this->session->userdata('RH_FONCTIONNAIRE') != 1) {

			redirect(base_url());
		}
	}
	function index()
	{
		$data['title'] = 'Fonctionnaire de la police';
		$this->load->view('psr_list_view', $data);
	}

	function listing()
	{

		$i = 1;
		$query_principal = 'SELECT IF(psr.SEXE = "H","mr","md") as SEXE,psr.DATE_INSERT,psr_grade.GRADE,DATE_NAISSANCE,ID_PSR_ELEMENT, NOM, PRENOM, NUMERO_MATRICULE,sp.PROVINCE_NAME AS province, sc.COMMUNE_NAME AS commune ,sz.ZONE_NAME AS zone, sco.COLLINE_NAME AS Colline, TELEPHONE, EMAIL,PHOTO, psr.LATITUDE, psr.LONGITUDE, psr.IS_ACTIF, us.IS_ACTIF AS ACTIF, us.ID_UTILISATEUR, psr.ID_GRADE, p.STATUT FROM psr_elements psr LEFT JOIN syst_provinces sp ON psr.PROVINCE_ID=sp.PROVINCE_ID LEFT JOIN syst_communes sc ON sc.COMMUNE_ID=psr.COMMUNE_ID LEFT JOIN syst_zones sz on sz.ZONE_ID=psr.ZONE_ID LEFT JOIN syst_collines sco ON sco.COLLINE_ID=psr.COLLINE_ID LEFT JOIN utilisateurs us on us.PSR_ELEMENT_ID=psr.ID_PSR_ELEMENT LEFT JOIN profil p ON p.PROFIL_ID = us.PROFIL_ID LEFT JOIN psr_grade ON psr.ID_GRADE=psr_grade.ID_GRADE WHERE 1  ';

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);


		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';


		$order_column = array('NOM', 'PRENOM', 'NUMERO_MATRICULE', 'GRADE', 'province', 'commune', 'zone', 'Colline', 'TELEPHONE', 'STATUT', 'ACTIF');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM,PRENOM ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM LIKE '%$var_search%' OR PRENOM LIKE '%$var_search%' OR NUMERO_MATRICULE LIKE '%$var_search%'  ") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_psr = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_psr as $row) {

			$labelle ="";
		    $color = '';
		    $btn = '';

		    if($row->ACTIF== 1)
		    {   $labelle='Désactiver';
		        $color = 'red';
		        $btn = 'btn-danger';
		    }else {
		        $labelle='Activer';
		        $color = 'green';
		        $btn = 'btn-success';
		    }

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_PSR_ELEMENT . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Psr_elements/getOne/' . $row->ID_PSR_ELEMENT) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Performance_Police/index/' . $row->ID_PSR_ELEMENT) . "'><label class='text-info'>&nbsp;&nbsp;Performance</label></a></li>";
			$row->ACTIF==0 ?
			$option .= "<li><hre='#'  id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='activer(".$row->ID_UTILISATEUR.",this.title,this.id)'><font color='".$color."'>&nbsp;&nbsp;".$labelle."</font></a></li>":$option .= "<li><hre='#'  id='".$row->PRENOM."'  title='".$row->NOM."'  onclick='desactiver(".$row->ID_UTILISATEUR.",this.title,this.id)'><font color='".$color."'>&nbsp;&nbsp;".$labelle."</font></a></li>";

			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_PSR_ELEMENT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->SEXE . "," . $row->NOM . " " . $row->PRENOM . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Psr_elements/delete/' . $row->ID_PSR_ELEMENT) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>

			<div class='modal fade' id='mystatut" .  $row->ID_UTILISATEUR . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous ".$labelle."?</strong> <br><b style='background-color:prink;color:green;'><i>" .$row->NOM." ".$row->PRENOM."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn ".$btn." btn-md' href='" . base_url('PSR/Psr_elements/getstatut/'.$row->ID_UTILISATEUR) . "'>Oui</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Non</button>
			</div>

			</div>
			</div>
			</div>";
			$source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			$sub_array = array();
			$sub_array[] = '<table> <tbody><tr><td><a title="' . $source . '" href="#" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM . '</td></tr></tbody></table></a>';
			$sub_array[] =  $this->notifications->ago($row->DATE_NAISSANCE, date('Y-m-d'));
			$sub_array[] = $row->NUMERO_MATRICULE;
			$sub_array[] = $row->GRADE;
			$sub_array[] = $row->province;
			$sub_array[] = $row->commune;
			$sub_array[] = $row->zone;
			$sub_array[] = $row->Colline;

			$sub_array[] = $row->TELEPHONE . "<br>" . $row->EMAIL;
			$sub_array[] = $row->STATUT;
			if ($row->ACTIF==1) {
				$sub_array[]='<center><div class=" btn-sm"><i title="Activer" class="fa fa-check" aria-hidden="true"></i></div></center>';
			} else {
				$sub_array[]='<center><div class=" btn-sm"><i title="Désactiver" class="fa fa-times" aria-hidden="true"></i></div></center>';

			}
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

	function getstatut($id)
	{
	    $get=$this->Model->getOne('utilisateurs',array('ID_UTILISATEUR'=>$id));

	    if(!empty($get))
	    {
	      if($get['IS_ACTIF']==1)
	      {
	        $status=0;
	      }
	      else
	      {
	        $status=1;
	      }
	    }
	    $this->Modele->update('utilisateurs',array('ID_UTILISATEUR'=>$id),array('IS_ACTIF'=>$status));
	    
		$data['message']='<div class="alert alert-success text-center" id="message">L\'action est faite avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Psr_elements'));
	}
	function activer($id)
	{
		 $this->Modele->update('utilisateurs',array('ID_UTILISATEUR'=>$id),array('IS_ACTIF'=>1));
        print_r(json_encode(1));
	}
	function desactiver($id)
	{
		 $this->Modele->update('utilisateurs',array('ID_UTILISATEUR'=>$id),array('IS_ACTIF'=>0));
        print_r(json_encode(1));
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
		$data['profils'] = $this->Model->getRequete('SELECT PROFIL_ID, STATUT FROM profil WHERE 1 ORDER BY STATUT ASC');
		$data['grade'] = $this->Model->getRequete('SELECT `ID_GRADE`,`GRADE` FROM `psr_grade` WHERE 1 ORDER BY `GRADE`');

		$data['title'] = 'Nouveau fonctionnaire de la PNB';
		$this->load->view('psr_add_view', $data);
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
		$this->form_validation->set_rules('NOM', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PRENOM', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NUMERO_MATRICULE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('TELEPHONE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('EMAIL', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PROFIL_ID', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('DATE_NAISSANCE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));





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
				'ID_GRADE' => $this->input->post('ID_GRADE'),
				'SEXE' => $this->input->post('SEXE'),
				'PHOTO' => $pathfile
			);
			//print_r($data_insert); die();
			$table = 'psr_elements';
			$idPolice = $this->Modele->insert_last_id($table, $data_insert);

			$password = $this->notifications->generate_password(9);

			$data_User = array(
				'NOM_UTILISATEUR' => $email,
				'MOT_DE_PASSE' => md5($telephone),
				'PROFIL_ID' => $profil,
				'PSR_ELEMENT_ID' => $idPolice,
			);

			$subjet = 'creation de mot de passe';

			$message = $nom . " " . $prenom . ",<br>Vos ids de connexion sur application PSR sont<br>
			<div>nom d'utilisateur <b>" . $email . "</b><br>Mot de passe<b> " . $telephone . "</b>
			";


			$sms = ucfirst($nom) . " " . $prenom . ",Vos ids sur PSR sont username:" . $email . "; password: " . $telephone . "";

			
			//$this->send_sms_smpp(trim($telephone), $sms);
			$this->notifications->send_mail($emailTo, $subjet, null, $message, null);

			$tabl = 'utilisateurs';
			$this->Modele->create($tabl, $data_User);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Psr_elements/'));
		}
	}
	function getOne($id = 0)
	{
		$membre = $this->Modele->getRequeteOne('SELECT * FROM psr_elements WHERE  ID_PSR_ELEMENT=' . $id);

		$data['profils'] = $this->Model->getRequete('SELECT PROFIL_ID, STATUT FROM profil WHERE 1 ORDER BY STATUT ASC');

		$data['user'] = $this->Model->getRequeteOne('SELECT `PROFIL_ID` FROM `utilisateurs` WHERE `PSR_ELEMENT_ID`='.$id);

		$data['membre'] = $membre;
		$data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
		$data['communes'] = $this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID=' . $membre['PROVINCE_ID'] . ' ORDER BY COMMUNE_NAME ASC');
		$data['zones'] = $this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID=' . $membre['COMMUNE_ID'] . ' ORDER BY ZONE_NAME ASC');
		$data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID=' . $membre['ZONE_ID'] . ' ORDER BY COLLINE_NAME ASC');

		$data['title'] = "Modifier les informations d'un agent";
		$this->load->view('psr_update_view', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('NOM', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PRENOM', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NUMERO_MATRICULE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('TELEPHONE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('EMAIL', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		$id = $this->input->post('ID_PSR_ELEMENT');

		if ($this->form_validation->run() == FALSE) {
			//$id=$this->input->post('ID_GERANT');

			$this->getOne($id);
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
			$id = $this->input->post('ID_PSR_ELEMENT');
			$telephone = $this->input->post('TELEPHONE');
			$email = $this->input->post('EMAIL');
			$profil = $this->input->post('PROFIL_ID');

			// print_r($_FILES['PHOTO']);
			// exit();
            

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
				'ID_GRADE' => $this->input->post('ID_GRADE'),
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
				'ID_GRADE' => $this->input->post('ID_GRADE'),
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

			$this->Modele->update('psr_elements', array('ID_PSR_ELEMENT' => $id), $data);
			$this->Modele->updateData('utilisateurs', $data_User, array('PSR_ELEMENT_ID' => $id));

			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('PSR/Psr_elements/'));
		}
	}

	function delete()
	{
		$table = "psr_elements";
		$criteres['ID_PSR_ELEMENT'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Psr_elements'));
	}
}
