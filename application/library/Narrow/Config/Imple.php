<?php 
	class Narrow_Config_Imple implements Narrow_Config_Interface {
	
		const MESSAGE_NEED_APPROVED = 1;
		
		
		public function get( $enum ){
			
			$configModel = Narrow_Config_Model_Config::getInstance();
			
			$data = $configModel->getOneByConditions( array( "config" => $enum ) , array( "value" ) );
			
			return $data['value'];
		}
	
	
		public function set($enum, $value) {
			
			$configModel = Narrow_Config_Model_Config::getInstance();
			$configModel->update( array( "value" => $value ) , array( "config" => $enum ) );
			
		}
		
		
	
	
		public function init() {
			
			$configModel = Narrow_Config_Model_Config::getInstance();
			$config = $configModel->getOneByConditions(array());
			
			if( !$config ){
				$configModel->insert( array( 'config' =>  self::MESSAGE_NEED_APPROVED , 'value' => intval(true) ) );
			}
			
		}


		
	}
?>