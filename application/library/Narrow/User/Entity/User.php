<?php 
	class Narrow_User_Entity_User extends WeFlex_Entity 
	{
		
		protected function _getOffset( $offset ){
		  	
			$translate 	= Zend_Registry::get( 'translate');
			
		  	switch( $offset ){
					
				case 'status_name':
					
					if(  $this->_coll['status'] == Narrow_User_Imple::STATUS_WAITING ){
						return $translate->_("Waiting");
					}
					elseif(  $this->_coll['status'] == Narrow_User_Imple::STATUS_APPROVAL  ){
						return $translate->_("Approved");
					}
					elseif(  $this->_coll['status'] == Narrow_User_Imple::STATUS_REJECTED  ){
						return $translate->_("Rejected");
					}
					break;
						
				case 'role_name':
					
					if(  $this->_coll['role'] == Narrow_User_Imple::ROLE_ADMIN ){
						return $translate->_("Admin");
					}elseif(  $this->_coll['role'] == Narrow_User_Imple::ROLE_USER  ){
						return $translate->_("Default");
					}
					break;
					
					
								
			}
			
			return parent::_getOffset( $offset );
		  }
		
	}