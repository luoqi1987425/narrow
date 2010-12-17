<?php 
	class Narrow_Plugins_Exts_Email extends Narrow_Plugins_Exts_Abstract{
		
		
		
		public function afterUserRegister( $data ){
			
			$emailMod = Narrow_Email_Factory::Factory();
			$userMod = Narrow_User_Factory::Factory();
			
			
			$admins = $userMod->gets( array( 'role' => Narrow_User_Imple::ROLE_ADMIN ) );
			
			$emailMod->register( $data['email'] , $data['name'] );
			$emailMod->registerForAdmin( $admins , $data['name'] , $data['occupation'] , $data['place_of_work'] );
			
		}
		
		
		
		
		public function afterUserApprove( $data ){
			
			$emailMod = Narrow_Email_Factory::Factory();
			$emailMod->approve( $data['email'] , $data['name'] , $data['code'] );
			
		}
		
		
		
		
		
	}
?>