<?php 
	interface Narrow_User_Interface{
		
		
		public function register( $data );
		
		public function login( $email , $password );
		
		public function loginFromCode($code);
		
		public function getLoginUser();
		
		public function isLogined();
		
		public function getsByStatus( $status , $order = null , $pageNo = null , $pageSize = null );
		
		public function getsByStatusCount( $status  );
		
		public function getById($id);
		
		public function status( $id , $status );
		
		public function role( $id , $role );
		
		
	}
?>