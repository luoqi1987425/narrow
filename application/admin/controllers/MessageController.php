<?php 
	class Admin_MessageController extends Narrow_ZendX_Controller_Action_Admin{
	
		
		const TITLE = 'user';
		
		
		public function indexAction(){
			
			$pageSize = 10;
			$pageNo	  = $this->paginationNo();
			$status	  = $this->_getParam( 'status' );
			if( !$status ){
				$status = 'all';
			}
			
			$messageMod = Narrow_Message_Factory::Factory();
			
			if( $status == 'approved' ){
				$conditions = array();
				$conditions['approved'] = Narrow_Message_Imple::STATUS_APPROVED;
			}elseif( $status == 'rejected' ){
				$conditions = array();
				$conditions['approved'] = Narrow_Message_Imple::STATUS_REJECTED;
			}else{
				$conditions = array();
				$conditions['approved'] = Narrow_Message_Imple::STATUS_WAITTING;
			}
			
			$messages = $messageMod->gets( $conditions , "date_add DESC" , $pageNo , $pageSize );
			$count	  = $messageMod->getsCount( $conditions );

			$paginationHTML = $this->pagination( $count , $pageSize );
			
			//if pageNum < 0 pagination will not be shown
	    	if( $count <= $pageSize ){
					$paginationHTML = '';
			}
			
			$this->assign( 'paginationHTML' , $paginationHTML );
			$this->assign( 'messages' , $messages );
			$this->assign( "status" , $status );
	    	$this->view->headTitle( $this->_( self::TITLE ) );
		}
		
		public function editAction(){
			
			$id = $this->_getParam( 'id' );
			
			$messageMod = Narrow_Message_Factory::Factory();
			
			$message   = $messageMod->getById( $id );
			
			$this->assign( 'message' , $message );
			
		}
		
		
		
		public function postsaveAction(){
			
			$data = array();
			$data['id'] 		= $this->_getParam( "id" );
			$data['content'] 	= $this->_getParam( "content" );
			
			$messageMod = Narrow_Message_Factory::Factory();
			
			$messageMod->save( $data );
			
			$this->redirect( 'index' , 'message' , 'admin' );
			
		}
		
		public function postdeleteAction(){
			
			$id 		= $this->_getParam( "id" );
			
			$messageMod = Narrow_Message_Factory::Factory();
			
			$messageMod->delete( $id );
			
			$this->redirect( 'index' , 'message' , 'admin' );
			
		}
		
		public function poststatusAction(){
			
			$id 		= $this->_getParam( "id" );
			$flag		= $this->_getParam( "approve" );
			
			$messageMod = Narrow_Message_Factory::Factory();
			
			$messageMod->approve( $id , $flag );
			
			$this->redirect( 'index' , 'message' , 'admin' );
			
		}
		
		
		
		
		
	}