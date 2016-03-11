<?php

class Revenues_mdl  extends MY_Model {


     
    public function get_all_runrate_view() {
    	   $this->db->order_by("level","asc");
        $query = $this->db->get("runrate_view");
       
    	

	 return $query;		
    }

    public function get_all_acqui_view() {
           $this->db->order_by("level","asc");
        $query = $this->db->get("acqui_view");
       
        

     return $query;     
    }
    public function get_all_activesubs_view() {
           $this->db->order_by("level","asc");
        $query = $this->db->get("activesubs_view");
       
        

     return $query;     
    }
        public function get_all_arpu_view() {
           $this->db->order_by("level","asc");
    $query = $this->db->get("arpu_view");
       
        

     return $query;     
    }


      public function get_runrate_parents($reportType) {
        
             $this->db->order_by("level","asc");

    $query = $this->db->get_where("runrate_nodes",array('pid'=>0,'reporttype'=>$reportType));
            
            $result = (object)array();
            if($query->num_rows() > 0){
                    $result = $query->result();
            }       

     return $result;        
    }

	

	


   




             
}
