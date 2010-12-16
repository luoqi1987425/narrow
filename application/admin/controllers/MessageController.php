<?php 
	class Admin_MessageController extends Narrow_ZendX_Controller_Action_Admin{
	
		
		const TITLE = 'user';
		
		
		public function indexAction(){
			
			$pageSize = 10;
			$pageNo	  = $this->paginationNo();
			
			$messageMod = Narrow_Message_Factory::Factory();
			
			$messages = $messageMod->gets( array() , "date_add DESC" , $pageNo , $pageSize );
			$count	  = $messageMod->getsCount( array() );

			$paginationHTML = $this->pagination( $count , $pageSize );
			
			//if pageNum < 0 pagination will not be shown
	    	if( $count <= $pageSize ){
					$paginationHTML = '';
			}
			
			$this->assign( 'paginationHTML' , $paginationHTML );
			$this->assign( 'messages' , $messages );
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
		
		
		
		
		
	}