<?php

/**
 *NDAYISABA Claudine
 *	CRUD DE TABLE Employes
 **/
class  Employes extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		if ($this->session->userdata('ID_PROFIL') != 2 && $this->session->userdata('ID_PROFIL') != 5 && $this->session->userdata('ID_PROFIL') != 4) {
			// redirect(base_url());
			redirect('Login');
		}
	}

	function index()
	{
		$data['title'] = 'Liste des Employes';
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
      
		$this->load->view('employes/Employes_List_View', $data);
	}

	function listing()
	{

		$i = 1;

		$query_principal = 'SELECT a.DESCRIPTION  ,col.COLLINE_ID,col.COLLINE_NAME,  zo.ZONE_ID ,zo.ZONE_NAME, co.COMMUNE_ID, co.COMMUNE_NAME,pro.PROVINCE_ID  ,pro.PROVINCE_NAME,ca.* FROM Employes ca JOIN syst_collines col ON  ca.ID_COLLINE_EMPLOYE=col.COLLINE_ID   JOIN syst_zones zo ON col.ZONE_ID=zo.ZONE_ID  JOIN syst_communes co ON zo.COMMUNE_ID=co.COMMUNE_ID JOIN syst_provinces pro ON
		 pro.PROVINCE_ID=co.PROVINCE_ID JOIN  agences a ON a.ID_AGENCE=ca.ID_AGENCE  WHERE 1';
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';
		
		$order_column = array('ID_EMPLOYE','NOM_EMPLOYE', 'PRENOM_EMPLOYE','ADRESE_EMPLOYE','NUMERO_CNI_EMPLOYE', 'IS_ACTIVE_EMPLOYE','DESCRIPTION','COLLINE_NAME');

		$order_by = isset($_POST['order']) ? 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM_EMPLOYE DESC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM_EMPLOYE LIKE '%$var_search%'") : '';

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
			data-target='#mydelete" . $row->ID_EMPLOYE   . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('donnees/Employes/getOne/' . $row->ID_EMPLOYE  ) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_EMPLOYE   . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->NOM_EMPLOYE . "   ".$row->PRENOM_EMPLOYE."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('donnees/Employes/delete/' . $row->ID_EMPLOYE  ) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";
	
			$sub_array = array();
			$u=++$u;
			$source = !empty($row->PHOTO_EMPLOYE) ? $row->PHOTO_EMPLOYE : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			
			$sub_array[]=$u;
			$sub_array[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM_EMPLOYE . ' ' . $row->PRENOM_EMPLOYE . '</td></tr></tbody></table></a>';
			$sub_array[] = '<table> <tbody><tr><td>' . $row->TELEPHONE_EMPLOYE . ' ' . $row->EMAIL_EMPLOYE . '</td></tr></tbody></table></a>';
            $sub_array[] = $row->NUMERO_CNI_EMPLOYE;
			$sub_array[] = $this->notifications->ago($row->DATE_NAISSANCE_EMPLOYE, date('Y-m-d'));
            $sub_array[] = $row->SEXE_EMPLOYE;
            $sub_array[] = $row->DESCRIPTION;
			$sub_array[] = $this->get_icon($row->IS_ACTIVE_EMPLOYE,$row);
			$sub_array[] = $row->COLLINE_NAME.'-'.$row->ZONE_NAME.'-'.$row->COMMUNE_NAME.'-'.$row->PROVINCE_NAME;
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
	function get_icon($statut, $row)
	{
	  $html = ($statut == 1) ? "<a class='btn btn-success btn-sm' id='".$row->NOM_EMPLOYE."'  title='".$row->NOM_EMPLOYE."'  onclick='desactiver(".$row->ID_EMPLOYE.",this.title,this.id)' style='float:right' ><span class = 'fa fa-check'></span></a>" : "<a class = 'btn btn-danger btn-sm' id='".$row->NOM_EMPLOYE."'  title='".$row->NOM_EMPLOYE."'  onclick='activer(".$row->ID_EMPLOYE.",this.title,this.id)' style='float:right'><span class = 'fa fa-ban' ></span></a>" ;
	  return $html;
	}
	function activer($id)
    {
          $this->Modele->update('Employes',array('ID_EMPLOYE'=>$id),array('IS_ACTIVE_EMPLOYE'=>1));
       print_r(json_encode(1));
    }
    function desactiver($id)
    {
          $this->Modele->update('Employes',array('ID_EMPLOYE'=>$id),array('IS_ACTIVE_EMPLOYE'=>0));
       print_r(json_encode(1));
    }
	function ajouter()
	{
		$data['title'] = 'Nouveau employé ';
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
		$data['agences'] = $this->Modele->getRequete('SELECT * FROM agences WHERE 1 order by DESCRIPTION ASC');
		$data['date_arrives'] = $this->Modele->getRequete('SELECT * FROM arrives WHERE 1 order by HEURES ASC');
        
		$this->load->view('employes/Employes_Add_View', $data);
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
		$this->form_validation->set_rules('NOM_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('PRENOM_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('TELEPHONE_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('EMAIL_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('NUMERO_CNI_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('DATE_NAISSANCE_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_AGENCE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('SEXE_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_COLLINE_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_ARRIVE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
        if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			
			$file = $_FILES['PHOTO'];
			$path = './uploads/Employes/';
			if (!is_dir(FCPATH . '/uploads/Employes/')) {
				mkdir(FCPATH . '/uploads/Employes/', 0777, TRUE);
			}

			$thepath = base_url() . 'uploads/Employes/';
			$config['upload_path'] = './uploads/Employes/';
			$photonames = date('ymdHisa');
			$config['file_name'] = $photonames;
			$config['allowed_types'] = '*';
			$this->upload->initialize($config);
			$this->upload->do_upload("PHOTO");
			$info = $this->upload->data();

			if ($file == '') {
				$pathfile = base_url() . 'uploads/sevtb.png';
			} else {
				$pathfile = base_url() . '/uploads/Employes/' . $photonames . $info['file_ext'];
			}


			$camerasImage = $this->input->post('ImageLink');

			if (!empty($camerasImage)) {

				$dir = FCPATH.'/uploads/cameraImageCeni/';
			      if (!is_dir(FCPATH . '/uploads/cameraImageCeni/')) {
				  mkdir(FCPATH . '/uploads/cameraImageCeni/', 0777, TRUE);
			    }

                $photonames = date('ymdHisa');
                $pathfile = base_url() . 'uploads/cameraImageCeni/' . $photonames .".png";
			    $pathfiless = FCPATH . '/uploads/cameraImageCeni/' . $photonames .".png";
			    $file_name = $photonames .".png";

			    $img = $this->input->post('ImageLink'); // Your data 'data:image/png;base64,AAAFBfj42Pj4';
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                file_put_contents($pathfiless, $data);

				//echo "<img src='".$path."' >";
				
			}
			$data_users = array(
				'USERNAME' => $this->input->post('EMAIL_EMPLOYE'),
				'PASSWORD' => md5($this->input->post('TELEPHONE_EMPLOYE')),
				'ID_PROFIL' => 3,
				'ID_ARRIVE'=> $this->input->post('ID_ARRIVE'),
			);
			$tableusers = 'utilisateurs';
			$idUsers = $this->Modele->insert_last_id($tableusers, $data_users);

			$data_insert = array(
				'NOM_EMPLOYE' => $this->input->post('NOM_EMPLOYE'),
				'PRENOM_EMPLOYE' => $this->input->post('PRENOM_EMPLOYE'),
				'TELEPHONE_EMPLOYE' => $this->input->post('TELEPHONE_EMPLOYE'),
				'EMAIL_EMPLOYE' => $this->input->post('EMAIL_EMPLOYE'),
				'NUMERO_CNI_EMPLOYE' => $this->input->post('NUMERO_CNI_EMPLOYE'),
				'DATE_NAISSANCE_EMPLOYE' => $this->input->post('DATE_NAISSANCE_EMPLOYE'),
				'SEXE_EMPLOYE' => $this->input->post('SEXE_EMPLOYE'),
				'PHOTO_EMPLOYE' => $pathfile,
				'ID_AGENCE'=> $this->input->post('ID_AGENCE'),
				'ID_COLLINE_EMPLOYE' => $this->input->post('ID_COLLINE_EMPLOYE'),
				'ID_UTILISATEUR'=>$idUsers
			);
			$table = 'Employes';
			$this->Modele->create($table, $data_insert);
			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('donnees/Employes/'));
		}
	}

	function getOne($id)
	{
		$employes = $this->Modele->getOne('Employes', array('ID_EMPLOYE' => $id));
		// print_r($employes);
		// exit();
		$colline = $this->Modele->getOne('syst_collines', array('COLLINE_ID' =>$employes['ID_COLLINE_EMPLOYE']));
		$zone = $this->Modele->getOne('syst_zones', array('ZONE_ID' => $colline['ZONE_ID']));
		$commun = $this->Modele->getOne('syst_communes', array('COMMUNE_ID' => $zone['COMMUNE_ID']));
		$prov = $this->Modele->getOne('syst_provinces', array('PROVINCE_ID' => $commun['PROVINCE_ID']));
		
		$data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID=' . $colline['ZONE_ID'] . ' ORDER BY COLLINE_NAME ASC');
		$data['zones'] = $this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID=' . $commun['COMMUNE_ID'] . ' ORDER BY ZONE_NAME ASC');
		$data['communes'] = $this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID=' . $prov['PROVINCE_ID'] . ' ORDER BY COMMUNE_NAME ASC');
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
        $data['provinces'] = $this->Modele->getRequete('SELECT * FROM syst_provinces WHERE 1 order by PROVINCE_NAME ASC');
	
		$data['data'] = $employes;
		$data['selectColl'] = $colline;
		$data['selectZon'] = $zone;
		$data['selectComm'] = $commun;
		$data['selectProv'] = $prov;

		$data['title'] = "Modification de l'employé ";
		$this->load->view('employes/Employes_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('NOM_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('PRENOM_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('TELEPHONE_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('EMAIL_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('NUMERO_CNI_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('DATE_NAISSANCE_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$this->form_validation->set_rules('SEXE_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_COLLINE_EMPLOYE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$id = $this->input->post('ID_EMPLOYE');
//  print $id
//  exit();
		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {

			
			$file = $_FILES['PHOTO'];
			$path = './uploads/Employes/';
			if (!is_dir(FCPATH . '/uploads/Employes/')) {
				mkdir(FCPATH . '/uploads/Employes/', 0777, TRUE);
			}

			$thepath = base_url() . 'uploads/Employes/';
			$config['upload_path'] = './uploads/Employes/';
			$photonames = date('ymdHisa');
			$config['file_name'] = $photonames;
			$config['allowed_types'] = '*';
			$this->upload->initialize($config);
			$this->upload->do_upload("PHOTO");
			$info = $this->upload->data();

			if ($file == '') {
				$pathfile = base_url() . 'uploads/sevtb.png';
			} else {
				$pathfile = base_url() . '/uploads/Employes/' . $photonames . $info['file_ext'];
			}


			$id = $this->input->post('ID_EMPLOYE');
			if(!empty($_FILES['PHOTO']['name'])) {
				$data = array(
					'NOM_EMPLOYE' => $this->input->post('NOM_EMPLOYE'),
					'PRENOM_EMPLOYE' => $this->input->post('PRENOM_EMPLOYE'),
					'TELEPHONE_EMPLOYE' => $this->input->post('TELEPHONE_EMPLOYE'),
					'EMAIL_EMPLOYE' => $this->input->post('EMAIL_EMPLOYE'),
					'NUMERO_CNI_EMPLOYE' => $this->input->post('NUMERO_CNI_EMPLOYE'),
					'DATE_NAISSANCE_EMPLOYE' => $this->input->post('DATE_NAISSANCE_EMPLOYE'),
					'SEXE_EMPLOYE' => $this->input->post('SEXE_EMPLOYE'),
					'PHOTO_EMPLOYE' => $pathfile,
					'ID_COLLINE_EMPLOYE' => $this->input->post('ID_COLLINE_EMPLOYE'),
				);
			}
			else{
				$data = array(
					'NOM_EMPLOYE' => $this->input->post('NOM_EMPLOYE'),
					'PRENOM_EMPLOYE' => $this->input->post('PRENOM_EMPLOYE'),
					'TELEPHONE_EMPLOYE' => $this->input->post('TELEPHONE_EMPLOYE'),
					'EMAIL_EMPLOYE' => $this->input->post('EMAIL_EMPLOYE'),
					'NUMERO_CNI_EMPLOYE' => $this->input->post('NUMERO_CNI_EMPLOYE'),
					'DATE_NAISSANCE_EMPLOYE' => $this->input->post('DATE_NAISSANCE_EMPLOYE'),
					'SEXE_EMPLOYE' => $this->input->post('SEXE_EMPLOYE'),
					'ID_COLLINE_EMPLOYE' => $this->input->post('ID_COLLINE_EMPLOYE'),
				);
			}
			
			$this->Modele->update('Employes', array('ID_EMPLOYE' => $id), $data);
			$datas['message'] = "<div class='alert alert-success text-center' id='message'>La modification de l'employé a été effectuée avec succès.</div>";
			$this->session->set_flashdata($datas);
			redirect(base_url('donnees/Employes/'));
		}
	}

	function delete()
	{
		$table = "Employes";
		$criteres['ID_EMPLOYE'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
		$data['message'] = '<div class="alert alert-success text-center" id="message">L\'element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('donnees/Employes/'));
	}
	function get_qrcode()
	{
		$data['title'] = 'Liste des QRcode';
		$this->load->view('qrcode/Qr_presence_list_view', $data);
	}
	
}
