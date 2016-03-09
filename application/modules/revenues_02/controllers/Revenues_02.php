<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Revenues_02 extends MY_Controller {


	  function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model("Revenues_mdl");
		$this->load->library('excel_sheet');

		date_default_timezone_set("Asia/Taipei");	
		$this->ydate=date_create(date("Y-m-d"));
        date_sub($this->ydate,date_interval_create_from_date_string("1 day"));
        $this->monthNum  = intval(date_format($this->ydate,"m"));
        
    }

    public function index(){

    	$this->excel_sheet->sheet->getColumnDimension('A')->setAutoSize(true);
    	
    	$header = $this->SET_HEADER("REVENUE SUMMARY(in PHP 000s)");
    	$body   = $this->SET_BODY(0);
		$footer = $this->SET_FOOTER("Total Revenues:",0);
		


		$htm="<table>";

		foreach ($body as $key => $td) {
			
		$htm.="<tr data-tt-id='".$td[0]->id."' data-tt-parent-id='".$td[0]->pid."'>";
			foreach ($td as $k => $value) {
			 $htm.="<td>". $value->cvalue."</td>";	
			}
		$htm.="</tr>";
			
		}
		$htm.="</table>";

		echo $htm;


		$this->excel_sheet->row+=1;

    	$this->SET_HEADER("Acquisitions");
    	$this->SET_BODY(1);

    	$this->excel_sheet->row+=1;

    	$this->SET_HEADER("Active Subs / Dongles estimate:");
    	$this->SET_BODY(2);

		$this->excel_sheet->row+=1;

		$this->SET_HEADER("Transactional ARPU:");
		$this->SET_ARPU();


    	//$this->excel_sheet->FILENAME = date_format($this->ydate,"Ym")."_runrate_revenues.xlsx";
		//$this->excel_sheet->PRINT_EXCEL();

    }
     public function SET_HEADER($header){
     	$rows = array();
    	
    	$this->excel_sheet->row +=1;
    	$this->excel_sheet->values = array((object)array('value'=>$header,'indent'=>0));
		

  
		for($i=1;$i<=$this->monthNum;$i++){
    		$dateObj   = DateTime::createFromFormat('!m', $i);
			$monthName = $dateObj->format('M');
			
			array_push($this->excel_sheet->values,(object)array('value'=>$monthName."Est",'indent'=>0));
			array_push($this->excel_sheet->values,(object)array('value'=>$monthName."Bud",'indent'=>0));
			array_push($this->excel_sheet->values,(object)array('value'=>"MTD VAR",'indent'=>0));
			array_push($this->excel_sheet->values,(object)array('value'=>"%",'indent'=>0));
			array_push($this->excel_sheet->values,(object)array('value'=>$monthName." YTD Est",'indent'=>0));
			array_push($this->excel_sheet->values,(object)array('value'=>$monthName." YTD Bud",'indent'=>0));
			array_push($this->excel_sheet->values,(object)array('value'=>$monthName." YTD VAR",'indent'=>0));
			array_push($this->excel_sheet->values,(object)array('value'=>$monthName." YTD %",'indent'=>0));
		

    	}

		$this->excel_sheet->SET_ROW();
		array_push($rows,$this->excel_sheet->values);
		return $rows;
    	    	
    }





    public function SET_BODY($body){
    	$rows = array(); 

    	$mdl = $this->Revenues_mdl;
		
		$result = $mdl->get_runrate_nodes_all($body);			
		
		foreach ($result as $k => $v) {
		
		
			$srvc = $mdl->get_runrate_services_byid( $v->sid );
			$name = $srvc->name;
			$this->excel_sheet->row = $v->level;
		    $this->excel_sheet->values = array((object)array('value'=>$srvc->name,'indent'=> $v->depth,'pid'=>$v->pid,'id'=>$v->id));
				
		    	$ytd = array();
				$ybtd = array();
		  
				for($i=1;$i<=$this->monthNum;$i++){
		    		$dateObj   = DateTime::createFromFormat('!m', $i);
					$monthName = strtolower($dateObj->format('M'));
					
					$col = count($this->excel_sheet->values);
					$rA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
					$rV  = $this->CTYPE_FORMULA($v->ctype,$col,$v->id,$i,"Rev");

					$rCV = $this->excel_sheet->sheet->getCell($rA)->getCalculatedValue();

					array_push($this->excel_sheet->values,(object)array('value'=>$rV,'indent'=>0));

					$col = count($this->excel_sheet->values);
					$bA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();	
					$bV  = $this->CTYPE_FORMULA($v->ctype,$col,$v->id,$i,"Bud");
					
					array_push($this->excel_sheet->values,(object)array('value'=>$bV,'indent'=>0));
					
					$col = count($this->excel_sheet->values);
					$vA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();	
				    $vV  = "=IF(ISERROR(".$rA."-".$bA."),0,(".$rA."-".$bA."))";	

					array_push($this->excel_sheet->values,(object)array('value'=> $vV ,'indent'=>0));
					
					$col = count($this->excel_sheet->values);
					$pA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
					$pV  = "=IF(ISERROR(".$vA."/ABS(".$bA.")),0,(".$vA."/ABS(".$bA.")))";	
					
					array_push($this->excel_sheet->values,(object)array('value'=>$pV,'indent'=>0));

					array_push($ytd,$rA);
					$col = count($this->excel_sheet->values);
					$yrA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
					$yrV  = "=SUM(".implode($ytd,",").")";	
					array_push($this->excel_sheet->values,(object)array('value'=>$yrV,'indent'=>0));

					array_push($ybtd,$bA);
					$col = count($this->excel_sheet->values);
					$ybA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
					$ybV  = "=SUM(".implode($ybtd,",").")";	
					array_push($this->excel_sheet->values,(object)array('value'=>$ybV,'indent'=>0));

					$col = count($this->excel_sheet->values);
					$yvA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
				    $yvV  = "=IF(ISERROR(".$yrA."-".$ybA."),0,(".$yrA."-".$ybA."))";
					array_push($this->excel_sheet->values,(object)array('value'=>$yvV,'indent'=>0));

					$col = count($this->excel_sheet->values);
					$ypA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
				    $ypV  = "=IF(ISERROR(".$yvA."/ABS(".$ybA.")),0,(".$yvA."/ABS(".$ybA.")))";
					array_push($this->excel_sheet->values,(object)array('value'=>$ypV,'indent'=>0));


		    	}
			
			$this->excel_sheet->SET_ROW();
			array_push($rows,$this->excel_sheet->values);
				
		}

		return $rows;
	
    	
    }

    public function SET_ARPU(){
    	$rows = array(); 
    	$arpu[0] = (object)array('name'=>"PAYROLL ARPU",'ids'=>array(8,9,10,11,12,13,14,15,16,17,18,20,21,22,24),'id'=>198,'depth'=>1);
    	$arpu[1] = (object)array('name'=>"LOANS ARPU",'ids'=>array(39,40,41,42,43,44,45,46,47,48,49,51,52,53,55),'id'=>199,'depth'=>1);
    	$arpu[2] = (object)array('name'=>"ALLOWANCE ARPU",'ids'=>array(71,72,73,74,75,76,77,78,79,80,81,83,84,85,87),'id'=>200,'depth'=>1);
    	$arpu[3] = (object)array('name'=>"REGULAR ARPU",'ids'=>array(133,134,135,136,137,138,139,140,141,142,143,144,145,146,147),'id'=>201,'depth'=>1);
    	$arpu[4] = (object)array('name'=>"GLOBE CHARGE ARPU",'ids'=>array(180),'id'=>202,'depth'=>1);
    	$ytd = array();
		$ybtd = array();
		  
    	foreach ($arpu as $key => $value) {
    		 $this->excel_sheet->row+=1;
    		 $this->excel_sheet->values = array((object)array('value'=>$value->name,'indent'=> $value->depth));


				for($i=1;$i<=$this->monthNum;$i++){
		    		$dateObj   = DateTime::createFromFormat('!m', $i);
					$monthName = strtolower($dateObj->format('M'));
					
					$col = count($this->excel_sheet->values);
					$rA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
					$rV  = $this->ARPU_FORMULA($col,$value->ids,$value->id);

					array_push($this->excel_sheet->values,(object)array('value'=>$rV,'indent'=>0));

					$col = count($this->excel_sheet->values);
					$bA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();	
					$bV  = $this->ARPU_FORMULA($col,$value->ids,$value->id);
					
					array_push($this->excel_sheet->values,(object)array('value'=>$bV,'indent'=>0));
					
					$col = count($this->excel_sheet->values);
					$vA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();	
				    $vV  = "=IF(ISERROR(".$rA."-".$bA."),0,(".$rA."-".$bA."))";	

					array_push($this->excel_sheet->values,(object)array('value'=> $vV ,'indent'=>0));
					
					$col = count($this->excel_sheet->values);
					$pA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
					$pV  = "=IF(ISERROR(".$vA."/ABS(".$bA.")),0,(".$vA."/ABS(".$bA.")))";	
					
					array_push($this->excel_sheet->values,(object)array('value'=>$pV,'indent'=>0));

					array_push($ytd,$rA);
					$col = count($this->excel_sheet->values);
					$yrA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
					$yrV  = "=SUM(".implode($ytd,",").")";	
					array_push($this->excel_sheet->values,(object)array('value'=>$yrV,'indent'=>0));

					array_push($ybtd,$bA);
					$col = count($this->excel_sheet->values);
					$ybA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
					$ybV  = "=SUM(".implode($ybtd,",").")";	
					array_push($this->excel_sheet->values,(object)array('value'=>$ybV,'indent'=>0));

					$col = count($this->excel_sheet->values);
					$yvA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
				    $yvV  = "=IF(ISERROR(".$yrA."-".$ybA."),0,(".$yrA."-".$ybA."))";
					array_push($this->excel_sheet->values,(object)array('value'=>$yvV,'indent'=>0));

					$col = count($this->excel_sheet->values);
					$ypA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
				    $ypV  = "=IF(ISERROR(".$yvA."/ABS(".$ybA.")),0,(".$yvA."/ABS(".$ybA.")))";
					array_push($this->excel_sheet->values,(object)array('value'=>$ypV,'indent'=>0));


		    	}
			
			$this->excel_sheet->SET_ROW();
			array_push($rows,$this->excel_sheet->values);
    	}	

    	return $rows;
		
	}	


    public function SET_FOOTER($name,$rtype){
   	$rows = array(); 
	    $this->excel_sheet->row+=1;
		$this->excel_sheet->values = array((object)array('value'=>$name,'indent'=> 0));
			
		$ytd = array();
		$ybtd = array();
     

		  
				for($i=1;$i<=$this->monthNum;$i++){
		    		$dateObj   = DateTime::createFromFormat('!m', $i);
					$monthName = strtolower($dateObj->format('M'));
					
					$col = count($this->excel_sheet->values);
					$rA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
					$rV  = $this->TOTAL_FORMULA($col,$rtype);

					array_push($this->excel_sheet->values,(object)array('value'=>$rV,'indent'=>0));

					$col = count($this->excel_sheet->values);
					$bA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();	
					$bV  = $this->TOTAL_FORMULA($col,$rtype);
					
					array_push($this->excel_sheet->values,(object)array('value'=>$bV,'indent'=>0));
					
					$col = count($this->excel_sheet->values);
					$vA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();	
				    $vV  = "=IF(ISERROR(".$rA."-".$bA."),0,(".$rA."-".$bA."))";	

					array_push($this->excel_sheet->values,(object)array('value'=> $vV ,'indent'=>0));
					
					$col = count($this->excel_sheet->values);
					$pA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
					$pV  = "=IF(ISERROR(".$vA."/ABS(".$bA.")),0,(".$vA."/ABS(".$bA.")))";	
					
					array_push($this->excel_sheet->values,(object)array('value'=>$pV,'indent'=>0));

					array_push($ytd,$rA);
					$col = count($this->excel_sheet->values);
					$yrA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
					$yrV  = "=SUM(".implode($ytd,",").")";	
					array_push($this->excel_sheet->values,(object)array('value'=>$yrV,'indent'=>0));

					array_push($ybtd,$bA);
					$col = count($this->excel_sheet->values);
					$ybA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
					$ybV  = "=SUM(".implode($ybtd,",").")";	
					array_push($this->excel_sheet->values,(object)array('value'=>$ybV,'indent'=>0));

					$col = count($this->excel_sheet->values);
					$yvA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
				    $yvV  = "=IF(ISERROR(".$yrA."-".$ybA."),0,(".$yrA."-".$ybA."))";
					array_push($this->excel_sheet->values,(object)array('value'=>$yvV,'indent'=>0));

					$col = count($this->excel_sheet->values);
					$ypA  = $this->excel_sheet->sheet->getCellByColumnAndRow($col, $this->excel_sheet->row)->getCoordinate();
				    $ypV  = "=IF(ISERROR(".$yvA."/ABS(".$ybA.")),0,(".$yvA."/ABS(".$ybA.")))";
					array_push($this->excel_sheet->values,(object)array('value'=>$ypV,'indent'=>0));


		    	}
			
			$this->excel_sheet->SET_ROW();

			array_push($rows,$this->excel_sheet->values);

			return $rows;

    }

    


   public function CTYPE_FORMULA($ctyp,$col,$id,$i,$cname){

		$dateObj   = DateTime::createFromFormat('!m', $i);
				 		$monthName = strtolower($dateObj->format('M')); 


		$sql = "select * from runrate_revenues where nid = ".$id;

		$data = "";
				$query = $this->db->query($sql);

				if($query->num_rows() > 0){
					$result = $query->row_array();
				
					$data = $result[$monthName.$cname ];	



				}


		$sql = "SELECT * FROM(SELECT level as 'row'  FROM runrate_nodes WHERE pid=".$id." )
				a WHERE ISNULL(`row`)!=1  "; 

				$data1 = "";
				$query = $this->db->query($sql);
				$rf = array();
				if($query->num_rows() > 0){
					$result = $query->result();
					foreach ($result as $key => $value) {
					  array_push($rf, $this->excel_sheet->sheet->getCellByColumnAndRow($col, Intval($value->row))->getCoordinate());
				
					}
				

					$data1 = "=SUM(".implode($rf, ",").")";	



				}
			
			 



		$sql = "SELECT * FROM(SELECT MIN(level) AS rf,MAX(level) AS rt FROM runrate_nodes WHERE pid=".$id." )
				a WHERE ISNULL(rf)!=1 AND ISNULL(rt)!=1 "; 

				$data2 = "";
				$query = $this->db->query($sql);

				if($query->num_rows() > 0){
					$result = $query->row();
					$rf = $this->excel_sheet->sheet->getCellByColumnAndRow($col, Intval($result->rf))->getCoordinate();
					$rt = $this->excel_sheet->sheet->getCellByColumnAndRow($col, Intval($result->rt))->getCoordinate();

					$data2 = "=SUM(".$rf.":".$rt.")";	



				}

					switch ($ctyp) {
						case 1 :
						return	$data1;
						break;
						
						case 2:
						return	$data2;
						break;
						
						default:
						return intval($data);	
						     
					}


	}

	 public function TOTAL_FORMULA($col,$rtype){
		$mdl = $this->Revenues_mdl;
		$node = $mdl->get_runrate_parents($rtype);

		$rf = array();	
		foreach ($node as $key => $value) {
					  array_push($rf, $this->excel_sheet->sheet->getCellByColumnAndRow($col, Intval($value->level))->getCoordinate());
				
		}
		$data = "=SUM(".implode($rf, ",").")";	


		return $data;	

	}

	 public function ARPU_FORMULA($col,$ids,$id){

	   	$rf = array();	
        $sql = "SELECT a.id,a.level FROM `runrate_nodes` a where a.id in(".implode($ids,",").") ORDER BY a.level ";

       $query =  $this->db->query($sql);
        $node = (object)array();
            if($query->num_rows() > 0){
                    $node = $query->result();

                    foreach ($node as $key => $value) {
					  array_push($rf, $this->excel_sheet->sheet->getCellByColumnAndRow($col, Intval($value->level))->getCoordinate());
				
					}
	


            }
            $sql = "SELECT a.id,a.level FROM `runrate_nodes` a where a.id=".$id."  ORDER BY a.level ";     

       $query =  $this->db->query($sql);
       $divisor = "";
             if($query->num_rows() > 0){
                    $row = $query->row();

                $divisor.="/". $this->excel_sheet->sheet->getCellByColumnAndRow($col, Intval($row->level))->getCoordinate();
	


            }

            	$data = "=SUM(".implode($rf, ",").")".$divisor;	
        return $data;    
    	}
   	
}
