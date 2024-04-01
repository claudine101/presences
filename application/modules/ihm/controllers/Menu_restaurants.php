<?php 
/**
 * Vanny
 * Gestion de publication de menu
 
 */
class Menu_restaurants extends CI_Controller
{
	
	function __construct()
	{
		# code...
		parent::__construct();
	}
	function index()
	{
     $user= $this->session->userdata('USER_ID');
		$data['title'] = 'Menus des vendeurs';

		// print_r($this->session->userdata('ID_RESTAURANT'));
		// exit();
		$this->load->view('menu_restaurant_view',$data);
	}


    function get_categorie($id=0){

      $menus = $this->Modele->getRequete('SELECT `ID_MENU`,`NOM_MENU` FROM `menu` WHERE `ID_CATEGORIE`='.$id.' ORDER BY `NOM_MENU` ');
	
      $menu= '<option value="">-----Sélectionner----</option>';

      foreach ($menus as $men) {
      $menu.= '<option value="'.$men['ID_MENU'].'">'.$men['NOM_MENU'].'</option>';
      }

      echo $menu;

	}







	function listing()
	{

        $ID_RESTAURANT = !empty($this->input->post('ID_RESTAURANT')) ? $this->input->post('ID_RESTAURANT') : $this->session->userdata('ID_RESTAURANT');
        $ID_CATEGORIE = $this->input->post('ID_CATEGORIE');
        $ID_MENU = $this->input->post('ID_MENU');

        $critere_rest = ($ID_RESTAURANT != 0 ||  !empty($ID_RESTAURANT)) ?' and r.ID_RESTAURANT='.$ID_RESTAURANT : "";
        $critere_categ = ($ID_CATEGORIE != 0 ||  !empty($ID_CATEGORIE)) ?' and c.ID_CATEGORIE='.$ID_CATEGORIE : "";
        $critere_menu = ($ID_MENU != 0 ||  !empty($ID_MENU)) ?' and r.ID_MENU='.$ID_MENU : "";

		$critere= $critere_rest.$critere_categ.$critere_menu;

		$query_principal='SELECT r.PRIX,r.ID_MENU_RESTAURANT, menu.NOM_MENU,c.NOM_CATEGORIE,menu.IMAGE_1,menu.IMAGE_2,menu.IMAGE_3,menu.DESCRIPTION FROM menu_restaurants r JOIN menu ON menu.ID_MENU=r.ID_MENU JOIN menu_categories c on c.ID_CATEGORIE=menu.ID_CATEGORIE WHERE 1 '.$critere;


		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit='LIMIT 0,10';

		if($_POST['length'] != -1){
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		$order_by='';



		$order_column=array('NOM_CATEGORIE','NOM_MENU','PRIX_1');

		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM_CATEGORIE,NOM_MENU ASC';

		$search = !empty($_POST['search']['value']) ? (" AND NOM_CATEGORIE LIKE '%$var_search%' OR NOM_MENU LIKE '%$var_search%'") : '';    

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
			data-target='#mydelete" .$row->ID_MENU_RESTAURANT."'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='".base_url('ihm/Menu_restaurants/getOne/'.md5($row->ID_MENU_RESTAURANT)) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete".$row->ID_MENU_RESTAURANT."'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" .$row->NOM_MENU." du ".$row->NOM_CATEGORIE."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Menu_restaurants/delete/'.$row->ID_MENU_RESTAURANT)."'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>

			<div class='modal fade' id='mydetail".$row->ID_MENU_RESTAURANT."'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center>
			<p><b>".$row->NOM_CATEGORIE." : ".$row->NOM_MENU."</b></p>
            
			<img style='height:150px' src='".$row->IMAGE_1."'>

			<img style='height:150px' src='".$row->IMAGE_2."'>

			<img style='height:150px' src='".$row->IMAGE_2."'>

			<p><b>".$row->NOM_MENU." </b></p>
            <p>".$row->DESCRIPTION."</p>
			</center>
			</div>

			<div class='modal-footer'>
			
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>


			";

			$sub_array = array();
			$sub_array[]="<a hre='#' data-toggle='modal' data-target='#mydetail" .$row->ID_MENU_RESTAURANT."' target='_blank'><img style='border-radius:50%;width:40px;height:40px' src='".$row->IMAGE_1."'></a>";
			$sub_array[]=$row->NOM_CATEGORIE;
			$sub_array[]=$row->NOM_MENU;
			$sub_array[]='<span style="float:right;">'.str_replace(",", " ", number_format($row->PRIX)).' BIF</span>';
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

		$user_resto = $this->session->userdata('ID_RESTAURANT');

		$condution = ($user_resto == 0) ? "" : " and ID_RESTAURANT = ".$user_resto;
		
		$data['restaurants'] = $this->Modele->getRequete('SELECT ID_RESTAURANT,NOM_RESTAURANT FROM `restaurants` WHERE 1'.$condution.' ORDER BY NOM_RESTAURANT');

		$data['menu_categories'] = $this->Modele->getRequete('SELECT ID_CATEGORIE, NOM_CATEGORIE FROM `menu_categories` WHERE 1 ORDER BY NOM_CATEGORIE');
       // $id=$this->uri->segment(4);
		$data['title'] = 'Nouveau menu du vendeurs';
		$this->load->view('Menu_resto_Add_View',$data);
		
	}





	function add()
	{

			
			$data_insert=array(

				'ID_RESTAURANT'=>$this->input->post('ID_RESTAURANT'),

				'ID_MENU'=>$this->input->post('ID_MENU'),

				'PRIX'=>$this->input->post('PRIX'),

				
			);

			//print_r($data_insert);


		
			$table='menu_restaurants';
			$this->Modele->create($table,$data_insert);

			$data['message']='<div class="alert alert-success text-center" id="message">'."L'enregistrement est faite avec succès".'</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Menu_restaurants/ajouter'));


	}

	function getOne()
	{
		$id=$this->uri->segment(4);


		$data['menu'] = $this->Modele->getRequete('SELECT ID_MENU, NOM_MENU FROM `menu` WHERE 1');


		$data['trove']=$this->Modele->getRequeteOne('SELECT * FROM `menu_restaurants` WHERE 1 and md5(ID_MENU_RESTAURANT)="'.$id.'"');

		$data['title'] = 'Modification - menu du vendeur';
		$this->load->view('Menu_resto_Update_View',$data);		
	}

	function update()
	{
		//$this->form_validation->set_rules('ID_RESTAURANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('ID_MENU','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PRIX_1','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		if ($this->form_validation->run() == FALSE) {
			$id=$this->input->post('ID_MENU_RESTAURANT');


			$this->getOne($id);
		}else{
			$id=$this->input->post('ID_MENU_RESTAURANT');

			$data=array(
				//'ID_RESTAURANT'=>$this->input->post('ID_RESTAURANT'),
				'ID_MENU'=>$this->input->post('ID_MENU'),
				'PRIX_1'=>$this->input->post('PRIX_1'),
			);

			$this->Modele->update('menu_restaurants',array('ID_MENU_RESTAURANT'=>$id),$data);
			$datas['message']='<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Menu_restaurants/'));
		}

	}

	function delete()
	{
		$table="Menu_restaurants";
		$criteres['ID_MENU_RESTAURANT']=$this->uri->segment(4);
		$data['rows']= $this->Modele->getOne( $table,$criteres);
		$this->Modele->delete($table,$criteres);

		$data['message']='<div class="alert alert-success text-center" id="message">Le menu  est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Menu_restaurants'));
	}
}
?>