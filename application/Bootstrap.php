<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

/**
	 * @var Zend_Controller_Front
	 */
	protected $_front;

	
	protected function _initFront(){
		$this->bootstrap('frontController');
		$this->_front = $this->getResource('frontController');
	}
	
	protected function _initView(){
		
		$view = new Zend_View();
		
		$view->setEncoding( 'UTF-8' );
		$view->doctype( Zend_View_Helper_Doctype::XHTML11 );
		
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
		
		Zend_Registry::set( 'view' , $view );
	}
	

	protected function _initWfAjax(){
    	
    	$wfAjax = new WeFlex_ZendX_Controller_Action_Helper_WfAjax();
    	Zend_Controller_Action_HelperBroker::addHelper( $wfAjax );
    	
    	return $wfAjax;
    	
    }
    
	protected function _initControllers()
    {
    	$this->_front->addControllerDirectory(APPLICATION_PATH . '/admin/controllers', 'admin');
    }
    
    
	protected function _initFakeTranslate(){
		
		$view = Zend_Registry::get( 'view' );
		
		$translate = new WeFlex_ZendX_FakeTranslator();
		$translateHelper = new WeFlex_ZendX_View_Helper_Translate( $translate );
		$view->registerHelper( $translateHelper , '_' );
		
		Zend_Registry::set( 'translate' , $translate );
    }
    
    
    
    
	protected function _initRouter(){
		
		

	}
	
	protected function _initCache(){
		
		if( $this->_options['cache'] ){
			$caching = true;
		}else{
			$caching = false;
		}
		
		$frontendOptions = array(
		   'caching' => $caching,
		   'lifetime' => 3600, // cache lifetime of 2 hours
		   'automatic_serialization' => true
		);
		 
		$backendOptions = array(
		    'cache_dir' => realpath(APPLICATION_PATH . '/../cache') // Directory where to put the cache files
		);
		 
		// getting a Zend_Cache_Core object
		$cache = Zend_Cache::factory('Core',
		                             'File',
		                             $frontendOptions,
		                             $backendOptions);             
		                       
		                             
		Zend_Registry::set( 'cache' , $cache );
		
		
	}

}
