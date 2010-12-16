<?php 
	class Narrow_User_Entity_User extends WeFlex_Entity 
	{
		
		protected function _getOffset( $offset ){
		  	
		  	switch( $offset ){
					
				case 'status_name':
					
					if(  $this->_coll['status'] == Narrow_User_Imple::STATUS_WAITING ){
						return "Waiting";
					}
					elseif(  $this->_coll['status'] == Narrow_User_Imple::STATUS_APPROVAL  ){
						return "Approved";
					}
					elseif(  $this->_coll['status'] == Narrow_User_Imple::STATUS_REJECTED  ){
						return "Rejected";
					}
					break;
						
				case 'role_name':
					
					if(  $this->_coll['role'] == Narrow_User_Imple::ROLE_ADMIN ){
						return "Admin";
					}elseif(  $this->_coll['role'] == Narrow_User_Imple::ROLE_USER  ){
						return "Default";
					}
					break;
					
					
								
			}
			
			return parent::_getOffset( $offset );
		  }
		
	}