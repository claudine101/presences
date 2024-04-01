<?php 
/**
 Alphonse 22h dimanche
 */
class Menu extends CI_Controller
{
	
	function __construct()
	{
		# code...
		parent::__construct();
	}
	function index()
	{

		$data['title'] = 'Gestion des menus';
     
		$this->load->view('menu_liste',$data);
	}

	function listing()
	{ 
		$ID_RESTAURANT=$this->input->post('resto');
		$critere='';
		
		$query_principal='SELECT ID_MENU,menu_categories.NOM_CATEGORIE, NOM_MENU, DESCRIPTION, IMAGE_1 FROM menu LEFT JOIN menu_categories ON menu_categories.ID_CATEGORIE=menu.ID_CATEGORIE WHERE 1';



		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		

		$limit='LIMIT 0,10';


		if($_POST['length'] != -1){
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		$order_by='';



		$order_column=array('NOM_MENU','NOM_CATEGORIE','DESCRIPTION','IMAGE_1','IMAGE_2','IMAGE_3');

		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM_MENU,NOM_CATEGORIE ASC';

		$search = !empty($_POST['search']['value']) ? (" AND NOM_MENU LIKE '%$var_search%' OR NOM_CATEGORIE LIKE '%$var_search%' OR DESCRIPTION LIKE '%$var_search%'") : '';     

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
			data-target='#mydelete" . $row->ID_MENU . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Menu/getOne/'.md5($row->ID_MENU)) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
	

			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_MENU . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><p>Voulez-vous supprimer?<br><b style='background-color:prink;color:green;'><i>" .$row->NOM_CATEGORIE."</i></b></p></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Menu/delete/'.$row->ID_MENU) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			$sub_array[]= '<a href="'.$row->IMAGE_1.'" target="_blank" ><img style="border-radius:50%;width:40px;height:40px" src="'.$row->IMAGE_1.'"></a>';
			$sub_array[]='<span style="float:right;">'.$row->NOM_CATEGORIE.'</span>';

			$sub_array[]='<span style="float:right;">'.$row->NOM_MENU.'</span>';
			
			$sub_array[]='<span style="float:right;" title="'.$row->DESCRIPTION.'">'.substr($row->DESCRIPTION, 0,15).'</span>'; 
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

		$data['marque'] = $this->Modele->getRequete('SELECT ID_CATEGORIE,NOM_CATEGORIE FROM `menu_categories` WHERE 1');

		$data['title'] = 'Nouveau Menu';
		$this->load->view('menu_add',$data);

	}






	function add(){ 

		
		$file= $_FILES['PHOTO_UNE'];

        $path='./upload/autre_imag_catego/';
        if(!is_dir(FCPATH.'/upload/autre_imag_catego/')){
         mkdir(FCPATH.'/upload/autre_imag_catego/', 0777, TRUE);
        }
        
        $thepath= base_url().'upload/autre_imag_catego/';
        $config['upload_path']= './upload/autre_imag_catego/';
        $photonames= date('ymdHisa');
        $config['file_name']=$photonames;
        $config['allowed_types']= '*';
        $this->upload->initialize($config);
        $this->upload->do_upload("PHOTO_UNE");
        $info=$this->upload->data();

        if($file==''){
          $pathfile= base_url().'uploads/sevtb.png';
        }else{
          $pathfile= base_url().'upload/autre_imag_catego/'.$photonames.$info['file_ext'];
        }

        //print_r($photonames.$info['file_ext']);
             

		$data_insert=array(

				'NOM_MENU'=>$this->input->post('NOM_MENU'),

				'ID_CATEGORIE'=>$this->input->post('ID_CATEGORIE'),

				'DESCRIPTION'=>$this->input->post('DESCRIPTION'),

				'IMAGE_1'=>$pathfile,
			);

			$table='menu';
			$this->Modele->create($table,$data_insert);

			$data['message']='<div class="alert alert-success text-center" id="message">'."L'enregistrement du menu est faite avec succès".'</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Menu/index'));

		

	}






	function getOne()
	{
		$id=$this->uri->segment(4);

		$data['marque'] = $this->Modele->getRequete('SELECT ID_CATEGORIE,NOM_CATEGORIE FROM `menu_categories` WHERE 1');


		$data['piece']=$this->Modele->getRequeteOne('SELECT * FROM `menu` WHERE 1 and md5(ID_MENU)="'.$id.'"');

		$data['title'] = '🏷️ Modification du menu';
		$this->load->view('Gestion_Publication_Menu_Update_View',$data);		
	}

	function update()
	{
		$this->form_validation->set_rules('ID_CATEGORIE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NOM_MENU','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DESCRIPTION','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		$id=$this->input->post('ID_MENU');

		if ($this->form_validation->run() == FALSE) {

			$this->getOne($id);
		}else{


	    $file= $_FILES['PHOTO_DEUX'];

        $path='./upload/autre_imag_catego/';
        if(!is_dir(FCPATH.'/upload/autre_imag_catego/')){
         mkdir(FCPATH.'/upload/autre_imag_catego/', 0777, TRUE);
        }
        
        $thepath= base_url().'upload/autre_imag_catego/';
        $config['upload_path']= './upload/autre_imag_catego/';
        $photonames= date('ymdHisa');
        $config['file_name']=$photonames;
        $config['allowed_types']= '*';
        $this->upload->initialize($config);
        $this->upload->do_upload("PHOTO_DEUX");
        $info=$this->upload->data();

        if($file==''){
          $pathfile= base_url().'uploads/sevtb.png';
        }else{
          $pathfile= base_url().'upload/autre_imag_catego/'.$photonames.$info['file_ext'];
        }




			$id=$this->input->post('ID_MENU');

			$data=array(
				'ID_CATEGORIE'=>$this->input->post('ID_CATEGORIE'),
				'NOM_MENU'=>$this->input->post('NOM_MENU'),
				'DESCRIPTION'=>$this->input->post('DESCRIPTION'),
				'IMAGE_1'=>$pathfile,

		);

			$this->Modele->update('menu',array('ID_MENU'=>$id),$data);
			$datas['message']='<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Menu/'));
		}

	}

	function delete()
	{
		$table="menu";
		$criteres['ID_MENU']=$this->uri->segment(4);
		$data['rows']= $this->Modele->getOne( $table,$criteres);
		$this->Modele->delete($table,$criteres);

		$data['message']='<div class="alert alert-success text-center" id="message">Le menu est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Menu/'));
	}
}

?>