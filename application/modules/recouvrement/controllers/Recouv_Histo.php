<?php

	class Recouv_Histo extends CI_Controller
	{
		function __construct()
		  {
		    parent::__construct();
		    $this->have_droit();
		  }

	  public function have_droit()
	  {
	    if ($this->session->userdata('INFRACTION') != 1) {

	      redirect(base_url());
	    }
	  }
		function index()
		{
			$data['title'] = 'Arriéré de paiement des amendes';
    		$this->load->view('Recouv_Histo_View', $data);
		}

		function listing()
		{
			
		    $utilisateurs=
		    $query_principal = "SELECT r.ID_RECOUVRE_HISTO,h.NUMERO_PLAQUE AS NUP,r.MESSAGE AS MSG,o.TELEPHONE AS TEL,r.DEPASSEMENT AS DEP,r.MONTANT_PAYE AS MP,o.NOM_PROPRIETAIRE AS NOM,r.DATE_INSERTION AS DATE_IN FROM recouvrement_historique r JOIN historiques h on r.ID_HISTORIQUE=h.ID_HISTORIQUE JOIN obr_immatriculations_voitures o on o.NUMERO_PLAQUE=h.NUMERO_PLAQUE WHERE r.ID_HISTORIQUE IN (SELECT DISTINCT `ID_HISTORIQUE` FROM recouvrement_historique)";

		    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
            $var_search=str_replace("'", "\'", $var_search);


		    $limit = 'LIMIT 0,10';

		    if ($_POST['length'] != -1)
		    {
		      $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
		    }

		    $order_by = '';

		    $order_column = array('ID_RECOUVRE_HISTO','r.ID_RECOUVRE_HISTO', 'h.NUMERO_PLAQUE','r.MESSAGE','o.TELEPHONE','r.DEPASSEMENT', 'r.MONTANT_PAYE','o.NOM_PROPRIETAIRE','r.DATE_INSERTION');

		    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY r.DATE_INSERTION, o.NOM_PROPRIETAIRE  ASC';

		    $search = !empty($_POST['search']['value']) ? ("AND o.NOM_PROPRIETAIRE LIKE '%$var_search%' OR h.NUMERO_PLAQUE LIKE '%$var_search%' OR r.DEPASSEMENT LIKE '%$var_search%'") : '';


		    $critaire = '';

		    $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
		    $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

		    $fetch_psr = $this->Modele->datatable($query_secondaire);
		    $data = array();

		    $i=0;

		    foreach ($fetch_psr as $row)
		    {	

		  	  $date_insert=new DateTime($row->DATE_IN);
		  	  
		  	  $i++;
		      $sub_array = array();
		      $sub_array[] = $i;
		      $sub_array[] = $row->NUP;
		      $sub_array[] = $row->MSG;
		      $sub_array[] = $row->TEL;
		      $sub_array[] = $row->DEP;
		      $sub_array[] = $row->MP;
		      $sub_array[] = $row->NOM;
		      $sub_array[] = $date_insert->format('d/m/Y');


		      
										
				
				
				$option = "<button class='btn btn-danger'><a hre='#' data-toggle='modal' data-target='#mydelete" . $row->ID_RECOUVRE_HISTO . "'><font color='white'>Supprimer</font></a></button>";


				$option .= "
						
						<div class='modal fade' id='mydelete" .  $row->ID_RECOUVRE_HISTO . "'>
						<div class='modal-dialog'>
						<div class='modal-content'>

						<div class='modal-body'>
						<center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" .$row->NUP."</i></b></h5></center>
						</div>

						<div class='modal-footer'>
						<a class='btn btn-danger btn-md' href='" . base_url('recouvrement/Recouv_Histo/delete/'.$row->ID_RECOUVRE_HISTO) . "'>Supprimer</a>
						<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
						</div>

						</div>
						</div>
						</div>";
		      
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

	 function delete($id)
		{
			$table=" recouvrement_historique";
			$criteres['ID_RECOUVRE_HISTO']=$this->uri->segment(4);
			$data['rows']= $this->Modele->getOne( $table,$criteres);
			$this->Modele->delete($table,$criteres);

			$data['message']='<div class="alert alert-success text-center" id="message">Suppression avec succès</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('recouvrement/Recouv_Histo'));

		}


}


?>