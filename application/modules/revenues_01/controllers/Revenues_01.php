<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Revenues_01 extends MY_Controller {

	public $totalRow = array();
	public $lastRow = 0;


	  function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->setActiveSheetIndex(0);
		$this->sheet = $this->objPHPExcel->getActiveSheet();
		$this->sheet->getColumnDimension('A')->setAutoSize(true);
		$this->load->model("Revenues_mdl");
		date_default_timezone_set("Asia/Taipei");	
		$this->ydate=date_create(date("Y-m-d"));
        date_sub($this->ydate,date_interval_create_from_date_string("1 day"));
        $this->monthNum  = intval(date_format($this->ydate,"m"));

        
    }

    
    public function index(){
    	$this->set_header(0);
	    $this->set_body(0);	
	    $this->set_footer();

	    $data['header'] = $this->get_header(0);
	    $data['body']   = $this->get_body(0);
	    $data['footer'] = $this->get_footer();
	    
	    $this->lastRow = $this->lastRow + 1;

	    $this->set_header(1);
	    $this->set_body(1);	

	  	$data['acqui_header'] = $this->get_header(1);
	    $data['acqui_body']   = $this->get_body(1);  
	  

	     $this->load->view("runrate_revenues",$data);	
	
    }


    public function download(){



	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".date_format($this->ydate,"Ym")."_runrate_revenues.xlsx");
	header("Pragma: no-cache");
	header("Expires: 0");

	flush();
	$this->lastRow = 0;		
	$this->set_header(0);
	$this->set_body(0);
	$this->set_footer();
	$this->lastRow = $this->lastRow + 1;				
	$this->set_header(1);
	$this->set_body(1);	

	$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');

    $objWriter->save('php://output');
	

	}
 
 	public function set_header($rtype){
 		$header[0] = "REVENUE SUMMARY(in PHP 000s)";
 		$header[1] = "Acquisitions";
  		$columns = array($header[$rtype]);
  		$level = $this->lastRow+1;	

  		for($i=1;$i<=$this->monthNum;$i++){		
  				$dateObj   = DateTime::createFromFormat('!m', $i);
				$monthName = $dateObj->format('M');

					array_push($columns,$monthName."Est");
					array_push($columns,$monthName."Bud");
					array_push($columns,"MTD Var");
					array_push($columns," %");
					array_push($columns,$monthName." YTD Est");
					array_push($columns,$monthName." YTD Bud");
					array_push($columns,$monthName." YTD Var");
					array_push($columns,$monthName." YTD %");

			

		}
		foreach ($columns as $k => $v) {
			$hA  = $this->sheet->getCellByColumnAndRow($k, $level)->getCoordinate();
				$this->sheet->setCellValue($hA,$v);
		}		 		
  	}
	public function set_body($rtype){

		$mdl = $this->Revenues_mdl;
		$result = $mdl->get_runrate_nodes_all($rtype);
		$lvl=0; 			
		foreach ($result as $k => $v) {
			$id   = $v->id;
			$sid  = $v->sid;
			$pid  = $v->pid;
			$lvl  = $v->level;
			$ctyp = $v->ctype; 
			$depth = $v->depth;
			$srvc = $mdl->get_runrate_services_byid($sid);
			$name = $srvc->name;
			$col  = 0;
			$sA   = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
			$this->sheet->setCellValue($sA,$name);
			$this->sheet->getStyle($sA)->getAlignment()->setIndent(intval($depth));
			
			$this->set($ctyp,$col,$id,$lvl);
				
		}

		$this->lastRow = $lvl;

  }


public function set($ctyp,$col,$id,$lvl){

		$ytd = array();
		$ybtd = array();
			for($i=1;$i<=$this->monthNum;$i++){	
			  
			  $col = $col + 1;			
			  $rA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
			  $rV  = $this->ctype_formula($ctyp,$col,$id,$i,"Rev");
			  
			  $col = $col + 1;
			  $bA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();			
			  $bV  = $this->ctype_formula($ctyp,$col,$id,$i,"Bud");
			  
			  $col = $col + 1;
			  $vA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
			  $vV  = "=IF(ISERROR(".$rA."-".$bA."),0,(".$rA."-".$bA."))";	
			  
			  $col = $col + 1;
		      $pA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
		      $pV  = "=IF(ISERROR(".$vA."/ABS(".$bA.")),0,(".$vA."/ABS(".$bA.")))";	

		      $col = $col + 1;
		      $yA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
		        array_push($ytd,$rA);
		      $yV  = "=SUM(".implode($ytd,",").")";	

		      $col = $col + 1;
		      $ybA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
		        array_push($ybtd,$bA);
		      $ybV  = "=SUM(".implode($ybtd,",").")";	

		      $col = $col + 1;
		      $yvA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();	 
		      $yvV  = "=IF(ISERROR(".$yA."-".$ybA."),0,(".$yA."-".$ybA."))";

		      $col = $col + 1;
		      $ypA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();	 
		      $ypV  = "=IF(ISERROR(".$yvA."/ABS(".$ybA.")),0,(".$yvA."/ABS(".$ybA.")))";		


					$this->sheet->setCellValue($rA,$rV);
		            $this->sheet->setCellValue($bA,$bV);			
		            $this->sheet->setCellValue($vA,$vV);			
		            $this->sheet->setCellValue($pA,$pV);			
		            $this->sheet->setCellValue($yA,$yV);			
		            $this->sheet->setCellValue($ybA,$ybV);			
		            $this->sheet->setCellValue($yvA,$yvV);			
		            $this->sheet->setCellValue($ypA,$ypV);			
		
			  

			}	

	}

	
  
  		public function set_footer(){
	    $level = $this->lastRow + 1;
	     $this->lastRow = $level;
		$col = 0;
	               $sA  =  $this->sheet->getCellByColumnAndRow(0, $level)->getCoordinate();
               $this->sheet->setCellValue($sA,"Total Revenues:");
		$ytd = array();
		$ybtd = array();
                 for($i=1;$i <= $this->monthNum;$i++){


                 	
					
                 	 $col=$col+1;
                
 		            $rA =   $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();
		            $rV = $this->total_formula($col);	
	
					$col=$col+1;

		            $bA =   $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();
		            $bV = $this->total_formula($col);		
	
					$col=$col+1;
						
					$vA =   $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();
					$vV = "=IF(ISERROR(".$rA."-".$bA."),0,(".$rA."-".$bA."))";		            		

					$col=$col+1;
					
					$pA =   $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();
		            $pV = "=IF(ISERROR(".$vA."/ABS(".$bA.")),0,(".$vA."/ABS(".$bA.")))";

		            $col=$col+1;
					
					$yA =   $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();				
		              array_push($ytd,$rA);
		      		$yV  = "=SUM(".implode($ytd,",").")";
		      		$col=$col+1;	
		      		$ybA =   $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();				
		              array_push($ybtd,$bA);
		      	        $ybV  = "=SUM(".implode($ybtd,",").")";		
		      	      $col = $col + 1;
			      $yvA  = $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();	 
			      $yvV  = "=IF(ISERROR(".$yA."-".$ybA."),0,(".$yA."-".$ybA."))";

			      $col = $col + 1;
			      $ypA  = $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();	 
			      $ypV  = "=IF(ISERROR(".$yvA."/ABS(".$ybA.")),0,(".$yvA."/ABS(".$ybA.")))";		

   

		            			$this->sheet->setCellValue($rA,$rV);
		            			$this->sheet->setCellValue($bA,$bV);
		            			$this->sheet->setCellValue($vA,$vV);
		            			$this->sheet->setCellValue($pA,$pV);
		            			$this->sheet->setCellValue($yA,$yV);
		            			$this->sheet->setCellValue($ybA,$ybV);
		            			$this->sheet->setCellValue($yvA,$yvV);
		            			$this->sheet->setCellValue($ypA,$ypV);
					
				}


		}


    public function get_header($rtype){
    	$header[0] = "REVENUE SUMMARY(in PHP 000s)";
 		$header[1] = "Acquisitions";
  		
  		$columns = array("");
  		$col = 0;	
  		$htm="<tr><th nowrap>".$header[$rtype]."</th>";
  		for($i=1;$i<=$this->monthNum;$i++){		
  				
  				$col = $col + 1;
				$rA  = $this->sheet->getCellByColumnAndRow($col, 1)->getCoordinate();
				$col = $col + 1;
				$bA  = $this->sheet->getCellByColumnAndRow($col, 1)->getCoordinate();
				$col = $col + 1;
				$vA  = $this->sheet->getCellByColumnAndRow($col, 1)->getCoordinate();
				$col = $col + 1;
				$pA  = $this->sheet->getCellByColumnAndRow($col, 1)->getCoordinate();
				$col = $col + 1;
				$yA  = $this->sheet->getCellByColumnAndRow($col, 1)->getCoordinate();
				$col = $col + 1;
				$ybA  = $this->sheet->getCellByColumnAndRow($col, 1)->getCoordinate();
				$col = $col + 1;
				$yvA  = $this->sheet->getCellByColumnAndRow($col, 1)->getCoordinate();
				$col = $col + 1;
				$ypA  = $this->sheet->getCellByColumnAndRow($col, 1)->getCoordinate();


				$rV  =	$this->sheet->getCell($rA)->getCalculatedValue();
		        $bV  =  $this->sheet->getCell($bA)->getCalculatedValue();			
		        $vV  =  $this->sheet->getCell($vA)->getCalculatedValue();			
		        $pV  =  $this->sheet->getCell($pA)->getCalculatedValue();
		        $yV  =  $this->sheet->getCell($yA)->getCalculatedValue();
		        $ybV  =  $this->sheet->getCell($ybA)->getCalculatedValue();
		        $yvV  =  $this->sheet->getCell($yvA)->getCalculatedValue();
		        $ypV  =  $this->sheet->getCell($ypA)->getCalculatedValue();

		        $htm.="<th nowrap>".$rV."</th>";
		        $htm.="<th nowrap>".$bV."</th>";
		        $htm.="<th nowrap>".$vV."</th>";
		        $htm.="<th nowrap>".$pV."</th>";
		        $htm.="<th nowrap>".$yV."</th>";
		        $htm.="<th nowrap>".$ybV."</th>";
		        $htm.="<th nowrap>".$yvV."</th>";
		        $htm.="<th nowrap>".$ypV."</th>";


		}
		$htm.="</tr>";
		return $htm;
  	}	
  	public function get_body($rtype){

	
		$mdl = $this->Revenues_mdl;
		$result = $mdl->get_runrate_nodes_all($rtype);
		$htm="";
		foreach ($result as $k => $v) {
			$id   = $v->id;
			$sid  = $v->sid;
			$pid  = $v->pid;
			$lvl  = $v->level;
			$ctyp = $v->ctype; 
		
			$col  = 0;
			$htm.=$this->get($id,$pid,$col,$lvl);
			
				
		}

		return $htm;

  }
  	
	public function get($id,$pid,$col,$lvl){
		   $htm = "";

		    $sA   = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
			$sV  =	$this->sheet->getCell($sA)->getCalculatedValue();
			 
                 $htm.="<tr data-tt-id='".$id."' data-tt-parent-id='".$pid."'>";
                 $htm.="<td nowrap>".$sV."</td>";

			for($i=1;$i<=$this->monthNum;$i++){	
			  
			  $col = $col + 1;			
			  $rA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();

			  
			  $col = $col + 1;
			  $bA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();			
			 
			  
			  $col = $col + 1;
			  $vA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
			
			  $col = $col + 1;
		      $pA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();

		      $col = $col + 1;
		      $yA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();


		      $col = $col + 1;
		      $ybA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();

			  $col = $col + 1;
		      $yvA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();

		      $col = $col + 1;
		      $ypA  = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
	


				$rV  =	$this->sheet->getCell($rA)->getCalculatedValue();
		        $bV  =  $this->sheet->getCell($bA)->getCalculatedValue();			
		        $vV  =  $this->sheet->getCell($vA)->getCalculatedValue();			
		        $pV  =  $this->sheet->getCell($pA)->getCalculatedValue();
		        $yV  =  $this->sheet->getCell($yA)->getCalculatedValue();
		        $ybV  =  $this->sheet->getCell($ybA)->getCalculatedValue();
		        $yvV  =  $this->sheet->getCell($yvA)->getCalculatedValue();
		        $ypV  =  $this->sheet->getCell($ypA)->getCalculatedValue();

		        $htm.="<td align='right'>".$rV."</td>";
		        $htm.="<td align='right'>".$bV."</td>";
		        $htm.="<td align='right'>".$vV."</td>";
		        $htm.="<td align='right'>".$pV."</td>";
		        $htm.="<td align='right'>".$yV."</td>";
		        $htm.="<td align='right'>".$ybV."</td>";
		        $htm.="<td align='right'>".$yvV."</td>";
		        $htm.="<td align='right'>".$ypV."</td>";
		      			
		
			}
			$htm.="</tr>";
			return $htm;	

	}
	public function get_footer(){
		   $htm = "";
		   	$col= 0;
		  	$level = $this->lastRow;
	
		    $sA   = $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();
			$sV  =	$this->sheet->getCell($sA)->getCalculatedValue();
			 
                 $htm.="<tr>";
                 $htm.="<th>".$sV."</th>";

			for($i=1;$i<=$this->monthNum;$i++){	
			  
			  $col = $col + 1;			
			  $rA  = $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();

			  
			  $col = $col + 1;
			  $bA  = $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();			
			 
			  
			  $col = $col + 1;
			  $vA  = $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();
			
			  $col = $col + 1;
		      $pA  = $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();
		      $col = $col + 1;
		      $yA  = $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();

		      $col = $col + 1;
		      $ybA  = $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();

		      $col = $col + 1;
		      $yvA  = $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();

		      $col = $col + 1;
		      $ypA  = $this->sheet->getCellByColumnAndRow($col, $level)->getCoordinate();


				$rV  =	$this->sheet->getCell($rA)->getCalculatedValue();
		        $bV  =  $this->sheet->getCell($bA)->getCalculatedValue();			
		        $vV  =  $this->sheet->getCell($vA)->getCalculatedValue();			
		        $pV  =  $this->sheet->getCell($pA)->getCalculatedValue();
		        $yV  =  $this->sheet->getCell($yA)->getCalculatedValue();
		        $ybV  =  $this->sheet->getCell($ybA)->getCalculatedValue();
		        $yvV  =  $this->sheet->getCell($yvA)->getCalculatedValue();
		        $ypV  =  $this->sheet->getCell($ypA)->getCalculatedValue();

		        $htm.="<th align='center'>".$rV."</th>";
		        $htm.="<th align='center'>".$bV."</th>";
		        $htm.="<th align='center'>".$vV."</th>";
		        $htm.="<th align='center'>".$pV."</th>";
		        $htm.="<th align='center'>".$yV."</th>";
		        $htm.="<th align='center'>".$ybV."</th>";
		        $htm.="<th align='center'>".$yvV."</th>";
		        $htm.="<th align='center'>".$ypV."</th>";
		      			
		
			}
			$htm.="</tr>";
			return $htm;	

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

              
		public function total_formula($col){
		$mdl = $this->Revenues_mdl;
		$node = $mdl->get_runrate_parents(0);

		$rf = array();	
		foreach ($node as $key => $value) {
					  array_push($rf, $this->sheet->getCellByColumnAndRow($col, Intval($value->level))->getCoordinate());
				
		}
		$data = "=SUM(".implode($rf, ",").")";	


		return $data;	

	   }




	
}
