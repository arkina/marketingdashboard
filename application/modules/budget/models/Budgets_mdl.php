<?php

class  Budgets_mdl  extends MY_Model {


     
    public function get_budget_months() {
    
    $sql = "SELECT c.id,a.depth,a.level,b.name,
            c.janBud, c.febBud, c.marBud, c.aprBud, c.mayBud, c.junBud, 
            c.julBud, c.augBud, c.sepBud, c.octBud, c.novBud, c.decBud
            FROM `runrate_nodes` a
            LEFT JOIN `runrate_revenues` c 
            ON a.id=c.nid
            INNER JOIN `runrate_services` b
            ON a.sid = b.id
            ORDER BY a.level;";		
    $query = $this->db->query($sql);
       
    		$result = (object)array();
    		if($query->num_rows() > 0){
					$result = $query->result_array();
			}		

	 return $result;		
    }

	

   




             
}
