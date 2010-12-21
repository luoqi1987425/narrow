<?php 
	class Narrow_User_Imple implements Narrow_User_Interface{
		
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
		
		
		const SESSION_NAME_SPACE = 'narrow-user';
		
		
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
	
	
		public function logout() {
			$this->_setSession( null );
		}


		
		
		public function register($data) {
			
			$broker = Narrow_Plugins_Broker::GetInstance();
			
			$this->_register($data);
			$broker->afterUserRegister($this->_plugin_datas);
			$this->_resetPluginData();
		}
	
	
		public function edit($data) {
			$this->_edit($data);
		}

		
		
		public function role($id, $role) {
			
			$broker = Narrow_Plugins_Broker::GetInstance();
			
			$this->_role( $id , $role );
			$broker->afterUserRole( $this->_plugin_datas );
			
		}
		
		
		public function status($id, $status) {
			
			$broker = Narrow_Plugins_Broker::GetInstance();
			
			$this->_status( $id , $status );
			$broker->afterUserStatus( $this->_plugin_datas ); 
			
		}
	
	
		public function approve($id) {
			
			$broker = Narrow_Plugins_Broker::GetInstance();
			
			$this->_approve( $id );
			$broker->afterUserApprove( $this->_plugin_datas ); 
			
		}

		
		public function getsByStatus($status , $order = null , $pageNo = null , $pageSize = null) {
			
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
	
	
		public function getById($id) {
			
			$userModel = Narrow_User_Model_User::getInstance();
			
			$user = $userModel->getOneByConditions( array( 'id' => $id ) );
			
			$rtn = new Narrow_User_Entity_User( $user );
			
			return $rtn;
		}
	
	
		public function changeLoginUserPassword( $newpassword , $code = null ) {
			
			$userModel = Narrow_User_Model_User::getInstance();
			
			$loginUser = $this->getLoginUser();
			if( !$loginUser ){
				throw new Exception( "you should login" );
			}
			
			$userModel->update( array( "password" => md5( $newpassword )  ) , array( "id" => $loginUser['id'] ) );
			
			if( $code ){
				//expire the code
				$userModel->update( array( 'is_code_used' => intval(true) ) , array( "id" => $loginUser['id'] ) );
			}
			
			
		}
	

		public function isLoginUserRole($role) {
			
			$loginUser = $this->getLoginUser();
			
			if( $loginUser['role'] == $role ){
				return true;
			}else{
				return false;
			}
			
		}


	
	
		public function isEmailExist($email) {
			
			$isEmailExist = $this->_isEmailExist( $email );
			
			return $isEmailExist;
			
		}
		
		public function generDefualtAdminDoctor() {
			
			$userModel = Narrow_User_Model_User::getInstance();
			$default_admin_account 	= Narrow::GetInstance()->config->user->default_admin->username;
			$default_admin_password = Narrow::GetInstance()->config->user->default_admin->password;
			$isExist = $this->_isEmailExist( $default_admin_account );
			
			if( !$isExist ){
				
				
				$data = array();
				$data['first_name']		= 'Administrator';
				$data['last_name']		= 'Administrator';
				$data['email'] 		= $default_admin_account;   
				$data['status']		= self::STATUS_APPROVAL;
				$data['role'] 		= self::ROLE_ADMIN;
				$data['password']	= md5( $default_admin_password );
				$data['date_add'] 	= time();
	
				$userModel->insert( $data );
				
				
			}
			
			
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
			
			if($user['status'] != self::STATUS_APPROVAL){
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
				throw new Exception( $translate->_("This link is expired") , 1 );
			}
			
			if( $user['is_code_used'] ){
				throw new Exception( $translate->_("This link is expired") , 1 );
			}
			
			$user = new Narrow_User_Entity_User( $user );
			$this->_setSession( $user );
			
		}
		
		private function _edit( $data ){
			
			$userModel = Narrow_User_Model_User::getInstance();
			$translate = Zend_Registry::get( 'translate');
			
			$id = $data['id'];
			unset($data['id']);
			
			
			//check email
			$beforeUser = $userModel->getOneByConditions( array( "id" => $id ) );
			if( $data['email'] == $beforeUser['email'] || !$data['email'] ){
				unset( $data['email'] );
			}else{
				$isExist = $this->_isEmailExist( $data['email'] );
				if( $isExist ){
					//_("Sorry,Email Exist.")
					throw new Exception( $translate->_("Email already exists") );
				}
			}
			
			if( $id ){
				$userModel->update( $data , array( "id" => $id ) );
			}
			
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
			$this->_plugin_datas['email'] 		= $data['email'];
			$this->_plugin_datas['name'] 		= $data['first_name'] . "." . $data['last_name'];
			$this->_plugin_datas['job_desc'] 	= $data['job_desc'];
			return $data;
			
		}
		
		private function _status( $id, $status ){
			
			$userModel = Narrow_User_Model_User::getInstance();
			$translate = Zend_Registry::get( 'translate');
			$user = $userModel->getOneByConditions( array( 'id' => $id ) );
			
			if( !$user ){
				throw new Exception( $translate->_("user do not exist") );
			}
			
			if( $user['email'] == Narrow::GetInstance()->config->user->default_admin->username ){
				throw new Exception( $translate->_("default administrator's status can't be changed") );
			}
			
			$userModel->update( array( "status" => $status ) , array( "id" => $id ) );
			
			//plugin_data
			
			$this->_plugin_datas['email'] 	= $user['email'];
			$this->_plugin_datas['status'] 	= $status;
			
		}
		
		private function _approve( $id ){
			
			$userModel = Narrow_User_Model_User::getInstance();
			
			$user = $userModel->getOneByConditions( array( "id" => $id ) );
			
			
			$code = $this->_generTempLoginCode();
			$userModel->update( array( "code" => $code , "status" => self::STATUS_APPROVAL ) , array( "id" => $id ) );
			
			//plugin_data
			$this->_plugin_datas['email'] 	= $user['email'];
			$this->_plugin_datas['name'] 	= $user['first_name'] . "." .  $user['last_name'];;
			$this->_plugin_datas['code']  	= $code;
			
		}
		
		private function _role( $id , $role ){
			
			$userModel = Narrow_User_Model_User::getInstance();
			
			$user = $userModel->getOneByConditions( array( 'id' => $id ) );
			
			if( !$user ){
				throw new Exception( $translate->_("user do not exist") );
			}
			
			if( $user['email'] == Narrow::GetInstance()->config->user->default_admin->username ){
				throw new Exception( $translate->_("default administrator's role can't be changed") );
			}
			
			$userModel->update( array( "role" => $role ) , array( "id" => $id ) );
			
			//plugin_data
			$this->_plugin_datas['email'] 	= $user['email'];
			$this->_plugin_datas['role'] 	= $role;
		
		}
		
		private function _generTempLoginCode( ){
			
			$code = md5( time() );
			return $code;
		}
		
		private function _isEmailExist( $email ){
			
			$userModel = Narrow_User_Model_User::getInstance();
			
			$user = $userModel->getOneByConditions( array( 'email' => $email ) , array( "id" ) );
			
			if( $user ){
				return true;
			}else{
				return false;
			}
			
		}
		
		private function _setSession( $doctor ){
			
			if( !$doctor ){
				$doctorStr = $doctor;
			}else{
				unset( $doctor['password'] );
				$doctorStr = serialize( $doctor );
			}
			
			WeFlex_Session::Set( self::SESSION_NAME_SPACE , $doctorStr );
			
		}
		
		private function _getSession(){
			
			$doctorStr = WeFlex_Session::Get( self::SESSION_NAME_SPACE );
			if( $doctorStr ){
				$doctor = unserialize( $doctorStr );
			}
			
			return $doctor;
			
		}

		
	}
?>