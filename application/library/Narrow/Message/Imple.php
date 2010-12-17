<?php 
	class Narrow_Message_Imple implements Narrow_Message_Interface {
	
	
		public function delete($id) {
			
			$messageModel = Narrow_Message_Model_Message::getInstance();
			
			$messageModel->delete( array( "id" => $id ) );
		}
		
	
		public function getsRssOutput( $sign ) {
			
			$right_sign	= Narrow::GetInstance()->config->message->rss_sign;
			
			if( $right_sign != $sign  ){
				throw new Exception( "sorry you can't get messages, because the signiture is not right" ); 
			}
			
			$conditions = array();
			$conditions['date_add'] = array( "min" , time() - (3600 * 24)  );
			
			$order = "date_add DESC";
			
			$messages =  $this->gets( $conditions , $order , 1 , 10 );

			/**
			  * Create the parent feed
			  */
			$feed = new Zend_Feed_Writer_Feed();
			
			$feed->setTitle('Rocky\'s Blog');
			$feed->setLink('http://www.rocknnon.com');
			$feed->setFeedLink('http://www.rocknnon.com/rss', 'rss');
			$feed->addAuthor(array(
			    'name'  => 'Paddy',
			    'email' => 'paddy@example.com',
			    'uri'   => 'http://www.example.com',
			));
			$feed->setDateModified(time());
			$feed->addHub('http://pubsubhubbub.appspot.com/');
			$feed->setDescription( "hello" );
			 
			/**
			 * Add one or more entries. Note that entries must
			 * be manually added once created.
			 */
			foreach( $messages as $message ){
				
				$entry = $feed->createEntry();
				$entry->setTitle('TV Mun');
				$entry->setLink('http://www.example.com/all-your-base-are-belong-to-us');
				$entry->addAuthor(array(
				    'name'  => 'Rocky',
				    'email' => 'luoqi.rocky@gmail.com',
				    'uri'   => 'http://www.rocknoon.com',
					));
				$entry->setDateModified	($message['date_add']);
				$entry->setDateCreated	($message['date_add']);
				$entry->setDescription($message['content']);
				$entry->setContent(
			    	$message['content']
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