<?php

/**
 *NTAHIMPERA Martin Luther King
 *	Element de la police 
 **/
class Droit extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}
	public function have_droit()
	{
		if ($this->session->userdata('PARAMETRE') != 1) {

			redirect(base_url());
		}
	}
	function index()
	{
		$data['title'] = 'Matrice';
		$this->load->view('droit/droit_list', $data);
	}
	function listing()
	{
		$i = 1;
		$query_principal = 'SELECT ID_DROIT, INSTITUTION , INFRACTION, PSR_ELEMENT, PEINES, AFFECTATION, PERMIS, DECLARATION, IMMATRICULATION, CONTROLE_TECHNIQUE, ASSURANCE,QUESTIONNAIRE, pr.STATUT AS STATUS,SIGNALEMENT,VALIDATEUR ,POLICE_JUDICIAIRE,TRANSPORT,PARAMETRE, TB_PJ, TB_ASSURANCE, TB_IMMATRICULATION, TB_PERMIS, TB_FINANCIER, TB_AMANDE, TB_POLICE, TB_SIGNALMENT, TB_CONSTANT, TB_CONTROLE_RAPIDE, TB_AUTRE_CONTROLE, MAP_CENTRE_SITUATION, MAP_AGENT_POLICE, MAP_SIGNALEMENT, CONFIGURATION_DATA, IHM, RH_FONCTIONNAIRE, RH_POSTE, RH_AFFECTATION, VERIFICATION, CONSTANT_SUR_CONTROLE ,FOURRIERE,CHEF_MENAGE,GESTION_CHEF_MENAGE,TB_TRANSPORT,TB_CONTROLE_TECHNIQUE FROM droits dr LEFT JOIN profil pr ON pr.PROFIL_ID=dr.PROFIL_ID WHERE 1';
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,10';
		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';
		$order_column = array('STATUS', 'INFRACTION', 'PSR_ELEMENT', 'PEINES', 'AFFECTATION', 'PERMIS', 'DECLARATION', 'IMMATRICULATION', 'CONTROLE_TECHNIQUE', 'ASSURANCE', 'QUESTIONNAIRE', 'STATUT', 'SIGNALEMENT', 'VALIDATEUR','POLICE_JUDICIAIRE','TRANSPORT','PARAMETRE', 'TB_PJ', 'TB_ASSURANCE', 'TB_IMMATRICULATION', 'TB_PERMIS', 'TB_FINANCIER', 'TB_AMANDE', 'TB_POLICE', 'TB_SIGNALMENT', 'TB_CONSTANT', 'TB_CONTROLE_RAPIDE', 'TB_AUTRE_CONTROLE', 'MAP_CENTRE_SITUATION', 'MAP_AGENT_POLICE', 'MAP_SIGNALEMENT', 'CONFIGURATION_DATA', 'IHM', 'RH_FONCTIONNAIRE', 'RH_POSTE', 'RH_AFFECTATION', 'VERIFICATION', 'CONSTANT_SUR_CONTROLE' ,'FOURRIERE','CHEF_MENAGE','GESTION_CHEF_MENAGE','GESTION_CHEF_MENAGE','INSTITUTION','TB_TRANSPORT','TB_CONTROLE_TECHNIQUE' );


		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY PEINES,PERMIS ASC';

		$search = !empty($_POST['search']['value']) ? ("AND STATUT LIKE '%$var_search%' ") : '';

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
			data-target='#mydelete" . $row->ID_DROIT . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Droit/getOne/' . $row->ID_DROIT) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_DROIT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->ID_DROIT . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Droit/delete/' . $row->ID_DROIT) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			// $sub_array[] = $i++;
			$sub_array[] = $row->STATUS;
			$sub_array[] = $row->INFRACTION == 1 ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->PSR_ELEMENT ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->PEINES ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->AFFECTATION ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->PERMIS ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->DECLARATION ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->IMMATRICULATION ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->CONTROLE_TECHNIQUE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->ASSURANCE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->QUESTIONNAIRE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->SIGNALEMENT ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->VALIDATEUR ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->POLICE_JUDICIAIRE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->TRANSPORT ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->PARAMETRE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->TB_PJ ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->TB_ASSURANCE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->TB_IMMATRICULATION ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->TB_PERMIS ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->TB_FINANCIER ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->TB_AMANDE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->TB_POLICE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->TB_SIGNALMENT ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->TB_CONSTANT ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->TB_CONTROLE_RAPIDE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->TB_AUTRE_CONTROLE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			
			$sub_array[] = $row->MAP_CENTRE_SITUATION ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->MAP_AGENT_POLICE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->MAP_SIGNALEMENT ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>'; 
			$sub_array[] = $row->CONFIGURATION_DATA ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->RH_FONCTIONNAIRE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->IHM ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->RH_POSTE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->RH_AFFECTATION ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->VERIFICATION ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->CONSTANT_SUR_CONTROLE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->FOURRIERE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->CHEF_MENAGE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->GESTION_CHEF_MENAGE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';

			$sub_array[] = $row->INSTITUTION ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->TB_TRANSPORT ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
			$sub_array[] = $row->TB_CONTROLE_TECHNIQUE ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
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
		$data['profils'] = $this->Model->getRequete('SELECT PROFIL_ID, STATUT FROM profil WHERE 1 ORDER BY STATUT ASC');
		$data['title'] = 'Nouveau élément';
		$this->load->view('droit/droit_add_v', $data);
	}




	function add()
	{

		$this->form_validation->set_rules('PROFIL_ID', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {
			if ($this->input->post('INFRACTION') != null) {
				$infraction = 1;
			} else {
				$infraction = 0;
			}
			if ($this->input->post('PSR_ELEMENT') != null) {
				$psr = 1;
			} else {
				$psr = 0;
			}
			if ($this->input->post('PEINES') != null) {
				$peines = 1;
			} else {
				$peines = 0;
			}
			if ($this->input->post('AFFECTATION') != null) {
				$affectation = 1;
			} else {
				$affectation = 0;
			}
			if ($this->input->post('PERMIS') != null) {
				$permis = 1;
			} else {
				$permis = 0;
			}
			if ($this->input->post('DECLARATION') != null) {
				$declaration = 1;
			} else {
				$declaration = 0;
			}
			if ($this->input->post('IMMATRICULATION') != null) {
				$immatriculation = 1;
			} else {
				$immatriculation = 0;
			}
			if ($this->input->post('CONTROLE_TECHNIQUE') != null) {
				$controle = 1;
			} else {
				$controle = 0;
			}
			if ($this->input->post('ASSURANCE') != null) {
				$assurance = 1;
			} else {
				$assurance = 0;
			}
			if ($this->input->post('QUESTIONNAIRE') != null) {
				$questionnaire = 1;
			} else {
				$questionnaire = 0;
			}

			if ($this->input->post('SIGNALEMENT') != null) {
				$signalement = 1;
			} else {
				$signalement = 0;
			}

			if ($this->input->post('VALIDATEUR') != null) {
				$validateur = 1;
			} else {
				$validateur = 0;
			}
			if ($this->input->post('POLICE_JUDICIAIRE') != null) {
				$POLICE_JUDICIAIRE = 1;
			} else {
				$POLICE_JUDICIAIRE = 0;
			}
			if ($this->input->post('TRANSPORT') != null) {
				$TRANSPORT = 1;
			} else {
				$TRANSPORT = 0;
			}
			if ($this->input->post('PARAMETRE') != null) {
				$PARAMETRE = 1;
			} else {
				$PARAMETRE = 0;
			}
			if ($this->input->post('TB_PJ') != null) {
				$TB_PJ = 1;
			} else {
				$TB_PJ = 0;
			}
			if ($this->input->post('TB_ASSURANCE') != null) {
				$TB_ASSURANCE = 1;
			} else {
				$TB_ASSURANCE = 0;
			}
			if ($this->input->post('TB_IMMATRICULATION') != null) {
				$TB_IMMATRICULATION = 1;
			} else {
				$TB_IMMATRICULATION = 0;
			}
			if ($this->input->post('TB_PERMIS') != null) {
				$TB_PERMIS = 1;
			} else {
				$TB_PERMIS = 0;
			}
			if ($this->input->post('TB_FINANCIER') != null) {
				$TB_FINANCIER = 1;
			} else {
				$TB_FINANCIER = 0;
			}
			if ($this->input->post('TB_AMANDE') != null) {
				$TB_AMANDE = 1;
			} else {
				$TB_AMANDE = 0;
			}
			if ($this->input->post('TB_POLICE') != null) {
				$TB_POLICE = 1;
			} else {
				$TB_POLICE = 0;
			}
			if ($this->input->post('TB_SIGNALMENT') != null) {
				$TB_SIGNALMENT = 1;
			} else {
				$TB_SIGNALMENT = 0;
			}
			if ($this->input->post('TB_CONSTANT') != null) {
				$TB_CONSTANT = 1;
			} else {
				$TB_CONSTANT = 0;
			}
			if ($this->input->post('TB_CONTROLE_RAPIDE') != null) {
				$TB_CONTROLE_RAPIDE = 1;
			} else {
				$TB_CONTROLE_RAPIDE = 0;
			}
			if ($this->input->post('TB_AUTRE_CONTROLE') != null) {
				$TB_AUTRE_CONTROLE = 1;
			} else {
				$TB_AUTRE_CONTROLE = 0;
			}
			if ($this->input->post('MAP_CENTRE_SITUATION') != null) {
				$MAP_CENTRE_SITUATION = 1;
			} else {
				$MAP_CENTRE_SITUATION = 0;
			}
			if ($this->input->post('MAP_AGENT_POLICE') != null) {
				$MAP_AGENT_POLICE = 1;
			} else {
				$MAP_AGENT_POLICE = 0;
			}
			if ($this->input->post('MAP_SIGNALEMENT') != null) {
				$MAP_SIGNALEMENT = 1;
			} else {
				$MAP_SIGNALEMENT = 0;
			}
		   if ($this->input->post('CONFIGURATION_DATA') != null) {
				$CONFIGURATION_DATA = 1;
			} else {
				$CONFIGURATION_DATA = 0;
			}
			if ($this->input->post('IHM') != null) {
				$IHM = 1;
			} else {
				$IHM = 0;
			}
			if ($this->input->post('RH_FONCTIONNAIRE') != null) {
				$RH_FONCTIONNAIRE = 1;
			} else {
				$RH_FONCTIONNAIRE = 0;
			}
			if ($this->input->post('RH_POSTE') != null) {
				$RH_POSTE = 1;
			} else {
				$RH_POSTE = 0;
			}
			if ($this->input->post('RH_AFFECTATION') != null) {
				$RH_AFFECTATION = 1;
			} else {
				$RH_AFFECTATION = 0;
			}
			if ($this->input->post('VERIFICATION') != null) {
				$VERIFICATION = 1;
			} else {
				$VERIFICATION = 0;
			}
			if ($this->input->post('CONSTANT_SUR_CONTROLE') != null) {
				$CONSTANT_SUR_CONTROLE = 1;
			} else {
				$CONSTANT_SUR_CONTROLE = 0;
			}
			if ($this->input->post('FOURRIERE') != null) {
				$FOURRIERE = 1;
			} else {
				$FOURRIERE = 0;
			}
			if ($this->input->post('CHEF_MENAGE') != null) {
				$CHEF_MENAGE = 1;
			} else {
				$CHEF_MENAGE = 0;
			}
			if ($this->input->post('GESTION_CHEF_MENAGE') != null) {
				$GESTION_CHEF_MENAGE = 1;
			} else {
				$GESTION_CHEF_MENAGE = 0;
			}
			if ($this->input->post('INSTITUTION') != null) {
				$INSTITUTION = 1;
			} else {
				$INSTITUTION = 0;
			}
			if ($this->input->post('INSTITUTION') != null) {
				$INSTITUTION = 1;
			} else {
				$INSTITUTION = 0;
			}
			if ($this->input->post('TB_TRANSPORT') != null) {
				$TB_TRANSPORT = 1;
			} else {
				$TB_TRANSPORT = 0;
			}
			if ($this->input->post('TB_CONTROLE_TECHNIQUE') != null) {
				$TB_CONTROLE_TECHNIQUE = 1;
			} else {
				$TB_CONTROLE_TECHNIQUE = 0;
			}


			
			$data_insert = array(
				'PROFIL_ID' => $this->input->post('PROFIL_ID'),
				'INFRACTION' => $infraction,
				'PSR_ELEMENT' => $psr,
				'PEINES' => $peines,
				'AFFECTATION' => $affectation,
				'PERMIS' => $permis,
				'DECLARATION' => $declaration,
				'IMMATRICULATION' => $immatriculation,
				'CONTROLE_TECHNIQUE' => $controle,
				'ASSURANCE' => $assurance,
				'QUESTIONNAIRE' => $questionnaire,
				'SIGNALEMENT' => $signalement,
				'VALIDATEUR' => $validateur,
				'POLICE_JUDICIAIRE' => $POLICE_JUDICIAIRE,
                'TRANSPORT'  => $TRANSPORT,
                'PARAMETRE'  => $PARAMETRE,
                'TB_PJ'  => $TB_PJ,
                'TB_ASSURANCE'  => $TB_ASSURANCE,
                'TB_IMMATRICULATION'  => $TB_IMMATRICULATION,
                'TB_PERMIS'  => $TB_PERMIS,
                'TB_FINANCIER'  => $TB_FINANCIER,
                'TB_AMANDE'  => $TB_AMANDE,
                'TB_POLICE'  => $TB_POLICE,
                'TB_SIGNALMENT'  => $TB_SIGNALMENT,
                'TB_CONSTANT'  => $TB_CONSTANT,
                'TB_CONTROLE_RAPIDE'  => $TB_CONTROLE_RAPIDE,
                'TB_AUTRE_CONTROLE'  => $TB_AUTRE_CONTROLE,
                'MAP_CENTRE_SITUATION'  => $MAP_CENTRE_SITUATION,
                'MAP_AGENT_POLICE'  => $MAP_AGENT_POLICE,
                'MAP_SIGNALEMENT'  => $MAP_SIGNALEMENT,
                'CONFIGURATION_DATA'  => $CONFIGURATION_DATA,
                'IHM' => $IHM,
                'RH_FONCTIONNAIRE'  => $RH_FONCTIONNAIRE,
                'RH_POSTE'  => $RH_POSTE,
                'RH_AFFECTATION'  => $RH_AFFECTATION,
                'VERIFICATION'  => $VERIFICATION,
                'CONSTANT_SUR_CONTROLE'  => $CONSTANT_SUR_CONTROLE,
                'FOURRIERE'  => $FOURRIERE,
                'CHEF_MENAGE'  => $CHEF_MENAGE,
                'GESTION_CHEF_MENAGE'  => $GESTION_CHEF_MENAGE,
                'INSTITUTION' => $INSTITUTION,
                'TB_TRANSPORT' => $TB_TRANSPORT,
                'TB_CONTROLE_TECHNIQUE' => $TB_CONTROLE_TECHNIQUE
			);
			
			$table = 'droits';
			$this->Modele->create($table, $data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Droit/'));
		}
	}

	function getOne()
	{
		$id = $this->uri->segment(4);
		$data['data'] = $this->Modele->getOne('droits', array('ID_DROIT' => $id));
		$data['profils'] = $this->Model->getRequete('SELECT PROFIL_ID, STATUT FROM profil WHERE 1 ORDER BY STATUT ASC');

		$checinfra = '';
		$checkPsr = '';
		$checkpeine = '';
		$checkaffect = '';
		$checkPermis = '';
		$checkDecla = '';
		$checkimma = '';
		$checkcont = '';
		$checkAss = '';
		$checkQues = '';
		$checkSign = '';
		$checkValid = '';
		$POLICE_JUDICIAIRE='';
        $TRANSPORT='';
        $PARAMETRE='';
        $TB_PJ='';
        $TB_ASSURANCE='';
        $TB_IMMATRICULATION='';
        $TB_PERMIS='';
        $TB_FINANCIER='';
        $TB_AMANDE='';
        $TB_POLICE='';
        $TB_SIGNALMENT='';
        $TB_CONSTANT='';
        $TB_CONTROLE_RAPIDE='';
        $TB_AUTRE_CONTROLE='';
        $MAP_CENTRE_SITUATION='';
        $MAP_AGENT_POLICE='';
        $MAP_SIGNALEMENT='';
        $CONFIGURATION_DATA='';
        $IHM='';
        $RH_FONCTIONNAIRE='';
        $RH_POSTE='';
        $RH_AFFECTATION='';
        $VERIFICATION='';
        $CONSTANT_SUR_CONTROLE='';
        $FOURRIERE='';
        $CHEF_MENAGE='';
        $GESTION_CHEF_MENAGE='';
        $INSTITUTION = '';
        $TB_CONTROLE_TECHNIQUE = '';
        $TB_TRANSPORT = '';

        


		if ($data['data']['INFRACTION'] == 1) {
			$checinfra = 'checked';
		}
		if ($data['data']['PSR_ELEMENT'] == 1) {
			$checkPsr = 'checked';
		}
		if ($data['data']['PEINES'] == 1) {
			$checkpeine = 'checked';
		}
		if ($data['data']['AFFECTATION'] == 1) {
			$checkaffect = 'checked';
		}
		if ($data['data']['PERMIS'] == 1) {
			$checkPermis = 'checked';
		}
		if ($data['data']['DECLARATION'] == 1) {
			$checkDecla = 'checked';
		}
		if ($data['data']['IMMATRICULATION'] == 1) {
			$checkimma = 'checked';
		}
		if ($data['data']['CONTROLE_TECHNIQUE'] == 1) {
			$checkcont = 'checked';
		}
		if ($data['data']['ASSURANCE'] == 1) {
			$checkAss = 'checked';
		}
		if ($data['data']['QUESTIONNAIRE'] == 1) {
			$checkQues = 'checked';
		}
		if ($data['data']['SIGNALEMENT'] == 1) {
			$checkSign = 'checked';
		}
		if ($data['data']['SIGNALEMENT'] == 1) {
			$checkValid = 'checked';
		}

        if ($data['data']['POLICE_JUDICIAIRE'] == 1) {
			$POLICE_JUDICIAIRE = 'checked';
		}
		if ($data['data']['TRANSPORT'] == 1) {
			$TRANSPORT = 'checked';
		}
		if ($data['data']['PARAMETRE'] == 1) {
			$PARAMETRE = 'checked';
		}
		if ($data['data']['TB_PJ'] == 1) {
			$TB_PJ = 'checked';
		}
		if ($data['data']['TB_ASSURANCE'] == 1) {
			$TB_ASSURANCE = 'checked';
		}
		if ($data['data']['TB_IMMATRICULATION'] == 1) {
			$TB_IMMATRICULATION = 'checked';
		}
		if ($data['data']['TB_PERMIS'] == 1) {
			$TB_PERMIS = 'checked';
		}
		if ($data['data']['TB_FINANCIER'] == 1) {
			$TB_FINANCIER = 'checked';
		}
		if ($data['data']['TB_AMANDE'] == 1) {
			$TB_AMANDE = 'checked';
		}
		if ($data['data']['TB_POLICE'] == 1) {
			$TB_POLICE = 'checked';
		}
		if ($data['data']['TB_SIGNALMENT'] == 1) {
			$TB_SIGNALMENT = 'checked';
		}
		if ($data['data']['TB_CONSTANT'] == 1) {
			$TB_CONSTANT = 'checked';
		}
		if ($data['data']['TB_CONTROLE_RAPIDE'] == 1) {
			$TB_CONTROLE_RAPIDE = 'checked';
		}
		if ($data['data']['CONFIGURATION_DATA'] == 1) {
			$CONFIGURATION_DATA = 'checked';
		}
		if ($data['data']['MAP_CENTRE_SITUATION'] == 1) {
			$MAP_CENTRE_SITUATION = 'checked';
		}
		if ($data['data']['TB_AUTRE_CONTROLE'] == 1) {
			$TB_AUTRE_CONTROLE = 'checked';
		}
		if ($data['data']['VERIFICATION'] == 1) {
			$VERIFICATION = 'checked';
		}
		if ($data['data']['MAP_SIGNALEMENT'] == 1) {
			$MAP_SIGNALEMENT = 'checked';
		}
		if ($data['data']['MAP_AGENT_POLICE'] == 1) {
			$MAP_AGENT_POLICE = 'checked';
		}
		if ($data['data']['IHM'] == 1) {
			$IHM = 'checked';
		}
		if ($data['data']['RH_FONCTIONNAIRE'] == 1) {
			$RH_FONCTIONNAIRE = 'checked';
		}
		if ($data['data']['RH_AFFECTATION'] == 1) {
			$RH_AFFECTATION = 'checked';
		}
		if ($data['data']['RH_POSTE'] == 1) {
			$RH_POSTE = 'checked';
		}
		if ($data['data']['VERIFICATION'] == 1) {
			$RH_AFFECTATION = 'checked';
		}
		if ($data['data']['CONSTANT_SUR_CONTROLE'] == 1) {
			$CONSTANT_SUR_CONTROLE = 'checked';
		}
		if ($data['data']['FOURRIERE'] == 1) {
			$FOURRIERE = 'checked';
		}
		if ($data['data']['CHEF_MENAGE'] == 1) {
			$CHEF_MENAGE = 'checked';
		}
		if ($data['data']['GESTION_CHEF_MENAGE'] == 1) {
			$GESTION_CHEF_MENAGE = 'checked';
		}

		if ($data['data']['INSTITUTION'] == 1) {
			$INSTITUTION = 'checked';
		}
		if ($data['data']['TB_CONTROLE_TECHNIQUE'] == 1) {
			$TB_CONTROLE_TECHNIQUE = 'checked';
		}
		if ($data['data']['TB_TRANSPORT'] == 1) {
			$TB_TRANSPORT = 'checked';
		}
		$data['chec1'] = $checinfra;
		$data['chec2'] = $checkPsr;
		$data['chec3'] = $checkpeine;
		$data['chec4'] = $checkaffect;
		$data['chec5'] = $checkPermis;
		$data['chec6'] = $checkDecla;
		$data['chec7'] = $checkimma;
		$data['chec8'] = $checkcont;
		$data['chec9'] = $checkAss;
		$data['chec10'] = $checkQues;
		$data['chec11'] = $checkSign;
		$data['chec12'] = $checkValid;

		$data['POLICE_JUDICIAIRE'] = $POLICE_JUDICIAIRE;
		$data['TRANSPORT'] = $TRANSPORT;
		$data['PARAMETRE'] = $PARAMETRE;
		$data['TB_PJ'] = $TB_PJ;
		$data['TB_ASSURANCE'] = $TB_ASSURANCE;
		$data['TB_IMMATRICULATION'] = $TB_IMMATRICULATION;
		$data['TB_PERMIS'] = $TB_PERMIS;
		$data['TB_FINANCIER'] = $TB_FINANCIER;
		$data['TB_POLICE'] = $TB_POLICE;
		$data['TB_AMANDE'] = $TB_AMANDE;
		$data['TB_SIGNALMENT'] = $TB_SIGNALMENT;
		$data['TB_CONSTANT'] = $TB_CONSTANT;
		$data['TB_CONTROLE_RAPIDE'] = $TB_CONTROLE_RAPIDE;


		$data['TB_AUTRE_CONTROLE'] = $TB_AUTRE_CONTROLE;
		$data['MAP_CENTRE_SITUATION'] = $MAP_CENTRE_SITUATION;
		$data['MAP_AGENT_POLICE'] = $MAP_AGENT_POLICE;
		$data['MAP_SIGNALEMENT'] = $MAP_SIGNALEMENT;
		$data['CONFIGURATION_DATA'] = $CONFIGURATION_DATA;
		$data['IHM'] = $IHM;
		$data['RH_FONCTIONNAIRE'] = $RH_FONCTIONNAIRE;
		$data['RH_POSTE'] = $RH_POSTE;
		$data['RH_AFFECTATION'] = $RH_AFFECTATION;
		$data['VERIFICATION'] = $VERIFICATION;
		$data['CONSTANT_SUR_CONTROLE'] = $CONSTANT_SUR_CONTROLE;
		$data['FOURRIERE'] = $FOURRIERE;
		$data['CHEF_MENAGE'] = $CHEF_MENAGE;
		$data['GESTION_CHEF_MENAGE'] = $GESTION_CHEF_MENAGE;
		$data['INSTITUTION'] = $INSTITUTION;
		$data['TB_CONTROLE_TECHNIQUE'] = $TB_CONTROLE_TECHNIQUE;
		$data['TB_TRANSPORT'] = $TB_TRANSPORT;
		$data['title'] = "Modification d'un Police";
		$this->load->view('droit/droit_update_v', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('PROFIL_ID', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		$id = $this->input->post('ID_DROIT');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne();
		} else {
			$id = $this->input->post('ID_DROIT');

			if ($this->input->post('INFRACTION') != null) {
				$infraction = 1;
			} else {
				$infraction = 0;
			}
			if ($this->input->post('PSR_ELEMENT') != null) {
				$psr = 1;
			} else {
				$psr = 0;
			}
			if ($this->input->post('PEINES') != null) {
				$peines = 1;
			} else {
				$peines = 0;
			}
			if ($this->input->post('AFFECTATION') != null) {
				$affectation = 1;
			} else {
				$affectation = 0;
			}
			if ($this->input->post('PERMIS') != null) {
				$permis = 1;
			} else {
				$permis = 0;
			}
			if ($this->input->post('DECLARATION') != null) {
				$declaration = 1;
			} else {
				$declaration = 0;
			}
			if ($this->input->post('IMMATRICULATION') != null) {
				$immatriculation = 1;
			} else {
				$immatriculation = 0;
			}
			if ($this->input->post('CONTROLE_TECHNIQUE') != null) {
				$controle = 1;
			} else {
				$controle = 0;
			}
			if ($this->input->post('ASSURANCE') != null) {
				$assurance = 1;
			} else {
				$assurance = 0;
			}
			if ($this->input->post('QUESTIONNAIRE') != null) {
				$questionnaire = 1;
			} else {
				$questionnaire = 0;
			}

			if ($this->input->post('SIGNALEMENT') != null) {
				$signalement = 1;
			} else {
				$signalement = 0;
			}

			if ($this->input->post('VALIDATEUR') != null) {
				$validateur = 1;
			} else {
				$validateur = 0;
			}
			if ($this->input->post('POLICE_JUDICIAIRE') != null) {
				$POLICE_JUDICIAIRE = 1;
			} else {
				$POLICE_JUDICIAIRE = 0;
			}
			if ($this->input->post('TRANSPORT') != null) {
				$TRANSPORT = 1;
			} else {
				$TRANSPORT = 0;
			}
			if ($this->input->post('PARAMETRE') != null) {
				$PARAMETRE = 1;
			} else {
				$PARAMETRE = 0;
			}
			if ($this->input->post('TB_PJ') != null) {
				$TB_PJ = 1;
			} else {
				$TB_PJ = 0;
			}
			if ($this->input->post('TB_ASSURANCE') != null) {
				$TB_ASSURANCE = 1;
			} else {
				$TB_ASSURANCE = 0;
			}
			if ($this->input->post('TB_IMMATRICULATION') != null) {
				$TB_IMMATRICULATION = 1;
			} else {
				$TB_IMMATRICULATION = 0;
			}
			if ($this->input->post('TB_PERMIS') != null) {
				$TB_PERMIS = 1;
			} else {
				$TB_PERMIS = 0;
			}
			if ($this->input->post('TB_FINANCIER') != null) {
				$TB_FINANCIER = 1;
			} else {
				$TB_FINANCIER = 0;
			}
			if ($this->input->post('TB_AMANDE') != null) {
				$TB_AMANDE = 1;
			} else {
				$TB_AMANDE = 0;
			}
			if ($this->input->post('TB_POLICE') != null) {
				$TB_POLICE = 1;
			} else {
				$TB_POLICE = 0;
			}
			if ($this->input->post('TB_SIGNALMENT') != null) {
				$TB_SIGNALMENT = 1;
			} else {
				$TB_SIGNALMENT = 0;
			}
			if ($this->input->post('TB_CONSTANT') != null) {
				$TB_CONSTANT = 1;
			} else {
				$TB_CONSTANT = 0;
			}
			if ($this->input->post('TB_CONTROLE_RAPIDE') != null) {
				$TB_CONTROLE_RAPIDE = 1;
			} else {
				$TB_CONTROLE_RAPIDE = 0;
			}
			if ($this->input->post('TB_AUTRE_CONTROLE') != null) {
				$TB_AUTRE_CONTROLE = 1;
			} else {
				$TB_AUTRE_CONTROLE = 0;
			}
			if ($this->input->post('MAP_CENTRE_SITUATION') != null) {
				$MAP_CENTRE_SITUATION = 1;
			} else {
				$MAP_CENTRE_SITUATION = 0;
			}
			if ($this->input->post('MAP_AGENT_POLICE') != null) {
				$MAP_AGENT_POLICE = 1;
			} else {
				$MAP_AGENT_POLICE = 0;
			}
			if ($this->input->post('MAP_SIGNALEMENT') != null) {
				$MAP_SIGNALEMENT = 1;
			} else {
				$MAP_SIGNALEMENT = 0;
			}
		   if ($this->input->post('CONFIGURATION_DATA') != null) {
				$CONFIGURATION_DATA = 1;
			} else {
				$CONFIGURATION_DATA = 0;
			}
			if ($this->input->post('IHM') != null) {
				$IHM = 1;
			} else {
				$IHM = 0;
			}
			if ($this->input->post('RH_FONCTIONNAIRE') != null) {
				$RH_FONCTIONNAIRE = 1;
			} else {
				$RH_FONCTIONNAIRE = 0;
			}
			if ($this->input->post('RH_POSTE') != null) {
				$RH_POSTE = 1;
			} else {
				$RH_POSTE = 0;
			}
			if ($this->input->post('RH_AFFECTATION') != null) {
				$RH_AFFECTATION = 1;
			} else {
				$RH_AFFECTATION = 0;
			}
			if ($this->input->post('VERIFICATION') != null) {
				$VERIFICATION = 1;
			} else {
				$VERIFICATION = 0;
			}
			if ($this->input->post('CONSTANT_SUR_CONTROLE') != null) {
				$CONSTANT_SUR_CONTROLE = 1;
			} else {
				$CONSTANT_SUR_CONTROLE = 0;
			}
			if ($this->input->post('FOURRIERE') != null) {
				$FOURRIERE = 1;
			} else {
				$FOURRIERE = 0;
			}
			if ($this->input->post('CHEF_MENAGE') != null) {
				$CHEF_MENAGE = 1;
			} else {
				$CHEF_MENAGE = 0;
			}
			if ($this->input->post('GESTION_CHEF_MENAGE') != null) {
				$GESTION_CHEF_MENAGE = 1;
			} else {
				$GESTION_CHEF_MENAGE = 0;
			}


			if ($this->input->post('INSTITUTION') != null) {
				$INSTITUTION = 1;
			} else {
				$INSTITUTION = 0;
			}
			if ($this->input->post('TB_CONTROLE_TECHNIQUE') != null) {
				$TB_CONTROLE_TECHNIQUE = 1;
			} else {
				$TB_CONTROLE_TECHNIQUE = 0;
			}
			if ($this->input->post('TB_TRANSPORT') != null) {
				$TB_TRANSPORT = 1;
			} else {
				$TB_TRANSPORT = 0;
			}
			$data = array(
				'PROFIL_ID' => $this->input->post('PROFIL_ID'),
				'INFRACTION' => $infraction,
				'PSR_ELEMENT' => $psr,
				'PEINES' => $peines,
				'AFFECTATION' => $affectation,
				'PERMIS' => $permis,
				'DECLARATION' => $declaration,
				'IMMATRICULATION' => $immatriculation,
				'CONTROLE_TECHNIQUE' => $controle,
				'ASSURANCE' => $assurance,
				'QUESTIONNAIRE' => $questionnaire,
				'SIGNALEMENT' => $signalement,
				'VALIDATEUR' => $validateur,
				'POLICE_JUDICIAIRE' => $POLICE_JUDICIAIRE,
                'TRANSPORT'  => $TRANSPORT,
                'PARAMETRE'  => $PARAMETRE,
                'TB_PJ'  => $TB_PJ,
                'TB_ASSURANCE'  => $TB_ASSURANCE,
                'TB_IMMATRICULATION'  => $TB_IMMATRICULATION,
                'TB_PERMIS'  => $TB_PERMIS,
                'TB_FINANCIER'  => $TB_FINANCIER,
                'TB_AMANDE'  => $TB_AMANDE,
                'TB_POLICE'  => $TB_POLICE,
                'TB_SIGNALMENT'  => $TB_SIGNALMENT,
                'TB_CONSTANT'  => $TB_CONSTANT,
                'TB_CONTROLE_RAPIDE'  => $TB_CONTROLE_RAPIDE,
                'TB_AUTRE_CONTROLE'  => $TB_AUTRE_CONTROLE,
                'MAP_CENTRE_SITUATION'  => $MAP_CENTRE_SITUATION,
                'MAP_AGENT_POLICE'  => $MAP_AGENT_POLICE,
                'MAP_SIGNALEMENT'  => $MAP_SIGNALEMENT,
                'CONFIGURATION_DATA'  => $CONFIGURATION_DATA,
                'IHM' => $IHM,
                'RH_FONCTIONNAIRE'  => $RH_FONCTIONNAIRE,
                'RH_POSTE'  => $RH_POSTE,
                'RH_AFFECTATION'  => $RH_AFFECTATION,
                'VERIFICATION'  => $VERIFICATION,
                'CONSTANT_SUR_CONTROLE'  => $CONSTANT_SUR_CONTROLE,
                'FOURRIERE'  => $FOURRIERE,
                'CHEF_MENAGE'  => $CHEF_MENAGE,
                'GESTION_CHEF_MENAGE'  => $GESTION_CHEF_MENAGE,
                'INSTITUTION' => $INSTITUTION,
                'TB_CONTROLE_TECHNIQUE' => $TB_CONTROLE_TECHNIQUE,
                'TB_TRANSPORT' => $TB_TRANSPORT
            );
			$this->Modele->update('droits', array('ID_DROIT' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('PSR/Droit/'));
		}
	}

	function delete()
	{
		$table = "droits";
		$criteres['ID_DROIT'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Droit'));
	}
}
