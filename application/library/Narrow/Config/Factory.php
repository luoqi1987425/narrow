<?php

class Narrow_Config_Factory{
	
	
		private static $_instance;
		
		/**
		 * @return  Narrow_Config_Interface
		 */
		public static function Factory(){
			if( !self::$_instance ){
				self::$_instance = new Narrow_Config_Imple();
			}
			return self::$_instance;
		}
}