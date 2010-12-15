<?php 
	abstract class Narrow_Plugins_Event{
		
		/**
		 * email
		 * name
		 */
		abstract public function afterUserRegister( $data );
		
		/**
		 * email
		 * status
		 * code // if status == approved
		 */
		abstract public function afterUserStatus( $data );
		
		/**
		 * email
		 * role
		 */
		abstract public function afterUserRole( $data );
		
	}
?>