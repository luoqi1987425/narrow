<?php

	class Narrow_ZendX_Controller_Action_Front extends Narrow_ZendX_Controller_Action
	{
	    
	    public function preDispatch(){
	    	parent::preDispatch();
	    	$this->_appendBasicJs();
	    }
	    
	    
	    
	    private function _appendBasicJs(){
	    	
			$this->appendJs('js/jquery-1.4.min.js');
			$this->appendJs('js/rocknoon/include.js');
//	    	$this->appendJs('js/sms/ajax.js');
//	    	$this->appendJs('js/sms/twitter.js');
	    }
	   
	   
	    
	    
	}
?>