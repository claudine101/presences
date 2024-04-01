<?php

class Notification extends CI_Controller

{

  function index()
  {
    $data['title']="NOTIFICATION";
    $this->load->view('Notification_List_V',$data);
  }

  function listing()
  {
   $query_principal='SELECT ID_NOTIFICATION, u.NOM_UTILISATEUR as NOM, MESSAGE, if (STATUT=1,"envoyer","non envoyer")as STATUT FROM notifications n JOIN utilisateurs u on n.USER_ID=u.ID_UTILISATEUR WHERE 1';

   $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

   $limit='LIMIT 0,10';

   if($_POST['length'] != -1){



     $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
   }


   $order_by='';

   $order_column=array('ID_NOTIFICATION','NOM','MESSAGE','STATUT');

   $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM,MESSAGE ASC';

   $search = !empty($_POST['search']['value']) ? ("AND NOM LIKE '%$var_search%' OR MESSAGE LIKE '%$var_search%' "):'';


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
     data-target='#mydelete" . $row->ID_NOTIFICATION . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
              
     $option .= " </ul>
     </div>
     <div class='modal fade' id='mydelete".$row->ID_NOTIFICATION. "'>
     <div class='modal-dialog'>
     <div class='modal-content'>

     <div class='modal-body'>
     <center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>".$row->MESSAGE."</i></b></h5></center>
     </div>


     <div class='modal-footer'>
     <a class='btn btn-danger btn-md' href='" . base_url('ihm/Voyage_trajet/delete/'.$row->ID_NOTIFICATION) . "'>Supprimer</a>
     <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
     </div>

     </div>
     </div>
     </div>";

     $sub_array = array();
     $sub_array[]='<table> <tbody><tr><td>' . $row->NOM .' </td></tr></tbody></table>';
     $sub_array[]=$row->MESSAGE;
     $sub_array[]=$row->STATUT;		
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

 function delete()
 {

   $table="notifications";
   $criteres['ID_NOTIFICATION']=$this->uri->segment(4);
   $data['rows']= $this->Modele->getOne( $table,$criteres);
   $this->Modele->delete($table,$criteres);

   $data['message']='<div class="alert alert-success text-center" id="message">Suppression effectuer avec succès</div>';
   $this->session->set_flashdata($data);
   redirect(base_url('ihm/Notification'));
 }





}
