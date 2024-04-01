<?php
class Money extends CI_Controller
{

     function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}
	public function have_droit()
	{
		if ($this->session->userdata('IHM') != 1) {

			redirect(base_url());
		}
	}
	function index()
	{
		$data['title'] = "Liste de monnaie ";
		

		$this->load->view('money/Money_Liste_View', $data);
	}
	function listing()
	{
		$i = 1;
		$query_principal = "SELECT `ID_MONEY`,`CommonName`, `MONEY`, `SYMBOLE`, `ID_PAYS`, `STATUT_USAGE`, `DATE_INSERT` FROM `psr_current_money` LEFT  JOIN  countries  c ON COUNTRY_ID=ID_PAYS WHERE 1";

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		

		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {

			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}
		$order_by = '';

		$order_column = array('MONEY', 'SYMBOLE', 'ID_PAYS', 'STATUT_USAGE','DATE_INSERT');

		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY STATUT_USAGE ASC';

		$search = !empty($_POST['search']['value']) ? ("AND STATUT_USAGE LIKE '%$var_search%' ") : '';
		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;



		$fetch_peine = $this->Modele->datatable($query_secondaire);
		$data = array();
		foreach ($fetch_peine as $row) {
		    if($row->STATUT_USAGE==0)
              {   $labelle='Activer';
                  $color = 'red';
                  $btn = 'btn-danger';
              }else {
                  $labelle='Désactiver';
                  $color = 'green';
                  $btn = 'btn-success';
              }
		     $option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">';
			$option .= "<li><a hre='#'  id='".$row->SYMBOLE."'  title='".$row->MONEY."'  onclick='supprimer(".$row->ID_MONEY.",this.title,this.id)'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Money/getOne/' . $row->ID_MONEY) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$row->STATUT_USAGE==0 ?
               $option .= "<li><hre='#'  id='".$row->MONEY."'  title='".$row->MONEY."'  onclick='activer(".$row->ID_MONEY.",this.title,this.id)'><font color='".$color."'>&nbsp;&nbsp;".$labelle."</font></a></li>":$option .= "<li><hre='#'  id='".$row->MONEY."'  title='".$row->MONEY."'  onclick='desactiver(".$row->ID_MONEY.",this.title,this.id)'><font color='".$color."'>&nbsp;&nbsp;".$labelle."</font></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_MONEY . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-body'>
			<center><h4 style='color:black;'><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->SYMBOLE . "</i></b></h4></center>
			</div>
			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Chaussee/delete/' . $row->ID_MONEY) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>
			</div>
			</div>
			</div>";
			$sub_array = array();
			$sub_array[] = $row->MONEY;
			$sub_array[] = $row->SYMBOLE;
			$sub_array[] = $row->CommonName;
			$sub_array[] = $row->STATUT_USAGE==1 ? 'Usage' :'			No usage';
			$sub_array[] = $row->DATE_INSERT;
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
		$data['countries'] = $this->Model->getRequete('SELECT COUNTRY_ID,CommonName FROM countries WHERE 1 ORDER BY CommonName ASC');
		$data['title'] = 'Nouvelle monnaie';
		$this->load->View('money/Money_Add_View', $data);
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

		$this->form_validation->set_rules('MONEY', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('SYMBOLE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_PAYS', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} else {

			$data_insert = array(

				'MONEY' => $this->input->post('MONEY'),
				'SYMBOLE' => $this->input->post('SYMBOLE'),
				'ID_PAYS' => $this->input->post('ID_PAYS'),
			);

			$table = 'psr_current_money';
			$this->Modele->create($table, $data_insert);

			$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Money/index'));
		}
	}
     
	function getOne($id)
	{
		
		$data['moneys'] = $this->Modele->getOne('psr_current_money', array('ID_MONEY' => $id));
          $data['countries'] = $this->Model->getRequete('SELECT COUNTRY_ID,CommonName FROM countries WHERE 1 ORDER BY CommonName ASC');
		$data['title'] = 'Modification de la monnaie';

		$this->load->view('money/Money_update_View', $data);
	}


	function update()
	{
          $this->form_validation->set_rules('MONEY', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('SYMBOLE', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ID_PAYS', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$id = $this->input->post('ID_MONEY');
		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {
			$id = $this->input->post('ID_MONEY');

			$data_insert = array(

				'MONEY' => $this->input->post('MONEY'),
				'SYMBOLE' => $this->input->post('SYMBOLE'),
				'ID_PAYS' => $this->input->post('ID_PAYS'),
			);

			$this->Modele->update('psr_current_money', array('ID_MONEY' => $id), $data_insert);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Money'));
		}
	}


	function delete()
	{
		$table = "psr_current_money";
		$criteres['ID_MONEY'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
          print_r(json_encode(1));
	}
	function activer($id)
     {
           $this->Modele->update('psr_current_money',array('ID_MONEY'=>$id),array('STATUT_USAGE'=>1));
        print_r(json_encode(1));
     }
     function desactiver($id)
     {
           $this->Modele->update('psr_current_money',array('ID_MONEY'=>$id),array('STATUT_USAGE'=>0));
        print_r(json_encode(1));
     }

	
}
