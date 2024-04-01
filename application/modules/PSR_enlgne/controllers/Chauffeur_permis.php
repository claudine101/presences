<?php

/**
 *NTAHIMPERA Martin Luther King
 *	Element de la police 
 **/
class Chauffeur_permis extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		if ($this->session->userdata('PERMIS') != 1 && $this->session->userdata('PSR_ELEMENT') != 1) {

			redirect(base_url());
		}
	}
	function index()
	{
		$data['title'] = 'Liste des permis';
		$data['instutions'] = $this->Model->getRequete('SELECT ID_PSR_INSTITUTION,NOM_INSTITUTION FROM psr_institution WHERE 1 ORDER BY NOM_INSTITUTION ASC');
		$this->load->view('permis_list_v', $data);
	}

	function listing()
	{
		$i = 1;
        $ID_PSR_INSTITUTION = $this->input->post('ID_PSR_INSTITUTION');
        $critere_institution = !empty($ID_PSR_INSTITUTION) ? " AND pi.ID_PSR_INSTITUTION=".$ID_PSR_INSTITUTION." ":"";
		$query_principal = "SELECT cp.ID_PERMIS, cp.NUMERO_PERMIS, cp.NOM_PROPRIETAIRE, cp.CATEGORIES, cp.DATE_NAISSANCE, cp.DATE_DELIVER, cp.DATE_EXPIRATION,cp.TELEPHONE,cp.LOGO_PROFIL,pi.NOM_INSTITUTION FROM chauffeur_permis cp LEFT  JOIN  psr_institution pi ON pi.ID_PSR_INSTITUTION=cp.ID_PSR_INSTITUTION
		WHERE 1 " .$critere_institution ;

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';


		$order_column = array('LOGO_PROFIL','NUMERO_PERMIS','NOM_PROPRIETAIRE','TELEPHONE', 'CATEGORIES','NOM_INSTITUTION', 'DATE_NAISSANCE', 'DATE_DELIVER', 'DATE_EXPIRATION');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY Nom ASC';

		$search = !empty($_POST['search']['value']) ? ("AND NUMERO_PERMIS LIKE '%$var_search%' OR NOM_PROPRIETAIRE LIKE '%$var_search%' OR CATEGORIES LIKE '%$var_search%'  ") : '';

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
			data-target='#mydelete" . $row->ID_PERMIS . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Chauffeur_permis/getOne/' . $row->ID_PERMIS) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= "<li>
              <a class='btn-md' title='".$row->NUMERO_PERMIS."' onclick='show_permis(this.title)' class='btn btn-md dt-button btn-sm' href='#'><label class='text-info'>&nbsp;&nbsp;TB Permis</label></a>
			</li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" . $row->ID_PERMIS . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->NOM_PROPRIETAIRE . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Chauffeur_permis/delete/' . $row->ID_PERMIS) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$debut = date("d-m-Y", strtotime($row->DATE_DELIVER));
			$fin = date("d-m-Y", strtotime($row->DATE_EXPIRATION));

			$source = !empty($row->LOGO_PROFIL) ? $row->LOGO_PROFIL : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			$sub_array = array();
			$sub_array[] = '<table> <tbody><tr><td><a title="' . $source . '" href="#" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td></td></tr></tbody></table></a>';

			$sub_array[] = "<a title='".$row->NUMERO_PERMIS."' onclick='show_permis(this.title)' class='btn btn-md dt-button btn-sm' href='#'>" .$row->NUMERO_PERMIS. "</a>";
			$sub_array[] = $row->NOM_PROPRIETAIRE;
			$sub_array[] = !empty($row->TELEPHONE)?$row->TELEPHONE:'N/A';
			$sub_array[] = $row->CATEGORIES;
			$sub_array[] = !empty($row->NOM_INSTITUTION)?$row->NOM_INSTITUTION:'N/A';
			$sub_array[] = $this->notifications->ago($row->DATE_NAISSANCE, date('Y-m-d'));
			$sub_array[] = $debut;
			$sub_array[] = $fin;
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

		$data['title'] = 'Nouveau Permis';
		$this->load->view('permis_add_v', $data);
	}
	// POUR  VERIFIER SI  LA VALEUR D'UN POUR CONTIENT LE CARACTERE ' "' 
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

		$this->form_validation->set_rules('NUMERO_PERMIS', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NOM_PROPRIETAIRE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('CATEGORIES', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DATE_NAISSANCE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DATE_DELIVER', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DATE_EXPIRATION', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$data_insert = array(
				'NUMERO_PERMIS' => $this->input->post('NUMERO_PERMIS'),
				'NOM_PROPRIETAIRE' => $this->input->post('NOM_PROPRIETAIRE'),
				'CATEGORIES' => $this->input->post('CATEGORIES'),
				'DATE_NAISSANCE' => $this->input->post('DATE_NAISSANCE'),
				'DATE_DELIVER' => $this->input->post('DATE_DELIVER'),
				'DATE_EXPIRATION' => $this->input->post('DATE_EXPIRATION'),
			);
			$table = 'chauffeur_permis';
			$this->Modele->create($table, $data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Chauffeur_permis/index'));
		}
	}
	function getOne($id = 0)
	{
		$data['title'] = "Modification d'un Permis";
		$data['data'] = $this->Modele->getOne('chauffeur_permis', array('ID_PERMIS' => $id));
		$this->load->view('permis_update_v', $data);
	}

	function update()
	{

		$this->form_validation->set_rules('NUMERO_PERMIS', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NOM_PROPRIETAIRE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('CATEGORIES', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DATE_NAISSANCE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DATE_DELIVER', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DATE_EXPIRATION', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));



		$id = $this->input->post('ID_PERMIS');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {
			$id = $this->input->post('ID_PERMIS');

			$data = array(
				'NUMERO_PERMIS' => $this->input->post('NUMERO_PERMIS'),
				'NOM_PROPRIETAIRE' => $this->input->post('NOM_PROPRIETAIRE'),
				'CATEGORIES' => $this->input->post('CATEGORIES'),
				'DATE_NAISSANCE' => $this->input->post('DATE_NAISSANCE'),
				'DATE_DELIVER' => $this->input->post('DATE_DELIVER'),
				'DATE_EXPIRATION' => $this->input->post('DATE_EXPIRATION'),
			);

			$this->Modele->update('chauffeur_permis', array('ID_PERMIS' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('PSR/Chauffeur_permis/index'));
		}
	}

	function delete()
	{
		$table = "chauffeur_permis";
		$criteres['ID_PERMIS'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Chauffeur_permis/index'));
	}


	public function add_excel()
	{



		$highestRow=0;
        $path = $_FILES["FICHIER"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);

      foreach($object->getWorksheetIterator() as $worksheet)
      {
        $highestRow.=$worksheet->getHighestRow();
        $highestColumn=$worksheet->getHighestColumn();
    //print_r($highestRow);die();
        $i=0;
        for($row=2; $row<=$highestRow; $row++)
        {
            //     

          $NUMERO_PERMIS=$worksheet->getCellByColumnAndRow(0, $row)->getValue();
          $NOM_PROPRIETAIRE=$worksheet->getCellByColumnAndRow(1, $row)->getValue();
          $DATE_NAISSANCE=$worksheet->getCellByColumnAndRow(2, $row)->getValue();
          $DATE_NAISSANCE = PHPExcel_Style_NumberFormat::toFormattedString($DATE_NAISSANCE, 'YYYY-MM-DD');

          $DATE_DELIVER=$worksheet->getCellByColumnAndRow(3, $row)->getValue();
          $DATE_DELIVER = PHPExcel_Style_NumberFormat::toFormattedString($DATE_DELIVER, 'YYYY-MM-DD');

          $DATE_EXPIRATION=$worksheet->getCellByColumnAndRow(4, $row)->getValue();
          $DATE_EXPIRATION = PHPExcel_Style_NumberFormat::toFormattedString($DATE_EXPIRATION, 'YYYY-MM-DD');
          
          $POINTS=$worksheet->getCellByColumnAndRow(5, $row)->getValue();
          
				
          $data_insert = array(
				'NUMERO_PERMIS' => trim($NUMERO_PERMIS),
				'NOM_PROPRIETAIRE' => trim($NOM_PROPRIETAIRE),
				'DATE_NAISSANCE' => trim($DATE_NAISSANCE),
				'DATE_DELIVER' => trim($DATE_DELIVER),
				'DATE_EXPIRATION' => trim($DATE_EXPIRATION),
				'POINTS' => trim($POINTS),
			);

        // echo "<pre>";
        // print_r($data_importation);
        // echo "</pre>";

			$tabl = 'chauffeur_permis';
			$this->Modele->create($tabl, $data_insert);

        }

    }  /* 
         */

    $donnee['message']='<div id="message" class="alert alert-info text-center">Importé avec succès</div>';
    $this->session->set_flashdata($donnee);
    redirect(base_url('PSR/Chauffeur_permis/index'));

		

	}
}
