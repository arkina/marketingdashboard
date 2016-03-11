<?php


class Spreadsheet extends phpexcel{

public $values = array(); 
public $row = 0;
public $FILENAME;
public $sheet;
public $objPHPExcel;
private $CI;

	  function __construct()
    {
        // Call the Model constructor
       // parent::__construct();
        $this->CI =& get_instance();
		$this->objPHPExcel = new PHPExcel();
		//$this->objPHPExcel->setActiveSheetIndex(1);
		//$this->sheet = $this->objPHPExcel->getActiveSheet();

        
    }


    public function NEW_SHEET($title,$num){

			$this->sheet = $this->objPHPExcel->createSheet($num);	
			$this->sheet->setTitle($title);
    }


    public function SET_ROW(){
       
	       foreach ($this->values as $k => $v) {
				$coordinate  = $this->sheet->getCellByColumnAndRow($k, $this->row)->getCoordinate();
				$this->sheet->setCellValue($coordinate,$v->value);
				$this->values[$k]->coordinate=$coordinate;
				if(isset($v->indent)){
					$this->sheet->getStyle($coordinate)->getAlignment()->setIndent(intval($v->indent));
				}
		   }		
		  
    }
    public function GET_ROW(){
       
       $column = array();
	       foreach ($this->values as $k => $v) {
				$coordinate  = $this->sheet->getCellByColumnAndRow($k, $this->row)->getCoordinate();				
				$value = $this->sheet->getCell($coordinate)->getCalculatedValue();
				$prop = (object)array('coordinate'=>$coordinate,'value'=>$value);
				array_push($column,$prop);
		   }	
		  return $column; 	
    }

    public function PRINT_EXCEL(){
    	header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$this->FILENAME);
		header("Pragma: no-cache");
		header("Expires: 0");
        flush();
    	
    	$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
    }
}
