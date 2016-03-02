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
    		 $nodeId = array(108, 109,110,111,112,113,114,115);
			$this->db->where_not_in('id', $nodeId);
    $query = $this->db->get("runrate_nodes");
       
    		$result = (object)array();
    		if($query->num_rows() > 0){
					$result = $query->result();
			}		

	 return $result;		
    }

	

	
    public function get_runrate_subs_all() {
    		 $nodeId = array(108, 109);
			$this->db->where_not_in('id', $nodeId);
    		 $this->db->order_by("level","asc");

    $query = $this->db->get_where("runrate_nodes",array('pid'=>0));
      		
    		$result = (object)array();
    		if($query->num_rows() > 0){
					$result = $query->result();
			}		

	 return $result;		
    }
    public function get_runrate_subs_merchaqui() {
    		 $nodeId = array(108, 109);
			$this->db->where_in('id', $nodeId);
    		 $this->db->order_by("level","asc");

    $query = $this->db->get_where("runrate_nodes",array('pid'=>0));
      		
    		$result = (object)array();
    		if($query->num_rows() > 0){
					$result = $query->result();
			}		

	 return $result;		
    }

      public function get_runrate_nodes_merchAcqui() {
    		 $this->db->order_by("level","asc");
    		 $nodeId = array(108, 109);
			$this->db->where_in('id', $nodeId);
    $query = $this->db->get("runrate_nodes");
       
    		$result = (object)array();
    		if($query->num_rows() > 0){
					$result = $query->result();

			}	
	 return $result;		
    }


    public function get_merchaqui_firstrow() {
    		
    	
    $query = $this->db->get_where("runrate_nodes",array('id'=>108));
      		
    		$result = (object)array();
    		if($query->num_rows() > 0){
					$result = $query->row();
			}		

	 return $result;		
    }


//===================================

    public function get_runrate_subs_others() {
    		 $nodeId = array(1110,111,112,113,114,115);
			$this->db->where_in('id', $nodeId);
    		 $this->db->order_by("level","asc");

    $query = $this->db->get_where("runrate_nodes",array('pid'=>0));
      		
    		$result = (object)array();
    		if($query->num_rows() > 0){
					$result = $query->result();
			}		

	 return $result;		
    }

      public function get_runrate_nodes_others() {
    		 $this->db->order_by("level","asc");
    		 $nodeId = array(110,111,112,113,114,115);
			$this->db->where_in('id', $nodeId);
    $query = $this->db->get("runrate_nodes");
       
    		$result = (object)array();
    		if($query->num_rows() > 0){
					$result = $query->result();

			}	
	 return $result;		
    }


    public function get_others_firstrow() {
    		
    	
    $query = $this->db->get_where("runrate_nodes",array('id'=>110));
      		
    		$result = (object)array();
    		if($query->num_rows() > 0){
					$result = $query->row();
			}		

	 return $result;		
    }

    public function get_lastrow() {
    		
    	
    $query = $this->db->query("SELECT MAX(level) AS rf FROM runrate_nodes");
      		
    		$result = (object)array();
    		if($query->num_rows() > 0){
					$result = $query->row();
			}		

	 return $result;		
    }




             
}
