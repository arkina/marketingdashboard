<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Budget extends MY_Controller {




	  function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->setActiveSheetIndex(0);
		$this->sheet = $this->objPHPExcel->getActiveSheet();
		$this->sheet->getColumnDimension('A')->setVisible(false);
		$this->sheet->getColumnDimension('B')->setAutoSize(true);
		$this->sheet->getProtection()->setSheet(true);
		$this->load->model("Budgets_mdl");
		date_default_timezone_set("Asia/Taipei");	
		$this->ydate=date_create(date("Y-m-d"));
        date_sub($this->ydate,date_interval_create_from_date_string("1 day"));
        $this->monthNum  = intval(date_format($this->ydate,"m"));


    }


    public function download(){



	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".date_format($this->ydate,"Ym")."_runrate_budgets.xlsx");
	header("Pragma: no-cache");
	header("Expires: 0");

	flush();

	$this->set_header();
	$this->set_body();
	$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');

    $objWriter->save('php://output');
	

	}
	function uploadxlsx()
	{

		
		$config['upload_path'] = './tmp_budget';
        $config['allowed_types'] = 'xlsx';
        $config['detect_mime'] = true;

        $this->upload->initialize($config);
        if (!$this->upload->do_upload("budget-input-700")){
            $data['error'] = 'The following error occured : '.$this->upload->display_errors().'Click on "Remove" and try again!';
            echo json_encode($data); 
        }else{
        	$inputFileName  = "./tmp_budget/".$_FILES['budget-input-700']['name'];
        	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);
			$objPHPExcel = $objReader->load($inputFileName );
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$highestRow = $objWorksheet->getHighestRow(); 
        	
			for($i=2;$i<=$highestRow;$i++){
				$id =  $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
				if(!is_null($id)){
					for($m=1; $m<=12; $m++){
						$k = $m+1;
						$dateObj   = DateTime::createFromFormat('!m', $m);
						$monthName = strtolower($dateObj->format('M'));

						$bV = $objWorksheet->getCellByColumnAndRow($k, $i)->getValue();

						$data = array($monthName."Bud"=>$bV);
						$this->db->where('id', $id);
						$this->db->update('runrate_revenues', $data);  
						

					}
				}

			}

        	echo json_encode("success".$highestRow); 

        }            
	}

	

	public function set_body(){



		$mdl = $this->Budgets_mdl;
		$result = $mdl->get_budget_months();
		$lvl=0; 			
		foreach ($result as $k => $v) {
			$id   = $v['id'];
			$lvl  = $v['level']; 
			$depth = $v['depth'];
			$name = $v['name'];
			$col  = 0;
			$iA   = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
			$col  = $col + 1; 
			$sA   = $this->sheet->getCellByColumnAndRow($col, $lvl)->getCoordinate();
			$this->sheet->setCellValue($iA,$id);
			$this->sheet->setCellValue($sA,$name);
			$this->sheet->getStyle($sA)->getAlignment()->setIndent(intval($depth));
			$this->set($col,$v);
				
		}

		$this->lastRow = $lvl;

  }

  	public function set_header(){
  		$columns = array("ID","REVENUE SUMMARY(in PHP 000s)");

  		for($i=1;$i<=12;$i++){		
  				$dateObj   = DateTime::createFromFormat('!m', $i);
				$monthName = $dateObj->format('M');

					array_push($columns,$monthName."Bud");
					
			

		}
		foreach ($columns as $k => $v) {
			$hA  = $this->sheet->getCellByColumnAndRow($k, 1)->getCoordinate();
				$this->sheet->setCellValue($hA,$v);
		}		 		
  	}


	public function set($col,$v){

	
			for($i=1;$i<=12; $i++){	

				$dateObj   = DateTime::createFromFormat('!m', $i);
				$monthName = strtolower($dateObj->format('M')); 
			  
			  $col = $col + 1;
			  $bA  = $this->sheet->getCellByColumnAndRow($col, $v['level'])->getCoordinate();			
			  $bV  = $v[$monthName.'Bud'];	
			  if(!is_null($bV)){
			  $this->sheet->getStyle($bA)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
		         }
		            $this->sheet->setCellValue($bA,$bV);			
		  

			}	

	}



	
}
