<?php 
/**
 * Vanny
 * Gestion de publication de menu
 
 */
class Restaurants extends CI_Controller
{
	
	function __construct()
	{
		# code...
		parent::__construct();
	}
	function index()
	{
		$data['title'] = 'Restaurants';
		$this->load->view('restaurants_list_view',$data);
	}

	 function get_icon($statut)
      {
      $html = ($statut == 1) ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>' ;
      return $html;
    }

	function listing()
	{
		$query_principal='SELECT ID_RESTAURANT, NOM_RESTAURANT, IMAGE, DESCRIPTION_RESTAURANT, syp.PROVINCE_NAME AS Province, syc.COMMUNE_NAME AS Commune, syz.ZONE_NAME AS Zone, syl.COLLINE_NAME AS Colline, NOM_RESPONSABLE, TEL_RESPONSABLE, EMAIL_RESPONSABLE, IS_ACTIF, re.LATITUDE, re.LONGITUDE, MAP_URL FROM restaurants re LEFT JOIN syst_provinces syp ON re.PROVINCE_ID=syp.PROVINCE_ID LEFT JOIN syst_communes syc ON re.COMMUNE_ID=syc.COMMUNE_ID LEFT JOIN syst_zones syz ON re.ZONE_ID=syz.ZONE_ID LEFT JOIN syst_collines syl ON re.COLLINE_ID=syl.COLLINE_ID  WHERE 1';


		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit='LIMIT 0,10';


		if($_POST['length'] != -1){
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		$order_by='';



		$order_column=array('NOM_RESTAURANT','DESCRIPTION_RESTAURANT','LATITUDE','LONGITUDE','NOM','PRENOM');

		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM_RESTAURANT,DESCRIPTION_RESTAURANT ASC';

		$search = !empty($_POST['search']['value']) ? (" AND NOM_RESTAURANT LIKE '%$var_search%' OR DESCRIPTION_RESTAURANT LIKE '%$var_search%' ") : ' ';  
		//$search = !empty($_POST['search']['value']) ? ("AND NOM LIKE'%$var_search%' OR PRENOM LIKE '%$var_search%' "):'';    

		$critaire = '';

		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;


		$fetch_restaurant = $this->Modele->datatable($query_secondaire);
		$data = array();

		foreach ($fetch_restaurant as $row) {

			$option = '<div class="dropdown ">
			<a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-cog"></i>
			Action
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
			';

			$option .= "<li><a hre='#' data-toggle='modal'
			data-target='#mydelete" . $row->ID_RESTAURANT . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
			$option .= "<li><a class='btn-md' href='" . base_url('ihm/Restaurants/getOne/'.md5($row->ID_RESTAURANT)) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
			$option .= " </ul>
			</div>
			<div class='modal fade' id='mydelete" .  $row->ID_RESTAURANT . "'>
			<div class='modal-dialog'>
			<div class='modal-content'>

			<div class='modal-body'>
			<center><p>
			Voulez-vous supprimer ? <br><b style='background-color:prink;color:green;'><i>" .$row->NOM_RESTAURANT." de ".$row->NOM_RESPONSABLE."</i></b></p></center>
			</div>

			<div class='modal-footer'>
			<a class='btn btn-danger btn-md' href='" . base_url('ihm/Restaurants/delete/'.$row->ID_RESTAURANT). "'>Supprimer</a>
			<button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
			</div>

			</div>
			</div>
			</div>";

			$sub_array = array();
			$sub_array[]='<a href="'.$row->IMAGE.'" target="_blank" ><img style="border-radius:50%;width:40px;height:40px" src="'.$row->IMAGE.'"></a>';
			$sub_array[]=$row->NOM_RESTAURANT;
			$sub_array[]= "<span title='".$row->DESCRIPTION_RESTAURANT."'>".substr($row->DESCRIPTION_RESTAURANT, 0, 15)." ...</span>"; 
			$sub_array[]=$row->Province.", ".$row->Commune.",<br>".$row->Zone." ".$row->Colline; 
			$sub_array[]=$row->NOM_RESPONSABLE; 
			$sub_array[]="<b>".$row->TEL_RESPONSABLE."</b><br>".$row->EMAIL_RESPONSABLE; 
			$sub_array[]=  $this->get_icon($row->IS_ACTIF);
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
		
		$data['provinces']=$this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
		$data['title'] = ' Nouveau Restaurant';
		$this->load->view('Restaurant_add_View',$data);
		
	}


	function get_communes($ID_PROVINCE=0)
	{
		$communes=$this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID='.$ID_PROVINCE.' ORDER BY COMMUNE_NAME ASC');
		$html='<option value="">---selectionner---</option>';
		foreach ($communes as $key)
		{
			$html.='<option value="'.$key['COMMUNE_ID'].'">'.$key['COMMUNE_NAME'].'</option>';
		}
		echo json_encode($html);
	}

	function get_zones($ID_COMMUNE=0)
	{
		$zones=$this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID='.$ID_COMMUNE.' ORDER BY ZONE_NAME ASC');
		$html='<option value="">---selectionner---</option>';
		foreach ($zones as $key)
		{
			$html.='<option value="'.$key['ZONE_ID'].'">'.$key['ZONE_NAME'].'</option>';
		}
		echo json_encode($html);
	}

	function get_collines($ID_ZONE=0)
	{
		$collines=$this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID='.$ID_ZONE.' ORDER BY COLLINE_NAME ASC');
		$html='<option value="">---selectionner---</option>';
		foreach ($collines as $key)
		{
			$html.='<option value="'.$key['COLLINE_ID'].'">'.$key['COLLINE_NAME'].'</option>';
		}
		echo json_encode($html);
	}





	function add()
	{ 

       $file= $_FILES['PHOTO'];
       $path='./uploads/photo_duResto/';
       if(!is_dir(FCPATH.'/uploads/photo_duResto/')){
         mkdir(FCPATH.'/uploads/photo_duResto/', 777, TRUE);
       }
        $thepath= base_url().'uploads/photo_duResto/';
        $config['upload_path']= './uploads/photo_duResto/';
        $photonames= date('ymdHisa');
        $config['file_name']=$photonames;
        $config['allowed_types']= '*';
        $this->upload->initialize($config);
        $this->upload->do_upload("PHOTO");
        $info=$this->upload->data();        
          
        $profile_img= base_url().'/uploads/photo_duResto/'.$photonames.$info['file_ext'];
        
        //$profile_img= base_url().'/uploads/resto/'.$photonames.$info['file_ext'];
      

		$data_insert=array(

			'NOM_RESTAURANT'=>$this->input->post('NOM_RESTAURANT'),

			'IMAGE'=>$profile_img,

			'DESCRIPTION_RESTAURANT'=>$this->input->post('DESCRIPTION_RESTAURANT'),

			'PROVINCE_ID'=>$this->input->post('PROVINCE_ID'),

			'COMMUNE_ID'=>$this->input->post('COMMUNE_ID'),

			'ZONE_ID'=>$this->input->post('ZONE_ID'),

			'COLLINE_ID'=>$this->input->post('COLLINE_ID'),

			'NOM_RESPONSABLE'=>$this->input->post('NOM_RESPONSABLE'),

			'TEL_RESPONSABLE'=>$this->input->post('TEL_RESPONSABLE'),

			'EMAIL_RESPONSABLE'=>$this->input->post('EMAIL_RESPONSABLE'),

			'IS_ACTIF'=>$this->input->post('IS_ACTIF'),

			'LATITUDE'=>$this->input->post('LATITUDE'),

			'LONGITUDE'=>$this->input->post('LONGITUDE'),
		);

		$table='restaurants';
		$id_resto = $this->Modele->insert_last_id($table,$data_insert);

		$pwd=$this->input->post('TEL_RESPONSABLE');

        $data_user= array(
        	           'NOM_PRENOM' =>$this->input->post('NOM_RESPONSABLE'),
                       'ID_RESTAURANT'=> $id_resto,
                       'PROFILE_ID'=> 2,
                       'USER_TELEPHONE'=> $this->input->post('TEL_RESPONSABLE'),
                       'USER_EMAIL'=>$this->input->post('EMAIL_RESPONSABLE'),
                       'IS_ACTIVE'=> $this->input->post('IS_ACTIF'),
                       'USER_PASSWORD'=>md5($pwd)
                       );
          
        $creation = $this->Model->insert_last_id('admin_users',$data_user);


         $email_utilisateur=$this->input->post('EMAIL_RESPONSABLE');


          $message="Monsieur/Madame ".$this->input->post('NOM_RESPONSABLE').", <br> Vos identifiant de connexion sur la plateform Wasili-Eat sont crée avec succès <a href='".base_url()."'>connectez-vous ici  :<br><br>";
          $message.="<b>Username : ".$email_utilisateur."</b><br>
          <b>Mot de passe : ".$pwd."</b><br>";

          $this->notifications->send_mail($email_utilisateur,'Wasili-Eat',NULL,$message,NULL);


		$data['message']='<div class="alert alert-success text-center" id="message">'."L'enregistrement est faite avec succès".'</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Restaurants/index'));

		//}

	}

	function getOne()
	{
		$id=$this->uri->segment(4);
		
		$data['resto']=$this->Modele->getRequeteOne(' SELECT * FROM `restaurants` WHERE 1 and md5(ID_RESTAURANT)="'.$id.'"');

		$restaurants=$data['resto'];
    //  print_r($restaurants['PROVINCE_ID']); die();
		$data['provinces']=$this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
		$data['communes']=$this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM syst_communes WHERE PROVINCE_ID='.$restaurants['PROVINCE_ID'].' ORDER BY COMMUNE_NAME ASC');
		$data['zones']=$this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM syst_zones WHERE COMMUNE_ID='.$restaurants['COMMUNE_ID'].' ORDER BY ZONE_NAME ASC');
		$data['collines']=$this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM syst_collines WHERE ZONE_ID='.$restaurants['ZONE_ID'].' ORDER BY COLLINE_NAME ASC');

		$data['title'] = 'Modification - Restaurant';
		$this->load->view('Restaurant_Update_View',$data);		
	}

	function update()
	{



      if(!empty($_FILES['PHOTO']['name'])){

	   $file= $_FILES['PHOTO'];
       $path='./uploads/photo_duResto/';
       if(!is_dir(FCPATH.'/uploads/photo_duResto/')){
         mkdir(FCPATH.'/uploads/photo_duResto/', 0777, TRUE);
       }
        $thepath= base_url().'uploads/photo_duResto/';
        $config['upload_path']= './uploads/photo_duResto/';
        $photonames= date('ymdHisa');
        $config['file_name']=$photonames;
        $config['allowed_types']= '*';
        $this->upload->initialize($config);
        $this->upload->do_upload("PHOTO");
        $info=$this->upload->data();     
          
        $image_name= base_url().'/uploads/photo_duResto/'.$photonames.$info['file_ext'];
        

		}else{

			$image_name=$this->input->post('old');
		}

		$id=$this->input->post('ID_RESTAURANT');

		$data=array(

			'NOM_RESTAURANT'=>$this->input->post('NOM_RESTAURANT'),

			'IMAGE'=>$image_name,

			'DESCRIPTION_RESTAURANT'=>$this->input->post('DESCRIPTION_RESTAURANT'),

			'PROVINCE_ID'=>$this->input->post('PROVINCE_ID'),

			'COMMUNE_ID'=>$this->input->post('COMMUNE_ID'),

			'ZONE_ID'=>$this->input->post('ZONE_ID'),

			'COLLINE_ID'=>$this->input->post('COLLINE_ID'),

			'NOM_RESPONSABLE'=>$this->input->post('NOM_RESPONSABLE'),

			'TEL_RESPONSABLE'=>$this->input->post('TEL_RESPONSABLE'),

			'EMAIL_RESPONSABLE'=>$this->input->post('EMAIL_RESPONSABLE'),

			'IS_ACTIF'=>$this->input->post('IS_ACTIF'),

			'LATITUDE'=>$this->input->post('LATITUDE'),

			'LONGITUDE'=>$this->input->post('LONGITUDE'),
		);

		$this->Modele->update('restaurants',array('ID_RESTAURANT'=>$id),$data);
		$datas['message']='<div class="alert alert-success text-center" id="message">La modification du restaurant est faite avec succès</div>';
		$this->session->set_flashdata($datas);
		redirect(base_url('ihm/Restaurants/'));


	}

	function delete()
	{
		$table="restaurants";
		$criteres['ID_RESTAURANT']=$this->uri->segment(4);
		$data['rows']= $this->Modele->getOne( $table,$criteres);
		$this->Modele->delete($table,$criteres);

		$data['message']='<div class="alert alert-success text-center" id="message">Le restaurant  est supprimé avec succès</div>';
		$this->session->set_flashdata($data);
		redirect(base_url('ihm/Restaurants'));
	}
}
?>