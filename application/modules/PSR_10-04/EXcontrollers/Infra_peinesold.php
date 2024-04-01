<?php

/**
 *NTAHIMPERA Martin Luther King
 * Element de la police 
 **/
class Infra_peines extends CI_Controller
{

  
  function __construct()
  {
    parent::__construct();
    $this->have_droit();
  }

  public function have_droit()
  {
    if ($this->session->userdata('PEINES') != 1) {

      redirect(base_url());
    }
  }

  function index()
  {
    //if()
    $type_verification = $this->Modele->getRequete(' SELECT ID_TYPE_VERIFICATION, VERIFICATION FROM type_verification WHERE 1 ORDER BY VERIFICATION');

    $data['type_verification'] = $type_verification;
    $data['title'] = "".lang('titre_Infra')."";
    $this->load->view('peines_list_view', $data);
  }

  function listing()
  {
    //$i = 1;
    $verifications = $this->input->post('ID_TYPE_VERIFICATION');

    $critere_command = !empty($verifications) ? "and type_verification.ID_TYPE_VERIFICATION= " . $verifications . " " : "";
    $query_principal = 'SELECT ID_INFRA_PEINE, ii.NIVEAU_ALERTE as NIVEAU_ALERTE,type_verification.ID_TYPE_VERIFICATION, AMENDES, MONTANT, POINTS FROM infra_peines ip LEFT JOIN infra_infractions ii on ii.ID_INFRA_INFRACTION=ip.ID_INFRA_INFRACTION LEFT JOIN type_verification ON type_verification.ID_TYPE_VERIFICATION=ii.ID_TYPE_VERIFICATION WHERE 1 ' . $critere_command . ' ';

    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

    $limit = 'LIMIT 0,10';


    if ($_POST['length'] != -1) {
      $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }

    $order_by = '';


    $order_column = array('NIVEAU_ALERTE', 'AMENDES', 'MONTANT', 'POINTS');

    $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NIVEAU_ALERTE ASC';

    $search = !empty($_POST['search']['value']) ? ("AND NIVEAU_ALERTE LIKE '%$var_search%' OR AMENDES LIKE '%$var_search%' OR MONTANT LIKE '%$var_search%'  ") : '';

    $critaire = '';

    $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
    $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

    $fetch_psr = $this->Modele->datatable($query_secondaire);
    $data = array();

    foreach ($fetch_psr as $row) {

      $done=$this->Modele->getOne('infra_peines',array('ID_INFRA_PEINE'=>$row->ID_INFRA_PEINE));     
      $array = json_decode($done['AMENDES'], true);

      $option = '<div class="dropdown ">
    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-cog"></i>
    Action
    <span class="caret"></span></a>
    <ul class="dropdown-menu dropdown-menu-left">
    ';

      $option .= "<li><a hre='#' data-toggle='modal'
    data-target='#mydelete" . $row->ID_INFRA_PEINE . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
      $option .= "<li><a class='btn-md' href='" . base_url('PSR/Infra_peines/getOne/' . $row->ID_INFRA_PEINE) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
      $option .= " </ul>
    </div>
    <div class='modal fade' id='mydelete" .  $row->ID_INFRA_PEINE . "'>
    <div class='modal-dialog'>
    <div class='modal-content'>

    <div class='modal-body'>
    <center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->AMENDES . "</i></b></h5></center>
    </div>

    <div class='modal-footer'>
    <a class='btn btn-danger btn-md' href='" . base_url('PSR/infra_peines/delete/' . $row->ID_INFRA_PEINE) . "'>Supprimer</a>
    <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
    </div>

    </div>
    </div>
    </div>";

      $sub_array = array();
      // $sub_array[]=$i++;
      $sub_array[] = $row->NIVEAU_ALERTE;
      $sub_array[] = $array ? $array['FR'] : $row->AMENDES;
      $sub_array[] = "<span style='float:right'>" . number_format($row->MONTANT, 0, '.', ' ') . " FBU</span>";
      $sub_array[] = $row->POINTS;

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
    $data['infraPeines'] = $this->Modele->getRequete('SELECT ID_INFRA_INFRACTION, NIVEAU_ALERTE FROM infra_infractions WHERE 1');

    $data['title'] = 'Nouveau Infraction';
    $this->load->view('peines_add_view', $data);
  }

  function add()
  {

    $this->form_validation->set_rules('ID_INFRA_INFRACTION', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


    $this->form_validation->set_rules('AMENDES', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

    $this->form_validation->set_rules('MONTANT', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
    $this->form_validation->set_rules('POINTS', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

    if ($this->form_validation->run() == FALSE) {
      $this->ajouter();
    } else {

      $data_insert = array(

        'ID_INFRA_INFRACTION' => $this->input->post('ID_INFRA_INFRACTION'),

        'AMENDES' => $this->input->post('AMENDES'),

        'MONTANT' => $this->input->post('MONTANT'),

        'POINTS' => $this->input->post('POINTS'),

        'PEINES_TRADUCTION' => $this->input->post('PEINES_TRADUCTION'),
      );

      $table = 'infra_peines';
      $this->Modele->create($table, $data_insert);

      $data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
      $this->session->set_flashdata($data);
      redirect(base_url('PSR/Infra_peines/'));
    }
  }
  function getOne()
  {
    $id = $this->uri->segment(4);
    $data['data'] = $this->Modele->getOne('infra_peines', array('ID_INFRA_PEINE' => $id));
    $data['infraPeines'] = $this->Modele->getRequete('SELECT ID_INFRA_INFRACTION, NIVEAU_ALERTE FROM infra_infractions WHERE 1');

    $data['title'] = "Modification sur un infractions";
    $this->load->view('peines_update_view', $data);
  }

  function update()
  {
    $this->form_validation->set_rules('ID_INFRA_INFRACTION', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


    $this->form_validation->set_rules('AMENDES', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

    $this->form_validation->set_rules('MONTANT', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

    $this->form_validation->set_rules('POINTS', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


    $id = $this->input->post('ID_INFRA_PEINE');

    if ($this->form_validation->run() == FALSE) {
      //$id=$this->input->post('ID_GERANT');

      $this->getOne();
    } else {
      $id = $this->input->post('ID_INFRA_PEINE');

      $data = array(
        'ID_INFRA_INFRACTION' => $this->input->post('ID_INFRA_INFRACTION'),

        'AMENDES' => $this->input->post('AMENDES'),

        'MONTANT' => $this->input->post('MONTANT'),

        'POINTS' => $this->input->post('POINTS'),

        'PEINES_TRADUCTION' => $this->input->post('PEINES_TRADUCTION'),
        
      );

      $this->Modele->update('infra_peines', array('ID_INFRA_PEINE' => $id), $data);
      $datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
      $this->session->set_flashdata($datas);
      redirect(base_url('PSR/Infra_peines/'));
    }
  }

  function saveForma(){

    $FR = $this->input->post('FR');
    $ENG = $this->input->post('ENG');
    $KIR = $this->input->post('KIR');
    $KISW = $this->input->post('KISW');

    $data  = array(
      'FR'=>$FR,
      'ENG'=>$ENG,
      'KIR'=>$KIR,
      'KISW'=>$KISW,
    );

    echo json_encode($data);

  }

  function delete()
  {
    $table = "infra_peines";
    $criteres['ID_INFRA_PEINE'] = $this->uri->segment(4);
    $data['rows'] = $this->Modele->getOne($table, $criteres);
    $this->Modele->delete($table, $criteres);

    $data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
    $this->session->set_flashdata($data);
    redirect(base_url('PSR/Infra_peines/'));
  }
}
