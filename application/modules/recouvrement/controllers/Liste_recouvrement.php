<?php
/**
* @author @nestorruhaya 
* with our almight aid
*/
class Liste_recouvrement extends CI_Controller
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
  public function index()
  { $data['title'] = 'Fréquence de recouvrement';
    $this->load->view('liste_recouvrement_view',$data);

}

function listing()

{

    $i = 1;
    $query_principal = "SELECT ID_RECOUVREMENT,DEBUT_COMPTE,TEMPS_INTERET,INTERET_ACCUMILE FROM recouvrement_config WHERE 1";

    $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
    $var_search=str_replace("'", "\'", $var_search);


    $limit = 'LIMIT 0,10';

    if ($_POST['length'] != -1) {
      $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
  }

  $order_by = '';

  $order_column = array('DEBUT_COMPTE','DEBUT_COMPTE', 'INTERET_ACCUMILE', 'TEMPS_INTERET',);

  $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DEBUT_COMPTE,TEMPS_INTERET,INTERET_ACCUMILE ASC';

  $search = !empty($_POST['search']['value']) ? ("AND TEMPS_INTERET LIKE '%$var_search%' OR INTERET_ACCUMILE LIKE '%$var_search%' OR DEBUT_COMPTE LIKE '%$var_search%'  ") : '';


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
      data-target='#mydelete" . $row->ID_RECOUVREMENT . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
      $option .= "<li><a class='btn-md' href='" . base_url('recouvrement/Liste_recouvrement/getOne/' . $row->ID_RECOUVREMENT) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
      $option .= " </ul>
      </div>
      <div class='modal fade' id='mydelete" .  $row->ID_RECOUVREMENT . "'>
      <div class='modal-dialog'>
      <div class='modal-content'>

      <div class='modal-body'>
      <center><h5><strong>Voulez-vous supprimer l'enregistrement?</strong> <br><b style='background-color:prink;color:green;'><i>"  . $row->ID_RECOUVREMENT ."</i></b></h5></center>
      </div>

      <div class='modal-footer'>
      <a class='btn btn-danger btn-md' href='" . base_url('recouvrement/Liste_recouvrement/delete/') . $row->ID_RECOUVREMENT . "'>Supprimer</a>
      <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
      </div>

      </div>
      </div>
      </div>";

      $sub_array = array();
      $sub_array[]=$i++;
      $sub_array[] = $row->DEBUT_COMPTE;
      $sub_array[] = $row->TEMPS_INTERET;
      $sub_array[] = $row->INTERET_ACCUMILE;
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
$data['title'] = 'Nouveau recouvrement';
    $this->load->view('add_recouvrement_view',$data);
}

function add()
{

    $this->form_validation->set_rules('DEBUT', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

    $this->form_validation->set_rules('TEMPS', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
    $this->form_validation->set_rules('INTERET', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


    if ($this->form_validation->run() == FALSE) {
      $this->ajouter();
  } else {
      $temps = $this->input->post('TEMPS');
      $debut = $this->input->post('DEBUT');
      $interet = $this->input->post('INTERET');

      $data_insert = array(

        'DEBUT_COMPTE' => $debut,
        'TEMPS_INTERET' => $temps,
        'INTERET_ACCUMILE' => $interet,
    );

      $table = 'recouvrement_config';
      $idrecouvrement = $this->Modele->insert_last_id($table, $data_insert);
      $data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout s'est faite avec succès" . '</div>';
      $this->session->set_flashdata($data);
      redirect(base_url('recouvrement/Liste_recouvrement/'));
  }
}


function getOne()
{
    $id = $this->uri->segment(4);
    $data['data'] = $this->Modele->getOne('recouvrement_config', array('ID_RECOUVREMENT' => $id));
    $data['title'] = 'Modification recouvrement';
    $this->load->view('recouvrement_update_view', $data);
}

function update()
{
    $this->form_validation->set_rules('DEBUT', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


    $this->form_validation->set_rules('TEMPS', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

    $this->form_validation->set_rules('INTERET', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

    $id = $this->input->post('ID_RECOUVREMENT');

    if ($this->form_validation->run() == FALSE) {
      $this->getOne();
  } else {
      $data = array(
        'DEBUT_COMPTE' => $this->input->post('DEBUT'),

        'TEMPS_INTERET' => $this->input->post('TEMPS'),

        'INTERET_ACCUMILE' => $this->input->post('INTERET'),
    );
// print_r($data);die;
      $this->Modele->update('recouvrement_config', array('ID_RECOUVREMENT' => $id), $data);
      $datas['message'] = '<div class="alert alert-success text-center" id="message">La modification  est faite avec succès</div>';
      $this->session->set_flashdata($datas);
      redirect(base_url('recouvrement/Liste_recouvrement/'));
  }
}


function delete()
{
    $table = "recouvrement_config";
    $criteres['ID_RECOUVREMENT'] = $this->uri->segment(4);
    $data['rows'] = $this->Modele->getOne($table, $criteres);
    $this->Modele->delete($table, $criteres);

    $data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
    $this->session->set_flashdata($data);
    redirect(base_url('recouvrement/Liste_recouvrement/'));
}
}
?>