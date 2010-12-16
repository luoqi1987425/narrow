<?php
	class Narrow
	{
		
		
		private static $_instance;
		
		/**
		 * @return Narrow
		 */
		public static function GetInstance(){
			if( !self::$_instance ){
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		
		public static function CleanCache(){
			
			$cache = Zend_Registry::get( 'cache' );
			$cache->clean();
			
		}
		
		
		public $config;
		
		public function init(){
			$this->_configSystemIni();
			$this->_configPlugins();
			$this->_generDefaultAdmin();
			
		}
		
		
		private function _configSystemIni(){
			$this->config = WeFlex_Application::GetInstance()->configAll->sms;
		}
		
		private function _configPlugins(){
			
				
		}
		
		private function _generDefaultAdmin(){
			
			$userMod = Narrow_User_Factory::Factory();
			$userMod->generDefualtAdminDoctor();
			
		}
		
	}
?>