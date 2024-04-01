<?php

class Assureur extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->have_droit();
  }

  public function have_droit()
  {
    if ($this->session->userdata('PSR_ELEMENT') != 1) {

      redirect(base_url());
    }
  }

  function index()
  {

    $data['title'] = 'Assureurs';
    $this->load->view('assurances/Assureur_List_View', $data);
  }


  function listing()
  {

    $i = 1;
    $query_principal = "SELECT ID_ASSUREUR,ASSURANCE,EMAIL,TELEPHONE,NIF,ADRESSE FROM assureur WHERE 1";

    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $limit = 'LIMIT 0,10';

    if ($_POST['length'] != -1) {
      $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }

    $order_by = '';

    $order_column = array('ASSURANCE', 'EMAIL', 'NIF', 'ADRESSE');

    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY ASSURANCE,EMAIL,NIF,ADRESSE ASC';

    $search = !empty($_POST['search']['value']) ? ("AND ASSURANCE LIKE '%$var_search%' OR EMAIL LIKE '%$var_search%' OR NIF LIKE '%$var_search%' OR ADRESSE LIKE '%$var_search%' ") : '';


    $critaire = '';

    $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

    $fetch_psr = $this->Modele->datatable($query_secondaire);
    $data = array();


    foreach ($fetch_psr as $row) {

      $option = '<div class="dropdown ">
  <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
  <i class="fa fa-cog"></i>
  Action
  <span class="caret"></span></a>
  <ul class="dropdown-menu dropdown-menu-left">
  ';

      $option .= "<li><a hre='#' data-toggle='modal'
  data-target='#mydelete" . $row->ID_ASSUREUR . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
      $option .= "<li><a class='btn-md' href='" . base_url('PSR/Assureur/getOne/' . $row->ID_ASSUREUR) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
      $option .= " </ul>
  </div>
  <div class='modal fade' id='mydelete" .  $row->ID_ASSUREUR . "'>
  <div class='modal-dialog'>
  <div class='modal-content'>

  <div class='modal-body'>
  <center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->ASSURANCE . " de " . $row->ADRESSE . "</i></b></h5></center>
  </div>

  <div class='modal-footer'>
  <a class='btn btn-danger btn-md' href='" . base_url('PSR/Assureur/delete/' . $row->ID_ASSUREUR) . "'>Supprimer</a>
  <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
  </div>

  </div>
  </div>
  </div>";

      $sub_array = array();
      //$sub_array[]=$i++;
      $sub_array[] = $row->ASSURANCE;
      $sub_array[] = $row->EMAIL;
      $sub_array[] = $row->NIF;
      $sub_array[] = $row->TELEPHONE;
      $sub_array[] = $row->ADRESSE;
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
    $data['infraPeines'] = $this->Modele->getRequete('SELECT `ID_ASSUREUR`,`ASSURANCE`,`EMAIL`,`NIF`,`ADRESSE` FROM `assureur` WHERE 1');

    $data['title'] = 'Nouveau Assureur';
    $this->load->view('assurances/Assureur_Add_View', $data);
  }

  function add()
  {

    $this->form_validation->set_rules('ASSURANCE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

    $this->form_validation->set_rules('EMAIL', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
    $this->form_validation->set_rules('TELEPHONE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

    $this->form_validation->set_rules('EMAIL', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


    $this->form_validation->set_rules('NIF', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

    $this->form_validation->set_rules('ADRESSE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

    if ($this->form_validation->run() == FALSE) {
      $this->ajouter();
    } else {
      $email = $this->input->post('EMAIL');
      $name = $this->input->post('ASSURANCE');
      $phone = $this->input->post('TELEPHONE');

      $data_insert = array(

        'ASSURANCE' => $name,

        'EMAIL' => $email,

        'TELEPHONE' => $phone,

        'NIF' => $this->input->post('NIF'),

        'ADRESSE' => $this->input->post('ADRESSE'),
      );

      $table = 'assureur';
      $idAssureur = $this->Modele->insert_last_id($table, $data_insert);

      $data_User = array(
        'NOM_UTILISATEUR' => $email,
        'MOT_DE_PASSE' => md5($phone),
        'PROFIL_ID' => 2,
        'ID_INSTITUTION' => $idAssureur,
      );
      // print_r($data_User);die();
      $subjet = 'creation de mot de passe';
      $message = "<div>votre mot de passe est '" . $password . "' 
  <p>Bonjour. Souhaitez-vous changer le mot de passe Cliquez <a href='" . base_url('Change_Password/index') . "'>ici</a> ?</p>
  </div>";

      $this->notifications->send_mail($email, $subjet, $cc_emails = NULL, $message, $attach = NULL);
      //          $this->notifications->send_sms($telephone,$message);
      $tabl = 'utilisateurs';
      $this->Modele->create($tabl, $data_User);

      $data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
      $this->session->set_flashdata($data);
      redirect(base_url('PSR/Assureur/'));
    }
  }


  function getOne()
  {
    $id = $this->uri->segment(4);
    $data['data'] = $this->Modele->getOne('assureur', array('ID_ASSUREUR' => $id));

    $data['title'] = "Modification d'un assureur";
    $this->load->view('assurances/Assureur_Update_View', $data);
  }

  function update()
  {
    $this->form_validation->set_rules('ASSURANCE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


    $this->form_validation->set_rules('EMAIL', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

    $this->form_validation->set_rules('TELEPHONE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

    $this->form_validation->set_rules('NIF', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

    $this->form_validation->set_rules('ADRESSE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


    $id = $this->input->post('ID_ASSUREUR');

    if ($this->form_validation->run() == FALSE) {
      $this->getOne();
    } else {
      $id = $this->input->post('ID_ASSUREUR');
      $phone = $this->input->post('TELEPHONE');

      $data = array(
        'ASSURANCE' => $this->input->post('ASSURANCE'),

        'EMAIL' => $this->input->post('EMAIL'),

        'TELEPHONE' => $phone,

        'NIF' => $this->input->post('NIF'),

        'ADRESSE' => $this->input->post('ADRESSE'),
      );

      $data_User = array(
        'NOM_UTILISATEUR' => $email,
        'MOT_DE_PASSE' => md5($phone),
        'PROFIL_ID' => 2,
        'ID_INSTITUTION' => $idAssureur,
      );

      $this->Modele->update('assureur', array('ID_ASSUREUR' => $id), $data);
      $this->Modele->updateData('utilisateurs', $data_User, array('ID_INSTITUTION' => $id));


      $datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
      $this->session->set_flashdata($datas);
      redirect(base_url('PSR/Assureur/'));
    }
  }


  function delete()
  {
    $table = "assureur";
    $criteres['ID_ASSUREUR'] = $this->uri->segment(4);
    $data['rows'] = $this->Modele->getOne($table, $criteres);
    $this->Modele->delete($table, $criteres);

    $data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
    $this->session->set_flashdata($data);
    redirect(base_url('PSR/Assureur/'));
  }
}
