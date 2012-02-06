<?php
	class Core{
		protected $_configFile = "config/class.config.php";
		
		public function Core(){
			$this->LoadConfig();
		}
		
		public function LoadConfig(){
			if(is_file($this->_configFile)){
				include($this->_configFile);
			}else{
				throw new CoreException("Config file doesn't exist",CoreException::ERROR_NO_CONFIG_FILE);	
			}
		}
		
		public function LoadScriptsForDataMining(){
			include_once Config::PATH_CLASS_DATA;
		}
	}
	
	class CoreException extends Exception{
		const ERROR_NO_CONFIG_FILE = 100;
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