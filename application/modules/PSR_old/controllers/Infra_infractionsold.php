<?php
/**
*NTAHIMPERA Martin Luther King
*	Infractions 
**/
class  Infra_infractions extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}


	public function have_droit()
	{
		if ($this->session->userdata('INFRACTION')!=1) {

			redirect(base_url());

		}

	}

	function index()
	{ 
		$type_verification=$this->Modele->getRequete(' SELECT ID_TYPE_VERIFICATION, VERIFICATION FROM type_verification WHERE 1 ORDER BY VERIFICATION');
		$data['type_verification']=$type_verification;
		$data['title'] = 'Infractions';
		$this->load->view('infractions_list_view',$data);
	}

	function listing()
	{
		$i=1; 

		 $verifications= $this->input->post('ID_TYPE_VERIFICATION');

		 $critere_command = !empty($verifications) ? "and type_verification.ID_TYPE_VERIFICATION= ".$verifications." " : "";


		$query_principal='SELECT ID_INFRA_INFRACTION,NIVEAU_ALERTE,type_verification.ID_TYPE_VERIFICATION,type_verification.VERIFICATION FROM infra_infractions JOIN type_verification ON type_verification.ID_TYPE_VERIFICATION=infra_infractions.ID_TYPE_VERIFICATION WHERE 1 '.$critere_command.' ';

		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit='LIMIT 0,10';


		if($_POST['length'] != -1){
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}

		$order_by='';

		$order_column=array('ID_INFRA_INFRACTION','NIVEAU_ALERTE','VERIFICATION');

		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NIVEAU_ALERTE ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NIVEAU_ALERTE LIKE '%$var_search%'"):'';     

		$critaire = '';

		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;

		$fetch_infraction = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_infraction as $row)
		{

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_INFRA_INFRACTION . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Infra_infractions/getOne/'.$row->ID_INFRA_INFRACTION) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_INFRA_INFRACTION . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" .$row->NIVEAU_ALERTE." ".$row->VERIFICATION."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Infra_infractions/delete/'.$row->ID_INFRA_INFRACTION) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			//$sub_array[]=$i++;
			$sub_array[]=$row->NIVEAU_ALERTE;
			$sub_array[]=$row->VERIFICATION; 			
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
		$data['verifications']=$this->Model->getRequete('SELECT ID_TYPE_VERIFICATION, VERIFICATION FROM type_verification WHERE 1 ORDER BY VERIFICATION ASC');
		$data['title'] = 'Nouveau Infraction';
		$this->load->view
		('infractions_add_view',$data);

	}

	function add()
	{

		$this->form_validation->set_rules('NIVEAU_ALERTE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_TYPE_VERIFICATION','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		if($this->form_validation->run() == FALSE)
		{
			$this->ajouter();
		}else{

			$data_insert=array(
				'NIVEAU_ALERTE'=>$this->input->post('NIVEAU_ALERTE'),
				'ID_TYPE_VERIFICATION'=>$this->input->post('ID_TYPE_VERIFICATION'),
			);

			$table='infra_infractions';
			$this->Modele->create($table,$data_insert);

			$data['message']='<div class="alert alert-success text-center" id="message">'."L'ajout se faite avec succès".'</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Infra_infractions/'));

		}

	}
	function getOne($id='')
	{

		$data['infra']=$this->Modele->getOne('infra_infractions',array('ID_INFRA_INFRACTION'=>$id));
		$data['verifications']=$this->Model->getRequete('SELECT ID_TYPE_VERIFICATION, VERIFICATION FROM type_verification WHERE 1 ORDER BY VERIFICATION ASC');
		$data['title'] = 'Modification infraction';
		$this->load->view('infractions_update_view',$data);
	}

	function update()
	{
		$this->form_validation->set_rules('NIVEAU_ALERTE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		
		$this->form_validation->set_rules('ID_TYPE_VERIFICATION','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		
		$id =$this->input->post('ID_INFRA_INFRACTION');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		}else{
			$id=$this->input->post('ID_INFRA_INFRACTION');

			$data_update=array(
				'NIVEAU_ALERTE'=>$this->input->post('NIVEAU_ALERTE'),
				'ID_TYPE_VERIFICATION'=>$this->input->post('ID_TYPE_VERIFICATION'),
			);

			$this->Modele->update('infra_infractions',array('ID_INFRA_INFRACTION'=>$id),$data_update);
			$datas['message']='<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('PSR/Infra_infractions/'));
		}
	}

	function delete()
	{
		$table="infra_infractions";
		$criteres['ID_INFRA_INFRACTION']=$this->uri->segment(4);
		$data['rows']= $this->Modele->getOne( $table,$criteres);
		$this->Modele->delete($table,$criteres);

		$data['message']='<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Infra_infractions'));
	}

}
