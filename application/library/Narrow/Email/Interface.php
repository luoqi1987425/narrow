<?php 
	interface Narrow_Email_Interface{
		
		
		public function register( $email , $name );
		
		public function registerForAdmin( $admins , $name , $job_desc  );
		
		public function approve( $email , $name , $code );
		
		
	}
?>