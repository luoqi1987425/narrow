<?php

class Narrow_Email_Factory{
	
	
		private static $_instance;
		
		/**
		 * @return  Narrow_Email_Interface
		 */
		public static function Factory(){
			if( !self::$_instance ){
				self::$_instance = new Narrow_Email();
			}
			return self::$_instance;
		}
}