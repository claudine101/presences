<?php

/**
 *NDAYISABA Claudine
 *	CRUD DE TABLE Employes
 **/
class  Presences extends CI_Controller
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
		$data['title'] = 'Liste des presences';
		$agences=$this->Model->getRequete("SELECT ID_AGENCE, DESCRIPTION FROM agences WHERE 1");
		$data['agences']=$agences;
		$this->load->view('presences/Presences_List_View', $data);
	}

	function listing()
	{

		$i = 1;
		$criteres3="";
		$criteres4="";
		$criteres5="";


        $avant=$this->input->post('avant');
        $agence=$this->input->post('agence');
        $dates=$this->input->post('dates');

		

        if(!empty($avant)){
			if($avant=='AM'){
				$criteres3.=" AND TIME(`DATE_PRESENCE`)<'12:00:00' ";
			}
			else{
			$criteres3.=" AND TIME(`DATE_PRESENCE`)>='12:00:00' ";

			}

		 }
		 if(!empty($agence)){
			$criteres4.=" AND a.`ID_AGENCE`= ".$agence." ";
		  }
		  if(!empty($dates)){
			$criteres5.=" AND date_format(pr.`DATE_PRESENCE`,'%Y-%m-%d')= '".$dates."'  ";
			;
		  }


		$query_principal = 'SELECT a.DESCRIPTION ,pr.ID_PRESENCE,pr.DATE_PRESENCE,DATE_FORMAT(pr.DATE_PRESENCE, "%p") as pm,pr.STATUT,col.COLLINE_ID,col.COLLINE_NAME,  zo.ZONE_ID ,zo.ZONE_NAME, co.COMMUNE_ID, co.COMMUNE_NAME,pro.PROVINCE_ID  
		,pro.PROVINCE_NAME,ca.* FROM Employes ca JOIN presences pr ON pr.ID_UTILISATEUR=ca.ID_UTILISATEUR JOIN syst_collines col ON  ca.ID_COLLINE_EMPLOYE=col.COLLINE_ID  
		 JOIN syst_zones zo ON col.ZONE_ID=zo.ZONE_ID  JOIN syst_communes co ON zo.COMMUNE_ID=co.COMMUNE_ID JOIN syst_provinces pro ON
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

		$query_secondaire = $query_principal .' '.$criteres3 .' '.$criteres4.  ' '.$criteres5.'' .$critaire . ' ' . $search . ' ' . $order_by . ' ' . $limit;
		$query_filter = $query_principal.' '.$criteres3. ' '.$criteres4. ' '.$criteres5.'' . ' ' . $critaire . ' ' . $search;

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
			data-target='#mydelete" . $row->ID_PRESENCE   . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('donnees/Presences/getOne/' . $row->ID_PRESENCE  ) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_PRESENCE   . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer la presence de ?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->NOM_EMPLOYE . "   ".$row->PRENOM_EMPLOYE."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('donnees/Presences/delete/' . $row->ID_PRESENCE  ) . "'>Supprimer</a>
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
            $sub_array[] = $row->DESCRIPTION;
            $sub_array[] = '<table> <tbody><tr><td>' . $row->DATE_PRESENCE . ' ' . $row->pm . '</td></tr></tbody></table>'; 
            $sub_array[] = $row->STATUT==0? 'Retard':'Ponctuel';
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
	  $html = ($statut == 1) ? "<a class='btn btn-success btn-sm' id='".$row->NOM_EMPLOYE."'  title='".$row->NOM_EMPLOYE."'  onclick='desactiver(".$row->ID_PRESENCE.",this.title,this.id)' style='float:right' ><span class = 'fa fa-check'></span></a>" : "<a class = 'btn btn-danger btn-sm' id='".$row->NOM_EMPLOYE."'  title='".$row->NOM_EMPLOYE."'  onclick='activer(".$row->ID_PRESENCE.",this.title,this.id)' style='float:right'><span class = 'fa fa-ban' ></span></a>" ;
	  return $html;
	}
	function activer($id)
    {
          $this->Modele->update('Employes',array('ID_PRESENCE'=>$id),array('IS_ACTIVE_EMPLOYE'=>1));
       print_r(json_encode(1));
    }
    function desactiver($id)
    {
          $this->Modele->update('Employes',array('ID_PRESENCE'=>$id),array('IS_ACTIVE_EMPLOYE'=>0));
       print_r(json_encode(1));
    }
	function ajouter()
	{
		$data['title'] = 'Nouveau presence ';
        $data['employes'] = $this->Modele->getRequete('SELECT * FROM employes WHERE 1 order by NOM_EMPLOYE ASC');
	
        
		$this->load->view('presences/Presences_Add_View', $data);
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
			$path = './uploads/Presences/';
			if (!is_dir(FCPATH . '/uploads/Presences/')) {
				mkdir(FCPATH . '/uploads/Presences/', 0777, TRUE);
			}

			$thepath = base_url() . 'uploads/Presences/';
			$config['upload_path'] = './uploads/Presences/';
			$photonames = date('ymdHisa');
			$config['file_name'] = $photonames;
			$config['allowed_types'] = '*';
			$this->upload->initialize($config);
			$this->upload->do_upload("PHOTO");
			$info = $this->upload->data();

			if ($file == '') {
				$pathfile = base_url() . 'uploads/sevtb.png';
			} else {
				$pathfile = base_url() . '/uploads/Presences/' . $photonames . $info['file_ext'];
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
			redirect(base_url('donnees/Presences/'));
		}
	}

	function getOne($id)
	{
		$employes = $this->Modele->getOne('Presences', array('ID_PRESENCE' => $id));
		$employes=$this->Model->getRequeteOne("SELECT p.*,date_format(p.`DATE_PRESENCE`,'%Y-%m-%d') as dates,date_format(p.`DATE_PRESENCE`,'%h:%m') as min ,e.NOM_EMPLOYE,e.PRENOM_EMPLOYE FROM presences p JOIN 
		employes e on P.ID_UTILISATEUR=e.ID_UTILISATEUR  WHERE p.ID_PRESENCE=".$id."");

	
		$data['data'] = $employes;
		

		$data['title'] = "Modification de  presence de  ".$employes['NOM_EMPLOYE']." ".$employes['PRENOM_EMPLOYE'];
		$this->load->view('presences/Presences_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('DATE_PRESENCE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('heure', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$id = $this->input->post('ID_PRESENCE');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {

			

			$id = $this->input->post('ID_PRESENCE');
			$date_presence_date = $this->input->post('DATE_PRESENCE');
			$date_presence_time = $this->input->post('heure');
			$date_presence = $date_presence_date . ' ' . $date_presence_time. ':00';// Combine date et heure

			$data = array(
				'DATE_PRESENCE' => $date_presence,
				'STATUT'=>1
			);
			
			$this->Modele->update('Presences', array('ID_PRESENCE' => $id), $data);
			$datas['message'] = "<div class='alert alert-success text-center' id='message'>La modification de la presence a été effectuée avec succès.</div>";
			$this->session->set_flashdata($datas);
			redirect(base_url('donnees/Presences/'));
		}
	}

	function delete()
	{
		$table = "Presences";
		$criteres['ID_PRESENCE'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
		$data['message'] = '<div class="alert alert-success text-center" id="message">L\'element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('donnees/Presences/'));
	}
	function get_qrcode()
	{
		$data['title'] = 'Liste des QRcode';
		$this->load->view('qrcode/Qr_presence_list_view', $data);
	}
	
}
