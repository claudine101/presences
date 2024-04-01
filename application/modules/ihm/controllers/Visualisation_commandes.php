<?php 
/**
 
 */
 class Visualisation_commandes extends CI_Controller
 {

 	function __construct()
 	{
 		parent::__construct();
 		$this->authentification();
 	}

 	function authentification(){
 		if (empty($this->session->userdata('ID_RESTAURANT'))) {
			redirect(base_url());
		}
 	}



 	function index(){
 	   
		$mes_resto=$this->Modele->getRequete('SELECT ID_RESTAURANT, NOM_RESTAURANT FROM 
			restaurants WHERE 1 ORDER BY NOM_RESTAURANT');

	    $lsattus=$this->Modele->getRequete('SELECT ID_STATUS_COMMANDE, DESCRIPTION FROM 
	    	commande_status WHERE 1 ORDER BY ID_STATUS_COMMANDE');

	    $Livreurs =$this->Modele->getRequete('SELECT `ID_LIVREUR`,`NOM_LIVREUR`,PRENOM_LIVREUR FROM `commande_livreurs` WHERE 1 ORDER BY NOM_LIVREUR,`PRENOM_LIVREUR` ');

 		$data['title'] = 'Listes des commandes';
        $data['commande_status'] = $lsattus;
        $data['Livreurs'] = $Livreurs;
        $data['mes_resto'] = $mes_resto;

        $select = "";

        $select .= ' <div class="form-group" id="div_driver">
                      <label for="date">Driver wasili *</label>
                        <select class="form-control input-sm" name="ID_LIVREUR" id="ID_LIVREUR" required>
                            <option value="">Driver---</option>';
        foreach ($Livreurs as $key => $value) {
        
         $select .= '<option value="'.$value['ID_LIVREUR'].'">'.$value['NOM_LIVREUR'].' '.$value['PRENOM_LIVREUR'].'</option>';

        }

        $select .= '</select>
                    </div>
                     <div class="form-group" id="div_driver">
                       <label for="date">N° de la Course *</label> 
                          <input type="text" name="NUMERO_COURSE_WASILI" id="NUMERO_COURSE_WASILI"  class="form-control input-sm" required> 
                     </div> 
                     ';


        $data['select_libr'] = $select;

 		$this->load->view('command_List_View',$data);
 	}



 	function getDetailMenu($id_comm =0){

		$donnes = $this->Modele->getRequete("SELECT `ID_COMMANDE_DETAIL`,c.NOM_CATEGORIE,menu.DESCRIPTION as MENU,menu.IMAGE_1,d.QUANTITE,d.PRIX_TOTAL,d.PRIX_UNITAIRE FROM commande_details d LEFT JOIN menu_restaurants r on r.ID_MENU_RESTAURANT=d.ID_MENU_RESTO LEFT JOIN menu on menu.ID_MENU=r.ID_MENU LEFT JOIN menu_categories c ON c.ID_CATEGORIE=menu.ID_CATEGORIE WHERE 1 AND d.ID_COMMANDE=  ".$id_comm);

		$xxx = '<table  class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
        <thead>
        <tr>
          <th>Catégorie</th>
          <th>Commande</th>
          <th>PU (Fbu)</th>
          <th>Quantité</th>
          <th>PT (Fbu)</th>
      

          <th>OPTIONS</th>
        </tr>
        </thead>

        <tbody>';

        $classs = 'secondary';
        

		foreach ($donnes as $key => $value) {

		$xxx .= "<tr>
          <td><span title='".$value['NOM_CATEGORIE']."'>".substr($value['NOM_CATEGORIE'], 0,25)."</span></td>

          <td><span title='".$value['MENU']."'>".substr($value['MENU'], 0,25)."</span></td>

           <td><span style='float:right'><b>".str_replace(",", " ", number_format($value['PRIX_UNITAIRE']))." BIF</b></span></td>

          <td style='color:blue'>".$value['QUANTITE']."</td>
                   
          <td><span style='float:right'><b>".str_replace(",", " ", number_format($value['PRIX_TOTAL']))." BIF</b></span></td>

          <td><button type='button' onclick='save_delete()'  class='btn btn-".$classs." btn-sm' >
          X</button></td>
        </tr>";
			
		}

		$xxx .= "</tbody>
        </table>";
        
        return $xxx;
		
	}




 	function listing()
 	{

        $ID_STATUS_COMMANDE= $this->input->post('ID_STATUS_COMMANDE');
 
        $ID_RESTAURANT = $this->input->post('ID_RESTAURANT_UNE') ;

        // $this->session->userdata('ID_RESTAURANT')

        $critere_command = !empty($ID_STATUS_COMMANDE) ? "and co.ID_STATUS_COMMANDE= ".$ID_STATUS_COMMANDE." " : "";

	    $critere_resto = !empty($ID_RESTAURANT) ? ' and r.ID_RESTAURANT= '.$ID_RESTAURANT.' ' : " and r.ID_RESTAURANT=".$this->session->userdata('ID_RESTAURANT');
		


 		$query_principal='SELECT `ID_COMMANDE`,`DATE_COMMANDE`,`MONTANT_COMMANDE`,cl.NOM,cl.EMAIL,cl.NUMERO_TEL,p.PROVINCE_NAME,com.COMMUNE_NAME,`ADRESSE_LIVRAISON`,co.`ID_STATUS_COMMANDE`,`LONGITUDE_LIVRAISON`,`LATITUDE_LIVRAISON`,s.DESCRIPTION FROM commandes co LEFT JOIN clients cl on cl.ID_CLIENT=co.ID_CLIENT LEFT JOIN syst_provinces p on p.PROVINCE_ID=co.PROVINCE_ID_LIVRAISON LEFT JOIN syst_communes com ON com.COMMUNE_ID=co.COMMUNE_ID_LIVRAISON LEFT JOIN commande_status s ON s.ID_STATUS_COMMANDE = co.ID_STATUS_COMMANDE WHERE 1 '.$critere_command.' and  co.ID_COMMANDE IN(SELECT d.ID_COMMANDE FROM commande_details d JOIN menu_restaurants r ON r.ID_MENU_RESTAURANT=d.ID_MENU_RESTO WHERE 1 '.$critere_resto.' GROUP BY ID_COMMANDE)';


 		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'", "\'", $var_search);
 		

 		$limit='LIMIT 0,10';


 		if($_POST['length'] != -1){
 			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
 		}
 		$order_by='';



 		$order_column=array('DATE_COMMANDE','NOM','EMAIL','NUMERO_TEL','PROVINCE_NAME','COMMUNE_NAME','ADRESSE_LIVRAISON','DESCRIPTION');

 		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY `ID_COMMANDE`,`DATE_COMMANDE` ASC';

 		$search = !empty($_POST['search']['value']) ? (" AND DATE_COMMANDE LIKE '%$var_search%' OR NOM LIKE '%$var_search%' OR NUMERO_TEL LIKE '%$var_search%' OR PROVINCE_NAME LIKE '%$var_search%' OR EMAIL LIKE '%$var_search%' OR ADRESSE_LIVRAISON LIKE '%$var_search%'") : '';     

 		$critaire = '';

 		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
 		$query_filter = $query_principal.' '.$critaire.' '.$search;


 		$fetch_row = $this->Modele->datatable($query_secondaire);
 		$data = array();

 		 $lsattus=$this->Modele->getRequete('SELECT ID_STATUS_COMMANDE, DESCRIPTION FROM 
	    	commande_status WHERE 1 ORDER BY DESCRIPTION');
        



 		foreach ($fetch_row as $row) {


 			$comm = !empty($row->ID_COMMANDE) ? ' and ID_COMMANDE = '.$row->ID_COMMANDE : '';

 			$article = $this->Modele->getRequeteOne('SELECT COUNT(`ID_COMMANDE`) as nmbr_menu , SUM(`PRIX_TOTAL`) AS PRIX_TOTAL  FROM `commande_details` WHERE 1 '.$comm.' GROUP BY ID_COMMANDE');

 		   $opt='';
 		   foreach ($lsattus as $key => $value) 
 		   {
 		   if ($value['ID_STATUS_COMMANDE']==$row->ID_STATUS_COMMANDE) {
 		    $opt.='<option selected value="'.$value['ID_STATUS_COMMANDE'].'">'.$value['DESCRIPTION'].'</option>';
 		   }else{
 		   	$opt.='<option  value="'.$value['ID_STATUS_COMMANDE'].'">'.$value['DESCRIPTION'].'</option>';
 		   }
 		  
 		   }



 			$option = '<div class="dropdown ">
 			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
 			<i class="fa fa-cog"></i>
 			Action
 			<span class="caret"></span></a>
 			<ul class="dropdown-menu dropdown-menu-left">
 			';

 			$option .= "<li><a hre='#' data-toggle='modal'
 			data-target='#mydelete" . $row->ID_COMMANDE. "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";

 			//$option .= "<li><a class='btn-md' href='" . base_url('ihm/Visualisation_commandes/getOne/'.md5($row->ID_COMMANDE)) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";

 			// $option .= '<li><a href="'.base_url('ihm/Visualisation_commandes/index2/'.$row->ID_COMMANDE).'"><label class="text-success">&nbsp;&nbsp;detail</label></a></li>';

 						
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_COMMANDE . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><P>Voulez-vous supprimer Cette commande?<br><b style='background-color:prink;color:green;'><i>" .$row->ID_COMMANDE."</i></b></P></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Visualisation_commandes/delete/'.$row->ID_COMMANDE) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>



			</div>
			</div>
			</div>



			<div class='modal fade' id='detailss" .  $row->ID_COMMANDE . "'>
			<div class='modal-dialog modal-lg' style ='width:1000px'>
			<div class='modal-content  modal-lg'>

			<div class='modal-body'>
			<center><p>Commande de ".$row->NOM."</p></center>
            <br>

            ".$this->getDetailMenu($row->ID_COMMANDE)."


			</div>

			<div class='modal-footer'>
			
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>



			</div>
			</div>
			</div>";


			 $option.= '<div class="modal fade" id="approv' .$row->ID_COMMANDE. '">
	      <div class="modal-dialog">
	      <div class="modal-content">

	      <div class="modal-body">
	      <p class="text-center"><b> Avis sur la commande de <b class="text-success">'.$row->NOM.'<BR></b>commande fait <b class="text-success">'.$row->DATE_COMMANDE.'</b><br>Statut <b class="text-success">'.$row->DESCRIPTION.'</b> <p><hr>
	     

	      <form id="myForm'.$row->ID_COMMANDE.'" action="'.base_url('ihm/Visualisation_commandes/changerStatut/').$row->ID_COMMANDE.'" method="post">

	        <div class="row" style="margin-left: 60px">
	          <div class="col-md-9" >
	           <div class="form-group">
	           <input type="Hidden" class="form-control" autocomplete="off" name="ID_COMMANDE" value="'.$row->ID_COMMANDE.'">
	              <label for="date">Avis statut </label>
	               <select class="form-control input-sm" onchange="get_driver(this.value,'.$row->ID_COMMANDE.')"  name="ID_STATUS_COMMANDE'.$row->ID_COMMANDE.'" id="ID_STATUS_COMMANDE'.$row->ID_COMMANDE.'" > 
                <option value="">Sélectionner</option>
                '. $opt.'
                
                <?php } ?>
              </select>
            </div>
            <span id="div_driver'.$row->ID_COMMANDE.'"></span>
         


	        </div>
          </div>
	         </div>
	          <div class="modal-footer">
	          <div class="float-right">
	              <button class="btn btn-secondry btn-md" data-dismiss="modal">Quitter</button>

	              <button type="button" class="btn btn-sm btn-primary " onclick="save_donnes('.$row->ID_COMMANDE.')">Changer</button>
	          </div>
	          </div>
	          
	        </form>

	      </div>
	      </div>
	      </div>';




			$sub_array = array();
            

			$sub_array[]= '<span class="btn"  onclick="get_message('.$row->ID_COMMANDE.')" > <table> <tr><td><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="'.base_url('uploads/personne.png').'"></td><td>'. $row->NOM.' <font style="font-size:10px;color:red"><i class="far fa-comment-dots">...</i></font></td></tr></table><span>';

			$sub_array[]= '<a href="#" data-toggle="modal" data-target="#detailss'.$row->ID_COMMANDE.'" title="voir details"><i class="fa fa-shopping-basket " style="font-size: 20px; color:orange"> </li>'.$article['nmbr_menu'].'</a>';

			$sub_array[]= (!empty($row->NUMERO_TEL)) ? $row->NUMERO_TEL : 'N/A'; 

			$sub_array[]="<span style='font-size:12px'>".$row->PROVINCE_NAME.", ". $row->COMMUNE_NAME.",</br>Adresse : <b>". $row->ADRESSE_LIVRAISON."</b></span>";
			 
			$sub_array[]=(!empty($row->DATE_COMMANDE)) ? $row->DATE_COMMANDE : 'N/A';
			
			
			$sub_array[]='<span data-toggle="modal" data-target="#approv' . $row->ID_COMMANDE . '" class="btn btn-sm btn-block" style="color: green" title="Changer statut"><i class="fa fa-eye" ></li> '.$row->DESCRIPTION.'</span>' ;

			$sub_array[]='<span style="float:right;"><b>'.str_replace(",", " ", number_format($article['PRIX_TOTAL'])).'</b></span>'; 
			
			


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




			// $sqls="SELECT QUANTITE  FROM commande_details WHERE ID_COMMANDE=".$row->ID_COMMANDE;
			// $nbre_commande=$this->Modele->getRequeteOne($sqls);


	
	function ajouter()
	{
		$data['ID_RESTAURANT'] = $this->Modele->getRequete('SELECT ID_RESTAURANT,NOM_RESTAURANT FROM `restaurants` WHERE 1');
		$data['ID_MENU'] = $this->Modele->getRequete('SELECT * FROM `menu` m WHERE EXISTS (SELECT mr.`ID_MENU` FROM `menu_restaurants` mr WHERE m.`ID_MENU`=mr.`ID_MENU` ) ');


		
		$data['title'] = 'Ajouter une commande';
		$this->load->view('commande_Add_View',$data);
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
		$this->form_validation->set_rules('DATE_COMMANDE','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NUMERO_CLIENT','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('ADRESSE_CLIENT','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NOM_RESTAURANT','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('NOM_MENU','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('STATUT','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


		if ($this->form_validation->run() == FALSE) {
		# code...
			$this->ajouter();
		}else{



			$data_insert=array(
				'DATE_COMMANDE'=>$this->input->post('DATE_COMMANDE'),
				'ID_MENU_RESTO'=>$this->input->post('ID_MENU_RESTO'),
				'ID_CLIENT'=>$this->input->post('NUMERO_CLIENT'),
				'NUMERO_CLIENT'=>$this->input->post('ADRESSE_CLIENT'),
				'ADRESSE_CLIENT'=>$this->input->post('NOM_RESTAURANT'),
				'LONGITUDE'=>$this->input->post('LONGITUDE'),
				'LATITUDE'=>$this->input->post('LATITUDE'),
				'E-MAIL'=>$this->input->post('E-MAIL'),
				'STATUT'=>$this->input->post('STATUT'),

			);

			print_r($data_insert); die();
			$table='commandes';
			$this->Modele->create($table,$data_insert);

			$data['message']='<div class="alert alert-success text-center" id="message">'."L'enregistrement de la commande est fait avec succès".'</div>';
			$this->session->set_flashdata($data);
			redirect(base_url('ihm/Visualisation_commandes1/'));

		}
	}

	function getOne()
	{
		
		$id=$this->uri->segment(4);
		$data['ID_RESTAURANT'] = $this->Modele->getRequete('SELECT ID_RESTAURANT,NOM_RESTAURANT FROM `restaurants` WHERE 1');
		$data['ID_MENU'] = $this->Modele->getRequete('SELECT ID_MENU,NOM_MENU FROM `menu` WHERE 1');
		$data['data']=$this->Modele->getRequeteOne('SELECT * FROM `commandes` WHERE 1 and md5(ID_COMMANDE)="'.$id.'"');
		
		$data['title'] = 'Modification des commandes';
		$this->load->view('commandes_Update_View',$data);
	}

	function update()
	{
		$this->form_validation->set_rules('DATE_COMMANDE','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NOM_MENU','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NOM_RESTAURANT','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('NUMERO_CLIENT','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('ADRESSE_CLIENT','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('LONGITUDE','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		$this->form_validation->set_rules('LATITUDE','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

		$this->form_validation->set_rules('STATUT','', 'trim|required|callback_validate_name',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
		

		$id=$this->input->post('ID_COMMANDE');

		if ($this->form_validation->run() == FALSE) {

			$this->getOne();
		}else{
			$id=$this->input->post('ID_COMMANDE');

			$data=array(
				'DATE_COMMANDE'=>$this->input->post('DATE_COMMANDE'),
				'NOM_RESTAURANT'=>$this->input->post('NOM_RESTAURANT'),
				'NOM_MENU'=>$this->input->post('NOM_MENU'),
				'ID_MENU_RESTO'=>$this->input->post('ID_MENU_RESTO'),
				'NUMERO_CLIENT'=>$this->input->post('NUMERO_CLIENT'),
				'ADRESSE_CLIENT'=>$this->input->post('ADRESSE_CLIENT'),
				'LONGITUDE'=>$this->input->post('LONGITUDE'),
				'LATITUDE'=>$this->input->post('LATITUDE'),
				'STATUT'=>$this->input->post('STATUT'),


			);
			$this->Modele->update('commandes',array('ID_COMMANDE'=>$id),$data);
			$datas['message']='<div class="alert alert-success text-center" id="message">La modification de la pièce  est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Visualisation_commandes/'));
		}
	}

	function delete()
	{
		$table="commandes";
		$criteres['ID_COMMANDE']=$this->uri->segment(4);
		$data['rows']= $this->Modele->getOne( $table,$criteres);
		$this->Modele->delete($table,$criteres);

		$data['message']='<div class="alert alert-success text-center" id="message">La commande a été bien supprimé</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Visualisation_commandes/'));
	}


	function index2()
 	{
 	
 		$data['title'] = 'Listes des details';
 		$this->load->view('ihm/command_detail_v',$data);
 	}

function detail(){
	$id=$this->uri->segment(4);
		$query_principal='SELECT cd.ID_COMMANDE_DETAIL,cd.ID_COMMANDE,cd.QUANTITE, cd.PRIX_UNITAIRE, mr.ID_MENU_RESTAURANT, mr.PRIX_1, menu.ID_MENU, menu.NOM_MENU, menu.DESCRIPTION, menu.IMAGE_1,mr.ID_MENU_RESTAURANT, mr.PRIX_1, menu.IMAGE_2, menu.IMAGE_3, resto.ID_RESTAURANT, resto.NOM_RESTAURANT, resto.ID_RESTAURANT, resto.NOM_RESTAURANT FROM commande_details cd LEFT JOIN menu_restaurants mr ON mr.ID_MENU_RESTAURANT = cd.ID_MENU_RESTO LEFT JOIN menu ON menu.ID_MENU = mr.ID_MENU LEFT JOIN restaurants resto ON resto.ID_RESTAURANT = mr.ID_RESTAURANT WHERE 1';
       $order_column=array('NOM_MENU','NOM_RESTAURANT','PRIX_UNITAIRE','NOTE');
       $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit='LIMIT 0,10';


		// if($_POST['length'] != -1){
		// 	$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		// }
		$order_by='';



		$order_column=array('NOM_MENU','NOM_RESTAURANT','PRIX_UNITAIRE','NOTE');

		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM_MENU,NOM_RESTAURANT ASC';

		$search = !empty($_POST['search']['value']) ? (" AND NOM_RESTAURANT LIKE '%$var_search%' OR NOM_MENU LIKE '%$var_search%'") : '';     

		$critaire = '';

		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;


		$fetch_row = $this->Modele->datatable($query_principal);
		$data = array();
		foreach ($fetch_row as $row) {

			$option = '<div class="dropdown ">
 			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
 			<i class="fa fa-cog"></i>
 			Action
 			<span class="caret"></span></a>
 			<ul class="dropdown-menu dropdown-menu-left">
 			';

 			$option .= "<li><a hre='#' data-toggle='modal'
 			data-target='#mydelete" . $row->ID_COMMANDE_DETAIL. "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
 			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Visualisation_commandes/getOne/'.md5($row->ID_COMMANDE_DETAIL)) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";

 			$option .= '<a href="'. base_url('ihm/Visualisation_commandes/detail/'.$row->ID_COMMANDE_DETAIL) .'" data-toggle="modal" data-target="#ecoul" onclick="get_hist(\'détail de  la commande numero:<b>'.$row->ID_COMMANDE_DETAIL.'</b>\','.$row->ID_COMMANDE_DETAIL.')"  style="color:white;"><label class="text-success">&nbsp;&nbsp;detail</label></a>';
			
			
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_COMMANDE_DETAIL . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><h5><strong>Voulez-vous supprimer Cette commande?</strong> <br><b style='background-color:prink;color:green;'><i>" .$row->ID_COMMANDE_DETAIL."</i></b></h5></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Visualisation_commandes/delete/'.$row->ID_COMMANDE_DETAIL) . "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>



			</div>
			</div>
			</div>";



		  

			$sub_array = array(); 

			$sub_array[]=$row->NOM_MENU;
			$sub_array[]=(!empty($row->NOM_RESTAURANT)) ? $row->NOM_RESTAURANT : 'N/A'; 
			$sub_array[]=(!empty($row->QUANTITE)) ? $row->QUANTITE : 'N/A'; 
			$sub_array[]=(!empty($row->PRIX_UNITAIRE)) ? $row->PRIX_UNITAIRE : 'N/A';
			//$sub_array[]=($row->QUANTITE*$row->PRIX_UNITAIRE); 
			
			$sub_array[]=(!empty($row->NOTE)) ? $row->NOTE : 'N/A';
			  
		 

			$data[] = $sub_array;
		
		}
		$output = array(
		   // "draw" => intval($_POST['draw']),
			"recordsTotal" =>$this->Modele->all_data($query_principal),
			"recordsFiltered" => $this->Modele->filtrer($query_filter),
			"data" => $data
		);
		echo json_encode($output);
}


function changerStatut($ID_COMMANDE)
	{
		$id= $ID_COMMANDE;
		$stat=$this->input->post('ID_STATUS_COMMANDE'.$ID_COMMANDE);

		$sql=$this->Modele->getOne('commandes',array('ID_COMMANDE'=>$id));
	
		$data=array(
					'ID_STATUS_COMMANDE'=>$stat
					);
		
		$this->Modele->update('commandes',array('ID_COMMANDE'=>$id),$data);

		 /*Historique*/

		$data_histo = array(
			                  'ID_STATUS_COMMANDE'=>$stat,
			                  'USER_ID'=>$this->session->userdata('USER_ID'),
			                  'ID_COMMANDE'=>$ID_COMMANDE,

			               );
		
        $table_x = 'commande_historique';
        $this->Modele->create('commande_historique',$data_histo);

        /*Livraison*/

        $ID_LIVREUR = $this->input->post('ID_LIVREUR');
        $NUMERO_COURSE_WASILI = $this->input->post('NUMERO_COURSE_WASILI');

        $Livreurs_donne = array(
        	'ID_COMMANDE'=>$id,
        	'ID_LIVREUR'=>$ID_LIVREUR,
        	'NUMERO_COURSE_WASILI'=>$NUMERO_COURSE_WASILI,
        	'USER_ID'=>$ID_COMMANDE,
        );


        if ($stat == 3) {
        	 $this->Modele->create('commande_livraison',$Livreurs_donne);
        }
        
       
		$datas['message']='<div class="alert alert-success text-center" id="message">La modification  est faite avec succès</div>';
			$this->session->set_flashdata($datas);
			redirect(base_url('ihm/Visualisation_commandes/index'));
	}

	
}
