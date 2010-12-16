<?php
	class Narrow_Message_Model_Message extends WeFlex_Db_Model{
		
		protected $_tableName = 'message';
		
		
		private static $_instance;
		
		/**
		 * @return Narrow_Message_Model_Message
		 */
		public static function getInstance(){
			if( !self::$_instance ){
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		
		
	}