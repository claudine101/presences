<?php

/**
 * Claudine NDAYISABA
 * Gestion des utilisateurs
 */
class Utilisateurs extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->have_droit();
	}
	public function have_droit()
	{
		
		if ($this->session->userdata('ID_PROFIL') != 2 && $this->session->userdata('ID_PROFIL') != 5 && $this->session->userdata('ID_PROFIL') != 4) {
			// redirect(base_url());
			redirect('Login');
		}
	}
	function index()
	{
		// echo ($this->session->userdata('ID_PROFIL'));
		// exit();
		$data['title'] = 'Utilisateurs';
        $data['profil'] = $this->Modele->getRequete('SELECT ID_PROFIL, DESCRIPTION FROM profils WHERE 1 order by DESCRIPTION ASC');
		$this->load->view('users/Utilisateur_List_View', $data);
	}

	function listing()
	{
		$i = 1;
        $condition = '';
        $profil = $this->input->post('ID_PROFIL');
        if (!empty($profil)) {
             $condition .=  ' and u.ID_PROFIL= "' . $profil . '"';
        }
		$query_principal = 'SELECT u.ID_UTILISATEUR, u.USERNAME,p.DESCRIPTION,
         u.PASSWORD, u.ID_PROFIL, u.IS_ACTIVE, u.DATE_INSERTION FROM utilisateurs u  JOIN profils p  ON p.ID_PROFIL=u.ID_PROFIL  WHERE 1 '. $condition . ' ';

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
	
		$limit = 'LIMIT 0,10';
		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}
		$order_by = '';
		$order_column = array('ID_UTILISATEUR','USERNAME', 'ID_PROFIL', 'IS_ACTIVE');
		$order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY USERNAME ASC';
		$search = !empty($_POST['search']['value']) ? ("AND USERNAME LIKE'%$var_search%'") : '';
		$critaire = '';
		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;
		$fetch_gerant = $this->Modele->datatable($query_secondaire);
		$data = array();
        $u=0;

		foreach ($fetch_gerant as $row) {

             $labelle ="";
              $color = '';
              $btn = '';
              if($row->IS_ACTIVE== 1)
              {   $labelle='Désactiver';
                  $color = 'red';
                  $btn = 'btn-danger';
              }else {
                  $labelle='Activer';
                  $color = 'green';
                  $btn = 'btn-success';
              }

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_UTILISATEUR . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('administration/Utilisateurs/getOne/' . $row->ID_UTILISATEUR) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			// $row->IS_ACTIVE==0 ?
            //    $option .= "<li><hre='#'  id='".$row->USERNAME."'  title='".$row->USERNAME."'  onclick='activer(".$row->ID_UTILISATEUR.",this.title,this.id)'><font color='".$color."'>&nbsp;&nbsp;".$labelle."</font></a></li>":
			//    $option .= "<li><hre='#'  id='".$row->USERNAME."'  title='".$row->USERNAME."'  onclick='desactiver(".$row->ID_UTILISATEUR.",this.title,this.id)'><font color='".$color."'>&nbsp;&nbsp;".$labelle."</font></a></li>";

            $option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_UTILISATEUR . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->USERNAME . " </i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('administration/Utilisateurs/delete/' . $row->ID_UTILISATEUR) . "'>Supprimer</a>
			<buttoN class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";
			$sub_array = array();
            $u=++$u;
			$sub_array[]=$u;
			$sub_array[] = $row->USERNAME;
			$sub_array[] = $row->DESCRIPTION;
			$sub_array[] = $this->get_icon($row->IS_ACTIVE,$row);
			if($this->session->userdata('ID_PROFIL') == 5){	
				$sub_array[] = $option;
			}
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

    function activer($id)
    {
          $this->Modele->update('utilisateurs',array('ID_UTILISATEUR'=>$id),array('IS_ACTIVE'=>1));
       print_r(json_encode(1));
    }
    function desactiver($id)
    {
          $this->Modele->update('utilisateurs',array('ID_UTILISATEUR'=>$id),array('IS_ACTIVE'=>0));
       print_r(json_encode(1));
    }
	function ajouter()
	{

		$data['profil'] = $this->Modele->getRequete('SELECT ID_PROFIL,DESCRIPTION FROM `profils` WHERE 1');
		$data['title'] = 'Nouvel utilisateur';
		$this->load->view('users/Utilisateur_Add_View', $data);
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
     function get_icon($DESCRIPTION, $row)
     {
       $html = ($DESCRIPTION == 1) ? "<a class='btn btn-success btn-sm' id='".$row->USERNAME."'  title='".$row->USERNAME."'  onclick='desactiver(".$row->ID_UTILISATEUR.",this.title,this.id)' style='float:right' ><span class = 'fa fa-check'></span></a>" : "<a class = 'btn btn-danger btn-sm' id='".$row->USERNAME."'  title='".$row->USERNAME."'  onclick='activer(".$row->ID_UTILISATEUR.",this.title,this.id)' style='float:right'><span class = 'fa fa-ban' ></span></a>" ;
       return $html;
     }

	function add()
	{

		$this->form_validation->set_rules('USERNAME', '', 'trim|required|callback_validate_name|is_unique[utilisateurs.USERNAME]', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>','is_unique' => '<font style="color:red;size:2px;">Nom d\'utilisateur doit  etre unique </font>'));

		$this->form_validation->set_rules('PASSWORD', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if ($this->form_validation->run() == FALSE) {
			$this->ajouter();
		} 
		else {
				
					$pswd = $this->input->post('PASSWORD');
					$data_insert = array(
						'USERNAME' => $this->input->post('USERNAME'),
						'PASSWORD' => md5($pswd),
						'ID_PROFIL' => 1,
					);
					$table = 'utilisateurs';
					$this->Modele->create($table, $data_insert);

					$data['message'] = '<div class="alert alert-success text-center" id="message">' . "enregistrement est faite avec succès" . '</div>';
					$this->session->set_flashdata($data);
					redirect(base_url('administration/Utilisateurs/'));
				
		}

	}

	function getOne($id)
	{

		$data['data'] = $this->Modele->getOne('utilisateurs', array('ID_UTILISATEUR' => $id));
		$data['profil'] = $this->Modele->getRequete('SELECT ID_PROFIL,DESCRIPTION FROM `profils` WHERE 1');

		$data['title'] = "Modification de l'utilisateur";
		$this->load->view('users/Utilisateur_Update_View', $data);
	}

	function update()
	{
		$this->form_validation->set_rules('USERNAME', '', 'trim|required|callback_validate_name|is_unique[utilisateurs.USERNAME]', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>','is_unique' => '<font style="color:red;size:2px;">Nom d\'utilisateur doit  etre unique </font>'));
		$id = $this->input->post('ID_UTILISATEUR');
		if ($this->form_validation->run() == FALSE) {
			$this->getOne($id);
		} else {
			$id = $this->input->post('ID_UTILISATEUR');
			$data = array(
				'USERNAME' => $this->input->post('USERNAME'),
			);
			$this->Modele->update('utilisateurs', array('ID_UTILISATEUR' => $id), $data);
			$datas['message'] = '<div class="alert alert-success text-center" id="message">La modification de enregistrement est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('administration/Utilisateurs/'));
		}
	}

	function delete()
	{
		$table = "utilisateurs";
		$criteres['ID_UTILISATEUR'] = $this->uri->segment(4);
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);

		$data['message'] = '<div class="alert alert-success text-center" id="message">L\'utilisateur  est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('administration/Utilisateurs/'));
	}
}
