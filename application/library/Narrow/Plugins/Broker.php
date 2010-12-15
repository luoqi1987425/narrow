<?php 
	class Narrow_Plugins_Broker extends Narrow_Plugins_Event{
		
		/**
		 * 
		 * @return Narrow_Plugins_Broker
		 *
		 */
		public static function GetInstance(){
			
		}
		
		private $_plugins;
		
		public function __construct(){
			
			$this->_plugins = array();
			
		}
		
		public function register( $plugin ){
			
			$this->_plugins[] = $plugin;
			
		}
		
		public function afterUserRegister(){
			
			foreach( $this->_plugins as $plugin ){
				$plugin->afterUserRegister();
			}
			
		}
		
		
		
		
		
		
		
	}
?>