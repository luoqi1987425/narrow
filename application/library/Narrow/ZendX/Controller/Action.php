<?php
	class Narrow_ZendX_Controller_Action extends WeFlex_ZendX_Controller_Action
	{
		function preDispatch(){
			parent::preDispatch();
			$this->_initLang();
			
		}
		
		protected function _initLang(){
			
			$translate = Zend_Registry::get( 'translate');
			
			$lang_config = array_keys(WeFlex_Application::GetInstance()->getLangs());
			
			if($this->getRequest()->getParam('lang') && in_array($this->getRequest()->getParam('lang'), $lang_config)){  
				@$translate->setLocale( $this->getRequest()->getParam('lang') );
				@setcookie('lang', $this->getRequest()->getParam('lang'), time() + 9999999, '/');
			}else if($_COOKIE['lang'] && in_array($_COOKIE['lang'], $lang_config)) {
				 //cookie
				@$translate->setLocale($_COOKIE['lang']);
			}        
			else if(in_array($translate->getLocale(), $lang_config)){
				//browers
				@setcookie('lang', $translate->getLocale(), time() + 9999999, '/');
			}   
			else{ 
				//first of list                                                             
				@$translate->setLocale(WeFlex_Application::GetInstance()->getDefaultLang());
				@setcookie('lang', $translate->getLocale(), time() + 9999999, '/');
			}
			
			
			//sepcify the grobal variable for lang
			$this->_setParam( 'lang'   , $translate->getLocale() );
			Zend_Registry::set('lang' ,  "nl_NL" );
		}

	}
?>