<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Runrate extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public $data = array();
	public $group = array();
	public $ydate;
	public $monthNum;	
	  function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$this->sheet = $objPHPExcel->getActiveSheet();

    }
    

	public function index(){


   
	
		$this->load->view("runrate_revenues");
	}
	
	public function handsonjson()
	{
		$this->upDateformula0();
		$this->upDateformula1();
		$this->upDateformula2();
		
		$this->ydate=date_create(date("Y-m-d"));
        date_sub($this->ydate,date_interval_create_from_date_string("1 day"));
        $this->monthNum  = intval(date_format($this->ydate,"m"));
		

				$this->data[0] = array('ID','REVENUE SUMMARY(in PHP 000s)');


				$num =1;
				while($num <= $this->monthNum) {
				    
				    	$dateObj   = DateTime::createFromFormat('!m', $num);
				 		$monthName = $dateObj->format('M'); 
				 		array_push($this->data[0],$monthName." Rev");	
				 		array_push($this->data[0],$monthName." Bud");	
				 		array_push($this->data[0],$monthName." Var");	
				 		array_push($this->data[0],$monthName." %");	
				    $num++;
				}

			$this->getData();
		
			
			$json['data'] = $this->data;
			$json['group'] = $this->group;
			$json['monthNum'] = $this->monthNum;	
			echo json_encode($json,JSON_PRETTY_PRINT);
			exit();
	}
	public function getData(){

		$this->ydate=date_create(date("Y-m-d"));
        date_sub($this->ydate,date_interval_create_from_date_string("1 day"));
        $this->monthNum  = intval(date_format($this->ydate,"m"));
		
		$num =1;
		$monthcol = array();
		while($num <= $this->monthNum) {
		    
		    	$dateObj   = DateTime::createFromFormat('!m', $num);
		 		$monthName = strtolower($dateObj->format('M')); 
		 		array_push($monthcol,$monthName."Rev");	
		 		array_push($monthcol,$monthName."Bud");	
		 		array_push($monthcol,$monthName."Var");	
		 		array_push($monthcol,$monthName."Per");	
		    $num++;
		}

		 $monthcolstr = implode($monthcol, ",");	

		$sql = "SELECT a.row_id,a.service_id,a.parent_id,b.serviceName,$monthcolstr FROM `runrate_issuer_nodes` a
			    INNER JOIN `runrate_issuer_revenues` b ON a.service_id = b.id
			    ORDER BY a.row_id";

		$query = $this->db->query($sql);

			if($query->num_rows() > 0){
				$result = $query->result_array();
				foreach ($result as $key => $value) {

					$id = $value['service_id'];	
					$serviceName = $value['serviceName'];
					$colArray = array($id,$serviceName); 
					$rowNumber = intval($value['row_id']);
					
					foreach ($monthcol as $k => $v) {
						array_push($colArray,$value[$v]);

					}
					array_push($this->data,$colArray);
					$this->getGroup($id);
				}

			}

	}
	public function getGroup($id){

		$sql = "SELECT * FROM(SELECT MIN(row_id) AS rf,MAX(row_id) AS rt FROM runrate_issuer_nodes WHERE parent_id=".$id.")
				a WHERE ISNULL(rf)!=1 AND ISNULL(rt)!=1"; 


			$query = $this->db->query($sql);

				if($query->num_rows() > 0){
					$result = $query->row();
					array_push($this->group,array('rows'=>array(Intval($result->rf),intval($result->rt))));
				}

	}

	public function getFormula2($id,$colNumber){


		$sql = "SELECT * FROM(SELECT MIN(row_id) AS rf,MAX(row_id) AS rt FROM runrate_issuer_nodes WHERE parent_id=".$id." )
				a WHERE ISNULL(rf)!=1 AND ISNULL(rt)!=1 "; 

				$data = "";
			$query = $this->db->query($sql);

				if($query->num_rows() > 0){
					$result = $query->row();
					$rf = $this->sheet->getCellByColumnAndRow($colNumber, Intval($result->rf)+1)->getCoordinate();
					$rt = $this->sheet->getCellByColumnAndRow($colNumber, Intval($result->rt)+1)->getCoordinate();

					$data = "=SUM(".$rf.":".$rt.")";	



				}
			return	$data;
			 


	}
	public function getFormula1($id,$colNumber){


		$sql = "SELECT * FROM(SELECT row_id as 'row'  FROM runrate_issuer_nodes WHERE parent_id=".$id." )
				a WHERE ISNULL(`row`)!=1  "; 

				$data = "";
				$query = $this->db->query($sql);
				$rf = array();
				if($query->num_rows() > 0){
					$result = $query->result();
					foreach ($result as $key => $value) {
					  array_push($rf, $this->sheet->getCellByColumnAndRow($colNumber, Intval($value->row)+1)->getCoordinate());
				
					}
				

					$data = "=SUM(".implode($rf, ",").")";	



				}
			return	$data;
			 


	}

	public function upDateformula2(){

		$this->ydate=date_create(date("Y-m-d"));
        date_sub($this->ydate,date_interval_create_from_date_string("1 day"));
        $this->monthNum  = intval(date_format($this->ydate,"m"));
		


		$sql = "SELECT id,service_id,row_id FROM `runrate_issuer_nodes` where rformula=2
			    ORDER BY row_id";

		$query = $this->db->query($sql);

			if($query->num_rows() > 0){
				$result = $query->result_array();
				foreach ($result as $key => $value) {
					 $rowNumber = $value['row_id']+1;
					$id = $value['service_id'];	
					$colNumber=1;
					$num =1;	
					while($num <= $this->monthNum) {
		    
				    	$dateObj   = DateTime::createFromFormat('!m', $num);
				 		$monthName = strtolower($dateObj->format('M')); 

				 		$colNumber=$colNumber + 1;	
				 		$revCoordinate=$this->sheet->getCellByColumnAndRow($colNumber, $rowNumber )->getCoordinate();
						$revformula  = $this->getFormula2($id,$colNumber);


						$colNumber=$colNumber + 1;	
						$budCoordinate=$this->sheet->getCellByColumnAndRow($colNumber,$rowNumber )->getCoordinate();
						$budformula = $this->getFormula2($id,$colNumber);
						

						$colNumber=$colNumber + 1;	
						$varCoordinate=$this->sheet->getCellByColumnAndRow($colNumber, $rowNumber )->getCoordinate();
						$colNumber=$colNumber + 1;	
						$perCoordinate=$this->sheet->getCellByColumnAndRow($colNumber, $rowNumber )->getCoordinate();

						$udata = array(
            				   $monthName."Rev" => $revformula,
            				   $monthName."Bud" => $budformula,
            				   $monthName."Var" => "=".$revCoordinate."-".$budCoordinate,
            				   $monthName."Per" => "=ROUND(".$varCoordinate."/ABS(".$budCoordinate.");2)"

           						 );

						$this->db->where('service_id', $id);
						$this->db->where('id', $value['id']);
						$this->db->update('runrate_issuer_nodes', $udata);

				   		 $num++;
					}

				}

			}

	}
		public function upDateformula1(){

		$this->ydate=date_create(date("Y-m-d"));
        date_sub($this->ydate,date_interval_create_from_date_string("1 day"));
        $this->monthNum  = intval(date_format($this->ydate,"m"));
		


		$sql = "SELECT id,service_id,row_id FROM `runrate_issuer_nodes` where rformula=1
			    ORDER BY row_id";

		$query = $this->db->query($sql);

			if($query->num_rows() > 0){
				$result = $query->result_array();
				foreach ($result as $key => $value) {
					$rowNumber =$value['row_id']+1;
					$id = $value['service_id'];	
					$colNumber=1;
					$num =1;	
					while($num <= $this->monthNum) {
		    
				    	$dateObj   = DateTime::createFromFormat('!m', $num);
				 		$monthName = strtolower($dateObj->format('M')); 

				 		$colNumber=$colNumber + 1;	
				 		$revCoordinate=$this->sheet->getCellByColumnAndRow($colNumber, $rowNumber)->getCoordinate();
						$revformula  = $this->getFormula1($id,$colNumber);


						$colNumber=$colNumber + 1;	
						$budCoordinate=$this->sheet->getCellByColumnAndRow($colNumber, $rowNumber)->getCoordinate();
						$budformula = $this->getFormula1($id,$colNumber);
						
						$colNumber=$colNumber + 1;	

						$varCoordinate=$this->sheet->getCellByColumnAndRow($colNumber, $rowNumber)->getCoordinate();
						$colNumber=$colNumber + 1;	
						$perCoordinate=$this->sheet->getCellByColumnAndRow($colNumber, $rowNumber)->getCoordinate()	;	

						$udata = array(
            				   $monthName."Rev" => $revformula,
            				   $monthName."Bud" => $budformula,
            				   $monthName."Var" => "=".$revCoordinate."-".$budCoordinate,
            				   $monthName."Per" => "=ROUND(".$varCoordinate."/ABS(".$budCoordinate.");2)"

           						 );

						$this->db->where('service_id', $id);
						$this->db->where('id', $value['id']);
						$this->db->update('runrate_issuer_nodes', $udata);

				   		 $num++;
					}

				}

			}

	}
		public function upDateformula0(){

		$this->ydate=date_create(date("Y-m-d"));
        date_sub($this->ydate,date_interval_create_from_date_string("1 day"));
        $this->monthNum  = intval(date_format($this->ydate,"m"));
		


		$sql = "SELECT id,service_id,row_id FROM `runrate_issuer_nodes` where rformula=0
			    ORDER BY row_id";

		$query = $this->db->query($sql);

			if($query->num_rows() > 0){
				$result = $query->result_array();
				foreach ($result as $key => $value) {
					$rowNumber =$value['row_id']+1;
					$id = $value['service_id'];	
					$colNumber=1;
					$num =1;	
					while($num <= $this->monthNum) {
		    
				    	$dateObj   = DateTime::createFromFormat('!m', $num);
				 		$monthName = strtolower($dateObj->format('M')); 

				 		$colNumber=$colNumber + 1;	
				 		$revCoordinate=$this->sheet->getCellByColumnAndRow($colNumber, $rowNumber)->getCoordinate();
					
						$colNumber=$colNumber + 1;	
						$budCoordinate=$this->sheet->getCellByColumnAndRow($colNumber, $rowNumber)->getCoordinate();
					
						$colNumber=$colNumber + 1;	

						$varCoordinate=$this->sheet->getCellByColumnAndRow($colNumber, $rowNumber)->getCoordinate();
						$colNumber=$colNumber + 1;	
						$perCoordinate=$this->sheet->getCellByColumnAndRow($colNumber, $rowNumber)->getCoordinate()	;	

						$udata = array(
            				
            				   $monthName."Var" => "=".$revCoordinate."-".$budCoordinate,
            				   $monthName."Per" => "=ROUND(".$varCoordinate."/ABS(".$budCoordinate.");2)"

           						 );

						$this->db->where('service_id', $id);
						$this->db->where('id', $value['id']);
						$this->db->update('runrate_issuer_nodes', $udata);


				   		 $num++;
					}

				}

			}

	}

	public function addService(){
		$serviceName = $this->input->get_post("serviceName");

		$count = $this->db->get_where("runrate_issuer_revenues",array('serviceName'=>$serviceName))->num_rows();
		if($count==0){
			echo "New Service ".$serviceName;
		}
	}


        
}
