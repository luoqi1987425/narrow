<?php 
	interface Narrow_Email_Interface{
		
		
		public function register( $email , $name );
		
		public function registerForAdmin( $email );
		
		public function approve( $email , $code );
		
		
	}
?>