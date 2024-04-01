<?php

/**
 *Allan
 *	Affectation d'un policien 
 **/
class Poste_Pnb extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		if ($this->session->userdata('RH_POSTE') != 1) {

			redirect(base_url());
		}
	}
	function index()
	{

		$data['title'] = 'Poste de contrôle de la PNB';
		$this->load->view('post_list_view', $data);
	}
	//POUR  RETOURNER  NBRE DES AGENTS PAR  POSTE
	function nbre_agents($id){
		$nbre = $this->Modele->getRequeteOne('SELECT COUNT(pea.ELEMENT_AFFECT_ID) as nombre FROM psr_affectatations pa LEFT JOIN  psr_element_affectation pea ON pea.PSR_AFFECTATION_ID=pa.PSR_AFFECTATION_ID WHERE pa.PSR_AFFECTATION_ID= '.$id.'  AND IS_ACTIVE=1');
      return  !empty($nbre['nombre']) ? $nbre['nombre'] : 0;

	}
	function listing()
	{
		$i = 1;
		$query_principal = "SELECT pa.PSR_AFFECTATION_ID,sp.PROVINCE_NAME , sc.COMMUNE_NAME  ,sz.ZONE_NAME , sco.COLLINE_NAME , LIEU_EXACTE, pa.LATITUDE, pa.LONGITUDE FROM psr_affectatations pa LEFT JOIN syst_provinces sp ON sp.PROVINCE_ID=pa.PROVINCE_ID LEFT JOIN syst_communes sc ON sc.COMMUNE_ID=pa.COMMUNE_ID LEFT JOIN syst_zones sz ON sz.ZONE_ID=pa.ZONE_ID LEFT JOIN syst_collines sco ON sco.COLLINE_ID= pa.COLLINE_ID WHERE 1 ";

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';


		$order_column = array('PROVINCE_NAME', 'COMMUNE_NAME', 'ZONE_NAME', 'COLLINE_NAME', 'LIEU_EXACTE');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : 'ORDER BY PROVINCE_NAME,COMMUNE_NAME,ZONE_NAME,COLLINE_NAME,LIEU_EXACTE ASC';

		$search = !empty($_POST['search']['value']) ? ("AND  sp.PROVINCE_NAME LIKE '%$var_search%' OR sc.COMMUNE_NAME LIKE '%$var_search%'  OR sz.ZONE_NAME LIKE '%$var_search%' OR sco.COLLINE_NAME LIKE '%$var_search%' OR LIEU_EXACTE LIKE '%$var_search%' ") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_psr = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_psr as $row) {

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->PSR_AFFECTATION_ID . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Poste_Pnb/getOne/' . $row->PSR_AFFECTATION_ID) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>
			<li><a class='btn-md' href='#'  ' onclick='affectation_new(".$row->PSR_AFFECTATION_ID.")'><label class='text-success'>&nbsp;&nbsp;Affecter</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" . $row->PSR_AFFECTATION_ID . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer le poste de ?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->LIEU_EXACTE . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Poste_Pnb/delete/' . $row->PSR_AFFECTATION_ID) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			//$sub_array[]=$i++;
			$sub_array[] = $row->PROVINCE_NAME;
			$sub_array[] = $row->COMMUNE_NAME;
			$sub_array[] = $row->ZONE_NAME;
			$sub_array[] = $row->COLLINE_NAME;
			$nbre = $this->nbre_agents($row->PSR_AFFECTATION_ID);
	          $sub_array[] ="
                <a class = 'btn btn-success btn-sm ' onclick='affectation_new(".$row->PSR_AFFECTATION_ID.")' style='float:right' ><span class = ''>".$nbre."</span></a>";
			$sub_array[] = $row->LIEU_EXACTE;
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

	function ajouter()
	{
		$data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');

		$data['title'] = 'Nouveau Poste de PNB';
		$this->load->view('post_add_view', $data);
	}

	function get_communes($ID_PROVINCE = 0)
	{
		$communes = $this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID=' . $ID_PROVINCE . ' ORDER BY COMMUNE_NAME ASC');
		$html = '<option value="">---selectionner---</option>';
		foreach ($communes as $key) {
			$html .= '<option value="' . $key['COMMUNE_ID'] . '">' . $key['COMMUNE_NAME'] . '</option>';
		}
		echo json_encode($html);
	}

	function get_zones($ID_COMMUNE = 0)
	{
		$zones = $this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID=' . $ID_COMMUNE . ' ORDER BY ZONE_NAME ASC');
		$html = '<option value="">---selectionner---</option>';
		foreach ($zones as $key) {
			$html .= '<option value="' . $key['ZONE_ID'] . '">' . $key['ZONE_NAME'] . '</option>';
		}
		echo json_encode($html);
	}

	function get_collines($ID_ZONE = 0)
	{
		$collines = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID=' . $ID_ZONE . ' ORDER BY COLLINE_NAME ASC');
		$html = '<option value="">---selectionner---</option>';
		foreach ($collines as $key) {
			$html .= '<option value="' . $key['COLLINE_ID'] . '">' . $key['COLLINE_NAME'] . '</option>';
		}
		echo json_encode($html);
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

		$this->form_validation->set_rules('LIEU_EXACTE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));



		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$data_insert = array(

				'PROVINCE_ID' => $this->input->post('ID_PROVINCE'),
				'COMMUNE_ID' => $this->input->post('ID_COMMUNE'),
				'ZONE_ID' => $this->input->post('ID_ZONE'),
				'COLLINE_ID' => $this->input->post('ID_COLLINE'),
				'LIEU_EXACTE' => $this->input->post('LIEU_EXACTE'),
				'LATITUDE' => $this->input->post('LATITUDE'),
				'LONGITUDE' => $this->input->post('LONGITUDE'),
			);
			$table = 'psr_affectatations';
			$this->Modele->create($table, $data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Poste_Pnb/index'));
		}
	}
	function getOne($id = 0)
	{

		$membre = $this->Modele->getRequeteOne('SELECT * FROM psr_affectatations WHERE PSR_AFFECTATION_ID=' . $id);

		$data['membre'] = $membre;

		$co = !empty($membre['PROVINCE_ID']) ? $membre['PROVINCE_ID'] : 0;
		$z = !empty($membre['COMMUNE_ID']) ? $membre['COMMUNE_ID'] : 0;
		$col = !empty($membre['ZONE_ID']) ? $membre['ZONE_ID'] : 0;


		$data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
		$data['communes'] = $this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID=' .$co. ' ORDER BY COMMUNE_NAME ASC');
		$data['zones'] = $this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID=' . $z . ' ORDER BY ZONE_NAME ASC');
		$data['collines'] = $this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID=' . $col . ' ORDER BY COLLINE_NAME ASC');

		$data['title'] = "Modification poste " . $membre['LIEU_EXACTE'];
		$this->load->view('poste_update', $data);
	}

	function update()
	{

		$this->form_validation->set_rules('LIEU_EXACTE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('LATITUDE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('LONGITUDE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$id = $this->input->post('PSR_AFFECTATION_ID');

		if ($this->form_validation->run() == FALSE) {

			$this->getOne($id);
		} else {
			$id = $this->input->post('PSR_AFFECTATION_ID');

			$data = array(

				'PROVINCE_ID' => $this->input->post('ID_PROVINCE'),
				'COMMUNE_ID' => $this->input->post('ID_COMMUNE'),
				'ZONE_ID' => $this->input->post('ID_ZONE'),
				'COLLINE_ID' => $this->input->post('ID_COLLINE'),
				'LIEU_EXACTE' => $this->input->post('LIEU_EXACTE'),
				'LATITUDE' => $this->input->post('LATITUDE'),
				'LONGITUDE' => $this->input->post('LONGITUDE'),
			);

			$this->Modele->update('psr_affectatations', array('PSR_AFFECTATION_ID' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('PSR/Poste_Pnb/index'));
		}
	}

	function delete()
	{
		$table = "psr_affectatations";
		$criteres['PSR_AFFECTATION_ID'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Poste_Pnb/index'));
	}
}
