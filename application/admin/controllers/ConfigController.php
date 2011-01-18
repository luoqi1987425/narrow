<?php

class Admin_ConfigController extends Narrow_ZendX_Controller_Action_Admin
{
	//_('administrator - SMS')
	const TITLE = 'administrator - SMS';
	
	public function preDispatch() {
		parent::preDispatch();
	}

	
    public function indexAction(){
    	
    	$config = Narrow_Config_Factory::Factory();
    	
    	$messageNeedApproved = $config->get( Narrow_Config_Imple::MESSAGE_NEED_APPROVED );
    	
    	$this->assign( "message_need_approved" , $messageNeedApproved );
    	
    }
    
    public function postconfigAction(){
    	
    	$config = $this->_getParam( "config" );
    	$value  = $this->_getParam( "value" );
    	
    	$configMod = Narrow_Config_Factory::Factory();
    	
    	$configMod->set( $config , $value );
    	
    	$this->redirect( "index" , "config" , "admin" );
    	
    }
    
    
    
	


}

