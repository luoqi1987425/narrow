<?php 
	class Admin_UserController extends Narrow_ZendX_Controller_Action_Admin{
	
		
		const TITLE = 'user';
		
		
		public function indexAction(){
			
			$pageSize = 10;
			$pageNo	  = $this->paginationNo();
			$stauts	  = $this->_getParam( 'status' );
			
			
			$userMod = Narrow_User_Factory::Factory();
			
			$users = $userMod->getsByStatus( $stauts , 'date_add DESC' , $pageNo , $pageSize );
			$count = $userMod->getsByStatusCount( $stauts );
			
		

			$paginationHTML = $this->pagination( $count , $pageSize );
			
			//if pageNum < 0 pagination will not be shown
	    	if( $count <= $pageSize ){
					$paginationHTML = '';
			}
			
			$this->assign( 'paginationHTML' , $paginationHTML );
			$this->assign( 'users' , $users );
			$this->assign( 'status' , $stauts );
	    	$this->view->headTitle( $this->_( self::TITLE ) );
		}
		
		public function viewAction(){
			
			$id = $this->_getParam( 'id' );
			
			$userMod = Narrow_User_Factory::Factory();
			
			$user   = $userMod->getById( $id );
			
			$this->assign( 'user' , $user );
			
		}
		
		
		
		public function postrejectAction(){
			
			$id = $this->_getParam( 'id' );
			
			$userMod = Narrow_User_Factory::Factory();
			
			$userMod->status( $id , Narrow_User_Imple::STATUS_REJECTED );
			
			$this->redirect( 'index' , 'doctor' , 'admin' , array( 'status' => Narrow_User_Imple::STATUS_WAITING ) );
			
		}
		
		public function postapproveAction(){

			$id 	= $this->_getParam( 'id' );
			$role 	= $this->_getParam( 'role' );
			
			$userMod = Narrow_User_Factory::Factory();
			$userMod->approve( $id );
			$userMod->role( $id , $role );
			
			$this->redirect( 'index' , 'user' , 'admin' , array( 'status' => Narrow_User_Imple::STATUS_WAITING ) );
			
		}
		
		public function poststatusAction(){

			$id 		= $this->_getParam( 'id' );
			$status 	= $this->_getParam( 'status' );
			
			$userMod = Narrow_User_Factory::Factory();
			$userMod->status( $id , $status );
			
			$this->redirect( 'index' , 'user' , 'admin' , array( 'status' => Narrow_User_Imple::STATUS_WAITING ) );
			
		}
		
		public function postroleAction(){
			
			$id 	= $this->_getParam( 'id' );
			$role 	= $this->_getParam( 'role' );
			
			$userMod = Narrow_User_Factory::Factory();
			
			$userMod->role( $id , $role );
			
			$this->redirect( 'index' , 'user' , 'admin' , array( 'status' => Narrow_User_Imple::STATUS_APPROVAL ) );
			
		}
		
		
		
		
		
	}