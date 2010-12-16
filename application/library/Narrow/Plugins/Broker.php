<?php 
	class Narrow_Plugins_Broker implements Narrow_Plugins_IEvent{
		
		private static $_instance;
		
		/**
		 * 
		 * @return Narrow_Plugins_Broker
		 *
		 */
		public static function GetInstance(){
			
			if( !self::$_instance ){
				self::$_instance = new self();
			}
			return self::$_instance;
			
		}
		
		private $_plugins;
		
		public function __construct(){
			
			$this->_plugins = array();
			
		}
		
		public function register( Narrow_Plugins_Exts_Abstract $plugin ){
			
			$this->_plugins[] = $plugin;
			
		}
		
		public function afterUserRegister( $data ){
			
			foreach( $this->_plugins as $plugin ){
				$plugin->afterUserRegister( $data );
			}
			
		}
	
	
		public function afterUserRole($data) {
			
			foreach( $this->_plugins as $plugin ){
				$plugin->afterUserRole( $data );
			}
			
		}
		
		
		public function afterUserStatus($data) {
			
			foreach( $this->_plugins as $plugin ){
				$plugin->afterUserStatus( $data );
			}
			
		}
		
		public function afterUserApprove($data) {
			
			foreach( $this->_plugins as $plugin ){
				$plugin->afterUserApprove( $data );
			}
			
		}

		
		
		
		
		
		
		
	}
?>