<?php

class Narrow_Message_Factory{
	
	
		private static $_instance;
		
		/**
		 * @return  Narrow_Message_Interface
		 */
		public static function Factory(){
			if( !self::$_instance ){
				self::$_instance = new Narrow_Message_Imple();
			}
			return self::$_instance;
		}
}