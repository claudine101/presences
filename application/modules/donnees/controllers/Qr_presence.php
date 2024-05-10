<?php

/**
 *NDAYISABA Claudine
 *	CRUD DE TABLE Employes
 **/
class  Qr_presence extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->have_droit();
	}

	public function have_droit()
	{
		//  if ($this->session->userdata('PARAMETRE') != 1) {

        //        redirect(base_url());
        //   }
	}

	function index()
	{
		  $data['title'] = 'Liste des QRcode';
	  $this->load->view('qrcode/Qr_presence_list_view', $data);
	}
	function delete()
	{
		$table = "qr_code_presence";
		$criteres['QR_CODE_PRES_ID'] = $this->uri->segment(4);
		
		$data['rows'] = $this->Modele->getOne($table, $criteres);
		$this->Modele->delete($table, $criteres);
		$data['message'] = '<div class="alert alert-success text-center" id="message">L\'element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('donnees/Qr_presence/'));
	}

	function activer($id)
    {
		$set=array('IS_ACTIVE'=>0);
				//befor create,update all of data,set IS_ACTIVE ==0
				$this->Model->update_table('qr_code_presence',array('IS_ACTIVE'=>1),$set);
          $this->Modele->update('qr_code_presence',array('QR_CODE_PRES_ID'=>$id),array('IS_ACTIVE'=>1));

       print_r(json_encode(1));
    }
    function desactiver($id)
    {
          $this->Modele->update('qr_code_presence',array('QR_CODE_PRES_ID'=>$id),array('IS_ACTIVE'=>0));
       print_r(json_encode(1));
    }
	function ajouter()
	{
		$data['title'] = 'Nouveau QRcode ';
		$this->load->view('qrcode/Qr_presence_view', $data);
	}
	
	function listing()
	{

		$i = 1;

		$query_principal = 'SELECT `QR_CODE_PRES_ID`, `DATE_QR_CODE`, `HOUR_BEGIN`, `HOUR_END`, `PATH_QR_CODE`, `USER_ID`, `IS_ACTIVE`, `DATE_INSERTION` FROM `qr_code_presence` WHERE 1';
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
		$limit = 'LIMIT 0,10';

		if ($_POST['length'] != -1) {
			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		}

		$order_by = '';
		
		$order_column = array('QR_CODE_PRES_ID','DATE_QR_CODE', 'HOUR_BEGIN','HOUR_END','PATH_QR_CODE', 'USER_ID', 'IS_ACTIVE'.'DATE_INSERTION');

		$order_by = isset($_POST['order']) ? 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_QR_CODE DESC';

		$search = !empty($_POST['search']['value']) ? ("AND DATE_QR_CODE LIKE '%$var_search%'") : '';

		$critaire = '';

		$query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . ' ' . $limit;
		$query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		$fetch_infraction = $this->Modele->datatable($query_secondaire);
		$data = array();
		$u=0;
		foreach ($fetch_infraction as $row) {
			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->QR_CODE_PRES_ID   . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('donnees/Qr_presence/getOne/' . $row->QR_CODE_PRES_ID  ) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->QR_CODE_PRES_ID   . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->DATE_QR_CODE . "   ".$row->HOUR_BEGIN."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('donnees/Qr_presence/delete/' . $row->QR_CODE_PRES_ID  ) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";
	
			$sub_array = array();
			$u=++$u;
			$sub_array[]=$u;
			$source = !empty($row->PATH_QR_CODE) ? $row->PATH_QR_CODE : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";
			
            $sub_array[] = $row->DATE_QR_CODE;
			$sub_array[] = '<a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a>';
			$sub_array[] = $row->DATE_QR_CODE;
			$sub_array[] = $row->HOUR_BEGIN;
			$sub_array[] = $row->HOUR_END;
			$sub_array[] = $this->get_icon_qrcode($row->IS_ACTIVE,$row);
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

	function get_icon_qrcode($statut, $row)
	{
	  $html = ($statut == 1) ? "<a class='btn btn-success btn-sm' id='".$row->DATE_QR_CODE."'  title='".$row->DATE_QR_CODE."'  onclick='desactiver(".$row->QR_CODE_PRES_ID.",this.title,this.id)' style='float:right' ><span class = 'fa fa-check'></span></a>" : "<a class = 'btn btn-danger btn-sm' id='".$row->DATE_QR_CODE."'  title='".$row->DATE_QR_CODE."'  onclick='activer(".$row->QR_CODE_PRES_ID.",this.title,this.id)' style='float:right'><span class = 'fa fa-ban' ></span></a>" ;
	  return $html;
	}

	
			public function changer()
			{
				$QR_CODE_PRES_ID = $this->uri->segment(3);
				$potes = $this->Model->getOne('qr_code_presence',array('QR_CODE_PRES_ID'=>$QR_CODE_PRES_ID));

				if ($potes['IS_ACTIVE']==1) {
				$stat=0;
				$poste = $this->Model->update_table('qr_code_presence',array('QR_CODE_PRES_ID'=>$QR_CODE_PRES_ID),array('IS_ACTIVE'=>$stat));

				$data['retour'] = base_url('Qr_presence/liste'); 
				$data['message'] = "<div class='alert alert-danger'> Le qr_code  a été desactivé avec success.</div>";
				$data['bread'] = $this->make_bread->output();
				$this->load->view('Message_View',$data);
				}
				else{
				$stat=1;
				$poste = $this->Model->update_table('qr_code_presence',array('QR_CODE_PRES_ID'=>$QR_CODE_PRES_ID),array('IS_ACTIVE'=>$stat)); 

				$data['retour'] = base_url('Qr_presence/liste'); 
				$data['message'] = "<div class='alert alert-success'> Le qr_code  a été activé avec success.</div>";
				$data['bread'] = $this->make_bread->output();
				$this->load->view('Message_View',$data);
				}
			
			}
			 //This function help for insertion table
			public function save()
			{
				$this->form_validation->set_rules('DATE_PRES', 'Date', 'trim|required');
				$this->form_validation->set_rules('HEURE_DEBUT', 'heure debut', 'trim|required');
				$this->form_validation->set_rules('HEURE_FIN', 'heure fin', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
				$data['DATE_PRES'] = $this->input->post('DATE_PRES');
				$data['HEURE_DEBUT'] = $this->input->post('HEURE_DEBUT');
				$data['HEURE_FIN'] = $this->input->post('HEURE_FIN');

				// $data['bread'] = $this->make_bread->output();
				$this->load->view('qrcode/Qr_presence_view',$data);
				} //if required field are stop not seted else insert
				else{


				$DATE =$this->input->post('DATE_PRES');
				$H_BEGIN =$this->input->post('HEURE_DEBUT');
				$H_END=$this->input->post('HEURE_FIN');


				$set=array('IS_ACTIVE'=>0);
				//befor create,update all of data,set IS_ACTIVE ==0
				$this->Model->update_table('qr_code_presence',array('IS_ACTIVE'=>1),$set);
				//Then ... insert
				$uniq=$this->notifications->generate_password(10);
				$dat=''.$uniq.'';

				$name="QrCode_".$uniq.'_'.uniqid().'';
				$name2=base_url() . '/uploads/qrcode/'.$name.'.png';
				$xyz=array('CODE'=>$uniq,'DATE_QR_CODE'=>$DATE,'HOUR_BEGIN'=>$H_BEGIN,'HOUR_END'=>$H_END,'USER_ID'=>$this->session->userdata('ID_UTILISATEUR'),'DATE_INSERTION'=>date('Y-m-d H:i:s'),'IS_ACTIVE'=>1,'PATH_QR_CODE'=>$name2);
				//print_r($xyz);die();

				$Qr_presence = $this->Model->create('qr_code_presence',$xyz);

				if(!empty($Qr_presence)){
				$data['message'] = "<div class='alert alert-success'> Le nouveau Qr_code  a été créé avec success.</div>";
				$this->notifications->generateQrcode($dat,$name);
				$this->session->set_flashdata($data);
				redirect(base_url('donnees/Qr_presence/'));
				}else{
				$data['message'] = "<div class='alert alert-warning'> Opération échouée</div>";
				$data['message'] = '<div class="alert alert-warning text-center" id="message">Opération échouée</div>';
				$this->session->set_flashdata($data);
				redirect(base_url('donnees/Qr_presence/'));
				}
				//else notify failing
			}
           
	

			
}

}

