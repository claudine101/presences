<?php

class DetailLabel extends CI_Controller
{

	function index($id)
	{
		$query_principal=$this->Modele->getRequeteOne("SELECT * FROM `autres_controles_questionnaires` WHERE ID_CONTROLES_QUESTIONNAIRES=".$id);
		$data['label']=$query_principal;
		$data['title']='Reponse';
		$this->load->View('detail/detailabel_Add_View',$data);
 // print_r($query_principal);die();
	}

    

    function update()
    {
    	
    	$id_question = $this->input->post('id_question');
    	$id_reponse = $this->input->post('id_reponse');
    	$REPONSE_DECRP = $this->input->post('REPONSE_DECRP');
    	$REPONSE_DECRP_TRADUCTION = $this->input->post('REPONSE_DECRP_TRADUCTION');


    	$donne =   array('REPONSE_DECRP'=>$REPONSE_DECRP ,'REPONSE_DECRP_TRADUCTION'=>$REPONSE_DECRP_TRADUCTION );

    	$this->Modele->update('autres_contr_quest_rp',array('ID_REPONSE'=>$id_reponse),$donne);

    	$data['message']='<div class="alert alert-success text-center" id="message">Modification est faite avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/DetailLabel/index/'.$id_question));



    }

     






    function getOne($id_question, $id_reponse){

    	$reponse  = $this->Modele->getOne('autres_contr_quest_rp', array('ID_REPONSE'=>$id_reponse));
    	$query_principal=$this->Modele->getRequeteOne("SELECT LABEL_REPONSE FROM `autres_controles_questionnaires` WHERE ID_CONTROLES_QUESTIONNAIRES=".$id_question);
        
        $data['reponse']=$reponse;
    	$data['label']=$query_principal;
		$data['title']='Modification';

		$data['id_question']= $id_question;
		$data['id_reponse']= $id_reponse;

		$this->load->View('detail/detailabel_Add_update',$data);


    }







	function listing($id)
	{
        
		$query_principal="SELECT `ID_REPONSE`,ID_CONTROLES_QUESTIONNAIRES,`REPONSE_DECRP` FROM `autres_contr_quest_rp` WHERE `ID_CONTROLES_QUESTIONNAIRES`=".$id;

		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit='LIMIT 0,10';

		if($_GET['length'] != -1){

			$limit='LIMIT '.$_GET["start"].','.$_GET["length"];
		}


		$order_by='';

		$order_column=array('REPONSE_DECRP');

		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY REPONSE_DECRP ASC';

		$search = !empty($_POST['search']['value']) ? ("AND REPONSE_DECRP LIKE '%$var_search%' "):'';     

		$critaire = '';

		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;

		$fetch_peine = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_peine as $row)
		{

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_REPONSE . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";

			$option .= "<li><a class='btn-md' href='" . base_url('ihm/DetailLabel/getOne/'.$row->ID_CONTROLES_QUESTIONNAIRES.'/'.$row->ID_REPONSE) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";


			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_REPONSE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" .$row->REPONSE_DECRP."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/DetailLabel/delete/'.$row->ID_REPONSE.'/'.$row->ID_CONTROLES_QUESTIONNAIRES) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			
			$sub_array[]=$row->REPONSE_DECRP;		
			$sub_array[]=$option;   
			$data[] = $sub_array;
		}


		$output = array(
			"draw" => intval($_GET['draw']),
			"recordsTotal" =>$this->Modele->all_data($query_principal),
			"recordsFiltered" => $this->Modele->filtrer($query_filter),
			"data" => $data
		);
		echo json_encode($output);

	}

	

	function add()
	{
	 
		$this->form_validation->set_rules('LABEL_REPONSE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		if($this->form_validation->run() == FALSE)
		{
			$this->index();
		}else{
               $id=$this->input->post('ID_REPONSE');
			$data_insert=array(
				'ID_CONTROLES_QUESTIONNAIRES'=>$id,
				'REPONSE_DECRP'=>$this->input->post('LABEL_REPONSE'),
				'REPONSE_DECRP_TRADUCTION'=>$this->input->post('REPONSE_DECRP_TRADUCTION')
			);

			$table='autres_contr_quest_rp';
			$this->Modele->create($table,$data_insert);
			$data['message']='<div class="alert alert-success text-center" id="message">'."L'ajout se fait avec succès".'</div>';
			$this->session->set_flashdata($data);
           redirect(base_url('ihm/DetailLabel/index/'.$id));
		}
	}




	function delete($id,$idQue)
	{
		$table="autres_contr_quest_rp";
		$criteres['ID_REPONSE']=$id;
		$data['rows']= $this->Modele->getOne( $table,$criteres);
		$this->Modele->delete($table,$criteres);

		$data['message']='<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/DetailLabel/index/'.$idQue));
	}


}
?>