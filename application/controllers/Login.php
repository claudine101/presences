<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index($params = NULL)
  {

    if (!empty($this->session->userdata('USERNAME'))) {
      redirect(base_url('administration/Utilisateurs/index'));
    } else {
      $datas['message'] = $params;
      $this->load->view('Login_View.php', $datas);
    }
  }



  public function do_login()
  {

    $login = $this->input->post('USERNAME');
    $PASSWORD = $this->input->post('PASSWORD');

    $criteresmail['USERNAME'] = $login;
    $criteresmail['PASSWORD'] = $PASSWORD;

    $user = $this->Model->getRequeteOne('SELECT * FROM utilisateurs WHERE  USERNAME="' . $login . '"');

    // $droit = $this->Model->getRequeteOne('SELECT *  FROM droits WHERE ID_PROFIL="' . $user['ID_PROFIL'] . '" ');

    $message = "";
    if (!empty($user)) {
      if ($user['PASSWORD'] == md5($PASSWORD)) {
        $session = array(
          'ID_UTILISATEUR' => $user['ID_UTILISATEUR'],
          'USERNAME' => $user['USERNAME'],
          'ID_PROFIL' => $user['ID_PROFIL']
        );

        $this->session->set_userdata($session);
        redirect(base_url('administration/Utilisateurs/index'));
        
      } else
        $message .= "<center><span  id='erro_msg' style='color:red;font-size:12px'> Le nom d'utilisateur ou/et mot de passe incorect(s) !</span></center>";
    } else
      $message .= "<center><span id='erro_msg' style='color:red;font-size:12px'>L'utilisateur n'existe pas/plus dans notre système informatique !</span></center>";
    $this->index($message);
  }

  public function do_logout()

  {

     $session = array(
         'ID_UTILISATEUR' => NULL,
          'USERNAME' => NULL,
          'ID_PROFIL' => NULL,
          'INFRACTION' => NULL,
          'PSR_ELEMENT' => NULL,
          'PEINES' => NULL,
          'AFFECTATION' => NULL,
          'PERMIS' => NULL,
          'DECLARATION' => NULL,
          'IMMATRICULATION' => NULL,
          'CONTROLE_TECHNIQUE' => NULL,
          'ASSURANCE' => NULL,
          'QUESTIONNAIRE' => NULL,
          'SIGNALEMENT' => NULL,
          'VALIDATEUR' => NULL,         
          'POLICE_JUDICIAIRE' => NULL,
          'TRANSPORT' => NULL,
          'PARAMETRE' =>NULL,
          'TB_PJ' => NULL,
          'TB_ASSURANCE' => NULL,
          'TB_IMMATRICULATION' =>  NULL,
          'TB_PERMIS' => NULL,
          'TB_CONTROLE_TECHNIQUE' => NULL,
          'TB_FINANCIER' => NULL,
          'TB_AMANDE' => NULL,
          'TB_POLICE' => NULL,
          'TB_SIGNALMENT' => NULL,
          'TB_CONSTANT' => NULL,
          'TB_CONTROLE_RAPIDE' => NULL,
          'TB_AUTRE_CONTROLE' => NULL,
          'MAP_CENTRE_SITUATION' => NULL,
          'MAP_AGENT_POLICE' => NULL,
          'MAP_SIGNALEMENT' => NULL,
          'CONFIGURATION_DATA' => NULL,
          'IHM' => NULL,
          'RH_FONCTIONNAIRE' => NULL,
          'RH_POSTE' => NULL,
          'RH_AFFECTATION' => NULL,
          'VERIFICATION' => NULL,
          'SIGNALEMENT' => NULL,
          'CONSTANT_SUR_CONTROLE' => NULL,
          'FOURRIERE' => NULL,
          'CHEF_MENAGE'=>NULL,
          'GESTION_CHEF_MENAGE'=>NULL
        );

    $this->session->set_userdata($session);
    redirect(base_url('index.php/Login'));
  }
}
