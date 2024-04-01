<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function create($table,$data){
    $sql=$this->db->insert($table,$data);
    return $sql ;
  }

  public function Add_data($table,$data){
		$sql=$this->db->insert($table,$data);
		return $sql ;
	}

	public function getList($table){
		$sql=$this->db->get($table) ;
		return $sql->result_array() ;
	}

	public function getOne($table,$where){
		$this->db->where($where) ;
		$sql=$this->db->get($table) ;
		return $sql->row_array() ;
	}

	public function deleteData($table,$where){
      $this->db->where($where);
      $sql=$this->db->delete($table) ;
      return $sql;
	}

	public function updateData($table,$data,$where){
		$this->db->where($where) ;
		$sql=$this->db->update($table,$data) ;
		return $sql;
	}


      function getListOrder($table,$criteres)
    {
        $this->db->order_by($criteres);
      $query= $this->db->get($table);
      if($query)
      {
          return $query->result_array();
      }
    }



	public function sql_one_query($query){
   	$sql=$this->db->query($query);
   	return $sql->row_array();
   }
   public function sql_all_query($query){
   	$sql=$this->db->query($query);
   	return $sql->result_array();
   }

   function insert_last_id($table, $data) {

        $query = $this->db->insert($table, $data);

       if ($query) {
            return $this->db->insert_id();
        }

    }

    public function maker($requete)//make query
    {
      return $this->db->query($requete);
    }

    public function datatable($requete)//make_datatables : requete avec LIMIT start,length
    {
        $query =$this->maker($requete);//call function make query
        return $query->result();
    }

    public function all_data($requete)//count_all_data : requete sans Condition sans LIMIT start,length
    {
       $query =$this->maker($requete); //call function make query
       return $query->num_rows();
    }
     public function filtrer($requete)//get_filtered_data : requete avec Condition sans LIMIT start,length
    {
         $query =$this->maker($requete);//call function make query
        return $query->num_rows();

    }

      function getRequete($requete){
       $query=$this->db->query($requete);
       if ($query) {
          return $query->result_array();
       }
     }

     function getRequete_object($requete){
       $query=$this->db->query($requete);
       if ($query) {
          return $query->result();
       }
     }

     // public function update($table,$data,$where){
     //   $this->db->where($where) ;
     //   $sql=$this->db->update($table,$data) ;
     //   return $sql;
     // }

     function update($table, $criteres, $data) {
        $this->db->where($criteres);
        $query = $this->db->update($table, $data);
        return ($query) ? true : false;
    }

     public function delete($table,$where){
         $this->db->where($where);
         $sql=$this->db->delete($table) ;
         return $sql;
     }

      function getRequeteOne($requete){
       $query=$this->db->query($requete);
       if ($query) {
          return $query->row_array();
       }
     }

     public function get_permission($url)
     {
       //  echo $this->session->userdata('INFINITY_POSTE_ID');
         $this->db->select('af.*');
         $this->db->from('admin_fonctionnalites af');
         $this->db->join('admin_profil_fonctionnalites afp','afp.FONCTIONNALITE_ID = af.FONCTIONNALITE_ID');
         $this->db->where('af.FONCTIONNALITE_URL',$url);
         $this->db->where('afp.PROFIL_ID',$this->session->userdata('iccm_PROFIL_ID'));

         $query = $this->db->get();
       //  echo $this->db->last_query();
         if($query){
             return $query->row_array();
         }
     }


}
