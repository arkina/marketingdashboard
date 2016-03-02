<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Revenues_01 extends MY_Controller {

	public $totalRow = array();
	  function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->setActiveSheetIndex(0);
		$this->sheet = $this->objPHPExcel->getActiveSheet();
		$this->load->model("Revenues_mdl");
		date_default_timezone_set("Asia/Taipei");	
		$this->ydate=date_create(date("Y-m-d"));
        date_sub($this->ydate,date_interval_create_from_date_string("1 day"));
        $this->monthNum  = intval(date_format($this->ydate,"m"));

    }
    public function jsondata(){
    	$this->set_header();
	    $this->set_body();	

	    $header = $this->get_header();
	    $body   = $this->get_body();
	    $table = array_merge($header,$body);

	    echo "<pre>";
	    echo json_encode($table,JSON_PRETTY_PRINT);	
	
    }

    public function download(){



	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".date_format($this->ydate,"Ym")."_runrate_revenues.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	flush();

	$this->set_header();
	$this->set_body();				

	$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');

    $objWriter->save('php://output');
	

	}
    

	public function set_body(){



		$mdl = $this->Revenues_mdl;
		$result = $mdl->get_runrate_nodes_all();

		foreach ($result as $k => $v) {
			$id   = $v->id;
			$sid  = $v->sid;
			$pid  = $v->pid;
			$lvl  = $v->level;
			$ctyp = $v->ctype; 
			$srvc = $mdl->get_runrate_services_byid($sid);
			$name = $srvc->name;
			$col  = 0;
			$sA   = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
			$this->sheet->setCellValue($sA,$name);
			$this->set($ctyp,$col,$id,$lvl);
				
		}

  }



	public function get_body(){

		$rows = array();
	
		$mdl = $this->Revenues_mdl;
		$result = $mdl->get_runrate_nodes_all();

		foreach ($result as $k => $v) {
		
			$col  = 0;
			$lvl  = $v->level;
			$columns = $this->get($col,$lvl);
			array_push($rows,$columns);
				
		}

		return $rows;

  }
  	public function set_header(){
  		$columns = array("REVENUE SUMMARY(in PHP 000s)");

  		for($i=1;$i<=$this->monthNum;$i++){		
  				$dateObj   = DateTime::createFromFormat('!m', $i);
				$monthName = $dateObj->format('M');

					array_push($columns,$monthName." Rev");
					array_push($columns,$monthName." Bud");
					array_push($columns,$monthName." Var");
					array_push($columns,$monthName." %");

		}
		foreach ($columns as $k => $v) {
			$hA  = $this->sheet->getCellByColumnAndRow($k, 1)->getCoordinate();
				$this->sheet->setCellValue($hA,$v);
		}		 		
  	}

    public function get_header(){
  		$columns = array("REVENUE SUMMARY(in PHP 000s)");
  		$col = 0;	
  		for($i=1;$i<=$this->monthNum;$i++){		
  				
  				$col = $col + 1;
				$rA  = $this->sheet->getCellByColumnAndRow($col, 1)->getCoordinate();
				$col = $col + 1;
				$bA  = $this->sheet->getCellByColumnAndRow($col, 1)->getCoordinate();
				$col = $col + 1;
				$vA  = $this->sheet->getCellByColumnAndRow($col, 1)->getCoordinate();
				$col = $col + 1;
				$pA  = $this->sheet->getCellByColumnAndRow($col, 1)->getCoordinate();


				$rV  =	$this->sheet->getCell($rA)->getCalculatedValue();
		        $bV  =  $this->sheet->getCell($bA)->getCalculatedValue();			
		        $vV  =  $this->sheet->getCell($vA)->getCalculatedValue();			
		        $pV  =  $this->sheet->getCell($pA)->getCalculatedValue();


				array_push($columns,$rV);
				array_push($columns,$bV);
				array_push($columns,$vV);
				array_push($columns,$pV);

		}
		$header = array($columns);
		return $header;
  	}	

	public function set($ctyp,$col,$id,$lvl){

		
			for($i=1;$i<=$this->monthNum;$i++){	
			  
			  $col = $col + 1;			
			  $rA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
			  $rV  = $this->ctype_formula($ctyp,$col,$id,$i,"Rev");
			  
			  $col = $col + 1;
			  $bA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();			
			  $bV  = $this->ctype_formula($ctyp,$col,$id,$i,"Bud");
			  
			  $col = $col + 1;
			  $vA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
			  $vV  = "=IF(ISERROR(".$rA."-".$bA."),\"\",(".$rA."-".$bA."))";	
			  
			  $col = $col + 1;
		      $pA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
		      $pV  = "=IF(ISERROR(".$vA."/ABS(".$bA.")),\"\",(".$vA."/ABS(".$bA.")))";	


					$this->sheet->setCellValue($rA,$rV);
		            $this->sheet->setCellValue($bA,$bV);			
		            $this->sheet->setCellValue($vA,$vV);			
		            $this->sheet->setCellValue($pA,$pV);			
		
			  

			}	

	}
	public function get($col,$lvl){
		$columns = array();

		$sA   = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
			$sV  =	$this->sheet->getCell($sA)->getCalculatedValue();
			
			array_push($columns,$sV);
			for($i=1;$i<=$this->monthNum;$i++){	
			  
			  $col = $col + 1;			
			  $rA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();

			  
			  $col = $col + 1;
			  $bA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();			
			 
			  
			  $col = $col + 1;
			  $vA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
			
			  $col = $col + 1;
		      $pA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();


				$rV  =	$this->sheet->getCell($rA)->getCalculatedValue();
		        $bV  =  $this->sheet->getCell($bA)->getCalculatedValue();			
		        $vV  =  $this->sheet->getCell($vA)->getCalculatedValue();			
		        $pV  =  $this->sheet->getCell($pA)->getCalculatedValue();

		        array_push($columns,$rV);
		        array_push($columns,$bV);
		        array_push($columns,$vV);
		        array_push($columns,$pV);			
		
			}
			return $columns;	

	}
	public function ctype_formula($ctyp,$col,$id,$i,$cname){

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
					  array_push($rf, $this->sheet->getCellByColumnAndRow($col, Intval($value->row))->getCoordinate());
				
					}
				

					$data1 = "=SUM(".implode($rf, ",").")";	



				}
			
			 



		$sql = "SELECT * FROM(SELECT MIN(level) AS rf,MAX(level) AS rt FROM runrate_nodes WHERE pid=".$id." )
				a WHERE ISNULL(rf)!=1 AND ISNULL(rt)!=1 "; 

				$data2 = "";
				$query = $this->db->query($sql);

				if($query->num_rows() > 0){
					$result = $query->row();
					$rf = $this->sheet->getCellByColumnAndRow($col, Intval($result->rf))->getCoordinate();
					$rt = $this->sheet->getCellByColumnAndRow($col, Intval($result->rt))->getCoordinate();

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

	
}
