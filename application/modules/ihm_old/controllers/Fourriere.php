<?php

class Fourriere extends CI_Controller
{
    function __construct()
  {
    parent::__construct();
    $this->have_droit();
  }

  public function have_droit()
  {
    if ($this->session->userdata('FOURRIERE') != 1) {

      redirect(base_url());
    }
  }
    function index()
    {
        $data['title'] = "Fourrières";
         $data['types'] = $this->Model->getRequete('SELECT ID_TYPE_FOURR, TYPE_FOURRIERE FROM psr_fourriere_type WHERE 1  ORDER BY TYPE_FOURRIERE ASC');
        $this->load->view('fourriere/Fourriere_List_view', $data);
    }

    function listing()
    {
        $i = 1;
        $TYPE_FOURRIERE = $this->input->post('TYPE_FOURRIERE');
          $critere_type ="";
          $critere_type = !empty($TYPE_FOURRIERE) ? "  AND pft. ID_TYPE_FOURR=".$TYPE_FOURRIERE." ":"";
        $query_principal = "SELECT pft.TYPE_FOURRIERE,pf.LOGO,pf.ID_FOURRIERE,obr.MODELE_VOITURE,obr.MARQUE_VOITURE, u.NOM_CITOYEN,u.PRENOM_CITOYEN,pf.NUMERO_PLAQUE, pf.NOM_FOURRIERE,pf.NON_DU_RESPONSABLE,pf.EMAIL_FROURRIERE,pf.TELEPHONE_FOURRIERE,pf.DATE_SAVE,pf.IS_ACTIVE FROM psr_fourriere pf  LEFT JOIN  utilisateurs u ON u.ID_UTILISATEUR=pf.ID_UTILISATEUR  LEFT JOIN obr_immatriculations_voitures obr ON obr.NUMERO_PLAQUE=pf.NUMERO_PLAQUE  LEFT JOIN psr_fourriere_type pft ON pft.ID_TYPE_FOURR=pf.TYPE_FOURRIERE WHERE 1 ".$critere_type;


        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search=str_replace("'", "\'", $var_search);

        $limit = 'LIMIT 0,10';

        if ($_POST['length'] != -1) {



            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }


        $order_by = '';

        $order_column = array('MODELE_VOITURE','MARQUE_VOITURE', 'NOM_CITOYEN','PRENOM_CITOYEN','NUMERO_PLAQUE', 'NOM_FOURRIERE','NON_DU_RESPONSABLE','EMAIL_FROURRIERE','TELEPHONE_FOURRIERE','DATE_SAVE','IS_ACTIVE');


        $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_SAVE ASC';

        $search = !empty($_POST['search']['value']) ? ("AND MARQUE_VOITURE LIKE '%$var_search%' ") : '';


        $critaire = '';

        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

        $fetch_fourriere = $this->Modele->datatable($query_secondaire);
        $data = array();
        foreach ($fetch_fourriere as $row) {
          $option = '<div class="dropdown ">
            <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-cog"></i>
            Action
            <span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-left">
            ';

            $option .= "<li><a  hre='#' id='".$row->NOM_FOURRIERE."'  title='".$row->NON_DU_RESPONSABLE."'  onclick='supprimer(".$row->ID_FOURRIERE.",this.title,this.id)'><font color='red'>&nbsp;&nbsp;Supprimer</font></a></li>";
            $option .= "<li><a class='btn-md' href='" . base_url('ihm/Fourriere/getOne/' . $row->ID_FOURRIERE) . "'><label class='text-info'>&nbsp;&nbsp;Modifier</label></a></li>";
            if($row->IS_ACTIVE==1 )
            {
               $option .= "<li><a  hre='#' id='".$row->NOM_FOURRIERE."'  title='".$row->NON_DU_RESPONSABLE."'  onclick='desactiver(".$row->ID_FOURRIERE.",this.title,this.id)'><font class='text-danger'>&nbsp;&nbsp;Désactiver</font></a></li>"; 
            }
            else{
                $option .= "<li><a  hre='#' id='".$row->NOM_FOURRIERE."'  title='".$row->NON_DU_RESPONSABLE."'  onclick='activer(".$row->ID_FOURRIERE.",this.title,this.id)'><font class='text-info'>&nbsp;&nbsp;Activer</font></a></li>";
            }
            $option .= "<li><a class='btn-md' href='#' id='".$row->NOM_FOURRIERE."'  title='".$row->NON_DU_RESPONSABLE."' onclick='getHistorique(".$row->ID_FOURRIERE.",this.title,this.id)'><label class='text-info'>&nbsp;&nbsp;Historique</label></a></li>";
            $option .= " </ul>
            </div>
            ";

            $sub_array = array();
            $source = !empty($row->LOGO) ? $row->LOGO : "https://app.mediabox.bi/wasiliEate/uploads/personne.png";

           
            
             
             $sub_array[] = '<table> <tbody><tr><td><a href="' . $source . '" target="_blank" ><img alt="Avtar" style="border-radius:50%;width:30px;height:30px" src="' . $source . '"></a></td><td>' . $row->NOM_FOURRIERE .'</td></tr></tbody></table></a>';
             $sub_array[]=$row->NUMERO_PLAQUE ? $row->NUMERO_PLAQUE:'N/A' ;
            $sub_array[] = $row->MODELE_VOITURE ? $row->MODELE_VOITURE:'N/A' ;
            $sub_array[] = $row->MARQUE_VOITURE ? $row->MARQUE_VOITURE:'N/A' ;
            $sub_array[] = $row->TYPE_FOURRIERE ;
            $sub_array[] = $row->NON_DU_RESPONSABLE ? $row->NON_DU_RESPONSABLE:'N/A' ;
            $sub_array[] = $row->TELEPHONE_FOURRIERE ? $row->TELEPHONE_FOURRIERE:'N/A' ;
            $sub_array[] = $row->EMAIL_FROURRIERE ? $row->EMAIL_FROURRIERE:'N/A' ;
            // $sub_array[] = $row->NOM_CITOYEN ? $row->NOM_CITOYEN:'N/A' ;
            // $sub_array[] = $row->PRENOM_CITOYEN ? $row->PRENOM_CITOYEN:'N/A' ;
            $sub_array[] = $row->IS_ACTIVE==1 ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>';
            $sub_array[] = $row->DATE_SAVE;
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
    function activer($ID_FOURRIERE)
    {
         $data = array('IS_ACTIVE' => 1);
            $this->Modele->update('psr_fourriere', array('ID_FOURRIERE' => $ID_FOURRIERE), $data);
            print_r(json_encode(1));
        }
    
    function desactiver($ID_FOURRIERE)
    {
            $data = array('IS_ACTIVE' => 0);
            $this->Modele->update('psr_fourriere', array('ID_FOURRIERE' => $ID_FOURRIERE), $data);
            print_r(json_encode(1));
    }
    function ajouter($sms='')
    {
        $data['title'] = 'Nouvelle Fourrière';
        $data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
        $data['types'] = $this->Model->getRequete('SELECT ID_TYPE_FOURR, TYPE_FOURRIERE FROM psr_fourriere_type WHERE 1  ORDER BY TYPE_FOURRIERE ASC');
        $data['message'] =$sms;
        $this->load->view('fourriere/Fourriere_add_view',$data);
    }
    function add(){
        
        $this->form_validation->set_rules('NUMERO_PLAQUE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

        $this->form_validation->set_rules('CARTE_ROSE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

        $this->form_validation->set_rules('NOM_FOURRIERE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

        $this->form_validation->set_rules('NON_DU_RESPONSABLE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

        $this->form_validation->set_rules('EMAIL_FROURRIERE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
        $this->form_validation->set_rules('TELEPHONE_FOURRIERE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
        $this->form_validation->set_rules('TELEPHONE_FOURRIERE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
        if ($this->form_validation->run() == FALSE) {
            $this->ajouter();
        }
         else {
            
                // initialize cURL
                $curl = curl_init();
                // set the URL to fetch
                curl_setopt($curl, CURLOPT_URL, "http://app.mediabox.bi:2522/plaques/search?plaque=".$this->input->post('NUMERO_PLAQUE'));
                // set the HTTP method to GET
                curl_setopt($curl, CURLOPT_HTTPGET, true);
                // follow any redirects
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                // return the response as a string
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                // execute the request and fetch the response
                $response = curl_exec($curl);
                // close the cURL session
                curl_close($curl);
                $res=json_decode($response);
            if(empty($res->result)){
                $sms= '<div class="alert alert-success text-center" id="message">Numero de la plaque introuvable</div>';
                $this->ajouter($sms);
            }
            else{
              $rose=$this->input->post('CARTE_ROSE');
             if($res->result->numero_carte_rose==$rose){
                    $file = $_FILES['PHOTO'];
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
            $this->upload->do_upload("PHOTO");
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
            }
$data_insert = array(
    'NUMERO_PLAQUE'=>$this->input->post('NUMERO_PLAQUE'),
    'NOM_FOURRIERE'=>$this->input->post('NOM_FOURRIERE'), 
    'NIF'=>$this->input->post('NIF'), 
    'NON_DU_RESPONSABLE'=>$this->input->post('NON_DU_RESPONSABLE'), 
    'EMAIL_FROURRIERE'=>$this->input->post('EMAIL_FROURRIERE'), 
    'TELEPHONE_FOURRIERE'=>$this->input->post('TELEPHONE_FOURRIERE'), 
    'TYPE_FOURRIERE'=>$this->input->post('TYPE_FOURRIERE'), 
    'LOGO'=>$pathfile, 
    'ADRESSE'=>$this->input->post('ADRESSE'), 
    'PROVINCE_ID'=>$this->input->post('PROVINCE_ID'),
    'LATITUDE_FOURRIERE'=>-1,
    'LONGITUDE_FOURRIERE'=>-1

);
$table = 'psr_fourriere';
$idPolice = $this->Modele->insert_last_id($table, $data_insert);
$data['message'] = '<div class="alert alert-success text-center" id="message">' . "L'ajout se faite avec succès" . '</div>';
$this->session->set_flashdata($data);
redirect(base_url('ihm/Fourriere/'));
         }
else{
 $sms= '<div class="alert alert-success text-center" id="message">Carte rose introuvable</div>';
    $this->ajouter($sms);
}
}
}

}
    function getOne($ID_FOURRIERE,$sms='')
    {
               $fourriere = $this->Modele->getRequeteOne('SELECT * FROM psr_fourriere WHERE  ID_FOURRIERE=' . $ID_FOURRIERE);
               // initialize cURL
                $curl = curl_init();
                // set the URL to fetch
                curl_setopt($curl, CURLOPT_URL, "http://app.mediabox.bi:2522/plaques/search?plaque=".$fourriere['NUMERO_PLAQUE']);
                // set the HTTP method to GET
                curl_setopt($curl, CURLOPT_HTTPGET, true);
                // follow any redirects
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                // return the response as a string
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                // execute the request and fetch the response
                $response = curl_exec($curl);
                // close the cURL session
                curl_close($curl);

                $res=json_decode($response);

                $data['fourriere']=$fourriere;
                // $data['rose']=(!empty($res->result) )? $res->result->numero_carte_rose :null;
                $data['provinces'] = $this->Model->getRequete('SELECT PROVINCE_ID,PROVINCE_NAME FROM syst_provinces WHERE 1 ORDER BY PROVINCE_NAME ASC');
                $data['types'] = $this->Model->getRequete('SELECT ID_TYPE_FOURR, TYPE_FOURRIERE FROM psr_fourriere_type WHERE 1  ORDER BY TYPE_FOURRIERE ASC');
                $data['title'] = "Modifier les informations d'une fourrière ";
                $data['message'] =$sms;
     
               $this->load->view('fourriere/Fourriere_update_view', $data);
    }
    function update(){
        
        $this->form_validation->set_rules('NUMERO_PLAQUE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));


        $this->form_validation->set_rules('NOM_FOURRIERE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

        $this->form_validation->set_rules('NON_DU_RESPONSABLE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));

        $this->form_validation->set_rules('EMAIL_FROURRIERE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
        $this->form_validation->set_rules('TELEPHONE_FOURRIERE', '', 'trim|required', array('required' => '<font style="color:red;size:2px;">Le champ est Obligatoire</font>'));
        ;
        if ($this->form_validation->run() == FALSE) {
            $this->update();
        }
        else {

            $file = $_FILES['PHOTO'];
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
            $this->upload->do_upload("PHOTO");
            $info = $this->upload->data();

            if ($file == '') {
                $pathfile = base_url() . 'uploads/sevtb.png';
            } else {
                $pathfile = base_url() . '/uploads/Gestion_Publication_Menu/' . $photonames . $info['file_ext'];
            }
            if (!empty($_FILES['PHOTO']['name'])) {
                  
        $data_insert = array(
            'NUMERO_PLAQUE'=>$this->input->post('NUMERO_PLAQUE'),
            'NOM_FOURRIERE'=>$this->input->post('NOM_FOURRIERE'), 
            'NIF'=>$this->input->post('NIF'), 
            'NON_DU_RESPONSABLE'=>$this->input->post('NON_DU_RESPONSABLE'), 
             'EMAIL_FROURRIERE'=>$this->input->post('EMAIL_FROURRIERE'), 
             'TELEPHONE_FOURRIERE'=>$this->input->post('TELEPHONE_FOURRIERE'), 
            'TYPE_FOURRIERE'=>$this->input->post('TYPE_FOURRIERE'), 
            'LOGO'=>$pathfile, 
            'ADRESSE'=>$this->input->post('ADRESSE'), 
            'PROVINCE_ID'=>$this->input->post('PROVINCE_ID')
                     );
        
            }else{
                $data_insert = array(
            'NUMERO_PLAQUE'=>$this->input->post('NUMERO_PLAQUE'),
            'NOM_FOURRIERE'=>$this->input->post('NOM_FOURRIERE'), 
            'NIF'=>$this->input->post('NIF'), 
            'NON_DU_RESPONSABLE'=>$this->input->post('NON_DU_RESPONSABLE'), 
             'EMAIL_FROURRIERE'=>$this->input->post('EMAIL_FROURRIERE'), 
             'TELEPHONE_FOURRIERE'=>$this->input->post('TELEPHONE_FOURRIERE'), 
            'TYPE_FOURRIERE'=>$this->input->post('TYPE_FOURRIERE'), 
            // 'LOGO'=>$pathfile, 
            'ADRESSE'=>$this->input->post('ADRESSE'), 
            'PROVINCE_ID'=>$this->input->post('PROVINCE_ID')
                     );
            }
             $id = $this->input->post('ID_FOURRIERE');
            $table = 'psr_fourriere';
            $this->Modele->update('psr_fourriere', array('ID_FOURRIERE' => $id), $data_insert);
            $data['message'] = '<div class="alert alert-success text-center" id="message">' . "Modiication se faite avec succès" . '</div>';
            $this->session->set_flashdata($data);
            redirect(base_url('ihm/Fourriere/'));
        }
    //     else {
            
    //         //     // initialize cURL
    //         //     $curl = curl_init();
    //         //     // set the URL to fetch
    //         //     curl_setopt($curl, CURLOPT_URL, "http://app.mediabox.bi:2522/plaques/search?plaque=".$this->input->post('NUMERO_PLAQUE'));
    //         //     // set the HTTP method to GET
    //         //     curl_setopt($curl, CURLOPT_HTTPGET, true);
    //         //     // follow any redirects
    //         //     curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    //         //     // return the response as a string
    //         //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //         //     // execute the request and fetch the response
    //         //     $response = curl_exec($curl);
    //         //     // close the cURL session
    //         //     curl_close($curl);
    //         //     $res=json_decode($response);
    //         // if(empty($res->result)){
    //         //     $sms= '<div class="alert alert-success text-center" id="message">Numero de la plaque introuvable</div>';
    //         //     $this->ajouter($sms);
    //         // }
    //         // else{
    //         //   $rose=$this->input->post('CARTE_ROSE');
    //         //  if($res->result->numero_carte_rose==$rose){
    //          $file = $_FILES['PHOTO'];
    //          $path = './uploads/Gestion_Publication_Menu/';
    //         if (!is_dir(FCPATH . '/uploads/Gestion_Publication_Menu/')) {
    //             mkdir(FCPATH . '/uploads/Gestion_Publication_Menu/', 0777, TRUE);
    //         }

    //         $thepath = base_url() . 'uploads/Gestion_Publication_Menu/';
    //         $config['upload_path'] = './uploads/Gestion_Publication_Menu/';
    //         $photonames = date('ymdHisa');
    //         $config['file_name'] = $photonames;
    //         $config['allowed_types'] = '*';
    //         $this->upload->initialize($config);
    //         $this->upload->do_upload("PHOTO");
    //         $info = $this->upload->data();

    //         if ($file == '') {
    //             $pathfile = base_url() . 'uploads/sevtb.png';
    //         } else {
    //             $pathfile = base_url() . '/uploads/Gestion_Publication_Menu/' . $photonames . $info['file_ext'];
    //         }
    //         $camerasImage = $this->input->post('ImageLink');
    //         if (!empty($camerasImage)) {

    //             $dir = FCPATH.'/uploads/cameraImagePsr/';
    //               if (!is_dir(FCPATH . '/uploads/cameraImagePsr/')) {
    //               mkdir(FCPATH . '/uploads/cameraImagePsr/', 0777, TRUE);
    //             }

    //             $photonames = date('ymdHisa');
    //             $pathfile = base_url() . 'uploads/cameraImagePsr/' . $photonames .".png";
    //             $pathfiless = FCPATH . '/uploads/cameraImagePsr/' . $photonames .".png";
    //             $file_name = $photonames .".png";
    //             $img = $this->input->post('ImageLink'); // Your data 'data:image/png;base64,AAAFBfj42Pj4';
    //             $img = str_replace('data:image/png;base64,', '', $img);
    //             $img = str_replace(' ', '+', $img);
    //             $data = base64_decode($img);
    //             file_put_contents($pathfiless, $data);
    //         }
    //         if (!empty($_FILES['PHOTO']['name'])) {
            

    //         }else{
            
    //         $data_insert = array('NUMERO_PLAQUE'=>$this->input->post('NUMERO_PLAQUE'),
    //                              'NOM_FOURRIERE'=>$this->input->post('NOM_FOURRIERE'), 
    //                              'NIF'=>$this->input->post('NIF'), 
    //                              'NON_DU_RESPONSABLE'=>$this->input->post('NON_DU_RESPONSABLE'), 
    //                              'EMAIL_FROURRIERE'=>$this->input->post('EMAIL_FROURRIERE'), 
    //                              'TELEPHONE_FOURRIERE'=>$this->input->post('TELEPHONE_FOURRIERE'), 
    //                              'TYPE_FOURRIERE'=>$this->input->post('TYPE_FOURRIERE'), 
    //                              // 'LOGO'=>$pathfile, 
    //                              'ADRESSE'=>$this->input->post('ADRESSE'), 
    //                              'PROVINCE_ID'=>$this->input->post('PROVINCE_ID')
    //                          );
      
    //         }
           
         // }
         // else{
         //     $sms= '<div class="alert alert-success text-center" id="message">Carte rose introuvable</div>';
         //        $this->update($sms);
         // }
      
    // }
            
    }
    public function supprimer($id)
    {
        $table = " psr_fourriere";
        $criteres['ID_FOURRIERE'] = $id;
        $data['rows'] = $this->Modele->getOne($table, $criteres);
        $this->Modele->delete($table, $criteres);
        print_r(json_encode(1));
    }
    function distance($lat1, $lng1, $lat2, $lng2)
    {
         $pi80 = M_PI / 180;
         $lat1 *= $pi80;
         $lng1 *= $pi80;
         $lat2 *= $pi80;
         $lng2 *= $pi80;
  
         $r = 6372.797; // rayon moyen de la Terre en km
         $dlat = $lat2 - $lat1;
         $dlng = $lng2 - $lng1;
         $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin(
        $dlng / 2) * sin($dlng / 2);
         $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
         $km = $r * $c;
         return ( $km);
    }

     function get_historique($ID_FOURRIERE){
        $i = 1;
        $query_principal = 'SELECT (6371 * acos( cos( radians(h.LATITUDE) ) * cos( radians( pfh.LATITUDE_END ) ) * cos( radians(pfh.LONGITUDE_END) - radians(h.LONGITUDE)) + sin(radians(h.LATITUDE)) * sin( radians(pfh.LATITUDE_END)))) AS DISTANCE,h.PSR_AFFECTATION_ID, h.ID_HISTORIQUE,h.NUMERO_PLAQUE,oiv.NOM_PROPRIETAIRE,oiv.PRENOM_PROPRIETAIRE,pfh.DATE_PRISE,pfh.DATE_END,pfh.IMAGE_CAR1,pfh.IMAGE_CAR2,pfh.IMAGE_CAR3,pfh.LONGITUDE_END,pfh.LATITUDE_END,pa.LIEU_EXACTE FROM  psr_fourriere_historique pfh  LEFT JOIN  historiques h ON h.ID_HISTORIQUE=pfh.ID_HISTORIQUE  LEFT JOIN obr_immatriculations_voitures oiv ON oiv.NUMERO_PLAQUE=h.NUMERO_PLAQUE  LEFT JOIN psr_affectatations pa ON pa.PSR_AFFECTATION_ID = h.PSR_AFFECTATION_ID LEFT JOIN psr_fourriere pf ON pf.ID_FOURRIERE=pfh.ID_FOURRIERE WHERE pf.ID_FOURRIERE='.$ID_FOURRIERE;

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

        $limit = 'LIMIT 0,10';


        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }

        $order_by = '';


        $order_column = array('NUMERO_PLAQUE','NOM_PROPRIETAIRE','PRENOM_PROPRIETAIRE','DATE_PRISE','DATE_END','IMAGE_CAR1','pa.LIEU_EXACTE');

        $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY DATE_END ASC';

        $search = !empty($_POST['search']['value']) ? ("AND NOM_PROPRIETAIRE LIKE '%$var_search%'") : '';

        $critaire = '';

        $query_secondaire = $query_principal . ' ' . $critaire . ' ' . $search . ' ' . $order_by . '   ' . $limit;
        $query_filter = $query_principal . ' ' . $critaire . ' ' . $search;

        $fetch_psr = $this->Modele->datatable($query_secondaire);
        $data = array();
        $no =0;
        $option='';
        // print_r($fetch_psr);
        // exit();
        foreach ($fetch_psr as $row) {
            // $no++;
            // $sub_array[] =$no;
             $sub_array = array();
            $sub_array[] = $row->NUMERO_PLAQUE;
            $sub_array[] = '<table> <tbody><tr><td>' . $row->NOM_PROPRIETAIRE . ' ' . $row->PRENOM_PROPRIETAIRE . '</td></tr></tbody></table></a>';
            $sub_array[] = $row->DATE_PRISE;
            $sub_array[] = $row->DATE_END;
            $sub_array[] = $row->LIEU_EXACTE;
            if (!empty($row->IMAGE_CAR1)) {
            $sub_array[]= "<table> <tbody><tr><td><a href='#'  title='" . $row->IMAGE_CAR1 . "' onclick='get_imag(this.title)' ><img style='width:15px' src='" . $row->IMAGE_CAR1 . "'></a></td><td><a href='#'  title='" . $row->IMAGE_CAR3. "' onclick='get_imag(this.title)' ><img style='width:15px' src='" . $row->IMAGE_CAR3 . "'></a></td><td><a href='#'  title='" . $row->IMAGE_CAR3 . "' onclick='get_imag(this.title)' ><img style='width:15px' src='" . $row->IMAGE_CAR3. "'></a></td></tr></tbody></table>";
        }
        else{
            $sub_array[]= "Aucun";
        }
            $sub_array[] = round($row->DISTANCE);
            $sub_array[] = ((round($row->DISTANCE))*10000)." BF";
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

}
