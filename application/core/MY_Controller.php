<?php

class MY_Controller extends CI_Controller {

   public function __construct()
   {
   	parent::__construct();
   	//$this->load->library('pagination');
   }

   public function layout($data=array())
   {
      $this->data = $data;
      $this->template['header'] = $this->load->view('templates/header',$this->data,TRUE);
      $this->template['footer'] = $this->load->view('templates/footer',$this->data,TRUE);
      $this->template['page'] = $this->load->view($this->page,$this->data,TRUE);

      $this->load->view('templates/sidebar',$this->template);
   }

   public function layout_rapport($data=array())
   {
      $this->data = $data;
      $this->template['header'] = $this->load->view('templates/header',$this->data,TRUE);
      $this->template['footer'] = $this->load->view('template_repport/footer',$this->data,TRUE);
      $this->template['page'] = $this->load->view($this->page,$this->data,TRUE);

      $this->load->view('template_repport/sidebar',$this->template);
   }

}
