<?php
	class Data{
		private $_filesToProcess = array();
		public function Data(){}
		
		private function PrepareData(){
			if(is_dir(Config::PATH_DATA)){
				if($handle = opendir(Config::PATH_DATA)) {
				    while (false !== ($entry = readdir($handle))) {
				        if($entry != "." && $entry != ".."){
				        	$this->_filesToProcess[] = $entry;
				        	$this->UnzipFile(Config::PATH_DATA.$entry,Config::PATH_UNZIP);
				        } 
				    }
				    closedir($handle);
				}
				
			}else{
				throw new DataException("Data folder doesn't exist",DataException::ERROR_NO_DATA_DIR);
			}
		}
		
		private function UnzipFile($filePath, $targetFolder){
			$zip = new ZipArchive;
		    $res = $zip->open($filePath);
		    if ($res === TRUE) {
		        $zip->extractTo($targetFolder);
		        $zip->close();
		    } else {
		        throw new DataException("Couldn't unzip file '$filePath'",DataException::ERROR_UNZIP_PROBLEM);
		    }
		}
		
		private function GetData(){
			
		}
	}
	
	class DataException extends Exception{
		const ERROR_NO_DATA_DIR = 100;
		const ERROR_UNZIP_PROBLEM = 101;
		public function __construct($message, $code=0) 
        { 
            parent::__construct($message,$code);
            $ref = (isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:"Not set";
			$browser = (isset($_SERVER['HTTP_USER_AGENT']))?$_SERVER['HTTP_USER_AGENT']:"Not set";
			
			$str = "Referrer: ". $ref;
			$str .= "\nBrowser info: ". $browser;
            $str .= "\nMessage: ".$this->message." / Code: ".$this->code."
            \nFile: ".$this->getFile()." / Line: ".$this->getLine()."
            \nText: ".$this->getTraceAsString(); 
            error_log($str);
        }    

        /* (non-PHPdoc)
         * @see Exception::__toString()
         */
        public function __toString() 
        { 
            return "<div style='background-color:#D00; color:#000; padding:5px; border:1px solid #888;'>
            		<div style='font-weight:bold; background-color:darkorange; border:2px solid #000; padding:3px;'>Message: ".$this->message." / Code: ".$this->code."</div>
            		<div style='font-weight:bold; background-color:darkorange; border:2px solid #000; margin-top:5px; padding:3px;'>File: ".$this->getFile()." / Line: ".$this->getLine()."</div>
            		</div>"; 
        }
	}
?>