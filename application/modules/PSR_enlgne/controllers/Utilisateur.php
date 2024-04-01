<?php

/**
 * NTAHIMPERA Martin Luther King
 * UTILISATEURS
 */

class Utilisateur extends CI_Controller
{

     function __construct()
     {
          parent::__construct();
          $this->have_droit();
     }


     public function have_droit()
     {
          if ($this->session->userdata('PARAMETRE') != 1) {

               redirect(base_url());
          }
     }
     function index()
     {
          $data['profil'] = $this->Modele->getRequete('SELECT PROFIL_ID, STATUT FROM profil WHERE 1 order by STATUT ASC');

          $data['title'] = "Utilisateur";
          $this->load->view('user/Utilisateurs_List_View', $data);
     }
     function listing()
     {
          $condition = '';
          $profil = $this->input->post('PROFIL_ID');
          if (!empty($profil)) {
               $condition .=  ' and user.PROFIL_ID = "' . $profil . '"';
          }
          $query_principal = 'SELECT CNI,ICON_LOGO,ID_UTILISATEUR, NOM_UTILISATEUR, user.PROFIL_ID,pr.STATUT, DATE_INSERTION FROM utilisateurs user LEFT JOIN psr_elements psr on psr.ID_PSR_ELEMENT=user.PSR_ELEMENT_ID LEFT JOIN profil pr on pr.PROFIL_ID=user.PROFIL_ID WHERE 1 ' . $condition . ' ';

          $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
          $var_search=str_replace("'", "\'", $var_search);
          $limit = 'LIMIT 0,10';


          if ($_POST['length'] != -1) {
               $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
          }

          $order_by = '';


           $order_column = array('NOM_UTILISATEUR','CNI', 'STATUT','DATE_INSERTION');
          $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY STATUT DESC';

          $search = !empty($_POST['search']['value']) ? ("AND NOM_UTILISATEUR LIKE '%$var_search%'  OR STATUT LIKE '%$var_search%'  ") : '';

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
               data-target='#mydelete" . $row->ID_UTILISATEUR . "'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
               $option .= "<li><a class='btn-md' href='" . base_url('PSR/Utilisateur/getOne/' . $row->ID_UTILISATEUR) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
               $option .= " </ul>
               </div>
               <div class='modal fade' id='mydelete" .


                    $row->ID_UTILISATEUR . "'>
               <div class='modal-dialog'>
               <div class='modal-content'>

               <div class='modal-body'>
               <center><h5><strong>Voulez-vous supprimer?</strong> <br><b style='background-color:prink;color:green;'><i>" . $row->NOM_UTILISATEUR . "</i></b></h5></center>
               </div>

               <div class='modal-footer'>
               <a class='btn btn-danger btn-md' href='" . base_url('PSR/Utilisateur/delete/' . $row->ID_UTILISATEUR) . "'>Supprimer</a>
               <button class='btn btn-primary btn-md' data-dismiss='modal'>Quitter</button>
               </div>

               </div>
               </div>
               </div>";
               $source = !empty($row->ICON_LOGO) ? $row->ICON_LOGO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";

               $sub_array = array();
               $sub_array[] = '<table> <tbody><tr><td><a title="' . $source . '" href="#" onclick="get_imag(this.title)" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM_UTILISATEUR . '</td></tr></tbody></table></a>';
                $sub_array[] = $row->CNI;

               // $sub_array = array();
               // // $sub_array[]=$i++;
               // $sub_array[] = '<table> <tbody><tr><td><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="https://app.mediabox.bi/wasiliEate/uploads/personne.png"></td><td>' . $row->NOM_UTILISATEUR . '</td></tr></tbody></table>';
               $sub_array[] = $row->STATUT;
               $sub_array[] = date("d-m-Y", strtotime($row->DATE_INSERTION));
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
          $data['CONTAGE_g'] = $this->Modele->getRequete('SELECT `PROFIL_ID`,`STATUT` FROM `profil` WHERE 1');
          $data['title'] = 'Nouveau utilisateur';
          $this->load->view('user/Utilisateurs_Add_View', $data);
     }
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
          $this->form_validation->set_rules('NOM_UTILISATEUR', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


          $this->form_validation->set_rules('PROFIL_ID', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

          $this->form_validation->set_rules('MOT_DE_PASSE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

          $this->form_validation->set_rules('CNI', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

          if ($this->form_validation->run() == FALSE) {
               $this->ajouter();
          } else {
              
            
               $file = $_FILES['ICON_LOGO'];
               $path = './uploads/Gestion_Publication_Menu/';
               if (!is_dir(FCPATH . '/uploads/Gestion_Publication_Menu/')) {
                    mkdir(FCPATH . '/uploads/Gestion_Publication_Menu/', 0777, TRUE);
               }

               $thepath = base_url() . 'uploads/Gestion_Publication_Menu/';
               $config['upload_path'] = './uploads/Gestion_Publication_Menu/';
               $photonames = date('ymdHisa');
               $config['file_name'] = $photonames;
               $config['allowed_types'] = '*';
               $this->upload->initialize($config);
               $this->upload->do_upload("ICON_LOGO");
               $info = $this->upload->data();

               if ($file == '') {
                    $pathfile = base_url() . 'uploads/sevtb.png';
               } else {
                    $pathfile = base_url() . '/uploads/Gestion_Publication_Menu/' . $photonames . $info['file_ext'];
               }


               $camerasImage = $this->input->post('ImageLink');

               if (!empty($camerasImage)) {

                    $dir = FCPATH.'/uploads/cameraImagePsr/';
                     if (!is_dir(FCPATH . '/uploads/cameraImagePsr/')) {
                      mkdir(FCPATH . '/uploads/cameraImagePsr/', 0777, TRUE);
                   }

                $photonames = date('ymdHisa');
                $pathfile = base_url() . 'uploads/cameraImagePsr/' . $photonames .".png";
                   $pathfiless = FCPATH . '/uploads/cameraImagePsr/' . $photonames .".png";
                   $file_name = $photonames .".png";

                   $img = $this->input->post('ImageLink'); // Your data 'data:image/png;base64,AAAFBfj42Pj4';
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                file_put_contents($pathfiless, $data);

                    //echo "<img src='".$path."' >";
                    
               }

                    $data_insert = array(

                    'NOM_UTILISATEUR' => $this->input->post('NOM_UTILISATEUR'),
                    'MOT_DE_PASSE' => md5($this->input->post('MOT_DE_PASSE')),
                    'PROFIL_ID' => $this->input->post('PROFIL_ID'),
                    'CNI' => $this->input->post('CNI'),
                    'ICON_LOGO'=>$pathfile
               );
               
               $table = 'utilisateurs';
               $this->Modele->create($table, $data_insert);

               $data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
               $this->session->set_flashdata($data);
               redirect(base_url('PSR/Utilisateur/index'));
          }
     }


     function getOne($id = 0)
     {
          $data['user'] = $this->Modele->getRequeteOne('SELECT ID_UTILISATEUR, NOM_UTILISATEUR,CNI,PROFIL_ID,PSR_ELEMENT_ID FROM utilisateurs WHERE  ID_UTILISATEUR=' . $id);

          $data['profil'] = $this->Model->getRequete('SELECT PROFIL_ID, STATUT FROM profil WHERE 1 ORDER BY STATUT ASC');

          $data['title'] = "Modification de l'utilisateur";
          $this->load->view('user/Utilisateurs_Update_View', $data);
     }

     function update()
     {
         
         $this->form_validation->set_rules('NOM_UTILISATEUR', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


          $this->form_validation->set_rules('PROFIL_ID', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

         
          $this->form_validation->set_rules('CNI', '', 'trim|required|callback_validate_name', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


          if ($this->form_validation->run() == FALSE) {
               //$id=$this->input->post('ID_GERANT');

               $this->getOne($this->input->post('ID_UTILISATEUR'));

          }
           else {
   

               $file = $_FILES['ICON_LOGO'];
               $path = './uploads/Gestion_Publication_Menu/';
               if (!is_dir(FCPATH . '/uploads/Gestion_Publication_Menu/')) {
                    mkdir(FCPATH . '/uploads/Gestion_Publication_Menu/', 0777, TRUE);
               }

               $thepath = base_url() . 'uploads/Gestion_Publication_Menu/';
               $config['upload_path'] = './uploads/Gestion_Publication_Menu/';
               $photonames = date('ymdHisa');
               $config['file_name'] = $photonames;
               $config['allowed_types'] = '*';
               $this->upload->initialize($config);
               $this->upload->do_upload("ICON_LOGO");
               $info = $this->upload->data();

               if ($file == '') {
                    $pathfile = base_url() . 'uploads/sevtb.png';
               } else {
                    $pathfile = base_url() . '/uploads/Gestion_Publication_Menu/' . $photonames . $info['file_ext'];
               }
               $id = $this->input->post('ID_PSR_ELEMENT');
               $telephone = $this->input->post('TELEPHONE');
               $email = $this->input->post('EMAIL');
               $profil = 6;

               
            
             
            if (!empty($_FILES['ICON_LOGO']['name'])) {

               $data = array(
                    'NOM_UTILISATEUR' => $this->input->post('NOM_UTILISATEUR'),
                    'CNI' => $this->input->post('CNI'),
                    'PROFIL_ID' => $this->input->post('PROFIL_ID'),
                    'ICON_LOGO'=>$pathfile
               );
            }
            else{
               $data = array(
                    'NOM_UTILISATEUR' => $this->input->post('NOM_UTILISATEUR'),
                    'CNI' => $this->input->post('CNI'),
                    // 'MOT_DE_PASSE' => md5($this->input->post('MOT_DE_PASSE')),
                    'PROFIL_ID' => $this->input->post('PROFIL_ID'),
               );
            }

               $this->Modele->update('utilisateurs', array('ID_UTILISATEUR' => $this->input->post('ID_UTILISATEUR')), $data);

               $datas['message'] = '<div class="alert alert-success text-center" id="message">La modification du menu est faite avec succès</div>';
               $this->session->set_flashdata($datas);
               redirect(base_url('PSR/Utilisateur/index'));
          }
     }

     function delete()
     {
          $table = "utilisateurs";
          $criteres['ID_UTILISATEUR'] = $this->uri->segment(4);
          $data['rows'] = $this->Modele->getOne($table, $criteres);
          $this->Modele->delete($table, $criteres);

          $data['message'] = '<div class="alert alert-success text-center" id="message">L"Element est supprimé avec succès</div>';
          $this->session->set_flashdata($data);
          redirect(base_url('PSR/Utilisateur'));
     }
}
