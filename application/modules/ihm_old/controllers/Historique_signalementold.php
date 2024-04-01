<?php
class  Historique_signalement extends CI_Controller
{
  function index()
  {
    $data['title']="Signalements traités";
    $this->load->view('historique/historique_signalement_list',$data);
  }


  function confirmEcocashPaid($txi_id = 0){

    $this->Modele->update('historique_signalement',array('TNX_ID'=> $txi_id),array('STATUT_PAYE'=> 1));

    echo $txi_id;

  }



  function listing()
  {

    $query_principal='SELECT ID_HISTO_SIGNALEMMENT,pr.STATUT, obr.NUMERO_PLAQUE,ca.STATUT_TRAITEMENT,sv.DESCRIPTION, DESCRIPTION_INFRATION, AMENDE,sv.ID_STATUT,STATUT_PAYE, IF(STATUT_PAYE=1, "payé" ,"non payé") AS STATUT_PAY , DATE_INSERT, ca.CIVIL_DESCRIPTION, user.NOM_UTILISATEUR,COMMENATAIRE FROM historique_signalement hs LEFT JOIN obr_immatriculations_voitures obr on obr.ID_IMMATRICULATION=hs.ID_IMMATICULATION LEFT JOIN utilisateurs user ON user.ID_UTILISATEUR=hs.USER_ID LEFT JOIN profil pr ON pr.PROFIL_ID=user.PROFIL_ID LEFT JOIN civil_alerts ca ON ca.ID_ALERT=hs.ID_ALERT LEFT JOIN statut_validation sv ON sv.ID_STATUT=ca.STATUT_TRAITEMENT  WHERE 1';


    $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $limit='LIMIT 0,10';

    if($_POST['length'] != -1){



     $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
   }

   $order_by='';

   $order_column=array('NUMERO_PLAQUE','DESCRIPTION_INFRATION','AMENDE','STATUT_PAYE','CIVIL_DESCRIPTION','NOM_UTILISATEUR');

   $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY ID_HISTO_SIGNALEMMENT ASC';

   $search = !empty($_POST['search']['value']) ? ("AND NUMERO_PLAQUE LIKE '%$var_search%' OR NOM_UTILISATEUR LIKE '%$var_search%' OR DESCRIPTION_INFRATION LIKE '%$var_search%' OR AMENDE LIKE '%$var_search%' "):'';     
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
    data-target='#mydelete" . $row->ID_HISTO_SIGNALEMMENT . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";

    $option .= ($row->STATUT_PAYE ==0) ? "<li><a hre='#' data-toggle='modal'
    data-target='#PaiementModal' onclick='getPayement(".$row->ID_HISTO_SIGNALEMMENT.",".$row->AMENDE.")'><font color='blue'>&nbsp;&nbsp;Payé</font></a></li>" : "";



    $option .= " </ul>
    </div>
    <div class='modal fade' id='mydelete". $row->ID_HISTO_SIGNALEMMENT. "'>
    <div class='modal-dialog'>
    <div class='modal-content'>

    <div class='modal-body'>
    <center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i> ".$row->NUMERO_PLAQUE." ".$row->NOM_UTILISATEUR." </i></b></h5></center>
    </div>

    <div class='modal-footer'>
    <a class='btn btn-danger btn-md' href='" . base_url('ihm/Historique_signalement/delete/'.$row->ID_HISTO_SIGNALEMMENT) . "'>Supprimer</a>
    <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
    </div>

    </div>
    </div>
    </div> ";

    $sub_array = array();
    $sub_array[]= '<table> <tbody><tr><td>' . $row->NOM_UTILISATEUR .'<br>'.$row->DESCRIPTION.'<font style="font-size:10px;color:red"><i class="far fa-comment-dots"></i></font></td></tr></tbody></table>';
    $sub_array[]=$row->NUMERO_PLAQUE;
    $sub_array[]=$row->DESCRIPTION_INFRATION;
    $sub_array[]="<span style='float:right'>".number_format($row->AMENDE,0,',',' ')."</span>";
    $sub_array[]=$row->CIVIL_DESCRIPTION;
    $sub_array[]=$row->STATUT_PAY;
    $sub_array[]=date("d-m-Y", strtotime($row->DATE_INSERT));     
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

  $table="historique_signalement";
  $criteres['ID_HISTO_SIGNALEMMENT']=$this->uri->segment(4);
  $data['rows']= $this->Modele->getOne( $table,$criteres);
  $this->Modele->delete($table,$criteres);

  $data['message']='<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
  $this->session->set_flashdata($data);
  redirect(base_url('ihm/Historique_signalement'));

}

function PayementEcocash($id,$amande){

  $url='http://app.mediabox.bi/api_ussd_php/Api_client_ecocash';
  $clientPhone=$this->input->post('Telephone');

  $data=array(
      'VENDEUR_PHONE'=>'71028884',
      'AMOUNT'=>'100',
      'CLIENT_PHONE'=>$clientPhone,
      'INSTANCE_TOKEN'=>'36'
  );
 $send= $this->httpPost($url,json_encode($data));
print_r($send);die();

}




function httpPost()
{ 
    $AMENDE =  $this->input->post('AMENDE');
    $Telephone =  $this->input->post('Telephone');
    $ID_HISTO_SIGNALEMMENT =  $this->input->post('ID_HISTO_SIGNALEMMENT');

        $data = array("VENDEUR_PHONE"=>"79839653","AMOUNT"=>$AMENDE,
                  "CLIENT_PHONE"=>$Telephone,"INSTANCE_TOKEN"=>"202022");

        $url = 'http://app.mediabox.bi/api_ussd_php/Api_client_ecocash';
        if(is_array($data)){ $data = json_encode($data);}
        $options = stream_context_create(['http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => $data
        ]]);
        $response = file_get_contents($url,false,$options);

        $respon = json_decode($response);

        if ($respon->statut == "200") {
          $this->Modele->update('historique_signalement',array('ID_HISTO_SIGNALEMMENT'=> $ID_HISTO_SIGNALEMMENT),array('TNX_ID'=> $respon->txn_id));
        }

        print_r($response);
} 


function confirm()
{

  $table="historique_signalement";
  $criteres['ID_HISTO_SIGNALEMMENT']=$this->uri->segment(4);
  $data['rows']= $this->Modele->getOne( $table,$criteres);
  $this->Modele->update($table,$criteres,array('STATUT_PAYE'=>1));

  $data['message']='<div class="alert alert-success text-center" id="message">L"Element est confirmé avec succès</div>';
  $this->session->set_flashdata($data);
  redirect(base_url('ihm/Historique_signalement'));


}


}
?>