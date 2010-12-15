<?php 
	class Narrow_Plugins_Exts_Email extends Narrow_Plugins_Event{
		
		
		
		public function afterUserRegister( $data ){
			
			$emailMod = Narrow_Email_Factory::Factory();
			
			$emailMod->register( $data['email'] , $data['name'] );
			$emailMod->registerForAdmin( $data['email'] , $data['name'] );
			
		}
		
		
		
		
		public function afterUserStatus( $data ){
			
			$emailMod = Narrow_Email_Factory::Factory();
			
			if( $data['status'] == Narrow_User::STATUS_APPROVAL && $data['code'] ){
				$emailMod->approve( $data['email'] , $data['code'] );
			}
			
		}
		
		
		
		
		
	}
?>