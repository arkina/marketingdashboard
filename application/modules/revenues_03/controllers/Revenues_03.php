<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Revenues_03 extends MY_Controller {


	  function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model("Revenues_mdl");
		$this->load->library('spreadsheet');

		date_default_timezone_set("Asia/Taipei");	
		$this->ydate=date_create(date("Y-m-d"));
        date_sub($this->ydate,date_interval_create_from_date_string("1 day"));
        $this->monthNum  = intval(date_format($this->ydate,"m"));

            $dateObj   = DateTime::createFromFormat('!m', $this->monthNum);
			$this->monthName = $dateObj->format('M');
        
    }
    public function index(){

    	$data = $this->getSheet();
    	$this->load->view('runrate_revenues',$data);

    }
     public function download(){

    	$data = $this->getSheet();
    	$this->spreadsheet->FILENAME = date_format($this->ydate,"Ym")."_runrate_revenues.xlsx";
    	$this->spreadsheet->objPHPExcel->setActiveSheetIndex(0);
		$this->spreadsheet->PRINT_EXCEL();

    }
    public function getSheet(){
    
    	$this->spreadsheet->NEW_SHEET("Runrate",0);
    	$this->spreadsheet->sheet->getColumnDimension('A')->setAutoSize(true);
    	$header = $this->SET_HEADER("REVENUE SUMMARY(in PHP 000s)");
    	$body   = $this->RUNRATE();
    	$footer = $this->SET_FOOTER("Total Revenues:",0);

    	$data['rhead'] = $this->thead($header);
    	$data['rbody'] = $this->tbody($body);
    	$data['rfoot'] = $this->tfoot($footer);
    	
    	$this->spreadsheet->NEW_SHEET("Acquisition",1);
    	$this->spreadsheet->sheet->getColumnDimension('A')->setAutoSize(true);
    	$header =$this->SET_HEADER("Acquisitions");
    	$body   = $this->ACQUISITION();

    	$data['Acqui_head']=$this->thead($header);
        $data['Acqui_body']=$this->tbody($body);

		$this->spreadsheet->NEW_SHEET("ActiveSubs",2);
		$this->spreadsheet->sheet->getColumnDimension('A')->setAutoSize(true);
    	$header = $this->SET_HEADER("Active Subs / Dongles estimate:");
    	$body   = $this->ACTIVESUBS();
		
		$data['Actvsubs_head']= $this->thead($header);
        $data['Actvsubs_body']= $this->tbody($body);

    	$this->spreadsheet->NEW_SHEET("ARPU",3);
    	$this->spreadsheet->sheet->getColumnDimension('A')->setAutoSize(true);
    	$header = $this->SET_HEADER("Transactional ARPU:");
    	$body   = $this->ARPU();

    	$data['ARPU_head'] = $this->thead($header);
        $data['ARPU_body'] = $this->tbody($body);
		
    	//$this->spreadsheet->objPHPExcel->setActiveSheetIndex(0);
		//$this->spreadsheet->PRINT_EXCEL();

		return $data;
    	


    }

    public function thead($header){

    	$thead = "<thead>";
		foreach ($header as $key => $head) {
			$thead.= "<tr>";	
			$thead.= "<th nowrap><button class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-plus'></i></button></th>";	
			$thead.= "<th nowrap>ID</th>";	
			foreach ($head as $k => $value) {
					$thead.= "<th nowrap>".$value->value."</th>";	
			}
		    $thead.= "</tr>";	
		}
		$thead.= "</thead>";

		return $thead;

    }
    public function tbody($body){
    			$tbody="<tbody>";
		foreach ($body as $key => $td) {
			
		$tbody.="<tr data-tt-id='".$td[0]->id."' data-tt-parent-id='".$td[0]->pid."'>";
		$tbody.= "<td nowrap><button class='btn btn-xs btn-success' 
		onclick=\"javascript:setting('".$td[0]->value."','".$td[0]->id."','".$td[0]->sumIds."','".$td[0]->divisorId."','".$td[0]->ctype."','".$td[0]->indent."','".$td[0]->reporttype."');\"    data-toggle='modal' data-target='#Setting'     ><i class='glyphicon glyphicon-cog'></i></button></td>";	
		$tbody.= "<td nowrap>".$td[0]->id."</td>";	
			foreach ($td as $k => $value) {
			 $cv =	$this->spreadsheet->sheet->getCell($value->coordinate)->getCalculatedValue();
			 $tbody.="<td nowrap>". $cv."</td>";	
			}
		$tbody.="</tr>";
			
		}
		$tbody.="</tbody>";

		return $tbody;
    }
    public function tfoot($footer){
    	$tfoot = "<tfoot>";
		foreach ($footer as $key => $foot) {
			$tfoot.= "<tr>";	
			 $tfoot.="<th nowrap></th>";	
			 $tfoot.="<th nowrap></th>";	
			foreach ($foot as $k => $value) {

			 $cv =	$this->spreadsheet->sheet->getCell($value->coordinate)->getCalculatedValue();
			 $tfoot.="<th nowrap>". $cv."</th>";	
					
			}
		    $tfoot.= "</tr>";	
		}
		$tfoot.= "</tfoot>";
		return $tfoot;
    }

    public function RUNRATE(){

    	$mdl 		= $this->Revenues_mdl;
    	$records 	= $mdl->get_all_runrate_view();
		return $this->SET_ALL_RECORDS($records);


    }
    public function ACQUISITION(){

        $mdl 		= $this->Revenues_mdl;
    	$records 	= $mdl->get_all_acqui_view();
    	return $this->SET_ALL_RECORDS($records);

    

    }
    public function ACTIVESUBS(){
    	$mdl 		= $this->Revenues_mdl;
    	$records 	= $mdl->get_all_activesubs_view();
    	return $this->SET_ALL_RECORDS($records);
    	
    }
    public function ARPU(){
    	$mdl 		= $this->Revenues_mdl;
    	$records 	= $mdl->get_all_arpu_view();
    	return $this->SET_ALL_RECORDS($records);

    }


    public function SET_ALL_RECORDS($records){
    	$rows = array();
    	$totalcount = $records->num_rows(); 
    	$result 	= $records->result_array(); 



    	if($totalcount > 0){
    			
    			foreach ($result as $key => $value) {
    				
    				$this->spreadsheet->row    = $value['level'];
    				$this->spreadsheet->values = array(
    					(object)array('value'=>$value['name'],'indent'=>$value['depth'], 'pid'=>$value['pid'],'id'=>$value['id'],
    						'sumIds'=>$value['sumIds'],'divisorId'=>$value['divisorId'],'ctype'=>$value['ctype'],'reporttype'=>$value['reporttype'])
    						
    					);
    				$sumids = $value['sumIds'];
    				$divisorId =  $value['divisorId'];
    				$ctype = $value['ctype'];
    				$ytd = array();
					$ybtd = array();
     
	    				
	    				for($i=1;$i<=$this->monthNum;$i++){
	    					$dateObj   = DateTime::createFromFormat('!m', $i);
							
							$monthName = strtolower($dateObj->format('M'));
							$col = count($this->spreadsheet->values);
							$suffix = "Rev";
							$rA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();
							array_push($ytd,$rA);
							$rV = $value[$monthName.$suffix];

							if($ctype<>0){

								$rV = $this->CTYPE_FORMULA($ctype,$col,$sumids,$divisorId);
								
							}
	    					
	    					array_push($this->spreadsheet->values,(object)array('value'=>$rV));

	    					$col = count($this->spreadsheet->values);
	    					$suffix = "Bud";
							
							$bA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();
							array_push($ybtd,$bA);
							$bV  = $value[$monthName.$suffix];
							if($ctype<>0){
								$bV = $this->CTYPE_FORMULA($ctype,$col,$sumids,$divisorId);
								
							}

	    					array_push($this->spreadsheet->values,(object)array('value'=>$bV));

	    					$col = count($this->spreadsheet->values);
							$vA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();
	    					$vV  = "=IF(ISERROR(".$rA."-".$bA."),0,(".$rA."-".$bA."))";	
	    					array_push($this->spreadsheet->values,(object)array('value'=>$vV));

	    					$col = count($this->spreadsheet->values);
							$pA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();
	    					$pV  = "=IF(ISERROR(".$vA."/ABS(".$bA.")),0,(".$vA."/ABS(".$bA.")))";	
	    					array_push($this->spreadsheet->values,(object)array('value'=>$pV));

	    					$col = count($this->spreadsheet->values);
							$yrA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();
	    					$yrV  = "=SUM(".implode($ytd,",").")";	
	    					array_push($this->spreadsheet->values,(object)array('value'=>$yrV));

	    					$col = count($this->spreadsheet->values);
							$ybA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();
	    					$ybV  = "=SUM(".implode($ybtd,",").")";	
	    					array_push($this->spreadsheet->values,(object)array('value'=>$ybV));

	    					$col = count($this->spreadsheet->values);
							$yvA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();
	    					$yvV  = "=IF(ISERROR(".$yrA."-".$ybA."),0,(".$yrA."-".$ybA."))";
	    					array_push($this->spreadsheet->values,(object)array('value'=>$yvV));

	    					$col = count($this->spreadsheet->values);
							$ypA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();
	    					$ypV  = "=IF(ISERROR(".$yvA."/ABS(".$ybA.")),0,(".$yvA."/ABS(".$ybA.")))";
	    					array_push($this->spreadsheet->values,(object)array('value'=>$ypV));


	    				}


	    				$this->spreadsheet->SET_ROW();
	    				array_push($rows,$this->spreadsheet->values);
    				
    			}
    		}


    		return $rows;
    }


     public function SET_HEADER($header){

     	$rows = array();
     	$this->spreadsheet->row = 0;
    	$this->spreadsheet->row +=1;
    	$this->spreadsheet->values = array((object)array('value'=>$header));
		

  
		for($i=1;$i<=$this->monthNum;$i++){
    		$dateObj   = DateTime::createFromFormat('!m', $i);
			$monthName = $dateObj->format('M');
				$suffix = "Act";
			if($this->monthName == $monthName){
				$suffix = "Est";
			}
			
			array_push($this->spreadsheet->values,(object)array('value'=>$monthName.$suffix));
			array_push($this->spreadsheet->values,(object)array('value'=>$monthName."Bud"));
			array_push($this->spreadsheet->values,(object)array('value'=>"MTD VAR"));
			array_push($this->spreadsheet->values,(object)array('value'=>"%",'indent'=>0));
			array_push($this->spreadsheet->values,(object)array('value'=>$monthName." YTD ".$suffix));
			array_push($this->spreadsheet->values,(object)array('value'=>$monthName." YTD Bud"));
			array_push($this->spreadsheet->values,(object)array('value'=>$monthName." YTD VAR"));
			array_push($this->spreadsheet->values,(object)array('value'=>$monthName." YTD %"));
		
    	}

		$this->spreadsheet->SET_ROW();
			array_push($rows,$this->spreadsheet->values);
		return $rows;
		
    	    	
    }

 public function SET_FOOTER($name,$rtype){
   	$rows = array(); 
	    $this->spreadsheet->row+=1;
		$this->spreadsheet->values = array((object)array('value'=>$name,'indent'=> 0));
			
		$ytd = array();
		$ybtd = array();
     

		  
				for($i=1;$i<=$this->monthNum;$i++){
		    		$dateObj   = DateTime::createFromFormat('!m', $i);
					$monthName = strtolower($dateObj->format('M'));
					
					$col = count($this->spreadsheet->values);
					$rA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();
					$rV  = $this->TOTAL_FORMULA($col,$rtype);

					array_push($this->spreadsheet->values,(object)array('value'=>$rV,'indent'=>0));

					$col = count($this->spreadsheet->values);
					$bA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();	
					$bV  = $this->TOTAL_FORMULA($col,$rtype);
					
					array_push($this->spreadsheet->values,(object)array('value'=>$bV,'indent'=>0));
					
					$col = count($this->spreadsheet->values);
					$vA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();	
				    $vV  = "=IF(ISERROR(".$rA."-".$bA."),0,(".$rA."-".$bA."))";	

					array_push($this->spreadsheet->values,(object)array('value'=> $vV ,'indent'=>0));
					
					$col = count($this->spreadsheet->values);
					$pA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();
					$pV  = "=IF(ISERROR(".$vA."/ABS(".$bA.")),0,(".$vA."/ABS(".$bA.")))";	
					
					array_push($this->spreadsheet->values,(object)array('value'=>$pV,'indent'=>0));

					array_push($ytd,$rA);
					$col = count($this->spreadsheet->values);
					$yrA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();
					$yrV  = "=SUM(".implode($ytd,",").")";	
					array_push($this->spreadsheet->values,(object)array('value'=>$yrV,'indent'=>0));

					array_push($ybtd,$bA);
					$col = count($this->spreadsheet->values);
					$ybA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();
					$ybV  = "=SUM(".implode($ybtd,",").")";	
					array_push($this->spreadsheet->values,(object)array('value'=>$ybV,'indent'=>0));

					$col = count($this->spreadsheet->values);
					$yvA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();
				    $yvV  = "=IF(ISERROR(".$yrA."-".$ybA."),0,(".$yrA."-".$ybA."))";
					array_push($this->spreadsheet->values,(object)array('value'=>$yvV,'indent'=>0));

					$col = count($this->spreadsheet->values);
					$ypA  = $this->spreadsheet->sheet->getCellByColumnAndRow($col, $this->spreadsheet->row)->getCoordinate();
				    $ypV  = "=IF(ISERROR(".$yvA."/ABS(".$ybA.")),0,(".$yvA."/ABS(".$ybA.")))";
					array_push($this->spreadsheet->values,(object)array('value'=>$ypV,'indent'=>0));


		    	}
			
			$this->spreadsheet->SET_ROW();

			array_push($rows,$this->spreadsheet->values);

			return $rows;

    }


      public function CTYPE_FORMULA($ctyp,$col,$sumids,$divisorId){

		$sql = "SELECT * FROM(SELECT level as 'row'  FROM runrate_nodes WHERE id in(".$sumids.") )
				a WHERE ISNULL(`row`)!=1  "; 

				$data1 = "";
				$query = $this->db->query($sql);
				$rf = array();
				if($query->num_rows() > 0){
					$result = $query->result();
					foreach ($result as $key => $value) {
					  array_push($rf, $this->spreadsheet->sheet->getCellByColumnAndRow($col, Intval($value->row))->getCoordinate());
				
					}
				

					$data1 = "=SUM(".implode($rf, ",").")";	



				}
			
			 



		$sql = "SELECT * FROM(SELECT MIN(level) AS rf,MAX(level) AS rt FROM runrate_nodes WHERE id in(".$sumids."))
				a WHERE ISNULL(rf)!=1 AND ISNULL(rt)!=1 "; 

				$data2 = "";
				$query = $this->db->query($sql);

				if($query->num_rows() > 0){
					$result = $query->row();
					$rf = $this->spreadsheet->sheet->getCellByColumnAndRow($col, Intval($result->rf))->getCoordinate();
					$rt = $this->spreadsheet->sheet->getCellByColumnAndRow($col, Intval($result->rt))->getCoordinate();

					$data2 = "=SUM(".$rf.":".$rt.")";	



				}

					switch ($ctyp) {
						case 1 :
						return	$data1;
						break;
						
						case 2:
						return	$data2;
						break;
						case 3:
						return	 $this->ARPU_FORMULA($col,$sumids,$divisorId);
						break;
			
						     
					}


	}

	public function ARPU_FORMULA($col,$ids,$id){

	   	$rf = array();	
        $sql = "SELECT a.id,a.level FROM `runrate_nodes` a where a.id in(".$ids.") ORDER BY a.level ";

       $query =  $this->db->query($sql);
        $node = (object)array();
            if($query->num_rows() > 0){
                    $node = $query->result();

                    foreach ($node as $key => $value) {
					  array_push($rf, "Runrate!".$this->spreadsheet->sheet->getCellByColumnAndRow($col, Intval($value->level))->getCoordinate());
				
					}
	


            }
            $sql = "SELECT a.id,a.level FROM `runrate_nodes` a where a.id=".$id."  ORDER BY a.level ";     

       $query =  $this->db->query($sql);
       $divisor = "";
             if($query->num_rows() > 0){
                    $row = $query->row();

                $divisor.="/ActiveSubs!". $this->spreadsheet->sheet->getCellByColumnAndRow($col, Intval($row->level))->getCoordinate();
	


            }

            	$data = "=SUM(".implode($rf, ",").")".$divisor;	
        return $data;    
    	}

 public function TOTAL_FORMULA($col,$rtype){
		$mdl = $this->Revenues_mdl;
		$node = $mdl->get_runrate_parents($rtype);

		$rf = array();	
		foreach ($node as $key => $value) {
					  array_push($rf, $this->spreadsheet->sheet->getCellByColumnAndRow($col, Intval($value->level))->getCoordinate());
				
		}
		$data = "=SUM(".implode($rf, ",").")";	


		return $data;	

	}
	public function save_setting(){
		$id = $this->input->post('id');
		$reporttype = $this->input->post('reporttype');

		switch ($reporttype) {
			case 0:
				$table = "runrate_view";
				break;
			case 1:
				$table = "acqui_view";
				break;
			case 2:
				$table = "activesubs_view";
				break;
			case 3:
				$table = "arpu_view";
				break;			
			
		}
		$this->db->db_debug = TRUE;
		$this->db->where('id', $id);
		if(!$this->db->update($table,$this->input->post())){

			$response['message'] = "<i style='color:red'>Failed to save changes</i>";
			$response['code'] = 0;
		}else{
			$response['message'] = "<i style='color:green'>Successfully save</i>";
			$response['code'] = 1;

		}


		echo json_encode($response);
		exit;	
	}
   	
}
