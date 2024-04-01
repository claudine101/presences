
<?php
class Admin_User  extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->is_Oauth();

    }

//user_rh_fonction
      public   function is_Oauth()
      {
      if($this->session->userdata('ID_UTILISATEUR ')==NULL){
        redirect(base_url());
       }
      }

      public function index()
      {
        $data['title']='ENREGISTRER L\'UTILISATEUR';
        $data['restaurants']=$this->Model->getList('restaurants');
        $data['admin_profil']=$this->Model->getList('utilisateurs');

        $this->load->view('Admin_User_Add_View',$data);
      }

      public function add_user()
      {
        $this->form_validation->set_rules('NOM','','trim|required',array('required'=>'<font style="font-size:15px;">*Veuillez entrer le nom  de l\'utilisateur</font>'));
        $this->form_validation->set_rules('PRENOM','','trim|required',array('required'=>'<font style="font-size:15px;">*Veuillez entrer le prenom de l\'utilisateur</font>'));
        $this->form_validation->set_rules('ID_RESTAURANT','','required',array('required'=>'<font style="color:red;font-size:15px">La fonction est obligatoire</font>'));
        $this->form_validation->set_rules('PROFIL_ID','','required',array('required'=>'<font style="font-size:15px;">*Veuillez entrer le profile de l\'utilisateur</font>'));
        $this->form_validation->set_rules('TELEPHONE1','','required|is_unique[admin_users.USER_TELEPHONE]|min_length[8]',array('required'=>'<font style="font-size:15px;">*Veuillez entrer le numéro de téléphone</font>','is_unique'=>'<font style="font-size:15px;">*Le téléphone existe déjà','min_length'=>'<font style="font-size:15px;">*Le téléphone doit contenir au minimum 8 chiffres</front>'));
        // $this->form_validation->set_rules('TELEPHONE2','','required|is_unique[admin_users.TELEPHONE2]|min_length[8]',array('required'=>'<font style="font-size:15px;">*Veuillez entrer le numéro de téléphone</font>','is_unique'=>'<font style="font-size:15px;">*Le téléphone existe déjà','min_length'=>'<font style="font-size:15px;">*Le téléphone doit contenir au minimum 8 chiffres</front>'));
        $this->form_validation->set_rules('EMAIL','','required|valid_email|is_unique[admin_users.USER_EMAIL]',array('required'=>'<font style="font-size:15px;">*Veuillez entrer un email</font>','valid_email'=>'<font style="font-size:15px;">*L\'addresse email doit contenir @</font>','is_unique'=>'<font style="font-size:15px;">*L\'addresse existe déjà</font>'));
         
       
        if ($this->form_validation->run()==FALSE) 
        {
          $data['USERNAME']=$this->input->post('NOM');
          // $data['PRENOM']=$this->input->post('PRENOM');
          $data['restaurants']=$this->Model->getList('restaurants');
          $data['admin_profil']=$this->Model->getList('admin_profil');

          $data['USER_TELEPHONE']=$this->input->post('TELEPHONE1');
          // $data['TELEPHONE2']=$this->input->post('TELEPHONE2');
          $data['USER_EMAIL']=$this->input->post('EMAIL');
          $data['title']='ENREGISTRER L\'UTILISATEUR';
          $this->load->view('Admin_User_Add_View',$data);
          
        }
        else
        {
          $table='admin_users';

          $pwd=$this->input->post('TELEPHONE1');
          $data= array('USERNAME' =>$this->input->post('NOM')." ".$this->input->post('PRENOM'),
                       'ID_RESTAURANT'=>$this->input->post('ID_RESTAURANT'),
                       'PROFILE_ID'=>$this->input->post('PROFIL_ID'),
                       'USER_TELEPHONE'=> !empty($this->input->post('TELEPHONE1')) ? $this->input->post('TELEPHONE1'):$this->input->post('TELEPHONE1'),
                       'USER_EMAIL'=>$this->input->post('EMAIL'),
                       'IS_ACTIVE'=>1,
                       'USER_PASSWORD'=>md5($pwd)
                       );
          
          $creation=$this->Model->create($table,$data);
          if ($creation)
          {
            $data['message']='<div class="alert alert-success text-center" id="message">L\'enregistrement de l\'utilisateur avec succès'.$this->input->post('NOM').'</div>';
            $this->session->set_flashdata($data);
          }
          else
          {
             $data['message']='<div class="alert alert-success text-center" id="message">L\'enregistrement de l\'utilisateur a echoué</div>';
             $this->session->set_flashdata($data);

          }
          $email_utilisateur=$this->input->post('EMAIL');


          $message="Monsieur/Madame ".$this->input->post('NOM')." ".$this->input->post('PRENOM')."<br> Vos identifiant de connexion sur la plateform Wasili-Eat sont crée avec succès <a href='".base_url()."'>connectez-vous ici  :<br><br>";
          $message.="<b>Username : ".$email_utilisateur."</b><br>
          <b>Mot de passe : ".$pwd."</b><br>";

          $this->notifications->send_mail($email_utilisateur,'Wasili-Eat',NULL,$message,NULL);

          redirect(base_url('administration/Admin_User/listing')); 
          
          
        }
      }


      public function listing()
      {
        $tabledata=array();
        $list=$this->Model->getList('utilisateurs');
        foreach ($list as $user) 
        {
          // $profil=$this->Model->getOne('admin_profil',array('PROFIL_ID'=>$user['PROFILE_ID']));
          // $resto=$this->Model->getOne('restaurants',array('ID_RESTAURANT'=>$user['ID_RESTAURANT']));
          $utilisateur=array();
          $utilisateur[]=$user['USERNAME'];
          $utilisateur[]=$user['USERPASSWORD_TELEPHONE'];
          $utilisateur[]=$user['ID_PROFIL'];
          // $utilisateur[]= $this->get_icon($user['IS_ACTIVE']);
          $utilisateur[]=$user['DATE_INSERTION'];
         
          $utilisateur['OPTIONS'] = '<div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Action
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-left">
                        ';
     
          $utilisateur['OPTIONS'] .= "<li><a hre='#' data-toggle='modal' 
                                  data-target='#mydelete" . $user['ID_UTILISATEUR '] . "'><font color='red'>Supprimer</font></a></li>";
          $utilisateur['OPTIONS'] .= "<li><a class='btn-md' href='" . base_url('administration/Admin_User/editer/'. $user['ID_UTILISATEUR ']) . "'>Modifier</a></li>";
          $utilisateur['OPTIONS'] .= " </ul>
                  </div>
                    <div class='modal fade' id='mydelete" . $user['ID_UTILISATEUR '] . "'>
                  <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <center><p>VOULEZ-VOUS SUPPRIMER UTILISATEUR : <b>" . $user['USERNAME']."</b>?</p></center>
                                                </div>

                                               <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('administration/Admin_User/delete/'. $user['ID_UTILISATEUR ']) . "'>Supprimer</a>
                                                    <button class='btn btn-warning btn-md' data-dismiss='modal'>Quitter</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div></form>";
              $tabledata[]=$utilisateur;

        }
        $template=array(
                    'table_open' => '<table id="user_list" class="table table-bordered table-stripped table-hover table-condensed">',
                    'table_close' => '</table>'
                );
        $this->table->set_template($template);
        $this->table->set_heading(array('NOM','PROFIL','UTILISATEUR DE','TELEPHONE','EMAIL','ACTIF','DATE_ACTIVATION','OPTIONS')); //NOM,PRENOM ,ID_RESTAURANT,PROFIL_ID,TELEPHONE1,TELEPHONE2,DATE_ACTIVATION,DATE_INSERTION,EMAIL,PASSWORD;
        $data['liste']=$tabledata;
        $data['title']='LISTE DES UTILISATEURS';
        $this->load->view('Admin_User_List_View',$data);
      }



    function get_icon($statut)
    {
      $html = ($statut == 1) ? '<a class = "btn btn-success btn-sm " style="float:right" ><span class = "fa fa-check" ></span></a>' : '<a class = "btn btn-danger btn-sm" style="float:right"><span class = "fa fa-ban" ></span></a>' ;
      return $html;
    }
  
      public function editer()
      {
        $ID_UTILISATEUR =$this->uri->segment(4);
        $listone=$this->Model->getOne('admin_users',array('ID_UTILISATEUR '=>$ID_UTILISATEUR ));
        $listone['user']=$listone;
        $listone['title']='MODIFIER L\'UTILISATEUR';
        $listone['profiles']=$this->Model->getList('admin_profil');
        $listone['restaurants']=$this->Model->getList('restaurants');
        $this->load->view('Admin_User_Update_View',$listone);
      }
      public function update()
      {
        $this->form_validation->set_rules('NOM','','trim|required',array('required'=>'<font style="font-size:15px;">*Veuillez entrer le nom  de l\'utilisateur</font>'));
       
         $this->form_validation->set_rules('ID_RESTAURANT','','required',array('required'=>'<font style="color:red;font-size:15px">La fonction est obligatoire</font>'));

         $this->form_validation->set_rules('PROFIL_ID','','required',array('required'=>'<font style="font-size:15px;">*Veuillez entrer le profile de l\'utilisateur</font>'));

         $this->form_validation->set_rules('TELEPHONE1','','required|min_length[8]',array('required'=>'<font style="font-size:15px;">*Veuillez entrer le nom du restaurant</font>','is_unique'=>'<font style="font-size:15px;">* Le numéro téléphone existe déjà</font>','min_length'=>'<font style="font-size:15px;">*doit contenir au minimum 8 chiffres</font>')); 

         // $this->form_validation->set_rules('TELEPHONE2','','required|min_length[8]',array('required'=>'<font style="font-size:15px;">*Veuillez entrer le nom du restaurant</font>','is_unique'=>'<font style="font-size:15px;">* Le numéro téléphone existe déjà</font>','min_length'=>'<font style="font-size:15px;">*doit contenir au minimum 8 chiffres</font>'));
         // $this->form_validation->set_rules('DATE_ACTIVATION','','trim|required',array('required'=>'<font style="font-size:15px;">*Veuillez entrer la date d\'activation de l\'utilisateur</font>'));
             // $this->form_validation->set_rules('DATE_INSERTION','','trim|required',array('required'=>'<font style="font-size:15px;">*Veuillez entrer la date d\'insertion de l\'utilisateur</font>'));
         $this->form_validation->set_rules('EMAIL','','required|valid_email',array('required'=>'<font style="font-size:15px;">*Veuillez entrer un email</font>','valid_email'=>'<font style="font-size:15px;">*L\'addresse email doit contenir @</font>'));
         // $this->form_validation->set_rules('PASSWORD','','trim|required',array('required'=>'<font style="font-size:15px;">*Veuillez entrer le mot de passe de l\'utilisateur</font>'));
                
       
        if ($this->form_validation->run()==0)
        {
           $ID_UTILISATEUR =$this->input->post('ID_UTILISATEUR ');
           $data['USERNAME']=$this->input->post('NOM').' '.$this->input->post('PRENOM');
           $data['restaurants']=$this->Model->getList('restaurants');
           $data['profiles']=$this->Model->getList('admin_profil');
           $data['USER_TELEPHONE']=!empty($this->input->post('TELEPHONE1')) ? $this->input->post('TELEPHONE1') : $this->input->post('TELEPHONE2');
           //$data['TELEPHONE2']=$this->input->post('TELEPHONE2');
           $data['USER_EMAIL']=$this->input->post('EMAIL');
           $data['PASSWORD']=$this->input->post('PASSWORD');
         
          
          $listone=$this->Model->getOne('admin_users',array('ID_UTILISATEUR '=>$ID_UTILISATEUR ));
          $data['user']=$listone;
          $data['title']='MODIFIER L\'UTILISATEUR';
          $data['restaurants']=$this->Model->getList('restaurants');
          $data['admin_profil']=$this->Model->getList('admin_profil');;
          $this->load->view('Admin_User_Update_View',$data); 
        }
        else
         {
          $table='admin_users';
          $ID_UTILISATEUR =$this->input->post('ID_UTILISATEUR ');

          $datas = array('USERNAME' =>$this->input->post('NOM')." ".$this->input->post('PRENOM'),
                         'ID_RESTAURANT'=>$this->input->post('ID_RESTAURANT'),
                         'PROFILE_ID'=>$this->input->post('PROFIL_ID'),
                         'USER_TELEPHONE'=> !empty($this->input->post('TELEPHONE1')) ? $this->input->post('TELEPHONE1') : $this->input->post('TELEPHONE1'),
                         'IS_ACTIVE'=> $this->input->post('IS_ACTIVE'),
                         'USER_EMAIL'=>$this->input->post('EMAIL')
                       );


          $Update_user=$this->Model->update($table,array('ID_UTILISATEUR '=>$ID_UTILISATEUR ),$datas);
          if ($Update_user) 
          {
            $data['message']='<div class="alert alert-success text-center " id="message">La modification d\'un utilisateur a été bien faite avec succès'.' '.$this->input->post('NOM').'</div>';
            $this->session->set_flashdata($data);
            redirect(base_url('administration/Admin_User/listing'));
          }
          else
          {
            $data['message']='<div class="alert alert-success text-center " id="message">La modification d\'un utilisateur a échouée</div>';
            $this->session->set_flashdata($data);
            redirect(base_url('administration/Admin_User/listing'));

          }
          

        }
      }

      public function delete()
      {
        $ID_UTILISATEUR =$this->uri->segment(4);
        $delete=$this->Model->delete('admin_users',array('ID_UTILISATEUR '=>$ID_UTILISATEUR ));
        if ($delete)
        {
          $data['message']='<div class="alert alert-success text-center" id="message">La suppression a été faite avec succès</div>';
          $this->session->set_flashdata($data);
          redirect(base_url('administration/Admin_User/listing'));
        }
        else
        {
          $data['message']='<div class="alert alert-success text-center" id="message">La suppression a échouée</div>';
          $this->session->set_flashdata($data);
          redirect(base_url('administration/Admin_User/listing'));

        }
        
      }
  

}
