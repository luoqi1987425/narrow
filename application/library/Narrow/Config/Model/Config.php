<?php
	class Narrow_Config_Model_Config extends WeFlex_Db_Model{
		
		protected $_tableName = 'config';
		
		private static $_instance;
		
		/**
		 * @return Narrow_Config_Model_Config
		 */
		public static function getInstance(){
			if( !self::$_instance ){
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		
		
	}