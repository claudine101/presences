<?php
/**
*NTAHIMPERA Martin Luther King
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
		if ($this->session->userdata('PSR_ELEMENT')!=1) {

			redirect(base_url());

		}
	}
	function index()
	{
		$data['title'] = 'Element de la police';
		$this->load->view('psr_list_view',$data);
	}

	function listing()
	{

		$i=1;
		$query_principal='SELECT ID_PSR_ELEMENT, NOM, PRENOM, NUMERO_MATRICULE,sp.PROVINCE_NAME AS province, sc.COMMUNE_NAME AS commune ,sz.ZONE_NAME AS zone, sco.COLLINE_NAME AS Colline, TELEPHONE, EMAIL, psr.LATITUDE, psr.LONGITUDE, psr.IS_ACTIF, ID_GRADE, p.STATUT FROM psr_elements psr LEFT JOIN syst_provinces sp ON psr.PROVINCE_ID=sp.PROVINCE_ID LEFT JOIN syst_communes sc ON sc.COMMUNE_ID=psr.COMMUNE_ID LEFT JOIN syst_zones sz on sz.ZONE_ID=psr.ZONE_ID LEFT JOIN syst_collines sco ON sco.COLLINE_ID=psr.COLLINE_ID LEFT JOIN utilisateurs us on us.PSR_ELEMENT_ID=psr.ID_PSR_ELEMENT LEFT JOIN profil p ON p.PROFIL_ID = us.PROFIL_ID  WHERE 1';

		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit='LIMIT 0,10';


		if($_POST['length'] != -1){
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}

		$order_by='';


		$order_column=array('ID_PSR_ELEMENT','NOM','PRENOM','NUMERO_MATRICULE','TELEPHONE','EMAIL');

		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM,PRENOM ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NOM LIKE '%$var_search%' OR PRENOM LIKE '%$var_search%' OR NUMERO_MATRICULE LIKE '%$var_search%'  "):'';     

		$critaire = '';

		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;

		$fetch_psr = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_psr as $row)
		{

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_PSR_ELEMENT . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Psr_elements/getOne/'.$row->ID_PSR_ELEMENT) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Psr_elements/show_performance/'.$row->ID_PSR_ELEMENT) . "'><label class='text-info'>&nbsp;&nbsp;Performance</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_PSR_ELEMENT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" .$row->NOM." ".$row->PRENOM."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Psr_elements/delete/'.$row->ID_PSR_ELEMENT) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			$sub_array[]=$i++;
			$sub_array[]='image';
			$sub_array[]=$row->NOM;
			$sub_array[]=$row->PRENOM;
			$sub_array[]=$row->NUMERO_MATRICULE; 
			$sub_array[]=$row->province;
			$sub_array[]=$row->commune; 
			$sub_array[]=$row->zone; 
			$sub_array[]=$row->Colline; 			
			$sub_array[]=$row->TELEPHONE; 
			$sub_array[]=$row->EMAIL; 
			$sub_array[]=$row->STATUT;			
			$sub_array[]=$option;   
			$data[] = $sub_array;
		}


		$output = array(
			"draw" => intval($_POST['draw']),
			"recordsTotal" =>$this->Modele->all_data($query_principal),
			"recordsFiltered" => $this->Modele->filtrer($query_filter),
			"data" => $data
		);
		echo json_encode($output);

	}

	function show_performance($ID_PSR_ELEMENT){
		$agent = $this->Modele->getRequeteOne("SELECT e.ID_PSR_ELEMENT,e.NOM,e.PRENOM,e.NUMERO_MATRICULE,e.DATE_NAISSANCE,e.PHOTO,p.PROVINCE_NAME as PROV_NAISSANCE,c.COMMUNE_NAME as COM_NAISSANCE,z.ZONE_NAME as ZONE_NAISSANCE,co.COLLINE_NAME as COLL_NAISSANCE,e.TELEPHONE,e.EMAIL,pr.PROVINCE_NAME as PROV_AFFECT,cm.COMMUNE_NAME as COMM_AFFECT,zo.ZONE_NAME as ZON_AFFECT, col.COLLINE_NAME as COLLINE_AFFECT,a.LIEU_EXACTE,a.LATITUDE,a.LONGITUDE FROM psr_elements e LEFT JOIN psr_affectatations a ON e.ID_PSR_ELEMENT=a.ID_PSR_ELEMENT LEFT JOIN syst_provinces p on p.PROVINCE_ID=e.PROVINCE_ID LEFT JOIN syst_communes c on c.COMMUNE_ID=e.COMMUNE_ID LEFT JOIN syst_zones z on z.ZONE_ID=e.ZONE_ID LEFT JOIN syst_collines co ON e.COLLINE_ID=co.COLLINE_ID LEFT JOIN syst_provinces pr on pr.PROVINCE_ID=a.PROVINCE_ID LEFT JOIN syst_communes cm on cm.COMMUNE_ID=a.COMMUNE_ID LEFT JOIN syst_zones zo on zo.ZONE_ID=a.ZONE_ID LEFT JOIN syst_collines col ON a.COLLINE_ID=col.COLLINE_ID WHERE e.ID_PSR_ELEMENT=".$ID_PSR_ELEMENT);

		$rapport = $this->Modele->getRequete("SELECT SUM(`MONTANT`) AS AMANDE, DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y') AS JOURS FROM historiques h JOIN utilisateurs u ON u.ID_UTILISATEUR=h.ID_UTILISATEUR  WHERE u.PSR_ELEMENT_ID=".$ID_PSR_ELEMENT." GROUP by DATE_FORMAT(h.DATE_INSERTION, '%d-%m-%Y')");

		$nombre=0;

		$donne = "";
		$catego = "";
		$datas = 0;

		if (!empty($rapport)) {
			
			foreach ($rapport as  $value) 
			{
				$mm = !empty($value['AMANDE']) ? $value['AMANDE'] : 0;
				$date  =  !empty($value['JOURS']) ? $value['JOURS'] : date('d-m-Y');
				$catego.= "'".$date."',";
				$datas .=  $mm.",";
				$nombre+=$value['AMANDE'];

			}

		}else{

			$mm = 0;
			$date  =   date('d-m-Y');
			$catego.= "'".$date."',";
			$datas .=  $mm.",";
			$nombre+=$mm;
		}


		$catego.= "@";
		$catego= str_replace(",@", "", $catego);

		$datas.= "@";
		$datas = str_replace(",@", "", $datas);


		$donne .="{
			name: 'Amande',
			data: [".$datas."]
		},";


		$data['catego'] = $catego;
		$data['donne'] = $donne;
		$data['total'] = $nombre;

// print_r($catego.$donne);
// exit();

		$data['title']="Tableau de bord d'un agent";
		$data['agent'] = $agent;
		$this->load->view('espace_perso/Performance_Police_View',$data);

	}

	function ajouter()
	{
		$data['provinces']=$this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
		$data['profils']=$this->Model->getRequete('SELECT PROFIL_ID, STATUT FROM profil WHERE 1 ORDER BY STATUT ASC');

		$data['title'] = 'Nouveau Element';
		$this->load->view('psr_add_view',$data);

	}

	function get_communes($ID_PROVINCE=0)
	{
		$communes=$this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID='.$ID_PROVINCE.' ORDER BY COMMUNE_NAME ASC');
		$html='<option value="">---selectionner---</option>';
		foreach ($communes as $key)
		{
			$html.='<option value="'.$key['COMMUNE_ID'].'">'.$key['COMMUNE_NAME'].'</option>';
		}
		echo json_encode($html);
	}

	function get_zones($ID_COMMUNE=0)
	{
		$zones=$this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID='.$ID_COMMUNE.' ORDER BY ZONE_NAME ASC');
		$html='<option value="">---selectionner---</option>';
		foreach ($zones as $key)
		{
			$html.='<option value="'.$key['ZONE_ID'].'">'.$key['ZONE_NAME'].'</option>';
		}
		echo json_encode($html);
	}

	function get_collines($ID_ZONE=0)
	{
		$collines=$this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID='.$ID_ZONE.' ORDER BY COLLINE_NAME ASC');
		$html='<option value="">---selectionner---</option>';
		foreach ($collines as $key)
		{
			$html.='<option value="'.$key['COLLINE_ID'].'">'.$key['COLLINE_NAME'].'</option>';
		}
		echo json_encode($html);
	}



	function add()
	{
		$this->form_validation->set_rules('NOM','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PRENOM','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NUMERO_MATRICULE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('TELEPHONE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('EMAIL','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PROFIL_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('DATE_NAISSANCE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));





		if($this->form_validation->run() == FALSE)
		{
			$this->ajouter();
		}else{

			$file= $_FILES['PHOTO'];
			$path='./uploads/Gestion_Publication_Menu/';
			if(!is_dir(FCPATH.'/uploads/Gestion_Publication_Menu/')){
				mkdir(FCPATH.'/uploads/Gestion_Publication_Menu/', 0777, TRUE);
			}

			$thepath= base_url().'uploads/Gestion_Publication_Menu/';
			$config['upload_path']= './uploads/Gestion_Publication_Menu/';
			$photonames= date('ymdHisa');
			$config['file_name']=$photonames;
			$config['allowed_types']= '*';
			$this->upload->initialize($config);
			$this->upload->do_upload("PHOTO");
			$info=$this->upload->data();

			if($file==''){
				$pathfile= base_url().'uploads/sevtb.png';
			}else{
				$pathfile= base_url().'/uploads/Gestion_Publication_Menu/'.$photonames.$info['file_ext'];
			}        

			$nom=$this->input->post('NOM');
			$prenom=$this->input->post('PRENOM');
			$matricule=$this->input->post('NUMERO_MATRICULE');
			$telephone=$this->input->post('TELEPHONE');
			$email=$this->input->post('EMAIL');
			$profil=$this->input->post('PROFIL_ID');

			$data_insert=array(

				'NOM'=>$nom,
				'PRENOM'=>$prenom,
				'NUMERO_MATRICULE'=>$matricule,
				'PROVINCE_ID'=>$this->input->post('ID_PROVINCE'),
				'COMMUNE_ID'=>$this->input->post('ID_COMMUNE'),
				'ZONE_ID'=>$this->input->post('ID_ZONE'),
				'COLLINE_ID'=>$this->input->post('ID_COLLINE'),
				'TELEPHONE'=>$telephone,
				'EMAIL'=>$email,
				'DATE_NAISSANCE'=>$this->input->post('DATE_NAISSANCE'),
				'PHOTO'=>$pathfile
			);
			print_r($data_insert); die();
			$table='psr_elements';
			$idPolice=$this->Modele->insert_last_id($table,$data_insert);	
			$password=$this->notifications->generate_password(6);
			$data_User=array(
				'NOM_UTILISATEUR'=> $email,
				'MOT_DE_PASSE'=> md5($password),
				'PROFIL_ID'=>$profil,
				'PSR_ELEMENT_ID'=> $idPolice,
			);

			$subjet='creation de mot de passe';
			$message="
			<div>votre mot de passe est '".$password."' 
			<p>Bonjour. Souhaitez-vous changer le mot de passe Cliquez <a href='".base_url('Change_Password/index')."'>ici</a> ?</p>
			</div>";

			// $this->notifications->send_mail($email,$subjet,$cc_emails=NULL,$message,$attach=NULL);
   //          $this->notifications->send_sms($telephone,$message);
			$tabl='utilisateurs';
			$this->Modele->create($tabl,$data_User);

			$data['message']='<div class="alert alert-success text-center" id="message">'."L'ajout se faite avec succès".'</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Psr_elements/'));

		}

	}
	function getOne($id=0)
	{
		$membre=$this->Modele->getRequeteOne('SELECT ID_PSR_ELEMENT, NOM, PRENOM, NUMERO_MATRICULE, PROVINCE_ID, COMMUNE_ID, ZONE_ID, COLLINE_ID, TELEPHONE, EMAIL, LATITUDE, LONGITUDE, IS_ACTIF, ID_GRADE FROM psr_elements WHERE  ID_PSR_ELEMENT='.$id);
		$data['profils']=$this->Model->getRequete('SELECT PROFIL_ID, STATUT FROM profil WHERE 1 ORDER BY STATUT ASC');

		$data['membre']=$membre;
		$data['provinces']=$this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
		$data['communes']=$this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID='.$membre['PROVINCE_ID'].' ORDER BY COMMUNE_NAME ASC');
		$data['zones']=$this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID='.$membre['COMMUNE_ID'].' ORDER BY ZONE_NAME ASC');
		$data['collines']=$this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID='.$membre['ZONE_ID'].' ORDER BY COLLINE_NAME ASC');
		
		$data['title'] = "Modification d'un Policien";
		$this->load->view('psr_update_view',$data);
	}

	function update()
	{
		$this->form_validation->set_rules('NOM','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PRENOM','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NUMERO_MATRICULE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('TELEPHONE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('EMAIL','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		$id=$this->input->post('ID_PSR_ELEMENT');

		if ($this->form_validation->run() == FALSE) {
		//$id=$this->input->post('ID_GERANT');

			$this->getOne();
		}else{
			$id=$this->input->post('ID_PSR_ELEMENT');
			$telephone=$this->input->post('TELEPHONE');
			$email=$this->input->post('EMAIL');
			$profil=$this->input->post('PROFIL_ID');
			$data=array(
				'NOM'=>$this->input->post('NOM'),
				'PRENOM'=>$this->input->post('PRENOM'),
				'NUMERO_MATRICULE'=>$this->input->post('NUMERO_MATRICULE'),
				'PROVINCE_ID'=>$this->input->post('ID_PROVINCE'),
				'COMMUNE_ID'=>$this->input->post('ID_COMMUNE'),
				'ZONE_ID'=>$this->input->post('ID_ZONE'),
				'COLLINE_ID'=>$this->input->post('ID_COLLINE'),
				'TELEPHONE'=>$this->input->post('TELEPHONE'),
				'EMAIL'=>$email,
			);

			$data_User=array(
				'NOM_UTILISATEUR'=> $email,
				'MOT_DE_PASSE'=> md5($telephone),
				'PROFIL_ID'=>$profil,
				'PSR_ELEMENT_ID'=> $id,
			);

			$this->Modele->update('psr_elements',array('ID_PSR_ELEMENT'=>$id),$data);
			$this->Modele->updateData('utilisateurs',$data_User,array('PSR_ELEMENT_ID'=>$id));

			$datas['message']='<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('PSR/Psr_elements/'));
		}
	}

	function delete()
	{
		$table="psr_elements";
		$criteres['ID_PSR_ELEMENT']=$this->uri->segment(4);
		$data['rows']= $this->Modele->getOne( $table,$criteres);
		$this->Modele->delete($table,$criteres);

		$data['message']='<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Psr_elements'));
	}

}
