<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modele extends CI_Model{

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

  public function getList($table,$condition = array()){
    if(!empty($condition)){
      $this->db->where($condition);
    }
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
function insert_batch($table,$data){

    $query=$this->db->insert_batch($table, $data);
    return ($query) ? true : false;
    //return ($query)? true:false;

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

    public function datatable($requete)//make_datatables : requete avec Condition,LIMIT start,length
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


        function getRequete1($requete){
         $query=$this->db->query($requete);
        //  if ($query) {
        //   return $query->result_array();
        // }
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





    ///edmond gica11
 public function make_datatables_intra_now($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
 {
  $this->make_query_intra_now($table,$select_column,$critere_txt,$critere_array,$order_by);
  if($_POST['length'] != -1){
   $this->db->limit($_POST["length"],$_POST["start"]);
 }
 $query = $this->db->get();
 return $query->result();
}

public function make_query_intra_now($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
{
  $this->db->select($select_column);
  $this->db->from($table);
  $this->db->join('stock_intervenat', 'stock_intervenat.STOCK_INTERVENANT_ID='.$table.'.INTRANT_MEDICAUX_ID','left');
  $this->db->join('intervenants_structure', 'intervenants_structure.INTERVENANT_STRUCTURE_ID=stock_intervenat.INTERVENANT_STRUCTURE_ID','left');

  if($critere_txt != NULL){
    $this->db->where($critere_txt);
  }
  if(!empty($critere_array))
    $this->db->where($critere_array);

  if(!empty($order_by)){
    $key = key($order_by);
    $this->db->order_by($key,$order_by[$key]);
  }

}
public function count_all_data_intra_now($table,$critere = array(),$critere_txt=NULL)
{
 $this->db->select('*');

 $this->db->where($critere);
 if($critere_txt != NULL)
   $this->db->where($critere);
 $this->db->from($table);
 $this->db->join('stock_intervenat', 'stock_intervenat.STOCK_INTERVENANT_ID='.$table.'.INTRANT_MEDICAUX_ID','left');
 $this->db->join('intervenants_structure', 'intervenants_structure.INTERVENANT_STRUCTURE_ID=stock_intervenat.INTERVENANT_STRUCTURE_ID','left');


 return $this->db->count_all_results();
}
public function get_filtered_data_intra_now($table,$select_column,$critere_txt,$critere_array,$order_by)
{
  $this->make_query_intra_now($table,$select_column,$critere_txt,$critere_array,$order_by);
  $query = $this->db->get();
  return $query->num_rows();

}
//pacy
public function mois($moi=0){
            $moislettre='';
            if($moi==1)
                $moislettre='Janvier';
            if($moi==2)
                $moislettre='Février';
            if($moi==3)
                $moislettre='Mars';
            if($moi==4)
                $moislettre='Avril';
            if($moi==5)
                $moislettre='Mai';
            if($moi==6)
                $moislettre='Juin';
            if($moi==7)
                $moislettre='Juillet';
            if($moi==8)
                $moislettre='Août';
            if($moi==9)
                $moislettre='Septembre';
            if($moi==10)
                $moislettre='Octobre';
            if($moi==11)
                $moislettre='Novembre';
            if($moi==12)
                $moislettre='Décembre';

            return $moislettre;
        }




        ///edmond gica11
 public function make_datatables_intra_dash($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
 {
  $this->make_query_intra_dash($table,$select_column,$critere_txt,$critere_array,$order_by);
  if($_POST['length'] != -1){
   $this->db->limit($_POST["length"],$_POST["start"]);
 }
 $query = $this->db->get();
 return $query->result();
}

public function make_query_intra_dash($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
{
  $this->db->select($select_column);
  $this->db->from($table);
  $this->db->join('stock_distribution_intrant_detail', 'stock_distribution_intrant_detail.INTRANT_ID='.$table.'.INTRANT_MEDICAUX_ID','left');
  $this->db->join('stock_distribution', 'stock_distribution.DISTRIBUTION_ID=stock_distribution_intrant_detail.DISTRIBUTION_ID','left');
  $this->db->join('stock_demande', 'stock_demande.DEMANDE_ID=stock_distribution.DEMANDE_ID','left');

  if($critere_txt != NULL){
    $this->db->where($critere_txt);
  }
  if(!empty($critere_array))
    $this->db->where($critere_array);

  if(!empty($order_by)){
    $key = key($order_by);
    $this->db->order_by($key,$order_by[$key]);
  }

}
public function count_all_data_intra_dash($table,$critere = array(),$critere_txt=NULL)
{
 $this->db->select('*');

 $this->db->where($critere);
 if($critere_txt != NULL)
   $this->db->where($critere);
 $this->db->from($table);
 $this->db->join('stock_distribution_intrant_detail', 'stock_distribution_intrant_detail.INTRANT_ID='.$table.'.INTRANT_MEDICAUX_ID','left');
  $this->db->join('stock_distribution', 'stock_distribution.DISTRIBUTION_ID=stock_distribution_intrant_detail.DISTRIBUTION_ID','left');
  $this->db->join('stock_demande', 'stock_demande.DEMANDE_ID=stock_distribution.DEMANDE_ID','left');


 return $this->db->count_all_results();
}
public function get_filtered_data_intra_dash($table,$select_column,$critere_txt,$critere_array,$order_by)
{
  $this->make_query_intra_dash($table,$select_column,$critere_txt,$critere_array,$order_by);
  $query = $this->db->get();
  return $query->num_rows();

}

///edmond gica11
 public function make_datatables_intra_anfin($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
 {
  $this->make_query_intra_anfin($table,$select_column,$critere_txt,$critere_array,$order_by);
  if($_POST['length'] != -1){
   $this->db->limit($_POST["length"],$_POST["start"]);
 }
 $query = $this->db->get();
 return $query->result();
}

public function make_query_intra_anfin($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
{
  $this->db->select($select_column);
  $this->db->from($table);
  $this->db->join('stock_demande_detail', 'stock_demande_detail.INTRANT_ID='.$table.'.INTRANT_MEDICAUX_ID','left');
  $this->db->join('stock_demande', 'stock_demande.DEMANDE_ID=stock_demande_detail.DEMANDE_ID','left');

  if($critere_txt != NULL){
    $this->db->where($critere_txt);
  }
  if(!empty($critere_array))
    $this->db->where($critere_array);

  if(!empty($order_by)){
    $key = key($order_by);
    $this->db->order_by($key,$order_by[$key]);
  }

}
public function count_all_data_intra_anfin($table,$critere = array(),$critere_txt=NULL)
{
 $this->db->select('*');

 $this->db->where($critere);
 if($critere_txt != NULL)
   $this->db->where($critere);
 $this->db->from($table);
 $this->db->join('stock_demande_detail', 'stock_demande_detail.INTRANT_ID='.$table.'.INTRANT_MEDICAUX_ID','left');
  $this->db->join('stock_demande', 'stock_demande.DEMANDE_ID=stock_demande_detail.DEMANDE_ID','left');


 return $this->db->count_all_results();
}
public function get_filtered_data_intra_anfin($table,$select_column,$critere_txt,$critere_array,$order_by)
{
  $this->make_query_intra_anfin($table,$select_column,$critere_txt,$critere_array,$order_by);
  $query = $this->db->get();
  return $query->num_rows();

}

}
