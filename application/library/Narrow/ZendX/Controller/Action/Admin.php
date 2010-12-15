<?php

	class Narrow_ZendX_Controller_Action_Admin extends Narrow_ZendX_Controller_Action
	{
	    
	    public function preDispatch(){
	    	
	    	parent::preDispatch();
	    	
	    	$this->_checkAdminPermission();
	    }
	

	    private function _checkAdminPermission(){
	    	
	    	if( $this->_request->getActionName() != 'login' && $this->_request->getControllerName() != 'index' &&  $this->_request->getActionName() != 'uploadimage' ){
	    		$adminMod = Finest_Admin_Factory::Factory();
				$isLogined = $adminMod->isLogined();
				if( !$isLogined ){
					$this->_helper->redirector->gotoSimple('login', 'index' , 'admin');
				}
	    	}
	    	
	    }
	    
	    
	}
?>