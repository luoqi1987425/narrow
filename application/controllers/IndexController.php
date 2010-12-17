<?php

class IndexController extends Narrow_ZendX_Controller_Action_Front
{
	
	const TITLE = "TV Mundipharma";

    public function indexAction()
    {
        $userMod = Narrow_User_Factory::Factory();
        
        $isLogin = $userMod->isLogined();
        
        if( $isLogin ){
        	$this->redirect( "message" , "index" , "default" );
        }else{
        	$this->redirect( "login" , "index" , "default" );
        }
    }
    
    public function loginAction(){
    	
    	
    	
    }
    
	public function registerAction(){
    	
    	
    	
    }
    
	public function passwordAction(){
    	
    	$code = $this->_getParam( 'code' );
    	
    	$userMod = Narrow_User_Factory::Factory();
    	
    	
    	if( $code ){
	    	try {
	    		$userMod->loginFromCode($code);
	    	}catch( Exception $ex ){
	    		$this->render( 'passworderror' );	
	    	}
	    	$this->assign( 'code' , $code );
    	} 
    	
    	
    	
    	
    	$this->view->headTitle( $this->_( self::TITLE ) );
    	
    }
    
    public function messageAction(){

    	
    }
    
	public function thanksAction(){

		$content  = $this->_getParam( "content" );
		
		$this->assign( "content" , $content );
    	
    }
    
    public function rssAction(){
    	
    	header('Content-type: application/xml;charset=UTF-8');
    	
    	$sign = $this->_getParam( "sign" );
    	
    	$messageMod = Narrow_Message_Factory::Factory();
    	
    	try{
    		$out = $messageMod->getsRssOutput($sign);
    	}catch(Exception $ex){
    		
    		$out = "<xml>".$ex->getMessage()."</xml>";
    		
    	}

    	echo $out;
    	
    	die();
    	
    }
    
	public function logoutAction(){
    	
    	$userMod = Narrow_User_Factory::Factory();
    	$userMod->logout();
    	
    	$this->redirect( 'login' , 'index' );
    	
    }
    
    public function postmessageAction(){
    	
    	$data = array();
    	
    	
    	
    	$messageMod = Narrow_Message_Factory::Factory();
    	$userMod 	= Narrow_User_Factory::Factory();
    	
    	$loginUser = $userMod->getLoginUser();
    	
    	$data['content'] = $this->_getParam( "content" );
    	$data['user_id'] = $loginUser['id'];
    	
    	
    	$messageMod->save( $data );
    	
    	$this->redirect( 'thanks' , 'index' , "default" , 
    	array( "content" => "Successfully submit message" ) );
    	
    }
    
	public function postloginAction(){
    	
    	$email	  =  $this->getRequest()->getParam( 'email' );
		$password =  $this->getRequest()->getParam( 'password' );
    	
		
       	$userMod = Narrow_User_Factory::Factory();
      	 
      	try {
      		$userMod->login( $email , $password );
      	}catch( Exception $ex ){
      		$this->assign( 'error' ,  $ex->getMessage());
      		$this->render( 'login' );
      		return;
      	}
      	
 
      	
      	
      	$this->redirect( 'message' , 'index'  );
    	
    }
    
	public function postregisterAction(){
    	
    	$user =  Narrow_User_Factory::Factory();
    	
    	
    	$data = array();
    	$data['email'] = $this->_getParam( 'email' );
    	$data['first_name'] = $this->_getParam( 'first_name' );
    	$data['last_name'] = $this->_getParam( 'last_name' );
    	$data['job_desc'] = $this->_getParam( 'job_desc' );
    	
    	$user->register( $data );
    	
    	$this->redirect( 'thanks' , 'index' , "default" , 
    	array( "content" => "Thanks for your register. and we will have a approval work for your apply. if your information is approved, we will use email to notice you." ) );
    	
    }
    
	public function postchangepasswordAction(){
    	
    	$user =  Narrow_User_Factory::Factory();
    	
    	
    	$code 		= $this->_getParam( "code" );
    	$password 	= $this->_getParam( "password" );
    	
    	$user->changeLoginUserPassword( $password , $code );
    	
    	$this->redirect( 'thanks' , 'index' , "default" , 
    	array( "content" => "successfully change your password" ) );
    	
    }


}

