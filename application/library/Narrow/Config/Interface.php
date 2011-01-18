<?php 
	interface Narrow_Config_Interface{
		
		public function init();
		
		public function get( $enum );
		
		public function set( $enum , $value );
		
		
	}
?>