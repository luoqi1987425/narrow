<?php

	class Narrow_ZendX_Controller_Action_Admin extends Narrow_ZendX_Controller_Action
	{
	    
	    public function preDispatch(){
	    	
	    	parent::preDispatch();
	    	
	    	$this->_checkAdminPermission();
	    }
	

	    private function _checkAdminPermission(){
	    	
	    	if(  $this->_request->getActionName() != 'uploadimage' ){
	    		$userMod = Narrow_User_Factory::Factory();
				$isLogined = $userMod->isLogined();
				
				if( !$isLogined ){
					$this->_helper->redirector->gotoSimple('index', 'index' , 'default');
					return;
				}
				
				$user = $userMod->getLoginUser();
				
				if( $user['role'] != Narrow_User_Imple::ROLE_ADMIN ){
					$this->_helper->redirector->gotoSimple('index', 'index' , 'default');
					return;
				}
	    	}
	    	
	    }
	    
	    
	}
?>