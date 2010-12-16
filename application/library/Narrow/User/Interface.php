<?php 
	interface Narrow_User_Interface{
		
		
		public function register( $data );
		
		public function login( $email , $password );
		
		public function loginFromCode($code);
		
		public function getLoginUser();
		
		public function isLogined();
		
		public function logout();
		
		public function getsByStatus( $status , $order = null , $pageNo = null , $pageSize = null );
		
		public function getsByStatusCount( $status  );
		
		public function getById($id);
		
		public function gets( $conditons = null , $order = null , $pageNo = null , $pageSize = null );
		
		//only change status
		public function status( $id , $status );
		
		//change status from waiting to approval
		public function approve( $id );
		
		public function role( $id , $role );
		
		//if code, then expire code
		public function changeLoginUserPassword( $newpassword , $code = null );
		
		public function isEmailExist( $email );
		
		public function generDefualtAdminDoctor();
		
		
	}
?>