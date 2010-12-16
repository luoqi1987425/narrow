<?php 
	interface Narrow_Plugins_IEvent{
		
		/**
		 * email
		 * name
		 * occupation
		 * place_of_work
		 * 
		 */
		public function afterUserRegister( $data );
		
		/**
		 * email
		 * status
		 */
		public function afterUserStatus( $data );
		
		/**
		 * email
		 * code
		 */
		public function afterUserApprove( $data );
		
		/**
		 * email
		 * role
		 */
		public function afterUserRole( $data );
		
	}
?>