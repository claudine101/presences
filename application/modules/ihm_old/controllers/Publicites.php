<?php 
/**
 * Claude
 * Gestion de publicités
 
 */
class Publicites extends CI_Controller
{
	
	function __construct()
	{
		# code...
		parent::__construct();
	}
	function index()
	{
		
		$restaur='SELECT ID_RESTAURANT, NOM_RESTAURANT FROM restaurants WHERE 1';
		$mes_resto=$this->Modele->getRequete($restaur);

		$data['title'] = 'Gestion des publicités';
        $data['restaurants'] = $mes_resto;
		$this->load->view('Publicite_List_View',$data);
	}

	function listing()
	{ 
		$ID_RESTAURANT=$this->input->post('resto');
		$critere='';
		if ($ID_RESTAURANT!='') {
			# code...
			$critere=' WHERE r.ID_RESTAURANT='.$ID_RESTAURANT.'';
		}

		$query_principal='SELECT p.ID_PUB AS ID_PUB,r.NOM_RESTAURANT AS RESTAURANT,p.PUB_URL AS PUB_URL,p.PUB_IMAGE AS PUB_IMAGE FROM publicites p LEFT JOIN restaurants r ON p.ID_RESTO=r.ID_RESTAURANT '.$critere;



		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit='LIMIT 0,10';


		if($_POST['length'] != -1){
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		$order_by='';


		$order_column=array('RESTAURANT','PUB_URL','PUB_IMAGE');

		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY RESTAURANT,PUB_URL ASC';

		$search = !empty($_POST['search']['value']) ? (" AND RESTAURANT LIKE '%$var_search%' OR PUB_URL LIKE '%$var_search%'") : '';     

		$critaire = '';

		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;


		$fetch_pub = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_pub as $row) {

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_PUB . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Publicites/getOne/'.md5($row->ID_PUB)) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
	

			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_PUB . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><p>Voulez-vous supprimer la pub de <br><b style='background-color:prink;color:green;'><i>" .$row->RESTAURANT."</i> </b></p><br><img style='width:80px;' src='".$row->PUB_IMAGE."'></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Publicites/delete/'.$row->ID_PUB) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			$sub_array[]= '<a href="'.$row->PUB_IMAGE.'" target="_blank" ><img style="border-radius:50%;width:40px;height:40px" src="'.$row->PUB_IMAGE.'"></a>';

			$sub_array[]=$row->RESTAURANT;
			
			$sub_array[]='<a href="'.$row->PUB_URL.'" target="_blank" title="'.$row->PUB_URL.'">Voir la pub</a>';
			
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

	function ajouter()
	{
     
		$data['resto'] = $this->Modele->getRequete('SELECT ID_RESTAURANT, NOM_RESTAURANT FROM restaurants WHERE 1 ORDER BY NOM_RESTAURANT');

		$data['title'] = 'Nouvelle Publicité';
		$this->load->view
		('Publicites_Add_View',$data);

	}
	function add()
	{

		$this->form_validation->set_rules('ID_RESTAURANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PUB_URL','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if($this->form_validation->run() == FALSE)
		{
			$this->ajouter();
		}else{
			//print_r($_FILES['PHOTO']);
			$file= $_FILES['PHOTO'];
			$path='./publicites/Publicites/';
			if(!is_dir(FCPATH.'/publicites/Publicites/')){
				mkdir(FCPATH.'/publicites/Publicites/', 0777, TRUE);
			}

			$thepath= base_url().'publicites/Publicites/';
			$config['upload_path']= './publicites/Publicites/';
			$photonames= date('ymdHisa');
			$config['file_name']=$photonames;
			$config['allowed_types']= '*';
			$this->upload->initialize($config);
			$this->upload->do_upload("PHOTO");
			$info=$this->upload->data();

			if($file==''){
				$pathfile= base_url().'publicites/sevtb.png';
			}else{
				$pathfile= base_url().'/publicites/Publicites/'.$photonames.$info['file_ext'];
			}                     

			$data_insert=array(

				'ID_RESTO'=>$this->input->post('ID_RESTAURANT'),

				'ID_MENU_RESTO'=>0,

				'PUB_URL'=>$this->input->post('PUB_URL'),

				'PUB_IMAGE'=>$pathfile,
				'IS_ACTIF'=>1,


			);

			$table='publicites';
			$this->Modele->create($table,$data_insert);

			$data['message']='<div class="alert alert-success text-center" id="message">'."L'enregistrement du publicité est faite avec succès".'</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Publicites/'));

		}

	}

	function getOne()
	{
		$id=$this->uri->segment(4);

	$data['resto'] = $this->Modele->getRequete('SELECT ID_RESTAURANT, NOM_RESTAURANT FROM restaurants WHERE 1 ORDER BY NOM_RESTAURANT');


		$data['piece']=$this->Modele->getRequeteOne('SELECT * FROM `publicites` WHERE 1 and md5(ID_PUB)="'.$id.'"');

		$data['title'] = '🏷️ Modification du Publicité';
		$this->load->view('Publicites_Update_View',$data);		
	}

	function update()
	{
		$this->form_validation->set_rules('ID_RESTAURANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PUB_URL','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

        $file= $_FILES['PHOTO'];
			$path='./publicites/Publicites/';
			if(!is_dir(FCPATH.'/publicites/Publicites/')){
				mkdir(FCPATH.'/publicites/Publicites/', 0777, TRUE);
			}

			$thepath= base_url().'publicites/Publicites/';
			$config['upload_path']= './publicites/Publicites/';
			$photonames= date('ymdHisa');
			$config['file_name']=$photonames;
			$config['allowed_types']= '*';
			$this->upload->initialize($config);
			$this->upload->do_upload("PHOTO");
			$info=$this->upload->data();

			if($file==''){
				$pathfile= base_url().'publicites/sevtb.png';
			}else{
				$pathfile= base_url().'/publicites/Publicites/'.$photonames.$info['file_ext'];
			}                     


		$id=$this->input->post('ID_PUB');

		if ($this->form_validation->run() == FALSE) {

			$this->getOne($id);
		}else{
			$id=$this->input->post('ID_PUB');

			$data=array(
				'ID_RESTO'=>$this->input->post('ID_RESTAURANT'),
				'PUB_URL'=>$this->input->post('PUB_URL'),
				'PUB_IMAGE'=>$pathfile,
				

		);

			$this->Modele->update('publicites',array('ID_PUB'=>$id),$data);
			$datas['message']='<div class="alert alert-success text-center" id="message">La modification du publicité est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Publicites/'));
		}

	}

	function delete()
	{
		$table="publicites";
		$criteres['ID_PUB']=$this->uri->segment(4);
		$data['rows']= $this->Modele->getOne( $table,$criteres);
		$this->Modele->delete($table,$criteres);

		$data['message']='<div class="alert alert-success text-center" id="message">Le publicité est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/publicites/'));
	}
}

?>