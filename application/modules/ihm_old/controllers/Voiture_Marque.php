<?php 
/**
 * christa
 * crud de marque de voiture
 */
class Voiture_Marque extends CI_Controller
{
	
	function __construct()
	{
		# code...
		parent::__construct();
	}

	function index()
	{
		$data['title'] = 'Marque de Voiture';
		$this->load->view('Voiture_Marque_List_View',$data);
	}
	function listing()
	{
		$query_principal='SELECT MARQUE_ID,DESCRIOTION FROM `voiture_marque` WHERE 1';


		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit='LIMIT 0,10';


		if($_POST['length'] != -1){
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		$order_by='';



		$order_column=array('MARQUE_ID','DESCRIOTION');

		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY DESCRIOTION ASC';

		$search = !empty($_POST['search']['value']) ? (" AND DESCRIOTION LIKE '%$var_search%' ") : '';     

		$critaire = '';

		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;


		$fetch_marque = $this->Modele->datatable($query_secondaire);
		$data = array();
		foreach ($fetch_marque as $row) {

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->MARQUE_ID . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Voiture_Marque/getOne/'.$row->MARQUE_ID) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->MARQUE_ID . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" .$row->DESCRIOTION."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Voiture_Marque/delete/'.$row->MARQUE_ID) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			$sub_array[]=$row->DESCRIOTION;  
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
		$data['title'] = 'Nouvelle Marque';
		$this->load->view('Voiture_Marque_Add_View',$data);
	}
	function add()
	{
		$this->form_validation->set_rules('DESCRIOTION','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if($this->form_validation->run() == FALSE)
		{
			$this->ajouter();
		}else{

			$data_insert=array(
							'DESCRIOTION'=>$this->input->post('DESCRIOTION')
			                  );

			$table='voiture_marque';
			$this->Modele->create('voiture_marque',$data_insert);

			$data['message']='<div class="alert alert-success text-center" id="message">'."L'enregistrement d'une marque <b>".' '.$this->input->post('DESCRIOTION').'</b> '." est fait avec succès".'</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Voiture_Marque/'));

		}

	}

	function getOne()
	{
		$id=$this->uri->segment(4);
		$data['marque']=$this->Modele->getOne('voiture_marque',array('MARQUE_ID'=>$id));

		$data['title'] = 'Modification - Marque';
		$this->load->view('Voiture_Marque_Update_View',$data);		
	}

	function update()
	{
		$this->form_validation->set_rules('DESCRIOTION','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if ($this->form_validation->run() == FALSE) {
			# code...
			$this->getOne();
		}else{
			$id=$this->input->post('MARQUE_ID');

			$data=array(
			'DESCRIOTION'=>$this->input->post('DESCRIOTION'),
			
			);

			$this->Modele->update('voiture_marque',array('MARQUE_ID'=>$id),$data);
			$datas['message']='<div class="alert alert-success text-center" id="message">La modification de marque '.$this->input->post('DESCRIOTION').'</b> est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Voiture_Marque/'));
		}

	}

	function delete()
	{
		$table="voiture_marque";
		$criteres['MARQUE_ID']=$this->uri->segment(4);
		$data['rows']= $this->Modele->getOne( $table,$criteres);
		$this->Modele->delete($table,$criteres);

		$data['message']='<div class="alert alert-success text-center" id="message">La marque '."".$data['rows']['DESCRIOTION'].' </b> '." est supprimé avec succès".'</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Voiture_Marque/'));

	}
}
 ?>