<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Revenues extends MY_Controller {

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
    

	public function index(){
					$this->load->view("runrate_revenues");
	}

	public function Issuer_Revenues(){
		$tbody = "";
		$mdl = $this->Revenues_mdl;

		$nodes = $mdl->get_runrate_nodes_all();

		if(count($nodes) > 0 ){

			$this->set($nodes);
			$tbody.=$this->get($nodes);
		}
		$this->set_issuers_revenues();
		$thead = $this->get_issuers_revenues();






		 $json['tbody'] = $tbody;
		 $json['thead'] = $thead;
		 return $json;
	}


	public function revTable(){

		$idata = $this->Issuer_Revenues();
		$mdata = $this->Merch_Acqui();
		$odata = $this->Other_Revenues();
		$tdata = $this->Total_Revenues();

		$json['ithead'] = $idata['thead'];
		$json['itbody'] = $idata['tbody'];

		$json['mthead'] = $mdata['thead'];
		$json['mtbody'] = $mdata['tbody'];

	    $json['othead'] = $odata['thead'];
		$json['otbody'] = $odata['tbody'];

		
	    $json['tthead'] = $tdata['thead'];

		 echo json_encode($json);
		 exit;

	}





public function dlTablexls(){



header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".date_format($this->ydate,"Ym")."_runrate_revenues.xls");
header("Pragma: no-cache");
header("Expires: 0");

flush();		
		$mdl = $this->Revenues_mdl;

		$nodes = $mdl->get_runrate_nodes_all();
		$this->setThead();	
		if(count($nodes) > 0 ){

			$this->set($nodes);
			//$tbody.=$this->get($nodes);
		}
		$this->set_issuers_revenues();

		$nodes = $mdl->get_runrate_nodes_merchAcqui();
	
		if(count($nodes) > 0 ){

			$this->set($nodes);
			//$tbody.=$this->get($nodes);
		}
		$this->set_merchAqui_revenues();
		$nodes = $mdl->get_runrate_nodes_others();
	
		if(count($nodes) > 0 ){

			$this->set($nodes);
			//$tbody.=$this->get($nodes);
		}
		$this->set_others_revenues();
		$this->set_total();
		//$thead = $this->get_issuers_revenues();

		 //$json['tbody'] = $tbody;
		// $json['thead'] = $thead;

		// echo json_encode($json);
		 //exit;
	$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');

    $objWriter->save('php://output');
	

}
public function setThead(){
	$col = 0;
	$row = 1;

//$this->sheet->getCellByColumnAndRow($col, $row)->setCellValue("REVENUE SUMMARY(in PHP 000s)");
             $sA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
                  $this->sheet->setCellValue($sA,"REVENUE SUMMARY(in PHP 000s)");

 for($i=1;$i <= $this->monthNum;$i++){
		$dateObj   = DateTime::createFromFormat('!m', $i);
				 		$monthName = $dateObj->format('M'); 
		$col=$col+1;
		$rA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
                  $this->sheet->setCellValue($rA,$monthName." Rev");
		$col=$col+1;		 		
			$bA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
                  $this->sheet->setCellValue($bA,$monthName." Bud");

		$col=$col+1;		 		
		$vA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
                  $this->sheet->setCellValue($vA,$monthName." Var");
         $col=$col+1;         		 		
		$pA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
                  $this->sheet->setCellValue($pA,$monthName." %");
                  	 		


	 }


}






	public function set($nodes){
		$mdl = $this->Revenues_mdl;

			foreach ($nodes as $key => $node) {

				$id  = $node->id; 
				$sid = $node->sid;
				$pid = $node->pid;
				$level = $node->level;
				$ctype = $node->ctype;
				$services = $mdl->get_runrate_services_byid($sid);
				$name = $services->name;
                 
                 $col = 0;
                 $row = $level+2;
                 $sA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
                  $this->sheet->setCellValue($sA,$name);
                 	
                 for($i=1;$i <= $this->monthNum;$i++){


					
                 	 $col=$col+1;
                 	$rev = $this->ctype_formula($ctype,$col,$id,$i,"Rev");
                 	
		          


		            $rA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($rA,$rev);
	

					$col=$col+1;

					$bud = $this->ctype_formula($ctype,$col,$id,$i,"Bud");
		            $bA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($bA,$bud);
	
					$col=$col+1;
					$var = "=IF(ISERROR(".$rA."-".$bA."),\"\",(".$rA."-".$bA."))";	
					$vA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($vA,$var);

					$col=$col+1;
					$per = "=IF(ISERROR(".$vA."/ABS(".$bA.")),\"\",(".$vA."/ABS(".$bA.")))";	
					$pA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($pA,$per);	
					
				}

		
              


			}

	}

	public function get($nodes){
			$htm = "";
			$mdl = $this->Revenues_mdl;
		foreach ($nodes as $key => $node) {

				$id  = $node->id; 
				$sid = $node->sid;
				$pid = $node->pid;
				$level = $node->level;
				$ctype = $node->ctype;
				$services = $mdl->get_runrate_services_byid($sid);
				$name = $services->name;
                 
                 $htm.="<tr data-tt-id='".$id."' data-tt-parent-id='".$pid."'>";
                 $htm.="<td >".$name."</td>";
                 	$col = 0;
           

                 for($i=1;$i <= $this->monthNum;$i++){


                 	$row = $level+2;
					
                 	 $col=$col+1;
                 

		             $rA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		        
		             $rV=	$this->sheet->getCell($rA)->getCalculatedValue();


					$htm.="<td align='right'>".$rV."</td>";
		
					

					$col=$col+1;

		            $bA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $bV=	$this->sheet->getCell($bA)->getCalculatedValue();	

					
					$htm.="<td align='right'>".$bV."</td>";
					$col=$col+1;
				     $vA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $vV=	$this->sheet->getCell($vA)->getCalculatedValue();	

					$htm.="<td align='right'>".$vV."</tD>";	
					$col=$col+1;
					$pA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $pV=	$this->sheet->getCell($pA)->getCalculatedValue();	
					$htm.="<td align='right'>".$pV."</td>";
				}








                 $htm.="</tr>";
              


			}

			return $htm;
	}
	

	public function get_issuers_revenues(){

		   $htm ="<tr>";
                 $htm.="<th >Issuer Revenues:</th>";
                 	$col = 0;
                 	$level = 0;
           

                 for($i=1;$i <= $this->monthNum;$i++){


                 	$row = $level+2;
					
                 	 $col=$col+1;
                 

		             $rA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		        
		             $rV=	$this->sheet->getCell($rA)->getCalculatedValue();


					$htm.="<th align='center'>".$rV."</th>";
		
					

					$col=$col+1;

		            $bA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $bV=	$this->sheet->getCell($bA)->getCalculatedValue();	

					
					$htm.="<th align='center'>".$bV."</th>";


					$col=$col+1;
				     $vA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $vV=	$this->sheet->getCell($vA)->getCalculatedValue();	

					$htm.="<th align='center'>".$vV."</th>";	
					$col=$col+1;
					$pA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $pV=	$this->sheet->getCell($pA)->getCalculatedValue();	
					$htm.="<th align='center'>".$pV."</th>";
				}

                 $htm.="</tr>";
              
              return $htm;
	}
public function set_issuers_revenues(){
		   

				$level = 0;
				
                 
               $col = 0;
               array_push($this->totalRow,2);
               $sA =   $this->sheet->getCellByColumnAndRow(0, 2)->getCoordinate();
                  $this->sheet->setCellValue($sA,"Issuer Revenues:");

                 for($i=1;$i <= $this->monthNum;$i++){


                 	$row = $level+2;
					
                 	 $col=$col+1;
                 	$rev = $this->issuersRev_formula($col);
                 	
		          


 		            $rA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($rA,$rev);
	

					$col=$col+1;

					$bud = $this->issuersRev_formula($col);
		            $bA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($bA,$bud);
	
					$col=$col+1;
					$var = "=IF(ISERROR(".$rA."-".$bA."),\"\",(".$rA."-".$bA."))";	
										$vA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
							            		$this->sheet->setCellValue($vA,$var);

					$col=$col+1;
					$per = "=IF(ISERROR(".$vA."/ABS(".$bA.")),\"\",(".$vA."/ABS(".$bA.")))";	
					$pA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($pA,$per);	
					
				}

		
              


			

	}
		public function issuersRev_formula($col){
		$mdl = $this->Revenues_mdl;
		$node = $mdl->get_runrate_subs_all();

		$rf = array();	
		foreach ($node as $key => $value) {
					  array_push($rf, $this->sheet->getCellByColumnAndRow($col, Intval($value->level)+2)->getCoordinate());
				
		}
		$data = "=SUM(".implode($rf, ",").")";	


		return $data;	

	}

//===============================================================================
	public function Merch_Acqui(){
		$tbody = "";
		$mdl = $this->Revenues_mdl;

		$nodes = $mdl->get_runrate_nodes_merchAcqui();

		if(count($nodes) > 0 ){

			$this->set($nodes);
			$tbody.=$this->get($nodes);
		}
		$this->set_merchAqui_revenues();
		$thead = $this->get_merchAcui_revenues();






		 $json['tbody'] = $tbody;
		 $json['thead'] = $thead;
		 return $json;
	}

public function set_merchAqui_revenues(){
		   
	$mdl = $this->Revenues_mdl;
	$level = $mdl->get_merchaqui_firstrow()->level;

				$level = $level-1;
				
                    array_push($this->totalRow,$level+2);
               $col = 0;
               $sA =   $this->sheet->getCellByColumnAndRow(0, $level+2)->getCoordinate();
                  $this->sheet->setCellValue($sA,"Merch Acqui:");

                 for($i=1;$i <= $this->monthNum;$i++){


                 	$row = $level+2;
					
                 	 $col=$col+1;
                 	$rev = $this->merchAcqui_formula($col);
                 	
		          


 		            $rA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($rA,$rev);
	

					$col=$col+1;

					$bud = $this->merchAcqui_formula($col);
		            $bA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($bA,$bud);
	
					$col=$col+1;
					$var = "=IF(ISERROR(".$rA."-".$bA."),\"\",(".$rA."-".$bA."))";	
										$vA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
							            		$this->sheet->setCellValue($vA,$var);

					$col=$col+1;
					$per = "=IF(ISERROR(".$vA."/ABS(".$bA.")),\"\",(".$vA."/ABS(".$bA.")))";	
					$pA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($pA,$per);	
					
				}

		
              


			

	}

public function get_merchAcui_revenues(){
	$mdl = $this->Revenues_mdl;
	$level = $mdl->get_merchaqui_firstrow()->level;

		   $htm ="<tr>";
                 $htm.="<th >Merch Acqui:</th>";
                 	$col = 0;
                 	$level = $level-1;
           

                 for($i=1;$i <= $this->monthNum;$i++){


                 	$row = $level+2;
					
                 	 $col=$col+1;
                 

		             $rA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		        
		             $rV =	$this->sheet->getCell($rA)->getCalculatedValue();


					$htm.="<th align='center'>".$rV."</th>";
		
					

					$col=$col+1;

		            $bA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $bV=	$this->sheet->getCell($bA)->getCalculatedValue();	

					
					$htm.="<th align='center'>".$bV."</th>";


					$col=$col+1;
				     $vA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $vV=	$this->sheet->getCell($vA)->getCalculatedValue();	

					$htm.="<th align='center'>".$vV."</th>";	
					$col=$col+1;
					$pA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $pV=	$this->sheet->getCell($pA)->getCalculatedValue();	
					$htm.="<th align='center'>".$pV."</th>";
				}

                 $htm.="</tr>";
              
              return $htm;
	}


	public function merchAcqui_formula($col){
		$mdl = $this->Revenues_mdl;
		$node = $mdl->get_runrate_subs_merchaqui();

		$rf = array();	
		foreach ($node as $key => $value) {
					  array_push($rf, $this->sheet->getCellByColumnAndRow($col, Intval($value->level)+2)->getCoordinate());
				
		}
		$data = "=SUM(".implode($rf, ",").")";	


		return $data;	

	}


//=====================================================


public function Other_Revenues(){
		$tbody = "";
		$mdl = $this->Revenues_mdl;

		$nodes = $mdl->get_runrate_nodes_others();

		if(count($nodes) > 0 ){

			$this->set($nodes);
			$tbody.=$this->get($nodes);
		}
		$this->set_others_revenues();
		$thead = $this->get_others_revenues();






		 $json['tbody'] = $tbody;
		 $json['thead'] = $thead;
		 return $json;
	}

public function set_others_revenues(){
		   
	$mdl = $this->Revenues_mdl;
	$level = $mdl->get_others_firstrow()->level;

				$level = $level-1;
				
                 array_push($this->totalRow, $level+2);
               $col = 0;
               $sA =   $this->sheet->getCellByColumnAndRow(0, $level+2)->getCoordinate();
                  $this->sheet->setCellValue($sA,"Other Revenues:");

                 for($i=1;$i <= $this->monthNum;$i++){


                 	$row = $level+2;
					
                 	 $col=$col+1;
                 	$rev = $this->others_formula($col);
                 	
		          


 		            $rA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($rA,$rev);
	

					$col=$col+1;

					$bud = $this->others_formula($col);
		            $bA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($bA,$bud);
	
					$col=$col+1;
					$var = "=IF(ISERROR(".$rA."-".$bA."),\"\",(".$rA."-".$bA."))";	
										$vA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
							            		$this->sheet->setCellValue($vA,$var);

					$col=$col+1;
					$per = "=IF(ISERROR(".$vA."/ABS(".$bA.")),\"\",(".$vA."/ABS(".$bA.")))";	
					$pA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($pA,$per);	
					
				}

		
              


			

	}

public function get_others_revenues(){
	$mdl = $this->Revenues_mdl;
	$level = $mdl->get_others_firstrow()->level;

		   $htm ="<tr>";
                 $htm.="<th >Other Revenues:</th>";
                 	$col = 0;
                 	$level = $level-1;
           

                 for($i=1;$i <= $this->monthNum;$i++){


                 	$row = $level+2;
					
                 	 $col=$col+1;
                 

		             $rA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		        
		             $rV =	$this->sheet->getCell($rA)->getCalculatedValue();


					$htm.="<th align='center'>".$rV."</th>";
		
					

					$col=$col+1;

		            $bA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $bV=	$this->sheet->getCell($bA)->getCalculatedValue();	

					
					$htm.="<th align='center'>".$bV."</th>";


					$col=$col+1;
				     $vA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $vV=	$this->sheet->getCell($vA)->getCalculatedValue();	

					$htm.="<th align='center'>".$vV."</th>";	
					$col=$col+1;
					$pA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $pV=	$this->sheet->getCell($pA)->getCalculatedValue();	
					$htm.="<th align='center'>".$pV."</th>";
				}

                 $htm.="</tr>";
              
              return $htm;
	}


	public function others_formula($col){
		$mdl = $this->Revenues_mdl;
		$node = $mdl->get_runrate_subs_others();

		$rf = array();	
		foreach ($node as $key => $value) {
					  array_push($rf, $this->sheet->getCellByColumnAndRow($col, Intval($value->level)+2)->getCoordinate());
				
		}
		$data = "=SUM(".implode($rf, ",").")";	


		return $data;	

	}


public function set_total(){
	$mdl = $this->Revenues_mdl;
	$level = $mdl->get_lastrow()->rf;
	$level = $level + 2; 

	$col = 0;
               $sA =   $this->sheet->getCellByColumnAndRow(0, $level+1)->getCoordinate();
                  $this->sheet->setCellValue($sA,"Total Revenues:");

                 for($i=1;$i <= $this->monthNum;$i++){


                 	$row = $level+1;
					
                 	 $col=$col+1;
                 	$rev = $this->total_formula($col);
                 	
		          


 		            $rA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($rA,$rev);
	

					$col=$col+1;

					$bud = $this->total_formula($col);
		            $bA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($bA,$bud);
	
					$col=$col+1;
					$var = "=IF(ISERROR(".$rA."-".$bA."),\"\",(".$rA."-".$bA."))";	
										$vA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
							            		$this->sheet->setCellValue($vA,$var);

					$col=$col+1;
					$per = "=IF(ISERROR(".$vA."/ABS(".$bA.")),\"\",(".$vA."/ABS(".$bA.")))";	
					$pA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		            		$this->sheet->setCellValue($pA,$per);	
					
				}

		
              


}
public function get_total(){
	$mdl = $this->Revenues_mdl;
	$level = $mdl->get_lastrow()->rf;
	$level = $level + 2; 

		   $htm ="<tr>";
                 $htm.="<th >Total Revenues:</th>";
                 	$col = 0;
              
           
                 	$row = $level+1;
                 for($i=1;$i <= $this->monthNum;$i++){


                 	
					
                 	 $col=$col+1;
                 

		             $rA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		        
		             $rV =	$this->sheet->getCell($rA)->getCalculatedValue();


					$htm.="<th align='center'>".$rV."</th>";
		
					

					$col=$col+1;

		            $bA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $bV=	$this->sheet->getCell($bA)->getCalculatedValue();	

					
					$htm.="<th align='center'>".$bV."</th>";


					$col=$col+1;
				     $vA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $vV=	$this->sheet->getCell($vA)->getCalculatedValue();	

					$htm.="<th align='center'>".$vV."</th>";	
					$col=$col+1;
					$pA =   $this->sheet->getCellByColumnAndRow($col, $row)->getCoordinate();
		     
		            $pV=	$this->sheet->getCell($pA)->getCalculatedValue();	
					$htm.="<th align='center'>".$pV."</th>";
				}

                 $htm.="</tr>";
              
              return $htm;
	}

public function Total_Revenues(){
	
		$this->set_total();
		$thead = $this->get_total();






	
		 $json['thead'] = $thead;
		 return $json;
	}

public function total_formula($col){
		
		$node = $this->totalRow;

		$rf = array();	
		foreach ($node as $key => $value) {
					  array_push($rf, $this->sheet->getCellByColumnAndRow($col, Intval($value))->getCoordinate());
				
		}
		$data = "=SUM(".implode($rf, ",").")";	


		return $data;	

	}










	public function ctype_formula($ctype,$col,$id,$i,$cname){

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
					  array_push($rf, $this->sheet->getCellByColumnAndRow($col, Intval($value->row)+2)->getCoordinate());
				
					}
				

					$data1 = "=SUM(".implode($rf, ",").")";	



				}
			
			 



		$sql = "SELECT * FROM(SELECT MIN(level) AS rf,MAX(level) AS rt FROM runrate_nodes WHERE pid=".$id." )
				a WHERE ISNULL(rf)!=1 AND ISNULL(rt)!=1 "; 

				$data2 = "";
				$query = $this->db->query($sql);

				if($query->num_rows() > 0){
					$result = $query->row();
					$rf = $this->sheet->getCellByColumnAndRow($col, Intval($result->rf)+2)->getCoordinate();
					$rt = $this->sheet->getCellByColumnAndRow($col, Intval($result->rt)+2)->getCoordinate();

					$data2 = "=SUM(".$rf.":".$rt.")";	



				}

					switch ($ctype) {
						case 1 :
						return	$data1;
						    case 2:

     					return	$data2;
						    break;
						  
						    default:

						    return intval($data);	
						     
					}


	}
	
        
}
