<?php

	class Narrow_ZendX_Controller_Action_Admin extends Narrow_ZendX_Controller_Action
	{
	    
	    public function preDispatch(){
	    	
	    	parent::preDispatch();
	    	$this->_appendBasicJs();
	    	$this->_checkAdminPermission();
	    	
	    	Narrow_Config_Factory::Factory()->init();
	    }
	    
		private function _appendBasicJs(){
	    	
			$this->appendJs('js/jquery-1.4.min.js');
			$this->appendJs('js/rocknoon/include.js');
	    	$this->appendJs('js/jquery.textlimit.js');
	    	
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