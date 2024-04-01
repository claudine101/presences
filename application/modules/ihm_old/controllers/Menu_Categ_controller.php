<?php 
/**
 * Vanny
 * Gestion de publication de menu
 
 */
class Menu_Categ_controller extends CI_Controller
{
	
	function __construct()
	{
		# code...
		parent::__construct();
	}
	function index()
	{
		$data['title'] = 'Categories des menus';
		$this->load->view('Menu_Categ_controller_List_View',$data);
	}

	function listing()
	{
		$query_principal='SELECT `ID_CATEGORIE`,`NOM_CATEGORIE`,IMAGE
		FROM `menu_categories` WHERE 1';


		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit='LIMIT 0,10';


		if($_POST['length'] != -1){
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		$order_by='';



		$order_column=array('ID_CATEGORIE','NOM_CATEGORIE');

		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM_CATEGORIE ASC';

		$search = !empty($_POST['search']['value']) ? (" AND NOM_CATEGORIE LIKE '%$var_search%'") : '';     

		$critaire = '';

		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;


		$fetch_menu = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_menu as $row) {

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_CATEGORIE . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Menu_Categ_controller/getOne/'.$row->ID_CATEGORIE) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_CATEGORIE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" .$row->NOM_CATEGORIE."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Menu_Categ_controller/delete/'.$row->ID_CATEGORIE) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			$sub_array[]= '<a href="'.$row->IMAGE.'" target="_blank" ><img style="border-radius:50%;width:40px;height:40px" src="'.$row->IMAGE.'"></a>';
			$sub_array[]=$row->NOM_CATEGORIE; 

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
		
		
		$data['title'] = 'Nouvelle categorie';
		$this->load->view
		('Menu_Categ_controller_Add_View',$data);
		
	}
	function add()
	{


		$this->form_validation->set_rules('NOM_CATEGORIE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		


		if($this->form_validation->run() == FALSE)
		{
			$this->ajouter();
		}else{


	    $file= $_FILES['PHOTO_UNE'];

        $path='./upload/categories/';
        if(!is_dir(FCPATH.'/upload/categories/')){
         mkdir(FCPATH.'/upload/categories/', 0777, TRUE);
        }
        
        $thepath= base_url().'upload/categories/';
        $config['upload_path']= './upload/categories/';
        $photonames= date('ymdHisa');
        $config['file_name']=$photonames;
        $config['allowed_types']= '*';
        $this->upload->initialize($config);
        $this->upload->do_upload("PHOTO_UNE");
        $info=$this->upload->data();

        if($file==''){
          $pathfile= base_url().'uploads/sevtb.png';
        }else{
          $pathfile= base_url().'upload/categories/'.$photonames.$info['file_ext'];
        }


			$data_insert=array(


				'NOM_CATEGORIE'=>$this->input->post('NOM_CATEGORIE'),
				'IMAGE'=>$pathfile

				
			);

			$table='menu_categories';
			$this->Modele->create($table,$data_insert);

			$data['message']='<div class="alert alert-success text-center" id="message">'."L'enregistrement est faite avec succès".'</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Menu_Categ_controller/'));

		}

	}

	function getOne()
	{
		
		$id=$this->uri->segment(4);
		$data['data']=$this->Modele->getOne('menu_categories',array('ID_CATEGORIE'=>$id));

		$data['title'] = 'Modification - categorie';
		$this->load->view('Menu_Categ_controller_Update_View',$data);	
	}

	function update()
	{
		
		$this->form_validation->set_rules('NOM_CATEGORIE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		

		//$id=$this->input->post('ID_MENU');

		if ($this->form_validation->run() == FALSE) {

			$this->getOne($id);
		}else{
			$id=$this->input->post('ID_CATEGORIE');


	    $file= $_FILES['PHOTO_UNE'];

        $path='./upload/categories/';
        if(!is_dir(FCPATH.'/upload/categories/')){
         mkdir(FCPATH.'/upload/categories/', 0777, TRUE);
        }
        
        $thepath= base_url().'upload/categories/';
        $config['upload_path']= './upload/categories/';
        $photonames= date('ymdHisa');
        $config['file_name']=$photonames;
        $config['allowed_types']= '*';
        $this->upload->initialize($config);
        $this->upload->do_upload("PHOTO_UNE");
        $info=$this->upload->data();

        if($file==''){
          $pathfile= base_url().'uploads/sevtb.png';
        }else{
          $pathfile= base_url().'upload/categories/'.$photonames.$info['file_ext'];
        }

			$data_insert=array(
				'NOM_CATEGORIE'=>$this->input->post('NOM_CATEGORIE'),
				'IMAGE' =>$pathfile
			);

			$this->Modele->update('menu_categories',array('ID_CATEGORIE'=>$id),$data_insert);
			$datas['message']='<div class="alert alert-success text-center" id="message">La modification  est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Menu_Categ_controller/'));
		}

	}

	function delete()
	{
		$table="menu_categories";
		$criteres['ID_CATEGORIE']=$this->uri->segment(4);
		$data['rows']= $this->Modele->getOne( $table,$criteres);
		$this->Modele->delete($table,$criteres);

		$data['message']='<div class="alert alert-success text-center" id="message">La categorie est supprimée avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Menu_Categ_controller/'));
	}
}
?>