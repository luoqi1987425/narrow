<?php 
	class Narrow_Message_Imple implements Narrow_Message_Interface {
	
	
		public function delete($id) {
			
			$messageModel = Narrow_Message_Model_Message::getInstance();
			
			$messageModel->delete( array( "id" => $id ) );
		}
		
	
		public function getsRssOutput( $sign ) {
			
			$translate = Zend_Registry::get( 'translate');
			
			$right_sign	= Narrow::GetInstance()->config->message->rss_sign;
			
			if( $right_sign != $sign  ){
				throw new Exception( $translate->_("sorry you can't get messages, because the signiture is not right") ); 
			}
			
			
			$userMod = Narrow_User_Factory::Factory();
			
			$conditions = array();
			$conditions['date_add'] = array( "min" , time() - (3600 * 24)  );
			
			$order = "date_add DESC";
			
			$messages =  $this->gets( $conditions , $order , 1 , 10 );
			
			

			/**
			  * Create the parent feed
			  */
			$currentLink = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
			
			$feed = new Zend_Feed_Writer_Feed();
			
			$feed->setTitle('TV Mundipharma');
			$feed->setLink($currentLink);
			$feed->setFeedLink($currentLink, 'rss');
			$feed->addAuthor(array(
			    'name'  => 'mundipharma',
			    'email' => 'admin@mundipharma.nl',
			    'uri'   => $currentLink,
			));
			$feed->setDateModified(time());
			$feed->addHub('http://pubsubhubbub.appspot.com/');
			$feed->setDescription( "TV Mundipharma" );
			 
			/**
			 * Add one or more entries. Note that entries must
			 * be manually added once created.
			 */
			foreach( $messages as $message ){
				
				$user = $userMod->getById( $message['user_id'] );
				$userName = $user['first_name'] . " " . $user['last_name'];
				
				$entry = $feed->createEntry();
				$entry->setTitle($message['content']);
				$entry->setLink($currentLink);
				$entry->addAuthor(array(
				    'name'  => $userName,
				    'email' => $user["email"],
				    'uri'   => $currentLink,
					));
				$entry->setId($message['id']);
				$entry->setDateModified	($message['date_add']);
				$entry->setDateCreated	($message['date_add']);
				$entry->setDescription( $user['first_name'] . ": " . $message['content']);
				$entry->setContent(
			    	$userName . ":" . $message['content']
				);
				$feed->addEntry($entry);
				
				
			}
			
			 
			/**
			* Render the resulting feed to Atom 1.0 and assign to $out.
			* You can substitute "atom" with "rss" to generate an RSS 2.0 feed.
			*/
			$out = $feed->export('rss');
			
			return $out;
		}
		
		public function save( $data ) {
			
			$messageModel = Narrow_Message_Model_Message::getInstance();
			
			$id = $data['id'];
			unset($data['id']);
			
			if(!$id){
				
				$data['date_add'] = time();
				$messageModel->insert($data);
			}else{
				$messageModel->update( $data , array( "id" => $id ) );
			}
			
			return $id;
			
		}
	
	
		public function getById($id) {
			
			$messageModel = Narrow_Message_Model_Message::getInstance();
			
			$message = $messageModel->getOneByConditions( array( "id" => $id ) );
			
			$rtn = new Narrow_Message_Entity_Message( $message );
			
			return $rtn;
		}

		
		
		public function gets( $conditons = null , $order = null , $pageNo = null , $pageSize = null ) {
			
			$messageModel = Narrow_Message_Model_Message::getInstance();
			
			$datas 	= $messageModel->getAllByConditions( $conditons, $order, $pageNo , $pageSize);
			$rtn 	= array();
			
			foreach( $datas as $data ){
				$rtn []= new Narrow_Message_Entity_Message( $data );
			}
			
			return $rtn;
			
		}
		
		public function getsCount( $conditons = null ){
			
			$userModel = Narrow_User_Model_User::getInstance();
			return $userModel->where( $conditons )->count();
		}
		
		

		
	}
?>