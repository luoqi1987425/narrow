<?php

class AjaxController extends Narrow_ZendX_Controller_Action_Front
{
    
    public function emailexistAction(){
		
    	$email = $this->_getParam( "email" );
    	
    	$userMod =  Narrow_User_Factory::Factory();
    	$isExist = $userMod->isEmailExist( $email );
    	
    	$this->success( intval( $isExist ) );
    	
    }


}

