<?php 
	class Narrow_Email_Imple implements Narrow_Email_Interface{
	
	
		public function approve($email, $name , $code) {
			
			$title = "TV Mundipharma";
			$content = $this->_generateApprovelContent( $name , $code);
			$this->_send( $email ,$title , $content );
			
		}
		
		
		public function register($email, $name) {
			
			$title = "TV Mundipharma";
			$content = $this->_generateRegisterContent($name );
			$this->_send( $email ,$title , $content );
			
		}
		
		
		public function registerForAdmin( $email , $admins , $name , $job_desc ) {
			
			
			$content = $this->_generateAdminSendContent( $email , $name  , $job_desc  );
			
			$title = "TV Mundipharma";
			
			foreach( $admins as $admin ){
				$this->_send( $admin['email'] ,$title , $content );
			}
			
		}
	
	
		public function messageForAdmin($content) {
			
			$title = "TV Mundipharma";
			$content = $this->_generateMessageForAdminContent( $content );
			$email   = Narrow::GetInstance()->config->email->message_email;
		
			$this->_send( $email ,$title , $content );
			
		}

		
		private function _generateRegisterContent( $name ){
			
			return "Beste ".$name.",<br/><br/>

			Bedankt voor uw aanvraag om lid te worden van de Mundipharma community. Omdat de community alleen toegankelijk is voor artsen wordt uw aanvraag eerst door ons beoordeeld. U ontvangt binnenkort van ons een e-mail bericht.
			<br/><br/>
			Bedankt,
			<br/><br/>
			TV Mundipharma";
			
		}
		
		private function _generateAdminSendContent( $email , $name , $job_desc  ){
			
			
			$url = WeFlex_Util::GetFullUrl( array( "action" => "index" , "controller" => "index" ,  "module" => "admin" ) , "default" );
			
			return "Beste,<br/><br/>

			A new user has registered on the Mundipharma doctor site and is requesting approval to join. Please login to the admin console and confirm or deny.<br/><br/>
			
			User Email: ".$email."<br/>
			User Name: ".$name."<br/>
			User Job Description: ".$job_desc."<br/>
			<br/>
			<a href='$url' target='_blank'>Go here to approve this user.</a>
			<br/><br/>
			Bedankt,
			<br/><br/>
			TV Mundipharma";
			
		}
		
		
		private function _generateApprovelContent( $name ,  $code ){
			
			$url = WeFlex_Util::GetFullUrl( array( "action" => "password" , "controller" => "index" , "code" => $code ) , "default" );
			
			$content = 'Beste '.$name.',<br/><br/>
						U aanvraag is goedgekeurd en u bent nu lid van de Mundipharma community. U kunt direct inloggen en gebruik maken van de community.
						<br/><br/>
						U kunt hier inloggen (indien de link niet werkt, dan kunt u deze kopiëren in uw browser): <a href="'.$url.'" target="_blank">click here to active your account and log in</a>
						<br/><br/>
						U kunt uw wachtwoord wijzigen na de eerste keer dat u inlogt.
						<br/><br/>
						Bedankt,
						<br/><br/>
						TV Mundipharma';
			
			return $content;
			
		}
		
		private function _generateMessageForAdminContent( $content ){
			
			$rtn = 'Mundipharma Administrator,
					<br/><br/>
					You have a message waitting for approval:
					<br/><br/>
					'.$content.' TV Mundipharma
					<br/><br/>
					You can approve this message here: <a href="http://tv.mundipharma.nl/admin/message">http://tv.mundipharma.nl/admin/message</a>';
			
			return $rtn;
			
		}
		
		private function _send( $to , $title , $message ){
			
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
			$headers .= 'From: info@mundipharma.nl' . "\r\n" . 'Reply-To: info@mundipharma.nl' . "\r\n";
			
			
			@mail(	$to , 
					$title,
					$message,
					$headers );
			
		}
		
		


		
	}
?>