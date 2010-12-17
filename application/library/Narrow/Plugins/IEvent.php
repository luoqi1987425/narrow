<?php 
	interface Narrow_Plugins_IEvent{
		
		/**
		 * email
		 * name
		 * job_desc
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
		 * name
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