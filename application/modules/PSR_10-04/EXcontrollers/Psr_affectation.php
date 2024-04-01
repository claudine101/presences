<?php
/**
*Allan
*	Affectation d'un policien 
**/
class Psr_affectation extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		if ($this->session->userdata('AFFECTATION')!=1) {

			redirect(base_url());

		}
	}
	function index()
	{
		$data['title'] = 'Affectation des policien';
		$this->load->view('psr_affectation_list_v',$data);
	}

	function listing()
	{
		$i=1;
		$query_principal="SELECT pa.PSR_AFFECTATION_ID,concat( pe.NOM,' ',pe.PRENOM) AS Nom, pe.NUMERO_MATRICULE as NUMERO_MATRICULE, sp.PROVINCE_NAME AS province, sc.COMMUNE_NAME AS commune ,sz.ZONE_NAME AS zone, sco.COLLINE_NAME AS Colline, LIEU_EXACTE, pa.LATITUDE, pa.LONGITUDE FROM psr_affectatations pa LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT=pa.ID_PSR_ELEMENT LEFT JOIN syst_provinces sp ON sp.PROVINCE_ID=pa.PROVINCE_ID LEFT JOIN syst_communes sc ON sc.COMMUNE_ID=pa.COMMUNE_ID LEFT JOIN syst_zones sz ON sz.ZONE_ID=pa.ZONE_ID LEFT JOIN syst_collines sco ON sco.COLLINE_ID= pa.COLLINE_ID WHERE 1";

		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit='LIMIT 0,10';


		if($_POST['length'] != -1){
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}

		$order_by='';


		$order_column=array('Nom','NUMERO_MATRICULE','province','commune','zone','Colline','LIEU_EXACTE');

		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY Nom ASC';

		$search = !empty($_POST['search']['value']) ? ("AND Nom LIKE '%$var_search%' OR province LIKE '%$var_search%' OR commune LIKE '%$var_search%'  "):'';     

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
			data-target='#mydelete" . $row->PSR_AFFECTATION_ID . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Psr_affectation/getOne/'.$row->PSR_AFFECTATION_ID) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .$row->PSR_AFFECTATION_ID. "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>".$row->Nom."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Psr_affectation/delete/'.$row->PSR_AFFECTATION_ID) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			$sub_array[]=$i++;
			$sub_array[]=$row->Nom; 
			$sub_array[]=$row->NUMERO_MATRICULE;
			$sub_array[]=$row->province;
			$sub_array[]=$row->commune; 
			$sub_array[]=$row->zone; 
			$sub_array[]=$row->Colline; 
			$sub_array[]=$row->LIEU_EXACTE;						
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
		$data['provinces']=$this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
		$data['policien']=$this->Model->getRequete('SELECT ID_PSR_ELEMENT,NUMERO_MATRICULE FROM psr_elements WHERE 1 ORDER BY NUMERO_MATRICULE ASC');

		$data['title'] = 'Nouvelle Affectation';
		$this->load->view('psr_affectation_add_v',$data);

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

		$this->form_validation->set_rules('LIEU_EXACTE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('LATITUDE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('LONGITUDE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));



		if($this->form_validation->run() == FALSE)
		{
			$this->ajouter();
		}else{

			$data_insert=array(
				'ID_PSR_ELEMENT'=>$this->input->post('police'),
				'PROVINCE_ID'=>$this->input->post('ID_PROVINCE'),
				'COMMUNE_ID'=>$this->input->post('ID_COMMUNE'),
				'ZONE_ID'=>$this->input->post('ID_ZONE'),
				'COLLINE_ID'=>$this->input->post('ID_COLLINE'),
				'LIEU_EXACTE'=>$this->input->post('LIEU_EXACTE'),
				'LATITUDE'=>$this->input->post('LATITUDE'),
				'LONGITUDE'=>$this->input->post('LONGITUDE'),
			);
			$table='psr_affectatations';
			$this->Modele->create($table,$data_insert);

			$data['message']='<div class="alert alert-success text-center" id="message">'."L'ajout se faite avec succès".'</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Psr_affectation/index'));

		}

	}
	function getOne($id=0)
	{
		
		$membre=$this->Modele->getRequeteOne('SELECT PSR_AFFECTATION_ID, ID_PSR_ELEMENT, PROVINCE_ID, COMMUNE_ID, ZONE_ID, COLLINE_ID, LIEU_EXACTE, LATITUDE, LONGITUDE FROM psr_affectatations WHERE PSR_AFFECTATION_ID='.$id);

		$data['membre']=$membre;
		$data['policien']=$this->Model->getRequete('SELECT ID_PSR_ELEMENT,NUMERO_MATRICULE FROM psr_elements WHERE 1 ORDER BY NUMERO_MATRICULE ASC');
		$data['provinces']=$this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
		$data['communes']=$this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID='.$membre['PROVINCE_ID'].' ORDER BY COMMUNE_NAME ASC');
		$data['zones']=$this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID='.$membre['COMMUNE_ID'].' ORDER BY ZONE_NAME ASC');
		$data['collines']=$this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID='.$membre['ZONE_ID'].' ORDER BY COLLINE_NAME ASC');
		
		$data['title'] = "Modification d'un Police";
		$this->load->view('psr_affectation_update_v',$data);
	}

	function update()
	{
		
		$this->form_validation->set_rules('LIEU_EXACTE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('LATITUDE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('LONGITUDE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$id=$this->input->post('PSR_AFFECTATION_ID');

		if ($this->form_validation->run() == FALSE) {

			$this->getOne();
		}else{
			$id=$this->input->post('PSR_AFFECTATION_ID');

			$data=array(
				'ID_PSR_ELEMENT'=>$this->input->post('police'),
				'PROVINCE_ID'=>$this->input->post('ID_PROVINCE'),
				'COMMUNE_ID'=>$this->input->post('ID_COMMUNE'),
				'ZONE_ID'=>$this->input->post('ID_ZONE'),
				'COLLINE_ID'=>$this->input->post('ID_COLLINE'),
				'LIEU_EXACTE'=>$this->input->post('LIEU_EXACTE'),
				'LATITUDE'=>$this->input->post('LATITUDE'),
				'LONGITUDE'=>$this->input->post('LONGITUDE'),
			);

			$this->Modele->update('psr_affectatations',array('PSR_AFFECTATION_ID'=>$id),$data);
			$datas['message']='<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('PSR/Psr_affectation/index'));
		}
	}

	function delete()
	{
		$table="psr_affectatations";
		$criteres['PSR_AFFECTATION_ID']=$this->uri->segment(4);
		$data['rows']= $this->Modele->getOne( $table,$criteres);
		$this->Modele->delete($table,$criteres);

		$data['message']='<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Psr_affectation/index'));
	}

}
?>



