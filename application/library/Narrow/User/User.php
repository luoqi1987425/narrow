<?php 
	class Narrow_User implements Narrow_User_Interface{
		
		/**
		 * register process status
		 */
		const STATUS_WAITING  = 0;
		const STATUS_APPROVAL = 1;
		const STATUS_REJECTED = 2;
		
		/**
		 * role
		 */
		const ROLE_USER	   	   = 1;
		const ROLE_ADMIN	   = 9;
		
		
		private $_plugin_datas;
		
		function __construct(){
			
			$this->_plugin_datas = array();
			
		}
	
		
		public function login($email, $password){
			$this->_login( $email, $password );
		}
		
		public function loginFromCode($code) {
			$this->_loginFromCode( $code );
		}
	
	
		public function getLoginUser() {
			return $this->_getSession();
		}
		
		
		public function isLogined() {
			
			$doctor = $this->_getSession();
			if( $doctor ){
				return true;
			}else{
				return false;
			}	
			
		}

		
		
		public function register($data) {
			
			$broker = Narrow_Plugins_Broker::GetInstance();
			
			$this->_register($data);
			$broker->afterUserRegister($this->_plugin_datas);
			$this->_resetPluginData();
		}
		
		
		public function role($id, $role) {
			
			$broker = Narrow_Plugins_Broker::GetInstance();
			
			$this->_role( $id , $role );
			$broker->afterUserRole( $id , $role );
			
		}
		
		
		public function status($id, $status) {
			
			$broker = Narrow_Plugins_Broker::GetInstance();
			
			$this->_status( $id , $status );
			$broker->afterUserStatus( $id , $status ); 
			
		}
		
		public function getsByStatus($status, $order, $pageNo, $pageSize) {
			
			$conditions = array();
			$conditions['status'] = $status;
			$conditions['email'] = array( '!=' , Narrow::GetInstance()->config->user->default_admin->username );
			
			return $this->gets( $conditions , $order , $pageNo , $pageSize );
			
		}
		
		
		public function getsByStatusCount( $status ) {
		
			$conditions = array();
			$conditions['status'] = $status;
			$conditions['email'] = array( '!=' , Narrow::GetInstance()->config->user->default_admin->username );
			
			return $this->getsCount( $conditions );
		
		}
		
		public function gets( $conditons = null , $order = null , $pageNo = null , $pageSize = null ) {
			
			$userModel = Narrow_User_Model_User::getInstance();
			
			$datas 	= $userModel->getAllByConditions( $conditons, $order, $pageNo , $pageSize);
			$rtn 	= array();
			
			foreach( $datas as $data ){
				$rtn []= new Narrow_User_Entity_User( $data );
			}
			
			return $rtn;
			
		}
		
		public function getsCount( $conditons = null ){
			
			$userModel = Narrow_User_Model_User::getInstance();
			return $userModel->where( $conditons )->count();
		}
		
		
		private function _resetPluginData(){
			
			$this->_plugin_datas = array();
			
		}
		
		private function _login($email, $password) {
			
			$userModel = Narrow_User_Model_User::getInstance();
			$user 	   = $userModel->getOneByConditions( array( 'email' => $email ) );
			$translate = Zend_Registry::get( 'translate' );
			
			if( !$user ){
				throw new Exception( $translate->_("This user does not exist") , 1 );
			}
			
			if($user['status'] != self::STATUS_VERIFIED){
				throw new Exception( $translate->_("This user has not been approved") , 1 );
			}
			
			if( $user['password'] != md5( $password ) ){
				throw new Exception( $translate->_("Incorrect password") , 1 );
			}
			
			$user = new Narrow_User_Entity_User( $user );
			
			$this->_setSession( $user );
			
		}
		
		private function _loginFromCode($code){
			
			$userModel = Narrow_User_Model_User::getInstance();
			
			$translate = Zend_Registry::get( 'translate' );
			
			$user = $userModel->getOneByConditions( array( 'code' => $code ) );
			if( !$user ){
				throw new Exception( $translate->_("This link is expiration") , 1 );
			}
			
			if( $user['is_code_used'] ){
				throw new Exception( $translate->_("This link is expiration") , 1 );
			}
			
			//expire the code
			$userModel->update( array( 'is_code_used' => intval(true) ) , array( "id" => $user['id'] ) );
			
			$user = new Narrow_User_Entity_User( $user );
			$this->_setSession( $user );
			
		}
		
		private function _register( $data ){
			
			$userModel = Narrow_User_Model_User::getInstance();
			$translate = Zend_Registry::get( 'translate');
			
			
			$isEmailExist = $this->_isEmailExist( $data['email'] );
			if( $isEmailExist ){
				//_("Sorry,Email Exist.")
				throw new Exception( $translate->_("Email already exists") );
			}
			
			$data['role']		= self::ROLE_USER;
			$data['status'] 	= self::STATUS_WAITING;
			$data['date_add'] 	= time();

			$id = $userModel->insert( $data );
			
			$data["id"] = $id;
			
			
			//plugin_data
			$this->_plugin_datas['email'] = $data['email'];

			return $data;
			
		}
		
		private function _status( $id, $status ){
			
			$userModel = Narrow_User_Model_User::getInstance();
			
			if( $status == self::STATUS_VERIFIED ){
				$code = $this->_generTempLoginCode();
				$userModel->update( array( "code" => $code , "status" => $status ) , array( "id" => $id ) );
				
			}else{
				$userModel->update( array( "status" => $status ) , array( "id" => $id ) );
			}
			
			
			
			//plugin_data
			$user = $userModel->getOneByConditions( array( 'id' => $id ) );
			$this->_plugin_datas['email'] 	= $user['email'];
			$this->_plugin_datas['status'] 	= $status;
			$this->_plugin_datas['code']  	= $code;
			
		}
		
		private function _role( $id , $role ){
			
			$userModel = Narrow_User_Model_User::getInstance();
			
			$userModel->update( array( "role" => $role ) , array( "id" => $id ) );
			
			//plugin_data
			$user = $userModel->getOneByConditions( array( 'id' => $id ) );
			$this->_plugin_datas['email'] 	= $user['email'];
			$this->_plugin_datas['role'] 	= $role;
		
		}
		
		private function _generTempLoginCode( ){
			
			$code = md5( time() );
			return $code;
		}

		
	}
?>