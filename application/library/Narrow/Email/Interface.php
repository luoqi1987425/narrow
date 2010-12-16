<?php 
	interface Narrow_Email_Interface{
		
		
		public function register( $email , $name );
		
		public function registerForAdmin( $admins , $name , $occupation , $place_of_work );
		
		public function approve( $email , $name , $code );
		
		
	}
?>