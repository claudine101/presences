<?php

class Grade_test extends CI_Controller
{

function index()
{
	$data['title']="Test GRAGE";
	$this->load->view('Grade_List_View_test',$data);
}

function listing()
{
	$i=1;
	$query_principal="SELECT `ID_GRADE`,`GRADE` FROM `psr_grade` WHERE 1";

   
     $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

	 $limit='LIMIT 0,10';

  if($_POST['length'] != -1){


               
               $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
          }


      $order_by='';

      $order_column=array('ID_GRADE','GRADE');


     $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY GRADE ASC';

	$search = !empty($_POST['search']['value']) ? ("AND GRADE LIKE '%$var_search%' "):'';


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
			data-target='#mydelete" . $row->ID_GRADE. "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Grade/getOne/'.$row->ID_GRADE) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .$row->ID_GRADE. "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" .$row->GRADE."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
		<a class='btn btn-danger btn-md' href='" . base_url('ihm/Grade/delete/'.$row->ID_GRADE)."'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			//$sub_array[]=$row->ID_GRADE;
			$sub_array[]=$row->GRADE;			
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

$data['COULEUR']=$this->Modele->getRequete('SELECT `ID_GRADE`,`GRADE` FROM `psr_grade` WHERE 1');

$data['title']='NOUVEAUX GRADE';
$this->load->View('ihm/Grade_Add_View',$data);
}


function add()
{
	$this->form_validation->set_rules('GRADE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


			if($this->form_validation->run() == FALSE)
		{
			$this->ajouter();
		}else{

			$data_insert=array(

				   'GRADE'=>$this->input->post('GRADE'),
			                  );

	$table='psr_grade';
			$this->Modele->create($table,$data_insert);

			$data['message']='<div class="alert alert-success text-center" id="message">'."L'ajout se faite avec succès".'</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Grade/index'));

		}
}


function getOne()
  {
  		$id=$this->uri->segment(4);
        $data['data']=$this->Modele->getOne('psr_grade',array('ID_GRADE'=>$id));
		
		$data['title'] = 'Modification Du Grade';
		
		$this->load->view('Grade_Update_View',$data);

  }


  function update()
 {
  	 $this->form_validation->set_rules('ID_GRADE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

	$this->form_validation->set_rules('GRADE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		
	$id=$this->input->post('ID_GRADE');

	if ($this->form_validation->run() == FALSE) {
		

		$this->getOne();
	}else{
			$id=$this->input->post('ID_GRADE');

			$data=array(
			'ID_GRADE'=>$this->input->post('ID_GRADE'),
			'GRADE'=>$this->input->post('GRADE'),
			);

			$this->Modele->update('psr_grade',array('ID_GRADE'=>$id),$data);
			$datas['message']='<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Grade'));
		}
  }


  function delete()
  {
          $table="psr_grade";
          $criteres['ID_GRADE']=$this->uri->segment(4);
          $data['rows']= $this->Modele->getOne( $table,$criteres);
          $this->Modele->delete($table,$criteres);

          $data['message']='<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
          $this->session->set_flashdata($data);
          redirect(base_url('ihm/Grade'));
  }





}
