<?php 
	class Narrow_Message implements Narrow_Message_Interface {
	
	
		public function delete($id) {
			
			$messageModel = Narrow_Message_Model_Message::getInstance();
			
			$messageModel->delete( array( "id" => $id ) );
		}
		
	
		public function getsForRss() {
			
			$conditions = array();
			$conditions['date_add'] = array( "min" , time() - (3600 * 24)  );
			
			$order = "date_add DESC";
			
			return $this->gets( $conditions , $order , 1 , 10 );
		}
		
		public function save( $data ) {
			
			$messageModel = Narrow_Message_Model_Message::getInstance();
			
			
			$id = $data['id'];
			unset($data['id']);
			
			if($id){
				$data['date_add'] = time();
				$messageModel->insert($data);
			}else{
				$messageModel->update( $data , array( "id" => $id ) );
			}
			
			return $id;
			
		}
		
		
		public function gets( $conditons = null , $order = null , $pageNo = null , $pageSize = null ) {
			
			$messageModel = Narrow_Message_Model_Message::getInstance();
			
			$datas 	= $messageModel->getAllByConditions( $conditons, $order, $pageNo , $pageSize);
			$rtn 	= array();
			
			foreach( $datas as $data ){
				$rtn []= new Narrow_User_Entity_User( $data );
			}
			
			return $rtn;
			
		}
		
		public function getsCount( $conditons = null ){
			
			$userModel = Narrow_User_Model_User::getInstance();
			return $userModel->where( $conditons )->count();
		}

		
	}
?>