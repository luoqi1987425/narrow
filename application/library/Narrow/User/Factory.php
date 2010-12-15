<?php

class Narrow_Message_Factory{
	
	
		private static $_instance;
		
		/**
		 * @return  Narrow_User_Interface
		 */
		public static function Factory(){
			if( !self::$_instance ){
				self::$_instance = new Narrow_User();
			}
			return self::$_instance;
		}
}