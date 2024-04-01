<?php

/**
 *
 *	Element de la police 
 **/
class Historique extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		if ($this->session->userdata('PSR_ELEMENT') != 1) {

			redirect(base_url());
		}
	}




    function gethistoControl($id){

		$query_principal = 'SELECT h.ID_COMPORTEMENT, ID_CONTROLE_MARCHANDISE,ID_HISTORIQUE,h.ID_CONTROLE,h.ID_HISTORIQUE_CATEGORIE, hc.DESCRIPTION as historique_categorie,
		(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_IMMATRICULATIO_PEINE) AS IMMATRICULATION,
		(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_ASSURANCE_PEINE) AS ASSURANCE,
		(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_CONTROLE_TECHNIQUE_PEINE) AS CONTROL_TECHNIQUE,
		(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_VOL_PEINE) AS VOL,(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_PERMIS_PEINE) AS PERMIS_PEINE, h.NUMERO_PLAQUE ,ID_IMMATRICULATIO_PEINE,ID_ASSURANCE_PEINE,ID_CONTROLE_TECHNIQUE_PEINE,ID_VOL_PEINE,ID_PERMIS_PEINE, NUMERO_PERMIS, concat(pe.NOM," ",pe.PRENOM) as user,pe.NUMERO_MATRICULE,pe.ID_PSR_ELEMENT, h.LATITUDE, h.LONGITUDE,h.DATE_INSERTION,h.MONTANT,h.IS_PAID,ID_CONTROLE_EQUIPEMENT,ID_SIGNALEMENT FROM historiques h LEFT JOIN historiques_categories hc ON h.ID_HISTORIQUE_CATEGORIE=hc.ID_CATEGORIE LEFT JOIN utilisateurs us ON us.ID_UTILISATEUR=h.ID_UTILISATEUR  LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT = us.PSR_ELEMENT_ID WHERE 1 and ID_HISTORIQUE='.$id;




		$data=$this->Modele->getRequeteOne($query_principal);

		$controle='';
		$controle_technique='';
		$assurance='';
		$permis='';
		$vol='';
		$comportement='';
		$detailControle='';
		$equipement='';

          $marchandise='';
        $titre = $data['historique_categorie'].' de la plaque '.$data['NUMERO_PLAQUE'].' '.$data['DATE_INSERTION'];
		 //print_r($data['ID_IMMATRICULATIO_PEINE']);exit();
		if($data['ID_IMMATRICULATIO_PEINE'] !=null){
			$controle=$this->getInfraImmatri($data['ID_IMMATRICULATIO_PEINE']);
		}

		//print_r($controle);exit();
		
		if($data['ID_CONTROLE_TECHNIQUE_PEINE'] !=null){
	        $controle_technique =$this->getInfracontroleTechnique($data['ID_CONTROLE_TECHNIQUE_PEINE'])	;
		}

		if($data['ID_ASSURANCE_PEINE'] !=null){
           $assurance =$this->getInfrassur($data['ID_ASSURANCE_PEINE']);
		}
	
		if($data['ID_VOL_PEINE'] !=null){
           $vol =$this->getInfraVol($data['ID_VOL_PEINE']);
			
		}

		if($data['ID_PERMIS_PEINE'] !=null){
           $permis =$this->getInfraPermis($data['ID_PERMIS_PEINE']);
			
		}


		if($data['ID_COMPORTEMENT'] !=null){
           $comportement =$this->getDetailComport($data['ID_COMPORTEMENT']);
			
		}

		if($data['ID_CONTROLE'] !=null){
           $detailControle =$this->getDetais($data['ID_CONTROLE']);
			
		}

		if($data['ID_CONTROLE_EQUIPEMENT'] !=null){
           $equipement =$this->getDetailEQUI($data['ID_CONTROLE_EQUIPEMENT']);
			
		}

		if($data['ID_CONTROLE_MARCHANDISE'] !=null){
           $marchandise =$this->getDetailMarchandise($data['ID_CONTROLE_MARCHANDISE']);
			
		}


		

	     //print_r($controle_technique);exit();

		$data['immatriculation'] = $controle;
		$data['vol'] = $vol;
		$data['assurance'] = $assurance;
		$data['permis'] = $permis;
		$data['comportement'] = $comportement;
		$data['detailControle'] = $detailControle;
		$data['equipement'] = $equipement;
		$data['marchandise'] = $marchandise;


		$data['historique'] = $query_principal;
		$data['title'] = 'Contrôle ';



		

	
		$map = $this->load->view('detail_view_map', $data, TRUE);
	    $output = array('views_detail' => $map, 'id' => $id,'titres'=>$titre);
	    echo json_encode($output);



	}









	function getDetailComport($id_control = 0)
	{

		$dataDetail = 'SELECT q.INFRACTIONS,q.MONTANT FROM historiques h JOIN autres_controles au on au.ID_CONTROLE_PLAQUE =h.ID_COMPORTEMENT JOIN autres_controles_questionnaires q on q.ID_CONTROLES_QUESTIONNAIRES=au.ID_CONTROLES_QUESTIONNAIRES WHERE h.ID_COMPORTEMENT = ' . $id_control;


		$htmlDetail = "<div class='table-responsive'><b>".$this->getIfraction($id_control)."</b>
		<table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
		<thead>
		<tr>
		<th>Application</th>
		<th>Montant</th>
		</tr>
		</thead>

		<tbody>";

		$total = 0;
		foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

			$total += $value['MONTANT'];

			$htmlDetail .= "<tr>
			<td>" . $value['INFRACTIONS'] . "</td>
			<td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . " FBU</span></td>
			</tr>";
		}

		$htmlDetail .= "<tr>
		<th>Total</th>
		<th><span style='float:right'>" . number_format($total, 0, '.', ' ') . " FBU</th>
		</span></tr>";

		$htmlDetail .= "</tbody></table>
		</div>";
		$htmlDetail .= "<div class='row'>
		
		</div>";

		return $htmlDetail;
	}





	function getDetais($id_control = 0)
	{

		$dataDetail = 'SELECT q.INFRACTIONS,q.MONTANT FROM historiques h JOIN autres_controles au on au.ID_CONTROLE_PLAQUE =h.ID_CONTROLE JOIN autres_controles_questionnaires q on q.ID_CONTROLES_QUESTIONNAIRES=au.ID_CONTROLES_QUESTIONNAIRES WHERE h.ID_CONTROLE = ' . $id_control;


		$htmlDetail = "<div class='table-responsive'><b>".$this->getIfraction($id_control)."</b>
		<table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
		<thead>
		<tr>
		<th>Application</th>
		<th>Montant</th>
		</tr>
		</thead>

		<tbody>";

		$total = 0;
		foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

			$total += $value['MONTANT'];

			$htmlDetail .= "<tr>
			<td>" . $value['INFRACTIONS'] . "</td>
			<td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . " FBU</span></td>
			</tr>";
		}

		$htmlDetail .= "<tr>
		<th>Total</th>
		<th><span style='float:right'>" . number_format($total, 0, '.', ' ') . " FBU</th>
		</span></tr>";

		$htmlDetail .= "</tbody></table>
		</div>";
		$htmlDetail .= "<div class='row'>
		
		</div>";

		return $htmlDetail;
	}

	function getDetaisSign($id_control = 0)
	{

		$dataDetail = 'SELECT ca.CIVIL_DESCRIPTION, acq.INFRACTIONS,ch.NOM_CHAUSSE FROM historiques h LEFT JOIN civil_alerts ca ON ca.ID_ALERT=h.ID_SIGNALEMENT LEFT JOIN civil_alerts_details cat ON cat.ID_CIVIL_ALERT=ca.ID_ALERT LEFT JOIN  autres_controles_questionnaires acq ON acq.ID_CONTROLES_QUESTIONNAIRES=cat.ID_QUESTIONNAIRE LEFT JOIN chaussee ch ON ch.ID_CHAUSSEE=ca.ID_CHAUSSEE  WHERE 1 AND h.ID_SIGNALEMENT=' . $id_control;


		$htmlDetail = "<div class='table-responsive'>
        
        <b>".$this->getIfraction($id_control)."</b>

		<table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
		<thead>
		<tr>
		<th>Chausse</th>
		<th>Application</th>
		<th>Description</th>
		</tr>
		</thead>

		<tbody>";

		$total = 0;
		foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {



			$htmlDetail .= "<tr>
			<td>" . $value['NOM_CHAUSSE'] . "</td>
			<td>" . $value['INFRACTIONS'] . "</td>
			<td>" . $value['CIVIL_DESCRIPTION'] . "</td>
			</tr>";
		}

		$htmlDetail .= "<tr>
		<th>Total</th>
		<th><span style='float:right'>" . number_format($total, 0, '.', ' ') . " FBU</th>
		</span></tr>";

		$htmlDetail .= "</tbody></table>
		</div>";
		$htmlDetail .= "<div class='row'>
		
		</div>";

		return $htmlDetail;
	}






	function getDetailMarchandise($id_control = 0)
	{
		$dataDetail = 'SELECT q.INFRACTIONS,q.MONTANT FROM historiques h JOIN autres_controles au on au.ID_CONTROLE_PLAQUE =h.ID_CONTROLE_MARCHANDISE JOIN autres_controles_questionnaires q on q.ID_CONTROLES_QUESTIONNAIRES=au.ID_CONTROLES_QUESTIONNAIRES WHERE h.ID_CONTROLE_MARCHANDISE= ' . $id_control;


		$htmlDetail = "<div class='table-responsive'>

		<b>".$this->getIfraction($id_control)."</b>
		<table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
		<thead>
		<tr>
		<th>Application</th>
		<th>Montant</th>
		</tr>
		</thead>

		<tbody>";

		$total = 0;
		foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

			$total += $value['MONTANT'];

			$htmlDetail .= "<tr>
			<td>" . $value['INFRACTIONS'] . "</td>
			<td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . " FBU</span></td>
			</tr>";
		}

		$htmlDetail .= "<tr>
		<th>Total</th>
		<th><span style='float:right'>" . number_format($total, 0, '.', ' ') . " FBU</th>
		</span></tr>";

		$htmlDetail .= "</tbody></table>
		</div>";
		$htmlDetail .= "<div class='row'>
		
		</div>";

		return $htmlDetail;
	}








	function getDetailEQUI($id_control = 0)
	{

		$dataDetail = 'SELECT q.INFRACTIONS,q.MONTANT FROM historiques h JOIN autres_controles au on au.ID_CONTROLE_PLAQUE =h.ID_CONTROLE_EQUIPEMENT JOIN autres_controles_questionnaires q on q.ID_CONTROLES_QUESTIONNAIRES=au.ID_CONTROLES_QUESTIONNAIRES WHERE h.ID_CONTROLE_EQUIPEMENT= ' . $id_control;


		$htmlDetail = "<div class='table-responsive'>

		<b>".$this->getIfraction($id_control)."</b>
		<table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
		<thead>
		<tr>
		<th>Application</th>
		<th>Montant</th>
		</tr>
		</thead>

		<tbody>";

		$total = 0;
		foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

			$total += $value['MONTANT'];

			$htmlDetail .= "<tr>
			<td>" . $value['INFRACTIONS'] . "</td>
			<td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . " FBU</span></td>
			</tr>";
		}

		// $htmlDetail .= "<tr>
		// <th>Total</th>
		// <th><span style='float:right'>" . number_format($total, 0, '.', ' ') . " FBU</th>
		// </span></tr>";

		$htmlDetail .= "</tbody></table>
		</div>";
		$htmlDetail .= "<div class='row'>
		
		</div>";

		return $htmlDetail;
	}



	function index()
	{
		$historique = $this->Modele->getRequete('SELECT date_format(DATE_INSERTION,"%d-%m-%Y") as date FROM historiques WHERE 1 GROUP BY date_format(DATE_INSERTION,"%d-%m-%Y")');
		$data['historique'] = $historique;
		$data['title'] = 'Historiques';
		$this->load->view('historique_list_v', $data);
	}



	function getPlaques($plaque)
	{
		$plaque = $this->Modele->getRequeteOne("SELECT * FROM obr_immatriculations_voitures WHERE NUMERO_PLAQUE='" . $plaque . "'");
		if ($plaque != NULL) {
			return $plaque['ID_IMMATRICULATION'];
		} else {
			return 0;
		}
		//print_r($plaque);
	}

	function getPermis($permis)
	{
		$permis = $this->Modele->getRequeteOne("SELECT * FROM `chauffeur_permis` WHERE 1 AND NUMERO_PERMIS ='" . $permis . "'");
		if ($permis != NULL) {
			return $permis['ID_PERMIS'];
		} else {
			return 0;
		}
		//print_r($plaque);
	}




	function listing()
	{
		$i = 1;

		$date = $this->input->post('date');
		$critere_date = !empty($date) ? " and date_format(h.DATE_INSERTION,'%d-%m-%Y')= '" . $date . "' " : "";

		$query_principal = 'SELECT h.ID_COMPORTEMENT, h.RAISON_ANNULATION, ID_CONTROLE_MARCHANDISE,ID_HISTORIQUE,h.ID_CONTROLE,h.ID_HISTORIQUE_CATEGORIE, hc.DESCRIPTION as historique_categorie,
		(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_IMMATRICULATIO_PEINE) AS IMMATRICULATION,
		(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_ASSURANCE_PEINE) AS ASSURANCE,
		(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_CONTROLE_TECHNIQUE_PEINE) AS CONTROL_TECHNIQUE,
		(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_VOL_PEINE) AS VOL,(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_PERMIS_PEINE) AS PERMIS_PEINE, h.NUMERO_PLAQUE ,ID_IMMATRICULATIO_PEINE,ID_ASSURANCE_PEINE,ID_CONTROLE_TECHNIQUE_PEINE,ID_VOL_PEINE,ID_PERMIS_PEINE, NUMERO_PERMIS, concat(pe.NOM," ",pe.PRENOM) as user,pe.NUMERO_MATRICULE,pe.ID_PSR_ELEMENT, h.LATITUDE, h.LONGITUDE,h.DATE_INSERTION,h.MONTANT,h.IS_PAID,ID_CONTROLE_EQUIPEMENT,ID_SIGNALEMENT FROM historiques h LEFT JOIN historiques_categories hc ON h.ID_HISTORIQUE_CATEGORIE=hc.ID_CATEGORIE LEFT JOIN utilisateurs us ON us.ID_UTILISATEUR=h.ID_UTILISATEUR  LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT = us.PSR_ELEMENT_ID WHERE 1 ' . $critere_date;



		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';

                    
		$order_column = array('user', 'DATE_INSERTION', 'historique_categorie', 'RAISON_ANNULATION', 'NUMERO_PLAQUE', 'NUMERO_PERMIS', 'MONTANT', 'IS_PAID', 'DATE_INSERTION');
		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_INSERTION DESC ';

		$search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%' ") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_psr = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_psr as $row) {

			$controleMarch = '';
			$controleSignale = '';
			$controleSignalement = '';
			$controleEquipement = '';
			$controleEquipe = '';
			$controlePhysique = '';
			$controlePhy = '';
			$infraplaque = '';
			$infrassur = '';
			$infracontrp = '';
			$infravol = '';
			$infrapermis = '';
			$plaque = '';
			$permis = '';
			$AutresControles = '';
			$option = '';




			if ($row->ID_COMPORTEMENT != Null) {
				$comportementPermis = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
			} else {
				$comportementPermis = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
			}


			$comportPermis = "<a hre='#' data-toggle='modal'
			data-target='#detailComport" . $row->ID_HISTORIQUE . "'>" . $comportementPermis . "</a>";


			$comportPermis .= "<div class='modal fade' id='detailComport" . $row->ID_HISTORIQUE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
			<h5 class='modal-title'>Detail du Control permis</h5>
			<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>";


			if ($row->ID_COMPORTEMENT != Null) {
				$comportPermis .= $this->getDetailComport($row->ID_COMPORTEMENT);
			}

			$comportPermis .= "
			</div>
			<div class='modal-footer'>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";






			if ($row->IMMATRICULATION != Null) {
				$infra = $row->IMMATRICULATION;
			} else {
				$infra = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
			}
			if ($row->ASSURANCE != Null) {
				$infrassur = $row->ASSURANCE;
			} else {
				$infrassur = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
			}
			if ($row->CONTROL_TECHNIQUE != Null) {
				$infracontrp = $row->CONTROL_TECHNIQUE;
			} else {
				$infracontrp = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
			}
			if ($row->VOL != Null) {
				$infravol = $row->VOL;
			} else {
				$infravol = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-times"></i></a>';
			}
			if ($row->PERMIS_PEINE != Null) {
				$infrapermis = $row->PERMIS_PEINE;
			} else {
				$infrapermis = !empty($row->NUMERO_PERMIS) ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
			}

			if ($row->NUMERO_PLAQUE != Null) {
				$plaques = $this->getPlaques($row->NUMERO_PLAQUE);

				if ($plaques != null) {
					$plaque = "<a  class='btn btn-md dt-button btn-sm' href='" . base_url('PSR/Obr_Immatriculation/show_vehicule/' . $plaques . '/' . $row->NUMERO_PLAQUE) . "'>" . $row->NUMERO_PLAQUE . "</a>";
				} else {
					$plaque = "<div class='btn btn-outline-danger''>" . $row->NUMERO_PLAQUE . "</div>";
				}
			} else {
				$plaque = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
			}
			if ($row->MONTANT != Null) {
				$montant = $row->MONTANT;
			} else {
				$montant = '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>';
			}
			if ($row->NUMERO_PERMIS != Null) {
				$idPermit = $this->getPermis($row->NUMERO_PERMIS);

				if ($idPermit != null) {
					$permis = "<a  class='btn btn-md dt-button btn-sm' href='" . base_url('ihm/
						Permis/index/' . $idPermit) . "'>" . $row->NUMERO_PERMIS . "</a>";
				} else {
					$permis = "<span style='color :red'>" . $row->NUMERO_PERMIS . "</span>";
				}
			} else {
				$permis = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
			}

			if ($row->ID_CONTROLE != Null) {
				$controlePhy = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
			} else {
				$controlePhysique = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
			}

			if ($row->ID_CONTROLE_EQUIPEMENT != Null) {
				$controleEquipe = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
			} else {
				$controleEquipe = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
			}

			if ($row->ID_SIGNALEMENT != Null) {
				$controleSignale = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
			} else {
				$controleSignalement = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
			}


			if ($row->ID_CONTROLE_MARCHANDISE != Null) {
				$controleMarch = '<span class = "btn btn-info btn-sm " style="float:right" ><i class = "fa fa-eye" ></i></span>';
			} else {
				$controleMarch = '<a class = "btn btn-success btn-sm " style="float:right" ><i class="fas fa-long-arrow-alt-right"></i></a>';
			}



			$detailMarch = "<a hre='#' data-toggle='modal'
			data-target='#detailMarchs" . $row->ID_HISTORIQUE . "'>" . $controleMarch . "</a>";


			$detailMarch .= "<div class='modal fade' id='detailMarchs" . $row->ID_HISTORIQUE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
			<h5 class='modal-title'>Detail du Controle Machandise</h5>
			<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>";


			if ($row->ID_CONTROLE_MARCHANDISE != Null) {
				$detailMarch .= $this->getDetailMarchandise($row->ID_CONTROLE_MARCHANDISE);
			}

			$detailMarch .= "
			</div>
			<div class='modal-footer'>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";



			$detailSign = '';

			$detailSign .= "<a hre='#' data-toggle='modal'
			data-target='#detail" . $row->ID_SIGNALEMENT . "'>" . $controleSignale . "</a>";
			$detailSign .= "
			<div class='modal fade' id='detail" . $row->ID_SIGNALEMENT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
			<h5 class='modal-title'>Detail du Controle Pysique</h5>
			<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>";


			if ($row->ID_SIGNALEMENT != Null) {
				$detailSign .= $this->getDetaisSign($row->ID_SIGNALEMENT);
			}

			$detailSign .= "
			</div>
			<div class='modal-footer'>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$detail = '';

			$detail .= "<a hre='#' data-toggle='modal'
			data-target='#detail" . $row->ID_CONTROLE . "'>" . $controlePhy . "</a>";
			$detail .= "
			<div class='modal fade' id='detail" . $row->ID_CONTROLE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
			<h5 class='modal-title'>Detail du controle Physique</h5>
			<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>";


			if ($row->ID_CONTROLE != Null) {
				$detail .= $this->getDetais($row->ID_CONTROLE);
			}

			$detail .= "
			</div>
			<div class='modal-footer'>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";



			$detailEqui = '';

			$detailEqui .= "<a hre='#' data-toggle='modal'
			data-target='#detailEquips" . $row->ID_CONTROLE_EQUIPEMENT . "'>" . $controleEquipe . "</a>";
			$detailEqui .= "
			<div class='modal fade' id='detailEquips" . $row->ID_CONTROLE_EQUIPEMENT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
			<h5 class='modal-title'>Detail du Controle Equipement</h5>
			<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>";


			if ($row->ID_CONTROLE_EQUIPEMENT != Null) {
				$detailEqui .= $this->getDetailEQUI($row->ID_CONTROLE_EQUIPEMENT);
			}

			$detailEqui .= "
			</div>
			<div class='modal-footer'>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";



			$detailInfraimmatri = '';

			$detailInfraimmatri .= "<a hre='#' data-toggle='modal'
			data-target='#detailIMP" . $row->ID_IMMATRICULATIO_PEINE . "'><span style='color: red'>" . $infra . "</spa></a>";
			$detailInfraimmatri .= "
			<div class='modal fade' id='detailIMP" . $row->ID_IMMATRICULATIO_PEINE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
			<h5 class='modal-title'>Detail de controle</h5>
			<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>";

			if ($row->ID_IMMATRICULATIO_PEINE != Null) {
				$detailInfraimmatri .= $this->getInfraImmatri($row->ID_IMMATRICULATIO_PEINE);
			}

			$detailInfraimmatri .= "
			</div>
			<div class='modal-footer'>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$detailInfrassur = '';

			$detailInfrassur .= "<a hre='#' data-toggle='modal'
			data-target='#detailASSUR" . $row->ID_ASSURANCE_PEINE . "'><span style='color: red'>" . $infrassur . "</span></a>";
			$detailInfrassur .= "
			<div class='modal fade' id='detailASSUR" . $row->ID_ASSURANCE_PEINE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
			<h5 class='modal-title'>Detail de controle</h5>
			<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>";

			// if ($row->ID_ASSURANCE_PEINE != Null) {
			// 	$detailInfrassur .= $this->getInfrassur($row->ID_ASSURANCE_PEINE);
			// }

			$detailInfrassur .= "
			</div>
			<div class='modal-footer'>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$detailInfrcontroltechnique = '';

			$detailInfrcontroltechnique .= "<a hre='#' data-toggle='modal'
			data-target='#detailCNTP" . $row->ID_CONTROLE_TECHNIQUE_PEINE . "'><span style='color: red'>" . $infracontrp . "</span></a>";
			$detailInfrcontroltechnique .= "
			<div class='modal fade' id='detailCNTP" . $row->ID_CONTROLE_TECHNIQUE_PEINE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
			<h5 class='modal-title'>Detail de controle</h5>
			<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>";

			if ($row->ID_CONTROLE_TECHNIQUE_PEINE != Null) {
				$detailInfrcontroltechnique .= $this->getInfracontroleTechnique($row->ID_CONTROLE_TECHNIQUE_PEINE);
			}

			$detailInfrcontroltechnique .= "
			</div>
			<div class='modal-footer'>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$detailInfravol = '';

			$detailInfravol .= "<a hre='#' data-toggle='modal'
			data-target='#detailVOL" . $row->ID_VOL_PEINE . "'><span style='color: red'>" . $infravol . "</span></a>";
			$detailInfravol .= "
			<div class='modal fade' id='detailVOL" . $row->ID_VOL_PEINE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
			<h5 class='modal-title'>Detail de controle</h5>
			<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>";

			if ($row->ID_VOL_PEINE != Null) {
				$detailInfravol .= $this->getInfraVol($row->ID_VOL_PEINE);
			}

			$detailInfravol .= "
			</div>
			<div class='modal-footer'>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$detailInfrapermis = '';

			$detailInfrapermis .= "<a hre='#' data-toggle='modal'
			data-target='#detailPMSP" . $row->ID_PERMIS_PEINE . "'><span style='color: red'>" . $infrapermis . "</span></a>";
			$detailInfrapermis .= "
			<div class='modal fade' id='detailPMSP" . $row->ID_PERMIS_PEINE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
			<h5 class='modal-title'>Detail de controle</h5>
			<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>";

			if ($row->ID_PERMIS_PEINE != Null) {
				$detailInfrapermis .= $this->getInfraPermis($row->ID_PERMIS_PEINE);
			}

			$detailInfrapermis .= "
			</div>
			<div class='modal-footer'>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_HISTORIQUE . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Historique/getDetail/' . $row->ID_HISTORIQUE) . "'><label class='text-info'>&nbsp;&nbsp;Detail</label></a></li>";

			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" . $row->ID_HISTORIQUE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer l'historique de?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->historique_categorie . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Historique/delete/' . $row->ID_HISTORIQUE) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";


			$stat = '';

			if ($row->IS_PAID == 1) {
				$val_stat = '<button class="btn btn-info" style="white-space: nowrap">Payé</button>';
			} else {
				$val_stat = '<button class="btn btn-outline-info" style="white-space: nowrap">Non payé</button>';
			}

			$stat .= "<a href='#' data-toggle='modal'
			data-target='#stat" . $row->ID_HISTORIQUE . "'><font color='blue'>&nbsp;&nbsp;" . $val_stat . "</font></a>";

			$stat .= " 
			<div class='modal fade' id='stat" .  $row->ID_HISTORIQUE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center>
			<p> Voulez-vous changer le statut?<br></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-primary btn-md' href='" . base_url('PSR/Historique/change_statut/' . $row->ID_HISTORIQUE . '/' . $row->IS_PAID) . "'>Changer</a>
			<button class='btn btn-danger btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

                              $option = "<a class='btn  btn-sm btn-outline-secondary' onclick='getDetailControl(".$row->ID_HISTORIQUE.")'  href='#'>🧐voir plus...</a>";

			$sub_array = array();
			$sub_array[] =  '<a class="nav-link" href="' . base_url('ihm/Performance_Police/index/' . $row->ID_PSR_ELEMENT) . '"><table> <tbody><tr><td><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="https://app.mediabox.bi/wasiliEate/uploads/personne.png"></td><td>' . str_replace(" ", "<span style='color:#dee2e6'>_</span>", $row->user) . '<br>' . $row->NUMERO_MATRICULE . '</td></tr></tbody></table></a>';
			// <font style="font-size:10px;color:red"><i class="far fa-comment-dots"></i></font>
			//$sub_array[]=$row->historique_categorie;
			$sub_array[] = "<div class='text-center text-sm'>".(new DateTime($row->DATE_INSERTION, new DateTimeZone("Africa/Bujumbura")))->format('d-m-Y') . '<br>'.(new DateTime($row->DATE_INSERTION, new DateTimeZone("Africa/Bujumbura")))->format('H:i')."</div>";
                              $sub_array[] = ucfirst(str_replace('Contrôle ', '', $row->historique_categorie));
                              if($row->RAISON_ANNULATION == null) {
                                        $annule = "<span class='btn btn-outline-info disabled'>Non</span>";
                              } else {
                                        $annule = "<span class='btn btn-danger'>Oui</span>";
                              }
                              $sub_array[] = $annule;
			$sub_array[] = $plaque;
			$sub_array[] = $permis;
			$montant =  !empty($montant) ? number_format(floatval($montant), 0, ',', ' ') : 0;
			$sub_array[] = "<b style='float:right'>" . $montant . "</b>";
			$sub_array[] = $stat;


			/*$sub_array[] = $row->ID_IMMATRICULATIO_PEINE == 2  ? $detailInfraimmatri : $infra;
			$sub_array[] = ($row->ID_ASSURANCE_PEINE == 3 || $row->ID_ASSURANCE_PEINE == 5) ? $detailInfrassur : $infrassur;
			$sub_array[] = ($row->ID_CONTROLE_TECHNIQUE_PEINE == 7 || $row->ID_CONTROLE_TECHNIQUE_PEINE == 8) ? $detailInfrcontroltechnique : $infracontrp;
			$sub_array[] = $row->ID_VOL_PEINE == 9 ? $detailInfravol : $infravol;
			$sub_array[] = $row->ID_PERMIS_PEINE == 12 ? $detailInfrapermis : $infrapermis;
			$sub_array[] = $permis;
			$sub_array[] = $comportPermis;
			$sub_array[] = $controlePhysique ? $controlePhysique : $detail;
			$sub_array[] = $detailEqui;
			$sub_array[] = $detailMarch; */
			// $sub_array[] = $controleSignalement ? $controleSignalement : $detailEqui;

			
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

	function change_statut($ID_HISTORIQUE, $IS_PAID)
	{
		if ($IS_PAID == 1) {
			$val = 0;
		}

		if ($IS_PAID == 0) {
			$val = 1;
		}

		$this->Modele->update('historiques', array('ID_HISTORIQUE' => $ID_HISTORIQUE), array('IS_PAID' => $val));

		$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du statut est faite avec succès</div>';
		$this->session->set_flashdata($datas);
		redirect(base_url('PSR/Historique'));
	}


	function getInfraImmatri($id_immatri = 0)
	{

		$dataDetail = 'SELECT ID_INFRA_PEINE, ID_INFRA_INFRACTION, AMENDES, MONTANT, POINTS FROM infra_peines WHERE 1 AND ID_INFRA_INFRACTION= ' . $id_immatri;
		// print_r($this->Modele->getRequete($dataDetail));die();

		$htmlDetail = "<div class='table-responsive'>

		<b>".$this->getIfraction($id_immatri)."</b>
		<table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
		<thead>
		<tr>
		<th>Application</th>
		<th>Montant</th>
		</tr>
		</thead>
		<tbody>";
	

		$total = 0;
		foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

			$total += $value['MONTANT'];
			$htmlDetail .= "<tr>
			<td>" . $value['AMENDES'] . "</td>
			<td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . " FBU</span></td>
			</tr>";
		}

		$htmlDetail .= "<tr>
		<th>Total</th>
		<th><span style='float:right'> FBU</th>
		</span></tr>";


		// </div></th>
		//                </tr>";

		$htmlDetail .= "</tbody></table>
		</div>";


		return $htmlDetail;
	}








	function getDetail($id){

		$query_principal = 'SELECT h.ID_COMPORTEMENT, ID_CONTROLE_MARCHANDISE,ID_HISTORIQUE,h.ID_CONTROLE,h.ID_HISTORIQUE_CATEGORIE, hc.DESCRIPTION as historique_categorie,
		(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_IMMATRICULATIO_PEINE) AS IMMATRICULATION,
		(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_ASSURANCE_PEINE) AS ASSURANCE,
		(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_CONTROLE_TECHNIQUE_PEINE) AS CONTROL_TECHNIQUE,
		(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_VOL_PEINE) AS VOL,(SELECT NIVEAU_ALERTE FROM infra_infractions WHERE ID_INFRA_INFRACTION= ID_PERMIS_PEINE) AS PERMIS_PEINE, h.NUMERO_PLAQUE ,ID_IMMATRICULATIO_PEINE,ID_ASSURANCE_PEINE,ID_CONTROLE_TECHNIQUE_PEINE,ID_VOL_PEINE,ID_PERMIS_PEINE, NUMERO_PERMIS, concat(pe.NOM," ",pe.PRENOM) as user,pe.NUMERO_MATRICULE,pe.ID_PSR_ELEMENT, h.LATITUDE, h.LONGITUDE,h.DATE_INSERTION,h.MONTANT,h.IS_PAID,ID_CONTROLE_EQUIPEMENT,ID_SIGNALEMENT FROM historiques h LEFT JOIN historiques_categories hc ON h.ID_HISTORIQUE_CATEGORIE=hc.ID_CATEGORIE LEFT JOIN utilisateurs us ON us.ID_UTILISATEUR=h.ID_UTILISATEUR  LEFT JOIN psr_elements pe ON pe.ID_PSR_ELEMENT = us.PSR_ELEMENT_ID WHERE 1 and ID_HISTORIQUE='.$id;

		$data=$this->Modele->getRequeteOne($query_principal);
		$controle='';
		$controle_technique='';
		$assurance='';
		$permis='';
		$vol='';
		$comportement='';
		$detailControle='';
		$equipement='';

          $marchandise='';

		 //print_r($data['ID_IMMATRICULATIO_PEINE']);exit();
		if($data['ID_IMMATRICULATIO_PEINE'] !=null){
			$controle=$this->getInfraImmatri($data['ID_IMMATRICULATIO_PEINE']);
		}

		//print_r($controle);exit();
		
		if($data['ID_CONTROLE_TECHNIQUE_PEINE'] !=null){
	        $controle_technique =$this->getInfracontroleTechnique($data['ID_CONTROLE_TECHNIQUE_PEINE'])	;
		}

		if($data['ID_ASSURANCE_PEINE'] !=null){
           $assurance =$this->getInfrassur($data['ID_ASSURANCE_PEINE']);
		}
	
		if($data['ID_VOL_PEINE'] !=null){
           $vol =$this->getInfraVol($data['ID_VOL_PEINE']);
			
		}

		if($data['ID_PERMIS_PEINE'] !=null){
           $permis =$this->getInfraPermis($data['ID_PERMIS_PEINE']);
			
		}


		if($data['ID_COMPORTEMENT'] !=null){
           $comportement =$this->getDetailComport($data['ID_COMPORTEMENT']);
			
		}

		if($data['ID_CONTROLE'] !=null){
           $detailControle =$this->getDetais($data['ID_CONTROLE']);
			
		}

		if($data['ID_CONTROLE_EQUIPEMENT'] !=null){
           $equipement =$this->getDetailEQUI($data['ID_CONTROLE_EQUIPEMENT']);
			
		}

		if($data['ID_CONTROLE_MARCHANDISE'] !=null){
           $marchandise =$this->getDetailMarchandise($data['ID_CONTROLE_MARCHANDISE']);
			
		}


		

	     //print_r($controle_technique);exit();

		$data['immatriculation'] = $controle;
		$data['vol'] = $vol;
		$data['assurance'] = $assurance;
		$data['permis'] = $permis;
		$data['comportement'] = $comportement;
		$data['detailControle'] = $detailControle;
		$data['equipement'] = $equipement;
		$data['marchandise'] = $marchandise;


		$data['historique'] = $query_principal;
		$data['title'] = 'Historiques detail';
		$this->load->view('detail_view', $data);
	}




	function getIfraction($id){

		$dataDetail = 'SELECT `NIVEAU_ALERTE` FROM `infra_infractions` WHERE `ID_INFRA_INFRACTION`= ' . $id;
        $donne = $this->Modele->getRequeteOne($dataDetail);

        return $donne['NIVEAU_ALERTE'];

	}


	function getInfrassur($id_immatri = 0)
	{

		$dataDetail = 'SELECT ID_INFRA_PEINE, ID_INFRA_INFRACTION, AMENDES, MONTANT, POINTS FROM infra_peines WHERE 1 AND ID_INFRA_INFRACTION= ' . $id_immatri;


		$htmlDetail = "<div class='table-responsive'><b>".$this->getIfraction($id_immatri)."</b>

		<table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
		<thead>
		<tr>
		<th>Application</th>
		<th>Montant</th>
		</tr>
		</thead>

		<tbody>";

		$total = 0;
		foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

			$total += $value['MONTANT'];
			$htmlDetail .= "<tr>
			<td>" . $value['AMENDES'] . "</td>
			<td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . " FBU</span></td>
			</tr>";
		}

		$htmlDetail .= "<tr>
		<th>Total</th>
		<th><span style='float:right'>" . number_format($total, 0, '.', ' ') . " FBU</th>
		</span></tr>";


		$htmlDetail .= "</tbody></table>
		</div>";


		return $htmlDetail;
	}

	function getInfraPermis($id_immatri = 0)
	{
		$dataDetail = 'SELECT ID_INFRA_PEINE, ID_INFRA_INFRACTION, AMENDES, MONTANT, POINTS FROM infra_peines WHERE 1 AND ID_INFRA_INFRACTION= ' . $id_immatri;


		$htmlDetail = "<div class='table-responsive'>
		<b>".$this->getIfraction($id_immatri)."</b>
		<table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
		<thead>
		<tr>
		<th>Application</th>
		<th>Montant</th>
		</tr>
		</thead>

		<tbody>";

		$total = 0;
		foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

			$total += $value['MONTANT'];
			$htmlDetail .= "<tr>
			<td>" . $value['AMENDES'] . "</td>
			<td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . " FBU</span></td>
			</tr>";

		}

		$htmlDetail .= "<tr>
		<th>Total</th>
		<th><span style='float:right'>" . number_format($total, 0, '.', ' ') . " FBU</th>
		</span></tr>";

		

		$htmlDetail .= "</tbody></table>
		</div>";


		return $htmlDetail;
	}

	function getInfraVol($id_immatri = 0)
	{

		$dataDetail = 'SELECT ID_INFRA_PEINE, ID_INFRA_INFRACTION, AMENDES, MONTANT, POINTS FROM infra_peines WHERE 1 AND ID_INFRA_INFRACTION= ' . $id_immatri;


		$htmlDetail = "<div class='table-responsive'>
		<b>".$this->getIfraction($id_immatri)."</b>
		<table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
		<thead>
		<tr>
		<th>Application</th>
		<th>Montant</th>
		</tr>
		</thead>

		<tbody>";

		$total = 0;
		foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

			$total += $value['MONTANT'];
			$htmlDetail .= "<tr>
			<td>" . $value['AMENDES'] . "</td>
			<td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . " FBU</span></td>
			</tr>";
		}

		$htmlDetail .= "<tr>
		<th>Total</th>
		<th><span style='float:right'>" . number_format($total, 0, '.', ' ') . " FBU</th>
		</span></tr>";


		$htmlDetail .= "</tbody></table>
		</div>";


		return $htmlDetail;
	}


	function getInfracontroleTechnique($technique)
	{

		$dataDetail = 'SELECT ID_INFRA_PEINE, ID_INFRA_INFRACTION, AMENDES, MONTANT, POINTS FROM infra_peines WHERE 1 AND ID_INFRA_INFRACTION= ' . $technique;


		$htmlDetail = "<div class='table-responsive'>
		<b>".$this->getIfraction($technique)."</b>
		<table id='mytable2' class='table table-bordered table-striped table-hover table-condensed' style='width:100%'>
		<thead>
		<tr>
		<th>Application</th>
		<th>Montant</th>
		</tr>
		</thead>

		<tbody>";

		$total = 0;
		foreach ($this->Modele->getRequete($dataDetail) as $key => $value) {

			$total += $value['MONTANT'];
			$htmlDetail .= "<tr>
			<td>" . $value['AMENDES'] . "</td>
			<td><span style='float:right'>" . number_format($value['MONTANT'], 0, '.', ' ') . " FBU</span></td>
			</tr>";
		}

		$htmlDetail .= "</tbody></table>
		</div>";


		return $htmlDetail;
	}

	function delete()
	{
		$table = "historiques";
		$criteres['ID_HISTORIQUE'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Historique'));
	}
}
