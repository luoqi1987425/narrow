<?php 
	class Narrow_Plugins_Exts_Email extends Narrow_Plugins_Exts_Abstract{
		
		
		
		public function afterUserRegister( $data ){
			
			$emailMod = Narrow_Email_Factory::Factory();
			$userMod = Narrow_User_Factory::Factory();
			
			
			$admins = $userMod->gets( array( 'role' => Narrow_User_Imple::ROLE_ADMIN ) );
			
			$emailMod->register( $data['email'] , $data['name'] );
			$emailMod->registerForAdmin( $data['email'] , $admins , $data['name'] , $data['job_desc']  );
			
		}
		
		
		
		
		public function afterUserApprove( $data ){
			
			$emailMod = Narrow_Email_Factory::Factory();
			$emailMod->approve( $data['email'] , $data['name'] , $data['code'] );
			
		}
		
		
		
		public function afterMessageSave($data) {
			
			$emailMod = Narrow_Email_Factory::Factory();
			if( $data['approved'] == Narrow_Message_Imple::STATUS_WAITTING ){
				
				$emailMod->messageForAdmin( $data['content'] );
				
			}
			
		}
		
		
		
		
		
		
		
	}
?>