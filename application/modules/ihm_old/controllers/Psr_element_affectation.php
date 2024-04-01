<?php

class Psr_element_affectation extends CI_Controller
{
     function __construct()
     {
          parent::__construct();
          $this->have_droit();
     }

     public function have_droit()
     {
          if ($this->session->userdata('RH_AFFECTATION') != 1) {

               redirect(base_url());
          }
     }

     function index()
     {
          $data['title'] = "Affectations";
          $this->load->view('Psr_affectation_Element_List_View', $data);
     }


     function listing()
     {
          $i = 1;
          $query_principal = "SELECT `ELEMENT_AFFECT_ID`,p.NOM,p.PRENOM,p.NUMERO_MATRICULE,`DATE_DEBUT`,`DATE_FIN`,IF(IS_ACTIVE = 1, 'oui','Non') as IS_ACTIVE,e.DATE_INSERT, f.LIEU_EXACTE as LIEU FROM psr_element_affectation e JOIN psr_elements p on e.ID_PSR_ELEMENT=p.ID_PSR_ELEMENT LEFT JOIN psr_affectatations f on f.PSR_AFFECTATION_ID=e.PSR_AFFECTATION_ID";


          $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
           $var_search=str_replace("'", "\'", $var_search);

          $limit = 'LIMIT 0,10';


          if ($_POST['length'] != -1) {



               $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
          }


          $order_by = '';

          $order_column = array('NOM', 'PRENOM', 'LIEU', 'DATE_DEBUT', 'DATE_FIN', 'IS_ACTIVE', 'DATE_INSERT');

          $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY NOM,PRENOM DESC';

          $search = !empty($_POST['search']['value']) ? ("AND NOM LIKE '%$var_search%'  OR PRENOM LIKE '%$var_search%'  ") : '';


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
               data-target='#mydelete" . $row->ELEMENT_AFFECT_ID . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
               $option .= "<li><a class='btn-md' href='" . base_url('ihm/Psr_element_affectation/getOne/' . $row->ELEMENT_AFFECT_ID) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
               $option .= " </ul>

               </div>
               <div class='modal fade' id='mydelete" . $row->ELEMENT_AFFECT_ID . "'>
               <div class='modal-dialog'>
               <div class='modal-content'>

               <div class='modal-body'>
     <center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->NOM . " " . $row->PRENOM . " " . $row->LIEU . " " . $row->DATE_DEBUT . " " . $row->DATE_FIN . " " . $row->IS_ACTIVE . " " . $row->DATE_INSERT . "</i></b></h5></center>
               </div>

               <div class='modal-footer'>
               <a class='btn btn-danger btn-md' href='" . base_url('ihm/Psr_element_affectation/delete/' . $row->ELEMENT_AFFECT_ID) . "'>Supprimer</a>
               <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
               </div>

               </div>
               </div>
               </div>";
               $source = !empty($row->PHOTO) ? $row->PHOTO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";

               $sub_array = array();
               $sub_array[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM . ' ' . $row->PRENOM . ' </td></tr></tbody></table></a>';
               // <font style="font-size:10px;color:red"><i class="far fa-comment-dots"></i></font>
               $sub_array[] = $row->LIEU;
               $sub_array[] = $row->DATE_DEBUT;
               $sub_array[] = $row->DATE_FIN;
               $sub_array[] = $row->IS_ACTIVE;
               $sub_array[] = $row->DATE_INSERT;
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
          $data['postes'] = $this->Modele->getRequete('SELECT `PSR_AFFECTATION_ID`,`LIEU_EXACTE` FROM `psr_affectatations` WHERE 1');

          $data['polices'] = $this->Modele->getRequete('SELECT `ID_PSR_ELEMENT`, concat(`NOM`," ",`PRENOM`," (",`NUMERO_MATRICULE`,")") as PNB FROM `psr_elements` WHERE 1 ORDER by `NOM`,`PRENOM`,`NUMERO_MATRICULE`');

          $data['title'] = "NOUVELLE AFFECTATION";

          $this->load->view('Psr_affectation_Element_Add_View', $data);
     }


     function add()
     {

          $update = array(

               'IS_ACTIVE' => 0
          );

          $test = $this->Modele->update('psr_element_affectation', array('ID_PSR_ELEMENT' => $this->input->post('ID_PSR_ELEMENT')), $update);



          $data_insert = array(
               'ID_PSR_ELEMENT' => $this->input->post('ID_PSR_ELEMENT'),
               'PSR_AFFECTATION_ID' => $this->input->post('PSR_AFFECTATION_ID'),
               'DATE_DEBUT' => $this->input->post('DATE_DEBUT'),
               'DATE_FIN' => $this->input->post('DATE_FIN'),
               'IS_ACTIVE' => 1,
          );


          $table = 'psr_element_affectation';
          $this->Modele->create($table, $data_insert);


          $data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
          $this->session->set_flashdata($data);
          redirect(base_url('ihm/Psr_element_affectation/index'));
     }


     function getOne($id = 0)
     {


          $data['postes'] = $this->Modele->getRequete('SELECT `PSR_AFFECTATION_ID`,`LIEU_EXACTE` FROM `psr_affectatations` WHERE 1');

          $data['polices'] = $this->Modele->getRequete('SELECT `ID_PSR_ELEMENT`, concat(`NOM`," ",`PRENOM`," (",`NUMERO_MATRICULE`,")") as PNB FROM `psr_elements` WHERE 1 ORDER by `NOM`,`PRENOM`,`NUMERO_MATRICULE`');

          $data['donne'] = $this->Modele->getOne('psr_element_affectation', array('ELEMENT_AFFECT_ID' => $id));



          $data['title'] = "Modification";
          $this->load->view('ihm/psr_update_aff', $data);
     }


     function delete()
     {
          $table = "psr_element_affectation";
          $criteres['ELEMENT_AFFECT_ID'] = $this->uri->segment(4);
          $data['rows'] = $this->Modele->getOne($table, $criteres);
          $this->Modele->delete($table, $criteres);

          $data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
          $this->session->set_flashdata($data);
          redirect(base_url('ihm/Psr_element_affectation'));
     }





     function updateData()
     {

          $ELEMENT_AFFECT_ID =  $this->input->post('ELEMENT_AFFECT_ID');

          $donnes = array(
               'ID_PSR_ELEMENT' => $this->input->post('ID_PSR_ELEMENT'),
               'PSR_AFFECTATION_ID' => $this->input->post('PSR_AFFECTATION_ID'),
               'DATE_DEBUT' => $this->input->post('DATE_DEBUT'),
               'DATE_FIN' => $this->input->post('DATE_FIN'),
               'IS_ACTIVE' => 1,
          );



          $don =  $this->Modele->update('psr_element_affectation', array('ELEMENT_AFFECT_ID' => $ELEMENT_AFFECT_ID), $donnes);


          $data['message'] = '<div class="alert alert-success text-center" id="message">Modification fait avec succès</div>';
          $this->session->set_flashdata($data);

          redirect(base_url('ihm/Psr_element_affectation'));
     }
}
