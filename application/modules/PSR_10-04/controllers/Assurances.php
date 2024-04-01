<?php

/**
 *Allan
 *	Element de la police 
 **/
class Assurances extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->have_droit();
		 ini_set('memory_limit', '256M');
	}
	public function have_droit()
	{
		if ($this->session->userdata('ASSURANCE') != 1 && $this->session->userdata('PSR_ELEMENT') != 1) {

			redirect(base_url());
		}
	}

	function index()
	{

		if ($this->session->userdata('PROFIL_ID') == 2) {

       	$inputs = $this->session->userdata('ID_INSTITUTION');

       	$condition =  " AND ID_ASSUREUR =".$inputs;


        $assureur = $this->Model->getRequeteOne('SELECT ID_ASSUREUR, ASSURANCE FROM assureur WHERE 1 '.$condition.'  ORDER BY ASSURANCE ASC');
        $data['title'] = "Souscripteurs de ".$assureur['ASSURANCE'];

       }else{
       	
	   $data['title'] = 'Souscripteurs';

       }
        $condition = "";
		if ($this->session->userdata('PROFIL_ID') == 2) {
       	 $condition = " and ID_ASSUREUR =".$this->session->userdata('ID_INSTITUTION');
        }
		$data['assurances'] = $this->Model->getRequete('SELECT ID_ASSUREUR, ASSURANCE FROM assureur WHERE 1 '.$condition.'  ORDER BY ASSURANCE ASC');
		$this->load->view('assurances/assurance_list', $data);
	}

	function listing()
	{
		$i = 1;
      
      $inputs = "";
       
       if (($this->session->userdata('PROFIL_ID') == 2) && !empty($this->session->userdata('ID_INSTITUTION'))) {
       	$inputs.= $this->session->userdata('ID_INSTITUTION');
       }else{
       	
	    $inputs.= !empty($this->input->post('ID_ASSUREUR0')) ? $this->input->post('ID_ASSUREUR0') : $this->input->post('ID_ASSUREUR');

       }


	   $id_assureur =  !empty($inputs) ? "  AND assurances_vehicules.ID_ASSUREUR =".$inputs." " : " ";



		$query_principal = "SELECT PHONE,ID_ASSURANCE, assurances_vehicules.NUMERO_PLAQUE,obr.ID_IMMATRICULATION, assurances_vehicules.ID_ASSUREUR,assureur.ASSURANCE, DATE_DEBUT, DATE_VALIDITE, PLACES_ASSURES, TYPE_ASSURANCE, assurances_vehicules.NOM_PROPRIETAIRE,assurances_vehicules.DATE_INSERTION FROM assurances_vehicules left join assureur on assureur.ID_ASSUREUR=assurances_vehicules.ID_ASSUREUR LEFT JOIN obr_immatriculations_voitures obr ON obr.NUMERO_PLAQUE=assurances_vehicules.NUMERO_PLAQUE WHERE 1 " . $id_assureur;

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);

		$limit = 'LIMIT 0,10';


		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by_a =  !empty($order_column[$_POST['order']['0']['column']]) ? $order_column[$_POST['order']['0']['column']] : 'DATE_INSERTION';

		

		$order_column = array('NUMERO_PLAQUE','PHONE', 'NOM_ASSUREUR', 'DATE_DEBUT', 'DATE_VALIDITE', 'PLACES_ASSURES', 'TYPE_ASSURANCE', 'NOM_PROPRIETAIRE','assurances_vehicules.DATE_INSERTION');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_by_a . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_INSERTION ';

		$search = !empty($_POST['search']['value']) ? ("  AND ( assurances_vehicules.NUMERO_PLAQUE LIKE '%$var_search%' OR ASSURANCE LIKE '%$var_search%' OR assurances_vehicules.NOM_PROPRIETAIRE LIKE '%$var_search%' OR assurances_vehicules.DATE_INSERTION LIKE '%$var_search%' AND assurances_vehicules.PHONE LIKE '%$var_search%' ) ") : '';

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
			data-target='#mydelete" . $row->ID_ASSURANCE . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('PSR/Assurances/getOne/' . $row->ID_ASSURANCE) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" . $row->ID_ASSURANCE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->NUMERO_PLAQUE . "</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('PSR/Assurances/delete/' . $row->ID_ASSURANCE) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$debut = date("d-m-Y", strtotime($row->DATE_DEBUT));
			$fin = date("d-m-Y", strtotime($row->DATE_VALIDITE));
			$sub_array = array();
			//$sub_array[]=$i++;

			if ($row->ID_IMMATRICULATION != null) {
				$sub_array[] = "<a title='".$row->NUMERO_PLAQUE."' onclick='show_vehicule(this.title)' class='btn btn-md dt-button btn-sm' href='#'>" .$row->NUMERO_PLAQUE. "</a>";
			} else {
				$sub_array[] = "<span style='color :red'>" . $row->NUMERO_PLAQUE . "</span>";
			}

			$sub_array[] = $row->ASSURANCE;
			$sub_array[] = $debut;
			$sub_array[] = $fin;
			$sub_array[] = $this->notifications->ago($debut, $fin);
			$sub_array[] = $row->PLACES_ASSURES;
			$sub_array[] = $row->TYPE_ASSURANCE;
			$sub_array[] = $row->NOM_PROPRIETAIRE;
			$sub_array[] = $row->PHONE;
			$sub_array[] = $row->DATE_INSERTION;
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
		$data['plaques'] = $this->Model->getRequete('SELECT ID_IMMATRICULATION, NUMERO_PLAQUE FROM obr_immatriculations_voitures WHERE 1 ORDER BY NUMERO_PLAQUE ASC');
		
		$condition = "";
		if ($this->session->userdata('PROFIL_ID') == 2) {
       	 $condition = " and ID_ASSUREUR =".$this->session->userdata('ID_INSTITUTION');
        }
		$data['assurances'] = $this->Model->getRequete('SELECT ID_ASSUREUR, ASSURANCE FROM assureur WHERE 1 ' . $condition . ' ORDER BY ASSURANCE ASC');


		$data['title'] = 'Nouvelle Assurances';
		$this->load->view('assurances/assurance_add_v', $data);
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

		$this->form_validation->set_rules('NUMERO_PLAQUE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('ID_ASSUREUR', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DATE_DEBUT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DATE_VALIDITE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PLACES_ASSURES', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('TYPE_ASSURANCE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NOM_PROPRIETAIRE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PHONE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$data_insert = array(
				'NUMERO_PLAQUE' => $this->input->post('NUMERO_PLAQUE'),
				'ID_ASSUREUR' => $this->input->post('ID_ASSUREUR'),
				'DATE_DEBUT' => $this->input->post('DATE_DEBUT'),
				'DATE_VALIDITE' => $this->input->post('DATE_VALIDITE'),
				'PLACES_ASSURES' => $this->input->post('PLACES_ASSURES'),
				'TYPE_ASSURANCE' => $this->input->post('TYPE_ASSURANCE'),
				'NOM_PROPRIETAIRE' => $this->input->post('NOM_PROPRIETAIRE'),
				'PHONE' => $this->input->post('PHONE'),
			);
			$table = 'assurances_vehicules';
			$this->Modele->create($table, $data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('PSR/Assurances/index'));
		}
	}


	function getOne($id)
	{
		$data['data'] = $this->Modele->getOne('assurances_vehicules', array('ID_ASSURANCE' => $id));
		$data['plaques'] = $this->Model->getRequete('SELECT ID_IMMATRICULATION, NUMERO_PLAQUE FROM obr_immatriculations_voitures WHERE 1 ORDER BY NUMERO_PLAQUE ASC');

		$condition = "";
		if ($this->session->userdata('PROFIL_ID') == 2) {
       	 $condition = " and ID_ASSUREUR =".$this->session->userdata('ID_INSTITUTION');
        }
		$data['assurances'] = $this->Model->getRequete('SELECT ID_ASSUREUR, ASSURANCE FROM assureur WHERE 1 ' . $condition . '  ORDER BY ASSURANCE ASC');

		$data['title'] = "Modification D'ASSURANCES";
		$this->load->view('assurances/assurance_update_v', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('NUMERO_PLAQUE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('ID_ASSUREUR', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DATE_DEBUT', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('DATE_VALIDITE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PLACES_ASSURES', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('TYPE_ASSURANCE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NOM_PROPRIETAIRE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('PHONE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		$id = $this->input->post('ID_ASSUREUR');

		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {
			$id = $this->input->post('ID_ASSUREUR');
			$phone = $this->input->post('TELEPHONE');

			$data = array(
				'NUMERO_PLAQUE' => $this->input->post('NUMERO_PLAQUE'),
				'ID_ASSUREUR' => $this->input->post('ID_ASSUREUR'),
				'DATE_DEBUT' => $this->input->post('DATE_DEBUT'),
				'DATE_VALIDITE' => $this->input->post('DATE_VALIDITE'),
				'PLACES_ASSURES' => $this->input->post('PLACES_ASSURES'),
				'TYPE_ASSURANCE' => $this->input->post('TYPE_ASSURANCE'),
				'NOM_PROPRIETAIRE' => $this->input->post('NOM_PROPRIETAIRE'),
				'PHONE' => $this->input->post('PHONE'),
			);

			$this->Modele->update('assurances_vehicules', array('ID_ASSURANCE' => $id), $data);

			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('PSR/Assurances/'));
		}
	}
	function delete()
	{
		$table = "assurances_vehicules";
		$criteres['ID_ASSURANCE'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('PSR/Assurances/index'));
	}

	public function add_excel(){
		$highestRow=0;
        $path = $_FILES["FICHIER"]["tmp_name"];

        $ID_ASSUREUR = $this->input->post('ID_ASSUREUR');


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

          $NUMERO_PLAQUE=$worksheet->getCellByColumnAndRow(0, $row)->getValue();
          $ID_ASSUREUR= $this->input->post('ID_ASSUREUR');
          $ID_UTILISATEUR = $this->session->userdata('');
          $NUMERO_ASSURANCE=$worksheet->getCellByColumnAndRow(1, $row)->getValue();
          $NOM_PROPRIETAIRE=$worksheet->getCellByColumnAndRow(2, $row)->getValue();


          $DATE_DEBUT=$worksheet->getCellByColumnAndRow(3, $row)->getValue();
          $DATE_DEBUT = PHPExcel_Style_NumberFormat::toFormattedString($DATE_DEBUT, 'YYYY-MM-DD');

          $DATE_VALIDITE=$worksheet->getCellByColumnAndRow(4, $row)->getValue();
          $DATE_VALIDITE = PHPExcel_Style_NumberFormat::toFormattedString($DATE_VALIDITE, 'YYYY-MM-DD');


          $PLACES_ASSURES=$worksheet->getCellByColumnAndRow(5, $row)->getValue();
          $TYPE_ASSURANCE=$worksheet->getCellByColumnAndRow(6, $row)->getValue();
          $TELEPHONE=$worksheet->getCellByColumnAndRow(7, $row)->getValue();

          $plaquess = $this->remplace_lettre($NUMERO_PLAQUE);


          if (!empty($plaquess)) {
          	
          
          $data_insert = array(
				'NUMERO_PLAQUE' => $plaquess,
				'ID_ASSUREUR' => trim($ID_ASSUREUR),
				'DATE_DEBUT' => trim($DATE_DEBUT),
				'DATE_VALIDITE' => trim($DATE_VALIDITE),
				'PLACES_ASSURES' => trim($PLACES_ASSURES),
				'TYPE_ASSURANCE' => trim($TYPE_ASSURANCE),
				'NOM_PROPRIETAIRE' => trim($NOM_PROPRIETAIRE),
				'PHONE' => trim($TELEPHONE),
				'ID_UTILISATEUR' => $this->session->userdata('USER_ID'),
				'IS_EXCEL'=> 1

			);

	        // echo "<pre>";
	        // print_r($data_importation);
	        // echo "</pre>";

			$tabl = 'assurances_vehicules';
			$this->Modele->create($tabl, $data_insert);

          }


       }

    }  /* 
         */

    $donnee['message']='<div id="message" class="alert alert-info text-center">Importé avec succès</div>';
    $this->session->set_flashdata($donnee);
    redirect(base_url('PSR/Assurances/index'));
	}



    function remplace_lettre($message = "")
  {

      $message = trim(str_replace(' ', '', $message));
      $message = str_replace("\n", "", $message);
      $message = str_replace("\r", "", $message);
      $message = str_replace("\t", "", $message);
      $message = str_replace("|", "", $message);
      $message = str_replace("/", "", $message);
      $message = str_replace("-", "", $message);
      $message = str_replace(".", "", $message);
      $message = str_replace(";", "", $message);
      $message = str_replace(",", "", $message);
      $message = str_replace("+", "", $message);
      $message = str_replace("*", "", $message);

    return  strtoupper($message);
  }




}
