<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends CI_Model{


 public function datatable($requete)//make_datatables : requete avec Condition,LIMIT start,length
    { 
        $query =$this->maker($requete);//call function make query
        return $query->result();
    }  
    public function maker($requete)//make query
    {
      return $this->db->query($requete);
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




  function create($table, $data) {

        $query = $this->db->insert($table, $data);
        return ($query) ? true : false;

  }

public function getRequeAutre($query){
    $sql=$this->db->query($query);
    return ($query) ? true : false;
   }


 function vider($requete){
      $query=$this->db->query($requete);
      return $query;
    }
 public function all_query($query){
    $sql=$this->db->query($query);
    return $sql->result_array();
   }



   public function insertData($table,$data){
        $sql=$this->db->insert($table,$data);
        return $sql ;
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



  //Modele fafa


 //marche
   public function count_all_data_releve_province($table,$critere =NULL)
    {
       $this->db->select('*');
       $this->db->where($critere);
       $this->db->from($table);
      // $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','left');
       // $this->db->join('enqueteurs', 'enqueteurs.ENQUETEUR_ID='.$table.'.ENQUETEUR_ID','left');
        
       return $this->db->count_all_results();   
    }
    public function get_filtered_data_releve_province($table,$select_column,$critere_txt,$critere_array,$order_by)
    {
        $this->make_query_releve_province($table,$select_column,$critere_txt,$critere_array,$order_by);
        $query = $this->db->get();
        return $query->num_rows();
        
    }
    // public function make_datatables_releve_province($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
    // {


    //     $this->make_query_releve_province($table,$select_column,$critere_txt,$critere_array,$order_by);
    //     if($_POST['length'] != -1){
    //        $this->db->limit($_POST["length"],$_POST["start"]);
    //     }
    //     $query = $this->db->get();
    //     return $query->result();
    // }
     public function make_query_releve_province($table,$select_column=array(),$critere_txt = NULL,$critere_array=NULL,$order_by=array())
    {
        $this->db->select($select_column);
        $this->db->from($table);
       // $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','left');
       // $this->db->join('enqueteurs', 'enqueteurs.ENQUETEUR_ID='.$table.'.ENQUETEUR_ID','left');
        
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















    public function make_query_bonfis($table_principale,$table_jointures_text = '',$table_jointures_etrangeres_text = '',$cles_etrangeres_text = '',$cles_t_etrangeres_text = '',$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
{

  $this->db->select($select_column);

  $this->db->from($table_principale);

  if ($table_jointures_text != '') {

    $t_jointures = explode(',', $table_jointures_text);
    $c_etrangeres = explode(',', $cles_etrangeres_text);
    $nbr_tables = count($t_jointures);

    for ($i=0; $i < $nbr_tables; $i++) { 
      $this->db->join($t_jointures[$i],$t_jointures[$i].'.'.$c_etrangeres[$i].' = '.$table_principale.'.'.$c_etrangeres[$i],'left');
    }
  }

  if ($table_jointures_etrangeres_text != '') { //Vérifier si il y en a des tables étrangères 

    $t_etrangeres_jointures = explode(',', $table_jointures_etrangeres_text);
    $c_t_etrangeres = explode(',', $cles_t_etrangeres_text);
    $nbr_tables_etrangeres = count($t_etrangeres_jointures);
    if ($nbr_tables_etrangeres == 2) {
      $this->db->join($t_etrangeres_jointures[0],$t_etrangeres_jointures[0].'.'.$c_t_etrangeres[0].' = '.$t_etrangeres_jointures[1].'.'.$c_t_etrangeres[1]);
    }
    if ($nbr_tables_etrangeres == 4) {
      $this->db->join($t_etrangeres_jointures[0],$t_etrangeres_jointures[0].'.'.$c_t_etrangeres[0].' = '.$t_etrangeres_jointures[1].'.'.$c_t_etrangeres[1]);
      $this->db->join($t_etrangeres_jointures[2],$t_etrangeres_jointures[2].'.'.$c_t_etrangeres[2].' = '.$t_etrangeres_jointures[3].'.'.$c_t_etrangeres[3]);
    }
    # code...
  }

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


  public function make_datatables_bonfis($table_principale,$table_jointures_text = '',$table_jointures_etrangeres_text = '',$cles_etrangeres_text = '',$cles_t_etrangeres_text = '',$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
  {
    $this->make_query_bonfis($table_principale,$table_jointures_text,$table_jointures_etrangeres_text,$cles_etrangeres_text,$cles_t_etrangeres_text,$select_column,$critere_txt,$critere_array,$order_by);
    if($_POST['length'] != -1){
      $this->db->limit($_POST["length"],$_POST["start"]);
    }
    $query = $this->db->get();
    return $query->result();
  }

  public function count_all_data_bonfis($table,$critere = array())
  {
    $this->db->select('*');
    $this->db->where($critere);
    $this->db->from($table);
    return $this->db->count_all_results();   
  }


  public function get_filtered_data_bonfis($table_principale,$table_jointures_text = '',$table_jointures_etrangeres_text = '',$cles_etrangeres_text = '',$cles_t_etrangeres_text = '',$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
  {
    $this->make_query_bonfis($table_principale,$table_jointures_text,$table_jointures_etrangeres_text,$cles_etrangeres_text,$cles_t_etrangeres_text,$select_column,$critere_txt,$critere_array,$order_by);
    $query = $this->db->get();
    return $query->num_rows(); 
  }












   
    function insert_batch($table,$data){
      
    $query=$this->db->insert_batch($table, $data);
    return ($query) ? true : false;
    //return ($query)? true:false;

    }
    function getListLimitold($table,$limit)
    {
     $this->db->limit($limit);
     $query= $this->db->get($table);
     
      if($query)
       {
           return $query->result_array();
       }   
    }

    function getListLimi($table,$limit,$cond=array())
    {
     $this->db->limit($limit);
     $this->db->where($cond);
     $query= $this->db->get($table);
     
      if($query)
       {
           return $query->result_array();
       }   
    }

    function getListLimitwhere($table,$criteres = array(),$limit = NULL)
    {
      $this->db->limit($limit);
      $this->db->where($criteres);
     $query= $this->db->get($table);
     
      if($query)
       {
           return $query->result_array();
       }   
    }

  

    function getList_distinct($table,$distinct_champ='',$criteres=array()) {
        $this->db->select($distinct_champ);
        $this->db->where($criteres);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function getList_distinct2($table,$distinct=array(),$criteres=array()) {
      $this->db->where($criteres);
        $this->db->select($distinct);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function getList_between($table,$critere=array(),$criteres=array()){
        $this->db->where('NBRE_PIECES_PRINCIPALES >=', $critere);
$this->db->where('NBRE_PIECES_PRINCIPALES <=', $criteres);
return $this->db->get($table);
    }

  function update($table, $criteres, $data) {
        $this->db->where($criteres);
        $query = $this->db->update($table, $data);
        return ($query) ? true : false;
    }
    function update_batch($table, $criteres, $data) {
        $this->db->where($criteres);
        $query = $this->db->update_batch($table, $data);
        return ($query) ? true : false;
    }
  function update_table($table, $criteres, $data) {
        foreach ($data as $key => $value) {
          $this->db->set($key,$value);
        }
        $this->db->where($criteres);
        $query = $this->db->update($table);
        return ($query) ? true : false;
    }  

    function insert_last_id($table, $data) {

        $query = $this->db->insert($table, $data);
       
       if ($query) {
            return $this->db->insert_id();
        }

    }

    // public function getOneOrder($table,$array= array(),$order_champ,$order_value = 'DESC')
    //    {
    //      $this->db->where($array);
    //      $this->db->order_by($order_champ,$order_value);

    //      $query = $this->db->get($table);

    //      if($query){
    //       return $query->row_array();
    //      }
    //    }   


    function getList($table,$criteres = array()) {
        $this->db->where($criteres);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function getListTime($table,$criteres = array(),$time = NULL) {
        $this->db->where($criteres);
        $this->db->where($time);
        $query = $this->db->get($table);
        return $query->result_array();
    }


    // function getListOrdertwo($table,$criteres = array(),$order) {
    //     $this->db->order_by($order,'ASC');
    //     $this->db->where($criteres);
        
    //     $query = $this->db->get($table);
    //     return $query->result_array();
    // }


    function checkvalue($table, $criteres) {
        $this->db->where($criteres);
        $query = $this->db->get($table);
        if($query->num_rows() > 0)
        {
           return true ;
        }
        else{
    return false;
    }
    }



    function getOne($table, $criteres) {
        $this->db->where($criteres);
        $query = $this->db->get($table);
        return $query->row_array();
    }
    function getOneSearch($table, $criteres) {
        $this->db->like($criteres);
        $query = $this->db->get($table);
        return $query->row_array();
    }
    function getOneSearch1($table, $criteres) {
        $this->db->like($criteres);
        $query = $this->db->get($table);
        return $query->row_array();
    }

   function delete($table,$criteres){
        $this->db->where($criteres);
        $query = $this->db->delete($table);
        return ($query) ? true : false;
    }



    function record_count($table)
    {
       $query= $this->db->get($table);
       if($query)
       {
           return $query->num_rows();
       }
       
    }


    function record_countsome($table, $criteres)
    {
      $this->db->where($criteres);
       $query= $this->db->get($table);
       if($query)
       {
           return $query->num_rows();
       }
       
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


    
  



     function fetch_table($table,$limit,$start,$order,$ordervalue)
    {
     $this->db->limit($limit,$start);
     $this->db->order_by($order,$ordervalue);
     $query= $this->db->get($table);
     
      if($query)
       {
           return $query->result_array();
       }   
    }




        function getToutList($requete) {
        //$this->db->where($criteres);
       $query = $this->db->query($requete);
       $result=$query->result_array();
        return $result;
    }
    
    function checkvalue1($table,$champ, $criteres) {
        
        $this->db->where($champ, $criteres);
        $query = $this->db->get($table);

        if ($query) {
            return $query->row_array();
        }
       
    }

    public function Listdelegationpersonnel(){
    $data = array();
    $this->db->select('pd.ID_DELEGATION');
    
    $this->db->from('personnel_delegation pd');

    $this->db->group_by('pd.ID_DELEGATION');
    $query=$this->db->get();
       
    if ($query) {
            return $query->result_array();
        }
    }

    // function ListOrder_personnel($table,$condition= array(),$criteres)
    // {
    //     $this->db->where($condition);
    //     $this->db->order_by($criteres);
    //   $query= $this->db->get($table);
    //   if($query)
    //   {
    //       return $query->result_array();
    //   }
    // }

public function get_elements($criterepieces=array()){

      /* $this->db->select('NOM_ELEMENT');
       
      $this->db->group_by('NOM_ELEMENT');
      $query=$this->db->get($table);
      return $query->result_array()  ;*/
      
  $this->db->select("*");
  $this->db->from('element e');
  $this->db->join('elements_piece ep', 'ep.CODE_ELEMENT = e.CODE_ELEMENT');
   $this->db->where("CODE_PIECE",$criterepieces);
  $query = $this->db->get();
  return $query->result_array();
 
       }
    public function get_ones($table, $champ, $value) {
        $this->db->where($champ, $value);
        $query = $this->db->get($table);
        if ($query) {
            return $query->result_array();
        }
    }

//fonction ghislain
// function getList_distinct_some($table,$distinct=array(), $value) {
//         $this->db->where($value);
//         $this->db->select($distinct);
//         $query = $this->db->get($table);
//         return $query->result_array();
//     }


function fetch_table_new($table,$limit,$start,$order,$ordervalue,$criteres)
    {
     $this->db->where($criteres);
     $this->db->limit($limit,$start);
     $this->db->order_by($order,$ordervalue);
     $query= $this->db->get($table);
     
      if($query)
       {
           return $query->row_array();
       }   
    }

    function findNext($table,$primary_key,$current_id) {
        $sql = "select * from $table where $primary_key = (select min($primary_key) from $table where $primary_key > $current_id)";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    function findPrevious($table,$primary_key,$current_id) {
        $sql = "select * from $table where $primary_key = (select max($primary_key) from $table where $primary_key < $current_id)";
        $query = $this->db->query($sql);
        return $query->row_array();
    }



    //fonction permettant de se connecter
function login($email,$password)
    {
   $this->db->where('EMAIL_PRENEUR',$email);
   $this->db->where('PASSWORD',$password);
   $query=$this->db->get('preneur');

  if($query->num_rows()==1)
   {
      return $query->row();
    }
  else{
      return false;
      }
   }


   function getListOrdered($table,$order=array(),$criteres = array()) {
        $this->db->where($criteres);
        $this->db->order_by($order,"ASC");
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function record_countsome22($table, $criteres=array(),$cond=array())
    {
      $this->db->where($criteres);
      $this->db->where($cond);
       $query= $this->db->get($table);
       if($query)
       {
           return $query->num_rows();
       }
       
    }
    //alain
     function getCond_distinct($table,$distinct=array(),$where=array(),$where2=array()) {
        $this->db->select($distinct);
        $this->db->where($where);
        $this->db->where($where2);
        $query = $this->db->get($table);
        return $query->result_array();
    }
    
    function getsomme($table, $column=array(), $cond=array(),$cond2=array())
    {
       $this->db->select($column);
       $this->db->where($cond);
       $this->db->where($cond2);
       $query = $this->db->get($table);
       return $query->row_array();
    }  

    // function getSommes($table, $criteres = array(),$reste) {
    //     $this->db->select_sum($reste);
    //     $this->db->where($criteres);
    //     $query = $this->db->get($table);
    //     return $query->row_array();
    // }

    // function getListDistinct($table,$criteres = array(),$distinctions) {
    //     $this->db->select("DISTINCT($distinctions)");
    //     $this->db->where($criteres);
    //     $query = $this->db->get($table);
    //     return $query->result_array();
    // }


   function getDate($table, $whereDate,$criteres = array()) {
        $this->db->where($whereDate);
        $this->db->where($criteres);
        $query = $this->db->get($table);
        return $query->result_array();
    }

          function get_somme($sum=array(), $table=array(),$cond=array())
    {
        $this->db->where($cond);
        $this->db->select($sum);
        $query = $this->db->get($table);

        if ($query) {
            return $query->row_array();
        }
    }
    public function ListMinute($idReunion){
    $data = array();

     $this->db->select('titre');
    
    $this->db->from('points_du_jour');
    $this->db->where( array('idReunion'=>$idReunion));

    $this->db->group_by('titre');
    $query=$this->db->get();
       
    if ($query) {
            return $query->result_array();
        }
    }
public function ListMinute1($idReunion){
    $data = array();

     //$this->db->select('idPoint');
      $this->db->distinct('idPoint');

     //$this->db->select('titre');
    
    $this->db->from('points_du_jour');
    $this->db->where( 'idReunion',$idReunion);

   // $this->db->group_by('idPoint');
    $query=$this->db->get();
       
    if ($query) {
            return $query->result_array();
        }
    }



    // function get_sum2($table, $criteres = array(),$reste) {
    //     $this->db->select($reste);
    //     $this->db->where($criteres);
    //     $query = $this->db->get($table);
    //     return $query->row_array();
    // }

    // function getListo($table,$criteres = array(),$order) {
    //     $this->db->where($criteres);
    //     $this->db->order_by($order,'DESC');
    //     $query = $this->db->get($table);
    //     return $query->result_array();
    // }

      function record_countsome222($table, $criteres=array(),$cond=array(),$cond2=array())
    {
      $this->db->where($criteres);
      $this->db->where($cond);
      $this->db->where($cond2);
       $query= $this->db->get($table);
       if($query)
       {
           return $query->num_rows();
       }
    }


   

    // function get_sum22($table, $criteres = array(),$cond2 = array(),$reste) {
    //     $this->db->select($reste);
    //     $this->db->where($criteres);
    //     $this->db->where($cond2);
    //     $query = $this->db->get($table);
    //     return $query->row_array();
    // }
    

// public function make_datatables($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

   public function make_query($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
    {
        $this->db->select($select_column);
        $this->db->from($table);

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
    public function count_all_data($table,$critere = array())
    {
       $this->db->select('*');
       $this->db->where($critere);
       $this->db->from($table);
       return $this->db->count_all_results();   
    }
  public function get_filtered_data($table,$select_column,$critere_txt,$critere_array,$order_by)
    {
        $this->make_query($table,$select_column,$critere_txt,$critere_array,$order_by);
        $query = $this->db->get();
        return $query->num_rows();
        
    }

    public function getListRequest($requete)
    {
      $query=$this->db->query($requete);
      if($query){
         return $query->result_array();
      }
    }

    function getOne_cond($table, $criteres=array(),$cond2=array()) {
        $this->db->where($criteres);
        $this->db->where($cond2);
        $query = $this->db->get($table);
        return $query->row_array();
    }

    function getList_cond($table,$criteres = array(),$cond=array()) {
        $this->db->where($criteres);
        $this->db->where($cond);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function getList_distinct22($table,$distinct=array(),$criteres=array(),$cond2=array()) {
      $this->db->where($criteres);
      $this->db->where($cond2);
        $this->db->select($distinct);
        $query = $this->db->get($table);
        return $query->result_array();
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

     function getRequeteOne($requete){
      $query=$this->db->query($requete);
      if ($query) {
         return $query->row_array();
      }
    }
    function getRequeteCount($requete){
      $query=$this->db->query($requete);
      if ($query) {
         return $query->num_rows();
      }
    }

   

    public  function getMax($table,$champ,$condition=array())
    {
        $this->db->select('MAX('.$champ.')as MAX');
        $this->db->from($table);
        $this->db->where($condition);
         $query = $this->db->get();
        return $query->row_array(); 
    } 

    public function get_Moyenne_age($critere)
    {
      $this->db->select("AVG(DATEDIFF(NOW(),DATE_NAISS)) AS moyenneAge");
      $this->db->from('ACTEURS_MIFA am');
      $this->db->join('GEO_LOCALITES gl','gl.ID_LOCALITE=am.ID_LOCALITE');
      $this->db->join('GEO_CANTONS gc','gl.ID_CANTON=gc.ID_CANTON');
      $this->db->join('GEO_PREFECTURES gp','gp.ID_PREFECTURE=gc.ID_PREFECTURE');
      $this->db->join('GEO_REGIONS gr','gr.ID_REGION=gp.ID_REGION');
      $this->db->where($critere);
      //echo $this->db->last_query();
      $query = $this->db->get(); 

      if($query){
        return $query->row_array();
      }
    }
    public function get_acteurs_grpment($criteres)
    {
      $this->db->select("COUNT(am.ID_ACTEUR) as nbActeur");
      $this->db->from('ACTEURS_MIFA am');
      $this->db->join('GROUPEMENTS_ACTEURS gm','gm.ID_ACTEUR=am.ID_ACTEUR');
      $this->db->join('GROUPEMENTS grm','grm.ID_GROUPEMENT=gm.ID_GROUPEMENT');
      //$this->db->join('GROUPEMENTS_TYPE grty','grty.ID_TYPE=grm.TYPE_GROUPEMENT');
      $this->db->join('GEO_LOCALITES gl','gl.ID_LOCALITE=am.ID_LOCALITE');
      $this->db->join('GEO_CANTONS gc','gl.ID_CANTON=gc.ID_CANTON');
      $this->db->join('GEO_PREFECTURES gp','gp.ID_PREFECTURE=gc.ID_PREFECTURE');
      $this->db->join('GEO_REGIONS gr','gr.ID_REGION=gp.ID_REGION');
      $this->db->where($criteres);
      //$this->db->group_by('grty.DESCR_TYPE');
      $query = $this->db->get();

      if($query){
        return $query->row_array();
      }
    }
    
    public function get_acteurs_profession($criteres)
    {
      $this->db->select("COUNT(am.ID_ACTEUR) as nbActeur,am.PROFESSION");
      $this->db->from('ACTEURS_MIFA am');
      $this->db->join('GEO_LOCALITES gl','gl.ID_LOCALITE=am.ID_LOCALITE');
      $this->db->join('GEO_CANTONS gc','gl.ID_CANTON=gc.ID_CANTON');
      $this->db->join('GEO_PREFECTURES gp','gp.ID_PREFECTURE=gc.ID_PREFECTURE');
      $this->db->join('GEO_REGIONS gr','gr.ID_REGION=gp.ID_REGION');
      $this->db->where($criteres);
      $this->db->group_by('am.PROFESSION');
      $query = $this->db->get();

      if($query){
        return $query->row_array();
      } 
    }

    public function get_acteurs_etude($criteres)
    {
      $this->db->select("COUNT(am.ID_ACTEUR) as nbActeur,am.NIVEAU_INSTRUCTION");
      $this->db->from('ACTEURS_MIFA am');
      $this->db->join('GEO_LOCALITES gl','gl.ID_LOCALITE=am.ID_LOCALITE');
      $this->db->join('GEO_CANTONS gc','gl.ID_CANTON=gc.ID_CANTON');
      $this->db->join('GEO_PREFECTURES gp','gp.ID_PREFECTURE=gc.ID_PREFECTURE');
      $this->db->join('GEO_REGIONS gr','gr.ID_REGION=gp.ID_REGION');
      $this->db->where($criteres);
      $this->db->group_by('am.NIVEAU_INSTRUCTION');
      $query = $this->db->get();

      if($query){
        return $query->row_array();
      } 
    }
    public function get_acteurs_mobile_money($criteres)
    {
      $this->db->select("COUNT(am.ID_ACTEUR) as nbActeur");
      $this->db->from('ACTEURS_MIFA am');
      $this->db->join('MOBILE_MONEY_ACTEUR mma','mma.ID_ACTEUR=am.ID_ACTEUR');
      $this->db->join('GEO_LOCALITES gl','gl.ID_LOCALITE=am.ID_LOCALITE');
      $this->db->join('GEO_CANTONS gc','gl.ID_CANTON=gc.ID_CANTON');
      $this->db->join('GEO_PREFECTURES gp','gp.ID_PREFECTURE=gc.ID_PREFECTURE');
      $this->db->join('GEO_REGIONS gr','gr.ID_REGION=gp.ID_REGION');
      $this->db->where($criteres);
      $query = $this->db->get();

      if($query){
        return $query->row_array();
      }
    }
    public function get_acteurs_operateur($criteres)
    {
      $this->db->select("COUNT(am.ID_ACTEUR) as nbActeur");
      $this->db->from('ACTEURS_MIFA am');
      $this->db->join('GEO_LOCALITES gl','gl.ID_LOCALITE=am.ID_LOCALITE');
      $this->db->join('GEO_CANTONS gc','gl.ID_CANTON=gc.ID_CANTON');
      $this->db->join('GEO_PREFECTURES gp','gp.ID_PREFECTURE=gc.ID_PREFECTURE');
      $this->db->join('GEO_REGIONS gr','gr.ID_REGION=gp.ID_REGION');
      $this->db->where($criteres);
      $query = $this->db->get();

      if($query){
        return $query->row_array();
      }
    }
    public function get_acteurs_sex($criteres,$sex)
    {
      $this->db->select("COUNT(am.ID_ACTEUR) as nbActeur");
      $this->db->from('ACTEURS_MIFA am');
      $this->db->join('GEO_LOCALITES gl','gl.ID_LOCALITE=am.ID_LOCALITE');
      $this->db->join('GEO_CANTONS gc','gl.ID_CANTON=gc.ID_CANTON');
      $this->db->join('GEO_PREFECTURES gp','gp.ID_PREFECTURE=gc.ID_PREFECTURE');
      $this->db->join('GEO_REGIONS gr','gr.ID_REGION=gp.ID_REGION');
      $this->db->where($criteres);
      $this->db->where('am.SEXE',$sex);
      $query = $this->db->get();

      if($query){
        return $query->row_array()['nbActeur'];
      }
    }

    public function get_prodution($criteres)
    {
      $this->db->select("SUM(fp.PRODUCTION_TO) as nbProd");
      $this->db->from('FAIT_PRODUCTION fp');
      $this->db->join('ACTEURS_MIFA am','fp.ID_ACTEUR=am.ID_ACTEUR');
      $this->db->join('CULTURES clt','clt.ID_CULTURE=fp.ID_CULTURE');
      $this->db->join('GEO_LOCALITES gl','gl.ID_LOCALITE=am.ID_LOCALITE');
      $this->db->join('GEO_CANTONS gc','gl.ID_CANTON=gc.ID_CANTON');
      $this->db->join('GEO_PREFECTURES gp','gp.ID_PREFECTURE=gc.ID_PREFECTURE');
      $this->db->join('GEO_REGIONS gr','gr.ID_REGION=gp.ID_REGION');
      $this->db->where($criteres);

      //echo $this->db->last_query();
      $query = $this->db->get();

      if($query){
        return $query->row_array();
      }
    }

    public function get_mobile_money($acteur_id)
    {
       $this->db->select("DISTINCT(mm.ID_MOBILE_MONEY),mm.*");
       $this->db->from('MOBILE_MONEY mm');
       $this->db->join('MOBILE_MONEY_ACTEUR mma','mma.ID_MOBILE_MONEY=mm.ID_MOBILE_MONEY');
       $this->db->where('mma.ID_ACTEUR',$acteur_id);

       $query = $this->db->get();
       if($query){
        return $query->result_array();
       }
    }
    public function get_groupments($acteur_id)
    {
       $this->db->select('gr.*');
       $this->db->from('GROUPEMENTS gr');
       $this->db->join('GROUPEMENTS_ACTEURS ga','ga.ID_GROUPEMENT=gr.ID_GROUPEMENT');
       $this->db->where('ga.ID_ACTEUR',$acteur_id);

       $query = $this->db->get();
       if($query){
        return $query->result_array();
       } 
    }

    public function get_production_acteur($acteur_id,$annee)
    {
      $this->db->select("SUM(fp.PRODUCTION_TO) as qty,SUM(fp.PV_KILO*PRODUCTION_TO*1000) as montant,clt.DESCR_CULTURE");
      $this->db->from('FAIT_PRODUCTION fp');
      $this->db->join('ACTEURS_MIFA am','fp.ID_ACTEUR=am.ID_ACTEUR');
      $this->db->join('CULTURES clt','clt.ID_CULTURE=fp.ID_CULTURE');
      $this->db->where('am.ID_ACTEUR',$acteur_id);
      $this->db->where('fp.ANNEE',$annee);
      $this->db->group_by('clt.DESCR_CULTURE');
      $query = $this->db->get();

      if($query){
        return $query->result_array();
      }
    }

    public function get_all_traitement_acteur($acteur_id)
    {
      $this->db->select("tr.*,SUM(trd.MONTANT) as montant,ass.NOM_COMPAGNIE");
      $this->db->from("SN_TRAITEMENT tr");
      $this->db->join("SN_TRAITEMENT_DETAIL trd","trd.TRAITEMENT_ID=tr.TRAITEMENT_ID");
      $this->db->join("ASSUREURS_MIFA ass","ass.ID_ASSURANCE=tr.ID_ASSURANCE");
      $this->db->where("tr.ID_ACTEUR",$acteur_id);
      $this->db->group_by("tr.TRAITEMENT_ID");

      $query = $this->db->get();
      if($query){
        return $query->result_array();
      }
    }

    public function get_all_credits($acteur_id)
    {
      $this->db->select("fc.*,fsc.*");
      $this->db->from("FONDS_CREDIT fc");
      $this->db->join("FONDS_STATUT_CREDIT fsc","fsc.ID_STATUT=fc.STATUT");
      $this->db->where("fc.ID_ACTEUR",$acteur_id);

      $query = $this->db->get();
      if($query){
         return $query->result_array();
      }
    }

    public function mes_cotisations($credit_id)
    {
      $this->db->select("fc.*,fm.*");
      $this->db->from("FONDS_COTISATION fc");
      $this->db->join("FONDS_MIFA fm","fm.ID_FONDS=fc.ID_FONDS");
      $this->db->where('fc.ID_CREDIT',$credit_id);
      
      $query = $this->db->get();
      if($query){
         return $query->result_array();
      }
    }

    public function getMesProductions($ID_ACTEUR)
    {
      $this->db->select("pro.*,cl.DESCR_CULTURE,tsl.DESCRIPTION,fert.DESCRIPTION as FERT_DESCRIPTION");
      $this->db->from('FAIT_PRODUCTION as pro');
      $this->db->join("CULTURES cl","cl.ID_CULTURE = pro.ID_CULTURE","LEFT");
      $this->db->join("TYPE_SOL tsl","tsl.ID_TYPE_SOL = pro.ID_TYPE_SOL","LEFT");
      $this->db->join("TYPE_FERTILISANT fert","fert.TYPE_FERTILISANT_ID = pro.TYPE_FERTILISANT_ID","LEFT");
      $this->db->where("pro.ID_ACTEUR",$ID_ACTEUR);

      $query = $this->db->get();
      if($query){
        return $query->result_array();
      }
    }
    public function mes_machines($RISK_CREDIT_ID)
    {
      $this->db->select('mact.*,mtyp.*');
      $this->db->from('RISK_MACHINE_ACTEURS mact');
      $this->db->join('MACHINES_TYPES mtyp','mtyp.ID_TYPE_MACHINE =mact.ID_TYPE_MACHINE');
      $this->db->where('mact.RISK_CREDIT_ID',$RISK_CREDIT_ID);

      $query = $this->db->get();
      if($query){
        return $query->result_array();
      }
    }

    public function mes_lien_parentes($ID_ACTEUR)
    {
      $this->db->select('parent.*,lien.*');
      $this->db->from('RISK_CREDIT_PARENTE parent');
      $this->db->join('LIEN_PARENTE lien','lien.LIEN_PARANTE_ID =parent.LIEN_PARANTE_ID');
      $this->db->where('parent.ID_ACTEUR',$ID_ACTEUR);

      $query = $this->db->get();
      if($query){
        return $query->result_array();
      }
    }




    //didace

    // public function make_datatables_act($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
    // {
    //     $this->make_query_act($table,$select_column,$critere_txt,$critere_array,$order_by);
    //     if($_POST['length'] != -1){
    //        $this->db->limit($_POST["length"],$_POST["start"]);
    //     }
    //     $query = $this->db->get();
    //     return $query->result();
    // }
    public function make_query_act($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
    {

     

        $this->db->select($select_column);
        $this->db->from($table);
       
         $this->db->join('GEO_LOCALITES as LOC', 'LOC.ID_LOCALITE ='.$table.'.ID_LOCALITE','LEFT');
         $this->db->join('GEO_CANTONS as CAT', 'CAT.ID_CANTON=LOC.ID_CANTON','LEFT');
         $this->db->join('GEO_PREFECTURES as PREF', 'PREF.ID_PREFECTURE =CAT.ID_PREFECTURE','LEFT');
         $this->db->join('GEO_REGIONS as GEO', 'GEO.ID_REGION=PREF.ID_REGION','LEFT');
         $this->db->join('AGENT_TYPE as TYP', 'TYP.TYPE_AGENT_ID ='.$table.'.TYPE_AGENT_ID','left');
          

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


     public function get_filtered_data_act($table,$select_column,$critere_txt,$critere_array,$order_by)
    {
        $this->make_query_act($table,$select_column,$critere_txt,$critere_array,$order_by);
        $query = $this->db->get();
        return $query->num_rows();
        
    }


    // public function make_datatables4($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
    // {
    //     $this->make_query4($table,$select_column,$critere_txt,$critere_array,$order_by);
    //     if($_POST['length'] != -1){
    //        $this->db->limit($_POST["length"],$_POST["start"]);
    //     }
    //     $query = $this->db->get();
    //     return $query->result();
    // }

   public function make_query4($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
    {
        $this->db->select($select_column);
        $this->db->from($table);
         // $this->db->join('users', 'users.USER_ID ='.$table.'.ID_USER', 'left');
        $this->db->join('AGENT_TYPE as type', 'type.TYPE_AGENT_ID ='.$table.'.TYPE_AGENT_ID','left');
   
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
    public function count_all_data4($table,$critere = array())
    {
       $this->db->select('*');
       $this->db->where($critere);
       $this->db->from($table);
       return $this->db->count_all_results();   
    }
  public function get_filtered_data4($table,$select_column,$critere_txt,$critere_array,$order_by)
    {
        $this->make_query4($table,$select_column,$critere_txt,$critere_array,$order_by);
        $query = $this->db->get();
        return $query->num_rows();
        
    }



public function count_all_data2($table,$critere = array())
    {
       $this->db->select('*');
       $this->db->where($critere);
       $this->db->from($table);
       return $this->db->count_all_results();   
    }



       public function make_query_em($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
    {
        $this->db->select($select_column);
        $this->db->from($table);
         $this->db->join('ACTEURS_MIFA', 'ACTEURS_MIFA.ID_ACTEUR ='.$table.'.ID_ACTEUR');
          $this->db->join('CULTURES', 'CULTURES.ID_CULTURE ='.$table.'.ID_CULTURE');
         
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

    //  public function make_datatables_em($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
    // {
    //     $this->make_query_em($table,$select_column,$critere_txt,$critere_array,$order_by);
    //     if($_POST['length'] != -1){
    //        $this->db->limit($_POST["length"],$_POST["start"]);
    //     }
    //     $query = $this->db->get();
    //     return $query->result();
    // }


    public function count_all_data_em($table,$critere = array())
    {
       $this->db->select('*');
       $this->db->where($critere);
       $this->db->from($table);
       return $this->db->count_all_results();   
    }
   

   public function get_filtered_data_em($table,$select_column,$critere_txt,$critere_array,$order_by)
    {
        $this->make_query_em($table,$select_column,$critere_txt,$critere_array,$order_by);
        $query = $this->db->get();
        return $query->num_rows();
        
    }



    // public function make_datatables_al($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
    // {
    //     $this->make_query_al($table,$select_column,$critere_txt,$critere_array,$order_by);
    //     if($_POST['length'] != -1){
    //        $this->db->limit($_POST["length"],$_POST["start"]);
    //     }
    //     $query = $this->db->get();
    //     return $query->result();
    // }



    public function make_query_al_sous_cooperative($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
    {
        $this->db->select($select_column);
        $this->db->from($table);
        $this->db->join('GEO_LOCALITES', 'GEO_LOCALITES.ID_LOCALITE ='.$table.'.COLLINE_ID','left');
        $this->db->join('GEO_REGIONS', 'GEO_REGIONS.ID_REGION ='.$table.'.PROVINCE_ID','left');
        //$this->db->join('GEO_LOCALITES', 'GEO_LOCALITES.ID_LOCALITE ='.$table.'.COLLINE_ID','left');
        //$this->db->join('GROUPEMENTS_TYPE', 'GROUPEMENTS_TYPE.ID_TYPE ='.$table.'.TYPE_GROUPEMENT','left');

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






 public function make_query_al($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
    {
        $this->db->select($select_column);
        $this->db->from($table);
        $this->db->join('GEO_LOCALITES', 'GEO_LOCALITES.ID_LOCALITE ='.$table.'.COLLINE_ID','left');
        $this->db->join('GEO_REGIONS', 'GEO_REGIONS.ID_REGION ='.$table.'.PROVINCE_ID','left');
        //$this->db->join('GEO_LOCALITES', 'GEO_LOCALITES.ID_LOCALITE ='.$table.'.COLLINE_ID','left');
        $this->db->join('GROUPEMENTS_TYPE', 'GROUPEMENTS_TYPE.ID_TYPE ='.$table.'.TYPE_GROUPEMENT','left');

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

 public function count_all_data_al($table,$critere = array())
    {
       $this->db->select('*');
       $this->db->where($critere);
       $this->db->from($table);
       return $this->db->count_all_results();   
    }

  public function get_filtered_data_al($table,$select_column,$critere_txt,$critere_array,$order_by)
    {
        $this->make_query_al($table,$select_column,$critere_txt,$critere_array,$order_by);
        $query = $this->db->get();
        return $query->num_rows();
        
    }



// public function make_datatables_paifar_localite_detail($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_paifar_localite_detail($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

   public function make_query_paifar_localite_detail($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
    {
        $this->db->select($select_column);
        $this->db->from($table);
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
    public function count_all_data_paifar_localite_detail($table,$critere = array(),$critere_txt=NULL)
    {
       $this->db->select('*');

       $this->db->where($critere);
       if($critere_txt != NULL)
         $this->db->where($critere);
       $this->db->from($table);
       return $this->db->count_all_results();   
    }
  public function get_filtered_data_paifar_localite_detail($table,$select_column,$critere_txt,$critere_array,$order_by)
    {
        $this->make_query_paifar_localite_detail($table,$select_column,$critere_txt,$critere_array,$order_by);
        $query = $this->db->get();
        return $query->num_rows();
        
    }


  function RequeteUpdate($requete){
      $query=$this->db->query($requete);
      if ($query) {
         return 1;
      }else{
        return 0;
      }
    }

    
  //marche
   public function count_all_data_marche($table,$critere =NULL)
    {
       $this->db->select('*');
       $this->db->where($critere);
       $this->db->from($table);
       return $this->db->count_all_results();   
    }
    public function get_filtered_data_marche($table,$select_column,$critere_txt,$critere_array,$order_by)
    {
        $this->make_query_marche($table,$select_column,$critere_txt,$critere_array,$order_by);
        $query = $this->db->get();
        return $query->num_rows();
        
    }
    // public function make_datatables_marche($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
    // {
    //     $this->make_query_marche($table,$select_column,$critere_txt,$critere_array,$order_by);
    //     if($_POST['length'] != -1){
    //        $this->db->limit($_POST["length"],$_POST["start"]);
    //     }
    //     $query = $this->db->get();
    //     return $query->result();
    // }
     public function make_query_marche($table,$select_column=array(),$critere_txt = NULL,$critere_array=NULL,$order_by=array())
    {
        $this->db->select($select_column);
        $this->db->from($table);
        $this->db->join('GEO_REGIONS', 'GEO_REGIONS.ID_REGION='.$table.'.ID_REGION','left');
        $this->db->join('GEO_PREFECTURES', 'GEO_PREFECTURES.ID_PREFECTURE='.$table.'.ID_PREFECTURE','left');
        $this->db->join('GEO_CANTONS', 'GEO_CANTONS.ID_CANTON='.$table.'.ID_CANTON','left');
        $this->db->join('GEO_LOCALITES', 'GEO_LOCALITES.ID_LOCALITE='.$table.'.ID_LOCALITE','left');
         
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







      //////emery models/////

   // public function make_datatables_detail_type_aides($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
   //  {
   //      $this->make_query_detail_type_aides($table,$select_column,$critere_txt,$critere_array,$order_by);
   //      if($_POST['length'] != -1){
   //         $this->db->limit($_POST["length"],$_POST["start"]);
   //      }
   //      $query = $this->db->get();
   //      return $query->result();
   //  }

   public function make_query_detail_type_aides($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
    {
        $this->db->select($select_column);
        $this->db->from($table);
         $this->db->join('GROUPEMENTS', 'GROUPEMENTS.ID_GROUPEMENT='.$table.'.COOPERATIVE_ID');
        $this->db->join('nature_aides', 'nature_aides.NATURE_AIDE_ID ='.$table.'.NATURE_ID');
     

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
    public function count_all_data_detail_type_aides($table,$critere = array(),$critere_txt=NULL)
    {
       $this->db->select('*');

       $this->db->where($critere);
       if($critere_txt != NULL)
         $this->db->where($critere);
      $this->db->from($table);
        $this->db->join('GROUPEMENTS', 'GROUPEMENTS.ID_GROUPEMENT='.$table.'.COOPERATIVE_ID');
        $this->db->join('nature_aides', 'nature_aides.NATURE_AIDE_ID ='.$table.'.NATURE_ID');
     

       return $this->db->count_all_results();   
            }
  public function get_filtered_data_detail_type_aides($table,$select_column,$critere_txt,$critere_array,$order_by)
    {
        $this->make_query_detail_type_aides($table,$select_column,$critere_txt,$critere_array,$order_by);
        $query = $this->db->get();
        return $query->num_rows();
        
    }





//           /////
//     //   public function make_datatables_detail_type_cooperative($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     // {
//     //     $this->make_query_detail_type_cooperative($table,$select_column,$critere_txt,$critere_array,$order_by);
//     //     if($_POST['length'] != -1){
//     //        $this->db->limit($_POST["length"],$_POST["start"]);
//     //     }
//     //     $query = $this->db->get();
//     //     return $query->result();
//     // }

//    public function make_query_detail_type_cooperative($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('GROUPEMENTS_TYPE', 'GROUPEMENTS_TYPE.ID_TYPE ='.$table.'.TYPE_GROUPEMENT');
     

//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_detail_type_cooperative($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//        $this->db->join('GROUPEMENTS_TYPE', 'GROUPEMENTS_TYPE.ID_TYPE ='.$table.'.TYPE_GROUPEMENT');
     
//        return $this->db->count_all_results();   
//             }
//   public function get_filtered_data_detail_type_cooperative($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_detail_type_cooperative($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }

//        ////opportinute//
//     public function make_datatables_detail_cooperative_opportunite($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_detail_cooperative_opportunite($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_detail_cooperative_opportunite($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//          $this->db->join('coop_opportunite', 'coop_opportunite.OPPORTUNITE_ID ='.$table.'.OPPORTUNITE_ID');
     
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//            }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//           }        
          
//       }
//     public function count_all_data_detail_cooperative_opportunite($table,$critere = array(),$critere_txt=NULL)
//           {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//        $this->db->join('coop_opportunite', 'coop_opportunite.OPPORTUNITE_ID ='.$table.'.OPPORTUNITE_ID');
     
//        return $this->db->count_all_results();   
//             }
//   public function get_filtered_data_detail_cooperative_opportunite($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_detail_cooperative_opportunite($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }

//    /////membres////
//      public function make_datatables_detail_membres_cooperative($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_detail_membres_cooperative($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_detail_membres_cooperative($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('GROUPEMENTS', 'GROUPEMENTS.ID_GROUPEMENT='.$table.'.ID_GROUPEMENT');
//         $this->db->join('ACTEURS_MIFA', 'ACTEURS_MIFA.ID_ACTEUR ='.$table.'.ID_ACTEUR','left');
     
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//            }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//           }        
          
//       }
//     public function count_all_data_detail_membres_cooperative($table,$critere = array(),$critere_txt=NULL)
//           {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//         $this->db->join('GROUPEMENTS', 'GROUPEMENTS.ID_GROUPEMENT='.$table.'.ID_GROUPEMENT');
//         $this->db->join('ACTEURS_MIFA', 'ACTEURS_MIFA.ID_ACTEUR ='.$table.'.ID_ACTEUR','left');
     
//        return $this->db->count_all_results();   
//             }
//   public function get_filtered_data_detail_membres_cooperative($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_detail_membres_cooperative($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }

//     //////transformation

//      public function make_datatables_detail_cooperative_transformation($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_detail_cooperative_transformation($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_detail_cooperative_transformation($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//          $this->db->join('coop_transformation', 'coop_transformation.TRANSFORMATION_ID ='.$table.'.TRANSFORMATION_ID');
     
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//            }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//           }        
          
//       }
//     public function count_all_data_detail_cooperative_transformation($table,$critere = array(),$critere_txt=NULL)
//           {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//        $this->db->join('coop_transformation', 'coop_transformation.TRANSFORMATION_ID ='.$table.'.TRANSFORMATION_ID');
     
//        return $this->db->count_all_results();   
//             }
//   public function get_filtered_data_detail_cooperative_transformation($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_detail_cooperative_transformation($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }
//      /////source capital///

//      public function make_datatables_detail_cooperative_source_cap($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_detail_cooperative_source_cap($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_detail_cooperative_source_cap($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('source_capital', 'source_capital.SOURCE_CAPITAL_ID ='.$table.'.SOURCE_CAPITAL_ID');
     
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//            }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//           }        
          
//       }
//     public function count_all_data_detail_cooperative_source_cap($table,$critere = array(),$critere_txt=NULL)
//           {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//        $this->db->join('source_capital', 'source_capital.SOURCE_CAPITAL_ID ='.$table.'.SOURCE_CAPITAL_ID');
     
//        return $this->db->count_all_results();   
//             }
//   public function get_filtered_data_detail_cooperative_source_cap($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_detail_cooperative_source_cap($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }

//     //cooperative  par lieux

//     public function make_datatables_cooperative_localite($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_cooperative_localite($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_cooperative_localite($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('GEO_REGIONS', 'GEO_REGIONS.ID_REGION='.$table.'.PROVINCE_ID','left');
//         $this->db->join('GEO_PREFECTURES', 'GEO_PREFECTURES.ID_PREFECTURE='.$table.'.COMMUNE_ID','left');
        
//         $this->db->join('GEO_CANTONS', 'GEO_CANTONS.ID_CANTON='.$table.'.ZONE_ID','left');
//         $this->db->join('GEO_LOCALITES', 'GEO_LOCALITES.ID_LOCALITE='.$table.'.COLLINE_ID','left');
              
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_cooperative_localite($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//         $this->db->join('GEO_REGIONS', 'GEO_REGIONS.ID_REGION='.$table.'.PROVINCE_ID','left');
//         $this->db->join('GEO_PREFECTURES', 'GEO_PREFECTURES.ID_PREFECTURE='.$table.'.COMMUNE_ID','left');
        
//         $this->db->join('GEO_CANTONS', 'GEO_CANTONS.ID_CANTON='.$table.'.ZONE_ID','left');
//         $this->db->join('GEO_LOCALITES', 'GEO_LOCALITES.ID_LOCALITE='.$table.'.COLLINE_ID','left');
//        return $this->db->count_all_results();   
//         }
//   public function get_filtered_data_cooperative_localite($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//         $this->make_query_cooperative_localite($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }




//     public function get_filtered_data_membre($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_membre($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }
//     public function make_datatables_membre($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_membre($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }
//      public function make_query_membre($table,$select_column=array(),$critere_txt = NULL,$critere_array=NULL,$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('CELLULE', 'CELLULE.CELLULE_ID='.$table.'.CELLULE_ID','left');
         
//         if($critere_txt != NULL){
         
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }

//     //SOUS_COOPERATIVE PAR LIEU

//     public function make_datatables_sous_cooperative_localite($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_sous_cooperative_localite($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_sous_cooperative_localite($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('GEO_REGIONS', 'GEO_REGIONS.ID_REGION='.$table.'.PROVINCE_ID','left');
//         $this->db->join('GEO_PREFECTURES', 'GEO_PREFECTURES.ID_PREFECTURE='.$table.'.COMMUNE_ID','left');
        
//         $this->db->join('GEO_CANTONS', 'GEO_CANTONS.ID_CANTON='.$table.'.ZONE_ID','left');
//         $this->db->join('GEO_LOCALITES', 'GEO_LOCALITES.ID_LOCALITE='.$table.'.COLLINE_ID','left');
              
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_sous_cooperative_localite($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//         $this->db->join('GEO_REGIONS', 'GEO_REGIONS.ID_REGION='.$table.'.PROVINCE_ID','left');
//         $this->db->join('GEO_PREFECTURES', 'GEO_PREFECTURES.ID_PREFECTURE='.$table.'.COMMUNE_ID','left');
        
//         $this->db->join('GEO_CANTONS', 'GEO_CANTONS.ID_CANTON='.$table.'.ZONE_ID','left');
//         $this->db->join('GEO_LOCALITES', 'GEO_LOCALITES.ID_LOCALITE='.$table.'.COLLINE_ID','left');
//        return $this->db->count_all_results();   
//         }
//   public function get_filtered_data_sous_cooperative_localite($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//         $this->make_query_sous_cooperative_localite($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }
//   public function make_datatables_ben_organisation($table,$select_column,$critere_txt,$critere_array=array(),$critere_in_array = array(),$critere_not_in_array = array(),$order_by)
//            {
//         $this->make_query_ben_organisation($table,$select_column,$critere_txt,$critere_array,$critere_in_array,$critere_not_in_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_ben_organisation($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$critere_in_array = array(),$critere_not_in_array = array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','LEFT');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','LEFT');
//         $this->db->join('syst_zones','syst_zones.ZONE_ID='.$table.'.ZONE_ID','LEFT');
//         $this->db->join('syst_collines', 'syst_collines.COLLINE_ID='.$table.'.COLLINE_ID','LEFT');        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array)){
//           $this->db->where($critere_array);
//         }


//         if(!empty($critere_not_in_array)){
//           $this->db->where_not_in('OP_ID',$critere_not_in_array);
//         }

//         if(!empty($critere_in_array)){
//           $this->db->where_in('OP_ID',$critere_in_array);
//         }


//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_ben_organisation($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//        $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','LEFT');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','LEFT');
//         $this->db->join('syst_zones','syst_zones.ZONE_ID='.$table.'.ZONE_ID','LEFT');
//         $this->db->join('syst_collines', 'syst_collines.COLLINE_ID='.$table.'.COLLINE_ID','LEFT');
        
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_ben_organisation($table,$select_column,$critere_txt,$critere_array=array(),$critere_in_array = array(),$critere_not_in_array = array(),$order_by)
//        {
//         $this->make_query_ben_organisation($table,$select_column,$critere_txt,$critere_array,$critere_in_array,$critere_not_in_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }


//         //Ella 


//   //   public function make_datatables_beneficiaire($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//   //   {
//   //       $this->make_query_beneficiaire($table,$select_column,$critere_txt,$critere_array,$order_by);
//   //       if($_POST['length'] != -1){
//   //          $this->db->limit($_POST["length"],$_POST["start"]);
//   //       }
//   //       $query = $this->db->get();
//   //       return $query->result();
//   //   }

//   //  public function make_query_beneficiaire($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//   //   {
//   //       $this->db->select($select_column);
//   //       $this->db->from($table);
//   //       $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','LEFT');
//   //       $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','LEFT');
//   //       $this->db->join('syst_zones','syst_zones.ZONE_ID='.$table.'.ZONE_ID','LEFT');
//   //       $this->db->join('syst_collines','syst_collines.COLLINE_ID='.$table.'.COLLINE_ID','LEFT');
//   //       $this->db->join('ben_sexe', 'ben_sexe.SEXE_ID='.$table.'.SEXE_ID','LEFT');
        
//   //       if($critere_txt != NULL){
//   //           $this->db->where($critere_txt);
//   //       }
//   //       if(!empty($critere_array))
//   //         $this->db->where($critere_array);

//   //       if(!empty($order_by)){
//   //           $key = key($order_by);
//   //         $this->db->order_by($key,$order_by[$key]);  
//   //       }        
          
//   //   }
//   //   public function count_all_data_beneficiaire($table,$critere = array(),$critere_txt=NULL)
//   //   {
//   //      $this->db->select('*');

//   //      $this->db->where($critere);
//   //      if($critere_txt != NULL)
//   //        $this->db->where($critere);
//   //      $this->db->from($table);
            
//   //       $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','LEFT');
//   //       $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','LEFT');
//   //       $this->db->join('syst_zones','syst_zones.ZONE_ID='.$table.'.ZONE_ID','LEFT');
//   //       $this->db->join('syst_collines','syst_collines.COLLINE_ID='.$table.'.COLLINE_ID','LEFT');
//   //       $this->db->join('ben_sexe', 'ben_sexe.SEXE_ID='.$table.'.SEXE_ID','LEFT');
        
        
//   //      return $this->db->count_all_results();   
//   //   }
//   // public function get_filtered_data_beneficiaire($table,$select_column,$critere_txt,$critere_array,$order_by)
//   //   {
//   //       $this->make_query_beneficiaire($table,$select_column,$critere_txt,$critere_array,$order_by);
//   //       $query = $this->db->get();
//   //       return $query->num_rows();
        
//   //   }

//     public function make_datatables_beneficiaire_cooperative($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_beneficiaire_cooperative($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_beneficiaire_cooperative($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
        

//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','LEFT');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','LEFT');
//         $this->db->join('syst_zones','syst_zones.ZONE_ID='.$table.'.ZONE_ID','LEFT');
//         $this->db->join('syst_collines','syst_collines.COLLINE_ID='.$table.'.COLLINE_ID','LEFT');
//         $this->db->join('ben_sexe', 'ben_sexe.SEXE_ID='.$table.'.SEXE_ID','LEFT');

//         $this->db->join('ben_beneficiaire_op', 'ben_beneficiaire_op.BENEFICIAIRE_ID='.$table.'.BENEFICIAIRE_ID','LEFT');
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_beneficiaire_cooperative($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
            
//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','LEFT');
        
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','LEFT');
//         $this->db->join('syst_zones','syst_zones.ZONE_ID='.$table.'.ZONE_ID','LEFT');
//         $this->db->join('syst_collines','syst_collines.COLLINE_ID='.$table.'.COLLINE_ID','LEFT');
//         $this->db->join('ben_sexe', 'ben_sexe.SEXE_ID='.$table.'.SEXE_ID','LEFT');

//         $this->db->join('ben_beneficiaire_op', 'ben_beneficiaire_op.BENEFICIAIRE_ID='.$table.'.BENEFICIAIRE_ID','LEFT');
        
        
//        return $this->db->count_all_results();   
//     }
//   public function get_filtered_data_beneficiaire_cooperative($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_beneficiaire_cooperative($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }



//     /////////////////////dashboard des affectations

//     public function make_datatables_affectation($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_affectation($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_affectation($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join(' pro_intervenant', ' pro_intervenant.INTERVENANT_ID='.$table.'.ID_COLLABORATEUR','left');
              
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_affectation($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//         $this->db->join(' pro_intervenant', ' pro_intervenant.INTERVENANT_ID='.$table.'.ID_COLLABORATEUR','left');
      
//        return $this->db->count_all_results();   
//         }
//   public function get_filtered_data_affectation($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//         $this->make_query_affectation($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }



//     /////////////laneuve29092020



    
// ////////////////////////////////rapport_Nbr_activite


//     public function make_datatables_activite($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_activite($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_activite($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//        // $this->db->join(' pro_intervenant', ' pro_intervenant.INTERVENANT_ID='.$table.'.ID_COLLABORATEUR','left');
              
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_activite($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//        // $this->db->join(' pro_intervenant', ' pro_intervenant.INTERVENANT_ID='.$table.'.ID_COLLABORATEUR','left');
      
//        return $this->db->count_all_results();   
//         }
//   public function get_filtered_data_activite($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//         $this->make_query_activite($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }

// /////////////laneuve29092020



// public function make_datatables_tache_sous_composante($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_tache_sous_composante($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_tache_sous_composante($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
        

//         $this->db->join('ptba_activite', 'ptba_activite.ID_TACHE='.$table.'.ID_TACHE');
        
//         $this->db->join('pro_sous_composante', 'pro_sous_composante.ID_SOUS_COMPOSANTE='.$table.'.ID_SOUS_COMPOSANTE','LEFT');
//         $this->db->join('pro_filiere','pro_filiere.FILIERE_ID='.$table.'.ID_FILLIERE','LEFT');
       
        
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_tache_sous_composante($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
            
//         $this->db->join('ptba_activite', 'ptba_activite.ID_TACHE='.$table.'.ID_TACHE');
        
//         $this->db->join('pro_sous_composante', 'pro_sous_composante.ID_SOUS_COMPOSANTE='.$table.'.ID_SOUS_COMPOSANTE','LEFT');
//        $this->db->join('pro_filiere','pro_filiere.FILIERE_ID='.$table.'.ID_FILLIERE','LEFT');
        
       
        
        
//        return $this->db->count_all_results();   
//     }
//   public function get_filtered_data_tache_sous_composante($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_tache_sous_composante($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }


//     /////////////laneuve29092020



// public function make_datatables_affectation_sous_composante($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_affectation_sous_composante($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_affectation_sous_composante($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
        

//         $this->db->join('ptba_affectation', 'ptba_affectation.ID_ACTIVITE='.$table.'.ID_ACTIVITE');

//        $this->db->join('ptba_tache', 'ptba_tache.ID_TACHE='.$table.'.ID_TACHE');
        
//         $this->db->join('pro_sous_composante', 'pro_sous_composante.ID_SOUS_COMPOSANTE=ptba_tache.ID_SOUS_COMPOSANTE','LEFT');
//         $this->db->join('pro_intervenant','pro_intervenant.INTERVENANT_ID=ptba_affectation.ID_COLLABORATEUR','LEFT');
       
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_affectation_sous_composante($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
            
        


//         $this->db->join('ptba_affectation', 'ptba_affectation.ID_ACTIVITE='.$table.'.ID_ACTIVITE');

//        $this->db->join('ptba_tache', 'ptba_tache.ID_TACHE='.$table.'.ID_TACHE');
        
//         $this->db->join('pro_sous_composante', 'pro_sous_composante.ID_SOUS_COMPOSANTE=ptba_tache.ID_SOUS_COMPOSANTE','LEFT');
//        $this->db->join('pro_intervenant','pro_intervenant.INTERVENANT_ID=ptba_affectation.ID_COLLABORATEUR','LEFT');
      
       
        
        
//        return $this->db->count_all_results();   
//     }
//   public function get_filtered_data_affectation_sous_composante($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_affectation_sous_composante($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }



//  //Ella 05/10/2020

//     public function make_datatables_type_alerte($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_type_alerte($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_type_alerte($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','LEFT');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','LEFT');
       
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_type_alerte($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
            
//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','LEFT');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','LEFT');
     
        
        
//        return $this->db->count_all_results();   
//     }
//   public function get_filtered_data_type_alerte($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_type_alerte($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }


//     //Edmond 05/10/2020

//            public function make_datatables_alertes_par_canton($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_alertes_par_canton($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_alertes_par_canton($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','left');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','left');
        
//          $this->db->join('pro_filiere', 'pro_filiere.FILIERE_ID='.$table.'.FILIERE_ID','left');
//          $this->db->join('cs_dec_type', 'cs_dec_type.DECLARATION_TYPE_ID='.$table.'.TYPE_ALERTE','left');
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_alertes_par_canton($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','left');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','left');
        
//         $this->db->join('pro_filiere', 'pro_filiere.FILIERE_ID='.$table.'.FILIERE_ID','left');
//         $this->db->join('cs_dec_type', 'cs_dec_type.DECLARATION_TYPE_ID='.$table.'.TYPE_ALERTE','left');
        
//        return $this->db->count_all_results();   
//         }
//   public function get_filtered_data_alertes_par_canton($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//         $this->make_query_alertes_par_canton($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }


//     ////////////////////////////////rapport_Nbr_allerte_filieres Dancilla


//   //   public function make_datatables_allerte_filiere($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//   //   {
//   //       $this->make_query_allerte_filiere($table,$select_column,$critere_txt,$critere_array,$order_by);
//   //       if($_POST['length'] != -1){
//   //          $this->db->limit($_POST["length"],$_POST["start"]);
//   //       }
//   //       $query = $this->db->get();
//   //       return $query->result();
//   //   }

//   //  public function make_query_allerte_filiere($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//   //   {
//   //       $this->db->select($select_column);
//   //       $this->db->from($table);
//   //      $this->db->join(' syst_provinces', ' syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','left');
//   //      $this->db->join(' syst_communes', ' syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','left');
//   //     // $this->db->join(' cs_dec_type', ' cs_dec_type.DECLARATION_TYPE_ID='.$table.'.TYPE_ALERTE','left');
//   //     // $this->db->join(' pro_filiere', ' pro_filiere.FILIERE_ID='.$table.'.FILIERE_ID','left');
              
        
//   //       if($critere_txt != NULL){
//   //           $this->db->where($critere_txt);
//   //       }
//   //       if(!empty($critere_array))
//   //         $this->db->where($critere_array);

//   //       if(!empty($order_by)){
//   //           $key = key($order_by);
//   //         $this->db->order_by($key,$order_by[$key]);  
//   //       }        
          
//   //   }
//   //   public function count_all_data_allerte_filiere($table,$critere = array(),$critere_txt=NULL)
//   //   {
//   //      $this->db->select('*');

//   //      $this->db->where($critere);
//   //      if($critere_txt != NULL)
//   //        $this->db->where($critere);
//   //      $this->db->from($table);
//   //         $this->db->join(' syst_provinces', ' syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','left');
//   //      $this->db->join(' syst_communes', ' syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','left');
//   //     // $this->db->join(' pro_filiere', ' pro_filiere.FILIERE_ID='.$table.'.FILIERE_ID','left');
      
//   //      return $this->db->count_all_results();   
//   //       }
//   // public function get_filtered_data_allerte_filiere($table,$select_column,$critere_txt,$critere_array,$order_by)
//   //      {
//   //       $this->make_query_allerte_filiere($table,$select_column,$critere_txt,$critere_array,$order_by);
//   //       $query = $this->db->get();
//   //       return $query->num_rows();
        
//   //   }

    


//  public function make_datatables_allerte_filiere($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_allerte_filiere($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_allerte_filiere($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//        $this->db->join(' syst_provinces', ' syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','LEFT');
//        $this->db->join(' syst_communes', ' syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','LEFT');
      
//       $this->db->join(' pro_filiere', ' pro_filiere.FILIERE_ID='.$table.'.FILIERE_ID','LEFT');
              
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_allerte_filiere($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//           $this->db->join(' syst_provinces', ' syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','LEFT');
//        $this->db->join(' syst_communes', ' syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','LEFT');
//       $this->db->join(' pro_filiere', ' pro_filiere.FILIERE_ID='.$table.'.FILIERE_ID','LEFT');

      
      
//        return $this->db->count_all_results();   
//         }
//   public function get_filtered_data_allerte_filiere($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//         $this->make_query_allerte_filiere($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }

// //////////////beneficiaire statut des sous projets

//     public function make_datatables_beneficiaire_statut($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_beneficiaire_statut($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_beneficiaire_statut($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
        

//         $this->db->join('sp_sous_projet_beneficiaire', 'sp_sous_projet_beneficiaire.BENEFICIAIRE_ID='.$table.'.BENEFICIAIRE_ID');

      
        
//         $this->db->join('sp_status_beneficiaire', 'sp_status_beneficiaire.STATUS_ID=sp_sous_projet_beneficiaire.STATUS_ID');

//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID');
//         $this->db->join('syst_zones', 'syst_zones.ZONE_ID='.$table.'.ZONE_ID');
//         $this->db->join('syst_collines', 'syst_collines.COLLINE_ID='.$table.'.COLLINE_ID');
//          $this->db->join('ben_sexe', 'ben_sexe.SEXE_ID='.$table.'.SEXE_ID','LEFT');
        
       
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_beneficiaire_statut($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
            
        


//         $this->db->join('sp_sous_projet_beneficiaire', 'sp_sous_projet_beneficiaire.BENEFICIAIRE_ID='.$table.'.BENEFICIAIRE_ID');

      
        
//       $this->db->join('sp_status_beneficiaire', 'sp_status_beneficiaire.STATUS_ID=sp_sous_projet_beneficiaire.STATUS_ID');

//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID');
//         $this->db->join('syst_zones', 'syst_zones.ZONE_ID='.$table.'.ZONE_ID');
//         $this->db->join('syst_collines', 'syst_collines.COLLINE_ID='.$table.'.COLLINE_ID');
//          $this->db->join('ben_sexe', 'ben_sexe.SEXE_ID='.$table.'.SEXE_ID','LEFT');
      
//        return $this->db->count_all_results();   
//     }
//   public function get_filtered_data_beneficiaire_statut($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_beneficiaire_statut($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }


//     //08/10/2020 EDMOND

//                public function make_datatables_liste_sous_comp($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_liste_sous_comp($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_liste_sous_comp($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
        
//         $this->db->join('pro_composante', 'pro_composante.ID_COMPOSANTE='.$table.'.ID_COMPOSANTE','left');
        
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_liste_sous_comp($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
        
//         $this->db->join('pro_composante', 'pro_composante.ID_COMPOSANTE='.$table.'.ID_COMPOSANTE','left');
        
        
//        return $this->db->count_all_results();   
//         }
//   public function get_filtered_data_liste_sous_comp($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//         $this->make_query_liste_sous_comp($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }
    

//     //LA NEUVE 08/10

//     //////////////tache activite

//     public function make_datatables_tache_activite($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_tache_activite($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_tache_activite($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
        

//         $this->db->join('ptba_tache', 'ptba_tache.ID_TACHE='.$table.'.ID_TACHE');


//         $this->db->join('pro_sous_composante_indicateur', 'pro_sous_composante_indicateur.ID_SOUS_COMPOSANTE=ptba_tache.ID_SOUS_COMPOSANTE');

//         $this->db->join('ptba_annee_mois', 'ptba_annee_mois.PTBA_ID=ptba_tache.PTBA_ID');




      
        
      

       
        
        
       
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_tache_activite($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
            
        


//         $this->db->join('ptba_tache', 'ptba_tache.ID_TACHE='.$table.'.ID_TACHE');


//         $this->db->join('pro_sous_composante_indicateur', 'pro_sous_composante_indicateur.ID_SOUS_COMPOSANTE=ptba_tache.ID_SOUS_COMPOSANTE');

//         $this->db->join('ptba_annee_mois', 'ptba_annee_mois.PTBA_ID=ptba_tache.PTBA_ID');

      
       
        
        
//        return $this->db->count_all_results();   
//     }
//   public function get_filtered_data_tache_activite($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_tache_activite($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }
// //15/10


//     public function make_datatables_tache_activite_ind2_9($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_tache_activite_ind2_9($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_tache_activite_ind2_9($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
        

//         $this->db->join('ptba_tache', 'ptba_tache.ID_TACHE='.$table.'.ID_TACHE');



//         $this->db->join('pro_indicateur_descr', 'pro_indicateur_descr.ID_INSCR=ptba_tache.ID_FILLIERE ');

//         $this->db->join('ptba_annee_mois', 'ptba_annee_mois.PTBA_ID=ptba_tache.PTBA_ID');

//         $this->db->join('pro_sous_composante_indicateur', 'pro_sous_composante_indicateur.ID_SOUS_COMPOSANTE=ptba_tache.ID_SOUS_COMPOSANTE');
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_tache_activite_ind2_9($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
            
        


//         $this->db->join('ptba_tache', 'ptba_tache.ID_TACHE='.$table.'.ID_TACHE');

//         $this->db->join('pro_indicateur_descr', 'pro_indicateur_descr.ID_INSCR=ptba_tache.ID_FILLIERE ');


//         $this->db->join('pro_sous_composante_indicateur', 'pro_sous_composante_indicateur.ID_SOUS_COMPOSANTE=ptba_tache.ID_SOUS_COMPOSANTE');

//         $this->db->join('ptba_annee_mois', 'ptba_annee_mois.PTBA_ID=ptba_tache.PTBA_ID');

      
       
        
        
//        return $this->db->count_all_results();   
//     }
//   public function get_filtered_data_tache_activite_ind2_9($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_tache_activite_ind2_9($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }


//  public function make_datatables_sp_phase($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_sp_phase($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_sp_phase($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);

//         $this->db->join('sp_phase', 'sp_phase.ID_PHASE='.$table.'.ID_PHASE');  
        

//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','left');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','left');
//         $this->db->join('syst_zones', 'syst_zones.ZONE_ID='.$table.'.ZONE_ID','left');
//         $this->db->join('syst_collines', 'syst_collines.COLLINE_ID='.$table.'.COLLINE_ID','left');
         
        
       
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_sp_phase($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
            
        


       
//        $this->db->join('sp_phase', 'sp_phase.ID_PHASE='.$table.'.ID_PHASE');  
        

//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','left');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','left');
//         $this->db->join('syst_zones', 'syst_zones.ZONE_ID='.$table.'.ZONE_ID','left');
//         $this->db->join('syst_collines', 'syst_collines.COLLINE_ID='.$table.'.COLLINE_ID','left');
         

        
       
        
        
//        return $this->db->count_all_results();   
//     }
//   public function get_filtered_data_sp_phase($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_sp_phase($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }



//     //LANEUVE18/11

//     public function make_datatables_beneficiaire_guichet($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_beneficiaire_guichet($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_beneficiaire_guichet($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
        

//         $this->db->join('ben_beneficiaire', 'ben_beneficiaire.BENEFICIAIRE_ID='.$table.'.COLLABORATEUR_ID');

        
//         $this->db->join('pro_guichet', 'pro_guichet.GUICHET_ID=ben_beneficiaire_sous_projet.GUICHET_ID');

//          $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID=ben_beneficiaire.PROVINCE_ID','LEFT');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID=ben_beneficiaire.COMMUNE_ID','LEFT');
//         $this->db->join('syst_zones', 'syst_zones.ZONE_ID=ben_beneficiaire.ZONE_ID','LEFT');

//         $this->db->join('syst_collines', 'syst_collines.COLLINE_ID=ben_beneficiaire.COLLINE_ID','LEFT');

//          $this->db->join('ben_sexe', 'ben_sexe.SEXE_ID=ben_beneficiaire.SEXE_ID','LEFT');
        
       
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_beneficiaire_guichet($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
            
        




//         $this->db->join('ben_beneficiaire', 'ben_beneficiaire.BENEFICIAIRE_ID='.$table.'.COLLABORATEUR_ID');

        
        
//         $this->db->join('pro_guichet', 'pro_guichet.GUICHET_ID=ben_beneficiaire_sous_projet.GUICHET_ID');

//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID=ben_beneficiaire.PROVINCE_ID','LEFT');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID=ben_beneficiaire.COMMUNE_ID','LEFT');
//         $this->db->join('syst_zones', 'syst_zones.ZONE_ID=ben_beneficiaire.ZONE_ID','LEFT');

//         $this->db->join('syst_collines', 'syst_collines.COLLINE_ID=ben_beneficiaire.COLLINE_ID','LEFT');

//          $this->db->join('ben_sexe', 'ben_sexe.SEXE_ID=ben_beneficiaire.SEXE_ID','LEFT');
      
       
        
        
//        return $this->db->count_all_results();   
//     }
//   public function get_filtered_data_beneficiaire_guichet($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_beneficiaire_guichet($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }

  

// ///////////////////////ben_carte////////////////////////////


// public function make_datatables_ben_carte($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_ben_carte($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }



//    public function make_query_ben_carte($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID ='.$table.'.PROVINCE_ID', 'left');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID ='.$table.'.COMMUNE_ID', 'left');
//         $this->db->join('syst_zones', 'syst_zones.ZONE_ID ='.$table.'.ZONE_ID', 'left');
//         $this->db->join('syst_collines', 'syst_collines.COLLINE_ID ='.$table.'.COLLINE_ID', 'left');


//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_ben_carte($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID ='.$table.'.PROVINCE_ID', 'left');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID ='.$table.'.COMMUNE_ID', 'left');
//         $this->db->join('syst_zones', 'syst_zones.ZONE_ID ='.$table.'.ZONE_ID', 'left');
//         $this->db->join('syst_collines', 'syst_collines.COLLINE_ID ='.$table.'.COLLINE_ID', 'left');
//        return $this->db->count_all_results();   
//     }
//   public function get_filtered_data_ben_carte($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_ben_carte($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }

// /**/
//     public function make_datatables_beneficiaire_new($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_beneficiaire_new($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_beneficiaire_new($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.ID_PROVINCE','LEFT');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.ID_COMMUNE','LEFT');
//         $this->db->join('syst_zones','syst_zones.ZONE_ID='.$table.'.ID_ZONE','LEFT');
//         $this->db->join('syst_collines','syst_collines.COLLINE_ID='.$table.'.ID_COLLINE','LEFT');

//         $this->db->join('ben_sexe', 'ben_sexe.ID_SEXE='.$table.'.ID_SEXE','LEFT');
//         $this->db->join('ben_statut_matrimonial', 'ben_statut_matrimonial.ID_ETAT_CIVIL='.$table.'.ID_ETAT_CIVIL','LEFT');

//         $this->db->join('membre_type_document', 'membre_type_document.ID_TYPE_DOCUMENT='.$table.'.ID_TYPE_DOCUMENT','LEFT');
//        // $this->db->join('ben_type_beneficiaire', 'ben_type_beneficiaire.ID_TYPE_BENEFICIAIRE='.$table.'.ID_TYPE_BENEFICIAIRE','LEFT');
//         $this->db->join('sp_status_foncier', 'sp_status_foncier.ID_STATUS_FONCIER='.$table.'.ID_STATUS_FONCIER','LEFT');
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_beneficiaire_new($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
            
//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.ID_PROVINCE','LEFT');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.ID_COMMUNE','LEFT');
//         $this->db->join('syst_zones','syst_zones.ZONE_ID='.$table.'.ID_ZONE','LEFT');
//         $this->db->join('syst_collines','syst_collines.COLLINE_ID='.$table.'.ID_COLLINE','LEFT');
//         $this->db->join('ben_sexe', 'ben_sexe.ID_SEXE='.$table.'.ID_SEXE','LEFT');
//         $this->db->join('ben_statut_matrimonial', 'ben_statut_matrimonial.ID_ETAT_CIVIL='.$table.'.ID_ETAT_CIVIL','LEFT');

//         $this->db->join('membre_type_document', 'membre_type_document.ID_TYPE_DOCUMENT='.$table.'.ID_TYPE_DOCUMENT','LEFT');
//         //$this->db->join('ben_type_beneficiaire', 'ben_type_beneficiaire.ID_TYPE_BENEFICIAIRE='.$table.'.ID_TYPE_BENEFICIAIRE','LEFT');
//         $this->db->join('sp_status_foncier', 'sp_status_foncier.ID_STATUS_FONCIER='.$table.'.ID_STATUS_FONCIER','LEFT');        
        
//        return $this->db->count_all_results();   
//     }
//   public function get_filtered_data_beneficiaire_new($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_beneficiaire_new($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }


// /**/
//  //Didace Dady: Automatiser les list avec Json : on met en parametre un requet concu avec tous les jointure possible
//  public function datatable($requete)//make_datatables : requete avec Condition,LIMIT start,length
//     { 
//         $query =$this->maker($requete);//call function make query
//         return $query->result();
//     }  
//     public function maker($requete)//make query
//     {
//       return $this->db->query($requete);
//     }

//     public function all_data($requete)//count_all_data : requete sans Condition sans LIMIT start,length
//     {
//        $query =$this->maker($requete); //call function make query
//        return $query->num_rows();   
//     }
//      public function filtrer($requete)//get_filtered_data : requete avec Condition sans LIMIT start,length
//     {
//          $query =$this->maker($requete);//call function make query
//         return $query->num_rows();
        
//     }


//     public function make_datatables_beneficiaire($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//     {
//         $this->make_query_beneficiaire($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//         }
//         $query = $this->db->get();
//         return $query->result();
//     }

//    public function make_query_beneficiaire($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//     {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','LEFT');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','LEFT');
//         $this->db->join('syst_zones','syst_zones.ZONE_ID='.$table.'.ZONE_ID','LEFT');
//         $this->db->join('syst_collines','syst_collines.COLLINE_ID='.$table.'.COLLINE_ID','LEFT');
//         $this->db->join('ben_sexe', 'ben_sexe.SEXE_ID='.$table.'.SEXE_ID','LEFT');
//         $this->db->join('ben_beneficiaire_sous_projet', 'ben_beneficiaire_sous_projet.COLLABORATEUR_ID='.$table.'.BENEFICIAIRE_ID','LEFT');

//         $this->db->join('pro_filiere', 'pro_filiere.FILIERE_ID=ben_beneficiaire_sous_projet.FILIERE_ID','LEFT');


//         $this->db->join('sp_saison', 'sp_saison.SAISON_ID=ben_beneficiaire_sous_projet.SAISON_ID','LEFT');
        
        
        
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_beneficiaire($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
            
//         $this->db->join('syst_provinces', 'syst_provinces.PROVINCE_ID='.$table.'.PROVINCE_ID','LEFT');
//         $this->db->join('syst_communes', 'syst_communes.COMMUNE_ID='.$table.'.COMMUNE_ID','LEFT');
//         $this->db->join('syst_zones','syst_zones.ZONE_ID='.$table.'.ZONE_ID','LEFT');
//         $this->db->join('syst_collines','syst_collines.COLLINE_ID='.$table.'.COLLINE_ID','LEFT');
//         $this->db->join('ben_sexe', 'ben_sexe.SEXE_ID='.$table.'.SEXE_ID','LEFT');

//         $this->db->join('ben_beneficiaire_sous_projet', 'ben_beneficiaire_sous_projet.COLLABORATEUR_ID='.$table.'.BENEFICIAIRE_ID','LEFT');

//         $this->db->join('pro_filiere', 'pro_filiere.FILIERE_ID=ben_beneficiaire_sous_projet.FILIERE_ID','LEFT');

//         $this->db->join('sp_saison', 'sp_saison.SAISON_ID=ben_beneficiaire_sous_projet.SAISON_ID','LEFT');
        
        
        
//        return $this->db->count_all_results();   
//     }
//   public function get_filtered_data_beneficiaire($table,$select_column,$critere_txt,$critere_array,$order_by)
//     {
//         $this->make_query_beneficiaire($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//     }




//             ///emery LE 10/12/2020

//   //   public function make_datatables_ben_valeur_obtenu($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//   //          {
//   //       $this->make_query_ben_valeur_obtenu($table,$select_column,$critere_txt,$critere_array,$order_by);
//   //       if($_POST['length'] != -1){
//   //          $this->db->limit($_POST["length"],$_POST["start"]);
//   //            }
//   //       $query = $this->db->get();
//   //       return $query->result();
//   //         }

//   //  public function make_query_ben_valeur_obtenu($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//   //        {
//   //       $this->db->select($select_column);
//   //       $this->db->from($table);
//   //        $this->db->join('ptba_tache', 'ptba_tache.ID_TACHE='.$table.'.ID_TACHE');
//   //       $this->db->join('ptba_annee_mois', 'ptba_annee_mois.PTBA_ID=ptba_tache.ID_TACHE');
//   //       $this->db->join('pro_sous_composante_indicateur', 'pro_sous_composante_indicateur.ID_SOUS_COMPOSANTE=ptba_tache.ID_SOUS_COMPOSANTE','LEFT');

//   //       $this->db->join('ben_beneficiaire_sous_projet', 'ben_beneficiaire_sous_projet.ID_INDICATEUR=pro_sous_composante_indicateur.ID_INDICATEUR','LEFT');

//   //       $this->db->join('ben_beneficiaire', 'ben_beneficiaire.BENEFICIAIRE_ID=ben_beneficiaire_sous_projet.COLLABORATEUR_ID','LEFT');
      
//   //       if($critere_txt != NULL){
//   //           $this->db->where($critere_txt);
//   //       }
//   //       if(!empty($critere_array))
//   //         $this->db->where($critere_array);

//   //       if(!empty($order_by)){
//   //           $key = key($order_by);
//   //         $this->db->order_by($key,$order_by[$key]);  
//   //       }        
          
//   //   }
//   //   public function count_all_data_ben_valeur_obtenu($table,$critere = array(),$critere_txt=NULL)
//   //   {
//   //      $this->db->select('*');

//   //      $this->db->where($critere);
//   //      if($critere_txt != NULL)
//   //        $this->db->where($critere);
//   //      $this->db->from($table);
//   //      $this->db->join('ptba_tache', 'ptba_tache.ID_TACHE='.$table.'.ID_TACHE');

//   //       $this->db->join('ptba_annee_mois', 'ptba_annee_mois.PTBA_ID=ptba_tache.ID_TACHE');
//   //       $this->db->join('pro_sous_composante_indicateur', 'pro_sous_composante_indicateur.ID_SOUS_COMPOSANTE=ptba_tache.ID_SOUS_COMPOSANTE','LEFT');

//   //       $this->db->join('ben_beneficiaire_sous_projet', 'ben_beneficiaire_sous_projet.ID_INDICATEUR=pro_sous_composante_indicateur.ID_INDICATEUR','LEFT');

//   //       $this->db->join('ben_beneficiaire', 'ben_beneficiaire.BENEFICIAIRE_ID=ben_beneficiaire_sous_projet.COLLABORATEUR_ID','LEFT');
      
//   //      return $this->db->count_all_results();   
//   //      }
//   // public function get_filtered_data_ben_valeur_obtenu($table,$select_column,$critere_txt,$critere_array,$order_by)
//   //      {
//   //       $this->make_query_ben_valeur_obtenu($table,$select_column,$critere_txt,$critere_array,$order_by);
//   //       $query = $this->db->get();
//   //       return $query->num_rows();
        
//   //      }


//         ///emery LE 10/12/2020/indicateur2

//     public function make_datatables_ben_valeur_obtenu_indicateur2($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_ben_valeur_obtenu_indicateur2($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_ben_valeur_obtenu_indicateur2($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//          $this->db->join('ptba_tache', 'ptba_tache.ID_TACHE='.$table.'.ID_TACHE');
//       $this->db->join('pro_indicateur_descr', 'pro_indicateur_descr.ID_INSCR=ptba_tache.ID_FILLIERE');

//       $this->db->join('ptba_annee_mois', 'ptba_annee_mois.PTBA_ID=ptba_tache.ID_TACHE');

//       $this->db->join('pro_sous_composante_indicateur', 'pro_sous_composante_indicateur.ID_SOUS_COMPOSANTE=ptba_tache.ID_SOUS_COMPOSANTE','LEFT');

//       $this->db->join('ben_beneficiaire_sous_projet', 'ben_beneficiaire_sous_projet.ID_INDICATEUR=pro_sous_composante_indicateur.ID_INDICATEUR','LEFT');

//       $this->db->join('ben_beneficiaire', 'ben_beneficiaire.BENEFICIAIRE_ID=ben_beneficiaire_sous_projet.COLLABORATEUR_ID','LEFT');
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_ben_valeur_obtenu_indicateur2($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//         $this->db->join('ptba_tache', 'ptba_tache.ID_TACHE='.$table.'.ID_TACHE');
        
//         $this->db->join('pro_indicateur_descr', 'pro_indicateur_descr.ID_INSCR=ptba_tache.ID_FILLIERE');
//         $this->db->join('ptba_annee_mois', 'ptba_annee_mois.PTBA_ID=ptba_tache.ID_TACHE');
//         $this->db->join('pro_sous_composante_indicateur', 'pro_sous_composante_indicateur.ID_SOUS_COMPOSANTE=ptba_tache.ID_SOUS_COMPOSANTE','LEFT');

//         $this->db->join('ben_beneficiaire_sous_projet', 'ben_beneficiaire_sous_projet.ID_INDICATEUR=pro_sous_composante_indicateur.ID_INDICATEUR','LEFT');

//         $this->db->join('ben_beneficiaire', 'ben_beneficiaire.BENEFICIAIRE_ID=ben_beneficiaire_sous_projet.COLLABORATEUR_ID','LEFT');
      
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_ben_valeur_obtenu_indicateur2($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//       $this->make_query_ben_valeur_obtenu_indicateur2($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }


//          ///emery LE 10/12/2020

//     public function make_datatables_ben_valeur_obtenu($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_ben_valeur_obtenu($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_ben_valeur_obtenu($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//          $this->db->join('ptba_tache', 'ptba_tache.ID_TACHE='.$table.'.ID_TACHE');
//       $this->db->join('pro_indicateur_descr', 'pro_indicateur_descr.ID_INSCR=ptba_tache.ID_FILLIERE');

//       $this->db->join('ptba_annee_mois', 'ptba_annee_mois.PTBA_ID=ptba_tache.PTBA_ID');

//       $this->db->join('pro_sous_composante_indicateur', 'pro_sous_composante_indicateur.ID_SOUS_COMPOSANTE=ptba_tache.ID_SOUS_COMPOSANTE','LEFT');

//       $this->db->join('ben_beneficiaire_sous_projet', 'ben_beneficiaire_sous_projet.ID_INDICATEUR=pro_sous_composante_indicateur.ID_INDICATEUR','LEFT');

//       $this->db->join('ben_beneficiaire', 'ben_beneficiaire.BENEFICIAIRE_ID=ben_beneficiaire_sous_projet.COLLABORATEUR_ID','LEFT');
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_ben_valeur_obtenu($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
        
//          $this->db->join('ptba_tache', 'ptba_tache.ID_TACHE='.$table.'.ID_TACHE');
//       $this->db->join('pro_indicateur_descr', 'pro_indicateur_descr.ID_INSCR=ptba_tache.ID_FILLIERE');

//       $this->db->join('ptba_annee_mois', 'ptba_annee_mois.PTBA_ID=ptba_tache.PTBA_ID');

//       $this->db->join('pro_sous_composante_indicateur', 'pro_sous_composante_indicateur.ID_SOUS_COMPOSANTE=ptba_tache.ID_SOUS_COMPOSANTE','LEFT');

//       $this->db->join('ben_beneficiaire_sous_projet', 'ben_beneficiaire_sous_projet.ID_INDICATEUR=pro_sous_composante_indicateur.ID_INDICATEUR','LEFT');

//       $this->db->join('ben_beneficiaire', 'ben_beneficiaire.BENEFICIAIRE_ID=ben_beneficiaire_sous_projet.COLLABORATEUR_ID','LEFT');
      
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_ben_valeur_obtenu($table,$select_column,$critere_txt,$critere_array,$order_by)
//         {
//       $this->make_query_ben_valeur_obtenu($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }


//        /////regideso facturation



// public function make_datatables_type_abonne_compteur($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_type_abonne_compteur($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_type_abonne_compteur($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//        $this->db->join('type_abonne', 'type_abonne.ID_TYPE_ABONNE='.$table.'.ID_TYPE_ABONNE');
      
//         $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//         $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//         $this->db->join('zone','zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_type_abonne_compteur($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//        $this->db->join('type_abonne', 'type_abonne.ID_TYPE_ABONNE='.$table.'.ID_TYPE_ABONNE');
      
      
//         $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//         $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//         $this->db->join('zone','zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
       

//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_type_abonne_compteur($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//       $this->make_query_type_abonne_compteur($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }




// public function make_datatables_type_client_compteur($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_type_client_compteur($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_type_client_compteur($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//        $this->db->join('type_identification_client', 'type_identification_client.ID_IDENTIFICATION_CLIENT='.$table.'.ID_IDENTIFICATION_CLIENT');
      
//         $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//         $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//         $this->db->join('zone','zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_type_client_compteur($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//        $this->db->join('type_identification_client', 'type_identification_client.ID_IDENTIFICATION_CLIENT='.$table.'.ID_IDENTIFICATION_CLIENT');
      
      
//         $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//         $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//         $this->db->join('zone','zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
       

//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_type_client_compteur($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//       $this->make_query_type_client_compteur($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }


       
//          ///rapport_compteur_existant_vs_non

//     public function make_datatables_compteur_existant_vs_non($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_compteur_existant_vs_non($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_compteur_existant_vs_non($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
     
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_compteur_existant_vs_non($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
        
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
     
      
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_compteur_existant_vs_non($table,$select_column,$critere_txt,$critere_array,$order_by)
//         {
//       $this->make_query_compteur_existant_vs_non($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }



//        public function make_datatables_categorie_abonnement($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_categorie_abonnement($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_categorie_abonnement($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//        $this->db->join('type_categorie_abonnement', 'type_categorie_abonnement.ID_CATEGORIE_ABONNEMENT='.$table.'.ID_CATEGORIE_ABONNEMENT');
      
//         $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//         $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//         $this->db->join('zone','zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_categorie_abonnement($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//        $this->db->join('type_categorie_abonnement', 'type_categorie_abonnement.ID_CATEGORIE_ABONNEMENT='.$table.'.ID_CATEGORIE_ABONNEMENT');
      
      
//         $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//         $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//         $this->db->join('zone','zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
       

//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_categorie_abonnement($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//       $this->make_query_categorie_abonnement($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }


//        public function make_datatables_nature_local($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_nature_local($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_nature_local($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//        $this->db->join('type_nature_local', 'type_nature_local.ID_NATURE_LOCAL='.$table.'.ID_NATURE_LOCAL');
      
//         $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//         $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//         $this->db->join('zone','zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_nature_local($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//        $this->db->join('type_nature_local', 'type_nature_local.ID_NATURE_LOCAL='.$table.'.ID_NATURE_LOCAL');
      
      
//         $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//         $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//         $this->db->join('zone','zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
       

//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_nature_local($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//       $this->make_query_nature_local($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }



       
//          ///rapport_type_sense_montage_eau

//     public function make_datatables_type_sense_montage_eau($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_type_sense_montage_eau($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_type_sense_montage_eau($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
//           $this->db->join('type_sense_montage_eau', 'type_sense_montage_eau.ID_MONTAGE='.$table.'.ID_MONTAGE','LEFT');
     
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_type_sense_montage_eau($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
        
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
//           $this->db->join('type_sense_montage_eau', 'type_sense_montage_eau.ID_MONTAGE='.$table.'.ID_MONTAGE','LEFT');
     
      
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_ctype_sense_montage_eau($table,$select_column,$critere_txt,$critere_array,$order_by)
//         {
//       $this->make_query_type_sense_montage_eau($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }


// //edmond le 24/12/2020
//                public function make_datatables_type_commerce_all($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_type_commerce_all($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_type_commerce_all($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//            $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//         $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT'); 
//          $this->db->join('type_commerce', 'type_commerce.`TYPE_COMMERCE_ID`='.$table.'.TYPE_COMMERCE_ID','LEFT');
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
        
//     }
//     public function count_all_data_type_commerce_all($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//        $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//         $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT'); 
//          $this->db->join('type_commerce', 'type_commerce.`TYPE_COMMERCE_ID`='.$table.'.TYPE_COMMERCE_ID','LEFT');
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_type_commerce_all($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//       $this->make_query_type_commerce_all($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }

//        //rapport_etat_compteur_eau

//     public function make_datatables_etat_compteur_eau($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_etat_compteur_eau($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_etat_compteur_eau($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
//           $this->db->join('etat_compteur_eau', 'etat_compteur_eau.ID_ETAT_COMPTEUR_EAU='.$table.'.ID_ETAT_COMPT_EAUX','LEFT');
     
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_etat_compteur_eau($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
        
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
//           $this->db->join('etat_compteur_eau', 'etat_compteur_eau.ID_ETAT_COMPTEUR_EAU='.$table.'.ID_ETAT_COMPT_EAUX','LEFT');
     
      
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_etat_compteur_eau($table,$select_column,$critere_txt,$critere_array,$order_by)
//         {
//       $this->make_query_etat_compteur_eau($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }


//               //edmond le 24/12/2020
//                public function make_datatables_type_anomalie_now($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_type_anomalie_now($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_type_anomalie_now($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.COMMUNE_ID','LEFT');
//         $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ZONE_ID','LEFT');
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.PROVINCE_ID','LEFT'); 
//          $this->db->join('pdl_releve_annomalie', 'pdl_releve_annomalie.RELEVE_ID='.$table.'.RELEVE_ID','LEFT');
//          $this->db->join('regideso_abonne', 'regideso_abonne.ID_ABONNE='.$table.'.ABONNE_ID','LEFT');
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
        
//     }
//     public function count_all_data_type_anomalie_now($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//        $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.COMMUNE_ID','LEFT');
//         $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ZONE_ID','LEFT');
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.PROVINCE_ID','LEFT'); 
//          $this->db->join('pdl_releve_annomalie', 'pdl_releve_annomalie.RELEVE_ID='.$table.'.RELEVE_ID','LEFT');
//          $this->db->join('regideso_abonne', 'regideso_abonne.ID_ABONNE='.$table.'.ABONNE_ID','LEFT');
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_type_anomalie_now($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//       $this->make_query_type_anomalie_now($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }


//        //rapport_compteur_releve_par_enqueteur

//      public function make_datatables_compteur_releve_par_enqueteur($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_compteur_releve_par_enqueteur($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//      public function make_query_compteur_releve_par_enqueteur($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//        $this->db->join('ville', 'ville.ID_VILLE='.$table.'.PROVINCE_ID','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.COMMUNE_ID','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ZONE_ID','LEFT');
//           $this->db->join('enqueteurs', 'enqueteurs.ENQUETEUR_ID='.$table.'.ENQUETEUR','LEFT');
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_compteur_releve_par_enqueteur($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
        
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.PROVINCE_ID','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.COMMUNE_ID','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ZONE_ID','LEFT');
//           $this->db->join('enqueteurs', 'enqueteurs.ENQUETEUR_ID='.$table.'.ENQUETEUR','LEFT');
     
      
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_compteur_releve_par_enqueteur($table,$select_column,$critere_txt,$critere_array,$order_by)
//         {
//       $this->make_query_compteur_releve_par_enqueteur($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }



//        ///RELEVE


//     public function make_datatables_compteur_releve($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_compteur_releve($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_compteur_releve($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('ville', 'ville.ID_VILLE='.$table.'.PROVINCE_ID','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.COMMUNE_ID','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ZONE_ID','LEFT');
     
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_compteur_releve($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
        
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.PROVINCE_ID','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.COMMUNE_ID','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ZONE_ID','LEFT');
     
      
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_compteur_releve($table,$select_column,$critere_txt,$critere_array,$order_by)
//         {
//       $this->make_query_compteur_releve($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }


//        /////facturation



//     public function make_datatables_compteur_facturation($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_compteur_facturation($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_compteur_facturation($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('pdl_releves', 'pdl_releves.RELEVE_ID=pdl_facturation.RELEVE_ID');
//         $this->db->join('ville', 'ville.ID_VILLE=pdl_releves.PROVINCE_ID','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE=pdl_releves.COMMUNE_ID','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE=pdl_releves.ZONE_ID','LEFT');

        
     
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_compteur_facturation($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);


//           $this->db->join('pdl_releves', 'pdl_releves.RELEVE_ID=pdl_facturation.RELEVE_ID');
        
//          $this->db->join('ville', 'ville.ID_VILLE=pdl_releves.PROVINCE_ID','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE=pdl_releves.COMMUNE_ID','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE=pdl_releves.ZONE_ID','LEFT');

         
     
      
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_compteur_facturation($table,$select_column,$critere_txt,$critere_array,$order_by)
//         {
//       $this->make_query_compteur_facturation($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }


//        //rapport_raison_no_releve_compteur

    

//      public function make_datatables_raison_no_releve_compteur($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_raison_no_releve_compteur($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//      public function make_query_raison_no_releve_compteur($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
      
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.PROVINCE_ID','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.COMMUNE_ID','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ZONE_ID','LEFT');
//           $this->db->join('raisons_non_releves', 'raisons_non_releves.RAISON_ID='.$table.'.RAISON_NO_RELEVE','LEFT');
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_raison_no_releve_compteur($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
        
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.PROVINCE_ID','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.COMMUNE_ID','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ZONE_ID','LEFT');
//           $this->db->join('raisons_non_releves', 'raisons_non_releves.RAISON_ID='.$table.'.RAISON_NO_RELEVE','LEFT');
     
      
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_raison_no_releve_compteur($table,$select_column,$critere_txt,$critere_array,$order_by)
//         {
//       $this->make_query_raison_no_releve_compteur($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }


//               ///rapport_compteur_par_ecart_statut

//     public function make_datatables_compteur_par_ecart_statut($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_compteur_par_ecart_statut($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_compteur_par_ecart_statut($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//           $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
//           $this->db->join('pdl_ecart', 'pdl_ecart.ID_MAISON='.$table.'.ID_MAISON','LEFT');
//       $this->db->join('ecart_status','ecart_status.ID_STATUS_ECART=pdl_ecart.ID_STATUS_ECART','LEFT');
     
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_compteur_par_ecart_statut($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
        
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
//           $this->db->join('pdl_ecart', 'pdl_ecart.ID_MAISON='.$table.'.ID_MAISON','LEFT');
//       $this->db->join('ecart_status','ecart_status.ID_STATUS_ECART=pdl_ecart.ID_STATUS_ECART','LEFT');
     
      
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_compteur_par_ecart_statut($table,$select_column,$critere_txt,$critere_array,$order_by)
//         {
//       $this->make_query_compteur_par_ecart_statut($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }


//       ///rapport_compteur_par_ecart

//     public function make_datatables_compteur_par_ecart($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_compteur_par_ecart($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_compteur_par_ecart($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//           $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
//           $this->db->join('pdl_ecart', 'pdl_ecart.ID_MAISON='.$table.'.ID_MAISON','LEFT');
//       $this->db->join('ecarts','ecarts.ID_ECART=pdl_ecart.ID_ECART','LEFT');
   
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_compteur_par_ecart($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
        
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.ID_VILLE','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.ID_COMMUNE','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ID_ZONE','LEFT');
//           $this->db->join('pdl_ecart', 'pdl_ecart.ID_MAISON='.$table.'.ID_MAISON','LEFT');
//       $this->db->join('ecarts','ecarts.ID_ECART=pdl_ecart.ID_ECART','LEFT');
     
      
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_compteur_par_ecart($table,$select_column,$critere_txt,$critere_array,$order_by)
//         {
//       $this->make_query_compteur_par_ecart($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }


// //rapport_compteur_par_type_incident

//      public function make_datatables_compteur_par_type_incident($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_compteur_par_type_incident($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//      public function make_query_compteur_par_type_incident($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//         $this->db->join('ville', 'ville.ID_VILLE='.$table.'.PROVINCE_ID','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.COMMUNE_ID','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ZONE_ID','LEFT');
//           $this->db->join('incident_type', 'incident_type.ID_TYPE='.$table.'.TYPE_INCIDENT_ID','LEFT');
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_compteur_par_type_incident($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
        
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.PROVINCE_ID','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.COMMUNE_ID','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ZONE_ID','LEFT');
//           $this->db->join('incident_type', 'incident_type.ID_TYPE='.$table.'.TYPE_INCIDENT_ID','LEFT');
   
      
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_compteur_par_type_incident($table,$select_column,$critere_txt,$critere_array,$order_by)
//         {
//       $this->make_query_compteur_par_type_incident($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }




//               //edmond le 04/01/2021
//                public function make_datatables_type_incidents_now($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_type_incidents_now($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//    public function make_query_type_incidents_now($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.COMMUNE_ID','LEFT');
//         $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ZONE_ID','LEFT');
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.PROVINCE_ID','LEFT'); 
//           $this->db->join('incident_status', 'incident_status.`STATUS_ID`='.$table.'.STATUS_ID','LEFT');
      
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
        
//     }
//     public function count_all_data_type_incidents_now($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');

//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
//        $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.COMMUNE_ID','LEFT');
//         $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ZONE_ID','LEFT');
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.PROVINCE_ID','LEFT'); 
//          $this->db->join('incident_status', 'incident_status.`STATUS_ID`='.$table.'.STATUS_ID','LEFT');
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_type_incidents_now($table,$select_column,$critere_txt,$critere_array,$order_by)
//        {
//       $this->make_query_type_incidents_now($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }
// //////////////////////////////////////////////////

// //rapport_performance_agents

//      public function make_datatables_performance_agents($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//            {
//         $this->make_query_performance_agents($table,$select_column,$critere_txt,$critere_array,$order_by);
//         if($_POST['length'] != -1){
//            $this->db->limit($_POST["length"],$_POST["start"]);
//              }
//         $query = $this->db->get();
//         return $query->result();
//           }

//      public function make_query_performance_agents($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
//          {
//         $this->db->select($select_column);
//         $this->db->from($table);
       
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.PROVINCE_ID','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.COMMUNE_ID','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ZONE_ID','LEFT');
//           $this->db->join('enqueteurs', 'enqueteurs.ENQUETEUR_ID='.$table.'.ENQUETEUR');
//         if($critere_txt != NULL){
//             $this->db->where($critere_txt);
//         }
//         if(!empty($critere_array))
//           $this->db->where($critere_array);

//         if(!empty($order_by)){
//             $key = key($order_by);
//           $this->db->order_by($key,$order_by[$key]);  
//         }        
          
//     }
//     public function count_all_data_performance_agents($table,$critere = array(),$critere_txt=NULL)
//     {
//        $this->db->select('*');
//        $this->db->where($critere);
//        if($critere_txt != NULL)
//          $this->db->where($critere);
//        $this->db->from($table);
        
//          $this->db->join('ville', 'ville.ID_VILLE='.$table.'.PROVINCE_ID','LEFT');
//          $this->db->join('commune', 'commune.ID_COMMUNE='.$table.'.COMMUNE_ID','LEFT');
//          $this->db->join('zone', 'zone.ID_ZONE='.$table.'.ZONE_ID','LEFT');
//           $this->db->join('enqueteurs', 'enqueteurs.ENQUETEUR_ID='.$table.'.ENQUETEUR');
   
      
//        return $this->db->count_all_results();   
//        }
//   public function get_filtered_data_performance_agents($table,$select_column,$critere_txt,$critere_array,$order_by)
//         {
//       $this->make_query_performance_agents($table,$select_column,$critere_txt,$critere_array,$order_by);
//         $query = $this->db->get();
//         return $query->num_rows();
        
//        }



    //    function insert_simple($requete){
    //   $query=$this->db->query($requete);
    // }










} 