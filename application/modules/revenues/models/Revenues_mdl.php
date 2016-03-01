<?php

class Revenues_mdl  extends MY_Model {

    public function get_runrate_services_byid($id) {

    $query = $this->db->get_where("runrate_services",array('id'=>$id));
       
    		$result = (object)array();
    		if($query->num_rows() > 0){
					$result = $query->row();
			}		

	 return $result;		
    }
     
    public function get_runrate_nodes_all() {
    		 $this->db->order_by("level","asc");
    $query = $this->db->get("runrate_nodes");
       
    		$result = (object)array();
    		if($query->num_rows() > 0){
					$result = $query->result();
			}		

	 return $result;		
    }
    public function get_runrate_subs_all() {
    		 $this->db->order_by("level","asc");
    $query = $this->db->get_where("runrate_nodes",array('pid'=>0));
      		
    		$result = (object)array();
    		if($query->num_rows() > 0){
					$result = $query->result();
			}		

	 return $result;		
    }
             
}
