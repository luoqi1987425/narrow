<?php

class Narrow_User_Factory{
	
	
		private static $_instance;
		
		/**
		 * @return  Narrow_User_Interface
		 */
		public static function Factory(){
			if( !self::$_instance ){
				self::$_instance = new Narrow_User_Imple();
			}
			return self::$_instance;
		}
}